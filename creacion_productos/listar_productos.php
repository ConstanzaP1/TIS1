<?php
require('../conexion.php'); // Conexión a la base de datos

// Consulta SQL para obtener todos los productos con las categorías y subcategorías
$query_productos = "
    SELECT p.id_producto, p.nombre_producto, p.precio, p.costo, p.cantidad, 
           m.nombre_marca, p.destacado
    FROM producto p
    INNER JOIN marca m ON p.marca = m.id_marca
";
$resultado = mysqli_query($conexion, $query_productos);

// Verificar si la consulta fue exitosa
if (!$resultado) {
    die("Error en la consulta: " . mysqli_error($conexion));
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Modificar Producto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- SweetAlert2 -->
</head>
<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container-fluid">
            <a class="navbar-brand" href="../admin_panel/admin_panel.php">
                <img src="../logoblanco.png" alt="Logo" style="width: auto; height: auto;" class="d-inline-block align-text-top">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="../admin_panel/admin_panel.php">Volver al Panel</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
<body>
<div class="container mt-5">
    <h2 class="d-flex justify-content-between align-items-center mb-4">
        <span>Modificar productos</span>
    </h2>
    <!-- Comprobamos si hay productos en la consulta -->
    <?php if (mysqli_num_rows($resultado) > 0): ?>
        <div class="table-responsive">
            <table class="table table-hover table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>Nombre</th>
                        <th>Marca</th>
                        <th>Costo</th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($producto = mysqli_fetch_assoc($resultado)): ?>
                        <tr id="producto-<?php echo $producto['id_producto']; ?>">
                            <td><?php echo htmlspecialchars($producto['nombre_producto']); ?></td>
                            <td><?php echo htmlspecialchars($producto['nombre_marca']); ?></td> <!-- Mostrar nombre de la marca -->
                            <td><?php echo '$' . number_format(htmlspecialchars($producto['costo']), 0, ',', '.'); ?></td>
                            <td><?php echo '$' . number_format(htmlspecialchars($producto['precio']), 0, ',', '.'); ?></td>
                            <td><?php echo htmlspecialchars($producto['cantidad']); ?></td>
                            <td>
                                <a href="modificar_productos.php?id_producto=<?php echo $producto['id_producto']; ?>" class="btn btn-primary btn-sm mx-1">Modificar</a>
                                <form method="POST" action="../catalogo_productos/actualizar_destacados.php" class="d-inline">
                                    <input type="hidden" name="id_producto" value="<?php echo $producto['id_producto']; ?>">
                                    <?php if ($producto['destacado']): ?>
                                        <button type="submit" name="quitar_destacado" class="btn btn-secondary btn-sm mx-1">Quitar destacado</button>
                                    <?php else: ?>
                                        <button type="submit" name="destacar" class="btn btn-success btn-sm mx-1">Marcar destacado</button>
                                    <?php endif; ?>
                                </form>
                                <button onclick="eliminarProducto(<?php echo $producto['id_producto']; ?>)" class="btn btn-danger btn-sm mx-1">Eliminar</button>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <p>No hay productos disponibles.</p>
    <?php endif; ?>

</div>

<script>
// Función para eliminar un producto mediante AJAX
function eliminarProducto(id_producto) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "Esta acción eliminará el producto.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '../catalogo_productos/eliminar_producto.php',
                type: 'POST',
                data: { id_producto: id_producto },
                success: function(response) {
                    if (response.status === 'success') {
                        Swal.fire(
                            '¡Eliminado!',
                            response.message,
                            'success'
                        ).then(() => {
                            // Elimina la fila de la tabla del producto eliminado sin recargar la página
                            $('#producto-' + id_producto).remove();
                        });
                    } else {
                        Swal.fire(
                            'Error',
                            response.message,
                            'error'
                        );
                    }
                },
                error: function(xhr, status, error) {
                    Swal.fire(
                        'Error',
                        'Ocurrió un error al intentar eliminar el producto.',
                        'error'
                    );
                }
            });
        }
    });
}
</script>

<?php mysqli_close($conexion); // Cerrar conexión ?>
</body>
</html>
