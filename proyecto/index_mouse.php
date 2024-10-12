<?php
require('conexion.php');

// Consulta para obtener datos de la tabla sensor_mouse que no sean NULL
$querySensor = "
    SELECT p.id_periferico, 
           sm.sensor_mouse
    FROM periferico p
    LEFT JOIN sensor_mouse sm ON p.id_periferico = sm.id_periferico
    WHERE sm.sensor_mouse IS NOT NULL
";

$resultSensor = mysqli_query($conexion, $querySensor);

// Consulta para obtener datos de la tabla dpi_mouse que no sean NULL
$queryDpi = "
    SELECT p.id_periferico, 
           dm.dpi_mouse
    FROM periferico p
    LEFT JOIN dpi_mouse dm ON p.id_periferico = dm.id_periferico
    WHERE dm.dpi_mouse IS NOT NULL
";

$resultDpi = mysqli_query($conexion, $queryDpi);

// Consulta para obtener datos de la tabla conectividad que no sean NULL
$queryConectividad = "
    SELECT p.id_periferico, 
           c.conectividad
    FROM periferico p
    LEFT JOIN conectividad c ON p.id_periferico = c.id_periferico
    WHERE c.conectividad IS NOT NULL
";

$resultConectividad = mysqli_query($conexion, $queryConectividad);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ingreso de Mantenedores</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h1 class="mb-4">Ingreso de mantenedores mouse</h1>

    <!-- Formulario para insertar periferico -->
    <form action="ingresar_periferico.php" method="POST" class="mb-4">
        <!-- Menú desplegable para seleccionar el tipo de periferico -->
        <div class="mb-3">
            <label for="tipo_periferico" class="form-label">Mantenedor</label>
            <select name="tipo_periferico" id="tipo_periferico" class="form-select" required onchange="mostrarCamposPeriferico()">
                <option value="" selected disabled>Seleccione un mantenedor</option>
                <option value="sensor_mouse">Sensor mouse</option>
                <option value="dpi_mouse">DPI mouse</option>
                <option value="conectividad">Conectividad</option>
            </select>
        </div>

        <!-- Campos (Ocultos inicialmente) -->
        <div class="mb-3" id="campoSensor_mouse" style="display: none;">       
            <label for="sensor_mouse" class="form-label mt-3">Sensor mouse</label>
            <input type="text" name="sensor_mouse" class="form-control" id="sensor_mouse">
        </div>
        <div class="mb-3" id="campoDpi_mouse" style="display: none;">       
            <label for="dpi_mouse" class="form-label mt-3">DPI mouse</label>
            <input type="text" name="dpi_mouse" class="form-control" id="dpi_mouse">
        </div>
        <div class="mb-3" id="campoConectividad" style="display: none;">       
            <label for="conectividad" class="form-label mt-3">Conectividad</label>
            <input type="text" name="conectividad" class="form-control" id="conectividad">
        </div>
        <button type="submit" class="btn btn-success mt-3">Guardar</button>
        <button class="btn btn-secondary mt-3" onclick="window.location.href='index.php';">Volver a Inicio</button>
    </form>

    <div class="container">
        <div class="row">
            <div class="col-6">
                <h2>Sensor Mouse</h2>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID Periferico</th>
                            <th>Sensor mouse</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($rowCategoria = mysqli_fetch_assoc($resultSensor)) : ?>
                            <tr>
                                <td><?php echo $rowCategoria['id_periferico']; ?></td>
                                <td><?php echo $rowCategoria['sensor_mouse']; ?></td>
                                <td>
                                    <button class="btn btn-primary" onclick="window.location.href='modificar_periferico.php?id_periferico=<?php echo $rowCategoria['id_periferico']; ?>';">Modificar</button>
                                    <button class="btn btn-danger" onclick="window.location.href='eliminar_periferico.php?id_periferico=<?php echo $rowCategoria['id_periferico']; ?>';">Eliminar</button>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>

            <div class="col-6">
                <h2>DPI mouse</h2>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID Periferico</th>
                            <th>DPI mouse</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($rowCategoria = mysqli_fetch_assoc($resultDpi)) : ?>
                            <tr>
                                <td><?php echo $rowCategoria['id_periferico']; ?></td>
                                <td><?php echo $rowCategoria['dpi_mouse']; ?></td>
                                <td>
                                    <button class="btn btn-primary" onclick="window.location.href='modificar_periferico.php?id_periferico=<?php echo $rowCategoria['id_periferico']; ?>';">Modificar</button>
                                    <button class="btn btn-danger" onclick="window.location.href='eliminar_periferico.php?id_periferico=<?php echo $rowCategoria['id_periferico']; ?>';">Eliminar</button>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>

            <div class="col-6">
                <h2>Conectividad</h2>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID Periferico</th>
                            <th>Conectividad</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($rowCategoria = mysqli_fetch_assoc($resultConectividad)) : ?>
                            <tr>
                                <td><?php echo $rowCategoria['id_periferico']; ?></td>
                                <td><?php echo $rowCategoria['conectividad']; ?></td>
                                <td>
                                    <button class="btn btn-primary" onclick="window.location.href='modificar_periferico.php?id_periferico=<?php echo $rowCategoria['id_periferico']; ?>';">Modificar</button>
                                    <button class="btn btn-danger" onclick="window.location.href='eliminar_periferico.php?id_periferico=<?php echo $rowCategoria['id_periferico']; ?>';">Eliminar</button>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript para mostrar los campos adicionales dinámicamente -->
<script>
    function mostrarCamposPeriferico() {
        var tipoPeriferico = document.getElementById("tipo_periferico").value;

        document.getElementById("campoSensor_mouse").style.display = "none";
        document.getElementById("campoDpi_mouse").style.display = "none";

        if (tipoPeriferico === "sensor_mouse") {
            document.getElementById("campoSensor_mouse").style.display = "block";
        } else if (tipoPeriferico === "dpi_mouse") {
            document.getElementById("campoDpi_mouse").style.display = "block";
        } else if (tipoPeriferico === "conectividad") {
            document.getElementById("campoConectividad").style.display = "block";
        }
    }
</script>
</body>
</html>
