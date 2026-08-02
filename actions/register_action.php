<?php

declare(strict_types=1);

require_once '../config/database.php';
require_once '../includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('../auth/register.php');
}

$username = sanitizeInput($_POST['username'] ?? '');
$email = sanitizeInput($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$confirmPassword = $_POST['confirm_password'] ?? '';

/*
|--------------------------------------------------------------------------
| Validation
|--------------------------------------------------------------------------
*/

if (
    empty($username) ||
    empty($email) ||
    empty($password) ||
    empty($confirmPassword)
) {
    die('All fields are required.');
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die('Invalid email address.');
}

if (strlen($password) < 8) {
    die('Password must be at least 8 characters.');
}

if ($password !== $confirmPassword) {
    die('Passwords do not match.');
}

/*
|--------------------------------------------------------------------------
| Check Duplicate Email
|--------------------------------------------------------------------------
*/

$stmt = $conn->prepare(
    "SELECT id FROM user WHERE email = ?"
);

$stmt->bind_param("s", $email);

$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows > 0) {
    die('Email already exists.');
}

/*
|--------------------------------------------------------------------------
| Hash Password
|--------------------------------------------------------------------------
*/

$hashedPassword = password_hash(
    $password,
    PASSWORD_DEFAULT
);

/*
|--------------------------------------------------------------------------
| Insert User
|--------------------------------------------------------------------------
*/

$role = "user";

$stmt = $conn->prepare(
    "INSERT INTO user
    (username,email,password,role)
    VALUES
    (?,?,?,?)"
);

$stmt->bind_param(
    "ssss",
    $username,
    $email,
    $hashedPassword,
    $role
);

$stmt->execute();

/*
|--------------------------------------------------------------------------
| Redirect
|--------------------------------------------------------------------------
*/

redirect("../auth/login.php");