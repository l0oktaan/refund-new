/*
Navicat MySQL Data Transfer

Source Server         : mysql
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : refund

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2019-07-13 15:45:04
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `10_form_rules`
-- ----------------------------
DROP TABLE IF EXISTS `10_form_rules`;
CREATE TABLE `10_form_rules` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `form_id` int(10) unsigned NOT NULL,
  `order` int(11) NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sub_of` int(11) NOT NULL,
  `rule_type` int(11) NOT NULL,
  `result_type` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `10_form_rules_form_id_index` (`form_id`),
  CONSTRAINT `10_form_rules_form_id_foreign` FOREIGN KEY (`form_id`) REFERENCES `9_forms` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of 10_form_rules
-- ----------------------------
INSERT INTO `10_form_rules` VALUES ('1', '1', '2', 'สัญญาที่จะได้รับความช่วยเหลือ', '0', '1', '1', '1', '2019-04-07 05:28:40', '2019-07-11 07:31:59');
INSERT INTO `10_form_rules` VALUES ('2', '1', '2', 'ลงนามระหว่างวันที่ 23 มี.ค. 54 - 18 เม.ย. 54', '1', '2', '0', '1', '2019-04-07 05:28:48', '2019-06-12 03:13:12');
INSERT INTO `10_form_rules` VALUES ('5', '1', '3', 'การขยายเวลา งดหรือลดค่าปรับ ได้ 180 วัน', '0', '1', '0', '0', '2019-05-20 10:15:39', '2019-06-12 13:15:49');
INSERT INTO `10_form_rules` VALUES ('7', '4', '1', 'Rule 1.1', '4', '2', '0', '0', '2019-05-20 10:41:59', '2019-05-20 10:41:59');
INSERT INTO `10_form_rules` VALUES ('15', '22', '1', 'เป็นสัญญาจ้างก่อสร้าง', '0', '1', '0', '0', '2019-05-25 07:52:01', '2019-05-25 07:52:01');
INSERT INTO `10_form_rules` VALUES ('17', '1', '1', 'ลงนามก่อนวันที่ 23 มี.ค. 54', '1', '2', '0', '0', '2019-06-05 10:34:58', '2019-06-12 03:12:50');
INSERT INTO `10_form_rules` VALUES ('31', '4', '1', 'เป็นสัญญาจ้างก่อสร้าง', '0', '1', '0', '0', '2019-07-11 06:20:20', '2019-07-11 06:20:20');
INSERT INTO `10_form_rules` VALUES ('33', '1', '1', 'เป็นสัญญาจ้างก่อสร้าง', '0', '1', '0', '0', '2019-07-11 07:31:45', '2019-07-11 07:31:45');

-- ----------------------------
-- Table structure for `11_form_conditions`
-- ----------------------------
DROP TABLE IF EXISTS `11_form_conditions`;
CREATE TABLE `11_form_conditions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `form_rule_id` int(10) unsigned NOT NULL,
  `order` int(11) DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `condition_type` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `11_form_conditions_form_rule_id_index` (`form_rule_id`),
  CONSTRAINT `11_form_conditions_form_rule_id_foreign` FOREIGN KEY (`form_rule_id`) REFERENCES `10_form_rules` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of 11_form_conditions
-- ----------------------------
INSERT INTO `11_form_conditions` VALUES ('3', '2', '1', 'ลงนามระหว่างวันที่ 23 มี.ค. 54 - 18 เม.ย. 54', '1', '1', '1', '2019-04-07 07:20:30', '2019-06-12 03:13:49');
INSERT INTO `11_form_conditions` VALUES ('6', '7', null, 'เป็นสัญญาจ้างก่อสร้าง', 'คำอธิบาย', '1', '1', '2019-05-22 04:19:25', '2019-05-22 04:29:55');
INSERT INTO `11_form_conditions` VALUES ('8', '5', null, 'งดหรือลดค่าปรับ - วัน ถึงวันที่ -', 'คำอธิบาย', '2', '1', '2019-05-22 04:33:39', '2019-06-12 13:18:54');
INSERT INTO `11_form_conditions` VALUES ('11', '15', null, 'เป็นสัญญาจ้างก่อสร้าง', 'คำอธิบาย', '1', '1', '2019-05-25 07:52:26', '2019-07-11 03:36:28');
INSERT INTO `11_form_conditions` VALUES ('13', '17', null, 'ลงนามก่อนวันที่ 23 มี.ค. 54', 'คำอธิบาย', '1', '1', '2019-06-12 03:13:35', '2019-06-12 03:13:35');
INSERT INTO `11_form_conditions` VALUES ('16', '33', null, 'เป็นสัญญาจ้างก่อสร้าง', 'คำอธิบาย', '1', '1', '2019-07-11 07:32:34', '2019-07-11 07:32:34');

-- ----------------------------
-- Table structure for `12_refund_forms`
-- ----------------------------
DROP TABLE IF EXISTS `12_refund_forms`;
CREATE TABLE `12_refund_forms` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `form_id` int(10) unsigned NOT NULL,
  `refund_id` int(10) unsigned NOT NULL,
  `result` tinyint(4) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `12_refund_forms_form_id_index` (`form_id`),
  KEY `12_refund_forms_refund_id_index` (`refund_id`),
  CONSTRAINT `12_refund_forms_form_id_foreign` FOREIGN KEY (`form_id`) REFERENCES `9_forms` (`id`) ON DELETE CASCADE,
  CONSTRAINT `12_refund_forms_refund_id_foreign` FOREIGN KEY (`refund_id`) REFERENCES `2_refunds` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of 12_refund_forms
-- ----------------------------
INSERT INTO `12_refund_forms` VALUES ('13', '22', '2', '1', '1', '2019-05-28 03:24:36', '2019-05-28 03:24:36');
INSERT INTO `12_refund_forms` VALUES ('41', '1', '37', '0', '0', '2019-06-12 03:10:07', '2019-06-12 03:10:07');
INSERT INTO `12_refund_forms` VALUES ('42', '4', '38', '0', '0', '2019-06-12 03:10:30', '2019-06-12 03:10:30');
INSERT INTO `12_refund_forms` VALUES ('43', '1', '39', '0', '0', '2019-06-12 03:14:15', '2019-06-12 03:14:15');
INSERT INTO `12_refund_forms` VALUES ('44', '1', '40', '0', '0', '2019-06-12 12:09:40', '2019-06-12 12:09:40');
INSERT INTO `12_refund_forms` VALUES ('45', '1', '41', '0', '0', '2019-07-11 07:25:54', '2019-07-11 07:25:54');

-- ----------------------------
-- Table structure for `13_refund_details`
-- ----------------------------
DROP TABLE IF EXISTS `13_refund_details`;
CREATE TABLE `13_refund_details` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `refund_form_id` int(10) unsigned NOT NULL,
  `condition_id` int(10) unsigned NOT NULL,
  `value` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `13_refund_details_refund_form_id_index` (`refund_form_id`),
  KEY `13_refund_details_condition_id_index` (`condition_id`),
  CONSTRAINT `13_refund_details_condition_id_foreign` FOREIGN KEY (`condition_id`) REFERENCES `11_form_conditions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `13_refund_details_refund_form_id_foreign` FOREIGN KEY (`refund_form_id`) REFERENCES `12_refund_forms` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of 13_refund_details
-- ----------------------------
INSERT INTO `13_refund_details` VALUES ('2', '13', '11', 'result', '1', '2019-05-28 08:47:28', '2019-05-28 08:47:28');

-- ----------------------------
-- Table structure for `1_offices`
-- ----------------------------
DROP TABLE IF EXISTS `1_offices`;
CREATE TABLE `1_offices` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `1_offices_code_unique` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of 1_offices
-- ----------------------------
INSERT INTO `1_offices` VALUES ('1', '111111', 'กรมปศุสัตว์', 'ทรงวุฒิ สัจจบุตร', '0836360616', '1', '2019-03-06 08:49:13', '2019-03-06 08:49:13');
INSERT INTO `1_offices` VALUES ('2', '123456', 'กรมบัญชีกลาง์', 'Songwut Sajjaboot', '0836360616', '1', '2019-03-06 08:53:21', '2019-03-06 08:53:21');
INSERT INTO `1_offices` VALUES ('3', '222222', 'กรมบัญชีกลาง์', 'Songwut Sajjaboot', '0836360616', '1', '2019-03-06 08:53:37', '2019-03-06 08:53:37');

-- ----------------------------
-- Table structure for `2_refunds`
-- ----------------------------
DROP TABLE IF EXISTS `2_refunds`;
CREATE TABLE `2_refunds` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `office_id` int(10) unsigned NOT NULL,
  `approve_code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `create_date` date NOT NULL,
  `sent_date` date DEFAULT NULL,
  `complete_date` date DEFAULT NULL,
  `status` tinyint(4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `2_refunds_id_unique` (`id`),
  KEY `2_refunds_office_id_index` (`office_id`),
  CONSTRAINT `2_refunds_office_id_foreign` FOREIGN KEY (`office_id`) REFERENCES `1_offices` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of 2_refunds
-- ----------------------------
INSERT INTO `2_refunds` VALUES ('1', '1', '123456', '2019-03-07', null, null, '1', '2019-03-07 02:41:44', '2019-03-07 02:41:44');
INSERT INTO `2_refunds` VALUES ('2', '2', '123456', '2019-03-07', null, null, '1', '2019-03-07 02:53:20', '2019-03-07 02:53:20');
INSERT INTO `2_refunds` VALUES ('3', '2', '123456', '2019-03-07', null, null, '2', '2019-03-07 02:58:13', '2019-03-07 02:58:13');
INSERT INTO `2_refunds` VALUES ('4', '3', '123456', '2019-03-07', null, null, '1', '2019-03-07 02:58:24', '2019-03-07 02:58:24');
INSERT INTO `2_refunds` VALUES ('37', '2', '123456', '2019-06-12', null, null, '1', '2019-06-12 03:10:07', '2019-06-12 03:10:07');
INSERT INTO `2_refunds` VALUES ('38', '2', '123456', '2019-06-12', null, null, '1', '2019-06-12 03:10:30', '2019-06-12 03:10:30');
INSERT INTO `2_refunds` VALUES ('39', '2', '123456', '2019-06-12', null, null, '1', '2019-06-12 03:14:15', '2019-06-12 03:14:15');
INSERT INTO `2_refunds` VALUES ('40', '2', '123456', '2019-06-12', null, null, '1', '2019-06-12 12:09:40', '2019-06-12 12:09:40');
INSERT INTO `2_refunds` VALUES ('41', '2', '123456', '2019-07-11', null, null, '1', '2019-07-11 07:25:53', '2019-07-11 07:25:53');

-- ----------------------------
-- Table structure for `3_contracts`
-- ----------------------------
DROP TABLE IF EXISTS `3_contracts`;
CREATE TABLE `3_contracts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `refund_id` int(10) unsigned NOT NULL,
  `contract_party` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contract_no` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contract_date` date NOT NULL,
  `budget` bigint(20) NOT NULL,
  `penalty_per_day` double(8,2) NOT NULL,
  `contract_start` date NOT NULL,
  `contract_end` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `3_contracts_refund_id_index` (`refund_id`),
  CONSTRAINT `3_contracts_refund_id_foreign` FOREIGN KEY (`refund_id`) REFERENCES `2_refunds` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of 3_contracts
-- ----------------------------
INSERT INTO `3_contracts` VALUES ('1', '1', 'ABC', '12/2562', '2019-03-11', '120000', '100.00', '2017-01-01', '2018-01-31', '2019-03-11 04:39:47', '2019-03-11 04:39:47');
INSERT INTO `3_contracts` VALUES ('2', '2', 'XYZ', '12/2562', '2019-03-11', '120000', '100.00', '2017-01-01', '2018-01-31', '2019-03-12 03:01:43', '2019-03-12 03:01:43');
INSERT INTO `3_contracts` VALUES ('3', '3', 'XYZ', '12/2562', '2019-03-11', '120000', '100.00', '2017-01-01', '2018-01-31', '2019-05-23 02:38:16', '2019-05-23 02:38:16');

-- ----------------------------
-- Table structure for `4_contract_budget_edits`
-- ----------------------------
DROP TABLE IF EXISTS `4_contract_budget_edits`;
CREATE TABLE `4_contract_budget_edits` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `refund_id` int(10) unsigned NOT NULL,
  `order` int(11) NOT NULL,
  `budget_new` bigint(20) NOT NULL,
  `penalty_new` double(10,2) NOT NULL,
  `contract_edit_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `4_contract_budget_edits_refund_id_index` (`refund_id`),
  CONSTRAINT `4_contract_budget_edits_refund_id_foreign` FOREIGN KEY (`refund_id`) REFERENCES `2_refunds` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of 4_contract_budget_edits
-- ----------------------------
INSERT INTO `4_contract_budget_edits` VALUES ('1', '1', '1', '100000000', '120.00', '2017-01-01', '2019-03-14 02:13:11', '2019-03-22 02:49:04');
INSERT INTO `4_contract_budget_edits` VALUES ('2', '1', '2', '10000', '120.00', '2017-01-01', '2019-03-14 03:18:34', '2019-03-14 03:18:34');
INSERT INTO `4_contract_budget_edits` VALUES ('3', '2', '1', '10000', '120.00', '2017-01-01', '2019-03-20 07:02:12', '2019-03-20 07:02:12');

-- ----------------------------
-- Table structure for `5_contract_time_edits`
-- ----------------------------
DROP TABLE IF EXISTS `5_contract_time_edits`;
CREATE TABLE `5_contract_time_edits` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `refund_id` int(10) unsigned NOT NULL,
  `order` int(11) NOT NULL,
  `approve_date` date NOT NULL,
  `edit_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `edit_detail` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `edit_days` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `5_contract_time_edits_refund_id_index` (`refund_id`),
  CONSTRAINT `5_contract_time_edits_refund_id_foreign` FOREIGN KEY (`refund_id`) REFERENCES `2_refunds` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of 5_contract_time_edits
-- ----------------------------
INSERT INTO `5_contract_time_edits` VALUES ('1', '1', '1', '2019-01-01', '2', 'abcdef', '15', '2019-03-27 04:32:04', '2019-03-30 04:24:05');
INSERT INTO `5_contract_time_edits` VALUES ('2', '1', '1', '2019-01-01', '2', 'abcdef', '15', '2019-03-27 04:33:13', '2019-03-30 04:24:21');
INSERT INTO `5_contract_time_edits` VALUES ('3', '2', '1', '2019-01-01', '1', 'abcdef', '10', '2019-03-27 06:49:04', '2019-03-27 06:49:04');
INSERT INTO `5_contract_time_edits` VALUES ('4', '2', '2', '2019-01-01', '1', 'abcdef', '10', '2019-03-27 06:49:49', '2019-03-27 06:49:49');
INSERT INTO `5_contract_time_edits` VALUES ('5', '2', '1', '2019-01-01', '1', 'abcdef', '10', '2019-03-28 02:02:12', '2019-03-28 02:02:12');

-- ----------------------------
-- Table structure for `6_delivers`
-- ----------------------------
DROP TABLE IF EXISTS `6_delivers`;
CREATE TABLE `6_delivers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `refund_id` int(10) unsigned NOT NULL,
  `order` tinyint(4) NOT NULL,
  `detail` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `overdue_days` int(11) NOT NULL,
  `deliver_date` date NOT NULL,
  `penalty` double(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `6_delivers_refund_id_index` (`refund_id`),
  CONSTRAINT `6_delivers_refund_id_foreign` FOREIGN KEY (`refund_id`) REFERENCES `2_refunds` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of 6_delivers
-- ----------------------------
INSERT INTO `6_delivers` VALUES ('1', '1', '1', 'abcdef', '5', '2019-03-30', '1000.00', '2019-03-30 05:47:03', '2019-04-02 05:19:01');
INSERT INTO `6_delivers` VALUES ('2', '1', '2', 'abcdef', '10', '2019-03-30', '1000.00', '2019-03-30 06:12:38', '2019-03-30 06:12:38');
INSERT INTO `6_delivers` VALUES ('3', '2', '1', 'abcdef', '10', '2019-03-30', '1000.00', '2019-03-30 06:13:52', '2019-03-30 06:13:52');

-- ----------------------------
-- Table structure for `7_deposit_penalties`
-- ----------------------------
DROP TABLE IF EXISTS `7_deposit_penalties`;
CREATE TABLE `7_deposit_penalties` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `refund_id` int(10) unsigned NOT NULL,
  `order` tinyint(4) NOT NULL,
  `deposit_no` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deposit_date` date NOT NULL,
  `amount` double(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `7_deposit_penalties_refund_id_index` (`refund_id`),
  CONSTRAINT `7_deposit_penalties_refund_id_foreign` FOREIGN KEY (`refund_id`) REFERENCES `2_refunds` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of 7_deposit_penalties
-- ----------------------------
INSERT INTO `7_deposit_penalties` VALUES ('1', '1', '1', '1/2522', '2019-03-30', '10.00', '2019-04-02 08:18:24', '2019-04-02 08:21:25');
INSERT INTO `7_deposit_penalties` VALUES ('2', '1', '2', '1/2522', '2019-03-30', '10.00', '2019-04-02 08:24:21', '2019-04-02 08:24:21');
INSERT INTO `7_deposit_penalties` VALUES ('3', '2', '1', '1/2522', '2019-03-30', '10.00', '2019-04-02 08:24:48', '2019-04-02 08:24:48');

-- ----------------------------
-- Table structure for `8_approve_refunds`
-- ----------------------------
DROP TABLE IF EXISTS `8_approve_refunds`;
CREATE TABLE `8_approve_refunds` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `refund_id` int(10) unsigned NOT NULL,
  `receive_refund_date` date NOT NULL,
  `approve_refund_days` int(11) NOT NULL,
  `approve_refund_amount` double(8,2) NOT NULL,
  `amount` double(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `8_approve_refunds_refund_id_index` (`refund_id`),
  CONSTRAINT `8_approve_refunds_refund_id_foreign` FOREIGN KEY (`refund_id`) REFERENCES `2_refunds` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of 8_approve_refunds
-- ----------------------------
INSERT INTO `8_approve_refunds` VALUES ('1', '1', '2019-01-31', '30', '20.20', '200.20', '2019-04-02 09:02:41', '2019-04-02 09:33:10');

-- ----------------------------
-- Table structure for `9_forms`
-- ----------------------------
DROP TABLE IF EXISTS `9_forms`;
CREATE TABLE `9_forms` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name1` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name2` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name3` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `order` tinyint(4) DEFAULT NULL,
  `create_by` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of 9_forms
-- ----------------------------
INSERT INTO `9_forms` VALUES ('1', 'ฟอร์ม หมายเลข 7', '2ccv', 'The Form 1', '7', 'Songwut', '1', '2019-04-03 12:09:01', '2019-07-11 03:35:09');
INSERT INTO `9_forms` VALUES ('2', 'Form 2', 'This is form two 2', 'The Form 2', '4', 'Songwut', '1', '2019-04-07 06:04:58', '2019-05-14 08:52:00');
INSERT INTO `9_forms` VALUES ('3', 'ชื่อฟอร์ม', 'ชื่อฟอร์ม', 'ชื่อฟอร์ม', '2', 'Songwut', '1', '2019-05-10 04:52:59', '2019-05-14 08:51:48');
INSERT INTO `9_forms` VALUES ('4', 'ชื่อฟอร์ม 1', 'ชื่อฟอร์ม 1', 'ชื่อฟอร์ม 1', '1', 'Songwut', '1', '2019-05-10 04:53:51', '2019-05-14 09:24:18');
INSERT INTO `9_forms` VALUES ('5', 'ชื่อฟอร์ม5', 'ชื่อฟอร์ม5', 'ชื่อฟอร์ม5', '5', 'Songwut', '1', '2019-05-10 05:07:23', '2019-05-10 09:31:05');
INSERT INTO `9_forms` VALUES ('12', 'แบบฟอร์ม8', 'แบบฟอร์ม8', 'แบบฟอร์ม8', '3', 'Songwut', '1', '2019-05-14 07:31:57', '2019-05-14 07:34:31');
INSERT INTO `9_forms` VALUES ('13', 'แบบฟอร์ม8', 'แบบฟอร์ม8', 'แบบฟอร์ม8', '6', 'Songwut', '1', '2019-05-14 07:34:45', '2019-05-14 08:52:09');
INSERT INTO `9_forms` VALUES ('16', 'แบบd', '2ccv', 'The Form 1', '8', 'Songwut', '1', '2019-05-14 08:49:24', '2019-05-14 08:52:36');
INSERT INTO `9_forms` VALUES ('17', 'แบบฟอร์ม 9', 'แบบฟอร์ม 9', 'แบบฟอร์ม 9', '9', 'Songwut', '1', '2019-05-24 07:41:37', '2019-05-24 07:41:37');
INSERT INTO `9_forms` VALUES ('18', 'แบบฟอร์ม 10', 'แบบฟอร์ม 10', 'แบบฟอร์ม 10', '10', 'Songwut', '1', '2019-05-24 08:08:38', '2019-05-24 08:08:38');
INSERT INTO `9_forms` VALUES ('20', 'แบบฟอร์ม 11', 'แบบฟอร์ม 11', 'แบบฟอร์ม 11', '11', 'Songwut', '1', '2019-05-25 06:33:13', '2019-05-25 06:33:13');
INSERT INTO `9_forms` VALUES ('21', 'แบบฟอร์ม12', 'แบบฟอร์ม12', 'แบบฟอร์ม12', '12', 'Songwut', '1', '2019-05-25 07:45:34', '2019-05-25 07:45:34');
INSERT INTO `9_forms` VALUES ('22', 'แบบฟอร์ม13', 'แบบฟอร์ม13', 'แบบฟอร์ม13', '13', 'Songwut', '1', '2019-05-25 07:51:45', '2019-05-25 07:51:45');

-- ----------------------------
-- Table structure for `migrations`
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO `migrations` VALUES ('1', '2014_10_12_000000_create_users_table', '1');
INSERT INTO `migrations` VALUES ('2', '2014_10_12_100000_create_password_resets_table', '1');
INSERT INTO `migrations` VALUES ('23', '2019_02_26_065640_create_offices_table', '2');
INSERT INTO `migrations` VALUES ('24', '2019_02_26_065741_create_refunds_table', '3');
INSERT INTO `migrations` VALUES ('25', '2019_02_26_071313_create_contracts_table', '3');
INSERT INTO `migrations` VALUES ('26', '2019_02_26_072926_create_contract_budget_edits_table', '3');
INSERT INTO `migrations` VALUES ('27', '2019_02_26_073325_create_contract_time_edits_table', '3');
INSERT INTO `migrations` VALUES ('28', '2019_02_28_060828_create_delivers_table', '3');
INSERT INTO `migrations` VALUES ('29', '2019_02_28_061714_create_deposit_penalties_table', '3');
INSERT INTO `migrations` VALUES ('30', '2019_03_01_041558_create_approve_refunds_table', '3');
INSERT INTO `migrations` VALUES ('31', '2019_03_27_041248_add_order_to_time_edit_table', '4');
INSERT INTO `migrations` VALUES ('32', '2019_03_27_042522_modify_edit_day_to_time_edit_table', '5');
INSERT INTO `migrations` VALUES ('33', '2019_03_30_053231_modify_delivers_table', '6');
INSERT INTO `migrations` VALUES ('34', '2019_03_30_054258_modify_delivers_table', '7');
INSERT INTO `migrations` VALUES ('35', '2019_03_30_054609_modify_delivers_table', '8');
INSERT INTO `migrations` VALUES ('37', '2019_04_02_042952_desposit_penalty_rename_desposit_date', '9');
INSERT INTO `migrations` VALUES ('38', '2019_04_02_090037_rename_aprrove_refund_day_to_days', '10');
INSERT INTO `migrations` VALUES ('39', '2019_04_03_065038_create_forms_table', '11');
INSERT INTO `migrations` VALUES ('40', '2019_04_03_070239_create_refund_forms_table', '11');
INSERT INTO `migrations` VALUES ('41', '2019_04_03_070715_create_form_rules_table', '11');
INSERT INTO `migrations` VALUES ('44', '2019_04_03_071418_create_form_conditions_table', '12');
INSERT INTO `migrations` VALUES ('45', '2019_05_09_081408_add__column_order_in_form_table', '13');
INSERT INTO `migrations` VALUES ('46', '2019_05_28_034811_create_refund_details_table', '14');

-- ----------------------------
-- Table structure for `password_resets`
-- ----------------------------
DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of password_resets
-- ----------------------------

-- ----------------------------
-- Table structure for `users`
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of users
-- ----------------------------
