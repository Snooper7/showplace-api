-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Сен 18 2023 г., 16:48
-- Версия сервера: 8.0.30
-- Версия PHP: 8.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `showplace`
--

-- --------------------------------------------------------

--
-- Структура таблицы `city`
--

CREATE TABLE `city` (
  `id` int NOT NULL,
  `title` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `city`
--

INSERT INTO `city` (`id`, `title`) VALUES
(1, 'Kirov'),
(8, 'Los Angeles'),
(6, 'Minsk'),
(5, 'Moscow'),
(9, 'New York'),
(2, 'Saratov'),
(10, 'Tokio'),
(15, 'Tomsk'),
(7, 'Toronto');

-- --------------------------------------------------------

--
-- Структура таблицы `score`
--

CREATE TABLE `score` (
  `id` int NOT NULL,
  `id_showplace` int NOT NULL,
  `id_traveler` int NOT NULL,
  `score` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `score`
--

INSERT INTO `score` (`id`, `id_showplace`, `id_traveler`, `score`) VALUES
(2, 5, 2, 4),
(3, 3, 2, 3),
(4, 3, 1, 4),
(5, 3, 5, 5),
(9, 2, 1, 4),
(10, 2, 2, 4),
(22, 1, 2, 4),
(23, 1, 3, 4),
(24, 1, 4, 4),
(25, 1, 5, 2),
(32, 1, 6, 2),
(41, 1, 8, 3),
(42, 1, 9, 3),
(44, 1, 10, 3),
(45, 1, 11, 5),
(47, 4, 11, 3),
(48, 5, 10, 3),
(50, 7, 9, 4),
(51, 8, 8, 4),
(53, 9, 6, 4),
(54, 10, 6, 4),
(55, 11, 6, 4),
(56, 12, 6, 4),
(57, 12, 10, 5);

-- --------------------------------------------------------

--
-- Структура таблицы `showplace`
--

CREATE TABLE `showplace` (
  `id` int NOT NULL,
  `id_city` int NOT NULL,
  `title` varchar(128) COLLATE utf8mb4_general_ci NOT NULL,
  `distance` float DEFAULT NULL,
  `avg_score` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `showplace`
--

INSERT INTO `showplace` (`id`, `id_city`, `title`, `distance`, `avg_score`) VALUES
(1, 1, 'Theatre square', 1.3, 3.33),
(2, 2, 'Набережная Космонавтов', 2, 4),
(3, 9, 'Times Square', 14, 3),
(4, 9, 'Statue of Liberty', 3.68, 3),
(5, 1, 'Park of Victory', 2.5, 3.5),
(7, 6, 'Independence Hall', 2.3, 4),
(8, 6, 'Church of Saints Simon and Helena', 1.7, 4),
(9, 6, 'Национальная библиотека Беларуси', 5.3, 4),
(10, 5, 'Red Square', 0.5, 4),
(11, 5, 'Moscow Kremlin', 0.5, 4),
(12, 5, 'Bolshoi Theatre', 1.5, 4.5);

-- --------------------------------------------------------

--
-- Структура таблицы `traveler`
--

CREATE TABLE `traveler` (
  `id` int NOT NULL,
  `name` varchar(128) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `traveler`
--

INSERT INTO `traveler` (`id`, `name`) VALUES
(1, 'Ivan'),
(2, 'Andrey'),
(3, 'Jhon'),
(4, 'Samanta'),
(5, 'Viktor'),
(6, 'Mary'),
(8, 'Rich'),
(9, 'Vladimir'),
(10, 'Mia'),
(11, 'Alex');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `city`
--
ALTER TABLE `city`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`title`);

--
-- Индексы таблицы `score`
--
ALTER TABLE `score`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_showplace` (`id_showplace`),
  ADD KEY `id_traveler` (`id_traveler`);

--
-- Индексы таблицы `showplace`
--
ALTER TABLE `showplace`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_city` (`id_city`);

--
-- Индексы таблицы `traveler`
--
ALTER TABLE `traveler`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `city`
--
ALTER TABLE `city`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT для таблицы `score`
--
ALTER TABLE `score`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT для таблицы `showplace`
--
ALTER TABLE `showplace`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT для таблицы `traveler`
--
ALTER TABLE `traveler`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `score`
--
ALTER TABLE `score`
  ADD CONSTRAINT `score_ibfk_1` FOREIGN KEY (`id_showplace`) REFERENCES `showplace` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `score_ibfk_2` FOREIGN KEY (`id_traveler`) REFERENCES `traveler` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Ограничения внешнего ключа таблицы `showplace`
--
ALTER TABLE `showplace`
  ADD CONSTRAINT `showplace_ibfk_1` FOREIGN KEY (`id_city`) REFERENCES `city` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
