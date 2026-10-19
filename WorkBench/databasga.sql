-- Schema matching WorkBench/databasga.mwb.
-- Photos and clips are stored on the web server; Media.Filevag stores their path.
-- Validate ratings (1-5), media types and uploads in PHP.
-- This file creates a fresh schema structure; it does not migrate an existing database.

CREATE DATABASE IF NOT EXISTS `databasga`
  DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `databasga`;

CREATE TABLE `Användare` (
  `AnvändareID` INT NOT NULL AUTO_INCREMENT,
  `AnvändareSmekNamn` VARCHAR(50) NOT NULL,
  `Email` VARCHAR(255) NOT NULL,
  `LösenordHash` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`AnvändareID`),
  UNIQUE KEY `idx_email` (`Email`)
) ENGINE=InnoDB DEFAULT CHARACTER SET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `Spel` (
  `SpelID` INT NOT NULL AUTO_INCREMENT,
  `Datum` VARCHAR(255) NULL,
  `LagringStorlek` TEXT NULL,
  `Utgivningsdatum` DATE NOT NULL,
  `Spel_Namn` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`SpelID`)
) ENGINE=InnoDB DEFAULT CHARACTER SET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `Användares_Spel` (
  `AnvändaresID` INT NOT NULL,
  `Spel_ID` INT NOT NULL,
  PRIMARY KEY (`AnvändaresID`, `Spel_ID`),
  KEY `IX_AnvandaresSpel_Spel` (`Spel_ID`),
  CONSTRAINT `FK_AnvandaresSpel_Anvandare`
    FOREIGN KEY (`AnvändaresID`)
    REFERENCES `Användare` (`AnvändareID`)
    ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `FK_AnvandaresSpel_Spel`
    FOREIGN KEY (`Spel_ID`)
    REFERENCES `Spel` (`SpelID`)
    ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARACTER SET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `Media` (
  `MediaID` INT NOT NULL AUTO_INCREMENT,
  `SpelID` INT NOT NULL,
  `TypAvMedia` VARCHAR(45) NOT NULL,
  `Filevag` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`MediaID`),
  KEY `IX_Media_Spel` (`SpelID`),
  CONSTRAINT `FK_Media_Spel`
    FOREIGN KEY (`SpelID`)
    REFERENCES `Spel` (`SpelID`)
    ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARACTER SET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `Spels_recension` (
  `RecensionID` INT NOT NULL AUTO_INCREMENT,
  `AnvändareID` INT NOT NULL,
  `SpelID` INT NOT NULL,
  `Recension` TEXT NULL,
  `stjärnor` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`RecensionID`),
  UNIQUE KEY `UQ_Recension_Anvandare_Spel` (`AnvändareID`, `SpelID`),
  KEY `IX_Recension_Spel` (`SpelID`),
  CONSTRAINT `FK_Recension_Anvandare`
    FOREIGN KEY (`AnvändareID`)
    REFERENCES `Användare` (`AnvändareID`)
    ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `FK_Recension_Spel`
    FOREIGN KEY (`SpelID`)
    REFERENCES `Spel` (`SpelID`)
    ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARACTER SET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
