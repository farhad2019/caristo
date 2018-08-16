/*
SQLyog Ultimate v11.11 (64 bit)
MySQL - 5.6.40 : Database - caristocrat
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `admin_queries` */

DROP TABLE IF EXISTS `admin_queries`;

CREATE TABLE `admin_queries` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '0,1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `admin_queries` */

/*Table structure for table `category` */

DROP TABLE IF EXISTS `category`;

CREATE TABLE `category` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `slug` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `user_id` int(11) unsigned DEFAULT NULL,
  `parent_id` int(11) unsigned DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `parent_id` (`parent_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `category` */

insert  into `category`(`id`,`slug`,`user_id`,`parent_id`,`created_at`,`updated_at`,`deleted_at`) values (1,'test category',1,0,'2018-08-09 17:10:29','2018-08-09 17:10:29',NULL),(2,'child test',1,1,'2018-08-14 11:38:22','2018-08-14 11:38:22',NULL);

/*Table structure for table `category_translations` */

DROP TABLE IF EXISTS `category_translations`;

CREATE TABLE `category_translations` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` int(11) unsigned DEFAULT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `subtitle` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `locale` varbinary(50) DEFAULT '',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `category_translations_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `category_translations` */

insert  into `category_translations`(`id`,`category_id`,`name`,`subtitle`,`locale`,`created_at`,`updated_at`,`deleted_at`) values (1,1,'test','','en','2018-08-09 17:34:59','2018-08-09 17:34:59',NULL),(2,1,'ٹھوٹ','','ar','2018-08-09 17:35:19','2018-08-09 17:35:19',NULL),(3,2,'child test','','en','2018-08-14 11:38:36','2018-08-14 11:38:36',NULL);

/*Table structure for table `comments` */

DROP TABLE IF EXISTS `comments`;

CREATE TABLE `comments` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `comment_text` text COLLATE utf8mb4_unicode_ci,
  `parent_id` int(11) unsigned DEFAULT '0',
  `news_id` int(11) unsigned DEFAULT NULL,
  `user_id` int(11) unsigned DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `comments_ibfk_1` (`news_id`),
  KEY `comments_ibfk_2` (`user_id`),
  KEY `parent_id` (`parent_id`),
  CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`news_id`) REFERENCES `news` (`id`) ON DELETE CASCADE,
  CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `comments` */

insert  into `comments`(`id`,`comment_text`,`parent_id`,`news_id`,`user_id`,`created_at`,`updated_at`,`deleted_at`) values (1,'test',0,4,1,'2018-08-14 14:45:58',NULL,NULL),(2,'string',0,5,2,'2018-08-14 09:10:16','2018-08-14 09:10:16',NULL),(3,'test',0,4,1,'2018-08-14 14:45:59',NULL,NULL),(4,'new',0,4,1,'2018-08-15 08:16:04','2018-08-15 08:16:04',NULL),(5,'chhcgxg',0,4,12,'2018-08-15 10:04:55','2018-08-15 10:04:55',NULL),(6,'cg Cff TX f',0,4,12,'2018-08-15 10:10:45','2018-08-15 10:10:45',NULL),(7,'hsgsgsgsg',0,4,12,'2018-08-15 10:27:50','2018-08-15 10:27:50',NULL),(8,'aaaa',0,4,12,'2018-08-15 10:31:01','2018-08-15 10:31:01',NULL),(9,'new',0,4,1,'2018-08-15 10:32:25','2018-08-15 10:32:25',NULL);

/*Table structure for table `locales` */

DROP TABLE IF EXISTS `locales`;

CREATE TABLE `locales` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `native_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `direction` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0,1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=185 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `locales` */

insert  into `locales`(`id`,`code`,`title`,`native_name`,`direction`,`status`,`created_at`,`updated_at`,`deleted_at`) values (1,'en','English',NULL,'LTR',1,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(2,'ar','Arabic',NULL,'RTL',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(3,'ab','Abkhaz',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(4,'aa','Afar',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(5,'af','Afrikaans',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(6,'ak','Akan',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(7,'sq','Albanian',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(8,'am','Amharic',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(10,'an','Aragonese',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(11,'hy','Armenian',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(12,'as','Assamese',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(13,'av','Avaric',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(14,'ae','Avestan',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(15,'ay','Aymara',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(16,'az','Azerbaijani',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(17,'bm','Bambara',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(18,'ba','Bashkir',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(19,'eu','Basque',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(20,'be','Belarusian',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(21,'bn','Bengali',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(22,'bh','Bihari',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(23,'bi','Bislama',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(24,'bs','Bosnian',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(25,'br','Breton',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(26,'bg','Bulgarian',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(27,'my','Burmese',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(28,'ca','Catalan; Valencian',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(29,'ch','Chamorro',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(30,'ce','Chechen',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(31,'ny','Chichewa; Chewa; Nyanja',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(32,'zh','Chinese',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(33,'cv','Chuvash',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(34,'kw','Cornish',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(35,'co','Corsican',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(36,'cr','Cree',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(37,'hr','Croatian',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(38,'cs','Czech',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(39,'da','Danish',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(40,'dv','Divehi; Dhivehi; Maldivian;',NULL,'RTL',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(41,'nl','Dutch',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(43,'eo','Esperanto',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(44,'et','Estonian',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(45,'ee','Ewe',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(46,'fo','Faroese',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(47,'fj','Fijian',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(48,'fi','Finnish',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(49,'fr','French',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(50,'ff','Fula; Fulah; Pulaar; Pular',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(51,'gl','Galician',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(52,'ka','Georgian',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(53,'de','German',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(54,'el','Greek, Modern',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(55,'gn','Guaraní',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(56,'gu','Gujarati',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(57,'ht','Haitian; Haitian Creole',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(58,'ha','Hausa',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(59,'he','Hebrew (modern)',NULL,'RTL',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(60,'hz','Herero',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(61,'hi','Hindi',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(62,'ho','Hiri Motu',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(63,'hu','Hungarian',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(64,'ia','Interlingua',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(65,'id','Indonesian',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(66,'ie','Interlingue',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(67,'ga','Irish',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(68,'ig','Igbo',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(69,'ik','Inupiaq',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(70,'io','Ido',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(71,'is','Icelandic',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(72,'it','Italian',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(73,'iu','Inuktitut',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(74,'ja','Japanese',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(75,'jv','Javanese',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(76,'kl','Kalaallisut, Greenlandic',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(77,'kn','Kannada',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(78,'kr','Kanuri',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(79,'ks','Kashmiri',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(80,'kk','Kazakh',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(81,'km','Khmer',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(82,'ki','Kikuyu, Gikuyu',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(83,'rw','Kinyarwanda',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(84,'ky','Kirghiz, Kyrgyz',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(85,'kv','Komi',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(86,'kg','Kongo',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(87,'ko','Korean',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(88,'ku','Kurdish',NULL,'RTL',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(89,'kj','Kwanyama, Kuanyama',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(90,'la','Latin',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(91,'lb','Luxembourgish, Letzeburgesch',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(92,'lg','Luganda',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(93,'li','Limburgish, Limburgan, Limburger',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(94,'ln','Lingala',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(95,'lo','Lao',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(96,'lt','Lithuanian',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(97,'lu','Luba-Katanga',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(98,'lv','Latvian',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(99,'gv','Manx',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(100,'mk','Macedonian',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(101,'mg','Malagasy',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(102,'ms','Malay',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(103,'ml','Malayalam',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(104,'mt','Maltese',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(105,'mi','Māori',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(106,'mr','Marathi (Marāṭhī)',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(107,'mh','Marshallese',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(108,'mn','Mongolian',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(109,'na','Nauru',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(110,'nv','Navajo, Navaho',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(111,'nb','Norwegian Bokmål',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(112,'nd','North Ndebele',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(113,'ne','Nepali',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(114,'ng','Ndonga',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(115,'nn','Norwegian Nynorsk',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(116,'no','Norwegian',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(117,'ii','Nuosu',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(118,'nr','South Ndebele',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(119,'oc','Occitan',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(120,'oj','Ojibwe, Ojibwa',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(121,'cu','Old Church Slavonic, Church Slavic, Church Slavonic, Old Bulgarian, Old Slavonic',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(122,'om','Oromo',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(123,'or','Oriya',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(124,'os','Ossetian, Ossetic',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(125,'pa','Panjabi, Punjabi',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(126,'pi','Pāli',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(127,'fa','Persian',NULL,'RTL',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(128,'pl','Polish',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(129,'ps','Pashto, Pushto',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(130,'pt','Portuguese',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(131,'qu','Quechua',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(132,'rm','Romansh',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(133,'rn','Kirundi',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(134,'ro','Romanian, Moldavian, Moldovan',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(135,'ru','Russian',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(136,'sa','Sanskrit (Saṁskṛta)',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(137,'sc','Sardinian',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(138,'sd','Sindhi',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(139,'se','Northern Sami',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(140,'sm','Samoan',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(141,'sg','Sango',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(142,'sr','Serbian',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(143,'gd','Scottish Gaelic; Gaelic',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(144,'sn','Shona',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(145,'si','Sinhala, Sinhalese',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(146,'sk','Slovak',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(147,'sl','Slovene',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(148,'so','Somali',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(149,'st','Southern Sotho',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(150,'es','Spanish; Castilian',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(151,'su','Sundanese',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(152,'sw','Swahili',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(153,'ss','Swati',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(154,'sv','Swedish',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(155,'ta','Tamil',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(156,'te','Telugu',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(157,'tg','Tajik',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(158,'th','Thai',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(159,'ti','Tigrinya',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(160,'bo','Tibetan Standard, Tibetan, Central',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(161,'tk','Turkmen',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(162,'tl','Tagalog',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(163,'tn','Tswana',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(164,'to','Tonga (Tonga Islands)',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(165,'tr','Turkish',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(166,'ts','Tsonga',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(167,'tt','Tatar',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(168,'tw','Twi',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(169,'ty','Tahitian',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(170,'ug','Uighur, Uyghur',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(171,'uk','Ukrainian',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(172,'ur','Urdu',NULL,'RTL',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(173,'uz','Uzbek',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(174,'ve','Venda',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(175,'vi','Viettitlese',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(176,'vo','Volapük',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(177,'wa','Walloon',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(178,'cy','Welsh',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(179,'wo','Wolof',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(180,'fy','Western Frisian',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(181,'xh','Xhosa',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(182,'yi','Yiddish',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(183,'yo','Yoruba',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(184,'za','Zhuang, Chuang',NULL,'LTR',0,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL);

/*Table structure for table `media_files` */

DROP TABLE IF EXISTS `media_files`;

CREATE TABLE `media_files` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `instance_id` int(11) unsigned DEFAULT NULL,
  `instance_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `title` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `filename` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `post_id` (`instance_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `media_files` */

insert  into `media_files`(`id`,`instance_id`,`instance_type`,`title`,`filename`,`created_at`,`updated_at`,`deleted_at`) values (1,2,'category','100 - Gameplay.jpeg','media_files/1534361143.jpg','2018-08-15 19:25:43','2018-08-15 19:25:43',NULL),(2,1,'category','100 - Buy Moves Menu.jpeg','media_files/1534361160.jpg','2018-08-15 19:26:00','2018-08-15 19:26:00',NULL);

/*Table structure for table `menus` */

DROP TABLE IF EXISTS `menus`;

CREATE TABLE `menus` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `position` tinyint(4) NOT NULL DEFAULT '0',
  `is_protected` tinyint(4) NOT NULL DEFAULT '0',
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `menus` */

insert  into `menus`(`id`,`name`,`icon`,`slug`,`position`,`is_protected`,`status`,`created_at`,`updated_at`,`deleted_at`) values (1,'Dashboard','fa fa-dashboard','dashboard',1,0,1,'2018-08-03 09:31:42','2018-08-03 09:31:42',NULL),(2,'Users','fa fa-user','users',2,0,1,'2018-08-03 09:31:42','2018-08-03 09:31:42',NULL),(3,'Roles','fa fa-edit','roles',3,0,1,'2018-08-03 09:31:42','2018-08-03 09:31:42',NULL),(4,'Permissions','fa fa-check-square-o','permissions',4,0,1,'2018-08-03 09:31:42','2018-08-03 09:31:42',NULL),(5,'Modules','fa fa-database','modules',5,0,1,'2018-08-03 09:31:42','2018-08-03 09:31:42',NULL),(6,'Languages','fa fa-comments-o','languages',6,0,1,'2018-08-03 09:31:42','2018-08-03 09:31:42',NULL),(7,'Pages','fa fa-wpforms','pages',7,0,1,'2018-08-03 09:31:42','2018-08-03 09:31:42',NULL),(8,'Contact us','fa fa-mail-forward','contactus',8,0,1,'2018-08-03 09:31:42','2018-08-03 09:31:42',NULL),(9,'Notifications','fa fa-bell','notifications',9,0,1,'2018-08-03 09:31:42','2018-08-03 09:31:42',NULL),(11,'Category','fa fa-th','categories',10,0,1,'2018-08-16 00:25:16','2018-08-16 00:25:16',NULL),(12,'News','fa fa-th','news',10,0,1,'2018-08-10 11:14:14','2018-08-10 11:15:50',NULL),(13,'Comments','fa fa-th-list','comments',11,0,1,'2018-08-10 11:16:29','2018-08-10 11:25:57',NULL),(14,'Media','fa fa-film','media',12,0,1,'2018-08-10 11:26:21','2018-08-10 11:27:26',NULL),(15,'News Interactions','fa fa-heart','newsInteractions',13,0,1,'2018-08-14 10:08:09','2018-08-14 10:10:57',NULL);

/*Table structure for table `migrations` */

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `migrations` */

insert  into `migrations`(`id`,`migration`,`batch`) values (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_resets_table',1),(3,'2018_04_06_081644_entrust_setup_tables',1),(4,'2018_04_06_134936_create_modules_table',1),(5,'2018_04_09_111106_add_soft_delete_in_users_table',1),(6,'2018_04_09_152013_create_menus_table',1),(7,'2018_07_12_083021_create_locales_table',1),(8,'2018_07_12_084644_create_pages_table',1),(9,'2018_07_13_181040_create_notification_table',1),(10,'2018_07_13_191027_create_admin_query_table',1);

/*Table structure for table `modules` */

DROP TABLE IF EXISTS `modules`;

CREATE TABLE `modules` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `table_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `is_module` tinyint(4) NOT NULL DEFAULT '0',
  `config` text COLLATE utf8mb4_unicode_ci,
  `is_protected` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `modules` */

insert  into `modules`(`id`,`name`,`slug`,`table_name`,`icon`,`status`,`is_module`,`config`,`is_protected`,`created_at`,`updated_at`,`deleted_at`) values (1,'Admin Panel','adminpanel','-','fa fa-dashboard',1,0,NULL,1,'2018-08-03 09:31:42','2018-08-03 09:31:42',NULL),(2,'Dashboard','dashboard','-','fa fa-dashboard',1,0,NULL,1,'2018-08-03 09:31:42','2018-08-03 09:31:42',NULL),(3,'Users','users','users','fa fa-user',1,1,NULL,1,'2018-08-03 09:31:42','2018-08-03 09:31:42',NULL),(4,'Roles','roles','roles','fa fa-edit',1,1,NULL,1,'2018-08-03 09:31:42','2018-08-03 09:31:42',NULL),(5,'Permissions','permissions','permissions','fa fa-check-square-o',1,1,NULL,1,'2018-08-03 09:31:42','2018-08-03 09:31:42',NULL),(6,'Modules','modules','modules','fa fa-database',1,1,NULL,1,'2018-08-03 09:31:42','2018-08-03 09:31:42',NULL),(7,'Languages','languages','locales','fa fa-comments-o',1,1,NULL,1,'2018-08-03 09:31:42','2018-08-03 09:31:42',NULL),(8,'Page','pages','pages','fa fa-wpforms',1,1,NULL,1,'2018-08-03 09:31:42','2018-08-03 09:31:42',NULL),(9,'ContactUs','contactus','admin_queries','fa fa-mail-forward',1,1,NULL,1,'2018-08-03 09:31:42','2018-08-03 09:31:42',NULL),(10,'Notification','notifications','notifications','fa fa-bell',1,1,NULL,1,'2018-08-03 09:31:42','2018-08-03 09:31:42',NULL),(11,'Category','categories','category','fa fa-th',1,1,'[{\"name\":\"id\",\"primary\":true,\"dbType\":\"increments\",\"fillable\":false,\"inForm\":false,\"htmlType\":false,\"validations\":false,\"inIndex\":true,\"searchable\":true},{\"name\":\"slug\",\"primary\":false,\"dbType\":\"string,50\",\"fillable\":true,\"inForm\":true,\"htmlType\":\"text\",\"validations\":\"required\",\"inIndex\":true,\"searchable\":true},{\"name\":\"user_id\",\"primary\":false,\"dbType\":\"increments\",\"fillable\":false,\"inForm\":false,\"htmlType\":false,\"validations\":false,\"inIndex\":false,\"searchable\":false},{\"name\":\"created_at\",\"primary\":false,\"dbType\":\"datetime\",\"fillable\":false,\"inForm\":false,\"htmlType\":false,\"validations\":false,\"inIndex\":true,\"searchable\":true},{\"name\":\"updated_at\",\"primary\":false,\"dbType\":\"datetime\",\"fillable\":false,\"inForm\":false,\"htmlType\":false,\"validations\":false,\"inIndex\":false,\"searchable\":false},{\"name\":\"deleted_at\",\"primary\":false,\"dbType\":\"datetime\",\"fillable\":false,\"inForm\":false,\"htmlType\":false,\"validations\":false,\"inIndex\":false,\"searchable\":false}]',0,'2018-08-16 00:25:16','2018-08-16 00:25:16',NULL),(13,'News','news','posts','fa fa-th',1,1,'[{\"name\":\"id\",\"primary\":true,\"dbType\":\"increments\",\"fillable\":true,\"inForm\":true,\"htmlType\":\"text\",\"validations\":\"required\",\"inIndex\":true,\"searchable\":true},{\"name\":\"category_id\",\"primary\":false,\"dbType\":\"increments\",\"fillable\":true,\"inForm\":true,\"htmlType\":\"text\",\"validations\":\"required\",\"inIndex\":true,\"searchable\":true},{\"name\":\"user_id\",\"primary\":false,\"dbType\":\"increments\",\"fillable\":false,\"inForm\":false,\"htmlType\":false,\"validations\":false,\"inIndex\":false,\"searchable\":false},{\"name\":\"views_count\",\"primary\":false,\"dbType\":\"increments\",\"fillable\":false,\"inForm\":false,\"htmlType\":false,\"validations\":false,\"inIndex\":true,\"searchable\":true},{\"name\":\"favorite_count\",\"primary\":false,\"dbType\":\"increments\",\"fillable\":false,\"inForm\":false,\"htmlType\":false,\"validations\":false,\"inIndex\":true,\"searchable\":true},{\"name\":\"like_count\",\"primary\":false,\"dbType\":\"increments\",\"fillable\":false,\"inForm\":false,\"htmlType\":false,\"validations\":false,\"inIndex\":true,\"searchable\":true},{\"name\":\"comments_count\",\"primary\":false,\"dbType\":\"increments\",\"fillable\":false,\"inForm\":false,\"htmlType\":false,\"validations\":false,\"inIndex\":true,\"searchable\":true},{\"name\":\"is_featured\",\"primary\":false,\"dbType\":\"increments\",\"fillable\":true,\"inForm\":true,\"htmlType\":\"text\",\"validations\":\"required\",\"inIndex\":false,\"searchable\":false},{\"name\":\"created_at\",\"primary\":false,\"dbType\":\"datetime\",\"fillable\":false,\"inForm\":false,\"htmlType\":false,\"validations\":false,\"inIndex\":true,\"searchable\":true},{\"name\":\"updated_at\",\"primary\":false,\"dbType\":\"datetime\",\"fillable\":false,\"inForm\":false,\"htmlType\":false,\"validations\":false,\"inIndex\":false,\"searchable\":false},{\"name\":\"deleted_at\",\"primary\":false,\"dbType\":\"datetime\",\"fillable\":false,\"inForm\":false,\"htmlType\":false,\"validations\":false,\"inIndex\":false,\"searchable\":false}]',0,'2018-08-10 11:14:14','2018-08-10 11:15:49',NULL),(14,'Comment','comments','comments','fa fa-th-list',1,1,'[{\"name\":\"id\",\"primary\":true,\"dbType\":\"increments\",\"fillable\":true,\"inForm\":true,\"htmlType\":\"text\",\"validations\":\"required\",\"inIndex\":true,\"searchable\":true},{\"name\":\"parent_id\",\"primary\":false,\"dbType\":\"increments\",\"fillable\":false,\"inForm\":false,\"htmlType\":false,\"validations\":false,\"inIndex\":true,\"searchable\":true},{\"name\":\"post_id\",\"primary\":false,\"dbType\":\"increments\",\"fillable\":false,\"inForm\":false,\"htmlType\":false,\"validations\":false,\"inIndex\":true,\"searchable\":true},{\"name\":\"user_id\",\"primary\":false,\"dbType\":\"increments\",\"fillable\":true,\"inForm\":true,\"htmlType\":\"text\",\"validations\":\"required\",\"inIndex\":true,\"searchable\":true},{\"name\":\"comment_text\",\"primary\":false,\"dbType\":\"text,65535\",\"fillable\":true,\"inForm\":true,\"htmlType\":\"text\",\"validations\":\"required\",\"inIndex\":true,\"searchable\":true},{\"name\":\"created_at\",\"primary\":false,\"dbType\":\"datetime\",\"fillable\":true,\"inForm\":true,\"htmlType\":\"text\",\"validations\":\"required\",\"inIndex\":true,\"searchable\":true},{\"name\":\"updated_at\",\"primary\":false,\"dbType\":\"datetime\",\"fillable\":false,\"inForm\":false,\"htmlType\":false,\"validations\":false,\"inIndex\":false,\"searchable\":false},{\"name\":\"deleted_at\",\"primary\":false,\"dbType\":\"datetime\",\"fillable\":false,\"inForm\":false,\"htmlType\":false,\"validations\":false,\"inIndex\":false,\"searchable\":false}]',0,'2018-08-10 11:16:29','2018-08-10 11:25:57',NULL),(15,'Media','media','media_files','fa fa-film',1,1,'[{\"name\":\"id\",\"primary\":true,\"dbType\":\"increments\",\"fillable\":true,\"inForm\":true,\"htmlType\":\"text\",\"validations\":\"required\",\"inIndex\":true,\"searchable\":true},{\"name\":\"instance_id\",\"primary\":false,\"dbType\":\"increments\",\"fillable\":true,\"inForm\":true,\"htmlType\":\"text\",\"validations\":\"required\",\"inIndex\":true,\"searchable\":true},{\"name\":\"instance_type\",\"primary\":false,\"dbType\":\"string,10\",\"fillable\":true,\"inForm\":true,\"htmlType\":\"text\",\"validations\":\"required\",\"inIndex\":true,\"searchable\":true},{\"name\":\"title\",\"primary\":false,\"dbType\":\"string,100\",\"fillable\":true,\"inForm\":true,\"htmlType\":\"text\",\"validations\":\"required\",\"inIndex\":true,\"searchable\":true},{\"name\":\"filename\",\"primary\":false,\"dbType\":\"string,100\",\"fillable\":true,\"inForm\":true,\"htmlType\":\"text\",\"validations\":\"required\",\"inIndex\":true,\"searchable\":true},{\"name\":\"created_at\",\"primary\":false,\"dbType\":\"datetime\",\"fillable\":true,\"inForm\":true,\"htmlType\":\"text\",\"validations\":\"required\",\"inIndex\":true,\"searchable\":true},{\"name\":\"updated_at\",\"primary\":false,\"dbType\":\"datetime\",\"fillable\":false,\"inForm\":false,\"htmlType\":false,\"validations\":false,\"inIndex\":false,\"searchable\":false},{\"name\":\"deleted_at\",\"primary\":false,\"dbType\":\"datetime\",\"fillable\":false,\"inForm\":false,\"htmlType\":false,\"validations\":false,\"inIndex\":false,\"searchable\":false}]',0,'2018-08-10 11:26:20','2018-08-10 11:27:26',NULL),(16,'NewsInteraction','newsinteractions','news_interactions','fa fa-heart',1,1,'[{\"name\":\"id\",\"primary\":true,\"dbType\":\"increments\",\"fillable\":true,\"inForm\":true,\"htmlType\":\"text\",\"validations\":\"required\",\"inIndex\":true,\"searchable\":true},{\"name\":\"user_id\",\"primary\":false,\"dbType\":\"increments\",\"fillable\":true,\"inForm\":true,\"htmlType\":\"text\",\"validations\":\"required\",\"inIndex\":false,\"searchable\":false},{\"name\":\"news_id\",\"primary\":false,\"dbType\":\"increments\",\"fillable\":true,\"inForm\":true,\"htmlType\":\"text\",\"validations\":\"required\",\"inIndex\":true,\"searchable\":true},{\"name\":\"type\",\"primary\":false,\"dbType\":\"string,50\",\"fillable\":true,\"inForm\":true,\"htmlType\":\"text\",\"validations\":\"required\",\"inIndex\":true,\"searchable\":true},{\"name\":\"created_at\",\"primary\":false,\"dbType\":\"datetime\",\"fillable\":true,\"inForm\":true,\"htmlType\":\"text\",\"validations\":\"required\",\"inIndex\":true,\"searchable\":true},{\"name\":\"updated_at\",\"primary\":false,\"dbType\":\"datetime\",\"fillable\":true,\"inForm\":true,\"htmlType\":\"text\",\"validations\":\"required\",\"inIndex\":false,\"searchable\":false},{\"name\":\"deleted_at\",\"primary\":false,\"dbType\":\"datetime\",\"fillable\":true,\"inForm\":true,\"htmlType\":\"text\",\"validations\":\"required\",\"inIndex\":false,\"searchable\":false}]',0,'2018-08-14 10:08:08','2018-08-14 10:10:56',NULL);

/*Table structure for table `news` */

DROP TABLE IF EXISTS `news`;

CREATE TABLE `news` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` int(11) unsigned DEFAULT NULL,
  `user_id` int(11) unsigned DEFAULT NULL,
  `views_count` int(11) DEFAULT NULL,
  `favorite_count` int(11) DEFAULT NULL,
  `like_count` int(11) DEFAULT NULL,
  `comments_count` int(11) DEFAULT NULL,
  `is_featured` int(5) DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `news_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `news_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

/*Data for the table `news` */

insert  into `news`(`id`,`category_id`,`user_id`,`views_count`,`favorite_count`,`like_count`,`comments_count`,`is_featured`,`created_at`,`updated_at`,`deleted_at`) values (4,2,1,5,5,5,5,0,'2018-08-13 14:49:08','2018-08-13 14:49:08',NULL),(5,2,1,5,5,5,5,0,'2018-08-13 14:49:12','2018-08-13 14:49:12',NULL);

/*Table structure for table `news_interactions` */

DROP TABLE IF EXISTS `news_interactions`;

CREATE TABLE `news_interactions` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned DEFAULT NULL,
  `news_id` int(11) unsigned DEFAULT NULL,
  `type` int(11) DEFAULT NULL COMMENT 'it could be "like", "favorite" or "view"',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `news_id` (`news_id`),
  CONSTRAINT `news_interactions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `news_interactions_ibfk_2` FOREIGN KEY (`news_id`) REFERENCES `news` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `news_interactions` */

insert  into `news_interactions`(`id`,`user_id`,`news_id`,`type`,`created_at`,`updated_at`,`deleted_at`) values (1,1,4,30,'2018-08-15 06:50:35','2018-08-15 06:50:35',NULL),(2,12,4,30,'2018-08-15 07:28:33','2018-08-15 07:28:33',NULL),(3,12,4,20,'2018-08-15 07:28:55','2018-08-15 07:28:55',NULL),(4,12,4,20,'2018-08-15 07:29:11','2018-08-15 07:29:11',NULL),(5,26,4,20,'2018-08-15 11:08:53','2018-08-15 11:08:53',NULL),(6,26,4,30,'2018-08-15 11:09:00','2018-08-15 11:09:00',NULL),(7,20,4,20,'2018-08-15 11:26:07','2018-08-15 11:26:07',NULL),(8,1,4,20,'2018-08-15 15:24:17','2018-08-15 15:24:17',NULL),(9,18,4,20,'2018-08-15 19:14:30','2018-08-15 19:14:30',NULL);

/*Table structure for table `news_translations` */

DROP TABLE IF EXISTS `news_translations`;

CREATE TABLE `news_translations` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `news_id` int(11) unsigned DEFAULT NULL,
  `headline` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `description` longblob,
  `source` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `locale` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `news_id` (`news_id`),
  CONSTRAINT `news_translations_ibfk_1` FOREIGN KEY (`news_id`) REFERENCES `news` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `news_translations` */

insert  into `news_translations`(`id`,`news_id`,`headline`,`description`,`source`,`locale`,`status`,`created_at`,`updated_at`,`deleted_at`) values (3,4,'headline','all description goes here \r\nall description goes here \r\nall description goes here \r\nall description goes here \r\nall description goes here \r\nall description goes here \r\n','www.google.com','en',1,'2018-08-13 16:19:22','2018-08-13 16:19:22',NULL),(4,4,'headline','all description goes here \r\nall description goes here \r\nall description goes here \r\nall description goes here \r\nall description goes here \r\nall description goes here \r\n','www.google.com','en',1,'2018-08-13 16:19:28','2018-08-13 16:19:28',NULL),(5,4,'غبصق','ٹعمع گشد \r\nٹعمع گشد \r\nٹعمع گشد \r\nٹعمع گشد \r\nٹعمع گشد \r\nٹعمع گشد \r\n','www.google.com','ar',1,'2018-08-13 16:19:30','2018-08-13 16:19:30',NULL),(6,4,'غبصق','ٹعمع گشد \r\nٹعمع گشد \r\nٹعمع گشد \r\nٹعمع گشد \r\nٹعمع گشد \r\nٹعمع گشد \r\n','www.google.com','ar',1,'2018-08-13 16:19:32','2018-08-13 16:19:32',NULL),(7,5,'headline','all description goes here \r\nall description goes here \r\nall description goes here \r\nall description goes here \r\nall description goes here \r\nall description goes here \r\n','www.google.com','en',1,'2018-08-13 16:19:22','2018-08-13 16:19:22',NULL),(8,5,'headline','all description goes here \r\nall description goes here \r\nall description goes here \r\nall description goes here \r\nall description goes here \r\nall description goes here \r\n','www.google.com','en',1,'2018-08-13 16:19:28','2018-08-13 16:19:28',NULL),(9,5,'غبصق','ٹعمع گشد \r\nٹعمع گشد \r\nٹعمع گشد \r\nٹعمع گشد \r\nٹعمع گشد \r\nٹعمع گشد \r\n','www.google.com','ar',1,'2018-08-13 16:19:30','2018-08-13 16:19:30',NULL),(10,5,'غبصق','ٹعمع گشد \r\nٹعمع گشد \r\nٹعمع گشد \r\nٹعمع گشد \r\nٹعمع گشد \r\nٹعمع گشد \r\n','www.google.com','ar',1,'2018-08-13 16:19:32','2018-08-13 16:19:32',NULL);

/*Table structure for table `notification_users` */

DROP TABLE IF EXISTS `notification_users`;

CREATE TABLE `notification_users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `notification_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '10=Sent, 20=Delivered, 30=Read',
  PRIMARY KEY (`id`),
  KEY `notification_users_user_id_foreign` (`user_id`),
  KEY `notification_users_notification_id_foreign` (`notification_id`),
  CONSTRAINT `notification_users_notification_id_foreign` FOREIGN KEY (`notification_id`) REFERENCES `notifications` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `notification_users_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `notification_users` */

/*Table structure for table `notifications` */

DROP TABLE IF EXISTS `notifications`;

CREATE TABLE `notifications` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sender_id` int(10) unsigned NOT NULL,
  `url` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `action_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ref_id` int(11) DEFAULT NULL,
  `message` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0,1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notifications_sender_id_foreign` (`sender_id`),
  CONSTRAINT `notifications_sender_id_foreign` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `notifications` */

/*Table structure for table `page_translations` */

DROP TABLE IF EXISTS `page_translations`;

CREATE TABLE `page_translations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `page_id` int(10) unsigned NOT NULL,
  `locale` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci,
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '0,1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `page_translations_page_id_foreign` (`page_id`),
  CONSTRAINT `page_translations_page_id_foreign` FOREIGN KEY (`page_id`) REFERENCES `pages` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `page_translations` */

insert  into `page_translations`(`id`,`page_id`,`locale`,`title`,`content`,`status`,`created_at`,`updated_at`,`deleted_at`) values (1,1,'en','title','oontent goes here	',1,'2018-08-09 17:12:22',NULL,NULL);

/*Table structure for table `pages` */

DROP TABLE IF EXISTS `pages`;

CREATE TABLE `pages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '0,1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `pages` */

insert  into `pages`(`id`,`slug`,`status`,`created_at`,`updated_at`,`deleted_at`) values (1,'page1',1,'2018-08-09 17:11:59',NULL,NULL);

/*Table structure for table `password_resets` */

DROP TABLE IF EXISTS `password_resets`;

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `code` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `token` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `password_resets` */

insert  into `password_resets`(`email`,`code`,`token`,`created_at`) values ('string@string.com','5380','','2018-08-14 07:21:00'),('testuser123@gmail.com','8936','','2018-08-14 07:48:18'),('x@x.com','3956','','2018-08-15 11:32:47');

/*Table structure for table `permission_role` */

DROP TABLE IF EXISTS `permission_role`;

CREATE TABLE `permission_role` (
  `permission_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `permission_role_role_id_foreign` (`role_id`),
  CONSTRAINT `permission_role_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `permission_role_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `permission_role` */

insert  into `permission_role`(`permission_id`,`role_id`) values (1,1),(2,1),(3,1),(4,1),(5,1),(6,1),(7,1),(8,1),(9,1),(10,1),(11,1),(12,1),(13,1),(14,1),(15,1),(16,1),(17,1),(18,1),(19,1),(20,1),(21,1),(22,1),(23,1),(24,1),(25,1),(26,1),(27,1),(28,1),(29,1),(30,1),(31,1),(32,1),(33,1),(34,1),(35,1),(36,1),(37,1),(38,1),(39,1),(40,1),(41,1),(42,1),(53,1),(54,1),(55,1),(56,1),(57,1),(58,1),(59,1),(60,1),(61,1),(62,1),(63,1),(64,1),(65,1),(66,1),(67,1),(68,1),(69,1),(70,1),(71,1),(72,1),(73,1),(74,1),(75,1),(76,1),(77,1),(1,2),(2,2),(8,2),(9,2),(10,2),(11,2),(12,2),(13,2),(14,2),(15,2),(16,2),(17,2),(23,2),(24,2),(25,2),(26,2),(27,2),(28,2),(29,2),(30,2),(31,2),(32,2),(33,2),(34,2),(35,2),(36,2),(37,2),(38,2),(39,2),(40,2),(41,2),(42,2);

/*Table structure for table `permissions` */

DROP TABLE IF EXISTS `permissions`;

CREATE TABLE `permissions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_protected` tinyint(1) NOT NULL DEFAULT '0',
  `description` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=78 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `permissions` */

insert  into `permissions`(`id`,`name`,`display_name`,`is_protected`,`description`,`created_at`,`updated_at`,`deleted_at`) values (1,'adminpanel','Admin Panel',1,'Admin Panel','2018-08-03 09:31:42','2018-08-03 09:31:42',NULL),(2,'dashboard','Dashboard',1,'Dashboard','2018-08-03 09:31:42','2018-08-03 09:31:42',NULL),(3,'permissions.index','List Permissions',1,'List Permissions','2018-08-03 09:31:42','2018-08-03 09:31:42',NULL),(4,'permissions.create','Create Permission',1,'Create Permission','2018-08-03 09:31:42','2018-08-03 09:31:42',NULL),(5,'permissions.show','View Permission',1,'View Permission','2018-08-03 09:31:42','2018-08-03 09:31:42',NULL),(6,'permissions.edit','Edit Permission',1,'Edit Permission','2018-08-03 09:31:42','2018-08-03 09:31:42',NULL),(7,'permissions.destroy','Delete Permission',1,'Delete Permission','2018-08-03 09:31:42','2018-08-03 09:31:42',NULL),(8,'roles.index','List Roles',1,'List Roles','2018-08-03 09:31:42','2018-08-03 09:31:42',NULL),(9,'roles.create','Create Role',1,'Create Role','2018-08-03 09:31:42','2018-08-03 09:31:42',NULL),(10,'roles.show','View Role',1,'View Role','2018-08-03 09:31:42','2018-08-03 09:31:42',NULL),(11,'roles.edit','Edit Role',1,'Edit Role','2018-08-03 09:31:42','2018-08-03 09:31:42',NULL),(12,'roles.destroy','Delete Role',1,'Delete Role','2018-08-03 09:31:42','2018-08-03 09:31:42',NULL),(13,'users.index','List Roles',1,'List Roles','2018-08-03 09:31:42','2018-08-03 09:31:42',NULL),(14,'users.create','Create Users',1,'Create Users','2018-08-03 09:31:42','2018-08-03 09:31:42',NULL),(15,'users.show','View User',1,'View User','2018-08-03 09:31:42','2018-08-03 09:31:42',NULL),(16,'users.edit','Edit User',1,'Edit User','2018-08-03 09:31:42','2018-08-03 09:31:42',NULL),(17,'users.destroy','Delete User',1,'Delete User','2018-08-03 09:31:42','2018-08-03 09:31:42',NULL),(18,'modules.index','List Modules',1,'List Modules','2018-08-03 09:31:42','2018-08-03 09:31:42',NULL),(19,'modules.create','Create Module',1,'Create Module','2018-08-03 09:31:42','2018-08-03 09:31:42',NULL),(20,'modules.show','View Module',1,'View Module','2018-08-03 09:31:42','2018-08-03 09:31:42',NULL),(21,'modules.edit','Edit Module',1,'Edit Module','2018-08-03 09:31:42','2018-08-03 09:31:42',NULL),(22,'modules.destroy','Delete Module',1,'Delete Module','2018-08-03 09:31:42','2018-08-03 09:31:42',NULL),(23,'languages.index','List Languages',1,'List Languages','2018-08-03 09:31:42','2018-08-03 09:31:42',NULL),(24,'languages.create','Create Languages',1,'Create Languages','2018-08-03 09:31:42','2018-08-03 09:31:42',NULL),(25,'languages.show','View Languages',1,'View Languages','2018-08-03 09:31:42','2018-08-03 09:31:42',NULL),(26,'languages.edit','Edit Languages',1,'Edit Languages','2018-08-03 09:31:42','2018-08-03 09:31:42',NULL),(27,'languages.destroy','Delete Languages',1,'Delete Languages','2018-08-03 09:31:42','2018-08-03 09:31:42',NULL),(28,'pages.index','List Pages',1,'List Pages','2018-08-03 09:31:42','2018-08-03 09:31:42',NULL),(29,'pages.create','Create Pages',1,'Create Pages','2018-08-03 09:31:42','2018-08-03 09:31:42',NULL),(30,'pages.show','View Pages',1,'View Pages','2018-08-03 09:31:42','2018-08-03 09:31:42',NULL),(31,'pages.edit','Edit Pages',1,'Edit Pages','2018-08-03 09:31:42','2018-08-03 09:31:42',NULL),(32,'pages.destroy','Delete Pages',1,'Delete Pages','2018-08-03 09:31:42','2018-08-03 09:31:42',NULL),(33,'contactus.index','List Contact Us',1,'List Contact Us Record','2018-08-03 09:31:42','2018-08-03 09:31:42',NULL),(34,'contactus.create','Create Contact Us',1,'Create Contact Us Record','2018-08-03 09:31:42','2018-08-03 09:31:42',NULL),(35,'contactus.show','View Contact Us',1,'View Contact Us Record','2018-08-03 09:31:42','2018-08-03 09:31:42',NULL),(36,'contactus.edit','Edit Contact Us',1,'Edit Contact Us Record','2018-08-03 09:31:42','2018-08-03 09:31:42',NULL),(37,'contactus.destroy','Delete Contact Us',1,'Delete Contact Us Record','2018-08-03 09:31:42','2018-08-03 09:31:42',NULL),(38,'notifications.index','List Notification',1,'List Notification','2018-08-03 09:31:42','2018-08-03 09:31:42',NULL),(39,'notifications.create','Create Notification',1,'Create Notification','2018-08-03 09:31:42','2018-08-03 09:31:42',NULL),(40,'notifications.show','View Notification',1,'View Notification','2018-08-03 09:31:42','2018-08-03 09:31:42',NULL),(41,'notifications.edit','Edit Notification',1,'Edit Notification','2018-08-03 09:31:42','2018-08-03 09:31:42',NULL),(42,'notifications.destroy','Delete Notification',1,'Delete Notification','2018-08-03 09:31:42','2018-08-03 09:31:42',NULL),(53,'news.index','News',0,'Index news',NULL,NULL,NULL),(54,'news.create','News',0,'Create news',NULL,NULL,NULL),(55,'news.show','News',0,'Show news',NULL,NULL,NULL),(56,'news.edit','News',0,'Edit news',NULL,NULL,NULL),(57,'news.destroy','News',0,'Destroy news',NULL,NULL,NULL),(58,'comments.index','Comment',0,'Index comments',NULL,NULL,NULL),(59,'comments.create','Comment',0,'Create comments',NULL,NULL,NULL),(60,'comments.show','Comment',0,'Show comments',NULL,NULL,NULL),(61,'comments.edit','Comment',0,'Edit comments',NULL,NULL,NULL),(62,'comments.destroy','Comment',0,'Destroy comments',NULL,NULL,NULL),(63,'media.index','Media',0,'Index media',NULL,NULL,NULL),(64,'media.create','Media',0,'Create media',NULL,NULL,NULL),(65,'media.show','Media',0,'Show media',NULL,NULL,NULL),(66,'media.edit','Media',0,'Edit media',NULL,NULL,NULL),(67,'media.destroy','Media',0,'Destroy media',NULL,NULL,NULL),(68,'newsInteractions.index','News Interaction',0,'Index newsinteractions',NULL,NULL,NULL),(69,'newsInteractions.create','News Interaction',0,'Create newsinteractions',NULL,NULL,NULL),(70,'newsInteractions.show','News Interaction',0,'Show newsinteractions',NULL,NULL,NULL),(71,'newsInteractions.edit','News Interaction',0,'Edit newsinteractions',NULL,NULL,NULL),(72,'newsInteractions.destroy','News Interaction',0,'Destroy newsinteractions',NULL,NULL,NULL),(73,'categories.index','Category',0,'Index category',NULL,NULL,NULL),(74,'categories.create','Category',0,'Create category',NULL,NULL,NULL),(75,'categories.show','Category',0,'Show category',NULL,NULL,NULL),(76,'categories.edit','Category',0,'Edit category',NULL,NULL,NULL),(77,'categories.destroy','Category',0,'Destroy category',NULL,NULL,NULL);

/*Table structure for table `role_user` */

DROP TABLE IF EXISTS `role_user`;

CREATE TABLE `role_user` (
  `user_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`role_id`),
  KEY `role_user_role_id_foreign` (`role_id`),
  CONSTRAINT `role_user_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `role_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `role_user` */

insert  into `role_user`(`user_id`,`role_id`) values (1,1),(2,2),(3,3),(4,3),(5,3),(6,3),(8,3),(9,3),(10,3),(11,3),(12,3),(13,3),(14,3),(15,3),(16,3),(17,3),(18,3),(19,3),(20,3),(21,3),(22,3),(23,3),(24,3),(25,3),(26,3);

/*Table structure for table `roles` */

DROP TABLE IF EXISTS `roles`;

CREATE TABLE `roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_protected` tinyint(1) NOT NULL DEFAULT '0',
  `description` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `roles` */

insert  into `roles`(`id`,`name`,`display_name`,`is_protected`,`description`,`created_at`,`updated_at`,`deleted_at`) values (1,'super-admin','Super Admin',1,'Super Admin has all permissions','2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(2,'admin','Administrators',1,'Assign this role to all the users who are administrators.','2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(3,'authenticated','Authenticated',0,'Authenticated users will be able to access front-end functionality','2018-08-03 09:31:43','2018-08-03 09:31:43',NULL);

/*Table structure for table `social_accounts` */

DROP TABLE IF EXISTS `social_accounts`;

CREATE TABLE `social_accounts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `platform` varchar(255) NOT NULL,
  `client_id` varchar(255) NOT NULL,
  `token` varchar(255) DEFAULT NULL,
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

/*Data for the table `social_accounts` */

/*Table structure for table `user_details` */

DROP TABLE IF EXISTS `user_details`;

CREATE TABLE `user_details` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `first_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_updates` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0,1',
  `social_login` tinyint(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_details_user_id_foreign` (`user_id`),
  CONSTRAINT `user_details_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `user_details` */

insert  into `user_details`(`id`,`user_id`,`first_name`,`last_name`,`phone`,`address`,`image`,`email_updates`,`social_login`,`created_at`,`updated_at`,`deleted_at`) values (1,3,'Test',NULL,'78787',NULL,NULL,1,0,'2018-08-09 08:33:05','2018-08-09 08:33:05',NULL),(2,4,'Test',NULL,'78787',NULL,NULL,1,0,'2018-08-09 08:35:02','2018-08-09 08:35:02',NULL),(3,5,'String',NULL,'string','string',NULL,1,0,'2018-08-09 10:21:12','2018-08-09 10:21:12',NULL),(4,6,'String',NULL,'string','string',NULL,1,0,'2018-08-09 10:32:44','2018-08-09 10:32:44',NULL),(5,8,'Test',NULL,'78787',NULL,NULL,1,0,'2018-08-09 10:53:23','2018-08-09 10:53:23',NULL),(6,9,'String',NULL,'string','string',NULL,1,0,'2018-08-09 10:54:54','2018-08-09 10:54:54',NULL),(7,10,'String',NULL,'string','string',NULL,1,0,'2018-08-09 11:07:18','2018-08-09 11:07:18',NULL),(8,11,'String',NULL,'string','string',NULL,1,0,'2018-08-09 11:08:02','2018-08-09 11:08:02',NULL),(9,12,'Testuser123',NULL,'56565656',NULL,NULL,1,0,'2018-08-09 12:09:35','2018-08-09 12:09:35',NULL),(10,13,'Abc',NULL,'+971-4567897','Abc',NULL,1,0,'2018-08-10 06:49:38','2018-08-10 06:49:38',NULL),(11,14,'Abc',NULL,'+971-4567897','Abc',NULL,1,0,'2018-08-10 07:21:01','2018-08-10 07:21:01',NULL),(12,15,'John',NULL,'123456789',NULL,NULL,1,0,'2018-08-10 09:21:30','2018-08-10 09:21:30',NULL),(13,16,'Cc00',NULL,'string','cc00',NULL,1,0,'2018-08-10 10:04:01','2018-08-10 10:04:01',NULL),(14,17,'Sasa',NULL,'123456789','sasa',NULL,1,0,'2018-08-14 06:50:37','2018-08-14 06:50:37',NULL),(15,18,'String',NULL,'string','string',NULL,1,0,'2018-08-14 07:17:41','2018-08-14 07:17:41',NULL),(16,19,'Sasa',NULL,'123456789','sasa',NULL,1,0,'2018-08-14 07:26:10','2018-08-14 07:26:10',NULL),(17,20,'CC 00',NULL,NULL,'cc00',NULL,1,0,'2018-08-14 07:48:56','2018-08-14 07:48:56',NULL),(18,21,'John',NULL,NULL,NULL,NULL,1,0,'2018-08-15 07:17:41','2018-08-15 07:17:41',NULL),(19,22,'John',NULL,NULL,NULL,NULL,1,0,'2018-08-15 08:45:39','2018-08-15 08:45:39',NULL),(20,23,'CC 00',NULL,NULL,'cc00',NULL,1,0,'2018-08-15 08:56:19','2018-08-15 08:56:19',NULL),(21,24,'John',NULL,NULL,NULL,NULL,1,0,'2018-08-15 09:52:50','2018-08-15 09:52:50',NULL),(22,25,'CC 05',NULL,NULL,'xyz',NULL,1,0,'2018-08-15 10:11:57','2018-08-15 10:11:57',NULL),(23,26,'CC 06',NULL,'+93-5566786','xyz',NULL,1,0,'2018-08-15 11:07:37','2018-08-15 11:07:37',NULL),(24,27,NULL,NULL,NULL,NULL,NULL,0,1,'2018-08-15 14:00:24','2018-08-15 14:00:24',NULL);

/*Table structure for table `user_devices` */

DROP TABLE IF EXISTS `user_devices`;

CREATE TABLE `user_devices` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `device_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `device_token` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_devices_user_id_foreign` (`user_id`),
  CONSTRAINT `user_devices_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `user_devices` */

insert  into `user_devices`(`id`,`user_id`,`device_type`,`device_token`,`created_at`,`updated_at`,`deleted_at`) values (1,3,'test123','ios','2018-08-09 08:33:05','2018-08-09 08:35:02','2018-08-09 08:35:02'),(2,4,'test123','ios','2018-08-09 08:35:02','2018-08-09 10:53:24','2018-08-09 10:53:24'),(3,5,'android','xyz123','2018-08-09 10:21:12','2018-08-09 10:32:44','2018-08-09 10:32:44'),(4,6,'android','xyz123','2018-08-09 10:32:44','2018-08-09 11:07:18','2018-08-09 11:07:18'),(5,8,'test123','ios','2018-08-09 10:53:24','2018-08-09 10:53:24',NULL),(6,9,'string','string','2018-08-09 10:54:54','2018-08-14 07:17:41','2018-08-14 07:17:41'),(7,10,'android','xyz123','2018-08-09 11:07:18','2018-08-09 11:08:02','2018-08-09 11:08:02'),(8,11,'android','xyz123','2018-08-09 11:08:02','2018-08-10 10:04:01','2018-08-10 10:04:01'),(9,12,'android','123','2018-08-09 12:09:35','2018-08-09 12:09:35',NULL),(10,13,'android','xyz','2018-08-10 06:49:38','2018-08-10 07:21:01','2018-08-10 07:21:01'),(11,14,'android','xyz','2018-08-10 07:21:01','2018-08-15 10:11:57','2018-08-15 10:11:57'),(12,15,'ios','sasasasasassasasas','2018-08-10 09:21:30','2018-08-10 09:21:30',NULL),(13,16,'android','xyz123','2018-08-10 10:04:01','2018-08-14 07:48:56','2018-08-14 07:48:56'),(14,17,'ios','123456789','2018-08-14 06:50:37','2018-08-14 07:26:10','2018-08-14 07:26:10'),(15,18,'string','string','2018-08-14 07:17:41','2018-08-14 07:17:41',NULL),(16,19,'ios','123456789','2018-08-14 07:26:10','2018-08-14 07:26:10',NULL),(17,20,'android','xyz123','2018-08-14 07:48:56','2018-08-15 08:56:19','2018-08-15 08:56:19'),(18,21,'ios','this_is_temporary','2018-08-15 07:17:41','2018-08-15 08:45:39','2018-08-15 08:45:39'),(19,22,'ios','this_is_temporary','2018-08-15 08:45:39','2018-08-15 09:52:50','2018-08-15 09:52:50'),(20,23,'android','xyz123','2018-08-15 08:56:19','2018-08-15 08:56:19',NULL),(21,24,'ios','this_is_temporary','2018-08-15 09:52:50','2018-08-15 09:52:50',NULL),(22,25,'android','xyz','2018-08-15 10:11:57','2018-08-15 11:07:37','2018-08-15 11:07:37'),(23,26,'android','xyz','2018-08-15 11:07:37','2018-08-15 11:07:37',NULL),(24,27,'ios',NULL,'2018-08-15 14:00:24','2018-08-15 14:00:24',NULL);

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=latin1;

/*Data for the table `users` */

insert  into `users`(`id`,`name`,`email`,`password`,`remember_token`,`created_at`,`updated_at`,`deleted_at`) values (1,'Super Admin','superadmin@ingic.com','$2y$10$nE83rMTJ6iFRu36EOYEgr.JrHmiN1y3.Rh7CaXC8AbCTzAUeGzcai','CKtDv96kesVwFxa8JKvJ6g6XLjVUhSBPRH1t7pMFViLqq6pfMa2rb6Iv8VNJ','2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(2,'Admin','admin@ingic.com','$2y$10$aodW5Pcl4JHjNl/VecDOvOrBI5EmgcyJKtz8D/aymHbE3ilUXQEfy',NULL,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(3,'Test','test@gmail.com','$2y$10$v/vzUEoLsPBE0sDbmAacKuJYNZ0idKNgr7fjxqUm44pRxql1UxVsW',NULL,'2018-08-09 08:33:05','2018-08-09 08:33:05',NULL),(4,'Test','test24@gmail.com','$2y$10$6QCYPgidFWA0d/RHJxj8suOY3SA58IvdviEslo3K78y788OpK62f2',NULL,'2018-08-09 08:35:02','2018-08-09 08:35:02',NULL),(5,'String','x@x.com','$2y$10$g4XKoLC1GjJgvlwLJDwfOuM9ru9VMvt7vkl9C8kxwXLHKtsd5dt.O',NULL,'2018-08-09 10:21:12','2018-08-09 10:21:12',NULL),(6,'String','xy@x.com','$2y$10$NLdYvAqn9Veb30hqEakrwOHMJnvsF0owl5bto3EU.fXyepHxRLIQe',NULL,'2018-08-09 10:32:44','2018-08-09 10:32:44',NULL),(7,'String','test12@test.com','$2y$10$HDLBnOrnz.IpUStFNCjj0uDk9FRYwZRbf/mJeTAxT90OZkDoP.oe2',NULL,'2018-08-09 10:52:27','2018-08-09 10:52:27',NULL),(8,'Test','test122@test.com','$2y$10$MCsYBfaoHwEY.ZMFuadkbeRAHH37PlrrVgbc7hS1CKaK2bHx6uMbe',NULL,'2018-08-09 10:53:23','2018-08-09 10:53:23',NULL),(9,'String','test@test.com','$2y$10$w3ofHqRj9CMpv8y4jOWlK.WBanWyn5HnWSgW1mgdUK4m4rwhhq2Ee',NULL,'2018-08-09 10:54:54','2018-08-09 10:54:54',NULL),(10,'String','a@mailinator.com','$2y$10$DuQf8yAujub5.CwraypoeuqNhISNk8RFWVPXj6MOjjpsN9ZHp9L66',NULL,'2018-08-09 11:07:18','2018-08-09 11:07:18',NULL),(11,'String','b@mailinator.com','$2y$10$0s/LvvKM6vcSUwdJBvXPruj3eeEFcbEP80fuaPvO/EqKKFjgpkzY.',NULL,'2018-08-09 11:08:02','2018-08-09 11:08:02',NULL),(12,'Testuser123','testuser123@gmail.com','$2y$10$npI5ZkBH6xQFMP2poKZhoO1HJu2X5qnUvpQwd3MeNDwQoF9oJd3Tu',NULL,'2018-08-09 12:09:35','2018-08-14 07:01:52',NULL),(13,'Abc','a@p.com','$2y$10$hyZir5vmkiKJy9D6b17XSe6Si8y/du2OGJB5XpZ5X7zoaoHvh0X92',NULL,'2018-08-10 06:49:38','2018-08-10 06:49:38',NULL),(14,'Abc','c@p.com','$2y$10$GG3VpVkSV2LZJcxmQF/5zu75Zv0QS3cqPuNmP9MMi.qSoCJ47HHx2',NULL,'2018-08-10 07:21:01','2018-08-10 07:21:01',NULL),(15,'John','john@gmail.com','$2y$10$HyKXP2AnWmWFDvFMLHdMa.UMYJEvu8l/5qH80Xu7XeECoV.oJfCPG',NULL,'2018-08-10 09:21:30','2018-08-10 09:21:30',NULL),(16,'Cc00','cc@mailinator.com','$2y$10$sWTzClxPazhTsZfJ3a/yr.TSN5dtQ4L4q9UQ21QrNRyf3yeXMHqYW',NULL,'2018-08-10 10:04:01','2018-08-10 10:04:01',NULL),(17,'Sasa','123456789@gmail.com','$2y$10$sBjdfLIUhyG/80DMdrvKieA1S1sjL5tM.RKVZ3YwgvSLUDZR.8azi',NULL,'2018-08-14 06:50:37','2018-08-14 06:50:37',NULL),(18,'String','string@string.com','$2y$10$ynppAY5H1RSrYjO1Ti6Cve3TUfIcCQj3l/eMcaPxURS6ZrsJLDZrG',NULL,'2018-08-14 07:17:41','2018-08-14 07:17:41',NULL),(19,'Sasa','123456789A@gmail.com','$2y$10$kzI8iKUjIvUHrgN.91F97e2McmucWsMNE0YD6vzjA4sWwKiJVPRFC',NULL,'2018-08-14 07:26:10','2018-08-14 07:26:10',NULL),(20,'CC 00','cc00@mailinator.com','$2y$10$eQaHW3XTzFxmLeZrzg3ErOc7cGStFVVPm1mRUoJ8XGmzPPeGD7HbS',NULL,'2018-08-14 07:48:56','2018-08-15 11:41:58',NULL),(21,'John','John3223@gmail.com','$2y$10$EFFYaKk2QrSE6v.51JmF9e.0wl1SZBDWZw3zFwJ3xaqt7UBXq8ADO',NULL,'2018-08-15 07:17:41','2018-08-15 07:17:41',NULL),(22,'John','John021@gmail.com','$2y$10$r1vM/g7JvfUdAntm6JolgOQoK4A9l3xW2piOst3rookVyDgHBa9EO',NULL,'2018-08-15 08:45:39','2018-08-15 08:45:39',NULL),(23,'CC 00','cc10@mailinator.com','$2y$10$xbgnXP1fdAWH0lelG040i.Yv5djqlEuXhJn3w29mLpY0MFsB2L6YO',NULL,'2018-08-15 08:56:19','2018-08-15 08:56:19',NULL),(24,'John','John001@gmail.com','$2y$10$vGBFnnE4d90NROcU/IwPReBCKLVzAYD0jA432eCYLL/MdX3jm60ne',NULL,'2018-08-15 09:52:50','2018-08-15 09:52:50',NULL),(25,'CC 05','cc05@mailinator.com','$2y$10$xTmGxY1YynGls4BVTJIgOOjF3odwbiEHWfY8Ug.WDFxzHxYzC1xBO',NULL,'2018-08-15 10:11:57','2018-08-15 10:11:57',NULL),(26,'CC 06','cc06@mailinator.com','$2y$10$UnX8eaBWLXfOJMiRvHr.7ux2elf72rFm78/kgZXEPeYqR/OJX7eby',NULL,'2018-08-15 11:07:37','2018-08-15 11:07:37',NULL),(27,NULL,'Ingic.123456789@facebook.com','Ingic',NULL,'2018-08-15 14:00:24','2018-08-15 14:00:24',NULL);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
