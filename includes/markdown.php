<?php

declare(strict_types=1);

function markdownToHtml(string $text): string
{
    $text = htmlspecialchars($text, ENT_QUOTES, 'UTF-8');

    // Headings
    $text = preg_replace('/^## (.+)$/m', '<h2>$1</h2>', $text);
    $text = preg_replace('/^# (.+)$/m', '<h1>$1</h1>', $text);

    // Bold
    $text = preg_replace('/\*\*(.*?)\*\*/s', '<strong>$1</strong>', $text);

    // Italic
    $text = preg_replace('/\*(.*?)\*/s', '<em>$1</em>', $text);

    // Links
    $text = preg_replace(
        '/\[(.*?)\]\((.*?)\)/',
        '<a href="$2" target="_blank">$1</a>',
        $text
    );

    // Lists
    $lines = explode("\n", $text);

    $html = "";
    $inList = false;

    foreach ($lines as $line) {

        if (preg_match('/^- (.+)/', $line, $matches)) {

            if (!$inList) {
                $html .= "<ul>";
                $inList = true;
            }

            $html .= "<li>{$matches[1]}</li>";

        } else {

            if ($inList) {
                $html .= "</ul>";
                $inList = false;
            }

            if (trim($line) !== "") {

                if (
                    !str_starts_with($line, "<h1>") &&
                    !str_starts_with($line, "<h2>")
                ) {
                    $html .= "<p>{$line}</p>";
                } else {
                    $html .= $line;
                }

            }

        }

    }

    if ($inList) {
        $html .= "</ul>";
    }

    return $html;
}