<?php

declare(strict_types=1);

require_once 'config/config.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title><?= htmlspecialchars($env['APP_NAME']) ?></title>

    <link rel="stylesheet"
          href="assets/css/style.css">

</head>

<body>

    <h1><?= htmlspecialchars($env['APP_NAME']) ?></h1>

    <script src="assets/js/script.js"></script>

</body>

</html>