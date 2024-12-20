<?php
require('../conexion.php');

// Obtener los datos del producto
$id_producto = $_POST['id_producto'];
$nombre_producto = $_POST['nombre_producto'];
$nombre_marca = $_POST['nombre_marca'];
$precio = $_POST['precio'];
$cantidad = $_POST['cantidad'];
$categoria_producto = $_POST['categoria_producto'];
$imagen_url = $_POST['imagen_url'];
$costo = $_POST['costo'];

// Actualizar los datos generales del producto
$query_actualizar_producto = "UPDATE producto SET nombre_producto='$nombre_producto', marca='$nombre_marca', precio='$precio', cantidad='$cantidad', tipo_producto='$categoria_producto', imagen_url='$imagen_url', costo='$costo' WHERE id_producto='$id_producto'";
mysqli_query($conexion, $query_actualizar_producto);

// Características según el tipo de producto
$caracteristicas = [];

if ($categoria_producto === 'teclado') {
    $caracteristicas = [
        'tipo_teclado' => $_POST['tipo_teclado'],
        'tipo_switch' => $_POST['tipo_switch'],
        'conectividad' => $_POST['conectividad'],
        'iluminacion' => $_POST['iluminacion'],
        'categoria_teclado' => $_POST['categoria_teclado']
    ];
} elseif ($categoria_producto === 'monitor') {
    $caracteristicas = [
        'resolucion_monitor' => $_POST['resolucion_monitor'],
        'tamanio_monitor' => $_POST['tamanio_monitor'],
        'tasa_refresco' => $_POST['tasa_refresco'],
        'tiempo_respuesta' => $_POST['tiempo_respuesta'],
        'soporte_monitor' => $_POST['soporte_monitor'],
        'tipo_panel' => $_POST['tipo_panel'],
        'tipo_curvatura' => $_POST['tipo_curvatura']
    ];
} elseif ($categoria_producto === 'audifono') {
    $caracteristicas = [
        'tipo_audifono' => $_POST['tipo_audifono'],
        'tipo_microfono' => $_POST['tipo_microfono'],
        'anc' => $_POST['anc'],
        'conectividad' => $_POST['conectividad'],
        'iluminacion' => $_POST['iluminacion']
    ];
} elseif ($categoria_producto === 'mouse') {
    $caracteristicas = [
        'dpi_mouse' => $_POST['dpi_mouse'],
        'peso_mouse' => $_POST['peso_mouse'],
        'sensor_mouse' => $_POST['sensor_mouse'],
        'conectividad' => $_POST['conectividad'],
        'iluminacion' => $_POST['iluminacion']
    ];
} elseif ($categoria_producto === 'cpu') {
    $caracteristicas = [
        'frecuencia_cpu' => $_POST['frecuencia_cpu'],
        'nucleo_hilo_cpu' => $_POST['nucleo_hilo_cpu'],
        'socket_cpu' => $_POST['socket_cpu']
    ];
} elseif ($categoria_producto === 'gpu') {
    $caracteristicas = [
        'frecuencia_gpu' => $_POST['frecuencia_gpu'],
        'memoria_gpu' => $_POST['memoria_gpu'],
        'bus_de_entrada_gpu' => $_POST['bus_de_entrada_gpu'],
    ];
} elseif ($categoria_producto === 'ram') {
    $caracteristicas = [
        'tipo_ram' => $_POST['tipo_ram'],
        'velocidad_ram' => $_POST['velocidad_ram'],
        'capacidad_ram' => $_POST['capacidad_ram'],
        'formato_ram' => $_POST['formato_ram']
    ];
} elseif ($categoria_producto === 'ssd') {
    $caracteristicas = [
        'capacidad_almacenamiento' => $_POST['capacidad_almacenamiento'],
        'bus_ssd' => $_POST['bus_ssd'],
        'formato_ssd' => $_POST['formato_ssd']
    ];
} elseif ($categoria_producto === 'hdd') {
    $caracteristicas = [
        'capacidad_almacenamiento' => $_POST['capacidad_almacenamiento'],
        'bus_hdd' => $_POST['bus_hdd'],
        'rpm_hdd' => $_POST['rpm_hdd'],
        'tamanio_hdd' => $_POST['tamanio_hdd']
    ];
}elseif ($categoria_producto === 'placa') {
    $caracteristicas = [
        'formato_placa' => $_POST['formato_placa'],
        'slot_memoria_placa' => $_POST['slot_memoria_placa'],
        'socket_placa' => $_POST['socket_placa'],
        'chipset_placa' => $_POST['chipset_placa']
    ];
} elseif ($categoria_producto === 'fuente') {
    $caracteristicas = [
        'certificacion_fuente' => $_POST['certificacion_fuente'],
        'potencia_fuente' => $_POST['potencia_fuente'],
        'tamanio_fuente' => $_POST['tamanio_fuente']
    ];
} elseif ($categoria_producto === 'gabinete') {
    $caracteristicas = [
        'tamanio_max_gabinete' => $_POST['tamanio_max_gabinete']
    ];
} elseif ($categoria_producto === 'notebook') {
    $caracteristicas = [
        'bateria_notebook' => $_POST['bateria_notebook'],
        'cpu_notebook' => $_POST['cpu_notebook'],
        'gpu_notebook' => $_POST['gpu_notebook'],
        'capacidad_ram' => $_POST['capacidad_ram'],
        'pantalla_notebook' => $_POST['pantalla_notebook']
    ];
}

// Actualizar o insertar características
foreach ($caracteristicas as $caracteristica => $valor_caracteristica) {
    $query_verificar = "SELECT * FROM producto_caracteristica WHERE id_producto='$id_producto' AND caracteristica='$caracteristica'";
    $resultado_verificar = mysqli_query($conexion, $query_verificar);

    if (mysqli_num_rows($resultado_verificar) > 0) {
        // Si existe, actualizar el valor
        $query_actualizar = "UPDATE producto_caracteristica SET valor_caracteristica='$valor_caracteristica' WHERE id_producto='$id_producto' AND caracteristica='$caracteristica'";
        mysqli_query($conexion, $query_actualizar);
    } else {
        // Si no existe, insertar la nueva característica
        $query_insertar = "INSERT INTO producto_caracteristica (id_producto, caracteristica, valor_caracteristica) VALUES ('$id_producto', '$caracteristica', '$valor_caracteristica')";
        mysqli_query($conexion, $query_insertar);
    }
}

header("Location: listar_productos.php");
exit();
?>
