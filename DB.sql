-- phpMyAdmin SQL Dump
-- version 4.2.12
-- http://www.phpmyadmin.net
--
-- Machine: rdbms
-- Gegenereerd op: 31 okt 2017 om 23:52
-- Serverversie: 5.6.37-log
-- PHP-versie: 5.5.38

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Databank: `DB3146805`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
`id` int(11) NOT NULL,
  `name` varchar(20) COLLATE latin1_german1_ci NOT NULL,
  `permissions` text COLLATE latin1_german1_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;

--
-- Gegevens worden geëxporteerd voor tabel `groups`
--

INSERT INTO `groups` (`id`, `name`, `permissions`) VALUES
(1, 'default', ''),
(2, 'moderator', '{"moderator": 1}'),
(3, 'admin', '{"admin": 1,"moderator": 1}');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `users`
--

CREATE TABLE IF NOT EXISTS `users` (
`id` int(11) NOT NULL,
  `username` varchar(20) COLLATE latin1_german1_ci NOT NULL,
  `password` varchar(64) COLLATE latin1_german1_ci NOT NULL,
  `salt` varchar(32) COLLATE latin1_german1_ci NOT NULL,
  `name` varchar(50) COLLATE latin1_german1_ci NOT NULL,
  `joined` datetime NOT NULL,
  `group` int(11) NOT NULL,
  `email` varchar(50) COLLATE latin1_german1_ci NOT NULL,
  `confirmed` int(1) NOT NULL,
  `active` int(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `users_confirm`
--

CREATE TABLE IF NOT EXISTS `users_confirm` (
`id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `confirm_code` varchar(64) COLLATE latin1_german1_ci NOT NULL,
  `invalid_date` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `users_forgot`
--

CREATE TABLE IF NOT EXISTS `users_forgot` (
`id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `forgot_code` varchar(64) COLLATE latin1_german1_ci NOT NULL,
  `invalid_date` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `users_session`
--

CREATE TABLE IF NOT EXISTS `users_session` (
`id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `hash` varchar(64) COLLATE latin1_german1_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `groups`
--
ALTER TABLE `groups`
 ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `users_confirm`
--
ALTER TABLE `users_confirm`
 ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `users_forgot`
--
ALTER TABLE `users_forgot`
 ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `users_session`
--
ALTER TABLE `users_session`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `groups`
--
ALTER TABLE `groups`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT voor een tabel `users`
--
ALTER TABLE `users`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=37;
--
-- AUTO_INCREMENT voor een tabel `users_confirm`
--
ALTER TABLE `users_confirm`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=36;
--
-- AUTO_INCREMENT voor een tabel `users_forgot`
--
ALTER TABLE `users_forgot`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT voor een tabel `users_session`
--
ALTER TABLE `users_session`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
