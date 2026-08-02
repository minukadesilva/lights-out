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
    redirect('blog/create.php');
}

$title = sanitizeInput($_POST['title'] ?? '');
$content = trim($_POST['content'] ?? '');

if (empty($title) || empty($content)) {

    setError("Title and content are required.");
    redirect("blog/create.php");

}

$stmt = $conn->prepare("
    INSERT INTO blogPost
    (user_id,title,content)
    VALUES
    (?,?,?)
");

if (!$stmt) {
    die($conn->error);
}

$userId = $_SESSION['user']['id'];

$stmt->bind_param(
    "iss",
    $userId,
    $title,
    $content
);

if (!$stmt->execute()) {
    die($stmt->error);
}

$stmt->close();

setSuccess("Article published successfully.");

redirect("dashboard.php");