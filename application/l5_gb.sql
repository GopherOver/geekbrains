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
-- Структура таблицы `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `group_id` int(11) NOT NULL DEFAULT '0',
  `purchase` int(255) NOT NULL DEFAULT '0',
  `price` int(255) NOT NULL,
  `img` varchar(255) NOT NULL DEFAULT 'no_img.jpg',
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Очистить таблицу перед добавлением данных `product`
--

TRUNCATE TABLE `product`;
--
-- Дамп данных таблицы `product`
--

INSERT INTO `product` (`id`, `name`, `group_id`, `purchase`, `price`, `img`, `description`) VALUES
(1, 'Apple iPhone 7', 1, 0, 45990, 'iphone-7.jpg', 'В iPhone 7 все важнейшие аспекты iPhone значительно улучшены. Это принципиально новая система камер для фото и видеосъёмки. Максимально мощный и экономичный аккумулятор. Стереодинамики с богатым звучанием. Самый яркий и разноцветный из всех дисплеев iPhone. Защита от брызг и воды. И его внешние данные впечатляют не менее, чем внутренние возможности. Всё это iPhone 7. '),
(2, 'Samsung S8', 2, 0, 50990, 'samsung-s8.jpg', 'Новый Samsung Galaxy меняет представление о смартфоне. Безграничный изогнутый с двух сторон экран обеспечивает эффект полного погружения и подчёркивает гармонию стиля и инноваций. Сканер радужной оболочки глаза позволяет надёжно защитить личные данные и с лёгкостью разблокировать смартфон. Камера 12 Мп c технологией Dual Pixel и диафрагмой F1.7 помогает делать потрясающие снимки при любых условиях освещённости.');

-- --------------------------------------------------------

--
-- Структура таблицы `product_group`
--

CREATE TABLE `product_group` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `img` varchar(255) NOT NULL DEFAULT 'no_img.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Очистить таблицу перед добавлением данных `product_group`
--

TRUNCATE TABLE `product_group`;
--
-- Дамп данных таблицы `product_group`
--

INSERT INTO `product_group` (`id`, `name`, `img`) VALUES
(1, 'Apple iPhone', 'no_img.jpg'),
(2, 'Samsung Galaxy', 'no_img.jpg');

-- --------------------------------------------------------

--
-- Структура таблицы `product_img`
--

CREATE TABLE `product_img` (
  `id` int(11) NOT NULL,
  `src` varchar(255) NOT NULL,
  `product_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Очистить таблицу перед добавлением данных `product_img`
--

TRUNCATE TABLE `product_img`;
--
-- Дамп данных таблицы `product_img`
--

INSERT INTO `product_img` (`id`, `src`, `product_id`) VALUES
(1, 'iphone-7.jpg', 1),
(2, 'iphone-7-1.jpg', 1),
(3, 'iphone-7-2.jpg', 1),
(4, 'samsung-s8.jpg', 2),
(5, 'samsung-s8-1.jpg', 2),
(6, 'samsung-s8-2.jpg', 2);

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `hash` varchar(255) DEFAULT NULL,
  `status` tinyint(8) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Очистить таблицу перед добавлением данных `user`
--

TRUNCATE TABLE `user`;
--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `product_group`
--
ALTER TABLE `product_group`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `product_img`
--
ALTER TABLE `product_img`
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
-- AUTO_INCREMENT для таблицы `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT для таблицы `product_group`
--
ALTER TABLE `product_group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT для таблицы `product_img`
--
ALTER TABLE `product_img`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
