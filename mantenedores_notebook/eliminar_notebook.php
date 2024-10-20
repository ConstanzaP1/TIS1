<?php
require('../conexion.php');

// Verifica si se recibió el ID del periférico
if (isset($_GET['id_notebook'])) {
    $id_notebook = mysqli_real_escape_string($conexion, $_GET['id_notebook']);

    // Eliminar de todas las tablas relacionadas, dependiendo de su existencia
    $tablas = [
        'cpu_notebook', 'gpu_notebook', 'pantalla_notebook', 
        'bateria_notebook'
    ];

    foreach ($tablas as $tabla) {
        $queryEliminar = "DELETE FROM $tabla WHERE id_notebook='$id_notebook'";
        if (!mysqli_query($conexion, $queryEliminar)) {
            echo "Error al eliminar de la tabla $tabla: " . mysqli_error($conexion);
        }
    }

    // Finalmente, eliminamos el periférico en sí
    $queryEliminarNotebook = "DELETE FROM notebook WHERE id_notebook='$id_notebook'";

    if (mysqli_query($conexion, $queryEliminarNotebook)) {
        echo "Periférico eliminado exitosamente.";
        header('location: ../admin_panel.php');
        exit();
    } else {
        echo "Error al eliminar el notebook: " . mysqli_error($conexion);
    }
} else {
    echo "No se proporcionó un ID válido.";
}
?>