-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 24, 2025 at 12:25 PM
-- Server version: 8.0.30
-- PHP Version: 8.2.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sarpras-ukk`
--

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
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `id_item` bigint UNSIGNED NOT NULL,
  `nama_item` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stok` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id_item`, `nama_item`, `stok`, `created_at`, `updated_at`) VALUES
(1, 'ac besar', 0, '2025-09-17 00:14:01', '2025-09-18 08:23:29'),
(2, 'kipas', 0, '2025-09-18 08:18:37', '2025-09-18 08:18:37'),
(3, 'proyektor', 0, '2025-09-18 08:18:46', '2025-09-18 08:18:46'),
(4, 'papan tulis', 0, '2025-09-18 08:19:02', '2025-09-18 08:19:02'),
(5, 'LAN', 0, '2025-09-18 08:19:28', '2025-09-18 08:19:28'),
(6, 'meja siswa', 0, '2025-09-27 07:26:00', '2025-09-27 07:26:00');

-- --------------------------------------------------------

--
-- Table structure for table `list_lokasi`
--

CREATE TABLE `list_lokasi` (
  `id_list` bigint UNSIGNED NOT NULL,
  `id_lokasi` bigint UNSIGNED NOT NULL,
  `id_item` bigint UNSIGNED NOT NULL,
  `jumlah` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `list_lokasi`
--

INSERT INTO `list_lokasi` (`id_list`, `id_lokasi`, `id_item`, `jumlah`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 0, NULL, NULL),
(2, 1, 2, 0, NULL, NULL),
(3, 1, 3, 0, NULL, NULL),
(4, 2, 4, 0, NULL, NULL),
(5, 3, 1, 0, NULL, NULL),
(6, 3, 3, 0, NULL, NULL),
(7, 3, 4, 0, NULL, NULL),
(8, 3, 5, 0, NULL, NULL),
(9, 4, 1, 0, NULL, NULL),
(10, 4, 3, 0, NULL, NULL),
(11, 4, 4, 0, NULL, NULL),
(12, 4, 5, 0, NULL, NULL),
(13, 4, 6, 0, NULL, NULL),
(14, 2, 3, 0, '2025-10-23 20:00:30', '2025-10-23 20:00:30');

-- --------------------------------------------------------

--
-- Table structure for table `lokasi`
--

CREATE TABLE `lokasi` (
  `id_lokasi` bigint UNSIGNED NOT NULL,
  `nama_lokasi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lokasi`
--

INSERT INTO `lokasi` (`id_lokasi`, `nama_lokasi`, `created_at`, `updated_at`) VALUES
(1, 'lab 1', '2025-09-17 00:14:20', '2025-10-20 21:01:56'),
(2, 'lab ipas', '2025-09-18 08:19:48', '2025-09-18 08:19:48'),
(3, 'lab 18', '2025-09-18 08:19:55', '2025-09-18 08:19:55'),
(4, 'lab 1', '2025-09-27 07:25:39', '2025-09-27 07:25:39');

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
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2014_10_12_100000_create_password_resets_table', 1),
(4, '2019_08_19_000000_create_failed_jobs_table', 1),
(5, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(6, '2025_09_15_074745_add_google_fields_to_users_table', 1),
(7, '2025_09_16_014227_create_pengaduan_sarpras_tables', 1),
(8, '2025_09_21_080324_add_remember_token_to_users_table', 2),
(9, '2025_10_23_162958_add_id_lokasi_to_pengaduan_table', 3),
(10, '2025_10_24_004225_rename_lokasi_column_in_pengaduan_table', 4),
(11, '2025_10_24_011919_add_id_lokasi_to_pengaduan_table', 5);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
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

--
-- Dumping data for table `password_reset_tokens`
--

INSERT INTO `password_reset_tokens` (`email`, `token`, `created_at`) VALUES
('adminsegar@example.com', '$2y$12$ltoejBYE82iffSOd/11ooOIAjchmX1pkgIynTqaVi8rFVVlDhoL0K', '2025-10-23 07:49:14'),
('rafiibnugroho@gmail.com', '$2y$12$.XJPLvEZ2I9TtEe9dNajROFi/PghOKFW/.xDsZRCexqwHvx0e3Nhy', '2025-09-20 22:18:08');

-- --------------------------------------------------------

--
-- Table structure for table `pengaduan`
--

CREATE TABLE `pengaduan` (
  `id_pengaduan` bigint UNSIGNED NOT NULL,
  `nama_pengaduan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `lokasi_manual` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_lokasi` bigint UNSIGNED DEFAULT NULL,
  `foto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('Diajukan','Disetujui','Ditolak','Diproses','Selesai') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Diajukan',
  `id_user` bigint UNSIGNED NOT NULL,
  `id_petugas` bigint UNSIGNED DEFAULT NULL,
  `id_item` bigint UNSIGNED NOT NULL,
  `tgl_pengajuan` date DEFAULT NULL,
  `tgl_selesai` date DEFAULT NULL,
  `saran_petugas` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pengaduan`
--

INSERT INTO `pengaduan` (`id_pengaduan`, `nama_pengaduan`, `deskripsi`, `lokasi_manual`, `id_lokasi`, `foto`, `status`, `id_user`, `id_petugas`, `id_item`, `tgl_pengajuan`, `tgl_selesai`, `saran_petugas`, `created_at`, `updated_at`) VALUES
(14, 'papan patah', 'sss', NULL, 2, 'pengaduan/aCYTdwVEbzXnqoMgNoBJYpxKaG4L0AuTGDqA9ssE.png', 'Diajukan', 5, NULL, 4, '2025-10-24', NULL, NULL, '2025-10-23 18:35:22', '2025-10-24 01:12:24');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\User', 4, 'auth_token', '1e8575db84d35daa7460b0630222b947e24b33c616e96eed93468796d3fb2646', '[\"*\"]', NULL, NULL, '2025-09-17 19:30:14', '2025-09-17 19:30:14'),
(2, 'App\\Models\\User', 4, 'auth_token', '18792e8650d2e9a6a1cd43e20e5fa9dfd330e6944aaf873ca65cff7d0cb2cbad', '[\"*\"]', NULL, NULL, '2025-09-17 19:37:28', '2025-09-17 19:37:28'),
(3, 'App\\Models\\User', 4, 'auth_token', 'f8c1bd4cb7ef6cbebe6eecf12005bb260f7e09570165ff9c177011972d182ea2', '[\"*\"]', '2025-09-17 19:51:11', NULL, '2025-09-17 19:41:09', '2025-09-17 19:51:11'),
(4, 'App\\Models\\User', 4, 'auth_token', 'f96d225a4c5a10d22206036dee1f5682a07027bf65c353552be926c9b7f3fd20', '[\"*\"]', NULL, NULL, '2025-09-17 20:06:45', '2025-09-17 20:06:45'),
(5, 'App\\Models\\User', 4, 'auth_token', '19775905721c0afb09aa6f334ef114f2d68e9d3ce01eaf167f7c1b420af25064', '[\"*\"]', '2025-09-17 20:13:42', NULL, '2025-09-17 20:13:18', '2025-09-17 20:13:42'),
(6, 'App\\Models\\User', 4, 'auth_token', '6394cbf887c65801676db286d868ed31edbe6d0440342909f4e2740c654d1241', '[\"*\"]', '2025-09-17 21:14:40', NULL, '2025-09-17 21:09:03', '2025-09-17 21:14:40'),
(7, 'App\\Models\\User', 4, 'auth_token', '5da38e6b48d2d61c70181484488dec78c038d5611f9c1f5bd3c03399bbf9a030', '[\"*\"]', '2025-09-17 21:15:14', NULL, '2025-09-17 21:15:06', '2025-09-17 21:15:14'),
(8, 'App\\Models\\User', 4, 'auth_token', 'db0d5d44207e1128c9b02d9c922fcab4a7da2f84cb7570978f90900791a10f05', '[\"*\"]', '2025-09-17 21:28:32', NULL, '2025-09-17 21:28:22', '2025-09-17 21:28:32'),
(9, 'App\\Models\\User', 4, 'auth_token', '436362be52c3937d8b77fc9be7c4e3ca309e68499e2f5a0ec74c09ca3766773a', '[\"*\"]', '2025-09-17 22:17:02', NULL, '2025-09-17 22:16:23', '2025-09-17 22:17:02'),
(10, 'App\\Models\\User', 4, 'auth_token', '5c7f67ab7f2ff16733f2ff094ca7b2a3dfd9304c09bf9d17fa0191eca583cd9d', '[\"*\"]', '2025-09-17 22:39:12', NULL, '2025-09-17 22:38:16', '2025-09-17 22:39:12'),
(11, 'App\\Models\\User', 4, 'auth_token', '19d5fb6177fa44135cd66009904b904e207119e49602c7f5b3e283c0042afbff', '[\"*\"]', '2025-09-17 22:42:13', NULL, '2025-09-17 22:41:15', '2025-09-17 22:42:13'),
(12, 'App\\Models\\User', 4, 'auth_token', 'ffed82bc82361870f6291c7ba58efbdba4661dc5f3e5660e3b3a95a245c7543b', '[\"*\"]', '2025-09-17 22:46:31', NULL, '2025-09-17 22:46:09', '2025-09-17 22:46:31'),
(13, 'App\\Models\\User', 4, 'auth_token', '29a8f29dea7ad4094caedbfcf74103477802af5dc259e0c5b6cf44da1b8d4b7d', '[\"*\"]', '2025-09-17 23:12:43', NULL, '2025-09-17 23:12:32', '2025-09-17 23:12:43'),
(14, 'App\\Models\\User', 4, 'auth_token', '5af09ce83db8dea797044b98f17e15666d50ce4bb4d6bb16a40cfa5f6c5b18b3', '[\"*\"]', '2025-09-17 23:18:40', NULL, '2025-09-17 23:17:52', '2025-09-17 23:18:40'),
(15, 'App\\Models\\User', 4, 'auth_token', '3a8891aff28cce927ee3d02bfa4f6034a281d65422cea442b511c2d1e7acbbff', '[\"*\"]', '2025-09-17 23:51:30', NULL, '2025-09-17 23:51:23', '2025-09-17 23:51:30'),
(16, 'App\\Models\\User', 4, 'auth_token', '26539b7991f23eabcd1a96e55704d5653211789a492ea8a0a0dffd2a590da3c2', '[\"*\"]', '2025-09-17 23:53:15', NULL, '2025-09-17 23:53:09', '2025-09-17 23:53:15'),
(18, 'App\\Models\\User', 3, 'auth_token', '660273bbc44270e4dbdb13c1f6675563a329608e41b778a57aeb1e0e464869d1', '[\"*\"]', '2025-10-21 19:03:55', NULL, '2025-10-21 18:39:25', '2025-10-21 19:03:55'),
(19, 'App\\Models\\User', 3, 'auth_token', 'c34017f3e710e6e98fe8a2a7840202db00efd05056541c9b1351cb8b6a17ffcf', '[\"*\"]', NULL, NULL, '2025-10-21 22:41:53', '2025-10-21 22:41:53'),
(20, 'App\\Models\\User', 3, 'auth_token', 'a078ac807ed699c2dc1bd19a00bbd749a9ee914cd962f683898ca67e5c292ced', '[\"*\"]', NULL, NULL, '2025-10-21 22:50:56', '2025-10-21 22:50:56'),
(21, 'App\\Models\\User', 3, 'auth_token', 'e7a20c87be33e2c5fe0453f15222c5a632794a51bf7a103f49748541644b7a03', '[\"*\"]', NULL, NULL, '2025-10-21 23:01:19', '2025-10-21 23:01:19'),
(22, 'App\\Models\\User', 8, 'auth_token', '2f7af8af82769b67d5e211b65dcb84fc7166b74c8c1d50443736e474d0ba38f9', '[\"*\"]', NULL, NULL, '2025-10-22 00:03:23', '2025-10-22 00:03:23');

-- --------------------------------------------------------

--
-- Table structure for table `petugas`
--

CREATE TABLE `petugas` (
  `id_petugas` bigint UNSIGNED NOT NULL,
  `nama_petugas` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'petugas',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `temporary_item`
--

CREATE TABLE `temporary_item` (
  `id_temp` bigint UNSIGNED NOT NULL,
  `id_item` bigint UNSIGNED NOT NULL,
  `jumlah` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `google_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','petugas','pengguna') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pengguna',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `google_id`, `avatar`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(2, 'Admin Segar', 'adminsegar@example.com', NULL, NULL, '$2y$12$5lORtI6BlCf59GC7YrWf.uMmpNGE9Hy9VMJMc3G9zFjWO2YstZko6', 'admin', NULL, '2025-09-17 00:13:20', '2025-09-17 00:13:20'),
(3, 'Petugas 1', 'petugas1@example.com', NULL, NULL, '$2y$12$eCrwSzP2Ks8KjhczinTqiOxQdGxxu2ECo/PwmsIKZKevGQfJ/pKre', 'petugas', 'ntnDlM2KXaguusChexueUkdI9JJFXLet1BwRSxATajnO5bdqKyNDPxJWjTmM', '2025-09-17 00:13:21', '2025-10-23 07:52:18'),
(4, 'Rafi', 'rafi@example.com', NULL, NULL, '$2y$12$rWAMvsuXMpkMRH1fTQN0MeTUqAOCsoE2XNTrzKZF9se1xd8677yk2', 'pengguna', 'PsIQw5IuEkY1XSrjupXgI3SAgdLPRHGCha2nkww5kORNdZDGAyXtq4TZXjnE', '2025-09-17 19:30:14', '2025-09-21 06:30:30'),
(5, 'Rafi anak sarpras', 'rafiibnugroho@gmail.com', '100457760666623105302', 'https://lh3.googleusercontent.com/a/ACg8ocL-JfhXJGhKkpDzJUeYS8k7B8DSPvXqJyWSnIaYZLesqsC4slA=s96-c', '$2y$12$i1TnRKqfk8TbWXaLycPaR.5mwd0zCqwm9ZGFqU7ygWCMaT/.jRkvK', 'pengguna', 'IhJdQhb4qmmTqwSyLSVUoWioxMg4O3TLggYWxPKOM3xeES6evz3lSz5BgjHs', '2025-09-23 05:45:53', '2025-10-19 23:53:20'),
(7, 'admin sarparas 1', 'adminsarpras1@gmail.com', NULL, NULL, '$2y$12$IwEhPLN5tmvLMFVNZs/oTuX2J48wz9Ds3rsb7OzrE2g2dYexFxtXu', 'admin', NULL, '2025-09-27 07:39:04', '2025-09-27 07:39:04');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id_item`);

--
-- Indexes for table `list_lokasi`
--
ALTER TABLE `list_lokasi`
  ADD PRIMARY KEY (`id_list`),
  ADD KEY `list_lokasi_id_lokasi_foreign` (`id_lokasi`),
  ADD KEY `list_lokasi_id_item_foreign` (`id_item`);

--
-- Indexes for table `lokasi`
--
ALTER TABLE `lokasi`
  ADD PRIMARY KEY (`id_lokasi`);

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
-- Indexes for table `pengaduan`
--
ALTER TABLE `pengaduan`
  ADD PRIMARY KEY (`id_pengaduan`),
  ADD KEY `pengaduan_id_user_foreign` (`id_user`),
  ADD KEY `pengaduan_id_petugas_foreign` (`id_petugas`),
  ADD KEY `pengaduan_id_item_foreign` (`id_item`),
  ADD KEY `pengaduan_id_lokasi_foreign` (`id_lokasi`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `petugas`
--
ALTER TABLE `petugas`
  ADD PRIMARY KEY (`id_petugas`),
  ADD UNIQUE KEY `petugas_email_unique` (`email`);

--
-- Indexes for table `temporary_item`
--
ALTER TABLE `temporary_item`
  ADD PRIMARY KEY (`id_temp`),
  ADD KEY `temporary_item_id_item_foreign` (`id_item`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_google_id_unique` (`google_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id_item` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `list_lokasi`
--
ALTER TABLE `list_lokasi`
  MODIFY `id_list` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `lokasi`
--
ALTER TABLE `lokasi`
  MODIFY `id_lokasi` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `pengaduan`
--
ALTER TABLE `pengaduan`
  MODIFY `id_pengaduan` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `petugas`
--
ALTER TABLE `petugas`
  MODIFY `id_petugas` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `temporary_item`
--
ALTER TABLE `temporary_item`
  MODIFY `id_temp` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `list_lokasi`
--
ALTER TABLE `list_lokasi`
  ADD CONSTRAINT `list_lokasi_id_item_foreign` FOREIGN KEY (`id_item`) REFERENCES `items` (`id_item`) ON DELETE CASCADE,
  ADD CONSTRAINT `list_lokasi_id_lokasi_foreign` FOREIGN KEY (`id_lokasi`) REFERENCES `lokasi` (`id_lokasi`) ON DELETE CASCADE;

--
-- Constraints for table `pengaduan`
--
ALTER TABLE `pengaduan`
  ADD CONSTRAINT `pengaduan_id_item_foreign` FOREIGN KEY (`id_item`) REFERENCES `items` (`id_item`) ON DELETE CASCADE,
  ADD CONSTRAINT `pengaduan_id_lokasi_foreign` FOREIGN KEY (`id_lokasi`) REFERENCES `lokasi` (`id_lokasi`) ON DELETE SET NULL,
  ADD CONSTRAINT `pengaduan_id_petugas_foreign` FOREIGN KEY (`id_petugas`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `pengaduan_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `temporary_item`
--
ALTER TABLE `temporary_item`
  ADD CONSTRAINT `temporary_item_id_item_foreign` FOREIGN KEY (`id_item`) REFERENCES `items` (`id_item`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
