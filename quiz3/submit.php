<?php

declare(strict_types=1);

require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/guestbook.php';

function respond_with_json(array $payload, int $statusCode): never
{
    http_response_code($statusCode);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($payload);
    exit;
}

function request_wants_json(): bool
{
    $requestedWith = strtolower((string) ($_SERVER['HTTP_X_REQUESTED_WITH'] ?? ''));
    $acceptHeader = strtolower((string) ($_SERVER['HTTP_ACCEPT'] ?? ''));

    return $requestedWith === 'xmlhttprequest' || str_contains($acceptHeader, 'application/json');
}

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
    if (request_wants_json()) {
        respond_with_json(['message' => 'Method not allowed.'], 405);
    }

    header('Location: index.php');
    exit;
}

$entry = guestbook_normalize_input($_POST);
$errors = guestbook_validate_entry($entry);

if ($errors !== []) {
    if (request_wants_json()) {
        respond_with_json([
            'message' => 'Please correct the highlighted fields.',
            'errors' => $errors,
        ], 422);
    }

    header('Location: index.php?error=1');
    exit;
}

try {
    $db = guestbook_db_connect();
    $entryId = guestbook_insert_entry($db, $entry);
    $savedEntry = guestbook_fetch_entry_by_id($db, $entryId);
    $db->close();
} catch (Throwable $exception) {
    if (request_wants_json()) {
        respond_with_json([
            'message' => 'The message could not be saved right now. Please try again later.',
        ], 500);
    }

    header('Location: index.php?error=1');
    exit;
}

if ($savedEntry === null) {
    if (request_wants_json()) {
        respond_with_json([
            'message' => 'The message was saved, but it could not be loaded back from the database.',
        ], 500);
    }

    header('Location: index.php?error=1');
    exit;
}

if (request_wants_json()) {
    respond_with_json([
        'message' => 'Thanks for signing the guestbook.',
        'entryHtml' => guestbook_render_entry($savedEntry),
    ], 201);
}

header('Location: index.php?posted=1');
exit;
