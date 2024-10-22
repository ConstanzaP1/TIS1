<?php
require('../conexion.php');

// Consultas para obtener las opciones de los atributos específicos del teclado
$queryTipoTeclado = "SELECT id_periferico, tipo_teclado FROM tipo_teclado";
$resultTipoTeclado = mysqli_query($conexion, $queryTipoTeclado);

$queryTipoSwitch = "SELECT id_periferico, tipo_switch FROM tipo_switch";
$resultTipoSwitch = mysqli_query($conexion, $queryTipoSwitch);

$queryConectividad = "SELECT id_periferico, conectividad FROM conectividad";
$resultConectividad = mysqli_query($conexion, $queryConectividad);

$queryIluminacion = "SELECT id_periferico, iluminacion FROM iluminacion";
$resultIluminacion = mysqli_query($conexion, $queryIluminacion);

$queryCategoria = "SELECT id_periferico, categoria_teclado FROM categoria_teclado";
$resultCategoria = mysqli_query($conexion, $queryCategoria);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Teclado</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1 class="mb-4">Ingreso de Teclado</h1>
    <form action="procesar_producto.php" method="POST">
        <input type="hidden" name="categoria_producto" value="teclado">

        <div class="mb-3">
            <label for="nombre_producto" class="form-label">Nombre del Producto</label>
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
            <label for="tipo_teclado" class="form-label">Tipo de Teclado</label>
            <select name="tipo_teclado" class="form-select" required>
                <option value="" selected disabled>Seleccione un tipo</option>
                <?php while ($row = mysqli_fetch_assoc($resultTipoTeclado)): ?>
                    <option value="<?= $row['id_periferico'] ?>"><?= $row['tipo_teclado'] ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="tipo_switch" class="form-label">Tipo de Switch</label>
            <select name="tipo_switch" class="form-select" required>
                <option value="" selected disabled>Seleccione un switch</option>
                <?php while ($row = mysqli_fetch_assoc($resultTipoSwitch)): ?>
                    <option value="<?= $row['id_periferico'] ?>"><?= $row['tipo_switch'] ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="categoria_teclado" class="form-label">Categoria</label>
            <select name="categoria_teclado" class="form-select" required>
                <option value="" selected disabled>Seleccione la categoria</option>
                <?php while ($row = mysqli_fetch_assoc($resultCategoria)): ?>
                    <option value="<?= $row['id_periferico'] ?>"><?= $row['categoria_teclado'] ?></option>
                <?php endwhile; ?>
            </select>
        </div>


        <div class="mb-3">
            <label for="conectividad" class="form-label">Conectividad</label>
            <select name="conectividad" class="form-select" required>
                <option value="" selected disabled>Seleccione la conectividad</option>
                <?php while ($row = mysqli_fetch_assoc($resultConectividad)): ?>
                    <option value="<?= $row['id_periferico'] ?>"><?= $row['conectividad'] ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="iluminacion" class="form-label">Iluminación</label>
            <select name="iluminacion" class="form-select" required>
                <option value="" selected disabled>Seleccione la iluminación</option>
                <?php while ($row = mysqli_fetch_assoc($resultIluminacion)): ?>
                    <option value="<?= $row['id_periferico'] ?>"><?= $row['iluminacion'] ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Guardar</button>
    </form>
</div>
</body>
</html>
