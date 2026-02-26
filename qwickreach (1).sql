-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 26, 2026 at 01:00 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.3.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `qwickreach`
--

-- --------------------------------------------------------

--
-- Table structure for table `abouts`
--

CREATE TABLE `abouts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `main_title` varchar(255) DEFAULT NULL,
  `main_description` text DEFAULT NULL,
  `main_image` varchar(255) DEFAULT NULL,
  `mission_title` varchar(255) DEFAULT NULL,
  `mission_description` text DEFAULT NULL,
  `mission_image` varchar(255) DEFAULT NULL,
  `story_description` text DEFAULT NULL,
  `story_image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `abouts`
--

INSERT INTO `abouts` (`id`, `main_title`, `main_description`, `main_image`, `mission_title`, `mission_description`, `mission_image`, `story_description`, `story_image`, `created_at`, `updated_at`) VALUES
(1, 'We\'re on a mission to make every asset reachable.', '<p>QwickReach is a next-generation QR-based tracking and registration system. We believe that privacy and connectivity should go hand-in-hand. Our platform helps thousands of users secure their vehicles, pets, and valuables using smart QR technology that protects personal data while ensuring you\'re always reachable.</p>', 'about/ssbJT1zascyFOq0SfAFfvyDSHyhkbFhLCArEbhPv.jpg', 'Helping Millions of People Stay Connected Safely.', '<p>Our mission is to build a world where losing something doesn\'t mean losing hope. We are dedicated to providing affordable, high-tech QR solutions that bridge the gap between finders and owners without exposing sensitive phone numbers or addresses. We grow better when our community stays connected and safe</p>', 'about/uze2rYg3A4gxScqb5pUBhEPiJ5kfe4N3NJ3qrUfS.jpg', '<p>In 2025, we noticed a major problem: people wanted to be reachable in case of emergencies (like a parked car blocking a way) but were afraid to display their mobile numbers publicly. That’s when the idea for QwickReach was born.</p>', 'about/nBISfF1ZpzyHg3gcOvmBsAYHnn9N1upWnIinNLN5.jpg', '2026-02-23 01:41:23', '2026-02-23 01:41:23');

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `announcements`
--

INSERT INTO `announcements` (`id`, `title`, `message`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'hello', 'Hello my user', 1, '2026-02-21 09:58:04', '2026-02-22 23:51:35'),
(2, 'test', 'trjsdlskdlks', 1, '2026-02-21 09:58:49', '2026-02-21 09:58:49'),
(3, 'test', 'dfdf', 1, '2026-02-22 23:21:17', '2026-02-22 23:21:17'),
(4, 'hii', 'dsfdf', 1, '2026-02-22 23:48:38', '2026-02-22 23:48:38');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `description`, `price`, `icon`, `is_active`, `sort_order`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Car QR Tag', 'car-qr-tag', 'For parked or lost vehicles', 499.00, 'uploads/categories/1771572105_car-qr-tag.png', 1, 1, '2026-02-11 02:50:04', '2026-02-20 01:51:45', NULL),
(2, 'Bike QR Tag', 'bike-qr-tag', 'Protect your two-wheeler anywhere', 399.00, 'uploads/categories/1771573304_bike-qr-tag.png', 1, 2, '2026-02-11 02:50:04', '2026-02-20 02:11:44', NULL),
(3, 'Bag QR Tag', 'bag-qr-tag', 'Luggage, office bags & travel bags', 299.00, 'uploads/categories/1771573704_bag-qr-tag.png', 1, 3, '2026-02-11 02:50:04', '2026-02-20 02:18:24', NULL),
(4, 'Pet QR Tag', 'pet-qr-tag', 'Help pets find their way home', 349.00, 'uploads/categories/1771573718_pet-qr-tag.png', 1, 4, '2026-02-11 02:50:04', '2026-02-20 02:18:38', NULL),
(5, 'Children QR Tag', 'children-qr-tag', 'Safety tags for kids & school trips', 299.00, 'uploads/categories/1771574169_children-qr-tag.png', 1, 5, '2026-02-11 02:50:04', '2026-02-20 02:26:09', NULL),
(6, 'Combo QR Tags', 'combo-qr-tags', 'Best value pack for families', 1499.00, 'uploads/categories/1771573732_combo-qr-tags.png', 1, 6, '2026-02-11 02:50:04', '2026-02-20 02:18:52', NULL),
(7, 'test', 'test', 'fdg', 500.00, '📁', 1, 0, '2026-02-12 04:15:22', '2026-02-12 04:15:33', '2026-02-12 04:15:33'),
(8, 'tset', 'tset', 'Description', 500.00, 'uploads/categories/1770892608_tset.jpg', 1, 0, '2026-02-12 05:06:48', '2026-02-12 05:07:02', '2026-02-12 05:07:02'),
(9, 'Sachin Verma', 'sachin-verma', 'Description', 300.00, 'uploads/categories/1771493661_Sachin Verma.jpg', 1, 0, '2026-02-19 04:04:21', '2026-02-19 04:05:07', '2026-02-19 04:05:07');

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`id`, `name`, `email`, `subject`, `message`, `created_at`, `updated_at`) VALUES
(1, 'sachin', 'digiempsachin@gmail.com', NULL, 'only testing', '2026-02-23 04:26:29', '2026-02-23 04:26:29');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_02_11_070914_create_categories_table', 1),
(5, '2026_02_11_071256_create_qr_codes_table', 1),
(6, '2026_02_11_071405_create_qr_registrations_table', 1),
(7, '2026_02_11_071508_create_payments_table', 1),
(8, '2026_02_11_071558_create_qr_scans_table', 1),
(9, '2026_02_13_091058_create_orders_table', 2),
(10, '2026_02_13_091109_create_order_items_table', 2),
(11, '2026_02_13_095930_allow_guest_checkout', 3),
(12, '2026_02_13_104722_add_order_id_to_qr_codes_table', 4),
(13, '2026_02_13_111512_fix_order_status_columns_to_string', 5),
(14, '2026_02_13_112050_fix_qrcode_status_column', 6),
(15, '2026_02_21_072323_create_sliders_table', 7),
(16, '2026_02_21_151416_create_announcements_table', 8),
(17, '2026_02_23_064710_create_abouts_table', 9),
(18, '2026_02_23_094142_create_contacts_table', 10),
(19, '2026_02_23_120516_add_google_id_to_users_table', 11),
(20, '2026_02_25_045139_create_password_resets_table', 12),
(21, '2026_02_25_093436_create_privacy_policies_table', 13);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `order_number` varchar(255) NOT NULL,
  `razorpay_order_id` varchar(255) DEFAULT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `tax` decimal(10,2) NOT NULL DEFAULT 0.00,
  `shipping_cost` decimal(10,2) NOT NULL DEFAULT 0.00,
  `total_amount` decimal(10,2) NOT NULL,
  `status` varchar(191) NOT NULL,
  `payment_status` varchar(191) NOT NULL,
  `shipping_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`shipping_data`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `order_number`, `razorpay_order_id`, `subtotal`, `tax`, `shipping_cost`, `total_amount`, `status`, `payment_status`, `shipping_data`, `created_at`, `updated_at`) VALUES
(8, NULL, 'ORD-MMI8BZZ9XX', 'order_SFazU1Ns7MNfws', 499.15, 89.85, 0.00, 589.00, 'pending', 'pending', '{\"full_name\":\"Sachin Verma\",\"mobile_number\":\"7080032118\",\"email\":\"sachinve4@gmail.com\",\"address_line1\":\"Address Line\",\"address_line2\":\"Address Line\",\"city\":\"Thane\",\"state\":\"Maharashtra\",\"pincode\":\"230503\",\"shipping_method\":\"standard\"}', '2026-02-13 04:53:14', '2026-02-13 04:53:15'),
(9, NULL, 'ORD-OUPUYLRYI7', 'order_SFbRmybuiBhxQA', 499.15, 89.85, 0.00, 589.00, 'pending', 'pending', '{\"full_name\":\"sachin\",\"mobile_number\":\"7080032118\",\"email\":\"sachinve4@gmail.com\",\"address_line1\":\"partapgarh\",\"address_line2\":\"partapgarh\",\"city\":\"Thane\",\"state\":\"Maharashtra\",\"pincode\":\"230503\",\"shipping_method\":\"standard\"}', '2026-02-13 05:20:02', '2026-02-13 05:20:03'),
(10, NULL, 'ORD-N87Z0BAYQC', 'order_SFbdNqBhw9jxsB', 499.15, 89.85, 0.00, 589.00, 'pending', 'pending', '{\"full_name\":\"sachin\",\"mobile_number\":\"7080032118\",\"email\":\"sachinve4@gmail.com\",\"address_line1\":\"Address Line\",\"address_line2\":\"Address Line\",\"city\":\"Thane\",\"state\":\"Maharashtra\",\"pincode\":\"230503\",\"shipping_method\":\"standard\"}', '2026-02-13 05:31:00', '2026-02-13 05:31:01'),
(11, NULL, 'ORD-WNDDV2CKOJ', 'order_SFbksrhFbCR56A', 499.15, 89.85, 0.00, 589.00, 'pending', 'pending', '{\"full_name\":\"sachin\",\"mobile_number\":\"7080032118\",\"email\":\"sachinve4@gmail.com\",\"address_line1\":\"Address Line\",\"address_line2\":\"Address Line\",\"city\":\"Thane\",\"state\":\"Maharashtra\",\"pincode\":\"230503\",\"shipping_method\":\"standard\"}', '2026-02-13 05:38:06', '2026-02-13 05:38:07'),
(12, NULL, 'ORD-GE2Q1LDNXG', 'order_SFbuMlori9rulx', 499.15, 89.85, 0.00, 589.00, 'pending', 'pending', '{\"full_name\":\"sachin\",\"mobile_number\":\"7080032118\",\"email\":\"sachinve4@gmail.com\",\"address_line1\":\"Address Line\",\"address_line2\":\"Address Line\",\"city\":\"Thane\",\"state\":\"Maharashtra\",\"pincode\":\"230503\",\"shipping_method\":\"standard\"}', '2026-02-13 05:47:05', '2026-02-13 05:47:06'),
(13, NULL, 'ORD-ATHNHCXDM3', 'order_SFbzwUJJbXvWwU', 499.15, 89.85, 0.00, 589.00, 'confirmed', 'completed', '{\"full_name\":\"Sachin\",\"mobile_number\":\"7080032118\",\"email\":\"sachinve4@gmail.com\",\"address_line1\":\"Address Line\",\"address_line2\":\"Address Line\",\"city\":\"Thane\",\"state\":\"Maharashtra\",\"pincode\":\"230503\",\"shipping_method\":\"standard\"}', '2026-02-13 05:52:22', '2026-02-13 05:52:58'),
(14, NULL, 'ORD-VSPLZQKB60', 'order_SFeiugKCB5aFFy', 399.15, 71.85, 0.00, 471.00, 'pending', 'pending', '{\"full_name\":\"Sachin\",\"mobile_number\":\"7080032118\",\"email\":\"sachinve4@gmail.com\",\"address_line1\":\"Address Line\",\"address_line2\":\"Address Line\",\"city\":\"Thane\",\"state\":\"Maharashtra\",\"pincode\":\"230503\",\"shipping_method\":\"standard\"}', '2026-02-13 08:32:19', '2026-02-13 08:32:20'),
(15, NULL, 'ORD-ZCCPZBEIZJ', 'order_SGgdHXILnS3kY1', 1499.15, 269.85, 0.00, 1769.00, 'pending', 'pending', '{\"full_name\":\"sachin\",\"mobile_number\":\"7800060691\",\"email\":\"sachinve4@gmail.com\",\"address_line1\":\"Address Line\",\"address_line2\":\"Address Line\",\"city\":\"pratapgarh\",\"state\":\"Uttar Pradesh\",\"pincode\":\"230503\",\"shipping_method\":\"standard\"}', '2026-02-15 23:03:22', '2026-02-15 23:03:24'),
(16, NULL, 'ORD-RG7JMBGFAY', 'order_SGgiWTPH49dT5B', 1499.15, 269.85, 0.00, 1769.00, 'confirmed', 'completed', '{\"full_name\":\"Sachin Verma\",\"mobile_number\":\"7080032118\",\"email\":\"sachinve4@gmail.com\",\"address_line1\":\"saraiya ,kishunganj,pratapgarh\",\"address_line2\":\"saraiya ,kishunganj,pratapgarh\",\"city\":\"pratapgarh\",\"state\":\"Uttar Pradesh\",\"pincode\":\"230503\",\"shipping_method\":\"standard\"}', '2026-02-15 23:08:20', '2026-02-15 23:09:07'),
(17, NULL, 'ORD-RQEJCRQSCI', 'order_SGnz4uBgUI3TBO', 499.15, 89.85, 0.00, 589.00, 'confirmed', 'completed', '{\"full_name\":\"ram\",\"mobile_number\":\"7800060691\",\"email\":\"sachin@gmail.com\",\"address_line1\":\"Address Line\",\"address_line2\":\"Address Line\",\"city\":\"pratapgarh\",\"state\":\"Uttar Pradesh\",\"pincode\":\"230503\",\"shipping_method\":\"standard\"}', '2026-02-16 06:14:51', '2026-02-16 06:15:33'),
(18, NULL, 'ORD-UBXX5PDTYY', 'order_SH8y939VFCepZv', 2894.92, 521.08, 0.00, 3416.00, 'confirmed', 'completed', '{\"full_name\":\"Sachin\",\"mobile_number\":\"7080032118\",\"email\":\"digiempsachin@gmail.com\",\"address_line1\":\"Address Line\",\"address_line2\":\"Address Line\",\"city\":\"Thane\",\"state\":\"Maharashtra\",\"pincode\":\"230503\",\"shipping_method\":\"standard\"}', '2026-02-17 02:46:32', '2026-02-17 02:47:18'),
(19, NULL, 'ORD-T5W5XYPOBP', 'order_SI1WPDWNjug8Xb', 422.88, 76.12, 0.00, 499.00, 'pending', 'pending', '{\"full_name\":\"sachin\",\"mobile_number\":\"7080032118\",\"address\":\"fdfdsf\",\"shipping_method\":\"standard\"}', '2026-02-19 08:08:25', '2026-02-19 08:08:27'),
(20, NULL, 'ORD-RQD9OE5LIY', 'order_SI1X44jlEmmtb8', 422.88, 76.12, 0.00, 499.00, 'pending', 'pending', '{\"full_name\":\"sachin\",\"mobile_number\":\"7080032118\",\"address\":\"fdfdsf\",\"shipping_method\":\"standard\"}', '2026-02-19 08:09:04', '2026-02-19 08:09:04'),
(21, NULL, 'ORD-QFCJBDIIHK', 'order_SI1cqBBudv0ex3', 422.88, 76.12, 0.00, 499.00, 'confirmed', 'completed', '{\"full_name\":\"sachin\",\"mobile_number\":\"7080032118\",\"address\":\"dsdsdfdf\",\"shipping_method\":\"standard\"}', '2026-02-19 08:14:32', '2026-02-19 08:15:09'),
(22, NULL, 'ORD-JNUZKLEX1R', 'order_SI2TgmAiM1Q6n6', 1270.34, 228.66, 0.00, 1499.00, 'pending', 'pending', '{\"full_name\":\"sachin\",\"mobile_number\":\"7080032118\",\"address\":\"test\",\"shipping_method\":\"standard\"}', '2026-02-19 09:04:33', '2026-02-19 09:04:34'),
(23, NULL, 'ORD-DEQHGKTNDD', 'order_SI2ZkfnMplwFSj', 1270.34, 228.66, 0.00, 1499.00, 'pending', 'pending', '{\"full_name\":\"sachin\",\"mobile_number\":\"07080032118\",\"address\":\"saraiya ,kishunganj,pratapgarh\",\"shipping_method\":\"standard\"}', '2026-02-19 09:10:18', '2026-02-19 09:10:19'),
(24, NULL, 'ORD-NEMG6QSK6X', 'order_SImJvGgbDSqXJe', 422.88, 76.12, 0.00, 499.00, 'confirmed', 'completed', '{\"full_name\":\"test\",\"mobile_number\":\"2345678901\",\"address\":\"dfdfddgfd\",\"shipping_method\":\"standard\"}', '2026-02-21 05:55:12', '2026-02-21 05:56:00'),
(25, 2, 'ORD-CD8GTR9OCB', 'order_SJrZez8hJgUl7w', 422.88, 76.12, 0.00, 499.00, 'pending', 'pending', '{\"full_name\":\"Sachin\",\"mobile_number\":\"7080032118\",\"address\":\"test test\",\"shipping_method\":\"standard\"}', '2026-02-23 23:42:35', '2026-02-23 23:42:36'),
(26, 2, 'ORD-EJQVMBGXNM', 'order_SJrd9Ou18rcYuZ', 422.88, 76.12, 0.00, 499.00, 'confirmed', 'completed', '{\"full_name\":\"Sachin Verma\",\"mobile_number\":\"7080032118\",\"address\":\"test\",\"shipping_method\":\"standard\"}', '2026-02-23 23:45:53', '2026-02-23 23:46:33'),
(27, NULL, 'ORD-JDCQSCRICB', 'order_SJxWW1tsH7dHyG', 1944.92, 350.08, 0.00, 2295.00, 'pending', 'pending', '{\"full_name\":\"ram Vrema\",\"email\":\"digiempsachin@gmail.com\",\"mobile_number\":\"7080032118\",\"address_line1\":\"Pratapgarh\",\"city\":\"antu\",\"pincode\":\"230503\"}', '2026-02-24 05:31:45', '2026-02-24 05:31:47'),
(28, NULL, 'ORD-4ZPIF6QZ1J', 'order_SJxZ29lXs8VCT6', 1944.92, 350.08, 0.00, 2295.00, 'confirmed', 'completed', '{\"full_name\":\"sachin\",\"email\":\"digiempsachin@gmail.com\",\"mobile_number\":\"7080032118\",\"address_line1\":\"Partapgarh\",\"city\":\"babuganj\",\"pincode\":\"230503\"}', '2026-02-24 05:34:09', '2026-02-24 05:34:52'),
(29, 2, 'ORD-Z2LKEGP1SZ', 'order_SJyp1VpuxLfIs0', 845.76, 152.24, 0.00, 998.00, 'confirmed', 'completed', '{\"full_name\":\"Sachin Verma Verma\",\"email\":\"digiempsachin@gmail.com\",\"mobile_number\":\"7080032118\",\"address_line1\":\"DFGFDFD\",\"city\":\"GFDGFDGF\",\"pincode\":\"12333334\"}', '2026-02-24 06:47:59', '2026-02-24 06:48:45');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `category_id`, `quantity`, `price`, `subtotal`, `created_at`, `updated_at`) VALUES
(8, 8, 1, 2, 499.00, 998.00, '2026-02-13 04:53:14', '2026-02-13 04:53:14'),
(9, 9, 1, 2, 499.00, 998.00, '2026-02-13 05:20:02', '2026-02-13 05:20:02'),
(10, 10, 1, 2, 499.00, 998.00, '2026-02-13 05:31:00', '2026-02-13 05:31:00'),
(11, 11, 1, 2, 499.00, 998.00, '2026-02-13 05:38:06', '2026-02-13 05:38:06'),
(12, 12, 1, 2, 499.00, 998.00, '2026-02-13 05:47:05', '2026-02-13 05:47:05'),
(13, 13, 1, 2, 499.00, 998.00, '2026-02-13 05:52:22', '2026-02-13 05:52:22'),
(14, 14, 2, 1, 399.00, 399.00, '2026-02-13 08:32:19', '2026-02-13 08:32:19'),
(15, 15, 6, 2, 1499.00, 2998.00, '2026-02-15 23:03:22', '2026-02-15 23:03:22'),
(16, 16, 6, 2, 1499.00, 2998.00, '2026-02-15 23:08:20', '2026-02-15 23:08:20'),
(17, 17, 1, 1, 499.00, 499.00, '2026-02-16 06:14:51', '2026-02-16 06:14:51'),
(18, 18, 2, 1, 399.00, 399.00, '2026-02-17 02:46:32', '2026-02-17 02:46:32'),
(19, 18, 5, 1, 299.00, 299.00, '2026-02-17 02:46:32', '2026-02-17 02:46:32'),
(20, 18, 4, 2, 349.00, 698.00, '2026-02-17 02:46:32', '2026-02-17 02:46:32'),
(21, 18, 6, 1, 1499.00, 1499.00, '2026-02-17 02:46:32', '2026-02-17 02:46:32'),
(22, 19, 1, 1, 499.00, 499.00, '2026-02-19 08:08:25', '2026-02-19 08:08:25'),
(23, 20, 1, 1, 499.00, 499.00, '2026-02-19 08:09:04', '2026-02-19 08:09:04'),
(24, 21, 1, 1, 499.00, 499.00, '2026-02-19 08:14:32', '2026-02-19 08:14:32'),
(25, 22, 6, 1, 1499.00, 1499.00, '2026-02-19 09:04:33', '2026-02-19 09:04:33'),
(26, 23, 6, 1, 1499.00, 1499.00, '2026-02-19 09:10:18', '2026-02-19 09:10:18'),
(27, 24, 1, 1, 499.00, 499.00, '2026-02-21 05:55:12', '2026-02-21 05:55:12'),
(28, 25, 1, 1, 499.00, 499.00, '2026-02-23 23:42:35', '2026-02-23 23:42:35'),
(29, 26, 1, 1, 499.00, 499.00, '2026-02-23 23:45:53', '2026-02-23 23:45:53'),
(30, 27, 1, 3, 499.00, 1497.00, '2026-02-24 05:31:45', '2026-02-24 05:31:45'),
(31, 27, 2, 2, 399.00, 798.00, '2026-02-24 05:31:45', '2026-02-24 05:31:45'),
(32, 28, 1, 3, 499.00, 1497.00, '2026-02-24 05:34:09', '2026-02-24 05:34:09'),
(33, 28, 2, 2, 399.00, 798.00, '2026-02-24 05:34:09', '2026-02-24 05:34:09'),
(34, 29, 1, 2, 499.00, 998.00, '2026-02-24 06:47:59', '2026-02-24 06:47:59');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_reset_tokens`
--

INSERT INTO `password_reset_tokens` (`email`, `token`, `created_at`) VALUES
('digiempsachin@gmail.com', '$2y$12$VzVNvfjfITq4mCzwVMSxdeZy4yDdY0Cc/4hiMmQ0X79ol6/M2v2j.', '2026-02-25 00:39:50');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `qr_code_id` bigint(20) UNSIGNED DEFAULT NULL,
  `order_id` varchar(255) NOT NULL,
  `transaction_id` varchar(255) DEFAULT NULL,
  `payment_gateway` varchar(255) DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `discount_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `final_amount` decimal(10,2) NOT NULL,
  `coupon_code` varchar(255) DEFAULT NULL,
  `payment_method` enum('upi','card','paytm','netbanking','wallet') DEFAULT NULL,
  `status` enum('pending','processing','completed','failed','refunded') NOT NULL DEFAULT 'pending',
  `payment_details` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`payment_details`)),
  `failure_reason` text DEFAULT NULL,
  `completed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `privacy_policies`
--

CREATE TABLE `privacy_policies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL DEFAULT 'Privacy Policy',
  `content` longtext NOT NULL,
  `effective_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `privacy_policies`
--

INSERT INTO `privacy_policies` (`id`, `title`, `content`, `effective_date`, `created_at`, `updated_at`) VALUES
(1, 'Privacy Policy – QwickReach', '<p>At QwickReach, we respect your privacy and are committed to protecting your personal information. This Privacy Policy explains how we collect, use, store, and safeguard your data when you use our platform, website, and QR-based services.</p><p>1. Information We Collect</p><p>We may collect the following types of information:</p><p>a) Personal Information</p><p>When you register or use QwickReach services, we may collect:</p><p>• Full Name</p><p>• Mobile Number</p><p>• Email Address (optional)</p><p>• Address</p><p>• Emergency contact numbers</p><p>• Profile or item-related information (such as pet, vehicle, child, or bag details)</p><p>b) QR Tag Information</p><p>We collect information related to the QR tag such as:</p><p>• Category (Pet, Vehicle, Child, etc.)</p><p>• Emergency contacts</p><p>• Any additional details you choose to provide.<br>c) Usage Information</p><p>We may collect:</p><p>• Device information</p><p>• IP address</p><p>• Browser and system data</p><p>• App or website activity.</p><p>2. How We Use Your Information</p><p>Your data is used only to:</p><p>• Provide emergency contact and identification services.</p><p>• Enable QR scanning and communication between users and tag owners.</p><p>• Improve our services and user experience.</p><p>• Send service-related alerts, updates, and important notifications.</p><p>• Prevent fraud, misuse, or unauthorized access.</p><p>• Comply with legal and regulatory requirements.</p><p>We do not sell or rent your personal information to third parties.</p><p>3. Communication &amp; Consent</p><p>By registering and using QwickReach, you agree to:</p><p>• Receive calls, OTPs, and service-related communication.</p><p>• Receive emergency notifications related to your registered QR tag.</p><p>• Consent for communication remains valid for 6 months from the date of acceptance and may be renewed upon continued use.</p><p>• You can withdraw consent at any time by contacting our support.<br>4. Data Sharing</p><p>We may share information only in the following situations:</p><p>• With service providers for hosting, analytics, and communication.</p><p>• With law enforcement or government authorities if required by law.</p><p>• In emergency situations where contact information is necessary to protect safety.</p><p>We never share more information than required.</p><p>5. Data Security</p><p>We implement industry-standard security measures including:</p><p>• Encryption</p><p>• Secure servers</p><p>• Access controls</p><p>• Regular monitoring.</p><p>However, no system is 100% secure. Users are encouraged to keep login details confidential.</p><p>6. Data Retention</p><p>We retain your data:</p><p>• As long as your account is active.</p><p>• For regulatory and compliance requirements.</p><p>• To handle disputes or legal obligations.</p><p>Users may request deletion of their data anytime<br>7. Your Rights</p><p>You have the right to:</p><p>• Access your data.</p><p>• Update or correct information.</p><p>• Request deletion of your account.</p><p>• Withdraw communication consent.</p><p>To exercise your rights, contact us.</p><p>8. Third-Party Links</p><p>Our platform may contain links to external websites. We are not responsible for their privacy practices.</p><p>9. Children’s Privacy</p><p>QwickReach services for children are managed and controlled by parents or guardians. We do not knowingly collect data directly from minors without parental consent.</p><p>10. Updates to this Policy</p><p>We may update this Privacy Policy from time to time. Changes will be reflected on this page.</p><p>11. Contact Us</p><p>For privacy-related concerns or requests:</p><p>QwickReach Support</p><p>Email: qwickreach74@gmail.com</p><p>Phone: 8452012408</p><p>Website: <a href=\"https://coral-lark-320677.hostingersite.com/user/products\">web_link</a></p>', NULL, '2026-02-25 04:24:06', '2026-02-26 00:55:12');

-- --------------------------------------------------------

--
-- Table structure for table `qr_codes`
--

CREATE TABLE `qr_codes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `qr_code` varchar(255) NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `order_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'available',
  `qr_image_path` varchar(255) DEFAULT NULL,
  `assigned_at` timestamp NULL DEFAULT NULL,
  `registered_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `qr_codes`
--

INSERT INTO `qr_codes` (`id`, `qr_code`, `category_id`, `user_id`, `order_id`, `status`, `qr_image_path`, `assigned_at`, `registered_at`, `created_at`, `updated_at`, `deleted_at`) VALUES
(121, 'QRQ95U49CTMG', 1, NULL, 13, 'sold', 'qr_codes/car/QRQ95U49CTMG.svg', '2026-02-13 05:52:58', NULL, '2026-02-11 07:45:12', '2026-02-13 05:52:58', NULL),
(122, 'QRLKCSQJ5F61', 2, NULL, 18, 'sold', 'qr_codes/bike/QRLKCSQJ5F61.svg', '2026-02-17 02:47:18', NULL, '2026-02-12 03:30:19', '2026-02-17 02:47:18', NULL),
(123, 'QRELCAINPQCT', 5, NULL, 18, 'sold', 'qr_codes/children-qr-tag/QRELCAINPQCT.svg', '2026-02-17 02:47:18', NULL, '2026-02-12 05:47:40', '2026-02-17 02:47:18', NULL),
(124, 'QR647TEC0ZHQ', 5, NULL, NULL, 'available', 'qr_codes/children-qr-tag/QR647TEC0ZHQ.svg', NULL, NULL, '2026-02-12 05:47:40', '2026-02-20 03:52:37', '2026-02-20 03:52:37'),
(125, 'QR9CYZBBLGWT', 5, NULL, NULL, 'available', 'qr_codes/children-qr-tag/QR9CYZBBLGWT.svg', NULL, NULL, '2026-02-12 05:47:40', '2026-02-20 03:52:37', '2026-02-20 03:52:37'),
(126, 'QRPCDHIHKKKB', 5, NULL, NULL, 'available', 'qr_codes/children-qr-tag/QRPCDHIHKKKB.svg', NULL, NULL, '2026-02-12 05:47:40', '2026-02-20 03:52:37', '2026-02-20 03:52:37'),
(127, 'QRPFN88LRK19', 5, NULL, NULL, 'available', 'qr_codes/children-qr-tag/QRPFN88LRK19.svg', NULL, NULL, '2026-02-12 05:47:40', '2026-02-20 03:52:37', '2026-02-20 03:52:37'),
(128, 'QRWLBXTRIEH1', 5, NULL, NULL, 'available', 'qr_codes/children-qr-tag/QRWLBXTRIEH1.svg', NULL, NULL, '2026-02-12 05:47:40', '2026-02-20 03:52:37', '2026-02-20 03:52:37'),
(129, 'QRIJ6BW7MHQ7', 5, NULL, NULL, 'available', 'qr_codes/children-qr-tag/QRIJ6BW7MHQ7.svg', NULL, NULL, '2026-02-12 05:47:40', '2026-02-20 03:52:37', '2026-02-20 03:52:37'),
(130, 'QR9PLUEEZMJV', 5, NULL, NULL, 'available', 'qr_codes/children-qr-tag/QR9PLUEEZMJV.svg', NULL, NULL, '2026-02-12 05:47:40', '2026-02-20 03:52:37', '2026-02-20 03:52:37'),
(131, 'QRD78NHA0EIU', 5, NULL, NULL, 'available', 'qr_codes/children-qr-tag/QRD78NHA0EIU.svg', NULL, NULL, '2026-02-12 05:47:40', '2026-02-20 03:52:37', '2026-02-20 03:52:37'),
(132, 'QRMPKMRTY0TL', 5, NULL, NULL, 'available', 'qr_codes/children-qr-tag/QRMPKMRTY0TL.svg', NULL, NULL, '2026-02-12 05:47:40', '2026-02-20 03:53:44', '2026-02-20 03:53:44'),
(133, 'QR6GZ7P6XCXA', 6, NULL, 16, 'sold', 'qr_codes/combo-qr-tags/QR6GZ7P6XCXA.svg', '2026-02-15 23:09:07', NULL, '2026-02-12 05:47:54', '2026-02-15 23:09:07', NULL),
(134, 'QRJYFCRWTK2V', 6, NULL, 16, 'sold', 'qr_codes/combo-qr-tags/QRJYFCRWTK2V.svg', '2026-02-15 23:09:07', NULL, '2026-02-12 05:47:54', '2026-02-15 23:09:07', NULL),
(135, 'QRGIKFZSD4WQ', 6, NULL, 18, 'sold', 'qr_codes/combo-qr-tags/QRGIKFZSD4WQ.svg', '2026-02-17 02:47:18', NULL, '2026-02-12 05:47:54', '2026-02-17 02:47:18', NULL),
(136, 'QRYOZNOZ86Y7', 6, NULL, NULL, 'available', 'qr_codes/combo-qr-tags/QRYOZNOZ86Y7.svg', NULL, NULL, '2026-02-12 05:47:54', '2026-02-20 03:53:27', '2026-02-20 03:53:27'),
(137, 'QRPWJ10ZRXRF', 6, NULL, NULL, 'available', 'qr_codes/combo-qr-tags/QRPWJ10ZRXRF.svg', NULL, NULL, '2026-02-12 05:47:54', '2026-02-20 03:52:37', '2026-02-20 03:52:37'),
(138, 'QR7WZP5GKGX8', 6, NULL, NULL, 'available', 'qr_codes/combo-qr-tags/QR7WZP5GKGX8.svg', NULL, NULL, '2026-02-12 05:47:55', '2026-02-20 03:53:27', '2026-02-20 03:53:27'),
(139, 'QRALNCNGVEX1', 6, NULL, NULL, 'available', 'qr_codes/combo-qr-tags/QRALNCNGVEX1.svg', NULL, NULL, '2026-02-12 05:47:55', '2026-02-20 03:53:27', '2026-02-20 03:53:27'),
(140, 'QRNDZGAI3AM2', 6, NULL, NULL, 'available', 'qr_codes/combo-qr-tags/QRNDZGAI3AM2.svg', NULL, NULL, '2026-02-12 05:47:55', '2026-02-20 03:53:27', '2026-02-20 03:53:27'),
(141, 'QRUEYIAVXBY0', 6, NULL, NULL, 'available', 'qr_codes/combo-qr-tags/QRUEYIAVXBY0.svg', NULL, NULL, '2026-02-12 05:47:55', '2026-02-20 03:53:27', '2026-02-20 03:53:27'),
(142, 'QRCABYJDWPRQ', 6, NULL, NULL, 'available', 'qr_codes/combo-qr-tags/QRCABYJDWPRQ.svg', NULL, NULL, '2026-02-12 05:47:55', '2026-02-20 03:53:27', '2026-02-20 03:53:27'),
(143, 'QR7XTEJYMGFS', 4, NULL, NULL, 'available', 'qr_codes/pet-qr-tag/QR7XTEJYMGFS.svg', NULL, NULL, '2026-02-12 05:48:04', '2026-02-12 06:24:21', '2026-02-12 06:24:21'),
(144, 'QRQ0FFQNE9VS', 4, NULL, NULL, 'available', 'qr_codes/pet-qr-tag/QRQ0FFQNE9VS.svg', NULL, NULL, '2026-02-12 05:48:04', '2026-02-12 06:28:01', '2026-02-12 06:28:01'),
(145, 'QRBINEKFEJFI', 4, NULL, 18, 'sold', 'qr_codes/pet-qr-tag/QRBINEKFEJFI.svg', '2026-02-17 02:47:18', NULL, '2026-02-12 05:48:04', '2026-02-17 02:47:18', NULL),
(146, 'QRRRE201O9ZV', 4, NULL, 18, 'sold', 'qr_codes/pet-qr-tag/QRRRE201O9ZV.svg', '2026-02-17 02:47:18', NULL, '2026-02-12 05:48:04', '2026-02-17 02:47:18', NULL),
(147, 'QRCXOMRN5FG2', 4, NULL, NULL, 'available', 'qr_codes/pet-qr-tag/QRCXOMRN5FG2.svg', NULL, NULL, '2026-02-12 05:48:04', '2026-02-20 03:54:55', '2026-02-20 03:54:55'),
(148, 'QRI9MK9CGQXX', 4, NULL, NULL, 'available', 'qr_codes/pet-qr-tag/QRI9MK9CGQXX.svg', NULL, NULL, '2026-02-12 05:48:04', '2026-02-20 03:54:55', '2026-02-20 03:54:55'),
(149, 'QRHFRYMLBYXW', 4, NULL, NULL, 'available', 'qr_codes/pet-qr-tag/QRHFRYMLBYXW.svg', NULL, NULL, '2026-02-12 05:48:04', '2026-02-20 03:54:55', '2026-02-20 03:54:55'),
(150, 'QRWBETX6NI8Z', 4, NULL, NULL, 'available', 'qr_codes/pet-qr-tag/QRWBETX6NI8Z.svg', NULL, NULL, '2026-02-12 05:48:04', '2026-02-20 03:54:55', '2026-02-20 03:54:55'),
(151, 'QRKMJNZNTFNN', 4, NULL, NULL, 'available', 'qr_codes/pet-qr-tag/QRKMJNZNTFNN.svg', NULL, NULL, '2026-02-12 05:48:04', '2026-02-20 03:54:55', '2026-02-20 03:54:55'),
(152, 'QRS8IMINEP9O', 4, NULL, NULL, 'available', 'qr_codes/pet-qr-tag/QRS8IMINEP9O.svg', NULL, NULL, '2026-02-12 05:48:04', '2026-02-20 03:53:27', '2026-02-20 03:53:27'),
(153, 'QR6LWMFYLU6O', 1, NULL, 13, 'registered', 'qr_codes/car-qr-tag/QR6LWMFYLU6O.svg', '2026-02-13 05:52:58', '2026-02-16 03:26:25', '2026-02-12 08:07:14', '2026-02-16 03:26:25', NULL),
(154, 'QRP8OFCOOB1Z', 1, NULL, 17, 'registered', 'qr_codes/car-qr-tag/QRP8OFCOOB1Z.svg', '2026-02-16 06:15:33', '2026-02-16 06:22:32', '2026-02-16 06:13:03', '2026-02-16 06:22:32', NULL),
(155, 'QR3YSTTKN3FS', 1, NULL, 21, 'sold', 'qr_codes/car-qr-tag/QR3YSTTKN3FS.svg', '2026-02-19 08:15:09', NULL, '2026-02-19 03:45:48', '2026-02-19 08:15:09', NULL),
(156, 'QRTHGVEYCF3T', 1, NULL, 24, 'sold', 'qr_codes/car-qr-tag/QRTHGVEYCF3T.svg', '2026-02-21 05:56:00', NULL, '2026-02-20 03:55:16', '2026-02-21 05:56:00', NULL),
(157, 'QREFPEESIFMR', 1, 2, 26, 'sold', 'qr_codes/car-qr-tag/QREFPEESIFMR.svg', '2026-02-23 23:46:33', NULL, '2026-02-21 06:08:34', '2026-02-23 23:46:33', NULL),
(158, 'QRERB5893KHR', 1, NULL, 28, 'sold', 'qr_codes/car-qr-tag/QRERB5893KHR.svg', '2026-02-24 05:34:52', NULL, '2026-02-24 03:25:42', '2026-02-24 05:34:52', NULL),
(159, 'QREKWXJPGJBU', 1, NULL, 28, 'sold', 'qr_codes/car-qr-tag/QREKWXJPGJBU.svg', '2026-02-24 05:34:52', NULL, '2026-02-24 03:25:42', '2026-02-24 05:34:52', NULL),
(160, 'QRCYU3IH4J9D', 1, NULL, 28, 'sold', 'qr_codes/car-qr-tag/QRCYU3IH4J9D.svg', '2026-02-24 05:34:52', NULL, '2026-02-24 03:25:42', '2026-02-24 05:34:52', NULL),
(161, 'QRLSK4AEPYRU', 1, 2, 29, 'sold', 'qr_codes/car-qr-tag/QRLSK4AEPYRU.svg', '2026-02-24 06:48:45', NULL, '2026-02-24 03:25:42', '2026-02-24 06:48:45', NULL),
(162, 'QRG4J5BUGFDC', 1, 2, 29, 'sold', 'qr_codes/car-qr-tag/QRG4J5BUGFDC.svg', '2026-02-24 06:48:45', NULL, '2026-02-24 03:25:42', '2026-02-24 06:48:45', NULL),
(163, 'QRAQR6L6GBVG', 2, NULL, 28, 'sold', 'qr_codes/bike-qr-tag/QRAQR6L6GBVG.svg', '2026-02-24 05:34:52', NULL, '2026-02-24 03:25:59', '2026-02-24 05:34:52', NULL),
(164, 'QRE5W5BBPECE', 2, NULL, 28, 'sold', 'qr_codes/bike-qr-tag/QRE5W5BBPECE.svg', '2026-02-24 05:34:52', NULL, '2026-02-24 03:25:59', '2026-02-24 05:34:52', NULL),
(165, 'QRLQV8RYNNIX', 2, NULL, NULL, 'available', 'qr_codes/bike-qr-tag/QRLQV8RYNNIX.svg', NULL, NULL, '2026-02-24 03:25:59', '2026-02-24 03:25:59', NULL),
(166, 'QRDIYAEUZRTV', 2, NULL, NULL, 'available', 'qr_codes/bike-qr-tag/QRDIYAEUZRTV.svg', NULL, NULL, '2026-02-24 03:25:59', '2026-02-24 03:25:59', NULL),
(167, 'QRHBUUKA4G61', 2, NULL, NULL, 'available', 'qr_codes/bike-qr-tag/QRHBUUKA4G61.svg', NULL, NULL, '2026-02-24 03:25:59', '2026-02-24 03:25:59', NULL),
(168, 'QRADT62FLVMP', 3, NULL, NULL, 'available', 'qr_codes/bag-qr-tag/QRADT62FLVMP.svg', NULL, NULL, '2026-02-24 03:26:09', '2026-02-24 03:26:09', NULL),
(169, 'QRUAUG700CWV', 3, NULL, NULL, 'available', 'qr_codes/bag-qr-tag/QRUAUG700CWV.svg', NULL, NULL, '2026-02-24 03:26:09', '2026-02-24 03:26:09', NULL),
(170, 'QRGDDRE2VQPI', 3, NULL, NULL, 'available', 'qr_codes/bag-qr-tag/QRGDDRE2VQPI.svg', NULL, NULL, '2026-02-24 03:26:09', '2026-02-24 03:26:09', NULL),
(171, 'QREAIPD3CQKC', 3, NULL, NULL, 'available', 'qr_codes/bag-qr-tag/QREAIPD3CQKC.svg', NULL, NULL, '2026-02-24 03:26:10', '2026-02-24 03:26:10', NULL),
(172, 'QRPFLCO5IZMR', 3, NULL, NULL, 'available', 'qr_codes/bag-qr-tag/QRPFLCO5IZMR.svg', NULL, NULL, '2026-02-24 03:26:10', '2026-02-24 03:26:10', NULL),
(173, 'QRMLMLQHZ8XI', 4, NULL, NULL, 'available', 'qr_codes/pet-qr-tag/QRMLMLQHZ8XI.svg', NULL, NULL, '2026-02-24 03:26:18', '2026-02-24 03:26:18', NULL),
(174, 'QRFEOBYRZFSK', 4, NULL, NULL, 'available', 'qr_codes/pet-qr-tag/QRFEOBYRZFSK.svg', NULL, NULL, '2026-02-24 03:26:18', '2026-02-24 03:26:18', NULL),
(175, 'QRR55ZATVLR2', 4, NULL, NULL, 'available', 'qr_codes/pet-qr-tag/QRR55ZATVLR2.svg', NULL, NULL, '2026-02-24 03:26:18', '2026-02-24 03:26:18', NULL),
(176, 'QRSFLQFKEXNB', 4, NULL, NULL, 'available', 'qr_codes/pet-qr-tag/QRSFLQFKEXNB.svg', NULL, NULL, '2026-02-24 03:26:18', '2026-02-24 03:26:18', NULL),
(177, 'QRNUBA2PQN3A', 4, NULL, NULL, 'available', 'qr_codes/pet-qr-tag/QRNUBA2PQN3A.svg', NULL, NULL, '2026-02-24 03:26:18', '2026-02-24 03:26:18', NULL),
(178, 'QRAZFTOG1EIV', 5, NULL, NULL, 'available', 'qr_codes/children-qr-tag/QRAZFTOG1EIV.svg', NULL, NULL, '2026-02-24 03:26:29', '2026-02-24 03:26:29', NULL),
(179, 'QRWHIVGCUMSW', 5, NULL, NULL, 'available', 'qr_codes/children-qr-tag/QRWHIVGCUMSW.svg', NULL, NULL, '2026-02-24 03:26:29', '2026-02-24 03:26:29', NULL),
(180, 'QRVLESY0ECLB', 5, NULL, NULL, 'available', 'qr_codes/children-qr-tag/QRVLESY0ECLB.svg', NULL, NULL, '2026-02-24 03:26:29', '2026-02-24 03:26:29', NULL),
(181, 'QRVETY2GYFLT', 5, NULL, NULL, 'available', 'qr_codes/children-qr-tag/QRVETY2GYFLT.svg', NULL, NULL, '2026-02-24 03:26:29', '2026-02-24 03:26:29', NULL),
(182, 'QRM8LWKG69R4', 5, NULL, NULL, 'available', 'qr_codes/children-qr-tag/QRM8LWKG69R4.svg', NULL, NULL, '2026-02-24 03:26:29', '2026-02-24 03:26:29', NULL),
(183, 'QRBF84PQELL7', 6, NULL, NULL, 'available', 'qr_codes/combo-qr-tags/QRBF84PQELL7.svg', NULL, NULL, '2026-02-24 03:26:38', '2026-02-24 03:26:38', NULL),
(184, 'QR6PG3YCYOCV', 6, NULL, NULL, 'available', 'qr_codes/combo-qr-tags/QR6PG3YCYOCV.svg', NULL, NULL, '2026-02-24 03:26:38', '2026-02-24 03:26:38', NULL),
(185, 'QRUJU6LQNQSU', 6, NULL, NULL, 'available', 'qr_codes/combo-qr-tags/QRUJU6LQNQSU.svg', NULL, NULL, '2026-02-24 03:26:38', '2026-02-24 03:26:38', NULL),
(186, 'QROO3CBOLUWS', 6, NULL, NULL, 'available', 'qr_codes/combo-qr-tags/QROO3CBOLUWS.svg', NULL, NULL, '2026-02-24 03:26:38', '2026-02-24 03:26:38', NULL),
(187, 'QRNAXPNVYU6Y', 6, NULL, NULL, 'available', 'qr_codes/combo-qr-tags/QRNAXPNVYU6Y.svg', NULL, NULL, '2026-02-24 03:26:38', '2026-02-24 03:26:38', NULL),
(188, 'QRMAZNC07UEG', 1, NULL, NULL, 'available', 'qr_codes/car-qr-tag/QRMAZNC07UEG.svg', NULL, NULL, '2026-02-26 05:01:20', '2026-02-26 05:01:20', NULL),
(189, 'QRXNDZWL9ELS', 1, NULL, NULL, 'available', 'qr_codes/car-qr-tag/QRXNDZWL9ELS.svg', NULL, NULL, '2026-02-26 05:01:20', '2026-02-26 05:01:20', NULL),
(190, 'QRNUOB0E8XHR', 1, NULL, NULL, 'available', 'qr_codes/car-qr-tag/QRNUOB0E8XHR.svg', NULL, NULL, '2026-02-26 05:01:20', '2026-02-26 05:01:20', NULL),
(191, 'QRRQJD9HMEOO', 1, NULL, NULL, 'available', 'qr_codes/car-qr-tag/QRRQJD9HMEOO.svg', NULL, NULL, '2026-02-26 05:01:20', '2026-02-26 05:01:20', NULL),
(192, 'QRRETM4UY8G5', 1, NULL, NULL, 'available', 'qr_codes/car-qr-tag/QRRETM4UY8G5.svg', NULL, NULL, '2026-02-26 05:01:20', '2026-02-26 05:01:20', NULL),
(193, 'QRZHUDACXZOQ', 1, NULL, NULL, 'available', 'qr_codes/car-qr-tag/QRZHUDACXZOQ.svg', NULL, NULL, '2026-02-26 05:01:20', '2026-02-26 05:01:20', NULL),
(194, 'QRX5WPZA0GYR', 1, NULL, NULL, 'available', 'qr_codes/car-qr-tag/QRX5WPZA0GYR.svg', NULL, NULL, '2026-02-26 05:01:20', '2026-02-26 05:01:20', NULL),
(195, 'QRSM9IEZ4L6B', 1, NULL, NULL, 'available', 'qr_codes/car-qr-tag/QRSM9IEZ4L6B.svg', NULL, NULL, '2026-02-26 05:01:20', '2026-02-26 05:01:20', NULL),
(196, 'QRQQNMAPQXA5', 1, NULL, NULL, 'available', 'qr_codes/car-qr-tag/QRQQNMAPQXA5.svg', NULL, NULL, '2026-02-26 05:01:20', '2026-02-26 05:01:20', NULL),
(197, 'QRCHJ0FWS4XO', 1, NULL, NULL, 'available', 'qr_codes/car-qr-tag/QRCHJ0FWS4XO.svg', NULL, NULL, '2026-02-26 05:01:20', '2026-02-26 05:01:20', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `qr_registrations`
--

CREATE TABLE `qr_registrations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `qr_code_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `full_name` varchar(255) NOT NULL,
  `mobile_number` varchar(255) NOT NULL,
  `friend_family_1` varchar(255) DEFAULT NULL,
  `friend_family_2` varchar(255) DEFAULT NULL,
  `full_address` text DEFAULT NULL,
  `selected_tags` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`selected_tags`)),
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `qr_registrations`
--

INSERT INTO `qr_registrations` (`id`, `qr_code_id`, `user_id`, `full_name`, `mobile_number`, `friend_family_1`, `friend_family_2`, `full_address`, `selected_tags`, `is_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 153, NULL, 'Sachin Verma', '7080032118', '7800060691', '7800060691', 'pratapgarh', '[\"car\"]', 1, '2026-02-16 03:26:25', '2026-02-16 03:26:25', NULL),
(2, 154, NULL, 'Raj Kumar', '7800606501', '7800606501', '7800606503', 'uttar pradesh', '[\"car\"]', 1, '2026-02-16 06:22:32', '2026-02-19 03:26:03', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `qr_scans`
--

CREATE TABLE `qr_scans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `qr_code_id` bigint(20) UNSIGNED NOT NULL,
  `scanner_ip` varchar(255) DEFAULT NULL,
  `scanner_user_agent` text DEFAULT NULL,
  `scanner_location` varchar(255) DEFAULT NULL,
  `action_taken` enum('view','call','whatsapp','emergency') DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `qr_scans`
--

INSERT INTO `qr_scans` (`id`, `qr_code_id`, `scanner_ip`, `scanner_user_agent`, `scanner_location`, `action_taken`, `created_at`, `updated_at`) VALUES
(1, 153, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, 'view', '2026-02-16 01:03:36', '2026-02-16 01:03:36'),
(2, 153, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, 'view', '2026-02-16 01:06:02', '2026-02-16 01:06:02'),
(3, 153, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, 'view', '2026-02-16 01:06:26', '2026-02-16 01:06:26'),
(4, 153, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, 'view', '2026-02-16 01:12:37', '2026-02-16 01:12:37'),
(5, 153, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, 'view', '2026-02-16 01:12:50', '2026-02-16 01:12:50'),
(6, 153, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, 'view', '2026-02-16 01:14:14', '2026-02-16 01:14:14'),
(7, 153, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, 'view', '2026-02-16 01:15:02', '2026-02-16 01:15:02'),
(8, 153, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, 'view', '2026-02-16 02:32:52', '2026-02-16 02:32:52'),
(9, 153, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, 'view', '2026-02-16 02:33:58', '2026-02-16 02:33:58'),
(10, 153, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, 'view', '2026-02-16 02:35:35', '2026-02-16 02:35:35'),
(11, 153, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, 'view', '2026-02-16 02:37:05', '2026-02-16 02:37:05'),
(12, 153, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, 'view', '2026-02-16 02:43:32', '2026-02-16 02:43:32'),
(13, 153, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, 'view', '2026-02-16 03:32:20', '2026-02-16 03:32:20'),
(14, 153, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, 'view', '2026-02-16 03:36:35', '2026-02-16 03:36:35'),
(15, 153, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, 'view', '2026-02-16 03:42:57', '2026-02-16 03:42:57'),
(16, 154, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, 'view', '2026-02-16 06:20:41', '2026-02-16 06:20:41'),
(17, 154, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, 'view', '2026-02-16 06:23:01', '2026-02-16 06:23:01'),
(18, 154, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, 'view', '2026-02-16 23:18:49', '2026-02-16 23:18:49'),
(19, 154, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, 'view', '2026-02-16 23:18:54', '2026-02-16 23:18:54'),
(20, 153, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, 'view', '2026-02-16 23:21:20', '2026-02-16 23:21:20'),
(21, 153, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, 'whatsapp', '2026-02-16 23:27:15', '2026-02-16 23:27:15'),
(22, 153, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, 'whatsapp', '2026-02-16 23:27:45', '2026-02-16 23:27:45'),
(23, 153, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', NULL, 'view', '2026-02-17 02:13:44', '2026-02-17 02:13:44');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sliders`
--

CREATE TABLE `sliders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `sub_title` varchar(255) DEFAULT NULL,
  `image_path` varchar(255) NOT NULL,
  `link` varchar(255) DEFAULT NULL,
  `order_priority` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sliders`
--

INSERT INTO `sliders` (`id`, `title`, `sub_title`, `image_path`, `link`, `order_priority`, `is_active`, `created_at`, `updated_at`) VALUES
(2, 'Smart', NULL, 'sliders/blOxFoBORfwbnBn8eKLlEcCJ5HM95YfcObP4tZA2.jpg', NULL, 0, 1, '2026-02-21 03:19:14', '2026-02-21 03:19:14'),
(3, 'Lost', NULL, 'sliders/9cVeFKrXo0GOcyPxLMeALB9oIUeePoKeJf0dly4a.jpg', NULL, 1, 1, '2026-02-21 03:22:01', '2026-02-21 03:22:10'),
(4, 'Upgrade', NULL, 'sliders/acjxkeP1sUdCPu7C6ltNYFx21HyBAhDgVvniEyqJ.jpg', NULL, 2, 1, '2026-02-21 03:22:51', '2026-02-21 03:22:51'),
(5, 'Safety', NULL, 'sliders/PVAjxRde8S0Y2F7SKTNJI4sDVaAc7YMr2vRy3Mjs.jpg', NULL, 3, 1, '2026-02-21 03:23:32', '2026-02-21 03:23:32');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `google_id` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT 0,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `google_id`, `phone`, `is_admin`, `email_verified_at`, `password`, `avatar`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'admin@example.com', NULL, '7800060691', 1, NULL, '$2y$12$asOU0LcHSCV3lXrNi69XPOzKDrfEJxYanQWEwqPqX7PM3HExriur2', NULL, NULL, '2026-02-11 02:47:46', '2026-02-11 02:47:46'),
(2, 'Sachin Verma Verma', 'digiempsachin@gmail.com', NULL, '7080032118', 0, NULL, '$2y$12$imM7YsVtYDHyeO931N6OHOigVfhqYYQjdZZJ8yqx6D62mCzpXUbTO', NULL, 'p8C5GzYD43MLypnCEylerSPG64Cc3osjYRymZlDUtOI1JiMfPmYmWXz4AU6I', '2026-02-23 08:10:06', '2026-02-25 00:36:50');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `abouts`
--
ALTER TABLE `abouts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_slug_unique` (`slug`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

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
  ADD UNIQUE KEY `orders_order_number_unique` (`order_number`),
  ADD KEY `orders_user_id_foreign` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_order_id_foreign` (`order_id`),
  ADD KEY `order_items_category_id_foreign` (`category_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `password_resets_email_index` (`email`);

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
  ADD UNIQUE KEY `payments_order_id_unique` (`order_id`),
  ADD KEY `payments_qr_code_id_foreign` (`qr_code_id`),
  ADD KEY `payments_order_id_index` (`order_id`),
  ADD KEY `payments_user_id_status_index` (`user_id`,`status`),
  ADD KEY `payments_transaction_id_index` (`transaction_id`);

--
-- Indexes for table `privacy_policies`
--
ALTER TABLE `privacy_policies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `qr_codes`
--
ALTER TABLE `qr_codes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `qr_codes_qr_code_unique` (`qr_code`),
  ADD KEY `qr_codes_category_id_foreign` (`category_id`),
  ADD KEY `qr_codes_user_id_foreign` (`user_id`),
  ADD KEY `qr_codes_status_category_id_index` (`status`,`category_id`),
  ADD KEY `qr_codes_qr_code_index` (`qr_code`);

--
-- Indexes for table `qr_registrations`
--
ALTER TABLE `qr_registrations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `qr_registrations_user_id_foreign` (`user_id`),
  ADD KEY `qr_registrations_mobile_number_index` (`mobile_number`),
  ADD KEY `qr_registrations_qr_code_id_index` (`qr_code_id`);

--
-- Indexes for table `qr_scans`
--
ALTER TABLE `qr_scans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `qr_scans_qr_code_id_index` (`qr_code_id`),
  ADD KEY `qr_scans_created_at_index` (`created_at`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `sliders`
--
ALTER TABLE `sliders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `abouts`
--
ALTER TABLE `abouts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `privacy_policies`
--
ALTER TABLE `privacy_policies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `qr_codes`
--
ALTER TABLE `qr_codes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=198;

--
-- AUTO_INCREMENT for table `qr_registrations`
--
ALTER TABLE `qr_registrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `qr_scans`
--
ALTER TABLE `qr_scans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `sliders`
--
ALTER TABLE `sliders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_qr_code_id_foreign` FOREIGN KEY (`qr_code_id`) REFERENCES `qr_codes` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `payments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `qr_codes`
--
ALTER TABLE `qr_codes`
  ADD CONSTRAINT `qr_codes_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `qr_codes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `qr_registrations`
--
ALTER TABLE `qr_registrations`
  ADD CONSTRAINT `qr_registrations_qr_code_id_foreign` FOREIGN KEY (`qr_code_id`) REFERENCES `qr_codes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `qr_registrations_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `qr_scans`
--
ALTER TABLE `qr_scans`
  ADD CONSTRAINT `qr_scans_qr_code_id_foreign` FOREIGN KEY (`qr_code_id`) REFERENCES `qr_codes` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
