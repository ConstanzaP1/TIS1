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
                <option value="cpu">Procesador</option>
                <option value="gpu">Tarjeta de video</option>
                <option value="ssd">SSD</option>
                <option value="hdd">HDD</option>
                <option value="ram">RAM</option>
                <option value="placa">Placa Madre</option>
                <option value="fuente">Fuente de poder</option>
                <option value="gabinete">Gabinete</option>
                <option value="notebook">Notebook</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Continuar</button>
        <button type="button" class="btn btn-secondary" onclick="window.location.href='../admin_panel/admin_panel.php';">Volver</button>
    </form>
</div>

</body>
</html>
