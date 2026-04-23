# Prompt Log
## Prompt 1
**Prompt:**  
Take a look at the code base and the instuctions and undertand what you need to do.

**What the AI returned:**  
It reviewed the assignment requirements, inspected the existing site, and recommended Option A (Guestbook) as the fastest way to meet all six technical requirements.

**What I kept / changed / threw away and why:**  
I kept the recommendation to use a guestbook because it had the smallest scope while still using PHP, MySQL, and JavaScript. I also kept the local-only workflow instruction because that matched the assignment stage I wanted.

## Prompt 2
**Prompt:**  
`Build Option A as a clean quiz3 folder with one MySQL table, prepared statements for user input, and JavaScript that posts messages without refreshing the page.`

**What the AI returned:**  
It proposed a small folder structure with `index.php`, `submit.php`, shared includes, and client-side JavaScript for AJAX form submission.

**What I kept / changed / threw away and why:**  
I kept the small folder structure because it was easy to explain in class. I threw away any larger multi-page design ideas because they would have added complexity without earning extra points.

## Prompt 3
**Prompt:**  
`Design the MySQL schema for the guestbook and explain why each column type makes sense.`

**What the AI returned:**  
It suggested a single `guestbook_entries` table with an auto-increment ID, a short name field, a text comment field, and a timestamp.

**What I kept / changed / threw away and why:**  
I kept the single-table design because it was enough for the feature. I kept `VARCHAR(80)` for names and `TEXT` for comments because those data types matched the expected content cleanly.

## Prompt 4
**Prompt:**  
`Write a tiny local PHP test file first for trimming input, validation, and safe HTML escaping before implementing the helpers.`

**What the AI returned:**  
It created a lightweight PHP test harness and helper function targets, then showed the test failing before the helper file existed.

**What I kept / changed / threw away and why:**  
I kept the test-first approach because it made the helper logic easier to trust. I threw away the idea of adding a heavier testing framework because that would have slowed the project down.

## Prompt 5
**Prompt:**  
`Implement the PHP write path with prepared statements and return JSON so the browser can update instantly after a post.`

**What the AI returned:**  
It built `submit.php` with normalization, validation, database insert logic, a prepared `INSERT`, and a prepared query to load the saved row back from the database.

**What I kept / changed / threw away and why:**  
I kept the prepared statements because they directly satisfy the assignment and prevent SQL injection. I threw away any verbose database error output because exposing SQL errors to users would be a security problem.

## Prompt 6
**Prompt:**  
`Implement the PHP read path so existing guestbook messages render newest-first on the main page.`

**What the AI returned:**  
It built a database helper to load rows ordered by newest first and a render helper that escaped the output with `htmlspecialchars()`.

**What I kept / changed / threw away and why:**  
I kept the newest-first ordering because the assignment required it. I kept the escaping because it blocks XSS and gave me a good second vulnerability example for the break-it write-up.

## Prompt 7
**Prompt:**  
`Add simple client-side interactivity: live character count, AJAX submit, inline errors, and prepend the new message without a page refresh.`

**What the AI returned:**  
It added a small vanilla JavaScript file that intercepts form submission, sends `fetch()` requests, updates status messages, and inserts the new HTML at the top of the wall.

**What I kept / changed / threw away and why:**  
I kept the JavaScript enhancements because they clearly improve the user experience beyond a plain form. I threw away extra animation ideas because they were not necessary for the grade.

## Prompt 8
**Prompt:**  
`Write the assignment support files: a code walkthrough README, a break-it exercise for SQL injection and XSS, and a prompt log that explains what I accepted or changed.`

**What the AI returned:**  
It created the documentation files needed to explain the schema, the PHP read/write flow, the JavaScript behavior, and the two intentional vulnerabilities.

**What I kept / changed / threw away and why:**  
I kept the write-ups because they directly map to the deliverables. I changed the prompt log wording to be transparent about which prompts were exact and which were reconstructed so the documentation stays honest.
