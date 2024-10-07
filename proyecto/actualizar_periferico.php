<?php
require('conexion.php');

// Obtener los datos del formulario
$id_periferico = $_POST['id_periferico'];
$tipo_periferico = $_POST['tipo_periferico'];

// Procesar los datos según el tipo de periférico
if ($tipo_periferico == 'conectividad') {
    $conectividad = $_POST['conectividad'];
    $query = "UPDATE conectividad SET conectividad = '$conectividad' WHERE id_periferico = '$id_periferico'";
} elseif ($tipo_periferico == 'sensor_mouse') {
    $sensor_mouse = $_POST['sensor_mouse'];
    $query = "UPDATE sensor_mouse SET sensor_mouse = '$sensor_mouse' WHERE id_periferico = '$id_periferico'";
} elseif ($tipo_periferico == 'dpi_mouse') {
    $dpi_mouse = $_POST['dpi_mouse'];
    $query = "UPDATE dpi_mouse SET dpi_mouse = '$dpi_mouse' WHERE id_periferico = '$id_periferico'";
} elseif ($tipo_periferico == 'categoria_teclado') {
    $categoria_teclado = $_POST['categoria_teclado'];
    $query = "UPDATE categoria_teclado SET categoria_teclado = '$categoria_teclado' WHERE id_periferico = '$id_periferico'";
} elseif ($tipo_periferico == 'tipo_teclado') {
    $tipo_teclado = $_POST['tipo_teclado'];
    $query = "UPDATE tipo_teclado SET tipo_teclado = '$tipo_teclado' WHERE id_periferico = '$id_periferico'";
} elseif ($tipo_periferico == 'tipo_audifono') {
    $tipo_audifono = $_POST['tipo_audifono'];
    $query = "UPDATE tipo_audifono SET tipo_audifono = '$tipo_audifono' WHERE id_periferico = '$id_periferico'";
} elseif ($tipo_periferico == 'tipo_microfono') {
    $tipo_microfono = $_POST['tipo_microfono'];
    $query = "UPDATE tipo_microfono SET tipo_microfono = '$tipo_microfono' WHERE id_periferico = '$id_periferico'";
} elseif ($tipo_periferico == 'tamanio_monitor') {
    $tamanio_monitor = $_POST['tamanio_monitor'];
    $query = "UPDATE tamanio_monitor SET tamanio_monitor = '$tamanio_monitor' WHERE id_periferico = '$id_periferico'";
} elseif ($tipo_periferico == 'resolucion_monitor') {
    $resolucion_monitor = $_POST['resolucion_monitor'];
    $query = "UPDATE resolucion_monitor SET resolucion_monitor = '$resolucion_monitor' WHERE id_periferico = '$id_periferico'";
} elseif ($tipo_periferico == 'tipo_curvatura') {
    $tipo_curvatura = $_POST['tipo_curvatura'];
    $query = "UPDATE tipo_curvatura SET tipo_curvatura = '$tipo_curvatura' WHERE id_periferico = '$id_periferico'";
} elseif ($tipo_periferico == 'tiempo_respuesta') {
    $tiempo_respuesta = $_POST['tiempo_respuesta'];
    $query = "UPDATE tiempo_respuesta SET tiempo_respuesta = '$tiempo_respuesta' WHERE id_periferico = '$id_periferico'";
} elseif ($tipo_periferico == 'tipo_panel') {
    $tipo_panel = $_POST['tipo_panel'];
    $query = "UPDATE tipo_panel SET tipo_panel = '$tipo_panel' WHERE id_periferico = '$id_periferico'";
}

// Ejecutar la consulta
mysqli_query($conexion, $query);

// Verificar si la consulta se ejecutó correctamente
if (mysqli_affected_rows($conexion) > 0) {
    // Redireccionar a la página de inicio
    header('Location: index.php');
    exit;
} else {
    // Mostrar un mensaje de error
    echo "Error al actualizar el periférico.";
    exit;
}
?>