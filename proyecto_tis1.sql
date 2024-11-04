-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 04-11-2024 a las 07:52:56
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
  `fecha` datetime NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `codigo_autorizacion` varchar(50) NOT NULL,
  `detalles` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`detalles`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `boletas`
--

INSERT INTO `boletas` (`id_boleta`, `fecha`, `total`, `codigo_autorizacion`, `detalles`) VALUES
(1, '2024-11-03 02:04:34', '120000.00', '1213', '[{\"producto\":\"Teclado gamer\",\"cantidad\":2,\"precio_unitario\":\"60000.00\",\"total\":120000}]'),
(2, '2024-11-03 02:28:27', '120000.00', '1213', '[{\"producto\":\"Teclado gamer\",\"cantidad\":2,\"precio_unitario\":\"60000.00\",\"total\":120000}]'),
(3, '2024-11-03 02:52:13', '60000.00', '1213', '[{\"producto\":\"Teclado gamer\",\"cantidad\":1,\"precio_unitario\":\"60000.00\",\"total\":60000}]'),
(4, '2024-11-03 03:04:08', '120000.00', '1213', '[{\"producto\":\"Monitor Gamer\",\"cantidad\":1,\"precio_unitario\":\"120000.00\",\"total\":120000}]'),
(5, '2024-11-03 03:32:40', '60000.00', '1213', '[{\"producto\":\"Teclado gamer\",\"cantidad\":1,\"precio_unitario\":\"60000.00\",\"total\":60000}]'),
(6, '2024-11-03 03:34:10', '180000.00', '1213', '[{\"producto\":\"Teclado gamer\",\"cantidad\":3,\"precio_unitario\":\"60000.00\",\"total\":180000}]'),
(7, '2024-11-03 03:37:23', '60000.00', '1213', '[{\"producto\":\"Teclado gamer\",\"cantidad\":1,\"precio_unitario\":\"60000.00\",\"total\":60000}]'),
(8, '2024-11-03 03:46:18', '120000.00', '1213', '[{\"producto\":\"Teclado gamer\",\"cantidad\":2,\"precio_unitario\":\"60000.00\",\"total\":120000}]'),
(9, '2024-11-03 16:44:50', '60000.00', '1213', '[{\"producto\":\"Teclado gamer\",\"cantidad\":1,\"precio_unitario\":\"60000.00\",\"total\":60000}]'),
(10, '2024-11-03 16:48:46', '60000.00', '1213', '[{\"producto\":\"Teclado gamer\",\"cantidad\":1,\"precio_unitario\":\"60000.00\",\"total\":60000}]'),
(11, '2024-11-03 16:50:17', '60000.00', '1213', '[{\"id_producto\":\"35\",\"producto\":\"Teclado gamer\",\"cantidad\":1,\"precio_unitario\":\"60000.00\",\"total\":60000}]'),
(12, '2024-11-03 16:50:43', '60000.00', '1213', '[{\"id_producto\":\"35\",\"producto\":\"Teclado gamer\",\"cantidad\":1,\"precio_unitario\":\"60000.00\",\"total\":60000}]'),
(13, '2024-11-03 12:54:41', '120000.00', '1213', '[{\"id_producto\":\"36\",\"producto\":\"Monitor Gamer\",\"cantidad\":1,\"precio_unitario\":\"120000.00\",\"total\":120000}]'),
(14, '2024-11-03 13:06:42', '660000.00', '1213', '[{\"id_producto\":\"35\",\"producto\":\"Teclado gamer\",\"cantidad\":1,\"precio_unitario\":\"60000.00\",\"total\":60000},{\"id_producto\":\"36\",\"producto\":\"Monitor Gamer\",\"cantidad\":5,\"precio_unitario\":\"120000.00\",\"total\":600000}]'),
(15, '2024-11-03 13:07:17', '60000.00', '1213', '[{\"id_producto\":\"35\",\"producto\":\"Teclado gamer\",\"cantidad\":1,\"precio_unitario\":\"60000.00\",\"total\":60000}]'),
(16, '2024-11-03 13:07:55', '60000.00', '1213', '[{\"id_producto\":\"35\",\"producto\":\"Teclado gamer\",\"cantidad\":1,\"precio_unitario\":\"60000.00\",\"total\":60000}]'),
(17, '2024-11-03 17:08:38', '60000.00', '1213', '[{\"id_producto\":\"35\",\"producto\":\"Teclado gamer\",\"cantidad\":1,\"precio_unitario\":\"60000.00\",\"total\":60000}]'),
(18, '2024-11-03 17:10:15', '120000.00', '1213', '[{\"id_producto\":\"36\",\"producto\":\"Monitor Gamer\",\"cantidad\":1,\"precio_unitario\":\"120000.00\",\"total\":120000}]'),
(19, '2024-11-03 17:14:18', '60000.00', '1213', '[{\"id_producto\":\"35\",\"producto\":\"Teclado gamer\",\"cantidad\":1,\"precio_unitario\":\"60000.00\",\"total\":60000}]'),
(20, '2024-11-03 17:16:26', '120000.00', '1213', '[{\"id_producto\":\"36\",\"producto\":\"Monitor Gamer\",\"cantidad\":1,\"precio_unitario\":\"120000.00\",\"total\":120000}]'),
(21, '2024-11-03 17:20:00', '60000.00', '1213', '[{\"id_producto\":\"35\",\"producto\":\"Teclado gamer\",\"cantidad\":1,\"precio_unitario\":\"60000.00\",\"total\":60000}]'),
(22, '2024-11-03 17:21:09', '60000.00', '1213', '[{\"id_producto\":\"35\",\"producto\":\"Teclado gamer\",\"cantidad\":1,\"precio_unitario\":\"60000.00\",\"total\":60000}]'),
(23, '2024-11-03 17:23:08', '60000.00', '1213', '[{\"id_producto\":\"35\",\"producto\":\"Teclado gamer\",\"cantidad\":1,\"precio_unitario\":\"60000.00\",\"total\":60000}]'),
(24, '2024-11-03 17:25:18', '60000.00', '1213', '[{\"id_producto\":\"35\",\"producto\":\"Teclado gamer\",\"cantidad\":1,\"precio_unitario\":\"60000.00\",\"total\":60000}]'),
(25, '2024-11-03 17:27:58', '60000.00', '1213', '[{\"id_producto\":\"35\",\"producto\":\"Teclado gamer\",\"cantidad\":1,\"precio_unitario\":\"60000.00\",\"total\":60000}]'),
(26, '2024-11-03 17:35:07', '120000.00', '1213', '[{\"id_producto\":\"36\",\"producto\":\"Monitor Gamer\",\"cantidad\":1,\"precio_unitario\":\"120000.00\",\"total\":120000}]'),
(27, '2024-11-03 17:40:11', '120000.00', '1213', '[{\"id_producto\":\"36\",\"producto\":\"Monitor Gamer\",\"cantidad\":1,\"precio_unitario\":\"120000.00\",\"total\":120000}]'),
(28, '2024-11-03 17:43:27', '720000.00', '1213', '[{\"id_producto\":\"36\",\"producto\":\"Monitor Gamer\",\"cantidad\":6,\"precio_unitario\":\"120000.00\",\"total\":720000}]'),
(29, '2024-11-03 13:47:57', '60000.00', '1213', '[{\"id_producto\":\"35\",\"producto\":\"Teclado gamer\",\"cantidad\":1,\"precio_unitario\":\"60000.00\",\"total\":60000}]'),
(30, '2024-11-03 15:29:29', '180246.00', '1213', '[{\"id_producto\":\"35\",\"producto\":\"Teclado gamer\",\"cantidad\":3,\"precio_unitario\":\"60000.00\",\"total\":180000},{\"id_producto\":\"49\",\"producto\":\"Kingston KVR26N19S6/4 (1 x 4GB | DIMM DDR4-2666)\",\"cantidad\":2,\"precio_unitario\":\"123.00\",\"total\":246}]'),
(31, '2024-11-03 16:56:58', '123.00', '1213', '[{\"id_producto\":\"40\",\"producto\":\"Ryzen 7 5700X \",\"cantidad\":1,\"precio_unitario\":\"123.00\",\"total\":123}]'),
(32, '2024-11-03 20:54:49', '2880000.00', '1213', '[{\"id_producto\":\"35\",\"producto\":\"Teclado gamer\",\"cantidad\":48,\"precio_unitario\":\"60000.00\",\"total\":2880000}]'),
(33, '2024-11-03 21:13:15', '240000.00', '1213', '[{\"id_producto\":\"36\",\"producto\":\"Monitor Gamer\",\"cantidad\":2,\"precio_unitario\":\"120000.00\",\"total\":240000}]'),
(34, '2024-11-03 21:20:50', '120000.00', '1213', '[{\"id_producto\":\"36\",\"producto\":\"Monitor Gamer\",\"cantidad\":1,\"precio_unitario\":\"120000.00\",\"total\":120000}]'),
(35, '2024-11-03 21:24:38', '120000.00', '1213', '[{\"id_producto\":\"36\",\"producto\":\"Monitor Gamer\",\"cantidad\":1,\"precio_unitario\":\"120000.00\",\"total\":120000}]'),
(36, '2024-11-03 21:25:09', '10000.00', '1213', '[{\"id_producto\":\"37\",\"producto\":\"Audifono generico\",\"cantidad\":1,\"precio_unitario\":\"10000.00\",\"total\":10000}]'),
(37, '2024-11-03 21:32:24', '246.00', '1213', '[{\"id_producto\":\"51\",\"producto\":\"Casecom C412-3B\",\"cantidad\":1,\"precio_unitario\":\"123.00\",\"total\":123},{\"id_producto\":\"41\",\"producto\":\"MSI GeForce RTX 4060\",\"cantidad\":1,\"precio_unitario\":\"123.00\",\"total\":123}]'),
(38, '2024-11-03 21:35:57', '123.00', '1213', '[{\"id_producto\":\"50\",\"producto\":\"Corsair CX Series CX750 2023 (750 W)\",\"cantidad\":1,\"precio_unitario\":\"123.00\",\"total\":123}]'),
(39, '2024-11-03 21:38:52', '60000.00', '1213', '[{\"producto\":\"Teclado gamer\",\"cantidad\":1,\"precio_unitario\":\"60000.00\",\"total\":60000}]'),
(40, '2024-11-03 21:41:35', '180000.00', '1213', '[{\"producto\":\"Teclado gamer\",\"cantidad\":3,\"precio_unitario\":\"60000.00\",\"total\":180000}]'),
(41, '2024-11-03 21:48:16', '180000.00', '1213', '[{\"producto\":\"Teclado gamer\",\"cantidad\":3,\"precio_unitario\":\"60000.00\",\"total\":180000}]'),
(42, '2024-11-03 21:49:06', '60000.00', '1213', '[{\"producto\":\"Teclado gamer\",\"cantidad\":1,\"precio_unitario\":\"60000.00\",\"total\":60000}]'),
(43, '2024-11-03 21:53:11', '120000.00', '1213', '[{\"producto\":\"Monitor Gamer\",\"cantidad\":1,\"precio_unitario\":\"120000.00\",\"total\":120000}]'),
(44, '2024-11-03 21:55:36', '240000.00', '1213', '[{\"producto\":\"Teclado gamer\",\"cantidad\":4,\"precio_unitario\":\"60000.00\",\"total\":240000}]'),
(45, '2024-11-03 21:59:17', '60000.00', '1213', '[{\"producto\":\"Teclado gamer\",\"cantidad\":1,\"precio_unitario\":\"60000.00\",\"total\":60000}]'),
(46, '2024-11-03 22:04:57', '60000.00', '1213', '[{\"producto\":\"Teclado gamer\",\"cantidad\":1,\"precio_unitario\":\"60000.00\",\"total\":60000}]'),
(47, '2024-11-03 22:07:48', '60000.00', '1213', '[{\"producto\":\"Teclado gamer\",\"cantidad\":1,\"precio_unitario\":\"60000.00\",\"total\":60000}]'),
(48, '2024-11-03 22:12:53', '60000.00', '1213', '[{\"producto\":\"Teclado gamer\",\"cantidad\":1,\"precio_unitario\":\"60000.00\",\"total\":60000}]'),
(49, '2024-11-04 00:22:02', '180000.00', '1213', '[{\"producto\":\"Teclado gamer\",\"cantidad\":3,\"precio_unitario\":\"60000.00\",\"total\":180000}]'),
(50, '2024-11-04 00:28:48', '60000.00', '1213', '[{\"producto\":\"Teclado gamer\",\"cantidad\":1,\"precio_unitario\":\"60000.00\",\"total\":60000}]'),
(51, '2024-11-04 00:32:28', '60000.00', '1213', '[{\"producto\":\"Teclado gamer\",\"cantidad\":1,\"precio_unitario\":\"60000.00\",\"total\":60000}]');

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
(96, '1 x 4 GB');

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
(70, 'Sin certificación');

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
(60, 'Micro ATX');

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
(57, 'DIMM');

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
(98, '3800 MHz');

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
(102, '2000 MHz');

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
(29, 'NVIDIA GeForce RTX 3050 (4 GB)');

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
(108, NULL);

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
(155, 'RGB'),
(197, 'No');

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
(9, 'Samsung');

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
(30, NULL);

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
(198, NULL);

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
(107, '650 W');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `id_producto` int(11) NOT NULL,
  `nombre_producto` varchar(255) DEFAULT NULL,
  `precio` decimal(10,2) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `tipo_producto` varchar(255) DEFAULT NULL,
  `marca` varchar(55) DEFAULT NULL,
  `imagen_url` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`id_producto`, `nombre_producto`, `precio`, `cantidad`, `tipo_producto`, `marca`, `imagen_url`) VALUES
(35, 'Teclado gamer', '60000.00', 89, 'teclado', '1', 'https://i.postimg.cc/kDZSR5tt/9.png[/img][/url]'),
(36, 'Monitor Gamer', '120000.00', 1110, 'monitor', '1', 'https://i.postimg.cc/Js3HFcYb/10.png[/img][/url]'),
(37, 'Audifono generico', '10000.00', 111, 'audifono', '1', 'https://i.postimg.cc/NyYmGP2J/3.png[/img][/url]'),
(39, 'Mouse generico', '5000.00', 1, 'mouse', '1', 'https://i.postimg.cc/yDCSnrj1/11.png[/img][/url]'),
(41, 'MSI GeForce RTX 4060', '123.00', 0, 'gpu', '1', 'https://i.postimg.cc/TLND9d7F/5.png[/img][/url]'),
(46, 'ASUS TUF A15 FA506NF-HN003W', '123.00', 1, 'notebook', '1', 'https://i.postimg.cc/TyR5vLBB/12.png[/img][/url]'),
(49, 'Kingston KVR26N19S6/4 (1 x 4GB | DIMM DDR4-2666)', '123.00', 1, 'ram', '1', 'https://i.postimg.cc/7JCTtFj6/7.png[/img][/url]'),
(50, 'Corsair CX Series CX750 2023 (750 W)', '123.00', 0, 'fuente', '1', 'https://i.postimg.cc/62pZn20C/2.png[/img][/url]'),
(51, 'Casecom C412-3B', '123.00', 11, 'gabinete', '1', 'https://i.postimg.cc/t15PsthX/4.png[/img][/url]'),
(57, 'a', '11.00', 111, 'teclado', '1', 'https://i.postimg.cc/kDZSR5tt/9.png[/img][/url]'),
(58, 'a', '11.00', 111, 'teclado', '1', 'https://i.postimg.cc/kDZSR5tt/9.png[/img][/url]'),
(59, 'a', '11.00', 111, 'teclado', '1', 'https://i.postimg.cc/kDZSR5tt/9.png[/img][/url]'),
(60, 'a', '11.00', 111, 'teclado', '2', 'https://i.postimg.cc/kDZSR5tt/9.png[/img][/url]'),
(61, 'a', '11.00', 111, 'teclado', '2', 'https://i.postimg.cc/kDZSR5tt/9.png[/img][/url]');

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
(120, 36, 'resolucion_monitor', '81'),
(121, 36, 'tamanio_monitor', '78'),
(122, 36, 'tasa_refresco', '168'),
(123, 36, 'tiempo_respuesta', '179'),
(124, 36, 'soporte_monitor', '170'),
(125, 36, 'tipo_panel', '82'),
(126, 36, 'tipo_curvatura', '79'),
(127, 37, 'tipo_audifono', '176'),
(128, 37, 'tipo_microfono', '177'),
(129, 37, 'anc', '196'),
(130, 37, 'conectividad', '141'),
(131, 37, 'iluminacion', '197'),
(135, 39, 'dpi_mouse', '77'),
(136, 39, 'peso_mouse', '161'),
(137, 39, 'sensor_mouse', '75'),
(138, 39, 'iluminacion', '155'),
(139, 39, 'conectividad', '76'),
(143, 41, 'frecuencia_gpu', '58'),
(144, 41, 'memoria_gpu', '59'),
(158, 46, 'bateria_notebook', '24'),
(159, 46, 'cpu_notebook', '23'),
(160, 46, 'gpu_notebook', '26'),
(161, 46, 'capacidad_ram', '56'),
(162, 46, 'pantalla_notebook', '25'),
(175, 35, 'tipo_teclado', '86'),
(176, 35, 'tipo_switch', '159'),
(177, 35, 'conectividad', '76'),
(178, 35, 'iluminacion', '155'),
(179, 35, 'categoria_teclado', '173'),
(180, 49, 'tipo_ram', '44'),
(181, 49, 'velocidad_ram', '55'),
(182, 49, 'capacidad_ram', '56'),
(183, 49, 'formato_ram', '57'),
(184, 50, 'certificacion_fuente', '70'),
(185, 50, 'potencia_fuente', '66'),
(186, 50, 'tamanio_fuente', '67'),
(187, 51, 'tamanio_max_gabinete', '68'),
(188, 51, 'iluminacion', '155'),
(213, 41, 'bus_de_entrada_gpu', '100'),
(214, 57, 'tipo_teclado', '66'),
(215, 57, 'tipo_switch', '159'),
(216, 57, 'conectividad', '76'),
(217, 57, 'iluminacion', '197'),
(218, 57, 'categoria_teclado', '173'),
(219, 58, 'tipo_teclado', '66'),
(220, 58, 'tipo_switch', '159'),
(221, 58, 'conectividad', '76'),
(222, 58, 'iluminacion', '155'),
(223, 58, 'categoria_teclado', '173'),
(224, 59, 'tipo_teclado', '66'),
(225, 59, 'tipo_switch', '159'),
(226, 59, 'conectividad', '76'),
(227, 59, 'iluminacion', '197'),
(228, 59, 'categoria_teclado', '173'),
(229, 60, 'tipo_teclado', '66'),
(230, 60, 'tipo_switch', '159'),
(231, 60, 'conectividad', '76'),
(232, 60, 'iluminacion', '197'),
(233, 60, 'categoria_teclado', '173'),
(234, 61, 'tipo_teclado', '66'),
(235, 61, 'tipo_switch', '159'),
(236, 61, 'conectividad', '76'),
(237, 61, 'iluminacion', '197'),
(238, 61, 'categoria_teclado', '173');

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
(67, 'Estandar ATX');

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
(181, '165 Hz');

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
(171, 'Rojo');

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
-- Indices de la tabla `boletas`
--
ALTER TABLE `boletas`
  ADD PRIMARY KEY (`id_boleta`);

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
  ADD KEY `correo` (`correo`);

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
-- Indices de la tabla `voltaje_ram`
--
ALTER TABLE `voltaje_ram`
  ADD PRIMARY KEY (`id_hardware`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `boletas`
--
ALTER TABLE `boletas`
  MODIFY `id_boleta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT de la tabla `detalle_boletas`
--
ALTER TABLE `detalle_boletas`
  MODIFY `id_detalle_boleta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `hardware`
--
ALTER TABLE `hardware`
  MODIFY `id_hardware` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=109;

--
-- AUTO_INCREMENT de la tabla `historial_compra`
--
ALTER TABLE `historial_compra`
  MODIFY `id_historal` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `marca`
--
ALTER TABLE `marca`
  MODIFY `id_marca` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `notebook`
--
ALTER TABLE `notebook`
  MODIFY `id_notebook` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de la tabla `orden_compra`
--
ALTER TABLE `orden_compra`
  MODIFY `id_orden` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `periferico`
--
ALTER TABLE `periferico`
  MODIFY `id_periferico` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=199;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT de la tabla `producto_caracteristica`
--
ALTER TABLE `producto_caracteristica`
  MODIFY `id_caracteristica` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=244;

--
-- AUTO_INCREMENT de la tabla `resena_valoracion`
--
ALTER TABLE `resena_valoracion`
  MODIFY `id_resena` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

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
-- Filtros para la tabla `bus_de_entrada_gpu`
--
ALTER TABLE `bus_de_entrada_gpu`
  ADD CONSTRAINT `bus_de_entrada_gpu_ibfk_1` FOREIGN KEY (`id_hardware`) REFERENCES `hardware` (`id_hardware`);

--
-- Filtros para la tabla `bus_hdd`
--
ALTER TABLE `bus_hdd`
  ADD CONSTRAINT `bus_hdd_ibfk_1` FOREIGN KEY (`id_hardware`) REFERENCES `hardware` (`id_hardware`);

--
-- Filtros para la tabla `bus_ssd`
--
ALTER TABLE `bus_ssd`
  ADD CONSTRAINT `bus_ssd_ibfk_1` FOREIGN KEY (`id_hardware`) REFERENCES `hardware` (`id_hardware`);

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
-- Filtros para la tabla `chipset_placa`
--
ALTER TABLE `chipset_placa`
  ADD CONSTRAINT `chipset_placa_ibfk_1` FOREIGN KEY (`id_hardware`) REFERENCES `hardware` (`id_hardware`);

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
-- Filtros para la tabla `detalle_boletas`
--
ALTER TABLE `detalle_boletas`
  ADD CONSTRAINT `detalle_boletas_ibfk_1` FOREIGN KEY (`id_boleta`) REFERENCES `boletas` (`id_boleta`),
  ADD CONSTRAINT `detalle_boletas_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`);

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
-- Filtros para la tabla `formato_ssd`
--
ALTER TABLE `formato_ssd`
  ADD CONSTRAINT `formato_ssd_ibfk_1` FOREIGN KEY (`id_hardware`) REFERENCES `hardware` (`id_hardware`);

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
-- Filtros para la tabla `producto_caracteristica`
--
ALTER TABLE `producto_caracteristica`
  ADD CONSTRAINT `producto_caracteristica_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`) ON DELETE CASCADE;

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
-- Filtros para la tabla `rpm_hdd`
--
ALTER TABLE `rpm_hdd`
  ADD CONSTRAINT `rpm_hdd_ibfk_1` FOREIGN KEY (`id_hardware`) REFERENCES `hardware` (`id_hardware`);

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
-- Filtros para la tabla `tamanio_hdd`
--
ALTER TABLE `tamanio_hdd`
  ADD CONSTRAINT `tamanio_hdd_ibfk_1` FOREIGN KEY (`id_hardware`) REFERENCES `hardware` (`id_hardware`);

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
