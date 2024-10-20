<?php
require('../conexion.php');

// Verifica si se recibió el ID del periférico
if (isset($_GET['id_hardware'])) {
    $id_hardware = mysqli_real_escape_string($conexion, $_GET['id_hardware']);

    // Eliminar de todas las tablas relacionadas, dependiendo de su existencia
    $tablas = [
        'memoria', 'memoria_gpu', 'frecuencia_gpu', 
        'frecuencia_cpu','socket_cpu','nucleo_hilo_cpu',
        'socket_placa','slot_memoria_placa','formato_ram',
        'velocidad_ram','capacidad_almacenamiento','formato_placa',
        'capacidad_ram','tipo_ram','certificacion_fuente',
        'tipo_cableado','tamanio_fuente','potencia_fuente',
        'tamanio_placa', 'tamanio_max_gabinete'
    ];

    foreach ($tablas as $tabla) {
        $queryEliminar = "DELETE FROM $tabla WHERE id_hardware='$id_hardware'";
        if (!mysqli_query($conexion, $queryEliminar)) {
            echo "Error al eliminar de la tabla $tabla: " . mysqli_error($conexion);
        }
    }

    // Finalmente, eliminamos el periférico en sí
    $queryEliminarHardware = "DELETE FROM hardware WHERE id_hardware='$id_hardware'";

    if (mysqli_query($conexion, $queryEliminarHardware)) {
        echo "Hardware eliminado exitosamente.";
        header('location: ../admin_panel.php');
        exit();
    } else {
        echo "Error al eliminar el hardware: " . mysqli_error($conexion);
    }
} else {
    echo "No se proporcionó un ID válido.";
}
?>