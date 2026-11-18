<?php

require_once __DIR__ . '/../config/db.php';

function LäggSpel($gameName, $releaseDate, $storageSize, $storageUnit)
{
    global $forum;

    $sql = "INSERT INTO Spel
            (Spel_Namn, Utgivningsdatum, LagringStorlek, LagringsEnhet)
            VALUES
            (:gameName, :releaseDate, :storageSize, :storageUnit)";

    $stmt = $forum->prepare($sql);

    $stmt->bindValue(':gameName', $gameName);
    $stmt->bindValue(':releaseDate', $releaseDate);
    $stmt->bindValue(':storageSize', $storageSize);
    $stmt->bindValue(':storageUnit', $storageUnit);

    return $stmt->execute();
}

function HämtaSpel()
{
    global $forum;

    $sql = "SELECT SpelID, Spel_Namn, Utgivningsdatum,
                   LagringStorlek, LagringsEnhet
            FROM Spel
            ORDER BY Spel_Namn ASC";

    return $forum->query($sql);
}

function SökSpel($search)
{
    global $forum;

    $sql = "SELECT SpelID, Spel_Namn, Utgivningsdatum,
                   LagringStorlek, LagringsEnhet
            FROM Spel
            WHERE Spel_Namn LIKE :search
            ORDER BY Spel_Namn ASC";

    $stmt = $forum->prepare($sql);
    $stmt->bindValue(':search', '%' . $search . '%');
    $stmt->execute();

    return $stmt;
}
