-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Окт 28 2020 г., 12:56
-- Версия сервера: 5.7.21-20-beget-5.7.21-20-1-log
-- Версия PHP: 5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `martem3s_vse2`
--

-- --------------------------------------------------------

--
-- Структура таблицы `auth_assignment`
--
-- Создание: Окт 04 2020 г., 17:42
-- Последнее обновление: Окт 21 2020 г., 12:09
--

DROP TABLE IF EXISTS `auth_assignment`;
CREATE TABLE `auth_assignment` (
  `item_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `auth_assignment`
--

INSERT INTO `auth_assignment` (`item_name`, `user_id`, `created_at`) VALUES
('admin', '28', 1601832978),
('admin', '29', 1601832978),
('admin', '5', 1600973934),
('editor', '7', 1600973934),
('user', '24', 1601314095),
('user', '30', 1601833708),
('user', '31', 1601834091),
('user', '32', 1601843050),
('user', '33', 1603282196);

-- --------------------------------------------------------

--
-- Структура таблицы `auth_item`
--
-- Создание: Окт 04 2020 г., 17:42
--

DROP TABLE IF EXISTS `auth_item`;
CREATE TABLE `auth_item` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `type` smallint(6) NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `rule_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `auth_item`
--

INSERT INTO `auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`) VALUES
('admin', 1, 'Администратор', NULL, NULL, 1600961395, 1600961395),
('editor', 1, 'Редактор', NULL, NULL, 1600961395, 1600961395),
('manageMessage', 2, 'Просмотр и удаление сообщения', NULL, NULL, 1601499109, 1601499109),
('manageOwnMessage', 2, 'Просмотр и удалние собственного сообщения', 'isAuthor', NULL, 1601499109, 1601499109),
('updateOrder', 2, 'Редактировать заказы', NULL, NULL, 1601408347, 1601408347),
('updateOwnOrder', 2, 'Редактировать свои заказы', 'isAuthor', NULL, 1601408347, 1601408347),
('user', 1, 'Пользователь', NULL, NULL, 1600961395, 1600961395);

-- --------------------------------------------------------

--
-- Структура таблицы `auth_item_child`
--
-- Создание: Окт 04 2020 г., 17:42
--

DROP TABLE IF EXISTS `auth_item_child`;
CREATE TABLE `auth_item_child` (
  `parent` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `child` varchar(64) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `auth_item_child`
--

INSERT INTO `auth_item_child` (`parent`, `child`) VALUES
('admin', 'editor'),
('manageOwnMessage', 'manageMessage'),
('user', 'manageOwnMessage'),
('updateOwnOrder', 'updateOrder'),
('user', 'updateOwnOrder'),
('editor', 'user');

-- --------------------------------------------------------

--
-- Структура таблицы `auth_rule`
--
-- Создание: Окт 04 2020 г., 17:42
--

DROP TABLE IF EXISTS `auth_rule`;
CREATE TABLE `auth_rule` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `auth_rule`
--

INSERT INTO `auth_rule` (`name`, `data`, `created_at`, `updated_at`) VALUES
('isAuthor', 0x4f3a32323a22636f6d6d6f6e5c726261635c417574686f7252756c65223a333a7b733a343a226e616d65223b733a383a226973417574686f72223b733a393a22637265617465644174223b693a313630313430383334373b733a393a22757064617465644174223b693a313630313430383334373b7d, 1601408347, 1601408347);

-- --------------------------------------------------------

--
-- Структура таблицы `category`
--
-- Создание: Окт 09 2020 г., 07:01
--

DROP TABLE IF EXISTS `category`;
CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `background` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `order` int(11) DEFAULT '0',
  `status` tinyint(3) DEFAULT NULL,
  `parent_id` int(11) DEFAULT '0',
  `icon` varchar(255) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `category`
--

INSERT INTO `category` (`id`, `title`, `background`, `url`, `order`, `status`, `parent_id`, `icon`, `created_at`, `updated_at`) VALUES
(1, 'Красота и здоровье', 'main-bg.jpg', 'health-and-beauty', 1, 1, 0, 'fas fa-spa', 1601315249, 1601315249),
(2, 'Недвижимость ', 'main-bg.jpg', 'realty', 2, 1, 0, 'fas fa-city', 1601315420, 1601315420),
(3, 'Автоуслуги, транспорт', 'main-bg.jpg', 'car-services', 3, 1, 0, 'fas fa-car', 1601315509, 1601315509),
(4, 'Грузоперевозки ', 'main-bg.jpg', 'tracking', 4, 1, 0, 'fas fa-truck-moving', 1601315640, 1601315640),
(5, 'Доставка, курьеры', 'main-bg.jpg', 'delivery', 5, 1, 0, 'fas fa-clipboard-list', 1601315703, 1601832682),
(6, 'Ремонт и строительство ', 'remont-kvartir.jpg', 'repair-and-construction', 6, 1, 0, 'fas fa-hammer', 1601315815, 1601315815),
(7, 'Бытовые услуги', 'main-bg.jpg', 'domestic-services', 7, 1, 0, 'typcn typcn-home', 1601315961, 1601315961),
(8, 'Клининг, уборка', 'cleaning.jpg', 'cleaning', 8, 1, 0, 'fas fa-quidditch', 1601316063, 1601316063),
(9, 'Деловые услуги', 'main-bg.jpg', 'business-services', 9, 1, 0, 'fas fa-suitcase', 1601316165, 1601316165),
(10, 'Интернет и IT', 'internet-i-it.jpg', 'internet-and-it', 10, 1, 0, 'fas fa-laptop-code', 1601316261, 1601316261),
(11, 'Маркетинг, реклама ', 'main-bg.jpg', 'marketing', 11, 1, 0, 'fas fa-bullhorn', 1601316402, 1601316402),
(12, 'Дизайн', 'disign-interieara.jpg', 'design', 12, 1, 0, 'fas fa-pencil-ruler', 1601316496, 1601316496),
(13, 'Фото и видеосъемка', 'foto-i-video-siemka.jpg', 'photo-and-video-filming', 13, 1, 0, 'fas fa-camera-retro', 1601316590, 1601543304),
(14, 'Праздники, мероприятия ', 'main-bg.jpg', 'events', 14, 1, 0, 'fas fa-birthday-cake', 1601316712, 1601316712),
(15, 'Ремонт и установка техники ', 'remont-texninki.jpg', 'equipment-repair', 7, 1, 0, 'fas fa-wrench', 1601316864, 1601842963),
(16, 'Для студентов', 'main-bg.jpg', 'for-students', 16, 1, 0, 'fas fa-book', 1601316947, 1601316947),
(17, 'Покупки ', 'main-bg.jpg', 'purchases', 17, 1, 0, 'fas fa-shopping-cart', 1601317033, 1601317033),
(18, 'Другое', 'main-bg.jpg', 'other', 18, 1, 0, 'fa fa-ellipsis-h', 1601317121, 1601317121);

-- --------------------------------------------------------

--
-- Структура таблицы `menu`
--
-- Создание: Окт 04 2020 г., 17:42
--

DROP TABLE IF EXISTS `menu`;
CREATE TABLE `menu` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `parent_id` int(11) DEFAULT '0',
  `icon` varchar(255) DEFAULT NULL,
  `url` varchar(255) NOT NULL,
  `category_id` int(11) NOT NULL,
  `status` tinyint(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `menu`
--

INSERT INTO `menu` (`id`, `title`, `parent_id`, `icon`, `url`, `category_id`, `status`) VALUES
(1, 'Категории меню', 0, 'fa fa-tags', 'menu-category', 1, 1),
(2, 'Все категории ', 1, '', 'menu-category', 1, 1),
(3, 'Cоздать', 1, '', 'menu-category/create', 1, 1),
(4, 'Меню', 0, 'fa fa-bars', 'menu', 1, 1),
(5, 'Все меню', 4, '', 'menu', 1, 1),
(6, 'Создать', 4, '', 'menu/create', 1, 1),
(7, 'Пользователи', 0, 'fa fa-user', 'users', 1, 1),
(8, 'Все пользователи', 7, '', 'users', 1, 1),
(9, 'Создать', 7, '', 'user/create', 1, 1),
(11, 'Акции', 7, '', 'stocks', 1, 1),
(12, 'Все акции', 11, '', 'stocks', 1, 1),
(13, 'Cоздать', 11, '', 'stock/create', 1, 1),
(14, 'Категории', 0, 'fa fa-tags', 'categories', 1, 1),
(15, 'Все категории', 14, '', 'categories', 1, 1),
(16, 'Создать ', 14, '', 'category/create', 1, 1),
(17, 'Заказы', 0, 'fa fas fa-archive', 'orders', 1, 1),
(18, 'Все заказы', 17, '', 'orders', 1, 1),
(19, 'Создать', 17, '', 'order/create', 1, 1),
(20, 'Мой профиль', 0, 'fa fa-user', 'profile/my', 2, 1),
(21, 'Сообщения', 0, 'fa fa-envelope', 'profile/messages', 2, 1),
(22, 'Пополнить баланс', 0, 'fab fas fa fa-cc-visa', 'plus-balance', 1, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `menu_category`
--
-- Создание: Окт 04 2020 г., 17:42
--

DROP TABLE IF EXISTS `menu_category`;
CREATE TABLE `menu_category` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `menu_category`
--

INSERT INTO `menu_category` (`id`, `title`) VALUES
(1, 'admin-menu'),
(2, 'sidebar');

-- --------------------------------------------------------

--
-- Структура таблицы `message`
--
-- Создание: Окт 04 2020 г., 17:42
--

DROP TABLE IF EXISTS `message`;
CREATE TABLE `message` (
  `id` int(11) NOT NULL,
  `author_id` int(11) NOT NULL,
  `reciver_id` int(11) NOT NULL,
  `message` text,
  `status` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `message`
--

INSERT INTO `message` (`id`, `author_id`, `reciver_id`, `message`, `status`, `created_at`, `updated_at`) VALUES
(5, 31, 30, 'Здравствуйте ', 1, 1601836954, 1601836954);

-- --------------------------------------------------------

--
-- Структура таблицы `migration`
--
-- Создание: Окт 04 2020 г., 17:42
--

DROP TABLE IF EXISTS `migration`;
CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1600947747),
('m130524_201442_init', 1600947748),
('m140506_102106_rbac_init', 1600955382),
('m170907_052038_rbac_add_index_on_auth_assignment_user_id', 1600955382),
('m180523_151638_rbac_updates_indexes_without_prefix', 1600955382),
('m190124_110200_add_verification_token_column_to_user_table', 1600947748),
('m200409_110543_rbac_update_mssql_trigger', 1600955382),
('m200924_115117_add_columns_to_user_table', 1600948883),
('m200924_120256_create_menu_category_table', 1600949087),
('m200924_120348_create_menu_table', 1600949264),
('m200924_120829_create_category_table', 1600949704),
('m200924_121620_create_order_table', 1600949873),
('m200924_121859_create_paid_orders_table', 1600949992),
('m200924_134306_create_stock_table', 1600955056),
('m200924_134455_create_message_table', 1600955184);

-- --------------------------------------------------------

--
-- Структура таблицы `order`
--
-- Создание: Окт 09 2020 г., 07:00
-- Последнее обновление: Окт 27 2020 г., 21:00
--

DROP TABLE IF EXISTS `order`;
CREATE TABLE `order` (
  `id` int(11) NOT NULL,
  `author_id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `content` text NOT NULL,
  `author_name` varchar(255) NOT NULL,
  `author_phone` varchar(255) NOT NULL,
  `status` tinyint(3) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `order`
--

INSERT INTO `order` (`id`, `author_id`, `category_id`, `content`, `author_name`, `author_phone`, `status`, `created_at`, `updated_at`) VALUES
(11, 24, 7, 'Старый заказ', 'Гость', '+996(555)110-144', 0, 1601727765, 1601833726),
(12, 24, 8, 'Старый заказ 2sadadasdasd', 'Администратор', '+996(555)110-145', 0, 1601727765, 1602246557),
(14, 31, 18, 'Тестовый заказ', 'Эльдар Ллвлвлв', '+996(555)110-144', 1, 1601834166, 1601836945),
(15, 24, 6, 'Нужен электрик срочно', 'Гость', '+996(708)903-088', 0, 1601837328, 1602078223),
(16, 24, 6, 'Собрать шкаф купе.Центр', 'Гость', '+996(708)903-088', 0, 1601841215, 1602078223),
(35, 31, 3, 'HShshahaha', 'Эльдар Ллвлвлв', '+996(555)110-144', 1, 1601844474, 1601976450),
(36, 5, 6, 'фывыфвы', 'Администратор ', '+996(555)110-144', 1, 1601844552, 1601881403),
(37, 31, 8, 'HAHAHhahahaha', 'Эльдар Ллвлвлв', '+996(555)110-144', 1, 1601844584, 1601976450),
(41, 24, 5, 'чсмчм', 'Гость', '+996(708)903-088', 0, 1601845613, 1602078223),
(45, 24, 15, 'asdasdasdadas', 'Гость', '+996(555)110-144', 0, 1601845949, 1602078223),
(46, 24, 6, 'sadsadasdasda', 'Гость', '+996(555)110-144', 0, 1601845988, 1602078223),
(47, 24, 4, 'sadasdas', 'Гость', '+996(555)110-144', 0, 1601846024, 1602078223),
(48, 24, 12, 'фывфывфыв', 'Гость', '+996(555)110-144', 0, 1601846042, 1602078223),
(49, 24, 4, 'ыфвфывф', 'Гость', '+996(555)110-144', 0, 1601846159, 1602078223),
(50, 24, 15, 'Сделать ремонт компьютера', 'Гость', '+996(708)903-088', 0, 1601846413, 1602078223),
(51, 24, 8, 'Постричь газон на участке ', 'Гость', '+996(700)999-333', 0, 1601846482, 1602078223),
(52, 24, 2, 'Влпладвдссдчж', 'Гость', '+996(700)999-333', 0, 1601846516, 1602078223),
(53, 24, 2, 'Гаоралчов', 'Гость', '+996(700)999-333', 0, 1601846738, 1602078223),
(54, 24, 6, 'Тест', 'Гость', '+996(555)110-144', 0, 1601846840, 1602078223),
(55, 24, 3, 'Тест', 'Гость', '+996(708)904-088', 0, 1601846897, 1602078223),
(56, 24, 6, 'фывыфвф', 'Гость', '+996(555)110-144', 0, 1601846955, 1602078223),
(57, 24, 2, 'Заказ', 'Гость', '+996(708)904-088', 0, 1601847000, 1602078223),
(58, 24, 6, 'фывыфв', 'Гость', '+996(555)110-144', 0, 1601847005, 1602078223),
(59, 24, 7, 'фывфыыфв', 'Гость', '+996(555)110-144', 0, 1601847074, 1602078223),
(60, 24, 4, 'фывывыфвфы', 'Гость', '+996(555)110-144', 0, 1601847104, 1602078223),
(61, 24, 6, 'фывфывф', 'Гость', '+996(555)110-144', 0, 1601847179, 1602078223),
(62, 24, 5, 'фывфывфывф', 'Гость', '+996(555)110-144', 0, 1601847201, 1602078223),
(63, 24, 5, 'фывфывфы', 'Гость', '+996(555)110-144', 0, 1601847282, 1602078223),
(64, 24, 5, 'asdadasas', 'Гость', '+996(555)110-144', 0, 1601847322, 1602078223),
(65, 24, 5, 'asdsada', 'Гость', '+996(555)110-144', 0, 1601847334, 1602078223),
(66, 24, 5, 'asdsadad', 'Гость', '+996(555)110-144', 0, 1601847362, 1602078223),
(67, 24, 5, 'фывффыв', 'Гость', '+996(555)110-144', 0, 1601847384, 1602078223),
(68, 24, 3, 'Test', 'Гость', '+996(555)666-777', 0, 1601847396, 1602078223),
(69, 24, 4, 'asadasd', 'Гость', '+996(555)110-144', 0, 1601847430, 1602078223),
(70, 24, 15, 'Установить стиральную машину', 'Гость', '+996(708)903-088', 0, 1601905558, 1602078223),
(71, 24, 15, 'Установить стиральную машину', 'Гость', '+996(708)903-088', 0, 1601905624, 1602078223),
(72, 24, 15, 'Установить стиральную машину', 'Гость', '+996(708)903-088', 0, 1601905624, 1602078223),
(73, 24, 15, 'Установить стиральную машину', 'Гость', '+996(708)903-088', 0, 1601905624, 1602078223),
(74, 24, 15, 'Установить стиральную машину', 'Гость', '+996(708)903-088', 0, 1601905624, 1602078223),
(75, 24, 15, 'Установить телевизор на стену\r\n12 микрорайон', 'Гость', '+996(708)903-088', 0, 1601905675, 1602078223),
(76, 24, 7, 'Установить телевизор на стену\r\n12 микрорайон\r\n\r\nРемонт и установка техники\r\nCегодня в 19:47\r\nУстановить стиральную машину\r\n\r\nРемонт и установка техники\r\nCегодня в 19:47\r\nУстановить стиральную машину\r\n\r\nРемонт и установка техники\r\nCегодня в 19:47\r\nУстановить стиральную машину', 'Гость', '+996(708)903-088', 0, 1601905723, 1602078223),
(77, 24, 15, 'Требуется сделать ремонт ноутбука\r\nЗаменить клавиатуру', 'Гость', '+996(708)903-088', 0, 1601905845, 1602078223),
(78, 24, 12, 'Нужен дизайнер интерьера. Нужно улучшить существующие комнаты небольшим бюджетом', 'Гость', '+996(708)903-088', 0, 1601905957, 1602078223),
(79, 24, 3, 'Нужен автомобиль комфорт класса', 'Гость', '+996(708)903-088', 0, 1601906110, 1602078223),
(80, 24, 6, 'Нужен сантехник на сегодня. Устранить засор', 'Гость', '+996(708)903-088', 0, 1602254187, 1602277202),
(81, 24, 4, 'Нужен переезд квартиры. Нужен портер ', 'Гость', '+996(708)903-088', 0, 1602254262, 1602277202),
(82, 24, 5, 'Нужен курьер, купить продукты и привезти домой', 'Гость', '+996(708)903-088', 0, 1602268034, 1602277202),
(83, 24, 2, 'Куплю новую квартиру в Бишкеке в рассрочку. Без процентов. До 7 лет рассрочки', 'Гость', '+996(708)903-088', 0, 1602268347, 1602277202),
(87, 24, 15, 'Нужен ремонт ноутбука. Acer s3 ultra', 'Гость', '+996(708)903-088', 0, 1602269219, 1602277202),
(92, 24, 9, 'Нужен бухгалтер удаленный для фирмы', 'Гость', '+996(708)903-088', 0, 1602351460, 1602363602),
(93, 24, 5, 'Нужен курьер, купить суши роллы и доставить в 6 мкр', 'Гость', '+996(708)903-088', 0, 1602351555, 1602363602),
(94, 24, 5, 'Доставить посылку из Арча-Бешика в Центр', 'Гость', '+996(708)903-088', 0, 1602351611, 1602363602),
(95, 24, 7, 'Починить телевизор, перестал включаться', 'Гость', '+996(708)903-088', 0, 1602351671, 1602363602),
(96, 24, 8, 'Убрать 2 комнатную квартиру\r\nСегодня или завтра', 'Гость', '+996(708)903-088', 0, 1602351712, 1602363602),
(97, 24, 12, 'Нужен дизайнер, сделать логотип для фирмы\r\nНедорого. Бюджет 1500 сом', 'Гость', '+996(708)903-088', 0, 1602351819, 1602363602),
(101, 30, 2, 'asdasdasadasdasdsadasdasasdasdasKakakasHahshhahasj', 'azizismailov872872@gmail.com ', '+996(555)110-145', 1, 1602352593, 1603788291),
(104, 24, 5, 'Нужен курьер\r\nотвезти посылку в Кант', 'Гость', '+996(708)903-088', 0, 1603281175, 1603314003),
(105, 24, 2, 'Нужна квартира на пятницу.\r\nНа сутки до 2000 элитка', 'Гость', '+996(708)903-088', 0, 1603281265, 1603314003),
(107, 32, 7, 'Сделать реставрацию кроссовок\r\nАдидас оригиналы', 'Мелис Смит', '+996(708)903-088', 1, 1603281915, 1603282637),
(108, 24, 4, 'asdsadasd', 'Гость', '+996(555)110-144', 0, 1603373408, 1603400402),
(109, 24, 5, 'Курьер', 'Гость', '+996(702)622-276', 0, 1603456349, 1603486802),
(110, 24, 6, 'Нужен сантехник срочно', 'Гость', '+996(708)903-088', 0, 1603733774, 1603746003),
(111, 24, 15, 'Требуется мастер по ноутбуку. \r\nЗаменить экран', 'Гость', '+996(708)903-088', 0, 1603733830, 1603746003),
(112, 24, 10, 'Сделать сайт для транспортной компании', 'Гость', '+996(708)903-088', 0, 1603733880, 1603746003),
(113, 24, 5, 'Нужен курьер, доставить еду с ресторана', 'Гость', '+996(700)987-737', 0, 1603734606, 1603746003),
(114, 24, 5, 'Нужен отвезти посылку', 'Гость', '+996(700)987-737', 0, 1603734634, 1603746003),
(115, 24, 7, 'Нужен электрик на сегодня', 'Гость', '+996(500)128-383', 0, 1603734754, 1603746003),
(116, 24, 2, 'Kansas ', 'Гость', '+996(555)110-144', 0, 1603788204, 1603832403),
(117, 24, 15, 'Hahahha', 'Гость', '+996(555)555-555', 0, 1603788246, 1603832403);

-- --------------------------------------------------------

--
-- Структура таблицы `paid_orders`
--
-- Создание: Окт 09 2020 г., 07:00
--

DROP TABLE IF EXISTS `paid_orders`;
CREATE TABLE `paid_orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `paid_orders`
--

INSERT INTO `paid_orders` (`id`, `user_id`, `order_id`, `status`) VALUES
(5, 30, 11, 1),
(7, 32, 14, 1),
(8, 32, 37, 1),
(9, 31, 79, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `stock`
--
-- Создание: Окт 04 2020 г., 17:42
--

DROP TABLE IF EXISTS `stock`;
CREATE TABLE `stock` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `stock`
--

INSERT INTO `stock` (`id`, `title`, `status`) VALUES
(1, 'Бонус при регистрации', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--
-- Создание: Окт 09 2020 г., 07:00
-- Последнее обновление: Окт 27 2020 г., 08:44
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '10',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `verification_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `surname` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `phone` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `photo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `balance` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`id`, `username`, `auth_key`, `password_hash`, `password_reset_token`, `email`, `status`, `created_at`, `updated_at`, `verification_token`, `surname`, `description`, `phone`, `photo`, `balance`) VALUES
(5, 'Администратор', 'kwp_V6bfydByscyKTSZubW_tUMC3RwgL', '$2y$13$B7OykM0fwRelWoJHlcNCoeo8fpVmsFrBR/.bpb0vLL7fwi8bFchye', NULL, 'admin@gmail.com', 1, 1600973392, 1601881403, 'WYZcL2GLNKeyjCTdM12Fwb_Yb9LRmEQm_1600973392', '', '', '', 'default.png', 100),
(7, 'Редактор', 'xchhIcvDsAngRO6QmmC_AgHOFlB7J1ZW', '$2y$13$BhWc8QYSYfEfSekPlRjsguDtEDEyGwIBZKIGHmCsehB9jTY/PImJC', NULL, 'editor@gmail.com', 1, 1600973460, 1600973460, 'Upfvl4VSqTcbx4pgars1EbLvPZ3lo9WU_1600973460', NULL, NULL, NULL, 'default.png', 0),
(24, 'Без автора', '03RGOBiaxkfcaXjhsh1SfXJFsS5k9Uu6', '$2y$13$Byb3Uf/6De5phjU3T0W/kuQs/QrLWP6y0GhLpdFy/sMZl6cFpJtAS', NULL, 'vseinfo.kg@gmail.com', 1, 1601314095, 1601314095, 'fXCpRlya_x2SNvQu9s-hcG5626a3s8tN_1601314095', '', 'Без автора', '', 'default.png', 40),
(28, NULL, 'GjILd6SUuIPwhg2hClnriMBih53jVRmz', '$2y$13$larg44pKUfUyNvLfKSQDFOihfWLyvuTzu20AJDHWWcrF5I0hO5n52', NULL, 'admin2@gmail.com', 1, 1601832939, 1601832939, '4xJ_Yg1XwnzXEXiBeXBikpk2IoeZplIV_1601832939', NULL, NULL, NULL, 'default.png', 40),
(29, NULL, 'wBZKc6xWyK96dEwDHAXXGz0kWZNBimcf', '$2y$13$tEWnvJC2NRcb89.PYkwOoeAZV.XlUn/sRQbxjQqNDkTuwtCmiqJwO', NULL, 'admin3@gmail.com', 1, 1601832969, 1601832969, 'wVp6fK9gp5eGps1xrB3RlglGkxEAvpmS_1601832969', NULL, NULL, NULL, 'default.png', 40),
(30, NULL, '82BI_x-V6fvM6fF6Dbqv7kmWUf6Rmy64', '$2y$13$mmolc2Y2RUnvKN8ZG.IgguGzmsU1YWLEG0PR6n5R1CsvGe1FO8E6O', 'cVwpx-ge0qG5BvtSOumPKAkAguTHI8-B_1603788291', 'azizismailov872872@gmail.com', 1, 1601833708, 1603788291, 'G4VPf6VP3ftsPKDai139JXbwXB2Fe52V_1601833708', NULL, NULL, NULL, 'default.png', 25),
(31, 'Эльдар', '6_4qHhIF-2NVjaVW2ZUWwHR7PnlC9DYc', '$2y$13$YHYzMUkipnI0CBxRuLsgRO/qhY69DB.9iXreMw2wgfNB9D8pjnWpC', NULL, 'eldar@gmail.com', 1, 1601834091, 1602254152, '9vZhE7ZmKpCYiYXkT7p_ztFhukm7pXBI_1601834091', 'Ллвлвлв', 'asdasdasdasd', '+996(555)110-144', 'customer.png', 110),
(32, 'Мелис', '_LmViHzBwbRC0yIBQhs8hpn4Su7JPeCR', '$2y$13$70BMzQeOE.4fV.o8Ju70wuLIsw6rPlGWcm1SydiFLBhxre.RBChvC', NULL, 'artbele@yandex.ru', 1, 1601843050, 1603735704, 'ub70uVhjQCNl0ZvVvP4Ab5FI53pLoMlO_1601843050', 'Смит', 'Маркетолог-психолог с 30 летним стажем. Умею все', '+996(708)903-088', '5ED7019C-BDB2-4919-936C-737601EAB8DE.jpeg', 10),
(33, 'Азамат', 'MnmTLOu6YOv47QeQmt5F6Gtr_fWBVKUH', '$2y$13$nc7ny3Ps8KRMa9g0NsSHe.9fxf.P7zM6NiCjxWZ6gufJt8DSrbaxK', NULL, 'bavaria4g@gmail.com', 1, 1603282196, 1603282353, 'z-KArQJZ3WAx2QBnMYlXwSn0PTOd-geL_1603282196', 'Нурболотович', 'Сантехник электрик', '+996(701)265-874', 'default.png', 0);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `auth_assignment`
--
ALTER TABLE `auth_assignment`
  ADD PRIMARY KEY (`item_name`,`user_id`),
  ADD KEY `idx-auth_assignment-user_id` (`user_id`);

--
-- Индексы таблицы `auth_item`
--
ALTER TABLE `auth_item`
  ADD PRIMARY KEY (`name`),
  ADD KEY `rule_name` (`rule_name`),
  ADD KEY `idx-auth_item-type` (`type`);

--
-- Индексы таблицы `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD PRIMARY KEY (`parent`,`child`),
  ADD KEY `child` (`child`);

--
-- Индексы таблицы `auth_rule`
--
ALTER TABLE `auth_rule`
  ADD PRIMARY KEY (`name`);

--
-- Индексы таблицы `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx-parent-id` (`parent_id`),
  ADD KEY `order` (`order`,`status`);

--
-- Индексы таблицы `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx-parent_id` (`parent_id`),
  ADD KEY `idx-category_id` (`category_id`);

--
-- Индексы таблицы `menu_category`
--
ALTER TABLE `menu_category`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx-message-author_id` (`author_id`),
  ADD KEY `idx-message-reciver_id` (`reciver_id`);

--
-- Индексы таблицы `migration`
--
ALTER TABLE `migration`
  ADD PRIMARY KEY (`version`);

--
-- Индексы таблицы `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx-order-author_id` (`author_id`),
  ADD KEY `idx-order-category_id` (`category_id`),
  ADD KEY `status` (`status`);

--
-- Индексы таблицы `paid_orders`
--
ALTER TABLE `paid_orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx-paid-orders-user_id` (`user_id`),
  ADD KEY `idx-paid-orders-order_id` (`order_id`),
  ADD KEY `status` (`status`);

--
-- Индексы таблицы `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `password_reset_token` (`password_reset_token`),
  ADD KEY `status` (`status`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT для таблицы `menu`
--
ALTER TABLE `menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT для таблицы `menu_category`
--
ALTER TABLE `menu_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `message`
--
ALTER TABLE `message`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `order`
--
ALTER TABLE `order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=118;

--
-- AUTO_INCREMENT для таблицы `paid_orders`
--
ALTER TABLE `paid_orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT для таблицы `stock`
--
ALTER TABLE `stock`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `auth_assignment`
--
ALTER TABLE `auth_assignment`
  ADD CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `auth_item`
--
ALTER TABLE `auth_item`
  ADD CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `menu`
--
ALTER TABLE `menu`
  ADD CONSTRAINT `fk-menu-category_id` FOREIGN KEY (`category_id`) REFERENCES `menu_category` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `message`
--
ALTER TABLE `message`
  ADD CONSTRAINT `fk-message-author_id` FOREIGN KEY (`author_id`) REFERENCES `user` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk-message-reciver_id` FOREIGN KEY (`reciver_id`) REFERENCES `user` (`id`);

--
-- Ограничения внешнего ключа таблицы `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `fk-order-author_id` FOREIGN KEY (`author_id`) REFERENCES `user` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk-order-category_id` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `paid_orders`
--
ALTER TABLE `paid_orders`
  ADD CONSTRAINT `fk-paid-orders-order_id` FOREIGN KEY (`order_id`) REFERENCES `order` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk-paid-orders-user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
