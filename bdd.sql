-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 22, 2025 at 04:45 PM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bdd`
--

-- --------------------------------------------------------

--
-- Table structure for table `choisir`
--

CREATE TABLE `choisir` (
  `id_spectacle` int NOT NULL,
  `id_visite` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `choisir`
--

INSERT INTO `choisir` (`id_spectacle`, `id_visite`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 2),
(5, 2),
(6, 2);

-- --------------------------------------------------------

--
-- Table structure for table `distance`
--

CREATE TABLE `distance` (
  `id_lieu` int NOT NULL,
  `id_lieu_1` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `distance`
--

INSERT INTO `distance` (`id_lieu`, `id_lieu_1`) VALUES
(1, 2),
(1, 3),
(2, 3),
(1, 4),
(2, 4),
(3, 4),
(1, 5),
(2, 5),
(3, 5),
(4, 5);

-- --------------------------------------------------------

--
-- Table structure for table `etape`
--

CREATE TABLE `etape` (
  `id_etape` int NOT NULL,
  `id_parcours` int NOT NULL,
  `id_seance` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `etape`
--

INSERT INTO `etape` (`id_etape`, `id_parcours`, `id_seance`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 3),
(4, 2, 4),
(5, 2, 5),
(6, 2, 6);

-- --------------------------------------------------------

--
-- Table structure for table `jours`
--

CREATE TABLE `jours` (
  `id_jours` varchar(50) NOT NULL,
  `heure_ouverture` time DEFAULT NULL,
  `heure_fermeture` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `jours`
--

INSERT INTO `jours` (`id_jours`, `heure_ouverture`, `heure_fermeture`) VALUES
('Dimanche', '09:00:00', '19:00:00'),
('Jeudi', '09:00:00', '18:00:00'),
('Lundi', '09:00:00', '18:00:00'),
('Mardi', '09:00:00', '18:00:00'),
('Mercredi', '09:00:00', '18:00:00'),
('Samedi', '09:00:00', '19:00:00'),
('Vendredi', '09:00:00', '18:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `lieu`
--

CREATE TABLE `lieu` (
  `id_lieu` int NOT NULL,
  `coordonnees_gps` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `lieu`
--

INSERT INTO `lieu` (`id_lieu`, `coordonnees_gps`) VALUES
(1, '46.88518782931529, -0.9276887320855931'),
(2, '46.88669612287445, -0.9294564965719844'),
(3, '46.89137498945829, -0.9312802575660718'),
(4, '46.893186511659124, -0.9343510966122666'),
(5, '46.88840506109226, -0.9272163843904809'),
(6, '46.88998620038355, -0.9293387758447051'),
(7, '46.891724093081336, -0.9274840734610365'),
(8, '46.8886923971089, -0.9306423189462162'),
(9, '46.89034213429962, -0.9333567143628533'),
(10, '46.88965952253639, -0.9306581002207169'),
(11, '46.88802610345511, -0.9302565667149741');

-- --------------------------------------------------------

--
-- Table structure for table `parcours`
--

CREATE TABLE `parcours` (
  `id_parcours` int NOT NULL,
  `duree` time DEFAULT NULL,
  `id_visite` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `parcours`
--

INSERT INTO `parcours` (`id_parcours`, `duree`, `id_visite`) VALUES
(1, '04:30:00', 1),
(2, '05:15:00', 2);

-- --------------------------------------------------------

--
-- Table structure for table `seance`
--

CREATE TABLE `seance` (
  `id_seance` int NOT NULL,
  `heure_debut` time DEFAULT NULL,
  `heure_fin` time DEFAULT NULL,
  `id_spectacle` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `seance`
--

INSERT INTO `seance` (`id_seance`, `heure_debut`, `heure_fin`, `id_spectacle`) VALUES
(1, '10:30:00', '11:15:00', 1),
(2, '11:45:00', '12:20:00', 2),
(3, '13:00:00', '13:40:00', 3),
(4, '14:30:00', '15:20:00', 4),
(5, '16:00:00', '16:30:00', 5),
(6, '17:00:00', '17:25:00', 6),
(7, '21:30:00', '23:20:00', 7),
(8, '10:00:00', '10:20:00', 8),
(9, '11:30:00', '12:00:00', 9),
(10, '14:00:00', '14:15:00', 10),
(11, '15:30:00', '15:50:00', 11);

-- --------------------------------------------------------

--
-- Table structure for table `spectacle`
--

CREATE TABLE `spectacle` (
  `id_spectacle` int NOT NULL,
  `libelle` varchar(50) NOT NULL,
  `duree_spectacle` time NOT NULL,
  `duree_attente` time NOT NULL,
  `id_lieu` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `spectacle`
--

INSERT INTO `spectacle` (`id_spectacle`, `libelle`, `duree_spectacle`, `duree_attente`, `id_lieu`) VALUES
(1, 'Le Signe du Triomphe', '00:45:00', '00:30:00', 1),
(2, 'Les Vikings', '00:35:00', '00:25:00', 2),
(3, 'Le Secret de la Lance', '00:40:00', '00:20:00', 3),
(4, 'Mousquetaire de Richelieu', '00:50:00', '00:35:00', 4),
(5, 'Le Bal des Oiseaux Fantômes', '00:30:00', '00:20:00', 5),
(6, 'Les Noces de Feu', '00:25:00', '00:15:00', 6),
(7, 'La Cinéscénie', '01:50:00', '00:45:00', 7),
(8, 'Le Premier Royaume', '00:20:00', '00:15:00', 8),
(9, 'Le Dernier Panache', '00:30:00', '00:20:00', 9),
(10, 'Les Amoureux de Verdun', '00:15:00', '00:10:00', 10),
(11, 'Le Mystère de La Pérouse', '00:20:00', '00:15:00', 11);

-- --------------------------------------------------------

--
-- Table structure for table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `id_utilisateur` int NOT NULL,
  `email` varchar(50) NOT NULL,
  `mot_de_passe` varchar(255) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `type_profil` varchar(50) NOT NULL,
  `vitesse_marche` decimal(15,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `utilisateur`
--

INSERT INTO `utilisateur` (`id_utilisateur`, `email`, `mot_de_passe`, `nom`, `prenom`, `type_profil`, `vitesse_marche`) VALUES
(1, 'admin@puydufou.com', 'admin123', 'Dupont', 'Pierre', 'admin', '4.50'),
(2, 'user1@gmail.com', 'user123', 'Martin', 'Sophie', 'user', '3.80'),
(3, 'user2@hotmail.com', 'user456', 'Bernard', 'Luc', 'user', '4.20'),
(4, 'ewenevin0@gmail.com', '$2y$10$4MgJjWOc26iywjX3jqmpve.BXttAFtbSdkjesshqVTLPfPjrTTtkm', 'Evin', 'Ewen', 'admin', '6.00');

-- --------------------------------------------------------

--
-- Table structure for table `visite`
--

CREATE TABLE `visite` (
  `id_visite` int NOT NULL,
  `date_` date DEFAULT NULL,
  `id_utilisateur` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `visite`
--

INSERT INTO `visite` (`id_visite`, `date_`, `id_utilisateur`) VALUES
(1, '2024-06-15', 2),
(2, '2024-06-16', 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `choisir`
--
ALTER TABLE `choisir`
  ADD PRIMARY KEY (`id_spectacle`,`id_visite`),
  ADD KEY `id_visite` (`id_visite`);

--
-- Indexes for table `distance`
--
ALTER TABLE `distance`
  ADD PRIMARY KEY (`id_lieu`,`id_lieu_1`),
  ADD KEY `id_lieu_1` (`id_lieu_1`);

--
-- Indexes for table `etape`
--
ALTER TABLE `etape`
  ADD PRIMARY KEY (`id_etape`),
  ADD KEY `id_parcours` (`id_parcours`),
  ADD KEY `id_seance` (`id_seance`);

--
-- Indexes for table `jours`
--
ALTER TABLE `jours`
  ADD PRIMARY KEY (`id_jours`);

--
-- Indexes for table `lieu`
--
ALTER TABLE `lieu`
  ADD PRIMARY KEY (`id_lieu`);

--
-- Indexes for table `parcours`
--
ALTER TABLE `parcours`
  ADD PRIMARY KEY (`id_parcours`),
  ADD KEY `id_visite` (`id_visite`);

--
-- Indexes for table `seance`
--
ALTER TABLE `seance`
  ADD PRIMARY KEY (`id_seance`),
  ADD KEY `id_spectacle` (`id_spectacle`);

--
-- Indexes for table `spectacle`
--
ALTER TABLE `spectacle`
  ADD PRIMARY KEY (`id_spectacle`),
  ADD KEY `id_lieu` (`id_lieu`);

--
-- Indexes for table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`id_utilisateur`);

--
-- Indexes for table `visite`
--
ALTER TABLE `visite`
  ADD PRIMARY KEY (`id_visite`),
  ADD KEY `id_utilisateur` (`id_utilisateur`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `etape`
--
ALTER TABLE `etape`
  MODIFY `id_etape` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `lieu`
--
ALTER TABLE `lieu`
  MODIFY `id_lieu` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `parcours`
--
ALTER TABLE `parcours`
  MODIFY `id_parcours` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `seance`
--
ALTER TABLE `seance`
  MODIFY `id_seance` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `spectacle`
--
ALTER TABLE `spectacle`
  MODIFY `id_spectacle` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `id_utilisateur` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `visite`
--
ALTER TABLE `visite`
  MODIFY `id_visite` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `choisir`
--
ALTER TABLE `choisir`
  ADD CONSTRAINT `choisir_ibfk_1` FOREIGN KEY (`id_spectacle`) REFERENCES `spectacle` (`id_spectacle`),
  ADD CONSTRAINT `choisir_ibfk_2` FOREIGN KEY (`id_visite`) REFERENCES `visite` (`id_visite`);

--
-- Constraints for table `distance`
--
ALTER TABLE `distance`
  ADD CONSTRAINT `distance_ibfk_1` FOREIGN KEY (`id_lieu`) REFERENCES `lieu` (`id_lieu`),
  ADD CONSTRAINT `distance_ibfk_2` FOREIGN KEY (`id_lieu_1`) REFERENCES `lieu` (`id_lieu`);

--
-- Constraints for table `etape`
--
ALTER TABLE `etape`
  ADD CONSTRAINT `etape_ibfk_1` FOREIGN KEY (`id_parcours`) REFERENCES `parcours` (`id_parcours`),
  ADD CONSTRAINT `etape_ibfk_2` FOREIGN KEY (`id_seance`) REFERENCES `seance` (`id_seance`);

--
-- Constraints for table `parcours`
--
ALTER TABLE `parcours`
  ADD CONSTRAINT `parcours_ibfk_1` FOREIGN KEY (`id_visite`) REFERENCES `visite` (`id_visite`);

--
-- Constraints for table `seance`
--
ALTER TABLE `seance`
  ADD CONSTRAINT `seance_ibfk_1` FOREIGN KEY (`id_spectacle`) REFERENCES `spectacle` (`id_spectacle`);

--
-- Constraints for table `spectacle`
--
ALTER TABLE `spectacle`
  ADD CONSTRAINT `spectacle_ibfk_1` FOREIGN KEY (`id_lieu`) REFERENCES `lieu` (`id_lieu`);

--
-- Constraints for table `visite`
--
ALTER TABLE `visite`
  ADD CONSTRAINT `visite_ibfk_1` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateur` (`id_utilisateur`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
