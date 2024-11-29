<?php
require('../conexion.php'); // Conexión a la base de datos

// Obtener todas las categorías
$query_categorias = "SELECT * FROM categorias ORDER BY nombre_categoria";
$result_categorias = mysqli_query($conexion, $query_categorias);

// Manejar la creación de categorías
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['crear_categoria'])) {
    $nombre_categoria = $_POST['nombre_categoria'];

    // Insertar la nueva categoría
    $query_crear = "INSERT INTO categorias (nombre_categoria) VALUES (?)";
    $stmt = $conexion->prepare($query_crear);
    $stmt->bind_param('s', $nombre_categoria);
    $stmt->execute();

    header("Location: categorias.php?created=1");
    exit;
}

// Actualizar el campo `nombre_categoria` en `producto`
function actualizarNombreCategoria($conexion, $id_producto)
{
    $query_actualizar = "
        UPDATE producto
        SET nombre_categoria = (
            SELECT GROUP_CONCAT(c.nombre_categoria SEPARATOR ', ')
            FROM producto_categorias pc
            INNER JOIN categorias c ON pc.id_categoria = c.id_categoria
            WHERE pc.id_producto = producto.id_producto
        )
        WHERE id_producto = ?";
    $stmt = $conexion->prepare($query_actualizar);
    $stmt->bind_param('i', $id_producto);
    $stmt->execute();
}

// Manejar la asignación de categoría a un producto
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['asignar_categoria'])) {
    $id_producto = $_POST['id_producto'];
    $id_categoria = $_POST['id_categoria'];

    // Insertar relación en producto_categorias
    $query_asignar = "INSERT IGNORE INTO producto_categorias (id_producto, id_categoria) VALUES (?, ?)";
    $stmt = $conexion->prepare($query_asignar);
    $stmt->bind_param('ii', $id_producto, $id_categoria);
    $stmt->execute();

    // Actualizar el campo `nombre_categoria`
    actualizarNombreCategoria($conexion, $id_producto);

    header("Location: categorias.php?success=1");
    exit;
}

// Manejar la eliminación de una categoría asignada a un producto
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['eliminar_categoria'])) {
    $id_producto = $_POST['id_producto'];
    $id_categoria = $_POST['id_categoria'];

    // Eliminar relación en producto_categorias
    $query_eliminar = "DELETE FROM producto_categorias WHERE id_producto = ? AND id_categoria = ?";
    $stmt = $conexion->prepare($query_eliminar);
    $stmt->bind_param('ii', $id_producto, $id_categoria);
    $stmt->execute();

    // Actualizar el campo `nombre_categoria`
    actualizarNombreCategoria($conexion, $id_producto);

    header("Location: categorias.php?removed=1");
    exit;
}

// Obtener todos los productos
$query_productos = "SELECT * FROM producto";
$result_productos = mysqli_query($conexion, $query_productos);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Categorías</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container my-4">
        <h1 class="h3">Gestionar Categorías</h1>

        <!-- Mensajes -->
        <?php if (isset($_GET['created'])): ?>
            <div class="alert alert-success">Categoría creada con éxito.</div>
        <?php elseif (isset($_GET['success'])): ?>
            <div class="alert alert-success">Categoría asignada con éxito.</div>
        <?php elseif (isset($_GET['removed'])): ?>
            <div class="alert alert-success">Categoría eliminada con éxito.</div>
        <?php endif; ?>
        <!-- Crear Nueva Categoría -->
        <div class="card mb-4">
            <div class="card-body">
                <h2 class="h5">Crear Nueva Categoría</h2>
                <form method="POST" action="categorias.php">
                    <input type="hidden" name="crear_categoria" value="1">
                    <div class="mb-3">
                        <label for="nombre_categoria" class="form-label">Nombre de la Categoría</label>
                        <input type="text" name="nombre_categoria" id="nombre_categoria" class="form-control" required>
                    </div>
                    <!-- Contenedor para los botones alineados -->
                    <div class="d-flex">
                        <button type="submit" class="btn btn-primary">Crear Categoría</button>
                        <button type="button" class="btn btn-secondary ms-2" onclick="window.location.href='../admin_panel/admin_panel.php'">
                            Ir al Panel Admin
                        </button>
                    </div>
                </form>
            </div>
        </div>



        <!-- Asignar Categorías a Productos -->
        <h2 class="h5 mb-3">Asignar Categorías a Productos</h2>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Categorías</th>
                        <th>Asignar Nueva Categoría</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($producto = mysqli_fetch_assoc($result_productos)): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($producto['nombre_producto']); ?></td>
                            <td>
                                <?php
                                // Obtener las categorías actuales del producto
                                $query_categorias_producto = "SELECT c.id_categoria, c.nombre_categoria FROM categorias c
                            INNER JOIN producto_categorias pc ON c.id_categoria = pc.id_categoria
                            WHERE pc.id_producto = ?";
                                $stmt = $conexion->prepare($query_categorias_producto);
                                $stmt->bind_param('i', $producto['id_producto']);
                                $stmt->execute();
                                $result_categorias_producto = $stmt->get_result();

                                while ($categoria = $result_categorias_producto->fetch_assoc()): ?>
                                    <form method="POST" action="categorias.php" class="d-inline">
                                        <input type="hidden" name="eliminar_categoria" value="1">
                                        <input type="hidden" name="id_producto" value="<?php echo $producto['id_producto']; ?>">
                                        <input type="hidden" name="id_categoria" value="<?php echo $categoria['id_categoria']; ?>">
                                        <span class="badge bg-primary">
                                            <?php echo htmlspecialchars($categoria['nombre_categoria']); ?>
                                            <button type="submit" class="btn btn-sm btn-danger">x</button>
                                        </span>
                                    </form>
                                <?php endwhile; ?>
                            </td>
                            <td>
                                <form method="POST" action="categorias.php">
                                    <input type="hidden" name="asignar_categoria" value="1">
                                    <input type="hidden" name="id_producto" value="<?php echo $producto['id_producto']; ?>">
                                    <select name="id_categoria" class="form-select">
                                        <option value="">Seleccionar Categoría</option>
                                        <?php mysqli_data_seek($result_categorias, 0); ?>
                                        <?php while ($categoria = mysqli_fetch_assoc($result_categorias)): ?>
                                            <option value="<?php echo $categoria['id_categoria']; ?>">
                                                <?php echo htmlspecialchars($categoria['nombre_categoria']); ?>
                                            </option>
                                        <?php endwhile; ?>
                                    </select>
                                    <button type="submit" class="btn btn-primary btn-sm mt-2">Asignar</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>