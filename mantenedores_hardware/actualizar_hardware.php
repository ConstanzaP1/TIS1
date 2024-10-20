<?php
require('../conexion.php');

// Obtener los datos del formulario
$id_hardware = $_POST['id_hardware'];
$tipo_hardware = $_POST['tipo_hardware'];

// Procesar los datos según el tipo de periférico
if ($tipo_hardware == 'memoria') {
    $memoria = $_POST['memoria'];
    $query = "UPDATE memoria SET memoria = '$memoria' WHERE id_hardware = '$id_hardware'";

} elseif ($tipo_hardware == 'memoria_gpu') {
    $memoria_gpu = $_POST['memoria_gpu'];
    $query = "UPDATE memoria_gpu SET memoria_gpu = '$memoria_gpu' WHERE id_hardware = '$id_hardware'";

} elseif ($tipo_hardware == 'frecuencia_gpu') {
    $frecuencia_gpu = $_POST['frecuencia_gpu'];
    $query = "UPDATE frecuencia_gpu SET frecuencia_gpu = '$frecuencia_gpu' WHERE id_hardware = '$id_hardware'";

} elseif ($tipo_hardware == 'frecuencia_cpu') {
    $frecuencia_cpu = $_POST['frecuencia_cpu'];
    $query = "UPDATE frecuencia_cpu SET frecuencia_cpu = '$frecuencia_cpu' WHERE id_hardware = '$id_hardware'";

} elseif ($tipo_hardware == 'socket_cpu') {
    $socket_cpu = $_POST['socket_cpu'];
    $query = "UPDATE socket_cpu SET socket_cpu = '$socket_cpu' WHERE id_hardware = '$id_hardware'";

} elseif ($tipo_hardware == 'nucleo_hilo_cpu') {
    $nucleo_hilo_cpu = $_POST['nucleo_hilo_cpu'];
    $query = "UPDATE nucleo_hilo_cpu SET nucleo_hilo_cpu = '$nucleo_hilo_cpu' WHERE id_hardware = '$id_hardware'";

} elseif ($tipo_hardware == 'socket_placa') {
    $socket_placa = $_POST['socket_placa'];
    $query = "UPDATE socket_placa SET socket_placa = '$socket_placa' WHERE id_hardware = '$id_hardware'";

} elseif ($tipo_hardware == 'slot_memoria_placa') {
    $slot_memoria_placa = $_POST['slot_memoria_placa'];
    $query = "UPDATE slot_memoria_placa SET slot_memoria_placa = '$slot_memoria_placa' WHERE id_hardware = '$id_hardware'";

} elseif ($tipo_hardware == 'formato_ram') {
    $formato_ram = $_POST['formato_ram'];
    $query = "UPDATE formato_ram SET formato_ram = '$formato_ram' WHERE id_hardware = '$id_hardware'";

} elseif ($tipo_hardware == 'velocidad_ram') {
    $velocidad_ram = $_POST['velocidad_ram'];
    $query = "UPDATE velocidad_ram SET velocidad_ram = '$velocidad_ram' WHERE id_hardware = '$id_hardware'";

} 
elseif ($tipo_hardware == 'capacidad_almacenamiento') {
    $capacidad_almacenamiento = $_POST['capacidad_almacenamiento'];
    $query = "UPDATE capacidad_almacenamiento SET capacidad_almacenamiento = '$capacidad_almacenamiento' WHERE id_hardware = '$id_hardware'";

}
elseif ($tipo_hardware == 'formato_placa') {
    $formato_placa = $_POST['formato_placa'];
    $query = "UPDATE formato_placa SET formato_placa = '$formato_placa' WHERE id_hardware = '$id_hardware'";

}
elseif ($tipo_hardware == 'capacidad_ram') {
    $capacidad_ram = $_POST['capacidad_ram'];
    $query = "UPDATE capacidad_ram SET capacidad_ram = '$capacidad_ram' WHERE id_hardware = '$id_hardware'";

} elseif ($tipo_hardware == 'tipo_ram') {
    $tipo_ram = $_POST['tipo_ram'];
    $query = "UPDATE tipo_ram SET tipo_ram = '$tipo_ram' WHERE id_hardware = '$id_hardware'";
}
elseif ($tipo_hardware == 'certificacion_fuente') {
    $certificacion_fuente = $_POST['certificacion_fuente'];
    $query = "UPDATE certificacion_fuente SET certificacion_fuente = '$certificacion_fuente' WHERE id_hardware = '$id_hardware'";

}elseif ($tipo_hardware == 'tipo_cableado') {
    $tipo_cableado = $_POST['tipo_cableado'];
    $query = "UPDATE tipo_cableado SET tipo_cableado = '$tipo_cableado' WHERE id_hardware = '$id_hardware'";

}elseif ($tipo_hardware == 'tamanio_fuente') {
    $tamanio_fuente = $_POST['tamanio_fuente'];
    $query = "UPDATE tamanio_fuente SET tamanio_fuente = '$tamanio_fuente' WHERE id_hardware = '$id_hardware'";

}elseif ($tipo_hardware == 'potencia_fuente') {
    $potencia_fuente = $_POST['potencia_fuente'];
    $query = "UPDATE potencia_fuente SET potencia_fuente = '$potencia_fuente' WHERE id_hardware = '$id_hardware'";

}elseif ($tipo_hardware == 'tamanio_placa') {
    $tamanio_placa = $_POST['tamanio_placa'];
    $query = "UPDATE tamanio_placa SET tamanio_placa = '$tamanio_placa' WHERE id_hardware = '$id_hardware'";
}elseif ($tipo_hardware == 'tamanio_max_gabinete') {
    $tamanio_max_gabinete = $_POST['tamanio_max_gabinete'];
    $query = "UPDATE tamanio_max_gabinete SET tamanio_max_gabinete = '$tamanio_max_gabinete' WHERE id_hardware = '$id_hardware'";
}



// Ejecutar la consulta
mysqli_query($conexion, $query);

// Verificar si la consulta se ejecutó correctamente
if (mysqli_affected_rows($conexion) > 0) {
    // Redireccionar a la página de inicio
    header('Location: ../admin_panel.php');
    exit;
} else {
    // Mostrar un mensaje de error
    echo "Error al actualizar el periférico.";
    exit;
}
?>