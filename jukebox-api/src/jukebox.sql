-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  lun. 02 avr. 2018 à 15:45
-- Version du serveur :  5.7.19
-- Version de PHP :  7.0.23

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
('Artorias@AnorLondo.lt', 'abyssWalker', 'Artorias', 'Knight'),
('lebonlegras@mail.com', '$2y$12$OEPlhaw1m.ICY/Oyqk0IJ.VnzieoNR4wLEvcRIyrhJ90k3hFfMM26', 'Legras', 'LEBON');

-- --------------------------------------------------------

--
-- Structure de la table `artist`
--

DROP TABLE IF EXISTS `artist`;
CREATE TABLE IF NOT EXISTS `artist` (
  `idArtist` int(11) NOT NULL AUTO_INCREMENT,
  `nameArtist` varchar(100) NOT NULL,
  PRIMARY KEY (`idArtist`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `artist`
--

INSERT INTO `artist` (`idArtist`, `nameArtist`) VALUES
(1, 'Linkin Park'),
(2, 'Imagine Dragons'),
(3, 'Two Steps From Hell');

-- --------------------------------------------------------

--
-- Structure de la table `jukebox`
--

DROP TABLE IF EXISTS `jukebox`;
CREATE TABLE IF NOT EXISTS `jukebox` (
  `idJukebox` int(11) NOT NULL AUTO_INCREMENT,
  `nameJukebox` varchar(100) NOT NULL,
  `description` varchar(500) NOT NULL,
  `tokenJukebox` varchar(500) NOT NULL,
  `administratorJukebox` varchar(100) NOT NULL,
  PRIMARY KEY (`idJukebox`),
  KEY `jukebox_ctrtAdministrator` (`administratorJukebox`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `jukebox`
--

INSERT INTO `jukebox` (`idJukebox`, `nameJukebox`, `description`, `tokenJukebox`, `administratorJukebox`) VALUES
(1, 'JukeBox Cisiie', 'Jukebox de test', 'mynithluna', 'Nicolas@gmail.com');

-- --------------------------------------------------------

--
-- Structure de la table `jukeboxlibrary`
--


DROP TABLE IF EXISTS `jukeboxlibrary`;
CREATE TABLE IF NOT EXISTS `jukeboxlibrary` (
  `idJukeboxLibrary` int(11) NOT NULL AUTO_INCREMENT,
  `idJukebox` int(11) NOT NULL,
  `idTrack` int(11) NOT NULL,
  PRIMARY KEY (``idJukeboxLibrary`),
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `jukeboxlibrary`
--

INSERT INTO `jukeboxlibrary` (`idJukeboxLibrary`, `idJukebox`, `idTrack`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 3),
(4, 1, 4),
(5, 1, 5),
(6, 1, 6),
(7, 1, 7),
(8, 1, 8),
(9, 1, 9),
(10, 1, 10),
(11, 1, 11);

-- --------------------------------------------------------

--
-- Structure de la table `kind`
--

DROP TABLE IF EXISTS `kind`;
CREATE TABLE IF NOT EXISTS `kind` (
  `idKind` int(11) NOT NULL AUTO_INCREMENT,
  `nameKind` varchar(100) NOT NULL,
  PRIMARY KEY (`idKind`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `kind`
--

INSERT INTO `kind` (`idKind`, `nameKind`) VALUES
(1, 'Rock'),
(2, 'Epic Music');

-- --------------------------------------------------------

--
-- Structure de la table `queue`
--

DROP TABLE IF EXISTS `queue`;
CREATE TABLE IF NOT EXISTS `queue` (
  `idQueue` int(11) NOT NULL AUTO_INCREMENT,
  `nameQueue` varchar(100) NOT NULL,
  `durationQueue` float DEFAULT NULL,
  `descriptionQueue` varchar(500) NOT NULL,
  `isActivated` tinyint(1) NOT NULL,
  `idJukebox` int(11) NOT NULL,
  `idKind` int(11) NOT NULL,
  PRIMARY KEY (`idQueue`),
  KEY `queue_ctrtJukebox` (`idJukebox`),
  KEY `queue_ctrtKind` (`idKind`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `queue`
--

INSERT INTO `queue` (`idQueue`, `nameQueue`, `durationQueue`, `descriptionQueue`, `isActivated`, `idJukebox`, `idKind`) VALUES
(1, 'Playlist test', NULL, 'Playlist de test pour le jukebox 1', 1, 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `queuecontent`
--

DROP TABLE IF EXISTS `queuecontent`;
CREATE TABLE IF NOT EXISTS `queuecontent` (
  `idQueueContent` int(11) NOT NULL AUTO_INCREMENT,
  `idQueue` int(11) NOT NULL,
  `idTrack` int(11) NOT NULL,
  `positionTrack` int(11) NOT NULL,
  `userTrack` varchar(50) NOT NULL,
  `score` int(5) DEFAULT NULL,
  PRIMARY KEY (`idQueueContent`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `queuecontent`
--

INSERT INTO `queuecontent` (`idQueueContent`, `idQueue`, `idTrack`, `positionTrack`, `userTrack`, `score`) VALUES
(1, 1, 1, 1, 'admin', 0),
(2, 1, 2, 2, 'client', 0),
(3, 1, 3, 3, 'admin', 0),
(4, 1, 4, 5, 'admin', 0),
(5, 1, 5, 7, 'user', 0),
(6, 1, 6, 6, 'admin', 0),
(7, 1, 7, 4, 'admin', 1),
(8, 1, 8, 8, 'test', NULL),
(9, 1, 8, 9, 'test', NULL);

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
  `yearTrack` int(4) NOT NULL,
  `pictureTrack` varchar(100) NOT NULL,
  `urlTrack` varchar(100) NOT NULL,
  `idArtist` int(11) NOT NULL,
  `idKind` int(11) NOT NULL,
  PRIMARY KEY (`idTrack`),
  KEY `track_ctrtArtist` (`idArtist`),
  KEY `track_ctrtKind` (`idKind`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `track`
--

INSERT INTO `track` (`idTrack`, `titleTrack`, `durationTrack`, `descriptionTrack`, `yearTrack`, `pictureTrack`, `urlTrack`, `idArtist`, `idKind`) VALUES
(3, 'In the End', 3.37, 'NULL', 2000, 'http://s07-gestion-appel-offre.zenserv.fr/pictures/LinkinPark/InTheEnd.jpg', 'http://s07-gestion-appel-offre.zenserv.fr/music/LinkinPark/InTheEnd.mp3', 1, 1),
(1, 'Numb', 3.06, 'NULL', 2003, 'http://s07-gestion-appel-offre.zenserv.fr/pictures/LinkinPark/Numb.jpg', 'http://s07-gestion-appel-offre.zenserv.fr/music/LinkinPark/Numb.mp3', 1, 1),
(4, 'Warriors', 2.5, 'Musique LOL mondial 2014', 2014, 'http://s07-gestion-appel-offre.zenserv.fr/pictures/ImagineDragons/Warriors.jpg', 'http://s07-gestion-appel-offre.zenserv.fr/music/ImagineDragons/Warriors.mp3', 2, 1),
(5, 'Demons', 2.57, 'description demons imagine dragons', 2012, 'http://s07-gestion-appel-offre.zenserv.fr/pictures/ImagineDragons/Demons.jpg', 'http://s07-gestion-appel-offre.zenserv.fr/music/ImagineDragons/Demons.m4a', 2, 1),
(6, 'It\'s Time', 4, 'description it\'s time ', 2012, 'http://s07-gestion-appel-offre.zenserv.fr/pictures/ImagineDragons/It\'sTime.jpg', 'http://s07-gestion-appel-offre.zenserv.fr/music/ImagineDragons/It\'sTime.mp3', 2, 1),
(7, 'Radioactive', 3.06, 'description radioactive', 2012, 'http://s07-gestion-appel-offre.zenserv.fr/pictures/ImagineDragons/Radioactive.jpg', 'http://s07-gestion-appel-offre.zenserv.fr/music/ImagineDragons/Radioactive.mp3', 2, 1),
(2, 'Breaking The Habit ', 3.16, '', 2003, 'http://s07-gestion-appel-offre.zenserv.fr/pictures/LinkinPark/BreakingThe Habit.jpg', 'http://s07-gestion-appel-offre.zenserv.fr/music/LinkinPark/BreakingTheHabit.mp3', 1, 1),
(8, 'Burn It Down', 3.5, '', 2012, 'http://s07-gestion-appel-offre.zenserv.fr/pictures/LinkinPark/BurnItDown.jpg', 'http://s07-gestion-appel-offre.zenserv.fr/music/LinkinPark/BurnItDown.mp3', 1, 1),
(9, 'Faint', 2.42, '', 2003, 'http://s07-gestion-appel-offre.zenserv.fr/pictures/LinkinPark/Faint.jpg', 'http://s07-gestion-appel-offre.zenserv.fr/music/LinkinPark/Faint.mp3', 1, 1),
(10, 'New Divide', 4.33, '', 2009, 'http://s07-gestion-appel-offre.zenserv.fr/pictures/LinkinPark/NewDivide.jpg', 'http://s07-gestion-appel-offre.zenserv.fr/music/LinkinPark/NewDivide.mp3', 1, 1),
(11, 'The Catalyst', 3.45, '', 2010, 'http://s07-gestion-appel-offre.zenserv.fr/pictures/LinkinPark/TheCatalyst.jpg', 'http://s07-gestion-appel-offre.zenserv.fr/music/LinkinPark/TheCatalyst.mp3', 1, 1),
(12, 'What I\'ve Done ', 3.31, '', 2007, 'http://s07-gestion-appel-offre.zenserv.fr/pictures/LinkinPark/WhatI\'VeDone.jpg', 'http://s07-gestion-appel-offre.zenserv.fr/music/LinkinPark/WhatI\'VeDone.mp3', 1, 1),
(13, 'BlackHeart', 4.26, '', 2012, 'http://s07-gestion-appel-offre.zenserv.fr/pictures/TwoStepsFromHell/Skyworld.jpg', 'http://s07-gestion-appel-offre.zenserv.fr/music/TwoStepsFromHell/Blackheart.mp3', 3, 2),
(14, 'Breathe', 2.55, '', 2012, 'http://s07-gestion-appel-offre.zenserv.fr/pictures/TwoStepsFromHell/Skyworld.jpg', 'http://s07-gestion-appel-offre.zenserv.fr/music/TwoStepsFromHell/Breathe.mp3', 3, 2),
(15, 'Compass', 4.22, '', 2014, 'http://s07-gestion-appel-offre.zenserv.fr/pictures/TwoStepsFromHell/Miracles.jpg', 'http://s07-gestion-appel-offre.zenserv.fr/music/TwoStepsFromHell/Compass.mp3', 3, 2),
(16, 'Flight Of the Silverbird', 3.27, '', 2015, 'http://s07-gestion-appel-offre.zenserv.fr/pictures/TwoStepsFromHell/Battlecry.jpg', 'http://s07-gestion-appel-offre.zenserv.fr/music/TwoStepsFromHell/FlightOfTheSilverbird.mp3', 3, 2),
(17, 'Ocean Princess', 2.57, '', 2011, 'http://s07-gestion-appel-offre.zenserv.fr/pictures/TwoStepsFromHell/Illusions.jpg', 'http://s07-gestion-appel-offre.zenserv.fr/music/TwoStepsFromHell/OceanPrincess.mp3', 3, 2),
(18, 'Protectors of the Earth', 2.51, '', 2010, 'http://s07-gestion-appel-offre.zenserv.fr/pictures/TwoStepsFromHell/Invincibles.jpg', 'http://s07-gestion-appel-offre.zenserv.fr/music/TwoStepsFromHell/ProtectorsOfTheEarth.mp3', 3, 2),
(19, 'Start Sky', 5.39, '', 2015, 'http://s07-gestion-appel-offre.zenserv.fr/pictures/TwoStepsFromHell/Battlecry.jpg', 'http://s07-gestion-appel-offre.zenserv.fr/music/TwoStepsFromHell/StarSky.mp3', 3, 2),
(20, 'Victory', 5.28, '', 2015, 'http://s07-gestion-appel-offre.zenserv.fr/pictures/TwoStepsFromHell/Battlecry.jpg', 'http://s07-gestion-appel-offre.zenserv.fr/music/TwoStepsFromHell/Victory.mp3', 3, 2);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
