-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  mar. 14 juil. 2020 à 07:04
-- Version du serveur :  10.4.10-MariaDB
-- Version de PHP :  7.4.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `card_manager`
--

-- --------------------------------------------------------

--
-- Structure de la table `cards`
--

DROP TABLE IF EXISTS `cards`;
CREATE TABLE IF NOT EXISTS `cards` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `company` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `telephone` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `cards`
--

INSERT INTO `cards` (`id`, `user_id`, `name`, `company`, `email`, `telephone`) VALUES
(1, 2, 'CardName', 'CompanyName', 'EmailName', 'TelephoneNumber'),
(2, 2, 'CardName2', 'CompanyName', '', ''),
(3, 2, 'CardName3', '', '', ''),
(4, 2, 'test', 'test', 'test@test.fr', '1234'),
(5, 2, 'test', NULL, NULL, NULL),
(6, 2, 'test', NULL, NULL, NULL),
(7, 2, 'test', NULL, NULL, NULL),
(8, NULL, 'azerdsd', 'ezaezae', 'ezaezae@eze.fr', 'zae');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `card_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `card_id` (`card_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `password`, `card_id`) VALUES
(1, 'Ozan', 'YILDIZ', 'ozan.y@outlook.fr', '$2y$10$Gb4zzAezZVgqSBi/0CYiK.RtrQ59bhMdab.5hOwlrAPIAqmjqJROe', NULL),
(2, 'Test', 'test', 'test@test.fr', '$2y$10$ahPJ6SA8lgbLmRGlDWTpGeXRnL0/u1RUleUEPsgEfJk.HMMnvrEbu', 8),
(3, 'testeur', 'testeur2', 'test@test2.fr', '$2y$10$ymiAvuueeZomsV0d3o/opek5blnwHh7ahvsjBeeoaXTghT4ugGLc6', NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
