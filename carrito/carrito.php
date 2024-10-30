<?php
session_start();
require('../vendor/autoload.php');
use Transbank\Webpay\WebpayPlus\Transaction;

// Configurar Transbank para el entorno de integración
Transbank\Webpay\WebpayPlus::configureForTesting();

// Inicializar el carrito si no existe
if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
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
    $cantidad = $_POST['cantidad'];
    if ($cantidad < 1) {
        unset($_SESSION['carrito'][$id_producto]); // Eliminar producto si la cantidad es menor a 1
    } else {
        $_SESSION['carrito'][$id_producto] = $cantidad; // Actualizar cantidad
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
            'http://localhost/xampp/TIS1/TIS1/index.php', // URL de éxito
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
            echo "<div class='alert alert-success text-center' role='alert'>";
            echo "<h1 class='alert-heading'>¡Pago Exitoso!</h1>";
            echo "<p>Tu pago ha sido aprobado. Código de autorización: <strong>" . $response->getAuthorizationCode() . "</strong></p>";
            echo "<hr>";
            echo "<p class='mb-0'>Gracias por tu compra. Puedes volver al <a href='../index.php' class='alert-link'>catálogo</a>.</p>";
            echo "</div>";
            unset($_SESSION['carrito']); // Vaciar el carrito
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
                require('../conexion.php'); // Asegúrate de incluir tu archivo de conexión aquí
                foreach ($_SESSION['carrito'] as $id_producto => $cantidad):
                    $id_producto = mysqli_real_escape_string($conexion, $id_producto); // Sanitizar ID del producto
                    $query = "SELECT nombre_producto, imagen_url, precio FROM producto WHERE id_producto = '$id_producto'";
                    $result = mysqli_query($conexion, $query);
                    $producto = mysqli_fetch_assoc($result);
                    if ($producto) {
                        $precio_total = $producto['precio'] * $cantidad; // Calcular precio total por producto
                        $total += $precio_total; // Sumar al total
                ?>
                    <tr>
                        <td><img src="<?php echo htmlspecialchars($producto['imagen_url']); ?>" alt="<?php echo htmlspecialchars($producto['nombre_producto']); ?>"></td>
                        <td><?php echo htmlspecialchars($producto['nombre_producto']); ?></td>
                        <td>
                            <form method="POST" action="carrito.php" class="form-inline">
                                <input type="hidden" name="id_producto" value="<?php echo $id_producto; ?>">
                                <input type="number" name="cantidad" value="<?php echo $cantidad; ?>" min="1" class="form-control w-25 mb-3" onchange="this.form.submit()">
                                <button type="submit" name="editar_carrito" class="btn btn-actualizar d-none">Actualizar</button>
                            </form>
                        </td>
                        <td><?php echo "$" . number_format($precio_total, 0, ',', '.'); ?></td>
                        <td>
                            <form method="POST" action="carrito.php">
                                <input type="hidden" name="id_producto" value="<?php echo $id_producto; ?>">
                                <button type="submit" name="eliminar_producto" class="btn btn-danger">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                <?php 
                    } // Cerrar la verificación de producto
                endforeach; 
                ?>
            </tbody>
        </table>
        <h4>Total: <?php echo "$" . number_format($total, 0, ',', '.'); ?></h4>
        <form method="POST" action="carrito.php" class="mt-3">
            <input type="hidden" name="total" value="<?php echo $total; ?>"> <!-- Pasar total -->
            <button type="submit" name="pagar" class="btn btn-primary">Proceder al Pago</button>
        </form>
    <?php endif; ?>
    <a href="../index.php" class="btn btn-secondary mt-3">Volver a la Tienda</a>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
