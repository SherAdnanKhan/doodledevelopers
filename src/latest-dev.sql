-- MySQL dump 10.17  Distrib 10.3.22-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: oil_dev_db
-- ------------------------------------------------------
-- Server version	10.3.22-MariaDB

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
-- Table structure for table `action_events`
--

DROP TABLE IF EXISTS `action_events`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `action_events` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `batch_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `actionable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `actionable_id` bigint(20) unsigned NOT NULL,
  `target_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `target_id` bigint(20) unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) unsigned DEFAULT NULL,
  `fields` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'running',
  `exception` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `original` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `changes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `action_events_actionable_type_actionable_id_index` (`actionable_type`,`actionable_id`),
  KEY `action_events_batch_id_model_type_model_id_index` (`batch_id`,`model_type`,`model_id`),
  KEY `action_events_user_id_index` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `action_events`
--

LOCK TABLES `action_events` WRITE;
/*!40000 ALTER TABLE `action_events` DISABLE KEYS */;
INSERT INTO `action_events` VALUES (1,'90551a81-507e-4a80-8da1-961eb2b1a1b6',1,'Create','App\\Tennant',1,'App\\Tennant',1,'App\\Tennant',1,'','finished','','2020-04-15 11:58:33','2020-04-15 11:58:33',NULL,'{\"name\":\"PDJ\",\"updated_at\":\"2020-04-15 11:58:32\",\"created_at\":\"2020-04-15 11:58:32\",\"id\":1}'),(2,'90553d80-1694-4cd0-98ff-dd1ffe7a03ca',1,'Create','App\\Tennant',2,'App\\Tennant',2,'App\\Tennant',2,'','finished','','2020-04-15 13:36:24','2020-04-15 13:36:24',NULL,'{\"name\":\"Roberts\",\"updated_at\":\"2020-04-15 13:36:24\",\"created_at\":\"2020-04-15 13:36:24\",\"id\":2}'),(3,'90553f90-2808-4db5-b9e8-af71550c8649',1,'Create','App\\Customer',1,'App\\Customer',1,'App\\Customer',1,'','finished','','2020-04-15 13:42:10','2020-04-15 13:42:10',NULL,'{\"tennant_id\":1,\"account_number\":\"00001\",\"customer_name\":\"Jamie McDonald\",\"customer_address\":\"1 Belle Vue Court\",\"updated_at\":\"2020-04-15 13:42:10\",\"created_at\":\"2020-04-15 13:42:10\",\"id\":1}'),(4,'90553fab-2084-455f-b27a-28527a4c5f28',1,'Update','App\\Customer',1,'App\\Customer',1,'App\\Customer',1,'','finished','','2020-04-15 13:42:27','2020-04-15 13:42:27','{\"account_number\":1}','{\"account_number\":\"1000000001\"}'),(5,'905542e2-9721-463d-a93e-5e0db39d3b6b',1,'Create','App\\Customer',2,'App\\Customer',2,'App\\Customer',2,'','finished','','2020-04-15 13:51:27','2020-04-15 13:51:27',NULL,'{\"tennant_id\":1,\"account_number\":\"11111222\",\"customer_name\":\"JT Global\",\"customer_address\":\"No 1, The Forum etc..\",\"updated_at\":\"2020-04-15 13:51:27\",\"created_at\":\"2020-04-15 13:51:27\",\"id\":2}'),(8,'90554a48-a958-4a73-a3bb-96d098f9ca96',1,'Create','App\\Tennant',3,'App\\Tennant',3,'App\\Tennant',3,'','finished','','2020-04-15 14:12:08','2020-04-15 14:12:08',NULL,'{\"name\":\"WaterWays\",\"updated_at\":\"2020-04-15 14:12:08\",\"created_at\":\"2020-04-15 14:12:08\",\"id\":3}'),(14,'90554bc3-d745-4d65-a761-29962ff78076',1,'Create','App\\User',2,'App\\User',2,'App\\User',2,'','finished','','2020-04-15 14:16:17','2020-04-15 14:16:17',NULL,'{\"name\":\"test\",\"customer_id\":\"1\",\"email\":\"me@jamie-mcdonald.net\",\"type\":\"admin\",\"updated_at\":\"2020-04-15 14:16:17\",\"created_at\":\"2020-04-15 14:16:17\",\"id\":2,\"photo_url\":\"https:\\/\\/www.gravatar.com\\/avatar\\/74f46e02a64f1de5fe56c00f35c17ce2.jpg?s=200&d=mm\"}'),(15,'90554c40-da33-4b9d-9183-226ac04958bf',1,'Update','App\\Customer',1,'App\\Customer',1,'App\\Customer',1,'','finished','','2020-04-15 14:17:39','2020-04-15 14:17:39','{\"customer_name\":\"Jamie McDonald\"}','{\"customer_name\":\"Jersey Electricity\"}'),(16,'90554c53-bc55-46b4-a4c3-fdad08bc668f',1,'Update','App\\User',2,'App\\User',2,'App\\User',2,'','finished','','2020-04-15 14:17:51','2020-04-15 14:17:51','{\"customer_id\":1}','{\"customer_id\":2}'),(17,'90554da0-560d-4639-910c-45788e874d04',1,'Update','App\\User',2,'App\\User',2,'App\\User',2,'','finished','','2020-04-15 14:21:29','2020-04-15 14:21:29','{\"customer_id\":2}','{\"customer_id\":1}'),(18,'90554dcc-46f2-4b1f-b1df-c63574c9b001',1,'Update','App\\User',2,'App\\User',2,'App\\User',2,'','finished','','2020-04-15 14:21:58','2020-04-15 14:21:58','{\"name\":\"test\"}','{\"name\":\"Test User\"}'),(19,'90554dee-abe0-4a13-84ff-293346154345',1,'Update','App\\User',2,'App\\User',2,'App\\User',2,'','finished','','2020-04-15 14:22:21','2020-04-15 14:22:21','{\"customer_id\":1}','{\"customer_id\":2}'),(20,'90554e18-4d04-48ff-bc89-2f56a69cd49f',1,'Update','App\\User',2,'App\\User',2,'App\\User',2,'','finished','','2020-04-15 14:22:48','2020-04-15 14:22:48','{\"customer_id\":2}','{\"customer_id\":1}'),(21,'905584d4-b6aa-4055-88d9-bf19b468e632',1,'Create','App\\Device',1,'App\\Device',1,'App\\Device',1,'','finished','','2020-04-15 16:55:51','2020-04-15 16:55:51',NULL,'{\"euid\":\"12345\",\"tennant_id\":\"1\",\"updated_at\":\"2020-04-15 16:55:51\",\"created_at\":\"2020-04-15 16:55:51\",\"id\":1}'),(22,'90559e7f-bb77-484f-9fd8-2707afd2576b',1,'Create','App\\Tank',1,'App\\Tank',1,'App\\Tank',1,'','finished','','2020-04-15 18:07:37','2020-04-15 18:07:37',NULL,'{\"device_id\":\"1\",\"customer_id\":\"1\",\"tank_address\":\"st johns\",\"lat\":\"00\",\"long\":\"00\",\"pic\":\"00\",\"tank_type\":\"harliquin\",\"setup_by\":\"Jamie\",\"updated_at\":\"2020-04-15 18:07:37\",\"created_at\":\"2020-04-15 18:07:37\",\"id\":1}'),(23,'905749eb-c5ec-4b16-8a45-5e3893d01636',1,'Create','App\\Tank',2,'App\\Tank',2,'App\\Tank',2,'','finished','','2020-04-16 14:02:47','2020-04-16 14:02:47',NULL,'{\"device_id\":1,\"customer_id\":1,\"tank_address\":\"123\",\"lat\":\"1\",\"long\":\"1\",\"pic\":\"1\",\"tank_type\":\"1\",\"setup_by\":\"1\",\"updated_at\":\"2020-04-16 14:02:47\",\"created_at\":\"2020-04-16 14:02:47\",\"id\":2}'),(24,'90575e52-b688-4935-b485-f2a7fa397e8b',1,'Create','App\\Tank_type',1,'App\\Tank_type',1,'App\\Tank_type',1,'','finished','','2020-04-16 14:59:50','2020-04-16 14:59:50',NULL,'{\"name\":\"Harliqin - 1000L\",\"shape\":\"rectangle\",\"length_cm\":\"215\",\"width_cm\":\"69\",\"height_cm\":\"142\",\"diameter_cm\":\"0\",\"volume_litres\":\"1000\",\"updated_at\":\"2020-04-16 14:59:50\",\"created_at\":\"2020-04-16 14:59:50\",\"id\":1}'),(25,'90577469-4cfe-44fa-8780-d87dc21f7fb3',1,'Create','App\\Tank_type',2,'App\\Tank_type',2,'App\\Tank_type',2,'','finished','','2020-04-16 16:01:36','2020-04-16 16:01:36',NULL,'{\"name\":\"Garage Bin - 90l\",\"shape\":\"cylinder\",\"length_cm\":\"0\",\"width_cm\":\"0\",\"height_cm\":\"66\",\"diameter_cm\":\"46\",\"volume_litres\":\"90\",\"updated_at\":\"2020-04-16 16:01:36\",\"created_at\":\"2020-04-16 16:01:36\",\"id\":2}'),(26,'905774a8-c8ea-4099-afaa-07c3a01ff506',1,'Update','App\\Tank_type',2,'App\\Tank_type',2,'App\\Tank_type',2,'','finished','','2020-04-16 16:02:17','2020-04-16 16:02:17','{\"name\":\"Garage Bin - 90l\"}','{\"name\":\"Garage Bin - 90L\"}'),(27,'90577583-e237-46a8-a8e4-34bb99936aaa',1,'Create','App\\Customer',1,'App\\Customer',1,'App\\Customer',1,'','finished','','2020-04-16 16:04:41','2020-04-16 16:04:41',NULL,'{\"tennant_id\":1,\"customer_name\":\"JTGlobal\",\"account_number\":\"1234567\",\"customer_address\":\"No 1. The Forum\",\"updated_at\":\"2020-04-16 16:04:41\",\"created_at\":\"2020-04-16 16:04:41\",\"id\":1}'),(28,'9057762b-eeac-4328-9ddc-a646a2f6e765',1,'Create','App\\Tennant',1,'App\\Tennant',1,'App\\Tennant',1,'','finished','','2020-04-16 16:06:31','2020-04-16 16:06:31',NULL,'{\"name\":\"PDJ\",\"updated_at\":\"2020-04-16 16:06:31\",\"created_at\":\"2020-04-16 16:06:31\",\"id\":1}'),(29,'90577649-ec2b-45fa-83a6-66499c7fec66',1,'Create','App\\Device',1,'App\\Device',1,'App\\Device',1,'','finished','','2020-04-16 16:06:51','2020-04-16 16:06:51',NULL,'{\"euid\":\"1234\",\"tennant_id\":1,\"updated_at\":\"2020-04-16 16:06:51\",\"created_at\":\"2020-04-16 16:06:51\",\"id\":1}'),(30,'9057766d-0c40-4777-8ae7-5526a7e14d7c',1,'Create','App\\Device',3,'App\\Device',3,'App\\Device',3,'','finished','','2020-04-16 16:07:14','2020-04-16 16:07:14',NULL,'{\"euid\":\"1235\",\"tennant_id\":1,\"updated_at\":\"2020-04-16 16:07:14\",\"created_at\":\"2020-04-16 16:07:14\",\"id\":3}'),(31,'905776a4-edfb-485f-b349-5f7dcb30b006',1,'Create','App\\Tank_type',1,'App\\Tank_type',1,'App\\Tank_type',1,'','finished','','2020-04-16 16:07:50','2020-04-16 16:07:50',NULL,'{\"name\":\"Harliquin - 1000L\",\"shape\":\"rectangle\",\"length_cm\":\"215\",\"width_cm\":\"69\",\"height_cm\":\"142\",\"diameter_cm\":\"0\",\"volume_litres\":\"1000\",\"updated_at\":\"2020-04-16 16:07:50\",\"created_at\":\"2020-04-16 16:07:50\",\"id\":1}'),(32,'905776bf-3633-40e6-a352-2dadc5a7652c',1,'Create','App\\Tank_type',2,'App\\Tank_type',2,'App\\Tank_type',2,'','finished','','2020-04-16 16:08:07','2020-04-16 16:08:07',NULL,'{\"name\":\"Garage Bin\",\"shape\":\"cylinder\",\"length_cm\":\"0\",\"width_cm\":\"0\",\"height_cm\":\"66\",\"diameter_cm\":\"46\",\"volume_litres\":\"90\",\"updated_at\":\"2020-04-16 16:08:07\",\"created_at\":\"2020-04-16 16:08:07\",\"id\":2}'),(33,'905776e3-1f3c-472e-8637-c3401ed73ece',1,'Create','App\\Customer',1,'App\\Customer',1,'App\\Customer',1,'','finished','','2020-04-16 16:08:31','2020-04-16 16:08:31',NULL,'{\"tennant_id\":1,\"customer_name\":\"JTGlobal\",\"account_number\":\"123456\",\"customer_address\":\"No 1, The Forum\",\"updated_at\":\"2020-04-16 16:08:31\",\"created_at\":\"2020-04-16 16:08:31\",\"id\":1}'),(34,'905776fc-b066-451c-a4ff-11c10d48d19b',1,'Create','App\\Customer',2,'App\\Customer',2,'App\\Customer',2,'','finished','','2020-04-16 16:08:48','2020-04-16 16:08:48',NULL,'{\"tennant_id\":1,\"customer_name\":\"Jersey Electricity\",\"account_number\":\"1234567897\",\"customer_address\":\"Queens Road\",\"updated_at\":\"2020-04-16 16:08:48\",\"created_at\":\"2020-04-16 16:08:48\",\"id\":2}');
/*!40000 ALTER TABLE `action_events` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customers`
--

DROP TABLE IF EXISTS `customers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `customers` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tennant_id` int(11) NOT NULL,
  `account_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customers`
--

LOCK TABLES `customers` WRITE;
/*!40000 ALTER TABLE `customers` DISABLE KEYS */;
INSERT INTO `customers` VALUES (1,1,'123456','JTGlobal','No 1, The Forum','2020-04-16 16:08:31','2020-04-16 16:08:31'),(2,1,'1234567897','Jersey Electricity','Queens Road','2020-04-16 16:08:48','2020-04-16 16:08:48');
/*!40000 ALTER TABLE `customers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `devices`
--

DROP TABLE IF EXISTS `devices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `devices` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `euid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tennant_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `devices_euid_unique` (`euid`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `devices`
--

LOCK TABLES `devices` WRITE;
/*!40000 ALTER TABLE `devices` DISABLE KEYS */;
INSERT INTO `devices` VALUES (1,'1234',1,'2020-04-16 16:06:51','2020-04-16 16:06:51'),(3,'1235',1,'2020-04-16 16:07:14','2020-04-16 16:07:14');
/*!40000 ALTER TABLE `devices` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_resets_table',1),(3,'2017_12_07_122845_create_oauth_providers_table',1),(4,'2018_01_01_000000_create_action_events_table',1),(5,'2019_05_10_000000_add_fields_to_action_events_table',1),(23,'2020_04_15_113128_create_devices_table',2),(24,'2020_04_15_115642_create_tennants_table',2),(25,'2020_04_15_120554_create_customers_table',2),(26,'2020_04_15_124738_create_tanks_table',2),(27,'2020_04_16_141215_create_tank_types_table',2);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_providers`
--

DROP TABLE IF EXISTS `oauth_providers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oauth_providers` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `provider` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `provider_user_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `refresh_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_providers_user_id_foreign` (`user_id`),
  KEY `oauth_providers_provider_user_id_index` (`provider_user_id`),
  CONSTRAINT `oauth_providers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_providers`
--

LOCK TABLES `oauth_providers` WRITE;
/*!40000 ALTER TABLE `oauth_providers` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth_providers` ENABLE KEYS */;
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
-- Table structure for table `tank_types`
--

DROP TABLE IF EXISTS `tank_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tank_types` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `shape` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `length_cm` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `width_cm` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `height_cm` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `diameter_cm` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `volume_litres` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tank_types`
--

LOCK TABLES `tank_types` WRITE;
/*!40000 ALTER TABLE `tank_types` DISABLE KEYS */;
INSERT INTO `tank_types` VALUES (1,'Harliquin - 1000L','rectangle','215','69','142','0','1000','2020-04-16 16:07:50','2020-04-16 16:07:50'),(2,'Garage Bin','cylinder','0','0','66','46','90','2020-04-16 16:08:07','2020-04-16 16:08:07');
/*!40000 ALTER TABLE `tank_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tanks`
--

DROP TABLE IF EXISTS `tanks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tanks` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `device_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `tank_address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `long` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pic` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tank_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `setup_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tanks_device_id_unique` (`device_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tanks`
--

LOCK TABLES `tanks` WRITE;
/*!40000 ALTER TABLE `tanks` DISABLE KEYS */;
/*!40000 ALTER TABLE `tanks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tennants`
--

DROP TABLE IF EXISTS `tennants`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tennants` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tennants`
--

LOCK TABLES `tennants` WRITE;
/*!40000 ALTER TABLE `tennants` DISABLE KEYS */;
INSERT INTO `tennants` VALUES (1,'PDJ','2020-04-16 16:06:31','2020-04-16 16:06:31');
/*!40000 ALTER TABLE `tennants` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'admin',
  `customer_id` int(11) NOT NULL DEFAULT 0,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Doodle Admin','systems@doodlelabs.co.uk','admin',0,NULL,'$2y$10$c0gssimUdfHRYW8vCLnBPOh1TDskrt8dK3UvPcNIgAHvX1asnWMvi',NULL,'2020-04-15 11:15:12','2020-04-15 11:15:12'),(2,'Test User','me@jamie-mcdonald.net','admin',1,NULL,'$2y$10$lohEDyRDVgICtOKcROq5SejKjES.wIIdtgI38b0Rd6BXGljj4d55q',NULL,'2020-04-15 14:16:17','2020-04-15 14:22:48');
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

-- Dump completed on 2020-04-16 16:08:57
