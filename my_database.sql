-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: db
-- Tiempo de generación: 20-08-2023 a las 10:10:47
-- Versión del servidor: 10.11.2-MariaDB-1:10.11.2+maria~ubu2204
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
  `price` decimal(6,2) NOT NULL DEFAULT 0.00,
  `available` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `dishes`
--

INSERT INTO `dishes` (`dishe_id`, `name`, `category_id`, `menu_id`, `description`, `picture`, `price`, `available`) VALUES
(1, 'macarrones a la boloñesa', 4, 2, 'Mauris eu mattis neque. Sed aliquet maximus rutrum. Praesent auctor enim felis, vitae molestie elit aliquam id. Donec et justo orci. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Duis auctor arcu libero, ut tempor nunc eleifend vel. Aliquam ullamcorper non augue eu porttitor. Phasellus at est vel sem placerat finibus sit amet a nibh. Proin metus ligula, scelerisque id eleifend sit amet, vestibulum sit amet justo. Duis tincidunt dui nec mauris egestas finibus. Morbi purus nulla, scelerisque sagittis consequat quis, pretium at sem. Phasellus ornare arcu metus, vitae feugiat neque rutrum sed. Donec maximus felis nunc, vel elementum orci viverra sit amet. Curabitur at odio sit amet nisi consequat commodo.', '/var/www/public/uploads/dishes_pics/1674058366-macarrones_bolognesa.jpg', '9.50', 1),
(2, 'ensalada catalana', 4, 3, 'mauris eu mattis neque. sed aliquet maximus rutrum. praesent auctor enim felis, vitae molestie elit aliquam id. donec et justo orci. \r\n\r\norci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. duis auctor arcu libero, ut tempor nunc eleifend vel. aliquam ullamcorper non augue eu porttitor. phasellus at est vel sem placerat finibus sit amet a nibh. proin metus ligula, scelerisque id eleifend sit amet, vestibulum sit amet justo. \r\n\r\nduis tincidunt dui nec mauris egestas finibus. morbi purus nulla, scelerisque sagittis consequat quis, pretium at sem. phasellus ornare arcu metus, vitae feugiat neque rutrum sed. donec maximus felis nunc, vel elementum orci viverra sit amet. curabitur at odio sit amet nisi consequat commodo.', '/var/www/public/uploads/dishes_pics/1674058472-ensalada_catalana.jpeg', '7.50', 1),
(3, 'ensalada mixta', 1, 3, 'Mauris eu mattis neque. Sed aliquet maximus rutrum. Praesent auctor enim felis, vitae molestie elit aliquam id. Donec et justo orci. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Duis auctor arcu libero, ut tempor nunc eleifend vel. Aliquam ullamcorper non augue eu porttitor. \r\n\r\nPhasellus at est vel sem placerat finibus sit amet a nibh. Proin metus ligula, scelerisque id eleifend sit amet, vestibulum sit amet justo. Duis tincidunt dui nec mauris egestas finibus. Morbi purus nulla, scelerisque sagittis consequat quis, pretium at sem. Phasellus ornare arcu metus, vitae feugiat neque rutrum sed. Donec maximus felis nunc, vel elementum orci viverra sit amet. Curabitur at odio sit amet nisi consequat commodo.', '/var/www/public/uploads/dishes_pics/1683464202-ensalada_mixta.png', '7.50', 1),
(4, 'paella valenciana', 2, 6, 'Mauris eu mattis neque. Sed aliquet maximus rutrum. Praesent auctor enim felis, vitae molestie elit aliquam id. Donec et justo orci. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Duis auctor arcu libero, ut tempor nunc eleifend vel. Aliquam ullamcorper non augue eu porttitor. Phasellus at est vel sem placerat finibus sit amet a nibh. \r\nProin metus ligula, scelerisque id eleifend sit amet, vestibulum sit amet justo. Duis tincidunt dui nec mauris egestas finibus. Morbi purus nulla, scelerisque sagittis consequat quis, pretium at sem. Phasellus ornare arcu metus, vitae feugiat neque rutrum sed. Donec maximus felis nunc, vel elementum orci viverra sit amet. Curabitur at odio sit amet nisi consequat commodo.', '/var/www/public/uploads/dishes_pics/1674058720-paella-valenciana-jpg.jpeg', '11.25', 1),
(5, 'bistec con patatas y verduras', 4, 4, 'Mauris eu mattis neque. Sed aliquet maximus rutrum. Praesent auctor enim felis, vitae molestie elit aliquam id. Donec et justo orci. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. \r\n\r\nDuis auctor arcu libero, ut tempor nunc eleifend vel. Aliquam ullamcorper non augue eu porttitor. Phasellus at est vel sem placerat finibus sit amet a nibh. Proin metus ligula, scelerisque id eleifend sit amet, vestibulum sit amet justo. Duis tincidunt dui nec mauris egestas finibus. Morbi purus nulla, scelerisque sagittis consequat quis, pretium at sem. Phasellus ornare arcu metus, vitae feugiat neque rutrum sed. Donec maximus felis nunc, vel elementum orci viverra sit amet. Curabitur at odio sit amet nisi consequat commodo.', '/var/www/public/uploads/dishes_pics/1674058802-bistec_patatas.jpg', '8.25', 1),
(6, 'arroz con setas', 4, 6, 'Mauris eu mattis neque. Sed aliquet maximus rutrum. Praesent auctor enim felis, vitae molestie elit aliquam id. Donec et justo orci. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Duis auctor arcu libero, ut tempor nunc eleifend vel. Aliquam ullamcorper non augue eu porttitor. Phasellus at est vel sem placerat finibus sit amet a nibh. Proin metus ligula, scelerisque id eleifend sit amet, vestibulum sit amet justo. Duis tincidunt dui nec mauris egestas finibus. \r\n\r\nMorbi purus nulla, scelerisque sagittis consequat quis, pretium at sem. Phasellus ornare arcu metus, vitae feugiat neque rutrum sed. Donec maximus felis nunc, vel elementum orci viverra sit amet. Curabitur at odio sit amet nisi consequat commodo.', '/var/www/public/uploads/dishes_pics/1674058844-arroz_setas.jpg', '12.35', 1),
(7, 'espaguetis a la carbonara', 1, 2, 'Mauris eu mattis neque. Sed aliquet maximus rutrum. Praesent auctor enim felis, vitae molestie elit aliquam id. Donec et justo orci. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Duis auctor arcu libero, ut tempor nunc eleifend vel. Aliquam ullamcorper non augue eu porttitor. Phasellus at est vel sem placerat finibus sit amet a nibh. Proin metus ligula, scelerisque id eleifend sit amet, vestibulum sit amet justo. Duis tincidunt dui nec mauris egestas finibus. Morbi purus nulla, scelerisque sagittis consequat quis, pretium at sem. Phasellus ornare arcu metus, vitae feugiat neque rutrum sed. \r\n\r\nDonec maximus felis nunc, vel elementum orci viverra sit amet. Curabitur at odio sit amet nisi consequat commodo.', '/var/www/public/uploads/dishes_pics/1674058899-espagueti_carbo.jpg', '8.75', 1),
(8, 'crema catalana', 4, 7, 'La crema catalana (conocida también como crema quemada o, en Cataluña, simplemente crema) es un postre muy típico de la cocina catalana similar a la francesa crème brûlée. Muy difundido por el resto de España y por toda Europa, que consiste en una crema pastelera con base en yema de huevo que se suele cubrir con una capa de azúcar caramelizado en su superficie para aportar un contraste crujiente.', '/var/www/public/uploads/dishes_pics/1674408728-crema_catalana.jpg', '8.00', 1),
(9, 'entrecot al gusto', 4, 4, 'Mauris ut blandit nunc. Cras eu turpis elit. Nulla facilisi. Praesent sed enim leo. In elementum in velit elementum fringilla. Duis condimentum erat quis elit vulputate vestibulum. \r\n\r\nSed dictum imperdiet felis a aliquam. Nullam fringilla ac justo at volutpat. Aenean feugiat nulla vel arcu tempor euismod. Aenean eros ligula, suscipit a elit at, sodales semper velit. Cras sit amet aliquet nulla. Nullam metus lorem, ultrices eu turpis ut, tristique mattis lacus.', '/var/www/public/uploads/dishes_pics/1676036967-entrecote.jpg', '17.00', 1),
(10, 'olivas rellenas', 4, 1, 'duis lobortis mattis leo, et mattis mi suscipit eu. morbi auctor leo a eros tempor accumsan. quisque egestas sem a condimentum tristique. mauris ut sapien a quam placerat tincidunt quis sed purus. curabitur vestibulum vitae lacus a imperdiet. vivamus venenatis lorem magna, et dignissim ligula ullamcorper ut. curabitur lacinia nunc sit amet quam maximus lobortis. ut diam dolor, lobortis vel purus vitae, varius posuere augue. phasellus dictum tempus tincidunt.', '/var/www/public/uploads/dishes_pics/1682844428-olivas_rellenas.jpg', '2.50', 0),
(11, 'patatas chips', 4, 1, 'Duis lobortis mattis leo, et mattis mi suscipit eu. Morbi auctor leo a eros tempor accumsan. Quisque egestas sem a condimentum tristique. Mauris ut sapien a quam placerat tincidunt quis sed purus. Curabitur vestibulum vitae lacus a imperdiet. Vivamus venenatis lorem magna, et dignissim ligula ullamcorper ut. Curabitur lacinia nunc sit amet quam maximus lobortis. Ut diam dolor, lobortis vel purus vitae, varius posuere augue. Phasellus dictum tempus tincidunt.', '/var/www/public/uploads/dishes_pics/1682845338-chips.jpg', '1.50', 1),
(12, 'salmón a la plancha', 2, 5, 'Sed sit amet est a lorem viverra convallis. Praesent id lectus at felis cursus scelerisque. Nunc luctus posuere diam, eget luctus nulla viverra at. Nam euismod posuere feugiat. Aliquam erat volutpat. Cras vel gravida lectus, vel porta orci. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae;', '/var/www/public/uploads/dishes_pics/1682846637-salmon.jpg', '13.75', 1),
(13, 'tinto de la casa', 4, 9, 'Sed sit amet est a lorem viverra convallis. Praesent id lectus at felis cursus scelerisque. Nunc luctus posuere diam, eget luctus nulla viverra at. Nam euismod posuere feugiat. Aliquam erat volutpat. Cras vel gravida lectus, vel porta orci. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae;', '/var/www/public/uploads/dishes_pics/1682849269-red-wine1.png', '11.50', 1),
(14, 'blanco de la casa', 4, 10, 'Sed sit amet est a lorem viverra convallis. Praesent id lectus at felis cursus scelerisque. Nunc luctus posuere diam, eget luctus nulla viverra at. Nam euismod posuere feugiat. Aliquam erat volutpat. Cras vel gravida lectus, vel porta orci. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae;', '/var/www/public/uploads/dishes_pics/1682851683-white-wine.png', '11.75', 1),
(15, 'refresco de cola', 4, 14, 'Sed sit amet est a lorem viverra convallis. Praesent id lectus at felis cursus scelerisque. Nunc luctus posuere diam, eget luctus nulla viverra at. Nam euismod posuere feugiat. Aliquam erat volutpat. Cras vel gravida lectus, vel porta orci. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae;', '/var/www/public/uploads/dishes_pics/1682853556-cola.jpg', '1.50', 1),
(16, 'agua mineral', 4, 14, 'Sed sit amet est a lorem viverra convallis. Praesent id lectus at felis cursus scelerisque. Nunc luctus posuere diam, eget luctus nulla viverra at. Nam euismod posuere feugiat. Aliquam erat volutpat. Cras vel gravida lectus, vel porta orci. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae;', '/var/www/public/uploads/dishes_pics/1682854251-water.jpg', '1.10', 1),
(17, 'café solo', 4, 8, 'Sed sit amet est a lorem viverra convallis. Praesent id lectus at felis cursus scelerisque. Nunc luctus posuere diam, eget luctus nulla viverra at. Nam euismod posuere feugiat. Aliquam erat volutpat. Cras vel gravida lectus, vel porta orci. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae;', '/var/www/public/uploads/dishes_pics/1682854429-coffee.jpg', '1.20', 1),
(18, 'café cortado', 4, 8, 'Sed sit amet est a lorem viverra convallis. Praesent id lectus at felis cursus scelerisque. Nunc luctus posuere diam, eget luctus nulla viverra at. Nam euismod posuere feugiat. Aliquam erat volutpat. Cras vel gravida lectus, vel porta orci. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae;', '/var/www/public/uploads/dishes_pics/1682854551-coffee.jpg', '1.30', 1),
(19, 'creps de la casa', 3, 7, 'Sed sit amet est a lorem viverra convallis. Praesent id lectus at felis cursus scelerisque. Nunc luctus posuere diam, eget luctus nulla viverra at. Nam euismod posuere feugiat. Aliquam erat volutpat. Cras vel gravida lectus, vel porta orci. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae;', '/var/www/public/uploads/dishes_pics/1682856434-creps.jpg', '4.75', 1),
(21, 'anchoas de la casa', 4, 1, 'Vestibulum vitae auctor odio. Vivamus sagittis eleifend fermentum. Aliquam dictum lacinia lacinia. Nulla commodo quam a convallis sollicitudin. Sed ipsum orci, tincidunt quis laoreet id, blandit vel neque. Nullam vel eleifend enim, a varius lorem. Mauris at mi sed velit faucibus rhoncus.', '/var/www/public/uploads/dishes_pics/1683462317-anchoas.webp', '11.75', 1),
(26, 'jarra de cerveza', 4, 14, 'Duis quis nulla vitae odio feugiat vehicula a id felis. Phasellus in ultrices ipsum. Nunc et efficitur metus, et lacinia ex. Duis sit amet nunc blandit, euismod mi eu, vehicula risus. Fusce eu felis sem. Morbi faucibus euismod malesuada. Morbi dapibus diam eu erat sagittis semper. Vestibulum tristique a orci ac semper. Nam orci enim, egestas eget semper eget, volutpat eget lacus. Fusce dignissim quam eu convallis molestie. Aliquam at nulla maximus, venenatis nisi quis, molestie lectus.', '/var/www/public/uploads/dishes_pics/1688758699-beer_jar.png', '3.25', 1);

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
  `menu_category` varchar(50) NOT NULL,
  `menu_emoji` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `dishes_menu`
--

INSERT INTO `dishes_menu` (`menu_id`, `menu_category`, `menu_emoji`) VALUES
(1, 'aperitivos', '&#127839;'),
(2, 'entrantes', '&#127836;'),
(3, 'ensaladas', '&#129367;'),
(4, 'carnes', '&#129385;'),
(5, 'pescados', '&#128031;'),
(6, 'arroces', '&#129368;'),
(7, 'postres', '&#129473;'),
(8, 'cafés', '&#9749;'),
(9, 'tintos', '&#127863;'),
(10, 'blancos', '&#127863;'),
(11, 'rosados', '&#127863;'),
(12, 'cavas', '&#127870;'),
(13, 'champagne', '&#127870;'),
(14, 'bebidas', '&#127866;'),
(15, 'licores', '&#127865;');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `english_dict`
--

CREATE TABLE `english_dict` (
  `id` int(11) NOT NULL,
  `key_word` varchar(50) NOT NULL,
  `value` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `english_dict`
--

INSERT INTO `english_dict` (`id`, `key_word`, `value`) VALUES
(1, 'flag_text', 'español'),
(2, 'flag', 'spanish'),
(3, 'welcome', 'welcome'),
(4, 'day_menu', 'day\'s menu'),
(5, 'first_plates', 'starters'),
(6, 'seconds', 'main dishes'),
(7, 'desserts', 'desserts'),
(8, 'price', 'price'),
(9, 'menu_day_footer', 'water, wine or refresh drink'),
(10, 'nav_link_home', 'home'),
(11, 'nav_link_menu', 'menu'),
(12, 'nav_link_logout', 'logout'),
(13, 'nav_link_sign_up', 'sign up'),
(14, 'nav_link_administration', 'administration'),
(15, 'nav_link_orders', 'orders'),
(16, 'our_menu', 'our menu'),
(17, 'send', 'send'),
(18, 'aperitivos', 'aperitifs'),
(20, 'entrantes', 'starters'),
(22, 'ensaladas', 'salads'),
(24, 'carnes', 'meats'),
(25, 'meats', 'carnes'),
(26, 'pescados', 'fishes'),
(28, 'arroces', 'rices'),
(30, 'postres', 'desserts'),
(32, 'cafés', 'coffees'),
(34, 'tintos', 'red wines'),
(36, 'blancos', 'white wines'),
(38, 'rosados', 'pink wines'),
(40, 'cavas', 'sparking wine'),
(42, 'champagne', 'champagne'),
(43, 'bebidas', 'drinks'),
(45, 'licores', 'liquors'),
(47, 'olivas rellenas', 'stuffed olives'),
(48, 'patatas chips', 'bag of chips'),
(49, 'anchoas de la casa', 'house anchovies'),
(50, 'macarrones a la boloñesa', 'macaroni bolognese'),
(51, 'espaguetis a la carbonara', 'spaghetti carbonara'),
(52, 'ensalada catalana', 'catalan salad'),
(53, 'catalan salad', 'catalan salad'),
(54, 'ensalada mixta', 'mixt salad'),
(55, 'bistec con patatas y verduras', 'steak with potatoes and vegetables'),
(56, 'entrecot al gusto', 'entrecote to taste'),
(57, 'salmón a la plancha', 'grilled salmon'),
(58, 'paella valenciana', 'valencian paella'),
(59, 'arroz con setas', 'rice with mushrooms'),
(60, 'crema catalana', 'catalan cream'),
(61, 'creps de la casa', 'house pancakes'),
(62, 'café solo', 'black coffee'),
(63, 'café cortado', 'small white coffee'),
(64, 'tinto de la casa', 'house red wine'),
(65, 'blanco de la casa', 'house white wine'),
(66, 'refresco de cola', 'cola drink'),
(67, 'agua mineral', 'mineral water'),
(68, 'jarra de cerveza', 'beer jar'),
(69, 'go_back', 'go back'),
(70, 'logged_as', 'logged as'),
(71, 'captcha_text', 'enter the code shown above'),
(72, 'alert_access', 'you don\'t have privileges to do this action.'),
(73, 'alert_login', 'check your credentials'),
(74, 'alert_delete', 'are you sure you want to delete it'),
(75, 'register_form', 'register form'),
(76, 'main_menu', 'main menu'),
(77, 'products', 'products'),
(78, 'menu_day_price', 'menu\'s price of the day'),
(79, 'show_list', 'show list'),
(80, 'search', 'search'),
(81, 'new', 'new'),
(82, 'users', 'users'),
(83, 'categories', 'categories'),
(84, 'orders', 'orders'),
(85, 'go_to_list', 'go to the list'),
(86, 'product_list', 'product listing'),
(87, 'image', 'image'),
(88, 'name', 'name'),
(89, 'category', 'category'),
(90, 'available', 'available'),
(91, 'options', 'options'),
(92, 'edit', 'edit'),
(93, 'delete', 'delete'),
(94, 'carta', 'menu'),
(95, 'primero', 'first'),
(96, 'segundo', 'second'),
(97, 'postre', 'dessert'),
(98, 'si', 'yes'),
(99, 'no', 'no'),
(100, 'prev', 'prev'),
(101, 'next', 'next'),
(102, 'new_product', 'new product'),
(103, 'description', 'description'),
(104, 'dish_type', 'dish type'),
(105, 'select', 'select'),
(106, 'product_details', 'product details'),
(107, 'change_image', 'change image'),
(108, 'update', 'update'),
(109, 'hi', 'hi'),
(110, 'search_product', 'search product'),
(111, 'place_holder_dish_name', 'dish\'s name'),
(112, 'by_name', 'by name'),
(113, 'by_availability', 'by availability'),
(114, 'by_category', 'by category'),
(115, 'search_criteria', 'search criteria'),
(116, 'availables', 'availables'),
(117, 'change_password', 'change password'),
(118, 'user_data', 'user data'),
(119, 'user', 'user'),
(120, 'password', 'password'),
(121, 'repeat_password', 'repeat password'),
(122, 'new_order', 'new order'),
(123, 'table', 'table'),
(124, 'people', 'people'),
(125, 'drinks', 'drinks'),
(126, 'coffees_and_liquors', 'coffees / liquors'),
(127, 'aperitif', 'aperitif'),
(128, 'drink', 'drink'),
(129, 'to_order', 'order'),
(130, 'qty', 'qty.'),
(131, 'current_orders', 'current orders'),
(132, 'people_qty', 'p. qty'),
(133, 'firsts', 'starters'),
(134, 'add', 'to add'),
(135, 'see_data', 'see data'),
(136, 'alert_table_number', 'select a table number'),
(137, 'alert_people_qty', 'select people quantity'),
(138, 'selecciona', 'select');

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
(1, '18.75');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `table_number` tinyint(3) UNSIGNED NOT NULL,
  `people_qty` tinyint(3) UNSIGNED NOT NULL,
  `aperitifs` text DEFAULT NULL,
  `aperitifs_qty` text DEFAULT NULL,
  `aperitifs_finished` text DEFAULT '0',
  `firsts` text DEFAULT NULL,
  `firsts_qty` text DEFAULT NULL,
  `firsts_finished` text DEFAULT '0',
  `seconds` text DEFAULT NULL,
  `seconds_qty` text DEFAULT NULL,
  `seconds_finished` text DEFAULT '0',
  `desserts` text DEFAULT NULL,
  `desserts_qty` text DEFAULT NULL,
  `desserts_finished` text DEFAULT '0',
  `drinks` text DEFAULT NULL,
  `drinks_qty` text DEFAULT NULL,
  `drinks_finished` text DEFAULT '0',
  `coffees` text DEFAULT NULL,
  `coffees_qty` text DEFAULT NULL,
  `coffees_finished` text DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `orders`
--

INSERT INTO `orders` (`id`, `table_number`, `people_qty`, `aperitifs`, `aperitifs_qty`, `aperitifs_finished`, `firsts`, `firsts_qty`, `firsts_finished`, `seconds`, `seconds_qty`, `seconds_finished`, `desserts`, `desserts_qty`, `desserts_finished`, `drinks`, `drinks_qty`, `drinks_finished`, `coffees`, `coffees_qty`, `coffees_finished`) VALUES
(1, 1, 2, 'patatas chips,anchoas de la casa', '1,1', '1,1', 'ensalada mixta,espaguetis a la carbonara', '1,1', '0,1', 'paella valenciana,salmón a la plancha', '1,1', '0,1', 'creps de la casa', '2', '0', 'agua mineral,refresco de cola', '1,1', '0,0', '', '', ''),
(2, 2, 1, 'olivas rellenas', '1', '0', 'ensalada mixta', '1', '0', 'salmón a la plancha', '1', '0', 'creps de la casa', '1', '0', 'jarra de cerveza', '1', '0', '', '', ''),
(3, 3, 2, 'olivas rellenas,patatas chips,anchoas de la casa', '1,1,1', '1,1,1', 'ensalada mixta', '1', '1', 'paella valenciana', '1', '1', 'creps de la casa,crema catalana', '2,1', '1,1', 'agua mineral,jarra de cerveza,blanco de la casa,refresco de cola,blanco de la casa', '1,1,1,1,1', '1,1,1,1,1', 'café solo,café cortado', '1,1', '1,1'),
(4, 4, 1, 'patatas chips', '1', '1', 'ensalada mixta', '1', '1', 'salmón a la plancha', '1', '1', 'crema catalana,crema catalana', '1,0', '1,1', 'jarra de cerveza', '3', '1', '', '', ''),
(5, 5, 1, '', '', '0', 'macarrones a la boloñesa', '1', '0', '', '', '0', '', '', '0', 'jarra de cerveza', '1', '0', '', '', '0');

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
-- Estructura de tabla para la tabla `spanish_dict`
--

CREATE TABLE `spanish_dict` (
  `id` int(11) NOT NULL,
  `key_word` varchar(50) NOT NULL,
  `value` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `spanish_dict`
--

INSERT INTO `spanish_dict` (`id`, `key_word`, `value`) VALUES
(1, 'flag_text', 'english'),
(2, 'flag', 'english'),
(3, 'welcome', 'bienvenido'),
(4, 'day_menu', 'menú del día'),
(5, 'first_plates', 'primeros platos'),
(6, 'seconds', 'segundos platos'),
(7, 'desserts', 'postres'),
(8, 'price', 'precio'),
(9, 'menu_day_footer', 'agua, vino o refresco'),
(10, 'nav_link_home', 'inicio'),
(11, 'nav_link_menu', 'carta'),
(12, 'nav_link_logout', 'salir'),
(13, 'nav_link_sign_up', 'registrate'),
(14, 'nav_link_administration', 'administración'),
(15, 'nav_link_orders', 'pedidos'),
(16, 'our_menu', 'nuestra carta'),
(17, 'send', 'enviar'),
(18, 'aperitivos', 'aperitivos'),
(19, 'aperitifs', 'aperitivos'),
(20, 'entrantes', 'entrantes'),
(21, 'starters', 'entrantes'),
(22, 'ensaladas', 'ensaladas'),
(23, 'salads', 'ensaladas'),
(24, 'carnes', 'carnes'),
(25, 'meats', 'carnes'),
(26, 'pescados', 'pescados'),
(27, 'fishes', 'pescados'),
(28, 'arroces', 'arroces'),
(29, 'rices', 'arroces'),
(30, 'postres', 'postres'),
(31, 'desserts', 'postres'),
(32, 'cafés', 'cafés'),
(33, 'coffees', 'cafés'),
(34, 'tintos', 'tintos'),
(35, 'red wines', 'tintos'),
(36, 'blancos', 'blancos'),
(37, 'white wines', 'blancos'),
(38, 'rosados', 'rosados'),
(39, 'pink wines', 'rosados'),
(40, 'cavas', 'cavas'),
(41, 'sparking wine', 'cavas'),
(42, 'champagne', 'champagne'),
(43, 'bebidas', 'bebidas'),
(44, 'drinks', 'bebidas'),
(45, 'licores', 'licores'),
(46, 'liquors', 'licores'),
(47, 'olivas rellenas', 'olivas rellenas'),
(48, 'patatas chips', 'patatas chips'),
(49, 'anchoas de la casa', 'anchoas de la casa'),
(50, 'macarrones a la boloñesa', 'macarrones a la boloñesa'),
(51, 'espaguetis a la carbonara', 'espaguetis a la carbonara'),
(52, 'ensalada catalana', 'ensalada catalana'),
(53, 'catalan salad', 'ensalada catalana'),
(54, 'ensalada mixta', 'ensalada mixta'),
(55, 'bistec con patatas y verduras', 'bistec con patatas y verduras'),
(56, 'entrecot al gusto', 'entrecot al gusto'),
(57, 'salmón a la plancha', 'salmón a la plancha'),
(58, 'paella valenciana', 'paella valenciana'),
(59, 'arroz con setas', 'arroz con setas'),
(60, 'crema catalana', 'crema catalana'),
(61, 'creps de la casa', 'creps de la casa'),
(62, 'café solo', 'café solo'),
(63, 'café cortado', 'café cortado'),
(64, 'tinto de la casa', 'tinto de la casa'),
(65, 'blanco de la casa', 'blanco de la casa'),
(66, 'refresco de cola', 'refresco de cola'),
(67, 'agua mineral', 'agua mineral'),
(68, 'jarra de cerveza', 'jarra de cerveza'),
(69, 'go_back', 'volver atrás'),
(70, 'logged_as', 'logeado como'),
(71, 'captcha_text', 'introduce la serie de caracteres'),
(72, 'alert_access', 'no tienes privilegios para realizar esta acción.'),
(73, 'alert_login', 'comprueba tus credenciales'),
(74, 'alert_delete', 'estás seguro de querer eliminar el registro'),
(75, 'register_form', 'formulario de registro'),
(76, 'main_menu', 'menú principal'),
(77, 'products', 'productos'),
(78, 'menu_day_price', 'precio del menú del día'),
(79, 'show_list', 'listado'),
(80, 'search', 'buscar'),
(81, 'new', 'nuevo'),
(82, 'users', 'usuarios'),
(83, 'categories', 'categorías'),
(84, 'orders', 'comandas'),
(85, 'go_to_list', 'ir al listado'),
(86, 'product_list', 'listado de productos'),
(87, 'image', 'imagen'),
(88, 'name', 'nombre'),
(89, 'category', 'categoría'),
(90, 'available', 'disponible'),
(91, 'options', 'opciones'),
(92, 'edit', 'editar'),
(93, 'delete', 'eliminar'),
(94, 'carta', 'carta'),
(95, 'primero', 'primero'),
(96, 'segundo', 'segundo'),
(97, 'postre', 'postre'),
(98, 'si', 'si'),
(99, 'no', 'no'),
(100, 'prev', 'ant'),
(101, 'next', 'sig'),
(102, 'new_product', 'nuevo producto'),
(103, 'description', 'descripción'),
(104, 'dish_type', 'tipo de plato'),
(105, 'select', 'selecciona'),
(106, 'product_details', 'detalles del producto'),
(107, 'change_image', 'cambiar imagen'),
(108, 'update', 'actualizar'),
(109, 'hi', 'hola'),
(110, 'search_product', 'buscar producto'),
(111, 'place_holder_dish_name', 'nombre del plato'),
(112, 'by_name', 'por nombre'),
(113, 'by_availability', 'por disponibilidad'),
(114, 'by_category', 'por categoría'),
(115, 'search_criteria', 'criterios de búsqueda'),
(116, 'availables', 'disponibles'),
(117, 'change_password', 'cambiar contraseña'),
(118, 'user_data', 'datos de usuario'),
(119, 'user', 'usuario'),
(120, 'password', 'contraseña'),
(121, 'repeat_password', 'repite contraseña'),
(122, 'new_order', 'nuevo pedido'),
(123, 'table', 'mesa'),
(124, 'people', 'personas'),
(126, 'coffees_and_liquors', 'cafés / licores'),
(127, 'aperitif', 'aperitivo'),
(128, 'drink', 'bebida'),
(129, 'to_order', 'pedir'),
(130, 'qty', 'cant.'),
(131, 'current_orders', 'pedidos en curso'),
(132, 'people_qty', 'pers.'),
(133, 'firsts', 'primeros'),
(134, 'add', 'añadir'),
(135, 'see_data', 'ver datos'),
(136, 'alert_table_number', 'selecciona un número de mesa'),
(137, 'alert_people_qty', 'selecciona número de personas'),
(138, 'selecciona', 'selecciona');

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
-- Indices de la tabla `english_dict`
--
ALTER TABLE `english_dict`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `menu_day_price`
--
ALTER TABLE `menu_day_price`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id_role`);

--
-- Indices de la tabla `spanish_dict`
--
ALTER TABLE `spanish_dict`
  ADD PRIMARY KEY (`id`);

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
  MODIFY `dishe_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

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
-- AUTO_INCREMENT de la tabla `english_dict`
--
ALTER TABLE `english_dict`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=139;

--
-- AUTO_INCREMENT de la tabla `menu_day_price`
--
ALTER TABLE `menu_day_price`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id_role` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `spanish_dict`
--
ALTER TABLE `spanish_dict`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=139;

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
