--
-- Database: `assignment2`
CREATE DATABASE `assignment2`;
-- --------------------------------------------------------

--
-- Use: `assignment2`
USE `assignment2`;
-- --------------------------------------------------------

--
-- Table structure for table `note`
--

CREATE TABLE IF NOT EXISTS `note` (
  `NOTEID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `USERID` int(10) unsigned NOT NULL,
  `CONTENT` varchar(250) NOT NULL,
  `POSITIONX` int(10) NOT NULL DEFAULT '150',
  `POSITIONY` int(10) NOT NULL DEFAULT '150',
  PRIMARY KEY (`NOTEID`),
  KEY `note_ibfk_1` (`USERID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `USERID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `USERNAME` varchar(25) NOT NULL,
  `PASSWORD` char(250) NOT NULL,
  `LOGIN_ATTEMPTS` int(3) NOT NULL DEFAULT '0',
  `TIMEOUT` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`USERID`),
  UNIQUE KEY `USERNAME` (`USERNAME`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
-- --------------------------------------------------------

--
-- Constraints for table `note`
--
ALTER TABLE `note`
  ADD CONSTRAINT `note_ibfk_1` FOREIGN KEY (`USERID`) REFERENCES `user` (`USERID`) ON DELETE CASCADE ON UPDATE CASCADE;
-- --------------------------------------------------------
