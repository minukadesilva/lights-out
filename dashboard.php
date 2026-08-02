<?php

declare(strict_types=1);

require_once 'includes/header.php';
require_once 'includes/navbar.php';

if (!isset($_SESSION['user'])) {
    header("Location: /lights-out/auth/login.php");
    exit;
}
?>

<main class="container">

    <h1>
        Welcome,
        <?= htmlspecialchars($_SESSION['user']['username']) ?>
    </h1>

    <p>You have successfully logged in.</p>

</main>

<?php require_once 'includes/footer.php'; ?>