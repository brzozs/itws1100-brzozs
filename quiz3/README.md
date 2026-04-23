# Quiz 3 Guestbook

## Feature Summary
This folder contains **Option A: Guestbook / Comment Wall** for Quiz 3. Visitors can enter a name and a comment, the data is stored in MySQL with PHP, and the newest messages appear first on the page.

## Local Run
1. Import the schema:

   ```bash
   mysql -uroot < quiz3/schema.sql
   ```

2. Start a local PHP server from the repo root:

   ```bash
   php -S 127.0.0.1:8000
   ```

3. Open:

   [http://127.0.0.1:8000/quiz3/index.php](http://127.0.0.1:8000/quiz3/index.php)

## Deployment URL
Local-only for now, per request. The planned Azure path after deployment is:

- [https://brzozsrpi.eastus.cloudapp.azure.com/iit/quiz3/](https://brzozsrpi.eastus.cloudapp.azure.com/iit/quiz3/)

## CREATE TABLE Statement
```sql
CREATE TABLE IF NOT EXISTS guestbook_entries (
  entry_id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  visitor_name VARCHAR(80) NOT NULL,
  comment_text TEXT NOT NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (entry_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

## Code Walkthrough

### Database Schema
The schema uses one table, `guestbook_entries`. `entry_id` is the primary key and auto-increments so each message has a unique identifier. `visitor_name` uses `VARCHAR(80)` because names are short and need a clear upper bound. `comment_text` uses `TEXT` because comments can be longer than a normal name field. `created_at` stores when the message was posted and defaults to the current timestamp so the server records the post time automatically.

### PHP Write Path
The form in [index.php](/Users/sebastian/Library/Mobile Documents/com~apple~CloudDocs/School/ITWS/itws1100-brzozs/quiz3/index.php) posts to [submit.php](/Users/sebastian/Library/Mobile Documents/com~apple~CloudDocs/School/ITWS/itws1100-brzozs/quiz3/submit.php). `submit.php` first checks that the request method is `POST`, then calls `guestbook_normalize_input($_POST)` to trim the raw form values. After that, `guestbook_validate_entry($entry)` checks that both required fields are present and within the length limits. If validation succeeds, `guestbook_db_connect()` opens the MySQL connection. `guestbook_insert_entry()` runs an `INSERT INTO guestbook_entries (visitor_name, comment_text) VALUES (?, ?)` prepared statement, then `guestbook_fetch_entry_by_id()` loads the just-created row back from MySQL so the endpoint can return the real saved record. For AJAX requests, `submit.php` sends JSON back to the browser with a success message and the rendered HTML snippet for the new entry.

### PHP Read Path
When the browser loads [index.php](/Users/sebastian/Library/Mobile Documents/com~apple~CloudDocs/School/ITWS/itws1100-brzozs/quiz3/index.php), the page includes [db.php](/Users/sebastian/Library/Mobile Documents/com~apple~CloudDocs/School/ITWS/itws1100-brzozs/quiz3/includes/db.php) and [guestbook.php](/Users/sebastian/Library/Mobile Documents/com~apple~CloudDocs/School/ITWS/itws1100-brzozs/quiz3/includes/guestbook.php). The page connects to MySQL and runs `guestbook_fetch_entries()`, which selects every row ordered by `created_at DESC, entry_id DESC` so the newest posts show first. The resulting array is passed into `guestbook_render_entries($entries)`. That helper loops through each entry with `array_map('guestbook_render_entry', $entries)` and builds the HTML cards shown in the browser. Inside `guestbook_render_entry()`, `htmlspecialchars()` escapes the name, comment, and timestamp before they are printed, which prevents browser-side script injection.

### Client-Side JavaScript
[app.js](/Users/sebastian/Library/Mobile Documents/com~apple~CloudDocs/School/ITWS/itws1100-brzozs/quiz3/assets/app.js) improves the user experience in three ways. First, it shows a live comment counter so the visitor can see how close they are to the 500-character limit. Second, it intercepts the form submit event and sends the data with `fetch()` instead of forcing a full page reload. Third, it updates the DOM after the server responds: validation errors appear under the right fields, success messages appear at the top of the form, and the returned entry HTML is inserted at the top of the message wall immediately.

## Files
- [index.php](/Users/sebastian/Library/Mobile Documents/com~apple~CloudDocs/School/ITWS/itws1100-brzozs/quiz3/index.php)
- [submit.php](/Users/sebastian/Library/Mobile Documents/com~apple~CloudDocs/School/ITWS/itws1100-brzozs/quiz3/submit.php)
- [schema.sql](/Users/sebastian/Library/Mobile Documents/com~apple~CloudDocs/School/ITWS/itws1100-brzozs/quiz3/schema.sql)
- [prompt-log.md](/Users/sebastian/Library/Mobile Documents/com~apple~CloudDocs/School/ITWS/itws1100-brzozs/quiz3/prompt-log.md)
- [break-it.md](/Users/sebastian/Library/Mobile Documents/com~apple~CloudDocs/School/ITWS/itws1100-brzozs/quiz3/break-it.md)
