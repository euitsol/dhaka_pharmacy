-- phpMyAdmin SQL Dump
-- version 5.1.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Feb 25, 2024 at 02:29 PM
-- Server version: 5.7.44-48-log
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dbagn3qmqlgczo`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bio` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `designation` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip` json DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `role_id`, `image`, `bio`, `designation`, `status`, `email`, `email_verified_at`, `password`, `ip`, `remember_token`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`) VALUES
(1, 'Superadmin', 1, NULL, NULL, NULL, 1, 'superadmin@euitsols.com', NULL, '$2y$12$BY80N.eZl8yLcCAul/0ebOdABFqgK..YB/tivntaPlx9BFjC.B.Zy', NULL, NULL, '2024-02-25 16:16:47', '2024-02-25 16:16:47', NULL, NULL, NULL, NULL),
(2, 'Admin', 2, NULL, NULL, NULL, 1, 'admin@euitsols.com', NULL, '$2y$12$65sM./evpW2UBS526tuH2.mzKQEmHhObOAytSNn61En4DD32ZKKl6', NULL, NULL, '2024-02-25 16:16:47', '2024-02-25 16:16:47', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `company_names`
--

CREATE TABLE `company_names` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `address` longtext COLLATE utf8mb4_unicode_ci,
  `note` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `company_names`
--

INSERT INTO `company_names` (`id`, `name`, `slug`, `status`, `address`, `note`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`) VALUES
(1, 'Beximco Pharmaceuticals Ltd', 'beximco-pharmaceuticals-ltd', 1, NULL, NULL, '2024-02-25 16:16:50', '2024-02-25 16:16:50', NULL, NULL, NULL, NULL),
(2, 'SUN PHARMACEUTICAL BANGLADESH LIMITED', 'sun-pharmaceutical-bangladesh-limited', 1, NULL, NULL, '2024-02-25 16:16:50', '2024-02-25 16:16:50', NULL, NULL, NULL, NULL),
(3, 'Incepta Pharmaceuticals Ltd.', 'incepta-pharmaceuticals-ltd.', 1, NULL, NULL, '2024-02-25 16:16:50', '2024-02-25 19:49:15', '2024-02-25 19:49:15', NULL, NULL, NULL),
(4, 'RADIANT PHARMACEUTICALS LIMITED', 'radiant-pharmaceuticals-limited', 1, NULL, NULL, '2024-02-25 16:16:50', '2024-02-25 16:16:50', NULL, NULL, NULL, NULL),
(5, 'ARISTOPHARMA LTD', 'aristopharma-ltd', 1, NULL, NULL, '2024-02-25 16:16:50', '2024-02-25 16:16:50', NULL, NULL, NULL, NULL),
(6, 'SQUARE PHARMACEUTICALS LIMITED', 'square-pharmaceuticals-limited', 1, NULL, NULL, '2024-02-25 16:16:50', '2024-02-25 16:16:50', NULL, NULL, NULL, NULL),
(7, 'Square Pharmaceuticals Ltd.', 'square-pharmaceuticals-ltd', 1, NULL, NULL, '2024-02-25 16:20:00', '2024-02-25 16:20:00', NULL, 2, NULL, NULL),
(8, 'ACI Limited', 'aci-limited', 1, NULL, NULL, '2024-02-25 17:24:58', '2024-02-25 17:24:58', NULL, 2, NULL, NULL),
(9, 'Eskayef Bangladesh Ltd', 'eskayef-bangladesh-ltd', 1, NULL, NULL, '2024-02-25 17:55:46', '2024-02-25 17:55:46', NULL, 2, NULL, NULL),
(10, 'Sun Pharmaceutical Ltd', 'sun-pharmaceutical-ltd', 1, NULL, NULL, '2024-02-25 18:54:23', '2024-02-25 18:54:23', NULL, 2, NULL, NULL),
(11, 'SMC Enterprise Limited', 'smc-enterprise-limited', 1, NULL, NULL, '2024-02-25 19:06:36', '2024-02-25 19:06:36', NULL, 2, NULL, NULL),
(12, 'Bashundhara Paper Mills Limited', 'bashundhara-paper-mills-limited', 1, NULL, NULL, '2024-02-25 19:21:24', '2024-02-25 19:21:24', NULL, 2, NULL, NULL),
(13, 'Malaysian', 'malaysian', 1, NULL, NULL, '2024-02-25 19:44:05', '2024-02-25 19:44:05', NULL, 2, NULL, NULL),
(14, 'Incepta Pharmaceuticals Ltd', 'incepta-pharmaceuticals-ltd', 1, NULL, NULL, '2024-02-25 19:45:55', '2024-02-25 19:45:55', NULL, 2, NULL, NULL),
(15, 'General Pharmaceuticals Ltd.', 'general-pharmaceuticals-ltd', 1, NULL, NULL, '2024-02-25 20:09:28', '2024-02-25 20:09:28', NULL, 2, NULL, NULL),
(16, 'Anfords Bangladesh Ltd', 'anfords-bangladesh-ltd', 1, NULL, NULL, '2024-02-25 20:18:01', '2024-02-25 20:18:01', NULL, 2, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `district_managers`
--

CREATE TABLE `district_managers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bio` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `designation` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `age` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `area` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `identification_type` enum('NID','DOB','Passport') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `identification_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `present_address` longtext COLLATE utf8mb4_unicode_ci,
  `cv` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` enum('Male','Female','Others') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `father_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mother_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `permanent_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `district_managers`
--

INSERT INTO `district_managers` (`id`, `name`, `image`, `bio`, `designation`, `status`, `email`, `phone`, `email_verified_at`, `password`, `remember_token`, `age`, `area`, `identification_type`, `identification_no`, `present_address`, `cv`, `gender`, `dob`, `father_name`, `mother_name`, `permanent_address`, `parent_phone`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`) VALUES
(1, 'Test DM-1', NULL, NULL, NULL, 1, NULL, '01711122231', NULL, '$2y$12$1IuPcE0EH1kxnzgF7rEbluTM9bd25j3x3p4oAsOyDYHCXXLSxlGgK', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-02-25 16:16:49', '2024-02-25 16:16:49', NULL, NULL, NULL, NULL),
(2, 'Test DM-2', NULL, NULL, NULL, 1, NULL, '01711122232', NULL, '$2y$12$D.dhUHD0su27107.e8uE.ecyzqEeoCkeeOmYyw9NjcOU04az3Uu3y', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-02-25 16:16:49', '2024-02-25 16:16:49', NULL, NULL, NULL, NULL),
(3, 'Test DM-3', NULL, NULL, NULL, 1, NULL, '01711122233', NULL, '$2y$12$QVgnsbZpl.POEGOEEwy0ue698uY9bVa9QlG7mFKU9oFPSNR0.03c.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-02-25 16:16:49', '2024-02-25 16:16:49', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `documentations`
--

CREATE TABLE `documentations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `module_key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `documentation` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `documentations`
--

INSERT INTO `documentations` (`id`, `title`, `module_key`, `documentation`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`) VALUES
(1, NULL, 'admin', NULL, '2024-02-25 16:16:48', '2024-02-25 16:16:48', NULL, NULL, NULL, NULL),
(2, NULL, 'user', NULL, '2024-02-25 16:16:48', '2024-02-25 16:16:48', NULL, NULL, NULL, NULL),
(3, NULL, 'pharmacy', NULL, '2024-02-25 16:16:48', '2024-02-25 16:16:48', NULL, NULL, NULL, NULL),
(4, NULL, 'permission', NULL, '2024-02-25 16:16:48', '2024-02-25 16:16:48', NULL, NULL, NULL, NULL),
(5, NULL, 'roll', NULL, '2024-02-25 16:16:48', '2024-02-25 16:16:48', NULL, NULL, NULL, NULL),
(6, NULL, 'pharmacy_kyc_settings', NULL, '2024-02-25 16:16:48', '2024-02-25 16:16:48', NULL, NULL, NULL, NULL),
(7, NULL, 'district_manager', NULL, '2024-02-25 16:16:48', '2024-02-25 16:16:48', NULL, NULL, NULL, NULL),
(8, NULL, 'local_area_manager', NULL, '2024-02-25 16:16:48', '2024-02-25 16:16:48', NULL, NULL, NULL, NULL),
(9, NULL, 'general_settings', NULL, '2024-02-25 16:16:48', '2024-02-25 16:16:48', NULL, NULL, NULL, NULL),
(10, NULL, 'email_settings', NULL, '2024-02-25 16:16:48', '2024-02-25 16:16:48', NULL, NULL, NULL, NULL),
(11, NULL, 'database_settings', NULL, '2024-02-25 16:16:48', '2024-02-25 16:16:48', NULL, NULL, NULL, NULL),
(12, NULL, 'sms_settings', NULL, '2024-02-25 16:16:48', '2024-02-25 16:16:48', NULL, NULL, NULL, NULL),
(13, NULL, 'notification_settings', NULL, '2024-02-25 16:16:48', '2024-02-25 16:16:48', NULL, NULL, NULL, NULL),
(14, NULL, 'email_templates', NULL, '2024-02-25 16:16:48', '2024-02-25 16:16:48', NULL, NULL, NULL, NULL),
(15, NULL, 'generic_name', NULL, '2024-02-25 16:16:48', '2024-02-25 16:16:48', NULL, NULL, NULL, NULL),
(16, NULL, 'company_name', NULL, '2024-02-25 16:16:48', '2024-02-25 16:16:48', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `email_templates`
--

CREATE TABLE `email_templates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `template` longtext COLLATE utf8mb4_unicode_ci,
  `variables` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `email_templates`
--

INSERT INTO `email_templates` (`id`, `key`, `name`, `subject`, `template`, `variables`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`) VALUES
(1, 'password_reset', 'Password Reset', NULL, NULL, '[{\"key\": \"username\", \"meaning\": \"This is User Name\"}, {\"key\": \"code\", \"meaning\": \"This is verification code\"}, {\"key\": \"sent_from\", \"meaning\": \"This is sender name\"}]', '2024-02-25 16:16:48', '2024-02-25 16:16:48', NULL, NULL, NULL, NULL),
(2, 'payment_success', 'Payment Successfull', NULL, NULL, '[{\"key\": \"username\", \"meaning\": \"This is User Name\"}, {\"key\": \"code\", \"meaning\": \"This is verification code\"}, {\"key\": \"sent_from\", \"meaning\": \"This is sender name\"}]', '2024-02-25 16:16:48', '2024-02-25 16:16:48', NULL, NULL, NULL, NULL),
(3, 'payment_received', 'Payment Received', NULL, NULL, '[{\"key\": \"username\", \"meaning\": \"This is User Name\"}, {\"key\": \"code\", \"meaning\": \"This is verification code\"}, {\"key\": \"sent_from\", \"meaning\": \"This is sender name\"}]', '2024-02-25 16:16:48', '2024-02-25 16:16:48', NULL, NULL, NULL, NULL),
(4, 'verify_email', 'Verify Email', NULL, NULL, '[{\"key\": \"username\", \"meaning\": \"This is User Name\"}, {\"key\": \"code\", \"meaning\": \"This is verification code\"}, {\"key\": \"sent_from\", \"meaning\": \"This is sender name\"}]', '2024-02-25 16:16:48', '2024-02-25 16:16:48', NULL, NULL, NULL, NULL),
(5, 'payment_confirmed', 'Payment Confirmed', NULL, NULL, '[{\"key\": \"username\", \"meaning\": \"This is User Name\"}, {\"key\": \"code\", \"meaning\": \"This is verification code\"}, {\"key\": \"sent_from\", \"meaning\": \"This is sender name\"}]', '2024-02-25 16:16:48', '2024-02-25 16:16:48', NULL, NULL, NULL, NULL),
(6, 'payment_rejected', 'Payment Rejected', NULL, NULL, '[{\"key\": \"username\", \"meaning\": \"This is User Name\"}, {\"key\": \"code\", \"meaning\": \"This is verification code\"}, {\"key\": \"sent_from\", \"meaning\": \"This is sender name\"}]', '2024-02-25 16:16:48', '2024-02-25 16:16:48', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `generic_names`
--

CREATE TABLE `generic_names` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `generic_names`
--

INSERT INTO `generic_names` (`id`, `name`, `slug`, `status`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`) VALUES
(1, 'Paracetamol', 'paracetamol', 1, '2024-02-25 16:16:50', '2024-02-25 16:16:50', NULL, NULL, NULL, NULL),
(2, 'FLUOXETINE', 'FLUOXETINE', 1, '2024-02-25 16:16:50', '2024-02-25 16:16:50', NULL, NULL, NULL, NULL),
(3, 'SODIUM VALPROATE+VALPORIC ACID', 'SODIUM-VALPROATE+VALPORIC-ACID', 1, '2024-02-25 16:16:50', '2024-02-25 16:16:50', NULL, NULL, NULL, NULL),
(4, 'MIDAZOLAM', 'MIDAZOLAM', 1, '2024-02-25 16:16:50', '2024-02-25 16:16:50', NULL, NULL, NULL, NULL),
(5, 'LUBRICATING', 'LUBRICATING', 1, '2024-02-25 16:16:50', '2024-02-25 16:16:50', NULL, NULL, NULL, NULL),
(6, 'ARIPIPRAZOLE', 'ARIPIPRAZOLE', 1, '2024-02-25 16:16:50', '2024-02-25 16:16:50', NULL, NULL, NULL, NULL),
(7, 'Vitamin C [Ascorbic acid]', 'vitamin-c-ascorbic-acid', 1, '2024-02-25 16:19:41', '2024-02-25 16:19:41', NULL, 2, NULL, NULL),
(8, 'Aluminium Hydroxide + Magnesium Hydroxide + Simethicone', 'aluminium-hydroxide-magnesium-hydroxide-simethicone', 1, '2024-02-25 16:29:38', '2024-02-25 16:29:38', NULL, 2, NULL, NULL),
(9, 'Albendazole', 'albendazole', 1, '2024-02-25 17:32:48', '2024-02-25 17:32:48', NULL, 2, NULL, NULL),
(10, 'Sanitary Napkin', 'sanitary-napkin', 1, '2024-02-25 18:25:21', '2024-02-25 18:25:21', NULL, 2, NULL, NULL),
(11, 'Diaper', 'diaper', 1, '2024-02-25 19:21:45', '2024-02-25 19:21:45', NULL, 2, NULL, NULL),
(12, 'Wipes', 'wipes', 1, '2024-02-25 19:47:25', '2024-02-25 19:47:25', NULL, 2, NULL, NULL),
(13, 'Eucalyptol + Menthol + Methyl Salicylate + Thymol + Sodium Fluoride', 'eucalyptol-menthol-methyl-salicylate-thymol-sodium-fluoride', 1, '2024-02-25 20:04:48', '2024-02-25 20:04:48', NULL, 2, NULL, NULL),
(14, 'Ultimate Dental Care', 'ultimate-dental-care', 1, '2024-02-25 20:13:34', '2024-02-25 20:13:34', NULL, 2, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `kyc_settings`
--

CREATE TABLE `kyc_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` enum('user','pharmacy','rider','doctor','dm','lam') COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `form_data` json NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `local_area_managers`
--

CREATE TABLE `local_area_managers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `dm_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bio` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `designation` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `age` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `area` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `identification_type` enum('NID','DOB','Passport') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `identification_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `present_address` longtext COLLATE utf8mb4_unicode_ci,
  `cv` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` enum('Male','Female','Others') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `father_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mother_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `permanent_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `creater_id` bigint(20) UNSIGNED DEFAULT NULL,
  `creater_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updater_id` bigint(20) UNSIGNED DEFAULT NULL,
  `updater_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleter_id` bigint(20) UNSIGNED DEFAULT NULL,
  `deleter_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `local_area_managers`
--

INSERT INTO `local_area_managers` (`id`, `dm_id`, `name`, `image`, `bio`, `designation`, `status`, `email`, `phone`, `email_verified_at`, `password`, `remember_token`, `age`, `area`, `identification_type`, `identification_no`, `present_address`, `cv`, `gender`, `dob`, `father_name`, `mother_name`, `permanent_address`, `parent_phone`, `created_at`, `updated_at`, `deleted_at`, `creater_id`, `creater_type`, `updater_id`, `updater_type`, `deleter_id`, `deleter_type`) VALUES
(1, 1, 'Test LAM-1', NULL, NULL, NULL, 1, NULL, '01711122231', NULL, '$2y$12$DhqNp7whVqGx.ctMLGvQl.AeHfvHl5GbAbGLf/XMoSrNlFkAfXT2y', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-02-25 16:16:49', '2024-02-25 16:16:49', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 2, 'Test LAM-2', NULL, NULL, NULL, 1, NULL, '01711122232', NULL, '$2y$12$Wki04.GWnw0ZGv5zUP.LgOsjGopwZLaLHb3NzbCej89nHJszoI8yW', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-02-25 16:16:50', '2024-02-25 16:16:50', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(3, 3, 'Test LAM-3', NULL, NULL, NULL, 1, NULL, '01711122233', NULL, '$2y$12$AzXQecvgrXgfGPcz4M4O8.d6NeXpplpeD.nAx8PtvYhROan4CkPBG', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-02-25 16:16:50', '2024-02-25 16:16:50', NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ltm_translations`
--

CREATE TABLE `ltm_translations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `locale` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `group` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `key` text COLLATE utf8mb4_bin NOT NULL,
  `value` text COLLATE utf8mb4_bin,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Table structure for table `medicines`
--

CREATE TABLE `medicines` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pro_cat_id` bigint(20) UNSIGNED NOT NULL,
  `pro_sub_cat_id` bigint(20) UNSIGNED NOT NULL,
  `generic_id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `strength_id` bigint(20) UNSIGNED DEFAULT NULL,
  `unit` json NOT NULL,
  `price` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `prescription_required` tinyint(1) DEFAULT NULL,
  `max_quantity` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kyc_required` tinyint(1) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `is_best_selling` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `medicines`
--

INSERT INTO `medicines` (`id`, `name`, `slug`, `pro_cat_id`, `pro_sub_cat_id`, `generic_id`, `company_id`, `strength_id`, `unit`, `price`, `image`, `description`, `prescription_required`, `max_quantity`, `kyc_required`, `status`, `is_best_selling`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`) VALUES
(1, 'Napa 500 MG', 'napa-500-mg', 1, 1, 1, 1, 1, '[\"2\", \"3\", \"1\"]', '1.08', 'district_manager/Napa 500 MG Tablet/Napa 500 MG Tablet_1708856236.webp', 'Indications of Napa 500 mg\r\n            Napa 500 mg is indicated for fever, common cold and influenza, headache, toothache, earache, bodyache, myalgia, neuralgia, dysmenorrhoea, sprains, colic pain, back pain, post-operative pain, postpartum pain, inflammatory pain and post vaccination pain in children. It is also indicated for rheumatic & osteoarthritic pain and stiffness of joints.\r\n            \r\n            Theropeutic Class\r\n            Non opioid analgesics\r\n            \r\n            Pharmacology\r\n            Napa 500 mg has analgesic and antipyretic properties with weak anti-inflammatory activity. Napa 500 mg (Acetaminophen) is thought to act primarily in the CNS, increasing the pain threshold by inhibiting both isoforms of cyclooxygenase, COX-1, COX-2, and COX-3 enzymes involved in prostaglandin (PG) synthesis. Napa 500 mg is a para aminophenol derivative, has analgesic and antipyretic properties with weak anti-inflammatory activity. Napa 500 mg is one of the most widely used, safest and fast acting analgesic. It is well tolerated and free from various side effects of aspirin.\r\n            \r\n            Dosage & Administration of Napa 500 mg\r\n            Tablet:\r\n            Adult: 1-2 tablets every 4 to 6 hours up to a maximum of 4 gm (8 tablets) daily.\r\n            Children (6-12 years): ½ to 1 tablet 3 to 4 times daily. For long term treatment it is wise not to exceed the dose beyond 2.6 gm/day.\r\n            Extended Release Tablet:\r\n            Adults & Children over 12 years: Two tablets, swallowed whole, every 6 to 8 hours (maximum of 6 tablets in any 24 hours).The tablet must not be crushed.\r\n            Syrup/Suspension:\r\n            Children under 3 months: 10 mg/kg body weight (reduce to 5 mg/kg if jaundiced) 3 to 4 times daily.\r\n            3 months to below 1 year: ½ to 1 teaspoonful 3 to 4 times daily.\r\n            1-5 years: 1 -2 teaspoonful 3 to 4 times daily.\r\n            6-12 years: 2-A teaspoonful 3 to 4 times daily.\r\n            Adults: 4-8 teaspoonful 3 to 4 times daily.\r\n            Suppository:\r\n            Children 3-12 months: 60-120 mg,4 times daily.\r\n            Children 1-5 years: 125-250 mg 4 times daily.\r\n            Children 6-12 years: 250-500 mg 4 times daily.\r\n            Adults & children over 12 years: 0.5-1 gm 4 times daily.\r\n            Paediatric Drop:\r\n            Children Upto 3 months: 0.5 ml (40 mg)\r\n            4 to 11 months: 1.0 ml (80 mg)\r\n            7 to 2 years: 1.5 ml (120 mg). Do not exceed more than 5 dose daily for a maximum of 5 days.\r\n            Napa 500 mg tablet with actizorb technology: It dissolves up to five times faster than standard Napa 500 mg tablets. It is a fast acting and safe analgesic with marked antipyretic property. It is specially suitable for patients who, for any reason, can not tolerate aspirin or other analgesics.\r\n            Adults and children (aged 12 years and over): Take 1 to 2 Tablets every four to six hours as needed. Do not take more than 8 caplets in 24 hours.\r\n            Children (7 to 11 years): Take ½-1 Tablet every four to six hours as needed. Do not take more than 4 caplets in 24 hours. Not recommended in children under 7 years.\r\n            Interaction of Napa 500 mg\r\n            Patients who have taken barbiturates, tricyclic antidepressants and alcohol may show diminished ability to metabolise large doses of Napa 500 mg. Alcohol can increase the hepatotoxicity of Napa 500 mg overdosage. Chronic ingestion of anticonvulsants or oral steroid contraceptives induce liver enzymes and may prevent attainment of therapeutic Napa 500 mg levels by increasing first-pass metabolism or clearance.\r\n            \r\n            Contraindications\r\n            It is contraindicated in known hypersensitivity to Napa 500 mg.\r\n            \r\n            Side Effects of Napa 500 mg\r\n            Side effects of Napa 500 mg are usually mild, though haematological reactions including thrombocytopenia, leucopenia, pancytopenia, neutropenia, and agranulocytosis have been reported. Pancreatitis, skin rashes, and other allergic reactions occur occasionally.\r\n            \r\n            Pregnancy & Lactation\r\n            Pregnancy category B according to USFDA. This drug should be used during pregnancy only if clearly needed\r\n            \r\n            Precautions & Warnings\r\n            Napa 500 mg should be given with caution to patients with impaired kidney or liver function. Napa 500 mg should be given with care to patients taking other drugs that affect the liver.\r\n            \r\n            Overdose Effects of Napa 500 mg\r\n            Symptoms of Napa 500 mg overdose in the first 24 hours are pallor, nausea, vomiting, anorexia and abdominal pain. Liver damage may become apparent 12-48 hours after ingestion. Abnormalities of glucose metabolism and metabolic acidosis may occur.\r\n            \r\n            Storage Conditions\r\n            Keep in a dry place away from light and heat. Keep out of the reach of children.\r\n            \r\n            Drug Classes\r\n            Non opioid analgesics\r\n            \r\n            Mode Of Action\r\n            Napa 500 mg has analgesic and antipyretic properties with weak anti-inflammatory activity. Napa 500 mg (Acetaminophen) is thought to act primarily in the CNS, increasing the pain threshold by inhibiting both isoforms of cyclooxygenase, COX-1, COX-2, and COX-3 enzymes involved in prostaglandin (PG) synthesis. Napa 500 mg is a para aminophenol derivative, has analgesic and antipyretic properties with weak anti-inflammatory activity. Napa 500 mg is one of the most widely used, safest and fast acting analgesic. It is well tolerated and free from various side effects of aspirin.\r\n            \r\n            Pregnancy\r\n            Pregnancy category B according to USFDA. This drug should be used during pregnancy only if clearly needed.  Napa 500 mg is excreted in breast milk. Maternal ingestion of Napa 500 mg in normal therapeutic doses does not appear to present a risk to the nursing infant.', NULL, NULL, NULL, 1, 1, '2024-02-25 16:16:50', '2024-02-25 17:42:54', NULL, NULL, 2, NULL),
(2, 'Ceevit 250 MG', 'ceevit-250-mg', 1, 1, 7, 7, 1, '[\"2\", \"13\", \"1\"]', '1.71', 'district_manager/Ceevit 250 MG/Ceevit 250 MG_1708856626.webp', 'Oral administration- For the prevention of scurvy: 1 tablet daily For the treatment of scurvy: 1-2 tablets daily; but dose may be increased depending on the severity of the condition. For the reduction of risk of stroke in the elderly: 1-2 tablets daily. In other cases: 1 tablet daily or as directed by the physician. Maximum safe dose is 2000 mg daily in divided doses. Parenteral administration- Vitamin C is usually administered orally. When oral administration is not feasible or when malabsorption is suspected, the drug may be administered IM, IV, or subcutaneously. When given parenterally, utilization of the vitamin reportedly is best after IM administration and that is the preferred parenteral route. For intravenous injection, dilution into a large volume parenteral such as Normal Saline, Water for Injection, or Glucose is recommended to minimize the adverse reactions associated with intravenous injection. The average protective dose of vitamin C for adults is 70 to 150 mg daily. In the presence of scurvy, doses of 300 mg to 1 g daily are recommended. However, as much as 6 g has been administered parenterally to normal adults without evidence of toxicity. To enhance wound healing, doses of 300 to 500 mg daily for a week or ten days both preoperatively and postoperatively are generally considered adequate, although considerably larger amounts have been recommended. In the treatment of burns, doses are governed by the extent of tissue injury. For severe burns, daily doses of 1 to 2 g are recommended. In other conditions in which the need for vitamin C is increased, three to five times the daily optimum allowances appear to be adequate. Parenteral drug products should be inspected visually for particulate matter and discoloration prior to administration, whenever the solution and container permit.', NULL, NULL, NULL, 1, 1, '2024-02-25 16:23:46', '2024-02-25 16:23:53', NULL, 2, NULL, NULL),
(3, 'Entacyd Plus 200 ML', 'entacyd-plus-200-ml', 1, 3, 8, 7, 15, '[\"11\"]', '72', 'district_manager/Entacyd Plus 200 ML/Entacyd Plus 200 ML_1708857119.webp', 'This is the mixture of non-systemic acid neutralizing substances and antiflatulent. This preparation offers reliability as well as long action. Aluminium Hydroxide and Magnesium Hydroxide induce the relief of ulcer by neutralizing gastric acid secreted from parietal cells of the stomach. The clinical use of simethicone is based on its antifoam properties. Simethicone spreads on the surface of aqueous liquids, forming a film of low surface tension and causing collapse of foam bubbles. Simethicone repeatedly allows mucous surrounded gas bubbles in the GI tract to coalesce and be expelled.This is used in the treatment of flatulence and meteorism for the elimination of gas, air or foam from the gastro-intestinal tract prior to radiography and for the relief of abdominal distension and dyspepsia. Simethicone is physiologically inert; it does not appeared to be absorbed from the GI tract to interfere with gastric secretion or absorption of nutrients. Following oral administration, the drug is excreted unchanged in the feces.', NULL, NULL, NULL, 1, 1, '2024-02-25 16:31:59', '2024-02-25 16:32:03', NULL, 2, NULL, NULL),
(4, 'Napa Extend 665 MG', 'napa-extend-665-mg', 1, 1, 1, 1, 21, '[\"14\", \"15\", \"1\"]', '1.80', 'district_manager/Napa Extend 665 MG/Napa Extend 665 MG_1708859751.webp', 'Napa Extend 665 mg has analgesic and antipyretic properties with weak anti-inflammatory activity. Napa Extend 665 mg (Acetaminophen) is thought to act primarily in the CNS, increasing the pain threshold by inhibiting both isoforms of cyclooxygenase, COX-1, COX-2, and COX-3 enzymes involved in prostaglandin (PG) synthesis. Napa Extend 665 mg is a para aminophenol derivative, has analgesic and antipyretic properties with weak anti-inflammatory activity. Napa Extend 665 mg is one of the most widely used, safest and fast acting analgesic. It is well tolerated and free from various side effects of aspirin.', NULL, NULL, NULL, 1, 1, '2024-02-25 17:15:51', '2024-02-25 17:15:56', NULL, 2, NULL, NULL),
(5, 'Napa 60 ML', 'napa-60-ml', 1, 3, 1, 1, 22, '[\"16\"]', '31.50', 'district_manager/Napa 60 ML/Napa 60 ML_1708860195.webp', 'Napa 60 ml has analgesic and antipyretic properties with weak anti-inflammatory activity. Napa 60 ml (Acetaminophen) is thought to act primarily in the CNS, increasing the pain threshold by inhibiting both isoforms of cyclooxygenase, COX-1, COX-2, and COX-3 enzymes involved in prostaglandin (PG) synthesis. Napa 60 ml is a para aminophenol derivative, has analgesic and antipyretic properties with weak anti-inflammatory activity. Napa 60 ml is one of the most widely used, safest and fast acting analgesic. It is well tolerated and free from various side effects of aspirin.', NULL, NULL, NULL, 1, 1, '2024-02-25 17:23:15', '2024-02-25 17:23:21', NULL, 2, NULL, NULL),
(6, 'Nutrivit-C 250 MG', 'nutrivit-c-250-mg', 1, 1, 7, 8, 23, '[\"2\", \"6\", \"1\"]', '1.71', 'district_manager/Nutrivit-C 250 MG/Nutrivit-C 250 MG_1708860534.webp', 'vitamin C, the water-soluble vitamin, is readily absorbed from the gastrointestinal tract and is widely distributed in the body tissues. It is believed to be involved in biological oxidations and reductions used in cellular respiration. It is essential for the synthesis of collagen and intracellular material. Vitamin C deficiency develops when the dietary intake is inadequate and when increased demand is not fulfilled. Deficiency leads to the development of well defined syndrome known as scurvy, which is characterized by capillary fragility, bleeding (especially from small blood vessels and the gums), anaemia, cartilage and bone lesions and slow healing of wounds.', NULL, NULL, NULL, 1, 1, '2024-02-25 17:28:54', '2024-02-25 17:28:58', NULL, 2, NULL, NULL),
(7, 'Almex 400 MG', 'almex-400-mg', 1, 1, 9, 7, 18, '[\"17\", \"1\"]', '4.52', 'district_manager/Almex 400 MG/Almex 400 MG_1708860915.webp', 'Adults & children over 2 years: 400 mg (1 tablet or 10 ml suspension) as a single dose in cases of Enterobius vermicularis, Trichuris trichiura, Ascaris lumbricoides, Ancylostoma duodenale and Necator americanus. In cases of strongyloidiasis or taeniasis, 400 mg (1 tablet or 10 ml suspension) daily should be given for 3 consecutive days. If the patient is not cured on follow-up after three weeks, a second course of treatment is indicated.  Children of 1-2 years: Recommended dose is a single dose of 200 mg (5 ml suspension).Children under 1 year: Not recommended.In Hydatid disease (Echinococcosis): Almex 400 mg is given by mouth with meals in a dose of 400 mg twice daily for 28 days for patients weighing over 60 kg. A dose of 15 mg/kg body weight daily in two divided doses (to a maximum total daily dose of 800 mg) is used for patients weighing less than 60 kg. For cystic echinococcosis, the 28 days course may be repeated after 14 days without treatment, to a total of 3 treatment cycles. For alveolar echinococcosis, cycles of 28 days of treatment followed by 14 days without treatment, may need to continue for months or years. In giardiasis, 400 mg (1 tablet or 10 ml suspension) once daily for five days is used.', NULL, NULL, NULL, 1, 1, '2024-02-25 17:35:15', '2024-02-25 17:35:54', NULL, 2, 2, NULL),
(8, 'Alben 10 ML', 'alben-10-ml', 1, 47, 9, 9, 3, '[\"18\"]', '20.70', 'district_manager/Alben 10 ML/Alben 10 ML_1708862845.webp', 'Adults & children over 2 years: 400 mg (1 tablet or 10 ml suspension) as a single dose in cases of Enterobius vermicularis, Trichuris trichiura, Ascaris lumbricoides, Ancylostoma duodenale and Necator americanus. In cases of strongyloidiasis or taeniasis, 400 mg (1 tablet or 10 ml suspension) daily should be given for 3 consecutive days. If the patient is not cured on follow-up after three weeks, a second course of treatment is indicated.  Children of 1-2 years: Recommended dose is a single dose of 200 mg (5 ml suspension).Children under 1 year: Not recommended.In Hydatid disease (Echinococcosis): Alben 10 ml is given by mouth with meals in a dose of 400 mg twice daily for 28 days for patients weighing over 60 kg. A dose of 15 mg/kg body weight daily in two divided doses (to a maximum total daily dose of 800 mg) is used for patients weighing less than 60 kg. For cystic echinococcosis, the 28 days course may be repeated after 14 days without treatment, to a total of 3 treatment cycles. For alveolar echinococcosis, cycles of 28 days of treatment followed by 14 days without treatment, may need to continue for months or years. In giardiasis, 400 mg (1 tablet or 10 ml suspension) once daily for five days is used.', NULL, NULL, NULL, 1, 0, '2024-02-25 18:07:25', '2024-02-25 18:07:25', NULL, 2, NULL, NULL),
(9, 'Entacyd Plus 200 MG', 'entacyd-plus-200-mg', 1, 1, 8, 7, 14, '[\"2\", \"6\", \"1\"]', '2.25', 'district_manager/Entacyd Plus 200 MG/Entacyd Plus 200 MG_1708863069.webp', 'This is the mixture of non-systemic acid neutralizing substances and antiflatulent. This preparation offers reliability as well as long action. Aluminium Hydroxide and Magnesium Hydroxide induce the relief of ulcer by neutralizing gastric acid secreted from parietal cells of the stomach. The clinical use of simethicone is based on its antifoam properties. Simethicone spreads on the surface of aqueous liquids, forming a film of low surface tension and causing collapse of foam bubbles. Simethicone repeatedly allows mucous surrounded gas bubbles in the GI tract to coalesce and be expelled.This is used in the treatment of flatulence and meteorism for the elimination of gas, air or foam from the gastro-intestinal tract prior to radiography and for the relief of abdominal distension and dyspepsia. Simethicone is physiologically inert; it does not appeared to be absorbed from the GI tract to interfere with gastric secretion or absorption of nutrients. Following oral administration, the drug is excreted unchanged in the feces.', NULL, NULL, NULL, 1, 0, '2024-02-25 18:11:09', '2024-02-25 18:11:09', NULL, 2, NULL, NULL),
(10, 'Freedom Heavy Flow Wings', 'freedom-heavy-flow-wings', 2, 7, 10, 8, NULL, '[\"19\"]', '760', 'district_manager/Freedom Heavy Flow Wings/Freedom Heavy Flow Wings_1708865314.webp', 'Stay confident and worry-free on your heavy flow days with Freedom Heavy Flow Wings 16 Pads. Its advanced features keep you dry, fresh and comfortable. The pad’s interior instantly absorbs and evenly distributes fluid. Also, it has an extra layer of protection to prevent back leakage.', NULL, NULL, NULL, 1, 0, '2024-02-25 18:48:34', '2024-02-25 18:48:34', NULL, 2, NULL, NULL),
(11, 'WHISPER MAXI NIGHTS', 'whisper-maxi-nights', 2, 7, 10, 10, NULL, '[\"20\"]', '332.50', 'district_manager/WHISPER MAXI NIGHTS/WHISPER MAXI NIGHTS_1708866179.webp', 'Stay confident and worry-free on your heavy flow days with WHISPER MAXI NIGHTS 15 Pads. Its advanced features keep you dry, fresh and comfortable. The pad’s interior instantly absorbs and evenly distributes fluid. Also, it has an extra layer of protection to prevent back leakage.', NULL, NULL, NULL, 1, 0, '2024-02-25 19:02:59', '2024-02-25 19:02:59', NULL, 2, NULL, NULL),
(12, 'Senora Confidence Regular Flow (Panty System)', 'senora-confidence-regular-flow-panty-system', 2, 7, 10, 7, NULL, '[\"20\"]', '142.50', 'district_manager/Senora Confidence Regular Flow (Panty System)/Senora Confidence Regular Flow (Panty System)_1708866373.webp', 'Stay confident and worry-free on your heavy flow days with Senora Confidence Regular Flow (Panty System) 15 Pads. Its advanced features keep you dry, fresh and comfortable. The pad’s interior instantly absorbs and evenly distributes fluid. Also, it has an extra layer of protection to prevent back leakage.', NULL, NULL, NULL, 1, 0, '2024-02-25 19:06:13', '2024-02-25 19:06:13', NULL, 2, NULL, NULL),
(13, 'Joya Wings Regular Flow', 'joya-wings-regular-flow', 2, 7, 10, 11, NULL, '[\"21\"]', '66.50', 'district_manager/Joya Wings Regular Flow/Joya Wings Regular Flow_1708866519.webp', 'Stay confident and worry-free on your heavy flow days with Joya Wings Regular Flow 8 pads. Its advanced features keep you dry, fresh and comfortable. The pad’s interior instantly absorbs and evenly distributes fluid. Also, it has an extra layer of protection to prevent back leakage.', NULL, NULL, NULL, 1, 0, '2024-02-25 19:08:39', '2024-02-25 19:08:39', NULL, 2, NULL, NULL),
(14, 'Senora Belt', 'senora-belt', 2, 7, 10, 7, NULL, '[\"20\"]', '123.50', 'district_manager/Senora Belt/Senora Belt_1708866636.webp', 'Stay confident and worry-free on your heavy flow days with Senora Belt 15 Pads. Its advanced features keep you dry, fresh and comfortable. The pad’s interior instantly absorbs and evenly distributes fluid. Also, it has an extra layer of protection to prevent back leakage.', NULL, NULL, NULL, 1, 0, '2024-02-25 19:10:36', '2024-02-25 19:10:36', NULL, 2, NULL, NULL),
(15, 'Diaper BASHUNDHARA BABY PANT (DIAPANT) Size 4-8 KG', 'diaper-bashundhara-baby-pant-diapant-size-4-8-kg', 5, 30, 11, 12, NULL, '[\"22\"]', '140', 'district_manager/Diaper BASHUNDHARA BABY PANT (DIAPANT) Size 4-8 KG/Diaper BASHUNDHARA BABY PANT (DIAPANT) Size 4-8 KG_1708867567.webp', 'Diaper BASHUNDHARA BABY PANT (DIAPANT) S SIZE 4-8 KG prioritizes the comfort and well-being of your baby. It is made of soft and breathable materials to ensure optimal comfort and keep your baby\'s skin dry and healthy. The Diaper BASHUNDHARA BABY PANT (DIAPANT) S SIZE 4-8 KG also features a secure fit to prevent leaks and ensures your baby stays clean and fresh all day long. It has easy-to-use fasteners and a wetness indicator that lets you know when it\'s time for a change.', NULL, NULL, NULL, 1, 0, '2024-02-25 19:26:07', '2024-02-25 19:26:07', NULL, 2, NULL, NULL),
(16, 'Huggies Dry Pant Diaper - MalaysianL SIZE 9-14 KG', 'huggies-dry-pant-diaper-malaysianl-size-9-14-kg', 5, 30, 11, 13, NULL, '[\"23\"]', '1584', 'district_manager/Huggies Dry Pant Diaper - MalaysianL SIZE 9-14 KG/Huggies Dry Pant Diaper - MalaysianL SIZE 9-14 KG_1708868735.webp', 'Huggies Dry Pant Diaper - Malaysian L SIZE 9-14 KG prioritizes the comfort and well-being of your baby. It is made of soft and breathable materials to ensure optimal comfort and keep your baby\'s skin dry and healthy. The Huggies Dry Pant Diaper - Malaysian L SIZE 9-14 KG also features a secure fit to prevent leaks and ensures your baby stays clean and fresh all day long. It has easy-to-use fasteners and a wetness indicator that lets you know when it\'s time for a change.', NULL, NULL, NULL, 1, 0, '2024-02-25 19:45:35', '2024-02-25 19:45:35', NULL, 2, NULL, NULL),
(17, 'NeoCare Baby Wipes', 'neocare-baby-wipes', 5, 31, 12, 14, NULL, '[\"24\"]', '223.25', 'district_manager/NeoCare Baby Wipes/NeoCare Baby Wipes_1708868940.webp', 'NeoCare Baby Wipes 120 are a popular choice for gentle yet effective cleaning for little babies. They are made of soft and absorbent materials to effectively clean and moisturize delicate skin without the risk of irritation. NeoCare Baby Wipes 120 are also hypoallergenic and dermatologically tested to ensure peace of mind for worried parents.', NULL, NULL, NULL, 1, 0, '2024-02-25 19:49:00', '2024-02-25 19:49:00', NULL, 2, NULL, NULL),
(18, 'Orostar Plus 250 ML', 'orostar-plus-250-ml', 6, 34, 13, 7, 25, '[\"12\"]', '135', 'district_manager/Orostar Plus 250 ML/Orostar Plus 250 ML_1708870146.webp', 'Eucalyptol is a natural organic compound which is a colorless liquid. It is a cyclic ether and a monoterpenoid. Eucalyptol is an ingredient in many brands of mouthwash and cough suppressant. It controls airway mucus hypersecretion and asthma via anti-inflammatory cytokine inhibition.Menthol: It provides cooling sensation by stimulation of cooling receptor and gives local anesthetic actionMethyl Salicylate: It penetrates and reaches at high concentration in pain regions and inhibit the prostaglandin synthesis and relieves pain effectivelyThymol, one of the chemicals in thyme, is used with another chemical, chlorhexidine, as a dental varnish to prevent tooth decay. In foods, thyme is used as a flavoring agent. In manufacturing, red thyme oil is used in perfumes. It is also used in soaps, cosmetics, and toothpastes.Fluoride salts are often added to municipal drinking water (as well as certain food products in some countries) for the purposes of maintaining dental health. The fluoride enhances the strength of teeth by the formation of fluorapatite, a naturally occurring component of tooth enamel. Toothpaste often contains sodium fluoride to prevent cavities, although tin(II) fluoride is generally considered superior for this application.', NULL, NULL, NULL, 1, 0, '2024-02-25 20:09:06', '2024-02-25 20:09:06', NULL, 2, NULL, NULL),
(19, 'Listacare Blue Mint 120 ML', 'listacare-blue-mint-120-ml', 6, 34, 13, 15, 26, '[\"26\"]', '72', 'district_manager/Listacare Blue Mint 120 ML/Listacare Blue Mint 120 ML_1708870378.webp', 'This preparation is a clinically proven antiseptic mouthwash that provides you complete care for healthier mouth with around-the-clock protection against bacteria and plaque. Your mouth stays cleaner, fresher and healthier. 24 hours protection against plaque, gingivitis and gum disease Fights against germs that cause bad breath Kills germs between teeth and keeps teeth cleaner & brighter', NULL, NULL, NULL, 1, 0, '2024-02-25 20:12:58', '2024-02-25 20:12:58', NULL, 2, NULL, NULL),
(20, 'Mediplus 140 GM', 'mediplus-140-gm', 6, 35, 14, 16, 27, '[\"27\"]', '85.50', 'district_manager/Mediplus 140 GM/Mediplus 140 GM_1708871191.webp', 'The information provided is accurate to our best practices, but it does not replace professional medical advice. We cannot guarantee its completeness or accuracy. The absence of specific information about a drug should not be seen as an endorsement. We are not responsible for any consequences resulting from this information, so consult a healthcare professional for any concerns or questions.', NULL, NULL, NULL, 1, 0, '2024-02-25 20:26:31', '2024-02-25 20:26:31', NULL, 2, NULL, NULL),
(21, 'Mediplus DS 140 GM', 'mediplus-ds-140-gm', 6, 35, 14, 16, 27, '[\"27\"]', '128.25', 'district_manager/Mediplus DS 140 GM/Mediplus DS 140 GM_1708871272.webp', 'Mediplus DS 140 gm is known for its effectiveness in keeping teeth clean and healthy. It contains fluoride to prevent tooth decay and strengthens enamel. Mediplus DS 140 gm also has a refreshing mint flavor that leaves the mouth feeling clean and fresh.', NULL, NULL, NULL, 1, 0, '2024-02-25 20:27:52', '2024-02-25 20:27:52', NULL, 2, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `medicine_categories`
--

CREATE TABLE `medicine_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `is_featured` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `medicine_strengths`
--

CREATE TABLE `medicine_strengths` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `quantity` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `unit` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `medicine_strengths`
--

INSERT INTO `medicine_strengths` (`id`, `quantity`, `unit`, `status`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`) VALUES
(1, '500', 'MG', 1, '2024-02-25 16:16:50', '2024-02-25 16:16:50', NULL, NULL, NULL, NULL),
(2, '10', 'MG', 1, '2024-02-25 16:16:50', '2024-02-25 16:16:50', NULL, NULL, NULL, NULL),
(3, '10', 'ML', 1, '2024-02-25 16:16:50', '2024-02-25 16:16:50', NULL, NULL, NULL, NULL),
(4, '20', 'MG', 1, '2024-02-25 16:16:50', '2024-02-25 16:16:50', NULL, NULL, NULL, NULL),
(5, '20', 'ML', 1, '2024-02-25 16:16:50', '2024-02-25 16:16:50', NULL, NULL, NULL, NULL),
(6, '30', 'MG', 1, '2024-02-25 16:16:50', '2024-02-25 16:16:50', NULL, NULL, NULL, NULL),
(7, '30', 'ML', 1, '2024-02-25 16:16:50', '2024-02-25 16:16:50', NULL, NULL, NULL, NULL),
(8, '40', 'MG', 1, '2024-02-25 16:16:50', '2024-02-25 16:16:50', NULL, NULL, NULL, NULL),
(9, '40', 'ML', 1, '2024-02-25 16:16:50', '2024-02-25 16:16:50', NULL, NULL, NULL, NULL),
(10, '50', 'MG', 1, '2024-02-25 16:16:50', '2024-02-25 16:16:50', NULL, NULL, NULL, NULL),
(11, '50', 'ML', 1, '2024-02-25 16:16:50', '2024-02-25 16:16:50', NULL, NULL, NULL, NULL),
(12, '100', 'MG', 1, '2024-02-25 16:16:50', '2024-02-25 16:16:50', NULL, NULL, NULL, NULL),
(13, '100', 'ML', 1, '2024-02-25 16:16:50', '2024-02-25 16:16:50', NULL, NULL, NULL, NULL),
(14, '200', 'MG', 1, '2024-02-25 16:16:50', '2024-02-25 16:16:50', NULL, NULL, NULL, NULL),
(15, '200', 'ML', 1, '2024-02-25 16:16:50', '2024-02-25 16:16:50', NULL, NULL, NULL, NULL),
(16, '300', 'MG', 1, '2024-02-25 16:16:50', '2024-02-25 16:16:50', NULL, NULL, NULL, NULL),
(17, '300', 'ML', 1, '2024-02-25 16:16:50', '2024-02-25 16:16:50', NULL, NULL, NULL, NULL),
(18, '400', 'MG', 1, '2024-02-25 16:16:50', '2024-02-25 16:16:50', NULL, NULL, NULL, NULL),
(19, '400', 'ML', 1, '2024-02-25 16:16:50', '2024-02-25 16:16:50', NULL, NULL, NULL, NULL),
(20, '500', 'ML', 1, '2024-02-25 16:16:50', '2024-02-25 16:16:50', NULL, NULL, NULL, NULL),
(21, '665', 'mg', 1, '2024-02-25 17:07:41', '2024-02-25 17:07:41', NULL, 2, NULL, NULL),
(22, '60', 'ml', 1, '2024-02-25 17:21:00', '2024-02-25 17:21:00', NULL, 2, NULL, NULL),
(23, '250', 'mg', 1, '2024-02-25 17:26:28', '2024-02-25 17:26:28', NULL, 2, NULL, NULL),
(24, '10', 'ml', 1, '2024-02-25 17:56:12', '2024-02-25 17:56:12', NULL, 2, NULL, NULL),
(25, '250', 'ml', 1, '2024-02-25 20:07:56', '2024-02-25 20:07:56', NULL, 2, NULL, NULL),
(26, '120', 'ml', 1, '2024-02-25 20:10:29', '2024-02-25 20:10:29', NULL, 2, NULL, NULL),
(27, '140', 'gm', 1, '2024-02-25 20:22:59', '2024-02-25 20:22:59', NULL, 2, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `medicine_units`
--

CREATE TABLE `medicine_units` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `medicine_units`
--

INSERT INTO `medicine_units` (`id`, `name`, `quantity`, `status`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`) VALUES
(1, 'Piece', '1', 1, '2024-02-25 16:16:50', '2024-02-25 17:25:38', NULL, NULL, 2, NULL),
(2, '10\'s Strip', '10', 1, '2024-02-25 16:16:50', '2024-02-25 16:16:50', NULL, NULL, NULL, NULL),
(3, '510\'s Pack', '510', 1, '2024-02-25 16:16:50', '2024-02-25 16:16:50', NULL, NULL, NULL, NULL),
(4, '100\'s Pack', '100', 1, '2024-02-25 16:16:50', '2024-02-25 16:16:50', NULL, NULL, NULL, NULL),
(5, '5\'s Strip', '5', 1, '2024-02-25 16:16:50', '2024-02-25 16:16:50', NULL, NULL, NULL, NULL),
(6, '200\'s Pack', '200', 1, '2024-02-25 16:16:50', '2024-02-25 16:16:50', NULL, NULL, NULL, NULL),
(7, '20\'s Strip', '20', 1, '2024-02-25 16:16:50', '2024-02-25 16:16:50', NULL, NULL, NULL, NULL),
(8, '60\'s Pack', '60', 1, '2024-02-25 16:16:50', '2024-02-25 16:16:50', NULL, NULL, NULL, NULL),
(9, '15\'s Strip', '15', 1, '2024-02-25 16:16:50', '2024-02-25 16:16:50', NULL, NULL, NULL, NULL),
(10, '150\'s Pack', '150', 1, '2024-02-25 16:16:50', '2024-02-25 16:16:50', NULL, NULL, NULL, NULL),
(11, '200 ml bottle', '1', 1, '2024-02-25 16:16:50', '2024-02-25 16:16:50', NULL, NULL, NULL, NULL),
(12, '250 ml bottle', '1', 1, '2024-02-25 16:16:50', '2024-02-25 16:16:50', NULL, NULL, NULL, NULL),
(13, '250\'s Pack', '250', 1, '2024-02-25 16:20:51', '2024-02-25 16:20:51', NULL, 2, NULL, NULL),
(14, '12\'s Strip', '12', 1, '2024-02-25 17:08:10', '2024-02-25 17:08:10', NULL, 2, NULL, NULL),
(15, '144\'s Pack', '144', 1, '2024-02-25 17:08:24', '2024-02-25 17:08:24', NULL, 2, NULL, NULL),
(16, '60 ml bottle', '1', 1, '2024-02-25 17:21:29', '2024-02-25 17:21:29', NULL, 2, NULL, NULL),
(17, '48\'s pack', '48', 1, '2024-02-25 17:33:27', '2024-02-25 17:33:27', NULL, 2, NULL, NULL),
(18, '10 ml bottle', '10', 1, '2024-02-25 17:57:00', '2024-02-25 17:57:00', NULL, 2, NULL, NULL),
(19, '16\'s Pads', '1', 1, '2024-02-25 18:23:30', '2024-02-25 18:23:30', NULL, 2, NULL, NULL),
(20, '15\'s Pads', '1', 1, '2024-02-25 18:55:32', '2024-02-25 19:02:18', NULL, 2, 2, NULL),
(21, '8\'s Pads', '1', 1, '2024-02-25 19:07:14', '2024-02-25 19:07:14', NULL, 2, NULL, NULL),
(22, '5\'s Pack', '1', 1, '2024-02-25 19:22:56', '2024-02-25 19:26:39', NULL, 2, 2, NULL),
(23, '50\'s Pack', '1', 1, '2024-02-25 19:42:54', '2024-02-25 19:42:54', NULL, 2, NULL, NULL),
(24, '120\'s Pack', '1', 1, '2024-02-25 19:46:36', '2024-02-25 19:46:36', NULL, 2, NULL, NULL),
(25, '250 ml bottle', '1', 1, '2024-02-25 20:05:15', '2024-02-25 20:05:26', '2024-02-25 20:05:26', 2, NULL, NULL),
(26, '120 ml bottle', '1', 1, '2024-02-25 20:11:02', '2024-02-25 20:11:02', NULL, 2, NULL, NULL),
(27, '140 gm tube', '1', 1, '2024-02-25 20:23:36', '2024-02-25 20:23:36', NULL, 2, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_04_02_193005_create_translations_table', 1),
(2, '2014_10_12_000000_create_users_table', 1),
(3, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(4, '2014_10_12_100000_create_password_resets_table', 1),
(5, '2019_08_19_000000_create_failed_jobs_table', 1),
(6, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(7, '2023_12_18_142659_create_permission_tables', 1),
(8, '2023_12_18_142724_add_prefix_column_to_permissions_table', 1),
(9, '2023_12_19_195430_create_admins_table', 1),
(10, '2023_12_20_103702_add_audit_columns_on_permissions_table', 1),
(11, '2023_12_20_103719_add_audit_columns_on_roles_table', 1),
(12, '2023_12_20_121415_add_audit_columns_on_users_table', 1),
(13, '2023_12_21_124938_create_kyc_settings_table', 1),
(14, '2024_01_09_061925_create_submitted_kycs_table', 1),
(15, '2024_01_09_073645_create_pharmacies_table', 1),
(16, '2024_01_09_125128_create_site_settings_table', 1),
(17, '2024_01_12_133030_create_documentations_table', 1),
(18, '2024_01_16_073625_create_district_managers_table', 1),
(19, '2024_01_16_091539_create_local_area_managers_table', 1),
(20, '2024_01_18_081713_create_email_templates_table', 1),
(21, '2024_01_31_072338_create_generic_names_table', 1),
(22, '2024_01_31_092533_create_company_names_table', 1),
(23, '2024_01_31_094226_create_medicine_categories_table', 1),
(24, '2024_01_31_094235_create_medicine_units_table', 1),
(25, '2024_01_31_094308_create_medicine_strengths_table', 1),
(26, '2024_02_01_125226_create_product_categories_table', 1),
(27, '2024_02_01_174639_create_product_sub_categories_table', 1),
(28, '2024_02_03_140722_create_medicines_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\Admin', 1),
(2, 'App\\Models\\Admin', 2);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `prefix` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`, `deleted_at`, `prefix`, `created_by`, `updated_by`, `deleted_by`) VALUES
(1, 'admin_list', 'admin', '2024-02-25 16:16:47', '2024-02-25 16:16:47', NULL, 'Admin', NULL, NULL, NULL),
(2, 'admin_create', 'admin', '2024-02-25 16:16:47', '2024-02-25 16:16:47', NULL, 'Admin', NULL, NULL, NULL),
(3, 'admin_edit', 'admin', '2024-02-25 16:16:47', '2024-02-25 16:16:47', NULL, 'Admin', NULL, NULL, NULL),
(4, 'admin_delete', 'admin', '2024-02-25 16:16:47', '2024-02-25 16:16:47', NULL, 'Admin', NULL, NULL, NULL),
(5, 'role_list', 'admin', '2024-02-25 16:16:47', '2024-02-25 16:16:47', NULL, 'Role', NULL, NULL, NULL),
(6, 'role_create', 'admin', '2024-02-25 16:16:47', '2024-02-25 16:16:47', NULL, 'Role', NULL, NULL, NULL),
(7, 'role_edit', 'admin', '2024-02-25 16:16:47', '2024-02-25 16:16:47', NULL, 'Role', NULL, NULL, NULL),
(8, 'role_delete', 'admin', '2024-02-25 16:16:47', '2024-02-25 16:16:47', NULL, 'Role', NULL, NULL, NULL),
(9, 'permission_list', 'admin', '2024-02-25 16:16:47', '2024-02-25 16:16:47', NULL, 'Permission', NULL, NULL, NULL),
(10, 'permission_create', 'admin', '2024-02-25 16:16:47', '2024-02-25 16:16:47', NULL, 'Permission', NULL, NULL, NULL),
(11, 'permission_edit', 'admin', '2024-02-25 16:16:47', '2024-02-25 16:16:47', NULL, 'Permission', NULL, NULL, NULL),
(12, 'permission_delete', 'admin', '2024-02-25 16:16:47', '2024-02-25 16:16:47', NULL, 'Permission', NULL, NULL, NULL),
(13, 'user_list', 'admin', '2024-02-25 16:16:47', '2024-02-25 16:16:47', NULL, 'User', NULL, NULL, NULL),
(14, 'user_create', 'admin', '2024-02-25 16:16:47', '2024-02-25 16:16:47', NULL, 'User', NULL, NULL, NULL),
(15, 'user_edit', 'admin', '2024-02-25 16:16:47', '2024-02-25 16:16:47', NULL, 'User', NULL, NULL, NULL),
(16, 'user_delete', 'admin', '2024-02-25 16:16:47', '2024-02-25 16:16:47', NULL, 'User', NULL, NULL, NULL),
(17, 'user_kyc_settings', 'admin', '2024-02-25 16:16:47', '2024-02-25 16:16:47', NULL, 'User KYC Settings', NULL, NULL, NULL),
(18, 'user_kyc_list', 'admin', '2024-02-25 16:16:47', '2024-02-25 16:16:47', NULL, 'User KYC', NULL, NULL, NULL),
(19, 'user_kyc_create', 'admin', '2024-02-25 16:16:47', '2024-02-25 16:16:47', NULL, 'User KYC', NULL, NULL, NULL),
(20, 'user_kyc_edit', 'admin', '2024-02-25 16:16:47', '2024-02-25 16:16:47', NULL, 'User KYC', NULL, NULL, NULL),
(21, 'user_kyc_delete', 'admin', '2024-02-25 16:16:47', '2024-02-25 16:16:47', NULL, 'User KYC', NULL, NULL, NULL),
(22, 'pharmacy_list', 'admin', '2024-02-25 16:16:47', '2024-02-25 16:16:47', NULL, 'Pharmacy', NULL, NULL, NULL),
(23, 'pharmacy_create', 'admin', '2024-02-25 16:16:47', '2024-02-25 16:16:47', NULL, 'Pharmacy', NULL, NULL, NULL),
(24, 'pharmacy_edit', 'admin', '2024-02-25 16:16:47', '2024-02-25 16:16:47', NULL, 'Pharmacy', NULL, NULL, NULL),
(25, 'pharmacy_delete', 'admin', '2024-02-25 16:16:47', '2024-02-25 16:16:47', NULL, 'Pharmacy', NULL, NULL, NULL),
(26, 'pharmacy_kyc_settings', 'admin', '2024-02-25 16:16:47', '2024-02-25 16:16:47', NULL, 'Pharmacy KYC Settings', NULL, NULL, NULL),
(27, 'pharmacy_kyc_list', 'admin', '2024-02-25 16:16:47', '2024-02-25 16:16:47', NULL, 'Pharmacy KYC', NULL, NULL, NULL),
(28, 'pharmacy_kyc_create', 'admin', '2024-02-25 16:16:47', '2024-02-25 16:16:47', NULL, 'Pharmacy KYC', NULL, NULL, NULL),
(29, 'pharmacy_kyc_edit', 'admin', '2024-02-25 16:16:47', '2024-02-25 16:16:47', NULL, 'Pharmacy KYC', NULL, NULL, NULL),
(30, 'pharmacy_kyc_delete', 'admin', '2024-02-25 16:16:47', '2024-02-25 16:16:47', NULL, 'Pharmacy KYC', NULL, NULL, NULL),
(31, 'site_settings', 'admin', '2024-02-25 16:16:47', '2024-02-25 16:16:47', NULL, 'Site Settings', NULL, NULL, NULL),
(32, 'district_manager_list', 'admin', '2024-02-25 16:16:47', '2024-02-25 16:16:47', NULL, 'District Manager', NULL, NULL, NULL),
(33, 'district_manager_create', 'admin', '2024-02-25 16:16:48', '2024-02-25 16:16:48', NULL, 'District Manager', NULL, NULL, NULL),
(34, 'district_manager_edit', 'admin', '2024-02-25 16:16:48', '2024-02-25 16:16:48', NULL, 'District Manager', NULL, NULL, NULL),
(35, 'district_manager_delete', 'admin', '2024-02-25 16:16:48', '2024-02-25 16:16:48', NULL, 'District Manager', NULL, NULL, NULL),
(36, 'local_area_manager_list', 'admin', '2024-02-25 16:16:48', '2024-02-25 16:16:48', NULL, 'Local Area Manager', NULL, NULL, NULL),
(37, 'local_area_manager_create', 'admin', '2024-02-25 16:16:48', '2024-02-25 16:16:48', NULL, 'Local Area Manager', NULL, NULL, NULL),
(38, 'local_area_manager_edit', 'admin', '2024-02-25 16:16:48', '2024-02-25 16:16:48', NULL, 'Local Area Manager', NULL, NULL, NULL),
(39, 'local_area_manager_delete', 'admin', '2024-02-25 16:16:48', '2024-02-25 16:16:48', NULL, 'Local Area Manager', NULL, NULL, NULL),
(40, 'user_profile', 'admin', '2024-02-25 16:16:48', '2024-02-25 16:16:48', NULL, 'User', NULL, NULL, NULL),
(41, 'admin_profile', 'admin', '2024-02-25 16:16:48', '2024-02-25 16:16:48', NULL, 'Admin', NULL, NULL, NULL),
(42, 'pharmacy_profile', 'admin', '2024-02-25 16:16:48', '2024-02-25 16:16:48', NULL, 'Pharmacy', NULL, NULL, NULL),
(43, 'district_manager_profile', 'admin', '2024-02-25 16:16:48', '2024-02-25 16:16:48', NULL, 'District Manager', NULL, NULL, NULL),
(44, 'local_area_manager_profile', 'admin', '2024-02-25 16:16:48', '2024-02-25 16:16:48', NULL, 'Local Area Manager', NULL, NULL, NULL),
(45, 'generic_name_list', 'admin', '2024-02-25 16:16:48', '2024-02-25 16:16:48', NULL, 'Generic Name', NULL, NULL, NULL),
(46, 'generic_name_create', 'admin', '2024-02-25 16:16:48', '2024-02-25 16:16:48', NULL, 'Generic Name', NULL, NULL, NULL),
(47, 'generic_name_edit', 'admin', '2024-02-25 16:16:48', '2024-02-25 16:16:48', NULL, 'Generic Name', NULL, NULL, NULL),
(48, 'generic_name_delete', 'admin', '2024-02-25 16:16:48', '2024-02-25 16:16:48', NULL, 'Generic Name', NULL, NULL, NULL),
(49, 'company_name_list', 'admin', '2024-02-25 16:16:48', '2024-02-25 16:16:48', NULL, 'Company Name', NULL, NULL, NULL),
(50, 'company_name_create', 'admin', '2024-02-25 16:16:48', '2024-02-25 16:16:48', NULL, 'Company Name', NULL, NULL, NULL),
(51, 'company_name_edit', 'admin', '2024-02-25 16:16:48', '2024-02-25 16:16:48', NULL, 'Company Name', NULL, NULL, NULL),
(52, 'company_name_delete', 'admin', '2024-02-25 16:16:48', '2024-02-25 16:16:48', NULL, 'Company Name', NULL, NULL, NULL),
(53, 'medicine_category_list', 'admin', '2024-02-25 16:16:48', '2024-02-25 16:16:48', NULL, 'Medicine Dosage', NULL, NULL, NULL),
(54, 'medicine_category_create', 'admin', '2024-02-25 16:16:48', '2024-02-25 16:16:48', NULL, 'Medicine Dosage', NULL, NULL, NULL),
(55, 'medicine_category_edit', 'admin', '2024-02-25 16:16:48', '2024-02-25 16:16:48', NULL, 'Medicine Dosage', NULL, NULL, NULL),
(56, 'medicine_category_delete', 'admin', '2024-02-25 16:16:48', '2024-02-25 16:16:48', NULL, 'Medicine Dosage', NULL, NULL, NULL),
(57, 'medicine_unit_list', 'admin', '2024-02-25 16:16:48', '2024-02-25 16:16:48', NULL, 'Medicine Unit', NULL, NULL, NULL),
(58, 'medicine_unit_create', 'admin', '2024-02-25 16:16:48', '2024-02-25 16:16:48', NULL, 'Medicine Unit', NULL, NULL, NULL),
(59, 'medicine_unit_edit', 'admin', '2024-02-25 16:16:48', '2024-02-25 16:16:48', NULL, 'Medicine Unit', NULL, NULL, NULL),
(60, 'medicine_unit_delete', 'admin', '2024-02-25 16:16:48', '2024-02-25 16:16:48', NULL, 'Medicine Unit', NULL, NULL, NULL),
(61, 'medicine_strength_list', 'admin', '2024-02-25 16:16:48', '2024-02-25 16:16:48', NULL, 'Medicine Strength', NULL, NULL, NULL),
(62, 'medicine_strength_create', 'admin', '2024-02-25 16:16:48', '2024-02-25 16:16:48', NULL, 'Medicine Strength', NULL, NULL, NULL),
(63, 'medicine_strength_edit', 'admin', '2024-02-25 16:16:48', '2024-02-25 16:16:48', NULL, 'Medicine Strength', NULL, NULL, NULL),
(64, 'medicine_strength_delete', 'admin', '2024-02-25 16:16:48', '2024-02-25 16:16:48', NULL, 'Medicine Strength', NULL, NULL, NULL),
(65, 'product_category_list', 'admin', '2024-02-25 16:16:48', '2024-02-25 16:16:48', NULL, 'Product Category', NULL, NULL, NULL),
(66, 'product_category_create', 'admin', '2024-02-25 16:16:48', '2024-02-25 16:16:48', NULL, 'Product Category', NULL, NULL, NULL),
(67, 'product_category_edit', 'admin', '2024-02-25 16:16:48', '2024-02-25 16:16:48', NULL, 'Product Category', NULL, NULL, NULL),
(68, 'product_category_delete', 'admin', '2024-02-25 16:16:48', '2024-02-25 16:16:48', NULL, 'Product Category', NULL, NULL, NULL),
(69, 'medicine_list', 'admin', '2024-02-25 16:16:48', '2024-02-25 16:16:48', NULL, 'Medicine', NULL, NULL, NULL),
(70, 'medicine_create', 'admin', '2024-02-25 16:16:48', '2024-02-25 16:16:48', NULL, 'Medicine', NULL, NULL, NULL),
(71, 'medicine_edit', 'admin', '2024-02-25 16:16:48', '2024-02-25 16:16:48', NULL, 'Medicine', NULL, NULL, NULL),
(72, 'medicine_delete', 'admin', '2024-02-25 16:16:48', '2024-02-25 16:16:48', NULL, 'Medicine', NULL, NULL, NULL),
(73, 'district_manager_kyc_settings', 'admin', '2024-02-25 16:16:48', '2024-02-25 16:16:48', NULL, 'DM KYC Settings', NULL, NULL, NULL),
(74, 'local_area_manager_kyc_settings', 'admin', '2024-02-25 16:16:48', '2024-02-25 16:16:48', NULL, 'LAM KYC Settings', NULL, NULL, NULL),
(75, 'local_area_manager_kyc_list', 'admin', '2024-02-25 16:16:48', '2024-02-25 16:16:48', NULL, 'LAM KYC', NULL, NULL, NULL),
(76, 'local_area_manager_kyc_details', 'admin', '2024-02-25 16:16:48', '2024-02-25 16:16:48', NULL, 'LAM KYC', NULL, NULL, NULL),
(77, 'local_area_manager_kyc_status', 'admin', '2024-02-25 16:16:48', '2024-02-25 16:16:48', NULL, 'LAM KYC', NULL, NULL, NULL),
(78, 'local_area_manager_kyc_delete', 'admin', '2024-02-25 16:16:48', '2024-02-25 16:16:48', NULL, 'LAM KYC', NULL, NULL, NULL),
(79, 'district_manager_kyc_list', 'admin', '2024-02-25 16:16:48', '2024-02-25 16:16:48', NULL, 'DM KYC', NULL, NULL, NULL),
(80, 'district_manager_kyc_details', 'admin', '2024-02-25 16:16:48', '2024-02-25 16:16:48', NULL, 'DM KYC', NULL, NULL, NULL),
(81, 'district_manager_kyc_status', 'admin', '2024-02-25 16:16:48', '2024-02-25 16:16:48', NULL, 'DM KYC', NULL, NULL, NULL),
(82, 'district_manager_kyc_delete', 'admin', '2024-02-25 16:16:48', '2024-02-25 16:16:48', NULL, 'DM KYC', NULL, NULL, NULL),
(83, 'product_sub_category_list', 'admin', '2024-02-25 16:16:48', '2024-02-25 16:16:48', NULL, 'Product Sub Category', NULL, NULL, NULL),
(84, 'product_sub_category_edit', 'admin', '2024-02-25 16:16:48', '2024-02-25 16:16:48', NULL, 'Product Sub Category', NULL, NULL, NULL),
(85, 'product_sub_category_create', 'admin', '2024-02-25 16:16:48', '2024-02-25 16:16:48', NULL, 'Product Sub Category', NULL, NULL, NULL),
(86, 'product_sub_category_delete', 'admin', '2024-02-25 16:16:48', '2024-02-25 16:16:48', NULL, 'Product Sub Category', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pharmacies`
--

CREATE TABLE `pharmacies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bio` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `designation` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `creater_id` bigint(20) UNSIGNED DEFAULT NULL,
  `creater_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updater_id` bigint(20) UNSIGNED DEFAULT NULL,
  `updater_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleter_id` bigint(20) UNSIGNED DEFAULT NULL,
  `deleter_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pharmacies`
--

INSERT INTO `pharmacies` (`id`, `name`, `image`, `bio`, `designation`, `status`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `deleted_at`, `creater_id`, `creater_type`, `updater_id`, `updater_type`, `deleter_id`, `deleter_type`) VALUES
(1, 'Pharmacy1', NULL, NULL, NULL, 1, 'pharmacy1@euitsols.com', NULL, '$2y$12$IX4atw1IdVDwGa5B02y5AeHNIi8EYXnhB9lfz3swin2S7sZVA5cjW', NULL, '2024-02-25 16:16:48', '2024-02-25 16:16:48', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 'Pharmacy2', NULL, NULL, NULL, 1, 'pharmacy2@euitsols.com', NULL, '$2y$12$3gjx1il6aUb4v3/AyiX3LuWNwBeTKCTWnDKhzLcc3kY58Y2NW272O', NULL, '2024-02-25 16:16:48', '2024-02-25 16:16:48', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(3, 'Pharmacy3', NULL, NULL, NULL, 1, 'pharmacy3@euitsols.com', NULL, '$2y$12$ZNJVCgFzkdr683mBSAKhg.NyYzEqcFCxDD4jfnHJeKV7P.OLvVaoC', NULL, '2024-02-25 16:16:48', '2024-02-25 16:16:48', NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `product_categories`
--

CREATE TABLE `product_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `is_featured` tinyint(1) NOT NULL DEFAULT '0',
  `is_menu` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_categories`
--

INSERT INTO `product_categories` (`id`, `name`, `slug`, `image`, `status`, `is_featured`, `is_menu`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`) VALUES
(1, 'OTC Medicine', 'otc-medicine', NULL, 1, 1, 1, '2024-02-25 16:16:50', '2024-02-25 16:16:50', NULL, NULL, NULL, NULL),
(2, 'Women\'s Choice', 'women\'s-choice', NULL, 1, 1, 1, '2024-02-25 16:16:50', '2024-02-25 16:16:50', NULL, NULL, NULL, NULL),
(3, 'Personal Care', 'personal-care', NULL, 1, 1, 1, '2024-02-25 16:16:50', '2024-02-25 16:16:50', NULL, NULL, NULL, NULL),
(4, 'Diabetic Care', 'diabetic-care', NULL, 1, 1, 1, '2024-02-25 16:16:50', '2024-02-25 16:16:50', NULL, NULL, NULL, NULL),
(5, 'Baby Care', 'baby-care', NULL, 1, 1, 1, '2024-02-25 16:16:50', '2024-02-25 16:16:50', NULL, NULL, NULL, NULL),
(6, 'Dental Care', 'dental-care', NULL, 1, 1, 1, '2024-02-25 16:16:50', '2024-02-25 16:16:50', NULL, NULL, NULL, NULL),
(7, 'Devices', 'devices', NULL, 1, 1, 1, '2024-02-25 16:16:50', '2024-02-25 16:16:50', NULL, NULL, NULL, NULL),
(8, 'Prescription Medicine', 'prescription-medicine', NULL, 1, 1, 1, '2024-02-25 16:16:50', '2024-02-25 16:16:50', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `product_sub_categories`
--

CREATE TABLE `product_sub_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `pro_cat_id` bigint(20) UNSIGNED NOT NULL,
  `is_menu` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_sub_categories`
--

INSERT INTO `product_sub_categories` (`id`, `name`, `slug`, `image`, `status`, `pro_cat_id`, `is_menu`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`) VALUES
(1, 'Tablet', 'tablet-1', NULL, 1, 1, 0, '2024-02-25 16:16:50', '2024-02-25 16:16:50', NULL, NULL, NULL, NULL),
(2, 'Capsule', 'capsule-1', NULL, 1, 1, 0, '2024-02-25 16:16:50', '2024-02-25 16:16:50', NULL, NULL, NULL, NULL),
(3, 'Syrup', 'syrup-1', NULL, 1, 1, 0, '2024-02-25 16:16:50', '2024-02-25 16:16:50', NULL, NULL, NULL, NULL),
(4, 'Injection', 'injection-1', NULL, 1, 1, 0, '2024-02-25 16:16:50', '2024-02-25 16:16:50', NULL, NULL, NULL, NULL),
(5, 'Ointment', 'ointment-1', NULL, 1, 1, 0, '2024-02-25 16:16:50', '2024-02-25 16:16:50', NULL, NULL, NULL, NULL),
(6, 'Liquid', 'liquid-1', NULL, 1, 1, 0, '2024-02-25 16:16:50', '2024-02-25 16:16:50', NULL, NULL, NULL, NULL),
(7, 'Napkin', 'napkin-2', NULL, 1, 2, 0, '2024-02-25 16:16:50', '2024-02-25 16:16:50', NULL, NULL, NULL, NULL),
(8, 'Pill', 'pill-2', NULL, 1, 2, 0, '2024-02-25 16:16:50', '2024-02-25 16:16:50', NULL, NULL, NULL, NULL),
(9, 'Test Strip', 'test-strip-2', NULL, 1, 2, 0, '2024-02-25 16:16:50', '2024-02-25 16:16:50', NULL, NULL, NULL, NULL),
(10, 'Tablet', 'tablet-2', NULL, 1, 2, 0, '2024-02-25 16:16:50', '2024-02-25 16:16:50', NULL, NULL, NULL, NULL),
(11, 'Liquid', 'liquid-2', NULL, 1, 2, 0, '2024-02-25 16:16:50', '2024-02-25 16:16:50', NULL, NULL, NULL, NULL),
(12, 'Hand Rub', 'hand-rub-3', NULL, 1, 3, 0, '2024-02-25 16:16:50', '2024-02-25 16:16:50', NULL, NULL, NULL, NULL),
(13, 'Cream', 'cream-3', NULL, 1, 3, 0, '2024-02-25 16:16:50', '2024-02-25 16:16:50', NULL, NULL, NULL, NULL),
(14, 'Shampoo', 'shampoo-3', NULL, 1, 3, 0, '2024-02-25 16:16:50', '2024-02-25 16:16:50', NULL, NULL, NULL, NULL),
(15, 'Liquid', 'liquid-3', NULL, 1, 3, 0, '2024-02-25 16:16:50', '2024-02-25 16:16:50', NULL, NULL, NULL, NULL),
(16, 'Cotton Strips', 'cotton-strips-3', NULL, 1, 3, 0, '2024-02-25 16:16:50', '2024-02-25 16:16:50', NULL, NULL, NULL, NULL),
(17, 'Powder', 'powder-3', NULL, 1, 3, 0, '2024-02-25 16:16:50', '2024-02-25 16:16:50', NULL, NULL, NULL, NULL),
(18, 'Pad', 'pad-3', NULL, 1, 3, 0, '2024-02-25 16:16:50', '2024-02-25 16:16:50', NULL, NULL, NULL, NULL),
(19, 'Sachet', 'sachet-3', NULL, 1, 3, 0, '2024-02-25 16:16:50', '2024-02-25 16:16:50', NULL, NULL, NULL, NULL),
(20, 'Tissue', 'tissue-3', NULL, 1, 3, 0, '2024-02-25 16:16:50', '2024-02-25 16:16:50', NULL, NULL, NULL, NULL),
(21, 'Gloves', 'gloves-3', NULL, 1, 3, 0, '2024-02-25 16:16:50', '2024-02-25 16:16:50', NULL, NULL, NULL, NULL),
(22, 'Mask', 'mask-3', NULL, 1, 3, 0, '2024-02-25 16:16:50', '2024-02-25 16:16:50', NULL, NULL, NULL, NULL),
(23, 'Insulin Needle', 'insulin-needle-4', NULL, 1, 4, 0, '2024-02-25 16:16:50', '2024-02-25 16:16:50', NULL, NULL, NULL, NULL),
(24, 'Diabetics Care', 'diabetics-care-4', NULL, 1, 4, 0, '2024-02-25 16:16:50', '2024-02-25 16:16:50', NULL, NULL, NULL, NULL),
(25, 'Test Strips', 'test-strips-4', NULL, 1, 4, 0, '2024-02-25 16:16:50', '2024-02-25 16:16:50', NULL, NULL, NULL, NULL),
(26, 'Syringe', 'syringe-4', NULL, 1, 4, 0, '2024-02-25 16:16:50', '2024-02-25 16:16:50', NULL, NULL, NULL, NULL),
(27, 'Twist Type', 'twist-type-4', NULL, 1, 4, 0, '2024-02-25 16:16:50', '2024-02-25 16:16:50', NULL, NULL, NULL, NULL),
(28, 'Ice Bag', 'ice-bag-4', NULL, 1, 4, 0, '2024-02-25 16:16:50', '2024-02-25 16:16:50', NULL, NULL, NULL, NULL),
(29, 'Glucometer Machine', 'glucometer-machine-4', NULL, 1, 4, 0, '2024-02-25 16:16:50', '2024-02-25 16:16:50', NULL, NULL, NULL, NULL),
(30, 'Diaper', 'diaper-5', NULL, 1, 5, 0, '2024-02-25 16:16:50', '2024-02-25 16:16:50', NULL, NULL, NULL, NULL),
(31, 'Wipes', 'wipes-5', NULL, 1, 5, 0, '2024-02-25 16:16:50', '2024-02-25 16:16:50', NULL, NULL, NULL, NULL),
(32, 'Baby Cotton Buds', 'baby-cotton-buds-5', NULL, 1, 5, 0, '2024-02-25 16:16:50', '2024-02-25 16:16:50', NULL, NULL, NULL, NULL),
(33, 'Milk Powder', 'milk-powder-5', NULL, 1, 5, 0, '2024-02-25 16:16:50', '2024-02-25 16:16:50', NULL, NULL, NULL, NULL),
(34, 'Mouthwash', 'mouthwash-6', NULL, 1, 6, 0, '2024-02-25 16:16:50', '2024-02-25 16:16:50', NULL, NULL, NULL, NULL),
(35, 'Toothpaste', 'toothpaste-6', NULL, 1, 6, 0, '2024-02-25 16:16:50', '2024-02-25 16:16:50', NULL, NULL, NULL, NULL),
(36, 'Toothbrush', 'toothbrush-6', NULL, 1, 6, 0, '2024-02-25 16:16:50', '2024-02-25 16:16:50', NULL, NULL, NULL, NULL),
(37, 'Digital Thermometer', 'digital-thermometer-7', NULL, 1, 7, 0, '2024-02-25 16:16:50', '2024-02-25 16:16:50', NULL, NULL, NULL, NULL),
(38, 'Thermometer', 'thermometer-7', NULL, 1, 7, 0, '2024-02-25 16:16:50', '2024-02-25 16:16:50', NULL, NULL, NULL, NULL),
(39, 'Surgical Kit', 'surgical-kit-7', NULL, 1, 7, 0, '2024-02-25 16:16:50', '2024-02-25 16:16:50', NULL, NULL, NULL, NULL),
(40, 'Pressure Machine Analog', 'pressure-machine-analog-7', NULL, 1, 7, 0, '2024-02-25 16:16:50', '2024-02-25 16:16:50', NULL, NULL, NULL, NULL),
(41, 'Tablet', 'tablet-8', NULL, 1, 8, 0, '2024-02-25 16:16:50', '2024-02-25 16:16:50', NULL, NULL, NULL, NULL),
(42, 'Capsule', 'capsule-8', NULL, 1, 8, 0, '2024-02-25 16:16:50', '2024-02-25 16:16:50', NULL, NULL, NULL, NULL),
(43, 'Syrup', 'syrup-8', NULL, 1, 8, 0, '2024-02-25 16:16:50', '2024-02-25 16:16:50', NULL, NULL, NULL, NULL),
(44, 'Injection', 'injection-8', NULL, 1, 8, 0, '2024-02-25 16:16:50', '2024-02-25 16:16:50', NULL, NULL, NULL, NULL),
(45, 'Ointment', 'ointment-8', NULL, 1, 8, 0, '2024-02-25 16:16:50', '2024-02-25 16:16:50', NULL, NULL, NULL, NULL),
(46, 'Liquid', 'liquid-8', NULL, 1, 8, 0, '2024-02-25 16:16:50', '2024-02-25 16:16:50', NULL, NULL, NULL, NULL),
(47, 'Suspension', 'suspension', NULL, 1, 1, 0, '2024-02-25 18:05:59', '2024-02-25 18:05:59', NULL, 2, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`) VALUES
(1, 'superadmin', 'admin', '2024-02-25 16:16:47', '2024-02-25 16:16:47', NULL, NULL, NULL, NULL),
(2, 'admin', 'admin', '2024-02-25 16:16:47', '2024-02-25 16:16:47', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(9, 1),
(10, 1),
(11, 1),
(12, 1),
(13, 1),
(14, 1),
(15, 1),
(16, 1),
(17, 1),
(18, 1),
(19, 1),
(20, 1),
(21, 1),
(22, 1),
(23, 1),
(24, 1),
(25, 1),
(26, 1),
(27, 1),
(28, 1),
(29, 1),
(30, 1),
(31, 1),
(32, 1),
(33, 1),
(34, 1),
(35, 1),
(36, 1),
(37, 1),
(38, 1),
(39, 1),
(40, 1),
(41, 1),
(42, 1),
(43, 1),
(44, 1),
(45, 1),
(46, 1),
(47, 1),
(48, 1),
(49, 1),
(50, 1),
(51, 1),
(52, 1),
(53, 1),
(54, 1),
(55, 1),
(56, 1),
(57, 1),
(58, 1),
(59, 1),
(60, 1),
(61, 1),
(62, 1),
(63, 1),
(64, 1),
(65, 1),
(66, 1),
(67, 1),
(68, 1),
(69, 1),
(70, 1),
(71, 1),
(72, 1),
(73, 1),
(74, 1),
(75, 1),
(76, 1),
(77, 1),
(78, 1),
(79, 1),
(80, 1),
(81, 1),
(82, 1),
(83, 1),
(84, 1),
(85, 1),
(86, 1),
(1, 2),
(2, 2),
(3, 2),
(4, 2),
(5, 2),
(6, 2),
(7, 2),
(8, 2),
(9, 2),
(10, 2),
(11, 2),
(12, 2),
(13, 2),
(14, 2),
(15, 2),
(16, 2),
(17, 2),
(18, 2),
(19, 2),
(20, 2),
(21, 2),
(22, 2),
(23, 2),
(24, 2),
(25, 2),
(26, 2),
(27, 2),
(28, 2),
(29, 2),
(30, 2),
(31, 2),
(32, 2),
(33, 2),
(34, 2),
(35, 2),
(36, 2),
(37, 2),
(38, 2),
(39, 2),
(40, 2),
(41, 2),
(42, 2),
(43, 2),
(44, 2),
(45, 2),
(46, 2),
(47, 2),
(48, 2),
(49, 2),
(50, 2),
(51, 2),
(52, 2),
(53, 2),
(54, 2),
(55, 2),
(56, 2),
(57, 2),
(58, 2),
(59, 2),
(60, 2),
(61, 2),
(62, 2),
(63, 2),
(64, 2),
(65, 2),
(66, 2),
(67, 2),
(68, 2),
(69, 2),
(70, 2),
(71, 2),
(72, 2),
(73, 2),
(74, 2),
(75, 2),
(76, 2),
(77, 2),
(78, 2),
(79, 2),
(80, 2),
(81, 2),
(82, 2),
(83, 2),
(84, 2),
(85, 2),
(86, 2);

-- --------------------------------------------------------

--
-- Table structure for table `site_settings`
--

CREATE TABLE `site_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `env_key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `value` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `site_settings`
--

INSERT INTO `site_settings` (`id`, `key`, `env_key`, `value`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`) VALUES
(1, 'site_name', 'APP_NAME', 'Dhaka Pharmacy', '2024-02-25 16:16:48', '2024-02-25 16:16:48', NULL, NULL, NULL, NULL),
(2, 'site_short_name', 'APP_SHORT_NAME', 'DP', '2024-02-25 16:16:48', '2024-02-25 16:16:48', NULL, NULL, NULL, NULL),
(3, 'timezone', 'TIMEZONE', 'Asia/Dhaka', '2024-02-25 16:16:48', '2024-02-25 16:16:48', NULL, NULL, NULL, NULL),
(4, 'env', 'APP_ENV', 'production', '2024-02-25 16:16:48', '2024-02-25 16:16:48', NULL, NULL, NULL, NULL),
(5, 'debug', 'APP_DEBUG', '0', '2024-02-25 16:16:48', '2024-02-25 16:16:48', NULL, NULL, NULL, NULL),
(6, 'debugbar', 'DEBUGBAR_ENABLED', '0', '2024-02-25 16:16:48', '2024-02-25 16:16:48', NULL, NULL, NULL, NULL),
(7, 'date_format', 'DATE_FORMAT', 'd/m/Y', '2024-02-25 16:16:48', '2024-02-25 16:16:48', NULL, NULL, NULL, NULL),
(8, 'time_format', 'TIME_FORMAT', 'H:i:s', '2024-02-25 16:16:48', '2024-02-25 16:16:48', NULL, NULL, NULL, NULL),
(9, 'mail_mailer', 'MAIL_MAILER', 'smtp', '2024-02-25 16:16:48', '2024-02-25 16:16:48', NULL, NULL, NULL, NULL),
(10, 'mail_host', 'MAIL_HOST', '', '2024-02-25 16:16:48', '2024-02-25 16:16:48', NULL, NULL, NULL, NULL),
(11, 'mail_port', 'MAIL_PORT', '', '2024-02-25 16:16:48', '2024-02-25 16:16:48', NULL, NULL, NULL, NULL),
(12, 'mail_username', 'MAIL_USERNAME', '', '2024-02-25 16:16:48', '2024-02-25 16:16:48', NULL, NULL, NULL, NULL),
(13, 'mail_password', 'MAIL_PASSWORD', '', '2024-02-25 16:16:48', '2024-02-25 16:16:48', NULL, NULL, NULL, NULL),
(14, 'mail_encription', 'MAIL_ENCRYPTION', '', '2024-02-25 16:16:48', '2024-02-25 16:16:48', NULL, NULL, NULL, NULL),
(15, 'mail_from', 'MAIL_FROM_ADDRESS', '', '2024-02-25 16:16:48', '2024-02-25 16:16:48', NULL, NULL, NULL, NULL),
(16, 'mail_from_name', 'MAIL_FROM_NAME', '', '2024-02-25 16:16:48', '2024-02-25 16:16:48', NULL, NULL, NULL, NULL),
(17, 'database_driver', 'DB_CONNECTION', 'mysql', '2024-02-25 16:16:48', '2024-02-25 16:16:48', NULL, NULL, NULL, NULL),
(18, 'database_host', 'DB_HOST', '127.0.0.1', '2024-02-25 16:16:48', '2024-02-25 16:16:48', NULL, NULL, NULL, NULL),
(19, 'database_port', 'DB_PORT', '3306', '2024-02-25 16:16:48', '2024-02-25 16:16:48', NULL, NULL, NULL, NULL),
(20, 'database_name', 'DB_DATABASE', 'dbagn3qmqlgczo', '2024-02-25 16:16:48', '2024-02-25 16:16:48', NULL, NULL, NULL, NULL),
(21, 'database_username', 'DB_USERNAME', 'uexujdijpkch2', '2024-02-25 16:16:48', '2024-02-25 16:16:48', NULL, NULL, NULL, NULL),
(22, 'database_password', 'DB_PASSWORD', 'ujgo7ajnfh8g', '2024-02-25 16:16:48', '2024-02-25 16:16:48', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `submitted_kycs`
--

CREATE TABLE `submitted_kycs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` enum('user','pharmacy','rider','doctor','dm','lam') COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `submitted_data` json NOT NULL,
  `note` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `creater_id` bigint(20) UNSIGNED DEFAULT NULL,
  `creater_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updater_id` bigint(20) UNSIGNED DEFAULT NULL,
  `updater_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleter_id` bigint(20) UNSIGNED DEFAULT NULL,
  `deleter_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bio` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `designation` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `otp` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `age` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `identification_type` enum('NID','DOB','Passport') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `identification_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `present_address` longtext COLLATE utf8mb4_unicode_ci,
  `gender` enum('Male','Female','Others') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `father_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mother_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `permanent_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `google_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `github_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `facebook_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `refresh_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar_original` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `creater_id` bigint(20) UNSIGNED DEFAULT NULL,
  `creater_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updater_id` bigint(20) UNSIGNED DEFAULT NULL,
  `updater_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleter_id` bigint(20) UNSIGNED DEFAULT NULL,
  `deleter_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `image`, `bio`, `designation`, `status`, `email`, `phone`, `email_verified_at`, `password`, `otp`, `remember_token`, `age`, `identification_type`, `identification_no`, `present_address`, `gender`, `dob`, `father_name`, `mother_name`, `permanent_address`, `google_id`, `github_id`, `facebook_id`, `token`, `refresh_token`, `avatar`, `avatar_original`, `deleted_at`, `created_at`, `updated_at`, `creater_id`, `creater_type`, `updater_id`, `updater_type`, `deleter_id`, `deleter_type`) VALUES
(1, 'User1', NULL, NULL, NULL, 1, NULL, '01711122231', NULL, '$2y$12$UwY0OF3Lt/YEZi/JwxeijuU.5N0FJXZaCpaH0u6OfWGu184IwqPIq', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-02-25 16:16:46', '2024-02-25 16:16:46', NULL, NULL, NULL, NULL, NULL, NULL),
(2, 'User2', NULL, NULL, NULL, 1, NULL, '01711122232', NULL, '$2y$12$ymzZ8ZGipySt/yJ6jDlFvu41okeYQK1I9UgCNXJlGoqkTtmSZbehm', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-02-25 16:16:47', '2024-02-25 16:16:47', NULL, NULL, NULL, NULL, NULL, NULL),
(3, 'User3', NULL, NULL, NULL, 1, NULL, '01711122233', NULL, '$2y$12$HiSJ/Tct2wCZppsbm.FFcO.QnM9QnuR43ICfiP./eGdaokxbCtwFq', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-02-25 16:16:47', '2024-02-25 16:16:47', NULL, NULL, NULL, NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admins_email_unique` (`email`),
  ADD KEY `admins_created_by_foreign` (`created_by`),
  ADD KEY `admins_updated_by_foreign` (`updated_by`),
  ADD KEY `admins_deleted_by_foreign` (`deleted_by`),
  ADD KEY `admins_role_id_foreign` (`role_id`);

--
-- Indexes for table `company_names`
--
ALTER TABLE `company_names`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `company_names_name_unique` (`name`),
  ADD UNIQUE KEY `company_names_slug_unique` (`slug`),
  ADD KEY `company_names_created_by_foreign` (`created_by`),
  ADD KEY `company_names_updated_by_foreign` (`updated_by`),
  ADD KEY `company_names_deleted_by_foreign` (`deleted_by`);

--
-- Indexes for table `district_managers`
--
ALTER TABLE `district_managers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `district_managers_phone_unique` (`phone`),
  ADD UNIQUE KEY `district_managers_email_unique` (`email`),
  ADD KEY `district_managers_created_by_foreign` (`created_by`),
  ADD KEY `district_managers_updated_by_foreign` (`updated_by`),
  ADD KEY `district_managers_deleted_by_foreign` (`deleted_by`);

--
-- Indexes for table `documentations`
--
ALTER TABLE `documentations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `documentations_module_key_unique` (`module_key`),
  ADD UNIQUE KEY `documentations_title_unique` (`title`),
  ADD KEY `documentations_created_by_foreign` (`created_by`),
  ADD KEY `documentations_updated_by_foreign` (`updated_by`),
  ADD KEY `documentations_deleted_by_foreign` (`deleted_by`);

--
-- Indexes for table `email_templates`
--
ALTER TABLE `email_templates`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email_templates_key_unique` (`key`),
  ADD KEY `email_templates_created_by_foreign` (`created_by`),
  ADD KEY `email_templates_updated_by_foreign` (`updated_by`),
  ADD KEY `email_templates_deleted_by_foreign` (`deleted_by`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `generic_names`
--
ALTER TABLE `generic_names`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `generic_names_name_unique` (`name`),
  ADD UNIQUE KEY `generic_names_slug_unique` (`slug`),
  ADD KEY `generic_names_created_by_foreign` (`created_by`),
  ADD KEY `generic_names_updated_by_foreign` (`updated_by`),
  ADD KEY `generic_names_deleted_by_foreign` (`deleted_by`);

--
-- Indexes for table `kyc_settings`
--
ALTER TABLE `kyc_settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kyc_settings_type_unique` (`type`),
  ADD KEY `kyc_settings_created_by_foreign` (`created_by`),
  ADD KEY `kyc_settings_updated_by_foreign` (`updated_by`),
  ADD KEY `kyc_settings_deleted_by_foreign` (`deleted_by`);

--
-- Indexes for table `local_area_managers`
--
ALTER TABLE `local_area_managers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `local_area_managers_phone_unique` (`phone`),
  ADD UNIQUE KEY `local_area_managers_email_unique` (`email`),
  ADD KEY `local_area_managers_dm_id_foreign` (`dm_id`);

--
-- Indexes for table `ltm_translations`
--
ALTER TABLE `ltm_translations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `medicines`
--
ALTER TABLE `medicines`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `medicines_name_unique` (`name`),
  ADD UNIQUE KEY `medicines_slug_unique` (`slug`),
  ADD KEY `medicines_created_by_foreign` (`created_by`),
  ADD KEY `medicines_updated_by_foreign` (`updated_by`),
  ADD KEY `medicines_deleted_by_foreign` (`deleted_by`),
  ADD KEY `medicines_pro_cat_id_foreign` (`pro_cat_id`),
  ADD KEY `medicines_pro_sub_cat_id_foreign` (`pro_sub_cat_id`),
  ADD KEY `medicines_generic_id_foreign` (`generic_id`),
  ADD KEY `medicines_company_id_foreign` (`company_id`),
  ADD KEY `medicines_strength_id_foreign` (`strength_id`);

--
-- Indexes for table `medicine_categories`
--
ALTER TABLE `medicine_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `medicine_categories_name_unique` (`name`),
  ADD UNIQUE KEY `medicine_categories_slug_unique` (`slug`),
  ADD KEY `medicine_categories_created_by_foreign` (`created_by`),
  ADD KEY `medicine_categories_updated_by_foreign` (`updated_by`),
  ADD KEY `medicine_categories_deleted_by_foreign` (`deleted_by`);

--
-- Indexes for table `medicine_strengths`
--
ALTER TABLE `medicine_strengths`
  ADD PRIMARY KEY (`id`),
  ADD KEY `medicine_strengths_created_by_foreign` (`created_by`),
  ADD KEY `medicine_strengths_updated_by_foreign` (`updated_by`),
  ADD KEY `medicine_strengths_deleted_by_foreign` (`deleted_by`);

--
-- Indexes for table `medicine_units`
--
ALTER TABLE `medicine_units`
  ADD PRIMARY KEY (`id`),
  ADD KEY `medicine_units_created_by_foreign` (`created_by`),
  ADD KEY `medicine_units_updated_by_foreign` (`updated_by`),
  ADD KEY `medicine_units_deleted_by_foreign` (`deleted_by`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

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
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`),
  ADD KEY `permissions_created_by_foreign` (`created_by`),
  ADD KEY `permissions_updated_by_foreign` (`updated_by`),
  ADD KEY `permissions_deleted_by_foreign` (`deleted_by`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `pharmacies`
--
ALTER TABLE `pharmacies`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pharmacies_email_unique` (`email`);

--
-- Indexes for table `product_categories`
--
ALTER TABLE `product_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `product_categories_name_unique` (`name`),
  ADD UNIQUE KEY `product_categories_slug_unique` (`slug`),
  ADD KEY `product_categories_created_by_foreign` (`created_by`),
  ADD KEY `product_categories_updated_by_foreign` (`updated_by`),
  ADD KEY `product_categories_deleted_by_foreign` (`deleted_by`);

--
-- Indexes for table `product_sub_categories`
--
ALTER TABLE `product_sub_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `product_sub_categories_slug_unique` (`slug`),
  ADD KEY `product_sub_categories_created_by_foreign` (`created_by`),
  ADD KEY `product_sub_categories_updated_by_foreign` (`updated_by`),
  ADD KEY `product_sub_categories_deleted_by_foreign` (`deleted_by`),
  ADD KEY `product_sub_categories_pro_cat_id_foreign` (`pro_cat_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`),
  ADD KEY `roles_created_by_foreign` (`created_by`),
  ADD KEY `roles_updated_by_foreign` (`updated_by`),
  ADD KEY `roles_deleted_by_foreign` (`deleted_by`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `site_settings`
--
ALTER TABLE `site_settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `site_settings_key_unique` (`key`),
  ADD KEY `site_settings_created_by_foreign` (`created_by`),
  ADD KEY `site_settings_updated_by_foreign` (`updated_by`),
  ADD KEY `site_settings_deleted_by_foreign` (`deleted_by`);

--
-- Indexes for table `submitted_kycs`
--
ALTER TABLE `submitted_kycs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_phone_unique` (`phone`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `company_names`
--
ALTER TABLE `company_names`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `district_managers`
--
ALTER TABLE `district_managers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `documentations`
--
ALTER TABLE `documentations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `email_templates`
--
ALTER TABLE `email_templates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `generic_names`
--
ALTER TABLE `generic_names`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `kyc_settings`
--
ALTER TABLE `kyc_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `local_area_managers`
--
ALTER TABLE `local_area_managers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `ltm_translations`
--
ALTER TABLE `ltm_translations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `medicines`
--
ALTER TABLE `medicines`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `medicine_categories`
--
ALTER TABLE `medicine_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `medicine_strengths`
--
ALTER TABLE `medicine_strengths`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `medicine_units`
--
ALTER TABLE `medicine_units`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pharmacies`
--
ALTER TABLE `pharmacies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `product_categories`
--
ALTER TABLE `product_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `product_sub_categories`
--
ALTER TABLE `product_sub_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `site_settings`
--
ALTER TABLE `site_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `submitted_kycs`
--
ALTER TABLE `submitted_kycs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admins`
--
ALTER TABLE `admins`
  ADD CONSTRAINT `admins_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `admins` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `admins_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `admins` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `admins_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `admins_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `admins` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `company_names`
--
ALTER TABLE `company_names`
  ADD CONSTRAINT `company_names_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `admins` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `company_names_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `admins` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `company_names_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `admins` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `district_managers`
--
ALTER TABLE `district_managers`
  ADD CONSTRAINT `district_managers_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `admins` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `district_managers_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `admins` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `district_managers_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `admins` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `documentations`
--
ALTER TABLE `documentations`
  ADD CONSTRAINT `documentations_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `admins` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `documentations_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `admins` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `documentations_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `admins` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `email_templates`
--
ALTER TABLE `email_templates`
  ADD CONSTRAINT `email_templates_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `admins` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `email_templates_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `admins` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `email_templates_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `admins` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `generic_names`
--
ALTER TABLE `generic_names`
  ADD CONSTRAINT `generic_names_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `admins` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `generic_names_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `admins` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `generic_names_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `admins` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `kyc_settings`
--
ALTER TABLE `kyc_settings`
  ADD CONSTRAINT `kyc_settings_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `admins` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `kyc_settings_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `admins` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `kyc_settings_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `admins` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `local_area_managers`
--
ALTER TABLE `local_area_managers`
  ADD CONSTRAINT `local_area_managers_dm_id_foreign` FOREIGN KEY (`dm_id`) REFERENCES `district_managers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `medicines`
--
ALTER TABLE `medicines`
  ADD CONSTRAINT `medicines_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `company_names` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `medicines_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `admins` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `medicines_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `admins` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `medicines_generic_id_foreign` FOREIGN KEY (`generic_id`) REFERENCES `generic_names` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `medicines_pro_cat_id_foreign` FOREIGN KEY (`pro_cat_id`) REFERENCES `product_categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `medicines_pro_sub_cat_id_foreign` FOREIGN KEY (`pro_sub_cat_id`) REFERENCES `product_sub_categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `medicines_strength_id_foreign` FOREIGN KEY (`strength_id`) REFERENCES `medicine_strengths` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `medicines_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `admins` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `medicine_categories`
--
ALTER TABLE `medicine_categories`
  ADD CONSTRAINT `medicine_categories_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `admins` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `medicine_categories_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `admins` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `medicine_categories_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `admins` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `medicine_strengths`
--
ALTER TABLE `medicine_strengths`
  ADD CONSTRAINT `medicine_strengths_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `admins` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `medicine_strengths_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `admins` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `medicine_strengths_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `admins` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `medicine_units`
--
ALTER TABLE `medicine_units`
  ADD CONSTRAINT `medicine_units_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `admins` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `medicine_units_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `admins` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `medicine_units_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `admins` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `permissions`
--
ALTER TABLE `permissions`
  ADD CONSTRAINT `permissions_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `admins` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `permissions_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `admins` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `permissions_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `admins` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product_categories`
--
ALTER TABLE `product_categories`
  ADD CONSTRAINT `product_categories_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `admins` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `product_categories_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `admins` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `product_categories_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `admins` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product_sub_categories`
--
ALTER TABLE `product_sub_categories`
  ADD CONSTRAINT `product_sub_categories_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `admins` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `product_sub_categories_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `admins` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `product_sub_categories_pro_cat_id_foreign` FOREIGN KEY (`pro_cat_id`) REFERENCES `product_categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `product_sub_categories_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `admins` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `roles`
--
ALTER TABLE `roles`
  ADD CONSTRAINT `roles_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `admins` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `roles_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `admins` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `roles_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `admins` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `site_settings`
--
ALTER TABLE `site_settings`
  ADD CONSTRAINT `site_settings_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `admins` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `site_settings_deleted_by_foreign` FOREIGN KEY (`deleted_by`) REFERENCES `admins` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `site_settings_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `admins` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
