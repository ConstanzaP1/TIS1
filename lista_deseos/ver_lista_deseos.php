<?php
session_start();
require('../conexion.php'); // Archivo de conexión a la base de datos

$nombre_lista = 'mi_lista_deseos'; // Nombre de la lista de deseos

$query = "SELECT p.id_producto, p.nombre_producto, p.precio, p.marca, p.imagen_url 
          FROM producto p
          JOIN lista_deseo_producto ldp ON p.id_producto = ldp.id_producto
          WHERE ldp.nombre_lista = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $nombre_lista);
$stmt->execute();
$result = $stmt->get_result();

echo "<h2>Lista de Deseos</h2>";
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div>";
        echo "<img src='" . $row['imagen_url'] . "' alt='" . $row['nombre_producto'] . "' style='width:100px; height:auto;'>";
        echo "<h3>" . $row['nombre_producto'] . "</h3>";
        echo "<p>Precio: $" . $row['precio'] . "</p>";
        echo "<p>Marca: " . $row['marca'] . "</p>";
        echo "</div>";
    }
} else {
    echo "La lista de deseos está vacía.";
}
?>
