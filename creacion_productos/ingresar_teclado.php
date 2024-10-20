<?php
require('../conexion.php');

// Si se envía el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre_producto = $_POST['nombre_producto'];
    $precio = $_POST['precio'];
    $cantidad = $_POST['cantidad'];
    $imagen = $_POST['imagen'];
    $id_marca = $_POST['id_marca']; 
    $categoria_producto = 'teclado'; 
    $categoria_teclado = $_POST['categoria_teclado']; 

    // Insertar el producto en la tabla "producto"
    $queryProducto = "INSERT INTO producto (nombre_producto, precio, cantidad, imagen, id_marca, categoria_producto) 
                      VALUES ('$nombre_producto', '$precio', '$cantidad', '$imagen', '$id_marca', '$categoria_producto')";

    if (mysqli_query($conexion, $queryProducto)) {
        // Obtener el último id_producto insertado
        $id_producto = mysqli_insert_id($conexion);

        if (mysqli_query($conexion, $queryCategoriaTeclado)) {
            echo "Teclado agregado exitosamente.";
            header('location: index_producto.php');
        } else {
            echo "Error al insertar en la categoría de teclado: " . mysqli_error($conexion);
        }
    } else {
        echo "Error al insertar el producto: " . mysqli_error($conexion);
    }
}
?>
