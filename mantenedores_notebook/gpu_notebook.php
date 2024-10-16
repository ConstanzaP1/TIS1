<?php
require('../conexion.php');

// Consulta para obtener datos de la tabla gpu_notebook que no sean NULL
$query = "
    SELECT p.id_notebook, 
           gn.gpu_notebook
    FROM notebook p
    LEFT JOIN gpu_notebook gn ON p.id_notebook = gn.id_notebook
    WHERE gn.gpu_notebook IS NOT NULL
";

$result = mysqli_query($conexion, $query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ingreso de Mantenedores</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script>
        // Función para mostrar el formulario y ocultar la tabla
        function mostrarFormulario() {
            document.getElementById('formulario').style.display = 'block';  // Mostrar el formulario
            document.getElementById('botonAgregar').style.display = 'none';  // Ocultar el botón de "Agregar"
            document.getElementById('tabla').style.display = 'none';  // Ocultar la tabla
            document.getElementById('botonVolverInicio').style.display = 'none'; // Ocultar el botón de volver al inicio fuera del formulario
        }
    </script>
</head>
<body>

<div class="container mt-5">
    <div class="container" id="tabla">
        <div class="row">
            <div class="col">
                <h2>Gpu notebook</h2>
                <table class="table table-bordered mt-4">
                    <thead>
                        <tr>
                            <th>Gpu notebook</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($rowCategoria = mysqli_fetch_assoc($result)) : ?>
                            <tr>
                                <td><?php echo $rowCategoria['gpu_notebook']; ?></td>
                                <td>
                                    <button class="btn btn-primary" onclick="window.location.href='modificar_notebook.php?id_notebook=<?php echo $rowCategoria['id_notebook']; ?>';">Modificar</button>
                                    <button class="btn btn-danger" onclick="window.location.href='eliminar_notebook.php?id_notebook=<?php echo $rowCategoria['id_notebook']; ?>';">Eliminar</button>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <button type="button" id="botonAgregar" class="btn btn-primary" onclick="mostrarFormulario()">Agregar</button>

    <button type="button" id="botonVolverInicio" class="btn btn-secondary" onclick="window.location.href='../index.php';">Volver a Inicio</button>

    <!-- Formulario para insertar -->
    <form action="ingresar_notebook.php" method="POST" id="formulario" style="display: none;" class="mt-4">
        <h1 class="mb-4">Ingreso de Gpu notebook</h1>
        <!-- Campo oculto para seleccionar automaticamente "Gpu notebook" -->
        <input type="hidden" name="tipo_notebook" value="gpu_notebook">

        <div class="mb-3">       
            <label for="gpu_notebook" class="form-label mt-3">Gpu notebook</label>
            <input type="text" name="gpu_notebook" class="form-control" id="gpu_notebook" required>
        </div>

        <!-- Contenedor para alinear los botones -->
        <div class="d-flex justify-content-between mt-3">
            <!-- Botón de guardar -->
            <button type="submit" class="btn btn-success">Guardar</button>
            
            <!-- Botón para volver al inicio al lado del botón de guardar -->
            <button type="button" class="btn btn-secondary" onclick="window.location.href='../index.php';">Volver a Inicio</button>
        </div>
    </form>
</div>
</body>
</html>
