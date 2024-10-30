<?php
require('../conexion.php');

// Recoger los datos generales del formulario
$nombre_producto = mysqli_real_escape_string($conexion, $_POST['nombre_producto']);
$nombre_marca = mysqli_real_escape_string($conexion, $_POST['nombre_marca']);
$precio = mysqli_real_escape_string($conexion, $_POST['precio']);
$cantidad = mysqli_real_escape_string($conexion, $_POST['cantidad']);
$categoria_producto = mysqli_real_escape_string($conexion, $_POST['categoria_producto']); // Ejemplo: 'teclado', 'monitor', 'audifono', etc.
$imagen_url = mysqli_real_escape_string($conexion, $_POST['imagen_url']);

// Insertar los datos generales del producto en la tabla producto
$query_producto = "INSERT INTO producto (nombre_producto, precio, cantidad, tipo_producto, marca, imagen_url) 
                   VALUES ('$nombre_producto', '$precio', '$cantidad', '$categoria_producto', '$nombre_marca', '$imagen_url')";
if (mysqli_query($conexion, $query_producto)) {
    // Obtener el id del último producto insertado
    $id_producto = mysqli_insert_id($conexion);

    // Crear un array vacío para almacenar los atributos
    $caracteristicas = [];

    // Verificar los atributos dependiendo de la categoría del producto
    if ($categoria_producto == 'teclado') {
        if (isset($_POST['tipo_teclado'])) $caracteristicas['tipo_teclado'] = $_POST['tipo_teclado'];
        if (isset($_POST['tipo_switch'])) $caracteristicas['tipo_switch'] = $_POST['tipo_switch'];
        if (isset($_POST['conectividad'])) $caracteristicas['conectividad'] = $_POST['conectividad'];
        if (isset($_POST['iluminacion'])) $caracteristicas['iluminacion'] = $_POST['iluminacion'];
        if (isset($_POST['categoria_teclado'])) $caracteristicas['categoria_teclado'] = $_POST['categoria_teclado'];

    } elseif ($categoria_producto == 'monitor') {
        if (isset($_POST['resolucion_monitor'])) $caracteristicas['resolucion_monitor'] = $_POST['resolucion_monitor'];
        if (isset($_POST['tamanio_monitor'])) $caracteristicas['tamanio_monitor'] = $_POST['tamanio_monitor'];
        if (isset($_POST['tasa_refresco'])) $caracteristicas['tasa_refresco'] = $_POST['tasa_refresco'];
        if (isset($_POST['tiempo_respuesta'])) $caracteristicas['tiempo_respuesta'] = $_POST['tiempo_respuesta'];
        if (isset($_POST['soporte_monitor'])) $caracteristicas['soporte_monitor'] = $_POST['soporte_monitor'];
        if (isset($_POST['tipo_panel'])) $caracteristicas['tipo_panel'] = $_POST['tipo_panel'];
        if (isset($_POST['tipo_curvatura'])) $caracteristicas['tipo_curvatura'] = $_POST['tipo_curvatura'];

    } elseif ($categoria_producto == 'audifono') {
        if (isset($_POST['tipo_audifono'])) $caracteristicas['tipo_audifono'] = $_POST['tipo_audifono'];
        if (isset($_POST['tipo_microfono'])) $caracteristicas['tipo_microfono'] = $_POST['tipo_microfono'];
        if (isset($_POST['anc'])) $caracteristicas['anc'] = $_POST['anc'];
        if (isset($_POST['conectividad'])) $caracteristicas['conectividad'] = $_POST['conectividad'];
        if (isset($_POST['iluminacion'])) $caracteristicas['iluminacion'] = $_POST['iluminacion'];

    } elseif ($categoria_producto == 'mouse') {
        if (isset($_POST['dpi_mouse'])) $caracteristicas['dpi_mouse'] = $_POST['dpi_mouse'];
        if (isset($_POST['peso_mouse'])) $caracteristicas['peso_mouse'] = $_POST['peso_mouse'];
        if (isset($_POST['sensor_mouse'])) $caracteristicas['sensor_mouse'] = $_POST['sensor_mouse'];
        if (isset($_POST['iluminacion'])) $caracteristicas['iluminacion'] = $_POST['iluminacion'];
        if (isset($_POST['conectividad'])) $caracteristicas['conectividad'] = $_POST['conectividad'];

    } elseif ($categoria_producto == 'cpu') {
        if (isset($_POST['frecuencia_cpu'])) $caracteristicas['frecuencia_cpu'] = $_POST['frecuencia_cpu'];
        if (isset($_POST['nucleo_hilo_cpu'])) $caracteristicas['nucleo_hilo_cpu'] = $_POST['nucleo_hilo_cpu'];
        if (isset($_POST['socket_cpu'])) $caracteristicas['socket_cpu'] = $_POST['socket_cpu'];

    } elseif ($categoria_producto == 'gpu') {
        if (isset($_POST['frecuencia_gpu'])) $caracteristicas['frecuencia_gpu'] = $_POST['frecuencia_gpu'];
        if (isset($_POST['memoria_gpu'])) $caracteristicas['memoria_gpu'] = $_POST['memoria_gpu'];

    } elseif ($categoria_producto == 'ram') {
        if (isset($_POST['tipo_ram'])) $caracteristicas['tipo_ram'] = $_POST['tipo_ram'];
        if (isset($_POST['velocidad_ram'])) $caracteristicas['velocidad_ram'] = $_POST['velocidad_ram'];
        if (isset($_POST['capacidad_ram'])) $caracteristicas['capacidad_ram'] = $_POST['capacidad_ram'];
        if (isset($_POST['formato_ram'])) $caracteristicas['formato_ram'] = $_POST['formato_ram'];

    } elseif ($categoria_producto == 'placa') {
        if (isset($_POST['formato_placa'])) $caracteristicas['formato_placa'] = $_POST['formato_placa'];
        if (isset($_POST['slot_memoria_placa'])) $caracteristicas['slot_memoria_placa'] = $_POST['slot_memoria_placa'];
        if (isset($_POST['socket_placa'])) $caracteristicas['socket_placa'] = $_POST['socket_placa'];
        if (isset($_POST['chipset_placa'])) $caracteristicas['chipset_placa'] = $_POST['chipset_placa'];

    } elseif ($categoria_producto == 'fuente') {
        if (isset($_POST['certificacion_fuente'])) $caracteristicas['certificacion_fuente'] = $_POST['certificacion_fuente'];
        if (isset($_POST['potencia_fuente'])) $caracteristicas['potencia_fuente'] = $_POST['potencia_fuente'];
        if (isset($_POST['tamanio_fuente'])) $caracteristicas['tamanio_fuente'] = $_POST['tamanio_fuente'];

    } elseif ($categoria_producto == 'gabinete') {
        if (isset($_POST['tamanio_max_gabinete'])) $caracteristicas['tamanio_max_gabinete'] = $_POST['tamanio_max_gabinete'];
        if (isset($_POST['iluminacion'])) $caracteristicas['iluminacion'] = $_POST['iluminacion'];

    } elseif ($categoria_producto == 'notebook') {
        if (isset($_POST['bateria_notebook'])) $caracteristicas['bateria_notebook'] = $_POST['bateria_notebook'];
        if (isset($_POST['cpu_notebook'])) $caracteristicas['cpu_notebook'] = $_POST['cpu_notebook'];
        if (isset($_POST['gpu_notebook'])) $caracteristicas['gpu_notebook'] = $_POST['gpu_notebook'];
        if (isset($_POST['capacidad_ram'])) $caracteristicas['capacidad_ram'] = $_POST['capacidad_ram'];
        if (isset($_POST['pantalla_notebook'])) $caracteristicas['pantalla_notebook'] = $_POST['pantalla_notebook'];

    }

    // Insertar cada atributo y su valor en la tabla producto_atributo
    foreach ($caracteristicas as $caracteristica => $valor_caracteristica) {
        $query_caracteristica = "INSERT INTO producto_caracteristica (id_producto, caracteristica, valor_caracteristica) 
                           VALUES ('$id_producto', '$caracteristica', '$valor_caracteristica')";
        mysqli_query($conexion, $query_caracteristica);
    }

    echo "Producto y caracteristicas insertados correctamente.";
    ?>

    <button type="button" class="btn btn-primary" onclick="window.location.href='../admin_panel/admin_panel.php';">Aceptar</button>
    <?php
} else {
    echo "Error al insertar el producto: " . mysqli_error($conexion);
}
?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">