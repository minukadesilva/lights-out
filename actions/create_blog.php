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

/*
|--------------------------------------------------------------------------
| Handle Cover Image Upload
|--------------------------------------------------------------------------
*/

$coverImage = "default.jpg";

if (
    isset($_FILES['cover_image']) &&
    $_FILES['cover_image']['error'] === UPLOAD_ERR_OK
) {

    $allowedTypes = ['jpg', 'jpeg', 'png', 'webp'];

    $extension = strtolower(
        pathinfo(
            $_FILES['cover_image']['name'],
            PATHINFO_EXTENSION
        )
    );

    if (in_array($extension, $allowedTypes)) {

        $coverImage = uniqid("cover_", true) . "." . $extension;

        move_uploaded_file(
            $_FILES['cover_image']['tmp_name'],
            "../uploads/" . $coverImage
        );

    }
}

/*
|--------------------------------------------------------------------------
| Insert Blog
|--------------------------------------------------------------------------
*/

$stmt = $conn->prepare("
    INSERT INTO blogPost
    (user_id, title, content, cover_image)
    VALUES
    (?, ?, ?, ?)
");

if (!$stmt) {
    die($conn->error);
}

$userId = $_SESSION['user']['id'];

$stmt->bind_param(
    "isss",
    $userId,
    $title,
    $content,
    $coverImage
);

if (!$stmt->execute()) {
    die($stmt->error);
}

$stmt->close();

setSuccess("Article published successfully.");

redirect("dashboard.php");