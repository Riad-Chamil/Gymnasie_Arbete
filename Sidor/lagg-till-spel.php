<?php

session_start();

require_once __DIR__ . '/../includes/functions.php';

$message = $_SESSION['message'] ?? '';
unset($_SESSION['message']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $gameName = trim($_POST['game_name'] ?? '');
    $releaseDate = $_POST['release_date'] ?? '';
    $storageSize = $_POST['storage_size'] ?? '';

    if ($gameName === '' || $releaseDate === '' || $storageSize === '') {

        $_SESSION['message'] = "Du måste fylla i alla fält.";
    } else {

        try {

            if (LäggSpel($gameName, $releaseDate, $storageSize)) {
                $_SESSION['message'] = "Spelet har lagts till i databasen!";
            } else {
                $_SESSION['message'] = "Det gick inte att lägga till spelet.";
            }
        } catch (PDOException $e) {

            error_log($e->getMessage());
            $_SESSION['message'] = "Ett databasfel uppstod.";
        }
    }

    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

$games = HämtaSpel();

?>

<!DOCTYPE html>
<html lang="sv">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lägg till spel</title>
</head>

<body>

    <h1>Lägg till ett spel</h1>

    <form method="POST" action="">

        <label for="game_name">Spelnamn:</label>

        <input
            type="text"
            id="game_name"
            name="game_name"
            maxlength="255"
            required>

        <br><br>

        <label for="release_date">Utgivningsdatum:</label>

        <input
            type="date"
            id="release_date"
            name="release_date"
            required>

        <br><br>

        <label for="storage_size">Lagringsstorlek (GB):</label>
        <input
            type="number"
            id="storage_size"
            name="storage_size"
            step="0.01"
            required>

        <br><br>


        <button type="submit">Lägg till spel</button>

    </form>

    <p>
        <?php echo htmlspecialchars($message, ENT_QUOTES, 'UTF-8'); ?>
    </p>

    <h2>Spel i databasen</h2>

    <?php while ($game = $games->fetch()): ?>

        <p>
            <?php echo htmlspecialchars($game['Spel_Namn'], ENT_QUOTES, 'UTF-8'); ?>
            -
            <?php echo htmlspecialchars($game['Utgivningsdatum'], ENT_QUOTES, 'UTF-8'); ?>
            -
            <?php echo htmlspecialchars($game['LagringStorlek'], ENT_QUOTES, 'UTF-8'); ?> GB
        </p>

    <?php endwhile; ?>

</body>

</html>