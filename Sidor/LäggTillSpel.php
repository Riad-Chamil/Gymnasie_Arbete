
<?php

require_once __DIR__ . '/../includes/functions.php';

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $gameName = trim($_POST['game_name'] ?? '');

    if ($gameName === '') {
        $message = "Du måste skriva ett spelnamn.";

    } else {
        try {
            LäggSpel($gameName);
            $message = "Spelet har lagts till i databasen!";

        } catch (PDOException $e) {
            error_log($e->getMessage());
            $message = "Det gick inte att lägga till spelet.";
        }
    }
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
            required
        >

        <button type="submit">Lägg till spel</button>

    </form>

    <p>
        <?php echo htmlspecialchars($message, ENT_QUOTES, 'UTF-8'); ?>
    </p>

    <h2>Spel i databasen</h2>

    <?php while ($game = $games->fetch()): ?>

        <p>
            <?php echo htmlspecialchars($game['Spel_Namn'], ENT_QUOTES, 'UTF-8'); ?>
        </p>

    <?php endwhile; ?>

</body>
</html>
