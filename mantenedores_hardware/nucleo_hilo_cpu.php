<?php
require('../conexion.php');

// Consulta para obtener datos de la tabla nucleo_hilo_cpu que no sean NULL
$query = "
    SELECT p.id_hardware, 
           nhc.nucleo_hilo_cpu
    FROM hardware p
    LEFT JOIN nucleo_hilo_cpu nhc ON p.id_hardware = nhc.id_hardware
    WHERE nhc.nucleo_hilo_cpu IS NOT NULL
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
    <!-- Tabla de categorías, visible por defecto, pero se oculta al agregar una nueva categoría -->
    <div class="container mt-5" id="tabla">
        <div class="row">
            <div class="col">
                <h2>Nucleos / Hilos CPU</h2>
                <table class="table table-bordered mt-4">
                    <thead>
                        <tr>
                            <th>Nucleos / Hilos CPU</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                            <tr>
                                <td><?php echo $row['nucleo_hilo_cpu']; ?></td>
                                <td>
                                    <button class="btn btn-primary" onclick="window.location.href='modificar_hardware.php?id_hardware=<?php echo $row['id_hardware']; ?>';">Modificar</button>
                                    <button class="btn btn-danger" onclick="window.location.href='eliminar_hardware.php?id_hardware=<?php echo $row['id_hardware']; ?>';">Eliminar</button>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Botón para mostrar el formulario -->
    <button type="button" id="botonAgregar" class="btn btn-primary" onclick="mostrarFormulario()">Agregar</button>

    <!-- Botón para volver al inicio que siempre aparece cuando la tabla está visible -->
    <button type="button" id="botonVolverInicio" class="btn btn-secondary" onclick="window.location.href='../index.php';">Volver a Inicio</button>

    <!-- Formulario oculto inicialmente -->
    <form action="ingresar_hardware.php" method="POST" id="formulario" style="display: none;" class="mt-4">
        <h1 class="mb-4">Ingreso de Nucleos / Hilos CPU</h1>
        <!-- Campo oculto para seleccionar automáticamente-->
        <input type="hidden" name="tipo_hardware" value="nucleo_hilo_cpu">

        <div class="mb-3">
            <label for="nucleo_hilo_cpu" class="form-label">Nucleos / Hilos CPU</label>
            <input type="text" name="nucleo_hilo_cpu" class="form-control" id="nucleo_hilo_cpu" required>
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
