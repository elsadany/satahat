-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 29, 2021 at 03:55 PM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `satahat`
--

-- --------------------------------------------------------

--
-- Table structure for table `banners`
--

CREATE TABLE `banners` (
  `id` int(11) NOT NULL,
  `image` varchar(191) COLLATE utf8_general_mysql500_ci NOT NULL,
  `title_ar` varchar(191) COLLATE utf8_general_mysql500_ci NOT NULL,
  `title_en` varchar(191) COLLATE utf8_general_mysql500_ci NOT NULL,
  `description_ar` text COLLATE utf8_general_mysql500_ci,
  `description_en` text COLLATE utf8_general_mysql500_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_mysql500_ci;

--
-- Dumping data for table `banners`
--

INSERT INTO `banners` (`id`, `image`, `title_ar`, `title_en`, `description_ar`, `description_en`) VALUES
(2, 'uploads/banners/06-2021/1624972206bWTWzLm8tv8IvLR.png', 'تست', 'test', 'تست', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` int(11) NOT NULL,
  `name_ar` varchar(20) COLLATE utf8_general_mysql500_ci NOT NULL,
  `name_en` varchar(20) COLLATE utf8_general_mysql500_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_mysql500_ci;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`id`, `name_ar`, `name_en`) VALUES
(1, 'بى ام دابليو', 'BMW');

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `id` int(11) NOT NULL,
  `name_en` varchar(50) COLLATE utf8_general_mysql500_ci NOT NULL,
  `name_ar` varchar(50) COLLATE utf8_general_mysql500_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_mysql500_ci;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`id`, `name_en`, `name_ar`) VALUES
(2, 'riad', 'ألرياض');

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `job_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_mysql500_ci;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`user_id`, `job_id`) VALUES
(2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `delivery`
--

CREATE TABLE `delivery` (
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `city_id` int(11) NOT NULL,
  `main_specialist_id` int(11) NOT NULL,
  `secondary_specialist_id` int(11) NOT NULL,
  `id_image` varchar(250) COLLATE utf8_general_mysql500_ci NOT NULL,
  `brand_id` int(11) NOT NULL,
  `model` int(11) NOT NULL,
  `car_number` varchar(30) COLLATE utf8_general_mysql500_ci NOT NULL,
  `driving_licence` varchar(250) COLLATE utf8_general_mysql500_ci NOT NULL,
  `insurance_number` varchar(20) COLLATE utf8_general_mysql500_ci NOT NULL,
  `authorize_image` varchar(191) COLLATE utf8_general_mysql500_ci DEFAULT NULL,
  `bank_name` varchar(50) COLLATE utf8_general_mysql500_ci NOT NULL,
  `iban_id` varchar(50) COLLATE utf8_general_mysql500_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_mysql500_ci;

--
-- Dumping data for table `delivery`
--

INSERT INTO `delivery` (`user_id`, `city_id`, `main_specialist_id`, `secondary_specialist_id`, `id_image`, `brand_id`, `model`, `car_number`, `driving_licence`, `insurance_number`, `authorize_image`, `bank_name`, `iban_id`) VALUES
(4, 2, 1, 1, 'uploads/users/1624903239hh3MhZn7bOISpjE.png', 1, 2019, '1234', 'uploads/users/1624903239bZcyYXz2HPMTmdm.png', '24444', NULL, 'الرياض', '123');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` int(11) NOT NULL,
  `name_ar` varchar(50) COLLATE utf8_general_mysql500_ci NOT NULL,
  `name_en` varchar(50) COLLATE utf8_general_mysql500_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_mysql500_ci;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`id`, `name_ar`, `name_en`) VALUES
(1, 'مهندس مدنى', 'civil engineer');

-- --------------------------------------------------------

--
-- Table structure for table `main_specialists`
--

CREATE TABLE `main_specialists` (
  `id` int(11) NOT NULL,
  `name_ar` varchar(50) COLLATE utf8_general_mysql500_ci NOT NULL,
  `name_en` varchar(50) COLLATE utf8_general_mysql500_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_mysql500_ci;

--
-- Dumping data for table `main_specialists`
--

INSERT INTO `main_specialists` (`id`, `name_ar`, `name_en`) VALUES
(1, 'سطحات', 'surfaces');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2016_06_01_000001_create_oauth_auth_codes_table', 1),
(2, '2016_06_01_000002_create_oauth_access_tokens_table', 1),
(3, '2016_06_01_000003_create_oauth_refresh_tokens_table', 1),
(4, '2016_06_01_000004_create_oauth_clients_table', 1),
(5, '2016_06_01_000005_create_oauth_personal_access_clients_table', 1),
(6, '2020_12_13_161507_create_users_table', 1),
(7, '2021_01_10_202422_add_column_to_users_table', 1),
(8, '2021_02_01_170530_add_remmember_token_to_users_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `notification` varchar(191) COLLATE utf8_general_mysql500_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `is_read` int(11) DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_mysql500_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_access_tokens`
--

CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_access_tokens`
--

INSERT INTO `oauth_access_tokens` (`id`, `user_id`, `client_id`, `name`, `scopes`, `revoked`, `created_at`, `updated_at`, `expires_at`) VALUES
('26849da43f16743d28ea79567fc76bcbe83603d95d9653063391d10955ad3b719b1940222e9db779', 5, 1, 'Personal Access Token', '[]', 0, '2021-06-29 11:06:38', '2021-06-29 11:06:38', '2022-06-29 13:06:38'),
('48140c0858f53eddae8bdb0abf584ab7adb0398e34a946d278cda93499e6e1c0f7708b045c8f7727', 2, 1, 'Personal Access Token', '[]', 0, '2021-06-28 15:42:11', '2021-06-28 15:42:11', '2022-06-28 17:42:11'),
('8e824a9584998e60fa1c77083b3d4c134928229cc9d4f095651dc61cf3b3af49652cd9cec9ebb71c', 4, 1, 'Personal Access Token', '[]', 0, '2021-06-29 10:52:23', '2021-06-29 10:52:23', '2022-06-29 12:52:23'),
('bf664fa6ceb4929dc47f149485bfc1a5a0bbbafb2a87247d3de0205f59955da9bcdcef3b5ed5fa66', 2, 1, 'Personal Access Token', '[]', 0, '2021-06-28 16:09:06', '2021-06-28 16:09:06', '2022-06-28 18:09:06'),
('c0ed26ee05f0d11b0d908bf2b04a11df7b1e7d3877ea9108294efcada567327b5754d277b984e14d', 2, 1, 'Personal Access Token', '[]', 0, '2021-06-28 15:46:17', '2021-06-28 15:46:17', '2022-06-28 17:46:17'),
('ef44ed2157b4cce02fc908766ee3341989391945aa1ee82a8e9f891196f9bf96b1d0b583a8db38e0', 4, 1, 'Personal Access Token', '[]', 0, '2021-06-28 16:00:39', '2021-06-28 16:00:39', '2021-07-12 18:00:39');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_auth_codes`
--

CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_clients`
--

CREATE TABLE `oauth_clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `secret` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provider` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `redirect` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_clients`
--

INSERT INTO `oauth_clients` (`id`, `user_id`, `name`, `secret`, `provider`, `redirect`, `personal_access_client`, `password_client`, `revoked`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Laravel Personal Access Client', 'Igg7bV6icqBfxvZFsmlW7bdMQieS9jHkEQY5yli5', NULL, 'http://localhost', 1, 0, 0, '2021-06-28 12:59:53', '2021-06-28 12:59:53'),
(2, NULL, 'Laravel Password Grant Client', 'eNCYUuqsfUvEnljStmf75kE6JtsrLJ7ftPNrOzQU', 'users', 'http://localhost', 0, 1, 0, '2021-06-28 12:59:53', '2021-06-28 12:59:53');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_personal_access_clients`
--

CREATE TABLE `oauth_personal_access_clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_personal_access_clients`
--

INSERT INTO `oauth_personal_access_clients` (`id`, `client_id`, `created_at`, `updated_at`) VALUES
(1, 1, '2021-06-28 12:59:53', '2021-06-28 12:59:53');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_refresh_tokens`
--

CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `offers`
--

CREATE TABLE `offers` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `delivery_id` int(11) NOT NULL,
  `offer` float(12,3) NOT NULL,
  `is_accept` tinyint(4) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_mysql500_ci;

--
-- Dumping data for table `offers`
--

INSERT INTO `offers` (`id`, `order_id`, `delivery_id`, `offer`, `is_accept`) VALUES
(1, 1, 4, 500.000, 1);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `delivery_id` int(11) DEFAULT NULL,
  `from_lat` varchar(20) COLLATE utf8_general_mysql500_ci NOT NULL,
  `from_lng` varchar(20) COLLATE utf8_general_mysql500_ci NOT NULL,
  `to_lat` varchar(30) COLLATE utf8_general_mysql500_ci NOT NULL,
  `to_lng` varchar(50) COLLATE utf8_general_mysql500_ci NOT NULL,
  `offer` float(12,3) DEFAULT NULL,
  `main_specialist_id` int(11) NOT NULL,
  `secondary_specialist_id` int(11) NOT NULL,
  `pay_method` varchar(50) COLLATE utf8_general_mysql500_ci DEFAULT NULL,
  `notes` text COLLATE utf8_general_mysql500_ci,
  `reason` varchar(191) COLLATE utf8_general_mysql500_ci DEFAULT NULL,
  `status_id` int(11) DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_mysql500_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `delivery_id`, `from_lat`, `from_lng`, `to_lat`, `to_lng`, `offer`, `main_specialist_id`, `secondary_specialist_id`, `pay_method`, `notes`, `reason`, `status_id`, `created_at`, `updated_at`) VALUES
(1, 2, 4, '34.33333', '33.3333', '33.33333', '33.333333', 500.000, 1, 1, 'كاش', NULL, NULL, 1, NULL, NULL),
(2, 2, NULL, '34.33333', '33.3333', '33.33333', '33.333333', NULL, 1, 1, 'كاش', NULL, NULL, 0, NULL, NULL),
(3, 2, NULL, '34.33333', '33.3333', '33.33333', '33.333333', NULL, 1, 1, 'كاش', NULL, 'test', 3, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `phone_codes`
--

CREATE TABLE `phone_codes` (
  `id` int(11) NOT NULL,
  `code` varchar(6) COLLATE utf8_general_mysql500_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8_general_mysql500_ci NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_mysql500_ci;

--
-- Dumping data for table `phone_codes`
--

INSERT INTO `phone_codes` (`id`, `code`, `phone`, `created_at`, `updated_at`) VALUES
(2, '5555', '01114591647', '2021-06-28 17:29:37', '2021-06-28 17:29:37'),
(3, '5555', '01114591647', '2021-06-28 17:30:16', '2021-06-28 17:30:16'),
(4, '5555', '01114591647', '2021-06-28 17:30:28', '2021-06-28 17:30:28');

-- --------------------------------------------------------

--
-- Table structure for table `secondary_specialists`
--

CREATE TABLE `secondary_specialists` (
  `id` int(11) NOT NULL,
  `name_ar` varchar(50) COLLATE utf8_general_mysql500_ci NOT NULL,
  `name_en` varchar(50) COLLATE utf8_general_mysql500_ci NOT NULL,
  `main_specialist_id` int(11) NOT NULL,
  `image` varchar(250) COLLATE utf8_general_mysql500_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_mysql500_ci;

--
-- Dumping data for table `secondary_specialists`
--

INSERT INTO `secondary_specialists` (`id`, `name_ar`, `name_en`, `main_specialist_id`, `image`) VALUES
(1, 'سطحه عاديه', 'original_surface', 1, 'uploads/fa393a34-93a5-4732-a4e5-213b648bf7e3_202104071425554101.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reset_password_token` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` int(11) NOT NULL DEFAULT '1',
  `device_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `password`, `created_at`, `updated_at`, `image`, `reset_password_token`, `remember_token`, `type`, `device_id`) VALUES
(2, 'test', 'eng.ahmedelsadany1@gmail.com', '01114591647', '$2y$10$j257la0S7s/XfQ0iQ2GwVOXJ//v8UUIUAlLLWSNmfvgirgiO2blci', '2021-06-28 15:42:11', '2021-06-29 11:18:16', 'uploads/users/1624972696flp6gIzbOTYFHiF.png', NULL, NULL, 1, '1234'),
(4, 'test', 'eng.ahmedelsadany2@gmail.com', '01114591641', '$2y$10$WpzarU3bnlaKCiaVZ84FfeHd.y/QGYNNK8XrxnxCwle9CJTpArJse', '2021-06-28 16:00:39', '2021-06-28 16:00:39', NULL, NULL, NULL, 2, NULL),
(5, 'test', 'admin@admin.com', '01114591641', '$2y$10$WpzarU3bnlaKCiaVZ84FfeHd.y/QGYNNK8XrxnxCwle9CJTpArJse', '2021-06-28 16:00:39', '2021-06-28 16:00:39', NULL, NULL, NULL, 4, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `banners`
--
ALTER TABLE `banners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD KEY `user_id` (`user_id`),
  ADD KEY `job_id` (`job_id`);

--
-- Indexes for table `delivery`
--
ALTER TABLE `delivery`
  ADD KEY `user_id` (`user_id`),
  ADD KEY `brand_id` (`brand_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `main_specialists`
--
ALTER TABLE `main_specialists`
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
-- Indexes for table `oauth_access_tokens`
--
ALTER TABLE `oauth_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_access_tokens_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_auth_codes`
--
ALTER TABLE `oauth_auth_codes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_auth_codes_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_clients_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_refresh_tokens`
--
ALTER TABLE `oauth_refresh_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`);

--
-- Indexes for table `offers`
--
ALTER TABLE `offers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `phone_codes`
--
ALTER TABLE `phone_codes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `secondary_specialists`
--
ALTER TABLE `secondary_specialists`
  ADD PRIMARY KEY (`id`),
  ADD KEY `main_specialist_id` (`main_specialist_id`);

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
-- AUTO_INCREMENT for table `banners`
--
ALTER TABLE `banners`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `main_specialists`
--
ALTER TABLE `main_specialists`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `offers`
--
ALTER TABLE `offers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `phone_codes`
--
ALTER TABLE `phone_codes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `secondary_specialists`
--
ALTER TABLE `secondary_specialists`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `clients`
--
ALTER TABLE `clients`
  ADD CONSTRAINT `clients_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `clients_ibfk_2` FOREIGN KEY (`job_id`) REFERENCES `jobs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `delivery`
--
ALTER TABLE `delivery`
  ADD CONSTRAINT `delivery_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `delivery_ibfk_2` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `secondary_specialists`
--
ALTER TABLE `secondary_specialists`
  ADD CONSTRAINT `secondary_specialists_ibfk_1` FOREIGN KEY (`main_specialist_id`) REFERENCES `main_specialists` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
