-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for monitoring_mcu
DROP DATABASE IF EXISTS `monitoring_mcu`;
CREATE DATABASE IF NOT EXISTS `monitoring_mcu` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `monitoring_mcu`;

-- Dumping structure for table monitoring_mcu.cache
DROP TABLE IF EXISTS `cache`;
CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table monitoring_mcu.cache: ~0 rows (approximately)

-- Dumping structure for table monitoring_mcu.cache_locks
DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table monitoring_mcu.cache_locks: ~0 rows (approximately)

-- Dumping structure for table monitoring_mcu.diagnoses
DROP TABLE IF EXISTS `diagnoses`;
CREATE TABLE IF NOT EXISTS `diagnoses` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table monitoring_mcu.diagnoses: ~4 rows (approximately)
REPLACE INTO `diagnoses` (`id`, `code`, `name`, `description`, `is_active`, `created_at`, `updated_at`) VALUES
	(1, 'I01', 'AAAA', NULL, 1, '2025-08-13 08:49:56', '2025-08-13 08:49:56'),
	(2, 'I01.1', 'BBBB', NULL, 1, '2025-08-13 08:50:21', '2025-08-13 08:50:21'),
	(3, 'B01', 'CCCCC', NULL, 1, '2025-08-13 08:50:58', '2025-08-13 08:50:58'),
	(4, 'D01', 'DDDDDD', NULL, 1, '2025-08-13 08:51:11', '2025-08-13 08:51:11');

-- Dumping structure for table monitoring_mcu.failed_jobs
DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table monitoring_mcu.failed_jobs: ~0 rows (approximately)

-- Dumping structure for table monitoring_mcu.jobs
DROP TABLE IF EXISTS `jobs`;
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table monitoring_mcu.jobs: ~4 rows (approximately)
REPLACE INTO `jobs` (`id`, `queue`, `payload`, `attempts`, `reserved_at`, `available_at`, `created_at`) VALUES
	(1, 'default', '{"uuid":"cea023bc-6528-48f9-9615-267c738b15fe","displayName":"App\\\\Notifications\\\\NewRegistrationNotification","job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","maxTries":null,"maxExceptions":null,"failOnTimeout":false,"backoff":null,"timeout":null,"retryUntil":null,"data":{"commandName":"Illuminate\\\\Notifications\\\\SendQueuedNotifications","command":"O:48:\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\":3:{s:11:\\"notifiables\\";O:45:\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\":5:{s:5:\\"class\\";s:15:\\"App\\\\Models\\\\User\\";s:2:\\"id\\";a:1:{i:0;i:1;}s:9:\\"relations\\";a:0:{}s:10:\\"connection\\";s:5:\\"mysql\\";s:15:\\"collectionClass\\";N;}s:12:\\"notification\\";O:45:\\"App\\\\Notifications\\\\NewRegistrationNotification\\":3:{s:4:\\"type\\";s:5:\\"ulang\\";s:7:\\"payload\\";a:6:{s:16:\\"participant_name\\";s:10:\\"Siti Utami\\";s:7:\\"nik_ktp\\";s:16:\\"9929078111305214\\";s:11:\\"nrk_pegawai\\";s:11:\\"NRK61105780\\";s:19:\\"tanggal_pemeriksaan\\";s:10:\\"2025-08-30\\";s:15:\\"jam_pemeriksaan\\";s:5:\\"12:30\\";s:18:\\"lokasi_pemeriksaan\\";s:9:\\"Balaikota\\";}s:2:\\"id\\";s:36:\\"1cf9da86-cdc3-429b-96c6-4756b2be032e\\";}s:8:\\"channels\\";a:1:{i:0;s:8:\\"database\\";}}"},"createdAt":1755103902,"delay":null}', 0, NULL, 1755103902, 1755103902),
	(2, 'default', '{"uuid":"09e07803-47bd-40a2-a127-2da08cb1bcd5","displayName":"App\\\\Notifications\\\\NewRegistrationNotification","job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","maxTries":null,"maxExceptions":null,"failOnTimeout":false,"backoff":null,"timeout":null,"retryUntil":null,"data":{"commandName":"Illuminate\\\\Notifications\\\\SendQueuedNotifications","command":"O:48:\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\":3:{s:11:\\"notifiables\\";O:45:\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\":5:{s:5:\\"class\\";s:15:\\"App\\\\Models\\\\User\\";s:2:\\"id\\";a:1:{i:0;i:2;}s:9:\\"relations\\";a:0:{}s:10:\\"connection\\";s:5:\\"mysql\\";s:15:\\"collectionClass\\";N;}s:12:\\"notification\\";O:45:\\"App\\\\Notifications\\\\NewRegistrationNotification\\":3:{s:4:\\"type\\";s:5:\\"ulang\\";s:7:\\"payload\\";a:6:{s:16:\\"participant_name\\";s:10:\\"Siti Utami\\";s:7:\\"nik_ktp\\";s:16:\\"9929078111305214\\";s:11:\\"nrk_pegawai\\";s:11:\\"NRK61105780\\";s:19:\\"tanggal_pemeriksaan\\";s:10:\\"2025-08-30\\";s:15:\\"jam_pemeriksaan\\";s:5:\\"12:30\\";s:18:\\"lokasi_pemeriksaan\\";s:9:\\"Balaikota\\";}s:2:\\"id\\";s:36:\\"b75834b3-e23d-4b51-8de0-9b6c6b454994\\";}s:8:\\"channels\\";a:1:{i:0;s:8:\\"database\\";}}"},"createdAt":1755103902,"delay":null}', 0, NULL, 1755103902, 1755103902),
	(3, 'default', '{"uuid":"0c3fb858-ff40-4458-8ada-be728296080a","displayName":"App\\\\Notifications\\\\NewRegistrationNotification","job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","maxTries":null,"maxExceptions":null,"failOnTimeout":false,"backoff":null,"timeout":null,"retryUntil":null,"data":{"commandName":"Illuminate\\\\Notifications\\\\SendQueuedNotifications","command":"O:48:\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\":3:{s:11:\\"notifiables\\";O:45:\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\":5:{s:5:\\"class\\";s:15:\\"App\\\\Models\\\\User\\";s:2:\\"id\\";a:1:{i:0;i:1;}s:9:\\"relations\\";a:0:{}s:10:\\"connection\\";s:5:\\"mysql\\";s:15:\\"collectionClass\\";N;}s:12:\\"notification\\";O:45:\\"App\\\\Notifications\\\\NewRegistrationNotification\\":3:{s:4:\\"type\\";s:5:\\"ulang\\";s:7:\\"payload\\";a:6:{s:16:\\"participant_name\\";s:10:\\"Siti Utami\\";s:7:\\"nik_ktp\\";s:16:\\"9929078111305214\\";s:11:\\"nrk_pegawai\\";s:11:\\"NRK61105780\\";s:19:\\"tanggal_pemeriksaan\\";s:10:\\"2025-09-06\\";s:15:\\"jam_pemeriksaan\\";s:5:\\"13:40\\";s:18:\\"lokasi_pemeriksaan\\";s:9:\\"Balaikota\\";}s:2:\\"id\\";s:36:\\"97c08c10-e411-4582-bc3c-ceaa87d5ec7f\\";}s:8:\\"channels\\";a:1:{i:0;s:8:\\"database\\";}}"},"createdAt":1755104603,"delay":null}', 0, NULL, 1755104603, 1755104603),
	(4, 'default', '{"uuid":"7176b6d2-1cf1-496e-b86c-1a6e7a1dffb4","displayName":"App\\\\Notifications\\\\NewRegistrationNotification","job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","maxTries":null,"maxExceptions":null,"failOnTimeout":false,"backoff":null,"timeout":null,"retryUntil":null,"data":{"commandName":"Illuminate\\\\Notifications\\\\SendQueuedNotifications","command":"O:48:\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\":3:{s:11:\\"notifiables\\";O:45:\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\":5:{s:5:\\"class\\";s:15:\\"App\\\\Models\\\\User\\";s:2:\\"id\\";a:1:{i:0;i:2;}s:9:\\"relations\\";a:0:{}s:10:\\"connection\\";s:5:\\"mysql\\";s:15:\\"collectionClass\\";N;}s:12:\\"notification\\";O:45:\\"App\\\\Notifications\\\\NewRegistrationNotification\\":3:{s:4:\\"type\\";s:5:\\"ulang\\";s:7:\\"payload\\";a:6:{s:16:\\"participant_name\\";s:10:\\"Siti Utami\\";s:7:\\"nik_ktp\\";s:16:\\"9929078111305214\\";s:11:\\"nrk_pegawai\\";s:11:\\"NRK61105780\\";s:19:\\"tanggal_pemeriksaan\\";s:10:\\"2025-09-06\\";s:15:\\"jam_pemeriksaan\\";s:5:\\"13:40\\";s:18:\\"lokasi_pemeriksaan\\";s:9:\\"Balaikota\\";}s:2:\\"id\\";s:36:\\"73141f39-150d-4840-bebb-25de57bd206c\\";}s:8:\\"channels\\";a:1:{i:0;s:8:\\"database\\";}}"},"createdAt":1755104603,"delay":null}', 0, NULL, 1755104603, 1755104603);

-- Dumping structure for table monitoring_mcu.job_batches
DROP TABLE IF EXISTS `job_batches`;
CREATE TABLE IF NOT EXISTS `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table monitoring_mcu.job_batches: ~0 rows (approximately)

-- Dumping structure for table monitoring_mcu.mcu_results
DROP TABLE IF EXISTS `mcu_results`;
CREATE TABLE IF NOT EXISTS `mcu_results` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `participant_id` bigint unsigned NOT NULL,
  `schedule_id` bigint unsigned NOT NULL,
  `tanggal_pemeriksaan` date NOT NULL,
  `diagnosis` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `diagnosis_list` json DEFAULT NULL,
  `hasil_pemeriksaan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status_kesehatan` enum('Sehat','Kurang Sehat','Tidak Sehat') COLLATE utf8mb4_unicode_ci NOT NULL,
  `rekomendasi` text COLLATE utf8mb4_unicode_ci,
  `file_hasil` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_hasil_files` json DEFAULT NULL,
  `file_hasil_multi` json DEFAULT NULL,
  `is_downloaded` tinyint(1) NOT NULL DEFAULT '0',
  `downloaded_at` timestamp NULL DEFAULT NULL,
  `uploaded_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `mcu_results_participant_id_foreign` (`participant_id`),
  KEY `mcu_results_schedule_id_foreign` (`schedule_id`),
  CONSTRAINT `mcu_results_participant_id_foreign` FOREIGN KEY (`participant_id`) REFERENCES `participants` (`id`) ON DELETE CASCADE,
  CONSTRAINT `mcu_results_schedule_id_foreign` FOREIGN KEY (`schedule_id`) REFERENCES `schedules` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table monitoring_mcu.mcu_results: ~2 rows (approximately)
REPLACE INTO `mcu_results` (`id`, `participant_id`, `schedule_id`, `tanggal_pemeriksaan`, `diagnosis`, `diagnosis_list`, `hasil_pemeriksaan`, `status_kesehatan`, `rekomendasi`, `file_hasil`, `file_hasil_files`, `file_hasil_multi`, `is_downloaded`, `downloaded_at`, `uploaded_by`, `created_at`, `updated_at`) VALUES
	(1, 60, 83, '2021-12-15', NULL, '["BBBB", "AAAA", "CCCCC"]', 'ok', 'Sehat', NULL, NULL, '["mcu-results/MUCHAMAD SAVIO S.pdf", "mcu-results/Rad - MUHAMMAD SAVIO SIDQI.pdf"]', NULL, 1, '2025-08-13 08:59:13', 'superadmin@mcu.local', '2025-08-13 08:57:52', '2025-08-13 08:59:13'),
	(2, 60, 85, '2025-08-13', NULL, '["AAAA", "CCCCC", "DDDDDD"]', 'ok', 'Kurang Sehat', NULL, NULL, '["mcu-results/1. MUHAMMAD SAVIO SIDQI.pdf", "mcu-results/0807250017-MUHAMMAD SAVIO SIDQI.pdf", "mcu-results/M. SAVIO SIDQI.pdf", "mcu-results/MUCHAMAD SAVIO S.pdf", "mcu-results/Rad - MUHAMMAD SAVIO SIDQI.pdf"]', NULL, 0, NULL, 'superadmin@mcu.local', '2025-08-13 09:01:11', '2025-08-13 09:01:11');

-- Dumping structure for table monitoring_mcu.migrations
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table monitoring_mcu.migrations: ~13 rows (approximately)
REPLACE INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '0001_01_01_000000_create_users_table', 1),
	(2, '0001_01_01_000001_create_cache_table', 1),
	(3, '0001_01_01_000002_create_jobs_table', 1),
	(4, '2025_08_09_041052_create_permission_tables', 1),
	(5, '2025_08_09_041056_create_participants_table', 1),
	(6, '2025_08_09_041217_create_schedules_table', 1),
	(7, '2025_08_09_041219_create_mcu_results_table', 1),
	(8, '2025_08_09_041221_create_settings_table', 1),
	(9, '2025_08_12_000000_add_file_hasil_multi_to_mcu_results_table', 1),
	(10, '2025_08_13_000001_add_file_hasil_files_to_mcu_results_table', 1),
	(11, '2025_08_13_010000_create_diagnoses_table', 1),
	(12, '2025_08_13_010100_add_diagnosis_list_to_mcu_results_table', 1),
	(13, '2025_08_13_020000_alter_schedules_status_enum_add_ditolak', 2),
	(14, '2025_08_13_030000_create_notifications_table', 3),
	(15, '2025_08_13_040000_add_queue_number_to_schedules_table', 4),
	(16, '2025_08_13_050000_add_participant_confirmation_and_reschedule_to_schedules_table', 5);

-- Dumping structure for table monitoring_mcu.model_has_permissions
DROP TABLE IF EXISTS `model_has_permissions`;
CREATE TABLE IF NOT EXISTS `model_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table monitoring_mcu.model_has_permissions: ~0 rows (approximately)

-- Dumping structure for table monitoring_mcu.model_has_roles
DROP TABLE IF EXISTS `model_has_roles`;
CREATE TABLE IF NOT EXISTS `model_has_roles` (
  `role_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table monitoring_mcu.model_has_roles: ~0 rows (approximately)

-- Dumping structure for table monitoring_mcu.notifications
DROP TABLE IF EXISTS `notifications`;
CREATE TABLE IF NOT EXISTS `notifications` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` bigint unsigned NOT NULL,
  `data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table monitoring_mcu.notifications: ~34 rows (approximately)
REPLACE INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES
	('018d72ed-ac82-4ee2-8620-93ab90308b3d', 'App\\Notifications\\NewRegistrationNotification', 'App\\Models\\User', 2, '{"title":"Pendaftaran Peserta Baru","payload":{"user_name":"Syaiful Islami","user_email":"syaiful@gmail.com","nik_ktp":"1010101010101010","nrk_pegawai":"101010"}}', NULL, '2025-08-13 18:52:32', '2025-08-13 18:52:32'),
	('030849af-da9e-48dd-9401-c80ef0a6c345', 'App\\Notifications\\NewRegistrationNotification', 'App\\Models\\User', 2, '{"title":"Pendaftaran Ulang Peserta","payload":{"type":"reschedule_request","participant_name":"Syaiful Islami","nik_ktp":"1010101010101010","new_date":"2025-08-15","new_time":"16:27","reason":"lagi sakit"}}', NULL, '2025-08-13 21:28:05', '2025-08-13 21:28:05'),
	('0434eb21-f992-4e0f-8eb6-ad27a7b6d968', 'App\\Notifications\\NewRegistrationNotification', 'App\\Models\\User', 2, '{"title":"Pendaftaran Ulang Peserta","payload":{"type":"reschedule_request","participant_name":"Syaiful Islami","nik_ktp":"1010101010101010","new_date":"2025-09-14","new_time":"07:30","reason":"lagi sakit"}}', NULL, '2025-09-03 05:49:03', '2025-09-03 05:49:03'),
	('0826fdd9-08aa-46a2-902a-3137efcc777e', 'App\\Notifications\\NewRegistrationNotification', 'App\\Models\\User', 1, '{"title":"Pendaftaran Ulang Peserta","payload":{"type":"reschedule_request","participant_name":"Syaiful Islami","nik_ktp":"1010101010101010","new_date":"2025-09-19","new_time":"10:30","reason":"Reschedule"}}', '2025-09-03 05:52:45', '2025-09-03 05:52:03', '2025-09-03 05:52:45'),
	('17f010eb-412a-4179-96a7-3ac80887acff', 'App\\Notifications\\NewRegistrationNotification', 'App\\Models\\User', 2, '{"title":"Pendaftaran Ulang Peserta","payload":{"participant_name":"Syaiful Islami","nik_ktp":"1010101010101010","nrk_pegawai":"101010","tanggal_pemeriksaan":"2025-08-14","jam_pemeriksaan":"12:11","lokasi_pemeriksaan":"Balaikota"}}', NULL, '2025-08-13 19:08:23', '2025-08-13 19:08:23'),
	('19a1f971-d721-40d7-8ba0-fdbf3d3daa3b', 'App\\Notifications\\NewRegistrationNotification', 'App\\Models\\User', 1, '{"title":"Pendaftaran Ulang Peserta","payload":{"type":"reschedule_request","participant_name":"Syaiful Islami","nik_ktp":"1010101010101010","new_date":"2025-08-15","new_time":"16:27","reason":"lagi sakit"}}', '2025-08-15 10:20:01', '2025-08-13 21:28:05', '2025-08-15 10:20:01'),
	('1f0a92ee-2d04-41d1-80b3-6e7fcd93867c', 'App\\Notifications\\NewRegistrationNotification', 'App\\Models\\User', 1, '{"title":"Pendaftaran Ulang Peserta","payload":{"participant_name":"Siti Utami","nik_ktp":"9929078111305214","nrk_pegawai":"NRK61105780","tanggal_pemeriksaan":"2025-09-04","jam_pemeriksaan":"13:09","lokasi_pemeriksaan":"Balaikota"}}', '2025-08-13 10:07:45', '2025-08-13 10:07:29', '2025-08-13 10:07:45'),
	('1f9c78d7-35e5-4c93-80c5-6e4701d11cec', 'App\\Notifications\\NewRegistrationNotification', 'App\\Models\\User', 1, '{"title":"Pendaftaran Ulang Peserta","payload":{"type":"reschedule_request","participant_name":"Rahmi Zulaika","nik_ktp":"2965860775719956","new_date":"2025-08-16","new_time":"14:59","reason":"Ada rapat"}}', '2025-08-13 20:55:50', '2025-08-13 20:55:33', '2025-08-13 20:55:50'),
	('24a63b3b-7615-426a-8b29-1c3ef41c6992', 'App\\Notifications\\NewRegistrationNotification', 'App\\Models\\User', 1, '{"title":"Pendaftaran Ulang Peserta","payload":{"type":"reschedule_request","participant_name":"Syaiful Islami","nik_ktp":"1010101010101010","new_date":"2025-09-20T00:00:00.000000Z","new_time":"2025-09-03T07:30:00.000000Z","reason":"Ada rapat"}}', '2025-09-03 05:56:37', '2025-09-03 05:56:23', '2025-09-03 05:56:37'),
	('2f5f3d1e-b133-46b9-80e3-6af9eb0a2359', 'App\\Notifications\\NewRegistrationNotification', 'App\\Models\\User', 2, '{"title":"Pendaftaran Ulang Peserta","payload":{"type":"reschedule_request","participant_name":"Syaiful Islami","nik_ktp":"1010101010101010","new_date":"2025-09-08","new_time":"07:30","reason":"Ada rapat"}}', NULL, '2025-09-03 05:46:31', '2025-09-03 05:46:31'),
	('30947b75-9af9-4ead-b8d3-0d6ac6f14fa2', 'App\\Notifications\\NewRegistrationNotification', 'App\\Models\\User', 2, '{"title":"Pendaftaran Ulang Peserta","payload":{"type":"reschedule_request","participant_name":"Syaiful Islami","nik_ktp":"1010101010101010","new_date":"2025-09-11","new_time":"08:00","reason":"Ada rapat"}}', NULL, '2025-09-03 05:42:59', '2025-09-03 05:42:59'),
	('313821cd-0eae-4299-abf0-8a0e6a6fd020', 'App\\Notifications\\NewRegistrationNotification', 'App\\Models\\User', 2, '{"title":"Pendaftaran Ulang Peserta","payload":{"type":"reschedule_request","participant_name":"Syaiful Islami","nik_ktp":"1010101010101010","new_date":"2025-08-15","new_time":"07:30","reason":"Ada rapat"}}', NULL, '2025-08-13 21:24:57', '2025-08-13 21:24:57'),
	('478a2959-cd5c-48de-a8b0-7e1fecdec2f2', 'App\\Notifications\\NewRegistrationNotification', 'App\\Models\\User', 1, '{"title":"Pendaftaran Ulang Peserta","payload":{"type":"reschedule_request","participant_name":"Syaiful Islami","nik_ktp":"1010101010101010","new_date":"2025-09-11","new_time":"08:00","reason":"Ada rapat"}}', '2025-09-03 05:43:50', '2025-09-03 05:43:00', '2025-09-03 05:43:50'),
	('4831db44-4d66-49e2-b617-a806fadd3055', 'App\\Notifications\\NewRegistrationNotification', 'App\\Models\\User', 2, '{"title":"Pendaftaran Ulang Peserta","payload":{"participant_name":"Siti Utami","nik_ktp":"9929078111305214","nrk_pegawai":"NRK61105780","tanggal_pemeriksaan":"2025-09-04","jam_pemeriksaan":"13:09","lokasi_pemeriksaan":"Balaikota"}}', NULL, '2025-08-13 10:07:30', '2025-08-13 10:07:30'),
	('4ab37171-1f6c-4fa8-89fb-b0e2c56804b1', 'App\\Notifications\\NewRegistrationNotification', 'App\\Models\\User', 1, '{"title":"Pendaftaran Ulang Peserta","payload":{"type":"reschedule_request","participant_name":"Syaiful Islami","nik_ktp":"1010101010101010","new_date":"2025-09-10","new_time":"21:12","reason":"lagi sakit"}}', '2025-09-03 05:12:59', '2025-09-03 05:12:48', '2025-09-03 05:12:59'),
	('67c4ff65-e0c4-445a-8a94-a34a5a5bd83f', 'App\\Notifications\\NewRegistrationNotification', 'App\\Models\\User', 1, '{"title":"Pendaftaran Ulang Peserta","payload":{"type":"reschedule_request","participant_name":"Rahmi Zulaika","nik_ktp":"2965860775719956","new_date":"2025-08-21","new_time":"07:30","reason":"lagi sakit"}}', '2025-08-13 21:21:37', '2025-08-13 21:20:33', '2025-08-13 21:21:37'),
	('7ae06412-9382-4401-8271-a437ca444d7c', 'App\\Notifications\\NewRegistrationNotification', 'App\\Models\\User', 1, '{"title":"Pendaftaran Ulang Peserta","payload":{"type":"reschedule_request","participant_name":"Syaiful Islami","nik_ktp":"1010101010101010","new_date":"2025-09-11","new_time":"08:00","reason":"Ada rapat"}}', '2025-09-03 05:43:46', '2025-09-03 05:42:59', '2025-09-03 05:43:46'),
	('81a1b81f-486f-47c9-9dd8-070d2f86b8cf', 'App\\Notifications\\NewRegistrationNotification', 'App\\Models\\User', 2, '{"title":"Pendaftaran Ulang Peserta","payload":{"type":"reschedule_request","participant_name":"Syaiful Islami","nik_ktp":"1010101010101010","new_date":"2025-09-11","new_time":"08:00","reason":"Ada rapat"}}', NULL, '2025-09-03 05:43:00', '2025-09-03 05:43:00'),
	('8bbc4721-b0cb-47b3-af52-0d9feb5daab9', 'App\\Notifications\\NewRegistrationNotification', 'App\\Models\\User', 2, '{"title":"Pendaftaran Ulang Peserta","payload":{"type":"reschedule_request","participant_name":"Rahmi Zulaika","nik_ktp":"2965860775719956","new_date":"2025-08-16","new_time":"14:59","reason":"Ada rapat"}}', NULL, '2025-08-13 20:55:35', '2025-08-13 20:55:35'),
	('941e1918-9c9b-40df-9902-4e86e4c6fc0c', 'App\\Notifications\\NewRegistrationNotification', 'App\\Models\\User', 2, '{"title":"Pendaftaran Ulang Peserta","payload":{"type":"reschedule_request","participant_name":"Syaiful Islami","nik_ktp":"1010101010101010","new_date":"2025-09-10","new_time":"21:12","reason":"lagi sakit"}}', NULL, '2025-09-03 05:12:48', '2025-09-03 05:12:48'),
	('9fcaeadd-bf17-4d56-87eb-397dbb8c0be2', 'App\\Notifications\\NewRegistrationNotification', 'App\\Models\\User', 1, '{"title":"Pendaftaran Ulang Peserta","payload":{"type":"reschedule_request","participant_name":"Rahmi Zulaika","nik_ktp":"2965860775719956","new_date":"2025-08-16","new_time":"14:59","reason":"Ada rapat"}}', '2025-08-13 20:55:51', '2025-08-13 20:55:35', '2025-08-13 20:55:51'),
	('a0688602-0e35-4df5-b9ee-c36690454737', 'App\\Notifications\\NewRegistrationNotification', 'App\\Models\\User', 2, '{"title":"Pendaftaran Ulang Peserta","payload":{"type":"reschedule_request","participant_name":"Syaiful Islami","nik_ktp":"1010101010101010","new_date":"2025-09-20T00:00:00.000000Z","new_time":"2025-09-03T07:30:00.000000Z","reason":"Ada rapat"}}', NULL, '2025-09-03 05:56:23', '2025-09-03 05:56:23'),
	('ae3f09d5-54ad-4ab1-befa-640b85cdcc1d', 'App\\Notifications\\NewRegistrationNotification', 'App\\Models\\User', 1, '{"title":"Pendaftaran Ulang Peserta","payload":{"participant_name":"Syaiful Islami","nik_ktp":"1010101010101010","nrk_pegawai":"101010","tanggal_pemeriksaan":"2025-08-14","jam_pemeriksaan":"08:53","lokasi_pemeriksaan":"Balaikota"}}', '2025-08-13 18:54:08', '2025-08-13 18:53:59', '2025-08-13 18:54:08'),
	('b1bea185-8ff5-4edc-a728-506577a2c53e', 'App\\Notifications\\NewRegistrationNotification', 'App\\Models\\User', 1, '{"title":"Pendaftaran Ulang Peserta","payload":{"type":"reschedule_request","participant_name":"Syaiful Islami","nik_ktp":"1010101010101010","new_date":"2025-09-14","new_time":"07:30","reason":"lagi sakit"}}', '2025-09-03 05:49:17', '2025-09-03 05:49:03', '2025-09-03 05:49:17'),
	('d355c420-15a7-4542-8f53-a1e7c374ccaf', 'App\\Notifications\\NewRegistrationNotification', 'App\\Models\\User', 1, '{"title":"Pendaftaran Ulang Peserta","payload":{"participant_name":"Syaiful Islami","nik_ktp":"1010101010101010","nrk_pegawai":"101010","tanggal_pemeriksaan":"2025-08-14","jam_pemeriksaan":"12:11","lokasi_pemeriksaan":"Balaikota"}}', '2025-08-13 19:08:49', '2025-08-13 19:08:23', '2025-08-13 19:08:49'),
	('dd563105-e539-4b50-bc0c-5671ec139b83', 'App\\Notifications\\NewRegistrationNotification', 'App\\Models\\User', 1, '{"title":"Pendaftaran Ulang Peserta","payload":{"type":"reschedule_request","participant_name":"Syaiful Islami","nik_ktp":"1010101010101010","new_date":"2025-09-19","new_time":"10:30","reason":"Reschedule"}}', '2025-09-03 05:52:46', '2025-09-03 05:52:02', '2025-09-03 05:52:46'),
	('e45be22b-fb2a-4f51-8e3e-a4aac2d498b9', 'App\\Notifications\\NewRegistrationNotification', 'App\\Models\\User', 2, '{"title":"Pendaftaran Ulang Peserta","payload":{"type":"reschedule_request","participant_name":"Rahmi Zulaika","nik_ktp":"2965860775719956","new_date":"2025-08-21","new_time":"07:30","reason":"lagi sakit"}}', NULL, '2025-08-13 21:20:33', '2025-08-13 21:20:33'),
	('e5f0f245-97c3-4419-99d0-99cc238107bd', 'App\\Notifications\\NewRegistrationNotification', 'App\\Models\\User', 2, '{"title":"Pendaftaran Ulang Peserta","payload":{"type":"reschedule_request","participant_name":"Syaiful Islami","nik_ktp":"1010101010101010","new_date":"2025-09-19","new_time":"10:30","reason":"Reschedule"}}', NULL, '2025-09-03 05:52:03', '2025-09-03 05:52:03'),
	('ebb9d101-804a-4bab-9214-10c21a70b11f', 'App\\Notifications\\NewRegistrationNotification', 'App\\Models\\User', 1, '{"title":"Pendaftaran Peserta Baru","payload":{"user_name":"Syaiful Islami","user_email":"syaiful@gmail.com","nik_ktp":"1010101010101010","nrk_pegawai":"101010"}}', '2025-08-13 18:54:10', '2025-08-13 18:52:32', '2025-08-13 18:54:10'),
	('ec7cf03d-e3ac-4be9-b8c7-019c153f6cf4', 'App\\Notifications\\NewRegistrationNotification', 'App\\Models\\User', 1, '{"title":"Pendaftaran Ulang Peserta","payload":{"type":"reschedule_request","participant_name":"Syaiful Islami","nik_ktp":"1010101010101010","new_date":"2025-09-08","new_time":"07:30","reason":"Ada rapat"}}', '2025-09-03 05:46:38', '2025-09-03 05:46:30', '2025-09-03 05:46:38'),
	('f9f56247-7013-46d3-b148-81d4513bd232', 'App\\Notifications\\NewRegistrationNotification', 'App\\Models\\User', 2, '{"title":"Pendaftaran Ulang Peserta","payload":{"type":"reschedule_request","participant_name":"Syaiful Islami","nik_ktp":"1010101010101010","new_date":"2025-09-19","new_time":"10:30","reason":"Reschedule"}}', NULL, '2025-09-03 05:52:02', '2025-09-03 05:52:02'),
	('fadc1602-fb03-4d4f-8ad9-dc5a6dbfc5d2', 'App\\Notifications\\NewRegistrationNotification', 'App\\Models\\User', 2, '{"title":"Pendaftaran Ulang Peserta","payload":{"type":"reschedule_request","participant_name":"Rahmi Zulaika","nik_ktp":"2965860775719956","new_date":"2025-08-16","new_time":"14:59","reason":"Ada rapat"}}', NULL, '2025-08-13 20:55:33', '2025-08-13 20:55:33'),
	('fb3f0588-8ec6-4574-8f1c-b70fdd8089ff', 'App\\Notifications\\NewRegistrationNotification', 'App\\Models\\User', 1, '{"title":"Pendaftaran Ulang Peserta","payload":{"type":"reschedule_request","participant_name":"Syaiful Islami","nik_ktp":"1010101010101010","new_date":"2025-08-15","new_time":"07:30","reason":"Ada rapat"}}', '2025-08-15 10:20:03', '2025-08-13 21:24:57', '2025-08-15 10:20:03'),
	('fb760249-52d7-422d-9d68-9d5c31d8bf68', 'App\\Notifications\\NewRegistrationNotification', 'App\\Models\\User', 2, '{"title":"Pendaftaran Ulang Peserta","payload":{"participant_name":"Syaiful Islami","nik_ktp":"1010101010101010","nrk_pegawai":"101010","tanggal_pemeriksaan":"2025-08-14","jam_pemeriksaan":"08:53","lokasi_pemeriksaan":"Balaikota"}}', NULL, '2025-08-13 18:53:59', '2025-08-13 18:53:59');

-- Dumping structure for table monitoring_mcu.participants
DROP TABLE IF EXISTS `participants`;
CREATE TABLE IF NOT EXISTS `participants` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nik_ktp` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nrk_pegawai` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_lengkap` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tempat_lahir` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `jenis_kelamin` enum('L','P') COLLATE utf8mb4_unicode_ci NOT NULL,
  `skpd` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ukpd` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_telp` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status_pegawai` enum('CPNS','PNS','PPPK') COLLATE utf8mb4_unicode_ci NOT NULL,
  `status_mcu` enum('Belum MCU','Sudah MCU','Ditolak') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Belum MCU',
  `tanggal_mcu_terakhir` date DEFAULT NULL,
  `catatan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `participants_nik_ktp_unique` (`nik_ktp`),
  UNIQUE KEY `participants_nrk_pegawai_unique` (`nrk_pegawai`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table monitoring_mcu.participants: ~100 rows (approximately)
REPLACE INTO `participants` (`id`, `nik_ktp`, `nrk_pegawai`, `nama_lengkap`, `tempat_lahir`, `tanggal_lahir`, `jenis_kelamin`, `skpd`, `ukpd`, `no_telp`, `email`, `status_pegawai`, `status_mcu`, `tanggal_mcu_terakhir`, `catatan`, `created_at`, `updated_at`) VALUES
	(1, '1803572186991303', 'NRK12486765', 'Hamima Wulandari', 'Pematangsiantar', '1999-03-19', 'P', 'Dinas Kesehatan', 'UPT 5', '089126723242', 'rangga55@example.net', 'PNS', 'Ditolak', '2024-11-24', NULL, '2025-08-13 08:46:50', '2025-08-13 08:46:50'),
	(2, '4750688855711636', 'NRK24865295', 'Jagaraga Sihombing', 'Depok', '1970-01-29', 'L', 'Bappeda', 'UPT 4', '082693793592', 'gangsa.mangunsong@example.net', 'PPPK', 'Ditolak', '2021-06-02', NULL, '2025-08-13 08:46:50', '2025-08-13 08:46:50'),
	(3, '0145121594652218', 'NRK30297563', 'Shakila Uyainah', 'Makassar', '1971-07-03', 'P', 'Bappeda', 'UPT 4', '080963324892', 'enovitasari@example.org', 'PNS', 'Belum MCU', NULL, NULL, '2025-08-13 08:46:50', '2025-08-13 08:46:50'),
	(4, '6118920130127941', 'NRK09873688', 'Argono Tasnim Siregar', 'Binjai', '1969-10-27', 'L', 'Dinas Pendidikan', 'UPT 2', '089579926320', 'cemeti26@example.org', 'CPNS', 'Sudah MCU', '2025-02-11', NULL, '2025-08-13 08:46:50', '2025-08-13 08:46:50'),
	(5, '5700930507337154', 'NRK08247934', 'Salsabila Rika Wulandari S.Psi', 'Pasuruan', '1985-01-27', 'P', 'Bappeda', 'UPT 1', '080306457502', 'wadi86@example.net', 'PPPK', 'Belum MCU', NULL, NULL, '2025-08-13 08:46:50', '2025-08-13 08:46:50'),
	(6, '2965860775719956', 'NRK45255515', 'Rahmi Zulaika', 'Tanjung Pinang', '1987-11-21', 'P', 'Bappeda', 'UPT 3', '082903477062', 'permata.kanda@example.com', 'CPNS', 'Ditolak', '2022-09-22', NULL, '2025-08-13 08:46:50', '2025-08-13 08:46:50'),
	(7, '1859082034842924', 'NRK98814231', 'Prakosa Umay Marpaung S.Gz', 'Malang', '1994-03-07', 'L', 'Dinas Kesehatan', 'UPT 5', '083392194511', 'cdongoran@example.net', 'PNS', 'Ditolak', '2020-12-02', 'Similique ullam voluptas magnam quam sunt ea.', '2025-08-13 08:46:50', '2025-08-13 08:46:50'),
	(8, '8640740555707092', 'NRK56971876', 'Zalindra Wastuti S.Gz', 'Batam', '2003-02-03', 'P', 'Sekretariat Daerah', 'UPT 2', '083134604345', 'purwanti.ira@example.org', 'CPNS', 'Sudah MCU', '2021-07-18', NULL, '2025-08-13 08:46:50', '2025-08-13 08:46:50'),
	(9, '2744574512798510', 'NRK06572259', 'Jelita Nurdiyanti', 'Batam', '1987-02-26', 'P', 'Sekretariat Daerah', 'UPT 2', '084881999136', 'msudiati@example.net', 'CPNS', 'Belum MCU', NULL, NULL, '2025-08-13 08:46:50', '2025-08-13 08:46:50'),
	(10, '7077903615783868', 'NRK41786017', 'Saka Pradana', 'Pagar Alam', '1983-09-16', 'L', 'Dinas Kesehatan', 'UPT 1', '081495835223', 'padmasari.ulva@example.net', 'PNS', 'Belum MCU', NULL, NULL, '2025-08-13 08:46:50', '2025-08-13 08:46:50'),
	(11, '5172009890707773', 'NRK51247637', 'Timbul Emas Wasita', 'Padangsidempuan', '1997-04-14', 'L', 'Dinas Kesehatan', 'UPT 4', '086773088165', 'saptono.diana@example.org', 'CPNS', 'Sudah MCU', '2022-12-11', NULL, '2025-08-13 08:46:50', '2025-08-13 08:46:50'),
	(12, '3424341757308972', 'NRK15170164', 'Belinda Raisa Laksmiwati S.IP', 'Lhokseumawe', '1996-04-28', 'P', 'Dinas Perhubungan', 'UPT 1', '080268947064', 'hari56@example.net', 'CPNS', 'Sudah MCU', '2021-10-04', NULL, '2025-08-13 08:46:50', '2025-08-13 08:46:50'),
	(13, '7737515738289057', 'NRK81142669', 'Kasiyah Widiastuti', 'Bukittinggi', '1988-09-02', 'P', 'Dinas Kesehatan', 'UPT 2', '084470080173', 'laksmiwati.soleh@example.org', 'CPNS', 'Belum MCU', NULL, 'Qui aut et est occaecati optio quae fugiat.', '2025-08-13 08:46:50', '2025-08-13 08:46:50'),
	(14, '0133938427399663', 'NRK40273080', 'Farah Rahmi Wijayanti S.I.Kom', 'Surabaya', '1987-06-16', 'P', 'Dinas Perhubungan', 'UPT 3', '088382206509', 'agustina.cahya@example.net', 'PPPK', 'Sudah MCU', '2021-06-18', 'Aut sit harum sit exercitationem ad veritatis.', '2025-08-13 08:46:50', '2025-08-13 08:46:50'),
	(15, '1617516239337821', 'NRK57325264', 'Gangsa Prasetyo', 'Ambon', '2001-06-29', 'L', 'Dinas Perhubungan', 'UPT 2', '088951728570', 'karimah27@example.net', 'PNS', 'Ditolak', '2025-08-11', NULL, '2025-08-13 08:46:50', '2025-08-13 08:46:50'),
	(16, '6816125867755016', 'NRK85921910', 'Bagas Atmaja Manullang', 'Gorontalo', '1974-02-16', 'L', 'Sekretariat Daerah', 'UPT 1', '085905099772', 'farida.intan@example.net', 'PNS', 'Belum MCU', NULL, NULL, '2025-08-13 08:46:50', '2025-08-13 08:46:50'),
	(17, '9768285423695468', 'NRK40212713', 'Enteng Cengkal Uwais', 'Bogor', '1990-03-21', 'L', 'Dinas Perhubungan', 'UPT 2', '088693914964', 'humaira24@example.com', 'PPPK', 'Belum MCU', NULL, NULL, '2025-08-13 08:46:50', '2025-08-13 08:46:50'),
	(18, '6950626103545027', 'NRK35360876', 'Zizi Lailasari', 'Palopo', '1976-03-14', 'P', 'Bappeda', 'UPT 4', '087213495961', 'ega70@example.com', 'PPPK', 'Sudah MCU', '2022-05-25', NULL, '2025-08-13 08:46:50', '2025-08-13 08:46:50'),
	(19, '1102807514169358', 'NRK17915261', 'Victoria Umi Namaga M.Ak', 'Pontianak', '1981-01-05', 'P', 'Dinas Kesehatan', 'UPT 4', '080501899355', 'karma.latupono@example.net', 'PPPK', 'Sudah MCU', '2023-08-07', NULL, '2025-08-13 08:46:50', '2025-08-13 08:46:50'),
	(20, '0254570322004177', 'NRK19374163', 'Warsita Lasmanto Mustofa', 'Samarinda', '1984-07-21', 'L', 'Sekretariat Daerah', 'UPT 4', '089835480640', 'liman45@example.net', 'PPPK', 'Sudah MCU', '2022-01-21', NULL, '2025-08-13 08:46:50', '2025-08-13 08:46:50'),
	(21, '2512288908789703', 'NRK91323602', 'Ophelia Hariyah', 'Administrasi Jakarta Timur', '1985-09-08', 'P', 'Sekretariat Daerah', 'UPT 4', '087030909577', 'legawa.laksmiwati@example.net', 'PPPK', 'Belum MCU', NULL, 'Id et vel est ullam rerum.', '2025-08-13 08:46:50', '2025-08-13 08:46:50'),
	(22, '8163473162535045', 'NRK26074258', 'Cakrajiya Ozy Pranowo', 'Tidore Kepulauan', '1981-12-13', 'L', 'Dinas Kesehatan', 'UPT 5', '085750190467', 'shania51@example.net', 'PPPK', 'Ditolak', '2022-01-25', NULL, '2025-08-13 08:46:50', '2025-08-13 08:46:50'),
	(23, '4630751766780962', 'NRK34928473', 'Aswani Tamba', 'Batam', '1976-04-05', 'L', 'Sekretariat Daerah', 'UPT 1', '087843874574', 'jane.aryani@example.net', 'CPNS', 'Belum MCU', NULL, 'Dolor est praesentium consequatur reprehenderit eos occaecati incidunt quisquam.', '2025-08-13 08:46:50', '2025-08-13 08:46:50'),
	(24, '6557299262527972', 'NRK68212038', 'Yance Utami', 'Samarinda', '1995-04-20', 'P', 'Sekretariat Daerah', 'UPT 2', '089454871647', 'wardi.kuswandari@example.net', 'PPPK', 'Belum MCU', NULL, NULL, '2025-08-13 08:46:50', '2025-08-13 08:46:50'),
	(25, '4669014529473951', 'NRK08619878', 'Darsirah Dongoran', 'Pagar Alam', '1980-10-15', 'L', 'Dinas Pendidikan', 'UPT 3', '083984861479', 'maryanto62@example.net', 'CPNS', 'Sudah MCU', '2025-04-18', NULL, '2025-08-13 08:46:50', '2025-08-13 08:46:50'),
	(26, '6914277711538834', 'NRK30667200', 'Slamet Prabowo', 'Langsa', '1967-01-31', 'L', 'Dinas Perhubungan', 'UPT 1', '084159360430', 'putri.budiyanto@example.net', 'CPNS', 'Ditolak', '2020-11-13', NULL, '2025-08-13 08:46:50', '2025-08-13 08:46:50'),
	(27, '8331131589012375', 'NRK63183072', 'Mursita Saefullah', 'Ambon', '1971-06-15', 'L', 'Sekretariat Daerah', 'UPT 5', '081059138888', 'talia.ardianto@example.com', 'PPPK', 'Ditolak', '2024-06-01', NULL, '2025-08-13 08:46:50', '2025-08-13 08:46:50'),
	(28, '8079236002145934', 'NRK14471908', 'Febi Yuliarti S.E.', 'Banjarmasin', '1993-10-16', 'P', 'Sekretariat Daerah', 'UPT 1', '083787847038', 'marbun.respati@example.com', 'PPPK', 'Ditolak', '2022-12-31', NULL, '2025-08-13 08:46:50', '2025-08-13 08:46:50'),
	(29, '4554231363668570', 'NRK27044407', 'Purwadi Hardiansyah S.Psi', 'Tomohon', '1968-03-18', 'L', 'Dinas Pendidikan', 'UPT 1', '085312825609', 'wibowo.gilang@example.org', 'PNS', 'Belum MCU', NULL, 'Autem nam delectus iure earum nostrum quis.', '2025-08-13 08:46:50', '2025-08-13 08:46:50'),
	(30, '7551274122099691', 'NRK08715018', 'Kartika Sudiati', 'Palembang', '1973-03-08', 'P', 'Sekretariat Daerah', 'UPT 4', '080558988414', 'hasta.lailasari@example.com', 'CPNS', 'Ditolak', '2021-08-11', NULL, '2025-08-13 08:46:50', '2025-08-13 08:46:50'),
	(31, '5066226508621651', 'NRK79380587', 'Humaira Nasyidah', 'Magelang', '1984-07-28', 'P', 'Bappeda', 'UPT 2', '087886138212', 'zaenab.lestari@example.net', 'CPNS', 'Ditolak', '2023-09-27', NULL, '2025-08-13 08:46:50', '2025-08-13 08:46:50'),
	(32, '4777846071634880', 'NRK13257485', 'Yuliana Puspasari', 'Salatiga', '1999-06-03', 'P', 'Dinas Perhubungan', 'UPT 1', '085994620620', 'carla41@example.net', 'PNS', 'Belum MCU', NULL, NULL, '2025-08-13 08:46:50', '2025-08-13 08:46:50'),
	(33, '8824109332171244', 'NRK24415333', 'Tami Laksita S.Psi', 'Lhokseumawe', '1997-03-18', 'P', 'Dinas Kesehatan', 'UPT 2', '080149248203', 'dmaryadi@example.com', 'CPNS', 'Belum MCU', NULL, 'Asperiores sequi rerum molestiae ut voluptatem.', '2025-08-13 08:46:50', '2025-08-13 08:46:50'),
	(34, '2757805117927443', 'NRK99117391', 'Unggul Galih Samosir', 'Balikpapan', '1984-03-19', 'L', 'Dinas Kesehatan', 'UPT 3', '085356773757', 'cinthia.prasetya@example.org', 'PPPK', 'Belum MCU', NULL, NULL, '2025-08-13 08:46:50', '2025-08-13 08:46:50'),
	(35, '0469754198578597', 'NRK89514573', 'Bajragin Prayoga', 'Pontianak', '1988-08-27', 'L', 'Dinas Pendidikan', 'UPT 3', '088361372241', 'wprabowo@example.com', 'PPPK', 'Ditolak', '2022-09-16', NULL, '2025-08-13 08:46:50', '2025-08-13 08:46:50'),
	(36, '6657932786049089', 'NRK56306342', 'Mahmud Hari Saptono S.Farm', 'Banjar', '2004-01-15', 'L', 'Dinas Pendidikan', 'UPT 1', '082712146905', 'varyani@example.net', 'CPNS', 'Ditolak', '2021-12-24', NULL, '2025-08-13 08:46:50', '2025-08-13 08:46:50'),
	(37, '7478163969041027', 'NRK31951550', 'Vanesa Prastuti', 'Metro', '1969-12-14', 'P', 'Bappeda', 'UPT 2', '087571265415', 'tkusumo@example.net', 'CPNS', 'Belum MCU', NULL, NULL, '2025-08-13 08:46:50', '2025-08-13 08:46:50'),
	(38, '3170151757154546', 'NRK08729491', 'Lanjar Jayeng Anggriawan', 'Administrasi Jakarta Selatan', '1968-09-12', 'L', 'Dinas Perhubungan', 'UPT 1', '089027105271', 'jaswadi27@example.org', 'PPPK', 'Sudah MCU', '2022-02-26', NULL, '2025-08-13 08:46:50', '2025-08-13 08:46:50'),
	(39, '0198868421434874', 'NRK11020325', 'Vero Cakrawangsa Siregar S.E.I', 'Samarinda', '1996-08-26', 'L', 'Sekretariat Daerah', 'UPT 3', '089314595921', 'wisnu30@example.com', 'PNS', 'Ditolak', '2021-12-17', 'Eligendi eaque sit repudiandae adipisci.', '2025-08-13 08:46:50', '2025-08-13 08:46:50'),
	(40, '1369793517685484', 'NRK83467225', 'Baktiadi Mulya Suryono', 'Medan', '1969-07-25', 'L', 'Bappeda', 'UPT 1', '089812356530', 'tsalahudin@example.org', 'CPNS', 'Sudah MCU', '2025-01-13', NULL, '2025-08-13 08:46:50', '2025-08-13 08:46:50'),
	(41, '7609099578474789', 'NRK05541560', 'Jagapati Jarwadi Januar S.H.', 'Batu', '1997-08-22', 'L', 'Dinas Kesehatan', 'UPT 3', '088978264603', 'puput01@example.com', 'CPNS', 'Sudah MCU', '2025-04-26', NULL, '2025-08-13 08:46:50', '2025-08-13 08:46:50'),
	(42, '4818709065849478', 'NRK35400887', 'Intan Mandasari', 'Tangerang', '1990-07-18', 'P', 'Dinas Perhubungan', 'UPT 1', '085425442965', 'rama78@example.com', 'CPNS', 'Belum MCU', NULL, NULL, '2025-08-13 08:46:50', '2025-08-13 08:46:50'),
	(43, '7151846974735817', 'NRK61761633', 'Rina Zulaika', 'Subulussalam', '1976-05-27', 'P', 'Sekretariat Daerah', 'UPT 1', '085619018401', 'samiah25@example.net', 'CPNS', 'Sudah MCU', '2022-04-03', NULL, '2025-08-13 08:46:50', '2025-08-13 08:46:50'),
	(44, '3316153899901240', 'NRK40788300', 'Nurul Natalia Hartati', 'Kupang', '1995-06-19', 'P', 'Dinas Kesehatan', 'UPT 2', '087494862155', 'warji.latupono@example.net', 'CPNS', 'Ditolak', '2021-04-04', NULL, '2025-08-13 08:46:50', '2025-08-13 08:46:50'),
	(45, '5274382598980287', 'NRK85566704', 'Rahmi Mardhiyah', 'Palangka Raya', '1980-07-28', 'P', 'Bappeda', 'UPT 4', '084906308465', 'nhutapea@example.net', 'PPPK', 'Belum MCU', NULL, NULL, '2025-08-13 08:46:50', '2025-08-13 08:46:50'),
	(46, '0610038265896742', 'NRK26241520', 'Galang Tarihoran', 'Sorong', '2002-10-21', 'L', 'Dinas Kesehatan', 'UPT 4', '085054445135', 'martana.haryanti@example.org', 'CPNS', 'Belum MCU', NULL, NULL, '2025-08-13 08:46:50', '2025-08-13 08:46:50'),
	(47, '2924932391990677', 'NRK40422637', 'Kani Padmasari M.Farm', 'Cilegon', '1966-12-18', 'P', 'Sekretariat Daerah', 'UPT 1', '082444288098', 'widiastuti.kambali@example.net', 'PPPK', 'Belum MCU', NULL, 'Laudantium aut error officia earum.', '2025-08-13 08:46:50', '2025-08-13 08:46:50'),
	(48, '3951011172408191', 'NRK49131824', 'Safina Wulandari', 'Bau-Bau', '1981-09-02', 'P', 'Dinas Perhubungan', 'UPT 3', '085863704344', 'uwais.kenes@example.com', 'CPNS', 'Sudah MCU', '2025-08-11', 'Fuga molestiae neque est cum.', '2025-08-13 08:46:50', '2025-08-13 08:46:50'),
	(49, '7662380558386541', 'NRK43119168', 'Safina Vanya Yuniar S.T.', 'Bitung', '1992-07-21', 'P', 'Sekretariat Daerah', 'UPT 5', '084727735338', 'kurniawan.ibun@example.com', 'PNS', 'Belum MCU', NULL, NULL, '2025-08-13 08:46:50', '2025-08-13 08:46:50'),
	(50, '5671777877212962', 'NRK26436183', 'Gaman Daruna Hutapea', 'Jambi', '1972-04-12', 'L', 'Dinas Kesehatan', 'UPT 3', '083925876808', 'yuliarti.jamalia@example.org', 'CPNS', 'Belum MCU', NULL, 'Autem aut ipsum placeat dolores fuga.', '2025-08-13 08:46:50', '2025-08-13 08:46:50'),
	(51, '5318060167737817', 'NRK50207713', 'Padma Wijayanti', 'Bontang', '1985-04-18', 'P', 'Dinas Perhubungan', 'UPT 1', '089798433607', 'wmansur@example.org', 'CPNS', 'Ditolak', '2024-06-20', NULL, '2025-08-13 08:46:50', '2025-08-13 08:46:50'),
	(52, '2962652752823073', 'NRK92283564', 'Elisa Andriani M.M.', 'Bengkulu', '1998-12-09', 'P', 'Dinas Pendidikan', 'UPT 3', '084334930026', 'titi.maryadi@example.com', 'PPPK', 'Ditolak', '2024-01-18', NULL, '2025-08-13 08:46:50', '2025-08-13 08:46:50'),
	(53, '7230177408411760', 'NRK84015818', 'Warsa Kardi Wijaya M.Ak', 'Palopo', '1993-10-04', 'L', 'Dinas Kesehatan', 'UPT 2', '084568261976', 'whutapea@example.net', 'PNS', 'Belum MCU', NULL, 'Maiores earum amet porro vel consequatur excepturi ab.', '2025-08-13 08:46:50', '2025-08-13 08:46:50'),
	(54, '9553690007315752', 'NRK12735822', 'Bakda Anggabaya Suryono M.Pd', 'Langsa', '1991-07-01', 'L', 'Dinas Pendidikan', 'UPT 4', '081440257416', 'fujiati.paulin@example.org', 'PNS', 'Belum MCU', NULL, 'Quaerat eum laboriosam perferendis nostrum possimus.', '2025-08-13 08:46:50', '2025-08-13 08:46:50'),
	(55, '1463004867708596', 'NRK98182142', 'Simon Cengkal Megantara M.Ak', 'Mataram', '1979-12-24', 'L', 'Dinas Perhubungan', 'UPT 4', '085353163751', 'suryatmi.putri@example.net', 'PPPK', 'Sudah MCU', '2025-03-29', NULL, '2025-08-13 08:46:50', '2025-08-13 08:46:50'),
	(56, '1427639639704403', 'NRK28110833', 'Jaeman Prasetyo', 'Binjai', '1999-12-27', 'L', 'Dinas Kesehatan', 'UPT 2', '084017849062', 'swahyuni@example.com', 'PPPK', 'Sudah MCU', '2022-09-01', NULL, '2025-08-13 08:46:50', '2025-08-13 08:46:50'),
	(57, '7425243593126200', 'NRK08757072', 'Nilam Prastuti', 'Tidore Kepulauan', '1990-07-28', 'P', 'Dinas Perhubungan', 'UPT 4', '087976223796', 'edward79@example.net', 'CPNS', 'Ditolak', '2023-07-09', 'Qui architecto sunt reiciendis possimus molestiae.', '2025-08-13 08:46:50', '2025-08-13 08:46:50'),
	(58, '9796411386956570', 'NRK65257448', 'Jaka Firgantoro', 'Pontianak', '1974-03-06', 'L', 'Sekretariat Daerah', 'UPT 3', '084209676713', 'agustina.hana@example.com', 'PNS', 'Sudah MCU', '2024-05-29', NULL, '2025-08-13 08:46:51', '2025-08-13 08:46:51'),
	(59, '1746150384536276', 'NRK43723890', 'Kartika Aurora Wastuti M.Kom.', 'Sukabumi', '1999-06-21', 'P', 'Dinas Kesehatan', 'UPT 5', '083854790005', 'mitra71@example.net', 'PNS', 'Sudah MCU', '2023-04-30', NULL, '2025-08-13 08:46:51', '2025-08-13 08:46:51'),
	(60, '9929078111305214', 'NRK61105780', 'Siti Utami', 'Administrasi Jakarta Pusat', '1991-06-28', 'P', 'Sekretariat Daerah', 'UPT 2', '087390261741', 'kezia29@example.com', 'PNS', 'Sudah MCU', '2021-12-15', NULL, '2025-08-13 08:46:51', '2025-08-13 08:46:51'),
	(61, '8550309481346503', 'NRK43195047', 'Kanda Budiyanto', 'Pagar Alam', '1998-02-25', 'L', 'Bappeda', 'UPT 4', '082384872350', 'cinta.jailani@example.net', 'PNS', 'Belum MCU', NULL, NULL, '2025-08-13 08:46:51', '2025-08-13 08:46:51'),
	(62, '3241837791860119', 'NRK88298597', 'Jane Talia Purwanti M.Farm', 'Probolinggo', '2003-02-01', 'P', 'Sekretariat Daerah', 'UPT 4', '085328831515', 'usamah.wirda@example.net', 'PNS', 'Ditolak', '2024-02-03', 'Saepe aut sequi quis commodi qui illum totam doloremque.', '2025-08-13 08:46:51', '2025-08-13 08:46:51'),
	(63, '2152433574126182', 'NRK34481015', 'Wakiman Ardianto', 'Pekanbaru', '2003-01-23', 'L', 'Dinas Kesehatan', 'UPT 1', '084910444279', 'napitupulu.atmaja@example.org', 'PNS', 'Belum MCU', NULL, 'Nihil commodi ipsum eum vitae.', '2025-08-13 08:46:51', '2025-08-13 08:46:51'),
	(64, '5623600850071463', 'NRK38880761', 'Daniswara Pranowo', 'Bima', '2002-12-19', 'L', 'Bappeda', 'UPT 5', '088747503611', 'nurdiyanti.hilda@example.org', 'PNS', 'Ditolak', '2022-10-20', 'Porro et veniam tempora rerum.', '2025-08-13 08:46:51', '2025-08-13 08:46:51'),
	(65, '7828219596971197', 'NRK16055141', 'Dalima Yunita Andriani M.TI.', 'Lhokseumawe', '1968-01-31', 'P', 'Dinas Pendidikan', 'UPT 4', '087644717627', 'hhassanah@example.net', 'CPNS', 'Ditolak', '2021-10-23', 'Temporibus cupiditate voluptatibus ut fuga a ea nam.', '2025-08-13 08:46:51', '2025-08-13 08:46:51'),
	(66, '2772431632267023', 'NRK91503795', 'Usyi Rahimah', 'Tegal', '1970-07-27', 'P', 'Sekretariat Daerah', 'UPT 5', '085211880309', 'kasim88@example.com', 'PPPK', 'Sudah MCU', '2022-12-31', 'Quia rem consequatur quo natus ipsam numquam eos.', '2025-08-13 08:46:51', '2025-08-13 08:46:51'),
	(67, '5301304688536367', 'NRK94619080', 'Teddy Kadir Maheswara S.I.Kom', 'Subulussalam', '1985-06-16', 'L', 'Dinas Pendidikan', 'UPT 1', '086537021248', 'radika.wibisono@example.net', 'PPPK', 'Sudah MCU', '2025-07-23', NULL, '2025-08-13 08:46:51', '2025-08-13 08:46:51'),
	(68, '5870591780337589', 'NRK98987114', 'Sari Novitasari', 'Batam', '1970-04-28', 'P', 'Sekretariat Daerah', 'UPT 3', '089106397565', 'jarwa27@example.net', 'PPPK', 'Sudah MCU', '2023-06-11', NULL, '2025-08-13 08:46:51', '2025-08-13 08:46:51'),
	(69, '6055973010101101', 'NRK23201887', 'Jaiman Hakim M.Kom.', 'Gunungsitoli', '1979-02-08', 'L', 'Bappeda', 'UPT 1', '080582359878', 'puji48@example.net', 'PPPK', 'Ditolak', '2025-07-09', NULL, '2025-08-13 08:46:51', '2025-08-13 08:46:51'),
	(70, '6140553856692995', 'NRK54962118', 'Rafid Yusuf Rajasa', 'Palangka Raya', '1989-06-27', 'L', 'Dinas Kesehatan', 'UPT 3', '089839996473', 'kwibisono@example.com', 'CPNS', 'Ditolak', '2023-07-16', NULL, '2025-08-13 08:46:51', '2025-08-13 08:46:51'),
	(71, '7516912562627505', 'NRK40779072', 'Clara Vanya Pratiwi S.Psi', 'Tidore Kepulauan', '1998-09-14', 'P', 'Bappeda', 'UPT 5', '082530375157', 'haryanti.okta@example.net', 'PNS', 'Belum MCU', NULL, 'Occaecati voluptatibus rem voluptas adipisci voluptatem molestiae nihil nulla.', '2025-08-13 08:46:51', '2025-08-13 08:46:51'),
	(72, '9825273455739077', 'NRK72429138', 'Kiandra Yuliarti', 'Tarakan', '1968-05-20', 'P', 'Dinas Pendidikan', 'UPT 5', '087244843788', 'virman.prastuti@example.net', 'CPNS', 'Ditolak', '2023-08-25', NULL, '2025-08-13 08:46:51', '2025-08-13 08:46:51'),
	(73, '2251685555336995', 'NRK76962204', 'Winda Oktaviani', 'Serang', '1997-08-10', 'P', 'Dinas Kesehatan', 'UPT 1', '081208296770', 'dyolanda@example.com', 'CPNS', 'Sudah MCU', '2020-11-21', NULL, '2025-08-13 08:46:51', '2025-08-13 08:46:51'),
	(74, '8007501791036941', 'NRK01161946', 'Jessica Anggraini', 'Bekasi', '1968-02-01', 'P', 'Bappeda', 'UPT 5', '085862161731', 'hasan.andriani@example.net', 'PNS', 'Belum MCU', NULL, NULL, '2025-08-13 08:46:51', '2025-08-13 08:46:51'),
	(75, '8790866875776858', 'NRK26478532', 'Aisyah Hassanah S.Ked', 'Tangerang Selatan', '1989-01-23', 'P', 'Dinas Kesehatan', 'UPT 5', '084354471148', 'ldabukke@example.org', 'PPPK', 'Ditolak', '2022-06-15', NULL, '2025-08-13 08:46:51', '2025-08-13 08:46:51'),
	(76, '7624105435477804', 'NRK40664153', 'Sarah Puji Rahayu', 'Banda Aceh', '1972-05-09', 'P', 'Bappeda', 'UPT 3', '081973240623', 'yuniar.ade@example.org', 'PNS', 'Ditolak', '2025-05-19', NULL, '2025-08-13 08:46:51', '2025-08-13 08:46:51'),
	(77, '2136023173819574', 'NRK25007323', 'Dina Gina Riyanti', 'Tual', '1976-04-16', 'P', 'Sekretariat Daerah', 'UPT 3', '088797195585', 'pia05@example.net', 'PPPK', 'Sudah MCU', '2024-03-08', 'Atque iure dolorem cumque nihil qui.', '2025-08-13 08:46:51', '2025-08-13 08:46:51'),
	(78, '2551994489312844', 'NRK33007042', 'Kamila Karen Hartati S.Pd', 'Pagar Alam', '1966-05-21', 'P', 'Sekretariat Daerah', 'UPT 1', '085827683348', 'cawuk52@example.net', 'CPNS', 'Ditolak', '2024-03-18', NULL, '2025-08-13 08:46:51', '2025-08-13 08:46:51'),
	(79, '8847545565983478', 'NRK76276607', 'Dalima Handayani', 'Metro', '1967-08-01', 'P', 'Sekretariat Daerah', 'UPT 4', '086509115930', 'harimurti.nainggolan@example.com', 'CPNS', 'Ditolak', '2020-09-24', NULL, '2025-08-13 08:46:51', '2025-08-13 08:46:51'),
	(80, '8961503034758136', 'NRK25838276', 'Pardi Siregar S.Psi', 'Kendari', '1996-10-14', 'L', 'Bappeda', 'UPT 1', '080882011879', 'kuncara01@example.org', 'CPNS', 'Sudah MCU', '2024-02-05', NULL, '2025-08-13 08:46:51', '2025-08-13 09:56:13'),
	(81, '7944652776035807', 'NRK12845308', 'Elvina Fitriani Astuti', 'Banjarbaru', '2000-07-16', 'P', 'Bappeda', 'UPT 5', '082729688066', 'bwijayanti@example.com', 'PNS', 'Ditolak', '2021-07-19', NULL, '2025-08-13 08:46:51', '2025-08-13 08:46:51'),
	(82, '4138151722140606', 'NRK81687985', 'Nadia Melani', 'Sabang', '1971-08-04', 'P', 'Sekretariat Daerah', 'UPT 1', '084762451434', 'winda.prayoga@example.org', 'PPPK', 'Belum MCU', NULL, NULL, '2025-08-13 08:46:51', '2025-08-13 08:46:51'),
	(83, '5315710316419227', 'NRK78644686', 'Kamaria Hartati', 'Prabumulih', '1972-03-30', 'P', 'Dinas Kesehatan', 'UPT 4', '084591448620', 'kamal14@example.com', 'PNS', 'Belum MCU', NULL, NULL, '2025-08-13 08:46:51', '2025-08-13 08:46:51'),
	(84, '9364925169352287', 'NRK83937589', 'Ana Ophelia Purwanti S.Pd', 'Palangka Raya', '1989-12-10', 'P', 'Bappeda', 'UPT 3', '082954079714', 'respati.januar@example.com', 'PNS', 'Sudah MCU', '2023-07-26', NULL, '2025-08-13 08:46:51', '2025-08-13 08:46:51'),
	(85, '6365966801921426', 'NRK10552819', 'Rama Ardianto', 'Padangsidempuan', '1991-12-27', 'L', 'Bappeda', 'UPT 3', '083766587589', 'radika.farida@example.org', 'PNS', 'Belum MCU', NULL, NULL, '2025-08-13 08:46:51', '2025-08-13 08:46:51'),
	(86, '8515827050115187', 'NRK69163783', 'Asmadi Situmorang', 'Probolinggo', '1999-06-22', 'L', 'Sekretariat Daerah', 'UPT 5', '087378962473', 'dsuartini@example.com', 'PPPK', 'Belum MCU', NULL, NULL, '2025-08-13 08:46:51', '2025-08-13 08:46:51'),
	(87, '2611951714589244', 'NRK04663625', 'Almira Paramita Yuliarti', 'Bontang', '1975-06-07', 'P', 'Sekretariat Daerah', 'UPT 3', '087528170563', 'hidayat.harja@example.org', 'PPPK', 'Sudah MCU', '2025-07-24', NULL, '2025-08-13 08:46:51', '2025-08-13 08:46:51'),
	(88, '0275887696507396', 'NRK57772085', 'Jarwa Purwa Wibowo', 'Banjar', '1975-04-30', 'L', 'Dinas Perhubungan', 'UPT 1', '087959723307', 'rajasa.oni@example.com', 'PPPK', 'Sudah MCU', '2023-09-20', NULL, '2025-08-13 08:46:51', '2025-08-13 08:46:51'),
	(89, '7288843076974262', 'NRK14591960', 'Hesti Wijayanti', 'Cilegon', '1997-11-09', 'P', 'Sekretariat Daerah', 'UPT 4', '082905398286', 'yessi.astuti@example.org', 'PNS', 'Ditolak', '2023-11-06', 'Aliquam laboriosam animi dolore non similique.', '2025-08-13 08:46:51', '2025-08-13 08:46:51'),
	(90, '4758830205723499', 'NRK61384498', 'Rafid Firmansyah', 'Administrasi Jakarta Utara', '1985-08-25', 'L', 'Dinas Pendidikan', 'UPT 2', '085720118604', 'purwanti.sadina@example.com', 'PNS', 'Belum MCU', NULL, NULL, '2025-08-13 08:46:51', '2025-08-13 08:46:51'),
	(91, '7119898900402473', 'NRK33257740', 'Intan Laksmiwati', 'Binjai', '2001-10-20', 'P', 'Dinas Kesehatan', 'UPT 5', '082519419168', 'gmardhiyah@example.com', 'CPNS', 'Belum MCU', NULL, 'Explicabo delectus est sed et iste rerum nostrum id.', '2025-08-13 08:46:51', '2025-08-13 08:46:51'),
	(92, '5355770528344340', 'NRK95364274', 'Ella Cici Hartati S.Kom', 'Banjar', '1968-04-12', 'P', 'Dinas Kesehatan', 'UPT 2', '084668996314', 'hana.wulandari@example.org', 'PNS', 'Belum MCU', NULL, 'Dolorem totam nam occaecati.', '2025-08-13 08:46:51', '2025-08-13 08:46:51'),
	(93, '9171942535508682', 'NRK40202707', 'Jasmin Rini Purwanti', 'Pontianak', '2003-05-20', 'P', 'Sekretariat Daerah', 'UPT 2', '080001446850', 'gmelani@example.org', 'PNS', 'Belum MCU', NULL, 'Voluptatum voluptates ipsa sit quas corrupti.', '2025-08-13 08:46:51', '2025-08-13 08:46:51'),
	(94, '9130826197228707', 'NRK17546181', 'Clara Rahayu', 'Bontang', '1993-05-06', 'P', 'Bappeda', 'UPT 3', '080307323388', 'suryono.intan@example.net', 'PPPK', 'Belum MCU', NULL, NULL, '2025-08-13 08:46:51', '2025-08-13 08:46:51'),
	(95, '9902672505241363', 'NRK38346238', 'Elvin Siregar', 'Administrasi Jakarta Barat', '1995-07-18', 'L', 'Dinas Kesehatan', 'UPT 3', '087075947778', 'dimaz.sihotang@example.org', 'PPPK', 'Ditolak', '2021-03-28', NULL, '2025-08-13 08:46:51', '2025-08-13 08:46:51'),
	(96, '5019741828588474', 'NRK87453346', 'Makara Hutagalung', 'Tual', '1983-03-23', 'L', 'Dinas Pendidikan', 'UPT 1', '080524780468', 'galuh.wahyudin@example.net', 'PPPK', 'Ditolak', '2023-03-31', NULL, '2025-08-13 08:46:51', '2025-08-13 08:46:51'),
	(97, '9559724842276473', 'NRK37615771', 'Liman Marbun S.Psi', 'Subulussalam', '1988-06-12', 'L', 'Dinas Perhubungan', 'UPT 3', '085806850981', 'nasab02@example.org', 'PNS', 'Sudah MCU', '2025-07-27', NULL, '2025-08-13 08:46:51', '2025-08-13 08:46:51'),
	(98, '7378434801741179', 'NRK79165553', 'Anastasia Aryani', 'Pekanbaru', '1993-04-04', 'P', 'Sekretariat Daerah', 'UPT 2', '085186966818', 'yusamah@example.org', 'CPNS', 'Belum MCU', NULL, NULL, '2025-08-13 08:46:51', '2025-08-13 08:46:51'),
	(99, '4146275479564183', 'NRK40842539', 'Almira Haryanti', 'Malang', '1989-01-07', 'P', 'Bappeda', 'UPT 2', '089655281752', 'maras09@example.com', 'PPPK', 'Sudah MCU', '2023-12-15', 'Pariatur debitis molestias tempora dolorem quia.', '2025-08-13 08:46:51', '2025-08-13 08:46:51'),
	(100, '3317344639842535', 'NRK67544897', 'Najib Panji Nababan S.Psi', 'Tangerang Selatan', '2000-05-25', 'L', 'Bappeda', 'UPT 2', '082138833549', 'rwahyuni@example.org', 'PPPK', 'Sudah MCU', '2025-03-23', NULL, '2025-08-13 08:46:51', '2025-08-13 08:46:51'),
	(101, '1010101010101010', '101010', 'Syaiful Islami', 'Gorontalo', '1990-01-01', 'L', 'Dinas Kesehatan', 'PPKP', '08110101010', 'syaiful@gmail.com', 'PNS', 'Belum MCU', NULL, 'Pendaftaran melalui sistem online', '2025-08-13 18:52:31', '2025-08-13 18:52:31');

-- Dumping structure for table monitoring_mcu.password_reset_tokens
DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table monitoring_mcu.password_reset_tokens: ~0 rows (approximately)

-- Dumping structure for table monitoring_mcu.permissions
DROP TABLE IF EXISTS `permissions`;
CREATE TABLE IF NOT EXISTS `permissions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table monitoring_mcu.permissions: ~0 rows (approximately)

-- Dumping structure for table monitoring_mcu.roles
DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table monitoring_mcu.roles: ~0 rows (approximately)

-- Dumping structure for table monitoring_mcu.role_has_permissions
DROP TABLE IF EXISTS `role_has_permissions`;
CREATE TABLE IF NOT EXISTS `role_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `role_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table monitoring_mcu.role_has_permissions: ~0 rows (approximately)

-- Dumping structure for table monitoring_mcu.schedules
DROP TABLE IF EXISTS `schedules`;
CREATE TABLE IF NOT EXISTS `schedules` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `participant_id` bigint unsigned NOT NULL,
  `nik_ktp` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nrk_pegawai` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_lengkap` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `jenis_kelamin` enum('L','P') COLLATE utf8mb4_unicode_ci NOT NULL,
  `skpd` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ukpd` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_telp` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_pemeriksaan` date NOT NULL,
  `jam_pemeriksaan` time NOT NULL,
  `lokasi_pemeriksaan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('Terjadwal','Selesai','Batal','Ditolak') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Terjadwal',
  `queue_number` int unsigned DEFAULT NULL,
  `participant_confirmed` tinyint(1) DEFAULT NULL,
  `participant_confirmed_at` timestamp NULL DEFAULT NULL,
  `reschedule_requested` tinyint(1) NOT NULL DEFAULT '0',
  `reschedule_new_date` date DEFAULT NULL,
  `reschedule_new_time` time DEFAULT NULL,
  `reschedule_reason` text COLLATE utf8mb4_unicode_ci,
  `reschedule_requested_at` timestamp NULL DEFAULT NULL,
  `email_sent` tinyint(1) NOT NULL DEFAULT '0',
  `whatsapp_sent` tinyint(1) NOT NULL DEFAULT '0',
  `email_sent_at` timestamp NULL DEFAULT NULL,
  `whatsapp_sent_at` timestamp NULL DEFAULT NULL,
  `catatan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `schedules_participant_id_foreign` (`participant_id`),
  CONSTRAINT `schedules_participant_id_foreign` FOREIGN KEY (`participant_id`) REFERENCES `participants` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table monitoring_mcu.schedules: ~155 rows (approximately)
REPLACE INTO `schedules` (`id`, `participant_id`, `nik_ktp`, `nrk_pegawai`, `nama_lengkap`, `tanggal_lahir`, `jenis_kelamin`, `skpd`, `ukpd`, `no_telp`, `email`, `tanggal_pemeriksaan`, `jam_pemeriksaan`, `lokasi_pemeriksaan`, `status`, `queue_number`, `participant_confirmed`, `participant_confirmed_at`, `reschedule_requested`, `reschedule_new_date`, `reschedule_new_time`, `reschedule_reason`, `reschedule_requested_at`, `email_sent`, `whatsapp_sent`, `email_sent_at`, `whatsapp_sent_at`, `catatan`, `created_at`, `updated_at`) VALUES
	(1, 1, '1803572186991303', 'NRK12486765', 'Hamima Wulandari', '1999-03-19', 'P', 'Dinas Kesehatan', 'UPT 5', '089126723242', 'rangga55@example.net', '2025-08-26', '06:34:00', 'Klinik Sehat Sentosa', 'Terjadwal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, '2025-08-13 08:54:18', '2025-08-13 08:54:24', NULL, '2025-08-13 08:46:51', '2025-08-13 08:54:24'),
	(2, 2, '4750688855711636', 'NRK24865295', 'Jagaraga Sihombing', '1970-01-29', 'L', 'Bappeda', 'UPT 4', '082693793592', 'gangsa.mangunsong@example.net', '2025-08-14', '14:25:00', 'Klinik Sehat Sentosa', 'Terjadwal', 3, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, '2025-08-13 19:41:53', '2025-08-06 08:46:51', NULL, '2025-08-13 08:46:51', '2025-08-13 19:42:27'),
	(3, 3, '0145121594652218', 'NRK30297563', 'Shakila Uyainah', '1971-07-03', 'P', 'Bappeda', 'UPT 4', '080963324892', 'enovitasari@example.org', '2025-03-06', '22:20:00', 'RS Bakti Husada', 'Selesai', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, 0, '2025-07-31 08:46:51', NULL, NULL, '2025-08-13 08:46:51', '2025-08-13 08:46:51'),
	(4, 6, '2965860775719956', 'NRK45255515', 'Rahmi Zulaika', '1987-11-21', 'P', 'Bappeda', 'UPT 3', '082903477062', 'permata.kanda@example.com', '2025-01-03', '21:56:00', 'RSUD Kota', 'Selesai', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, '2025-08-02 08:46:51', '2025-07-20 08:46:51', 'Atque minima voluptatem a.', '2025-08-13 08:46:51', '2025-08-13 08:46:51'),
	(5, 6, '2965860775719956', 'NRK45255515', 'Rahmi Zulaika', '1987-11-21', 'P', 'Bappeda', 'UPT 3', '082903477062', 'permata.kanda@example.com', '2025-08-21', '07:30:00', 'Klinik Sehat Sentosa', 'Terjadwal', 1, 1, '2025-08-13 20:56:56', 0, NULL, NULL, NULL, NULL, 1, 1, '2025-08-13 19:31:21', '2025-08-13 19:31:26', NULL, '2025-08-13 08:46:51', '2025-09-03 05:55:40'),
	(6, 7, '1859082034842924', 'NRK98814231', 'Prakosa Umay Marpaung S.Gz', '1994-03-07', 'L', 'Dinas Kesehatan', 'UPT 5', '083392194511', 'cdongoran@example.net', '2024-01-27', '13:41:00', 'Klinik Sehat Sentosa', 'Selesai', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, '2025-08-13 08:46:51', '2025-08-13 08:46:51'),
	(7, 9, '2744574512798510', 'NRK06572259', 'Jelita Nurdiyanti', '1987-02-26', 'P', 'Sekretariat Daerah', 'UPT 2', '084881999136', 'msudiati@example.net', '2024-09-16', '15:26:00', 'RS Permata Hati', 'Selesai', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, 0, '2025-08-06 08:46:51', NULL, NULL, '2025-08-13 08:46:51', '2025-08-13 08:46:51'),
	(8, 11, '5172009890707773', 'NRK51247637', 'Timbul Emas Wasita', '1997-04-14', 'L', 'Dinas Kesehatan', 'UPT 4', '086773088165', 'saptono.diana@example.org', '2024-08-26', '08:21:00', 'RS Bakti Husada', 'Selesai', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, '2025-07-30 08:46:51', '2025-07-16 08:46:51', NULL, '2025-08-13 08:46:51', '2025-08-13 08:46:51'),
	(9, 11, '5172009890707773', 'NRK51247637', 'Timbul Emas Wasita', '1997-04-14', 'L', 'Dinas Kesehatan', 'UPT 4', '086773088165', 'saptono.diana@example.org', '2023-10-07', '19:19:00', 'RSUD Kota', 'Selesai', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, 0, '2025-07-30 08:46:51', NULL, NULL, '2025-08-13 08:46:51', '2025-08-13 08:46:51'),
	(10, 11, '5172009890707773', 'NRK51247637', 'Timbul Emas Wasita', '1997-04-14', 'L', 'Dinas Kesehatan', 'UPT 4', '086773088165', 'saptono.diana@example.org', '2025-03-20', '16:03:00', 'Klinik Sehat Sentosa', 'Batal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, 0, '2025-08-08 08:46:51', NULL, NULL, '2025-08-13 08:46:51', '2025-08-13 08:46:51'),
	(11, 12, '3424341757308972', 'NRK15170164', 'Belinda Raisa Laksmiwati S.IP', '1996-04-28', 'P', 'Dinas Perhubungan', 'UPT 1', '080268947064', 'hari56@example.net', '2025-08-19', '07:38:00', 'RS Permata Hati', 'Batal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, '2025-08-13 08:46:51', '2025-08-13 08:46:51'),
	(12, 12, '3424341757308972', 'NRK15170164', 'Belinda Raisa Laksmiwati S.IP', '1996-04-28', 'P', 'Dinas Perhubungan', 'UPT 1', '080268947064', 'hari56@example.net', '2025-09-30', '10:21:00', 'RS Permata Hati', 'Terjadwal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, '2025-08-13 08:46:51', '2025-08-13 08:46:51'),
	(13, 12, '3424341757308972', 'NRK15170164', 'Belinda Raisa Laksmiwati S.IP', '1996-04-28', 'P', 'Dinas Perhubungan', 'UPT 1', '080268947064', 'hari56@example.net', '2025-04-20', '15:35:00', 'RS Permata Hati', 'Batal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, '2025-08-13 08:46:51', '2025-08-13 08:46:51'),
	(14, 13, '7737515738289057', 'NRK81142669', 'Kasiyah Widiastuti', '1988-09-02', 'P', 'Dinas Kesehatan', 'UPT 2', '084470080173', 'laksmiwati.soleh@example.org', '2025-01-16', '02:26:00', 'RS Permata Hati', 'Selesai', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, '2025-08-12 08:46:51', '2025-07-25 08:46:51', NULL, '2025-08-13 08:46:51', '2025-08-13 08:46:51'),
	(15, 13, '7737515738289057', 'NRK81142669', 'Kasiyah Widiastuti', '1988-09-02', 'P', 'Dinas Kesehatan', 'UPT 2', '084470080173', 'laksmiwati.soleh@example.org', '2025-10-08', '13:57:00', 'Klinik Medika Utama', 'Terjadwal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, '2025-08-13 08:46:51', '2025-08-13 08:46:51'),
	(16, 14, '0133938427399663', 'NRK40273080', 'Farah Rahmi Wijayanti S.I.Kom', '1987-06-16', 'P', 'Dinas Perhubungan', 'UPT 3', '088382206509', 'agustina.cahya@example.net', '2025-08-19', '17:12:00', 'Klinik Sehat Sentosa', 'Terjadwal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, 'Quia totam nihil ducimus eveniet voluptatem iusto.', '2025-08-13 08:46:51', '2025-08-13 08:46:51'),
	(17, 16, '6816125867755016', 'NRK85921910', 'Bagas Atmaja Manullang', '1974-02-16', 'L', 'Sekretariat Daerah', 'UPT 1', '085905099772', 'farida.intan@example.net', '2025-10-13', '05:22:00', 'Klinik Sehat Sentosa', 'Terjadwal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, '2025-08-13 08:46:51', '2025-08-13 08:46:51'),
	(18, 16, '6816125867755016', 'NRK85921910', 'Bagas Atmaja Manullang', '1974-02-16', 'L', 'Sekretariat Daerah', 'UPT 1', '085905099772', 'farida.intan@example.net', '2025-12-28', '13:04:00', 'RS Permata Hati', 'Terjadwal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, '2025-08-13 08:46:51', '2025-08-13 08:46:51'),
	(19, 16, '6816125867755016', 'NRK85921910', 'Bagas Atmaja Manullang', '1974-02-16', 'L', 'Sekretariat Daerah', 'UPT 1', '085905099772', 'farida.intan@example.net', '2024-12-11', '02:18:00', 'RSUD Kota', 'Batal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, '2025-07-27 08:46:51', '2025-08-04 08:46:51', NULL, '2025-08-13 08:46:51', '2025-08-13 08:46:51'),
	(20, 17, '9768285423695468', 'NRK40212713', 'Enteng Cengkal Uwais', '1990-03-21', 'L', 'Dinas Perhubungan', 'UPT 2', '088693914964', 'humaira24@example.com', '2024-06-26', '04:25:00', 'RS Permata Hati', 'Selesai', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, '2025-07-18 08:46:51', '2025-08-11 08:46:51', NULL, '2025-08-13 08:46:51', '2025-08-13 08:46:51'),
	(21, 17, '9768285423695468', 'NRK40212713', 'Enteng Cengkal Uwais', '1990-03-21', 'L', 'Dinas Perhubungan', 'UPT 2', '088693914964', 'humaira24@example.com', '2025-10-25', '01:58:00', 'RS Permata Hati', 'Terjadwal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, '2025-08-13 08:46:51', '2025-08-13 08:46:51'),
	(22, 18, '6950626103545027', 'NRK35360876', 'Zizi Lailasari', '1976-03-14', 'P', 'Bappeda', 'UPT 4', '087213495961', 'ega70@example.com', '2024-07-24', '21:56:00', 'RS Permata Hati', 'Selesai', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, '2025-07-16 08:46:51', '2025-08-01 08:46:51', NULL, '2025-08-13 08:46:51', '2025-08-13 08:46:51'),
	(23, 18, '6950626103545027', 'NRK35360876', 'Zizi Lailasari', '1976-03-14', 'P', 'Bappeda', 'UPT 4', '087213495961', 'ega70@example.com', '2025-05-13', '01:19:00', 'RSUD Kota', 'Selesai', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, 0, '2025-08-06 08:46:51', NULL, NULL, '2025-08-13 08:46:51', '2025-08-13 08:46:51'),
	(24, 19, '1102807514169358', 'NRK17915261', 'Victoria Umi Namaga M.Ak', '1981-01-05', 'P', 'Dinas Kesehatan', 'UPT 4', '080501899355', 'karma.latupono@example.net', '2025-04-19', '02:27:00', 'Klinik Medika Utama', 'Selesai', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, '2025-08-13 08:46:52', '2025-08-13 08:46:52'),
	(25, 19, '1102807514169358', 'NRK17915261', 'Victoria Umi Namaga M.Ak', '1981-01-05', 'P', 'Dinas Kesehatan', 'UPT 4', '080501899355', 'karma.latupono@example.net', '2025-05-13', '08:58:00', 'Klinik Medika Utama', 'Selesai', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, '2025-07-29 08:46:52', '2025-07-21 08:46:52', NULL, '2025-08-13 08:46:52', '2025-08-13 08:46:52'),
	(26, 21, '2512288908789703', 'NRK91323602', 'Ophelia Hariyah', '1985-09-08', 'P', 'Sekretariat Daerah', 'UPT 4', '087030909577', 'legawa.laksmiwati@example.net', '2026-01-09', '11:48:00', 'Klinik Medika Utama', 'Terjadwal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, '2025-08-13 08:46:52', '2025-08-13 08:46:52'),
	(27, 21, '2512288908789703', 'NRK91323602', 'Ophelia Hariyah', '1985-09-08', 'P', 'Sekretariat Daerah', 'UPT 4', '087030909577', 'legawa.laksmiwati@example.net', '2024-11-11', '05:18:00', 'RSUD Kota', 'Selesai', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, '2025-07-15 08:46:52', '2025-07-31 08:46:52', 'Minima ipsam sapiente error pariatur nulla.', '2025-08-13 08:46:52', '2025-08-13 08:46:52'),
	(28, 22, '8163473162535045', 'NRK26074258', 'Cakrajiya Ozy Pranowo', '1981-12-13', 'L', 'Dinas Kesehatan', 'UPT 5', '085750190467', 'shania51@example.net', '2026-02-12', '11:56:00', 'Klinik Sehat Sentosa', 'Terjadwal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, '2025-08-13 08:46:52', '2025-08-13 08:46:52'),
	(29, 22, '8163473162535045', 'NRK26074258', 'Cakrajiya Ozy Pranowo', '1981-12-13', 'L', 'Dinas Kesehatan', 'UPT 5', '085750190467', 'shania51@example.net', '2025-10-19', '09:48:00', 'Klinik Medika Utama', 'Terjadwal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, 'Tempora at cupiditate facilis corrupti omnis et.', '2025-08-13 08:46:52', '2025-08-13 08:46:52'),
	(30, 22, '8163473162535045', 'NRK26074258', 'Cakrajiya Ozy Pranowo', '1981-12-13', 'L', 'Dinas Kesehatan', 'UPT 5', '085750190467', 'shania51@example.net', '2025-09-22', '19:51:00', 'Klinik Medika Utama', 'Batal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 1, NULL, '2025-08-13 08:46:52', NULL, '2025-08-13 08:46:52', '2025-08-13 08:46:52'),
	(31, 23, '4630751766780962', 'NRK34928473', 'Aswani Tamba', '1976-04-05', 'L', 'Sekretariat Daerah', 'UPT 1', '087843874574', 'jane.aryani@example.net', '2025-05-12', '00:37:00', 'Klinik Sehat Sentosa', 'Selesai', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, 0, '2025-07-30 08:46:52', NULL, NULL, '2025-08-13 08:46:52', '2025-08-13 08:46:52'),
	(32, 23, '4630751766780962', 'NRK34928473', 'Aswani Tamba', '1976-04-05', 'L', 'Sekretariat Daerah', 'UPT 1', '087843874574', 'jane.aryani@example.net', '2026-01-29', '14:41:00', 'RS Permata Hati', 'Terjadwal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, '2025-08-13 08:46:52', '2025-08-13 08:46:52'),
	(33, 24, '6557299262527972', 'NRK68212038', 'Yance Utami', '1995-04-20', 'P', 'Sekretariat Daerah', 'UPT 2', '089454871647', 'wardi.kuswandari@example.net', '2023-12-12', '20:48:00', 'RS Permata Hati', 'Selesai', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, 0, '2025-08-11 08:46:52', NULL, NULL, '2025-08-13 08:46:52', '2025-08-13 08:46:52'),
	(34, 27, '8331131589012375', 'NRK63183072', 'Mursita Saefullah', '1971-06-15', 'L', 'Sekretariat Daerah', 'UPT 5', '081059138888', 'talia.ardianto@example.com', '2025-09-06', '13:50:00', 'Klinik Sehat Sentosa', 'Terjadwal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, '2025-08-13 08:46:52', '2025-08-13 08:46:52'),
	(35, 28, '8079236002145934', 'NRK14471908', 'Febi Yuliarti S.E.', '1993-10-16', 'P', 'Sekretariat Daerah', 'UPT 1', '083787847038', 'marbun.respati@example.com', '2026-01-15', '19:34:00', 'RS Bakti Husada', 'Terjadwal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, '2025-08-13 08:46:52', '2025-08-13 08:46:52'),
	(36, 28, '8079236002145934', 'NRK14471908', 'Febi Yuliarti S.E.', '1993-10-16', 'P', 'Sekretariat Daerah', 'UPT 1', '083787847038', 'marbun.respati@example.com', '2023-12-26', '22:50:00', 'Klinik Medika Utama', 'Selesai', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, 0, '2025-08-11 08:46:52', NULL, 'Consequatur molestiae alias voluptatem consectetur et commodi ipsa.', '2025-08-13 08:46:52', '2025-08-13 08:46:52'),
	(37, 29, '4554231363668570', 'NRK27044407', 'Purwadi Hardiansyah S.Psi', '1968-03-18', 'L', 'Dinas Pendidikan', 'UPT 1', '085312825609', 'wibowo.gilang@example.org', '2024-10-23', '10:50:00', 'Klinik Medika Utama', 'Selesai', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, '2025-07-24 08:46:52', '2025-08-11 08:46:52', NULL, '2025-08-13 08:46:52', '2025-08-13 08:46:52'),
	(38, 29, '4554231363668570', 'NRK27044407', 'Purwadi Hardiansyah S.Psi', '1968-03-18', 'L', 'Dinas Pendidikan', 'UPT 1', '085312825609', 'wibowo.gilang@example.org', '2026-01-19', '15:47:00', 'Klinik Sehat Sentosa', 'Terjadwal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, '2025-08-13 08:46:52', '2025-08-13 08:46:52'),
	(39, 30, '7551274122099691', 'NRK08715018', 'Kartika Sudiati', '1973-03-08', 'P', 'Sekretariat Daerah', 'UPT 4', '080558988414', 'hasta.lailasari@example.com', '2025-02-19', '07:32:00', 'Klinik Medika Utama', 'Selesai', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, '2025-07-16 08:46:52', '2025-07-21 08:46:52', NULL, '2025-08-13 08:46:52', '2025-08-13 08:46:52'),
	(40, 31, '5066226508621651', 'NRK79380587', 'Humaira Nasyidah', '1984-07-28', 'P', 'Bappeda', 'UPT 2', '087886138212', 'zaenab.lestari@example.net', '2025-09-19', '10:27:00', 'Klinik Sehat Sentosa', 'Batal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 1, NULL, '2025-08-08 08:46:52', NULL, '2025-08-13 08:46:52', '2025-08-13 08:46:52'),
	(41, 31, '5066226508621651', 'NRK79380587', 'Humaira Nasyidah', '1984-07-28', 'P', 'Bappeda', 'UPT 2', '087886138212', 'zaenab.lestari@example.net', '2025-12-28', '01:30:00', 'Klinik Sehat Sentosa', 'Terjadwal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, 'Et assumenda corrupti rem earum nobis qui aspernatur.', '2025-08-13 08:46:52', '2025-08-13 08:46:52'),
	(42, 32, '4777846071634880', 'NRK13257485', 'Yuliana Puspasari', '1999-06-03', 'P', 'Dinas Perhubungan', 'UPT 1', '085994620620', 'carla41@example.net', '2025-06-17', '19:21:00', 'RS Permata Hati', 'Batal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, '2025-08-03 08:46:52', '2025-07-17 08:46:52', NULL, '2025-08-13 08:46:52', '2025-08-13 08:46:52'),
	(43, 32, '4777846071634880', 'NRK13257485', 'Yuliana Puspasari', '1999-06-03', 'P', 'Dinas Perhubungan', 'UPT 1', '085994620620', 'carla41@example.net', '2026-02-03', '00:37:00', 'Klinik Sehat Sentosa', 'Terjadwal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, '2025-08-13 08:46:52', '2025-08-13 08:46:52'),
	(44, 32, '4777846071634880', 'NRK13257485', 'Yuliana Puspasari', '1999-06-03', 'P', 'Dinas Perhubungan', 'UPT 1', '085994620620', 'carla41@example.net', '2024-05-05', '21:58:00', 'RSUD Kota', 'Selesai', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, '2025-08-05 08:46:52', '2025-07-14 08:46:52', 'Nisi ut aut quis esse rerum unde porro.', '2025-08-13 08:46:52', '2025-08-13 08:46:52'),
	(45, 33, '8824109332171244', 'NRK24415333', 'Tami Laksita S.Psi', '1997-03-18', 'P', 'Dinas Kesehatan', 'UPT 2', '080149248203', 'dmaryadi@example.com', '2024-09-07', '23:20:00', 'Klinik Medika Utama', 'Batal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, '2025-07-15 08:46:52', '2025-08-02 08:46:52', NULL, '2025-08-13 08:46:52', '2025-08-13 08:46:52'),
	(46, 33, '8824109332171244', 'NRK24415333', 'Tami Laksita S.Psi', '1997-03-18', 'P', 'Dinas Kesehatan', 'UPT 2', '080149248203', 'dmaryadi@example.com', '2025-10-23', '09:24:00', 'Klinik Medika Utama', 'Terjadwal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, '2025-08-13 08:46:52', '2025-08-13 08:46:52'),
	(47, 33, '8824109332171244', 'NRK24415333', 'Tami Laksita S.Psi', '1997-03-18', 'P', 'Dinas Kesehatan', 'UPT 2', '080149248203', 'dmaryadi@example.com', '2025-03-05', '11:00:00', 'RSUD Kota', 'Selesai', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, 0, '2025-08-02 08:46:52', NULL, NULL, '2025-08-13 08:46:52', '2025-08-13 08:46:52'),
	(48, 34, '2757805117927443', 'NRK99117391', 'Unggul Galih Samosir', '1984-03-19', 'L', 'Dinas Kesehatan', 'UPT 3', '085356773757', 'cinthia.prasetya@example.org', '2025-02-04', '21:38:00', 'RS Bakti Husada', 'Selesai', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, '2025-07-27 08:46:52', '2025-08-01 08:46:52', 'Voluptatem vero nesciunt nihil commodi magni ea.', '2025-08-13 08:46:52', '2025-08-13 08:46:52'),
	(49, 36, '6657932786049089', 'NRK56306342', 'Mahmud Hari Saptono S.Farm', '2004-01-15', 'L', 'Dinas Pendidikan', 'UPT 1', '082712146905', 'varyani@example.net', '2025-07-21', '20:36:00', 'RS Bakti Husada', 'Batal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, '2025-08-03 08:46:52', '2025-08-13 08:46:52', 'Veniam sit quam et doloremque eum iure aut.', '2025-08-13 08:46:52', '2025-08-13 08:46:52'),
	(50, 37, '7478163969041027', 'NRK31951550', 'Vanesa Prastuti', '1969-12-14', 'P', 'Bappeda', 'UPT 2', '087571265415', 'tkusumo@example.net', '2024-05-30', '09:49:00', 'Klinik Medika Utama', 'Selesai', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, '2025-08-11 08:46:52', '2025-08-05 08:46:52', NULL, '2025-08-13 08:46:52', '2025-08-13 08:46:52'),
	(51, 37, '7478163969041027', 'NRK31951550', 'Vanesa Prastuti', '1969-12-14', 'P', 'Bappeda', 'UPT 2', '087571265415', 'tkusumo@example.net', '2025-10-14', '09:26:00', 'RS Bakti Husada', 'Terjadwal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, '2025-08-13 08:46:52', '2025-08-13 08:46:52'),
	(52, 38, '3170151757154546', 'NRK08729491', 'Lanjar Jayeng Anggriawan', '1968-09-12', 'L', 'Dinas Perhubungan', 'UPT 1', '089027105271', 'jaswadi27@example.org', '2025-05-22', '06:16:00', 'RS Permata Hati', 'Selesai', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, '2025-08-12 08:46:52', '2025-07-17 08:46:52', NULL, '2025-08-13 08:46:52', '2025-08-13 08:46:52'),
	(53, 39, '0198868421434874', 'NRK11020325', 'Vero Cakrawangsa Siregar S.E.I', '1996-08-26', 'L', 'Sekretariat Daerah', 'UPT 3', '089314595921', 'wisnu30@example.com', '2025-10-13', '13:06:00', 'Klinik Medika Utama', 'Terjadwal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, 'Sed sit doloribus itaque nesciunt molestiae.', '2025-08-13 08:46:52', '2025-08-13 08:46:52'),
	(54, 39, '0198868421434874', 'NRK11020325', 'Vero Cakrawangsa Siregar S.E.I', '1996-08-26', 'L', 'Sekretariat Daerah', 'UPT 3', '089314595921', 'wisnu30@example.com', '2026-01-23', '14:00:00', 'RS Bakti Husada', 'Terjadwal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, '2025-08-13 08:46:52', '2025-08-13 08:46:52'),
	(55, 39, '0198868421434874', 'NRK11020325', 'Vero Cakrawangsa Siregar S.E.I', '1996-08-26', 'L', 'Sekretariat Daerah', 'UPT 3', '089314595921', 'wisnu30@example.com', '2024-01-15', '15:12:00', 'RS Bakti Husada', 'Selesai', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, '2025-08-13 08:46:52', '2025-08-13 08:46:52'),
	(56, 40, '1369793517685484', 'NRK83467225', 'Baktiadi Mulya Suryono', '1969-07-25', 'L', 'Bappeda', 'UPT 1', '089812356530', 'tsalahudin@example.org', '2025-10-09', '01:15:00', 'Klinik Sehat Sentosa', 'Terjadwal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, '2025-08-13 08:46:52', '2025-08-13 08:46:52'),
	(57, 41, '7609099578474789', 'NRK05541560', 'Jagapati Jarwadi Januar S.H.', '1997-08-22', 'L', 'Dinas Kesehatan', 'UPT 3', '088978264603', 'puput01@example.com', '2025-09-12', '06:25:00', 'Klinik Sehat Sentosa', 'Batal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, 0, '2025-07-20 08:46:52', NULL, NULL, '2025-08-13 08:46:52', '2025-08-13 08:46:52'),
	(58, 41, '7609099578474789', 'NRK05541560', 'Jagapati Jarwadi Januar S.H.', '1997-08-22', 'L', 'Dinas Kesehatan', 'UPT 3', '088978264603', 'puput01@example.com', '2024-12-08', '06:49:00', 'Klinik Medika Utama', 'Batal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, 0, '2025-07-22 08:46:52', NULL, NULL, '2025-08-13 08:46:52', '2025-08-13 08:46:52'),
	(59, 43, '7151846974735817', 'NRK61761633', 'Rina Zulaika', '1976-05-27', 'P', 'Sekretariat Daerah', 'UPT 1', '085619018401', 'samiah25@example.net', '2025-03-18', '00:52:00', 'Klinik Sehat Sentosa', 'Selesai', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, '2025-08-03 08:46:52', '2025-08-10 08:46:52', NULL, '2025-08-13 08:46:52', '2025-08-13 08:46:52'),
	(60, 43, '7151846974735817', 'NRK61761633', 'Rina Zulaika', '1976-05-27', 'P', 'Sekretariat Daerah', 'UPT 1', '085619018401', 'samiah25@example.net', '2023-09-02', '19:22:00', 'Klinik Medika Utama', 'Selesai', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 1, NULL, '2025-07-20 08:46:52', NULL, '2025-08-13 08:46:52', '2025-08-13 08:46:52'),
	(61, 47, '2924932391990677', 'NRK40422637', 'Kani Padmasari M.Farm', '1966-12-18', 'P', 'Sekretariat Daerah', 'UPT 1', '082444288098', 'widiastuti.kambali@example.net', '2025-04-30', '06:52:00', 'RS Permata Hati', 'Selesai', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, '2025-08-09 08:46:52', '2025-08-05 08:46:52', NULL, '2025-08-13 08:46:52', '2025-08-13 08:46:52'),
	(62, 48, '3951011172408191', 'NRK49131824', 'Safina Wulandari', '1981-09-02', 'P', 'Dinas Perhubungan', 'UPT 3', '085863704344', 'uwais.kenes@example.com', '2024-11-25', '20:38:00', 'RS Permata Hati', 'Selesai', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, '2025-07-16 08:46:52', '2025-08-05 08:46:52', NULL, '2025-08-13 08:46:52', '2025-08-13 08:46:52'),
	(63, 48, '3951011172408191', 'NRK49131824', 'Safina Wulandari', '1981-09-02', 'P', 'Dinas Perhubungan', 'UPT 3', '085863704344', 'uwais.kenes@example.com', '2024-06-10', '13:05:00', 'Klinik Medika Utama', 'Selesai', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 1, NULL, '2025-07-27 08:46:52', 'Quidem aut hic sit ut excepturi facere maxime.', '2025-08-13 08:46:52', '2025-08-13 08:46:52'),
	(64, 48, '3951011172408191', 'NRK49131824', 'Safina Wulandari', '1981-09-02', 'P', 'Dinas Perhubungan', 'UPT 3', '085863704344', 'uwais.kenes@example.com', '2025-12-03', '08:39:00', 'Klinik Medika Utama', 'Terjadwal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, '2025-08-13 08:46:52', '2025-08-13 08:46:52'),
	(65, 49, '7662380558386541', 'NRK43119168', 'Safina Vanya Yuniar S.T.', '1992-07-21', 'P', 'Sekretariat Daerah', 'UPT 5', '084727735338', 'kurniawan.ibun@example.com', '2024-12-15', '14:41:00', 'RSUD Kota', 'Selesai', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 1, NULL, '2025-07-18 08:46:52', NULL, '2025-08-13 08:46:52', '2025-08-13 08:46:52'),
	(66, 49, '7662380558386541', 'NRK43119168', 'Safina Vanya Yuniar S.T.', '1992-07-21', 'P', 'Sekretariat Daerah', 'UPT 5', '084727735338', 'kurniawan.ibun@example.com', '2023-11-19', '04:01:00', 'RS Bakti Husada', 'Selesai', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 1, NULL, '2025-08-11 08:46:52', NULL, '2025-08-13 08:46:52', '2025-08-13 08:46:52'),
	(67, 49, '7662380558386541', 'NRK43119168', 'Safina Vanya Yuniar S.T.', '1992-07-21', 'P', 'Sekretariat Daerah', 'UPT 5', '084727735338', 'kurniawan.ibun@example.com', '2024-10-16', '11:16:00', 'RS Bakti Husada', 'Selesai', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, 0, '2025-08-01 08:46:52', NULL, 'Eum aspernatur unde minus quas.', '2025-08-13 08:46:52', '2025-08-13 08:46:52'),
	(68, 50, '5671777877212962', 'NRK26436183', 'Gaman Daruna Hutapea', '1972-04-12', 'L', 'Dinas Kesehatan', 'UPT 3', '083925876808', 'yuliarti.jamalia@example.org', '2023-11-27', '20:43:00', 'RS Bakti Husada', 'Selesai', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, '2025-08-03 08:46:52', '2025-07-26 08:46:52', NULL, '2025-08-13 08:46:52', '2025-08-13 08:46:52'),
	(69, 50, '5671777877212962', 'NRK26436183', 'Gaman Daruna Hutapea', '1972-04-12', 'L', 'Dinas Kesehatan', 'UPT 3', '083925876808', 'yuliarti.jamalia@example.org', '2025-09-26', '12:48:00', 'RS Permata Hati', 'Terjadwal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, '2025-08-13 08:46:52', '2025-08-13 08:46:52'),
	(70, 50, '5671777877212962', 'NRK26436183', 'Gaman Daruna Hutapea', '1972-04-12', 'L', 'Dinas Kesehatan', 'UPT 3', '083925876808', 'yuliarti.jamalia@example.org', '2025-05-12', '15:45:00', 'RSUD Kota', 'Selesai', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, '2025-07-22 08:46:52', '2025-08-02 08:46:52', 'Aut recusandae provident repellat voluptatem iure architecto.', '2025-08-13 08:46:52', '2025-08-13 08:46:52'),
	(71, 52, '2962652752823073', 'NRK92283564', 'Elisa Andriani M.M.', '1998-12-09', 'P', 'Dinas Pendidikan', 'UPT 3', '084334930026', 'titi.maryadi@example.com', '2025-09-22', '00:43:00', 'RSUD Kota', 'Terjadwal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, '2025-08-13 08:46:52', '2025-08-13 08:46:52'),
	(72, 52, '2962652752823073', 'NRK92283564', 'Elisa Andriani M.M.', '1998-12-09', 'P', 'Dinas Pendidikan', 'UPT 3', '084334930026', 'titi.maryadi@example.com', '2025-10-29', '11:31:00', 'RS Bakti Husada', 'Terjadwal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, '2025-08-13 08:46:52', '2025-08-13 08:46:52'),
	(73, 52, '2962652752823073', 'NRK92283564', 'Elisa Andriani M.M.', '1998-12-09', 'P', 'Dinas Pendidikan', 'UPT 3', '084334930026', 'titi.maryadi@example.com', '2023-09-12', '00:43:00', 'Klinik Sehat Sentosa', 'Selesai', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, '2025-08-09 08:46:52', '2025-07-30 08:46:52', NULL, '2025-08-13 08:46:52', '2025-08-13 08:46:52'),
	(74, 54, '9553690007315752', 'NRK12735822', 'Bakda Anggabaya Suryono M.Pd', '1991-07-01', 'L', 'Dinas Pendidikan', 'UPT 4', '081440257416', 'fujiati.paulin@example.org', '2024-09-25', '21:57:00', 'RS Bakti Husada', 'Batal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 1, NULL, '2025-08-07 08:46:52', NULL, '2025-08-13 08:46:52', '2025-08-13 08:46:52'),
	(75, 55, '1463004867708596', 'NRK98182142', 'Simon Cengkal Megantara M.Ak', '1979-12-24', 'L', 'Dinas Perhubungan', 'UPT 4', '085353163751', 'suryatmi.putri@example.net', '2025-01-30', '18:45:00', 'RS Permata Hati', 'Selesai', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 1, NULL, '2025-08-13 08:46:52', 'Id expedita ipsum dolorem deleniti quo sapiente aut.', '2025-08-13 08:46:52', '2025-08-13 08:46:52'),
	(76, 55, '1463004867708596', 'NRK98182142', 'Simon Cengkal Megantara M.Ak', '1979-12-24', 'L', 'Dinas Perhubungan', 'UPT 4', '085353163751', 'suryatmi.putri@example.net', '2025-01-29', '13:31:00', 'Klinik Medika Utama', 'Selesai', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, 0, '2025-07-14 08:46:52', NULL, NULL, '2025-08-13 08:46:52', '2025-08-13 08:46:52'),
	(77, 58, '9796411386956570', 'NRK65257448', 'Jaka Firgantoro', '1974-03-06', 'L', 'Sekretariat Daerah', 'UPT 3', '084209676713', 'agustina.hana@example.com', '2025-08-15', '20:29:00', 'RSUD Kota', 'Terjadwal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, '2025-08-13 08:46:52', '2025-08-13 08:46:52'),
	(78, 58, '9796411386956570', 'NRK65257448', 'Jaka Firgantoro', '1974-03-06', 'L', 'Sekretariat Daerah', 'UPT 3', '084209676713', 'agustina.hana@example.com', '2026-02-06', '08:59:00', 'RS Permata Hati', 'Terjadwal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, '2025-08-13 08:46:52', '2025-08-13 08:46:52'),
	(79, 58, '9796411386956570', 'NRK65257448', 'Jaka Firgantoro', '1974-03-06', 'L', 'Sekretariat Daerah', 'UPT 3', '084209676713', 'agustina.hana@example.com', '2024-05-22', '15:27:00', 'RSUD Kota', 'Selesai', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, '2025-08-10 08:46:52', '2025-08-04 08:46:52', NULL, '2025-08-13 08:46:52', '2025-08-13 08:46:52'),
	(80, 59, '1746150384536276', 'NRK43723890', 'Kartika Aurora Wastuti M.Kom.', '1999-06-21', 'P', 'Dinas Kesehatan', 'UPT 5', '083854790005', 'mitra71@example.net', '2026-02-04', '13:40:00', 'RSUD Kota', 'Terjadwal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, '2025-08-13 08:46:52', '2025-08-13 08:46:52'),
	(81, 59, '1746150384536276', 'NRK43723890', 'Kartika Aurora Wastuti M.Kom.', '1999-06-21', 'P', 'Dinas Kesehatan', 'UPT 5', '083854790005', 'mitra71@example.net', '2026-01-31', '22:21:00', 'Klinik Medika Utama', 'Terjadwal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, '2025-08-13 08:46:52', '2025-08-13 08:46:52'),
	(82, 59, '1746150384536276', 'NRK43723890', 'Kartika Aurora Wastuti M.Kom.', '1999-06-21', 'P', 'Dinas Kesehatan', 'UPT 5', '083854790005', 'mitra71@example.net', '2025-08-05', '07:33:00', 'RSUD Kota', 'Batal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, '2025-07-14 08:46:52', '2025-08-05 08:46:52', NULL, '2025-08-13 08:46:52', '2025-08-13 08:46:52'),
	(83, 60, '9929078111305214', 'NRK61105780', 'Siti Utami', '1991-06-28', 'P', 'Sekretariat Daerah', 'UPT 2', '087390261741', 'kezia29@example.com', '2025-06-24', '06:56:00', 'RS Permata Hati', 'Selesai', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 1, NULL, '2025-08-11 08:46:52', NULL, '2025-08-13 08:46:52', '2025-08-13 08:46:52'),
	(84, 60, '9929078111305214', 'NRK61105780', 'Siti Utami', '1991-06-28', 'P', 'Sekretariat Daerah', 'UPT 2', '087390261741', 'kezia29@example.com', '2025-08-27', '22:50:00', 'RS Permata Hati', 'Terjadwal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, '2025-08-13 08:46:52', '2025-08-13 08:46:52'),
	(85, 60, '9929078111305214', 'NRK61105780', 'Siti Utami', '1991-06-28', 'P', 'Sekretariat Daerah', 'UPT 2', '087390261741', 'kezia29@example.com', '2023-10-12', '21:10:00', 'Klinik Sehat Sentosa', 'Selesai', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, '2025-08-13 08:46:52', '2025-08-07 08:46:52', NULL, '2025-08-13 08:46:52', '2025-08-13 08:46:52'),
	(86, 62, '3241837791860119', 'NRK88298597', 'Jane Talia Purwanti M.Farm', '2003-02-01', 'P', 'Sekretariat Daerah', 'UPT 4', '085328831515', 'usamah.wirda@example.net', '2024-01-12', '05:26:00', 'RSUD Kota', 'Selesai', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, '2025-08-03 08:46:52', '2025-07-30 08:46:52', NULL, '2025-08-13 08:46:52', '2025-08-13 08:46:52'),
	(87, 63, '2152433574126182', 'NRK34481015', 'Wakiman Ardianto', '2003-01-23', 'L', 'Dinas Kesehatan', 'UPT 1', '084910444279', 'napitupulu.atmaja@example.org', '2024-09-07', '10:00:00', 'RS Permata Hati', 'Selesai', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, '2025-07-23 08:46:52', '2025-07-16 08:46:52', NULL, '2025-08-13 08:46:52', '2025-08-13 08:46:52'),
	(88, 63, '2152433574126182', 'NRK34481015', 'Wakiman Ardianto', '2003-01-23', 'L', 'Dinas Kesehatan', 'UPT 1', '084910444279', 'napitupulu.atmaja@example.org', '2025-04-01', '02:23:00', 'RS Bakti Husada', 'Selesai', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, '2025-07-20 08:46:52', '2025-07-21 08:46:52', 'Iure voluptatem quibusdam soluta expedita saepe voluptates consequatur reiciendis.', '2025-08-13 08:46:52', '2025-08-13 08:46:52'),
	(89, 64, '5623600850071463', 'NRK38880761', 'Daniswara Pranowo', '2002-12-19', 'L', 'Bappeda', 'UPT 5', '088747503611', 'nurdiyanti.hilda@example.org', '2023-12-11', '12:04:00', 'Klinik Sehat Sentosa', 'Selesai', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, 0, '2025-08-07 08:46:52', NULL, NULL, '2025-08-13 08:46:52', '2025-08-13 08:46:52'),
	(90, 64, '5623600850071463', 'NRK38880761', 'Daniswara Pranowo', '2002-12-19', 'L', 'Bappeda', 'UPT 5', '088747503611', 'nurdiyanti.hilda@example.org', '2023-11-23', '10:42:00', 'RS Bakti Husada', 'Selesai', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 1, NULL, '2025-07-19 08:46:52', NULL, '2025-08-13 08:46:52', '2025-08-13 08:46:52'),
	(91, 65, '7828219596971197', 'NRK16055141', 'Dalima Yunita Andriani M.TI.', '1968-01-31', 'P', 'Dinas Pendidikan', 'UPT 4', '087644717627', 'hhassanah@example.net', '2025-09-10', '23:24:00', 'Klinik Medika Utama', 'Terjadwal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, '2025-08-13 08:46:52', '2025-08-13 08:46:52'),
	(92, 67, '5301304688536367', 'NRK94619080', 'Teddy Kadir Maheswara S.I.Kom', '1985-06-16', 'L', 'Dinas Pendidikan', 'UPT 1', '086537021248', 'radika.wibisono@example.net', '2025-12-30', '22:02:00', 'Klinik Sehat Sentosa', 'Terjadwal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, 'Aliquid aliquid expedita consectetur.', '2025-08-13 08:46:52', '2025-08-13 08:46:52'),
	(93, 69, '6055973010101101', 'NRK23201887', 'Jaiman Hakim M.Kom.', '1979-02-08', 'L', 'Bappeda', 'UPT 1', '080582359878', 'puji48@example.net', '2025-08-03', '17:14:00', 'RS Bakti Husada', 'Batal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, 0, '2025-07-27 08:46:52', NULL, NULL, '2025-08-13 08:46:52', '2025-08-13 08:46:52'),
	(94, 70, '6140553856692995', 'NRK54962118', 'Rafid Yusuf Rajasa', '1989-06-27', 'L', 'Dinas Kesehatan', 'UPT 3', '089839996473', 'kwibisono@example.com', '2025-11-29', '11:44:00', 'RS Permata Hati', 'Terjadwal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, '2025-08-13 08:46:52', '2025-08-13 08:46:52'),
	(95, 70, '6140553856692995', 'NRK54962118', 'Rafid Yusuf Rajasa', '1989-06-27', 'L', 'Dinas Kesehatan', 'UPT 3', '089839996473', 'kwibisono@example.com', '2024-01-02', '12:01:00', 'RSUD Kota', 'Selesai', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 1, NULL, '2025-07-15 08:46:52', 'Corrupti vel nihil fugiat.', '2025-08-13 08:46:52', '2025-08-13 08:46:52'),
	(96, 70, '6140553856692995', 'NRK54962118', 'Rafid Yusuf Rajasa', '1989-06-27', 'L', 'Dinas Kesehatan', 'UPT 3', '089839996473', 'kwibisono@example.com', '2025-06-16', '11:18:00', 'RS Bakti Husada', 'Batal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, '2025-08-06 08:46:52', '2025-08-07 08:46:52', NULL, '2025-08-13 08:46:52', '2025-08-13 08:46:52'),
	(97, 71, '7516912562627505', 'NRK40779072', 'Clara Vanya Pratiwi S.Psi', '1998-09-14', 'P', 'Bappeda', 'UPT 5', '082530375157', 'haryanti.okta@example.net', '2025-12-29', '16:25:00', 'RSUD Kota', 'Terjadwal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, '2025-08-13 08:46:53', '2025-08-13 08:46:53'),
	(98, 71, '7516912562627505', 'NRK40779072', 'Clara Vanya Pratiwi S.Psi', '1998-09-14', 'P', 'Bappeda', 'UPT 5', '082530375157', 'haryanti.okta@example.net', '2024-06-05', '06:56:00', 'RS Bakti Husada', 'Selesai', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, '2025-07-26 08:46:53', '2025-08-05 08:46:53', NULL, '2025-08-13 08:46:53', '2025-08-13 08:46:53'),
	(99, 72, '9825273455739077', 'NRK72429138', 'Kiandra Yuliarti', '1968-05-20', 'P', 'Dinas Pendidikan', 'UPT 5', '087244843788', 'virman.prastuti@example.net', '2025-02-04', '07:00:00', 'RSUD Kota', 'Batal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, '2025-07-22 08:46:53', '2025-07-31 08:46:53', NULL, '2025-08-13 08:46:53', '2025-08-13 08:46:53'),
	(100, 72, '9825273455739077', 'NRK72429138', 'Kiandra Yuliarti', '1968-05-20', 'P', 'Dinas Pendidikan', 'UPT 5', '087244843788', 'virman.prastuti@example.net', '2025-11-24', '01:45:00', 'Klinik Sehat Sentosa', 'Terjadwal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, '2025-08-13 08:46:53', '2025-08-13 08:46:53'),
	(101, 72, '9825273455739077', 'NRK72429138', 'Kiandra Yuliarti', '1968-05-20', 'P', 'Dinas Pendidikan', 'UPT 5', '087244843788', 'virman.prastuti@example.net', '2025-09-03', '07:19:00', 'Klinik Sehat Sentosa', 'Terjadwal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, '2025-09-03 05:59:43', '2025-09-03 05:59:37', NULL, '2025-08-13 08:46:53', '2025-09-03 05:59:43'),
	(102, 73, '2251685555336995', 'NRK76962204', 'Winda Oktaviani', '1997-08-10', 'P', 'Dinas Kesehatan', 'UPT 1', '081208296770', 'dyolanda@example.com', '2025-08-20', '04:13:00', 'RSUD Kota', 'Terjadwal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, '2025-08-13 08:46:53', '2025-08-13 08:46:53'),
	(103, 73, '2251685555336995', 'NRK76962204', 'Winda Oktaviani', '1997-08-10', 'P', 'Dinas Kesehatan', 'UPT 1', '081208296770', 'dyolanda@example.com', '2024-05-03', '21:15:00', 'RS Permata Hati', 'Selesai', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, 0, '2025-07-19 08:46:53', NULL, NULL, '2025-08-13 08:46:53', '2025-08-13 08:46:53'),
	(104, 76, '7624105435477804', 'NRK40664153', 'Sarah Puji Rahayu', '1972-05-09', 'P', 'Bappeda', 'UPT 3', '081973240623', 'yuniar.ade@example.org', '2024-07-05', '00:57:00', 'Klinik Medika Utama', 'Selesai', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 1, NULL, '2025-08-10 08:46:53', NULL, '2025-08-13 08:46:53', '2025-08-13 08:46:53'),
	(105, 76, '7624105435477804', 'NRK40664153', 'Sarah Puji Rahayu', '1972-05-09', 'P', 'Bappeda', 'UPT 3', '081973240623', 'yuniar.ade@example.org', '2024-03-04', '04:18:00', 'RSUD Kota', 'Selesai', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, '2025-07-14 08:46:53', '2025-08-09 08:46:53', NULL, '2025-08-13 08:46:53', '2025-08-13 08:46:53'),
	(106, 77, '2136023173819574', 'NRK25007323', 'Dina Gina Riyanti', '1976-04-16', 'P', 'Sekretariat Daerah', 'UPT 3', '088797195585', 'pia05@example.net', '2025-05-29', '19:05:00', 'Klinik Sehat Sentosa', 'Selesai', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, 0, '2025-07-29 08:46:53', NULL, NULL, '2025-08-13 08:46:53', '2025-08-13 08:46:53'),
	(107, 79, '8847545565983478', 'NRK76276607', 'Dalima Handayani', '1967-08-01', 'P', 'Sekretariat Daerah', 'UPT 4', '086509115930', 'harimurti.nainggolan@example.com', '2024-08-20', '23:32:00', 'RS Bakti Husada', 'Selesai', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, '2025-08-08 08:46:53', '2025-07-25 08:46:53', NULL, '2025-08-13 08:46:53', '2025-08-13 08:46:53'),
	(108, 79, '8847545565983478', 'NRK76276607', 'Dalima Handayani', '1967-08-01', 'P', 'Sekretariat Daerah', 'UPT 4', '086509115930', 'harimurti.nainggolan@example.com', '2025-08-17', '02:54:00', 'RSUD Kota', 'Terjadwal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, '2025-08-13 08:46:53', '2025-08-13 08:46:53'),
	(109, 79, '8847545565983478', 'NRK76276607', 'Dalima Handayani', '1967-08-01', 'P', 'Sekretariat Daerah', 'UPT 4', '086509115930', 'harimurti.nainggolan@example.com', '2025-09-15', '07:30:00', 'RSUD Kota', 'Terjadwal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, '2025-08-13 08:46:53', '2025-08-13 08:46:53'),
	(110, 80, '8961503034758136', 'NRK25838276', 'Pardi Siregar S.Psi', '1996-10-14', 'L', 'Bappeda', 'UPT 1', '080882011879', 'kuncara01@example.org', '2024-11-22', '17:32:00', 'RS Bakti Husada', 'Selesai', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 1, NULL, '2025-08-06 08:46:53', NULL, '2025-08-13 08:46:53', '2025-08-13 08:46:53'),
	(111, 80, '8961503034758136', 'NRK25838276', 'Pardi Siregar S.Psi', '1996-10-14', 'L', 'Bappeda', 'UPT 1', '080882011879', 'kuncara01@example.org', '2023-10-02', '18:37:00', 'RSUD Kota', 'Selesai', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 1, NULL, '2025-08-03 08:46:53', NULL, '2025-08-13 08:46:53', '2025-08-13 08:46:53'),
	(112, 80, '8961503034758136', 'NRK25838276', 'Pardi Siregar S.Psi', '1996-10-14', 'L', 'Bappeda', 'UPT 1', '080882011879', 'kuncara01@example.org', '2025-11-26', '08:32:00', 'Klinik Medika Utama', 'Terjadwal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, '2025-08-13 08:46:53', '2025-08-13 08:46:53'),
	(113, 81, '7944652776035807', 'NRK12845308', 'Elvina Fitriani Astuti', '2000-07-16', 'P', 'Bappeda', 'UPT 5', '082729688066', 'bwijayanti@example.com', '2024-03-12', '22:04:00', 'RS Permata Hati', 'Selesai', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, 0, '2025-07-14 08:46:53', NULL, NULL, '2025-08-13 08:46:53', '2025-08-13 08:46:53'),
	(114, 84, '9364925169352287', 'NRK83937589', 'Ana Ophelia Purwanti S.Pd', '1989-12-10', 'P', 'Bappeda', 'UPT 3', '082954079714', 'respati.januar@example.com', '2025-10-17', '07:26:00', 'RS Permata Hati', 'Terjadwal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, '2025-08-13 08:46:53', '2025-08-13 08:46:53'),
	(115, 85, '6365966801921426', 'NRK10552819', 'Rama Ardianto', '1991-12-27', 'L', 'Bappeda', 'UPT 3', '083766587589', 'radika.farida@example.org', '2025-10-10', '02:04:00', 'Klinik Sehat Sentosa', 'Terjadwal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, '2025-08-13 08:46:53', '2025-08-13 08:46:53'),
	(116, 85, '6365966801921426', 'NRK10552819', 'Rama Ardianto', '1991-12-27', 'L', 'Bappeda', 'UPT 3', '083766587589', 'radika.farida@example.org', '2024-11-20', '10:57:00', 'RS Permata Hati', 'Selesai', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, 0, '2025-08-11 08:46:53', NULL, 'Est hic optio nobis facilis quis.', '2025-08-13 08:46:53', '2025-08-13 08:46:53'),
	(117, 85, '6365966801921426', 'NRK10552819', 'Rama Ardianto', '1991-12-27', 'L', 'Bappeda', 'UPT 3', '083766587589', 'radika.farida@example.org', '2024-12-16', '21:42:00', 'RSUD Kota', 'Selesai', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 1, NULL, '2025-07-14 08:46:53', NULL, '2025-08-13 08:46:53', '2025-08-13 08:46:53'),
	(118, 86, '8515827050115187', 'NRK69163783', 'Asmadi Situmorang', '1999-06-22', 'L', 'Sekretariat Daerah', 'UPT 5', '087378962473', 'dsuartini@example.com', '2024-08-06', '00:29:00', 'RS Bakti Husada', 'Selesai', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 1, NULL, '2025-08-03 08:46:53', NULL, '2025-08-13 08:46:53', '2025-08-13 08:46:53'),
	(119, 86, '8515827050115187', 'NRK69163783', 'Asmadi Situmorang', '1999-06-22', 'L', 'Sekretariat Daerah', 'UPT 5', '087378962473', 'dsuartini@example.com', '2024-11-01', '18:32:00', 'Klinik Sehat Sentosa', 'Batal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 1, NULL, '2025-08-12 08:46:53', NULL, '2025-08-13 08:46:53', '2025-08-13 08:46:53'),
	(120, 87, '2611951714589244', 'NRK04663625', 'Almira Paramita Yuliarti', '1975-06-07', 'P', 'Sekretariat Daerah', 'UPT 3', '087528170563', 'hidayat.harja@example.org', '2024-09-11', '12:29:00', 'RSUD Kota', 'Selesai', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, '2025-07-15 08:46:53', '2025-08-13 08:46:53', NULL, '2025-08-13 08:46:53', '2025-08-13 08:46:53'),
	(121, 87, '2611951714589244', 'NRK04663625', 'Almira Paramita Yuliarti', '1975-06-07', 'P', 'Sekretariat Daerah', 'UPT 3', '087528170563', 'hidayat.harja@example.org', '2026-01-26', '08:31:00', 'RSUD Kota', 'Terjadwal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, 'Officia et ratione unde fuga nesciunt impedit vel provident.', '2025-08-13 08:46:53', '2025-08-13 08:46:53'),
	(122, 87, '2611951714589244', 'NRK04663625', 'Almira Paramita Yuliarti', '1975-06-07', 'P', 'Sekretariat Daerah', 'UPT 3', '087528170563', 'hidayat.harja@example.org', '2025-12-12', '23:35:00', 'RS Bakti Husada', 'Terjadwal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, '2025-08-13 08:46:53', '2025-08-13 08:46:53'),
	(123, 88, '0275887696507396', 'NRK57772085', 'Jarwa Purwa Wibowo', '1975-04-30', 'L', 'Dinas Perhubungan', 'UPT 1', '087959723307', 'rajasa.oni@example.com', '2023-11-08', '01:00:00', 'Klinik Sehat Sentosa', 'Selesai', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, '2025-07-22 08:46:53', '2025-08-07 08:46:53', NULL, '2025-08-13 08:46:53', '2025-08-13 08:46:53'),
	(124, 88, '0275887696507396', 'NRK57772085', 'Jarwa Purwa Wibowo', '1975-04-30', 'L', 'Dinas Perhubungan', 'UPT 1', '087959723307', 'rajasa.oni@example.com', '2023-09-16', '05:38:00', 'RS Permata Hati', 'Selesai', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, '2025-08-06 08:46:53', '2025-08-12 08:46:53', NULL, '2025-08-13 08:46:53', '2025-08-13 08:46:53'),
	(125, 88, '0275887696507396', 'NRK57772085', 'Jarwa Purwa Wibowo', '1975-04-30', 'L', 'Dinas Perhubungan', 'UPT 1', '087959723307', 'rajasa.oni@example.com', '2025-12-03', '14:24:00', 'Klinik Medika Utama', 'Terjadwal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, '2025-08-13 08:46:53', '2025-08-13 08:46:53'),
	(126, 89, '7288843076974262', 'NRK14591960', 'Hesti Wijayanti', '1997-11-09', 'P', 'Sekretariat Daerah', 'UPT 4', '082905398286', 'yessi.astuti@example.org', '2023-12-02', '07:16:00', 'RS Permata Hati', 'Selesai', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, 0, '2025-08-04 08:46:53', NULL, NULL, '2025-08-13 08:46:53', '2025-08-13 08:46:53'),
	(127, 89, '7288843076974262', 'NRK14591960', 'Hesti Wijayanti', '1997-11-09', 'P', 'Sekretariat Daerah', 'UPT 4', '082905398286', 'yessi.astuti@example.org', '2026-01-26', '17:16:00', 'Klinik Medika Utama', 'Terjadwal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, '2025-08-13 08:46:53', '2025-08-13 08:46:53'),
	(128, 89, '7288843076974262', 'NRK14591960', 'Hesti Wijayanti', '1997-11-09', 'P', 'Sekretariat Daerah', 'UPT 4', '082905398286', 'yessi.astuti@example.org', '2026-01-28', '06:52:00', 'RS Bakti Husada', 'Terjadwal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, '2025-08-13 08:46:53', '2025-08-13 08:46:53'),
	(129, 90, '4758830205723499', 'NRK61384498', 'Rafid Firmansyah', '1985-08-25', 'L', 'Dinas Pendidikan', 'UPT 2', '085720118604', 'purwanti.sadina@example.com', '2026-01-18', '07:30:00', 'RS Permata Hati', 'Terjadwal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, '2025-08-13 08:46:53', '2025-08-13 08:46:53'),
	(130, 90, '4758830205723499', 'NRK61384498', 'Rafid Firmansyah', '1985-08-25', 'L', 'Dinas Pendidikan', 'UPT 2', '085720118604', 'purwanti.sadina@example.com', '2024-07-23', '23:25:00', 'RS Permata Hati', 'Selesai', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, '2025-07-30 08:46:53', '2025-07-18 08:46:53', 'Eligendi quos sed eaque et asperiores sed.', '2025-08-13 08:46:53', '2025-08-13 08:46:53'),
	(131, 90, '4758830205723499', 'NRK61384498', 'Rafid Firmansyah', '1985-08-25', 'L', 'Dinas Pendidikan', 'UPT 2', '085720118604', 'purwanti.sadina@example.com', '2024-02-17', '08:27:00', 'RS Permata Hati', 'Selesai', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, '2025-07-18 08:46:53', '2025-08-01 08:46:53', NULL, '2025-08-13 08:46:53', '2025-08-13 08:46:53'),
	(132, 91, '7119898900402473', 'NRK33257740', 'Intan Laksmiwati', '2001-10-20', 'P', 'Dinas Kesehatan', 'UPT 5', '082519419168', 'gmardhiyah@example.com', '2025-04-29', '17:20:00', 'RS Bakti Husada', 'Selesai', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 1, NULL, '2025-08-09 08:46:53', 'Repudiandae itaque dolores aut aperiam maxime repellat quia.', '2025-08-13 08:46:53', '2025-08-13 08:46:53'),
	(133, 91, '7119898900402473', 'NRK33257740', 'Intan Laksmiwati', '2001-10-20', 'P', 'Dinas Kesehatan', 'UPT 5', '082519419168', 'gmardhiyah@example.com', '2025-09-23', '11:52:00', 'RS Bakti Husada', 'Terjadwal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, '2025-08-13 08:46:53', '2025-08-13 08:46:53'),
	(134, 91, '7119898900402473', 'NRK33257740', 'Intan Laksmiwati', '2001-10-20', 'P', 'Dinas Kesehatan', 'UPT 5', '082519419168', 'gmardhiyah@example.com', '2024-11-07', '18:42:00', 'RS Bakti Husada', 'Batal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, '2025-08-13 08:46:53', '2025-08-13 08:46:53'),
	(135, 92, '5355770528344340', 'NRK95364274', 'Ella Cici Hartati S.Kom', '1968-04-12', 'P', 'Dinas Kesehatan', 'UPT 2', '084668996314', 'hana.wulandari@example.org', '2025-09-02', '20:40:00', 'Klinik Medika Utama', 'Batal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, 0, '2025-07-18 08:46:53', NULL, NULL, '2025-08-13 08:46:53', '2025-08-13 08:46:53'),
	(136, 92, '5355770528344340', 'NRK95364274', 'Ella Cici Hartati S.Kom', '1968-04-12', 'P', 'Dinas Kesehatan', 'UPT 2', '084668996314', 'hana.wulandari@example.org', '2025-03-13', '08:04:00', 'Klinik Medika Utama', 'Selesai', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, '2025-08-13 08:46:53', '2025-08-13 08:46:53'),
	(137, 93, '9171942535508682', 'NRK40202707', 'Jasmin Rini Purwanti', '2003-05-20', 'P', 'Sekretariat Daerah', 'UPT 2', '080001446850', 'gmelani@example.org', '2025-12-31', '23:38:00', 'RS Bakti Husada', 'Terjadwal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, 'Aut velit ipsum et ut sit.', '2025-08-13 08:46:53', '2025-08-13 08:46:53'),
	(138, 94, '9130826197228707', 'NRK17546181', 'Clara Rahayu', '1993-05-06', 'P', 'Bappeda', 'UPT 3', '080307323388', 'suryono.intan@example.net', '2025-11-21', '10:46:00', 'RS Permata Hati', 'Terjadwal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, '2025-08-13 08:46:53', '2025-08-13 08:46:53'),
	(139, 94, '9130826197228707', 'NRK17546181', 'Clara Rahayu', '1993-05-06', 'P', 'Bappeda', 'UPT 3', '080307323388', 'suryono.intan@example.net', '2024-06-22', '07:37:00', 'RS Bakti Husada', 'Selesai', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, '2025-08-04 08:46:53', '2025-07-25 08:46:53', NULL, '2025-08-13 08:46:53', '2025-08-13 08:46:53'),
	(140, 94, '9130826197228707', 'NRK17546181', 'Clara Rahayu', '1993-05-06', 'P', 'Bappeda', 'UPT 3', '080307323388', 'suryono.intan@example.net', '2024-11-13', '10:59:00', 'Klinik Sehat Sentosa', 'Selesai', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, '2025-08-13 08:46:53', '2025-08-04 08:46:53', NULL, '2025-08-13 08:46:53', '2025-08-13 08:46:53'),
	(141, 95, '9902672505241363', 'NRK38346238', 'Elvin Siregar', '1995-07-18', 'L', 'Dinas Kesehatan', 'UPT 3', '087075947778', 'dimaz.sihotang@example.org', '2025-06-16', '09:06:00', 'RS Bakti Husada', 'Batal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, '2025-07-28 08:46:53', '2025-08-02 08:46:53', 'Eum dolor est animi vel voluptates recusandae.', '2025-08-13 08:46:53', '2025-08-13 08:46:53'),
	(142, 96, '5019741828588474', 'NRK87453346', 'Makara Hutagalung', '1983-03-23', 'L', 'Dinas Pendidikan', 'UPT 1', '080524780468', 'galuh.wahyudin@example.net', '2024-09-17', '02:38:00', 'Klinik Sehat Sentosa', 'Selesai', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, '2025-07-16 08:46:53', '2025-07-29 08:46:53', NULL, '2025-08-13 08:46:53', '2025-08-13 08:46:53'),
	(143, 96, '5019741828588474', 'NRK87453346', 'Makara Hutagalung', '1983-03-23', 'L', 'Dinas Pendidikan', 'UPT 1', '080524780468', 'galuh.wahyudin@example.net', '2026-01-23', '03:32:00', 'Klinik Sehat Sentosa', 'Terjadwal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, '2025-08-13 08:46:53', '2025-08-13 08:46:53'),
	(144, 97, '9559724842276473', 'NRK37615771', 'Liman Marbun S.Psi', '1988-06-12', 'L', 'Dinas Perhubungan', 'UPT 3', '085806850981', 'nasab02@example.org', '2024-03-30', '13:48:00', 'RS Permata Hati', 'Selesai', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, '2025-08-06 08:46:53', '2025-08-06 08:46:53', 'Soluta alias ut hic dolorem temporibus est voluptas qui.', '2025-08-13 08:46:53', '2025-08-13 08:46:53'),
	(145, 97, '9559724842276473', 'NRK37615771', 'Liman Marbun S.Psi', '1988-06-12', 'L', 'Dinas Perhubungan', 'UPT 3', '085806850981', 'nasab02@example.org', '2024-02-28', '05:40:00', 'RS Bakti Husada', 'Selesai', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, '2025-07-29 08:46:53', '2025-07-26 08:46:53', NULL, '2025-08-13 08:46:53', '2025-08-13 08:46:53'),
	(146, 98, '7378434801741179', 'NRK79165553', 'Anastasia Aryani', '1993-04-04', 'P', 'Sekretariat Daerah', 'UPT 2', '085186966818', 'yusamah@example.org', '2026-01-03', '05:27:00', 'RSUD Kota', 'Terjadwal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, '2025-08-13 08:46:53', '2025-08-13 08:46:53'),
	(147, 98, '7378434801741179', 'NRK79165553', 'Anastasia Aryani', '1993-04-04', 'P', 'Sekretariat Daerah', 'UPT 2', '085186966818', 'yusamah@example.org', '2025-09-26', '16:47:00', 'Klinik Medika Utama', 'Terjadwal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, '2025-08-13 08:46:53', '2025-08-13 08:46:53'),
	(148, 99, '4146275479564183', 'NRK40842539', 'Almira Haryanti', '1989-01-07', 'P', 'Bappeda', 'UPT 2', '089655281752', 'maras09@example.com', '2025-12-20', '15:37:00', 'RS Permata Hati', 'Terjadwal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, '2025-08-13 08:46:53', '2025-08-13 08:46:53'),
	(149, 99, '4146275479564183', 'NRK40842539', 'Almira Haryanti', '1989-01-07', 'P', 'Bappeda', 'UPT 2', '089655281752', 'maras09@example.com', '2026-01-06', '23:54:00', 'RS Bakti Husada', 'Terjadwal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, '2025-08-13 08:46:53', '2025-08-13 08:46:53'),
	(150, 99, '4146275479564183', 'NRK40842539', 'Almira Haryanti', '1989-01-07', 'P', 'Bappeda', 'UPT 2', '089655281752', 'maras09@example.com', '2025-12-26', '21:04:00', 'RS Bakti Husada', 'Terjadwal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, '2025-08-13 08:46:53', '2025-08-13 08:46:53'),
	(151, 60, '9929078111305214', 'NRK61105780', 'Siti Utami', '1991-06-28', 'P', 'Sekretariat Daerah', 'UPT 2', '087390261741', 'kezia29@example.com', '2025-08-20', '12:30:00', 'Klinik Utama Balaikota', 'Ditolak', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, '2025-08-13 09:03:58', '2025-08-13 09:11:46'),
	(152, 60, '9929078111305214', 'NRK61105780', 'Siti Utami', '1991-06-28', 'P', 'Sekretariat Daerah', 'UPT 2', '087390261741', 'kezia29@example.com', '2025-08-30', '12:30:00', 'Balaikota', 'Terjadwal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, '2025-08-13 09:51:41', '2025-08-13 09:51:41'),
	(153, 60, '9929078111305214', 'NRK61105780', 'Siti Utami', '1991-06-28', 'P', 'Sekretariat Daerah', 'UPT 2', '087390261741', 'kezia29@example.com', '2025-09-06', '13:40:00', 'Balaikota', 'Terjadwal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, '2025-08-13 10:03:23', '2025-08-13 10:03:23'),
	(154, 60, '9929078111305214', 'NRK61105780', 'Siti Utami', '1991-06-28', 'P', 'Sekretariat Daerah', 'UPT 2', '087390261741', 'kezia29@example.com', '2025-09-04', '13:09:00', 'Balaikota', 'Terjadwal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, '2025-08-13 10:07:29', '2025-08-13 10:07:29'),
	(155, 101, '1010101010101010', '101010', 'Syaiful Islami', '1990-01-01', 'L', 'Dinas Kesehatan', 'PPKP', '08110101010', 'syaiful@gmail.com', '2025-09-20', '07:30:00', 'Balaikota', 'Terjadwal', 1, 1, '2025-09-03 05:58:52', 0, NULL, NULL, NULL, NULL, 1, 1, '2025-08-13 19:17:13', '2025-08-13 19:17:51', 'MCU APBD', '2025-08-13 18:53:58', '2025-09-03 05:58:52');

-- Dumping structure for table monitoring_mcu.sessions
DROP TABLE IF EXISTS `sessions`;
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table monitoring_mcu.sessions: ~2 rows (approximately)
REPLACE INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
	('aMBsSvrGhexqfpb6pLWicgcNTZ9obMjyzu9kfa6N', 8, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoidklCM3FMUDVEa1FkNHdSY1pBdFNPSDJjdkE4UUIzdWFZSHMzcThwYyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzg6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9jbGllbnQvZGFzaGJvYXJkIjt9czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czozODoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2NsaWVudC9kYXNoYm9hcmQiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTo4O30=', 1756906200),
	('QX1k2B8O0jMxjlkChvhUc1dQDjiLs2e4PcSAZ2gr', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiNm1HajNyQXFsR0JNSE85SVI3dHdmbjRNMXY5QjhQMW1lZ2dySzR4diI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7czoxNzoicGFzc3dvcmRfaGFzaF93ZWIiO3M6NjA6IiQyeSQxMiRZZlg3OU9weFNOOWFTMEhucThFMTh1b0w4WlRqblRCblUuU3dLdHRaaXFNNEtWMWJTcGRFbSI7czo4OiJmaWxhbWVudCI7YTowOnt9fQ==', 1756906598);

-- Dumping structure for table monitoring_mcu.settings
DROP TABLE IF EXISTS `settings`;
CREATE TABLE IF NOT EXISTS `settings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'string',
  `group` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'general',
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `settings_key_unique` (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table monitoring_mcu.settings: ~16 rows (approximately)
REPLACE INTO `settings` (`id`, `key`, `value`, `type`, `group`, `description`, `created_at`, `updated_at`) VALUES
	(1, 'smtp_host', 'smtp.gmail.com', 'string', 'smtp', 'SMTP Host', '2025-08-13 08:46:48', '2025-08-13 08:46:48'),
	(2, 'smtp_port', '587', 'string', 'smtp', 'SMTP Port', '2025-08-13 08:46:48', '2025-08-13 08:46:48'),
	(3, 'smtp_username', '', 'string', 'smtp', 'SMTP Username', '2025-08-13 08:46:48', '2025-08-13 08:46:48'),
	(4, 'smtp_password', '', 'string', 'smtp', 'SMTP Password', '2025-08-13 08:46:48', '2025-08-13 08:46:48'),
	(5, 'smtp_encryption', 'tls', 'string', 'smtp', 'SMTP Encryption', '2025-08-13 08:46:48', '2025-08-13 08:46:48'),
	(6, 'smtp_from_address', 'noreply@mcu.local', 'string', 'smtp', 'SMTP From Address', '2025-08-13 08:46:48', '2025-08-13 08:46:48'),
	(7, 'smtp_from_name', 'Sistem MCU', 'string', 'smtp', 'SMTP From Name', '2025-08-13 08:46:48', '2025-08-13 08:46:48'),
	(8, 'whatsapp_token', '', 'string', 'whatsapp', 'WhatsApp API Token', '2025-08-13 08:46:48', '2025-08-13 08:46:48'),
	(9, 'whatsapp_instance_id', '', 'string', 'whatsapp', 'WhatsApp Instance ID', '2025-08-13 08:46:48', '2025-08-13 08:46:48'),
	(10, 'whatsapp_phone_number', '', 'string', 'whatsapp', 'WhatsApp Phone Number', '2025-08-13 08:46:48', '2025-08-13 08:46:48'),
	(11, 'email_invitation_subject', 'Undangan Medical Check Up', 'string', 'email_template', 'Subject Email Undangan', '2025-08-13 08:46:48', '2025-08-13 08:46:48'),
	(12, 'email_invitation_template', 'Kepada {nama_lengkap}, Anda diundang untuk mengikuti Medical Check Up pada tanggal {tanggal_pemeriksaan} pukul {jam_pemeriksaan} di {lokasi_pemeriksaan}.', 'text', 'email_template', 'Template Email Undangan', '2025-08-13 08:46:49', '2025-08-13 08:46:49'),
	(13, 'whatsapp_invitation_template', 'Halo {nama_lengkap}, Anda diundang untuk mengikuti Medical Check Up pada tanggal {tanggal_pemeriksaan} pukul {jam_pemeriksaan} di {lokasi_pemeriksaan}.', 'text', 'whatsapp_template', 'Template WhatsApp Undangan', '2025-08-13 08:46:49', '2025-08-13 08:46:49'),
	(14, 'app_name', 'Sistem Monitoring MCU', 'string', 'general', 'Nama Aplikasi', '2025-08-13 08:46:49', '2025-08-13 08:46:49'),
	(15, 'app_description', 'Sistem Monitoring Medical Check Up', 'string', 'general', 'Deskripsi Aplikasi', '2025-08-13 08:46:49', '2025-08-13 08:46:49'),
	(16, 'mcu_interval_years', '3', 'string', 'general', 'Interval MCU (Tahun)', '2025-08-13 08:46:49', '2025-08-13 08:46:49');

-- Dumping structure for table monitoring_mcu.users
DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('super_admin','admin','user') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `nik_ktp` varchar(16) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nrk_pegawai` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_nik_ktp_unique` (`nik_ktp`),
  UNIQUE KEY `users_nrk_pegawai_unique` (`nrk_pegawai`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table monitoring_mcu.users: ~8 rows (approximately)
REPLACE INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `nik_ktp`, `nrk_pegawai`, `is_active`, `remember_token`, `created_at`, `updated_at`) VALUES
	(1, 'Super Admin', 'superadmin@mcu.local', NULL, '$2y$12$YfX79OpxSN9aS0Hnq8E18uoL8ZTjnTBnU.SwKttZiqM4KV1bSpdEm', 'super_admin', NULL, NULL, 1, NULL, '2025-08-13 08:46:48', '2025-08-13 08:46:48'),
	(2, 'Admin MCU', 'admin@mcu.local', NULL, '$2y$12$RHQB2fH6Jb8ZqkE14rOXoOGiTMe.rAsKe6iS85hiM8HRxSgg3owja', 'admin', NULL, NULL, 1, NULL, '2025-08-13 08:46:48', '2025-08-13 08:46:48'),
	(3, 'User MCU', 'user@mcu.local', NULL, '$2y$12$rDeZqmZElyVmRx5OoRyRu.JN90IH/Y79dFhjH8Px4iNROZFlfnzvW', 'user', NULL, NULL, 1, NULL, '2025-08-13 08:46:48', '2025-08-13 08:46:48'),
	(4, 'Siti Utami', 'kezia29@example.com', NULL, '$2y$12$Yw5P8Q0Zh78pjsmK3raWPe9WvaHvxhXBZXWSNm3yCr0fEdCH3jeOe', 'user', '9929078111305214', 'NRK61105780', 1, NULL, '2025-08-13 08:59:02', '2025-08-13 08:59:02'),
	(5, 'Pardi Siregar S.Psi', 'kuncara01@example.org', NULL, '$2y$12$2i6IMw2T9Btl1cHi6JlZ/OJdH0gHPZEB984S9W8wUBonW9gn3ChxK', 'user', '8961503034758136', 'NRK25838276', 1, NULL, '2025-08-13 09:54:00', '2025-08-13 09:54:00'),
	(6, 'Syaiful Islami', 'syaiful@gmail.com', NULL, '$2y$12$uLY/pkwy4OEq0/rkLZ2lnenV.Ua4ISbVptETwr0CRXQHgW54zxOfy', 'user', '1010101010101010', '101010', 1, NULL, '2025-08-13 18:52:31', '2025-08-13 18:52:31'),
	(7, 'Rahmi Zulaika', 'permata.kanda@example.com', NULL, '$2y$12$/m76Gv9w2iTfsTF2xnadM.KWBjRiiytJ0OTaFUPcJA7EcvyMZM2uS', 'user', '2965860775719956', 'NRK45255515', 1, NULL, '2025-08-13 19:33:12', '2025-08-13 19:33:12'),
	(8, 'Kiandra Yuliarti', 'virman.prastuti@example.net', NULL, '$2y$12$tk9KzyNrOPYx18cJFUkLoelYI378edxny4eEqamcj0EO4dDgkurLK', 'user', '9825273455739077', 'NRK72429138', 1, NULL, '2025-09-03 06:00:16', '2025-09-03 06:00:16');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
