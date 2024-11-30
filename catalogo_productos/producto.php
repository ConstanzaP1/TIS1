<?php
require('../conexion.php'); // Conexión a la base de datos

// Obtener todas las categorías con sus subcategorías
$query_categorias = "SELECT * FROM categorias";
$categorias = mysqli_query($conexion, $query_categorias);

// Lógica para guardar o modificar el producto
if (isset($_POST['guardar_producto'])) {
    $nombre_producto = $_POST['nombre_producto'];
    $precio = $_POST['precio'];
    $id_categoria = $_POST['id_categoria']; // Obtener el id_categoria del formulario
    $imagen_url = $_POST['imagen_url'];

    // Guardar el producto en la base de datos
    $query = "INSERT INTO producto (nombre_producto, precio, id_categoria, imagen_url) VALUES (?, ?, ?, ?)";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param('sdss', $nombre_producto, $precio, $id_categoria, $imagen_url);
    $stmt->execute();

    $mensaje = "Producto guardado exitosamente!";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Producto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4">Agregar Nuevo Producto</h2>

    <!-- Mostrar mensaje de éxito -->
    <?php if (isset($mensaje)) { echo "<div class='alert alert-success'>$mensaje</div>"; } ?>

    <!-- Formulario para agregar un producto -->
    <form method="POST">
        <div class="mb-3">
            <label for="nombre_producto" class="form-label">Nombre del Producto</label>
            <input type="text" class="form-control" name="nombre_producto" id="nombre_producto" required>
        </div>

        <div class="mb-3">
            <label for="precio" class="form-label">Precio</label>
            <input type="number" class="form-control" name="precio" id="precio" step="0.01" required>
        </div>

        <div class="mb-3">
            <label for="id_categoria" class="form-label">Categoría/Subcategoría</label>
            <select class="form-select" name="id_categoria" required>
                <option value="">Seleccionar Categoría/Subcategoría</option>
                <?php while ($categoria = mysqli_fetch_assoc($categorias)): ?>
                    <option value="<?php echo $categoria['id_categoria']; ?>">
                        <?php echo $categoria['nombre_categoria']; ?> / <?php echo $categoria['subcategoria']; ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="imagen_url" class="form-label">URL de la Imagen</label>
            <input type="text" class="form-control" name="imagen_url" id="imagen_url" required>
        </div>

        <button type="submit" name="guardar_producto" class="btn btn-primary">Guardar Producto</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
