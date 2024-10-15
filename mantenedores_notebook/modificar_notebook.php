<?php
require('../conexion.php');

// Obtener el ID del periférico a modificar
$id_notebook = $_GET['id_notebook'];

// Consultar la base de datos para obtener los datos actuales del periférico
$query = "SELECT * FROM notebook p
          LEFT JOIN cpu_notebook cp ON p.id_notebook = cp.id_notebook
          LEFT JOIN gpu_notebook gn ON p.id_notebook = gn.id_notebook
          LEFT JOIN pantalla_notebook pn ON p.id_notebook = pn.id_notebook
          LEFT JOIN bateria_notebook bn ON p.id_notebook = bn.id_notebook
          WHERE p.id_notebook = '$id_notebook'";

$result = mysqli_query($conexion, $query);
$row = mysqli_fetch_assoc($result);

// Mostrar un formulario con los datos actuales para que el usuario pueda modificarlos
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Notebook</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h1 class="mb-4">Modificar Notebook</h1>

    <!-- Formulario para modificar periférico -->
    <form action="actualizar_notebook.php" method="POST" class="mb-4">
        <!-- Campos oculto para el ID del periférico -->
        <input type="hidden" name="id_notebook" value="<?php echo $id_notebook; ?>">

        <!-- Menú desplegable para seleccionar el tipo de periférico -->
        <div class="mb-3" style="display: none;">
            <label for="tipo_notebook" class="form-label">Tipo de Notebook</label>
            <select name="tipo_notebook" id="tipo_notebook" class="form-select" required>
                <option value="" selected disabled>Seleccione un tipo de Notebook</option>
                <option value="cpu_notebook" <?php if ($row['cpu_notebook']) echo 'selected'; ?>>Cpu Notebook</option>
                <option value="gpu_notebook" <?php if ($row['gpu_notebook']) echo 'selected'; ?>>Gpu Notebook</option>
                <option value="pantalla_notebook" <?php if ($row['pantalla_notebook']) echo 'selected'; ?>>Pantalla Notebook</option>
                <option value="bateria_notebook" <?php if ($row['bateria_notebook']) echo 'selected'; ?>>Bateria Notebook</option>
            </select>
        </div>
                 <!-- Camposs (Ocultos inicialmente) -->
        <div class="mb-3" id="camposCpu_notebook" style="display: none;">       
            <label for="cpu_notebook" class="form-label mt-3">cpu_notebook</label>
            <input type="text" name="cpu_notebook" class="form-control" id="cpu_notebook" value="<?php echo $row['cpu_notebook']; ?>">
        </div>
        <div class="mb-3" id="camposGpu_notebook" style="display: none;">       
            <label for="gpu_notebook" class="form-label mt-3">Gpu Notebook</label>
            <input type="text" name="gpu_notebook" class="form-control" id="gpu_notebook" value="<?php echo $row['gpu_notebook']; ?>">
        </div>
        <div class="mb-3" id="camposPantalla_notebook" style="display: none;">       
            <label for="pantalla_notebook" class="form-label mt-3">Pantalla Notebook</label>
            <input type="text" name="pantalla_notebook" class="form-control" id="pantalla_notebook" value="<?php echo $row['pantalla_notebook']; ?>">
        </div>
        <div class="mb-3" id="camposBateria_notebook" style="display: none;">       
            <label for="bateria_notebook" class="form-label mt-3">Bateria Notebook</label>
            <input type="text" name="bateria_notebook" class="form-control" id="bateria_notebook" value="<?php echo $row['bateria_notebook']; ?>">
        </div>
        <button type="submit" class="btn btn-primary mt-3">Guardar cambios</button>
    </form>

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

        // Llamar a la función al cargar la página
        window.onload = function() {
            mostrarCamposNotebook();
        };

        // Llamar a la función al cambiar el valor del select
        document.getElementById("tipo_notebook").addEventListener("change", mostrarCamposNotebook);
    </script>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>