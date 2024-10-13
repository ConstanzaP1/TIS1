<?php
require('../conexion.php');

// Obtener el ID del periférico a modificar
$id_periferico = $_GET['id_periferico'];

// Consultar la base de datos para obtener los datos actuales del periférico
$query = "SELECT * FROM periferico p
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
          WHERE p.id_periferico = '$id_periferico'";

$result = mysqli_query($conexion, $query);
$row = mysqli_fetch_assoc($result);

// Mostrar un formulario con los datos actuales para que el usuario pueda modificarlos
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Periférico</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h1 class="mb-4">Modificar mantenedores perifericos</h1>

    <!-- Formulario para modificar periférico -->
    <form action="actualizar_periferico.php" method="POST" class="mb-4">
        <!-- Campo oculto para el ID del periférico -->
        <input type="hidden" name="id_periferico" value="<?php echo $id_periferico; ?>">

        <!-- Menú desplegable para seleccionar el tipo de periférico -->
        <div class="mb-3" style="display: none;">
            <label for="tipo_periferico" class="form-label">Tipo de Periférico</label>
            <select name="tipo_periferico" id="tipo_periferico" class="form-select" required>
                <option value="" selected disabled>Seleccione un tipo de periférico</option>
                <option value="conectividad" <?php if ($row['conectividad']) echo 'selected'; ?>>Conectividad</option>
                <option value="sensor_mouse" <?php if ($row['sensor_mouse']) echo 'selected'; ?>>Sensor Mouse</option>
                <option value="dpi_mouse" <?php if ($row['dpi_mouse']) echo 'selected'; ?>>Dpi_mouse</option>
                <option value="categoria_teclado" <?php if ($row['categoria_teclado']) echo 'selected'; ?>>Categoria teclado</option>
                <option value="tipo_teclado" <?php if ($row['tipo_teclado']) echo 'selected'; ?>>Tipo teclado</option>
                <option value="tipo_audifono" <?php if ($row['tipo_audifono']) echo 'selected'; ?>>Tipo audifono</option>
                <option value="tipo_microfono" <?php if ($row['tipo_microfono']) echo 'selected'; ?>>Tipo microfono</option>
                <option value="tamanio_monitor" <?php if ($row['tamanio_monitor']) echo 'selected'; ?>>Tamaño Monitor</option>
                <option value="resolucion_monitor" <?php if ($row['resolucion_monitor']) echo 'selected'; ?>>Resolución Monitor</option>
                <option value="tipo_curvatura" <?php if ($row['tipo_curvatura']) echo 'selected'; ?>>Tipo curvatura</option>
                <option value="tiempo_respuesta" <?php if ($row['tiempo_respuesta']) echo 'selected'; ?>>Tiempo respuesta</option>
                <option value="tipo_panel" <?php if ($row['tipo_panel']) echo 'selected'; ?>>Tipo panel</option>
            </select>
        </div>
        <!-- Campos (Ocultos inicialmente) -->
        <div class="mb-3" id="campoConectividad" style="display: none;">       
            <label for="conectividad" class="form-label mt-3">Conectividad</label>
            <input type="text" name="conectividad" class="form-control" id="conectividad" value="<?php echo $row['conectividad']; ?>">
        </div>
        <div class="mb-3" id="campoSensor_mouse" style="display: none;">       
            <label for="sensor_mouse" class="form-label mt-3">Sensor mouse</label>
            <input type="text" name="sensor_mouse" class="form-control" id="sensor_mouse" value="<?php echo $row['sensor_mouse']; ?>">
        </div>
        <div class="mb-3" id="campoDpi_mouse" style="display: none;">       
            <label for="dpi_mouse" class="form-label mt-3">Dpi mouse</label>
            <input type="text" name="dpi_mouse" class="form-control" id="dpi_mouse" value="<?php echo $row['dpi_mouse']; ?>">
        </div>
        <div class="mb-3" id="campoCategoria_teclado" style="display: none;">       
            <label for="categoria_teclado" class="form-label mt-3">Categoria teclado</label>
            <input type="text" name="categoria_teclado" class="form-control" id="categoria_teclado" value="<?php echo $row['categoria_teclado']; ?>">
        </div>
        <div class="mb-3" id="campoTipo_teclado" style="display: none;">       
            <label for="tipo_teclado" class="form-label mt-3">Tipo teclado</label>
            <input type="text" name="tipo_teclado" class="form-control" id="tipo_teclado" value="<?php echo $row['tipo_teclado']; ?>">
        </div>
        <div class="mb-3" id="campoTipo_audifono" style="display: none;">       
            <label for="tipo_audifono" class="form-label mt-3">Tipo Audifono</label>
            <input type="text" name="tipo_audifono" class="form-control" id="tipo_audifono" value="<?php echo $row['tipo_audifono']; ?>">
        </div>
        <div class="mb-3" id="campoTipo_microfono" style="display: none;">       
            <label for="tipo_microfono" class="form-label mt-3">Tipo Microfono</label>
            <input type="text" name="tipo_microfono" class="form-control" id="tipo_microfono" value="<?php echo $row['tipo_microfono']; ?>">
        </div>
        <div class="mb-3" id="campoTamanio_monitor" style="display: none;">       
            <label for="tamanio_monitor" class="form-label mt-3">Tamaño monitor</label>
            <input type="text" name="tamanio_monitor" class="form-control" id="tamanio_monitor" value="<?php echo $row['tamanio_monitor']; ?>">
        </div>
        <div class="mb-3" id="campoResolucion_monitor" style="display: none;">       
            <label for="resolucion_monitor" class="form-label mt-3">Resolucion monitor</label>
            <input type="text" name="resolucion_monitor" class="form-control" id="resolucion_monitor" value="<?php echo $row['resolucion_monitor']; ?>">
        </div>
        <div class="mb-3" id="campoTipo_curvatura" style="display: none;">       
            <label for="tipo_curvatura" class="form-label mt-3">Tipo curvatura</label>
            <input type="text" name="tipo_curvatura" class="form-control" id="tipo_curvatura" value="<?php echo $row['tipo_curvatura']; ?>">
        </div>
        <div class="mb-3" id="campoTiempo_respuesta" style="display: none;">       
            <label for="tiempo_respuesta" class="form-label mt-3">Tiempo respuesta</label>
            <input type="text" name="tiempo_respuesta" class="form-control" id="tiempo_respuesta" value="<?php echo $row['tiempo_respuesta']; ?>">
        </div>
        <div class="mb-3" id="campoTipo_panel" style="display: none;">       
            <label for="tipo_panel" class="form-label mt-3">Tipo panel</label>
            <input type="text" name="tipo_panel" class="form-control" id="tipo_panel" value="<?php echo $row['tipo_panel']; ?>">
        </div>

        <button type="submit" class="btn btn-primary mt-3">Guardar cambios</button>
    </form>

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

        // Llamar a la función al cargar la página
        window.onload = function() {
            mostrarCamposPeriferico();
        };

        // Llamar a la función al cambiar el valor del select
        document.getElementById("tipo_periferico").addEventListener("change", mostrarCamposPeriferico);
    </script>
</div>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>