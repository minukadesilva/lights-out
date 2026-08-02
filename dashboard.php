<?php

declare(strict_types=1);

require_once 'includes/header.php';
require_once 'includes/navbar.php';

if (!isset($_SESSION['user'])) {
    redirect("auth/login.php");
}
?>

<main class="dashboard">

    <div class="dashboard-card">

        <span class="dashboard-tag">

            Welcome Back

        </span>

        <h1>

            <?= htmlspecialchars($_SESSION['user']['username']) ?>

        </h1>

        <p>

            Ready to publish your next Formula One story?

        </p>

        <a
            href="/lights-out/blog/create.php"
            class="hero-btn">

            + Write New Article

        </a>

    </div>

</main>

<?php
require_once 'includes/footer.php';