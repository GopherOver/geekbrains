-- phpMyAdmin SQL Dump
-- version 4.7.1
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Авг 05 2017 г., 13:55
-- Версия сервера: 5.7.18-0ubuntu0.16.04.1
-- Версия PHP: 7.0.18-0ubuntu0.16.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `l5.gb`
--
CREATE DATABASE IF NOT EXISTS `l5.gb` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `l5.gb`;

-- --------------------------------------------------------

--
-- Структура таблицы `carts`
--

DROP TABLE IF EXISTS `carts`;
CREATE TABLE IF NOT EXISTS `carts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `size` varchar(50) NOT NULL DEFAULT 'MANGO PEOPLE T-SHIRT',
  `color` varchar(50) NOT NULL DEFAULT 'Black',
  `amount` int(11) NOT NULL DEFAULT '1',
  `product_price` double NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `amount` double NOT NULL DEFAULT '0',
  `status` tinyint(8) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `amount`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 95990, 4, '2017-07-04 14:53:36', '2017-07-04 14:53:36'),
(2, 1, 45990, 3, '2017-07-04 22:29:03', '2017-07-04 22:29:03');

-- --------------------------------------------------------

--
-- Структура таблицы `orders_statuses`
--

DROP TABLE IF EXISTS `orders_statuses`;
CREATE TABLE IF NOT EXISTS `orders_statuses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status_name` varchar(50) DEFAULT NULL,
  `css` varchar(50) NOT NULL DEFAULT 'label-default',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `orders_statuses`
--

INSERT INTO `orders_statuses` (`id`, `status_name`, `css`) VALUES
(1, 'Новый', 'danger'),
(2, 'В обработке', 'warning'),
(3, 'Отправлен', 'info'),
(4, 'Завершён', 'success');

-- --------------------------------------------------------

--
-- Структура таблицы `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT 'MANGO PEOPLE T-SHIRT',
  `category_id` int(11) NOT NULL DEFAULT '0',
  `purchase` int(255) NOT NULL DEFAULT '0',
  `price` int(255) NOT NULL DEFAULT '52',
  `img_src` varchar(255) NOT NULL DEFAULT 'no_img.jpg',
  `description` varchar(250) NOT NULL DEFAULT 'Compellingly actualize fully researched processes before proactive outsourcing. Progressively syndicate collaborative architectures before cutting-edge services. Completely visualize parallel core competencies rather than exceptional portals. ',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `products`
--

INSERT INTO `products` (`id`, `name`, `category_id`, `purchase`, `price`, `img_src`, `description`) VALUES
(1, 'MANGO PEOPLE T-SHIRT', 1, 0, 52, 'item1.png', 'Compellingly actualize fully researched processes before proactive outsourcing. Progressively syndicate collaborative architectures before cutting-edge services. Completely visualize parallel core competencies rather than exceptional portals. '),
(2, 'MANGO PEOPLE T-SHIRT', 2, 0, 52, 'item2.png', 'Compellingly actualize fully researched processes before proactive outsourcing. Progressively syndicate collaborative architectures before cutting-edge services. Completely visualize parallel core competencies rather than exceptional portals. '),
(3, 'MANGO PEOPLE T-SHIRT', 1, 0, 52, 'item3.png', 'Compellingly actualize fully researched processes before proactive outsourcing. Progressively syndicate collaborative architectures before cutting-edge services. Completely visualize parallel core competencies rather than exceptional portals. '),
(4, 'MANGO PEOPLE T-SHIRT', 2, 0, 52, 'item4.png', 'Compellingly actualize fully researched processes before proactive outsourcing. Progressively syndicate collaborative architectures before cutting-edge services. Completely visualize parallel core competencies rather than exceptional portals. '),
(5, 'MANGO PEOPLE T-SHIRT', 2, 0, 52, 'item5.png', 'Compellingly actualize fully researched processes before proactive outsourcing. Progressively syndicate collaborative architectures before cutting-edge services. Completely visualize parallel core competencies rather than exceptional portals. '),
(6, 'MANGO PEOPLE T-SHIRT', 1, 0, 52, 'item6.png', 'Compellingly actualize fully researched processes before proactive outsourcing. Progressively syndicate collaborative architectures before cutting-edge services. Completely visualize parallel core competencies rather than exceptional portals. '),
(7, 'MANGO PEOPLE T-SHIRT', 1, 0, 52, 'item7.png', 'Compellingly actualize fully researched processes before proactive outsourcing. Progressively syndicate collaborative architectures before cutting-edge services. Completely visualize parallel core competencies rather than exceptional portals. '),
(8, 'MANGO PEOPLE T-SHIRT', 1, 0, 52, 'item8.png', 'Compellingly actualize fully researched processes before proactive outsourcing. Progressively syndicate collaborative architectures before cutting-edge services. Completely visualize parallel core competencies rather than exceptional portals. '),
(9, 'MANGO PEOPLE T-SHIRT', 3, 0, 52, 'item9.png', 'Compellingly actualize fully researched processes before proactive outsourcing. Progressively syndicate collaborative architectures before cutting-edge services. Completely visualize parallel core competencies rather than exceptional portals. '),
(10, 'MANGO PEOPLE T-SHIRT', 4, 0, 52, 'item10.png', 'Compellingly actualize fully researched processes before proactive outsourcing. Progressively syndicate collaborative architectures before cutting-edge services. Completely visualize parallel core competencies rather than exceptional portals. '),
(11, 'MANGO PEOPLE T-SHIRT', 5, 0, 52, 'item11.png', 'Compellingly actualize fully researched processes before proactive outsourcing. Progressively syndicate collaborative architectures before cutting-edge services. Completely visualize parallel core competencies rather than exceptional portals. '),
(12, 'MANGO PEOPLE T-SHIRT', 6, 0, 52, 'item12.png', 'Compellingly actualize fully researched processes before proactive outsourcing. Progressively syndicate collaborative architectures before cutting-edge services. Completely visualize parallel core competencies rather than exceptional portals. ');

-- --------------------------------------------------------

--
-- Структура таблицы `products_categories`
--

DROP TABLE IF EXISTS `products_categories`;
CREATE TABLE IF NOT EXISTS `products_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `img_src` varchar(255) DEFAULT NULL,
  `slug` varchar(50) NOT NULL,
  `menu_name` varchar(50) NOT NULL,
  `url` varchar(50) NOT NULL DEFAULT '#',
  `parent_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `products_categories`
--

INSERT INTO `products_categories` (`id`, `title`, `img_src`, `slug`, `menu_name`, `url`, `parent_id`) VALUES
(1, 'For Men', 'category1.png', 'Hot Deal', 'Men', '/shop?category=1', 0),
(2, 'Women', 'category2.png', '30% offer', 'Women', '/shop?category=2', 0),
(3, 'Accessories', 'category3.png', 'New Arrivals', 'Accessories', '/shop?category=3', 0),
(4, 'For Kids', 'category4.png', 'Luxirous & Trendy', 'Kids', '/shop?category=4', 0),
(5, 'Featured', '', '', 'Featured', '/shop?category=5', 0),
(6, 'Hot Deals', '', '', 'Hot Deals', '/shop?category=6', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `products_designers`
--

DROP TABLE IF EXISTS `products_designers`;
CREATE TABLE IF NOT EXISTS `products_designers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `products_designers`
--

INSERT INTO `products_designers` (`id`, `name`) VALUES
(1, 'Bohemian'),
(2, 'Floral'),
(3, 'Lace');

-- --------------------------------------------------------

--
-- Структура таблицы `products_properties`
--

DROP TABLE IF EXISTS `products_properties`;
CREATE TABLE IF NOT EXISTS `products_properties` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `type` tinyint(10) UNSIGNED NOT NULL DEFAULT '1',
  `value` varchar(255) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`),
  KEY `type` (`type`),
  KEY `value` (`value`)
) ENGINE=InnoDB AUTO_INCREMENT=89 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `products_properties`
--

INSERT INTO `products_properties` (`id`, `product_id`, `type`, `value`) VALUES
(1, 1, 1, 'item1.png'),
(2, 1, 1, 'item1.png'),
(3, 1, 1, 'item1.png'),
(4, 2, 1, 'item2.png'),
(5, 2, 1, 'item2.png'),
(6, 2, 1, 'item2.png'),
(7, 1, 2, 'S'),
(8, 1, 2, 'M'),
(9, 1, 3, 'Red'),
(10, 1, 4, 'COTTON'),
(11, 1, 4, 'POLIESTER'),
(12, 1, 5, 'BINBURHAN'),
(13, 1, 6, '2'),
(14, 1, 6, '3'),
(15, 1, 6, '4'),
(16, 2, 6, '5'),
(17, 3, 1, 'item3.png'),
(18, 4, 1, 'item4.png'),
(19, 5, 1, 'item5.png'),
(20, 6, 1, 'item6.png'),
(21, 7, 1, 'item7.png'),
(22, 8, 1, 'item8.png'),
(23, 9, 1, 'item9.png'),
(24, 10, 1, 'item10.png'),
(25, 11, 1, 'item11.png'),
(26, 12, 1, 'item12.png'),
(27, 2, 2, 'XS'),
(28, 2, 2, 'S'),
(29, 2, 2, 'M'),
(30, 2, 2, 'L'),
(31, 2, 3, 'RED'),
(32, 2, 3, 'BLUE'),
(33, 2, 4, 'COTTON'),
(34, 2, 5, 'BINBURHAN'),
(35, 3, 2, 'M'),
(36, 3, 2, 'L'),
(37, 3, 2, 'XL'),
(38, 3, 3, 'RED'),
(39, 3, 3, 'BLACK'),
(40, 3, 4, 'COTTON'),
(41, 3, 5, 'BINBURHAN'),
(42, 4, 2, 'S'),
(43, 4, 2, 'M'),
(44, 4, 3, 'RED'),
(45, 4, 4, 'COTTON'),
(46, 4, 5, 'BINBURHAN'),
(47, 5, 2, 'S'),
(48, 5, 2, 'M'),
(49, 5, 3, 'RED'),
(50, 5, 3, 'BLACK'),
(51, 5, 4, 'COTTON'),
(52, 5, 5, 'BINBURHAN'),
(53, 6, 2, 'S'),
(54, 6, 2, 'M'),
(55, 6, 3, 'RED'),
(56, 6, 3, 'BLACK'),
(57, 6, 4, 'COTTON'),
(58, 6, 5, 'BINBURHAN'),
(59, 7, 2, 'S'),
(60, 7, 2, 'M'),
(61, 7, 3, 'RED'),
(62, 7, 3, 'BLACK'),
(63, 7, 4, 'COTTON'),
(64, 7, 5, 'BINBURHAN'),
(65, 8, 2, 'S'),
(66, 8, 2, 'M'),
(67, 8, 3, 'RED'),
(68, 8, 3, 'BLACK'),
(69, 8, 4, 'COTTON'),
(70, 8, 5, 'BINBURHAN'),
(71, 9, 2, 'S'),
(72, 9, 2, 'M'),
(73, 9, 3, 'RED'),
(74, 9, 3, 'BLACK'),
(75, 9, 4, 'COTTON'),
(76, 9, 5, 'BINBURHAN'),
(77, 10, 2, 'S'),
(78, 10, 2, 'M'),
(79, 10, 3, 'RED'),
(80, 10, 3, 'BLACK'),
(81, 10, 4, 'COTTON'),
(82, 10, 5, 'BINBURHAN'),
(83, 12, 2, 'S'),
(84, 12, 2, 'M'),
(85, 12, 3, 'RED'),
(86, 12, 3, 'BLACK'),
(87, 12, 4, 'COTTON'),
(88, 12, 5, 'BINBURHAN');

-- --------------------------------------------------------

--
-- Структура таблицы `products_properties_types`
--

DROP TABLE IF EXISTS `products_properties_types`;
CREATE TABLE IF NOT EXISTS `products_properties_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `products_properties_types`
--

INSERT INTO `products_properties_types` (`id`, `type`, `name`) VALUES
(1, 1, 'img'),
(2, 2, 'size'),
(3, 3, 'color'),
(4, 4, 'material'),
(5, 5, 'designer'),
(6, 6, 'related');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `middle_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `hash` varchar(255) DEFAULT NULL,
  `is_admin` tinyint(8) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
