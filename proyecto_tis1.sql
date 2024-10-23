-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 22-10-2024 a las 01:56:31
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
-- Estructura de tabla para la tabla `anc`
--

CREATE TABLE `anc` (
  `id_periferico` int(11) NOT NULL,
  `anc` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `anc`
--

INSERT INTO `anc` (`id_periferico`, `anc`) VALUES
(163, 'a'),
(164, 'vbaa');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asocia`
--

CREATE TABLE `asocia` (
  `id_orden` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bateria_notebook`
--

CREATE TABLE `bateria_notebook` (
  `id_notebook` int(11) NOT NULL,
  `bateria_notebook` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `capacidad_almacenamiento`
--

CREATE TABLE `capacidad_almacenamiento` (
  `id_hardware` int(11) NOT NULL,
  `capacidad_almacenamiento` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `capacidad_almacenamiento`
--

INSERT INTO `capacidad_almacenamiento` (`id_hardware`, `capacidad_almacenamiento`) VALUES
(40, '1gb'),
(41, '2gb');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `capacidad_ram`
--

CREATE TABLE `capacidad_ram` (
  `id_hardware` int(11) NOT NULL,
  `capacidad_ram` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria_teclado`
--

CREATE TABLE `categoria_teclado` (
  `id_periferico` int(11) NOT NULL,
  `categoria_teclado` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categoria_teclado`
--

INSERT INTO `categoria_teclado` (`id_periferico`, `categoria_teclado`) VALUES
(98, '100%'),
(99, '80%'),
(152, '60%');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `certificacion_fuente`
--

CREATE TABLE `certificacion_fuente` (
  `id_hardware` int(11) NOT NULL,
  `certificacion_fuente` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `conectividad`
--

CREATE TABLE `conectividad` (
  `id_periferico` int(11) NOT NULL,
  `conectividad` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `conectividad`
--

INSERT INTO `conectividad` (`id_periferico`, `conectividad`) VALUES
(76, 'Bluetooth'),
(141, 'Analogaaaa');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cpu_notebook`
--

CREATE TABLE `cpu_notebook` (
  `id_notebook` int(11) NOT NULL,
  `cpu_notebook` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dpi_mouse`
--

CREATE TABLE `dpi_mouse` (
  `id_periferico` int(11) NOT NULL,
  `dpi_mouse` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `dpi_mouse`
--

INSERT INTO `dpi_mouse` (`id_periferico`, `dpi_mouse`) VALUES
(77, '16000DPI');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `formato_placa`
--

CREATE TABLE `formato_placa` (
  `id_hardware` int(11) NOT NULL,
  `formato_placa` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `formato_ram`
--

CREATE TABLE `formato_ram` (
  `id_hardware` int(11) NOT NULL,
  `formato_ram` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `frecuencia_cpu`
--

CREATE TABLE `frecuencia_cpu` (
  `id_hardware` int(11) NOT NULL,
  `frecuencia_cpu` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `frecuencia_cpu`
--

INSERT INTO `frecuencia_cpu` (`id_hardware`, `frecuencia_cpu`) VALUES
(24, '1000');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `frecuencia_gpu`
--

CREATE TABLE `frecuencia_gpu` (
  `id_hardware` int(11) NOT NULL,
  `frecuencia_gpu` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gpu_notebook`
--

CREATE TABLE `gpu_notebook` (
  `id_notebook` int(11) NOT NULL,
  `gpu_notebook` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `hardware`
--

CREATE TABLE `hardware` (
  `id_hardware` int(11) NOT NULL,
  `id_producto` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `hardware`
--

INSERT INTO `hardware` (`id_hardware`, `id_producto`) VALUES
(24, NULL),
(32, NULL),
(34, NULL),
(39, NULL),
(40, NULL),
(41, NULL),
(44, NULL),
(47, NULL),
(48, NULL),
(49, NULL),
(53, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_compra`
--

CREATE TABLE `historial_compra` (
  `id_historal` int(11) NOT NULL,
  `estado` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `iluminacion`
--

CREATE TABLE `iluminacion` (
  `id_periferico` int(11) NOT NULL,
  `iluminacion` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `iluminacion`
--

INSERT INTO `iluminacion` (`id_periferico`, `iluminacion`) VALUES
(155, 'RGB');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lista_deseo`
--

CREATE TABLE `lista_deseo` (
  `nombre_lista` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `marca`
--

CREATE TABLE `marca` (
  `id_marca` int(11) NOT NULL,
  `nombre_marca` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `memoria`
--

CREATE TABLE `memoria` (
  `id_hardware` int(11) NOT NULL,
  `memoria` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `memoria_gpu`
--

CREATE TABLE `memoria_gpu` (
  `id_hardware` int(11) NOT NULL,
  `memoria_gpu` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `memoria_gpu`
--

INSERT INTO `memoria_gpu` (`id_hardware`, `memoria_gpu`) VALUES
(53, 'dasdassadas');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notebook`
--

CREATE TABLE `notebook` (
  `id_notebook` int(11) NOT NULL,
  `id_producto` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `notebook`
--

INSERT INTO `notebook` (`id_notebook`, `id_producto`) VALUES
(21, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nucleo_hilo_cpu`
--

CREATE TABLE `nucleo_hilo_cpu` (
  `id_hardware` int(11) NOT NULL,
  `nucleo_hilo_cpu` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `nucleo_hilo_cpu`
--

INSERT INTO `nucleo_hilo_cpu` (`id_hardware`, `nucleo_hilo_cpu`) VALUES
(39, '2 Nucleos / 2 Hilos'),
(47, '4 Nucleos / 4 Hilos');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `orden_compra`
--

CREATE TABLE `orden_compra` (
  `id_orden` int(11) NOT NULL,
  `fecha` date DEFAULT NULL,
  `forma_pago` varchar(50) DEFAULT NULL,
  `correo` varchar(255) DEFAULT NULL,
  `detalle_orden_precio` decimal(10,2) DEFAULT NULL,
  `detalle_orden_tipo_pago` varchar(255) DEFAULT NULL,
  `detalle_orden_cantidad` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pantalla_notebook`
--

CREATE TABLE `pantalla_notebook` (
  `id_notebook` int(11) NOT NULL,
  `pantalla_notebook` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pantalla_notebook`
--

INSERT INTO `pantalla_notebook` (`id_notebook`, `pantalla_notebook`) VALUES
(21, '14\"');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `periferico`
--

CREATE TABLE `periferico` (
  `id_periferico` int(11) NOT NULL,
  `id_producto` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `periferico`
--

INSERT INTO `periferico` (`id_periferico`, `id_producto`) VALUES
(66, NULL),
(75, NULL),
(76, NULL),
(77, NULL),
(78, NULL),
(79, NULL),
(80, NULL),
(81, NULL),
(82, NULL),
(86, NULL),
(141, NULL),
(154, NULL),
(155, NULL),
(156, NULL),
(158, NULL),
(159, NULL),
(161, NULL),
(163, NULL),
(164, NULL),
(168, NULL),
(169, NULL),
(170, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pertenece`
--

CREATE TABLE `pertenece` (
  `nombre_lista` varchar(255) NOT NULL,
  `id_producto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `peso_mouse`
--

CREATE TABLE `peso_mouse` (
  `id_periferico` int(11) NOT NULL,
  `peso_mouse` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `peso_mouse`
--

INSERT INTO `peso_mouse` (`id_periferico`, `peso_mouse`) VALUES
(161, '120g');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `potencia_fuente`
--

CREATE TABLE `potencia_fuente` (
  `id_hardware` int(11) NOT NULL,
  `potencia_fuente` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `id_producto` int(11) NOT NULL,
  `nombre_producto` varchar(255) DEFAULT NULL,
  `precio` decimal(10,2) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  `id_marca` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `resena_valoracion`
--

CREATE TABLE `resena_valoracion` (
  `id_resena` int(11) NOT NULL,
  `clasificacion` int(11) DEFAULT NULL,
  `comentario` text DEFAULT NULL,
  `respuesta` text DEFAULT NULL,
  `id_producto` int(11) DEFAULT NULL,
  `correo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `resolucion_monitor`
--

CREATE TABLE `resolucion_monitor` (
  `id_periferico` int(11) NOT NULL,
  `resolucion_monitor` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `resolucion_monitor`
--

INSERT INTO `resolucion_monitor` (`id_periferico`, `resolucion_monitor`) VALUES
(81, 'Full HD (1920x1080)');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sensor_mouse`
--

CREATE TABLE `sensor_mouse` (
  `id_periferico` int(11) NOT NULL,
  `sensor_mouse` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `sensor_mouse`
--

INSERT INTO `sensor_mouse` (`id_periferico`, `sensor_mouse`) VALUES
(75, 'Optico');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `slot_memoria_placa`
--

CREATE TABLE `slot_memoria_placa` (
  `id_hardware` int(11) NOT NULL,
  `slot_memoria_placa` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `slot_memoria_placa`
--

INSERT INTO `slot_memoria_placa` (`id_hardware`, `slot_memoria_placa`) VALUES
(34, '4');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `socket_cpu`
--

CREATE TABLE `socket_cpu` (
  `id_hardware` int(11) NOT NULL,
  `socket_cpu` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `socket_placa`
--

CREATE TABLE `socket_placa` (
  `id_hardware` int(11) NOT NULL,
  `socket_placa` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `socket_placa`
--

INSERT INTO `socket_placa` (`id_hardware`, `socket_placa`) VALUES
(32, 'atx');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `soporte_monitor`
--

CREATE TABLE `soporte_monitor` (
  `id_periferico` int(11) NOT NULL,
  `soporte_monitor` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `soporte_monitor`
--

INSERT INTO `soporte_monitor` (`id_periferico`, `soporte_monitor`) VALUES
(170, 'G-Sync / FreeSync');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tamanio_fuente`
--

CREATE TABLE `tamanio_fuente` (
  `id_hardware` int(11) NOT NULL,
  `tamanio_fuente` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tamanio_max_gabinete`
--

CREATE TABLE `tamanio_max_gabinete` (
  `id_hardware` int(11) NOT NULL,
  `tamanio_max_gabinete` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tamanio_monitor`
--

CREATE TABLE `tamanio_monitor` (
  `id_periferico` int(11) NOT NULL,
  `tamanio_monitor` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tamanio_monitor`
--

INSERT INTO `tamanio_monitor` (`id_periferico`, `tamanio_monitor`) VALUES
(78, '24.0\"');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tamanio_placa`
--

CREATE TABLE `tamanio_placa` (
  `id_hardware` int(11) NOT NULL,
  `tamanio_placa` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tasa_refresco`
--

CREATE TABLE `tasa_refresco` (
  `id_periferico` int(11) NOT NULL,
  `tasa_refresco` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tasa_refresco`
--

INSERT INTO `tasa_refresco` (`id_periferico`, `tasa_refresco`) VALUES
(168, '60hz');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tiempo_respuesta`
--

CREATE TABLE `tiempo_respuesta` (
  `id_periferico` int(11) NOT NULL,
  `tiempo_respuesta` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tiempo_respuesta`
--

INSERT INTO `tiempo_respuesta` (`id_periferico`, `tiempo_respuesta`) VALUES
(80, '5 ms');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_audifono`
--

CREATE TABLE `tipo_audifono` (
  `id_periferico` int(11) NOT NULL,
  `tipo_audifono` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_cableado`
--

CREATE TABLE `tipo_cableado` (
  `id_hardware` int(11) NOT NULL,
  `tipo_cableado` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_curvatura`
--

CREATE TABLE `tipo_curvatura` (
  `id_periferico` int(11) NOT NULL,
  `tipo_curvatura` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipo_curvatura`
--

INSERT INTO `tipo_curvatura` (`id_periferico`, `tipo_curvatura`) VALUES
(79, 'Si');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_microfono`
--

CREATE TABLE `tipo_microfono` (
  `id_periferico` int(11) NOT NULL,
  `tipo_microfono` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipo_microfono`
--

INSERT INTO `tipo_microfono` (`id_periferico`, `tipo_microfono`) VALUES
(156, 'asdasd');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_panel`
--

CREATE TABLE `tipo_panel` (
  `id_periferico` int(11) NOT NULL,
  `tipo_panel` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipo_panel`
--

INSERT INTO `tipo_panel` (`id_periferico`, `tipo_panel`) VALUES
(82, 'LED');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_ram`
--

CREATE TABLE `tipo_ram` (
  `id_hardware` int(11) NOT NULL,
  `tipo_ram` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipo_ram`
--

INSERT INTO `tipo_ram` (`id_hardware`, `tipo_ram`) VALUES
(44, 'ddr5');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_switch`
--

CREATE TABLE `tipo_switch` (
  `id_periferico` int(11) NOT NULL,
  `tipo_switch` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipo_switch`
--

INSERT INTO `tipo_switch` (`id_periferico`, `tipo_switch`) VALUES
(159, 'Azul');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_teclado`
--

CREATE TABLE `tipo_teclado` (
  `id_periferico` int(11) NOT NULL,
  `tipo_teclado` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipo_teclado`
--

INSERT INTO `tipo_teclado` (`id_periferico`, `tipo_teclado`) VALUES
(66, 'Mecanico'),
(86, 'Membrana'),
(154, 'brazo de 35');

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
(10, 'dan', 'dan.programas.oc@gmail.com', '$2y$10$GXfHu4BB4Qfb76LZV.mRv.OeNVtusB5QJNzk2gLJYKXaAbxiTTmIa', 'admin'),
(24, 'matias', 'asdas@asdas.com', '$2y$10$KgQcSH91oMbsM0xFZLacgeDZP6ZkUX9l6MDd3PGUVpP4Q6BDIMPtW', 'admin'),
(29, 'asdas', 'paz835134@gmail.com', '$2y$10$CawUD1kdtC.TksPZWm/q1.yC5kt6UKC1pISsAnOYqVLQ1.8SllvUu', 'user'),
(31, 'dan', 'msanchezs@ebasica.ucsc.cl', '$2y$10$zO70QxFYpOT5rmSmiunc2e316T0UqxahTjHQStqI9QRJJt1mT2wq.', 'user'),
(32, 'usuario1', 'usuario1@example.com', 'contraseña1', 'user'),
(33, 'usuario2', 'usuario2@example.com', 'contraseña2', 'user'),
(34, 'usuario3', 'usuario3@example.com', 'contraseña3', 'user'),
(35, 'usuario4', 'usuario4@example.com', 'contraseña4', 'user'),
(36, 'usuario5', 'usuario5@example.com', 'contraseña5', 'user'),
(37, 'usuario6', 'usuario6@example.com', 'contraseña6', 'user'),
(38, 'usuario7', 'usuario7@example.com', 'contraseña7', 'user'),
(39, 'usuario8', 'usuario8@example.com', 'contraseña8', 'user'),
(40, 'usuario9', 'usuario9@example.com', 'contraseña9', 'user'),
(41, 'usuario10', 'usuario10@example.com', 'contraseña10', 'user'),
(44, 'matias', 'matias@matias.cl', '$2y$10$6LQ1h.XYve6cCXiLxVW8.OOK2nDLePiLPeXKRa0zd4NcO71G6x4.m', 'admin');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `correo` varchar(255) NOT NULL,
  `contrasena` varchar(255) DEFAULT NULL,
  `nombre_usuario` varchar(255) DEFAULT NULL,
  `rut` varchar(50) DEFAULT NULL,
  `rol` enum('registrado','no_registrado','administrador') DEFAULT NULL,
  `id_historal` int(11) DEFAULT NULL,
  `nombre_lista` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `velocidad_ram`
--

CREATE TABLE `velocidad_ram` (
  `id_hardware` int(11) NOT NULL,
  `velocidad_ram` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `voltaje_ram`
--

CREATE TABLE `voltaje_ram` (
  `id_hardware` int(11) NOT NULL,
  `voltaje_ram` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `anc`
--
ALTER TABLE `anc`
  ADD PRIMARY KEY (`id_periferico`);

--
-- Indices de la tabla `asocia`
--
ALTER TABLE `asocia`
  ADD PRIMARY KEY (`id_orden`,`id_producto`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indices de la tabla `bateria_notebook`
--
ALTER TABLE `bateria_notebook`
  ADD PRIMARY KEY (`id_notebook`);

--
-- Indices de la tabla `capacidad_almacenamiento`
--
ALTER TABLE `capacidad_almacenamiento`
  ADD PRIMARY KEY (`id_hardware`);

--
-- Indices de la tabla `capacidad_ram`
--
ALTER TABLE `capacidad_ram`
  ADD PRIMARY KEY (`id_hardware`);

--
-- Indices de la tabla `categoria_teclado`
--
ALTER TABLE `categoria_teclado`
  ADD PRIMARY KEY (`id_periferico`);

--
-- Indices de la tabla `certificacion_fuente`
--
ALTER TABLE `certificacion_fuente`
  ADD PRIMARY KEY (`id_hardware`);

--
-- Indices de la tabla `conectividad`
--
ALTER TABLE `conectividad`
  ADD PRIMARY KEY (`id_periferico`);

--
-- Indices de la tabla `cpu_notebook`
--
ALTER TABLE `cpu_notebook`
  ADD PRIMARY KEY (`id_notebook`);

--
-- Indices de la tabla `dpi_mouse`
--
ALTER TABLE `dpi_mouse`
  ADD PRIMARY KEY (`id_periferico`);

--
-- Indices de la tabla `formato_placa`
--
ALTER TABLE `formato_placa`
  ADD PRIMARY KEY (`id_hardware`);

--
-- Indices de la tabla `formato_ram`
--
ALTER TABLE `formato_ram`
  ADD PRIMARY KEY (`id_hardware`);

--
-- Indices de la tabla `frecuencia_cpu`
--
ALTER TABLE `frecuencia_cpu`
  ADD PRIMARY KEY (`id_hardware`);

--
-- Indices de la tabla `frecuencia_gpu`
--
ALTER TABLE `frecuencia_gpu`
  ADD PRIMARY KEY (`id_hardware`);

--
-- Indices de la tabla `gpu_notebook`
--
ALTER TABLE `gpu_notebook`
  ADD PRIMARY KEY (`id_notebook`);

--
-- Indices de la tabla `hardware`
--
ALTER TABLE `hardware`
  ADD PRIMARY KEY (`id_hardware`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indices de la tabla `historial_compra`
--
ALTER TABLE `historial_compra`
  ADD PRIMARY KEY (`id_historal`);

--
-- Indices de la tabla `iluminacion`
--
ALTER TABLE `iluminacion`
  ADD PRIMARY KEY (`id_periferico`);

--
-- Indices de la tabla `lista_deseo`
--
ALTER TABLE `lista_deseo`
  ADD PRIMARY KEY (`nombre_lista`);

--
-- Indices de la tabla `marca`
--
ALTER TABLE `marca`
  ADD PRIMARY KEY (`id_marca`);

--
-- Indices de la tabla `memoria`
--
ALTER TABLE `memoria`
  ADD PRIMARY KEY (`id_hardware`);

--
-- Indices de la tabla `memoria_gpu`
--
ALTER TABLE `memoria_gpu`
  ADD PRIMARY KEY (`id_hardware`);

--
-- Indices de la tabla `notebook`
--
ALTER TABLE `notebook`
  ADD PRIMARY KEY (`id_notebook`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indices de la tabla `nucleo_hilo_cpu`
--
ALTER TABLE `nucleo_hilo_cpu`
  ADD PRIMARY KEY (`id_hardware`);

--
-- Indices de la tabla `orden_compra`
--
ALTER TABLE `orden_compra`
  ADD PRIMARY KEY (`id_orden`),
  ADD KEY `correo` (`correo`);

--
-- Indices de la tabla `pantalla_notebook`
--
ALTER TABLE `pantalla_notebook`
  ADD PRIMARY KEY (`id_notebook`);

--
-- Indices de la tabla `periferico`
--
ALTER TABLE `periferico`
  ADD PRIMARY KEY (`id_periferico`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indices de la tabla `pertenece`
--
ALTER TABLE `pertenece`
  ADD PRIMARY KEY (`nombre_lista`,`id_producto`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indices de la tabla `peso_mouse`
--
ALTER TABLE `peso_mouse`
  ADD PRIMARY KEY (`id_periferico`);

--
-- Indices de la tabla `potencia_fuente`
--
ALTER TABLE `potencia_fuente`
  ADD PRIMARY KEY (`id_hardware`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`id_producto`);

--
-- Indices de la tabla `resena_valoracion`
--
ALTER TABLE `resena_valoracion`
  ADD PRIMARY KEY (`id_resena`),
  ADD KEY `id_producto` (`id_producto`),
  ADD KEY `correo` (`correo`);

--
-- Indices de la tabla `resolucion_monitor`
--
ALTER TABLE `resolucion_monitor`
  ADD PRIMARY KEY (`id_periferico`);

--
-- Indices de la tabla `sensor_mouse`
--
ALTER TABLE `sensor_mouse`
  ADD PRIMARY KEY (`id_periferico`);

--
-- Indices de la tabla `slot_memoria_placa`
--
ALTER TABLE `slot_memoria_placa`
  ADD PRIMARY KEY (`id_hardware`);

--
-- Indices de la tabla `socket_cpu`
--
ALTER TABLE `socket_cpu`
  ADD PRIMARY KEY (`id_hardware`);

--
-- Indices de la tabla `socket_placa`
--
ALTER TABLE `socket_placa`
  ADD PRIMARY KEY (`id_hardware`);

--
-- Indices de la tabla `soporte_monitor`
--
ALTER TABLE `soporte_monitor`
  ADD PRIMARY KEY (`id_periferico`);

--
-- Indices de la tabla `tamanio_fuente`
--
ALTER TABLE `tamanio_fuente`
  ADD PRIMARY KEY (`id_hardware`);

--
-- Indices de la tabla `tamanio_max_gabinete`
--
ALTER TABLE `tamanio_max_gabinete`
  ADD PRIMARY KEY (`id_hardware`);

--
-- Indices de la tabla `tamanio_monitor`
--
ALTER TABLE `tamanio_monitor`
  ADD PRIMARY KEY (`id_periferico`);

--
-- Indices de la tabla `tamanio_placa`
--
ALTER TABLE `tamanio_placa`
  ADD PRIMARY KEY (`id_hardware`);

--
-- Indices de la tabla `tasa_refresco`
--
ALTER TABLE `tasa_refresco`
  ADD PRIMARY KEY (`id_periferico`);

--
-- Indices de la tabla `tiempo_respuesta`
--
ALTER TABLE `tiempo_respuesta`
  ADD PRIMARY KEY (`id_periferico`);

--
-- Indices de la tabla `tipo_audifono`
--
ALTER TABLE `tipo_audifono`
  ADD PRIMARY KEY (`id_periferico`);

--
-- Indices de la tabla `tipo_cableado`
--
ALTER TABLE `tipo_cableado`
  ADD PRIMARY KEY (`id_hardware`);

--
-- Indices de la tabla `tipo_curvatura`
--
ALTER TABLE `tipo_curvatura`
  ADD PRIMARY KEY (`id_periferico`);

--
-- Indices de la tabla `tipo_microfono`
--
ALTER TABLE `tipo_microfono`
  ADD PRIMARY KEY (`id_periferico`);

--
-- Indices de la tabla `tipo_panel`
--
ALTER TABLE `tipo_panel`
  ADD PRIMARY KEY (`id_periferico`);

--
-- Indices de la tabla `tipo_ram`
--
ALTER TABLE `tipo_ram`
  ADD PRIMARY KEY (`id_hardware`);

--
-- Indices de la tabla `tipo_switch`
--
ALTER TABLE `tipo_switch`
  ADD PRIMARY KEY (`id_periferico`);

--
-- Indices de la tabla `tipo_teclado`
--
ALTER TABLE `tipo_teclado`
  ADD PRIMARY KEY (`id_periferico`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`correo`);

--
-- Indices de la tabla `velocidad_ram`
--
ALTER TABLE `velocidad_ram`
  ADD PRIMARY KEY (`id_hardware`);

--
-- Indices de la tabla `voltaje_ram`
--
ALTER TABLE `voltaje_ram`
  ADD PRIMARY KEY (`id_hardware`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `hardware`
--
ALTER TABLE `hardware`
  MODIFY `id_hardware` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT de la tabla `historial_compra`
--
ALTER TABLE `historial_compra`
  MODIFY `id_historal` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `marca`
--
ALTER TABLE `marca`
  MODIFY `id_marca` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `notebook`
--
ALTER TABLE `notebook`
  MODIFY `id_notebook` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `orden_compra`
--
ALTER TABLE `orden_compra`
  MODIFY `id_orden` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `periferico`
--
ALTER TABLE `periferico`
  MODIFY `id_periferico` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=171;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `resena_valoracion`
--
ALTER TABLE `resena_valoracion`
  MODIFY `id_resena` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `anc`
--
ALTER TABLE `anc`
  ADD CONSTRAINT `anc_ibfk_1` FOREIGN KEY (`id_periferico`) REFERENCES `periferico` (`id_periferico`);

--
-- Filtros para la tabla `asocia`
--
ALTER TABLE `asocia`
  ADD CONSTRAINT `asocia_ibfk_1` FOREIGN KEY (`id_orden`) REFERENCES `orden_compra` (`id_orden`),
  ADD CONSTRAINT `asocia_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`);

--
-- Filtros para la tabla `bateria_notebook`
--
ALTER TABLE `bateria_notebook`
  ADD CONSTRAINT `bateria_notebook_ibfk_1` FOREIGN KEY (`id_notebook`) REFERENCES `notebook` (`id_notebook`);

--
-- Filtros para la tabla `capacidad_almacenamiento`
--
ALTER TABLE `capacidad_almacenamiento`
  ADD CONSTRAINT `capacidad_almacenamiento_ibfk_1` FOREIGN KEY (`id_hardware`) REFERENCES `hardware` (`id_hardware`);

--
-- Filtros para la tabla `capacidad_ram`
--
ALTER TABLE `capacidad_ram`
  ADD CONSTRAINT `capacidad_ram_ibfk_1` FOREIGN KEY (`id_hardware`) REFERENCES `hardware` (`id_hardware`);

--
-- Filtros para la tabla `certificacion_fuente`
--
ALTER TABLE `certificacion_fuente`
  ADD CONSTRAINT `certificacion_fuente_ibfk_1` FOREIGN KEY (`id_hardware`) REFERENCES `hardware` (`id_hardware`);

--
-- Filtros para la tabla `conectividad`
--
ALTER TABLE `conectividad`
  ADD CONSTRAINT `conectividad_ibfk_1` FOREIGN KEY (`id_periferico`) REFERENCES `periferico` (`id_periferico`);

--
-- Filtros para la tabla `cpu_notebook`
--
ALTER TABLE `cpu_notebook`
  ADD CONSTRAINT `cpu_notebook_ibfk_1` FOREIGN KEY (`id_notebook`) REFERENCES `notebook` (`id_notebook`);

--
-- Filtros para la tabla `dpi_mouse`
--
ALTER TABLE `dpi_mouse`
  ADD CONSTRAINT `dpi_mouse_ibfk_1` FOREIGN KEY (`id_periferico`) REFERENCES `periferico` (`id_periferico`);

--
-- Filtros para la tabla `formato_placa`
--
ALTER TABLE `formato_placa`
  ADD CONSTRAINT `formato_placa_ibfk_1` FOREIGN KEY (`id_hardware`) REFERENCES `hardware` (`id_hardware`);

--
-- Filtros para la tabla `formato_ram`
--
ALTER TABLE `formato_ram`
  ADD CONSTRAINT `formato_ram_ibfk_1` FOREIGN KEY (`id_hardware`) REFERENCES `hardware` (`id_hardware`);

--
-- Filtros para la tabla `frecuencia_cpu`
--
ALTER TABLE `frecuencia_cpu`
  ADD CONSTRAINT `frecuencia_cpu_ibfk_1` FOREIGN KEY (`id_hardware`) REFERENCES `hardware` (`id_hardware`);

--
-- Filtros para la tabla `frecuencia_gpu`
--
ALTER TABLE `frecuencia_gpu`
  ADD CONSTRAINT `frecuencia_gpu_ibfk_1` FOREIGN KEY (`id_hardware`) REFERENCES `hardware` (`id_hardware`);

--
-- Filtros para la tabla `gpu_notebook`
--
ALTER TABLE `gpu_notebook`
  ADD CONSTRAINT `gpu_notebook_ibfk_1` FOREIGN KEY (`id_notebook`) REFERENCES `notebook` (`id_notebook`);

--
-- Filtros para la tabla `hardware`
--
ALTER TABLE `hardware`
  ADD CONSTRAINT `hardware_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`);

--
-- Filtros para la tabla `iluminacion`
--
ALTER TABLE `iluminacion`
  ADD CONSTRAINT `iluminacion_ibfk_1` FOREIGN KEY (`id_periferico`) REFERENCES `periferico` (`id_periferico`);

--
-- Filtros para la tabla `memoria`
--
ALTER TABLE `memoria`
  ADD CONSTRAINT `memoria_ibfk_1` FOREIGN KEY (`id_hardware`) REFERENCES `hardware` (`id_hardware`);

--
-- Filtros para la tabla `notebook`
--
ALTER TABLE `notebook`
  ADD CONSTRAINT `notebook_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`);

--
-- Filtros para la tabla `nucleo_hilo_cpu`
--
ALTER TABLE `nucleo_hilo_cpu`
  ADD CONSTRAINT `nucleo_hilo_cpu_ibfk_1` FOREIGN KEY (`id_hardware`) REFERENCES `hardware` (`id_hardware`);

--
-- Filtros para la tabla `orden_compra`
--
ALTER TABLE `orden_compra`
  ADD CONSTRAINT `orden_compra_ibfk_1` FOREIGN KEY (`correo`) REFERENCES `usuario` (`correo`);

--
-- Filtros para la tabla `pantalla_notebook`
--
ALTER TABLE `pantalla_notebook`
  ADD CONSTRAINT `pantalla_notebook_ibfk_1` FOREIGN KEY (`id_notebook`) REFERENCES `notebook` (`id_notebook`);

--
-- Filtros para la tabla `periferico`
--
ALTER TABLE `periferico`
  ADD CONSTRAINT `periferico_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`);

--
-- Filtros para la tabla `pertenece`
--
ALTER TABLE `pertenece`
  ADD CONSTRAINT `pertenece_ibfk_1` FOREIGN KEY (`nombre_lista`) REFERENCES `lista_deseo` (`nombre_lista`) ON DELETE CASCADE,
  ADD CONSTRAINT `pertenece_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`) ON DELETE CASCADE;

--
-- Filtros para la tabla `peso_mouse`
--
ALTER TABLE `peso_mouse`
  ADD CONSTRAINT `peso_mouse_ibfk_1` FOREIGN KEY (`id_periferico`) REFERENCES `periferico` (`id_periferico`);

--
-- Filtros para la tabla `potencia_fuente`
--
ALTER TABLE `potencia_fuente`
  ADD CONSTRAINT `potencia_fuente_ibfk_1` FOREIGN KEY (`id_hardware`) REFERENCES `hardware` (`id_hardware`);

--
-- Filtros para la tabla `resena_valoracion`
--
ALTER TABLE `resena_valoracion`
  ADD CONSTRAINT `resena_valoracion_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`),
  ADD CONSTRAINT `resena_valoracion_ibfk_2` FOREIGN KEY (`correo`) REFERENCES `usuario` (`correo`);

--
-- Filtros para la tabla `resolucion_monitor`
--
ALTER TABLE `resolucion_monitor`
  ADD CONSTRAINT `resolucion_monitor_ibfk_1` FOREIGN KEY (`id_periferico`) REFERENCES `periferico` (`id_periferico`);

--
-- Filtros para la tabla `sensor_mouse`
--
ALTER TABLE `sensor_mouse`
  ADD CONSTRAINT `sensor_mouse_ibfk_1` FOREIGN KEY (`id_periferico`) REFERENCES `periferico` (`id_periferico`);

--
-- Filtros para la tabla `slot_memoria_placa`
--
ALTER TABLE `slot_memoria_placa`
  ADD CONSTRAINT `slot_memoria_placa_ibfk_1` FOREIGN KEY (`id_hardware`) REFERENCES `hardware` (`id_hardware`);

--
-- Filtros para la tabla `socket_cpu`
--
ALTER TABLE `socket_cpu`
  ADD CONSTRAINT `socket_cpu_ibfk_1` FOREIGN KEY (`id_hardware`) REFERENCES `hardware` (`id_hardware`);

--
-- Filtros para la tabla `socket_placa`
--
ALTER TABLE `socket_placa`
  ADD CONSTRAINT `socket_placa_ibfk_1` FOREIGN KEY (`id_hardware`) REFERENCES `hardware` (`id_hardware`);

--
-- Filtros para la tabla `soporte_monitor`
--
ALTER TABLE `soporte_monitor`
  ADD CONSTRAINT `soporte_monitor_ibfk_1` FOREIGN KEY (`id_periferico`) REFERENCES `periferico` (`id_periferico`);

--
-- Filtros para la tabla `tamanio_fuente`
--
ALTER TABLE `tamanio_fuente`
  ADD CONSTRAINT `tamanio_fuente_ibfk_1` FOREIGN KEY (`id_hardware`) REFERENCES `hardware` (`id_hardware`);

--
-- Filtros para la tabla `tamanio_max_gabinete`
--
ALTER TABLE `tamanio_max_gabinete`
  ADD CONSTRAINT `tamanio_max_gabinete_ibfk_1` FOREIGN KEY (`id_hardware`) REFERENCES `hardware` (`id_hardware`);

--
-- Filtros para la tabla `tamanio_monitor`
--
ALTER TABLE `tamanio_monitor`
  ADD CONSTRAINT `tamanio_monitor_ibfk_1` FOREIGN KEY (`id_periferico`) REFERENCES `periferico` (`id_periferico`);

--
-- Filtros para la tabla `tamanio_placa`
--
ALTER TABLE `tamanio_placa`
  ADD CONSTRAINT `tamanio_placa_ibfk_1` FOREIGN KEY (`id_hardware`) REFERENCES `hardware` (`id_hardware`);

--
-- Filtros para la tabla `tasa_refresco`
--
ALTER TABLE `tasa_refresco`
  ADD CONSTRAINT `tasa_refresco_ibfk_1` FOREIGN KEY (`id_periferico`) REFERENCES `periferico` (`id_periferico`);

--
-- Filtros para la tabla `tiempo_respuesta`
--
ALTER TABLE `tiempo_respuesta`
  ADD CONSTRAINT `tiempo_respuesta_ibfk_1` FOREIGN KEY (`id_periferico`) REFERENCES `periferico` (`id_periferico`);

--
-- Filtros para la tabla `tipo_audifono`
--
ALTER TABLE `tipo_audifono`
  ADD CONSTRAINT `tipo_audifono_ibfk_1` FOREIGN KEY (`id_periferico`) REFERENCES `periferico` (`id_periferico`);

--
-- Filtros para la tabla `tipo_cableado`
--
ALTER TABLE `tipo_cableado`
  ADD CONSTRAINT `tipo_cableado_ibfk_1` FOREIGN KEY (`id_hardware`) REFERENCES `hardware` (`id_hardware`);

--
-- Filtros para la tabla `tipo_curvatura`
--
ALTER TABLE `tipo_curvatura`
  ADD CONSTRAINT `tipo_curvatura_ibfk_1` FOREIGN KEY (`id_periferico`) REFERENCES `periferico` (`id_periferico`);

--
-- Filtros para la tabla `tipo_microfono`
--
ALTER TABLE `tipo_microfono`
  ADD CONSTRAINT `tipo_microfono_ibfk_1` FOREIGN KEY (`id_periferico`) REFERENCES `periferico` (`id_periferico`);

--
-- Filtros para la tabla `tipo_panel`
--
ALTER TABLE `tipo_panel`
  ADD CONSTRAINT `tipo_panel_ibfk_1` FOREIGN KEY (`id_periferico`) REFERENCES `periferico` (`id_periferico`);

--
-- Filtros para la tabla `tipo_ram`
--
ALTER TABLE `tipo_ram`
  ADD CONSTRAINT `tipo_ram_ibfk_1` FOREIGN KEY (`id_hardware`) REFERENCES `hardware` (`id_hardware`);

--
-- Filtros para la tabla `tipo_switch`
--
ALTER TABLE `tipo_switch`
  ADD CONSTRAINT `tipo_switch_ibfk_1` FOREIGN KEY (`id_periferico`) REFERENCES `periferico` (`id_periferico`);

--
-- Filtros para la tabla `tipo_teclado`
--
ALTER TABLE `tipo_teclado`
  ADD CONSTRAINT `tipo_teclado_ibfk_1` FOREIGN KEY (`id_periferico`) REFERENCES `periferico` (`id_periferico`);

--
-- Filtros para la tabla `velocidad_ram`
--
ALTER TABLE `velocidad_ram`
  ADD CONSTRAINT `velocidad_ram_ibfk_1` FOREIGN KEY (`id_hardware`) REFERENCES `hardware` (`id_hardware`);

--
-- Filtros para la tabla `voltaje_ram`
--
ALTER TABLE `voltaje_ram`
  ADD CONSTRAINT `voltaje_ram_ibfk_1` FOREIGN KEY (`id_hardware`) REFERENCES `hardware` (`id_hardware`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
