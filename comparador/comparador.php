<?php
session_start();
require('../conexion.php');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comparador de Productos</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .product-img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 5px;
        }
        .table th, .table td {
            vertical-align: middle;
        }
        .empty-comparator {
            text-align: center;
            margin-top: 20px;
        }
        .back-to-store {
            margin-top: 20px;
            display: block;
            text-align: center;
        }
    </style>
</head>
<body class="bg-light">

<div class="container mt-5">
    <?php
    // Verificar si hay productos en el comparador
    if (!isset($_SESSION['comparador']) || empty($_SESSION['comparador'])) {
        echo "<h2 class='empty-comparator'>No hay productos en el comparador.</h2>";
        echo "<a href='../index.php' class='btn btn-secondary back-to-store'>Volver a la Tienda</a>";
        exit();
    }

    // Obtener IDs de productos para la consulta
    $product_ids = implode(',', $_SESSION['comparador']);
    $query = "SELECT id_producto, nombre_producto, imagen_url, precio, tipo_producto FROM producto WHERE id_producto IN ($product_ids)";
    $result = mysqli_query($conexion, $query);

    if (!$result) {
        echo "<div class='alert alert-danger'>Error en la consulta: " . mysqli_error($conexion) . "</div>";
        exit();
    }

    if (mysqli_num_rows($result) > 0) {
        echo "<h2 class='text-center mb-4'>Comparador de Productos</h2>";
        echo "<table class='table table-hover table-bordered bg-white'>";
        echo "<thead class='thead-dark'><tr><th>Imagen</th><th>Producto</th><th>Precio</th><th>Características</th><th>Acciones</th></tr></thead>";
        echo "<tbody>";

        while ($row = mysqli_fetch_assoc($result)) {
            // Obtener características
            $query_caracteristicas = getCaracteristicasQuery($row['tipo_producto'], $row['id_producto']);
            $result_caracteristicas = mysqli_query($conexion, $query_caracteristicas);

            $caracteristicas = '';
            if ($result_caracteristicas && mysqli_num_rows($result_caracteristicas) > 0) {
                while ($caracteristica = mysqli_fetch_assoc($result_caracteristicas)) {
                    $caracteristicas .= "<li>" . htmlspecialchars($caracteristica['caracteristica']) . "</li>";
                }
            } else {
                $caracteristicas = "<li>No hay características disponibles</li>";
            }

            echo "<tr>";
            echo "<td><img src='" . htmlspecialchars($row['imagen_url']) . "' alt='" . htmlspecialchars($row['nombre_producto']) . "' class='product-img'></td>";
            echo "<td>" . htmlspecialchars($row['nombre_producto']) . "</td>";
            echo "<td>$" . number_format($row['precio'], 0, ',', '.') . "</td>";
            echo "<td><ul>" . $caracteristicas . "</ul></td>";
            echo "<td>
                    <form method='POST' action='comparador.php'>
                        <input type='hidden' name='id_producto' value='" . $row['id_producto'] . "'>
                        <button type='submit' name='eliminar_comparador' class='btn btn-sm btn-danger'>Eliminar</button>
                    </form>
                  </td>";
            echo "</tr>";
        }

        echo "</tbody></table>";
    } else {
        echo "<h2 class='empty-comparator'>No se encontraron productos en el comparador.</h2>";
    }

    // Eliminar un producto del comparador
    if (isset($_POST['eliminar_comparador'])) {
        $id_producto = $_POST['id_producto'];
        $_SESSION['comparador'] = array_filter($_SESSION['comparador'], function($item) use ($id_producto) {
            return $item != $id_producto;
        });
        header("Location: comparador.php");
        exit();
    }

    // Función para obtener la consulta de características según el tipo de producto

    function getCaracteristicasQuery($tipo_producto, $id_producto) {
        switch ($tipo_producto) {
            case 'teclado':
                return "
                    SELECT 
                        CASE 
                            WHEN pa.caracteristica = 'tipo_teclado' THEN CONCAT('Tipo de Teclado: ', tt.tipo_teclado) 
                            WHEN pa.caracteristica = 'tipo_switch' THEN CONCAT('Tipo de Switch: ', ts.tipo_switch) 
                            WHEN pa.caracteristica = 'conectividad' THEN CONCAT('Conectividad: ', c.conectividad)
                            WHEN pa.caracteristica = 'iluminacion' THEN CONCAT('Iluminación: ', i.iluminacion)
                        END AS caracteristica
                    FROM 
                        producto_caracteristica pa
                    LEFT JOIN tipo_teclado tt ON pa.valor_caracteristica = tt.id_periferico AND pa.caracteristica = 'tipo_teclado'
                    LEFT JOIN tipo_switch ts ON pa.valor_caracteristica = ts.id_periferico AND pa.caracteristica = 'tipo_switch'
                    LEFT JOIN conectividad c ON pa.valor_caracteristica = c.id_periferico AND pa.caracteristica = 'conectividad'
                    LEFT JOIN iluminacion i ON pa.valor_caracteristica = i.id_periferico AND pa.caracteristica = 'iluminacion'
                    WHERE pa.id_producto = '$id_producto'";
            
                   case 'monitor':
                return "
                    SELECT 
                        CASE 
                            WHEN pa.caracteristica = 'resolucion_monitor' THEN CONCAT('Resolución: ', r.resolucion_monitor) 
                            WHEN pa.caracteristica = 'tasa_refresco' THEN CONCAT('Tasa de Refresco: ', tr.tasa_refresco) 
                        END AS caracteristica
                    FROM 
                        producto_caracteristica pa
                    LEFT JOIN resolucion_monitor r ON pa.valor_caracteristica = r.id_periferico AND pa.caracteristica = 'resolucion_monitor'
                    LEFT JOIN tasa_refresco tr ON pa.valor_caracteristica = tr.id_periferico AND pa.caracteristica = 'tasa_refresco'
                    WHERE pa.id_producto = '$id_producto'";
            case 'audifono':
                return "
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
            case 'mouse':
                return "
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
            case 'cpu':
                return "
                    SELECT 
                        CASE 
                            WHEN pa.caracteristica = 'frecuencia_cpu' THEN CONCAT('Frecuencia: ', fc.frecuencia_cpu)
                            WHEN pa.caracteristica = 'nucleo_hilo_cpu' THEN CONCAT('Nucle / Hilo: ', nhc.nucleo_hilo_cpu)
                            WHEN pa.caracteristica = 'socket_cpu' THEN CONCAT('Socket: ', sc.socket_cpu)
                            ELSE NULL
                        END AS caracteristica
                    FROM 
                        producto_caracteristica pa
                    LEFT JOIN frecuencia_cpu fc ON pa.valor_caracteristica = fc.id_hardware AND pa.caracteristica = 'frecuencia_cpu'
                    LEFT JOIN nucleo_hilo_cpu nhc ON pa.valor_caracteristica = nhc.id_hardware AND pa.caracteristica = 'nucleo_hilo_cpu'
                    LEFT JOIN socket_cpu sc ON pa.valor_caracteristica = sc.id_hardware AND pa.caracteristica = 'socket_cpu'
                    WHERE pa.id_producto = '$id_producto'
                ";
            case 'gpu':
                return "
                    SELECT 
                        CASE 
                            WHEN pa.caracteristica = 'frecuencia_gpu' THEN CONCAT('Frecuencia: ', fg.frecuencia_gpu)
                            WHEN pa.caracteristica = 'memoria_gpu' THEN CONCAT('Memoria: ', mg.memoria_gpu)
                            ELSE NULL
                        END AS caracteristica
                    FROM 
                        producto_caracteristica pa
                    LEFT JOIN frecuencia_gpu fg ON pa.valor_caracteristica = fg.id_hardware AND pa.caracteristica = 'frecuencia_gpu'
                    LEFT JOIN memoria_gpu mg ON pa.valor_caracteristica = mg.id_hardware AND pa.caracteristica = 'memoria_gpu'
                    WHERE pa.id_producto = '$id_producto'
                ";
            case 'placa':
                return "
                    SELECT 
                        CASE 
                            WHEN pa.caracteristica = 'formato_placa' THEN CONCAT('Formato: ', fp.formato_placa)
                            WHEN pa.caracteristica = 'slot_memoria_placa' THEN CONCAT('Slots de memoria: ', smp.slot_memoria_placa)
                            WHEN pa.caracteristica = 'socket_placa' THEN CONCAT('Socket: ', sp.socket_placa)
                            WHEN pa.caracteristica = 'chipset_placa' THEN CONCAT('Chipset: ', cp.chipset_placa)
                            ELSE NULL
                        END AS caracteristica
                    FROM 
                        producto_caracteristica pa
                    LEFT JOIN formato_placa fp ON pa.valor_caracteristica = fp.id_hardware AND pa.caracteristica = 'formato_placa'
                    LEFT JOIN slot_memoria_placa smp ON pa.valor_caracteristica = smp.id_hardware AND pa.caracteristica = 'slot_memoria_placa'
                    LEFT JOIN socket_placa sp ON pa.valor_caracteristica = sp.id_hardware AND pa.caracteristica = 'socket_placa'
                    LEFT JOIN chipset_placa cp ON pa.valor_caracteristica = cp.id_hardware AND pa.caracteristica = 'chipset_placa'
                    WHERE pa.id_producto = '$id_producto'
                ";
            case 'ram':
                return "
                    SELECT 
                        CASE 
                            WHEN pa.caracteristica = 'tipo_ram' THEN CONCAT('Tipo: ', tr.tipo_ram)
                            WHEN pa.caracteristica = 'velocidad_ram' THEN CONCAT('Velocidad: ', vr.velocidad_ram)
                            WHEN pa.caracteristica = 'capacidad_ram' THEN CONCAT('Capacidad: ', cr.capacidad_ram)
                            WHEN pa.caracteristica = 'formato_ram' THEN CONCAT('Formato: ', fr.formato_ram)
                            ELSE NULL
                        END AS caracteristica
                    FROM 
                        producto_caracteristica pa
                    LEFT JOIN tipo_ram tr ON pa.valor_caracteristica = tr.id_hardware AND pa.caracteristica = 'tipo_ram'
                    LEFT JOIN velocidad_ram vr ON pa.valor_caracteristica = vr.id_hardware AND pa.caracteristica = 'velocidad_ram'
                    LEFT JOIN capacidad_ram cr ON pa.valor_caracteristica = cr.id_hardware AND pa.caracteristica = 'capacidad_ram'
                    LEFT JOIN formato_ram fr ON pa.valor_caracteristica = fr.id_hardware AND pa.caracteristica = 'formato_ram'
                    WHERE pa.id_producto = '$id_producto'
                ";
            case 'fuente':
                return"
                    SELECT 
                        CASE 
                            WHEN pa.caracteristica = 'certificacion_fuente' THEN CONCAT('Certificacion: ', cf.certificacion_fuente)
                            WHEN pa.caracteristica = 'potencia_fuente' THEN CONCAT('Potencia: ', pf.potencia_fuente)
                            WHEN pa.caracteristica = 'tamanio_fuente' THEN CONCAT('Tamaño: ', tf.tamanio_fuente)
                            ELSE NULL
                        END AS caracteristica
                    FROM 
                        producto_caracteristica pa
                    LEFT JOIN certificacion_fuente cf ON pa.valor_caracteristica = cf.id_hardware AND pa.caracteristica = 'certificacion_fuente'
                    LEFT JOIN potencia_fuente pf ON pa.valor_caracteristica = pf.id_hardware AND pa.caracteristica = 'potencia_fuente'
                    LEFT JOIN tamanio_fuente tf ON pa.valor_caracteristica = tf.id_hardware AND pa.caracteristica = 'tamanio_fuente'
                    WHERE pa.id_producto = '$id_producto'
                ";
            case 'gabinete':
                return "
                    SELECT 
                        CASE 
                            WHEN pa.caracteristica = 'tamanio_max_gabinete' THEN CONCAT('Tamaño maximo de placa: ', tmg.tamanio_max_gabinete)
                            WHEN pa.caracteristica = 'iluminacion' THEN CONCAT('Iluminacion: ', i.iluminacion)
                            ELSE NULL
                        END AS caracteristica
                    FROM 
                        producto_caracteristica pa
                    LEFT JOIN tamanio_max_gabinete tmg ON pa.valor_caracteristica = tmg.id_hardware AND pa.caracteristica = 'tamanio_max_gabinete'
                    LEFT JOIN iluminacion i ON pa.valor_caracteristica = i.id_periferico AND pa.caracteristica = 'iluminacion'
                    WHERE pa.id_producto = '$id_producto'
                ";
            case 'notebook':
                return"
                    SELECT 
                        CASE 
                            WHEN pa.caracteristica = 'bateria_notebook' THEN CONCAT('Bateria: ', bn.bateria_notebook)
                            WHEN pa.caracteristica = 'cpu_notebook' THEN CONCAT('Procesador: ', cn.cpu_notebook)
                            WHEN pa.caracteristica = 'gpu_notebook' THEN CONCAT('Tarjeta de video maximo de placa: ', gn.gpu_notebook)
                            WHEN pa.caracteristica = 'pantalla_notebook' THEN CONCAT('Pantalla: ', pn.pantalla_notebook)
                            WHEN pa.caracteristica = 'capacidad_ram' THEN CONCAT('RAM: ', cr.capacidad_ram)
                            ELSE NULL
                        END AS caracteristica
                    FROM 
                        producto_caracteristica pa
                    LEFT JOIN bateria_notebook bn ON pa.valor_caracteristica = bn.id_notebook AND pa.caracteristica = 'bateria_notebook'
                    LEFT JOIN cpu_notebook cn ON pa.valor_caracteristica = cn.id_notebook AND pa.caracteristica = 'cpu_notebook'
                    LEFT JOIN gpu_notebook gn ON pa.valor_caracteristica = gn.id_notebook AND pa.caracteristica = 'gpu_notebook'
                    LEFT JOIN pantalla_notebook pn ON pa.valor_caracteristica = pn.id_notebook AND pa.caracteristica = 'pantalla_notebook'
                    LEFT JOIN capacidad_ram cr ON pa.valor_caracteristica = cr.id_hardware AND pa.caracteristica = 'capacidad_ram'
                    WHERE pa.id_producto = '$id_producto'
                ";
            // Agrega más casos según los tipos de productos...
            default:
                return "SELECT 'No hay características disponibles' AS caracteristica WHERE 1=0"; // Consulta que no devuelve filas
        }
    }
    ?>
    <a href="../index.php" class="btn btn-secondary back-to-store">Volver a la Tienda</a>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>


