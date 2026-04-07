-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Хост: localhost:3306
-- Время создания: Апр 07 2026 г., 14:25
-- Версия сервера: 5.7.44-cll-lve
-- Версия PHP: 8.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `a7comby_Medicator_Ru`
--

-- --------------------------------------------------------

--
-- Структура таблицы `filter`
--

CREATE TABLE `filter` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `opis` varchar(255) NOT NULL,
  `slug` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `filter`
--

INSERT INTO `filter` (`id`, `name`, `opis`, `slug`) VALUES
(1, 'check', 'check', 'check');

-- --------------------------------------------------------

--
-- Структура таблицы `filter_Relationships`
--

CREATE TABLE `filter_Relationships` (
  `id` int(11) NOT NULL,
  `filter_id` int(11) NOT NULL,
  `subfilter_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `filter_Relationships`
--

INSERT INTO `filter_Relationships` (`id`, `filter_id`, `subfilter_id`) VALUES
(1, 1, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `medicator`
--

CREATE TABLE `medicator` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `d_dosing` varchar(255) NOT NULL,
  `performance` varchar(255) NOT NULL,
  `pressure` varchar(255) NOT NULL,
  `temperature` varchar(255) NOT NULL,
  `connections` varchar(255) NOT NULL,
  `m_seal` varchar(255) NOT NULL,
  `m_case` varchar(255) NOT NULL,
  `dop` varchar(255) NOT NULL,
  `passport` varchar(255) DEFAULT NULL,
  `user_pass` varchar(255) DEFAULT NULL,
  `opis` varchar(2555) NOT NULL,
  `filtr` varchar(255) NOT NULL,
  `slug` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `medicator`
--

INSERT INTO `medicator` (`id`, `name`, `d_dosing`, `performance`, `pressure`, `temperature`, `connections`, `m_seal`, `m_case`, `dop`, `passport`, `user_pass`, `opis`, `filtr`, `slug`) VALUES
(1, 'check', 'check', 'check', 'check', 'check', 'check', 'check', 'check', 'check', 'check', 'check', 'мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу мяу', 'check', 'check');

-- --------------------------------------------------------

--
-- Структура таблицы `medicator_img`
--

CREATE TABLE `medicator_img` (
  `id` int(11) NOT NULL,
  `medicator_id` int(11) NOT NULL,
  `is_Main` tinyint(1) NOT NULL DEFAULT '0',
  `path_img` varchar(500) NOT NULL,
  `sort` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `medicator_img`
--

INSERT INTO `medicator_img` (`id`, `medicator_id`, `is_Main`, `path_img`, `sort`) VALUES
(1, 1, 1, 'products/medikator.jpg', 0),
(3, 1, 0, 'products/лапы.jpg', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `medicator_view`
--

CREATE TABLE `medicator_view` (
  `id` int(11) NOT NULL,
  `medicator_id` int(11) NOT NULL,
  `medicator_name` varchar(255) NOT NULL,
  `view_data` date NOT NULL,
  `view_count` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `medicator_view`
--

INSERT INTO `medicator_view` (`id`, `medicator_id`, `medicator_name`, `view_data`, `view_count`) VALUES
(1, 1, 'check', '2026-04-07', 1),
(2, 1, 'check', '2026-04-07', 1),
(3, 1, 'check', '2026-04-07', 1),
(4, 1, 'check', '2026-04-07', 1),
(5, 1, 'check', '2026-04-07', 1),
(6, 1, 'check', '2026-04-07', 1),
(7, 1, 'check', '2026-04-07', 1),
(8, 1, 'check', '2026-04-07', 1),
(9, 1, 'check', '2026-04-07', 1),
(10, 1, 'check', '2026-04-07', 1),
(11, 1, 'check', '2026-04-07', 1),
(12, 1, 'check', '2026-04-07', 1),
(13, 1, 'check', '2026-04-07', 1),
(14, 1, 'check', '2026-04-07', 1),
(15, 1, 'check', '2026-04-07', 1),
(16, 1, 'check', '2026-04-07', 1),
(17, 1, 'check', '2026-04-07', 1),
(18, 1, 'check', '2026-04-07', 1),
(19, 1, 'check', '2026-04-07', 1),
(20, 1, 'check', '2026-04-07', 1),
(21, 1, 'check', '2026-04-07', 1),
(22, 1, 'check', '2026-04-07', 1),
(23, 1, 'check', '2026-04-07', 1),
(24, 1, 'check', '2026-04-07', 1),
(25, 1, 'check', '2026-04-07', 1),
(26, 1, 'check', '2026-04-07', 1),
(27, 1, 'check', '2026-04-07', 1),
(28, 1, 'check', '2026-04-07', 1),
(29, 1, 'check', '2026-04-07', 1),
(30, 1, 'check', '2026-04-07', 1),
(31, 1, 'check', '2026-04-07', 1),
(32, 1, 'check', '2026-04-07', 1),
(33, 1, 'check', '2026-04-07', 1),
(34, 1, 'check', '2026-04-07', 1),
(35, 1, 'check', '2026-04-07', 1),
(36, 1, 'check', '2026-04-07', 1),
(37, 1, 'check', '2026-04-07', 1),
(38, 1, 'check', '2026-04-07', 1),
(39, 1, 'check', '2026-04-07', 1),
(40, 1, 'check', '2026-04-07', 1),
(41, 1, 'check', '2026-04-07', 1),
(42, 1, 'check', '2026-04-07', 1),
(43, 1, 'check', '2026-04-07', 1),
(44, 1, 'check', '2026-04-07', 1),
(45, 1, 'check', '2026-04-07', 1),
(46, 1, 'check', '2026-04-07', 1),
(47, 1, 'check', '2026-04-07', 1),
(48, 1, 'check', '2026-04-07', 1),
(49, 1, 'check', '2026-04-07', 1),
(50, 1, 'check', '2026-04-07', 1),
(51, 1, 'check', '2026-04-07', 1),
(52, 1, 'check', '2026-04-07', 1),
(53, 1, 'check', '2026-04-07', 1),
(54, 1, 'check', '2026-04-07', 1),
(55, 1, 'check', '2026-04-07', 1),
(56, 1, 'check', '2026-04-07', 1),
(57, 1, 'check', '2026-04-07', 1),
(58, 1, 'check', '2026-04-07', 1),
(59, 1, 'check', '2026-04-07', 1),
(60, 1, 'check', '2026-04-07', 1),
(61, 1, 'check', '2026-04-07', 1),
(62, 1, 'check', '2026-04-07', 1),
(63, 1, 'check', '2026-04-07', 1),
(64, 1, 'check', '2026-04-07', 1),
(65, 1, 'check', '2026-04-07', 1),
(66, 1, 'check', '2026-04-07', 1),
(67, 1, 'check', '2026-04-07', 1),
(68, 1, 'check', '2026-04-07', 1),
(69, 1, 'check', '2026-04-07', 1),
(70, 1, 'check', '2026-04-07', 1),
(71, 1, 'check', '2026-04-07', 1),
(72, 1, 'check', '2026-04-07', 1),
(73, 1, 'check', '2026-04-07', 1),
(74, 1, 'check', '2026-04-07', 1),
(75, 1, 'check', '2026-04-07', 1),
(76, 1, 'check', '2026-04-07', 1),
(77, 1, 'check', '2026-04-07', 1),
(78, 1, 'check', '2026-04-07', 1),
(79, 1, 'check', '2026-04-07', 1),
(80, 1, 'check', '2026-04-07', 1),
(81, 1, 'check', '2026-04-07', 1),
(82, 1, 'check', '2026-04-07', 1),
(83, 1, 'check', '2026-04-07', 1),
(84, 1, 'check', '2026-04-07', 1),
(85, 1, 'check', '2026-04-07', 1),
(86, 1, 'check', '2026-04-07', 1),
(87, 1, 'check', '2026-04-07', 1),
(88, 1, 'check', '2026-04-07', 1),
(89, 1, 'check', '2026-04-07', 1),
(90, 1, 'check', '2026-04-07', 1),
(91, 1, 'check', '2026-04-07', 1),
(92, 1, 'check', '2026-04-07', 1),
(93, 1, 'check', '2026-04-07', 1),
(94, 1, 'check', '2026-04-07', 1),
(95, 1, 'check', '2026-04-07', 1),
(96, 1, 'check', '2026-04-07', 1),
(97, 1, 'check', '2026-04-07', 1),
(98, 1, 'check', '2026-04-07', 1),
(99, 1, 'check', '2026-04-07', 1),
(100, 1, 'check', '2026-04-07', 1),
(101, 1, 'check', '2026-04-07', 1),
(102, 1, 'check', '2026-04-07', 1),
(103, 1, 'check', '2026-04-07', 1),
(104, 1, 'check', '2026-04-07', 1),
(105, 1, 'check', '2026-04-07', 1),
(106, 1, 'check', '2026-04-07', 1),
(107, 1, 'check', '2026-04-07', 1),
(108, 1, 'check', '2026-04-07', 1),
(109, 1, 'check', '2026-04-07', 1),
(110, 1, 'check', '2026-04-07', 1),
(111, 1, 'check', '2026-04-07', 1),
(112, 1, 'check', '2026-04-07', 1),
(113, 1, 'check', '2026-04-07', 1),
(114, 1, 'check', '2026-04-07', 1),
(115, 1, 'check', '2026-04-07', 1),
(116, 1, 'check', '2026-04-07', 1),
(117, 1, 'check', '2026-04-07', 1),
(118, 1, 'check', '2026-04-07', 1),
(119, 1, 'check', '2026-04-07', 1),
(120, 1, 'check', '2026-04-07', 1),
(121, 1, 'check', '2026-04-07', 1),
(122, 1, 'check', '2026-04-07', 1),
(123, 1, 'check', '2026-04-07', 1),
(124, 1, 'check', '2026-04-07', 1),
(125, 1, 'check', '2026-04-07', 1),
(126, 1, 'check', '2026-04-07', 1),
(127, 1, 'check', '2026-04-07', 1),
(128, 1, 'check', '2026-04-07', 1),
(129, 1, 'check', '2026-04-07', 1),
(130, 1, 'check', '2026-04-07', 1),
(131, 1, 'check', '2026-04-07', 1),
(132, 1, 'check', '2026-04-07', 1),
(133, 1, 'check', '2026-04-07', 1),
(134, 1, 'check', '2026-04-07', 1),
(135, 1, 'check', '2026-04-07', 1),
(136, 1, 'check', '2026-04-07', 1),
(137, 1, 'check', '2026-04-07', 1),
(138, 1, 'check', '2026-04-07', 1),
(139, 1, 'check', '2026-04-07', 1),
(140, 1, 'check', '2026-04-07', 1),
(141, 1, 'check', '2026-04-07', 1),
(142, 1, 'check', '2026-04-07', 1),
(143, 1, 'check', '2026-04-07', 1),
(144, 1, 'check', '2026-04-07', 1),
(145, 1, 'check', '2026-04-07', 1),
(146, 1, 'check', '2026-04-07', 1),
(147, 1, 'check', '2026-04-07', 1),
(148, 1, 'check', '2026-04-07', 1),
(149, 1, 'check', '2026-04-07', 1),
(150, 1, 'check', '2026-04-07', 1),
(151, 1, 'check', '2026-04-07', 1),
(152, 1, 'check', '2026-04-07', 1),
(153, 1, 'check', '2026-04-07', 1),
(154, 1, 'check', '2026-04-07', 1),
(155, 1, 'check', '2026-04-07', 1),
(156, 1, 'check', '2026-04-07', 1),
(157, 1, 'check', '2026-04-07', 1),
(158, 1, 'check', '2026-04-07', 1),
(159, 1, 'check', '2026-04-07', 1),
(160, 1, 'check', '2026-04-07', 1),
(161, 1, 'check', '2026-04-07', 1),
(162, 1, 'check', '2026-04-07', 1),
(163, 1, 'check', '2026-04-07', 1),
(164, 1, 'check', '2026-04-07', 1),
(165, 1, 'check', '2026-04-07', 1),
(166, 1, 'check', '2026-04-07', 1),
(167, 1, 'check', '2026-04-07', 1),
(168, 1, 'check', '2026-04-07', 1),
(169, 1, 'check', '2026-04-07', 1),
(170, 1, 'check', '2026-04-07', 1),
(171, 1, 'check', '2026-04-07', 1),
(172, 1, 'check', '2026-04-07', 1),
(173, 1, 'check', '2026-04-07', 1),
(174, 1, 'check', '2026-04-07', 1),
(175, 1, 'check', '2026-04-07', 1),
(176, 1, 'check', '2026-04-07', 1),
(177, 1, 'check', '2026-04-07', 1),
(178, 1, 'check', '2026-04-07', 1),
(179, 1, 'check', '2026-04-07', 1),
(180, 1, 'check', '2026-04-07', 1),
(181, 1, 'check', '2026-04-07', 1),
(182, 1, 'check', '2026-04-07', 1),
(183, 1, 'check', '2026-04-07', 1),
(184, 1, 'check', '2026-04-07', 1),
(185, 1, 'check', '2026-04-07', 1),
(186, 1, 'check', '2026-04-07', 1),
(187, 1, 'check', '2026-04-07', 1),
(188, 1, 'check', '2026-04-07', 1),
(189, 1, 'check', '2026-04-07', 1),
(190, 1, 'check', '2026-04-07', 1),
(191, 1, 'check', '2026-04-07', 1),
(192, 1, 'check', '2026-04-07', 1),
(193, 1, 'check', '2026-04-07', 1),
(194, 1, 'check', '2026-04-07', 1),
(195, 1, 'check', '2026-04-07', 1),
(196, 1, 'check', '2026-04-07', 1),
(197, 1, 'check', '2026-04-07', 1),
(198, 1, 'check', '2026-04-07', 1),
(199, 1, 'check', '2026-04-07', 1),
(200, 1, 'check', '2026-04-07', 1),
(201, 1, 'check', '2026-04-07', 1),
(202, 1, 'check', '2026-04-07', 1),
(203, 1, 'check', '2026-04-07', 1),
(204, 1, 'check', '2026-04-07', 1),
(205, 1, 'check', '2026-04-07', 1),
(206, 1, 'check', '2026-04-07', 1),
(207, 1, 'check', '2026-04-07', 1),
(208, 1, 'check', '2026-04-07', 1),
(209, 1, 'check', '2026-04-07', 1),
(210, 1, 'check', '2026-04-07', 1),
(211, 1, 'check', '2026-04-07', 1),
(212, 1, 'check', '2026-04-07', 1),
(213, 1, 'check', '2026-04-07', 1),
(214, 1, 'check', '2026-04-07', 1),
(215, 1, 'check', '2026-04-07', 1),
(216, 1, 'check', '2026-04-07', 1),
(217, 1, 'check', '2026-04-07', 1),
(218, 1, 'check', '2026-04-07', 1),
(219, 1, 'check', '2026-04-07', 1),
(220, 1, 'check', '2026-04-07', 1),
(221, 1, 'check', '2026-04-07', 1),
(222, 1, 'check', '2026-04-07', 1),
(223, 1, 'check', '2026-04-07', 1),
(224, 1, 'check', '2026-04-07', 1),
(225, 1, 'check', '2026-04-07', 1),
(226, 1, 'check', '2026-04-07', 1),
(227, 1, 'check', '2026-04-07', 1),
(228, 1, 'check', '2026-04-07', 1),
(229, 1, 'check', '2026-04-07', 1),
(230, 1, 'check', '2026-04-07', 1),
(231, 1, 'check', '2026-04-07', 1),
(232, 1, 'check', '2026-04-07', 1),
(233, 1, 'check', '2026-04-07', 1),
(234, 1, 'check', '2026-04-07', 1),
(235, 1, 'check', '2026-04-07', 1),
(236, 1, 'check', '2026-04-07', 1),
(237, 1, 'check', '2026-04-07', 1),
(238, 1, 'check', '2026-04-07', 1),
(239, 1, 'check', '2026-04-07', 1),
(240, 1, 'check', '2026-04-07', 1),
(241, 1, 'check', '2026-04-07', 1),
(242, 1, 'check', '2026-04-07', 1),
(243, 1, 'check', '2026-04-07', 1),
(244, 1, 'check', '2026-04-07', 1),
(245, 1, 'check', '2026-04-07', 1),
(246, 1, 'check', '2026-04-07', 1),
(247, 1, 'check', '2026-04-07', 1),
(248, 1, 'check', '2026-04-07', 1),
(249, 1, 'check', '2026-04-07', 1),
(250, 1, 'check', '2026-04-07', 1),
(251, 1, 'check', '2026-04-07', 1),
(252, 1, 'check', '2026-04-07', 1),
(253, 1, 'check', '2026-04-07', 1),
(254, 1, 'check', '2026-04-07', 1),
(255, 1, 'check', '2026-04-07', 1),
(256, 1, 'check', '2026-04-07', 1),
(257, 1, 'check', '2026-04-07', 1),
(258, 1, 'check', '2026-04-07', 1),
(259, 1, 'check', '2026-04-07', 1),
(260, 1, 'check', '2026-04-07', 1),
(261, 1, 'check', '2026-04-07', 1),
(262, 1, 'check', '2026-04-07', 1),
(263, 1, 'check', '2026-04-07', 1),
(264, 1, 'check', '2026-04-07', 1),
(265, 1, 'check', '2026-04-07', 1),
(266, 1, 'check', '2026-04-07', 1),
(267, 1, 'check', '2026-04-07', 1),
(268, 1, 'check', '2026-04-07', 1),
(269, 1, 'check', '2026-04-07', 1),
(270, 1, 'check', '2026-04-07', 1),
(271, 1, 'check', '2026-04-07', 1),
(272, 1, 'check', '2026-04-07', 1),
(273, 1, 'check', '2026-04-07', 1),
(274, 1, 'check', '2026-04-07', 1),
(275, 1, 'check', '2026-04-07', 1),
(276, 1, 'check', '2026-04-07', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `subfilter`
--

CREATE TABLE `subfilter` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `opis` varchar(255) NOT NULL,
  `slug` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `subfilter`
--

INSERT INTO `subfilter` (`id`, `name`, `opis`, `slug`) VALUES
(1, 'check', 'check', 'check');

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `login` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `filter`
--
ALTER TABLE `filter`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Индексы таблицы `filter_Relationships`
--
ALTER TABLE `filter_Relationships`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FX_filter_12` (`filter_id`),
  ADD KEY `FX_subfilter_12` (`subfilter_id`);

--
-- Индексы таблицы `medicator`
--
ALTER TABLE `medicator`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `medicator_img`
--
ALTER TABLE `medicator_img`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FX_medicatorimg_12` (`medicator_id`);

--
-- Индексы таблицы `medicator_view`
--
ALTER TABLE `medicator_view`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FX_medicatorview_12` (`medicator_id`);

--
-- Индексы таблицы `subfilter`
--
ALTER TABLE `subfilter`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `filter`
--
ALTER TABLE `filter`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `filter_Relationships`
--
ALTER TABLE `filter_Relationships`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `medicator`
--
ALTER TABLE `medicator`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `medicator_img`
--
ALTER TABLE `medicator_img`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `medicator_view`
--
ALTER TABLE `medicator_view`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=277;

--
-- AUTO_INCREMENT для таблицы `subfilter`
--
ALTER TABLE `subfilter`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `filter_Relationships`
--
ALTER TABLE `filter_Relationships`
  ADD CONSTRAINT `FX_filter_12` FOREIGN KEY (`filter_id`) REFERENCES `filter` (`id`),
  ADD CONSTRAINT `FX_subfilter_12` FOREIGN KEY (`subfilter_id`) REFERENCES `subfilter` (`id`);

--
-- Ограничения внешнего ключа таблицы `medicator_img`
--
ALTER TABLE `medicator_img`
  ADD CONSTRAINT `FX_medicatorimg_12` FOREIGN KEY (`medicator_id`) REFERENCES `medicator` (`id`);

--
-- Ограничения внешнего ключа таблицы `medicator_view`
--
ALTER TABLE `medicator_view`
  ADD CONSTRAINT `FX_medicatorview_12` FOREIGN KEY (`medicator_id`) REFERENCES `medicator` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
