-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 25. Jan 2019 um 15:31
-- Server-Version: 10.1.31-MariaDB
-- PHP-Version: 7.2.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `pnpboardbackend`
--
CREATE DATABASE IF NOT EXISTS `pnpboardbackend` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `pnpboardbackend`;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `note`
--

DROP TABLE IF EXISTS `mod_note`;
CREATE TABLE `mod_note` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `text` longtext NOT NULL,
  `user_id` int(11) NOT NULL,
  `party_id` int(11) NOT NULL,
  `date` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `party`
--

DROP TABLE IF EXISTS `mod_party`;
CREATE TABLE `mod_party` (
  `id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `world_id` int(11) NOT NULL,
  `gm` int(11) NOT NULL,
  `sheet_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tag`
--

DROP TABLE IF EXISTS `mod_tag`;
CREATE TABLE `mod_tag` (
  `id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `partyId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `user`
--

DROP TABLE IF EXISTS `mod_user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `pw` varchar(100) NOT NULL,
  `email` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `world`
--

DROP TABLE IF EXISTS `mod_world`;
CREATE TABLE `world` (
  `id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `desc` varchar(500) NOT NULL,
  `edition` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `note`
--
ALTER TABLE `mod_note`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `party`
--
ALTER TABLE `mod_party`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indizes für die Tabelle `tag`
--
ALTER TABLE `mod_tag`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `user`
--
ALTER TABLE `mod_user`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `world`
--
ALTER TABLE `mod_world`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `note`
--
ALTER TABLE `mod_note`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `party`
--
ALTER TABLE `mod_party`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `tag`
--
ALTER TABLE `mod_tag`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `user`
--
ALTER TABLE `mod_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `world`
--
ALTER TABLE `mod_world`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
