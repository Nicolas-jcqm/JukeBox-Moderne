-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Client :  127.0.0.1
-- Généré le :  Lun 19 Février 2018 à 14:11
-- Version du serveur :  5.7.14
-- Version de PHP :  7.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `jukebox`
--

-- --------------------------------------------------------

--
-- Structure de la table `administrator`
--

CREATE TABLE `administrator` (
  `mail` varchar(100) NOT NULL,
  `password` varchar(500) NOT NULL,
  `firstName` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `artist`
--

CREATE TABLE `artist` (
  `idArtist` int(11) NOT NULL,
  `nameArtist` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `jukebox`
--

CREATE TABLE `jukebox` (
  `idJukebox` int(11) NOT NULL,
  `nameJukebox` varchar(100) NOT NULL,
  `tokenJukebox` varchar(500) NOT NULL,
  `administratorJukebox` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `kind`
--

CREATE TABLE `kind` (
  `idKind` int(11) NOT NULL,
  `nameKind` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `playlist`
--

CREATE TABLE `playlist` (
  `idPlaylist` int(11) NOT NULL,
  `namePlaylist` varchar(100) NOT NULL,
  `durationPlaylist` float NOT NULL,
  `descriptionPlaylist` varchar(500) NOT NULL,
  `idJukebox` int(11) NOT NULL,
  `idKind` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `playlisttrack`
--

CREATE TABLE `playlisttrack` (
  `idPlaylist` int(11) NOT NULL,
  `idTrack` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `track`
--

CREATE TABLE `track` (
  `idTrack` int(11) NOT NULL,
  `titleTrack` varchar(100) NOT NULL,
  `durationTrack` float NOT NULL,
  `descriptionTrack` varchar(500) NOT NULL,
  `scoreTrack` float NOT NULL,
  `yearTrack` int(4) NOT NULL,
  `pictureTrack` varchar(100) NOT NULL,
  `idArtist` int(11) NOT NULL,
  `idKind` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Index pour les tables exportées
--

--
-- Index pour la table `administrator`
--
ALTER TABLE `administrator`
  ADD PRIMARY KEY (`mail`);

--
-- Index pour la table `artist`
--
ALTER TABLE `artist`
  ADD PRIMARY KEY (`idArtist`);

--
-- Index pour la table `jukebox`
--
ALTER TABLE `jukebox`
  ADD PRIMARY KEY (`idJukebox`),
  ADD KEY `jukebox_ctrtAdministrator` (`administratorJukebox`);

--
-- Index pour la table `kind`
--
ALTER TABLE `kind`
  ADD PRIMARY KEY (`idKind`);

--
-- Index pour la table `playlist`
--
ALTER TABLE `playlist`
  ADD PRIMARY KEY (`idPlaylist`),
  ADD KEY `playlist_ctrtJukebox` (`idJukebox`),
  ADD KEY `playlist_ctrtKind` (`idKind`);

--
-- Index pour la table `playlisttrack`
--
ALTER TABLE `playlisttrack`
  ADD KEY `playlisttrack_ctrtPlaylist` (`idPlaylist`),
  ADD KEY `playlisttrack_ctrtTrack` (`idTrack`);

--
-- Index pour la table `track`
--
ALTER TABLE `track`
  ADD PRIMARY KEY (`idTrack`),
  ADD KEY `track_ctrtArtist` (`idArtist`),
  ADD KEY `track_ctrtKind` (`idKind`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `artist`
--
ALTER TABLE `artist`
  MODIFY `idArtist` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `jukebox`
--
ALTER TABLE `jukebox`
  MODIFY `idJukebox` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `kind`
--
ALTER TABLE `kind`
  MODIFY `idKind` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `playlist`
--
ALTER TABLE `playlist`
  MODIFY `idPlaylist` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `track`
--
ALTER TABLE `track`
  MODIFY `idTrack` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
