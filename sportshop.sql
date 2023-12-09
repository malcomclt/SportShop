-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : sam. 09 déc. 2023 à 01:57
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
-- Base de données : `sportshop`
--

-- --------------------------------------------------------

--
-- Structure de la table `articles`
--

DROP TABLE IF EXISTS `articles`;
CREATE TABLE IF NOT EXISTS `articles` (
  `id_art` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(20) NOT NULL,
  `quantite` int NOT NULL,
  `prix` float NOT NULL,
  `url_photo` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `description` text NOT NULL,
  `ID_STRIPE` varchar(150) NOT NULL,
  PRIMARY KEY (`id_art`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `articles`
--

INSERT INTO `articles` (`id_art`, `nom`, `quantite`, `prix`, `url_photo`, `description`, `ID_STRIPE`) VALUES
(1, 'Maillot PandaBasket', 0, 20, '../images/maillot-panda.jpg', 'Equipe PandaBasket,Coupe Standard,100% coton', 'price_1OJ1DZGUqrjEgW3AlhYou30c'),
(2, 'Short PandaBasket', 14, 30, '../images/short-panda.jpg', 'Equipe PandaBasket,Coupe Standard,100% coton', 'price_1OJ1DwGUqrjEgW3AgVJ6GMpA'),
(3, 'Basket', 14, 150, '../images/short-panda.jpg', 'Jordan 1,\r\nBlanche et Noir', 'price_1OJ1EKGUqrjEgW3AEH7yEQUy'),
(4, 'Chaussettes', 20, 5, '../images/maillot-panda.jpg', 'blanche,longue,double epaisseur', 'price_1OJ1F3GUqrjEgW3Agcgs2qdL');

-- --------------------------------------------------------

--
-- Structure de la table `clients`
--

DROP TABLE IF EXISTS `clients`;
CREATE TABLE IF NOT EXISTS `clients` (
  `id_client` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `adresse` text NOT NULL,
  `numero` int NOT NULL,
  `mail` varchar(50) NOT NULL,
  `mdp` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `ID_STRIPE` varchar(150) NOT NULL,
  PRIMARY KEY (`id_client`)
) ENGINE=MyISAM AUTO_INCREMENT=51 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `clients`
--

INSERT INTO `clients` (`id_client`, `nom`, `prenom`, `adresse`, `numero`, `mail`, `mdp`, `ID_STRIPE`) VALUES
(50, 'toto', 'toto', 'toto', 2147483647, 'test@test.com', '$2y$10$svyziGaytBfd0kf190dGq.pxDYSxPKT.o9NBwm8/.yAq8rudC1aZ6', 'cus_P9YiGfohdoXCsx'),
(49, 'CARLET', 'Malcom', '8 RUE DES TAMARIS', 2147483647, 'malcomclt@gmail.com', '$2y$10$8XTr965xLbAujuIo1cyJyegKZSkX20OO9wfNQ1pc9CcBI2j67spdm', 'cus_P9YOlIbQEJbT6w');

-- --------------------------------------------------------

--
-- Structure de la table `commandes`
--

DROP TABLE IF EXISTS `commandes`;
CREATE TABLE IF NOT EXISTS `commandes` (
  `id_commande` int NOT NULL AUTO_INCREMENT,
  `id_art` int NOT NULL,
  `id_client` int NOT NULL,
  `quantite` int NOT NULL,
  `envoi` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_commande`),
  KEY `id_art` (`id_art`),
  KEY `id_client` (`id_client`)
) ENGINE=MyISAM AUTO_INCREMENT=52 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `commandes`
--

INSERT INTO `commandes` (`id_commande`, `id_art`, `id_client`, `quantite`, `envoi`) VALUES
(1, 2, 5, 2, 0),
(2, 1, 9, 10, 0),
(3, 2, 9, 2, 0),
(4, 2, 9, 2, 0),
(5, 3, 9, 20, 0),
(6, 4, 9, 4, 0),
(7, 4, 9, 2, 0),
(8, 1, 36, 2, 0),
(9, 4, 37, 2, 0),
(10, 2, 37, 1, 0),
(11, 1, 37, 1, 0),
(12, 1, 37, 2, 0),
(13, 1, 36, 1, 0),
(14, 1, 37, 6, 0),
(15, 1, 37, 1, 0),
(16, 3, 37, 1, 0),
(17, 3, 37, 1, 0),
(18, 2, 37, 1, 0),
(19, 1, 37, 1, 0),
(20, 3, 37, 1, 0),
(21, 3, 37, 1, 0),
(22, 2, 37, 1, 0),
(23, 1, 37, 1, 0),
(24, 3, 37, 1, 0),
(25, 3, 37, 1, 0),
(26, 2, 37, 1, 0),
(27, 1, 37, 1, 0),
(28, 2, 37, 1, 0),
(29, 2, 37, 1, 0),
(30, 1, 37, 1, 0),
(31, 2, 37, 1, 0),
(32, 3, 37, 1, 0),
(33, 2, 37, 1, 0),
(34, 1, 37, 1, 0),
(35, 2, 37, 1, 0),
(36, 3, 37, 1, 0),
(37, 2, 37, 1, 0),
(38, 2, 37, 1, 0),
(39, 2, 37, 1, 0),
(40, 2, 42, 8, 0),
(41, 3, 42, 8, 0),
(42, 1, 42, 82, 0),
(43, 2, 42, 180, 0),
(44, 3, 42, 10, 0),
(45, 1, 42, 20, 0),
(46, 2, 48, 4, 0),
(47, 3, 48, 4, 0),
(48, 1, 48, 20, 0),
(49, 2, 50, 2, 0),
(50, 3, 50, 2, 0),
(51, 1, 50, 20, 0);

-- --------------------------------------------------------

--
-- Structure de la table `messages`
--

DROP TABLE IF EXISTS `messages`;
CREATE TABLE IF NOT EXISTS `messages` (
  `id_message` int NOT NULL AUTO_INCREMENT,
  `id_client` int DEFAULT NULL,
  `content` text,
  `date_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id_message`),
  KEY `id_client` (`id_client`)
) ENGINE=MyISAM AUTO_INCREMENT=44 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `messages`
--

INSERT INTO `messages` (`id_message`, `id_client`, `content`, `date_time`) VALUES
(41, 50, 'Salut', '2023-12-09 02:48:03'),
(43, 50, 'Ca fait longtemps ', '2023-12-09 02:48:27'),
(42, 49, 'Coucou', '2023-12-09 02:48:08');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
