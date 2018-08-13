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
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `category` */

insert  into `category`(`id`,`slug`,`user_id`,`created_at`,`updated_at`,`deleted_at`) values (1,'test category',1,'2018-08-09 17:10:29','2018-08-09 17:10:29',NULL);

/*Table structure for table `category_translations` */

DROP TABLE IF EXISTS `category_translations`;

CREATE TABLE `category_translations` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` int(11) unsigned DEFAULT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `locale` varbinary(50) DEFAULT '',
  `cretaed_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `category_translations_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `category_translations` */

insert  into `category_translations`(`id`,`category_id`,`name`,`locale`,`cretaed_at`,`updated_at`,`deleted_at`) values (1,1,'test','en','2018-08-09 17:34:59','2018-08-09 17:34:59',NULL),(2,1,'ٹھوٹ','ar','2018-08-09 17:35:19','2018-08-09 17:35:19',NULL);

/*Table structure for table `comments` */

DROP TABLE IF EXISTS `comments`;

CREATE TABLE `comments` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `comment_text` text COLLATE utf8mb4_unicode_ci,
  `parent_id` int(11) unsigned DEFAULT NULL,
  `post_id` int(11) unsigned DEFAULT NULL,
  `user_id` int(11) unsigned DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `comments_ibfk_1` (`post_id`),
  KEY `comments_ibfk_2` (`user_id`),
  KEY `parent_id` (`parent_id`),
  CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE,
  CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `comments_ibfk_3` FOREIGN KEY (`parent_id`) REFERENCES `comments` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `comments` */

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
  `instance_type` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `title` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `filename` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `post_id` (`instance_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `media_files` */

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
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `menus` */

insert  into `menus`(`id`,`name`,`icon`,`slug`,`position`,`is_protected`,`status`,`created_at`,`updated_at`,`deleted_at`) values (1,'Dashboard','fa fa-dashboard','dashboard',1,0,1,'2018-08-03 09:31:42','2018-08-03 09:31:42',NULL),(2,'Users','fa fa-user','users',2,0,1,'2018-08-03 09:31:42','2018-08-03 09:31:42',NULL),(3,'Roles','fa fa-edit','roles',3,0,1,'2018-08-03 09:31:42','2018-08-03 09:31:42',NULL),(4,'Permissions','fa fa-check-square-o','permissions',4,0,1,'2018-08-03 09:31:42','2018-08-03 09:31:42',NULL),(5,'Modules','fa fa-database','modules',5,0,1,'2018-08-03 09:31:42','2018-08-03 09:31:42',NULL),(6,'Languages','fa fa-comments-o','languages',6,0,1,'2018-08-03 09:31:42','2018-08-03 09:31:42',NULL),(7,'Pages','fa fa-wpforms','pages',7,0,1,'2018-08-03 09:31:42','2018-08-03 09:31:42',NULL),(8,'Contact us','fa fa-mail-forward','contactus',8,0,1,'2018-08-03 09:31:42','2018-08-03 09:31:42',NULL),(9,'Notifications','fa fa-bell','notifications',9,0,1,'2018-08-03 09:31:42','2018-08-03 09:31:42',NULL);

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
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `modules` */

insert  into `modules`(`id`,`name`,`slug`,`table_name`,`icon`,`status`,`is_module`,`config`,`is_protected`,`created_at`,`updated_at`,`deleted_at`) values (1,'Admin Panel','adminpanel','-','fa fa-dashboard',1,0,NULL,1,'2018-08-03 09:31:42','2018-08-03 09:31:42',NULL),(2,'Dashboard','dashboard','-','fa fa-dashboard',1,0,NULL,1,'2018-08-03 09:31:42','2018-08-03 09:31:42',NULL),(3,'Users','users','users','fa fa-user',1,1,NULL,1,'2018-08-03 09:31:42','2018-08-03 09:31:42',NULL),(4,'Roles','roles','roles','fa fa-edit',1,1,NULL,1,'2018-08-03 09:31:42','2018-08-03 09:31:42',NULL),(5,'Permissions','permissions','permissions','fa fa-check-square-o',1,1,NULL,1,'2018-08-03 09:31:42','2018-08-03 09:31:42',NULL),(6,'Modules','modules','modules','fa fa-database',1,1,NULL,1,'2018-08-03 09:31:42','2018-08-03 09:31:42',NULL),(7,'Languages','languages','locales','fa fa-comments-o',1,1,NULL,1,'2018-08-03 09:31:42','2018-08-03 09:31:42',NULL),(8,'Page','pages','pages','fa fa-wpforms',1,1,NULL,1,'2018-08-03 09:31:42','2018-08-03 09:31:42',NULL),(9,'ContactUs','contactus','admin_queries','fa fa-mail-forward',1,1,NULL,1,'2018-08-03 09:31:42','2018-08-03 09:31:42',NULL),(10,'Notification','notifications','notifications','fa fa-bell',1,1,NULL,1,'2018-08-03 09:31:42','2018-08-03 09:31:42',NULL);

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
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `password_resets` */

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

insert  into `permission_role`(`permission_id`,`role_id`) values (1,1),(2,1),(3,1),(4,1),(5,1),(6,1),(7,1),(8,1),(9,1),(10,1),(11,1),(12,1),(13,1),(14,1),(15,1),(16,1),(17,1),(18,1),(19,1),(20,1),(21,1),(22,1),(23,1),(24,1),(25,1),(26,1),(27,1),(28,1),(29,1),(30,1),(31,1),(32,1),(33,1),(34,1),(35,1),(36,1),(37,1),(38,1),(39,1),(40,1),(41,1),(42,1),(1,2),(2,2),(8,2),(9,2),(10,2),(11,2),(12,2),(13,2),(14,2),(15,2),(16,2),(17,2),(23,2),(24,2),(25,2),(26,2),(27,2),(28,2),(29,2),(30,2),(31,2),(32,2),(33,2),(34,2),(35,2),(36,2),(37,2),(38,2),(39,2),(40,2),(41,2),(42,2);

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
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `permissions` */

insert  into `permissions`(`id`,`name`,`display_name`,`is_protected`,`description`,`created_at`,`updated_at`,`deleted_at`) values (1,'adminpanel','Admin Panel',1,'Admin Panel','2018-08-03 09:31:42','2018-08-03 09:31:42',NULL),(2,'dashboard','Dashboard',1,'Dashboard','2018-08-03 09:31:42','2018-08-03 09:31:42',NULL),(3,'permissions.index','List Permissions',1,'List Permissions','2018-08-03 09:31:42','2018-08-03 09:31:42',NULL),(4,'permissions.create','Create Permission',1,'Create Permission','2018-08-03 09:31:42','2018-08-03 09:31:42',NULL),(5,'permissions.show','View Permission',1,'View Permission','2018-08-03 09:31:42','2018-08-03 09:31:42',NULL),(6,'permissions.edit','Edit Permission',1,'Edit Permission','2018-08-03 09:31:42','2018-08-03 09:31:42',NULL),(7,'permissions.destroy','Delete Permission',1,'Delete Permission','2018-08-03 09:31:42','2018-08-03 09:31:42',NULL),(8,'roles.index','List Roles',1,'List Roles','2018-08-03 09:31:42','2018-08-03 09:31:42',NULL),(9,'roles.create','Create Role',1,'Create Role','2018-08-03 09:31:42','2018-08-03 09:31:42',NULL),(10,'roles.show','View Role',1,'View Role','2018-08-03 09:31:42','2018-08-03 09:31:42',NULL),(11,'roles.edit','Edit Role',1,'Edit Role','2018-08-03 09:31:42','2018-08-03 09:31:42',NULL),(12,'roles.destroy','Delete Role',1,'Delete Role','2018-08-03 09:31:42','2018-08-03 09:31:42',NULL),(13,'users.index','List Roles',1,'List Roles','2018-08-03 09:31:42','2018-08-03 09:31:42',NULL),(14,'users.create','Create Users',1,'Create Users','2018-08-03 09:31:42','2018-08-03 09:31:42',NULL),(15,'users.show','View User',1,'View User','2018-08-03 09:31:42','2018-08-03 09:31:42',NULL),(16,'users.edit','Edit User',1,'Edit User','2018-08-03 09:31:42','2018-08-03 09:31:42',NULL),(17,'users.destroy','Delete User',1,'Delete User','2018-08-03 09:31:42','2018-08-03 09:31:42',NULL),(18,'modules.index','List Modules',1,'List Modules','2018-08-03 09:31:42','2018-08-03 09:31:42',NULL),(19,'modules.create','Create Module',1,'Create Module','2018-08-03 09:31:42','2018-08-03 09:31:42',NULL),(20,'modules.show','View Module',1,'View Module','2018-08-03 09:31:42','2018-08-03 09:31:42',NULL),(21,'modules.edit','Edit Module',1,'Edit Module','2018-08-03 09:31:42','2018-08-03 09:31:42',NULL),(22,'modules.destroy','Delete Module',1,'Delete Module','2018-08-03 09:31:42','2018-08-03 09:31:42',NULL),(23,'languages.index','List Languages',1,'List Languages','2018-08-03 09:31:42','2018-08-03 09:31:42',NULL),(24,'languages.create','Create Languages',1,'Create Languages','2018-08-03 09:31:42','2018-08-03 09:31:42',NULL),(25,'languages.show','View Languages',1,'View Languages','2018-08-03 09:31:42','2018-08-03 09:31:42',NULL),(26,'languages.edit','Edit Languages',1,'Edit Languages','2018-08-03 09:31:42','2018-08-03 09:31:42',NULL),(27,'languages.destroy','Delete Languages',1,'Delete Languages','2018-08-03 09:31:42','2018-08-03 09:31:42',NULL),(28,'pages.index','List Pages',1,'List Pages','2018-08-03 09:31:42','2018-08-03 09:31:42',NULL),(29,'pages.create','Create Pages',1,'Create Pages','2018-08-03 09:31:42','2018-08-03 09:31:42',NULL),(30,'pages.show','View Pages',1,'View Pages','2018-08-03 09:31:42','2018-08-03 09:31:42',NULL),(31,'pages.edit','Edit Pages',1,'Edit Pages','2018-08-03 09:31:42','2018-08-03 09:31:42',NULL),(32,'pages.destroy','Delete Pages',1,'Delete Pages','2018-08-03 09:31:42','2018-08-03 09:31:42',NULL),(33,'contactus.index','List Contact Us',1,'List Contact Us Record','2018-08-03 09:31:42','2018-08-03 09:31:42',NULL),(34,'contactus.create','Create Contact Us',1,'Create Contact Us Record','2018-08-03 09:31:42','2018-08-03 09:31:42',NULL),(35,'contactus.show','View Contact Us',1,'View Contact Us Record','2018-08-03 09:31:42','2018-08-03 09:31:42',NULL),(36,'contactus.edit','Edit Contact Us',1,'Edit Contact Us Record','2018-08-03 09:31:42','2018-08-03 09:31:42',NULL),(37,'contactus.destroy','Delete Contact Us',1,'Delete Contact Us Record','2018-08-03 09:31:42','2018-08-03 09:31:42',NULL),(38,'notifications.index','List Notification',1,'List Notification','2018-08-03 09:31:42','2018-08-03 09:31:42',NULL),(39,'notifications.create','Create Notification',1,'Create Notification','2018-08-03 09:31:42','2018-08-03 09:31:42',NULL),(40,'notifications.show','View Notification',1,'View Notification','2018-08-03 09:31:42','2018-08-03 09:31:42',NULL),(41,'notifications.edit','Edit Notification',1,'Edit Notification','2018-08-03 09:31:42','2018-08-03 09:31:42',NULL),(42,'notifications.destroy','Delete Notification',1,'Delete Notification','2018-08-03 09:31:42','2018-08-03 09:31:42',NULL);

/*Table structure for table `post_interactions` */

DROP TABLE IF EXISTS `post_interactions`;

CREATE TABLE `post_interactions` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned DEFAULT NULL,
  `post_id` int(11) unsigned DEFAULT NULL,
  `type` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT 'it could be "like", "favorite" or "view"',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `post_id` (`post_id`),
  CONSTRAINT `post_interactions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `post_interactions_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `post_interactions` */

/*Table structure for table `post_translations` */

DROP TABLE IF EXISTS `post_translations`;

CREATE TABLE `post_translations` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `post_id` int(11) unsigned DEFAULT NULL,
  `headline` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `description` longblob,
  `locale` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `post_id` (`post_id`),
  CONSTRAINT `post_translations_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `post_translations` */

/*Table structure for table `posts` */

DROP TABLE IF EXISTS `posts`;

CREATE TABLE `posts` (
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
  CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `posts_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `posts` */

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

insert  into `role_user`(`user_id`,`role_id`) values (1,1),(2,2),(3,3),(4,3),(5,3),(6,3),(8,3),(9,3),(10,3),(11,3),(12,3),(13,3),(14,3),(15,3),(16,3),(17,3),(21,3),(22,3),(23,3),(24,3),(26,3),(27,3),(28,3),(29,3),(30,3),(35,3),(36,3);

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

/*Table structure for table `user_details` */

DROP TABLE IF EXISTS `user_details`;

CREATE TABLE `user_details` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `first_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_updates` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0,1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_details_user_id_foreign` (`user_id`),
  CONSTRAINT `user_details_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `user_details` */

insert  into `user_details`(`id`,`user_id`,`first_name`,`last_name`,`phone`,`address`,`image`,`email_updates`,`created_at`,`updated_at`,`deleted_at`) values (1,3,'Test',NULL,'78787',NULL,NULL,1,'2018-08-09 08:33:05','2018-08-09 08:33:05',NULL),(2,4,'Test',NULL,'78787',NULL,NULL,1,'2018-08-09 08:35:02','2018-08-09 08:35:02',NULL),(3,5,'String',NULL,'string','string',NULL,1,'2018-08-09 10:21:12','2018-08-09 10:21:12',NULL),(4,6,'String',NULL,'string','string',NULL,1,'2018-08-09 10:32:44','2018-08-09 10:32:44',NULL),(5,8,'Test',NULL,'78787',NULL,NULL,1,'2018-08-09 10:53:23','2018-08-09 10:53:23',NULL),(6,9,'String',NULL,'string','string',NULL,1,'2018-08-09 10:54:54','2018-08-09 10:54:54',NULL),(7,10,'String',NULL,'string','string',NULL,1,'2018-08-09 11:07:18','2018-08-09 11:07:18',NULL),(8,11,'String',NULL,'string','string',NULL,1,'2018-08-09 11:08:02','2018-08-09 11:08:02',NULL),(9,12,'Testuser123',NULL,'56565656',NULL,NULL,1,'2018-08-09 12:09:35','2018-08-09 12:09:35',NULL),(10,13,'Abc',NULL,'+971-4567897','Abc',NULL,1,'2018-08-10 06:49:38','2018-08-10 06:49:38',NULL),(11,14,'Abc',NULL,'+971-4567897','Abc',NULL,1,'2018-08-10 07:21:01','2018-08-10 07:21:01',NULL),(12,15,'John',NULL,'123456789',NULL,NULL,1,'2018-08-10 09:21:30','2018-08-10 09:21:30',NULL),(13,16,'Cc00',NULL,'string','cc00',NULL,1,'2018-08-10 10:04:01','2018-08-10 10:04:01',NULL),(14,17,'John',NULL,NULL,NULL,NULL,1,'2018-08-10 11:36:00','2018-08-10 11:36:00',NULL),(15,18,'John',NULL,'123456789',NULL,NULL,1,'2018-08-10 11:53:18','2018-08-10 11:53:18',NULL),(16,19,'John',NULL,'123456789',NULL,NULL,1,'2018-08-10 11:54:43','2018-08-10 11:54:43',NULL),(17,20,'John',NULL,'123456789',NULL,NULL,1,'2018-08-10 12:01:12','2018-08-10 12:01:12',NULL),(18,21,'String',NULL,'string',NULL,NULL,1,'2018-08-10 12:03:17','2018-08-10 12:03:17',NULL),(19,22,'John',NULL,'123456789',NULL,NULL,1,'2018-08-10 12:04:16','2018-08-10 12:04:16',NULL),(20,23,'John',NULL,NULL,NULL,NULL,1,'2018-08-10 12:56:28','2018-08-10 12:56:28',NULL),(21,24,'Testuser1253',NULL,'56565656',NULL,NULL,1,'2018-08-10 13:24:31','2018-08-10 13:24:31',NULL),(22,25,'Testuser1253',NULL,'56565656',NULL,NULL,1,'2018-08-10 13:24:47','2018-08-10 13:24:47',NULL),(23,26,'CC 05',NULL,'+971-5566786','xyz',NULL,1,'2018-08-11 04:15:40','2018-08-11 04:15:40',NULL),(24,27,'CC 06',NULL,'+971-5566700','xyz',NULL,1,'2018-08-11 04:23:23','2018-08-11 04:23:23',NULL),(25,28,'CC 07',NULL,NULL,'xyz',NULL,1,'2018-08-11 04:31:31','2018-08-11 04:31:31',NULL),(26,29,'CC 08',NULL,NULL,'xyz',NULL,1,'2018-08-11 04:39:55','2018-08-11 04:39:55',NULL),(27,30,'CC 09',NULL,NULL,'xyz',NULL,1,'2018-08-11 04:45:18','2018-08-11 04:45:18',NULL),(28,31,'Testuser1253a',NULL,'56565656',NULL,NULL,1,'2018-08-11 05:30:28','2018-08-11 05:30:28',NULL),(29,32,'Teastuser1253a',NULL,'56565656',NULL,NULL,1,'2018-08-11 05:32:35','2018-08-11 05:32:35',NULL),(30,33,'Teasstuser1253a',NULL,'56565656',NULL,NULL,1,'2018-08-11 05:32:59','2018-08-11 05:32:59',NULL),(31,34,'Teasstuser1253a',NULL,'56565656',NULL,NULL,1,'2018-08-11 05:33:59','2018-08-11 05:33:59',NULL),(32,35,'Teasstuser1253a',NULL,'56565656',NULL,NULL,1,'2018-08-11 05:36:26','2018-08-11 05:36:26',NULL),(33,36,'Teasstuser1253a',NULL,'56565656',NULL,NULL,1,'2018-08-11 06:05:15','2018-08-11 06:05:15',NULL);

/*Table structure for table `user_devices` */

DROP TABLE IF EXISTS `user_devices`;

CREATE TABLE `user_devices` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `device_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `device_token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_devices_user_id_foreign` (`user_id`),
  CONSTRAINT `user_devices_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `user_devices` */

insert  into `user_devices`(`id`,`user_id`,`device_type`,`device_token`,`created_at`,`updated_at`,`deleted_at`) values (1,3,'test123','ios','2018-08-09 08:33:05','2018-08-09 08:35:02','2018-08-09 08:35:02'),(2,4,'test123','ios','2018-08-09 08:35:02','2018-08-09 10:53:24','2018-08-09 10:53:24'),(3,5,'android','xyz123','2018-08-09 10:21:12','2018-08-09 10:32:44','2018-08-09 10:32:44'),(4,6,'android','xyz123','2018-08-09 10:32:44','2018-08-09 11:07:18','2018-08-09 11:07:18'),(5,8,'test123','ios','2018-08-09 10:53:24','2018-08-09 10:53:24',NULL),(6,9,'string','string','2018-08-09 10:54:54','2018-08-10 12:03:17','2018-08-10 12:03:17'),(7,10,'android','xyz123','2018-08-09 11:07:18','2018-08-09 11:08:02','2018-08-09 11:08:02'),(8,11,'android','xyz123','2018-08-09 11:08:02','2018-08-10 10:04:01','2018-08-10 10:04:01'),(9,12,'android','123','2018-08-09 12:09:35','2018-08-10 13:24:32','2018-08-10 13:24:32'),(10,13,'android','xyz','2018-08-10 06:49:38','2018-08-10 07:21:01','2018-08-10 07:21:01'),(11,14,'android','xyz','2018-08-10 07:21:01','2018-08-11 04:15:40','2018-08-11 04:15:40'),(12,15,'ios','sasasasasassasasas','2018-08-10 09:21:30','2018-08-10 09:21:30',NULL),(13,16,'android','xyz123','2018-08-10 10:04:01','2018-08-10 10:04:01',NULL),(14,17,'ios','asasasas','2018-08-10 11:36:00','2018-08-10 11:36:00',NULL),(15,21,'string','string','2018-08-10 12:03:17','2018-08-10 12:03:17',NULL),(16,22,'ios','32323232','2018-08-10 12:04:16','2018-08-10 12:04:16',NULL),(17,23,'ios','this_is_temporary','2018-08-10 12:56:28','2018-08-10 12:56:28',NULL),(18,24,'android','123','2018-08-10 13:24:32','2018-08-10 13:24:32',NULL),(19,26,'android','xyz','2018-08-11 04:15:40','2018-08-11 04:23:23','2018-08-11 04:23:23'),(20,27,'android','xyz','2018-08-11 04:23:23','2018-08-11 04:31:31','2018-08-11 04:31:31'),(21,28,'android','xyz','2018-08-11 04:31:31','2018-08-11 04:39:55','2018-08-11 04:39:55'),(22,29,'android','xyz','2018-08-11 04:39:55','2018-08-11 04:45:18','2018-08-11 04:45:18'),(23,30,'android','xyz','2018-08-11 04:45:18','2018-08-11 04:45:18',NULL);

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=latin1;

/*Data for the table `users` */

insert  into `users`(`id`,`name`,`email`,`password`,`remember_token`,`created_at`,`updated_at`,`deleted_at`) values (1,'Super Admin','superadmin@ingic.com','$2y$10$nE83rMTJ6iFRu36EOYEgr.JrHmiN1y3.Rh7CaXC8AbCTzAUeGzcai',NULL,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(2,'Admin','admin@ingic.com','$2y$10$aodW5Pcl4JHjNl/VecDOvOrBI5EmgcyJKtz8D/aymHbE3ilUXQEfy',NULL,'2018-08-03 09:31:43','2018-08-03 09:31:43',NULL),(3,'Test','test@gmail.com','$2y$10$v/vzUEoLsPBE0sDbmAacKuJYNZ0idKNgr7fjxqUm44pRxql1UxVsW',NULL,'2018-08-09 08:33:05','2018-08-09 08:33:05',NULL),(4,'Test','test24@gmail.com','$2y$10$6QCYPgidFWA0d/RHJxj8suOY3SA58IvdviEslo3K78y788OpK62f2',NULL,'2018-08-09 08:35:02','2018-08-09 08:35:02',NULL),(5,'String','x@x.com','$2y$10$g4XKoLC1GjJgvlwLJDwfOuM9ru9VMvt7vkl9C8kxwXLHKtsd5dt.O',NULL,'2018-08-09 10:21:12','2018-08-09 10:21:12',NULL),(6,'String','xy@x.com','$2y$10$NLdYvAqn9Veb30hqEakrwOHMJnvsF0owl5bto3EU.fXyepHxRLIQe',NULL,'2018-08-09 10:32:44','2018-08-09 10:32:44',NULL),(7,'String','test12@test.com','$2y$10$HDLBnOrnz.IpUStFNCjj0uDk9FRYwZRbf/mJeTAxT90OZkDoP.oe2',NULL,'2018-08-09 10:52:27','2018-08-09 10:52:27',NULL),(8,'Test','test122@test.com','$2y$10$MCsYBfaoHwEY.ZMFuadkbeRAHH37PlrrVgbc7hS1CKaK2bHx6uMbe',NULL,'2018-08-09 10:53:23','2018-08-09 10:53:23',NULL),(9,'String','test@test.com','$2y$10$w3ofHqRj9CMpv8y4jOWlK.WBanWyn5HnWSgW1mgdUK4m4rwhhq2Ee',NULL,'2018-08-09 10:54:54','2018-08-09 10:54:54',NULL),(10,'String','a@mailinator.com','$2y$10$DuQf8yAujub5.CwraypoeuqNhISNk8RFWVPXj6MOjjpsN9ZHp9L66',NULL,'2018-08-09 11:07:18','2018-08-09 11:07:18',NULL),(11,'String','b@mailinator.com','$2y$10$0s/LvvKM6vcSUwdJBvXPruj3eeEFcbEP80fuaPvO/EqKKFjgpkzY.',NULL,'2018-08-09 11:08:02','2018-08-09 11:08:02',NULL),(12,'Testuser123','testuser123@gmail.com','$2y$10$7lx08KRppUhwQpr.k4oYMe9TyTnhTCVEU0VTGBWO.fX2S5cz9y/IK',NULL,'2018-08-09 12:09:35','2018-08-09 12:09:35',NULL),(13,'Abc','a@p.com','$2y$10$hyZir5vmkiKJy9D6b17XSe6Si8y/du2OGJB5XpZ5X7zoaoHvh0X92',NULL,'2018-08-10 06:49:38','2018-08-10 06:49:38',NULL),(14,'Abc','c@p.com','$2y$10$GG3VpVkSV2LZJcxmQF/5zu75Zv0QS3cqPuNmP9MMi.qSoCJ47HHx2',NULL,'2018-08-10 07:21:01','2018-08-10 07:21:01',NULL),(15,'John','john@gmail.com','$2y$10$HyKXP2AnWmWFDvFMLHdMa.UMYJEvu8l/5qH80Xu7XeECoV.oJfCPG',NULL,'2018-08-10 09:21:30','2018-08-10 09:21:30',NULL),(16,'Cc00','cc@mailinator.com','$2y$10$sWTzClxPazhTsZfJ3a/yr.TSN5dtQ4L4q9UQ21QrNRyf3yeXMHqYW',NULL,'2018-08-10 10:04:01','2018-08-10 10:04:01',NULL),(17,'John','john1@gmail.com','$2y$10$nyS1d9BnD.kfe5K3cEtzQ.J5J9PudEp7TRZm.xhfs1.ilCgpBbY2m',NULL,'2018-08-10 11:36:00','2018-08-10 11:36:00',NULL),(18,'John','john5@gmail.com','$2y$10$3wcfQZxD51UsP8t3CMZsa.Ts9dWsGNFc50AtXAl0si0uxh1zj/Vgm',NULL,'2018-08-10 11:53:18','2018-08-10 11:53:18',NULL),(19,'John','john3235@gmail.com','$2y$10$VfbB63QsiCTNATJJtEycR.TfgAIbfDiChDfGQi/c5efQT1bgTvzAa',NULL,'2018-08-10 11:54:43','2018-08-10 11:54:43',NULL),(20,'John','joh41n55@gmail.com','$2y$10$4R132h7IObQRTX/M8SOwNOdv7Zt8oPyL7w/6u8Iv3oxRpxif6roG.',NULL,'2018-08-10 12:01:12','2018-08-10 12:01:12',NULL),(21,'String','nayamemail@gmail.com','$2y$10$iR0L7jNM5m/G3Popuoj30uhwO/99NLs8OP30I.Y5WspJiJVi3gAoC',NULL,'2018-08-10 12:03:17','2018-08-10 12:03:17',NULL),(22,'John','joh41n55212@gmail.com','$2y$10$hfaC0uXIzlfFSSRtEOd/1uyUACO.0sY2uTr9Rm69CzCuu.452vFbO',NULL,'2018-08-10 12:04:16','2018-08-10 12:04:16',NULL),(23,'John','John0912@gmail.com','$2y$10$dZKw1amRFmD7u5UfwhX/OuQ2eQPaOlXjcSEMrr/WR9.XDYtaVBcNq',NULL,'2018-08-10 12:56:28','2018-08-10 12:56:28',NULL),(24,'Testuser1253','testuser1231@gmail.com','$2y$10$mIlqj88uN/4DiawHA0MJtepBN23sS9VViejJ1qYkSpUTs2iiKcWuC',NULL,'2018-08-10 13:24:31','2018-08-10 13:24:31',NULL),(25,'Testuser1253','testuser1231a@gmail.com','$2y$10$38Xf52BgiKCLIRHnTUQu9OUl61orCbd.jv4zpW5/VBE9khN1h/HwC',NULL,'2018-08-10 13:24:47','2018-08-10 13:24:47',NULL),(26,'CC 05','cc05@mailinator.com','$2y$10$GrlMw0zFE3UpsmX1125BTeR2rCLYo5g7cM4HqLkGJ0DlgAFu5Xey2',NULL,'2018-08-11 04:15:40','2018-08-11 04:15:40',NULL),(27,'CC 06','cc06@mailinator.com','$2y$10$oHVrdP7aLciMBU27irK3VON84IcyxHO6f2BjAgEWo5/2vAXBsx8hi',NULL,'2018-08-11 04:23:23','2018-08-11 04:23:23',NULL),(28,'CC 07','cc07@mailinator.com','$2y$10$TIYtrke4ibOEEI4m3kyVTug34ysmgQkoYr53o5lSxu/sLCnWXb20S',NULL,'2018-08-11 04:31:31','2018-08-11 04:31:31',NULL),(29,'CC 08','cc08@mailinator.com','$2y$10$Tnm/onvpRFE.psA2RFJgO.YTU9tePz/ld0F..h4ExMTioUxSLxTVm',NULL,'2018-08-11 04:39:55','2018-08-11 04:39:55',NULL),(30,'CC 09','cc09@mailinator.com','$2y$10$4WnyYjJADTOpViwRJnyLLec517XJh8DpZShU.RP4cpffS0BcC9dSi',NULL,'2018-08-11 04:45:18','2018-08-11 04:45:18',NULL),(31,'Testuser1253a','testuser12311a@gmail.com','$2y$10$NZcYVYY5d8VSW23X5226BOlau4stF/5AQJ4.gtrt3c8bratf/kuXC',NULL,'2018-08-11 05:30:28','2018-08-11 05:30:28',NULL),(32,'Teastuser1253a','tesatuser12311a@gmail.com','$2y$10$bkU8rU31tAjhVrXc0roFgOj/g3SIoRjUXoZEOBNTBrFBs7803zGtW',NULL,'2018-08-11 05:32:35','2018-08-11 05:32:35',NULL),(33,'Teasstuser1253a','tesatuser1231s1a@gmail.com','$2y$10$oLaNDIaXYC9n/ii4Nz5LRuRuvH6Vozh3KDYHMU9YV4q3DHHoDBOP6',NULL,'2018-08-11 05:32:59','2018-08-11 05:32:59',NULL),(34,'Teasstuser1253a','tesatuser123s1s1a@gmail.com','$2y$10$TokS5ozbYaQP9GGVK2skkux2S.iT5biP1hkRhsYDKy03EF8phPjxG',NULL,'2018-08-11 05:33:59','2018-08-11 05:33:59',NULL),(35,'Teasstuser1253a','testingDev@gmail.com','$2y$10$Y97CpL4XLY43oZH0fX/Tn.cKH8FA9EssFk4GCjKS1YkS7rFILrcVu',NULL,'2018-08-11 05:36:26','2018-08-11 05:36:26',NULL),(36,'Teasstuser1253a','etestingDev@gmail.com','$2y$10$ukEQJbE/GdNm/8L0IfG5HeDv.LUB0fQtZbBLaz5Amn72UIXAbzSnu',NULL,'2018-08-11 06:05:15','2018-08-11 06:05:15',NULL);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
