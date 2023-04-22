-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: db
-- Tiempo de generación: 22-04-2023 a las 16:55:21
-- Versión del servidor: 10.10.3-MariaDB-1:10.10.3+maria~ubu2204
-- Versión de PHP: 8.0.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `my_database`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dishes`
--

CREATE TABLE `dishes` (
  `dishe_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `menu_id` int(11) NOT NULL DEFAULT 1,
  `description` text NOT NULL,
  `picture` varchar(200) DEFAULT NULL,
  `price` decimal(5,2) NOT NULL DEFAULT 0.00,
  `available` char(2) NOT NULL DEFAULT 'SI'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `dishes`
--

INSERT INTO `dishes` (`dishe_id`, `name`, `category_id`, `menu_id`, `description`, `picture`, `price`, `available`) VALUES
(1, 'Macarrones a la Boloñesa', 4, 2, 'Mauris eu mattis neque. Sed aliquet maximus rutrum. Praesent auctor enim felis, vitae molestie elit aliquam id. Donec et justo orci. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Duis auctor arcu libero, ut tempor nunc eleifend vel. Aliquam ullamcorper non augue eu porttitor. Phasellus at est vel sem placerat finibus sit amet a nibh. Proin metus ligula, scelerisque id eleifend sit amet, vestibulum sit amet justo. Duis tincidunt dui nec mauris egestas finibus. Morbi purus nulla, scelerisque sagittis consequat quis, pretium at sem. Phasellus ornare arcu metus, vitae feugiat neque rutrum sed. Donec maximus felis nunc, vel elementum orci viverra sit amet. Curabitur at odio sit amet nisi consequat commodo.', '/var/www/public/uploads/dishes_pics/1674058366-macarrones_bolognesa.jpg', '9.50', 'SI'),
(2, 'Ensalada catalana', 4, 3, 'Mauris eu mattis neque. Sed aliquet maximus rutrum. Praesent auctor enim felis, vitae molestie elit aliquam id. Donec et justo orci. \r\n\r\nOrci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Duis auctor arcu libero, ut tempor nunc eleifend vel. Aliquam ullamcorper non augue eu porttitor. Phasellus at est vel sem placerat finibus sit amet a nibh. Proin metus ligula, scelerisque id eleifend sit amet, vestibulum sit amet justo. \r\n\r\nDuis tincidunt dui nec mauris egestas finibus. Morbi purus nulla, scelerisque sagittis consequat quis, pretium at sem. Phasellus ornare arcu metus, vitae feugiat neque rutrum sed. Donec maximus felis nunc, vel elementum orci viverra sit amet. Curabitur at odio sit amet nisi consequat commodo.', '/var/www/public/uploads/dishes_pics/1674058472-ensalada_catalana.jpeg', '7.50', 'SI'),
(3, 'Ensalada mixta', 1, 3, 'Mauris eu mattis neque. Sed aliquet maximus rutrum. Praesent auctor enim felis, vitae molestie elit aliquam id. Donec et justo orci. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Duis auctor arcu libero, ut tempor nunc eleifend vel. Aliquam ullamcorper non augue eu porttitor. \r\n\r\nPhasellus at est vel sem placerat finibus sit amet a nibh. Proin metus ligula, scelerisque id eleifend sit amet, vestibulum sit amet justo. Duis tincidunt dui nec mauris egestas finibus. Morbi purus nulla, scelerisque sagittis consequat quis, pretium at sem. Phasellus ornare arcu metus, vitae feugiat neque rutrum sed. Donec maximus felis nunc, vel elementum orci viverra sit amet. Curabitur at odio sit amet nisi consequat commodo.', '/var/www/public/uploads/dishes_pics/1674058648-ensalada_mixta.jpg', '7.50', 'SI'),
(4, 'Paella Valenciana', 2, 6, 'Mauris eu mattis neque. Sed aliquet maximus rutrum. Praesent auctor enim felis, vitae molestie elit aliquam id. Donec et justo orci. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Duis auctor arcu libero, ut tempor nunc eleifend vel. Aliquam ullamcorper non augue eu porttitor. Phasellus at est vel sem placerat finibus sit amet a nibh. \r\nProin metus ligula, scelerisque id eleifend sit amet, vestibulum sit amet justo. Duis tincidunt dui nec mauris egestas finibus. Morbi purus nulla, scelerisque sagittis consequat quis, pretium at sem. Phasellus ornare arcu metus, vitae feugiat neque rutrum sed. Donec maximus felis nunc, vel elementum orci viverra sit amet. Curabitur at odio sit amet nisi consequat commodo.', '/var/www/public/uploads/dishes_pics/1674058720-paella-valenciana-jpg.jpeg', '11.25', 'SI'),
(5, 'Bistec con patatas y verduras', 2, 4, 'Mauris eu mattis neque. Sed aliquet maximus rutrum. Praesent auctor enim felis, vitae molestie elit aliquam id. Donec et justo orci. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. \r\n\r\nDuis auctor arcu libero, ut tempor nunc eleifend vel. Aliquam ullamcorper non augue eu porttitor. Phasellus at est vel sem placerat finibus sit amet a nibh. Proin metus ligula, scelerisque id eleifend sit amet, vestibulum sit amet justo. Duis tincidunt dui nec mauris egestas finibus. Morbi purus nulla, scelerisque sagittis consequat quis, pretium at sem. Phasellus ornare arcu metus, vitae feugiat neque rutrum sed. Donec maximus felis nunc, vel elementum orci viverra sit amet. Curabitur at odio sit amet nisi consequat commodo.', '/var/www/public/uploads/dishes_pics/1674058802-bistec_patatas.jpg', '8.25', 'SI'),
(6, 'Arroz con setas', 4, 6, 'Mauris eu mattis neque. Sed aliquet maximus rutrum. Praesent auctor enim felis, vitae molestie elit aliquam id. Donec et justo orci. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Duis auctor arcu libero, ut tempor nunc eleifend vel. Aliquam ullamcorper non augue eu porttitor. Phasellus at est vel sem placerat finibus sit amet a nibh. Proin metus ligula, scelerisque id eleifend sit amet, vestibulum sit amet justo. Duis tincidunt dui nec mauris egestas finibus. \r\n\r\nMorbi purus nulla, scelerisque sagittis consequat quis, pretium at sem. Phasellus ornare arcu metus, vitae feugiat neque rutrum sed. Donec maximus felis nunc, vel elementum orci viverra sit amet. Curabitur at odio sit amet nisi consequat commodo.', '/var/www/public/uploads/dishes_pics/1674058844-arroz_setas.jpg', '12.35', 'SI'),
(7, 'Espaguetis a la carbonara', 1, 2, 'Mauris eu mattis neque. Sed aliquet maximus rutrum. Praesent auctor enim felis, vitae molestie elit aliquam id. Donec et justo orci. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Duis auctor arcu libero, ut tempor nunc eleifend vel. Aliquam ullamcorper non augue eu porttitor. Phasellus at est vel sem placerat finibus sit amet a nibh. Proin metus ligula, scelerisque id eleifend sit amet, vestibulum sit amet justo. Duis tincidunt dui nec mauris egestas finibus. Morbi purus nulla, scelerisque sagittis consequat quis, pretium at sem. Phasellus ornare arcu metus, vitae feugiat neque rutrum sed. \r\n\r\nDonec maximus felis nunc, vel elementum orci viverra sit amet. Curabitur at odio sit amet nisi consequat commodo.', '/var/www/public/uploads/dishes_pics/1674058899-espagueti_carbo.jpg', '11.00', 'SI'),
(8, 'Crema Catalana', 3, 7, 'La crema catalana (conocida también como crema quemada o, en Cataluña, simplemente crema) es un postre muy típico de la cocina catalana similar a la francesa crème brûlée. Muy difundido por el resto de España y por toda Europa, que consiste en una crema pastelera con base en yema de huevo que se suele cubrir con una capa de azúcar caramelizado en su superficie para aportar un contraste crujiente.', '/var/www/public/uploads/dishes_pics/1674408728-crema_catalana.jpg', '8.00', 'SI'),
(9, 'entrecot al gusto', 4, 4, 'Mauris ut blandit nunc. Cras eu turpis elit. Nulla facilisi. Praesent sed enim leo. In elementum in velit elementum fringilla. Duis condimentum erat quis elit vulputate vestibulum. \r\n\r\nSed dictum imperdiet felis a aliquam. Nullam fringilla ac justo at volutpat. Aenean feugiat nulla vel arcu tempor euismod. Aenean eros ligula, suscipit a elit at, sodales semper velit. Cras sit amet aliquet nulla. Nullam metus lorem, ultrices eu turpis ut, tristique mattis lacus.', '/var/www/public/uploads/dishes_pics/1676036967-entrecote.jpg', '17.00', 'SI');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dishes_day`
--

CREATE TABLE `dishes_day` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(50) NOT NULL DEFAULT 'primero'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `dishes_day`
--

INSERT INTO `dishes_day` (`category_id`, `category_name`) VALUES
(1, 'primero'),
(2, 'segundo'),
(3, 'postre'),
(4, 'carta');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dishes_menu`
--

CREATE TABLE `dishes_menu` (
  `menu_id` int(11) NOT NULL,
  `menu_category` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `dishes_menu`
--

INSERT INTO `dishes_menu` (`menu_id`, `menu_category`) VALUES
(1, 'aperitivos'),
(2, 'entrantes'),
(3, 'ensaladas'),
(4, 'carnes'),
(5, 'pescados'),
(6, 'arroces'),
(7, 'postres'),
(8, 'cafés'),
(9, 'tintos'),
(10, 'blancos'),
(11, 'rosados'),
(12, 'cavas'),
(13, 'champagne'),
(14, 'bebidas'),
(15, 'licores');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menu_day_price`
--

CREATE TABLE `menu_day_price` (
  `id` int(11) NOT NULL,
  `price` decimal(5,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `menu_day_price`
--

INSERT INTO `menu_day_price` (`id`, `price`) VALUES
(1, '17.50');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id_role` int(11) NOT NULL,
  `role` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id_role`, `role`) VALUES
(1, 'ROLE_ADMIN'),
(2, 'ROLE_USER'),
(3, 'ROLE_WAITER');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `id_role` int(11) NOT NULL DEFAULT 2
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`id`, `user_name`, `password`, `email`, `id_role`) VALUES
(1, 'admin', '$2y$10$UmlPg2q.E8FyQ/y8/zkcgu/OXaar1erO8gEldBqGI5BtB3vElwReq', 'admin@admin.com', 1),
(2, 'pepe', '$2y$10$06rwi52tnOtwSM.u3OSpIuth3eu4M1pEzysOEv9r9kJ//1PUh7YwO', 'pepe@pepe.com', 3),
(3, 'luis', '$2y$10$30PDCa6OsP4RetegiCIbYORAxooMOZ11p.A5HNbwp5LZHDEttpHwq', 'luis@luis.com', 2);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `dishes`
--
ALTER TABLE `dishes`
  ADD PRIMARY KEY (`dishe_id`),
  ADD KEY `menu_id` (`menu_id`),
  ADD KEY `dishes_fk_day` (`category_id`);

--
-- Indices de la tabla `dishes_day`
--
ALTER TABLE `dishes_day`
  ADD PRIMARY KEY (`category_id`);

--
-- Indices de la tabla `dishes_menu`
--
ALTER TABLE `dishes_menu`
  ADD PRIMARY KEY (`menu_id`);

--
-- Indices de la tabla `menu_day_price`
--
ALTER TABLE `menu_day_price`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id_role`);

--
-- Indices de la tabla `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `fk_user_role` (`id_role`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `dishes`
--
ALTER TABLE `dishes`
  MODIFY `dishe_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `dishes_day`
--
ALTER TABLE `dishes_day`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `dishes_menu`
--
ALTER TABLE `dishes_menu`
  MODIFY `menu_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `menu_day_price`
--
ALTER TABLE `menu_day_price`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id_role` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `dishes`
--
ALTER TABLE `dishes`
  ADD CONSTRAINT `dishes_fk_day` FOREIGN KEY (`category_id`) REFERENCES `dishes_day` (`category_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dishes_fk_menu` FOREIGN KEY (`menu_id`) REFERENCES `dishes_menu` (`menu_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `fk_user_role` FOREIGN KEY (`id_role`) REFERENCES `roles` (`id_role`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
