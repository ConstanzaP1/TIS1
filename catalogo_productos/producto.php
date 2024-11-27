<?php
require('../conexion.php'); // Conexión a la base de datos

// Obtener la categoría seleccionada
$categoria = $_GET['categoria'] ?? null;

if ($categoria) {
    // Consultar productos de la categoría seleccionada
    $query = "
        SELECT p.nombre_producto, p.precio, p.imagen_url 
        FROM producto p
        INNER JOIN producto_categorias pc ON p.id_producto = pc.id_producto
        INNER JOIN categorias c ON pc.id_categoria = c.id_categoria
        WHERE c.nombre_categoria = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param('s', $categoria);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    // Redirigir si no hay categoría seleccionada
    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos - <?php echo htmlspecialchars($categoria); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container my-4">
    <h1 class="h3">Productos en la Categoría "<?php echo htmlspecialchars($categoria); ?>"</h1>

    <div class="row">
        <?php while ($producto = $result->fetch_assoc()): ?>
            <div class="col-md-4">
                <div class="card mb-4">
                    <img src="<?php echo htmlspecialchars($producto['imagen_url']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($producto['nombre_producto']); ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($producto['nombre_producto']); ?></h5>
                        <p class="card-text">Precio: $<?php echo htmlspecialchars($producto['precio']); ?></p>
                        <a href="detalle_producto.php?id=<?php echo $producto['id_producto']; ?>" class="btn btn-primary">Ver Detalles</a>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
