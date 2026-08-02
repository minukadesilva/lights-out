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

<main>

    <!-- Hero -->

    <section class="hero">

    <div class="hero-content">

        <span class="hero-tag">

            FORMULA ONE BLOG

        </span>

        <h1>

            LIGHTS OUT

        </h1>

        <p>

            Race reports, technical insights,
            paddock stories and everything Formula One.

        </p>

        <a
            href="#latest"
            class="hero-btn">

            Explore Stories

        </a>

    </div>

</section>

    <?php
    $featured = true;
    ?>

    <?php while ($blog = $result->fetch_assoc()): ?>

        <?php if ($featured): ?>

        <!-- Featured Article -->

       <section class="featured">

    <div class="featured-card">

        <div class="featured-image-container">

            <img
                src="/lights-out/uploads/<?= htmlspecialchars($blog['cover_image']) ?>"
                class="featured-image"
                alt="<?= htmlspecialchars($blog['title']) ?>">

        </div>

        <div class="featured-content">

            <span class="featured-badge">

                Featured Story

            </span>

            <h2>

                <?= htmlspecialchars($blog['title']) ?>

            </h2>

            <p class="featured-meta">

                👤 <?= htmlspecialchars($blog['username']) ?>

                •

                <?= date('F d, Y', strtotime($blog['created_at'])) ?>

            </p>

            <p>

                <?= substr(strip_tags(markdownToHtml($blog['content'])),0,260) ?>

                ...

            </p>

            <a
                href="blog/view.php?id=<?= $blog['id'] ?>"
                class="hero-btn">

                Read Full Article →

            </a>

        </div>

    </div>

</section>
        <section
            id="latest"
            class="latest-section">

            <h2>

                Latest Stories

            </h2>

            <div class="blog-grid">

        <?php
        $featured = false;
        continue;
        endif;
        ?>

            <article class="blog-card">

    <img
        src="/lights-out/uploads/<?= htmlspecialchars($blog['cover_image']) ?>"
        alt="<?= htmlspecialchars($blog['title']) ?>"
        class="blog-image">

    <span class="category">

        Formula One

    </span>

    <h3>

        <?= htmlspecialchars($blog['title']) ?>

    </h3>

    <p class="meta">

        <?= htmlspecialchars($blog['username']) ?>

        •

        <?= date('d M Y', strtotime($blog['created_at'])) ?>

    </p>

<p class="excerpt">

    <?= substr(strip_tags(markdownToHtml($blog['content'])),0,140) ?>

    ...

</p>

<a
    href="blog/view.php?id=<?= $blog['id'] ?>"
    class="card-btn">

    Read Article →

</a>

</article>

    <?php endwhile; ?>

        </div>

    </section>

</main>

<?php
require_once 'includes/footer.php';