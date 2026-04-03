-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Хост: localhost:3306
-- Время создания: Апр 03 2026 г., 12:36
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

-- --------------------------------------------------------

--
-- Структура таблицы `filter_Relationships`
--

CREATE TABLE `filter_Relationships` (
  `id` int(11) NOT NULL,
  `filter_id` int(11) NOT NULL,
  `subfilter_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
  `opis` varchar(255) NOT NULL,
  `filtr` varchar(255) NOT NULL,
  `slug` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `filter_Relationships`
--
ALTER TABLE `filter_Relationships`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `medicator`
--
ALTER TABLE `medicator`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `medicator_img`
--
ALTER TABLE `medicator_img`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `medicator_view`
--
ALTER TABLE `medicator_view`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `subfilter`
--
ALTER TABLE `subfilter`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

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
