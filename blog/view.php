<?php

declare(strict_types=1);

require_once '../includes/header.php';
require_once '../includes/navbar.php';
require_once '../config/database.php';
require_once '../includes/markdown.php';

$id = (int)($_GET['id'] ?? 0);

$stmt = $conn->prepare("
SELECT
    blogPost.*,
    user.username
FROM blogPost
INNER JOIN user
ON blogPost.user_id = user.id
WHERE blogPost.id = ?
");

$stmt->bind_param("i", $id);

$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows === 0) {

    echo "<h2>Article not found.</h2>";

    require_once '../includes/footer.php';

    exit;
}

$blog = $result->fetch_assoc();
?>

<main class="article-container">

    <article class="article">

        <h1>

            <?= htmlspecialchars($blog['title']) ?>

        </h1>

        <div class="article-meta">

            By

            <strong>

                <?= htmlspecialchars($blog['username']) ?>

            </strong>

            •

            <?= date(
                "F d, Y",
                strtotime($blog['created_at'])
            ) ?>

        </div>

        <div class="article-content">

            <?= markdownToHtml($blog['content']) ?>

        </div>

        <a href="/lights-out/" class="back-link">

            ← Back to Articles

        </a>

    </article>

</main>

<?php
require_once '../includes/footer.php';