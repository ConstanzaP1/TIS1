<?php
    require('../conexion.php'); // Conexión a la base de datos

    // Consulta para obtener todos los productos
    $query_productos = "SELECT * FROM producto";
    $resultado = mysqli_query($conexion, $query_productos);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Modificar Producto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4">Lista de Productos</h2>
    
    <?php if (mysqli_num_rows($resultado) > 0): ?>
        <div class="table-responsive">
            <table class="table table-hover table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>Nombre</th>
                        <th>Marca</th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($producto = mysqli_fetch_assoc($resultado)): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($producto['nombre_producto']); ?></td>
                            <td><?php echo htmlspecialchars($producto['marca']); ?></td>
                            <td><?php echo htmlspecialchars($producto['precio']); ?></td>
                            <td><?php echo htmlspecialchars($producto['cantidad']); ?></td>
                            <td>
                                <a href="modificar_productos.php?id_producto=<?php echo $producto['id_producto']; ?>" class="btn btn-warning btn-sm mx-1">Modificar</a>
                                <a href="../catalogo_productos/eliminar_producto.php?id_producto=<?php echo $producto['id_producto']; ?>" class="btn btn-danger btn-sm mx-1">Eliminar</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <p>No hay productos disponibles.</p>
    <?php endif; ?>

    <button type="button" class="btn btn-secondary mt-4" onclick="window.location.href='../admin_panel/admin_panel.php';">Volver al Panel de Administración</button>
</div>
<?php
    mysqli_close($conexion); // Cerrar conexión
?>
</body>
</html>

