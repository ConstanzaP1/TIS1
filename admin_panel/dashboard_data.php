<?php
require_once 'dashboard.php'; // Incluye las funciones definidas.
require_once '../conexion.php'; // Conexión a la base de datos.

// Captura la métrica solicitada desde el parámetro 'metric'.
$metric = $_GET['metric'] ?? null;

// Procesa la métrica solicitada.
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
