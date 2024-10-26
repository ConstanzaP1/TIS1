<?php
require('../conexion.php');

// Consultas para obtener las opciones de los atributos específicos del teclado
$queryCertificacion = "SELECT id_hardware, certificacion_fuente FROM certificacion_fuente";
$resultCertificacion = mysqli_query($conexion, $queryCertificacion);

$queryPotencia = "SELECT id_hardware, potencia_fuente FROM potencia_fuente";
$resultPotencia = mysqli_query($conexion, $queryPotencia);

$queryTamanio = "SELECT id_hardware, tamanio_fuente FROM tamanio_fuente";
$resultTamanio = mysqli_query($conexion, $queryTamanio);

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
    <h1 class="mb-4">Ingreso de Fuentes de poder</h1>
    <form action="procesar_producto.php" method="POST">
        <input type="hidden" name="categoria_producto" value="fuente">

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
            <label for="certificacion_fuente" class="form-label">Certificacion Fuente</label>
            <select name="certificacion_fuente" class="form-select" required>
                <option value="" selected disabled>Seleccione una certificacion</option>
                <?php while ($row = mysqli_fetch_assoc($resultCertificacion)): ?>
                    <option value="<?= $row['id_hardware'] ?>"><?= $row['certificacion_fuente'] ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="potencia_fuente" class="form-label">Potencia de fuente</label>
            <select name="potencia_fuente" class="form-select" required>
                <option value="" selected disabled>Seleccione una potencia</option>
                <?php while ($row = mysqli_fetch_assoc($resultPotencia)): ?>
                    <option value="<?= $row['id_hardware'] ?>"><?= $row['potencia_fuente'] ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="tamanio_fuente" class="form-label">Tamaño Fuente</label>
            <select name="tamanio_fuente" class="form-select" required>
                <option value="" selected disabled>Seleccione un tamaño</option>
                <?php while ($row = mysqli_fetch_assoc($resultTamanio)): ?>
                    <option value="<?= $row['id_hardware'] ?>"><?= $row['tamanio_fuente'] ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Guardar</button>
        <button type="button" class="btn btn-secondary" onclick="window.location.href='index_crear_producto.php';">Volver</button>
    </form>
</div>
</body>
</html>
