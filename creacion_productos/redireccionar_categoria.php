<?php
// Verificar si se ha enviado la categoría del producto
if (isset($_POST['categoria_producto'])) {
    $categoria = $_POST['categoria_producto'];

    // Redirigir a la página correspondiente según la categoría seleccionada
    if ($categoria == 'teclado') {
        header('Location: crear_teclado.php');
    } elseif ($categoria == 'monitor') {
        // Aquí puedes redirigir a una página para crear un monitor
        header('Location: crear_monitor.php');
    } elseif ($categoria == 'mouse') {
        // Aquí puedes redirigir a una página para crear un mouse
        header('Location: crear_mouse.php');
    } elseif ($categoria == 'auricular') {
        // Aquí puedes redirigir a una página para crear un auricular
        header('Location: crear_auricular.php');
    } else {
        // Si no se seleccionó ninguna categoría válida, redirigir de nuevo
        header('Location: index_crear_producto.php');
    }
} else {
    // Si no se envió la categoría, redirigir de nuevo al formulario
    header('Location: index_crear_producto.php');
}
exit();
