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

// Actualizar los datos generales del producto
$query_actualizar_producto = "UPDATE producto SET nombre_producto='$nombre_producto', marca='$nombre_marca', precio='$precio', cantidad='$cantidad', tipo_producto='$categoria_producto', imagen_url='$imagen_url' WHERE id_producto='$id_producto'";
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
