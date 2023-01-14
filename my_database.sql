-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: db
-- Tiempo de generación: 13-01-2023 a las 19:04:44
-- Versión del servidor: 10.8.3-MariaDB-1:10.8.3+maria~jammy
-- Versión de PHP: 8.0.22

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
  `picture` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `dishes`
--

INSERT INTO `dishes` (`dishe_id`, `name`, `category_id`, `menu_id`, `description`, `picture`) VALUES
(1, 'Macarrones a la Boloñesa', 1, 2, 'Macarrones con tomate y parmesano gratinados', NULL),
(2, 'Bistec con patatas y verduras', 2, 4, 'Bistec de ternera a la brasa con verduras a la parrilla', NULL),
(3, 'Flan con Nata y chocolate', 3, 7, 'Flan de huevo con nata montada a mano y chocolate casero', NULL),
(5, 'Ensalada mixta con aguacate', 1, 3, 'Ensalada con ingredientes de la huerta, lechuga, tomate, pepino, maiz, muslitos de cangrejo, aguacate y atún.', NULL),
(6, 'Pastel de queso', 3, 7, 'Pastel casero con queso de cabra y frambuesas', NULL),
(8, 'Paella Valenciana', 4, 6, 'Paella de conejo y pollo con caracoles y verduras típicas de la huerta valenciana.', NULL),
(9, 'Bolsa de patatas fritas', 4, 1, 'Patatas de bolsa para aperitivos', NULL),
(10, 'Aceitunas rellenas', 4, 1, 'Lata de aceitunas rellenas.', NULL),
(11, 'Espaguetis a la carbonara', 4, 2, 'Espaguetis con nata y condimentos especiales para la elaboración artesanal', NULL),
(12, 'Ensalada catalana', 4, 3, 'Ensalada típica de cataluña, con ingredientes de l´Alt Empurdá', NULL),
(13, 'Entrecot a la pimienta', 4, 4, 'Entrecot de buey a la parrilla con salsa a la pimienta', NULL),
(14, 'Arroz negro', 4, 6, 'Arroz negro con tinta de sepia, gambas y frutos del mar', NULL),
(15, 'Arroz con setas', 2, 6, 'Arroz con setas de campo, liebre y verduras de la campiña.', NULL),
(16, 'Arroz marinero', 4, 6, 'Arroz con frutos de mar, bogabante y gambas.', NULL),
(17, 'Arroz con verduras', 4, 6, 'Arroz con verduras frescas de temporada.', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dishes_day`
--

CREATE TABLE `dishes_day` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(50) NOT NULL DEFAULT 'primero'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id_roles` int(11) NOT NULL,
  `role` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id_roles`, `role`) VALUES
(1, 'ROLE_ADMIN'),
(2, 'ROLE_USER');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `id_role` int(11) NOT NULL DEFAULT 2
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`id_user`, `user_name`, `password`, `email`, `id_role`) VALUES
(1, 'admin', '$2y$10$UmlPg2q.E8FyQ/y8/zkcgu/OXaar1erO8gEldBqGI5BtB3vElwReq', 'admin@admin.com', 1),
(2, 'pepe', '$2y$10$06rwi52tnOtwSM.u3OSpIuth3eu4M1pEzysOEv9r9kJ//1PUh7YwO', 'pepe@pepe.com', 2);

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
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id_roles`);

--
-- Indices de la tabla `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `fk_user_role` (`id_role`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `dishes`
--
ALTER TABLE `dishes`
  MODIFY `dishe_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

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
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id_roles` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
  ADD CONSTRAINT `fk_user_role` FOREIGN KEY (`id_role`) REFERENCES `roles` (`id_roles`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
