<?php

declare(strict_types=1);

function guestbook_config(): array
{
    return [
        'db_host' => getenv('QUIZ3_DB_HOST') ?: '127.0.0.1',
        'db_user' => getenv('QUIZ3_DB_USER') ?: 'root',
        'db_pass' => getenv('QUIZ3_DB_PASS') ?: '',
        'db_name' => getenv('QUIZ3_DB_NAME') ?: 'itws_quiz3',
    ];
}
