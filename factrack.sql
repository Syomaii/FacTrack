-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 14, 2024 at 07:33 AM
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
-- Database: `factrack`
--

-- --------------------------------------------------------

--
-- Table structure for table `borrows`
--

CREATE TABLE `borrows` (
  `id` int(10) UNSIGNED NOT NULL,
  `equipment_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `borrowers_id_no` int(10) UNSIGNED NOT NULL,
  `borrowers_name` varchar(100) NOT NULL,
  `department` varchar(50) NOT NULL,
  `borrowed_date` datetime NOT NULL,
  `expected_returned_date` date NOT NULL,
  `returned_date` datetime DEFAULT NULL,
  `status` varchar(50) NOT NULL,
  `purpose` varchar(50) NOT NULL,
  `remarks` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `borrows`
--

INSERT INTO `borrows` (`id`, `equipment_id`, `user_id`, `borrowers_id_no`, `borrowers_name`, `department`, `borrowed_date`, `expected_returned_date`, `returned_date`, `status`, `purpose`, `remarks`, `created_at`, `updated_at`) VALUES
(1, 4, 2, 9445040, 'Angelica Eve Angel', 'College of Computer Studies', '2024-11-06 17:14:19', '2024-11-08', '2024-11-06 17:21:00', 'Borrowed', 'huwam', 'okay na', '2024-11-06 09:14:19', '2024-11-06 09:22:06'),
(2, 3, 2, 14708127, 'Lexer John Amorcillo', 'College of Computer Studies', '2024-11-14 13:35:48', '2024-11-15', '2024-11-14 13:46:00', 'Returned', 'huwam', 'okay ra', '2024-11-14 05:35:48', '2024-11-14 05:46:39'),
(3, 3, 2, 18004473, 'John Colleen Saberon', 'College of Computer Studies', '2024-11-14 13:48:04', '2024-11-15', NULL, 'Borrowed', 'huwam', 'The day the equipment is Borrowed', '2024-11-14 05:48:04', '2024-11-14 05:48:04');

-- --------------------------------------------------------

--
-- Table structure for table `designations`
--

CREATE TABLE `designations` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `designations`
--

INSERT INTO `designations` (`id`, `name`) VALUES
(1, 'Dean'),
(2, 'Working Student\r\n'),
(3, 'Maintenance Personnel');

-- --------------------------------------------------------

--
-- Table structure for table `disposed`
--

CREATE TABLE `disposed` (
  `id` int(10) UNSIGNED NOT NULL,
  `equipment_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `disposed_date` datetime NOT NULL,
  `remarks` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `donated`
--

CREATE TABLE `donated` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `equipments`
--

CREATE TABLE `equipments` (
  `id` int(10) UNSIGNED NOT NULL,
  `facility_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `brand` varchar(50) NOT NULL,
  `name` varchar(255) NOT NULL,
  `serial_no` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `acquired_date` datetime NOT NULL,
  `code` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `status` varchar(50) NOT NULL,
  `owned_by` varchar(50) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `equipments`
--

INSERT INTO `equipments` (`id`, `facility_id`, `user_id`, `brand`, `name`, `serial_no`, `description`, `acquired_date`, `code`, `image`, `status`, `owned_by`, `created_at`, `updated_at`) VALUES
(2, 2, 2, 'hehe', 'hehe', '523424', 'hehe', '2024-10-31 00:00:00', '241110320323209', 'images/equipments/pc.png', 'In Maintenance', 'University', '2024-11-02 19:32:09', '2024-11-04 21:33:25'),
(3, 2, 2, 'lenovo', 'pc2', '48945162', 'pc2', '2024-10-27 00:00:00', '241110320323316', 'images/equipments/pc.png', 'Borrowed', 'University', '2024-11-02 19:33:16', '2024-11-14 05:48:04'),
(4, 3, 2, 'monoblock', 'chair', '89759486542', 'a plastic chair', '2024-10-29 00:00:00', '241110330624835', 'images/equipments/chair.jpeg', 'Available', 'University', '2024-11-02 22:48:35', '2024-11-06 09:22:06'),
(5, 2, 2, 'acer', 'pc3', '6252688748574', 'a pc', '2024-10-29 00:00:00', '241110421022727', 'images/equipments/pc.png', 'In Maintenance', 'University', '2024-11-04 02:27:27', '2024-11-04 21:35:29'),
(6, 2, 2, 'apple', 'mac', '5647687867486', 'a mac pc', '2024-10-29 00:00:00', '241110421022933', 'images/equipments/pc.png', 'Available', 'University', '2024-11-04 02:29:33', '2024-11-04 21:37:37'),
(7, 2, 2, 'wala', 'wala', '64768687568', 'wala', '2024-10-29 00:00:00', '241110721325030', 'images/equipments/Screenshot (1).png', 'Available', 'University', '2024-11-07 05:50:30', '2024-11-07 05:50:30');

-- --------------------------------------------------------

--
-- Table structure for table `facilities`
--

CREATE TABLE `facilities` (
  `id` int(10) UNSIGNED NOT NULL,
  `office_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `type` varchar(10) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `facilities`
--

INSERT INTO `facilities` (`id`, `office_id`, `name`, `description`, `type`, `created_at`, `updated_at`) VALUES
(2, 1, 'C1s', 'Computer laboratory 12s', 'office', '2024-10-22 23:55:03', '2024-11-08 04:27:16'),
(3, 1, 'Stock Room', 'Stock Room', 'room', '2024-11-02 22:47:43', '2024-11-02 22:47:43');

-- --------------------------------------------------------

--
-- Table structure for table `maintenance`
--

CREATE TABLE `maintenance` (
  `id` int(10) UNSIGNED NOT NULL,
  `equipment_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `maintained_date` datetime NOT NULL,
  `returned_date` datetime DEFAULT NULL,
  `remarks` varchar(255) NOT NULL,
  `issue` varchar(255) NOT NULL,
  `action_taken` varchar(255) DEFAULT NULL,
  `recommendations` varchar(255) DEFAULT NULL,
  `status` varchar(50) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `maintenance`
--

INSERT INTO `maintenance` (`id`, `equipment_id`, `user_id`, `maintained_date`, `returned_date`, `remarks`, `issue`, `action_taken`, `recommendations`, `status`, `created_at`, `updated_at`) VALUES
(1, 6, 2, '2024-11-05 00:00:00', '2024-11-05 05:36:00', 'asd', 'asd', 'asd', 'asd', 'okay', '2024-11-04 21:36:20', '2024-11-04 21:37:01'),
(2, 6, 2, '2024-11-05 00:00:00', '2024-11-05 05:37:00', 'asdasd', 'asd', 'asd', 'asd', 'okay', '2024-11-04 21:37:20', '2024-11-04 21:37:37');

-- --------------------------------------------------------

--
-- Table structure for table `maintenance_schedules`
--

CREATE TABLE `maintenance_schedules` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `equipment_id` int(10) UNSIGNED NOT NULL,
  `last_maintenance_date` datetime NOT NULL,
  `maintenance_frequency` int(10) UNSIGNED NOT NULL,
  `next_due_date` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
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
(1, '2024_07_31_181510_create_offices_table', 1),
(2, '2024_07_31_181522_create_designations_table', 1),
(3, '2024_07_31_181529_create_users_table', 1),
(4, '2024_07_31_181542_create_facilities_table', 1),
(5, '2024_07_31_181552_create_equipments_table', 1),
(7, '2024_07_31_181629_create_repairs_table', 1),
(10, '2024_07_31_181650_create_disposed_table', 1),
(11, '2024_08_05_081759_create_donated_table', 1),
(12, '2024_08_05_081814_create_timeline_table', 1),
(13, '2024_08_07_170136_create_notifications_table', 1),
(14, '2024_10_19_113619_add_remember_token_to_users_table', 1),
(16, '2024_07_31_181613_create_maintenance_table', 2),
(20, '2024_07_31_181634_create_students_table', 3),
(21, '2024_11_07_052748_add_last_login_at_to_users_table', 4),
(22, '2024_11_03_005817_create_personal_access_tokens_table', 5),
(23, '2024_11_14_041207_create_maintenance_schedules_table', 6);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) NOT NULL,
  `type` varchar(255) NOT NULL,
  `notifiable_type` varchar(255) NOT NULL,
  `notifiable_id` bigint(20) UNSIGNED NOT NULL,
  `data` text NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `offices`
--

CREATE TABLE `offices` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `type` varchar(10) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `offices`
--

INSERT INTO `offices` (`id`, `name`, `description`, `type`, `created_at`, `updated_at`) VALUES
(1, 'College of Computer Study', 'CCS', 'department', '2024-10-22 20:59:55', '2024-11-08 04:28:45'),
(2, 'College of Criminology', 'CoCs', 'department', '2024-10-22 21:00:06', '2024-10-29 07:06:12'),
(3, 'College of Teacher Education', 'CTE', 'department', '2024-10-29 07:10:28', '2024-10-29 07:10:28'),
(4, 'College of Nursing', 'CoN', 'department', '2024-11-07 11:15:54', '2024-11-07 11:15:54'),
(5, 'Office of the Maintenance', 'Maintenance', 'office', '2024-11-07 11:17:34', '2024-11-07 11:17:34'),
(6, 'Office of the vice president', 'ovp', 'office', '2024-11-10 03:36:08', '2024-11-10 03:36:08'),
(7, 'Office Of The President', 'oop', 'office', '2024-11-10 03:42:40', '2024-11-10 03:42:40');

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

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\User', 5, 'ResetPasswordToken', '43f64f07c3c4525bf34a0dd78fd8817d13242a019f856c9c7b3627cc8b52b6db', '[\"*\"]', NULL, NULL, '2024-11-07 06:01:38', '2024-11-07 06:01:38'),
(2, 'App\\Models\\User', 6, 'ResetPasswordToken', '8e68d4f2b0005bb3d7a2ea0620e04b0cba8e2d45439e0d0655cba0fa6b031cbc', '[\"*\"]', NULL, NULL, '2024-11-09 13:22:36', '2024-11-09 13:22:36');

-- --------------------------------------------------------

--
-- Table structure for table `repairs`
--

CREATE TABLE `repairs` (
  `id` int(10) UNSIGNED NOT NULL,
  `equipment_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `repaired_date` datetime NOT NULL,
  `returned_date` datetime DEFAULT NULL,
  `remarks` varchar(255) NOT NULL,
  `status` varchar(50) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id_no` varchar(255) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `gender` varchar(1) NOT NULL,
  `email` varchar(50) NOT NULL,
  `course` varchar(50) NOT NULL,
  `department` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id_no`, `firstname`, `lastname`, `gender`, `email`, `course`, `department`, `created_at`, `updated_at`) VALUES
('09445040', 'Angelica Eve', 'Angel', 'F', 'kaaiyukichan1417@gmail.com', 'BSCS 4', 'College of Computer Studies', '2024-11-05 21:36:23', '2024-11-05 21:36:23'),
('10480770', 'Tyler Joshua', 'De Leon', 'M', 'tylerjoshuadeleon@gmail.com', 'BSIT 2', 'College Of Criminology', '2024-11-10 11:40:50', '2024-11-10 11:40:50'),
('11532231', 'Aldrin', 'Baclohan', 'M', 'aldrin.dino.baclohan@gmail.com', 'BSIT 3', 'College of Computer Studies', '2024-11-06 02:08:17', '2024-11-06 02:08:17'),
('13607924', 'John April', 'Patalinghug', 'M', 'johnapril1996@gmail.com', 'BSIT 2', 'College of Computer Studies', '2024-11-06 02:09:31', '2024-11-06 02:09:31'),
('13638069', 'Janvel', 'Andrino', 'M', 'janzskies13@gmail.com', 'BSIT 3', 'College of Computer Studies', '2024-11-05 21:34:00', '2024-11-05 21:34:00'),
('14708127', 'Lexer John', 'Amorcillo', 'M', 'lexeramorcillo@gmail.com', 'BSIT 4', 'College of Computer Studies', '2024-11-06 02:08:17', '2024-11-06 02:08:17'),
('15462312', 'Test5', 'Test5', 'M', 'test5@test.com', 'test', 'Testing Department', '2024-11-12 04:30:54', '2024-11-12 04:30:54'),
('15762412', 'Zariell Emanuele Ondree', 'Averilla', 'M', 'ondreeaverilla@gmail.com', 'BSIT 2', 'College of Computer Studies', '2024-11-06 02:09:31', '2024-11-06 02:09:31'),
('16523214', 'Test4', 'Test4', 'M', 'test4@test.com', 'test', 'Testing Department', '2024-11-12 04:30:54', '2024-11-12 04:30:54'),
('16880684', 'Vingie', 'Wenceslao', 'M', 'parasofficiall@gmail.com', 'BSIT 3', 'College of Computer Studies', '2024-11-05 21:34:00', '2024-11-05 21:34:00'),
('17824563', 'Test2', 'Test2', 'M', 'test2@test.com', 'test', 'Testing Department', '2024-11-12 04:30:54', '2024-11-12 04:30:54'),
('17917790', 'Benedict', 'Avenido', 'M', 'benedictavenido1320@gmail.com', 'BSIT 2', 'College Of Criminology', '2024-11-10 11:40:50', '2024-11-10 11:40:50'),
('17918624', 'Francis Miguel', 'Diano', 'M', 'hotxspot47@gmail.com', 'BSIT 2', 'College Of Criminology', '2024-11-10 11:40:50', '2024-11-10 11:40:50'),
('17928441', 'Uriel Jorosh', 'Garcia', 'M', 'jojostand2020@gmail.com', 'BSIT 2', 'College of Computer Studies', '2024-11-06 02:09:31', '2024-11-06 02:09:31'),
('17931635', 'Jade Mykel', 'Ventic', 'M', 'jmykelvenz@gmail.com', 'BSIT 2', 'College Of Criminology', '2024-11-10 11:40:50', '2024-11-10 11:40:50'),
('17933193', 'Patrick Aiken', 'Aredidon', 'M', 'sacc39301@gmail.com', 'BSIT 2', 'College Of Criminology', '2024-11-10 11:40:50', '2024-11-10 11:40:50'),
('17939257', 'Vaneth Mea', 'Cadivida', 'F', 'van.cadivida@yahoo.com', 'BSIT 3', 'College of Computer Studies', '2024-11-06 02:08:17', '2024-11-06 02:08:17'),
('18004473', 'John Colleen', 'Saberon', 'M', 'johnsaberon178@gmail.com', 'BSCS 4', 'College of Computer Studies', '2024-11-05 21:36:23', '2024-11-05 21:36:23'),
('18011296', 'Veejay', 'Cuizon', 'M', 'veejaycuizon24@gmail.com', 'BSIT 2', 'College Of Criminology', '2024-11-10 11:40:50', '2024-11-10 11:40:50'),
('18778148', 'Test1', 'Test1', 'M', 'test1@test.com', 'test', 'Testing Department', '2024-11-12 04:30:54', '2024-11-12 04:30:54'),
('18976811', 'Dominic', 'Tacatani', 'M', 'greatdominic143@gmail.com', 'BSIT 3', 'College of Computer Study', '2024-11-06 06:06:10', '2024-11-06 06:06:10'),
('18977496', 'Charles Thom', 'Matidios', 'M', 'charlesthommatidios@gmail.com', 'BSIT 3', 'College of Computer Studies', '2024-11-06 02:08:17', '2024-11-06 02:08:17'),
('18977595', 'Joseph Ivan Jr.', 'Quisido', 'M', 'QUISIDOJOSEPH23@GMAIL.COM', 'BSIT 3', 'College of Computer Studies', '2024-11-06 02:08:17', '2024-11-06 02:08:17'),
('18990820', 'Via', 'Gelig', 'F', 'viagelig01@gmail.com', 'BSCS 4', 'College of Computer Studies', '2024-11-05 21:36:23', '2024-11-05 21:36:23'),
('18991968', 'Rey', 'Comendador', 'M', 'reycomendador4@gmail.com', 'BSIT 3', 'College of Computer Studies', '2024-11-05 21:34:00', '2024-11-05 21:34:00'),
('19067898', 'Test', 'Test', 'M', 'test@test.com', 'test', 'Testing Department', '2024-11-12 04:30:54', '2024-11-12 04:30:54'),
('19069913', 'Kent Ryann', 'Bongcaron', 'M', 'Bongcaronk@gmail.com', 'BSIT 3', 'College of Computer Studies', '2024-11-05 21:34:00', '2024-11-05 21:34:00'),
('19074764', 'Francis Dave', 'Gelborion', 'M', 'gelboriondave@gmail.com', 'BSIT 3', 'College of Computer Study', '2024-11-06 06:06:10', '2024-11-06 06:06:10'),
('19077247', 'Keir', 'Gom-os', 'M', 'keirgomos@gmail.com', 'BSIT 2', 'College of Computer Studies', '2024-11-06 02:09:31', '2024-11-06 02:09:31'),
('19101245', 'Jundix', 'Pepino', 'M', 'julixpepino3@gmail.com', 'BSIT 3', 'College of Computer Studies', '2024-11-05 21:34:00', '2024-11-05 21:34:00'),
('19101773', 'Chrystal Jem', 'Gadiano', 'F', 'jemgadiano09@gmail.com', 'BSIT 3', 'College of Computer Studies', '2024-11-05 21:34:00', '2024-11-05 21:34:00'),
('19107044', 'Maureen', 'Simafranca', 'F', 'Maurhianasimafranca@gmail.com', 'BSIT 2', 'College of Computer Studies', '2024-11-06 02:09:31', '2024-11-06 02:09:31'),
('19125244', 'John Carlo', 'Diocampo', 'M', 'jcdiocampo23@gmail.com', 'BSIT 3', 'College of Computer Study', '2024-11-06 06:06:10', '2024-11-06 06:06:10'),
('19132158', 'Agel', 'Genita', 'F', 'kellybrooke734@gmail.com', 'BSCS 4', 'College of Computer Studies', '2024-11-05 21:36:23', '2024-11-05 21:36:23'),
('19138114', 'Larry', 'Pino', 'M', 'walablayf@gmail.com', 'BSIT 3', 'College of Computer Studies', '2024-11-05 21:34:00', '2024-11-05 21:34:00'),
('19253678', 'Test3', 'Test3', 'M', 'test3@test.com', 'test', 'Testing Department', '2024-11-12 04:30:54', '2024-11-12 04:30:54'),
('20147073', 'Irene', 'Ferrer', 'M', 'ferrerirenerigodo@gmail.com', 'BSIT 3', 'College of Computer Studies', '2024-11-06 02:08:17', '2024-11-06 02:08:17'),
('20148408', 'Twinky', 'Casidsid', 'F', 'casidsidtwinky.2004@gmail.com', 'BSIT 3', 'College of Computer Study', '2024-11-06 06:06:10', '2024-11-06 06:06:10'),
('20150145', 'Jes Vincent', 'Sungahid', 'M', 'sungahidjes@gmail.com', 'BSIT 3', 'College of Computer Studies', '2024-11-06 02:08:17', '2024-11-06 02:08:17'),
('20152039', 'Jessiah France', 'Armero', 'M', 'francearmero663@gmail.com', 'BSIT 3', 'College of Computer Studies', '2024-11-06 02:08:17', '2024-11-06 02:08:17'),
('20152063', 'Jose Danielle', 'Inocentes', 'M', 'daniel.inocentes81@gmail.com', 'BSIT 3', 'College of Computer Study', '2024-11-06 06:06:10', '2024-11-06 06:06:10'),
('20152590', 'Jameskevin', 'Velasco', 'M', 'lkhevinlvelasco@gmail.com', 'BSIT 3', 'College of Computer Study', '2024-11-06 06:06:10', '2024-11-06 06:06:10'),
('20154343', 'Ronan', 'Madanguit', 'M', 'madanguitronan@gmail.com', 'BSIT 3', 'College of Computer Study', '2024-11-06 06:06:10', '2024-11-06 06:06:10'),
('20154601', 'Shaen Jhee', 'Garcia', 'M', 'shaenjhee@gmail.com', 'BSIT 3', 'College of Computer Studies', '2024-11-06 02:08:17', '2024-11-06 02:08:17'),
('20155501', 'Kemp', 'Jumao-as', 'M', 'kempjumaoas@gmail.com', 'BSIT 2', 'College Of Criminology', '2024-11-10 11:40:50', '2024-11-10 11:40:50'),
('20157636', 'Frix Adrian', 'De Loyola', 'M', 'frixadrian2@gmail.com', 'BSIT 3', 'College of Computer Studies', '2024-11-05 21:34:00', '2024-11-05 21:34:00'),
('20157653', 'Jenifer', 'Pongasi', 'F', 'jeniferpongasi18@gmail.com', 'BSIT 3', 'College of Computer Studies', '2024-11-06 02:08:17', '2024-11-06 02:08:17'),
('20157908', 'Gave', 'Capuras', 'M', 'gavesarupac@gmail.com', 'BSIT 3', 'College of Computer Studies', '2024-11-06 02:08:17', '2024-11-06 02:08:17'),
('20158527', 'Angel Marie', 'Sabido', 'F', 'sabidoangel.uc@gmail.com', 'BSIT 3', 'College of Computer Study', '2024-11-06 06:06:10', '2024-11-06 06:06:10'),
('20158623', 'Maryneil Jade', 'Sevilla', 'F', 'sevillamaryneil.uc@gmail.com', 'BSIT 3', 'College of Computer Studies', '2024-11-05 21:34:00', '2024-11-05 21:34:00'),
('20158714', 'Ivan Jethro', 'Dungog', 'M', 'dungogjethro@gmail.com', 'BSIT 3', 'College of Computer Studies', '2024-11-05 21:34:00', '2024-11-05 21:34:00'),
('20158757', 'Kirby', 'Estimada', 'M', 'kirbsrigonan@gmail.com', 'BSIT 3', 'College of Computer Study', '2024-11-06 06:06:10', '2024-11-06 06:06:10'),
('20159732', 'Allan Jay', 'Villanueva', 'M', 'myuserisinvalid@gmail.com', 'BSIT 3', 'College of Computer Study', '2024-11-06 06:06:10', '2024-11-06 06:06:10'),
('20166642', 'Vince', 'YbaÑez', 'M', 'vinzzybanez@gmail.com', 'BSIT 3', 'College of Computer Study', '2024-11-06 06:06:10', '2024-11-06 06:06:10'),
('20173806', 'Vivien Heart', 'Conson', 'F', 'vivienhearty@gmail.com', 'BSIT 3', 'College of Computer Study', '2024-11-06 06:06:10', '2024-11-06 06:06:10'),
('20174912', 'Derick', 'Aton', 'M', 'derickaton12345@gmail.com', 'BSIT 3', 'College of Computer Studies', '2024-11-05 21:34:00', '2024-11-05 21:34:00'),
('20176098', 'Leande May', 'Soronio', 'F', 'leandemays@gmail.com', 'BSIT 3', 'College of Computer Study', '2024-11-06 06:06:10', '2024-11-06 06:06:10'),
('20177766', 'Vina May', 'Blen', 'M', 'blenvinamay580@gmail.com', 'BSCS 4', 'College of Computer Studies', '2024-11-05 21:36:23', '2024-11-05 21:36:23'),
('20181099', 'Lovelyn', 'Gula', 'M', 'gulalovelyn205@gmail.com', 'BSIT 3', 'College of Computer Studies', '2024-11-05 21:34:00', '2024-11-05 21:34:00'),
('20182301', 'Charles Vincent', 'Amodia', 'M', 'amodia.charlesvincent@gmail.com', 'BSIT 4', 'College of Computer Studies', '2024-11-05 21:34:00', '2024-11-05 21:34:00'),
('20183604', 'Calvin Paul', 'Mendoza', 'M', 'ultramite.98@gmail.com', 'BSIT 3', 'College of Computer Study', '2024-11-06 06:06:10', '2024-11-06 06:06:10'),
('22200943', 'Aaron', 'Cumahig', 'M', 'aaroncumahig12@gmail.com', 'BSIT 2', 'College Of Criminology', '2024-11-10 11:40:50', '2024-11-10 11:40:50'),
('22201537', 'Argee Boy', 'Paquibot', 'M', 'aboy.paqs@gmail.com', 'BSIT 2', 'College Of Criminology', '2024-11-10 11:40:50', '2024-11-10 11:40:50'),
('22202113', 'John Anakin', 'Injug', 'M', 'johninjug56@gmail.com', 'BSIT 2', 'College Of Criminology', '2024-11-10 11:40:50', '2024-11-10 11:40:50'),
('22202519', 'Daniel Kane Isidore', 'Mapano', 'M', 'mapano.daniel@gmail.com', 'BSIT 2', 'College Of Criminology', '2024-11-10 11:40:50', '2024-11-10 11:40:50'),
('22203475', 'Joemar', 'Ygot', 'M', 'joemarygot@gmail.com', 'BSCS 4', 'College of Computer Studies', '2024-11-05 21:36:23', '2024-11-05 21:36:23'),
('22203483', 'John Henry', 'Tero', 'M', 'johnhenrytero007@gmail.com', 'BSCS 4', 'College of Computer Studies', '2024-11-05 21:36:23', '2024-11-05 21:36:23'),
('22203517', 'Lloyd Christopher ', 'Singcol', 'M', 'kbager263@gmail.com', 'BSCS 4', 'College of Computer Studies', '2024-11-05 21:36:23', '2024-11-05 21:36:23'),
('22204226', 'Stephen John', 'De Los Santos', 'M', 'stephjohndelossantos@gmail.com', 'BSCS 4', 'College of Computer Studies', '2024-11-05 21:36:23', '2024-11-05 21:36:23'),
('22204366', 'Jan David', 'Capuyan', 'M', 'ezdavidz789@gmail.com', 'BSIT 2', 'College Of Criminology', '2024-11-10 11:40:50', '2024-11-10 11:40:50'),
('22204374', 'Erika Gabrielle', 'Samson', 'F', 'kaisamson.uc@gmail.com', 'BSIT 2', 'College of Computer Studies', '2024-11-06 02:09:31', '2024-11-06 02:09:31'),
('22204390', 'John Angelo', 'Ayson', 'M', 'johnangeloayson@gmail.com', 'BSIT 3', 'College of Computer Studies', '2024-11-05 21:34:00', '2024-11-05 21:34:00'),
('22205942', 'Glord', 'Hiyas', 'M', 'hiyasglord@gmail.com', 'BSIT 4', 'College of Computer Studies', '2024-11-06 02:08:17', '2024-11-06 02:08:17'),
('22207708', 'Jaycee Kent', 'Cabansag', 'M', 'jayceekentcabansag123@gmail.com', 'BSIT 2', 'College Of Criminology', '2024-11-10 11:40:50', '2024-11-10 11:40:50'),
('22213532', 'Alexandre', 'Paquibot', 'M', 'paquibotalexandre00@gmail.com', 'BSIT 2', 'College Of Criminology', '2024-11-10 11:40:50', '2024-11-10 11:40:50'),
('22214209', 'Esper Jona', 'Mandigma', 'F', 'espermandigz@gmail.com', 'BSIT 2', 'College of Computer Studies', '2024-11-06 02:09:31', '2024-11-06 02:09:31'),
('22215727', 'Allyssa Faith', 'Ejares', 'F', 'allyejares24@gmail.com', 'BSIT 2', 'College Of Criminology', '2024-11-10 11:40:50', '2024-11-10 11:40:50'),
('22216618', 'Kaycee', 'Roamar', 'F', 'roamarkaycee@gmail.com', 'BSIT 2', 'College Of Criminology', '2024-11-10 11:40:50', '2024-11-10 11:40:50'),
('22222111', 'Sheilmae Jean', 'Furog', 'F', 'sheilmaefurog@gmail.com', 'BSCS 4', 'College of Computer Studies', '2024-11-05 21:36:23', '2024-11-05 21:36:23'),
('22222145', 'Richie', 'Caracas', 'M', 'richiecaracas83@gmail.com', 'BSIT 3', 'College of Computer Studies', '2024-11-06 02:08:17', '2024-11-06 02:08:17'),
('22222681', 'John Carlo', 'Borgueta', 'M', 'johncarloborgueta@gmail.com', 'BSIT 2', 'College Of Criminology', '2024-11-10 11:40:50', '2024-11-10 11:40:50'),
('22223390', 'Kendrick Emmanuel', 'Oanes', 'M', 'keooanes@gmail.com', 'BSIT 2', 'College of Computer Studies', '2024-11-06 02:09:31', '2024-11-06 02:09:31'),
('22223788', 'John Michael', 'Lim', 'M', 'johnmichaellim041202@gmail.com', 'BSCS 4', 'College of Computer Studies', '2024-11-05 21:36:23', '2024-11-05 21:36:23'),
('22225528', 'Nichol Angelo', 'Degamo', 'M', 'angelo07232002@gmail.com', 'BSCS 4', 'College of Computer Studies', '2024-11-05 21:36:23', '2024-11-05 21:36:23'),
('22226054', 'Lemuel', 'Mangao', 'M', 'lemuelmangao69@gmail.com', 'BSIT 2', 'College Of Criminology', '2024-11-10 11:40:50', '2024-11-10 11:40:50'),
('22226930', 'Harold', 'Gutierrez', 'M', 'growtopiagusion@gmail.com', 'BSIT 2', 'College of Computer Studies', '2024-11-06 02:09:31', '2024-11-06 02:09:31'),
('22227169', 'Jhermaine Rob', 'Landeza', 'M', 'jhermainerb1@gmail.com', 'BSIT 2', 'College of Computer Studies', '2024-11-06 02:09:31', '2024-11-06 02:09:31'),
('22228894', 'Vladimir Clint', 'Catigan', 'M', 'therealvlad3@gmail.com', 'BSIT 3', 'College of Computer Studies', '2024-11-05 21:34:00', '2024-11-05 21:34:00'),
('22235170', 'Rizza Joy', 'Aradillos', 'F', 'ilex.aradillos@gmail.com', 'BSIT 2', 'College of Computer Studies', '2024-11-06 02:09:31', '2024-11-06 02:09:31'),
('22236368', 'Mark Andrew', 'Sencil', 'M', 'sencilmarkandrew12@gmail.com', 'BSCS 4', 'College of Computer Studies', '2024-11-05 21:36:23', '2024-11-05 21:36:23'),
('22242077', 'Kevser', 'Emanet', 'F', 'kevseremttt@gmail.com', 'BSIT 2', 'College of Computer Studies', '2024-11-06 02:09:31', '2024-11-06 02:09:31'),
('22244735', 'Sara', 'Pahara', 'F', 'paharasara@gmail.com', 'BSIT 3', 'College of Computer Study', '2024-11-06 06:06:10', '2024-11-06 06:06:10'),
('23206824', 'Nimu', 'Gonzaga', 'M', 'nimugonzaga@gmail.com', 'BSIT 3', 'College of Computer Studies', '2024-11-05 21:34:00', '2024-11-05 21:34:00'),
('23206832', 'Riel Maico', 'Aparre', 'M', 'Rielmaicoaparre1@gmail.com', 'BSIT 3', 'College of Computer Studies', '2024-11-05 21:34:00', '2024-11-05 21:34:00'),
('23207194', 'Gwen', 'Dupal-ag', 'F', 'gwenixwinters1803@gmail.com', 'BSIT 3', 'College of Computer Studies', '2024-11-06 02:08:17', '2024-11-06 02:08:17'),
('23207723', 'Carla Jay', 'Gersamio', 'F', 'carlajaygersamio081@gmail.com', 'BSIT 3', 'College of Computer Studies', '2024-11-05 21:34:00', '2024-11-05 21:34:00'),
('23208689', 'Kenjade', 'Baring', 'M', 'kenjade1baring2003@gmail.com', 'BSIT 3', 'College of Computer Study', '2024-11-06 06:06:10', '2024-11-06 06:06:10'),
('23209091', 'John Humer ', 'Melendres', 'M', 'humermelendres@gmail.com', 'BSIT 3', 'College of Computer Studies', '2024-11-06 02:08:17', '2024-11-06 02:08:17'),
('23209794', 'Lei Dennise ', 'Balunan', 'F', 'balunanleidennise@gmail.com', 'BSIT 3', 'College Of Criminology', '2024-11-10 11:40:50', '2024-11-10 11:40:50'),
('23210651', 'James Ivan', 'Quilantang', 'M', 'ivanquilantang303@gmail.com', 'BSIT 3', 'College of Computer Studies', '2024-11-06 02:08:17', '2024-11-06 02:08:17'),
('23210776', 'Liza Mae', 'Balunan', 'F', 'lizamaebalunan17@gmail.com', 'BSIT 3', 'College of Computer Studies', '2024-11-05 21:34:00', '2024-11-05 21:34:00'),
('23210792', 'Jimarnie', 'Branzuela', 'M', 'jimarnie.branzuela@gmail.com', 'BSIT 3', 'College of Computer Study', '2024-11-06 06:06:10', '2024-11-06 06:06:10'),
('23211774', 'Andrei Joshua', 'Neri', 'M', 'andreineri2002@gmail.com', 'BSIT 3', 'College of Computer Studies', '2024-11-06 02:08:17', '2024-11-06 02:08:17'),
('23212731', 'Sanzibel', 'Makiling', 'F', 'sanzibelmakiling03@gmail.com', 'BSIT 2', 'College Of Criminology', '2024-11-10 11:40:50', '2024-11-10 11:40:50'),
('23212848', 'Jazryl', 'Padin', 'F', 'jazrylpadin@gmail.com', 'BSIT 3', 'College of Computer Studies', '2024-11-05 21:34:00', '2024-11-05 21:34:00'),
('23213176', 'Samantha Khaye ', 'Ymbong', 'F', 'icedc156@gmail.com', 'BSIT 3', 'College of Computer Studies', '2024-11-05 21:34:00', '2024-11-05 21:34:00'),
('23213200', 'Mark Darryl', 'Gabito', 'M', 'darrylgabito03@gmail.com', 'BSIT 3', 'College of Computer Study', '2024-11-06 06:06:10', '2024-11-06 06:06:10'),
('23213325', 'Christian Rey', 'Fuentes', 'M', 'myklax23@gmail.com', 'BSIT 3', 'College of Computer Studies', '2024-11-05 21:34:00', '2024-11-05 21:34:00'),
('23213572', 'Ralph Christian', 'De Jesus', 'M', 'dj.ralphyan@gmail.com', 'BSIT 3', 'College of Computer Study', '2024-11-06 06:06:10', '2024-11-06 06:06:10'),
('23214042', 'Ares Daniel', 'Marte', 'M', 'aresdmarte@gmail.com', 'BSIT 3', 'College of Computer Studies', '2024-11-05 21:34:00', '2024-11-05 21:34:00'),
('23214588', 'Mark Jorland', 'Iway', 'M', 'markjorlandiway1234@gmail.com', 'BSIT 3', 'College of Computer Studies', '2024-11-05 21:34:00', '2024-11-05 21:34:00'),
('23215692', 'Rumart ', 'Tatoy', 'M', 'rumartbarontatoyuclm@gmail.com', 'BSIT 3', 'College of Computer Study', '2024-11-06 06:06:10', '2024-11-06 06:06:10'),
('23215825', 'Gianne Isabelle', 'Augusto', 'F', 'gianneaisabelle@gmail.com', 'BSIT 3', 'College of Computer Studies', '2024-11-06 02:08:17', '2024-11-06 02:08:17'),
('23215833', 'John Clarence', 'Belarmino', 'M', 'clarencebelarmino@gmail.com', 'BSIT 3', 'College of Computer Studies', '2024-11-05 21:34:00', '2024-11-05 21:34:00'),
('23216047', 'Kristine Mae', 'NuÑeza', 'F', 'KMNUNEZA@SYMONSYSTEM.COM', 'BSIT 3', 'College of Computer Studies', '2024-11-06 02:08:17', '2024-11-06 02:08:17'),
('23216591', 'Kendrick', 'Lazo', 'M', 'visionperipheral69@gmail.com', 'BSIT 3', 'College of Computer Study', '2024-11-06 06:06:10', '2024-11-06 06:06:10'),
('23216799', 'Chryssdale Heart', 'Allasgo', 'M', 'chryssdaleheartallasgo@gmail.com', 'BSIT 3', 'College of Computer Studies', '2024-11-05 21:34:00', '2024-11-05 21:34:00'),
('23217508', 'Kenneth', 'Fernandez', 'M', 'fernandezkenneth654@gmail.com', 'BSIT 3', 'College of Computer Studies', '2024-11-06 02:08:17', '2024-11-06 02:08:17'),
('23218811', 'Aj', 'Villamor', 'M', 'ajvillamor45@gmail.com', 'BSIT 3', 'College of Computer Studies', '2024-11-05 21:34:00', '2024-11-05 21:34:00'),
('23218928', 'Jayred Deil', 'Mahasol', 'M', 'jayredmahasol@gmail.com', 'BSIT 3', 'College of Computer Study', '2024-11-06 06:06:10', '2024-11-06 06:06:10'),
('23218944', 'Kezekiah', 'Yatong', 'F', 'kezekiahy@gmail.com', 'BSIT 3', 'College of Computer Study', '2024-11-06 06:06:10', '2024-11-06 06:06:10'),
('23219504', 'Junriel', 'Casul', 'M', 'jpopcasul@gmail.com', 'BSIT 3', 'College of Computer Study', '2024-11-06 06:06:10', '2024-11-06 06:06:10'),
('23221567', 'Francis Miguel', 'Formentera', 'M', 'francis.formentera29@gmail.com', 'BSIT 3', 'College of Computer Studies', '2024-11-05 21:34:00', '2024-11-05 21:34:00'),
('23221997', 'Chuck ', 'Ybalez ', 'M', 'shamsipad2022@gmail.com', 'BSIT 3', 'College of Computer Study', '2024-11-06 06:06:10', '2024-11-06 06:06:10'),
('23224116', 'Rogiel', 'Dinoy', 'M', 'rogidinoy@gmail.com', 'BSIT 2', 'College Of Criminology', '2024-11-10 11:40:50', '2024-11-10 11:40:50'),
('23224702', 'Laleine ', 'Flores', 'F', 'floreslaleine009@gmail.com', 'BSIT 3', 'College of Computer Studies', '2024-11-06 02:08:17', '2024-11-06 02:08:17'),
('23224710', 'Jan Christopher', 'Obregon', 'M', 'janobregon857@gmail.com', 'BSIT 3', 'College of Computer Study', '2024-11-06 06:06:10', '2024-11-06 06:06:10'),
('23224975', 'Joanna', 'Dimpas', 'F', 'joannadimpas182@gmail.com', 'BSIT 3', 'College of Computer Studies', '2024-11-06 02:08:17', '2024-11-06 02:08:17'),
('23225949', 'James Emmanuel', 'Embudo', 'M', 'embudojames4@gmail.com', 'BSIT 3', 'College of Computer Studies', '2024-11-05 21:34:00', '2024-11-05 21:34:00'),
('23226038', 'Angelito ', 'Berame ', 'M', 'angelberame712@gmail.com', 'BSIT 3', 'College of Computer Studies', '2024-11-06 02:08:17', '2024-11-06 02:08:17'),
('23226673', 'Ethanael', 'Tan', 'M', 'ethk3250@gmail.com', 'BSIT 3', 'College of Computer Study', '2024-11-06 06:06:10', '2024-11-06 06:06:10'),
('23228851', 'Clemens', 'Neuda', 'M', 'clemensneuda13@gmail.com', 'BSIT 3', 'College of Computer Study', '2024-11-06 06:06:10', '2024-11-06 06:06:10'),
('23229123', 'Alyssa', 'Sumile', 'F', 'alyssa.sumile18@gmail.com', 'BSIT 3', 'College of Computer Studies', '2024-11-06 02:08:17', '2024-11-06 02:08:17'),
('23229263', 'Janine ', 'Alolod', 'F', 'zaninyu11778@gmail.com', 'BSIT 3', 'College of Computer Study', '2024-11-06 06:06:10', '2024-11-06 06:06:10'),
('23229339', 'Jerome', 'Ayong', 'M', 'jeromeayong405@gmail.com', 'BSIT 3', 'College of Computer Studies', '2024-11-06 02:08:17', '2024-11-06 02:08:17'),
('23231236', 'Luxury Landy', 'Joren', 'M', 'luxurylandy98@gmail.com', 'BSIT 3', 'College of Computer Study', '2024-11-06 06:06:10', '2024-11-06 06:06:10'),
('23232242', 'Caryl', 'Dapanas', 'F', 'dapanascaryl@gmail.com', 'BSIT 3', 'College of Computer Studies', '2024-11-05 21:34:00', '2024-11-05 21:34:00'),
('23232457', 'Judy Lou', 'Cortes', 'F', 'judylou.cortes@gmail.com', 'BSIT 3', 'College of Computer Study', '2024-11-06 06:06:10', '2024-11-06 06:06:10'),
('23234255', 'Jarcel Franz', 'Tubigon', 'M', 'Jarcelfranz@gmail.com', 'BSIT 3', 'College of Computer Studies', '2024-11-05 21:34:00', '2024-11-05 21:34:00'),
('23235211', 'Jhun Kenneth', 'Curacha', 'M', 'kennethcuracha018@gmail.com', 'BSIT 3', 'College of Computer Studies', '2024-11-05 21:34:00', '2024-11-05 21:34:00'),
('23235229', 'Seth', 'Alcos', 'M', 'sethalcos@gmail.com', 'BSIT 3', 'College of Computer Study', '2024-11-06 06:06:10', '2024-11-06 06:06:10'),
('23236607', 'Briyce', 'Bentulan', 'M', 'brays0903@gmail.com', 'BSIT 3', 'College of Computer Studies', '2024-11-06 02:08:17', '2024-11-06 02:08:17'),
('23236730', 'Ivan', 'Cuyos', 'M', 'cuyosivan1@gmail.com', 'BSIT 3', 'College of Computer Studies', '2024-11-05 21:34:00', '2024-11-05 21:34:00'),
('23236896', 'Chad Michael', 'Sira', 'M', 'chadsira321@gmail.com', 'BSIT 3', 'College of Computer Study', '2024-11-06 06:06:10', '2024-11-06 06:06:10'),
('23236912', 'Ken Lloyd ', 'Brazal', 'M', 'kenlloydbrazal@gmail.com', 'BSIT 3', 'College of Computer Studies', '2024-11-05 21:34:00', '2024-11-05 21:34:00'),
('23238009', 'Christy Mae', 'Manog', 'F', 'christy221mae@gmail.com', 'BSIT 3', 'College of Computer Studies', '2024-11-05 21:34:00', '2024-11-05 21:34:00'),
('23238165', 'Jesryle James', 'Agrabio', 'M', 'jesryleagrabio08@gmail.com', 'BSIT 3', 'College of Computer Study', '2024-11-06 06:06:10', '2024-11-06 06:06:10'),
('23238413', 'Bern Dione ', 'Dioso', 'M', 'berndione03@gmail.com', 'BSIT 3', 'College of Computer Studies', '2024-11-06 02:08:17', '2024-11-06 02:08:17'),
('23239049', 'Mary Kris', 'Gaut', 'F', 'gmarykris663@gmail.com', 'BSIT 3', 'College of Computer Studies', '2024-11-06 02:08:17', '2024-11-06 02:08:17'),
('23239163', 'Jhon Axell', 'SeÑagan', 'M', 'sirjhonny147@gmail.com', 'BSIT 3', 'College of Computer Studies', '2024-11-05 21:34:00', '2024-11-05 21:34:00'),
('23240823', 'Miranda Lois ', 'Arriola', 'F', 'miranda.arriola29@gmail.com', 'BSCS 4', 'College of Computer Studies', '2024-11-05 21:36:23', '2024-11-05 21:36:23'),
('23240922', 'John Paul ', 'Sanoria', 'M', 'akashikun14@yahoo.com', 'BSIT 3', 'College of Computer Studies', '2024-11-05 21:34:00', '2024-11-05 21:34:00'),
('23241664', 'Florence Easter ', 'Cuizon', 'F', 'cuizonflorence99@gmail.com', 'BSIT 3', 'College of Computer Studies', '2024-11-06 02:08:17', '2024-11-06 02:08:17'),
('23243637', 'Noriann', 'Catuburan', 'F', 'norianncatuburan4@gmail.com', 'BSIT 3', 'College of Computer Studies', '2024-11-06 02:08:17', '2024-11-06 02:08:17'),
('23245962', 'Joeharvey', 'Baguio', 'M', 'joeharveyb@gmail.com', 'BSIT 3', 'College of Computer Studies', '2024-11-06 02:08:17', '2024-11-06 02:08:17'),
('23245996', 'Vince Bernard', 'Gabaca', 'M', 'vince.gabaca1@gmail.com', 'BSIT 3', 'College of Computer Studies', '2024-11-06 02:08:17', '2024-11-06 02:08:17'),
('23246127', 'Kent', 'Amante', 'M', 'kentamante70@gmail.com', 'BSIT 3', 'College of Computer Study', '2024-11-06 06:06:10', '2024-11-06 06:06:10'),
('23246267', 'Harven Raye ', 'Tampus', 'M', 'harvenraye.tampus2003@gmail.com', 'BSIT 3', 'College of Computer Study', '2024-11-06 06:06:10', '2024-11-06 06:06:10'),
('23246390', 'Justine Ezekiel', 'Justiniani', 'M', 'jejustiniani2003@gmail.com', 'BSIT 3', 'College of Computer Studies', '2024-11-06 02:08:17', '2024-11-06 02:08:17'),
('23248669', 'Megan Ys ', 'Tepait ', 'M', 'meganclan2017@gmail.com', 'BSIT 3', 'College of Computer Studies', '2024-11-05 21:34:00', '2024-11-05 21:34:00'),
('23249121', 'Alyssa', 'Albiso', 'F', 'albisoalyssa8@gmail.com', 'BSIT 3', 'College of Computer Studies', '2024-11-05 21:34:00', '2024-11-05 21:34:00'),
('23249592', 'Louie Jay', 'Bonghanoy', 'M', 'louiejaybonghanoy69@gmail.com', 'BSIT 3', 'College of Computer Study', '2024-11-06 06:06:10', '2024-11-06 06:06:10'),
('23251051', 'Lance', 'Jayme', 'M', 'lancejayme13@gmail.com', 'BSIT 3', 'College of Computer Study', '2024-11-06 06:06:10', '2024-11-06 06:06:10'),
('23251077', 'Aldwyn John', 'Baisac', 'M', 'johnslem143@gmail.com', 'BSIT 3', 'College of Computer Studies', '2024-11-06 02:08:17', '2024-11-06 02:08:17'),
('23251259', 'NiÑa Regene', 'Lumapas', 'F', 'lumapasalex6@gmail.com', 'BSIT 3', 'College of Computer Studies', '2024-11-05 21:34:00', '2024-11-05 21:34:00'),
('23251275', 'Charmel', 'Buscar', 'M', 'charmelbuscar15@gmail.com', 'BSIT 3', 'College of Computer Studies', '2024-11-06 02:08:17', '2024-11-06 02:08:17'),
('23252216', 'Cris Dyford', 'Bonghanoy', 'M', 'dyforbonghanoy@gmail.com', 'BSIT 3', 'College of Computer Study', '2024-11-06 06:06:10', '2024-11-06 06:06:10'),
('23252257', 'Vinz Angelo', 'Onde', 'M', 'vinz.onde@email.com', 'BSIT 3', 'College of Computer Studies', '2024-11-06 02:08:17', '2024-11-06 02:08:17'),
('23252810', 'Kevin John', 'Salimbangon', 'M', 'kelltdb38@gmail.com', 'BSIT 3', 'College of Computer Studies', '2024-11-06 02:08:17', '2024-11-06 02:08:17'),
('23255508', 'Danisse', 'Jumao-as', 'F', 'danissejumaoas30@gmail.com', 'BSIT 3', 'College of Computer Studies', '2024-11-06 02:08:17', '2024-11-06 02:08:17'),
('23255516', 'Monica Joy', 'Madrazo', 'F', 'monicaozardam@gmail.com', 'BSIT 3', 'College of Computer Studies', '2024-11-06 02:08:17', '2024-11-06 02:08:17'),
('23255920', 'Lany Fe', 'Nazareno ', 'F', 'nazarenolany22@gmail.com', 'BSIT 3', 'College of Computer Studies', '2024-11-06 02:08:17', '2024-11-06 02:08:17'),
('23255938', 'Mark NiÑo', 'Abayon', 'M', 'markheyabayon999@gmail.com', 'BSIT 3', 'College of Computer Studies', '2024-11-06 02:08:17', '2024-11-06 02:08:17'),
('23255953', 'Iggy', 'Martinez', 'M', 'kraziecj85@gmail.com', 'BSIT 3', 'College of Computer Studies', '2024-11-06 02:08:17', '2024-11-06 02:08:17'),
('23256035', 'Kean Gabriel', 'Diaz', 'M', 'keandiaz894@gmail.com', 'BSIT 3', 'College of Computer Study', '2024-11-06 06:06:10', '2024-11-06 06:06:10'),
('23258320', 'Shiela Mae', 'Fabrigar', 'F', 'shiesfranky@gmail.com', 'BSIT 3', 'College of Computer Studies', '2024-11-06 02:08:17', '2024-11-06 02:08:17'),
('23259070', 'Stephen Nikkole', 'Lumban', 'M', 'lumbanstephen@gmail.com', 'BSCS 4', 'College of Computer Studies', '2024-11-05 21:36:23', '2024-11-05 21:36:23'),
('23259161', 'Nick Casper', 'Tesado', 'M', 'caspertesado@gmail.com', 'BSIT 3', 'College of Computer Studies', '2024-11-05 21:34:00', '2024-11-05 21:34:00'),
('23259633', 'Vince Rodulph', 'Doming', 'M', 'vdoming70@gmail.com', 'BSIT 3', 'College of Computer Studies', '2024-11-06 02:08:17', '2024-11-06 02:08:17'),
('23259948', 'Earl Francis', 'Ong', 'M', 'earlfrancisong@gmail.com', 'BSCS 4', 'College of Computer Studies', '2024-11-05 21:36:23', '2024-11-05 21:36:23'),
('23260888', 'Kento ', 'Futamata', 'M', 'kenfutamata123@gmail.com', 'BSIT 3', 'College of Computer Study', '2024-11-06 06:06:10', '2024-11-06 06:06:10'),
('23261035', 'Russel', 'Longakit', 'M', 'Russel.longakit@gmail.com', 'BSIT 3', 'College of Computer Studies', '2024-11-05 21:34:00', '2024-11-05 21:34:00'),
('23261118', 'Fred Nykrow', 'Abordo', 'M', 'fredabordo25@gmail.com', 'BSIT 3', 'College of Computer Studies', '2024-11-05 21:34:00', '2024-11-05 21:34:00'),
('23261332', 'Shannen Rhey', 'Abellanosa', 'M', 'shannenrhey@gmail.com', 'BSIT 3', 'College of Computer Study', '2024-11-06 06:06:10', '2024-11-06 06:06:10'),
('23262439', 'Flora May', 'Villarias', 'F', 'floramay_villarias@yahoo.com', 'BSIT 3', 'College of Computer Study', '2024-11-06 06:06:10', '2024-11-06 06:06:10'),
('23264153', 'Mark Niel', 'Poro', 'M', 'jonas142poro@gmail.com', 'BSIT 2', 'College of Computer Studies', '2024-11-06 02:09:31', '2024-11-06 02:09:31'),
('23266000', 'Carl Rj', 'Avenido', 'M', 'carlitoavenido81@gmail.com', 'BSIT 3', 'College of Computer Studies', '2024-11-06 02:08:17', '2024-11-06 02:08:17'),
('23269665', 'Roswell Rey', 'Ceniza', 'M', 'cenizaroswellrey@gmail.com', 'BSIT 3', 'College of Computer Studies', '2024-11-05 21:34:00', '2024-11-05 21:34:00'),
('23269731', 'Stephen Hans', 'Amistoso', 'M', '21700382@usc.edu.ph', 'BSCS 4', 'College of Computer Studies', '2024-11-05 21:36:23', '2024-11-05 21:36:23'),
('23270010', 'Glaisa Mae', 'Andales', 'F', 'glaisamaeandales25@gmail.com', 'BSIT 3', 'College of Computer Study', '2024-11-06 06:06:10', '2024-11-06 06:06:10'),
('23270044', 'James David', 'Guba', 'M', 'jamesdavidguba2@gmail.com', 'BSIT 3', 'College of Computer Studies', '2024-11-05 21:34:00', '2024-11-05 21:34:00'),
('23270085', 'Cyril', 'Seno', 'M', 'cyriljeremyseno@gmail.com', 'BSIT 2', 'College of Computer Studies', '2024-11-06 02:09:31', '2024-11-06 02:09:31'),
('23270374', 'Ernest James', 'Lofranco', 'M', 'ernestjames193@gmail.com', 'BSIT 2', 'College of Computer Studies', '2024-11-06 02:09:31', '2024-11-06 02:09:31'),
('23270671', 'May Kyla', 'Cabanog', 'F', 'maykylacabanog@gmail.com', 'BSIT 3', 'College of Computer Studies', '2024-11-05 21:34:00', '2024-11-05 21:34:00'),
('23271018', 'Jasper', 'TabaÑag', 'M', 'jaspertabanag96@gmail.com', 'BSIT 3', 'College of Computer Studies', '2024-11-05 21:34:00', '2024-11-05 21:34:00'),
('23271240', 'Jan Michael', 'Cabahug', 'M', 'jancabahug31@gmail.com', 'BSIT 3', 'College of Computer Studies', '2024-11-05 21:34:00', '2024-11-05 21:34:00'),
('23271463', 'Clark John', 'Monteclaro', 'M', 'jc2222004@gmail.com', 'BSIT 3', 'College of Computer Study', '2024-11-06 06:06:10', '2024-11-06 06:06:10'),
('24206989', 'Brad Anthony Vann', 'Sarra', 'M', 'bradsarra@gmail.com', 'BSIT 2', 'College Of Criminology', '2024-11-10 11:40:50', '2024-11-10 11:40:50'),
('24207524', 'Prince David', 'Bentulan', 'M', 'princedavidbentulan@gmail.com', 'BSIT 2', 'College of Computer Studies', '2024-11-06 02:09:31', '2024-11-06 02:09:31'),
('24207730', 'Kient Michael', 'Abenoja', 'M', 'kientabenoja@gmail.com', 'BSIT 2', 'College of Computer Studies', '2024-11-06 02:09:31', '2024-11-06 02:09:31'),
('24207748', 'John Benedict', 'Pitogo', 'M', 'pitogojohnbenedict@gmail.com', 'BSIT 2', 'College of Computer Studies', '2024-11-06 02:09:31', '2024-11-06 02:09:31'),
('24207938', 'Eduard', 'Tojong', 'M', 'eduardtojong8@gmail.com', 'BSIT 2', 'College of Computer Studies', '2024-11-06 02:09:31', '2024-11-06 02:09:31'),
('24207953', 'Rj', 'Alenton', 'M', 'soulrj3@gmail.com', 'BSIT 2', 'College of Computer Studies', '2024-11-06 02:09:31', '2024-11-06 02:09:31'),
('24208019', 'Ingrid Maria Sofia ', 'Gacayan', 'F', 'sofiacalledo@gmail.com', 'BSIT 2', 'College of Computer Studies', '2024-11-06 02:09:31', '2024-11-06 02:09:31'),
('24208175', 'Louis Clint ', 'Lactud', 'M', 'loy.shortcut@gmail.com', 'BSIT 2', 'College Of Criminology', '2024-11-10 11:40:50', '2024-11-10 11:40:50'),
('24208290', 'Imee', 'Camba', 'F', 'imeegcamba99@gmail.com', 'BSIT 2', 'College Of Criminology', '2024-11-10 11:40:50', '2024-11-10 11:40:50'),
('24208423', 'Clark Edzel', 'Pulvera', 'M', 'pulveraclark105@gmail.com', 'BSIT 2', 'College of Computer Studies', '2024-11-06 02:09:31', '2024-11-06 02:09:31'),
('24209140', 'Kiana Kae', 'Cirilo', 'F', 'arar.cirilo@gmail.com', 'BSIT 2', 'College Of Criminology', '2024-11-10 11:40:50', '2024-11-10 11:40:50'),
('24212524', 'Jamaica Mae', 'Jumuad', 'F', 'jmjumuad2@gmail.com', 'BSIT 2', 'College Of Criminology', '2024-11-10 11:40:50', '2024-11-10 11:40:50'),
('24212946', 'Nathaniel', 'Tiro', 'M', 'natztiro312@gmail.com', 'BSIT 2', 'College of Computer Studies', '2024-11-06 02:09:31', '2024-11-06 02:09:31'),
('24214157', 'Ayn Lorebelle', 'Cavan', 'F', '02ayncavan@gmail.com', 'BSIT 2', 'College Of Criminology', '2024-11-10 11:40:50', '2024-11-10 11:40:50'),
('24214199', 'Princess Abegeal', 'Alegre', 'F', 'alegreabe60@gmail.com', 'BSIT 2', 'College of Computer Studies', '2024-11-06 02:09:31', '2024-11-06 02:09:31'),
('24214207', 'Emelio', 'Mondares', 'M', 'emeliomondares14@gmail.com', 'BSIT 2', 'College of Computer Studies', '2024-11-06 02:09:31', '2024-11-06 02:09:31'),
('24214546', 'Kyle', 'Peralta', 'M', 'kyleperaltahax@gmail.com', 'BSIT 2', 'College Of Criminology', '2024-11-10 11:40:50', '2024-11-10 11:40:50'),
('24214744', 'Renante', 'Taac-taac', 'M', 'xxkingrenantex@gmail.com', 'BSIT 2', 'College of Computer Studies', '2024-11-06 02:09:31', '2024-11-06 02:09:31'),
('24214967', 'John Vincent', 'Saplad', 'M', 'johnsaplad61@gmail.com', 'BSIT 2', 'College of Computer Studies', '2024-11-06 02:09:31', '2024-11-06 02:09:31'),
('24218026', 'Andre Benedict', 'Claudio', 'M', 'slexinator@gmail.com', 'BSIT 2', 'College Of Criminology', '2024-11-10 11:40:50', '2024-11-10 11:40:50'),
('24218059', 'Fiona Marie ', 'Palacios ', 'F', 'fionamariepalacios18@gmail.com', 'BSIT 2', 'College of Computer Studies', '2024-11-06 02:09:31', '2024-11-06 02:09:31'),
('24218364', 'Rey Marhkn Angelo', 'Mendoza', 'M', 'mendozareymarhkangelo@gmail.com', 'BSIT 2', 'College of Computer Studies', '2024-11-06 02:09:31', '2024-11-06 02:09:31'),
('24222465', 'Erlan Jude', 'Gimenez', 'M', 'erlanjudegimenez17@gmail.com', 'BSIT 2', 'College of Computer Studies', '2024-11-06 02:09:31', '2024-11-06 02:09:31'),
('24225435', 'Glyzel', 'Galagar', 'F', 'glyzelgalagar14@gmail.com', 'BSIT 2', 'College Of Criminology', '2024-11-10 11:40:50', '2024-11-10 11:40:50'),
('24227530', 'James', 'Casquejo', 'M', 'jamescasquejo456@gmail.com', 'BSIT 2', 'College Of Criminology', '2024-11-10 11:40:50', '2024-11-10 11:40:50'),
('24228199', 'Channyl Jacquelyn ', 'Pizon', 'F', 'channylumapaspizon@gmail.com', 'BSIT 2', 'College of Computer Studies', '2024-11-06 02:09:31', '2024-11-06 02:09:31'),
('24229254', 'Marielle Andrea', 'Torreon', 'F', 'marrielleandrea.torreon@gmail.com', 'BSIT 2', 'College of Computer Studies', '2024-11-06 02:09:31', '2024-11-06 02:09:31'),
('24230088', 'Randolph', 'Bacolot', 'M', 'lichtb44@gmail.com', 'BSIT 2', 'College of Computer Studies', '2024-11-06 02:09:31', '2024-11-06 02:09:31'),
('24234023', 'John Christian', 'Lenizo', 'M', 'lenizochristian8@gmail.com', 'BSIT 2', 'College of Computer Studies', '2024-11-06 02:09:31', '2024-11-06 02:09:31'),
('24234676', 'John Benedict', 'CaÑon', 'M', 'canonjohnbenedict81@gmail.com', 'BSIT 2', 'College of Computer Studies', '2024-11-06 02:09:31', '2024-11-06 02:09:31'),
('24239527', 'John Rey', 'Donal', 'M', 'toounit@gmail.com', 'BSIT 2', 'College Of Criminology', '2024-11-10 11:40:50', '2024-11-10 11:40:50'),
('24241911', 'Mary Jasmin', 'Ompad', 'F', 'ompad.maryjasmin@gmail.com', 'BSIT 2', 'College Of Criminology', '2024-11-10 11:40:50', '2024-11-10 11:40:50'),
('24242760', 'Crazelle Patrice', 'Soscano', 'F', 'icamille.camacho@gmail.com', 'BSIT 2', 'College of Computer Studies', '2024-11-06 02:09:31', '2024-11-06 02:09:31'),
('24243966', 'John Elton', 'Geromo', 'M', 'johneltongeromo438@gmail.com', 'BSIT 2', 'College Of Criminology', '2024-11-10 11:40:50', '2024-11-10 11:40:50'),
('24244766', 'Marcin', 'Pascua', 'F', 'pascua.marcin1@gmail.com', 'BSIT 2', 'College Of Criminology', '2024-11-10 11:40:50', '2024-11-10 11:40:50'),
('24245102', 'Matthew', 'QuiÑones', 'M', 'flavrsoft@gmail.com', 'BSIT 2', 'College Of Criminology', '2024-11-10 11:40:50', '2024-11-10 11:40:50'),
('24245268', 'Ivan Justine', 'Cortes', 'M', 'Ivancortes027@gmail.com', 'BSIT 2', 'College Of Criminology', '2024-11-10 11:40:50', '2024-11-10 11:40:50'),
('24245748', 'Jay', 'Talingting', 'M', 'Talingtingjay099@gmail.com', 'BSIT 2', 'College of Computer Studies', '2024-11-06 02:09:31', '2024-11-06 02:09:31'),
('24245763', 'Icy', 'Coloscos', 'F', 'coloscosicy56@gmail.com', 'BSIT 2', 'College of Computer Studies', '2024-11-06 02:09:31', '2024-11-06 02:09:31'),
('24246423', 'Vanessa Mae', 'Florenosos', 'F', 'florenososvanmae615@gmail.com', 'BSIT 2', 'College of Computer Studies', '2024-11-06 02:09:31', '2024-11-06 02:09:31'),
('24247942', 'Glendel', 'Catipay', 'F', 'catipayglendel@gmail.com', 'BSIT 2', 'College of Computer Studies', '2024-11-06 02:09:31', '2024-11-06 02:09:31'),
('24248510', 'Joei Xena Lee', 'Deocampo', 'F', 'joeilee454@gmail.com', 'BSIT 2', 'College of Computer Studies', '2024-11-06 02:09:31', '2024-11-06 02:09:31'),
('24249229', 'Princess', 'Dupal-ag', 'F', 'itzmeprinttet10@gmail.com', 'BSIT 2', 'College of Computer Studies', '2024-11-06 02:09:31', '2024-11-06 02:09:31'),
('24249369', 'Wilfred Cholo', 'PeÑales', 'M', 'Cholopenales0@gmail.com', 'BSIT 2', 'College of Computer Studies', '2024-11-06 02:09:31', '2024-11-06 02:09:31'),
('24251852', 'Sean Leonard', 'Torres', 'M', 'Seantorres712@gmail.com', 'BSIT 2', 'College of Computer Studies', '2024-11-06 02:09:31', '2024-11-06 02:09:31'),
('24252736', 'Roy Vincent', 'Gimongala', 'M', 'rvince.gimongala@gmail.com', 'BSIT 2', 'College Of Criminology', '2024-11-10 11:40:50', '2024-11-10 11:40:50'),
('24253437', 'Jabin', 'Aldiano', 'M', 'jabinaldiano14@gmail.com', 'BSIT 2', 'College of Computer Studies', '2024-11-06 02:09:31', '2024-11-06 02:09:31'),
('24254377', 'John Mark', 'Pagobo', 'M', 'johnmarkpagobo21@gmail.com', 'BSIT 2', 'College of Computer Studies', '2024-11-06 02:09:31', '2024-11-06 02:09:31'),
('24255069', 'Joseph Richard', 'Tabar', 'M', 'josephrichardtabar@gmail.com', 'BSIT 2', 'College Of Criminology', '2024-11-10 11:40:50', '2024-11-10 11:40:50'),
('24255184', 'John Vhengie', 'Booc', 'M', 'vhengie02@gmail.com', 'BSIT 2', 'College Of Criminology', '2024-11-10 11:40:50', '2024-11-10 11:40:50'),
('24255879', 'Christo Rey', 'Espina', 'M', 'christoreyespina@gmail.com', 'BSIT 2', 'College Of Criminology', '2024-11-10 11:40:50', '2024-11-10 11:40:50'),
('24257602', 'Cris Roniel', 'Ibali', 'M', 'ibalicris@gmail.com', 'BSIT 2', 'College Of Criminology', '2024-11-10 11:40:50', '2024-11-10 11:40:50'),
('24259095', 'Francis ', 'Tanga-an ', 'M', 'francismermo@gmail.com', 'BSIT 2', 'College of Computer Studies', '2024-11-06 02:09:31', '2024-11-06 02:09:31'),
('24261182', 'Hernan', 'Panaguiton', 'M', 'hernancpanaguiton@gmail.com', 'BSIT 2', 'College of Computer Studies', '2024-11-06 02:09:31', '2024-11-06 02:09:31'),
('24262479', 'Joseph Lemuel', 'Fernandez', 'M', 'jct.josephlemuelfernandez@gmail.com', 'BSIT 3', 'College of Computer Studies', '2024-11-05 21:34:00', '2024-11-05 21:34:00'),
('24267312', 'Joshua', 'Inoc', 'M', 'shua0257@gmail.com', 'BSIT 2', 'College Of Criminology', '2024-11-10 11:40:50', '2024-11-10 11:40:50'),
('24267379', 'Kurt Godwin', 'Carwana', 'M', 'kurtcarwana09@gmail.comm', 'BSIT 3', 'College of Computer Studies', '2024-11-06 02:08:17', '2024-11-06 02:08:17'),
('24269185', 'Louis Vincent', 'Tajanlangit', 'M', 'vinxvade@gmail.com', 'BSIT 3', 'College of Computer Studies', '2024-11-06 02:09:31', '2024-11-06 02:09:31'),
('24269615', 'Rembrant', 'Pasardan', 'M', 'pasardanbranter@gmail.com', 'BSIT 3', 'College of Computer Studies', '2024-11-05 21:34:00', '2024-11-05 21:34:00'),
('49874872', 'hah', 'haha', 'M', 'hah@hah.com', 'bsit2', 'hehe', '2024-11-12 15:22:30', '2024-11-12 15:22:30');

-- --------------------------------------------------------

--
-- Table structure for table `timeline`
--

CREATE TABLE `timeline` (
  `id` int(10) UNSIGNED NOT NULL,
  `remarks` text NOT NULL,
  `status` varchar(50) NOT NULL,
  `equipment_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `timeline`
--

INSERT INTO `timeline` (`id`, `remarks`, `status`, `equipment_id`, `user_id`, `created_at`, `updated_at`) VALUES
(3, 'The day the equipment is added in the system', 'Available', 2, 2, '2024-11-02 19:32:09', '2024-11-02 19:32:09'),
(4, 'The day the equipment is added in the system', 'Available', 3, 2, '2024-11-02 19:33:16', '2024-11-02 19:33:16'),
(5, 'The day the equipment is added in the system', 'Available', 4, 2, '2024-11-02 22:48:35', '2024-11-02 22:48:35'),
(6, 'The day the equipment is added in the system', 'Available', 5, 2, '2024-11-04 02:27:27', '2024-11-04 02:27:27'),
(7, 'The day the equipment is added in the system', 'Available', 6, 2, '2024-11-04 02:29:33', '2024-11-04 02:29:33'),
(8, 'Status updated to In Maintenance', 'In Maintenance', 2, 2, '2024-11-04 05:14:43', '2024-11-04 05:14:43'),
(9, 'Status updated to Available', 'Available', 2, 2, '2024-11-04 19:37:39', '2024-11-04 19:37:39'),
(10, 'Status updated to In Maintenance', 'In Maintenance', 2, 2, '2024-11-04 20:32:36', '2024-11-04 20:32:36'),
(11, 'Status updated to Available', 'Available', 2, 2, '2024-11-04 20:33:00', '2024-11-04 20:33:00'),
(12, 'Status updated to In Maintenance', 'In Maintenance', 2, 2, '2024-11-04 20:34:24', '2024-11-04 20:34:24'),
(13, 'Status updated to Available', 'Available', 2, 2, '2024-11-04 20:34:49', '2024-11-04 20:34:49'),
(14, 'Status updated to In Maintenance', 'In Maintenance', 2, 2, '2024-11-04 20:35:55', '2024-11-04 20:35:55'),
(15, 'Status updated to Available', 'Available', 2, 2, '2024-11-04 20:36:31', '2024-11-04 20:36:31'),
(16, 'Status updated to In Maintenance', 'In Maintenance', 2, 2, '2024-11-04 20:37:15', '2024-11-04 20:37:15'),
(17, 'Status updated to Available', 'Available', 2, 2, '2024-11-04 20:45:07', '2024-11-04 20:45:07'),
(18, 'Status updated to In Maintenance', 'In Maintenance', 2, 2, '2024-11-04 21:33:25', '2024-11-04 21:33:25'),
(19, 'Status updated to In Maintenance', 'In Maintenance', 5, 2, '2024-11-04 21:35:29', '2024-11-04 21:35:29'),
(20, 'Status updated to In Maintenance', 'In Maintenance', 6, 2, '2024-11-04 21:36:20', '2024-11-04 21:36:20'),
(21, 'Status updated to Available', 'Available', 6, 2, '2024-11-04 21:37:01', '2024-11-04 21:37:01'),
(22, 'Status updated to In Maintenance', 'In Maintenance', 6, 2, '2024-11-04 21:37:20', '2024-11-04 21:37:20'),
(23, 'Status updated to Available', 'Available', 6, 2, '2024-11-04 21:37:37', '2024-11-04 21:37:37'),
(24, 'Status updated to Borrowed', 'Borrowed', 4, 2, '2024-11-06 09:14:19', '2024-11-06 09:14:19'),
(25, 'Status updated to Available', 'Available', 4, 2, '2024-11-06 09:22:06', '2024-11-06 09:22:06'),
(26, 'The day the equipment is added in the system', 'Available', 7, 2, '2024-11-07 05:50:30', '2024-11-07 05:50:30'),
(27, 'Status updated to Borrowed', 'Borrowed', 3, 2, '2024-11-14 05:35:48', '2024-11-14 05:35:48'),
(28, 'Status updated to Available', 'Available', 3, 2, '2024-11-14 05:46:39', '2024-11-14 05:46:39'),
(29, 'Status updated to Borrowed', 'Borrowed', 3, 2, '2024-11-14 05:48:04', '2024-11-14 05:48:04');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `designation_id` int(10) UNSIGNED DEFAULT NULL,
  `office_id` int(10) UNSIGNED DEFAULT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `mobile_no` varchar(50) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` varchar(50) NOT NULL,
  `type` varchar(50) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `last_login_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `designation_id`, `office_id`, `firstname`, `lastname`, `email`, `password`, `mobile_no`, `image`, `status`, `type`, `created_at`, `updated_at`, `remember_token`, `last_login_at`) VALUES
(1, NULL, NULL, 'admin', 'admin', 'admin@gmail.com', '$2y$12$1XlqEw/QMYVaHx6S2EhTUOxBa66ECPrKzOVBl0ymN0FJUNiNLpRmq', '09924821214', 'images/profile_pictures/default-profile.png', 'active', 'admin', NULL, '2024-11-07 11:14:51', '3DkBCuybF248wWczRtbrMorSC9Ih8xLcezT8QtwpQLosOS4JV8DhkONY31yN', '2024-11-13 14:46:22'),
(2, 1, 1, 'Christian jay', 'Putol', 'chrischanjay29@gmail.com', '$2y$12$w4uacbT0WJPsqPYnswa4ielHaLcR8a8TSCA7nurYP.wiizht0ePQ2', '09081666131', 'images/profile_pictures/default-profile.png', 'active', 'facility manager', '2024-10-22 21:30:56', '2024-11-07 05:35:54', 'waE6I0feaMyIX9E7tTDm3tRWeSTBf27GHQmgHNn4tMyuUQQNUlOhrXnAVt0M', '2024-11-14 02:47:31'),
(6, 1, 3, 'Juje', 'Sultan', 'jujechu@gmail.com', '$2y$12$6KxYw7W0mKr6ZU6HvgsrSOZTeQr5Ov/uGprQ.uS3xs2BsXGzpDalC', '09081666131', 'images/profile_pictures/default-profile.png', 'active', 'facility manager', '2024-10-29 07:14:32', '2024-10-29 07:14:32', NULL, NULL),
(7, 1, 2, 'cjay', 'mp', 'christianjayputol29@gmail.com', '$2y$12$XyqS/xwXJvZZUg3tBhlFguriXbPaOUgA2Wyn.rPHCFzyNAw5RyjAS', '09924821214', 'images/profile_pictures/default-profile.png', 'active', 'facility manager', '2024-11-07 08:53:48', '2024-11-07 11:11:01', 'Z4DF3lFWiJBvFKWFVnkH3Tn2X6GjgGPxNixBKaPjFHxndn5iPDIO3zGzpCBq', '2024-11-08 04:39:57'),
(8, 1, 4, 'test', 'test', 'radazakyle99@gmail.com', '$2y$12$X94kMFm4MZroCwhRjGbEBuSw1wIWH6js7D2/Vy9PBjsiiyzEr7PoW', '09924821214', 'images/profile_pictures/default-profile.png', 'active', 'facility manager', '2024-11-07 11:16:44', '2024-11-07 11:16:44', NULL, NULL),
(10, 1, 5, 'test', 'test', 'syomairays7@gmail.com', '$2y$12$wmKp0ALnR0pfSALghTDTFuRDSqV9z01sj4K3FbmxNbXHZ4q3ITKfC', '123456789', 'images/profile_pictures/default-profile.png', 'active', 'facility manager', '2024-11-07 11:31:41', '2024-11-07 11:31:41', 'Ix5I7Q379QCAZa9mCF0TQcUnWLz5ptpjiiPnvom3W8BVQrM0G8wTNTe4uHwk', '2024-11-07 11:34:40'),
(11, 2, 1, 'sad', 'sad', 'sad@sad.sad', '$2y$12$/T1HuanwqgoHGA/uQ6eLQ.aXSnRZ5pu/AaZuNPhZJbPq8z2jce.sS', '09924821214', 'images/profile_pictures/default-profile.png', 'active', 'operator', '2024-11-10 03:11:33', '2024-11-10 03:11:33', NULL, NULL),
(12, 1, 6, 'hehe', 'hehe', 'hehe@hehe.com', '$2y$12$3rQ7k4io43jc.WKYzfopgeC5mZjdPebXB7PZh7LW3DyaF/HpqsVNq', '099248211214', 'images/profile_pictures/default-profile.png', 'active', 'facility manager', '2024-11-10 03:37:40', '2024-11-10 03:37:40', NULL, NULL),
(13, 2, 1, 'Working', 'Student', 'dumagpikent321@gmail.com', '$2y$12$ljo0ivCnu2b9Vyl/OTuHC.VtDzails41EtS59N63oD2Xo32jP29wa', '09924821214', 'images/profile_pictures/default-profile.png', 'active', 'operator', '2024-11-12 14:12:59', '2024-11-12 14:12:59', NULL, '2024-11-12 14:20:19');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `borrows`
--
ALTER TABLE `borrows`
  ADD PRIMARY KEY (`id`),
  ADD KEY `borrows_equipment_id_foreign` (`equipment_id`),
  ADD KEY `borrows_user_id_foreign` (`user_id`);

--
-- Indexes for table `designations`
--
ALTER TABLE `designations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `disposed`
--
ALTER TABLE `disposed`
  ADD PRIMARY KEY (`id`),
  ADD KEY `disposed_equipment_id_foreign` (`equipment_id`),
  ADD KEY `disposed_user_id_foreign` (`user_id`);

--
-- Indexes for table `donated`
--
ALTER TABLE `donated`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `equipments`
--
ALTER TABLE `equipments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `equipments_facility_id_foreign` (`facility_id`),
  ADD KEY `equipments_user_id_foreign` (`user_id`);

--
-- Indexes for table `facilities`
--
ALTER TABLE `facilities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `facilities_office_id_foreign` (`office_id`);

--
-- Indexes for table `maintenance`
--
ALTER TABLE `maintenance`
  ADD PRIMARY KEY (`id`),
  ADD KEY `maintenance_equipment_id_foreign` (`equipment_id`),
  ADD KEY `maintenance_user_id_foreign` (`user_id`);

--
-- Indexes for table `maintenance_schedules`
--
ALTER TABLE `maintenance_schedules`
  ADD PRIMARY KEY (`id`),
  ADD KEY `maintenance_schedules_equipment_id_foreign` (`equipment_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

--
-- Indexes for table `offices`
--
ALTER TABLE `offices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `repairs`
--
ALTER TABLE `repairs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `repairs_equipment_id_foreign` (`equipment_id`),
  ADD KEY `repairs_user_id_foreign` (`user_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id_no`);

--
-- Indexes for table `timeline`
--
ALTER TABLE `timeline`
  ADD PRIMARY KEY (`id`),
  ADD KEY `timeline_equipment_id_foreign` (`equipment_id`),
  ADD KEY `timeline_user_id_foreign` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_office_id_index` (`office_id`),
  ADD KEY `users_designation_id_foreign` (`designation_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `borrows`
--
ALTER TABLE `borrows`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `designations`
--
ALTER TABLE `designations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `disposed`
--
ALTER TABLE `disposed`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `donated`
--
ALTER TABLE `donated`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `equipments`
--
ALTER TABLE `equipments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `facilities`
--
ALTER TABLE `facilities`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `maintenance`
--
ALTER TABLE `maintenance`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `maintenance_schedules`
--
ALTER TABLE `maintenance_schedules`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `offices`
--
ALTER TABLE `offices`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `repairs`
--
ALTER TABLE `repairs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `timeline`
--
ALTER TABLE `timeline`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `borrows`
--
ALTER TABLE `borrows`
  ADD CONSTRAINT `borrows_equipment_id_foreign` FOREIGN KEY (`equipment_id`) REFERENCES `equipments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `borrows_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `disposed`
--
ALTER TABLE `disposed`
  ADD CONSTRAINT `disposed_equipment_id_foreign` FOREIGN KEY (`equipment_id`) REFERENCES `equipments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `disposed_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `equipments`
--
ALTER TABLE `equipments`
  ADD CONSTRAINT `equipments_facility_id_foreign` FOREIGN KEY (`facility_id`) REFERENCES `facilities` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `equipments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `facilities`
--
ALTER TABLE `facilities`
  ADD CONSTRAINT `facilities_office_id_foreign` FOREIGN KEY (`office_id`) REFERENCES `offices` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `maintenance`
--
ALTER TABLE `maintenance`
  ADD CONSTRAINT `maintenance_equipment_id_foreign` FOREIGN KEY (`equipment_id`) REFERENCES `equipments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `maintenance_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `maintenance_schedules`
--
ALTER TABLE `maintenance_schedules`
  ADD CONSTRAINT `maintenance_schedules_equipment_id_foreign` FOREIGN KEY (`equipment_id`) REFERENCES `equipments` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `repairs`
--
ALTER TABLE `repairs`
  ADD CONSTRAINT `repairs_equipment_id_foreign` FOREIGN KEY (`equipment_id`) REFERENCES `equipments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `repairs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `timeline`
--
ALTER TABLE `timeline`
  ADD CONSTRAINT `timeline_equipment_id_foreign` FOREIGN KEY (`equipment_id`) REFERENCES `equipments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `timeline_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_designation_id_foreign` FOREIGN KEY (`designation_id`) REFERENCES `designations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `users_office_id_foreign` FOREIGN KEY (`office_id`) REFERENCES `offices` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
