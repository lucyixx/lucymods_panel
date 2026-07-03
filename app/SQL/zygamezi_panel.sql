-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Máy chủ: localhost:3306
-- Thời gian đã tạo: Th9 20, 2025 lúc 01:58 AM
-- Phiên bản máy phục vụ: 10.6.23-MariaDB-log
-- Phiên bản PHP: 8.4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `zygamezi_panel`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `games`
--

CREATE TABLE `games` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `package` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Đang đổ dữ liệu cho bảng `games`
--

INSERT INTO `games` (`id`, `name`, `package`) VALUES
(1, 'Liên Quân Mobile', 'com.garena.game.kgvn'),
(6, 'com.activision.callofduty.shooter', 'com.activision.callofduty.shooter'),
(7, 'com.pixel.gun3d', 'com.pixel.gun3d'),
(8, 'com.garena.game.codm', 'com.garena.game.codm'),
(9, 'com.tencent.ngame.chty', 'com.tencent.ngame.chty'),
(10, 'com.dts.freefireth', 'com.dts.freefireth'),
(11, 'com.dts.freefiremax', 'com.dts.freefiremax'),
(12, 'com.GlobalSoFunny.Sausage', 'com.GlobalSoFunny.Sausage'),
(13, 'com.zoneplay.funnyfighters', 'com.zoneplay.funnyfighters'),
(14, 'com.ngame.allstar.eu', 'com.ngame.allstar.eu'),
(15, 'com.levelinfinite.sgameGlobal', 'com.levelinfinite.sgameGlobal'),
(16, 'com.Gaggle.fun.GooseGooseDuck', 'com.Gaggle.fun.GooseGooseDuck'),
(17, 'com.hhgame.mlbbvn', 'com.hhgame.mlbbvn'),
(18, 'com.mobile.legends', 'com.mobile.legends'),
(19, 'com.vng.codmvn', 'com.vng.codmvn'),
(20, 'com.vtc.tapkich', 'com.vtc.tapkich'),
(21, 'com.vng.sea.metalslug', 'com.vng.sea.metalslug'),
(22, 'com.garena.game.kgid', 'com.garena.game.kgid'),
(23, 'com.matr1x.fire', 'com.matr1x.fire'),
(24, 'com.garena.game.kgth', 'com.garena.game.kgth'),
(25, 'com.vng.metalslug.rambolun', 'com.vng.metalslug.rambolun'),
(26, 'com.aslegends', 'com.aslegends'),
(27, 'com.garena.game.kgtw', 'com.garena.game.kgtw'),
(28, 'com.riotgames.league.wildrift', 'com.riotgames.league.wildrift'),
(29, 'com.riotgames.league.wildriftvn', 'com.riotgames.league.wildriftvn'),
(30, 'com.gbits.funnyfighter.android.overseas', 'com.gbits.funnyfighter.android.overseas'),
(31, 'com.tencent.tmgp.sgame', 'com.tencent.tmgp.sgame'),
(32, 'com.vtcmobilejsc.phuckichvtc', 'com.vtcmobilejsc.phuckichvtc'),
(33, 'com.levelinfinite.sgameGlobal.midaspay', 'com.levelinfinite.sgameGlobal.midaspay'),
(34, 'com.vng.playtogether', 'com.vng.playtogether'),
(35, 'com.haegin.playtogether', 'com.haegin.playtogether'),
(36, 'com.netease.newspikevn', 'com.netease.newspikevn'),
(37, 'com.netease.newspike', 'com.netease.newspike'),
(38, 'com.vng.pubgmobile', 'com.vng.pubgmobile'),
(39, 'com.garena.game.kgvntest', 'com.garena.game.kgvntest'),
(40, 'com.garena.game.kgvo', 'com.garena.game.kgvo'),
(41, 'com.tencent.stc.cfl', 'com.tencent.stc.cfl'),
(42, 'com.clashoftitansandroid.india', 'com.clashoftitansandroid.india'),
(43, 'com.innersloth.spacemafia', 'com.innersloth.spacemafia');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `history`
--

CREATE TABLE `history` (
  `id_history` int(11) NOT NULL,
  `keys_id` varchar(33) DEFAULT NULL,
  `user_do` varchar(33) DEFAULT NULL,
  `info` mediumtext NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Đang đổ dữ liệu cho bảng `history`
--

INSERT INTO `history` (`id_history`, `keys_id`, `user_do`, `info`, `created_at`, `updated_at`) VALUES
(15485, '16068', 'tisqnuyen', 'ALL|6FGGQ|1|1', '2025-09-07 10:15:17', '2025-09-07 10:15:17'),
(15486, '16069', 'tisqnuyen', 'ALL|6FGGQ|1|1', '2025-09-07 10:20:58', '2025-09-07 10:20:58'),
(15487, '16074', 'tisnquyen', 'com.dts.freefireth|vJ7oo|30|1', '2025-09-07 14:18:03', '2025-09-07 14:18:03'),
(15488, '16077', 'tisqnuyen', 'ALL|BXQVL|1|1', '2025-09-07 16:15:24', '2025-09-07 16:15:24'),
(15489, '16078', 'tisnquyen', 'com.garena.game.kgvn|sZldj|30|1', '2025-09-07 17:20:23', '2025-09-07 17:20:23'),
(15490, '16082', 'tisqnuyen', 'ALL|7X1V9|1|1', '2025-09-08 16:07:37', '2025-09-08 16:07:37'),
(15491, '16083', 'tisqnuyen', 'ALL|68YPU|1|1', '2025-09-08 21:47:58', '2025-09-08 21:47:58'),
(15492, '16084', 'tisqnuyen', 'ALL|94SCS|1|1', '2025-09-09 00:47:40', '2025-09-09 00:47:40'),
(15493, '16085', 'tisqnuyen', 'ALL|5BDC2|1|1', '2025-09-09 00:50:42', '2025-09-09 00:50:42'),
(15494, '16086', 'tisqnuyen', 'ALL|4TNCX|1|1', '2025-09-09 04:46:45', '2025-09-09 04:46:45'),
(15495, '16087', 'tisqnuyen', 'ALL|4TNCX|1|1', '2025-09-09 04:53:19', '2025-09-09 04:53:19'),
(15496, '16006', 'tisnquyen', 'com.dts.freefireth|VAETY|60|1', '2025-09-09 04:53:19', '2025-09-09 04:53:19'),
(15497, '16090', 'tisnquyen', 'com.dts.freefireth|Zmc5h|30|1', '2025-09-09 15:45:16', '2025-09-09 15:45:16'),
(15498, '16095', 'freekey', 'ALL|DV1BF|1|1', '2025-09-09 20:19:29', '2025-09-09 20:19:29'),
(15499, '16097', 'tisnquyen', 'com.dts.freefireth|r6E9F|30|1', '2025-09-10 03:22:05', '2025-09-10 03:22:05'),
(15500, '16098', 'tisnquyen', 'com.dts.freefireth|1xNYA|1|1', '2025-09-10 10:44:27', '2025-09-10 10:44:27'),
(15501, '16099', 'tisnquyen', 'com.dts.freefireth|gkKm6|30|1', '2025-09-10 13:59:32', '2025-09-10 13:59:32'),
(15502, '16100', 'tisnquyen', 'com.dts.freefireth|lJ7t6|30|1', '2025-09-10 14:49:59', '2025-09-10 14:49:59'),
(15503, '16101', 'tisnquyen', 'com.dts.freefireth|f6lzR|30|1', '2025-09-10 16:05:27', '2025-09-10 16:05:27'),
(15504, '16102', 'tisnquyen', 'com.dts.freefireth|zBMQg|30|1', '2025-09-10 16:13:38', '2025-09-10 16:13:38'),
(15505, '16103', 'tisnquyen', 'com.garena.game.kgvn|LTDFF|30|1', '2025-09-10 16:26:10', '2025-09-10 16:26:10'),
(15506, '16105', 'tisnquyen', 'com.dts.freefireth|OlnTK|1|1', '2025-09-12 06:50:58', '2025-09-12 06:50:58'),
(15507, '16106', 'tisnquyen', 'com.garena.game.kgvn|zxqxs|30|1', '2025-09-13 13:24:56', '2025-09-13 13:24:56'),
(15508, '16107', 'tisnquyen', 'ALL|WqQss|30|3', '2025-09-13 13:33:01', '2025-09-13 13:33:01'),
(15509, '16108', 'tisnquyen', 'com.dts.freefireth|uRXdB|30|1', '2025-09-13 14:31:34', '2025-09-13 14:31:34'),
(15510, '16109', 'tisnquyen', 'com.garena.game.kgvn|P8Xov|30|1', '2025-09-14 04:04:10', '2025-09-14 04:04:10'),
(15511, '16110', 'tisnquyen', 'com.dts.freefireth|l1MAD|30|1', '2025-09-14 06:04:26', '2025-09-14 06:04:26'),
(15512, '16111', 'tisnquyen', 'com.garena.game.kgvn|V1gEp|7|1', '2025-09-14 09:16:42', '2025-09-14 09:16:42'),
(15513, '16112', 'tisnquyen', 'com.garena.game.kgtw|bxkfg|30|1', '2025-09-15 00:42:44', '2025-09-15 00:42:44'),
(15514, '16113', 'tisnquyen', 'com.garena.game.kgvn|QNX4M|30|1', '2025-09-15 09:02:16', '2025-09-15 09:02:16'),
(15515, '16114', 'tisnquyen', 'com.garena.game.kgvn|wcIB4|30|1', '2025-09-15 15:04:45', '2025-09-15 15:04:45'),
(15516, '16115', 'tisnquyen', 'com.dts.freefireth|lnfI0|30|1', '2025-09-15 15:11:06', '2025-09-15 15:11:06'),
(15517, '16116', 'tisnquyen', 'com.riotgames.league.wildriftvn|DK4Cd|30|1', '2025-09-15 15:17:14', '2025-09-15 15:17:14'),
(15518, '16117', 'tisnquyen', 'com.garena.game.kgvn|ZAdkS|30|1', '2025-09-16 01:53:33', '2025-09-16 01:53:33'),
(15519, '16118', 'tisnquyen', 'com.dts.freefireth|hEkqd|30|1', '2025-09-16 04:31:38', '2025-09-16 04:31:38'),
(15520, '16119', 'tisnquyen', 'com.dts.freefireth|7nsP1|30|1', '2025-09-16 12:20:50', '2025-09-16 12:20:50'),
(15521, '16120', 'tisnquyen', 'com.dts.freefireth|vSFjk|30|1', '2025-09-16 15:46:57', '2025-09-16 15:46:57'),
(15522, '16121', 'tisnquyen', 'com.dts.freefiremax|GKp1H|60|1', '2025-09-17 03:00:06', '2025-09-17 03:00:06'),
(15523, '16122', 'tisnquyen', 'com.dts.freefiremax|YVQqE|30|1', '2025-09-17 04:48:38', '2025-09-17 04:48:38'),
(15524, '16123', 'tisnquyen', 'com.dts.freefireth|jdjNP|30|1', '2025-09-17 10:36:01', '2025-09-17 10:36:01'),
(15525, '16124', 'tisnquyen', 'com.garena.game.kgvn|xUX5S|1|1', '2025-09-18 00:47:13', '2025-09-18 00:47:13'),
(15526, '16125', 'tisnquyen', 'com.dts.freefireth|K25Yn|1|1', '2025-09-18 08:21:25', '2025-09-18 08:21:25'),
(15527, '16126', 'tisnquyen', 'com.tencent.stc.cfl|pO8K5|1|1', '2025-09-18 10:51:50', '2025-09-18 10:51:50'),
(15528, '16127', 'tisnquyen', 'com.garena.game.kgvn|oY4aq|30|1', '2025-09-18 11:04:12', '2025-09-18 11:04:12'),
(15529, '16128', 'tisnquyen', 'com.garena.game.kgvn|5fK7G|30|1', '2025-09-19 01:25:20', '2025-09-19 01:25:20'),
(15530, '16129', 'tisnquyen', 'com.garena.game.kgvntest|j96ML|1|1', '2025-09-19 03:59:46', '2025-09-19 03:59:46'),
(15531, '16130', 'tisnquyen', 'com.dts.freefireth|RpnOj|30|1', '2025-09-19 11:04:08', '2025-09-19 11:04:08'),
(15532, '16131', 'tisnquyen', 'com.netease.newspikevn|ZA01y|1|1', '2025-09-19 15:33:00', '2025-09-19 15:33:00'),
(15533, '16132', 'tisnquyen', 'com.dts.freefireth|E2ey6|30|1', '2025-09-19 15:49:20', '2025-09-19 15:49:20');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `keys_code`
--

CREATE TABLE `keys_code` (
  `id_keys` int(11) NOT NULL,
  `game` varchar(32) NOT NULL,
  `user_key` varchar(32) DEFAULT NULL,
  `key_level` tinyint(4) DEFAULT 1,
  `duration` int(11) DEFAULT NULL,
  `expired_date` datetime DEFAULT NULL,
  `max_devices` int(11) DEFAULT NULL,
  `devices` mediumtext DEFAULT NULL,
  `logins_remaining` int(11) DEFAULT 0,
  `status` tinyint(1) DEFAULT 1,
  `registrator` varchar(32) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Đang đổ dữ liệu cho bảng `keys_code`
--

INSERT INTO `keys_code` (`id_keys`, `game`, `user_key`, `key_level`, `duration`, `expired_date`, `max_devices`, `devices`, `logins_remaining`, `status`, `registrator`, `created_at`, `updated_at`) VALUES
(14318, 'com.garena.game.kgvn', 'rjX1Irqf0JedvcnV', 2, 30, '2025-09-29 15:55:00', 1, '6d1cdee4-83cd-31d4-951e-53e8eb8415ed', 0, 1, 'tisnquyen', '2024-10-03 22:48:41', '2025-08-30 23:00:47'),
(14582, 'com.garena.game.kgvn', 'CvSZP3pViyEa6KDU', 2, 30, '2025-10-15 23:13:00', 1, '59ca0495-ae01-3c80-83e0-5e418eea5aee', 0, 1, 'tisnquyen', '2024-11-26 10:12:37', '2025-09-15 23:18:25'),
(14602, 'com.garena.game.kgvn', 'NjHYLsMgohOEeYd0', 2, 30, '2025-09-30 11:39:00', 1, '7189ec0c-4b4d-30c8-8c6a-afc07d6efc00', 0, 1, 'tisnquyen', '2024-11-29 18:26:19', '2025-08-29 23:39:41'),
(14941, 'com.garena.game.kgvn', 'LuvHHWSvHcGj2Lr2', 2, 30, '2025-10-01 01:22:00', 1, 'e6b1e889-8934-362b-9239-c18fc7040fe9', 0, 1, 'tisnquyen', '2025-04-11 08:05:13', '2025-09-01 19:30:01'),
(14957, 'com.garena.game.kgvn', 't5W0rWZ0SzRPd2u7', 2, 30, '2025-09-25 06:54:00', 1, '5e1e7a17-956a-3d54-a094-bca89c727cb7', 0, 1, 'tisnquyen', '2025-04-28 13:49:48', '2025-08-21 15:05:06'),
(15004, 'com.garena.game.kgvn', 'gthKblgINi4C1k6g', 2, 30, '2025-09-28 08:48:00', 1, '48a50a45-e2a2-31f0-95db-51b3222ba120', 0, 1, 'tisnquyen', '2025-05-31 15:24:16', '2025-08-29 19:29:01'),
(15011, 'com.garena.game.kgvn', '2TNeC9cG5PwNidRC', 2, 30, '2025-09-26 05:20:00', 1, '0efdd9c9-5529-360c-aa06-967517452f09', 0, 1, 'tisnquyen', '2025-06-03 12:09:28', '2025-08-25 11:15:13'),
(15074, 'com.garena.game.kgvn', '6tGQsCQnvMfrDVCQ', 2, 30, '2025-10-13 11:25:00', 1, '8d0a1a01-2206-3521-9428-0a0c41d65273', 0, 1, 'tisnquyen', '2025-07-20 17:09:29', '2025-09-16 18:22:46'),
(15080, 'com.garena.game.kgvn', 'O9QWAKYaQWrLMdRm', 2, 30, '2025-10-08 10:20:00', 1, 'ed0a94c4-d61c-3e83-a2ae-4ea43e7223d8', 0, 1, 'tisnquyen', '2025-07-25 16:56:28', '2025-09-11 21:59:48'),
(15087, 'com.garena.game.kgvn', '7NWc8f8F64ovboUH', 2, 30, '2025-09-23 16:36:00', 1, '6646e6df-22be-387d-be43-ce94074abbf7', 0, 1, 'tisnquyen', '2025-07-28 22:50:50', '2025-09-15 18:08:37'),
(15088, 'com.dts.freefireth', 'ZGWCbfn553QS4R0f', 3, 30, '2025-09-19 16:44:00', 1, '0a57c775-17e1-303c-ac96-78d3a7a879df', 0, 0, 'tisnquyen', '2025-07-28 23:41:52', '2025-09-07 13:33:41'),
(15105, 'com.garena.game.kgvn', 'LhcS26O3JZO6aTtz', 2, 30, '2025-10-03 22:57:00', 1, '53c17e3f-c16d-30f1-8919-a2496df1d795', 0, 1, 'tisnquyen', '2025-08-04 22:23:40', '2025-08-30 22:00:46'),
(15243, 'com.garena.game.kgvn', 'RgecixH7lYRaOwIV', 2, 30, '2025-10-05 14:41:00', 1, '06e86294-c662-3f1c-86bf-63992faecc05', 0, 1, 'tisnquyen', '2025-08-06 20:41:02', '2025-09-04 20:59:05'),
(15446, 'com.garena.game.kgvn', 'ytEVY82eq9EPpP0a', 2, 30, '2025-09-16 01:12:00', 1, '05957923-4b49-3aab-a84b-3b6294748f62', 0, 1, 'tisnquyen', '2025-08-13 08:01:26', '2025-09-10 19:16:23'),
(15483, 'com.garena.game.kgvn', 'q6U9k0Gu27uVPm2I', 2, 30, '2025-10-14 14:48:00', 1, '109b80fa-c95f-3144-b3f9-ba13ceb9c7f6', 0, 1, 'tisnquyen', '2025-08-15 21:44:23', '2025-09-14 20:29:08'),
(15492, 'com.garena.game.kgvn', 'eER6XVN2UbOaiWsv', 2, 30, '2025-10-16 03:54:00', 1, 'fdd6bfa8-714e-365f-babd-1f5ad2f15bf5', 0, 1, 'tisnquyen', '2025-08-17 10:39:57', '2025-09-15 16:07:54'),
(15497, 'GameGuardian', 'fqlzqfiCE5dOnLj9', 1, 30, '2025-09-17 12:16:10', 1, 'Fri Mar 21 13:37:25 UTC 2025|1742564245|JRedmi/diting/diting:12/SKQ1.230401.001/OS2.0.5.0.VLFCNXM:user/release-keys', 0, 1, 'tisnquyen', '2025-08-18 19:10:48', '2025-08-18 19:16:10'),
(15498, 'com.dts.freefiremax', 'wh2aIoKyeICy7ToR', 3, 30, '2025-09-17 13:01:42', 1, '05e9b0c7-a6dd-398c-8cff-065c1b8f232f', 0, 1, 'tisnquyen', '2025-08-18 19:16:08', '2025-08-18 20:01:42'),
(15500, 'com.dts.freefireth', 'VPr9giX62FnB0YsT', 3, 30, '2025-09-15 14:42:00', 1, '82298bc2-0679-370c-902e-7f15c1d8dd32', 0, 1, 'tisnquyen', '2025-08-18 21:29:22', '2025-09-13 06:56:01'),
(15503, 'com.dts.freefireth', 'WuocXUoV6K3VUJIM', 3, 30, '2025-09-18 04:29:00', 1, 'b6866e9f-7c6c-3d61-91f8-7c9d77093025', 0, 0, 'tisnquyen', '2025-08-19 11:14:39', '2025-09-10 10:11:30'),
(15508, 'com.garena.game.kgvn', 'TNbrAh4xe5EBvTqI', 2, 30, '2025-09-18 08:46:42', 1, 'caa0dbc5-0c4f-345b-80c8-b480e152af13', 0, 1, 'tisnquyen', '2025-08-19 15:35:03', '2025-08-19 15:46:42'),
(15517, 'com.dts.freefireth', 'lAQr2ghVrodEARBP', 3, 30, '2025-09-19 13:54:47', 1, '047b7940-fd35-391c-9ba0-13cc97be2863', 0, 1, 'tisnquyen', '2025-08-20 20:54:12', '2025-08-20 20:54:47'),
(15518, 'com.garena.game.kgvn', 'OUdBFqPeoMkQpZfx', 2, 30, '2025-09-20 00:03:34', 1, '4e95c2a2-bc7e-375c-a46d-89e9aa09d3f8', 0, 1, 'tisnquyen', '2025-08-21 06:58:58', '2025-08-21 07:03:34'),
(15540, 'com.dts.freefiremax', '4XexSMByppre9gn6', 3, 30, '2025-09-21 00:47:19', 1, '26d606bf-53b7-3588-826c-4cea936db490', 0, 1, 'tisnquyen', '2025-08-22 07:41:32', '2025-08-22 07:47:19'),
(15542, 'com.garena.game.kgvn', 'q6cRX4OtVEMgPFUF', 2, 30, '2025-09-22 01:50:29', 1, 'b79a0d0e-93f8-357c-9d3e-8dbf81c907ca', 0, 1, 'tisnquyen', '2025-08-23 08:37:44', '2025-08-23 08:50:29'),
(15543, 'com.dts.freefireth', 'WCQ0zrYntvarQoNY', 3, 30, '2025-09-22 03:15:00', 1, '45978518-4605-39af-8380-d92529a8c2cb', 0, 0, 'tisnquyen', '2025-08-23 10:04:09', '2025-09-09 21:41:00'),
(15545, 'com.dts.freefiremax', '7Z91omMTAD6n6Wbi', 3, 30, '2025-09-22 16:03:03', 1, 'c83d2dda-b297-359a-a384-aadd9f2d297f', 0, 1, 'tisnquyen', '2025-08-23 22:57:44', '2025-08-23 23:03:03'),
(15561, 'com.garena.game.kgvn', 'io7sD2RqOtr3zNMi', 2, 30, '2025-09-16 13:45:00', 1, 'd7024556-fd84-340a-a03c-15f19946472e', 0, 1, 'tisnquyen', '2025-08-27 20:43:49', '2025-09-13 20:53:42'),
(15607, 'com.garena.game.kgvn', 'dQx2AylMg7WeHO9Z', 2, 30, '2025-09-27 05:59:38', 1, '88dec6ab-4947-3e02-8180-04165f5cd448', 0, 1, 'tisnquyen', '2025-08-28 12:48:26', '2025-08-28 12:59:38'),
(15619, 'com.garena.game.kgvn', '4UkqUS8Z0A1jtYmF', 2, 30, '2025-09-29 06:22:00', 1, '384f71e1-3a14-3cdc-adba-f80b1d743b3c', 0, 1, 'tisnquyen', '2025-08-28 13:18:08', '2025-09-17 11:12:48'),
(15718, 'com.dts.freefireth', 'TLXMJpyz6EULGcvO', 3, 30, '2025-09-24 07:37:00', 1, '88e92c0b-dc37-3317-84e3-69b33452b217', 0, 1, 'tisnquyen', '2025-08-29 13:58:59', '2025-09-07 13:45:54'),
(15720, 'com.dts.freefireth', 'EZlrAQM7VAF9yCeN', 3, 30, '2025-09-28 08:18:54', 1, '07db9598-8617-3f6f-b2b7-3715dc2bac80', 0, 1, 'tisnquyen', '2025-08-29 15:16:13', '2025-08-29 15:18:54'),
(15725, 'com.dts.freefireth', 'PSQyf0SAK5qMLg27', 3, 30, '2025-09-28 09:28:28', 1, 'ab0413e7-227f-3b49-a14b-83ec5e7beabf', 0, 1, 'tisnquyen', '2025-08-29 16:24:25', '2025-08-29 16:28:28'),
(15764, 'com.dts.freefireth', 'PE5aeVM8QF6mpiGD', 3, 30, '2025-09-28 11:55:00', 1, '159ab002-73e7-34af-9a81-d6f279c316e6', 0, 1, 'tisnquyen', '2025-08-29 18:54:03', '2025-09-09 21:52:22'),
(15778, 'com.dts.freefireth', 'RZkV9dCk7QBadT1r', 3, 30, '2025-09-28 13:17:03', 1, '9ff5a406-b0cc-3875-958c-1220e1672b37', 0, 1, 'tisnquyen', '2025-08-29 20:15:00', '2025-08-29 20:17:03'),
(15884, 'com.garena.game.kgvn', 'gwKyBOa9wvzoRxTT', 2, 30, '2025-09-29 14:54:00', 1, 'e3b172e5-855f-3abb-ac90-eace2198637f', 0, 1, 'tisnquyen', '2025-08-30 21:48:08', '2025-08-30 21:55:36'),
(15885, 'com.dts.freefireth', 'v582T0e7Jmgv4ACA', 3, 30, '2025-09-30 03:36:23', 1, 'c581c5bd-81c5-3387-964a-7320fa187e54', 0, 1, 'tisnquyen', '2025-08-30 22:00:54', '2025-08-31 10:36:23'),
(15930, 'com.dts.freefireth', 'JE0jsOYvcfoOJaIG', 3, 30, '2025-09-30 17:14:21', 1, '68a0c455-9908-35fa-a35b-28f65bc9b0d8', 0, 1, 'tisnquyen', '2025-08-31 23:43:06', '2025-09-01 00:14:21'),
(15941, 'com.dts.freefireth', 'pKjCEdxCFKqUO6YE', 3, 30, '2025-09-30 23:56:33', 1, 'd471561b-c467-312b-9ad6-17af128141e7', 0, 1, 'tisnquyen', '2025-09-01 06:50:00', '2025-09-04 18:45:24'),
(15949, 'com.garena.game.kgvn', 'J4QzzcvkuPsyyn64', 2, 30, '2025-10-01 01:20:34', 1, '0db25e18-a806-31e9-bd55-0ad02a56187b', 0, 1, 'tisnquyen', '2025-09-01 08:18:31', '2025-09-01 19:42:36'),
(15950, 'com.garena.game.kgvn', 'T0AW4gtI5kb8Byob', 2, 30, '2025-10-01 03:09:25', 1, '7f92bd06-bdbf-3558-90ea-0a9f4e86171b', 0, 1, 'tisnquyen', '2025-09-01 09:17:24', '2025-09-01 10:09:25'),
(15951, 'com.dts.freefiremax', 'aydAnhJjq85vAHil', 3, 1, '2025-09-21 02:54:00', 1, '21b6f16f-8423-3124-8395-6f522cf3375b', 0, 1, 'tisnquyen', '2025-09-01 09:53:20', '2025-09-19 17:23:23'),
(15957, 'com.dts.freefireth', 'hIKJmDlFaTsdJCIU', 3, 30, '2025-09-26 05:18:00', 1, 'b26336c9-f810-319c-813c-cd10c986df48', 0, 1, 'tisnquyen', '2025-09-01 11:55:07', '2025-09-11 08:03:34'),
(15962, 'com.dts.freefireth', 'pZLg9iSQbhRMOezg', 3, 30, '2025-09-17 11:48:00', 1, 'd2a2c2d3-ad0d-3155-82ad-838ad95683f0', 0, 1, 'tisnquyen', '2025-09-01 18:45:28', '2025-09-09 20:04:40'),
(15984, 'com.garena.game.kgth', '8GKiJ4A9rTy7AJoh', 2, 30, '2025-10-02 07:52:40', 1, '0ea3c065-b9c2-3cf5-b45b-e4f5dd1833d7', 0, 1, 'tisnquyen', '2025-09-02 12:25:47', '2025-09-02 14:52:40'),
(15988, 'com.garena.game.kgvn', 'x2md6wvARfIAonHr', 2, 30, '2025-09-27 06:13:00', 1, 'fdf8369a-eaf7-32f5-a0ed-58cda15234f8', 0, 1, 'tisnquyen', '2025-09-02 12:54:48', '2025-09-10 13:34:47'),
(16002, 'com.garena.game.kgvn', 'XYLw7ThbFNi1pDII', 2, 30, '2025-10-03 02:35:41', 1, '932adbe9-cac3-33c9-b64d-6218e76d2bbc', 0, 1, 'tisnquyen', '2025-09-03 08:37:40', '2025-09-03 09:35:41'),
(16005, 'com.dts.freefireth', 'ZwwftwntSNwJyMER', 3, 30, '2025-09-30 05:47:00', 1, '12edb02a-364a-3d29-a10a-52996af0632e', 0, 1, 'tisnquyen', '2025-09-03 12:38:30', '2025-09-03 18:08:46'),
(16006, 'com.dts.freefireth', 'VAETYAY9rrN0Jmj4', 2, 60, '2025-11-18 18:39:45', 1, '907ee31e-965c-3a08-b53b-fbcde29714f8', 0, 1, 'hnem06', '2025-09-20 01:39:12', '2025-09-20 01:49:55'),
(16009, 'com.dts.freefireth', '0RRs2AmaPQCd2MrC', 3, 37, '2025-10-11 03:07:08', 1, '4ec729ed-c948-341b-8f95-dfab6c8f01d4', 0, 1, 'tisnquyen', '2025-09-03 23:13:53', '2025-09-10 10:39:25'),
(16014, 'com.dts.freefireth', 'qtZGALf3RB8ZcHuO', 3, 30, '2025-10-04 11:57:35', 1, '28b4017a-9183-30e5-8e56-1fe1bb5f4643', 0, 1, 'tisnquyen', '2025-09-04 12:49:44', '2025-09-04 18:57:35'),
(16020, 'com.dts.freefireth', 'EfVYiN51KJoGmLiR', 3, 1, '2025-09-13 12:31:00', 1, '00ffbdb8-feaf-37f2-b3e4-127f0652186b', 0, 1, 'tisnquyen', '2025-09-05 19:30:56', '2025-09-08 21:33:33'),
(16023, 'com.dts.freefireth', 'sxEjvSpsU9VtAeuj', 3, 30, '2025-09-21 14:27:00', 1, NULL, 1, 1, 'tisnquyen', '2025-09-05 20:40:42', '2025-09-13 07:07:32'),
(16040, 'com.garena.game.kgth', '8YnRuI6IElsZgUZF', 2, 30, '2025-10-06 16:10:35', 1, '37bbadfa-dbc8-3c7a-be7b-f053c449d755', 0, 1, 'tisnquyen', '2025-09-06 21:31:51', '2025-09-06 23:10:35'),
(16041, 'GameGuardian', 'Y2LU7lPtHhBYFBbk', 1, 30, '2025-10-06 14:33:42', 1, 'Sat Jun 28 06:05:47 CST 2025|1751061947|VLenovo/TB373FU/TB373FU:15/AP3A.240905.015/ZUI_17.0.04.088_250628_ROW:user/release-keys', 0, 1, 'tisnquyen', '2025-09-06 21:32:38', '2025-09-06 21:33:42'),
(16074, 'com.dts.freefireth', 'vJ7oohmDwwL78uEd', 3, 30, '2025-09-30 14:22:00', 1, 'a0ae9fcc-8b0a-31e6-9aa4-bd64d28ab6d9', 0, 1, 'tisnquyen', '2025-09-07 21:18:03', '2025-09-17 09:47:45'),
(16078, 'com.garena.game.kgvn', 'sZldjSVRjmSbHh3t', 2, 30, '2025-10-04 17:25:00', 1, 'dd409610-da63-3c1f-839f-121aa2c5437e', 0, 1, 'tisnquyen', '2025-09-08 00:20:23', '2025-09-08 10:32:30'),
(16097, 'com.dts.freefireth', 'r6E9F8Fn6IwLhBW4', 3, 30, '2025-10-10 10:39:50', 1, '409f9162-3de9-3dea-b2a6-64526bdebb02', 0, 1, 'tisnquyen', '2025-09-10 10:22:05', '2025-09-10 17:39:51'),
(16099, 'com.dts.freefireth', 'gkKm6K2r40PKbJcg', 3, 30, '2025-10-10 14:14:53', 1, '8c3fea75-5764-3e13-b772-31e35343e558', 0, 1, 'tisnquyen', '2025-09-10 20:59:32', '2025-09-10 21:14:53'),
(16100, 'com.dts.freefiremax', 'lJ7t63Z6uTPKHM7B', 3, 30, '2025-10-10 14:56:29', 1, '38d39049-bf9c-32cc-8895-48699c526699', 0, 1, 'tisnquyen', '2025-09-10 21:49:59', '2025-09-10 21:56:29'),
(16101, 'com.dts.freefireth', 'f6lzRq41IwxQy75H', 3, 30, '2025-10-10 16:23:00', 1, '15bf8ae1-4576-3ad2-8943-0be36a5dff4a', 0, 1, 'tisnquyen', '2025-09-10 23:05:27', '2025-09-12 16:18:40'),
(16102, 'com.dts.freefireth', 'zBMQgDjNcsXKeHuk', 3, 30, '2025-10-10 05:04:00', 1, 'e3b172e5-855f-3abb-ac90-eace2198637f', 1, 1, 'tisnquyen', '2025-09-10 23:13:38', '2025-09-12 19:23:52'),
(16103, 'com.garena.game.kgvn', 'LTDFFsF7tEPjhSAe', 2, 30, '2025-10-10 16:32:34', 1, '94980603-84e1-35a9-babd-a0a257ef18d0', 0, 1, 'tisnquyen', '2025-09-10 23:26:10', '2025-09-10 23:32:34'),
(16106, 'com.garena.game.kgvn', 'zxqxsFfxJcJnjGE6', 2, 30, '2025-10-13 13:26:32', 1, '99007adb-d7e4-3657-8429-7c289004cb31', 0, 1, 'tisnquyen', '2025-09-13 20:24:56', '2025-09-13 20:26:32'),
(16107, 'ALL', 'WqQssqO4uWJGnYfu', 2, 30, '2025-10-13 13:33:00', 4, 'b532996c-1c98-38bc-9ed1-e2f5b5d4530b,6af22fe7-54e4-3790-885b-54b9d6b1fed8,2f613bcd-5795-382c-bbcf-80da4b737c96,2fdca9fd-affd-3526-95a5-42d97a0f53b2', 0, 1, 'tisnquyen', '2025-09-13 20:33:01', '2025-09-18 12:40:09'),
(16108, 'com.dts.freefireth', 'uRXdBnqVQmapPLVz', 3, 30, '2025-10-13 16:56:04', 1, 'de930374-31fa-362b-bde8-65312b2a0050', 0, 1, 'tisnquyen', '2025-09-13 21:31:34', '2025-09-13 23:56:04'),
(16109, 'com.garena.game.kgvn', 'P8XovETMqLnIYCqd', 2, 30, '2025-10-14 04:07:20', 1, '8bd7d79f-77ae-3366-bdcd-81d23e3bdcce', 0, 1, 'tisnquyen', '2025-09-14 11:04:10', '2025-09-14 11:07:20'),
(16110, 'com.dts.freefireth', 'l1MADkhQLXGNhtqZ', 3, 30, '2025-10-18 08:57:52', 1, '8437146b-86bd-3f05-86f1-262b300636a6', 0, 1, 'tisnquyen', '2025-09-14 13:04:26', '2025-09-18 15:57:52'),
(16111, 'com.garena.game.kgvn', 'V1gEpFIwttrMz8d0', 2, 7, '2025-09-21 09:20:19', 1, 'dd29b1b9-05c3-3e2c-96f2-a3659e8c595a', 0, 1, 'tisnquyen', '2025-09-14 16:16:42', '2025-09-14 16:20:19'),
(16112, 'com.garena.game.kgtw', 'bxkfgn2BEW1U0Mh6', 2, 30, '2025-10-08 00:45:00', 1, 'f2128790-ae91-3593-82cb-5d4ba6d6b8c5', 0, 1, 'tisnquyen', '2025-09-15 07:42:44', '2025-09-18 14:07:03'),
(16113, 'com.garena.game.kgvn', 'QNX4M04xJRTbvN7v', 2, 30, '2025-10-15 09:05:31', 1, 'fd728c60-3b87-34aa-9902-13c1dff6b112', 0, 1, 'tisnquyen', '2025-09-15 16:02:16', '2025-09-15 16:05:31'),
(16114, 'com.garena.game.kgvn', 'wcIB4rOpQP0qmOPs', 2, 30, '2025-10-16 05:28:06', 1, '4f701f3b-055f-364d-ada2-a2dac9bc7bf9', 0, 1, 'tisnquyen', '2025-09-15 22:04:45', '2025-09-16 12:28:06'),
(16115, 'com.dts.freefireth', 'lnfI0AJ13q1YZm9y', 3, 30, '2025-10-15 15:39:21', 1, 'def6c0c7-bafc-3728-9ef5-01c9bedab508', 0, 1, 'tisnquyen', '2025-09-15 22:11:06', '2025-09-15 22:39:21'),
(16117, 'com.garena.game.kgvn', 'ZAdkSKOIYxeSvjbz', 2, 30, '2025-10-16 02:01:13', 1, '08473ce5-439f-3187-a687-fcf175bf1f78', 0, 1, 'tisnquyen', '2025-09-16 08:53:33', '2025-09-16 09:01:13'),
(16118, 'com.dts.freefireth', 'hEkqd0t55gdaLUV0', 3, 30, '2025-10-16 04:35:40', 1, 'ad213ed9-89d9-3a85-8371-13df04140bfe', 0, 1, 'tisnquyen', '2025-09-16 11:31:38', '2025-09-16 11:35:40'),
(16119, 'com.dts.freefireth', '7nsP1mV2jIVp6yXP', 3, 30, '2025-10-16 12:23:42', 1, '5f3bc75c-6888-3846-851a-68ec30d66209', 0, 1, 'tisnquyen', '2025-09-16 19:20:50', '2025-09-16 19:23:42'),
(16120, 'com.dts.freefireth', 'vSFjk7PBkx6OmQhD', 3, 30, '2025-10-16 17:03:32', 1, '339b50c4-ec85-376b-9995-79904f2c2e76', 0, 1, 'tisnquyen', '2025-09-16 22:46:57', '2025-09-17 00:03:32'),
(16121, 'com.dts.freefiremax', 'GKp1HLAvxKr2ZBA1', 3, 60, '2025-11-16 03:03:08', 1, 'd3561a31-02e5-3c13-b094-fad424c06c08', 0, 1, 'tisnquyen', '2025-09-17 10:00:06', '2025-09-17 10:03:08'),
(16122, 'com.dts.freefiremax', 'YVQqEc6C4z5k46Tg', 3, 30, '2025-10-17 04:56:52', 1, '30bee48d-a883-3a6e-99a3-af266a8553a9', 0, 1, 'tisnquyen', '2025-09-17 11:48:38', '2025-09-17 11:56:52'),
(16123, 'com.dts.freefireth', 'jdjNPJPGZgX9VGx3', 3, 30, NULL, 1, 'd7312ddd28749d9f36578af9f0936a07', 0, 1, 'tisnquyen', '2025-09-17 17:36:01', '2025-09-17 17:36:01'),
(16124, 'com.garena.game.kgvn', 'xUX5S3SRs4nzRsiN', 2, 1, '2025-09-19 00:47:31', 1, '34862a5f-6987-3ccb-9120-dddb72926771', 0, 1, 'tisnquyen', '2025-09-18 07:47:13', '2025-09-18 07:47:31'),
(16126, 'com.tencent.stc.cfl', 'pO8K5SQWTGXhyQ7k', 3, 1, '2025-09-19 10:51:58', 1, 'c9b5bc85-489f-3c12-b711-c705d090e26b', 0, 1, 'tisnquyen', '2025-09-18 17:51:50', '2025-09-18 17:51:58'),
(16127, 'com.garena.game.kgvn', 'oY4aq76FGsgVLvKu', 2, 30, '2025-10-18 11:08:15', 1, 'ef5edc6e-3104-35d2-85c3-34ff2c1acf28', 0, 1, 'tisnquyen', '2025-09-18 18:04:12', '2025-09-18 18:08:15'),
(16128, 'com.garena.game.kgvn', '5fK7GycJQpkz9Oar', 2, 30, '2025-10-19 01:50:00', 1, 'e40ef31f-a848-3201-886c-9179a9a395cb', 0, 1, 'tisnquyen', '2025-09-19 08:25:20', '2025-09-19 08:50:00'),
(16130, 'com.dts.freefireth', 'RpnOjLSilMgjXYKK', 3, 30, '2025-10-19 11:16:50', 1, 'cd47557a-a45c-3ef3-8713-382391afa939', 0, 1, 'tisnquyen', '2025-09-19 18:04:08', '2025-09-19 18:16:50'),
(16132, 'com.dts.freefireth', 'E2ey6h8GxJvqzbfR', 3, 30, '2025-10-19 18:10:27', 1, '713e79f0-80f2-38fe-89fb-b26e132bb52e', 0, 1, 'tisnquyen', '2025-09-19 22:49:20', '2025-09-20 01:10:45');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `libonline`
--

CREATE TABLE `libonline` (
  `id` int(11) NOT NULL COMMENT 'Primary Key',
  `name` varchar(255) NOT NULL COMMENT 'Name',
  `type` varchar(255) NOT NULL COMMENT 'File Type',
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `libonline`
--

INSERT INTO `libonline` (`id`, `name`, `type`, `status`) VALUES
(28, 'libmain.so', 'application/octet-stream', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `referral_code`
--

CREATE TABLE `referral_code` (
  `id_reff` int(11) NOT NULL,
  `code` varchar(255) NOT NULL,
  `hashed` varchar(128) DEFAULT NULL,
  `saldo` int(11) DEFAULT NULL,
  `level` int(11) NOT NULL,
  `used_by` varchar(66) DEFAULT NULL,
  `created_by` varchar(66) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Đang đổ dữ liệu cho bảng `referral_code`
--

INSERT INTO `referral_code` (`id_reff`, `code`, `hashed`, `saldo`, `level`, `used_by`, `created_by`, `created_at`, `updated_at`) VALUES
(15, '7FL6mb', '1eea273d41e9c84a11c528b0c48f3d64', 59, 2, 'abcxyz', 'tisnquyen', '2023-07-30 22:55:11', '2024-02-27 02:06:10');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `server`
--

CREATE TABLE `server` (
  `id` int(11) NOT NULL,
  `modname` varchar(255) NOT NULL,
  `status` varchar(5) NOT NULL,
  `myinput` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `server`
--

INSERT INTO `server` (`id`, `modname`, `status`, `myinput`) VALUES
(11, 'ZyGames', 'on', 'Server is under maintenance');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id_users` int(11) NOT NULL,
  `fullname` varchar(155) DEFAULT NULL,
  `username` varchar(66) NOT NULL,
  `level` int(11) DEFAULT 2,
  `saldo` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1,
  `uplink` varchar(66) DEFAULT NULL,
  `password` varchar(155) NOT NULL,
  `user_ip` varchar(155) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id_users`, `fullname`, `username`, `level`, `saldo`, `status`, `uplink`, `password`, `user_ip`, `created_at`, `updated_at`) VALUES
(1, 'TisNquyen', 'tisnquyen', 1, 39081, 1, 'tisnquyen', '$2y$08$88Jm6noZhg3rX/MgRS2ZBuckZ.jzUT4ps.la2yRzKx5mTMl0KSpsO', '', '2023-07-26 10:33:38', '2025-09-19 15:49:20');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `games`
--
ALTER TABLE `games`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `history`
--
ALTER TABLE `history`
  ADD PRIMARY KEY (`id_history`);

--
-- Chỉ mục cho bảng `keys_code`
--
ALTER TABLE `keys_code`
  ADD PRIMARY KEY (`id_keys`),
  ADD UNIQUE KEY `user_key` (`user_key`);

--
-- Chỉ mục cho bảng `libonline`
--
ALTER TABLE `libonline`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `referral_code`
--
ALTER TABLE `referral_code`
  ADD PRIMARY KEY (`id_reff`);

--
-- Chỉ mục cho bảng `server`
--
ALTER TABLE `server`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_users`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `games`
--
ALTER TABLE `games`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT cho bảng `history`
--
ALTER TABLE `history`
  MODIFY `id_history` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15535;

--
-- AUTO_INCREMENT cho bảng `keys_code`
--
ALTER TABLE `keys_code`
  MODIFY `id_keys` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16136;

--
-- AUTO_INCREMENT cho bảng `libonline`
--
ALTER TABLE `libonline`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Primary Key', AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT cho bảng `referral_code`
--
ALTER TABLE `referral_code`
  MODIFY `id_reff` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT cho bảng `server`
--
ALTER TABLE `server`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id_users` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
