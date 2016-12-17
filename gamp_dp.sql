-- MySQL dump 10.13  Distrib 5.7.9, for Win64 (x86_64)
--
-- Host: localhost    Database: gamp_dp
-- ------------------------------------------------------
-- Server version	5.7.15-log

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
-- Table structure for table `tbl_mobjekt`
--

DROP TABLE IF EXISTS `tbl_mobjekt`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_mobjekt` (
  `mo_id` int(11) NOT NULL AUTO_INCREMENT,
  `mo_reihenfolge` int(11) NOT NULL,
  `mo_text` varchar(45) DEFAULT NULL,
  `mo_audio` varchar(45) DEFAULT NULL,
  `mo_bild` text NOT NULL,
  `mo_video` varchar(45) DEFAULT NULL,
  `tbl_modul_m_id` int(11) NOT NULL,
  `mo_name` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`mo_id`,`tbl_modul_m_id`),
  KEY `fk_tbl_mobjekt_tbl_modul_idx` (`tbl_modul_m_id`),
  CONSTRAINT `fk_tbl_mobjekt_tbl_modul` FOREIGN KEY (`tbl_modul_m_id`) REFERENCES `tbl_modul` (`m_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_mobjekt`
--

LOCK TABLES `tbl_mobjekt` WRITE;
/*!40000 ALTER TABLE `tbl_mobjekt` DISABLE KEYS */;
INSERT INTO `tbl_mobjekt` VALUES (1,1,'df',NULL,'',NULL,1,'karl'),(6,6,NULL,NULL,'../../mvc/public/bilder/images.jpg',NULL,1,NULL),(9,9,NULL,NULL,'../../mvc/public/bilder/images.jpg',NULL,1,NULL);
/*!40000 ALTER TABLE `tbl_mobjekt` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_modul`
--

DROP TABLE IF EXISTS `tbl_modul`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_modul` (
  `m_id` int(11) NOT NULL AUTO_INCREMENT,
  `m_name` varchar(45) DEFAULT NULL,
  `m_icon` varchar(45) DEFAULT NULL,
  `tbl_user_u_id` int(11) NOT NULL,
  PRIMARY KEY (`m_id`,`tbl_user_u_id`),
  KEY `fk_tbl_modul_tbl_user_idx` (`tbl_user_u_id`),
  KEY `idx_tbl_modul_m_name` (`m_name`) COMMENT 'erleichterte Modulnamensabrage',
  CONSTRAINT `fk_tbl_modul_tbl_user` FOREIGN KEY (`tbl_user_u_id`) REFERENCES `tbl_user` (`u_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_modul`
--

LOCK TABLES `tbl_modul` WRITE;
/*!40000 ALTER TABLE `tbl_modul` DISABLE KEYS */;
INSERT INTO `tbl_modul` VALUES (1,'erstes Modul',NULL,13),(2,'Zweites Modul',NULL,13),(4,'fddf',NULL,13),(11,'fg',NULL,13),(12,'vcv',NULL,13);
/*!40000 ALTER TABLE `tbl_modul` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_user`
--

DROP TABLE IF EXISTS `tbl_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_user` (
  `u_id` int(11) NOT NULL AUTO_INCREMENT,
  `u_name` varchar(45) DEFAULT NULL,
  `u_email` varchar(45) DEFAULT NULL,
  `u_password` varchar(300) DEFAULT NULL,
  `u_icon` varchar(45) DEFAULT NULL,
  `u_admin` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`u_id`),
  UNIQUE KEY `u_name_UNIQUE` (`u_name`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_user`
--

LOCK TABLES `tbl_user` WRITE;
/*!40000 ALTER TABLE `tbl_user` DISABLE KEYS */;
INSERT INTO `tbl_user` VALUES (13,'markus',NULL,'24d9c7b19834aa278ce9609a00d156f61bd83184c2634d1c2b1d6aaa9c235b3a',NULL,0),(14,'',NULL,'e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855',NULL,0),(15,'dfd',NULL,NULL,NULL,0),(18,'dfdf',NULL,NULL,NULL,0);
/*!40000 ALTER TABLE `tbl_user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-12-17 19:08:37
