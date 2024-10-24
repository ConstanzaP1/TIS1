<?php
require('../conexion.php');

// Consultas para obtener las opciones de los atributos específicos del RAM
$queryTipoRam = "SELECT id_hardware, tipo_ram FROM tipo_ram";
$resultTipoRam = mysqli_query($conexion, $queryTipoRam);

$queryVelocidadRam = "SELECT id_hardware, velocidad_ram FROM velocidad_ram";
$resultVelocidadRam = mysqli_query($conexion, $queryVelocidadRam);

$queryCapacidadRam = "SELECT id_hardware, capacidad_ram FROM capacidad_ram";
$resultCapacidadRam = mysqli_query($conexion, $queryCapacidadRam);

$queryFormatoRam = "SELECT id_hardware, formato_ram FROM formato_ram";
$resultFormatoRam = mysqli_query($conexion, $queryFormatoRam);

$queryMarca = "SELECT id_marca, nombre_marca FROM marca";
$resultMarca = mysqli_query($conexion, $queryMarca);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear RAM</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1 class="mb-4">Ingreso de RAM</h1>
    <form action="procesar_producto.php" method="POST">
        <input type="hidden" name="categoria_producto" value="ram">

        <div class="mb-3">
            <label for="nombre_producto" class="form-label">Nombre del Producto</label>
            <input type="text" name="nombre_producto" class="form-control" id="nombre_producto" required>
        </div>

        <div class="mb-3">
            <label for="nombre_marca" class="form-label">Marca</label>
            <select name="nombre_marca" class="form-select" required>
                <option value="" selected disabled>Seleccione una marca</option>
                <?php while ($row = mysqli_fetch_assoc($resultMarca)): ?>
                    <option value="<?= $row['id_marca'] ?>"><?= $row['nombre_marca'] ?></option>
                <?php endwhile; ?>
            </select>
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
            <label for="tipo_ram" class="form-label">Tipo RAM</label>
            <select name="tipo_ram" class="form-select" required>
                <option value="" selected disabled>Seleccione un tipo</option>
                <?php while ($row = mysqli_fetch_assoc($resultTipoRam)): ?>
                    <option value="<?= $row['id_hardware'] ?>"><?= $row['tipo_ram'] ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="velocidad_ram" class="form-label">Velocidad RAM</label>
            <select name="velocidad_ram" class="form-select" required>
                <option value="" selected disabled>Seleccione una velocidad</option>
                <?php while ($row = mysqli_fetch_assoc($resultVelocidadRam)): ?>
                    <option value="<?= $row['id_hardware'] ?>"><?= $row['velocidad_ram'] ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="capacidad_ram" class="form-label">Capacidad RAM</label>
            <select name="capacidad_ram" class="form-select" required>
                <option value="" selected disabled>Seleccione una capacidad </option>
                <?php while ($row = mysqli_fetch_assoc($resultCapacidadRam)): ?>
                    <option value="<?= $row['id_hardware'] ?>"><?= $row['capacidad_ram'] ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="formato_ram" class="form-label">Formato RAM</label>
            <select name="formato_ram" class="form-select" required>
                <option value="" selected disabled>Seleccione un formato </option>
                <?php while ($row = mysqli_fetch_assoc($resultFormatoRam)): ?>
                    <option value="<?= $row['id_hardware'] ?>"><?= $row['formato_ram'] ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Guardar</button>
        <button type="button" class="btn btn-secondary" onclick="window.location.href='index_crear_producto.php';">Volver</button>
    </form>
</div>
</body>
</html>
