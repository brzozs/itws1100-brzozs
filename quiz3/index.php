<?php

declare(strict_types=1);

require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/guestbook.php';

$entries = [];
$statusMessage = '';
$statusType = '';

try {
    $db = guestbook_db_connect();
    $entries = guestbook_fetch_entries($db);
    $db->close();
} catch (Throwable $exception) {
    $statusMessage = 'Database connection failed. Import `quiz3/schema.sql` and confirm your MySQL settings.';
    $statusType = 'error';
}

if (isset($_GET['posted'])) {
    $statusMessage = 'Thanks for signing the guestbook.';
    $statusType = 'success';
}

if (isset($_GET['error'])) {
    $statusMessage = 'Please try your submission again. JavaScript is recommended for the best experience.';
    $statusType = 'error';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Quiz 3 Guestbook</title>
  <link rel="stylesheet" href="assets/styles.css">
</head>
<body>
  <main class="page-shell">
    <section class="hero">
      <p class="eyebrow">ITWS 1100 Quiz 3</p>
      <h1>Guestbook / Comment Wall</h1>
      <p class="hero-copy">Leave a message and watch it appear instantly at the top of the wall.</p>
      <p><a href="../index.html">Back to home</a></p>
    </section>

    <section class="panel">
      <h2>Sign the Wall</h2>

      <?php if ($statusMessage !== ''): ?>
      <div class="status status--<?= guestbook_escape($statusType) ?>" id="pageStatus">
        <?= guestbook_escape($statusMessage) ?>
      </div>
      <?php else: ?>
      <div class="status" id="pageStatus" hidden></div>
      <?php endif; ?>

      <form id="guestbookForm" action="submit.php" method="post" novalidate>
        <label for="visitor_name">Name</label>
        <input type="text" id="visitor_name" name="visitor_name" maxlength="80" required>
        <p class="field-error" id="nameError" hidden></p>

        <label for="comment_text">Comment</label>
        <textarea id="comment_text" name="comment_text" rows="5" maxlength="500" required></textarea>
        <div class="field-row">
          <p class="field-error" id="commentError" hidden></p>
          <p class="char-count"><span id="commentCount">0</span>/500</p>
        </div>

        <button type="submit" id="submitButton">Post Message</button>
      </form>
    </section>

    <section class="panel">
      <div class="wall-header">
        <h2>Latest Messages</h2>
        <p>Newest posts appear first.</p>
      </div>
      <div id="guestbookWall" class="guestbook-wall">
        <?= guestbook_render_entries($entries) ?>
      </div>
    </section>
  </main>

  <script src="assets/app.js"></script>
</body>
</html>
