<?php
// Verificar si se ha enviado la categoría del producto
if (isset($_POST['categoria_producto'])) {
    $categoria = $_POST['categoria_producto'];

    // Redirigir a la página correspondiente según la categoría seleccionada
    if ($categoria == 'teclado') {
        header('Location: crear_teclado.php');
    } elseif ($categoria == 'monitor') {
        header('Location: crear_monitor.php');
    } elseif ($categoria == 'mouse') {
        header('Location: crear_mouse.php');
    } elseif ($categoria == 'audifono') {
        header('Location: crear_audifono.php');
    } elseif ($categoria == 'cpu') {
        header('Location: crear_cpu.php');
    } elseif ($categoria == 'gpu') {
        header('Location: crear_gpu.php');
    } elseif ($categoria == 'ram') {
        header('Location: crear_ram.php');
    } elseif ($categoria == 'ssd') {
        header('Location: crear_ssd.php');
    } elseif ($categoria == 'hdd') {
        header('Location: crear_hdd.php');
    } elseif ($categoria == 'placa') {
        header('Location: crear_placa_madre.php');
    } elseif ($categoria == 'fuente') {
        header('Location: crear_fuente.php');
    } elseif ($categoria == 'gabinete') {
        header('Location: crear_gabinete.php');
    } elseif ($categoria == 'notebook') {
        header('Location: crear_notebook.php');
    }
    else {
        // Si no se seleccionó ninguna categoría válida, redirigir de nuevo
        header('Location: index_crear_producto.php');
    }
} else {
    // Si no se envió la categoría, redirigir de nuevo al formulario
    header('Location: index_crear_producto.php');
}
exit();
