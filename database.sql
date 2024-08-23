-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Waktu pembuatan: 23 Agu 2024 pada 03.24
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `auth_user`
--

INSERT INTO `auth_user` (`auth_user_id`, `auth_user_user_id`, `auth_user_username`, `auth_user_token`, `auth_user_date_login`, `auth_user_date_expired`) VALUES
(1, 1, 'bakpia', 'YmFrcGlhMTIzNDU2', '2024-08-23 10:23:56', '2024-08-24 10:23:56'),
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
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
) ENGINE=MyISAM AUTO_INCREMENT=45 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `product`
--

INSERT INTO `product` (`product_id`, `product_name`, `product_price`, `product_category_id`, `product_category_name`, `product_description`, `product_created_at`, `product_updated_at`) VALUES
(41, 'Bakpia 465 Kering  20', 24000, 2, 'Kering', 'coba coba wak', '2024-08-22 16:24:28', NULL),
(42, 'Bakpia 465 Kering  20', 24000, 2, 'Kering', 'coba coba wak', '2024-08-22 16:24:33', NULL),
(43, 'Bakpia 465 Kering  20', 24000, 2, 'Kering', 'coba coba wak', '2024-08-22 16:24:40', NULL),
(44, 'Bakpia 465 Kering  20', 24000, 2, 'Kering', 'coba coba wak', '2024-08-22 16:24:45', NULL),
(39, 'Bakpia 465 20', 26000, 1, 'Basah', 'coba coba wak', '2024-08-22 16:23:27', NULL),
(40, 'Bakpia 465 15', 24000, 1, 'Basah', 'coba coba wak', '2024-08-22 16:23:44', NULL),
(31, 'Griya Bakpia Premium 15', 40000, 1, 'Basah', 'coba coba wak', '2024-08-22 16:20:47', NULL),
(33, 'Griya Bakpia Premium 15', 40000, 1, 'Basah', '\r\nLorem, ipsum dolor sit amet consectetur adipisicing elit. Numquam maiores fuga id. Magnam rerum sunt atque sequi dolores, sit id, voluptas et qui debitis cumque eligendi maiores rem, accusantium nobis!\r\nNecessitatibus dolorem temporibus, recusandae officia soluta beatae, minima repudiandae quis eos nam consectetur! Ipsum beatae voluptas fuga ullam vitae voluptatibus cupiditate blanditiis accusamus. Explicabo cumque odit, quas libero ut sint.\r\nExpedita tenetur incidunt quod assumenda cupiditate exercitationem distinctio veniam, cum quae magni? Ullam cupiditate repudiandae sit, sequi eaque voluptatem vel alias tempora unde! Architecto, tenetur. Delectus quibusdam similique inventore dicta?\r\nMinus, sunt saepe sapiente soluta consequuntur delectus aspernatur esse rerum perferendis dolores, necessitatibus quia possimus praesentium quisquam laboriosam enim placeat sed blanditiis voluptas explicabo dicta, maxime omnis culpa veritatis. Repellendus?\r\nEx cum voluptatem expedita quia ipsam tene', '2024-08-22 16:22:07', '2024-08-23 09:45:36'),
(34, 'Griya Bakpia Premium 15', 40000, 1, 'Basah', 'coba coba wak', '2024-08-22 16:22:20', NULL),
(35, 'Griya Bakpia Premium 15', 40000, 1, 'Basah', 'coba coba wak', '2024-08-22 16:22:24', NULL),
(36, 'Griya Bakpia Premium 15', 42000, 1, 'Basah', 'coba coba wak', '2024-08-22 16:22:36', NULL),
(37, 'Bakpia 465 20', 24000, 1, 'Basah', 'coba coba wak', '2024-08-22 16:23:01', NULL),
(38, 'Bakpia 465 20', 26000, 1, 'Basah', 'coba coba wak', '2024-08-22 16:23:21', NULL);

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
) ENGINE=MyISAM AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `product_stock`
--

INSERT INTO `product_stock` (`product_stock_id`, `product_stock_product_id`, `product_stock_variant_id`, `product_stock_category_id`, `product_stock_stock`, `product_stock_in`, `product_stock_out`) VALUES
(34, 44, 33, 2, 50, 0, 0),
(33, 43, 32, 2, 50, 0, 0),
(32, 42, 31, 2, 50, 0, 0),
(31, 41, 30, 2, 50, 0, 0),
(30, 40, 29, 1, 50, 0, 0),
(29, 39, 28, 1, 35, 0, 15),
(28, 38, 27, 1, 50, 0, 0),
(27, 37, 26, 1, 50, 0, 0),
(26, 36, 25, 1, 35, 0, 15),
(25, 35, 24, 1, 35, 0, 15),
(24, 34, 23, 1, 50, 0, 0),
(21, 31, 20, 1, 35, 0, 15),
(23, 33, 22, 1, 50, 0, 0);

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
) ENGINE=MyISAM AUTO_INCREMENT=42 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `sales_order`
--

INSERT INTO `sales_order` (`sales_order_id`, `sales_order_status`, `sales_order_price`, `sales_order_customer_id`, `sales_order_customer_name`, `sales_order_customer_address`, `sales_order_customer_no_handphone`, `sales_order_date`, `sales_order_proof`) VALUES
(41, 'customer_canceled', 740000, 1, 'noob', 'jkt', '0123313213', '2024-08-23 10:08:03', ''),
(40, 'payed', 740000, 1, 'noob', 'jkt', '0123313213', '2024-08-23 10:07:56', 'customer_40_1724382481_23aa5c03e4df7aee4e04.png'),
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
) ENGINE=MyISAM AUTO_INCREMENT=91 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `sales_product`
--

INSERT INTO `sales_product` (`sales_product_id`, `sales_product_status`, `sales_product_product_id`, `sales_product_product_name`, `sales_product_product_variant`, `sales_product_product_category`, `sales_product_quantity`, `sales_product_price`, `sales_product_order_id`, `sales_product_customer_id`) VALUES
(81, 'confirmed', 36, 'Griya Bakpia Premium 15', 'Mix', 'Basah', 5, 42000, 39, 1),
(80, 'confirmed', 35, 'Griya Bakpia Premium 15', 'Durian', 'Basah', 5, 40000, 39, 1),
(79, 'confirmed', 31, 'Griya Bakpia Premium 15', 'Kacang Hijau', 'Basah', 5, 40000, 39, 1),
(82, 'confirmed', 39, 'Bakpia 465 20', 'Kacang Hijau Rasa Coklat', 'Basah', 5, 26000, 39, 1),
(83, 'payed', 31, 'Griya Bakpia Premium 15', 'Kacang Hijau', 'Basah', 5, 40000, 40, 1),
(84, 'payed', 35, 'Griya Bakpia Premium 15', 'Durian', 'Basah', 5, 40000, 40, 1),
(85, 'payed', 36, 'Griya Bakpia Premium 15', 'Mix', 'Basah', 5, 42000, 40, 1),
(86, 'payed', 39, 'Bakpia 465 20', 'Kacang Hijau Rasa Coklat', 'Basah', 5, 26000, 40, 1),
(87, 'customer_canceled', 31, 'Griya Bakpia Premium 15', 'Kacang Hijau', 'Basah', 5, 40000, 41, 1),
(88, 'customer_canceled', 35, 'Griya Bakpia Premium 15', 'Durian', 'Basah', 5, 40000, 41, 1),
(89, 'customer_canceled', 36, 'Griya Bakpia Premium 15', 'Mix', 'Basah', 5, 42000, 41, 1),
(90, 'customer_canceled', 39, 'Bakpia 465 20', 'Kacang Hijau Rasa Coklat', 'Basah', 5, 26000, 41, 1);

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
) ENGINE=MyISAM AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `variant`
--

INSERT INTO `variant` (`variant_id`, `variant_product_id`, `variant_name`, `variant_created_at`, `variant_updated_at`, `variant_deleted_at`) VALUES
(30, 41, 'Kering Keju', '2024-08-22 16:24:28', NULL, NULL),
(29, 40, 'Telo Ungu', '2024-08-22 16:23:44', NULL, NULL),
(28, 39, 'Kacang Hijau Rasa Coklat', '2024-08-22 16:23:27', NULL, NULL),
(27, 38, 'Kacang Hijau Rasa Keju', '2024-08-22 16:23:21', NULL, NULL),
(26, 37, 'Kacang Hijau Original', '2024-08-22 16:23:01', NULL, NULL),
(25, 36, 'Mix', '2024-08-22 16:22:36', NULL, NULL),
(24, 35, 'Durian', '2024-08-22 16:22:24', NULL, NULL),
(23, 34, 'Coklat', '2024-08-22 16:22:20', NULL, NULL),
(22, 33, 'Keju', '2024-08-22 16:22:07', NULL, NULL),
(20, 31, 'Kacang Hijau', '2024-08-22 16:20:47', NULL, NULL),
(31, 42, 'Kering Coklat', '2024-08-22 16:24:33', NULL, NULL),
(32, 43, 'Kering Aneka Rasa', '2024-08-22 16:24:40', NULL, NULL),
(33, 44, 'Kering Mix Keju Coklat', '2024-08-22 16:24:45', NULL, NULL);

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
