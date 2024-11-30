<?php
require('../conexion.php'); // Conexión a la base de datos

// Obtener todos los productos
$query_productos = "SELECT p.id_producto, p.nombre_producto, p.nombre_categoria, p.subcategoria, p.id_categoria
                    FROM producto p";
$resultado_productos = mysqli_query($conexion, $query_productos);

// Obtener todas las categorías
$query_categorias = "SELECT * FROM categorias";
$categorias = mysqli_query($conexion, $query_categorias);

// Lógica para asignar una categoría y subcategoría a un producto
if (isset($_POST['asignar_categoria'])) {
    $id_producto = $_POST['id_producto'];
    $id_categoria = $_POST['id_categoria'];
    $id_subcategoria = $_POST['subcategoria'];

    // Obtener el nombre de la categoría
    $query_categoria = "SELECT nombre_categoria FROM categorias WHERE id_categoria = ?";
    $stmt_categoria = $conexion->prepare($query_categoria);
    $stmt_categoria->bind_param('i', $id_categoria);
    $stmt_categoria->execute();
    $resultado_categoria = $stmt_categoria->get_result();
    $categoria = $resultado_categoria->fetch_assoc();
    $nombre_categoria = $categoria['nombre_categoria'];

    // Obtener el nombre de la subcategoría directamente desde la tabla categorias
    $query_subcategoria = "SELECT subcategoria FROM categorias WHERE id_categoria = ?";
    $stmt_subcategoria = $conexion->prepare($query_subcategoria);
    $stmt_subcategoria->bind_param('i', $id_categoria); // Usamos el id_categoria para obtener la subcategoria
    $stmt_subcategoria->execute();
    $resultado_subcategoria = $stmt_subcategoria->get_result();
    $subcategoria = $resultado_subcategoria->fetch_assoc();
    $nombre_subcategoria = $subcategoria['subcategoria'];

    // Actualizar la categoría y subcategoría del producto
    $query_asignar = "UPDATE producto 
                      SET id_categoria = ?, nombre_categoria = ?, subcategoria = ? 
                      WHERE id_producto = ?";
    $stmt_asignar = $conexion->prepare($query_asignar);
    $stmt_asignar->bind_param('isss', $id_categoria, $nombre_categoria, $nombre_subcategoria, $id_producto);
    $stmt_asignar->execute();
    $mensaje_asignar = "Categoría y Subcategoría asignadas correctamente!";
}

// Lógica para quitar la categoría y subcategoría de un producto
if (isset($_POST['quitar_categoria'])) {
    $id_producto = $_POST['id_producto'];

    // Quitar la categoría y subcategoría del producto
    $query_quitar = "UPDATE producto SET id_categoria = NULL, nombre_categoria = NULL, subcategoria = NULL WHERE id_producto = ?";
    $stmt_quitar = $conexion->prepare($query_quitar);
    $stmt_quitar->bind_param('i', $id_producto);
    $stmt_quitar->execute();
    $mensaje_quitar = "Categoría y Subcategoría quitadas correctamente!";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Categorías</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4">Gestionar Categorías y Subcategorías de Productos</h2>

    <!-- Mostrar mensajes de éxito -->
    <?php if (isset($mensaje_asignar)) { echo "<div class='alert alert-success'>$mensaje_asignar</div>"; } ?>
    <?php if (isset($mensaje_quitar)) { echo "<div class='alert alert-success'>$mensaje_quitar</div>"; } ?>

    <!-- Formulario para asignar categoría y subcategoría a un producto -->
    <h3>Asignar Categoría/Subcategoría a Producto</h3>
    <form method="POST">
    <div class="mb-3">
        <select class="form-select" name="id_producto" required>
            <option value="">Seleccionar Producto</option>
            <?php while ($producto = mysqli_fetch_assoc($resultado_productos)): ?>
                <option value="<?php echo $producto['id_producto']; ?>"><?php echo $producto['nombre_producto']; ?></option>
            <?php endwhile; ?>
        </select>
    </div>
    <div class="mb-3">
        <select class="form-select" name="id_categoria" id="categoria" required>
            <option value="">Seleccionar Categoría</option>
            <?php while ($categoria = mysqli_fetch_assoc($categorias)): ?>
                <option value="<?php echo $categoria['id_categoria']; ?>"><?php echo $categoria['nombre_categoria']; ?></option>
            <?php endwhile; ?>
        </select>
    </div>
    <div class="mb-3">
        <select class="form-select" name="subcategoria" id="subcategoria" required>
            <option value="">Seleccionar Subcategoría</option>
            <!-- Las subcategorías se cargarán dinámicamente con JavaScript -->
        </select>
    </div>
    <button type="submit" name="asignar_categoria" class="btn btn-primary mt-2">Asignar Categoría/Subcategoría</button>
</form>

    <hr>

    <button type="button" class="btn btn-secondary mt-1 mb-3" onclick="window.location.href='../admin_panel/admin_panel.php';">Volver al Panel de Administración</button>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Cargar subcategorías dinámicamente cuando se seleccione una categoría
    document.getElementById('categoria').addEventListener('change', function() {
    const categoriaId = this.value;
    const subcategoriaSelect = document.getElementById('subcategoria');

    // Limpiar las subcategorías previas
    subcategoriaSelect.innerHTML = '<option value="">Seleccionar Subcategoría</option>';

    if (categoriaId) {
        // Hacer una solicitud para obtener las subcategorías de la categoría seleccionada
        fetch('obtener_subcategorias.php?id_categoria=' + categoriaId)
            .then(response => response.json())
            .then(data => {
                // Verificar que la respuesta tenga subcategorías
                if (data.subcategorias && data.subcategorias.length > 0) {
                    data.subcategorias.forEach(subcategoria => {
                        const option = document.createElement('option');
                        option.value = subcategoria.id_categoria; // Usar el id_categoria para el valor
                        option.textContent = subcategoria.subcategoria || 'No hay subcategoría'; // Mostrar la subcategoría
                        subcategoriaSelect.appendChild(option);
                    });
                } else {
                    // Si no hay subcategorías, mostrar un mensaje
                    const option = document.createElement('option');
                    option.value = '';
                    option.textContent = 'No hay subcategorías disponibles';
                    subcategoriaSelect.appendChild(option);
                }
            })
            .catch(error => {
                console.error('Error al cargar subcategorías:', error);
            });
    }
});

</script>

</body>
</html>

<?php mysqli_close($conexion); // Cerrar la conexión ?>
