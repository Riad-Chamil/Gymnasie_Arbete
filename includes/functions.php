<?php

require_once __DIR__ . '/../config/db.php';

function LäggSpel($gameName, $releaseDate, $storageSize)
{
    global $forum;

    $sql = "INSERT INTO Spel (Spel_Namn, Utgivningsdatum, LagringStorlek)
            VALUES (:gameName, :releaseDate, :storageSize)";

    $stmt = $forum->prepare($sql);

    $stmt->bindValue(':gameName', $gameName);
    $stmt->bindValue(':releaseDate', $releaseDate);
    $stmt->bindValue(':storageSize', $storageSize);

    return $stmt->execute();
}

function HämtaSpel()
{
    global $forum;

    $sql = "SELECT SpelID, Spel_Namn, Utgivningsdatum, LagringStorlek
            FROM Spel
            ORDER BY Spel_Namn ASC";

    return $forum->query($sql);
}

function SökSpel($search)
{
    global $forum;

    $sql = "SELECT SpelID, Spel_Namn, Utgivningsdatum, LagringStorlek
            FROM Spel
            WHERE Spel_Namn LIKE :search
            ORDER BY Spel_Namn ASC";

    $stmt = $forum->prepare($sql);
    $stmt->bindValue(':search', '%' . $search . '%');
    $stmt->execute();

    return $stmt;
}
