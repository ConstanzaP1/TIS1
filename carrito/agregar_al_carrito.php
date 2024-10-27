<?php
session_start();
require('../conexion.php'); // Conexión a la base de datos

// Verificar si se envió el formulario
if (isset($_POST['agregar_carrito'])) {
    $id_producto = $_POST['id_producto'];
    $cantidad = intval($_POST['cantidad']);

    // Verificar si el carrito ya existe en la sesión
    if (!isset($_SESSION['carrito'])) {
        $_SESSION['carrito'] = []; // Inicializar el carrito
    }

    // Verificar si el producto ya está en el carrito
    if (isset($_SESSION['carrito'][$id_producto])) {
        // Si ya está, simplemente aumentamos la cantidad
        $_SESSION['carrito'][$id_producto] += $cantidad;
    } else {
        // Si no está, lo agregamos al carrito
        $_SESSION['carrito'][$id_producto] = $cantidad;
    }

    // Redirigir al carrito o a otra página
    header('Location: carrito.php');
    exit(); // Asegúrate de terminar el script después de redirigir
} else {
    // Manejar el caso donde el botón no fue presionado correctamente
    echo "No se pudo agregar el producto al carrito.";
}
?>
