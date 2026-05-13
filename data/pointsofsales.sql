-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 22, 2026 at 02:21 PM
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
-- Database: `master_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendance_credentials`
--

CREATE TABLE `attendance_credentials` (
  `emp_num` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `is_active` tinyint(4) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attendance_credentials`
--

INSERT INTO `attendance_credentials` (`emp_num`, `password`, `is_active`, `created_at`) VALUES
('2021-001', '1111', 1, '2026-04-19 09:02:08'),
('2021-003', '1111', 1, '2026-04-16 07:18:27'),
('2021-005', '1111', 1, '2026-04-19 09:03:13'),
('2021-007', '1111', 1, '2026-04-19 12:56:29'),
('2021-012', '1111', 1, '2026-04-19 12:56:51'),
('2021-018', '1111', 1, '2026-04-19 12:56:17'),
('2021-019', '1111', 1, '2026-04-19 12:56:05'),
('2021-030', '1111', 1, '2026-04-19 12:57:49'),
('2021-033', '1111', 1, '2026-04-19 12:57:57'),
('2021-035', '1111', 1, '2026-04-19 08:58:22'),
('2021-036', '1111', 1, '2026-04-19 12:58:05'),
('2021-043', '1111', 1, '2026-04-19 12:57:40'),
('2021-045', '1111', 1, '2026-04-19 12:56:59'),
('2021-089', '1111', 1, '2026-04-19 08:56:59'),
('2021-096', '1111\r\n', 1, '2026-04-19 12:56:44'),
('2021-098', '1111', 1, '2026-04-16 07:05:00');

-- --------------------------------------------------------

--
-- Table structure for table `attendance_logs`
--

CREATE TABLE `attendance_logs` (
  `id` int(11) NOT NULL,
  `emp_id` int(11) NOT NULL,
  `emp_num` varchar(50) NOT NULL,
  `employee_name` varchar(150) NOT NULL,
  `log_date` date NOT NULL,
  `time_in` datetime DEFAULT NULL,
  `time_out` datetime DEFAULT NULL,
  `status` varchar(20) DEFAULT 'IN',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attendance_logs`
--

INSERT INTO `attendance_logs` (`id`, `emp_id`, `emp_num`, `employee_name`, `log_date`, `time_in`, `time_out`, `status`, `created_at`, `updated_at`) VALUES
(1, 118, '2021-003', 'AILA MARIE BATA-ANON', '2026-03-23', '2026-03-23 08:02:11', '2026-03-23 17:15:43', 'Present', '2026-03-23 08:02:11', NULL),
(2, 118, '2021-003', 'AILA MARIE BATA-ANON', '2026-03-24', '2026-03-24 10:45:22', '2026-03-24 20:13:07', 'Late', '2026-03-24 10:45:22', NULL),
(3, 118, '2021-003', 'AILA MARIE BATA-ANON', '2026-03-25', '2026-03-25 07:48:55', '2026-03-25 16:52:30', 'Early', '2026-03-25 07:48:55', NULL),
(4, 118, '2021-003', 'AILA MARIE BATA-ANON', '2026-03-26', NULL, NULL, 'Absent', '2026-03-26 00:00:00', NULL),
(5, 118, '2021-003', 'AILA MARIE BATA-ANON', '2026-03-27', '2026-03-27 08:11:33', '2026-03-27 17:04:19', 'Present', '2026-03-27 08:11:33', NULL),
(6, 118, '2021-003', 'AILA MARIE BATA-ANON', '2026-03-28', '2026-03-28 10:58:44', '2026-03-28 20:47:12', 'Late', '2026-03-28 10:58:44', NULL),
(7, 118, '2021-003', 'AILA MARIE BATA-ANON', '2026-03-29', '2026-03-29 07:55:10', '2026-03-29 16:49:38', 'Early', '2026-03-29 07:55:10', NULL),
(8, 118, '2021-003', 'AILA MARIE BATA-ANON', '2026-03-30', '2026-03-30 08:07:29', '2026-03-30 17:22:54', 'Present', '2026-03-30 08:07:29', NULL),
(9, 118, '2021-003', 'AILA MARIE BATA-ANON', '2026-03-31', NULL, NULL, 'Absent', '2026-03-31 00:00:00', NULL),
(10, 118, '2021-003', 'AILA MARIE BATA-ANON', '2026-04-01', '2026-04-01 10:33:18', '2026-04-01 20:01:45', 'Late', '2026-04-01 10:33:18', NULL),
(11, 118, '2021-003', 'AILA MARIE BATA-ANON', '2026-04-02', '2026-04-02 07:52:41', '2026-04-02 16:58:23', 'Early', '2026-04-02 07:52:41', NULL),
(12, 118, '2021-003', 'AILA MARIE BATA-ANON', '2026-04-03', '2026-04-03 08:04:57', '2026-04-03 17:11:36', 'Present', '2026-04-03 08:04:57', NULL),
(13, 118, '2021-003', 'AILA MARIE BATA-ANON', '2026-04-04', '2026-04-04 11:02:33', '2026-04-04 20:55:47', 'Late', '2026-04-04 11:02:33', NULL),
(14, 118, '2021-003', 'AILA MARIE BATA-ANON', '2026-04-05', NULL, NULL, 'Absent', '2026-04-05 00:00:00', NULL),
(15, 118, '2021-003', 'AILA MARIE BATA-ANON', '2026-04-06', '2026-04-06 07:44:16', '2026-04-06 16:37:52', 'Early', '2026-04-06 07:44:16', NULL),
(16, 118, '2021-003', 'AILA MARIE BATA-ANON', '2026-04-07', '2026-04-07 08:09:42', '2026-04-07 17:18:29', 'Present', '2026-04-07 08:09:42', NULL),
(17, 118, '2021-003', 'AILA MARIE BATA-ANON', '2026-04-08', '2026-04-08 10:41:05', '2026-04-08 19:58:33', 'Late', '2026-04-08 10:41:05', NULL),
(18, 118, '2021-003', 'AILA MARIE BATA-ANON', '2026-04-09', '2026-04-09 08:01:28', '2026-04-09 17:09:14', 'Present', '2026-04-09 08:01:28', NULL),
(19, 118, '2021-003', 'AILA MARIE BATA-ANON', '2026-04-10', '2026-04-10 07:50:39', '2026-04-10 16:44:07', 'Early', '2026-04-10 07:50:39', NULL),
(20, 118, '2021-003', 'AILA MARIE BATA-ANON', '2026-04-11', NULL, NULL, 'Absent', '2026-04-11 00:00:00', NULL),
(21, 118, '2021-003', 'AILA MARIE BATA-ANON', '2026-04-12', '2026-04-12 10:52:17', '2026-04-12 20:38:41', 'Late', '2026-04-12 10:52:17', NULL),
(22, 118, '2021-003', 'AILA MARIE BATA-ANON', '2026-04-13', '2026-04-13 08:06:53', '2026-04-13 17:14:22', 'Present', '2026-04-13 08:06:53', NULL),
(23, 118, '2021-003', 'AILA MARIE BATA-ANON', '2026-04-14', '2026-04-14 07:46:31', '2026-04-14 16:40:18', 'Early', '2026-04-14 07:46:31', NULL),
(24, 118, '2021-003', 'AILA MARIE BATA-ANON', '2026-04-15', '2026-04-15 08:13:44', '2026-04-15 17:21:09', 'Present', '2026-04-15 08:13:44', NULL),
(25, 118, '2021-003', 'AILA MARIE BATA-ANON', '2026-04-16', '2026-04-16 11:15:28', '2026-04-16 21:03:55', 'Late', '2026-04-16 11:15:28', NULL),
(26, 118, '2021-003', 'AILA MARIE BATA-ANON', '2026-04-17', NULL, NULL, 'Absent', '2026-04-17 00:00:00', NULL),
(27, 118, '2021-003', 'AILA MARIE BATA-ANON', '2026-04-18', '2026-04-18 07:53:26', '2026-04-18 16:47:13', 'Early', '2026-04-18 07:53:26', NULL),
(28, 118, '2021-003', 'AILA MARIE BATA-ANON', '2026-04-19', '2026-04-19 10:59:03', '2026-04-19 20:51:26', 'Late', '2026-04-19 16:59:03', NULL),
(29, 118, '2021-003', 'AILA MARIE BATA-ANON', '2026-04-20', '2026-04-20 08:08:37', '2026-04-20 17:16:54', 'Present', '2026-04-20 08:08:37', NULL),
(30, 118, '2021-003', 'AILA MARIE BATA-ANON', '2026-04-21', '2026-04-21 16:11:24', '2026-04-21 16:39:04', 'Late', '2026-04-21 16:11:24', NULL),
(31, 120, '2021-035', 'AIREEN EVANGELISTA', '2026-03-23', '2026-03-23 10:47:19', '2026-03-23 20:22:35', 'Late', '2026-03-23 10:47:19', NULL),
(32, 120, '2021-035', 'AIREEN EVANGELISTA', '2026-03-24', '2026-03-24 08:03:44', '2026-03-24 17:08:21', 'Present', '2026-03-24 08:03:44', NULL),
(33, 120, '2021-035', 'AIREEN EVANGELISTA', '2026-03-25', NULL, NULL, 'Absent', '2026-03-25 00:00:00', NULL),
(34, 120, '2021-035', 'AIREEN EVANGELISTA', '2026-03-26', '2026-03-26 07:51:08', '2026-03-26 16:55:43', 'Early', '2026-03-26 07:51:08', NULL),
(35, 120, '2021-035', 'AIREEN EVANGELISTA', '2026-03-27', '2026-03-27 08:05:32', '2026-03-27 17:13:17', 'Present', '2026-03-27 08:05:32', NULL),
(36, 120, '2021-035', 'AIREEN EVANGELISTA', '2026-03-28', '2026-03-28 11:08:57', '2026-03-28 21:02:34', 'Late', '2026-03-28 11:08:57', NULL),
(37, 120, '2021-035', 'AIREEN EVANGELISTA', '2026-03-29', '2026-03-29 07:48:23', '2026-03-29 16:41:59', 'Early', '2026-03-29 07:48:23', NULL),
(38, 120, '2021-035', 'AIREEN EVANGELISTA', '2026-03-30', NULL, NULL, 'Absent', '2026-03-30 00:00:00', NULL),
(39, 120, '2021-035', 'AIREEN EVANGELISTA', '2026-03-31', '2026-03-31 08:12:46', '2026-03-31 17:19:33', 'Present', '2026-03-31 08:12:46', NULL),
(40, 120, '2021-035', 'AIREEN EVANGELISTA', '2026-04-01', '2026-04-01 10:38:15', '2026-04-01 20:29:48', 'Late', '2026-04-01 10:38:15', NULL),
(41, 120, '2021-035', 'AIREEN EVANGELISTA', '2026-04-02', '2026-04-02 07:55:39', '2026-04-02 16:48:26', 'Early', '2026-04-02 07:55:39', NULL),
(42, 120, '2021-035', 'AIREEN EVANGELISTA', '2026-04-03', '2026-04-03 08:01:14', '2026-04-03 17:07:52', 'Present', '2026-04-03 08:01:14', NULL),
(43, 120, '2021-035', 'AIREEN EVANGELISTA', '2026-04-04', NULL, NULL, 'Absent', '2026-04-04 00:00:00', NULL),
(44, 120, '2021-035', 'AIREEN EVANGELISTA', '2026-04-05', '2026-04-05 10:55:27', '2026-04-05 20:43:14', 'Late', '2026-04-05 10:55:27', NULL),
(45, 120, '2021-035', 'AIREEN EVANGELISTA', '2026-04-06', '2026-04-06 08:07:53', '2026-04-06 17:15:41', 'Present', '2026-04-06 08:07:53', NULL),
(46, 120, '2021-035', 'AIREEN EVANGELISTA', '2026-04-07', '2026-04-07 07:43:28', '2026-04-07 16:36:55', 'Early', '2026-04-07 07:43:28', NULL),
(47, 120, '2021-035', 'AIREEN EVANGELISTA', '2026-04-08', '2026-04-08 08:09:41', '2026-04-08 17:18:27', 'Present', '2026-04-08 08:09:41', NULL),
(48, 120, '2021-035', 'AIREEN EVANGELISTA', '2026-04-09', '2026-04-09 11:12:33', '2026-04-09 21:05:49', 'Late', '2026-04-09 11:12:33', NULL),
(49, 120, '2021-035', 'AIREEN EVANGELISTA', '2026-04-10', NULL, NULL, 'Absent', '2026-04-10 00:00:00', NULL),
(50, 120, '2021-035', 'AIREEN EVANGELISTA', '2026-04-11', '2026-04-11 07:49:17', '2026-04-11 16:42:44', 'Early', '2026-04-11 07:49:17', NULL),
(51, 120, '2021-035', 'AIREEN EVANGELISTA', '2026-04-12', '2026-04-12 08:04:29', '2026-04-12 17:12:16', 'Present', '2026-04-12 08:04:29', NULL),
(52, 120, '2021-035', 'AIREEN EVANGELISTA', '2026-04-13', '2026-04-13 10:43:52', '2026-04-13 20:37:19', 'Late', '2026-04-13 10:43:52', NULL),
(53, 120, '2021-035', 'AIREEN EVANGELISTA', '2026-04-14', '2026-04-14 08:06:18', '2026-04-14 17:14:05', 'Present', '2026-04-14 08:06:18', NULL),
(54, 120, '2021-035', 'AIREEN EVANGELISTA', '2026-04-15', '2026-04-15 07:46:44', '2026-04-15 16:40:31', 'Early', '2026-04-15 07:46:44', NULL),
(55, 120, '2021-035', 'AIREEN EVANGELISTA', '2026-04-16', NULL, NULL, 'Absent', '2026-04-16 00:00:00', NULL),
(56, 120, '2021-035', 'AIREEN EVANGELISTA', '2026-04-17', '2026-04-17 08:11:56', '2026-04-17 17:19:43', 'Present', '2026-04-17 08:11:56', NULL),
(57, 120, '2021-035', 'AIREEN EVANGELISTA', '2026-04-18', '2026-04-18 10:57:31', '2026-04-18 20:50:18', 'Late', '2026-04-18 10:57:31', NULL),
(58, 120, '2021-035', 'AIREEN EVANGELISTA', '2026-04-19', '2026-04-19 10:59:14', '2026-04-19 14:37:50', 'Late', '2026-04-19 16:59:14', NULL),
(59, 120, '2021-035', 'AIREEN EVANGELISTA', '2026-04-20', '2026-04-20 07:52:43', '2026-04-20 16:46:19', 'Early', '2026-04-20 07:52:43', NULL),
(60, 120, '2021-035', 'AIREEN EVANGELISTA', '2026-04-21', '2026-04-21 08:08:22', '2026-04-21 17:16:09', 'Present', '2026-04-21 08:08:22', NULL),
(61, 119, '2021-089', 'AILONA LIPIT', '2026-03-23', '2026-03-23 08:05:47', '2026-03-23 17:12:34', 'Present', '2026-03-23 08:05:47', NULL),
(62, 119, '2021-089', 'AILONA LIPIT', '2026-03-24', NULL, NULL, 'Absent', '2026-03-24 00:00:00', NULL),
(63, 119, '2021-089', 'AILONA LIPIT', '2026-03-25', '2026-03-25 10:44:28', '2026-03-25 20:31:15', 'Late', '2026-03-25 10:44:28', NULL),
(64, 119, '2021-089', 'AILONA LIPIT', '2026-03-26', '2026-03-26 07:53:41', '2026-03-26 16:47:18', 'Early', '2026-03-26 07:53:41', NULL),
(65, 119, '2021-089', 'AILONA LIPIT', '2026-03-27', '2026-03-27 08:02:19', '2026-03-27 17:10:06', 'Present', '2026-03-27 08:02:19', NULL),
(66, 119, '2021-089', 'AILONA LIPIT', '2026-03-28', '2026-03-28 10:51:34', '2026-03-28 20:45:01', 'Late', '2026-03-28 10:51:34', NULL),
(67, 119, '2021-089', 'AILONA LIPIT', '2026-03-29', NULL, NULL, 'Absent', '2026-03-29 00:00:00', NULL),
(68, 119, '2021-089', 'AILONA LIPIT', '2026-03-30', '2026-03-30 08:08:53', '2026-03-30 17:17:40', 'Present', '2026-03-30 08:08:53', NULL),
(69, 119, '2021-089', 'AILONA LIPIT', '2026-03-31', '2026-03-31 07:47:26', '2026-03-31 16:41:13', 'Early', '2026-03-31 07:47:26', NULL),
(70, 119, '2021-089', 'AILONA LIPIT', '2026-04-01', '2026-04-01 08:10:38', '2026-04-01 17:18:25', 'Present', '2026-04-01 08:10:38', NULL),
(71, 119, '2021-089', 'AILONA LIPIT', '2026-04-02', '2026-04-02 11:05:49', '2026-04-02 21:00:16', 'Late', '2026-04-02 11:05:49', NULL),
(72, 119, '2021-089', 'AILONA LIPIT', '2026-04-03', NULL, NULL, 'Absent', '2026-04-03 00:00:00', NULL),
(73, 119, '2021-089', 'AILONA LIPIT', '2026-04-04', '2026-04-04 07:50:12', '2026-04-04 16:43:49', 'Early', '2026-04-04 07:50:12', NULL),
(74, 119, '2021-089', 'AILONA LIPIT', '2026-04-05', '2026-04-05 08:03:27', '2026-04-05 17:11:14', 'Present', '2026-04-05 08:03:27', NULL),
(75, 119, '2021-089', 'AILONA LIPIT', '2026-04-06', '2026-04-06 10:49:53', '2026-04-06 20:43:30', 'Late', '2026-04-06 10:49:53', NULL),
(76, 119, '2021-089', 'AILONA LIPIT', '2026-04-07', '2026-04-07 08:06:44', '2026-04-07 17:14:31', 'Present', '2026-04-07 08:06:44', NULL),
(77, 119, '2021-089', 'AILONA LIPIT', '2026-04-08', '2026-04-08 07:44:59', '2026-04-08 16:38:36', 'Early', '2026-04-08 07:44:59', NULL),
(78, 119, '2021-089', 'AILONA LIPIT', '2026-04-09', NULL, NULL, 'Absent', '2026-04-09 00:00:00', NULL),
(79, 119, '2021-089', 'AILONA LIPIT', '2026-04-10', '2026-04-10 08:01:33', '2026-04-10 17:09:20', 'Present', '2026-04-10 08:01:33', NULL),
(80, 119, '2021-089', 'AILONA LIPIT', '2026-04-11', '2026-04-11 10:53:47', '2026-04-11 20:47:24', 'Late', '2026-04-11 10:53:47', NULL),
(81, 119, '2021-089', 'AILONA LIPIT', '2026-04-12', '2026-04-12 07:48:22', '2026-04-12 16:42:09', 'Early', '2026-04-12 07:48:22', NULL),
(82, 119, '2021-089', 'AILONA LIPIT', '2026-04-13', '2026-04-13 08:07:16', '2026-04-13 17:15:03', 'Present', '2026-04-13 08:07:16', NULL),
(83, 119, '2021-089', 'AILONA LIPIT', '2026-04-14', NULL, NULL, 'Absent', '2026-04-14 00:00:00', NULL),
(84, 119, '2021-089', 'AILONA LIPIT', '2026-04-15', '2026-04-15 11:10:41', '2026-04-15 21:04:18', 'Late', '2026-04-15 11:10:41', NULL),
(85, 119, '2021-089', 'AILONA LIPIT', '2026-04-16', '2026-04-16 08:04:58', '2026-04-16 17:12:45', 'Present', '2026-04-16 08:04:58', NULL),
(86, 119, '2021-089', 'AILONA LIPIT', '2026-04-17', '2026-04-17 07:51:33', '2026-04-17 16:45:10', 'Early', '2026-04-17 07:51:33', NULL),
(87, 119, '2021-089', 'AILONA LIPIT', '2026-04-18', '2026-04-18 08:09:27', '2026-04-18 17:17:14', 'Present', '2026-04-18 08:09:27', NULL),
(88, 119, '2021-089', 'AILONA LIPIT', '2026-04-19', '2026-04-19 10:59:26', '2026-04-19 14:37:43', 'Late', '2026-04-19 16:59:26', NULL),
(89, 119, '2021-089', 'AILONA LIPIT', '2026-04-20', NULL, NULL, 'Absent', '2026-04-20 00:00:00', NULL),
(90, 119, '2021-089', 'AILONA LIPIT', '2026-04-21', '2026-04-21 07:46:15', '2026-04-21 16:39:52', 'Early', '2026-04-21 07:46:15', NULL),
(91, 116, '2021-098', 'ABEGAIL PASIA', '2026-03-23', '2026-03-23 10:52:37', '2026-03-23 20:46:14', 'Late', '2026-03-23 10:52:37', NULL),
(92, 116, '2021-098', 'ABEGAIL PASIA', '2026-03-24', '2026-03-24 07:49:53', '2026-03-24 16:43:30', 'Early', '2026-03-24 07:49:53', NULL),
(93, 116, '2021-098', 'ABEGAIL PASIA', '2026-03-25', '2026-03-25 08:06:28', '2026-03-25 17:14:15', 'Present', '2026-03-25 08:06:28', NULL),
(94, 116, '2021-098', 'ABEGAIL PASIA', '2026-03-26', NULL, NULL, 'Absent', '2026-03-26 00:00:00', NULL),
(95, 116, '2021-098', 'ABEGAIL PASIA', '2026-03-27', '2026-03-27 10:46:41', '2026-03-27 20:40:18', 'Late', '2026-03-27 10:46:41', NULL),
(96, 116, '2021-098', 'ABEGAIL PASIA', '2026-03-28', '2026-03-28 08:03:54', '2026-03-28 17:11:41', 'Present', '2026-03-28 08:03:54', NULL),
(97, 116, '2021-098', 'ABEGAIL PASIA', '2026-03-29', '2026-03-29 07:52:19', '2026-03-29 16:46:06', 'Early', '2026-03-29 07:52:19', NULL),
(98, 116, '2021-098', 'ABEGAIL PASIA', '2026-03-30', NULL, NULL, 'Absent', '2026-03-30 00:00:00', NULL),
(99, 116, '2021-098', 'ABEGAIL PASIA', '2026-03-31', '2026-03-31 08:08:42', '2026-03-31 17:16:29', 'Present', '2026-03-31 08:08:42', NULL),
(100, 116, '2021-098', 'ABEGAIL PASIA', '2026-04-01', '2026-04-01 11:03:15', '2026-04-01 20:57:52', 'Late', '2026-04-01 11:03:15', NULL),
(101, 116, '2021-098', 'ABEGAIL PASIA', '2026-04-02', '2026-04-02 07:45:38', '2026-04-02 16:39:25', 'Early', '2026-04-02 07:45:38', NULL),
(102, 116, '2021-098', 'ABEGAIL PASIA', '2026-04-03', '2026-04-03 08:10:51', '2026-04-03 17:18:38', 'Present', '2026-04-03 08:10:51', NULL),
(103, 116, '2021-098', 'ABEGAIL PASIA', '2026-04-04', '2026-04-04 10:57:24', '2026-04-04 20:51:01', 'Late', '2026-04-04 10:57:24', NULL),
(104, 116, '2021-098', 'ABEGAIL PASIA', '2026-04-05', NULL, NULL, 'Absent', '2026-04-05 00:00:00', NULL),
(105, 116, '2021-098', 'ABEGAIL PASIA', '2026-04-06', '2026-04-06 08:02:37', '2026-04-06 17:10:24', 'Present', '2026-04-06 08:02:37', NULL),
(106, 116, '2021-098', 'ABEGAIL PASIA', '2026-04-07', '2026-04-07 07:47:12', '2026-04-07 16:40:49', 'Early', '2026-04-07 07:47:12', NULL),
(107, 116, '2021-098', 'ABEGAIL PASIA', '2026-04-08', '2026-04-08 08:11:26', '2026-04-08 17:19:13', 'Present', '2026-04-08 08:11:26', NULL),
(108, 116, '2021-098', 'ABEGAIL PASIA', '2026-04-09', '2026-04-09 10:44:39', '2026-04-09 20:38:16', 'Late', '2026-04-09 10:44:39', NULL),
(109, 116, '2021-098', 'ABEGAIL PASIA', '2026-04-10', NULL, NULL, 'Absent', '2026-04-10 00:00:00', NULL),
(110, 116, '2021-098', 'ABEGAIL PASIA', '2026-04-11', '2026-04-11 07:53:48', '2026-04-11 16:47:25', 'Early', '2026-04-11 07:53:48', NULL),
(111, 116, '2021-098', 'ABEGAIL PASIA', '2026-04-12', '2026-04-12 08:05:13', '2026-04-12 17:13:00', 'Present', '2026-04-12 08:05:13', NULL),
(112, 116, '2021-098', 'ABEGAIL PASIA', '2026-04-13', '2026-04-13 11:09:27', '2026-04-13 21:03:04', 'Late', '2026-04-13 11:09:27', NULL),
(113, 116, '2021-098', 'ABEGAIL PASIA', '2026-04-14', '2026-04-14 08:07:42', '2026-04-14 17:15:29', 'Present', '2026-04-14 08:07:42', NULL),
(114, 116, '2021-098', 'ABEGAIL PASIA', '2026-04-15', '2026-04-15 07:48:57', '2026-04-15 16:42:34', 'Early', '2026-04-15 07:48:57', NULL),
(115, 116, '2021-098', 'ABEGAIL PASIA', '2026-04-16', '2026-04-16 08:04:21', '2026-04-16 17:12:08', 'Present', '2026-04-16 08:04:21', NULL),
(116, 116, '2021-098', 'ABEGAIL PASIA', '2026-04-17', NULL, NULL, 'Absent', '2026-04-17 00:00:00', NULL),
(117, 116, '2021-098', 'ABEGAIL PASIA', '2026-04-18', '2026-04-18 10:50:33', '2026-04-18 20:44:10', 'Late', '2026-04-18 10:50:33', NULL),
(118, 116, '2021-098', 'ABEGAIL PASIA', '2026-04-19', '2026-04-19 10:59:37', '2026-04-19 14:37:35', 'Late', '2026-04-19 16:59:37', NULL),
(119, 116, '2021-098', 'ABEGAIL PASIA', '2026-04-20', '2026-04-20 07:51:16', '2026-04-20 16:45:03', 'Early', '2026-04-20 07:51:16', NULL),
(120, 116, '2021-098', 'ABEGAIL PASIA', '2026-04-21', '2026-04-21 16:11:10', '2026-04-21 16:39:23', 'Late', '2026-04-21 16:11:10', NULL),
(121, 201, '2021-005', 'MAI NICOLE OLAGUER', '2026-03-23', '2026-03-23 07:55:29', '2026-03-23 16:49:06', 'Early', '2026-03-23 07:55:29', NULL),
(122, 201, '2021-005', 'MAI NICOLE OLAGUER', '2026-03-24', '2026-03-24 08:04:52', '2026-03-24 17:12:39', 'Present', '2026-03-24 08:04:52', NULL),
(123, 201, '2021-005', 'MAI NICOLE OLAGUER', '2026-03-25', '2026-03-25 10:53:28', '2026-03-25 20:47:05', 'Late', '2026-03-25 10:53:28', NULL),
(124, 201, '2021-005', 'MAI NICOLE OLAGUER', '2026-03-26', NULL, NULL, 'Absent', '2026-03-26 00:00:00', NULL),
(125, 201, '2021-005', 'MAI NICOLE OLAGUER', '2026-03-27', '2026-03-27 08:07:43', '2026-03-27 17:15:30', 'Present', '2026-03-27 08:07:43', NULL),
(126, 201, '2021-005', 'MAI NICOLE OLAGUER', '2026-03-28', '2026-03-28 07:46:58', '2026-03-28 16:40:35', 'Early', '2026-03-28 07:46:58', NULL),
(127, 201, '2021-005', 'MAI NICOLE OLAGUER', '2026-03-29', '2026-03-29 08:09:14', '2026-03-29 17:17:01', 'Present', '2026-03-29 08:09:14', NULL),
(128, 201, '2021-005', 'MAI NICOLE OLAGUER', '2026-03-30', '2026-03-30 11:06:37', '2026-03-30 21:00:14', 'Late', '2026-03-30 11:06:37', NULL),
(129, 201, '2021-005', 'MAI NICOLE OLAGUER', '2026-03-31', NULL, NULL, 'Absent', '2026-03-31 00:00:00', NULL),
(130, 201, '2021-005', 'MAI NICOLE OLAGUER', '2026-04-01', '2026-04-01 07:52:51', '2026-04-01 16:46:28', 'Early', '2026-04-01 07:52:51', NULL),
(131, 201, '2021-005', 'MAI NICOLE OLAGUER', '2026-04-02', '2026-04-02 08:03:16', '2026-04-02 17:11:03', 'Present', '2026-04-02 08:03:16', NULL),
(132, 201, '2021-005', 'MAI NICOLE OLAGUER', '2026-04-03', '2026-04-03 10:48:43', '2026-04-03 20:42:20', 'Late', '2026-04-03 10:48:43', NULL),
(133, 201, '2021-005', 'MAI NICOLE OLAGUER', '2026-04-04', '2026-04-04 08:06:58', '2026-04-04 17:14:45', 'Present', '2026-04-04 08:06:58', NULL),
(134, 201, '2021-005', 'MAI NICOLE OLAGUER', '2026-04-05', '2026-04-05 07:50:23', '2026-04-05 16:44:00', 'Early', '2026-04-05 07:50:23', NULL),
(135, 201, '2021-005', 'MAI NICOLE OLAGUER', '2026-04-06', NULL, NULL, 'Absent', '2026-04-06 00:00:00', NULL),
(136, 201, '2021-005', 'MAI NICOLE OLAGUER', '2026-04-07', '2026-04-07 08:11:35', '2026-04-07 17:19:22', 'Present', '2026-04-07 08:11:35', NULL),
(137, 201, '2021-005', 'MAI NICOLE OLAGUER', '2026-04-08', '2026-04-08 10:55:49', '2026-04-08 20:49:26', 'Late', '2026-04-08 10:55:49', NULL),
(138, 201, '2021-005', 'MAI NICOLE OLAGUER', '2026-04-09', '2026-04-09 07:47:14', '2026-04-09 16:40:51', 'Early', '2026-04-09 07:47:14', NULL),
(139, 201, '2021-005', 'MAI NICOLE OLAGUER', '2026-04-10', '2026-04-10 08:02:39', '2026-04-10 17:10:26', 'Present', '2026-04-10 08:02:39', NULL),
(140, 201, '2021-005', 'MAI NICOLE OLAGUER', '2026-04-11', NULL, NULL, 'Absent', '2026-04-11 00:00:00', NULL),
(141, 201, '2021-005', 'MAI NICOLE OLAGUER', '2026-04-12', '2026-04-12 11:13:25', '2026-04-12 21:07:02', 'Late', '2026-04-12 11:13:25', NULL),
(142, 201, '2021-005', 'MAI NICOLE OLAGUER', '2026-04-13', '2026-04-13 08:08:41', '2026-04-13 17:16:28', 'Present', '2026-04-13 08:08:41', NULL),
(143, 201, '2021-005', 'MAI NICOLE OLAGUER', '2026-04-14', '2026-04-14 07:53:16', '2026-04-14 16:47:03', 'Early', '2026-04-14 07:53:16', NULL),
(144, 201, '2021-005', 'MAI NICOLE OLAGUER', '2026-04-15', '2026-04-15 08:05:52', '2026-04-15 17:13:39', 'Present', '2026-04-15 08:05:52', NULL),
(145, 201, '2021-005', 'MAI NICOLE OLAGUER', '2026-04-16', '2026-04-16 10:42:27', '2026-04-16 20:36:04', 'Late', '2026-04-16 10:42:27', NULL),
(146, 201, '2021-005', 'MAI NICOLE OLAGUER', '2026-04-17', '2026-04-17 07:48:53', '2026-04-17 16:42:30', 'Early', '2026-04-17 07:48:53', NULL),
(147, 201, '2021-005', 'MAI NICOLE OLAGUER', '2026-04-18', NULL, NULL, 'Absent', '2026-04-18 00:00:00', NULL),
(148, 201, '2021-005', 'MAI NICOLE OLAGUER', '2026-04-19', '2026-04-19 11:03:23', '2026-04-19 14:37:23', 'Late', '2026-04-19 17:03:23', NULL),
(149, 201, '2021-005', 'MAI NICOLE OLAGUER', '2026-04-20', '2026-04-20 08:10:17', '2026-04-20 17:18:04', 'Present', '2026-04-20 08:10:17', NULL),
(150, 201, '2021-005', 'MAI NICOLE OLAGUER', '2026-04-21', '2026-04-21 07:54:39', '2026-04-21 16:48:26', 'Early', '2026-04-21 07:54:39', NULL),
(151, 205, '2021-019', 'MARK ELABA', '2026-03-23', '2026-03-23 20:51:42', '2026-03-24 06:45:19', 'Present', '2026-03-23 20:51:42', NULL),
(152, 205, '2021-019', 'MARK ELABA', '2026-03-24', NULL, NULL, 'Absent', '2026-03-24 00:00:00', NULL),
(153, 205, '2021-019', 'MARK ELABA', '2026-03-25', '2026-03-25 21:14:33', '2026-03-26 07:08:10', 'Late', '2026-03-25 21:14:33', NULL),
(154, 205, '2021-019', 'MARK ELABA', '2026-03-26', '2026-03-26 20:48:57', '2026-03-27 06:42:34', 'Present', '2026-03-26 20:48:57', NULL),
(155, 205, '2021-019', 'MARK ELABA', '2026-03-27', '2026-03-27 20:43:22', '2026-03-28 06:37:09', 'Early', '2026-03-27 20:43:22', NULL),
(156, 205, '2021-019', 'MARK ELABA', '2026-03-28', '2026-03-28 21:07:48', '2026-03-29 07:01:25', 'Late', '2026-03-28 21:07:48', NULL),
(157, 205, '2021-019', 'MARK ELABA', '2026-03-29', NULL, NULL, 'Absent', '2026-03-29 00:00:00', NULL),
(158, 205, '2021-019', 'MARK ELABA', '2026-03-30', '2026-03-30 20:53:14', '2026-03-31 06:46:51', 'Present', '2026-03-30 20:53:14', NULL),
(159, 205, '2021-019', 'MARK ELABA', '2026-03-31', '2026-03-31 20:46:39', '2026-04-01 06:40:16', 'Early', '2026-03-31 20:46:39', NULL),
(160, 205, '2021-019', 'MARK ELABA', '2026-04-01', '2026-04-01 21:19:05', '2026-04-02 07:12:42', 'Late', '2026-04-01 21:19:05', NULL),
(161, 205, '2021-019', 'MARK ELABA', '2026-04-02', '2026-04-02 20:55:30', '2026-04-03 06:49:07', 'Present', '2026-04-02 20:55:30', NULL),
(162, 205, '2021-019', 'MARK ELABA', '2026-04-03', NULL, NULL, 'Absent', '2026-04-03 00:00:00', NULL),
(163, 205, '2021-019', 'MARK ELABA', '2026-04-04', '2026-04-04 20:49:55', '2026-04-05 06:43:32', 'Early', '2026-04-04 20:49:55', NULL),
(164, 205, '2021-019', 'MARK ELABA', '2026-04-05', '2026-04-05 21:02:21', '2026-04-06 06:55:58', 'Present', '2026-04-05 21:02:21', NULL),
(165, 205, '2021-019', 'MARK ELABA', '2026-04-06', '2026-04-06 21:22:47', '2026-04-07 07:16:24', 'Late', '2026-04-06 21:22:47', NULL),
(166, 205, '2021-019', 'MARK ELABA', '2026-04-07', '2026-04-07 20:57:12', '2026-04-08 06:50:49', 'Present', '2026-04-07 20:57:12', NULL),
(167, 205, '2021-019', 'MARK ELABA', '2026-04-08', '2026-04-08 20:44:37', '2026-04-09 06:38:14', 'Early', '2026-04-08 20:44:37', NULL),
(168, 205, '2021-019', 'MARK ELABA', '2026-04-09', NULL, NULL, 'Absent', '2026-04-09 00:00:00', NULL),
(169, 205, '2021-019', 'MARK ELABA', '2026-04-10', '2026-04-10 21:10:03', '2026-04-11 07:03:40', 'Late', '2026-04-10 21:10:03', NULL),
(170, 205, '2021-019', 'MARK ELABA', '2026-04-11', '2026-04-11 20:52:28', '2026-04-12 06:46:05', 'Present', '2026-04-11 20:52:28', NULL),
(171, 205, '2021-019', 'MARK ELABA', '2026-04-12', '2026-04-12 20:47:53', '2026-04-13 06:41:30', 'Early', '2026-04-12 20:47:53', NULL),
(172, 205, '2021-019', 'MARK ELABA', '2026-04-13', '2026-04-13 21:15:19', '2026-04-14 07:08:56', 'Late', '2026-04-13 21:15:19', NULL),
(173, 205, '2021-019', 'MARK ELABA', '2026-04-14', '2026-04-14 20:54:44', '2026-04-15 06:48:21', 'Present', '2026-04-14 20:54:44', NULL),
(174, 205, '2021-019', 'MARK ELABA', '2026-04-15', NULL, NULL, 'Absent', '2026-04-15 00:00:00', NULL),
(175, 205, '2021-019', 'MARK ELABA', '2026-04-16', '2026-04-16 20:46:09', '2026-04-17 06:39:46', 'Early', '2026-04-16 20:46:09', NULL),
(176, 205, '2021-019', 'MARK ELABA', '2026-04-17', '2026-04-17 21:08:35', '2026-04-18 07:02:12', 'Late', '2026-04-17 21:08:35', NULL),
(177, 205, '2021-019', 'MARK ELABA', '2026-04-18', '2026-04-18 20:59:00', '2026-04-19 06:52:37', 'Present', '2026-04-18 20:59:00', NULL),
(178, 205, '2021-019', 'MARK ELABA', '2026-04-19', '2026-04-19 20:58:49', '2026-04-20 06:37:45', 'Late', '2026-04-19 20:58:49', NULL),
(179, 205, '2021-019', 'MARK ELABA', '2026-04-20', '2026-04-20 20:51:16', '2026-04-21 06:44:53', 'Present', '2026-04-20 20:51:16', NULL),
(180, 205, '2021-019', 'MARK ELABA', '2026-04-21', '2026-04-21 20:43:41', '2026-04-22 06:37:18', 'Early', '2026-04-21 20:43:41', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `productnumber` varchar(50) NOT NULL,
  `productname` varchar(50) NOT NULL,
  `productbrand` varchar(50) NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `quantity` int(4) NOT NULL,
  `subtotal` decimal(12,2) NOT NULL,
  `emp_num` varchar(12) NOT NULL,
  `sales_date` date NOT NULL,
  `sales_invoice` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `productnumber`, `productname`, `productbrand`, `price`, `quantity`, `subtotal`, `emp_num`, `sales_date`, `sales_invoice`) VALUES
(16, '12390', 'Sanmarino', '', 35.00, 1, 35.00, '', '2026-04-22', ''),
(17, '12390', 'Sanmarino', '', 35.00, 15, 525.00, '', '2026-04-22', '');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` int(5) NOT NULL,
  `emp_num` varchar(50) NOT NULL,
  `fname` varchar(35) NOT NULL,
  `mname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `address` text NOT NULL,
  `gender` varchar(9) NOT NULL,
  `employment_status` varchar(15) NOT NULL,
  `position` varchar(200) NOT NULL,
  `sss` varchar(50) NOT NULL,
  `philhealth` varchar(100) NOT NULL,
  `tin` varchar(50) NOT NULL,
  `pagibig` varchar(50) NOT NULL,
  `taxcategory` varchar(20) NOT NULL,
  `salary` float NOT NULL,
  `rateperday` float NOT NULL,
  `photo` varchar(120) NOT NULL,
  `cnum` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `department` varchar(70) NOT NULL,
  `civil_status` varchar(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `emp_num`, `fname`, `mname`, `lname`, `address`, `gender`, `employment_status`, `position`, `sss`, `philhealth`, `tin`, `pagibig`, `taxcategory`, `salary`, `rateperday`, `photo`, `cnum`, `email`, `department`, `civil_status`) VALUES
(116, '2021-098', 'ABEGAIL', '', 'PASIA', '', 'Female', '', 'Faculty', '', '', '', '', '', 0, 0, 'pasia.webp', '', 'abegail.pasia@pcaat.edu.ph', 'FACULTY/TVL/PART-TIME', ''),
(118, '2021-003', 'AILA MARIE', '', 'BATA-ANON', '', 'Female', '', 'Faculty', '', '', '', '', '', 0, 0, 'bata-anon.webp', '', 'ailamarie.bata-anon@pcaat.edu.ph', 'FACULTY/RESEARCH AND SOCIAL SCIENCES', ''),
(119, '2021-089', 'AILONA', ' L.', 'LIPIT', '', 'Female', '', 'Faculty', '', '', '', '', '', 0, 0, 'lipit.webp', '', 'ailona.lumberio-lipt@pcaat.edu.ph', 'FACULTY/LANGUAGES AND LITERATURE', ''),
(120, '2021-035', 'AIREEN', '', 'EVANGELISTA', '', 'Female', '', 'Faculty', '', '', '', '', '', 0, 0, 'evangelista.webp', '', 'aireen.evangelista@pcaat.edu.ph', 'FACULTY/BUSINESS AND SCIENCE', ''),
(122, '2021-001', 'ALLYSZA', 'N.', 'DATU', '', 'Female', '', 'Executive Assistant', '', '', '', '', '', 0, 0, '', '', 'allysza.datu@pcaat.edu.ph', 'Executive Assistant', ''),
(123, '2021-017', 'ALMHAR ', 'D.', 'PANELO', '', 'Male', '', 'Faculty', '', '', '', '', '', 0, 0, 'panelo.webp', '', 'almhar.panelo@pcaat.edu.ph', 'FACULTY/TECHNICAL-VOCATIONAL-LIVELIHOOD', ''),
(127, '2021-001', 'ANGEL', 'L.', 'DATU', '', 'Male', '', 'Faculty', '', '', '', '', '', 0, 0, 'angeldatu.webp', '', 'angel.datu@pcaat.edu.ph', 'FACULTY/LANGUAGES AND LITERATURE', ''),
(128, '2021-013', 'ANGELICA', 'R.', 'ILAN', '', 'Female', '', 'Faculty', '', '', '', '', '', 0, 0, 'ilan.webp', '', 'angelica.ilan@pcaat.edu.ph', 'FACULTY/RESEARCH AND SOCIAL SCIENCES', ''),
(131, '2021-038', 'ARIES', '', 'SEGUI', '', 'Male', '', 'Maintenance', '', '', '', '', '', 0, 0, '', '', 'aries.sigue@pcaat.edu.ph', 'Maintenance', ''),
(135, '2021-008', 'BERMIN', '', 'CAPELLAN', '', 'Female', '', 'Dept. Head B&S', '', '', '', '', '', 0, 0, 'capellan.webp', '', 'bermin.capellan@pcaat.edu.ph', 'Dept. Head, Business and Sciences', ''),
(138, '2021-045', 'CHERRY ROSE', '', 'TAGUIAM', '', 'Female', '', 'Faculty', '', '', '', '', '', 0, 0, 'taguiam.webp', '', 'cherryrose.taguiam@pcaat.edu.ph', 'FACULTY/RESEARCH AND SOCIAL SCIENCES', ''),
(139, '2021-001', 'CHIARA REINA', '', 'DATU', '', 'Female', '', 'PRESIDENT', '', '', '', '', '', 0, 0, '', '', 'chiara.datu@pcaat.edu.ph', 'President', ''),
(140, '2021-015', 'CHRISTIAN', 'M.', 'ARELLANO', '', 'Male', '', 'OIC, PPF', '', '', '', '', '', 0, 0, 'arellano.png', '', 'christian.arellano@pcaat.edu.ph', 'OIC, PPF', ''),
(142, '2021-043', 'CLARISSA', 'S.', 'LICUAN', '', 'Female', '', 'Faculty', '', '', '', '', '', 0, 0, 'licuan.webp', '', 'clarissa.licuan@pcaat.edu.ph', 'FACULTY/LANGUAGES AND LITERATURE', ''),
(144, '2021-030', 'DANDY', 'MONTOYA', 'BONETE', '', 'Male', '', 'Faculty', '', '', '', '', '', 0, 0, 'bonete.webp', '', 'dandy.bonete@pcaat.edu.ph', 'FACULTY/BUSINESS AND SCIENCE', ''),
(147, '2021-033', 'DAVETTE JOHANA', '', 'GARCIA', '', 'Female', '', 'Marketing', '', '', '', '', '', 0, 0, '', '', 'davette.garcia@pcaat.edu.ph', 'Marketing', ''),
(153, '2021-036', 'EDUARD', '', 'JOSEPH', '', 'Male', '', 'Maintenance', '', '', '', '', '', 0, 0, '', '', 'eduard.joseph@pcaat.edu.ph', 'Maintenance', ''),
(160, '2021-033', 'MA. FILIPINA', '', 'GARCIA', '', 'Female', '', 'Business Development Officer', '', '', '', '', '', 0, 0, '', '', 'filipina.garcia@pcaat.edu.ph', 'Business Development Officer', ''),
(170, '2021-001', 'IDELFONSO', 'L.', 'DATU', '', 'Male', '', 'VP for Admin and Finance', '', '', '', '', '', 0, 0, 'ideldatu.webp', '', 'idel.datu@pcaat.edu.ph', 'Vice President for Administration and Finance', ''),
(171, '2021-012', 'IRIS', '', 'FRANI', '', 'Female', '', 'Faculty', '', '', '', '', '', 0, 0, 'frani.webp', '', 'iris.frani@pcaat.edu.ph', 'FACULTY/RESEARCH AND SOCIAL SCIENCES', ''),
(180, '2021-096', 'JOSE ARIEL', 'P', 'CLEMENTE', 'Sta. Cruz, Manila', 'Male', '', 'IT Staff', '', '', '', '', 'B', 24000, 0, 'clemente.webp', '', 'jose.clemente@pcaat.edu.ph', 'FACULTY/TECHNICAL-VOCATIONAL-LIVELIHOOD', 'Single'),
(183, '2021-007', 'JUDY', 'G.', 'SIBAYAN', '', 'Female', '', 'Faculty', '', '', '', '', '', 0, 0, 'sibayan.webp', '', 'judy.sibayan@pcaat.edu.ph', 'FACULTY/RESEARCH AND SOCIAL SCIENCES', ''),
(193, '2021-018', 'KYLA MARIE', '', 'PASTORAL', '', 'Female', '', 'Faculty', '', '', '', '', '', 0, 0, 'pastoral.webp', '', 'kyla.pastoral@pcaat.edu.ph', 'FACULTY/TECHNICAL-VOCATIONAL-LIVELIHOOD', ''),
(201, '2021-005', 'MAI NICOLE', 'R.', 'OLAGUER', '', 'Female', '', 'Asst. Principal', '', '', '', '', '', 0, 0, 'olaguer.webp', '', 'mai.olaguer@pcaat.edu.ph', 'ASSISTANT PRINCIPAL', ''),
(205, '2021-019', 'MARK', '', 'ELABA', '', 'Male', '', 'Faculty', '', '', '', '', '', 0, 0, '', '', 'mark.elaba@pcaat.edu.ph', 'TECHNICAL-VOCATIONAL-LIVELIHOOD', ''),
(215, '2021-009', 'MICHELLE MAE', '', 'FERNANDEZ', '', 'Female', '', 'IT Head', '', '', '', '', '', 0, 0, 'fernandez.webp', '', 'michelle.fernandez@pcaat.edu.ph', 'IT HEAD', ''),
(223, '2021-028', 'PEARL ANGELETTE', '', 'MARIANO', '', 'Female', '', 'HRD Head', '', '', '', '', '', 0, 0, 'pearlmariano.webp', '', 'pearl.mariano@pcaat.edu.ph', 'Head, HRD/ OIC, Marketing Director', ''),
(224, '2021-001', 'PERLITA', '', 'DATU', '', 'Female', '', 'Consultant', '', '', '', '', '', 0, 0, '', '', 'perlita.datu@pcaat.edu.ph', 'Internal and External Consultant', ''),
(226, '2021-027', 'PHOEBE', '', 'CLAROS', '', 'Female', '', 'Faculty', '', '', '', '', '', 0, 0, 'claros.webp', '', 'phoebe.claros@pcaat.edu.ph', 'FACULTY/LANGUAGES AND LITERATURE', ''),
(227, '2021-040', 'PRINCESS DIANE', '', 'DE GUIA', '', 'Female', '', 'Faculty', '', '', '', '', '', 0, 0, 'deguia.webp', '', 'princess.deguia@pcaat.edu.ph', 'FACULTY/TECHNICAL-VOCATIONAL-LIVELIHOOD', ''),
(229, '2021-029', 'PSALM', 'DANIEL', 'CAGUIA', '', 'Female', '', 'Registrar Staff', '', '', '', '', '', 0, 0, 'caguia.webp', '', 'psalm.caguia@pcaat.edu.ph', 'Registrar staff', ''),
(230, '2021-024', 'REXEL IAN', '', 'REYES', '', 'Male', '', 'IT Staff', '', '', '', '', '', 0, 0, 'reyes.webp', '', 'rexel.reyes@pcaat.edu.ph', 'IT Staff', ''),
(236, '2021-026', 'RICKARDO', '', 'SANTIAGO', '', 'Male', '', '', '', '', '', '', '', 0, 0, '', '', 'rickardo.santiago@pcaat.edu.ph', 'REGISTRAR Staff', ''),
(237, '2021-032', 'ROBERT JERME', 'J.', 'DE VERA', '', 'Male', '', 'Faculty', '', '', '', '', '', 0, 0, 'devera.webp', '', 'robert.devera@pcaat.edu.ph', 'FACULTY/RESEARCH AND SOCIAL SCIENCES', ''),
(238, '2021-011', 'ROCELINE', 'P.', 'SORIQUEZ', '', 'Female', '', 'Faculty', '', '', '', '', '', 0, 0, 'soriquez.webp', '', 'roceline.soriquez@pcaat.edu.ph', 'FACULTY/TECHNICAL-VOCATIONAL-LIVELIHOOD', ''),
(239, '2021-099', 'ROCHELLE ANN', '', 'PANA', '', 'Female', '', 'Faculty', '', '', '', '', '', 0, 0, 'pana.webp', '', 'rochell.pana@pcaat.edu.ph', 'FACULTY/BUSINESS AND SCIENCE', ''),
(245, '2021-033', 'ROWENA', '', 'GARCIA', '', 'Female', '', '', '', '', '', '', '', 0, 0, '', '', 'rowena.garcia@pcaat.edu.ph', 'Part time, Registrar Staff', ''),
(246, '2021-023', 'RUBEN', 'M.', 'DE LIMA', '', 'Male', '', 'Faculty', '', '', '', '', '', 0, 0, 'delima.webp', '', 'ruben.delima@pcaat.edu.ph', 'FACULTY/BUSINESS AND SCIENCE', ''),
(248, '2021-022', 'SERVANDO', '', 'CRUZ', '', 'Male', '', '', '', '', '', '', '', 0, 0, 'cruz.webp', '', 'servando.cruz@pcaat.edu.ph', 'MARKETING OFFICER', ''),
(249, '2021-021', 'GLOLAND SHAI', '', 'DE LEON', '', 'Female', '', 'Registrar Staff', '', '', '', '', '', 0, 0, 'deleon.webp', '', 'shai.deleon@pcaat.edu.ph', 'Registrar Staff', ''),
(250, '2021-004', 'SHERINA', '', 'VILLANUEVA', '', 'Female', '', 'Department Head', '', '', '', '', '', 0, 0, 'villanueva.webp', '', 'sherina.villanueva@pcaat.edu.ph', 'Dep. Head, Language and Literature', ''),
(252, '2021-020', 'VANESSA MAE', '', 'OJEDA', '', 'Female', '', 'Faculty', '', '', '', '', '', 0, 0, 'ojeda.webp', '', 'vanessamae.ojeda@pcaat.edu.ph', 'FACULTY/RESEARCH AND SOCIAL SCIENCES', '');

-- --------------------------------------------------------

--
-- Table structure for table `payroll`
--

CREATE TABLE `payroll` (
  `id` int(11) NOT NULL,
  `payroll_period` varchar(20) NOT NULL,
  `date_from` date NOT NULL,
  `date_to` date NOT NULL,
  `emp_num` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `mname` varchar(50) NOT NULL,
  `department` varchar(100) NOT NULL,
  `position` varchar(200) NOT NULL,
  `days_worked` int(11) NOT NULL DEFAULT 0,
  `days_absent` int(11) NOT NULL DEFAULT 0,
  `late_count` int(11) NOT NULL DEFAULT 0,
  `rate_per_day` decimal(10,2) NOT NULL DEFAULT 0.00,
  `gross_pay` decimal(10,2) NOT NULL DEFAULT 0.00,
  `deduction_absent` decimal(10,2) NOT NULL DEFAULT 0.00,
  `deduction_late` decimal(10,2) NOT NULL DEFAULT 0.00,
  `deduction_sss` decimal(10,2) NOT NULL DEFAULT 0.00,
  `deduction_philhealth` decimal(10,2) NOT NULL DEFAULT 0.00,
  `deduction_pagibig` decimal(10,2) NOT NULL DEFAULT 0.00,
  `total_deductions` decimal(10,2) NOT NULL DEFAULT 0.00,
  `net_pay` decimal(10,2) NOT NULL DEFAULT 0.00,
  `status` varchar(20) NOT NULL DEFAULT 'Processed',
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `payroll`
--

INSERT INTO `payroll` (`id`, `payroll_period`, `date_from`, `date_to`, `emp_num`, `lname`, `fname`, `mname`, `department`, `position`, `days_worked`, `days_absent`, `late_count`, `rate_per_day`, `gross_pay`, `deduction_absent`, `deduction_late`, `deduction_sss`, `deduction_philhealth`, `deduction_pagibig`, `total_deductions`, `net_pay`, `status`, `created_at`) VALUES
(1, '2026-04', '2026-04-01', '2026-04-30', '2021-098', 'PASIA', 'ABEGAIL', '', 'FACULTY/TVL/PART-TIME', 'Faculty', 18, 12, 13, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 'Processed', '2026-04-21 18:11:04'),
(2, '2026-04', '2026-04-01', '2026-04-30', '2021-019', 'ELABA', 'MARK', '', 'TECHNICAL-VOCATIONAL-LIVELIHOOD', 'Faculty', 18, 12, 18, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 'Processed', '2026-04-21 18:13:44'),
(3, '2026-04', '2026-04-01', '2026-04-30', '2021-089', 'LIPIT', 'AILONA', ' L.', 'FACULTY/LANGUAGES AND LITERATURE', 'Faculty', 17, 13, 12, 500.00, 8500.00, 6500.00, 600.00, 0.00, 0.00, 0.00, 7100.00, 1400.00, 'Processed', '2026-04-21 20:59:25');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `productnumber` varchar(50) NOT NULL,
  `productname` varchar(50) NOT NULL,
  `productbrand` varchar(50) NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `quantity` int(4) NOT NULL,
  `productstatus` varchar(20) NOT NULL,
  `photo` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `productnumber`, `productname`, `productbrand`, `price`, `quantity`, `productstatus`, `photo`) VALUES
(1, '12321', 'CDO Conrned Beef', 'CDO', 40.00, -6, '', ''),
(3, '12390', 'Sanmarino', 'CDO', 35.00, 95, '', 'uploads/products/69e77412ccba9_12390.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` int(11) NOT NULL,
  `productnumber` varchar(50) NOT NULL,
  `productname` varchar(50) NOT NULL,
  `productbrand` varchar(50) NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `quantity` int(4) NOT NULL,
  `subtotal` decimal(12,2) NOT NULL,
  `emp_num` varchar(12) NOT NULL,
  `sales_date` date NOT NULL,
  `sales_invoice` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`id`, `productnumber`, `productname`, `productbrand`, `price`, `quantity`, `subtotal`, `emp_num`, `sales_date`, `sales_invoice`) VALUES
(1, '12321', 'CDO Conrned Beef', 'CDO', 40.00, 1, 40.00, '', '0000-00-00', ''),
(7, '12321', 'CDO Conrned Beef', 'CDO', 40.00, 1, 40.00, '', '0000-00-00', ''),
(8, '12321', 'CDO Conrned Beef', 'CDO', 40.00, 1, 40.00, '', '0000-00-00', ''),
(9, '12321', 'CDO Conrned Beef', 'CDO', 40.00, 1, 40.00, '', '0000-00-00', ''),
(10, '', 'CDO Conrned Beef', '', 40.00, 1, 40.00, '6', '2026-04-22', 'INV-17768599'),
(11, '', 'CDO Conrned Beef', '', 40.00, 1, 40.00, '6', '2026-04-22', 'INV-17768599'),
(12, '', 'CDO Conrned Beef', '', 40.00, 1, 40.00, '6', '2026-04-22', 'INV-17768599'),
(13, '', 'CDO Conrned Beef', '', 40.00, 1, 40.00, '6', '2026-04-22', 'INV-17768599'),
(14, '', 'Sanmarino', '', 35.00, 1, 35.00, '6', '2026-04-22', 'INV-17768599'),
(15, '', 'Sanmarino', '', 35.00, 1, 35.00, '6', '2026-04-22', 'INV-17768599'),
(16, '', 'Sanmarino', '', 35.00, 1, 35.00, '6', '2026-04-22', 'INV-17768599'),
(17, '', 'Sanmarino', '', 35.00, 1, 35.00, '6', '2026-04-22', 'INV-17768600'),
(18, '', 'Sanmarino', '', 35.00, 1, 35.00, '6', '2026-04-22', 'INV-17768600'),
(19, '', 'Sanmarino', '', 35.00, 100, 3500.00, '6', '2026-04-22', 'INV-17768600');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendance_credentials`
--
ALTER TABLE `attendance_credentials`
  ADD PRIMARY KEY (`emp_num`);

--
-- Indexes for table `attendance_logs`
--
ALTER TABLE `attendance_logs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_daily_log` (`emp_id`,`log_date`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payroll`
--
ALTER TABLE `payroll`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attendance_logs`
--
ALTER TABLE `attendance_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=181;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=264;

--
-- AUTO_INCREMENT for table `payroll`
--
ALTER TABLE `payroll`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;