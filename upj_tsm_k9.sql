-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 11, 2025 at 04:13 AM
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
-- Database: `upj_tsm_k9`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `vehicle_type` enum('matic','bebek','cup','sport') NOT NULL,
  `plate_number` varchar(255) NOT NULL,
  `booking_date` datetime NOT NULL,
  `queue_number` int(11) DEFAULT NULL,
  `quota` int(11) NOT NULL DEFAULT 1,
  `service_id` bigint(20) UNSIGNED NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `customer_whatsapp` varchar(255) NOT NULL,
  `status` enum('pending','approved','on_progress','done','cancelled') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `user_id`, `vehicle_type`, `plate_number`, `booking_date`, `queue_number`, `quota`, `service_id`, `customer_name`, `customer_whatsapp`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'matic', 'N 1234 AB', '2025-09-30 10:55:00', 1, 1, 1, 'Danny', '085123456789', 'done', '2025-09-30 03:56:27', '2025-09-30 16:47:49'),
(2, 2, 'sport', 'N 5678 AB', '2025-09-30 12:00:00', 2, 1, 2, 'Arga', '08987654321', 'done', '2025-09-30 04:00:25', '2025-09-30 16:47:46'),
(8, 1, 'bebek', 'N 8899 AB', '2025-09-30 13:58:00', 3, 1, 5, 'Danny', '085123456789', 'done', '2025-09-30 06:59:12', '2025-09-30 16:47:43'),
(9, 1, 'cup', 'N 7755 BY', '2025-09-30 23:00:00', 4, 1, 6, 'Danny', '085123456789', 'approved', '2025-09-30 07:07:11', '2025-09-30 08:13:11'),
(10, 1, 'sport', 'N 8899 GG', '2025-10-01 08:00:00', 1, 1, 6, 'Danny', '085123456789', 'approved', '2025-09-30 07:31:16', '2025-09-30 08:13:05'),
(11, 1, 'cup', 'N 3344 NN', '2025-10-01 08:00:00', 2, 1, 1, 'Danny', '085123456789', 'pending', '2025-09-30 13:39:00', '2025-09-30 13:39:00'),
(12, 1, 'sport', 'N 5566 UY', '2025-10-01 20:39:00', 3, 1, 3, 'Danny', '085123456789', 'pending', '2025-09-30 13:39:54', '2025-09-30 13:39:54'),
(13, 1, 'sport', 'N 7744 HG', '2025-10-01 00:50:00', 4, 1, 12, 'Danny', '085123456789', 'done', '2025-09-30 13:40:55', '2025-10-01 02:34:45'),
(14, 1, 'bebek', 'N 7766 BU', '2025-10-01 08:55:00', 5, 1, 8, 'Danny', '085123456789', 'pending', '2025-09-30 15:51:40', '2025-09-30 15:51:40'),
(15, 1, 'cup', 'N 5585 HH', '2025-09-30 23:00:00', 5, 1, 1, 'Danny', '085123456789', 'pending', '2025-09-30 15:58:29', '2025-09-30 15:58:29'),
(16, 1, 'bebek', 'N 8844 UY', '2025-10-02 09:40:00', 1, 1, 12, 'Danny', '0875699335', 'pending', '2025-10-01 02:42:52', '2025-10-01 02:42:52'),
(17, 1, 'bebek', 'N 7754 AW', '2025-10-07 10:42:00', 1, 1, 1, 'Danny', '085865245388', 'pending', '2025-10-06 13:43:51', '2025-10-06 13:43:51');

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
(4, '2025_09_15_063618_create_services_table', 1),
(5, '2025_09_15_063656_create_bookings_table', 1),
(6, '2025_09_15_133241_create_service_advisors_table', 1),
(7, '2025_09_16_063545_create_personal_access_tokens_table', 1),
(8, '2025_09_30_214202_add_role_to_users_table', 2);

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
  `name` text NOT NULL,
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
(2, 'App\\Models\\User', 2, 'mobile', '41e8c44e526ce3a1924a250b4508e09c8987c93b3567ba20bcc154579ecd01f6', '[\"*\"]', '2025-09-30 04:35:17', NULL, '2025-09-30 04:16:16', '2025-09-30 04:35:17'),
(17, 'App\\Models\\User', 1, 'mobile', 'f4b2e56f1b1540c7fa32883e61907e36161cb9039367c28689f3f089859cbca8', '[\"*\"]', '2025-09-30 15:43:02', NULL, '2025-09-30 14:12:55', '2025-09-30 15:43:02'),
(18, 'App\\Models\\User', 1, 'authToken', '3acd5609cfc3b8628fdb2afb9b34bc5985cd28c0be8f187ecaccaa14d4467016', '[\"customer-access\"]', '2025-10-01 02:37:09', NULL, '2025-09-30 15:44:40', '2025-10-01 02:37:09'),
(19, 'App\\Models\\User', 1, 'authToken', '37b102ad1f418eb89e0bded7b2313c79c69b093dee0cfea51e31463ec7886be5', '[\"customer-access\"]', '2025-10-07 06:02:08', NULL, '2025-10-01 02:39:48', '2025-10-07 06:02:08');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` enum('paket','non_paket') NOT NULL,
  `price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `name`, `type`, `price`, `created_at`, `updated_at`) VALUES
(1, 'Service Lengkap', 'paket', 70000.00, '2025-09-30 03:49:56', '2025-09-30 03:49:56'),
(2, 'Service Ringan', 'paket', 40000.00, '2025-09-30 03:49:56', '2025-09-30 03:49:56'),
(3, 'Ganti Oli Plus', 'paket', 25000.00, '2025-09-30 03:49:56', '2025-09-30 03:49:56'),
(4, 'Pembersihan CVT', 'non_paket', 40000.00, '2025-09-30 03:49:56', '2025-09-30 03:49:56'),
(5, 'Kuras Tangki', 'non_paket', 50000.00, '2025-09-30 03:49:56', '2025-09-30 03:49:56'),
(6, 'Ganti Ban', 'non_paket', 30000.00, '2025-09-30 03:49:56', '2025-09-30 03:49:56'),
(7, 'Ganti Gear Set', 'non_paket', 20000.00, '2025-09-30 03:49:56', '2025-09-30 03:49:56'),
(8, 'Ganti Kampas Rem Belakang', 'non_paket', 25000.00, '2025-09-30 03:49:56', '2025-09-30 03:49:56'),
(9, 'Ganti Filter Udara', 'non_paket', 10000.00, '2025-09-30 03:49:56', '2025-09-30 03:49:56'),
(10, 'Ganti Aki', 'non_paket', 13000.00, '2025-09-30 03:49:56', '2025-09-30 03:49:56'),
(11, 'Ganti Kabel Speedo', 'non_paket', 20000.00, '2025-09-30 03:49:56', '2025-09-30 03:49:56'),
(12, 'Cuci Sepeda', 'paket', 12000.00, '2025-09-30 03:49:56', '2025-09-30 03:49:56');

-- --------------------------------------------------------

--
-- Table structure for table `service_advisors`
--

CREATE TABLE `service_advisors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `booking_id` bigint(20) UNSIGNED NOT NULL,
  `jobs` varchar(255) DEFAULT NULL,
  `estimation_cost` decimal(12,2) NOT NULL DEFAULT 0.00,
  `spareparts` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`spareparts`)),
  `estimation_parts` decimal(12,2) NOT NULL DEFAULT 0.00,
  `total_estimation` decimal(12,2) NOT NULL DEFAULT 0.00,
  `customer_complaint` text DEFAULT NULL,
  `advisor_notes` text DEFAULT NULL,
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

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('NJ6v93mn3Ma0PMAQiiz8sMt3QFAinZ723R65oAHz', 3, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiaWJmZ0dOWlJ0c1ZUcDJKN1I5WnpYYTRiYWRQQTJEMjVpNUtHVk02TyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Nzc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9jdXN0b21lcnMvMDg5ODc2NTQzMjEvYm9va2luZ3M/ZW1haWw9YXJnYSU0MGV4YW1wbGUuY29tIjt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6Mzt9', 1759252753),
('soEoNC3IzHa2D0m7r4EJ0Vtc9d23aTMdnMunV1U4', 3, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiSGQxS0RVZkVpbVJFc1Y4cjV1WFN4WDBqTWlmZU53RHlIZWtQWURFSyI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjI5OiJodHRwOi8vbG9jYWxob3N0OjgwMDAvYm9va2luZyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjM7fQ==', 1759816875),
('xNN4n0mvJvVSQXtFujlnZdfwuucM1UrwVXGcZ7ov', 3, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiS0l0bHBLOUdlVGpNUXEyR0VVVXhFdkk1N3FESVBzbnhEOXBYbTMwcSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzY6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZHZpc29yL2NyZWF0ZSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjM7fQ==', 1759286100);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'customer',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Danny', 'danny@example.com', 'customer', NULL, '$2y$12$X7DlYtZGC7yeJHvz5vAeQOaxOHyqWTkeyKR/wwBrJqugVnwK69lPy', 'oYb7bMqKaDp0ydbJBwOS1RwGhU46jDOCbNqMrmm9mpBgJyeTO5G09KCcuMIc', '2025-09-30 03:50:39', '2025-09-30 03:50:39'),
(2, 'Arga', 'arga@example.com', 'customer', NULL, '$2y$12$4fl5uQS6vfYRdSArh/CHv.QxM9xm48QTcLFMV6GYMkPy0c31nuGD6', NULL, '2025-09-30 03:59:43', '2025-09-30 03:59:43'),
(3, 'admina', 'admin@example.com', 'admin', NULL, '$2y$12$gNSyR8nRIye7CoeciSEPwuXy3yy5aJyhIr7J/1zW3DRUq1Y5yODce', NULL, '2025-09-30 14:44:41', '2025-09-30 14:44:41');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bookings_user_id_foreign` (`user_id`),
  ADD KEY `bookings_service_id_foreign` (`service_id`);

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
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

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
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`),
  ADD KEY `personal_access_tokens_expires_at_index` (`expires_at`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `service_advisors`
--
ALTER TABLE `service_advisors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `service_advisors_booking_id_foreign` (`booking_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `service_advisors`
--
ALTER TABLE `service_advisors`
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
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bookings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `service_advisors`
--
ALTER TABLE `service_advisors`
  ADD CONSTRAINT `service_advisors_booking_id_foreign` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
