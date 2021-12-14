# ************************************************************
# Sequel Ace SQL dump
# Version 20016
#
# https://sequel-ace.com/
# https://github.com/Sequel-Ace/Sequel-Ace
#
# Host: 127.0.0.1 (MySQL 5.5.5-10.4.21-MariaDB)
# Database: yii_latihan
# Generation Time: 2021-12-14 08:14:14 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
SET NAMES utf8mb4;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE='NO_AUTO_VALUE_ON_ZERO', SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table member
# ------------------------------------------------------------

DROP TABLE IF EXISTS `member`;

CREATE TABLE `member` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `MemberId` varchar(18) NOT NULL DEFAULT '',
  `Name` varchar(100) NOT NULL DEFAULT '',
  `Address` varchar(160) NOT NULL DEFAULT '',
  `City` varchar(60) NOT NULL DEFAULT '',
  `Phone` varchar(24) NOT NULL DEFAULT '',
  `StatId` int(11) NOT NULL DEFAULT 1,
  `JoinDate` datetime DEFAULT NULL,
  `Remark` varchar(160) NOT NULL DEFAULT '',
  PRIMARY KEY (`Id`),
  UNIQUE KEY `MemberId` (`MemberId`),
  KEY `StatId` (`StatId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

LOCK TABLES `member` WRITE;
/*!40000 ALTER TABLE `member` DISABLE KEYS */;

INSERT INTO `member` (`Id`, `MemberId`, `Name`, `Address`, `City`, `Phone`, `StatId`, `JoinDate`, `Remark`)
VALUES
	(1,'YII0000001','Administrator','Jalan Terindah','Bandung','022 000',1,'2021-09-01 00:00:00','');

/*!40000 ALTER TABLE `member` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table member_status
# ------------------------------------------------------------

DROP TABLE IF EXISTS `member_status`;

CREATE TABLE `member_status` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Status` varchar(20) NOT NULL DEFAULT '',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

LOCK TABLES `member_status` WRITE;
/*!40000 ALTER TABLE `member_status` DISABLE KEYS */;

INSERT INTO `member_status` (`Id`, `Status`)
VALUES
	(1,'Active'),
	(2,'Non Active'),
	(3,'Resign');

/*!40000 ALTER TABLE `member_status` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table product
# ------------------------------------------------------------

DROP TABLE IF EXISTS `product`;

CREATE TABLE `product` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Product` varchar(100) NOT NULL DEFAULT '',
  `Description` mediumtext DEFAULT NULL,
  `Price` decimal(15,2) NOT NULL,
  `Stock` int(11) NOT NULL,
  `StatId` int(11) DEFAULT NULL,
  `Remark` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`Id`),
  KEY `StatId` (`StatId`),
  CONSTRAINT `product_ibfk_1` FOREIGN KEY (`StatId`) REFERENCES `product_status` (`Id`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



# Dump of table product_status
# ------------------------------------------------------------

DROP TABLE IF EXISTS `product_status`;

CREATE TABLE `product_status` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Status` varchar(20) NOT NULL DEFAULT '',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

LOCK TABLES `product_status` WRITE;
/*!40000 ALTER TABLE `product_status` DISABLE KEYS */;

INSERT INTO `product_status` (`Id`, `Status`)
VALUES
	(1,'Ready'),
	(2,'Stock Out'),
	(3,'Discontinue');

/*!40000 ALTER TABLE `product_status` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table session
# ------------------------------------------------------------

DROP TABLE IF EXISTS `session`;

CREATE TABLE `session` (
  `id` char(40) NOT NULL,
  `expire` int(11) DEFAULT NULL,
  `data` blob DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



# Dump of table user
# ------------------------------------------------------------

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Username` varchar(255) NOT NULL DEFAULT '',
  `Authkey` varchar(32) NOT NULL DEFAULT '',
  `Password` varchar(255) NOT NULL DEFAULT '',
  `PasswordResetToken` varchar(255) DEFAULT NULL,
  `VerificationToken` varchar(255) DEFAULT NULL,
  `Email` varchar(255) NOT NULL,
  `PrivId` int(11) NOT NULL DEFAULT 0,
  `MemberId` varchar(18) NOT NULL DEFAULT '',
  `Created` datetime DEFAULT NULL,
  `LastUpdate` datetime DEFAULT NULL,
  `LastIP` varchar(24) NOT NULL DEFAULT '',
  `Enabled` tinyint(1) unsigned NOT NULL DEFAULT 0,
  `Authorization` varchar(100) DEFAULT NULL,
  `IsVerified` tinyint(1) unsigned NOT NULL DEFAULT 0,
  `IsAdmin` tinyint(1) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `username` (`Username`),
  UNIQUE KEY `email` (`Email`),
  UNIQUE KEY `password_reset_token` (`PasswordResetToken`),
  KEY `PrivId` (`PrivId`),
  KEY `MemberId` (`MemberId`),
  CONSTRAINT `user_ibfk_1` FOREIGN KEY (`PrivId`) REFERENCES `user_privilege` (`Id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `user_ibfk_2` FOREIGN KEY (`MemberId`) REFERENCES `member` (`MemberId`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;

INSERT INTO `user` (`Id`, `Username`, `Authkey`, `Password`, `PasswordResetToken`, `VerificationToken`, `Email`, `PrivId`, `MemberId`, `Created`, `LastUpdate`, `LastIP`, `Enabled`, `Authorization`, `IsVerified`, `IsAdmin`)
VALUES
	(1,'admin','fz5h0gtmRABiHqlNz00-NNv2Y-MYcduI','$2y$13$41jNJk41JpOIv.DEwfxaGu5COw5GgssbnXfsJi2wSseEGmWq4KX7m','jbkT4yj3Nk3rWruWXieU2TV_cIGZsRY7_1630850672','392760','admin@diwangkara.com',11,'YII0000001',NULL,'2021-09-08 21:54:06','',1,NULL,1,1);

/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table user_privilege
# ------------------------------------------------------------

DROP TABLE IF EXISTS `user_privilege`;

CREATE TABLE `user_privilege` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Privilege` varchar(20) NOT NULL DEFAULT '',
  `Remark` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

LOCK TABLES `user_privilege` WRITE;
/*!40000 ALTER TABLE `user_privilege` DISABLE KEYS */;

INSERT INTO `user_privilege` (`Id`, `Privilege`, `Remark`)
VALUES
	(1,'Developer',''),
	(2,'Superadmin',''),
	(3,'Administrator',''),
	(4,'Web Owner','');

/*!40000 ALTER TABLE `user_privilege` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
