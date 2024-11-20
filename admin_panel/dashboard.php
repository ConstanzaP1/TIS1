<?php
require_once '../conexion.php'; // Conexión a la base de datos

/**
 * Función genérica para ejecutar consultas con manejo de errores.
 */
function ejecutarConsulta($conexion, $sql) {
    $result = mysqli_query($conexion, $sql);
    if (!$result) {
        error_log("Error en la consulta: " . mysqli_error($conexion));
        return ['error' => 'Error en la consulta a la base de datos.'];
    }
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

/**
 * 1. Obtener ganancias de productos.
 */
function obtenerGananciasProductos($conexion) {
    $sql = "SELECT nombre_producto, costo, precio, (precio - costo) AS ganancia 
            FROM producto 
            WHERE cantidad > 0 AND costo > 0 AND precio > 0";
    return ejecutarConsulta($conexion, $sql);
}

/**
 * 2. Ventas diarias.
 */
function obtenerVentasDiarias($conexion) {
    $sql = "SELECT DATE(fecha_compra) AS dia, SUM(total) AS total_ventas 
            FROM ventas 
            GROUP BY DATE(fecha_compra) 
            ORDER BY dia DESC";
    return ejecutarConsulta($conexion, $sql);
}

/**
 * 3. Productos más vendidos.
 */
function obtenerProductosMasVendidos($conexion) {
    $sql = "SELECT p.nombre_producto, SUM(vp.cantidad) AS cantidad_vendida 
            FROM venta_producto vp 
            JOIN producto p ON vp.id_producto = p.id_producto 
            GROUP BY p.nombre_producto 
            ORDER BY cantidad_vendida DESC 
            LIMIT 5";
    return ejecutarConsulta($conexion, $sql);
}

/**
 * 4. Problemas de stock.
 */
function obtenerProblemasStock($conexion) {
    $sql = "SELECT nombre_producto, cantidad 
            FROM producto 
            WHERE cantidad = 0";
    return ejecutarConsulta($conexion, $sql);
}
