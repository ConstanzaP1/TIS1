<?php
require('../conexion.php');

// Consultas para obtener las opciones de los atributos específicos del CPU
$queryFrecuenciaGpu = "SELECT id_hardware, frecuencia_gpu FROM frecuencia_gpu";
$resultFrencuenciaGpu = mysqli_query($conexion, $queryFrecuenciaGpu);

$queryMemoriaGpu = "SELECT id_hardware, memoria_gpu FROM memoria_gpu";
$resultMemoriaGpu = mysqli_query($conexion, $queryMemoriaGpu);

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
    <h1 class="mb-4">Ingreso de GPU</h1>
    <form action="procesar_producto.php" method="POST">
        <input type="hidden" name="categoria_producto" value="gpu">

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
            <label for="frecuencia_gpu" class="form-label">Frecuencia de GPU</label>
            <select name="frecuencia_gpu" class="form-select" required>
                <option value="" selected disabled>Seleccione una frecuencia</option>
                <?php while ($row = mysqli_fetch_assoc($resultFrencuenciaGpu)): ?>
                    <option value="<?= $row['id_hardware'] ?>"><?= $row['frecuencia_gpu'] ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="memoria_gpu" class="form-label">Memoria GPU</label>
            <select name="memoria_gpu" class="form-select" required>
                <option value="" selected disabled>Seleccione una memoria</option>
                <?php while ($row = mysqli_fetch_assoc($resultMemoriaGpu)): ?>
                    <option value="<?= $row['id_hardware'] ?>"><?= $row['memoria_gpu'] ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        
        <button type="submit" class="btn btn-success">Guardar</button>
        <button type="button" class="btn btn-secondary" onclick="window.location.href='index_crear_producto.php';">Volver</button>
    </form>
</div>
</body>
</html>
