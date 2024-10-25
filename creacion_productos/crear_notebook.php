<?php
require('../conexion.php');

// Consultas para obtener las opciones de los atributos específicos del teclado
$queryBateria = "SELECT id_notebook, bateria_notebook FROM bateria_notebook";
$resultBateria = mysqli_query($conexion, $queryBateria);

$queryCpu = "SELECT id_notebook, cpu_notebook FROM cpu_notebook";
$resultCpu = mysqli_query($conexion, $queryCpu);

$queryGpu = "SELECT id_notebook, gpu_notebook FROM gpu_notebook";
$resultGpu = mysqli_query($conexion, $queryGpu);

$queryCapacidadRam = "SELECT id_hardware, capacidad_ram FROM capacidad_ram";
$resultCapacidadRam = mysqli_query($conexion, $queryCapacidadRam);

$queryPantalla = "SELECT id_notebook, pantalla_notebook FROM pantalla_notebook";
$resultPantalla = mysqli_query($conexion, $queryPantalla);

$queryMarca = "SELECT id_marca, nombre_marca FROM marca";
$resultMarca = mysqli_query($conexion, $queryMarca);
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
    <h1 class="mb-4">Ingreso de Notebooks</h1>
    <form action="procesar_producto.php" method="POST">
        <input type="hidden" name="categoria_producto" value="notebook">

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
            <label for="imagen_url" class="form-label">URL imagen</label>
            <input type="text" name="imagen_url" class="form-control" id="imagen_url" required>
        </div>
        
        <div class="mb-3">
            <label for="bateria_notebook" class="form-label">Bateria</label>
            <select name="bateria_notebook" class="form-select" required>
                <option value="" selected disabled>Seleccione un tipo</option>
                <?php while ($row = mysqli_fetch_assoc($resultBateria)): ?>
                    <option value="<?= $row['id_notebook'] ?>"><?= $row['bateria_notebook'] ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="cpu_notebook" class="form-label">Procesador</label>
            <select name="cpu_notebook" class="form-select" required>
                <option value="" selected disabled>Seleccione un procesador</option>
                <?php while ($row = mysqli_fetch_assoc($resultCpu)): ?>
                    <option value="<?= $row['id_notebook'] ?>"><?= $row['cpu_notebook'] ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="gpu_notebook" class="form-label">Tarjeta grafica</label>
            <select name="gpu_notebook" class="form-select" required>
                <option value="" selected disabled>Seleccione una tarjeta grafica</option>
                <?php while ($row = mysqli_fetch_assoc($resultGpu)): ?>
                    <option value="<?= $row['id_notebook'] ?>"><?= $row['gpu_notebook'] ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="pantalla_notebook" class="form-label">Pantalla</label>
            <select name="pantalla_notebook" class="form-select" required>
                <option value="" selected disabled>Seleccione una pantalla</option>
                <?php while ($row = mysqli_fetch_assoc($resultPantalla)): ?>
                    <option value="<?= $row['id_notebook'] ?>"><?= $row['pantalla_notebook'] ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="capacidad_ram" class="form-label">Memoria RAM</label>
            <select name="capacidad_ram" class="form-select" required>
                <option value="" selected disabled>Seleccione una capacidad </option>
                <?php while ($row = mysqli_fetch_assoc($resultCapacidadRam)): ?>
                    <option value="<?= $row['id_hardware'] ?>"><?= $row['capacidad_ram'] ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Guardar</button>
        <button type="button" class="btn btn-secondary" onclick="window.location.href='index_crear_producto.php';">Volver</button>
    </form>
</div>
</body>
</html>
