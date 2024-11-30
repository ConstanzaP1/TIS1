<?php
require('../conexion.php'); // Conexión a la base de datos

// Lógica para agregar una nueva categoría
if (isset($_POST['agregar_categoria'])) {
    $nombre_categoria = $_POST['nombre_categoria'];

    // Insertar la categoría en la base de datos
    $query_categoria = "INSERT INTO categorias (nombre_categoria) VALUES (?)";
    $stmt_categoria = $conexion->prepare($query_categoria);
    $stmt_categoria->bind_param('s', $nombre_categoria);
    $stmt_categoria->execute();
    $mensaje_categoria = "Categoría agregada exitosamente!";
}

// Lógica para agregar una subcategoría
if (isset($_POST['agregar_subcategoria'])) {
    $id_categoria = $_POST['id_categoria'];
    $nombre_subcategoria = $_POST['nombre_subcategoria'];

    // Insertar la subcategoría en la base de datos
    $query_subcategoria = "UPDATE categorias SET subcategoria = ? WHERE id_categoria = ?";
    $stmt_subcategoria = $conexion->prepare($query_subcategoria);
    $stmt_subcategoria->bind_param('si', $nombre_subcategoria, $id_categoria);
    $stmt_subcategoria->execute();
    $mensaje_subcategoria = "Subcategoría agregada exitosamente!";
}

// Obtener todas las categorías para seleccionarlas
$query_categorias = "SELECT * FROM categorias";
$categorias = mysqli_query($conexion, $query_categorias);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Categoría</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4">Crear Categoría y Subcategoría</h2>

    <!-- Mostrar mensajes de éxito -->
    <?php if (isset($mensaje_categoria)) { echo "<div class='alert alert-success'>$mensaje_categoria</div>"; } ?>
    <?php if (isset($mensaje_subcategoria)) { echo "<div class='alert alert-success'>$mensaje_subcategoria</div>"; } ?>

    <!-- Formulario para agregar una nueva categoría -->
    <h3>Agregar Categoría</h3>
    <form method="POST">
        <input type="text" class="form-control" name="nombre_categoria" placeholder="Nombre de la categoría" required>
        <button type="submit" name="agregar_categoria" class="btn btn-primary mt-2">Agregar Categoría</button>
    </form>

    <hr>

    <!-- Formulario para agregar una subcategoría -->
    <h3>Agregar Subcategoría</h3>
    <form method="POST">
        <select class="form-select" name="id_categoria" required>
            <option value="">Seleccionar Categoría</option>
            <?php while ($categoria = mysqli_fetch_assoc($categorias)): ?>
                <option value="<?php echo $categoria['id_categoria']; ?>"><?php echo $categoria['nombre_categoria']; ?></option>
            <?php endwhile; ?>
        </select>
        <input type="text" class="form-control mt-2" name="nombre_subcategoria" placeholder="Nombre de la subcategoría" required>
        <button type="submit" name="agregar_subcategoria" class="btn btn-primary mt-2">Agregar Subcategoría</button>
    </form>

    <hr>

    <button type="button" class="btn btn-secondary mt-1 mb-3" onclick="window.location.href='../admin_panel/admin_panel.php';">Volver al Panel de Administración</button>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php mysqli_close($conexion); // Cerrar la conexión ?>
