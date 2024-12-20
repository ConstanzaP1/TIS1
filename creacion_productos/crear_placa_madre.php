<?php
require('../conexion.php');

// Consultas para obtener las opciones de los atributos específicos del teclado
$queryFormatoPlaca = "SELECT id_hardware, formato_placa FROM formato_placa";
$resultFormatoPlaca = mysqli_query($conexion, $queryFormatoPlaca);

$querySlot = "SELECT id_hardware, slot_memoria_placa FROM slot_memoria_placa";
$resultSlot = mysqli_query($conexion, $querySlot);

$querySocket = "SELECT id_hardware, socket_placa FROM socket_placa";
$resultSocket = mysqli_query($conexion, $querySocket);

$queryChipset = "SELECT id_hardware, chipset_placa FROM chipset_placa";
$resultChipset = mysqli_query($conexion, $queryChipset);

$queryMarca = "SELECT id_marca, nombre_marca FROM marca";
$resultMarca = mysqli_query($conexion, $queryMarca);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear placa madre</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1 class="mb-4">Ingreso de Placa</h1>
    <form action="procesar_producto.php" method="POST">
        <input type="hidden" name="categoria_producto" value="placa">

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
            <label for="formato_placa" class="form-label">Formato Placa</label>
            <select name="formato_placa" class="form-select" required>
                <option value="" selected disabled>Seleccione un formato</option>
                <?php while ($row = mysqli_fetch_assoc($resultFormatoPlaca)): ?>
                    <option value="<?= $row['id_hardware'] ?>"><?= $row['formato_placa'] ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="slot_memoria_placa" class="form-label">Slot Placa</label>
            <select name="slot_memoria_placa" class="form-select" required>
                <option value="" selected disabled>Seleccione un slot</option>
                <?php while ($row = mysqli_fetch_assoc($resultSlot)): ?>
                    <option value="<?= $row['id_hardware'] ?>"><?= $row['slot_memoria_placa'] ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="socket_placa" class="form-label">Socket Placa</label>
            <select name="socket_placa" class="form-select" required>
                <option value="" selected disabled>Seleccione un socket</option>
                <?php while ($row = mysqli_fetch_assoc($resultSocket)): ?>
                    <option value="<?= $row['id_hardware'] ?>"><?= $row['socket_placa'] ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="chipset_placa" class="form-label">Chipset Placa</label>
            <select name="chipset_placa" class="form-select" required>
                <option value="" selected disabled>Seleccione un chipset</option>
                <?php while ($row = mysqli_fetch_assoc($resultChipset)): ?>
                    <option value="<?= $row['id_hardware'] ?>"><?= $row['chipset_placa'] ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Guardar</button>
        <button type="button" class="btn btn-secondary" onclick="window.location.href='index_crear_producto.php';">Volver</button>
    </form>
</div>
</body>
</html>
