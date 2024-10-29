<?php
session_start();

// Inicializar el carrito si no existe
if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

// Agregar productos al carrito
if (isset($_POST['agregar_carrito'])) {
    $id_producto = $_POST['id_producto'];
    $cantidad = $_POST['cantidad'];

    if (isset($_SESSION['carrito'][$id_producto])) {
        $_SESSION['carrito'][$id_producto] += $cantidad; // Aumentar cantidad
    } else {
        $_SESSION['carrito'][$id_producto] = $cantidad; // Agregar nuevo producto
    }
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
        .btn-actualizar {
            background-color: #28a745; /* Verde */
            color: white;
        }
    </style>
</head>
<body>

<div class="container py-5">
    <h2>Carrito de Compras</h2>

    <?php if (empty($_SESSION['carrito'])): ?>
        <p>El carrito está vacío.</p>
    <?php else: ?>
        <table class="table">
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
                foreach ($_SESSION['carrito'] as $id_producto => $cantidad): 
                    // Obtener información del producto desde la base de datos
                    require('../conexion.php');
                    $query = "SELECT nombre_producto, imagen_url, precio FROM producto WHERE id_producto = '$id_producto'";
                    $result = mysqli_query($conexion, $query);
                    $producto = mysqli_fetch_assoc($result);
                    $precio_total = $producto['precio'] * $cantidad; // Calcular precio total por producto
                    $total += $precio_total; // Sumar al total
                ?>
                    <tr>
                        <td><img src="<?php echo htmlspecialchars($producto['imagen_url']); ?>" alt="<?php echo htmlspecialchars($producto['nombre_producto']); ?>" class="img-fluid" style="width: 50px;"></td>
                        <td><?php echo htmlspecialchars($producto['nombre_producto']); ?></td>
                        <td>
                            <form method="POST" action="carrito.php" class="form-inline">
                                <input type="hidden" name="id_producto" value="<?php echo $id_producto; ?>">
                                <input type="number" name="cantidad" value="<?php echo $cantidad; ?>" min="1" class="form-control w-25 mb-3">
                                <button type="submit" name="editar_carrito" class="btn btn-actualizar">Actualizar</button>
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
                <?php endforeach; ?>
            </tbody>
        </table>

        <h4>Total: <?php echo "$" . number_format($total, 0, ',', '.'); ?></h4>
        <a href="pago.php" class="btn btn-primary">Proceder al Pago</a>
    <?php endif; ?>

    <a href="../index.php" class="btn btn-secondary">Volver a la Tienda</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
