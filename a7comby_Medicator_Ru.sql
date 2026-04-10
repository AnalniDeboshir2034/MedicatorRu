-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Хост: localhost:3306
-- Время создания: Апр 10 2026 г., 12:07
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
(4, 'Dosatron', '', 'dosatron'),
(5, 'MASTERPRO', '', 'masterpro'),
(6, 'MixRite', '', 'mixrite'),
(7, 'Узел водоподготовки', '', 'uzel-vodopodgotovki');

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
(4, 4, 4),
(5, 4, 5),
(6, 6, 6),
(7, 5, 7),
(8, 7, 8);

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
(5, 'Дозатрон D25AL2 NVF', '0.2 — 2 % [1:500 — 1:50]', '10л/ч - 2.5м³/ч', '0.3 — 6 бар', '5 — 40°C', 'G¾\" наружная', 'VITON – для кислот, масел, ветеринарных препаратов, ароматических веществ и пестицидов', 'Специальный полипропилен', 'NSF cертификация для контакта с пищевыми продуктами', 'products/admin_docs/doc_69d78d04603043.03423725_697cbe3d42d71_Rangesheet_FichesGamme_D25_EN-1.pdf', '', 'Инновационный дозатор [b]D25AL2N[/b] (серия Animal Health Line), также известный как D25+Care, с производительностью от 10 до 2500 л/ч обладает большей химической стойкостью и расширенным диапазоном дозирования по сравнению с классической моделью D25RE2.', 'D25', 'dozatron-d25al2-nvf'),
(6, 'Дозатрон D07RE5AF', '0.8 — 5.5 % [1:128 — 1:28]', '5л/ч - 0.7м³/ч', '0.3 — 6 бар', '5 — 40°C', 'G¾\" наружная', 'AFLAS – уплотнения, устойчивые к щелочам, для дозирования жидкостей со значением pH более 8', 'Полиацеталь', 'Встроенный by-pass', 'products/admin_docs/doc_69d89965080420.71523551_697cbd905ab83_Eclate-D07RE5-u.pdf', '', '[b]Серия D07 Compact[/b] – это самые малогабаритные неэлектрические пропорциональные дозаторы. Их используют в тех случаях, когда не требуется высокая производительность и сильно ограничено пространство для установки. Часто находят свое применение в составе более сложных агрегатов.', 'D07', 'dozatron-d07re5af'),
(7, 'Дозатрон D25AL5 NVF', '1 — 5 % [1:100 — 1:20]', '10л/ч - 2.5м³/ч', '0.3 — 6 бар', '5 — 40°C', 'G¾\" наружная', 'VITON – для кислот, масел, ветеринарных препаратов, ароматических веществ и пестицидов', 'Специальный полипропилен', 'NSF cертификация для контакта с пищивыми продуктами', 'products/admin_docs/doc_69d8b8c5cb5531.47213552_697cbeb85e873_Rangesheet_FichesGamme_D25_EN-1.pdf', '', 'Инновационный дозатор [b]D25AL5N (серия Animal Health Line)[/b], также известный как D25+Care, с производительностью от 10 до 2500 л/ч обладает большей химической стойкостью и расширенным диапазоном дозирования по сравнению с классической моделью [b]D25RE5[/b].', 'D25', 'dozatron-d25al5-nvf');

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
(9, 5, 1, 'products/admin_uploads/img_69d78ce272f5a6.08957617_meow.png', 1),
(10, 6, 1, 'products/admin_uploads/img_69d8997fc380a5.89810321_D07RE5.png', 1),
(11, 7, 1, 'products/admin_uploads/img_69d8b8fbc80c14.09355584_D25AL2N_A3png.png', 1);

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
(435, 5, 'Дозатрон D25AL2 NVF', '2026-04-10', 12),
(436, 6, 'Дозатрон D07RE5AF', '2026-04-10', 7);

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
(4, 'D25', '', 'd25'),
(5, 'D07', '', 'd07'),
(6, 'MixRite 25', '', 'mixrite-25'),
(7, 'Master Pro', '', 'master-pro'),
(8, 'Узел водоподготовки', '', 'uzel-vodopodgotovki');

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
  ADD UNIQUE KEY `UX_medicatorview_day` (`medicator_id`,`view_data`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT для таблицы `filter_Relationships`
--
ALTER TABLE `filter_Relationships`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT для таблицы `medicator`
--
ALTER TABLE `medicator`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT для таблицы `medicator_img`
--
ALTER TABLE `medicator_img`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT для таблицы `medicator_view`
--
ALTER TABLE `medicator_view`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=437;

--
-- AUTO_INCREMENT для таблицы `subfilter`
--
ALTER TABLE `subfilter`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

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
