-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Waktu pembuatan: 21 Nov 2024 pada 09.47
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
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `auth_user`
--

INSERT INTO `auth_user` (`auth_user_id`, `auth_user_user_id`, `auth_user_username`, `auth_user_token`, `auth_user_date_login`, `auth_user_date_expired`) VALUES
(6, 1, 'bakpia', 'YmFrcGlhMTIzNDU2', '2024-11-21 16:40:31', '2024-11-22 16:40:31');

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
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `bank`
--

INSERT INTO `bank` (`bank_id`, `bank_name`, `bank_account_name`, `bank_account_number`, `bank_code`, `bank_created_at`, `bank_updated_at`) VALUES
(1, 'BCA', 'pitek', '6913812381', '014', '2024-10-17 04:33:44', NULL),
(3, 'BRI', 'pitek', '69138123811', '021', '2024-10-17 07:35:08', NULL),
(4, 'NIAGA', 'pitek', '123124', '011', '2024-10-17 07:35:36', NULL),
(5, 'MANDIRI', 'pitek', '69138123', '51512', '2024-11-21 09:40:21', NULL),
(6, 'BNI', 'pitek', '6913812342142', '511', '2024-11-21 09:40:31', NULL);

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
) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `category`
--

INSERT INTO `category` (`category_id`, `category_name`, `category_created_at`, `category_updated_at`, `category_deleted_at`) VALUES
(1, 'Basah', '2024-08-02 06:58:12', NULL, NULL),
(8, 'Kering', '2024-09-06 10:20:17', NULL, NULL);

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
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `customer`
--

INSERT INTO `customer` (`customer_id`, `customer_name`, `customer_address`, `customer_no_handphone`) VALUES
(1, 'noob', 'jkt', '0123313213'),
(2, 'asdfasdf', 'dsasfds', '12312312312'),
(3, 'hfdsfnmcbcvz', 'ewqrwasgdhey54ythhj,gj,n', '1345675516768965'),
(4, 'hfdsfnmcbcvz', 'vscdfagnfgfsdfagfbd', '12312312312'),
(5, 'dawdwa', 'jkt', '0123313213'),
(6, 'dwadawdawdawdawdawdawdwadadwdawdadwadwadwwdwwdaawwdawwdadwawddawdawdawadwdawdawwad', 'dwadawdawdawdsdwadwadawdawdawdadawdadawwadadawdasdw', '421422141214'),
(7, 'dwadaw', 'dwwadwadawdawdawda', '2141421412'),
(8, 'dwa', 'dwadawdwa', '21412421414'),
(9, 'dwdawdwad', 'dawdawdadaw', '241241412412'),
(10, 'dwadaw', 'asd', '12412513551'),
(11, 'dwadawda', 'dwadwadaw', '214214214214'),
(12, 'dawda', 'dwadawdawa', '124124124124'),
(13, 'dawdaw', 'dwadawdawd', '214214124214'),
(14, 'waddaw', 'dawdawd', '24124124124124'),
(15, '214dwadwa', 'dwadawdwadaw', '21421424214'),
(16, 'dwadaw', 'dwadawdawdawdsdwadwadawdawdawdadawdadawwadadawdasdw', '421422141214'),
(17, 'dwada', 'dwa', '124124124124'),
(18, 'dawad', 'dwadada', '2414124124124'),
(19, 'dwadaw', 'dwadwad', '2414124212142'),
(20, 'dwadaw', 'dadawd', '4214141241412'),
(21, 'dwadaw', 'dwadasdwa', '111111111111111'),
(22, 'dawda', 'dwa', '24141241241'),
(23, 'dwadaw', 'dawdawdad', '41242124421');

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
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `outlet`
--

INSERT INTO `outlet` (`outlet_id`, `outlet_title`, `outlet_address`, `outlet_photo`, `outlet_link`, `outlet_created_at`, `outlet_updated_at`) VALUES
(3, 'tes', 'tes', 'tes_1732073094.webp', 'linkpohmax', '2024-09-11 14:13:13', '2024-11-20 09:28:44'),
(4, 'tes', 'tes', 'tes_1732070513.jpeg', 'linkpohmax', '2024-09-11 14:17:28', '2024-11-20 09:28:34'),
(5, 'tes', 'tes', 'tes_1732072569.webp', 'tes', '2024-11-20 09:31:08', NULL),
(6, 'warung', 'bantul', 'warung_1732070282.webp', 'tes', '2024-11-20 09:31:30', NULL),
(7, 'warung', 'bantul', 'warung_1732072907.webp', 'link', '2024-11-20 09:31:34', NULL),
(8, 'warung', 'bantul', 'warung_1732071278.webp', 'tes', '2024-11-20 09:31:38', NULL),
(9, 'esoda', 'poh', 'esoda_1732070604.webp', 'tes', '2024-11-20 09:31:44', NULL);

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
) ENGINE=MyISAM AUTO_INCREMENT=245 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `product`
--

INSERT INTO `product` (`product_id`, `product_name`, `product_price`, `product_category_id`, `product_category_name`, `product_variant_id`, `product_variant_name`, `product_description`, `product_photo`, `product_created_at`, `product_updated_at`) VALUES
(237, 'Bakpia 465', 24000, 1, 'Basah', 159, 'test', 'dwadawdawdawd', 'bakpia_465_1731901078.png', '2024-11-18 10:14:51', NULL),
(236, 'Bakpia 465', 24000, 1, 'Basah', 159, 'test', 'dwadawdawdawd', 'bakpia_465_1731900236.png', '2024-11-18 10:14:48', NULL),
(235, 'Bakpia 465', 24000, 1, 'Basah', 159, 'test', 'dwadawdawdawd', NULL, '2024-11-18 10:13:48', NULL),
(230, '123', 123, 1, 'Basah', 158, 'test4', 'dwadawdawdawdawd', '123_1731576644.jpg', '2024-11-14 15:40:01', '2024-11-14 15:43:42'),
(232, 'Griya Bakpia', 24000, 1, 'Basah', 159, 'test', 'dwadawdawdawd', 'griya_bakpia_1731660227.png', '2024-11-15 15:20:16', NULL),
(231, 'griya bakpia', 24000, 1, 'Basah', 159, 'test', 'dwadawdawdawd', 'griya_bakpia_1731662073.png', '2024-11-15 15:20:12', NULL),
(212, 'dwad', 231412, 1, 'Basah', 158, 'test4', 'dwa', 'dwad_1731570571.png', '2024-11-14 13:55:47', '2024-11-14 14:12:32'),
(213, 'dwada', 21414, 1, 'Basah', 158, 'test4', 'dwadas', 'dwada_1731569406.png', '2024-11-14 14:03:53', '2024-11-14 14:12:58'),
(214, 'wdawda', 214, 1, 'Basah', 158, 'test4', '214124', NULL, '2024-11-14 14:07:17', NULL),
(215, 'hitam', 42141421, 1, 'Basah', 158, 'test4', 'asd', NULL, '2024-11-14 14:08:46', NULL),
(209, '12344556546467', 2147483647, 1, 'Basah', 160, 'test1', 'wesdbndhndnfbndssdgsfd ssvfs sf sfg', '12344556546467_1731562944.png', '2024-11-14 11:52:52', '2024-11-14 12:08:13'),
(234, 'Bakpia 465', 24000, 1, 'Basah', 159, 'test', 'dwadawdawdawd', NULL, '2024-11-18 10:13:44', NULL),
(207, 'Basah', 24000, 1, 'Basah', 159, 'test', 'dwadawdawdawd', 'basah_1731562846.png', '2024-11-14 11:45:51', NULL),
(206, 'Kering', 24000, 8, 'Kering', 159, 'test', 'dwadawdawdawd', 'kering_1731562470.png', '2024-11-14 11:45:47', NULL),
(233, 'Bakpia 465', 24000, 1, 'Basah', 159, 'test', 'dwadawdawdawd', NULL, '2024-11-18 10:13:20', NULL),
(228, 'hitam', 412, 1, 'Basah', 158, 'test4', 'dwadwad', 'hitam_1731570038.png', '2024-11-14 14:33:16', NULL),
(194, 'test insert', 24000, 1, 'Basah', 159, 'test', 'dwadawdawdawd', NULL, '2024-11-14 11:42:39', NULL),
(195, 'Bakpia', 24000, 1, 'Basah', 159, 'test', 'dwadawdawdawd', NULL, '2024-11-14 11:42:44', NULL),
(196, 'Coba', 24000, 1, 'Basah', 159, 'test', 'dwadawdawdawd', NULL, '2024-11-14 11:42:46', NULL),
(205, 'Test', 24000, 8, 'Kering', 159, 'test', 'dwadawdawdawd', 'test_1731562170.png', '2024-11-14 11:45:43', NULL),
(204, 'Kering', 24000, 8, 'Kering', 159, 'test', 'dwadawdawdawd', 'kering_1731561767.png', '2024-11-14 11:45:42', NULL),
(225, 'hitam', 124, 1, 'Basah', 158, 'test4', 'dwa', NULL, '2024-11-14 14:30:41', NULL),
(226, 'hitam', 41241, 1, 'Basah', 158, 'test4', 'dwadwa', 'hitam_1731573054.png', '2024-11-14 14:31:35', NULL),
(238, 'Bakpia 465', 24000, 1, 'Basah', 159, 'test', 'dwadawdawdawd', NULL, '2024-11-18 10:14:58', NULL),
(239, 'Bakpia 465 Kering', 24000, 1, 'Basah', 159, 'test', 'dwadawdawdawd', 'bakpia_465_kering_1731901941.png', '2024-11-18 10:15:10', NULL),
(240, 'Bakpia 465 Kering', 24000, 1, 'Basah', 159, 'test', 'dwadawdawdawd', NULL, '2024-11-18 10:15:14', NULL),
(241, 'Bakpia 465 Kering', 24000, 1, 'Basah', 159, 'test', 'dwadawdawdawd', 'bakpia_465_kering_1731901823.png', '2024-11-18 10:15:24', NULL),
(242, 'Bakpia 465 Kering', 50000, 1, 'Basah', 159, 'test', 'dwadawdawdawd', 'bakpia_465_kering_1731918829.png', '2024-11-18 14:35:17', NULL),
(243, 'Bakpia 465 Kering', 50000, 1, 'Basah', 159, 'test', 'dwadawdawdawd', 'bakpia_465_kering_1731918021.png', '2024-11-18 14:35:20', NULL),
(244, 'Bakpia 465 Kering', 50000, 1, 'Basah', 159, 'test', 'dwadawdawdawd', 'bakpia_465_kering_1731917632.png', '2024-11-18 14:35:21', NULL);

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
) ENGINE=MyISAM AUTO_INCREMENT=243 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `product_stock`
--

INSERT INTO `product_stock` (`product_stock_id`, `product_stock_product_id`, `product_stock_variant_id`, `product_stock_category_id`, `product_stock_stock`, `product_stock_in`, `product_stock_out`) VALUES
(194, 198, 159, 1, 50, 0, 0),
(193, 0, 159, 2, 50, 0, 0),
(232, 234, 159, 1, 32, 0, 18),
(198, 200, 159, 8, 50, 0, 0),
(199, 201, 159, 8, 50, 0, 0),
(200, 202, 159, 8, 50, 0, 0),
(196, 0, 159, 2, 50, 0, 0),
(195, 0, 159, 2, 50, 0, 0),
(192, 0, 159, 2, 50, 0, 0),
(230, 232, 159, 1, 35, 0, 15),
(202, 204, 159, 8, 47, 0, 3),
(203, 205, 159, 8, 50, 0, 0),
(204, 206, 159, 8, 50, 0, 0),
(226, 228, 158, 1, 240, 0, 1),
(205, 207, 159, 1, 50, 0, 0),
(191, 197, 159, 1, 50, 0, 0),
(190, 196, 159, 1, 50, 0, 0),
(182, 188, 159, 1, 50, 0, 0),
(183, 189, 159, 1, 50, 0, 0),
(184, 190, 159, 1, 50, 0, 0),
(185, 191, 159, 1, 50, 0, 0),
(186, 192, 159, 1, 50, 0, 0),
(223, 225, 158, 1, 2414, 0, 0),
(224, 226, 158, 1, 241421, 0, 0),
(188, 194, 159, 1, 50, 0, 0),
(171, 177, 159, 1, 50, 0, 0),
(169, 175, 159, 1, 50, 0, 0),
(167, 173, 159, 1, 50, 0, 0),
(166, 172, 159, 1, 50, 0, 0),
(165, 171, 159, 1, 50, 0, 0),
(170, 176, 159, 1, 50, 0, 0),
(240, 242, 159, 1, 50, 0, 0),
(239, 241, 159, 1, 50, 0, 0),
(154, 160, 159, 8, -10, 0, 180),
(234, 236, 159, 1, 45, 0, 5),
(236, 238, 159, 1, 50, 0, 0),
(235, 237, 159, 1, 45, 0, 5),
(181, 187, 159, 1, 50, 0, 0),
(172, 178, 159, 1, 50, 0, 0),
(238, 240, 159, 1, 50, 0, 0),
(231, 233, 159, 1, 50, 0, 0),
(237, 239, 159, 1, 25, 0, 25),
(207, 209, 160, 1, 123123123, 0, 0),
(189, 195, 159, 1, 50, 0, 0),
(211, 213, 158, 1, 124, 0, 0),
(210, 212, 158, 1, 4124124, 0, 0),
(212, 214, 158, 1, 214124, 0, 0),
(213, 215, 158, 1, 21441, 0, 0),
(228, 230, 158, 1, 123, 0, 0),
(233, 235, 159, 1, 50, 0, 0),
(229, 231, 159, 1, 50, 0, 0),
(241, 243, 159, 1, 50, 0, 0),
(242, 244, 159, 1, 50, 0, 0);

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
) ENGINE=MyISAM AUTO_INCREMENT=116 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `sales_order`
--

INSERT INTO `sales_order` (`sales_order_id`, `sales_order_status`, `sales_order_reason`, `sales_order_price`, `sales_order_customer_id`, `sales_order_customer_name`, `sales_order_customer_address`, `sales_order_customer_no_handphone`, `sales_order_date`, `sales_order_proof`) VALUES
(98, 'pending', '', 48000, 7, 'dwadaw', 'dwwadwadawdawdawda', '2141421412', '2024-11-21 15:00:23', ''),
(99, 'pending', '', 48000, 8, 'dwa', 'dwadawdwa', '21412421414', '2024-11-21 15:02:39', ''),
(100, 'pending', '', 48000, 9, 'dwdawdwad', 'dawdawdadaw', '241241412412', '2024-11-21 15:04:58', ''),
(101, 'pending', '', 48000, 10, 'dwadaw', 'asd', '12412513551', '2024-11-21 15:13:23', ''),
(102, 'pending', '', 48000, 11, 'dwadawda', 'dwadwadaw', '214214214214', '2024-11-21 15:14:22', ''),
(103, 'pending', '', 48000, 12, 'dawda', 'dwadawdawa', '124124124124', '2024-11-21 15:14:51', ''),
(104, 'pending', '', 48000, 13, 'dawdaw', 'dwadawdawd', '214214124214', '2024-11-21 15:15:24', ''),
(105, 'pending', '', 48000, 14, 'waddaw', 'dawdawd', '24124124124124', '2024-11-21 15:15:36', ''),
(106, 'pending', '', 48000, 15, '214dwadwa', 'dwadawdwadaw', '21421424214', '2024-11-21 15:16:09', ''),
(107, 'pending', '', 120000, 16, 'dwadaw', 'dwadawdawdawdsdwadwadawdawdawdadawdadawwadadawdasdw', '421422141214', '2024-11-21 15:17:57', ''),
(108, 'pending', '', 48000, 17, 'dwada', 'dwa', '124124124124', '2024-11-21 15:20:53', ''),
(109, 'pending', '', 24412, 18, 'dawad', 'dwadada', '2414124124124', '2024-11-21 15:21:30', ''),
(110, 'pending', '', 48000, 19, 'dwadaw', 'dwadwad', '2414124212142', '2024-11-21 15:25:34', ''),
(111, 'pending', '', 0, 20, 'dwadaw', 'dadawd', '4214141241412', '2024-11-21 15:48:17', ''),
(112, 'pending', '', 0, 21, 'dwadaw', 'dwadasdwa', '111111111111111', '2024-11-21 15:48:37', ''),
(113, 'pending', '', 48000, 22, 'dawda', 'dwa', '24141241241', '2024-11-21 15:57:57', ''),
(114, 'pending', '', 240000, 1, 'noob', 'jkt', '0123313213', '2024-11-21 16:01:57', ''),
(115, 'pending', '', 48000, 23, 'dwadaw', 'dawdawdad', '41242124421', '2024-11-21 16:08:07', '');

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
) ENGINE=MyISAM AUTO_INCREMENT=204 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `sales_product`
--

INSERT INTO `sales_product` (`sales_product_id`, `sales_product_status`, `sales_product_product_id`, `sales_product_product_name`, `sales_product_product_variant`, `sales_product_product_category`, `sales_product_quantity`, `sales_product_price`, `sales_product_order_id`, `sales_product_customer_id`) VALUES
(203, 'pending', 232, 'Griya Bakpia', 'test', 'Basah', 1, 24000, 115, 23),
(202, 'pending', 234, 'Bakpia 465', 'test', 'Basah', 1, 24000, 115, 23),
(201, 'pending', 236, 'Bakpia 465', 'test', 'Basah', 5, 24000, 114, 1),
(200, 'pending', 237, 'Bakpia 465', 'test', 'Basah', 5, 24000, 114, 1),
(199, 'pending', 232, 'Griya Bakpia', 'test', 'Basah', 1, 24000, 113, 22),
(198, 'pending', 234, 'Bakpia 465', 'test', 'Basah', 1, 24000, 113, 22),
(197, 'pending', 232, 'Griya Bakpia', 'test', 'Basah', 1, 24000, 110, 19),
(196, 'pending', 234, 'Bakpia 465', 'test', 'Basah', 1, 24000, 110, 19),
(195, 'pending', 228, 'hitam', 'test4', 'Basah', 1, 412, 109, 18),
(194, 'pending', 234, 'Bakpia 465', 'test', 'Basah', 1, 24000, 109, 18),
(193, 'pending', 232, 'Griya Bakpia', 'test', 'Basah', 1, 24000, 108, 17),
(192, 'pending', 234, 'Bakpia 465', 'test', 'Basah', 1, 24000, 108, 17),
(191, 'pending', 239, 'Bakpia 465 Kering', 'test', 'Basah', 5, 24000, 107, 16),
(190, 'pending', 232, 'Griya Bakpia', 'test', 'Basah', 1, 24000, 106, 15),
(189, 'pending', 234, 'Bakpia 465', 'test', 'Basah', 1, 24000, 106, 15),
(188, 'pending', 232, 'Griya Bakpia', 'test', 'Basah', 1, 24000, 105, 14),
(187, 'pending', 234, 'Bakpia 465', 'test', 'Basah', 1, 24000, 105, 14),
(186, 'pending', 232, 'Griya Bakpia', 'test', 'Basah', 1, 24000, 104, 13),
(185, 'pending', 234, 'Bakpia 465', 'test', 'Basah', 1, 24000, 104, 13),
(184, 'pending', 232, 'Griya Bakpia', 'test', 'Basah', 1, 24000, 103, 12),
(183, 'pending', 234, 'Bakpia 465', 'test', 'Basah', 1, 24000, 103, 12),
(182, 'pending', 232, 'Griya Bakpia', 'test', 'Basah', 1, 24000, 102, 11),
(181, 'pending', 234, 'Bakpia 465', 'test', 'Basah', 1, 24000, 102, 11),
(180, 'pending', 232, 'Griya Bakpia', 'test', 'Basah', 1, 24000, 101, 10),
(179, 'pending', 234, 'Bakpia 465', 'test', 'Basah', 1, 24000, 101, 10),
(178, 'pending', 204, 'Kering', 'test', 'Kering', 1, 24000, 100, 9),
(177, 'pending', 234, 'Bakpia 465', 'test', 'Basah', 1, 24000, 100, 9),
(176, 'pending', 204, 'Kering', 'test', 'Kering', 1, 24000, 99, 8),
(175, 'pending', 234, 'Bakpia 465', 'test', 'Basah', 1, 24000, 99, 8),
(174, 'pending', 232, 'Griya Bakpia', 'test', 'Basah', 1, 24000, 98, 7),
(173, 'pending', 234, 'Bakpia 465', 'test', 'Basah', 1, 24000, 98, 7);

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
(1, 'bakpia', '123456', 'lol', 'piteknoob@gmail.com', '6285600077410', 'super_user', 913497, '2024-11-21 14:41:39', '2024-07-25 10:52:24', '2024-09-02 09:07:11');

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
) ENGINE=MyISAM AUTO_INCREMENT=164 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `variant`
--

INSERT INTO `variant` (`variant_id`, `variant_name`, `variant_created_at`, `variant_updated_at`, `variant_deleted_at`) VALUES
(158, 'test4', '2024-10-10 09:15:56', NULL, NULL),
(159, 'test', '2024-10-10 09:16:03', NULL, NULL),
(160, 'test1', '2024-10-10 09:16:05', NULL, NULL),
(163, 'Basah', '2024-11-14 07:16:04', NULL, NULL);

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
