<?php

require_once __DIR__ . '/../includes/functions.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: games.php");
    exit;
}

$gameID = (int) $_GET['id'];

?>

<!DOCTYPE html>
<html>

<head>
    <title>Game Details</title>
</head>

<body>

    <h1>Game ID: <?php echo $gameID; ?></h1>

</body>

</html>