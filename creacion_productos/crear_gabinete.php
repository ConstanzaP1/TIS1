<?php
require('../conexion.php');

// Consultas para obtener las opciones de los atributos específicos del teclado
$queryGabinete = "SELECT id_hardware, tamanio_max_gabinete FROM tamanio_max_gabinete";
$resultGabinete = mysqli_query($conexion, $queryGabinete);

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
    <title>Crear gabinete</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1 class="mb-4">Ingreso de gabinetes</h1>
    <form action="procesar_producto.php" method="POST">
        <input type="hidden" name="categoria_producto" value="gabinete">

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
            <label for="tamanio_max_gabinete" class="form-label">Tamaño Gabinete</label>
            <select name="tamanio_max_gabinete" class="form-select" required>
                <option value="" selected disabled>Seleccione un tamaño</option>
                <?php while ($row = mysqli_fetch_assoc($resultGabinete)): ?>
                    <option value="<?= $row['id_hardware'] ?>"><?= $row['tamanio_max_gabinete'] ?></option>
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
        <button type="button" class="btn btn-secondary" onclick="window.location.href='index_crear_producto.php';">Volver</button>
    </form>
</div>
</body>
</html>
