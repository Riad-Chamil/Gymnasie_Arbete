<?php

session_start();

require_once __DIR__ . '/../includes/functions.php';

$message = $_SESSION['message'] ?? '';
unset($_SESSION['message']);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sök efter spel</title>
</head>

<body>
    <form method="get" action="search.php">
        <h1>Sök efter spel</h1>

        <input class="textFiled" name="search" type="search" id="search" placeholder="Sök efter spel..."

            value="<?php echo htmlspecialchars($search, ENT_QUOTES, 'UTF-8'); ?>" required>

        <button type="submit">Sök</button>
    </form>
    <?php if ($search !== '' && count($results) === 0): ?>
        <p>Inga meddelanden hittades för: <?php echo htmlspecialchars($search, ENT_QUOTES, 'UTF-8'); ?></p>
    <?php elseif ($search !== ''): ?>
        <table id="dbres">
            <tr>
                <th>Namn</th>
                <th>Meddelande</th>
                <th>Datum</th>
            </tr>
            <?php foreach ($results as $row_Recordset1) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($row_Recordset1['name'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo nl2br(htmlspecialchars($row_Recordset1['message'], ENT_QUOTES, 'UTF-8')); ?></td>
                    <td><?php echo htmlspecialchars($row_Recordset1['time'], ENT_QUOTES, 'UTF-8'); ?></td>
                </tr>
            <?php } ?>
        </table>
    <?php endif; ?>
</body>

</html>