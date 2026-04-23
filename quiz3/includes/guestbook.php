<?php

declare(strict_types=1);

function guestbook_normalize_input(array $input): array
{
    return [
        'visitor_name' => trim((string) ($input['visitor_name'] ?? '')),
        'comment_text' => trim((string) ($input['comment_text'] ?? '')),
    ];
}

function guestbook_validate_entry(array $entry): array
{
    $errors = [];

    if ($entry['visitor_name'] === '') {
        $errors['visitor_name'] = 'Please enter your name.';
    } elseif (mb_strlen($entry['visitor_name']) > 80) {
        $errors['visitor_name'] = 'Name must be 80 characters or fewer.';
    }

    if ($entry['comment_text'] === '') {
        $errors['comment_text'] = 'Please enter a comment.';
    } elseif (mb_strlen($entry['comment_text']) > 500) {
        $errors['comment_text'] = 'Comment must be 500 characters or fewer.';
    }

    return $errors;
}

function guestbook_escape(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

function guestbook_render_entry(array $entry): string
{
    $name = guestbook_escape((string) ($entry['visitor_name'] ?? 'Anonymous'));
    $comment = nl2br(guestbook_escape((string) ($entry['comment_text'] ?? '')));
    $createdAt = guestbook_escape((string) ($entry['created_at'] ?? ''));

    return <<<HTML
<article class="guestbook-entry">
  <header class="guestbook-entry__header">
    <h3>{$name}</h3>
    <p>{$createdAt}</p>
  </header>
  <p class="guestbook-entry__comment">{$comment}</p>
</article>
HTML;
}

function guestbook_render_entries(array $entries): string
{
    if ($entries === []) {
        return '<p class="empty-state">No messages yet. Be the first to sign the wall.</p>';
    }

    return implode(PHP_EOL, array_map('guestbook_render_entry', $entries));
}
