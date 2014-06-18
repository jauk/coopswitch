-- MySQL dump 10.13  Distrib 5.5.37, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: coop_dev
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
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `major_long` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=88 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Majors`
--

LOCK TABLES `Majors` WRITE;
/*!40000 ALTER TABLE `Majors` DISABLE KEYS */;
INSERT INTO `Majors` VALUES (2,'Accounting'),(3,'Animation & Visual Effects'),(4,'Anthropology'),(5,'Architectural Engineering'),(6,'Architecture'),(7,'Behavioral Health Counseling'),(8,'Biological Sciences'),(9,'Biomedical Engineering'),(10,'Business (General)'),(11,'Business Analytics'),(12,'Business Administration'),(13,'Business and Engineering'),(14,'Chemical Engineering'),(15,'Chemistry'),(16,'Civil Engineering'),(17,'Communication'),(18,'Communication and Applied Technology'),(19,'Computer Engineering'),(20,'Computer Science'),(21,'Computing and Security Technology'),(22,'Construction Management'),(23,'Criminal Justice'),(24,'Culinary Arts'),(25,'Custom-Designed Major'),(26,'Dance'),(27,'Design and Merchandising'),(28,'Economics'),(29,'Electrical Engineering'),(30,'Elementary Education'),(31,'Engineering'),(32,'Engineering Technology'),(33,'English'),(34,'Entertainment and Arts Management'),(35,'Entrepreneurship'),(36,'Environmental Engineering'),(37,'Environmental Science'),(38,'Environmental Studies'),(39,'Fashion Design'),(40,'Film and Video'),(41,'Finance'),(42,'Game Art & Production'),(43,'General Business'),(44,'General Studies'),(45,'Geoscience'),(46,'Graphic Design'),(47,'Health Sciences'),(48,'Health-Services Administration'),(49,'History'),(50,'Hospitality Management'),(51,'Informatics'),(52,'Information Systems'),(53,'Information Technology'),(54,'Interactive Digital Media'),(55,'International Area Studies'),(56,'International Business'),(57,'Interior Design'),(58,'Invasive Cardiovascular Technology'),(59,'Legal Studies'),(60,'Management Information Systems'),(61,'Marketing'),(62,'Materials Science and Engineering'),(63,'Mathematics'),(64,'Mechanical Engineering'),(65,'Music Industry'),(66,'Nursing'),(67,'Nursing: RN-MSN Bridge Program'),(68,'Nutrition and Foods'),(69,'Operations and Supply Chain Management'),(70,'Philosophy'),(71,'Photography'),(72,'Physics'),(73,'Political Science'),(74,'Product Design'),(75,'Professional Studies'),(76,'Property Management'),(77,'Psychology'),(78,'Public Health'),(79,'Radio Technology'),(80,'ROTC'),(81,'Screenwriting & Playwriting'),(82,'Sociology'),(83,'Software Engineering'),(84,'Sport Management'),(85,'Teacher Education'),(86,'TV Production & Media Management'),(87,'Westphal Studies Program');
/*!40000 ALTER TABLE `Majors` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Matches`
--

DROP TABLE IF EXISTS `Matches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Matches` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userA` int(64) NOT NULL,
  `userB` int(64) NOT NULL,
  `major` int(8) NOT NULL,
  `isFinished` tinyint(1) DEFAULT NULL,
  `date_matched` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=174 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Users`
--

DROP TABLE IF EXISTS `Users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `password` varchar(32) DEFAULT NULL,
  `email` varchar(20) NOT NULL,
  `cycle` int(11) NOT NULL,
  `num_year_program` int(16) DEFAULT NULL,
  `major` int(8) NOT NULL,
  `matched` int(8) NOT NULL,
  `Matches_id` int(64) NOT NULL,
  `dropped_matches` int(8) DEFAULT NULL,
  `register_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `payment` int(128) NOT NULL,
  `gradYear` int(128) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=603 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-06-02 16:12:27
