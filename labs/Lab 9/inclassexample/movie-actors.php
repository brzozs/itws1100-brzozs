<?php
include('includes/init.inc.php');
include('includes/functions.inc.php');
?>
<title>PHP &amp; MySQL - ITWS</title>

<?php include('includes/head.inc.php'); ?>

<h1>PHP &amp; MySQL</h1>

<?php include('includes/menubody.inc.php'); ?>

<?php
$dbOk = false;
@$db = new mysqli('localhost', 'root', 'root', 'iit');

if ($db->connect_error) {
  echo '<div class="messages">Could not connect to the database. Error: ';
  echo $db->connect_errno . ' - ' . $db->connect_error . '</div>';
} else {
  $dbOk = true;
}
?>

<h3>Movie Actors</h3>
<table id="actorTable">
<?php
if ($dbOk) {
  $query = 'select m.title, a.last_name, a.first_names '
    . 'from movie_actors ma '
    . 'inner join movies m on ma.movieid = m.movieid '
    . 'inner join actors a on ma.actorid = a.actorid '
    . 'order by m.title, a.last_name, a.first_names';
  $result = $db->query($query);

  if ($result) {
    $numRecords = $result->num_rows;

    echo '<tr><th>Movie</th><th>Actor</th></tr>';
    for ($i = 0; $i < $numRecords; $i++) {
      $record = $result->fetch_assoc();
      if ($i % 2 == 0) {
        echo "\n" . '<tr><td>';
      } else {
        echo "\n" . '<tr class="odd"><td>';
      }
      echo htmlspecialchars($record['title']);
      echo '</td><td>';
      echo htmlspecialchars($record['last_name']) . ', ';
      echo htmlspecialchars($record['first_names']);
      echo '</td></tr>';
    }

    if ($numRecords == 0) {
      echo '<tr><td colspan="2">No movie/actor relations found.</td></tr>';
    }

    $result->free();
  } else {
    echo '<tr><td colspan="2">Could not read movie/actor relations from database.</td></tr>';
  }

  $db->close();
}
?>
</table>

<?php include('includes/foot.inc.php');
?>
