-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  ven. 25 sep. 2020 à 14:49
-- Version du serveur :  10.4.10-MariaDB
-- Version de PHP :  7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `symfonydashboard`
--

-- --------------------------------------------------------

--
-- Structure de la table `book`
--

DROP TABLE IF EXISTS `book`;
CREATE TABLE IF NOT EXISTS `book` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ref` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `buy_price` double NOT NULL,
  `sold_price` double NOT NULL,
  `rent_price` double NOT NULL,
  `stock` int(11) NOT NULL,
  `sold` int(11) NOT NULL,
  `rent` int(11) NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `book`
--

INSERT INTO `book` (`id`, `title`, `ref`, `category`, `photo`, `description`, `buy_price`, `sold_price`, `rent_price`, `stock`, `sold`, `rent`, `updated_at`) VALUES
(1, 'Sorceleur', 'SO1234', 'fantastique', 'livre.jpg', 'Geralt', 500, 800, 300, 5, 0, 0, '2020-09-25 14:18:54');

-- --------------------------------------------------------

--
-- Structure de la table `customer_flow`
--

DROP TABLE IF EXISTS `customer_flow`;
CREATE TABLE IF NOT EXISTS `customer_flow` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `flow_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_6517207A76ED395` (`user_id`),
  KEY `IDX_651720716A2B381` (`book_id`),
  KEY `IDX_65172077EB60D1B` (`flow_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

DROP TABLE IF EXISTS `doctrine_migration_versions`;
CREATE TABLE IF NOT EXISTS `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20200925114904', '2020-09-25 11:49:32', 293),
('DoctrineMigrations\\Version20200925122001', '2020-09-25 12:20:17', 5183),
('DoctrineMigrations\\Version20200925135651', '2020-09-25 13:56:59', 137);

-- --------------------------------------------------------

--
-- Structure de la table `flow`
--

DROP TABLE IF EXISTS `flow`;
CREATE TABLE IF NOT EXISTS `flow` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `book_id` int(11) NOT NULL,
  `buy_date` date DEFAULT NULL,
  `rent_date` date DEFAULT NULL,
  `return_date` date DEFAULT NULL,
  `return_ok` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_52C0D67016A2B381` (`book_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:json)',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8D93D649F85E0677` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `username`, `roles`, `password`, `email`) VALUES
(2, 'yoann', '[\"ROLE_USER\",\"ROLE_ADMIN\"]', '$argon2id$v=19$m=65536,t=4,p=1$LmRJNmZBcW4uZnlRSUZuWQ$hQyDWx9u6+1JLZz19h2ybYANPuy9BFm+0PLqS6V9Qys', 'y.abran@codeur.online'),
(3, 'philippe', '[\"ROLE_USER\",\"ROLE_ADMIN\"]', '$argon2id$v=19$m=65536,t=4,p=1$blRtMWZHL2dOOE9Tb3Rhaw$FdZs3oq7AmhAVVIabEL8D2CpOO8tG5jOYiYbZQx8tFM', 'p.perechodov@codeur.online'),
(4, 'sylvain', '[\"ROLE_USER\",\"ROLE_ADMIN\"]', '$argon2id$v=19$m=65536,t=4,p=1$dFBEelFsUFdFSzlzMEQxcg$RQ40Wgp/UKGHQWx1QpOvmODJSu7LN0vTKUVR0tJ1D+4', 's.thibault@codeur.online');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `customer_flow`
--
ALTER TABLE `customer_flow`
  ADD CONSTRAINT `FK_651720716A2B381` FOREIGN KEY (`book_id`) REFERENCES `book` (`id`),
  ADD CONSTRAINT `FK_65172077EB60D1B` FOREIGN KEY (`flow_id`) REFERENCES `flow` (`id`),
  ADD CONSTRAINT `FK_6517207A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `flow`
--
ALTER TABLE `flow`
  ADD CONSTRAINT `FK_52C0D67016A2B381` FOREIGN KEY (`book_id`) REFERENCES `book` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
