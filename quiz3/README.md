# Quiz 3 Guestbook

## Overview
For Quiz 3, I built Option A, a guestbook/comment wall. A visitor can type in a name and a comment, submit it, and the message gets stored in MySQL and displayed on the page with the newest posts first.

## Local setup
1. Import the schema:

```bash
mysql -uroot < quiz3/schema.sql
```

2. Start the PHP server from the repo root:

```bash
php -S 127.0.0.1:8000
```

3. Open this page in the browser:

http://127.0.0.1:8000/quiz3/index.php

## Azure URL
This is the URL I will use after deployment:

https://brzozsrpi.eastus.cloudapp.azure.com/iit/quiz3/

## CREATE TABLE statement

```sql
CREATE TABLE IF NOT EXISTS guestbook_entries (
  entry_id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  visitor_name VARCHAR(80) NOT NULL,
  comment_text TEXT NOT NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (entry_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

## Code walkthrough

### Database schema
I used one table called guestbook_entries. The entry_id column is the primary key and auto-increments so every post has its own ID. visitor_name is a VARCHAR(80) because names are short and I wanted a clear limit. comment_text is TEXT because comments can be longer. created_at stores the time the message was posted, which lets me sort the messages with the newest ones first.

### PHP write path
The form on index.php sends data to submit.php. In submit.php, the first step is checking that the request method is POST. After that, the code trims the values from the form and validates them. If either field is blank, the script sends an error back instead of saving bad data.

If the data is valid, PHP connects to MySQL and runs an INSERT statement with placeholders. That is the prepared statement part. The values are bound separately, so user input is treated like data instead of part of the SQL command. After the insert, the code loads that same row back from the database and sends it to the browser as JSON.

### PHP read path
When index.php loads, it connects to the database and gets all guestbook entries from the guestbook_entries table. The query orders the rows by created_at DESC and then entry_id DESC, so the newest message shows up first. The results are turned into an array of rows.

Then the render helper builds the HTML for each message. The helper escapes the name, comment, and date before putting them on the page. That matters because if I printed raw user input, someone could try to inject HTML or JavaScript into the page.

### Client-side JavaScript
The JavaScript file does a few things to make the page better to use. It watches the comment box and updates the live character count while the user types. It also intercepts the form submission and sends the data with fetch instead of doing a full page reload.

When the response comes back, the script checks whether it succeeded. If there is a validation problem, it shows the error message under the matching field. If the post works, it adds the new guestbook message to the top of the page right away, resets the form, and shows a success message.

## Main files
- index.php
- submit.php
- schema.sql
- prompt-log.md
- break-it.md
