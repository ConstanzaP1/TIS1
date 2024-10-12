-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 07, 2024 at 07:57 PM
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
-- Database: `prueba2`
--

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

-- --------------------------------------------------------

--
-- Table structure for table `capacidad_almacenamiento`
--

CREATE TABLE `capacidad_almacenamiento` (
  `id_hardware` int(11) NOT NULL,
  `capacidad_almacenamiento` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
-- Table structure for table `frecuencia_cpu`
--

CREATE TABLE `frecuencia_cpu` (
  `id_hardware` int(11) NOT NULL,
  `frecuencia_cpu` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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

-- --------------------------------------------------------

--
-- Table structure for table `notebook`
--

CREATE TABLE `notebook` (
  `id_notebook` int(11) NOT NULL,
  `id_producto` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `nucleo_hilo_cpu`
--

CREATE TABLE `nucleo_hilo_cpu` (
  `id_hardware` int(11) NOT NULL,
  `nucleo_hilo_cpu` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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

-- --------------------------------------------------------

--
-- Table structure for table `periferico`
--

CREATE TABLE `periferico` (
  `id_periferico` int(11) NOT NULL,
  `id_producto` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `perifericos`
--

CREATE TABLE `perifericos` (
  `id` int(11) NOT NULL,
  `tipo_periferico` varchar(255) DEFAULT NULL,
  `valor` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `imagen` varchar(255) DEFAULT NULL,
  `id_marca` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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

-- --------------------------------------------------------

--
-- Table structure for table `sensor_mouse`
--

CREATE TABLE `sensor_mouse` (
  `id_periferico` int(11) NOT NULL,
  `sensor_mouse` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `slot_memoria_placa`
--

CREATE TABLE `slot_memoria_placa` (
  `id_hardware` int(11) NOT NULL,
  `slot_memoria_placa` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
-- Table structure for table `tamanio_monitor`
--

CREATE TABLE `tamanio_monitor` (
  `id_periferico` int(11) NOT NULL,
  `tamanio_monitor` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tamanio_placa`
--

CREATE TABLE `tamanio_placa` (
  `id_hardware` int(11) NOT NULL,
  `tamanio_max_placa` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tiempo_respuesta`
--

CREATE TABLE `tiempo_respuesta` (
  `id_periferico` int(11) NOT NULL,
  `tiempo_respuesta` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tipo_audifono`
--

CREATE TABLE `tipo_audifono` (
  `id_periferico` int(11) NOT NULL,
  `tipo_audifono` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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

-- --------------------------------------------------------

--
-- Table structure for table `tipo_microfono`
--

CREATE TABLE `tipo_microfono` (
  `id_periferico` int(11) NOT NULL,
  `tipo_microfono` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tipo_panel`
--

CREATE TABLE `tipo_panel` (
  `id_periferico` int(11) NOT NULL,
  `tipo_panel` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tipo_ram`
--

CREATE TABLE `tipo_ram` (
  `id_hardware` int(11) NOT NULL,
  `tipo_ram` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tipo_teclado`
--

CREATE TABLE `tipo_teclado` (
  `id_periferico` int(11) NOT NULL,
  `tipo_teclado` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
-- Indexes for table `perifericos`
--
ALTER TABLE `perifericos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pertenece`
--
ALTER TABLE `pertenece`
  ADD PRIMARY KEY (`nombre_lista`,`id_producto`),
  ADD KEY `id_producto` (`id_producto`);

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
-- Indexes for table `tamanio_fuente`
--
ALTER TABLE `tamanio_fuente`
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
-- Indexes for table `tipo_teclado`
--
ALTER TABLE `tipo_teclado`
  ADD PRIMARY KEY (`id_periferico`);

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
  MODIFY `id_hardware` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `historial_compra`
--
ALTER TABLE `historial_compra`
  MODIFY `id_historal` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `marca`
--
ALTER TABLE `marca`
  MODIFY `id_marca` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notebook`
--
ALTER TABLE `notebook`
  MODIFY `id_notebook` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `orden_compra`
--
ALTER TABLE `orden_compra`
  MODIFY `id_orden` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `periferico`
--
ALTER TABLE `periferico`
  MODIFY `id_periferico` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `perifericos`
--
ALTER TABLE `perifericos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `producto`
--
ALTER TABLE `producto`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `resena_valoracion`
--
ALTER TABLE `resena_valoracion`
  MODIFY `id_resena` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

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
-- Constraints for table `potencia_fuente`
--
ALTER TABLE `potencia_fuente`
  ADD CONSTRAINT `potencia_fuente_ibfk_1` FOREIGN KEY (`id_hardware`) REFERENCES `hardware` (`id_hardware`);

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
-- Constraints for table `tamanio_fuente`
--
ALTER TABLE `tamanio_fuente`
  ADD CONSTRAINT `tamanio_fuente_ibfk_1` FOREIGN KEY (`id_hardware`) REFERENCES `hardware` (`id_hardware`);

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
