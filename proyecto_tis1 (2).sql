-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 30-11-2024 a las 09:00:46
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
-- Estructura de tabla para la tabla `agregar_carrito`
--

CREATE TABLE `agregar_carrito` (
  `id_carrito` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `agregar_carrito`
--

INSERT INTO `agregar_carrito` (`id_carrito`, `id_producto`, `cantidad`) VALUES
(1, 35, 1),
(2, 36, 2),
(3, 37, 3),
(4, 35, 1),
(5, 36, 2),
(6, 37, 3),
(7, 35, 1),
(8, 36, 2),
(9, 37, 3);

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
(178, 'Si'),
(196, 'No');

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
-- Estructura de tabla para la tabla `atencion_postventa`
--

CREATE TABLE `atencion_postventa` (
  `id` int(11) NOT NULL,
  `cliente_nombre` varchar(255) DEFAULT NULL,
  `cliente_email` varchar(255) DEFAULT NULL,
  `pregunta` text DEFAULT NULL,
  `respuesta` text DEFAULT NULL,
  `fecha_pregunta` datetime DEFAULT current_timestamp(),
  `fecha_respuesta` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `atencion_postventa`
--

INSERT INTO `atencion_postventa` (`id`, `cliente_nombre`, `cliente_email`, `pregunta`, `respuesta`, `fecha_pregunta`, `fecha_respuesta`) VALUES
(1, 'pedro', 'admin@admin.cl', 'hola]?', NULL, '2024-11-20 00:39:59', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bateria_notebook`
--

CREATE TABLE `bateria_notebook` (
  `id_notebook` int(11) NOT NULL,
  `bateria_notebook` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `bateria_notebook`
--

INSERT INTO `bateria_notebook` (`id_notebook`, `bateria_notebook`) VALUES
(24, '60000 mWh'),
(27, '45000 mWh');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `boletas`
--

CREATE TABLE `boletas` (
  `id_boleta` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `fecha` datetime NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `codigo_autorizacion` varchar(50) NOT NULL,
  `detalles` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`detalles`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `boletas`
--

INSERT INTO `boletas` (`id_boleta`, `id_usuario`, `fecha`, `total`, `codigo_autorizacion`, `detalles`) VALUES
(2, 46, '2024-11-10 22:10:09', '300000.00', '1213', '[{\"producto\":\"Monitor Gamer\",\"cantidad\":2,\"precio_unitario\":\"120000.00\",\"total\":240000},{\"producto\":\"Teclado gamer\",\"cantidad\":1,\"precio_unitario\":\"60000.00\",\"total\":60000}]'),
(3, 46, '2024-11-11 01:09:47', '60000.00', '1213', '[{\"producto\":\"Teclado gamer\",\"cantidad\":1,\"precio_unitario\":\"60000.00\",\"total\":60000}]'),
(4, 46, '2024-11-19 02:16:54', '120000.00', '1213', '[{\"producto\":\"Audifono generico\",\"cantidad\":12,\"precio_unitario\":\"10000\",\"total\":120000}]'),
(5, 46, '2024-11-20 01:03:50', '60000.00', '1213', '[{\"producto\":\"Teclado gamer\",\"cantidad\":1,\"precio_unitario\":\"60000\",\"total\":60000}]');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bus_de_entrada_gpu`
--

CREATE TABLE `bus_de_entrada_gpu` (
  `id_hardware` int(11) NOT NULL,
  `bus_de_entrada_gpu` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `bus_de_entrada_gpu`
--

INSERT INTO `bus_de_entrada_gpu` (`id_hardware`, `bus_de_entrada_gpu`) VALUES
(84, 'PCI Express 2.0 x16'),
(100, 'PCI Express 4.0 x8');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bus_hdd`
--

CREATE TABLE `bus_hdd` (
  `id_hardware` int(11) NOT NULL,
  `bus_hdd` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `bus_hdd`
--

INSERT INTO `bus_hdd` (`id_hardware`, `bus_hdd`) VALUES
(76, 'SATA 3 (6.0 Gb/s)');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bus_ssd`
--

CREATE TABLE `bus_ssd` (
  `id_hardware` int(11) NOT NULL,
  `bus_ssd` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `bus_ssd`
--

INSERT INTO `bus_ssd` (`id_hardware`, `bus_ssd`) VALUES
(89, 'SATA 3 (6.0 Gb/s)'),
(90, 'PCIe 4.0 x4');

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
(40, '500GB'),
(41, '1TB'),
(87, '2TB');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `capacidad_ram`
--

CREATE TABLE `capacidad_ram` (
  `id_hardware` int(11) NOT NULL,
  `capacidad_ram` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `capacidad_ram`
--

INSERT INTO `capacidad_ram` (`id_hardware`, `capacidad_ram`) VALUES
(56, '1 x 8 GB'),
(96, '1 x 4 GB'),
(117, '1 x 12 GB');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id_categoria` int(11) NOT NULL,
  `nombre_categoria` varchar(255) NOT NULL,
  `subcategoria` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id_categoria`, `nombre_categoria`, `subcategoria`) VALUES
(1, 'Monitor', 'Gamer'),
(2, 'Monitor', NULL),
(3, 'PEPE', NULL),
(4, 'Monitor', NULL),
(5, 'Monitor', NULL),
(6, 'rico', 'Gamer'),
(7, 'aaa', 'aaaaaa');

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
(173, '100% (Teclado full)'),
(174, '80% (Tenkeyless)'),
(175, '60%');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `certificacion_fuente`
--

CREATE TABLE `certificacion_fuente` (
  `id_hardware` int(11) NOT NULL,
  `certificacion_fuente` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `certificacion_fuente`
--

INSERT INTO `certificacion_fuente` (`id_hardware`, `certificacion_fuente`) VALUES
(65, '80PLUS Bronze'),
(70, 'Sin certificación'),
(113, 'Gold Blanca'),
(115, 'Platinum');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `chipset_placa`
--

CREATE TABLE `chipset_placa` (
  `id_hardware` int(11) NOT NULL,
  `chipset_placa` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `chipset_placa`
--

INSERT INTO `chipset_placa` (`id_hardware`, `chipset_placa`) VALUES
(63, 'AMD B550 (AM4)'),
(106, 'AMD A68H (FM2+)');

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
(141, 'Analoga');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cpu_notebook`
--

CREATE TABLE `cpu_notebook` (
  `id_notebook` int(11) NOT NULL,
  `cpu_notebook` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cpu_notebook`
--

INSERT INTO `cpu_notebook` (`id_notebook`, `cpu_notebook`) VALUES
(23, 'Intel Core i7-13620H (2400 MHz - 4900 MHz)'),
(28, 'AMD Ryzen 5 6600H (3300 MHz - 4500 MHz)');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_boletas`
--

CREATE TABLE `detalle_boletas` (
  `id_detalle_boleta` int(11) NOT NULL,
  `id_boleta` int(11) DEFAULT NULL,
  `id_producto` int(11) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `precio_unitario` decimal(10,2) DEFAULT NULL,
  `precio_total` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detalle_boletas`
--

INSERT INTO `detalle_boletas` (`id_detalle_boleta`, `id_boleta`, `id_producto`, `cantidad`, `precio_unitario`, `precio_total`) VALUES
(2, 11, 35, 1, '60000.00', '60000.00'),
(3, 12, 35, 1, '60000.00', '60000.00'),
(4, 13, 36, 1, '120000.00', '120000.00'),
(5, 14, 35, 1, '60000.00', '60000.00'),
(6, 14, 36, 5, '120000.00', '600000.00'),
(7, 15, 35, 1, '60000.00', '60000.00'),
(8, 16, 35, 1, '60000.00', '60000.00'),
(9, 17, 35, 1, '60000.00', '60000.00'),
(10, 18, 36, 1, '120000.00', '120000.00'),
(11, 19, 35, 1, '60000.00', '60000.00'),
(12, 20, 36, 1, '120000.00', '120000.00'),
(13, 21, 35, 1, '60000.00', '60000.00'),
(14, 22, 35, 1, '60000.00', '60000.00'),
(15, 23, 35, 1, '60000.00', '60000.00'),
(16, 24, 35, 1, '60000.00', '60000.00'),
(17, 25, 35, 1, '60000.00', '60000.00'),
(18, 26, 36, 1, '120000.00', '120000.00'),
(19, 27, 36, 1, '120000.00', '120000.00'),
(20, 28, 36, 6, '120000.00', '720000.00'),
(21, 29, 35, 1, '60000.00', '60000.00'),
(22, 30, 35, 3, '60000.00', '180000.00'),
(23, 30, 49, 2, '123.00', '246.00');

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
(77, '16000'),
(191, '12000'),
(193, '8000');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `formato_placa`
--

CREATE TABLE `formato_placa` (
  `id_hardware` int(11) NOT NULL,
  `formato_placa` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `formato_placa`
--

INSERT INTO `formato_placa` (`id_hardware`, `formato_placa`) VALUES
(60, 'Micro ATX'),
(111, 'ATX');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `formato_ram`
--

CREATE TABLE `formato_ram` (
  `id_hardware` int(11) NOT NULL,
  `formato_ram` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `formato_ram`
--

INSERT INTO `formato_ram` (`id_hardware`, `formato_ram`) VALUES
(57, 'DIMM'),
(116, 'SODIMM');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `formato_ssd`
--

CREATE TABLE `formato_ssd` (
  `id_hardware` int(11) NOT NULL,
  `formato_ssd` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `formato_ssd`
--

INSERT INTO `formato_ssd` (`id_hardware`, `formato_ssd`) VALUES
(83, 'M.2 (2280)'),
(91, '2.5\"');

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
(24, '3000 MHz'),
(69, '3600 MHz'),
(98, '3800 MHz'),
(109, '2800 Mhz');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `frecuencia_gpu`
--

CREATE TABLE `frecuencia_gpu` (
  `id_hardware` int(11) NOT NULL,
  `frecuencia_gpu` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `frecuencia_gpu`
--

INSERT INTO `frecuencia_gpu` (`id_hardware`, `frecuencia_gpu`) VALUES
(58, '2125 MHz'),
(102, '2000 MHz'),
(110, '2775 Mhz');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gpu_notebook`
--

CREATE TABLE `gpu_notebook` (
  `id_notebook` int(11) NOT NULL,
  `gpu_notebook` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `gpu_notebook`
--

INSERT INTO `gpu_notebook` (`id_notebook`, `gpu_notebook`) VALUES
(26, 'NVIDIA GeForce RTX 4060 (8 GB)'),
(29, 'NVIDIA GeForce RTX 3050 (4 GB)'),
(31, 'Integrada'),
(32, 'Intel HD600');

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
(34, NULL),
(39, NULL),
(40, NULL),
(41, NULL),
(44, NULL),
(47, NULL),
(48, NULL),
(49, NULL),
(54, NULL),
(55, NULL),
(56, NULL),
(57, NULL),
(58, NULL),
(59, NULL),
(60, NULL),
(61, NULL),
(62, NULL),
(63, NULL),
(65, NULL),
(66, NULL),
(67, NULL),
(68, NULL),
(69, NULL),
(70, NULL),
(71, NULL),
(72, NULL),
(73, NULL),
(74, NULL),
(75, NULL),
(76, NULL),
(77, NULL),
(78, NULL),
(79, NULL),
(80, NULL),
(81, NULL),
(82, NULL),
(83, NULL),
(84, NULL),
(87, NULL),
(89, NULL),
(90, NULL),
(91, NULL),
(92, NULL),
(93, NULL),
(94, NULL),
(95, NULL),
(96, NULL),
(97, NULL),
(98, NULL),
(99, NULL),
(100, NULL),
(101, NULL),
(102, NULL),
(103, NULL),
(104, NULL),
(105, NULL),
(106, NULL),
(107, NULL),
(108, NULL),
(109, NULL),
(110, NULL),
(111, NULL),
(112, NULL),
(113, NULL),
(114, NULL),
(115, NULL),
(116, NULL),
(117, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_compras`
--

CREATE TABLE `historial_compras` (
  `id_historial` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_boleta` int(11) NOT NULL,
  `fecha_compra` datetime DEFAULT current_timestamp(),
  `total` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `historial_compras`
--

INSERT INTO `historial_compras` (`id_historial`, `id_usuario`, `id_boleta`, `fecha_compra`, `total`) VALUES
(1, 46, 2, '2024-11-10 22:10:09', '300000.00'),
(2, 46, 3, '2024-11-11 01:09:47', '60000.00'),
(3, 46, 4, '2024-11-19 02:16:54', '120000.00'),
(4, 46, 5, '2024-11-20 01:03:50', '60000.00');

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
(155, 'RGB'),
(197, 'No');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lista_deseo_producto`
--

CREATE TABLE `lista_deseo_producto` (
  `id_lista` int(11) NOT NULL,
  `nombre_lista` varchar(255) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `lista_deseo_producto`
--

INSERT INTO `lista_deseo_producto` (`id_lista`, `nombre_lista`, `id_producto`, `user_id`) VALUES
(2, 'mi_lista_deseos', 36, NULL),
(3, 'mi_lista_deseos', 35, NULL),
(4, 'mi_lista_deseos', 37, NULL),
(5, 'mi_lista_deseos', 41, NULL),
(6, 'mi_lista_deseos', 49, NULL),
(7, 'mi_lista_deseos', 35, 50),
(8, 'mi_lista_deseos', 36, 50),
(12, 'mi_lista_deseos', 35, 49),
(13, 'mi_lista_deseos', 35, 46);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `marca`
--

CREATE TABLE `marca` (
  `id_marca` int(11) NOT NULL,
  `nombre_marca` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `marca`
--

INSERT INTO `marca` (`id_marca`, `nombre_marca`) VALUES
(1, 'Asus'),
(2, 'AMD'),
(3, 'Intel'),
(4, 'NVIDIA'),
(5, 'Gigabyte'),
(6, 'MSI'),
(7, 'HyperX'),
(8, 'Corsair'),
(9, 'Samsung'),
(10, 'AZORPA'),
(11, 'Blitzwolf'),
(12, 'Logitech'),
(13, 'HP'),
(15, 'Western Digital'),
(16, 'Toshiba'),
(17, 'AData'),
(18, 'Ocelot'),
(19, 'Cooler Master');

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
(59, '8 GB GDDR6 '),
(101, '4 GB GDDR6');

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
(23, NULL),
(24, NULL),
(25, NULL),
(26, NULL),
(27, NULL),
(28, NULL),
(29, NULL),
(30, NULL),
(31, NULL),
(32, NULL);

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
(47, '4 núcleos / 8 hilos');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `orden_compra`
--

CREATE TABLE `orden_compra` (
  `id_orden` int(11) NOT NULL,
  `fecha` date DEFAULT NULL,
  `forma_pago` varchar(50) DEFAULT NULL,
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
(25, 'LED 15.6\" (1920x1080) / 144 Hz'),
(30, 'LED 15.6\" (1920x1080) / 60 Hz');

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
(155, NULL),
(158, NULL),
(159, NULL),
(161, NULL),
(168, NULL),
(169, NULL),
(170, NULL),
(171, NULL),
(173, NULL),
(174, NULL),
(175, NULL),
(176, NULL),
(177, NULL),
(178, NULL),
(179, NULL),
(180, NULL),
(181, NULL),
(182, NULL),
(183, NULL),
(184, NULL),
(185, NULL),
(186, NULL),
(187, NULL),
(188, NULL),
(189, NULL),
(190, NULL),
(191, NULL),
(192, NULL),
(193, NULL),
(194, NULL),
(195, NULL),
(196, NULL),
(197, NULL),
(198, NULL),
(199, NULL),
(200, NULL);

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
(161, '99 g'),
(194, ' 85 g');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `potencia_fuente`
--

CREATE TABLE `potencia_fuente` (
  `id_hardware` int(11) NOT NULL,
  `potencia_fuente` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `potencia_fuente`
--

INSERT INTO `potencia_fuente` (`id_hardware`, `potencia_fuente`) VALUES
(66, '500 W'),
(107, '650 W'),
(112, '750 W');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `id_producto` int(11) NOT NULL,
  `nombre_producto` varchar(255) DEFAULT NULL,
  `precio` int(11) NOT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `tipo_producto` varchar(255) DEFAULT NULL,
  `marca` varchar(55) DEFAULT NULL,
  `imagen_url` varchar(255) NOT NULL,
  `destacado` tinyint(1) DEFAULT 0,
  `costo` decimal(10,0) NOT NULL DEFAULT 0,
  `nombre_categoria` varchar(255) DEFAULT NULL,
  `subcategoria` varchar(255) NOT NULL,
  `id_categoria` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`id_producto`, `nombre_producto`, `precio`, `cantidad`, `tipo_producto`, `marca`, `imagen_url`, `destacado`, `costo`, `nombre_categoria`, `subcategoria`, `id_categoria`) VALUES
(70, 'AZORPA One-Knob', 75990, 51, 'teclado', '10', 'https://m.media-amazon.com/images/I/61pRioARU1L._AC_SL1500_.jpg', 1, '40000', 'aaa', 'aaaaaa', 7),
(71, 'Blitzwolf KB-1', 35990, 34, 'teclado', '11', 'https://imgaz2.staticbg.com/thumb/large/oaupload/banggood/images/8B/2F/1bc363d6-2e0f-48c4-98ea-9b23a6a6e90b.jpg', 1, '20000', NULL, '', 0),
(74, 'HP K500', 14990, 123, 'teclado', '13', 'https://m.media-amazon.com/images/I/61YFZs8A+2L.jpg', 1, '10000', NULL, '', 0),
(75, 'SAMSUNG ODYSSEY G3', 279990, 124, 'monitor', '9', 'https://images.samsung.com/is/image/samsung/p6pim/cl/ls27dg300elxzs/gallery/cl-odyssey-g3-g30d-ls27dg300elxzs-543059014?$1300_1038_PNG$', 1, '200000', NULL, '', 0),
(76, 'MONITOR ASUS 27IN', 279990, 24, 'monitor', '1', 'https://m.media-amazon.com/images/I/71u4mAb+V6L._AC_SL1500_.jpg', 1, '200000', NULL, '', 0),
(77, 'MONITOR HP M24F FHD', 169990, 12, 'monitor', '13', 'https://imagedelivery.net/4fYuQyy-r8_rpBpcY7lH_A/falabellaPE/133078862_02/w=800,h=800,fit=pad', 1, '100000', NULL, '', 0),
(78, 'CORSAIR VIRTUOSO', 217990, 123, 'audifono', '8', 'https://sipoonline.cl/wp-content/uploads/2024/09/Audifonos-Wireless-Corsair-Virtuoso-RGB-Sonido-7.1-White.png', 1, '150000', NULL, '', 0),
(79, 'LOGITECH G335', 79990, 124, 'audifono', '12', 'https://fotosol.cl/cdn/shop/products/audifonos_logitech_g335_2_1200x.jpg?v=1666214019', 1, '60000', NULL, '', 0),
(80, 'GALAXY BUDS FE', 57990, 234, 'audifono', '1', 'https://mrclick.cl/cdn/shop/files/004_1500x1500_4_17ead26b-90d6-4c2d-b3c9-81215d6cb804_1500x.jpg?v=1706709360', 1, '40000', NULL, '', 0),
(81, 'CHAMPION SERIES SABRE PRO NEGRO', 159990, 53, 'mouse', '8', 'https://prophonechile.cl/wp-content/uploads/2022/01/SABRERGBPRO.png', 1, '124000', NULL, '', 0),
(82, 'LOGITECH G102', 29990, 53, 'mouse', '12', 'https://imagedelivery.net/4fYuQyy-r8_rpBpcY7lH_A/falabellaCL/127630797_01/w=1500,h=1500,fit=pad', 1, '15000', NULL, '', 0),
(83, 'MOUSE HP 200', 5990, 235, 'mouse', '13', 'https://elgeniox.com/cdn/shop/files/mouse-inalambrico-hp-200-plateado--693983--2520240919T213228552.jpg?v=1726781555', 1, '2000', NULL, '', 0),
(84, 'AMD Ryzen 7 5700x', 199990, 43, 'cpu', '2', 'https://assets.pcfactory.cl/public/foto/46746/google_1000.jpg', 1, '170000', NULL, '', 0),
(85, 'Intel Core i5 12400F', 149990, 53, 'cpu', '3', 'https://megadrivestore.cl/968-large_default/intel-core-i5-12400f-25-ghz-6-nucleos-12-subprocesos-18-mb-de-cache-zocalo-lga1700.jpg', 1, '120000', NULL, '', 0),
(86, 'Intel Core i9 12900K', 459990, 43, 'cpu', '3', 'https://pegasum.cl/wp-content/uploads/2023/01/1498180_picture_1637592613-1.png', 1, '230000', NULL, '', 0),
(87, 'Asus Tuf RTX 3060', 249990, 54, 'gpu', '1', 'https://www.exertis.ie/images/products/34563/112485/600x600/TUF-RTX3060-O12G-V.webp', 1, '160000', NULL, '', 0),
(88, 'Radeon RX 7600', 319990, 42, 'gpu', '2', 'https://n1g.cl/Home/9518-large_default/sapphire-pulse-radeon-rx-7600-8gb-gddr6-pci-express-40-x8-atx-video-card-11324-01-20g.jpg', 1, '280000', NULL, '', 0),
(89, 'Nvidia GTX 1080', 149990, 15, 'gpu', '4', 'https://static.gigabyte.com/StaticFile/Image/Global/62c0b2b60a46145c021a1f64afec3a2a/Product/16867', 1, '110000', NULL, '', 0),
(90, 'WD WGreen SSD', 31990, 15, 'ssd', '15', 'https://s3.amazonaws.com/w3.assets/fotos/33142/2..webp?v=100328130', 1, '19000', NULL, '', 0),
(91, 'SSD ADATA Ultimate SU650', 24990, 52, 'ssd', '17', 'https://media.spdigital.cl/thumbnails/products/7yow1o1x_ffc43df9_thumbnail_512.jpg', 1, '20000', NULL, '', 0),
(92, 'ADATA Legend 800', 34990, 53, 'ssd', '17', 'https://media.spdigital.cl/thumbnails/products/57txoq6c_aa13ced4_thumbnail_512.jpg', 1, '21000', NULL, '', 0),
(93, 'WD Blue 3.5', 71990, 52, 'hdd', '15', 'https://media.spdigital.cl/thumbnails/products/5nobcw1v_e9578faa_thumbnail_512.jpg', 1, '59000', NULL, '', 0),
(94, 'WD WPurple Surveilance', 52990, 42, 'hdd', '15', 'https://www.virec.cl/wp-content/uploads/2024/03/WD10PURZ.jpg', 1, '39000', NULL, '', 0),
(95, 'PC P300', 21990, 42, 'hdd', '16', 'https://supplyline.cl/wp-content/uploads/2019/08/HDWK105UZSVA.jpg', 1, '18000', NULL, '', 0),
(96, 'Asus H410M-E', 89990, 56, 'placa', '1', 'https://www.asus.com/media/global/gallery/cdrhcxg7gtwfagts_setting_xxx_0_90_end_800.png', 1, '71000', NULL, '', 0),
(97, 'H610M-H', 102990, 56, 'placa', '5', 'https://centrale.cl/wp-content/uploads/Placa-Madre-Micro-ATX-Gigabyte-H610M-H-Socket-Intel-LGA-1700-DDR5.webp', 1, '80000', NULL, '', 0),
(98, 'MSI PRO B760M-P ', 119990, 22, 'placa', '6', 'https://n1g.cl/Home/10789-large_default/msi-pro-b760m-p-ddr4-lga-1700-intel-b760-sata-6gbs-micro-atx-motherboard.jpg', 1, '90000', NULL, '', 0),
(99, 'CX750F', 118990, 51, 'fuente', '8', 'https://cdn3.spider.cl/19139-large_default/fuente-de-poder-corsair-cx750f-rgb-750w-certgold-blanca.jpg', 1, '92000', NULL, '', 0),
(100, 'P650B', 138990, 53, 'fuente', '5', 'https://cache.zoey.com.ar/foto.php?src=/fotos/650W80PLGIGABYYTE.JPG&ancho=750&alto=750', 1, '96000', NULL, '', 0),
(101, 'SF750', 169990, 13, 'fuente', '1', 'https://assets.corsair.com/image/upload/c_pad,q_auto,h_1024,w_1024,f_auto/products/Power-Supply-Units/CP-9020186-EU/Gallery/SF750_01_300m.webp', 1, '159000', NULL, '', 0),
(102, 'Ocelot Box1', 71990, 42, 'gabinete', '1', 'https://mcashop.mx/ecommerce/wp-content/uploads/2024/07/21089cdcb3977bbdbac759dc0a2383c3.webp', 1, '69000', NULL, '', 0),
(103, 'Icue 4000x', 62990, 12, 'gabinete', '8', 'https://http2.mlstatic.com/D_NQ_NP_876894-MLU71267144605_082023-O.webp', 1, '59000', NULL, '', 0),
(104, 'Cooler Master CMP 520', 71990, 17, 'gabinete', '19', 'https://centrale.cl/wp-content/uploads/Gabinete-Gamer-Cooler-Master-CMP-520-ARGB-ATX-Black-3-Ventiladores-ARGB-IncluC3ADd.webp', 1, '52000', NULL, '', 0),
(105, 'HP Victus 15', 719990, 49, 'notebook', '13', 'https://imagedelivery.net/4fYuQyy-r8_rpBpcY7lH_A/falabellaCL/17031115_1/w=800,h=800,fit=pad', 1, '650000', NULL, '', 0),
(106, 'HP 15', 589990, 24, 'notebook', '1', 'https://d1pc5hp1w29h96.cloudfront.net/catalog/product/cache/b3b166914d87ce343d4dc5ec5117b502/8/2/827B1LA-1_T1694733380.png', 1, '500000', NULL, '', 0),
(107, 'ROG Zephyrus G16', 2519990, 12, 'notebook', '1', 'https://dlcdnwebimgs.asus.com/gain/9E8B3BDF-4BB7-45CC-B7BE-F38810969B9A/w717/h525', 1, '2000000', NULL, '', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto_caracteristica`
--

CREATE TABLE `producto_caracteristica` (
  `id_caracteristica` int(11) NOT NULL,
  `id_producto` int(11) DEFAULT NULL,
  `caracteristica` varchar(255) DEFAULT NULL,
  `valor_caracteristica` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `producto_caracteristica`
--

INSERT INTO `producto_caracteristica` (`id_caracteristica`, `id_producto`, `caracteristica`, `valor_caracteristica`) VALUES
(264, 70, 'tipo_teclado', '66'),
(265, 70, 'tipo_switch', '159'),
(266, 70, 'conectividad', '76'),
(267, 70, 'iluminacion', '155'),
(268, 70, 'categoria_teclado', '174'),
(269, 71, 'tipo_teclado', '66'),
(270, 71, 'tipo_switch', '171'),
(271, 71, 'conectividad', '76'),
(272, 71, 'iluminacion', '155'),
(273, 71, 'categoria_teclado', '175'),
(284, 74, 'tipo_teclado', '86'),
(285, 74, 'tipo_switch', '199'),
(286, 74, 'conectividad', '141'),
(287, 74, 'iluminacion', '155'),
(288, 74, 'categoria_teclado', '173'),
(289, 75, 'resolucion_monitor', '81'),
(290, 75, 'tamanio_monitor', '180'),
(291, 75, 'tasa_refresco', '181'),
(292, 75, 'tiempo_respuesta', '179'),
(293, 75, 'soporte_monitor', '170'),
(294, 75, 'tipo_panel', '186'),
(295, 75, 'tipo_curvatura', '188'),
(296, 76, 'resolucion_monitor', '81'),
(297, 76, 'tamanio_monitor', '180'),
(298, 76, 'tasa_refresco', '200'),
(299, 76, 'tiempo_respuesta', '179'),
(300, 76, 'soporte_monitor', '170'),
(301, 76, 'tipo_panel', '185'),
(302, 76, 'tipo_curvatura', '188'),
(303, 77, 'resolucion_monitor', '81'),
(304, 77, 'tamanio_monitor', '78'),
(305, 77, 'tasa_refresco', '168'),
(306, 77, 'tiempo_respuesta', '80'),
(307, 77, 'soporte_monitor', '182'),
(308, 77, 'tipo_panel', '185'),
(309, 77, 'tipo_curvatura', '188'),
(310, 78, 'tipo_audifono', '176'),
(311, 78, 'tipo_microfono', '195'),
(312, 78, 'anc', '196'),
(313, 78, 'conectividad', '76'),
(314, 78, 'iluminacion', '197'),
(315, 79, 'tipo_audifono', '176'),
(316, 79, 'tipo_microfono', '195'),
(317, 79, 'anc', '196'),
(318, 79, 'conectividad', '141'),
(319, 79, 'iluminacion', '155'),
(325, 80, 'tipo_audifono', '198'),
(326, 80, 'tipo_microfono', '177'),
(327, 80, 'anc', '196'),
(328, 80, 'conectividad', '76'),
(329, 80, 'iluminacion', '197'),
(330, 81, 'dpi_mouse', '77'),
(331, 81, 'peso_mouse', '194'),
(332, 81, 'sensor_mouse', '192'),
(333, 81, 'iluminacion', '197'),
(334, 81, 'conectividad', '141'),
(335, 82, 'dpi_mouse', '77'),
(336, 82, 'peso_mouse', '161'),
(337, 82, 'sensor_mouse', '75'),
(338, 82, 'iluminacion', '155'),
(339, 82, 'conectividad', '141'),
(340, 83, 'dpi_mouse', '193'),
(341, 83, 'peso_mouse', '161'),
(342, 83, 'sensor_mouse', '75'),
(343, 83, 'iluminacion', '197'),
(344, 83, 'conectividad', '76'),
(345, 84, 'frecuencia_cpu', '69'),
(346, 84, 'nucleo_hilo_cpu', '47'),
(347, 84, 'socket_cpu', '99'),
(348, 85, 'frecuencia_cpu', '24'),
(349, 85, 'nucleo_hilo_cpu', '47'),
(350, 85, 'socket_cpu', '97'),
(351, 86, 'frecuencia_cpu', '69'),
(352, 86, 'nucleo_hilo_cpu', '47'),
(353, 86, 'socket_cpu', '97'),
(354, 87, 'frecuencia_gpu', '58'),
(355, 87, 'memoria_gpu', '59'),
(356, 87, 'bus_de_entrada_gpu', '100'),
(357, 88, 'frecuencia_gpu', '110'),
(358, 88, 'memoria_gpu', '59'),
(359, 88, 'bus_de_entrada_gpu', '100'),
(360, 89, 'frecuencia_gpu', '58'),
(361, 89, 'memoria_gpu', '101'),
(362, 89, 'bus_de_entrada_gpu', '84'),
(363, 90, 'capacidad_almacenamiento', '41'),
(364, 90, 'bus_ssd', '89'),
(365, 90, 'formato_ssd', '91'),
(366, 91, 'capacidad_almacenamiento', '40'),
(367, 91, 'bus_ssd', '89'),
(368, 91, 'formato_ssd', '91'),
(369, 92, 'capacidad_almacenamiento', '40'),
(370, 92, 'bus_ssd', '90'),
(371, 92, 'formato_ssd', '83'),
(372, 93, 'capacidad_almacenamiento', '41'),
(373, 93, 'bus_hdd', '76'),
(374, 93, 'rpm_hdd', '92'),
(375, 93, 'tamanio_hdd', '78'),
(376, 94, 'capacidad_almacenamiento', '41'),
(377, 94, 'bus_hdd', '76'),
(378, 94, 'rpm_hdd', '92'),
(379, 94, 'tamanio_hdd', '78'),
(380, 95, 'capacidad_almacenamiento', '40'),
(381, 95, 'bus_hdd', '76'),
(382, 95, 'rpm_hdd', '80'),
(383, 95, 'tamanio_hdd', '93'),
(384, 96, 'formato_placa', '111'),
(385, 96, 'slot_memoria_placa', '34'),
(386, 96, 'socket_placa', '61'),
(387, 96, 'chipset_placa', '63'),
(388, 97, 'formato_placa', '60'),
(389, 97, 'slot_memoria_placa', '103'),
(390, 97, 'socket_placa', '104'),
(391, 97, 'chipset_placa', '106'),
(392, 98, 'formato_placa', '60'),
(393, 98, 'slot_memoria_placa', '103'),
(394, 98, 'socket_placa', '104'),
(395, 98, 'chipset_placa', '63'),
(396, 99, 'certificacion_fuente', '113'),
(397, 99, 'potencia_fuente', '112'),
(398, 99, 'tamanio_fuente', '67'),
(399, 100, 'certificacion_fuente', '65'),
(400, 100, 'potencia_fuente', '107'),
(401, 100, 'tamanio_fuente', '67'),
(402, 101, 'certificacion_fuente', '115'),
(403, 101, 'potencia_fuente', '112'),
(404, 101, 'tamanio_fuente', '114'),
(405, 102, 'tamanio_max_gabinete', '68'),
(406, 102, 'iluminacion', '155'),
(407, 103, 'tamanio_max_gabinete', '68'),
(408, 103, 'iluminacion', '197'),
(409, 104, 'tamanio_max_gabinete', '68'),
(410, 104, 'iluminacion', '197'),
(411, 105, 'bateria_notebook', '24'),
(412, 105, 'cpu_notebook', '23'),
(413, 105, 'gpu_notebook', '29'),
(414, 105, 'capacidad_ram', '56'),
(415, 105, 'pantalla_notebook', '30'),
(416, 106, 'bateria_notebook', '24'),
(417, 106, 'cpu_notebook', '28'),
(418, 106, 'gpu_notebook', '31'),
(419, 106, 'capacidad_ram', '96'),
(420, 106, 'pantalla_notebook', '30'),
(421, 107, 'bateria_notebook', '27'),
(422, 107, 'cpu_notebook', '23'),
(423, 107, 'gpu_notebook', '26'),
(424, 107, 'capacidad_ram', '117'),
(425, 107, 'pantalla_notebook', '25');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `resena_valoracion`
--

CREATE TABLE `resena_valoracion` (
  `id_resena` int(11) NOT NULL,
  `valoracion` int(11) DEFAULT NULL,
  `comentario` text DEFAULT NULL,
  `id_producto` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `fecha` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `resena_valoracion`
--

INSERT INTO `resena_valoracion` (`id_resena`, `valoracion`, `comentario`, `id_producto`, `user_id`, `fecha`) VALUES
(13, 5, 'Buen producto :)', 35, 47, '2024-11-08 20:11:07'),
(14, 4, 'xd', 60, 46, '2024-11-09 19:29:23'),
(15, 5, 'xd', 36, 46, '2024-11-11 01:15:28'),
(16, 5, 'xdddd', 35, 46, '2024-11-11 19:37:35');

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
(81, 'Full HD (1920x1080)'),
(189, 'Ultra HD (3840x2160)');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rpm_hdd`
--

CREATE TABLE `rpm_hdd` (
  `id_hardware` int(11) NOT NULL,
  `rpm_hdd` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `rpm_hdd`
--

INSERT INTO `rpm_hdd` (`id_hardware`, `rpm_hdd`) VALUES
(80, '7200 rpm'),
(92, '5400 rpm');

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
(75, 'Optico'),
(192, 'Laser');

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
(34, '4x DDR4'),
(103, '2x DDR4'),
(105, '2x DDR3');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `socket_cpu`
--

CREATE TABLE `socket_cpu` (
  `id_hardware` int(11) NOT NULL,
  `socket_cpu` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `socket_cpu`
--

INSERT INTO `socket_cpu` (`id_hardware`, `socket_cpu`) VALUES
(54, 'LGA 1150'),
(97, 'LGA 1200'),
(99, 'AM4');

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
(61, 'AM4'),
(104, 'FM2+');

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
(170, 'G-Sync / FreeSync'),
(182, 'No'),
(183, 'G-Sync'),
(184, 'FreeSync');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `subcategorias`
--

CREATE TABLE `subcategorias` (
  `id_subcategoria` int(11) NOT NULL,
  `nombre_subcategoria` varchar(255) NOT NULL,
  `id_categoria` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tamanio_fuente`
--

CREATE TABLE `tamanio_fuente` (
  `id_hardware` int(11) NOT NULL,
  `tamanio_fuente` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tamanio_fuente`
--

INSERT INTO `tamanio_fuente` (`id_hardware`, `tamanio_fuente`) VALUES
(67, 'Estandar ATX'),
(114, 'SFX');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tamanio_hdd`
--

CREATE TABLE `tamanio_hdd` (
  `id_hardware` int(11) NOT NULL,
  `tamanio_hdd` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tamanio_hdd`
--

INSERT INTO `tamanio_hdd` (`id_hardware`, `tamanio_hdd`) VALUES
(78, '3.5\"'),
(93, '2.5\"');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tamanio_max_gabinete`
--

CREATE TABLE `tamanio_max_gabinete` (
  `id_hardware` int(11) NOT NULL,
  `tamanio_max_gabinete` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tamanio_max_gabinete`
--

INSERT INTO `tamanio_max_gabinete` (`id_hardware`, `tamanio_max_gabinete`) VALUES
(68, 'ATX'),
(108, 'Micro ATX');

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
(78, '24.0\"'),
(180, '27.0\"'),
(190, '32.0\"');

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
(168, '60 Hz'),
(181, '165 Hz'),
(200, '180 Hz');

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
(80, '5 ms'),
(179, '1 ms');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_audifono`
--

CREATE TABLE `tipo_audifono` (
  `id_periferico` int(11) NOT NULL,
  `tipo_audifono` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipo_audifono`
--

INSERT INTO `tipo_audifono` (`id_periferico`, `tipo_audifono`) VALUES
(176, 'Over-Ear / Headset'),
(198, 'True Wireless');

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
(79, 'Si'),
(188, 'No');

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
(177, 'Montado (invisible)'),
(195, 'Externo (estilo headset)');

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
(82, 'LED'),
(185, 'IPS'),
(186, 'VA'),
(187, 'TN');

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
(44, 'DDR4'),
(94, 'DDR5');

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
(159, 'Azul'),
(171, 'Rojo'),
(199, 'N/A');

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
(86, 'Membrana');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user','superadmin') NOT NULL DEFAULT 'user',
  `status` enum('activo','inhabilitado') DEFAULT 'activo',
  `fecha_registro` datetime DEFAULT current_timestamp(),
  `img` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`, `status`, `fecha_registro`, `img`) VALUES
(1, 'cliente1', 'cliente1@correo.com', 'hashed_password1', 'user', 'activo', '2023-11-10 10:00:00', NULL),
(2, 'cliente2', 'cliente2@correo.com', 'hashed_password2', 'user', 'activo', '2023-11-11 11:00:00', NULL),
(3, 'cliente3', 'cliente3@correo.com', 'hashed_password3', 'user', 'activo', '2023-11-12 12:00:00', NULL),
(46, 'admin', 'admin@admin.cl', '$2y$10$hnEq7BCps9MjNagRZbMkoO64Y9u7SDComOz8hPrNiRbQA3tAnjiKu', 'admin', 'activo', '2024-11-17 01:56:20', 'https://i.pinimg.com/736x/4f/91/0e/4f910e02fef7145d49ee7b934021026a.jpg'),
(47, 'maty', 'matias@matias.cl', '$2y$10$1EF01TysLiHJkPLD3UTfoes/f1ocQmAJfR5IV.ODk.0P8VUJsc13S', 'user', 'activo', '2024-11-17 01:56:20', NULL),
(50, 'pepe', 'pee@pee.cl', '$2y$10$G0pfGwL7/PNO.vJirg1PIOg5G4A1R7eqbzLq70FOZslR/6xlxdnVq', 'user', 'activo', '2024-11-17 01:56:20', NULL),
(51, 'prueba', 'prueba@prueba.cl', '$2y$10$48yLlR2mmE0EpSe0uN4i2.t4FRKE3lGY2ZCA7996b8eGvo8R6E5ma', 'user', 'activo', '2024-11-17 01:56:20', NULL),
(52, 'dan', 'dan.programas.oc@gmail.com', '$2y$10$zSbYIAYWhm0nPLPl0i0wBO3T1kXMmPCvJzz/s.wj8XrwwQjXm55VK', 'user', 'activo', '2024-11-17 01:56:20', NULL),
(55, 'superadmin', 'superadmin@admin.cl', '$2y$10$V5kKuWrOSGkmM75nlrNAlu9qyFMvxkVCvIO2faGDBUsRK7cLMOdPm', 'superadmin', 'activo', '2024-11-17 01:56:20', NULL),
(56, 'dan', 'dan.1997simon@gmail.com', '$2y$10$YTa3jBCViArfGlDBHYdZhuI5QybyvxqUO9TYo0mJI6HnT0XED9Lni', 'user', 'activo', '2024-11-17 01:56:20', NULL),
(57, 'matias', 'matiasg206@gmail.com', '$2y$10$p4dK5oLfmp5wje9/wyj6IuGb2GPj6h7DuwUDH/btoZPRf1LiLUBu.', 'user', 'activo', '2024-11-17 01:56:20', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `velocidad_ram`
--

CREATE TABLE `velocidad_ram` (
  `id_hardware` int(11) NOT NULL,
  `velocidad_ram` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `velocidad_ram`
--

INSERT INTO `velocidad_ram` (`id_hardware`, `velocidad_ram`) VALUES
(55, ' 4800 MT/s'),
(95, '2666 MT/s');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `id_venta` int(11) NOT NULL,
  `fecha_compra` datetime NOT NULL,
  `total` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`id_venta`, `fecha_compra`, `total`) VALUES
(1, '2023-11-10 10:30:00', '150'),
(2, '2023-11-11 15:45:00', '250'),
(3, '2023-11-12 18:20:00', '1001111'),
(4, '2023-11-13 20:15:00', '300'),
(5, '2023-11-14 12:00:00', '120');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `venta_producto`
--

CREATE TABLE `venta_producto` (
  `id_venta_producto` int(11) NOT NULL,
  `id_venta` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `venta_producto`
--

INSERT INTO `venta_producto` (`id_venta_producto`, `id_venta`, `id_producto`, `cantidad`) VALUES
(8, 1, 35, 2),
(9, 1, 36, 1),
(10, 2, 37, 4),
(11, 3, 39, 1),
(12, 4, 46, 3),
(13, 5, 49, 2);

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
-- Indices de la tabla `agregar_carrito`
--
ALTER TABLE `agregar_carrito`
  ADD PRIMARY KEY (`id_carrito`),
  ADD KEY `id_producto` (`id_producto`);

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
-- Indices de la tabla `atencion_postventa`
--
ALTER TABLE `atencion_postventa`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `bateria_notebook`
--
ALTER TABLE `bateria_notebook`
  ADD PRIMARY KEY (`id_notebook`);

--
-- Indices de la tabla `boletas`
--
ALTER TABLE `boletas`
  ADD PRIMARY KEY (`id_boleta`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `bus_de_entrada_gpu`
--
ALTER TABLE `bus_de_entrada_gpu`
  ADD PRIMARY KEY (`id_hardware`);

--
-- Indices de la tabla `bus_hdd`
--
ALTER TABLE `bus_hdd`
  ADD PRIMARY KEY (`id_hardware`);

--
-- Indices de la tabla `bus_ssd`
--
ALTER TABLE `bus_ssd`
  ADD PRIMARY KEY (`id_hardware`);

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
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id_categoria`);

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
-- Indices de la tabla `chipset_placa`
--
ALTER TABLE `chipset_placa`
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
-- Indices de la tabla `detalle_boletas`
--
ALTER TABLE `detalle_boletas`
  ADD PRIMARY KEY (`id_detalle_boleta`),
  ADD KEY `id_boleta` (`id_boleta`),
  ADD KEY `id_producto` (`id_producto`);

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
-- Indices de la tabla `formato_ssd`
--
ALTER TABLE `formato_ssd`
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
-- Indices de la tabla `historial_compras`
--
ALTER TABLE `historial_compras`
  ADD PRIMARY KEY (`id_historial`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_boleta` (`id_boleta`);

--
-- Indices de la tabla `iluminacion`
--
ALTER TABLE `iluminacion`
  ADD PRIMARY KEY (`id_periferico`);

--
-- Indices de la tabla `lista_deseo_producto`
--
ALTER TABLE `lista_deseo_producto`
  ADD PRIMARY KEY (`id_lista`),
  ADD KEY `nombre_lista` (`nombre_lista`),
  ADD KEY `id_producto` (`id_producto`);

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
  ADD PRIMARY KEY (`id_orden`);

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
-- Indices de la tabla `producto_caracteristica`
--
ALTER TABLE `producto_caracteristica`
  ADD PRIMARY KEY (`id_caracteristica`),
  ADD KEY `producto_caracteristica_ibfk_1` (`id_producto`);

--
-- Indices de la tabla `resena_valoracion`
--
ALTER TABLE `resena_valoracion`
  ADD PRIMARY KEY (`id_resena`),
  ADD KEY `id_producto` (`id_producto`),
  ADD KEY `id_usuario` (`user_id`);

--
-- Indices de la tabla `resolucion_monitor`
--
ALTER TABLE `resolucion_monitor`
  ADD PRIMARY KEY (`id_periferico`);

--
-- Indices de la tabla `rpm_hdd`
--
ALTER TABLE `rpm_hdd`
  ADD PRIMARY KEY (`id_hardware`);

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
-- Indices de la tabla `subcategorias`
--
ALTER TABLE `subcategorias`
  ADD PRIMARY KEY (`id_subcategoria`),
  ADD KEY `id_categoria` (`id_categoria`);

--
-- Indices de la tabla `tamanio_fuente`
--
ALTER TABLE `tamanio_fuente`
  ADD PRIMARY KEY (`id_hardware`);

--
-- Indices de la tabla `tamanio_hdd`
--
ALTER TABLE `tamanio_hdd`
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
-- Indices de la tabla `velocidad_ram`
--
ALTER TABLE `velocidad_ram`
  ADD PRIMARY KEY (`id_hardware`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`id_venta`);

--
-- Indices de la tabla `venta_producto`
--
ALTER TABLE `venta_producto`
  ADD PRIMARY KEY (`id_venta_producto`),
  ADD KEY `id_venta` (`id_venta`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indices de la tabla `voltaje_ram`
--
ALTER TABLE `voltaje_ram`
  ADD PRIMARY KEY (`id_hardware`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `agregar_carrito`
--
ALTER TABLE `agregar_carrito`
  MODIFY `id_carrito` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `atencion_postventa`
--
ALTER TABLE `atencion_postventa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `boletas`
--
ALTER TABLE `boletas`
  MODIFY `id_boleta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `detalle_boletas`
--
ALTER TABLE `detalle_boletas`
  MODIFY `id_detalle_boleta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `hardware`
--
ALTER TABLE `hardware`
  MODIFY `id_hardware` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=118;

--
-- AUTO_INCREMENT de la tabla `historial_compras`
--
ALTER TABLE `historial_compras`
  MODIFY `id_historial` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `lista_deseo_producto`
--
ALTER TABLE `lista_deseo_producto`
  MODIFY `id_lista` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `marca`
--
ALTER TABLE `marca`
  MODIFY `id_marca` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `notebook`
--
ALTER TABLE `notebook`
  MODIFY `id_notebook` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT de la tabla `orden_compra`
--
ALTER TABLE `orden_compra`
  MODIFY `id_orden` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `periferico`
--
ALTER TABLE `periferico`
  MODIFY `id_periferico` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=201;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=108;

--
-- AUTO_INCREMENT de la tabla `producto_caracteristica`
--
ALTER TABLE `producto_caracteristica`
  MODIFY `id_caracteristica` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=426;

--
-- AUTO_INCREMENT de la tabla `resena_valoracion`
--
ALTER TABLE `resena_valoracion`
  MODIFY `id_resena` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `subcategorias`
--
ALTER TABLE `subcategorias`
  MODIFY `id_subcategoria` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `id_venta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `venta_producto`
--
ALTER TABLE `venta_producto`
  MODIFY `id_venta_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `anc`
--
ALTER TABLE `anc`
  ADD CONSTRAINT `anc_ibfk_1` FOREIGN KEY (`id_periferico`) REFERENCES `periferico` (`id_periferico`);

--
-- Filtros para la tabla `subcategorias`
--
ALTER TABLE `subcategorias`
  ADD CONSTRAINT `subcategorias_ibfk_1` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id_categoria`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
