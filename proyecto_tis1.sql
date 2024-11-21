-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 11, 2024 at 11:57 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `proyecto_tis1`
--

-- --------------------------------------------------------

--
-- Table structure for table `anc`
--

CREATE TABLE `anc` (
  `id_periferico` int(11) NOT NULL,
  `anc` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `anc`
--

INSERT INTO `anc` (`id_periferico`, `anc`) VALUES
(178, 'Si'),
(196, 'No');

-- --------------------------------------------------------

--
-- Table structure for table `asocia`
--

CREATE TABLE `asocia` (
  `id_orden` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bateria_notebook`
--

CREATE TABLE `bateria_notebook` (
  `id_notebook` int(11) NOT NULL,
  `bateria_notebook` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bateria_notebook`
--

INSERT INTO `bateria_notebook` (`id_notebook`, `bateria_notebook`) VALUES
(24, '60000 mWh'),
(27, '45000 mWh');

-- --------------------------------------------------------

--
-- Table structure for table `boletas`
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
-- Dumping data for table `boletas`
--

INSERT INTO `boletas` (`id_boleta`, `id_usuario`, `fecha`, `total`, `codigo_autorizacion`, `detalles`) VALUES
(2, 46, '2024-11-10 22:10:09', 300000.00, '1213', '[{\"producto\":\"Monitor Gamer\",\"cantidad\":2,\"precio_unitario\":\"120000.00\",\"total\":240000},{\"producto\":\"Teclado gamer\",\"cantidad\":1,\"precio_unitario\":\"60000.00\",\"total\":60000}]'),
(3, 46, '2024-11-11 01:09:47', 60000.00, '1213', '[{\"producto\":\"Teclado gamer\",\"cantidad\":1,\"precio_unitario\":\"60000.00\",\"total\":60000}]');

-- --------------------------------------------------------

--
-- Table structure for table `bus_de_entrada_gpu`
--

CREATE TABLE `bus_de_entrada_gpu` (
  `id_hardware` int(11) NOT NULL,
  `bus_de_entrada_gpu` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bus_de_entrada_gpu`
--

INSERT INTO `bus_de_entrada_gpu` (`id_hardware`, `bus_de_entrada_gpu`) VALUES
(84, 'PCI Express 2.0 x16'),
(100, 'PCI Express 4.0 x8');

-- --------------------------------------------------------

--
-- Table structure for table `bus_hdd`
--

CREATE TABLE `bus_hdd` (
  `id_hardware` int(11) NOT NULL,
  `bus_hdd` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bus_hdd`
--

INSERT INTO `bus_hdd` (`id_hardware`, `bus_hdd`) VALUES
(76, 'SATA 3 (6.0 Gb/s)');

-- --------------------------------------------------------

--
-- Table structure for table `bus_ssd`
--

CREATE TABLE `bus_ssd` (
  `id_hardware` int(11) NOT NULL,
  `bus_ssd` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bus_ssd`
--

INSERT INTO `bus_ssd` (`id_hardware`, `bus_ssd`) VALUES
(89, 'SATA 3 (6.0 Gb/s)'),
(90, 'PCIe 4.0 x4');

-- --------------------------------------------------------

--
-- Table structure for table `capacidad_almacenamiento`
--

CREATE TABLE `capacidad_almacenamiento` (
  `id_hardware` int(11) NOT NULL,
  `capacidad_almacenamiento` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `capacidad_almacenamiento`
--

INSERT INTO `capacidad_almacenamiento` (`id_hardware`, `capacidad_almacenamiento`) VALUES
(40, '500GB'),
(41, '1TB'),
(87, '2TB');

-- --------------------------------------------------------

--
-- Table structure for table `capacidad_ram`
--

CREATE TABLE `capacidad_ram` (
  `id_hardware` int(11) NOT NULL,
  `capacidad_ram` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `capacidad_ram`
--

INSERT INTO `capacidad_ram` (`id_hardware`, `capacidad_ram`) VALUES
(56, '1 x 8 GB'),
(96, '1 x 4 GB');

-- --------------------------------------------------------

--
-- Table structure for table `categoria_teclado`
--

CREATE TABLE `categoria_teclado` (
  `id_periferico` int(11) NOT NULL,
  `categoria_teclado` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categoria_teclado`
--

INSERT INTO `categoria_teclado` (`id_periferico`, `categoria_teclado`) VALUES
(173, '100% (Teclado full)'),
(174, '80% (Tenkeyless)'),
(175, '60%');

-- --------------------------------------------------------

--
-- Table structure for table `certificacion_fuente`
--

CREATE TABLE `certificacion_fuente` (
  `id_hardware` int(11) NOT NULL,
  `certificacion_fuente` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `certificacion_fuente`
--

INSERT INTO `certificacion_fuente` (`id_hardware`, `certificacion_fuente`) VALUES
(65, '80PLUS Bronze'),
(70, 'Sin certificación');

-- --------------------------------------------------------

--
-- Table structure for table `chipset_placa`
--

CREATE TABLE `chipset_placa` (
  `id_hardware` int(11) NOT NULL,
  `chipset_placa` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chipset_placa`
--

INSERT INTO `chipset_placa` (`id_hardware`, `chipset_placa`) VALUES
(63, 'AMD B550 (AM4)'),
(106, 'AMD A68H (FM2+)');

-- --------------------------------------------------------

--
-- Table structure for table `conectividad`
--

CREATE TABLE `conectividad` (
  `id_periferico` int(11) NOT NULL,
  `conectividad` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `conectividad`
--

INSERT INTO `conectividad` (`id_periferico`, `conectividad`) VALUES
(76, 'Bluetooth'),
(141, 'Analoga');

-- --------------------------------------------------------

--
-- Table structure for table `cpu_notebook`
--

CREATE TABLE `cpu_notebook` (
  `id_notebook` int(11) NOT NULL,
  `cpu_notebook` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cpu_notebook`
--

INSERT INTO `cpu_notebook` (`id_notebook`, `cpu_notebook`) VALUES
(23, 'Intel Core i7-13620H (2400 MHz - 4900 MHz)'),
(28, 'AMD Ryzen 5 6600H (3300 MHz - 4500 MHz)');

-- --------------------------------------------------------

--
-- Table structure for table `detalle_boletas`
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
-- Dumping data for table `detalle_boletas`
--

INSERT INTO `detalle_boletas` (`id_detalle_boleta`, `id_boleta`, `id_producto`, `cantidad`, `precio_unitario`, `precio_total`) VALUES
(2, 11, 35, 1, 60000.00, 60000.00),
(3, 12, 35, 1, 60000.00, 60000.00),
(4, 13, 36, 1, 120000.00, 120000.00),
(5, 14, 35, 1, 60000.00, 60000.00),
(6, 14, 36, 5, 120000.00, 600000.00),
(7, 15, 35, 1, 60000.00, 60000.00),
(8, 16, 35, 1, 60000.00, 60000.00),
(9, 17, 35, 1, 60000.00, 60000.00),
(10, 18, 36, 1, 120000.00, 120000.00),
(11, 19, 35, 1, 60000.00, 60000.00),
(12, 20, 36, 1, 120000.00, 120000.00),
(13, 21, 35, 1, 60000.00, 60000.00),
(14, 22, 35, 1, 60000.00, 60000.00),
(15, 23, 35, 1, 60000.00, 60000.00),
(16, 24, 35, 1, 60000.00, 60000.00),
(17, 25, 35, 1, 60000.00, 60000.00),
(18, 26, 36, 1, 120000.00, 120000.00),
(19, 27, 36, 1, 120000.00, 120000.00),
(20, 28, 36, 6, 120000.00, 720000.00),
(21, 29, 35, 1, 60000.00, 60000.00),
(22, 30, 35, 3, 60000.00, 180000.00),
(23, 30, 49, 2, 123.00, 246.00);

-- --------------------------------------------------------

--
-- Table structure for table `dpi_mouse`
--

CREATE TABLE `dpi_mouse` (
  `id_periferico` int(11) NOT NULL,
  `dpi_mouse` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dpi_mouse`
--

INSERT INTO `dpi_mouse` (`id_periferico`, `dpi_mouse`) VALUES
(77, '16000'),
(191, '12000'),
(193, '8000');

-- --------------------------------------------------------

--
-- Table structure for table `formato_placa`
--

CREATE TABLE `formato_placa` (
  `id_hardware` int(11) NOT NULL,
  `formato_placa` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `formato_placa`
--

INSERT INTO `formato_placa` (`id_hardware`, `formato_placa`) VALUES
(60, 'Micro ATX');

-- --------------------------------------------------------

--
-- Table structure for table `formato_ram`
--

CREATE TABLE `formato_ram` (
  `id_hardware` int(11) NOT NULL,
  `formato_ram` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `formato_ram`
--

INSERT INTO `formato_ram` (`id_hardware`, `formato_ram`) VALUES
(57, 'DIMM');

-- --------------------------------------------------------

--
-- Table structure for table `formato_ssd`
--

CREATE TABLE `formato_ssd` (
  `id_hardware` int(11) NOT NULL,
  `formato_ssd` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `formato_ssd`
--

INSERT INTO `formato_ssd` (`id_hardware`, `formato_ssd`) VALUES
(83, 'M.2 (2280)'),
(91, '2.5\"');

-- --------------------------------------------------------

--
-- Table structure for table `frecuencia_cpu`
--

CREATE TABLE `frecuencia_cpu` (
  `id_hardware` int(11) NOT NULL,
  `frecuencia_cpu` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `frecuencia_cpu`
--

INSERT INTO `frecuencia_cpu` (`id_hardware`, `frecuencia_cpu`) VALUES
(24, '3000 MHz'),
(69, '3600 MHz'),
(98, '3800 MHz');

-- --------------------------------------------------------

--
-- Table structure for table `frecuencia_gpu`
--

CREATE TABLE `frecuencia_gpu` (
  `id_hardware` int(11) NOT NULL,
  `frecuencia_gpu` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `frecuencia_gpu`
--

INSERT INTO `frecuencia_gpu` (`id_hardware`, `frecuencia_gpu`) VALUES
(58, '2125 MHz'),
(102, '2000 MHz');

-- --------------------------------------------------------

--
-- Table structure for table `gpu_notebook`
--

CREATE TABLE `gpu_notebook` (
  `id_notebook` int(11) NOT NULL,
  `gpu_notebook` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gpu_notebook`
--

INSERT INTO `gpu_notebook` (`id_notebook`, `gpu_notebook`) VALUES
(26, 'NVIDIA GeForce RTX 4060 (8 GB)'),
(29, 'NVIDIA GeForce RTX 3050 (4 GB)');

-- --------------------------------------------------------

--
-- Table structure for table `hardware`
--

CREATE TABLE `hardware` (
  `id_hardware` int(11) NOT NULL,
  `id_producto` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hardware`
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
-- Table structure for table `historial_compras`
--

CREATE TABLE `historial_compras` (
  `id_historial` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_boleta` int(11) NOT NULL,
  `fecha_compra` datetime DEFAULT current_timestamp(),
  `total` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `historial_compras`
--

INSERT INTO `historial_compras` (`id_historial`, `id_usuario`, `id_boleta`, `fecha_compra`, `total`) VALUES
(1, 46, 2, '2024-11-10 22:10:09', 300000.00),
(2, 46, 3, '2024-11-11 01:09:47', 60000.00);

-- --------------------------------------------------------

--
-- Table structure for table `iluminacion`
--

CREATE TABLE `iluminacion` (
  `id_periferico` int(11) NOT NULL,
  `iluminacion` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `iluminacion`
--

INSERT INTO `iluminacion` (`id_periferico`, `iluminacion`) VALUES
(155, 'RGB'),
(197, 'No');

-- --------------------------------------------------------

--
-- Table structure for table `lista_deseo_producto`
--

CREATE TABLE `lista_deseo_producto` (
  `id_lista` int(11) NOT NULL,
  `nombre_lista` varchar(255) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lista_deseo_producto`
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
-- Table structure for table `marca`
--

CREATE TABLE `marca` (
  `id_marca` int(11) NOT NULL,
  `nombre_marca` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `marca`
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
-- Table structure for table `memoria`
--

CREATE TABLE `memoria` (
  `id_hardware` int(11) NOT NULL,
  `memoria` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `memoria_gpu`
--

CREATE TABLE `memoria_gpu` (
  `id_hardware` int(11) NOT NULL,
  `memoria_gpu` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `memoria_gpu`
--

INSERT INTO `memoria_gpu` (`id_hardware`, `memoria_gpu`) VALUES
(59, '8 GB GDDR6 '),
(101, '4 GB GDDR6');

-- --------------------------------------------------------

--
-- Table structure for table `notebook`
--

CREATE TABLE `notebook` (
  `id_notebook` int(11) NOT NULL,
  `id_producto` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notebook`
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
-- Table structure for table `nucleo_hilo_cpu`
--

CREATE TABLE `nucleo_hilo_cpu` (
  `id_hardware` int(11) NOT NULL,
  `nucleo_hilo_cpu` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `nucleo_hilo_cpu`
--

INSERT INTO `nucleo_hilo_cpu` (`id_hardware`, `nucleo_hilo_cpu`) VALUES
(39, '2 Nucleos / 2 Hilos'),
(47, '4 núcleos / 8 hilos');

-- --------------------------------------------------------

--
-- Table structure for table `orden_compra`
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
-- Table structure for table `pantalla_notebook`
--

CREATE TABLE `pantalla_notebook` (
  `id_notebook` int(11) NOT NULL,
  `pantalla_notebook` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pantalla_notebook`
--

INSERT INTO `pantalla_notebook` (`id_notebook`, `pantalla_notebook`) VALUES
(25, 'LED 15.6\" (1920x1080) / 144 Hz'),
(30, 'LED 15.6\" (1920x1080) / 60 Hz');

-- --------------------------------------------------------

--
-- Table structure for table `periferico`
--

CREATE TABLE `periferico` (
  `id_periferico` int(11) NOT NULL,
  `id_producto` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `periferico`
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
-- Table structure for table `pertenece`
--

CREATE TABLE `pertenece` (
  `nombre_lista` varchar(255) NOT NULL,
  `id_producto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `peso_mouse`
--

CREATE TABLE `peso_mouse` (
  `id_periferico` int(11) NOT NULL,
  `peso_mouse` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `peso_mouse`
--

INSERT INTO `peso_mouse` (`id_periferico`, `peso_mouse`) VALUES
(161, '99 g'),
(194, ' 85 g');

-- --------------------------------------------------------

--
-- Table structure for table `potencia_fuente`
--

CREATE TABLE `potencia_fuente` (
  `id_hardware` int(11) NOT NULL,
  `potencia_fuente` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `potencia_fuente`
--

INSERT INTO `potencia_fuente` (`id_hardware`, `potencia_fuente`) VALUES
(66, '500 W'),
(107, '650 W');

-- --------------------------------------------------------

--
-- Table structure for table `producto`
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
-- Dumping data for table `producto`
--

INSERT INTO `producto` (`id_producto`, `nombre_producto`, `precio`, `cantidad`, `tipo_producto`, `marca`, `imagen_url`) VALUES
(35, 'Teclado gamer', 60000.00, 86, 'teclado', '1', 'https://i.postimg.cc/kDZSR5tt/9.png[/img][/url]'),
(36, 'Monitor Gamer', 120000.00, 1108, 'monitor', '1', 'https://i.postimg.cc/Js3HFcYb/10.png[/img][/url]'),
(37, 'Audifono generico', 10000.00, 111, 'audifono', '1', 'https://i.postimg.cc/NyYmGP2J/3.png[/img][/url]'),
(39, 'Mouse generico', 5000.00, 1, 'mouse', '1', 'https://i.postimg.cc/yDCSnrj1/11.png[/img][/url]'),
(41, 'MSI GeForce RTX 4060', 123.00, 0, 'gpu', '1', 'https://i.postimg.cc/TLND9d7F/5.png[/img][/url]'),
(46, 'ASUS TUF A15 FA506NF-HN003W', 123.00, 1, 'notebook', '1', 'https://i.postimg.cc/TyR5vLBB/12.png[/img][/url]'),
(49, 'Kingston KVR26N19S6/4 (1 x 4GB | DIMM DDR4-2666)', 123.00, 1, 'ram', '1', 'https://i.postimg.cc/7JCTtFj6/7.png[/img][/url]'),
(50, 'Corsair CX Series CX750 2023 (750 W)', 123.00, 0, 'fuente', '1', 'https://i.postimg.cc/62pZn20C/2.png[/img][/url]'),
(51, 'Casecom C412-3B', 123.00, 11, 'gabinete', '1', 'https://i.postimg.cc/t15PsthX/4.png[/img][/url]'),
(57, 'a', 11.00, 111, 'teclado', '1', 'https://i.postimg.cc/kDZSR5tt/9.png[/img][/url]'),
(58, 'a', 11.00, 111, 'teclado', '1', 'https://i.postimg.cc/kDZSR5tt/9.png[/img][/url]'),
(59, 'a', 11.00, 111, 'teclado', '1', 'https://i.postimg.cc/kDZSR5tt/9.png[/img][/url]'),
(60, 'a', 11.00, 111, 'teclado', '2', 'https://i.postimg.cc/kDZSR5tt/9.png[/img][/url]'),
(61, 'a', 11.00, 111, 'teclado', '2', 'https://i.postimg.cc/kDZSR5tt/9.png[/img][/url]'),
(63, 'sexo', 1111.00, 1111, 'notebook', '1', 'https://i.postimg.cc/kDZSR5tt/9.png[/img][/url]'),
(64, 'aaa', 12312.00, 12331, 'notebook', '2', 'https://i.postimg.cc/kDZSR5tt/9.png[/img][/url]'),
(65, 'adsada', 12312.00, 12331, 'notebook', '7', 'https://imagedelivery.net/4fYuQyy-r8_rpBpcY7lH_A/falabellaCL/17152025_1/w=1500,h=1500,fit=pad');

-- --------------------------------------------------------

--
-- Table structure for table `producto_caracteristica`
--

CREATE TABLE `producto_caracteristica` (
  `id_caracteristica` int(11) NOT NULL,
  `id_producto` int(11) DEFAULT NULL,
  `caracteristica` varchar(255) DEFAULT NULL,
  `valor_caracteristica` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `producto_caracteristica`
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
(238, 61, 'categoria_teclado', '173'),
(244, 63, 'bateria_notebook', '24'),
(245, 63, 'cpu_notebook', '23'),
(246, 63, 'gpu_notebook', '26'),
(247, 63, 'capacidad_ram', '56'),
(248, 63, 'pantalla_notebook', '25'),
(249, 64, 'bateria_notebook', '27'),
(250, 64, 'cpu_notebook', '28'),
(251, 64, 'gpu_notebook', '29'),
(252, 64, 'capacidad_ram', '96'),
(253, 64, 'pantalla_notebook', '30'),
(254, 65, 'bateria_notebook', '27'),
(255, 65, 'cpu_notebook', '23'),
(256, 65, 'gpu_notebook', '29'),
(257, 65, 'capacidad_ram', '96'),
(258, 65, 'pantalla_notebook', '25');

-- --------------------------------------------------------

--
-- Table structure for table `resena_valoracion`
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
-- Dumping data for table `resena_valoracion`
--

INSERT INTO `resena_valoracion` (`id_resena`, `valoracion`, `comentario`, `id_producto`, `user_id`, `fecha`) VALUES
(13, 5, 'Buen producto :)', 35, 47, '2024-11-08 20:11:07'),
(14, 4, 'xd', 60, 46, '2024-11-09 19:29:23'),
(15, 5, 'xd', 36, 46, '2024-11-11 01:15:28'),
(16, 5, 'xdddd', 35, 46, '2024-11-11 19:37:35');

-- --------------------------------------------------------

--
-- Table structure for table `resolucion_monitor`
--

CREATE TABLE `resolucion_monitor` (
  `id_periferico` int(11) NOT NULL,
  `resolucion_monitor` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `resolucion_monitor`
--

INSERT INTO `resolucion_monitor` (`id_periferico`, `resolucion_monitor`) VALUES
(81, 'Full HD (1920x1080)'),
(189, 'Ultra HD (3840x2160)');

-- --------------------------------------------------------

--
-- Table structure for table `rpm_hdd`
--

CREATE TABLE `rpm_hdd` (
  `id_hardware` int(11) NOT NULL,
  `rpm_hdd` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rpm_hdd`
--

INSERT INTO `rpm_hdd` (`id_hardware`, `rpm_hdd`) VALUES
(80, '7200 rpm'),
(92, '5400 rpm');

-- --------------------------------------------------------

--
-- Table structure for table `sensor_mouse`
--

CREATE TABLE `sensor_mouse` (
  `id_periferico` int(11) NOT NULL,
  `sensor_mouse` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sensor_mouse`
--

INSERT INTO `sensor_mouse` (`id_periferico`, `sensor_mouse`) VALUES
(75, 'Optico'),
(192, 'Laser');

-- --------------------------------------------------------

--
-- Table structure for table `slot_memoria_placa`
--

CREATE TABLE `slot_memoria_placa` (
  `id_hardware` int(11) NOT NULL,
  `slot_memoria_placa` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `slot_memoria_placa`
--

INSERT INTO `slot_memoria_placa` (`id_hardware`, `slot_memoria_placa`) VALUES
(34, '4x DDR4'),
(103, '2x DDR4'),
(105, '2x DDR3');

-- --------------------------------------------------------

--
-- Table structure for table `socket_cpu`
--

CREATE TABLE `socket_cpu` (
  `id_hardware` int(11) NOT NULL,
  `socket_cpu` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `socket_cpu`
--

INSERT INTO `socket_cpu` (`id_hardware`, `socket_cpu`) VALUES
(54, 'LGA 1150'),
(97, 'LGA 1200'),
(99, 'AM4');

-- --------------------------------------------------------

--
-- Table structure for table `socket_placa`
--

CREATE TABLE `socket_placa` (
  `id_hardware` int(11) NOT NULL,
  `socket_placa` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `socket_placa`
--

INSERT INTO `socket_placa` (`id_hardware`, `socket_placa`) VALUES
(61, 'AM4'),
(104, 'FM2+');

-- --------------------------------------------------------

--
-- Table structure for table `soporte_monitor`
--

CREATE TABLE `soporte_monitor` (
  `id_periferico` int(11) NOT NULL,
  `soporte_monitor` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `soporte_monitor`
--

INSERT INTO `soporte_monitor` (`id_periferico`, `soporte_monitor`) VALUES
(170, 'G-Sync / FreeSync'),
(182, 'No'),
(183, 'G-Sync'),
(184, 'FreeSync');

-- --------------------------------------------------------

--
-- Table structure for table `tamanio_fuente`
--

CREATE TABLE `tamanio_fuente` (
  `id_hardware` int(11) NOT NULL,
  `tamanio_fuente` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tamanio_fuente`
--

INSERT INTO `tamanio_fuente` (`id_hardware`, `tamanio_fuente`) VALUES
(67, 'Estandar ATX');

-- --------------------------------------------------------

--
-- Table structure for table `tamanio_hdd`
--

CREATE TABLE `tamanio_hdd` (
  `id_hardware` int(11) NOT NULL,
  `tamanio_hdd` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tamanio_hdd`
--

INSERT INTO `tamanio_hdd` (`id_hardware`, `tamanio_hdd`) VALUES
(78, '3.5\"'),
(93, '2.5\"');

-- --------------------------------------------------------

--
-- Table structure for table `tamanio_max_gabinete`
--

CREATE TABLE `tamanio_max_gabinete` (
  `id_hardware` int(11) NOT NULL,
  `tamanio_max_gabinete` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tamanio_max_gabinete`
--

INSERT INTO `tamanio_max_gabinete` (`id_hardware`, `tamanio_max_gabinete`) VALUES
(68, 'ATX'),
(108, 'Micro ATX');

-- --------------------------------------------------------

--
-- Table structure for table `tamanio_monitor`
--

CREATE TABLE `tamanio_monitor` (
  `id_periferico` int(11) NOT NULL,
  `tamanio_monitor` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tamanio_monitor`
--

INSERT INTO `tamanio_monitor` (`id_periferico`, `tamanio_monitor`) VALUES
(78, '24.0\"'),
(180, '27.0\"'),
(190, '32.0\"');

-- --------------------------------------------------------

--
-- Table structure for table `tasa_refresco`
--

CREATE TABLE `tasa_refresco` (
  `id_periferico` int(11) NOT NULL,
  `tasa_refresco` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tasa_refresco`
--

INSERT INTO `tasa_refresco` (`id_periferico`, `tasa_refresco`) VALUES
(168, '60 Hz'),
(181, '165 Hz');

-- --------------------------------------------------------

--
-- Table structure for table `tiempo_respuesta`
--

CREATE TABLE `tiempo_respuesta` (
  `id_periferico` int(11) NOT NULL,
  `tiempo_respuesta` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tiempo_respuesta`
--

INSERT INTO `tiempo_respuesta` (`id_periferico`, `tiempo_respuesta`) VALUES
(80, '5 ms'),
(179, '1 ms');

-- --------------------------------------------------------

--
-- Table structure for table `tipo_audifono`
--

CREATE TABLE `tipo_audifono` (
  `id_periferico` int(11) NOT NULL,
  `tipo_audifono` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tipo_audifono`
--

INSERT INTO `tipo_audifono` (`id_periferico`, `tipo_audifono`) VALUES
(176, 'Over-Ear / Headset'),
(198, 'True Wireless');

-- --------------------------------------------------------

--
-- Table structure for table `tipo_cableado`
--

CREATE TABLE `tipo_cableado` (
  `id_hardware` int(11) NOT NULL,
  `tipo_cableado` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tipo_curvatura`
--

CREATE TABLE `tipo_curvatura` (
  `id_periferico` int(11) NOT NULL,
  `tipo_curvatura` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tipo_curvatura`
--

INSERT INTO `tipo_curvatura` (`id_periferico`, `tipo_curvatura`) VALUES
(79, 'Si'),
(188, 'No');

-- --------------------------------------------------------

--
-- Table structure for table `tipo_microfono`
--

CREATE TABLE `tipo_microfono` (
  `id_periferico` int(11) NOT NULL,
  `tipo_microfono` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tipo_microfono`
--

INSERT INTO `tipo_microfono` (`id_periferico`, `tipo_microfono`) VALUES
(177, 'Montado (invisible)'),
(195, 'Externo (estilo headset)');

-- --------------------------------------------------------

--
-- Table structure for table `tipo_panel`
--

CREATE TABLE `tipo_panel` (
  `id_periferico` int(11) NOT NULL,
  `tipo_panel` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tipo_panel`
--

INSERT INTO `tipo_panel` (`id_periferico`, `tipo_panel`) VALUES
(82, 'LED'),
(185, 'IPS'),
(186, 'VA'),
(187, 'TN');

-- --------------------------------------------------------

--
-- Table structure for table `tipo_ram`
--

CREATE TABLE `tipo_ram` (
  `id_hardware` int(11) NOT NULL,
  `tipo_ram` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tipo_ram`
--

INSERT INTO `tipo_ram` (`id_hardware`, `tipo_ram`) VALUES
(44, 'DDR4'),
(94, 'DDR5');

-- --------------------------------------------------------

--
-- Table structure for table `tipo_switch`
--

CREATE TABLE `tipo_switch` (
  `id_periferico` int(11) NOT NULL,
  `tipo_switch` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tipo_switch`
--

INSERT INTO `tipo_switch` (`id_periferico`, `tipo_switch`) VALUES
(159, 'Azul'),
(171, 'Rojo');

-- --------------------------------------------------------

--
-- Table structure for table `tipo_teclado`
--

CREATE TABLE `tipo_teclado` (
  `id_periferico` int(11) NOT NULL,
  `tipo_teclado` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tipo_teclado`
--

INSERT INTO `tipo_teclado` (`id_periferico`, `tipo_teclado`) VALUES
(66, 'Mecanico'),
(86, 'Membrana');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`) VALUES
(46, 'admin', 'admin@admin.cl', '$2y$10$hnEq7BCps9MjNagRZbMkoO64Y9u7SDComOz8hPrNiRbQA3tAnjiKu', 'admin'),
(47, 'maty', 'matias@matias.cl', '$2y$10$1EF01TysLiHJkPLD3UTfoes/f1ocQmAJfR5IV.ODk.0P8VUJsc13S', 'user'),
(50, 'pepe', 'pee@pee.cl', '$2y$10$G0pfGwL7/PNO.vJirg1PIOg5G4A1R7eqbzLq70FOZslR/6xlxdnVq', 'user'),
(51, 'prueba', 'prueba@prueba.cl', '$2y$10$48yLlR2mmE0EpSe0uN4i2.t4FRKE3lGY2ZCA7996b8eGvo8R6E5ma', 'user'),
(52, 'dan', 'dan.programas.oc@gmail.com', '$2y$10$zSbYIAYWhm0nPLPl0i0wBO3T1kXMmPCvJzz/s.wj8XrwwQjXm55VK', 'user');

-- --------------------------------------------------------

--
-- Table structure for table `velocidad_ram`
--

CREATE TABLE `velocidad_ram` (
  `id_hardware` int(11) NOT NULL,
  `velocidad_ram` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `velocidad_ram`
--

INSERT INTO `velocidad_ram` (`id_hardware`, `velocidad_ram`) VALUES
(55, ' 4800 MT/s'),
(95, '2666 MT/s');

-- --------------------------------------------------------

--
-- Table structure for table `voltaje_ram`
--

CREATE TABLE `voltaje_ram` (
  `id_hardware` int(11) NOT NULL,
  `voltaje_ram` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `anc`
--
ALTER TABLE `anc`
  ADD PRIMARY KEY (`id_periferico`);

--
-- Indexes for table `asocia`
--
ALTER TABLE `asocia`
  ADD PRIMARY KEY (`id_orden`,`id_producto`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indexes for table `bateria_notebook`
--
ALTER TABLE `bateria_notebook`
  ADD PRIMARY KEY (`id_notebook`);

--
-- Indexes for table `boletas`
--
ALTER TABLE `boletas`
  ADD PRIMARY KEY (`id_boleta`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indexes for table `bus_de_entrada_gpu`
--
ALTER TABLE `bus_de_entrada_gpu`
  ADD PRIMARY KEY (`id_hardware`);

--
-- Indexes for table `bus_hdd`
--
ALTER TABLE `bus_hdd`
  ADD PRIMARY KEY (`id_hardware`);

--
-- Indexes for table `bus_ssd`
--
ALTER TABLE `bus_ssd`
  ADD PRIMARY KEY (`id_hardware`);

--
-- Indexes for table `capacidad_almacenamiento`
--
ALTER TABLE `capacidad_almacenamiento`
  ADD PRIMARY KEY (`id_hardware`);

--
-- Indexes for table `capacidad_ram`
--
ALTER TABLE `capacidad_ram`
  ADD PRIMARY KEY (`id_hardware`);

--
-- Indexes for table `categoria_teclado`
--
ALTER TABLE `categoria_teclado`
  ADD PRIMARY KEY (`id_periferico`);

--
-- Indexes for table `certificacion_fuente`
--
ALTER TABLE `certificacion_fuente`
  ADD PRIMARY KEY (`id_hardware`);

--
-- Indexes for table `chipset_placa`
--
ALTER TABLE `chipset_placa`
  ADD PRIMARY KEY (`id_hardware`);

--
-- Indexes for table `conectividad`
--
ALTER TABLE `conectividad`
  ADD PRIMARY KEY (`id_periferico`);

--
-- Indexes for table `cpu_notebook`
--
ALTER TABLE `cpu_notebook`
  ADD PRIMARY KEY (`id_notebook`);

--
-- Indexes for table `detalle_boletas`
--
ALTER TABLE `detalle_boletas`
  ADD PRIMARY KEY (`id_detalle_boleta`),
  ADD KEY `id_boleta` (`id_boleta`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indexes for table `dpi_mouse`
--
ALTER TABLE `dpi_mouse`
  ADD PRIMARY KEY (`id_periferico`);

--
-- Indexes for table `formato_placa`
--
ALTER TABLE `formato_placa`
  ADD PRIMARY KEY (`id_hardware`);

--
-- Indexes for table `formato_ram`
--
ALTER TABLE `formato_ram`
  ADD PRIMARY KEY (`id_hardware`);

--
-- Indexes for table `formato_ssd`
--
ALTER TABLE `formato_ssd`
  ADD PRIMARY KEY (`id_hardware`);

--
-- Indexes for table `frecuencia_cpu`
--
ALTER TABLE `frecuencia_cpu`
  ADD PRIMARY KEY (`id_hardware`);

--
-- Indexes for table `frecuencia_gpu`
--
ALTER TABLE `frecuencia_gpu`
  ADD PRIMARY KEY (`id_hardware`);

--
-- Indexes for table `gpu_notebook`
--
ALTER TABLE `gpu_notebook`
  ADD PRIMARY KEY (`id_notebook`);

--
-- Indexes for table `hardware`
--
ALTER TABLE `hardware`
  ADD PRIMARY KEY (`id_hardware`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indexes for table `historial_compras`
--
ALTER TABLE `historial_compras`
  ADD PRIMARY KEY (`id_historial`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_boleta` (`id_boleta`);

--
-- Indexes for table `iluminacion`
--
ALTER TABLE `iluminacion`
  ADD PRIMARY KEY (`id_periferico`);

--
-- Indexes for table `lista_deseo_producto`
--
ALTER TABLE `lista_deseo_producto`
  ADD PRIMARY KEY (`id_lista`),
  ADD KEY `nombre_lista` (`nombre_lista`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indexes for table `marca`
--
ALTER TABLE `marca`
  ADD PRIMARY KEY (`id_marca`);

--
-- Indexes for table `memoria`
--
ALTER TABLE `memoria`
  ADD PRIMARY KEY (`id_hardware`);

--
-- Indexes for table `memoria_gpu`
--
ALTER TABLE `memoria_gpu`
  ADD PRIMARY KEY (`id_hardware`);

--
-- Indexes for table `notebook`
--
ALTER TABLE `notebook`
  ADD PRIMARY KEY (`id_notebook`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indexes for table `nucleo_hilo_cpu`
--
ALTER TABLE `nucleo_hilo_cpu`
  ADD PRIMARY KEY (`id_hardware`);

--
-- Indexes for table `orden_compra`
--
ALTER TABLE `orden_compra`
  ADD PRIMARY KEY (`id_orden`);

--
-- Indexes for table `pantalla_notebook`
--
ALTER TABLE `pantalla_notebook`
  ADD PRIMARY KEY (`id_notebook`);

--
-- Indexes for table `periferico`
--
ALTER TABLE `periferico`
  ADD PRIMARY KEY (`id_periferico`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indexes for table `pertenece`
--
ALTER TABLE `pertenece`
  ADD PRIMARY KEY (`nombre_lista`,`id_producto`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indexes for table `peso_mouse`
--
ALTER TABLE `peso_mouse`
  ADD PRIMARY KEY (`id_periferico`);

--
-- Indexes for table `potencia_fuente`
--
ALTER TABLE `potencia_fuente`
  ADD PRIMARY KEY (`id_hardware`);

--
-- Indexes for table `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`id_producto`);

--
-- Indexes for table `producto_caracteristica`
--
ALTER TABLE `producto_caracteristica`
  ADD PRIMARY KEY (`id_caracteristica`),
  ADD KEY `producto_caracteristica_ibfk_1` (`id_producto`);

--
-- Indexes for table `resena_valoracion`
--
ALTER TABLE `resena_valoracion`
  ADD PRIMARY KEY (`id_resena`),
  ADD KEY `id_producto` (`id_producto`),
  ADD KEY `id_usuario` (`user_id`);

--
-- Indexes for table `resolucion_monitor`
--
ALTER TABLE `resolucion_monitor`
  ADD PRIMARY KEY (`id_periferico`);

--
-- Indexes for table `rpm_hdd`
--
ALTER TABLE `rpm_hdd`
  ADD PRIMARY KEY (`id_hardware`);

--
-- Indexes for table `sensor_mouse`
--
ALTER TABLE `sensor_mouse`
  ADD PRIMARY KEY (`id_periferico`);

--
-- Indexes for table `slot_memoria_placa`
--
ALTER TABLE `slot_memoria_placa`
  ADD PRIMARY KEY (`id_hardware`);

--
-- Indexes for table `socket_cpu`
--
ALTER TABLE `socket_cpu`
  ADD PRIMARY KEY (`id_hardware`);

--
-- Indexes for table `socket_placa`
--
ALTER TABLE `socket_placa`
  ADD PRIMARY KEY (`id_hardware`);

--
-- Indexes for table `soporte_monitor`
--
ALTER TABLE `soporte_monitor`
  ADD PRIMARY KEY (`id_periferico`);

--
-- Indexes for table `tamanio_fuente`
--
ALTER TABLE `tamanio_fuente`
  ADD PRIMARY KEY (`id_hardware`);

--
-- Indexes for table `tamanio_hdd`
--
ALTER TABLE `tamanio_hdd`
  ADD PRIMARY KEY (`id_hardware`);

--
-- Indexes for table `tamanio_max_gabinete`
--
ALTER TABLE `tamanio_max_gabinete`
  ADD PRIMARY KEY (`id_hardware`);

--
-- Indexes for table `tamanio_monitor`
--
ALTER TABLE `tamanio_monitor`
  ADD PRIMARY KEY (`id_periferico`);

--
-- Indexes for table `tasa_refresco`
--
ALTER TABLE `tasa_refresco`
  ADD PRIMARY KEY (`id_periferico`);

--
-- Indexes for table `tiempo_respuesta`
--
ALTER TABLE `tiempo_respuesta`
  ADD PRIMARY KEY (`id_periferico`);

--
-- Indexes for table `tipo_audifono`
--
ALTER TABLE `tipo_audifono`
  ADD PRIMARY KEY (`id_periferico`);

--
-- Indexes for table `tipo_cableado`
--
ALTER TABLE `tipo_cableado`
  ADD PRIMARY KEY (`id_hardware`);

--
-- Indexes for table `tipo_curvatura`
--
ALTER TABLE `tipo_curvatura`
  ADD PRIMARY KEY (`id_periferico`);

--
-- Indexes for table `tipo_microfono`
--
ALTER TABLE `tipo_microfono`
  ADD PRIMARY KEY (`id_periferico`);

--
-- Indexes for table `tipo_panel`
--
ALTER TABLE `tipo_panel`
  ADD PRIMARY KEY (`id_periferico`);

--
-- Indexes for table `tipo_ram`
--
ALTER TABLE `tipo_ram`
  ADD PRIMARY KEY (`id_hardware`);

--
-- Indexes for table `tipo_switch`
--
ALTER TABLE `tipo_switch`
  ADD PRIMARY KEY (`id_periferico`);

--
-- Indexes for table `tipo_teclado`
--
ALTER TABLE `tipo_teclado`
  ADD PRIMARY KEY (`id_periferico`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `velocidad_ram`
--
ALTER TABLE `velocidad_ram`
  ADD PRIMARY KEY (`id_hardware`);

--
-- Indexes for table `voltaje_ram`
--
ALTER TABLE `voltaje_ram`
  ADD PRIMARY KEY (`id_hardware`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `boletas`
--
ALTER TABLE `boletas`
  MODIFY `id_boleta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `detalle_boletas`
--
ALTER TABLE `detalle_boletas`
  MODIFY `id_detalle_boleta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `hardware`
--
ALTER TABLE `hardware`
  MODIFY `id_hardware` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=109;

--
-- AUTO_INCREMENT for table `historial_compras`
--
ALTER TABLE `historial_compras`
  MODIFY `id_historial` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `lista_deseo_producto`
--
ALTER TABLE `lista_deseo_producto`
  MODIFY `id_lista` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `marca`
--
ALTER TABLE `marca`
  MODIFY `id_marca` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `notebook`
--
ALTER TABLE `notebook`
  MODIFY `id_notebook` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `orden_compra`
--
ALTER TABLE `orden_compra`
  MODIFY `id_orden` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `periferico`
--
ALTER TABLE `periferico`
  MODIFY `id_periferico` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=199;

--
-- AUTO_INCREMENT for table `producto`
--
ALTER TABLE `producto`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `producto_caracteristica`
--
ALTER TABLE `producto_caracteristica`
  MODIFY `id_caracteristica` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=259;

--
-- AUTO_INCREMENT for table `resena_valoracion`
--
ALTER TABLE `resena_valoracion`
  MODIFY `id_resena` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `anc`
--
ALTER TABLE `anc`
  ADD CONSTRAINT `anc_ibfk_1` FOREIGN KEY (`id_periferico`) REFERENCES `periferico` (`id_periferico`);

--
-- Constraints for table `asocia`
--
ALTER TABLE `asocia`
  ADD CONSTRAINT `asocia_ibfk_1` FOREIGN KEY (`id_orden`) REFERENCES `orden_compra` (`id_orden`),
  ADD CONSTRAINT `asocia_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`);

--
-- Constraints for table `bateria_notebook`
--
ALTER TABLE `bateria_notebook`
  ADD CONSTRAINT `bateria_notebook_ibfk_1` FOREIGN KEY (`id_notebook`) REFERENCES `notebook` (`id_notebook`);

--
-- Constraints for table `boletas`
--
ALTER TABLE `boletas`
  ADD CONSTRAINT `boletas_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `bus_de_entrada_gpu`
--
ALTER TABLE `bus_de_entrada_gpu`
  ADD CONSTRAINT `bus_de_entrada_gpu_ibfk_1` FOREIGN KEY (`id_hardware`) REFERENCES `hardware` (`id_hardware`);

--
-- Constraints for table `bus_hdd`
--
ALTER TABLE `bus_hdd`
  ADD CONSTRAINT `bus_hdd_ibfk_1` FOREIGN KEY (`id_hardware`) REFERENCES `hardware` (`id_hardware`);

--
-- Constraints for table `bus_ssd`
--
ALTER TABLE `bus_ssd`
  ADD CONSTRAINT `bus_ssd_ibfk_1` FOREIGN KEY (`id_hardware`) REFERENCES `hardware` (`id_hardware`);

--
-- Constraints for table `capacidad_almacenamiento`
--
ALTER TABLE `capacidad_almacenamiento`
  ADD CONSTRAINT `capacidad_almacenamiento_ibfk_1` FOREIGN KEY (`id_hardware`) REFERENCES `hardware` (`id_hardware`);

--
-- Constraints for table `capacidad_ram`
--
ALTER TABLE `capacidad_ram`
  ADD CONSTRAINT `capacidad_ram_ibfk_1` FOREIGN KEY (`id_hardware`) REFERENCES `hardware` (`id_hardware`);

--
-- Constraints for table `certificacion_fuente`
--
ALTER TABLE `certificacion_fuente`
  ADD CONSTRAINT `certificacion_fuente_ibfk_1` FOREIGN KEY (`id_hardware`) REFERENCES `hardware` (`id_hardware`);

--
-- Constraints for table `chipset_placa`
--
ALTER TABLE `chipset_placa`
  ADD CONSTRAINT `chipset_placa_ibfk_1` FOREIGN KEY (`id_hardware`) REFERENCES `hardware` (`id_hardware`);

--
-- Constraints for table `conectividad`
--
ALTER TABLE `conectividad`
  ADD CONSTRAINT `conectividad_ibfk_1` FOREIGN KEY (`id_periferico`) REFERENCES `periferico` (`id_periferico`);

--
-- Constraints for table `cpu_notebook`
--
ALTER TABLE `cpu_notebook`
  ADD CONSTRAINT `cpu_notebook_ibfk_1` FOREIGN KEY (`id_notebook`) REFERENCES `notebook` (`id_notebook`);

--
-- Constraints for table `detalle_boletas`
--
ALTER TABLE `detalle_boletas`
  ADD CONSTRAINT `detalle_boletas_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`);

--
-- Constraints for table `dpi_mouse`
--
ALTER TABLE `dpi_mouse`
  ADD CONSTRAINT `dpi_mouse_ibfk_1` FOREIGN KEY (`id_periferico`) REFERENCES `periferico` (`id_periferico`);

--
-- Constraints for table `formato_placa`
--
ALTER TABLE `formato_placa`
  ADD CONSTRAINT `formato_placa_ibfk_1` FOREIGN KEY (`id_hardware`) REFERENCES `hardware` (`id_hardware`);

--
-- Constraints for table `formato_ram`
--
ALTER TABLE `formato_ram`
  ADD CONSTRAINT `formato_ram_ibfk_1` FOREIGN KEY (`id_hardware`) REFERENCES `hardware` (`id_hardware`);

--
-- Constraints for table `formato_ssd`
--
ALTER TABLE `formato_ssd`
  ADD CONSTRAINT `formato_ssd_ibfk_1` FOREIGN KEY (`id_hardware`) REFERENCES `hardware` (`id_hardware`);

--
-- Constraints for table `frecuencia_cpu`
--
ALTER TABLE `frecuencia_cpu`
  ADD CONSTRAINT `frecuencia_cpu_ibfk_1` FOREIGN KEY (`id_hardware`) REFERENCES `hardware` (`id_hardware`);

--
-- Constraints for table `frecuencia_gpu`
--
ALTER TABLE `frecuencia_gpu`
  ADD CONSTRAINT `frecuencia_gpu_ibfk_1` FOREIGN KEY (`id_hardware`) REFERENCES `hardware` (`id_hardware`);

--
-- Constraints for table `gpu_notebook`
--
ALTER TABLE `gpu_notebook`
  ADD CONSTRAINT `gpu_notebook_ibfk_1` FOREIGN KEY (`id_notebook`) REFERENCES `notebook` (`id_notebook`);

--
-- Constraints for table `hardware`
--
ALTER TABLE `hardware`
  ADD CONSTRAINT `hardware_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`);

--
-- Constraints for table `historial_compras`
--
ALTER TABLE `historial_compras`
  ADD CONSTRAINT `historial_compras_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `users` (`id`);

--
-- Constraints for table `iluminacion`
--
ALTER TABLE `iluminacion`
  ADD CONSTRAINT `iluminacion_ibfk_1` FOREIGN KEY (`id_periferico`) REFERENCES `periferico` (`id_periferico`);

--
-- Constraints for table `memoria`
--
ALTER TABLE `memoria`
  ADD CONSTRAINT `memoria_ibfk_1` FOREIGN KEY (`id_hardware`) REFERENCES `hardware` (`id_hardware`);

--
-- Constraints for table `notebook`
--
ALTER TABLE `notebook`
  ADD CONSTRAINT `notebook_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`);

--
-- Constraints for table `nucleo_hilo_cpu`
--
ALTER TABLE `nucleo_hilo_cpu`
  ADD CONSTRAINT `nucleo_hilo_cpu_ibfk_1` FOREIGN KEY (`id_hardware`) REFERENCES `hardware` (`id_hardware`);

--
-- Constraints for table `pantalla_notebook`
--
ALTER TABLE `pantalla_notebook`
  ADD CONSTRAINT `pantalla_notebook_ibfk_1` FOREIGN KEY (`id_notebook`) REFERENCES `notebook` (`id_notebook`);

--
-- Constraints for table `resena_valoracion`
--
ALTER TABLE `resena_valoracion`
  ADD CONSTRAINT `id_producto` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`),
  ADD CONSTRAINT `id_usuario` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
