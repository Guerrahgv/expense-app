-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 13-06-2023 a las 19:31:01
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `expenseapp`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categories`
--

CREATE TABLE `categories` (
  `id` int(5) NOT NULL,
  `name` varchar(100) NOT NULL,
  `color` varchar(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `categories`
--

INSERT INTO `categories` (`id`, `name`, `color`) VALUES
(1, 'comida', '#DE1F59'),
(2, 'hogar', '#DE1FAA'),
(3, 'ropa', '#B01FDE'),
(4, 'Juegos', '#681FDE'),
(5, 'Viajes', '#1FAADE');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `expenses`
--

CREATE TABLE `expenses` (
  `id` int(20) NOT NULL,
  `title` varchar(150) NOT NULL,
  `category_id` int(5) NOT NULL,
  `amount` float(10,2) NOT NULL,
  `date` date NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `expenses`
--

INSERT INTO `expenses` (`id`, `title`, `category_id`, `amount`, `date`, `id_user`) VALUES
(1, 'compra zapatos', 3, 300000.00, '2023-01-15', 5),
(2, 'Cefes U', 1, 60000.00, '2023-02-04', 5),
(4, 'Regalo de cumpleaños mamá', 2, 120000.00, '2023-04-24', 5),
(5, 'cd Silvestre', 2, 120000.00, '2023-03-14', 5),
(6, 'Viaje a Santa marta', 5, 200000.00, '2023-01-14', 5),
(7, 'Chocolates', 1, 14000.00, '2023-05-23', 5),
(10, 'Salida a Cine', 5, 232300.00, '2023-04-15', 5),
(11, 'comida Italiana', 1, 232000.00, '2023-05-21', 5),
(12, 'Viaje Bucaramanga', 5, 110000.00, '2023-02-21', 5),
(13, 'viaje Bogota', 5, 230000.00, '2023-01-04', 5),
(14, 'Cervezas', 5, 230000.00, '2023-03-02', 5),
(19, 'asado', 1, 300000.00, '2023-04-20', 5),
(20, 'Libro: El pajaro loco', 4, 100000.00, '2023-02-11', 5),
(21, 'Uñas', 3, 20000.00, '2023-05-16', 6),
(23, 'pastillas para la tos', 2, 2100.00, '2023-01-16', 5),
(24, 'Compra sueter', 3, 300000.00, '2023-04-01', 5),
(25, 'juego Nintendo', 4, 200000.00, '2023-05-09', 5),
(26, 'buy coffee students ', 1, 45000.00, '2023-06-13', 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('user','admin') NOT NULL,
  `budget` float(10,2) NOT NULL,
  `photo` varchar(300) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `budget`, `photo`, `name`) VALUES
(5, 'roberto', '$2y$10$2rSgJFpMQIu846sVP3uV8eRGqQ2xW4DWaERiXNgQHH86h/pDSpwBy', 'user', 5000000.00, 'roberto.jpg', 'Roberto Fernandez'),
(6, 'prueba', '$2y$10$gMCScVEtrGcKTXVahN2z5OyW6WZowx0PaySZgGYIGx5gXKHspNt16', 'user', 16000.00, '', 'prueba'),
(7, 'Henry', '$2y$10$dlU7zI0cnJ6cUphgEipDReNhEL6/VHp4ELa7sLOiWnkcnVf35Gw82', 'user', 20000.00, '', 'henry'),
(8, 'admin', '$2y$10$3Hxc2UAimmUWsb46c3SbH.mSlmFPQuK/WwIsdQL0zFxzulSonsFnG', 'admin', 0.00, '', '');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user_expense` (`id_user`),
  ADD KEY `id_category_expense` (`category_id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `expenses`
--
ALTER TABLE `expenses`
  ADD CONSTRAINT `id_category_expense` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `id_user_expense` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
