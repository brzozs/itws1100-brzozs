<?php 
  include('includes/init.inc.php'); // include the DOCTYPE and opening tags
  include('includes/functions.inc.php'); // functions
?>
<title>PHP &amp; MySQL - ITWS</title>   

<?php include('includes/head.inc.php'); ?>

<h1>PHP &amp; MySQL</h1>
      
<?php include('includes/menubody.inc.php'); ?>

<?php
// Open one database connection for this page.
$dbOk = false;
@$db = new mysqli('localhost', 'root', 'root', 'iit');

if ($db->connect_error) {
  echo '<div class="messages">Could not connect to the database. Error: ';
  echo $db->connect_errno . ' - ' . $db->connect_error . '</div>';
} else {
  $dbOk = true;
}
?>

<h3>Movies</h3>
<table id="actorTable">
<?php
if ($dbOk) {
  $query = 'select * from movies order by title';
  $result = $db->query($query);

  if ($result) {
    $numRecords = $result->num_rows;

    echo '<tr><th>Title</th><th>Year</th></tr>';
    for ($i = 0; $i < $numRecords; $i++) {
      $record = $result->fetch_assoc();
      if ($i % 2 == 0) {
        echo "\n" . '<tr><td>';
      } else {
        echo "\n" . '<tr class="odd"><td>';
      }
      echo htmlspecialchars($record['title']);
      echo '</td><td>';
      echo htmlspecialchars($record['year']);
      echo '</td></tr>';
    }

    if ($numRecords == 0) {
      echo '<tr><td colspan="2">No movies found.</td></tr>';
    }

    $result->free();
  } else {
    echo '<tr><td colspan="2">Could not read movies from database.</td></tr>';
  }

  $db->close();
}
?>
</table>

<?php include('includes/foot.inc.php'); 
  // footer info and closing tags
?>
