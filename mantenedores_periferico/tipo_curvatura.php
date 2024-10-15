<?php
require('../conexion.php');

// Consulta para obtener datos de la tabla tipo_curvatura que no sean NULL
$query = "
    SELECT p.id_periferico, 
           tc.tipo_curvatura
    FROM periferico p
    LEFT JOIN tipo_curvatura tc ON p.id_periferico = tc.id_periferico
    WHERE tc.tipo_curvatura IS NOT NULL
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
    <div class="container mt-5" id="tabla">
        <div class="row">
            <div class="col">
                <h2>Tipo de Curvatura</h2>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Tipo de Curvatura</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($rowCategoria = mysqli_fetch_assoc($result)) : ?>
                            <tr>
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
        </div>
    </div>

    <!-- Botón para mostrar el formulario -->
    <button type="button" id="botonAgregar" class="btn btn-primary" onclick="mostrarFormulario()">Agregar Tipo de Curvatura</button>

    <!-- Botón para volver al inicio que siempre aparece cuando la tabla está visible -->
    <button type="button" id="botonVolverInicio" class="btn btn-secondary" onclick="window.location.href='../index.php';">Volver a Inicio</button>                        

    
    <!-- Formulario para insertar -->
    <form action="ingresar_periferico.php" method="POST" id="formulario" style="display: none;" class="mt-4">
        <h1 class="mb-4">Ingreso de tipos Audifono</h1>
        <!-- Campo oculto para seleccionar automaticamente -->
        <input type="hidden" name="tipo_periferico" value="tipo_curvatura">

        <div class="mb-3">       
            <label for="tipo_curvatura" class="form-label mt-3">Tipo de Curvatura</label>
            <input type="text" name="tipo_curvatura" class="form-control" id="tipo_curvatura" required>
        </div>

        <!-- Contenedor para alinear los botones -->
        <div class="d-flex justify-content-between mt-3">
            <!-- Botón de guardar -->
            <button type="submit" class="btn btn-success">Guardar Tipo de Curvatura</button>
            
            <!-- Botón para volver al inicio al lado del botón de guardar -->
            <button type="button" class="btn btn-secondary" onclick="window.location.href='../index.php';">Volver a Inicio</button>
        </div>
    </form>
</div>
</body>
</html>
