<?php
require ('../conexion.php');
session_start();

$comentario = mysqli_real_escape_string($conexion, $_POST['comentario']);
$valoracion = mysqli_real_escape_string($conexion, $_POST['valoracion']);
$id_producto = $_GET['id_producto'];
$user_id = $_SESSION['user_id'] ?? null;

// Obtener la fecha y hora actuales en el formato adecuado
date_default_timezone_set('America/Santiago');
$fecha_actual = date("Y-m-d H:i:s");

// Insertar la reseña con fecha y hora
$query_resena = "INSERT INTO resena_valoracion(valoracion, comentario, id_producto, user_id, fecha) 
                 VALUES ('$valoracion', '$comentario', '$id_producto', '$user_id', '$fecha_actual')";

if (mysqli_query($conexion, $query_resena)) {
    echo "Reseña añadida correctamente.";
    
} else {
    echo "Error al añadir la reseña: " . mysqli_error($conexion);
}
?>
