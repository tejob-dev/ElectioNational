CREATE DATABASE IF NOT EXISTS `referal_tkfa_info` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `referal_tkfa_info`;

-- --------------------------------------------------------

--
-- Structure de la table `agent_de_sections`
--

CREATE TABLE `agent_de_sections` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telephone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `section_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `agent_de_sections`
--

INSERT INTO `agent_de_sections` (`id`, `nom`, `prenom`, `telephone`, `section_id`, `created_at`, `updated_at`) VALUES
(1, 'Opérateur', 'ADJAME VILLAGE', '0707070707', 1, '2023-04-26 16:03:04', '2023-04-26 16:03:04'),
(2, 'Opérateur', 'CROIX BLEU', '0707070707', 2, '2023-04-26 16:06:51', '2023-04-26 16:06:51'),
(3, 'Opérateur', 'MARIE THERESE', '0707070707', 3, '2023-04-26 16:09:19', '2023-04-26 16:09:19'),
(4, 'Opérateur', 'PAILLET', '0707070707', 4, '2023-04-26 16:13:25', '2023-04-26 16:13:25'),
(5, 'Opérateur', 'PEULLIEUVILLE', '0707070707', 5, '2023-04-26 16:16:52', '2023-04-26 16:16:52'),
(6, 'Opérateur', 'QUARTIER EBRIE NORD EST', '0707070707', 6, '2023-04-26 16:19:08', '2023-04-26 16:19:08'),
(7, 'Opérateur', 'SAINT MICHEL', '0707070707', 7, '2023-04-26 16:21:41', '2023-04-26 16:21:41'),
(8, 'Opérateur', 'SODECI MACACI', '0707070707', 8, '2023-04-26 16:25:20', '2023-04-26 16:25:20');

-- --------------------------------------------------------

--
-- Structure de la table `agent_du_bureau_votes`
--

CREATE TABLE `agent_du_bureau_votes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telphone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bureau_vote_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `agent_terrains`
--

CREATE TABLE `agent_terrains` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telephone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lieu_vote_id` bigint(20) UNSIGNED DEFAULT NULL,
  `section_id` bigint(20) UNSIGNED DEFAULT NULL,
  `sous_section_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `bureau_votes`
--

CREATE TABLE `bureau_votes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `libel` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `objectif` int(11) NOT NULL,
  `seuil` int(11) NOT NULL,
  `lieu_vote_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `bureau_votes`
--

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
(278, 'BV03', 448, 121, 45, '2023-04-22 15:25:12', '2023-04-22 15:25:12'),
(279, 'BV04', 448, 121, 45, NULL, NULL),
(280, 'BV05', 448, 121, 45, NULL, NULL),
(281, 'BV06', 448, 121, 45, NULL, NULL),
(282, 'BV07', 448, 121, 45, NULL, NULL),
(283, 'BV08', 447, 120, 45, NULL, NULL),
(284, 'BV09', 440, 118, 45, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `candidats`
--

CREATE TABLE `candidats` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `couleur` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parti` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `candidats`
--

INSERT INTO `candidats` (`id`, `nom`, `prenom`, `code`, `photo`, `couleur`, `parti`, `created_at`, `updated_at`) VALUES
(6, 'GERARD', 'BOHUI', NULL, 'public/uVJAuU60J4t7f66xluBUudwsXUIvJjwiHYSL22Tp.png', '#00dad4', 'PPA-CI / PDCI-RDA', '2023-04-25 12:47:31', '2023-08-04 23:31:20'),
(11, 'SOUALIO', 'DOSSO', NULL, 'public/Hf8p08ZPC7kRWLp3XtEXFI7mafiqCm5qLePQMel1.png', '#01a800', 'INDEPENDANT', '2023-08-04 23:33:25', '2023-08-04 23:33:25'),
(12, 'BEN', 'CISSE', NULL, 'public/lZNmMPZyI6AimwhzuK5pCjW1eKkBPCNDzbEUIHfy.png', '#e8bd00', 'INDEPENDANT', '2023-08-04 23:35:42', '2023-08-04 23:35:42'),
(13, 'FARIKOU', 'SOUMAHORO', NULL, 'public/NWeAoftPml51dPbb0xRxpMHS8WEChzbR2mq8UCQI.png', '#fe9900', 'RHDP', '2023-08-04 23:37:13', '2023-08-04 23:37:13'),
(14, 'ZANGA', 'COULIBALY', NULL, 'public/GMDZ59m6ltWWE4XwjnutOBiyhEfLMq7xoPkzjtwn.png', '#fe0000', 'INDEPENDANT', '2023-08-04 23:38:54', '2023-08-04 23:38:54');

-- --------------------------------------------------------

--
-- Structure de la table `communes`
--

CREATE TABLE `communes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `libel` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nbrinscrit` int(11) NOT NULL,
  `objectif` int(11) NOT NULL,
  `seuil` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `communes`
--

INSERT INTO `communes` (`id`, `libel`, `nbrinscrit`, `objectif`, `seuil`, `created_at`, `updated_at`) VALUES
(39, 'ADJAME COMMUNE 039', 117482, 50478, 31607, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `commune_departement`
--

CREATE TABLE `commune_departement` (
  `commune_id` bigint(20) UNSIGNED NOT NULL,
  `departement_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `commune_lieu_vote`
--

CREATE TABLE `commune_lieu_vote` (
  `lieu_vote_id` bigint(20) UNSIGNED NOT NULL,
  `commune_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `departements`
--

CREATE TABLE `departements` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `libel` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nbrinscrit` int(11) NOT NULL,
  `objectif` int(11) NOT NULL,
  `seuil` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `lieu_votes`
--

CREATE TABLE `lieu_votes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `libel` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nbrinscrit` int(11) NOT NULL,
  `objectif` int(11) NOT NULL,
  `seuil` int(11) NOT NULL,
  `quartier_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `lieu_votes`
--

INSERT INTO `lieu_votes` (`id`, `code`, `libel`, `nbrinscrit`, `objectif`, `seuil`, `quartier_id`, `created_at`, `updated_at`) VALUES
(1, 'LV-039-01', 'ECOLE PRIMAIRE MISSION LIBANAISE', 2553, 1087, 686, 1, NULL, NULL),
(2, 'LV-039-02', 'GS MARIE DES PETITS', 1606, 684, 433, 1, NULL, NULL),
(3, 'LV-039-03', 'GS HARRIS RAIMOND DECLERC', 1753, 746, 470, 1, NULL, NULL),
(4, 'LV-039-04', 'EPV KONATE', 3196, 1360, 863, 2, NULL, NULL),
(5, 'LV-039-05', 'GS JEAN PORQUET', 4351, 1852, 1168, 2, NULL, NULL),
(6, 'LV-039-06', 'COLLEGE MODERNE LE PANTHEON (COLLEGE JP SARTRE)', 2457, 1046, 662, 3, NULL, NULL),
(7, 'LV-039-07', 'EPV LA SORBONNE', 4113, 1750, 1108, 3, NULL, NULL),
(8, 'LV-039-08', 'GS METHODISTE', 2709, 1153, 727, 3, NULL, NULL),
(9, 'LV-039-09', 'ECOLE PRIMAIRE CROIX ROUGE (IMST)', 3063, 1304, 822, 4, NULL, NULL),
(10, 'LV-039-10', 'INSTITUT SOMA SAMAKE', 2435, 1036, 656, 4, NULL, NULL),
(11, 'LV-039-11', 'EPV VICTOR SCHOELCHER', 3621, 1541, 977, 5, NULL, NULL),
(12, 'LV-039-12', 'EPV LES MESANGES', 2152, 916, 578, 5, NULL, NULL),
(13, 'LV-039-13', 'INSTITUT SCOLAIRE PRIVE MARDOCHE', 1874, 798, 504, 5, NULL, NULL),
(14, 'LV-039-14', 'GROUPE SCOLAIRE MUNICIPALITE', 2239, 953, 604, 5, NULL, NULL),
(15, 'LV-039-15', 'GS JEAN DELAFOSSE', 1120, 953, 301, 5, NULL, NULL),
(16, 'LV-039-16', 'LYCEE MODERNE DJEDJI AMONDJI PIERRE', 1854, 789, 499, 5, NULL, NULL),
(17, 'LV-039-17', 'GS PAILLET', 2669, 1136, 719, 6, NULL, NULL),
(18, 'LV-039-18', 'EPP SYLLA YOUSSOUF OU MACACI', 2922, 1244, 786, 6, NULL, NULL),
(19, 'LV-039-19', 'ECOLE MATERNELLE MUNICIPALE PAILLET', 598, 255, 161, 6, NULL, NULL),
(20, 'LV-039-20', 'GS MERLAN PAILLET', 2415, 1028, 651, 7, NULL, NULL),
(21, 'LV-039-21', 'COMPLEXE SOCIO-EDUCATIF ADJAME SANTE', 2334, 993, 626, 8, NULL, NULL),
(22, 'LV-039-22', 'GS YACE ATTOUMBRE', 2271, 967, 610, 8, NULL, NULL),
(23, 'LV-039-23', 'GS BIA', 2166, 922, 582, 8, NULL, NULL),
(24, 'LV-039-24', 'GS SATIGUI', 2144, 912, 576, 9, NULL, NULL),
(25, 'LV-039-25', 'CENTRE SOCIAL MUNICIPAL', 3173, 1350, 854, 9, NULL, NULL),
(26, 'LV-039-26', 'EPV SOMA SAMAKE', 2530, 1077, 680, 9, NULL, NULL),
(27, 'LV-039-27', 'COLLEGE SAINT BERNARD', 3269, 1391, 881, 10, NULL, NULL),
(28, 'LV-039-28', 'GS JACOB WILLIAMS', 2130, 907, 573, 10, NULL, NULL),
(29, 'LV-039-29', 'COLLEGE MAKAN TRAORE', 3037, 1293, 816, 10, NULL, NULL),
(30, 'LV-039-30', 'EPP OUEZZIN COULIBALY 2', 2252, 958, 605, 11, NULL, NULL),
(31, 'LV-039-31', 'EPP CHATEAU D\'EAU', 2216, 943, 596, 11, NULL, NULL),
(32, 'LV-039-32', 'EPV LES ALLOUETTES', 2060, 877, 555, 12, NULL, NULL),
(33, 'LV-039-33', 'COLLEGE VICTOR HUGO', 2946, 1254, 792, 12, NULL, NULL),
(34, 'LV-039-34', 'GS HABITAT SERY KORE MARIE', 2084, 887, 561, 12, NULL, NULL),
(35, 'LV-039-35', 'GS LIBERTE EBRIE', 5599, 2383, 1504, 13, NULL, NULL),
(36, 'LV-039-36', 'GS ROLAND CISSE', 1782, 758, 480, 13, NULL, NULL),
(37, 'LV-039-37', 'EPV LES HIRONDELLES', 2301, 979, 617, 13, NULL, NULL),
(38, 'LV-039-38', 'EPV CATHOLIQUE ST MICHEL', 1938, 825, 520, 14, NULL, NULL),
(39, 'LV-039-39', 'NOTRE DAME DES APOTRES (IVOIRE COUTURE)', 1995, 849, 538, 14, NULL, NULL),
(40, 'LV-039-40', 'GROUPE SCOLAIRE BAD WILLIAMSVILLE', 2050, 872, 552, 15, NULL, NULL),
(41, 'LV-039-41', 'INSTITUT SUPERIEUR D\'INFORMATIQUE ET D\'ELECTRONIQUE', 2020, 860, 545, 16, NULL, NULL),
(42, 'LV-039-42', 'GS SODECI ZONE NORD', 3207, 1365, 865, 16, NULL, NULL),
(43, 'LV-039-43', 'GS DIA KOUAKOU', 5304, 2257, 1425, 17, NULL, NULL),
(44, 'LV-039-44', 'ECOLE MATERNELLE MUNICIPALE', 2951, 1256, 794, 17, NULL, NULL),
(45, 'LV-039-45', 'LYCEE MUNICIPAL ADJAME WILLIAMSVILLE', 4023, 1712, 1085, 18, NULL, NULL),
(46, 'LV-AC', 'AUTRE CIRCONSCRIPTION', 0, 0, 0, NULL, '2023-06-04 20:40:56', '2023-06-04 20:40:56');

-- --------------------------------------------------------

--
-- Structure de la table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(2, 'App\\Models\\User', 1),
(6, 'App\\Models\\User', 2),
(7, 'App\\Models\\User', 9),
(7, 'App\\Models\\User', 10),
(7, 'App\\Models\\User', 11),
(7, 'App\\Models\\User', 12),
(7, 'App\\Models\\User', 13),
(7, 'App\\Models\\User', 14),
(7, 'App\\Models\\User', 15),
(7, 'App\\Models\\User', 16),
(8, 'App\\Models\\User', 17),
(11, 'App\\Models\\User', 18);

-- --------------------------------------------------------

--
-- Structure de la table `parrains`
--

CREATE TABLE `parrains` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nom_pren_par` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telephone_par` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `recenser` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cart_milit` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `list_elect` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cart_elect` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telephone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_naiss` date NOT NULL,
  `code_lv` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `residence` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `profession` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `observation` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(16) COLLATE utf8mb4_unicode_ci DEFAULT 'Non traité',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'list agentdesections', 'web', '2023-04-18 16:25:14', '2023-04-18 16:25:14'),
(2, 'view agentdesections', 'web', '2023-04-18 16:25:14', '2023-04-18 16:25:14'),
(3, 'create agentdesections', 'web', '2023-04-18 16:25:14', '2023-04-18 16:25:14'),
(4, 'update agentdesections', 'web', '2023-04-18 16:25:14', '2023-04-18 16:25:14'),
(5, 'delete agentdesections', 'web', '2023-04-18 16:25:14', '2023-04-18 16:25:14'),
(6, 'list agentdubureauvotes', 'web', '2023-04-18 16:25:14', '2023-04-18 16:25:14'),
(7, 'view agentdubureauvotes', 'web', '2023-04-18 16:25:15', '2023-04-18 16:25:15'),
(8, 'create agentdubureauvotes', 'web', '2023-04-18 16:25:15', '2023-04-18 16:25:15'),
(9, 'update agentdubureauvotes', 'web', '2023-04-18 16:25:15', '2023-04-18 16:25:15'),
(10, 'delete agentdubureauvotes', 'web', '2023-04-18 16:25:15', '2023-04-18 16:25:15'),
(11, 'list agentterrains', 'web', '2023-04-18 16:25:15', '2023-04-18 16:25:15'),
(12, 'view agentterrains', 'web', '2023-04-18 16:25:15', '2023-04-18 16:25:15'),
(13, 'create agentterrains', 'web', '2023-04-18 16:25:15', '2023-04-18 16:25:15'),
(14, 'update agentterrains', 'web', '2023-04-18 16:25:15', '2023-04-18 16:25:15'),
(15, 'delete agentterrains', 'web', '2023-04-18 16:25:15', '2023-04-18 16:25:15'),
(16, 'list bureauvotes', 'web', '2023-04-18 16:25:15', '2023-04-18 16:25:15'),
(17, 'view bureauvotes', 'web', '2023-04-18 16:25:15', '2023-04-18 16:25:15'),
(18, 'create bureauvotes', 'web', '2023-04-18 16:25:15', '2023-04-18 16:25:15'),
(19, 'update bureauvotes', 'web', '2023-04-18 16:25:15', '2023-04-18 16:25:15'),
(20, 'delete bureauvotes', 'web', '2023-04-18 16:25:15', '2023-04-18 16:25:15'),
(21, 'list candidats', 'web', '2023-04-18 16:25:15', '2023-04-18 16:25:15'),
(22, 'view candidats', 'web', '2023-04-18 16:25:15', '2023-04-18 16:25:15'),
(23, 'create candidats', 'web', '2023-04-18 16:25:15', '2023-04-18 16:25:15'),
(24, 'update candidats', 'web', '2023-04-18 16:25:15', '2023-04-18 16:25:15'),
(25, 'delete candidats', 'web', '2023-04-18 16:25:15', '2023-04-18 16:25:15'),
(26, 'list communes', 'web', '2023-04-18 16:25:15', '2023-04-18 16:25:15'),
(27, 'view communes', 'web', '2023-04-18 16:25:15', '2023-04-18 16:25:15'),
(28, 'create communes', 'web', '2023-04-18 16:25:15', '2023-04-18 16:25:15'),
(29, 'update communes', 'web', '2023-04-18 16:25:15', '2023-04-18 16:25:15'),
(30, 'delete communes', 'web', '2023-04-18 16:25:15', '2023-04-18 16:25:15'),
(31, 'list departements', 'web', '2023-04-18 16:25:15', '2023-04-18 16:25:15'),
(32, 'view departements', 'web', '2023-04-18 16:25:15', '2023-04-18 16:25:15'),
(33, 'create departements', 'web', '2023-04-18 16:25:16', '2023-04-18 16:25:16'),
(34, 'update departements', 'web', '2023-04-18 16:25:16', '2023-04-18 16:25:16'),
(35, 'delete departements', 'web', '2023-04-18 16:25:16', '2023-04-18 16:25:16'),
(36, 'list lieuvotes', 'web', '2023-04-18 16:25:16', '2023-04-18 16:25:16'),
(37, 'view lieuvotes', 'web', '2023-04-18 16:25:16', '2023-04-18 16:25:16'),
(38, 'create lieuvotes', 'web', '2023-04-18 16:25:16', '2023-04-18 16:25:16'),
(39, 'update lieuvotes', 'web', '2023-04-18 16:25:16', '2023-04-18 16:25:16'),
(40, 'delete lieuvotes', 'web', '2023-04-18 16:25:16', '2023-04-18 16:25:16'),
(41, 'list parrains', 'web', '2023-04-18 16:25:16', '2023-04-18 16:25:16'),
(42, 'view parrains', 'web', '2023-04-18 16:25:16', '2023-04-18 16:25:16'),
(43, 'create parrains', 'web', '2023-04-18 16:25:16', '2023-04-18 16:25:16'),
(44, 'update parrains', 'web', '2023-04-18 16:25:16', '2023-04-18 16:25:16'),
(45, 'delete parrains', 'web', '2023-04-18 16:25:16', '2023-04-18 16:25:16'),
(46, 'list procesverbals', 'web', '2023-04-18 16:25:16', '2023-04-18 16:25:16'),
(47, 'view procesverbals', 'web', '2023-04-18 16:25:16', '2023-04-18 16:25:16'),
(48, 'create procesverbals', 'web', '2023-04-18 16:25:16', '2023-04-18 16:25:16'),
(49, 'update procesverbals', 'web', '2023-04-18 16:25:16', '2023-04-18 16:25:16'),
(50, 'delete procesverbals', 'web', '2023-04-18 16:25:16', '2023-04-18 16:25:16'),
(51, 'list quartiers', 'web', '2023-04-18 16:25:16', '2023-04-18 16:25:16'),
(52, 'view quartiers', 'web', '2023-04-18 16:25:16', '2023-04-18 16:25:16'),
(53, 'create quartiers', 'web', '2023-04-18 16:25:16', '2023-04-18 16:25:16'),
(54, 'update quartiers', 'web', '2023-04-18 16:25:16', '2023-04-18 16:25:16'),
(55, 'delete quartiers', 'web', '2023-04-18 16:25:16', '2023-04-18 16:25:16'),
(56, 'list sections', 'web', '2023-04-18 16:25:16', '2023-04-18 16:25:16'),
(57, 'view sections', 'web', '2023-04-18 16:25:16', '2023-04-18 16:25:16'),
(58, 'create sections', 'web', '2023-04-18 16:25:17', '2023-04-18 16:25:17'),
(59, 'update sections', 'web', '2023-04-18 16:25:17', '2023-04-18 16:25:17'),
(60, 'delete sections', 'web', '2023-04-18 16:25:17', '2023-04-18 16:25:17'),
(61, 'list suplieudevotes', 'web', '2023-04-18 16:25:17', '2023-04-18 16:25:17'),
(62, 'view suplieudevotes', 'web', '2023-04-18 16:25:17', '2023-04-18 16:25:17'),
(63, 'create suplieudevotes', 'web', '2023-04-18 16:25:17', '2023-04-18 16:25:17'),
(64, 'update suplieudevotes', 'web', '2023-04-18 16:25:17', '2023-04-18 16:25:17'),
(65, 'delete suplieudevotes', 'web', '2023-04-18 16:25:17', '2023-04-18 16:25:17'),
(66, 'list roles', 'web', '2023-04-18 16:25:19', '2023-04-18 16:25:19'),
(67, 'view roles', 'web', '2023-04-18 16:25:19', '2023-04-18 16:25:19'),
(68, 'create roles', 'web', '2023-04-18 16:25:19', '2023-04-18 16:25:19'),
(69, 'update roles', 'web', '2023-04-18 16:25:19', '2023-04-18 16:25:19'),
(70, 'delete roles', 'web', '2023-04-18 16:25:19', '2023-04-18 16:25:19'),
(71, 'list permissions', 'web', '2023-04-18 16:25:19', '2023-04-18 16:25:19'),
(72, 'view permissions', 'web', '2023-04-18 16:25:19', '2023-04-18 16:25:19'),
(73, 'create permissions', 'web', '2023-04-18 16:25:19', '2023-04-18 16:25:19'),
(74, 'update permissions', 'web', '2023-04-18 16:25:19', '2023-04-18 16:25:19'),
(75, 'delete permissions', 'web', '2023-04-18 16:25:19', '2023-04-18 16:25:19'),
(76, 'list users', 'web', '2023-04-18 16:25:20', '2023-04-18 16:25:20'),
(77, 'view users', 'web', '2023-04-18 16:25:20', '2023-04-18 16:25:20'),
(78, 'create users', 'web', '2023-04-18 16:25:20', '2023-04-18 16:25:20'),
(79, 'update users', 'web', '2023-04-18 16:25:20', '2023-04-18 16:25:20'),
(80, 'delete users', 'web', '2023-04-18 16:25:20', '2023-04-18 16:25:20'),
(81, 'can set rules', 'web', '2023-04-18 17:42:37', '2023-04-18 17:42:37'),
(82, 'recens-parrain', 'web', '2023-04-19 12:22:16', '2023-04-19 12:22:55'),
(83, 'recens-commune', 'web', '2023-04-19 12:25:37', '2023-04-19 12:25:37'),
(84, 'recens-section', 'web', '2023-04-19 12:25:50', '2023-04-19 12:25:50'),
(85, 'recens-quartier', 'web', '2023-04-19 12:26:01', '2023-04-19 12:26:01'),
(86, 'recens-lieuvote', 'web', '2023-04-19 12:26:11', '2023-04-19 12:26:11'),
(87, 'operateurs-view', 'web', '2023-04-19 18:14:59', '2023-04-19 18:14:59'),
(88, 'can-set-super-admin', 'web', '2023-04-21 13:40:19', '2023-04-21 13:40:19'),
(89, 'can-export-parrain', 'web', '2023-04-22 11:24:13', '2023-04-22 11:24:13'),
(90, 'can-open-section-only', 'web', '2023-04-25 05:48:55', '2023-04-25 05:48:55'),
(91, 'can-open-all', 'web', '2023-04-25 05:49:25', '2023-04-25 05:49:25'),
(92, 'administration viewer', 'web', '2023-04-26 17:42:38', '2023-04-26 17:42:38'),
(93, 'recensement viewer', 'web', '2023-04-26 17:43:43', '2023-04-26 17:44:11'),
(94, 'accueil viewer', 'web', '2023-04-26 17:44:39', '2023-04-26 17:44:39'),
(95, 'list soussections', 'web', '2023-05-29 20:27:40', '2023-05-29 20:27:40'),
(96, 'view soussections', 'web', '2023-05-29 20:28:03', '2023-05-29 20:28:03'),
(97, 'create soussections', 'web', '2023-05-29 20:28:28', '2023-05-29 20:28:28'),
(98, 'update soussections', 'web', '2023-05-29 20:28:43', '2023-05-29 20:28:43'),
(99, 'delete soussections', 'web', '2023-05-29 20:29:13', '2023-05-29 20:29:13'),
(100, 'recens-sous-section', 'web', '2023-06-01 12:44:57', '2023-06-01 12:44:57'),
(101, 'can-open-soussection-only', 'web', '2023-06-01 12:50:50', '2023-06-01 12:50:50'),
(102, 'can-change-code-lv', 'web', '2023-06-02 14:02:14', '2023-06-02 14:02:14'),
(103, 'can-change-libel-lv', 'web', '2023-06-02 14:02:37', '2023-06-02 14:02:37'),
(104, 'can-change-inscrit-lv', 'web', '2023-06-02 14:03:04', '2023-06-02 14:03:04'),
(105, 'can-change-seuil-lv', 'web', '2023-06-02 14:03:22', '2023-06-04 09:47:44'),
(106, 'can-change-libel-quart', 'web', '2023-06-02 14:36:47', '2023-06-02 14:36:47'),
(107, 'can-change-inscrit-quart', 'web', '2023-06-02 14:37:03', '2023-06-02 14:37:03'),
(108, 'can-change-seuil-quart', 'web', '2023-06-02 14:37:37', '2023-06-02 14:37:37');

-- --------------------------------------------------------

--
-- Structure de la table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `proces_verbals`
--

CREATE TABLE `proces_verbals` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `libel` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bureau_vote_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `quartiers`
--

CREATE TABLE `quartiers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `libel` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nbrinscrit` int(11) NOT NULL,
  `objectif` int(11) NOT NULL,
  `seuil` int(11) NOT NULL,
  `section_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `quartiers`
--

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

-- --------------------------------------------------------

--
-- Structure de la table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(2, 'super-admin', 'web', '2023-04-18 16:25:20', '2023-04-24 21:24:47'),
(6, 'Admin', 'web', '2023-04-24 21:32:40', '2023-04-24 21:32:40'),
(7, 'Opérateur de section', 'web', '2023-04-24 21:35:43', '2023-04-24 21:35:43'),
(8, 'Invité', 'web', '2023-04-24 21:40:06', '2023-04-24 21:40:06'),
(9, 'Invité de section', 'web', '2023-04-24 21:44:02', '2023-04-24 21:44:02'),
(10, 'Forest', 'web', '2023-04-28 06:12:39', '2023-04-28 06:12:39'),
(11, 'Sous admin', 'web', '2023-06-04 09:37:21', '2023-06-04 09:37:21');

-- --------------------------------------------------------

--
-- Structure de la table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
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
(82, 2),
(83, 2),
(84, 2),
(85, 2),
(86, 2),
(87, 2),
(88, 2),
(89, 2),
(91, 2),
(92, 2),
(93, 2),
(94, 2),
(100, 2),
(102, 2),
(103, 2),
(104, 2),
(105, 2),
(106, 2),
(107, 2),
(108, 2),
(1, 6),
(2, 6),
(3, 6),
(4, 6),
(5, 6),
(6, 6),
(7, 6),
(8, 6),
(9, 6),
(10, 6),
(11, 6),
(12, 6),
(13, 6),
(14, 6),
(15, 6),
(16, 6),
(17, 6),
(18, 6),
(19, 6),
(20, 6),
(21, 6),
(22, 6),
(23, 6),
(24, 6),
(25, 6),
(26, 6),
(27, 6),
(28, 6),
(29, 6),
(30, 6),
(31, 6),
(32, 6),
(33, 6),
(34, 6),
(35, 6),
(36, 6),
(37, 6),
(38, 6),
(39, 6),
(40, 6),
(41, 6),
(42, 6),
(43, 6),
(44, 6),
(45, 6),
(46, 6),
(47, 6),
(48, 6),
(49, 6),
(50, 6),
(51, 6),
(52, 6),
(53, 6),
(54, 6),
(55, 6),
(56, 6),
(57, 6),
(58, 6),
(59, 6),
(60, 6),
(61, 6),
(62, 6),
(63, 6),
(64, 6),
(65, 6),
(66, 6),
(67, 6),
(76, 6),
(77, 6),
(78, 6),
(79, 6),
(82, 6),
(83, 6),
(84, 6),
(85, 6),
(86, 6),
(87, 6),
(89, 6),
(91, 6),
(92, 6),
(93, 6),
(94, 6),
(100, 6),
(102, 6),
(103, 6),
(104, 6),
(105, 6),
(106, 6),
(107, 6),
(108, 6),
(11, 7),
(13, 7),
(41, 7),
(44, 7),
(82, 7),
(84, 7),
(85, 7),
(86, 7),
(89, 7),
(90, 7),
(92, 7),
(93, 7),
(82, 8),
(83, 8),
(84, 8),
(85, 8),
(86, 8),
(89, 8),
(91, 8),
(93, 8),
(94, 8),
(100, 8),
(56, 9),
(57, 9),
(84, 9),
(90, 9),
(93, 9),
(5, 10),
(89, 10),
(92, 10),
(1, 11),
(3, 11),
(6, 11),
(8, 11),
(11, 11),
(12, 11),
(13, 11),
(14, 11),
(15, 11),
(36, 11),
(39, 11),
(41, 11),
(42, 11),
(43, 11),
(44, 11),
(45, 11),
(46, 11),
(48, 11),
(51, 11),
(52, 11),
(53, 11),
(54, 11),
(55, 11),
(56, 11),
(57, 11),
(58, 11),
(59, 11),
(60, 11),
(61, 11),
(63, 11),
(82, 11),
(83, 11),
(84, 11),
(85, 11),
(86, 11),
(91, 11),
(92, 11),
(93, 11),
(94, 11),
(95, 11),
(96, 11),
(97, 11),
(98, 11),
(99, 11),
(100, 11);

-- --------------------------------------------------------

--
-- Structure de la table `sections`
--

CREATE TABLE `sections` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `libel` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nbrinscrit` int(11) NOT NULL,
  `objectif` int(11) NOT NULL DEFAULT '0',
  `seuil` int(11) NOT NULL DEFAULT '0',
  `commune_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `sections`
--

INSERT INTO `sections` (`id`, `libel`, `nbrinscrit`, `objectif`, `seuil`, `commune_id`, `created_at`, `updated_at`) VALUES
(1, 'ADJAME VILLAGE', 5912, 2517, 1589, 39, NULL, NULL),
(2, 'CROIX BLEU', 16826, 7161, 4528, 39, NULL, NULL),
(3, 'MARIE THERESE', 18358, 8290, 4941, 39, NULL, NULL),
(4, 'PAILLET', 8604, 3663, 2317, 39, NULL, NULL),
(5, 'PEULLIEUVILLE', 27522, 11713, 7399, 39, NULL, NULL),
(6, 'QUARTIER EBRIE NORD EST', 16772, 7138, 4509, 39, NULL, NULL),
(7, 'SAINT MICHEL', 3933, 1674, 1058, 39, NULL, NULL),
(8, 'SODECI MACACI', 19555, 8322, 5266, 39, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('0h8bKFLVAxR1Yf5zICaVXNSRo55UQ6fl9Iq5d8q1', NULL, '172.71.130.183', 'Expanse, a Palo Alto Networks company, searches across the global IPv4 space multiple times per day to identify customers&#39; presences on the Internet. If you would like to be excluded from our scans, please send IP addresses/domains to: scaninfo@paloaltonetworks.com', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiN0YxZ3E2Y0lkVDdacUtCQktTaTZlaVRTcUxoUkJlbXZmclZqUTJqcSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHBzOi8vcmVmZXJhbC50a2ZhYXJ0LmluZm8iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1693891660),
('3hKZa9HvMc68HsA1JxpTtrxRYsAIdAIlitCvcMGU', NULL, '172.71.142.99', 'Cloudflare-SSLDetector', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiRXF1WDdLYVhoUXJ0d0ZOQWt0T2xycGVkNnlGOXN3M09zdU9MMFU2YyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHBzOi8vcmVmZXJhbC50a2ZhYXJ0LmluZm8iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1693592594),
('4ck0ZRg1nQA9KNPaqyrVrTMndW4qN4AwflECDdQe', NULL, '172.70.126.153', 'Expanse, a Palo Alto Networks company, searches across the global IPv4 space multiple times per day to identify customers&#39; presences on the Internet. If you would like to be excluded from our scans, please send IP addresses/domains to: scaninfo@paloaltonetworks.com', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiaVRIUHduemhSMWFxNzRmUVYxUElrZGkxNXlCYThJSkFGdXE4MUVrZyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHBzOi8vcmVmZXJhbC50a2ZhYXJ0LmluZm8iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1694512155),
('4dsqmXJsDe6o4y4TZ6pb2qGYyesOCmLTHlAfzKTK', NULL, '172.71.178.121', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/115.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiZTBRNGhoaW82Q3ZGNThzVllkQlRncFlwMDRrajhJYnA2UXdFVHBJRyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzQ6Imh0dHBzOi8vcmVmZXJhbC50a2ZhYXJ0LmluZm8vbG9naW4iO31zOjM6InVybCI7YToxOntzOjg6ImludGVuZGVkIjtzOjM4OiJodHRwczovL3JlZmVyYWwudGtmYWFydC5pbmZvL2Rhc2hib2FyZCI7fX0=', 1691207850),
('6mjn4OkfTsvHviiszW4FPM0yFrzEC3nk6iQqFfOH', NULL, '162.158.102.80', 'Mozilla/5.0 (iPhone; CPU iPhone OS 14_7_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.1.2 Mobile/15E148 Safari/604.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiaThQQTc5dHV2MWNEc0Y5d1ladkhGZEtSd01KRUw4YzRNWXQ4S0VaUCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHBzOi8vcmVmZXJhbC50a2ZhYXJ0LmluZm8iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1690818229),
('6qKp1PMQzRnZyuC3caYRakRqkaJUqVN8NVF2P0Hy', NULL, '172.71.134.46', 'Expanse, a Palo Alto Networks company, searches across the global IPv4 space multiple times per day to identify customers&#39; presences on the Internet. If you would like to be excluded from our scans, please send IP addresses/domains to: scaninfo@paloaltonetworks.com', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiWlhwWU81T3BCbmZJaGJ4bDRlQVRpZ0d0RVVYWFQ4WnVGSklDSEFLUyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHBzOi8vcmVmZXJhbC50a2ZhYXJ0LmluZm8iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1694585054),
('7F2tHt2FhIUwzl1cxDuKHf2p43sMpuoSLWW3N3S9', NULL, '172.71.154.39', 'Cloudflare-SSLDetector', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoicWd0SnlKWUEwUTdtN2h0TjJmM0pFMmR5WnNEc01RdnV0VlRYUU9lTyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHBzOi8vcmVmZXJhbC50a2ZhYXJ0LmluZm8iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1693107290),
('7p3qDqZ72ChtCXeQpfOLRUR2GvAML4sFC3q6swEg', NULL, '172.71.142.57', 'Cloudflare-SSLDetector', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiNG1YcVBwSnl4RTJQd2NLT01UeWhVbXlTaDIzMnVpdzhNM0xPRW5rbyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHBzOi8vcmVmZXJhbC50a2ZhYXJ0LmluZm8iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1690302033),
('85ihVniaWzNx2taOZRZW7HnG1biG7ohWEwHk0kz1', NULL, '172.71.150.33', 'Cloudflare-SSLDetector', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiODRqQ2trMURITk9GRTdqSkJ2eWdBMW51VXMzNkR2RUJJbWFJc1NIZiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHBzOi8vcmVmZXJhbC50a2ZhYXJ0LmluZm8iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1694299809),
('A3xA146YHtNztmakIs1eKe6otPOFZLMZQzki2d0m', NULL, '108.162.245.6', 'Cloudflare-SSLDetector', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZVBqdTM1SlBRNHdSeTZZYXN6OWc4VTF4MGhXUWpkS3V2NWR0NndyayI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHBzOi8vcmVmZXJhbC50a2ZhYXJ0LmluZm8iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1694532543),
('a8boyYBUUAGUMlO97jAN6vs1DRlSQsYd6EYwhp3q', NULL, '172.71.147.54', 'Cloudflare-SSLDetector', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiQWoxYmJrOUMwanN3OU41Q3BtMThvaEFpaUtyWjVGQVNjaTNHS1NoUCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHBzOi8vcmVmZXJhbC50a2ZhYXJ0LmluZm8iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1692173602),
('AikM272vj9W4qNTa3qT0ekQv6I0aWQb4TKr2rwUQ', NULL, '172.71.146.139', 'Cloudflare-SSLDetector', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiU0p0aVVQamdWSUpDdEZmWkhoNnBReHVKM3dYTjNsQ1lNZGI1b2Y5QSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHBzOi8vcmVmZXJhbC50a2ZhYXJ0LmluZm8iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1690073200),
('aJvgHO3mw5xtNHJD0HxiiCUCEG2vf0GRS8mFp3Cm', NULL, '172.69.23.53', 'Cloudflare-SSLDetector', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZjJTTzRzYmNQU0ZUbXVCT3l6MXhIV2NGY1c5OVpYUmNUTG9wTEw3YiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHBzOi8vcmVmZXJhbC50a2ZhYXJ0LmluZm8iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1693348824),
('aO6KUwQ4g2I7JSUbjnXehLhivP3e8gguuWLljhcN', NULL, '172.71.146.16', 'Cloudflare-SSLDetector', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiWEN3MDZQZjdrWmJDZGdUTERwUHUxREV1b2sxNWd1RU5wZklWNUYyTiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHBzOi8vcmVmZXJhbC50a2ZhYXJ0LmluZm8iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1694532543),
('atnN09l56jjQulNO0JRUbZFQGYF0IHN3CkZJPK9w', NULL, '172.71.150.14', 'Cloudflare-SSLDetector', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiU3ZuN3lZZGROYnhNamRaQlROaHllTHZ3ZnFPOFk3cGx5UG1YNEk4aiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHBzOi8vcmVmZXJhbC50a2ZhYXJ0LmluZm8iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1691929907),
('BB3ymtbl4fxju5WA38CfFjd5DHaC47vGsUoA0hj3', NULL, '172.68.150.34', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.106 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoieGRpQmlZY1BHNW5VNjVrcVgwNmR0YnFndjE2clFOcVZFREFzblZmeSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHBzOi8vcmVmZXJhbC50a2ZhYXJ0LmluZm8iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1693201684),
('bbQfCS0D7FfWRw7t8Hwp2cjs3hj2tNEsyH3ioJOv', NULL, '172.71.154.242', 'Cloudflare-SSLDetector', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoib1h6SjJVZDk3RHUyUWR6UzZpNkQ5T2xRZU9OVTNpM1U1MnUwSDNhYiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHBzOi8vcmVmZXJhbC50a2ZhYXJ0LmluZm8iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1693831511),
('BMFxrywPoQhLtZERrsw8aUb8CIvxdtkdO0uEcb0m', NULL, '172.71.146.82', 'Cloudflare-SSLDetector', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZng0U1BIU3N1MVhyczF2ZU4xYUFrS3JZUFZuNFNGSmdUWEl1anF4byI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHBzOi8vcmVmZXJhbC50a2ZhYXJ0LmluZm8iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1692411329),
('c9dBUdJMtnLFjewm56qzQLs7Bmy7vc7xvm01gow7', NULL, '172.71.131.107', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiSk5LbGRVM1FKT0ZYVTB0OG5Bckhha3dITGZCNXRDZDVZREtlTW1TRyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzQ6Imh0dHBzOi8vcmVmZXJhbC50a2ZhYXJ0LmluZm8vbG9naW4iO31zOjM6InVybCI7YToxOntzOjg6ImludGVuZGVkIjtzOjM4OiJodHRwczovL3JlZmVyYWwudGtmYWFydC5pbmZvL2Rhc2hib2FyZCI7fX0=', 1689911037),
('CLVd4Lu6kCJy6D2aCcgb7q2OJMEpwQ9drs24YglI', NULL, '108.162.245.48', 'Cloudflare-SSLDetector', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiSlJXQWMxR21BNmlFcjRiMUFJM1lFRjFiRUVVbk5rTGxyR2g5ZE01ZCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHBzOi8vcmVmZXJhbC50a2ZhYXJ0LmluZm8iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1690532347),
('cteJjZYz3f765Wp3GTuLr93KLTzboeDx5Du5FOML', NULL, '172.64.236.79', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/115.0.0.0 Safari/537.36 Edg/115.0.1901.188', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoienl3d1ZTMFZDb3ZWUlh1OXRZVjFWb0FDTjhOWk5xb1NnSENnRWhYSCI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czozODoiaHR0cHM6Ly9yZWZlcmFsLnRrZmFhcnQuaW5mby9kYXNoYm9hcmQiO31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czozNDoiaHR0cHM6Ly9yZWZlcmFsLnRrZmFhcnQuaW5mby9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1691942868),
('CZIXLmi4I3h6u9k4CqnI1O3puIoGGrHhcXdw362n', NULL, '141.101.98.112', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/115.0.0.0 Safari/537.36 Edg/115.0.1901.188', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiM1dxdU55WGtsMnFpWEFxNkZJMnRucUxBMFIyWHRtS2xHNGVlR0RtVyI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czozODoiaHR0cHM6Ly9yZWZlcmFsLnRrZmFhcnQuaW5mby9kYXNoYm9hcmQiO31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czozNDoiaHR0cHM6Ly9yZWZlcmFsLnRrZmFhcnQuaW5mby9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1691780191),
('DGJ2wFGBETgtp6jb0GWROdNdfuP3wqE20SySBVkM', 1, '172.68.134.27', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/115.0.0.0 Safari/537.36 Edg/115.0.1901.188', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiakp3dk1FbjlVb3dkYVpncThLUjMzMXFrdElocndRaDFtMWs3WWJvQyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzg6Imh0dHBzOi8vcmVmZXJhbC50a2ZhYXJ0LmluZm8vZGFzaGJvYXJkIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1691889846),
('DSjkghtFS7drqMXq8FjS0n7eHNS5OeKqyJ7WDQaB', 1, '172.70.86.155', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/115.0.0.0 Safari/537.36 Edg/115.0.1901.188', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiRTdrcTY3c21WSzJ2NjFReUhHU1N1Z05KNTNJQ0hrUzZ5bDBlMXpmcCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzg6Imh0dHBzOi8vcmVmZXJhbC50a2ZhYXJ0LmluZm8vZGFzaGJvYXJkIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czozOiJ1cmwiO2E6MDp7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1691661641),
('flFvdviRgMlsAqKY1JyerVZpWGlcloiC6C5M8aZt', NULL, '108.162.245.72', 'Cloudflare-SSLDetector', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiNURGWTNFWFh6UGZpRWdLa2YxQVhydTZPY3lqRkpoT1lId3h3OHcySyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHBzOi8vcmVmZXJhbC50a2ZhYXJ0LmluZm8iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1694065545),
('gbBPkuoFMpf66gkJNhNihDUsWVuTjdPu4mRen53n', NULL, '172.69.22.31', 'Cloudflare-SSLDetector', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZ2RLRnJCd2RXdjgzeGNMTngxY3dWRWlQdmNQelREV0duaThQaUFZSCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHBzOi8vcmVmZXJhbC50a2ZhYXJ0LmluZm8iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1694299810),
('hb3S9Bx0JsWBXZ7K4Jc7sPFC1Oa3lEB0zbtB9f7h', NULL, '172.71.178.51', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/115.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiS2tKSUxldGRwaGVIMFFReDI5UW52eE1Ua29VTm1sZHVtR09YMTZlTSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzQ6Imh0dHBzOi8vcmVmZXJhbC50a2ZhYXJ0LmluZm8vbG9naW4iO31zOjM6InVybCI7YToxOntzOjg6ImludGVuZGVkIjtzOjM4OiJodHRwczovL3JlZmVyYWwudGtmYWFydC5pbmZvL2Rhc2hib2FyZCI7fX0=', 1691425755),
('hJ0IiL5K62av0hb5gBkmIQX9ewx8mkCi0A2wqIhv', NULL, '141.101.98.217', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/115.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiWGJrMlphSFBDclRBZzhSalNWZDBHaVZ6Nk9QRVZyMHhUSlNqdGFkSyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzQ6Imh0dHBzOi8vcmVmZXJhbC50a2ZhYXJ0LmluZm8vbG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1691959447),
('HJrJexYe2eKkaAAFxds4SvL1iwwDy1MmTT48iOk0', NULL, '172.68.150.34', 'Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiVkJlZWV3bTBWcE11RFhBa3JXYzA3VHRvZGxIck5Tbm5VRFU2QndDQSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHBzOi8vcmVmZXJhbC50a2ZhYXJ0LmluZm8iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1693201685),
('igutNMZdk8R3r53bIryxaVHytsfuKEaTbBPIv8hP', NULL, '172.71.151.67', 'Cloudflare-SSLDetector', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiSG90UzZ3djdSOTZPODEzWFF5Q1JNRUYyVXcxT3dBUHlobkpQdW8xbiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHBzOi8vcmVmZXJhbC50a2ZhYXJ0LmluZm8iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1691929908),
('j77tkSURDyKlc3BOrNCqq1ixZeLhLSpSo4Y5i2p5', NULL, '172.71.150.102', 'Cloudflare-SSLDetector', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiRXJnT0JqdE8wREc2MmhvMnRCZE95dW1STlJKdHQ3MGZGcXZMdk9yRCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHBzOi8vcmVmZXJhbC50a2ZhYXJ0LmluZm8iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1691460368),
('JEOngj48ARNaAFo2OtTr26745pblyw4LpUDoqf2y', NULL, '172.71.146.71', 'Cloudflare-SSLDetector', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiMEg3OGR3UzdqU0dnNUNxOHYxNkVqeW44ZE42YjNOUkg2NVM3clR4ZyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHBzOi8vcmVmZXJhbC50a2ZhYXJ0LmluZm8iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1690998900),
('JH9SLllpKjUMsuKirNT86qsHAbeifkAdu4eJODpl', NULL, '198.41.230.186', 'Expanse, a Palo Alto Networks company, searches across the global IPv4 space multiple times per day to identify customers&#39; presences on the Internet. If you would like to be excluded from our scans, please send IP addresses/domains to: scaninfo@paloaltonetworks.com', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiU0I0amMxZVFQRlFWMnFVSXZSbnBOemw3Y3FpTW9LTlh0eUx1S0dROSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHBzOi8vcmVmZXJhbC50a2ZhYXJ0LmluZm8iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1694158150),
('jKymrFQrkJQFXfIJCkyR2J2VYBeMDeIh1HMpOl5g', NULL, '172.71.142.101', 'Cloudflare-SSLDetector', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoid2lmRnIyempjZTZDSUN1Y2ZOaFd6U3hPaEVielR0Sk13UlVIR3pEUCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHBzOi8vcmVmZXJhbC50a2ZhYXJ0LmluZm8iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1690998899),
('Jrm7onZr4Z27hdIEXdrKRenxBmKM9tKhTn20uJXb', NULL, '172.71.122.16', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiNWFjVkY5YUNZeDBhZ2h5ZGdUcUVoZ3BhVkJzNEF2c3R6ek9vV1ZQSCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzQ6Imh0dHBzOi8vcmVmZXJhbC50a2ZhYXJ0LmluZm8vbG9naW4iO31zOjM6InVybCI7YToxOntzOjg6ImludGVuZGVkIjtzOjM4OiJodHRwczovL3JlZmVyYWwudGtmYWFydC5pbmZvL2Rhc2hib2FyZCI7fX0=', 1690163247),
('jsT2M6XYP2i3bwKiOWw09l9FQLhhobkKoF7ptQIz', NULL, '172.71.146.17', 'Cloudflare-SSLDetector', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiNWNiSkU0Q2k4Y3VZa3NpWm9HNUN1cVgyOTBrSzJ3ZkRWOVVyVzlDTSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHBzOi8vcmVmZXJhbC50a2ZhYXJ0LmluZm8iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1693348823),
('JTeQVvPWJtvJOnrmQUyjL70COyRifTA3a4JFLgG1', NULL, '108.162.245.135', 'Cloudflare-SSLDetector', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiaVBMTXNISnpkalRXbXBOM1NraDl0MGdmc1djeWhjVU5QMmF6cTZ2MyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHBzOi8vcmVmZXJhbC50a2ZhYXJ0LmluZm8iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1690302034),
('JvLrSgNSBuRkyCSUm0mFh0Y6xcKbDdB1gfpG0rYi', NULL, '162.158.102.80', 'Mozilla/5.0 (iPhone; CPU iPhone OS 14_7_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.1.2 Mobile/15E148 Safari/604.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZXoyeGJWMVVuY3dvVjFHa21PNGdXaUM3TzFqU2JacTN4NlIwTHdtdiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzQ6Imh0dHBzOi8vcmVmZXJhbC50a2ZhYXJ0LmluZm8vbG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1690818232),
('jzp35Bw9TcBuKRVT3CiSBPsMt59p7ITMeErLks7x', NULL, '108.162.245.199', 'Cloudflare-SSLDetector', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoib1lOQnVvSURsNEFBcVQ5SGl3MVNGa04xM085cGZOOXVHdnNOeHNGdyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHBzOi8vcmVmZXJhbC50a2ZhYXJ0LmluZm8iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1690762337),
('kDnlNEqC5swYAC2BmZJPZuvZmYu8QA7FgMNVmsMR', NULL, '141.101.68.210', 'Expanse, a Palo Alto Networks company, searches across the global IPv4 space multiple times per day to identify customers&#39; presences on the Internet. If you would like to be excluded from our scans, please send IP addresses/domains to: scaninfo@paloaltonetworks.com', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiOUxYSjJFZWFoUTRtb0Jtbmt2b2h3NkNTWmdrVEo2eE1IZ29zUnZodyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHBzOi8vcmVmZXJhbC50a2ZhYXJ0LmluZm8iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1694527554),
('Kl3BLUtnLipT7iOW05dHkXLWsToNGCS51yPXzmzL', NULL, '172.70.90.141', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/115.0.0.0 Safari/537.36 Edg/115.0.1901.188', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiVzZzTEVVR01lcklReUg0REdLeXlEUnRvc1ZiRThjQklKZklGSFNpQyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHBzOi8vcmVmZXJhbC50a2ZhYXJ0LmluZm8iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1691664855),
('l3IwciSR589EsytXZGndWqJ7C0wM6ZWL5NHgIi0U', NULL, '172.70.162.233', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/116.0.0.0 Mobile Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoieFJXUHRsUXRRSFRxZ2FXdnpiZ3NhN3VPNG5TQWxmR045UkcweTd4QiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6OTg6Imh0dHBzOi8vcmVmZXJhbC50a2ZhYXJ0LmluZm8vP2ZiY2xpZD1Jd0FSMF9XNFJjbkY4MzZ4RF85dzMza0x1UjFaQUsySXBVakw2dUFybGI0T0VaaGZRS2lEODJoZkgtWUQwIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1693309835),
('LGfp2SO5IOoUnVUPmgaEPrOTFq5QGYCL7MAeKPru', NULL, '108.162.245.199', 'Cloudflare-SSLDetector', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZ2dxVVc4MGdnR0lodTB6dDlwem11eGFuUms5VVNUdmtDS0FnMGlibiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHBzOi8vcmVmZXJhbC50a2ZhYXJ0LmluZm8iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1693831511),
('mFHYjDDCP5Snum6LRGirzLkQHT54rLF76qI6E1Wn', NULL, '108.162.245.178', 'Cloudflare-SSLDetector', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiMFd5WHFhTlE1RFM4RHZEZ25TbVdJR3U5emxMaWhJb2trdDh0clA4VyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHBzOi8vcmVmZXJhbC50a2ZhYXJ0LmluZm8iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1693107289),
('NPIrpZUhwfhIDUPJVRdyIY8PgjiNLfH46nx4zdTs', NULL, '172.68.150.83', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.106 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiMm1VdnFkMWw1aDI2Q1FOMktJaWFzMDlsQzVvZUl1aDh0SUNyZ0VIeiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDY6Imh0dHBzOi8vcmVmZXJhbC50a2ZhYXJ0LmluZm8vaW5kZXgucGhwP3BhcmFtcz0iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1693201685),
('o39vwmKvbsUxWCU4BhursILPZWNTRrowYeSvF6PJ', NULL, '172.70.210.215', 'facebookexternalhit/1.1 (+http://www.facebook.com/externalhit_uatext.php)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoib0FxbThkYXVQREZlcm9tRXRMckd2QmE5WnhBQ0dlT0ZTWnpmRk5qUCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHBzOi8vcmVmZXJhbC50a2ZhYXJ0LmluZm8iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1693309824),
('oa64kvEWe6hqjxT7GRP9trBXZWUr7iaYe3SdG4JW', NULL, '162.158.179.48', 'Expanse, a Palo Alto Networks company, searches across the global IPv4 space multiple times per day to identify customers&#39; presences on the Internet. If you would like to be excluded from our scans, please send IP addresses/domains to: scaninfo@paloaltonetworks.com', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoib0RYdVUwWm5oRGE5ZEFtS2M5UHFROExqT0RoZFRxdkJnbVRFV09XayI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHBzOi8vcmVmZXJhbC50a2ZhYXJ0LmluZm8iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1694211408),
('Ok0wk2rIjl4KKwnDA8pR68LikTH3l4io40GqItTP', NULL, '172.70.86.147', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/115.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiRU1CMjhDdEE0QW91SzRXeXhReXM1bHNlODd5ZmdQZW1FWm5sUEpDNiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzQ6Imh0dHBzOi8vcmVmZXJhbC50a2ZhYXJ0LmluZm8vbG9naW4iO31zOjM6InVybCI7YToxOntzOjg6ImludGVuZGVkIjtzOjM4OiJodHRwczovL3JlZmVyYWwudGtmYWFydC5pbmZvL2Rhc2hib2FyZCI7fX0=', 1691370153),
('oKZqXRZMgUUuRuahyttREKbZe0bNXDeHKSjZdBAS', NULL, '172.71.158.183', 'Cloudflare-SSLDetector', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoibGJ5OTkxRWNHSlBVT0VwS1dXVTVOc2Mwak1LM1pWWGNWaGhIRE5LdyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHBzOi8vcmVmZXJhbC50a2ZhYXJ0LmluZm8iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1692876259),
('PayCmNf80Wnh5VBoLLWYdMcE6Mbn7ZJOyumV7VY8', NULL, '172.71.150.145', 'Cloudflare-SSLDetector', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiNHh2bXU1a2tTT3FxR1dWdTNCaDNDcnVuVGN4aWFGY0Qxb1NubmxZZCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHBzOi8vcmVmZXJhbC50a2ZhYXJ0LmluZm8iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1691230946),
('prKjhJPuKkb0kqbD7sKcLxRfwIichU3dQ5cH6VQK', NULL, '172.70.85.237', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/115.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoic0t2dDUwbVVmWDF3UGxITTlPU1FaSzY4QnBLV0FiZGtRNjdlQ2dGVSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzQ6Imh0dHBzOi8vcmVmZXJhbC50a2ZhYXJ0LmluZm8vbG9naW4iO31zOjM6InVybCI7YToxOntzOjg6ImludGVuZGVkIjtzOjM4OiJodHRwczovL3JlZmVyYWwudGtmYWFydC5pbmZvL2Rhc2hib2FyZCI7fX0=', 1691360230),
('qiSlWGgLDO25CKmgAxpE1KL2Z4lSiBoizxGTrqMA', NULL, '172.70.86.143', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/115.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiNjJCZ29HSkhUMWVlQ3VER05pRFEyblVXcnEyYzVlTFhwbnJuc3VSTyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzQ6Imh0dHBzOi8vcmVmZXJhbC50a2ZhYXJ0LmluZm8vbG9naW4iO31zOjM6InVybCI7YToxOntzOjg6ImludGVuZGVkIjtzOjM4OiJodHRwczovL3JlZmVyYWwudGtmYWFydC5pbmZvL2Rhc2hib2FyZCI7fX0=', 1691199600),
('r0tBlOmIC8mzsLiGlrPEuhLNvo9bkWRBZ1QKuZXq', NULL, '172.69.134.219', 'Cloudflare-SSLDetector', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoic1dUTXphbUxzVE5iUlRhWVQ1dHBzbHcxUGFRSjZSTWFNaU9mbVA2cyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHBzOi8vcmVmZXJhbC50a2ZhYXJ0LmluZm8iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1692876259),
('RSWNvYaHFmRpLOm9FwfX5SfyuAtshNyDkgL9eAlg', NULL, '162.158.103.146', 'Mozilla/5.0 (iPhone; CPU iPhone OS 14_7_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.1.2 Mobile/15E148 Safari/604.1', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiaExVcEF1WUxXQ080QjJlUTl1QlBJT2hhUzd0QnlRQVQ2REFueTIzaiI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czozODoiaHR0cHM6Ly9yZWZlcmFsLnRrZmFhcnQuaW5mby9kYXNoYm9hcmQiO31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czozODoiaHR0cHM6Ly9yZWZlcmFsLnRrZmFhcnQuaW5mby9kYXNoYm9hcmQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1690818232),
('RVKtOEvoHsABQxt5moF5JmLPEypyOqYu0F7iLMTe', NULL, '172.71.130.167', 'Expanse, a Palo Alto Networks company, searches across the global IPv4 space multiple times per day to identify customers&#39; presences on the Internet. If you would like to be excluded from our scans, please send IP addresses/domains to: scaninfo@paloaltonetworks.com', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoieHVpRzBJNVllemFrenhtYjBmTURuaE5UZVdRa05KMjdQTVpXNHJBeSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHBzOi8vcmVmZXJhbC50a2ZhYXJ0LmluZm8iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1694155079),
('SUaXilLyI663LjxLPuZj4HYnWdpKyvSryVCHkoRi', NULL, '172.71.150.33', 'Cloudflare-SSLDetector', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiOGNlSWlHeW10UkRGaXo4MTN0MzJhNHBhN0RKWlYxVjZJRVprZGRFOCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHBzOi8vcmVmZXJhbC50a2ZhYXJ0LmluZm8iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1692173603),
('TBQ3AWBeoygUd1TkbayKuitMvAPxMKLhdCOmWuqV', NULL, '172.71.142.92', 'Cloudflare-SSLDetector', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiVVEyMWg4N1V1WkZuZUN3N1hSOWlUUTNpTmRJelFUaGwxeGhWVXNlZSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHBzOi8vcmVmZXJhbC50a2ZhYXJ0LmluZm8iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1691460369),
('tMZt54NpRaJ5Aq2nymGAXElDRDs9auWUqcdTi6QY', NULL, '172.71.146.51', 'Cloudflare-SSLDetector', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiWm13a24zR3pLN1lZU0YyVmhZMjNwS0xHR1FjYm5kN2NrbGRRMTVmWSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHBzOi8vcmVmZXJhbC50a2ZhYXJ0LmluZm8iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1691695390),
('TtM9Ld3IJy7gOByHnVitmvxIFd6FT6HK37851mzM', NULL, '172.71.150.79', 'Cloudflare-SSLDetector', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiRHZGcHlXMDNPMEJuZlcwQjNPQnZmZHllOXhHYmpaRkl1QzZDUlZCNiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHBzOi8vcmVmZXJhbC50a2ZhYXJ0LmluZm8iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1691230947),
('VPZ7gHytxCfLxq6rmNb2Ibal2T0O5Rl6RzUKA7Y9', NULL, '172.71.234.88', 'Expanse, a Palo Alto Networks company, searches across the global IPv4 space multiple times per day to identify customers&#39; presences on the Internet. If you would like to be excluded from our scans, please send IP addresses/domains to: scaninfo@paloaltonetworks.com', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiYTVWMFIwUXhUSTg5R2VLTmNrRFdIdERDS1lTdUZLWXUxZlhXTU9DRCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHBzOi8vcmVmZXJhbC50a2ZhYXJ0LmluZm8iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1693899417),
('vWE3VPiRCtPJuenNNwUrOJNxucjDGWBcS2w7A7mR', NULL, '172.71.151.67', 'Cloudflare-SSLDetector', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiVjdqc0g2M3NVNVkzdGNJQVE5ZUVBR3N3YllYY2ZYV1g2cUxMUEt3bCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHBzOi8vcmVmZXJhbC50a2ZhYXJ0LmluZm8iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1692644383),
('vWjbeRn2vZg4srEs1ZAcCOzMwLr26XpdYBKxqy5k', NULL, '172.71.147.50', 'Cloudflare-SSLDetector', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiamg4Wkd0M3FaYTlqdXFGQzJKOG4xR2xXMlJFa0lUNGZNSlJrckhLcyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHBzOi8vcmVmZXJhbC50a2ZhYXJ0LmluZm8iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1691695389),
('WC8TXqvDKFInvuRWZRzrFV6v7PXISu8nrgvkitG4', NULL, '108.162.245.199', 'Cloudflare-SSLDetector', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiT3Z0dkY3VWxjT0R2V3JpNktJaUhoSHdUQ21JVkRIbktHbkFyRWswQSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHBzOi8vcmVmZXJhbC50a2ZhYXJ0LmluZm8iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1693592594),
('whQVNBVb3SRp9TUXpa6ZNcZKmdeydaWViWnD63Ix', NULL, '172.71.151.127', 'Cloudflare-SSLDetector', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoic1BOZk5Cd1ViY3VZeGJINVRtUUpHYVFqa1Q0ZGtZSjFGZW9XbFMxYiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHBzOi8vcmVmZXJhbC50a2ZhYXJ0LmluZm8iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1692644383),
('wy5b0l9s4h1QjZvHnFL23Diz82MW2CvVyKL7cNFf', NULL, '172.71.150.179', 'Cloudflare-SSLDetector', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiSGpleUViTEMyR0NqWGN3aGJsU2Vla3ZUcjRLRVBWQWZvODN0aUs1SSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHBzOi8vcmVmZXJhbC50a2ZhYXJ0LmluZm8iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1694065545),
('XhhMrBi1yEVNrPMKQ3q0hbsxXp2xNzcmcyJHxs1r', NULL, '172.71.146.197', 'Cloudflare-SSLDetector', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiVGpRaFQxcnJlOHdhdHVzdkh4ZExJall6RHlzV3lDckw2NHdLUVdMQSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHBzOi8vcmVmZXJhbC50a2ZhYXJ0LmluZm8iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1690532348),
('XIjwPjH8EQVfizawOpQB6vwJMLuXuRQqjVRqoxHR', NULL, '108.162.245.178', 'Cloudflare-SSLDetector', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiOHdaTFFCRGNrM2owaG5UOGxqRFNUMXhQb2tMVnJZbGM3MUs0eGtlWCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHBzOi8vcmVmZXJhbC50a2ZhYXJ0LmluZm8iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1690762337),
('XkmsInmayOdhWmgorDUDnRpUTBwV5xKBCLkMMLeg', NULL, '172.71.151.15', 'Cloudflare-SSLDetector', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiM0lKM0xxeHFZaHlnWkV1NXpsYXFaZHJsNXNYa0JwTTNTQm82QjVHdiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHBzOi8vcmVmZXJhbC50a2ZhYXJ0LmluZm8iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1692411328),
('YxAYYy6fQoRkVNIT17FnLNMLi9xrCHqjlrwNoWIG', NULL, '172.71.178.188', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/115.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoidkJBOEN1QkVUUWR5TTNaaldFbWE0Z1haMTF0Sk51YU9RZEZIWExJSiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzQ6Imh0dHBzOi8vcmVmZXJhbC50a2ZhYXJ0LmluZm8vbG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1691805375),
('Z4pv88R3y199aD5udlW2NVADU6WzQtqICeaSvXvd', NULL, '172.71.122.179', 'Expanse, a Palo Alto Networks company, searches across the global IPv4 space multiple times per day to identify customers&#39; presences on the Internet. If you would like to be excluded from our scans, please send IP addresses/domains to: scaninfo@paloaltonetworks.com', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiNHVaRDBUZ1YzYUtQV1NTNjNxN1hMSVB5bjYxMHFhMFg2Z2hLYk1xbSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHBzOi8vcmVmZXJhbC50a2ZhYXJ0LmluZm8iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1694236999),
('zdWrKTW9F8bkoaMBHpTgix3o5O1E2fZ6eKVlMouR', NULL, '172.71.11.6', 'Expanse, a Palo Alto Networks company, searches across the global IPv4 space multiple times per day to identify customers&#39; presences on the Internet. If you would like to be excluded from our scans, please send IP addresses/domains to: scaninfo@paloaltonetworks.com', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiTEk3R21DMWJmVURGV1VMRWxkaEFmQzIzVFd0WkhvU1FMQVhmOThoSCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHBzOi8vcmVmZXJhbC50a2ZhYXJ0LmluZm8iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1694527379),
('zHWPRDViv8CMnjFYXIF64U9QeB8HNN6Uu5ICnJ6m', NULL, '172.70.131.116', 'Expanse, a Palo Alto Networks company, searches across the global IPv4 space multiple times per day to identify customers&#39; presences on the Internet. If you would like to be excluded from our scans, please send IP addresses/domains to: scaninfo@paloaltonetworks.com', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiejBybDc1SGk4eHNoWXRoM3BlbnBaZFYwbG1nVzNsNHp1dGZnY2kzVSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHBzOi8vcmVmZXJhbC50a2ZhYXJ0LmluZm8iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1693983372),
('ZUyp9oV6jJGiuvr5QmtSpNbEYDcvUm1i1hAeRnmU', NULL, '172.71.242.118', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/115.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiVHRRNkJsSFNrZ3djakpGU2daU1Z1MGVFVnV2M0ozZzZoaUFtTkhxdCI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo0NDoiaHR0cHM6Ly9yZWZlcmFsLnRrZmFhcnQuaW5mby9yZWNlbnMvcGFycmFpbnMiO31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czozNDoiaHR0cHM6Ly9yZWZlcmFsLnRrZmFhcnQuaW5mby9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1691855226),
('zwBqZq0k1QpzopPGDJYshdUVWPy2NX5LlnkGu6Lr', NULL, '172.71.150.91', 'Cloudflare-SSLDetector', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiTzA1RTFGUnhTcFBXZDlhTFh1WUtiVmtxZWMxaWNUZ0Z3M3lXQzltSiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHBzOi8vcmVmZXJhbC50a2ZhYXJ0LmluZm8iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1690073200);

-- --------------------------------------------------------

--
-- Structure de la table `sous_sections`
--

CREATE TABLE `sous_sections` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `libel` varchar(255) NOT NULL,
  `objectif` bigint(20) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `sup_lieu_de_votes`
--

CREATE TABLE `sup_lieu_de_votes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telephone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lieu_vote_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_naiss` date NOT NULL,
  `super_admin` smallint(6) NOT NULL DEFAULT '0',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `commune_id` bigint(20) UNSIGNED DEFAULT NULL,
  `departement_id` bigint(20) UNSIGNED DEFAULT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `name`, `prenom`, `email`, `date_naiss`, `super_admin`, `email_verified_at`, `password`, `remember_token`, `commune_id`, `departement_id`, `photo`, `created_at`, `updated_at`) VALUES
(1, 'Proprio', 'Tkfaart', 'admin@tkfaart.net', '2023-04-18', 1, NULL, '$2y$10$896NodTfaiJSqnaAU45MD.tcJWQ/1naVMqFIyN0Ke8Wy/eu0Fc7CO', 'aJ8T1LNTmE1qjasMgSTZaiPpivTLyNidfTQjed9p6WCnSKPDnUNaZKGmrkVx', NULL, NULL, NULL, '2023-04-18 16:36:05', '2023-05-08 14:10:56'),
(2, 'Super', 'Admin', 'example@electio.ci', '2004-10-11', 0, NULL, '$2y$10$xg1z32oB1iuXpYZ02DUBZeA2eLkOc9gDjIBiDC46Dfc46MQ2pK3u.', NULL, NULL, NULL, NULL, '2023-04-25 08:04:02', '2023-04-25 08:04:02'),
(9, 'Opérateur', 'ADJAME VILLAGE', 'operateur-adjame-village@electio.ci', '2023-04-26', 0, NULL, '$2y$10$./qoAt0kW5P1QMXoN60HseAKDHg1Bi1.LvE9xT7KZrABKNjaolfRq', NULL, NULL, NULL, 'public/RFdz2dxC0GIVTn8tmjDJ2eLptLX1IFpnZKSwSJ8L.png', '2023-04-26 15:58:37', '2023-04-26 15:58:37'),
(10, 'Opérateur', 'CROIX BLEU', 'operateur-croix-bleu@electio.ci', '2023-04-26', 0, NULL, '$2y$10$.z2m.X5NIKvY7Kq8l99HtedGrQMLA8mUKlDQVwXlHnwJKzdZnZBzy', NULL, NULL, NULL, 'public/ZqiVEVzciA4fzdvbURJ9CSkZJd7x7Fk5MgW5u4Sk.png', '2023-04-26 16:06:13', '2023-04-26 16:06:13'),
(11, 'Opérateur', 'MARIE THERESE', 'operateur-marie-therese@electio.ci', '2023-04-26', 0, NULL, '$2y$10$5GcWnXWJR0lB5osSb3EKXOnNkqFZB8PhSpQUkXhZ731tpMVdepJE6', NULL, NULL, NULL, 'public/EyEskfw03cuN6dOzbg7Ys9x1bZLni82zQscbG8Y5.png', '2023-04-26 16:08:57', '2023-04-26 16:08:57'),
(12, 'Opérateur', 'PAILLET', 'operateur-paillet@electio.ci', '2023-04-26', 0, NULL, '$2y$10$0yGrW2.QSdKVEoszhMR3Z.BBgJUmMcecJGmeb0Nif4ZS7mUZzUsEy', NULL, NULL, NULL, 'public/AZCMRl0X1BDf91FkcEyCHEWmmp5rFFaxsSQTKohR.png', '2023-04-26 16:13:07', '2023-04-26 16:13:07'),
(13, 'Opérateur', 'PEULLIEUVILLE', 'operateur-peullieuville@electio.ci', '2023-04-26', 0, NULL, '$2y$10$PGZdx9rN0gAUYbSNTpemr.PP.mKsrWdyiP9S01kR74v6vOQilHS2m', NULL, NULL, NULL, 'public/XL7EKvhKp34SeIJKzEVXVWUdBLthMiUjOnLDD3lw.png', '2023-04-26 16:16:01', '2023-04-26 16:16:01'),
(14, 'Opérateur', 'QUARTIER EBRIE NORD EST', 'operateur-quartier-ebrie-nord-est@electio.ci', '2023-04-26', 0, NULL, '$2y$10$yYcteBHPjFcENZujMBB9sOad9hii81cEtDuRlMBzWCVCbwqu40OS6', NULL, NULL, NULL, 'public/ZA3rlP9gaA7l8agqwcW1PXEvY3k6UH89CS1ApzwP.png', '2023-04-26 16:18:36', '2023-04-26 16:18:36'),
(15, 'Opérateur', 'SAINT MICHEL', 'operateur-saint-michel@electio.ci', '2023-04-26', 0, NULL, '$2y$10$yX77kAMkDr2W1DHakcFezecVvTnr0j7AsV3h6VzPwQL/lYiWSUKAG', NULL, NULL, NULL, 'public/VZbAnyXW3OAnMbpX1mh2VCD8WZd8NyauHbCa8Y6k.png', '2023-04-26 16:21:15', '2023-04-26 16:21:15'),
(16, 'Opérateur', 'SODECI MACACI', 'operateur-sodeci-macaci@electio.ci', '2023-04-26', 0, NULL, '$2y$10$tNR5Zs91yB5gk63NskfizuON2apTsM0QHU/KX.a0X72xzB23jNK22', NULL, NULL, NULL, 'public/1FgpkZZEsXCogOPyobK3rSboYHZ6Y1HADkNjWhJa.png', '2023-04-26 16:24:27', '2023-04-26 16:24:27'),
(17, 'GB Initiative', 'GB', 'gb-initiative@electio.ci', '2023-04-26', 0, NULL, '$2y$10$hntWHyUGgpgEj8J0.j4BhO9IFN8NlQQLHqzgRaWNkDE0GYpJjh/am', NULL, NULL, NULL, 'public/qtQHcxG5GUx2CqqcVGPO5ZLBCRV1O1FwfpOqCwLh.jpg', '2023-04-26 16:46:11', '2023-04-26 19:50:39'),
(18, 'Sous-Admin', 'SAdmin', 'sous-admin@electio.ci', '2000-06-04', 0, NULL, '$2y$10$6ezqNnKdgxJawtJ92.FWQeVUkDyTJhLG4KnrCfqHCIP0lRi1XbieW', NULL, NULL, NULL, 'public/7VNhdg6rX9vU18b3e8diSi3RYkCzTjhLCndj1ai0.jpg', '2023-06-04 19:30:41', '2023-06-04 19:30:41');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `agent_de_sections`
--
ALTER TABLE `agent_de_sections`
  ADD PRIMARY KEY (`id`),
  ADD KEY `agent_de_sections_section_id_foreign` (`section_id`);

--
-- Index pour la table `agent_du_bureau_votes`
--
ALTER TABLE `agent_du_bureau_votes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `agent_du_bureau_votes_bureau_vote_id_foreign` (`bureau_vote_id`);

--
-- Index pour la table `agent_terrains`
--
ALTER TABLE `agent_terrains`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `agent_terrains_telephone_unique` (`telephone`),
  ADD UNIQUE KEY `agent_terrains_code_unique` (`code`),
  ADD KEY `agent_terrains_lieu_vote_id_foreign` (`lieu_vote_id`);

--
-- Index pour la table `bureau_votes`
--
ALTER TABLE `bureau_votes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bureau_votes_lieu_vote_id_foreign` (`lieu_vote_id`);

--
-- Index pour la table `candidats`
--
ALTER TABLE `candidats`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `communes`
--
ALTER TABLE `communes`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `commune_departement`
--
ALTER TABLE `commune_departement`
  ADD KEY `commune_departement_commune_id_foreign` (`commune_id`),
  ADD KEY `commune_departement_departement_id_foreign` (`departement_id`);

--
-- Index pour la table `commune_lieu_vote`
--
ALTER TABLE `commune_lieu_vote`
  ADD KEY `commune_lieu_vote_lieu_vote_id_foreign` (`lieu_vote_id`),
  ADD KEY `commune_lieu_vote_commune_id_foreign` (`commune_id`);

--
-- Index pour la table `departements`
--
ALTER TABLE `departements`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Index pour la table `lieu_votes`
--
ALTER TABLE `lieu_votes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `lieu_votes_code_unique` (`code`),
  ADD KEY `lieu_votes_quartier_id_foreign` (`quartier_id`);

--
-- Index pour la table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Index pour la table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Index pour la table `parrains`
--
ALTER TABLE `parrains`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Index pour la table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Index pour la table `proces_verbals`
--
ALTER TABLE `proces_verbals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `proces_verbals_bureau_vote_id_foreign` (`bureau_vote_id`);

--
-- Index pour la table `quartiers`
--
ALTER TABLE `quartiers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `quartiers_section_id_foreign` (`section_id`);

--
-- Index pour la table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Index pour la table `sections`
--
ALTER TABLE `sections`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sections_commune_id_foreign` (`commune_id`);

--
-- Index pour la table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Index pour la table `sous_sections`
--
ALTER TABLE `sous_sections`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `sup_lieu_de_votes`
--
ALTER TABLE `sup_lieu_de_votes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sup_lieu_de_votes_lieu_vote_id_foreign` (`lieu_vote_id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_commune_id_foreign` (`commune_id`),
  ADD KEY `users_departement_id_foreign` (`departement_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `agent_de_sections`
--
ALTER TABLE `agent_de_sections`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `agent_du_bureau_votes`
--
ALTER TABLE `agent_du_bureau_votes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `agent_terrains`
--
ALTER TABLE `agent_terrains`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `bureau_votes`
--
ALTER TABLE `bureau_votes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=285;

--
-- AUTO_INCREMENT pour la table `candidats`
--
ALTER TABLE `candidats`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT pour la table `communes`
--
ALTER TABLE `communes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT pour la table `departements`
--
ALTER TABLE `departements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `lieu_votes`
--
ALTER TABLE `lieu_votes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT pour la table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `parrains`
--
ALTER TABLE `parrains`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=109;

--
-- AUTO_INCREMENT pour la table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `proces_verbals`
--
ALTER TABLE `proces_verbals`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `quartiers`
--
ALTER TABLE `quartiers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT pour la table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `sections`
--
ALTER TABLE `sections`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `sous_sections`
--
ALTER TABLE `sous_sections`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `sup_lieu_de_votes`
--
ALTER TABLE `sup_lieu_de_votes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `agent_de_sections`
--
ALTER TABLE `agent_de_sections`
  ADD CONSTRAINT `agent_de_sections_section_id_foreign` FOREIGN KEY (`section_id`) REFERENCES `sections` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `agent_du_bureau_votes`
--
ALTER TABLE `agent_du_bureau_votes`
  ADD CONSTRAINT `agent_du_bureau_votes_bureau_vote_id_foreign` FOREIGN KEY (`bureau_vote_id`) REFERENCES `bureau_votes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `agent_terrains`
--
ALTER TABLE `agent_terrains`
  ADD CONSTRAINT `agent_terrains_lieu_vote_id_foreign` FOREIGN KEY (`lieu_vote_id`) REFERENCES `lieu_votes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `bureau_votes`
--
ALTER TABLE `bureau_votes`
  ADD CONSTRAINT `bureau_votes_lieu_vote_id_foreign` FOREIGN KEY (`lieu_vote_id`) REFERENCES `lieu_votes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `commune_departement`
--
ALTER TABLE `commune_departement`
  ADD CONSTRAINT `commune_departement_commune_id_foreign` FOREIGN KEY (`commune_id`) REFERENCES `communes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `commune_departement_departement_id_foreign` FOREIGN KEY (`departement_id`) REFERENCES `departements` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `commune_lieu_vote`
--
ALTER TABLE `commune_lieu_vote`
  ADD CONSTRAINT `commune_lieu_vote_commune_id_foreign` FOREIGN KEY (`commune_id`) REFERENCES `communes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `commune_lieu_vote_lieu_vote_id_foreign` FOREIGN KEY (`lieu_vote_id`) REFERENCES `lieu_votes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `lieu_votes`
--
ALTER TABLE `lieu_votes`
  ADD CONSTRAINT `lieu_votes_quartier_id_foreign` FOREIGN KEY (`quartier_id`) REFERENCES `quartiers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `proces_verbals`
--
ALTER TABLE `proces_verbals`
  ADD CONSTRAINT `proces_verbals_bureau_vote_id_foreign` FOREIGN KEY (`bureau_vote_id`) REFERENCES `bureau_votes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `quartiers`
--
ALTER TABLE `quartiers`
  ADD CONSTRAINT `quartiers_section_id_foreign` FOREIGN KEY (`section_id`) REFERENCES `sections` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `sections`
--
ALTER TABLE `sections`
  ADD CONSTRAINT `sections_commune_id_foreign` FOREIGN KEY (`commune_id`) REFERENCES `communes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `sup_lieu_de_votes`
--
ALTER TABLE `sup_lieu_de_votes`
  ADD CONSTRAINT `sup_lieu_de_votes_lieu_vote_id_foreign` FOREIGN KEY (`lieu_vote_id`) REFERENCES `lieu_votes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_commune_id_foreign` FOREIGN KEY (`commune_id`) REFERENCES `communes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `users_departement_id_foreign` FOREIGN KEY (`departement_id`) REFERENCES `departements` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
