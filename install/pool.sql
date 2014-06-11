-- phpMyAdmin SQL Dump
-- version 3.4.11.1deb2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 11. Jun 2014 um 08:07
-- Server Version: 5.5.31
-- PHP-Version: 5.4.4-14+deb7u4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Datenbank: `pool`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `aktor`
--

CREATE TABLE IF NOT EXISTS `aktor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `programm` int(1) DEFAULT '0',
  `verbrauch` int(4) DEFAULT NULL,
  `gpio` int(3) DEFAULT NULL,
  `toggle_gpio` int(3) NOT NULL,
  `zeitEin` int(11) NOT NULL,
  `zeitHeute` int(11) NOT NULL,
  `verbrauchWatt` decimal(5,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Daten für Tabelle `aktor`
--

INSERT INTO `aktor` (`id`, `name`, `programm`, `verbrauch`, `gpio`, `toggle_gpio`, `zeitEin`, `zeitHeute`, `verbrauchWatt`) VALUES
(1, 'Pool', 3, NULL, 17, 0, 0, 0, 500.00),
(2, 'Solar', 0, NULL, 24, 0, 0, 0, 0.00),
(3, 'Licht', 0, NULL, 22, 0, 0, 0, 100.00),
(4, 'Tablet', 0, NULL, 23, 0, 0, 0, 0.00);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `einstellungen`
--

CREATE TABLE IF NOT EXISTS `einstellungen` (
  `maxWasser` int(10) NOT NULL,
  `diffTemp` int(11) NOT NULL,
  `minSolar` int(2) NOT NULL,
  `startPumpe` time NOT NULL,
  `stopPumpe` time NOT NULL,
  `startPumpe1` time NOT NULL,
  `stopPumpe1` time NOT NULL,
  `startTablet` time NOT NULL,
  `stopTablet` time NOT NULL,
  `tabletWochentag` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `einstellungen`
--

INSERT INTO `einstellungen` (`maxWasser`, `diffTemp`, `minSolar`, `startPumpe`, `stopPumpe`, `startPumpe1`, `stopPumpe1`, `startTablet`, `stopTablet`, `tabletWochentag`) VALUES
(30, 3, 25, '08:45:00', '12:00:00', '13:15:00', '18:30:00', '11:30:00', '15:00:00', '1;2;4;6');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `logtemp`
--

CREATE TABLE IF NOT EXISTS `logtemp` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(25) NOT NULL,
  `iid` varchar(30) DEFAULT NULL,
  `value` float DEFAULT NULL,
  `time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `logverbrauch`
--

CREATE TABLE IF NOT EXISTS `logverbrauch` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gpio` int(3) DEFAULT NULL,
  `kwh` varchar(11) DEFAULT NULL,
  `zeitEin` int(11) DEFAULT NULL,
  `date` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Daten für Tabelle `logverbrauch`
--



--
-- Tabellenstruktur für Tabelle `sensoren`
--

CREATE TABLE IF NOT EXISTS `sensoren` (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `sensorId` varchar(20) NOT NULL,
  `name` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Daten für Tabelle `sensoren`
--

INSERT INTO `sensoren` (`id`, `sensorId`, `name`) VALUES
(1, '28-0000045c707e', 'Pool'),
(2, '28-0000045d2690', 'Solar'),
(3, '123456789', 'Raspberry'),
(4, '28-00000472367d', 'Ruecklauf');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `temptrend`
--

CREATE TABLE IF NOT EXISTS `temptrend` (
  `Pool` float NOT NULL,
  `Solar` float NOT NULL,
  `Ruecklauf` float NOT NULL,
  `Raspberry` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `temptrend`
--

INSERT INTO `temptrend` (`Pool`, `Solar`, `Ruecklauf`, `Raspberry`) VALUES
(0.18, 4.37, 0.25, 1.07);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
