-- --------------------------------------------------------
-- Host:                         localhost
-- Server version:               5.7.24 - MySQL Community Server (GPL)
-- Server OS:                    Win64
-- HeidiSQL Version:             10.2.0.5599
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for refund2
CREATE DATABASE IF NOT EXISTS `refund2` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `refund2`;

-- Dumping structure for table refund2.tmp_code
CREATE TABLE IF NOT EXISTS `tmp_code` (
  `id` int(11) DEFAULT NULL,
  `refund_id` int(11) DEFAULT NULL,
  `new_approve_code` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table refund2.tmp_code: ~0 rows (approximately)
/*!40000 ALTER TABLE `tmp_code` DISABLE KEYS */;
REPLACE INTO `tmp_code` (`id`, `refund_id`, `new_approve_code`) VALUES
	(2, 180, '63-0001\r'),
	(3, 181, '63-0002\r'),
	(4, 183, '63-0003\r'),
	(5, 196, '63-0004\r'),
	(7, 203, '63-0005\r'),
	(8, 208, '63-0006\r'),
	(9, 209, '63-0007\r'),
	(10, 210, '63-0008\r'),
	(11, 211, '63-0009\r'),
	(12, 205, '63-0010\r'),
	(13, 213, '63-0011\r'),
	(14, 214, '63-0012\r'),
	(15, 215, '63-0013\r'),
	(16, 216, '63-0014\r'),
	(17, 217, '63-0015\r'),
	(18, 220, '63-0016\r'),
	(19, 223, '63-0017\r'),
	(20, 225, '63-0018\r'),
	(21, 226, '63-0019\r'),
	(22, 231, '63-0020\r'),
	(23, 232, '63-0021\r'),
	(24, 233, '63-0022\r'),
	(25, 235, '63-0023\r'),
	(26, 236, '63-0024\r'),
	(27, 237, '63-0025\r'),
	(28, 238, '63-0026\r'),
	(29, 239, '63-0027\r'),
	(30, 240, '63-0028\r'),
	(31, 241, '63-0029\r'),
	(32, 242, '63-0030\r'),
	(33, 243, '63-0031\r'),
	(34, 244, '63-0032\r'),
	(35, 245, '63-0033\r'),
	(36, 246, '63-0034\r'),
	(37, 247, '63-0035\r'),
	(38, 212, '63-0036\r'),
	(39, 249, '63-0037\r'),
	(40, 248, '63-0038\r'),
	(41, 250, '63-0039\r'),
	(42, 252, '63-0040\r'),
	(43, 254, '64-0001\r'),
	(44, 255, '64-0002\r'),
	(45, 256, '64-0003\r'),
	(46, 257, '64-0004\r'),
	(47, 258, '64-0005\r'),
	(48, 259, '64-0006\r'),
	(49, 260, '64-0007\r'),
	(50, 261, '64-0008\r'),
	(51, 262, '64-0009\r'),
	(52, 264, '64-0010\r'),
	(53, 265, '64-0011\r'),
	(54, 266, '64-0012\r'),
	(55, 267, '64-0013\r'),
	(56, 268, '64-0014\r'),
	(57, 270, '64-0015\r'),
	(58, 269, '64-0016\r'),
	(59, 271, '64-0017\r'),
	(60, 272, '64-0018\r'),
	(61, 273, '64-0019\r'),
	(62, 274, '64-0020\r'),
	(63, 275, '64-0021\r'),
	(64, 276, '64-0022\r'),
	(65, 277, '64-0023\r'),
	(66, 279, '64-0024\r'),
	(67, 281, '64-0025\r'),
	(68, 282, '64-0026\r'),
	(69, 283, '64-0027\r'),
	(70, 284, '64-0028\r'),
	(71, 285, '64-0029\r'),
	(72, 293, '64-0030\r'),
	(73, 294, '64-0031\r'),
	(74, 295, '64-0032\r'),
	(75, 297, '64-0033\r'),
	(76, 299, '64-0034\r'),
	(77, 302, '64-0035\r'),
	(78, 300, '64-0036\r'),
	(79, 303, '64-0037\r'),
	(80, 298, '64-0038\r');
/*!40000 ALTER TABLE `tmp_code` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
