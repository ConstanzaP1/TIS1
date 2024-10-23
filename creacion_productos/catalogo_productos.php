<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

<?php
require('../conexion.php');

// Consulta para obtener los productos y sus caracteristicas
$query = "
    SELECT 
        p.id_producto, 
        p.nombre_producto, 
        p.precio, 
        p.cantidad,
        p.tipo_producto,
        GROUP_CONCAT(CASE 
            -- caracteristicas para teclados
            WHEN pc.caracteristica = 'tipo_teclado' THEN CONCAT('Tipo de Teclado: ', tt.tipo_teclado) 
            WHEN pc.caracteristica = 'tipo_switch' THEN CONCAT('Tipo de Switch: ', ts.tipo_switch) 
            WHEN pc.caracteristica = 'conectividad' THEN CONCAT('Conectividad: ', c.conectividad)
            WHEN pc.caracteristica = 'iluminacion' THEN CONCAT('Iluminación: ', i.iluminacion)
            WHEN pc.caracteristica = 'categoria_teclado' THEN CONCAT('Categoría de Teclado: ', ct.categoria_teclado)

            -- caracteristicas para monitores
            WHEN pc.caracteristica = 'resolucion_monitor' THEN CONCAT('Resolución: ', rm.resolucion_monitor)
            WHEN pc.caracteristica = 'tamanio_monitor' THEN CONCAT('Tamaño: ', tm.tamanio_monitor)
            WHEN pc.caracteristica = 'tasa_refresco' THEN CONCAT('Tasa refresco: ', tr.tasa_refresco)
            WHEN pc.caracteristica = 'tiempo_respuesta' THEN CONCAT('Tiempo respuesta: ', tra.tiempo_respuesta)
            WHEN pc.caracteristica = 'soporte_monitor' THEN CONCAT('Soporte: ', sm.soporte_monitor)
            WHEN pc.caracteristica = 'tipo_panel' THEN CONCAT('Tipo panel: ', tp.tipo_panel)
            WHEN pc.caracteristica = 'tipo_curvatura' THEN CONCAT('Tipo curvatura: ', tc.tipo_curvatura)


            ELSE NULL
        END SEPARATOR ', ') AS caracteristicas
    FROM producto p
    LEFT JOIN producto_caracteristica pc ON p.id_producto = pc.id_producto
    -- Uniones para teclados
    LEFT JOIN tipo_teclado tt ON pc.valor_caracteristica = tt.id_periferico AND pc.caracteristica = 'tipo_teclado'
    LEFT JOIN tipo_switch ts ON pc.valor_caracteristica = ts.id_periferico AND pc.caracteristica = 'tipo_switch'
    LEFT JOIN conectividad c ON pc.valor_caracteristica = c.id_periferico AND pc.caracteristica = 'conectividad'
    LEFT JOIN iluminacion i ON pc.valor_caracteristica = i.id_periferico AND pc.caracteristica = 'iluminacion'
    LEFT JOIN categoria_teclado ct ON pc.valor_caracteristica = ct.id_periferico AND pc.caracteristica = 'categoria_teclado'
    
    -- Uniones para monitores
    LEFT JOIN resolucion_monitor rm ON pc.valor_caracteristica = rm.id_periferico AND pc.caracteristica = 'resolucion_monitor'
    LEFT JOIN tamanio_monitor tm ON pc.valor_caracteristica = tm.id_periferico AND pc.caracteristica = 'tamanio_monitor'
    LEFT JOIN tasa_refresco tr ON pc.valor_caracteristica = tr.id_periferico AND pc.caracteristica = 'tasa_refresco'
    LEFT JOIN tiempo_respuesta tra ON pc.valor_caracteristica = tra.id_periferico AND pc.caracteristica = 'tiempo_respuesta'
    LEFT JOIN soporte_monitor sm ON pc.valor_caracteristica = sm.id_periferico AND pc.caracteristica = 'soporte_monitor'
    LEFT JOIN tipo_panel tp ON pc.valor_caracteristica = tp.id_periferico AND pc.caracteristica = 'tipo_panel'
    LEFT JOIN tipo_curvatura tc ON pc.valor_caracteristica = tc.id_periferico AND pc.caracteristica = 'tipo_curvatura'
    
    GROUP BY p.id_producto
";

$result = mysqli_query($conexion, $query);

if ($result->num_rows > 0) {
    echo "
    <div class='container'>
        <h2 class='my-4'>Catálogo de Productos</h2>
        <table class='table table-striped table-bordered'>
            <thead class='thead-dark'>
                <tr>
                    <th>ID Producto</th>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Cantidad</th>
                    <th>Tipo de Producto</th>
                    <th>Caracteristicas</th>
                </tr>
            </thead>
            <tbody>";

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>
                <td>" . $row['id_producto'] . "</td>
                <td>" . $row['nombre_producto'] . "</td>
                <td>" . number_format($row['precio'], 0, ',', '.') . "</td> <!-- Precio con formato -->
                <td>" . $row['cantidad'] . "</td>
                <td>" . ucfirst($row['tipo_producto']) . "</td> <!-- Capitalizar el tipo de producto -->
                <td>" . (!empty($row['caracteristicas']) ? $row['caracteristicas'] : 'Sin caracteristicas específicos') . "</td> <!-- Mostrar 'Sin caracteristicas' si está vacío -->
              </tr>";
    }

    echo "</tbody></table></div>";
} else {
    echo "<div class='container'><p>No hay productos en el catálogo.</p></div>";
}
?>
