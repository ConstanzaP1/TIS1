<?php
session_start();
require '../conexion.php';

$message = ""; // Variable para mensajes

// Obtener el ID del producto desde la URL
$id_producto = $_GET['id_producto'] ?? null;

// Consultar detalles del producto
$producto = null;
$caracteristicas = [];
if ($id_producto) {
    $query_producto = "
        SELECT 
            nombre_producto, precio, imagen_url, tipo_producto 
        FROM producto 
        WHERE id_producto = ?";
    $stmt = $conexion->prepare($query_producto);
    $stmt->bind_param("i", $id_producto);
    $stmt->execute();
    $result = $stmt->get_result();
    $producto = $result->fetch_assoc();

    // Si existe el producto, consulta sus características
    if ($producto) {
        switch ($producto['tipo_producto']) {
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
                    WHERE pa.id_producto = ?";
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
                    WHERE pa.id_producto = ?";
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
                    WHERE pa.id_producto = ?";
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
                    WHERE pa.id_producto = ?";
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
                    WHERE pa.id_producto = ?";
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
                    WHERE pa.id_producto = ?";
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
                    WHERE pa.id_producto = ?";
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
                    WHERE pa.id_producto = ?";
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
                    WHERE pa.id_producto = ?";
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
                    WHERE pa.id_producto = ?";
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
                    WHERE pa.id_producto = ?";
                break;
        
            default:
                $query_caracteristicas = "
                    SELECT caracteristica 
                    FROM producto_caracteristica 
                    WHERE id_producto = ?";
                break;
        }        

        $stmt_caracteristicas = $conexion->prepare($query_caracteristicas);
        $stmt_caracteristicas->bind_param("i", $id_producto);
        $stmt_caracteristicas->execute();
        $result_caracteristicas = $stmt_caracteristicas->get_result();
        
        while ($row = $result_caracteristicas->fetch_assoc()) {
            if (!empty($row['caracteristica'])) {
                $caracteristicas[] = $row['caracteristica'];
            }
        }
    }
}

// Procesar formulario de postventa
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["nombre"];
    $email = $_SESSION["email"] ?? $_POST["email"];
    $pregunta = $_POST["pregunta"];
    $producto_id = $_POST["id_producto"];

    $stmt = $conexion->prepare("
        INSERT INTO atencion_postventa (cliente_nombre, cliente_email, pregunta, id_producto) 
        VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssi", $nombre, $email, $pregunta, $producto_id);
    
    if ($stmt->execute()) {
        $message = "¡Tu consulta ha sido enviada con éxito! Nos pondremos en contacto contigo pronto.";
    } else {
        $message = "Ocurrió un error al enviar tu consulta. Por favor, inténtalo nuevamente.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Postventa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .navbar {
            background-color: rgba(0, 128, 255, 0.5);   
        }
        .card-body {
            background-color: #e0e0e0;
        }
        .image-container {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 300px;
        }
        .product-image {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
        <div class="navbar-brand col-2">
            <img class="logo img-fluid w-75 rounded-pill" src="../logopng.png" alt="Logo">
        </div>
    </div>
</nav>
<div class="container py-5">
    <h2>Consulta de Postventa</h2>

    <?php if ($producto): ?>
        <div class="card mb-3" style="background-color: #e0e0e0; border: none;">
            <div class="row g-0">
                <div class="col-md-4 image-container">
                    <img src="<?= htmlspecialchars($producto['imagen_url']) ?>" 
                         class="product-image" 
                         alt="<?= htmlspecialchars($producto['nombre_producto']) ?>">
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($producto['nombre_producto']) ?></h5>
                        <p class="card-text">Precio: $<?= number_format($producto['precio'], 0, ',', '.') ?></p>
                        <h6>Características:</h6>
                        <ul>
                            <?php foreach ($caracteristicas as $caracteristica): ?>
                                <li><?= htmlspecialchars($caracteristica) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    <?php else: ?>
        <p class="text-danger">No se encontró información del producto.</p>
    <?php endif; ?>

    <?php if ($message): ?>
        <div class="alert <?= strpos($message, 'éxito') !== false ? 'alert-success' : 'alert-danger' ?>">
            <?= $message ?>
        </div>
    <?php endif; ?>

    <form method="POST">
        <input type="hidden" name="id_producto" value="<?= htmlspecialchars($id_producto) ?>">
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre:</label>
            <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ingresa tu nombre" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Correo:</label>
            <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($_SESSION['email'] ?? '') ?>" <?= isset($_SESSION['email']) ? 'readonly' : '' ?> required>
        </div>
        <div class="mb-3">
            <label for="pregunta" class="form-label">Consulta:</label>
            <textarea class="form-control" id="pregunta" name="pregunta" rows="4" placeholder="Escribe tu consulta aquí" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Enviar</button>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
