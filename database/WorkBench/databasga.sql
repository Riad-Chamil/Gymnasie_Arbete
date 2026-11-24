-- phpMyAdmin SQL Dump
-- version 5.2.3deb1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 24, 2026 at 01:17 PM
-- Server version: 8.4.13-0ubuntu0.26.04.2
-- PHP Version: 8.5.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `databasga`
--

-- --------------------------------------------------------

--
-- Table structure for table `Användare`
--

CREATE TABLE `Användare` (
  `AnvändareID` int NOT NULL,
  `AnvändareSmekNamn` varchar(50) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `LösenordHash` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Användares_Spel`
--

CREATE TABLE `Användares_Spel` (
  `AnvändaresID` int NOT NULL,
  `Spel_ID` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Media`
--

CREATE TABLE `Media` (
  `MediaID` int NOT NULL,
  `SpelID` int NOT NULL,
  `TypAvMedia` varchar(45) NOT NULL,
  `Filevag` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Spel`
--

CREATE TABLE `Spel` (
  `SpelID` int NOT NULL,
  `LagringStorlek` text,
  `Utgivningsdatum` date NOT NULL,
  `Spel_Namn` varchar(255) NOT NULL,
  `LagringsEnhet` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `Spel`
--

INSERT INTO `Spel` (`SpelID`, `LagringStorlek`, `Utgivningsdatum`, `Spel_Namn`, `LagringsEnhet`) VALUES
(1, '65', '2011-11-18', 'Minecraft', 'GB');

-- --------------------------------------------------------

--
-- Table structure for table `Spels_recension`
--

CREATE TABLE `Spels_recension` (
  `RecensionID` int NOT NULL,
  `AnvändareID` int NOT NULL,
  `SpelID` int NOT NULL,
  `Recension` text,
  `stjärnor` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Användare`
--
ALTER TABLE `Användare`
  ADD PRIMARY KEY (`AnvändareID`),
  ADD UNIQUE KEY `UQ_Anvandare_Email` (`Email`);

--
-- Indexes for table `Användares_Spel`
--
ALTER TABLE `Användares_Spel`
  ADD PRIMARY KEY (`AnvändaresID`,`Spel_ID`),
  ADD KEY `IX_AnvandaresSpel_Spel` (`Spel_ID`);

--
-- Indexes for table `Media`
--
ALTER TABLE `Media`
  ADD PRIMARY KEY (`MediaID`),
  ADD KEY `IX_Media_Spel` (`SpelID`);

--
-- Indexes for table `Spel`
--
ALTER TABLE `Spel`
  ADD PRIMARY KEY (`SpelID`);

--
-- Indexes for table `Spels_recension`
--
ALTER TABLE `Spels_recension`
  ADD PRIMARY KEY (`RecensionID`),
  ADD UNIQUE KEY `UQ_Recension_Anvandare_Spel` (`AnvändareID`,`SpelID`),
  ADD KEY `IX_Recension_Spel` (`SpelID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Användare`
--
ALTER TABLE `Användare`
  MODIFY `AnvändareID` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Media`
--
ALTER TABLE `Media`
  MODIFY `MediaID` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Spel`
--
ALTER TABLE `Spel`
  MODIFY `SpelID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `Spels_recension`
--
ALTER TABLE `Spels_recension`
  MODIFY `RecensionID` int NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Användares_Spel`
--
ALTER TABLE `Användares_Spel`
  ADD CONSTRAINT `FK_AnvandaresSpel_Anvandare` FOREIGN KEY (`AnvändaresID`) REFERENCES `Användare` (`AnvändareID`),
  ADD CONSTRAINT `FK_AnvandaresSpel_Spel` FOREIGN KEY (`Spel_ID`) REFERENCES `Spel` (`SpelID`);

--
-- Constraints for table `Media`
--
ALTER TABLE `Media`
  ADD CONSTRAINT `FK_Media_Spel` FOREIGN KEY (`SpelID`) REFERENCES `Spel` (`SpelID`);

--
-- Constraints for table `Spels_recension`
--
ALTER TABLE `Spels_recension`
  ADD CONSTRAINT `FK_Recension_Anvandare` FOREIGN KEY (`AnvändareID`) REFERENCES `Användare` (`AnvändareID`),
  ADD CONSTRAINT `FK_Recension_Spel` FOREIGN KEY (`SpelID`) REFERENCES `Spel` (`SpelID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
