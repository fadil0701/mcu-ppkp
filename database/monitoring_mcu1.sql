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
CREATE DATABASE IF NOT EXISTS `monitoring_mcu` /*!40100 DEFAULT CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `monitoring_mcu`;

-- Dumping structure for table monitoring_mcu.cache
CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table monitoring_mcu.cache: ~4 rows (approximately)
REPLACE INTO `cache` (`key`, `value`, `expiration`) VALUES
	('laravel-cache-356a192b7913b04c54574d18c28d46e6395428ab', 'i:1;', 1756958197),
	('laravel-cache-356a192b7913b04c54574d18c28d46e6395428ab:timer', 'i:1756958197;', 1756958197),
	('laravel-cache-livewire-rate-limiter:a17961fa74e9275d529f489537f179c05d50c2f3', 'i:1;', 1756956621),
	('laravel-cache-livewire-rate-limiter:a17961fa74e9275d529f489537f179c05d50c2f3:timer', 'i:1756956620;', 1756956620);

-- Dumping structure for table monitoring_mcu.cache_locks
CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table monitoring_mcu.cache_locks: ~0 rows (approximately)

-- Dumping structure for table monitoring_mcu.diagnoses
CREATE TABLE IF NOT EXISTS `diagnoses` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table monitoring_mcu.diagnoses: ~2 rows (approximately)
REPLACE INTO `diagnoses` (`id`, `code`, `name`, `description`, `is_active`, `created_at`, `updated_at`) VALUES
	(1, 'I01', 'TES', NULL, 1, '2025-09-03 20:31:30', '2025-09-03 20:31:47'),
	(2, 'A01', 'TES 3', NULL, 1, '2025-09-03 20:31:58', '2025-09-03 20:31:58'),
	(3, 'E01', 'TES 2', NULL, 1, '2025-09-03 20:32:03', '2025-09-03 20:32:03');

-- Dumping structure for table monitoring_mcu.failed_jobs
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

-- Dumping data for table monitoring_mcu.jobs: ~0 rows (approximately)

-- Dumping structure for table monitoring_mcu.job_batches
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
  `specialist_doctor_ids` json DEFAULT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table monitoring_mcu.mcu_results: ~2 rows (approximately)
REPLACE INTO `mcu_results` (`id`, `participant_id`, `schedule_id`, `tanggal_pemeriksaan`, `diagnosis`, `diagnosis_list`, `hasil_pemeriksaan`, `status_kesehatan`, `rekomendasi`, `specialist_doctor_ids`, `file_hasil`, `file_hasil_files`, `file_hasil_multi`, `is_downloaded`, `downloaded_at`, `uploaded_by`, `created_at`, `updated_at`) VALUES
	(1, 68, 138, '2025-09-04', NULL, '["TES 3"]', 'aaaa', 'Sehat', 'ddddddd', '["1", "2"]', NULL, '[]', NULL, 0, NULL, 'superadmin@mcu.local', '2025-09-03 20:43:36', '2025-09-03 20:58:07'),
	(2, 2, 2, '2025-09-04', NULL, '["TES"]', 'sssssssssss', 'Sehat', 'ffffffff', '["1", "2"]', NULL, '[]', NULL, 0, NULL, 'superadmin@mcu.local', '2025-09-03 20:54:42', '2025-09-03 20:54:42');

-- Dumping structure for table monitoring_mcu.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table monitoring_mcu.migrations: ~0 rows (approximately)
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
	(13, '2025_08_13_020000_alter_schedules_status_enum_add_ditolak', 1),
	(14, '2025_08_13_030000_create_notifications_table', 1),
	(15, '2025_08_13_040000_add_queue_number_to_schedules_table', 1),
	(16, '2025_08_13_050000_add_participant_confirmation_and_reschedule_to_schedules_table', 1),
	(17, '2025_09_04_100000_create_specialist_doctors_table', 1),
	(18, '2025_09_04_120000_add_specialist_doctor_ids_to_mcu_results_table', 2);

-- Dumping structure for table monitoring_mcu.model_has_permissions
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

-- Dumping data for table monitoring_mcu.notifications: ~0 rows (approximately)

-- Dumping structure for table monitoring_mcu.participants
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
) ENGINE=InnoDB AUTO_INCREMENT=101 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table monitoring_mcu.participants: ~100 rows (approximately)
REPLACE INTO `participants` (`id`, `nik_ktp`, `nrk_pegawai`, `nama_lengkap`, `tempat_lahir`, `tanggal_lahir`, `jenis_kelamin`, `skpd`, `ukpd`, `no_telp`, `email`, `status_pegawai`, `status_mcu`, `tanggal_mcu_terakhir`, `catatan`, `created_at`, `updated_at`) VALUES
	(1, '9191343531083708', 'NRK18802225', 'Lanang Suryono', 'Gorontalo', '1994-02-08', 'L', 'Dinas Perhubungan', 'UPT 4', '082864860194', 'mandasari.jail@example.org', 'PPPK', 'Ditolak', '2020-12-03', NULL, '2025-09-03 20:29:06', '2025-09-03 20:29:06'),
	(2, '1353709589100153', 'NRK73021586', 'Tedi Bakiadi Siregar S.Pt', 'Tangerang Selatan', '1977-08-29', 'L', 'Dinas Pendidikan', 'UPT 4', '086964336712', 'agnes09@example.net', 'PPPK', 'Sudah MCU', '2025-08-18', NULL, '2025-09-03 20:29:06', '2025-09-03 20:29:06'),
	(3, '9779889211102710', 'NRK04017520', 'Soleh Sihombing', 'Jayapura', '1968-05-05', 'L', 'Dinas Perhubungan', 'UPT 5', '088785088249', 'upurnawati@example.com', 'PPPK', 'Belum MCU', NULL, NULL, '2025-09-03 20:29:06', '2025-09-03 20:29:06'),
	(4, '9476264224120438', 'NRK49681218', 'Cemani Hutasoit S.Pd', 'Batam', '1989-10-27', 'L', 'Dinas Kesehatan', 'UPT 4', '086563566332', 'hartati.hesti@example.org', 'CPNS', 'Sudah MCU', '2023-10-06', NULL, '2025-09-03 20:29:06', '2025-09-03 20:29:06'),
	(5, '4509748956317060', 'NRK06092686', 'Labuh Okta Wasita', 'Ternate', '1992-02-12', 'L', 'Dinas Kesehatan', 'UPT 3', '085481526891', 'pratama.lamar@example.org', 'CPNS', 'Belum MCU', NULL, 'Distinctio vero reprehenderit ut aliquam temporibus.', '2025-09-03 20:29:06', '2025-09-03 20:29:06'),
	(6, '8278109309219580', 'NRK35375867', 'Eman Irawan', 'Dumai', '1969-12-11', 'L', 'Dinas Pendidikan', 'UPT 3', '088082351496', 'kusmawati.umi@example.com', 'PPPK', 'Sudah MCU', '2022-08-22', NULL, '2025-09-03 20:29:06', '2025-09-03 20:29:06'),
	(7, '8336109928590247', 'NRK93326761', 'Zelda Hartati', 'Gunungsitoli', '1977-09-20', 'P', 'Dinas Perhubungan', 'UPT 4', '081657760199', 'uwais.ajimin@example.net', 'PPPK', 'Belum MCU', NULL, 'Odio consectetur exercitationem dicta est mollitia voluptas.', '2025-09-03 20:29:06', '2025-09-03 20:29:06'),
	(8, '8497542367974666', 'NRK29215374', 'Usman Nashiruddin', 'Sukabumi', '1980-09-06', 'L', 'Dinas Pendidikan', 'UPT 3', '089453756988', 'rhutapea@example.org', 'PPPK', 'Sudah MCU', '2024-02-19', 'Quia voluptatem magnam maiores molestias.', '2025-09-03 20:29:06', '2025-09-03 20:29:06'),
	(9, '8203964692051667', 'NRK97116060', 'Alika Puspita S.Pt', 'Banjarmasin', '1994-01-26', 'P', 'Dinas Kesehatan', 'UPT 1', '083886291837', 'aryani.yoga@example.com', 'PPPK', 'Belum MCU', NULL, NULL, '2025-09-03 20:29:06', '2025-09-03 20:29:06'),
	(10, '8642630301106016', 'NRK30147489', 'Puti Zulaika M.Kom.', 'Medan', '1994-07-25', 'P', 'Bappeda', 'UPT 5', '083184332932', 'farhunnisa.usamah@example.org', 'PNS', 'Belum MCU', NULL, NULL, '2025-09-03 20:29:07', '2025-09-03 20:29:07'),
	(11, '1909831408631259', 'NRK27411971', 'Azalea Vera Hartati', 'Banjarmasin', '1978-07-17', 'P', 'Dinas Perhubungan', 'UPT 3', '085407395163', 'cakrawangsa.hidayanto@example.net', 'CPNS', 'Belum MCU', NULL, 'Soluta nostrum necessitatibus enim maiores.', '2025-09-03 20:29:07', '2025-09-03 20:29:07'),
	(12, '8625561037069846', 'NRK36058497', 'Jessica Permata', 'Palu', '1974-09-03', 'P', 'Dinas Pendidikan', 'UPT 3', '089123540729', 'cprabowo@example.com', 'PPPK', 'Belum MCU', NULL, NULL, '2025-09-03 20:29:07', '2025-09-03 20:29:07'),
	(13, '6168437007070995', 'NRK75985302', 'Kawaya Radit Wijaya', 'Yogyakarta', '1975-05-09', 'L', 'Sekretariat Daerah', 'UPT 1', '085749292349', 'kusmawati.ganda@example.net', 'PNS', 'Belum MCU', NULL, NULL, '2025-09-03 20:29:07', '2025-09-03 20:29:07'),
	(14, '0573724463885283', 'NRK40860138', 'Tasnim Najam Maulana', 'Makassar', '1975-08-28', 'L', 'Sekretariat Daerah', 'UPT 1', '082977427166', 'jusada@example.com', 'CPNS', 'Sudah MCU', '2021-08-08', NULL, '2025-09-03 20:29:07', '2025-09-03 20:29:07'),
	(15, '8745249429034252', 'NRK39601695', 'Sadina Cici Widiastuti M.Ak', 'Blitar', '1967-06-21', 'P', 'Sekretariat Daerah', 'UPT 2', '082021663957', 'wawan.rahayu@example.net', 'PNS', 'Sudah MCU', '2023-09-12', NULL, '2025-09-03 20:29:07', '2025-09-03 20:29:07'),
	(16, '5988906012996226', 'NRK91458831', 'Jail Dimaz Setiawan M.Kom.', 'Palopo', '1987-02-09', 'L', 'Sekretariat Daerah', 'UPT 2', '081564168276', 'pagustina@example.com', 'PNS', 'Sudah MCU', '2021-12-16', 'Est odit aliquam est alias veritatis.', '2025-09-03 20:29:07', '2025-09-03 20:29:07'),
	(17, '5931539523720941', 'NRK31007451', 'Mursita Hutapea', 'Probolinggo', '1997-10-08', 'L', 'Dinas Perhubungan', 'UPT 1', '088326626689', 'nainggolan.silvia@example.com', 'CPNS', 'Sudah MCU', '2024-01-28', NULL, '2025-09-03 20:29:07', '2025-09-03 20:29:07'),
	(18, '1708654747879783', 'NRK37417865', 'Karta Naradi Dabukke S.Pd', 'Tasikmalaya', '2002-08-12', 'L', 'Dinas Pendidikan', 'UPT 4', '084238956658', 'saefullah.gamblang@example.com', 'CPNS', 'Ditolak', '2022-07-11', NULL, '2025-09-03 20:29:07', '2025-09-03 20:29:07'),
	(19, '2350557554961764', 'NRK40922596', 'Yance Vanya Rahmawati', 'Jambi', '1973-04-19', 'P', 'Bappeda', 'UPT 5', '082429065243', 'astuti.zamira@example.net', 'PPPK', 'Ditolak', '2023-01-01', NULL, '2025-09-03 20:29:07', '2025-09-03 20:29:07'),
	(20, '7952921179667963', 'NRK05201469', 'Jaeman Winarno M.Farm', 'Sibolga', '1967-05-28', 'L', 'Dinas Pendidikan', 'UPT 5', '086464907840', 'yuni.habibi@example.com', 'CPNS', 'Sudah MCU', '2021-07-20', NULL, '2025-09-03 20:29:07', '2025-09-03 20:29:07'),
	(21, '4302519698788589', 'NRK75222599', 'Mahmud Saragih', 'Medan', '1966-12-21', 'L', 'Dinas Kesehatan', 'UPT 2', '084646508498', 'daryani.sitompul@example.com', 'PNS', 'Ditolak', '2023-10-24', NULL, '2025-09-03 20:29:07', '2025-09-03 20:29:07'),
	(22, '5875565790985336', 'NRK78712764', 'Julia Kusmawati', 'Kendari', '1983-09-15', 'P', 'Bappeda', 'UPT 2', '085977225173', 'ajiman.novitasari@example.net', 'PPPK', 'Ditolak', '2025-05-23', NULL, '2025-09-03 20:29:07', '2025-09-03 20:29:07'),
	(23, '8898200543400277', 'NRK39437566', 'Dasa Lurhur Mangunsong', 'Kediri', '1991-11-15', 'L', 'Bappeda', 'UPT 3', '080711893332', 'mardhiyah.yoga@example.net', 'PNS', 'Sudah MCU', '2022-05-28', NULL, '2025-09-03 20:29:07', '2025-09-03 20:29:07'),
	(24, '0964248310529583', 'NRK14307246', 'Yance Mayasari', 'Sorong', '1976-03-13', 'P', 'Bappeda', 'UPT 4', '083931646938', 'digdaya79@example.com', 'PNS', 'Ditolak', '2022-07-17', NULL, '2025-09-03 20:29:07', '2025-09-03 20:29:07'),
	(25, '6568980031656078', 'NRK14600934', 'Padmi Tina Nasyiah', 'Administrasi Jakarta Utara', '1973-03-03', 'P', 'Dinas Pendidikan', 'UPT 2', '083235654271', 'kiandra.tamba@example.com', 'PNS', 'Ditolak', '2023-12-09', 'Deleniti et quia voluptatem iusto illo.', '2025-09-03 20:29:07', '2025-09-03 20:29:07'),
	(26, '8081600118962082', 'NRK67043012', 'Ida Tiara Hastuti', 'Pekanbaru', '1987-05-15', 'P', 'Dinas Kesehatan', 'UPT 5', '083562726232', 'jono.gunarto@example.org', 'PPPK', 'Sudah MCU', '2023-01-20', 'Voluptas animi qui neque accusamus.', '2025-09-03 20:29:07', '2025-09-03 20:29:07'),
	(27, '3409584376252244', 'NRK78277425', 'Luthfi Prabowo', 'Yogyakarta', '2002-08-01', 'L', 'Dinas Perhubungan', 'UPT 2', '081902983121', 'maimunah78@example.com', 'PNS', 'Ditolak', '2025-06-09', NULL, '2025-09-03 20:29:07', '2025-09-03 20:29:07'),
	(28, '1974800009821769', 'NRK65222023', 'Olivia Hartati', 'Ternate', '2001-07-14', 'P', 'Dinas Kesehatan', 'UPT 2', '084236991790', 'najib80@example.com', 'PPPK', 'Ditolak', '2020-09-28', NULL, '2025-09-03 20:29:07', '2025-09-03 20:29:07'),
	(29, '3649941571236397', 'NRK10315560', 'Belinda Palastri', 'Bima', '1993-02-08', 'P', 'Dinas Pendidikan', 'UPT 4', '086674695359', 'paulin17@example.com', 'PNS', 'Sudah MCU', '2021-04-19', NULL, '2025-09-03 20:29:07', '2025-09-03 20:29:07'),
	(30, '2114332162924867', 'NRK99495204', 'Nilam Yolanda', 'Administrasi Jakarta Timur', '1983-10-14', 'P', 'Dinas Perhubungan', 'UPT 1', '087406577861', 'lestari.ida@example.org', 'PPPK', 'Ditolak', '2024-02-25', NULL, '2025-09-03 20:29:07', '2025-09-03 20:29:07'),
	(31, '1484042069695566', 'NRK40418953', 'Umar Setiawan M.M.', 'Administrasi Jakarta Pusat', '1986-10-20', 'L', 'Dinas Pendidikan', 'UPT 3', '088295003361', 'wacana.ghaliyati@example.com', 'CPNS', 'Ditolak', '2023-04-09', NULL, '2025-09-03 20:29:07', '2025-09-03 20:29:07'),
	(32, '9028290176343202', 'NRK77888416', 'Widya Hasanah', 'Administrasi Jakarta Pusat', '2004-07-25', 'P', 'Dinas Pendidikan', 'UPT 2', '084029385765', 'eli93@example.org', 'PNS', 'Belum MCU', NULL, NULL, '2025-09-03 20:29:07', '2025-09-03 20:29:07'),
	(33, '0353765121730707', 'NRK69602035', 'Jasmin Genta Farida S.Pt', 'Cimahi', '1982-05-28', 'P', 'Dinas Perhubungan', 'UPT 5', '080317355226', 'mulyani.hardi@example.net', 'CPNS', 'Sudah MCU', '2022-11-12', 'Ut ut aspernatur corrupti perspiciatis ipsum cupiditate.', '2025-09-03 20:29:07', '2025-09-03 20:29:07'),
	(34, '7633027084568962', 'NRK20985258', 'Eja Martani Firmansyah M.Farm', 'Sukabumi', '1999-09-06', 'L', 'Dinas Perhubungan', 'UPT 3', '083840997814', 'aisyah83@example.net', 'PNS', 'Belum MCU', NULL, 'Sunt vitae voluptatem vel accusantium rem aliquam.', '2025-09-03 20:29:07', '2025-09-03 20:29:07'),
	(35, '8916274791018114', 'NRK71023347', 'Tania Susanti S.Kom', 'Manado', '1999-03-11', 'P', 'Sekretariat Daerah', 'UPT 1', '085704481499', 'drajat34@example.com', 'PNS', 'Ditolak', '2022-07-22', 'Molestias tenetur et et enim in quam.', '2025-09-03 20:29:07', '2025-09-03 20:29:07'),
	(36, '4174810570224994', 'NRK22132355', 'Himawan Salahudin', 'Parepare', '1983-10-25', 'L', 'Dinas Perhubungan', 'UPT 2', '084009291166', 'usman.sihotang@example.org', 'CPNS', 'Belum MCU', NULL, NULL, '2025-09-03 20:29:07', '2025-09-03 20:29:07'),
	(37, '0081683729852088', 'NRK49618182', 'Rahmat Pranowo', 'Madiun', '1975-09-15', 'L', 'Bappeda', 'UPT 1', '087331130727', 'aurora.ramadan@example.com', 'PNS', 'Belum MCU', NULL, NULL, '2025-09-03 20:29:07', '2025-09-03 20:29:07'),
	(38, '2551375333797732', 'NRK70381342', 'Ellis Wirda Suryatmi', 'Sawahlunto', '1976-05-09', 'P', 'Dinas Pendidikan', 'UPT 5', '089535126963', 'mmandasari@example.com', 'PPPK', 'Belum MCU', NULL, NULL, '2025-09-03 20:29:07', '2025-09-03 20:29:07'),
	(39, '0733974887331626', 'NRK54626479', 'Oni Purnawati', 'Gunungsitoli', '1996-12-17', 'P', 'Sekretariat Daerah', 'UPT 4', '087507090565', 'kuswandari.carla@example.com', 'PNS', 'Sudah MCU', '2023-11-14', NULL, '2025-09-03 20:29:07', '2025-09-03 20:29:07'),
	(40, '5653712413526170', 'NRK10272777', 'Yance Salimah Hastuti', 'Singkawang', '1983-12-03', 'P', 'Sekretariat Daerah', 'UPT 5', '089209278578', 'permadi.eka@example.com', 'CPNS', 'Sudah MCU', '2020-12-14', NULL, '2025-09-03 20:29:07', '2025-09-03 20:29:07'),
	(41, '3167725023191305', 'NRK71627998', 'Warsita Saragih', 'Banjarmasin', '1974-12-15', 'L', 'Sekretariat Daerah', 'UPT 5', '088299684410', 'vmanullang@example.com', 'PNS', 'Ditolak', '2023-04-01', NULL, '2025-09-03 20:29:07', '2025-09-03 20:29:07'),
	(42, '5829007005942247', 'NRK69067226', 'Ina Riyanti', 'Palopo', '1994-05-04', 'P', 'Dinas Perhubungan', 'UPT 5', '089102415174', 'nhutasoit@example.com', 'PPPK', 'Sudah MCU', '2022-07-06', NULL, '2025-09-03 20:29:07', '2025-09-03 20:29:07'),
	(43, '8348010223405913', 'NRK97067517', 'Umaya Najmudin S.Ked', 'Sibolga', '1995-12-30', 'L', 'Sekretariat Daerah', 'UPT 3', '080778616677', 'capa60@example.net', 'CPNS', 'Sudah MCU', '2022-10-30', 'Dolores illo voluptatem et repudiandae ad odit et.', '2025-09-03 20:29:07', '2025-09-03 20:29:07'),
	(44, '5936743162505298', 'NRK73572985', 'Agnes Hastuti', 'Bekasi', '1981-01-02', 'P', 'Dinas Kesehatan', 'UPT 1', '088399715471', 'juli.wacana@example.org', 'PPPK', 'Belum MCU', NULL, 'Qui nam nemo maiores dolores totam.', '2025-09-03 20:29:07', '2025-09-03 20:29:07'),
	(45, '9042152862837962', 'NRK33102248', 'Mala Sudiati', 'Tegal', '1968-05-28', 'P', 'Bappeda', 'UPT 3', '081949827442', 'vera.maryati@example.net', 'CPNS', 'Ditolak', '2022-03-19', 'Autem dolorum consectetur omnis maxime.', '2025-09-03 20:29:07', '2025-09-03 20:29:07'),
	(46, '9512156204603361', 'NRK82037580', 'Prayoga Kurniawan', 'Padangsidempuan', '2003-06-10', 'L', 'Dinas Perhubungan', 'UPT 1', '089397820198', 'irfan.astuti@example.org', 'CPNS', 'Sudah MCU', '2023-04-09', NULL, '2025-09-03 20:29:07', '2025-09-03 20:29:07'),
	(47, '8339387581983149', 'NRK99489418', 'Nasim Halim', 'Pekalongan', '1968-07-14', 'L', 'Sekretariat Daerah', 'UPT 1', '085337769026', 'wijaya.hasna@example.com', 'PPPK', 'Belum MCU', NULL, NULL, '2025-09-03 20:29:07', '2025-09-03 20:29:07'),
	(48, '6329051916661550', 'NRK08857527', 'Tari Agnes Nurdiyanti', 'Sorong', '1983-08-19', 'P', 'Dinas Pendidikan', 'UPT 2', '086952191242', 'indah.sihombing@example.net', 'CPNS', 'Belum MCU', NULL, NULL, '2025-09-03 20:29:07', '2025-09-03 20:29:07'),
	(49, '3277415132294764', 'NRK41721788', 'Usyi Palastri', 'Sukabumi', '2000-05-18', 'P', 'Bappeda', 'UPT 3', '089606231834', 'narpati.kalim@example.org', 'PNS', 'Belum MCU', NULL, NULL, '2025-09-03 20:29:07', '2025-09-03 20:29:07'),
	(50, '7322624495652947', 'NRK11888818', 'Bagiya Irfan Haryanto', 'Blitar', '2003-08-05', 'L', 'Dinas Pendidikan', 'UPT 5', '082899339333', 'daryani@example.net', 'CPNS', 'Ditolak', '2021-12-04', NULL, '2025-09-03 20:29:07', '2025-09-03 20:29:07'),
	(51, '6533852422019357', 'NRK61267588', 'Harjaya Ozy Samosir', 'Pekalongan', '1993-01-19', 'L', 'Sekretariat Daerah', 'UPT 5', '084161711447', 'keisha11@example.com', 'PPPK', 'Sudah MCU', '2022-05-14', NULL, '2025-09-03 20:29:07', '2025-09-03 20:29:07'),
	(52, '3405133169753454', 'NRK92655158', 'Ozy Waluyo', 'Parepare', '1987-03-08', 'L', 'Dinas Pendidikan', 'UPT 5', '089113715386', 'handayani.azalea@example.com', 'PNS', 'Sudah MCU', '2021-08-23', NULL, '2025-09-03 20:29:07', '2025-09-03 20:29:07'),
	(53, '6492640492450523', 'NRK20166684', 'Pranawa Samosir', 'Madiun', '1987-05-09', 'L', 'Dinas Kesehatan', 'UPT 3', '087659907944', 'dwijayanti@example.org', 'CPNS', 'Belum MCU', NULL, NULL, '2025-09-03 20:29:07', '2025-09-03 20:29:07'),
	(54, '4841638052777768', 'NRK02204822', 'Ega Jaeman Iswahyudi S.E.I', 'Singkawang', '1976-05-28', 'L', 'Dinas Kesehatan', 'UPT 3', '085638305850', 'queen.marpaung@example.org', 'CPNS', 'Belum MCU', NULL, NULL, '2025-09-03 20:29:07', '2025-09-03 20:29:07'),
	(55, '9626475907919866', 'NRK04805101', 'Melinda Elisa Novitasari S.T.', 'Yogyakarta', '1987-04-02', 'P', 'Dinas Perhubungan', 'UPT 1', '087371910851', 'msihotang@example.org', 'PNS', 'Ditolak', '2022-03-24', NULL, '2025-09-03 20:29:07', '2025-09-03 20:29:07'),
	(56, '8690618125108924', 'NRK91446483', 'Waluyo Saragih', 'Palu', '1981-05-06', 'L', 'Bappeda', 'UPT 5', '083296523829', 'uda20@example.net', 'PNS', 'Ditolak', '2022-12-05', NULL, '2025-09-03 20:29:07', '2025-09-03 20:29:07'),
	(57, '2117568766273336', 'NRK03352515', 'Septi Wulandari', 'Padang', '1989-07-19', 'P', 'Sekretariat Daerah', 'UPT 3', '087290107627', 'hidayat.zizi@example.com', 'PNS', 'Ditolak', '2020-09-21', 'Ut excepturi sit est voluptatem.', '2025-09-03 20:29:07', '2025-09-03 20:29:07'),
	(58, '0821239175780783', 'NRK22039559', 'Genta Hariyah', 'Banjarmasin', '1969-06-17', 'P', 'Bappeda', 'UPT 3', '085370046384', 'tbudiyanto@example.com', 'PPPK', 'Sudah MCU', '2021-02-07', 'Magni recusandae totam sunt accusamus occaecati.', '2025-09-03 20:29:07', '2025-09-03 20:29:07'),
	(59, '3170186601570648', 'NRK90436308', 'Hana Padmasari', 'Pagar Alam', '2002-08-12', 'P', 'Dinas Kesehatan', 'UPT 3', '082840562071', 'icha.nashiruddin@example.org', 'PPPK', 'Ditolak', '2024-08-14', 'Iusto harum aut temporibus et dignissimos autem molestias laboriosam.', '2025-09-03 20:29:07', '2025-09-03 20:29:07'),
	(60, '5680209206662284', 'NRK45645048', 'Ellis Uyainah S.E.', 'Administrasi Jakarta Barat', '2002-07-20', 'P', 'Sekretariat Daerah', 'UPT 2', '083924177504', 'wahyu.maryati@example.com', 'PPPK', 'Ditolak', '2024-06-27', NULL, '2025-09-03 20:29:07', '2025-09-03 20:29:07'),
	(61, '4618567823743526', 'NRK85066235', 'Ismail Dongoran', 'Bogor', '1980-04-27', 'L', 'Dinas Kesehatan', 'UPT 3', '083439834999', 'prasetya.arsipatra@example.org', 'PPPK', 'Belum MCU', NULL, NULL, '2025-09-03 20:29:07', '2025-09-03 20:29:07'),
	(62, '4130079557314629', 'NRK85461297', 'Sarah Suartini', 'Salatiga', '1996-11-18', 'P', 'Dinas Kesehatan', 'UPT 3', '082466696883', 'fzulkarnain@example.net', 'PNS', 'Belum MCU', NULL, NULL, '2025-09-03 20:29:07', '2025-09-03 20:29:07'),
	(63, '2236893789397081', 'NRK21499713', 'Saiful Tamba', 'Ambon', '1969-11-04', 'L', 'Dinas Perhubungan', 'UPT 1', '081986600894', 'wibowo.hardi@example.net', 'PNS', 'Belum MCU', NULL, NULL, '2025-09-03 20:29:08', '2025-09-03 20:29:08'),
	(64, '3649064178238951', 'NRK58292594', 'Kunthara Rajasa S.T.', 'Administrasi Jakarta Barat', '1981-07-10', 'L', 'Dinas Kesehatan', 'UPT 4', '085254376441', 'janet.puspita@example.org', 'PPPK', 'Sudah MCU', '2024-12-27', NULL, '2025-09-03 20:29:08', '2025-09-03 20:29:08'),
	(65, '9156424594201170', 'NRK99753368', 'Tedi Budiman S.Farm', 'Jambi', '1966-10-04', 'L', 'Dinas Perhubungan', 'UPT 2', '086255038496', 'embuh06@example.com', 'CPNS', 'Sudah MCU', '2022-08-09', 'Voluptatum quidem est est aut.', '2025-09-03 20:29:08', '2025-09-03 20:29:08'),
	(66, '0171887301335752', 'NRK15141164', 'Chelsea Winarsih', 'Kediri', '1982-09-04', 'P', 'Sekretariat Daerah', 'UPT 4', '085816220529', 'azalea.purnawati@example.net', 'CPNS', 'Sudah MCU', '2022-04-07', 'Labore non rerum est impedit sunt quia.', '2025-09-03 20:29:08', '2025-09-03 20:29:08'),
	(67, '9974406615912020', 'NRK97951033', 'Pangestu Nashiruddin S.H.', 'Gorontalo', '1998-01-12', 'L', 'Dinas Pendidikan', 'UPT 4', '087128030771', 'dlaksmiwati@example.org', 'CPNS', 'Belum MCU', NULL, NULL, '2025-09-03 20:29:08', '2025-09-03 20:29:08'),
	(68, '4907796551066706', 'NRK16083381', 'Violet Laila Haryanti', 'Padangpanjang', '2001-05-17', 'P', 'Dinas Pendidikan', 'UPT 3', '086196963038', 'gaman.wijaya@example.org', 'PPPK', 'Sudah MCU', '2025-09-04', NULL, '2025-09-03 20:29:08', '2025-09-03 20:35:48'),
	(69, '0408210830250031', 'NRK78643462', 'Asirwanda Prakosa Dongoran', 'Ternate', '1970-09-23', 'L', 'Dinas Kesehatan', 'UPT 1', '082363264263', 'widiastuti.nilam@example.com', 'PNS', 'Sudah MCU', '2021-11-07', NULL, '2025-09-03 20:29:08', '2025-09-03 20:29:08'),
	(70, '1412060563898333', 'NRK55549725', 'Karsana Megantara', 'Lubuklinggau', '1976-09-22', 'L', 'Dinas Perhubungan', 'UPT 4', '084174852131', 'fbudiyanto@example.com', 'PPPK', 'Ditolak', '2024-03-13', NULL, '2025-09-03 20:29:08', '2025-09-03 20:29:08'),
	(71, '3072677493627732', 'NRK39832941', 'Febi Pia Prastuti', 'Pematangsiantar', '1989-11-01', 'P', 'Dinas Kesehatan', 'UPT 4', '089142632309', 'kariman.nuraini@example.net', 'PPPK', 'Sudah MCU', '2020-09-07', NULL, '2025-09-03 20:29:08', '2025-09-03 20:29:08'),
	(72, '0987137903638191', 'NRK66057286', 'Reza Laswi Uwais', 'Administrasi Jakarta Selatan', '1984-11-09', 'L', 'Bappeda', 'UPT 4', '085895062214', 'nmelani@example.com', 'PNS', 'Sudah MCU', '2023-07-20', NULL, '2025-09-03 20:29:08', '2025-09-03 20:29:08'),
	(73, '2124842252198068', 'NRK91126850', 'Enteng Maryadi M.Farm', 'Parepare', '2000-01-08', 'L', 'Sekretariat Daerah', 'UPT 1', '086299457359', 'nadine17@example.com', 'PNS', 'Ditolak', '2024-12-02', NULL, '2025-09-03 20:29:08', '2025-09-03 20:29:08'),
	(74, '7557790904932259', 'NRK30482316', 'Ulva Uyainah', 'Padangsidempuan', '1997-08-28', 'P', 'Dinas Pendidikan', 'UPT 1', '087979107348', 'hutami@example.com', 'CPNS', 'Sudah MCU', '2023-09-14', NULL, '2025-09-03 20:29:08', '2025-09-03 20:29:08'),
	(75, '9835756825943445', 'NRK66397931', 'Vicky Paris Winarsih', 'Sawahlunto', '1999-01-27', 'P', 'Bappeda', 'UPT 3', '086226535473', 'clara.halimah@example.org', 'PPPK', 'Belum MCU', NULL, NULL, '2025-09-03 20:29:08', '2025-09-03 20:29:08'),
	(76, '1629723027044398', 'NRK13938223', 'Purwanto Baktiadi Marbun S.T.', 'Palangka Raya', '1994-04-12', 'L', 'Dinas Kesehatan', 'UPT 4', '086230396814', 'samsul71@example.org', 'CPNS', 'Belum MCU', NULL, 'Expedita at maiores qui iusto.', '2025-09-03 20:29:08', '2025-09-03 20:29:08'),
	(77, '7721997752902721', 'NRK47476321', 'Galar Garda Firgantoro', 'Dumai', '1977-03-31', 'L', 'Sekretariat Daerah', 'UPT 2', '083164707529', 'tirtayasa36@example.org', 'PNS', 'Ditolak', '2023-10-24', NULL, '2025-09-03 20:29:08', '2025-09-03 20:29:08'),
	(78, '5526977026157122', 'NRK86818982', 'Lili Suartini', 'Parepare', '1972-04-30', 'P', 'Dinas Kesehatan', 'UPT 2', '080385258574', 'viktor.thamrin@example.net', 'PNS', 'Ditolak', '2022-07-25', NULL, '2025-09-03 20:29:08', '2025-09-03 20:29:08'),
	(79, '7040888950211179', 'NRK05492864', 'Xanana Paiman Thamrin S.Kom', 'Malang', '1998-02-21', 'L', 'Bappeda', 'UPT 4', '085714103232', 'prajasa@example.org', 'PNS', 'Ditolak', '2023-07-20', NULL, '2025-09-03 20:29:08', '2025-09-03 20:29:08'),
	(80, '6858411294669855', 'NRK51128209', 'Satya Firmansyah S.IP', 'Pematangsiantar', '2000-11-04', 'L', 'Dinas Pendidikan', 'UPT 1', '086629264848', 'safitri.kamila@example.net', 'CPNS', 'Ditolak', '2022-04-26', NULL, '2025-09-03 20:29:08', '2025-09-03 20:29:08'),
	(81, '5898108877157291', 'NRK81315032', 'Tiara Pia Safitri', 'Surakarta', '1979-03-09', 'P', 'Dinas Pendidikan', 'UPT 3', '087467091636', 'cakrawala.rahayu@example.com', 'PPPK', 'Ditolak', '2021-03-28', NULL, '2025-09-03 20:29:08', '2025-09-03 20:29:08'),
	(82, '2225837017082195', 'NRK52481528', 'Candrakanta Raharja Marbun', 'Tual', '1974-01-30', 'L', 'Dinas Pendidikan', 'UPT 3', '082491889372', 'situmorang.mila@example.com', 'PNS', 'Belum MCU', NULL, NULL, '2025-09-03 20:29:08', '2025-09-03 20:29:08'),
	(83, '8661919713857118', 'NRK97717984', 'Jais Darman Ramadan', 'Tomohon', '1972-07-06', 'L', 'Bappeda', 'UPT 2', '080711983531', 'bambang39@example.org', 'CPNS', 'Belum MCU', NULL, NULL, '2025-09-03 20:29:08', '2025-09-03 20:29:08'),
	(84, '9686867656640714', 'NRK41402592', 'Lamar Darmana Nababan', 'Bekasi', '1987-04-06', 'L', 'Sekretariat Daerah', 'UPT 4', '086963681458', 'kayla15@example.net', 'PPPK', 'Ditolak', '2022-06-19', 'Ut accusantium nesciunt est illo esse id omnis.', '2025-09-03 20:29:08', '2025-09-03 20:29:08'),
	(85, '8703023845004985', 'NRK87654364', 'Nadine Fujiati S.Pt', 'Banda Aceh', '2003-03-13', 'P', 'Dinas Kesehatan', 'UPT 1', '088857563733', 'gamani.utami@example.com', 'PPPK', 'Sudah MCU', '2023-01-14', NULL, '2025-09-03 20:29:08', '2025-09-03 20:29:08'),
	(86, '2137525024636347', 'NRK57963643', 'Kasiran Mangunsong M.M.', 'Banjarmasin', '1969-04-02', 'L', 'Dinas Kesehatan', 'UPT 2', '085675978960', 'akarsana97@example.org', 'CPNS', 'Sudah MCU', '2022-07-29', NULL, '2025-09-03 20:29:08', '2025-09-03 20:29:08'),
	(87, '3927251092406648', 'NRK14648358', 'Victoria Wulandari', 'Sungai Penuh', '1997-04-16', 'P', 'Sekretariat Daerah', 'UPT 3', '080559041930', 'tantri63@example.org', 'CPNS', 'Belum MCU', NULL, NULL, '2025-09-03 20:29:08', '2025-09-03 20:29:08'),
	(88, '9181375532833240', 'NRK90748423', 'Mutia Halimah S.E.I', 'Banda Aceh', '1990-05-06', 'P', 'Bappeda', 'UPT 1', '081179943488', 'qrahimah@example.org', 'CPNS', 'Ditolak', '2025-08-12', NULL, '2025-09-03 20:29:08', '2025-09-03 20:29:08'),
	(89, '6189954881739972', 'NRK23473696', 'Mahfud Ardianto', 'Ternate', '1975-11-21', 'L', 'Bappeda', 'UPT 2', '085755113341', 'gadang60@example.org', 'PPPK', 'Belum MCU', NULL, NULL, '2025-09-03 20:29:08', '2025-09-03 20:29:08'),
	(90, '2240475169456362', 'NRK08365022', 'Taufan Wasita', 'Cirebon', '1993-07-14', 'L', 'Sekretariat Daerah', 'UPT 4', '082623518751', 'nugraha.hasanah@example.com', 'PPPK', 'Belum MCU', NULL, NULL, '2025-09-03 20:29:08', '2025-09-03 20:29:08'),
	(91, '0758988847703839', 'NRK39297092', 'Galur Rama Marbun S.IP', 'Samarinda', '1984-04-16', 'L', 'Dinas Perhubungan', 'UPT 2', '089514504284', 'ryuniar@example.net', 'CPNS', 'Belum MCU', NULL, 'Cupiditate sed atque in illo minus eos.', '2025-09-03 20:29:08', '2025-09-03 20:29:08'),
	(92, '5430878351409194', 'NRK92976377', 'Siska Wastuti', 'Batam', '1989-03-23', 'P', 'Dinas Pendidikan', 'UPT 4', '085183751617', 'hmaheswara@example.org', 'PNS', 'Ditolak', '2025-06-28', NULL, '2025-09-03 20:29:08', '2025-09-03 20:29:08'),
	(93, '1125114412764308', 'NRK84822023', 'Bakianto Siregar S.Psi', 'Bogor', '1970-05-07', 'L', 'Bappeda', 'UPT 1', '081298379923', 'wasis.prabowo@example.net', 'PNS', 'Ditolak', '2025-07-01', NULL, '2025-09-03 20:29:08', '2025-09-03 20:29:08'),
	(94, '8769116244993339', 'NRK74890425', 'Karna Ramadan', 'Surakarta', '1987-08-15', 'L', 'Sekretariat Daerah', 'UPT 1', '086283975042', 'jelita.zulkarnain@example.net', 'PPPK', 'Belum MCU', NULL, NULL, '2025-09-03 20:29:08', '2025-09-03 20:29:08'),
	(95, '8106964243386543', 'NRK82930403', 'Dodo Megantara', 'Kendari', '1976-04-12', 'L', 'Dinas Kesehatan', 'UPT 5', '088732967081', 'klaksita@example.org', 'PNS', 'Belum MCU', NULL, NULL, '2025-09-03 20:29:08', '2025-09-03 20:29:08'),
	(96, '6963398528468312', 'NRK25865073', 'Saka Empluk Megantara M.Pd', 'Tangerang Selatan', '1972-07-18', 'L', 'Dinas Perhubungan', 'UPT 1', '089645427993', 'cagak.gunarto@example.net', 'PNS', 'Ditolak', '2022-02-10', NULL, '2025-09-03 20:29:08', '2025-09-03 20:29:08'),
	(97, '9292081032693601', 'NRK12109178', 'Sari Safitri M.Ak', 'Lhokseumawe', '2005-06-30', 'P', 'Dinas Kesehatan', 'UPT 1', '089904903945', 'utama.kiandra@example.com', 'CPNS', 'Belum MCU', NULL, NULL, '2025-09-03 20:29:08', '2025-09-03 20:29:08'),
	(98, '5511373130154713', 'NRK54418012', 'Zulaikha Fujiati', 'Jayapura', '1983-08-01', 'P', 'Dinas Perhubungan', 'UPT 4', '080075535874', 'pia46@example.org', 'CPNS', 'Belum MCU', NULL, NULL, '2025-09-03 20:29:08', '2025-09-03 20:29:08'),
	(99, '3890335247353816', 'NRK70875617', 'Daliman Saputra', 'Padang', '1981-07-06', 'L', 'Sekretariat Daerah', 'UPT 2', '087119790533', 'yuliarti.jamal@example.org', 'PPPK', 'Sudah MCU', '2022-01-12', NULL, '2025-09-03 20:29:08', '2025-09-03 20:29:08'),
	(100, '9518581840116883', 'NRK70521776', 'Lintang Zelaya Halimah', 'Tarakan', '2001-10-27', 'P', 'Dinas Perhubungan', 'UPT 3', '082871339892', 'prasetyo.tami@example.net', 'CPNS', 'Belum MCU', NULL, NULL, '2025-09-03 20:29:08', '2025-09-03 20:29:08');

-- Dumping structure for table monitoring_mcu.password_reset_tokens
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table monitoring_mcu.password_reset_tokens: ~0 rows (approximately)

-- Dumping structure for table monitoring_mcu.permissions
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
) ENGINE=InnoDB AUTO_INCREMENT=139 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table monitoring_mcu.schedules: ~137 rows (approximately)
REPLACE INTO `schedules` (`id`, `participant_id`, `nik_ktp`, `nrk_pegawai`, `nama_lengkap`, `tanggal_lahir`, `jenis_kelamin`, `skpd`, `ukpd`, `no_telp`, `email`, `tanggal_pemeriksaan`, `jam_pemeriksaan`, `lokasi_pemeriksaan`, `status`, `queue_number`, `participant_confirmed`, `participant_confirmed_at`, `reschedule_requested`, `reschedule_new_date`, `reschedule_new_time`, `reschedule_reason`, `reschedule_requested_at`, `email_sent`, `whatsapp_sent`, `email_sent_at`, `whatsapp_sent_at`, `catatan`, `created_at`, `updated_at`) VALUES
	(1, 1, '9191343531083708', 'NRK18802225', 'Lanang Suryono', '1994-02-08', 'L', 'Dinas Perhubungan', 'UPT 4', '082864860194', 'mandasari.jail@example.org', '2026-02-22', '05:20:00', 'RSUD Kota', 'Terjadwal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, '2025-09-03 20:29:08', '2025-09-03 20:29:08'),
	(2, 2, '1353709589100153', 'NRK73021586', 'Tedi Bakiadi Siregar S.Pt', '1977-08-29', 'L', 'Dinas Pendidikan', 'UPT 4', '086964336712', 'agnes09@example.net', '2025-09-04', '07:10:00', 'RSUD Kota', 'Selesai', 2, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, '2025-08-05 20:29:08', '2025-08-07 20:29:08', NULL, '2025-09-03 20:29:08', '2025-09-03 20:53:19'),
	(3, 2, '1353709589100153', 'NRK73021586', 'Tedi Bakiadi Siregar S.Pt', '1977-08-29', 'L', 'Dinas Pendidikan', 'UPT 4', '086964336712', 'agnes09@example.net', '2025-11-01', '00:34:00', 'RS Bakti Husada', 'Terjadwal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, '2025-09-03 20:29:08', '2025-09-03 20:29:08'),
	(4, 3, '9779889211102710', 'NRK04017520', 'Soleh Sihombing', '1968-05-05', 'L', 'Dinas Perhubungan', 'UPT 5', '088785088249', 'upurnawati@example.com', '2025-10-16', '02:00:00', 'RS Permata Hati', 'Terjadwal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, '2025-09-03 20:29:08', '2025-09-03 20:29:08'),
	(5, 3, '9779889211102710', 'NRK04017520', 'Soleh Sihombing', '1968-05-05', 'L', 'Dinas Perhubungan', 'UPT 5', '088785088249', 'upurnawati@example.com', '2023-11-08', '13:15:00', 'RS Permata Hati', 'Selesai', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, '2025-08-26 20:29:08', '2025-08-06 20:29:08', NULL, '2025-09-03 20:29:08', '2025-09-03 20:29:08'),
	(6, 3, '9779889211102710', 'NRK04017520', 'Soleh Sihombing', '1968-05-05', 'L', 'Dinas Perhubungan', 'UPT 5', '088785088249', 'upurnawati@example.com', '2026-02-05', '03:11:00', 'RS Bakti Husada', 'Terjadwal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, '2025-09-03 20:29:08', '2025-09-03 20:29:08'),
	(7, 4, '9476264224120438', 'NRK49681218', 'Cemani Hutasoit S.Pd', '1989-10-27', 'L', 'Dinas Kesehatan', 'UPT 4', '086563566332', 'hartati.hesti@example.org', '2024-01-12', '20:25:00', 'RSUD Kota', 'Selesai', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, '2025-08-07 20:29:08', '2025-08-16 20:29:08', NULL, '2025-09-03 20:29:08', '2025-09-03 20:29:08'),
	(8, 5, '4509748956317060', 'NRK06092686', 'Labuh Okta Wasita', '1992-02-12', 'L', 'Dinas Kesehatan', 'UPT 3', '085481526891', 'pratama.lamar@example.org', '2025-04-16', '22:06:00', 'RS Bakti Husada', 'Selesai', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, '2025-08-29 20:29:08', '2025-08-24 20:29:08', NULL, '2025-09-03 20:29:08', '2025-09-03 20:29:08'),
	(9, 5, '4509748956317060', 'NRK06092686', 'Labuh Okta Wasita', '1992-02-12', 'L', 'Dinas Kesehatan', 'UPT 3', '085481526891', 'pratama.lamar@example.org', '2025-11-30', '23:15:00', 'RSUD Kota', 'Terjadwal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, '2025-09-03 20:29:08', '2025-09-03 20:29:08'),
	(10, 7, '8336109928590247', 'NRK93326761', 'Zelda Hartati', '1977-09-20', 'P', 'Dinas Perhubungan', 'UPT 4', '081657760199', 'uwais.ajimin@example.net', '2026-02-21', '23:15:00', 'Klinik Sehat Sentosa', 'Terjadwal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, '2025-09-03 20:29:08', '2025-09-03 20:29:08'),
	(11, 8, '8497542367974666', 'NRK29215374', 'Usman Nashiruddin', '1980-09-06', 'L', 'Dinas Pendidikan', 'UPT 3', '089453756988', 'rhutapea@example.org', '2025-04-24', '23:28:00', 'RS Bakti Husada', 'Selesai', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, 0, '2025-08-12 20:29:08', NULL, 'Occaecati quidem fugiat eligendi sit.', '2025-09-03 20:29:08', '2025-09-03 20:29:08'),
	(12, 8, '8497542367974666', 'NRK29215374', 'Usman Nashiruddin', '1980-09-06', 'L', 'Dinas Pendidikan', 'UPT 3', '089453756988', 'rhutapea@example.org', '2023-11-14', '06:49:00', 'RSUD Kota', 'Selesai', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, '2025-08-11 20:29:08', '2025-09-01 20:29:08', NULL, '2025-09-03 20:29:08', '2025-09-03 20:29:08'),
	(13, 8, '8497542367974666', 'NRK29215374', 'Usman Nashiruddin', '1980-09-06', 'L', 'Dinas Pendidikan', 'UPT 3', '089453756988', 'rhutapea@example.org', '2025-09-26', '11:57:00', 'RSUD Kota', 'Terjadwal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, 'Voluptatibus voluptas libero incidunt.', '2025-09-03 20:29:08', '2025-09-03 20:29:08'),
	(14, 9, '8203964692051667', 'NRK97116060', 'Alika Puspita S.Pt', '1994-01-26', 'P', 'Dinas Kesehatan', 'UPT 1', '083886291837', 'aryani.yoga@example.com', '2025-09-28', '14:26:00', 'RSUD Kota', 'Terjadwal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, '2025-09-03 20:29:08', '2025-09-03 20:29:08'),
	(15, 9, '8203964692051667', 'NRK97116060', 'Alika Puspita S.Pt', '1994-01-26', 'P', 'Dinas Kesehatan', 'UPT 1', '083886291837', 'aryani.yoga@example.com', '2024-05-16', '17:34:00', 'Klinik Medika Utama', 'Selesai', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 1, NULL, '2025-08-28 20:29:09', NULL, '2025-09-03 20:29:09', '2025-09-03 20:29:09'),
	(16, 9, '8203964692051667', 'NRK97116060', 'Alika Puspita S.Pt', '1994-01-26', 'P', 'Dinas Kesehatan', 'UPT 1', '083886291837', 'aryani.yoga@example.com', '2025-10-15', '17:18:00', 'Klinik Sehat Sentosa', 'Terjadwal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, '2025-09-03 20:29:09', '2025-09-03 20:29:09'),
	(17, 10, '8642630301106016', 'NRK30147489', 'Puti Zulaika M.Kom.', '1994-07-25', 'P', 'Bappeda', 'UPT 5', '083184332932', 'farhunnisa.usamah@example.org', '2023-10-19', '01:20:00', 'RS Permata Hati', 'Selesai', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 1, NULL, '2025-08-14 20:29:09', NULL, '2025-09-03 20:29:09', '2025-09-03 20:29:09'),
	(18, 11, '1909831408631259', 'NRK27411971', 'Azalea Vera Hartati', '1978-07-17', 'P', 'Dinas Perhubungan', 'UPT 3', '085407395163', 'cakrawangsa.hidayanto@example.net', '2026-02-26', '20:02:00', 'Klinik Sehat Sentosa', 'Terjadwal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, '2025-09-03 20:29:09', '2025-09-03 20:29:09'),
	(19, 12, '8625561037069846', 'NRK36058497', 'Jessica Permata', '1974-09-03', 'P', 'Dinas Pendidikan', 'UPT 3', '089123540729', 'cprabowo@example.com', '2025-05-25', '06:41:00', 'Klinik Sehat Sentosa', 'Selesai', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 1, NULL, '2025-08-17 20:29:09', NULL, '2025-09-03 20:29:09', '2025-09-03 20:29:09'),
	(20, 12, '8625561037069846', 'NRK36058497', 'Jessica Permata', '1974-09-03', 'P', 'Dinas Pendidikan', 'UPT 3', '089123540729', 'cprabowo@example.com', '2026-02-28', '17:56:00', 'Klinik Sehat Sentosa', 'Terjadwal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, 'Molestiae provident magnam tempore dolore fuga.', '2025-09-03 20:29:09', '2025-09-03 20:29:09'),
	(21, 13, '6168437007070995', 'NRK75985302', 'Kawaya Radit Wijaya', '1975-05-09', 'L', 'Sekretariat Daerah', 'UPT 1', '085749292349', 'kusmawati.ganda@example.net', '2025-08-31', '18:37:00', 'Klinik Medika Utama', 'Selesai', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 1, NULL, '2025-08-23 20:29:09', NULL, '2025-09-03 20:29:09', '2025-09-03 20:29:09'),
	(22, 13, '6168437007070995', 'NRK75985302', 'Kawaya Radit Wijaya', '1975-05-09', 'L', 'Sekretariat Daerah', 'UPT 1', '085749292349', 'kusmawati.ganda@example.net', '2025-02-14', '21:13:00', 'RSUD Kota', 'Batal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 1, NULL, '2025-08-20 20:29:09', 'Quia et ut eum magnam explicabo odio aut.', '2025-09-03 20:29:09', '2025-09-03 20:29:09'),
	(23, 15, '8745249429034252', 'NRK39601695', 'Sadina Cici Widiastuti M.Ak', '1967-06-21', 'P', 'Sekretariat Daerah', 'UPT 2', '082021663957', 'wawan.rahayu@example.net', '2024-01-26', '16:29:00', 'RSUD Kota', 'Selesai', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, '2025-08-10 20:29:09', '2025-08-30 20:29:09', NULL, '2025-09-03 20:29:09', '2025-09-03 20:29:09'),
	(24, 15, '8745249429034252', 'NRK39601695', 'Sadina Cici Widiastuti M.Ak', '1967-06-21', 'P', 'Sekretariat Daerah', 'UPT 2', '082021663957', 'wawan.rahayu@example.net', '2026-02-12', '16:12:00', 'RS Permata Hati', 'Terjadwal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, '2025-09-03 20:29:09', '2025-09-03 20:29:09'),
	(25, 16, '5988906012996226', 'NRK91458831', 'Jail Dimaz Setiawan M.Kom.', '1987-02-09', 'L', 'Sekretariat Daerah', 'UPT 2', '081564168276', 'pagustina@example.com', '2025-05-24', '02:56:00', 'RS Bakti Husada', 'Selesai', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 1, NULL, '2025-08-09 20:29:09', NULL, '2025-09-03 20:29:09', '2025-09-03 20:29:09'),
	(26, 16, '5988906012996226', 'NRK91458831', 'Jail Dimaz Setiawan M.Kom.', '1987-02-09', 'L', 'Sekretariat Daerah', 'UPT 2', '081564168276', 'pagustina@example.com', '2024-02-06', '12:33:00', 'Klinik Medika Utama', 'Selesai', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, '2025-08-05 20:29:09', '2025-08-24 20:29:09', NULL, '2025-09-03 20:29:09', '2025-09-03 20:29:09'),
	(27, 17, '5931539523720941', 'NRK31007451', 'Mursita Hutapea', '1997-10-08', 'L', 'Dinas Perhubungan', 'UPT 1', '088326626689', 'nainggolan.silvia@example.com', '2025-04-13', '22:47:00', 'RS Bakti Husada', 'Batal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 1, NULL, '2025-09-03 20:29:09', NULL, '2025-09-03 20:29:09', '2025-09-03 20:29:09'),
	(28, 17, '5931539523720941', 'NRK31007451', 'Mursita Hutapea', '1997-10-08', 'L', 'Dinas Perhubungan', 'UPT 1', '088326626689', 'nainggolan.silvia@example.com', '2024-12-28', '19:41:00', 'RS Bakti Husada', 'Batal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 1, NULL, '2025-09-02 20:29:09', NULL, '2025-09-03 20:29:09', '2025-09-03 20:29:09'),
	(29, 17, '5931539523720941', 'NRK31007451', 'Mursita Hutapea', '1997-10-08', 'L', 'Dinas Perhubungan', 'UPT 1', '088326626689', 'nainggolan.silvia@example.com', '2026-01-30', '11:32:00', 'Klinik Sehat Sentosa', 'Terjadwal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, '2025-09-03 20:29:09', '2025-09-03 20:29:09'),
	(30, 19, '2350557554961764', 'NRK40922596', 'Yance Vanya Rahmawati', '1973-04-19', 'P', 'Bappeda', 'UPT 5', '082429065243', 'astuti.zamira@example.net', '2024-09-29', '08:30:00', 'Klinik Medika Utama', 'Selesai', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, '2025-09-03 20:29:09', '2025-09-03 20:29:09'),
	(31, 19, '2350557554961764', 'NRK40922596', 'Yance Vanya Rahmawati', '1973-04-19', 'P', 'Bappeda', 'UPT 5', '082429065243', 'astuti.zamira@example.net', '2025-09-22', '09:31:00', 'RS Permata Hati', 'Terjadwal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, '2025-09-03 20:29:09', '2025-09-03 20:29:09'),
	(32, 19, '2350557554961764', 'NRK40922596', 'Yance Vanya Rahmawati', '1973-04-19', 'P', 'Bappeda', 'UPT 5', '082429065243', 'astuti.zamira@example.net', '2025-05-28', '09:13:00', 'RS Bakti Husada', 'Batal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 1, NULL, '2025-08-20 20:29:09', NULL, '2025-09-03 20:29:09', '2025-09-03 20:29:09'),
	(33, 20, '7952921179667963', 'NRK05201469', 'Jaeman Winarno M.Farm', '1967-05-28', 'L', 'Dinas Pendidikan', 'UPT 5', '086464907840', 'yuni.habibi@example.com', '2025-11-16', '12:38:00', 'RS Permata Hati', 'Batal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, '2025-09-01 20:29:09', '2025-08-12 20:29:09', 'Omnis totam quae autem quibusdam odit.', '2025-09-03 20:29:09', '2025-09-03 20:29:09'),
	(34, 22, '5875565790985336', 'NRK78712764', 'Julia Kusmawati', '1983-09-15', 'P', 'Bappeda', 'UPT 2', '085977225173', 'ajiman.novitasari@example.net', '2024-11-13', '02:01:00', 'RS Permata Hati', 'Selesai', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, '2025-08-30 20:29:09', '2025-08-21 20:29:09', NULL, '2025-09-03 20:29:09', '2025-09-03 20:29:09'),
	(35, 22, '5875565790985336', 'NRK78712764', 'Julia Kusmawati', '1983-09-15', 'P', 'Bappeda', 'UPT 2', '085977225173', 'ajiman.novitasari@example.net', '2025-09-04', '23:07:00', 'RS Bakti Husada', 'Terjadwal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, '2025-09-03 20:29:09', '2025-09-03 20:29:09'),
	(36, 22, '5875565790985336', 'NRK78712764', 'Julia Kusmawati', '1983-09-15', 'P', 'Bappeda', 'UPT 2', '085977225173', 'ajiman.novitasari@example.net', '2025-11-30', '12:44:00', 'Klinik Sehat Sentosa', 'Terjadwal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, '2025-09-03 20:29:09', '2025-09-03 20:29:09'),
	(37, 23, '8898200543400277', 'NRK39437566', 'Dasa Lurhur Mangunsong', '1991-11-15', 'L', 'Bappeda', 'UPT 3', '080711893332', 'mardhiyah.yoga@example.net', '2025-02-13', '04:59:00', 'RS Bakti Husada', 'Selesai', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, '2025-08-07 20:29:09', '2025-08-31 20:29:09', NULL, '2025-09-03 20:29:09', '2025-09-03 20:29:09'),
	(38, 23, '8898200543400277', 'NRK39437566', 'Dasa Lurhur Mangunsong', '1991-11-15', 'L', 'Bappeda', 'UPT 3', '080711893332', 'mardhiyah.yoga@example.net', '2025-05-19', '00:06:00', 'RSUD Kota', 'Selesai', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, '2025-08-08 20:29:09', '2025-08-17 20:29:09', NULL, '2025-09-03 20:29:09', '2025-09-03 20:29:09'),
	(39, 23, '8898200543400277', 'NRK39437566', 'Dasa Lurhur Mangunsong', '1991-11-15', 'L', 'Bappeda', 'UPT 3', '080711893332', 'mardhiyah.yoga@example.net', '2026-02-20', '13:54:00', 'RSUD Kota', 'Terjadwal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, '2025-09-03 20:29:09', '2025-09-03 20:29:09'),
	(40, 25, '6568980031656078', 'NRK14600934', 'Padmi Tina Nasyiah', '1973-03-03', 'P', 'Dinas Pendidikan', 'UPT 2', '083235654271', 'kiandra.tamba@example.com', '2026-01-12', '08:04:00', 'RSUD Kota', 'Terjadwal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, '2025-09-03 20:29:09', '2025-09-03 20:29:09'),
	(41, 26, '8081600118962082', 'NRK67043012', 'Ida Tiara Hastuti', '1987-05-15', 'P', 'Dinas Kesehatan', 'UPT 5', '083562726232', 'jono.gunarto@example.org', '2025-11-07', '05:22:00', 'RS Permata Hati', 'Terjadwal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, 'Est rerum et repudiandae quo sapiente iusto porro.', '2025-09-03 20:29:09', '2025-09-03 20:29:09'),
	(42, 26, '8081600118962082', 'NRK67043012', 'Ida Tiara Hastuti', '1987-05-15', 'P', 'Dinas Kesehatan', 'UPT 5', '083562726232', 'jono.gunarto@example.org', '2023-11-09', '13:30:00', 'RS Bakti Husada', 'Selesai', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, '2025-08-22 20:29:09', '2025-08-09 20:29:09', 'Eaque ducimus officiis dolorum laudantium maxime blanditiis.', '2025-09-03 20:29:09', '2025-09-03 20:29:09'),
	(43, 27, '3409584376252244', 'NRK78277425', 'Luthfi Prabowo', '2002-08-01', 'L', 'Dinas Perhubungan', 'UPT 2', '081902983121', 'maimunah78@example.com', '2025-08-22', '20:39:00', 'Klinik Sehat Sentosa', 'Selesai', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, '2025-09-03 20:29:09', '2025-09-03 20:29:09'),
	(44, 28, '1974800009821769', 'NRK65222023', 'Olivia Hartati', '2001-07-14', 'P', 'Dinas Kesehatan', 'UPT 2', '084236991790', 'najib80@example.com', '2025-04-24', '22:27:00', 'RSUD Kota', 'Selesai', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, '2025-08-14 20:29:09', '2025-08-11 20:29:09', NULL, '2025-09-03 20:29:09', '2025-09-03 20:29:09'),
	(45, 28, '1974800009821769', 'NRK65222023', 'Olivia Hartati', '2001-07-14', 'P', 'Dinas Kesehatan', 'UPT 2', '084236991790', 'najib80@example.com', '2025-10-10', '16:13:00', 'RS Permata Hati', 'Terjadwal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, '2025-09-03 20:29:09', '2025-09-03 20:29:09'),
	(46, 30, '2114332162924867', 'NRK99495204', 'Nilam Yolanda', '1983-10-14', 'P', 'Dinas Perhubungan', 'UPT 1', '087406577861', 'lestari.ida@example.org', '2025-11-11', '05:28:00', 'RSUD Kota', 'Terjadwal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, '2025-09-03 20:29:09', '2025-09-03 20:29:09'),
	(47, 30, '2114332162924867', 'NRK99495204', 'Nilam Yolanda', '1983-10-14', 'P', 'Dinas Perhubungan', 'UPT 1', '087406577861', 'lestari.ida@example.org', '2025-01-14', '17:35:00', 'RS Permata Hati', 'Selesai', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, '2025-08-20 20:29:09', '2025-08-12 20:29:09', 'Consequuntur veritatis sint sit alias laboriosam.', '2025-09-03 20:29:09', '2025-09-03 20:29:09'),
	(48, 30, '2114332162924867', 'NRK99495204', 'Nilam Yolanda', '1983-10-14', 'P', 'Dinas Perhubungan', 'UPT 1', '087406577861', 'lestari.ida@example.org', '2025-10-18', '01:46:00', 'RS Bakti Husada', 'Terjadwal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, '2025-09-03 20:29:09', '2025-09-03 20:29:09'),
	(49, 31, '1484042069695566', 'NRK40418953', 'Umar Setiawan M.M.', '1986-10-20', 'L', 'Dinas Pendidikan', 'UPT 3', '088295003361', 'wacana.ghaliyati@example.com', '2025-04-10', '15:46:00', 'Klinik Sehat Sentosa', 'Selesai', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, '2025-08-23 20:29:09', '2025-08-12 20:29:09', NULL, '2025-09-03 20:29:09', '2025-09-03 20:29:09'),
	(50, 31, '1484042069695566', 'NRK40418953', 'Umar Setiawan M.M.', '1986-10-20', 'L', 'Dinas Pendidikan', 'UPT 3', '088295003361', 'wacana.ghaliyati@example.com', '2026-02-06', '15:55:00', 'RS Bakti Husada', 'Terjadwal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, '2025-09-03 20:29:09', '2025-09-03 20:29:09'),
	(51, 32, '9028290176343202', 'NRK77888416', 'Widya Hasanah', '2004-07-25', 'P', 'Dinas Pendidikan', 'UPT 2', '084029385765', 'eli93@example.org', '2025-12-03', '09:33:00', 'RS Bakti Husada', 'Terjadwal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, '2025-09-03 20:29:09', '2025-09-03 20:29:09'),
	(52, 33, '0353765121730707', 'NRK69602035', 'Jasmin Genta Farida S.Pt', '1982-05-28', 'P', 'Dinas Perhubungan', 'UPT 5', '080317355226', 'mulyani.hardi@example.net', '2025-12-01', '07:07:00', 'RS Permata Hati', 'Terjadwal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, '2025-09-03 20:29:09', '2025-09-03 20:29:09'),
	(53, 35, '8916274791018114', 'NRK71023347', 'Tania Susanti S.Kom', '1999-03-11', 'P', 'Sekretariat Daerah', 'UPT 1', '085704481499', 'drajat34@example.com', '2025-11-05', '22:59:00', 'RS Permata Hati', 'Terjadwal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, '2025-09-03 20:29:09', '2025-09-03 20:29:09'),
	(54, 35, '8916274791018114', 'NRK71023347', 'Tania Susanti S.Kom', '1999-03-11', 'P', 'Sekretariat Daerah', 'UPT 1', '085704481499', 'drajat34@example.com', '2024-08-25', '21:33:00', 'RS Permata Hati', 'Selesai', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 1, NULL, '2025-08-21 20:29:09', NULL, '2025-09-03 20:29:09', '2025-09-03 20:29:09'),
	(55, 36, '4174810570224994', 'NRK22132355', 'Himawan Salahudin', '1983-10-25', 'L', 'Dinas Perhubungan', 'UPT 2', '084009291166', 'usman.sihotang@example.org', '2024-12-20', '20:49:00', 'Klinik Medika Utama', 'Selesai', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, 0, '2025-08-14 20:29:09', NULL, NULL, '2025-09-03 20:29:09', '2025-09-03 20:29:09'),
	(56, 36, '4174810570224994', 'NRK22132355', 'Himawan Salahudin', '1983-10-25', 'L', 'Dinas Perhubungan', 'UPT 2', '084009291166', 'usman.sihotang@example.org', '2023-10-27', '03:27:00', 'RS Bakti Husada', 'Selesai', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, '2025-08-16 20:29:09', '2025-08-25 20:29:09', NULL, '2025-09-03 20:29:09', '2025-09-03 20:29:09'),
	(57, 36, '4174810570224994', 'NRK22132355', 'Himawan Salahudin', '1983-10-25', 'L', 'Dinas Perhubungan', 'UPT 2', '084009291166', 'usman.sihotang@example.org', '2025-11-14', '03:49:00', 'Klinik Sehat Sentosa', 'Batal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, '2025-08-29 20:29:09', '2025-08-22 20:29:09', 'Eum et consequatur consequatur laborum.', '2025-09-03 20:29:09', '2025-09-03 20:29:09'),
	(58, 37, '0081683729852088', 'NRK49618182', 'Rahmat Pranowo', '1975-09-15', 'L', 'Bappeda', 'UPT 1', '087331130727', 'aurora.ramadan@example.com', '2025-12-23', '07:41:00', 'Klinik Medika Utama', 'Terjadwal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, '2025-09-03 20:29:09', '2025-09-03 20:29:09'),
	(59, 37, '0081683729852088', 'NRK49618182', 'Rahmat Pranowo', '1975-09-15', 'L', 'Bappeda', 'UPT 1', '087331130727', 'aurora.ramadan@example.com', '2025-02-07', '19:42:00', 'Klinik Medika Utama', 'Selesai', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, '2025-08-14 20:29:09', '2025-08-06 20:29:09', NULL, '2025-09-03 20:29:09', '2025-09-03 20:29:09'),
	(60, 37, '0081683729852088', 'NRK49618182', 'Rahmat Pranowo', '1975-09-15', 'L', 'Bappeda', 'UPT 1', '087331130727', 'aurora.ramadan@example.com', '2025-05-23', '20:56:00', 'Klinik Medika Utama', 'Selesai', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 1, NULL, '2025-08-25 20:29:09', NULL, '2025-09-03 20:29:09', '2025-09-03 20:29:09'),
	(61, 39, '0733974887331626', 'NRK54626479', 'Oni Purnawati', '1996-12-17', 'P', 'Sekretariat Daerah', 'UPT 4', '087507090565', 'kuswandari.carla@example.com', '2024-10-30', '04:19:00', 'RSUD Kota', 'Selesai', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, '2025-09-01 20:29:09', '2025-08-16 20:29:09', NULL, '2025-09-03 20:29:09', '2025-09-03 20:29:09'),
	(62, 39, '0733974887331626', 'NRK54626479', 'Oni Purnawati', '1996-12-17', 'P', 'Sekretariat Daerah', 'UPT 4', '087507090565', 'kuswandari.carla@example.com', '2024-04-05', '13:16:00', 'Klinik Sehat Sentosa', 'Selesai', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, '2025-08-21 20:29:09', '2025-08-24 20:29:09', 'Error non deserunt architecto laudantium.', '2025-09-03 20:29:09', '2025-09-03 20:29:09'),
	(63, 41, '3167725023191305', 'NRK71627998', 'Warsita Saragih', '1974-12-15', 'L', 'Sekretariat Daerah', 'UPT 5', '088299684410', 'vmanullang@example.com', '2025-03-03', '07:27:00', 'Klinik Medika Utama', 'Selesai', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, '2025-08-08 20:29:09', '2025-08-05 20:29:09', NULL, '2025-09-03 20:29:09', '2025-09-03 20:29:09'),
	(64, 41, '3167725023191305', 'NRK71627998', 'Warsita Saragih', '1974-12-15', 'L', 'Sekretariat Daerah', 'UPT 5', '088299684410', 'vmanullang@example.com', '2025-01-19', '12:22:00', 'Klinik Sehat Sentosa', 'Selesai', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, '2025-09-03 20:29:09', '2025-09-03 20:29:09'),
	(65, 44, '5936743162505298', 'NRK73572985', 'Agnes Hastuti', '1981-01-02', 'P', 'Dinas Kesehatan', 'UPT 1', '088399715471', 'juli.wacana@example.org', '2023-10-26', '14:31:00', 'RS Bakti Husada', 'Selesai', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, '2025-09-03 20:29:09', '2025-08-06 20:29:09', NULL, '2025-09-03 20:29:09', '2025-09-03 20:29:09'),
	(66, 44, '5936743162505298', 'NRK73572985', 'Agnes Hastuti', '1981-01-02', 'P', 'Dinas Kesehatan', 'UPT 1', '088399715471', 'juli.wacana@example.org', '2025-12-12', '14:17:00', 'RS Permata Hati', 'Terjadwal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, '2025-09-03 20:29:10', '2025-09-03 20:29:10'),
	(67, 44, '5936743162505298', 'NRK73572985', 'Agnes Hastuti', '1981-01-02', 'P', 'Dinas Kesehatan', 'UPT 1', '088399715471', 'juli.wacana@example.org', '2026-02-20', '01:47:00', 'RS Permata Hati', 'Terjadwal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, '2025-09-03 20:29:10', '2025-09-03 20:29:10'),
	(68, 45, '9042152862837962', 'NRK33102248', 'Mala Sudiati', '1968-05-28', 'P', 'Bappeda', 'UPT 3', '081949827442', 'vera.maryati@example.net', '2025-12-09', '11:26:00', 'RSUD Kota', 'Terjadwal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, '2025-09-03 20:29:10', '2025-09-03 20:29:10'),
	(69, 46, '9512156204603361', 'NRK82037580', 'Prayoga Kurniawan', '2003-06-10', 'L', 'Dinas Perhubungan', 'UPT 1', '089397820198', 'irfan.astuti@example.org', '2025-10-18', '17:39:00', 'RS Permata Hati', 'Terjadwal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, 'Labore beatae rerum ad maiores voluptatem.', '2025-09-03 20:29:10', '2025-09-03 20:29:10'),
	(70, 46, '9512156204603361', 'NRK82037580', 'Prayoga Kurniawan', '2003-06-10', 'L', 'Dinas Perhubungan', 'UPT 1', '089397820198', 'irfan.astuti@example.org', '2024-10-24', '09:06:00', 'Klinik Sehat Sentosa', 'Batal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 1, NULL, '2025-08-31 20:29:10', NULL, '2025-09-03 20:29:10', '2025-09-03 20:29:10'),
	(71, 47, '8339387581983149', 'NRK99489418', 'Nasim Halim', '1968-07-14', 'L', 'Sekretariat Daerah', 'UPT 1', '085337769026', 'wijaya.hasna@example.com', '2025-11-28', '02:06:00', 'Klinik Medika Utama', 'Terjadwal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, '2025-09-03 20:29:10', '2025-09-03 20:29:10'),
	(72, 50, '7322624495652947', 'NRK11888818', 'Bagiya Irfan Haryanto', '2003-08-05', 'L', 'Dinas Pendidikan', 'UPT 5', '082899339333', 'daryani@example.net', '2024-12-05', '05:20:00', 'RS Bakti Husada', 'Batal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, '2025-09-03 20:29:10', '2025-09-03 20:29:10'),
	(73, 51, '6533852422019357', 'NRK61267588', 'Harjaya Ozy Samosir', '1993-01-19', 'L', 'Sekretariat Daerah', 'UPT 5', '084161711447', 'keisha11@example.com', '2024-09-16', '21:53:00', 'Klinik Medika Utama', 'Selesai', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, '2025-08-07 20:29:10', '2025-08-17 20:29:10', NULL, '2025-09-03 20:29:10', '2025-09-03 20:29:10'),
	(74, 51, '6533852422019357', 'NRK61267588', 'Harjaya Ozy Samosir', '1993-01-19', 'L', 'Sekretariat Daerah', 'UPT 5', '084161711447', 'keisha11@example.com', '2025-10-14', '05:40:00', 'Klinik Medika Utama', 'Terjadwal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, 'Adipisci in quibusdam est recusandae.', '2025-09-03 20:29:10', '2025-09-03 20:29:10'),
	(75, 52, '3405133169753454', 'NRK92655158', 'Ozy Waluyo', '1987-03-08', 'L', 'Dinas Pendidikan', 'UPT 5', '089113715386', 'handayani.azalea@example.com', '2025-01-05', '17:02:00', 'Klinik Sehat Sentosa', 'Batal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, 0, '2025-08-11 20:29:10', NULL, NULL, '2025-09-03 20:29:10', '2025-09-03 20:29:10'),
	(76, 52, '3405133169753454', 'NRK92655158', 'Ozy Waluyo', '1987-03-08', 'L', 'Dinas Pendidikan', 'UPT 5', '089113715386', 'handayani.azalea@example.com', '2024-10-17', '17:28:00', 'RS Permata Hati', 'Batal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 1, NULL, '2025-08-06 20:29:10', 'Sed et consequatur labore consequatur illum ut possimus et.', '2025-09-03 20:29:10', '2025-09-03 20:29:10'),
	(77, 54, '4841638052777768', 'NRK02204822', 'Ega Jaeman Iswahyudi S.E.I', '1976-05-28', 'L', 'Dinas Kesehatan', 'UPT 3', '085638305850', 'queen.marpaung@example.org', '2025-08-21', '16:13:00', 'RSUD Kota', 'Selesai', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, '2025-08-27 20:29:10', '2025-08-21 20:29:10', NULL, '2025-09-03 20:29:10', '2025-09-03 20:29:10'),
	(78, 54, '4841638052777768', 'NRK02204822', 'Ega Jaeman Iswahyudi S.E.I', '1976-05-28', 'L', 'Dinas Kesehatan', 'UPT 3', '085638305850', 'queen.marpaung@example.org', '2025-11-18', '08:20:00', 'Klinik Medika Utama', 'Terjadwal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, '2025-09-03 20:29:10', '2025-09-03 20:29:10'),
	(79, 54, '4841638052777768', 'NRK02204822', 'Ega Jaeman Iswahyudi S.E.I', '1976-05-28', 'L', 'Dinas Kesehatan', 'UPT 3', '085638305850', 'queen.marpaung@example.org', '2024-01-24', '11:28:00', 'RS Bakti Husada', 'Selesai', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, '2025-08-12 20:29:10', '2025-09-02 20:29:10', NULL, '2025-09-03 20:29:10', '2025-09-03 20:29:10'),
	(80, 55, '9626475907919866', 'NRK04805101', 'Melinda Elisa Novitasari S.T.', '1987-04-02', 'P', 'Dinas Perhubungan', 'UPT 1', '087371910851', 'msihotang@example.org', '2025-09-19', '23:01:00', 'RS Bakti Husada', 'Terjadwal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, '2025-09-03 20:29:10', '2025-09-03 20:29:10'),
	(81, 58, '0821239175780783', 'NRK22039559', 'Genta Hariyah', '1969-06-17', 'P', 'Bappeda', 'UPT 3', '085370046384', 'tbudiyanto@example.com', '2025-11-07', '03:23:00', 'Klinik Medika Utama', 'Terjadwal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, '2025-09-03 20:29:10', '2025-09-03 20:29:10'),
	(82, 59, '3170186601570648', 'NRK90436308', 'Hana Padmasari', '2002-08-12', 'P', 'Dinas Kesehatan', 'UPT 3', '082840562071', 'icha.nashiruddin@example.org', '2023-09-27', '03:47:00', 'RSUD Kota', 'Selesai', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, '2025-08-05 20:29:10', '2025-08-25 20:29:10', NULL, '2025-09-03 20:29:10', '2025-09-03 20:29:10'),
	(83, 59, '3170186601570648', 'NRK90436308', 'Hana Padmasari', '2002-08-12', 'P', 'Dinas Kesehatan', 'UPT 3', '082840562071', 'icha.nashiruddin@example.org', '2024-09-11', '09:30:00', 'RS Permata Hati', 'Selesai', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 1, NULL, '2025-08-24 20:29:10', NULL, '2025-09-03 20:29:10', '2025-09-03 20:29:10'),
	(84, 59, '3170186601570648', 'NRK90436308', 'Hana Padmasari', '2002-08-12', 'P', 'Dinas Kesehatan', 'UPT 3', '082840562071', 'icha.nashiruddin@example.org', '2025-10-04', '04:23:00', 'Klinik Medika Utama', 'Terjadwal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, '2025-09-03 20:29:10', '2025-09-03 20:29:10'),
	(85, 61, '4618567823743526', 'NRK85066235', 'Ismail Dongoran', '1980-04-27', 'L', 'Dinas Kesehatan', 'UPT 3', '083439834999', 'prasetya.arsipatra@example.org', '2023-10-05', '09:51:00', 'RS Bakti Husada', 'Selesai', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, '2025-08-18 20:29:10', '2025-08-14 20:29:10', 'Quibusdam nesciunt ad ad inventore.', '2025-09-03 20:29:10', '2025-09-03 20:29:10'),
	(86, 61, '4618567823743526', 'NRK85066235', 'Ismail Dongoran', '1980-04-27', 'L', 'Dinas Kesehatan', 'UPT 3', '083439834999', 'prasetya.arsipatra@example.org', '2024-11-23', '16:01:00', 'RS Bakti Husada', 'Selesai', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, '2025-08-21 20:29:10', '2025-08-04 20:29:10', 'Occaecati nobis iusto ipsam mollitia.', '2025-09-03 20:29:10', '2025-09-03 20:29:10'),
	(87, 62, '4130079557314629', 'NRK85461297', 'Sarah Suartini', '1996-11-18', 'P', 'Dinas Kesehatan', 'UPT 3', '082466696883', 'fzulkarnain@example.net', '2025-10-18', '19:17:00', 'RSUD Kota', 'Terjadwal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, '2025-09-03 20:29:10', '2025-09-03 20:29:10'),
	(88, 63, '2236893789397081', 'NRK21499713', 'Saiful Tamba', '1969-11-04', 'L', 'Dinas Perhubungan', 'UPT 1', '081986600894', 'wibowo.hardi@example.net', '2025-10-29', '07:19:00', 'RSUD Kota', 'Terjadwal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, '2025-09-03 20:29:10', '2025-09-03 20:29:10'),
	(89, 63, '2236893789397081', 'NRK21499713', 'Saiful Tamba', '1969-11-04', 'L', 'Dinas Perhubungan', 'UPT 1', '081986600894', 'wibowo.hardi@example.net', '2025-07-31', '10:11:00', 'Klinik Sehat Sentosa', 'Batal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, '2025-08-07 20:29:10', '2025-08-15 20:29:10', NULL, '2025-09-03 20:29:10', '2025-09-03 20:29:10'),
	(90, 63, '2236893789397081', 'NRK21499713', 'Saiful Tamba', '1969-11-04', 'L', 'Dinas Perhubungan', 'UPT 1', '081986600894', 'wibowo.hardi@example.net', '2025-01-08', '16:38:00', 'RS Bakti Husada', 'Selesai', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 1, NULL, '2025-08-10 20:29:10', NULL, '2025-09-03 20:29:10', '2025-09-03 20:29:10'),
	(91, 64, '3649064178238951', 'NRK58292594', 'Kunthara Rajasa S.T.', '1981-07-10', 'L', 'Dinas Kesehatan', 'UPT 4', '085254376441', 'janet.puspita@example.org', '2024-08-12', '05:02:00', 'RS Permata Hati', 'Selesai', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 1, NULL, '2025-08-31 20:29:10', NULL, '2025-09-03 20:29:10', '2025-09-03 20:29:10'),
	(92, 64, '3649064178238951', 'NRK58292594', 'Kunthara Rajasa S.T.', '1981-07-10', 'L', 'Dinas Kesehatan', 'UPT 4', '085254376441', 'janet.puspita@example.org', '2023-12-29', '19:19:00', 'RS Permata Hati', 'Selesai', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, 0, '2025-08-26 20:29:10', NULL, 'Eveniet itaque veniam rem dolorum rerum.', '2025-09-03 20:29:10', '2025-09-03 20:29:10'),
	(93, 64, '3649064178238951', 'NRK58292594', 'Kunthara Rajasa S.T.', '1981-07-10', 'L', 'Dinas Kesehatan', 'UPT 4', '085254376441', 'janet.puspita@example.org', '2024-02-21', '11:28:00', 'Klinik Sehat Sentosa', 'Selesai', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, 0, '2025-08-07 20:29:10', NULL, 'Doloremque corrupti et excepturi blanditiis.', '2025-09-03 20:29:10', '2025-09-03 20:29:10'),
	(94, 65, '9156424594201170', 'NRK99753368', 'Tedi Budiman S.Farm', '1966-10-04', 'L', 'Dinas Perhubungan', 'UPT 2', '086255038496', 'embuh06@example.com', '2026-02-09', '14:02:00', 'Klinik Medika Utama', 'Terjadwal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, '2025-09-03 20:29:10', '2025-09-03 20:29:10'),
	(95, 65, '9156424594201170', 'NRK99753368', 'Tedi Budiman S.Farm', '1966-10-04', 'L', 'Dinas Perhubungan', 'UPT 2', '086255038496', 'embuh06@example.com', '2026-02-23', '12:12:00', 'RS Permata Hati', 'Terjadwal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, '2025-09-03 20:29:10', '2025-09-03 20:29:10'),
	(96, 66, '0171887301335752', 'NRK15141164', 'Chelsea Winarsih', '1982-09-04', 'P', 'Sekretariat Daerah', 'UPT 4', '085816220529', 'azalea.purnawati@example.net', '2026-01-10', '02:22:00', 'Klinik Sehat Sentosa', 'Terjadwal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, '2025-09-03 20:29:10', '2025-09-03 20:29:10'),
	(97, 66, '0171887301335752', 'NRK15141164', 'Chelsea Winarsih', '1982-09-04', 'P', 'Sekretariat Daerah', 'UPT 4', '085816220529', 'azalea.purnawati@example.net', '2025-10-19', '07:20:00', 'Klinik Medika Utama', 'Terjadwal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, '2025-09-03 20:29:10', '2025-09-03 20:29:10'),
	(98, 67, '9974406615912020', 'NRK97951033', 'Pangestu Nashiruddin S.H.', '1998-01-12', 'L', 'Dinas Pendidikan', 'UPT 4', '087128030771', 'dlaksmiwati@example.org', '2024-12-29', '19:06:00', 'RSUD Kota', 'Selesai', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, '2025-08-10 20:29:10', '2025-08-06 20:29:10', NULL, '2025-09-03 20:29:10', '2025-09-03 20:29:10'),
	(99, 71, '3072677493627732', 'NRK39832941', 'Febi Pia Prastuti', '1989-11-01', 'P', 'Dinas Kesehatan', 'UPT 4', '089142632309', 'kariman.nuraini@example.net', '2024-08-17', '18:29:00', 'RS Permata Hati', 'Selesai', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, '2025-09-03 20:29:10', '2025-08-21 20:29:10', 'Saepe perspiciatis facilis quis.', '2025-09-03 20:29:10', '2025-09-03 20:29:10'),
	(100, 71, '3072677493627732', 'NRK39832941', 'Febi Pia Prastuti', '1989-11-01', 'P', 'Dinas Kesehatan', 'UPT 4', '089142632309', 'kariman.nuraini@example.net', '2023-12-01', '00:44:00', 'Klinik Medika Utama', 'Selesai', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, '2025-09-02 20:29:10', '2025-08-31 20:29:10', NULL, '2025-09-03 20:29:10', '2025-09-03 20:29:10'),
	(101, 71, '3072677493627732', 'NRK39832941', 'Febi Pia Prastuti', '1989-11-01', 'P', 'Dinas Kesehatan', 'UPT 4', '089142632309', 'kariman.nuraini@example.net', '2024-04-04', '22:33:00', 'Klinik Sehat Sentosa', 'Selesai', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, 0, '2025-08-08 20:29:10', NULL, 'Ullam ab accusantium odio corrupti tempore.', '2025-09-03 20:29:10', '2025-09-03 20:29:10'),
	(102, 75, '9835756825943445', 'NRK66397931', 'Vicky Paris Winarsih', '1999-01-27', 'P', 'Bappeda', 'UPT 3', '086226535473', 'clara.halimah@example.org', '2024-04-24', '22:49:00', 'Klinik Medika Utama', 'Selesai', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, '2025-08-28 20:29:10', '2025-08-29 20:29:10', NULL, '2025-09-03 20:29:10', '2025-09-03 20:29:10'),
	(103, 76, '1629723027044398', 'NRK13938223', 'Purwanto Baktiadi Marbun S.T.', '1994-04-12', 'L', 'Dinas Kesehatan', 'UPT 4', '086230396814', 'samsul71@example.org', '2024-05-17', '18:26:00', 'Klinik Medika Utama', 'Selesai', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, '2025-08-22 20:29:10', '2025-08-14 20:29:10', 'Laboriosam quo incidunt aperiam pariatur.', '2025-09-03 20:29:10', '2025-09-03 20:29:10'),
	(104, 78, '5526977026157122', 'NRK86818982', 'Lili Suartini', '1972-04-30', 'P', 'Dinas Kesehatan', 'UPT 2', '080385258574', 'viktor.thamrin@example.net', '2026-01-21', '05:13:00', 'RS Bakti Husada', 'Terjadwal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, '2025-09-03 20:29:10', '2025-09-03 20:29:10'),
	(105, 79, '7040888950211179', 'NRK05492864', 'Xanana Paiman Thamrin S.Kom', '1998-02-21', 'L', 'Bappeda', 'UPT 4', '085714103232', 'prajasa@example.org', '2025-10-18', '03:42:00', 'Klinik Medika Utama', 'Terjadwal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, '2025-09-03 20:29:10', '2025-09-03 20:29:10'),
	(106, 79, '7040888950211179', 'NRK05492864', 'Xanana Paiman Thamrin S.Kom', '1998-02-21', 'L', 'Bappeda', 'UPT 4', '085714103232', 'prajasa@example.org', '2024-10-20', '03:58:00', 'Klinik Medika Utama', 'Batal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, '2025-08-31 20:29:10', '2025-08-05 20:29:10', NULL, '2025-09-03 20:29:10', '2025-09-03 20:29:10'),
	(107, 81, '5898108877157291', 'NRK81315032', 'Tiara Pia Safitri', '1979-03-09', 'P', 'Dinas Pendidikan', 'UPT 3', '087467091636', 'cakrawala.rahayu@example.com', '2025-06-11', '23:15:00', 'Klinik Medika Utama', 'Selesai', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, '2025-09-03 20:29:10', '2025-08-17 20:29:10', 'Et voluptate facere voluptatum provident rerum inventore nihil.', '2025-09-03 20:29:10', '2025-09-03 20:29:10'),
	(108, 82, '2225837017082195', 'NRK52481528', 'Candrakanta Raharja Marbun', '1974-01-30', 'L', 'Dinas Pendidikan', 'UPT 3', '082491889372', 'situmorang.mila@example.com', '2025-11-08', '06:59:00', 'RS Bakti Husada', 'Terjadwal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, '2025-09-03 20:29:10', '2025-09-03 20:29:10'),
	(109, 82, '2225837017082195', 'NRK52481528', 'Candrakanta Raharja Marbun', '1974-01-30', 'L', 'Dinas Pendidikan', 'UPT 3', '082491889372', 'situmorang.mila@example.com', '2025-10-20', '15:37:00', 'RSUD Kota', 'Terjadwal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, '2025-09-03 20:29:10', '2025-09-03 20:29:10'),
	(110, 82, '2225837017082195', 'NRK52481528', 'Candrakanta Raharja Marbun', '1974-01-30', 'L', 'Dinas Pendidikan', 'UPT 3', '082491889372', 'situmorang.mila@example.com', '2024-05-03', '09:06:00', 'RSUD Kota', 'Selesai', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, '2025-08-28 20:29:10', '2025-08-14 20:29:10', NULL, '2025-09-03 20:29:10', '2025-09-03 20:29:10'),
	(111, 84, '9686867656640714', 'NRK41402592', 'Lamar Darmana Nababan', '1987-04-06', 'L', 'Sekretariat Daerah', 'UPT 4', '086963681458', 'kayla15@example.net', '2026-01-14', '03:04:00', 'Klinik Medika Utama', 'Terjadwal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, '2025-09-03 20:29:10', '2025-09-03 20:29:10'),
	(112, 86, '2137525024636347', 'NRK57963643', 'Kasiran Mangunsong M.M.', '1969-04-02', 'L', 'Dinas Kesehatan', 'UPT 2', '085675978960', 'akarsana97@example.org', '2024-03-18', '06:08:00', 'RSUD Kota', 'Selesai', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 1, NULL, '2025-08-06 20:29:10', NULL, '2025-09-03 20:29:10', '2025-09-03 20:29:10'),
	(113, 87, '3927251092406648', 'NRK14648358', 'Victoria Wulandari', '1997-04-16', 'P', 'Sekretariat Daerah', 'UPT 3', '080559041930', 'tantri63@example.org', '2023-11-28', '07:42:00', 'Klinik Medika Utama', 'Selesai', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, '2025-08-11 20:29:10', '2025-08-17 20:29:10', NULL, '2025-09-03 20:29:10', '2025-09-03 20:29:10'),
	(114, 88, '9181375532833240', 'NRK90748423', 'Mutia Halimah S.E.I', '1990-05-06', 'P', 'Bappeda', 'UPT 1', '081179943488', 'qrahimah@example.org', '2025-09-04', '23:02:00', 'RS Bakti Husada', 'Terjadwal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, 'Ratione aperiam ducimus autem possimus sint.', '2025-09-03 20:29:11', '2025-09-03 20:29:11'),
	(115, 89, '6189954881739972', 'NRK23473696', 'Mahfud Ardianto', '1975-11-21', 'L', 'Bappeda', 'UPT 2', '085755113341', 'gadang60@example.org', '2025-11-17', '14:19:00', 'RS Bakti Husada', 'Terjadwal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, 'Reprehenderit consectetur voluptas amet similique cupiditate voluptatum vel eligendi.', '2025-09-03 20:29:11', '2025-09-03 20:29:11'),
	(116, 89, '6189954881739972', 'NRK23473696', 'Mahfud Ardianto', '1975-11-21', 'L', 'Bappeda', 'UPT 2', '085755113341', 'gadang60@example.org', '2025-09-20', '05:55:00', 'Klinik Medika Utama', 'Terjadwal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, '2025-09-03 20:29:11', '2025-09-03 20:29:11'),
	(117, 90, '2240475169456362', 'NRK08365022', 'Taufan Wasita', '1993-07-14', 'L', 'Sekretariat Daerah', 'UPT 4', '082623518751', 'nugraha.hasanah@example.com', '2025-11-12', '18:25:00', 'Klinik Medika Utama', 'Terjadwal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, '2025-09-03 20:29:11', '2025-09-03 20:29:11'),
	(118, 90, '2240475169456362', 'NRK08365022', 'Taufan Wasita', '1993-07-14', 'L', 'Sekretariat Daerah', 'UPT 4', '082623518751', 'nugraha.hasanah@example.com', '2025-12-12', '15:33:00', 'RSUD Kota', 'Terjadwal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, '2025-09-03 20:29:11', '2025-09-03 20:29:11'),
	(119, 91, '0758988847703839', 'NRK39297092', 'Galur Rama Marbun S.IP', '1984-04-16', 'L', 'Dinas Perhubungan', 'UPT 2', '089514504284', 'ryuniar@example.net', '2025-08-06', '07:09:00', 'RS Bakti Husada', 'Selesai', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, '2025-08-31 20:29:11', '2025-08-30 20:29:11', NULL, '2025-09-03 20:29:11', '2025-09-03 20:29:11'),
	(120, 91, '0758988847703839', 'NRK39297092', 'Galur Rama Marbun S.IP', '1984-04-16', 'L', 'Dinas Perhubungan', 'UPT 2', '089514504284', 'ryuniar@example.net', '2025-11-07', '23:02:00', 'Klinik Sehat Sentosa', 'Terjadwal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, '2025-09-03 20:29:11', '2025-09-03 20:29:11'),
	(121, 92, '5430878351409194', 'NRK92976377', 'Siska Wastuti', '1989-03-23', 'P', 'Dinas Pendidikan', 'UPT 4', '085183751617', 'hmaheswara@example.org', '2025-03-04', '11:50:00', 'Klinik Sehat Sentosa', 'Selesai', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 1, NULL, '2025-08-27 20:29:11', NULL, '2025-09-03 20:29:11', '2025-09-03 20:29:11'),
	(122, 92, '5430878351409194', 'NRK92976377', 'Siska Wastuti', '1989-03-23', 'P', 'Dinas Pendidikan', 'UPT 4', '085183751617', 'hmaheswara@example.org', '2025-08-15', '09:37:00', 'RS Bakti Husada', 'Selesai', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, 0, '2025-08-06 20:29:11', NULL, NULL, '2025-09-03 20:29:11', '2025-09-03 20:29:11'),
	(123, 92, '5430878351409194', 'NRK92976377', 'Siska Wastuti', '1989-03-23', 'P', 'Dinas Pendidikan', 'UPT 4', '085183751617', 'hmaheswara@example.org', '2026-01-14', '18:08:00', 'RS Bakti Husada', 'Terjadwal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, '2025-09-03 20:29:11', '2025-09-03 20:29:11'),
	(124, 94, '8769116244993339', 'NRK74890425', 'Karna Ramadan', '1987-08-15', 'L', 'Sekretariat Daerah', 'UPT 1', '086283975042', 'jelita.zulkarnain@example.net', '2026-02-26', '22:12:00', 'RSUD Kota', 'Terjadwal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, '2025-09-03 20:29:11', '2025-09-03 20:29:11'),
	(125, 94, '8769116244993339', 'NRK74890425', 'Karna Ramadan', '1987-08-15', 'L', 'Sekretariat Daerah', 'UPT 1', '086283975042', 'jelita.zulkarnain@example.net', '2025-03-09', '20:00:00', 'RS Permata Hati', 'Selesai', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 1, NULL, '2025-08-04 20:29:11', NULL, '2025-09-03 20:29:11', '2025-09-03 20:29:11'),
	(126, 94, '8769116244993339', 'NRK74890425', 'Karna Ramadan', '1987-08-15', 'L', 'Sekretariat Daerah', 'UPT 1', '086283975042', 'jelita.zulkarnain@example.net', '2024-02-09', '18:45:00', 'RS Bakti Husada', 'Selesai', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, 'Ducimus facilis nesciunt aspernatur maxime dolor adipisci iste.', '2025-09-03 20:29:11', '2025-09-03 20:29:11'),
	(127, 95, '8106964243386543', 'NRK82930403', 'Dodo Megantara', '1976-04-12', 'L', 'Dinas Kesehatan', 'UPT 5', '088732967081', 'klaksita@example.org', '2025-12-18', '07:00:00', 'RS Bakti Husada', 'Terjadwal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, '2025-09-03 20:29:11', '2025-09-03 20:29:11'),
	(128, 96, '6963398528468312', 'NRK25865073', 'Saka Empluk Megantara M.Pd', '1972-07-18', 'L', 'Dinas Perhubungan', 'UPT 1', '089645427993', 'cagak.gunarto@example.net', '2025-10-13', '22:52:00', 'RSUD Kota', 'Batal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, '2025-08-10 20:29:11', '2025-08-30 20:29:11', NULL, '2025-09-03 20:29:11', '2025-09-03 20:29:11'),
	(129, 97, '9292081032693601', 'NRK12109178', 'Sari Safitri M.Ak', '2005-06-30', 'P', 'Dinas Kesehatan', 'UPT 1', '089904903945', 'utama.kiandra@example.com', '2024-02-06', '07:40:00', 'RSUD Kota', 'Selesai', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, '2025-08-27 20:29:11', '2025-08-18 20:29:11', 'Pariatur praesentium debitis odio ratione dolores iure aperiam.', '2025-09-03 20:29:11', '2025-09-03 20:29:11'),
	(130, 98, '5511373130154713', 'NRK54418012', 'Zulaikha Fujiati', '1983-08-01', 'P', 'Dinas Perhubungan', 'UPT 4', '080075535874', 'pia46@example.org', '2025-01-15', '04:28:00', 'RS Bakti Husada', 'Selesai', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, '2025-08-31 20:29:11', '2025-08-11 20:29:11', NULL, '2025-09-03 20:29:11', '2025-09-03 20:29:11'),
	(131, 98, '5511373130154713', 'NRK54418012', 'Zulaikha Fujiati', '1983-08-01', 'P', 'Dinas Perhubungan', 'UPT 4', '080075535874', 'pia46@example.org', '2023-09-20', '01:04:00', 'RSUD Kota', 'Selesai', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, '2025-09-02 20:29:11', '2025-08-14 20:29:11', NULL, '2025-09-03 20:29:11', '2025-09-03 20:29:11'),
	(132, 98, '5511373130154713', 'NRK54418012', 'Zulaikha Fujiati', '1983-08-01', 'P', 'Dinas Perhubungan', 'UPT 4', '080075535874', 'pia46@example.org', '2023-09-28', '17:33:00', 'RSUD Kota', 'Selesai', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, '2025-08-27 20:29:11', '2025-08-17 20:29:11', NULL, '2025-09-03 20:29:11', '2025-09-03 20:29:11'),
	(133, 99, '3890335247353816', 'NRK70875617', 'Daliman Saputra', '1981-07-06', 'L', 'Sekretariat Daerah', 'UPT 2', '087119790533', 'yuliarti.jamal@example.org', '2024-12-15', '02:08:00', 'RS Permata Hati', 'Selesai', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, '2025-09-01 20:29:11', '2025-08-14 20:29:11', 'Voluptatum eos voluptas libero vel sunt et.', '2025-09-03 20:29:11', '2025-09-03 20:29:11'),
	(134, 99, '3890335247353816', 'NRK70875617', 'Daliman Saputra', '1981-07-06', 'L', 'Sekretariat Daerah', 'UPT 2', '087119790533', 'yuliarti.jamal@example.org', '2024-09-06', '12:28:00', 'RS Bakti Husada', 'Batal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, '2025-08-12 20:29:11', '2025-08-12 20:29:11', NULL, '2025-09-03 20:29:11', '2025-09-03 20:29:11'),
	(135, 99, '3890335247353816', 'NRK70875617', 'Daliman Saputra', '1981-07-06', 'L', 'Sekretariat Daerah', 'UPT 2', '087119790533', 'yuliarti.jamal@example.org', '2025-12-06', '07:33:00', 'Klinik Medika Utama', 'Terjadwal', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, 'Repellendus aspernatur aut sit rerum vitae ex quia.', '2025-09-03 20:29:11', '2025-09-03 20:29:11'),
	(136, 100, '9518581840116883', 'NRK70521776', 'Lintang Zelaya Halimah', '2001-10-27', 'P', 'Dinas Perhubungan', 'UPT 3', '082871339892', 'prasetyo.tami@example.net', '2025-03-03', '18:09:00', 'RS Permata Hati', 'Selesai', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, 1, '2025-08-06 20:29:11', '2025-08-14 20:29:11', NULL, '2025-09-03 20:29:11', '2025-09-03 20:29:11'),
	(137, 100, '9518581840116883', 'NRK70521776', 'Lintang Zelaya Halimah', '2001-10-27', 'P', 'Dinas Perhubungan', 'UPT 3', '082871339892', 'prasetyo.tami@example.net', '2024-09-25', '01:40:00', 'Klinik Medika Utama', 'Selesai', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 1, 0, '2025-08-21 20:29:11', NULL, NULL, '2025-09-03 20:29:11', '2025-09-03 20:29:11'),
	(138, 68, '4907796551066706', 'NRK16083381', 'Violet Laila Haryanti', '2001-05-17', 'P', 'Dinas Pendidikan', 'UPT 3', '086196963038', 'gaman.wijaya@example.org', '2025-09-04', '11:38:00', 'Balaikota', 'Selesai', 1, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, NULL, '2025-09-03 20:37:54', '2025-09-03 20:37:54');

-- Dumping structure for table monitoring_mcu.sessions
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
	('98v4XkaRyvPjEdXS25CRNaTcRxjjfestQlLXVUIk', 4, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiWElSV2RKWTV6T2R5MGxOYmVNV1JFSTJGWm1LajVTQkhIUUYwbnVGZSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzg6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9jbGllbnQvc2NoZWR1bGVzIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6NDt9', 1756958317),
	('fZ1JjGuoWIQxzeO7R4EC0oz0oPLx1X3QkUhZbHFS', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiOXVta254N1kwbWNqanpSV3B4aXRTNEwxSzRHZkhRcG5lbjlmTjdJRSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzk6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9hZG1pbi9tY3UtcmVzdWx0cyI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7czoxNzoicGFzc3dvcmRfaGFzaF93ZWIiO3M6NjA6IiQyeSQxMiRROWRwbGtUOWJ5Um56UlVoT0ZBbFEuS1RScWZpd1doUzNhN2N0M3BhVWg1RFNRTVJCaG1lcSI7czo4OiJmaWxhbWVudCI7YTowOnt9fQ==', 1756959113);

-- Dumping structure for table monitoring_mcu.settings
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
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table monitoring_mcu.settings: ~16 rows (approximately)
REPLACE INTO `settings` (`id`, `key`, `value`, `type`, `group`, `description`, `created_at`, `updated_at`) VALUES
	(1, 'smtp_host', 'smtp.gmail.com', 'string', 'smtp', 'SMTP Host', '2025-09-03 20:29:06', '2025-09-03 20:29:06'),
	(2, 'smtp_port', '587', 'string', 'smtp', 'SMTP Port', '2025-09-03 20:29:06', '2025-09-03 20:29:06'),
	(3, 'smtp_username', '', 'string', 'smtp', 'SMTP Username', '2025-09-03 20:29:06', '2025-09-03 20:29:06'),
	(4, 'smtp_password', '', 'string', 'smtp', 'SMTP Password', '2025-09-03 20:29:06', '2025-09-03 20:29:06'),
	(5, 'smtp_encryption', 'tls', 'string', 'smtp', 'SMTP Encryption', '2025-09-03 20:29:06', '2025-09-03 20:29:06'),
	(6, 'smtp_from_address', 'noreply@mcu.local', 'string', 'smtp', 'SMTP From Address', '2025-09-03 20:29:06', '2025-09-03 20:29:06'),
	(7, 'smtp_from_name', 'Sistem MCU', 'string', 'smtp', 'SMTP From Name', '2025-09-03 20:29:06', '2025-09-03 20:29:06'),
	(8, 'whatsapp_token', '', 'string', 'whatsapp', 'WhatsApp API Token', '2025-09-03 20:29:06', '2025-09-03 20:29:06'),
	(9, 'whatsapp_instance_id', '', 'string', 'whatsapp', 'WhatsApp Instance ID', '2025-09-03 20:29:06', '2025-09-03 20:29:06'),
	(10, 'whatsapp_phone_number', '', 'string', 'whatsapp', 'WhatsApp Phone Number', '2025-09-03 20:29:06', '2025-09-03 20:29:06'),
	(11, 'email_invitation_subject', 'Undangan Medical Check Up', 'string', 'email_template', 'Subject Email Undangan', '2025-09-03 20:29:06', '2025-09-03 20:29:06'),
	(12, 'email_invitation_template', 'Kepada {nama_lengkap}, Anda diundang untuk mengikuti Medical Check Up pada tanggal {tanggal_pemeriksaan} pukul {jam_pemeriksaan} di {lokasi_pemeriksaan}.', 'text', 'email_template', 'Template Email Undangan', '2025-09-03 20:29:06', '2025-09-03 20:29:06'),
	(13, 'whatsapp_invitation_template', 'Halo {nama_lengkap}, Anda diundang untuk mengikuti Medical Check Up pada tanggal {tanggal_pemeriksaan} pukul {jam_pemeriksaan} di {lokasi_pemeriksaan}.', 'text', 'whatsapp_template', 'Template WhatsApp Undangan', '2025-09-03 20:29:06', '2025-09-03 20:29:06'),
	(14, 'app_name', 'Sistem Monitoring MCU', 'string', 'general', 'Nama Aplikasi', '2025-09-03 20:29:06', '2025-09-03 20:29:06'),
	(15, 'app_description', 'Sistem Monitoring Medical Check Up', 'string', 'general', 'Deskripsi Aplikasi', '2025-09-03 20:29:06', '2025-09-03 20:29:06'),
	(16, 'mcu_interval_years', '3', 'string', 'general', 'Interval MCU (Tahun)', '2025-09-03 20:29:06', '2025-09-03 20:29:06');

-- Dumping structure for table monitoring_mcu.specialist_doctors
CREATE TABLE IF NOT EXISTS `specialist_doctors` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `specialty` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table monitoring_mcu.specialist_doctors: ~2 rows (approximately)
REPLACE INTO `specialist_doctors` (`id`, `name`, `specialty`, `description`, `is_active`, `created_at`, `updated_at`) VALUES
	(1, 'Dokter Sp. JP', 'Jantung', NULL, 1, '2025-09-03 20:32:12', '2025-09-03 20:32:12'),
	(2, 'Dokter Sp. PD', 'Penyakit Dalam', NULL, 1, '2025-09-03 20:32:27', '2025-09-03 20:32:27');

-- Dumping structure for table monitoring_mcu.users
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table monitoring_mcu.users: ~4 rows (approximately)
REPLACE INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `nik_ktp`, `nrk_pegawai`, `is_active`, `remember_token`, `created_at`, `updated_at`) VALUES
	(1, 'Super Admin', 'superadmin@mcu.local', NULL, '$2y$12$Q9dplkT9byRnzRUhOFAlQ.KTRqfiwWhS3a7ct3paUh5DSQMRBhmeq', 'super_admin', NULL, NULL, 1, NULL, '2025-09-03 20:29:06', '2025-09-03 20:29:06'),
	(2, 'Admin MCU', 'admin@mcu.local', NULL, '$2y$12$Ru2BCAcOyJLy9uc3M1VfnOdT1ulJZL3Ds4xXAECNt.wFOXankI/zW', 'admin', NULL, NULL, 1, NULL, '2025-09-03 20:29:06', '2025-09-03 20:29:06'),
	(3, 'User MCU', 'user@mcu.local', NULL, '$2y$12$4/wIIWy/aiSWWdh08MLKOO0FM8bplYaVlzhBu7KBc9pCwRZvWS1ma', 'user', NULL, NULL, 1, NULL, '2025-09-03 20:29:06', '2025-09-03 20:29:06'),
	(4, 'Violet Laila Haryanti', 'gaman.wijaya@example.org', NULL, '$2y$12$3SzX3hkrFduSbsPmr/8qLeVah1hTsKA7oe7ticTsg2j56j0O4Ilmq', 'user', '4907796551066706', 'NRK16083381', 1, NULL, '2025-09-03 20:30:46', '2025-09-03 20:30:46');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
