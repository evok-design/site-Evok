-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  mar. 09 avr. 2019 à 09:37
-- Version du serveur :  5.7.24
-- Version de PHP :  7.2.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `evokdesign`
--

-- --------------------------------------------------------

--
-- Structure de la table `actualites`
--

DROP TABLE IF EXISTS `actualites`;
CREATE TABLE IF NOT EXISTS `actualites` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `slider_id` int(11) DEFAULT NULL,
  `titre` varchar(255) COLLATE utf8_general_ci NOT NULL,
  `date` datetime NOT NULL,
  `contenu` longtext COLLATE utf8_general_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_general_ci NOT NULL,
  `img_prev` varchar(255) COLLATE utf8_general_ci NOT NULL,
  `img_header` varchar(255) COLLATE utf8_general_ci NOT NULL,
  `img_content` varchar(255) COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_75315B6D989D9B62` (`slug`),
  UNIQUE KEY `UNIQ_75315B6D2CCC9638` (`slider_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `bloc`
--

DROP TABLE IF EXISTS `bloc`;
CREATE TABLE IF NOT EXISTS `bloc` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(255) COLLATE utf8_general_ci NOT NULL,
  `image` varchar(255) COLLATE utf8_general_ci DEFAULT NULL,
  `img_header` varchar(255) COLLATE utf8_general_ci NOT NULL,
  `description1` longtext COLLATE utf8_general_ci NOT NULL,
  `img_content1` varchar(255) COLLATE utf8_general_ci NOT NULL,
  `description2` longtext COLLATE utf8_general_ci,
  `img_content2` varchar(255) COLLATE utf8_general_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_C778955A989D9B62` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `bloc_categorie`
--

DROP TABLE IF EXISTS `bloc_categorie`;
CREATE TABLE IF NOT EXISTS `bloc_categorie` (
  `bloc_id` int(11) NOT NULL,
  `categorie_id` int(11) NOT NULL,
  PRIMARY KEY (`bloc_id`,`categorie_id`),
  KEY `IDX_5CDA4DF95582E9C0` (`bloc_id`),
  KEY `IDX_5CDA4DF9BCF5E72D` (`categorie_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

DROP TABLE IF EXISTS `categorie`;
CREATE TABLE IF NOT EXISTS `categorie` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(255) COLLATE utf8_general_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_497DD634989D9B62` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

DROP TABLE IF EXISTS `client`;
CREATE TABLE IF NOT EXISTS `client` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `creation`
--

DROP TABLE IF EXISTS `creation`;
CREATE TABLE IF NOT EXISTS `creation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(11) NOT NULL,
  `slider_id` int(11) DEFAULT NULL,
  `title` varchar(255) COLLATE utf8_general_ci NOT NULL,
  `description` longtext COLLATE utf8_general_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_general_ci NOT NULL,
  `image1` varchar(255) COLLATE utf8_general_ci NOT NULL,
  `image2` varchar(255) COLLATE utf8_general_ci NOT NULL,
  `image_header` varchar(255) COLLATE utf8_general_ci NOT NULL,
  `image_content` varchar(255) COLLATE utf8_general_ci DEFAULT NULL,
  `description2` longtext COLLATE utf8_general_ci,
  `image_corps_2` varchar(255) COLLATE utf8_general_ci DEFAULT NULL,
  `img_big_nb` varchar(255) COLLATE utf8_general_ci NOT NULL,
  `img_small_nb` varchar(255) COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_57EE8574989D9B62` (`slug`),
  UNIQUE KEY `UNIQ_57EE85742CCC9638` (`slider_id`),
  KEY `IDX_57EE857419EB6921` (`client_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `creation_categorie`
--

DROP TABLE IF EXISTS `creation_categorie`;
CREATE TABLE IF NOT EXISTS `creation_categorie` (
  `creation_id` int(11) NOT NULL,
  `categorie_id` int(11) NOT NULL,
  PRIMARY KEY (`creation_id`,`categorie_id`),
  KEY `IDX_A7A9F7A134FFA69A` (`creation_id`),
  KEY `IDX_A7A9F7A1BCF5E72D` (`categorie_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `slide`
--

DROP TABLE IF EXISTS `slide`;
CREATE TABLE IF NOT EXISTS `slide` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `slider_id` int(11) DEFAULT NULL,
  `url_image` varchar(255) COLLATE utf8_general_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_general_ci NOT NULL,
  `tabindex` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_72EFEE622CCC9638` (`slider_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `slider`
--

DROP TABLE IF EXISTS `slider`;
CREATE TABLE IF NOT EXISTS `slider` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--


--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `actualites`
--
ALTER TABLE `actualites`
  ADD CONSTRAINT `FK_75315B6D2CCC9638` FOREIGN KEY (`slider_id`) REFERENCES `slider` (`id`);

--
-- Contraintes pour la table `bloc_categorie`
--
ALTER TABLE `bloc_categorie`
  ADD CONSTRAINT `FK_5CDA4DF95582E9C0` FOREIGN KEY (`bloc_id`) REFERENCES `bloc` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_5CDA4DF9BCF5E72D` FOREIGN KEY (`categorie_id`) REFERENCES `categorie` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `creation`
--
ALTER TABLE `creation`
  ADD CONSTRAINT `FK_57EE857419EB6921` FOREIGN KEY (`client_id`) REFERENCES `client` (`id`),
  ADD CONSTRAINT `FK_57EE85742CCC9638` FOREIGN KEY (`slider_id`) REFERENCES `slider` (`id`);

--
-- Contraintes pour la table `creation_categorie`
--
ALTER TABLE `creation_categorie`
  ADD CONSTRAINT `FK_A7A9F7A134FFA69A` FOREIGN KEY (`creation_id`) REFERENCES `creation` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_A7A9F7A1BCF5E72D` FOREIGN KEY (`categorie_id`) REFERENCES `categorie` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `slide`
--
ALTER TABLE `slide`
  ADD CONSTRAINT `FK_72EFEE622CCC9638` FOREIGN KEY (`slider_id`) REFERENCES `slider` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
