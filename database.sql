CREATE DATABASE  IF NOT EXISTS `nss_item_manage` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `nss_item_manage`;
-- MySQL dump 10.13  Distrib 8.0.33, for Win64 (x86_64)
--
-- Host: forye.top    Database: nss_item_manage
-- ------------------------------------------------------
-- Server version	8.0.24

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `account`
--

DROP TABLE IF EXISTS `account`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `account` (
  `id` int NOT NULL AUTO_INCREMENT,
  `account` varchar(255) NOT NULL DEFAULT 'admin',
  `password` varchar(255) NOT NULL DEFAULT '123456',
  `authority` int NOT NULL DEFAULT '1',
  `name` varchar(255) NOT NULL DEFAULT '默认名字',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=102 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `account`
--

LOCK TABLES `account` WRITE;
/*!40000 ALTER TABLE `account` DISABLE KEYS */;
INSERT INTO `account` VALUES (6,'888','$2y$10$HBDe3PmFYHYYq.ALVmjYdeCeL452FvUPVV.O9VWhzqIFwC33Ji3KO',1,'okk'),(7,'666','$2y$10$Nksq8gVebcZ835fxMQWZIuv3vtkDdzv5E69QFoorH2eEOFwtdpRGS',2,'大可爱'),(100,'6666','$2y$10$vFuQM7G1PRsR3enSUrqv/.VMObkeflOagkpFUigrEGOOf.j23yCEi',3,'知道吗'),(101,'aiccyxixy@163.com','$2y$10$KQkME5fq2o1kfF5v/9qN/eIcehq9mqaF.DgyLuIpKL8t3SY7VguCq',3,'叶晓叶');
/*!40000 ALTER TABLE `account` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `item`
--

DROP TABLE IF EXISTS `item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `item` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `quantity` int NOT NULL DEFAULT '1',
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=75 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `item`
--

LOCK TABLES `item` WRITE;
/*!40000 ALTER TABLE `item` DISABLE KEYS */;
INSERT INTO `item` VALUES (2,'长安汽车不好开',50,'2023-01-28 03:38:08'),(3,'南孚电池再看一眼就会爆炸',60,'2023-01-28 03:38:08'),(6,'阿萨姆奶茶好喝',156,'2023-01-28 03:38:08'),(7,'太阳黑子',56,'2023-01-28 03:38:08'),(10,'华为荣耀手机',117,'2023-01-28 15:27:07'),(36,'生命支付卡',98,'2023-01-29 15:04:10'),(37,'ikun3天体验卡',27,'2023-02-03 17:49:42'),(38,'哎呦你干嘛',25,'2023-02-05 09:40:12'),(39,'只因你太美 baby 只因你太美 baby',1,'2023-02-06 15:33:45'),(41,'迎面走来的你让我如此蠢蠢欲动',2,'2023-02-06 15:48:23'),(42,'这种感觉我从未有',3,'2023-02-06 15:48:33'),(43,'Cause I got a crush on you who you',4,'2023-02-06 15:48:42'),(44,'你是我的我是你的谁',5,'2023-02-06 15:49:08'),(45,'再多一眼看一眼就会爆炸',6,'2023-02-06 15:49:16'),(46,'再近一点靠近点快被融化',7,'2023-02-06 15:49:23'),(47,'想要把你占为己有baby bae',8,'2023-02-06 15:49:30'),(48,'不管走到哪里都会想起的人是你 you you',9,'2023-02-06 15:49:47'),(49,'我应该拿你怎样',10,'2023-02-06 15:49:58'),(50,'uh 所有人都在看着你',11,'2023-02-06 15:50:05'),(51,'我的心总是不安',12,'2023-02-06 15:50:13'),(52,'oh 我现在已病入膏肓',13,'2023-02-06 15:50:21'),(53,'eh eh 难道真的因为你而疯狂吗',14,'2023-02-06 15:50:51'),(54,'我本来不是这种人',15,'2023-02-06 15:50:59'),(55,'因你变成奇怪的人',16,'2023-02-06 15:51:07'),(56,'第一次呀变成这样的我',17,'2023-02-06 15:51:13'),(57,'不管我怎么去否认',18,'2023-02-06 15:51:19'),(58,'只因你太美 baby 只因你太美 baby - 1',19,'2023-02-06 15:51:46'),(59,'只因你实在是太美 baby 只因你太美 baby - 1',20,'2023-02-06 15:51:58'),(60,'闭着眼睛大声对你说爱',21,'2023-02-06 15:52:32'),(61,'感情 加速 加深 发生',22,'2023-02-06 15:52:41'),(62,'像酒精为你沉醉',23,'2023-02-06 15:52:46'),(63,'你疯 你笑 你叫 你跳 你闹',24,'2023-02-06 15:52:53'),(64,'脑海中一直浮现你的微笑',25,'2023-02-06 16:16:49'),(65,'房间里全是你的味道',26,'2023-02-06 16:17:11'),(66,'I don\'t wanna wake up in dream',27,'2023-02-06 16:17:22'),(67,'我只想看你这是真心话',28,'2023-02-06 16:17:30'),(68,'只因你太美 baby 只因你太美 baby - 2',29,'2023-02-06 16:18:13'),(69,'只因你实在是太美 baby 只因你太美 baby - 2',30,'2023-02-06 16:18:28'),(70,'oh eh oh 现在确认地告诉我',31,'2023-02-06 16:18:35'),(71,'oh eh oh 你到底属于谁',32,'2023-02-06 16:18:44'),(72,'oh eh oh 现在确认地告诉我 - 1',33,'2023-02-06 16:19:11'),(73,'oh eh oh 你到底属于谁 就是现在告诉我',34,'2023-02-06 16:19:22');
/*!40000 ALTER TABLE `item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `log`
--

DROP TABLE IF EXISTS `log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `log` (
  `id` int NOT NULL AUTO_INCREMENT,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `action` varchar(255) NOT NULL DEFAULT 'defalut',
  `item` varchar(255) NOT NULL DEFAULT 'null',
  `quantity` int NOT NULL DEFAULT '0',
  `newname` varchar(255) DEFAULT 'null',
  `newquantity` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=118 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `log`
--

LOCK TABLES `log` WRITE;
/*!40000 ALTER TABLE `log` DISABLE KEYS */;
INSERT INTO `log` VALUES (72,'2023-01-29 15:04:10','append','生命支付卡',98,'null',0),(73,'2023-01-29 16:18:31','modify','长安汽车不好开',5,'长安汽车不好开',50),(76,'2023-02-03 17:49:42','append','ikun3天体验卡',27,'null',0),(77,'2023-02-05 09:40:12','append','哎呦你干嘛',25,'null',0),(78,'2023-02-06 15:23:03','modify','长安汽车不好开吧',50,'长安汽车不好开',50),(79,'2023-02-06 15:33:45','append','只因你太美 baby 只因你太美 baby',1,'null',0),(82,'2023-02-06 15:48:23','append','迎面走来的你让我如此蠢蠢欲动',2,'null',0),(83,'2023-02-06 15:48:33','append','这种感觉我从未有',3,'null',0),(84,'2023-02-06 15:48:42','append','Cause I got a crush on you who you',4,'null',0),(85,'2023-02-06 15:49:08','append','你是我的我是你的谁',5,'null',0),(86,'2023-02-06 15:49:16','append','再多一眼看一眼就会爆炸',6,'null',0),(87,'2023-02-06 15:49:23','append','再近一点靠近点快被融化',7,'null',0),(88,'2023-02-06 15:49:30','append','想要把你占为己有baby bae',8,'null',0),(89,'2023-02-06 15:49:47','append','不管走到哪里都会想起的人是你 you you',9,'null',0),(90,'2023-02-06 15:49:58','append','我应该拿你怎样',10,'null',0),(91,'2023-02-06 15:50:05','append','uh 所有人都在看着你',11,'null',0),(92,'2023-02-06 15:50:13','append','我的心总是不安',12,'null',0),(93,'2023-02-06 15:50:21','append','oh 我现在已病入膏肓',13,'null',0),(94,'2023-02-06 15:50:51','append','eh eh 难道真的因为你而疯狂吗',14,'null',0),(95,'2023-02-06 15:50:59','append','我本来不是这种人',15,'null',0),(96,'2023-02-06 15:51:07','append','因你变成奇怪的人',16,'null',0),(97,'2023-02-06 15:51:13','append','第一次呀变成这样的我',17,'null',0),(98,'2023-02-06 15:51:19','append','不管我怎么去否认',18,'null',0),(99,'2023-02-06 15:51:46','append','只因你太美 baby 只因你太美 baby - 1',19,'null',0),(100,'2023-02-06 15:51:58','append','只因你实在是太美 baby 只因你太美 baby - 1',20,'null',0),(101,'2023-02-06 15:52:32','append','闭着眼睛大声对你说爱',21,'null',0),(102,'2023-02-06 15:52:41','append','感情 加速 加深 发生',22,'null',0),(103,'2023-02-06 15:52:46','append','像酒精为你沉醉',23,'null',0),(104,'2023-02-06 15:52:53','append','你疯 你笑 你叫 你跳 你闹',23,'null',0),(105,'2023-02-06 16:16:10','modify','你疯 你笑 你叫 你跳 你闹',23,'你疯 你笑 你叫 你跳 你闹',24),(106,'2023-02-06 16:16:49','append','脑海中一直浮现你的微笑',25,'null',0),(107,'2023-02-06 16:17:11','append','房间里全是你的味道',26,'null',0),(108,'2023-02-06 16:17:22','append','I don\'t wanna wake up in dream',27,'null',0),(109,'2023-02-06 16:17:30','append','我只想看你这是真心话',28,'null',0),(110,'2023-02-06 16:18:13','append','只因你太美 baby 只因你太美 baby - 2',29,'null',0),(111,'2023-02-06 16:18:28','append','只因你实在是太美 baby 只因你太美 baby - 2',30,'null',0),(112,'2023-02-06 16:18:35','append','oh eh oh 现在确认地告诉我',31,'null',0),(113,'2023-02-06 16:18:44','append','oh eh oh 你到底属于谁',32,'null',0),(114,'2023-02-06 16:19:11','append','oh eh oh 现在确认地告诉我 - 1',33,'null',0),(115,'2023-02-06 16:19:22','append','oh eh oh 你到底属于谁 就是现在告诉我',34,'null',0),(116,'2023-02-07 14:59:16','append','不是吧',22,'null',0),(117,'2023-02-07 14:59:20','delete','不是吧',22,'null',0);
/*!40000 ALTER TABLE `log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `operation`
--

DROP TABLE IF EXISTS `operation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `operation` (
  `id` int NOT NULL AUTO_INCREMENT,
  `accountid` int NOT NULL DEFAULT '0',
  `accountname` varchar(255) NOT NULL DEFAULT '未知用户',
  `itemid` int NOT NULL DEFAULT '0',
  `itemname` varchar(255) NOT NULL DEFAULT 'item',
  `borrowquantity` int NOT NULL DEFAULT '0',
  `borrowtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `isreturn` tinyint(1) NOT NULL DEFAULT '0',
  `returntime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `operation`
--

LOCK TABLES `operation` WRITE;
/*!40000 ALTER TABLE `operation` DISABLE KEYS */;
INSERT INTO `operation` VALUES (2,100,'知道吗',3,'南孚电池再看一眼就会爆炸',1,'2023-01-27 17:46:41',1,'2023-01-28 12:51:35'),(3,100,'知道吗',3,'南孚电池再看一眼就会爆炸',1,'2023-01-27 17:47:29',1,'2023-01-28 12:51:35'),(4,100,'知道吗',2,'长安汽车不好开',1,'2023-01-27 17:48:34',1,'2023-01-28 12:51:28'),(5,100,'知道吗',2,'长安汽车不好开',1,'2023-01-27 17:50:36',1,'2023-01-28 12:51:28'),(6,100,'知道吗',2,'长安汽车不好开',1,'2023-01-27 17:50:49',1,'2023-01-28 12:51:28'),(7,100,'知道吗',2,'长安汽车不好开',1,'2023-01-27 17:51:00',1,'2023-01-28 12:51:28'),(8,100,'知道吗',6,'阿萨姆奶茶好喝',9,'2023-01-28 10:05:49',1,'2023-01-28 12:46:13'),(9,100,'知道吗',6,'阿萨姆奶茶好喝',1,'2023-01-28 12:46:03',1,'2023-01-28 12:46:13'),(10,100,'知道吗',9,'大你太忙',1,'2023-01-28 12:55:14',1,'2023-01-28 12:55:24'),(11,7,'大可爱',10,'华为荣耀手机',1,'2023-01-28 16:04:14',1,'2023-01-29 16:22:00'),(12,7,'大可爱',10,'华为荣耀手机',1,'2023-01-28 16:06:16',1,'2023-01-29 16:22:00'),(13,100,'知道吗',10,'华为荣耀手机',4,'2023-01-29 07:42:05',1,'2023-01-29 07:42:10'),(14,100,'知道吗',7,'太阳黑子',1,'2023-01-29 08:49:47',1,'2023-01-29 08:49:51'),(15,101,'叶晓叶',37,'ikun3天体验卡',1,'2023-02-05 08:24:00',1,'2023-02-05 08:24:03'),(16,101,'叶晓叶',66,'I don\'t wanna wake up in dream',1,'2023-02-07 15:28:11',1,'2023-02-07 15:28:16'),(17,101,'叶晓叶',73,'oh eh oh 你到底属于谁 就是现在告诉我',1,'2023-02-07 16:04:48',1,'2023-02-07 16:04:54'),(18,101,'叶晓叶',73,'oh eh oh 你到底属于谁 就是现在告诉我',1,'2023-02-07 16:04:57',1,'2023-02-07 16:06:37'),(19,101,'叶晓叶',72,'oh eh oh 现在确认地告诉我 - 1',1,'2023-02-07 16:06:40',1,'2023-02-10 14:44:26'),(20,100,'知道吗',73,'oh eh oh 你到底属于谁 就是现在告诉我',1,'2023-02-07 17:26:03',1,'2023-02-10 14:46:22'),(21,101,'叶晓叶',73,'oh eh oh 你到底属于谁 就是现在告诉我',1,'2023-02-08 03:52:53',1,'2023-02-10 14:44:27'),(22,100,'知道吗',71,'oh eh oh 你到底属于谁',1,'2023-02-09 18:17:15',1,'2023-02-09 18:17:27'),(23,100,'知道吗',73,'oh eh oh 你到底属于谁 就是现在告诉我',1,'2023-02-10 15:01:11',1,'2023-02-12 13:56:44'),(24,100,'知道吗',41,'迎面走来的你让我如此蠢蠢欲动',1,'2023-02-12 13:56:27',1,'2023-02-12 13:56:43'),(25,7,'大可爱',73,'oh eh oh 你到底属于谁 就是现在告诉我',1,'2023-02-19 09:36:38',1,'2023-02-19 09:36:40'),(26,101,'叶晓叶',73,'oh eh oh 你到底属于谁 就是现在告诉我',1,'2023-02-20 11:00:38',1,'2023-02-20 11:01:01'),(27,101,'叶晓叶',37,'ikun3天体验卡',1,'2023-02-20 11:00:56',1,'2023-02-20 11:01:00'),(28,101,'叶晓叶',3,'南孚电池再看一眼就会爆炸',1,'2023-11-01 15:17:07',1,'2023-11-01 15:17:19'),(29,101,'叶晓叶',73,'oh eh oh 你到底属于谁 就是现在告诉我',1,'2023-11-02 09:00:43',1,'2023-12-07 13:42:23'),(30,101,'叶晓叶',73,'oh eh oh 你到底属于谁 就是现在告诉我',1,'2024-05-14 17:03:23',1,'2024-05-14 17:03:42'),(31,101,'叶晓叶',73,'oh eh oh 你到底属于谁 就是现在告诉我',1,'2024-09-20 21:22:01',1,'2024-09-20 13:27:38');
/*!40000 ALTER TABLE `operation` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-09-21  5:31:48
