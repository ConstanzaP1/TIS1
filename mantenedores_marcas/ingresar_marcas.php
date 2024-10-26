<?php
require('../conexion.php'); // Asegúrate de que este archivo establece correctamente la conexión a la base de datos

// Verifica si se envió el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibir el valor del formulario
    $nombre_marca = $_POST['nombre_marca'];

    // Verifica si la variable $conexion está definida
    if (isset($conexion)) {
        // Prepara la consulta para insertar los datos (usando ? como marcador de parámetro)
        $query = $conexion->prepare("INSERT INTO marca (nombre_marca) VALUES (?)");

        // Vincula el parámetro a la consulta preparada
        $query->bind_param("s", $nombre_marca);  // "s" indica que el parámetro es una cadena (string)

        // Ejecuta la consulta
        if ($query->execute()) {
            echo "Marca ingresada exitosamente.";
            header('Location: nombres_marcas.php'); // Redirigir tras el éxito
            exit();
        } else {
            echo "Error al insertar: " . $conexion->error;
        }
    } else {
        echo "Error: No se pudo conectar a la base de datos.";
    }
}
?>
