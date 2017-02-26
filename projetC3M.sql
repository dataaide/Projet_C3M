-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Client :  localhost
-- Généré le :  Lun 27 Février 2017 à 00:21
-- Version du serveur :  10.1.21-MariaDB
-- Version de PHP :  7.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `projetC3M`
--
CREATE DATABASE IF NOT EXISTS `projetC3M` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `projetC3M`;

-- --------------------------------------------------------

--
-- Structure de la table `caisse_contact`
--

DROP TABLE IF EXISTS `caisse_contact`;
CREATE TABLE `caisse_contact` (
  `id` int(11) NOT NULL,
  `nomCourt` varchar(255) NOT NULL,
  `nomLong` varchar(1500) NOT NULL,
  `cheminLogo` varchar(1500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `caisse_contact`
--

INSERT INTO `caisse_contact` (`id`, `nomCourt`, `nomLong`, `cheminLogo`) VALUES
(1, 'cardsf', 'Caisse autonome de retraite des chirurgiens dentistes et des sages-femmes', ''),
(2, 'carmf', 'Caisse autonome de retraite des médecins de France', ''),
(3, 'carpimko', 'Caisse autonome de retraite et de prévoyance des infirmiers, masseurs-kinesithérapeutes, pédicures-podologues, orthophonistes et orthoptistes', ''),
(4, 'carpv', 'Caisse autonome de retraites et de prévoyance des vétérinaires', ''),
(5, 'cavamac', 'Caisse d\'allocation vieillesse des agents généraux et des mandataires non salariés de l\'assurance et de la capitalisation', ''),
(6, 'cavec', 'Caisse d\'assurance vieillesse des experts-comptables et des commissaires aux comptes', ''),
(7, 'cavom', 'Caisse d’assurance vieillesse des officiers ministériels, des officiers publics et des compagnies judiciaires', ''),
(8, 'cavp', 'Caisse d\'assurance vieillesse des pharmaciens', ''),
(9, 'cipav', 'Caisse interprofessionnelle de prévoyance et d\'assurance vieillesse', ''),
(10, 'crn', 'Caisse interprofessionnelle de prévoyance et d\'assurance vieillesse', '');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `caisse_contact`
--
ALTER TABLE `caisse_contact`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `caisse_contact`
--
ALTER TABLE `caisse_contact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
