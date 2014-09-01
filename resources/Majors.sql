-- MySQL dump 10.13  Distrib 5.5.37, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: coopswitch
-- ------------------------------------------------------
-- Server version	5.5.37-0ubuntu0.14.04.1

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
-- Table structure for table `Majors`
--

DROP TABLE IF EXISTS `Majors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Majors` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `major_long` varchar(128) DEFAULT NULL,
  `noSwitch` int(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=71 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Majors`
--

LOCK TABLES `Majors` WRITE;
/*!40000 ALTER TABLE `Majors` DISABLE KEYS */;
INSERT INTO `Majors` VALUES (1,'Animation & Visual Effects',0),(2,'Anthropology',1),(3,'Architectural Engineering',0),(4,'Architecture',0),(5,'Behavioral Health Counseling',1),(6,'Biological Sciences',0),(7,'Biomedical Engineering',0),(9,'Business Administration (All Majors)',0),(10,'Business and Engineering',0),(11,'Chemical Engineering',0),(12,'Chemistry',1),(13,'Civil Engineering',0),(14,'Communication',0),(15,'Computer Engineering',0),(16,'Computer Science',0),(17,'Construction Management',1),(18,'Criminal Justice',1),(19,'Culinary Arts',0),(20,'Custom-Designed Major',1),(21,'Dance',0),(22,'Design and Merchandising',0),(23,'Economics',0),(24,'Electrical Engineering',0),(25,'Elementary Education',1),(26,'Engineering',0),(27,'Engineering Technology',1),(28,'English',0),(29,'Entertainment and Arts Management',0),(30,'Entrepreneurship',0),(31,'Environmental Engineering',0),(32,'Environmental Science',1),(33,'Environmental Studies',1),(34,'Fashion Design',0),(35,'Film and Video',0),(36,'Game Art & Production',0),(37,'General Studies',1),(38,'Geoscience',0),(39,'Graphic Design',0),(40,'Health Sciences',0),(41,'Health-Services Administration',0),(42,'History',1),(43,'Hospitality Management',1),(44,'Informatics',0),(45,'Information Systems',0),(46,'Information Technology',0),(47,'Interactive Digital Media',0),(48,'Interior Design',0),(49,'International Area Studies',0),(50,'Materials Science and Engineering',1),(51,'Mathematics',1),(52,'Mechanical Engineering',0),(53,'Music Industry',0),(54,'Nursing',0),(55,'Nutrition and Foods',1),(56,'Philosophy',1),(57,'Photography',0),(58,'Physics',1),(59,'Political Science',0),(60,'Product Design',0),(61,'Property Management',0),(62,'Psychology',0),(63,'Public Health',0),(64,'Screenwriting & Playwriting',0),(65,'Sociology',0),(66,'Software Engineering',1),(67,'Sport Management',0),(68,'Teacher Education',1),(69,'TV Production & Media Management',0),(70,'Westphal Studies Program',1);
/*!40000 ALTER TABLE `Majors` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-08-31 21:39:09
