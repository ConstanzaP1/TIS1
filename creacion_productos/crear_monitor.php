<?php
require('../conexion.php');

// Consultas para obtener las opciones de los atributos específicos del teclado
$queryResolucionMonitor = "SELECT id_periferico, resolucion_monitor FROM resolucion_monitor";
$resultResolucionMonitor = mysqli_query($conexion, $queryResolucionMonitor);

$queryTamanioMonitor = "SELECT id_periferico, tamanio_monitor FROM tamanio_monitor";
$resultTamanioMonitor = mysqli_query($conexion, $queryTamanioMonitor);

$queryTasa = "SELECT id_periferico, tasa_refresco FROM tasa_refresco";
$resultTasa = mysqli_query($conexion, $queryTasa);

$queryTiempo = "SELECT id_periferico, tiempo_respuesta FROM tiempo_respuesta";
$resultTiempo = mysqli_query($conexion, $queryTiempo);

$querySoporte = "SELECT id_periferico, soporte_monitor FROM soporte_monitor";
$resultSoporte = mysqli_query($conexion, $querySoporte);

$queryTipoPanel = "SELECT id_periferico, tipo_panel FROM tipo_panel";
$resultTipoPanel = mysqli_query($conexion, $queryTipoPanel);

$queryTipoCurvatura = "SELECT id_periferico, tipo_curvatura FROM tipo_curvatura";
$resultTipoCurvatura = mysqli_query($conexion, $queryTipoCurvatura);
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
        <input type="hidden" name="categoria_producto" value="monitor">

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
            <label for="resolucion_monitor" class="form-label">Resolucion de Monitor</label>
            <select name="resolucion_monitor" class="form-select" required>
                <option value="" selected disabled>Seleccione una resolucion</option>
                <?php while ($row = mysqli_fetch_assoc($resultResolucionMonitor)): ?>
                    <option value="<?= $row['id_periferico'] ?>"><?= $row['resolucion_monitor'] ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="tamanio_monitor" class="form-label">Tamaño de Monitor</label>
            <select name="tamanio_monitor" class="form-select" required>
                <option value="" selected disabled>Seleccione un tamaño</option>
                <?php while ($row = mysqli_fetch_assoc($resultTamanioMonitor)): ?>
                    <option value="<?= $row['id_periferico'] ?>"><?= $row['tamanio_monitor'] ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="tasa_refresco" class="form-label">Tasa de refresco</label>
            <select name="tasa_refresco" class="form-select" required>
                <option value="" selected disabled>Seleccione una tasa </option>
                <?php while ($row = mysqli_fetch_assoc($resultTasa)): ?>
                    <option value="<?= $row['id_periferico'] ?>"><?= $row['tasa_refresco'] ?></option>
                <?php endwhile; ?>
            </select>
        </div>


        <div class="mb-3">
            <label for="tiempo_respuesta" class="form-label">Tiempo de respuesta</label>
            <select name="tiempo_respuesta" class="form-select" required>
                <option value="" selected disabled>Seleccione un tiempo</option>
                <?php while ($row = mysqli_fetch_assoc($resultTiempo)): ?>
                    <option value="<?= $row['id_periferico'] ?>"><?= $row['tiempo_respuesta'] ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="soporte_monitor" class="form-label">Soporte del monitor</label>
            <select name="soporte_monitor" class="form-select" required>
                <option value="" selected disabled>Seleccione soporte</option>
                <?php while ($row = mysqli_fetch_assoc($resultSoporte)): ?>
                    <option value="<?= $row['id_periferico'] ?>"><?= $row['soporte_monitor'] ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="tipo_panel" class="form-label">Tipo de panel</label>
            <select name="tipo_panel" class="form-select" required>
                <option value="" selected disabled>Seleccione tipo</option>
                <?php while ($row = mysqli_fetch_assoc($resultTipoPanel)): ?>
                    <option value="<?= $row['id_periferico'] ?>"><?= $row['tipo_panel'] ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="tipo_curvatura" class="form-label">Tipo de curvatura</label>
            <select name="tipo_curvatura" class="form-select" required>
                <option value="" selected disabled>Seleccione tipo</option>
                <?php while ($row = mysqli_fetch_assoc($resultTipoCurvatura)): ?>
                    <option value="<?= $row['id_periferico'] ?>"><?= $row['tipo_curvatura'] ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Guardar</button>
    </form>
</div>
</body>
</html>
