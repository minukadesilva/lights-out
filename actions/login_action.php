<?php

declare(strict_types=1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once '../config/database.php';
require_once '../includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('../auth/login.php');
}

$email = sanitizeInput($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

if (empty($email) || empty($password)) {
    setError('Please fill in all fields.');
    redirect('../auth/login.php');
}

$stmt = $conn->prepare("
    SELECT id, username, email, password, role
    FROM user
    WHERE email = ?
");

if (!$stmt) {
    die("Prepare Error: " . $conn->error);
}

$stmt->bind_param("s", $email);

if (!$stmt->execute()) {
    die("Execute Error: " . $stmt->error);
}

$stmt->store_result();

if ($stmt->num_rows === 0) {
    setError("Invalid email or password.");
    redirect("../auth/login.php");
}

$stmt->bind_result(
    $id,
    $username,
    $userEmail,
    $hashedPassword,
    $role
);

$stmt->fetch();

if (!password_verify($password, $hashedPassword)) {
    setError("Invalid email or password.");
    redirect("../auth/login.php");
}


$_SESSION['user'] = [
    'id' => $id,
    'username' => $username,
    'email' => $userEmail,
    'role' => $role
];

$stmt->close();

header("Location: /lights-out/dashboard.php");
exit;