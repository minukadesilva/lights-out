<?php

declare(strict_types=1);

require_once 'includes/header.php';
require_once 'includes/navbar.php';
require_once 'config/database.php';
require_once 'includes/markdown.php';

$query = "
    SELECT
        blogPost.*,
        user.username
    FROM blogPost
    INNER JOIN user
        ON blogPost.user_id = user.id
    ORDER BY created_at DESC
";

$result = $conn->query($query);
?>

<main class="container">

    <h1 class="page-title">

        Latest Formula One Articles

    </h1>

    <?php if ($result->num_rows === 0): ?>

        <div class="empty-state">

            <h2>No articles yet.</h2>

            <p>

                Be the first to publish an F1 article!

            </p>

        </div>

    <?php else: ?>

        <div class="blog-grid">

            <?php while ($blog = $result->fetch_assoc()): ?>

                <article class="blog-card">

                    <h2>

                        <?= htmlspecialchars($blog['title']) ?>

                    </h2>

                    <div class="meta">

                        By

                        <strong>

                            <?= htmlspecialchars($blog['username']) ?>

                        </strong>

                        •

                        <?= date(
                            'd M Y',
                            strtotime($blog['created_at'])
                        ) ?>

                    </div>

                    <div class="excerpt">

                        <?=
                        substr(
                            strip_tags(
                                markdownToHtml(
                                    $blog['content']
                                )
                            ),
                            0,
                            220
                        );
                        ?>

                        ...

                    </div>

                    <a
                        class="read-more"
                        href="blog/view.php?id=<?= $blog['id'] ?>">

                        Read More →

                    </a>

                </article>

            <?php endwhile; ?>

        </div>

    <?php endif; ?>

</main>

<?php
require_once 'includes/footer.php';