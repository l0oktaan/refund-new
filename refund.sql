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

-- Dumping data for table refund.10_form_rules: ~0 rows (approximately)
/*!40000 ALTER TABLE `10_form_rules` DISABLE KEYS */;
/*!40000 ALTER TABLE `10_form_rules` ENABLE KEYS */;

-- Dumping data for table refund.12_refund_forms: ~0 rows (approximately)
/*!40000 ALTER TABLE `12_refund_forms` DISABLE KEYS */;
/*!40000 ALTER TABLE `12_refund_forms` ENABLE KEYS */;

-- Dumping data for table refund.1_offices: ~2 rows (approximately)
/*!40000 ALTER TABLE `1_offices` DISABLE KEYS */;
INSERT INTO `1_offices` (`id`, `code`, `name`, `contact_name`, `phone`, `status`, `created_at`, `updated_at`) VALUES
	(1, '111111', 'กรมปศุสัตว์', 'ทรงวุฒิ สัจจบุตร', '0836360616', 1, '2019-03-06 08:49:13', '2019-03-06 08:49:13'),
	(2, '123456', 'กรมบัญชีกลาง์', 'Songwut Sajjaboot', '0836360616', 1, '2019-03-06 08:53:21', '2019-03-06 08:53:21'),
	(3, '222222', 'กรมบัญชีกลาง์', 'Songwut Sajjaboot', '0836360616', 1, '2019-03-06 08:53:37', '2019-03-06 08:53:37');
/*!40000 ALTER TABLE `1_offices` ENABLE KEYS */;

-- Dumping data for table refund.2_refunds: ~4 rows (approximately)
/*!40000 ALTER TABLE `2_refunds` DISABLE KEYS */;
INSERT INTO `2_refunds` (`id`, `office_id`, `approve_code`, `create_date`, `sent_date`, `complete_date`, `status`, `created_at`, `updated_at`) VALUES
	(1, 1, '123456', '2019-03-07', NULL, NULL, 1, '2019-03-07 02:41:44', '2019-03-07 02:41:44'),
	(2, 2, '123456', '2019-03-07', NULL, NULL, 1, '2019-03-07 02:53:20', '2019-03-07 02:53:20'),
	(3, 2, '123456', '2019-03-07', NULL, NULL, 1, '2019-03-07 02:58:13', '2019-03-07 02:58:13'),
	(4, 3, '123456', '2019-03-07', NULL, NULL, 1, '2019-03-07 02:58:24', '2019-03-07 02:58:24');
/*!40000 ALTER TABLE `2_refunds` ENABLE KEYS */;

-- Dumping data for table refund.3_contracts: ~2 rows (approximately)
/*!40000 ALTER TABLE `3_contracts` DISABLE KEYS */;
INSERT INTO `3_contracts` (`id`, `refund_id`, `contract_party`, `contract_no`, `contract_date`, `budget`, `penalty_per_day`, `contract_start`, `contract_end`, `created_at`, `updated_at`) VALUES
	(1, 1, 'ABC', '12/2562', '2019-03-11', 120000, 100.00, '2017-01-01', '2018-01-31', '2019-03-11 04:39:47', '2019-03-11 04:39:47'),
	(2, 2, 'XYZ', '12/2562', '2019-03-11', 120000, 100.00, '2017-01-01', '2018-01-31', '2019-03-12 03:01:43', '2019-03-12 03:01:43');
/*!40000 ALTER TABLE `3_contracts` ENABLE KEYS */;

-- Dumping data for table refund.4_contract_budget_edits: ~2 rows (approximately)
/*!40000 ALTER TABLE `4_contract_budget_edits` DISABLE KEYS */;
INSERT INTO `4_contract_budget_edits` (`id`, `refund_id`, `order`, `budget_new`, `penalty_new`, `contract_edit_date`, `created_at`, `updated_at`) VALUES
	(1, 1, 1, 100000000, 120.00, '2017-01-01', '2019-03-14 02:13:11', '2019-03-22 02:49:04'),
	(2, 1, 2, 10000, 120.00, '2017-01-01', '2019-03-14 03:18:34', '2019-03-14 03:18:34'),
	(3, 2, 1, 10000, 120.00, '2017-01-01', '2019-03-20 07:02:12', '2019-03-20 07:02:12');
/*!40000 ALTER TABLE `4_contract_budget_edits` ENABLE KEYS */;

-- Dumping data for table refund.5_contract_time_edits: ~4 rows (approximately)
/*!40000 ALTER TABLE `5_contract_time_edits` DISABLE KEYS */;
INSERT INTO `5_contract_time_edits` (`id`, `refund_id`, `order`, `approve_date`, `edit_type`, `edit_detail`, `edit_days`, `created_at`, `updated_at`) VALUES
	(1, 1, 1, '2019-01-01', '2', 'abcdef', 15, '2019-03-27 04:32:04', '2019-03-30 04:24:05'),
	(2, 1, 1, '2019-01-01', '2', 'abcdef', 15, '2019-03-27 04:33:13', '2019-03-30 04:24:21'),
	(3, 2, 1, '2019-01-01', '1', 'abcdef', 10, '2019-03-27 06:49:04', '2019-03-27 06:49:04'),
	(4, 2, 2, '2019-01-01', '1', 'abcdef', 10, '2019-03-27 06:49:49', '2019-03-27 06:49:49'),
	(5, 2, 1, '2019-01-01', '1', 'abcdef', 10, '2019-03-28 02:02:12', '2019-03-28 02:02:12');
/*!40000 ALTER TABLE `5_contract_time_edits` ENABLE KEYS */;

-- Dumping data for table refund.6_delivers: ~2 rows (approximately)
/*!40000 ALTER TABLE `6_delivers` DISABLE KEYS */;
INSERT INTO `6_delivers` (`id`, `refund_id`, `order`, `detail`, `overdue_days`, `deliver_date`, `penalty`, `created_at`, `updated_at`) VALUES
	(1, 1, 1, 'abcdef', 5, '2019-03-30', 1000.00, '2019-03-30 05:47:03', '2019-04-02 05:19:01'),
	(2, 1, 2, 'abcdef', 10, '2019-03-30', 1000.00, '2019-03-30 06:12:38', '2019-03-30 06:12:38'),
	(3, 2, 1, 'abcdef', 10, '2019-03-30', 1000.00, '2019-03-30 06:13:52', '2019-03-30 06:13:52');
/*!40000 ALTER TABLE `6_delivers` ENABLE KEYS */;

-- Dumping data for table refund.7_deposit_penalties: ~3 rows (approximately)
/*!40000 ALTER TABLE `7_deposit_penalties` DISABLE KEYS */;
INSERT INTO `7_deposit_penalties` (`id`, `refund_id`, `order`, `deposit_no`, `deposit_date`, `amount`, `created_at`, `updated_at`) VALUES
	(1, 1, 1, '1/2522', '2019-03-30', 10.00, '2019-04-02 08:18:24', '2019-04-02 08:21:25'),
	(2, 1, 2, '1/2522', '2019-03-30', 10.00, '2019-04-02 08:24:21', '2019-04-02 08:24:21'),
	(3, 2, 1, '1/2522', '2019-03-30', 10.00, '2019-04-02 08:24:48', '2019-04-02 08:24:48');
/*!40000 ALTER TABLE `7_deposit_penalties` ENABLE KEYS */;

-- Dumping data for table refund.8_approve_refunds: ~1 rows (approximately)
/*!40000 ALTER TABLE `8_approve_refunds` DISABLE KEYS */;
INSERT INTO `8_approve_refunds` (`id`, `refund_id`, `receive_refund_date`, `approve_refund_days`, `approve_refund_amount`, `amount`, `created_at`, `updated_at`) VALUES
	(1, 1, '2019-01-31', 30, 20.20, 200.20, '2019-04-02 09:02:41', '2019-04-02 09:33:10');
/*!40000 ALTER TABLE `8_approve_refunds` ENABLE KEYS */;

-- Dumping data for table refund.9_forms: ~0 rows (approximately)
/*!40000 ALTER TABLE `9_forms` DISABLE KEYS */;
/*!40000 ALTER TABLE `9_forms` ENABLE KEYS */;

-- Dumping data for table refund.form_conditions: ~0 rows (approximately)
/*!40000 ALTER TABLE `form_conditions` DISABLE KEYS */;
/*!40000 ALTER TABLE `form_conditions` ENABLE KEYS */;

-- Dumping data for table refund.migrations: ~21 rows (approximately)
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
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
	(42, '2019_04_03_071418_create_form_conditions_table', 11);
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
