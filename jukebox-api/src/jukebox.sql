DROP TABLE administrator;
DROP TABLE artist;
DROP Table jukebox;
DROP TABLE kind;
DROP TABLE playlist;
DROP TABLE track;
DROP TABLE playlist_track;

-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  jeu. 08 mars 2018 à 14:48
-- Version du serveur :  5.7.19
-- Version de PHP :  5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
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

DROP TABLE IF EXISTS `administrator`;
CREATE TABLE IF NOT EXISTS `administrator` (
  `mail` varchar(100) NOT NULL,
  `password` varchar(500) NOT NULL,
  `firstName` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`mail`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `administrator`
--

INSERT INTO `administrator` (`mail`, `password`, `firstName`, `name`) VALUES
('Nicolas@gmail.com', 'password1', 'Nicolas', 'Jacquemin'),
('Artorias@AnorLondo.lt', 'abyssWalker', 'Artorias', 'Knight');

-- --------------------------------------------------------

--
-- Structure de la table `artist`
--

DROP TABLE IF EXISTS `artist`;
CREATE TABLE IF NOT EXISTS `artist` (
  `idArtist` int(11) NOT NULL AUTO_INCREMENT,
  `nameArtist` varchar(100) NOT NULL,
  PRIMARY KEY (`idArtist`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `artist`
--

INSERT INTO `artist` (`idArtist`, `nameArtist`) VALUES
(1, 'Linkin Park'),
(2, 'Imagine Dragons');

-- --------------------------------------------------------

--
-- Structure de la table `jukebox`
--

DROP TABLE IF EXISTS `jukebox`;
CREATE TABLE IF NOT EXISTS `jukebox` (
  `idJukebox` int(11) NOT NULL AUTO_INCREMENT,
  `nameJukebox` varchar(100) NOT NULL,
  `tokenJukebox` varchar(500) NOT NULL,
  `administratorJukebox` varchar(100) NOT NULL,
  PRIMARY KEY (`idJukebox`),
  KEY `jukebox_ctrtAdministrator` (`administratorJukebox`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `jukebox`
--

INSERT INTO `jukebox` (`idJukebox`, `nameJukebox`, `tokenJukebox`, `administratorJukebox`) VALUES
(1, 'JukeBox Cisiie', 'mynithluna', 'Nicolas@gmail.com');

-- --------------------------------------------------------

--
-- Structure de la table `kind`
--

DROP TABLE IF EXISTS `kind`;
CREATE TABLE IF NOT EXISTS `kind` (
  `idKind` int(11) NOT NULL AUTO_INCREMENT,
  `nameKind` varchar(100) NOT NULL,
  PRIMARY KEY (`idKind`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `kind`
--

INSERT INTO `kind` (`idKind`, `nameKind`) VALUES
(1, 'Rock');

-- --------------------------------------------------------

--
-- Structure de la table `playlist`
--

DROP TABLE IF EXISTS `playlist`;
CREATE TABLE IF NOT EXISTS `playlist` (
  `idPlaylist` int(11) NOT NULL AUTO_INCREMENT,
  `namePlaylist` varchar(100) NOT NULL,
  `durationPlaylist` float DEFAULT NULL,
  `descriptionPlaylist` varchar(500) NOT NULL,
  `isActivated` tinyint(1) NOT NULL,
  `idJukebox` int(11) NOT NULL,
  `idKind` int(11) NOT NULL,
  PRIMARY KEY (`idPlaylist`),
  KEY `playlist_ctrtJukebox` (`idJukebox`),
  KEY `playlist_ctrtKind` (`idKind`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `playlist`
--

INSERT INTO `playlist` (`idPlaylist`, `namePlaylist`, `durationPlaylist`, `descriptionPlaylist`, `isActivated`, `idJukebox`, `idKind`) VALUES
(1, 'Playlist test', NULL, 'Playlist de test pour le jukebox 1', 1, 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `playlist_track`
--

DROP TABLE IF EXISTS `playlist_track`;
CREATE TABLE IF NOT EXISTS `playlist_track` (
  `idPlaylist` int(11) NOT NULL,
  `idTrack` int(11) NOT NULL,
  `positionTrack` int(11) NOT NULL,
  KEY `playlisttrack_ctrtPlaylist` (`idPlaylist`),
  KEY `playlisttrack_ctrtTrack` (`idTrack`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `playlist_track`
--

INSERT INTO `playlist_track` (`idPlaylist`, `idTrack`, `positionTrack`) VALUES
(1, 1, 1),
(1, 2, 2),
(1, 3, 3);

-- --------------------------------------------------------

--
-- Structure de la table `track`
--

DROP TABLE IF EXISTS `track`;
CREATE TABLE IF NOT EXISTS `track` (
  `idTrack` int(11) NOT NULL AUTO_INCREMENT,
  `titleTrack` varchar(100) NOT NULL,
  `durationTrack` float NOT NULL,
  `descriptionTrack` varchar(500) NOT NULL,
  `scoreTrack` float NOT NULL,
  `yearTrack` int(4) NOT NULL,
  `pictureTrack` varchar(100) NOT NULL,
  `urlTrack` varchar(100) NOT NULL,
  `idArtist` int(11) NOT NULL,
  `idKind` int(11) NOT NULL,
  PRIMARY KEY (`idTrack`),
  KEY `track_ctrtArtist` (`idArtist`),
  KEY `track_ctrtKind` (`idKind`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `track`
--

INSERT INTO `track` (`idTrack`, `titleTrack`, `durationTrack`, `descriptionTrack`, `scoreTrack`, `yearTrack`, `pictureTrack`, `urlTrack`, `idArtist`, `idKind`) VALUES
(3, 'In the End', 3.37, 'NULL', 0, 2000, 'http://s07-gestion-appel-offre.zenserv.fr/pictures/LinkinPark/InTheEnd.jpg', 'http://s07-gestion-appel-offre.zenserv.fr/music/LinkinPark/InTheEnd', 1, 1),
(1, 'Numb', 3.06, 'NULL', 0, 2003, 'http://s07-gestion-appel-offre.zenserv.fr/pictures/LinkinPark/Numb.jpg', 'http://s07-gestion-appel-offre.zenserv.fr/music/LinkinPark/Numb', 1, 1),
(4, 'Warriors', 2.5, 'Musique LOL mondial 2014', 0, 2014, 'http://s07-gestion-appel-offre.zenserv.fr/pictures/ImagineDragons/Warriors.jpg', 'http://s07-gestion-appel-offre.zenserv.fr/music/ImagineDragons/Warriors', 2, 1);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
