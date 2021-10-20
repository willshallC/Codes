-- MySQL dump 10.16  Distrib 10.2.25-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: churning_laravel
-- ------------------------------------------------------
-- Server version	10.2.25-MariaDB-cll-lve

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
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `department_id` int(4) NOT NULL,
  `category` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `department_id_constarint` (`department_id`),
  CONSTRAINT `department_id_constarint` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,1,'Coding'),(2,1,'R & D'),(3,1,'Functionality Testing'),(4,1,'Discussions'),(5,1,'Miscellaneous'),(6,2,'Design'),(7,2,'Front End Development'),(8,3,'Search Engine Optimization'),(9,3,'Social Media Optimization'),(10,3,'Search Engine Marketing'),(11,3,'Social Media Marketing'),(12,3,'Content Writing'),(13,4,'Bidding Jobs'),(14,4,'Email Response'),(15,4,'Client Calling / Chatting'),(16,4,'Proposals Making'),(17,4,'Team Discussion'),(18,4,'Miscellaneous'),(19,5,'Resource Hunting'),(20,5,'Interviews'),(21,5,'Employee Interaction'),(22,5,'Job Posting'),(23,5,'Miscellaneous'),(24,6,'Website Testing'),(25,6,'Bug Verification'),(26,6,'Team Discussion '),(27,6,'Miscellaneous');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `departments`
--

DROP TABLE IF EXISTS `departments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `departments` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `department` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `departments`
--

LOCK TABLES `departments` WRITE;
/*!40000 ALTER TABLE `departments` DISABLE KEYS */;
INSERT INTO `departments` VALUES (1,'Development'),(2,'Design'),(3,'Digital Marketing'),(4,'Sales'),(5,'HR'),(6,'Testing');
/*!40000 ALTER TABLE `departments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `designations`
--

DROP TABLE IF EXISTS `designations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `designations` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `designation` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `designations`
--

LOCK TABLES `designations` WRITE;
/*!40000 ALTER TABLE `designations` DISABLE KEYS */;
INSERT INTO `designations` VALUES (1,'Trainee'),(2,'Executive'),(3,'Sr. Executive'),(4,'Team Lead'),(5,'Manager');
/*!40000 ALTER TABLE `designations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dsr`
--

DROP TABLE IF EXISTS `dsr`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dsr` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `category_id` int(4) NOT NULL,
  `subcategory_id` int(4) DEFAULT NULL,
  `employee_id` int(11) NOT NULL,
  `dsr_date` date NOT NULL,
  `time_spent` int(4) NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `filled_by_token_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `project_id` (`project_id`),
  KEY `category_id` (`category_id`),
  KEY `subcategory_id` (`subcategory_id`),
  KEY `employee_id` (`employee_id`),
  KEY `filled_by_token_id` (`filled_by_token_id`),
  CONSTRAINT `category_id_constraint` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON UPDATE NO ACTION,
  CONSTRAINT `project_id_constraint` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON UPDATE NO ACTION,
  CONSTRAINT `subcategory_id_constraint` FOREIGN KEY (`subcategory_id`) REFERENCES `subcategories` (`id`) ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dsr`
--

LOCK TABLES `dsr` WRITE;
/*!40000 ALTER TABLE `dsr` DISABLE KEYS */;
INSERT INTO `dsr` VALUES (2,1,1,NULL,3,'2019-12-18',150,'Worked on mega menus.',NULL,'2019-12-18 10:05:42','2019-12-18 10:05:42'),(3,10,13,NULL,5,'2019-12-18',130,'This is testing phase of TMS.',NULL,'2019-12-18 17:59:35','2019-12-18 17:59:35'),(4,10,13,NULL,5,'2019-12-18',325,'This is testing of DSR',NULL,'2019-12-18 18:04:54','2019-12-18 18:04:54'),(5,10,3,1,3,'2019-12-18',325,'This is testing of DSR with Deepak Profile',NULL,'2019-12-18 18:04:54','2019-12-18 18:04:54'),(6,9,1,NULL,3,'2019-12-18',125,'test',NULL,'2019-12-18 19:45:49','2019-12-18 19:45:49'),(7,10,13,NULL,5,'2019-12-19',140,'Testing',NULL,'2019-12-19 12:58:18','2019-12-19 12:58:18'),(8,11,15,NULL,5,'2019-12-19',180,'Tester',NULL,'2019-12-19 13:07:58','2019-12-19 13:07:58'),(9,9,1,NULL,3,'2019-12-19',120,'Worked on fill dsr form.',NULL,'2019-12-19 13:09:48','2019-12-19 13:09:48'),(10,10,3,1,3,'2019-12-19',65,'Tested fill DSR form and found some Css issues, shared with vivek thakur.',NULL,'2019-12-19 13:11:06','2019-12-19 13:11:06'),(11,13,3,1,3,'2019-12-19',170,'test',NULL,'2019-12-19 14:03:17','2019-12-19 14:03:17'),(12,11,5,8,3,'2019-12-19',395,'test',NULL,'2019-12-19 14:03:56','2019-12-19 14:03:56'),(13,11,2,NULL,3,'2019-12-19',175,'test',NULL,'2019-12-19 14:08:26','2019-12-19 14:08:26'),(14,9,2,NULL,3,'2019-12-19',125,'ttt',NULL,'2019-12-19 14:10:48','2019-12-19 14:10:48'),(15,9,1,NULL,10,'2019-12-19',235,'Worked on TMS display in admin.',NULL,'2019-12-19 14:25:34','2019-12-19 14:25:34'),(16,7,1,NULL,10,'2019-12-19',130,'Displayed pre-order badge on product and category pages.',NULL,'2019-12-19 14:49:09','2019-12-19 14:49:09'),(17,4,3,2,11,'2019-12-19',30,'Tested payment gateway and order emails.',NULL,'2019-12-19 17:52:07','2019-12-19 17:52:07'),(18,9,2,NULL,3,'2019-12-19',125,'ttt',NULL,'2019-12-19 18:08:30','2019-12-19 18:08:30'),(19,9,2,NULL,3,'2019-12-19',165,'test',NULL,'2019-12-19 18:32:54','2019-12-19 18:32:54'),(20,9,1,NULL,3,'2019-12-19',120,'Worked on fill dsr form.',NULL,'2019-12-19 18:58:03','2019-12-19 18:58:03'),(21,9,1,NULL,3,'2019-12-19',5,'Worked on fill dsr form.',NULL,'2019-12-19 18:58:49','2019-12-19 18:58:49'),(22,9,5,5,3,'2019-12-19',405,'test',NULL,'2019-12-19 19:14:14','2019-12-19 19:14:14'),(23,14,1,NULL,3,'2019-12-20',170,'New description',NULL,'2019-12-20 12:00:48','2019-12-20 16:39:00'),(24,13,2,NULL,3,'2019-12-20',80,'Done research on extension.',NULL,'2019-12-20 16:46:54','2019-12-20 16:46:54'),(25,9,1,NULL,3,'2019-12-20',140,'Done coding.',NULL,'2019-12-20 16:47:28','2019-12-20 17:04:34'),(26,9,1,NULL,10,'2019-12-20',180,'Working on admin view employee DSR form',NULL,'2019-12-20 17:41:58','2019-12-20 17:41:58'),(27,4,13,NULL,5,'2019-12-20',530,'Done bidding all day.',NULL,'2019-12-20 18:27:56','2019-12-20 18:27:56'),(28,9,2,NULL,3,'2019-12-20',135,'new task',NULL,'2019-12-20 20:12:29','2019-12-20 20:12:29'),(29,5,4,NULL,10,'2019-12-23',70,'Checked for website security issues , vulnerabilities with Mahipal , Solomon',NULL,'2019-12-23 17:28:40','2019-12-23 17:28:40'),(30,4,3,1,11,'2019-12-23',40,'Website testing..',NULL,'2019-12-23 17:33:14','2019-12-23 17:33:14'),(31,4,6,9,6,'2019-12-23',195,'Testing',NULL,'2019-12-23 20:30:06','2019-12-23 20:30:06'),(32,4,1,NULL,3,'2019-12-23',130,'Testing function',NULL,'2019-12-23 20:34:56','2019-12-23 20:34:56'),(33,4,6,10,7,'2019-12-23',280,'Created Design',NULL,'2019-12-23 20:36:28','2019-12-23 20:36:28'),(34,5,1,NULL,10,'2019-12-24',240,'description ..',NULL,'2019-12-24 17:20:06','2019-12-24 17:20:06'),(35,9,1,NULL,10,'2019-12-26',225,'Worked on TMS view page .',NULL,'2019-12-26 14:35:05','2019-12-26 14:35:05'),(36,4,6,10,7,'2019-12-26',365,'test',NULL,'2019-12-26 16:57:50','2019-12-26 16:57:50'),(37,4,6,NULL,7,'2019-12-27',460,'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.',NULL,'2019-12-27 11:05:14','2019-12-27 17:44:50'),(38,9,3,1,10,'2019-12-27',70,'testing ..',NULL,'2019-12-27 12:10:46','2019-12-27 12:10:46'),(39,4,3,1,10,'2019-12-27',35,'testing product list and detail pages on BCW.',NULL,'2019-12-27 12:14:45','2019-12-27 12:14:45'),(40,4,1,NULL,11,'2019-12-27',65,'On Hover images',NULL,'2019-12-27 12:52:28','2019-12-27 12:52:28'),(41,4,7,14,7,'2019-12-27',230,'test',NULL,'2019-12-27 17:45:42','2019-12-27 17:45:42'),(42,4,7,15,7,'2019-12-27',475,'dddddddddddddddddddddd',NULL,'2019-12-27 18:00:24','2019-12-27 18:00:24'),(43,4,7,18,7,'2019-12-27',135,'r',NULL,'2019-12-27 18:06:05','2019-12-27 18:06:05'),(44,4,6,9,7,'2019-12-30',125,'test',NULL,'2019-12-30 13:18:00','2019-12-30 13:18:00'),(45,4,6,11,7,'2019-12-30',415,'test',NULL,'2019-12-30 13:25:07','2019-12-30 13:25:07'),(46,9,1,NULL,3,'2019-12-30',220,'Done coding.',NULL,'2019-12-30 17:50:33','2019-12-30 17:50:33'),(47,4,3,1,10,'2019-12-31',65,'Pages testing.',NULL,'2019-12-31 12:56:57','2019-12-31 12:56:57'),(48,9,1,NULL,3,'2019-12-31',70,'Test DSR',NULL,'2019-12-31 14:52:18','2019-12-31 14:52:18');
/*!40000 ALTER TABLE `dsr` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dsr_edit_request_token`
--

DROP TABLE IF EXISTS `dsr_edit_request_token`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dsr_edit_request_token` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) NOT NULL,
  `issued_by` int(11) NOT NULL,
  `issued_for_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `valid_till_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `token_number` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `issued_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `requested_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `id` (`id`),
  KEY `employee_id` (`employee_id`),
  KEY `issued_by` (`issued_by`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dsr_edit_request_token`
--

LOCK TABLES `dsr_edit_request_token` WRITE;
/*!40000 ALTER TABLE `dsr_edit_request_token` DISABLE KEYS */;
/*!40000 ALTER TABLE `dsr_edit_request_token` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `employee_profile`
--

DROP TABLE IF EXISTS `employee_profile`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `employee_profile` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `emp_id` int(11) unsigned NOT NULL,
  `gender` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `joining_date` date DEFAULT NULL,
  `designation_id` int(3) DEFAULT NULL,
  `core_skills` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `qualification` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `current_salary` int(7) DEFAULT NULL,
  `phone_personal` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_emergency` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address_present` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address_permanent` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `marital_status` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `esic_number` double DEFAULT NULL,
  `salary_account_number` bigint(20) DEFAULT NULL,
  `pan_number` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `emp_id` (`emp_id`),
  KEY `designation` (`designation_id`),
  CONSTRAINT `designation_constraint` FOREIGN KEY (`designation_id`) REFERENCES `designations` (`id`) ON UPDATE NO ACTION,
  CONSTRAINT `user_Profile_relation` FOREIGN KEY (`emp_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `employee_profile`
--

LOCK TABLES `employee_profile` WRITE;
/*!40000 ALTER TABLE `employee_profile` DISABLE KEYS */;
INSERT INTO `employee_profile` VALUES (1,3,'Male','2019-02-14',3,'Magento , laravel , Html , Css , Javascript , jQuery , Codeingiter','BCA','1995-10-07',NULL,'9898989898','9898989897','Test','Test','Single',NULL,NULL,NULL),(2,10,'Male',NULL,4,'core php , laravel','B.Tech','1992-01-11',NULL,'9021233002','1236547890','address 11','address22 dsdcdbgvbbbbbsfdsfdsfdddsf','Married',NULL,NULL,NULL),(3,20,'Male',NULL,NULL,'PSD to HTML','BCA','1995-01-09',NULL,'7895642310','9632587410','15 sec , Chandigarh','Harmirpur , HP','Single',NULL,NULL,NULL),(4,22,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(5,23,'Male',NULL,NULL,'Photoshop, Bootstrap, Magento, Business Catalyst','MCA','1982-11-27',NULL,'09023469345','9876543210','2271, Sector 47-C','2271, Sector 47-C','Married',NULL,NULL,NULL),(6,24,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(7,13,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(8,25,NULL,'2017-10-02',3,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(9,26,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `employee_profile` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_resets_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `project_user_relation`
--

DROP TABLE IF EXISTS `project_user_relation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `project_user_relation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `relation_status` int(11) NOT NULL COMMENT '''1'' = ''active'',''0'' = ''deactivated''',
  PRIMARY KEY (`id`),
  KEY `project_id` (`project_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `project_user_relation`
--

LOCK TABLES `project_user_relation` WRITE;
/*!40000 ALTER TABLE `project_user_relation` DISABLE KEYS */;
INSERT INTO `project_user_relation` VALUES (1,9,3,1),(4,11,5,1),(5,11,3,1),(6,12,7,1),(7,12,6,1),(8,12,3,0),(9,13,3,1),(10,14,3,1),(12,6,10,1),(13,7,10,1),(14,11,10,1),(16,9,10,1),(24,4,7,1),(25,4,5,1),(26,4,10,1),(27,4,11,1),(28,4,6,1),(29,4,3,1),(30,10,3,1),(31,1,3,1),(33,3,3,1),(35,6,3,1),(36,7,3,1),(37,2,13,1),(38,2,3,1),(39,5,23,1);
/*!40000 ALTER TABLE `project_user_relation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `projects`
--

DROP TABLE IF EXISTS `projects`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `projects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `department_ids` int(11) DEFAULT NULL COMMENT 'Only for single id not multiple',
  `project_title` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_date` timestamp NULL DEFAULT NULL,
  `end_date` timestamp NULL DEFAULT NULL,
  `priority` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `billing_type` int(1) NOT NULL COMMENT '''1'' = ''Fixed'', ''2'' = ''Hourly''',
  `project_cost` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hourly_rate` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `platform` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `time_allocated` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `client_name` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `client_email` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `client_skype` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `client_country` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sales_executive` int(2) NOT NULL,
  `status` int(11) NOT NULL COMMENT '''1'' = ''Active'', ''2'' = ''Completed'', ''3'' = ''On-Hold'', ''4'' = ''Canceled'', ''5'' = ''Dispute''',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `department_ids` (`department_ids`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `projects`
--

LOCK TABLES `projects` WRITE;
/*!40000 ALTER TABLE `projects` DISABLE KEYS */;
INSERT INTO `projects` VALUES (1,1,'IM','https://www.illuminated-mirrors.uk.com/','2020-01-01 07:00:00','2020-01-10 07:00:00','Low','This is a UK based online portal of mirrors.',1,'1000',NULL,'Upwork','100 hours','','','','',5,1,'2019-12-03 19:32:35','2019-12-03 19:32:35'),(2,1,'IM','https://www.illuminated-mirrors.uk.com/','2014-01-01 07:00:00','2020-12-13 07:00:00','High','This is UK based online mirror store.',2,NULL,'13','Upwork','150 hours','Jamie Bell','jamie@gmail.com','jamie24','UK',5,1,'2019-12-05 11:51:29','2019-12-27 15:18:03'),(3,1,'ML','https://www.miroir-lumineux.com/','2015-06-15 07:00:00','2022-07-27 07:00:00','High','This is a France based online mirror store.',2,NULL,'13','Upwork','170 hours','Jamie Bell','jamie@gmail.com','jamie24','UK',9,3,'2019-12-05 13:49:08','2019-12-05 13:49:08'),(4,1,'BCW','https://www.bathroom-cabinet-world.co.uk/','2019-12-12 07:00:00','2019-12-31 07:00:00','High','Testing',2,NULL,'13','Upwork','110 hours','Jamie Bell','jamie@gmail.com','jamie24','UK',9,1,'2019-12-05 17:41:57','2019-12-26 12:53:58'),(5,2,'Magento Development','www.magento.com','2019-12-05 07:00:00','2019-12-18 07:00:00','High','Testing',1,'$1500',NULL,'Upwork','50 hours','David','david@test.com','testingdavid','USA',9,1,'2019-12-05 18:06:38','2019-12-27 20:54:26'),(6,2,'Magento Development','www.magento.com','2019-12-05 07:00:00','2019-12-18 07:00:00','High','Testing',1,'$1500',NULL,'Upwork','230 hours','David','david@test.com','testingdavid','USA',5,3,'2019-12-05 18:06:39','2019-12-05 18:06:39'),(7,1,'MM','https://www.modern-mirror-design.co.uk/','2019-12-05 07:00:00','2020-02-07 07:00:00','High','Testing',2,NULL,'13','Upwork','320 hours','Jamie Bell','jamie@gmail.com','jamie24','UK',5,1,'2019-12-05 18:42:40','2019-12-05 18:42:40'),(9,1,'TMS','https://churnings.com/laravel/public','2019-12-05 07:00:00','2020-01-01 07:00:00','High','This is willshall TMS system.',1,'$1000',NULL,'Direct','250 hours','Willshall','willshall@willshall.com','willshall','INDIA',5,1,'2019-12-05 19:16:56','2019-12-05 19:16:56'),(10,3,'Churning','http://churnings.com','2019-12-05 07:00:00','2020-01-31 07:00:00','Medium','Testing of project editing module.',1,'$100',NULL,'Direct','90 hours','Tester','Tester','tester','INDIA',9,3,'2019-12-05 19:41:34','2019-12-26 12:57:24'),(11,1,'Rustiquehome','https://www.rustiquehome.co.uk/','2019-12-05 07:00:00','2020-02-07 07:00:00','Medium','Testing project',1,'$1100',NULL,'Upwork','350 hours','Neil','neil@gmail.com','Neil','UK',5,2,'2019-12-05 20:24:30','2019-12-05 20:24:30'),(12,1,'DXH','https://www.diamondxhollywood.com/','2019-12-09 07:00:00','2020-11-01 07:00:00','High','USA based site.',2,NULL,'13','Upwork','100 hours','Jamie Bell','jamie@gmail.com','jamie24','UK',9,3,'2019-12-09 13:28:03','2019-12-09 13:28:03'),(13,1,'bcw','https://www.illuminated-mirrors.uk.com/bathroom-mirrors.html','2019-12-09 07:00:00','2019-12-11 07:00:00','Critical & Top','des',1,'34',NULL,'Upwork','30 hours','aaa','abc@cc.com','dswqa','USA',5,1,'2019-12-09 20:42:55','2019-12-09 20:42:55'),(14,2,'Test','https://www.test.com/','2019-12-11 07:00:00','2020-01-15 07:00:00','High','Testing',2,NULL,'13','Upwork','10 hours','Tester','tester@gmail.com','tester','UK',5,1,'2019-12-11 18:33:46','2019-12-11 18:33:46');
/*!40000 ALTER TABLE `projects` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subcategories`
--

DROP TABLE IF EXISTS `subcategories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `subcategories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(4) NOT NULL,
  `subcategory` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_cat_id` (`category_id`),
  CONSTRAINT `fk_cat_id` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subcategories`
--

LOCK TABLES `subcategories` WRITE;
/*!40000 ALTER TABLE `subcategories` DISABLE KEYS */;
INSERT INTO `subcategories` VALUES (1,3,'Website Testing'),(2,3,'Payment Gateway Testing'),(3,4,'Client Chat / Skype Call'),(4,4,'Team Discussion'),(5,5,'Conduct Interview'),(6,5,'Office Activities'),(7,5,'Quote sharing for projects'),(8,5,'Guiding / helping Juniors'),(9,6,'Mock Up Design'),(10,6,'Graphic Design'),(11,6,'Wireframe Design'),(12,6,'Miscellaneous'),(13,7,'PSD to HTML'),(14,7,'Design integration in WP'),(15,7,'Design integration in Shopify'),(16,7,'Design integration in Magento'),(17,7,'Responsive Work'),(18,7,'Content Implementation'),(19,7,'Miscellaneous'),(20,7,'Team Coordination'),(21,8,'On Page Work'),(22,8,'Off Page Work'),(23,9,'Post Creation'),(24,9,'Followers/Likes/Commenting'),(25,9,'Stories Creation'),(26,10,'Campaign Setting'),(27,10,'Ad Creating'),(28,10,'Tracking & Analysis'),(29,11,'Campaign Setting'),(30,11,'Ad Creating'),(31,11,'Tracking & Analysis'),(32,12,'Article / Blog Writing'),(33,12,'Description Writing'),(34,12,'Website Content'),(35,12,'Miscellaneous');
/*!40000 ALTER TABLE `subcategories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `department_id` int(2) DEFAULT NULL,
  `access_level` int(2) NOT NULL DEFAULT 3 COMMENT '1=Super-admin 2=HR 3=Employee',
  `status` int(1) NOT NULL DEFAULT 0 COMMENT '''0'' = ''inactive'', ''1'' = ''active''',
  `profile_pic` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `department_id` (`department_id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (2,'Willshall','sachin@willshall.com',NULL,'$2y$10$t0ufXBC85qzuVFQ24G28YuWzIIPh55x0B2nnkwXT7ukP7ZxZzyyQW',NULL,0,1,1,'willshall.svg','2019-11-29 17:09:34','2019-12-20 19:34:45'),(3,'Deepak','deepak.kumar@willshall.com',NULL,'$2y$10$WOxgVe7mMB2arhx..vhA0ONBK5RUxL4L.k3NafMrgmX8hY9LcBGDy','AOQfUM4500xx9RKdOXG0iu2deCl8S7haIYo2RAxFguAtLut0c0y4DaJi8i7a',1,3,1,'NK22V6mPazz9McrYDPxbDvQgIa3C1HMoGC0e4uqu.jpeg','2019-12-03 13:55:32','2019-12-31 17:10:35'),(4,'Admin','admin@black.com',NULL,'$2y$12$63W7IIEvM/7YYqUSBeoFsu1uI7opcQ3I632tgQTrhgsde4SKonkw2',NULL,0,1,1,NULL,'2019-12-02 07:00:00','2019-12-09 19:02:18'),(5,'Neetika','neetika@willshall.com',NULL,'$2y$12$ax3w6r3F6fKsA1Kl7hSpAOMF36pmy9dcErvL5/5nsUQtSQlJ7oLlO',NULL,4,3,1,NULL,'2019-12-02 07:00:00','2019-12-03 07:00:00'),(6,'Happy','happy.singh@willshall.com',NULL,'$2y$12$HoDdtd2B/a1ZYTKbIxyzvuYreosA1lkextM9Z.y7hzYlb/qnS6Ab6',NULL,2,3,1,NULL,'2019-12-09 07:00:00','2019-12-09 07:00:00'),(7,'Vivek','vivek.thakur@willshall.com',NULL,'$2y$12$uJs4mxhW/LxkLX/LhQU79ehtWGzkck.m65G7SiOwRUBQnDGG05R8S',NULL,2,3,1,NULL,'2019-12-09 07:00:00','2019-12-09 07:00:00'),(8,'Agam','agam.sharma@willshall.com',NULL,'$2y$10$h9y8o6yd2yPfCR1r45Yqf.Wx.bb3J3l2kiHn5bbzFlSUHMCLrKU/y',NULL,5,3,1,NULL,'2019-12-09 14:59:38','2019-12-09 15:07:43'),(9,'Rita','rita.saini@willshall.com',NULL,'$2y$10$0Cx2VLaJSblmHDiHNhaJqun6MGzg6mSZnwjQTwxUga6CW2bs3dgPG',NULL,4,3,1,NULL,'2019-12-13 16:43:47','2019-12-13 16:43:47'),(10,'Kirandeep Singh','kirandeep.singh@willshall.com',NULL,'$2y$10$rhVjMlPU2sKE7TFihRRYPeWx6Q8PN2fWAJ5UX.22c5kv4RSGQzQbK',NULL,1,3,1,'up4PhynKv00soEZ4cARn2ouFk803Otnu3RuN0kbi.png','2019-12-19 14:08:58','2019-12-19 14:08:58'),(11,'Jai Prakash','jai.prakash@willshall.com',NULL,'$2y$10$LNkzu9fDeA28D194Ym3d9e9bnWxSwWQJCeLfVuv9soxWckGv7JhOK',NULL,1,3,1,NULL,'2019-12-19 17:35:42','2019-12-19 17:35:42'),(12,'test','test@test.com',NULL,'$2y$10$WHp7gMhwGfECaHjIVv3jGezHZ.gC/xcZrl2zTLcnjXVMz2YDZ1CL6',NULL,2,3,1,NULL,'2019-12-20 20:25:06','2019-12-20 20:25:06'),(13,'Paras','paras@willshall.com',NULL,'$2y$10$oXWq8PKQGN2eJYwYiGiafedSga3R8zsBqceVCBVS08Mo98PnX5AA2',NULL,2,3,1,NULL,'2019-12-26 13:25:27','2019-12-27 15:13:11'),(14,'Sourabhdeep','sourabh@willshall.com',NULL,'$2y$10$MH4wOMoN0irCqgJYO6klRezsItjmxJFJpYRdYbrf0OpXqBzQ3Sdxi',NULL,NULL,3,0,NULL,'2019-12-26 17:47:56','2019-12-27 13:25:54'),(15,'Neha','neha.rana@willshall.com',NULL,'$2y$10$tIxXBvNhPGVj1nSm.hX27u8T6HNnAaAYnMNrTBj4x6bufh7lgOk8.',NULL,3,3,0,NULL,'2019-12-26 18:49:18','2019-12-26 19:14:49'),(16,'Krishna','krishna@willshall.com',NULL,'$2y$10$nH5H7Lxt8RyvtUZSNfyEtuk8RyrvWVu6ol0TFJ22AQ7yrrTJ1W6Vi',NULL,2,3,1,NULL,'2019-12-26 18:58:32','2019-12-26 21:04:17'),(17,'Deeksha','deeksha@willshall.com',NULL,'$2y$10$XsjvT0UgEXVMOZCyrdMe0e0EzS55XBmmrB1sDu3Y5PggeK/PvVm9y',NULL,4,3,1,NULL,'2019-12-27 14:09:08','2019-12-27 14:09:08'),(18,'Santosh','santosh@willshall.com',NULL,'$2y$10$PJzCsp9fsDtl1NB1X4mMB.hxOmBuvhT7u9vI1d0Zxiu.s46sgZVQ6',NULL,3,3,1,NULL,'2019-12-27 14:10:56','2019-12-27 14:10:56'),(19,'Monica','monica@willshall.com',NULL,'$2y$10$Myqlop6qkmgG/inc2Tj.OeFwSKWu8snPBRH8ILqYSgxeKqVARy706',NULL,3,3,1,NULL,'2019-12-27 14:22:39','2019-12-27 14:22:39'),(20,'Pankaj','pankaj@willshall.com',NULL,'$2y$10$c1ZF.0RszlfWfXH8Qhu5re7a8nVRa3o5vVDoarTkyXeZvo6nxqtSy',NULL,2,3,1,NULL,'2019-12-27 14:27:11','2019-12-27 14:27:11'),(21,'Vicky','vicky@willshall.com',NULL,'$2y$10$tTxXW7gCqaMqXS1.gOgxleha1pGPYijj66ZrRJ8E1bAGiP0N7muXO',NULL,NULL,3,0,NULL,'2019-12-27 14:50:19','2019-12-27 14:50:19'),(22,'Sudiksha','sudiksha@willshall.com',NULL,'$2y$10$RhxMs9DPNQ3I2NEu6TSUhOZmZ3VmoAD0SjCe3NP37P09Iyn2EzwDS',NULL,NULL,3,0,NULL,'2019-12-27 14:53:28','2019-12-27 14:53:28'),(23,'Sachin Sharma','sachinssachin@gmail.com',NULL,'$2y$10$YWmctSSUTmTFdteUCtbVc.Ps9S7AqMkw0cmi.Yf1o35jaCES5hpMu',NULL,2,3,1,NULL,'2019-12-27 17:46:35','2019-12-27 18:14:12'),(24,'kkjdkdksdad','sdsdsda@gmail.com',NULL,'$2y$10$K2K4YwMO5oByv8ngX36eH.bJ0tjYpxtjgUWQ9d3kWoum3KfaX7A5S',NULL,NULL,3,0,NULL,'2019-12-27 19:29:21','2019-12-27 19:29:21'),(25,'Navpreet','navpreet.kaur@willshall.com',NULL,'$2y$10$ypTTxr3Apb1bbyU2IZ5Gdu.m.Ot/hTcCRDGseqia5W1lS510Wxqg6',NULL,1,3,1,NULL,'2019-12-30 16:56:54','2019-12-30 16:56:54'),(26,'Tester2','tester@gmail.com',NULL,'$2y$10$TCHFzrMCZAEII5py5pgKte8E1eN6eoZ1kq0zeGuUxo6DgEC2lnm2K',NULL,NULL,3,0,NULL,'2019-12-31 11:56:57','2019-12-31 11:56:57');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-12-31  5:43:20
