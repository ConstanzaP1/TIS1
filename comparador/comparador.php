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
    if (empty($_SESSION['comparador'])) {
        $_SESSION['comparador'] = [];
    }
    cargar_productos_y_caracteristicas();
    header("Location: comparador.php");
    exit();
}

// Función para cargar productos y sus características
function cargar_productos_y_caracteristicas() {
    global $conexion;

    if (empty($_SESSION['comparador']) || !is_array($_SESSION['comparador'])) {
        $_SESSION['productos'] = [];
        $_SESSION['caracteristicas_producto'] = [];
        return;
    }

    // Filtrar los IDs para asegurarnos de que sean números válidos
    $product_ids = array_filter($_SESSION['comparador'], 'is_numeric');

    if (empty($product_ids)) {
        $_SESSION['productos'] = [];
        $_SESSION['caracteristicas_producto'] = [];
        return;
    }

    // Convertir los IDs en una lista separada por comas
    $product_ids = implode(',', $product_ids);

    $query = "SELECT id_producto, nombre_producto, imagen_url, precio, tipo_producto FROM producto WHERE id_producto IN ($product_ids)";
    $result = mysqli_query($conexion, $query);

    // Validar si la consulta es correcta
    if (!$result) {
        die("Error en la consulta de productos: " . mysqli_error($conexion));
    }

    $productos = [];
    $caracteristicas_producto = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $productos[] = $row;

        // Generar la consulta de características según el tipo de producto
        $query_caracteristicas = obtener_query_caracteristicas($row['tipo_producto'], $row['id_producto']);
        if (!$query_caracteristicas) {
            continue; // Si no hay consulta, saltar este producto
        }

        $result_caracteristicas = mysqli_query($conexion, $query_caracteristicas);

        // Validar si la consulta de características es correcta
        if (!$result_caracteristicas) {
            die("Error en la consulta de características: " . mysqli_error($conexion));
        }

        $caracteristicas = [];
        if (mysqli_num_rows($result_caracteristicas) > 0) {
            while ($caracteristica = mysqli_fetch_assoc($result_caracteristicas)) {
                $caracteristicas[] = $caracteristica['caracteristica'];
            }
        }
        $caracteristicas_producto[$row['id_producto']] = $caracteristicas;
    }

    $_SESSION['productos'] = $productos;
    $_SESSION['caracteristicas_producto'] = $caracteristicas_producto;
}

// Función para obtener la consulta de características según el tipo de producto
function obtener_query_caracteristicas($tipo_producto, $id_producto) {
    if (empty($tipo_producto) || empty($id_producto)) {
        return null;
    }

    switch ($tipo_producto) {
        case 'teclado':
            return "
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

        case 'monitor':
            return "
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
            return "
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
            return "
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
        // Repite para cada tipo de producto...
        default:
            return null;
    }
}

// Cargar productos y características iniciales
cargar_productos_y_caracteristicas();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comparador de Productos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .navbar {
            background-color: rgba(0, 128, 255, 0.5); /* Fondo celeste */
        }
        .product-img {
            height: 200px;
            object-fit: cover;
        }
        .empty-comparator {
            margin-top: 50px;
        }
        .card {
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            transition: transform 0.3s ease;
        }
        .card:hover {
            transform: translateY(-5px);
        }
        .card-title {
            font-size: 1.2rem;
            font-weight: bold;
        }
        .btn-eliminar {
            transition: background-color 0.3s ease;
        }
        .btn-eliminar:hover {
            background-color: #ff4d4d;
            color: white;
        }
        @media (max-width: 768px) {
            .product-img {
                height: 150px;
            }
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
        <!-- Logo -->
        <a href="../index.php" class="navbar-brand">
            <img src="../logopng.png" alt="Logo" class="img-fluid rounded-pill" style="height: 40px;">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <button type="button" class="btn btn-cart p-3 ms-2 rounded-pill" onclick="window.location.href='../carrito/carrito.php'">
                        <i class="fas fa-shopping-cart"></i>
                    </button>
                </li>
                <li class="nav-item">
                    <button type="button" class="btn btn-comparar p-3 ms-2 rounded-pill me-2" onclick="window.location.href='../comparador/comparador.php'">
                        <i class="fas fa-exchange-alt"></i>
                    </button>
                </li>
                <li class="nav-item">
                    <button type="button" class="btn btn-deseos p-3 ms-2 rounded-pill me-2" onclick="window.location.href='../lista_deseos/lista_deseos.php'">
                        <i class="fas fa-heart"></i>
                    </button>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle bg-white rounded-pill p-3" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Bienvenid@, <?php echo htmlspecialchars($_SESSION['username']); ?>!
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item text-danger" href="../login/logout.php">Cerrar Sesión</a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item ms-2">
                    <a href="../perfil_usuario/perfil_usuario.php">
                        <img src="<?php echo htmlspecialchars($img_url); ?>" alt="Foto de perfil" class="rounded-circle" style="width: 50px; height: 50px; object-fit: cover;">
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <h2 class="text-center mb-4">Comparador de Productos</h2>
    <div class="row justify-content-center g-4">
        <?php if (!empty($_SESSION['productos'])): ?>
            <?php foreach ($_SESSION['productos'] as $producto): ?>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card">
                        <img src="<?php echo htmlspecialchars($producto['imagen_url']); ?>" class="card-img-top product-img" alt="<?php echo htmlspecialchars($producto['nombre_producto']); ?>">
                        <div class="card-body">
                            <h5 class="card-title text-center"><?php echo htmlspecialchars($producto['nombre_producto']); ?></h5>
                            <p class="card-text text-center">Precio: $<?php echo number_format($producto['precio'], 0, ',', '.'); ?></p>
                            <h6 class="text-center mt-3">Características:</h6>
                            <ul class="list-unstyled">
                                <?php foreach ($_SESSION['caracteristicas_producto'][$producto['id_producto']] as $caracteristica): ?>
                                    <li><i class="fas fa-check-circle text-success"></i> <?php echo htmlspecialchars($caracteristica); ?></li>
                                <?php endforeach; ?>
                            </ul>
                            <form method="POST" action="comparador.php" class="text-center mt-3">
                                <input type="hidden" name="id_producto" value="<?php echo $producto['id_producto']; ?>">
                                <button type="submit" name="eliminar_comparador" class="btn btn-danger btn-eliminar">Eliminar</button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="empty-comparator text-center">
                <div class="card p-5 shadow">
                    <h4 class="mb-3">No hay productos en el comparador</h4>
                    <a href="../index.php" class="btn btn-primary">Regresar al catálogo</a>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
