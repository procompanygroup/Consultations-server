-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Feb 01, 2024 at 11:52 PM
-- Server version: 10.5.23-MariaDB-log
-- PHP Version: 8.1.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `orasorasweb_consdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `cashtransfers`
--

CREATE TABLE `cashtransfers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cash` decimal(8,2) DEFAULT NULL,
  `cashtype` varchar(200) DEFAULT NULL,
  `fromtype` varchar(200) NOT NULL,
  `totype` varchar(200) DEFAULT NULL,
  `status` varchar(200) DEFAULT NULL,
  `client_id` bigint(20) UNSIGNED DEFAULT NULL,
  `expert_id` bigint(20) UNSIGNED DEFAULT NULL,
  `pointtransfer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_name` varchar(200) DEFAULT NULL,
  `password` varchar(200) DEFAULT NULL,
  `mobile` varchar(200) NOT NULL,
  `email` varchar(200) DEFAULT NULL,
  `nationality` varchar(200) DEFAULT NULL,
  `birthdate` datetime DEFAULT NULL,
  `gender` int(11) DEFAULT NULL,
  `marital_status` varchar(200) DEFAULT NULL,
  `image` varchar(200) DEFAULT NULL,
  `token` varchar(200) DEFAULT NULL,
  `points_balance` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `updateuser_id` bigint(20) UNSIGNED DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`id`, `user_name`, `password`, `mobile`, `email`, `nationality`, `birthdate`, `gender`, `marital_status`, `image`, `token`, `points_balance`, `created_at`, `updated_at`, `updateuser_id`, `is_active`) VALUES
(10, 'احمد', NULL, '0533494872', 'dfc@uy.com', 'syr', '2000-01-20 00:00:00', 1, 'single', '5947810.webp', NULL, 20000, '2024-01-18 20:06:28', '2024-01-28 19:38:32', NULL, 1),
(11, 'احمد1', NULL, '0533494877', 'dfc@uy.com', 'syr', '2000-01-20 00:00:00', 1, 'single', '2779511.webp', NULL, 0, '2024-01-18 20:26:34', '2024-01-18 20:26:34', NULL, 1),
(12, 'احمد2', NULL, '0533494777', 'dfc@uy.com', 'syr', '2005-01-05 00:00:00', 1, 'single', '8576212.webp', NULL, 0, '2024-01-18 20:27:48', '2024-01-18 20:27:48', NULL, 1),
(13, 'احمد3', NULL, '0533497777', 'dfc@uy.com', 'syr', '2005-05-01 00:00:00', 1, 'single', '9227313.webp', NULL, 0, '2024-01-18 20:29:12', '2024-01-18 20:29:12', NULL, 1),
(14, 'raghad', NULL, '021458700000', 'ra@email.com', 'syria', '2000-05-18 00:00:00', 2, 'single', '9782114.webp', NULL, 0, '2024-02-01 07:12:20', '2024-02-01 07:12:21', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `experts`
--

CREATE TABLE `experts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_name` varchar(200) NOT NULL,
  `mobile` varchar(200) NOT NULL,
  `email` varchar(200) DEFAULT NULL,
  `nationality` varchar(200) DEFAULT NULL,
  `birthdate` datetime DEFAULT NULL,
  `gender` int(11) DEFAULT NULL,
  `marital_status` varchar(200) DEFAULT NULL,
  `image` varchar(200) DEFAULT NULL,
  `points_balance` int(11) DEFAULT 0,
  `cash_balance` decimal(8,2) DEFAULT 0.00,
  `cash_balance_todate` decimal(8,2) DEFAULT 0.00,
  `rates` decimal(8,2) DEFAULT 0.00,
  `desc` text DEFAULT NULL,
  `call_cost` int(11) DEFAULT 0,
  `token` varchar(200) DEFAULT NULL,
  `password` varchar(200) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL,
  `answer_speed` decimal(8,2) DEFAULT NULL,
  `first_name` varchar(200) DEFAULT NULL,
  `last_name` varchar(200) DEFAULT NULL,
  `record` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `experts`
--

INSERT INTO `experts` (`id`, `user_name`, `mobile`, `email`, `nationality`, `birthdate`, `gender`, `marital_status`, `image`, `points_balance`, `cash_balance`, `cash_balance_todate`, `rates`, `desc`, `call_cost`, `token`, `password`, `created_at`, `updated_at`, `is_active`, `answer_speed`, `first_name`, `last_name`, `record`) VALUES
(1, 'expert1', '0969459459', 'expert@gmail.com', 'Syrian', '2000-01-01 00:00:00', 1, 'm', '1.webpb', 0, 0.00, 0.00, 0.00, NULL, 0, NULL, '$2y$12$hmb198tlznpCuj4fUy3uW.9XBUdfNdbQe7JD52ok4VN3K8G.q3uJC', NULL, '2024-01-28 11:44:54', 1, NULL, NULL, NULL, NULL),
(2, 'expert2', '096959459451', 'expert2012@gmail.com', 'Syrian', '2000-01-01 17:59:22', 1, 'm', NULL, 0, 0.00, 0.00, 0.00, NULL, 0, NULL, '$2y$12$hmb198tlznpCuj4fUy3uW.9XBUdfNdbQe7JD52ok4VN3K8G.q3uJC', NULL, NULL, 1, NULL, NULL, NULL, NULL),
(3, 'expert3', '0969459441', 'expert2011@gmail.com', 'Syrian', '2000-01-01 00:00:00', 1, 'm', NULL, 0, 0.00, 0.00, 0.00, 'asc', 0, NULL, '$2y$12$hmb198tlznpCuj4fUy3uW.9XBUdfNdbQe7JD52ok4VN3K8G.q3uJC', NULL, '2024-01-28 11:51:44', 1, NULL, NULL, NULL, NULL),
(6, 'sdvsdv', '8111123456', 'dssfvw@ononon.com', NULL, '2024-01-01 00:00:00', 2, NULL, '984116.webp', 0, 0.00, 0.00, 0.00, 'gregregfv', 0, NULL, '$2y$12$z6uPd0zfxseoukPrIAUXXub2mVSI2/8IuGcnvnXGx7GYoWXJElw3.', '2024-01-28 11:55:25', '2024-01-28 12:22:53', 1, NULL, '1ahmad', '1ms', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `expertsfavorites`
--

CREATE TABLE `expertsfavorites` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED DEFAULT NULL,
  `expert_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `expertsfavorites`
--

INSERT INTO `expertsfavorites` (`id`, `client_id`, `expert_id`, `created_at`, `updated_at`) VALUES
(1, 13, 1, NULL, NULL),
(2, 13, 2, NULL, NULL),
(3, 13, 6, NULL, NULL),
(4, 10, 6, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `experts_services`
--

CREATE TABLE `experts_services` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `expert_id` bigint(20) UNSIGNED DEFAULT NULL,
  `service_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `points` int(11) DEFAULT 0,
  `expert_cost` decimal(8,2) DEFAULT 0.00,
  `cost_type` int(11) DEFAULT 0,
  `expert_cost_value` decimal(8,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `experts_services`
--

INSERT INTO `experts_services` (`id`, `expert_id`, `service_id`, `created_at`, `updated_at`, `points`, `expert_cost`, `cost_type`, `expert_cost_value`) VALUES
(1, 1, 1, NULL, NULL, 200, 50.00, 1, 50.00),
(2, 2, 1, NULL, NULL, 300, 10.00, 2, 30.00),
(3, 1, 20, NULL, NULL, 100, 0.00, 0, 0.00),
(4, 1, 21, NULL, NULL, 200, 0.00, 0, 0.00),
(5, 2, 20, NULL, NULL, 200, 0.00, 0, 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(200) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inputs`
--

CREATE TABLE `inputs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(200) NOT NULL,
  `type` varchar(200) NOT NULL,
  `tooltipe` varchar(200) NOT NULL,
  `icon` text DEFAULT NULL,
  `ispersonal` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `image_count` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `inputs`
--

INSERT INTO `inputs` (`id`, `name`, `type`, `tooltipe`, `icon`, `ispersonal`, `created_at`, `updated_at`, `image_count`) VALUES
(1, 'user_name', 'text', 'الاسم', 'username.svg', 1, NULL, NULL, 0),
(2, 'mobile', 'text', 'الموبيل', NULL, 1, NULL, NULL, 0),
(3, 'nationality', 'text', 'الجنسية', NULL, 1, NULL, NULL, 0),
(4, 'birthdate', 'date', 'تاريخ الميلاد', 'birthdate.svg', 1, NULL, NULL, 0),
(5, 'gender', 'text', 'الجنس', 'gender.svg', 1, NULL, NULL, 0),
(6, 'marital_status', 'text', 'الحالة الاجتماعية', 'martial.svg', 1, NULL, NULL, 0),
(7, 'الوضع الدراسي', 'list', 'الوضع الدراسي', NULL, 0, NULL, NULL, 0),
(8, 'العمل الحالي', 'text', 'العمل الحالي', NULL, 0, NULL, NULL, 0),
(9, 'هل يوجد مرض مزمن', 'bool', 'هل يوجد مرض مزمن', NULL, 0, NULL, NULL, 0),
(24, 'record', 'record', '', '', 0, '2024-02-01 17:04:29', '2024-02-01 17:04:29', 0),
(25, 'image', 'image', '', '', 0, '2024-02-01 17:04:29', '2024-02-01 17:04:29', 4),
(26, 'email', 'text', 'البريد الالكتروني', 'email.svg', 1, NULL, NULL, 0),
(27, 'وصف الحالة', 'longtext', 'وصف الحالة', 'username.svg', 0, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `inputs_services`
--

CREATE TABLE `inputs_services` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `service_id` bigint(20) UNSIGNED DEFAULT NULL,
  `input_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `inputs_services`
--

INSERT INTO `inputs_services` (`id`, `service_id`, `input_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, NULL, NULL),
(2, 1, 4, NULL, NULL),
(3, 1, 5, NULL, NULL),
(4, 1, 7, NULL, NULL),
(5, 1, 9, NULL, NULL),
(30, 1, 3, '2024-02-01 17:04:19', '2024-02-01 17:04:19'),
(31, 1, 6, '2024-02-01 17:04:19', '2024-02-01 17:04:19'),
(32, 1, 24, '2024-02-01 17:04:29', '2024-02-01 17:04:29'),
(33, 1, 25, '2024-02-01 17:04:29', '2024-02-01 17:04:29'),
(34, 1, 27, '2024-02-01 17:04:29', '2024-02-01 17:04:29');

-- --------------------------------------------------------

--
-- Table structure for table `inputvalues`
--

CREATE TABLE `inputvalues` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `value` varchar(200) NOT NULL,
  `input_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(200) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(39, '2024_01_21_225228_change_cost_type_in_experts_services_table', 14),
(40, '2024_01_22_153151_add_is_active_to_users_table', 15),
(41, '2024_01_23_114747_add_first_name_to_exprts_table', 16),
(42, '2024_01_27_142243_change_value_in_values_services_table', 17),
(43, '2024_01_27_221643_add_status_to_selectedservices_table', 18),
(44, '2024_01_28_115214_add_side_to_pointstransfers_table', 19),
(45, '2024_01_28_125241_change_desc_in_services_table', 20),
(46, '2024_01_28_132233_add_record_to_experts_table', 21),
(47, '2024_01_28_132536_add_record_to_experts_table', 22),
(48, '2024_01_28_134218_add_records_to_experts_table', 23),
(49, '2024_01_28_162956_change_is_active_in_points_table', 24),
(50, '2024_01_29_151056_change_image_in_services_table', 25),
(51, '2024_01_29_201247_change_desc_in_services_table', 26),
(52, '2024_01_31_114719_add_image_count_to_inputs_table', 27),
(53, '2024_01_31_211919_add_is_callservice_to_services_table', 28);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(200) NOT NULL,
  `token` varchar(200) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(200) NOT NULL,
  `token` varchar(200) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `service_id` bigint(20) UNSIGNED DEFAULT NULL,
  `allowcomment` tinyint(1) DEFAULT NULL,
  `allowanswer` tinyint(1) DEFAULT NULL,
  `allowsend` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(200) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(200) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `points`
--

CREATE TABLE `points` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `count` int(11) DEFAULT 0,
  `price` decimal(8,2) DEFAULT 0.00,
  `pricebefor` decimal(8,2) DEFAULT 0.00,
  `countbefor` int(11) DEFAULT 0,
  `createuser_id` bigint(20) UNSIGNED DEFAULT NULL,
  `updateuser_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `points`
--

INSERT INTO `points` (`id`, `count`, `price`, `pricebefor`, `countbefor`, `createuser_id`, `updateuser_id`, `created_at`, `updated_at`, `is_active`) VALUES
(1, 20, 20.22, 20.22, 0, NULL, NULL, '2024-01-28 14:31:09', '2024-01-31 19:06:48', 1),
(2, 100, 100.00, 100.00, 0, NULL, NULL, '2024-01-28 19:05:30', '2024-01-31 19:07:09', 1),
(5, 110, 100.00, 100.00, 90, NULL, NULL, '2024-01-31 18:59:15', '2024-01-31 18:59:52', 1);

-- --------------------------------------------------------

--
-- Table structure for table `pointstransfers`
--

CREATE TABLE `pointstransfers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `point_id` bigint(20) UNSIGNED DEFAULT NULL,
  `client_id` bigint(20) UNSIGNED DEFAULT NULL,
  `expert_id` bigint(20) UNSIGNED DEFAULT NULL,
  `service_id` bigint(20) UNSIGNED DEFAULT NULL,
  `count` int(11) DEFAULT 0,
  `status` int(11) DEFAULT 0,
  `selectedservice_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `side` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reasons`
--

CREATE TABLE `reasons` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `content` varchar(200) DEFAULT NULL,
  `type` varchar(200) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `selectedservices`
--

CREATE TABLE `selectedservices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `expert_id` bigint(20) UNSIGNED DEFAULT NULL,
  `service_id` bigint(20) UNSIGNED DEFAULT NULL,
  `points` int(11) DEFAULT 0,
  `rate` decimal(8,2) DEFAULT 0.00,
  `answer` text DEFAULT NULL,
  `answer2` text DEFAULT NULL,
  `comment` text DEFAULT NULL,
  `iscommentconfirmd` tinyint(1) DEFAULT 0,
  `issendconfirmd` tinyint(1) DEFAULT 0,
  `isanswerconfirmd` tinyint(1) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `comment_rate` int(11) NOT NULL DEFAULT 0,
  `status` varchar(200) NOT NULL,
  `expert_cost` decimal(8,2) DEFAULT 0.00,
  `cost_type` decimal(8,2) DEFAULT 0.00,
  `expert_cost_value` decimal(8,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(200) NOT NULL,
  `desc` text DEFAULT NULL,
  `image` varchar(200) DEFAULT NULL,
  `createuser_id` bigint(20) UNSIGNED DEFAULT NULL,
  `updateuser_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `icon` varchar(200) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `is_callservice` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `name`, `desc`, `image`, `createuser_id`, `updateuser_id`, `created_at`, `updated_at`, `icon`, `is_active`, `is_callservice`) VALUES
(1, 'طاقة 1الشفاء', 'نارلانلامن', '9227311.webp', NULL, 1, NULL, '2024-02-01 16:57:12', '992601.svg', 1, 0),
(2, 'الصحة', 'يري', '', NULL, NULL, NULL, NULL, NULL, 1, 0),
(19, 'callservice', NULL, NULL, 1, 1, '2024-01-31 19:28:03', '2024-01-31 19:28:03', NULL, 1, 1),
(20, 'طاقة الشفاء', 'العلاج بالطاقة', '2383720.webp', 1, 1, '2024-01-31 19:29:36', '2024-01-31 19:29:36', '9302820.svg', 1, 0),
(21, 'استشارة طبية', NULL, '1305721.webp', 1, 1, '2024-01-31 19:30:52', '2024-02-01 16:55:42', '4823021.svg', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `servicesfavorites`
--

CREATE TABLE `servicesfavorites` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED DEFAULT NULL,
  `service_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(200) DEFAULT NULL,
  `email` varchar(200) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(200) NOT NULL,
  `first_name` varchar(200) DEFAULT NULL,
  `last_name` varchar(200) DEFAULT NULL,
  `user_name` varchar(200) DEFAULT NULL,
  `role` varchar(200) DEFAULT NULL,
  `token` varchar(200) DEFAULT NULL,
  `createuser_id` bigint(20) UNSIGNED DEFAULT NULL,
  `updateuser_id` bigint(20) UNSIGNED DEFAULT NULL,
  `mobile` varchar(200) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `image` text DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `first_name`, `last_name`, `user_name`, `role`, `token`, `createuser_id`, `updateuser_id`, `mobile`, `remember_token`, `created_at`, `updated_at`, `image`, `is_active`) VALUES
(1, 'ahmad', 'najyms@gmail.com', NULL, '$2y$12$hmb198tlznpCuj4fUy3uW.9XBUdfNdbQe7JD52ok4VN3K8G.q3uJC', 'ahmad', 'ms', NULL, 'admin', NULL, NULL, 1, NULL, NULL, '2024-01-11 12:47:38', '2024-01-28 10:55:50', '430751.webp', 1),
(2, 'super1', 'super@gmail.com', NULL, '$2y$12$Bhtt5mZSK0f6kkE3qc54m.C0p1YwjfNH/eBE93BV25mp1s0Om1SJG', 'super', 'super', NULL, 'super', NULL, NULL, 1, NULL, NULL, '2024-01-11 12:48:33', '2024-01-25 17:29:17', '274822.webp', 1),
(8, 'aqwdmin@gmail.com', 'aqawdqadmin@gmail.com', NULL, '$2y$12$dIhz7Qerz6EsdXSe1ugDm.0GQRZM6lvPk14yQ3EnqbM.IFJ/./rUm', 'casc', 'ascv', NULL, 'admin', NULL, 1, 1, '88811143434', NULL, '2024-01-22 13:51:09', '2024-01-22 13:51:09', NULL, 0),
(9, 'ddddsw@ononon.com', 'dsddw@ononon.com', NULL, '$2y$12$6/MlVPFz4icsHWL6I7OM4OKpCJJo1NqmsQCshGZjV5f4lpSdkpi4u', 'ahmad', 'ms', NULL, 'super', NULL, 1, 1, '88811143434', NULL, '2024-01-22 13:56:56', '2024-01-22 13:56:56', NULL, 1),
(10, 'ddtyhtddsw@ononon.com', 'dsdtyntdw@ononon.com', NULL, '$2y$12$CzGEYxXyluOtZobX267ub.WonqpY5D59rIbFB7yGTyUYeJRWcauii', 'ahmad', 'ms', NULL, 'super', NULL, 1, 1, '88811143434', NULL, '2024-01-22 13:57:50', '2024-01-22 13:57:50', NULL, 0),
(11, 'ahmadahmad', 'dkk@gmail.com', NULL, '$2y$12$FhT2nx3xlkMNzRNXfb2ZEu9.BbQBzK6RJrQuiDVnIiDPovdsJ4aTC', 'احمد', 'محمد', NULL, 'admin', NULL, 1, 1, '0995959959', NULL, '2024-01-23 13:06:37', '2024-01-23 13:06:37', '2317011.webp', 1),
(12, 'ahmad11', 'dsw@ononon.com', NULL, '$2y$12$NPrwOkxJ8Ef/Ho7gWa2PkOZbptrGQFPzkYk16p0Sf/xTN6jlhtQBW', 'ahmad', 'ms', NULL, 'super', NULL, 1, 1, '1202056511', NULL, '2024-01-23 14:47:04', '2024-01-23 14:47:04', '7897012.webp', 1);

-- --------------------------------------------------------

--
-- Table structure for table `values_services`
--

CREATE TABLE `values_services` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `value` text NOT NULL,
  `selectedservice_id` bigint(20) UNSIGNED DEFAULT NULL,
  `inputservice_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cashtransfers`
--
ALTER TABLE `cashtransfers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `clients_mobile_unique` (`mobile`);

--
-- Indexes for table `experts`
--
ALTER TABLE `experts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `experts_user_name_unique` (`user_name`),
  ADD UNIQUE KEY `experts_mobile_unique` (`mobile`);

--
-- Indexes for table `expertsfavorites`
--
ALTER TABLE `expertsfavorites`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `experts_services`
--
ALTER TABLE `experts_services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `inputs`
--
ALTER TABLE `inputs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inputs_services`
--
ALTER TABLE `inputs_services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inputvalues`
--
ALTER TABLE `inputvalues`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `points`
--
ALTER TABLE `points`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pointstransfers`
--
ALTER TABLE `pointstransfers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reasons`
--
ALTER TABLE `reasons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `selectedservices`
--
ALTER TABLE `selectedservices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `servicesfavorites`
--
ALTER TABLE `servicesfavorites`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `values_services`
--
ALTER TABLE `values_services`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cashtransfers`
--
ALTER TABLE `cashtransfers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `experts`
--
ALTER TABLE `experts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `expertsfavorites`
--
ALTER TABLE `expertsfavorites`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `experts_services`
--
ALTER TABLE `experts_services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inputs`
--
ALTER TABLE `inputs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `inputs_services`
--
ALTER TABLE `inputs_services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `inputvalues`
--
ALTER TABLE `inputvalues`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `points`
--
ALTER TABLE `points`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `pointstransfers`
--
ALTER TABLE `pointstransfers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `reasons`
--
ALTER TABLE `reasons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `selectedservices`
--
ALTER TABLE `selectedservices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `servicesfavorites`
--
ALTER TABLE `servicesfavorites`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `values_services`
--
ALTER TABLE `values_services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
