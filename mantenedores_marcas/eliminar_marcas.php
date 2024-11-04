<?php
require('../conexion.php');

// Verifica si se recibió el ID de la marca
if (isset($_GET['id_marca'])) {
    // Escapar el ID de la marca para evitar inyecciones SQL
    $id_marca = mysqli_real_escape_string($conexion, $_GET['id_marca']);

    // Consulta para eliminar la marca
    $queryEliminarMarca = "DELETE FROM marca WHERE id_marca='$id_marca'";

    // Ejecutar la consulta
    if (mysqli_query($conexion, $queryEliminarMarca)) {
        echo "Marca eliminada exitosamente.";
        // Redirigir al index después de la eliminación
        header('location: ../index.php');
        exit();
    } else {
        // Mostrar error si no se puede eliminar
        echo "Error al eliminar la marca: " . mysqli_error($conexion);
    }
} else {
    // Mostrar mensaje si no se proporciona un ID válido
    echo "No se proporcionó un ID válido.";
}
?>
