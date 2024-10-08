-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Waktu pembuatan: 07 Okt 2024 pada 09.32
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
(6, 1, 'bakpia', 'YmFrcGlhMTIzNDU2', '2024-10-07 16:21:55', '2024-10-08 16:21:55'),
(8, 24, 'bakpia2', 'YmFrcGlhMjEyMzQ1Ng==', '2024-10-07 15:31:25', '2024-10-08 15:31:25');

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
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
) ENGINE=MyISAM AUTO_INCREMENT=99 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
(98, 39, 28, 1, 'sold', 5, '2024-08-23 13:37:48');

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
  `product_name` varchar(255) NOT NULL,
  `product_price` int NOT NULL,
  `product_category_id` int UNSIGNED NOT NULL,
  `product_category_name` varchar(255) NOT NULL,
  `product_description` varchar(1000) NOT NULL,
  `product_photo` varchar(255) DEFAULT NULL,
  `product_created_at` datetime DEFAULT NULL,
  `product_updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`product_id`),
  KEY `fk_product_category` (`product_category_id`)
) ENGINE=MyISAM AUTO_INCREMENT=152 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `product`
--

INSERT INTO `product` (`product_id`, `product_name`, `product_price`, `product_category_id`, `product_category_name`, `product_description`, `product_photo`, `product_created_at`, `product_updated_at`) VALUES
(139, 'Griya Bakpia Premium 15', 40000, 1, 'Basah', '', 'griya_bakpia_premium_15_1728272986.jpg', '2024-10-07 10:44:22', NULL),
(140, 'Griya Bakpia Premium 15', 40000, 1, 'Basah', '', 'griya_bakpia_premium_15_1728274358.jpg', '2024-10-07 10:46:10', NULL),
(141, 'Griya Bakpia Premium 15', 40000, 1, 'Basah', '', 'griya_bakpia_premium_15_1728273486.jpg', '2024-10-07 10:48:52', NULL),
(142, 'Griya Bakpia Premium 15', 40000, 1, 'Basah', '', 'griya_bakpia_premium_15_1728273939.jpg', '2024-10-07 10:50:43', NULL),
(143, 'Griya Bakpia Premium 15', 42000, 1, 'Basah', '', 'griya_bakpia_premium_15_1728275816.jpg', '2024-10-07 10:52:22', NULL),
(144, 'Bakpia 465 Basah 20', 24000, 1, 'Basah', '', 'bakpia_465_basah_20_1728274299.jpg', '2024-10-07 10:56:30', NULL),
(145, 'Bakpia 465 Basah 20', 26000, 1, 'Basah', '', 'bakpia_465_basah_20_1728274581.jpg', '2024-10-07 11:04:07', NULL),
(146, 'Bakpia 465 Basah 20', 26000, 1, 'Basah', '', 'bakpia_465_basah_20_1728274597.jpg', '2024-10-07 11:06:52', NULL),
(147, 'Bakpia 465 Basah 15', 24000, 1, 'Basah', '', 'bakpia_465_basah_15_1728276956.jpg', '2024-10-07 11:08:32', NULL),
(148, 'Bakpia 465 Kering 20', 24000, 8, 'kering', '', 'bakpia_465_kering_20_1728274675.jpg', '2024-10-07 11:10:53', NULL),
(149, 'Bakpia 465 Kering 20', 24000, 8, 'kering', '', 'bakpia_465_kering_20_1728274998.jpg', '2024-10-07 11:12:03', NULL),
(150, 'Bakpia 465 Kering 20', 24000, 8, 'kering', 'Bakpia dengan isi rasa strawberry, blueberry, capucino, dan tiramisu', 'bakpia_465_kering_20_1728275508.jpg', '2024-10-07 11:14:25', NULL),
(151, 'Bakpia 465 Kering 20', 24000, 8, 'kering', '', 'bakpia_465_kering_20_1728277524.jpg', '2024-10-07 11:16:13', NULL);

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
) ENGINE=MyISAM AUTO_INCREMENT=145 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `product_stock`
--

INSERT INTO `product_stock` (`product_stock_id`, `product_stock_product_id`, `product_stock_variant_id`, `product_stock_category_id`, `product_stock_stock`, `product_stock_in`, `product_stock_out`) VALUES
(144, 151, 143, 8, 50, 0, 0),
(143, 150, 142, 8, 50, 0, 0),
(142, 149, 141, 8, 50, 0, 0),
(141, 148, 140, 8, 50, 0, 0),
(140, 147, 139, 1, 50, 0, 0),
(139, 146, 138, 1, 50, 0, 0),
(138, 145, 137, 1, 50, 0, 0),
(137, 144, 136, 1, 50, 0, 0),
(136, 143, 135, 1, 50, 0, 0),
(135, 142, 134, 1, 50, 0, 0),
(134, 141, 133, 1, 50, 0, 0),
(133, 140, 132, 1, 50, 0, 0),
(132, 139, 131, 1, 50, 0, 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `sales_order`
--

DROP TABLE IF EXISTS `sales_order`;
CREATE TABLE IF NOT EXISTS `sales_order` (
  `sales_order_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `sales_order_status` enum('pending','payed','confirmed','canceled','customer_canceled','break') NOT NULL,
  `sales_order_price` int NOT NULL,
  `sales_order_customer_id` int UNSIGNED NOT NULL,
  `sales_order_customer_name` varchar(255) NOT NULL,
  `sales_order_customer_address` varchar(255) NOT NULL,
  `sales_order_customer_no_handphone` varchar(21) NOT NULL,
  `sales_order_date` datetime NOT NULL,
  `sales_order_proof` varchar(255) NOT NULL,
  PRIMARY KEY (`sales_order_id`),
  KEY `fk_sales_order_customer` (`sales_order_customer_id`)
) ENGINE=MyISAM AUTO_INCREMENT=49 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `sales_order`
--

INSERT INTO `sales_order` (`sales_order_id`, `sales_order_status`, `sales_order_price`, `sales_order_customer_id`, `sales_order_customer_name`, `sales_order_customer_address`, `sales_order_customer_no_handphone`, `sales_order_date`, `sales_order_proof`) VALUES
(48, 'payed', 740000, 1, 'noob', 'jkt', '0123313213', '2024-08-23 13:40:15', 'customer_48_1724395219_5578f583f8d529610800.png'),
(47, 'canceled', 740000, 1, 'noob', 'jkt', '0123313213', '2024-08-23 10:53:55', 'customer_47_1724393905_66052ee4b9136ef6bc51.png'),
(46, 'confirmed', 740000, 1, 'noob', 'jkt', '0123313213', '2024-08-23 10:38:31', 'customer_46_1724384314_298a9687cb43fa89a1d8.png'),
(45, 'confirmed', 740000, 1, 'noob', 'jkt', '0123313213', '2024-08-23 10:38:00', 'customer_45_1724384284_1265aa609359e70533cf.png'),
(44, 'confirmed', 740000, 1, 'noob', 'jkt', '0123313213', '2024-08-23 10:35:55', 'customer_44_1724384159_21fc2e0cadf828958b6f.png'),
(43, 'confirmed', 740000, 1, 'noob', 'jkt', '0123313213', '2024-08-23 10:35:11', 'customer_43_1724384115_1ad1ad41f5a212b08a88.png'),
(41, 'customer_canceled', 740000, 1, 'noob', 'jkt', '0123313213', '2024-08-23 10:08:03', ''),
(42, 'confirmed', 740000, 1, 'noob', 'jkt', '0123313213', '2024-08-23 10:34:16', 'customer_42_1724384061_028804fe75c2bbcc7ef7.png'),
(40, 'confirmed', 740000, 1, 'noob', 'jkt', '0123313213', '2024-08-23 10:07:56', 'customer_40_1724382481_23aa5c03e4df7aee4e04.png'),
(39, 'confirmed', 740000, 1, 'noob', 'jkt', '0123313213', '2024-08-22 16:38:09', 'customer_39_1724382441_901510cf01b53bf9ac73.png');

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
) ENGINE=MyISAM AUTO_INCREMENT=119 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `sales_product`
--

INSERT INTO `sales_product` (`sales_product_id`, `sales_product_status`, `sales_product_product_id`, `sales_product_product_name`, `sales_product_product_variant`, `sales_product_product_category`, `sales_product_quantity`, `sales_product_price`, `sales_product_order_id`, `sales_product_customer_id`) VALUES
(81, 'confirmed', 36, 'Griya Bakpia Premium 15', 'Mix', 'Basah', 5, 42000, 39, 1),
(80, 'confirmed', 35, 'Griya Bakpia Premium 15', 'Durian', 'Basah', 5, 40000, 39, 1),
(79, 'confirmed', 31, 'Griya Bakpia Premium 15', 'Kacang Hijau', 'Basah', 5, 40000, 39, 1),
(82, 'confirmed', 39, 'Bakpia 465 20', 'Kacang Hijau Rasa Coklat', 'Basah', 5, 26000, 39, 1),
(83, 'confirmed', 31, 'Griya Bakpia Premium 15', 'Kacang Hijau', 'Basah', 5, 40000, 40, 1),
(84, 'confirmed', 35, 'Griya Bakpia Premium 15', 'Durian', 'Basah', 5, 40000, 40, 1),
(85, 'confirmed', 36, 'Griya Bakpia Premium 15', 'Mix', 'Basah', 5, 42000, 40, 1),
(86, 'confirmed', 39, 'Bakpia 465 20', 'Kacang Hijau Rasa Coklat', 'Basah', 5, 26000, 40, 1),
(87, 'customer_canceled', 31, 'Griya Bakpia Premium 15', 'Kacang Hijau', 'Basah', 5, 40000, 41, 1),
(88, 'customer_canceled', 35, 'Griya Bakpia Premium 15', 'Durian', 'Basah', 5, 40000, 41, 1),
(89, 'customer_canceled', 36, 'Griya Bakpia Premium 15', 'Mix', 'Basah', 5, 42000, 41, 1),
(90, 'customer_canceled', 39, 'Bakpia 465 20', 'Kacang Hijau Rasa Coklat', 'Basah', 5, 26000, 41, 1),
(91, 'confirmed', 31, 'Griya Bakpia Premium 15', 'Kacang Hijau', 'Basah', 5, 40000, 42, 1),
(92, 'confirmed', 35, 'Griya Bakpia Premium 15', 'Durian', 'Basah', 5, 40000, 42, 1),
(93, 'confirmed', 36, 'Griya Bakpia Premium 15', 'Mix', 'Basah', 5, 42000, 42, 1),
(94, 'confirmed', 39, 'Bakpia 465 20', 'Kacang Hijau Rasa Coklat', 'Basah', 5, 26000, 42, 1),
(95, 'confirmed', 31, 'Griya Bakpia Premium 15', 'Kacang Hijau', 'Basah', 5, 40000, 43, 1),
(96, 'confirmed', 35, 'Griya Bakpia Premium 15', 'Durian', 'Basah', 5, 40000, 43, 1),
(97, 'confirmed', 36, 'Griya Bakpia Premium 15', 'Mix', 'Basah', 5, 42000, 43, 1),
(98, 'confirmed', 39, 'Bakpia 465 20', 'Kacang Hijau Rasa Coklat', 'Basah', 5, 26000, 43, 1),
(99, 'confirmed', 31, 'Griya Bakpia Premium 15', 'Kacang Hijau', 'Basah', 5, 40000, 44, 1),
(100, 'confirmed', 35, 'Griya Bakpia Premium 15', 'Durian', 'Basah', 5, 40000, 44, 1),
(101, 'confirmed', 36, 'Griya Bakpia Premium 15', 'Mix', 'Basah', 5, 42000, 44, 1),
(102, 'confirmed', 39, 'Bakpia 465 20', 'Kacang Hijau Rasa Coklat', 'Basah', 5, 26000, 44, 1),
(103, 'confirmed', 31, 'Griya Bakpia Premium 15', 'Kacang Hijau', 'Basah', 5, 40000, 45, 1),
(104, 'confirmed', 35, 'Griya Bakpia Premium 15', 'Durian', 'Basah', 5, 40000, 45, 1),
(105, 'confirmed', 36, 'Griya Bakpia Premium 15', 'Mix', 'Basah', 5, 42000, 45, 1),
(106, 'confirmed', 39, 'Bakpia 465 20', 'Kacang Hijau Rasa Coklat', 'Basah', 5, 26000, 45, 1),
(107, 'confirmed', 31, 'Griya Bakpia Premium 15', 'Kacang Hijau', 'Basah', 5, 40000, 46, 1),
(108, 'confirmed', 35, 'Griya Bakpia Premium 15', 'Durian', 'Basah', 5, 40000, 46, 1),
(109, 'confirmed', 36, 'Griya Bakpia Premium 15', 'Mix', 'Basah', 5, 42000, 46, 1),
(110, 'confirmed', 39, 'Bakpia 465 20', 'Kacang Hijau Rasa Coklat', 'Basah', 5, 26000, 46, 1),
(111, 'canceled', 31, 'Griya Bakpia Premium 15', 'Kacang Hijau', 'Basah', 5, 40000, 47, 1),
(112, 'canceled', 35, 'Griya Bakpia Premium 15', 'Durian', 'Basah', 5, 40000, 47, 1),
(113, 'canceled', 36, 'Griya Bakpia Premium 15', 'Mix', 'Basah', 5, 42000, 47, 1),
(114, 'canceled', 39, 'Bakpia 465 20', 'Kacang Hijau Rasa Coklat', 'Basah', 5, 26000, 47, 1),
(115, 'payed', 31, 'Griya Bakpia Premium 15', 'Kacang Hijau', 'Basah', 5, 40000, 48, 1),
(116, 'payed', 35, 'Griya Bakpia Premium 15', 'Durian', 'Basah', 5, 40000, 48, 1),
(117, 'payed', 36, 'Griya Bakpia Premium 15', 'Mix', 'Basah', 5, 42000, 48, 1),
(118, 'payed', 39, 'Bakpia 465 20', 'Kacang Hijau Rasa Coklat', 'Basah', 5, 26000, 48, 1);

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
  `user_created_at` datetime DEFAULT NULL,
  `user_updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`user_id`, `user_username`, `user_password`, `user_name`, `user_email`, `user_no_handphone`, `user_role`, `user_created_at`, `user_updated_at`) VALUES
(1, 'bakpia', '123456', 'lol', 'griya@gmail.com', '91823812', 'super_user', '2024-07-25 10:52:24', '2024-09-02 09:07:11'),
(24, 'bakpia2', '123456', 'tes', 'pitek@gmail.com', '2147483647', 'admin', '2024-08-29 11:47:22', '2024-09-09 15:56:55'),
(37, 'bakpia41', '123456', 'wdadaw', 'wadaw@gmail.com', '21474836471321', 'admin', '2024-09-10 10:36:23', '2024-09-11 10:30:46');

-- --------------------------------------------------------

--
-- Struktur dari tabel `variant`
--

DROP TABLE IF EXISTS `variant`;
CREATE TABLE IF NOT EXISTS `variant` (
  `variant_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `variant_product_id` int UNSIGNED NOT NULL,
  `variant_name` varchar(255) NOT NULL,
  `variant_created_at` datetime DEFAULT NULL,
  `variant_updated_at` datetime DEFAULT NULL,
  `variant_deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`variant_id`),
  KEY `fk_variant_product` (`variant_product_id`)
) ENGINE=MyISAM AUTO_INCREMENT=144 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `variant`
--

INSERT INTO `variant` (`variant_id`, `variant_product_id`, `variant_name`, `variant_created_at`, `variant_updated_at`, `variant_deleted_at`) VALUES
(143, 151, 'Mix Keju Coklat', '2024-10-07 11:16:13', NULL, NULL),
(142, 150, 'Aneka Rasa', '2024-10-07 11:14:25', NULL, NULL),
(140, 148, 'Keju', '2024-10-07 11:10:53', NULL, NULL),
(141, 149, 'Coklat', '2024-10-07 11:12:03', NULL, NULL),
(139, 147, 'Telo Ungu', '2024-10-07 11:08:32', NULL, NULL),
(138, 146, 'Kacang Hijau Rasa Coklat', '2024-10-07 11:06:52', NULL, NULL),
(131, 139, 'Kacang Hijau', '2024-10-07 10:44:22', NULL, NULL),
(132, 140, 'Keju', '2024-10-07 10:46:10', NULL, NULL),
(133, 141, 'Coklat', '2024-10-07 10:48:52', NULL, NULL),
(134, 142, 'Durian', '2024-10-07 10:50:43', NULL, NULL),
(135, 143, 'Mix', '2024-10-07 10:52:22', NULL, NULL),
(136, 144, 'Kacang Hijau Original', '2024-10-07 10:56:30', NULL, NULL),
(137, 145, 'Kacang Hijau Rasa Keju', '2024-10-07 11:04:07', NULL, NULL);

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
