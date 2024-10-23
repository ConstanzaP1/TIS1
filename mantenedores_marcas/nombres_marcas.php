<?php
require('../conexion.php');

// Consulta para obtener datos de la tabla marca
$query = "
    SELECT id_marca, nombre_marca
    FROM marca
    WHERE nombre_marca IS NOT NULL
";

$result = mysqli_query($conexion, $query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ingreso de Marcas</title>
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
                <h2>Marcas</h2>
                <table class="table table-bordered mt-4">
                    <thead>
                        <tr>
                            <th>Marca</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($rowCategoria = mysqli_fetch_assoc($result)) : ?>
                            <tr>
                                <td><?php echo $rowCategoria['nombre_marca']; ?></td>
                                <td>
                                    <button class="btn btn-primary" onclick="window.location.href='modificar_marcas.php?id_marca=<?php echo $rowCategoria['id_marca']; ?>';">Modificar</button>
                                    <button class="btn btn-danger" onclick="window.location.href='eliminar_marcas.php?id_marca=<?php echo $rowCategoria['id_marca']; ?>';">Eliminar</button>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <button type="button" id="botonAgregar" class="btn btn-primary" onclick="mostrarFormulario()">Agregar</button>

    <button type="button" id="botonVolverInicio" class="btn btn-secondary" onclick="window.location.href='../admin_panel/admin_panel.php';">Volver</button>

    <!-- Formulario para insertar -->
    <form action="ingresar_marcas.php" method="POST" id="formulario" style="display: none;" class="mt-4">
        <h1 class="mb-4">Ingreso de Marca</h1>

        <div class="mb-3">
            <label for="nombre_marca" class="form-label mt-3">Nombre de la Marca</label>
            <input type="text" name="nombre_marca" class="form-control" id="nombre_marca" required>
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
