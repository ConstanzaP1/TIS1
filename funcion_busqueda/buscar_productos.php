<?php
// Conexión a la base de datos
require('../conexion.php');

// Capturar el término de búsqueda desde AJAX
$searchQuery = '';
if (isset($_GET['query']) && !empty($_GET['query'])) {
    $searchQuery = mysqli_real_escape_string($conexion, $_GET['query']);
}

// Consulta para obtener los productos y el nombre de la marca
$query = "
    SELECT 
        p.id_producto, 
        m.nombre_marca AS marca, 
        p.nombre_producto, 
        p.precio, 
        p.imagen_url 
    FROM 
        producto p
    JOIN 
        marca m ON p.marca = m.id_marca
";

// Añadir condición de búsqueda si existe una consulta
if (!empty($searchQuery)) {
    $query .= " WHERE p.nombre_producto LIKE '%$searchQuery%' OR m.nombre_marca LIKE '%$searchQuery%'";
}

$result = mysqli_query($conexion, $query);

// Contenedor para mantener el formato de las cards
echo "<div class='d-flex flex-wrap justify-content-center'>";
if ($result->num_rows > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        // Variables del producto
        $id_producto = $row['id_producto'];
        $marca = $row['marca']; 
        $nombre_producto = $row['nombre_producto'];
        $precio = number_format($row['precio'], 0, ',', '.');
        $imagen_url = $row['imagen_url']; 

        // HTML del producto con enlace al detalle
        echo "
          <div class='card mx-1 mb-3 p-0 shadow' style='width: 18rem; height: 26rem;'>
            <img src='$imagen_url' alt='$nombre_producto' class='card-img-top img-fluid' style='height: 20rem; object-fit: cover;'>
              <div class='card-body text-begin'>
                <a class='text-decoration-none' href='catalogo_productos/detalle_producto.php?id_producto=$id_producto'>
                    <p class='text-secondary m-0'>$marca</p>
                    <h5 class='text-black my-1'>$nombre_producto</h5>
                    <p class='text-secondary'>$$precio</p>
                </a>
              </div>
          </div>
        ";
    }
} else {
    echo "<p>No hay productos disponibles.</p>";
}
echo "</div>"; // Cierre del contenedor
mysqli_close($conexion);
?>
