<?php

declare(strict_types=1);

function assertSameValue(mixed $expected, mixed $actual, string $message): void
{
    if ($expected !== $actual) {
        fwrite(STDERR, $message . PHP_EOL);
        fwrite(STDERR, 'Expected: ' . var_export($expected, true) . PHP_EOL);
        fwrite(STDERR, 'Actual:   ' . var_export($actual, true) . PHP_EOL);
        exit(1);
    }
}

function assertTrueValue(bool $condition, string $message): void
{
    if (!$condition) {
        fwrite(STDERR, $message . PHP_EOL);
        exit(1);
    }
}

function findHrefByLinkText(string $filePath, string $linkText): string
{
    $html = file_get_contents($filePath);

    if ($html === false) {
        fwrite(STDERR, 'Unable to read file: ' . $filePath . PHP_EOL);
        exit(1);
    }

    $dom = new DOMDocument();

    libxml_use_internal_errors(true);
    $dom->loadHTML($html);
    libxml_clear_errors();

    foreach ($dom->getElementsByTagName('a') as $anchor) {
        $textContent = trim(html_entity_decode($anchor->textContent, ENT_QUOTES | ENT_HTML5));

        if (str_contains($textContent, $linkText)) {
            return (string) $anchor->getAttribute('href');
        }
    }

    fwrite(STDERR, 'Could not find link text "' . $linkText . '" in ' . $filePath . PHP_EOL);
    exit(1);
}

function assertLinkTargetExists(string $filePath, string $href): void
{
    $targetPath = realpath(dirname($filePath) . '/' . $href);

    assertTrueValue(
        $targetPath !== false && is_file($targetPath),
        'Expected link target to exist for ' . $filePath . ': ' . $href
    );
}

$repoRoot = dirname(__DIR__, 2);

$expectedLinks = [
    $repoRoot . '/labs/Lab 8/lab8.html' => [
        'text' => 'Back to Home',
        'href' => '../../index.html',
    ],
    $repoRoot . '/labs/Lab 5/Lab 5/education.html' => [
        'text' => 'Home',
        'href' => '../../../index.html',
    ],
    $repoRoot . '/labs/Lab 5/Lab 5/skills.html' => [
        'text' => 'Home',
        'href' => '../../../index.html',
    ],
    $repoRoot . '/labs/Lab 5/Lab 5/contacts.html' => [
        'text' => 'Home',
        'href' => '../../../index.html',
    ],
    $repoRoot . '/labs/Lab 5/Lab 5/exp.html' => [
        'text' => 'Home',
        'href' => '../../../index.html',
    ],
    $repoRoot . '/labs/Lab 5/Lab 5/VolE.html' => [
        'text' => 'Home',
        'href' => '../../../index.html',
    ],
];

foreach ($expectedLinks as $filePath => $expectation) {
    $actualHref = findHrefByLinkText($filePath, $expectation['text']);

    assertSameValue(
        $expectation['href'],
        $actualHref,
        'Unexpected link target for ' . $filePath . ' (' . $expectation['text'] . ').'
    );

    assertLinkTargetExists($filePath, $actualHref);
}

fwrite(STDOUT, "Navigation regression tests passed." . PHP_EOL);
