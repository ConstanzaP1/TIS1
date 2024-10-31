CREATE TABLE `notificaciones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tipo` enum('compra','stock_bajo','sin_stock') NOT NULL,
  `mensaje` text NOT NULL,
  `producto_id` int(11) NOT NULL,
  `leida` tinyint(1) DEFAULT 0,
  `fecha_creacion` timestamp DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
);