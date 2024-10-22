<?php
require('../conexion.php');

// Consulta para obtener los productos y sus atributos
$query = "
    SELECT 
        p.id_producto, 
        p.nombre_producto, 
        p.precio, 
        p.cantidad,
        p.tipo_producto,
        GROUP_CONCAT(CASE 
            WHEN pa.atributo = 'tipo_teclado' THEN CONCAT('Tipo de Teclado: ', tt.tipo_teclado) 
            WHEN pa.atributo = 'tipo_switch' THEN CONCAT('Tipo de Switch: ', ts.tipo_switch) 
            WHEN pa.atributo = 'conectividad' THEN CONCAT('Conectividad: ', c.conectividad)
            WHEN pa.atributo = 'iluminacion' THEN CONCAT('Iluminación: ', i.iluminacion)
            ELSE NULL
        END SEPARATOR ', ') AS atributos
    FROM producto p
    LEFT JOIN producto_atributo pa ON p.id_producto = pa.id_producto
    LEFT JOIN tipo_teclado tt ON pa.valor_atributo = tt.id_periferico AND pa.atributo = 'tipo_teclado'
    LEFT JOIN tipo_switch ts ON pa.valor_atributo = ts.id_periferico AND pa.atributo = 'tipo_switch'
    LEFT JOIN conectividad c ON pa.valor_atributo = c.id_periferico AND pa.atributo = 'conectividad'
    LEFT JOIN iluminacion i ON pa.valor_atributo = i.id_periferico AND pa.atributo = 'iluminacion'
    GROUP BY p.id_producto
";

$result = mysqli_query($conexion, $query);

if ($result->num_rows > 0) {
    echo "<table class='table'>
            <thead>
                <tr>
                    <th>ID Producto</th>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Cantidad</th>
                    <th>Tipo de producto</th>
                    <th>Atributos</th>
                </tr>
            </thead>
            <tbody>";

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>
                <td>" . $row['id_producto'] . "</td>
                <td>" . $row['nombre_producto'] . "</td>
                <td>" . $row['precio'] . "</td>
                <td>" . $row['cantidad'] . "</td>
                <td>" . $row['tipo_producto'] . "</td>
                <td>" . $row['atributos'] . "</td>
              </tr>";
    }

    echo "</tbody></table>";
} else {
    echo "No hay productos en el catálogo.";
}
?>
