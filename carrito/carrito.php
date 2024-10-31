<?php
// Al principio del archivo carrito.php
if (isset($_GET['success'])) {
    echo "<div class='alert alert-success'>¡Pago Exitoso! Gracias por tu compra.</div>";
}
if (isset($_GET['error'])) {
    echo "<div class='alert alert-danger'>Hubo un error en el pago. Por favor, intenta nuevamente.</div>";
}
?>

<?php
session_start();
require('../vendor/autoload.php');
use Transbank\Webpay\WebpayPlus\Transaction;

// Configurar Transbank para el entorno de integración
Transbank\Webpay\WebpayPlus::configureForTesting();
require('../conexion.php'); // Conexión a la base de datos

// Inicializar el carrito si no existe
if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

// Aquí asumo que el ID del usuario está almacenado en la sesión
$id_usuario = $_SESSION['id_usuario'] ?? null;

// Cargar el carrito desde la base de datos al iniciar sesión
if ($id_usuario) {
    $query = "SELECT productos FROM carrito WHERE id_usuario = '$id_usuario' LIMIT 1";
    $result = mysqli_query($conexion, $query);
    if ($row = mysqli_fetch_assoc($result)) {
        $_SESSION['carrito'] = json_decode($row['productos'], true); // Cargar el carrito
    }
}

// Agregar productos al carrito
if (isset($_POST['agregar_carrito'])) {
    $id_producto = $_POST['id_producto'];
    $cantidad = $_POST['cantidad'];
    $_SESSION['carrito'][$id_producto] = ($_SESSION['carrito'][$id_producto] ?? 0) + $cantidad; // Aumentar cantidad
}

// Editar la cantidad en el carrito
if (isset($_POST['editar_carrito'])) {
    $id_producto = $_POST['id_producto'];
    $nueva_cantidad = $_POST['cantidad'];
    
    // Obtener la cantidad antigua
    $cantidad_antigua = $_SESSION['carrito'][$id_producto] ?? 0;

    // Actualizar la cantidad en el carrito
    if ($nueva_cantidad < 1) {
        unset($_SESSION['carrito'][$id_producto]); // Eliminar producto si la cantidad es menor a 1
    } else {
        $_SESSION['carrito'][$id_producto] = $nueva_cantidad; // Actualizar cantidad
    }
}

// Eliminar un producto del carrito
if (isset($_POST['eliminar_producto'])) {
    $id_producto = $_POST['id_producto'];
    unset($_SESSION['carrito'][$id_producto]); // Eliminar producto
}

// Proceder al pago
if (isset($_POST['pagar'])) {
    $total = $_POST['total'];
    $transaction = new Transaction();
    try {
        $response = $transaction->create(
            session_id(), // ID de sesión
            uniqid(), // Orden de compra única
            $total, // Monto total
            'http://localhost/xampp/TIS1/TIS1/carrito/actualizar_productos.php', // URL de éxito
            'http://localhost/xampp/TIS1/TIS1/carrito/carrito.php' // URL de fallo
        );
        header("Location: " . $response->getUrl() . "?token_ws=" . $response->getToken());
        exit;
    } catch (Exception $e) {
        echo "Error al iniciar la transacción: " . $e->getMessage();
    }
}

// Manejo de respuesta de Transbank
if (isset($_GET['token_ws'])) {
    $token = $_GET['token_ws'];
    $transaction = new Transaction();
    try {
        $response = $transaction->commit($token);
        if ($response->isApproved()) {
            // Guardar detalles de la compra en la base de datos
            $productos_comprados = json_encode($_SESSION['carrito']); // Guardar los productos como JSON
            if ($id_usuario) {
                // Guardar en historial de compras
                $estado = 'Aprobado'; // Estado de la compra
                $query = "INSERT INTO historial_compra (id_usuario, productos, total, estado) VALUES ('$id_usuario', '$productos_comprados', '$total', '$estado')";
                if (!mysqli_query($conexion, $query)) {
                    echo "Error al guardar el historial de compras: " . mysqli_error($conexion);
                }

                // Actualizar la cantidad de cada producto en la base de datos
                foreach ($_SESSION['carrito'] as $id_producto => $cantidad) {
                    $id_producto = mysqli_real_escape_string($conexion, $id_producto); // Sanitizar ID del producto
                    
                    // Verificar la cantidad actual antes de actualizar
                    $query = "SELECT cantidad FROM producto WHERE id_producto = '$id_producto'";
                    $result = mysqli_query($conexion, $query);
                    $producto = mysqli_fetch_assoc($result);
                    
                    if ($producto) {
                        $cantidad_disponible = $producto['cantidad'];
                        if ($cantidad <= $cantidad_disponible) {
                            // Actualizar la cantidad en producto
                            $query = "UPDATE producto SET cantidad = cantidad - $cantidad WHERE id_producto = '$id_producto'";
                            if (!mysqli_query($conexion, $query)) {
                                echo "Error al actualizar cantidad del producto: " . mysqli_error($conexion);
                            }
                        } else {
                            echo "No hay suficiente stock para el producto ID: $id_producto.";
                        }
                    } else {
                        echo "Producto no encontrado: ID $id_producto.";
                    }
                }
                
                // Guardar el carrito en la base de datos
                $query = "INSERT INTO carrito (id_usuario, productos) VALUES ('$id_usuario', '$productos_comprados')
                          ON DUPLICATE KEY UPDATE productos = '$productos_comprados'";
                if (!mysqli_query($conexion, $query)) {
                    echo "Error al guardar el carrito: " . mysqli_error($conexion);
                }
            }

            echo "<div class='alert alert-success text-center' role='alert'>";
            echo "<h1 class='alert-heading'>¡Pago Exitoso!</h1>";
            echo "<p>Tu pago ha sido aprobado. Código de autorización: <strong>" . $response->getAuthorizationCode() . "</strong></p>";
            echo "<hr>";
            echo "<p class='mb-0'>Gracias por tu compra. Puedes volver al <a href='../index.php' class='alert-link'>catálogo</a>.</p>";
            echo "</div>";
            
            // Vaciar el carrito
            unset($_SESSION['carrito']); // Esto se asegura de que el carrito se vacíe

        } else {
            echo "<div class='alert alert-danger text-center' role='alert'>";
            echo "<h1 class='alert-heading'>Pago Rechazado</h1>";
            echo "<p>Lamentablemente, tu pago no fue aprobado.</p>";
            echo "<hr>";
            echo "<p class='mb-0'>Por favor, intenta nuevamente o contáctanos si el problema persiste.</p>";
            echo "<a href='carrito.php' class='btn btn-danger mt-3'>Volver al Carrito</a>";
            echo "</div>";
        }
    } catch (Exception $e) {
        echo "Error al confirmar la transacción: " . $e->getMessage();
    }
}

// Mostrar el carrito
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .btn-actualizar {
            background-color: #28a745; /* Verde */
            color: white;
        }
        .table img {
            width: 50px;
            height: auto;
        }
        .table th, .table td {
            vertical-align: middle;
        }
        .alert {
            margin-top: 20px;
        }
        .text-danger {
            margin-top: 5px;
        }
    </style>
</head>
<body>
<div class="container py-5">
    <h2 class="mb-4">Carrito de Compras</h2>
    <?php if (empty($_SESSION['carrito'])): ?>
        <div class="alert alert-warning" role="alert">
            El carrito está vacío.
        </div>
    <?php else: ?>
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Imagen</th>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $total = 0; // Inicializar total
                $hay_stock = true; // Variable para verificar stock
                foreach ($_SESSION['carrito'] as $id_producto => $cantidad):
                    $id_producto = mysqli_real_escape_string($conexion, $id_producto); // Sanitizar ID del producto
                    $query = "SELECT nombre_producto, imagen_url, precio, cantidad FROM producto WHERE id_producto = '$id_producto'";
                    $result = mysqli_query($conexion, $query);
                    $producto = mysqli_fetch_assoc($result);
                    if ($producto) {
                        $precio_total = $producto['precio'] * $cantidad; // Calcular precio total por producto
                        $total += $precio_total; // Sumar al total
                        if ($cantidad > $producto['cantidad']) {
                            $hay_stock = false; // No hay stock suficiente
                        }
                ?>
                    <tr>
                        <td><img src="<?php echo htmlspecialchars($producto['imagen_url']); ?>" alt="<?php echo htmlspecialchars($producto['nombre_producto']); ?>"></td>
                        <td><?php echo htmlspecialchars($producto['nombre_producto']); ?></td>
                        <td>
                            <form method="POST" action="carrito.php" class="form-inline">
                                <input type="hidden" name="id_producto" value="<?php echo $id_producto; ?>">
                                <input type="number" name="cantidad" value="<?php echo $cantidad; ?>" min="1" max="<?php echo $producto['cantidad']; ?>" class="form-control w-25 mb-3">
                                <button type="submit" name="editar_carrito" class="btn btn-actualizar">Actualizar</button>
                            </form>
                            <?php if ($cantidad > $producto['cantidad']): ?>
                                <div class="text-danger">Sin stock suficiente</div>
                            <?php endif; ?>
                        </td>
                        <td><?php echo "$" . number_format($precio_total, 0, ',', '.'); ?></td>
                        <td>
                            <form method="POST" action="carrito.php">
                                <input type="hidden" name="id_producto" value="<?php echo $id_producto; ?>">
                                <button type="submit" name="eliminar_producto" class="btn btn-danger">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                <?php } endforeach; ?>
            </tbody>
        </table>
        <h4>Total: <?php echo "$" . number_format($total, 0, ',', '.'); ?></h4>
        <form method="POST" action="carrito.php">
            <input type="hidden" name="total" value="<?php echo $total; ?>">
            <button type="submit" name="pagar" class="btn btn-primary" <?php echo $hay_stock ? '' : 'disabled'; ?>>Proceder al Pago</button>
        </form>
    <?php endif; ?>

    <hr>
        <div class="row col-6">
            <h2>Enviar Cotizacion</h2>
            <form action="../boleta_cotizacion/cotizacion.php" method="POST">
            <div class="mb-3">
                <label for="correo" class="form-label">Correo Electrónico</label>
                <input type="email" class="form-control" id="correo" name="correo" required>
            </div>
            <button type="submit" class="btn btn-primary">Enviar</button>
        </div>
    
    <!-- Botón Volver al Índice -->
     <br>
    <a href='../index.php' class='btn btn-secondary'>Volver al Catálogo</a></div>

</div>
</body>
</html>
