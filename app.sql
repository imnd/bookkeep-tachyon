/*
Target Server Type    : MYSQL
Target Server Version : 50711
File Encoding         : 65001

Date: 2018-08-13 20:07:05
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for `articles`
-- ----------------------------
DROP TABLE IF EXISTS `articles`;
CREATE TABLE `articles` (
  `id` smallint(8) unsigned NOT NULL AUTO_INCREMENT,
  `subcat_id` smallint(6) unsigned NOT NULL,
  `name` tinytext NOT NULL,
  `price` float(8,2) unsigned NOT NULL,
  `active` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `unit` enum('шт','кг') NOT NULL DEFAULT 'кг',
  PRIMARY KEY (`id`),
  KEY `subcat_id` (`subcat_id`),
  CONSTRAINT `articles_ibfk_1` FOREIGN KEY (`subcat_id`) REFERENCES `article_subcats` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `article_cats`
-- ----------------------------
DROP TABLE IF EXISTS `article_cats`;
CREATE TABLE `article_cats` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for `article_subcats`
-- ----------------------------
DROP TABLE IF EXISTS `article_subcats`;
CREATE TABLE `article_subcats` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `cat_id` smallint(5) unsigned NOT NULL,
  `name` tinytext NOT NULL,
  PRIMARY KEY (`id`),
  KEY `cat_id` (`cat_id`),
  CONSTRAINT `article_subcats_ibfk_1` FOREIGN KEY (`cat_id`) REFERENCES `article_cats` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `bills`
-- ----------------------------
DROP TABLE IF EXISTS `bills`;
CREATE TABLE `bills` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `contract_num` tinytext NOT NULL,
  `client_id` int(11) NOT NULL,
  `sum` double(10,2) NOT NULL,
  `remainder` double(10,2) unsigned NOT NULL COMMENT 'сколько денег не раскидано по фактурам',
  `date` date NOT NULL,
  `contents` tinytext NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `clients`
-- ----------------------------
DROP TABLE IF EXISTS `clients`;
CREATE TABLE `clients` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `name` tinytext NOT NULL,
  `address` tinytext,
  `region_id` smallint(5) unsigned DEFAULT NULL,
  `telephone` tinytext,
  `fax` tinytext,
  `contact_fio` tinytext,
  `contact_post` tinytext,
  `account` tinytext,
  `bank` tinytext CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `INN` bigint(12) DEFAULT NULL,
  `BIK` bigint(9) unsigned DEFAULT NULL,
  `KPP` bigint(12) DEFAULT NULL,
  `next_call_date` datetime DEFAULT NULL,
  `sort` smallint(6) unsigned NOT NULL,
  `active` tinyint(1) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `region_id` (`region_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `clients_articles_prises`
-- ----------------------------
DROP TABLE IF EXISTS `clients_articles_prises`;
CREATE TABLE `clients_articles_prises` (
  `client_id` smallint(6) unsigned NOT NULL DEFAULT '0',
  `article_id` int(11) unsigned NOT NULL,
  `price` double(10,2) unsigned NOT NULL,
  PRIMARY KEY (`client_id`,`article_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for `contracts`
-- ----------------------------
DROP TABLE IF EXISTS `contracts`;
CREATE TABLE `contracts` (
  `id` mediumint(7) unsigned NOT NULL AUTO_INCREMENT,
  `contract_num` tinytext NOT NULL,
  `date` date NOT NULL,
  `client_id` smallint(8) unsigned NOT NULL,
  `sum` double(12,2) unsigned DEFAULT NULL,
  `payed` double(12,2) DEFAULT NULL,
  `term_start` date DEFAULT NULL,
  `term_end` date DEFAULT NULL,
  `type` enum('contract','agreement') NOT NULL DEFAULT 'agreement',
  PRIMARY KEY (`id`),
  KEY `client_ID` (`client_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `contracts_rows`
-- ----------------------------
DROP TABLE IF EXISTS `contracts_rows`;
CREATE TABLE `contracts_rows` (
  `id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `contract_id` mediumint(7) unsigned NOT NULL,
  `article_id` smallint(8) unsigned NOT NULL,
  `quantity` double(10,3) unsigned NOT NULL,
  `price` double(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `article_ID` (`article_id`),
  KEY `invoice_ID` (`contract_id`),
  CONSTRAINT `contracts_rows_ibfk_1` FOREIGN KEY (`contract_id`) REFERENCES `contracts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `contracts_rows_ibfk_2` FOREIGN KEY (`article_id`) REFERENCES `articles` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `invoices`
-- ----------------------------
DROP TABLE IF EXISTS `invoices`;
CREATE TABLE `invoices` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `number` tinytext NOT NULL,
  `client_id` smallint(8) unsigned NOT NULL,
  `contract_num` tinytext NOT NULL,
  `sum` float(8,2) DEFAULT NULL,
  `payed` float(8,2) DEFAULT '0.00',
  PRIMARY KEY (`id`),
  KEY `client_ID` (`client_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `invoices_bills`
-- ----------------------------
DROP TABLE IF EXISTS `invoices_bills`;
CREATE TABLE `invoices_bills` (
  `invoice_id` int(11) unsigned NOT NULL,
  `bill_id` mediumint(8) unsigned NOT NULL,
  KEY `invoice_id` (`invoice_id`),
  KEY `bill_id` (`bill_id`),
  CONSTRAINT `invoices_bills_ibfk_1` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `invoices_bills_ibfk_2` FOREIGN KEY (`bill_id`) REFERENCES `bills` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `invoices_rows`
-- ----------------------------
DROP TABLE IF EXISTS `invoices_rows`;
CREATE TABLE `invoices_rows` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `invoice_id` int(11) unsigned NOT NULL,
  `article_id` smallint(8) unsigned NOT NULL,
  `quantity` double(10,3) unsigned NOT NULL,
  `price` double(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `article_ID` (`article_id`),
  KEY `invoice_ID` (`invoice_id`),
  CONSTRAINT `invoices_rows_ibfk_1` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `invoices_rows_ibfk_2` FOREIGN KEY (`article_id`) REFERENCES `article_cats` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `purchases`
-- ----------------------------
DROP TABLE IF EXISTS `purchases`;
CREATE TABLE `purchases` (
  `id` mediumint(9) unsigned NOT NULL AUTO_INCREMENT,
  `number` tinytext NOT NULL,
  `date` date DEFAULT NULL,
  `sum` float(8,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `purchases_rows`
-- ----------------------------
DROP TABLE IF EXISTS `purchases_rows`;
CREATE TABLE `purchases_rows` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `purchase_id` mediumint(9) unsigned NOT NULL,
  `article_subcategory_id` smallint(8) unsigned NOT NULL,
  `quantity` double(10,3) unsigned NOT NULL,
  `price` double(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `article_ID` (`article_subcategory_id`),
  KEY `invoice_ID` (`purchase_id`),
  CONSTRAINT `purchases_rows_ibfk_1` FOREIGN KEY (`purchase_id`) REFERENCES `purchases` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `purchases_rows_ibfk_2` FOREIGN KEY (`article_subcategory_id`) REFERENCES `article_subcats` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `regions`
-- ----------------------------
DROP TABLE IF EXISTS `regions`;
CREATE TABLE `regions` (
  `id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(200) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for `settings`
-- ----------------------------
DROP TABLE IF EXISTS `settings`;
CREATE TABLE `settings` (
  `ID` smallint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` tinytext NOT NULL,
  `key` tinytext NOT NULL,
  `value` tinytext NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

