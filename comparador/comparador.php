<?php
session_start();
require('../conexion.php');
// Verificar si el usuario está autenticado
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login/login.php");
    exit();
}

// Obtener datos del usuario
$user_id = $_SESSION['user_id'];
$queryUser = "SELECT username, img FROM users WHERE id = ?";
$stmtUser = $conexion->prepare($queryUser);
$stmtUser->bind_param("i", $user_id);
$stmtUser->execute();
$resultUser = $stmtUser->get_result();
$userData = $resultUser->fetch_assoc();
$stmtUser->close();

// Establecer imagen de perfil por defecto si no se encuentra en la base de datos
$img_url = $userData['img'] ?? 'https://static.vecteezy.com/system/resources/previews/007/167/661/non_2x/user-blue-icon-isolated-on-white-background-free-vector.jpg';
// Eliminar un producto del comparador
if (isset($_POST['eliminar_comparador'])) {
    $id_producto = $_POST['id_producto'];
    if (isset($_SESSION['comparador']) && is_array($_SESSION['comparador'])) {
        $_SESSION['comparador'] = array_filter($_SESSION['comparador'], function ($item) use ($id_producto) {
            return $item != $id_producto;
        });
    }
    // Si el comparador queda vacío, establecerlo como un array vacío
    if (empty($_SESSION['comparador'])) {
        $_SESSION['comparador'] = [];
    }
    calcular_puntajes();
    header("Location: comparador.php");
    exit();
}

// Función para calcular puntajes de productos
function calcular_puntajes() {
    global $conexion;

    if (empty($_SESSION['comparador'])) {
        $_SESSION['productos'] = [];
        $_SESSION['caracteristicas_producto'] = [];
        $_SESSION['puntajes'] = [];
        return;
    }

    $product_ids = implode(',', $_SESSION['comparador']);
    $query = "SELECT id_producto, nombre_producto, imagen_url, precio, tipo_producto FROM producto WHERE id_producto IN ($product_ids)";
    $result = mysqli_query($conexion, $query);

    $productos = [];
    $caracteristicas_producto = [];
    $puntajes = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $productos[] = $row;

        // Obtener características según el tipo de producto
        switch ($row['tipo_producto']) {
            case 'teclado':
                $query_caracteristicas = "
                    SELECT 
                        CASE 
                            WHEN pa.caracteristica = 'tipo_teclado' THEN CONCAT('Tipo de Teclado: ', tt.tipo_teclado) 
                            WHEN pa.caracteristica = 'tipo_switch' THEN CONCAT('Tipo de Switch: ', ts.tipo_switch) 
                            WHEN pa.caracteristica = 'conectividad' THEN CONCAT('Conectividad: ', c.conectividad)
                            WHEN pa.caracteristica = 'iluminacion' THEN CONCAT('Iluminación: ', i.iluminacion)
                            WHEN pa.caracteristica = 'categoria_teclado' THEN CONCAT('Categoría teclado: ', ct.categoria_teclado)
                        END AS caracteristica
                    FROM 
                        producto_caracteristica pa
                    LEFT JOIN tipo_teclado tt ON pa.valor_caracteristica = tt.id_periferico AND pa.caracteristica = 'tipo_teclado'
                    LEFT JOIN tipo_switch ts ON pa.valor_caracteristica = ts.id_periferico AND pa.caracteristica = 'tipo_switch'
                    LEFT JOIN conectividad c ON pa.valor_caracteristica = c.id_periferico AND pa.caracteristica = 'conectividad'
                    LEFT JOIN iluminacion i ON pa.valor_caracteristica = i.id_periferico AND pa.caracteristica = 'iluminacion'
                    LEFT JOIN categoria_teclado ct ON pa.valor_caracteristica = ct.id_periferico AND pa.caracteristica = 'categoria_teclado'
                    WHERE pa.id_producto = '{$row['id_producto']}'";
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
                    WHERE pa.id_producto = '{$row['id_producto']}'";
                break;

            case 'audifono':
                $query_caracteristicas = "
                    SELECT 
                        CASE 
                            WHEN pa.caracteristica = 'tipo_audifono' THEN CONCAT('Tipo de Audífono: ', ta.tipo_audifono)
                            WHEN pa.caracteristica = 'tipo_microfono' THEN CONCAT('Tipo de Micrófono: ', tm.tipo_microfono)
                            WHEN pa.caracteristica = 'anc' THEN CONCAT('Cancelación de ruido: ', a.anc)
                            WHEN pa.caracteristica = 'iluminacion' THEN CONCAT('Iluminación: ', i.iluminacion)
                            WHEN pa.caracteristica = 'conectividad' THEN CONCAT('Conectividad: ', c.conectividad)
                        END AS caracteristica
                    FROM 
                        producto_caracteristica pa
                    LEFT JOIN tipo_audifono ta ON pa.valor_caracteristica = ta.id_periferico AND pa.caracteristica = 'tipo_audifono'
                    LEFT JOIN tipo_microfono tm ON pa.valor_caracteristica = tm.id_periferico AND pa.caracteristica = 'tipo_microfono'
                    LEFT JOIN anc a ON pa.valor_caracteristica = a.id_periferico AND pa.caracteristica = 'anc'
                    LEFT JOIN iluminacion i ON pa.valor_caracteristica = i.id_periferico AND pa.caracteristica = 'iluminacion'
                    LEFT JOIN conectividad c ON pa.valor_caracteristica = c.id_periferico AND pa.caracteristica = 'conectividad'
                    WHERE pa.id_producto = '{$row['id_producto']}'";
                break;

            case 'mouse':
                $query_caracteristicas = "
                    SELECT 
                        CASE 
                            WHEN pa.caracteristica = 'dpi_mouse' THEN CONCAT('DPI: ', dm.dpi_mouse)
                            WHEN pa.caracteristica = 'peso_mouse' THEN CONCAT('Peso: ', pm.peso_mouse)
                            WHEN pa.caracteristica = 'sensor_mouse' THEN CONCAT('Sensor: ', sm.sensor_mouse)
                            WHEN pa.caracteristica = 'iluminacion' THEN CONCAT('Iluminación: ', i.iluminacion)
                            WHEN pa.caracteristica = 'conectividad' THEN CONCAT('Conectividad: ', c.conectividad)
                        END AS caracteristica
                    FROM 
                        producto_caracteristica pa
                    LEFT JOIN dpi_mouse dm ON pa.valor_caracteristica = dm.id_periferico AND pa.caracteristica = 'dpi_mouse'
                    LEFT JOIN peso_mouse pm ON pa.valor_caracteristica = pm.id_periferico AND pa.caracteristica = 'peso_mouse'
                    LEFT JOIN sensor_mouse sm ON pa.valor_caracteristica = sm.id_periferico AND pa.caracteristica = 'sensor_mouse'
                    LEFT JOIN iluminacion i ON pa.valor_caracteristica = i.id_periferico AND pa.caracteristica = 'iluminacion'
                    LEFT JOIN conectividad c ON pa.valor_caracteristica = c.id_periferico AND pa.caracteristica = 'conectividad'
                    WHERE pa.id_producto = '{$row['id_producto']}'";
                break;

            case 'cpu':
                $query_caracteristicas = "
                    SELECT 
                        CASE 
                            WHEN pa.caracteristica = 'frecuencia_cpu' THEN CONCAT('Frecuencia: ', fc.frecuencia_cpu)
                            WHEN pa.caracteristica = 'nucleo_hilo_cpu' THEN CONCAT('Núcleo / Hilo: ', nhc.nucleo_hilo_cpu)
                            WHEN pa.caracteristica = 'socket_cpu' THEN CONCAT('Socket: ', sc.socket_cpu)
                        END AS caracteristica
                    FROM 
                        producto_caracteristica pa
                    LEFT JOIN frecuencia_cpu fc ON pa.valor_caracteristica = fc.id_hardware AND pa.caracteristica = 'frecuencia_cpu'
                    LEFT JOIN nucleo_hilo_cpu nhc ON pa.valor_caracteristica = nhc.id_hardware AND pa.caracteristica = 'nucleo_hilo_cpu'
                    LEFT JOIN socket_cpu sc ON pa.valor_caracteristica = sc.id_hardware AND pa.caracteristica = 'socket_cpu'
                    WHERE pa.id_producto = '{$row['id_producto']}'";
                break;

            case 'gpu':
                $query_caracteristicas = "
                    SELECT 
                        CASE 
                            WHEN pa.caracteristica = 'frecuencia_gpu' THEN CONCAT('Frecuencia: ', fg.frecuencia_gpu)
                            WHEN pa.caracteristica = 'memoria_gpu' THEN CONCAT('Memoria: ', mg.memoria_gpu)
                        END AS caracteristica
                    FROM 
                        producto_caracteristica pa
                    LEFT JOIN frecuencia_gpu fg ON pa.valor_caracteristica = fg.id_hardware AND pa.caracteristica = 'frecuencia_gpu'
                    LEFT JOIN memoria_gpu mg ON pa.valor_caracteristica = mg.id_hardware AND pa.caracteristica = 'memoria_gpu'
                    WHERE pa.id_producto = '{$row['id_producto']}'";
                break;

            case 'placa':
                $query_caracteristicas = "
                    SELECT 
                        CASE 
                            WHEN pa.caracteristica = 'formato_placa' THEN CONCAT('Formato: ', fp.formato_placa)
                            WHEN pa.caracteristica = 'slot_memoria_placa' THEN CONCAT('Slots de memoria: ', smp.slot_memoria_placa)
                            WHEN pa.caracteristica = 'socket_placa' THEN CONCAT('Socket: ', sp.socket_placa)
                            WHEN pa.caracteristica = 'chipset_placa' THEN CONCAT('Chipset: ', cp.chipset_placa)
                        END AS caracteristica
                    FROM 
                        producto_caracteristica pa
                    LEFT JOIN formato_placa fp ON pa.valor_caracteristica = fp.id_hardware AND pa.caracteristica = 'formato_placa'
                    LEFT JOIN slot_memoria_placa smp ON pa.valor_caracteristica = smp.id_hardware AND pa.caracteristica = 'slot_memoria_placa'
                    LEFT JOIN socket_placa sp ON pa.valor_caracteristica = sp.id_hardware AND pa.caracteristica = 'socket_placa'
                    LEFT JOIN chipset_placa cp ON pa.valor_caracteristica = cp.id_hardware AND pa.caracteristica = 'chipset_placa'
                    WHERE pa.id_producto = '{$row['id_producto']}'";
                break;

            case 'ram':
                $query_caracteristicas = "
                    SELECT 
                        CASE 
                            WHEN pa.caracteristica = 'tipo_ram' THEN CONCAT('Tipo: ', tr.tipo_ram)
                            WHEN pa.caracteristica = 'velocidad_ram' THEN CONCAT('Velocidad: ', vr.velocidad_ram)
                            WHEN pa.caracteristica = 'capacidad_ram' THEN CONCAT('Capacidad: ', cr.capacidad_ram)
                            WHEN pa.caracteristica = 'formato_ram' THEN CONCAT('Formato: ', fr.formato_ram)
                        END AS caracteristica
                    FROM 
                        producto_caracteristica pa
                    LEFT JOIN tipo_ram tr ON pa.valor_caracteristica = tr.id_hardware AND pa.caracteristica = 'tipo_ram'
                    LEFT JOIN velocidad_ram vr ON pa.valor_caracteristica = vr.id_hardware AND pa.caracteristica = 'velocidad_ram'
                    LEFT JOIN capacidad_ram cr ON pa.valor_caracteristica = cr.id_hardware AND pa.caracteristica = 'capacidad_ram'
                    LEFT JOIN formato_ram fr ON pa.valor_caracteristica = fr.id_hardware AND pa.caracteristica = 'formato_ram'
                    WHERE pa.id_producto = '{$row['id_producto']}'";
                break;

            case 'fuente':
                $query_caracteristicas = "
                    SELECT 
                        CASE 
                            WHEN pa.caracteristica = 'certificacion_fuente' THEN CONCAT('Certificación: ', cf.certificacion_fuente)
                            WHEN pa.caracteristica = 'potencia_fuente' THEN CONCAT('Potencia: ', pf.potencia_fuente)
                            WHEN pa.caracteristica = 'tamanio_fuente' THEN CONCAT('Tamaño: ', tf.tamanio_fuente)
                        END AS caracteristica
                    FROM 
                        producto_caracteristica pa
                    LEFT JOIN certificacion_fuente cf ON pa.valor_caracteristica = cf.id_hardware AND pa.caracteristica = 'certificacion_fuente'
                    LEFT JOIN potencia_fuente pf ON pa.valor_caracteristica = pf.id_hardware AND pa.caracteristica = 'potencia_fuente'
                    LEFT JOIN tamanio_fuente tf ON pa.valor_caracteristica = tf.id_hardware AND pa.caracteristica = 'tamanio_fuente'
                    WHERE pa.id_producto = '{$row['id_producto']}'";
                break;

            case 'gabinete':
                $query_caracteristicas = "
                    SELECT 
                        CASE 
                            WHEN pa.caracteristica = 'tamanio_max_gabinete' THEN CONCAT('Tamaño máximo de placa: ', tmg.tamanio_max_gabinete)
                            WHEN pa.caracteristica = 'iluminacion' THEN CONCAT('Iluminación: ', i.iluminacion)
                        END AS caracteristica
                    FROM 
                        producto_caracteristica pa
                    LEFT JOIN tamanio_max_gabinete tmg ON pa.valor_caracteristica = tmg.id_hardware AND pa.caracteristica = 'tamanio_max_gabinete'
                    LEFT JOIN iluminacion i ON pa.valor_caracteristica = i.id_periferico AND pa.caracteristica = 'iluminacion'
                    WHERE pa.id_producto = '{$row['id_producto']}'";
                break;

            case 'notebook':
                $query_caracteristicas = "
                    SELECT 
                        CASE 
                            WHEN pa.caracteristica = 'bateria_notebook' THEN CONCAT('Batería: ', bn.bateria_notebook)
                            WHEN pa.caracteristica = 'cpu_notebook' THEN CONCAT('Procesador: ', cn.cpu_notebook)
                            WHEN pa.caracteristica = 'gpu_notebook' THEN CONCAT('Tarjeta de video: ', gn.gpu_notebook)
                            WHEN pa.caracteristica = 'pantalla_notebook' THEN CONCAT('Pantalla: ', pn.pantalla_notebook)
                            WHEN pa.caracteristica = 'capacidad_ram' THEN CONCAT('RAM: ', cr.capacidad_ram)
                        END AS caracteristica
                    FROM 
                        producto_caracteristica pa
                    LEFT JOIN bateria_notebook bn ON pa.valor_caracteristica = bn.id_notebook AND pa.caracteristica = 'bateria_notebook'
                    LEFT JOIN cpu_notebook cn ON pa.valor_caracteristica = cn.id_notebook AND pa.caracteristica = 'cpu_notebook'
                    LEFT JOIN gpu_notebook gn ON pa.valor_caracteristica = gn.id_notebook AND pa.caracteristica = 'gpu_notebook'
                    LEFT JOIN pantalla_notebook pn ON pa.valor_caracteristica = pn.id_notebook AND pa.caracteristica = 'pantalla_notebook'
                    LEFT JOIN capacidad_ram cr ON pa.valor_caracteristica = cr.id_hardware AND pa.caracteristica = 'capacidad_ram'
                    WHERE pa.id_producto = '{$row['id_producto']}'";
                break;


            default:
                $query_caracteristicas = "SELECT caracteristica FROM producto_caracteristica WHERE id_producto = '{$row['id_producto']}'";
                break;
        }

        $result_caracteristicas = mysqli_query($conexion, $query_caracteristicas);
        $caracteristicas = [];
        if ($result_caracteristicas && mysqli_num_rows($result_caracteristicas) > 0) {
            while ($caracteristica = mysqli_fetch_assoc($result_caracteristicas)) {
                if (!empty($caracteristica['caracteristica'])) {
                    $caracteristicas[] = $caracteristica['caracteristica'];
                }
            }
        }
        $caracteristicas_producto[$row['id_producto']] = $caracteristicas;

        // Calcular puntaje
        $puntaje = 0;
        foreach ($caracteristicas as $caracteristica) {
            if (strpos($caracteristica, 'Switch') !== false) {
                $puntaje += 3;
            } elseif (strpos($caracteristica, 'Iluminación') !== false) {
                $puntaje += 1;
            } else {
                $puntaje += 2;
            }
        }
        $puntaje += ($row['precio'] < 50000) ? 5 : 0;
        $puntajes[$row['id_producto']] = $puntaje;
    }

    $_SESSION['productos'] = $productos;
    $_SESSION['caracteristicas_producto'] = $caracteristicas_producto;
    $_SESSION['puntajes'] = $puntajes;
}

// Calcular puntajes iniciales
calcular_puntajes();

// Determinar el mejor producto
$mejor_producto_id = !empty($_SESSION['puntajes']) ? array_keys($_SESSION['puntajes'], max($_SESSION['puntajes']))[0] : null;
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comparador de Productos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        .navbar{
        background-color: rgba(0, 128, 255, 0.5);   
        }
        .celeste-background{
        background-color: rgba(0, 128, 255, 0.5); 
        border-color: rgba(0, 128, 255, 0.5);   
        }
        .btn-cart:hover {
    background-color: white; /* Cambia el fondo al pasar el mouse */
    color: #721c24; /* Cambia el color del texto/icono */
    transform: scale(1.1); /* Hace que el botón crezca ligeramente */
    transition: all 0.3s ease; /* Suaviza la animación */
}

/* Estilo para el botón de comparar */
.btn-comparar:hover {
    background-color: white; /* Cambia el fondo al pasar el mouse */
    color: #155724; /* Cambia el color del texto/icono */
    transform: scale(1.1); /* Hace que el botón crezca ligeramente */
    transition: all 0.3s ease; /* Suaviza la animación */
}
.btn-deseos:hover {
    background-color: white; /* Cambia el fondo al pasar el mouse */
    color: #721c24; /* Cambia el color del texto/icono */
    transform: scale(1.1); /* Hace que el botón crezca ligeramente */
    transition: all 0.3s ease; /* Suaviza la animación */
}
    </style>
</head>
<nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
        <!-- Logo -->
        <div class="navbar-brand col-2  ">
            <a href="../index.php">
                <img class="logo img-fluid w-75 rounded-pill" src="../logopng.png" alt="Logo">
            </a>
        </div>
        <!-- Botón para colapsar el menú en pantallas pequeñas -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Contenido de la navbar -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <!-- Menú desplegable -->
            <ul class="navbar-nav ms-auto">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li class="nav-item">
                    <button type="button" class="btn btn-cart p-3 ms-2 rounded-pill" onclick="window.location.href='../carrito/carrito.php'">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-cart" viewBox="0 0 16 16">
                            <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5M3.102 4l1.313 7h8.17l1.313-7zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4m7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4m-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2m7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2"/>
                        </svg>
                    </button>
                </li>
                <li class="nav-item">
                    <button type="button" class="btn btn-comparar p-3 ms-2 rounded-pill me-2" onclick="window.location.href='../comparador/comparador.php'">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left-right" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M1 11.5a.5.5 0 0 0 .5.5h11.793l-3.147 3.146a.5.5 0 0 0 .708.708l4-4a.5.5 0 0 0 0-.708l-4-4a.5.5 0 0 0-.708.708L13.293 11H1.5a.5.5 0 0 0-.5.5m14-7a.5.5 0 0 1-.5.5H2.707l3.147 3.146a.5.5 0 1 1-.708.708l-4-4a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 4H14.5a.5.5 0 0 1 .5.5"/>
                        </svg>
                    </button>
                </li>
                <li>
                    <button type="button" class="btn btn-deseos p-3 ms-2 rounded-pill me-2" onclick="window.location.href='../lista_deseos/lista_deseos.php'">
                    <i class='fas fa-heart'></i>
                    </button>
                   
                </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle bg-white rounded-pill p-3" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Bienvenid@, <?php echo htmlspecialchars($_SESSION['username']); ?>!
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                        <?php if (in_array($_SESSION['role'], ['admin', 'superadmin'])): ?>
                                <li>
                                    <a class="dropdown-item" href="../admin_panel/admin_panel.php">Panel Admin</a>
                                </li>
                            <?php endif; ?>

                            <li>
                                <a class="dropdown-item text-danger" href="../login/logout.php">Cerrar Sesión</a>
                            </li>
                        </ul>
                    </li>
                    <a class="dropdown-item" href="../perfil_usuario/perfil_usuario.php">
                        <li class="nav-item ms-2">
                            <img src="<?php echo htmlspecialchars($img_url); ?>" alt="Foto de perfil" class="rounded-circle" style="width: 50px; height: 50px; object-fit: cover;">
                        </li>
                    </a>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="btn btn-primary" href="login/login.php">Iniciar Sesión</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Comparador de Productos</h2>
        <div class="row justify-content-center">
            <?php if (!empty($_SESSION['productos'])): ?>
                <?php foreach ($_SESSION['productos'] as $index => $producto): ?>
                    <div class="col-md-4">
                        <div class="card">
                            <img src="<?php echo htmlspecialchars($producto['imagen_url']); ?>" class="card-img-top product-img" alt="<?php echo htmlspecialchars($producto['nombre_producto']); ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($producto['nombre_producto']); ?></h5>
                                <p class="card-text">Precio: $<?php echo number_format($producto['precio'], 0, ',', '.'); ?></p>
                                <ul>
                                    <?php foreach ($_SESSION['caracteristicas_producto'][$producto['id_producto']] as $caracteristica): ?>
                                        <li><?php echo htmlspecialchars($caracteristica); ?></li>
                                    <?php endforeach; ?>
                                </ul>
                                <form method="POST" action="comparador.php" class="d-inline">
                                    <input type="hidden" name="id_producto" value="<?php echo $producto['id_producto']; ?>">
                                    <button type="submit" name="eliminar_comparador" class="btn btn-danger btn-sm">Eliminar</button>
                                </form>
                            </div>
                            <?php if ($producto['id_producto'] == $mejor_producto_id): ?>
                                <div class="card-footer text-success text-center">
                                    Mejor relación calidad/precio
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="empty-comparator mt-5">
                    <div class="card shadow-lg p-5 border-0 text-center">
                        <div class="mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" fill="currentColor" class="bi bi-box-seam text-primary" viewBox="0 0 16 16">
                                <path d="M9.674 4.146a.5.5 0 0 1-.348-.217L8 2.5 6.674 3.929a.5.5 0 0 1-.348.217l-2.5.385.831.831a.5.5 0 0 1 .138.34l.035 2.487a.5.5 0 0 1-.205.417l-.832.831 2.5.385a.5.5 0 0 1 .342.33L8 13.5l1.026-1.025a.5.5 0 0 1 .342-.33l2.5-.385-.832-.831a.5.5 0 0 1-.205-.417l.035-2.487a.5.5 0 0 1 .138-.34l.831-.831-2.5-.385zM2.857 1.399a1.5 1.5 0 0 1 1.071-.399h8.143c.414 0 .801.17 1.071.399L16 3.063v9.874l-2.857 1.664A1.5 1.5 0 0 1 12.071 15H3.929a1.5 1.5 0 0 1-1.071-.399L0 12.937V3.063l2.857-1.664zm1.144.937A.5.5 0 0 0 3.5 2H12.5a.5.5 0 0 0 .499-.664L10.929.5H5.071L4.357 1.399zm7.5.101a.5.5 0 0 1 .499-.664L13.5 2H2.5L4.357.835a.5.5 0 0 1 .499.664L2.5 2h11z"/>
                            </svg>
                        </div>
                        <h4 class="mb-3 text-secondary">No hay productos en el comparador</h4>
                        <p class="text-muted mb-4">Añade productos para comparar características y precios.</p>
                        <a href="../index.php" class="btn btn-primary btn-lg">Añadir al Comparador</a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <?php include "../footer.php"?>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</html>
