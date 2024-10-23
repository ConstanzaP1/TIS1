<?php
require('../conexion.php');

// Recoger los datos generales del formulario
$nombre_producto = $_POST['nombre_producto'];
$nombre_marca = $_POST['nombre_marca'];
$precio = $_POST['precio'];
$cantidad = $_POST['cantidad'];
$categoria_producto = $_POST['categoria_producto']; // Ejemplo: 'teclado', 'monitor', 'audifono', etc.

// Insertar los datos generales del producto en la tabla producto
$query_producto = "INSERT INTO producto (nombre_producto, precio, cantidad, tipo_producto, marca) 
                   VALUES ('$nombre_producto', '$precio', '$cantidad', '$categoria_producto', $nombre_marca)";
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
        if (isset($_POST['tasa_refresco'])) $caracteristicas['frecuencia_actualizacion'] = $_POST['tasa_refresco'];
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
