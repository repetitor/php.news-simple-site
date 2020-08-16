-- MySQL dump 10.17  Distrib 10.3.22-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: 127.0.0.1    Database: db
-- ------------------------------------------------------
-- Server version	8.0.21

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `authors`
--

DROP TABLE IF EXISTS `authors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `authors` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` char(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `authors`
--

LOCK TABLES `authors` WRITE;
/*!40000 ALTER TABLE `authors` DISABLE KEYS */;
INSERT INTO `authors` VALUES (1,'Buford Lindgren'),(2,'Fermin Purdy'),(3,'Vance Monahan'),(4,'Kenton Streich'),(5,'Elwyn Davis');
/*!40000 ALTER TABLE `authors` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` char(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,'Главные'),(2,'Политика'),(3,'Экономика');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `news`
--

DROP TABLE IF EXISTS `news`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `news` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` char(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `author_id` bigint unsigned NOT NULL,
  `category_id` bigint unsigned NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `news_author_id_foreign` (`author_id`),
  KEY `news_category_id_foreign` (`category_id`),
  CONSTRAINT `news_author_id_foreign` FOREIGN KEY (`author_id`) REFERENCES `authors` (`id`),
  CONSTRAINT `news_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=119 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `news`
--

LOCK TABLES `news` WRITE;
/*!40000 ALTER TABLE `news` DISABLE KEYS */;
INSERT INTO `news` VALUES (37,'name postman 29',2,1,'description postmanh','2020-08-12 18:48:10','2020-08-13 23:22:00'),(54,'jhj',1,1,'kj','2020-08-13 23:26:54','2020-08-13 23:26:54'),(55,'mn',1,1,'kjk','2020-08-13 23:27:00','2020-08-13 23:27:00'),(57,' b',1,1,'bb','2020-08-13 23:31:49','2020-08-13 23:31:49'),(58,'ff',1,1,'fff','2020-08-13 23:55:06','2020-08-13 23:55:06'),(59,'gg',1,1,'ggg','2020-08-14 00:04:35','2020-08-14 00:04:35'),(60,'zzzzzzzz',1,1,'zzzzzzzz','2020-08-14 00:05:39','2020-08-14 00:05:39'),(61,'vbb',1,1,'vbv','2020-08-14 00:08:23','2020-08-14 00:08:23'),(62,'vv',1,1,'vv','2020-08-14 00:12:11','2020-08-14 00:12:11'),(63,'ff',1,1,'fff','2020-08-14 00:13:12','2020-08-14 00:13:12'),(64,'dd',1,1,'dd','2020-08-14 00:13:24','2020-08-14 00:13:24'),(65,'user',1,1,'user@example.com','2020-08-14 00:18:18','2020-08-14 00:18:18'),(66,'user',1,1,'user@example.com','2020-08-14 00:19:26','2020-08-14 00:19:26'),(67,'user',1,1,'user@example.com','2020-08-14 00:21:24','2020-08-14 00:21:24'),(68,'user',1,1,'user@example.com','2020-08-14 00:22:56','2020-08-14 00:22:56'),(69,'',1,1,'','2020-08-14 00:26:16','2020-08-14 00:26:16'),(70,'',1,1,'','2020-08-14 00:26:56','2020-08-14 00:26:56'),(71,'',1,1,'','2020-08-14 00:27:27','2020-08-14 00:27:27'),(72,'',1,1,'','2020-08-14 00:27:35','2020-08-14 00:27:35'),(73,'f',1,1,'f','2020-08-14 00:30:56','2020-08-14 00:30:56'),(74,'f',1,1,'f','2020-08-14 00:30:56','2020-08-14 00:30:56'),(75,'d',1,1,'d','2020-08-14 00:31:37','2020-08-14 00:31:37'),(76,'f',1,1,'f','2020-08-14 00:32:46','2020-08-14 00:32:46'),(77,'f',1,1,'f','2020-08-14 00:36:03','2020-08-14 00:36:03'),(78,'f',1,1,'f','2020-08-14 00:36:03','2020-08-14 00:36:03'),(79,'as',1,1,'dd','2020-08-14 00:39:11','2020-08-14 00:39:11'),(80,'as',1,1,'dd','2020-08-14 00:39:11','2020-08-14 00:39:11'),(81,'f',1,1,'f','2020-08-14 00:40:22','2020-08-14 00:40:22'),(82,'f',1,1,'f','2020-08-14 00:40:22','2020-08-14 00:40:22'),(83,'ff',1,1,'fvfv','2020-08-14 00:40:31','2020-08-14 00:40:31'),(84,'ff',1,1,'fvfv','2020-08-14 00:40:31','2020-08-14 00:40:31'),(85,'cvcc',1,1,'cvvc','2020-08-14 00:42:36','2020-08-14 00:42:36'),(86,'cvcc',1,1,'cvvc','2020-08-14 00:42:36','2020-08-14 00:42:36'),(87,'g',1,1,'h','2020-08-14 00:51:16','2020-08-14 00:51:16'),(88,'ggfg',1,1,'h','2020-08-14 00:51:16','2020-08-14 00:52:00'),(89,' bg',1,1,'bvv','2020-08-14 00:52:45','2020-08-14 00:52:45'),(90,' bg',1,1,'bvv','2020-08-14 00:52:45','2020-08-14 00:52:45'),(91,'1',1,1,'1','2020-08-15 13:07:12','2020-08-15 13:07:12'),(92,'1',1,1,'1','2020-08-15 13:07:12','2020-08-15 13:07:12'),(93,'vvvhg',1,1,'nbvbn','2020-08-15 13:17:18','2020-08-15 13:17:18'),(94,'vvvhg',1,1,'nbvbn','2020-08-15 13:17:18','2020-08-15 13:17:18'),(95,'gg',1,1,'nb\r\n\r\nhh\r\nh','2020-08-15 13:21:20','2020-08-15 13:21:20'),(96,'ggsdsdds',1,1,'nb\r\n\r\nhh\r\nh222','2020-08-15 13:21:20','2020-08-15 13:50:00'),(97,'  ffff',1,1,'fff','2020-08-15 16:00:05','2020-08-15 16:00:05'),(98,'  ffff',1,1,'fff','2020-08-15 16:00:05','2020-08-15 16:00:05'),(99,'ddd',1,1,'ddd','2020-08-15 16:00:14','2020-08-15 16:00:14'),(100,'ddd',1,1,'ddd\r\n\r\nddf','2020-08-15 16:00:14','2020-08-15 16:06:00'),(101,'aaa',1,1,'zzzz','2020-08-15 16:08:01','2020-08-15 16:08:01'),(102,'aaa',1,1,'zzzz','2020-08-15 16:08:01','2020-08-15 16:08:01'),(103,'55',1,1,'44','2020-08-15 16:11:05','2020-08-15 16:11:05'),(104,'jjj',1,1,'hh','2020-08-15 16:14:10','2020-08-15 16:14:10'),(106,'jjjjjjjjjj',1,1,'l\r\nj\r\nj','2020-08-15 16:20:18','2020-08-15 16:20:18'),(107,'gffg',2,3,'','2020-08-15 16:20:49','2020-08-15 16:20:49'),(108,'bbv',1,1,'bb','2020-08-15 16:28:57','2020-08-15 19:28:00'),(110,'name postman 29',2,1,'description postman','2020-08-15 17:50:06','2020-08-15 22:41:00'),(111,'name-postmanr hhh-update2666',1,2,'description-postman','2020-08-15 17:50:12','2020-08-15 22:50:00'),(113,'bn',1,1,'nbn','2020-08-15 22:06:31','2020-08-15 22:35:00'),(117,'c',1,1,'vv','2020-08-15 22:48:20','2020-08-15 22:48:20'),(118,'name postman 29',2,1,'description postman','2020-08-15 22:52:54','2020-08-15 22:52:54');
/*!40000 ALTER TABLE `news` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-08-16 12:35:09
