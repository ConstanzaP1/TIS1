<?php
function filtrarProductosPorMarcaYRangoYCategoria($marca, $precio_min, $precio_max, $categoria, $soloDestacados = false) {
    // Conexión a la base de datos
    require('conexion.php');

    // Consulta base
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
        WHERE 1=1
    ";

    // Inicializar los parámetros y tipos para la consulta preparada
    $params = [];
    $types = "";

    // Filtro de productos destacados (siempre activo)
    $query .= " AND p.destacado = 1";

    // Filtro de marca
    if ($marca !== "") {
        $query .= " AND m.nombre_marca = ?";
        $params[] = $marca;
        $types .= "s";
    }

    // Filtro de precio mínimo
    if ($precio_min !== "") {
        $query .= " AND p.precio >= ?";
        $params[] = $precio_min;
        $types .= "d";
    }

    // Filtro de precio máximo
    if ($precio_max !== "") {
        $query .= " AND p.precio <= ?";
        $params[] = $precio_max;
        $types .= "d";
    }

    // Filtro de categoría
    if ($categoria !== "") {
        $query .= " AND p.tipo_producto LIKE ?";
        $params[] = "%" . $categoria . "%";
        $types .= "s";
    }

    // Preparar y ejecutar la consulta
    $stmt = $conexion->prepare($query);
    if ($types) {
        $stmt->bind_param($types, ...$params);
    }
    $stmt->execute();
    $result = $stmt->get_result();

    // Obtener productos filtrados
    $productos = [];
    while ($row = $result->fetch_assoc()) {
        $productos[] = $row;
    }

    // Cerrar la conexión
    $stmt->close();
    $conexion->close();

    return $productos;
}

?>