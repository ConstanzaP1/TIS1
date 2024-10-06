<?php
    require('conexion.php');
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
        <!-- Campos (Ocultos inicialmente) -->
        <div class="mb-3" id="campoSensor_mouse" style="display: none;">       
            <label for="sensor_mouse" class="form-label mt-3">Sensor mouse</label>
            <input type="text" name="sensor_mouse" class="form-control" id="sensor_mouse">
        </div>
        <!-- Campos (Ocultos inicialmente) -->
        <div class="mb-3" id="campoDpi_mouse" style="display: none;">       
            <label for="dpi_mouse" class="form-label mt-3">Dpi mouse</label>
            <input type="text" name="dpi_mouse" class="form-control" id="dpi_mouse">
        </div>
        <!-- Campos (Ocultos inicialmente) -->
        <div class="mb-3" id="campoCategoria_teclado" style="display: none;">       
            <label for="categoria_teclado" class="form-label mt-3">Categoria teclado</label>
            <input type="text" name="categoria_teclado" class="form-control" id="categoria_teclado">
        </div>
        <!-- Campos  (Ocultos inicialmente) -->
        <div class="mb-3" id="campoTipo_teclado" style="display: none;">       
            <label for="tipo_teclado" class="form-label mt-3">Tipo teclado</label>
            <input type="text" name="tipo_teclado" class="form-control" id="tipo_teclado">
        </div>
        <!-- Campos (Ocultos inicialmente) -->
        <div class="mb-3" id="campoTipo_audifono" style="display: none;">       
            <label for="tipo_audifono" class="form-label mt-3">Tipo Audifono</label>
            <input type="text" name="tipo_audifono" class="form-control" id="tipo_audifono">
        </div>
        <!-- Campos (Ocultos inicialmente) -->
        <div class="mb-3" id="campoTipo_microfono" style="display: none;">       
            <label for="tipo_microfono" class="form-label mt-3">Tipo Microfono</label>
            <input type="text" name="tipo_microfono" class="form-control" id="tipo_microfono">
        </div>
        <!-- Campos (Ocultos inicialmente) FALTA TABLA -->
        <div class="mb-3" id="campoTamanio_monitor" style="display: none;">       
            <label for="tamanio_monitor" class="form-label mt-3">Tamaño monitor</label>
            <input type="text" name="tamanio_monitor" class="form-control" id="tamanio_monitor">
        </div>
        <!-- Campos (Ocultos inicialmente) FALTA TABLA -->
        <div class="mb-3" id="campoResolucion_monitor" style="display: none;">       
            <label for="resolucion_monitor" class="form-label mt-3">Resolucion monitor  </label>
            <input type="text" name="resolucion_monitor" class="form-control" id="resolucion_monitor">
        </div>
        <!-- Campos (Ocultos inicialmente) FALTA TABLA -->
        <div class="mb-3" id="campoTipo_curvatura" style="display: none;">       
            <label for="tipo_curvatura" class="form-label mt-3">Tipo curvatura  </label>
            <input type="text" name="tipo_curvatura" class="form-control" id="tipo_curvatura">
        </div>
        <!-- Campos (Ocultos inicialmente) FALTA TABLA -->
        <div class="mb-3" id="campoTiempo_respuesta" style="display: none;">       
            <label for="tiempo_respuesta" class="form-label mt-3">Tiempo respuesta  </label>
            <input type="text" name="tiempo_respuesta" class="form-control" id="tiempo_respuesta">
        </div>
        <!-- Campos (Ocultos inicialmente) FALTA TABLA -->
        <div class="mb-3" id="campoTipo_panel" style="display: none;">       
            <label for="tipo_panel" class="form-label mt-3">Tipo panel  </label>
            <input type="text" name="tipo_panel" class="form-control" id="tipo_panel">
        </div>

        <button type="submit" class="btn btn-primary mt-3">Guardar Hardware</button>
    </form>

</div>

<!-- JavaScript para mostrar los campos adicionales dinámicamente -->
<script>
    function mostrarCamposPeriferico() {
        var tipo_periferico = document.getElementById("tipo_periferico").value;

        // Ocultar todos los campos inicialmente
        document.getElementById("campoConectividad").style.display = "none";
        document.getElementById("campoSensor_mouse").style.display = "none";
        
        // Mostrar solo los campos correspondientes al tipo de periferico seleccionado
        if (tipo_periferico === "conectividad") {
            document.getElementById("campoConectividad").style.display = "block";

        } else if (tipo_periferico === "sensor_mouse") {
            document.getElementById("campoSensor_mouse").style.display = "block";
        } else if (tipo_periferico === "dpi_mouse") {
            document.getElementById("campoDpi_mouse").style.display = "block";
        } else if (tipo_periferico === "categoria_teclado") {
            document.getElementById("campoCategoria_teclado").style.display = "block";
        } else if (tipo_periferico === "tipo_teclado") {
            document.getElementById("campoTipo_teclado").style.display = "block";
        } else if (tipo_periferico === "tipo_audifono") {
            document.getElementById("campoTipo_audifono").style.display = "block";
        } else if (tipo_periferico === "tipo_microfono") {
            document.getElementById("campoTipo_microfono").style.display = "block";
        } else if (tipo_periferico === "tamanio_monitor") {
            document.getElementById("campoTamanio_monitor").style.display = "block";
        } else if (tipo_periferico === "resolucion_monitor") {
            document.getElementById("campoResolucion_monitor").style.display = "block";
        } else if (tipo_periferico === "tipo_curvatura") {
            document.getElementById("campoTipo_curvatura").style.display = "block";
        } else if (tipo_periferico === "tiempo_respuesta") {
            document.getElementById("campoTiempo_respuesta").style.display = "block";
        } else if (tipo_periferico === "tipo_panel") {
            document.getElementById("campoTipo_panel").style.display = "block";
        }
    }
</script>

</body>
</html>
