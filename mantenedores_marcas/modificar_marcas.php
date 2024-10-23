<?php
require('../conexion.php');

// Obtener el ID de la marca a modificar
$id_marca = $_GET['id_marca'];

// Consultar la base de datos para obtener los datos actuales de la marca
$query = "SELECT * FROM marca WHERE id_marca = '$id_marca'";
$result = mysqli_query($conexion, $query);
$row = mysqli_fetch_assoc($result);

// Mostrar un formulario con los datos actuales para que el usuario pueda modificarlos
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Marca</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h1 class="mb-4">Modificar Marca</h1>

    <!-- Formulario para modificar marca -->
    <form action="actualizar_marcas.php" method="POST" class="mb-4">
        <!-- Campo oculto para el ID de la marca -->
        <input type="hidden" name="id_marca" value="<?php echo $id_marca; ?>">

        <!-- Campo para modificar el nombre de la marca -->
        <div class="mb-3">
            <label for="nombre_marca" class="form-label">Nombre de la Marca</label>
            <input type="text" name="nombre_marca" class="form-control" id="nombre_marca" value="<?php echo $row['nombre_marca']; ?>" required>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Guardar cambios</button>
    </form>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
