-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 06. Dez 2019 um 01:32
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

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `man_login_status`
--

DROP TABLE IF EXISTS `man_login_status`;
CREATE TABLE `man_login_status` (
  `user_id` int(11) NOT NULL,
  `token` varchar(70) NOT NULL,
  `timestamp` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `mod_note`
--

DROP TABLE IF EXISTS `mod_note`;
CREATE TABLE `mod_note` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `note_text` longtext NOT NULL,
  `user_id` int(11) NOT NULL,
  `party_id` int(11) NOT NULL,
  `note_date` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `mod_party`
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
-- Tabellenstruktur für Tabelle `mod_sheet`
--

DROP TABLE IF EXISTS `mod_sheet`;
CREATE TABLE `mod_sheet` (
  `id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `world_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `mod_tag`
--

DROP TABLE IF EXISTS `mod_tag`;
CREATE TABLE `mod_tag` (
  `id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `party_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `mod_user`
--

DROP TABLE IF EXISTS `mod_user`;
CREATE TABLE `mod_user` (
  `id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `pw` varchar(100) NOT NULL,
  `email` varchar(30) NOT NULL,
  `sec_question` varchar(100) NOT NULL,
  `sec_answer` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `mod_world`
--

DROP TABLE IF EXISTS `mod_world`;
CREATE TABLE `mod_world` (
  `id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `short` varchar(10) NOT NULL,
  `description` varchar(500) NOT NULL,
  `edition` varchar(30) NOT NULL,
  `author` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `rel_notes_users_tags`
--

DROP TABLE IF EXISTS `rel_notes_users_tags`;
CREATE TABLE `rel_notes_users_tags` (
  `note_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `tag_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `rel_users_parties`
--

DROP TABLE IF EXISTS `rel_users_parties`;
CREATE TABLE `rel_users_parties` (
  `user_id` int(11) NOT NULL,
  `party_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `man_login_status`
--
ALTER TABLE `man_login_status`
  ADD UNIQUE KEY `user_id` (`user_id`),
  ADD UNIQUE KEY `hash` (`token`);

--
-- Indizes für die Tabelle `mod_note`
--
ALTER TABLE `mod_note`
  ADD PRIMARY KEY (`id`),
  ADD KEY `party_id` (`party_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indizes für die Tabelle `mod_party`
--
ALTER TABLE `mod_party`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD KEY `gm` (`gm`),
  ADD KEY `world_id` (`world_id`),
  ADD KEY `sheet_id` (`sheet_id`);

--
-- Indizes für die Tabelle `mod_sheet`
--
ALTER TABLE `mod_sheet`
  ADD PRIMARY KEY (`id`),
  ADD KEY `world_id` (`world_id`);

--
-- Indizes für die Tabelle `mod_tag`
--
ALTER TABLE `mod_tag`
  ADD PRIMARY KEY (`id`),
  ADD KEY `partyId` (`party_id`);

--
-- Indizes für die Tabelle `mod_user`
--
ALTER TABLE `mod_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indizes für die Tabelle `mod_world`
--
ALTER TABLE `mod_world`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `rel_notes_users_tags`
--
ALTER TABLE `rel_notes_users_tags`
  ADD KEY `user_id` (`user_id`),
  ADD KEY `tag_id` (`tag_id`),
  ADD KEY `rel_notes_users_tags_ibfk_1` (`note_id`);

--
-- Indizes für die Tabelle `rel_users_parties`
--
ALTER TABLE `rel_users_parties`
  ADD KEY `user_id` (`user_id`),
  ADD KEY `party_id` (`party_id`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `mod_note`
--
ALTER TABLE `mod_note`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT für Tabelle `mod_party`
--
ALTER TABLE `mod_party`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT für Tabelle `mod_sheet`
--
ALTER TABLE `mod_sheet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT für Tabelle `mod_tag`
--
ALTER TABLE `mod_tag`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT für Tabelle `mod_user`
--
ALTER TABLE `mod_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT für Tabelle `mod_world`
--
ALTER TABLE `mod_world`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `mod_note`
--
-- ALTER TABLE `mod_note`
--   ADD CONSTRAINT `mod_note_ibfk_1` FOREIGN KEY (`party_id`) REFERENCES `mod_party` (`id`),
--   ADD CONSTRAINT `mod_note_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `mod_user` (`id`);
--
-- --
-- -- Constraints der Tabelle `mod_party`
-- --
-- ALTER TABLE `mod_party`
--   ADD CONSTRAINT `mod_party_ibfk_1` FOREIGN KEY (`gm`) REFERENCES `mod_user` (`id`),
--   ADD CONSTRAINT `mod_party_ibfk_2` FOREIGN KEY (`world_id`) REFERENCES `mod_world` (`id`),
--   ADD CONSTRAINT `mod_party_ibfk_3` FOREIGN KEY (`sheet_id`) REFERENCES `mod_sheet` (`id`);
--
-- --
-- -- Constraints der Tabelle `mod_sheet`
-- --
-- ALTER TABLE `mod_sheet`
--   ADD CONSTRAINT `mod_sheet_ibfk_1` FOREIGN KEY (`world_id`) REFERENCES `mod_world` (`id`);
--
-- --
-- -- Constraints der Tabelle `mod_tag`
-- --
-- ALTER TABLE `mod_tag`
--   ADD CONSTRAINT `mod_tag_ibfk_1` FOREIGN KEY (`party_id`) REFERENCES `mod_party` (`id`);
-- COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
