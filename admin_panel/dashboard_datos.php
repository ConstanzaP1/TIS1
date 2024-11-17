<?php
require_once '../conexion.php'; // Conexión a la base de datos

/**
 * Función genérica para ejecutar consultas con manejo de errores
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
 * 1. Obtener ganancias de productos
 */
function obtenerGananciasProductos($conexion) {
    $sql = "SELECT nombre_producto, costo, precio, (precio - costo) AS ganancia 
            FROM producto 
            WHERE cantidad > 0 AND costo > 0 AND precio > 0";
    return ejecutarConsulta($conexion, $sql);
}

/**
 * 2. Ventas diarias
 */
function obtenerVentasDiarias($conexion) {
    $sql = "SELECT DATE(fecha_compra) AS dia, SUM(total) AS total_ventas 
            FROM ventas 
            GROUP BY DATE(fecha_compra) 
            ORDER BY dia DESC";
    return ejecutarConsulta($conexion, $sql);
}

/**
 * 3. Monto promedio por carrito
 */
function obtenerPromedioCarrito($conexion) {
    $sql = "SELECT AVG(total) AS promedio_carrito FROM ventas";
    $result = ejecutarConsulta($conexion, $sql);
    return $result[0]['promedio_carrito'] ?? 0;
}

/**
 * 4. Productos más vendidos
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
 * 5. Productos más añadidos al carrito
 */
function obtenerProductosMasAñadidos($conexion) {
    $sql = "SELECT p.nombre_producto, COUNT(ac.id_producto) AS veces_agregado 
            FROM agregar_carrito ac 
            JOIN producto p ON ac.id_producto = p.id_producto 
            GROUP BY p.nombre_producto 
            ORDER BY veces_agregado DESC 
            LIMIT 5";
    return ejecutarConsulta($conexion, $sql);
}

/**
 * 6. Clientes registrados y nuevos
 */
function obtenerClientesRegistrados($conexion) {
    $sqlTotal = "SELECT COUNT(*) AS total_clientes FROM users";
    $sqlNuevos = "SELECT COUNT(*) AS nuevos_clientes FROM users 
                  WHERE fecha_registro >= DATE_SUB(NOW(), INTERVAL 30 DAY)";
    
    $totalClientes = ejecutarConsulta($conexion, $sqlTotal);
    $nuevosClientes = ejecutarConsulta($conexion, $sqlNuevos);

    return [
        'total' => $totalClientes[0]['total_clientes'] ?? 0,
        'nuevos' => $nuevosClientes[0]['nuevos_clientes'] ?? 0
    ];
}

/**
 * 7. Reseñas recientes
 */
function obtenerReseñasRecientes($conexion) {
    $sql = "SELECT r.comentario, r.valoracion, p.nombre_producto 
            FROM resena_valoracion r 
            JOIN producto p ON r.id_producto = p.id_producto 
            ORDER BY r.fecha DESC 
            LIMIT 5";
    return ejecutarConsulta($conexion, $sql);
}

/**
 * 8. Productos con problemas de stock
 */
function obtenerProblemasStock($conexion) {
    $sql = "SELECT nombre_producto, cantidad 
            FROM producto 
            WHERE cantidad = 0";
    return ejecutarConsulta($conexion, $sql);
}

// Captura el parámetro 'metric' de la solicitud
$metric = $_GET['metric'] ?? null;

// Procesa la métrica solicitada
switch ($metric) {
    case 'ganancias_productos':
        echo json_encode(obtenerGananciasProductos($conexion));
        break;
    case 'ventas_diarias':
        echo json_encode(obtenerVentasDiarias($conexion));
        break;
    case 'productos_mas_vendidos':
        echo json_encode(obtenerProductosMasVendidos($conexion));
        break;
    case 'problemas_stock':
        echo json_encode(obtenerProblemasStock($conexion));
        break;
    default:
        echo json_encode(['error' => 'Métrica no válida']);
        break;
}

?>
