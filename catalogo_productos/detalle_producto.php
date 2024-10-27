<?php
session_start();
?>

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
    
<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <div class="row col-2 ">
            <img class="img-fluid w-75" src="https://upload.wikimedia.org/wikipedia/commons/d/df/Ripley_Logo.png" alt="">
        </div>
        <div class="row col-6 ">
            <form class="d-flex" role="search">
                <input class="form-control me-2" type="search" placeholder="Buscar" aria-label="Search">
                <button class="btn btn-primary" type="submit">Buscar</button>
            </form>
        </div>
        <div class="row col-4 text-end">
            <?php if (isset($_SESSION['user_id'])): ?>
                <div class="align-items-center">
                    <span class="me-2">Bienvenido, <?php echo htmlspecialchars($_SESSION['username']); ?>!</span>
                    <?php if ($_SESSION['role'] === 'admin'): ?>
                        <button type="button" class="btn btn-primary me-1" onclick="window.location.href='admin_panel/admin_panel.php';">Panel Admin</button>
                    <?php endif; ?>
                    <button type="button" class="btn btn-primary" onclick="window.location.href='../carrito/carrito.php';">Mi Carro</button>
                    <button type="button" class="btn btn-danger" onclick="window.location.href='login/logout.php';">Cerrar Sesión</button>
                </div>
            <?php else: ?>
                <button type="button" class="btn btn-primary" onclick="window.location.href='login/login.php';">Iniciar Sesión</button>
            <?php endif; ?>
        </div>
    </div>
</nav>
<div class="container py-5">
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
                    <ul>";
                    echo "
                            <form method='POST' action='../carrito/agregar_al_carrito.php'>
                                <input type='hidden' name='id_producto' value='{$id_producto}'>
                                <label>Cantidad:</label>
                                <input type='number' name='cantidad' value='1' min='1' class='form-control w-25 mb-3'>
                                <button type='submit' name='agregar_carrito' class='btn btn-primary'>Agregar al Carrito</button>
                            </form>
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

                case 'cpu':
                    $query_caracteristicas = "
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
                        break;

                case 'gpu':
                    $query_caracteristicas = "
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
                        break;

                case 'placa':
                    $query_caracteristicas = "
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
                        break;

                case 'ram':
                    $query_caracteristicas = "
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
                        break;
                case 'fuente':
                    $query_caracteristicas = "
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
                        break;
                case 'gabinete':
                    $query_caracteristicas = "
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
                        break;
                case 'notebook':
                    $query_caracteristicas = "
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
                        break;

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
                    </ul>";

            // Botones de acción según el rol del usuario
            if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
                echo "<button class='btn btn-danger mt-3 mx-1'>Eliminar producto</button>";
            } elseif (isset($_SESSION['role']) && $_SESSION['role'] === 'user')
            echo "<a href='../index.php' class='btn btn-secondary mt-3'>Volver al Catálogo</a>
                </div>
            </div>";
        } else {
            echo "<p>Producto no encontrado.</p>";
        }
    } else {
        echo "<p>ID de producto no proporcionado.</p>";
    }
    mysqli_close($conexion);
    ?>
    
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
