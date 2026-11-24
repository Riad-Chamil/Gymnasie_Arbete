<?php

require_once __DIR__ . '/../includes/functions.php';

$search = trim($_GET['search'] ?? '');
$results = [];

if ($search !== '') {
    $stmt = SökSpel($search);
    $results = $stmt->fetchAll();
}

?>

<!DOCTYPE html>
<html lang="sv">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Spelhantering</title>
</head>

<body>

    <h1>Spelhantering</h1>

    <form method="get" action="game.php">

        <h2>Sök efter spel</h2>

        <input
            type="search"
            name="search"
            placeholder="Sök efter ett spelnamn..."
            value="<?php echo htmlspecialchars($search, ENT_QUOTES, 'UTF-8'); ?>"
            required>

        <button type="submit">Sök</button>
    </form>
    <?php if ($search !== '' && count($results) === 0): ?>

        <p>
            Inga spel hittades för:
            <?php echo htmlspecialchars($search, ENT_QUOTES, 'UTF-8'); ?>
        </p>

    <?php elseif ($search !== ''): ?>

        <h2>Sökresultat</h2>

        <?php foreach ($results as $game): ?>

            <div>

                <h3>
                    <a href="Spel-Detalier.php?id=<?php echo $game['SpelID']; ?>">
                        <?php echo htmlspecialchars($game['Spel_Namn'], ENT_QUOTES, 'UTF-8'); ?>
                    </a>
                </h3>

                <p>
                    Spel-ID: <?php echo $game['SpelID']; ?> -
                    Utgivningsdatum:
                    <?php echo htmlspecialchars($game['Utgivningsdatum'], ENT_QUOTES, 'UTF-8'); ?> -
                    Lagringsstorlek:
                    <?php echo htmlspecialchars($game['LagringStorlek'] . ' ' . $game['LagringsEnhet'], ENT_QUOTES, 'UTF-8'); ?>
                </p>

            </div>

            <hr>

        <?php endforeach; ?>

    <?php endif; ?>
</body>

</html>