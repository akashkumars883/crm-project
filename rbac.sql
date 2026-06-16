-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 06, 2023 at 07:05 PM
-- Server version: 10.6.12-MariaDB-0ubuntu0.22.04.1
-- PHP Version: 8.1.2-1ubuntu2.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rbac`
--

-- --------------------------------------------------------

--
-- Table structure for table `activities`
--

CREATE TABLE `activities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `activity_type_id` bigint(20) UNSIGNED NOT NULL,
  `lead_id` bigint(20) UNSIGNED DEFAULT NULL,
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `project_id` bigint(20) UNSIGNED DEFAULT NULL,
  `contact_method_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `activities`
--

INSERT INTO `activities` (`id`, `activity_type_id`, `lead_id`, `customer_id`, `project_id`, `contact_method_id`, `title`, `description`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 1, 1, NULL, NULL, 5, 'Requirement Confirm', 'Confirmed and sent standard Invoicee', 1, 1, '2023-09-04 13:26:31', '2023-09-04 13:26:31'),
(2, 6, NULL, 1, NULL, 4, 'Project Plan', 'Test', 1, 1, '2023-09-04 13:33:27', '2023-09-04 13:33:27'),
(3, 2, 1, 1, 1, 5, 'Site Visit', 'Test', 1, 1, '2023-09-04 13:58:19', '2023-09-04 13:58:19'),
(4, 1, 2, NULL, NULL, 3, 'Test', 'Test', 3, 3, '2023-09-06 06:03:06', '2023-09-06 06:03:06'),
(5, 4, NULL, 2, NULL, 5, 'Test', 'Test', 3, 3, '2023-09-06 06:05:44', '2023-09-06 06:05:44'),
(6, 2, 2, 2, 2, 5, 'Test', 'Test', 4, 4, '2023-09-06 06:09:06', '2023-09-06 06:09:06');

-- --------------------------------------------------------

--
-- Table structure for table `activity_types`
--

CREATE TABLE `activity_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `activity_types`
--

INSERT INTO `activity_types` (`id`, `name`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'Estimation', 1, 1, '2023-09-04 12:53:54', '2023-09-04 12:53:54'),
(2, 'Site Inspection', 1, 1, '2023-09-04 12:54:03', '2023-09-04 12:54:03'),
(3, 'Surface Preparation', 1, 1, '2023-09-04 12:54:10', '2023-09-04 12:54:10'),
(4, 'Painting', 1, 1, '2023-09-04 12:54:17', '2023-09-04 12:54:17'),
(5, 'Color Consultation', 1, 1, '2023-09-04 12:54:25', '2023-09-04 12:54:25'),
(6, 'Project Planning', 1, 1, '2023-09-04 12:54:33', '2023-09-04 12:54:33'),
(7, 'Safety Inspection', 1, 1, '2023-09-04 12:54:40', '2023-09-04 12:54:40'),
(8, 'Inventory Management', 1, 1, '2023-09-04 12:54:49', '2023-09-04 12:54:49'),
(9, 'Client Meetings', 1, 1, '2023-09-04 12:54:56', '2023-09-04 12:54:56'),
(10, 'Quality Control', 1, 1, '2023-09-04 12:55:04', '2023-09-04 12:55:04'),
(11, 'Equipment Maintenance', 1, 1, '2023-09-04 12:55:12', '2023-09-04 12:55:12'),
(12, 'Training and Development', 1, 1, '2023-09-04 12:55:21', '2023-09-04 12:55:21'),
(13, 'Marketing and Promotion', 1, 1, '2023-09-04 12:55:32', '2023-09-04 12:55:32'),
(14, 'Financial Management', 1, 1, '2023-09-04 12:55:40', '2023-09-04 12:55:40'),
(15, 'Documentation', 1, 1, '2023-09-04 12:55:46', '2023-09-04 12:55:46'),
(16, 'Project Review', 1, 1, '2023-09-04 12:55:53', '2023-09-04 12:55:53'),
(17, 'Health and Safety Training', 1, 1, '2023-09-04 12:56:00', '2023-09-04 12:56:00'),
(18, 'Team Building', 1, 1, '2023-09-04 12:56:08', '2023-09-04 12:56:08'),
(20, 'Community Engagement', 1, 1, '2023-09-04 12:56:27', '2023-09-04 12:56:27'),
(21, 'Tool and Material Procurement', 1, 1, '2023-09-04 12:56:34', '2023-09-04 12:56:34'),
(22, 'IT Support', 1, 1, '2023-09-04 12:56:43', '2023-09-04 12:56:43'),
(25, 'Social Media Management', 1, 1, '2023-09-04 12:57:12', '2023-09-04 12:57:12'),
(26, 'Job Site Cleanup', 1, 1, '2023-09-04 12:57:32', '2023-09-04 12:57:32'),
(27, 'Billing and Invoicing', 1, 1, '2023-09-04 12:57:41', '2023-09-04 12:57:41'),
(28, 'Legal and Compliance', 1, 1, '2023-09-04 12:57:49', '2023-09-04 12:57:49'),
(29, 'Customer Service', 1, 1, '2023-09-04 12:58:10', '2023-09-04 12:58:10');

-- --------------------------------------------------------

--
-- Table structure for table `attachments`
--

CREATE TABLE `attachments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `attachment_type_id` bigint(20) UNSIGNED NOT NULL,
  `project_id` bigint(20) UNSIGNED NOT NULL,
  `images` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`images`)),
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `attachments`
--

INSERT INTO `attachments` (`id`, `attachment_type_id`, `project_id`, `images`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '[\"projects\\/1\\/images\\/64f630316f6ef.jpeg\"]', 1, 1, '2023-09-04 13:59:53', '2023-09-04 13:59:53'),
(2, 1, 2, '[\"projects\\/2\\/images\\/64f864fa10a1e.jpg\"]', 4, 4, '2023-09-06 06:09:38', '2023-09-06 06:09:38');

-- --------------------------------------------------------

--
-- Table structure for table `attachment_types`
--

CREATE TABLE `attachment_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `attachment_types`
--

INSERT INTO `attachment_types` (`id`, `name`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'Before', 1, 1, '2023-09-04 12:03:29', '2023-09-04 12:03:29'),
(2, 'During', 1, 1, '2023-09-04 12:03:36', '2023-09-04 12:03:36'),
(3, 'After', 1, 1, '2023-09-04 12:03:45', '2023-09-04 12:03:45');

-- --------------------------------------------------------

--
-- Table structure for table `attendance_records`
--

CREATE TABLE `attendance_records` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `project_id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `notes` varchar(255) DEFAULT NULL,
  `attendance_type_id` bigint(20) UNSIGNED NOT NULL,
  `attendance_status_id` bigint(20) UNSIGNED NOT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `attendance_records`
--

INSERT INTO `attendance_records` (`id`, `employee_id`, `project_id`, `date`, `notes`, `attendance_type_id`, `attendance_status_id`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '2023-09-05', NULL, 1, 1, 1, 1, '2023-09-04 14:07:27', '2023-09-04 14:07:27'),
(2, 1, 1, '2023-09-06', NULL, 9, 11, 8, 8, '2023-09-05 01:48:41', '2023-09-05 01:48:41');

-- --------------------------------------------------------

--
-- Table structure for table `attendance_statuses`
--

CREATE TABLE `attendance_statuses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `attendance_statuses`
--

INSERT INTO `attendance_statuses` (`id`, `name`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'Present', 1, 1, '2023-09-04 12:22:37', '2023-09-04 12:22:37'),
(2, 'Absent', 1, 1, '2023-09-04 12:22:44', '2023-09-04 12:22:44'),
(3, 'Late', 1, 1, '2023-09-04 12:22:51', '2023-09-04 12:22:51'),
(4, 'Early Departure', 1, 1, '2023-09-04 12:22:58', '2023-09-04 12:22:58'),
(5, 'Excused Absence', 1, 1, '2023-09-04 12:23:04', '2023-09-04 12:23:04'),
(6, 'Unexcused Absence', 1, 1, '2023-09-04 12:23:11', '2023-09-04 12:23:11'),
(7, 'Tardy', 1, 1, '2023-09-04 12:23:22', '2023-09-04 12:23:22'),
(8, 'Partial Attendance', 1, 1, '2023-09-04 12:23:30', '2023-09-04 12:23:30'),
(9, 'No Show', 1, 1, '2023-09-04 12:23:36', '2023-09-04 12:23:36'),
(10, 'On Leave', 1, 1, '2023-09-04 12:23:43', '2023-09-04 12:23:43'),
(11, 'Remote Attendance', 1, 1, '2023-09-04 12:23:52', '2023-09-04 12:23:52'),
(12, 'Training In Progress', 1, 1, '2023-09-04 12:23:59', '2023-09-04 12:23:59'),
(13, 'Meeting In Progress', 1, 1, '2023-09-04 12:24:05', '2023-09-04 12:24:05'),
(14, 'Traveling', 1, 1, '2023-09-04 12:24:12', '2023-09-04 12:24:12'),
(15, 'Inactive', 1, 1, '2023-09-04 12:24:19', '2023-09-04 12:24:19');

-- --------------------------------------------------------

--
-- Table structure for table `attendance_types`
--

CREATE TABLE `attendance_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `attendance_types`
--

INSERT INTO `attendance_types` (`id`, `name`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'Regular', 1, 1, '2023-09-04 12:18:45', '2023-09-04 12:20:29'),
(2, 'Overtime', 1, 1, '2023-09-04 12:18:53', '2023-09-04 12:19:36'),
(3, 'Training', 1, 1, '2023-09-04 12:19:00', '2023-09-04 12:19:28'),
(4, 'Meeting', 1, 1, '2023-09-04 12:19:19', '2023-09-04 12:19:19'),
(5, 'Sick Leave', 1, 1, '2023-09-04 12:20:59', '2023-09-04 12:20:59'),
(6, 'Vacation Leave', 1, 1, '2023-09-04 12:21:06', '2023-09-04 12:21:06'),
(7, 'Paid Time Off (PTO)', 1, 1, '2023-09-04 12:21:17', '2023-09-04 12:21:17'),
(8, 'Unpaid Leave', 1, 1, '2023-09-04 12:21:24', '2023-09-04 12:21:24'),
(9, 'Remote Work', 1, 1, '2023-09-04 12:21:31', '2023-09-04 12:21:31'),
(10, 'Business Travel', 1, 1, '2023-09-04 12:21:39', '2023-09-04 12:21:39'),
(11, 'Compensatory Time (Comp Time)', 1, 1, '2023-09-04 12:21:48', '2023-09-04 12:21:48'),
(12, 'Maternity/Paternity Leave', 1, 1, '2023-09-04 12:21:56', '2023-09-04 12:21:56'),
(13, 'Bereavement Leave', 1, 1, '2023-09-04 12:22:04', '2023-09-04 12:22:04'),
(14, 'Unscheduled Absence', 1, 1, '2023-09-04 12:22:18', '2023-09-04 12:22:18');

-- --------------------------------------------------------

--
-- Table structure for table `bills`
--

CREATE TABLE `bills` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `bill_type_id` bigint(20) UNSIGNED NOT NULL,
  `reference` varchar(255) DEFAULT NULL,
  `amount` decimal(20,2) NOT NULL,
  `bill_date` date NOT NULL,
  `due_date` date NOT NULL,
  `bill_status_id` bigint(20) UNSIGNED NOT NULL,
  `payment_method_id` bigint(20) UNSIGNED DEFAULT NULL,
  `project_id` bigint(20) UNSIGNED DEFAULT NULL,
  `inventory_id` bigint(20) UNSIGNED DEFAULT NULL,
  `employee_id` bigint(20) UNSIGNED DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `attachments` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`attachments`)),
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bills`
--

INSERT INTO `bills` (`id`, `bill_type_id`, `reference`, `amount`, `bill_date`, `due_date`, `bill_status_id`, `payment_method_id`, `project_id`, `inventory_id`, `employee_id`, `notes`, `attachments`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 1, '231040', '100.00', '2023-09-05', '2023-09-05', 5, 3, 1, NULL, NULL, NULL, NULL, 1, 1, '2023-09-04 13:57:30', '2023-09-04 13:57:30'),
(2, 1, '12345', '12542.00', '2023-09-05', '2023-09-06', 1, NULL, NULL, NULL, NULL, NULL, NULL, 7, 7, '2023-09-04 14:27:09', '2023-09-04 14:27:09'),
(3, 1, '1332', '5000.00', '2023-09-05', '2023-09-05', 1, NULL, NULL, 1, NULL, NULL, NULL, 7, 1, '2023-09-04 14:37:43', '2023-09-04 14:46:55'),
(4, 5, '121212', '12222.00', '2023-09-06', '2023-09-06', 5, 6, 2, NULL, NULL, 'test', NULL, 4, 4, '2023-09-06 06:08:45', '2023-09-06 06:08:45');

-- --------------------------------------------------------

--
-- Table structure for table `bill_statuses`
--

CREATE TABLE `bill_statuses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bill_statuses`
--

INSERT INTO `bill_statuses` (`id`, `name`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'Draft', 1, 1, '2023-09-04 11:54:30', '2023-09-04 11:54:30'),
(2, 'Sent', 1, 1, '2023-09-04 11:54:38', '2023-09-04 11:54:38'),
(3, 'Pending', 1, 1, '2023-09-04 11:54:46', '2023-09-04 11:54:46'),
(4, 'Partially Paid', 1, 1, '2023-09-04 11:54:57', '2023-09-04 11:54:57'),
(5, 'Paid', 1, 1, '2023-09-04 11:55:05', '2023-09-04 11:55:05'),
(6, 'Overdue', 1, 1, '2023-09-04 11:55:12', '2023-09-04 11:55:12'),
(7, 'Voided', 1, 1, '2023-09-04 11:55:18', '2023-09-04 11:55:18'),
(8, 'Refunded', 1, 1, '2023-09-04 11:55:25', '2023-09-04 11:55:25'),
(9, 'Authorized', 1, 1, '2023-09-04 11:55:32', '2023-09-04 11:55:32'),
(10, 'Settled', 1, 1, '2023-09-04 11:55:40', '2023-09-04 11:55:40'),
(11, 'Failed', 1, 1, '2023-09-04 11:55:47', '2023-09-04 11:55:47'),
(12, 'Disputed', 1, 1, '2023-09-04 11:55:54', '2023-09-04 11:55:54'),
(13, 'Archived', 1, 1, '2023-09-04 11:56:01', '2023-09-04 11:56:01');

-- --------------------------------------------------------

--
-- Table structure for table `bill_types`
--

CREATE TABLE `bill_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bill_types`
--

INSERT INTO `bill_types` (`id`, `name`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'Regular Bill', 1, 1, '2023-09-04 11:52:35', '2023-09-04 11:52:35'),
(2, 'Recurring Bill', 1, 1, '2023-09-04 11:52:44', '2023-09-04 11:52:44'),
(3, 'Credit Bill (Credit Note)', 1, 1, '2023-09-04 11:52:54', '2023-09-04 11:52:54'),
(4, 'Debit Bill (Debit Note)', 1, 1, '2023-09-04 11:53:04', '2023-09-04 11:53:04'),
(5, 'Expense Bill', 1, 1, '2023-09-04 11:53:14', '2023-09-04 11:53:14'),
(6, 'Utility Bill', 1, 1, '2023-09-04 11:53:21', '2023-09-04 11:53:21'),
(7, 'Membership Fee', 1, 1, '2023-09-04 11:53:30', '2023-09-04 11:53:30'),
(8, 'Rent Bill', 1, 1, '2023-09-04 11:53:39', '2023-09-04 11:53:39'),
(9, 'Advance Payment Bill', 1, 1, '2023-09-04 11:53:46', '2023-09-04 11:53:46'),
(10, 'Interest Bill', 1, 1, '2023-09-04 11:53:54', '2023-09-04 11:53:54'),
(11, 'Consolidated Bill', 1, 1, '2023-09-04 11:54:02', '2023-09-04 11:54:02'),
(12, 'Tax Bill', 1, 1, '2023-09-04 11:54:10', '2023-09-04 11:54:10');

-- --------------------------------------------------------

--
-- Table structure for table `blood_groups`
--

CREATE TABLE `blood_groups` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `blood_groups`
--

INSERT INTO `blood_groups` (`id`, `name`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'A+', 1, 1, '2023-09-04 12:47:04', '2023-09-04 12:47:04'),
(2, 'A-', 1, 1, '2023-09-04 12:47:14', '2023-09-04 12:47:14'),
(3, 'B+', 1, 1, '2023-09-04 12:47:24', '2023-09-04 12:47:24'),
(4, 'B-', 1, 1, '2023-09-04 12:47:41', '2023-09-04 12:47:41'),
(5, 'AB+', 1, 1, '2023-09-04 12:47:49', '2023-09-04 12:47:49'),
(6, 'AB-', 1, 1, '2023-09-04 12:48:00', '2023-09-04 12:48:00'),
(7, 'O+', 1, 1, '2023-09-04 12:48:10', '2023-09-04 12:48:10'),
(8, 'O-', 1, 1, '2023-09-04 12:48:23', '2023-09-04 12:48:23'),
(9, 'Unknown (Blood type not known)', 1, 1, '2023-09-04 12:48:35', '2023-09-04 12:48:35'),
(10, 'Not Applicable (Blood type not applicable)', 1, 1, '2023-09-04 12:48:46', '2023-09-04 12:48:46');

-- --------------------------------------------------------

--
-- Table structure for table `contact_languages`
--

CREATE TABLE `contact_languages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contact_languages`
--

INSERT INTO `contact_languages` (`id`, `name`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'English', 1, 1, '2023-09-04 11:33:27', '2023-09-04 11:33:27'),
(2, 'Hindi', 1, 1, '2023-09-04 11:33:35', '2023-09-04 11:33:35');

-- --------------------------------------------------------

--
-- Table structure for table `contact_methods`
--

CREATE TABLE `contact_methods` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contact_methods`
--

INSERT INTO `contact_methods` (`id`, `name`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(3, 'Email', 1, 1, '2023-09-04 11:41:40', '2023-09-04 11:41:40'),
(4, 'Phone', 1, 1, '2023-09-04 11:41:49', '2023-09-04 11:41:49'),
(5, 'In-Person', 1, 1, '2023-09-04 11:42:01', '2023-09-04 11:42:01'),
(6, 'Video Call', 1, 1, '2023-09-04 11:42:10', '2023-09-04 11:42:10'),
(7, 'Chat', 1, 1, '2023-09-04 11:42:18', '2023-09-04 11:42:18'),
(8, 'Social Media', 1, 1, '2023-09-04 11:42:28', '2023-09-04 11:42:28'),
(9, 'SMS/Text', 1, 1, '2023-09-04 11:42:38', '2023-09-04 11:42:38'),
(10, 'Voicemail', 1, 1, '2023-09-04 11:42:47', '2023-09-04 11:42:47'),
(11, 'Mail', 1, 1, '2023-09-04 11:42:55', '2023-09-04 11:42:55'),
(12, 'Web Forms', 1, 1, '2023-09-04 11:43:04', '2023-09-04 11:43:04');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `lead_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `lead_id`, `user_id`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 1, 5, 1, 1, '2023-09-04 13:27:53', '2023-09-04 13:27:53'),
(2, 2, 10, 3, 3, '2023-09-06 06:03:18', '2023-09-06 06:03:18');

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `name`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'Operations', 1, 1, '2023-09-04 12:32:37', '2023-09-04 12:32:37'),
(2, 'Sales and Marketing', 1, 1, '2023-09-04 12:32:47', '2023-09-04 12:32:47'),
(3, 'Estimation and Quotation', 1, 1, '2023-09-04 12:32:58', '2023-09-04 12:32:58'),
(4, 'Human Resources', 1, 1, '2023-09-04 12:33:08', '2023-09-04 12:33:08'),
(5, 'Finance and Accounting', 1, 1, '2023-09-04 12:33:16', '2023-09-04 12:33:16'),
(6, 'Safety and Compliance', 1, 1, '2023-09-04 12:33:25', '2023-09-04 12:33:25'),
(7, 'Customer Service', 1, 1, '2023-09-04 12:33:35', '2023-09-04 12:33:35'),
(8, 'Inventory and Procurement', 1, 1, '2023-09-04 12:33:43', '2023-09-04 12:33:43'),
(9, 'IT and Technology', 1, 1, '2023-09-04 12:33:52', '2023-09-04 12:33:52'),
(10, 'Legal and Compliance', 1, 1, '2023-09-04 12:34:01', '2023-09-04 12:34:01'),
(11, 'Miscellaneous', 1, 1, '2023-09-04 12:34:10', '2023-09-04 12:34:10');

-- --------------------------------------------------------

--
-- Table structure for table `designations`
--

CREATE TABLE `designations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `designations`
--

INSERT INTO `designations` (`id`, `name`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'Operations Manager', 1, 1, '2023-09-04 12:34:36', '2023-09-04 12:34:36'),
(2, 'Project Coordinator', 1, 1, '2023-09-04 12:34:44', '2023-09-04 12:34:44'),
(3, 'Site Supervisor', 1, 1, '2023-09-04 12:34:53', '2023-09-04 12:34:53'),
(4, 'Painter', 1, 1, '2023-09-04 12:35:13', '2023-09-04 12:35:13'),
(5, 'Sales Manager', 1, 1, '2023-09-04 12:35:23', '2023-09-04 12:35:23'),
(6, 'Sales Representative', 1, 1, '2023-09-04 12:35:30', '2023-09-04 12:35:30'),
(7, 'Marketing Specialist', 1, 1, '2023-09-04 12:35:38', '2023-09-04 12:35:38'),
(8, 'Digital Marketing Coordinator', 1, 1, '2023-09-04 12:35:45', '2023-09-04 12:35:45'),
(9, 'Estimation Manager', 1, 1, '2023-09-04 12:35:55', '2023-09-04 12:35:55'),
(10, 'Estimator', 1, 1, '2023-09-04 12:36:02', '2023-09-04 12:36:02'),
(11, 'Quantity Surveyor', 1, 1, '2023-09-04 12:36:10', '2023-09-04 12:36:10'),
(12, 'HR Manager', 1, 1, '2023-09-04 12:36:19', '2023-09-04 12:36:19'),
(13, 'Recruitment Specialist', 1, 1, '2023-09-04 12:36:27', '2023-09-04 12:36:27'),
(14, 'Training Coordinator', 1, 1, '2023-09-04 12:36:35', '2023-09-04 12:36:35'),
(15, 'Payroll Administrator', 1, 1, '2023-09-04 12:36:42', '2023-09-04 12:36:42'),
(16, 'Finance Manager', 1, 1, '2023-09-04 12:36:50', '2023-09-04 12:36:50'),
(17, 'Accountant', 1, 1, '2023-09-04 12:36:59', '2023-09-04 12:36:59'),
(18, 'Accounts Payable/Receivable Clerk', 1, 1, '2023-09-04 12:37:07', '2023-09-04 12:37:07'),
(19, 'Financial Analyst', 1, 1, '2023-09-04 12:37:15', '2023-09-04 12:37:15'),
(20, 'Safety Officer', 1, 1, '2023-09-04 12:37:25', '2023-09-04 12:37:25'),
(21, 'Compliance Specialist', 1, 1, '2023-09-04 12:37:31', '2023-09-04 12:37:31'),
(22, 'Environmental Specialist', 1, 1, '2023-09-04 12:37:38', '2023-09-04 12:37:38'),
(23, 'Customer Service Manager', 1, 1, '2023-09-04 12:37:47', '2023-09-04 12:37:47'),
(24, 'Customer Service Representative', 1, 1, '2023-09-04 12:37:56', '2023-09-04 12:37:56'),
(25, 'Inventory Manager', 1, 1, '2023-09-04 12:38:05', '2023-09-04 12:38:05'),
(26, 'Procurement Officer', 1, 1, '2023-09-04 12:38:13', '2023-09-04 12:38:13'),
(27, 'IT Manager', 1, 1, '2023-09-04 12:38:20', '2023-09-04 12:38:20'),
(28, 'IT Support Specialist', 1, 1, '2023-09-04 12:38:27', '2023-09-04 12:38:27'),
(29, 'Legal Counsel', 1, 1, '2023-09-04 12:38:36', '2023-09-04 12:38:36'),
(30, 'Carpenter', 1, 1, '2023-09-04 12:38:43', '2023-09-04 12:38:43'),
(31, 'Electrician', 1, 1, '2023-09-04 12:38:50', '2023-09-04 12:38:50'),
(32, 'Plumber', 1, 1, '2023-09-04 12:38:56', '2023-09-04 12:38:56'),
(33, 'Cleaning Staff', 1, 1, '2023-09-04 12:39:08', '2023-09-04 12:39:08'),
(34, 'Security Personnel', 1, 1, '2023-09-04 12:39:17', '2023-09-04 12:39:17');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `emp_id` varchar(255) NOT NULL,
  `employee_type_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `gender_id` bigint(20) UNSIGNED NOT NULL,
  `blood_group_id` bigint(20) UNSIGNED NOT NULL,
  `date_of_birth` date NOT NULL,
  `address` text NOT NULL,
  `joining_date` date NOT NULL,
  `department_id` bigint(20) UNSIGNED NOT NULL,
  `designation_id` bigint(20) UNSIGNED NOT NULL,
  `skill_paint_id` bigint(20) UNSIGNED NOT NULL,
  `skill_polish_id` bigint(20) UNSIGNED NOT NULL,
  `salary` decimal(10,2) NOT NULL,
  `photograph` varchar(255) DEFAULT NULL,
  `pan` varchar(255) DEFAULT NULL,
  `aadhaar` varchar(255) DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `emp_id`, `employee_type_id`, `name`, `phone`, `email`, `gender_id`, `blood_group_id`, `date_of_birth`, `address`, `joining_date`, `department_id`, `designation_id`, `skill_paint_id`, `skill_polish_id`, `salary`, `photograph`, `pan`, `aadhaar`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'HG93317', 1, 'Salman Khan', '123456789', 'sakman@gmail.com', 1, 4, '1973-11-12', '123 street', '2023-08-29', 1, 4, 1, 2, '123000.00', 'employees/HG93317/photograph.jpg', 'employees/HG93317/pan.jpg', 'employees/HG93317/aadhaar.jpg', 1, 1, '2023-09-04 14:04:37', '2023-09-04 14:04:37');

-- --------------------------------------------------------

--
-- Table structure for table `employee_bank_accounts`
--

CREATE TABLE `employee_bank_accounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `emp_id` bigint(20) UNSIGNED NOT NULL,
  `bank_name` varchar(255) NOT NULL,
  `branch` varchar(255) NOT NULL,
  `ifsc` varchar(255) NOT NULL,
  `account_name` varchar(255) NOT NULL,
  `account_number` varchar(255) NOT NULL,
  `upi` varchar(255) DEFAULT NULL,
  `phonepe` varchar(255) DEFAULT NULL,
  `googlepay` varchar(255) DEFAULT NULL,
  `paytm` varchar(255) DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employee_bank_accounts`
--

INSERT INTO `employee_bank_accounts` (`id`, `emp_id`, `bank_name`, `branch`, `ifsc`, `account_name`, `account_number`, `upi`, `phonepe`, `googlepay`, `paytm`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 1, 'Axis', 'Hyd', '12121212', 'Sakman', '875548755475', 'example', 'example', 'example', 'example', 1, 1, '2023-09-04 14:05:43', '2023-09-04 14:05:43');

-- --------------------------------------------------------

--
-- Table structure for table `employee_types`
--

CREATE TABLE `employee_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employee_types`
--

INSERT INTO `employee_types` (`id`, `name`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'Permanent', 1, 1, '2023-09-04 12:29:47', '2023-09-04 12:29:47'),
(2, 'Contract', 1, 1, '2023-09-04 12:29:55', '2023-09-04 12:29:55'),
(3, 'Temporary', 1, 1, '2023-09-04 12:30:03', '2023-09-04 12:30:03'),
(4, 'Daily Laborer', 1, 1, '2023-09-04 12:30:11', '2023-09-04 12:30:11'),
(5, 'Part-Time', 1, 1, '2023-09-04 12:30:19', '2023-09-04 12:30:19'),
(6, 'Intern/Apprentice', 1, 1, '2023-09-04 12:30:33', '2023-09-04 12:30:33'),
(7, 'Seasonal', 1, 1, '2023-09-04 12:30:42', '2023-09-04 12:30:42'),
(8, 'Freelancer/Independent Contractor', 1, 1, '2023-09-04 12:30:51', '2023-09-04 12:30:51'),
(9, 'Consultant', 1, 1, '2023-09-04 12:30:58', '2023-09-04 12:30:58'),
(10, 'Casual Labor', 1, 1, '2023-09-04 12:31:09', '2023-09-04 12:31:09');

-- --------------------------------------------------------

--
-- Table structure for table `employee_user`
--

CREATE TABLE `employee_user` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employee_user`
--

INSERT INTO `employee_user` (`id`, `employee_id`, `user_id`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 1, 6, 1, 1, '2023-09-04 14:05:01', '2023-09-04 14:05:01');

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
-- Table structure for table `genders`
--

CREATE TABLE `genders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `genders`
--

INSERT INTO `genders` (`id`, `name`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'Male', 1, 1, '2023-09-04 12:44:41', '2023-09-04 12:44:41'),
(2, 'Female', 1, 1, '2023-09-04 12:44:47', '2023-09-04 12:44:47'),
(3, 'Non-Binary', 1, 1, '2023-09-04 12:44:55', '2023-09-04 12:44:55'),
(4, 'Genderqueer', 1, 1, '2023-09-04 12:45:03', '2023-09-04 12:45:03'),
(5, 'Genderfluid', 1, 1, '2023-09-04 12:45:11', '2023-09-04 12:45:11'),
(6, 'Agender', 1, 1, '2023-09-04 12:45:18', '2023-09-04 12:45:18'),
(7, 'Bigender', 1, 1, '2023-09-04 12:45:28', '2023-09-04 12:45:28'),
(8, 'Two-Spirit', 1, 1, '2023-09-04 12:45:36', '2023-09-04 12:45:36'),
(9, 'Androgynous', 1, 1, '2023-09-04 12:45:42', '2023-09-04 12:45:42'),
(10, 'Transgender', 1, 1, '2023-09-04 12:45:50', '2023-09-04 12:45:50'),
(11, 'Cisgender', 1, 1, '2023-09-04 12:45:57', '2023-09-04 12:45:57'),
(12, 'Demigender', 1, 1, '2023-09-04 12:46:05', '2023-09-04 12:46:05'),
(13, 'Neutrois', 1, 1, '2023-09-04 12:46:13', '2023-09-04 12:46:13'),
(14, 'Pangender', 1, 1, '2023-09-04 12:46:20', '2023-09-04 12:46:20'),
(15, 'Third Gender', 1, 1, '2023-09-04 12:46:30', '2023-09-04 12:46:30'),
(16, 'Other', 1, 1, '2023-09-04 12:46:37', '2023-09-04 12:46:37');

-- --------------------------------------------------------

--
-- Table structure for table `inventories`
--

CREATE TABLE `inventories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `inventory_status_id` bigint(20) UNSIGNED NOT NULL,
  `inventory_type_id` bigint(20) UNSIGNED NOT NULL,
  `vendor_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `cost` text DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `project_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `inventories`
--

INSERT INTO `inventories` (`id`, `inventory_status_id`, `inventory_type_id`, `vendor_id`, `title`, `description`, `cost`, `created_by`, `updated_by`, `created_at`, `updated_at`, `project_id`) VALUES
(1, 1, 1, 1, 'Paint', 'Test', '12000', 1, 1, '2023-09-04 14:25:01', '2023-09-05 07:29:56', 1);

-- --------------------------------------------------------

--
-- Table structure for table `inventory_statuses`
--

CREATE TABLE `inventory_statuses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `inventory_statuses`
--

INSERT INTO `inventory_statuses` (`id`, `name`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'In Stock', 1, 1, '2023-09-04 12:08:36', '2023-09-04 12:08:36'),
(2, 'Out of Stock', 1, 1, '2023-09-04 12:08:47', '2023-09-04 12:08:47'),
(3, 'Low Stock', 1, 1, '2023-09-04 12:09:24', '2023-09-04 12:09:24'),
(4, 'On Order', 1, 1, '2023-09-04 12:10:07', '2023-09-04 12:10:07'),
(6, 'Reserved', 1, 1, '2023-09-04 12:10:48', '2023-09-04 12:10:48'),
(7, 'Damaged', 1, 1, '2023-09-04 12:10:55', '2023-09-04 12:10:55'),
(8, 'Expired', 1, 1, '2023-09-04 12:11:02', '2023-09-04 12:11:02'),
(9, 'Pending Inspection', 1, 1, '2023-09-04 12:11:09', '2023-09-04 12:11:09'),
(10, 'Disposed', 1, 1, '2023-09-04 12:11:16', '2023-09-04 12:11:16'),
(11, 'Transferred', 1, 1, '2023-09-04 12:11:24', '2023-09-04 12:11:24'),
(12, 'Stolen or Lost', 1, 1, '2023-09-04 12:11:34', '2023-09-04 12:11:34'),
(13, 'Blocked', 1, 1, '2023-09-04 12:11:40', '2023-09-04 12:11:40'),
(14, 'Unallocated', 1, 1, '2023-09-04 12:11:48', '2023-09-04 12:11:48'),
(15, 'Reorder Point', 1, 1, '2023-09-04 12:11:58', '2023-09-04 12:11:58');

-- --------------------------------------------------------

--
-- Table structure for table `inventory_types`
--

CREATE TABLE `inventory_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `inventory_types`
--

INSERT INTO `inventory_types` (`id`, `name`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'Paint and Coatings', 1, 1, '2023-09-04 12:06:50', '2023-09-04 12:06:50'),
(2, 'Painting Supplies', 1, 1, '2023-09-04 12:06:59', '2023-09-04 12:06:59'),
(3, 'Surface Preparation Materials', 1, 1, '2023-09-04 12:07:08', '2023-09-04 12:07:08'),
(4, 'Safety Equipment', 1, 1, '2023-09-04 12:07:17', '2023-09-04 12:07:17'),
(5, 'Ladders and Scaffolding', 1, 1, '2023-09-04 12:07:25', '2023-09-04 12:07:25'),
(6, 'Color Samples', 1, 1, '2023-09-04 12:07:38', '2023-09-04 12:07:38'),
(7, 'Cleaning and Maintenance Products', 1, 1, '2023-09-04 12:07:45', '2023-09-04 12:07:45'),
(8, 'Sprayers and Equipment', 1, 1, '2023-09-04 12:07:56', '2023-09-04 12:07:56'),
(9, 'Drop Cloth and Coverings', 1, 1, '2023-09-04 12:08:05', '2023-09-04 12:08:05'),
(10, 'Miscellaneous', 1, 1, '2023-09-04 12:08:13', '2023-09-04 12:08:13');

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `lead_id` bigint(20) UNSIGNED NOT NULL,
  `invoice_type_id` bigint(20) UNSIGNED NOT NULL,
  `invoice_status_id` bigint(20) UNSIGNED NOT NULL,
  `value` decimal(20,2) NOT NULL,
  `attachments` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`attachments`)),
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `invoices`
--

INSERT INTO `invoices` (`id`, `lead_id`, `invoice_type_id`, `invoice_status_id`, `value`, `attachments`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 5, '2500.00', '[\"invoices\\/1_64f627f8ee439.pdf\"]', 1, 1, '2023-09-04 13:24:49', '2023-09-04 13:34:15'),
(2, 2, 1, 2, '1212.00', NULL, 3, 3, '2023-09-06 06:02:50', '2023-09-06 06:02:50');

-- --------------------------------------------------------

--
-- Table structure for table `invoice_statuses`
--

CREATE TABLE `invoice_statuses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `invoice_statuses`
--

INSERT INTO `invoice_statuses` (`id`, `name`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'Draft', 1, 1, '2023-09-04 11:45:54', '2023-09-04 11:45:54'),
(2, 'Sent', 1, 1, '2023-09-04 11:46:03', '2023-09-04 11:46:03'),
(3, 'Pending', 1, 1, '2023-09-04 11:46:12', '2023-09-04 11:46:12'),
(4, 'Partially Paid', 1, 1, '2023-09-04 11:46:19', '2023-09-04 11:46:19'),
(5, 'Paid', 1, 1, '2023-09-04 11:46:28', '2023-09-04 11:46:28'),
(6, 'Overdue', 1, 1, '2023-09-04 11:46:37', '2023-09-04 11:46:37'),
(7, 'Void', 1, 1, '2023-09-04 11:46:47', '2023-09-04 11:46:47'),
(8, 'Refunded', 1, 1, '2023-09-04 11:46:55', '2023-09-04 11:46:55'),
(9, 'Approved', 1, 1, '2023-09-04 11:47:03', '2023-09-04 11:47:03'),
(10, 'Disputed', 1, 1, '2023-09-04 11:47:10', '2023-09-04 11:47:10');

-- --------------------------------------------------------

--
-- Table structure for table `invoice_types`
--

CREATE TABLE `invoice_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `invoice_types`
--

INSERT INTO `invoice_types` (`id`, `name`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'Standard Invoice', 1, 1, '2023-09-04 11:44:13', '2023-09-04 11:44:13'),
(2, 'Proforma Invoice', 1, 1, '2023-09-04 11:44:21', '2023-09-04 11:44:21'),
(3, 'Recurring Invoice', 1, 1, '2023-09-04 11:44:29', '2023-09-04 11:44:29'),
(4, 'Credit Invoice (Credit Note)', 1, 1, '2023-09-04 11:44:39', '2023-09-04 11:44:39'),
(5, 'Debit Invoice (Debit Note)', 1, 1, '2023-09-04 11:44:51', '2023-09-04 11:44:51'),
(6, 'Expense Report', 1, 1, '2023-09-04 11:45:00', '2023-09-04 11:45:00'),
(7, 'Progress Invoice', 1, 1, '2023-09-04 11:45:09', '2023-09-04 11:45:09'),
(8, 'Advance Payment Invoice', 1, 1, '2023-09-04 11:45:20', '2023-09-04 11:45:20'),
(9, 'Interest Invoice', 1, 1, '2023-09-04 11:45:29', '2023-09-04 11:45:29'),
(10, 'Consolidated Invoice', 1, 1, '2023-09-04 11:45:37', '2023-09-04 11:45:37');

-- --------------------------------------------------------

--
-- Table structure for table `leads`
--

CREATE TABLE `leads` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `lead_source_id` bigint(20) UNSIGNED DEFAULT NULL,
  `lead_status_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `zip` varchar(255) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `contact_method_id` bigint(20) UNSIGNED DEFAULT NULL,
  `contact_language_id` bigint(20) UNSIGNED DEFAULT NULL,
  `assignee_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `leads`
--

INSERT INTO `leads` (`id`, `lead_source_id`, `lead_status_id`, `name`, `phone`, `email`, `address`, `city`, `state`, `zip`, `notes`, `contact_method_id`, `contact_language_id`, `assignee_id`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 1, 6, 'John Mathew', '1234567890', 'john@gmail.com', '123 street', 'Hyderabad', 'Telangana', '500020', NULL, 12, 1, 4, 1, 1, '2023-09-04 13:10:27', '2023-09-04 13:34:47'),
(2, 5, 4, 'Kevin', '1234567890', 'kevin@gmail.com', '123 street', 'Chennai', 'Tamil Nadu', '512232', NULL, 4, 2, 3, 1, 3, '2023-09-04 13:13:11', '2023-09-06 06:00:06');

-- --------------------------------------------------------

--
-- Table structure for table `lead_sources`
--

CREATE TABLE `lead_sources` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lead_sources`
--

INSERT INTO `lead_sources` (`id`, `name`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'Website', 1, 1, '2023-09-04 11:31:51', '2023-09-04 11:35:59'),
(4, 'Referrals', 1, 1, '2023-09-04 11:36:52', '2023-09-04 11:36:52'),
(5, 'Social Media', 1, 1, '2023-09-04 11:37:05', '2023-09-04 11:37:05'),
(6, 'Email Marketing', 1, 1, '2023-09-04 11:37:16', '2023-09-04 11:37:16'),
(7, 'Cold Calling', 1, 1, '2023-09-04 11:37:25', '2023-09-04 11:37:25'),
(8, 'Trade Shows/Events', 1, 1, '2023-09-04 11:37:39', '2023-09-04 11:37:39'),
(9, 'Content Marketing', 1, 1, '2023-09-04 11:37:49', '2023-09-04 11:37:49'),
(10, 'Advertising', 1, 1, '2023-09-04 11:37:58', '2023-09-04 11:37:58'),
(11, 'Word of Mouth', 1, 1, '2023-09-04 11:38:12', '2023-09-04 11:38:12'),
(12, 'Inbound Marketing', 1, 1, '2023-09-04 11:38:23', '2023-09-04 11:38:23');

-- --------------------------------------------------------

--
-- Table structure for table `lead_statuses`
--

CREATE TABLE `lead_statuses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lead_statuses`
--

INSERT INTO `lead_statuses` (`id`, `name`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(3, 'New Lead', 1, 1, '2023-09-04 11:39:43', '2023-09-04 11:39:43'),
(4, 'Contacted', 1, 1, '2023-09-04 11:39:53', '2023-09-04 11:39:53'),
(5, 'Qualified Lead', 1, 1, '2023-09-04 11:40:05', '2023-09-04 11:40:05'),
(6, 'Converted', 1, 1, '2023-09-04 11:40:14', '2023-09-04 11:40:14'),
(7, 'Closed Lost', 1, 1, '2023-09-04 11:40:24', '2023-09-04 11:40:24'),
(8, 'On Hold', 1, 1, '2023-09-04 11:40:33', '2023-09-04 11:40:33'),
(9, 'Follow-up', 1, 1, '2023-09-04 11:40:43', '2023-09-04 11:40:43'),
(10, 'Negotiation', 1, 1, '2023-09-04 11:40:52', '2023-09-04 11:40:52'),
(11, 'Pending Approval', 1, 1, '2023-09-04 11:41:01', '2023-09-04 11:41:01'),
(12, 'Referred', 1, 1, '2023-09-04 11:41:10', '2023-09-04 11:41:10');

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
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2014_10_12_100000_create_password_resets_table', 1),
(4, '2019_08_19_000000_create_failed_jobs_table', 1),
(5, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(6, '2023_08_16_093500_laratrust_setup_tables', 1),
(7, '2023_08_17_091928_create_lead_sources_table', 1),
(8, '2023_08_17_091942_create_lead_statuses_table', 1),
(9, '2023_08_17_125423_create_contact_methods_table', 1),
(10, '2023_08_17_125436_create_contact_languages_table', 1),
(11, '2023_08_17_141050_create_leads_table', 1),
(12, '2023_08_19_102301_create_invoice_types_table', 1),
(13, '2023_08_19_102324_create_invoice_statuses_table', 1),
(14, '2023_08_19_102545_create_bill_types_table', 1),
(15, '2023_08_19_102554_create_bill_statuses_table', 1),
(16, '2023_08_19_102622_create_payment_methods_table', 1),
(17, '2023_08_19_102640_create_payment_statuses_table', 1),
(18, '2023_08_19_102701_create_inventory_types_table', 1),
(19, '2023_08_19_102715_create_inventory_statuses_table', 1),
(20, '2023_08_19_102739_create_vendor_types_table', 1),
(21, '2023_08_19_102805_create_vendor_statuses_table', 1),
(22, '2023_08_19_102910_create_employee_types_table', 1),
(23, '2023_08_19_102920_create_designations_table', 1),
(24, '2023_08_19_102930_create_departments_table', 1),
(25, '2023_08_19_103020_create_blood_groups_table', 1),
(26, '2023_08_19_103035_create_genders_table', 1),
(27, '2023_08_19_103204_create_project_types_table', 1),
(28, '2023_08_19_103218_create_project_statuses_table', 1),
(29, '2023_08_20_081142_create_skills_table', 1),
(30, '2023_08_20_083101_create_invoices_table', 1),
(31, '2023_08_20_083148_create_customers_table', 1),
(32, '2023_08_21_092107_create_projects_table', 1),
(33, '2023_08_21_092150_create_activity_types_table', 1),
(34, '2023_08_21_093114_create_activities_table', 1),
(35, '2023_08_21_140012_create_employees_table', 1),
(36, '2023_08_21_141529_create_employee_bank_accounts_table', 1),
(37, '2023_08_23_081923_create_employee_user_table', 1),
(38, '2023_08_23_082143_create_vendors_table', 1),
(39, '2023_08_23_082305_create_vendor_users_table', 1),
(40, '2023_08_23_082526_create_inventories_table', 1),
(41, '2023_08_23_083136_create_attendance_statuses_table', 1),
(42, '2023_08_23_085139_create_attendance_types_table', 1),
(43, '2023_08_23_091113_create_attendance_records_table', 1),
(44, '2023_08_29_120630_create_ticket_categories_table', 1),
(45, '2023_08_29_120649_create_tickets_table', 1),
(46, '2023_08_30_185955_create_attachment_types_table', 1),
(47, '2023_08_30_190109_create_attachments_table', 1),
(48, '2023_08_31_091849_create_bills_table', 1),
(49, '2023_08_31_091900_create_payments_table', 1),
(50, '2023_09_05_123252_add_project_id_to_inventories', 2),
(51, '2023_09_06_123320_add_labor_cost_to_projects', 3),
(52, '2023_09_06_125237_add_previous_leftover_material_cost_to_projects', 4),
(53, '2023_09_06_125513_add_administrative_cost_to_projects', 5),
(54, '2023_09_06_125602_add_invoice_value_to_projects', 5);

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
  `reference` varchar(255) DEFAULT NULL,
  `payment_method_id` bigint(20) UNSIGNED NOT NULL,
  `payment_status_id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `project_id` bigint(20) UNSIGNED DEFAULT NULL,
  `amount` decimal(20,2) NOT NULL,
  `notes` text DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `reference`, `payment_method_id`, `payment_status_id`, `customer_id`, `project_id`, `amount`, `notes`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, '12345', 2, 4, 1, 1, '12542.00', 'Test', 1, 1, '2023-09-04 13:55:24', '2023-09-04 13:55:24'),
(2, '123123', 6, 4, 2, 2, '12121.00', 'Test', 3, 3, '2023-09-06 06:05:18', '2023-09-06 06:05:18');

-- --------------------------------------------------------

--
-- Table structure for table `payment_methods`
--

CREATE TABLE `payment_methods` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payment_methods`
--

INSERT INTO `payment_methods` (`id`, `name`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'Credit Card', 1, 1, '2023-09-04 11:50:04', '2023-09-04 11:50:04'),
(2, 'Debit Card', 1, 1, '2023-09-04 11:50:12', '2023-09-04 11:50:12'),
(3, 'Bank Transfer (ACH)', 1, 1, '2023-09-04 11:50:22', '2023-09-04 11:50:22'),
(4, 'PayPal', 1, 1, '2023-09-04 11:50:28', '2023-09-04 11:50:28'),
(5, 'Check', 1, 1, '2023-09-04 11:50:35', '2023-09-04 11:50:35'),
(6, 'Cash', 1, 1, '2023-09-04 11:50:42', '2023-09-04 11:50:42'),
(7, 'Wire Transfer', 1, 1, '2023-09-04 11:50:49', '2023-09-04 11:50:49'),
(8, 'Online Payment Gateways', 1, 1, '2023-09-04 11:50:58', '2023-09-04 11:50:58'),
(9, 'Mobile Wallet', 1, 1, '2023-09-04 11:51:09', '2023-09-04 11:51:09'),
(10, 'Cryptocurrency', 1, 1, '2023-09-04 11:51:19', '2023-09-04 11:51:19'),
(11, 'Electronic Funds Transfer (EFT)', 1, 1, '2023-09-04 11:51:29', '2023-09-04 11:51:29'),
(12, 'Payment Plan', 1, 1, '2023-09-04 11:51:37', '2023-09-04 11:51:37'),
(13, 'Cash on Delivery (COD)', 1, 1, '2023-09-04 11:51:46', '2023-09-04 11:51:46');

-- --------------------------------------------------------

--
-- Table structure for table `payment_statuses`
--

CREATE TABLE `payment_statuses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payment_statuses`
--

INSERT INTO `payment_statuses` (`id`, `name`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'Pending', 1, 1, '2023-09-04 11:48:21', '2023-09-04 11:48:21'),
(2, 'Authorized', 1, 1, '2023-09-04 11:48:30', '2023-09-04 11:48:30'),
(3, 'In Progress', 1, 1, '2023-09-04 11:48:39', '2023-09-04 11:48:39'),
(4, 'Completed', 1, 1, '2023-09-04 11:48:46', '2023-09-04 11:48:46'),
(5, 'Partially Paid', 1, 1, '2023-09-04 11:48:54', '2023-09-04 11:48:54'),
(6, 'Failed', 1, 1, '2023-09-04 11:49:02', '2023-09-04 11:49:02'),
(7, 'Refunded', 1, 1, '2023-09-04 11:49:09', '2023-09-04 11:49:09'),
(8, 'Voided', 1, 1, '2023-09-04 11:49:17', '2023-09-04 11:49:17'),
(9, 'Settled', 1, 1, '2023-09-04 11:49:27', '2023-09-04 11:49:27'),
(10, 'Overdue', 1, 1, '2023-09-04 11:49:34', '2023-09-04 11:49:34'),
(11, 'Disputed', 1, 1, '2023-09-04 11:49:43', '2023-09-04 11:49:43');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `display_name` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `display_name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'create-users', 'Create Users', NULL, '2023-08-16 04:08:51', '2023-08-16 04:08:51'),
(2, 'read-users', 'Read Users', NULL, '2023-08-16 04:09:14', '2023-08-16 04:09:14'),
(3, 'update-users', 'Update Users', NULL, '2023-08-16 04:09:31', '2023-08-16 04:09:31'),
(4, 'delete-users', 'Delete Users', NULL, '2023-08-16 04:09:49', '2023-08-16 04:09:49'),
(5, 'manage-users', 'Manage Users', NULL, '2023-08-16 22:45:58', '2023-08-16 22:45:58'),
(6, 'manage-lead-source', 'Manage Lead Source', NULL, '2023-08-16 23:19:08', '2023-08-16 23:19:08'),
(7, 'create-lead-source', 'Create Lead Source', NULL, '2023-08-16 23:34:49', '2023-08-16 23:34:49'),
(8, 'read-lead-source', 'Read Lead Source', NULL, '2023-08-16 23:35:10', '2023-08-16 23:35:10'),
(9, 'update-lead-source', 'Update Lead Source', NULL, '2023-08-16 23:35:29', '2023-08-16 23:35:29'),
(10, 'delete-lead-source', 'Delete Lead Source', NULL, '2023-08-16 23:35:45', '2023-08-16 23:35:45'),
(11, 'manage-lead-status', 'Manage Lead Status', NULL, '2023-08-16 23:51:50', '2023-08-16 23:51:50'),
(12, 'create-lead-status', 'Create Lead Status', NULL, '2023-08-16 23:52:50', '2023-08-16 23:52:50'),
(13, 'read-lead-status', 'Read Lead Status', NULL, '2023-08-16 23:53:36', '2023-08-16 23:53:36'),
(14, 'update-lead-status', 'Update Lead Status', NULL, '2023-08-16 23:54:18', '2023-08-16 23:54:18'),
(15, 'delete-lead-status', 'Delete Lead Status', NULL, '2023-08-16 23:55:01', '2023-08-16 23:55:01'),
(16, 'manage-contact-language', 'Manage Contact Language', NULL, '2023-08-17 02:01:44', '2023-08-17 02:01:44'),
(17, 'create-contact-language', 'Create Contact Language', NULL, '2023-08-17 02:01:55', '2023-08-17 02:01:55'),
(19, 'read-contact-language', 'Read Contact Language', NULL, '2023-08-17 02:04:26', '2023-08-17 02:04:26'),
(20, 'update-contact-language', 'Update Contact Language', NULL, '2023-08-17 02:04:37', '2023-08-17 02:04:37'),
(21, 'delete-contact-language', 'Delete Contact Language', NULL, '2023-08-17 02:04:49', '2023-08-17 02:04:49'),
(22, 'manage-contact-method', 'Manage Contact Method', NULL, '2023-08-17 02:04:59', '2023-08-17 02:04:59'),
(23, 'create-contact-method', 'Create Contact Method', NULL, '2023-08-17 02:05:09', '2023-08-17 02:05:09'),
(24, 'read-contact-method', 'Read Contact Method', NULL, '2023-08-17 02:05:19', '2023-08-17 02:05:19'),
(25, 'update-contact-method', 'Update Contact Method', NULL, '2023-08-17 02:05:29', '2023-08-17 02:05:29'),
(26, 'delete-contact-method', 'Delete Contact Method', NULL, '2023-08-17 02:05:38', '2023-08-17 02:05:38'),
(27, 'manage-lead', 'Manage Lead', NULL, '2023-08-17 04:44:39', '2023-08-17 04:44:39'),
(28, 'create-lead', 'Create Lead', NULL, '2023-08-17 04:44:48', '2023-08-17 04:44:48'),
(29, 'read-lead', 'Read Lead', NULL, '2023-08-17 04:44:56', '2023-08-17 04:44:56'),
(30, 'update-lead', 'Update Lead', NULL, '2023-08-17 04:45:04', '2023-08-17 04:45:04'),
(31, 'delete-lead', 'Delete Lead', NULL, '2023-08-17 04:45:12', '2023-08-17 04:45:12'),
(32, 'manage-bill-status', 'Manage Bill Status', NULL, '2023-08-19 00:08:30', '2023-08-19 00:08:30'),
(33, 'create-bill-status', 'Create Bill Status', NULL, '2023-08-19 00:08:40', '2023-08-19 00:08:40'),
(34, 'read-bill-status', 'Read Bill Status', NULL, '2023-08-19 00:08:48', '2023-08-19 00:08:48'),
(35, 'update-bill-status', 'Update Bill Status', NULL, '2023-08-19 00:08:56', '2023-08-19 00:08:56'),
(36, 'delete-bill-status', 'Delete Bill Status', NULL, '2023-08-19 00:09:07', '2023-08-19 00:09:07'),
(37, 'manage-bill-type', 'Manage Bill Type', NULL, '2023-08-19 00:09:19', '2023-08-19 00:09:19'),
(38, 'create-bill-type', 'Create Bill Type', NULL, '2023-08-19 00:09:28', '2023-08-19 00:09:28'),
(39, 'read-bill-type', 'Read Bill Type', NULL, '2023-08-19 00:09:37', '2023-08-19 00:09:37'),
(40, 'update-bill-type', 'Update Bill Type', NULL, '2023-08-19 00:09:47', '2023-08-19 00:09:47'),
(41, 'delete-bill-type', 'Delete Bill Type', NULL, '2023-08-19 00:09:57', '2023-08-19 00:09:57'),
(42, 'manage-blood-group', 'Manage Blood Group', NULL, '2023-08-19 00:12:42', '2023-08-19 00:12:42'),
(43, 'create-blood-group', 'Create Blood Group', NULL, '2023-08-19 00:13:00', '2023-08-19 00:13:00'),
(44, 'read-blood-group', 'Read Blood Group', NULL, '2023-08-19 00:13:09', '2023-08-19 00:13:09'),
(45, 'update-blood-group', 'Update Blood Group', NULL, '2023-08-19 00:13:24', '2023-08-19 00:13:24'),
(46, 'delete-blood-group', 'Delete Blood Group', NULL, '2023-08-19 00:13:34', '2023-08-19 00:13:34'),
(47, 'manage-department', 'Manage Department', NULL, '2023-08-19 00:29:32', '2023-08-19 00:29:32'),
(48, 'create-department', 'Create Department', NULL, '2023-08-19 00:29:40', '2023-08-19 00:29:40'),
(49, 'read-department', 'Read Department', NULL, '2023-08-19 00:29:48', '2023-08-19 00:29:48'),
(50, 'update-department', 'Update Department', NULL, '2023-08-19 00:29:58', '2023-08-19 00:29:58'),
(51, 'delete-department', 'Delete Department', NULL, '2023-08-19 00:30:07', '2023-08-19 00:30:07'),
(52, 'manage-designation', 'Manage Designation', NULL, '2023-08-19 00:30:54', '2023-08-19 00:30:54'),
(53, 'create-designation', 'Create Designation', NULL, '2023-08-19 00:31:00', '2023-08-19 00:31:00'),
(54, 'read-designation', 'Read Designation', NULL, '2023-08-19 00:31:10', '2023-08-19 00:31:10'),
(55, 'update-designation', 'Update Designation', NULL, '2023-08-19 00:31:17', '2023-08-19 00:31:17'),
(56, 'delete-designation', 'Delete Designation', NULL, '2023-08-19 00:31:22', '2023-08-19 00:31:22'),
(57, 'manage-gender', 'Manage Gender', NULL, '2023-08-19 02:13:34', '2023-08-19 02:13:34'),
(58, 'create-gender', 'Create Gender', NULL, '2023-08-19 02:13:43', '2023-08-19 02:13:43'),
(59, 'read-gender', 'Read Gender', NULL, '2023-08-19 02:13:51', '2023-08-19 02:13:51'),
(60, 'update-gender', 'Update Gender', NULL, '2023-08-19 02:13:58', '2023-08-19 02:13:58'),
(61, 'delete-gender', 'Delete Gender', NULL, '2023-08-19 02:14:06', '2023-08-19 02:14:06'),
(62, 'manage-inventory-status', 'Manage Inventory Status', NULL, '2023-08-19 02:46:21', '2023-08-19 02:46:21'),
(63, 'create-inventory-status', 'Create Inventory Status', NULL, '2023-08-19 02:46:30', '2023-08-19 02:46:30'),
(64, 'read-inventory-status', 'Read Inventory Status', NULL, '2023-08-19 02:46:37', '2023-08-19 02:46:37'),
(65, 'update-inventory-status', 'Update Inventory Status', NULL, '2023-08-19 02:46:49', '2023-08-19 02:46:49'),
(66, 'delete-inventory-status', 'Delete Inventory Status', NULL, '2023-08-19 02:46:56', '2023-08-19 02:46:56'),
(67, 'manage-inventory-type', 'Manage Inventory Type', NULL, '2023-08-19 02:47:13', '2023-08-19 02:47:13'),
(68, 'create-inventory-type', 'Create Inventory Type', NULL, '2023-08-19 02:47:22', '2023-08-19 02:47:22'),
(69, 'read-inventory-type', 'Read Inventory Type', NULL, '2023-08-19 02:47:27', '2023-08-19 02:47:27'),
(70, 'update-inventory-type', 'Update Inventory Type', NULL, '2023-08-19 02:47:36', '2023-08-19 02:47:36'),
(71, 'delete-inventory-type', 'Delete Inventory Type', NULL, '2023-08-19 02:47:48', '2023-08-19 02:47:48'),
(72, 'manage-invoice-status', 'Manage Invoice Status', NULL, '2023-08-19 02:48:15', '2023-08-19 02:48:15'),
(73, 'create-invoice-status', 'Create Invoice Status', NULL, '2023-08-19 02:48:24', '2023-08-19 02:48:24'),
(74, 'read-invoice-status', 'Read Invoice Status', NULL, '2023-08-19 02:48:30', '2023-08-19 02:48:30'),
(75, 'update-invoice-status', 'Update Invoice Status', NULL, '2023-08-19 02:48:38', '2023-08-19 02:48:38'),
(76, 'delete-invoice-status', 'Delete Invoice Status', NULL, '2023-08-19 02:48:44', '2023-08-19 02:48:44'),
(77, 'manage-invoice-type', 'Manage Invoice Type', NULL, '2023-08-19 02:56:35', '2023-08-19 02:56:35'),
(78, 'create-invoice-type', 'Create Invoice Type', NULL, '2023-08-19 02:56:45', '2023-08-19 02:56:45'),
(79, 'read-invoice-type', 'Read Invoice Type', NULL, '2023-08-19 02:56:51', '2023-08-19 02:56:51'),
(80, 'update-invoice-type', 'Update Invoice Type', NULL, '2023-08-19 02:56:57', '2023-08-19 02:56:57'),
(81, 'delete-invoice-type', 'Delete Invoice Type', NULL, '2023-08-19 02:57:04', '2023-08-19 02:57:04'),
(82, 'manage-employee-type', 'Manage Employee Type', NULL, '2023-08-19 02:57:17', '2023-08-19 02:57:17'),
(83, 'create-employee-type', 'Create Employee Type', NULL, '2023-08-19 02:57:24', '2023-08-19 02:57:24'),
(84, 'read-employee-type', 'Read Employee Type', NULL, '2023-08-19 02:57:30', '2023-08-19 02:57:30'),
(85, 'update-employee-type', 'Update Employee Type', NULL, '2023-08-19 02:57:38', '2023-08-19 02:57:38'),
(86, 'delete-employee-type', 'Delete Employee Type', NULL, '2023-08-19 02:57:43', '2023-08-19 02:57:43'),
(87, 'manage-payment-method', 'Manage Payment Method', NULL, '2023-08-19 18:18:11', '2023-08-19 18:18:11'),
(88, 'create-payment-method', 'Create Payment Method', NULL, '2023-08-19 18:18:20', '2023-08-19 18:18:20'),
(89, 'read-payment-method', 'Read Payment Method', NULL, '2023-08-19 18:18:31', '2023-08-19 18:18:31'),
(90, 'update-payment-method', 'Update Payment Method', NULL, '2023-08-19 18:18:37', '2023-08-19 18:18:37'),
(91, 'delete-payment-method', 'Delete Payment Method', NULL, '2023-08-19 18:18:43', '2023-08-19 18:18:43'),
(92, 'manage-payment-status', 'Manage Payment Status', NULL, '2023-08-19 18:19:09', '2023-08-19 18:19:09'),
(93, 'create-payment-status', 'Create Payment Status', NULL, '2023-08-19 18:19:16', '2023-08-19 18:19:16'),
(94, 'read-payment-status', 'Read Payment Status', NULL, '2023-08-19 18:19:21', '2023-08-19 18:19:21'),
(95, 'update-payment-status', 'Update Payment Status', NULL, '2023-08-19 18:19:27', '2023-08-19 18:19:27'),
(96, 'delete-payment-status', 'Delete Payment Status', NULL, '2023-08-19 18:19:33', '2023-08-19 18:19:33'),
(97, 'manage-project-type', 'Manage Project Type', NULL, '2023-08-19 18:20:16', '2023-08-19 18:20:16'),
(98, 'create-project-type', 'Create Project Type', NULL, '2023-08-19 18:20:21', '2023-08-19 18:20:21'),
(99, 'read-project-type', 'Read Project Type', NULL, '2023-08-19 18:20:26', '2023-08-19 18:20:26'),
(100, 'update-project-type', 'Update Project Type', NULL, '2023-08-19 18:20:33', '2023-08-19 18:20:33'),
(101, 'delete-project-type', 'Delete Project Type', NULL, '2023-08-19 18:20:39', '2023-08-19 18:20:39'),
(102, 'manage-project-status', 'Manage Project Status', NULL, '2023-08-19 18:20:54', '2023-08-19 18:20:54'),
(103, 'create-project-status', 'Create Project Status', NULL, '2023-08-19 18:21:00', '2023-08-19 18:21:00'),
(104, 'read-project-status', 'Read Project Status', NULL, '2023-08-19 18:21:07', '2023-08-19 18:21:07'),
(105, 'update-project-status', 'Update Project Status', NULL, '2023-08-19 18:21:13', '2023-08-19 18:21:13'),
(106, 'delete-project-status', 'Delete Project Status', NULL, '2023-08-19 18:21:19', '2023-08-19 18:21:19'),
(108, 'manage-vendor-type', 'Manage Vendor Type', NULL, '2023-08-19 18:23:12', '2023-08-19 18:23:12'),
(109, 'create-vendor-type', 'Create Vendor Type', NULL, '2023-08-19 18:23:19', '2023-08-19 18:23:19'),
(110, 'read-vendor-type', 'Read Vendor Type', NULL, '2023-08-19 18:23:32', '2023-08-19 18:23:32'),
(111, 'update-vendor-type', 'Update Vendor Type', NULL, '2023-08-19 18:23:38', '2023-08-19 18:23:38'),
(112, 'delete-vendor-type', 'Delete Vendor Type', NULL, '2023-08-19 18:23:43', '2023-08-19 18:23:43'),
(113, 'manage-vendor-status', 'Manage Vendor Status', NULL, '2023-08-19 18:23:54', '2023-08-19 18:23:54'),
(114, 'create-vendor-status', 'Create Vendor Status', NULL, '2023-08-19 18:24:01', '2023-08-19 18:24:01'),
(115, 'read-vendor-status', 'Read Vendor Status', NULL, '2023-08-19 18:24:07', '2023-08-19 18:24:07'),
(116, 'update-vendor-status', 'Update Vendor Status', NULL, '2023-08-19 18:24:13', '2023-08-19 18:24:13'),
(117, 'delete-vendor-status', 'Delete Vendor Status', NULL, '2023-08-19 18:24:19', '2023-08-19 18:24:19'),
(119, 'admin-menu', 'Admin Menu', NULL, '2023-08-19 18:43:47', '2023-08-19 19:01:28'),
(120, 'supervisor-menu', 'Supervisor Menu', NULL, '2023-08-19 18:44:00', '2023-08-19 18:44:00'),
(121, 'manager-menu', 'Manager Menu', NULL, '2023-08-19 18:55:00', '2023-08-19 18:55:00'),
(122, 'accounts-menu', 'Accounts Menu', NULL, '2023-08-19 18:55:12', '2023-08-19 18:55:12'),
(123, 'hr-menu', 'HR Menu', NULL, '2023-08-19 18:55:21', '2023-08-19 18:55:21'),
(124, 'employee-menu', 'Employee Menu', NULL, '2023-08-19 18:55:29', '2023-08-19 18:55:29'),
(125, 'vendor-menu', 'Vendor Menu', NULL, '2023-08-19 18:55:36', '2023-08-19 18:55:36'),
(126, 'client-menu', 'Client Menu', NULL, '2023-08-19 18:55:44', '2023-08-19 18:55:44'),
(127, 'admin-dashboard', 'Admin Dashboard', NULL, '2023-08-19 19:43:55', '2023-08-19 19:43:55'),
(128, 'manager-dashboard', 'Manager Dashboard', NULL, '2023-08-19 19:44:04', '2023-08-19 19:44:04'),
(129, 'supervisor-dashboard', 'Supervisor Dashboard', NULL, '2023-08-19 19:44:15', '2023-08-19 19:44:15'),
(130, 'accounts-dashboard', 'Accounts Dashboard', NULL, '2023-08-19 19:44:22', '2023-08-19 19:44:22'),
(131, 'hr-dashboard', 'HR Dashboard', NULL, '2023-08-19 19:44:31', '2023-08-19 19:44:31'),
(132, 'employee-dashboard', 'Employee Dashboard', NULL, '2023-08-19 19:44:40', '2023-08-19 19:44:40'),
(133, 'vendor-dashboard', 'Vendor Dashboard', NULL, '2023-08-19 19:44:47', '2023-08-19 19:44:47'),
(134, 'client-dashboard', 'Client Dashboard', NULL, '2023-08-19 19:44:59', '2023-08-19 19:44:59'),
(135, 'manage-skill', 'Manage Skill', NULL, '2023-08-19 21:26:45', '2023-08-19 21:26:45'),
(136, 'create-skill', 'Create Skill', NULL, '2023-08-19 21:26:51', '2023-08-19 21:26:51'),
(137, 'read-skill', 'Read Skill', NULL, '2023-08-19 21:26:58', '2023-08-19 21:26:58'),
(138, 'update-skill', 'Update Skill', NULL, '2023-08-19 21:27:05', '2023-08-19 21:27:05'),
(139, 'delete-skill', 'Delete Skill', NULL, '2023-08-19 21:27:13', '2023-08-19 21:27:13'),
(140, 'manage-invoice', 'Manage Invoice', NULL, '2023-08-19 22:04:02', '2023-08-19 22:04:02'),
(141, 'create-invoice', 'Create Invoice', NULL, '2023-08-19 22:04:09', '2023-08-19 22:04:09'),
(142, 'read-invoice', 'Read Invoice', NULL, '2023-08-19 22:04:14', '2023-08-19 22:04:14'),
(143, 'update-invoice', 'Update Invoice', NULL, '2023-08-19 22:04:21', '2023-08-19 22:04:21'),
(144, 'delete-invoice', 'Delete Invoice', NULL, '2023-08-19 22:04:29', '2023-08-19 22:04:29'),
(145, 'manage-customer', 'Manage Customer', NULL, '2023-08-19 22:05:13', '2023-08-19 22:05:13'),
(146, 'create-customer', 'Create Customer', NULL, '2023-08-19 22:05:20', '2023-08-19 22:05:20'),
(147, 'read-customer', 'Read Customer', NULL, '2023-08-19 22:05:26', '2023-08-19 22:05:26'),
(148, 'update-customer', 'Update Customer', NULL, '2023-08-19 22:05:32', '2023-08-19 22:05:32'),
(149, 'manage-project', 'Manage Project', NULL, '2023-08-20 04:41:06', '2023-08-20 04:41:06'),
(150, 'create-project', 'Create Project', NULL, '2023-08-20 04:41:30', '2023-08-20 04:41:30'),
(151, 'read-project', 'Read Project', NULL, '2023-08-20 04:41:37', '2023-08-20 04:41:37'),
(152, 'update-project', 'Update Project', NULL, '2023-08-20 04:41:45', '2023-08-20 04:41:45'),
(153, 'delete-project', 'Delete Project', NULL, '2023-08-20 04:41:53', '2023-08-20 04:41:53'),
(154, 'manage-bill', 'Manage Bill', NULL, '2023-08-20 04:42:12', '2023-08-20 04:42:12'),
(155, 'create-bill', 'Create  Bill', NULL, '2023-08-20 04:42:17', '2023-08-20 04:42:17'),
(156, 'read-bill', 'Read  Bill', NULL, '2023-08-20 04:42:23', '2023-08-20 04:42:23'),
(157, 'update-bill', 'Update  Bill', NULL, '2023-08-20 04:42:29', '2023-08-20 04:42:29'),
(158, 'delete-bill', 'Delete  Bill', NULL, '2023-08-20 04:42:35', '2023-08-20 04:42:35'),
(159, 'delete-customer', 'Delete Customer', NULL, '2023-08-20 18:15:35', '2023-08-20 18:15:35'),
(160, 'manage-activity-type', 'Manage Activity Type', NULL, '2023-08-20 23:04:47', '2023-08-20 23:04:47'),
(161, 'create-activity-type', 'Create Activity Type', NULL, '2023-08-20 23:04:57', '2023-08-20 23:04:57'),
(162, 'read-activity-type', 'Read Activity Type', NULL, '2023-08-20 23:05:06', '2023-08-20 23:05:06'),
(163, 'update-activity-type', 'Update Activity Type', NULL, '2023-08-20 23:05:13', '2023-08-20 23:05:13'),
(164, 'delete-activity-type', 'Delete Activity Type', NULL, '2023-08-20 23:05:19', '2023-08-20 23:05:19'),
(165, 'manage-activity', 'Manage Activity', NULL, '2023-08-20 23:29:13', '2023-08-20 23:29:13'),
(166, 'create-activity', 'Create Activity', NULL, '2023-08-20 23:29:19', '2023-08-20 23:29:19'),
(167, 'read-activity', 'Read Activity', NULL, '2023-08-20 23:29:25', '2023-08-20 23:29:25'),
(168, 'update-activity', 'Update Activity', NULL, '2023-08-20 23:29:32', '2023-08-20 23:29:32'),
(169, 'delete-activity', 'Delete Activity', NULL, '2023-08-20 23:29:37', '2023-08-20 23:29:37'),
(170, 'manage-employee', 'Manage Employee', NULL, '2023-08-21 03:21:51', '2023-08-21 03:21:51'),
(171, 'create-employee', 'Create Employee', NULL, '2023-08-21 03:21:58', '2023-08-21 03:21:58'),
(172, 'read-employee', 'Read Employee', NULL, '2023-08-21 03:22:04', '2023-08-21 03:22:04'),
(173, 'update-employee', 'Update Employee', NULL, '2023-08-21 03:22:10', '2023-08-21 03:22:10'),
(174, 'delete-employee', 'Delete Employee', NULL, '2023-08-21 03:22:17', '2023-08-21 03:22:17'),
(175, 'manage-employee-bank-account', 'Manage Employee Bank Account', NULL, '2023-08-21 03:22:36', '2023-08-21 03:22:36'),
(176, 'create-employee-bank-account', 'Create Employee Bank Account', NULL, '2023-08-21 03:22:42', '2023-08-21 03:22:42'),
(177, 'read-employee-bank-account', 'Read Employee Bank Account', NULL, '2023-08-21 03:22:47', '2023-08-21 03:22:47'),
(178, 'update-employee-bank-account', 'Update Employee Bank Account', NULL, '2023-08-21 03:22:55', '2023-08-21 03:22:55'),
(179, 'delete-employee-bank-account', 'Delete Employee Bank Account', NULL, '2023-08-21 03:23:01', '2023-08-21 03:23:01'),
(180, 'manage-attendance-type', 'Manage Attendance Type', NULL, '2023-08-22 23:11:35', '2023-08-22 23:11:35'),
(181, 'create-attendance-type', 'Create Attendance Type', NULL, '2023-08-22 23:11:41', '2023-08-22 23:11:41'),
(182, 'read-attendance-type', 'Read Attendance Type', NULL, '2023-08-22 23:11:47', '2023-08-22 23:11:47'),
(183, 'update-attendance-type', 'Update Attendance Type', NULL, '2023-08-22 23:11:54', '2023-08-22 23:11:54'),
(184, 'delete-attendance-type', 'Delete Attendance Type', NULL, '2023-08-22 23:12:02', '2023-08-22 23:12:02'),
(185, 'manage-attendance-status', 'Manage Attendance Status', NULL, '2023-08-22 23:12:18', '2023-08-22 23:12:18'),
(186, 'create-attendance-status', 'Create Attendance Status', NULL, '2023-08-22 23:12:24', '2023-08-22 23:12:24'),
(187, 'read-attendance-status', 'Read Attendance Status', NULL, '2023-08-22 23:12:31', '2023-08-22 23:12:31'),
(188, 'update-attendance-status', 'Update Attendance Status', NULL, '2023-08-22 23:12:37', '2023-08-22 23:12:37'),
(189, 'delete-attendance-status', 'Delete Attendance Status', NULL, '2023-08-22 23:12:44', '2023-08-22 23:12:44'),
(190, 'manage-employee-user', 'Manage Employee User', NULL, '2023-08-23 01:17:20', '2023-08-23 01:17:20'),
(191, 'create-employee-user', 'Create Employee User', NULL, '2023-08-23 01:17:25', '2023-08-23 01:17:25'),
(192, 'read-employee-user', 'Read Employee User', NULL, '2023-08-23 01:17:33', '2023-08-23 01:17:33'),
(193, 'update-employee-user', 'Update Employee User', NULL, '2023-08-23 01:17:39', '2023-08-23 01:17:39'),
(194, 'delete-employee-user', 'Delete Employee User', NULL, '2023-08-23 01:17:46', '2023-08-23 01:17:46'),
(195, 'manage-vendor', 'Manage Vendor', NULL, '2023-08-24 22:30:22', '2023-08-24 22:30:22'),
(196, 'create-vendor', 'Create Vendor', NULL, '2023-08-24 22:30:29', '2023-08-24 22:30:29'),
(197, 'read-vendor', 'Read Vendor', NULL, '2023-08-24 22:30:34', '2023-08-24 22:30:34'),
(198, 'update-vendor', 'Update Vendor', NULL, '2023-08-24 22:30:43', '2023-08-24 22:30:43'),
(199, 'delete-vendor', 'Delete Vendor', NULL, '2023-08-24 22:30:51', '2023-08-24 22:30:51'),
(200, 'manage-vendor-user', 'Manage Vendor User', NULL, '2023-08-24 22:31:06', '2023-08-24 22:31:06'),
(201, 'create-vendor-user', 'Create Vendor User', NULL, '2023-08-24 22:31:13', '2023-08-24 22:31:13'),
(202, 'read-vendor-user', 'Read Vendor User', NULL, '2023-08-24 22:31:19', '2023-08-24 22:31:19'),
(203, 'update-vendor-user', 'Update Vendor User', NULL, '2023-08-24 22:31:26', '2023-08-24 22:31:26'),
(204, 'delete-vendor-user', 'Delete Vendor User', NULL, '2023-08-24 22:31:32', '2023-08-24 22:31:32'),
(205, 'manage-ticket-category', 'Manage Ticket Category', NULL, '2023-08-29 01:44:44', '2023-08-29 01:44:44'),
(206, 'create-ticket-category', 'Create Ticket Category', NULL, '2023-08-29 01:44:49', '2023-08-29 01:44:49'),
(207, 'read-ticket-category', 'Read Ticket Category', NULL, '2023-08-29 01:44:54', '2023-08-29 01:44:54'),
(208, 'update-ticket-category', 'Update Ticket Category', NULL, '2023-08-29 01:45:00', '2023-08-29 01:45:00'),
(209, 'delete-ticket-category', 'Delete Ticket Category', NULL, '2023-08-29 01:45:06', '2023-08-29 01:45:06'),
(210, 'manage-ticket', 'Manage Ticket', NULL, '2023-08-29 01:46:15', '2023-08-29 01:46:15'),
(211, 'create-ticket', 'Create Ticket', NULL, '2023-08-29 01:46:27', '2023-08-29 01:46:27'),
(212, 'read-ticket', 'Read Ticket', NULL, '2023-08-29 01:46:33', '2023-08-29 01:46:33'),
(213, 'update-ticket', 'Update Ticket', NULL, '2023-08-29 01:46:39', '2023-08-29 01:46:39'),
(214, 'delete-ticket', 'Delete Ticket', NULL, '2023-08-29 01:46:45', '2023-08-29 01:46:45'),
(215, 'manage-inventory', 'Manage Inventory', NULL, '2023-08-30 01:35:41', '2023-08-30 01:35:41'),
(216, 'create-inventory', 'Create Inventory', NULL, '2023-08-30 01:35:47', '2023-08-30 01:35:47'),
(217, 'read-inventory', 'Read Inventory', NULL, '2023-08-30 01:35:53', '2023-08-30 01:35:53'),
(218, 'update-inventory', 'Update Inventory', NULL, '2023-08-30 01:36:01', '2023-08-30 01:36:01'),
(219, 'delete-inventory', 'Delete Inventory', NULL, '2023-08-30 01:36:08', '2023-08-30 01:36:08'),
(220, 'manage-attendance-record', 'Manage Attendance Record', NULL, '2023-08-30 02:38:48', '2023-08-30 02:38:48'),
(221, 'create-attendance-record', 'Create Attendance Record', NULL, '2023-08-30 02:38:56', '2023-08-30 02:38:56'),
(222, 'read-attendance-record', 'Read Attendance Record', NULL, '2023-08-30 02:39:02', '2023-08-30 02:39:02'),
(223, 'update-attendance-record', 'Update Attendance Record', NULL, '2023-08-30 02:39:18', '2023-08-30 02:39:18'),
(224, 'delete-attendance-record', 'Delete Attendance Record', NULL, '2023-08-30 02:39:26', '2023-08-30 02:39:26'),
(225, 'manage-attachment-type', 'Manage Attachment Type', NULL, '2023-08-30 08:24:43', '2023-08-30 08:24:43'),
(226, 'create-attachment-type', 'Create Attachment Type', NULL, '2023-08-30 08:24:50', '2023-08-30 08:24:50'),
(227, 'read-attachment-type', 'Read Attachment Type', NULL, '2023-08-30 08:24:56', '2023-08-30 08:24:56'),
(228, 'update-attachment-type', 'Update Attachment Type', NULL, '2023-08-30 08:25:04', '2023-08-30 08:25:04'),
(229, 'delete-attachment-type', 'Delete Attachment Type', NULL, '2023-08-30 08:25:11', '2023-08-30 08:25:11'),
(230, 'manage-attachment', 'Manage Attachment', NULL, '2023-08-30 08:37:05', '2023-08-30 08:37:05'),
(231, 'create-attachment', 'Create Attachment', NULL, '2023-08-30 08:37:11', '2023-08-30 08:37:11'),
(232, 'read-attachment', 'Read Attachment', NULL, '2023-08-30 08:37:19', '2023-08-30 08:37:19'),
(233, 'update-attachment', 'Update Attachment', NULL, '2023-08-30 08:37:27', '2023-08-30 08:37:27'),
(234, 'delete-attachment', 'Delete Attachment', NULL, '2023-08-30 08:37:35', '2023-08-30 08:37:35'),
(235, 'manage-payment', 'Manage Payment', NULL, '2023-08-30 23:28:50', '2023-08-30 23:28:50'),
(236, 'create-payment', 'Create Payment', NULL, '2023-08-30 23:28:56', '2023-08-30 23:28:56'),
(237, 'read-payment', 'Read Payment', NULL, '2023-08-30 23:29:04', '2023-08-30 23:29:04'),
(238, 'update-payment', 'Update Payment', NULL, '2023-08-30 23:29:10', '2023-08-30 23:29:10'),
(239, 'delete-payment', 'Delete Payment', NULL, '2023-08-30 23:29:16', '2023-08-30 23:29:16'),
(241, 'my-invoices', 'My Invoices', NULL, '2023-08-31 12:07:57', '2023-08-31 12:07:57'),
(242, 'my-projects', 'My Projects', NULL, '2023-08-31 14:14:23', '2023-08-31 14:14:23'),
(243, 'my-payments', 'My Payments', NULL, '2023-08-31 14:14:31', '2023-08-31 14:14:31'),
(244, 'my-tickets', 'My Tickets', NULL, '2023-08-31 14:14:40', '2023-08-31 14:14:40'),
(245, 'vendor-bills', 'Vendor Bills', NULL, '2023-08-31 21:59:48', '2023-08-31 21:59:48'),
(246, 'vendor-inventories', 'Vendor Inventories', NULL, '2023-08-31 21:59:59', '2023-08-31 21:59:59'),
(247, 'my-attendance', 'My Attendance', NULL, '2023-08-31 23:32:07', '2023-08-31 23:32:07'),
(248, 'employee-bills', 'Employee Bills', NULL, '2023-08-31 23:32:22', '2023-08-31 23:32:22'),
(249, 'employee-projects', 'Employee Projects', NULL, '2023-08-31 23:32:34', '2023-08-31 23:32:34'),
(250, 'my-bank-accounts', 'My Bank Accounts', NULL, '2023-08-31 23:32:47', '2023-08-31 23:32:47'),
(251, 'employee-profile', 'Employee Profile', NULL, '2023-09-01 00:03:59', '2023-09-01 00:03:59'),
(252, 'manage-my-tickets', 'Manage My Tickets', NULL, '2023-09-03 18:02:16', '2023-09-03 18:02:16'),
(253, 'create-my-tickets', 'Create My Tickets', NULL, '2023-09-03 18:02:33', '2023-09-03 18:02:33'),
(254, 'read-my-tickets', 'Read My Tickets', NULL, '2023-09-03 18:02:42', '2023-09-03 18:02:42'),
(255, 'update-my-tickets', 'Update My Tickets', NULL, '2023-09-03 18:02:50', '2023-09-03 18:02:50'),
(256, 'delete-my-tickets', 'Delete My Tickets', NULL, '2023-09-03 18:02:57', '2023-09-03 18:02:57'),
(257, 'manage-assigned-projects', 'Manage Assigned Projects', NULL, '2023-09-04 04:04:42', '2023-09-04 04:04:42'),
(258, 'create-assigned-projects', 'Create Assigned Projects', NULL, '2023-09-04 04:04:51', '2023-09-04 04:04:51'),
(259, 'read-assigned-projects', 'Read Assigned Projects', NULL, '2023-09-04 04:04:59', '2023-09-04 04:04:59'),
(260, 'update-assigned-projects', 'Update Assigned Projects', NULL, '2023-09-04 04:05:09', '2023-09-04 04:05:09'),
(261, 'delete-assigned-projects', 'Delete Assigned Projects', NULL, '2023-09-04 04:05:21', '2023-09-04 04:05:21'),
(262, 'manage-my-lead', 'Manage My Lead', NULL, '2023-09-06 00:31:52', '2023-09-06 00:31:52'),
(263, 'create-my-lead', 'Create My Lead', NULL, '2023-09-06 00:32:07', '2023-09-06 00:32:07'),
(264, 'read-my-lead', 'Read My Lead', NULL, '2023-09-06 00:32:22', '2023-09-06 00:32:22'),
(265, 'update-my-lead', 'Update My Lead', NULL, '2023-09-06 00:32:41', '2023-09-06 00:32:41'),
(266, 'delete-my-lead', 'Delete My Lead', NULL, '2023-09-06 00:32:54', '2023-09-06 00:32:54');

-- --------------------------------------------------------

--
-- Table structure for table `permission_role`
--

CREATE TABLE `permission_role` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permission_role`
--

INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES
(1, 10),
(1, 11),
(1, 12),
(1, 13),
(2, 10),
(2, 11),
(2, 12),
(2, 13),
(3, 10),
(3, 11),
(3, 12),
(3, 13),
(4, 10),
(4, 11),
(5, 10),
(5, 11),
(5, 12),
(5, 13),
(6, 10),
(6, 11),
(7, 10),
(7, 11),
(8, 10),
(8, 11),
(9, 10),
(9, 11),
(10, 10),
(10, 11),
(11, 10),
(11, 11),
(12, 10),
(12, 11),
(13, 10),
(13, 11),
(14, 10),
(14, 11),
(15, 10),
(15, 11),
(16, 10),
(16, 11),
(17, 10),
(17, 11),
(19, 10),
(19, 11),
(20, 10),
(20, 11),
(21, 10),
(21, 11),
(22, 10),
(22, 11),
(23, 10),
(23, 11),
(24, 10),
(24, 11),
(25, 10),
(25, 11),
(26, 10),
(26, 11),
(27, 10),
(27, 11),
(27, 12),
(27, 13),
(28, 10),
(28, 11),
(28, 12),
(29, 10),
(29, 11),
(29, 12),
(29, 13),
(30, 10),
(30, 11),
(30, 12),
(30, 13),
(31, 10),
(31, 11),
(31, 12),
(32, 10),
(32, 11),
(33, 10),
(33, 11),
(34, 10),
(34, 11),
(35, 10),
(35, 11),
(36, 10),
(36, 11),
(37, 10),
(37, 11),
(38, 10),
(38, 11),
(39, 10),
(39, 11),
(40, 10),
(40, 11),
(41, 10),
(41, 11),
(42, 10),
(42, 11),
(43, 10),
(43, 11),
(44, 10),
(44, 11),
(45, 10),
(45, 11),
(46, 10),
(46, 11),
(47, 10),
(47, 11),
(48, 10),
(48, 11),
(49, 10),
(49, 11),
(50, 10),
(50, 11),
(51, 10),
(51, 11),
(52, 10),
(52, 11),
(53, 10),
(53, 11),
(54, 10),
(54, 11),
(55, 10),
(55, 11),
(56, 10),
(56, 11),
(57, 10),
(57, 11),
(58, 10),
(58, 11),
(59, 10),
(59, 11),
(60, 10),
(60, 11),
(61, 10),
(61, 11),
(62, 10),
(62, 11),
(63, 10),
(63, 11),
(64, 10),
(64, 11),
(65, 10),
(65, 11),
(66, 10),
(66, 11),
(67, 10),
(67, 11),
(68, 10),
(68, 11),
(69, 10),
(69, 11),
(70, 10),
(70, 11),
(71, 10),
(71, 11),
(72, 10),
(72, 11),
(73, 10),
(73, 11),
(74, 10),
(74, 11),
(75, 10),
(75, 11),
(76, 10),
(76, 11),
(77, 10),
(77, 11),
(78, 10),
(78, 11),
(79, 10),
(79, 11),
(80, 10),
(80, 11),
(81, 10),
(81, 11),
(82, 10),
(82, 11),
(83, 10),
(83, 11),
(84, 10),
(84, 11),
(85, 10),
(85, 11),
(86, 10),
(86, 11),
(87, 10),
(87, 11),
(88, 10),
(88, 11),
(89, 10),
(89, 11),
(90, 10),
(90, 11),
(91, 10),
(91, 11),
(92, 10),
(92, 11),
(93, 10),
(93, 11),
(94, 10),
(94, 11),
(95, 10),
(95, 11),
(96, 10),
(96, 11),
(97, 10),
(97, 11),
(98, 10),
(98, 11),
(99, 10),
(99, 11),
(100, 10),
(100, 11),
(101, 10),
(101, 11),
(102, 10),
(102, 11),
(103, 10),
(103, 11),
(104, 10),
(104, 11),
(105, 10),
(105, 11),
(106, 10),
(106, 11),
(108, 10),
(108, 11),
(109, 10),
(109, 11),
(110, 10),
(110, 11),
(111, 10),
(111, 11),
(112, 10),
(112, 11),
(113, 10),
(113, 11),
(114, 10),
(114, 11),
(115, 10),
(115, 11),
(116, 10),
(116, 11),
(117, 10),
(117, 11),
(119, 10),
(119, 11),
(120, 10),
(120, 11),
(121, 10),
(121, 11),
(122, 10),
(122, 11),
(123, 10),
(123, 11),
(124, 10),
(124, 11),
(125, 10),
(125, 11),
(126, 10),
(126, 11),
(127, 10),
(127, 11),
(128, 10),
(128, 11),
(129, 10),
(129, 11),
(130, 10),
(130, 11),
(131, 10),
(131, 11),
(132, 10),
(132, 11),
(133, 10),
(133, 11),
(134, 10),
(134, 11),
(135, 10),
(135, 11),
(136, 10),
(136, 11),
(137, 10),
(137, 11),
(138, 10),
(138, 11),
(139, 10),
(139, 11),
(140, 10),
(140, 11),
(140, 12),
(140, 13),
(141, 10),
(141, 11),
(141, 12),
(141, 13),
(142, 10),
(142, 11),
(142, 12),
(142, 13),
(143, 10),
(143, 11),
(143, 12),
(143, 13),
(144, 10),
(144, 11),
(144, 12),
(145, 10),
(145, 11),
(145, 12),
(145, 13),
(146, 10),
(146, 11),
(146, 12),
(146, 13),
(147, 10),
(147, 11),
(147, 12),
(147, 13),
(148, 10),
(148, 11),
(148, 12),
(148, 13),
(149, 10),
(149, 11),
(149, 12),
(149, 13),
(150, 10),
(150, 11),
(150, 12),
(150, 13),
(151, 10),
(151, 11),
(151, 12),
(151, 13),
(152, 10),
(152, 11),
(152, 12),
(152, 13),
(153, 10),
(153, 11),
(153, 12),
(154, 10),
(154, 11),
(154, 12),
(154, 13),
(154, 14),
(155, 10),
(155, 11),
(155, 12),
(155, 13),
(155, 14),
(156, 10),
(156, 11),
(156, 12),
(156, 13),
(156, 14),
(157, 10),
(157, 11),
(157, 12),
(157, 13),
(157, 14),
(158, 10),
(158, 11),
(158, 12),
(158, 14),
(159, 10),
(159, 11),
(159, 12),
(159, 13),
(160, 10),
(160, 11),
(161, 10),
(161, 11),
(162, 10),
(162, 11),
(163, 10),
(163, 11),
(164, 10),
(164, 11),
(165, 10),
(165, 11),
(165, 12),
(165, 13),
(166, 10),
(166, 11),
(166, 12),
(166, 13),
(167, 10),
(167, 11),
(167, 12),
(167, 13),
(168, 10),
(168, 11),
(168, 12),
(168, 13),
(169, 10),
(169, 11),
(169, 12),
(170, 10),
(170, 11),
(170, 12),
(170, 13),
(170, 15),
(171, 10),
(171, 11),
(171, 15),
(172, 10),
(172, 11),
(172, 12),
(172, 13),
(172, 15),
(173, 10),
(173, 11),
(173, 15),
(174, 10),
(174, 11),
(174, 15),
(175, 10),
(175, 11),
(175, 12),
(175, 14),
(175, 15),
(176, 10),
(176, 11),
(176, 14),
(176, 15),
(177, 10),
(177, 11),
(177, 12),
(177, 14),
(177, 15),
(178, 10),
(178, 11),
(178, 14),
(178, 15),
(179, 10),
(179, 11),
(179, 14),
(179, 15),
(180, 10),
(180, 11),
(181, 10),
(181, 11),
(182, 10),
(182, 11),
(183, 10),
(183, 11),
(184, 10),
(184, 11),
(185, 10),
(185, 11),
(186, 10),
(186, 11),
(187, 10),
(187, 11),
(188, 10),
(188, 11),
(189, 10),
(189, 11),
(190, 10),
(190, 11),
(190, 12),
(190, 13),
(191, 10),
(191, 11),
(191, 12),
(192, 10),
(192, 11),
(192, 12),
(192, 13),
(193, 10),
(193, 11),
(193, 12),
(194, 10),
(194, 11),
(195, 10),
(195, 11),
(195, 12),
(195, 13),
(196, 10),
(196, 11),
(196, 12),
(196, 13),
(197, 10),
(197, 11),
(197, 12),
(197, 13),
(198, 10),
(198, 11),
(198, 12),
(198, 13),
(199, 10),
(199, 11),
(199, 12),
(200, 10),
(200, 11),
(200, 12),
(200, 13),
(201, 10),
(201, 11),
(201, 12),
(201, 13),
(202, 10),
(202, 11),
(202, 12),
(202, 13),
(203, 10),
(203, 11),
(203, 12),
(203, 13),
(204, 10),
(204, 11),
(205, 10),
(205, 11),
(206, 10),
(206, 11),
(207, 10),
(207, 11),
(208, 10),
(208, 11),
(209, 10),
(209, 11),
(210, 10),
(210, 11),
(210, 12),
(210, 13),
(211, 10),
(211, 11),
(211, 12),
(211, 13),
(212, 10),
(212, 11),
(212, 12),
(212, 13),
(213, 10),
(213, 11),
(213, 12),
(213, 13),
(214, 10),
(214, 11),
(214, 12),
(215, 10),
(215, 11),
(215, 12),
(215, 13),
(216, 10),
(216, 11),
(216, 12),
(216, 13),
(217, 10),
(217, 11),
(217, 12),
(217, 13),
(218, 10),
(218, 11),
(218, 12),
(218, 13),
(219, 10),
(219, 11),
(219, 12),
(220, 10),
(220, 11),
(220, 12),
(220, 13),
(220, 14),
(220, 15),
(221, 10),
(221, 11),
(221, 12),
(221, 13),
(221, 15),
(222, 10),
(222, 11),
(222, 12),
(222, 13),
(222, 14),
(222, 15),
(223, 10),
(223, 11),
(223, 12),
(223, 13),
(223, 15),
(224, 10),
(224, 11),
(224, 12),
(224, 15),
(225, 10),
(225, 11),
(226, 10),
(226, 11),
(227, 10),
(227, 11),
(228, 10),
(228, 11),
(229, 10),
(229, 11),
(230, 10),
(230, 11),
(230, 12),
(230, 13),
(231, 10),
(231, 11),
(231, 12),
(231, 13),
(232, 10),
(232, 11),
(232, 12),
(232, 13),
(233, 10),
(233, 11),
(233, 12),
(233, 13),
(234, 10),
(234, 11),
(234, 12),
(234, 13),
(235, 10),
(235, 11),
(235, 12),
(235, 13),
(235, 14),
(236, 10),
(236, 11),
(236, 12),
(236, 13),
(236, 14),
(237, 10),
(237, 11),
(237, 12),
(237, 13),
(237, 14),
(238, 10),
(238, 11),
(238, 12),
(238, 13),
(238, 14),
(239, 10),
(239, 11),
(239, 12),
(239, 14),
(241, 10),
(241, 11),
(241, 17),
(242, 10),
(242, 11),
(242, 17),
(243, 10),
(243, 11),
(243, 17),
(244, 10),
(244, 11),
(244, 17),
(245, 10),
(245, 11),
(245, 18),
(246, 10),
(246, 11),
(246, 18),
(247, 10),
(247, 11),
(247, 16),
(248, 10),
(248, 11),
(248, 16),
(249, 10),
(249, 11),
(250, 10),
(250, 11),
(250, 16),
(251, 10),
(251, 11),
(251, 16),
(252, 10),
(252, 11),
(252, 12),
(252, 13),
(253, 10),
(253, 11),
(253, 12),
(254, 10),
(254, 11),
(254, 12),
(254, 13),
(255, 10),
(255, 11),
(255, 12),
(255, 13),
(256, 10),
(256, 11),
(256, 12),
(257, 10),
(257, 11),
(257, 12),
(257, 13),
(258, 10),
(258, 11),
(258, 12),
(259, 10),
(259, 11),
(259, 12),
(259, 13),
(260, 10),
(260, 11),
(260, 12),
(260, 13),
(261, 10),
(261, 11),
(261, 12),
(262, 12),
(262, 13),
(263, 12),
(264, 12),
(264, 13),
(265, 12),
(265, 13),
(266, 12);

-- --------------------------------------------------------

--
-- Table structure for table `permission_user`
--

CREATE TABLE `permission_user` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `user_type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `project_type_id` bigint(20) UNSIGNED NOT NULL,
  `project_status_id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `assigned_to` bigint(20) UNSIGNED NOT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `labor_cost` decimal(10,2) DEFAULT NULL,
  `previousLeftoverMaterialCost` decimal(10,2) NOT NULL DEFAULT 0.00,
  `administrativeCost` decimal(10,2) NOT NULL DEFAULT 0.00,
  `invoiceValue` decimal(10,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `project_type_id`, `project_status_id`, `customer_id`, `start_date`, `end_date`, `assigned_to`, `created_by`, `updated_by`, `created_at`, `updated_at`, `labor_cost`, `previousLeftoverMaterialCost`, `administrativeCost`, `invoiceValue`) VALUES
(1, 1, 2, 1, '2023-09-07', NULL, 3, 1, 1, '2023-09-04 13:54:27', '2023-09-06 07:55:24', '800.00', '10000.00', '4900.00', '70000.00'),
(2, 2, 3, 2, '2023-09-06', NULL, 4, 3, 3, '2023-09-06 06:04:42', '2023-09-06 06:06:43', NULL, '0.00', '0.00', '0.00');

-- --------------------------------------------------------

--
-- Table structure for table `project_statuses`
--

CREATE TABLE `project_statuses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `project_statuses`
--

INSERT INTO `project_statuses` (`id`, `name`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'Estimation', 1, 1, '2023-09-04 12:01:08', '2023-09-04 12:01:08'),
(2, 'Scheduled', 1, 1, '2023-09-04 12:01:15', '2023-09-04 12:01:15'),
(3, 'In Progress', 1, 1, '2023-09-04 12:01:27', '2023-09-04 12:01:27'),
(4, 'On Hold', 1, 1, '2023-09-04 12:01:35', '2023-09-04 12:01:35'),
(5, 'Completed', 1, 1, '2023-09-04 12:01:42', '2023-09-04 12:01:42'),
(6, 'Quality Inspection', 1, 1, '2023-09-04 12:01:49', '2023-09-04 12:01:49'),
(7, 'Touch-Up', 1, 1, '2023-09-04 12:01:58', '2023-09-04 12:01:58'),
(8, 'Client Approval', 1, 1, '2023-09-04 12:02:07', '2023-09-04 12:02:07'),
(9, 'Payment Processing', 1, 1, '2023-09-04 12:02:16', '2023-09-04 12:02:16'),
(10, 'Cancelled', 1, 1, '2023-09-04 12:02:24', '2023-09-04 12:02:24'),
(11, 'Delayed', 1, 1, '2023-09-04 12:02:31', '2023-09-04 12:02:31'),
(12, 'Materials Procurement', 1, 1, '2023-09-04 12:02:39', '2023-09-04 12:02:39'),
(13, 'Equipment Setup', 1, 1, '2023-09-04 12:02:46', '2023-09-04 12:02:46'),
(14, 'Site Preparation', 1, 1, '2023-09-04 12:02:55', '2023-09-04 12:02:55'),
(15, 'Safety Inspection', 1, 1, '2023-09-04 12:03:03', '2023-09-04 12:03:03');

-- --------------------------------------------------------

--
-- Table structure for table `project_types`
--

CREATE TABLE `project_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `project_types`
--

INSERT INTO `project_types` (`id`, `name`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'Interior Painting', 1, 1, '2023-09-04 11:58:32', '2023-09-04 11:58:32'),
(2, 'Exterior Painting', 1, 1, '2023-09-04 11:58:41', '2023-09-04 11:58:41'),
(3, 'Residential Painting', 1, 1, '2023-09-04 11:58:49', '2023-09-04 11:58:49'),
(4, 'Commercial Painting', 1, 1, '2023-09-04 11:58:57', '2023-09-04 11:58:57'),
(5, 'Industrial Painting', 1, 1, '2023-09-04 11:59:07', '2023-09-04 11:59:07'),
(6, 'Renovation Painting', 1, 1, '2023-09-04 11:59:15', '2023-09-04 11:59:15'),
(7, 'Decorative Painting', 1, 1, '2023-09-04 11:59:25', '2023-09-04 11:59:25'),
(8, 'Pressure Washing and Painting', 1, 1, '2023-09-04 11:59:40', '2023-09-04 11:59:40'),
(9, 'Color Consultation', 1, 1, '2023-09-04 11:59:50', '2023-09-04 11:59:50'),
(10, 'Touch-Up and Maintenance', 1, 1, '2023-09-04 12:00:04', '2023-09-04 12:00:04'),
(11, 'Custom Painting', 1, 1, '2023-09-04 12:00:13', '2023-09-04 12:00:13'),
(12, 'Wallpaper Removal', 1, 1, '2023-09-04 12:00:21', '2023-09-04 12:00:21'),
(13, 'Fence and Deck Staining/Painting', 1, 1, '2023-09-04 12:00:31', '2023-09-04 12:00:31'),
(14, 'Epoxy Flooring', 1, 1, '2023-09-04 12:00:41', '2023-09-04 12:00:41'),
(15, 'Specialty Coatings', 1, 1, '2023-09-04 12:00:50', '2023-09-04 12:00:50');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `display_name` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `display_name`, `description`, `created_at`, `updated_at`) VALUES
(10, 'super-admin', 'Super Admin', NULL, '2023-09-04 11:22:13', '2023-09-04 11:22:13'),
(11, 'admin', 'Admin', NULL, '2023-09-04 11:22:19', '2023-09-04 11:22:19'),
(12, 'manager', 'Manager', NULL, '2023-09-04 11:22:33', '2023-09-04 11:22:33'),
(13, 'supervisor', 'Supervisor', NULL, '2023-09-04 11:22:42', '2023-09-04 11:22:42'),
(14, 'accounts', 'Accounts', NULL, '2023-09-04 11:22:50', '2023-09-04 11:22:50'),
(15, 'hr', 'HR', NULL, '2023-09-04 11:22:56', '2023-09-04 11:22:56'),
(16, 'employee', 'Employee', NULL, '2023-09-04 11:23:04', '2023-09-04 11:23:04'),
(17, 'client', 'Client', NULL, '2023-09-04 11:23:12', '2023-09-04 11:23:12'),
(18, 'vendor', 'Vendor', NULL, '2023-09-04 11:23:20', '2023-09-04 11:23:20');

-- --------------------------------------------------------

--
-- Table structure for table `role_user`
--

CREATE TABLE `role_user` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `user_type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_user`
--

INSERT INTO `role_user` (`role_id`, `user_id`, `user_type`) VALUES
(10, 1, 'App\\Models\\User'),
(11, 2, 'App\\Models\\User'),
(12, 3, 'App\\Models\\User'),
(13, 4, 'App\\Models\\User'),
(17, 5, 'App\\Models\\User'),
(16, 6, 'App\\Models\\User'),
(18, 7, 'App\\Models\\User'),
(15, 8, 'App\\Models\\User'),
(14, 9, 'App\\Models\\User'),
(17, 10, 'App\\Models\\User');

-- --------------------------------------------------------

--
-- Table structure for table `skills`
--

CREATE TABLE `skills` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `skills`
--

INSERT INTO `skills` (`id`, `name`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'Painting', 1, 1, '2023-09-04 12:41:08', '2023-09-04 12:41:08'),
(2, 'Polishing', 1, 1, '2023-09-04 12:41:42', '2023-09-04 12:41:42'),
(3, 'Surface Preparation', 1, 1, '2023-09-04 12:41:49', '2023-09-04 12:41:49'),
(4, 'Color Theory and Design', 1, 1, '2023-09-04 12:41:56', '2023-09-04 12:41:56'),
(5, 'Safety and Compliance', 1, 1, '2023-09-04 12:42:11', '2023-09-04 12:42:11'),
(6, 'Project Management', 1, 1, '2023-09-04 12:42:19', '2023-09-04 12:42:19'),
(7, 'Customer Service', 1, 1, '2023-09-04 12:42:25', '2023-09-04 12:42:25'),
(8, 'Tools and Equipment', 1, 1, '2023-09-04 12:42:35', '2023-09-04 12:42:35'),
(9, 'Estimation and Quotation', 1, 1, '2023-09-04 12:42:44', '2023-09-04 12:42:44'),
(11, 'Training and Development', 1, 1, '2023-09-04 12:42:57', '2023-09-04 12:42:57'),
(12, 'Technical', 1, 1, '2023-09-04 12:43:14', '2023-09-04 12:43:14');

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ticket_category_id` bigint(20) UNSIGNED NOT NULL,
  `priority` enum('low','medium','high') NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `status` enum('Answered','Pending') NOT NULL DEFAULT 'Pending',
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `assigned_to` bigint(20) UNSIGNED DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tickets`
--

INSERT INTO `tickets` (`id`, `ticket_category_id`, `priority`, `subject`, `message`, `status`, `client_id`, `assigned_to`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 1, 'low', 'Website Down', 'Test', 'Pending', 5, 4, 5, 1, '2023-09-04 14:22:18', '2023-09-04 14:47:48'),
(2, 2, 'medium', 'Test', 'asass', 'Pending', 5, 3, 1, 1, '2023-09-04 14:56:16', '2023-09-04 14:56:16');

-- --------------------------------------------------------

--
-- Table structure for table `ticket_categories`
--

CREATE TABLE `ticket_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ticket_categories`
--

INSERT INTO `ticket_categories` (`id`, `name`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'Technical Issues', 1, 1, '2023-09-04 13:00:15', '2023-09-04 13:00:15'),
(2, 'Billing and Payment', 1, 1, '2023-09-04 13:00:23', '2023-09-04 13:00:23'),
(3, 'Project Questions', 1, 1, '2023-09-04 13:00:31', '2023-09-04 13:00:31'),
(4, 'Service Request', 1, 1, '2023-09-04 13:00:45', '2023-09-04 13:00:45'),
(5, 'Quality Concerns', 1, 1, '2023-09-04 13:00:53', '2023-09-04 13:00:53'),
(6, 'Scheduling and Rescheduling', 1, 1, '2023-09-04 13:01:03', '2023-09-04 13:01:03'),
(7, 'Materials and Equipment', 1, 1, '2023-09-04 13:01:13', '2023-09-04 13:01:13'),
(8, 'Safety Concerns', 1, 1, '2023-09-04 13:01:22', '2023-09-04 13:01:22'),
(9, 'Feedback and Suggestions', 1, 1, '2023-09-04 13:01:30', '2023-09-04 13:01:30'),
(10, 'Emergency Situations:', 1, 1, '2023-09-04 13:01:56', '2023-09-04 13:01:56'),
(11, 'Job Site Access', 1, 1, '2023-09-04 13:02:03', '2023-09-04 13:02:03'),
(12, 'Environmental Concerns', 1, 1, '2023-09-04 13:02:10', '2023-09-04 13:02:10'),
(13, 'Contractual Disputes', 1, 1, '2023-09-04 13:02:16', '2023-09-04 13:02:16'),
(14, 'Insurance and Liability', 1, 1, '2023-09-04 13:02:24', '2023-09-04 13:02:24'),
(15, 'Follow-up and Status', 1, 1, '2023-09-04 13:02:32', '2023-09-04 13:02:32'),
(16, 'Refunds and Returns', 1, 1, '2023-09-04 13:02:40', '2023-09-04 13:02:40'),
(17, 'Employee Conduct', 1, 1, '2023-09-04 13:02:47', '2023-09-04 13:02:47'),
(18, 'Documentation Requests', 1, 1, '2023-09-04 13:02:55', '2023-09-04 13:02:55'),
(19, 'Community Engagement', 1, 1, '2023-09-04 13:03:06', '2023-09-04 13:03:06'),
(20, 'Legal Matters', 1, 1, '2023-09-04 13:03:14', '2023-09-04 13:03:14'),
(21, 'Health and Safety', 1, 1, '2023-09-04 13:03:22', '2023-09-04 13:03:22'),
(22, 'Vendor Relations', 1, 1, '2023-09-04 13:03:29', '2023-09-04 13:03:29'),
(23, 'Training and Education', 1, 1, '2023-09-04 13:03:36', '2023-09-04 13:03:36'),
(24, 'IT Support', 1, 1, '2023-09-04 13:03:43', '2023-09-04 13:03:43'),
(25, 'Website and Online Services', 1, 1, '2023-09-04 13:03:52', '2023-09-04 13:03:52'),
(26, 'Other', 1, 1, '2023-09-04 13:04:04', '2023-09-04 13:04:04');

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
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Super Administrator User', 'superadmin@homeglazer.com', NULL, '$2y$10$.uXsm4IYnstswxLjnnaUEe1sUBCFpGHvpp2cnq43DSv4saEKObtb6', NULL, '2023-09-04 10:32:23', '2023-09-04 13:20:40'),
(2, 'Administrator User', 'admin@homeglazer.com', NULL, '$2y$10$vh0teFaRIs9u4HS3RI1iU.Qe6EBzKhI8WEoh2Ed1cI3dyDFXbQmgy', NULL, '2023-09-04 13:05:32', '2023-09-04 13:20:57'),
(3, 'Manager User', 'manager@homeglazer.com', NULL, '$2y$10$nXR9ocAGwmVZhwcKK2in9ujW.2dJURHMoG1Rx/XkKpxFGG5Ow9ieu', NULL, '2023-09-04 13:06:19', '2023-09-04 13:21:07'),
(4, 'Supervisor User', 'supervisor@homeglazer.com', NULL, '$2y$10$a6HOaTcx6z/yk26xj3Z7U.sBeaLboqKuxZnJwH3w9KEcc6gZ9.EDq', NULL, '2023-09-04 13:07:06', '2023-09-04 13:21:17'),
(5, 'John Mathew', 'john@gmail.com', NULL, '$2y$10$7V2H7sCSCFSiCawIYTGua.tOSwgA1M4X1utj2K971hs.nmhT7adka', NULL, '2023-09-04 13:27:53', '2023-09-04 14:20:35'),
(6, 'Salman Khan', 'sakman@gmail.com', NULL, '$2y$10$iV40N/Vhw4DUmi85uRFSwub07MAbm2mE4bHSI1gdpYr8OKOAms9Ym', NULL, '2023-09-04 14:05:01', '2023-09-04 14:15:16'),
(7, 'Asian', 'asian@gmail.com', NULL, '$2y$10$StePKrK/5YmDpMsOcfS7jOk.7MGyKpQOHBMQLdHGhB51Ei4uVKlM2', NULL, '2023-09-04 14:25:45', '2023-09-04 14:25:45'),
(8, 'Human Resource', 'hr@homeglazer.com', NULL, '$2y$10$Zw8fRfP5jIy8su93kG3.QeDWw8/u632lXLgDfGr907SyPO9RgX0kW', '6APMt42yQtoSwSXnWuBTa5c68A4s7qmv3uIEEdcKejt56Toxzqahe4BPZdXc', '2023-09-04 14:57:44', '2023-09-04 14:57:44'),
(9, 'Accounts', 'accounts@homeglazer.com', NULL, '$2y$10$crxk0pfmmQvolyZPbu7yI.LcxJSlLkT/9l.19NOAqR1xyxYlDAppq', NULL, '2023-09-05 16:18:49', '2023-09-05 16:18:49'),
(10, 'Kevin', 'kevin@gmail.com', NULL, '$2y$10$OSyeQI/T/PtVtxddLsyCC.vmNInESBH9uX2.Aw1BwMm20Ttn4Cj1a', NULL, '2023-09-06 06:03:18', '2023-09-06 06:03:18');

-- --------------------------------------------------------

--
-- Table structure for table `vendors`
--

CREATE TABLE `vendors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `vendor_type_id` bigint(20) UNSIGNED NOT NULL,
  `vendor_status_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vendors`
--

INSERT INTO `vendors` (`id`, `vendor_type_id`, `vendor_status_id`, `name`, `phone`, `email`, `address`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'Asian', '1234567890', 'asian@gmail.com', 'Example', 1, 1, '2023-09-04 14:24:12', '2023-09-04 14:24:12');

-- --------------------------------------------------------

--
-- Table structure for table `vendor_statuses`
--

CREATE TABLE `vendor_statuses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vendor_statuses`
--

INSERT INTO `vendor_statuses` (`id`, `name`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'Active', 1, 1, '2023-09-04 12:15:38', '2023-09-04 12:15:38'),
(2, 'Pending Approval', 1, 1, '2023-09-04 12:15:46', '2023-09-04 12:15:46'),
(3, 'Approved', 1, 1, '2023-09-04 12:15:53', '2023-09-04 12:15:53'),
(4, 'On Hold:', 1, 1, '2023-09-04 12:16:02', '2023-09-04 12:16:02'),
(5, 'Archived', 1, 1, '2023-09-04 12:16:09', '2023-09-04 12:16:09'),
(6, 'Preferred', 1, 1, '2023-09-04 12:16:16', '2023-09-04 12:16:16'),
(7, 'Cancelled', 1, 1, '2023-09-04 12:16:25', '2023-09-04 12:16:25'),
(8, 'Suspended', 1, 1, '2023-09-04 12:16:33', '2023-09-04 12:16:33'),
(9, 'Emergency Supplier', 1, 1, '2023-09-04 12:16:45', '2023-09-04 12:16:45'),
(10, 'Quality Issues', 1, 1, '2023-09-04 12:16:55', '2023-09-04 12:16:55'),
(11, 'Delivery Issues', 1, 1, '2023-09-04 12:17:01', '2023-09-04 12:17:01'),
(12, 'Payment Issues', 1, 1, '2023-09-04 12:17:08', '2023-09-04 12:17:08'),
(13, 'Disputed', 1, 1, '2023-09-04 12:17:16', '2023-09-04 12:17:16'),
(14, 'New Vendor', 1, 1, '2023-09-04 12:17:23', '2023-09-04 12:17:23'),
(15, 'Specialty Supplier', 1, 1, '2023-09-04 12:17:34', '2023-09-04 12:17:34');

-- --------------------------------------------------------

--
-- Table structure for table `vendor_types`
--

CREATE TABLE `vendor_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vendor_types`
--

INSERT INTO `vendor_types` (`id`, `name`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'Paint Suppliers', 1, 1, '2023-09-04 12:13:03', '2023-09-04 12:13:03'),
(2, 'Tool Suppliers', 1, 1, '2023-09-04 12:13:11', '2023-09-04 12:13:11'),
(3, 'Safety Equipment Suppliers', 1, 1, '2023-09-04 12:13:19', '2023-09-04 12:13:19'),
(4, 'Ladder and Scaffolding Suppliers', 1, 1, '2023-09-04 12:13:28', '2023-09-04 12:13:28'),
(5, 'Cleaning Supply Vendors', 1, 1, '2023-09-04 12:13:36', '2023-09-04 12:13:36'),
(6, 'Primer and Sealer Suppliers', 1, 1, '2023-09-04 12:13:45', '2023-09-04 12:13:45'),
(7, 'Specialty Finish Suppliers', 1, 1, '2023-09-04 12:14:02', '2023-09-04 12:14:02'),
(8, 'Repair Material Suppliers', 1, 1, '2023-09-04 12:14:11', '2023-09-04 12:14:11'),
(9, 'Paint Sprayer Suppliers', 1, 1, '2023-09-04 12:14:20', '2023-09-04 12:14:20'),
(10, 'Thinners and Solvent Suppliers', 1, 1, '2023-09-04 12:14:30', '2023-09-04 12:14:30'),
(11, 'Decorator Suppliers', 1, 1, '2023-09-04 12:14:38', '2023-09-04 12:14:38'),
(12, 'General Hardware Suppliers', 1, 1, '2023-09-04 12:14:46', '2023-09-04 12:14:46'),
(13, 'Sanding Material Suppliers', 1, 1, '2023-09-04 12:14:54', '2023-09-04 12:14:54'),
(14, 'Tarps and Drop Cloth Suppliers', 1, 1, '2023-09-04 12:15:03', '2023-09-04 12:15:03'),
(15, 'Stolen or Lost', 1, 1, '2023-09-04 12:15:11', '2023-09-04 12:15:11');

-- --------------------------------------------------------

--
-- Table structure for table `vendor_users`
--

CREATE TABLE `vendor_users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `vendor_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vendor_users`
--

INSERT INTO `vendor_users` (`id`, `vendor_id`, `user_id`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 1, 7, 1, 1, '2023-09-04 14:25:45', '2023-09-04 14:25:45');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activities`
--
ALTER TABLE `activities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `activities_activity_type_id_foreign` (`activity_type_id`),
  ADD KEY `activities_lead_id_foreign` (`lead_id`),
  ADD KEY `activities_customer_id_foreign` (`customer_id`),
  ADD KEY `activities_project_id_foreign` (`project_id`),
  ADD KEY `activities_contact_method_id_foreign` (`contact_method_id`),
  ADD KEY `activities_created_by_index` (`created_by`),
  ADD KEY `activities_updated_by_index` (`updated_by`);

--
-- Indexes for table `activity_types`
--
ALTER TABLE `activity_types`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `activity_types_name_unique` (`name`),
  ADD KEY `activity_types_created_by_index` (`created_by`),
  ADD KEY `activity_types_updated_by_index` (`updated_by`);

--
-- Indexes for table `attachments`
--
ALTER TABLE `attachments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `attachments_attachment_type_id_foreign` (`attachment_type_id`),
  ADD KEY `attachments_project_id_foreign` (`project_id`),
  ADD KEY `attachments_created_by_index` (`created_by`),
  ADD KEY `attachments_updated_by_index` (`updated_by`);

--
-- Indexes for table `attachment_types`
--
ALTER TABLE `attachment_types`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `attachment_types_name_unique` (`name`),
  ADD KEY `attachment_types_created_by_index` (`created_by`),
  ADD KEY `attachment_types_updated_by_index` (`updated_by`);

--
-- Indexes for table `attendance_records`
--
ALTER TABLE `attendance_records`
  ADD PRIMARY KEY (`id`),
  ADD KEY `attendance_records_employee_id_foreign` (`employee_id`),
  ADD KEY `attendance_records_project_id_foreign` (`project_id`),
  ADD KEY `attendance_records_attendance_type_id_foreign` (`attendance_type_id`),
  ADD KEY `attendance_records_attendance_status_id_foreign` (`attendance_status_id`),
  ADD KEY `attendance_records_created_by_index` (`created_by`),
  ADD KEY `attendance_records_updated_by_index` (`updated_by`);

--
-- Indexes for table `attendance_statuses`
--
ALTER TABLE `attendance_statuses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `attendance_statuses_name_unique` (`name`),
  ADD KEY `attendance_statuses_created_by_index` (`created_by`),
  ADD KEY `attendance_statuses_updated_by_index` (`updated_by`);

--
-- Indexes for table `attendance_types`
--
ALTER TABLE `attendance_types`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `attendance_types_name_unique` (`name`),
  ADD KEY `attendance_types_created_by_index` (`created_by`),
  ADD KEY `attendance_types_updated_by_index` (`updated_by`);

--
-- Indexes for table `bills`
--
ALTER TABLE `bills`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bills_bill_type_id_foreign` (`bill_type_id`),
  ADD KEY `bills_bill_status_id_foreign` (`bill_status_id`),
  ADD KEY `bills_payment_method_id_foreign` (`payment_method_id`),
  ADD KEY `bills_project_id_foreign` (`project_id`),
  ADD KEY `bills_inventory_id_foreign` (`inventory_id`),
  ADD KEY `bills_employee_id_foreign` (`employee_id`),
  ADD KEY `bills_created_by_index` (`created_by`),
  ADD KEY `bills_updated_by_index` (`updated_by`);

--
-- Indexes for table `bill_statuses`
--
ALTER TABLE `bill_statuses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `bill_statuses_name_unique` (`name`),
  ADD KEY `bill_statuses_created_by_index` (`created_by`),
  ADD KEY `bill_statuses_updated_by_index` (`updated_by`);

--
-- Indexes for table `bill_types`
--
ALTER TABLE `bill_types`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `bill_types_name_unique` (`name`),
  ADD KEY `bill_types_created_by_index` (`created_by`),
  ADD KEY `bill_types_updated_by_index` (`updated_by`);

--
-- Indexes for table `blood_groups`
--
ALTER TABLE `blood_groups`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `blood_groups_name_unique` (`name`),
  ADD KEY `blood_groups_created_by_index` (`created_by`),
  ADD KEY `blood_groups_updated_by_index` (`updated_by`);

--
-- Indexes for table `contact_languages`
--
ALTER TABLE `contact_languages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `contact_languages_name_unique` (`name`),
  ADD KEY `contact_languages_created_by_index` (`created_by`),
  ADD KEY `contact_languages_updated_by_index` (`updated_by`);

--
-- Indexes for table `contact_methods`
--
ALTER TABLE `contact_methods`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `contact_methods_name_unique` (`name`),
  ADD KEY `contact_methods_created_by_index` (`created_by`),
  ADD KEY `contact_methods_updated_by_index` (`updated_by`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customers_lead_id_foreign` (`lead_id`),
  ADD KEY `customers_user_id_foreign` (`user_id`),
  ADD KEY `customers_created_by_index` (`created_by`),
  ADD KEY `customers_updated_by_index` (`updated_by`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `departments_name_unique` (`name`),
  ADD KEY `departments_created_by_index` (`created_by`),
  ADD KEY `departments_updated_by_index` (`updated_by`);

--
-- Indexes for table `designations`
--
ALTER TABLE `designations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `designations_name_unique` (`name`),
  ADD KEY `designations_created_by_index` (`created_by`),
  ADD KEY `designations_updated_by_index` (`updated_by`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `employees_emp_id_unique` (`emp_id`),
  ADD KEY `employees_employee_type_id_foreign` (`employee_type_id`),
  ADD KEY `employees_gender_id_foreign` (`gender_id`),
  ADD KEY `employees_blood_group_id_foreign` (`blood_group_id`),
  ADD KEY `employees_department_id_foreign` (`department_id`),
  ADD KEY `employees_designation_id_foreign` (`designation_id`),
  ADD KEY `employees_skill_paint_id_foreign` (`skill_paint_id`),
  ADD KEY `employees_skill_polish_id_foreign` (`skill_polish_id`),
  ADD KEY `employees_created_by_index` (`created_by`),
  ADD KEY `employees_updated_by_index` (`updated_by`);

--
-- Indexes for table `employee_bank_accounts`
--
ALTER TABLE `employee_bank_accounts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_bank_accounts_emp_id_foreign` (`emp_id`),
  ADD KEY `employee_bank_accounts_created_by_index` (`created_by`),
  ADD KEY `employee_bank_accounts_updated_by_index` (`updated_by`);

--
-- Indexes for table `employee_types`
--
ALTER TABLE `employee_types`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `employee_types_name_unique` (`name`),
  ADD KEY `employee_types_created_by_index` (`created_by`),
  ADD KEY `employee_types_updated_by_index` (`updated_by`);

--
-- Indexes for table `employee_user`
--
ALTER TABLE `employee_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_user_employee_id_foreign` (`employee_id`),
  ADD KEY `employee_user_user_id_foreign` (`user_id`),
  ADD KEY `employee_user_created_by_index` (`created_by`),
  ADD KEY `employee_user_updated_by_index` (`updated_by`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `genders`
--
ALTER TABLE `genders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `genders_name_unique` (`name`),
  ADD KEY `genders_created_by_index` (`created_by`),
  ADD KEY `genders_updated_by_index` (`updated_by`);

--
-- Indexes for table `inventories`
--
ALTER TABLE `inventories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `inventories_inventory_status_id_foreign` (`inventory_status_id`),
  ADD KEY `inventories_inventory_type_id_foreign` (`inventory_type_id`),
  ADD KEY `inventories_vendor_id_foreign` (`vendor_id`),
  ADD KEY `inventories_created_by_index` (`created_by`),
  ADD KEY `inventories_updated_by_index` (`updated_by`),
  ADD KEY `inventories_project_id_foreign` (`project_id`);

--
-- Indexes for table `inventory_statuses`
--
ALTER TABLE `inventory_statuses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `inventory_statuses_name_unique` (`name`),
  ADD KEY `inventory_statuses_created_by_index` (`created_by`),
  ADD KEY `inventory_statuses_updated_by_index` (`updated_by`);

--
-- Indexes for table `inventory_types`
--
ALTER TABLE `inventory_types`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `inventory_types_name_unique` (`name`),
  ADD KEY `inventory_types_created_by_index` (`created_by`),
  ADD KEY `inventory_types_updated_by_index` (`updated_by`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `invoices_lead_id_foreign` (`lead_id`),
  ADD KEY `invoices_invoice_type_id_foreign` (`invoice_type_id`),
  ADD KEY `invoices_invoice_status_id_foreign` (`invoice_status_id`),
  ADD KEY `invoices_created_by_index` (`created_by`),
  ADD KEY `invoices_updated_by_index` (`updated_by`);

--
-- Indexes for table `invoice_statuses`
--
ALTER TABLE `invoice_statuses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `invoice_statuses_name_unique` (`name`),
  ADD KEY `invoice_statuses_created_by_index` (`created_by`),
  ADD KEY `invoice_statuses_updated_by_index` (`updated_by`);

--
-- Indexes for table `invoice_types`
--
ALTER TABLE `invoice_types`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `invoice_types_name_unique` (`name`),
  ADD KEY `invoice_types_created_by_index` (`created_by`),
  ADD KEY `invoice_types_updated_by_index` (`updated_by`);

--
-- Indexes for table `leads`
--
ALTER TABLE `leads`
  ADD PRIMARY KEY (`id`),
  ADD KEY `leads_lead_source_id_foreign` (`lead_source_id`),
  ADD KEY `leads_lead_status_id_foreign` (`lead_status_id`),
  ADD KEY `leads_contact_method_id_foreign` (`contact_method_id`),
  ADD KEY `leads_contact_language_id_foreign` (`contact_language_id`),
  ADD KEY `leads_assignee_id_foreign` (`assignee_id`),
  ADD KEY `leads_created_by_index` (`created_by`),
  ADD KEY `leads_updated_by_index` (`updated_by`);

--
-- Indexes for table `lead_sources`
--
ALTER TABLE `lead_sources`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `lead_sources_name_unique` (`name`),
  ADD KEY `lead_sources_created_by_index` (`created_by`),
  ADD KEY `lead_sources_updated_by_index` (`updated_by`);

--
-- Indexes for table `lead_statuses`
--
ALTER TABLE `lead_statuses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `lead_statuses_name_unique` (`name`),
  ADD KEY `lead_statuses_created_by_index` (`created_by`),
  ADD KEY `lead_statuses_updated_by_index` (`updated_by`);

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
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payments_payment_method_id_foreign` (`payment_method_id`),
  ADD KEY `payments_payment_status_id_foreign` (`payment_status_id`),
  ADD KEY `payments_customer_id_foreign` (`customer_id`),
  ADD KEY `payments_project_id_foreign` (`project_id`),
  ADD KEY `payments_created_by_index` (`created_by`),
  ADD KEY `payments_updated_by_index` (`updated_by`);

--
-- Indexes for table `payment_methods`
--
ALTER TABLE `payment_methods`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `payment_methods_name_unique` (`name`),
  ADD KEY `payment_methods_created_by_index` (`created_by`),
  ADD KEY `payment_methods_updated_by_index` (`updated_by`);

--
-- Indexes for table `payment_statuses`
--
ALTER TABLE `payment_statuses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `payment_statuses_name_unique` (`name`),
  ADD KEY `payment_statuses_created_by_index` (`created_by`),
  ADD KEY `payment_statuses_updated_by_index` (`updated_by`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_unique` (`name`);

--
-- Indexes for table `permission_role`
--
ALTER TABLE `permission_role`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `permission_role_role_id_foreign` (`role_id`);

--
-- Indexes for table `permission_user`
--
ALTER TABLE `permission_user`
  ADD PRIMARY KEY (`user_id`,`permission_id`,`user_type`),
  ADD KEY `permission_user_permission_id_foreign` (`permission_id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `projects_project_type_id_foreign` (`project_type_id`),
  ADD KEY `projects_project_status_id_foreign` (`project_status_id`),
  ADD KEY `projects_customer_id_foreign` (`customer_id`),
  ADD KEY `projects_assigned_to_foreign` (`assigned_to`),
  ADD KEY `projects_created_by_index` (`created_by`),
  ADD KEY `projects_updated_by_index` (`updated_by`);

--
-- Indexes for table `project_statuses`
--
ALTER TABLE `project_statuses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `project_statuses_name_unique` (`name`),
  ADD KEY `project_statuses_created_by_index` (`created_by`),
  ADD KEY `project_statuses_updated_by_index` (`updated_by`);

--
-- Indexes for table `project_types`
--
ALTER TABLE `project_types`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `project_types_name_unique` (`name`),
  ADD KEY `project_types_created_by_index` (`created_by`),
  ADD KEY `project_types_updated_by_index` (`updated_by`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_unique` (`name`);

--
-- Indexes for table `role_user`
--
ALTER TABLE `role_user`
  ADD PRIMARY KEY (`user_id`,`role_id`,`user_type`),
  ADD KEY `role_user_role_id_foreign` (`role_id`);

--
-- Indexes for table `skills`
--
ALTER TABLE `skills`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `skills_name_unique` (`name`),
  ADD KEY `skills_created_by_index` (`created_by`),
  ADD KEY `skills_updated_by_index` (`updated_by`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tickets_ticket_category_id_foreign` (`ticket_category_id`),
  ADD KEY `tickets_client_id_foreign` (`client_id`),
  ADD KEY `tickets_assigned_to_foreign` (`assigned_to`),
  ADD KEY `tickets_created_by_index` (`created_by`),
  ADD KEY `tickets_updated_by_index` (`updated_by`);

--
-- Indexes for table `ticket_categories`
--
ALTER TABLE `ticket_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ticket_categories_name_unique` (`name`),
  ADD KEY `ticket_categories_created_by_index` (`created_by`),
  ADD KEY `ticket_categories_updated_by_index` (`updated_by`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `vendors`
--
ALTER TABLE `vendors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vendors_vendor_type_id_foreign` (`vendor_type_id`),
  ADD KEY `vendors_vendor_status_id_foreign` (`vendor_status_id`),
  ADD KEY `vendors_created_by_index` (`created_by`),
  ADD KEY `vendors_updated_by_index` (`updated_by`);

--
-- Indexes for table `vendor_statuses`
--
ALTER TABLE `vendor_statuses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `vendor_statuses_name_unique` (`name`),
  ADD KEY `vendor_statuses_created_by_index` (`created_by`),
  ADD KEY `vendor_statuses_updated_by_index` (`updated_by`);

--
-- Indexes for table `vendor_types`
--
ALTER TABLE `vendor_types`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `vendor_types_name_unique` (`name`),
  ADD KEY `vendor_types_created_by_index` (`created_by`),
  ADD KEY `vendor_types_updated_by_index` (`updated_by`);

--
-- Indexes for table `vendor_users`
--
ALTER TABLE `vendor_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vendor_users_vendor_id_foreign` (`vendor_id`),
  ADD KEY `vendor_users_user_id_foreign` (`user_id`),
  ADD KEY `vendor_users_created_by_index` (`created_by`),
  ADD KEY `vendor_users_updated_by_index` (`updated_by`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activities`
--
ALTER TABLE `activities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `activity_types`
--
ALTER TABLE `activity_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `attachments`
--
ALTER TABLE `attachments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `attachment_types`
--
ALTER TABLE `attachment_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `attendance_records`
--
ALTER TABLE `attendance_records`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `attendance_statuses`
--
ALTER TABLE `attendance_statuses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `attendance_types`
--
ALTER TABLE `attendance_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `bills`
--
ALTER TABLE `bills`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `bill_statuses`
--
ALTER TABLE `bill_statuses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `bill_types`
--
ALTER TABLE `bill_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `blood_groups`
--
ALTER TABLE `blood_groups`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `contact_languages`
--
ALTER TABLE `contact_languages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `contact_methods`
--
ALTER TABLE `contact_methods`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `designations`
--
ALTER TABLE `designations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `employee_bank_accounts`
--
ALTER TABLE `employee_bank_accounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `employee_types`
--
ALTER TABLE `employee_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `employee_user`
--
ALTER TABLE `employee_user`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `genders`
--
ALTER TABLE `genders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `inventories`
--
ALTER TABLE `inventories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `inventory_statuses`
--
ALTER TABLE `inventory_statuses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `inventory_types`
--
ALTER TABLE `inventory_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `invoice_statuses`
--
ALTER TABLE `invoice_statuses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `invoice_types`
--
ALTER TABLE `invoice_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `leads`
--
ALTER TABLE `leads`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `lead_sources`
--
ALTER TABLE `lead_sources`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `lead_statuses`
--
ALTER TABLE `lead_statuses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `payment_methods`
--
ALTER TABLE `payment_methods`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `payment_statuses`
--
ALTER TABLE `payment_statuses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=267;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `project_statuses`
--
ALTER TABLE `project_statuses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `project_types`
--
ALTER TABLE `project_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `skills`
--
ALTER TABLE `skills`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `ticket_categories`
--
ALTER TABLE `ticket_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `vendors`
--
ALTER TABLE `vendors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `vendor_statuses`
--
ALTER TABLE `vendor_statuses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `vendor_types`
--
ALTER TABLE `vendor_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `vendor_users`
--
ALTER TABLE `vendor_users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activities`
--
ALTER TABLE `activities`
  ADD CONSTRAINT `activities_activity_type_id_foreign` FOREIGN KEY (`activity_type_id`) REFERENCES `activity_types` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `activities_contact_method_id_foreign` FOREIGN KEY (`contact_method_id`) REFERENCES `contact_methods` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `activities_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `activities_lead_id_foreign` FOREIGN KEY (`lead_id`) REFERENCES `leads` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `activities_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `attachments`
--
ALTER TABLE `attachments`
  ADD CONSTRAINT `attachments_attachment_type_id_foreign` FOREIGN KEY (`attachment_type_id`) REFERENCES `attachment_types` (`id`),
  ADD CONSTRAINT `attachments_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`);

--
-- Constraints for table `attendance_records`
--
ALTER TABLE `attendance_records`
  ADD CONSTRAINT `attendance_records_attendance_status_id_foreign` FOREIGN KEY (`attendance_status_id`) REFERENCES `attendance_statuses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `attendance_records_attendance_type_id_foreign` FOREIGN KEY (`attendance_type_id`) REFERENCES `attendance_types` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `attendance_records_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `attendance_records_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `bills`
--
ALTER TABLE `bills`
  ADD CONSTRAINT `bills_bill_status_id_foreign` FOREIGN KEY (`bill_status_id`) REFERENCES `bill_statuses` (`id`),
  ADD CONSTRAINT `bills_bill_type_id_foreign` FOREIGN KEY (`bill_type_id`) REFERENCES `bill_types` (`id`),
  ADD CONSTRAINT `bills_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`),
  ADD CONSTRAINT `bills_inventory_id_foreign` FOREIGN KEY (`inventory_id`) REFERENCES `inventories` (`id`),
  ADD CONSTRAINT `bills_payment_method_id_foreign` FOREIGN KEY (`payment_method_id`) REFERENCES `payment_methods` (`id`),
  ADD CONSTRAINT `bills_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`);

--
-- Constraints for table `customers`
--
ALTER TABLE `customers`
  ADD CONSTRAINT `customers_lead_id_foreign` FOREIGN KEY (`lead_id`) REFERENCES `leads` (`id`),
  ADD CONSTRAINT `customers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `employees`
--
ALTER TABLE `employees`
  ADD CONSTRAINT `employees_blood_group_id_foreign` FOREIGN KEY (`blood_group_id`) REFERENCES `blood_groups` (`id`),
  ADD CONSTRAINT `employees_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`),
  ADD CONSTRAINT `employees_designation_id_foreign` FOREIGN KEY (`designation_id`) REFERENCES `designations` (`id`),
  ADD CONSTRAINT `employees_employee_type_id_foreign` FOREIGN KEY (`employee_type_id`) REFERENCES `employee_types` (`id`),
  ADD CONSTRAINT `employees_gender_id_foreign` FOREIGN KEY (`gender_id`) REFERENCES `genders` (`id`),
  ADD CONSTRAINT `employees_skill_paint_id_foreign` FOREIGN KEY (`skill_paint_id`) REFERENCES `skills` (`id`),
  ADD CONSTRAINT `employees_skill_polish_id_foreign` FOREIGN KEY (`skill_polish_id`) REFERENCES `skills` (`id`);

--
-- Constraints for table `employee_bank_accounts`
--
ALTER TABLE `employee_bank_accounts`
  ADD CONSTRAINT `employee_bank_accounts_emp_id_foreign` FOREIGN KEY (`emp_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `employee_user`
--
ALTER TABLE `employee_user`
  ADD CONSTRAINT `employee_user_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`),
  ADD CONSTRAINT `employee_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `inventories`
--
ALTER TABLE `inventories`
  ADD CONSTRAINT `inventories_inventory_status_id_foreign` FOREIGN KEY (`inventory_status_id`) REFERENCES `inventory_statuses` (`id`),
  ADD CONSTRAINT `inventories_inventory_type_id_foreign` FOREIGN KEY (`inventory_type_id`) REFERENCES `inventory_types` (`id`),
  ADD CONSTRAINT `inventories_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `inventories_vendor_id_foreign` FOREIGN KEY (`vendor_id`) REFERENCES `vendors` (`id`);

--
-- Constraints for table `invoices`
--
ALTER TABLE `invoices`
  ADD CONSTRAINT `invoices_invoice_status_id_foreign` FOREIGN KEY (`invoice_status_id`) REFERENCES `invoice_statuses` (`id`),
  ADD CONSTRAINT `invoices_invoice_type_id_foreign` FOREIGN KEY (`invoice_type_id`) REFERENCES `invoice_types` (`id`),
  ADD CONSTRAINT `invoices_lead_id_foreign` FOREIGN KEY (`lead_id`) REFERENCES `leads` (`id`);

--
-- Constraints for table `leads`
--
ALTER TABLE `leads`
  ADD CONSTRAINT `leads_assignee_id_foreign` FOREIGN KEY (`assignee_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `leads_contact_language_id_foreign` FOREIGN KEY (`contact_language_id`) REFERENCES `contact_languages` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `leads_contact_method_id_foreign` FOREIGN KEY (`contact_method_id`) REFERENCES `contact_methods` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `leads_lead_source_id_foreign` FOREIGN KEY (`lead_source_id`) REFERENCES `lead_sources` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `leads_lead_status_id_foreign` FOREIGN KEY (`lead_status_id`) REFERENCES `lead_statuses` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
  ADD CONSTRAINT `payments_payment_method_id_foreign` FOREIGN KEY (`payment_method_id`) REFERENCES `payment_methods` (`id`),
  ADD CONSTRAINT `payments_payment_status_id_foreign` FOREIGN KEY (`payment_status_id`) REFERENCES `payment_statuses` (`id`),
  ADD CONSTRAINT `payments_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`);

--
-- Constraints for table `permission_role`
--
ALTER TABLE `permission_role`
  ADD CONSTRAINT `permission_role_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `permission_role_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `permission_user`
--
ALTER TABLE `permission_user`
  ADD CONSTRAINT `permission_user_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `projects`
--
ALTER TABLE `projects`
  ADD CONSTRAINT `projects_assigned_to_foreign` FOREIGN KEY (`assigned_to`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `projects_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
  ADD CONSTRAINT `projects_project_status_id_foreign` FOREIGN KEY (`project_status_id`) REFERENCES `project_statuses` (`id`),
  ADD CONSTRAINT `projects_project_type_id_foreign` FOREIGN KEY (`project_type_id`) REFERENCES `project_types` (`id`);

--
-- Constraints for table `role_user`
--
ALTER TABLE `role_user`
  ADD CONSTRAINT `role_user_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tickets`
--
ALTER TABLE `tickets`
  ADD CONSTRAINT `tickets_assigned_to_foreign` FOREIGN KEY (`assigned_to`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tickets_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tickets_ticket_category_id_foreign` FOREIGN KEY (`ticket_category_id`) REFERENCES `ticket_categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `vendors`
--
ALTER TABLE `vendors`
  ADD CONSTRAINT `vendors_vendor_status_id_foreign` FOREIGN KEY (`vendor_status_id`) REFERENCES `vendor_statuses` (`id`),
  ADD CONSTRAINT `vendors_vendor_type_id_foreign` FOREIGN KEY (`vendor_type_id`) REFERENCES `vendor_types` (`id`);

--
-- Constraints for table `vendor_users`
--
ALTER TABLE `vendor_users`
  ADD CONSTRAINT `vendor_users_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `vendor_users_vendor_id_foreign` FOREIGN KEY (`vendor_id`) REFERENCES `vendors` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
