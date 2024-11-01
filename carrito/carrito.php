<?php
session_start();
require('../conexion.php'); // Conexión a la base de datos

// Inicializar el carrito si no existe
if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

// Aquí asumo que el ID del usuario está almacenado en la sesión
$id_usuario = $_SESSION['id_usuario'] ?? null;

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
    <a href='../index.php' class='btn btn-secondary'>Volver al Catálogo</a>
    <br>
</div>
</body>
</html>
