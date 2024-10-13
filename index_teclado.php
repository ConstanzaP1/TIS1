<?php
require('conexion.php');

// Consulta para obtener datos de la tabla categoria_teclado que no sean NULL
$queryCategoria = "
    SELECT p.id_periferico, 
           ct.categoria_teclado
    FROM periferico p
    LEFT JOIN categoria_teclado ct ON p.id_periferico = ct.id_periferico
    WHERE ct.categoria_teclado IS NOT NULL
";

$resultCategoria = mysqli_query($conexion, $queryCategoria);

// Consulta para obtener datos de la tabla tipo_teclado que no sean NULL
$queryTipo = "
    SELECT p.id_periferico, 
           tt.tipo_teclado
    FROM periferico p
    LEFT JOIN tipo_teclado tt ON p.id_periferico = tt.id_periferico
    WHERE tt.tipo_teclado IS NOT NULL
";

$resultTipo = mysqli_query($conexion, $queryTipo);
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
    <h1 class="mb-4">Ingreso de mantenedores teclado</h1>

    <!-- Formulario para insertar periferico -->
    <form action="ingresar_periferico.php" method="POST" class="mb-4">
        <!-- Menú desplegable para seleccionar el tipo de periferico -->
        <div class="mb-3">
            <label for="tipo_periferico" class="form-label">Tipo de Periferico</label>
            <select name="tipo_periferico" id="tipo_periferico" class="form-select" required onchange="mostrarCamposPeriferico()">
                <option value="" selected disabled>Seleccione un tipo de teclado</option>
                <option value="categoria_teclado">Categoria teclado</option>
                <option value="tipo_teclado">Tipo teclado</option>
            </select>
        </div>

        <!-- Campos (Ocultos inicialmente) -->
        <div class="mb-3" id="campoCategoria_teclado" style="display: none;">       
            <label for="categoria_teclado" class="form-label mt-3">Categoria teclado</label>
            <input type="text" name="categoria_teclado" class="form-control" id="categoria_teclado">
        </div>
        <div class="mb-3" id="campoTipo_teclado" style="display: none;">       
            <label for="tipo_teclado" class="form-label mt-3">Tipo teclado</label>
            <input type="text" name="tipo_teclado" class="form-control" id="tipo_teclado">
        </div>
        <button type="submit" class="btn btn-success mt-3">Guardar tipo teclado</button>
        <button class="btn btn-secondary mt-3" onclick="window.location.href='index.php';">Volver a Inicio</button>
    </form>

    <div class="container">
        <div class="row">
            <div class="col">
                <h2>Categoria teclado</h2>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID Periferico</th>
                            <th>Categoria Teclado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($rowCategoria = mysqli_fetch_assoc($resultCategoria)) : ?>
                            <tr>
                                <td><?php echo $rowCategoria['id_periferico']; ?></td>
                                <td><?php echo $rowCategoria['categoria_teclado']; ?></td>
                                <td>
                                    <button class="btn btn-primary" onclick="window.location.href='modificar_periferico.php?id_periferico=<?php echo $rowCategoria['id_periferico']; ?>';">Modificar</button>
                                    <button class="btn btn-danger" onclick="window.location.href='eliminar_periferico.php?id_periferico=<?php echo $rowCategoria['id_periferico']; ?>';">Eliminar</button>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>

            <div class="col">
                <h2>Tipo teclado</h2>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID Periferico</th>
                            <th>Tipo Teclado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($rowCategoria = mysqli_fetch_assoc($resultTipo)) : ?>
                            <tr>
                                <td><?php echo $rowCategoria['id_periferico']; ?></td>
                                <td><?php echo $rowCategoria['tipo_teclado']; ?></td>
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

        document.getElementById("campoCategoria_teclado").style.display = "none";
        document.getElementById("campoTipo_teclado").style.display = "none";

        if (tipoPeriferico === "categoria_teclado") {
            document.getElementById("campoCategoria_teclado").style.display = "block";
        } else if (tipoPeriferico === "tipo_teclado") {
            document.getElementById("campoTipo_teclado").style.display = "block";
        }
    }
</script>
</body>
</html>
