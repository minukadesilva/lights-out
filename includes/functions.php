<?php

declare(strict_types=1);

/**
 * Remove unnecessary whitespace.
 */
function sanitizeInput(string $value): string
{
    return trim($value);
}

/**
 * Redirect to another page.
 */
function redirect(string $location): void
{
    header("Location: $location");
    exit;
}