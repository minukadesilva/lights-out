<?php

declare(strict_types=1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once '../config/database.php';
require_once '../includes/functions.php';

if (!isset($_SESSION['user'])) {
    redirect('auth/login.php');
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('dashboard.php');
}

$id = (int)($_POST['id'] ?? 0);

$userId = $_SESSION['user']['id'];

$stmt = $conn->prepare("
    DELETE FROM blogPost
    WHERE
        id = ?
    AND
        user_id = ?
");

if (!$stmt) {
    die($conn->error);
}

$stmt->bind_param(
    "ii",
    $id,
    $userId
);

if (!$stmt->execute()) {
    die($stmt->error);
}

$stmt->close();

setSuccess("Article deleted successfully.");

redirect("");