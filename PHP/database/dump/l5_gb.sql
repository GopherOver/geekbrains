-- Хост: localhost
-- Время создания: Июл 06 2017 г., 12:58
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

CREATE TABLE IF NOT EXISTS `carts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_price` double NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `carts`
--

INSERT INTO `carts` (`id`, `order_id`, `user_id`, `product_id`, `product_price`) VALUES
(1, 1, 1, 1, 45990),
(2, 1, 1, 2, 50000),
(3, 2, 1, 1, 45990);

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

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
(2, 1, 45990, 2, '2017-07-04 22:29:03', '2017-07-04 22:29:03');

-- --------------------------------------------------------

--
-- Структура таблицы `orders_statuses`
--

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
(1, 'Новый', 'primary'),
(2, 'В обработке', 'warning'),
(3, 'Отправлен', 'success'),
(4, 'Завершён', 'danger');

-- --------------------------------------------------------

--
-- Структура таблицы `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `group_id` int(11) NOT NULL DEFAULT '0',
  `purchase` int(255) NOT NULL DEFAULT '0',
  `price` int(255) NOT NULL,
  `img_src` varchar(255) NOT NULL DEFAULT 'no_img.jpg',
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `products`
--

INSERT INTO `products` (`id`, `name`, `group_id`, `purchase`, `price`, `img_src`, `description`) VALUES
(1, 'Apple iPhone 7', 1, 0, 45990, 'iphone-7.jpg', 'В iPhone 7 все важнейшие аспекты iPhone значительно улучшены. Это принципиально новая система камер для фото и видеосъёмки. Максимально мощный и экономичный аккумулятор. Стереодинамики с богатым звучанием. Самый яркий и разноцветный из всех дисплеев iPhone. Защита от брызг и воды. И его внешние данные впечатляют не менее, чем внутренние возможности. Всё это iPhone 7. '),
(2, 'Samsung S8', 2, 0, 50990, 'samsung-s8.jpg', 'Новый Samsung Galaxy меняет представление о смартфоне. Безграничный изогнутый с двух сторон экран обеспечивает эффект полного погружения и подчёркивает гармонию стиля и инноваций. Сканер радужной оболочки глаза позволяет надёжно защитить личные данные и с лёгкостью разблокировать смартфон. Камера 12 Мп c технологией Dual Pixel и диафрагмой F1.7 помогает делать потрясающие снимки при любых условиях освещённости.');

-- --------------------------------------------------------

--
-- Структура таблицы `products_categories`
--

CREATE TABLE IF NOT EXISTS `products_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `img_src` varchar(255) NOT NULL DEFAULT 'no_img.jpg',
  `parent_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `products_categories`
--

INSERT INTO `products_categories` (`id`, `title`, `img_src`, `parent_id`) VALUES
(1, 'Apple iPhone', 'no_img.jpg', 0),
(2, 'Samsung Galaxy', 'no_img.jpg', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `products_properties`
--

CREATE TABLE IF NOT EXISTS `products_properties` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `type` tinyint(8) NOT NULL DEFAULT '0',
  `value` varchar(255) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`),
  KEY `type` (`type`),
  KEY `value` (`value`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `products_properties`
--

INSERT INTO `products_properties` (`id`, `product_id`, `type`, `value`) VALUES
(1, 1, 0, 'iphone-7.jpg'),
(2, 1, 0, 'iphone-7-1.jpg'),
(3, 1, 0, 'iphone-7-2.jpg'),
(4, 2, 0, 'samsung-s8.jpg'),
(5, 2, 0, 'samsung-s8-1.jpg'),
(6, 2, 0, 'samsung-s8-2.jpg');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

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
