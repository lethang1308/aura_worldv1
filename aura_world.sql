-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 01, 2025 at 05:23 AM
-- Server version: 8.0.30
-- PHP Version: 8.2.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `aura_world`
--

-- --------------------------------------------------------

--
-- Table structure for table `attributes`
--

CREATE TABLE `attributes` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `attributes`
--

INSERT INTO `attributes` (`id`, `name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(4, 'Hương thơm', NULL, '2025-07-20 10:18:01', '2025-07-20 10:18:01'),
(7, 'Dung tích', '2025-07-20 10:18:46', '2025-07-20 10:18:46', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `attributes_values`
--

CREATE TABLE `attributes_values` (
  `id` bigint UNSIGNED NOT NULL,
  `attribute_id` bigint UNSIGNED NOT NULL,
  `value` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `attributes_values`
--

INSERT INTO `attributes_values` (`id`, `attribute_id`, `value`, `created_at`, `updated_at`, `deleted_at`) VALUES
(11, 7, '50ml', '2025-07-20 10:18:46', '2025-07-20 10:18:46', NULL),
(12, 7, '100ml', '2025-07-20 10:18:46', '2025-07-20 10:18:46', NULL),
(13, 7, '200ml', '2025-07-20 10:18:46', '2025-07-20 10:18:46', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `banners`
--

CREATE TABLE `banners` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `sort_order` int NOT NULL DEFAULT '0',
  `type` enum('main','secondary') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'main',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`id`, `name`, `logo`, `description`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(3, 'Afnan', 'storage/brands/gpJ1W65pSe2VtGOGx9ZyKh3wzyzyQ3w8A1uFJPDn.jpg', NULL, 'active', '2025-07-19 10:52:26', '2025-07-19 10:52:26', NULL),
(4, 'Dior', 'storage/brands/MWLpQ0wmMyqpMnsZSW5NDwsKAaKTNQFRtcN4kLcA.jpg', NULL, 'active', '2025-07-19 10:53:57', '2025-07-19 10:53:57', NULL),
(5, 'Chanel', 'storage/brands/seaLhlJVqWETxw5gLUmPvGsIu7jsDSvNEwZGhLpJ.png', 'Chanel', 'active', '2025-07-19 11:08:55', '2025-07-19 11:08:55', NULL),
(6, 'Tom Ford', 'storage/brands/dhQ8eKJHNaTBx2bX0vJQzA86LATV4zkTJ5gOva9i.png', 'Tom Ford', 'active', '2025-07-19 11:15:48', '2025-07-19 11:15:48', NULL),
(8, 'Armaf', 'storage/brands/kW3nndkTCgXaxWl2LZGhzbcDnz0SG53cKc9PAWty.webp', 'Hãng Armaf', 'active', '2025-07-31 20:16:19', '2025-07-31 20:16:19', NULL),
(9, 'Burberry', 'storage/brands/SnThnadeCpwzA16Xfo8pTQYd4keEl99ct68NbCv0.jpg', 'Burberry', 'active', '2025-07-31 20:23:21', '2025-07-31 20:23:21', NULL),
(10, 'Gucci', 'storage/brands/JGqQeyl9L8x03k49NNp5Aal1Wb76KfkcLuIxOsny.webp', NULL, 'active', '2025-07-31 20:26:40', '2025-07-31 20:26:40', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `total_quantity` int DEFAULT NULL,
  `total_price` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `total_quantity`, `total_price`, `created_at`, `updated_at`) VALUES
(29, 10, 1, 1000000, '2025-07-26 19:54:20', '2025-07-26 19:54:20'),
(37, 2, 2, 5000246, '2025-07-26 22:28:34', '2025-07-26 23:26:21'),
(82, 13, 0, 0, '2025-07-31 21:34:01', '2025-07-31 21:34:55');

-- --------------------------------------------------------

--
-- Table structure for table `cart_items`
--

CREATE TABLE `cart_items` (
  `id` bigint UNSIGNED NOT NULL,
  `cart_id` bigint UNSIGNED NOT NULL,
  `variant_id` bigint UNSIGNED NOT NULL,
  `quantity` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint UNSIGNED NOT NULL,
  `category_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent_category_id` bigint UNSIGNED DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category_name`, `parent_category_id`, `description`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Nước hoa nam', NULL, NULL, '1', NULL, NULL, NULL),
(3, 'Nước hoa nữ', NULL, NULL, '1', NULL, '2025-07-18 00:28:53', NULL),
(5, 'Nước hoa nam EDP', 1, NULL, '1', '2025-07-17 09:14:30', '2025-07-18 07:16:08', NULL),
(9, 'Nước hoa nữ EDP', 3, NULL, '1', '2025-07-17 09:21:39', '2025-07-17 09:21:39', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Hà Nội', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

CREATE TABLE `coupons` (
  `id` bigint UNSIGNED NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('percent','fixed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'fixed',
  `value` decimal(10,2) NOT NULL,
  `min_order_value` decimal(10,2) DEFAULT NULL,
  `max_discount` decimal(10,2) DEFAULT NULL,
  `start_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  `usage_limit` int DEFAULT NULL,
  `used` int NOT NULL DEFAULT '0',
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `coupons`
--

INSERT INTO `coupons` (`id`, `code`, `type`, `value`, `min_order_value`, `max_discount`, `start_date`, `end_date`, `usage_limit`, `used`, `status`, `description`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'GIAM10%', 'percent', 10.00, 500000.00, NULL, '2025-07-25 00:00:00', '2026-12-06 00:00:00', 20, 0, 'active', 'Giảm 10% cho đơn hàng từ 500.000', '2025-07-24 17:52:37', '2025-07-24 17:52:37', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `districts`
--

CREATE TABLE `districts` (
  `id` bigint UNSIGNED NOT NULL,
  `city_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `districts`
--

INSERT INTO `districts` (`id`, `city_id`, `name`, `created_at`, `updated_at`) VALUES
(1, 1, 'Ba Đình', NULL, NULL),
(2, 1, 'Hoàn Kiếm', NULL, NULL),
(3, 1, 'Đống Đa', NULL, NULL),
(4, 1, 'Hai Bà Trưng', NULL, NULL),
(5, 1, 'Cầu Giấy', NULL, NULL),
(6, 1, 'Thanh Xuân', NULL, NULL),
(7, 1, 'Hoàng Mai', NULL, NULL),
(8, 1, 'Long Biên', NULL, NULL),
(9, 1, 'Tây Hồ', NULL, NULL),
(10, 1, 'Hà Đông', NULL, NULL),
(11, 1, 'Bắc Từ Liêm', NULL, NULL),
(12, 1, 'Nam Từ Liêm', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2025_07_18_140315_add_soft_deletes_to_customers_table', 1),
(2, '2025_07_18_140332_add_soft_deletes_to_attributes_table', 2),
(3, '2025_07_18_140332_add_soft_deletes_to_categories_table', 3),
(4, '2025_07_18_140338_add_soft_deletes_to_attribute_values_table', 4),
(5, '2025_07_19_000000_create_brands_table', 5),
(6, '2025_07_19_000001_add_brand_id_to_products_table', 6),
(7, '2025_07_19_190353_create_otp_codes_table', 7),
(8, '2025_07_20_093437_add_soft_deletes_to_products_table', 8),
(9, '2025_07_20_093450_add_soft_deletes_to_brands_table', 9),
(10, '2025_07_21_132843_add_google_id_to_users_table', 10),
(11, '2025_07_22_083916_create_reviews_table', 11),
(12, '2025_07_22_120230_add_cancel_reason_and_cancelled_by_admin_id_to_orders_table', 12),
(13, '2025_07_23_134852_create_coupons_table', 13),
(14, '2025_07_27_225840_add_discount_to_orders_table', 14),
(15, '2025_07_29_035725_add_shipper_id_to_orders_table', 15),
(16, '2025_07_30_105556_create_banners_table', 16),
(17, '2025_01_15_000000_add_type_to_banners_table', 17);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `user_email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_note` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `cancel_reason` text COLLATE utf8mb4_unicode_ci,
  `cancelled_by_admin_id` bigint UNSIGNED DEFAULT NULL,
  `status_order` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `shipper_id` bigint UNSIGNED DEFAULT NULL,
  `status_payment` varchar(55) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'unpaid',
  `type_payment` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_price` decimal(15,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `discount` int NOT NULL DEFAULT '0',
  `coupon_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `id` bigint UNSIGNED NOT NULL,
  `order_id` bigint UNSIGNED NOT NULL,
  `variant_id` bigint UNSIGNED NOT NULL,
  `variant_price` decimal(15,2) NOT NULL,
  `quantity` int NOT NULL,
  `total_price` decimal(15,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `otp_codes`
--

CREATE TABLE `otp_codes` (
  `id` bigint UNSIGNED NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `otp` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expires_at` timestamp NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `otp_codes`
--

INSERT INTO `otp_codes` (`id`, `email`, `otp`, `expires_at`, `created_at`, `updated_at`) VALUES
(2, 'tung565025@gmail.com', '395482', '2025-07-19 12:42:47', '2025-07-19 12:30:15', '2025-07-19 12:32:47');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` bigint UNSIGNED NOT NULL,
  `order_id` bigint UNSIGNED NOT NULL,
  `payment_method` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_date` timestamp NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_transactions`
--

CREATE TABLE `payment_transactions` (
  `id` bigint UNSIGNED NOT NULL,
  `payment_id` bigint UNSIGNED NOT NULL,
  `order_id` bigint UNSIGNED NOT NULL,
  `gateway` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `transaction_status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `currency` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `transaction_date` timestamp NOT NULL,
  `response_transaction` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint UNSIGNED NOT NULL,
  `brand_id` bigint UNSIGNED DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `category_id` bigint UNSIGNED NOT NULL,
  `base_price` int NOT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `brand_id`, `name`, `description`, `category_id`, `base_price`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(6, 3, 'Afnan 9AM EDP', 'Hương thơm tươi mát, ngọt ngào và dễ chịu, phù hợp để dùng hàng ngày, đi làm, đi học hay dạo phố lúc sáng sớm.', 5, 1000000, 'active', '2025-07-18 22:38:00', '2025-07-24 22:55:04', NULL),
(8, 4, 'Dior Homme Intense EDP', 'Hương thơm nam tính và gợi cảm, hoàn hảo cho những buổi tối lãng mạn và sự kiện trang trọng.', 5, 2000000, 'active', '2025-07-19 10:54:40', '2025-07-19 10:54:40', NULL),
(9, 4, 'Dior Sauvage EDP', 'Hương thơm nam tính và ấm áp, lý tưởng cho những buổi tối lãng mạn.', 5, 2200000, 'active', '2025-07-19 10:55:54', '2025-07-19 10:55:54', NULL),
(10, 4, 'Dior J’adore EDP', 'Hương thơm nữ tính và thanh lịch, lý tưởng cho cả ngày làm việc và các buổi tiệc tối sang trọng.', 9, 2500000, 'active', '2025-07-19 10:56:52', '2025-07-19 10:56:52', NULL),
(11, 4, 'Dior Miss Dior Blooming Bouquet EDT', 'Hương thơm của quả mơ, hoa mẫu đơn và xạ hương, tạo nên một phong cách tươi trẻ, ngọt ngào, lý tưởng cho những ngày xuân và các buổi dạo phố nhẹ nhàng.', 9, 2000000, 'active', '2025-07-19 10:58:13', '2025-07-19 10:58:13', NULL),
(12, 4, 'Dior J’adore Infinissime EDP', 'Hương thơm của hoa nhài, hoa hồng và gỗ đàn hương, tạo nên một phong cách quyến rũ, nữ tính và đầy thanh lịch, lý tưởng cho những buổi tối sang trọng.', 9, 2300000, 'active', '2025-07-19 11:02:03', '2025-07-19 11:02:03', NULL),
(13, 3, 'Afnan Supremacy Silver EDP', 'Hương thơm nam tính và tinh tế, lý tưởng cho cả ngày làm việc và các buổi tiệc tối.', 5, 800000, 'active', '2025-07-19 11:06:03', '2025-07-19 11:06:03', NULL),
(14, 5, 'Chanel Coco Mademoiselle EDP Intense', 'Hương thơm sâu lắng và quyến rũ, lý tưởng cho những buổi tối sang trọng và các dịp đặc biệt.', 9, 1700000, 'active', '2025-07-19 11:10:01', '2025-07-19 11:10:01', NULL),
(15, 5, 'Chanel Chance EDP', 'Hương thơm sang trọng, cuốn hút, lý tưởng cho những buổi tiệc tối và các sự kiện quan trọng.', 9, 2500000, 'active', '2025-07-19 11:11:09', '2025-07-19 11:11:09', NULL),
(16, 5, 'Chanel Allure Homme Sport Eau Extreme EDP', 'Hương thơm mạnh mẽ và sảng khoái, lý tưởng cho những người đàn ông năng động và thích phiêu lưu.', 5, 2400000, 'active', '2025-07-19 11:12:13', '2025-07-19 11:12:13', NULL),
(17, 5, 'Chanel Allure Homme Sport EDT', 'Hương thơm năng động và tươi mát, lý tưởng cho những ngày hè và các hoạt động thể thao.', 5, 2300000, 'active', '2025-07-19 11:13:45', '2025-07-19 11:13:45', NULL),
(18, 5, 'Chanel Bleu De Chanel Parfum', 'Hương thơm nam tính và sang trọng, lý tưởng cho những dịp quan trọng và buổi tối trang trọng.', 5, 2600000, 'active', '2025-07-19 11:14:55', '2025-07-19 11:14:55', NULL),
(19, 6, 'Tom Ford Black Orchid Parfum', 'Hương thơm của nấm truýp, ylang-ylang và mận đen, tạo nên một phong cách sang trọng, gợi cảm và đầy bí ẩn, lý tưởng cho những buổi tối lãng mạn.', 5, 2700000, 'active', '2025-07-19 11:17:50', '2025-07-19 11:17:50', NULL),
(20, 6, 'Tom Ford Tobacco Vanille EDP', 'Hương thơm ấm áp và gợi cảm, lý tưởng cho những buổi tối lãng mạn và các sự kiện quan trọng.', 5, 3000000, 'active', '2025-07-19 11:18:42', '2025-07-19 11:18:42', NULL),
(21, 6, 'Tom Ford Noir Extreme EDP', 'Hương thơm đậm đà, sang trọng, lý tưởng cho những buổi tối quyến rũ và các sự kiện đẳng cấp.', 5, 2800000, 'active', '2025-07-19 11:19:50', '2025-07-19 11:19:50', NULL),
(22, 6, 'Tom Ford Black Orchid EDP', 'Mùi hương quyến rũ, đầy bí ẩn và sang trọng, thích hợp cho những buổi tiệc tối và sự kiện đặc biệt.', 5, 2500000, 'active', '2025-07-19 11:21:02', '2025-07-19 11:40:43', NULL),
(24, 8, 'Armaf Club De Nuit Intense Man EDT', 'Hương thơm nam tính và mạnh mẽ, lý tưởng cho các buổi tiệc tối và những dịp quan trọng.', 5, 880000, 'active', '2025-07-31 20:18:10', '2025-07-31 20:18:10', NULL),
(25, 8, 'Armaf Ventana EDP', 'Hương thơm tươi mát, sảng khoái, lý tưởng cho những ngày dạo phố và các buổi gặp gỡ bạn bè.', 5, 680000, 'active', '2025-07-31 20:19:46', '2025-07-31 20:19:46', NULL),
(26, 8, 'Armaf Club De Nuit Woman EDP', 'Hương thơm sang trọng và quyến rũ, lý tưởng cho các buổi tiệc tối và những dịp đặc biệt.', 9, 780000, 'active', '2025-07-31 20:20:49', '2025-07-31 20:20:49', NULL),
(27, 8, 'Armaf Club De Nuit Intense Man Parfum', 'Hương thơm đầy mạnh mẽ, nam tính, lý tưởng cho những buổi tiệc tối sang trọng và những dịp đặc biệt.', 5, 1480000, 'active', '2025-07-31 20:22:21', '2025-07-31 20:22:21', NULL),
(28, 9, 'Burberry Her EDP', 'Hương thơm ngọt ngào và tươi mát, lý tưởng cho các buổi hẹn hò và những ngày dạo phố cùng bạn bè.', 9, 2280000, 'active', '2025-07-31 20:24:24', '2025-07-31 20:24:24', NULL),
(29, 9, 'Burberry London For Women EDP', 'Hương thơm của hoa hồng, kim ngân và gỗ đàn hương, tạo nên một phong cách thanh lịch, quyến rũ và đầy nữ tính.', 9, 1000000, 'active', '2025-07-31 20:25:28', '2025-07-31 20:57:03', NULL),
(30, 10, 'Gucci Bloom EDP', 'Hương thơm thanh khiết và nữ tính, lý tưởng cho những buổi hẹn hò lãng mạn và các dịp đặc biệt.', 9, 2000000, 'active', '2025-07-31 20:27:42', '2025-07-31 20:56:50', NULL),
(31, 10, 'Gucci Bloom Ambrosia Di Fiori EDP', 'Hương thơm thanh khiết và nữ tính, lý tưởng cho những buổi hẹn hò lãng mạn và các dịp đặc biệt.', 9, 2000000, 'active', '2025-07-31 20:29:03', '2025-07-31 20:56:38', NULL),
(32, 10, 'Gucci Flora Gorgeous Gardenia EDP', 'Hương thơm ngọt ngào và nữ tính, lý tưởng cho các buổi hẹn hò lãng mạn và những dịp đặc biệt.', 9, 2000000, 'active', '2025-07-31 20:29:58', '2025-07-31 20:56:29', NULL),
(33, 10, 'Gucci Guilty Pour Homme EDT', 'Hương thơm của chanh, oải hương và hoắc hương, tạo nên một phong cách thanh lịch, mạnh mẽ và đầy cuốn hút, lý tưởng cho những dịp tối.', 5, 1200000, 'active', '2025-07-31 20:31:02', '2025-07-31 20:56:16', NULL),
(34, 10, 'Gucci Guilty Pour Homme EDP', 'Hương thơm của cam Bergamot, hoa oải hương và gỗ tuyết tùng, tạo nên một phong cách sâu lắng, nồng nàn và đầy nam tính, lý tưởng cho những buổi tối lãng mạn.', 5, 1500000, 'active', '2025-07-31 20:31:42', '2025-07-31 20:55:58', NULL),
(35, 10, 'Gucci Guilty Black Pour Femme EDT', 'Hương thơm của quả mọng đỏ, hồ tiêu hồng và hoắc hương, tạo nên một phong cách quyến rũ, mạnh mẽ và đầy bí ẩn, lý tưởng cho những buổi tối sôi động và các sự kiện đặc biệt.', 5, 2000000, 'active', '2025-07-31 20:32:28', '2025-07-31 20:55:48', NULL),
(36, 10, 'Gucci Guilty Black Pour Homme EDT', 'Hương ngò thơm, hoa cam và hoắc hương, tạo nên một phong cách bí ẩn, mạnh mẽ và đầy quyến rũ, lý tưởng cho những buổi tối lãng mạn và các sự kiện đặc biệt.', 5, 1000000, 'active', '2025-07-31 20:33:18', '2025-07-31 20:55:31', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `products_images`
--

CREATE TABLE `products_images` (
  `id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products_images`
--

INSERT INTO `products_images` (`id`, `product_id`, `path`, `is_featured`, `created_at`, `updated_at`) VALUES
(8, 6, 'images/products/Fw7uQE5OozmX98SLn00HdVNfexpSFIvLQcUD1FrB.webp', 1, '2025-07-18 22:38:00', '2025-07-20 12:50:44'),
(21, 8, 'images/products/HohVXtGvDRqSG3AujfTqhPmuC6xWBCa0X5iAbG4Z.jpg', 1, '2025-07-19 10:54:40', '2025-07-20 12:51:27'),
(22, 8, 'images/products/4QD1KTIHhP92RpisyMKkba78RHYzBl3dIwqjUoTG.jpg', 0, '2025-07-19 10:54:40', '2025-07-19 10:54:40'),
(24, 9, 'images/products/HsIndSS4MAoAguxEnsMz2OFMJcIAzm2yKcT6umAs.jpg', 1, '2025-07-19 10:55:54', '2025-07-19 10:55:54'),
(25, 9, 'images/products/zH8irZVpY6CzuBPvwQ8IYDuwA500eXL8GgEfBHeh.jpg', 0, '2025-07-19 10:55:54', '2025-07-19 10:55:54'),
(26, 9, 'images/products/6bka1VVl5QcU4B2KEA5zknbpBayaiyz0Ra8rEo7u.jpg', 0, '2025-07-19 10:55:54', '2025-07-19 10:55:54'),
(28, 10, 'images/products/9ZMZ2WOp7YlIsjscVBwsHTvmvzY5Zgo5bEJXIHqB.jpg', 0, '2025-07-19 10:56:52', '2025-07-19 10:56:52'),
(29, 10, 'images/products/HdZOCM0bFTTbM0IL6GJwwdDqZhgztjtTYMKYS09N.jpg', 1, '2025-07-19 10:56:52', '2025-07-19 10:57:07'),
(30, 11, 'images/products/IxJtStAs78sIkSreTXCpg97oKYzuZb47ka33H0aN.jpg', 0, '2025-07-19 10:58:13', '2025-07-19 11:06:35'),
(31, 11, 'images/products/89vB33G4697C8clk86JYqjpvW8VpK3uy9PpsayZ9.jpg', 0, '2025-07-19 10:58:13', '2025-07-19 10:58:13'),
(32, 11, 'images/products/N8C5fObMbt0SjglAVL8zYJFNhdFDGJv6VYun26By.jpg', 1, '2025-07-19 10:58:13', '2025-07-19 11:06:35'),
(33, 12, 'images/products/ujzpDocaP2rCV1Zg76i6eQcm9HZhtb6Fh9NalP9r.jpg', 1, '2025-07-19 11:02:03', '2025-07-19 11:02:03'),
(34, 12, 'images/products/VzaBwWRgdAEXN771B4zbnIMjsIJWcIu3Ayc81Qc2.jpg', 0, '2025-07-19 11:02:03', '2025-07-19 11:02:03'),
(35, 12, 'images/products/9YDY5yh8pWTM8EjqBKAuZsI3vY8mqkkxtLPTkIKC.jpg', 0, '2025-07-19 11:02:03', '2025-07-19 11:02:03'),
(36, 13, 'images/products/HSWoLG8Qln5tbHQQf2Ml2VYuaRAkt1S9mu96PLjQ.jpg', 0, '2025-07-19 11:06:03', '2025-07-19 11:06:45'),
(37, 13, 'images/products/mI63IeQGnyiWikcacOloJ92pklAOcPiHLtzHAfGU.jpg', 0, '2025-07-19 11:06:03', '2025-07-19 11:06:03'),
(38, 13, 'images/products/5AblkfCZODqnF5rf6OPCKdx3yWqDjbqF5oEXfykE.jpg', 1, '2025-07-19 11:06:03', '2025-07-19 11:06:45'),
(39, 6, 'images/products/GDRTSXXHA3fBA3UXrWuec0Ljq8svdKk9T1DoHLKM.webp', 0, '2025-07-19 11:07:38', '2025-07-19 11:07:38'),
(40, 14, 'images/products/k8Vh48KYOSWgATpADUzC9Pm1m4Ov8CHovkus0O9i.jpg', 0, '2025-07-19 11:10:01', '2025-07-19 11:11:17'),
(41, 14, 'images/products/ZMESWr3xwO7DOg7rKF2mcEL6e5N4I5xKG80rjPhC.jpg', 0, '2025-07-19 11:10:01', '2025-07-19 11:10:01'),
(42, 14, 'images/products/K8M5IDw9LjPmWQNGTDsVt95AosYyxhJlz6ciGd3Q.jpg', 1, '2025-07-19 11:10:01', '2025-07-19 11:11:17'),
(43, 15, 'images/products/Kk2lgofXMLi7BKrkHOgcvSyui34rOHcaS8Zn4LZz.jpg', 1, '2025-07-19 11:11:09', '2025-07-19 11:11:09'),
(44, 15, 'images/products/o53MVsbVh41h7QGHc5nY0TAan3Z18ZtMEEUN2pit.jpg', 0, '2025-07-19 11:11:09', '2025-07-19 11:11:09'),
(45, 15, 'images/products/ZVboLQDW1k2YbGSVEICgVbWkr8UB3Ej71MknYgxY.jpg', 0, '2025-07-19 11:11:09', '2025-07-19 11:11:09'),
(46, 16, 'images/products/kmtvsy8UeZQUWgD61PHZTDkCpd2G3BCEf439I2hq.jpg', 0, '2025-07-19 11:12:13', '2025-07-19 11:12:23'),
(47, 16, 'images/products/Sp75PvLuc7Hadpm2KzKONxZmj6FTYPzwdaJAgj61.jpg', 0, '2025-07-19 11:12:13', '2025-07-19 11:12:13'),
(48, 16, 'images/products/AUVq4Ds6uBPJNXy7b5r1ymMjw30pEFgBl9f9gd4G.jpg', 1, '2025-07-19 11:12:13', '2025-07-19 11:12:23'),
(49, 17, 'images/products/W977X63EOEAbqxZFYp3Xcc0pNSSuEFD5SqgpikBk.jpg', 0, '2025-07-19 11:13:45', '2025-07-19 11:13:58'),
(50, 17, 'images/products/m0ScxF1Dm8uDQezHUEmTRhVNFtRXvXSpjxiJiX7w.jpg', 0, '2025-07-19 11:13:45', '2025-07-19 11:13:45'),
(51, 17, 'images/products/UJ2SGDMI9KWDRiPOx3IjsNcdwOX78uaQ64i3GmOU.webp', 1, '2025-07-19 11:13:45', '2025-07-19 11:13:58'),
(52, 18, 'images/products/v6uTvopStjF9nUyoeDAFEVp5t0Knyg71Khn7NfMJ.jpg', 0, '2025-07-19 11:14:55', '2025-07-19 11:18:53'),
(53, 18, 'images/products/EXmQ5L2PA8UaNruc2pggUppBkBO95vHCcNctZirb.jpg', 0, '2025-07-19 11:14:55', '2025-07-19 11:14:55'),
(54, 18, 'images/products/FNdv02YbV24FcgU2nbtArNRFMlumDrBLrNw1pMP7.jpg', 1, '2025-07-19 11:14:55', '2025-07-19 11:18:53'),
(55, 19, 'images/products/YwCDKQZec6WvtKiAkog4PemzcaL0aaVaj7S7kNda.jpg', 0, '2025-07-19 11:17:50', '2025-07-19 11:18:01'),
(56, 19, 'images/products/9sDICfPRtfD7JZaBRWYyKjGkfanrN9Yih1921DTt.jpg', 0, '2025-07-19 11:17:50', '2025-07-19 11:17:50'),
(57, 19, 'images/products/bjBNEVAOKMhH43NH52PKu7TGDO4zz7TQBOjLs0rs.jpg', 1, '2025-07-19 11:17:50', '2025-07-19 11:18:01'),
(58, 20, 'images/products/JH37MhsSds3U2XrzIjZTdcpHeavNOifhUFnRqz8I.jpg', 0, '2025-07-19 11:18:42', '2025-07-19 11:19:02'),
(59, 20, 'images/products/mCAYxBOxXJmkfKNfMauIkrwbBz9HJ4apZBiQJkfh.jpg', 0, '2025-07-19 11:18:42', '2025-07-19 11:18:42'),
(60, 20, 'images/products/1V777jcpQFjMx1OEp5zO3f9idrfgbUUfyQrLDxDz.jpg', 1, '2025-07-19 11:18:42', '2025-07-19 11:19:02'),
(61, 21, 'images/products/LiNR17UEJjMonqUSgDm3dsxa1LBPFA5MjeZpPTeL.jpg', 0, '2025-07-19 11:19:50', '2025-07-19 11:20:01'),
(62, 21, 'images/products/UP2polbYlWbFMFDHYM0XAs9bEtOJ9MrZFxIWRFGc.jpg', 0, '2025-07-19 11:19:50', '2025-07-19 11:19:50'),
(63, 21, 'images/products/54oS7YWQEGcxUTTKlO5nUG9ZSVilsmb9KnUa31FY.jpg', 1, '2025-07-19 11:19:50', '2025-07-19 11:20:01'),
(64, 22, 'images/products/7GmQ0rXsEq9huFpkfMpUk7iQkbZ09ZTZFkuyBVp7.jpg', 0, '2025-07-19 11:21:02', '2025-07-19 11:21:09'),
(65, 22, 'images/products/LIqfoxWFdRkBbftXHp2VERLtiAlZvLx5axnStOLJ.jpg', 0, '2025-07-19 11:21:02', '2025-07-19 11:21:02'),
(66, 22, 'images/products/S5XztccYQcF7VjGbXqUM9AAWtmZbjnpoDAXBm3oX.jpg', 1, '2025-07-19 11:21:02', '2025-07-19 11:21:09'),
(67, 6, 'images/products/8A12n9phBt4dLkKxNxD0yacwq5XUwCEnYiLNtfnD.webp', 0, '2025-07-20 12:51:08', '2025-07-20 12:51:08'),
(68, 8, 'images/products/Zv3BB8PsaG0BT09RRchrnCPR0wgoXtsGA2qfKzH4.jpg', 0, '2025-07-20 12:52:08', '2025-07-20 12:52:08'),
(73, 24, 'images/products/lrM1yfgGMs3rfkOJz1gn6jNHicw6GlByQpHfuuc9.jpg', 0, '2025-07-31 20:18:10', '2025-07-31 20:18:17'),
(74, 24, 'images/products/YzuSipEPO5a6h69tTtPJjZmDJm2a3xTBHJNFSjO2.jpg', 0, '2025-07-31 20:18:10', '2025-07-31 20:18:10'),
(75, 24, 'images/products/MjYvWLmZ22BuKYU2LNBT5tz3GikaicV0JRdBqUhK.jpg', 1, '2025-07-31 20:18:10', '2025-07-31 20:18:17'),
(76, 25, 'images/products/FvlYh7qQYqop7Z29QfAzNKUQGjpFXBWux16oxCHl.jpg', 1, '2025-07-31 20:19:46', '2025-07-31 20:19:46'),
(77, 25, 'images/products/Ck0lfZ1KvJyvz1o3Y3gpeqRbzFDyPVmn5yDYc1M4.jpg', 0, '2025-07-31 20:19:46', '2025-07-31 20:19:46'),
(78, 26, 'images/products/VTKizltgpvwO8DlFS2IjItgt3rgPfuC4xWNrOapN.jpg', 1, '2025-07-31 20:20:49', '2025-07-31 20:20:49'),
(79, 26, 'images/products/DFDA4jy1UCvyN273tpyFef0o1gKiWgjzxNpiBkSU.jpg', 0, '2025-07-31 20:20:49', '2025-07-31 20:20:49'),
(80, 26, 'images/products/CyFxnr4jmY6mLmqmbeumL4qjAjCBflNsAISm00oF.jpg', 0, '2025-07-31 20:20:49', '2025-07-31 20:20:49'),
(81, 27, 'images/products/yhY0WolQDIx21gaGxtQ8kYchQLmdZva0y9lDvvzn.jpg', 1, '2025-07-31 20:22:21', '2025-07-31 20:22:21'),
(82, 27, 'images/products/oRogknEodIEIdaxHqryYQScZgCztZ8ZwGtyGaTXr.jpg', 0, '2025-07-31 20:22:21', '2025-07-31 20:22:21'),
(83, 27, 'images/products/O5pWfVlfLG1RUeCC6bZWbHHmO0ImrzQeVlQFZhnU.jpg', 0, '2025-07-31 20:22:21', '2025-07-31 20:22:21'),
(84, 28, 'images/products/FEJPnzwqNRCQXGn59WnAjsFjcSw8CQh9oGCiQzLo.jpg', 1, '2025-07-31 20:24:24', '2025-07-31 20:24:24'),
(85, 28, 'images/products/WdaMVNsxSz18wa20cJjGZ976tMFS20t5ZIMLNzvo.jpg', 0, '2025-07-31 20:24:24', '2025-07-31 20:24:24'),
(86, 28, 'images/products/i8IsBL1lNuFNpOLIx1OqSEc0MrcVhacc3279CRYG.jpg', 0, '2025-07-31 20:24:24', '2025-07-31 20:24:24'),
(87, 29, 'images/products/IrDhJ7CiDoZymPrh8OVPB1ml92FqryPNSiqSIgnF.jpg', 1, '2025-07-31 20:25:28', '2025-07-31 20:25:28'),
(88, 29, 'images/products/yfoQWrLViFVgsmumK3nAfBG2AurGENVtyaKMCYc2.jpg', 0, '2025-07-31 20:25:28', '2025-07-31 20:25:28'),
(89, 29, 'images/products/ieQQIXElzqyCa9n5Fsm7E86oZO7f2gzavQEL8pgE.jpg', 0, '2025-07-31 20:25:28', '2025-07-31 20:25:28'),
(90, 30, 'images/products/FzJNurb2EZcIEd2BQGvg7XUdiYjHVxAkpwblQ6To.jpg', 0, '2025-07-31 20:27:42', '2025-07-31 20:56:50'),
(91, 30, 'images/products/ojhh6bMOWy2n8Gfa0nfTYy4y0FYbwQ9BElq398rC.jpg', 0, '2025-07-31 20:27:42', '2025-07-31 20:27:42'),
(92, 30, 'images/products/3wQ44uz28Rzbyxb1Mhta8fuW4OUQc3kxFhn7GVXD.jpg', 1, '2025-07-31 20:27:42', '2025-07-31 20:56:50'),
(93, 31, 'images/products/ikWX0e1dkl69rSAwjpDRBfhwzBZGBqBpega2cGz7.jpg', 0, '2025-07-31 20:29:03', '2025-07-31 20:56:38'),
(94, 31, 'images/products/P9oL5FDbtOD8fOK3gm87phIVThb2jlI3ARyK6XXW.jpg', 0, '2025-07-31 20:29:03', '2025-07-31 20:29:03'),
(95, 31, 'images/products/5959QxdBf6jvWY9wtq3Bjav1962kTIv9lLZjih0j.jpg', 1, '2025-07-31 20:29:03', '2025-07-31 20:56:38'),
(96, 32, 'images/products/rgBVBC6iYid4Ds7Q8ikyy8MIJeFCCIDzVSykjZrm.jpg', 0, '2025-07-31 20:29:58', '2025-07-31 20:56:29'),
(97, 32, 'images/products/EsypN7GMSW9qtKuUXAyiOvtJuJs7A4AoUZ43DO0b.jpg', 0, '2025-07-31 20:29:58', '2025-07-31 20:29:58'),
(98, 32, 'images/products/fkRk0FOZvhpE4F1x84504pFziKhspzTlzHmMzpqU.jpg', 1, '2025-07-31 20:29:58', '2025-07-31 20:56:29'),
(99, 33, 'images/products/Al0bHDb8j1ahWRNL2qAeOC12GbD3e5WiHu9vHRAo.jpg', 0, '2025-07-31 20:31:02', '2025-07-31 20:56:16'),
(100, 33, 'images/products/XP50GKHGVKQ4HTWioUO1WRu8L81H1zwJxVDbTGmh.jpg', 0, '2025-07-31 20:31:02', '2025-07-31 20:31:02'),
(101, 33, 'images/products/cDXzYhbacVLlYkCQDQImNjN82BM2ecBrUbFTSiKw.jpg', 1, '2025-07-31 20:31:02', '2025-07-31 20:56:16'),
(102, 34, 'images/products/gj7hNUj0bGxsXSDy463h03RzjCOK62lm9lr9J7Wf.jpg', 0, '2025-07-31 20:31:42', '2025-07-31 20:40:44'),
(103, 34, 'images/products/EkJg9vTIRVE7wA2DjhOjed9qWSoUnBlrI5uqzKLU.jpg', 0, '2025-07-31 20:31:42', '2025-07-31 20:31:42'),
(104, 34, 'images/products/AbXlNm4qemKZPytXJehj1g1E3tnBZas5WBY00BEt.jpg', 1, '2025-07-31 20:31:42', '2025-07-31 20:40:44'),
(105, 35, 'images/products/6ZB5r9KkwCYOWaJmQyyuZwVaU3DlJzKr7Hm1gyGV.jpg', 0, '2025-07-31 20:32:28', '2025-07-31 20:33:30'),
(106, 35, 'images/products/BoEpdM286kEXDImOXsIM5esiA6CkCKrXF2vrjE44.jpg', 1, '2025-07-31 20:32:28', '2025-07-31 20:33:30'),
(107, 36, 'images/products/j8wytvYk0qcv0gAZZEFu7uRRCdtGL38ltBCRDbGZ.jpg', 0, '2025-07-31 20:33:18', '2025-07-31 20:40:37'),
(108, 36, 'images/products/q9s8KnRg0D1WYrVbFZyI1yCUHk6knUPdWiKGBGUg.jpg', 0, '2025-07-31 20:33:18', '2025-07-31 20:33:18'),
(109, 36, 'images/products/3RYcfzEE9Bpy9C5b401WZzrENal3sIrhUCX9KDpq.jpg', 1, '2025-07-31 20:33:18', '2025-07-31 20:40:37');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `rating` tinyint UNSIGNED NOT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint UNSIGNED NOT NULL,
  `role_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `role_name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'admin', NULL, NULL, NULL),
(2, 'user', NULL, NULL, NULL),
(7, 'shipper', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('kCaF1aFlm0STG3kvwy8ikKL3telkUxS50oKWdgBg', 13, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36 Edg/138.0.0.0', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiSER2NEZ2cDVycW1DZm92UlJMNUtvOGg3TENIWmhyTFd1c1RHV1E4VCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDA6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9jbGllbnRzL3Byb2R1Y3RzLzYiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjU6InN0YXRlIjtzOjQwOiJuZkVmeHRDRkFYWDkxdVkyelVzcW9LRDNFTlhId1lNSEpxcjRyeHVaIjtzOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxMzt9', 1754025334),
('tbwjj6uaperIHGYvdAfpQshxGqyrPcG4I41uVa9U', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36 Edg/138.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiZTZUMjZpQ2Q3MDdpaTJDcjVVWFhuZk9hY0w2WWdJQVM3Sk9KSWJtbCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzY6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi92YXJpYW50cyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjI7fQ==', 1754025034),
('vschKJ3Fy4GIWGmLoxbz4Srek2DFFEve4sITsAaW', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36 Edg/138.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiRmQ1SUsxVGVNdWxxMk5seGI2VlgyNmNjZHFkRm82RmUxVGtJa1ZvbSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzY6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9wcm9kdWN0cyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjI7fQ==', 1754025723);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `google_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role_id` bigint UNSIGNED NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `google_id`, `phone`, `password`, `address`, `role_id`, `is_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(2, 'Chu Quang Tung', 'tchu280305@gmail.com', NULL, '0862837030', '$2y$12$bGrJJKSbQXH4l17LSVex2.b.2w2Ra0fOHwNM8S/Kms4R08YxgTeqq', '77 An Dương Vương', 1, 1, '2025-07-16 09:05:13', '2025-07-17 17:22:26', NULL),
(8, '[INDA] Đơn xin nghỉ phép - Chu Quang Tùng', 'tchu2803055@gmail.com', NULL, '0862837030', '$2y$12$N6o9QyPjJ1aN7COrysp2AemnzBLHECamB1QcCDwa2j5Q2YZhyP.x2', '1', 2, 1, '2025-07-23 08:45:55', '2025-07-23 08:45:55', NULL),
(9, '[INDA] Đơn xin nghỉ phép - Chu Quang Tùng', 'tchu2803056@gmail.com', NULL, '0862837030', '$2y$12$49jKv.Mc/1Pxna7J.yixUOqGsab8hdJSPotMKmlem6STxITTeYW8.', '1', 2, 0, '2025-07-23 08:46:23', '2025-07-26 19:56:42', NULL),
(10, '[INDA] Đơn xin nghỉ phép - Chu Quang Tùng', 'tchu2803012@gmail.com', NULL, '0862837030', '$2y$12$NmRL6x8JWBIIPppV4.3yUutkGA9lvA2ROPQvumztGaDUyh8OiT/Vm', '123', 2, 1, '2025-07-26 19:10:49', '2025-07-28 21:31:51', NULL),
(11, '[INDA] Đơn xin nghỉ phép - Chu Quang Tùng', 'tchu28030123@gmail.com', NULL, '0862837030', '$2y$12$U/NtPSamIupl30T6Zsk5Eu/WAmXfLckRDvaulQSCtayxx..yrkuVW', '123', 7, 1, '2025-07-27 00:11:15', '2025-07-27 00:11:15', NULL),
(12, '[INDA] Đơn xin nghỉ phép - Chu Quang Tùng', 'tchu280301234@gmail.com', NULL, '0862837030', '$2y$12$XpM.Yy82Qefe/wAtzkNaYOH.9rry.8Q37l716FbW5hRo3YLPJodVG', '123', 2, 1, '2025-07-27 00:13:18', '2025-07-27 00:13:18', NULL),
(13, 'Tùng Chu Quang', 'tung565025@gmail.com', '112830450929733553796', '731-682-7703', '$2y$12$kIq95EwBbRravmOr6cqbqeyGH8dKXGoWUzz9YNIOLKzIHsXxd0/EK', '7787 Alaina Crescent Apt. 303Joshview, NC 63327', 2, 1, '2025-07-27 00:54:04', '2025-07-27 01:08:23', NULL),
(14, '[INDA] Đơn xin nghỉ phép - Chu Quang Tùng', 'an12@gmail.com', NULL, '0862837030', '$2y$12$Pm3GMNix.kWwvLLGOQhNi.2QlYUG4TSF4hW5nQ9Pgk2dPodyVLhPi', '=12', 2, 1, '2025-07-27 18:45:11', '2025-07-27 18:45:11', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `variants`
--

CREATE TABLE `variants` (
  `id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `price` int NOT NULL,
  `stock_quantity` int NOT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `variants`
--

INSERT INTO `variants` (`id`, `product_id`, `price`, `stock_quantity`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(2, 13, 1500000, 18, 'active', '2025-07-24 14:34:52', '2025-07-26 19:35:18', '2025-07-26 19:35:18'),
(3, 16, 5000000, 10, 'active', '2025-07-24 14:35:48', '2025-07-26 19:33:33', '2025-07-26 19:33:33'),
(6, 6, 1200000, 9, 'active', '2025-07-26 21:45:45', '2025-07-26 21:49:57', '2025-07-26 21:49:57'),
(7, 6, 500000, 20, 'active', '2025-07-31 21:31:50', '2025-07-31 21:31:50', NULL),
(8, 13, 300000, 15, 'active', '2025-07-31 21:32:10', '2025-07-31 21:32:10', NULL),
(9, 24, 400000, 20, 'active', '2025-07-31 21:32:27', '2025-07-31 21:32:27', NULL),
(10, 27, 500000, 15, 'active', '2025-07-31 21:32:44', '2025-07-31 21:32:44', NULL),
(11, 26, 700000, 20, 'active', '2025-07-31 21:33:01', '2025-07-31 21:33:01', NULL),
(12, 25, 400000, 20, 'active', '2025-07-31 21:33:26', '2025-07-31 21:33:26', NULL),
(13, 25, 800000, 15, 'active', '2025-07-31 21:33:42', '2025-07-31 21:33:42', NULL),
(14, 26, 500000, 10, 'active', '2025-07-31 21:35:28', '2025-07-31 21:35:28', NULL),
(15, 27, 300000, 10, 'active', '2025-07-31 21:35:54', '2025-07-31 21:35:54', NULL),
(16, 24, 800000, 10, 'active', '2025-07-31 21:36:22', '2025-07-31 21:36:22', NULL),
(17, 6, 1000000, 10, 'active', '2025-07-31 21:36:53', '2025-07-31 21:36:53', NULL),
(18, 13, 600000, 15, 'active', '2025-07-31 21:37:14', '2025-07-31 21:37:14', NULL),
(19, 28, 500000, 15, 'active', '2025-07-31 21:44:50', '2025-07-31 21:44:50', NULL),
(20, 28, 800000, 17, 'active', '2025-07-31 21:45:05', '2025-07-31 21:45:05', NULL),
(21, 29, 1000000, 15, 'active', '2025-07-31 21:45:24', '2025-07-31 21:45:24', NULL),
(22, 29, 700000, 20, 'active', '2025-07-31 21:45:37', '2025-07-31 21:45:37', NULL),
(23, 16, 600000, 17, 'active', '2025-07-31 21:46:19', '2025-07-31 21:46:19', NULL),
(24, 16, 1000000, 10, 'active', '2025-07-31 21:46:34', '2025-07-31 21:46:34', NULL),
(25, 17, 450000, 30, 'active', '2025-07-31 21:47:37', '2025-07-31 21:47:37', NULL),
(26, 17, 850000, 25, 'active', '2025-07-31 21:47:54', '2025-07-31 21:47:54', NULL),
(27, 18, 900000, 25, 'active', '2025-07-31 21:48:24', '2025-07-31 21:48:24', NULL),
(28, 18, 1750000, 30, 'active', '2025-07-31 21:48:51', '2025-07-31 21:48:51', NULL),
(29, 15, 750000, 24, 'active', '2025-07-31 21:51:10', '2025-07-31 21:51:10', NULL),
(30, 15, 1400000, 35, 'active', '2025-07-31 21:51:28', '2025-07-31 21:51:28', NULL),
(31, 14, 450000, 12, 'active', '2025-07-31 21:52:08', '2025-07-31 21:52:08', NULL),
(32, 14, 800000, 23, 'active', '2025-07-31 21:52:26', '2025-07-31 21:52:26', NULL),
(33, 8, 550000, 51, 'active', '2025-07-31 21:52:51', '2025-07-31 21:52:51', NULL),
(34, 8, 750000, 42, 'active', '2025-07-31 21:53:13', '2025-07-31 21:53:13', NULL),
(35, 10, 350000, 31, 'active', '2025-07-31 22:02:27', '2025-07-31 22:02:27', NULL),
(36, 10, 800000, 27, 'active', '2025-07-31 22:02:45', '2025-07-31 22:02:45', NULL),
(37, 12, 480000, 62, 'active', '2025-07-31 22:04:48', '2025-07-31 22:04:48', NULL),
(38, 12, 850000, 34, 'active', '2025-07-31 22:05:04', '2025-07-31 22:05:04', NULL),
(39, 11, 650000, 70, 'active', '2025-07-31 22:05:26', '2025-07-31 22:05:26', NULL),
(40, 9, 850000, 92, 'active', '2025-07-31 22:05:45', '2025-07-31 22:05:45', NULL),
(41, 31, 950000, 32, 'active', '2025-07-31 22:06:03', '2025-07-31 22:06:03', NULL),
(42, 30, 350000, 12, 'active', '2025-07-31 22:06:21', '2025-07-31 22:06:21', NULL),
(43, 30, 800000, 45, 'active', '2025-07-31 22:06:37', '2025-07-31 22:06:37', NULL),
(44, 32, 650000, 25, 'active', '2025-07-31 22:06:53', '2025-07-31 22:06:53', NULL),
(45, 35, 750000, 34, 'active', '2025-07-31 22:07:21', '2025-07-31 22:07:21', NULL),
(46, 36, 650000, 41, 'active', '2025-07-31 22:07:36', '2025-07-31 22:07:36', NULL),
(47, 34, 550000, 62, 'active', '2025-07-31 22:07:52', '2025-07-31 22:07:52', NULL),
(48, 33, 450000, 21, 'active', '2025-07-31 22:08:13', '2025-07-31 22:08:13', NULL),
(49, 22, 850000, 48, 'active', '2025-07-31 22:08:33', '2025-07-31 22:08:33', NULL),
(50, 22, 450000, 35, 'active', '2025-07-31 22:08:48', '2025-07-31 22:08:48', NULL),
(51, 19, 1500000, 34, 'active', '2025-07-31 22:09:11', '2025-07-31 22:09:11', NULL),
(52, 19, 750000, 31, 'active', '2025-07-31 22:09:29', '2025-07-31 22:09:29', NULL),
(53, 21, 650000, 45, 'active', '2025-07-31 22:09:46', '2025-07-31 22:09:46', NULL),
(54, 21, 1200000, 45, 'active', '2025-07-31 22:10:03', '2025-07-31 22:10:03', NULL),
(55, 20, 350000, 42, 'active', '2025-07-31 22:10:19', '2025-07-31 22:10:19', NULL),
(56, 20, 750000, 46, 'active', '2025-07-31 22:10:33', '2025-07-31 22:10:33', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `variant_attributes`
--

CREATE TABLE `variant_attributes` (
  `variant_attributes_id` bigint UNSIGNED NOT NULL,
  `variant_id` bigint UNSIGNED NOT NULL,
  `attribute_value_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `variant_attributes`
--

INSERT INTO `variant_attributes` (`variant_attributes_id`, `variant_id`, `attribute_value_id`, `created_at`, `updated_at`) VALUES
(21, 7, 12, '2025-07-31 21:31:50', '2025-07-31 21:31:50'),
(22, 8, 11, '2025-07-31 21:32:10', '2025-07-31 21:32:10'),
(23, 9, 12, '2025-07-31 21:32:27', '2025-07-31 21:32:27'),
(24, 10, 13, '2025-07-31 21:32:44', '2025-07-31 21:32:44'),
(25, 11, 12, '2025-07-31 21:33:01', '2025-07-31 21:33:01'),
(26, 12, 12, '2025-07-31 21:33:26', '2025-07-31 21:33:26'),
(27, 13, 13, '2025-07-31 21:33:42', '2025-07-31 21:33:42'),
(28, 14, 11, '2025-07-31 21:35:28', '2025-07-31 21:35:28'),
(29, 15, 12, '2025-07-31 21:35:54', '2025-07-31 21:35:54'),
(30, 16, 13, '2025-07-31 21:36:22', '2025-07-31 21:36:22'),
(31, 17, 13, '2025-07-31 21:36:53', '2025-07-31 21:36:53'),
(32, 18, 12, '2025-07-31 21:37:14', '2025-07-31 21:37:14'),
(33, 19, 11, '2025-07-31 21:44:50', '2025-07-31 21:44:50'),
(34, 20, 12, '2025-07-31 21:45:05', '2025-07-31 21:45:05'),
(35, 21, 12, '2025-07-31 21:45:24', '2025-07-31 21:45:24'),
(36, 22, 11, '2025-07-31 21:45:37', '2025-07-31 21:45:37'),
(37, 23, 11, '2025-07-31 21:46:19', '2025-07-31 21:46:19'),
(38, 24, 12, '2025-07-31 21:46:34', '2025-07-31 21:46:34'),
(39, 25, 11, '2025-07-31 21:47:37', '2025-07-31 21:47:37'),
(40, 26, 12, '2025-07-31 21:47:54', '2025-07-31 21:47:54'),
(41, 27, 11, '2025-07-31 21:48:24', '2025-07-31 21:48:24'),
(42, 28, 12, '2025-07-31 21:48:51', '2025-07-31 21:48:51'),
(43, 29, 11, '2025-07-31 21:51:10', '2025-07-31 21:51:10'),
(44, 30, 12, '2025-07-31 21:51:28', '2025-07-31 21:51:28'),
(45, 31, 11, '2025-07-31 21:52:08', '2025-07-31 21:52:08'),
(46, 32, 12, '2025-07-31 21:52:26', '2025-07-31 21:52:26'),
(47, 33, 11, '2025-07-31 21:52:51', '2025-07-31 21:52:51'),
(48, 34, 12, '2025-07-31 21:53:13', '2025-07-31 21:53:13'),
(49, 35, 11, '2025-07-31 22:02:27', '2025-07-31 22:02:27'),
(50, 36, 12, '2025-07-31 22:02:45', '2025-07-31 22:02:45'),
(51, 37, 11, '2025-07-31 22:04:48', '2025-07-31 22:04:48'),
(52, 38, 12, '2025-07-31 22:05:04', '2025-07-31 22:05:04'),
(53, 39, 11, '2025-07-31 22:05:26', '2025-07-31 22:05:26'),
(54, 40, 12, '2025-07-31 22:05:45', '2025-07-31 22:05:45'),
(55, 41, 12, '2025-07-31 22:06:03', '2025-07-31 22:06:03'),
(56, 42, 11, '2025-07-31 22:06:21', '2025-07-31 22:06:21'),
(57, 43, 12, '2025-07-31 22:06:37', '2025-07-31 22:06:37'),
(58, 44, 11, '2025-07-31 22:06:53', '2025-07-31 22:06:53'),
(59, 45, 12, '2025-07-31 22:07:21', '2025-07-31 22:07:21'),
(60, 46, 11, '2025-07-31 22:07:36', '2025-07-31 22:07:36'),
(61, 47, 12, '2025-07-31 22:07:52', '2025-07-31 22:07:52'),
(62, 48, 11, '2025-07-31 22:08:13', '2025-07-31 22:08:13'),
(63, 49, 12, '2025-07-31 22:08:33', '2025-07-31 22:08:33'),
(64, 50, 11, '2025-07-31 22:08:48', '2025-07-31 22:08:48'),
(65, 51, 13, '2025-07-31 22:09:11', '2025-07-31 22:09:11'),
(66, 52, 11, '2025-07-31 22:09:29', '2025-07-31 22:09:29'),
(67, 53, 11, '2025-07-31 22:09:46', '2025-07-31 22:09:46'),
(68, 54, 12, '2025-07-31 22:10:03', '2025-07-31 22:10:03'),
(69, 55, 11, '2025-07-31 22:10:19', '2025-07-31 22:10:19'),
(70, 56, 12, '2025-07-31 22:10:33', '2025-07-31 22:10:33');

-- --------------------------------------------------------

--
-- Table structure for table `wards`
--

CREATE TABLE `wards` (
  `id` bigint UNSIGNED NOT NULL,
  `district_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wards`
--

INSERT INTO `wards` (`id`, `district_id`, `name`, `created_at`, `updated_at`) VALUES
(1, 1, 'Phúc Xá', NULL, NULL),
(2, 1, 'Trúc Bạch', NULL, NULL),
(3, 1, 'Vĩnh Phúc', NULL, NULL),
(4, 1, 'Cống Vị', NULL, NULL),
(5, 1, 'Liễu Giai', NULL, NULL),
(6, 1, 'Ngọc Hà', NULL, NULL),
(7, 1, 'Điện Biên', NULL, NULL),
(8, 1, 'Đội Cấn', NULL, NULL),
(9, 1, 'Ngọc Khánh', NULL, NULL),
(10, 1, 'Kim Mã', NULL, NULL),
(11, 1, 'Giảng Võ', NULL, NULL),
(12, 1, 'Thành Công', NULL, NULL),
(13, 1, 'Quán Thánh', NULL, NULL),
(14, 1, 'Nguyễn Trung Trực', NULL, NULL),
(15, 2, 'Phan Chu Trinh', NULL, NULL),
(16, 2, 'Hàng Bạc', NULL, NULL),
(17, 2, 'Hàng Bông', NULL, NULL),
(18, 2, 'Cửa Đông', NULL, NULL),
(19, 2, 'Lý Thái Tổ', NULL, NULL),
(20, 2, 'Hàng Mã', NULL, NULL),
(21, 2, 'Đồng Xuân', NULL, NULL),
(22, 2, 'Tràng Tiền', NULL, NULL),
(23, 2, 'Hàng Bài', NULL, NULL),
(24, 2, 'Cửa Nam', NULL, NULL),
(25, 3, 'Cát Linh', NULL, NULL),
(26, 3, 'Văn Miếu', NULL, NULL),
(27, 3, 'Quốc Tử Giám', NULL, NULL),
(28, 3, 'Láng Thượng', NULL, NULL),
(29, 3, 'Ô Chợ Dừa', NULL, NULL),
(30, 3, 'Trung Liệt', NULL, NULL),
(31, 3, 'Khâm Thiên', NULL, NULL),
(32, 3, 'Thổ Quan', NULL, NULL),
(33, 3, 'Nam Đồng', NULL, NULL),
(34, 3, 'Kim Liên', NULL, NULL),
(35, 4, 'Bạch Đằng', NULL, NULL),
(36, 4, 'Thanh Lương', NULL, NULL),
(37, 4, 'Thanh Nhàn', NULL, NULL),
(38, 4, 'Cầu Dền', NULL, NULL),
(39, 4, 'Bách Khoa', NULL, NULL),
(40, 4, 'Đồng Tâm', NULL, NULL),
(41, 4, 'Lê Đại Hành', NULL, NULL),
(42, 4, 'Bùi Thị Xuân', NULL, NULL),
(43, 5, 'Nghĩa Đô', NULL, NULL),
(44, 5, 'Nghĩa Tân', NULL, NULL),
(45, 5, 'Mai Dịch', NULL, NULL),
(46, 5, 'Dịch Vọng', NULL, NULL),
(47, 5, 'Dịch Vọng Hậu', NULL, NULL),
(48, 5, 'Quan Hoa', NULL, NULL),
(49, 5, 'Yên Hòa', NULL, NULL),
(50, 5, 'Trung Hòa', NULL, NULL),
(51, 6, 'Nhân Chính', NULL, NULL),
(52, 6, 'Thanh Xuân Bắc', NULL, NULL),
(53, 6, 'Thanh Xuân Nam', NULL, NULL),
(54, 6, 'Thượng Đình', NULL, NULL),
(55, 6, 'Kim Giang', NULL, NULL),
(56, 6, 'Phương Liệt', NULL, NULL),
(57, 6, 'Khương Mai', NULL, NULL),
(58, 7, 'Đại Kim', NULL, NULL),
(59, 7, 'Định Công', NULL, NULL),
(60, 7, 'Hoàng Liệt', NULL, NULL),
(61, 7, 'Thanh Trì', NULL, NULL),
(62, 7, 'Vĩnh Hưng', NULL, NULL),
(63, 7, 'Mai Động', NULL, NULL),
(64, 7, 'Tương Mai', NULL, NULL),
(65, 8, 'Bồ Đề', NULL, NULL),
(66, 8, 'Sài Đồng', NULL, NULL),
(67, 8, 'Long Biên', NULL, NULL),
(68, 8, 'Thạch Bàn', NULL, NULL),
(69, 8, 'Phúc Lợi', NULL, NULL),
(70, 8, 'Việt Hưng', NULL, NULL),
(71, 9, 'Bưởi', NULL, NULL),
(72, 9, 'Thụy Khuê', NULL, NULL),
(73, 9, 'Yên Phụ', NULL, NULL),
(74, 9, 'Tứ Liên', NULL, NULL),
(75, 9, 'Nhật Chiêu', NULL, NULL),
(76, 9, 'Quảng An', NULL, NULL),
(77, 10, 'Yết Kiêu', NULL, NULL),
(78, 10, 'Nguyễn Trãi', NULL, NULL),
(79, 10, 'Vạn Phúc', NULL, NULL),
(80, 10, 'Phúc La', NULL, NULL),
(81, 10, 'Hà Cầu', NULL, NULL),
(82, 10, 'La Khê', NULL, NULL),
(83, 11, 'Cổ Nhuế 1', NULL, NULL),
(84, 11, 'Cổ Nhuế 2', NULL, NULL),
(85, 11, 'Phú Diễn', NULL, NULL),
(86, 11, 'Minh Khai', NULL, NULL),
(87, 11, 'Đông Ngạc', NULL, NULL),
(88, 11, 'Xuân Đỉnh', NULL, NULL),
(89, 12, 'Cầu Diễn', NULL, NULL),
(90, 12, 'Mỹ Đình 1', NULL, NULL),
(91, 12, 'Mỹ Đình 2', NULL, NULL),
(92, 12, 'Phú Đô', NULL, NULL),
(93, 12, 'Mễ Trì', NULL, NULL),
(94, 12, 'Trung Văn', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attributes`
--
ALTER TABLE `attributes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attributes_values`
--
ALTER TABLE `attributes_values`
  ADD PRIMARY KEY (`id`),
  ADD KEY `attributes_values_attribute_id_foreign` (`attribute_id`);

--
-- Indexes for table `banners`
--
ALTER TABLE `banners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cart_user_id_foreign` (`user_id`);

--
-- Indexes for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cart_items_cart_id_foreign` (`cart_id`),
  ADD KEY `cart_items_variant_id_foreign` (`variant_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categories_parent_category_id_foreign` (`parent_category_id`);

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `coupons_code_unique` (`code`);

--
-- Indexes for table `districts`
--
ALTER TABLE `districts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `districts_city_id_foreign` (`city_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_user_id_foreign` (`user_id`),
  ADD KEY `orders_cancelled_by_admin_id_foreign` (`cancelled_by_admin_id`),
  ADD KEY `orders_shipper_id_foreign` (`shipper_id`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_details_order_id_foreign` (`order_id`),
  ADD KEY `order_details_variant_id_foreign` (`variant_id`);

--
-- Indexes for table `otp_codes`
--
ALTER TABLE `otp_codes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `otp_codes_email_index` (`email`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payments_order_id_foreign` (`order_id`);

--
-- Indexes for table `payment_transactions`
--
ALTER TABLE `payment_transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payment_transactions_payment_id_foreign` (`payment_id`),
  ADD KEY `payment_transactions_order_id_foreign` (`order_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_category_id_foreign` (`category_id`),
  ADD KEY `products_brand_id_foreign` (`brand_id`);

--
-- Indexes for table `products_images`
--
ALTER TABLE `products_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_images_product_id_foreign` (`product_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reviews_user_id_foreign` (`user_id`),
  ADD KEY `reviews_product_id_foreign` (`product_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_google_id_unique` (`google_id`),
  ADD KEY `users_role_id_foreign` (`role_id`);

--
-- Indexes for table `variants`
--
ALTER TABLE `variants`
  ADD PRIMARY KEY (`id`),
  ADD KEY `variants_product_id_foreign` (`product_id`);

--
-- Indexes for table `variant_attributes`
--
ALTER TABLE `variant_attributes`
  ADD PRIMARY KEY (`variant_attributes_id`),
  ADD KEY `variant_attributes_variant_id_foreign` (`variant_id`),
  ADD KEY `variant_attributes_attribute_value_id_foreign` (`attribute_value_id`);

--
-- Indexes for table `wards`
--
ALTER TABLE `wards`
  ADD PRIMARY KEY (`id`),
  ADD KEY `wards_district_id_foreign` (`district_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attributes`
--
ALTER TABLE `attributes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `attributes_values`
--
ALTER TABLE `attributes_values`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `banners`
--
ALTER TABLE `banners`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT for table `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `districts`
--
ALTER TABLE `districts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

--
-- AUTO_INCREMENT for table `otp_codes`
--
ALTER TABLE `otp_codes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `payment_transactions`
--
ALTER TABLE `payment_transactions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `products_images`
--
ALTER TABLE `products_images`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=110;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `variants`
--
ALTER TABLE `variants`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `variant_attributes`
--
ALTER TABLE `variant_attributes`
  MODIFY `variant_attributes_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `wards`
--
ALTER TABLE `wards`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2014;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attributes_values`
--
ALTER TABLE `attributes_values`
  ADD CONSTRAINT `attributes_values_attribute_id_foreign` FOREIGN KEY (`attribute_id`) REFERENCES `attributes` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD CONSTRAINT `cart_items_cart_id_foreign` FOREIGN KEY (`cart_id`) REFERENCES `cart` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_items_variant_id_foreign` FOREIGN KEY (`variant_id`) REFERENCES `variants` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_parent_category_id_foreign` FOREIGN KEY (`parent_category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `districts`
--
ALTER TABLE `districts`
  ADD CONSTRAINT `districts_city_id_foreign` FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_cancelled_by_admin_id_foreign` FOREIGN KEY (`cancelled_by_admin_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `orders_shipper_id_foreign` FOREIGN KEY (`shipper_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `order_details_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_details_variant_id_foreign` FOREIGN KEY (`variant_id`) REFERENCES `variants` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payment_transactions`
--
ALTER TABLE `payment_transactions`
  ADD CONSTRAINT `payment_transactions_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `payment_transactions_payment_id_foreign` FOREIGN KEY (`payment_id`) REFERENCES `payments` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_brand_id_foreign` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE RESTRICT;

--
-- Constraints for table `products_images`
--
ALTER TABLE `products_images`
  ADD CONSTRAINT `products_images_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `variants`
--
ALTER TABLE `variants`
  ADD CONSTRAINT `variants_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `variant_attributes`
--
ALTER TABLE `variant_attributes`
  ADD CONSTRAINT `variant_attributes_attribute_value_id_foreign` FOREIGN KEY (`attribute_value_id`) REFERENCES `attributes_values` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `variant_attributes_variant_id_foreign` FOREIGN KEY (`variant_id`) REFERENCES `variants` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `wards`
--
ALTER TABLE `wards`
  ADD CONSTRAINT `wards_district_id_foreign` FOREIGN KEY (`district_id`) REFERENCES `districts` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
