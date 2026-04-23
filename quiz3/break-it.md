# Break It

For this part, I made vulnerable copies of the code instead of changing the real version of the guestbook.

## 1. SQL Injection

### Vulnerable code
In the safe version, I use a prepared statement. In the vulnerable copy, I changed it to direct string concatenation:

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

### Malicious input
If somebody could control `entry_id`, they could use this:

```text
0 OR 1=1
```

### What would happen
The SQL would turn into this:

```sql
WHERE entry_id = 0 OR 1=1
```

Since `1=1` is always true, the query would return every row instead of one row. That means the attacker changed what the SQL does just by typing input into the page.

### Safe code
This is the original safe version:

```php
$statement = $db->prepare(
    "SELECT entry_id, visitor_name, comment_text, DATE_FORMAT(created_at, '%Y-%m-%d %H:%i') AS created_at
     FROM guestbook_entries
     WHERE entry_id = ?"
);
$statement->bind_param('i', $entryId);
$statement->execute();
```

### Why the safe code works
The `?` keeps the SQL command fixed, and `bind_param('i', $entryId)` sends the value separately as data. Because of that, MySQL does not treat the input like part of the SQL command.

## 2. XSS

### Vulnerable code
In the safe version, I escape output before showing it. In the vulnerable copy, I removed that escaping:

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

### Malicious input
Someone could type this into the form:

```html
<script>alert('hacked')</script>
```

### What would happen
If that input gets stored and shown without escaping, the browser reads it like real JavaScript instead of plain text. In this example it would pop up an alert, but in a real attack it could be used to run unwanted code in another user's browser.

### Safe code
This is the original safe version:

```php
$name = htmlspecialchars((string) ($entry['visitor_name'] ?? 'Anonymous'), ENT_QUOTES, 'UTF-8');
$comment = nl2br(htmlspecialchars((string) ($entry['comment_text'] ?? ''), ENT_QUOTES, 'UTF-8'));
$createdAt = htmlspecialchars((string) ($entry['created_at'] ?? ''), ENT_QUOTES, 'UTF-8');
```

### Why the safe code works
`htmlspecialchars()` changes characters like `<`, `>`, and quotes into HTML entities. That makes the browser display the input as text instead of running it as code.
