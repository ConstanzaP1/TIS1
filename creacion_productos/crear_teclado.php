<?php
require('../conexion.php');

// Obtener categorías de teclado
$queryCategoria = "SELECT id_periferico, categoria_teclado FROM categoria_teclado";
$resultCategoria = mysqli_query($conexion, $queryCategoria);

// Obtener tipos de teclado
$queryTipo = "SELECT id_periferico, tipo_teclado FROM tipo_teclado";
$resultTipo = mysqli_query($conexion, $queryTipo);

// Obtener conectividad
$queryConectividad = "SELECT id_periferico, conectividad FROM conectividad";
$resultConectividad = mysqli_query($conexion, $queryConectividad);

// Obtener iluminación
$queryIluminacion = "SELECT id_periferico, iluminacion FROM iluminacion";
$resultIluminacion = mysqli_query($conexion, $queryIluminacion);

// Obtener tipo de switch
$queryTipo_switch = "SELECT id_periferico, tipo_switch FROM tipo_switch";
$resultTipo_switch = mysqli_query($conexion, $queryTipo_switch);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Teclado</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h1 class="mb-4">Ingreso de Teclado</h1>
    <!-- Formulario para insertar teclado -->
    <form action="ingresar_producto.php" method="POST" class="mb-4">
        <!-- Campo oculto para definir la categoría -->
        <input type="hidden" name="categoria_producto" value="teclado">

        <!-- Campos específicos del teclado -->
        <div class="mb-3">
            <label for="nombre_producto" class="form-label">Nombre del Teclado</label>
            <input type="text" name="nombre_producto" class="form-control" id="nombre_producto" required>
        </div>
        
        <div class="mb-3">
            <label for="precio" class="form-label">Precio</label>
            <input type="number" name="precio" class="form-control" id="precio" required>
        </div>

        <div class="mb-3">
            <label for="cantidad" class="form-label">Cantidad</label>
            <input type="number" name="cantidad" class="form-control" id="cantidad" required>
        </div>

        <div class="mb-3">
            <label for="categoria_teclado" class="form-label">Categoría del Teclado</label>
            <select name="categoria_teclado" id="categoria_teclado" class="form-select" required>
                <option value="" selected disabled>Seleccione una categoría</option>
                <?php
                while ($row = $resultCategoria->fetch_assoc()) {
                    echo "<option value='" . $row['id_periferico'] . "'>" . $row['categoria_teclado'] . "</option>";
                }
                ?>
            </select>
        </div>

        <!-- Otros campos adicionales para el teclado, como tipo de teclado, conectividad, etc. -->
        
        <button type="submit" class="btn btn-success mt-3">Guardar</button>
        <button type="button" class="btn btn-secondary mt-3" onclick="window.location.href='index_crear_producto.php';">Volver</button>
    </form>
</div>

</body>
</html>
