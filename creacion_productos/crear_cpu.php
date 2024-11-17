<?php
require('../conexion.php');

// Consultas para obtener las opciones de los atributos específicos del CPU
$queryFrecuenciaCpu = "SELECT id_hardware, frecuencia_cpu FROM frecuencia_cpu";
$resultFrencuenciaCpu = mysqli_query($conexion, $queryFrecuenciaCpu);

$queryNucleoHilo = "SELECT id_hardware, nucleo_hilo_cpu FROM nucleo_hilo_cpu";
$resultNucleoHilo = mysqli_query($conexion, $queryNucleoHilo);

$querySocketCpu = "SELECT id_hardware, socket_cpu FROM socket_cpu";
$resultSocketCpu = mysqli_query($conexion, $querySocketCpu);

$queryMarca = "SELECT id_marca, nombre_marca FROM marca";
$resultMarca = mysqli_query($conexion, $queryMarca);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear CPU</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1 class="mb-4">Ingreso de CPU</h1>
    <form action="procesar_producto.php" method="POST">
        <input type="hidden" name="categoria_producto" value="cpu">

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
            <label for="precio" class="form-label">Precio de venta</label>
            <input type="number" name="precio" class="form-control" id="precio" required>
        </div>

        <div class="mb-3">
            <label for="costo" class="form-label">Costo de compra</label>
            <input type="number" name="costo" class="form-control" id="costo" required>
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
            <label for="frecuencia_cpu" class="form-label">Frecuencia de la CPU</label>
            <select name="frecuencia_cpu" class="form-select" required>
                <option value="" selected disabled>Seleccione una frecuencia</option>
                <?php while ($row = mysqli_fetch_assoc($resultFrencuenciaCpu)): ?>
                    <option value="<?= $row['id_hardware'] ?>"><?= $row['frecuencia_cpu'] ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="nucleo_hilo_cpu" class="form-label">Nucle / HIlo CPU</label>
            <select name="nucleo_hilo_cpu" class="form-select" required>
                <option value="" selected disabled>Seleccione una opcion</option>
                <?php while ($row = mysqli_fetch_assoc($resultNucleoHilo)): ?>
                    <option value="<?= $row['id_hardware'] ?>"><?= $row['nucleo_hilo_cpu'] ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="socket_cpu" class="form-label">Socket CPU</label>
            <select name="socket_cpu" class="form-select" required>
                <option value="" selected disabled>Seleccione un socket </option>
                <?php while ($row = mysqli_fetch_assoc($resultSocketCpu)): ?>
                    <option value="<?= $row['id_hardware'] ?>"><?= $row['socket_cpu'] ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Guardar</button>
        <button type="button" class="btn btn-secondary" onclick="window.location.href='index_crear_producto.php';">Volver</button>
    </form>
</div>
</body>
</html>
