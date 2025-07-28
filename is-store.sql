-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 28, 2025 at 02:22 PM
-- Server version: 8.0.33
-- PHP Version: 8.3.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `is-store`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint UNSIGNED NOT NULL,
  `creator_id` bigint UNSIGNED DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `creator_id`, `slug`, `title`, `created_at`, `updated_at`) VALUES
(1, 1, 'iphone', 'iPhone', '2025-07-25 09:46:23', '2025-07-25 09:46:23'),
(2, 1, 'macbook-air', 'MacBook Air', '2025-07-25 10:00:54', '2025-07-25 10:00:54'),
(3, 1, 'macbook-pro', 'MacBook Pro', '2025-07-25 10:08:55', '2025-07-25 10:08:55'),
(4, 1, 'imac', 'iMac', '2025-07-25 10:16:13', '2025-07-25 10:16:13'),
(5, 1, 'mac-mini', 'Mac mini', '2025-07-25 10:18:36', '2025-07-25 10:18:36'),
(6, 1, 'watch', 'Watch', '2025-07-25 10:26:23', '2025-07-25 10:26:23');

-- --------------------------------------------------------

--
-- Table structure for table `change_logs`
--

CREATE TABLE `change_logs` (
  `id` bigint UNSIGNED NOT NULL,
  `creator_id` bigint UNSIGNED NOT NULL,
  `changeable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `changeable_id` bigint UNSIGNED NOT NULL,
  `change` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2024_02_05_161810_create_change_logs_table', 1),
(5, '2025_07_24_095036_create_categories_table', 1),
(6, '2025_07_24_095133_create_products_table', 1),
(7, '2025_07_25_093457_create_orders_table', 1),
(8, '2025_07_25_094051_create_order_products_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint UNSIGNED NOT NULL,
  `status` enum('1','2','3','4','5') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `additional_requirements` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `delivery_address` text COLLATE utf8mb4_unicode_ci,
  `delivery_date` date DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_price` decimal(8,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_products`
--

CREATE TABLE `order_products` (
  `id` bigint UNSIGNED NOT NULL,
  `order_id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `quantity` int NOT NULL DEFAULT '1',
  `price` decimal(8,2) DEFAULT NULL
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
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint UNSIGNED NOT NULL,
  `creator_id` bigint UNSIGNED DEFAULT NULL,
  `category_id` bigint UNSIGNED DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `price` decimal(8,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `creator_id`, `category_id`, `image`, `slug`, `title`, `description`, `price`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 1, 'nqdajOY8MIMW0uKSxpxGZ8nkacQIEq3v5c9C8tdX.webp', 'iphone-16-pro', 'iPhone 16 Pro', 'White, 128GB', 2199.98, '2025-07-25 09:41:59', '2025-07-25 09:46:30', NULL),
(2, 1, 1, 'eNoHyXsjU3xHDnUWLHYSQYHcdHHanisXG38wNbr5.webp', 'iphone-16e', 'iPhone 16e', 'White, 128GB', 1269.00, '2025-07-25 09:47:34', '2025-07-25 09:47:34', NULL),
(3, 1, 1, 'AtKBeJ5mtJi0z7itf6kc2sRPscgx3SfGIfX4LbNC.webp', 'iphone-16', 'iPhone 16', 'Ultramarine, 128GB', 1699.00, '2025-07-25 09:49:16', '2025-07-25 09:49:16', NULL),
(4, 1, 1, 'HLqeGRhgaFeqAZjC9h01khgyoLFbebsoW8bVIMsv.webp', 'iphone-15-pro-max', 'iPhone 15 Pro Max', 'Black Titanium, 512GB', 2749.00, '2025-07-25 09:50:13', '2025-07-25 09:50:13', NULL),
(5, 1, 1, 'nDmB1dR1yKEYUVbW5g4kJLZAxMo00zWt6Pa3HiIF.webp', 'iphone-16-pro-max', 'iPhone 16 Pro Max', 'Natural Titanium, 256GB', 2749.00, '2025-07-25 09:52:06', '2025-07-25 09:52:06', NULL),
(6, 1, 1, 'UGvdXNngovsHrxwpNiNwcNn1H4oKcXAo4XVEFVn5.webp', 'iphone-15', 'iPhone 15', 'Pink, 128GB', 1499.00, '2025-07-25 09:54:21', '2025-07-25 11:13:09', NULL),
(7, 1, 1, 'aC5iTXSVZnPaWEsaHwXXJ7hJ4txSiRdbTSmQTKgF.webp', 'iphone-15-plus', 'iPhone 15 Plus', 'Yellow, 128GB', 1739.00, '2025-07-25 09:55:21', '2025-07-25 09:55:21', NULL),
(8, 1, 1, 'IZEWgbKxupoAN6IKZYJHoTtL7xT0uddElKL9wnbf.webp', 'iphone-14', 'iPhone 14', 'Purple, 128GB', 1299.00, '2025-07-25 09:56:22', '2025-07-25 11:13:00', NULL),
(9, 1, 1, 'uIWTE3jijzVnes97CK8Z81TyCzJN2ryqzdtQoz1w.webp', 'iphone-14-pro-max', 'iPhone 14 Pro Max', 'Deep Purple, 256GB', 2599.00, '2025-07-25 09:57:13', '2025-07-25 09:57:13', NULL),
(10, 1, 1, 's3XE2Tsj7Gpdo43HNUyzE7FOyDCWKyH8mCltkMNJ.webp', 'iphone-13', 'iPhone 13', 'Midnight, 128GB', 1049.99, '2025-07-25 09:58:20', '2025-07-25 09:58:20', NULL),
(11, 1, 1, 'asIPkddhpona2bpygLgXlA7CIAqTeZh1M0OZHqkM.webp', 'iphone-12', 'iPhone 12', 'Black, 64GB', 839.99, '2025-07-25 09:59:37', '2025-07-25 09:59:37', NULL),
(12, 1, 2, '15AsUsn8xBZnB69rXQPjBDxaMZ3VYNnzAH8jmKuR.webp', 'macbook-air-15-inch-m4-chip', 'MacBook Air (15-inch) M4 chip', 'Midnight, 16GB, 256GB', 2959.00, '2025-07-25 10:02:37', '2025-07-25 10:02:37', NULL),
(13, 1, 2, 'juG1zwJHtezzu5qzuWUoioasEFd9kgeDsQ13zUfK.webp', 'macbook-air-13-inch-m4-chip', 'MacBook Air (13-inch) M4 chip', 'Midnight, 16GB, 256GB', 2389.99, '2025-07-25 10:03:42', '2025-07-25 10:03:42', NULL),
(14, 1, 2, 'Pk1WoXb4fY7qZXoLiZ4PKQ9dzLKqUYiG2bXwaIOn.webp', 'macbook-air-15-inch-m3-chip', 'MacBook Air (15-inch) M3 chip', 'Starlight, 8GB, 256GB', 2399.00, '2025-07-25 10:04:47', '2025-07-25 10:04:47', NULL),
(15, 1, 2, 'raLy3femYw455vxSdi5AAqLchRnTEluwzQrWoxar.webp', 'macbook-air-13-inch-m3-chip', 'MacBook Air (13-inch) M3 chip', 'Space Grey, 24GB, 512GB', 3099.00, '2025-07-25 10:05:59', '2025-07-25 10:05:59', NULL),
(16, 1, 2, 'YpDj3JCiGFiGYwO3KaSnSWvrDlICg0oT6QMlXN1o.webp', 'macbook-air-13-inch-m2-chip', 'MacBook Air (13-inch) M2 chip', 'Midnight, 16GB, 256GB', 1999.00, '2025-07-25 10:07:13', '2025-07-25 10:07:13', NULL),
(17, 1, 2, 'rwIOoQ3YX1m3Ktx1NgDyDFYDofJF946LbbCNFVI4.webp', 'macbook-air-13-inch-m1-chip', 'MacBook Air (13-inch) M1 chip', 'Space Grey, 8GB, 256GB', 1649.00, '2025-07-25 10:08:05', '2025-07-25 10:08:05', NULL),
(18, 1, 3, 'Yc14E7NeTNixbeaiwmHZFMF6MumOrT5WFQZ2HX6F.webp', 'macbook-pro-16-inch-m4-max', 'MacBook Pro (16-inch) M4 Max', 'Silver, 36GB, 1TB', 8269.00, '2025-07-25 10:10:18', '2025-07-25 10:10:18', NULL),
(19, 1, 3, '3UXHNHhfgyeesuBDMKDZIPOxoSS19pyCSKv60Jyz.webp', 'macbook-pro-16-inch-m4-pro', 'MacBook Pro (16-inch) M4 Pro', 'Silver, 48GB, 512GB', 6799.00, '2025-07-25 10:11:21', '2025-07-25 10:11:21', NULL),
(20, 1, 3, 'DJwmp4JE7hXT5155LXaXT1x1LOrCmTWxbxbyCYwy.webp', 'macbook-pro-14-inch-m4-max', 'MacBook Pro (14-inch) M4 Max', 'Silver, 36GB, 1TB', 7699.00, '2025-07-25 10:12:47', '2025-07-25 10:12:47', NULL),
(21, 1, 3, 'EuBeLdLNhblv8T9dfviEOrGTJJ6tm2lTSxEbVmrU.webp', 'macbook-pro-14-inch-m4-pro', 'MacBook Pro (14-inch) M4 Pro', 'Silver, 24GB, 512GB', 4899.00, '2025-07-25 10:13:40', '2025-07-25 10:13:40', NULL),
(22, 1, 3, 'gSEGkreY4mBt0P6jEkqugkXw0JUtNAUxcmIp3umK.webp', 'macbook-pro-14-inch-m4-chip', 'MacBook Pro (14-inch) M4 chip', 'Silver, 24GB, 1TB', 4749.00, '2025-07-25 10:14:51', '2025-07-25 10:14:51', NULL),
(23, 1, 3, 'oPQTNtcWQeoyZyZzorhudOuK7o5Txa78O4Czpbo5.webp', 'macbook-pro-14-inch-m1-pro', 'MacBook Pro (14-inch) M1 Pro', 'Space Grey, 64GB, 1TB', 8294.00, '2025-07-25 10:15:41', '2025-07-25 10:15:41', NULL),
(24, 1, 4, 'FDBjpdyUjz4vTqjiRrmVvhuzdra048vAO6ch3Qv5.webp', 'imac-24-inch-m4-chip', 'iMac (24-inch) M4 chip', 'Blue, 16GB, 256GB', 3499.00, '2025-07-25 10:17:05', '2025-07-25 10:17:05', NULL),
(25, 1, 4, 'FatoAo9gRdLLgssaUJ7pxOePYnTG70NYg2l8H4Gp.webp', 'imac-24-inch-m1-chip', 'iMac (24-inch) M1 chip', 'Pink, 8GB, 512GB', 3299.00, '2025-07-25 10:18:07', '2025-07-25 10:18:07', NULL),
(26, 1, 5, 'BQKaieJoR4t7jOvxroXMGHJkwtpna0RYdevpeBlN.webp', 'mac-mini-m4-pro', 'Mac mini M4 Pro', 'Silver, 24GB, 512GB', 3299.00, '2025-07-25 10:19:30', '2025-07-25 10:19:30', NULL),
(27, 1, 5, 'q1631fAtaOToMxB6NC60vkuSclhzkw3D8ppL7nUO.webp', 'mac-mini-m4', 'Mac mini M4', 'Silver, 16GB, 256GB', 1439.99, '2025-07-25 10:20:31', '2025-07-25 10:20:31', NULL),
(28, 1, 5, '54u3v3G8tDtZrOeIrJRCrHsPCOOml8eykgB2Dk5U.webp', 'mac-mini-m2', 'Mac mini M2', 'Silver, 8GB, 512GB', 1939.00, '2025-07-25 10:21:19', '2025-07-25 10:21:19', NULL),
(29, 1, 6, 'KkhzoH1ZcNgW2gYodyBGvTWgzqRaPAaWfTo2mrXu.webp', 'apple-watch-series-10-sport-band', 'Apple Watch Series 10 Sport Band', 'Jet Black', 1149.00, '2025-07-25 10:27:00', '2025-07-25 10:27:00', NULL),
(30, 1, 6, 'EJ2fzcmii7ipKVGlJLFXInN9bYm1ODDbWQ0THQL5.webp', '2024-apple-watch-se-sport-band', '2024 Apple Watch SE Sport Band', 'Midnight', 469.99, '2025-07-25 10:27:43', '2025-07-25 10:27:43', NULL),
(31, 1, 6, 'tVaAHvgJLdpn2eB3fpCVAqYpqZN8AC05YZA3vZ2g.webp', '2024-apple-watch-ultra-2-ocean-band', '2024 Apple Watch Ultra 2 Ocean Band', 'Black', 1719.00, '2025-07-25 10:28:10', '2025-07-25 10:28:10', NULL),
(32, 1, 6, 'tpNKfESQCwITLv6tBZ7l1mcdKGFJKJufTm4khveb.webp', 'apple-watch-series-9-sport-loop', 'Apple Watch Series 9 Sport Loop', 'Midnight', 739.99, '2025-07-25 10:28:47', '2025-07-25 10:28:47', NULL),
(33, 1, 6, 'eYt3DIMrDCAWduKE3FTdnfFJY1L4fFfjgh3i4JBp.webp', 'apple-watch-series-8', 'Apple Watch Series 8', 'Silver', 1099.01, '2025-07-25 10:29:18', '2025-07-25 10:29:18', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Test User', 'test@example.com', '2025-07-28 08:21:31', '$2y$12$9jXQNXjQMhXO.CxqFDGcqut8bAuk92TbZyI8v2VYAuoDhBhdJ3lqK', '0UJjpvu31r', '2025-07-28 08:21:32', '2025-07-28 08:21:32');

--
-- Indexes for dumped tables
--

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
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categories_creator_id_foreign` (`creator_id`);

--
-- Indexes for table `change_logs`
--
ALTER TABLE `change_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `change_logs_creator_id_foreign` (`creator_id`),
  ADD KEY `change_logs_changeable_type_changeable_id_index` (`changeable_type`,`changeable_id`);

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
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_products`
--
ALTER TABLE `order_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_products_order_id_foreign` (`order_id`),
  ADD KEY `order_products_product_id_foreign` (`product_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_creator_id_foreign` (`creator_id`),
  ADD KEY `products_category_id_foreign` (`category_id`);

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
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `change_logs`
--
ALTER TABLE `change_logs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_products`
--
ALTER TABLE `order_products`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_creator_id_foreign` FOREIGN KEY (`creator_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `change_logs`
--
ALTER TABLE `change_logs`
  ADD CONSTRAINT `change_logs_creator_id_foreign` FOREIGN KEY (`creator_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `order_products`
--
ALTER TABLE `order_products`
  ADD CONSTRAINT `order_products_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `order_products_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `products_creator_id_foreign` FOREIGN KEY (`creator_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
