-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.3.13-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             9.5.0.5196
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping data for table refund.10_form_rules: ~16 rows (approximately)
/*!40000 ALTER TABLE `10_form_rules` DISABLE KEYS */;
REPLACE INTO `10_form_rules` (`id`, `form_id`, `order`, `name`, `sub_of`, `rule_type`, `result_type`, `condition`, `condition_type`, `description`, `status`, `created_at`, `updated_at`) VALUES
	(1, 1, 1, 'เป็นการให้ความช่วยเหลือผู้ประกอบการก่อสร้างในภาคใต้ที่ได้รับผลกระทบทางอ้อมจากเหตุอุทกภัยที่เกิดขึ้นในช่วงตั้งแต่วันที่ 1 ธ.ค. 59 ถึงวันที่ 12 ก.พ. 60', 0, 1, 0, NULL, 0, NULL, 0, '2019-08-23 06:39:07', '2019-08-23 06:39:07'),
	(2, 1, 2, 'อยู่ในพื้นที่ภาคใต้ 1 จังหวัด ได้แก่ สตูล', 0, 1, 0, NULL, 0, NULL, 0, '2019-08-23 06:40:59', '2019-08-23 06:40:59'),
	(3, 1, 3, 'สัญญาที่จะได้รับความช่วยเหลือ', 0, 1, 1, NULL, 0, NULL, 0, '2019-08-23 06:41:41', '2019-08-23 06:46:17'),
	(4, 1, 1, '(ก.) ลงนามก่อน 1 ธ.ค. 59', 3, 2, 0, NULL, 0, NULL, 0, '2019-08-23 06:42:20', '2019-08-23 06:42:20'),
	(5, 1, 2, '(ข.) ลงนามระหว่าง 1 ธ.ค. 59 - 12 ก.พ. 60', 3, 2, 0, NULL, 0, NULL, 0, '2019-08-23 06:46:39', '2019-08-23 06:46:39'),
	(6, 1, 4, 'เป็นสัญญาตาม (ก.) หรือ (ข.) ที่', 0, 1, 1, NULL, 0, NULL, 0, '2019-08-23 06:48:49', '2019-08-23 06:51:29'),
	(7, 1, 1, 'ณ วันที่ 1 ธ.ค. 59 - 12 ก.พ. 60 ยังมีนิติสัมพันธ์อยู่ และยังไม่ส่งมอบงานงวดสุดท้าย', 6, 2, 0, NULL, 0, NULL, 0, '2019-08-23 06:50:09', '2019-08-23 06:50:09'),
	(8, 1, 2, 'เป็นสัญญาตาม (ก.) หรือ (ข.) ยังมีนิติสัมพันธ์อยู่ แต่ส่งงานงวดสุดท้ายระหว่าง 1 ธ.ค. 59 - 12 ก.พ. 60', 6, 2, 0, NULL, 0, NULL, 0, '2019-08-23 06:52:15', '2019-08-23 06:52:15'),
	(9, 1, 5, 'การขยายเวลา งด/ลดค่าปรับ', 0, 1, 0, NULL, 0, NULL, 0, '2019-08-23 06:52:47', '2019-08-23 06:52:47'),
	(10, 1, 6, 'ผู้ประกอบการต้องยื่นคำขอต่อหน่วยงานภายใน 60 วัน นับถัดจากวันที่คณะรัฐมนตรีมีมติ', 0, 1, 0, NULL, 0, NULL, 0, '2019-08-23 06:57:13', '2019-08-23 06:57:13'),
	(11, 2, 1, 'เป็นไปตามระเบียบ ข้อบังคับ หรือข้อบัญญัติ ว่าด้วยการพัสดุของหน่วยงานนั้น ๆ', 0, 1, 0, NULL, 0, NULL, 0, '2019-08-23 07:07:57', '2019-08-23 07:07:57'),
	(12, 2, 2, 'เข้าตามกรณี', 0, 1, 1, NULL, 0, NULL, 0, '2019-08-23 07:08:28', '2019-08-23 07:09:16'),
	(13, 2, 1, '(1) เหตุเกิดจากความผิดหรือความบกพร่องของส่วนราชการ', 12, 2, 0, NULL, 0, NULL, 0, '2019-08-23 07:08:59', '2019-08-23 07:08:59'),
	(14, 2, 2, '(2) เหตุสุดวิสัย', 12, 2, 0, NULL, 0, NULL, 0, '2019-08-23 07:09:28', '2019-08-23 07:09:28'),
	(16, 4, 1, 'เป็นสัญญาจ้างก่อสร้าง', 0, 1, 0, NULL, 0, NULL, 0, '2019-09-05 02:11:24', '2019-09-05 02:11:24'),
	(17, 4, 2, 'Rule 3', 0, 1, 0, NULL, 0, NULL, 0, '2019-09-05 02:16:15', '2019-09-05 02:17:21'),
	(18, 5, 1, 'เป็นสัญญาจ้างก่อสร้าง', 0, 1, 0, NULL, 0, NULL, 0, '2019-10-30 07:56:27', '2019-10-30 07:56:27');
/*!40000 ALTER TABLE `10_form_rules` ENABLE KEYS */;

-- Dumping data for table refund.112_considers: ~16 rows (approximately)
/*!40000 ALTER TABLE `112_considers` DISABLE KEYS */;
REPLACE INTO `112_considers` (`id`, `form_rule_id`, `order`, `name`, `description`, `type`, `oper`, `var1`, `var2`, `created_at`, `updated_at`) VALUES
	(1, 1, 0, 'เป็นงานก่อสร้าง', 'คำอธิบายงานก่อสร้าง', 1, '0', NULL, NULL, '2019-08-23 06:39:24', '2019-08-26 03:48:09'),
	(2, 2, 0, 'อยู่ในจังหวัดสตูล', 'คำอธิบาย', 1, '0', NULL, NULL, '2019-08-23 06:41:11', '2019-08-23 06:41:11'),
	(3, 4, 0, 'ลงนามก่อน 1 ธ.ค. 59', NULL, 1, '2', '30/11/2016', NULL, '2019-08-23 06:45:55', '2019-09-10 06:34:22'),
	(4, 5, 0, 'ลงนามระหว่าง 1 ธ.ค. 59 - 12 ก.พ. 60', NULL, 1, '2', '12/02/2017', NULL, '2019-08-23 06:48:05', '2019-09-10 06:34:55'),
	(5, 7, 0, 'ณ วันที่ 1 ธ.ค. 59 - 12 ก.พ. 60 ยังมีนิติสัมพันธ์อยู่ และยังไม่ส่งมอบงานงวดสุดท้าย', 'คำอธิบาย', 1, '0', NULL, NULL, '2019-08-23 06:51:18', '2019-08-23 06:51:18'),
	(6, 8, 0, 'เป็นสัญญาตาม (ก.) หรือ (ข.) ยังมีนิติสัมพันธ์อยู่ แต่ส่งงานงวดสุดท้ายระหว่าง 1 ธ.ค. 59 - 12 ก.พ. 60', NULL, 1, '0', NULL, NULL, '2019-08-23 06:52:25', '2019-08-23 06:52:25'),
	(7, 9, 0, 'ขยาย งดหรือลด จำนวน (วัน)', NULL, 2, '0', NULL, NULL, '2019-08-23 06:53:47', '2019-08-23 06:53:47'),
	(8, 9, 0, 'ถึงวันที่', NULL, 2, '0', NULL, NULL, '2019-08-23 06:54:10', '2019-08-23 06:54:10'),
	(9, 10, 0, 'ยื่นคำขอภายในวันที่ 23 มิ.ย. 62', NULL, 1, '0', NULL, NULL, '2019-08-23 06:57:53', '2019-08-23 06:57:53'),
	(10, 10, 0, 'หน่วยงานรับหนังสือขอรับความช่วยเหลือเมื่อวันที่', NULL, 3, '2', '23/06/2017', NULL, '2019-08-23 07:02:57', '2019-08-23 07:02:57'),
	(11, 11, 0, 'เป็นไปตามระเบียบ ข้อ', NULL, 2, '0', NULL, NULL, '2019-08-23 07:08:12', '2019-08-23 07:08:12'),
	(12, 13, 0, 'ให้ตาม (1)', NULL, 1, '0', NULL, NULL, '2019-08-23 07:09:07', '2019-08-23 07:09:07'),
	(13, 14, 0, 'ให้ตาม (2)', NULL, 1, '0', NULL, NULL, '2019-08-23 07:09:44', '2019-08-23 07:09:44'),
	(25, 17, 0, 'Rule 3', 'คำอธิบาย', 1, '0', NULL, NULL, '2019-09-09 09:35:23', '2019-09-09 09:35:23'),
	(40, 16, 0, 'ลงนามก่อนวันที่ 23 มี.ค. 54', 'คำอธิบาย', 3, '2', '2019-10-01', '2019-10-31', '2019-10-30 07:36:47', '2019-10-30 08:01:06'),
	(42, 16, 0, 'ลงนามระหว่าง 1 ธ.ค. 59 - 12 ก.พ. 60', 'คำอธิบาย', 3, '3', '2019-10-01', '2019-10-31', '2019-10-30 07:37:36', '2019-10-30 07:37:36'),
	(43, 18, 0, 'เป็นสัญญาจ้างก่อสร้าง', 'คำอธิบาย', 3, '2', '2019-10-01', NULL, '2019-10-30 07:56:44', '2019-10-30 07:56:44');
/*!40000 ALTER TABLE `112_considers` ENABLE KEYS */;

-- Dumping data for table refund.11_form_conditions: ~0 rows (approximately)
/*!40000 ALTER TABLE `11_form_conditions` DISABLE KEYS */;
/*!40000 ALTER TABLE `11_form_conditions` ENABLE KEYS */;

-- Dumping data for table refund.12_refund_forms: ~8 rows (approximately)
/*!40000 ALTER TABLE `12_refund_forms` DISABLE KEYS */;
REPLACE INTO `12_refund_forms` (`id`, `form_id`, `refund_id`, `result`, `status`, `created_at`, `updated_at`) VALUES
	(90, 1, 9, 0, 0, '2019-09-10 08:08:36', '2019-09-10 08:08:36'),
	(91, 1, 10, 0, 0, '2019-09-10 08:09:12', '2019-09-10 08:09:12'),
	(92, 2, 10, 0, 0, '2019-09-10 08:09:12', '2019-09-10 08:09:12'),
	(93, 1, 11, 0, 0, '2019-09-12 07:41:01', '2019-09-12 07:41:01'),
	(94, 1, 12, 0, 0, '2019-09-12 07:55:01', '2019-09-12 07:55:01'),
	(95, 1, 13, 0, 0, '2019-10-28 03:50:37', '2019-10-28 03:50:37'),
	(96, 4, 14, 0, 0, '2019-10-30 08:22:23', '2019-10-30 08:22:23'),
	(97, 4, 15, 0, 0, '2019-11-14 09:31:15', '2019-11-14 09:31:15'),
	(98, 1, 16, 0, 0, '2019-11-14 09:31:54', '2019-11-14 09:31:54');
/*!40000 ALTER TABLE `12_refund_forms` ENABLE KEYS */;

-- Dumping data for table refund.13_refund_details: ~0 rows (approximately)
/*!40000 ALTER TABLE `13_refund_details` DISABLE KEYS */;
/*!40000 ALTER TABLE `13_refund_details` ENABLE KEYS */;

-- Dumping data for table refund.1_offices: ~2 rows (approximately)
/*!40000 ALTER TABLE `1_offices` DISABLE KEYS */;
REPLACE INTO `1_offices` (`id`, `code`, `name`, `contact_name`, `phone`, `status`, `created_at`, `updated_at`) VALUES
	(1, '111111', 'กรมปศุสัตว์', 'ทรงวุฒิ สัจจบุตร', '0836360616', 1, '2019-03-06 08:49:13', '2019-03-06 08:49:13'),
	(2, '123456', 'กรมบัญชีกลาง์', 'Songwut Sajjaboot', '0836360616', 1, '2019-03-06 08:53:21', '2019-03-06 08:53:21'),
	(3, '222222', 'กรมบัญชีกลาง์', 'Songwut Sajjaboot', '0836360616', 1, '2019-03-06 08:53:37', '2019-03-06 08:53:37');
/*!40000 ALTER TABLE `1_offices` ENABLE KEYS */;

-- Dumping data for table refund.2_refunds: ~8 rows (approximately)
/*!40000 ALTER TABLE `2_refunds` DISABLE KEYS */;
REPLACE INTO `2_refunds` (`id`, `office_id`, `approve_code`, `create_date`, `sent_date`, `complete_date`, `status`, `created_at`, `updated_at`) VALUES
	(9, 2, '123456', '2019-09-10', NULL, NULL, 1, '2019-09-10 08:08:35', '2019-09-10 08:08:35'),
	(10, 2, '123456', '2019-09-10', NULL, NULL, 1, '2019-09-10 08:09:12', '2019-09-10 08:09:12'),
	(11, 2, '123456', '2019-09-12', NULL, NULL, 1, '2019-09-12 07:41:01', '2019-09-12 07:41:01'),
	(12, 2, '123456', '2019-09-12', NULL, NULL, 1, '2019-09-12 07:55:01', '2019-09-12 07:55:01'),
	(13, 2, '123456', '2019-10-28', NULL, NULL, 1, '2019-10-28 03:50:37', '2019-10-28 03:50:37'),
	(14, 2, '123456', '2019-10-30', NULL, NULL, 1, '2019-10-30 08:22:22', '2019-10-30 08:22:22'),
	(15, 2, '123456', '2019-11-14', NULL, NULL, 1, '2019-11-14 09:31:14', '2019-11-14 09:31:14'),
	(16, 2, '123456', '2019-11-14', NULL, NULL, 1, '2019-11-14 09:31:54', '2019-11-14 09:31:54');
/*!40000 ALTER TABLE `2_refunds` ENABLE KEYS */;

-- Dumping data for table refund.3_contracts: ~2 rows (approximately)
/*!40000 ALTER TABLE `3_contracts` DISABLE KEYS */;
REPLACE INTO `3_contracts` (`id`, `refund_id`, `contract_party`, `contract_no`, `contract_date`, `budget`, `penalty_per_day`, `contract_start`, `contract_end`, `created_at`, `updated_at`) VALUES
	(19, 14, 'บริษัท มาสเตอ เมกเคอ จำกัด', '16/2556', '2019-11-06', 111111.00, 1000.01, '2019-11-02', '2019-11-30', '2019-11-05 09:30:59', '2019-11-19 08:40:12'),
	(21, 15, 'บริษัท มาสเตอ เมกเคอ จำกัด', '16/2556', '2019-11-18', 12212121.00, 1212.00, '2019-11-01', '2019-11-30', '2019-11-18 04:57:13', '2019-11-18 04:57:13');
/*!40000 ALTER TABLE `3_contracts` ENABLE KEYS */;

-- Dumping data for table refund.4_contract_budget_edits: ~5 rows (approximately)
/*!40000 ALTER TABLE `4_contract_budget_edits` DISABLE KEYS */;
REPLACE INTO `4_contract_budget_edits` (`id`, `refund_id`, `order`, `budget_new`, `penalty_new`, `contract_edit_date`, `created_at`, `updated_at`) VALUES
	(9, 14, NULL, 10000000.00, 111111.00, '2019-11-02', '2019-11-14 09:17:58', '2019-11-19 08:23:08'),
	(11, 14, NULL, 10000.00, 11.00, '2019-12-01', '2019-11-18 04:44:50', '2019-11-19 03:53:34'),
	(13, 14, NULL, 12121212.00, 120.00, '2019-11-20', '2019-11-19 04:45:29', '2019-11-19 04:45:29'),
	(14, 14, NULL, 1000.00, 120.00, '2019-11-19', '2019-11-19 08:24:23', '2019-11-19 08:27:22'),
	(15, 14, NULL, 12121212.00, 11.00, '2019-11-21', '2019-11-21 04:11:55', '2019-11-21 04:11:55');
/*!40000 ALTER TABLE `4_contract_budget_edits` ENABLE KEYS */;

-- Dumping data for table refund.5_contract_time_edits: ~3 rows (approximately)
/*!40000 ALTER TABLE `5_contract_time_edits` DISABLE KEYS */;
REPLACE INTO `5_contract_time_edits` (`id`, `refund_id`, `approve_date`, `edit_type`, `edit_detail`, `edit_days`, `edit_budget`, `contract_end_date`, `approve_type`, `approve_case`, `problem_end_date`, `book_date`, `created_at`, `updated_at`) VALUES
	(10, 14, '2019-10-02', '1', '111', 1, 2000.00, '2019-11-30', '1', '1', '2019-09-28', '2019-09-29', '2019-11-21 04:40:40', '2019-11-21 05:04:52'),
	(18, 14, '2019-11-01', '3', '-', 11, 1334.00, '2019-11-02', '4', 'dsfgdsfgdfg', '2019-11-03', '2019-11-04', '2019-11-21 05:01:52', '2019-11-21 05:04:30'),
	(19, 14, '2019-11-30', '3', '-', 11, 30000.00, '2015-11-30', '3', '1', '2019-11-21', '2019-11-30', '2019-11-21 05:14:04', '2019-11-21 05:14:04');
/*!40000 ALTER TABLE `5_contract_time_edits` ENABLE KEYS */;

-- Dumping data for table refund.6_delivers: ~3 rows (approximately)
/*!40000 ALTER TABLE `6_delivers` DISABLE KEYS */;
REPLACE INTO `6_delivers` (`id`, `refund_id`, `delivery`, `detail`, `overdue_days`, `deliver_date`, `penalty`, `created_at`, `updated_at`) VALUES
	(5, 14, 'งวดที่ 1/ครั้งที่ 2', 'abcdef', 10, '2019-03-30', 100000.00, '2019-11-21 07:49:16', '2019-11-21 11:05:06'),
	(6, 14, 'งวดที่ 3/ครั้งที่ 3', 'abcdef', 444, '2019-11-21', 1000000.00, '2019-11-21 10:58:59', '2019-11-21 12:20:33'),
	(8, 14, 'งวดที่ 2/ครั้งที่ 2', 'abcdef', 10, '2019-03-30', 1000.00, '2019-11-21 12:17:58', '2019-11-21 12:17:58');
/*!40000 ALTER TABLE `6_delivers` ENABLE KEYS */;

-- Dumping data for table refund.7_deposit_penalties: ~5 rows (approximately)
/*!40000 ALTER TABLE `7_deposit_penalties` DISABLE KEYS */;
REPLACE INTO `7_deposit_penalties` (`id`, `refund_id`, `deposit_no`, `deposit_date`, `amount`, `created_at`, `updated_at`) VALUES
	(5, 14, '1/2522', '2020-03-30', 10.00, '2019-11-21 13:23:55', '2019-11-22 09:43:42'),
	(6, 14, '1/2522', '2019-03-30', 10.00, '2019-11-22 09:08:02', '2019-11-22 09:08:02'),
	(7, 14, '1/2522', '2019-03-30', 10.00, '2019-11-22 09:16:39', '2019-11-22 09:16:39'),
	(9, 14, '1/2522', '2020-11-30', 10.00, '2019-11-22 09:43:29', '2019-11-22 09:43:29'),
	(10, 14, '111/2522', '2015-11-02', 11.00, '2019-11-22 09:45:54', '2019-11-22 09:45:54');
/*!40000 ALTER TABLE `7_deposit_penalties` ENABLE KEYS */;

-- Dumping data for table refund.8_approve_refunds: ~0 rows (approximately)
/*!40000 ALTER TABLE `8_approve_refunds` DISABLE KEYS */;
REPLACE INTO `8_approve_refunds` (`id`, `refund_id`, `receive_date`, `refund_days`, `refund_amount`, `approve_amount`, `created_at`, `updated_at`) VALUES
	(5, 14, '2019-11-23', 3, 3000000.00, 3000000.00, '2019-11-22 11:41:25', '2019-11-22 11:52:12');
/*!40000 ALTER TABLE `8_approve_refunds` ENABLE KEYS */;

-- Dumping data for table refund.9_forms: ~3 rows (approximately)
/*!40000 ALTER TABLE `9_forms` DISABLE KEYS */;
REPLACE INTO `9_forms` (`id`, `name1`, `name2`, `name3`, `order`, `create_by`, `status`, `created_at`, `updated_at`) VALUES
	(1, 'แบบการถอนคืนเงินรายได้แผ่นดิน ตามมติคณะรัฐมนตรีเมื่อวันที่ 24 เมษายน 2562', 'แจ้งตามหนังสือสำนักเลขาธิการคณะรัฐมนตรี ด่วนที่สุด ที่ นร 0505/ว 165 ลงวันที่ 26 เมษายน 2562', 'แบบถอนคืนตาม ว 165', 1, 'Songwut', 1, '2019-08-23 06:37:32', '2019-08-23 06:37:32'),
	(2, 'แบบการถอนคืนเงินรายได้แผ่นดิน ตามระเบียบสำนักนายกรัฐมนตรีว่าด้วยการพัสดุ พ.ศ. 2535 และที่แก้ไขเพิ่มเติม', 'หรือข้อบังคับ ข้อบัญญัติ ว่าด้วยการพัสดุของหน่วยงานนั้น ๆ', 'แบบถอนคืนตามระเบียบพัสดุ', 2, 'Songwut', 1, '2019-08-23 07:07:26', '2019-08-23 07:07:26'),
	(4, 'Form Test 1', 'Form Test 1', 'Form Test 1', 3, 'Songwut', 1, '2019-09-05 02:10:41', '2019-09-05 02:10:41'),
	(5, 'ฟอร์ม หมายเลข 4', 'ฟอร์ม หมายเลข 4', 'ฟอร์ม หมายเลข 4', 4, 'Songwut', 1, '2019-10-30 07:56:12', '2019-10-30 07:56:12');
/*!40000 ALTER TABLE `9_forms` ENABLE KEYS */;

-- Dumping data for table refund.migrations: ~31 rows (approximately)
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
REPLACE INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '2014_10_12_000000_create_users_table', 1),
	(2, '2014_10_12_100000_create_password_resets_table', 1),
	(23, '2019_02_26_065640_create_offices_table', 2),
	(24, '2019_02_26_065741_create_refunds_table', 3),
	(25, '2019_02_26_071313_create_contracts_table', 3),
	(26, '2019_02_26_072926_create_contract_budget_edits_table', 3),
	(27, '2019_02_26_073325_create_contract_time_edits_table', 3),
	(28, '2019_02_28_060828_create_delivers_table', 3),
	(29, '2019_02_28_061714_create_deposit_penalties_table', 3),
	(30, '2019_03_01_041558_create_approve_refunds_table', 3),
	(31, '2019_03_27_041248_add_order_to_time_edit_table', 4),
	(32, '2019_03_27_042522_modify_edit_day_to_time_edit_table', 5),
	(33, '2019_03_30_053231_modify_delivers_table', 6),
	(34, '2019_03_30_054258_modify_delivers_table', 7),
	(35, '2019_03_30_054609_modify_delivers_table', 8),
	(37, '2019_04_02_042952_desposit_penalty_rename_desposit_date', 9),
	(38, '2019_04_02_090037_rename_aprrove_refund_day_to_days', 10),
	(39, '2019_04_03_065038_create_forms_table', 11),
	(40, '2019_04_03_070239_create_refund_forms_table', 11),
	(41, '2019_04_03_070715_create_form_rules_table', 11),
	(44, '2019_04_03_071418_create_form_conditions_table', 12),
	(45, '2019_05_09_081408_add__column_order_in_form_table', 13),
	(46, '2019_05_28_034811_create_refund_details_table', 14),
	(49, '2019_07_15_024751_add_condition_to_rules_table', 15),
	(51, '2019_08_06_072551_create_considers_table', 16),
	(52, '2019_08_26_032504_add_description_on_considers_table', 17),
	(53, '2019_09_12_034811_create_refund_details_table', 18),
	(54, '2019_11_14_091048_modify_contract_budget_edit', 19),
	(55, '2019_11_19_081214_modify_3_contracts_float_to_decimal', 20),
	(58, '2019_11_20_013925_modify_contract_time_edit_add_column', 21),
	(61, '2019_11_21_070101_modify_delivers', 22),
	(62, '2019_11_22_111718_modify_approve_table_refund_id_set_unique', 23);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;

-- Dumping data for table refund.password_resets: ~0 rows (approximately)
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;

-- Dumping data for table refund.users: ~0 rows (approximately)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
