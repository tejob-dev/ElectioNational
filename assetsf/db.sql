-- --------------------------------------------------------
-- Hôte:                         127.0.0.1
-- Version du serveur:           8.0.30 - MySQL Community Server - GPL
-- SE du serveur:                Win64
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

-- Listage de la structure de table votime. agent_de_sections
CREATE TABLE IF NOT EXISTS `agent_de_sections` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telephone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `section_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `agent_de_sections_section_id_foreign` (`section_id`),
  CONSTRAINT `agent_de_sections_section_id_foreign` FOREIGN KEY (`section_id`) REFERENCES `sections` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table votime.agent_de_sections : ~5 rows (environ)

-- Listage de la structure de table votime. agent_du_bureau_votes
CREATE TABLE IF NOT EXISTS `agent_du_bureau_votes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telphone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bureau_vote_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `agent_du_bureau_votes_bureau_vote_id_foreign` (`bureau_vote_id`),
  CONSTRAINT `agent_du_bureau_votes_bureau_vote_id_foreign` FOREIGN KEY (`bureau_vote_id`) REFERENCES `bureau_votes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table votime.agent_du_bureau_votes : ~5 rows (environ)

-- Listage de la structure de table votime. agent_terrains
CREATE TABLE IF NOT EXISTS `agent_terrains` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telephone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lieu_vote_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `agent_terrains_code_unique` (`code`),
  UNIQUE KEY `agent_terrains_telephone_unique` (`telephone`),
  KEY `agent_terrains_lieu_vote_id_foreign` (`lieu_vote_id`),
  CONSTRAINT `agent_terrains_lieu_vote_id_foreign` FOREIGN KEY (`lieu_vote_id`) REFERENCES `lieu_votes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table votime.agent_terrains : ~5 rows (environ)
INSERT INTO `agent_terrains` (`id`, `nom`, `prenom`, `code`, `telephone`, `lieu_vote_id`, `created_at`, `updated_at`) VALUES
	(6, 'Kodjo', 'kle', 'LV-039-01', '0747687854', 31, '2023-04-18 20:57:13', '2023-04-18 21:03:10'),
	(7, 'kouadio', 'kan', 'LV-039-04', '0747687857', 33, '2023-04-18 20:58:38', '2023-04-18 20:58:38');

-- Listage de la structure de table votime. bureau_votes
CREATE TABLE IF NOT EXISTS `bureau_votes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `libel` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `objectif` int NOT NULL,
  `seuil` int NOT NULL,
  `lieu_vote_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `bureau_votes_lieu_vote_id_foreign` (`lieu_vote_id`),
  CONSTRAINT `bureau_votes_lieu_vote_id_foreign` FOREIGN KEY (`lieu_vote_id`) REFERENCES `lieu_votes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table votime.bureau_votes : ~0 rows (environ)
INSERT INTO `bureau_votes` (`id`, `libel`, `objectif`, `seuil`, `lieu_vote_id`, `created_at`, `updated_at`) VALUES
	(16, 'BV01', 432, 116, 31, '2023-04-18 20:18:58', '2023-04-18 20:18:58'),
	(17, 'BV02', 425, 114, 31, '2023-04-18 20:19:27', '2023-04-18 20:21:49'),
	(18, 'BV01', 406, 109, 32, '2023-04-18 20:20:13', '2023-04-18 20:20:13'),
	(19, 'BV02', 400, 108, 32, '2023-04-18 20:20:35', '2023-04-18 20:20:35');

-- Listage de la structure de table votime. candidats
CREATE TABLE IF NOT EXISTS `candidats` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `couleur` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parti` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table votime.candidats : ~0 rows (environ)

-- Listage de la structure de table votime. communes
CREATE TABLE IF NOT EXISTS `communes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `libel` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nbrinscrit` int NOT NULL,
  `objectif` int NOT NULL,
  `seuil` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table votime.communes : ~1 rows (environ)
INSERT INTO `communes` (`id`, `libel`, `nbrinscrit`, `objectif`, `seuil`, `created_at`, `updated_at`) VALUES
	(57, 'ADJAME COMMUNE 039', 117482, 50, 31607, '2023-04-18 19:54:28', '2023-04-18 19:54:28');

-- Listage de la structure de table votime. commune_departement
CREATE TABLE IF NOT EXISTS `commune_departement` (
  `commune_id` bigint unsigned NOT NULL,
  `departement_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  KEY `commune_departement_commune_id_foreign` (`commune_id`),
  KEY `commune_departement_departement_id_foreign` (`departement_id`),
  CONSTRAINT `commune_departement_commune_id_foreign` FOREIGN KEY (`commune_id`) REFERENCES `communes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `commune_departement_departement_id_foreign` FOREIGN KEY (`departement_id`) REFERENCES `departements` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table votime.commune_departement : ~0 rows (environ)

-- Listage de la structure de table votime. commune_lieu_vote
CREATE TABLE IF NOT EXISTS `commune_lieu_vote` (
  `lieu_vote_id` bigint unsigned NOT NULL,
  `commune_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  KEY `commune_lieu_vote_lieu_vote_id_foreign` (`lieu_vote_id`),
  KEY `commune_lieu_vote_commune_id_foreign` (`commune_id`),
  CONSTRAINT `commune_lieu_vote_commune_id_foreign` FOREIGN KEY (`commune_id`) REFERENCES `communes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `commune_lieu_vote_lieu_vote_id_foreign` FOREIGN KEY (`lieu_vote_id`) REFERENCES `lieu_votes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table votime.commune_lieu_vote : ~0 rows (environ)

-- Listage de la structure de table votime. departements
CREATE TABLE IF NOT EXISTS `departements` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `libel` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nbrinscrit` int NOT NULL,
  `objectif` int NOT NULL,
  `seuil` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table votime.departements : ~0 rows (environ)

-- Listage de la structure de table votime. failed_jobs
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

-- Listage des données de la table votime.failed_jobs : ~0 rows (environ)

-- Listage de la structure de table votime. lieu_votes
CREATE TABLE IF NOT EXISTS `lieu_votes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `libel` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nbrinscrit` int NOT NULL,
  `objectif` int NOT NULL,
  `seuil` int NOT NULL,
  `quartier_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `lieu_votes_code_unique` (`code`),
  KEY `lieu_votes_quartier_id_foreign` (`quartier_id`),
  CONSTRAINT `lieu_votes_quartier_id_foreign` FOREIGN KEY (`quartier_id`) REFERENCES `quartiers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table votime.lieu_votes : ~0 rows (environ)
INSERT INTO `lieu_votes` (`id`, `code`, `libel`, `nbrinscrit`, `objectif`, `seuil`, `quartier_id`, `created_at`, `updated_at`) VALUES
	(31, 'LV-039-01', 'ECOLE PRIMAIRE MISSION LIBANAISE', 2553, 1087, 686, 36, '2023-04-18 20:07:55', '2023-04-18 20:07:55'),
	(32, 'LV-039-02', 'GS MARIE DES PETITS', 1606, 684, 433, 36, '2023-04-18 20:09:30', '2023-04-18 20:09:30'),
	(33, 'LV-039-04', 'EPV KONATE', 3196, 1360, 863, 37, '2023-04-18 20:10:58', '2023-04-18 20:10:58'),
	(34, 'LV-039-07', 'EPV LA SORBONNE', 4113, 1750, 1108, 38, '2023-04-18 20:12:35', '2023-04-18 20:12:35');

-- Listage de la structure de table votime. migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table votime.migrations : ~0 rows (environ)
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '2014_10_12_000000_create_users_table', 1),
	(2, '2014_10_12_100000_create_password_resets_table', 1),
	(3, '2019_08_19_000000_create_failed_jobs_table', 1),
	(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
	(5, '2023_04_16_000001_create_agent_de_sections_table', 1),
	(6, '2023_04_16_000002_create_agent_du_bureau_votes_table', 1),
	(7, '2023_04_16_000003_create_agent_terrains_table', 1),
	(8, '2023_04_16_000004_create_bureau_votes_table', 1),
	(9, '2023_04_16_000005_create_candidats_table', 1),
	(10, '2023_04_16_000006_create_communes_table', 1),
	(11, '2023_04_16_000007_create_commune_departement_table', 1),
	(12, '2023_04_16_000008_create_commune_lieu_vote_table', 1),
	(13, '2023_04_16_000009_create_departements_table', 1),
	(14, '2023_04_16_000010_create_lieu_votes_table', 1),
	(15, '2023_04_16_000011_create_parrains_table', 1),
	(16, '2023_04_16_000012_create_proces_verbals_table', 1),
	(17, '2023_04_16_000013_create_quartiers_table', 1),
	(18, '2023_04_16_000014_create_sections_table', 1),
	(19, '2023_04_16_000015_create_sup_lieu_de_votes_table', 1),
	(20, '2023_04_16_009001_add_foreigns_to_agent_de_sections_table', 1),
	(21, '2023_04_16_009002_add_foreigns_to_agent_du_bureau_votes_table', 1),
	(22, '2023_04_16_009003_add_foreigns_to_agent_terrains_table', 1),
	(23, '2023_04_16_009004_add_foreigns_to_bureau_votes_table', 1),
	(24, '2023_04_16_009005_add_foreigns_to_commune_departement_table', 1),
	(25, '2023_04_16_009006_add_foreigns_to_commune_lieu_vote_table', 1),
	(26, '2023_04_16_009007_add_foreigns_to_lieu_votes_table', 1),
	(27, '2023_04_16_009008_add_foreigns_to_proces_verbals_table', 1),
	(28, '2023_04_16_009009_add_foreigns_to_quartiers_table', 1),
	(29, '2023_04_16_009010_add_foreigns_to_sections_table', 1),
	(30, '2023_04_16_009011_add_foreigns_to_sup_lieu_de_votes_table', 1),
	(31, '2023_04_16_009012_add_foreigns_to_users_table', 1),
	(32, '2023_04_18_175700_create_sessions_table', 1),
	(33, '2023_04_18_175732_create_permission_tables', 1);

-- Listage de la structure de table votime. model_has_permissions
CREATE TABLE IF NOT EXISTS `model_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table votime.model_has_permissions : ~0 rows (environ)

-- Listage de la structure de table votime. model_has_roles
CREATE TABLE IF NOT EXISTS `model_has_roles` (
  `role_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table votime.model_has_roles : ~0 rows (environ)
INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
	(2, 'App\\Models\\User', 1),
	(4, 'App\\Models\\User', 7);

-- Listage de la structure de table votime. parrains
CREATE TABLE IF NOT EXISTS `parrains` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nom_pren_par` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telephone_par` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cart_milit` enum('Oui','Non','Sympatisant') COLLATE utf8mb4_unicode_ci NOT NULL,
  `list_elect` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cart_elect` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telephone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_naiss` date NOT NULL,
  `code_lv` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `residence` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `profession` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `observation` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table votime.parrains : ~0 rows (environ)
INSERT INTO `parrains` (`id`, `nom_pren_par`, `telephone_par`, `nom`, `prenom`, `cart_milit`, `list_elect`, `cart_elect`, `telephone`, `date_naiss`, `code_lv`, `residence`, `profession`, `observation`, `created_at`, `updated_at`) VALUES
	(6, 'kouadio kan', '0747687857', 'konan', 'Fab', 'Oui', 'NaN', '2255124124541451', '0747524252', '1990-02-01', 'LV-039-04', 'Angré', 'Matho', 'Voici un parrain', '2023-04-18 20:43:29', '2023-04-18 21:06:08'),
	(7, 'Kodjo kle', '0747687854', 'kissi', 'Mol', 'Sympatisant', '2014', '1214154515451', '0745857857', '1995-10-26', 'LV-039-01', 'Marie Te', 'Physiq', 'Le nouveau', '2023-04-18 20:47:24', '2023-04-18 20:59:15');

-- Listage de la structure de table votime. password_resets
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table votime.password_resets : ~0 rows (environ)

-- Listage de la structure de table votime. permissions
CREATE TABLE IF NOT EXISTS `permissions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=82 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table votime.permissions : ~80 rows (environ)
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
	(1, 'list agentdesections', 'web', '2023-04-18 18:25:14', '2023-04-18 18:25:14'),
	(2, 'view agentdesections', 'web', '2023-04-18 18:25:14', '2023-04-18 18:25:14'),
	(3, 'create agentdesections', 'web', '2023-04-18 18:25:14', '2023-04-18 18:25:14'),
	(4, 'update agentdesections', 'web', '2023-04-18 18:25:14', '2023-04-18 18:25:14'),
	(5, 'delete agentdesections', 'web', '2023-04-18 18:25:14', '2023-04-18 18:25:14'),
	(6, 'list agentdubureauvotes', 'web', '2023-04-18 18:25:14', '2023-04-18 18:25:14'),
	(7, 'view agentdubureauvotes', 'web', '2023-04-18 18:25:15', '2023-04-18 18:25:15'),
	(8, 'create agentdubureauvotes', 'web', '2023-04-18 18:25:15', '2023-04-18 18:25:15'),
	(9, 'update agentdubureauvotes', 'web', '2023-04-18 18:25:15', '2023-04-18 18:25:15'),
	(10, 'delete agentdubureauvotes', 'web', '2023-04-18 18:25:15', '2023-04-18 18:25:15'),
	(11, 'list agentterrains', 'web', '2023-04-18 18:25:15', '2023-04-18 18:25:15'),
	(12, 'view agentterrains', 'web', '2023-04-18 18:25:15', '2023-04-18 18:25:15'),
	(13, 'create agentterrains', 'web', '2023-04-18 18:25:15', '2023-04-18 18:25:15'),
	(14, 'update agentterrains', 'web', '2023-04-18 18:25:15', '2023-04-18 18:25:15'),
	(15, 'delete agentterrains', 'web', '2023-04-18 18:25:15', '2023-04-18 18:25:15'),
	(16, 'list bureauvotes', 'web', '2023-04-18 18:25:15', '2023-04-18 18:25:15'),
	(17, 'view bureauvotes', 'web', '2023-04-18 18:25:15', '2023-04-18 18:25:15'),
	(18, 'create bureauvotes', 'web', '2023-04-18 18:25:15', '2023-04-18 18:25:15'),
	(19, 'update bureauvotes', 'web', '2023-04-18 18:25:15', '2023-04-18 18:25:15'),
	(20, 'delete bureauvotes', 'web', '2023-04-18 18:25:15', '2023-04-18 18:25:15'),
	(21, 'list candidats', 'web', '2023-04-18 18:25:15', '2023-04-18 18:25:15'),
	(22, 'view candidats', 'web', '2023-04-18 18:25:15', '2023-04-18 18:25:15'),
	(23, 'create candidats', 'web', '2023-04-18 18:25:15', '2023-04-18 18:25:15'),
	(24, 'update candidats', 'web', '2023-04-18 18:25:15', '2023-04-18 18:25:15'),
	(25, 'delete candidats', 'web', '2023-04-18 18:25:15', '2023-04-18 18:25:15'),
	(26, 'list communes', 'web', '2023-04-18 18:25:15', '2023-04-18 18:25:15'),
	(27, 'view communes', 'web', '2023-04-18 18:25:15', '2023-04-18 18:25:15'),
	(28, 'create communes', 'web', '2023-04-18 18:25:15', '2023-04-18 18:25:15'),
	(29, 'update communes', 'web', '2023-04-18 18:25:15', '2023-04-18 18:25:15'),
	(30, 'delete communes', 'web', '2023-04-18 18:25:15', '2023-04-18 18:25:15'),
	(31, 'list departements', 'web', '2023-04-18 18:25:15', '2023-04-18 18:25:15'),
	(32, 'view departements', 'web', '2023-04-18 18:25:15', '2023-04-18 18:25:15'),
	(33, 'create departements', 'web', '2023-04-18 18:25:16', '2023-04-18 18:25:16'),
	(34, 'update departements', 'web', '2023-04-18 18:25:16', '2023-04-18 18:25:16'),
	(35, 'delete departements', 'web', '2023-04-18 18:25:16', '2023-04-18 18:25:16'),
	(36, 'list lieuvotes', 'web', '2023-04-18 18:25:16', '2023-04-18 18:25:16'),
	(37, 'view lieuvotes', 'web', '2023-04-18 18:25:16', '2023-04-18 18:25:16'),
	(38, 'create lieuvotes', 'web', '2023-04-18 18:25:16', '2023-04-18 18:25:16'),
	(39, 'update lieuvotes', 'web', '2023-04-18 18:25:16', '2023-04-18 18:25:16'),
	(40, 'delete lieuvotes', 'web', '2023-04-18 18:25:16', '2023-04-18 18:25:16'),
	(41, 'list parrains', 'web', '2023-04-18 18:25:16', '2023-04-18 18:25:16'),
	(42, 'view parrains', 'web', '2023-04-18 18:25:16', '2023-04-18 18:25:16'),
	(43, 'create parrains', 'web', '2023-04-18 18:25:16', '2023-04-18 18:25:16'),
	(44, 'update parrains', 'web', '2023-04-18 18:25:16', '2023-04-18 18:25:16'),
	(45, 'delete parrains', 'web', '2023-04-18 18:25:16', '2023-04-18 18:25:16'),
	(46, 'list procesverbals', 'web', '2023-04-18 18:25:16', '2023-04-18 18:25:16'),
	(47, 'view procesverbals', 'web', '2023-04-18 18:25:16', '2023-04-18 18:25:16'),
	(48, 'create procesverbals', 'web', '2023-04-18 18:25:16', '2023-04-18 18:25:16'),
	(49, 'update procesverbals', 'web', '2023-04-18 18:25:16', '2023-04-18 18:25:16'),
	(50, 'delete procesverbals', 'web', '2023-04-18 18:25:16', '2023-04-18 18:25:16'),
	(51, 'list quartiers', 'web', '2023-04-18 18:25:16', '2023-04-18 18:25:16'),
	(52, 'view quartiers', 'web', '2023-04-18 18:25:16', '2023-04-18 18:25:16'),
	(53, 'create quartiers', 'web', '2023-04-18 18:25:16', '2023-04-18 18:25:16'),
	(54, 'update quartiers', 'web', '2023-04-18 18:25:16', '2023-04-18 18:25:16'),
	(55, 'delete quartiers', 'web', '2023-04-18 18:25:16', '2023-04-18 18:25:16'),
	(56, 'list sections', 'web', '2023-04-18 18:25:16', '2023-04-18 18:25:16'),
	(57, 'view sections', 'web', '2023-04-18 18:25:16', '2023-04-18 18:25:16'),
	(58, 'create sections', 'web', '2023-04-18 18:25:17', '2023-04-18 18:25:17'),
	(59, 'update sections', 'web', '2023-04-18 18:25:17', '2023-04-18 18:25:17'),
	(60, 'delete sections', 'web', '2023-04-18 18:25:17', '2023-04-18 18:25:17'),
	(61, 'list suplieudevotes', 'web', '2023-04-18 18:25:17', '2023-04-18 18:25:17'),
	(62, 'view suplieudevotes', 'web', '2023-04-18 18:25:17', '2023-04-18 18:25:17'),
	(63, 'create suplieudevotes', 'web', '2023-04-18 18:25:17', '2023-04-18 18:25:17'),
	(64, 'update suplieudevotes', 'web', '2023-04-18 18:25:17', '2023-04-18 18:25:17'),
	(65, 'delete suplieudevotes', 'web', '2023-04-18 18:25:17', '2023-04-18 18:25:17'),
	(66, 'list roles', 'web', '2023-04-18 18:25:19', '2023-04-18 18:25:19'),
	(67, 'view roles', 'web', '2023-04-18 18:25:19', '2023-04-18 18:25:19'),
	(68, 'create roles', 'web', '2023-04-18 18:25:19', '2023-04-18 18:25:19'),
	(69, 'update roles', 'web', '2023-04-18 18:25:19', '2023-04-18 18:25:19'),
	(70, 'delete roles', 'web', '2023-04-18 18:25:19', '2023-04-18 18:25:19'),
	(71, 'list permissions', 'web', '2023-04-18 18:25:19', '2023-04-18 18:25:19'),
	(72, 'view permissions', 'web', '2023-04-18 18:25:19', '2023-04-18 18:25:19'),
	(73, 'create permissions', 'web', '2023-04-18 18:25:19', '2023-04-18 18:25:19'),
	(74, 'update permissions', 'web', '2023-04-18 18:25:19', '2023-04-18 18:25:19'),
	(75, 'delete permissions', 'web', '2023-04-18 18:25:19', '2023-04-18 18:25:19'),
	(76, 'list users', 'web', '2023-04-18 18:25:20', '2023-04-18 18:25:20'),
	(77, 'view users', 'web', '2023-04-18 18:25:20', '2023-04-18 18:25:20'),
	(78, 'create users', 'web', '2023-04-18 18:25:20', '2023-04-18 18:25:20'),
	(79, 'update users', 'web', '2023-04-18 18:25:20', '2023-04-18 18:25:20'),
	(80, 'delete users', 'web', '2023-04-18 18:25:20', '2023-04-18 18:25:20'),
	(81, 'can set rules', 'web', '2023-04-18 19:42:37', '2023-04-18 19:42:37');

-- Listage de la structure de table votime. personal_access_tokens
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table votime.personal_access_tokens : ~0 rows (environ)

-- Listage de la structure de table votime. proces_verbals
CREATE TABLE IF NOT EXISTS `proces_verbals` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `libel` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bureau_vote_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `proces_verbals_bureau_vote_id_foreign` (`bureau_vote_id`),
  CONSTRAINT `proces_verbals_bureau_vote_id_foreign` FOREIGN KEY (`bureau_vote_id`) REFERENCES `bureau_votes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table votime.proces_verbals : ~0 rows (environ)

-- Listage de la structure de table votime. quartiers
CREATE TABLE IF NOT EXISTS `quartiers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `libel` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nbrinscrit` int NOT NULL,
  `objectif` int NOT NULL,
  `seuil` int NOT NULL,
  `section_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `quartiers_section_id_foreign` (`section_id`),
  CONSTRAINT `quartiers_section_id_foreign` FOREIGN KEY (`section_id`) REFERENCES `sections` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table votime.quartiers : ~0 rows (environ)
INSERT INTO `quartiers` (`id`, `libel`, `nbrinscrit`, `objectif`, `seuil`, `section_id`, `created_at`, `updated_at`) VALUES
	(36, 'ADJAME VILLAGE', 5912, 2517, 1589, 46, '2023-04-18 20:02:39', '2023-04-18 20:02:39'),
	(37, 'WILLIAMSVILLE 1', 7547, 3212, 2031, 47, '2023-04-18 20:04:01', '2023-04-18 20:04:01'),
	(38, 'WILLIASMVILLE 2', 9279, 3949, 2497, 47, '2023-04-18 20:04:47', '2023-04-18 20:04:47');

-- Listage de la structure de table votime. roles
CREATE TABLE IF NOT EXISTS `roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table votime.roles : ~2 rows (environ)
INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
	(1, 'user', 'web', '2023-04-18 18:25:17', '2023-04-18 18:25:17'),
	(2, 'super-admin', 'web', '2023-04-18 18:25:20', '2023-04-18 18:25:20'),
	(3, 'operateurs de recensement', 'web', '2023-04-18 19:27:11', '2023-04-18 19:27:36'),
	(4, 'operateurs suivi et resultats', 'web', '2023-04-18 19:38:13', '2023-04-18 19:38:13');

-- Listage de la structure de table votime. role_has_permissions
CREATE TABLE IF NOT EXISTS `role_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `role_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table votime.role_has_permissions : ~145 rows (environ)
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
	(1, 1),
	(2, 1),
	(3, 1),
	(4, 1),
	(5, 1),
	(6, 1),
	(7, 1),
	(8, 1),
	(9, 1),
	(10, 1),
	(11, 1),
	(12, 1),
	(13, 1),
	(14, 1),
	(15, 1),
	(16, 1),
	(17, 1),
	(18, 1),
	(19, 1),
	(20, 1),
	(21, 1),
	(22, 1),
	(23, 1),
	(24, 1),
	(25, 1),
	(26, 1),
	(27, 1),
	(28, 1),
	(29, 1),
	(30, 1),
	(31, 1),
	(32, 1),
	(33, 1),
	(34, 1),
	(35, 1),
	(36, 1),
	(37, 1),
	(38, 1),
	(39, 1),
	(40, 1),
	(41, 1),
	(42, 1),
	(43, 1),
	(44, 1),
	(45, 1),
	(46, 1),
	(47, 1),
	(48, 1),
	(49, 1),
	(50, 1),
	(51, 1),
	(52, 1),
	(53, 1),
	(54, 1),
	(55, 1),
	(56, 1),
	(57, 1),
	(58, 1),
	(59, 1),
	(60, 1),
	(61, 1),
	(62, 1),
	(63, 1),
	(64, 1),
	(65, 1),
	(1, 2),
	(2, 2),
	(3, 2),
	(4, 2),
	(5, 2),
	(6, 2),
	(7, 2),
	(8, 2),
	(9, 2),
	(10, 2),
	(11, 2),
	(12, 2),
	(13, 2),
	(14, 2),
	(15, 2),
	(16, 2),
	(17, 2),
	(18, 2),
	(19, 2),
	(20, 2),
	(21, 2),
	(22, 2),
	(23, 2),
	(24, 2),
	(25, 2),
	(26, 2),
	(27, 2),
	(28, 2),
	(29, 2),
	(30, 2),
	(31, 2),
	(32, 2),
	(33, 2),
	(34, 2),
	(35, 2),
	(36, 2),
	(37, 2),
	(38, 2),
	(39, 2),
	(40, 2),
	(41, 2),
	(42, 2),
	(43, 2),
	(44, 2),
	(45, 2),
	(46, 2),
	(47, 2),
	(48, 2),
	(49, 2),
	(50, 2),
	(51, 2),
	(52, 2),
	(53, 2),
	(54, 2),
	(55, 2),
	(56, 2),
	(57, 2),
	(58, 2),
	(59, 2),
	(60, 2),
	(61, 2),
	(62, 2),
	(63, 2),
	(64, 2),
	(65, 2),
	(66, 2),
	(67, 2),
	(68, 2),
	(69, 2),
	(70, 2),
	(71, 2),
	(72, 2),
	(73, 2),
	(74, 2),
	(75, 2),
	(76, 2),
	(77, 2),
	(78, 2),
	(79, 2),
	(80, 2),
	(81, 2),
	(11, 3),
	(12, 3),
	(13, 3),
	(41, 3),
	(42, 3),
	(44, 3),
	(56, 3),
	(57, 3),
	(6, 4),
	(7, 4),
	(8, 4),
	(11, 4),
	(12, 4),
	(13, 4),
	(16, 4),
	(17, 4),
	(36, 4),
	(37, 4),
	(46, 4),
	(47, 4),
	(48, 4),
	(49, 4),
	(51, 4),
	(52, 4),
	(56, 4),
	(57, 4),
	(61, 4),
	(62, 4),
	(63, 4),
	(76, 4),
	(79, 4);

-- Listage de la structure de table votime. sections
CREATE TABLE IF NOT EXISTS `sections` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `libel` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nbrinscrit` int NOT NULL,
  `objectif` int NOT NULL DEFAULT '0',
  `seuil` int NOT NULL DEFAULT '0',
  `commune_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sections_commune_id_foreign` (`commune_id`),
  CONSTRAINT `sections_commune_id_foreign` FOREIGN KEY (`commune_id`) REFERENCES `communes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table votime.sections : ~0 rows (environ)
INSERT INTO `sections` (`id`, `libel`, `nbrinscrit`, `objectif`, `seuil`, `commune_id`, `created_at`, `updated_at`) VALUES
	(46, 'ADJAME VILLAGE', 5912, 2517, 189, 57, '2023-04-18 19:57:00', '2023-04-18 19:57:00'),
	(47, 'CROIX BLEU', 16826, 7161, 4529, 57, '2023-04-18 19:59:32', '2023-04-18 19:59:32');

-- Listage de la structure de table votime. sessions
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table votime.sessions : ~1 rows (environ)
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
	('rRxPTcAQ89Eijm0waWP8oQcJeIz7a1B1KaCsTuDC', 7, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/112.0.0.0 Safari/537.36 Edg/112.0.1722.48', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoibHJnSG5oVDYwWE0zYW5BQlcwVTlBOU92eFBQOGNzS2x4a0NnazFQVSI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjI3OiJodHRwOi8vbG9jYWxob3N0OjgwMDAvdXNlcnMiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTo3O30=', 1681852911),
	('s1cDLDexq2xGOCabTso83jLZsOb6nnkojNVjdhmf', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/112.0.0.0 Safari/537.36 Edg/112.0.1722.48', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiYmtxODhsMnJPdjRScjFITzB4dE82N3FaMVh2OXI2TGJnWkk4c3F2MiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9sb2dpbiI7fX0=', 1681853467);

-- Listage de la structure de table votime. sup_lieu_de_votes
CREATE TABLE IF NOT EXISTS `sup_lieu_de_votes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telephone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lieu_vote_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sup_lieu_de_votes_lieu_vote_id_foreign` (`lieu_vote_id`),
  CONSTRAINT `sup_lieu_de_votes_lieu_vote_id_foreign` FOREIGN KEY (`lieu_vote_id`) REFERENCES `lieu_votes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table votime.sup_lieu_de_votes : ~0 rows (environ)

-- Listage de la structure de table votime. users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_naiss` date NOT NULL,
  `super_admin` smallint NOT NULL DEFAULT '0',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `commune_id` bigint unsigned DEFAULT NULL,
  `departement_id` bigint unsigned DEFAULT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_commune_id_foreign` (`commune_id`),
  KEY `users_departement_id_foreign` (`departement_id`),
  CONSTRAINT `users_commune_id_foreign` FOREIGN KEY (`commune_id`) REFERENCES `communes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `users_departement_id_foreign` FOREIGN KEY (`departement_id`) REFERENCES `departements` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table votime.users : ~2 rows (environ)
INSERT INTO `users` (`id`, `name`, `prenom`, `email`, `date_naiss`, `super_admin`, `email_verified_at`, `password`, `remember_token`, `commune_id`, `departement_id`, `photo`, `created_at`, `updated_at`) VALUES
	(1, 'Adminer', 'Tkfaart', 'admin@admin.com', '2023-04-18', 1, NULL, '$2y$10$896NodTfaiJSqnaAU45MD.tcJWQ/1naVMqFIyN0Ke8Wy/eu0Fc7CO', NULL, NULL, NULL, NULL, '2023-04-18 18:36:05', '2023-04-18 18:36:06'),
	(7, 'kouadio', 'Lan', 'tchimouj44@gmail.com', '1991-02-01', 0, NULL, '$2y$10$CP3igrtzTg/HbcZgp0TXmOVbip67VI.UoV7tBeYjad8O4tqeiFE1O', NULL, NULL, NULL, 'public/s8kOytSeja6tiBqYY95Ar6Kl47wqfMS1InRKHA3m.png', '2023-04-18 18:47:58', '2023-04-18 18:47:58');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
