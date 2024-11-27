<?php
session_start();
require('../conexion.php'); // Conexión a la base de datos

// Validar que se han recibido los datos necesarios
if (!isset($_POST['id_producto'], $_POST['cantidad'])) {
    mostrarAlerta("Datos incompletos", "No se han recibido los datos necesarios para la compra.", "error");
    exit;
}

$id_producto = $_POST['id_producto'];
$cantidad = (int)$_POST['cantidad'];

// Consulta para verificar el stock disponible
$query = "SELECT cantidad, precio FROM producto WHERE id_producto = ?";
$stmt = mysqli_prepare($conexion, $query);
mysqli_stmt_bind_param($stmt, 's', $id_producto);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($result && mysqli_num_rows($result) > 0) {
    $producto = mysqli_fetch_assoc($result);
    $stock_disponible = (int)$producto['cantidad'];
    $precio_unitario = (float)$producto['precio'];

    // Validar stock disponible
    if ($cantidad > $stock_disponible) {
        mostrarAlerta(
            "Stock insuficiente",
            "La cantidad solicitada excede el stock disponible.",
            "error",
            true
        );
        exit;
    }

    // Agregar producto al carrito
    if (!isset($_SESSION['carrito'][$id_producto])) {
        $_SESSION['carrito'][$id_producto] = 0;
    }
    $_SESSION['carrito'][$id_producto] += $cantidad;

    // Recalcular el total
    recalcularTotal($conexion);

    // Redirigir al carrito
    header("Location: carrito.php");
    exit;
} else {
    mostrarAlerta("Producto no encontrado", "No se encontró el producto en la base de datos.", "error");
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
            mysqli_stmt_bind_param($stmt, 's', $id_producto);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $producto = mysqli_fetch_assoc($result);
            if ($producto) {
                $total += $producto['precio'] * $cantidad;
            }
        }
        $_SESSION['total'] = $total;
    } else {
        $_SESSION['total'] = 0;
    }
}

// Función para mostrar una alerta con SweetAlert2
function mostrarAlerta($titulo, $mensaje, $tipo, $volverAtras = false)
{
    echo "
    <!DOCTYPE html>
    <html lang='es'>
    <head>
        <meta charset='UTF-8'>
        <title>{$titulo}</title>
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    </head>
    <body>
        <script>
            Swal.fire({
                icon: '{$tipo}',
                title: '{$titulo}',
                text: '{$mensaje}',
                confirmButtonText: 'Aceptar'
            }).then((result) => {
                " . ($volverAtras ? "window.history.back();" : "window.location.href='carrito.php';") . "
            });
        </script>
    </body>
    </html>";
}

mysqli_close($conexion);
?>
