-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 19, 2024 at 11:36 AM
-- Server version: 10.5.24-MariaDB-log
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
-- Table structure for table `answers`
--

DROP TABLE IF EXISTS `answers`;
CREATE TABLE `answers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `record` text DEFAULT NULL,
  `content` text DEFAULT NULL,
  `answer_reject_reason` varchar(200) DEFAULT NULL,
  `answer_state` varchar(200) DEFAULT NULL,
  `selectedservice_id` bigint(20) UNSIGNED DEFAULT NULL,
  `updateuser_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `answer_admin_date` datetime DEFAULT NULL,
  `answer_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cashtransfers`
--

DROP TABLE IF EXISTS `cashtransfers`;
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
  `updated_at` timestamp NULL DEFAULT NULL,
  `selectedservice_id` bigint(20) UNSIGNED DEFAULT NULL,
  `source_id` bigint(20) UNSIGNED DEFAULT NULL,
  `cash_num` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cashtransfers`
--

INSERT INTO `cashtransfers` (`id`, `cash`, `cashtype`, `fromtype`, `totype`, `status`, `client_id`, `expert_id`, `pointtransfer_id`, `created_at`, `updated_at`, `selectedservice_id`, `source_id`, `cash_num`) VALUES
(27, 1000.00, 'd', 'client', 'company', 'points', NULL, NULL, 136, '2024-03-18 09:30:39', '2024-03-18 09:30:39', NULL, NULL, 'DCOM-000001'),
(28, 1000.00, 'd', 'client', 'company', 'points', NULL, NULL, 137, '2024-03-18 09:30:54', '2024-03-18 09:30:54', NULL, NULL, 'DCOM-000002'),
(29, 1000.00, 'd', 'client', 'company', 'points', NULL, NULL, 138, '2024-03-18 09:30:56', '2024-03-18 09:30:56', NULL, NULL, 'DCOM-000003'),
(30, 1000.00, 'd', 'client', 'company', 'points', NULL, NULL, 139, '2024-03-18 09:34:15', '2024-03-18 09:34:15', NULL, NULL, 'DCOM-000004'),
(31, 1000.00, 'd', 'client', 'company', 'points', NULL, NULL, 140, '2024-03-18 09:34:17', '2024-03-18 09:34:17', NULL, NULL, 'DCOM-000005'),
(32, 1000.00, 'd', 'client', 'company', 'points', NULL, NULL, 141, '2024-03-18 09:34:18', '2024-03-18 09:34:18', NULL, NULL, 'DCOM-000006'),
(33, 1000.00, 'd', 'client', 'company', 'points', NULL, NULL, 142, '2024-03-18 09:34:25', '2024-03-18 09:34:25', NULL, NULL, 'DCOM-000007'),
(34, 1000.00, 'd', 'client', 'company', 'points', NULL, NULL, 143, '2024-03-18 09:38:29', '2024-03-18 09:38:29', NULL, NULL, 'DCOM-000008'),
(35, 1000.00, 'd', 'client', 'company', 'points', NULL, NULL, 144, '2024-03-18 09:38:31', '2024-03-18 09:38:31', NULL, NULL, 'DCOM-000009'),
(36, 1000.00, 'd', 'client', 'company', 'points', NULL, NULL, 145, '2024-03-18 09:38:33', '2024-03-18 09:38:33', NULL, NULL, 'DCOM-000010'),
(37, 1000.00, 'd', 'client', 'company', 'points', NULL, NULL, 146, '2024-03-18 09:38:34', '2024-03-18 09:38:34', NULL, NULL, 'DCOM-000011');

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

DROP TABLE IF EXISTS `clients`;
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
  `token` text DEFAULT NULL,
  `points_balance` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `updateuser_id` bigint(20) UNSIGNED DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `country_code` varchar(200) DEFAULT NULL,
  `country_num` varchar(200) DEFAULT NULL,
  `mobile_num` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`id`, `user_name`, `password`, `mobile`, `email`, `nationality`, `birthdate`, `gender`, `marital_status`, `image`, `token`, `points_balance`, `created_at`, `updated_at`, `updateuser_id`, `is_active`, `country_code`, `country_num`, `mobile_num`) VALUES
(10, 'احمد', NULL, '213533494872', 'dfc@uy.com', 'syr', '2000-01-20 00:00:00', 1, 'single', '5947810.webp', '', 0, '2024-01-18 20:06:28', '2024-03-18 08:36:19', NULL, 1, NULL, '213', '533494872'),
(12, 'احمد2', NULL, '213533494777', 'dfc@uy.com', 'syr', '2005-01-05 00:00:00', 1, 'single', '8576212.webp', NULL, 0, '2024-01-18 20:27:48', '2024-01-18 20:27:48', NULL, 1, NULL, '213', '533494777'),
(13, 'احمد3', NULL, '213533497777', 'dfc@uy.com', 'syr', '2005-05-01 00:00:00', 1, 'single', '9227313.webp', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvYXBpL2xvZ2luY2xpZW50IiwiaWF0IjoxNzA3NDA3MTU3LCJuYmYiOjE3MDc0MDcxNTcsImp0aSI6IkZvUFZYMllrT2VqMHJ1TjkiLCJzdWIiOiIxMyIsInBydiI6IjQxZWZiN2JhZDdmNmY2MzJlMjQwNWJkM2E3OTNiOGE2YmRlYzY3NzcifQ.rWvpuHg5-DBfWxrubaCDIUXlBgOJcRfyhqHhZZpliXA', 0, '2024-01-18 20:29:12', '2024-02-08 13:45:57', NULL, 1, NULL, '213', '533497777\n'),
(14, 'raghad', NULL, '21458700000', 'ra@email.com', 'syria', '2000-05-18 00:00:00', 2, 'single', '9782114.webp', NULL, 0, '2024-02-01 07:12:20', '2024-02-01 07:12:21', NULL, 1, NULL, '214', '58700000'),
(15, 'tesyyyt', NULL, '213777777777', 'hhel@hh.lo', 'الجزائر', '2024-02-16 00:00:00', 2, NULL, '7137915.webp', NULL, 0, '2024-02-15 22:08:38', '2024-03-03 13:15:38', NULL, 1, NULL, '213', '777777777'),
(16, 'dina test', NULL, '213111111111', 'dina@gmail.com', 'الجزائر', '2024-01-01 00:00:00', 2, 'Married', '8632416.webp', NULL, 0, '2024-02-16 17:31:55', '2024-03-03 13:19:19', NULL, 0, NULL, '213', '111111111'),
(17, 'ahmadd', NULL, '213944917252', 'abc@xyz.com', 'سوريا', '2000-10-20 00:00:00', 1, 'married', '4385517.webp', NULL, 0, '2024-02-17 12:09:04', '2024-02-19 13:59:22', NULL, 1, NULL, '213', '944917252'),
(20, 'dina test', NULL, '213111111111', 'dina@gmail.com', 'الجزائر', '2024-02-25 00:00:00', 2, 'Married', NULL, NULL, 0, '2024-02-25 11:03:53', '2024-02-25 11:04:20', NULL, 0, NULL, '213', '111111111'),
(21, 'test test', NULL, '213222222222', 'test@gmil.com', 'الجزائر', '2024-02-28 00:00:00', 2, 'Single', '8551021.webp', NULL, 4000, '2024-02-28 08:57:40', '2024-03-18 09:34:25', NULL, 1, NULL, '213', '222222222'),
(22, 'محمد نعساني', NULL, '963966376308', 'mnasani79@gmail.com', 'سوريا', '1979-02-19 00:00:00', 1, 'Married', NULL, NULL, 4000, '2024-03-06 17:50:23', '2024-03-18 09:38:34', NULL, 1, NULL, '213', '963966376308'),
(36, 'احمد مصري', NULL, '+963935189509', 'najyms@gmail.com', 'سوريا', '1990-03-18 00:00:00', 1, 'Married', NULL, NULL, 2600, '2024-03-18 09:20:31', '2024-03-18 10:08:15', NULL, 1, NULL, '+963', '935189509'),
(37, 'yasin1', NULL, '+963944917252', 'Yasinidlbi@gmail.com', 'الكويت', '2024-03-19 00:00:00', 1, 'Married', NULL, NULL, 0, '2024-03-18 20:08:38', '2024-03-18 20:08:38', NULL, 1, NULL, '+963', '944917252');

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

DROP TABLE IF EXISTS `companies`;
CREATE TABLE `companies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `point_balance` decimal(8,2) DEFAULT 0.00,
  `point_profit` decimal(8,2) DEFAULT 0.00,
  `cash_balance` decimal(8,2) DEFAULT 0.00,
  `cash_profit` decimal(8,2) DEFAULT 0.00,
  `notes` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `companies`
--

INSERT INTO `companies` (`id`, `point_balance`, `point_profit`, `cash_balance`, `cash_profit`, `notes`, `created_at`, `updated_at`) VALUES
(1, 200.00, 0.00, 11200.00, 0.00, '', NULL, '2024-03-18 09:47:15');

-- --------------------------------------------------------

--
-- Table structure for table `experts`
--

DROP TABLE IF EXISTS `experts`;
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
  `token` text DEFAULT NULL,
  `password` varchar(200) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL,
  `answer_speed` decimal(8,2) DEFAULT NULL,
  `first_name` varchar(200) DEFAULT NULL,
  `last_name` varchar(200) DEFAULT NULL,
  `record` text DEFAULT NULL,
  `country_code` varchar(200) DEFAULT NULL,
  `country_num` varchar(200) DEFAULT NULL,
  `mobile_num` varchar(200) DEFAULT NULL,
  `is_available` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `experts`
--

INSERT INTO `experts` (`id`, `user_name`, `mobile`, `email`, `nationality`, `birthdate`, `gender`, `marital_status`, `image`, `points_balance`, `cash_balance`, `cash_balance_todate`, `rates`, `desc`, `call_cost`, `token`, `password`, `created_at`, `updated_at`, `is_active`, `answer_speed`, `first_name`, `last_name`, `record`, `country_code`, `country_num`, `mobile_num`, `is_available`) VALUES
(1, 'expert1', '+213969459459', 'experwwt@gmail.com', 'Syrian', '2000-01-01 00:00:00', 1, 'm', '352171.webp', 0, 0.00, 0.00, 0.00, 'انا دكتور في علم الطاقةانا دكتور في علم الطاقةانا دكتور في علم الطاقةانا دكتور في علم الطاقةانا دكتور في علم الطاقةانا دكتور في علم الطاقةانا دكتور في علم الطاقةانا دكتور في علم الطاقةانا دكتور في علم الطاقةانا دكتور في علم الطاقةانا دكتور في علم الطاقةانا دكتور في علم الطاقةانا دكتور في علم الطاقةانا دكتور في علم الطاقة', 0, '', '$2y$12$hmb198tlznpCuj4fUy3uW.9XBUdfNdbQe7JD52ok4VN3K8G.q3uJC', NULL, '2024-03-18 09:16:38', 1, 0.00, 'محمد', 'السعيد', '602631.mp3', NULL, '+213', '969459459', 1),
(2, 'expert2', '+213265498789', 'expert2012@gmail.com', 'Syrian', '2000-01-01 00:00:00', 1, 'm', '331772.webp', 0, 0.00, 0.00, 0.00, NULL, 0, NULL, '$2y$12$A3aKZ9WoZKtDQvTDsxqxx.FucOJGrS0sqiFjtduiIrJuY6K.JTNuq', NULL, '2024-03-12 09:50:32', 1, 0.00, 'ahmad', 'ms', '15562135.mp3', NULL, '+213', '265498789', 0),
(3, 'expert3', '+213629599511', 'abc@xyz.com', 'Syrian', '1990-10-20 00:00:00', 1, 'm', '240733.webp', 0, 0.00, 0.00, 0.00, 'xyz abc xyz abc', 0, NULL, '$2y$12$ZJWOskt6dMUFNuhSgj8pIeI8y9eYbxvb5tMVfHcOeSUGUqzDGWWrS', NULL, '2024-03-12 11:40:23', 1, 0.00, 'احمد', 'نجار', NULL, NULL, '+213', '629599511', 0),
(7, 'expert-4', '+213956464987', 'dsssw@ononon.com', NULL, '2000-02-05 00:00:00', 1, NULL, NULL, 0, 0.00, 0.00, 0.00, NULL, 0, NULL, '$2y$12$AY0yFfKsCh1o0q/ucYa1b.Z8OsmWLWHg50H7CDTeJ6HrMUT3CRtJS', '2024-02-09 20:04:35', '2024-03-18 10:26:40', 1, 0.00, 'احمد', 'السالم', NULL, NULL, '+213', '956464987', 0),
(13, 'expert10', '+213265489758', 'abc@ononon.com', NULL, '1990-10-20 00:00:00', 1, NULL, '5988313.webp', 0, 0.00, 0.00, 0.00, 'xyz abc xyz abc', 0, NULL, '$2y$12$06BJ6yVqan1kfa.ByoHxdeZb0nQ1eWeMZCcc111qez0QKWT1A8uc.', '2024-02-24 12:34:30', '2024-03-12 09:52:38', 1, 0.00, 'احمد', 'نجار', NULL, NULL, '+213', '265489758', 0);

-- --------------------------------------------------------

--
-- Table structure for table `expertsfavorites`
--

DROP TABLE IF EXISTS `expertsfavorites`;
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
(2, 13, 2, NULL, NULL),
(5, 13, 1, '2024-02-10 14:30:09', '2024-02-10 14:30:09'),
(8, 22, 1, '2024-03-06 17:54:28', '2024-03-06 17:54:28'),
(9, 22, 2, '2024-03-06 17:54:31', '2024-03-06 17:54:31'),
(10, 17, 1, '2024-03-07 21:15:08', '2024-03-07 21:15:08'),
(11, 10, 1, '2024-03-07 21:15:08', '2024-03-07 21:15:08');

-- --------------------------------------------------------

--
-- Table structure for table `experts_services`
--

DROP TABLE IF EXISTS `experts_services`;
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
(5, 2, 20, NULL, NULL, 200, 0.00, 0, 0.00),
(6, 3, 1, NULL, NULL, 200, 0.00, 0, 0.00),
(49, 1, 2, '2024-02-12 20:17:29', '2024-02-28 13:05:33', 200, 0.00, 0, 0.00),
(50, 7, 2, '2024-02-12 20:22:32', '2024-02-12 20:22:32', 100, 0.00, 0, 0.00),
(52, 1, 23, '2024-02-22 13:41:02', '2024-02-22 13:41:02', 200, 0.00, 0, 0.00),
(53, 7, 20, '2024-03-02 13:08:05', '2024-03-02 13:08:05', 200, 0.00, 0, 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
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

DROP TABLE IF EXISTS `inputs`;
CREATE TABLE `inputs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(200) NOT NULL,
  `type` varchar(200) NOT NULL,
  `tooltipe` varchar(200) NOT NULL,
  `icon` text DEFAULT NULL,
  `ispersonal` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `image_count` int(11) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `inputs`
--

INSERT INTO `inputs` (`id`, `name`, `type`, `tooltipe`, `icon`, `ispersonal`, `created_at`, `updated_at`, `image_count`, `is_active`) VALUES
(1, 'user_name', 'text', 'الاسم', 'username.svg', 1, NULL, NULL, 0, 1),
(2, 'mobile', 'text', 'الموبيل', NULL, 1, NULL, NULL, 0, 1),
(3, 'nationality', 'nationality', 'الجنسية', NULL, 1, NULL, NULL, 0, 1),
(4, 'birthdate', 'date', 'تاريخ الميلاد', 'birthdate.svg', 1, NULL, NULL, 0, 1),
(5, 'gender', 'list', 'الجنس', 'gender.svg', 1, NULL, NULL, 0, 1),
(6, 'marital_status', 'list', 'الحالة الاجتماعية', 'martial.svg', 1, NULL, NULL, 0, 1),
(7, 'الوضع الدراسي', 'list', 'الوضع الدراسي', NULL, 0, NULL, NULL, 0, 1),
(8, 'العمل الحالي', 'text', 'العمل الحالي', NULL, 0, NULL, NULL, 0, 1),
(9, 'هل يوجد مرض مزمن', 'bool', 'هل يوجد مرض مزمن', NULL, 0, NULL, NULL, 0, 1),
(24, 'record', 'record', '', '', 0, '2024-02-01 19:04:27', '2024-02-01 19:04:27', 0, 1),
(25, 'image', 'image', '', '', 0, '2024-02-01 19:04:27', '2024-02-01 19:04:27', 4, 1),
(48, 'record', 'record', '', '', 0, '2024-02-03 13:25:04', '2024-02-03 13:25:04', 0, 1),
(49, 'image', 'image', '', '', 0, '2024-02-03 13:25:04', '2024-02-09 11:10:49', 2, 1),
(65, 'name f', 'text', 'tooltipwww', '9455365.svg', 0, '2024-02-09 11:10:41', '2024-02-09 11:10:41', 0, 1),
(66, 'advsav', 'text', 'rrrr', NULL, 0, '2024-02-10 13:00:48', '2024-02-10 13:02:24', 0, 1),
(70, 'هل لديك مرض مزمن', 'bool', 'هل لديك مرض مزمن', '5094870.svg', 0, '2024-02-22 13:38:46', '2024-02-22 13:38:46', 0, 1),
(71, 'تحدث عن مشكلتك الصحية', 'longtext', 'تحدث عن مشكلتك الصحية', '9303871.svg', 0, '2024-02-22 13:39:33', '2024-02-22 13:39:33', 0, 1),
(72, 'متى بدأت المشكلة', 'date', 'متى بدأت المشكلة', '4558772.svg', 0, '2024-02-22 13:40:14', '2024-02-22 13:40:14', 0, 1),
(75, 'record', 'record', '', '', 0, '2024-02-28 12:44:34', '2024-02-28 12:44:34', 0, 1),
(76, 'image', 'image', '', '', 0, '2024-02-28 12:44:34', '2024-02-28 12:44:34', 4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `inputs_services`
--

DROP TABLE IF EXISTS `inputs_services`;
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
(30, 1, 3, '2024-02-01 19:04:20', '2024-02-01 19:04:20'),
(31, 1, 6, '2024-02-01 19:04:20', '2024-02-01 19:04:20'),
(32, 1, 24, '2024-02-01 19:04:27', '2024-02-01 19:04:27'),
(33, 1, 25, '2024-02-01 19:04:27', '2024-02-01 19:04:27'),
(80, 23, 1, '2024-02-22 13:37:23', '2024-02-22 13:37:23'),
(81, 23, 3, '2024-02-22 13:37:23', '2024-02-22 13:37:23'),
(82, 23, 5, '2024-02-22 13:37:23', '2024-02-22 13:37:23'),
(83, 23, 4, '2024-02-22 13:37:23', '2024-02-22 13:37:23'),
(84, 23, 6, '2024-02-22 13:37:23', '2024-02-22 13:37:23'),
(87, 23, 70, '2024-02-22 13:38:46', '2024-02-22 13:38:46'),
(88, 23, 71, '2024-02-22 13:39:33', '2024-02-22 13:39:33'),
(89, 23, 72, '2024-02-22 13:40:14', '2024-02-22 13:40:14'),
(92, 2, 75, '2024-02-28 12:44:34', '2024-02-28 12:44:34'),
(93, 2, 76, '2024-02-28 12:44:34', '2024-02-28 12:44:34'),
(94, 2, 1, '2024-02-28 12:44:37', '2024-02-28 12:44:37'),
(95, 2, 3, '2024-02-28 12:44:37', '2024-02-28 12:44:37'),
(96, 2, 5, '2024-02-28 12:44:37', '2024-02-28 12:44:37'),
(97, 2, 4, '2024-02-28 12:44:37', '2024-02-28 12:44:37'),
(98, 2, 6, '2024-02-28 12:44:37', '2024-02-28 12:44:37');

-- --------------------------------------------------------

--
-- Table structure for table `inputvalues`
--

DROP TABLE IF EXISTS `inputvalues`;
CREATE TABLE `inputvalues` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `value` varchar(200) NOT NULL,
  `input_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `inputvalues`
--

INSERT INTO `inputvalues` (`id`, `value`, `input_id`, `created_at`, `updated_at`, `is_active`) VALUES
(1, 'اعدادي', 7, NULL, NULL, 1),
(2, 'ثانوي', 7, NULL, NULL, 1),
(3, 'معهد', 7, NULL, NULL, 1),
(4, 'اجازة جامعية', 7, NULL, NULL, 1),
(5, 'دراسات عليا', 7, NULL, NULL, 1),
(6, 'aa', 28, '2024-02-02 16:19:29', '2024-02-02 16:19:29', 1),
(7, 'ds', 31, '2024-02-02 16:22:30', '2024-02-02 16:22:30', 1),
(8, '1', 5, NULL, NULL, 1),
(9, '2', 5, NULL, NULL, 1),
(10, 'single', 6, NULL, NULL, 1),
(11, 'married', 6, NULL, NULL, 1),
(12, 'divorced', 6, NULL, NULL, 1),
(13, 'widower', 6, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
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
(53, '2024_01_31_211919_add_is_callservice_to_services_table', 28),
(54, '2024_02_02_181449_add_is_active_to_inputs_table', 29),
(55, '2024_02_02_181513_add_is_active_to_inputvalues_table', 29),
(56, '2024_02_04_160634_add_expert_percent_to_services_table', 30),
(57, '2024_02_04_161836_add_name_to_values_services_table', 30),
(58, '2024_02_04_163843_change_expert_percent_to_services_table', 31),
(59, '2024_02_05_210300_change_name_in_values_services_table', 32),
(60, '2024_02_08_154224_change_token_in_clients_table', 33),
(61, '2024_02_08_154244_change_token_in_experts_table', 33),
(62, '2024_02_08_154256_change_token_in_users_table', 33),
(63, '2024_02_12_193320_create_settings_table', 34),
(64, '2024_02_12_195152_add_ar_name_to_settings_table', 35),
(65, '2024_02_13_133435_create_notifications_table', 36),
(66, '2024_02_14_214709_add_comment_date_to_selectedservices_table', 37),
(67, '2024_02_14_220716_create_answers_table', 37),
(68, '2024_02_15_115410_drop_answer2_from_selectedservices_table', 38),
(69, '2024_02_15_120613_create_companies_table', 39),
(70, '2024_02_15_120707_add_company_profit_to_selectedservices_table', 39),
(71, '2024_02_17_214543_add_form_reject_reason_to_selectedservices_table', 40),
(72, '2024_02_19_183752_add_state_to_pointstransfers_table', 41),
(73, '2024_02_20_163306_change_id_in_notifications_table', 42),
(74, '2024_02_20_163619_add_id_to_notifications_table', 43),
(75, '2024_02_20_163836_drop_notifiable_type_in_notifications_table', 44),
(76, '2024_02_20_165438_create_notifications_users_table', 45),
(77, '2024_02_21_152603_add_source_id_to_pointstransfers_table', 46),
(78, '2024_02_22_131501_add_selectedservice_id_to_cashtransfers_table', 47),
(79, '2024_02_22_133725_add_source_id_to_cashtransfers_table', 48),
(80, '2024_03_01_212640_add_order_num_to_selectedservices_table', 49),
(81, '2024_03_02_103549_add_rate_date_to_selectedservices_table', 50),
(82, '2024_03_06_192933_add_answer_speed_to_selectedservices_table', 51),
(83, '2024_03_10_154242_change_count_in_pointstransfers_table', 52),
(84, '2024_03_11_092702_add_country_code_to_experts_table', 53),
(85, '2024_03_11_092715_add_country_code_to_clients_table', 53);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
CREATE TABLE `notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` text NOT NULL,
  `body` text NOT NULL,
  `type` varchar(200) NOT NULL,
  `side` varchar(200) NOT NULL,
  `data` text NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `notes` text NOT NULL,
  `createuser_id` bigint(20) UNSIGNED DEFAULT NULL,
  `updateuser_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notifications_users`
--

DROP TABLE IF EXISTS `notifications_users`;
CREATE TABLE `notifications_users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `notification_id` bigint(20) UNSIGNED DEFAULT NULL,
  `client_id` bigint(20) UNSIGNED DEFAULT NULL,
  `expert_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `isread` tinyint(1) DEFAULT NULL,
  `read_at` datetime DEFAULT NULL,
  `state` varchar(200) DEFAULT NULL,
  `notes` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets` (
  `email` varchar(200) NOT NULL,
  `token` varchar(200) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(200) NOT NULL,
  `token` varchar(200) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_reset_tokens`
--

INSERT INTO `password_reset_tokens` (`email`, `token`, `created_at`) VALUES
('najims833@gmail.com', '$2y$12$eLcUpwDt.rfaVHjn2LAfUOfuo9hx6419l9H5n481Fpcry/xvAkyV6', '2024-03-14 13:18:48'),
('najyms@gmail.com', '$2y$12$c09Ic.LgaD3DXbTRzeN8feQQSxb9bm/AxjByAVRtCLs.3YqCN/GNG', '2024-03-14 13:49:33');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
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

DROP TABLE IF EXISTS `personal_access_tokens`;
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

DROP TABLE IF EXISTS `points`;
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
(2, 110, 100.00, 100.00, 0, NULL, NULL, '2024-01-28 19:05:30', '2024-03-17 18:03:56', 1),
(5, 110, 100.00, 100.00, 90, NULL, NULL, '2024-01-31 18:59:15', '2024-01-31 18:59:52', 1),
(6, 200, 200.00, 0.00, 0, NULL, NULL, '2024-02-29 12:09:43', '2024-02-29 12:09:43', 1),
(7, 300, 300.00, 0.00, 0, NULL, NULL, '2024-02-29 12:09:55', '2024-02-29 12:09:55', 1),
(17, 1000, 1000.00, 0.00, 0, NULL, NULL, '2024-03-18 11:00:34', '2024-03-18 11:00:34', 1);

-- --------------------------------------------------------

--
-- Table structure for table `pointstransfers`
--

DROP TABLE IF EXISTS `pointstransfers`;
CREATE TABLE `pointstransfers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `point_id` bigint(20) UNSIGNED DEFAULT NULL,
  `client_id` bigint(20) UNSIGNED DEFAULT NULL,
  `expert_id` bigint(20) UNSIGNED DEFAULT NULL,
  `service_id` bigint(20) UNSIGNED DEFAULT NULL,
  `count` decimal(8,2) DEFAULT 0.00,
  `status` int(11) DEFAULT 0,
  `selectedservice_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `side` varchar(200) NOT NULL,
  `state` varchar(200) DEFAULT NULL,
  `type` varchar(200) DEFAULT NULL,
  `source_id` bigint(20) UNSIGNED DEFAULT NULL,
  `num` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pointstransfers`
--

INSERT INTO `pointstransfers` (`id`, `point_id`, `client_id`, `expert_id`, `service_id`, `count`, `status`, `selectedservice_id`, `created_at`, `updated_at`, `side`, `state`, `type`, `source_id`, `num`) VALUES
(136, 17, 36, NULL, NULL, 1000.00, 1, NULL, '2024-03-18 09:30:39', '2024-03-18 09:30:39', 'to-client', 'points', 'p', NULL, 'PCL-000001'),
(137, 17, 36, NULL, NULL, 1000.00, 1, NULL, '2024-03-18 09:30:54', '2024-03-18 09:30:54', 'to-client', 'points', 'p', NULL, 'PCL-000002'),
(138, 17, 36, NULL, NULL, 1000.00, 1, NULL, '2024-03-18 09:30:56', '2024-03-18 09:30:56', 'to-client', 'points', 'p', NULL, 'PCL-000003'),
(139, 17, 21, NULL, NULL, 1000.00, 1, NULL, '2024-03-18 09:34:15', '2024-03-18 09:34:15', 'to-client', 'points', 'p', NULL, 'PCL-000004'),
(140, 17, 21, NULL, NULL, 1000.00, 1, NULL, '2024-03-18 09:34:17', '2024-03-18 09:34:17', 'to-client', 'points', 'p', NULL, 'PCL-000005'),
(141, 17, 21, NULL, NULL, 1000.00, 1, NULL, '2024-03-18 09:34:18', '2024-03-18 09:34:18', 'to-client', 'points', 'p', NULL, 'PCL-000006'),
(142, 17, 21, NULL, NULL, 1000.00, 1, NULL, '2024-03-18 09:34:25', '2024-03-18 09:34:25', 'to-client', 'points', 'p', NULL, 'PCL-000007'),
(143, 17, 22, NULL, NULL, 1000.00, 1, NULL, '2024-03-18 09:38:29', '2024-03-18 09:38:29', 'to-client', 'points', 'p', NULL, 'PCL-000008'),
(144, 17, 22, NULL, NULL, 1000.00, 1, NULL, '2024-03-18 09:38:31', '2024-03-18 09:38:31', 'to-client', 'points', 'p', NULL, 'PCL-000009'),
(145, 17, 22, NULL, NULL, 1000.00, 1, NULL, '2024-03-18 09:38:33', '2024-03-18 09:38:33', 'to-client', 'points', 'p', NULL, 'PCL-000010'),
(146, 17, 22, NULL, NULL, 1000.00, 1, NULL, '2024-03-18 09:38:34', '2024-03-18 09:38:34', 'to-client', 'points', 'p', NULL, 'PCL-000011'),
(147, NULL, 36, 1, 2, 200.00, 1, 70, '2024-03-18 09:45:33', '2024-03-18 09:47:15', 'from-client', 'agree', 'd', NULL, 'DCL-000001'),
(148, NULL, 36, 1, 1, 200.00, 1, 71, '2024-03-18 09:48:49', '2024-03-18 09:58:58', 'from-client', 'reject', 'd', NULL, 'DCL-000002'),
(149, NULL, 36, 1, 1, 200.00, 1, 71, '2024-03-18 09:58:58', '2024-03-18 09:58:58', 'to-client', 'reject-return', 'p', 148, 'PCL-000012'),
(150, NULL, 36, 1, 1, 200.00, 1, 72, '2024-03-18 10:08:15', '2024-03-18 10:08:15', 'from-client', 'wait', 'd', NULL, 'DCL-000003');

-- --------------------------------------------------------

--
-- Table structure for table `reasons`
--

DROP TABLE IF EXISTS `reasons`;
CREATE TABLE `reasons` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `content` varchar(200) DEFAULT NULL,
  `type` varchar(200) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reasons`
--

INSERT INTO `reasons` (`id`, `content`, `type`, `created_at`, `updated_at`, `is_active`) VALUES
(1, 'غير مطابق للشروط والاحكام', 'form', NULL, NULL, 1),
(2, 'غير مناسب', 'form', NULL, NULL, 1),
(3, 'اسباب اخرى', 'form', NULL, NULL, 1),
(4, 'غير مطابق للشروط والاحكام', 'answer', NULL, NULL, 1),
(5, 'اسباب اخرى', 'answer', NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `selectedservices`
--

DROP TABLE IF EXISTS `selectedservices`;
CREATE TABLE `selectedservices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `expert_id` bigint(20) UNSIGNED DEFAULT NULL,
  `service_id` bigint(20) UNSIGNED DEFAULT NULL,
  `points` int(11) DEFAULT 0,
  `rate` decimal(8,2) DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `order_num` varchar(200) DEFAULT NULL,
  `form_state` varchar(200) DEFAULT NULL,
  `form_reject_reason` varchar(200) DEFAULT NULL,
  `order_date` datetime DEFAULT NULL,
  `order_admin_date` datetime DEFAULT NULL,
  `order_admin_id` bigint(20) UNSIGNED DEFAULT NULL,
  `comment` text DEFAULT NULL,
  `comment_date` datetime DEFAULT NULL,
  `comment_state` varchar(200) DEFAULT NULL,
  `comment_reject_reason` varchar(200) DEFAULT NULL,
  `comment_rate` int(11) NOT NULL DEFAULT 0,
  `status` varchar(200) NOT NULL,
  `expert_cost` decimal(8,2) DEFAULT 0.00,
  `cost_type` decimal(8,2) DEFAULT 0.00,
  `expert_cost_value` decimal(8,2) DEFAULT 0.00,
  `company_profit` decimal(8,2) DEFAULT 0.00,
  `company_profit_percent` decimal(8,2) DEFAULT 0.00,
  `comment_user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `comment_admin_date` datetime DEFAULT NULL,
  `rate_date` datetime DEFAULT NULL,
  `comment_rate_date` datetime DEFAULT NULL,
  `comment_rate_admin_id` bigint(20) UNSIGNED DEFAULT NULL,
  `answer_speed` decimal(8,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `selectedservices`
--

INSERT INTO `selectedservices` (`id`, `client_id`, `expert_id`, `service_id`, `points`, `rate`, `created_at`, `updated_at`, `order_num`, `form_state`, `form_reject_reason`, `order_date`, `order_admin_date`, `order_admin_id`, `comment`, `comment_date`, `comment_state`, `comment_reject_reason`, `comment_rate`, `status`, `expert_cost`, `cost_type`, `expert_cost_value`, `company_profit`, `company_profit_percent`, `comment_user_id`, `comment_admin_date`, `rate_date`, `comment_rate_date`, `comment_rate_admin_id`, `answer_speed`) VALUES
(70, 36, 1, 2, 200, 0.00, '2024-03-18 09:45:33', '2024-03-18 09:47:15', 'ORDER-000001', 'agree', NULL, '2024-03-18 12:45:33', '2024-03-18 12:47:15', 1, '', NULL, NULL, NULL, 0, 'created', 10.00, 0.00, 20.00, 0.00, 0.00, NULL, NULL, NULL, NULL, NULL, 0.00),
(71, 36, 1, 1, 200, 0.00, '2024-03-18 09:48:49', '2024-03-18 09:58:58', 'ORDER-000002', 'reject', 'غير مطابق للشروط والاحكام', '2024-03-18 12:48:49', '2024-03-18 12:58:58', 1, '', NULL, NULL, NULL, 0, 'created', 6.60, 1.00, 13.20, 0.00, 0.00, NULL, NULL, NULL, NULL, NULL, 0.00),
(72, 36, 1, 1, 200, 0.00, '2024-03-18 10:08:15', '2024-03-18 10:08:15', 'ORDER-000003', 'wait', NULL, '2024-03-18 13:08:15', NULL, NULL, '', NULL, NULL, NULL, 0, 'created', 6.60, 1.00, 13.20, 0.00, 0.00, NULL, NULL, NULL, NULL, NULL, 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

DROP TABLE IF EXISTS `services`;
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
  `is_callservice` int(11) DEFAULT 0,
  `expert_percent` decimal(8,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `name`, `desc`, `image`, `createuser_id`, `updateuser_id`, `created_at`, `updated_at`, `icon`, `is_active`, `is_callservice`, `expert_percent`) VALUES
(1, 'طاقة 1الشفاء', 'طاقة  الشفاء 1', '895841.webp', NULL, 1, NULL, '2024-02-22 13:29:54', '879541.svg', 1, 0, 6.60),
(2, 'الصحة', 'الصحة', '655182.webp', NULL, 1, NULL, '2024-02-28 13:06:05', '788262.svg', 1, 0, 10.00),
(19, 'اتصال مباشر', ' ', 'callservice.png', 1, 1, '2024-01-31 19:28:03', '2024-01-31 19:28:03', 'callservice.svg', 1, 1, 0.00),
(20, 'طاقة الشفاء', 'العلاج بالطاقة', '2383720.webp', 1, 1, '2024-01-31 19:29:36', '2024-02-11 17:30:39', '9302820.svg', 1, 0, 10.00),
(23, 'استشارة طبية', 'استشارة طبية', '2348623.webp', 1, 1, '2024-02-22 13:32:32', '2024-02-22 13:42:21', '3063923.svg', 1, 0, 20.00);

-- --------------------------------------------------------

--
-- Table structure for table `servicesfavorites`
--

DROP TABLE IF EXISTS `servicesfavorites`;
CREATE TABLE `servicesfavorites` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED DEFAULT NULL,
  `service_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(200) DEFAULT NULL,
  `value` text DEFAULT NULL,
  `type` varchar(200) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `updateuser_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `ar_name` varchar(200) DEFAULT NULL,
  `sequence` int(11) DEFAULT 0,
  `dept` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `name`, `value`, `type`, `notes`, `updateuser_id`, `created_at`, `updated_at`, `ar_name`, `sequence`, `dept`) VALUES
(1, 'expert_percent', '10', 'decimal', NULL, NULL, NULL, '2024-02-14 11:05:30', 'نسبة الخبير الافتراضية', 0, NULL),
(2, 'expert_service_points', '200', 'decimal', NULL, NULL, NULL, '2024-02-14 11:05:52', 'النقاط الافتراضية', 0, NULL),
(3, 'secret_key', 'sk_test_51OixcfJifccNTBbxOq8WNVWmSxV2cEKNlZtH5R4vZ8KRIwWQku5MIMQ0tuaCiafkdvM4QQbSk8eFkxcGF6Wpuutn003q1wl281', 'string', NULL, NULL, NULL, '2024-02-14 11:05:52', 'Secret key', 0, 'payment'),
(4, 'publishable_key', 'pk_test_51OixcfJifccNTBbxp9uOqin9nVSx6UOb6KE6JaWDnMSbbsxAUICBdBByrXLa8G6sPAhO2PDtBFjTJudgRHOjQDP600pI5owy1m', 'string', NULL, NULL, NULL, '2024-02-14 11:05:52', 'Publishable key', 0, 'payment');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
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
  `token` text DEFAULT NULL,
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
(1, 'ahmad', 'najyms@gmail.com', NULL, '$2y$12$hmb198tlznpCuj4fUy3uW.9XBUdfNdbQe7JD52ok4VN3K8G.q3uJC', 'ahmad', 'ms', NULL, 'admin', 'cuazVdoOzmwIySszyF2Hm6:APA91bEYValX5_T_V8vxWG693VEfGlytytYEiQi3IYZ-YQ2y5cYa1riz6Ox4f15YuEokXslKmELDXjamslqiT4ySDD8cC2uQo5SURTkf3Vq87fbhfrOqeYOggOGEiz075bTAepER4dNj', NULL, 1, NULL, NULL, '2024-01-11 12:47:38', '2024-03-18 15:51:49', '109301.webp', 1),
(2, 'super1', 'super@gmail.com', NULL, '$2y$12$Bhtt5mZSK0f6kkE3qc54m.C0p1YwjfNH/eBE93BV25mp1s0Om1SJG', 'super', 'super', NULL, 'super', NULL, NULL, 1, NULL, NULL, '2024-01-11 12:48:33', '2024-01-25 17:29:17', '274822.webp', 1),
(3, 'admin@gmail.com', 'jjjjjj@gmail.com', NULL, '$2y$12$CkkT3KMcnk2qq1M9HIExPOmY7JO0yJThW.9Gv08V3uPxj.aI/pY.C', 'yumyu', 'ergerg', NULL, 'super', NULL, 1, 1, '0213456789', NULL, '2024-02-18 11:28:55', '2024-02-18 11:28:55', NULL, 1),
(8, 'user1', 'najims833@gmail.com', NULL, '$2y$12$54YLe6Epl6E0ruhQaNj6ruVe32Ll9mQsoe8evlwmf.zLXzRwPdDlG', 'casc', 'ascv', NULL, 'admin', 'cUqZTkolu1pz2-74npIClM:APA91bHIqKoY5CXg0lugNY_u7s82bRz-M8eakf_QcsNqjn7fpvMgQMVMukBIfnXF-AsyIN-F-yfL0vijm-WWD1EhMoT2OeoVSH9bi-xO8KSVQRFjZrLPXD7sBvtTK1AsVzaAbEk-tweN', 1, 8, '8111434342', NULL, '2024-01-22 13:51:09', '2024-03-13 11:06:42', NULL, 1),
(9, 'client', 'client@gmail.com', NULL, '$2y$12$t9tCCSF76pHXuuqHctkWpePmE2.Ng190NI2m0hAOLp3ZiMq8tj.XK', 'ahmad', 'ms', NULL, 'admin', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvYXBpL2xvZ2luY2xpZW50IiwiaWF0IjoxNzA3NDA3MTU3LCJuYmYiOjE3MDc0MDcxNTcsImp0aSI6IkZvUFZYMllrT2VqMHJ1TjkiLCJzdWIiOiIxMyIsInBydiI6IjQxZWZiN2JhZDdmNmY2MzJlMjQwNWJkM2E3OTNiOGE2YmRlYzY3NzcifQ.rWvpuHg5-DBfWxrubaCDIUXlBgOJcRfyhqHhZZpliXA', 1, 1, '1234123444', NULL, '2024-01-22 13:56:56', '2024-02-08 13:48:29', NULL, 1),
(11, 'ahmadahmad', 'adminuser@gmail.com', NULL, '$2y$12$6BjwnUF9jB5NgFAIclCsIOlwr2CyjIuvGiORWedjX6eQKo/3q.CYa', 'احمد', 'محمد', NULL, 'admin', 'f22i4Dh75_SupfLYkUEVit:APA91bGph_GirA_BYppqL81YqLuqDsmGhC5dRf9n51XrZdRI8UAoAz9mdtRkPjwHTayvaAGnNdE65iXwhEpA1MGMx-MRFu_Yo5ce4FpovPEWgO3GcZj_HQzquCq-RUtKUiHmyanDfuxq', 1, 1, '0995959959', NULL, '2024-01-23 13:06:37', '2024-02-08 12:57:58', '2317011.webp', 1),
(12, 'ahmad11', 'dsw@ononon.com', NULL, '$2y$12$NPrwOkxJ8Ef/Ho7gWa2PkOZbptrGQFPzkYk16p0Sf/xTN6jlhtQBW', 'ahmad', 'ms', NULL, 'super', NULL, 1, 1, '1202056511', NULL, '2024-01-23 14:47:04', '2024-01-23 14:47:04', '7897012.webp', 1),
(14, 'user', 'user@gmail.com', NULL, '$2y$12$DJDAYspBduZd067VrYvl9OCA4sdZMci9GglFL9M5CSa3oECxttGme', 'user', 'user', NULL, 'admin', NULL, 1, 1, NULL, NULL, '2024-03-18 11:36:43', '2024-03-18 11:36:43', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `values_services`
--

DROP TABLE IF EXISTS `values_services`;
CREATE TABLE `values_services` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `value` text NOT NULL,
  `selectedservice_id` bigint(20) UNSIGNED DEFAULT NULL,
  `inputservice_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `name` varchar(200) DEFAULT NULL,
  `type` varchar(200) DEFAULT NULL,
  `tooltipe` varchar(200) DEFAULT NULL,
  `icon` text DEFAULT NULL,
  `ispersonal` tinyint(1) DEFAULT NULL,
  `image_count` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `values_services`
--

INSERT INTO `values_services` (`id`, `value`, `selectedservice_id`, `inputservice_id`, `created_at`, `updated_at`, `name`, `type`, `tooltipe`, `icon`, `ispersonal`, `image_count`) VALUES
(385, 'احمد مصري', 70, 94, '2024-03-18 09:45:33', '2024-03-18 09:45:33', 'user_name', 'text', 'الاسم', 'username.svg', 1, 0),
(386, 'سوريا', 70, 95, '2024-03-18 09:45:33', '2024-03-18 09:45:33', 'nationality', 'nationality', 'الجنسية', NULL, 1, 0),
(387, '1', 70, 96, '2024-03-18 09:45:33', '2024-03-18 09:45:33', 'gender', 'list', 'الجنس', 'gender.svg', 1, 0),
(388, '1990-03-18 00:00:00.000', 70, 97, '2024-03-18 09:45:33', '2024-03-18 09:45:33', 'birthdate', 'date', 'تاريخ الميلاد', 'birthdate.svg', 1, 0),
(389, 'Married', 70, 98, '2024-03-18 09:45:33', '2024-03-18 09:45:33', 'marital_status', 'list', 'الحالة الاجتماعية', 'martial.svg', 1, 0),
(390, '86560390.webp', 70, 93, '2024-03-18 09:45:34', '2024-03-18 09:45:34', 'image', 'image', '', '', 0, 4),
(391, '44856391.', 70, 92, '2024-03-18 09:45:34', '2024-03-18 09:45:34', 'record', 'record', '', '', 0, 0),
(392, 'احمد مصري', 71, 1, '2024-03-18 09:48:49', '2024-03-18 09:48:49', 'user_name', 'text', 'الاسم', 'username.svg', 1, 0),
(393, '1990-03-18 00:00:00.000', 71, 2, '2024-03-18 09:48:49', '2024-03-18 09:48:49', 'birthdate', 'date', 'تاريخ الميلاد', 'birthdate.svg', 1, 0),
(394, '1', 71, 3, '2024-03-18 09:48:49', '2024-03-18 09:48:49', 'gender', 'list', 'الجنس', 'gender.svg', 1, 0),
(395, 'اجازة جامعية', 71, 4, '2024-03-18 09:48:49', '2024-03-18 09:48:49', 'الوضع الدراسي', 'list', 'الوضع الدراسي', NULL, 0, 0),
(396, 'true', 71, 5, '2024-03-18 09:48:49', '2024-03-18 09:48:49', 'هل يوجد مرض مزمن', 'bool', 'هل يوجد مرض مزمن', NULL, 0, 0),
(397, 'سوريا', 71, 30, '2024-03-18 09:48:49', '2024-03-18 09:48:49', 'nationality', 'nationality', 'الجنسية', NULL, 1, 0),
(398, 'Married', 71, 31, '2024-03-18 09:48:49', '2024-03-18 09:48:49', 'marital_status', 'list', 'الحالة الاجتماعية', 'martial.svg', 1, 0),
(399, '73242399.webp', 71, 33, '2024-03-18 09:48:49', '2024-03-18 09:48:50', 'image', 'image', '', '', 0, 4),
(400, 'احمد مصري', 72, 1, '2024-03-18 10:08:15', '2024-03-18 10:08:15', 'user_name', 'text', 'الاسم', 'username.svg', 1, 0),
(401, '1990-03-18 00:00:00.000', 72, 2, '2024-03-18 10:08:15', '2024-03-18 10:08:15', 'birthdate', 'date', 'تاريخ الميلاد', 'birthdate.svg', 1, 0),
(402, '1', 72, 3, '2024-03-18 10:08:15', '2024-03-18 10:08:15', 'gender', 'list', 'الجنس', 'gender.svg', 1, 0),
(403, 'اجازة جامعية', 72, 4, '2024-03-18 10:08:15', '2024-03-18 10:08:15', 'الوضع الدراسي', 'list', 'الوضع الدراسي', NULL, 0, 0),
(404, 'false', 72, 5, '2024-03-18 10:08:15', '2024-03-18 10:08:15', 'هل يوجد مرض مزمن', 'bool', 'هل يوجد مرض مزمن', NULL, 0, 0),
(405, 'سوريا', 72, 30, '2024-03-18 10:08:15', '2024-03-18 10:08:15', 'nationality', 'nationality', 'الجنسية', NULL, 1, 0),
(406, 'Married', 72, 31, '2024-03-18 10:08:15', '2024-03-18 10:08:15', 'marital_status', 'list', 'الحالة الاجتماعية', 'martial.svg', 1, 0),
(407, '73627407.webp', 72, 33, '2024-03-18 10:08:16', '2024-03-18 10:08:16', 'image', 'image', '', '', 0, 4),
(408, '62892408.webp', 72, 33, '2024-03-18 10:08:16', '2024-03-18 10:08:16', 'image', 'image', '', '', 0, 4);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `answers`
--
ALTER TABLE `answers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cashtransfers`
--
ALTER TABLE `cashtransfers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `experts`
--
ALTER TABLE `experts`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications_users`
--
ALTER TABLE `notifications_users`
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
-- Indexes for table `settings`
--
ALTER TABLE `settings`
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
-- AUTO_INCREMENT for table `answers`
--
ALTER TABLE `answers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `cashtransfers`
--
ALTER TABLE `cashtransfers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `companies`
--
ALTER TABLE `companies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `experts`
--
ALTER TABLE `experts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `expertsfavorites`
--
ALTER TABLE `expertsfavorites`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `experts_services`
--
ALTER TABLE `experts_services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inputs`
--
ALTER TABLE `inputs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT for table `inputs_services`
--
ALTER TABLE `inputs_services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99;

--
-- AUTO_INCREMENT for table `inputvalues`
--
ALTER TABLE `inputvalues`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notifications_users`
--
ALTER TABLE `notifications_users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `pointstransfers`
--
ALTER TABLE `pointstransfers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=151;

--
-- AUTO_INCREMENT for table `reasons`
--
ALTER TABLE `reasons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `selectedservices`
--
ALTER TABLE `selectedservices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `servicesfavorites`
--
ALTER TABLE `servicesfavorites`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `values_services`
--
ALTER TABLE `values_services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=409;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
