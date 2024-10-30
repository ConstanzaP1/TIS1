<?php
session_start();

// Inicializar el cotizador si no existe
if (!isset($_SESSION['cotizador'])) {
    $_SESSION['cotizador'] = [];
}

// Eliminar un producto del cotizador
if (isset($_POST['eliminar_producto'])) {
    $id_producto = $_POST['id_producto'];
    unset($_SESSION['cotizador'][$id_producto]); // Eliminar producto
}

// Mostrar el cotizador
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cotizador</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container py-5">
    <h2>Cotizador</h2>

    <?php if (empty($_SESSION['cotizador'])): ?>
        <p>No hay productos en el cotizador.</p>
    <?php else: ?>
        <table class="table">
            <thead>
                <tr>
                    <th>Imagen</th>
                    <th>Producto</th>
                    <th>Precio</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                foreach ($_SESSION['cotizador'] as $id_producto): 
                    // Obtener información del producto desde la base de datos
                    require('../conexion.php');
                    $query = "SELECT nombre_producto, imagen_url, precio FROM producto WHERE id_producto = '$id_producto'";
                    $result = mysqli_query($conexion, $query);
                    $producto = mysqli_fetch_assoc($result);
                ?>
                    <tr>
                        <td><img src="<?php echo htmlspecialchars($producto['imagen_url']); ?>" alt="<?php echo htmlspecialchars($producto['nombre_producto']); ?>" class="img-fluid" style="width: 50px;"></td>
                        <td><?php echo htmlspecialchars($producto['nombre_producto']); ?></td>
                        <td><?php echo "$" . number_format($producto['precio'], 0, ',', '.'); ?></td>
                        <td>
                            <form method="POST" action="cotizador.php">
                                <input type="hidden" name="id_producto" value="<?php echo $id_producto; ?>">
                                <button type="submit" name="eliminar_producto" class="btn btn-danger">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <a href="../index.php" class="btn btn-secondary">Volver a la Tienda</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
