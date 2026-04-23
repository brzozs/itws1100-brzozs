<?php
$items = [
    'lab01' => '/labs/Lab%201/',
    'lab02' => '/labs/Lab%202/',
    'lab03' => '/labs/Lab%203/',
    'lab04' => '/labs/Lab%204/',
    'lab05' => '/labs/Lab%205/',
    'lab06' => '/labs/Lab%206/',
    'lab08' => '/labs/Lab%208/',
    'lab09' => '/labs/Lab%209/',
    'lab10' => '/labs/Lab%2010/',
    'project-rpi-dorms' => 'https://github.com/brzozs/RPI-Dorms-Space',
    'project-city-limits' => 'https://github.com/brzozs/City-Limits',
];

$item = $_GET['item'] ?? '';

if (!isset($items[$item])) {
    http_response_code(404);
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Lab Link Not Found</title>
  <link rel="stylesheet" href="../styles.css">
</head>
<body>
  <h1>Lab Link Not Found</h1>
  <p>The requested lab or project link is not configured.</p>
  <p><a href="Lab 8/lab8.html">Back to Projects</a></p>
</body>
</html>
    <?php
    exit;
}

$target = $items[$item];

if (str_starts_with($target, '/')) {
    $scriptDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '/labs/open.php'));
    $scriptDir = $scriptDir === '/' ? '' : rtrim($scriptDir, '/');
    $siteRoot = preg_replace('#/labs$#', '', $scriptDir);
    $target = $siteRoot . $target;
}

header('Location: ' . $target, true, 302);
exit;
?>
