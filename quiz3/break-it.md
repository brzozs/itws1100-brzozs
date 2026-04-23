# Break It Exercise

This document shows two vulnerabilities in a **copy** of the guestbook code. The live feature should keep the original safe version.

## Vulnerability 1: SQL Injection

### Vulnerable Code
This is a copied, intentionally unsafe version of the prepared statement in `guestbook_fetch_entry_by_id()`:

```php
$query = "
SELECT
    entry_id,
    visitor_name,
    comment_text,
    DATE_FORMAT(created_at, '%Y-%m-%d %H:%i') AS created_at
FROM guestbook_entries
WHERE entry_id = " . $_GET['entry_id'];

$result = $db->query($query);
```

### Malicious Input
If an attacker can control `entry_id`, they could send:

```text
0 OR 1=1
```

### What Would Happen
The query would become:

```sql
... WHERE entry_id = 0 OR 1=1
```

Because `1=1` is always true, the database would return every row instead of just one intended row. That leaks data and proves the attacker changed the meaning of the SQL statement.

### Safe Code
This is the original safe pattern from the real project:

```php
$statement = $db->prepare(
    "SELECT entry_id, visitor_name, comment_text, DATE_FORMAT(created_at, '%Y-%m-%d %H:%i') AS created_at
     FROM guestbook_entries
     WHERE entry_id = ?"
);
$statement->bind_param('i', $entryId);
$statement->execute();
```

### Why the Safe Code Works
The `?` placeholder keeps the SQL structure fixed, and `bind_param('i', $entryId)` sends the value separately as an integer. MySQL treats it as data, not as part of the SQL command, so `0 OR 1=1` cannot change the query logic.

## Vulnerability 2: XSS (Cross-Site Scripting)

### Vulnerable Code
This is a copied, intentionally unsafe version of `guestbook_render_entry()` with escaping removed:

```php
function guestbook_render_entry(array $entry): string
{
    $name = (string) ($entry['visitor_name'] ?? 'Anonymous');
    $comment = nl2br((string) ($entry['comment_text'] ?? ''));
    $createdAt = (string) ($entry['created_at'] ?? '');

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
```

### Malicious Input
An attacker could submit this as the name or comment:

```html
<script>alert('hacked')</script>
```

### What Would Happen
When another visitor loads the guestbook page, the browser would treat the `<script>` tag as real code and run it. In this example, it would show an alert box, but a real attacker could inject worse JavaScript to steal data or manipulate the page.

### Safe Code
This is the original safe pattern from the real project:

```php
$name = htmlspecialchars((string) ($entry['visitor_name'] ?? 'Anonymous'), ENT_QUOTES, 'UTF-8');
$comment = nl2br(htmlspecialchars((string) ($entry['comment_text'] ?? ''), ENT_QUOTES, 'UTF-8'));
$createdAt = htmlspecialchars((string) ($entry['created_at'] ?? ''), ENT_QUOTES, 'UTF-8');
```

### Why the Safe Code Works
`htmlspecialchars()` converts characters like `<`, `>`, and quotes into harmless HTML entities. That means the browser displays the attacker’s input as plain text instead of executing it as JavaScript.
