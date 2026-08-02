<?php

declare(strict_types=1);

function sanitizeInput(string $value): string
{
    return trim($value);
}

function redirect(string $location): void
{
    header("Location: $location");
    exit;
}

function setError(string $message): void
{
    $_SESSION['error'] = $message;
}

function setSuccess(string $message): void
{
    $_SESSION['success'] = $message;
}