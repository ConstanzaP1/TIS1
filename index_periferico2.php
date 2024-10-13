<?php
require('conexion.php');

// Consulta para obtener datos de la tabla periferico y sus tablas asociadas
$query = "
    SELECT p.id_periferico, c.conectividad, sm.sensor_mouse, dm.dpi_mouse,
           ct.categoria_teclado, tt.tipo_teclado,
           ta.tipo_audifono, tm.tipo_microfono,
           tma.tamanio_monitor, rm.resolucion_monitor,
           tc.tipo_curvatura, tr.tiempo_respuesta,
           tp.tipo_panel
    FROM periferico p
    LEFT JOIN conectividad c ON p.id_periferico = c.id_periferico
    LEFT JOIN sensor_mouse sm ON p.id_periferico = sm.id_periferico
    LEFT JOIN dpi_mouse dm ON p.id_periferico = dm.id_periferico
    LEFT JOIN categoria_teclado ct ON p.id_periferico = ct.id_periferico
    LEFT JOIN tipo_teclado tt ON p.id_periferico = tt.id_periferico
    LEFT JOIN tipo_audifono ta ON p.id_periferico = ta.id_periferico
    LEFT JOIN tipo_microfono tm ON p.id_periferico = tm.id_periferico
    LEFT JOIN tamanio_monitor tma ON p.id_periferico = tma.id_periferico
    LEFT JOIN resolucion_monitor rm ON p.id_periferico = rm.id_periferico
    LEFT JOIN tipo_curvatura tc ON p.id_periferico = tc.id_periferico
    LEFT JOIN tiempo_respuesta tr ON p.id_periferico = tr.id_periferico
    LEFT JOIN tipo_panel tp ON p.id_periferico = tp.id_periferico
";

$result = mysqli_query($conexion, $query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ingreso de Hardware</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h1 class="mb-4">Ingreso de Periferico</h1>

    <!-- Formulario para insertar periferico -->
    <form action="ingresar_periferico.php" method="POST" class="mb-4">
        <!-- Menú desplegable para seleccionar el tipo de periferico -->
        <div class="mb-3">
            <label for="tipo_periferico" class="form-label">Tipo de Periferico</label>
            <select name="tipo_periferico" id="tipo_periferico" class="form-select" required onchange="mostrarCamposPeriferico()">
                <option value="" selected disabled>Seleccione un tipo de periferico</option>
                <option value="conectividad">Conectividad</option>
                <option value="sensor_mouse">Sensor Mouse</option>
                <option value="dpi_mouse">Dpi_mouse</option>
                <option value="categoria_teclado">Categoria teclado</option>
                <option value="tipo_teclado">Tipo teclado</option>
                <option value="tipo_audifono">Tipo audifono</option>
                <option value="tipo_microfono">Tipo microfono</option>
                <option value="tamanio_monitor">Tamaño Monitor</option>
                <option value="resolucion_monitor">Resolucion Monitor</option>
                <option value="tipo_curvatura">Tipo curvatura</option>
                <option value="tiempo_respuesta">Tiempo respuesta</option>
                <option value="tipo_panel">Tipo panel</option>
            </select>
        </div>

        <!-- Campos (Ocultos inicialmente) -->
        <div class="mb-3" id="campoConectividad" style="display: none;">       
            <label for="conectividad" class="form-label mt-3">Conectividad</label>
            <input type="text" name="conectividad" class="form-control" id="conectividad">
        </div>
        <div class="mb-3" id="campoSensor_mouse" style="display: none;">       
            <label for="sensor_mouse" class="form-label mt-3">Sensor mouse</label>
            <input type="text" name="sensor_mouse" class="form-control" id="sensor_mouse">
        </div>
        <div class="mb-3" id="campoDpi_mouse" style="display: none;">       
            <label for="dpi_mouse" class="form-label mt-3">Dpi mouse</label>
            <input type="text" name="dpi_mouse" class="form-control" id="dpi_mouse">
        </div>
        <div class="mb-3" id="campoCategoria_teclado" style="display: none;">       
            <label for="categoria_teclado" class="form-label mt-3">Categoria teclado</label>
            <input type="text" name="categoria_teclado" class="form-control" id="categoria_teclado">
        </div>
        <div class="mb-3" id="campoTipo_teclado" style="display: none;">       
            <label for="tipo_teclado" class="form-label mt-3">Tipo teclado</label>
            <input type="text" name="tipo_teclado" class="form-control" id="tipo_teclado">
        </div>
        <div class="mb-3" id="campoTipo_audifono" style="display: none;">       
            <label for="tipo_audifono" class="form-label mt-3">Tipo Audifono</label>
            <input type="text" name="tipo_audifono" class="form-control" id="tipo_audifono">
        </div>
        <div class="mb-3" id="campoTipo_microfono" style="display: none;">       
            <label for="tipo_microfono" class="form-label mt-3">Tipo Microfono</label>
            <input type="text" name="tipo_microfono" class="form-control" id="tipo_microfono">
        </div>
        <div class="mb-3" id="campoTamanio_monitor" style="display: none;">       
            <label for="tamanio_monitor" class="form-label mt-3">Tamaño monitor</label>
            <input type="text" name="tamanio_monitor" class="form-control" id="tamanio_monitor">
        </div>
        <div class="mb-3" id="campoResolucion_monitor" style="display: none;">       
            <label for="resolucion_monitor" class="form-label mt-3">Resolucion monitor</label>
            <input type="text" name="resolucion_monitor" class="form-control" id="resolucion_monitor">
        </div>
        <div class="mb-3" id="campoTipo_curvatura" style="display: none;">       
            <label for="tipo_curvatura" class="form-label mt-3">Tipo curvatura</label>
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

        <button type="submit" class="btn btn-primary mt-3">Guardar Hardware</button>
        <button class="btn btn-secondary mt-3" onclick="window.location.href='index.php';">Volver a Inicio</button>
    </form>
    
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID Periferico</th>
                <th>Conectividad</th>
                <th>Sensor Mouse</th>
                <th>DPI Mouse</th>
                <th>Categoria Teclado</th>
                <th>Tipo Teclado</th>
                <th>Tipo Audifono</th>
                <th>Tipo Microfono</th>
                <th>Tamaño Monitor</th>
                <th>Resolución Monitor</th>
                <th>Tipo Curvatura</th>
                <th>Tiempo Respuesta</th>
                <th>Tipo Panel</th>
                <th>Acciones</th> <!-- Nueva columna para botones -->
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                <tr>
                    <td><?php echo $row['id_periferico']; ?></td>
                    <td><?php echo $row['conectividad']; ?></td>
                    <td><?php echo $row['sensor_mouse']; ?></td>
                    <td><?php echo $row['dpi_mouse']; ?></td>
                    <td><?php echo $row['categoria_teclado']; ?></td>
                    <td><?php echo $row['tipo_teclado']; ?></td>
                    <td><?php echo $row['tipo_audifono']; ?></td>
                    <td><?php echo $row['tipo_microfono']; ?></td>
                    <td><?php echo $row['tamanio_monitor']; ?></td>
                    <td><?php echo $row['resolucion_monitor']; ?></td>
                    <td><?php echo $row['tipo_curvatura']; ?></td>
                    <td><?php echo $row['tiempo_respuesta']; ?></td>
                    <td><?php echo $row['tipo_panel']; ?></td>
                    <td>
                        <a href="modificar_periferico.php?id_periferico=<?php echo $row['id_periferico']; ?>">Modificar</a> | 
                        <a href="eliminar_periferico.php?id_periferico=<?php echo $row['id_periferico']; ?>">Eliminar</a>
                    </td> <!-- Botones de acción -->
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<script>
function mostrarCamposPeriferico() {
    const tipoPeriferico = document.getElementById("tipo_periferico").value;
    const campos = [
        'campoConectividad', 'campoSensor_mouse', 'campoDpi_mouse',
        'campoCategoria_teclado', 'campoTipo_teclado', 'campoTipo_audifono',
        'campoTipo_microfono', 'campoTamanio_monitor', 'campoResolucion_monitor',
        'campoTipo_curvatura', 'campoTiempo_respuesta', 'campoTipo_panel'
    ];
    
    // Oculta todos los campos
    campos.forEach(campo => document.getElementById(campo).style.display = 'none');

    // Muestra el campo correspondiente
    if (tipoPeriferico) {
        const campoMostrar = `campo${tipoPeriferico.charAt(0).toUpperCase() + tipoPeriferico.slice(1)}`;
        document.getElementById(campoMostrar).style.display = 'block';
    }
}
</script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
