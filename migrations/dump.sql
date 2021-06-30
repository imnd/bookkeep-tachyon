SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

CREATE TABLE `article_cats`  (
  `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = DYNAMIC;

CREATE TABLE `article_subcats`  (
  `id` smallint(6) UNSIGNED NOT NULL AUTO_INCREMENT,
  `cat_id` smallint(6) NOT NULL,
  `name` tinytext CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `cat_id`(`cat_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 189 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

CREATE TABLE `articles`  (
  `id` smallint(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `subcat_id` smallint(6) NOT NULL,
  `name` tinytext CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `price` float(8, 2) UNSIGNED NOT NULL,
  `active` tinyint(1) UNSIGNED NOT NULL DEFAULT 1,
  `unit` enum('шт','кг') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'кг',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `subcat_id`(`subcat_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 253 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

CREATE TABLE `bills`  (
  `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `contract_num` tinytext CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `client_id` int(11) NOT NULL,
  `sum` double(10, 2) NOT NULL,
  `remainder` double(10, 2) UNSIGNED NOT NULL COMMENT 'сколько денег не раскидано по фактурам',
  `date` date NOT NULL,
  `contents` tinytext CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 6098 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

CREATE TABLE `clients`  (
  `id` smallint(6) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` tinytext CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `address` tinytext CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `region_id` smallint(5) UNSIGNED NULL DEFAULT NULL,
  `telephone` tinytext CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `fax` tinytext CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `contact_fio` tinytext CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `contact_post` tinytext CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `account` tinytext CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `bank` tinytext CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `INN` bigint(12) NULL DEFAULT NULL,
  `BIK` bigint(9) UNSIGNED NULL DEFAULT NULL,
  `KPP` bigint(12) NULL DEFAULT NULL,
  `next_call_date` datetime(0) NULL DEFAULT NULL,
  `sort` smallint(6) UNSIGNED NOT NULL,
  `active` tinyint(1) UNSIGNED NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `region_id`(`region_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 269 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

CREATE TABLE `clients_articles_prises`  (
  `client_id` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `article_id` int(11) UNSIGNED NOT NULL,
  `price` double(10, 2) UNSIGNED NOT NULL
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = DYNAMIC;

CREATE TABLE `contracts`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `contract_num` tinytext CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `date` date NOT NULL,
  `client_id` smallint(8) UNSIGNED NOT NULL,
  `sum` double(12, 2) UNSIGNED NULL DEFAULT NULL,
  `payed` double(12, 2) NULL DEFAULT NULL,
  `term_start` date NULL DEFAULT NULL,
  `term_end` date NULL DEFAULT NULL,
  `type` enum('contract','agreement') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'agreement',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `client_ID`(`client_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 2612 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

CREATE TABLE `contracts_rows`  (
  `id` int(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `contract_id` mediumint(7) UNSIGNED NOT NULL,
  `article_id` smallint(6) UNSIGNED NOT NULL,
  `quantity` double(10, 3) UNSIGNED NOT NULL,
  `price` double(10, 2) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `article_ID`(`article_id`) USING BTREE,
  INDEX `invoice_ID`(`contract_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 32746 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = FIXED;

CREATE TABLE `invoices`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `number` tinytext CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `client_id` smallint(8) UNSIGNED NOT NULL,
  `contract_num` tinytext CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `sum` float(8, 2) NULL DEFAULT NULL,
  `payed` float(8, 2) NULL DEFAULT 0.00,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `client_ID`(`client_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 14134 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

CREATE TABLE `invoices_bills`  (
  `invoice_ID` int(11) UNSIGNED NOT NULL,
  `bill_ID` int(11) UNSIGNED NOT NULL
) ENGINE = MyISAM CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = FIXED;

CREATE TABLE `invoices_rows`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `invoice_id` int(11) UNSIGNED NOT NULL,
  `article_id` smallint(8) UNSIGNED NOT NULL,
  `quantity` double(10, 3) UNSIGNED NOT NULL,
  `price` double(10, 2) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `article_ID`(`article_id`) USING BTREE,
  INDEX `invoice_ID`(`invoice_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 81584 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = FIXED;

CREATE TABLE `purchases`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `number` tinytext CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `date` date NULL DEFAULT NULL,
  `sum` float(8, 2) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 697 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

CREATE TABLE `purchases_rows`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `purchase_id` int(11) UNSIGNED NOT NULL,
  `article_subcategory_id` smallint(8) UNSIGNED NOT NULL,
  `quantity` double(10, 3) UNSIGNED NOT NULL,
  `price` double(10, 2) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `article_ID`(`article_subcategory_id`) USING BTREE,
  INDEX `invoice_ID`(`purchase_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 12100 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = FIXED;

CREATE TABLE `regions`  (
  `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = DYNAMIC;

CREATE TABLE `settings`  (
  `id` smallint(3) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` tinytext CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `key` tinytext CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `value` tinytext CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 72 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

CREATE TABLE `users`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `email` char(128) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `confirmed` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `confirm_code` char(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `remember_token` char(128) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `api_token` char(60) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `username`(`username`) USING BTREE,
  UNIQUE INDEX `email`(`email`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 14 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = DYNAMIC;

SET FOREIGN_KEY_CHECKS = 1;