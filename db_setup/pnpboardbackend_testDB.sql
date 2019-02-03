-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 25. Jan 2019 um 19:06
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

--
-- Daten für Tabelle `mod_note`
--

INSERT INTO `mod_note` (`id`, `name`, `note_text`, `user_id`, `party_id`, `note_date`) VALUES
(1, 'note1', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean', 1, 1, 1548436481),
(2, 'note2', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean', 1, 1, 1548436481),
(3, 'note3', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean', 1, 2, 1548436481),
(4, 'note4', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean', 1, 2, 1548436481),
(5, 'note5', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean', 1, 1, 1548436481);

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

--
-- Daten für Tabelle `mod_party`
--

INSERT INTO `mod_party` (`id`, `name`, `world_id`, `gm`, `sheet_id`) VALUES
(1, 'Network', 1, 1, 1),
(2, 'party2(Splittermond)', 2, 2, 2),
(3, 'party3(Shadowrun)', 5, 1, 5),
(4, 'party4(Werwolf)', 1, 1, 2);

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

--
-- Daten für Tabelle `mod_sheet`
--

INSERT INTO `mod_sheet` (`id`, `name`, `world_id`) VALUES
(1, 'sh1(Werwolf_W20)', 1),
(2, 'sh2(Splittermond_min)', 2),
(3, 'sh3(DSA_5th)', 3),
(4, 'sh4(D&D_5th)', 4),
(5, 'sh5(Shadow_reprint)', 5),
(6, 'sh6(Werwolf_mrGone)', 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `mod_tag`
--

DROP TABLE IF EXISTS `mod_tag`;
CREATE TABLE `mod_tag` (
  `id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `partyId` int(11) NOT NULL
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
  `email` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `mod_user`
--

INSERT INTO `mod_user` (`id`, `username`, `pw`, `email`) VALUES
(1, 'user1', 'pw_1', 'user1@user.de'),
(2, 'user2', 'pw_2', 'user2@user.de'),
(3, 'user3', 'pw_3', 'user3@user.de'),
(4, 'user4', 'pw_4', 'user4@user.de');

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
  `edition` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `mod_world`
--

INSERT INTO `mod_world` (`id`, `name`, `short`, `description`, `edition`) VALUES
(1, 'Werwolf the Apocalypse', 'WtA', 'I am a WoD description', 'W20'),
(2, 'Splittermond', 'Sm', 'I am a Splittermond description', '1st'),
(3, 'Das schwarze Auge', 'DSA', 'I am a DSA description', '5th'),
(4, 'Dungeons and Dragons', 'D&D', 'I am a D&D description', '5th'),
(5, 'Shadowrun', 'Sr', 'I am a Shadowrun description', '3rd');

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

--
-- Daten für Tabelle `rel_notes_users_tags`
--

INSERT INTO `rel_notes_users_tags` (`note_id`, `user_id`, `tag_id`) VALUES
(1, 0, 1),
(1, 0, 2),
(1, 2, 0),
(1, 3, 0),
(2, 0, 2),
(2, 0, 3),
(2, 2, 0),
(2, 3, 0),
(3, 0, 5),
(3, 0, 6),
(3, 1, 0),
(3, 2, 0),
(3, 3, 0),
(4, 0, 5),
(4, 0, 6),
(4, 1, 0),
(4, 2, 0),
(5, 0, 2),
(5, 0, 3),
(5, 3, 0),
(5, 4, 0);

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
-- Daten für Tabelle `rel_users_parties`
--

INSERT INTO `rel_users_parties` (`user_id`, `party_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(1, 2),
(2, 2),
(4, 2),
(1, 3),
(2, 3),
(4, 3),
(1, 4),
(2, 4),
(3, 4),
(4, 4);

--
-- Indizes der exportierten Tabellen
--

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
  ADD KEY `partyId` (`partyId`);

--
-- Indizes für die Tabelle `mod_user`
--
ALTER TABLE `mod_user`
  ADD PRIMARY KEY (`id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `mod_user`
--
ALTER TABLE `mod_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT für Tabelle `mod_world`
--
ALTER TABLE `mod_world`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `mod_note`
--
ALTER TABLE `mod_note`
  ADD CONSTRAINT `mod_note_ibfk_1` FOREIGN KEY (`party_id`) REFERENCES `mod_party` (`id`),
  ADD CONSTRAINT `mod_note_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `mod_user` (`id`);

--
-- Constraints der Tabelle `mod_party`
--
ALTER TABLE `mod_party`
  ADD CONSTRAINT `mod_party_ibfk_1` FOREIGN KEY (`gm`) REFERENCES `mod_user` (`id`),
  ADD CONSTRAINT `mod_party_ibfk_2` FOREIGN KEY (`world_id`) REFERENCES `mod_world` (`id`),
  ADD CONSTRAINT `mod_party_ibfk_3` FOREIGN KEY (`sheet_id`) REFERENCES `mod_sheet` (`id`);

--
-- Constraints der Tabelle `mod_sheet`
--
ALTER TABLE `mod_sheet`
  ADD CONSTRAINT `mod_sheet_ibfk_1` FOREIGN KEY (`world_id`) REFERENCES `mod_world` (`id`);

--
-- Constraints der Tabelle `mod_tag`
--
ALTER TABLE `mod_tag`
  ADD CONSTRAINT `mod_tag_ibfk_1` FOREIGN KEY (`partyId`) REFERENCES `mod_party` (`id`);

--
-- Constraints der Tabelle `rel_notes_users_tags`
--
ALTER TABLE `rel_notes_users_tags`
  ADD CONSTRAINT `rel_notes_users_tags_ibfk_1` FOREIGN KEY (`note_id`) REFERENCES `mod_note` (`id`);

--
-- Constraints der Tabelle `rel_users_parties`
--
ALTER TABLE `rel_users_parties`
  ADD CONSTRAINT `rel_users_parties_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `mod_user` (`id`),
  ADD CONSTRAINT `rel_users_parties_ibfk_2` FOREIGN KEY (`party_id`) REFERENCES `mod_party` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
