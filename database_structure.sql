-- MySQL dump 10.13  Distrib 8.0.19, for Win64 (x86_64)
--
-- Host: m4rti-server    Database: login_v2
-- ------------------------------------------------------
-- Server version	5.5.5-10.6.11-MariaDB-0ubuntu0.22.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `chatMsg`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `chatMsg` (
  `reciever` int(11) NOT NULL,
  `sender` int(11) NOT NULL,
  `msgId` int(11) NOT NULL AUTO_INCREMENT,
  `txt` text DEFAULT NULL,
  `hora` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`msgId`),
  UNIQUE KEY `PK_Message` (`sender`,`reciever`,`msgId`),
  KEY `reciever` (`reciever`),
  CONSTRAINT `chatMsg_ibfk_1` FOREIGN KEY (`sender`) REFERENCES `users` (`userId`),
  CONSTRAINT `chatMsg_ibfk_2` FOREIGN KEY (`reciever`) REFERENCES `users` (`userId`)
) ENGINE=InnoDB AUTO_INCREMENT=198 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `genders`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `genders` (
  `code` char(1) NOT NULL,
  `gender` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `socials`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `socials` (
  `socialId` int(11) NOT NULL AUTO_INCREMENT,
  `socialName` varchar(30) DEFAULT NULL,
  `socialIcon` varchar(50) DEFAULT NULL,
  `socialColor` char(7) DEFAULT NULL,
  `profUrl` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`socialId`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `userSocials`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `userSocials` (
  `userId` int(11) NOT NULL,
  `socialId` int(11) NOT NULL,
  `socialUsrName` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`userId`,`socialId`),
  KEY `FK_sName` (`socialId`),
  CONSTRAINT `FK_sName` FOREIGN KEY (`socialId`) REFERENCES `socials` (`socialId`),
  CONSTRAINT `FK_uId` FOREIGN KEY (`userId`) REFERENCES `users` (`userId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `users`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `userId` int(11) NOT NULL AUTO_INCREMENT,
  `userName` varchar(128) NOT NULL,
  `userEmail` varchar(128) NOT NULL,
  `userPwd` varchar(128) NOT NULL,
  `userBdate` date NOT NULL,
  `userImage` varchar(1000) DEFAULT '../user_images/default.png',
  `userBanner` varchar(1000) DEFAULT '../user_images/banner-default.png',
  `userDescription` varchar(100) DEFAULT NULL,
  `userGender` char(1) DEFAULT NULL,
  PRIMARY KEY (`userId`),
  UNIQUE KEY `UC_user` (`userName`),
  UNIQUE KEY `UC_pwrd` (`userEmail`),
  KEY `userGender` (`userGender`),
  CONSTRAINT `users_ibfk_1` FOREIGN KEY (`userGender`) REFERENCES `genders` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping routines for database 'login_v2'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-02-03 12:42:27
