<?php

declare(strict_types=1);

require_once '../includes/header.php';
require_once '../includes/navbar.php';
require_once '../config/database.php';
require_once '../includes/markdown.php';

$id = (int) ($_GET['id'] ?? 0);

$stmt = $conn->prepare("
    SELECT
        blogPost.*,
        user.username
    FROM blogPost
    INNER JOIN user
        ON blogPost.user_id = user.id
    WHERE blogPost.id = ?
");

if (!$stmt) {
    die("Prepare Error: " . $conn->error);
}

$stmt->bind_param("i", $id);

if (!$stmt->execute()) {
    die("Execute Error: " . $stmt->error);
}

$result = $stmt->get_result();

if ($result->num_rows === 0) {

    require_once '../includes/header.php';

    echo '
    <main class="container">
        <h2>Article not found.</h2>
        <a href="/lights-out/" class="back-link">
            ← Back to Articles
        </a>
    </main>';

    require_once '../includes/footer.php';
    exit;
}

$blog = $result->fetch_assoc();

$stmt->close();
?>

<main class="article-container">

    <article class="article">

        <h1>
            <?= htmlspecialchars($blog['title']) ?>
        </h1>

        <div class="article-meta">

            <span>
                👤
                <strong><?= htmlspecialchars($blog['username']) ?></strong>
            </span>

            <span>
                📅
                <?= date("F d, Y", strtotime($blog['created_at'])) ?>
            </span>

            <?php if ($blog['updated_at'] !== $blog['created_at']) : ?>

                <span>
                    • Updated
                    <?= date("F d, Y", strtotime($blog['updated_at'])) ?>
                </span>

            <?php endif; ?>

        </div>

        <div class="article-content">

            <?= markdownToHtml($blog['content']) ?>

        </div>
        

        <?php if (
            isset($_SESSION['user']) &&
            $_SESSION['user']['id'] == $blog['user_id']
        ) : ?>

            <div class="article-actions">

                <a
                    href="edit.php?id=<?= $blog['id'] ?>"
                    class="btn">

                    ✏ Edit Article

                </a>

                <form
                    action="../actions/delete_blog.php"
                    method="POST"
                    onsubmit="return confirm('Are you sure you want to delete this article?');">

                    <input
                        type="hidden"
                        name="id"
                        value="<?= $blog['id'] ?>">

                    <button
                        type="submit"
                        class="btn danger">

                        🗑 Delete

                    </button>

                </form>

            </div>

        <?php endif; ?>

        <a
            href="/lights-out/"
            class="back-link">

            ← Back to Articles

        </a>

    </article>

</main>

<?php
require_once '../includes/footer.php';