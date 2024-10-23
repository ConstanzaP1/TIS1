<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seleccionar Categoría de Producto</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h1 class="mb-4">Seleccionar Categoría de Producto</h1>
    <!-- Formulario para seleccionar categoría -->
    <form action="redireccionar_categoria.php" method="POST">
        <div class="mb-3">
            <label for="categoria_producto" class="form-label">Categoría de Producto</label>
            <select name="categoria_producto" id="categoria_producto" class="form-select" required>
                <option value="" selected disabled>Seleccione una categoría</option>
                <option value="teclado">Teclado</option>
                <option value="monitor">Monitor</option>
                <option value="audifono">Audifono</option>
                <option value="mouse">Mouse</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Continuar</button>
        <button type="button" class="btn btn-secondary" onclick="window.location.href='../admin_panel/admin_panel.php';">Volver</button>
    </form>
</div>

</body>
</html>
