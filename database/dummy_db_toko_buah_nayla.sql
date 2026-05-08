-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 08, 2026 at 03:08 AM
-- Server version: 8.0.30
-- PHP Version: 8.3.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `toko_buah_nayla`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `description`, `image`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Buah Segar', 'buah-segar', 'Aneka buah segar pilihan langsung dari kebun terbaik.', NULL, 1, '2026-05-04 19:32:26', '2026-05-04 19:32:26'),
(2, 'Es Buah', 'es-buah', 'Es buah segar dengan berbagai pilihan rasa yang menyegarkan.', NULL, 1, '2026-05-04 19:32:26', '2026-05-04 19:32:26'),
(3, 'Buah Import', 'buah-import', 'Buah-buahan pilihan dari mancanegara dengan kualitas premium.', NULL, 1, '2026-05-04 19:32:26', '2026-05-04 19:32:26'),
(4, 'Buah Potong', 'buah-potong', 'Buah segar yang sudah dipotong siap saji.', NULL, 1, '2026-05-04 19:32:26', '2026-05-04 19:32:26');

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
  `attempts` smallint UNSIGNED NOT NULL,
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
(4, '2026_05_05_000001_add_role_to_users_table', 1),
(5, '2026_05_05_000002_create_categories_table', 1),
(6, '2026_05_05_000003_create_products_table', 1),
(7, '2026_05_05_000004_create_orders_table', 1),
(8, '2026_05_05_000005_add_payment_method_to_orders_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `order_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `subtotal` decimal(12,2) NOT NULL DEFAULT '0.00',
  `total` decimal(12,2) NOT NULL DEFAULT '0.00',
  `status` enum('pending','processing','shipped','delivered','cancelled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `payment_status` enum('unpaid','paid') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'unpaid',
  `payment_method` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `order_number`, `customer_name`, `customer_phone`, `customer_address`, `notes`, `subtotal`, `total`, `status`, `payment_status`, `payment_method`, `created_at`, `updated_at`) VALUES
(1, 3, 'TBN-3EAWEBKD', 'Iqbal D. Istiqomah', '0895706896800', 'bumiayu', 'letakkan di depan pintu', '205000.00', '205000.00', 'processing', 'paid', NULL, '2026-05-04 19:36:23', '2026-05-04 19:40:25'),
(2, 3, 'TBN-PZVA6Y6X', 'Iqbal D. Istiqomah', '0895706896800', 'bumiayu', NULL, '20000.00', '20000.00', 'pending', 'unpaid', 'QRIS', '2026-05-04 19:48:22', '2026-05-04 19:48:22'),
(3, 3, 'TBN-BMGUVZOM', 'Iqbal D. Istiqomah', '0895706896800', 'Ambil di Toko', NULL, '33000.00', '33000.00', 'pending', 'unpaid', 'QRIS', '2026-05-04 19:56:18', '2026-05-04 19:56:18');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint UNSIGNED NOT NULL,
  `order_id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `product_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(12,2) NOT NULL,
  `quantity` int NOT NULL,
  `subtotal` decimal(12,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `product_name`, `price`, `quantity`, `subtotal`, `created_at`, `updated_at`) VALUES
(1, 1, 17, 'Durian Musang King', '150000.00', 1, '150000.00', '2026-05-04 19:36:23', '2026-05-04 19:36:23'),
(2, 1, 16, 'Apel Fuji Jepang', '55000.00', 1, '55000.00', '2026-05-04 19:36:23', '2026-05-04 19:36:23'),
(3, 2, 11, 'Es Buah Kelapa Muda', '20000.00', 1, '20000.00', '2026-05-04 19:48:22', '2026-05-04 19:48:22'),
(4, 3, 1, 'Mangga Harum Manis', '25000.00', 1, '25000.00', '2026-05-04 19:56:18', '2026-05-04 19:56:18'),
(5, 3, 2, 'Semangka Merah', '8000.00', 1, '8000.00', '2026-05-04 19:56:18', '2026-05-04 19:56:18');

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
  `category_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `price` decimal(12,2) NOT NULL,
  `unit` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'kg',
  `stock` int NOT NULL DEFAULT '0',
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `name`, `slug`, `description`, `price`, `unit`, `stock`, `image`, `is_featured`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 1, 'Mangga Harum Manis', 'mangga-harum-manis-288', 'Mangga harum manis pilihan, manis dan segar, cocok dikonsumsi langsung atau dijadikan jus.', '25000.00', 'kg', 49, NULL, 1, 1, '2026-05-04 19:32:26', '2026-05-04 19:56:18'),
(2, 1, 'Semangka Merah', 'semangka-merah-321', 'Semangka merah segar dengan kadar air tinggi, manis dan menyegarkan.', '8000.00', 'kg', 79, NULL, 1, 1, '2026-05-04 19:32:26', '2026-05-04 19:56:18'),
(3, 1, 'Melon Hijau', 'melon-hijau-873', 'Melon hijau dengan daging buah kuning manis dan aroma harum.', '12000.00', 'kg', 40, NULL, 0, 1, '2026-05-04 19:32:26', '2026-05-04 19:32:26'),
(4, 1, 'Pisang Ambon', 'pisang-ambon-440', 'Pisang ambon manis segar, cocok untuk camilan sehari-hari.', '18000.00', 'sisir', 30, NULL, 0, 1, '2026-05-04 19:32:26', '2026-05-04 19:32:26'),
(5, 1, 'Pepaya California', 'pepaya-california-486', 'Pepaya california dengan daging tebal berwarna oranye cerah, manis dan bernutrisi.', '10000.00', 'kg', 60, NULL, 1, 1, '2026-05-04 19:32:26', '2026-05-04 19:32:26'),
(6, 1, 'Jeruk Manis', 'jeruk-manis-425', 'Jeruk manis segar kaya vitamin C, cocok dijadikan jus atau dimakan langsung.', '22000.00', 'kg', 45, NULL, 0, 1, '2026-05-04 19:32:26', '2026-05-04 19:32:26'),
(7, 1, 'Alpukat Mentega', 'alpukat-mentega-468', 'Alpukat mentega dengan tekstur lembut dan creamy, sempurna untuk jus atau salad.', '30000.00', 'kg', 25, NULL, 1, 1, '2026-05-04 19:32:26', '2026-05-04 19:32:26'),
(8, 1, 'Jambu Biji Merah', 'jambu-biji-merah-928', 'Jambu biji merah segar, kaya vitamin C dan antioksidan.', '15000.00', 'kg', 35, NULL, 0, 1, '2026-05-04 19:32:26', '2026-05-04 19:32:26'),
(9, 2, 'Es Buah Spesial Nayla', 'es-buah-spesial-nayla-608', 'Es buah spesial andalan Toko Nayla dengan campuran 10 buah segar pilihan, santan, dan sirup cocopandan.', '15000.00', 'porsi', 100, NULL, 1, 1, '2026-05-04 19:32:26', '2026-05-04 19:32:26'),
(10, 2, 'Es Buah Susu', 'es-buah-susu-418', 'Es buah dengan tambahan susu kental manis, segar dan creamy di setiap suapannya.', '18000.00', 'porsi', 80, NULL, 1, 1, '2026-05-04 19:32:26', '2026-05-04 19:32:26'),
(11, 2, 'Es Buah Kelapa Muda', 'es-buah-kelapa-muda-905', 'Es buah dengan air kelapa muda alami dan daging kelapa muda yang lembut.', '20000.00', 'porsi', 59, NULL, 0, 1, '2026-05-04 19:32:26', '2026-05-04 19:48:22'),
(12, 2, 'Es Buah Diet', 'es-buah-diet-223', 'Es buah rendah kalori tanpa gula tambahan, menggunakan pemanis alami stevia.', '16000.00', 'porsi', 50, NULL, 0, 1, '2026-05-04 19:32:26', '2026-05-04 19:32:26'),
(13, 2, 'Es Buah Nata de Coco', 'es-buah-nata-de-coco-933', 'Es buah dengan tambahan nata de coco kenyal dan segar, paduan rasa yang sempurna.', '17000.00', 'porsi', 70, NULL, 1, 1, '2026-05-04 19:32:26', '2026-05-04 19:32:26'),
(14, 3, 'Anggur Shine Muscat', 'anggur-shine-muscat-315', 'Anggur shine muscat import premium dari Jepang, manis tanpa biji dengan aroma muscat yang khas.', '75000.00', 'kg', 20, NULL, 1, 1, '2026-05-04 19:32:26', '2026-05-04 19:32:26'),
(15, 3, 'Strawberry Australia', 'strawberry-australia-594', 'Strawberry segar dari Australia, merah cerah, manis asam menyegarkan.', '45000.00', 'box', 30, NULL, 1, 1, '2026-05-04 19:32:26', '2026-05-04 19:32:26'),
(16, 3, 'Apel Fuji Jepang', 'apel-fuji-jepang-452', 'Apel fuji dari Jepang dengan tekstur renyah dan rasa manis yang khas.', '55000.00', 'kg', 24, NULL, 0, 1, '2026-05-04 19:32:26', '2026-05-04 19:36:23'),
(17, 3, 'Durian Musang King', 'durian-musang-king-758', 'Raja durian dari Malaysia, daging tebal creamy dengan rasa pahit manis yang ikonik.', '150000.00', 'kg', 14, NULL, 1, 1, '2026-05-04 19:32:26', '2026-05-04 19:36:23'),
(18, 3, 'Kiwi Selandia Baru', 'kiwi-selandia-baru-329', 'Kiwi hijau segar dari Selandia Baru, kaya vitamin C dan antioksidan tinggi.', '40000.00', 'kg', 35, NULL, 0, 1, '2026-05-04 19:32:26', '2026-05-04 19:32:26'),
(19, 4, 'Rujak Buah Segar', 'rujak-buah-segar-599', 'Aneka buah segar yang dipotong dan disajikan dengan bumbu rujak pedas manis khas Nayla.', '12000.00', 'porsi', 50, NULL, 0, 1, '2026-05-04 19:32:26', '2026-05-04 19:32:26'),
(20, 4, 'Buah Potong Campur', 'buah-potong-campur-701', 'Buah potong campur dalam box praktis, cocok untuk bekal atau camilan sehat.', '15000.00', 'box', 40, NULL, 1, 1, '2026-05-04 19:32:26', '2026-05-04 19:32:26'),
(21, 4, 'Mangga Potong Pedas', 'mangga-potong-pedas-793', 'Mangga muda segar dipotong tipis dan dilumuri bumbu pedas asam khas.', '10000.00', 'porsi', 60, NULL, 0, 1, '2026-05-04 19:32:26', '2026-05-04 19:32:26'),
(22, 4, 'Semangka Potong', 'semangka-potong-301', 'Semangka merah segar dipotong segitiga siap makan, menyegarkan.', '8000.00', 'porsi', 70, NULL, 0, 1, '2026-05-04 19:32:26', '2026-05-04 19:32:26');

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

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('GeHoW6fn19lbwWx16DUFN35vJfFftCsfx5zTwzKm', 3, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:150.0) Gecko/20100101 Firefox/150.0', 'eyJfdG9rZW4iOiJxRVZJbXQxaWwwRXladExSQ2k3V0JGNjUwTENSa2g1cUFvN1VZWG81IiwiX2ZsYXNoIjp7Im5ldyI6W10sIm9sZCI6W119LCJfcHJldmlvdXMiOnsidXJsIjoiaHR0cDpcL1wvMTI3LjAuMC4xOjgwMDAiLCJyb3V0ZSI6ImhvbWUifSwibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiOjN9', 1777950974),
('IgCb8vajOUmhBabMHmOzwskuHBjjBO0i7fPQHkoQ', 3, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:150.0) Gecko/20100101 Firefox/150.0', 'eyJfdG9rZW4iOiJ6UnZBREdIcUxTTHVSSkhJeHZGYUdBU1ZkYmN4eWUwajVKSVRnY09KIiwibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiOjMsIl9wcmV2aW91cyI6eyJ1cmwiOiJodHRwOlwvXC8xMjcuMC4wLjE6ODAwMCIsInJvdXRlIjoiaG9tZSJ9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19', 1778209569);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `role`, `phone`, `address`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin Nayla', 'admin@nayla.com', 'admin', '081234567890', NULL, NULL, '$2y$12$RejDny.DbJ/QNH2y2honrO4i8DCAImkoehawpySdQaeD1/.TRBKh.', '7szEyKeu5kJEg6EemRzIPebbZDfy6ErMDFEx7HEJ7NpupmuIrVO8SYfbJF9T', '2026-05-04 19:32:26', '2026-05-04 19:32:26'),
(2, 'Pelanggan Demo', 'user@nayla.com', 'user', '089876543210', NULL, NULL, '$2y$12$P1qmKt4/ShL/MuGhpMcGCuqimtQP/zzfT21mODbFgyytSXa91Ygiq', NULL, '2026-05-04 19:32:26', '2026-05-04 19:32:26'),
(3, 'Iqbal D. Istiqomah', 'customer1@example.com', 'user', '0895706896800', NULL, NULL, '$2y$12$ypKTt4h4xquLlz58qclH6e3VjMdgzTpXOZpTzOZqfbCgvO6ZvJFru', 'wxTcJgSchM9HUCLeSOD0Lhd10eZ6F1pI97O4sub54WcAb8vpsXc2IvuWIh72', '2026-05-04 19:35:33', '2026-05-04 19:35:33');

--
-- Indexes for dumped tables
--

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
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_slug_unique` (`slug`);

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
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `orders_order_number_unique` (`order_number`),
  ADD KEY `orders_user_id_foreign` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_order_id_foreign` (`order_id`),
  ADD KEY `order_items_product_id_foreign` (`product_id`);

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
  ADD UNIQUE KEY `products_slug_unique` (`slug`),
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
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
