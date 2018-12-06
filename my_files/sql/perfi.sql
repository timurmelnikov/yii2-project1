-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Авг 30 2017 г., 12:41
-- Версия сервера: 10.1.24-MariaDB
-- Версия PHP: 7.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `perfi`
--

-- --------------------------------------------------------

--
-- Структура таблицы `db1_account`
--

CREATE TABLE `db1_account` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL COMMENT 'Наименование',
  `current_sum` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT 'Текущая сумма',
  `state` tinyint(1) NOT NULL COMMENT 'Состояние (0-действуюший, 1-Закрытый)',
  `user_id` int(11) NOT NULL COMMENT 'Пользователь'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Счета';

--
-- Дамп данных таблицы `db1_account`
--

INSERT INTO `db1_account` (`id`, `name`, `current_sum`, `state`, `user_id`) VALUES
(1, 'Карточка FidoBank', '1902.00', 0, 2),
(2, 'Карточка Приват', '0.00', 1, 2),
(3, 'Наличные', '2004.56', 0, 2),
(4, 'Карточка Приват', '80.00', 0, 3),
(5, 'Наличные', '700.00', 0, 3),
(6, 'Наличные', '100.00', 0, 8);

-- --------------------------------------------------------

--
-- Структура таблицы `db1_account_move`
--

CREATE TABLE `db1_account_move` (
  `id` int(11) NOT NULL,
  `account_from` int(11) NOT NULL COMMENT 'Со счета',
  `account_to` int(11) NOT NULL COMMENT 'На счет',
  `move_sum` decimal(10,2) NOT NULL COMMENT 'Перемещаемая сумма',
  `date_oper` date NOT NULL COMMENT 'Дата операции',
  `user_id` int(11) NOT NULL COMMENT 'Пользователь',
  `description` varchar(200) DEFAULT NULL COMMENT 'Описание'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Перемещения';

--
-- Дамп данных таблицы `db1_account_move`
--

INSERT INTO `db1_account_move` (`id`, `account_from`, `account_to`, `move_sum`, `date_oper`, `user_id`, `description`) VALUES
(4, 1, 2, '22.00', '2015-07-25', 2, ''),
(5, 1, 5, '100.00', '2015-07-25', 2, ''),
(6, 2, 3, '85.21', '2015-07-28', 2, ''),
(7, 4, 3, '10.00', '2015-07-30', 3, ''),
(8, 1, 3, '0.01', '2017-08-19', 2, '3333');

-- --------------------------------------------------------

--
-- Структура таблицы `db1_auth_assignment`
--

CREATE TABLE `db1_auth_assignment` (
  `item_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Таблица для RBAC';

--
-- Дамп данных таблицы `db1_auth_assignment`
--

INSERT INTO `db1_auth_assignment` (`item_name`, `user_id`, `created_at`) VALUES
('admin', '1', 1439889952),
('admin', '2', 1502280268),
('admin', '3', 1504074051),
('show_all', '1', 1439889951),
('show_all', '2', 1502371960),
('show_all', '3', 1458139514),
('user', '1', 1439889953),
('user', '2', 1502179449),
('user', '3', 1458139511),
('user', '8', 1458569740);

-- --------------------------------------------------------

--
-- Структура таблицы `db1_auth_item`
--

CREATE TABLE `db1_auth_item` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `type` int(11) NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `rule_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` text COLLATE utf8_unicode_ci,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Таблица для RBAC';

--
-- Дамп данных таблицы `db1_auth_item`
--

INSERT INTO `db1_auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`) VALUES
('admin', 1, 'Администратор', NULL, NULL, 1438842221, 1438842221),
('show_all', 1, 'Просмотр всех', NULL, NULL, 1439294547, 1439294547),
('user', 1, 'Пользователь', NULL, NULL, 1438842221, 1438842221);

-- --------------------------------------------------------

--
-- Структура таблицы `db1_auth_item_child`
--

CREATE TABLE `db1_auth_item_child` (
  `parent` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `child` varchar(64) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Таблица для RBAC';

-- --------------------------------------------------------

--
-- Структура таблицы `db1_auth_rule`
--

CREATE TABLE `db1_auth_rule` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `data` text COLLATE utf8_unicode_ci,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Таблица для RBAC';

-- --------------------------------------------------------

--
-- Структура таблицы `db1_currency`
--

CREATE TABLE `db1_currency` (
  `id` int(11) NOT NULL,
  `name` varchar(3) NOT NULL COMMENT 'Наименование',
  `fullname` varchar(100) NOT NULL COMMENT 'Полное наименование',
  `code` varchar(3) NOT NULL COMMENT 'Код'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Валюты';

--
-- Дамп данных таблицы `db1_currency`
--

INSERT INTO `db1_currency` (`id`, `name`, `fullname`, `code`) VALUES
(1, 'USD', 'Доллар США', '840'),
(2, 'EUR', 'Евро', '978'),
(3, 'RUB', 'Российский рубль', '643');

-- --------------------------------------------------------

--
-- Структура таблицы `db1_currency_exchange`
--

CREATE TABLE `db1_currency_exchange` (
  `id` int(11) NOT NULL,
  `currency_id` int(11) NOT NULL COMMENT 'Валюта',
  `start_date` date NOT NULL COMMENT 'Дата начала',
  `number_units` int(11) NOT NULL COMMENT 'Количество единиц',
  `official_exchange` decimal(10,4) NOT NULL COMMENT 'Официальный курс'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Курсы валют';

--
-- Дамп данных таблицы `db1_currency_exchange`
--

INSERT INTO `db1_currency_exchange` (`id`, `currency_id`, `start_date`, `number_units`, `official_exchange`) VALUES
(3, 1, '2015-07-17', 100, '2198.6687'),
(4, 2, '2015-07-17', 100, '2389.2933'),
(6, 3, '2015-07-17', 10, '3.8607'),
(7, 1, '2015-07-18', 100, '2201.4924'),
(8, 3, '2015-07-20', 10, '3.8766'),
(9, 1, '2015-07-20', 100, '2203.2134'),
(10, 2, '2015-07-20', 100, '2390.9272'),
(14, 1, '2015-07-21', 100, '2203.2134'),
(16, 3, '2015-07-21', 10, '3.8766'),
(17, 2, '2015-07-21', 100, '2390.9272'),
(18, 1, '2015-07-25', 100, '2207.3520'),
(19, 1, '2015-07-27', 100, '2207.3520'),
(20, 2, '2015-07-27', 100, '2414.6224'),
(21, 3, '2015-07-27', 10, '3.8033'),
(22, 1, '2015-07-28', 100, '2206.2278'),
(23, 2, '2015-07-28', 100, '2439.6467'),
(24, 3, '2015-07-28', 10, '3.7533'),
(25, 1, '2015-12-11', 100, '2386.0094'),
(26, 1, '2015-12-13', 100, '2386.0094'),
(27, 1, '2015-12-19', 100, '2354.6414'),
(28, 3, '2016-02-14', 10, '3.2892'),
(29, 2, '2016-02-14', 100, '2948.1227'),
(30, 1, '2016-02-15', 100, '2614.7430'),
(31, 2, '2016-02-15', 100, '2948.1227'),
(32, 3, '2016-02-15', 10, '3.2892'),
(33, 1, '2016-02-16', 100, '2681.8080'),
(34, 2, '2016-02-16', 100, '2998.2613'),
(35, 3, '2016-02-16', 10, '3.4480'),
(36, 3, '2016-02-23', 10, '3.5023'),
(37, 1, '2016-02-23', 100, '2701.4507'),
(38, 2, '2016-02-23', 100, '2978.6195'),
(39, 1, '2016-02-24', 100, '2723.3858'),
(40, 2, '2016-02-24', 100, '2996.2691'),
(41, 3, '2016-02-24', 10, '3.5308'),
(42, 1, '2016-03-10', 100, '2618.2756'),
(44, 3, '2016-03-10', 10, '3.6175'),
(49, 1, '2017-08-19', 100, '2549.0401');

-- --------------------------------------------------------

--
-- Структура таблицы `db1_expense`
--

CREATE TABLE `db1_expense` (
  `id` int(11) NOT NULL,
  `cost` decimal(10,2) NOT NULL COMMENT 'Сумма расхода',
  `unit_id` int(11) NOT NULL COMMENT 'Единица измерения',
  `count_unit` decimal(10,2) NOT NULL COMMENT 'Количество',
  `expense_category_id` int(11) NOT NULL COMMENT 'Категория расходов',
  `description` varchar(200) DEFAULT NULL COMMENT 'Описание',
  `date_oper` date NOT NULL COMMENT 'Дата операции',
  `user_id` int(11) NOT NULL COMMENT 'Пользователь',
  `account_id` int(11) NOT NULL COMMENT 'Счет'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Расходы';

--
-- Дамп данных таблицы `db1_expense`
--

INSERT INTO `db1_expense` (`id`, `cost`, `unit_id`, `count_unit`, `expense_category_id`, `description`, `date_oper`, `user_id`, `account_id`) VALUES
(39, '1.00', 5, '1.00', 92, '', '2015-07-22', 2, 2),
(40, '3.00', 5, '1.00', 90, '', '2015-07-23', 2, 2),
(41, '33.00', 5, '1.00', 90, '', '2015-07-23', 2, 2),
(44, '3.00', 2, '700.00', 161, '', '2015-07-24', 2, 3),
(45, '10.00', 2, '200.00', 99, '', '2015-07-24', 2, 3),
(46, '150.00', 1, '1.00', 89, '', '2015-07-27', 2, 3),
(48, '40.00', 2, '800.00', 150, '', '2015-07-27', 2, 1),
(50, '10.00', 2, '200.00', 99, 'Хек', '2015-07-28', 2, 3),
(51, '150.00', 1, '1.00', 89, '', '2015-07-28', 2, 2),
(52, '3.00', 10, '1.00', 94, 'Проезд на транспорте', '2015-07-28', 2, 3),
(53, '150.00', 1, '1.00', 89, '', '2015-07-28', 2, 3),
(54, '3.00', 10, '1.00', 94, 'Проезд в маршрутке', '2015-07-28', 2, 3),
(55, '12.50', 5, '1.00', 83, '', '2015-07-29', 2, 1),
(56, '13.99', 5, '1.00', 83, 'Сильпо', '2015-07-30', 3, 4),
(59, '7.50', 2, '1000.00', 161, 'truytryrt', '2015-12-20', 2, 3),
(60, '46.50', 5, '1.00', 143, 'NIVEA', '2016-02-24', 2, 1),
(61, '36.99', 11, '3.00', 149, 'Гурманика', '2016-02-24', 2, 1),
(64, '4.00', 10, '1.00', 164, '', '2016-02-26', 8, 6),
(65, '3.00', 10, '1.00', 166, '', '2016-02-26', 8, 6),
(66, '30.00', 1, '1.00', 141, '', '2016-02-26', 8, 6),
(69, '0.01', 1, '1.00', 112, '21312', '2017-08-19', 2, 1),
(70, '0.01', 1, '1.00', 93, 'etrtert', '2017-08-19', 2, 1),
(71, '1.11', 1, '1.00', 143, '23423', '2017-08-19', 2, 3),
(72, '0.22', 1, '1.00', 72, '321423423', '2017-08-19', 2, 1),
(73, '0.66', 1, '1.00', 143, '4545', '2017-08-19', 2, 3),
(74, '4.44', 1, '1.00', 93, '34343343', '2017-08-19', 2, 3),
(75, '33.33', 1, '1.00', 196, '32423423', '2017-08-19', 2, 3),
(76, '3.00', 10, '1.00', 94, 'Проезд в маршрутке (по городу)555', '2017-08-19', 2, 3);

-- --------------------------------------------------------

--
-- Структура таблицы `db1_expense_category`
--

CREATE TABLE `db1_expense_category` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) DEFAULT NULL COMMENT 'Родительская категория',
  `path` text NOT NULL COMMENT 'Путь',
  `name` varchar(20) NOT NULL COMMENT 'Наименование'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Категории расходов';

--
-- Дамп данных таблицы `db1_expense_category`
--

INSERT INTO `db1_expense_category` (`id`, `parent_id`, `path`, `name`) VALUES
(0, 0, '', 'Кореневая'),
(60, 0, '0', 'Продукты питания'),
(61, 0, '0', 'Хоз. расходы'),
(62, 0, '0', 'Услуги связи'),
(63, 0, '0', 'Развлечения'),
(72, 0, '0', 'Гигиена'),
(77, 0, '0', 'Здоровье'),
(82, 0, '0', 'Коммунальные услуги'),
(83, 60, '0.60', 'Хлеб'),
(84, 60, '0.60', 'Овощи'),
(85, 83, '0.60.83', 'Булки'),
(89, 62, '0.62', 'Интернет'),
(90, 72, '0.72', 'Зубная паста'),
(91, 72, '0.72', 'Шампунь'),
(92, 72, '0.72', 'Мыло'),
(93, 72, '0.72', 'Зубная шетка'),
(94, 0, '0', 'Транспорт'),
(95, 94, '0.94', 'Такси'),
(96, 94, '0.94', 'Маршрутка'),
(97, 94, '0.94', 'Железная дорога'),
(98, 60, '0.60', 'Мясные продукты'),
(99, 60, '0.60', 'Рыбные продукты'),
(103, 62, '0.62', 'Мобильная связь'),
(104, 62, '0.62', 'Телефон'),
(108, 61, '0.61', 'Дача'),
(109, 94, '0.94', 'Нерегулярн. перевоз.'),
(110, 82, '0.82', 'Газ'),
(111, 82, '0.82', 'Электроэнергия'),
(112, 82, '0.82', 'Вода'),
(113, 82, '0.82', 'Мусор'),
(114, 77, '0.77', 'Лекарства'),
(116, 60, '0.60', 'Молокопродукты'),
(119, 77, '0.77', 'Услуги врача'),
(120, 108, '0.61.108', 'Удобрения'),
(122, 63, '0.63', 'Ресторан'),
(141, 103, '0.62.103', 'Vodafone (МТС)'),
(142, 108, '0.61.108', 'Инструмент'),
(143, 72, '0.72', 'Дезодорант'),
(144, 72, '0.72', 'Прокладки'),
(145, 116, '0.60.116', 'Молоко'),
(146, 116, '0.60.116', 'Сметана'),
(147, 116, '0.60.116', 'Кефир'),
(148, 116, '0.60.116', 'Ряженка'),
(149, 116, '0.60.116', 'Йогурт'),
(150, 116, '0.60.116', 'Сыр твердый'),
(151, 116, '0.60.116', 'Сыр плавленый'),
(152, 83, '0.60.83', 'Хлеб белый'),
(153, 83, '0.60.83', 'Хлеб черный'),
(154, 98, '0.60.98', 'Мясо говяжье'),
(155, 98, '0.60.98', 'Мясо свинное'),
(156, 98, '0.60.98', 'Колбаса копченая'),
(157, 98, '0.60.98', 'Колбаса вареная'),
(158, 99, '0.60.99', 'Рыба свежая'),
(159, 99, '0.60.99', 'Рыба копченая'),
(160, 84, '0.60.84', 'Лук'),
(161, 84, '0.60.84', 'Картошка'),
(162, 63, '0.63', 'Театр'),
(163, 63, '0.63', 'Пикник'),
(164, 94, '0.94', 'Метро'),
(165, 94, '0.94', 'Автобус'),
(166, 94, '0.94', 'Трамвай'),
(167, 94, '0.94', 'Троллейбус'),
(168, 94, '0.94', 'Электричка'),
(169, 60, '0.60', 'Сладости'),
(170, 169, '0.60.169', 'Шоколад'),
(171, 169, '0.60.169', 'Печенье'),
(172, 169, '0.60.169', 'Пирожные'),
(173, 60, '0.60', 'Напитки'),
(174, 173, '0.60.173', 'Кофе'),
(175, 173, '0.60.173', 'Чай'),
(176, 173, '0.60.173', 'Минеральная вода'),
(177, 173, '0.60.173', 'Сок'),
(178, 173, '0.60.173', 'Газированные напитки'),
(179, 83, '0.60.83', 'Лаваш'),
(180, 103, '0.62.103', 'Kyivstar (Киевстар)'),
(181, 103, '0.62.103', 'Lifecell (Лайф)'),
(182, 84, '0.60.84', 'Морковь'),
(183, 84, '0.60.84', 'Капуста'),
(184, 84, '0.60.84', 'Зелень'),
(185, 84, '0.60.84', 'Свекла'),
(186, 84, '0.60.84', 'Редис'),
(187, 99, '0.60.99', 'Консервы рыбные'),
(188, 99, '0.60.99', 'Икра красная'),
(189, 99, '0.60.99', 'Икра других рыб'),
(190, 60, '0.60', 'Алкоголь'),
(191, 190, '0.60.190', 'Вино'),
(192, 190, '0.60.190', 'Водка'),
(193, 190, '0.60.190', 'Пиво'),
(194, 190, '0.60.190', 'Коньяк'),
(195, 173, '0.60.173', 'Пиво (без алк.)'),
(196, 98, '0.60.98', 'Сало'),
(197, 98, '0.60.98', 'Бекон'),
(198, 98, '0.60.98', 'Консервы мясные'),
(200, 0, '0', '4324234');

-- --------------------------------------------------------

--
-- Структура таблицы `db1_expense_template`
--

CREATE TABLE `db1_expense_template` (
  `id` int(11) NOT NULL,
  `cost` decimal(10,2) NOT NULL COMMENT 'Сумма расхода',
  `unit_id` int(11) NOT NULL COMMENT 'Единица измерения',
  `count_unit` decimal(10,2) NOT NULL COMMENT 'Количество',
  `expense_category_id` int(11) NOT NULL COMMENT 'Категория расходов',
  `description` varchar(200) DEFAULT NULL COMMENT 'Описание',
  `user_id` int(11) NOT NULL COMMENT 'Пользователь',
  `account_id` int(11) NOT NULL COMMENT 'Счет',
  `name` varchar(50) NOT NULL COMMENT 'Наименование'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Шаблоны расходов';

--
-- Дамп данных таблицы `db1_expense_template`
--

INSERT INTO `db1_expense_template` (`id`, `cost`, `unit_id`, `count_unit`, `expense_category_id`, `description`, `user_id`, `account_id`, `name`) VALUES
(43, '3.00', 10, '1.00', 94, 'Проезд в маршрутке (по городу)555', 2, 3, 'Проезд в маршрутке'),
(45, '150.00', 1, '1.00', 89, '', 3, 2, 'Интернет'),
(47, '3.00', 10, '1.00', 94, 'Проезд в маршрутке', 3, 3, 'Транспорт'),
(48, '175.00', 1, '1.00', 164, 'Пополнение карты Метро на месяц', 2, 3, 'Пополнение карты Метро'),
(50, '7.50', 2, '1000.00', 161, '', 2, 3, 'Картошка'),
(51, '3.00', 10, '1.00', 166, '', 2, 6, 'Трамвай'),
(52, '4.00', 10, '1.00', 164, '', 2, 6, 'Метро'),
(54, '36.99', 11, '3.00', 149, 'Гурманика', 2, 1, 'Йогурт'),
(55, '0.05', 2, '1.01', 143, '', 2, 1, 'fhf'),
(56, '0.01', 1, '1.00', 93, '', 2, 1, 'Зубная шетка'),
(57, '0.22', 1, '1.00', 72, '321423423', 2, 1, 'Гигиена');

-- --------------------------------------------------------

--
-- Структура таблицы `db1_income`
--

CREATE TABLE `db1_income` (
  `id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL COMMENT 'Сумма дохода',
  `income_category_id` int(11) NOT NULL COMMENT 'Категория доходов',
  `date_oper` date NOT NULL COMMENT 'Дата операции',
  `user_id` int(11) NOT NULL COMMENT 'Пользователь',
  `account_id` int(11) NOT NULL COMMENT 'Счет'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Доходы';

--
-- Дамп данных таблицы `db1_income`
--

INSERT INTO `db1_income` (`id`, `amount`, `income_category_id`, `date_oper`, `user_id`, `account_id`) VALUES
(3, '100.00', 3, '2015-01-01', 3, 2),
(6, '600.00', 12, '2015-07-24', 3, 5),
(8, '1000.00', 6, '2015-07-24', 2, 2),
(9, '1500.00', 3, '2015-07-28', 2, 1),
(10, '2000.00', 6, '2015-07-28', 2, 3),
(11, '1.11', 4, '2017-08-19', 2, 1),
(12, '2.22', 4, '2017-08-19', 2, 1),
(13, '0.21', 4, '2017-08-19', 2, 3),
(14, '0.44', 4, '2017-08-19', 2, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `db1_income_category`
--

CREATE TABLE `db1_income_category` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL COMMENT 'Пользователь',
  `name` varchar(50) NOT NULL COMMENT 'Наименование',
  `account_id` int(11) NOT NULL COMMENT 'Счет по умолчанию'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Категории доходов';

--
-- Дамп данных таблицы `db1_income_category`
--

INSERT INTO `db1_income_category` (`id`, `user_id`, `name`, `account_id`) VALUES
(3, 2, 'Зарплата', 3),
(4, 2, 'Аванс', 1),
(5, 2, 'Конверт', 2),
(6, 2, 'Калым', 2),
(7, 3, 'Аванс', 4),
(12, 3, 'Зарплата', 4);

-- --------------------------------------------------------

--
-- Структура таблицы `db1_migration`
--

CREATE TABLE `db1_migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `db1_migration`
--

INSERT INTO `db1_migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1502693288),
('m170812_064905_shopping_list', 1502693298),
('m170812_064906_Relations', 1502693299),
('m170812_064936_shopping_list_item', 1502693299),
('m170812_064937_Relations', 1502693299);

-- --------------------------------------------------------

--
-- Структура таблицы `db1_setting`
--

CREATE TABLE `db1_setting` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL COMMENT 'Пользователь',
  `setting_parametr_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL COMMENT 'Наименование',
  `unit_code` varchar(20) NOT NULL COMMENT 'Код раздела',
  `setting_code` varchar(25) NOT NULL COMMENT 'Код настройки'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Настройки';

--
-- Дамп данных таблицы `db1_setting`
--

INSERT INTO `db1_setting` (`id`, `user_id`, `setting_parametr_id`, `name`, `unit_code`, `setting_code`) VALUES
(2, 2, 1, 'Счет по умолчанию', '', ''),
(3, 2, 2, 'Единица измерения по умолчанию', '', ''),
(4, 3, 1, 'Количество записей в гриде', '', ''),
(5, 3, 2, 'Настройка 1', '', '');

-- --------------------------------------------------------

--
-- Структура таблицы `db1_setting_parametr`
--

CREATE TABLE `db1_setting_parametr` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL COMMENT 'Наименование'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Параметры настроек';

--
-- Дамп данных таблицы `db1_setting_parametr`
--

INSERT INTO `db1_setting_parametr` (`id`, `name`) VALUES
(1, 'Количество записей в гриде'),
(2, 'Счет по умолчанию');

-- --------------------------------------------------------

--
-- Структура таблицы `db1_shopping_list`
--

CREATE TABLE `db1_shopping_list` (
  `id` int(11) NOT NULL,
  `date_list` date NOT NULL COMMENT 'Дата листа',
  `name` varchar(50) NOT NULL COMMENT 'Наименование',
  `user_from` int(11) NOT NULL COMMENT 'От пользователя',
  `user_to` int(11) NOT NULL COMMENT 'Пользователю'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `db1_shopping_list`
--

INSERT INTO `db1_shopping_list` (`id`, `date_list`, `name`, `user_from`, `user_to`) VALUES
(5, '2017-08-07', 'Список № 1', 2, 3),
(6, '2017-08-30', 'Список АТБ', 3, 2),
(7, '2017-08-30', 'Купить на пикник', 8, 2),
(8, '2017-08-30', 'Список покупок от 30.08.2017', 3, 2);

-- --------------------------------------------------------

--
-- Структура таблицы `db1_shopping_list_item`
--

CREATE TABLE `db1_shopping_list_item` (
  `id` int(11) NOT NULL,
  `shopping_list_id` int(11) NOT NULL COMMENT 'Список покупок',
  `description` varchar(200) NOT NULL COMMENT 'Описание'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `db1_unit`
--

CREATE TABLE `db1_unit` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL COMMENT 'Наименование',
  `fullname` varchar(100) NOT NULL COMMENT 'Полное наименование'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Единицы измерения';

--
-- Дамп данных таблицы `db1_unit`
--

INSERT INTO `db1_unit` (`id`, `name`, `fullname`) VALUES
(1, 'опер', 'Операция'),
(2, 'г', 'Грамм'),
(3, 'м', 'Метр'),
(4, 'пач', 'Пачка'),
(5, 'шт', 'Штука'),
(6, 'м2', 'Метр квадратный'),
(9, 'кг', 'Килограмм'),
(10, 'проезд', 'Проезд'),
(11, 'бан', 'Банка');

-- --------------------------------------------------------

--
-- Структура таблицы `db1_user`
--

CREATE TABLE `db1_user` (
  `id` int(11) NOT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `fullname` varchar(255) DEFAULT NULL COMMENT 'Полное имя',
  `username` varchar(255) NOT NULL COMMENT 'Имя пользователя',
  `auth_key` varchar(32) DEFAULT NULL,
  `email_confirm_token` varchar(255) DEFAULT NULL,
  `password_hash` varchar(255) NOT NULL COMMENT 'Хеш пароля',
  `password_reset_token` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL COMMENT 'E-mail',
  `state` smallint(6) NOT NULL DEFAULT '0' COMMENT 'Состояние'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Пользователи системы';

--
-- Дамп данных таблицы `db1_user`
--

INSERT INTO `db1_user` (`id`, `created_at`, `updated_at`, `fullname`, `username`, `auth_key`, `email_confirm_token`, `password_hash`, `password_reset_token`, `email`, `state`) VALUES
(1, 1429777037, 1438175197, 'Супер пользователь системы', 'root', '0ZIG7OZCKEOR7JyE20g0Rh-R_NVlipex', NULL, '$2y$13$NVfh/naxh8QWQtMeTeumjOzcqGaGm6uNHwXpbzyjj5rWJejqyI4I.', NULL, 'admin@ukr.net', 0),
(2, 1429777037, 1438175211, 'Мельников Тимур Викторович', 'timur', 'b8HKw5Lt3NqQQxw1Ly1L2jkH2N7B1ZR4', NULL, '$2y$13$KFS/bKU0RZjBDv49ePch2OlepQqDGlEPmRhxZEoSYwGwBEHRXl0pu', NULL, 'timur@ukr.net', 0),
(3, 1429777037, 1438238903, 'Мельников Беатриса Леонидовна', 'beata', 'xotK69FcZqF5LKRrK4bNGawddzqAzSSQ', NULL, '$2y$13$vXZ2pkOxCm4xL9u27Uks9eaWHtzDgqMW144lmgVOgDjXk3w3utK0m', NULL, 'beata@ukr.net', 0),
(8, 1429777037, 1438175252, 'Морозова Даша', 'dasha', 'd4-Xo9XcUIptBQZz4aw4KNphHOgk0YV6', NULL, '$2y$13$hwH2t9ZTVz3WjzPth08LAuw1KIk/0wEGCnZzhwCu2DZmwWSQ8fDce', NULL, 'dasha@ukr.net', 0),
(10, 1503133882, 1503135307, 'укцкцук', 'цукцукцу', '4cqInJ9mIJh7-h03X5qcREqKI0dPC6h4', NULL, '$2y$13$RCBQq91EVfNfIfhbbVahKOYxA/oM54UEYmkxnmrf7DdVkEWNW9UCO', NULL, 'rrrr5555r@gdfgd.rr', 0);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `db1_account`
--
ALTER TABLE `db1_account`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_user_id` (`user_id`);

--
-- Индексы таблицы `db1_account_move`
--
ALTER TABLE `db1_account_move`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_user_id` (`user_id`),
  ADD KEY `idx_account_from` (`account_from`),
  ADD KEY `idx_account_to` (`account_to`);

--
-- Индексы таблицы `db1_auth_assignment`
--
ALTER TABLE `db1_auth_assignment`
  ADD PRIMARY KEY (`item_name`,`user_id`);

--
-- Индексы таблицы `db1_auth_item`
--
ALTER TABLE `db1_auth_item`
  ADD PRIMARY KEY (`name`),
  ADD KEY `idx_rule_name` (`rule_name`),
  ADD KEY `idx_type` (`type`) USING BTREE;

--
-- Индексы таблицы `db1_auth_item_child`
--
ALTER TABLE `db1_auth_item_child`
  ADD PRIMARY KEY (`parent`,`child`),
  ADD KEY `idx_child` (`child`);

--
-- Индексы таблицы `db1_auth_rule`
--
ALTER TABLE `db1_auth_rule`
  ADD PRIMARY KEY (`name`);

--
-- Индексы таблицы `db1_currency`
--
ALTER TABLE `db1_currency`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `db1_currency_exchange`
--
ALTER TABLE `db1_currency_exchange`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idx_currency_exchange_uniq` (`currency_id`,`start_date`) USING BTREE,
  ADD KEY `idx_currency_id` (`currency_id`) USING BTREE;

--
-- Индексы таблицы `db1_expense`
--
ALTER TABLE `db1_expense`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_user_id` (`user_id`),
  ADD KEY `idx_account_id` (`account_id`),
  ADD KEY `idx_unit_id` (`unit_id`),
  ADD KEY `idx_expense_category_id` (`expense_category_id`) USING BTREE;

--
-- Индексы таблицы `db1_expense_category`
--
ALTER TABLE `db1_expense_category`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idx_name` (`name`),
  ADD KEY `idx_parent_id` (`parent_id`);

--
-- Индексы таблицы `db1_expense_template`
--
ALTER TABLE `db1_expense_template`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idx_expense_template_uniq_1` (`user_id`,`name`) USING BTREE,
  ADD UNIQUE KEY `idx_expense_template_uniq_2` (`cost`,`expense_category_id`,`description`,`user_id`,`account_id`) USING BTREE,
  ADD KEY `idx_user_id` (`user_id`),
  ADD KEY `idx_account_id` (`account_id`),
  ADD KEY `idx_unit_id` (`unit_id`),
  ADD KEY `idx_expense_category_id` (`expense_category_id`) USING BTREE;

--
-- Индексы таблицы `db1_income`
--
ALTER TABLE `db1_income`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_user_id` (`user_id`),
  ADD KEY `idx_account_id` (`account_id`),
  ADD KEY `idx_income_category_id` (`income_category_id`) USING BTREE;

--
-- Индексы таблицы `db1_income_category`
--
ALTER TABLE `db1_income_category`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idx_income_category_uniq` (`name`,`user_id`) USING BTREE,
  ADD KEY `idx_user_id` (`user_id`),
  ADD KEY `idx_account_id` (`account_id`) USING BTREE;

--
-- Индексы таблицы `db1_migration`
--
ALTER TABLE `db1_migration`
  ADD PRIMARY KEY (`version`);

--
-- Индексы таблицы `db1_setting`
--
ALTER TABLE `db1_setting`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idx_setting_uniq` (`user_id`,`setting_parametr_id`),
  ADD KEY `idx_user_id` (`user_id`),
  ADD KEY `idx_setting_parametr_id` (`setting_parametr_id`) USING BTREE;

--
-- Индексы таблицы `db1_setting_parametr`
--
ALTER TABLE `db1_setting_parametr`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `db1_shopping_list`
--
ALTER TABLE `db1_shopping_list`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_user_from` (`user_from`),
  ADD KEY `idx_user_to` (`user_to`);

--
-- Индексы таблицы `db1_shopping_list_item`
--
ALTER TABLE `db1_shopping_list_item`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_shopping_list_id` (`shopping_list_id`);

--
-- Индексы таблицы `db1_unit`
--
ALTER TABLE `db1_unit`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idx_name` (`name`);

--
-- Индексы таблицы `db1_user`
--
ALTER TABLE `db1_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_username` (`username`) USING BTREE,
  ADD KEY `idx_status` (`state`) USING BTREE,
  ADD KEY `idx_email` (`email`) USING BTREE;

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `db1_account`
--
ALTER TABLE `db1_account`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT для таблицы `db1_account_move`
--
ALTER TABLE `db1_account_move`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT для таблицы `db1_currency`
--
ALTER TABLE `db1_currency`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT для таблицы `db1_currency_exchange`
--
ALTER TABLE `db1_currency_exchange`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;
--
-- AUTO_INCREMENT для таблицы `db1_expense`
--
ALTER TABLE `db1_expense`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;
--
-- AUTO_INCREMENT для таблицы `db1_expense_category`
--
ALTER TABLE `db1_expense_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=201;
--
-- AUTO_INCREMENT для таблицы `db1_expense_template`
--
ALTER TABLE `db1_expense_template`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;
--
-- AUTO_INCREMENT для таблицы `db1_income`
--
ALTER TABLE `db1_income`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT для таблицы `db1_income_category`
--
ALTER TABLE `db1_income_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT для таблицы `db1_setting`
--
ALTER TABLE `db1_setting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT для таблицы `db1_setting_parametr`
--
ALTER TABLE `db1_setting_parametr`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT для таблицы `db1_shopping_list`
--
ALTER TABLE `db1_shopping_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT для таблицы `db1_shopping_list_item`
--
ALTER TABLE `db1_shopping_list_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `db1_unit`
--
ALTER TABLE `db1_unit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT для таблицы `db1_user`
--
ALTER TABLE `db1_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `db1_account`
--
ALTER TABLE `db1_account`
  ADD CONSTRAINT `db1_account_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `db1_user` (`id`);

--
-- Ограничения внешнего ключа таблицы `db1_account_move`
--
ALTER TABLE `db1_account_move`
  ADD CONSTRAINT `db1_account_move_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `db1_user` (`id`),
  ADD CONSTRAINT `db1_account_move_ibfk_2` FOREIGN KEY (`account_from`) REFERENCES `db1_account` (`id`),
  ADD CONSTRAINT `db1_account_move_ibfk_3` FOREIGN KEY (`account_to`) REFERENCES `db1_account` (`id`);

--
-- Ограничения внешнего ключа таблицы `db1_auth_assignment`
--
ALTER TABLE `db1_auth_assignment`
  ADD CONSTRAINT `db1_auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `db1_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `db1_auth_item`
--
ALTER TABLE `db1_auth_item`
  ADD CONSTRAINT `db1_auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `db1_auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `db1_auth_item_child`
--
ALTER TABLE `db1_auth_item_child`
  ADD CONSTRAINT `db1_auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `db1_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `db1_auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `db1_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `db1_currency_exchange`
--
ALTER TABLE `db1_currency_exchange`
  ADD CONSTRAINT `db1_currency_exchange_ibfk_1` FOREIGN KEY (`currency_id`) REFERENCES `db1_currency` (`id`);

--
-- Ограничения внешнего ключа таблицы `db1_expense`
--
ALTER TABLE `db1_expense`
  ADD CONSTRAINT `db1_expense_ibfk_1` FOREIGN KEY (`expense_category_id`) REFERENCES `db1_expense_category` (`id`),
  ADD CONSTRAINT `db1_expense_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `db1_user` (`id`),
  ADD CONSTRAINT `db1_expense_ibfk_3` FOREIGN KEY (`account_id`) REFERENCES `db1_account` (`id`),
  ADD CONSTRAINT `db1_expense_ibfk_4` FOREIGN KEY (`unit_id`) REFERENCES `db1_unit` (`id`);

--
-- Ограничения внешнего ключа таблицы `db1_expense_category`
--
ALTER TABLE `db1_expense_category`
  ADD CONSTRAINT `db1_expense_category_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `db1_expense_category` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `db1_expense_template`
--
ALTER TABLE `db1_expense_template`
  ADD CONSTRAINT `db1_expense_template_ibfk_1` FOREIGN KEY (`expense_category_id`) REFERENCES `db1_expense_category` (`id`),
  ADD CONSTRAINT `db1_expense_template_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `db1_user` (`id`),
  ADD CONSTRAINT `db1_expense_template_ibfk_3` FOREIGN KEY (`account_id`) REFERENCES `db1_account` (`id`),
  ADD CONSTRAINT `db1_expense_template_ibfk_4` FOREIGN KEY (`unit_id`) REFERENCES `db1_unit` (`id`);

--
-- Ограничения внешнего ключа таблицы `db1_income`
--
ALTER TABLE `db1_income`
  ADD CONSTRAINT `db1_income_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `db1_user` (`id`),
  ADD CONSTRAINT `db1_income_ibfk_2` FOREIGN KEY (`income_category_id`) REFERENCES `db1_income_category` (`id`),
  ADD CONSTRAINT `db1_income_ibfk_3` FOREIGN KEY (`account_id`) REFERENCES `db1_account` (`id`);

--
-- Ограничения внешнего ключа таблицы `db1_income_category`
--
ALTER TABLE `db1_income_category`
  ADD CONSTRAINT `db1_income_category_ibfk_1` FOREIGN KEY (`account_id`) REFERENCES `db1_account` (`id`),
  ADD CONSTRAINT `db1_income_category_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `db1_user` (`id`);

--
-- Ограничения внешнего ключа таблицы `db1_setting`
--
ALTER TABLE `db1_setting`
  ADD CONSTRAINT `db1_setting_ibfk_1` FOREIGN KEY (`setting_parametr_id`) REFERENCES `db1_setting_parametr` (`id`),
  ADD CONSTRAINT `db1_setting_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `db1_user` (`id`);

--
-- Ограничения внешнего ключа таблицы `db1_shopping_list`
--
ALTER TABLE `db1_shopping_list`
  ADD CONSTRAINT `fk_db1_shopping_list_user_from` FOREIGN KEY (`user_from`) REFERENCES `db1_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_db1_shopping_list_user_to` FOREIGN KEY (`user_to`) REFERENCES `db1_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `db1_shopping_list_item`
--
ALTER TABLE `db1_shopping_list_item`
  ADD CONSTRAINT `fk_db1_shopping_list_item_shopping_list_id` FOREIGN KEY (`shopping_list_id`) REFERENCES `db1_shopping_list` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
