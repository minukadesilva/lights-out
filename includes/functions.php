<?php

declare(strict_types=1);

function sanitizeInput(string $value): string
{
    return trim($value);
}

function redirect(string $path): void
{
    header("Location: /lights-out/" . ltrim($path, '/'));
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