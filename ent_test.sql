-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : sam. 06 jan. 2024 à 00:45
-- Version du serveur : 8.0.31
-- Version de PHP : 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `ent_test`
--

-- --------------------------------------------------------

--
-- Structure de la table `matieres`
--

DROP TABLE IF EXISTS `matieres`;
CREATE TABLE IF NOT EXISTS `matieres` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `matieres`
--

INSERT INTO `matieres` (`id`, `nom`) VALUES
(1, 'intégration'),
(2, 'développement front'),
(3, 'développement back'),
(4, 'marketing'),
(5, 'culture numérique');

-- --------------------------------------------------------

--
-- Structure de la table `messages`
--

DROP TABLE IF EXISTS `messages`;
CREATE TABLE IF NOT EXISTS `messages` (
  `message_id` int NOT NULL AUTO_INCREMENT,
  `sender` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `recipient_type` varchar(20) NOT NULL DEFAULT 'eleve',
  `recipient_name` varchar(100) DEFAULT NULL,
  `objet` varchar(255) DEFAULT NULL,
  `subject` varchar(255) NOT NULL,
  `attachment_path` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`message_id`)
) ENGINE=MyISAM AUTO_INCREMENT=148 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `messages`
--

INSERT INTO `messages` (`message_id`, `sender`, `message`, `timestamp`, `recipient_type`, `recipient_name`, `objet`, `subject`, `attachment_path`) VALUES
(144, 'maria', 'D\'accord, voici le code mis à jour avec les modifications nécessaires pour garantir que l\'utilisateur voit seulement SES messages. N\'oubliez pas d\'ajuster votre connexion à la base de données (connexion.php) et de vérifier si vos chemins d\'inclusion et de redirection correspondent à votre structure de fichiers.\r\n\r\n', '2024-01-06 00:15:50', 'specific', 'toto', 'salut toto', 'salut toto', 'uploads/Diego Toda de Oliveira.jpg'),
(145, 'massé', 'whatsup', '2024-01-06 00:16:56', 'all', NULL, 'hi every body', 'hi every body', NULL),
(146, 'alisson', 'Le code que vous avez partagé utilise la variable $resultCurrentMessage pour stocker le résultat de la requête SQL qui récupère les détails du message actuel. Vous pouvez utiliser cette variable pour accéder aux données du message actuel et les afficher.\r\n\r\nPar exemple, dans votre code actuel, après la ligne où vous avez extrait les données du message actuel à partir de la base de données, vous pouvez utiliser les propriétés de cette variable pour afficher les informations du message dans votre HTML. Voici un exemple de continuation du code:', '2024-01-06 00:18:20', 'all', NULL, 'l\'arrive d\'alisson', 'l\'arrive d\'alisson', NULL),
(147, 'alisson', 'how are you doing', '2024-01-06 00:18:42', 'specific', 'carla', 'hey people', 'hey people', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `type` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'eleve',
  `matiere` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `profil` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `nom`, `password`, `type`, `matiere`, `profil`) VALUES
(1, 'toto', '$2y$10$cA0YEwiNATyCiIT6jyjr8eTbw3RmjWT.rbV/vdRcF0g95QqAvA9sG', 'eleve', 'null', 'uploads/default.jpg'),
(2, 'maria', '$2y$10$XwweWyrkxKfFoZ/NrphAZe4T/yHCY0.q4AVyK9paXsQ98UgWp/o.i', 'prof', 'développement front', 'uploads/default.jpg'),
(4, 'carla', '$2y$10$.PsMN7qM5DCx/UA7q6Pa/.yN1oulXOV9PHG54GI61zrUnVo9ZCbHy', 'eleve', 'null', 'uploads/default.jpg'),
(5, 'titi', '$2y$10$zSJy3lTaB/GQ2S8jBqNXLeb768BTwX.7668DFH.CO5KsQb8IUjiAG', 'prof', 'culture numérique', 'uploads/default.jpg'),
(6, 'thomas', '$2y$10$5UefHPML.zdA3GWQTNbcCuSrPlbtn.2dpVUIYlTVqmzU342jhbTi.', 'eleve', 'null', 'uploads/default.jpg'),
(7, 'admin', '$2y$10$tCMeEV5CaktMh8gtgLpmEOUdvvm6qKmE1G9ew8Ig3m/Qa8QRXsSR6', 'admin', 'null', 'uploads/default.jpg'),
(9, 'Tania', '$2y$10$tPsUl4N.JK/40n40x.MOtO2RXPwi91FhxdsHLwU7rwCUL2/7BGO8O', 'prof', 'marketing', 'uploads/default.jpg'),
(10, 'masse', '$2y$10$syo4U/vJDcUWoADxsH8zk.gtYACGNyBNbbFegKfDYKiE9JhRZeb/S', 'prof', 'développement back', ''),
(11, 'alisson', '$2y$10$HmDwMb/4F1vRFmRMGEEfEuK5liOP2.F4WidTYiSD4ebC9W6JXvhaq', 'prof', 'culture numérique', '');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
