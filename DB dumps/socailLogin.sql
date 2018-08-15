/*
SQLyog Ultimate v11.11 (64 bit)
MySQL - 5.7.20-log : Database - sanam_tech
*********************************************************************
*/


/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `social_accounts` */

DROP TABLE IF EXISTS `social_accounts`;

CREATE TABLE `social_accounts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `platform` varchar(255) NOT NULL,
  `client_id` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `social_user_id` (`user_id`),
  CONSTRAINT `social_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

ALTER TABLE `users` CHANGE `name` `name` VARCHAR(191) CHARSET utf8mb4 COLLATE utf8mb4_unicode_ci NULL;
ALTER TABLE `user_details` CHANGE `first_name` `first_name` VARCHAR(191) CHARSET utf8mb4 COLLATE utf8mb4_unicode_ci NULL;
ALTER TABLE `social_accounts` CHANGE `token` `token` VARCHAR(255) CHARSET utf8 COLLATE utf8_general_ci NULL;
ALTER TABLE `user_devices` CHANGE `device_token` `device_token` VARCHAR(191) CHARSET utf8mb4 COLLATE utf8mb4_unicode_ci NULL;
ALTER TABLE `user_details` ADD COLUMN `social_login` BOOLEAN DEFAULT 0 NULL AFTER `email_updates`;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;


