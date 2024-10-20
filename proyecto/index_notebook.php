<?php
require('conexion.php');

// Consulta para obtener datos de la tabla periferico y sus tablas asociadas
$query = "
    SELECT p.id_notebook, cp.cpu_notebook, gn.gpu_notebook, pn.pantalla_notebook,
           bn.bateria_notebook
    FROM notebook p
    LEFT JOIN cpu_notebook cp ON p.id_notebook = cp.id_notebook
    LEFT JOIN gpu_notebook gn ON p.id_notebook = gn.id_notebook
    LEFT JOIN pantalla_notebook pn ON p.id_notebook = pn.id_notebook
    LEFT JOIN bateria_notebook bn ON p.id_notebook = bn.id_notebook
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
    <h1 class="mb-4">Ingreso de Notebook</h1>

    <!-- Formulario para insertar notebook -->
    <form action="ingresar_notebook.php" method="POST" class="mb-4">
        <!-- Menú desplegable para seleccionar el tipo de hardware -->
        <div class="mb-3">
            <label for="tipo_notebook" class="form-label">Tipo de notebook</label>
            <select name="tipo_notebook" id="tipo_notebook" class="form-select" required onchange="mostrarCamposNotebook()">
                <option value="" selected disabled>Seleccione un tipo de notebook</option>
                <option value="cpu_notebook">CPU Notebook</option>
                <option value="gpu_notebook">GPU Notebook</option>
                <option value="pantalla_notebook">Pantalla Notebook</option>
                <option value="bateria_notebook">Bateria Notebook</option>
            </select>
        </div>

        <!-- Campos (Ocultos inicialmente) -->
        <div class="mb-3" id="camposCpu_notebook" style="display: none;">       
            <label for="cpu_notebook" class="form-label mt-3">CPU Notebook</label>
            <input type="text" name="cpu_notebook" class="form-control" id="cpu_notebook">
        </div>
        <div class="mb-3" id="camposGpu_notebook" style="display: none;">       
            <label for="gpu_notebook" class="form-label mt-3">GPU Notebook</label>
            <input type="text" name="gpu_notebook" class="form-control" id="gpu_notebook">
        </div>

        <div class="mb-3" id="camposPantalla_notebook" style="display: none;">       
            <label for="pantalla_notebook" class="form-label mt-3">Pantalla Notebook</label>
            <input type="text" name="pantalla_notebook" class="form-control" id="pantalla_notebook">
        </div>

        <div class="mb-3" id="camposBateria_notebook" style="display: none;">       
            <label for="bateria_notebook" class="form-label mt-3">Bateria Notebook</label>
            <input type="text" name="bateria_notebook" class="form-control" id="bateria_notebook">
        </div>

        <button type="submit" class="btn btn-primary mt-3">Guardar Notebook</button>
        <button class="btn btn-secondary mt-3" onclick="window.location.href='admin_panel.php';">Volver a Inicio</button>
    </form>

    <!-- Tabla para mostrar los datos guardados -->
    <h2 class="mb-4">Notebooks Registrados</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID Notebook</th>
                <th>CPU Notebook</th>
                <th>GPU Notebook</th>
                <th>Pantalla Notebook</th>
                <th>Bateria Notebook</th>
                <th>Acciones</th> <!-- Nueva columna para botones -->
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                <tr>
                    <td><?php echo $row['id_notebook']; ?></td>
                    <td><?php echo $row['cpu_notebook']; ?></td>
                    <td><?php echo $row['gpu_notebook']; ?></td>
                    <td><?php echo $row['pantalla_notebook']; ?></td>
                    <td><?php echo $row['bateria_notebook']; ?></td>
                    <td>
                        <a href="modificar_notebook.php?id_notebook=<?php echo $row['id_notebook']; ?>">Modificar</a> | 
                        <a href="eliminar_notebook.php?id_notebook=<?php echo $row['id_notebook']; ?>">Eliminar</a>
                    </td> <!-- Botones de acción -->
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<!-- JavaScript para mostrar los campos adicionales dinámicamente -->
<script>
    function mostrarCamposNotebook() {
        var tipoNotebook = document.getElementById("tipo_notebook").value;

        // Ocultar todos los campos inicialmente
        document.getElementById("camposCpu_notebook").style.display = "none";
        document.getElementById("camposGpu_notebook").style.display = "none";
        document.getElementById("camposPantalla_notebook").style.display = "none";
        document.getElementById("camposBateria_notebook").style.display = "none";


        // Mostrar solo los campos correspondientes al tipo de hardware seleccionado
        if (tipoNotebook === "cpu_notebook") {
            document.getElementById("camposCpu_notebook").style.display = "block";

        } else if (tipoNotebook === "gpu_notebook") {
            document.getElementById("camposGpu_notebook").style.display = "block";
        } 

        else if (tipoNotebook === "pantalla_notebook") {
            document.getElementById("camposPantalla_notebook").style.display = "block";
        } 

        else if (tipoNotebook === "bateria_notebook") {
            document.getElementById("camposBateria_notebook").style.display = "block";
        } 
        

        
        // Agregar más condiciones si se agregan más tipos de hardware
    }
</script>

</body>
</html>