-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jan 21, 2024 at 10:56 PM
-- Server version: 8.0.31
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `consultationsdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `cashtransfers`
--

DROP TABLE IF EXISTS `cashtransfers`;
CREATE TABLE IF NOT EXISTS `cashtransfers` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `cash` decimal(8,2) DEFAULT NULL,
  `cashtype` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fromtype` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `totype` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `client_id` bigint UNSIGNED DEFAULT NULL,
  `expert_id` bigint UNSIGNED DEFAULT NULL,
  `pointtransfer_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

DROP TABLE IF EXISTS `clients`;
CREATE TABLE IF NOT EXISTS `clients` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_name` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nationality` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `birthdate` datetime DEFAULT NULL,
  `gender` int DEFAULT NULL,
  `marital_status` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `token` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `points_balance` int DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `updateuser_id` bigint UNSIGNED DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `clients_mobile_unique` (`mobile`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`id`, `user_name`, `password`, `mobile`, `email`, `nationality`, `birthdate`, `gender`, `marital_status`, `image`, `token`, `points_balance`, `created_at`, `updated_at`, `updateuser_id`, `is_active`) VALUES
(10, 'احمد', NULL, '0533494872', 'dfc@uy.com', 'syr', '2000-01-20 00:00:00', 1, 'single', '5947810.webp', NULL, 0, '2024-01-18 20:06:28', '2024-01-18 20:06:29', NULL, 1),
(11, 'احمد1', NULL, '0533494877', 'dfc@uy.com', 'syr', '2000-01-20 00:00:00', 1, 'single', '2779511.webp', NULL, 0, '2024-01-18 20:26:34', '2024-01-18 20:26:34', NULL, 1),
(12, 'احمد2', NULL, '0533494777', 'dfc@uy.com', 'syr', '2005-01-05 00:00:00', 1, 'single', '8576212.webp', NULL, 0, '2024-01-18 20:27:48', '2024-01-18 20:27:48', NULL, 1),
(13, 'احمد3', NULL, '0533497777', 'dfc@uy.com', 'syr', '2005-05-01 00:00:00', 1, 'single', '9227313.webp', NULL, 0, '2024-01-18 20:29:12', '2024-01-18 20:29:12', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `experts`
--

DROP TABLE IF EXISTS `experts`;
CREATE TABLE IF NOT EXISTS `experts` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nationality` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `birthdate` datetime DEFAULT NULL,
  `gender` int DEFAULT NULL,
  `marital_status` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `points_balance` int DEFAULT '0',
  `cash_balance` decimal(8,2) DEFAULT '0.00',
  `cash_balance_todate` decimal(8,2) DEFAULT '0.00',
  `rates` decimal(8,2) DEFAULT '0.00',
  `record` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `desc` text COLLATE utf8mb4_unicode_ci,
  `call_cost` int DEFAULT '0',
  `token` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL,
  `answer_speed` decimal(8,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `experts_user_name_unique` (`user_name`),
  UNIQUE KEY `experts_mobile_unique` (`mobile`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `experts`
--

INSERT INTO `experts` (`id`, `user_name`, `mobile`, `email`, `nationality`, `birthdate`, `gender`, `marital_status`, `image`, `points_balance`, `cash_balance`, `cash_balance_todate`, `rates`, `record`, `desc`, `call_cost`, `token`, `password`, `created_at`, `updated_at`, `is_active`, `answer_speed`) VALUES
(1, 'expert1', '096959459459', 'expert@gmail.com', 'Syrian', '2000-01-01 17:59:22', NULL, 'm', NULL, 0, '0.00', '0.00', '0.00', NULL, NULL, 0, NULL, '$2y$12$hmb198tlznpCuj4fUy3uW.9XBUdfNdbQe7JD52ok4VN3K8G.q3uJC', NULL, NULL, 1, NULL),
(2, 'expert2', '096959459451', 'expert2012@gmail.com', 'Syrian', '2000-01-01 17:59:22', NULL, 'm', NULL, 0, '0.00', '0.00', '0.00', NULL, NULL, 0, NULL, '$2y$12$hmb198tlznpCuj4fUy3uW.9XBUdfNdbQe7JD52ok4VN3K8G.q3uJC', NULL, NULL, 1, NULL),
(3, 'expert3', '096959459441', 'expert2011@gmail.com', 'Syrian', '2000-01-01 17:59:22', NULL, 'm', NULL, 0, '0.00', '0.00', '0.00', NULL, NULL, 0, NULL, '$2y$12$hmb198tlznpCuj4fUy3uW.9XBUdfNdbQe7JD52ok4VN3K8G.q3uJC', NULL, NULL, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `expertsfavorites`
--

DROP TABLE IF EXISTS `expertsfavorites`;
CREATE TABLE IF NOT EXISTS `expertsfavorites` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `client_id` bigint UNSIGNED DEFAULT NULL,
  `expert_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `experts_services`
--

DROP TABLE IF EXISTS `experts_services`;
CREATE TABLE IF NOT EXISTS `experts_services` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `expert_id` bigint UNSIGNED DEFAULT NULL,
  `service_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `points` int DEFAULT '0',
  `expert_cost` decimal(8,2) DEFAULT '0.00',
  `cost_type` int DEFAULT '0',
  `expert_cost_value` decimal(8,2) DEFAULT '0.00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `experts_services`
--

INSERT INTO `experts_services` (`id`, `expert_id`, `service_id`, `created_at`, `updated_at`, `points`, `expert_cost`, `cost_type`, `expert_cost_value`) VALUES
(1, 1, 1, NULL, NULL, 0, '0.00', 0, '0.00'),
(2, 2, 1, NULL, NULL, 0, '0.00', 0, '0.00');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inputs`
--

DROP TABLE IF EXISTS `inputs`;
CREATE TABLE IF NOT EXISTS `inputs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tooltipe` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` text COLLATE utf8mb4_unicode_ci,
  `ispersonal` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `inputs`
--

INSERT INTO `inputs` (`id`, `name`, `type`, `tooltipe`, `icon`, `ispersonal`, `created_at`, `updated_at`) VALUES
(1, 'user_name', 'text', 'الاسم', NULL, 1, NULL, NULL),
(2, 'mobile', 'text', 'الموبيل', NULL, 1, NULL, NULL),
(3, 'nationality', 'text', 'الجنسية', NULL, 1, NULL, NULL),
(4, 'birthdate', 'date', 'تاريخ الميلاد', NULL, 1, NULL, NULL),
(5, 'gender', 'text', 'الجنس', NULL, 1, NULL, NULL),
(6, 'marital_status', 'text', 'الحالة الاجتماعية', NULL, 1, NULL, NULL),
(7, 'الوضع الدراسي', 'list', 'الوضع الدراسي', NULL, 0, NULL, NULL),
(8, 'العمل الحالي', 'text', 'العمل الحالي', NULL, 0, NULL, NULL),
(9, 'هل يوجد مرض مزمن', 'bool', 'هل يوجد مرض مزمن', NULL, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `inputs_services`
--

DROP TABLE IF EXISTS `inputs_services`;
CREATE TABLE IF NOT EXISTS `inputs_services` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `service_id` bigint UNSIGNED DEFAULT NULL,
  `input_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `inputs_services`
--

INSERT INTO `inputs_services` (`id`, `service_id`, `input_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, NULL, NULL),
(2, 1, 4, NULL, NULL),
(3, 1, 5, NULL, NULL),
(4, 1, 7, NULL, NULL),
(5, 1, 9, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `inputvalues`
--

DROP TABLE IF EXISTS `inputvalues`;
CREATE TABLE IF NOT EXISTS `inputvalues` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `value` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `input_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `inputvalues`
--

INSERT INTO `inputvalues` (`id`, `value`, `input_id`, `created_at`, `updated_at`) VALUES
(1, 'اعدادي', 7, NULL, NULL),
(2, 'ثانوي', 7, NULL, NULL),
(3, 'معهد', 7, NULL, NULL),
(4, 'اجازة جامعية', 7, NULL, NULL),
(5, 'دراسات عليا', 7, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2014_10_12_100000_create_password_resets_table', 1),
(4, '2019_08_19_000000_create_failed_jobs_table', 1),
(5, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(6, '2024_01_06_193109_create_experts_table', 1),
(7, '2024_01_06_193700_create_clients_table', 1),
(8, '2024_01_09_150050_create_services_table', 1),
(9, '2024_01_09_150101_create_inputs_table', 1),
(10, '2024_01_09_150108_create_inputvalues_table', 1),
(11, '2024_01_09_150128_create_selectedservices_table', 1),
(12, '2024_01_09_150156_create_points_table', 1),
(13, '2024_01_09_150206_create_pointstransfers_table', 1),
(14, '2024_01_09_150216_create_cashtransfers_table', 1),
(15, '2024_01_09_150228_create_expertsfavorites_table', 1),
(16, '2024_01_09_150239_create_servisesfavorites_table', 1),
(17, '2024_01_09_150247_create_permissions_table', 1),
(18, '2024_01_09_150254_create_reasons_table', 1),
(19, '2024_01_09_152338_create_inputs_services_table', 1),
(20, '2024_01_09_153018_create_experts_services_table', 1),
(21, '2024_01_09_153308_create_values_services_table', 1),
(22, '2024_01_13_140142_rename_servisesfavorites_table_to_servicesfavorites', 2),
(23, '2024_01_14_175619_add_is_active_to_experts_table', 3),
(24, '2024_01_14_180305_add_is_active_to_clients_table', 4),
(25, '2024_01_14_180321_add_is_active_to_services_table', 4),
(26, '2024_01_14_180347_add_is_active_to_inputs_table', 4),
(27, '2024_01_14_180410_add_is_active_to_inputvalues_table', 4),
(28, '2024_01_14_180430_add_is_active_to_points_table', 4),
(29, '2024_01_14_180449_add_is_active_to_reasons_table', 4),
(30, '2024_01_15_143333_add_comment_rate_to_selectedservices_table', 5),
(31, '2024_01_18_201734_add_is_active_to_clients_table', 6),
(32, '2024_01_18_203735_add_is_active_to_clients_table', 7),
(33, '2024_01_20_143356_add_icon_to_services_table', 8),
(34, '2024_01_20_152656_add_is_active_to_services_table', 9),
(35, '2024_01_20_165855_add_answer_speed_to_experts_table', 10),
(36, '2024_01_21_122146_add_image_to_users_table', 11),
(37, '2024_01_21_222132_add_points_to_experts_services_table', 12),
(38, '2024_01_21_223010_change_points_in_experts_services_table', 13),
(39, '2024_01_21_225228_change_cost_type_in_experts_services_table', 14);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
CREATE TABLE IF NOT EXISTS `permissions` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `service_id` bigint UNSIGNED DEFAULT NULL,
  `allowcomment` tinyint(1) DEFAULT NULL,
  `allowanswer` tinyint(1) DEFAULT NULL,
  `allowsend` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `points`
--

DROP TABLE IF EXISTS `points`;
CREATE TABLE IF NOT EXISTS `points` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `count` int DEFAULT '0',
  `price` decimal(8,2) DEFAULT '0.00',
  `pricebefor` decimal(8,2) DEFAULT '0.00',
  `countbefor` int DEFAULT '0',
  `createuser_id` bigint UNSIGNED DEFAULT NULL,
  `updateuser_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pointstransfers`
--

DROP TABLE IF EXISTS `pointstransfers`;
CREATE TABLE IF NOT EXISTS `pointstransfers` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `point_id` bigint UNSIGNED DEFAULT NULL,
  `client_id` bigint UNSIGNED DEFAULT NULL,
  `expert_id` bigint UNSIGNED DEFAULT NULL,
  `service_id` bigint UNSIGNED DEFAULT NULL,
  `count` int DEFAULT '0',
  `status` int DEFAULT '0',
  `selectedservice_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reasons`
--

DROP TABLE IF EXISTS `reasons`;
CREATE TABLE IF NOT EXISTS `reasons` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `content` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `selectedservices`
--

DROP TABLE IF EXISTS `selectedservices`;
CREATE TABLE IF NOT EXISTS `selectedservices` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `client_id` bigint UNSIGNED NOT NULL,
  `expert_id` bigint UNSIGNED DEFAULT NULL,
  `service_id` bigint UNSIGNED DEFAULT NULL,
  `points` int DEFAULT '0',
  `rate` decimal(8,2) DEFAULT '0.00',
  `answer` text COLLATE utf8mb4_unicode_ci,
  `answer2` text COLLATE utf8mb4_unicode_ci,
  `comment` text COLLATE utf8mb4_unicode_ci,
  `iscommentconfirmd` tinyint(1) DEFAULT '0',
  `issendconfirmd` tinyint(1) DEFAULT '0',
  `isanswerconfirmd` tinyint(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `comment_rate` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

DROP TABLE IF EXISTS `services`;
CREATE TABLE IF NOT EXISTS `services` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `desc` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `createuser_id` bigint UNSIGNED DEFAULT NULL,
  `updateuser_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `icon` text COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `name`, `desc`, `image`, `createuser_id`, `updateuser_id`, `created_at`, `updated_at`, `icon`, `is_active`) VALUES
(1, 'طاقة الشفاء', 'نارلانلامن', '9227311.webp', NULL, NULL, NULL, NULL, 'aa.svg', 1),
(2, 'الصحة', 'يري', '', NULL, NULL, NULL, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `servicesfavorites`
--

DROP TABLE IF EXISTS `servicesfavorites`;
CREATE TABLE IF NOT EXISTS `servicesfavorites` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `client_id` bigint UNSIGNED DEFAULT NULL,
  `service_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_name` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_name` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `token` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `createuser_id` bigint UNSIGNED DEFAULT NULL,
  `updateuser_id` bigint UNSIGNED DEFAULT NULL,
  `mobile` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `image` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `first_name`, `last_name`, `user_name`, `role`, `token`, `createuser_id`, `updateuser_id`, `mobile`, `remember_token`, `created_at`, `updated_at`, `image`) VALUES
(1, 'ahmad', 'najyms@gmail.com', NULL, '$2y$12$hmb198tlznpCuj4fUy3uW.9XBUdfNdbQe7JD52ok4VN3K8G.q3uJC', NULL, NULL, NULL, 'admin', NULL, NULL, NULL, NULL, NULL, '2024-01-11 12:47:38', '2024-01-11 12:47:38', NULL),
(2, 'super1', 'super@gmail.com', NULL, '$2y$12$Bhtt5mZSK0f6kkE3qc54m.C0p1YwjfNH/eBE93BV25mp1s0Om1SJG', NULL, NULL, NULL, 'super', NULL, NULL, NULL, NULL, NULL, '2024-01-11 12:48:33', '2024-01-11 12:48:33', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `values_services`
--

DROP TABLE IF EXISTS `values_services`;
CREATE TABLE IF NOT EXISTS `values_services` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `value` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `selectedservice_id` bigint UNSIGNED DEFAULT NULL,
  `inputservice_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;