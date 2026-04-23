<?php

declare(strict_types=1);

require __DIR__ . '/../includes/guestbook.php';

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

$normalized = guestbook_normalize_input([
    'visitor_name' => '  Ada Lovelace  ',
    'comment_text' => "  First programmer.  ",
]);

assertSameValue(
    [
        'visitor_name' => 'Ada Lovelace',
        'comment_text' => 'First programmer.',
    ],
    $normalized,
    'guestbook_normalize_input should trim both form fields.'
);

$errors = guestbook_validate_entry([
    'visitor_name' => '',
    'comment_text' => '',
]);

assertSameValue(
    [
        'visitor_name' => 'Please enter your name.',
        'comment_text' => 'Please enter a comment.',
    ],
    $errors,
    'guestbook_validate_entry should report both required fields.'
);

$entryHtml = guestbook_render_entry([
    'visitor_name' => '<script>alert("x")</script>',
    'comment_text' => 'Hello <b>world</b>',
    'created_at' => '2026-04-23 12:00:00',
]);

assertTrueValue(
    !str_contains($entryHtml, '<script>alert("x")</script>'),
    'guestbook_render_entry should escape the visitor name.'
);

assertTrueValue(
    str_contains($entryHtml, '&lt;script&gt;alert(&quot;x&quot;)&lt;/script&gt;'),
    'guestbook_render_entry should include the escaped visitor name.'
);

assertTrueValue(
    str_contains($entryHtml, 'Hello &lt;b&gt;world&lt;/b&gt;'),
    'guestbook_render_entry should escape the comment text.'
);

fwrite(STDOUT, "All guestbook helper tests passed." . PHP_EOL);
