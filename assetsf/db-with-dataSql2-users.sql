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
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table votime.users : ~4 rows (environ)
INSERT INTO `users` (`id`, `name`, `prenom`, `email`, `date_naiss`, `super_admin`, `email_verified_at`, `password`, `remember_token`, `commune_id`, `departement_id`, `photo`, `created_at`, `updated_at`) VALUES
	(1, 'Adminer', 'Tkfaart', 'admin@admin.com', '2023-04-18', 1, NULL, '$2y$10$896NodTfaiJSqnaAU45MD.tcJWQ/1naVMqFIyN0Ke8Wy/eu0Fc7CO', 'PnJhQq7alm7zqog2i8jzOJL738sSKskAJmB9Bd0InZYXDBmvxr7mZBf6gTnM', NULL, NULL, NULL, '2023-04-18 18:36:05', '2023-04-18 18:36:06'),
	(7, 'kouadio', 'Lan', 'tchimouj44@gmail.com', '1991-02-01', 0, NULL, '$2y$10$CP3igrtzTg/HbcZgp0TXmOVbip67VI.UoV7tBeYjad8O4tqeiFE1O', '95hlL5pZh2LzcAprGI4StpQQ6VzjYkZoAiSdLT4i0ihTK4gJFhvLvFmr9Cka', NULL, NULL, 'public/s8kOytSeja6tiBqYY95Ar6Kl47wqfMS1InRKHA3m.png', '2023-04-18 18:47:58', '2023-04-18 18:47:58'),
	(8, 'koffi', 'bahouin', 'tchimouj24@gmail.com', '2018-10-02', 0, NULL, '$2y$10$Mat7ukQfe0rbjCdWiYaCvO92DBhcAZFQWTxp2Ns2KL6QaF4CL.4.e', NULL, NULL, NULL, NULL, '2023-04-18 22:26:58', '2023-04-18 22:26:58'),
	(9, 'Super', 'Admin', 'example@electio.ci', '2004-10-11', 0, NULL, '$2y$10$xg1z32oB1iuXpYZ02DUBZeA2eLkOc9gDjIBiDC46Dfc46MQ2pK3u.', NULL, NULL, NULL, 'public/n3fjuCcXSioVdT3jpa3jb3yF4c0sPNWcZ8Q6KkKC.jpg', '2023-04-25 10:04:02', '2023-04-25 10:04:02');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
