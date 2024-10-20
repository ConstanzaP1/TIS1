<?php
require('conexion.php');

// Verifica si se recibió el ID del periférico
if (isset($_GET['id_periferico'])) {
    $id_periferico = mysqli_real_escape_string($conexion, $_GET['id_periferico']);

    // Eliminar de todas las tablas relacionadas, dependiendo de su existencia
    $tablas = [
        'conectividad', 'sensor_mouse', 'dpi_mouse', 
        'categoria_teclado', 'tipo_teclado', 'tipo_audifono', 
        'tipo_microfono', 'tamanio_monitor', 'resolucion_monitor', 
        'tipo_curvatura', 'tiempo_respuesta', 'tipo_panel'
    ];

    foreach ($tablas as $tabla) {
        $queryEliminar = "DELETE FROM $tabla WHERE id_periferico='$id_periferico'";
        if (!mysqli_query($conexion, $queryEliminar)) {
            echo "Error al eliminar de la tabla $tabla: " . mysqli_error($conexion);
        }
    }

    // Finalmente, eliminamos el periférico en sí
    $queryEliminarPeriferico = "DELETE FROM periferico WHERE id_periferico='$id_periferico'";

    if (mysqli_query($conexion, $queryEliminarPeriferico)) {
        echo "Periférico eliminado exitosamente.";
        header('location: admin_panel.php');
        exit();
    } else {
        echo "Error al eliminar el periférico: " . mysqli_error($conexion);
    }
} else {
    echo "No se proporcionó un ID válido.";
}
?>
