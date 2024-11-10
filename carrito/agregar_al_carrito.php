<?php
session_start();
require('../conexion.php'); // Conexión a la base de datos

// Verificar que se han recibido los datos necesarios
if (isset($_POST['id_producto']) && isset($_POST['cantidad'])) {
    $id_producto = $_POST['id_producto'];
    $cantidad = (int)$_POST['cantidad'];

    // Consulta para verificar el stock disponible
    $query = "SELECT cantidad FROM producto WHERE id_producto = '$id_producto'";
    $result = mysqli_query($conexion, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $producto = mysqli_fetch_assoc($result);
        $stock_disponible = (int)$producto['cantidad'];

        // Verificar si la cantidad solicitada supera el stock disponible
        if ($cantidad > $stock_disponible) {
            // Enviar un HTML completo con la alerta de SweetAlert2
            echo "
            <!DOCTYPE html>
            <html lang='es'>
            <head>
                <meta charset='UTF-8'>
                <title>Stock insuficiente</title>
                <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
            </head>
            <body>
                <script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Stock insuficiente',
                        text: 'La cantidad solicitada excede el stock disponible.',
                        confirmButtonText: 'Aceptar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.history.back();
                        }
                    });
                </script>
            </body>
            </html>";
            exit;
        } else {
            // Agregar producto al carrito en la sesión
            if (!isset($_SESSION['carrito'][$id_producto])) {
                $_SESSION['carrito'][$id_producto] = 0;
            }
            $_SESSION['carrito'][$id_producto] += $cantidad;

            // Llamar a la función recalcularTotal() para actualizar el total en la sesión
            recalcularTotal($conexion);

            // Redirigir al carrito después de agregar el producto
            header("Location: carrito.php");
            exit;
        }
    } else {
        echo "
        <!DOCTYPE html>
        <html lang='es'>
        <head>
            <meta charset='UTF-8'>
            <title>Producto no encontrado</title>
            <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        </head>
        <body>
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Producto no encontrado',
                    text: 'No se encontró el producto en la base de datos.',
                    confirmButtonText: 'Aceptar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.history.back();
                    }
                });
            </script>
        </body>
        </html>";
        exit;
    }
} else {
    echo "
    <!DOCTYPE html>
    <html lang='es'>
    <head>
        <meta charset='UTF-8'>
        <title>Datos incompletos</title>
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    </head>
    <body>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Datos incompletos',
                text: 'No se han recibido los datos necesarios para la compra.',
                confirmButtonText: 'Aceptar'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.history.back();
                }
            });
        </script>
    </body>
    </html>";
    exit;
}

// Función para recalcular el total del carrito y guardarlo en la sesión
function recalcularTotal($conexion) {
    if (!empty($_SESSION['carrito'])) {
        $total = 0;
        foreach ($_SESSION['carrito'] as $id_producto => $cantidad) {
            $id_producto = mysqli_real_escape_string($conexion, $id_producto);
            $query = "SELECT precio FROM producto WHERE id_producto = '$id_producto'";
            $result = mysqli_query($conexion, $query);
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

mysqli_close($conexion);
?>
