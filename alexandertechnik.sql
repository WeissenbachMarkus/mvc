-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Erstellungszeit: 30. Jan 2017 um 19:23
-- Server-Version: 10.1.16-MariaDB
-- PHP-Version: 5.6.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `alexandertechnik`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `alarmfunction`
--

CREATE TABLE `alarmfunction` (
  `af_id` int(11) NOT NULL,
  `af_dateTime` datetime NOT NULL,
  `af_message` varchar(45) DEFAULT NULL,
  `User_u_email` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `chargeable`
--

CREATE TABLE `chargeable` (
  `c_price` int(11) NOT NULL,
  `c_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `chargeable`
--

INSERT INTO `chargeable` (`c_price`, `c_id`) VALUES
(11, 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `diary`
--

CREATE TABLE `diary` (
  `d_id` int(11) NOT NULL,
  `user_u_email` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `diarycontent`
--

CREATE TABLE `diarycontent` (
  `dc_id` int(11) NOT NULL,
  `dc_position` int(11) NOT NULL,
  `dc_text` varchar(50) DEFAULT NULL,
  `dc_bild` varchar(50) DEFAULT NULL,
  `Diary_d_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `imprint`
--

CREATE TABLE `imprint` (
  `i_id` int(11) NOT NULL,
  `i_text` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `lastmessage`
--

CREATE TABLE `lastmessage` (
  `lm_date` datetime NOT NULL,
  `user_u_email` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `masterplan`
--

CREATE TABLE `masterplan` (
  `mp_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `message`
--

CREATE TABLE `message` (
  `m_id` int(11) NOT NULL,
  `m_afterXdays` int(11) DEFAULT NULL,
  `m_modelUsageLimit` int(11) DEFAULT NULL,
  `m_message` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `modul`
--

CREATE TABLE `modul` (
  `m_name` varchar(50) NOT NULL,
  `m _icon` varchar(50) DEFAULT NULL,
  `m_finished` tinyint(4) DEFAULT '0',
  `m_showInProgress` tinyint(4) DEFAULT '0',
  `User_u_email` varchar(50) DEFAULT 'Null',
  `chargeable_c_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `modulcontent`
--

CREATE TABLE `modulcontent` (
  `mc_id` int(11) NOT NULL,
  `mc_position` int(11) NOT NULL,
  `mc_text` varchar(50) DEFAULT NULL,
  `mc_bild` varchar(50) DEFAULT NULL,
  `mc_audio` varchar(50) DEFAULT NULL,
  `mc_video` varchar(50) DEFAULT NULL,
  `Modul_m_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `modulposition`
--

CREATE TABLE `modulposition` (
  `modul_m_name` varchar(50) NOT NULL,
  `masterplan_mp_id` int(11) NOT NULL,
  `mp_position` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `stats`
--

CREATE TABLE `stats` (
  `User_u_email` varchar(45) NOT NULL,
  `Modul_m_name` varchar(20) NOT NULL,
  `s_modulUsed` int(11) DEFAULT NULL,
  `s_lastTimeUsed` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `timerfunction`
--

CREATE TABLE `timerfunction` (
  `tf_id` int(11) NOT NULL,
  `tf_timer` time NOT NULL,
  `tf_message` varchar(45) DEFAULT NULL,
  `User_u_email` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `user`
--

CREATE TABLE `user` (
  `u_nickname` varchar(20) NOT NULL,
  `u_icon` varchar(50) DEFAULT '../app/models/pictures/userIcons/default.jpg',
  `u_email` varchar(45) NOT NULL,
  `u_password` varchar(256) NOT NULL,
  `u_admin` tinyint(4) DEFAULT '0',
  `u_masterplanViewed` tinyint(4) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `user`
--

INSERT INTO `user` (`u_nickname`, `u_icon`, `u_email`, `u_password`, `u_admin`, `u_masterplanViewed`) VALUES
('chris', '../app/models/pictures/userIcons/default.jpg', 'chris@gmy.at', '59eec1dd352fbd3c453fe8d40958fbf77c1d683636d43fb2d6e886774dc11c68', 1, 0),
('markus2', '../app/models/pictures/userIcons/default.jpg', 'markus2@gmx.at', '60779550b85deb565cae37b08067783680a31d38319678f91738bc0dae17f2e6', 0, 0),
('markus', '../app/models/pictures/userIcons/default.jpg', 'markus@gmx.at', '03d32f1e2b6a2a016c21f326d651f34ae47d13d424b29d961309963a8c28e96e', 1, 0);

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `alarmfunction`
--
ALTER TABLE `alarmfunction`
  ADD PRIMARY KEY (`af_id`),
  ADD KEY `fk_AlarmFunction_User1_idx` (`User_u_email`);

--
-- Indizes für die Tabelle `chargeable`
--
ALTER TABLE `chargeable`
  ADD PRIMARY KEY (`c_id`);

--
-- Indizes für die Tabelle `diary`
--
ALTER TABLE `diary`
  ADD PRIMARY KEY (`d_id`),
  ADD KEY `fk_diary_user1_idx` (`user_u_email`);

--
-- Indizes für die Tabelle `diarycontent`
--
ALTER TABLE `diarycontent`
  ADD PRIMARY KEY (`dc_id`,`dc_position`),
  ADD UNIQUE KEY `di_id_UNIQUE` (`dc_id`),
  ADD KEY `fk_DiaryInhalt_Diary1_idx` (`Diary_d_id`);

--
-- Indizes für die Tabelle `imprint`
--
ALTER TABLE `imprint`
  ADD PRIMARY KEY (`i_id`);

--
-- Indizes für die Tabelle `lastmessage`
--
ALTER TABLE `lastmessage`
  ADD PRIMARY KEY (`lm_date`),
  ADD KEY `fk_lastmessage_user1_idx` (`user_u_email`);

--
-- Indizes für die Tabelle `masterplan`
--
ALTER TABLE `masterplan`
  ADD PRIMARY KEY (`mp_id`);

--
-- Indizes für die Tabelle `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`m_id`),
  ADD UNIQUE KEY `m_id_UNIQUE` (`m_id`);

--
-- Indizes für die Tabelle `modul`
--
ALTER TABLE `modul`
  ADD PRIMARY KEY (`m_name`),
  ADD UNIQUE KEY `m_name_UNIQUE` (`m_name`),
  ADD KEY `fk_Modul_User1_idx` (`User_u_email`),
  ADD KEY `fk_modul_chargeable1_idx` (`chargeable_c_id`);

--
-- Indizes für die Tabelle `modulcontent`
--
ALTER TABLE `modulcontent`
  ADD PRIMARY KEY (`mc_id`,`mc_position`),
  ADD KEY `fk_ModulInhalt_Modul_idx` (`Modul_m_name`);

--
-- Indizes für die Tabelle `modulposition`
--
ALTER TABLE `modulposition`
  ADD PRIMARY KEY (`modul_m_name`,`masterplan_mp_id`),
  ADD KEY `fk_modulposition_modul1_idx` (`modul_m_name`),
  ADD KEY `fk_modulposition_masterplan1_idx` (`masterplan_mp_id`);

--
-- Indizes für die Tabelle `stats`
--
ALTER TABLE `stats`
  ADD PRIMARY KEY (`User_u_email`,`Modul_m_name`),
  ADD KEY `fk_table1_User1_idx` (`User_u_email`),
  ADD KEY `fk_table1_Modul1_idx` (`Modul_m_name`);

--
-- Indizes für die Tabelle `timerfunction`
--
ALTER TABLE `timerfunction`
  ADD PRIMARY KEY (`tf_id`),
  ADD KEY `fk_TimerFunction_User1_idx` (`User_u_email`);

--
-- Indizes für die Tabelle `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`u_email`),
  ADD UNIQUE KEY `u_nickname_UNIQUE` (`u_nickname`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `alarmfunction`
--
ALTER TABLE `alarmfunction`
  MODIFY `af_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `chargeable`
--
ALTER TABLE `chargeable`
  MODIFY `c_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT für Tabelle `diary`
--
ALTER TABLE `diary`
  MODIFY `d_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `diarycontent`
--
ALTER TABLE `diarycontent`
  MODIFY `dc_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `imprint`
--
ALTER TABLE `imprint`
  MODIFY `i_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `message`
--
ALTER TABLE `message`
  MODIFY `m_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `modulcontent`
--
ALTER TABLE `modulcontent`
  MODIFY `mc_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `timerfunction`
--
ALTER TABLE `timerfunction`
  MODIFY `tf_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `alarmfunction`
--
ALTER TABLE `alarmfunction`
  ADD CONSTRAINT `fk_AlarmFunction_User1` FOREIGN KEY (`User_u_email`) REFERENCES `user` (`u_email`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints der Tabelle `diary`
--
ALTER TABLE `diary`
  ADD CONSTRAINT `fk_diary_user1` FOREIGN KEY (`user_u_email`) REFERENCES `user` (`u_email`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints der Tabelle `diarycontent`
--
ALTER TABLE `diarycontent`
  ADD CONSTRAINT `fk_DiaryInhalt_Diary1` FOREIGN KEY (`Diary_d_id`) REFERENCES `diary` (`d_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints der Tabelle `lastmessage`
--
ALTER TABLE `lastmessage`
  ADD CONSTRAINT `fk_lastmessage_user1` FOREIGN KEY (`user_u_email`) REFERENCES `user` (`u_email`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints der Tabelle `modul`
--
ALTER TABLE `modul`
  ADD CONSTRAINT `fk_Modul_User1` FOREIGN KEY (`User_u_email`) REFERENCES `user` (`u_email`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_modul_chargeable1` FOREIGN KEY (`chargeable_c_id`) REFERENCES `chargeable` (`c_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints der Tabelle `modulcontent`
--
ALTER TABLE `modulcontent`
  ADD CONSTRAINT `fk_ModulInhalt_Modul` FOREIGN KEY (`Modul_m_name`) REFERENCES `modul` (`m_name`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints der Tabelle `modulposition`
--
ALTER TABLE `modulposition`
  ADD CONSTRAINT `fk_modulposition_masterplan1` FOREIGN KEY (`masterplan_mp_id`) REFERENCES `masterplan` (`mp_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_modulposition_modul1` FOREIGN KEY (`modul_m_name`) REFERENCES `modul` (`m_name`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints der Tabelle `stats`
--
ALTER TABLE `stats`
  ADD CONSTRAINT `fk_table1_Modul1` FOREIGN KEY (`Modul_m_name`) REFERENCES `modul` (`m_name`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_table1_User1` FOREIGN KEY (`User_u_email`) REFERENCES `user` (`u_email`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints der Tabelle `timerfunction`
--
ALTER TABLE `timerfunction`
  ADD CONSTRAINT `fk_TimerFunction_User1` FOREIGN KEY (`User_u_email`) REFERENCES `user` (`u_email`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
