# Prompt Log

## Prompt 1
Prompt:
Take a look at the code base and the instructions and understand what you need to do.

What the AI returned:
It looked through the project and the assignment, then recommended doing Option A, the guestbook/comment wall, because it was the fastest way to meet all the requirements.

What I kept, changed, or threw away:
I kept the guestbook idea because it was the simplest choice that still used PHP, MySQL, and JavaScript together. I also kept the local-only approach for now since I did not want to deploy yet.

## Prompt 2
Prompt:
Build Option A as a clean quiz3 folder with one MySQL table, prepared statements for user input, and JavaScript that posts messages without refreshing the page.

What the AI returned:
It suggested a simple folder setup with index.php, submit.php, shared include files, and one JavaScript file for AJAX form submission.

What I kept, changed, or threw away:
I kept the small folder structure because it was easy to follow and easy to explain. I threw away anything that made it bigger than it needed to be, like extra pages or extra features.

## Prompt 3
Prompt:
Design the MySQL schema for the guestbook and explain why each column type makes sense.

What the AI returned:
It suggested one table called guestbook_entries with an ID, name, comment, and timestamp.

What I kept, changed, or threw away:
I kept the one-table design because that was enough for this feature. I also kept the timestamp so the page could show newest messages first.

## Prompt 4
Prompt:
Write a small local PHP test first for trimming input, validation, and safe output before making the helper functions.

What the AI returned:
It made a lightweight PHP test file and used it to check input trimming, required fields, and HTML escaping.

What I kept, changed, or threw away:
I kept the test-first idea because it made the helper code easier to check. I did not add a bigger testing framework because that would have taken more time than this project needed.

## Prompt 5
Prompt:
Implement the PHP write path with prepared statements and return JSON so the page can update right away after a post.

What the AI returned:
It built the submit logic, added validation, inserted the message with a prepared statement, and returned JSON for the browser.

What I kept, changed, or threw away:
I kept the prepared statements because they are required and they protect against SQL injection. I also kept the JSON response because it made the JavaScript side simpler.

## Prompt 6
Prompt:
Implement the PHP read path so guestbook messages load from MySQL and display newest first.

What the AI returned:
It added the query to load the entries and a render helper that escapes the output before printing it.

What I kept, changed, or threw away:
I kept the newest-first ordering because that is part of the assignment. I kept the escaping because it prevents XSS and made a good example for the break-it section.

## Prompt 7
Prompt:
Add simple client-side interactivity like a live character count, AJAX submission, inline errors, and adding the new message without reloading the page.

What the AI returned:
It created a JavaScript file that intercepts the form submit, sends the request with fetch, shows errors, and adds the new message to the top of the wall.

What I kept, changed, or threw away:
I kept the interactive parts because they clearly improve the user experience. I threw away anything extra like animations because they were not needed for the assignment.

## Prompt 8
Prompt:
Write the support files for the assignment: the code walkthrough, the break-it exercise, and the prompt log.

What the AI returned:
It made the documentation files and filled in the main explanations for the schema, PHP read and write paths, JavaScript behavior, and the two vulnerabilities.

What I kept, changed, or threw away:
I kept the basic structure because it matched the assignment. I edited the wording to make it sound more like my own class notes and less like generated documentation.
