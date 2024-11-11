-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 11-11-2024 a las 05:17:53
-- Versión del servidor: 10.4.27-MariaDB
-- Versión de PHP: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `proyecto_tis1`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`) VALUES
(46, 'admin', 'admin@admin.cl', '$2y$10$hnEq7BCps9MjNagRZbMkoO64Y9u7SDComOz8hPrNiRbQA3tAnjiKu', 'admin'),
(47, 'maty', 'matias@matias.cl', '$2y$10$1EF01TysLiHJkPLD3UTfoes/f1ocQmAJfR5IV.ODk.0P8VUJsc13S', 'user'),
(50, 'pepe', 'pee@pee.cl', '$2y$10$G0pfGwL7/PNO.vJirg1PIOg5G4A1R7eqbzLq70FOZslR/6xlxdnVq', 'user'),
(51, 'prueba', 'prueba@prueba.cl', '$2y$10$48yLlR2mmE0EpSe0uN4i2.t4FRKE3lGY2ZCA7996b8eGvo8R6E5ma', 'user'),
(52, 'dan', 'dan.programas.oc@gmail.com', '$2y$10$zSbYIAYWhm0nPLPl0i0wBO3T1kXMmPCvJzz/s.wj8XrwwQjXm55VK', 'user');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
