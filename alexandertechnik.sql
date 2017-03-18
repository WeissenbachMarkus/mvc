-- MySQL dump 10.13  Distrib 5.6.23, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: alexandertechnik
-- ------------------------------------------------------
-- Server version	5.5.5-10.1.16-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `alarmfunction`
--

DROP TABLE IF EXISTS `alarmfunction`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `alarmfunction` (
  `af_id` int(11) NOT NULL AUTO_INCREMENT,
  `af_dateTime` datetime NOT NULL,
  `af_message` varchar(45) DEFAULT NULL,
  `User_u_email` varchar(45) NOT NULL,
  PRIMARY KEY (`af_id`),
  KEY `fk_AlarmFunction_User1_idx` (`User_u_email`),
  CONSTRAINT `fk_AlarmFunction_User1` FOREIGN KEY (`User_u_email`) REFERENCES `user` (`u_email`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `alarmfunction`
--

LOCK TABLES `alarmfunction` WRITE;
/*!40000 ALTER TABLE `alarmfunction` DISABLE KEYS */;
/*!40000 ALTER TABLE `alarmfunction` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `chargeable`
--

DROP TABLE IF EXISTS `chargeable`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `chargeable` (
  `c_price` int(11) NOT NULL,
  `c_id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`c_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `chargeable`
--

LOCK TABLES `chargeable` WRITE;
/*!40000 ALTER TABLE `chargeable` DISABLE KEYS */;
/*!40000 ALTER TABLE `chargeable` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `diary`
--

DROP TABLE IF EXISTS `diary`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `diary` (
  `d_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_u_email` varchar(45) NOT NULL,
  PRIMARY KEY (`d_id`),
  KEY `fk_diary_user1_idx` (`user_u_email`),
  CONSTRAINT `fk_diary_user1` FOREIGN KEY (`user_u_email`) REFERENCES `user` (`u_email`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `diary`
--

LOCK TABLES `diary` WRITE;
/*!40000 ALTER TABLE `diary` DISABLE KEYS */;
/*!40000 ALTER TABLE `diary` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `diarycontent`
--

DROP TABLE IF EXISTS `diarycontent`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `diarycontent` (
  `dc_id` int(11) NOT NULL AUTO_INCREMENT,
  `dc_position` int(11) NOT NULL,
  `dc_text` varchar(50) DEFAULT NULL,
  `dc_bild` varchar(50) DEFAULT NULL,
  `Diary_d_id` int(11) NOT NULL,
  PRIMARY KEY (`dc_id`,`dc_position`),
  UNIQUE KEY `di_id_UNIQUE` (`dc_id`),
  KEY `fk_DiaryInhalt_Diary1_idx` (`Diary_d_id`),
  CONSTRAINT `fk_DiaryInhalt_Diary1` FOREIGN KEY (`Diary_d_id`) REFERENCES `diary` (`d_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `diarycontent`
--

LOCK TABLES `diarycontent` WRITE;
/*!40000 ALTER TABLE `diarycontent` DISABLE KEYS */;
/*!40000 ALTER TABLE `diarycontent` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `imprint`
--

DROP TABLE IF EXISTS `imprint`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `imprint` (
  `i_id` int(11) NOT NULL AUTO_INCREMENT,
  `i_text` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`i_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `imprint`
--

LOCK TABLES `imprint` WRITE;
/*!40000 ALTER TABLE `imprint` DISABLE KEYS */;
/*!40000 ALTER TABLE `imprint` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lastmessage`
--

DROP TABLE IF EXISTS `lastmessage`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lastmessage` (
  `lm_date` datetime NOT NULL,
  `user_u_email` varchar(45) NOT NULL,
  PRIMARY KEY (`lm_date`),
  KEY `fk_lastmessage_user1_idx` (`user_u_email`),
  CONSTRAINT `fk_lastmessage_user1` FOREIGN KEY (`user_u_email`) REFERENCES `user` (`u_email`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lastmessage`
--

LOCK TABLES `lastmessage` WRITE;
/*!40000 ALTER TABLE `lastmessage` DISABLE KEYS */;
/*!40000 ALTER TABLE `lastmessage` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `masterplan`
--

DROP TABLE IF EXISTS `masterplan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `masterplan` (
  `m_position` varchar(45) NOT NULL,
  `m_id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`m_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `masterplan`
--

LOCK TABLES `masterplan` WRITE;
/*!40000 ALTER TABLE `masterplan` DISABLE KEYS */;
/*!40000 ALTER TABLE `masterplan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `message`
--

DROP TABLE IF EXISTS `message`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `message` (
  `m_id` int(11) NOT NULL AUTO_INCREMENT,
  `m_afterXdays` int(11) DEFAULT NULL,
  `m_modelUsageLimit` int(11) DEFAULT NULL,
  `m_message` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`m_id`),
  UNIQUE KEY `m_id_UNIQUE` (`m_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `message`
--

LOCK TABLES `message` WRITE;
/*!40000 ALTER TABLE `message` DISABLE KEYS */;
/*!40000 ALTER TABLE `message` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `modul`
--

DROP TABLE IF EXISTS `modul`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `modul` (
  `m_name` varchar(50) NOT NULL,
  `m _icon` varchar(50) DEFAULT NULL,
  `m_finished` tinyint(4) DEFAULT '0',
  `m_showInProgress` tinyint(4) DEFAULT '0',
  `chargeable_c_id` int(11) DEFAULT NULL,
  `masterplan_m_id` int(11) NOT NULL,
  PRIMARY KEY (`m_name`),
  UNIQUE KEY `m_name_UNIQUE` (`m_name`),
  KEY `fk_modul_chargeable1_idx` (`chargeable_c_id`),
  KEY `fk_modul_masterplan1_idx` (`masterplan_m_id`),
  CONSTRAINT `fk_modul_chargeable1` FOREIGN KEY (`chargeable_c_id`) REFERENCES `chargeable` (`c_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_modul_masterplan1` FOREIGN KEY (`masterplan_m_id`) REFERENCES `masterplan` (`m_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `modul`
--

LOCK TABLES `modul` WRITE;
/*!40000 ALTER TABLE `modul` DISABLE KEYS */;
/*!40000 ALTER TABLE `modul` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `modulcontent`
--

DROP TABLE IF EXISTS `modulcontent`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `modulcontent` (
  `mc_id` int(11) NOT NULL AUTO_INCREMENT,
  `mc_position` int(11) NOT NULL,
  `mc_text` varchar(50) DEFAULT NULL,
  `mc_image` varchar(50) DEFAULT NULL,
  `mc_audio` varchar(50) DEFAULT NULL,
  `mc_video` varchar(50) DEFAULT NULL,
  `Modul_m_name` varchar(50) NOT NULL,
  PRIMARY KEY (`mc_id`,`mc_position`),
  KEY `fk_ModulInhalt_Modul_idx` (`Modul_m_name`),
  CONSTRAINT `fk_ModulInhalt_Modul` FOREIGN KEY (`Modul_m_name`) REFERENCES `modul` (`m_name`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `modulcontent`
--

LOCK TABLES `modulcontent` WRITE;
/*!40000 ALTER TABLE `modulcontent` DISABLE KEYS */;
/*!40000 ALTER TABLE `modulcontent` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `stats`
--

DROP TABLE IF EXISTS `stats`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `stats` (
  `User_u_email` varchar(45) NOT NULL,
  `Modul_m_name` varchar(20) NOT NULL,
  `s_modulUsed` int(11) DEFAULT NULL,
  `s_lastTimeUsed` datetime DEFAULT NULL,
  PRIMARY KEY (`User_u_email`,`Modul_m_name`),
  KEY `fk_table1_User1_idx` (`User_u_email`),
  KEY `fk_table1_Modul1_idx` (`Modul_m_name`),
  CONSTRAINT `fk_table1_Modul1` FOREIGN KEY (`Modul_m_name`) REFERENCES `modul` (`m_name`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_table1_User1` FOREIGN KEY (`User_u_email`) REFERENCES `user` (`u_email`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `stats`
--

LOCK TABLES `stats` WRITE;
/*!40000 ALTER TABLE `stats` DISABLE KEYS */;
/*!40000 ALTER TABLE `stats` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `timerfunction`
--

DROP TABLE IF EXISTS `timerfunction`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `timerfunction` (
  `tf_id` int(11) NOT NULL AUTO_INCREMENT,
  `tf_timer` time NOT NULL,
  `tf_message` varchar(45) DEFAULT NULL,
  `User_u_email` varchar(45) NOT NULL,
  PRIMARY KEY (`tf_id`),
  KEY `fk_TimerFunction_User1_idx` (`User_u_email`),
  CONSTRAINT `fk_TimerFunction_User1` FOREIGN KEY (`User_u_email`) REFERENCES `user` (`u_email`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `timerfunction`
--

LOCK TABLES `timerfunction` WRITE;
/*!40000 ALTER TABLE `timerfunction` DISABLE KEYS */;
/*!40000 ALTER TABLE `timerfunction` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `u_nickname` varchar(20) NOT NULL,
  `u_icon` varchar(50) DEFAULT '../app/models/pictures/userIcons/default.jpg',
  `u_email` varchar(45) NOT NULL,
  `u_password` varchar(256) NOT NULL,
  `u_admin` tinyint(4) DEFAULT '0',
  `u_masterplanViewed` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`u_email`),
  UNIQUE KEY `u_nickname_UNIQUE` (`u_nickname`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES ('chris','../app/models/pictures/userIcons/default.jpg','chris@gmy.at','59eec1dd352fbd3c453fe8d40958fbf77c1d683636d43fb2d6e886774dc11c68',1,0),('markus2','../app/models/pictures/userIcons/default.jpg','markus2@gmx.at','60779550b85deb565cae37b08067783680a31d38319678f91738bc0dae17f2e6',0,0),('markus','../app/models/pictures/userIcons/default.jpg','markus@gmx.at','03d32f1e2b6a2a016c21f326d651f34ae47d13d424b29d961309963a8c28e96e',1,0);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `using`
--

DROP TABLE IF EXISTS `using`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `using` (
  `user_u_email` varchar(45) NOT NULL,
  `modul_m_name` varchar(50) NOT NULL,
  KEY `fk_using_user1_idx` (`user_u_email`),
  KEY `fk_using_modul1_idx` (`modul_m_name`),
  CONSTRAINT `fk_using_modul1` FOREIGN KEY (`modul_m_name`) REFERENCES `modul` (`m_name`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_using_user1` FOREIGN KEY (`user_u_email`) REFERENCES `user` (`u_email`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `using`
--

LOCK TABLES `using` WRITE;
/*!40000 ALTER TABLE `using` DISABLE KEYS */;
/*!40000 ALTER TABLE `using` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-03-17 19:32:10
