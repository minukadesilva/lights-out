<?php

declare(strict_types=1);

require_once 'includes/header.php';
require_once 'includes/navbar.php';
require_once 'config/database.php';

if (!isset($_SESSION['user'])) {
    redirect("auth/login.php");
}

$userId = $_SESSION['user']['id'];

$stmt = $conn->prepare("
    SELECT
        id,
        title,
        created_at
    FROM blogPost
    WHERE user_id = ?
    ORDER BY created_at DESC
");

$stmt->bind_param("i", $userId);

$stmt->execute();

$result = $stmt->get_result();

$totalArticles = $result->num_rows;

?>

<main class="dashboard-page">

    <section class="dashboard-header">

        <span class="dashboard-tag">

            Welcome Back

        </span>

        <h1>

            <?= htmlspecialchars($_SESSION['user']['username']) ?> 👋

        </h1>

        <p>

            Ready to publish your next Formula One story?

        </p>

        <a
            href="blog/create.php"
            class="hero-btn">

            + Write New Article

        </a>

    </section>

    <section class="dashboard-stats">

        <div class="stat-card">

            <h2>

                <?= $totalArticles ?>

            </h2>

            <p>

                Articles Published

            </p>

        </div>

    </section>

    <section class="dashboard-articles">

        <h2>

            My Articles

        </h2>

        <?php if ($totalArticles === 0): ?>

            <div class="empty-dashboard">

                <h3>No Articles Yet</h3>

                <p>

                    Publish your first Formula One story.

                </p>

            </div>

        <?php else: ?>

            <?php while ($blog = $result->fetch_assoc()): ?>

                <div class="dashboard-article">

                    <div>

                        <h3>

                            <?= htmlspecialchars($blog['title']) ?>

                        </h3>

                        <small>

                            <?= date('d M Y', strtotime($blog['created_at'])) ?>

                        </small>

                    </div>

                    <div class="dashboard-actions">

                        <a
                            href="blog/edit.php?id=<?= $blog['id'] ?>"
                            class="btn">

                            Edit

                        </a>

                        <a
                            href="actions/delete_blog.php?id=<?= $blog['id'] ?>"
                            class="btn danger"
                            onclick="return confirm('Delete this article?')">

                            Delete

                        </a>

                    </div>

                </div>

            <?php endwhile; ?>

        <?php endif; ?>

    </section>

</main>

<?php
require_once 'includes/footer.php';
?>