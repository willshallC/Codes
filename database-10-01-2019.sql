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
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,1,'Coding'),(2,1,'R & D'),(3,1,'Functionality Testing'),(4,1,'Discussions'),(5,1,'Miscellaneous'),(6,2,'Design'),(7,2,'Front End Development'),(8,3,'Search Engine Optimization'),(9,3,'Social Media Optimization'),(10,3,'Search Engine Marketing'),(11,3,'Social Media Marketing'),(12,3,'Content Writing'),(13,4,'Bidding Jobs'),(14,4,'Email Response'),(15,4,'Client Calling / Chatting'),(16,4,'Proposals Making'),(17,4,'Team Discussion'),(18,4,'Miscellaneous'),(19,5,'Resource Hunting'),(20,5,'Interviews'),(21,5,'Employee Interaction'),(22,5,'Job Posting'),(23,5,'Miscellaneous'),(24,6,'Website Testing'),(25,6,'Bug Verification'),(26,6,'Team Discussion '),(27,6,'Miscellaneous'),(28,3,'Miscellaneous'),(29,2,'Miscellaneous');
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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dsr`
--

LOCK TABLES `dsr` WRITE;
/*!40000 ALTER TABLE `dsr` DISABLE KEYS */;
INSERT INTO `dsr` VALUES (5,26,8,22,39,'2020-01-09',120,'Today,  I have done 2 activities like guest post outreach, and podcast submissions.',NULL,'2020-01-09 14:48:25','2020-01-09 14:49:57'),(6,35,8,22,39,'2020-01-09',90,'I have done two SEO activities for this project: Business listing, and Guest post outreach',NULL,'2020-01-09 15:04:10','2020-01-09 20:38:29'),(7,34,8,22,39,'2020-01-09',150,'I have done two activities for this project: classified ads and guest post outreach',NULL,'2020-01-09 18:31:29','2020-01-09 18:31:51'),(8,27,8,22,39,'2020-01-09',120,'Done two SEO off-page activities for this project :\r\nPPT Submissions\r\nPDF Submissions',NULL,'2020-01-09 20:29:21','2020-01-09 20:29:21');
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
  `info` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `qualification` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `current_salary` int(7) DEFAULT NULL,
  `phone_personal` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_emergency` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `employee_profile`
--

LOCK TABLES `employee_profile` WRITE;
/*!40000 ALTER TABLE `employee_profile` DISABLE KEYS */;
INSERT INTO `employee_profile` VALUES (1,3,'Male','2019-02-14',3,'Magento 1 & 2, laravel , Html , Css , Javascript , jQuery , Codeigniter, MySQL','Technocrat. Have good hands on Core level coding.','BCA','1995-10-07',NULL,'9898989898','9898989897','Test','Test','Single',NULL,NULL,NULL),(2,10,'Male','2014-12-03',4,'Core php , Laravel , Magento 1 & 2 , Wordpress , codeigniter , javascript , jQuery , Mysql','Core php , Laravel , Magento 1 & 2 , Wordpress , codeigniter , javascript , jQuery , Mysql','B.Tech','1992-01-11',NULL,'9023287131','9878541012','Near Shivalic homes, Sector 127, Mohali , Punjab','V.P.O. Matorda , Teh. Nabha, Distt.  Patiala, Punjab','Married',NULL,NULL,NULL),(10,4,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(11,2,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(12,27,'Female','2018-02-01',2,'Business Analyst','','Btech','1991-11-19',NULL,'8386841355','8386841355','2506 E sunny enclave','2506 E sunny enclave','Single',NULL,NULL,NULL),(13,28,'Female','2018-02-01',2,'Digital Marketing','','B.tech - Electrical Engineering','1993-02-04',NULL,'9736296504','09815038667','House No. 1560 Phase 5 Mohali','House No. 1442 Near Govt. degree college Una Distt Una (H.P.)','Single',NULL,NULL,NULL),(14,29,'Female','2019-12-18',2,'Digital Marketing Services','','B.Tech','1991-12-15',NULL,'8580715268','8091457410','House no. 122, 3b2 Mohali','House no. M-31, Housing Board Colony, Dharamshala (H.P)','Single',NULL,NULL,NULL),(15,30,NULL,'2020-01-02',2,NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(16,31,'Male','2019-09-09',2,'SEO, SMO','My key skills are SEO & SMO. I can work on websites to get their ranking on top & I can also work on Social Media to grow business through Social Media.','B.C.A','1994-12-26',NULL,'7508664627','8146466609','K- no 13, Phase-4, Sector 59, Mohali','B-14/185, Vaidan Mohalla, Nawanshahr, Distt. Shaheed Bhagat Singh Nagar','Single',NULL,NULL,NULL),(17,32,'Female','2019-08-19',2,'Reading, writing, SEO','I can complete my task with punctuality and with complete dedication. And my core skills are: Reading the article and writing on any topic at the relevant time. Traveling and making friends is something that defines my nature.','B.tech (CSE)','1996-11-02',NULL,'9115834361','8847676858','Phase 5 House no. 1588','Old Shahpur Road, Pathankot','Single',NULL,NULL,NULL),(18,33,'Female','2019-07-22',4,'SEO, SMO, SMM, ORM, SEM, ASO','Hey there, I am working as an SEO Team lead. Dancing, Gyming & Travelling are some of my hobbies. I am little stubborn but getting work done within time is my specialty!','B.Tech','1994-07-12',NULL,'7018512192','8288940742','House Number 661, Phase 3B1, Mohali','Vill. Hardwal Lahar, Post Office Suder Lahar, teh. Khundian, Distt. Kangra, Pin 176030, HP','Single',NULL,NULL,NULL),(19,34,'Female','2019-07-04',2,'SEO, SMO','My key skills is SEO and SMO. I\'m capable to increase more traffic on website. I can also work on social media marketing to help businesses establish themselves. Further, I\'m creative person and I like dancing, adventure.','MCA','1995-02-04',NULL,'7985996844','9625255244','Mohali, Phase 5, House no. 1632','V.P.O Mangnoti, Teh- Barsar, Distt- Hamirpur','Single',NULL,NULL,NULL),(20,35,'Male','2019-02-11',4,'PPC','Trainer and Motivator of the WillShall\'s digital marketing team. Kudos..!','MCA','1990-11-10',NULL,'9996097184','9896107181','160/2, Sector - 45a, Chandigarh','Kurukshetra, Haryana','Single',NULL,NULL,NULL),(21,36,'Male','2019-11-26',2,'SEO','','B-TECH','1997-05-20',NULL,'6280105676','9781753269','#2783 Sector 38 W (CHD)','#2783 Sector 38 W (CHD)','Single',NULL,NULL,NULL),(22,37,'Female','2018-01-04',2,'SMO, SEO','I am capable of managing SEO & SMO. Further, I can also help businesses to grow on Social Media. I love working on the Instagram platform. I am a shopaholic person and I love dancing too.','MCA','1992-09-20',NULL,'8558008969','9877131372','HNO. 235, Shanti Nagar Manimajra Chandigarh','HNO. 235, Shanti Nagar Manimajra Chandigarh','Single',NULL,NULL,NULL),(23,38,'Male','2019-12-18',2,'SEO','','B.A (pursuing)','1999-09-17',NULL,'8619996364','7297066482','Phase-3 shahi majra mohali','Kamtaul kot patty darbhanga bihar','Single',NULL,NULL,NULL),(24,39,'Female','2019-05-27',2,'SEO, SMO, Email Marketing, Content Writing','I am working as an SEO Executive. My hobbies are listening to music, traveling, and reading good books. My key skills are SEO, SMO, Content Writing, Email Marketing and learning stage in paid marketing. My Speciality, I always give my 100% for improving website ranking and achieve the best results for every project.','MCA','1993-12-01',NULL,'8360214356','9888512026','H.no. 1477, phase 3B2 Mohali','Vpo Dala Distt Moga Pin code 142011','Single',NULL,NULL,NULL),(26,41,'Male','2019-09-25',2,'writing','My key skill is writing. I can create interesting and engaging content on any given topic in confined words and time.','Graduation(BA)','1998-12-23',NULL,'7831068334','7018725849','House Number 1105, Guru Nanak Enclave, Daun, Mohali','MC Dari, Near Tea Factory, Dharamshala, Himachal Pradesh','Single',NULL,NULL,NULL),(27,42,'Female','2017-02-20',3,'Wordpress, Codeigniter, Core PHP, Shopify, Jquery, Plugin Customisation, Theme Customisation','Wordpress, Codeigniter, Core PHP, Shopify','B.Tech(CSE)','1990-01-05',NULL,'7347447008','9915676299','Phase 5, Mohali','Gurdaspur','Married',NULL,NULL,NULL),(28,43,NULL,'2019-06-18',1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(29,44,'Male','2018-10-15',2,'Core PHP, Wordpress, Magento, OpenCart, Shopify, jQuery','Core PHP, Wordpress, Magento, OpenCart, Shopify, jQuery','PGDCA','1994-02-09',NULL,'9465513961','9198238249','#263 badmajra Post: balaungi Dist: mohali Punjab (140301)','Vill: padari mehadiya Post: khajuri bazar Dist: kushinagar up (274305)','Single',NULL,NULL,NULL),(30,45,'Male','2015-11-23',3,'HTML/CSS, Bootstrap, Photoshop, CorelDRAW, WordPress, Shopify, BigCommerce, Business Catalyst, Laravel, Magneto 1 & 2, Basic jQuery.','The life of a designer is a life of fight.','Bachelor of Computer Application','1994-01-05',NULL,'9569920319','7986958612','# 6, Ward No. 4, Sector 127, Mohali, Punjab','Village kuru, PO Dehra, Teh. Dehra, District Kangra (HP) Pin code 177101','Single',NULL,NULL,NULL),(31,46,'Male','2013-05-21',4,'HTML/CSS, JQuery, Photoshop, Illustrator, Wordpress, Shopify, Bigcommerce, Prestation, Business Catalyst, Website Builders.',NULL,'BSC(IT)','1989-12-12',NULL,'9646615506','9877806079','# 7, Ward No. 5, Sector 115, Mohali','# 7, Ward No. 5, Sector 115, Mohali','Married',NULL,NULL,NULL),(32,47,'Male','2012-09-03',3,'HTML5, CSS3, Bootstrap, Photoshop, Illustrator','.','Master of Computer Application','1988-07-11',NULL,'9888149397','8527130453','#3291, 35D, CHANDIGARH','#3291, 35D, CHANDIGARH','Single',NULL,NULL,NULL),(34,49,'Female','2019-06-24',2,'HTML/CSS, Bootstrap, Dreamweaver, Photoshop, CorelDRAW, Illustrator','Design is intelligence made visible','BSc IT','1997-07-01',NULL,'9878415851','7830897108','#1561 , Sector 34D, Chandigarh','Dist- Bageshwar, State-Uttarakhand','Single',NULL,NULL,NULL),(35,50,'Male','2019-12-09',2,'HTML/CSS, Bootstrap,J Query, Photoshop, WordPress, Shopify, AI.','I am instrested working on html css. Playing cricket is my hobby.','B.tech','1996-02-13',NULL,'9988791964','7719652891','Dashmesh marcket Blongi','patna Bihar','Single',NULL,NULL,NULL),(37,52,'Female','2018-05-29',2,'HR and Marketing','Above Information is enough.','MBA','1994-10-25',NULL,'8968915107','9888785515','#1671, Phase7, Mohali','#2355, Railway Colony, Patiala, Punjab','Single',NULL,NULL,NULL),(38,53,'Male','2018-04-25',2,'HTML/CSS, Bootstrap, Basic JQuery, Photoshop, WordPress, Shopify, Bigcommerce, Business Catalyst.','Nothing else....!','+2','1993-10-27',NULL,'7508259134','7508259134','#1099 Sec. 24 B CHD.','Hamirpur, Himachal Pradesh','Single',NULL,NULL,NULL);
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
  `user_id` int(11) unsigned NOT NULL,
  `relation_status` int(11) NOT NULL COMMENT '''1'' = ''active'',''0'' = ''deactivated''',
  PRIMARY KEY (`id`),
  KEY `project_id` (`project_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `fk_project_id` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=188 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `project_user_relation`
--

LOCK TABLES `project_user_relation` WRITE;
/*!40000 ALTER TABLE `project_user_relation` DISABLE KEYS */;
INSERT INTO `project_user_relation` VALUES (91,40,52,1),(92,40,34,1),(93,40,38,1),(94,40,29,1),(95,40,3,1),(96,40,31,1),(97,40,44,1),(98,40,10,1),(99,40,49,1),(100,40,37,1),(101,40,42,1),(102,40,27,1),(103,40,33,1),(104,40,53,1),(105,40,47,1),(106,40,28,1),(107,40,46,1),(108,40,36,1),(109,40,43,1),(110,40,35,1),(111,40,32,1),(112,40,41,1),(113,40,39,1),(114,40,50,1),(115,40,45,1),(120,26,35,1),(121,26,39,1),(122,27,35,1),(123,27,39,1),(124,34,35,1),(125,34,39,1),(126,35,35,1),(127,35,39,1),(128,36,35,1),(129,36,39,1),(130,38,52,1),(131,38,34,1),(132,38,38,1),(133,38,29,1),(134,38,3,1),(135,38,31,1),(136,38,44,1),(137,38,10,1),(138,38,49,1),(139,38,37,1),(140,38,42,1),(141,38,27,1),(142,38,33,1),(143,38,53,1),(144,38,47,1),(145,38,28,1),(146,38,46,1),(147,38,36,1),(148,38,43,1),(149,38,35,1),(150,38,32,1),(151,38,41,1),(152,38,39,1),(153,38,50,1),(154,38,45,1),(155,41,35,1),(156,41,32,1),(157,42,35,1),(158,42,32,1),(159,43,36,1),(160,43,35,1),(161,44,36,1),(162,44,35,1),(163,45,36,1),(164,45,35,1),(165,46,36,1),(166,46,35,1),(167,47,38,1),(168,47,35,1),(169,48,38,1),(170,48,35,1),(171,49,38,1),(172,49,35,1),(173,50,35,1),(174,51,35,1),(175,52,35,1),(176,53,37,1),(177,53,33,1),(180,54,37,1),(181,54,33,1),(182,55,37,1),(183,55,33,1),(184,56,37,1),(185,56,33,1),(186,57,31,1),(187,57,33,1);
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
  `project_title` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `start_date` timestamp NULL DEFAULT NULL,
  `end_date` timestamp NULL DEFAULT NULL,
  `priority` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `billing_type` int(1) DEFAULT NULL COMMENT '''1'' = ''Fixed'', ''2'' = ''Hourly''',
  `project_cost` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hourly_rate` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `platform` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `upwork_profile_name` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `time_allocated` int(10) DEFAULT NULL,
  `client_name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `client_email` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `client_skype` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `client_country` varchar(70) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sales_executive` int(2) DEFAULT NULL,
  `hired_by_other` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) NOT NULL COMMENT '''1'' = ''Active'', ''2'' = ''Completed'', ''3'' = ''On-Hold'', ''4'' = ''Canceled'', ''5'' = ''Dispute''',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `department_ids` (`department_ids`)
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `projects`
--

LOCK TABLES `projects` WRITE;
/*!40000 ALTER TABLE `projects` DISABLE KEYS */;
INSERT INTO `projects` VALUES (26,3,'Smart Color Pen','https://www.smartcolorpen.com/','2019-12-09 07:00:00',NULL,'Medium',NULL,2,NULL,'$6','Upwork','Ragini',2400,'Steven',NULL,NULL,'United States',28,NULL,1,'2020-01-02 15:20:39','2020-01-10 00:04:54'),(27,3,'Amazon Product','https://www.amazon.com/Plastic-Dinner-Disposable-Dinnerware-Eco-Friendly/dp/B07L461FBY','2019-08-09 07:00:00',NULL,'Medium','Initially Client came for Google ads. We Set up Google ads and Ads are running fine but client want an Organic traffic as well for this particular link so we are doing SEO.',2,NULL,'$5','Upwork','Priya',2400,'Michael',NULL,NULL,'United States',30,'Ranjana',1,'2020-01-02 15:28:26','2020-01-10 00:05:15'),(34,3,'Goldelucks','https://www.goldelucks.com.au/','2019-10-19 07:00:00',NULL,'Medium','The client\'s website is already rank in Google results but the Client wants to improve the Ranking of highly competitive keywords.',2,NULL,'$5','Upwork','Sakshi',2400,'Phillip Kay',NULL,NULL,'Australia',28,NULL,1,'2020-01-09 00:23:30','2020-01-10 00:06:07'),(35,3,'Masrm','https://www.masrm.com.au/','2019-12-09 07:00:00',NULL,'Medium','The client assigned as 40 hours to rank his website and we have completed 25 hours successfully and his website is ranked in Good position now.',2,NULL,'$6','Upwork','Sandeep',2400,'Karina',NULL,'karininha_silva','Australia',28,NULL,1,'2020-01-09 00:31:53','2020-01-10 00:06:37'),(36,3,'Instagram marketing expert','https://www.instagram.com/sofiahabits/','2019-12-02 07:00:00',NULL,'Medium',NULL,2,NULL,'$8','Upwork','Mamta',1200,'Martynas Kairys',NULL,NULL,'United States',28,NULL,1,'2020-01-09 00:36:22','2020-01-10 00:06:56'),(38,5,'Office Event/Activities',NULL,'2020-01-01 07:00:00',NULL,NULL,NULL,2,NULL,'0','Direct',NULL,1200,'Office Event',NULL,NULL,NULL,30,'Office',1,'2020-01-09 16:07:17','2020-01-10 00:07:48'),(40,6,'Miscellaneous Work/Discussion',NULL,'2020-01-01 07:00:00',NULL,NULL,NULL,2,NULL,'0','Direct',NULL,1500,'Miscellaneous Work/Discussion',NULL,NULL,NULL,30,'Office',1,'2020-01-09 18:46:21','2020-01-09 20:52:40'),(41,3,'The Campus Advisor','https://thecampusadvisor.com/','2019-08-18 07:00:00',NULL,NULL,'\"We discussed 20 keywords to do SEO work but we have only 18 Keywords. Initially, there were 13 keywords to target but recently add 5 more keywords.\r\n\"',2,NULL,'$6','Upwork','Ragini',2400,'Brian Moran',NULL,NULL,'United States',28,NULL,1,'2020-01-10 00:00:20','2020-01-10 00:08:59'),(42,3,'VB Studio','http://www.vbstudionyc.com/','2018-10-16 07:00:00',NULL,NULL,NULL,2,NULL,'$5','Upwork','Mamta',2400,'Haven',NULL,NULL,'United States',28,NULL,1,'2020-01-10 00:16:06','2020-01-10 00:17:31'),(43,3,'AShoeAddiction','https://ashoeaddiction.com.au','2019-08-20 07:00:00',NULL,NULL,'We Were running Facebook and Instagram Ads for this client but now we are doing SEO for her.',2,NULL,'$5','Upwork','Sandeep',2400,'Candice',NULL,NULL,'Australia',28,NULL,1,'2020-01-10 00:31:31','2020-01-10 00:31:31'),(44,3,'Haven Color Bar','https://www.havencolorbar.com/','2018-10-16 07:00:00',NULL,NULL,NULL,2,NULL,'$5','Upwork','Mamta',3600,'Haven',NULL,NULL,'United States',28,NULL,1,'2020-01-10 00:35:46','2020-01-10 00:35:46'),(45,3,'Palm Salon','http://palms-salon.com/','2018-12-01 07:00:00',NULL,NULL,NULL,2,NULL,'$5','Upwork','Mamta',3600,'Haven',NULL,NULL,'United States',28,NULL,1,'2020-01-10 00:41:15','2020-01-10 00:41:15'),(46,3,'Toronto Psychological Services',NULL,'2019-05-08 07:00:00',NULL,NULL,NULL,1,'$225',NULL,'Upwork','Ragini',1200,'Jancy king',NULL,NULL,'United States',30,'Ranjana',1,'2020-01-10 00:45:14','2020-01-10 00:45:14'),(47,3,'Stone Depot','http://stonedepotgh.com/','2019-06-14 07:00:00',NULL,NULL,NULL,2,NULL,'$5','Upwork','Neha',2400,'Elias Hage',NULL,NULL,'United States',27,NULL,1,'2020-01-10 00:50:54','2020-01-10 00:50:54'),(48,3,'Agalliu Contracting','https://agalliucontracting.com','2018-12-01 07:00:00',NULL,NULL,NULL,1,'$220',NULL,'Upwork','Mamta',2400,'Haven',NULL,NULL,'United States',28,NULL,1,'2020-01-10 00:54:04','2020-01-10 05:00:27'),(49,3,'Transfer Content','https://www.dropbox.com/','2019-12-30 07:00:00',NULL,NULL,NULL,2,NULL,'$5','Upwork','Monica',4800,'Sab Salem',NULL,NULL,'United States',28,NULL,1,'2020-01-10 00:57:28','2020-01-10 00:57:28'),(50,3,'Sai Global',NULL,'2019-12-16 07:00:00',NULL,NULL,NULL,1,'$500',NULL,'Upwork','Mamta',0,'Tom Sadler',NULL,NULL,NULL,28,NULL,1,'2020-01-10 01:00:38','2020-01-10 01:00:38'),(51,3,'Muza Medical','https://muzamedical.co.uk/','2019-12-19 07:00:00',NULL,NULL,NULL,2,NULL,'$8','Upwork','Ragini',0,'Ani Muhayen',NULL,NULL,NULL,28,NULL,1,'2020-01-10 01:03:15','2020-01-10 01:03:15'),(52,3,'eQatar',NULL,'2019-12-26 07:00:00',NULL,NULL,NULL,1,'$150',NULL,'Upwork','Heena',1500,'Tariq AlSheikh',NULL,NULL,'Qatar',27,NULL,1,'2020-01-10 01:06:05','2020-01-10 01:06:05'),(53,3,'Madeline Brick Oven Pizza','https://madelineeastnash.com/','2019-04-12 07:00:00',NULL,NULL,'Facebook & Instagram only.',2,NULL,'$5','Upwork','Arti',2400,'Adam Payz',NULL,'Whatsapp','United States',28,NULL,1,'2020-01-10 01:13:11','2020-01-10 01:13:11'),(54,3,'Smart Mini Care','https://www.instagram.com/smartminicare/','2019-11-29 07:00:00',NULL,NULL,NULL,1,'$200',NULL,'Upwork','Mamta',2400,'Mo Daher',NULL,NULL,'United Kingdom',28,NULL,1,'2020-01-10 01:17:32','2020-01-10 01:18:34'),(55,3,'Prestige Event Rentals','https://www.prestigeeventrentals.com/','2019-10-12 07:00:00',NULL,NULL,NULL,2,NULL,'$5','Upwork','Sakshi',2400,'Dominique White',NULL,NULL,'United States',28,NULL,1,'2020-01-10 01:20:55','2020-01-10 01:20:55'),(56,3,'BMonStore','https://www.bmonstore.com/','2019-08-12 07:00:00',NULL,NULL,'Need leads.',1,'$00',NULL,'Direct',NULL,2400,'BMonStore',NULL,NULL,'United States',30,'Manoj',1,'2020-01-10 01:28:44','2020-01-10 05:02:07'),(57,3,'Madame A. Lingerie','https://www.instagram.com/madamea.lingerie/','2019-12-09 07:00:00',NULL,NULL,'https://www.facebook.com/madameabrand',1,'$145',NULL,'Upwork','Monica',2400,'Julie Antunes',NULL,'Whatsapp','Australia',28,NULL,1,'2020-01-10 01:31:44','2020-01-10 01:31:44');
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
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (2,'Sachin Sharma','sachin@willshall.com',NULL,'$2y$10$t0ufXBC85qzuVFQ24G28YuWzIIPh55x0B2nnkwXT7ukP7ZxZzyyQW',NULL,0,1,1,'willshall.svg','2019-11-29 17:09:34','2020-01-10 00:18:22'),(3,'Deepak Kumar','deepak.kumar@willshall.com',NULL,'$2y$10$WOxgVe7mMB2arhx..vhA0ONBK5RUxL4L.k3NafMrgmX8hY9LcBGDy','PKNs80yRDzznqC6duCNTzkkqDfcMT9yaMBruwc5JC8UxDiaCra2q7NVHGDgU',1,3,1,'XuCkkHnShMeOPxlUf3GucOmUpm0UyFWbM8J1lXMU.png','2019-12-03 13:55:32','2020-01-09 20:48:28'),(4,'Admin','admin@black.com',NULL,'$2y$12$63W7IIEvM/7YYqUSBeoFsu1uI7opcQ3I632tgQTrhgsde4SKonkw2',NULL,0,1,1,NULL,'2019-12-02 07:00:00','2019-12-09 19:02:18'),(10,'Kirandeep Singh','kirandeep.singh@willshall.com',NULL,'$2y$10$rhVjMlPU2sKE7TFihRRYPeWx6Q8PN2fWAJ5UX.22c5kv4RSGQzQbK',NULL,1,3,1,'UvKI5tUusi5qsW8lEbxNHtJsVYXu5pglTwqX4MLz.png','2019-12-19 14:08:58','2019-12-19 14:08:58'),(27,'Neetika Passi','neetika.passi@willshall.com',NULL,'$2y$10$7CI70YRtghlqclK7Xi6.R.r9wLTyGA0.Dm36xZPXrrtc/xSqM/9vq',NULL,4,3,1,'ORCNCGKqZXgs7VkQboNtJGD5rrWGrAymFTtWZDpT.png','2020-01-01 17:38:03','2020-01-03 13:33:38'),(28,'Rita Saini','rita.saini@willshall',NULL,'$2y$10$GotIxeZHpPSWWfXzQHihmOYlKtjxZFSfzXY1LNxyh2FMCFf8UKYxy',NULL,4,3,1,NULL,'2020-01-01 17:38:16','2020-01-01 18:27:25'),(29,'Deeksha Bharti','deeksha.bharti@willshall.com',NULL,'$2y$10$aOkRZ4OoalJNwa6j.kiHBOZyu8P/NO3GHWt/Qts6H2YAgluVKtNXK',NULL,4,3,1,NULL,'2020-01-01 17:41:57','2020-01-03 13:32:55'),(30,'Other','other@willshall.com',NULL,'$2y$10$HdlHkRA82vy9mUXey8jVKuKCPJmTLc0IWIYUrMEdULGNAk7T05avK',NULL,4,3,1,NULL,'2020-01-02 12:08:29','2020-01-02 12:10:55'),(31,'Hitesh Raj','hitesh.raj@willshall.com',NULL,'$2y$10$FPT4bNcYw4XeluSla2h37OqJDuYlMImHAP8lAz04uHTsz5iPBr81u',NULL,3,3,1,'Whs1Mdf3BDoFNPcQPjO0jUUA6Y0asjKKnTn6ORpW.jpeg','2020-01-02 16:02:56','2020-01-02 19:03:49'),(32,'Sudhiksha Mahajan','sudhiksha.mahajan@willshall.com',NULL,'$2y$10$vxAxndQDUQMEmq/o.YQEcueT.KX3kLfBLzXRmnUfp49BriisN4icu',NULL,3,3,1,'ojhJe61W7qXQbiY3MmW9M40mJqPnGuyRnya7JolR.png','2020-01-02 16:03:42','2020-01-02 16:26:30'),(33,'Neha Rana','neha.rana@willshall.com',NULL,'$2y$10$oSWqTe.hV2sEOhfj.8JbF.aidgwR4MvzJ0CS4bi3oE59pskeLoHw.',NULL,3,3,1,'bV6zkAohIeGCgwCGx1Up1GRAlkmiGF8lCjcLzXBV.jpeg','2020-01-02 16:03:58','2020-01-02 16:22:28'),(34,'Anjali Sharma','anjali.sharma@willshall.com',NULL,'$2y$10$4qz3vktcOnvCsphMoMaWxOatOhbVxAuEegos0jEl.gyPgGAn0jW9K',NULL,3,3,1,'tPVBjSOdFbY9ValfgdBN1enFNCn3JQbkef53yAST.jpeg','2020-01-02 16:07:05','2020-01-03 13:32:27'),(35,'Sourabhdeep Singh','sourabhdeep.singh@willshall.com',NULL,'$2y$10$zMgcEDUtjG9zwLidDbC/IumocdeRl.0NM3XbFT/Ku2y4ZQoYg4hla',NULL,3,3,1,'r88GSZhrec8cL8HviP4AOU9HRDcx15v0Nf6vvMoV.png','2020-01-02 16:07:55','2020-01-02 16:24:53'),(36,'Santosh Kumar','santosh.kumar@willshall.com',NULL,'$2y$10$ADjfF9JeppXhDoJEAFw3Iu9kIyTUFQRJEqwwbyBhppTR.uL0Orf2.',NULL,3,3,1,'lB5cCU7j9stZI2Rt35ba05AYjBVezFuTbkTIbyIo.png','2020-01-02 16:08:25','2020-01-02 16:24:02'),(37,'Monica Chaudhary','monica.chaudhary@willshall.com',NULL,'$2y$10$i6xLNCnxkjeL99wvyztUO.zyOCui.P3mOYcdPBaCRcERHMLCYSnxu',NULL,3,3,1,'f4zqNSpjqcZxc9eJgeSW1WvmfKwVg7yCjgwR7Axd.png','2020-01-02 16:08:28','2020-01-02 16:20:23'),(38,'Avinash Kumar','avinash.kumar@willshall.com',NULL,'$2y$10$0A2mtkIYKdT0mko1K7AyxORImyQh9thfJl0Op9Y0epiNmvkdUpO7y',NULL,3,3,1,'Fjg8Ogxl8Rywz5vhDHUND0Oe4iYecrvUBYSqJdCD.jpeg','2020-01-02 16:09:42','2020-01-02 16:23:12'),(39,'Tarvinder Kaur','tarvinder.kaur@willshall.com',NULL,'$2y$10$kMegslsMwfJrKLEP8c9Wzer6v6jM300N3wFC70xy8g/ohKWOkX9k.',NULL,3,3,1,'1O5IcfzC1UK9fHyNxgQMn5wmFmsidwtHlBQlyRAm.png','2020-01-02 16:12:14','2020-01-03 13:33:52'),(41,'Suhail Thapa','suhail.thapa@willshall.com',NULL,'$2y$10$WD5cbpYhhcUrj/APZkyV/.jln193SjD5L0pIGg/aHPBgtUyUoQpeK',NULL,3,3,1,'wcyNIa1EVxdblzMXVbP22RwCnAF0qrQEq4B7RuH9.png','2020-01-02 16:30:15','2020-01-02 16:44:53'),(42,'Navpreet Kaur','navpreet.kaur@willshall.com',NULL,'$2y$10$QuAQv4Ub8SQeBBGbM2JYM.as51l8JgBBSR4jMwo1ZOMnUfcBODqW6',NULL,1,3,1,'9MUJ8CQt7TDQhM0R69TB7YAvZQD7yz6lEJjwy7Ts.png','2020-01-03 13:22:19','2020-01-03 13:50:10'),(43,'Satish Yadav','satish.yadav@willshall.com',NULL,'$2y$10$kK28R.AZXZSvT7Ttr7zYReivU1IzP8wTncTCOxzFhWoOCRTVigs0u',NULL,1,3,1,NULL,'2020-01-03 13:25:35','2020-01-03 18:13:34'),(44,'Jai Prakash Singh','jai.prakash@willshall.com',NULL,'$2y$10$.wc9UJLWR0gqST9RPI3oE.0AeHKtIJp3SjpVfVcW7ydWlxivtLwlS',NULL,1,3,1,'rFn2RmJ4bkSpibkQfEiSGMMW16BSzezoxRgRuX8L.png','2020-01-03 13:43:08','2020-01-03 17:55:04'),(45,'Vivek Thakur','vivek.thakur@willshall.com',NULL,'$2y$10$Lgz2cIHJAlthAZyH4VJIwue7pREw4B8DXngaQG6e80getCwq5bZem',NULL,2,3,1,'ihG6q41lFw82ui3Q7wsWnVR9Ke1YA8dgTHYibJcL.png','2020-01-03 13:43:13','2020-01-03 17:57:36'),(46,'Sampuran Singh','happy.singh@willshall.com',NULL,'$2y$10$mC2gXmp3zvjOXzk/Y2jQr.NXBF49gP2Wuiq.Ma3Vf/7hCwUdLWSn2',NULL,2,3,1,'ZJznrK5k6PhIVU46ET02nVUrjVaNpsErJfPjwg01.png','2020-01-03 13:45:23','2020-01-03 13:52:31'),(47,'Paras Makhaik','paras.makhaik@willshall.com',NULL,'$2y$10$xv/xe9bX8hXyp853ysHKZ.VXPQu0PW2bQ07n0VsMHUVeVXY4qlNmm','y6J7JeOdfN52zIuucoCgWekd7T6n4rQkdGFIL0soWDkzGpTP5I10zevp0JEl',2,3,1,'i4snwyt26ZRWyAVfjftM9GydyghpeFMg5ViIN8Y8.png','2020-01-03 13:46:27','2020-01-03 18:19:14'),(49,'krishna Rautela','krishna.rautela@willshall.com',NULL,'$2y$10$Teqz5ryHm1/5kf7ATMN6i.HCf8Ck9ljxSVH02Q0hYRFDuhpvTBxW6',NULL,2,3,1,'A0INJhZp9sbPJajGFnJw7zP16BYh29IGcmJDEfuI.jpeg','2020-01-03 13:48:29','2020-01-03 19:47:25'),(50,'Vicky Kumar','vicky.kumar@willshall.com',NULL,'$2y$10$Xjw79HLyC50WNkSq7tpdKOJn1byDNReC.t/FXT6bLZcAxIgIm0MHy',NULL,2,3,1,'GkIOO4y6XvFoDf0lE2HO8oUt6OoslaCX9fluSevA.jpeg','2020-01-03 13:59:37','2020-01-03 17:58:44'),(52,'Agam Sharma','agam.sharma@willshall.com',NULL,'$2y$10$lbOAfAju6AARhKuj0Edl6OcBzwiFBlMkkvKmFJ4XnpYsMQY4xRZv.',NULL,5,3,1,'QVypBcWMwr11FfIH0vNrqYqPS8yJSIYQkxXDnNTt.jpeg','2020-01-03 17:29:10','2020-01-03 17:30:28'),(53,'Pankaj Rana','pankaj.kumar@willshall.com',NULL,'$2y$10$ewZkQfnvoGYdpqvr3zL1Z.vi1DP47cK/QRHYKHTvHtVZJkt4Qiu1C',NULL,2,3,1,'NIibYQ1WyStgIEG8q1OL2pGyQImCvudcm8Wa5VOK.png','2020-01-03 18:13:43','2020-01-03 18:15:40');
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

-- Dump completed on 2020-01-09 22:41:46
