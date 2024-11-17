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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- SweetAlert2 -->
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
                        <tr id="producto-<?php echo $producto['id_producto']; ?>">
                            <td><?php echo htmlspecialchars($producto['nombre_producto']); ?></td>
                            <td><?php echo htmlspecialchars($producto['marca']); ?></td>
                            <td><?php echo htmlspecialchars($producto['precio']); ?></td>
                            <td><?php echo htmlspecialchars($producto['cantidad']); ?></td>
                            <td>
                                <a href="modificar_productos.php?id_producto=<?php echo $producto['id_producto']; ?>" class="btn btn-warning btn-sm mx-1">Modificar</a>
                                <button onclick="eliminarProducto(<?php echo $producto['id_producto']; ?>)" class="btn btn-danger btn-sm mx-1">Eliminar</button>
                                <form method="POST" action="../catalogo_productos/actualizar_destacados.php" class="d-inline">
                                    <input type="hidden" name="id_producto" value="<?php echo $producto['id_producto']; ?>">
                                    <?php if ($producto['destacado']): ?>
                                        <!-- Botón para quitar destacado -->
                                        <button type="submit" name="quitar_destacado" class="btn btn-secondary btn-sm mx-1">Quitar Destacado</button>
                                    <?php else: ?>
                                        <!-- Botón para marcar como destacado -->
                                        <button type="submit" name="destacar" class="btn btn-success btn-sm mx-1">Marcar Destacado</button>
                                    <?php endif; ?>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <p>No hay productos disponibles.</p>
    <?php endif; ?>

    <button type="button" class="btn btn-secondary mt-1 mb-3" onclick="window.location.href='../admin_panel/admin_panel.php';">Volver al Panel de Administración</button>
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
