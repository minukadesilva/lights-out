<?php

declare(strict_types=1);

require_once __DIR__ . '/config.php';

$conn = new mysqli(
    $env['DB_HOST'],
    $env['DB_USER'],
    $env['DB_PASS'],
    $env['DB_NAME'],
    (int)$env['DB_PORT']
);

if ($conn->connect_error) {
    die("Database connection failed.");
}