<?php
require ('../conexion.php');
session_start();

header('Content-Type: application/json');

$comentario = mysqli_real_escape_string($conexion, $_POST['comentario']);
$valoracion = mysqli_real_escape_string($conexion, $_POST['valoracion']);
$id_producto = $_GET['id_producto'];
$user_id = $_SESSION['user_id'] ?? null;

date_default_timezone_set('America/Santiago');
$fecha_actual = date("Y-m-d H:i:s");

$query_resena = "INSERT INTO resena_valoracion(valoracion, comentario, id_producto, user_id, fecha) 
                 VALUES ('$valoracion', '$comentario', '$id_producto', '$user_id', '$fecha_actual')";

if (mysqli_query($conexion, $query_resena)) {
    echo json_encode(['status' => 'success', 'message' => 'Reseña añadida correctamente.']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Error al añadir la reseña: ' . mysqli_error($conexion)]);
}
?>
