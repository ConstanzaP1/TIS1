<?php
require('../conexion.php');

$query = isset($_GET['query']) ? mysqli_real_escape_string($conexion, $_GET['query']) : "";

$sql = "SELECT 
            p.id_producto, 
            p.nombre_producto, 
            p.precio, 
            p.cantidad, 
            p.tipo_producto, 
            p.imagen_url, 
            p.destacado, 
            p.costo, 
            m.nombre_marca AS marca 
        FROM producto p
        INNER JOIN marca m ON p.marca = m.id_marca
        WHERE p.nombre_producto LIKE '%$query%' OR m.nombre_marca LIKE '%$query%'
        LIMIT 20";

$result = mysqli_query($conexion, $sql);

if ($result) {
    $productos = mysqli_fetch_all($result, MYSQLI_ASSOC);
    foreach ($productos as $producto) {
        // Ensure price is properly formatted before displaying
        $precio_formateado = number_format($producto['precio'], 0, ',', '.');

        echo "
            <div class='col-6 col-md-4'>
                <a href='catalogo_productos/detalle_producto.php?id_producto={$producto['id_producto']}' class='text-decoration-none'>
                    <div class='card p-0 shadow' style='width: 100%; height: 100%;'>
                        <div class='image-container' style='width: 100%; height: 100%; position: relative; overflow: hidden;'>
                            <img src='{$producto['imagen_url']}' alt='{$producto['nombre_producto']}' class='card-img-top img-fluid product-image' style='object-fit: contain; width: 100%; height: 100%;'>
                        </div>
                        <div class='card-body text-begin' style='width: 100%; height: 45%;'>
                            <h6 class='text-black fw-bold'>{$producto['marca']}</h6>
                            <h5 class='text-secondary-emphasis'>{$producto['nombre_producto']}</h5>
                            <h5 class='text-secondary-emphasis'>\${$precio_formateado}</h5>
                        </div>
                    </div>
                </a>
            </div>
        ";
    }
} else {
    echo "<p>No se encontraron productos.</p>";
}
?>
