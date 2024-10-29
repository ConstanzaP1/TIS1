-- Crear la base de datos (ajusta el nombre según prefieras)
CREATE DATABASE IF NOT EXISTS comparador;
USE comparador;

-- Crear la tabla de productos
CREATE TABLE IF NOT EXISTS producto (
    id_producto INT AUTO_INCREMENT PRIMARY KEY,
    nombre_producto VARCHAR(255) NOT NULL,
    descripcion TEXT,
    precio DECIMAL(10, 2) NOT NULL,
    categoria VARCHAR(100),
    marca VARCHAR(100),
    imagen_url VARCHAR(255),
    caracteristicas JSON -- Requiere MySQL 5.7 o superior para soporte de JSON
);