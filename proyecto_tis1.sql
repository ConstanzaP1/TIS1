-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 23, 2024 at 06:58 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

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
(178, 'Si');

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
(22, 'asdaasdasd');

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
(40, '1gb'),
(41, '2gb');

-- --------------------------------------------------------

--
-- Table structure for table `capacidad_ram`
--

CREATE TABLE `capacidad_ram` (
  `id_hardware` int(11) NOT NULL,
  `capacidad_ram` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(173, '100%'),
(174, '80%'),
(175, '60%');

-- --------------------------------------------------------

--
-- Table structure for table `certificacion_fuente`
--

CREATE TABLE `certificacion_fuente` (
  `id_hardware` int(11) NOT NULL,
  `certificacion_fuente` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(77, '16000DPI');

-- --------------------------------------------------------

--
-- Table structure for table `formato_placa`
--

CREATE TABLE `formato_placa` (
  `id_hardware` int(11) NOT NULL,
  `formato_placa` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `formato_ram`
--

CREATE TABLE `formato_ram` (
  `id_hardware` int(11) NOT NULL,
  `formato_ram` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(24, '1000');

-- --------------------------------------------------------

--
-- Table structure for table `frecuencia_gpu`
--

CREATE TABLE `frecuencia_gpu` (
  `id_hardware` int(11) NOT NULL,
  `frecuencia_gpu` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gpu_notebook`
--

CREATE TABLE `gpu_notebook` (
  `id_notebook` int(11) NOT NULL,
  `gpu_notebook` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
-- Table structure for table `historial_compra`
--

CREATE TABLE `historial_compra` (
  `id_historal` int(11) NOT NULL,
  `estado` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(155, 'RGB');

-- --------------------------------------------------------

--
-- Table structure for table `lista_deseo`
--

CREATE TABLE `lista_deseo` (
  `nombre_lista` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(1, 'Asus');

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
(53, 'dasdassadas');

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
(21, NULL),
(22, NULL);

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
(47, '4 Nucleos / 4 Hilos');

-- --------------------------------------------------------

--
-- Table structure for table `orden_compra`
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
(21, '14\"');

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
(154, NULL),
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
(178, NULL);

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
(161, '120g');

-- --------------------------------------------------------

--
-- Table structure for table `potencia_fuente`
--

CREATE TABLE `potencia_fuente` (
  `id_hardware` int(11) NOT NULL,
  `potencia_fuente` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `marca` varchar(55) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `producto`
--

INSERT INTO `producto` (`id_producto`, `nombre_producto`, `precio`, `cantidad`, `tipo_producto`, `marca`) VALUES
(19, 'Audifono1', 123.00, 123, 'audifono', '1'),
(20, 'Mouse1', 123.00, 123, 'mouse', '1');

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
(76, 19, 'tipo_audifono', '176'),
(77, 19, 'tipo_microfono', '177'),
(78, 19, 'anc', '178'),
(79, 19, 'conectividad', '76'),
(80, 19, 'iluminacion', '155'),
(81, 20, 'dpi_mouse', '77'),
(82, 20, 'peso_mouse', '161'),
(83, 20, 'sensor_mouse', '75');

-- --------------------------------------------------------

--
-- Table structure for table `resena_valoracion`
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
(81, 'Full HD (1920x1080)');

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
(75, 'Optico');

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
(34, '4');

-- --------------------------------------------------------

--
-- Table structure for table `socket_cpu`
--

CREATE TABLE `socket_cpu` (
  `id_hardware` int(11) NOT NULL,
  `socket_cpu` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(32, 'atx');

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
(170, 'G-Sync / FreeSync');

-- --------------------------------------------------------

--
-- Table structure for table `tamanio_fuente`
--

CREATE TABLE `tamanio_fuente` (
  `id_hardware` int(11) NOT NULL,
  `tamanio_fuente` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tamanio_max_gabinete`
--

CREATE TABLE `tamanio_max_gabinete` (
  `id_hardware` int(11) NOT NULL,
  `tamanio_max_gabinete` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(78, '24.0\"');

-- --------------------------------------------------------

--
-- Table structure for table `tamanio_placa`
--

CREATE TABLE `tamanio_placa` (
  `id_hardware` int(11) NOT NULL,
  `tamanio_placa` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(168, '60hz');

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
(80, '5 ms');

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
(176, 'Over-Ear / Headset');

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
(79, 'Si');

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
(177, 'Montado (invisible)');

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
(82, 'LED');

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
(44, 'ddr5');

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
(86, 'Membrana'),
(154, 'brazo de 35');

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
(46, 'admin', 'admin@admin.cl', '$2y$10$hnEq7BCps9MjNagRZbMkoO64Y9u7SDComOz8hPrNiRbQA3tAnjiKu', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `usuario`
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
-- Table structure for table `velocidad_ram`
--

CREATE TABLE `velocidad_ram` (
  `id_hardware` int(11) NOT NULL,
  `velocidad_ram` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
-- Indexes for table `historial_compra`
--
ALTER TABLE `historial_compra`
  ADD PRIMARY KEY (`id_historal`);

--
-- Indexes for table `iluminacion`
--
ALTER TABLE `iluminacion`
  ADD PRIMARY KEY (`id_periferico`);

--
-- Indexes for table `lista_deseo`
--
ALTER TABLE `lista_deseo`
  ADD PRIMARY KEY (`nombre_lista`);

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
  ADD PRIMARY KEY (`id_orden`),
  ADD KEY `correo` (`correo`);

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
  ADD KEY `correo` (`correo`);

--
-- Indexes for table `resolucion_monitor`
--
ALTER TABLE `resolucion_monitor`
  ADD PRIMARY KEY (`id_periferico`);

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
-- Indexes for table `tamanio_placa`
--
ALTER TABLE `tamanio_placa`
  ADD PRIMARY KEY (`id_hardware`);

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
-- Indexes for table `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`correo`);

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
-- AUTO_INCREMENT for table `hardware`
--
ALTER TABLE `hardware`
  MODIFY `id_hardware` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `historial_compra`
--
ALTER TABLE `historial_compra`
  MODIFY `id_historal` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `marca`
--
ALTER TABLE `marca`
  MODIFY `id_marca` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `notebook`
--
ALTER TABLE `notebook`
  MODIFY `id_notebook` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `orden_compra`
--
ALTER TABLE `orden_compra`
  MODIFY `id_orden` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `periferico`
--
ALTER TABLE `periferico`
  MODIFY `id_periferico` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=179;

--
-- AUTO_INCREMENT for table `producto`
--
ALTER TABLE `producto`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `producto_caracteristica`
--
ALTER TABLE `producto_caracteristica`
  MODIFY `id_caracteristica` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT for table `resena_valoracion`
--
ALTER TABLE `resena_valoracion`
  MODIFY `id_resena` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

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
-- Constraints for table `orden_compra`
--
ALTER TABLE `orden_compra`
  ADD CONSTRAINT `orden_compra_ibfk_1` FOREIGN KEY (`correo`) REFERENCES `usuario` (`correo`);

--
-- Constraints for table `pantalla_notebook`
--
ALTER TABLE `pantalla_notebook`
  ADD CONSTRAINT `pantalla_notebook_ibfk_1` FOREIGN KEY (`id_notebook`) REFERENCES `notebook` (`id_notebook`);

--
-- Constraints for table `periferico`
--
ALTER TABLE `periferico`
  ADD CONSTRAINT `periferico_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`);

--
-- Constraints for table `pertenece`
--
ALTER TABLE `pertenece`
  ADD CONSTRAINT `pertenece_ibfk_1` FOREIGN KEY (`nombre_lista`) REFERENCES `lista_deseo` (`nombre_lista`) ON DELETE CASCADE,
  ADD CONSTRAINT `pertenece_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`) ON DELETE CASCADE;

--
-- Constraints for table `peso_mouse`
--
ALTER TABLE `peso_mouse`
  ADD CONSTRAINT `peso_mouse_ibfk_1` FOREIGN KEY (`id_periferico`) REFERENCES `periferico` (`id_periferico`);

--
-- Constraints for table `potencia_fuente`
--
ALTER TABLE `potencia_fuente`
  ADD CONSTRAINT `potencia_fuente_ibfk_1` FOREIGN KEY (`id_hardware`) REFERENCES `hardware` (`id_hardware`);

--
-- Constraints for table `producto_caracteristica`
--
ALTER TABLE `producto_caracteristica`
  ADD CONSTRAINT `producto_caracteristica_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`) ON DELETE CASCADE;

--
-- Constraints for table `resena_valoracion`
--
ALTER TABLE `resena_valoracion`
  ADD CONSTRAINT `resena_valoracion_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`),
  ADD CONSTRAINT `resena_valoracion_ibfk_2` FOREIGN KEY (`correo`) REFERENCES `usuario` (`correo`);

--
-- Constraints for table `resolucion_monitor`
--
ALTER TABLE `resolucion_monitor`
  ADD CONSTRAINT `resolucion_monitor_ibfk_1` FOREIGN KEY (`id_periferico`) REFERENCES `periferico` (`id_periferico`);

--
-- Constraints for table `sensor_mouse`
--
ALTER TABLE `sensor_mouse`
  ADD CONSTRAINT `sensor_mouse_ibfk_1` FOREIGN KEY (`id_periferico`) REFERENCES `periferico` (`id_periferico`);

--
-- Constraints for table `slot_memoria_placa`
--
ALTER TABLE `slot_memoria_placa`
  ADD CONSTRAINT `slot_memoria_placa_ibfk_1` FOREIGN KEY (`id_hardware`) REFERENCES `hardware` (`id_hardware`);

--
-- Constraints for table `socket_cpu`
--
ALTER TABLE `socket_cpu`
  ADD CONSTRAINT `socket_cpu_ibfk_1` FOREIGN KEY (`id_hardware`) REFERENCES `hardware` (`id_hardware`);

--
-- Constraints for table `socket_placa`
--
ALTER TABLE `socket_placa`
  ADD CONSTRAINT `socket_placa_ibfk_1` FOREIGN KEY (`id_hardware`) REFERENCES `hardware` (`id_hardware`);

--
-- Constraints for table `soporte_monitor`
--
ALTER TABLE `soporte_monitor`
  ADD CONSTRAINT `soporte_monitor_ibfk_1` FOREIGN KEY (`id_periferico`) REFERENCES `periferico` (`id_periferico`);

--
-- Constraints for table `tamanio_fuente`
--
ALTER TABLE `tamanio_fuente`
  ADD CONSTRAINT `tamanio_fuente_ibfk_1` FOREIGN KEY (`id_hardware`) REFERENCES `hardware` (`id_hardware`);

--
-- Constraints for table `tamanio_max_gabinete`
--
ALTER TABLE `tamanio_max_gabinete`
  ADD CONSTRAINT `tamanio_max_gabinete_ibfk_1` FOREIGN KEY (`id_hardware`) REFERENCES `hardware` (`id_hardware`);

--
-- Constraints for table `tamanio_monitor`
--
ALTER TABLE `tamanio_monitor`
  ADD CONSTRAINT `tamanio_monitor_ibfk_1` FOREIGN KEY (`id_periferico`) REFERENCES `periferico` (`id_periferico`);

--
-- Constraints for table `tamanio_placa`
--
ALTER TABLE `tamanio_placa`
  ADD CONSTRAINT `tamanio_placa_ibfk_1` FOREIGN KEY (`id_hardware`) REFERENCES `hardware` (`id_hardware`);

--
-- Constraints for table `tasa_refresco`
--
ALTER TABLE `tasa_refresco`
  ADD CONSTRAINT `tasa_refresco_ibfk_1` FOREIGN KEY (`id_periferico`) REFERENCES `periferico` (`id_periferico`);

--
-- Constraints for table `tiempo_respuesta`
--
ALTER TABLE `tiempo_respuesta`
  ADD CONSTRAINT `tiempo_respuesta_ibfk_1` FOREIGN KEY (`id_periferico`) REFERENCES `periferico` (`id_periferico`);

--
-- Constraints for table `tipo_audifono`
--
ALTER TABLE `tipo_audifono`
  ADD CONSTRAINT `tipo_audifono_ibfk_1` FOREIGN KEY (`id_periferico`) REFERENCES `periferico` (`id_periferico`);

--
-- Constraints for table `tipo_cableado`
--
ALTER TABLE `tipo_cableado`
  ADD CONSTRAINT `tipo_cableado_ibfk_1` FOREIGN KEY (`id_hardware`) REFERENCES `hardware` (`id_hardware`);

--
-- Constraints for table `tipo_curvatura`
--
ALTER TABLE `tipo_curvatura`
  ADD CONSTRAINT `tipo_curvatura_ibfk_1` FOREIGN KEY (`id_periferico`) REFERENCES `periferico` (`id_periferico`);

--
-- Constraints for table `tipo_microfono`
--
ALTER TABLE `tipo_microfono`
  ADD CONSTRAINT `tipo_microfono_ibfk_1` FOREIGN KEY (`id_periferico`) REFERENCES `periferico` (`id_periferico`);

--
-- Constraints for table `tipo_panel`
--
ALTER TABLE `tipo_panel`
  ADD CONSTRAINT `tipo_panel_ibfk_1` FOREIGN KEY (`id_periferico`) REFERENCES `periferico` (`id_periferico`);

--
-- Constraints for table `tipo_ram`
--
ALTER TABLE `tipo_ram`
  ADD CONSTRAINT `tipo_ram_ibfk_1` FOREIGN KEY (`id_hardware`) REFERENCES `hardware` (`id_hardware`);

--
-- Constraints for table `tipo_switch`
--
ALTER TABLE `tipo_switch`
  ADD CONSTRAINT `tipo_switch_ibfk_1` FOREIGN KEY (`id_periferico`) REFERENCES `periferico` (`id_periferico`);

--
-- Constraints for table `tipo_teclado`
--
ALTER TABLE `tipo_teclado`
  ADD CONSTRAINT `tipo_teclado_ibfk_1` FOREIGN KEY (`id_periferico`) REFERENCES `periferico` (`id_periferico`);

--
-- Constraints for table `velocidad_ram`
--
ALTER TABLE `velocidad_ram`
  ADD CONSTRAINT `velocidad_ram_ibfk_1` FOREIGN KEY (`id_hardware`) REFERENCES `hardware` (`id_hardware`);

--
-- Constraints for table `voltaje_ram`
--
ALTER TABLE `voltaje_ram`
  ADD CONSTRAINT `voltaje_ram_ibfk_1` FOREIGN KEY (`id_hardware`) REFERENCES `hardware` (`id_hardware`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
