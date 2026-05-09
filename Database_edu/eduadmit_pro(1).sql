-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 09, 2026 at 07:22 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `eduadmit_pro`
--

-- --------------------------------------------------------

--
-- Table structure for table `applications`
--

CREATE TABLE `applications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `mobile` varchar(255) DEFAULT NULL,
  `lead_id` bigint(20) UNSIGNED DEFAULT NULL,
  `course_id` bigint(20) UNSIGNED NOT NULL,
  `application_no` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'registered',
  `tenth_percentage` decimal(5,2) DEFAULT NULL,
  `twelfth_percentage` decimal(5,2) DEFAULT NULL,
  `merit_score` decimal(5,2) DEFAULT NULL,
  `rejection_reason` varchar(255) DEFAULT NULL,
  `applied_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `admin_remarks` text DEFAULT NULL,
  `quota_category_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `applications`
--

INSERT INTO `applications` (`id`, `user_id`, `first_name`, `last_name`, `dob`, `mobile`, `lead_id`, `course_id`, `application_no`, `status`, `tenth_percentage`, `twelfth_percentage`, `merit_score`, `rejection_reason`, `applied_date`, `created_at`, `updated_at`, `admin_remarks`, `quota_category_id`) VALUES
(1, 6, 'Akarsh', 'B', '2001-10-31', '9400498901', NULL, 1, 'BSCCOMPUTERSCIENCE-2026-TDPMV', 'enrolled', 89.10, 91.10, 90.10, NULL, '2026-05-08', '2026-05-08 12:10:20', '2026-05-09 04:39:09', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `audit_logs`
--

CREATE TABLE `audit_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `action` varchar(255) NOT NULL,
  `resource` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'success',
  `ip_address` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `duration_years` int(11) NOT NULL,
  `total_seats` int(11) NOT NULL,
  `application_fee` decimal(10,2) NOT NULL,
  `admission_fee` decimal(10,2) NOT NULL,
  `lab_fee` decimal(10,2) DEFAULT NULL,
  `library_fee` decimal(10,2) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `department_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `level` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `credits` int(11) DEFAULT NULL,
  `semester_count` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `name`, `code`, `duration_years`, `total_seats`, `application_fee`, `admission_fee`, `lab_fee`, `library_fee`, `is_active`, `department_id`, `created_at`, `updated_at`, `level`, `description`, `credits`, `semester_count`) VALUES
(1, 'B.Sc. Computer Science', 'CS101', 3, 60, 500.00, 15000.00, NULL, NULL, 1, 6, '2026-05-08 11:36:31', '2026-05-08 12:04:45', NULL, NULL, NULL, NULL),
(2, 'B.Tech Computer Science', 'CSE101', 4, 120, 1000.00, 50000.00, NULL, NULL, 1, 3, '2026-05-08 12:02:03', '2026-05-08 12:04:45', NULL, NULL, NULL, NULL),
(3, 'Bachelor of Computer Applications (BCA)', 'BCA101', 3, 60, 500.00, 20000.00, NULL, NULL, 1, 3, '2026-05-08 12:02:03', '2026-05-08 12:04:45', NULL, NULL, NULL, NULL),
(4, 'Bachelor of Business Administration (BBA)', 'BBA101', 3, 60, 500.00, 25000.00, NULL, NULL, 1, 2, '2026-05-08 12:02:03', '2026-05-08 12:04:45', NULL, NULL, NULL, NULL),
(5, 'Master of Business Administration (MBA)', 'MBA101', 2, 60, 1000.00, 40000.00, NULL, NULL, 1, 2, '2026-05-08 12:02:03', '2026-05-08 12:04:45', NULL, NULL, NULL, NULL),
(6, 'M.Tech Computer Science', 'CSE102', 2, 30, 1200.00, 60000.00, NULL, NULL, 1, 3, '2026-05-08 12:04:45', '2026-05-08 12:04:45', NULL, NULL, NULL, NULL),
(7, 'Master of Computer Applications (MCA)', 'MCA101', 2, 60, 800.00, 35000.00, NULL, NULL, 1, 3, '2026-05-08 12:04:45', '2026-05-08 12:04:45', NULL, NULL, NULL, NULL),
(8, 'B.Sc. Data Science', 'DS101', 3, 40, 600.00, 25000.00, NULL, NULL, 1, 3, '2026-05-08 12:04:45', '2026-05-08 12:04:45', NULL, NULL, NULL, NULL),
(9, 'Executive MBA', 'EMBA101', 1, 30, 1500.00, 75000.00, NULL, NULL, 1, 2, '2026-05-08 12:04:45', '2026-05-08 12:04:45', NULL, NULL, NULL, NULL),
(10, 'Ph.D. in Management', 'PHDM101', 3, 10, 2000.00, 50000.00, NULL, NULL, 1, 2, '2026-05-08 12:04:45', '2026-05-08 12:04:45', NULL, NULL, NULL, NULL),
(11, 'Diploma in Digital Marketing', 'DDM101', 1, 50, 300.00, 15000.00, NULL, NULL, 1, 2, '2026-05-08 12:04:45', '2026-05-08 12:04:45', NULL, NULL, NULL, NULL),
(12, 'Bachelor of Commerce (B.Com)', 'BCOM101', 3, 100, 400.00, 15000.00, NULL, NULL, 1, 4, '2026-05-08 12:04:45', '2026-05-08 12:04:45', NULL, NULL, NULL, NULL),
(13, 'Master of Commerce (M.Com)', 'MCOM101', 2, 40, 600.00, 20000.00, NULL, NULL, 1, 4, '2026-05-08 12:04:45', '2026-05-08 12:04:45', NULL, NULL, NULL, NULL),
(14, 'B.Com Honours', 'BCOMH101', 3, 50, 500.00, 18000.00, NULL, NULL, 1, 4, '2026-05-08 12:04:45', '2026-05-08 12:04:45', NULL, NULL, NULL, NULL),
(15, 'B.Sc. Finance', 'BSCF101', 3, 40, 600.00, 22000.00, NULL, NULL, 1, 4, '2026-05-08 12:04:45', '2026-05-08 12:04:45', NULL, NULL, NULL, NULL),
(16, 'Diploma in Accounting', 'DA101', 1, 30, 300.00, 12000.00, NULL, NULL, 1, 4, '2026-05-08 12:04:45', '2026-05-08 12:04:45', NULL, NULL, NULL, NULL),
(17, 'B.A. English', 'BAENG101', 3, 60, 300.00, 10000.00, NULL, NULL, 1, 5, '2026-05-08 12:04:45', '2026-05-08 12:04:45', NULL, NULL, NULL, NULL),
(18, 'B.A. History', 'BAHIS101', 3, 60, 300.00, 10000.00, NULL, NULL, 1, 5, '2026-05-08 12:04:45', '2026-05-08 12:04:45', NULL, NULL, NULL, NULL),
(19, 'M.A. Political Science', 'MAPS101', 2, 40, 500.00, 15000.00, NULL, NULL, 1, 5, '2026-05-08 12:04:45', '2026-05-08 12:04:45', NULL, NULL, NULL, NULL),
(20, 'B.A. Psychology', 'BAPSY101', 3, 40, 400.00, 12000.00, NULL, NULL, 1, 5, '2026-05-08 12:04:45', '2026-05-08 12:04:45', NULL, NULL, NULL, NULL),
(21, 'Diploma in Fine Arts', 'DFA101', 1, 30, 300.00, 10000.00, NULL, NULL, 1, 5, '2026-05-08 12:04:45', '2026-05-08 12:04:45', NULL, NULL, NULL, NULL),
(22, 'B.Sc. Physics', 'BSCPH101', 3, 50, 400.00, 15000.00, NULL, NULL, 1, 6, '2026-05-08 12:04:45', '2026-05-08 12:04:45', NULL, NULL, NULL, NULL),
(23, 'B.Sc. Chemistry', 'BSCCH101', 3, 50, 400.00, 15000.00, NULL, NULL, 1, 6, '2026-05-08 12:04:45', '2026-05-08 12:04:45', NULL, NULL, NULL, NULL),
(24, 'M.Sc. Mathematics', 'MSCM101', 2, 30, 600.00, 20000.00, NULL, NULL, 1, 6, '2026-05-08 12:04:45', '2026-05-08 12:04:45', NULL, NULL, NULL, NULL),
(25, 'B.Sc. Biotechnology', 'BSCBIO101', 3, 40, 500.00, 18000.00, NULL, NULL, 1, 6, '2026-05-08 12:04:45', '2026-05-08 12:04:45', NULL, NULL, NULL, NULL),
(26, 'B.Tech Mechanical Engineering', 'ME101', 4, 60, 1000.00, 45000.00, NULL, NULL, 1, 7, '2026-05-08 12:04:45', '2026-05-08 12:04:45', NULL, NULL, NULL, NULL),
(27, 'B.Tech Civil Engineering', 'CE101', 4, 60, 1000.00, 45000.00, NULL, NULL, 1, 7, '2026-05-08 12:04:45', '2026-05-08 12:04:45', NULL, NULL, NULL, NULL),
(28, 'B.Tech Electrical Engineering', 'EE101', 4, 60, 1000.00, 45000.00, NULL, NULL, 1, 7, '2026-05-08 12:04:45', '2026-05-08 12:04:45', NULL, NULL, NULL, NULL),
(29, 'B.Tech Electronics & Communication', 'ECE101', 4, 60, 1000.00, 45000.00, NULL, NULL, 1, 7, '2026-05-08 12:04:45', '2026-05-08 12:04:45', NULL, NULL, NULL, NULL),
(30, 'M.Tech Structural Engineering', 'MSTE101', 2, 20, 1200.00, 55000.00, NULL, NULL, 1, 7, '2026-05-08 12:04:45', '2026-05-08 12:04:45', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `course_quotas`
--

CREATE TABLE `course_quotas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `course_id` bigint(20) UNSIGNED NOT NULL,
  `quota_category_id` bigint(20) UNSIGNED NOT NULL,
  `reserved_seats` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `course_quotas`
--

INSERT INTO `course_quotas` (`id`, `course_id`, `quota_category_id`, `reserved_seats`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 30, '2026-05-08 12:07:22', '2026-05-08 12:07:22'),
(2, 1, 2, 14, '2026-05-08 12:07:22', '2026-05-08 12:07:22'),
(3, 1, 3, 16, '2026-05-08 12:07:22', '2026-05-08 12:07:22'),
(4, 1, 4, 1, '2026-05-08 12:07:22', '2026-05-08 12:07:22'),
(5, 2, 1, 60, '2026-05-08 12:07:22', '2026-05-08 12:07:22'),
(6, 2, 2, 27, '2026-05-08 12:07:22', '2026-05-08 12:07:22'),
(7, 2, 3, 32, '2026-05-08 12:07:22', '2026-05-08 12:07:22'),
(8, 2, 4, 1, '2026-05-08 12:07:22', '2026-05-08 12:07:22'),
(9, 3, 1, 30, '2026-05-08 12:07:22', '2026-05-08 12:07:22'),
(10, 3, 2, 14, '2026-05-08 12:07:22', '2026-05-08 12:07:22'),
(11, 3, 3, 16, '2026-05-08 12:07:22', '2026-05-08 12:07:22'),
(12, 3, 4, 1, '2026-05-08 12:07:22', '2026-05-08 12:07:22'),
(13, 4, 1, 30, '2026-05-08 12:07:22', '2026-05-08 12:07:22'),
(14, 4, 2, 14, '2026-05-08 12:07:22', '2026-05-08 12:07:22'),
(15, 4, 3, 16, '2026-05-08 12:07:22', '2026-05-08 12:07:22'),
(16, 4, 4, 1, '2026-05-08 12:07:22', '2026-05-08 12:07:22'),
(17, 5, 1, 30, '2026-05-08 12:07:22', '2026-05-08 12:07:22'),
(18, 5, 2, 14, '2026-05-08 12:07:22', '2026-05-08 12:07:22'),
(19, 5, 3, 16, '2026-05-08 12:07:22', '2026-05-08 12:07:22'),
(20, 5, 4, 1, '2026-05-08 12:07:22', '2026-05-08 12:07:22'),
(21, 6, 1, 15, '2026-05-08 12:07:22', '2026-05-08 12:07:22'),
(22, 6, 2, 7, '2026-05-08 12:07:22', '2026-05-08 12:07:22'),
(23, 6, 3, 8, '2026-05-08 12:07:22', '2026-05-08 12:07:22'),
(24, 6, 4, 1, '2026-05-08 12:07:22', '2026-05-08 12:07:22'),
(25, 7, 1, 30, '2026-05-08 12:07:22', '2026-05-08 12:07:22'),
(26, 7, 2, 14, '2026-05-08 12:07:22', '2026-05-08 12:07:22'),
(27, 7, 3, 16, '2026-05-08 12:07:22', '2026-05-08 12:07:22'),
(28, 7, 4, 1, '2026-05-08 12:07:22', '2026-05-08 12:07:22'),
(29, 8, 1, 20, '2026-05-08 12:07:22', '2026-05-08 12:07:22'),
(30, 8, 2, 9, '2026-05-08 12:07:22', '2026-05-08 12:07:22'),
(31, 8, 3, 11, '2026-05-08 12:07:22', '2026-05-08 12:07:22'),
(32, 8, 4, 1, '2026-05-08 12:07:22', '2026-05-08 12:07:22'),
(33, 9, 1, 15, '2026-05-08 12:07:22', '2026-05-08 12:07:22'),
(34, 9, 2, 7, '2026-05-08 12:07:22', '2026-05-08 12:07:22'),
(35, 9, 3, 8, '2026-05-08 12:07:22', '2026-05-08 12:07:22'),
(36, 9, 4, 1, '2026-05-08 12:07:22', '2026-05-08 12:07:22'),
(37, 10, 1, 5, '2026-05-08 12:07:22', '2026-05-08 12:07:22'),
(38, 10, 2, 2, '2026-05-08 12:07:22', '2026-05-08 12:07:22'),
(39, 10, 3, 3, '2026-05-08 12:07:22', '2026-05-08 12:07:22'),
(40, 10, 4, 1, '2026-05-08 12:07:22', '2026-05-08 12:07:22'),
(41, 11, 1, 25, '2026-05-08 12:07:22', '2026-05-08 12:07:22'),
(42, 11, 2, 11, '2026-05-08 12:07:22', '2026-05-08 12:07:22'),
(43, 11, 3, 14, '2026-05-08 12:07:22', '2026-05-08 12:07:22'),
(44, 11, 4, 1, '2026-05-08 12:07:22', '2026-05-08 12:07:22'),
(45, 12, 1, 50, '2026-05-08 12:07:22', '2026-05-08 12:07:22'),
(46, 12, 2, 23, '2026-05-08 12:07:22', '2026-05-08 12:07:22'),
(47, 12, 3, 27, '2026-05-08 12:07:22', '2026-05-08 12:07:22'),
(48, 12, 4, 1, '2026-05-08 12:07:22', '2026-05-08 12:07:22'),
(49, 13, 1, 20, '2026-05-08 12:07:22', '2026-05-08 12:07:22'),
(50, 13, 2, 9, '2026-05-08 12:07:22', '2026-05-08 12:07:22'),
(51, 13, 3, 11, '2026-05-08 12:07:22', '2026-05-08 12:07:22'),
(52, 13, 4, 1, '2026-05-08 12:07:22', '2026-05-08 12:07:22'),
(53, 14, 1, 25, '2026-05-08 12:07:22', '2026-05-08 12:07:22'),
(54, 14, 2, 11, '2026-05-08 12:07:22', '2026-05-08 12:07:22'),
(55, 14, 3, 14, '2026-05-08 12:07:22', '2026-05-08 12:07:22'),
(56, 14, 4, 1, '2026-05-08 12:07:22', '2026-05-08 12:07:22'),
(57, 15, 1, 20, '2026-05-08 12:07:22', '2026-05-08 12:07:22'),
(58, 15, 2, 9, '2026-05-08 12:07:22', '2026-05-08 12:07:22'),
(59, 15, 3, 11, '2026-05-08 12:07:22', '2026-05-08 12:07:22'),
(60, 15, 4, 1, '2026-05-08 12:07:22', '2026-05-08 12:07:22'),
(61, 16, 1, 15, '2026-05-08 12:07:22', '2026-05-08 12:07:22'),
(62, 16, 2, 7, '2026-05-08 12:07:22', '2026-05-08 12:07:22'),
(63, 16, 3, 8, '2026-05-08 12:07:22', '2026-05-08 12:07:22'),
(64, 16, 4, 1, '2026-05-08 12:07:22', '2026-05-08 12:07:22'),
(65, 17, 1, 30, '2026-05-08 12:07:22', '2026-05-08 12:07:22'),
(66, 17, 2, 14, '2026-05-08 12:07:22', '2026-05-08 12:07:22'),
(67, 17, 3, 16, '2026-05-08 12:07:22', '2026-05-08 12:07:22'),
(68, 17, 4, 1, '2026-05-08 12:07:22', '2026-05-08 12:07:22'),
(69, 18, 1, 30, '2026-05-08 12:07:22', '2026-05-08 12:07:22'),
(70, 18, 2, 14, '2026-05-08 12:07:22', '2026-05-08 12:07:22'),
(71, 18, 3, 16, '2026-05-08 12:07:22', '2026-05-08 12:07:22'),
(72, 18, 4, 1, '2026-05-08 12:07:22', '2026-05-08 12:07:22'),
(73, 19, 1, 20, '2026-05-08 12:07:22', '2026-05-08 12:07:22'),
(74, 19, 2, 9, '2026-05-08 12:07:22', '2026-05-08 12:07:22'),
(75, 19, 3, 11, '2026-05-08 12:07:23', '2026-05-08 12:07:23'),
(76, 19, 4, 1, '2026-05-08 12:07:23', '2026-05-08 12:07:23'),
(77, 20, 1, 20, '2026-05-08 12:07:23', '2026-05-08 12:07:23'),
(78, 20, 2, 9, '2026-05-08 12:07:23', '2026-05-08 12:07:23'),
(79, 20, 3, 11, '2026-05-08 12:07:23', '2026-05-08 12:07:23'),
(80, 20, 4, 1, '2026-05-08 12:07:23', '2026-05-08 12:07:23'),
(81, 21, 1, 15, '2026-05-08 12:07:23', '2026-05-08 12:07:23'),
(82, 21, 2, 7, '2026-05-08 12:07:23', '2026-05-08 12:07:23'),
(83, 21, 3, 8, '2026-05-08 12:07:23', '2026-05-08 12:07:23'),
(84, 21, 4, 1, '2026-05-08 12:07:23', '2026-05-08 12:07:23'),
(85, 22, 1, 25, '2026-05-08 12:07:23', '2026-05-08 12:07:23'),
(86, 22, 2, 11, '2026-05-08 12:07:23', '2026-05-08 12:07:23'),
(87, 22, 3, 14, '2026-05-08 12:07:23', '2026-05-08 12:07:23'),
(88, 22, 4, 1, '2026-05-08 12:07:23', '2026-05-08 12:07:23'),
(89, 23, 1, 25, '2026-05-08 12:07:23', '2026-05-08 12:07:23'),
(90, 23, 2, 11, '2026-05-08 12:07:23', '2026-05-08 12:07:23'),
(91, 23, 3, 14, '2026-05-08 12:07:23', '2026-05-08 12:07:23'),
(92, 23, 4, 1, '2026-05-08 12:07:23', '2026-05-08 12:07:23'),
(93, 24, 1, 15, '2026-05-08 12:07:23', '2026-05-08 12:07:23'),
(94, 24, 2, 7, '2026-05-08 12:07:23', '2026-05-08 12:07:23'),
(95, 24, 3, 8, '2026-05-08 12:07:23', '2026-05-08 12:07:23'),
(96, 24, 4, 1, '2026-05-08 12:07:23', '2026-05-08 12:07:23'),
(97, 25, 1, 20, '2026-05-08 12:07:23', '2026-05-08 12:07:23'),
(98, 25, 2, 9, '2026-05-08 12:07:23', '2026-05-08 12:07:23'),
(99, 25, 3, 11, '2026-05-08 12:07:23', '2026-05-08 12:07:23'),
(100, 25, 4, 1, '2026-05-08 12:07:23', '2026-05-08 12:07:23'),
(101, 26, 1, 30, '2026-05-08 12:07:23', '2026-05-08 12:07:23'),
(102, 26, 2, 14, '2026-05-08 12:07:23', '2026-05-08 12:07:23'),
(103, 26, 3, 16, '2026-05-08 12:07:23', '2026-05-08 12:07:23'),
(104, 26, 4, 1, '2026-05-08 12:07:23', '2026-05-08 12:07:23'),
(105, 27, 1, 30, '2026-05-08 12:07:23', '2026-05-08 12:07:23'),
(106, 27, 2, 14, '2026-05-08 12:07:23', '2026-05-08 12:07:23'),
(107, 27, 3, 16, '2026-05-08 12:07:23', '2026-05-08 12:07:23'),
(108, 27, 4, 1, '2026-05-08 12:07:23', '2026-05-08 12:07:23'),
(109, 28, 1, 30, '2026-05-08 12:07:23', '2026-05-08 12:07:23'),
(110, 28, 2, 14, '2026-05-08 12:07:23', '2026-05-08 12:07:23'),
(111, 28, 3, 16, '2026-05-08 12:07:23', '2026-05-08 12:07:23'),
(112, 28, 4, 1, '2026-05-08 12:07:23', '2026-05-08 12:07:23'),
(113, 29, 1, 30, '2026-05-08 12:07:23', '2026-05-08 12:07:23'),
(114, 29, 2, 14, '2026-05-08 12:07:23', '2026-05-08 12:07:23'),
(115, 29, 3, 16, '2026-05-08 12:07:23', '2026-05-08 12:07:23'),
(116, 29, 4, 1, '2026-05-08 12:07:23', '2026-05-08 12:07:23'),
(117, 30, 1, 10, '2026-05-08 12:07:23', '2026-05-08 12:07:23'),
(118, 30, 2, 5, '2026-05-08 12:07:23', '2026-05-08 12:07:23'),
(119, 30, 3, 5, '2026-05-08 12:07:23', '2026-05-08 12:07:23'),
(120, 30, 4, 1, '2026-05-08 12:07:23', '2026-05-08 12:07:23');

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `code` varchar(255) NOT NULL,
  `hod_name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `name`, `description`, `code`, `hod_name`, `created_at`, `updated_at`) VALUES
(2, 'Management', NULL, 'MGMT', 'Dr. Peter Drucker', '2026-05-08 12:03:54', '2026-05-08 12:03:54'),
(3, 'Computer Science & Engineering', NULL, 'CSE', 'Dr. Alan Turing', '2026-05-08 12:04:45', '2026-05-08 12:04:45'),
(4, 'Commerce & Finance', NULL, 'COMM', 'Dr. Raghuram Rajan', '2026-05-08 12:04:45', '2026-05-08 12:04:45'),
(5, 'Arts & Humanities', NULL, 'ARTS', 'Dr. Amartya Sen', '2026-05-08 12:04:45', '2026-05-08 12:04:45'),
(6, 'Science & Research', NULL, 'SCI', 'Dr. C.V. Raman', '2026-05-08 12:04:45', '2026-05-08 12:04:45'),
(7, 'Engineering & Technology', NULL, 'ENGG', 'Dr. A.P.J. Abdul Kalam', '2026-05-08 12:04:45', '2026-05-08 12:04:45');

-- --------------------------------------------------------

--
-- Table structure for table `enrollments`
--

CREATE TABLE `enrollments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `student_id` varchar(255) DEFAULT NULL,
  `application_id` bigint(20) UNSIGNED NOT NULL,
  `enrolled_at` date NOT NULL,
  `fee` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `enrollments`
--

INSERT INTO `enrollments` (`id`, `student_id`, `application_id`, `enrolled_at`, `fee`, `created_at`, `updated_at`) VALUES
(1, 'CS101STU2026YQPS', 1, '2026-05-09', 15000.00, '2026-05-09 04:43:12', '2026-05-09 04:43:12');

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
-- Table structure for table `follow_ups`
--

CREATE TABLE `follow_ups` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `lead_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `scheduled_at` datetime NOT NULL,
  `priority` enum('low','medium','high') NOT NULL DEFAULT 'medium',
  `status` enum('scheduled','completed','cancelled','missed') NOT NULL DEFAULT 'scheduled',
  `system_notification` tinyint(1) NOT NULL DEFAULT 1,
  `email_notification` tinyint(1) NOT NULL DEFAULT 0,
  `note` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
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
-- Table structure for table `leads`
--

CREATE TABLE `leads` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `source` varchar(255) NOT NULL,
  `course_interested` bigint(20) UNSIGNED NOT NULL,
  `assigned_to` bigint(20) UNSIGNED DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'New',
  `lead_score` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `leads`
--

INSERT INTO `leads` (`id`, `name`, `email`, `phone`, `source`, `course_interested`, `assigned_to`, `status`, `lead_score`, `created_at`, `updated_at`) VALUES
(1, 'Abhi', 'abhi7596@gmai.com', '1234567890', 'Website', 1, NULL, 'New', 50, '2026-05-08 11:38:19', '2026-05-08 11:41:55'),
(2, 'Adhi', 'adhi2008@gmail.com', '1234567891', 'Walk in', 1, NULL, 'New', 60, '2026-05-08 11:38:19', '2026-05-08 11:41:55'),
(3, 'Akarsh', 'akarshb@gmail.com', '1234567892', 'Website', 1, 9, 'Converted', 100, '2026-05-08 11:38:19', '2026-05-09 04:24:13');

-- --------------------------------------------------------

--
-- Table structure for table `lead_communications`
--

CREATE TABLE `lead_communications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `lead_id` bigint(20) UNSIGNED NOT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `type` varchar(100) DEFAULT 'system',
  `message` text NOT NULL,
  `communicated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lead_communications`
--

INSERT INTO `lead_communications` (`id`, `lead_id`, `created_by`, `type`, `message`, `communicated_at`) VALUES
(1, 3, 9, 'Phone Call', 'Made a Call', '2026-05-09 04:24:34');

-- --------------------------------------------------------

--
-- Table structure for table `lms_student_records`
--

CREATE TABLE `lms_student_records` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `subject` varchar(255) NOT NULL,
  `grade` varchar(255) DEFAULT NULL,
  `attendance` int(11) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lms_student_records`
--

INSERT INTO `lms_student_records` (`id`, `user_id`, `subject`, `grade`, `attendance`, `status`, `created_at`, `updated_at`) VALUES
(1, 6, 'Introduction to Programming', 'A', 95, 'active', '2026-05-09 04:59:37', '2026-05-09 04:59:37'),
(2, 6, 'Data Structures', 'B+', 88, 'active', '2026-05-09 04:59:37', '2026-05-09 04:59:37'),
(3, 6, 'Discrete Mathematics', 'A+', 90, 'active', '2026-05-09 04:59:37', '2026-05-09 04:59:37');

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
(4, '2026_02_25_000001_create_courses_table', 1),
(5, '2026_02_25_000002_create_roles_table', 1),
(6, '2026_02_26_045152_create_leads_table', 1),
(7, '2026_02_26_045209_create_applications_table', 1),
(8, '2026_02_26_045225_create_enrollments_table', 1),
(9, '2026_02_26_045232_create_payments_table', 1),
(10, '2026_02_27_064106_add_extra_fields_to_courses_table', 1),
(11, '2026_02_27_095751_create_quota_categories_table', 1),
(12, '2026_02_27_095753_create_course_quotas_table', 1),
(13, '2026_02_27_095754_create_permissions_table', 1),
(14, '2026_02_27_095754_create_role_permission_table', 1),
(15, '2026_02_28_052656_create_reports_table', 1),
(16, '2026_02_28_064628_create_audit_logs_table', 1),
(17, '2026_03_03_042716_create_applications_table', 1),
(18, '2026_03_03_043736_create_student_documents_table', 1),
(19, '2026_03_03_044038_create_scholarships_table', 1),
(20, '2026_03_06_044133_add_fields_to_applications_table', 1),
(21, '2026_03_06_052512_add_personal_details_to_applications_table', 1),
(22, '2026_03_06_054334_add_applied_date_to_applications_table', 1),
(23, '2026_03_09_080424_add_merit_score_to_applications_table', 1),
(24, '2026_03_10_053135_add_admin_remarks_to_applications_table', 1),
(25, '2026_03_10_061931_add_transaction_id_to_payments_table', 1),
(26, '2026_03_11_100844_add_department_id_to_users_table', 1),
(27, '2026_03_11_101658_add_hod_name_to_departments_table', 1),
(28, '2026_03_11_102743_add_level_to_courses_table', 1),
(29, '2026_03_12_111533_add_last_login_at_to_users_table', 1),
(30, '2026_03_13_063355_add_status_and_score_to_leads_table', 1),
(31, '2026_03_16_230451_create_follow_ups_table', 1),
(32, '2026_03_30_000418_add_extra_fee_columns_to_courses_table', 1),
(33, '2026_03_30_040439_add_quota_category_id_to_applications_table', 1),
(34, '2026_03_30_041357_add_merit_threshold_to_quota_categories_table', 1),
(35, '2026_04_16_000000_create_lead_communications_table', 1),
(36, '2026_04_16_052657_add_student_id_to_enrollments_table', 1),
(37, '2026_04_17_041755_alter_type_in_lead_communications_table', 1),
(38, '2026_05_08_165839_add_is_active_to_users_table', 2),
(39, '2026_05_08_170656_rename_course_id_to_course_interested_in_leads_table', 3),
(40, '2026_05_08_175000_add_payment_type_to_payments_table', 4),
(41, '2026_05_09_102000_create_parent_student_table', 5),
(42, '2026_05_09_103000_create_lms_student_records_table', 6);

-- --------------------------------------------------------

--
-- Table structure for table `parent_student`
--

CREATE TABLE `parent_student` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `parent_id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `parent_student`
--

INSERT INTO `parent_student` (`id`, `parent_id`, `student_id`, `created_at`, `updated_at`) VALUES
(1, 13, 6, '2026-05-09 04:59:37', '2026-05-09 04:59:37');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `enrollment_id` bigint(20) UNSIGNED DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_mode` varchar(255) DEFAULT NULL,
  `payment_date` date DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `payment_type` varchar(255) DEFAULT NULL,
  `payment_method` varchar(255) DEFAULT NULL,
  `transaction_id` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `user_id`, `enrollment_id`, `amount`, `payment_mode`, `payment_date`, `type`, `status`, `payment_type`, `payment_method`, `transaction_id`, `created_at`, `updated_at`) VALUES
(1, 6, NULL, 500.00, NULL, NULL, NULL, 'success', 'application', NULL, 'pay_Smrqaev4XeMGqx', '2026-05-08 12:21:16', '2026-05-08 12:21:16'),
(2, 6, NULL, 15000.00, NULL, NULL, NULL, 'success', 'admission', NULL, 'pay_Sn8EclzQKoq85d', '2026-05-09 04:21:42', '2026-05-09 04:21:42');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `quota_categories`
--

CREATE TABLE `quota_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `percentage` decimal(5,2) NOT NULL,
  `merit_threshold` decimal(5,2) NOT NULL DEFAULT 60.00,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `quota_categories`
--

INSERT INTO `quota_categories` (`id`, `name`, `code`, `percentage`, `merit_threshold`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'General', 'GEN', 50.00, 60.00, 1, NULL, NULL),
(2, 'SC/ST', 'SCST', 22.50, 45.00, 1, NULL, NULL),
(3, 'OBC', 'OBC', 27.00, 55.00, 1, NULL, NULL),
(4, 'Sports', 'SP', 0.50, 40.00, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(255) NOT NULL,
  `department` varchar(255) DEFAULT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `generated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `display_name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `display_name`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'Administrator', NULL, NULL),
(2, 'accountant', 'Accountant', NULL, NULL),
(3, 'student', 'Student', NULL, NULL),
(4, 'counselor', 'Counselor', NULL, NULL),
(5, 'parent', 'Parent', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `role_permission`
--

CREATE TABLE `role_permission` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `scholarships`
--

CREATE TABLE `scholarships` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `min_percentage` decimal(5,2) NOT NULL,
  `discount_percentage` decimal(5,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Table structure for table `student_documents`
--

CREATE TABLE `student_documents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `application_id` bigint(20) UNSIGNED NOT NULL,
  `document_type` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `student_documents`
--

INSERT INTO `student_documents` (`id`, `user_id`, `application_id`, `document_type`, `file_path`, `status`, `created_at`, `updated_at`) VALUES
(1, 6, 1, '10th', 'documents/6/1778242925_z2WdehBdKr.pdf', 'verified', '2026-05-08 12:22:06', '2026-05-08 12:30:19'),
(2, 6, 1, '12th', 'documents/6/1778242935_yugTkODOL3.pdf', 'verified', '2026-05-08 12:22:15', '2026-05-08 12:30:16'),
(3, 6, 1, 'tc', 'documents/6/1778242943_fyqfn1omKi.jpeg', 'verified', '2026-05-08 12:22:23', '2026-05-08 12:29:58'),
(4, 6, 1, 'id', 'documents/6/1778242959_GA4XhXYZLR.pdf', 'verified', '2026-05-08 12:22:39', '2026-05-08 12:30:04'),
(5, 6, 1, 'photo', 'documents/6/1778242973_B5HNr6yaNp.jpeg', 'verified', '2026-05-08 12:22:53', '2026-05-08 12:30:08'),
(6, 6, 1, 'income', 'documents/6/1778242981_0QZnIPJz4y.jpeg', 'verified', '2026-05-08 12:23:01', '2026-05-08 12:30:12');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `last_login_at` timestamp NULL DEFAULT NULL,
  `role_id` bigint(20) UNSIGNED DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `department_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `is_active`, `last_login_at`, `role_id`, `remember_token`, `created_at`, `updated_at`, `department_id`) VALUES
(1, 'System Admin', 'admin@eduadmit.pro', NULL, '$2y$12$IWClFtjwlZCNvWPGdy0vNu1IgXAZHZo3gniegLYEwd/OI5IusNqrG', 1, '2026-05-09 04:36:21', 1, NULL, '2026-05-08 11:20:47', '2026-05-09 04:36:21', NULL),
(6, 'Akarsh', 'akarshb@gmail.com', NULL, '$2y$12$/Xqx4Z7ZvnO3t/Jx81Th9uu2htbGntcIbjmDau8fMAwms3pXlK9wy', 1, '2026-05-09 04:35:18', 3, NULL, '2026-05-08 11:26:20', '2026-05-09 04:35:18', NULL),
(7, 'Abhi', 'abhi7596@gmai.com', NULL, '$2y$12$zFB4/CG2Eu.zgkde8xSoG.ED/bi1a5TmU54uFwUAlcZmB1JxBnule', 1, '2026-05-09 04:22:33', 3, NULL, '2026-05-08 11:26:20', '2026-05-09 04:22:33', NULL),
(9, 'Sarah', 'sarah@university.edu', NULL, '$2y$12$8vDfhkrkYrmPCO1qJm15.eqixtWcpVuMV30i71RdGxkt6Z8IbYdNG', 1, '2026-05-09 04:30:41', 4, NULL, '2026-05-08 11:26:21', '2026-05-09 04:30:41', NULL),
(10, 'Priya', 'priya123@gmail.com', NULL, '$2y$12$Pi4zPS3ThyMxW6PrQzGnuujZLkUsIIXJK6gNAvN2.vRShl06z5Xcq', 1, NULL, 4, NULL, '2026-05-08 11:26:21', '2026-05-08 11:26:21', NULL),
(11, 'Accountant', 'accountant@eduadmit.com', NULL, '$2y$12$oilV.ZEmfwkLSiZuTiAIC.kExtMZGiEk80fYLbA/WvPOdiYwWQJQi', 1, '2026-05-08 11:36:11', 2, NULL, '2026-05-08 11:26:21', '2026-05-08 11:36:11', NULL),
(12, 'Adhi', 'adhi2008@gmail.com', NULL, '$2y$12$r8pKBSpzaqqqjE/EZ3dnSO4CD811P4Dr9LzZNlQq7MzD37FAQkqv6', 1, '2026-05-08 12:02:33', 3, NULL, '2026-05-08 11:31:20', '2026-05-08 12:02:33', NULL),
(13, 'John Doe Sr.', 'parent@example.com', NULL, '$2y$12$Dqjo30Es4nqCR8KOzdXO0ez8IGTVa1M.jHu8bj8whjHxu1KdbFjl2', 1, NULL, 5, NULL, '2026-05-09 04:53:09', '2026-05-09 04:53:09', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `applications`
--
ALTER TABLE `applications`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `applications_application_no_unique` (`application_no`),
  ADD KEY `applications_user_id_foreign` (`user_id`),
  ADD KEY `applications_lead_id_foreign` (`lead_id`),
  ADD KEY `applications_course_id_foreign` (`course_id`),
  ADD KEY `applications_quota_category_id_foreign` (`quota_category_id`);

--
-- Indexes for table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `audit_logs_user_id_foreign` (`user_id`);

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
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `courses_code_unique` (`code`),
  ADD KEY `courses_department_id_foreign` (`department_id`);

--
-- Indexes for table `course_quotas`
--
ALTER TABLE `course_quotas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_quotas_course_id_foreign` (`course_id`),
  ADD KEY `course_quotas_quota_category_id_foreign` (`quota_category_id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `departments_code_unique` (`code`);

--
-- Indexes for table `enrollments`
--
ALTER TABLE `enrollments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `enrollments_student_id_unique` (`student_id`),
  ADD KEY `enrollments_application_id_foreign` (`application_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `follow_ups`
--
ALTER TABLE `follow_ups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `follow_ups_lead_id_foreign` (`lead_id`),
  ADD KEY `follow_ups_user_id_foreign` (`user_id`);

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
-- Indexes for table `leads`
--
ALTER TABLE `leads`
  ADD PRIMARY KEY (`id`),
  ADD KEY `leads_course_id_foreign` (`course_interested`),
  ADD KEY `leads_assigned_to_foreign` (`assigned_to`);

--
-- Indexes for table `lead_communications`
--
ALTER TABLE `lead_communications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lead_communications_lead_id_foreign` (`lead_id`),
  ADD KEY `lead_communications_created_by_foreign` (`created_by`);

--
-- Indexes for table `lms_student_records`
--
ALTER TABLE `lms_student_records`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lms_student_records_user_id_foreign` (`user_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `parent_student`
--
ALTER TABLE `parent_student`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parent_student_parent_id_foreign` (`parent_id`),
  ADD KEY `parent_student_student_id_foreign` (`student_id`);

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
  ADD KEY `payments_user_id_foreign` (`user_id`),
  ADD KEY `payments_enrollment_id_foreign` (`enrollment_id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_code_unique` (`code`);

--
-- Indexes for table `quota_categories`
--
ALTER TABLE `quota_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `quota_categories_code_unique` (`code`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reports_generated_by_foreign` (`generated_by`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_unique` (`name`);

--
-- Indexes for table `role_permission`
--
ALTER TABLE `role_permission`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role_permission_role_id_foreign` (`role_id`),
  ADD KEY `role_permission_permission_id_foreign` (`permission_id`);

--
-- Indexes for table `scholarships`
--
ALTER TABLE `scholarships`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `student_documents`
--
ALTER TABLE `student_documents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_documents_user_id_foreign` (`user_id`),
  ADD KEY `student_documents_application_id_foreign` (`application_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_department_id_foreign` (`department_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `applications`
--
ALTER TABLE `applications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `audit_logs`
--
ALTER TABLE `audit_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `course_quotas`
--
ALTER TABLE `course_quotas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=121;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `enrollments`
--
ALTER TABLE `enrollments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `follow_ups`
--
ALTER TABLE `follow_ups`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `leads`
--
ALTER TABLE `leads`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `lead_communications`
--
ALTER TABLE `lead_communications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `lms_student_records`
--
ALTER TABLE `lms_student_records`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `parent_student`
--
ALTER TABLE `parent_student`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `quota_categories`
--
ALTER TABLE `quota_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `role_permission`
--
ALTER TABLE `role_permission`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `scholarships`
--
ALTER TABLE `scholarships`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `student_documents`
--
ALTER TABLE `student_documents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `applications`
--
ALTER TABLE `applications`
  ADD CONSTRAINT `applications_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`),
  ADD CONSTRAINT `applications_lead_id_foreign` FOREIGN KEY (`lead_id`) REFERENCES `leads` (`id`),
  ADD CONSTRAINT `applications_quota_category_id_foreign` FOREIGN KEY (`quota_category_id`) REFERENCES `quota_categories` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `applications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD CONSTRAINT `audit_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `courses_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `course_quotas`
--
ALTER TABLE `course_quotas`
  ADD CONSTRAINT `course_quotas_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `course_quotas_quota_category_id_foreign` FOREIGN KEY (`quota_category_id`) REFERENCES `quota_categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `enrollments`
--
ALTER TABLE `enrollments`
  ADD CONSTRAINT `enrollments_application_id_foreign` FOREIGN KEY (`application_id`) REFERENCES `applications` (`id`);

--
-- Constraints for table `follow_ups`
--
ALTER TABLE `follow_ups`
  ADD CONSTRAINT `follow_ups_lead_id_foreign` FOREIGN KEY (`lead_id`) REFERENCES `leads` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `follow_ups_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `leads`
--
ALTER TABLE `leads`
  ADD CONSTRAINT `leads_assigned_to_foreign` FOREIGN KEY (`assigned_to`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `leads_course_id_foreign` FOREIGN KEY (`course_interested`) REFERENCES `courses` (`id`);

--
-- Constraints for table `lead_communications`
--
ALTER TABLE `lead_communications`
  ADD CONSTRAINT `lead_communications_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `lead_communications_lead_id_foreign` FOREIGN KEY (`lead_id`) REFERENCES `leads` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `lms_student_records`
--
ALTER TABLE `lms_student_records`
  ADD CONSTRAINT `lms_student_records_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `parent_student`
--
ALTER TABLE `parent_student`
  ADD CONSTRAINT `parent_student_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `parent_student_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_enrollment_id_foreign` FOREIGN KEY (`enrollment_id`) REFERENCES `enrollments` (`id`),
  ADD CONSTRAINT `payments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reports`
--
ALTER TABLE `reports`
  ADD CONSTRAINT `reports_generated_by_foreign` FOREIGN KEY (`generated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `role_permission`
--
ALTER TABLE `role_permission`
  ADD CONSTRAINT `role_permission_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_permission_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `student_documents`
--
ALTER TABLE `student_documents`
  ADD CONSTRAINT `student_documents_application_id_foreign` FOREIGN KEY (`application_id`) REFERENCES `applications` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `student_documents_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
