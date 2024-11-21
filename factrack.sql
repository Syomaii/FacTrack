-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 20, 2024 at 08:10 PM
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
  `borrowers_id_no` varchar(255) NOT NULL,
  `borrowers_name` varchar(100) NOT NULL,
  `department` varchar(50) NOT NULL,
  `borrowed_date` datetime NOT NULL,
  `expected_returned_date` datetime NOT NULL,
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
(1, 1, 2, '18035147', 'John Lyndon Ibaoc', 'College Of Computer Studies', '2024-11-20 22:13:17', '2024-11-21 00:00:00', '2024-11-20 22:14:00', 'Returned', 'huwam', 'uli na nako', '2024-11-20 14:13:17', '2024-11-20 14:15:06'),
(2, 1, 2, '19066729', 'Christian Jay Putolss', 'College Of Computer Studies', '2024-11-20 23:57:01', '2024-11-20 00:00:00', '2024-11-21 03:08:00', 'Returned', 'huwam', 'ok', '2024-11-20 15:57:01', '2024-11-20 19:08:33');

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
(2, 'Working Student'),
(3, 'Student'),
(4, 'Maintenance Personnel');

-- --------------------------------------------------------

--
-- Table structure for table `disposed`
--

CREATE TABLE `disposed` (
  `id` int(10) UNSIGNED NOT NULL,
  `equipment_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `disposed_date` datetime NOT NULL,
  `received_by` varchar(100) NOT NULL,
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
  `equipment_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `donated_date` datetime NOT NULL,
  `condition` varchar(50) NOT NULL,
  `recipient` text NOT NULL,
  `remarks` varchar(255) NOT NULL,
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
  `next_due_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `equipments`
--

INSERT INTO `equipments` (`id`, `facility_id`, `user_id`, `brand`, `name`, `serial_no`, `description`, `acquired_date`, `code`, `image`, `status`, `owned_by`, `next_due_date`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 'Dell', 'Monitor sq12314f1sda', '97867878345', 'A monitor', '2024-11-20 00:00:00', '241112012124234', 'images/equipments/dell-monitor.jpeg', 'Available', 'University', '2024-12-20', '2024-11-20 13:42:34', '2024-11-20 19:08:33');

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
(1, 1, 'C2', 'C2', 'laboratory', '2024-11-20 13:39:41', '2024-11-20 13:39:41'),
(2, 1, 'C1', 'Computer Lab 1', 'laboratory', '2024-11-20 13:39:56', '2024-11-20 13:39:56'),
(3, 1, 'Room 212', 'Room', 'room', '2024-11-20 13:40:13', '2024-11-20 13:40:13'),
(4, 1, 'Dean\'s Office', 'office of the dean', 'office', '2024-11-20 13:40:25', '2024-11-20 13:40:25');

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
  `action_taken` text DEFAULT NULL,
  `recommendations` text DEFAULT NULL,
  `technician` varchar(255) DEFAULT NULL,
  `status` varchar(50) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(3, '2024_07_31_181528_create_students_table', 1),
(4, '2024_07_31_181529_create_users_table', 1),
(5, '2024_07_31_181542_create_facilities_table', 1),
(6, '2024_07_31_181552_create_equipments_table', 1),
(7, '2024_07_31_181613_create_maintenance_table', 1),
(8, '2024_07_31_181629_create_repairs_table', 1),
(9, '2024_07_31_181635_create_borrows_table', 1),
(10, '2024_07_31_181650_create_disposed_table', 1),
(11, '2024_08_05_081759_create_donated_table', 1),
(12, '2024_08_05_081814_create_timeline_table', 1),
(13, '2024_08_07_170136_create_notifications_table', 1),
(14, '2024_10_19_113619_add_remember_token_to_users_table', 1),
(15, '2024_11_01_114623_create_personal_access_tokens_table', 1),
(16, '2024_11_02_065807_create_password_resets_table', 1),
(17, '2024_11_14_041207_create_maintenance_schedules_table', 1),
(18, '2024_11_15_014603_create_cache_table', 1),
(20, '2024_07_31_181530_create_reservation_table', 2);

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

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES
('62d30cd0-68ab-4338-9c4f-fb6ac589fb4d', 'App\\Notifications\\OverdueEquipmentsNotification', 'App\\Models\\User', 2, '{\"title\":\"Overdue Equipment Notification\",\"message\":\"A student has been notified about overdue equipment: Christian Jay Putolss\"}', '2024-11-20 18:23:11', '2024-11-20 17:53:32', '2024-11-20 18:23:11'),
('9e542dd5-5b47-4baf-8b7c-817bd015b3dc', 'App\\Notifications\\OverdueEquipmentsNotification', 'App\\Models\\User', 2, '{\"title\":\"Overdue Equipment Notification\",\"message\":\"A student has been notified about overdue equipment: Christian Jay Putolss\"}', '2024-11-20 18:10:49', '2024-11-20 16:16:32', '2024-11-20 18:10:49'),
('9fd1a664-c8f2-499c-b1d2-e31d7373078a', 'App\\Notifications\\OverdueEquipmentsNotification', 'App\\Models\\User', 2, '{\"title\":\"Overdue Equipment Notification\",\"message\":\"A student has been notified about overdue equipment: Christian Jay Putolss\"}', '2024-11-20 18:22:55', '2024-11-20 18:14:53', '2024-11-20 18:22:55');

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
(1, 'College Of Computer Studies', 'CCS', 'department', '2024-11-19 07:34:50', '2024-11-19 07:34:50');

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
-- Table structure for table `repairs`
--

CREATE TABLE `repairs` (
  `id` int(10) UNSIGNED NOT NULL,
  `equipment_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `repaired_date` datetime NOT NULL,
  `returned_date` datetime DEFAULT NULL,
  `remarks` text NOT NULL,
  `issue` text NOT NULL,
  `action_taken` text DEFAULT NULL,
  `recommendations` text DEFAULT NULL,
  `technician` varchar(255) DEFAULT NULL,
  `status` varchar(50) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reservation`
--

CREATE TABLE `reservation` (
  `id` int(10) UNSIGNED NOT NULL,
  `student_id` varchar(255) NOT NULL,
  `equipment_id` int(10) UNSIGNED NOT NULL,
  `office_id` int(10) UNSIGNED NOT NULL,
  `reservation_date` datetime NOT NULL,
  `expected_return_date` datetime NOT NULL,
  `status` enum('pending','approved','declined','completed','cancelled') NOT NULL,
  `purpose` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` varchar(255) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `gender` varchar(1) NOT NULL,
  `email` varchar(50) NOT NULL,
  `course` varchar(50) NOT NULL,
  `department` varchar(100) NOT NULL,
  `overdue_count` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `firstname`, `lastname`, `gender`, `email`, `course`, `department`, `overdue_count`, `created_at`, `updated_at`) VALUES
('17936428', 'Charles Jenson', 'Fabrigas', 'M', 'Charles.fabrgas@gmail.com', 'BSIT 1', 'College Of Computer Studies', NULL, '2024-11-20 14:04:16', '2024-11-20 14:04:16'),
('18035147', 'John Lyndon', 'Ibaoc', 'M', '27gooddays@gmail.com', 'BSIT 1', 'College Of Computer Studies', NULL, '2024-11-20 14:04:17', '2024-11-20 14:04:17'),
('18985812', 'Laurence Johnvel', 'Pantaleon', 'M', 'johnvelpantaleon20@gmail.com', 'BSIT 1', 'College Of Computer Studies', NULL, '2024-11-20 14:04:18', '2024-11-20 14:04:18'),
('18988592', 'Coolbay John', 'Rodrigo', 'M', 'coolbayjohn9sapphire@gmail.com', 'BSIT 1', 'College Of Computer Studies', NULL, '2024-11-20 14:04:19', '2024-11-20 14:04:19'),
('19066729', 'Christian Jay', 'Putolss', 'M', 'syomairays7@gmail.com', 'BSIT-4', 'College Of Computer Studies', NULL, '2024-11-20 15:56:15', '2024-11-20 19:08:33'),
('19093459', 'Daryl', 'Capacite', 'M', 'daryl.capacite1963@gmail.com', 'BSIT 2', 'College Of Computer Studies', NULL, '2024-11-20 14:04:14', '2024-11-20 14:04:14'),
('23207038', 'John Emmanuel', 'Watin', 'M', 'watinemmanuel@gmail.com', 'BSIT 1', 'College Of Computer Studies', NULL, '2024-11-20 14:04:20', '2024-11-20 14:04:20'),
('23207640', 'Richnell', 'Adana', 'M', 'Richnelladana.ra@gmail.com', 'BSIT 1', 'College Of Computer Studies', NULL, '2024-11-20 14:04:13', '2024-11-20 14:04:13'),
('23216708', 'Dansean James', 'Awit', 'M', 'jamesdansean@gmail.com', 'BSIT 1', 'College Of Computer Studies', NULL, '2024-11-20 14:04:13', '2024-11-20 14:04:13'),
('23222425', 'Roomitch', 'Ripdos', 'M', 'roomitchm@gmail.com', 'BSIT 1', 'College Of Computer Studies', NULL, '2024-11-20 14:04:19', '2024-11-20 14:04:19'),
('23222771', 'Jon Rohnbert', 'Biong', 'M', 'Rohnbert123456@gmail.com', 'BSIT 1', 'College Of Computer Studies', NULL, '2024-11-20 14:04:14', '2024-11-20 14:04:14'),
('23229388', 'Jhouanese', 'Condor', 'M', 'condorjhounaese@gmail.com', 'BSIT 1', 'College Of Computer Studies', NULL, '2024-11-20 14:04:15', '2024-11-20 14:04:15'),
('23233299', 'Mar Luar', 'Igot', 'M', 'marluarigot31@gmail.com', 'BSIT 1', 'College Of Computer Studies', NULL, '2024-11-20 14:04:17', '2024-11-20 14:04:17'),
('23238686', 'Jhanly', 'Selencio', 'M', 'jlyselencio01@gmail.com', 'BSIT 1', 'College Of Computer Studies', NULL, '2024-11-20 14:04:20', '2024-11-20 14:04:20'),
('23240302', 'John Pearlnel', 'Dinoro', 'M', 'jndnro.21@gmail.com', 'BSIT 12', 'College Of Computer Studies', NULL, '2024-11-20 14:04:15', '2024-11-20 14:04:15'),
('23245954', 'Lui Mar', 'Geopano', 'M', 'luimargeopano4@gmail.com', 'BSIT 1', 'College Of Computer Studies', NULL, '2024-11-20 14:04:16', '2024-11-20 14:04:16'),
('23257363', 'Jhorsten', 'Baclohan', 'M', 'Jhorstenbaclohan0@gmail.com', 'BSIT 1', 'College Of Computer Studies', NULL, '2024-11-20 14:04:14', '2024-11-20 14:04:14'),
('25223538', 'Jeof Cyril', 'Humawan ', 'M', 'jeofcyril21@gmail.com', 'BSIT 1', 'College Of Computer Studies', NULL, '2024-11-20 14:04:17', '2024-11-20 14:04:17'),
('25228453', 'Elaine Ena', 'Villaluna', 'F', 'elaineenavillaluna@gmail.com', 'BSIT 1', 'College Of Computer Studies', NULL, '2024-11-20 14:04:13', '2024-11-20 14:04:13'),
('25230210', 'Jhon Rickciel', 'Escaran', 'M', 'jhonrickcieloe@gmail.com', 'BSIT 1', 'College Of Computer Studies', NULL, '2024-11-20 14:04:16', '2024-11-20 14:04:16'),
('25230228', 'Jhehanz', 'Bosotros', 'M', 'hanzjheigot12@gmail.com', 'BSIT 1', 'College Of Computer Studies', NULL, '2024-11-20 14:04:14', '2024-11-20 14:04:14'),
('25231218', 'Jayson Bernard', 'Frias', 'M', 'jaysonbernardfrias9@gmail.com', 'BSIT 1', 'College Of Computer Studies', NULL, '2024-11-20 14:04:16', '2024-11-20 14:04:16'),
('25232018', 'Tyrone Wayne ', 'Landero', 'M', 'Landerswaynet@gmail.com', 'BSIT 1', 'College Of Computer Studies', NULL, '2024-11-20 14:04:18', '2024-11-20 14:04:18'),
('25232398', 'Denver', 'Remo', 'M', 'denverremo007@gmail.com', 'BSIT 1', 'College Of Computer Studies', NULL, '2024-11-20 14:04:19', '2024-11-20 14:04:19'),
('25232604', 'Kevin', 'Kikuchi', 'M', 'chekoykuchi@gmail.com', 'BSIT 1', 'College Of Computer Studies', NULL, '2024-11-20 14:04:18', '2024-11-20 14:04:18'),
('25233990', 'Cesar', 'Dico', 'M', 'cjdico18@gmail.com', 'BSIT 1', 'College Of Computer Studies', NULL, '2024-11-20 14:04:15', '2024-11-20 14:04:15'),
('25234196', 'Shien Rose', 'Bilagantol', 'F', 'bilagantolshienrose@gmail.com', 'BSIT 1', 'College Of Computer Studies', NULL, '2024-11-20 14:04:12', '2024-11-20 14:04:12'),
('25236530', 'Rohwen Kent', 'Nim', 'M', 'teresacuna22@gmail.com', 'BSIT 1', 'College Of Computer Studies', NULL, '2024-11-20 14:04:18', '2024-11-20 14:04:18'),
('25236613', 'Remixon', 'Ipanag', 'M', 'ipanagremixon@gmail.com', 'BSIT 1', 'College Of Computer Studies', NULL, '2024-11-20 14:04:17', '2024-11-20 14:04:17'),
('25236696', 'Rojamin Merari', 'Pantorilla', 'M', 'rojaminygay@gmail.com', 'BSIT 1', 'College Of Computer Studies', NULL, '2024-11-20 14:04:19', '2024-11-20 14:04:19'),
('25236969', 'Jose Kobe ', 'Sanchez', 'M', 'sanchezplayerxp@gmail.com', 'BSIT 1', 'College Of Computer Studies', NULL, '2024-11-20 14:04:19', '2024-11-20 14:04:19'),
('25239831', 'John Rupert', 'Segarino', 'M', 'segarinorupert@gmail.com', 'BSIT 1', 'College Of Computer Studies', NULL, '2024-11-20 14:04:20', '2024-11-20 14:04:20'),
('25240714', 'Clark Adelaide', 'Lopez', 'M', 'clarklopez999@gmail.com', 'BSIT 1', 'College Of Computer Studies', NULL, '2024-11-20 14:04:18', '2024-11-20 14:04:18'),
('25240755', 'Matt Kerby', 'Cogo', 'M', 'mattcogo1@gmail.com', 'BSIT 1', 'College Of Computer Studies', NULL, '2024-11-20 14:04:15', '2024-11-20 14:04:15'),
('25241472', 'Armando', 'Yangao', 'M', 'armandoyangao@gmail.com', 'BSIT 1', 'College Of Computer Studies', NULL, '2024-11-20 14:04:20', '2024-11-20 14:04:20'),
('25243247', 'Geovan', 'Candongo', 'M', 'geovancandongo19@gmail.com', 'BSIT 1', 'College Of Computer Studies', NULL, '2024-11-20 14:04:14', '2024-11-20 14:04:14'),
('25243510', 'Sed Melton', 'Santos', 'M', 'sedsantos89@gmail.com', 'BSIT 1', 'College Of Computer Studies', NULL, '2024-11-20 14:04:20', '2024-11-20 14:04:20'),
('25243726', 'John Mar', 'Aledon', 'M', 'johnmaraledon823@gmail.com', 'BSIT 1', 'College Of Computer Studies', NULL, '2024-11-20 14:04:13', '2024-11-20 14:04:13'),
('25243858', 'John Jesnel', 'Remoto', 'M', 'kamihamiha64@gmail.com', 'BSIT 1', 'College Of Computer Studies', NULL, '2024-11-20 14:04:19', '2024-11-20 14:04:19'),
('25244427', 'Glenmark', 'Gungob', 'M', 'glenmarkgungob24@gmail.com', 'BSIT 1', 'College Of Computer Studies', NULL, '2024-11-20 14:04:17', '2024-11-20 14:04:17'),
('25244799', 'Liel Joseph', 'Ceniza', 'M', 'Lielceniza@gmail.com', 'BSIT 1', 'College Of Computer Studies', NULL, '2024-11-20 14:04:15', '2024-11-20 14:04:15'),
('25251927', 'Krishna Eurelle', 'Dizon', 'F', 'kryshxgorg@gmail.com', 'BSIT 1', 'College Of Computer Studies', NULL, '2024-11-20 14:04:12', '2024-11-20 14:04:12'),
('25251935', 'Hannah Shane', 'Tejero', 'F', 'hannahshanetejero27@gmail.com', 'BSIT 1', 'College Of Computer Studies', NULL, '2024-11-20 14:04:13', '2024-11-20 14:04:13'),
('25268020', 'Andrew', 'Galon', 'M', 'andrewgalon07@gmail.com', 'BSIT 1', 'College Of Computer Studies', NULL, '2024-11-20 14:04:16', '2024-11-20 14:04:16');

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
(1, 'The day the equipment is added in the system', 'Available', 1, 2, '2024-11-20 13:42:34', '2024-11-20 13:42:34'),
(2, 'Status updated to Borrowed', 'Borrowed', 1, 2, '2024-11-20 14:13:17', '2024-11-20 14:13:17'),
(3, 'Status updated to Available', 'Available', 1, 2, '2024-11-20 14:15:06', '2024-11-20 14:15:06'),
(4, 'Status updated to Borrowed', 'Borrowed', 1, 2, '2024-11-20 15:57:01', '2024-11-20 15:57:01'),
(5, 'Status updated to Available', 'Available', 1, 2, '2024-11-20 19:08:33', '2024-11-20 19:08:33');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `designation_id` int(10) UNSIGNED DEFAULT NULL,
  `office_id` int(10) UNSIGNED DEFAULT NULL,
  `student_id` varchar(255) DEFAULT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `mobile_no` varchar(50) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `type` varchar(50) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `last_login_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `designation_id`, `office_id`, `student_id`, `firstname`, `lastname`, `email`, `password`, `mobile_no`, `image`, `status`, `type`, `created_at`, `updated_at`, `last_login_at`, `remember_token`) VALUES
(1, NULL, NULL, NULL, 'admin', 'admin', 'admin@gmail.com', '$2y$12$1XlqEw/QMYVaHx6S2EhTUOxBa66ECPrKzOVBl0ymN0FJUNiNLpRmq', '09924821214', 'images/profile_pictures/default-profile.png', 'active', 'admin', '2024-11-19 07:32:49', '2024-11-19 07:32:49', '2024-11-20 11:06:14', NULL),
(2, 1, 1, NULL, 'Christian Jay', 'Putol', 'chrischanjay29@gmail.com', '$2y$12$1D.6kE3S6xbW5mV/GoP3P.75x8eMxwl7V3lCn/DevPIfXC3H7awlK', '09924821214', 'images/profile_pictures/default-profile.png', 'active', 'facility manager', '2024-11-19 07:35:40', '2024-11-20 10:23:43', '2024-11-20 16:08:54', NULL),
(90, 2, 1, NULL, 'Christian Jay', 'Putol', 'christianjayputol29@gmail.com', '$2y$12$ue7QswKiAOBpLRMY.2iPM.ciwLCk7HbkljIy0cYPKvBC7V38V1Suy', '09924821214', 'images/profile_pictures/default-profile.png', 'active', 'facility manager', '2024-11-19 07:52:52', '2024-11-19 07:52:52', '2024-11-19 08:00:33', NULL),
(178, 3, 1, '25234196', 'Shien Rose', 'Bilagantol', 'bilagantolshienrose@gmail.com', '$2y$12$/g5VW3lP13v.XQ5Rk9J1U.hdcXbOKsjr.01ZxOP.0m2Kj6/nHGcLq', 'none', 'images/profile_pictures/default-profile.png', 'active', 'student', '2024-11-20 14:04:12', '2024-11-20 14:04:12', NULL, NULL),
(179, 3, 1, '25251927', 'Krishna Eurelle', 'Dizon', 'kryshxgorg@gmail.com', '$2y$12$G2s9D2Fxekl8/kmhFcTUdO7ZS5T3K8TXtlSHn7zV9Nx6gAgk7Krwu', 'none', 'images/profile_pictures/default-profile.png', 'active', 'student', '2024-11-20 14:04:12', '2024-11-20 14:04:12', NULL, NULL),
(180, 3, 1, '25251935', 'Hannah Shane', 'Tejero', 'hannahshanetejero27@gmail.com', '$2y$12$Y9yfJjh.XSAkPB5C.pB1Pu1tjldl5hXyyXKbt1JaFGgVpz74s3Wa.', 'none', 'images/profile_pictures/default-profile.png', 'active', 'student', '2024-11-20 14:04:13', '2024-11-20 14:04:13', NULL, NULL),
(181, 3, 1, '25228453', 'Elaine Ena', 'Villaluna', 'elaineenavillaluna@gmail.com', '$2y$12$RKlLchIXK0DC.twDC1ZmJ.cNLQVM5npjXQf/rqeNJK5LNLkI2n.fW', 'none', 'images/profile_pictures/default-profile.png', 'active', 'student', '2024-11-20 14:04:13', '2024-11-20 14:04:13', NULL, NULL),
(182, 3, 1, '23207640', 'Richnell', 'Adana', 'Richnelladana.ra@gmail.com', '$2y$12$UC8DezlZBRbs8xAsv1w3..kgm4XlOFdTcN1PWFwncJNGBsOYCDMe.', 'none', 'images/profile_pictures/default-profile.png', 'active', 'student', '2024-11-20 14:04:13', '2024-11-20 14:04:13', NULL, NULL),
(183, 3, 1, '25243726', 'John Mar', 'Aledon', 'johnmaraledon823@gmail.com', '$2y$12$He7f2IEJXMpfit82Znxt/OJSz29Z/HfQ8hvZm7JTMrhW8k7OuIdmm', 'none', 'images/profile_pictures/default-profile.png', 'active', 'student', '2024-11-20 14:04:13', '2024-11-20 14:04:13', NULL, NULL),
(184, 3, 1, '23216708', 'Dansean James', 'Awit', 'jamesdansean@gmail.com', '$2y$12$pNN9TP6vl8dyHWlpbNNHMOcnN0X5CcSGVPJITV3Cl//tOeL43ztx.', 'none', 'images/profile_pictures/default-profile.png', 'active', 'student', '2024-11-20 14:04:13', '2024-11-20 14:04:13', NULL, NULL),
(185, 3, 1, '23257363', 'Jhorsten', 'Baclohan', 'Jhorstenbaclohan0@gmail.com', '$2y$12$MDKadS/N.AMqXOFswl8KgeRcKmQi8RqUSeoJONyeKLWXU870Gz.Gy', 'none', 'images/profile_pictures/default-profile.png', 'active', 'student', '2024-11-20 14:04:14', '2024-11-20 14:04:14', NULL, NULL),
(186, 3, 1, '23222771', 'Jon Rohnbert', 'Biong', 'Rohnbert123456@gmail.com', '$2y$12$bLL.sDBjaJB/yxPwBOUa9erUsGBMsBcA3Yc6yRiz3ktZDvyyyqQqO', 'none', 'images/profile_pictures/default-profile.png', 'active', 'student', '2024-11-20 14:04:14', '2024-11-20 14:04:14', NULL, NULL),
(187, 3, 1, '25230228', 'Jhehanz', 'Bosotros', 'hanzjheigot12@gmail.com', '$2y$12$QYex7MYzrYTQ1MFNGVYdueT4yfxzffuVbKiH0UgJnqHLafIc6LxjC', 'none', 'images/profile_pictures/default-profile.png', 'active', 'student', '2024-11-20 14:04:14', '2024-11-20 14:04:14', NULL, NULL),
(188, 3, 1, '25243247', 'Geovan', 'Candongo', 'geovancandongo19@gmail.com', '$2y$12$dPg4K1bqywA7C9xrrJ2IOuhOFKEC/HeIaxcBnz6eYQs7rLjvTdHiu', 'none', 'images/profile_pictures/default-profile.png', 'active', 'student', '2024-11-20 14:04:14', '2024-11-20 14:04:14', NULL, NULL),
(189, 3, 1, '19093459', 'Daryl', 'Capacite', 'daryl.capacite1963@gmail.com', '$2y$12$BEiyVIhgTiCG0f5dLaVPkuSaR8X3xWGtzyEq4QHlBw2igCKcbldK6', 'none', 'images/profile_pictures/default-profile.png', 'active', 'student', '2024-11-20 14:04:14', '2024-11-20 14:04:14', NULL, NULL),
(190, 3, 1, '25244799', 'Liel Joseph', 'Ceniza', 'Lielceniza@gmail.com', '$2y$12$EtOA71add1/GkS26nsh8zORZGMsjI0SJjWwiD4kXT5PvICLU99VWa', 'none', 'images/profile_pictures/default-profile.png', 'active', 'student', '2024-11-20 14:04:15', '2024-11-20 14:04:15', NULL, NULL),
(191, 3, 1, '25240755', 'Matt Kerby', 'Cogo', 'mattcogo1@gmail.com', '$2y$12$Ti9fC9ih8YcvGpIliydgJOwdVHognG9UnKKqso/wvK5DUkgkQ19MC', 'none', 'images/profile_pictures/default-profile.png', 'active', 'student', '2024-11-20 14:04:15', '2024-11-20 14:04:15', NULL, NULL),
(192, 3, 1, '23229388', 'Jhouanese', 'Condor', 'condorjhounaese@gmail.com', '$2y$12$xe3VXHUFSRRpuhhYYXHv.eqo.6gH3s5sO64YTuuB0EJE3cVpM8ifm', 'none', 'images/profile_pictures/default-profile.png', 'active', 'student', '2024-11-20 14:04:15', '2024-11-20 14:04:15', NULL, NULL),
(193, 3, 1, '25233990', 'Cesar', 'Dico', 'cjdico18@gmail.com', '$2y$12$JrGriEY1YaNh560sf9Tkn.N24w511xNuGej7irbL2eCqBdn90Fcge', 'none', 'images/profile_pictures/default-profile.png', 'active', 'student', '2024-11-20 14:04:15', '2024-11-20 14:04:15', NULL, NULL),
(194, 3, 1, '23240302', 'John Pearlnel', 'Dinoro', 'jndnro.21@gmail.com', '$2y$12$niTc/ijFfysFa6ogJIcX5u6fyKWeVcvTl5BVodS/L5ZqbBcCGLPb2', 'none', 'images/profile_pictures/default-profile.png', 'active', 'student', '2024-11-20 14:04:15', '2024-11-20 14:04:15', NULL, NULL),
(195, 3, 1, '25230210', 'Jhon Rickciel', 'Escaran', 'jhonrickcieloe@gmail.com', '$2y$12$a9OQ1j7ZjE95J0W8f8ms.uZLbSl3n1QUk0OVlg6OTENESWy6WMGku', 'none', 'images/profile_pictures/default-profile.png', 'active', 'student', '2024-11-20 14:04:16', '2024-11-20 14:04:16', NULL, NULL),
(196, 3, 1, '17936428', 'Charles Jenson', 'Fabrigas', 'Charles.fabrgas@gmail.com', '$2y$12$m1SocqyHuNFRRfyrRzKkrO6fRTtgZanW/7TGOuqWy5ySPOCaYoBj6', 'none', 'images/profile_pictures/default-profile.png', 'active', 'student', '2024-11-20 14:04:16', '2024-11-20 14:04:16', NULL, NULL),
(197, 3, 1, '25231218', 'Jayson Bernard', 'Frias', 'jaysonbernardfrias9@gmail.com', '$2y$12$zdFaSktWj5YE6iRuIJxDWeMgBTRckSRWLiX/2lHFGjYHb59H9Gobq', 'none', 'images/profile_pictures/default-profile.png', 'active', 'student', '2024-11-20 14:04:16', '2024-11-20 14:04:16', NULL, NULL),
(198, 3, 1, '25268020', 'Andrew', 'Galon', 'andrewgalon07@gmail.com', '$2y$12$3joi6thsCp8yPEcnOuWFf.PjY7lq2tNGX088DOfkTzqRT5zQr2ymy', 'none', 'images/profile_pictures/default-profile.png', 'active', 'student', '2024-11-20 14:04:16', '2024-11-20 14:04:16', NULL, NULL),
(199, 3, 1, '23245954', 'Lui Mar', 'Geopano', 'luimargeopano4@gmail.com', '$2y$12$XToDreaeXl0khw/HyT5Fp.E3FWu8frimeRdDs9uoBRUmB5Mcq3mRO', 'none', 'images/profile_pictures/default-profile.png', 'active', 'student', '2024-11-20 14:04:16', '2024-11-20 14:04:16', NULL, NULL),
(200, 3, 1, '25244427', 'Glenmark', 'Gungob', 'glenmarkgungob24@gmail.com', '$2y$12$idHZx3kGIGsUsYPbVoV3gOjFrAXnw0xz9bXJnac3hsyOk4T9SAqaK', 'none', 'images/profile_pictures/default-profile.png', 'active', 'student', '2024-11-20 14:04:17', '2024-11-20 14:04:17', NULL, NULL),
(201, 3, 1, '25223538', 'Jeof Cyril', 'Humawan ', 'jeofcyril21@gmail.com', '$2y$12$7gkRGwMsEN0RhYIYKvjLM.Lv67lxWcyZxNnC7/Q.WpnOUCs3u.3Mu', 'none', 'images/profile_pictures/default-profile.png', 'active', 'student', '2024-11-20 14:04:17', '2024-11-20 14:04:17', NULL, NULL),
(202, 3, 1, '18035147', 'John Lyndon', 'Ibaoc', '27gooddays@gmail.com', '$2y$12$mJujW9A7frf9DqC2vhJ15uVO0g8yLNjdt8sLE/Ac42dEypy3/JjIG', 'none', 'images/profile_pictures/default-profile.png', 'active', 'student', '2024-11-20 14:04:17', '2024-11-20 14:04:17', NULL, NULL),
(203, 3, 1, '23233299', 'Mar Luar', 'Igot', 'marluarigot31@gmail.com', '$2y$12$msQ6Rz9EhLPG8S9rtq.bbu3pvpwT4pw.CdbsmdGcEL7u17reyiRm6', 'none', 'images/profile_pictures/default-profile.png', 'active', 'student', '2024-11-20 14:04:17', '2024-11-20 14:04:17', NULL, NULL),
(204, 3, 1, '25236613', 'Remixon', 'Ipanag', 'ipanagremixon@gmail.com', '$2y$12$Uiun0yahHiZ05ix0kOsDJePGlh5MSi4gONjTq3GtBTpcN0v4oMaga', 'none', 'images/profile_pictures/default-profile.png', 'active', 'student', '2024-11-20 14:04:17', '2024-11-20 14:04:17', NULL, NULL),
(205, 3, 1, '25232604', 'Kevin', 'Kikuchi', 'chekoykuchi@gmail.com', '$2y$12$svco4KGWKpkjaGTBmuuc7uJi8EqdXOG06euAzenl.ppUVo6YKl0C2', 'none', 'images/profile_pictures/default-profile.png', 'active', 'student', '2024-11-20 14:04:18', '2024-11-20 14:04:18', NULL, NULL),
(206, 3, 1, '25232018', 'Tyrone Wayne ', 'Landero', 'Landerswaynet@gmail.com', '$2y$12$nvyYQYVlrXmkNHcmEGSdVeMQ3fEqAFPV/.TU97eK7piF72kGs9GJK', 'none', 'images/profile_pictures/default-profile.png', 'active', 'student', '2024-11-20 14:04:18', '2024-11-20 14:04:18', NULL, NULL),
(207, 3, 1, '25240714', 'Clark Adelaide', 'Lopez', 'clarklopez999@gmail.com', '$2y$12$bA6YYhGc19gyj3WfBDH78OCGnSpwEHJ1ZRQxAd5.NzKfeWSK71x56', 'none', 'images/profile_pictures/default-profile.png', 'active', 'student', '2024-11-20 14:04:18', '2024-11-20 14:04:18', NULL, NULL),
(208, 3, 1, '25236530', 'Rohwen Kent', 'Nim', 'teresacuna22@gmail.com', '$2y$12$jJfKrYg8EOf7u6KdJEKnG.bA/BKNhAXSAc1IIf5pHHZGiWp62QHf.', 'none', 'images/profile_pictures/default-profile.png', 'active', 'student', '2024-11-20 14:04:18', '2024-11-20 14:04:18', NULL, NULL),
(209, 3, 1, '18985812', 'Laurence Johnvel', 'Pantaleon', 'johnvelpantaleon20@gmail.com', '$2y$12$ND.XsEdzgZimYWQCB8lo2.cVmsjHCSnzl4Xlav1Dep.qHxUiHASWa', 'none', 'images/profile_pictures/default-profile.png', 'active', 'student', '2024-11-20 14:04:18', '2024-11-20 14:04:18', NULL, NULL),
(210, 3, 1, '25236696', 'Rojamin Merari', 'Pantorilla', 'rojaminygay@gmail.com', '$2y$12$7YVrf4p7Uj1.1zWO1dofVe5KKE6OgFgfc4ij9cWCcZiGGxw4dXyNq', 'none', 'images/profile_pictures/default-profile.png', 'active', 'student', '2024-11-20 14:04:19', '2024-11-20 14:04:19', NULL, NULL),
(211, 3, 1, '25232398', 'Denver', 'Remo', 'denverremo007@gmail.com', '$2y$12$btOJnWGCsSXTFR18l.29d.yp9jp16vqqHuxpyts45DV2.IDfH7QOm', 'none', 'images/profile_pictures/default-profile.png', 'active', 'student', '2024-11-20 14:04:19', '2024-11-20 14:04:19', NULL, NULL),
(212, 3, 1, '25243858', 'John Jesnel', 'Remoto', 'kamihamiha64@gmail.com', '$2y$12$/fTmx.JAkR0wyHuhcDk7jeICMXp9257245refG5yK8/W.MhoNJ9k6', 'none', 'images/profile_pictures/default-profile.png', 'active', 'student', '2024-11-20 14:04:19', '2024-11-20 14:04:19', NULL, NULL),
(213, 3, 1, '23222425', 'Roomitch', 'Ripdos', 'roomitchm@gmail.com', '$2y$12$hv1nIf7HBd0TJMAMv9E4J.9Bypr6B4bofsO7OpZPrJJhiBgphTgdS', 'none', 'images/profile_pictures/default-profile.png', 'active', 'student', '2024-11-20 14:04:19', '2024-11-20 14:04:19', NULL, NULL),
(214, 3, 1, '18988592', 'Coolbay John', 'Rodrigo', 'coolbayjohn9sapphire@gmail.com', '$2y$12$Cmhen7J4cmL6waWAY/bzyOweEmG5UoZynDkGFpLCFccgfcuW/wH5e', 'none', 'images/profile_pictures/default-profile.png', 'active', 'student', '2024-11-20 14:04:19', '2024-11-20 14:04:19', NULL, NULL),
(215, 3, 1, '25236969', 'Jose Kobe ', 'Sanchez', 'sanchezplayerxp@gmail.com', '$2y$12$vTX1q.cGY03CizmgATifB..Mggc8oUb45mKeHUeNDeAqHgGmtRT.y', 'none', 'images/profile_pictures/default-profile.png', 'active', 'student', '2024-11-20 14:04:19', '2024-11-20 14:04:19', NULL, NULL),
(216, 3, 1, '25243510', 'Sed Melton', 'Santos', 'sedsantos89@gmail.com', '$2y$12$zIn61ecdwwM9Hr0mjuc7RenrkcoNMjjIjQ6DOLz8To/QVrKEZOx0u', 'none', 'images/profile_pictures/default-profile.png', 'active', 'student', '2024-11-20 14:04:20', '2024-11-20 14:04:20', NULL, NULL),
(217, 3, 1, '25239831', 'John Rupert', 'Segarino', 'segarinorupert@gmail.com', '$2y$12$Xt9UPPYaOG/rdJ8q3fa7fub5ctZJEYI3BStcu6vGI2Y9YLGW9JZmS', 'none', 'images/profile_pictures/default-profile.png', 'active', 'student', '2024-11-20 14:04:20', '2024-11-20 14:04:20', NULL, NULL),
(218, 3, 1, '23238686', 'Jhanly', 'Selencio', 'jlyselencio01@gmail.com', '$2y$12$DfuB.PZODLIFsmWP4lalXetKOMKLFutjS5WZ.1/qwXA.sNAHxNqY.', 'none', 'images/profile_pictures/default-profile.png', 'active', 'student', '2024-11-20 14:04:20', '2024-11-20 14:04:20', NULL, NULL),
(219, 3, 1, '23207038', 'John Emmanuel', 'Watin', 'watinemmanuel@gmail.com', '$2y$12$wBvnApJ7aXnLTj.zMrjvFuh8kugAM9i3AzOSQMEbkz2ZDxqMB5rLq', 'none', 'images/profile_pictures/default-profile.png', 'active', 'student', '2024-11-20 14:04:20', '2024-11-20 14:04:20', NULL, NULL),
(220, 3, 1, '25241472', 'Armando', 'Yangao', 'armandoyangao@gmail.com', '$2y$12$N7Z4zT/Pk7EAXmnQX/j5zOtK8Sszr8i4.w4qpE0A2v5IgWhDjgkSe', 'none', 'images/profile_pictures/default-profile.png', 'active', 'student', '2024-11-20 14:04:20', '2024-11-20 14:04:20', NULL, NULL),
(223, 3, 1, '19066729', 'Christian Jay', 'Putolss', 'syomairays7@gmail.com', '$2y$12$0jEmBri5oln6eCkNfVFAyOfRKRgnOSdPozSRRl8YRD/uDn6umntuG', 'none', 'images/profile_pictures/default-profile.png', 'active', 'student', '2024-11-20 15:56:15', '2024-11-20 15:56:15', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `borrows`
--
ALTER TABLE `borrows`
  ADD PRIMARY KEY (`id`),
  ADD KEY `borrows_equipment_id_foreign` (`equipment_id`),
  ADD KEY `borrows_user_id_foreign` (`user_id`),
  ADD KEY `borrows_borrowers_id_no_foreign` (`borrowers_id_no`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

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
  ADD PRIMARY KEY (`id`),
  ADD KEY `donated_equipment_id_foreign` (`equipment_id`),
  ADD KEY `donated_user_id_foreign` (`user_id`);

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
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD UNIQUE KEY `password_reset_tokens_email_unique` (`email`);

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
-- Indexes for table `reservation`
--
ALTER TABLE `reservation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reservation_student_id_foreign` (`student_id`),
  ADD KEY `reservation_equipment_id_foreign` (`equipment_id`),
  ADD KEY `reservation_office_id_foreign` (`office_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`);

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
  ADD KEY `users_student_id_foreign` (`student_id`),
  ADD KEY `users_designation_id_foreign` (`designation_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `borrows`
--
ALTER TABLE `borrows`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `designations`
--
ALTER TABLE `designations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `facilities`
--
ALTER TABLE `facilities`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `maintenance`
--
ALTER TABLE `maintenance`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `maintenance_schedules`
--
ALTER TABLE `maintenance_schedules`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `offices`
--
ALTER TABLE `offices`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `repairs`
--
ALTER TABLE `repairs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reservation`
--
ALTER TABLE `reservation`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `timeline`
--
ALTER TABLE `timeline`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=224;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `borrows`
--
ALTER TABLE `borrows`
  ADD CONSTRAINT `borrows_borrowers_id_no_foreign` FOREIGN KEY (`borrowers_id_no`) REFERENCES `students` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `borrows_equipment_id_foreign` FOREIGN KEY (`equipment_id`) REFERENCES `equipments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `borrows_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `disposed`
--
ALTER TABLE `disposed`
  ADD CONSTRAINT `disposed_equipment_id_foreign` FOREIGN KEY (`equipment_id`) REFERENCES `equipments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `disposed_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `donated`
--
ALTER TABLE `donated`
  ADD CONSTRAINT `donated_equipment_id_foreign` FOREIGN KEY (`equipment_id`) REFERENCES `equipments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `donated_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

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
-- Constraints for table `reservation`
--
ALTER TABLE `reservation`
  ADD CONSTRAINT `reservation_equipment_id_foreign` FOREIGN KEY (`equipment_id`) REFERENCES `equipments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reservation_office_id_foreign` FOREIGN KEY (`office_id`) REFERENCES `offices` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reservation_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE;

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
  ADD CONSTRAINT `users_office_id_foreign` FOREIGN KEY (`office_id`) REFERENCES `offices` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `users_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
