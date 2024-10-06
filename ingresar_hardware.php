<?php
require('conexion.php');

// Si se envía el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tipo_hardware = $_POST['tipo_hardware'];

    // Insertar solo el ID (auto-incremental) en la tabla hardware
    $queryHardware = "INSERT INTO hardware () VALUES ()"; // No especificamos id_hardware

    if (mysqli_query($conexion, $queryHardware)) {
        // Obtener el último id_hardware insertado
        $id_hardware = mysqli_insert_id($conexion);

        // Dependiendo del tipo de hardware, insertamos los valores en las tablas correspondientes
        if ($tipo_hardware == 'memoria_gpu') {
            $memoria_gpu = $_POST['memoria_gpu'];

            // Insertar en las tablas asociadas para tarjetas de video
            $queryMemoriaGPU = "INSERT INTO memoria_gpu (id_hardware, memoria_gpu) VALUES ('$id_hardware', '$memoria_gpu')";

            if (mysqli_query($conexion, $queryMemoriaGPU)) {
                echo "Memoria de GPU agregadas exitosamente.";
                header('location: index.php');
            } else {
                echo "Error al insertar datos de GPU: " . mysqli_error($conexion);   
            }
            
        } elseif ($tipo_hardware == 'frecuencia_gpu') {
            $frecuencia_gpu = $_POST['frecuencia_gpu'];
            // Insertar en las tablas asociadas para procesadores
            $queryFrecuenciaGPU = "INSERT INTO frecuencia_gpu (id_hardware, frecuencia_gpu) VALUES ('$id_hardware', '$frecuencia_gpu')";

            if (mysqli_query($conexion, $queryFrecuenciaGPU)) {
                echo "Frecuencia de GPU agregados exitosamente.";
            } else {
                echo "Error al insertar datos de CPU: " . mysqli_error($conexion);
            }
            header('location: index.php');
        } elseif ($tipo_hardware == 'frecuencia_cpu') {
            $frecuencia_cpu = $_POST['frecuencia_cpu'];
            // Insertar en las tablas asociadas para procesadores
            $queryFrecuenciaCPU = "INSERT INTO frecuencia_cpu (id_hardware, frecuencia_cpu) VALUES ('$id_hardware', '$frecuencia_cpu')";

            if (mysqli_query($conexion, $queryFrecuenciaCPU)) {
                echo "Frecuencia de GPU agregados exitosamente.";
            } else {
                echo "Error al insertar datos de CPU: " . mysqli_error($conexion);
            }
            header('location: index.php');
        } 
        // Agregar más bloques elseif para otros tipos de hardware (almacenamiento, fuente de poder, etc.)
    } else {
        echo "Error al insertar ID de hardware: " . mysqli_error($conexion);
    }
}
?>