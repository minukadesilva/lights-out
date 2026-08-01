<?php

declare(strict_types=1);

/**
 * Simple .env loader
 * No external libraries
 */

function loadEnv(string $path): array
{
    $env = [];

    if (!file_exists($path)) {
        return $env;
    }

    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    foreach ($lines as $line) {

        $line = trim($line);

        if ($line === '' || str_starts_with($line, '#')) {
            continue;
        }

        [$key, $value] = explode('=', $line, 2);

        $env[trim($key)] = trim($value);
    }

    return $env;
}