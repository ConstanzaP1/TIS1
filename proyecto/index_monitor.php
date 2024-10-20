<?php
require('conexion.php');

// Consulta para obtener datos de la tabla tamanio_monitor que no sean NULL
$queryTamanio_monitor = "
    SELECT p.id_periferico, 
           tm.tamanio_monitor
    FROM periferico p
    LEFT JOIN tamanio_monitor tm ON p.id_periferico = tm.id_periferico
    WHERE tm.tamanio_monitor IS NOT NULL
";

$resultTamanio_monitor= mysqli_query($conexion, $queryTamanio_monitor);

// Consulta para obtener datos de la tabla resolucion_monitor que no sean NULL
$queryResolucion_monitor = "
    SELECT p.id_periferico, 
           rm.resolucion_monitor
    FROM periferico p
    LEFT JOIN resolucion_monitor rm ON p.id_periferico = rm.id_periferico
    WHERE rm.resolucion_monitor IS NOT NULL
";

$resultResolucion_monitor = mysqli_query($conexion, $queryResolucion_monitor);

// Consulta para obtener datos de la tabla tipo_curvatura que no sean NULL
$queryTipo_curvatura = "
    SELECT p.id_periferico, 
           tc.tipo_curvatura
    FROM periferico p
    LEFT JOIN tipo_curvatura tc ON p.id_periferico = tc.id_periferico
    WHERE tc.tipo_curvatura IS NOT NULL
";

$resultTipo_curvatura = mysqli_query($conexion, $queryTipo_curvatura);

// Consulta para obtener datos de la tabla tiempo_respuesta que no sean NULL
$queryTiempo_respuesta = "
    SELECT p.id_periferico, 
           tr.tiempo_respuesta
    FROM periferico p
    LEFT JOIN tiempo_respuesta tr ON p.id_periferico = tr.id_periferico
    WHERE tr.tiempo_respuesta IS NOT NULL
";

$resultTiempo_respuesta = mysqli_query($conexion, $queryTiempo_respuesta);

// Consulta para obtener datos de la tabla tipo_panel que no sean NULL
$queryTipo_panel = "
    SELECT p.id_periferico, 
           tp.tipo_panel
    FROM periferico p
    LEFT JOIN tipo_panel tp ON p.id_periferico = tp.id_periferico
    WHERE  tp.tipo_panel IS NOT NULL
";

$resultTipo_panel = mysqli_query($conexion, $queryTipo_panel);
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
    <h1 class="mb-4">Ingreso de mantenedores monitor</h1>

    <!-- Formulario para insertar periferico -->
    <form action="ingresar_periferico.php" method="POST" class="mb-4">
        <!-- Menú desplegable para seleccionar el tipo de periferico -->
        <div class="mb-3">
            <label for="tipo_periferico" class="form-label">Mantenedor</label>
            <select name="tipo_periferico" id="tipo_periferico" class="form-select" required onchange="mostrarCamposPeriferico()">
                <option value="" selected disabled>Seleccione un mantenedor</option>
                <option value="tamanio_monitor">Tamaño monitor</option>
                <option value="resolucion_monitor">Resolucion Monitor</option>
                <option value="tipo_curvatura">Tipo de curvatura</option>
                <option value="tiempo_respuesta">Tiempo de respuesta</option>
                <option value="tipo_panel">Tipo de panel</option>
            </select>
        </div>

        <!-- Campos (Ocultos inicialmente) -->
        <div class="mb-3" id="campoTamanio_monitor" style="display: none;">       
            <label for="tamanio_monitor" class="form-label mt-3">Tamaño monitor</label>
            <input type="text" name="tamanio_monitor" class="form-control" id="tamanio_monitor">
        </div>
        <div class="mb-3" id="campoResolucion_monitor" style="display: none;">       
            <label for="resolucion_monitor" class="form-label mt-3">Resolucion monitor</label>
            <input type="text" name="resolucion_monitor" class="form-control" id="resolucion_monitor">
        </div>
        <div class="mb-3" id="campoTipo_curvatura" style="display: none;">       
            <label for="tipo_curvatura" class="form-label mt-3">tipo_curvatura</label>
            <input type="text" name="tipo_curvatura" class="form-control" id="tipo_curvatura">
        </div>
        <div class="mb-3" id="campoTiempo_respuesta" style="display: none;">       
            <label for="tiempo_respuesta" class="form-label mt-3">Tiempo respuesta</label>
            <input type="text" name="tiempo_respuesta" class="form-control" id="tiempo_respuesta">
        </div>
        <div class="mb-3" id="campoTipo_panel" style="display: none;">       
            <label for="tipo_panel" class="form-label mt-3">Tipo panel</label>
            <input type="text" name="tipo_panel" class="form-control" id="tipo_panel">
        </div>
        <button type="submit" class="btn btn-success mt-3">Guardar</button>
        <button class="btn btn-secondary mt-3" onclick="window.location.href='admin_panel.php';">Volver a Inicio</button>
    </form>

    <div class="container">
        <div class="row">
            <div class="col-6">
                <h2>Tamaño monitor</h2>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID Periferico</th>
                            <th>Tamaño monitor</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($rowCategoria = mysqli_fetch_assoc($resultTamanio_monitor)) : ?>
                            <tr>
                                <td><?php echo $rowCategoria['id_periferico']; ?></td>
                                <td><?php echo $rowCategoria['tamanio_monitor']; ?></td>
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
                <h2>Resolucion monitor</h2>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID Periferico</th>
                            <th>Resolucion monitor</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($rowCategoria = mysqli_fetch_assoc($resultResolucion_monitor)) : ?>
                            <tr>
                                <td><?php echo $rowCategoria['id_periferico']; ?></td>
                                <td><?php echo $rowCategoria['resolucion_monitor']; ?></td>
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
                <h2>tipo_curvatura</h2>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID Periferico</th>
                            <th>Tipo curvatura</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($rowCategoria = mysqli_fetch_assoc($resultTipo_curvatura)) : ?>
                            <tr>
                                <td><?php echo $rowCategoria['id_periferico']; ?></td>
                                <td><?php echo $rowCategoria['tipo_curvatura']; ?></td>
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
                <h2>Tiempo respuesta</h2>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID Periferico</th>
                            <th>Tiempo respuesta</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($rowCategoria = mysqli_fetch_assoc($resultTiempo_respuesta)) : ?>
                            <tr>
                                <td><?php echo $rowCategoria['id_periferico']; ?></td>
                                <td><?php echo $rowCategoria['tiempo_respuesta']; ?></td>
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
                <h2>Tipo panel</h2>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID Periferico</th>
                            <th>Tipo panel</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($rowCategoria = mysqli_fetch_assoc($resultTipo_panel)) : ?>
                            <tr>
                                <td><?php echo $rowCategoria['id_periferico']; ?></td>
                                <td><?php echo $rowCategoria['tipo_panel']; ?></td>
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

        document.getElementById("campoTamanio_monitor").style.display = "none";
        document.getElementById("campoResolucion_monitor").style.display = "none";

        if (tipoPeriferico === "tamanio_monitor") {
            document.getElementById("campoTamanio_monitor").style.display = "block";
        } else if (tipoPeriferico === "resolucion_monitor") {
            document.getElementById("campoResolucion_monitor").style.display = "block";
        } else if (tipoPeriferico === "tipo_curvatura") {
            document.getElementById("campoTipo_curvatura").style.display = "block";
        } else if (tipoPeriferico === "tiempo_respuesta") {
            document.getElementById("campoTiempo_respuesta").style.display = "block";
        } else if (tipoPeriferico === "tipo_panel") {
            document.getElementById("campoTipo_panel").style.display = "block";
        }
    }
</script>
</body>
</html>
