<?php
session_start();
require('../conexion.php'); // Conexión a la base de datos

// Validar que se han recibido los datos necesarios
if (!isset($_POST['id_producto'], $_POST['cantidad'])) {
    $id_producto = $_POST['id_producto'] ?? 0;
    header("Location: ../catalogo_productos/detalle_producto.php?id_producto=$id_producto&status=error&message=Datos+incompletos");
    exit;
}

$id_producto = $_POST['id_producto'];
$cantidad = (int)$_POST['cantidad'];

// Consulta para verificar el stock disponible
$query = "SELECT cantidad, precio, imagen_url, nombre_producto FROM producto WHERE id_producto = ?";
$stmt = mysqli_prepare($conexion, $query);

if (!$stmt) {
    header("Location: ../catalogo_productos/detalle_producto.php?id_producto=$id_producto&status=error&message=Error+en+la+consulta+de+base+de+datos");
    exit;
}

mysqli_stmt_bind_param($stmt, 's', $id_producto);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($result && mysqli_num_rows($result) > 0) {
    $producto = mysqli_fetch_assoc($result);
    $stock_disponible = (int)$producto['cantidad'];

    // Validar stock disponible
    if ($cantidad > $stock_disponible) {
        header("Location: ../catalogo_productos/detalle_producto.php?id_producto=$id_producto&status=error&message=Stock+insuficiente");
        exit;
    }

    // Agregar producto al carrito
    if (!isset($_SESSION['carrito'][$id_producto])) {
        $_SESSION['carrito'][$id_producto] = 0;
    }
    $_SESSION['carrito'][$id_producto] += $cantidad;

    // Recalcular el total
    recalcularTotal($conexion);

    // Redirigir con mensaje de éxito
    header("Location: ../catalogo_productos/detalle_producto.php?id_producto=$id_producto&status=success&message=Producto+agregado+con+éxito");
    exit;
} else {
    header("Location: ../catalogo_productos/detalle_producto.php?id_producto=$id_producto&status=error&message=Producto+no+encontrado");
    exit;
}

// Función para recalcular el total del carrito
function recalcularTotal($conexion)
{
    if (!empty($_SESSION['carrito'])) {
        $total = 0;
        foreach ($_SESSION['carrito'] as $id_producto => $cantidad) {
            $query = "SELECT precio FROM producto WHERE id_producto = ?";
            $stmt = mysqli_prepare($conexion, $query);
            if ($stmt) {
                mysqli_stmt_bind_param($stmt, 's', $id_producto);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                $producto = mysqli_fetch_assoc($result);
                if ($producto) {
                    $total += $producto['precio'] * $cantidad;
                }
            }
        }
        $_SESSION['total'] = $total;
    } else {
        $_SESSION['total'] = 0;
    }
}

mysqli_close($conexion);
?>
