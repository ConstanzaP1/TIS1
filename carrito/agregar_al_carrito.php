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
$query = "SELECT cantidad, precio, imagen_url, nombre_producto FROM producto WHERE id_producto = ?";
$stmt = mysqli_prepare($conexion, $query);

if (!$stmt) {
    mostrarAlerta("Error", "Error en la consulta a la base de datos.", "error");
    exit;
}

mysqli_stmt_bind_param($stmt, 's', $id_producto);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($result && mysqli_num_rows($result) > 0) {
    $producto = mysqli_fetch_assoc($result);
    $stock_disponible = (int)$producto['cantidad'];
    $precio_unitario = $producto['precio'];
    $imagen_url = $producto['imagen_url'];
    $nombre_producto = $producto['nombre_producto'];

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

    // Mostrar ventana emergente
    echo "
    <!DOCTYPE html>
    <html lang='es'>
    <head>
        <meta charset='UTF-8'>
        <title>Producto agregado</title>
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    </head>
    <body>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Producto agregado al carrito',
                html: `
                    <div style='display: flex; align-items: center; gap: 15px; text-align: left; font-family: Arial, sans-serif;'>
                        <img src='{$imagen_url}' alt='Producto' style='width: 100px; height: 100px; object-fit: contain; border: 1px solid #ddd; border-radius: 5px;'>
                        <div style='flex-grow: 1;'>
                            <p style='margin: 0; font-size: 16px; font-weight: bold;'>{$nombre_producto}</p>
                            <p style='margin: 5px 0; font-size: 14px; color: #555;'>Cantidad: {$cantidad}</p>
                        </div>
                    </div>
                `,
                showCancelButton: true,
                confirmButtonText: 'Ir al carrito',
                cancelButtonText: 'Seguir comprando'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'carrito.php';
                } else {
                    window.history.back(); // Regresar a la página anterior
                }
            });
        </script>
    </body>
    </html>";
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
        <style>
            /* Estilo para difuminar el fondo */
            .blurred-background {
                filter: blur(5px);
                transition: filter 0.3s ease;
            }
        </style>
    </head>
    <body>
        <script>
            Swal.fire({
                icon: '{$tipo}',
                title: '{$titulo}',
                text: '{$mensaje}',
                confirmButtonText: 'Aceptar',
                customClass: {
                    popup: 'my-swal-popup'
                },
                didOpen: () => {
                    // Aplicar difuminado al fondo
                    document.body.classList.add('blurred-background');
                },
                willClose: () => {
                    // Eliminar el difuminado cuando se cierre el popup
                    document.body.classList.remove('blurred-background');
                }
            }).then((result) => {
                " . ($volverAtras ? "window.history.back();" : "window.location.href='carrito.php';") . "
            });
        </script>
    </body>
    </html>";
}

mysqli_close($conexion);
?>
