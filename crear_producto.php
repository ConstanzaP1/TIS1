<?php
require('conexion.php');

// Obtener categorías de teclado
$queryCategoria = "SELECT id_periferico, categoria_teclado FROM categoria_teclado";
$resultCategoria = mysqli_query($conexion, $queryCategoria);

// Obtener tipos de teclado
$queryTipo = "SELECT id_periferico, tipo_teclado FROM tipo_teclado";
$resultTipo = mysqli_query($conexion, $queryTipo);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ingreso de productos</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h1 class="mb-4">Ingreso de productos</h1>
    <!-- Formulario para insertar periférico -->
    <form action="ingresar_producto.php" method="POST" class="mb-4">
        <!-- Menú desplegable para seleccionar el tipo de producto -->
        <div class="mb-3">
            <label for="tipo_producto" class="form-label">Categorías de productos</label>
            <select name="tipo_producto" id="tipo_producto" class="form-select" required onchange="mostrarCamposProducto()">
                <option value="" selected disabled>Seleccione una categoría de producto</option>
                <option value="teclado">Teclado</option>
            </select>
        </div>

        <!-- Campos adicionales para teclado (Ocultos inicialmente) -->
        <div class="mb-3" id="camposTeclado" style="display: none;">
            <!-- Categoría de teclado -->
            <label for="id_producto" class="form-label mt-3">Id producto</label>
            <input type="text" name="id_producto" class="form-control" id="id_producto">

            <label for="nombre_producto" class="form-label mt-3">Nombre producto</label>
            <input type="text" name="nombre_producto" class="form-control" id="nombre_producto">

            <label for="precio" class="form-label mt-3">Precio</label>
            <input type="text" name="precio" class="form-control" id="precio">

            <label for="cantidad" class="form-label mt-3">Cantidad</label>
            <input type="text" name="cantidad" class="form-control" id="cantidad">

            <label for="imagen" class="form-label mt-3">Imagen</label>
            <input type="text" name="imagen" class="form-control" id="imagen">

            <label for="categoria_teclado" class="form-label mt-3">Categoria teclado</label>
            <select name="categoria_teclado" id="categoria_teclado" class="form-select">
                <option value="" selected disabled>Seleccione una categoría</option>
                <?php
                while ($row = $resultCategoria->fetch_assoc()) {
                    echo "<option value='" . $row['id_periferico'] . "'>" . $row['categoria_teclado'] . "</option>";
                }
                ?>
            </select>
            <label for="tipo_teclado" class="form-label mt-3">Tipo teclado</label>
            <select name="tipo_teclado" id="tipo_teclado" class="form-select">
                <option value="" selected disabled>Seleccione una categoría</option>
                <?php
                while ($row = $resultTipo->fetch_assoc()) {
                    echo "<option value='" . $row['id_periferico'] . "'>" . $row['tipo_teclado'] . "</option>";
                }
                ?>
            </select>
        </div>
        <button type="submit" class="btn btn-success mt-3">Guardar</button>
        <button class="btn btn-secondary mt-3" onclick="window.location.href='index.php';">Volver a Inicio</button>
    </form>
</div>

<!-- JavaScript para mostrar los campos adicionales dinámicamente -->
<script>
    function mostrarCamposProducto() {
        var tipoProducto = document.getElementById("tipo_producto").value;
        document.getElementById("camposTeclado").style.display = "none";

        // Ocultar todos los campos adicionales inicialmente
        camposTeclado.style.display = "none";

        // Mostrar campos adicionales si el tipo de producto es "teclado"
        if (tipoProducto === "teclado") {
            camposTeclado.style.display = "block";
        }
    }
</script>

</body>
</html>