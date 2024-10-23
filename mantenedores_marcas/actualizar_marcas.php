<?php
require('../conexion.php');

// Obtener los datos del formulario
$id_marca = $_POST['id_marca'];
$nombre_marca = $_POST['nombre_marca'];

// Consulta para actualizar la marca
$query = "UPDATE marca SET nombre_marca = '$nombre_marca' WHERE id_marca = '$id_marca'";

// Ejecutar la consulta
mysqli_query($conexion, $query);

// Verificar si la consulta se ejecutó correctamente
if (mysqli_affected_rows($conexion) > 0) {
    // Redireccionar a la página de inicio
    header('Location: ../index.php');
    exit;
} else {
    // Mostrar un mensaje de error si no se actualizó
    echo "Error al actualizar la marca o no se realizaron cambios.";
    exit;
}
?>
