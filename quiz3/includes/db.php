<?php

declare(strict_types=1);

require_once __DIR__ . '/config.php';

function guestbook_db_connect(): mysqli
{
    $config = guestbook_config();

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    $db = new mysqli(
        $config['db_host'],
        $config['db_user'],
        $config['db_pass'],
        $config['db_name']
    );

    $db->set_charset('utf8mb4');

    return $db;
}

function guestbook_fetch_entries(mysqli $db): array
{
    $query = <<<SQL
SELECT
    entry_id,
    visitor_name,
    comment_text,
    DATE_FORMAT(created_at, '%Y-%m-%d %H:%i') AS created_at
FROM guestbook_entries
ORDER BY created_at DESC, entry_id DESC
SQL;

    $result = $db->query($query);
    $entries = $result->fetch_all(MYSQLI_ASSOC);
    $result->free();

    return $entries;
}

function guestbook_insert_entry(mysqli $db, array $entry): int
{
    $statement = $db->prepare(
        'INSERT INTO guestbook_entries (visitor_name, comment_text) VALUES (?, ?)'
    );
    $statement->bind_param('ss', $entry['visitor_name'], $entry['comment_text']);
    $statement->execute();

    $insertId = (int) $db->insert_id;
    $statement->close();

    return $insertId;
}

function guestbook_fetch_entry_by_id(mysqli $db, int $entryId): ?array
{
    $statement = $db->prepare(
        <<<SQL
SELECT
    entry_id,
    visitor_name,
    comment_text,
    DATE_FORMAT(created_at, '%Y-%m-%d %H:%i') AS created_at
FROM guestbook_entries
WHERE entry_id = ?
SQL
    );
    $statement->bind_param('i', $entryId);
    $statement->execute();
    $result = $statement->get_result();
    $entry = $result->fetch_assoc() ?: null;
    $result->free();
    $statement->close();

    return $entry;
}
