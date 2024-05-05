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

-- Listage de la structure de table votimedata. agent_de_sections
CREATE TABLE IF NOT EXISTS `agent_de_sections` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `telephone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `section_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `agent_de_sections_section_id_foreign` (`section_id`),
  CONSTRAINT `agent_de_sections_section_id_foreign` FOREIGN KEY (`section_id`) REFERENCES `sections` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table votimedata.agent_de_sections : ~0 rows (environ)

-- Listage de la structure de table votimedata. agent_du_bureau_votes
CREATE TABLE IF NOT EXISTS `agent_du_bureau_votes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `telphone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `bureau_vote_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `agent_du_bureau_votes_bureau_vote_id_foreign` (`bureau_vote_id`),
  CONSTRAINT `agent_du_bureau_votes_bureau_vote_id_foreign` FOREIGN KEY (`bureau_vote_id`) REFERENCES `bureau_votes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table votimedata.agent_du_bureau_votes : ~0 rows (environ)

-- Listage de la structure de table votimedata. agent_terrains
CREATE TABLE IF NOT EXISTS `agent_terrains` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `telephone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `lieu_vote_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `agent_terrains_code_unique` (`code`),
  UNIQUE KEY `agent_terrains_telephone_unique` (`telephone`),
  KEY `agent_terrains_lieu_vote_id_foreign` (`lieu_vote_id`),
  CONSTRAINT `agent_terrains_lieu_vote_id_foreign` FOREIGN KEY (`lieu_vote_id`) REFERENCES `lieu_votes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table votimedata.agent_terrains : ~0 rows (environ)

-- Listage de la structure de table votimedata. bureau_votes
CREATE TABLE IF NOT EXISTS `bureau_votes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `libel` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `objectif` int NOT NULL,
  `seuil` int NOT NULL,
  `lieu_vote_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `bureau_votes_lieu_vote_id_foreign` (`lieu_vote_id`),
  CONSTRAINT `bureau_votes_lieu_vote_id_foreign` FOREIGN KEY (`lieu_vote_id`) REFERENCES `lieu_votes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=285 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table votimedata.bureau_votes : ~0 rows (environ)
INSERT INTO `bureau_votes` (`id`, `libel`, `objectif`, `seuil`, `lieu_vote_id`, `created_at`, `updated_at`) VALUES
	(1, 'BV01', 432, 116, 1, NULL, NULL),
	(2, 'BV02', 425, 114, 1, NULL, NULL),
	(3, 'BV03', 424, 114, 1, NULL, NULL),
	(4, 'BV04', 424, 114, 1, NULL, NULL),
	(5, 'BV05', 424, 114, 1, NULL, NULL),
	(6, 'BV06', 424, 114, 1, NULL, NULL),
	(7, 'BV01', 406, 109, 2, NULL, NULL),
	(8, 'BV02', 400, 108, 2, NULL, NULL),
	(9, 'BV03', 400, 108, 2, NULL, NULL),
	(10, 'BV04', 400, 108, 2, NULL, NULL),
	(11, 'BV01', 440, 118, 3, NULL, NULL),
	(12, 'BV02', 440, 118, 3, NULL, NULL),
	(13, 'BV03', 440, 118, 3, NULL, NULL),
	(14, 'BV04', 433, 116, 3, NULL, NULL),
	(15, 'BV01', 400, 108, 4, NULL, NULL),
	(16, 'BV02', 400, 108, 4, NULL, NULL),
	(17, 'BV03', 400, 108, 4, NULL, NULL),
	(18, 'BV04', 400, 108, 4, NULL, NULL),
	(19, 'BV05', 400, 108, 4, NULL, NULL),
	(20, 'BV06', 400, 108, 4, NULL, NULL),
	(21, 'BV07', 400, 108, 4, NULL, NULL),
	(22, 'BV08', 396, 107, 4, NULL, NULL),
	(23, 'BV01', 440, 118, 5, NULL, NULL),
	(24, 'BV02', 440, 118, 5, NULL, NULL),
	(25, 'BV03', 440, 118, 5, NULL, NULL),
	(26, 'BV04', 439, 118, 5, NULL, NULL),
	(27, 'BV05', 432, 116, 5, NULL, NULL),
	(28, 'BV06', 432, 116, 5, NULL, NULL),
	(29, 'BV07', 432, 116, 5, NULL, NULL),
	(30, 'BV08', 432, 116, 5, NULL, NULL),
	(31, 'BV09', 432, 116, 5, NULL, NULL),
	(32, 'BV10', 432, 116, 5, NULL, NULL),
	(33, 'BV01', 416, 112, 6, NULL, NULL),
	(34, 'BV02', 409, 110, 6, NULL, NULL),
	(35, 'BV03', 408, 110, 6, NULL, NULL),
	(36, 'BV04', 408, 110, 6, NULL, NULL),
	(37, 'BV05', 408, 110, 6, NULL, NULL),
	(38, 'BV06', 408, 110, 6, NULL, NULL),
	(39, 'BV01', 416, 112, 7, NULL, NULL),
	(40, 'BV02', 416, 112, 7, NULL, NULL),
	(41, 'BV03', 416, 112, 7, NULL, NULL),
	(42, 'BV04', 416, 112, 7, NULL, NULL),
	(43, 'BV05', 409, 110, 7, NULL, NULL),
	(44, 'BV06', 408, 110, 7, NULL, NULL),
	(45, 'BV07', 408, 110, 7, NULL, NULL),
	(46, 'BV08', 408, 110, 7, NULL, NULL),
	(47, 'BV09', 408, 110, 7, NULL, NULL),
	(48, 'BV10', 408, 110, 7, NULL, NULL),
	(49, 'BV01', 392, 105, 8, NULL, NULL),
	(50, 'BV02', 392, 105, 8, NULL, NULL),
	(51, 'BV03', 389, 105, 8, NULL, NULL),
	(52, 'BV04', 384, 103, 8, NULL, NULL),
	(53, 'BV05', 384, 103, 8, NULL, NULL),
	(54, 'BV06', 384, 103, 8, NULL, NULL),
	(55, 'BV07', 384, 103, 8, NULL, NULL),
	(56, 'BV01', 440, 118, 9, NULL, NULL),
	(57, 'BV02', 440, 118, 9, NULL, NULL),
	(58, 'BV03', 440, 118, 9, NULL, NULL),
	(59, 'BV04', 440, 118, 9, NULL, NULL),
	(60, 'BV05', 439, 118, 9, NULL, NULL),
	(61, 'BV06', 432, 116, 9, NULL, NULL),
	(62, 'BV07', 432, 116, 9, NULL, NULL),
	(63, 'BV01', 408, 110, 10, NULL, NULL),
	(64, 'BV02', 408, 110, 10, NULL, NULL),
	(65, 'BV03', 408, 110, 10, NULL, NULL),
	(66, 'BV04', 408, 110, 10, NULL, NULL),
	(67, 'BV05', 403, 108, 10, NULL, NULL),
	(68, 'BV06', 400, 108, 10, NULL, NULL),
	(69, 'BV01', 408, 110, 11, NULL, NULL),
	(70, 'BV02', 408, 110, 11, NULL, NULL),
	(71, 'BV03', 405, 109, 11, NULL, NULL),
	(72, 'BV04', 400, 108, 11, NULL, NULL),
	(73, 'BV05', 400, 108, 11, NULL, NULL),
	(74, 'BV06', 400, 108, 11, NULL, NULL),
	(75, 'BV07', 400, 108, 11, NULL, NULL),
	(76, 'BV08', 400, 108, 11, NULL, NULL),
	(77, 'BV09', 400, 108, 11, NULL, NULL),
	(78, 'BV01', 432, 116, 12, NULL, NULL),
	(79, 'BV02', 432, 116, 12, NULL, NULL),
	(80, 'BV03', 432, 116, 12, NULL, NULL),
	(81, 'BV04', 432, 116, 12, NULL, NULL),
	(82, 'BV05', 424, 114, 12, NULL, NULL),
	(83, 'BV01', 376, 101, 13, NULL, NULL),
	(84, 'BV02', 376, 101, 13, NULL, NULL),
	(85, 'BV03', 376, 101, 13, NULL, NULL),
	(86, 'BV04', 376, 101, 13, NULL, NULL),
	(87, 'BV05', 370, 100, 13, NULL, NULL),
	(88, 'BV01', 448, 121, 14, NULL, NULL),
	(89, 'BV02', 448, 121, 14, NULL, NULL),
	(90, 'BV03', 448, 121, 14, NULL, NULL),
	(91, 'BV04', 448, 121, 14, NULL, NULL),
	(92, 'BV05', 447, 120, 14, NULL, NULL),
	(93, 'BV01', 376, 101, 15, NULL, NULL),
	(94, 'BV02', 376, 101, 15, NULL, NULL),
	(95, 'BV03', 368, 99, 15, NULL, NULL),
	(96, 'BV01', 376, 101, 16, NULL, NULL),
	(97, 'BV02', 374, 101, 16, NULL, NULL),
	(98, 'BV03', 368, 99, 16, NULL, NULL),
	(99, 'BV04', 368, 99, 16, NULL, NULL),
	(100, 'BV05', 368, 99, 16, NULL, NULL),
	(101, 'BV01', 448, 121, 17, NULL, NULL),
	(102, 'BV02', 448, 121, 17, NULL, NULL),
	(103, 'BV03', 448, 121, 17, NULL, NULL),
	(104, 'BV04', 445, 120, 17, NULL, NULL),
	(105, 'BV05', 440, 118, 17, NULL, NULL),
	(106, 'BV06', 440, 118, 17, NULL, NULL),
	(107, 'BV01', 424, 114, 18, NULL, NULL),
	(108, 'BV02', 418, 112, 18, NULL, NULL),
	(109, 'BV03', 416, 112, 18, NULL, NULL),
	(110, 'BV04', 416, 112, 18, NULL, NULL),
	(111, 'BV05', 416, 112, 18, NULL, NULL),
	(112, 'BV06', 416, 112, 18, NULL, NULL),
	(113, 'BV07', 416, 112, 18, NULL, NULL),
	(114, 'BV01', 302, 81, 19, NULL, NULL),
	(115, 'BV02', 296, 80, 19, NULL, NULL),
	(116, 'BV01', 408, 110, 20, NULL, NULL),
	(117, 'BV02', 407, 109, 20, NULL, NULL),
	(118, 'BV03', 400, 108, 20, NULL, NULL),
	(119, 'BV04', 400, 108, 20, NULL, NULL),
	(120, 'BV05', 400, 108, 20, NULL, NULL),
	(121, 'BV06', 400, 108, 20, NULL, NULL),
	(122, 'BV01', 392, 105, 21, NULL, NULL),
	(123, 'BV02', 392, 105, 21, NULL, NULL),
	(124, 'BV03', 392, 105, 21, NULL, NULL),
	(125, 'BV04', 390, 105, 21, NULL, NULL),
	(126, 'BV05', 384, 103, 21, NULL, NULL),
	(127, 'BV06', 384, 103, 21, NULL, NULL),
	(128, 'BV01', 384, 103, 22, NULL, NULL),
	(129, 'BV02', 383, 103, 22, NULL, NULL),
	(130, 'BV03', 376, 101, 22, NULL, NULL),
	(131, 'BV04', 376, 101, 22, NULL, NULL),
	(132, 'BV05', 376, 101, 22, NULL, NULL),
	(133, 'BV06', 376, 101, 22, NULL, NULL),
	(134, 'BV01', 438, 118, 23, NULL, NULL),
	(135, 'BV02', 432, 116, 23, NULL, NULL),
	(136, 'BV03', 432, 116, 23, NULL, NULL),
	(137, 'BV04', 432, 116, 23, NULL, NULL),
	(138, 'BV05', 432, 116, 23, NULL, NULL),
	(139, 'BV01', 432, 116, 24, NULL, NULL),
	(140, 'BV02', 432, 116, 24, NULL, NULL),
	(141, 'BV03', 432, 116, 24, NULL, NULL),
	(142, 'BV04', 424, 114, 24, NULL, NULL),
	(143, 'BV05', 424, 114, 24, NULL, NULL),
	(144, 'BV01', 400, 108, 25, NULL, NULL),
	(145, 'BV02', 400, 108, 25, NULL, NULL),
	(146, 'BV03', 400, 108, 25, NULL, NULL),
	(147, 'BV04', 400, 108, 25, NULL, NULL),
	(148, 'BV05', 397, 107, 25, NULL, NULL),
	(149, 'BV06', 392, 105, 25, NULL, NULL),
	(150, 'BV07', 392, 105, 25, NULL, NULL),
	(151, 'BV08', 392, 105, 25, NULL, NULL),
	(152, 'BV01', 424, 114, 26, NULL, NULL),
	(153, 'BV02', 424, 114, 26, NULL, NULL),
	(154, 'BV03', 424, 114, 26, NULL, NULL),
	(155, 'BV04', 424, 114, 26, NULL, NULL),
	(156, 'BV05', 418, 112, 26, NULL, NULL),
	(157, 'BV06', 416, 112, 26, NULL, NULL),
	(158, 'BV01', 413, 111, 27, NULL, NULL),
	(159, 'BV02', 408, 110, 27, NULL, NULL),
	(160, 'BV03', 408, 110, 27, NULL, NULL),
	(161, 'BV04', 408, 110, 27, NULL, NULL),
	(162, 'BV05', 408, 110, 27, NULL, NULL),
	(163, 'BV06', 408, 110, 27, NULL, NULL),
	(164, 'BV07', 408, 110, 27, NULL, NULL),
	(165, 'BV08', 408, 110, 27, NULL, NULL),
	(166, 'BV01', 432, 116, 28, NULL, NULL),
	(167, 'BV02', 426, 115, 28, NULL, NULL),
	(168, 'BV03', 424, 114, 28, NULL, NULL),
	(169, 'BV04', 424, 114, 28, NULL, NULL),
	(170, 'BV05', 424, 114, 28, NULL, NULL),
	(171, 'BV01', 440, 118, 29, NULL, NULL),
	(172, 'BV02', 437, 118, 29, NULL, NULL),
	(173, 'BV03', 432, 116, 29, NULL, NULL),
	(174, 'BV04', 432, 116, 29, NULL, NULL),
	(175, 'BV05', 432, 116, 29, NULL, NULL),
	(176, 'BV06', 432, 116, 29, NULL, NULL),
	(177, 'BV07', 432, 116, 29, NULL, NULL),
	(178, 'BV01', 376, 101, 30, NULL, NULL),
	(179, 'BV02', 376, 101, 30, NULL, NULL),
	(180, 'BV03', 376, 101, 30, NULL, NULL),
	(181, 'BV04', 376, 101, 30, NULL, NULL),
	(182, 'BV05', 376, 101, 30, NULL, NULL),
	(183, 'BV06', 372, 100, 30, NULL, NULL),
	(184, 'BV01', 448, 121, 31, NULL, NULL),
	(185, 'BV02', 448, 121, 31, NULL, NULL),
	(186, 'BV03', 440, 118, 31, NULL, NULL),
	(187, 'BV04', 440, 118, 31, NULL, NULL),
	(188, 'BV05', 440, 118, 31, NULL, NULL),
	(189, 'BV01', 416, 112, 32, NULL, NULL),
	(190, 'BV02', 416, 112, 32, NULL, NULL),
	(191, 'BV03', 412, 111, 32, NULL, NULL),
	(192, 'BV04', 408, 110, 32, NULL, NULL),
	(193, 'BV05', 408, 110, 32, NULL, NULL),
	(194, 'BV01', 424, 114, 33, NULL, NULL),
	(195, 'BV02', 424, 114, 33, NULL, NULL),
	(196, 'BV03', 424, 114, 33, NULL, NULL),
	(197, 'BV04', 424, 114, 33, NULL, NULL),
	(198, 'BV05', 418, 112, 33, NULL, NULL),
	(199, 'BV06', 416, 112, 33, NULL, NULL),
	(200, 'BV07', 416, 112, 33, NULL, NULL),
	(201, 'BV01', 420, 113, 34, NULL, NULL),
	(202, 'BV02', 416, 112, 34, NULL, NULL),
	(203, 'BV03', 416, 112, 34, NULL, NULL),
	(204, 'BV04', 416, 112, 34, NULL, NULL),
	(205, 'BV05', 416, 112, 34, NULL, NULL),
	(206, 'BV01', 432, 116, 35, NULL, NULL),
	(207, 'BV02', 432, 116, 35, NULL, NULL),
	(208, 'BV03', 432, 116, 35, NULL, NULL),
	(209, 'BV04', 432, 116, 35, NULL, NULL),
	(210, 'BV05', 432, 116, 35, NULL, NULL),
	(211, 'BV06', 432, 116, 35, NULL, NULL),
	(212, 'BV07', 432, 116, 35, NULL, NULL),
	(213, 'BV08', 432, 116, 35, NULL, NULL),
	(214, 'BV09', 432, 116, 35, NULL, NULL),
	(215, 'BV10', 432, 116, 35, NULL, NULL),
	(216, 'BV11', 431, 116, 35, NULL, NULL),
	(217, 'BV12', 424, 114, 35, NULL, NULL),
	(218, 'BV13', 424, 114, 35, NULL, NULL),
	(219, 'BV01', 448, 121, 36, NULL, NULL),
	(220, 'BV02', 448, 121, 36, NULL, NULL),
	(221, 'BV03', 446, 120, 36, NULL, NULL),
	(222, 'BV04', 440, 118, 36, NULL, NULL),
	(223, 'BV01', 384, 103, 37, NULL, NULL),
	(224, 'BV02', 384, 103, 37, NULL, NULL),
	(225, 'BV03', 384, 103, 37, NULL, NULL),
	(226, 'BV04', 384, 103, 37, NULL, NULL),
	(227, 'BV05', 384, 103, 37, NULL, NULL),
	(228, 'BV06', 381, 102, 37, NULL, NULL),
	(229, 'BV01', 392, 105, 38, NULL, NULL),
	(230, 'BV02', 392, 105, 38, NULL, NULL),
	(231, 'BV03', 386, 104, 38, NULL, NULL),
	(232, 'BV04', 384, 103, 38, NULL, NULL),
	(233, 'BV05', 384, 103, 38, NULL, NULL),
	(234, 'BV01', 400, 108, 39, NULL, NULL),
	(235, 'BV02', 400, 108, 39, NULL, NULL),
	(236, 'BV03', 400, 108, 39, NULL, NULL),
	(237, 'BV04', 400, 108, 39, NULL, NULL),
	(238, 'BV05', 395, 106, 39, NULL, NULL),
	(239, 'BV01', 416, 112, 40, NULL, NULL),
	(240, 'BV02', 410, 110, 40, NULL, NULL),
	(241, 'BV03', 408, 110, 40, NULL, NULL),
	(242, 'BV04', 408, 110, 40, NULL, NULL),
	(243, 'BV05', 408, 110, 40, NULL, NULL),
	(244, 'BV01', 408, 110, 41, NULL, NULL),
	(245, 'BV02', 408, 110, 41, NULL, NULL),
	(246, 'BV03', 404, 109, 41, NULL, NULL),
	(247, 'BV04', 400, 108, 41, NULL, NULL),
	(248, 'BV05', 400, 108, 41, NULL, NULL),
	(249, 'BV01', 407, 109, 42, NULL, NULL),
	(250, 'BV02', 400, 108, 42, NULL, NULL),
	(251, 'BV03', 400, 108, 42, NULL, NULL),
	(252, 'BV04', 400, 108, 42, NULL, NULL),
	(253, 'BV05', 400, 108, 42, NULL, NULL),
	(254, 'BV06', 400, 108, 42, NULL, NULL),
	(255, 'BV07', 400, 108, 42, NULL, NULL),
	(256, 'BV08', 400, 108, 42, NULL, NULL),
	(257, 'BV01', 448, 121, 43, NULL, NULL),
	(258, 'BV02', 448, 121, 43, NULL, NULL),
	(259, 'BV03', 448, 121, 43, NULL, NULL),
	(260, 'BV04', 440, 118, 43, NULL, NULL),
	(261, 'BV05', 440, 118, 43, NULL, NULL),
	(262, 'BV06', 440, 118, 43, NULL, NULL),
	(263, 'BV07', 440, 118, 43, NULL, NULL),
	(264, 'BV08', 440, 118, 43, NULL, NULL),
	(265, 'BV09', 440, 118, 43, NULL, NULL),
	(266, 'BV10', 440, 118, 43, NULL, NULL),
	(267, 'BV11', 440, 118, 43, NULL, NULL),
	(268, 'BV12', 440, 118, 43, NULL, NULL),
	(269, 'BV01', 424, 114, 44, NULL, NULL),
	(270, 'BV02', 424, 114, 44, NULL, NULL),
	(271, 'BV03', 424, 114, 44, NULL, NULL),
	(272, 'BV04', 424, 114, 44, NULL, NULL),
	(273, 'BV05', 423, 114, 44, NULL, NULL),
	(274, 'BV06', 416, 112, 44, NULL, NULL),
	(275, 'BV07', 416, 112, 44, NULL, NULL),
	(276, 'BV01', 448, 121, 45, NULL, NULL),
	(277, 'BV02', 448, 121, 45, NULL, NULL),
	(278, 'BV03', 448, 121, 45, '2023-04-22 17:25:12', '2023-04-22 17:25:12'),
	(279, 'BV04', 448, 121, 45, NULL, NULL),
	(280, 'BV05', 448, 121, 45, NULL, NULL),
	(281, 'BV06', 448, 121, 45, NULL, NULL),
	(282, 'BV07', 448, 121, 45, NULL, NULL),
	(283, 'BV08', 447, 120, 45, NULL, NULL),
	(284, 'BV09', 440, 118, 45, NULL, NULL);

-- Listage de la structure de table votimedata. candidats
CREATE TABLE IF NOT EXISTS `candidats` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `couleur` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parti` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table votimedata.candidats : ~0 rows (environ)

-- Listage de la structure de table votimedata. communes
CREATE TABLE IF NOT EXISTS `communes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `libel` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nbrinscrit` int NOT NULL,
  `objectif` int NOT NULL,
  `seuil` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table votimedata.communes : ~0 rows (environ)
INSERT INTO `communes` (`id`, `libel`, `nbrinscrit`, `objectif`, `seuil`, `created_at`, `updated_at`) VALUES
	(39, 'ADJAME COMMUNE 039', 117482, 50478, 31607, NULL, NULL);

-- Listage de la structure de table votimedata. commune_departement
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

-- Listage des données de la table votimedata.commune_departement : ~0 rows (environ)

-- Listage de la structure de table votimedata. commune_lieu_vote
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

-- Listage des données de la table votimedata.commune_lieu_vote : ~0 rows (environ)

-- Listage de la structure de table votimedata. departements
CREATE TABLE IF NOT EXISTS `departements` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `libel` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nbrinscrit` int NOT NULL,
  `objectif` int NOT NULL,
  `seuil` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table votimedata.departements : ~0 rows (environ)

-- Listage de la structure de table votimedata. failed_jobs
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table votimedata.failed_jobs : ~0 rows (environ)

-- Listage de la structure de table votimedata. lieu_votes
CREATE TABLE IF NOT EXISTS `lieu_votes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `libel` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table votimedata.lieu_votes : ~0 rows (environ)
INSERT INTO `lieu_votes` (`id`, `code`, `libel`, `nbrinscrit`, `objectif`, `seuil`, `quartier_id`, `created_at`, `updated_at`) VALUES
	(1, 'LV-039-01', 'ECOLE PRIMAIRE MISSION LIBANAISE', 2553, 1087, 686, 1, NULL, NULL),
	(2, 'LV-039-02', 'GS MARIE DES PETITS', 1606, 684, 433, 1, NULL, NULL),
	(3, 'LV-039-03', 'GS HARRIS RAIMOND DECLERC', 1753, 746, 470, 1, NULL, NULL),
	(4, 'LV-039-04', 'EPV KONATE', 3196, 1360, 863, 2, NULL, NULL),
	(5, 'LV-039-05', 'GS JEAN PORQUET', 4351, 1852, 1168, 2, NULL, NULL),
	(6, 'LV-039-06', 'COLLEGE MODERNE LE PANTHEON (COLLEGE JP SARTRE)', 2457, 1046, 662, 3, NULL, NULL),
	(7, 'LV-039-07', 'EPV LA SORBONNE', 4113, 1750, 1108, 3, NULL, NULL),
	(8, 'LV-039-08', 'GS METHODISTE', 2709, 1153, 727, 3, NULL, NULL),
	(9, 'LV-039-09', 'GS JEAN DELAFOSSE', 3063, 1304, 822, 4, NULL, NULL),
	(10, 'LV-039-10', 'LYCEE MODERNE DJEDJI AMONDJI PIERRE', 2435, 1036, 656, 4, NULL, NULL),
	(11, 'LV-039-11', 'ECOLE PRIMAIRE CROIX ROUGE (IMST)', 3621, 1541, 977, 5, NULL, NULL),
	(12, 'LV-039-12', 'INSTITUT SOMA SAMAKE', 2152, 916, 578, 5, NULL, NULL),
	(13, 'LV-039-13', 'EPV VICTOR SCHOELCHER', 1874, 798, 504, 5, NULL, NULL),
	(14, 'LV-039-14', 'EPV LES MESANGES', 2239, 953, 604, 5, NULL, NULL),
	(15, 'LV-039-15', 'INSTITUT SCOLAIRE PRIVE MARDOCHE', 1120, 953, 301, 5, NULL, NULL),
	(16, 'LV-039-16', 'GROUPE SCOLAIRE MUNICIPALITE', 1854, 789, 499, 5, NULL, NULL),
	(17, 'LV-039-17', 'GS PAILLET', 2669, 1136, 719, 6, NULL, NULL),
	(18, 'LV-039-18', 'ECOLE MATERNELLE MUNICIPALE PAILLET', 2922, 1244, 786, 6, NULL, NULL),
	(19, 'LV-039-19', 'GS MERLAN PAILLET', 598, 255, 161, 6, NULL, NULL),
	(20, 'LV-039-20', 'EPP SYLLA YOUSSOUF OU MACACI', 2415, 1028, 651, 7, NULL, NULL),
	(21, 'LV-039-21', 'GS JACOB WILLIAMS', 2334, 993, 626, 8, NULL, NULL),
	(22, 'LV-039-22', 'EPP OUEZZIN COULIBALY 2', 2271, 967, 610, 8, NULL, NULL),
	(23, 'LV-039-23', 'EPP CHATEAU D\'EAU', 2166, 922, 582, 8, NULL, NULL),
	(24, 'LV-039-24', 'EPV SOMA SAMAKE', 2144, 912, 576, 9, NULL, NULL),
	(25, 'LV-039-25', 'COLLEGE SAINT BERNARD', 3173, 1350, 854, 9, NULL, NULL),
	(26, 'LV-039-26', 'COLLEGE MAKAN TRAORE', 2530, 1077, 680, 9, NULL, NULL),
	(27, 'LV-039-27', 'COMPLEXE SOCIO-EDUCATIF ADJAME SANTE', 3269, 1391, 881, 10, NULL, NULL),
	(28, 'LV-039-28', 'GS YACE ATTOUMBRE', 2130, 907, 573, 10, NULL, NULL),
	(29, 'LV-039-29', 'GS BIA', 3037, 1293, 816, 10, NULL, NULL),
	(30, 'LV-039-30', 'GS SATIGUI SANGARE', 2252, 958, 605, 11, NULL, NULL),
	(31, 'LV-039-31', 'CENTRE SOCIAL MUNICIPAL', 2216, 943, 596, 11, NULL, NULL),
	(32, 'LV-039-32', 'EPV LES ALLOUETTES', 2060, 877, 555, 12, NULL, NULL),
	(33, 'LV-039-33', 'COLLEGE VICTOR HUGO', 2946, 1254, 792, 12, NULL, NULL),
	(34, 'LV-039-34', 'GS HABITAT SERY KORE MARIE', 2084, 887, 561, 12, NULL, NULL),
	(35, 'LV-039-35', 'GS LIBERTE EBRIE', 5599, 2383, 1504, 13, NULL, NULL),
	(36, 'LV-039-36', 'GS ROLAND CISSE', 1782, 758, 480, 13, NULL, NULL),
	(37, 'LV-039-37', 'EPV LES HIRONDELLES', 2301, 979, 617, 13, NULL, NULL),
	(38, 'LV-039-38', 'EPV CATHOLIQUE ST MICHEL', 1938, 825, 520, 14, NULL, NULL),
	(39, 'LV-039-39', 'NOTRE DAME DES APOTRES (IVOIRE COUTURE)', 1995, 849, 538, 14, NULL, NULL),
	(40, 'LV-039-40', 'GS DIA KOUAKOU', 2050, 872, 552, 15, NULL, NULL),
	(41, 'LV-039-41', 'GS SODECI ZONE NORD', 2020, 860, 545, 16, NULL, NULL),
	(42, 'LV-039-42', 'ECOLE MATERNELLE MUNICIPALE', 3207, 1365, 865, 16, NULL, NULL),
	(43, 'LV-039-43', 'GROUPE SCOLAIRE BAD WILLIAMSVILLE', 5304, 2257, 1425, 17, NULL, NULL),
	(44, 'LV-039-44', 'INSTITUT SUPERIEUR D\'INFORMATIQUE ET D\'ELECTRONIQUE', 2951, 1256, 794, 17, NULL, NULL),
	(45, 'LV-039-45', 'LYCEE MUNICIPAL ADJAME WILLIAMSVILLE', 4023, 1712, 1085, 18, NULL, NULL);

-- Listage de la structure de table votimedata. migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table votimedata.migrations : ~0 rows (environ)

-- Listage de la structure de table votimedata. model_has_permissions
CREATE TABLE IF NOT EXISTS `model_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table votimedata.model_has_permissions : ~0 rows (environ)

-- Listage de la structure de table votimedata. model_has_roles
CREATE TABLE IF NOT EXISTS `model_has_roles` (
  `role_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table votimedata.model_has_roles : ~0 rows (environ)
INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
	(2, 'App\\Models\\User', 1);

-- Listage de la structure de table votimedata. parrains
CREATE TABLE IF NOT EXISTS `parrains` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nom_pren_par` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `telephone_par` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nom` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `cart_milit` enum('Oui','Non','Sympatisant') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `list_elect` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `cart_elect` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `telephone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_naiss` date NOT NULL,
  `code_lv` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `residence` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `profession` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `observation` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table votimedata.parrains : ~0 rows (environ)

-- Listage de la structure de table votimedata. password_resets
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table votimedata.password_resets : ~0 rows (environ)

-- Listage de la structure de table votimedata. permissions
CREATE TABLE IF NOT EXISTS `permissions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=89 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table votimedata.permissions : ~88 rows (environ)
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
	(81, 'can set rules', 'web', '2023-04-18 19:42:37', '2023-04-18 19:42:37'),
	(82, 'recens-parrain', 'web', '2023-04-19 14:22:16', '2023-04-19 14:22:55'),
	(83, 'recens-commune', 'web', '2023-04-19 14:25:37', '2023-04-19 14:25:37'),
	(84, 'recens-section', 'web', '2023-04-19 14:25:50', '2023-04-19 14:25:50'),
	(85, 'recens-quartier', 'web', '2023-04-19 14:26:01', '2023-04-19 14:26:01'),
	(86, 'recens-lieuvote', 'web', '2023-04-19 14:26:11', '2023-04-19 14:26:11'),
	(87, 'operateurs-view', 'web', '2023-04-19 20:14:59', '2023-04-19 20:14:59'),
	(88, 'can-set-super-admin', 'web', '2023-04-21 15:40:19', '2023-04-21 15:40:19');

-- Listage de la structure de table votimedata. personal_access_tokens
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table votimedata.personal_access_tokens : ~0 rows (environ)

-- Listage de la structure de table votimedata. proces_verbals
CREATE TABLE IF NOT EXISTS `proces_verbals` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `libel` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `bureau_vote_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `proces_verbals_bureau_vote_id_foreign` (`bureau_vote_id`),
  CONSTRAINT `proces_verbals_bureau_vote_id_foreign` FOREIGN KEY (`bureau_vote_id`) REFERENCES `bureau_votes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table votimedata.proces_verbals : ~0 rows (environ)

-- Listage de la structure de table votimedata. quartiers
CREATE TABLE IF NOT EXISTS `quartiers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `libel` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
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

-- Listage des données de la table votimedata.quartiers : ~0 rows (environ)
INSERT INTO `quartiers` (`id`, `libel`, `nbrinscrit`, `objectif`, `seuil`, `section_id`, `created_at`, `updated_at`) VALUES
	(1, 'ADJAME VILLAGE', 5912, 2517, 1589, 1, NULL, NULL),
	(2, 'WILLIAMSVILLE 1', 7547, 3212, 2031, 2, NULL, NULL),
	(3, 'WILLIASMVILLE 2', 9279, 3949, 2497, 2, NULL, NULL),
	(4, '220 LOGEMENTS', 5498, 2340, 1478, 3, NULL, NULL),
	(5, 'MARIE THERESE', 12860, 5950, 3463, 3, NULL, NULL),
	(6, 'PAILLET', 6189, 2635, 1666, 4, NULL, NULL),
	(7, 'WILLI 3 MACACI / PAILLET EXTENSION', 2415, 1028, 651, 4, NULL, NULL),
	(8, 'ADJAME NORD', 6771, 2882, 1818, 5, NULL, NULL),
	(9, 'BROMACOTE', 7847, 3339, 2110, 5, NULL, NULL),
	(10, 'MAIRIE 1', 8436, 3591, 2270, 5, NULL, NULL),
	(11, 'MAIRIE 2', 4468, 1901, 1201, 5, NULL, NULL),
	(12, 'HABITAT EXTENSION', 7090, 3018, 1908, 6, NULL, NULL),
	(13, 'QUARTIER EBRIE', 9682, 4120, 2601, 6, NULL, NULL),
	(14, 'SAINT MICHEL', 3933, 1674, 1058, 7, NULL, NULL),
	(15, 'QUARTIER FILTISAC ET SOLEIL', 2050, 872, 552, 8, NULL, NULL),
	(16, 'SODECI WILLIAMSVILLE', 5227, 2225, 1410, 8, NULL, NULL),
	(17, 'WILLIAMSVILLE 3 ', 8255, 3513, 2219, 8, NULL, NULL),
	(18, 'WILLIAMSVILLE 3 MACACI ', 4023, 1712, 1085, 8, NULL, NULL);

-- Listage de la structure de table votimedata. roles
CREATE TABLE IF NOT EXISTS `roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table votimedata.roles : ~5 rows (environ)
INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
	(1, 'user', 'web', '2023-04-18 18:25:17', '2023-04-18 18:25:17'),
	(2, 'super-admin', 'web', '2023-04-18 18:25:20', '2023-04-18 18:25:20'),
	(3, 'operateurs de recensement', 'web', '2023-04-18 19:27:11', '2023-04-18 19:27:36'),
	(4, 'operateurs suivi et resultats', 'web', '2023-04-18 19:38:13', '2023-04-18 19:38:13'),
	(5, 'parrain viewer', 'web', '2023-04-19 13:01:03', '2023-04-19 13:01:03');

-- Listage de la structure de table votimedata. role_has_permissions
CREATE TABLE IF NOT EXISTS `role_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `role_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table votimedata.role_has_permissions : ~0 rows (environ)
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
	(87, 2),
	(88, 2),
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
	(79, 4),
	(87, 4),
	(26, 5),
	(27, 5),
	(41, 5),
	(42, 5),
	(78, 5),
	(79, 5),
	(81, 5),
	(82, 5),
	(83, 5),
	(84, 5),
	(85, 5),
	(86, 5),
	(87, 5);

-- Listage de la structure de table votimedata. sections
CREATE TABLE IF NOT EXISTS `sections` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `libel` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
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

-- Listage des données de la table votimedata.sections : ~0 rows (environ)
INSERT INTO `sections` (`id`, `libel`, `nbrinscrit`, `objectif`, `seuil`, `commune_id`, `created_at`, `updated_at`) VALUES
	(1, 'ADJAME VILLAGE', 5912, 2517, 1589, 39, NULL, NULL),
	(2, 'CROIX BLEU', 16826, 7161, 4528, 39, NULL, NULL),
	(3, 'MARIE THERESE', 18358, 8290, 4941, 39, NULL, NULL),
	(4, 'PAILLET', 8604, 3663, 2317, 39, NULL, NULL),
	(5, 'PEULLIEUVILLE', 27522, 11713, 7399, 39, NULL, NULL),
	(6, 'QUARTIER EBRIE NORD EST', 16772, 7138, 4509, 39, NULL, NULL),
	(7, 'SAINT MICHEL', 3933, 1674, 1058, 39, NULL, NULL),
	(8, 'SODECI MACACI', 19555, 8322, 5266, 39, NULL, NULL);

-- Listage de la structure de table votimedata. sessions
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `payload` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table votimedata.sessions : ~0 rows (environ)

-- Listage de la structure de table votimedata. sup_lieu_de_votes
CREATE TABLE IF NOT EXISTS `sup_lieu_de_votes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `telephone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `lieu_vote_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sup_lieu_de_votes_lieu_vote_id_foreign` (`lieu_vote_id`),
  CONSTRAINT `sup_lieu_de_votes_lieu_vote_id_foreign` FOREIGN KEY (`lieu_vote_id`) REFERENCES `lieu_votes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table votimedata.sup_lieu_de_votes : ~0 rows (environ)

-- Listage de la structure de table votimedata. users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_naiss` date NOT NULL,
  `super_admin` smallint NOT NULL DEFAULT '0',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `commune_id` bigint unsigned DEFAULT NULL,
  `departement_id` bigint unsigned DEFAULT NULL,
  `photo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_commune_id_foreign` (`commune_id`),
  KEY `users_departement_id_foreign` (`departement_id`),
  CONSTRAINT `users_commune_id_foreign` FOREIGN KEY (`commune_id`) REFERENCES `communes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `users_departement_id_foreign` FOREIGN KEY (`departement_id`) REFERENCES `departements` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table votimedata.users : ~1 rows (environ)
INSERT INTO `users` (`id`, `name`, `prenom`, `email`, `date_naiss`, `super_admin`, `email_verified_at`, `password`, `remember_token`, `commune_id`, `departement_id`, `photo`, `created_at`, `updated_at`) VALUES
	(1, 'Adminer', 'Tkfaart', 'admin@admin.com', '2023-04-18', 1, NULL, '$2y$10$896NodTfaiJSqnaAU45MD.tcJWQ/1naVMqFIyN0Ke8Wy/eu0Fc7CO', 'pyDJaz9FhFQgm8bsEeRejd2of285G3QvPm118PM5ySXKG0i2iUeKWV8hySYI', NULL, NULL, NULL, '2023-04-18 18:36:05', '2023-04-18 18:36:06');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
