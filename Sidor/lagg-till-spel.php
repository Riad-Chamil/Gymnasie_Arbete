<?php

session_start();

require_once __DIR__ . '/../includes/functions.php';

$message = $_SESSION['message'] ?? '';
unset($_SESSION['message']);

$allowedUnits = ['B', 'KB', 'MB', 'GB', 'TB'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $gameName = trim($_POST['game_name'] ?? '');
    $releaseDate = $_POST['release_date'] ?? '';
    $storageSize = $_POST['storage_size'] ?? '';
    $storageUnit = $_POST['storage_unit'] ?? '';

    if (
        $gameName === '' ||
        $releaseDate === '' ||
        $storageSize === '' ||
        !is_numeric($storageSize) ||
        $storageSize < 0 ||
        !in_array($storageUnit, $allowedUnits, true)
    ) {

        $_SESSION['message'] = "Fyll i alla fält korrekt.";
    } else {

        try {

            if (LäggSpel($gameName, $releaseDate, $storageSize, $storageUnit)) {
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

        <label for="storage_size">Lagringsstorlek:</label>
        <input
            type="number"
            id="storage_size"
            name="storage_size"
            min="0"
            step="0.1"
            required>

        <select name="storage_unit" id="storage_unit" required>
            <option value="B">Byte (B)</option>
            <option value="KB">Kilobyte (KB)</option>
            <option value="MB">Megabyte (MB)</option>
            <option value="GB" selected>Gigabyte (GB)</option>
            <option value="TB">Terabyte (TB)</option>
        </select>

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
            <?php echo htmlspecialchars($game['LagringStorlek'], ENT_QUOTES, 'UTF-8'); ?>
            <?php echo htmlspecialchars($game['LagringsEnhet'], ENT_QUOTES, 'UTF-8'); ?>
        </p>

    <?php endwhile; ?>

</body>

</html>