<?php
require('../conexion.php');

// Función para redimensionar la imagen desde una URL
function resizeImageFromURL($url, $newWidth, $newHeight) {
    // Obtener la imagen desde la URL
    $imageData = file_get_contents($url);
    if ($imageData === false) {
        die("No se pudo obtener la imagen desde la URL.");
    }

    // Crear una imagen desde los datos obtenidos
    $sourceImage = imagecreatefromstring($imageData);
    if ($sourceImage === false) {
        die("La URL proporcionada no es una imagen válida.");
    }

    // Obtener el tamaño original de la imagen
    $originalWidth = imagesx($sourceImage);
    $originalHeight = imagesy($sourceImage);

    // Crear una imagen vacía con el nuevo tamaño
    $resizedImage = imagecreatetruecolor($newWidth, $newHeight);

    // Redimensionar la imagen
    imagecopyresampled($resizedImage, $sourceImage, 0, 0, 0, 0, $newWidth, $newHeight, $originalWidth, $originalHeight);

    // Guardar la imagen redimensionada en el servidor temporalmente
    $tempPath = 'temp_image.jpg';
    imagejpeg($resizedImage, $tempPath);

    // Liberar memoria
    imagedestroy($sourceImage);
    imagedestroy($resizedImage);

    return $tempPath;
}

// Procesar los datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $imagenURL = $_POST['imagen_url'];

    // Redimensionar la imagen desde la URL
    $newWidth = 300;  // Ajusta el tamaño deseado
    $newHeight = 300; // Ajusta el tamaño deseado
    $resizedImagePath = resizeImageFromURL($imagenURL, $newWidth, $newHeight);

    // Guardar los datos en la base de datos (ajusta la consulta según tu estructura)
    $query = "INSERT INTO productos (imagen_url) VALUES (?)";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("siisississ",$resizedImagePath);

    if ($stmt->execute()) {
        echo "Producto guardado exitosamente.";
    } else {
        echo "Error al guardar el producto: " . $conexion->error;
    }

    $stmt->close();
    $conexion->close();
}
?>
        