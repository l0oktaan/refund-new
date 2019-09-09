/*
Navicat MySQL Data Transfer

Source Server         : mysql
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : refund

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2019-09-09 11:13:33
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
  `condition` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `condition_type` int(11) DEFAULT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `10_form_rules_form_id_index` (`form_id`),
  CONSTRAINT `10_form_rules_form_id_foreign` FOREIGN KEY (`form_id`) REFERENCES `9_forms` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of 10_form_rules
-- ----------------------------
INSERT INTO `10_form_rules` VALUES ('1', '1', '1', 'เป็นการให้ความช่วยเหลือผู้ประกอบการก่อสร้างในภาคใต้ที่ได้รับผลกระทบทางอ้อมจากเหตุอุทกภัยที่เกิดขึ้นในช่วงตั้งแต่วันที่ 1 ธ.ค. 59 ถึงวันที่ 12 ก.พ. 60', '0', '1', '0', null, '0', null, '0', '2019-08-23 06:39:07', '2019-08-23 06:39:07');
INSERT INTO `10_form_rules` VALUES ('2', '1', '2', 'อยู่ในพื้นที่ภาคใต้ 1 จังหวัด ได้แก่ สตูล', '0', '1', '0', null, '0', null, '0', '2019-08-23 06:40:59', '2019-08-23 06:40:59');
INSERT INTO `10_form_rules` VALUES ('3', '1', '3', 'สัญญาที่จะได้รับความช่วยเหลือ', '0', '1', '1', null, '0', null, '0', '2019-08-23 06:41:41', '2019-08-23 06:46:17');
INSERT INTO `10_form_rules` VALUES ('4', '1', '1', '(ก.) ลงนามก่อน 1 ธ.ค. 59', '3', '2', '0', null, '0', null, '0', '2019-08-23 06:42:20', '2019-08-23 06:42:20');
INSERT INTO `10_form_rules` VALUES ('5', '1', '2', '(ข.) ลงนามระหว่าง 1 ธ.ค. 59 - 12 ก.พ. 60', '3', '2', '0', null, '0', null, '0', '2019-08-23 06:46:39', '2019-08-23 06:46:39');
INSERT INTO `10_form_rules` VALUES ('6', '1', '4', 'เป็นสัญญาตาม (ก.) หรือ (ข.) ที่', '0', '1', '1', null, '0', null, '0', '2019-08-23 06:48:49', '2019-08-23 06:51:29');
INSERT INTO `10_form_rules` VALUES ('7', '1', '1', 'ณ วันที่ 1 ธ.ค. 59 - 12 ก.พ. 60 ยังมีนิติสัมพันธ์อยู่ และยังไม่ส่งมอบงานงวดสุดท้าย', '6', '2', '0', null, '0', null, '0', '2019-08-23 06:50:09', '2019-08-23 06:50:09');
INSERT INTO `10_form_rules` VALUES ('8', '1', '2', 'เป็นสัญญาตาม (ก.) หรือ (ข.) ยังมีนิติสัมพันธ์อยู่ แต่ส่งงานงวดสุดท้ายระหว่าง 1 ธ.ค. 59 - 12 ก.พ. 60', '6', '2', '0', null, '0', null, '0', '2019-08-23 06:52:15', '2019-08-23 06:52:15');
INSERT INTO `10_form_rules` VALUES ('9', '1', '5', 'การขยายเวลา งด/ลดค่าปรับ', '0', '1', '0', null, '0', null, '0', '2019-08-23 06:52:47', '2019-08-23 06:52:47');
INSERT INTO `10_form_rules` VALUES ('10', '1', '6', 'ผู้ประกอบการต้องยื่นคำขอต่อหน่วยงานภายใน 60 วัน นับถัดจากวันที่คณะรัฐมนตรีมีมติ', '0', '1', '0', null, '0', null, '0', '2019-08-23 06:57:13', '2019-08-23 06:57:13');
INSERT INTO `10_form_rules` VALUES ('11', '2', '1', 'เป็นไปตามระเบียบ ข้อบังคับ หรือข้อบัญญัติ ว่าด้วยการพัสดุของหน่วยงานนั้น ๆ', '0', '1', '0', null, '0', null, '0', '2019-08-23 07:07:57', '2019-08-23 07:07:57');
INSERT INTO `10_form_rules` VALUES ('12', '2', '2', 'เข้าตามกรณี', '0', '1', '1', null, '0', null, '0', '2019-08-23 07:08:28', '2019-08-23 07:09:16');
INSERT INTO `10_form_rules` VALUES ('13', '2', '1', '(1) เหตุเกิดจากความผิดหรือความบกพร่องของส่วนราชการ', '12', '2', '0', null, '0', null, '0', '2019-08-23 07:08:59', '2019-08-23 07:08:59');
INSERT INTO `10_form_rules` VALUES ('14', '2', '2', '(2) เหตุสุดวิสัย', '12', '2', '0', null, '0', null, '0', '2019-08-23 07:09:28', '2019-08-23 07:09:28');
INSERT INTO `10_form_rules` VALUES ('16', '4', '1', 'เป็นสัญญาจ้างก่อสร้าง', '0', '1', '0', null, '0', null, '0', '2019-09-05 02:11:24', '2019-09-05 02:11:24');
INSERT INTO `10_form_rules` VALUES ('17', '4', '2', 'Rule 3', '0', '1', '0', null, '0', null, '0', '2019-09-05 02:16:15', '2019-09-05 02:17:21');

-- ----------------------------
-- Table structure for `112_considers`
-- ----------------------------
DROP TABLE IF EXISTS `112_considers`;
CREATE TABLE `112_considers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `form_rule_id` int(10) unsigned NOT NULL,
  `order` int(11) NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` int(11) NOT NULL,
  `oper` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `var1` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `var2` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `112_considers_form_rule_id_index` (`form_rule_id`),
  CONSTRAINT `112_considers_form_rule_id_foreign` FOREIGN KEY (`form_rule_id`) REFERENCES `10_form_rules` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of 112_considers
-- ----------------------------
INSERT INTO `112_considers` VALUES ('1', '1', '0', 'เป็นงานก่อสร้าง', 'คำอธิบายงานก่อสร้าง', '1', '0', null, null, '2019-08-23 06:39:24', '2019-08-26 03:48:09');
INSERT INTO `112_considers` VALUES ('2', '2', '0', 'อยู่ในจังหวัดสตูล', null, '1', '0', null, null, '2019-08-23 06:41:11', '2019-08-23 06:41:11');
INSERT INTO `112_considers` VALUES ('3', '4', '0', 'ลงนามก่อน 1 ธ.ค. 59', null, '3', '2', '30/11/2016', null, '2019-08-23 06:45:55', '2019-08-23 06:45:55');
INSERT INTO `112_considers` VALUES ('4', '5', '0', 'ลงนามระหว่าง 1 ธ.ค. 59 - 12 ก.พ. 60', null, '3', '2', '12/02/2017', null, '2019-08-23 06:48:05', '2019-08-23 06:48:05');
INSERT INTO `112_considers` VALUES ('5', '7', '0', 'ณ วันที่ 1 ธ.ค. 59 - 12 ก.พ. 60 ยังมีนิติสัมพันธ์อยู่ และยังไม่ส่งมอบงานงวดสุดท้าย', null, '1', '0', null, null, '2019-08-23 06:51:18', '2019-08-23 06:51:18');
INSERT INTO `112_considers` VALUES ('6', '8', '0', 'เป็นสัญญาตาม (ก.) หรือ (ข.) ยังมีนิติสัมพันธ์อยู่ แต่ส่งงานงวดสุดท้ายระหว่าง 1 ธ.ค. 59 - 12 ก.พ. 60', null, '1', '0', null, null, '2019-08-23 06:52:25', '2019-08-23 06:52:25');
INSERT INTO `112_considers` VALUES ('7', '9', '0', 'ขยาย งดหรือลด จำนวน (วัน)', null, '2', '0', null, null, '2019-08-23 06:53:47', '2019-08-23 06:53:47');
INSERT INTO `112_considers` VALUES ('8', '9', '0', 'ถึงวันที่', null, '2', '0', null, null, '2019-08-23 06:54:10', '2019-08-23 06:54:10');
INSERT INTO `112_considers` VALUES ('9', '10', '0', 'ยื่นคำขอภายในวันที่ 23 มิ.ย. 62', null, '1', '0', null, null, '2019-08-23 06:57:53', '2019-08-23 06:57:53');
INSERT INTO `112_considers` VALUES ('10', '10', '0', 'หน่วยงานรับหนังสือขอรับความช่วยเหลือเมื่อวันที่', null, '3', '2', '23/06/2017', null, '2019-08-23 07:02:57', '2019-08-23 07:02:57');
INSERT INTO `112_considers` VALUES ('11', '11', '0', 'เป็นไปตามระเบียบ ข้อ', null, '2', '0', null, null, '2019-08-23 07:08:12', '2019-08-23 07:08:12');
INSERT INTO `112_considers` VALUES ('12', '13', '0', 'ให้ตาม (1)', null, '1', '0', null, null, '2019-08-23 07:09:07', '2019-08-23 07:09:07');
INSERT INTO `112_considers` VALUES ('13', '14', '0', 'ให้ตาม (2)', null, '1', '0', null, null, '2019-08-23 07:09:44', '2019-08-23 07:09:44');
INSERT INTO `112_considers` VALUES ('20', '16', '0', 'เป็นสัญญาจ้างก่อสร้าง', 'คำอธิบาย', '1', '0', null, null, '2019-09-05 02:12:08', '2019-09-05 02:12:08');
INSERT INTO `112_considers` VALUES ('21', '16', '0', 'Rule 3', 'คำอธิบาย', '2', '0', null, null, '2019-09-05 02:12:29', '2019-09-05 02:12:29');
INSERT INTO `112_considers` VALUES ('22', '16', '0', 'ลงนามก่อนวันที่ 23 มี.ค. 54', 'คำอธิบาย', '3', '1', null, null, '2019-09-05 02:12:45', '2019-09-05 02:12:45');
INSERT INTO `112_considers` VALUES ('23', '16', '0', 'ลงนามก่อนวันที่ 23 มี.ค. 54', 'คำอธิบาย', '3', '2', '11/09/2019', null, '2019-09-05 02:13:01', '2019-09-05 02:13:01');
INSERT INTO `112_considers` VALUES ('24', '16', '0', 'เป็นสัญญาจ้างก่อสร้าง 2', 'คำอธิบาย', '3', '3', '06/09/2019', '01/10/2019', '2019-09-05 02:13:21', '2019-09-05 02:13:21');

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
) ENGINE=InnoDB AUTO_INCREMENT=90 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of 12_refund_forms
-- ----------------------------
INSERT INTO `12_refund_forms` VALUES ('86', '1', '5', '0', '0', '2019-08-23 08:15:29', '2019-08-23 08:15:29');
INSERT INTO `12_refund_forms` VALUES ('87', '1', '6', '0', '0', '2019-09-02 02:47:28', '2019-09-02 02:47:28');
INSERT INTO `12_refund_forms` VALUES ('88', '1', '7', '0', '0', '2019-09-02 02:50:05', '2019-09-02 02:50:05');
INSERT INTO `12_refund_forms` VALUES ('89', '4', '8', '0', '0', '2019-09-09 02:27:23', '2019-09-09 02:27:23');

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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of 2_refunds
-- ----------------------------
INSERT INTO `2_refunds` VALUES ('1', '2', '123456', '2019-07-22', null, null, '1', '2019-07-22 01:57:24', '2019-07-22 01:57:24');
INSERT INTO `2_refunds` VALUES ('2', '2', '123456', '2019-07-22', null, null, '1', '2019-07-22 02:05:10', '2019-07-22 02:05:10');
INSERT INTO `2_refunds` VALUES ('3', '2', '123456', '2019-07-30', null, null, '1', '2019-07-30 02:28:14', '2019-07-30 02:28:14');
INSERT INTO `2_refunds` VALUES ('4', '2', '123456', '2019-08-13', null, null, '1', '2019-08-13 05:46:39', '2019-08-13 05:46:39');
INSERT INTO `2_refunds` VALUES ('5', '2', '123456', '2019-08-23', null, null, '1', '2019-08-23 08:15:28', '2019-08-23 08:15:28');
INSERT INTO `2_refunds` VALUES ('6', '2', '123456', '2019-09-02', null, null, '1', '2019-09-02 02:47:27', '2019-09-02 02:47:27');
INSERT INTO `2_refunds` VALUES ('7', '2', '123456', '2019-09-02', null, null, '1', '2019-09-02 02:50:04', '2019-09-02 02:50:04');
INSERT INTO `2_refunds` VALUES ('8', '2', '123456', '2019-09-09', null, null, '1', '2019-09-09 02:27:22', '2019-09-09 02:27:22');

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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of 9_forms
-- ----------------------------
INSERT INTO `9_forms` VALUES ('1', 'แบบการถอนคืนเงินรายได้แผ่นดิน ตามมติคณะรัฐมนตรีเมื่อวันที่ 24 เมษายน 2562', 'แจ้งตามหนังสือสำนักเลขาธิการคณะรัฐมนตรี ด่วนที่สุด ที่ นร 0505/ว 165 ลงวันที่ 26 เมษายน 2562', 'แบบถอนคืนตาม ว 165', '1', 'Songwut', '1', '2019-08-23 06:37:32', '2019-08-23 06:37:32');
INSERT INTO `9_forms` VALUES ('2', 'แบบการถอนคืนเงินรายได้แผ่นดิน ตามระเบียบสำนักนายกรัฐมนตรีว่าด้วยการพัสดุ พ.ศ. 2535 และที่แก้ไขเพิ่มเติม', 'หรือข้อบังคับ ข้อบัญญัติ ว่าด้วยการพัสดุของหน่วยงานนั้น ๆ', 'แบบถอนคืนตามระเบียบพัสดุ', '2', 'Songwut', '1', '2019-08-23 07:07:26', '2019-08-23 07:07:26');
INSERT INTO `9_forms` VALUES ('4', 'Form Test 1', 'Form Test 1', 'Form Test 1', '3', 'Songwut', '1', '2019-09-05 02:10:41', '2019-09-05 02:10:41');

-- ----------------------------
-- Table structure for `migrations`
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
INSERT INTO `migrations` VALUES ('49', '2019_07_15_024751_add_condition_to_rules_table', '15');
INSERT INTO `migrations` VALUES ('51', '2019_08_06_072551_create_considers_table', '16');
INSERT INTO `migrations` VALUES ('52', '2019_08_26_032504_add_description_on_considers_table', '17');

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
