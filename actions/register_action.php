<?php

declare(strict_types=1);

require_once '../config/database.php';
require_once '../includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('../auth/register.php');
}

// Get form data
$username = sanitizeInput($_POST['username'] ?? '');
$email = sanitizeInput($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$confirmPassword = $_POST['confirm_password'] ?? '';

// Validation
if (
    empty($username) ||
    empty($email) ||
    empty($password) ||
    empty($confirmPassword)
) {
    setError('All fields are required.');
    redirect('../auth/register.php');
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    setError('Invalid email address.');
    redirect('../auth/register.php');
}

if (strlen($password) < 8) {
    setError('Password must be at least 8 characters.');
    redirect('../auth/register.php');
}

if ($password !== $confirmPassword) {
    setError('Passwords do not match.');
    redirect('../auth/register.php');
}

// Check if email already exists
$stmt = $conn->prepare("SELECT id FROM user WHERE email = ?");

if (!$stmt) {
    die("Prepare Error: " . $conn->error);
}

$stmt->bind_param("s", $email);

if (!$stmt->execute()) {
    die("Execute Error: " . $stmt->error);
}

$stmt->store_result();

if ($stmt->num_rows > 0) {
    $stmt->close();

    setError("Email already exists.");
    redirect("../auth/register.php");
}

$stmt->close();

// Hash password
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

$role = "user";

// Insert user
$stmt = $conn->prepare("
    INSERT INTO user (username, email, password, role)
    VALUES (?, ?, ?, ?)
");

if (!$stmt) {
    die("Prepare Error: " . $conn->error);
}

$stmt->bind_param(
    "ssss",
    $username,
    $email,
    $hashedPassword,
    $role
);

if (!$stmt->execute()) {
    die("Insert Error: " . $stmt->error);
}

$stmt->close();

echo "Registration Successful!";
exit;