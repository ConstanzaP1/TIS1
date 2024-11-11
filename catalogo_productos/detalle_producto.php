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
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>
<style>
    .navbar{
        background-color: rgba(0, 128, 255, 0.5);   
    }
    .celeste-background{
        background-color: rgba(0, 128, 255, 0.5); 
        border-color: rgba(0, 128, 255, 0.5);   
    }
    .card-body{
        background-color: #e0e0e0;
    }
    body{
        background-color: #e0e0e0;
    }
    .star-rating {
    direction: rtl;
    font-size: 2em;
    display: inline-flex;
}
.star-rating input[type="radio"] {
    display: none;
}
.star-rating label {
    color: #ccc;
    cursor: pointer;
}
.star-rating input[type="radio"]:checked ~ label,
.star-rating label:hover,
.star-rating label:hover ~ label {
    color: #f5c518;
}

</style>
<body>
        
<nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
        <!-- Logo -->
        <div class="navbar-brand col-2  ">
            <img class="logo img-fluid w-75 rounded-pill" src="../Logopng.png" alt="Logo">
        </div>

        <!-- Botón para colapsar el menú en pantallas pequeñas -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Contenido de la navbar -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <!-- Barra de búsqueda -->
            <form class="d-flex ms-auto col-8 shadow" role="search">
                <input class="form-control" type="search" placeholder="Buscar en tisnology" aria-label="Buscar">
            </form>

            <!-- Menú desplegable -->
            <ul class="navbar-nav ms-auto">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle bg-white rounded-pill p-3" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Bienvenido, <?php echo htmlspecialchars($_SESSION['username']); ?>!
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <?php if ($_SESSION['role'] === 'admin'): ?>
                                <li>
                                    <a class="dropdown-item" href="../admin_panel/admin_panel.php">Panel Admin</a>
                                </li>
                            <?php endif; ?>
                                
                            <li>
                                <a class="dropdown-item text-danger" href="../login/logout.php">Cerrar Sesión</a>
                            </li>
                        </ul>
                        <li class="nav-item">
                            <button type="button" class="btn btn-cart p-3 ms-2 rounded-pill" onclick="window.location.href='../carrito/carrito.php'">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-cart" viewBox="0 0 16 16">
                                    <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5M3.102 4l1.313 7h8.17l1.313-7zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4m7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4m-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2m7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2"/>
                                </svg>
                            </button>
                        </li>
                        <li class="nav-item">
                            <button type="button" class="btn btn-comparar p-3 ms-2 rounded-pill" onclick="window.location.href='../comparador/comparador.php'">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left-right" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M1 11.5a.5.5 0 0 0 .5.5h11.793l-3.147 3.146a.5.5 0 0 0 .708.708l4-4a.5.5 0 0 0 0-.708l-4-4a.5.5 0 0 0-.708.708L13.293 11H1.5a.5.5 0 0 0-.5.5m14-7a.5.5 0 0 1-.5.5H2.707l3.147 3.146a.5.5 0 1 1-.708.708l-4-4a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 4H14.5a.5.5 0 0 1 .5.5"/>
                                </svg>
                            </button>
                        </li>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="btn btn-primary" href="../login/login.php">Iniciar Sesión</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<div class="container py-5">
    <?php
    require('../conexion.php');

    if (isset($_GET['id_producto'])) {
        $id_producto = $_GET['id_producto'];

        $query_producto = "
            SELECT 
                p.nombre_producto, 
                p.precio, 
                p.imagen_url, 
                m.nombre_marca AS marca,
                p.tipo_producto,
                p.cantidad AS stock_disponible
            FROM 
                producto p
            LEFT JOIN marca m ON p.marca = m.id_marca
            WHERE p.id_producto = '$id_producto'
        ";
        
        $result_producto = mysqli_query($conexion, query: $query_producto);

        if ($result_producto->num_rows > 0) {
            $producto = mysqli_fetch_assoc($result_producto);

            echo "
            <div class='producto-detalle shadow d-flex align-items-center bg-white'>
                <div class='col-6 text-center me-1'>
                    <img class='img-fluid ' src='{$producto['imagen_url']}' alt='{$producto['nombre_producto']}'>
                </div>
                <div class='producto-info col-6 p-5'>
                    <h1>{$producto['nombre_producto']}</h1>
                    <p>Precio: $" . number_format($producto['precio'], 0, ',', '.') . "</p>
                    <p><strong>Marca:</strong> {$producto['marca']}</p>
                    <p><strong>Características:</strong></p>
                    <ul>";
                        
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
                                    WHEN pa.caracteristica = 'categoria_teclado' THEN CONCAT('Categoria teclado: ', ct.categoria_teclado)
                                    ELSE NULL
                                END AS caracteristica
                            FROM 
                                producto_caracteristica pa
                            LEFT JOIN tipo_teclado tt ON pa.valor_caracteristica = tt.id_periferico AND pa.caracteristica = 'tipo_teclado'
                            LEFT JOIN tipo_switch ts ON pa.valor_caracteristica = ts.id_periferico AND pa.caracteristica = 'tipo_switch'
                            LEFT JOIN conectividad c ON pa.valor_caracteristica = c.id_periferico AND pa.caracteristica = 'conectividad'
                            LEFT JOIN iluminacion i ON pa.valor_caracteristica = i.id_periferico AND pa.caracteristica = 'iluminacion'
                            LEFT JOIN categoria_teclado ct ON pa.valor_caracteristica = ct.id_periferico AND pa.caracteristica = 'categoria_teclado'
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

                $result_caracteristicas = mysqli_query($conexion, $query_caracteristicas);

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

            if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
                echo "
                        <form method='POST' action='../carrito/agregar_al_carrito.php'>
                            <input type='hidden' name='id_producto' value='{$id_producto}'>
                            <label>Cantidad:</label>
                            <input type='number' name='cantidad' value='1' min='1' max='{$producto['stock_disponible']}' class='form-control w-25 mb-3'>
                            <p><strong>Stock disponible:</strong> {$producto['stock_disponible']}</p>
                            <button type='submit' name='agregar_carrito' class='btn btn-primary rounded-pill px-5'>Agregar al Carrito</button>
                        </form>
                        ";
                echo "
                        <form method='POST' action='../comparador/agregar_al_comparador.php'>
                            <input type='hidden' name='id_producto' value='{$id_producto}'>
                            <button type='submit' name='agregar_comparador' class='btn btn-primary rounded-pill px-5 mt-3'>Agregar al Comparador</button>
                        </form>
                        ";
                if (isset($_GET['id_producto'])) {
                    $id_producto = $_GET['id_producto'];
                    echo "<button onclick='eliminarProducto($id_producto)' class='btn btn-danger mt-3 mx-1 px-5 rounded-pill '>Eliminar producto</button>";
                }
            } elseif (isset($_SESSION['role']) && $_SESSION['role'] === 'user') {
                echo "
                        <form method='POST' action='../carrito/agregar_al_carrito.php'>
                            <input type='hidden' name='id_producto' value='{$id_producto}'>
                            <label>Cantidad:</label>
                            <input type='number' name='cantidad' value='1' min='1' max='{$producto['stock_disponible']}' class='form-control w-25 mb-3'>
                            <p><strong>Stock disponible:</strong> {$producto['stock_disponible']}</p>
                            <button type='submit' name='agregar_carrito' class='btn btn-primary rounded-pill px-5'>Agregar al Carrito</button>
                        </form>
                        ";
                echo "
                        <form method='POST' action='../comparador/agregar_al_comparador.php'>
                            <input type='hidden' name='id_producto' value='{$id_producto}'>
                            <button type='submit' name='agregar_comparador' class='btn btn-primary rounded-pill px-5 mt-3'>Agregar al Comparador</button>
                        </form>
                        ";
            }

            echo "<a href='../index.php' class='btn btn-secondary mt-3 rounded-pill px-5'>Volver al Catálogo</a>
                </div>
            </div>"; ?>

            <?php if ($id_producto) {
                $query_resenas = "SELECT rv.valoracion, rv.comentario, rv.fecha, u.username
                                FROM resena_valoracion AS rv
                                JOIN users AS u ON rv.user_id = u.id
                                WHERE rv.id_producto = '$id_producto'
                                ORDER BY rv.fecha DESC";
                $result_resenas = mysqli_query($conexion, $query_resenas);

                if (mysqli_num_rows($result_resenas) > 0) {
                    echo "<div class='container'>";
                    ?> <br> <?php
                    echo "<div class='row bg-white px-5 py-3 shadow'>";
                    echo "<h3>Reseñas</h3>";
                    while ($resena = mysqli_fetch_assoc($result_resenas)) {
                        $valoracion = intval($resena['valoracion']);
                        echo "<div class='card mb-3'>";
                        echo "<div class='card-bodyy'>";
        
                        echo "<h5 class='card-title'>";
                        for ($i = 1; $i <= 5; $i++) {
                            echo $i <= $valoracion ? "&#9733;" : "&#9734;";
                        }
                        echo " - " . htmlspecialchars($resena['username']) . "</h5>";
        
                        echo "<p class='card-text'>" . htmlspecialchars($resena['comentario']) . "</p>";
                        echo "<p class='card-text'><small class='text-muted'>Fecha: " . htmlspecialchars($resena['fecha']) . "</small></p>";
                        echo "</div>";
                     echo "</div>";
                    }
                    echo "</div>";
                } else {
                    echo "<div class='alert alert-dark'>Aún no hay reseñas para este producto.</div>";
                }
            } else {
                echo "<div class='alert alert-danger'>Error: ID de producto no encontrado.</div>";
            }
            if (isset($_SESSION['user_id'])) { ?>   
                <!-- Botón para abrir el modal de agregar reseña -->
                <button type="button" class="btn btn-primary mt-3 rounded-pill" data-bs-toggle="modal" data-bs-target="#modalAgregarResena">
                    Agregar Reseña
                </button>

                <!-- Modal para agregar reseña -->
                <div class="modal fade" id="modalAgregarResena" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Agregar Reseña</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action='../reseñas_valoraciones/procesar_resena.php?id_producto=<?php echo $id_producto; ?>' method='POST'>
                                    <div class='form-group'>
                                        <label for='valoracion'>Valoración:</label>
                                        <div class="star-rating">
                                            <input type="radio" name="valoracion" value="5" id="star-5">
                                            <label for="star-5" title="5 estrellas">&#9733;</label>
                                            <input type="radio" name="valoracion" value="4" id="star-4">
                                            <label for="star-4" title="4 estrellas">&#9733;</label>
                                            <input type="radio" name="valoracion" value="3" id="star-3">
                                            <label for="star-3" title="3 estrellas">&#9733;</label>
                                            <input type="radio" name="valoracion" value="2" id="star-2">
                                            <label for="star-2" title="2 estrellas">&#9733;</label>
                                            <input type="radio" name="valoracion" value="1" id="star-1">
                                            <label for="star-1" title="1 estrella">&#9733;</label>
                                        </div>
                                    </div>
                                    <div class='form-group'>
                                        <label for='comentario'>Comentario:</label>
                                        <textarea name='comentario' class='form-control' rows='3' required></textarea>
                                    </div>
                                    <button type='submit' name='enviar_reseña' class='btn btn-primary mt-2'>Enviar Reseña</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } 
        } else {
            echo "<p>Producto no encontrado.</p>";
        }
    } else {
        echo "<p>ID de producto no proporcionado.</p>";
    }
    mysqli_close($conexion);
    ?>
</div>
<script>

function eliminarProducto(id_producto) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: 'Esta acción eliminará el producto de forma permanente.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            // Realizar la solicitud AJAX para eliminar el producto
            fetch('eliminar_producto.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: 'id_producto=' + id_producto
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === "success") {
                    Swal.fire({
                        icon: 'success',
                        title: 'Producto eliminado',
                        text: data.message,
                        confirmButtonText: 'Aceptar'
                    }).then(() => {
                        window.location.href = '../index.php';
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: data.message,
                        confirmButtonText: 'Aceptar'
                    });
                }
            })
            .catch(error => {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Hubo un error en la solicitud.',
                    confirmButtonText: 'Aceptar'
                });
            });
        }
    });
}
</script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    </body>
    </html>
