-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 01, 2024 at 03:04 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `coop`
--

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `middle_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `citizenship` varchar(255) DEFAULT NULL,
  `civil_status` varchar(255) DEFAULT NULL,
  `spouse_name` varchar(255) DEFAULT NULL,
  `provincial_address` varchar(255) DEFAULT NULL,
  `city_address` varchar(255) DEFAULT NULL,
  `mailing_address` varchar(255) DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `birth_place` varchar(255) DEFAULT NULL,
  `phone_number` bigint(20) DEFAULT NULL,
  `tax_id_number` varchar(255) NOT NULL,
  `date_employed` date DEFAULT NULL,
  `position` varchar(255) DEFAULT NULL,
  `nature_of_work` varchar(255) DEFAULT NULL,
  `account_status` varchar(255) DEFAULT NULL,
  `amount_of_share` decimal(15,2) DEFAULT NULL,
  `balance` decimal(15,2) UNSIGNED NOT NULL DEFAULT 0.00,
  `remarks` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`id`, `first_name`, `middle_name`, `last_name`, `citizenship`, `civil_status`, `spouse_name`, `provincial_address`, `city_address`, `mailing_address`, `birth_date`, `birth_place`, `phone_number`, `tax_id_number`, `date_employed`, `position`, `nature_of_work`, `account_status`, `amount_of_share`, `balance`, `remarks`, `created_at`, `updated_at`, `deleted_at`, `user_id`) VALUES
(1, 'test', 'test', 'tester', 'Filipino', 'Single', 'None', 'Cabanatuan', 'Cabanatuan', 'Cabanatuan City', '2024-02-27', 'Cabanatuan city', 9991231231, '123-123-123-12', '2024-02-12', 'IT', 'Teaching', 'Non-Active', 8857.81, 18456.52, 'unpaid', '2024-02-19 04:36:12', '2024-03-01 05:21:33', NULL, 5),
(2, 'asddw', 'dasd', 'gobas', 'Cabanatuan city', 'Single', 'None', 'Nueva Ecija', 'Cabanatuan', 'Cabanatuan City', '2024-02-26', 'Cabanatuan City', 9991231231, '123-123-123-12', '2024-02-26', 'tester', 'Teaching', 'Active', 20000.00, 0.00, NULL, '2024-02-26 04:42:43', '2024-02-26 04:42:43', NULL, 6),
(3, 'sDAsdas', 'dasdsa', 'kcirederf', 'Filipino', 'Single', 'None', 'dw', 'dads', 'Cabanatuan City', '2024-02-26', 'Cabanatuan City', 9995656038, '123-123-123-12', '2024-02-26', 'IT', 'Teaching', 'Active', 20000.00, 0.00, NULL, '2024-02-26 05:39:24', '2024-02-26 05:39:24', NULL, 7),
(4, 'nhoj', 'dd', 'testdds', 'Filipino', 'Single', 'None', 'Cabanatuan', 'asdsada', 'Cabanatuan City', '2024-02-26', 'Cabanatuan city', 9991231231, '123-123-123-12', '2024-02-26', 'dasdas', 'Teaching', 'Active', 20000.00, 0.00, NULL, '2024-02-26 05:41:05', '2024-02-26 05:41:05', NULL, 8),
(5, 'ewqew', 'eqwewq', 'asdasd', 'qweqwe', 'Single', 'None', 'eewee', 'ewqewq', 'Cabanatuan City', '2024-02-26', 'dasdasd', 9991231231, '123-123-123-12', '2024-02-26', 'wqeqwew', 'Teaching', 'Active', 20000.00, 0.00, NULL, '2024-02-26 05:43:10', '2024-02-26 05:43:10', NULL, 9),
(6, 'Justine', 'Dagatan', 'Retiro', 'qweqwe', 'Single', 'None', 'eewee', 'Cabanatuan City', 'Cabanatuan City', '2024-03-04', 'dasdasd', 9991231231, '123-123-123-12', '2024-02-26', 'wqeqwew', 'Teaching', 'Active', 20000.00, 0.00, NULL, '2024-03-04 00:02:54', '2024-03-04 00:02:54', NULL, 10),
(7, 'ewqew', 'eqwewq', 'asdasd', 'qweqwe', 'Single', 'None', 'eewee', 'ewqewq', 'Cabanatuan City', '2024-02-26', 'dasdasd', 9991231231, '123-123-123-12', '2024-02-26', 'wqeqwew', 'Teaching', 'Active', 20000.00, 0.00, NULL, '2024-03-04 01:38:47', '2024-03-04 01:38:47', NULL, 11);

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
-- Table structure for table `loan_applications`
--

CREATE TABLE `loan_applications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `loan_reference` int(11) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `age` int(11) NOT NULL,
  `birth_date` date DEFAULT NULL,
  `date_employed` varchar(255) DEFAULT NULL,
  `contact_num` bigint(20) DEFAULT NULL,
  `college` varchar(255) DEFAULT NULL,
  `taxid_num` varchar(255) NOT NULL,
  `loan_type` varchar(255) DEFAULT NULL,
  `work_position` varchar(255) DEFAULT NULL,
  `retirement_year` int(11) NOT NULL,
  `application_date` date NOT NULL,
  `time_pay` int(11) NOT NULL,
  `application_status` varchar(255) NOT NULL,
  `financed_amount` decimal(15,2) NOT NULL,
  `monthly_pay` decimal(8,2) NOT NULL,
  `finance_charge` decimal(15,2) DEFAULT NULL,
  `balance` decimal(15,2) DEFAULT NULL,
  `note` longtext DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `remarks` varchar(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `account_number_id` bigint(20) UNSIGNED DEFAULT NULL,
  `client_id` bigint(20) UNSIGNED DEFAULT NULL,
  `take_action_by_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `loan_applications`
--

INSERT INTO `loan_applications` (`id`, `loan_reference`, `customer_name`, `age`, `birth_date`, `date_employed`, `contact_num`, `college`, `taxid_num`, `loan_type`, `work_position`, `retirement_year`, `application_date`, `time_pay`, `application_status`, `financed_amount`, `monthly_pay`, `finance_charge`, `balance`, `note`, `due_date`, `remarks`, `created_at`, `updated_at`, `deleted_at`, `account_number_id`, `client_id`, `take_action_by_id`) VALUES
(1, 44188540, 'test', 25, '2024-02-12', '2024-02-12', 9991231231, 'IT', '123-123-123-12', 'Regular', NULL, 2512, '2024-02-20', 12, 'pending', 8425.00, 0.00, 8509.25, NULL, NULL, NULL, '', '2024-02-19 22:04:16', '2024-02-19 22:04:16', NULL, 5, NULL, NULL),
(2, 41910790, 'test', 25, '2024-02-12', '2024-02-12', 9991231231, 'IT', '123-123-123-12', 'Regular', NULL, 2512, '2024-02-20', 12, 'pending', 8425.00, 0.00, 8509.25, NULL, NULL, NULL, '', '2024-02-19 22:06:16', '2024-02-19 22:06:16', NULL, 5, NULL, NULL),
(3, 49883986, 'test', 25, '2024-02-12', '2024-02-12', 9991231231, 'IT', '123-123-123-12', 'Regular', NULL, 2512, '2024-02-20', 12, 'pending', 8425.00, 0.00, 8509.25, NULL, NULL, NULL, '', '2024-02-19 22:12:58', '2024-02-19 22:12:58', NULL, 5, NULL, NULL),
(4, 46465191, 'test', 25, '2024-02-12', '2024-02-12', 9991231231, 'IT', '123-123-123-12', 'Regular', 'IT', 2512, '2024-02-21', 12, 'pending', 10000.00, 0.00, 10100.00, NULL, NULL, NULL, NULL, '2024-02-20 21:16:40', '2024-02-20 21:16:40', NULL, 5, NULL, NULL),
(5, 45674250, 'test', 25, '2024-02-12', '2024-02-12', 9991231231, 'IT', '123-123-123-12', 'Regular', 'IT', 2512, '2024-02-21', 12, 'approved', 10000.00, 0.00, 10100.00, NULL, NULL, NULL, NULL, '2024-02-20 21:17:44', '2024-02-21 04:43:35', NULL, 5, 1, NULL),
(6, 47915969, 'test', 25, '2024-02-12', '2024-02-12', 9991231231, 'IT', '123-123-123-12', 'Regular', 'IT', 2512, '2024-02-21', 12, 'approved', 10000.00, 0.00, 10100.00, NULL, NULL, NULL, NULL, '2024-02-20 21:18:15', '2024-02-21 04:35:26', NULL, 5, 1, NULL),
(7, 47792173, 'test', 25, '2024-02-12', '2024-02-12', 9991231231, 'IT', '123-123-123-12', 'Regular', 'IT', 2512, '2024-02-21', 12, 'approved', 10000.00, 0.00, 10100.00, NULL, NULL, NULL, NULL, '2024-02-20 21:20:21', '2024-02-21 03:00:18', NULL, 5, 1, NULL),
(8, 42970472, 'test', 25, '2024-02-12', '2024-02-12', 9991231231, 'IT', '123-123-123-12', 'Regular', 'IT', 2512, '2024-02-21', 12, 'approved', 8425.00, 0.00, 8509.25, 0.00, NULL, NULL, 'Paid', '2024-02-20 21:52:01', '2024-02-27 06:49:06', NULL, 5, 1, NULL),
(9, 46118218, 'test', 25, '2024-02-12', '2024-02-12', 9991231231, 'IT', '123-123-123-12', 'Regular', 'IT', 2512, '2024-02-21', 12, 'rejected', 1231.00, 0.00, 1243.31, NULL, NULL, NULL, NULL, '2024-02-21 03:32:58', '2024-02-21 03:55:33', NULL, 5, 1, NULL),
(10, 49637373, 'test', 25, '2024-02-12', '2024-02-12', 9991231231, 'ITS', '123-123-123-12', 'Regular', 'IT', 2512, '2024-02-21', 12, 'rejected', 8425.00, 0.00, 8509.25, NULL, NULL, NULL, NULL, '2024-02-21 04:50:22', '2024-02-21 05:26:47', NULL, 5, 1, NULL),
(11, 44350890, 'test', 25, '2024-02-12', '2024-02-12', 9991231231, 'They', '123-123-123-12', 'Regular', 'IT', 2512, '2024-02-21', 12, 'approved', 8425.00, 0.00, 8509.25, 0.00, NULL, NULL, 'Paid', '2024-02-21 05:01:56', '2024-02-24 21:00:18', NULL, 5, 1, NULL),
(12, 41956816, 'test', 24, '2024-02-12', '2024-02-12', 9991231231, 'IT', '123-123-123-12', 'Regular', 'IT', 2025, '2024-02-23', 15, 'rejected', 10000.00, 0.00, 10125.00, NULL, NULL, NULL, NULL, '2024-02-23 04:01:25', '2024-03-01 05:19:20', NULL, 5, 1, NULL),
(13, 46105678, 'test', 25, '2024-02-12', '2024-02-12', 9991231231, 'IT', '123-123-123-12', 'Regular', 'IT', 2025, '2024-02-24', 25, 'approved', 10000.00, 0.00, 10208.33, NULL, NULL, NULL, NULL, '2024-02-23 21:24:00', '2024-02-23 23:40:16', NULL, 5, 1, NULL),
(14, 46781142, 'test', 25, '2024-02-12', '2024-02-12', 9991231231, 'IT', '123-123-123-12', 'Regular', 'IT', 2025, '2024-02-24', 12, 'approved', 8000.00, 0.00, 8080.00, 0.00, NULL, NULL, 'Paid', '2024-02-24 00:12:16', '2024-02-24 21:01:38', NULL, 5, 1, NULL),
(15, 42046914, 'test', 23, '2024-02-12', '2024-02-12', 9991231231, 'IT', '123-123-123-12', 'Regular', 'IT', 2025, '2024-02-24', 23, 'approved', 10000.00, 0.00, 10191.67, 0.00, NULL, NULL, 'Paid', '2024-02-24 04:20:12', '2024-02-25 02:19:35', NULL, 5, 1, NULL),
(16, 49000190, 'test', 25, '2024-02-12', '2024-02-12', 9991231231, NULL, '123-123-123-12', 'Regular', 'IT', 2025, '2024-02-25', 12, 'pending', 10000.00, 0.00, 11200.00, NULL, NULL, NULL, NULL, '2024-02-25 05:41:37', '2024-02-25 05:41:37', NULL, 5, 1, NULL),
(17, 47705249, 'test', 25, '2024-02-12', '2024-02-12', 9991231231, NULL, '123-123-123-12', 'Regular', 'IT', 2025, '2024-02-25', 12, 'pending', 10000.00, 0.00, 11200.00, NULL, NULL, NULL, NULL, '2024-02-25 05:41:47', '2024-02-25 05:41:47', NULL, 5, 1, NULL),
(18, 43682448, 'test', 25, '2024-02-12', '2024-02-12', 9991231231, NULL, '123-123-123-12', 'Regular', 'IT', 2025, '2024-02-25', 12, 'pending', 10000.00, 0.00, 11200.00, NULL, NULL, NULL, NULL, '2024-02-25 05:42:24', '2024-02-25 05:42:24', NULL, 5, 1, NULL),
(19, 43903629, 'test', 25, '2024-02-12', '2024-02-12', 9991231231, NULL, '123-123-123-12', 'Regular', 'IT', 2025, '2024-02-25', 12, 'rejected', 10000.00, 0.00, 11200.00, NULL, NULL, NULL, NULL, '2024-02-25 05:45:12', '2024-02-29 06:02:33', NULL, 5, 1, NULL),
(20, 48612702, 'test', 25, '2024-02-12', '2024-02-12', 9991231231, 'IT', '123-123-123-12', 'Regular', 'IT', 2025, '2024-02-25', 12, 'rejected', 10000.00, 0.00, 9500.00, NULL, NULL, NULL, NULL, '2024-02-25 06:27:34', '2024-02-29 06:05:35', NULL, 5, 1, NULL),
(21, 41632791, 'test', 25, '2024-02-12', '2024-02-12', 9991231231, 'IT', '123-123-123-12', 'Regular', 'IT', 2025, '2024-02-25', 12, 'approved', 11000.00, 980.83, 10450.00, 0.00, NULL, NULL, 'Paid', '2024-02-25 07:12:12', '2024-02-27 06:53:16', NULL, 5, 1, NULL),
(22, 41587639, 'test', 25, '2024-02-12', '2024-02-12', 9991231231, 'IT', '123-123-123-12', 'Regular', 'IT', 2512, '2024-02-26', 12, 'approved', 12100.00, 1078.92, 11495.00, 0.00, NULL, NULL, 'Paid', '2024-02-25 22:20:00', '2024-02-27 21:48:30', NULL, 5, 1, NULL),
(23, 44343533, 'test', 23, '2024-02-27', '2024-02-12', 9991231231, 'dasd', '123-123-123-12', 'Regular', 'IT', 2025, '2024-02-27', 12, 'approved', 13310.00, 1186.81, 12644.50, 3150.02, NULL, NULL, 'Unpaid', '2024-02-27 05:38:00', '2024-02-29 06:44:15', NULL, 5, 1, NULL),
(24, 46484404, 'test', 25, '2024-02-27', '2024-02-12', 9991231231, 'IT', '123-123-123-12', 'Providential', 'IT', 2025, '2024-02-29', 12, 'approved', 14641.00, 1305.49, 13908.95, 13908.95, 'kasama', NULL, 'unpaid', '2024-02-29 13:51:48', '2024-02-29 06:04:55', NULL, 5, 1, NULL),
(25, 49230817, 'test', 25, '2024-02-27', '2024-02-12', 9991231231, 'IT', '123-123-123-12', 'Providential', 'IT', 2025, '2024-03-01', 12, 'rejected', 16105.10, 1436.04, 15299.85, NULL, NULL, NULL, NULL, '2024-03-01 13:21:33', '2024-03-01 05:24:22', NULL, 5, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `loan_application_approvals`
--

CREATE TABLE `loan_application_approvals` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `loan_id` bigint(20) UNSIGNED NOT NULL,
  `book_keeper` smallint(6) NOT NULL,
  `general_manager` smallint(6) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `loan_application_approvals`
--

INSERT INTO `loan_application_approvals` (`id`, `loan_id`, `book_keeper`, `general_manager`, `created_at`, `updated_at`) VALUES
(1, 5, 1, 1, '2024-02-20 21:17:44', '2024-02-21 04:49:55'),
(2, 6, 1, 1, '2024-02-20 21:18:16', '2024-02-21 04:42:24'),
(3, 7, 0, 0, '2024-02-20 21:20:21', '2024-02-20 21:20:21'),
(4, 8, 1, 1, '2024-02-20 21:52:01', '2024-02-26 00:09:45'),
(5, 9, 1, 1, '2024-02-21 03:32:58', '2024-02-21 04:32:52'),
(6, 10, 1, 1, '2024-02-21 04:50:22', '2024-02-21 05:26:47'),
(7, 11, 1, 1, '2024-02-21 05:01:56', '2024-02-21 05:12:30'),
(8, 12, 1, 0, '2024-02-23 04:01:25', '2024-03-01 05:19:20'),
(9, 13, 1, 1, '2024-02-23 21:24:00', '2024-02-23 23:40:16'),
(10, 14, 1, 1, '2024-02-24 00:12:16', '2024-02-24 00:15:27'),
(11, 15, 1, 1, '2024-02-24 04:20:12', '2024-02-24 07:20:14'),
(12, 19, 1, 0, '2024-02-25 05:45:12', '2024-02-29 06:02:33'),
(13, 20, 1, 1, '2024-02-25 06:27:34', '2024-02-29 06:05:35'),
(14, 21, 1, 1, '2024-02-25 07:12:12', '2024-02-26 02:46:31'),
(15, 22, 1, 1, '2024-02-25 22:20:00', '2024-02-25 22:21:53'),
(16, 23, 1, 1, '2024-02-27 05:38:00', '2024-02-27 22:13:17'),
(17, 24, 1, 1, '2024-02-29 05:51:48', '2024-02-29 06:04:55'),
(18, 25, 1, 0, '2024-03-01 05:21:33', '2024-03-01 05:24:22');

-- --------------------------------------------------------

--
-- Table structure for table `loan_application_payment`
--

CREATE TABLE `loan_application_payment` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `payment_id` bigint(20) UNSIGNED NOT NULL,
  `loan_application_id` bigint(20) UNSIGNED NOT NULL,
  `remarks` varchar(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `loan_application_payment`
--

INSERT INTO `loan_application_payment` (`id`, `payment_id`, `loan_application_id`, `remarks`, `created_at`, `updated_at`) VALUES
(1, 11, 15, '5', '2024-02-24 19:28:28', '2024-02-24 19:28:28'),
(2, 12, 15, '5', '2024-02-24 19:29:27', '2024-02-24 19:29:27'),
(4, 15, 15, '5', '2024-02-24 19:35:52', '2024-02-24 19:35:52'),
(5, 16, 15, '5', '2024-02-24 19:37:06', '2024-02-24 19:37:06'),
(6, 17, 15, '5', '2024-02-24 19:37:44', '2024-02-24 19:37:44'),
(7, 18, 15, '5', '2024-02-24 19:46:21', '2024-02-24 19:46:21'),
(8, 19, 15, '5', '2024-02-24 19:47:32', '2024-02-24 19:47:32'),
(9, 20, 15, '5', '2024-02-24 19:47:45', '2024-02-24 19:47:45'),
(10, 21, 15, '5', '2024-02-24 20:33:39', '2024-02-24 20:33:39'),
(11, 22, 15, 'Paid', '2024-02-24 20:58:02', '2024-02-24 20:58:02'),
(12, 23, 11, 'Paid', '2024-02-24 21:00:18', '2024-02-24 21:00:18'),
(13, 24, 14, 'Paid', '2024-02-24 21:01:38', '2024-02-24 21:01:38'),
(14, 25, 15, 'Paid', '2024-02-24 21:03:24', '2024-02-24 21:03:24'),
(15, 26, 15, 'Paid', '2024-02-24 21:23:03', '2024-02-24 21:23:03'),
(16, 27, 15, 'Fully Paid', '2024-02-24 23:43:08', '2024-02-24 23:43:08'),
(17, 28, 15, 'Fully Paid', '2024-02-25 01:35:22', '2024-02-25 01:35:22'),
(18, 29, 15, 'Fully Paid', '2024-02-25 01:36:17', '2024-02-25 01:36:17'),
(19, 30, 15, 'Fully Paid', '2024-02-25 01:37:26', '2024-02-25 01:37:26'),
(20, 31, 15, 'Fully Paid', '2024-02-25 01:42:33', '2024-02-25 01:42:33'),
(21, 32, 15, 'Fully Paid', '2024-02-25 01:47:06', '2024-02-25 01:47:06'),
(22, 33, 15, 'Fully Paid', '2024-02-25 01:51:58', '2024-02-25 01:51:58'),
(23, 34, 15, 'Fully Paid', '2024-02-25 01:54:06', '2024-02-25 01:54:06'),
(24, 35, 15, 'Fully Paid', '2024-02-25 02:01:31', '2024-02-25 02:01:31'),
(25, 36, 15, 'Fully Paid', '2024-02-25 02:02:57', '2024-02-25 02:02:57'),
(26, 37, 15, 'Fully Paid', '2024-02-25 02:05:55', '2024-02-25 02:05:55'),
(27, 38, 15, 'Fully Paid', '2024-02-25 02:07:10', '2024-02-25 02:07:10'),
(28, 39, 15, 'Fully Paid', '2024-02-25 02:12:54', '2024-02-25 02:12:54'),
(29, 40, 15, 'Fully Paid', '2024-02-25 02:14:44', '2024-02-25 02:14:44'),
(30, 41, 15, 'Fully Paid', '2024-02-25 02:15:36', '2024-02-25 02:15:36'),
(31, 42, 15, 'Fully Paid', '2024-02-25 02:19:35', '2024-02-25 02:19:35'),
(32, 43, 21, 'Paid Partially', '2024-02-26 02:47:12', '2024-02-26 02:47:12'),
(33, 44, 8, 'Fully Paid', '2024-02-27 06:49:06', '2024-02-27 06:49:06'),
(34, 45, 21, 'Paid Partially', '2024-02-27 06:51:33', '2024-02-27 06:51:33'),
(35, 46, 21, 'Fully Paid', '2024-02-27 06:53:16', '2024-02-27 06:53:16'),
(36, 47, 22, 'Fully Paid', '2024-02-27 06:55:42', '2024-02-27 06:55:42'),
(37, 48, 22, 'Fully Paid', '2024-02-27 06:57:06', '2024-02-27 06:57:06'),
(38, 49, 22, 'Fully Paid', '2024-02-27 06:57:23', '2024-02-27 06:57:23'),
(39, 50, 22, 'Fully Paid', '2024-02-27 21:48:30', '2024-02-27 21:48:30'),
(40, 51, 23, 'Paid Partially', '2024-02-29 06:25:30', '2024-02-29 06:25:30'),
(41, 52, 23, 'Paid Partially', '2024-02-29 06:35:21', '2024-02-29 06:35:21'),
(42, 53, 23, 'Paid Partially', '2024-02-29 06:37:01', '2024-02-29 06:37:01'),
(43, 54, 23, 'Paid Partially', '2024-02-29 06:37:34', '2024-02-29 06:37:34'),
(44, 55, 23, 'Paid Partially', '2024-02-29 06:40:49', '2024-02-29 06:40:49'),
(45, 56, 23, 'Paid Partially', '2024-02-29 06:41:59', '2024-02-29 06:41:59'),
(46, 57, 23, 'Paid Partially', '2024-02-29 06:43:01', '2024-02-29 06:43:01'),
(47, 58, 23, 'Paid Partially', '2024-02-29 06:44:15', '2024-02-29 06:44:15');

-- --------------------------------------------------------

--
-- Table structure for table `media`
--

CREATE TABLE `media` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `signature` varchar(255) NOT NULL,
  `take_home_pay` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `loan_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `media`
--

INSERT INTO `media` (`id`, `signature`, `take_home_pay`, `created_at`, `updated_at`, `loan_id`) VALUES
(1, 'public/signatures/test-41910790-2024_02_20_06_06_16/1708409176_GetCloudyConsultingLogo.png', 'public/homepay_receipts/test-41910790-2024_02_20_06_06_16/1708409176_GetCloudyConsultingLogo.png', '2024-02-19 22:06:16', '2024-02-19 22:06:16', 2),
(2, 'public/signatures/test-49883986-2024_02_20_06_12_58/1708409578_GetCloudyConsultingLogo.png', 'public/homepay_receipts/test-49883986-2024_02_20_06_12_58/1708409578_GetCloudyConsultingLogo.png', '2024-02-19 22:12:58', '2024-02-19 22:12:58', 3),
(3, 'public/signatures/test-46465191-2024_02_21_05_16_40/1708492600_423221208_701012102225381_2068126842416215255_n.png', 'public/homepay_receipts/test-46465191-2024_02_21_05_16_40/1708492600_423221208_701012102225381_2068126842416215255_n.png', '2024-02-20 21:16:40', '2024-02-20 21:16:40', 4),
(4, 'public/signatures/test-45674250-2024_02_21_05_17_44/1708492664_423221208_701012102225381_2068126842416215255_n.png', 'public/homepay_receipts/test-45674250-2024_02_21_05_17_44/1708492664_423221208_701012102225381_2068126842416215255_n.png', '2024-02-20 21:17:44', '2024-02-20 21:17:44', 5),
(5, 'public/signatures/test-47915969-2024_02_21_05_18_15/1708492695_Slide 16_9 - 3.png', 'public/homepay_receipts/test-47915969-2024_02_21_05_18_15/1708492695_Slide 16_9 - 3.png', '2024-02-20 21:18:15', '2024-02-20 21:18:15', 6),
(6, 'public/signatures/test-47792173-2024_02_21_05_20_21/1708492821_Slide 16_9 - 2.png', 'public/homepay_receipts/test-47792173-2024_02_21_05_20_21/1708492821_Slide 16_9 - 2.png', '2024-02-20 21:20:21', '2024-02-20 21:20:21', 7),
(7, 'public/signatures/test-42970472-2024_02_21_05_52_01/1708494721_report1708307879346.csv', 'public/homepay_receipts/test-42970472-2024_02_21_05_52_01/1708494721_report1708307879346.csv', '2024-02-20 21:52:01', '2024-02-20 21:52:01', 8),
(8, 'public/signatures/test-46118218-2024_02_21_11_32_58/1708515178_Slide 16_9 - 2.png', 'public/homepay_receipts/test-46118218-2024_02_21_11_32_58/1708515178_Slide 16_9 - 2.png', '2024-02-21 03:32:58', '2024-02-21 03:32:58', 9),
(9, 'public/signatures/test-49637373-2024_02_21_12_50_22/1708519822_Your account name.png', 'public/homepay_receipts/test-49637373-2024_02_21_12_50_22/1708519822_Your account name.png', '2024-02-21 04:50:22', '2024-02-21 04:50:22', 10),
(10, 'public/signatures/test-44350890-2024_02_21_13_01_56/1708520516_Slide 16_9 - 2.png', 'public/homepay_receipts/test-44350890-2024_02_21_13_01_56/1708520516_Slide 16_9 - 2.png', '2024-02-21 05:01:56', '2024-02-21 05:01:56', 11),
(11, 'public/signatures/test-41956816-2024_02_23_12_01_25/1708689685_415753137_318834867824231_1113351066923660500_n.png', 'public/homepay_receipts/test-41956816-2024_02_23_12_01_25/1708689685_415753137_318834867824231_1113351066923660500_n.png', '2024-02-23 04:01:25', '2024-02-23 04:01:25', 12),
(12, 'public/signatures/test-46105678-2024_02_24_05_24_00/1708752240_GetCloudyConsultingLogo.png', 'public/homepay_receipts/test-46105678-2024_02_24_05_24_00/1708752240_GetCloudyConsultingLogo.png', '2024-02-23 21:24:00', '2024-02-23 21:24:00', 13),
(13, 'public/signatures/test-46781142-2024_02_24_08_12_16/1708762336_GetCloudyConsultingLogo.png', 'public/homepay_receipts/test-46781142-2024_02_24_08_12_16/1708762336_GetCloudyConsultingLogo.png', '2024-02-24 00:12:16', '2024-02-24 00:12:16', 14),
(14, 'public/signatures/test-42046914-2024_02_24_12_20_12/1708777212_GetCloudyConsultingLogo.png', 'public/homepay_receipts/test-42046914-2024_02_24_12_20_12/1708777212_GetCloudyConsultingLogo.png', '2024-02-24 04:20:12', '2024-02-24 04:20:12', 15),
(15, 'public/signatures/test-49000190-2024_02_25_13_41_37/1708868497_GetCloudyConsultingLogo.png', 'public/homepay_receipts/test-49000190-2024_02_25_13_41_37/1708868497_GetCloudyConsultingLogo.png', '2024-02-25 05:41:37', '2024-02-25 05:41:37', 16),
(16, 'public/signatures/test-47705249-2024_02_25_13_41_47/1708868507_GetCloudyConsultingLogo.png', 'public/homepay_receipts/test-47705249-2024_02_25_13_41_47/1708868507_GetCloudyConsultingLogo.png', '2024-02-25 05:41:47', '2024-02-25 05:41:47', 17),
(17, 'public/signatures/test-43682448-2024_02_25_13_42_25/1708868545_GetCloudyConsultingLogo.png', 'public/homepay_receipts/test-43682448-2024_02_25_13_42_25/1708868545_GetCloudyConsultingLogo.png', '2024-02-25 05:42:25', '2024-02-25 05:42:25', 18),
(18, 'public/signatures/test-43903629-2024_02_25_13_45_12/1708868712_GetCloudyConsultingLogo.png', 'public/homepay_receipts/test-43903629-2024_02_25_13_45_12/1708868712_GetCloudyConsultingLogo.png', '2024-02-25 05:45:12', '2024-02-25 05:45:12', 19),
(19, 'public/signatures/test-48612702-2024_02_25_14_27_34/1708871254_GetCloudyConsultingLogo.png', 'public/homepay_receipts/test-48612702-2024_02_25_14_27_34/1708871254_GetCloudyConsultingLogo.png', '2024-02-25 06:27:34', '2024-02-25 06:27:34', 20),
(20, 'public/signatures/test-41632791-2024_02_25_15_12_12/1708873932_GetCloudyConsultingLogo.png', 'public/homepay_receipts/test-41632791-2024_02_25_15_12_12/1708873932_GetCloudyConsultingLogo.png', '2024-02-25 07:12:12', '2024-02-25 07:12:12', 21),
(21, 'public/signatures/test-41587639-2024_02_26_06_20_00/1708928400_GetCloudyConsultingLogo.png', 'public/homepay_receipts/test-41587639-2024_02_26_06_20_00/1708928400_GetCloudyConsultingLogo.png', '2024-02-25 22:20:00', '2024-02-25 22:20:00', 22),
(22, 'public/signatures/test-44343533-2024_02_27_13_38_00/1709041080_GetCloudyConsultingLogo.png', 'public/homepay_receipts/test-44343533-2024_02_27_13_38_00/1709041080_GetCloudyConsultingLogo.png', '2024-02-27 05:38:00', '2024-02-27 05:38:00', 23),
(23, 'signatures/1709214708_415753137_318834867824231_1113351066923660500_n.png', 'receipts/1709214708_GetCloudyConsultingLogo.png', '2024-02-29 05:51:48', '2024-02-29 05:51:48', 24),
(24, 'signatures/1709299293_Slide 16_9 - 4.png', 'receipts/1709299293_GetCloudyConsultingLogo.png', '2024-03-01 05:21:33', '2024-03-01 05:21:33', 25);

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
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2024_02_09_105122_create_loan_applications', 1),
(6, '2024_02_09_134130_create_media_table', 1),
(7, '2024_02_09_134318_create_permissions_table', 1),
(8, '2024_02_09_134446_create_payments_table', 1),
(9, '2024_02_09_134536_create_clients_table', 1),
(10, '2024_02_09_134602_create_transaction_histories_table', 1),
(11, '2024_02_09_134629_create_permission_role_pivot_table', 1),
(12, '2024_02_09_134651_create_role_user_pivot_table', 1),
(13, '2024_02_09_134754_create_loan_application_payment_pivot_table', 1),
(14, '2024_02_09_134829_add_relationship_fields_to_loan_applications_table', 1),
(15, '2024_02_09_134858_add_relationship_fields_to_payment_table', 1),
(16, '2024_02_09_134928_add_relationship_fieldsto_clients', 1),
(17, '2024_02_09_135022_add_relationship_fieldsto_transaction_histories_table', 1),
(18, '2024_02_11_062042_create_role_id_in_user_table', 1),
(19, '2024_02_11_114511_create_permission_id_in_users_table', 1),
(20, '2024_02_20_041453_add_time_pay', 2),
(21, '2024_02_20_041927_add_receipts', 3),
(22, '2024_02_20_042415_add_receipts', 4),
(23, '2024_02_20_104208_add_remarks', 5),
(24, '2024_02_20_104828_create_loan_application_approvals', 6),
(25, '2024_02_20_105108_add_loan_id', 7),
(26, '2024_02_20_105549_add_remarks', 8),
(27, '2024_02_21_125334_create_client_id', 9),
(28, '2024_02_24_050857_create_balance', 10),
(29, '2024_02_24_152801_create_note_payment', 11),
(30, '2024_02_25_031437_create_timestamp', 12),
(31, '2024_02_25_051854_create_reference_number', 13),
(32, '2024_02_25_150450_create_monthly_pay', 14),
(33, '2024_02_26_104147_make_client_id', 15),
(34, '2024_02_26_123419_user_columns', 16),
(35, '2024_02_27_033336_create_code_column', 17),
(36, '2024_02_27_095330_create_newemail', 18),
(37, '2024_02_27_114408_create_password_user_col', 19);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
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
  `reference_no` varchar(255) NOT NULL,
  `amount_paid` decimal(15,2) NOT NULL,
  `current_balance` decimal(15,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `account_number_id` bigint(20) UNSIGNED DEFAULT NULL,
  `note` text DEFAULT NULL,
  `client_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `reference_no`, `amount_paid`, `current_balance`, `created_at`, `updated_at`, `deleted_at`, `account_number_id`, `note`, `client_id`) VALUES
(3, '', 8080.00, 0.00, '2024-02-24 04:18:10', '2024-02-24 04:18:10', NULL, NULL, NULL, NULL),
(4, '', 0.00, 0.00, '2024-02-24 04:18:57', '2024-02-24 04:18:57', NULL, NULL, NULL, NULL),
(5, '', 8000.00, 2191.67, '2024-02-24 07:22:11', '2024-02-24 07:22:11', NULL, NULL, NULL, NULL),
(6, '', 322.00, 1869.67, '2024-02-24 07:23:54', '2024-02-24 07:23:54', NULL, 5, NULL, NULL),
(11, '', 1000.00, 869.67, '2024-02-24 19:28:28', '2024-02-24 19:28:28', NULL, 5, NULL, NULL),
(12, '', 500.00, 369.67, '2024-02-24 19:29:27', '2024-02-24 19:29:27', NULL, 5, NULL, NULL),
(15, '', 233.00, 136.67, '2024-02-24 19:35:52', '2024-02-24 19:35:52', NULL, 5, NULL, NULL),
(16, '', 24.00, 112.67, '2024-02-24 19:37:06', '2024-02-24 19:37:06', NULL, 5, NULL, NULL),
(17, '', 23.00, 89.67, '2024-02-24 19:37:44', '2024-02-24 19:37:44', NULL, 5, NULL, NULL),
(18, '', 23.00, 66.67, '2024-02-24 19:46:21', '2024-02-24 19:46:21', NULL, 5, 'dasdas', NULL),
(19, '', 50.00, 16.67, '2024-02-24 19:47:32', '2024-02-24 19:47:32', NULL, 5, NULL, NULL),
(20, '', 1.00, 15.67, '2024-02-24 19:47:45', '2024-02-24 19:47:45', NULL, 5, 'dasdas', NULL),
(21, '', 1.00, 14.67, '2024-02-24 20:33:39', '2024-02-24 20:33:39', NULL, 5, NULL, NULL),
(22, '', 14.67, 0.00, '2024-02-24 20:58:02', '2024-02-24 20:58:02', NULL, 5, NULL, NULL),
(23, '', 8509.25, 0.00, '2024-02-24 21:00:18', '2024-02-24 21:00:18', NULL, 5, NULL, NULL),
(24, '', 0.00, 0.00, '2024-02-24 21:01:38', '2024-02-24 21:01:38', NULL, 5, NULL, NULL),
(25, '', 0.00, 0.00, '2024-02-24 21:03:24', '2024-02-24 21:03:24', NULL, 5, NULL, NULL),
(26, 'LPZ76MXISP', 0.00, 0.00, '2024-02-24 21:23:03', '2024-02-24 21:23:03', NULL, 5, NULL, NULL),
(27, 'LPMMU8AZ1T', 0.00, 0.00, '2024-02-24 23:43:08', '2024-02-24 23:43:08', NULL, 5, NULL, NULL),
(28, 'LPOW92WESJ', 0.00, 0.00, '2024-02-25 01:35:22', '2024-02-25 01:35:22', NULL, 5, 'dasdsa', NULL),
(29, 'LPKBIH3LFW', 0.00, 0.00, '2024-02-25 01:36:17', '2024-02-25 01:36:17', NULL, 5, 'adsa', NULL),
(30, 'LPEV0TJR61', 0.00, 0.00, '2024-02-25 01:37:26', '2024-02-25 01:37:26', NULL, 5, NULL, NULL),
(31, 'LPEL4HUJAL', 0.00, 0.00, '2024-02-25 01:42:33', '2024-02-25 01:42:33', NULL, 5, NULL, NULL),
(32, 'LPWJVM8IPK', 0.00, 0.00, '2024-02-25 01:47:06', '2024-02-25 01:47:06', NULL, 5, 'dasdsa', NULL),
(33, 'LP8ITXJWYC', 0.00, 0.00, '2024-02-25 01:51:58', '2024-02-25 01:51:58', NULL, 5, 'dsds', NULL),
(34, 'LPWYYRCAHX', 0.00, 0.00, '2024-02-25 01:54:06', '2024-02-25 01:54:06', NULL, 5, NULL, NULL),
(35, 'LPP43S7ONW', 0.00, 0.00, '2024-02-25 02:01:31', '2024-02-25 02:01:31', NULL, 5, NULL, NULL),
(36, 'LP3RM7ZR4C', 0.00, 0.00, '2024-02-25 02:02:57', '2024-02-25 02:02:57', NULL, 5, NULL, NULL),
(37, 'LPHF3GCJD0', 0.00, 0.00, '2024-02-25 02:05:55', '2024-02-25 02:05:55', NULL, 5, NULL, NULL),
(38, 'LPEP2LL2FY', 0.00, 0.00, '2024-02-25 02:07:10', '2024-02-25 02:07:10', NULL, 5, NULL, NULL),
(39, 'LPTQCVXUTH', 0.00, 0.00, '2024-02-25 02:12:54', '2024-02-25 02:12:54', NULL, 5, NULL, NULL),
(40, 'LPR3DLQ1RZ', 0.00, 0.00, '2024-02-25 02:14:44', '2024-02-25 02:14:44', NULL, 5, NULL, NULL),
(41, 'LP1LVYOZHE', 0.00, 0.00, '2024-02-25 02:15:36', '2024-02-25 02:15:36', NULL, 5, NULL, NULL),
(42, 'LPMNCAVVSQ', 0.00, 0.00, '2024-02-25 02:19:35', '2024-02-25 02:19:35', NULL, 5, NULL, NULL),
(43, 'LP3D3ZZYGJ', 1040.00, 9410.00, '2024-02-26 02:47:12', '2024-02-26 02:47:12', NULL, 5, 'asdasd', 1),
(44, 'LPG0KIVA6O', 8509.25, 0.00, '2024-02-27 06:49:06', '2024-02-27 06:49:06', NULL, 5, NULL, 1),
(45, 'LPBJ7JD6LR', 9000.00, 410.00, '2024-02-27 06:51:33', '2024-02-27 06:51:33', NULL, 5, NULL, 1),
(46, 'LPMBMAHF8J', 410.00, 0.00, '2024-02-27 06:53:16', '2024-02-27 06:53:16', NULL, 5, NULL, 1),
(47, 'LPEAJZ9SL3', 11495.00, 0.00, '2024-02-27 06:55:42', '2024-02-27 06:55:42', NULL, 5, NULL, 1),
(48, 'LPAXR0PYC0', 0.00, 0.00, '2024-02-27 14:57:06', '2024-02-27 06:57:06', NULL, 5, NULL, 1),
(49, 'LPNBMS3M4P', 0.00, 0.00, '2024-02-27 14:57:23', '2024-02-27 06:57:23', NULL, 5, NULL, 1),
(50, 'LPELORDWEC', 0.00, 0.00, '2024-02-28 05:48:30', '2024-02-27 21:48:30', NULL, 5, NULL, 1),
(51, 'LPCKTZRJN5', 1186.81, 11457.69, '2024-02-29 14:25:30', '2024-02-29 06:25:30', NULL, 5, NULL, 1),
(52, 'LPTVZYPP3C', 1186.81, 10270.88, '2024-02-29 14:35:21', '2024-02-29 06:35:21', NULL, 5, 'Yes', 1),
(53, 'LPKGCLGZ0I', 1186.81, 9084.07, '2024-02-29 14:37:01', '2024-02-29 06:37:01', NULL, 5, 'Pay', 1),
(54, 'LPQ1B5K2MU', 1186.81, 7897.26, '2024-02-29 14:37:34', '2024-02-29 06:37:34', NULL, 5, NULL, 1),
(55, 'LPFK9BALKC', 1186.81, 6710.45, '2024-02-29 14:40:49', '2024-02-29 06:40:49', NULL, 5, NULL, 1),
(56, 'LPOXDT8HNM', 1186.81, 5523.64, '2024-02-29 14:41:59', '2024-02-29 06:41:59', NULL, 5, 'Payu', 1),
(57, 'LP9IETHUG4', 1186.81, 4336.83, '2024-02-29 14:43:01', '2024-02-29 06:43:01', NULL, 5, NULL, 1),
(58, 'LP33LWECDU', 1186.81, 3150.02, '2024-02-29 14:44:15', '2024-02-29 06:44:15', NULL, 5, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'general_manager', 'Admin', NULL, NULL, NULL),
(2, 'accountant', 'Admin', NULL, NULL, NULL),
(3, 'book_keeper', 'Admin', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `permission_role`
--

CREATE TABLE `permission_role` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `permission_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permission_role`
--

INSERT INTO `permission_role` (`id`, `role_id`, `permission_id`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 3);

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `title`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Admin', NULL, NULL, NULL),
(2, 'Member', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `role_user`
--

CREATE TABLE `role_user` (
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transaction_histories`
--

CREATE TABLE `transaction_histories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `audit_description` varchar(255) DEFAULT NULL,
  `transaction_type` varchar(255) DEFAULT NULL,
  `transaction_status` varchar(255) DEFAULT NULL,
  `transaction_date` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `account_number_id` bigint(20) UNSIGNED DEFAULT NULL,
  `loan_application_id` bigint(20) UNSIGNED DEFAULT NULL,
  `currently_assigned_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transaction_histories`
--

INSERT INTO `transaction_histories` (`id`, `audit_description`, `transaction_type`, `transaction_status`, `transaction_date`, `created_at`, `updated_at`, `deleted_at`, `account_number_id`, `loan_application_id`, `currently_assigned_id`) VALUES
(1, 'Payment recorded for loan reference: 46781142', 'Payment', 'Completed', '2024-02-24 12:18:10', '2024-02-24 04:18:10', '2024-02-24 04:18:10', NULL, NULL, NULL, NULL),
(2, 'Payment recorded for loan reference: 46781142', 'Payment', 'Completed', '2024-02-24 12:18:57', '2024-02-24 04:18:57', '2024-02-24 04:18:57', NULL, NULL, NULL, NULL),
(3, 'Payment recorded for loan reference: 42046914', 'Payment', 'Completed', '2024-02-24 15:22:11', '2024-02-24 07:22:11', '2024-02-24 07:22:11', NULL, NULL, NULL, NULL),
(4, 'Payment recorded for loan reference: 42046914', 'Payment', 'Completed', '2024-02-24 15:23:54', '2024-02-24 07:23:54', '2024-02-24 07:23:54', NULL, NULL, NULL, NULL),
(5, 'Payment recorded for loan reference: 42046914', 'Payment', 'Completed', '2024-02-25 03:28:28', '2024-02-24 19:28:28', '2024-02-24 19:28:28', NULL, 5, NULL, 3),
(6, 'Payment recorded for loan reference: 42046914', 'Payment', 'Completed', '2024-02-25 03:29:27', '2024-02-24 19:29:27', '2024-02-24 19:29:27', NULL, 5, NULL, 3),
(7, 'Payment recorded for loan reference: 42046914', 'Payment', 'Completed', '2024-02-25 03:35:52', '2024-02-24 19:35:52', '2024-02-24 19:35:52', NULL, 5, 15, 3),
(8, 'Payment recorded for loan reference: 42046914', 'Payment', 'Completed', '2024-02-25 03:37:06', '2024-02-24 19:37:06', '2024-02-24 19:37:06', NULL, 5, 15, 3),
(9, 'Payment recorded for loan reference: 42046914', 'Payment', 'Completed', '2024-02-25 03:37:44', '2024-02-24 19:37:44', '2024-02-24 19:37:44', NULL, 5, 15, 3),
(10, 'Payment recorded for loan reference: 42046914', 'Payment', 'Completed', '2024-02-25 03:46:21', '2024-02-24 19:46:21', '2024-02-24 19:46:21', NULL, 5, 15, 3),
(11, 'Payment recorded for loan reference: 42046914', 'Payment', 'Completed', '2024-02-25 03:47:32', '2024-02-24 19:47:32', '2024-02-24 19:47:32', NULL, 5, 15, 3),
(12, 'Payment recorded for loan reference: 42046914', 'Payment', 'Completed', '2024-02-25 03:47:45', '2024-02-24 19:47:45', '2024-02-24 19:47:45', NULL, 5, 15, 3),
(13, 'Payment recorded for loan reference: 42046914', 'Payment', 'Completed', '2024-02-25 04:33:39', '2024-02-24 20:33:39', '2024-02-24 20:33:39', NULL, 5, 15, 3),
(14, 'Payment recorded for loan reference: 42046914', 'Payment', 'Completed', '2024-02-25 04:58:02', '2024-02-24 20:58:02', '2024-02-24 20:58:02', NULL, 5, 15, 3),
(15, 'Payment recorded for loan reference: 44350890', 'Payment', 'Completed', '2024-02-25 05:00:18', '2024-02-24 21:00:18', '2024-02-24 21:00:18', NULL, 5, 11, 3),
(16, 'Payment recorded for loan reference: 46781142', 'Payment', 'Completed', '2024-02-25 05:01:38', '2024-02-24 21:01:38', '2024-02-24 21:01:38', NULL, 5, 14, 3),
(17, 'Payment recorded for loan reference: 42046914', 'Payment', 'Completed', '2024-02-25 05:03:24', '2024-02-24 21:03:24', '2024-02-24 21:03:24', NULL, 5, 15, 3),
(18, 'Payment recorded for loan reference: 42046914', 'Payment', 'Completed', '2024-02-25 05:23:03', '2024-02-24 21:23:03', '2024-02-24 21:23:03', NULL, 5, 15, 3),
(19, 'Payment recorded for loan reference: 42046914', 'Payment', 'Completed', '2024-02-25 07:43:08', '2024-02-24 23:43:08', '2024-02-24 23:43:08', NULL, 5, 15, 3),
(20, 'Payment recorded for loan reference: 42046914', 'Payment', 'Completed', '2024-02-25 09:35:22', '2024-02-25 01:35:22', '2024-02-25 01:35:22', NULL, 5, 15, 3),
(21, 'Payment recorded for loan reference: 42046914', 'Payment', 'Completed', '2024-02-25 09:36:17', '2024-02-25 01:36:17', '2024-02-25 01:36:17', NULL, 5, 15, 3),
(22, 'Payment recorded for loan reference: 42046914', 'Payment', 'Completed', '2024-02-25 09:37:26', '2024-02-25 01:37:26', '2024-02-25 01:37:26', NULL, 5, 15, 3),
(23, 'Payment recorded for loan reference: 42046914', 'Payment', 'Completed', '2024-02-25 09:42:33', '2024-02-25 01:42:33', '2024-02-25 01:42:33', NULL, 5, 15, 3),
(24, 'Payment recorded for loan reference: 42046914', 'Payment', 'Completed', '2024-02-25 09:47:06', '2024-02-25 01:47:06', '2024-02-25 01:47:06', NULL, 5, 15, 3),
(25, 'Payment recorded for loan reference: 42046914', 'Payment', 'Completed', '2024-02-25 09:51:58', '2024-02-25 01:51:58', '2024-02-25 01:51:58', NULL, 5, 15, 3),
(26, 'Payment recorded for loan reference: 42046914', 'Payment', 'Completed', '2024-02-25 09:54:06', '2024-02-25 01:54:06', '2024-02-25 01:54:06', NULL, 5, 15, 3),
(27, 'Payment recorded for loan reference: 42046914', 'Payment', 'Completed', '2024-02-25 10:01:31', '2024-02-25 02:01:31', '2024-02-25 02:01:31', NULL, 5, 15, 3),
(28, 'Payment recorded for loan reference: 42046914', 'Payment', 'Completed', '2024-02-25 10:02:57', '2024-02-25 02:02:57', '2024-02-25 02:02:57', NULL, 5, 15, 3),
(29, 'Payment recorded for loan reference: 42046914', 'Payment', 'Completed', '2024-02-25 10:05:55', '2024-02-25 02:05:55', '2024-02-25 02:05:55', NULL, 5, 15, 3),
(30, 'Payment recorded for loan reference: 42046914', 'Payment', 'Completed', '2024-02-25 10:07:10', '2024-02-25 02:07:10', '2024-02-25 02:07:10', NULL, 5, 15, 3),
(31, 'Payment recorded for loan reference: 42046914', 'Payment', 'Completed', '2024-02-25 10:12:54', '2024-02-25 02:12:54', '2024-02-25 02:12:54', NULL, 5, 15, 3),
(32, 'Payment recorded for loan reference: 42046914', 'Payment', 'Completed', '2024-02-25 10:14:44', '2024-02-25 02:14:44', '2024-02-25 02:14:44', NULL, 5, 15, 3),
(33, 'Payment recorded for loan reference: 42046914', 'Payment', 'Completed', '2024-02-25 10:15:36', '2024-02-25 02:15:36', '2024-02-25 02:15:36', NULL, 5, 15, 3),
(34, 'Payment recorded for loan reference: 42046914', 'Payment', 'Completed', '2024-02-25 10:19:35', '2024-02-25 02:19:35', '2024-02-25 02:19:35', NULL, 5, 15, 3),
(35, 'Payment recorded for loan reference: 41632791', 'Payment', 'Completed', '2024-02-26 10:47:12', '2024-02-26 02:47:12', '2024-02-26 02:47:12', NULL, 5, 21, 3),
(36, 'Loan Application Submitted', 'Loan Application', 'Pending', '2024-02-27 13:38:00', '2024-02-27 05:38:00', '2024-02-27 05:38:00', NULL, 5, 23, NULL),
(37, 'Payment recorded for loan reference: 42970472', 'Payment', 'Completed', '2024-02-27 22:49:06', '2024-02-27 06:49:06', '2024-02-27 06:49:06', NULL, 5, 8, 3),
(38, 'Payment recorded for loan reference: 41632791', 'Payment', 'Completed', '2024-02-27 22:51:33', '2024-02-27 06:51:33', '2024-02-27 06:51:33', NULL, 5, 21, 3),
(39, 'Payment recorded for loan reference: 41632791', 'Payment', 'Completed', '2024-02-27 22:53:16', '2024-02-27 06:53:16', '2024-02-27 06:53:16', NULL, 5, 21, 3),
(40, 'Payment recorded for loan reference: 41587639', 'Payment', 'Completed', '2024-02-27 22:55:42', '2024-02-27 06:55:42', '2024-02-27 06:55:42', NULL, 5, 22, 3),
(41, 'Payment recorded for loan reference: 41587639', 'Payment', 'Completed', '2024-02-27 22:57:06', '2024-02-27 06:57:06', '2024-02-27 06:57:06', NULL, 5, 22, 3),
(42, 'Payment recorded for loan reference: 41587639', 'Payment', 'Completed', '2024-02-27 22:57:23', '2024-02-27 06:57:23', '2024-02-27 06:57:23', NULL, 5, 22, 3),
(43, 'Payment recorded for loan reference: 41587639', 'Payment', 'Completed', '2024-02-28 13:48:30', '2024-02-27 21:48:30', '2024-02-27 21:48:30', NULL, 5, 22, 3),
(44, 'Loan Application Response', 'Loan Application', 'Accepted', '2024-02-28 14:11:49', '2024-02-27 22:11:49', '2024-02-27 22:11:49', NULL, 5, 23, 2),
(45, 'Loan Application Response', 'Loan Application', 'Accepted', '2024-02-28 14:13:17', '2024-02-27 22:13:17', '2024-02-27 22:13:17', NULL, 5, 23, 1),
(46, 'Loan Application Submitted', 'Loan Application', 'Pending', '2024-02-29 21:51:48', '2024-02-29 05:51:48', '2024-02-29 05:51:48', NULL, 5, 24, NULL),
(47, 'Loan Application Response', 'Loan Application', 'Approved', '2024-02-29 21:54:36', '2024-02-29 05:54:36', '2024-02-29 05:54:36', NULL, 5, 24, 2),
(48, 'Loan Application Response', 'Loan Application', 'Approved', '2024-02-29 21:55:48', '2024-02-29 05:55:48', '2024-02-29 05:55:48', NULL, 5, 24, 2),
(49, 'Loan Application Response', 'Loan Application', 'Approved', '2024-02-29 21:57:56', '2024-02-29 05:57:56', '2024-02-29 05:57:56', NULL, 5, 24, 2),
(50, 'Loan Application Response', 'Loan Application', 'Approved', '2024-02-29 21:58:49', '2024-02-29 05:58:49', '2024-02-29 05:58:49', NULL, 5, 24, 2),
(51, 'Loan Application Response', 'Loan Application', 'Approved', '2024-02-29 22:00:07', '2024-02-29 06:00:07', '2024-02-29 06:00:07', NULL, 5, 20, 2),
(52, 'Loan Application Response', 'Loan Application', 'Rejected', '2024-02-29 22:02:33', '2024-02-29 06:02:33', '2024-02-29 06:02:33', NULL, 5, 19, 2),
(53, 'Loan Application Response', 'Loan Application', 'Approved', '2024-02-29 22:04:55', '2024-02-29 06:04:55', '2024-02-29 06:04:55', NULL, 5, 24, 1),
(54, 'Loan Application Response', 'Loan Application', 'Rejected', '2024-02-29 22:05:35', '2024-02-29 06:05:35', '2024-02-29 06:05:35', NULL, 5, 20, 1),
(55, 'Payment for 44343533 recorded.', 'Payment', 'Completed', '2024-02-29 22:25:30', '2024-02-29 06:25:30', '2024-02-29 06:25:30', NULL, 5, 23, 3),
(56, 'Payment for 44343533 recorded.', 'Payment', 'Completed', '2024-02-29 22:35:21', '2024-02-29 06:35:21', '2024-02-29 06:35:21', NULL, 5, 23, 3),
(57, 'Payment for 44343533 recorded.', 'Payment', 'Completed', '2024-02-29 22:37:01', '2024-02-29 06:37:01', '2024-02-29 06:37:01', NULL, 5, 23, 3),
(58, 'Payment for 44343533 recorded.', 'Payment', 'Completed', '2024-02-29 22:37:34', '2024-02-29 06:37:34', '2024-02-29 06:37:34', NULL, 5, 23, 3),
(59, 'Payment for 44343533 recorded.', 'Payment', 'Completed', '2024-02-29 22:40:49', '2024-02-29 06:40:49', '2024-02-29 06:40:49', NULL, 5, 23, 3),
(60, 'Payment for 44343533 recorded.', 'Payment', 'Completed', '2024-02-29 22:41:59', '2024-02-29 06:41:59', '2024-02-29 06:41:59', NULL, 5, 23, 3),
(61, 'Payment for 44343533 recorded.', 'Payment', 'Completed', '2024-02-29 22:43:01', '2024-02-29 06:43:01', '2024-02-29 06:43:01', NULL, 5, 23, 3),
(62, 'Payment for 44343533 recorded.', 'Payment', 'Completed', '2024-02-29 22:44:15', '2024-02-29 06:44:15', '2024-02-29 06:44:15', NULL, 5, 23, 3),
(63, 'Loan Application Response', 'Loan Application', 'Rejected', '2024-03-01 21:19:20', '2024-03-01 05:19:20', '2024-03-01 05:19:20', NULL, 5, 12, 2),
(64, 'Loan Application Submitted', 'Loan Application', 'Pending', '2024-03-01 21:21:33', '2024-03-01 05:21:33', '2024-03-01 05:21:33', NULL, 5, 25, NULL),
(65, 'Loan Application Response', 'Loan Application', 'Rejected', '2024-03-01 21:24:22', '2024-03-01 05:24:22', '2024-03-01 05:24:22', NULL, 5, 25, 2);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `permission_id` bigint(20) UNSIGNED DEFAULT NULL,
  `role_id` bigint(20) UNSIGNED DEFAULT NULL,
  `account_number` bigint(20) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `email_verified_at` datetime DEFAULT NULL,
  `new_email` varchar(255) DEFAULT NULL,
  `new_password` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `default_password` tinyint(4) DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL,
  `email_verified` tinyint(1) DEFAULT NULL,
  `remember_token` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `permission_id`, `role_id`, `account_number`, `name`, `email`, `email_verified_at`, `new_email`, `new_password`, `password`, `default_password`, `birth_date`, `code`, `email_verified`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 1, 1234, 'Admin General Manager', 'admin1@admin.com', NULL, NULL, NULL, '$2y$10$kAbhZte5UDxTeiOGNcYs8u/W8pYdM/ynOlPHXtqZmMQOjOb6MqX8G', NULL, '2024-02-26', NULL, 1, NULL, NULL, NULL, NULL),
(2, 3, 1, 12345, 'Admin Book Keeper', 'admin12@admin.com', NULL, NULL, NULL, '$2y$10$QvlcyGWsSG9IPt/ugPEhBu4qUBg3eyhNpC9g/Qjgy9HEVyoIFi79u', 0, '2024-02-26', NULL, 1, NULL, NULL, '2024-02-27 06:41:27', NULL),
(3, 2, 1, 123456, 'Admin Accountant', 'admin3@admin.com', NULL, NULL, NULL, '$2y$10$YVoni.FEPnKsEz8kNDaa4OduO0cOA.PCwtIFFwAN9.fKU2il9.UJS', NULL, '2024-02-26', NULL, 1, NULL, NULL, NULL, NULL),
(4, NULL, 2, 2345, 'Member', 'member@admin.com', NULL, NULL, NULL, '$2y$10$QcG6C64imOD9lZ7B8USWAedJylwiLJzIKQ6Lsrjp/jkvGOJGb2..S', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(5, NULL, 2, 6714496342, 'test test tester', 'nateman@gmail.com', '2024-03-01 15:50:52', NULL, NULL, '$2y$10$JdUTGa.rSYiVq5Vza1oKeeqEnx/vIGdRukNcIAZ8rP4iqeDLc.692', 0, '2024-02-27', '309959', 1, NULL, '2024-02-19 04:36:12', '2024-03-06 02:51:58', NULL),
(6, NULL, 2, 6101048119, 'asddw dasd gobas', NULL, NULL, NULL, NULL, NULL, 0, '2024-02-26', '583725', NULL, NULL, '2024-02-26 04:42:43', '2024-03-01 07:18:48', NULL),
(7, NULL, 2, 6731265423, 'sDAsdas dasdsa kcirederf', NULL, NULL, NULL, NULL, NULL, 1, '2024-02-26', NULL, NULL, NULL, '2024-02-26 05:39:24', '2024-02-26 05:39:24', NULL),
(8, NULL, 2, 6239035588, 'nhoj dd testdds', NULL, NULL, NULL, NULL, NULL, 1, '2024-02-26', NULL, NULL, NULL, '2024-02-26 05:41:05', '2024-02-26 05:41:05', NULL),
(9, NULL, 2, 6598972406, 'ewqew eqwewq asdasd', NULL, NULL, NULL, NULL, '$2y$10$R.Izgy0QCLKVtCY24Uhejey9gSFhNNqbxfdnKDSE1KD0Wv.hfVCxm', 1, '2024-02-26', NULL, NULL, NULL, '2024-02-26 05:43:10', '2024-02-26 05:43:10', NULL),
(10, NULL, 2, 6380646883, 'Justine Dagatan Retiro', NULL, NULL, NULL, NULL, '$2y$10$ltJ3vLssm5e3HKGy/QjBJ.CXLHhq1mJ18LN1VpXyNiYYiRm84YYum', 0, '2024-03-04', NULL, NULL, NULL, '2024-03-04 00:02:54', '2024-03-04 01:26:09', NULL),
(11, NULL, 2, 6263016875, 'ewqew eqwewq asdasd', NULL, NULL, NULL, NULL, '$2y$10$HscU92PN6s/8gAXDhpW1Y.WZsjsukv96uCvULPDsvDb47H5njSBQu', 0, '2024-02-26', NULL, 1, NULL, '2024-03-04 01:38:47', '2024-03-04 01:38:47', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `account_number_fk_9484416` (`user_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `loan_applications`
--
ALTER TABLE `loan_applications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `account_number_fk_9484383` (`account_number_id`),
  ADD KEY `take_action_by_fk_9484382` (`take_action_by_id`),
  ADD KEY `loan_applications_client_id_foreign` (`client_id`);

--
-- Indexes for table `loan_application_approvals`
--
ALTER TABLE `loan_application_approvals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `loan_application_approvals_loan_id_foreign` (`loan_id`);

--
-- Indexes for table `loan_application_payment`
--
ALTER TABLE `loan_application_payment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payment_id_fk_9484410` (`payment_id`),
  ADD KEY `loan_application_id_fk_9484410` (`loan_application_id`);

--
-- Indexes for table `media`
--
ALTER TABLE `media`
  ADD PRIMARY KEY (`id`),
  ADD KEY `media_loan_id_foreign` (`loan_id`);

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
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `account_number_fk_9484411` (`account_number_id`),
  ADD KEY `client_id_fk_9482411` (`client_id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permission_role`
--
ALTER TABLE `permission_role`
  ADD PRIMARY KEY (`id`),
  ADD KEY `permission_role_role_id_foreign` (`role_id`),
  ADD KEY `permission_role_permission_id_foreign` (`permission_id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_user`
--
ALTER TABLE `role_user`
  ADD KEY `user_id_fk_9484318` (`user_id`),
  ADD KEY `role_id_fk_9484318` (`role_id`);

--
-- Indexes for table `transaction_histories`
--
ALTER TABLE `transaction_histories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `account_number_fk_9484441` (`account_number_id`),
  ADD KEY `currently_assigned_fk_9484447` (`currently_assigned_id`),
  ADD KEY `loan_reference_fk_9484442` (`loan_application_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_account_number_unique` (`account_number`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_role_id_foreign` (`role_id`),
  ADD KEY `users_permission_id_foreign` (`permission_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `loan_applications`
--
ALTER TABLE `loan_applications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `loan_application_approvals`
--
ALTER TABLE `loan_application_approvals`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `loan_application_payment`
--
ALTER TABLE `loan_application_payment`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `media`
--
ALTER TABLE `media`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `permission_role`
--
ALTER TABLE `permission_role`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `transaction_histories`
--
ALTER TABLE `transaction_histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `clients`
--
ALTER TABLE `clients`
  ADD CONSTRAINT `account_number_fk_9484416` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `loan_applications`
--
ALTER TABLE `loan_applications`
  ADD CONSTRAINT `account_number_fk_9484383` FOREIGN KEY (`account_number_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `loan_applications_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `take_action_by_fk_9484382` FOREIGN KEY (`take_action_by_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `loan_application_approvals`
--
ALTER TABLE `loan_application_approvals`
  ADD CONSTRAINT `loan_application_approvals_loan_id_foreign` FOREIGN KEY (`loan_id`) REFERENCES `loan_applications` (`id`);

--
-- Constraints for table `loan_application_payment`
--
ALTER TABLE `loan_application_payment`
  ADD CONSTRAINT `loan_application_id_fk_9484410` FOREIGN KEY (`loan_application_id`) REFERENCES `loan_applications` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `payment_id_fk_9484410` FOREIGN KEY (`payment_id`) REFERENCES `payments` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `media`
--
ALTER TABLE `media`
  ADD CONSTRAINT `media_loan_id_foreign` FOREIGN KEY (`loan_id`) REFERENCES `loan_applications` (`id`);

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `account_number_fk_9484411` FOREIGN KEY (`account_number_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `client_id_fk_9482411` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`);

--
-- Constraints for table `permission_role`
--
ALTER TABLE `permission_role`
  ADD CONSTRAINT `permission_role_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `permission_role_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_user`
--
ALTER TABLE `role_user`
  ADD CONSTRAINT `role_id_fk_9484318` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_id_fk_9484318` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `transaction_histories`
--
ALTER TABLE `transaction_histories`
  ADD CONSTRAINT `account_number_fk_9484441` FOREIGN KEY (`account_number_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `currently_assigned_fk_9484447` FOREIGN KEY (`currently_assigned_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `loan_reference_fk_9484442` FOREIGN KEY (`loan_application_id`) REFERENCES `loan_applications` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
