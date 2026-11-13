<?php

require_once __DIR__ . '/../config/db.php';

function LäggSpel($gameName)
{
    global $forum;

    $sql = "INSERT INTO Spel (Spel_Namn)
            VALUES (:gameName)";

    $stmt = $forum->prepare($sql);
    $stmt->bindValue(':gameName', $gameName);

    return $stmt->execute();
}

function HämtaSpel()
{
    global $forum;

    $sql = "SELECT SpelID, Spel_Namn
            FROM Spel
            ORDER BY Spel_Namn ASC";

    return $forum->query($sql);
}

function SökSpel($search)
{
    global $forum;

    $sql = "SELECT SpelID, Spel_Namn
            FROM Spel
            WHERE Spel_Namn LIKE :search
            ORDER BY Spel_Namn ASC";

    $stmt = $forum->prepare($sql);
    $stmt->bindValue(':search', '%' . $search . '%');
    $stmt->execute();

    return $stmt;
}