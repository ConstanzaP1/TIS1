<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle del Producto</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
</head>
<body>

<div class="container my-5 py-5">
    <?php
    // Conexión a la base de datos
    require('../conexion.php');

    // Verificar si recibimos el id_producto
    if (isset($_GET['id_producto'])) {
        $id_producto = $_GET['id_producto'];

        // Consulta para obtener los detalles del producto, incluyendo su tipo
        $query_producto = "
            SELECT 
                p.nombre_producto, 
                p.precio, 
                p.imagen_url, 
                m.nombre_marca AS marca,
                p.tipo_producto
            FROM 
                producto p
            LEFT JOIN marca m ON p.marca = m.id_marca
            WHERE p.id_producto = '$id_producto'
        ";
        
        $result_producto = mysqli_query($conexion, $query_producto);

        if ($result_producto->num_rows > 0) {
            $producto = mysqli_fetch_assoc($result_producto);

            // Mostrar los detalles del producto
            echo "
            <div class='producto-detalle shadow d-flex align-items-center'>
                <div class='col-6 text-center'>
                    <img class='img-fluid' src='{$producto['imagen_url']}' alt='{$producto['nombre_producto']}'>
                </div>
                <div class='producto-info col-6 shadow p-5'>
                    <h1>{$producto['nombre_producto']}</h1>
                    <p>Precio: $" . number_format($producto['precio'], 0, ',', '.') . "</p>
                    <p><strong>Marca:</strong> {$producto['marca']}</p>
                    <p><strong>Características:</strong></p>
                    <ul>
            ";

            // Mostrar características según el tipo de producto
            switch ($producto['tipo_producto']) {
                case 'teclado':
                    $query_caracteristicas = "
                        SELECT 
                            CASE 
                                WHEN pa.caracteristica = 'tipo_teclado' THEN CONCAT('Tipo de Teclado: ', tt.tipo_teclado) 
                                WHEN pa.caracteristica = 'tipo_switch' THEN CONCAT('Tipo de Switch: ', ts.tipo_switch) 
                                WHEN pa.caracteristica = 'conectividad' THEN CONCAT('Conectividad: ', c.conectividad)
                                WHEN pa.caracteristica = 'iluminacion' THEN CONCAT('Iluminación: ', i.iluminacion)
                                ELSE NULL
                            END AS caracteristica
                        FROM 
                            producto_caracteristica pa
                        LEFT JOIN tipo_teclado tt ON pa.valor_caracteristica = tt.id_periferico AND pa.caracteristica = 'tipo_teclado'
                        LEFT JOIN tipo_switch ts ON pa.valor_caracteristica = ts.id_periferico AND pa.caracteristica = 'tipo_switch'
                        LEFT JOIN conectividad c ON pa.valor_caracteristica = c.id_periferico AND pa.caracteristica = 'conectividad'
                        LEFT JOIN iluminacion i ON pa.valor_caracteristica = i.id_periferico AND pa.caracteristica = 'iluminacion'
                        WHERE pa.id_producto = '$id_producto'
                    ";
                    break;

                case 'monitor':
                    $query_caracteristicas = "
                        SELECT 
                            CASE 
                                WHEN pa.caracteristica = 'resolucion_monitor' THEN CONCAT('Resolución: ', r.resolucion_monitor) 
                                WHEN pa.caracteristica = 'tasa_refresco' THEN CONCAT('Tasa de Refresco: ', tr.tasa_refresco) 
                                WHEN pa.caracteristica = 'tipo_panel' THEN CONCAT('Tipo de Panel: ', tp.tipo_panel)
                                WHEN pa.caracteristica = 'tamanio_monitor' THEN CONCAT('Tamaño monitor: ', tm.tamanio_monitor)
                                WHEN pa.caracteristica = 'tiempo_respuesta' THEN CONCAT('Tiempo de respuesta: ', tra.tiempo_respuesta)
                                WHEN pa.caracteristica = 'soporte_monitor' THEN CONCAT('Soporte monitor: ', sm.soporte_monitor)
                                WHEN pa.caracteristica = 'tipo_curvatura' THEN CONCAT('Tipo de curvatura: ', tc.tipo_curvatura)
                                ELSE NULL
                            END AS caracteristica
                        FROM 
                            producto_caracteristica pa
                        LEFT JOIN resolucion_monitor r ON pa.valor_caracteristica = r.id_periferico AND pa.caracteristica = 'resolucion_monitor'
                        LEFT JOIN tasa_refresco tr ON pa.valor_caracteristica = tr.id_periferico AND pa.caracteristica = 'tasa_refresco'
                        LEFT JOIN tipo_panel tp ON pa.valor_caracteristica = tp.id_periferico AND pa.caracteristica = 'tipo_panel'
                        LEFT JOIN tamanio_monitor tm ON pa.valor_caracteristica = tm.id_periferico AND pa.caracteristica = 'tamanio_monitor'
                        LEFT JOIN tiempo_respuesta tra ON pa.valor_caracteristica = tra.id_periferico AND pa.caracteristica = 'tiempo_respuesta'
                        LEFT JOIN soporte_monitor sm ON pa.valor_caracteristica = sm.id_periferico AND pa.caracteristica = 'soporte_monitor'
                        LEFT JOIN tipo_curvatura tc ON pa.valor_caracteristica = tc.id_periferico AND pa.caracteristica = 'tipo_curvatura'
                        WHERE pa.id_producto = '$id_producto'
                    ";
                    break;

                case 'audifono':
                    $query_caracteristicas = "
                        SELECT 
                            CASE 
                                WHEN pa.caracteristica = 'tipo_audifono' THEN CONCAT('Tipo de Audífono: ', ta.tipo_audifono)
                                WHEN pa.caracteristica = 'tipo_microfono' THEN CONCAT('Tipo de Microfono: ', tm.tipo_microfono)
                                WHEN pa.caracteristica = 'anc' THEN CONCAT('Cancelacion de ruido: ', a.anc)
                                WHEN pa.caracteristica = 'iluminacion' THEN CONCAT('Iluminacion: ', i.iluminacion)
                                WHEN pa.caracteristica = 'conectividad' THEN CONCAT('Conectividad: ', c.conectividad)
                                ELSE NULL
                            END AS caracteristica
                        FROM 
                            producto_caracteristica pa
                        LEFT JOIN tipo_audifono ta ON pa.valor_caracteristica = ta.id_periferico AND pa.caracteristica = 'tipo_audifono'
                        LEFT JOIN tipo_microfono tm ON pa.valor_caracteristica = tm.id_periferico AND pa.caracteristica = 'tipo_microfono'
                        LEFT JOIN anc a ON pa.valor_caracteristica = a.id_periferico AND pa.caracteristica = 'anc'
                        LEFT JOIN iluminacion i ON pa.valor_caracteristica = i.id_periferico AND pa.caracteristica = 'iluminacion'
                        LEFT JOIN conectividad c ON pa.valor_caracteristica = c.id_periferico AND pa.caracteristica = 'conectividad'
                        WHERE pa.id_producto = '$id_producto'
                    ";
                    break;

                case 'audifono':
                    $query_caracteristicas = "
                        SELECT 
                            CASE 
                                WHEN pa.caracteristica = 'tipo_audifono' THEN CONCAT('Tipo de Audífono: ', ta.tipo_audifono)
                                WHEN pa.caracteristica = 'tipo_microfono' THEN CONCAT('Tipo de Microfono: ', tm.tipo_microfono)
                                WHEN pa.caracteristica = 'anc' THEN CONCAT('Cancelacion de ruido: ', a.anc)
                                WHEN pa.caracteristica = 'iluminacion' THEN CONCAT('Iluminacion: ', i.iluminacion)
                                WHEN pa.caracteristica = 'conectividad' THEN CONCAT('Conectividad: ', c.conectividad)
                                ELSE NULL
                            END AS caracteristica
                        FROM 
                            producto_caracteristica pa
                        LEFT JOIN tipo_audifono ta ON pa.valor_caracteristica = ta.id_periferico AND pa.caracteristica = 'tipo_audifono'
                        LEFT JOIN tipo_microfono tm ON pa.valor_caracteristica = tm.id_periferico AND pa.caracteristica = 'tipo_microfono'
                        LEFT JOIN anc a ON pa.valor_caracteristica = a.id_periferico AND pa.caracteristica = 'anc'
                        LEFT JOIN iluminacion i ON pa.valor_caracteristica = i.id_periferico AND pa.caracteristica = 'iluminacion'
                        LEFT JOIN conectividad c ON pa.valor_caracteristica = c.id_periferico AND pa.caracteristica = 'conectividad'
                        WHERE pa.id_producto = '$id_producto'
                    ";
                    break;

                case 'mouse':
                    $query_caracteristicas = "
                        SELECT 
                            CASE 
                                WHEN pa.caracteristica = 'dpi_mouse' THEN CONCAT('DPI: ', dm.dpi_mouse)
                                WHEN pa.caracteristica = 'peso_mouse' THEN CONCAT('Peso: ', pm.peso_mouse)
                                WHEN pa.caracteristica = 'sensor_mouse' THEN CONCAT('Sensor: ', sm.sensor_mouse)
                                WHEN pa.caracteristica = 'iluminacion' THEN CONCAT('Iluminacion: ', i.iluminacion)
                                WHEN pa.caracteristica = 'conectividad' THEN CONCAT('Conectividad: ', c.conectividad)
                                ELSE NULL
                            END AS caracteristica
                        FROM 
                            producto_caracteristica pa
                        LEFT JOIN dpi_mouse dm ON pa.valor_caracteristica = dm.id_periferico AND pa.caracteristica = 'dpi_mouse'
                        LEFT JOIN peso_mouse pm ON pa.valor_caracteristica = pm.id_periferico AND pa.caracteristica = 'peso_mouse'
                        LEFT JOIN sensor_mouse sm ON pa.valor_caracteristica = sm.id_periferico AND pa.caracteristica = 'sensor_mouse'
                        LEFT JOIN iluminacion i ON pa.valor_caracteristica = i.id_periferico AND pa.caracteristica = 'iluminacion'
                        LEFT JOIN conectividad c ON pa.valor_caracteristica = c.id_periferico AND pa.caracteristica = 'conectividad'
                        WHERE pa.id_producto = '$id_producto'
                    ";
                        break;
                // Agrega más casos para otros tipos de productos, como mouse, parlantes, etc.
            }

            // Ejecutar la consulta de características
            $result_caracteristicas = mysqli_query($conexion, $query_caracteristicas);

            // Iterar sobre las características y mostrarlas en una lista
            if ($result_caracteristicas->num_rows > 0) {
                while ($caracteristica = mysqli_fetch_assoc($result_caracteristicas)) {
                    if ($caracteristica['caracteristica'] !== null) {
                        echo "<li>" . $caracteristica['caracteristica'] . "</li>";
                    }
                }
            } else {
                echo "<li>No hay características disponibles.</li>";
            }

            echo "
                    </ul>
                    <button class='btn btn-primary mt-3'>Agregar al Carro</button>
                </div>
            </div>
            ";
        } else {
            echo "<p>Producto no encontrado.</p>";
        }
    } else {
        echo "<p>ID de producto no proporcionado.</p>";
    }

    // Cierre de conexión
    mysqli_close($conexion);
    ?>
    <a href="catalogo_productos.php" class="btn btn-secondary mb-4">Volver al Catálogo</a>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
