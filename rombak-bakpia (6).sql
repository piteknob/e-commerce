-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Waktu pembuatan: 20 Agu 2024 pada 08.57
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
-- Database: `rombak-bakpia`
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `auth_user`
--

INSERT INTO `auth_user` (`auth_user_id`, `auth_user_user_id`, `auth_user_username`, `auth_user_token`, `auth_user_date_login`, `auth_user_date_expired`) VALUES
(1, 1, 'bakpia', 'YmFrcGlhMTIzNDU2', '2024-08-20 15:55:03', '2024-08-21 15:55:03'),
(2, 2, 'bakpia2', 'YmFrcGlhMjEyMzQ1Ng==', '2024-08-20 15:26:44', '2024-08-21 15:26:44');

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
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `category`
--

INSERT INTO `category` (`category_id`, `category_name`, `category_created_at`, `category_updated_at`, `category_deleted_at`) VALUES
(1, 'Basah', '2024-08-02 06:58:12', NULL, NULL),
(2, 'Kering', '2024-08-06 13:59:15', NULL, NULL);

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
) ENGINE=MyISAM AUTO_INCREMENT=91 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
  `product_created_at` datetime DEFAULT NULL,
  `product_updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`product_id`),
  KEY `fk_product_category` (`product_category_id`)
) ENGINE=MyISAM AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `product`
--

INSERT INTO `product` (`product_id`, `product_name`, `product_price`, `product_category_id`, `product_category_name`, `product_description`, `product_created_at`, `product_updated_at`) VALUES
(6, 'Griya Bakpia Premium 15', 40000, 1, 'Basah', 'Bakpia adalah camilan tradisional yang berasal dari Yogyakarta, Indonesia. Bakpia biasanya berbentuk bulat kecil dengan kulit yang tipis dan renyah, serta memiliki berbagai macam isian yang lezat. Isian bakpia yang paling populer adalah kacang hijau yang manis, tetapi seiring perkembangan zaman, isian bakpia telah bervariasi, mulai dari cokelat, keju, hingga durian. Camilan ini biasanya dinikmati sebagai oleh-oleh khas Yogyakarta dan sering dijadikan teman minum teh atau kopi. Tekstur yang lembut di dalam dengan kulit yang renyah di luar membuat bakpia menjadi camilan yang digemari banyak orang.', '2024-08-08 10:42:20', NULL),
(7, 'Griya Bakpia Premium 15', 40000, 1, 'Basah', 'Bakpia adalah camilan tradisional yang berasal dari Yogyakarta, Indonesia. Bakpia biasanya berbentuk bulat kecil dengan kulit yang tipis dan renyah, serta memiliki berbagai macam isian yang lezat. Isian bakpia yang paling populer adalah kacang hijau yang manis, tetapi seiring perkembangan zaman, isian bakpia telah bervariasi, mulai dari cokelat, keju, hingga durian. Camilan ini biasanya dinikmati sebagai oleh-oleh khas Yogyakarta dan sering dijadikan teman minum teh atau kopi. Tekstur yang lembut di dalam dengan kulit yang renyah di luar membuat bakpia menjadi camilan yang digemari banyak orang.', '2024-08-08 10:43:54', NULL),
(8, 'Griya Bakpia Premium 15', 40000, 1, 'Basah', 'Bakpia adalah camilan tradisional yang berasal dari Yogyakarta, Indonesia. Bakpia biasanya berbentuk bulat kecil dengan kulit yang tipis dan renyah, serta memiliki berbagai macam isian yang lezat. Isian bakpia yang paling populer adalah kacang hijau yang manis, tetapi seiring perkembangan zaman, isian bakpia telah bervariasi, mulai dari cokelat, keju, hingga durian. Camilan ini biasanya dinikmati sebagai oleh-oleh khas Yogyakarta dan sering dijadikan teman minum teh atau kopi. Tekstur yang lembut di dalam dengan kulit yang renyah di luar membuat bakpia menjadi camilan yang digemari banyak orang.', '2024-08-08 10:45:05', NULL),
(9, 'Griya Bakpia Premium 15', 40000, 1, 'Basah', 'Bakpia adalah camilan tradisional yang berasal dari Yogyakarta, Indonesia. Bakpia biasanya berbentuk bulat kecil dengan kulit yang tipis dan renyah, serta memiliki berbagai macam isian yang lezat. Isian bakpia yang paling populer adalah kacang hijau yang manis, tetapi seiring perkembangan zaman, isian bakpia telah bervariasi, mulai dari cokelat, keju, hingga durian. Camilan ini biasanya dinikmati sebagai oleh-oleh khas Yogyakarta dan sering dijadikan teman minum teh atau kopi. Tekstur yang lembut di dalam dengan kulit yang renyah di luar membuat bakpia menjadi camilan yang digemari banyak orang.', '2024-08-08 10:51:50', NULL),
(10, 'Griya Bakpia Premium 15', 42000, 1, 'Basah', 'Bakpia adalah camilan tradisional yang berasal dari Yogyakarta, Indonesia. Bakpia biasanya berbentuk bulat kecil dengan kulit yang tipis dan renyah, serta memiliki berbagai macam isian yang lezat. Isian bakpia yang paling populer adalah kacang hijau yang manis, tetapi seiring perkembangan zaman, isian bakpia telah bervariasi, mulai dari cokelat, keju, hingga durian. Camilan ini biasanya dinikmati sebagai oleh-oleh khas Yogyakarta dan sering dijadikan teman minum teh atau kopi. Tekstur yang lembut di dalam dengan kulit yang renyah di luar membuat bakpia menjadi camilan yang digemari banyak orang.', '2024-08-08 10:52:12', NULL),
(11, 'Bakpia 465 20', 24000, 1, 'Basah', 'Bakpia adalah camilan tradisional yang berasal dari Yogyakarta, Indonesia. Bakpia biasanya berbentuk bulat kecil dengan kulit yang tipis dan renyah, serta memiliki berbagai macam isian yang lezat. Isian bakpia yang paling populer adalah kacang hijau yang manis, tetapi seiring perkembangan zaman, isian bakpia telah bervariasi, mulai dari cokelat, keju, hingga durian. Camilan ini biasanya dinikmati sebagai oleh-oleh khas Yogyakarta dan sering dijadikan teman minum teh atau kopi. Tekstur yang lembut di dalam dengan kulit yang renyah di luar membuat bakpia menjadi camilan yang digemari banyak orang.', '2024-08-08 10:54:57', NULL),
(12, 'Bakpia 465 20', 26000, 1, 'Basah', 'Bakpia adalah camilan tradisional yang berasal dari Yogyakarta, Indonesia. Bakpia biasanya berbentuk bulat kecil dengan kulit yang tipis dan renyah, serta memiliki berbagai macam isian yang lezat. Isian bakpia yang paling populer adalah kacang hijau yang manis, tetapi seiring perkembangan zaman, isian bakpia telah bervariasi, mulai dari cokelat, keju, hingga durian. Camilan ini biasanya dinikmati sebagai oleh-oleh khas Yogyakarta dan sering dijadikan teman minum teh atau kopi. Tekstur yang lembut di dalam dengan kulit yang renyah di luar membuat bakpia menjadi camilan yang digemari banyak orang.', '2024-08-08 10:55:48', NULL),
(13, 'Bakpia 465 20', 26000, 1, 'Basah', 'Bakpia adalah camilan tradisional yang berasal dari Yogyakarta, Indonesia. Bakpia biasanya berbentuk bulat kecil dengan kulit yang tipis dan renyah, serta memiliki berbagai macam isian yang lezat. Isian bakpia yang paling populer adalah kacang hijau yang manis, tetapi seiring perkembangan zaman, isian bakpia telah bervariasi, mulai dari cokelat, keju, hingga durian. Camilan ini biasanya dinikmati sebagai oleh-oleh khas Yogyakarta dan sering dijadikan teman minum teh atau kopi. Tekstur yang lembut di dalam dengan kulit yang renyah di luar membuat bakpia menjadi camilan yang digemari banyak orang.', '2024-08-08 10:55:51', NULL),
(14, 'Bakpia 465 15', 24000, 1, 'Basah', 'Bakpia adalah camilan tradisional yang berasal dari Yogyakarta, Indonesia. Bakpia biasanya berbentuk bulat kecil dengan kulit yang tipis dan renyah, serta memiliki berbagai macam isian yang lezat. Isian bakpia yang paling populer adalah kacang hijau yang manis, tetapi seiring perkembangan zaman, isian bakpia telah bervariasi, mulai dari cokelat, keju, hingga durian. Camilan ini biasanya dinikmati sebagai oleh-oleh khas Yogyakarta dan sering dijadikan teman minum teh atau kopi. Tekstur yang lembut di dalam dengan kulit yang renyah di luar membuat bakpia menjadi camilan yang digemari banyak orang.', '2024-08-08 10:56:31', NULL),
(15, 'Bakpia 465 Kering 20', 24000, 2, 'Kering', 'Bakpia adalah camilan tradisional yang berasal dari Yogyakarta, Indonesia. Bakpia biasanya berbentuk bulat kecil dengan kulit yang tipis dan renyah, serta memiliki berbagai macam isian yang lezat. Isian bakpia yang paling populer adalah kacang hijau yang manis, tetapi seiring perkembangan zaman, isian bakpia telah bervariasi, mulai dari cokelat, keju, hingga durian. Camilan ini biasanya dinikmati sebagai oleh-oleh khas Yogyakarta dan sering dijadikan teman minum teh atau kopi. Tekstur yang lembut di dalam dengan kulit yang renyah di luar membuat bakpia menjadi camilan yang digemari banyak orang.', '2024-08-08 10:57:31', NULL),
(16, 'Bakpia 465 Kering 20', 24000, 2, 'Kering', 'Bakpia adalah camilan tradisional yang berasal dari Yogyakarta, Indonesia. Bakpia biasanya berbentuk bulat kecil dengan kulit yang tipis dan renyah, serta memiliki berbagai macam isian yang lezat. Isian bakpia yang paling populer adalah kacang hijau yang manis, tetapi seiring perkembangan zaman, isian bakpia telah bervariasi, mulai dari cokelat, keju, hingga durian. Camilan ini biasanya dinikmati sebagai oleh-oleh khas Yogyakarta dan sering dijadikan teman minum teh atau kopi. Tekstur yang lembut di dalam dengan kulit yang renyah di luar membuat bakpia menjadi camilan yang digemari banyak orang.', '2024-08-08 10:57:39', NULL),
(17, 'Bakpia 465 Kering 20', 24000, 2, 'Kering', 'Bakpia adalah camilan tradisional yang berasal dari Yogyakarta, Indonesia. Bakpia biasanya berbentuk bulat kecil dengan kulit yang tipis dan renyah, serta memiliki berbagai macam isian yang lezat. Isian bakpia yang paling populer adalah kacang hijau yang manis, tetapi seiring perkembangan zaman, isian bakpia telah bervariasi, mulai dari cokelat, keju, hingga durian. Camilan ini biasanya dinikmati sebagai oleh-oleh khas Yogyakarta dan sering dijadikan teman minum teh atau kopi. Tekstur yang lembut di dalam dengan kulit yang renyah di luar membuat bakpia menjadi camilan yang digemari banyak orang.', '2024-08-08 10:57:56', NULL),
(29, 'Bakpia 465 Kering 20', 24000, 2, 'Kering', 'coba coba wak', '2024-08-20 15:55:03', NULL);

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
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `product_stock`
--

INSERT INTO `product_stock` (`product_stock_id`, `product_stock_product_id`, `product_stock_variant_id`, `product_stock_category_id`, `product_stock_stock`, `product_stock_in`, `product_stock_out`) VALUES
(1, 6, 1, 1, 100, 5, 5),
(2, 7, 2, 1, 100, 0, 0),
(3, 8, 3, 1, 10, 0, 90),
(4, 9, 4, 1, 10, 0, 90),
(5, 10, 5, 1, 100, 0, 0),
(6, 11, 6, 1, 100, 0, 0),
(7, 12, 7, 1, 100, 0, 0),
(8, 13, 8, 1, 100, 0, 0),
(9, 14, 9, 1, 100, 0, 0),
(10, 15, 10, 2, 100, 0, 0),
(11, 16, 11, 2, 100, 0, 0),
(12, 17, 14, 2, 100, 0, 0),
(19, 29, 17, 2, 50, 0, 0);

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
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `sales_order`
--

INSERT INTO `sales_order` (`sales_order_id`, `sales_order_status`, `sales_order_price`, `sales_order_customer_id`, `sales_order_customer_name`, `sales_order_customer_address`, `sales_order_customer_no_handphone`, `sales_order_date`, `sales_order_proof`) VALUES
(3, 'confirmed', 400000, 1, 'noob', 'jkt', '0123313213', '0000-00-00 00:00:00', '0'),
(4, 'customer_canceled', 400000, 1, 'noob', 'jkt', '0123313213', '0000-00-00 00:00:00', '0'),
(5, 'customer_canceled', 400000, 1, 'noob', 'jkt', '0123313213', '0000-00-00 00:00:00', '0'),
(6, 'customer_canceled', 400000, 1, 'noob', 'jkt', '0123313213', '0000-00-00 00:00:00', '0'),
(7, 'customer_canceled', 400000, 1, 'noob', 'jkt', '0123313213', '0000-00-00 00:00:00', '0'),
(8, 'customer_canceled', 400000, 1, 'noob', 'jkt', '0123313213', '0000-00-00 00:00:00', '0'),
(9, 'customer_canceled', 400000, 1, 'noob', 'jkt', '0123313213', '0000-00-00 00:00:00', '0'),
(10, 'customer_canceled', 400000, 1, 'noob', 'jkt', '0123313213', '0000-00-00 00:00:00', '0'),
(11, 'customer_canceled', 400000, 1, 'noob', 'jkt', '0123313213', '0000-00-00 00:00:00', '0'),
(12, 'confirmed', 400000, 1, 'noob', 'jkt', '0123313213', '0000-00-00 00:00:00', 'customer_12_1723192672_ab37ef6331e3c2c47b64.png'),
(13, 'canceled', 400000, 1, 'noob', 'jkt', '0123313213', '0000-00-00 00:00:00', 'customer_13_1723430002_57c7bbc47f02ab32cbd0.png'),
(14, 'canceled', 400000, 1, 'noob', 'jkt', '0123313213', '0000-00-00 00:00:00', 'customer_14_1723517375_5a7ee3d155899f8bb64b.png'),
(15, 'customer_canceled', 400000, 1, 'noob', 'jkt', '0123313213', '0000-00-00 00:00:00', ''),
(16, 'confirmed', 400000, 1, 'noob', 'jkt', '0123313213', '0000-00-00 00:00:00', 'customer_16_1723517479_201041237b473889e4ff.png'),
(17, 'confirmed', 400000, 1, 'noob', 'jkt', '0123313213', '0000-00-00 00:00:00', 'customer_17_1723517624_0086347a8b83abc41f6e.png'),
(18, 'confirmed', 400000, 1, 'noob', 'jkt', '0123313213', '0000-00-00 00:00:00', 'customer_18_1723517841_ed01b334adb5cdfcfb33.png'),
(19, 'confirmed', 400000, 1, 'noob', 'jkt', '0123313213', '0000-00-00 00:00:00', 'customer_19_1723518132_10ebe77e03c243a01be4.png'),
(20, 'confirmed', 400000, 1, 'noob', 'jkt', '0123313213', '0000-00-00 00:00:00', 'customer_20_1723518224_37ee161ba5adc08b9fa7.png'),
(21, 'confirmed', 400000, 1, 'noob', 'jkt', '0123313213', '0000-00-00 00:00:00', 'customer_21_1723518301_3ac8af8915ee5152f0e2.png'),
(22, 'confirmed', 400000, 1, 'noob', 'jkt', '0123313213', '0000-00-00 00:00:00', 'customer_22_1723518367_4ac2a7421c9695d24e0a.png'),
(23, 'confirmed', 400000, 1, 'noob', 'jkt', '0123313213', '0000-00-00 00:00:00', 'customer_23_1723518640_1047b5ecaf3e8aafd6a9.png'),
(24, 'confirmed', 400000, 1, 'noob', 'jkt', '0123313213', '0000-00-00 00:00:00', 'customer_24_1723518674_bd464bf63b8f080ad140.png'),
(26, 'confirmed', 400000, 1, 'noob', 'jkt', '0123313213', '2024-08-16 10:45:27', 'customer_26_1723692853_b6c9d9927581ca5d1d07.png'),
(27, 'payed', 400000, 1, 'noob', 'jkt', '0123313213', '2024-08-16 10:45:37', 'customer_27_1723779028_0c863dea79df8c17d01d.png'),
(28, 'canceled', 400000, 1, 'noob', 'jkt', '0123313213', '2024-08-16 10:45:41', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sales_product`
--

DROP TABLE IF EXISTS `sales_product`;
CREATE TABLE IF NOT EXISTS `sales_product` (
  `sales_product_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `sales_product_status` enum('pending','payed','confirmed','canceled','customer_canceled','break') NOT NULL,
  `sales_product_product_name` varchar(255) NOT NULL,
  `sales_product_product_variant` varchar(255) NOT NULL,
  `sales_product_product_category` varchar(255) NOT NULL,
  `sales_product_product_box` int NOT NULL,
  `sales_product_quantity` int NOT NULL,
  `sales_product_price` int NOT NULL,
  `sales_product_order_id` int UNSIGNED NOT NULL,
  `sales_product_customer_id` int UNSIGNED NOT NULL,
  PRIMARY KEY (`sales_product_id`),
  KEY `fk_sales_product_customer` (`sales_product_customer_id`),
  KEY `fk_sales_product_sales_order` (`sales_product_order_id`)
) ENGINE=MyISAM AUTO_INCREMENT=55 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `sales_product`
--

INSERT INTO `sales_product` (`sales_product_id`, `sales_product_status`, `sales_product_product_name`, `sales_product_product_variant`, `sales_product_product_category`, `sales_product_product_box`, `sales_product_quantity`, `sales_product_price`, `sales_product_order_id`, `sales_product_customer_id`) VALUES
(4, 'confirmed', 'Griya Bakpia Premium', 'Durian', 'Kering', 15, 5, 40000, 3, 1),
(3, 'confirmed', 'Griya Bakpia Premium', 'Coklat', 'Kering', 15, 5, 40000, 3, 1),
(5, 'customer_canceled', 'Griya Bakpia Premium', 'Coklat', 'Kering', 15, 5, 40000, 4, 1),
(6, 'customer_canceled', 'Griya Bakpia Premium', 'Durian', 'Kering', 15, 5, 40000, 4, 1),
(7, 'customer_canceled', 'Griya Bakpia Premium', 'Coklat', 'Kering', 15, 5, 40000, 5, 1),
(8, 'customer_canceled', 'Griya Bakpia Premium', 'Durian', 'Kering', 15, 5, 40000, 5, 1),
(9, 'customer_canceled', 'Griya Bakpia Premium', 'Coklat', 'Kering', 15, 5, 40000, 6, 1),
(10, 'customer_canceled', 'Griya Bakpia Premium', 'Durian', 'Kering', 15, 5, 40000, 6, 1),
(11, 'customer_canceled', 'Griya Bakpia Premium', 'Coklat', 'Kering', 15, 5, 40000, 7, 1),
(12, 'customer_canceled', 'Griya Bakpia Premium', 'Durian', 'Kering', 15, 5, 40000, 7, 1),
(13, 'customer_canceled', 'Griya Bakpia Premium', 'Coklat', 'Kering', 15, 5, 40000, 8, 1),
(14, 'customer_canceled', 'Griya Bakpia Premium', 'Durian', 'Kering', 15, 5, 40000, 8, 1),
(15, 'customer_canceled', 'Griya Bakpia Premium', 'Coklat', 'Kering', 15, 5, 40000, 9, 1),
(16, 'customer_canceled', 'Griya Bakpia Premium', 'Durian', 'Kering', 15, 5, 40000, 9, 1),
(17, 'customer_canceled', 'Griya Bakpia Premium', 'Coklat', 'Kering', 15, 5, 40000, 10, 1),
(18, 'customer_canceled', 'Griya Bakpia Premium', 'Durian', 'Kering', 15, 5, 40000, 10, 1),
(19, 'customer_canceled', 'Griya Bakpia Premium', 'Coklat', 'Kering', 15, 5, 40000, 11, 1),
(20, 'customer_canceled', 'Griya Bakpia Premium', 'Durian', 'Kering', 15, 5, 40000, 11, 1),
(21, 'confirmed', 'Griya Bakpia Premium', 'Coklat', 'Kering', 15, 5, 40000, 12, 1),
(22, 'confirmed', 'Griya Bakpia Premium', 'Durian', 'Kering', 15, 5, 40000, 12, 1),
(23, 'canceled', 'Griya Bakpia Premium', 'Coklat', 'Kering', 15, 5, 40000, 13, 1),
(24, 'canceled', 'Griya Bakpia Premium', 'Durian', 'Kering', 15, 5, 40000, 13, 1),
(25, 'canceled', 'Griya Bakpia Premium', 'Coklat', 'Kering', 15, 5, 40000, 14, 1),
(26, 'canceled', 'Griya Bakpia Premium', 'Durian', 'Kering', 15, 5, 40000, 14, 1),
(27, 'customer_canceled', 'Griya Bakpia Premium', 'Coklat', 'Kering', 15, 5, 40000, 15, 1),
(28, 'customer_canceled', 'Griya Bakpia Premium', 'Durian', 'Kering', 15, 5, 40000, 15, 1),
(29, 'confirmed', 'Griya Bakpia Premium', 'Coklat', 'Kering', 15, 5, 40000, 16, 1),
(30, 'confirmed', 'Griya Bakpia Premium', 'Durian', 'Kering', 15, 5, 40000, 16, 1),
(31, 'confirmed', 'Griya Bakpia Premium', 'Coklat', 'Kering', 15, 5, 40000, 17, 1),
(32, 'confirmed', 'Griya Bakpia Premium', 'Durian', 'Kering', 15, 5, 40000, 17, 1),
(33, 'confirmed', 'Griya Bakpia Premium', 'Coklat', 'Kering', 15, 5, 40000, 18, 1),
(34, 'confirmed', 'Griya Bakpia Premium', 'Durian', 'Kering', 15, 5, 40000, 18, 1),
(35, 'confirmed', 'Griya Bakpia Premium', 'Coklat', 'Kering', 15, 5, 40000, 19, 1),
(36, 'confirmed', 'Griya Bakpia Premium', 'Durian', 'Kering', 15, 5, 40000, 19, 1),
(37, 'confirmed', 'Griya Bakpia Premium', 'Coklat', 'Kering', 15, 5, 40000, 20, 1),
(38, 'confirmed', 'Griya Bakpia Premium', 'Durian', 'Kering', 15, 5, 40000, 20, 1),
(39, 'confirmed', 'Griya Bakpia Premium', 'Coklat', 'Kering', 15, 5, 40000, 21, 1),
(40, 'confirmed', 'Griya Bakpia Premium', 'Durian', 'Kering', 15, 5, 40000, 21, 1),
(41, 'confirmed', 'Griya Bakpia Premium', 'Coklat', 'Kering', 15, 5, 40000, 22, 1),
(42, 'confirmed', 'Griya Bakpia Premium', 'Durian', 'Kering', 15, 5, 40000, 22, 1),
(43, 'confirmed', 'Griya Bakpia Premium', 'Coklat', 'Kering', 15, 5, 40000, 23, 1),
(44, 'confirmed', 'Griya Bakpia Premium', 'Durian', 'Kering', 15, 5, 40000, 23, 1),
(45, 'confirmed', 'Griya Bakpia Premium', 'Coklat', 'Kering', 15, 5, 40000, 24, 1),
(46, 'confirmed', 'Griya Bakpia Premium', 'Durian', 'Kering', 15, 5, 40000, 24, 1),
(47, 'pending', 'Griya Bakpia Premium', 'Coklat', 'Kering', 15, 5, 40000, 25, 1),
(48, 'pending', 'Griya Bakpia Premium', 'Durian', 'Kering', 15, 5, 40000, 25, 1),
(49, 'confirmed', 'Griya Bakpia Premium', 'Coklat', 'Kering', 15, 5, 40000, 26, 1),
(50, 'confirmed', 'Griya Bakpia Premium', 'Durian', 'Kering', 15, 5, 40000, 26, 1),
(51, 'payed', 'Griya Bakpia Premium', 'Coklat', 'Kering', 15, 5, 40000, 27, 1),
(52, 'payed', 'Griya Bakpia Premium', 'Durian', 'Kering', 15, 5, 40000, 27, 1),
(53, 'canceled', 'Griya Bakpia Premium', 'Coklat', 'Kering', 15, 5, 40000, 28, 1),
(54, 'canceled', 'Griya Bakpia Premium', 'Durian', 'Kering', 15, 5, 40000, 28, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `user_password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `user_name` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `user_email` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `user_no_handphone` int DEFAULT NULL,
  `user_role` enum('super_user','admin') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `user_created_at` datetime DEFAULT NULL,
  `user_updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`user_id`, `user_username`, `user_password`, `user_name`, `user_email`, `user_no_handphone`, `user_role`, `user_created_at`, `user_updated_at`) VALUES
(1, 'bakpia', '123456', 'speed', 'speed@gmail.com', 8241442, 'super_user', '2024-07-25 10:52:24', NULL),
(2, 'bakpia2', '123456', 'kai cenat', 'kai@gmail.com', 8569432, 'admin', '2024-07-26 10:52:28', NULL);

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
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `variant`
--

INSERT INTO `variant` (`variant_id`, `variant_product_id`, `variant_name`, `variant_created_at`, `variant_updated_at`, `variant_deleted_at`) VALUES
(1, 6, 'Kacang Hijau', '2024-08-07 14:05:46', NULL, NULL),
(2, 7, 'Keju', '2024-08-07 14:06:24', NULL, NULL),
(3, 8, 'Coklat', '2024-08-07 14:10:32', NULL, NULL),
(4, 9, 'Durian', '2024-08-07 14:10:55', NULL, NULL),
(5, 10, 'Mix', '2024-08-07 14:10:58', NULL, NULL),
(6, 11, 'Kacang Hijau Originial', '2024-08-07 14:25:02', NULL, NULL),
(7, 12, 'Kacang Hijau Rasa Keju', '2024-08-07 14:29:01', NULL, NULL),
(8, 13, 'Kacang Hijau Rasa Coklat', '2024-08-07 14:29:13', NULL, NULL),
(9, 14, 'Telo Ungu', '2024-08-07 14:29:21', NULL, NULL),
(10, 15, 'Keju', '2024-08-07 14:29:35', NULL, NULL),
(11, 16, 'Coklat', '2024-08-07 14:29:45', NULL, NULL),
(14, 17, 'Aneka Rasa', '2024-08-20 13:25:25', NULL, NULL),
(17, 29, 'mix Keju Coklat', '2024-08-20 15:55:03', NULL, NULL);

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
