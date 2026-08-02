<?php

declare(strict_types=1);

require_once 'includes/header.php';
require_once 'includes/navbar.php';

if (!isset($_SESSION['user'])) {
    redirect("auth/login.php");
}
?>

<main class="container">

    <h1>

        Welcome,
        <?= htmlspecialchars($_SESSION['user']['username']) ?>

    </h1>

    <p>

        Ready to write another Formula One article?

    </p>

    <br>

    <a href="blog/create.php" class="btn">

        + New Article

    </a>

</main>

<?php
require_once 'includes/footer.php';