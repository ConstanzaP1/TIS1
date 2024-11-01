<?php
session_start();
require('../conexion.php');

if (isset($_POST['id_producto'])) {
    $id_producto = mysqli_real_escape_string($conexion, $_POST['id_producto']);
    $query = "SELECT cantidad FROM producto WHERE id_producto = '$id_producto'";
    $result = mysqli_query($conexion, $query);
    $producto = mysqli_fetch_assoc($result);
    echo $producto ? $producto['cantidad'] : 0; // Retornar la cantidad disponible
}
?>
