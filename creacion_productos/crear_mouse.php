<?php
require('../conexion.php');

// Consultas para obtener las opciones de los atributos específicos del teclado
$queryDpiMouse = "SELECT id_periferico, dpi_mouse FROM dpi_mouse";
$resultDpiMouse = mysqli_query($conexion, $queryDpiMouse);

$queryPesoMouse = "SELECT id_periferico, peso_mouse FROM peso_mouse";
$resultPesoMouse = mysqli_query($conexion, $queryPesoMouse);

$querySensorMouse = "SELECT id_periferico, sensor_mouse FROM sensor_mouse";
$resultSensorMouse = mysqli_query($conexion, $querySensorMouse);

$queryConectividad = "SELECT id_periferico, conectividad FROM conectividad";
$resultConectividad = mysqli_query($conexion, $queryConectividad);

$queryIluminacion = "SELECT id_periferico, iluminacion FROM iluminacion";
$resultIluminacion = mysqli_query($conexion, $queryIluminacion);

$queryMarca = "SELECT id_marca, nombre_marca FROM marca";
$resultMarca = mysqli_query($conexion, $queryMarca);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear mouse</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1 class="mb-4">Ingreso de Teclado</h1>
    <form action="procesar_producto.php" method="POST">
        <input type="hidden" name="categoria_producto" value="mouse">

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
            <label for="dpi_mouse" class="form-label">DPI de mouse</label>
            <select name="dpi_mouse" class="form-select" required>
                <option value="" selected disabled>Seleccione un DPI</option>
                <?php while ($row = mysqli_fetch_assoc($resultDpiMouse)): ?>
                    <option value="<?= $row['id_periferico'] ?>"><?= $row['dpi_mouse'] ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="peso_mouse" class="form-label">Peso de Mouse</label>
            <select name="peso_mouse" class="form-select" required>
                <option value="" selected disabled>Seleccione un peso</option>
                <?php while ($row = mysqli_fetch_assoc($resultPesoMouse)): ?>
                    <option value="<?= $row['id_periferico'] ?>"><?= $row['peso_mouse'] ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="sensor_mouse" class="form-label">Sensor de mouse</label>
            <select name="sensor_mouse" class="form-select" required>
                <option value="" selected disabled>Seleccione un sensor</option>
                <?php while ($row = mysqli_fetch_assoc($resultSensorMouse)): ?>
                    <option value="<?= $row['id_periferico'] ?>"><?= $row['sensor_mouse'] ?></option>
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

        <div class="mb-3">
            <label for="conectividad" class="form-label">Conectividad</label>
            <select name="conectividad" class="form-select" required>
                <option value="" selected disabled>Seleccione la conectividad</option>
                <?php while ($row = mysqli_fetch_assoc($resultConectividad)): ?>
                    <option value="<?= $row['id_periferico'] ?>"><?= $row['conectividad'] ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Guardar</button>
        <button type="button" class="btn btn-secondary" onclick="window.location.href='index_crear_producto.php';">Volver</button>
    </form>
</div>
</body>
</html>
