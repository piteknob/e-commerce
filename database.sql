-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Waktu pembuatan: 17 Okt 2024 pada 09.56
-- Versi server: 8.3.0
-- Versi PHP: 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `griya-bakpia`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `auth_user`
--

DROP TABLE IF EXISTS `auth_user`;
CREATE TABLE IF NOT EXISTS `auth_user` (
  `auth_user_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `auth_user_user_id` int UNSIGNED NOT NULL,
  `auth_user_username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `auth_user_token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `auth_user_date_login` datetime DEFAULT NULL,
  `auth_user_date_expired` datetime DEFAULT NULL,
  PRIMARY KEY (`auth_user_id`),
  KEY `FK_auth_user_user` (`auth_user_user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `auth_user`
--

INSERT INTO `auth_user` (`auth_user_id`, `auth_user_user_id`, `auth_user_username`, `auth_user_token`, `auth_user_date_login`, `auth_user_date_expired`) VALUES
(6, 1, 'bakpia', 'YmFrcGlhMTIzNDU2', '2024-10-17 15:12:51', '2024-10-18 15:12:51'),
(8, 24, 'bakpia211', 'YmFrcGlhMjExMTIzNDU2', '2024-10-16 14:51:24', '2024-10-17 14:51:24');

-- --------------------------------------------------------

--
-- Struktur dari tabel `bank`
--

DROP TABLE IF EXISTS `bank`;
CREATE TABLE IF NOT EXISTS `bank` (
  `bank_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `bank_name` varchar(50) NOT NULL,
  `bank_account_name` varchar(50) NOT NULL,
  `bank_account_number` varchar(20) NOT NULL,
  `bank_code` varchar(10) NOT NULL,
  `bank_created_at` datetime DEFAULT NULL,
  `bank_updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`bank_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `bank`
--

INSERT INTO `bank` (`bank_id`, `bank_name`, `bank_account_name`, `bank_account_number`, `bank_code`, `bank_created_at`, `bank_updated_at`) VALUES
(1, 'BCA', 'pitek', '6913812381', '014', '2024-10-17 04:33:44', NULL),
(3, 'BBRI', 'pitek', '69138123811', '021', '2024-10-17 07:35:08', NULL),
(4, 'NIAGA', 'pitek', '123124', '011', '2024-10-17 07:35:36', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `category`
--

DROP TABLE IF EXISTS `category`;
CREATE TABLE IF NOT EXISTS `category` (
  `category_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `category_name` varchar(255) NOT NULL,
  `category_created_at` datetime DEFAULT NULL,
  `category_updated_at` datetime DEFAULT NULL,
  `category_deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `category`
--

INSERT INTO `category` (`category_id`, `category_name`, `category_created_at`, `category_updated_at`, `category_deleted_at`) VALUES
(1, 'Basah', '2024-08-02 06:58:12', NULL, NULL),
(8, 'kering', '2024-09-06 10:20:17', NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `customer`
--

DROP TABLE IF EXISTS `customer`;
CREATE TABLE IF NOT EXISTS `customer` (
  `customer_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `customer_name` varchar(255) NOT NULL,
  `customer_address` varchar(255) NOT NULL,
  `customer_no_handphone` varchar(21) NOT NULL,
  PRIMARY KEY (`customer_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `customer`
--

INSERT INTO `customer` (`customer_id`, `customer_name`, `customer_address`, `customer_no_handphone`) VALUES
(1, 'noob', 'jkt', '0123313213');

-- --------------------------------------------------------

--
-- Struktur dari tabel `log_stock`
--

DROP TABLE IF EXISTS `log_stock`;
CREATE TABLE IF NOT EXISTS `log_stock` (
  `log_stock_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `log_stock_product_id` int UNSIGNED NOT NULL,
  `log_stock_variant_id` int UNSIGNED NOT NULL,
  `log_stock_category_id` int UNSIGNED NOT NULL,
  `log_stock_status` enum('add','reduce','sold','') NOT NULL,
  `log_stock_quantity` int NOT NULL,
  `log_stock_date` datetime NOT NULL,
  PRIMARY KEY (`log_stock_id`),
  KEY `fk_log_stock_product` (`log_stock_product_id`),
  KEY `fk_log_stock_variant` (`log_stock_variant_id`),
  KEY `fk_log_stock_category` (`log_stock_category_id`)
) ENGINE=MyISAM AUTO_INCREMENT=118 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `log_stock`
--

INSERT INTO `log_stock` (`log_stock_id`, `log_stock_product_id`, `log_stock_variant_id`, `log_stock_category_id`, `log_stock_status`, `log_stock_quantity`, `log_stock_date`) VALUES
(91, 31, 20, 1, 'sold', 5, '2024-08-23 10:42:42'),
(92, 35, 24, 1, 'sold', 5, '2024-08-23 10:42:42'),
(93, 36, 25, 1, 'sold', 5, '2024-08-23 10:42:42'),
(94, 39, 28, 1, 'sold', 5, '2024-08-23 10:42:42'),
(95, 31, 20, 1, 'sold', 5, '2024-08-23 13:37:48'),
(96, 35, 24, 1, 'sold', 5, '2024-08-23 13:37:48'),
(97, 36, 25, 1, 'sold', 5, '2024-08-23 13:37:48'),
(98, 39, 28, 1, 'sold', 5, '2024-08-23 13:37:48'),
(99, 139, 131, 1, 'sold', 5, '2024-10-09 11:07:35'),
(100, 140, 132, 1, 'sold', 5, '2024-10-09 11:07:35'),
(101, 139, 131, 1, 'sold', 5, '2024-10-09 14:12:22'),
(102, 140, 132, 1, 'sold', 5, '2024-10-09 14:12:22'),
(103, 160, 159, 8, 'reduce', 5, '2024-10-11 16:02:48'),
(104, 160, 159, 8, 'reduce', 5, '2024-10-11 16:04:44'),
(105, 160, 159, 8, 'reduce', 5, '2024-10-11 16:04:47'),
(106, 160, 159, 8, 'reduce', 5, '2024-10-11 16:05:17'),
(107, 160, 159, 8, 'reduce', 5, '2024-10-11 16:05:43'),
(108, 160, 159, 8, 'reduce', 5, '2024-10-11 16:05:57'),
(109, 160, 159, 8, 'reduce', 5, '2024-10-11 16:06:06'),
(110, 160, 159, 8, 'reduce', 5, '2024-10-11 16:06:44'),
(111, 160, 159, 8, 'reduce', 5, '2024-10-11 16:06:54'),
(112, 160, 159, 8, 'reduce', 5, '2024-10-11 16:07:16'),
(113, 160, 159, 8, 'add', 5, '2024-10-11 16:15:08'),
(114, 160, 159, 8, 'add', 5, '2024-10-11 16:15:45'),
(115, 160, 159, 8, 'sold', 5, '2024-10-17 10:10:45'),
(116, 160, 159, 8, 'sold', 5, '2024-10-17 10:11:11'),
(117, 160, 159, 8, 'sold', 5, '2024-10-17 10:11:48');

-- --------------------------------------------------------

--
-- Struktur dari tabel `outlet`
--

DROP TABLE IF EXISTS `outlet`;
CREATE TABLE IF NOT EXISTS `outlet` (
  `outlet_id` int NOT NULL AUTO_INCREMENT,
  `outlet_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `outlet_address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `outlet_photo` varchar(255) NOT NULL,
  `outlet_link` varchar(255) NOT NULL,
  `outlet_created_at` datetime DEFAULT NULL,
  `outlet_updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`outlet_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `outlet`
--

INSERT INTO `outlet` (`outlet_id`, `outlet_title`, `outlet_address`, `outlet_photo`, `outlet_link`, `outlet_created_at`, `outlet_updated_at`) VALUES
(3, 'tes', 'tes', 'tes_1726040201.png', 'tes', '2024-09-11 14:13:13', NULL),
(4, 'tes', 'tes', 'tes_1726118062.png', 'tes', '2024-09-11 14:17:28', '2024-09-12 11:42:28');

-- --------------------------------------------------------

--
-- Struktur dari tabel `product`
--

DROP TABLE IF EXISTS `product`;
CREATE TABLE IF NOT EXISTS `product` (
  `product_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `product_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `product_price` int NOT NULL,
  `product_category_id` int UNSIGNED NOT NULL,
  `product_category_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `product_variant_id` int UNSIGNED NOT NULL,
  `product_variant_name` varchar(50) NOT NULL,
  `product_description` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `product_photo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `product_created_at` datetime DEFAULT NULL,
  `product_updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`product_id`),
  KEY `fk_product_category` (`product_category_id`),
  KEY `fk_product_variant` (`product_variant_id`)
) ENGINE=MyISAM AUTO_INCREMENT=167 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `product`
--

INSERT INTO `product` (`product_id`, `product_name`, `product_price`, `product_category_id`, `product_category_name`, `product_variant_id`, `product_variant_name`, `product_description`, `product_photo`, `product_created_at`, `product_updated_at`) VALUES
(160, 'Bakpia 465 Kering 20', 24000, 8, 'kering', 159, 'test', '', 'bakpia_465_kering_20_1728629676.png', '2024-10-11 13:51:53', NULL),
(161, 'Bakpia 465 Kering 20', 24000, 8, 'kering', 159, 'test', '', 'bakpia_465_kering_20_1728630700.png', '2024-10-11 13:51:55', NULL),
(162, 'Premium', 24000, 8, 'kering', 159, 'test', '', 'premium_1728637680.png', '2024-10-11 15:13:35', NULL),
(163, 'Premium', 24000, 8, 'kering', 159, 'test', '', 'premium_1728634669.png', '2024-10-11 15:13:37', NULL),
(164, 'Premium', 24000, 8, 'kering', 159, 'test', '', 'premium_1728635471.png', '2024-10-11 15:13:38', NULL),
(165, 'Test', 24000, 1, 'Basah', 159, 'test', '', 'test_1728635134.png', '2024-10-11 15:14:08', NULL),
(166, 'Test', 24000, 1, 'Basah', 159, 'test', '', 'test_1728636057.png', '2024-10-11 15:14:09', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `product_stock`
--

DROP TABLE IF EXISTS `product_stock`;
CREATE TABLE IF NOT EXISTS `product_stock` (
  `product_stock_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `product_stock_product_id` int UNSIGNED NOT NULL,
  `product_stock_variant_id` int UNSIGNED NOT NULL,
  `product_stock_category_id` int UNSIGNED NOT NULL,
  `product_stock_stock` int NOT NULL,
  `product_stock_in` int NOT NULL DEFAULT '0',
  `product_stock_out` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`product_stock_id`),
  KEY `fk_product_stock_product` (`product_stock_product_id`),
  KEY `fk_product_stock_variant` (`product_stock_variant_id`),
  KEY `fk_product_stock_category` (`product_stock_category_id`)
) ENGINE=MyISAM AUTO_INCREMENT=161 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `product_stock`
--

INSERT INTO `product_stock` (`product_stock_id`, `product_stock_product_id`, `product_stock_variant_id`, `product_stock_category_id`, `product_stock_stock`, `product_stock_in`, `product_stock_out`) VALUES
(160, 166, 159, 1, 10, 0, 0),
(159, 165, 159, 1, 50, 0, 0),
(158, 164, 159, 8, 50, 0, 0),
(157, 163, 159, 8, 50, 0, 0),
(156, 162, 159, 8, 50, 0, 0),
(155, 161, 159, 8, 50, 0, 0),
(154, 160, 159, 8, 10, 0, 160);

-- --------------------------------------------------------

--
-- Struktur dari tabel `sales_order`
--

DROP TABLE IF EXISTS `sales_order`;
CREATE TABLE IF NOT EXISTS `sales_order` (
  `sales_order_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `sales_order_status` enum('pending','payed','confirmed','canceled','customer_canceled','break') NOT NULL,
  `sales_order_reason` varchar(500) NOT NULL,
  `sales_order_price` int NOT NULL,
  `sales_order_customer_id` int UNSIGNED NOT NULL,
  `sales_order_customer_name` varchar(255) NOT NULL,
  `sales_order_customer_address` varchar(255) NOT NULL,
  `sales_order_customer_no_handphone` varchar(21) NOT NULL,
  `sales_order_date` datetime NOT NULL,
  `sales_order_proof` varchar(255) NOT NULL,
  PRIMARY KEY (`sales_order_id`),
  KEY `fk_sales_order_customer` (`sales_order_customer_id`)
) ENGINE=MyISAM AUTO_INCREMENT=91 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `sales_order`
--

INSERT INTO `sales_order` (`sales_order_id`, `sales_order_status`, `sales_order_reason`, `sales_order_price`, `sales_order_customer_id`, `sales_order_customer_name`, `sales_order_customer_address`, `sales_order_customer_no_handphone`, `sales_order_date`, `sales_order_proof`) VALUES
(87, 'canceled', '', 120000, 1, 'noob', 'jkt', '0123313213', '2024-10-17 10:32:16', 'customer_87_1729150984_1cb9560e4ed0320f5a66.png'),
(85, 'canceled', '', 120000, 1, 'noob', 'jkt', '0123313213', '2024-10-17 10:20:10', 'customer_85_1729135214_bbe05e22bbe25032c660.png'),
(86, 'canceled', '', 120000, 1, 'noob', 'jkt', '0123313213', '2024-10-17 10:24:13', 'customer_86_1729135462_2a0787a5ec08638ff71f.png'),
(84, 'canceled', '', 120000, 1, 'noob', 'jkt', '0123313213', '2024-10-17 10:20:04', 'customer_84_1729135207_acd4fe6022e2607eec0e.png'),
(82, 'confirmed', '', 120000, 1, 'noob', 'jkt', '0123313213', '2024-10-17 10:10:14', 'customer_82_1729134616_0dc882a32d5396c9ce16.png'),
(83, 'confirmed', '', 120000, 1, 'noob', 'jkt', '0123313213', '2024-10-17 10:11:37', 'customer_83_1729134701_8970cdcd745469d658b8.png'),
(81, 'confirmed', '', 120000, 1, 'noob', 'jkt', '0123313213', '2024-10-17 10:10:08', 'customer_81_1729134612_e416b3efe4c40e73d649.png'),
(80, 'confirmed', '', 120000, 1, 'noob', 'jkt', '0123313213', '2024-10-17 10:10:03', 'customer_80_1729134604_9d864f4dcb59ea126fb9.png'),
(79, 'confirmed', '', 120000, 1, 'noob', 'jkt', '0123313213', '2024-10-16 14:51:51', 'customer_79_1729134600_b0aa477be4aeab702325.png'),
(78, 'confirmed', '', 120000, 1, 'noob', 'jkt', '0123313213', '2024-10-16 14:39:45', 'customer_78_1729064390_34927fde5adb8fcb2f7f.png'),
(76, 'customer_canceled', '', 120000, 1, 'noob', 'jkt', '0123313213', '2024-10-16 14:34:30', ''),
(77, 'confirmed', '', 120000, 1, 'noob', 'jkt', '0123313213', '2024-10-16 14:39:14', 'customer_77_1729064361_49734713b2647dd59802.png'),
(75, 'confirmed', '', 120000, 1, 'noob', 'jkt', '0123313213', '2024-10-16 14:33:19', 'customer_75_1729064033_d5c09fe2fe4546b2f5ae.png'),
(73, 'customer_canceled', '', 120000, 1, 'noob', 'jkt', '0123313213', '2024-10-16 14:32:28', ''),
(74, 'customer_canceled', '', 120000, 1, 'noob', 'jkt', '0123313213', '2024-10-16 14:32:50', ''),
(72, 'customer_canceled', '', 120000, 1, 'noob', 'jkt', '0123313213', '2024-10-16 14:31:58', ''),
(71, 'customer_canceled', '', 120000, 1, 'noob', 'jkt', '0123313213', '2024-10-16 14:31:27', ''),
(69, 'customer_canceled', '', 120000, 1, 'noob', 'jkt', '0123313213', '2024-10-16 14:30:20', ''),
(70, 'customer_canceled', '', 120000, 1, 'noob', 'jkt', '0123313213', '2024-10-16 14:30:53', ''),
(67, 'customer_canceled', '', 120000, 1, 'noob', 'jkt', '0123313213', '2024-10-16 14:28:09', ''),
(68, 'customer_canceled', '', 120000, 1, 'noob', 'jkt', '0123313213', '2024-10-16 14:28:59', ''),
(88, 'customer_canceled', '\'pengen ganti barang\'', 120000, 1, 'noob', 'jkt', '0123313213', '2024-10-17 14:43:09', ''),
(89, 'customer_canceled', 'pengen ganti barang', 120000, 1, 'noob', 'jkt', '0123313213', '2024-10-17 14:43:59', ''),
(90, 'canceled', 'stock abis', 120000, 1, 'noob', 'jkt', '0123313213', '2024-10-17 14:44:27', 'customer_90_1729151073_6622d62c6db76381c056.png');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sales_product`
--

DROP TABLE IF EXISTS `sales_product`;
CREATE TABLE IF NOT EXISTS `sales_product` (
  `sales_product_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `sales_product_status` enum('pending','payed','confirmed','canceled','customer_canceled','break') NOT NULL,
  `sales_product_product_id` int UNSIGNED NOT NULL,
  `sales_product_product_name` varchar(255) NOT NULL,
  `sales_product_product_variant` varchar(255) NOT NULL,
  `sales_product_product_category` varchar(255) NOT NULL,
  `sales_product_quantity` int NOT NULL,
  `sales_product_price` int NOT NULL,
  `sales_product_order_id` int UNSIGNED NOT NULL,
  `sales_product_customer_id` int UNSIGNED NOT NULL,
  PRIMARY KEY (`sales_product_id`),
  KEY `fk_sales_product_customer` (`sales_product_customer_id`),
  KEY `fk_sales_product_sales_order` (`sales_product_order_id`),
  KEY `fk_sales_product_product` (`sales_product_product_id`)
) ENGINE=MyISAM AUTO_INCREMENT=162 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `sales_product`
--

INSERT INTO `sales_product` (`sales_product_id`, `sales_product_status`, `sales_product_product_id`, `sales_product_product_name`, `sales_product_product_variant`, `sales_product_product_category`, `sales_product_quantity`, `sales_product_price`, `sales_product_order_id`, `sales_product_customer_id`) VALUES
(161, 'canceled', 160, 'Bakpia 465 Kering 20', 'test', 'kering', 5, 24000, 90, 1),
(160, 'customer_canceled', 160, 'Bakpia 465 Kering 20', 'test', 'kering', 5, 24000, 89, 1),
(159, 'customer_canceled', 160, 'Bakpia 465 Kering 20', 'test', 'kering', 5, 24000, 88, 1),
(158, 'canceled', 160, 'Bakpia 465 Kering 20', 'test', 'kering', 5, 24000, 87, 1),
(157, 'canceled', 160, 'Bakpia 465 Kering 20', 'test', 'kering', 5, 24000, 86, 1),
(156, 'canceled', 160, 'Bakpia 465 Kering 20', 'test', 'kering', 5, 24000, 85, 1),
(155, 'canceled', 160, 'Bakpia 465 Kering 20', 'test', 'kering', 5, 24000, 84, 1),
(154, 'confirmed', 160, 'Bakpia 465 Kering 20', 'test', 'kering', 5, 24000, 83, 1),
(153, 'confirmed', 160, 'Bakpia 465 Kering 20', 'test', 'kering', 5, 24000, 82, 1),
(152, 'confirmed', 160, 'Bakpia 465 Kering 20', 'test', 'kering', 5, 24000, 81, 1),
(151, 'confirmed', 160, 'Bakpia 465 Kering 20', 'test', 'kering', 5, 24000, 80, 1),
(150, 'confirmed', 160, 'Bakpia 465 Kering 20', 'test', 'kering', 5, 24000, 79, 1),
(149, 'confirmed', 160, 'Bakpia 465 Kering 20', 'test', 'kering', 5, 24000, 78, 1),
(148, 'confirmed', 160, 'Bakpia 465 Kering 20', 'test', 'kering', 5, 24000, 77, 1),
(147, 'customer_canceled', 160, 'Bakpia 465 Kering 20', 'test', 'kering', 5, 24000, 76, 1),
(146, 'confirmed', 160, 'Bakpia 465 Kering 20', 'test', 'kering', 5, 24000, 75, 1),
(145, 'customer_canceled', 160, 'Bakpia 465 Kering 20', 'test', 'kering', 5, 24000, 74, 1),
(144, 'customer_canceled', 160, 'Bakpia 465 Kering 20', 'test', 'kering', 5, 24000, 73, 1),
(143, 'customer_canceled', 160, 'Bakpia 465 Kering 20', 'test', 'kering', 5, 24000, 72, 1),
(142, 'customer_canceled', 160, 'Bakpia 465 Kering 20', 'test', 'kering', 5, 24000, 71, 1),
(141, 'customer_canceled', 160, 'Bakpia 465 Kering 20', 'test', 'kering', 5, 24000, 70, 1),
(140, 'customer_canceled', 160, 'Bakpia 465 Kering 20', 'test', 'kering', 5, 24000, 69, 1),
(139, 'customer_canceled', 160, 'Bakpia 465 Kering 20', 'test', 'kering', 5, 24000, 68, 1),
(138, 'customer_canceled', 160, 'Bakpia 465 Kering 20', 'test', 'kering', 5, 24000, 67, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `user_password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `user_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `user_email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `user_no_handphone` varchar(25) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `user_role` enum('super_user','admin') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `user_otp` int DEFAULT NULL,
  `user_otp_expired` datetime DEFAULT NULL,
  `user_created_at` datetime DEFAULT NULL,
  `user_updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`user_id`, `user_username`, `user_password`, `user_name`, `user_email`, `user_no_handphone`, `user_role`, `user_otp`, `user_otp_expired`, `user_created_at`, `user_updated_at`) VALUES
(1, 'bakpia', '123456', 'lol', 'piteknoob@gmail.com', '6285600077410', 'super_user', NULL, NULL, '2024-07-25 10:52:24', '2024-09-02 09:07:11'),
(24, 'bakpia211', '123456', 'tes', 'pitek@gmail.com', '1231212111111', 'admin', NULL, NULL, '2024-08-29 11:47:22', '2024-10-16 10:12:40');

-- --------------------------------------------------------

--
-- Struktur dari tabel `variant`
--

DROP TABLE IF EXISTS `variant`;
CREATE TABLE IF NOT EXISTS `variant` (
  `variant_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `variant_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `variant_created_at` datetime DEFAULT NULL,
  `variant_updated_at` datetime DEFAULT NULL,
  `variant_deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`variant_id`)
) ENGINE=MyISAM AUTO_INCREMENT=163 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `variant`
--

INSERT INTO `variant` (`variant_id`, `variant_name`, `variant_created_at`, `variant_updated_at`, `variant_deleted_at`) VALUES
(158, 'test4', '2024-10-10 09:15:56', NULL, NULL),
(159, 'test', '2024-10-10 09:16:03', NULL, NULL),
(160, 'test1', '2024-10-10 09:16:05', NULL, NULL);

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `auth_user`
--
ALTER TABLE `auth_user`
  ADD CONSTRAINT `FK_auth_user_user` FOREIGN KEY (`auth_user_user_id`) REFERENCES `user` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
