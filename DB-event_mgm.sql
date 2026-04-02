-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Apr 02, 2026 at 06:14 AM
-- Server version: 8.3.0
-- PHP Version: 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `event_mgm`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendees`
--

DROP TABLE IF EXISTS `attendees`;
CREATE TABLE IF NOT EXISTS `attendees` (
  `attendee_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `order_item_id` bigint UNSIGNED NOT NULL,
  `full_name` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(190) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `phone` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `checkin_status` enum('not_checked_in','checked_in') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'not_checked_in',
  `checkin_time` datetime DEFAULT NULL,
  PRIMARY KEY (`attendee_id`),
  KEY `fk_attendees_orderitem` (`order_item_id`),
  KEY `idx_attendees_name` (`full_name`),
  KEY `idx_attendees_checkin` (`checkin_status`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
CREATE TABLE IF NOT EXISTS `cache` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

DROP TABLE IF EXISTS `events`;
CREATE TABLE IF NOT EXISTS `events` (
  `event_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `venue_id` bigint UNSIGNED DEFAULT NULL,
  `event_name` varchar(180) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `price` decimal(12,2) NOT NULL DEFAULT '0.00',
  `currency` char(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'USD',
  `timezone` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'UTC',
  `status` enum('draft','published','archived') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'draft',
  `created_by` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`event_id`),
  KEY `events_venue_id_foreign` (`venue_id`),
  KEY `events_created_by_foreign` (`created_by`),
  KEY `idx_events_dates` (`start_date`,`end_date`),
  KEY `idx_events_status` (`status`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`event_id`, `venue_id`, `event_name`, `description`, `start_date`, `end_date`, `price`, `currency`, `timezone`, `status`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 1, 'Tech Summit 2025', 'Annual technology conference', '2026-03-25', '2026-03-25', 150.00, 'USD', 'Asia/Phnom_Penh', 'draft', 0, NULL, '2026-03-28 05:17:13'),
(2, 1, 'Technology Cambodia', 'Technology Cambodia', '2026-04-01', '2026-04-01', 150.00, 'USD', 'Asia/Phnom_Penh', 'published', 1, '2026-03-24 08:01:52', '2026-03-28 05:16:49'),
(3, 1, 'Cambodia Web Dev & Infra Summit 2026', NULL, '2026-04-02', '2026-04-02', 150.00, 'USD', 'Asia/Phnom_Penh', 'published', 1, '2026-03-28 10:25:42', '2026-04-01 23:12:20');

-- --------------------------------------------------------

--
-- Table structure for table `event_sponsors`
--

DROP TABLE IF EXISTS `event_sponsors`;
CREATE TABLE IF NOT EXISTS `event_sponsors` (
  `event_id` bigint UNSIGNED NOT NULL,
  `sponsor_id` bigint UNSIGNED NOT NULL,
  `tier` enum('platinum','gold','silver','bronze','partner') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'partner',
  `amount` decimal(12,2) DEFAULT NULL,
  PRIMARY KEY (`event_id`,`sponsor_id`),
  KEY `idx_es_tier` (`tier`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `event_sponsors`
--

INSERT INTO `event_sponsors` (`event_id`, `sponsor_id`, `tier`, `amount`) VALUES
(1, 1, 'platinum', 50000.00),
(1, 2, 'gold', 30000.00),
(1, 3, 'platinum', 1000.00),
(1, 4, 'silver', 15000.00),
(1, 5, 'bronze', 5000.00),
(1, 6, 'platinum', 1000.00),
(1, 7, 'gold', 500.00),
(1, 8, 'gold', 500.00),
(2, 7, 'platinum', 1000.00),
(2, 8, 'platinum', 1000.00),
(3, 3, 'gold', 500.00);

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mailbox_messages`
--

DROP TABLE IF EXISTS `mailbox_messages`;
CREATE TABLE IF NOT EXISTS `mailbox_messages` (
  `message_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `event_id` bigint DEFAULT NULL,
  `sender_name` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `sender_email` varchar(190) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `recipient_email` varchar(190) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `subject` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `body` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `folder` enum('inbox','sent','draft','trash') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'inbox',
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  `created_by` bigint DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`message_id`),
  KEY `fk_mail_user` (`created_by`),
  KEY `idx_mail_folder_read` (`folder`,`is_read`),
  KEY `idx_mail_event` (`event_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mailbox_messages`
--

INSERT INTO `mailbox_messages` (`message_id`, `event_id`, `sender_name`, `sender_email`, `recipient_email`, `subject`, `body`, `folder`, `is_read`, `created_by`, `created_at`) VALUES
(1, NULL, 'Chet Vichea', 'vichea.chet@gmail.com', 'sovanrith.tha@gmail.com', 'testing', 'Hello', 'inbox', 1, NULL, '2026-03-28 09:53:09'),
(2, 3, 'HLB', 'sovanrith.tha@gmail.com', 'info@mgmevent.com', 'testing', 'Hello', 'inbox', 1, NULL, '2026-04-02 01:49:44'),
(3, NULL, 'Tha Sovanrith', 'kzezzgaming@gmail.com', 'sovanrith.tha@gmail.com', 'testing', 'Hello Sovanrith', 'inbox', 1, NULL, '2026-04-02 04:09:27');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=50 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2026_03_18_145021_create_speakers_table', 1),
(2, '2026_03_18_145440_create_users_table', 1),
(3, '2026_03_18_151019_create_cache_table', 1),
(4, '2026_03_18_151054_create_jobs_table', 1),
(5, '2026_03_18_151133_create_sessions_table', 1),
(29, '2026_03_23_123508_create_session_speakers_table', 2),
(30, '2026_03_23_124407_create_rooms_table', 2),
(31, '2026_03_23_124631_create_venues_table', 2),
(32, '2026_03_23_124846_create_tracks_table', 2),
(33, '2026_03_23_125040_create_events_table', 2),
(34, '2026_03_23_125555_create_public_schedule_view', 2),
(35, '2026_03_23_131919_create_schedule_table', 2),
(36, '2026_03_23_131946_create_sessions_table', 2),
(37, '2026_03_23_153307_create_sponsors_table', 3),
(38, '2026_03_23_153652_create_event_sponsors_table', 3),
(39, '2026_03_23_164144_create_orders_table', 4),
(40, '2026_03_23_164232_create_ticket_types_table', 4),
(41, '2026_03_23_164308_create_order_items_table', 4),
(42, '2026_03_23_164328_create_attendees_table', 4),
(43, '2026_03_24_025359_create_users_table', 5),
(44, '2026_03_24_025451_create_user_table', 6),
(45, '2026_03_24_030744_create_mailbox_messages_table', 7),
(46, '2026_03_24_031007_create_roles_table', 8),
(47, '2026_03_24_031022_create_user_settings_table', 8),
(48, '2026_03_24_032848_create_supplier_bookings_table', 9),
(49, '2026_04_02_024228_create_schedule_speaker_table', 10);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `order_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `event_id` bigint UNSIGNED NOT NULL,
  `buyer_name` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `buyer_email` varchar(190) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `buyer_phone` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status` enum('pending','paid','cancelled','refunded') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'pending',
  `payment_ref` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `subtotal` decimal(12,2) NOT NULL DEFAULT '0.00',
  `total` decimal(12,2) NOT NULL DEFAULT '0.00',
  `currency` char(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'USD',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`order_id`),
  KEY `idx_orders_event_status` (`event_id`,`status`),
  KEY `idx_orders_email` (`buyer_email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

DROP TABLE IF EXISTS `order_items`;
CREATE TABLE IF NOT EXISTS `order_items` (
  `order_item_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `order_id` bigint UNSIGNED NOT NULL,
  `ticket_type_id` bigint UNSIGNED NOT NULL,
  `qty` int NOT NULL,
  `unit_price` decimal(12,2) NOT NULL,
  `line_total` decimal(12,2) NOT NULL,
  PRIMARY KEY (`order_item_id`),
  KEY `fk_orderitems_ticket` (`ticket_type_id`),
  KEY `idx_orderitems_order` (`order_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_otps`
--

DROP TABLE IF EXISTS `password_reset_otps`;
CREATE TABLE IF NOT EXISTS `password_reset_otps` (
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `otp` varchar(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `expires_at` timestamp NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `token` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `role_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `role_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`role_id`),
  UNIQUE KEY `roles_role_name_unique` (`role_name`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`role_id`, `role_name`) VALUES
(1, 'Admin'),
(2, 'User'),
(3, 'Supplier');

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

DROP TABLE IF EXISTS `rooms`;
CREATE TABLE IF NOT EXISTS `rooms` (
  `room_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `venue_id` bigint UNSIGNED NOT NULL,
  `room_name` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `capacity` int DEFAULT NULL,
  PRIMARY KEY (`room_id`),
  UNIQUE KEY `uk_rooms_venue_name` (`venue_id`,`room_name`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`room_id`, `venue_id`, `room_name`, `capacity`) VALUES
(1, 1, 'Main Hall A', 500),
(2, 1, 'Room B', 200),
(3, 1, 'Room C', 150);

-- --------------------------------------------------------

--
-- Table structure for table `schedule`
--

DROP TABLE IF EXISTS `schedule`;
CREATE TABLE IF NOT EXISTS `schedule` (
  `schedule_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `event_id` bigint UNSIGNED NOT NULL,
  `track_id` bigint UNSIGNED DEFAULT NULL,
  `room_id` bigint UNSIGNED DEFAULT NULL,
  `title` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL,
  `session_type` enum('talk','workshop','panel','keynote','break','networking') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'talk',
  `status` enum('draft','confirmed','cancelled','pending') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'pending',
  `capacity` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`schedule_id`),
  KEY `schedule_track_id_foreign` (`track_id`),
  KEY `schedule_room_id_foreign` (`room_id`),
  KEY `idx_sessions_event_time` (`event_id`,`start_time`),
  KEY `idx_sessions_status` (`status`),
  KEY `schedule_event_id_index` (`event_id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `schedule`
--

INSERT INTO `schedule` (`schedule_id`, `event_id`, `track_id`, `room_id`, `title`, `description`, `start_time`, `end_time`, `session_type`, `status`, `capacity`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 'Opening Keynote', NULL, '2025-09-10 09:00:00', '2025-09-10 10:30:00', 'talk', 'confirmed', NULL, NULL, '2026-03-23 08:15:41'),
(2, 3, 1, 3, 'Laravel 11 Deep Dive', NULL, '2025-09-10 08:00:00', '2025-09-10 12:00:00', 'workshop', 'confirmed', NULL, NULL, '2026-03-30 00:33:25');

-- --------------------------------------------------------

--
-- Table structure for table `schedule_speaker`
--

DROP TABLE IF EXISTS `schedule_speaker`;
CREATE TABLE IF NOT EXISTS `schedule_speaker` (
  `schedule_id` bigint UNSIGNED NOT NULL,
  `speaker_id` bigint UNSIGNED NOT NULL,
  PRIMARY KEY (`schedule_id`,`speaker_id`),
  KEY `schedule_speaker_speaker_id_foreign` (`speaker_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `session_speakers`
--

DROP TABLE IF EXISTS `session_speakers`;
CREATE TABLE IF NOT EXISTS `session_speakers` (
  `schedule_id` bigint UNSIGNED NOT NULL,
  `speaker_id` bigint UNSIGNED NOT NULL,
  `speaker_role` enum('speaker','moderator','panelist') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'speaker',
  PRIMARY KEY (`schedule_id`,`speaker_id`),
  KEY `session_speakers_speaker_id_foreign` (`speaker_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `session_speakers`
--

INSERT INTO `session_speakers` (`schedule_id`, `speaker_id`, `speaker_role`) VALUES
(1, 1, 'speaker'),
(2, 2, 'speaker');

-- --------------------------------------------------------

--
-- Table structure for table `speakers`
--

DROP TABLE IF EXISTS `speakers`;
CREATE TABLE IF NOT EXISTS `speakers` (
  `speaker_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `full_name` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `title` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `company` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `bio` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `email` varchar(190) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `phone` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `photo_url` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status` enum('active','inactive') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`speaker_id`),
  KEY `idx_speakers_name` (`full_name`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `speakers`
--

INSERT INTO `speakers` (`speaker_id`, `full_name`, `title`, `company`, `bio`, `email`, `phone`, `photo_url`, `status`, `created_at`, `updated_at`) VALUES
(1, 'John Doe', 'Senior Developer', 'Tech Corp', 'Expert in Laravel and database design.', 'john@example.com', '0885656654', 'uploads/speakers/1775068322.jpg', 'active', '2026-03-22 21:07:56', '2026-04-01 18:42:12'),
(2, 'Jasmine', 'Founder & Graphic Designer', 'HLB Cambodia', 'Founder and Graphic Designer with a strong background in digital media and IT.', 'sovanrith.tha@gmail.com', '098098794', 'uploads/speakers/1775068391.jpg', 'active', '2026-03-22 23:25:04', '2026-04-01 18:42:12'),
(3, 'Tha Sovanrith', 'Web Developer', 'HLB Cambodia', 'Web Developer', 'sovanrith.tha@gmail.com', '0969358760', 'uploads/speakers/1774254923.jpg', 'active', '2026-03-22 23:48:02', '2026-04-01 18:42:12'),
(5, 'John Doe', 'Senior Engineer', 'Meta', 'Senior Engineer', 'john@example.com', '0969358760', 'uploads/speakers/1774856268.jpg', 'active', NULL, '2026-04-01 11:43:50'),
(6, 'Jane Smith', 'Tech Lead', 'Google', 'Senior Engineer', 'jane@example.com', '+1-555-010-8833', 'uploads/speakers/1775068360.jpg', 'active', NULL, '2026-04-01 11:43:58'),
(7, 'David Lee', 'CTO', 'Startup', 'Experienced Chief Technology Officer specializing in early-stage startup growth.', 'david@example.com', '+1-555-019-2244', 'uploads/speakers/1775068376.jpg', 'active', NULL, '2026-04-01 18:42:12'),
(8, 'Chet Vichea', 'Web Developer', 'Creative Web Studio', 'Professional Web Developer focused on building scalable, user-friendly web applications.', 'vichea.chet@gmail.com', '+1-206-000-0003', 'uploads/speakers/1774427130.jpg', 'active', '2026-03-25 01:25:30', '2026-04-01 18:42:12');

-- --------------------------------------------------------

--
-- Table structure for table `sponsors`
--

DROP TABLE IF EXISTS `sponsors`;
CREATE TABLE IF NOT EXISTS `sponsors` (
  `sponsor_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(180) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `website` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `logo_url` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `contact_name` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `contact_email` varchar(190) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `contact_phone` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`sponsor_id`),
  KEY `idx_sponsors_name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sponsors`
--

INSERT INTO `sponsors` (`sponsor_id`, `name`, `website`, `logo_url`, `contact_name`, `contact_email`, `contact_phone`, `created_at`, `updated_at`) VALUES
(3, 'AWS', 'https://aws.amazon.com', '1774359999_gl-spon-three.png', 'Carol White', 'carol@amazon.com', '+1-206-000-0003', NULL, '2026-04-01 23:13:00'),
(8, 'CETA', 'https://www.ceta.com', '1774359974_gl-spon-one.png', 'Tha Sovanrith', 'sovanrith.tha@gmail.com', '0969358760', '2026-03-23 09:31:14', '2026-03-30 00:38:14'),
(7, 'HLB', 'https://www.hlb.com', '1774856327_pt-spon-two.png', 'Tha Sovanrith', 'sovanrith.tha@gmail.com', '0969358760', '2026-03-23 09:05:08', '2026-03-30 00:38:47');

-- --------------------------------------------------------

--
-- Table structure for table `supplier_bookings`
--

DROP TABLE IF EXISTS `supplier_bookings`;
CREATE TABLE IF NOT EXISTS `supplier_bookings` (
  `booking_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `event_id` bigint UNSIGNED NOT NULL,
  `supplier_name` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `booking_date` date NOT NULL,
  `amount` decimal(12,2) NOT NULL,
  `currency` char(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'USD',
  `status` enum('pending','confirmed','cancelled','paid') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'pending',
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`booking_id`),
  KEY `supplier_bookings_event_id_foreign` (`event_id`),
  KEY `supplier_bookings_created_by_foreign` (`created_by`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `supplier_bookings`
--

INSERT INTO `supplier_bookings` (`booking_id`, `event_id`, `supplier_name`, `description`, `booking_date`, `amount`, `currency`, `status`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 1, 'Tha Sovanrith', 'Hello', '2026-03-25', 150.00, 'USD', 'cancelled', NULL, '2026-03-23 20:51:36', '2026-03-30 00:34:22'),
(2, 1, 'Chet Vichea', NULL, '2026-03-24', 150.00, 'USD', 'cancelled', 1, '2026-03-24 07:05:01', '2026-03-30 00:34:26'),
(3, 2, 'Siv Meng', NULL, '2026-03-25', 150.00, 'USD', 'cancelled', 1, '2026-03-25 01:29:35', '2026-03-30 00:34:31'),
(4, 1, 'Chet Vichea', NULL, '2026-03-31', 150.00, 'USD', 'cancelled', 3, '2026-03-28 02:53:32', '2026-03-30 00:34:02'),
(5, 1, 'Chet Vichea', NULL, '2026-04-01', 150.00, 'USD', 'cancelled', 3, '2026-03-28 05:18:18', '2026-03-30 00:33:56'),
(6, 3, 'Tha Sovanrith', NULL, '2026-04-25', 150.00, 'USD', 'cancelled', 1, '2026-03-28 10:28:48', '2026-03-30 00:34:11'),
(7, 3, 'Tha Sovanrith', NULL, '2026-04-25', 150.00, 'USD', 'cancelled', 1, '2026-03-28 10:29:50', '2026-03-30 00:34:17'),
(8, 3, 'ថា សុវណ្ណឬទ្ធិ', NULL, '2026-03-29', 150.00, 'USD', 'paid', 4, '2026-03-30 00:39:39', '2026-03-30 00:39:39'),
(9, 3, 'Chet Vichea', NULL, '2026-03-30', 150.00, 'USD', 'paid', 3, '2026-03-30 00:40:16', '2026-04-01 09:56:28');

-- --------------------------------------------------------

--
-- Table structure for table `ticket_types`
--

DROP TABLE IF EXISTS `ticket_types`;
CREATE TABLE IF NOT EXISTS `ticket_types` (
  `ticket_type_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `event_id` bigint UNSIGNED NOT NULL,
  `name` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `price` decimal(12,2) NOT NULL DEFAULT '0.00',
  `currency` char(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'USD',
  `quota` int DEFAULT NULL,
  `sale_start` datetime DEFAULT NULL,
  `sale_end` datetime DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`ticket_type_id`),
  UNIQUE KEY `uk_ticket_event_name` (`event_id`,`name`),
  KEY `idx_ticket_active` (`is_active`),
  KEY `event_id` (`event_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ticket_types`
--

INSERT INTO `ticket_types` (`ticket_type_id`, `event_id`, `name`, `price`, `currency`, `quota`, `sale_start`, `sale_end`, `is_active`) VALUES
(1, 1, 'Regular Admission', 150.00, 'USD', 100, NULL, NULL, 1),
(2, 1, 'VIP Ticket', 150.00, 'USD', 100, '2026-03-24 14:14:29', '2026-04-23 14:14:29', 1),
(3, 1, 'Standard Ticket', 50.00, 'USD', 500, '2026-03-24 14:14:29', '2026-04-23 14:14:29', 1),
(4, 1, 'Early Bird', 35.00, 'USD', 200, '2026-03-24 14:14:29', '2026-04-23 14:14:29', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tracks`
--

DROP TABLE IF EXISTS `tracks`;
CREATE TABLE IF NOT EXISTS `tracks` (
  `track_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `event_id` bigint UNSIGNED NOT NULL,
  `track_name` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `sort_order` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`track_id`),
  UNIQUE KEY `uk_tracks_event_name` (`event_id`,`track_name`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tracks`
--

INSERT INTO `tracks` (`track_id`, `event_id`, `track_name`, `sort_order`) VALUES
(1, 1, 'Web Development', 1),
(2, 1, 'Data & AI', 2),
(3, 1, 'Cloud & DevOps', 3);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `role_id` int NOT NULL,
  `full_name` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(190) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password_hash` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar_url` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `fk_users_role` (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `role_id`, `full_name`, `email`, `password_hash`, `avatar_url`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 1, 'Sovanrith Tha', 'sovanrith.tha@gmail.com', '$2y$12$8yIGSNT8yMPg9uSIaDZMeeITJWRv5.YowfigMg.lDq31dkAAUHmlC', 'avatars/r6LdCuXcpsJBdKcWs4VmyTQrMFLt6uhhpAHqBKeJ.jpg', 1, '2026-03-24 00:34:06', '2026-04-01 23:11:33'),
(2, 2, 'John Doe', 'john.doe@example.com', '$2y$12$F2m4WQS.QiWQYgHSzJXb3.L0fv7mMCKeCymP2D6a9JPiwCmHpWnhG', NULL, 1, '2026-03-24 00:34:06', '2026-03-24 08:21:20'),
(3, 3, 'Chet Vichea', 'vichea.chet@gmail.com', '$2y$12$PQ.QN/yW9Dog0HrYOSf6TOfrViBh2Z6JbM7v3bx0QbupX8JbF908G', 'avatars/pURcGvAd7IhgRYH10SLtMhAstFR6HVLhgZegfXTU.jpg', 1, '2026-03-24 06:44:57', '2026-03-28 09:52:46'),
(4, 3, 'Tha Sovanrith', 'kzezzgaming@gmail.com', '$2y$12$/AAV9y2sA.EdHbNIqDIbGulQMQQoJW55XPE.sbRUxfM6brCmxCTRS', 'avatars/WT0UA7iNhrmWFtBQrr3XkIHJJWi6w451slg7fcwG.jpg', 1, '2026-03-28 02:55:15', '2026-03-28 10:23:42'),
(5, 1, 'info', 'info@mgmevent.com', '$2y$12$yKglXhxYD2dl5W6CPC7ak.GkIcsFETNcnFBTbgR4/1IMGlvjf4Dr6', 'avatars/sH1THJPyE2C8jrvKh3a2oD3xRTywZoCK8dWDCnHA.jpg', 1, '2026-04-01 21:13:43', '2026-04-01 22:03:11');

-- --------------------------------------------------------

--
-- Table structure for table `user_settings`
--

DROP TABLE IF EXISTS `user_settings`;
CREATE TABLE IF NOT EXISTS `user_settings` (
  `user_id` bigint NOT NULL,
  `setting_key` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `setting_value` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`,`setting_key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `venues`
--

DROP TABLE IF EXISTS `venues`;
CREATE TABLE IF NOT EXISTS `venues` (
  `venue_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `venue_name` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `city` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `country` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `capacity` int DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`venue_id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `venues`
--

INSERT INTO `venues` (`venue_id`, `venue_name`, `address`, `city`, `country`, `capacity`, `created_at`) VALUES
(1, 'Koh Pich Convention Center', 'Diamond Island', 'Phnom Penh', 'Cambodia', 5000, '2026-03-23 14:38:26'),
(2, 'Morodok Techo National Stadium', 'Sangkat Prek Tasek, Khan Chroy Changvar', 'Phnom Penh', 'Cambodia', 60000, '2026-04-01 16:21:07'),
(3, 'Sokha Siem Reap Convention Center', 'Road 60, Phum Trang, Sangkat Slorkram', 'Siem Reap', 'Cambodia', 2000, '2026-04-01 16:21:07'),
(4, 'Premier Centre Sen Sok', 'Street 1003, Sangkat Phnom Penh Thmey, Khan Sen Sok', 'Phnom Penh', 'Cambodia', 3000, '2026-04-01 16:21:07'),
(5, 'Chaktomuk Conference Hall', 'Preah Sisowath Quay, Sangkat Chaktomuk', 'Phnom Penh', 'Cambodia', 570, '2026-04-01 16:21:07'),
(6, 'Sihanoukville Autonomous Port Hall', 'Street 800, Phum 3, Sangkat 3', 'Sihanoukville', 'Cambodia', 500, '2026-04-01 16:21:07'),
(7, 'Aeon Mall Sen Sok City Hall', 'St. 1003, Village Bayab, Sangkat Phnom Penh Thmey', 'Phnom Penh', 'Cambodia', 1500, '2026-04-01 16:21:21');

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_public_schedule`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `v_public_schedule`;
CREATE TABLE IF NOT EXISTS `v_public_schedule` (
`description` text
,`end_time` datetime
,`event_name` varchar(180)
,`room_name` varchar(120)
,`schedule_id` bigint unsigned
,`session_type` enum('talk','workshop','panel','keynote','break','networking')
,`speakers_list` text
,`start_time` datetime
,`title` varchar(200)
,`track_name` varchar(120)
,`venue_name` varchar(150)
);

-- --------------------------------------------------------

--
-- Structure for view `v_public_schedule`
--
DROP TABLE IF EXISTS `v_public_schedule`;

DROP VIEW IF EXISTS `v_public_schedule`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_public_schedule`  AS SELECT `sch`.`schedule_id` AS `schedule_id`, `e`.`event_name` AS `event_name`, `sch`.`title` AS `title`, `sch`.`description` AS `description`, `sch`.`start_time` AS `start_time`, `sch`.`end_time` AS `end_time`, `r`.`room_name` AS `room_name`, `v`.`venue_name` AS `venue_name`, `t`.`track_name` AS `track_name`, `sch`.`session_type` AS `session_type`, (select group_concat(`speakers`.`full_name` separator ', ') from (`speakers` join `session_speakers` on((`speakers`.`speaker_id` = `session_speakers`.`speaker_id`))) where (`session_speakers`.`schedule_id` = `sch`.`schedule_id`)) AS `speakers_list` FROM ((((`schedule` `sch` join `events` `e` on((`sch`.`event_id` = `e`.`event_id`))) left join `rooms` `r` on((`sch`.`room_id` = `r`.`room_id`))) left join `venues` `v` on((`r`.`venue_id` = `v`.`venue_id`))) left join `tracks` `t` on((`sch`.`track_id` = `t`.`track_id`))) ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
