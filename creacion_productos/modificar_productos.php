<?php
require('../conexion.php');

// Obtener el ID del producto desde la URL
if (isset($_GET['id_producto'])) {
    $id_producto = mysqli_real_escape_string($conexion, $_GET['id_producto']);

    // Consultar los datos generales del producto
    $query_producto = "SELECT * FROM producto WHERE id_producto = '$id_producto'";
    $resultado_producto = mysqli_query($conexion, $query_producto);
    $producto = mysqli_fetch_assoc($resultado_producto);

    // Consultar las características del producto
    $query_caracteristicas = "SELECT * FROM producto_caracteristica WHERE id_producto = '$id_producto'";
    $resultado_caracteristicas = mysqli_query($conexion, $query_caracteristicas);
    $caracteristicas = [];
    while ($fila = mysqli_fetch_assoc($resultado_caracteristicas)) {
        $caracteristicas[$fila['caracteristica']] = $fila['valor_caracteristica'];
    }
}
$queryMarca = "SELECT id_marca, nombre_marca FROM marca";
$resultMarca = mysqli_query($conexion, $queryMarca);

// consultas teclado
$queryTipoTeclado = "SELECT id_periferico, tipo_teclado FROM tipo_teclado";
$resultTipoTeclado = mysqli_query($conexion, $queryTipoTeclado);

$queryTipoSwitch = "SELECT id_periferico, tipo_switch FROM tipo_switch";
$resultTipoSwitch = mysqli_query($conexion, $queryTipoSwitch);

$queryConectividad = "SELECT id_periferico, conectividad FROM conectividad";
$resultConectividad = mysqli_query($conexion, $queryConectividad);

$queryIluminacion = "SELECT id_periferico, iluminacion FROM iluminacion";
$resultIluminacion = mysqli_query($conexion, $queryIluminacion);

$queryCategoria = "SELECT id_periferico, categoria_teclado FROM categoria_teclado";
$resultCategoria = mysqli_query($conexion, $queryCategoria);

//consultas monitor
$queryResolucionMonitor = "SELECT id_periferico, resolucion_monitor FROM resolucion_monitor";
$resultResolucionMonitor = mysqli_query($conexion, $queryResolucionMonitor);

$queryTamanioMonitor = "SELECT id_periferico, tamanio_monitor FROM tamanio_monitor";
$resultTamanioMonitor = mysqli_query($conexion, $queryTamanioMonitor);

$queryTasa = "SELECT id_periferico, tasa_refresco FROM tasa_refresco";
$resultTasa = mysqli_query($conexion, $queryTasa);

$queryTiempo = "SELECT id_periferico, tiempo_respuesta FROM tiempo_respuesta";
$resultTiempo = mysqli_query($conexion, $queryTiempo);

$querySoporte = "SELECT id_periferico, soporte_monitor FROM soporte_monitor";
$resultSoporte = mysqli_query($conexion, $querySoporte);

$queryTipoPanel = "SELECT id_periferico, tipo_panel FROM tipo_panel";
$resultTipoPanel = mysqli_query($conexion, $queryTipoPanel);

$queryTipoCurvatura = "SELECT id_periferico, tipo_curvatura FROM tipo_curvatura";
$resultTipoCurvatura = mysqli_query($conexion, $queryTipoCurvatura);

// consultas audifono
$queryTipoAudifono = "SELECT id_periferico, tipo_audifono FROM tipo_audifono";
$resultTipoAudifono = mysqli_query($conexion, $queryTipoAudifono);

$queryTipoMicrofono = "SELECT id_periferico, tipo_microfono FROM tipo_microfono";
$resultTipoMicrofono = mysqli_query($conexion, $queryTipoMicrofono);

$queryAnc = "SELECT id_periferico, anc FROM anc";
$resultAnc = mysqli_query($conexion, $queryAnc);

$queryConectividad = "SELECT id_periferico, conectividad FROM conectividad";
$resultConectividad = mysqli_query($conexion, $queryConectividad);

$queryIluminacion = "SELECT id_periferico, iluminacion FROM iluminacion";
$resultIluminacion = mysqli_query($conexion, $queryIluminacion);

//consultas mouse
$queryDpiMouse = "SELECT id_periferico, dpi_mouse FROM dpi_mouse";
$resultDpiMouse = mysqli_query($conexion, $queryDpiMouse);

$queryPesoMouse = "SELECT id_periferico, peso_mouse FROM peso_mouse";
$resultPesoMouse = mysqli_query($conexion, $queryPesoMouse);

$querySensorMouse = "SELECT id_periferico, sensor_mouse FROM sensor_mouse";
$resultSensorMouse = mysqli_query($conexion, $querySensorMouse);

//consultas cpu
$queryFrecuenciaCpu = "SELECT id_hardware, frecuencia_cpu FROM frecuencia_cpu";
$resultFrencuenciaCpu = mysqli_query($conexion, $queryFrecuenciaCpu);

$queryNucleoHilo = "SELECT id_hardware, nucleo_hilo_cpu FROM nucleo_hilo_cpu";
$resultNucleoHilo = mysqli_query($conexion, $queryNucleoHilo);

$querySocketCpu = "SELECT id_hardware, socket_cpu FROM socket_cpu";
$resultSocketCpu = mysqli_query($conexion, $querySocketCpu);

//consultas gpu
$queryFrecuenciaGpu = "SELECT id_hardware, frecuencia_gpu FROM frecuencia_gpu";
$resultFrencuenciaGpu = mysqli_query($conexion, $queryFrecuenciaGpu);

$queryMemoriaGpu = "SELECT id_hardware, memoria_gpu FROM memoria_gpu";
$resultMemoriaGpu = mysqli_query($conexion, $queryMemoriaGpu);

$queryBusEntrada = "SELECT id_hardware, bus_de_entrada_gpu FROM bus_de_entrada_gpu";
$resultBusEntrada = mysqli_query($conexion, $queryBusEntrada);

//consultas ram
$queryTipoRam = "SELECT id_hardware, tipo_ram FROM tipo_ram";
$resultTipoRam = mysqli_query($conexion, $queryTipoRam);

$queryVelocidadRam = "SELECT id_hardware, velocidad_ram FROM velocidad_ram";
$resultVelocidadRam = mysqli_query($conexion, $queryVelocidadRam);

$queryCapacidadRam = "SELECT id_hardware, capacidad_ram FROM capacidad_ram";
$resultCapacidadRam = mysqli_query($conexion, $queryCapacidadRam);

$queryFormatoRam = "SELECT id_hardware, formato_ram FROM formato_ram";
$resultFormatoRam = mysqli_query($conexion, $queryFormatoRam);

//query ssd
$queryBusSsd = "SELECT id_hardware, bus_ssd FROM bus_ssd";
$resultBusSsd = mysqli_query($conexion, $queryBusSsd);

$queryFormatoSsd = "SELECT id_hardware, formato_ssd FROM formato_ssd";
$resultFormatoSsd = mysqli_query($conexion, $queryFormatoSsd);


//query hdd
$queryCapacidadAlmacenamiento = "SELECT id_hardware, capacidad_almacenamiento FROM capacidad_almacenamiento";
$resultCapacidadAlmacenamiento = mysqli_query($conexion, $queryCapacidadAlmacenamiento);

$queryBusHdd = "SELECT id_hardware, bus_hdd FROM bus_hdd";
$resultBusHdd = mysqli_query($conexion, $queryBusHdd);

$queryRpmHdd = "SELECT id_hardware, rpm_hdd FROM rpm_hdd";
$resultRpmHdd = mysqli_query($conexion, $queryRpmHdd);

$queryTamanioHdd = "SELECT id_hardware, tamanio_hdd FROM tamanio_hdd";
$resultTamanioHdd = mysqli_query($conexion, $queryTamanioHdd);

//consultas placa
$queryFormatoPlaca = "SELECT id_hardware, formato_placa FROM formato_placa";
$resultFormatoPlaca = mysqli_query($conexion, $queryFormatoPlaca);

$querySlot = "SELECT id_hardware, slot_memoria_placa FROM slot_memoria_placa";
$resultSlot = mysqli_query($conexion, $querySlot);

$querySocket = "SELECT id_hardware, socket_placa FROM socket_placa";
$resultSocket = mysqli_query($conexion, $querySocket);

$queryChipset = "SELECT id_hardware, chipset_placa FROM chipset_placa";
$resultChipset = mysqli_query($conexion, $queryChipset);

//consultas fuente
$queryCertificacion = "SELECT id_hardware, certificacion_fuente FROM certificacion_fuente";
$resultCertificacion = mysqli_query($conexion, $queryCertificacion);

$queryPotencia = "SELECT id_hardware, potencia_fuente FROM potencia_fuente";
$resultPotencia = mysqli_query($conexion, $queryPotencia);

$queryTamanio = "SELECT id_hardware, tamanio_fuente FROM tamanio_fuente";
$resultTamanio = mysqli_query($conexion, $queryTamanio);

//consultas gabinete
$queryGabinete = "SELECT id_hardware, tamanio_max_gabinete FROM tamanio_max_gabinete";
$resultGabinete = mysqli_query($conexion, $queryGabinete);

//consultas notebook
$queryBateria = "SELECT id_notebook, bateria_notebook FROM bateria_notebook";
$resultBateria = mysqli_query($conexion, $queryBateria);

$queryCpuNotebook = "SELECT id_notebook, cpu_notebook FROM cpu_notebook";
$resultCpuNotebook = mysqli_query($conexion, $queryCpuNotebook);

$queryGpuNotebook = "SELECT id_notebook, gpu_notebook FROM gpu_notebook";
$resultGpuNotebook = mysqli_query($conexion, $queryGpuNotebook);

$queryCapacidadRam = "SELECT id_hardware, capacidad_ram FROM capacidad_ram";
$resultCapacidadRam = mysqli_query($conexion, $queryCapacidadRam);

$queryPantalla = "SELECT id_notebook, pantalla_notebook FROM pantalla_notebook";
$resultPantalla = mysqli_query($conexion, $queryPantalla);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Modificar producto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
        <h2 class="mb-4">Modificar producto</h2>

        <form action="procesar_modificacion_producto.php" method="POST" class="row g-3">
            <input type="hidden" name="id_producto" value="<?php echo htmlspecialchars($producto['id_producto']); ?>">

            <!-- Datos generales -->
            <div class="col-md-6">
                <label for="nombre_producto" class="form-label">Nombre del producto:</label>
                <input type="text" name="nombre_producto" id="nombre_producto" value="<?php echo htmlspecialchars($producto['nombre_producto']); ?>" class="form-control" required>
            </div>

            <div class="col-md-6">
                <label for="precio" class="form-label">Precio de venta:</label>
                <input type="number" name="precio" id="precio" value="<?php echo htmlspecialchars($producto['precio']); ?>" class="form-control" required>
            </div>

            <div class="col-md-6">
                <label for="costo" class="form-label">Costo de compra:</label>
                <input type="number" name="costo" id="costo" value="<?php echo htmlspecialchars($producto['costo']); ?>" class="form-control" required>
            </div>

            <div class="col-md-6">
                <label for="nombre_marca" class="form-label">Marca:</label>
                <select name="nombre_marca" id="nombre_marca" class="form-select" required>
                    <option value="" disabled>Seleccione una marca</option>
                    <?php while ($row = mysqli_fetch_assoc($resultMarca)): ?>
                        <option value="<?= $row['id_marca'] ?>" <?= ($producto['marca'] == $row['nombre_marca']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($row['nombre_marca']) ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="col-md-6">
                <label for="cantidad" class="form-label">Cantidad:</label>
                <input type="number" name="cantidad" id="cantidad" value="<?php echo htmlspecialchars($producto['cantidad']); ?>" class="form-control" required>
            </div>

            <div class="col-md-6">
                <label for="categoria_producto" class="form-label">Categoría:</label>
                <input type="text" name="categoria_producto" id="categoria_producto" value="<?php echo htmlspecialchars($producto['tipo_producto']); ?>" class="form-control" required>
            </div>

            <div class="col-md-6">
                <label for="imagen_url" class="form-label">URL de la Imagen:</label>
                <input type="url" name="imagen_url" id="imagen_url" value="<?php echo htmlspecialchars($producto['imagen_url']); ?>" class="form-control">
            </div>

            <!-- Características del producto -->
            <h3 class="mt-4">Características del producto</h3>

            <?php if ($producto['tipo_producto'] == 'teclado'): ?>
                <!-- Tipo de Teclado -->
                <div class="col-md-6">
                    <label for="tipo_teclado" class="form-label">Tipo de Teclado:</label>
                    <select name="tipo_teclado" id="tipo_teclado" class="form-select" required>
                        <option value="" selected disabled>Seleccione un tipo</option>
                        <?php while ($row = mysqli_fetch_assoc($resultTipoTeclado)): ?>
                            <option value="<?= $row['id_periferico'] ?>" <?= (isset($caracteristicas['tipo_teclado']) && $caracteristicas['tipo_teclado'] == $row['id_periferico']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($row['tipo_teclado']) ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <!-- Tipo de Switch -->
                <div class="col-md-6">
                    <label for="tipo_switch" class="form-label">Tipo de Switch:</label>
                    <select name="tipo_switch" id="tipo_switch" class="form-select" required>
                        <option value="" selected disabled>Seleccione un switch</option>
                        <?php while ($row = mysqli_fetch_assoc($resultTipoSwitch)): ?>
                            <option value="<?= $row['id_periferico'] ?>" <?= (isset($caracteristicas['tipo_switch']) && $caracteristicas['tipo_switch'] == $row['id_periferico']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($row['tipo_switch']) ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <!-- Conectividad -->
                <div class="col-md-6">
                    <label for="conectividad" class="form-label">Conectividad:</label>
                    <select name="conectividad" id="conectividad" class="form-select" required>
                        <option value="" selected disabled>Seleccione un tipo</option>
                        <?php while ($row = mysqli_fetch_assoc($resultConectividad)): ?>
                            <option value="<?= $row['id_periferico'] ?>" <?= (isset($caracteristicas['conectividad']) && $caracteristicas['conectividad'] == $row['id_periferico']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($row['conectividad']) ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <!-- Iluminación -->
                <div class="col-md-6">
                    <label for="iluminacion" class="form-label">Iluminación:</label>
                    <select name="iluminacion" id="iluminacion" class="form-select" required>
                        <option value="" selected disabled>Seleccione la iluminación</option>
                        <?php while ($row = mysqli_fetch_assoc($resultIluminacion)): ?>
                            <option value="<?= $row['id_periferico'] ?>" <?= (isset($caracteristicas['iluminacion']) && $caracteristicas['iluminacion'] == $row['id_periferico']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($row['iluminacion']) ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <!-- Categoria teclado   -->
                <div class="col-md-6">
                    <label for="categoria_teclado" class="form-label">Categoria teclado:</label>
                    <select name="categoria_teclado" id="categoria_teclado" class="form-select" required>
                        <option value="" selected disabled>Seleccione la iluminación</option>
                        <?php while ($row = mysqli_fetch_assoc($resultCategoria)): ?>
                            <option value="<?= $row['id_periferico'] ?>" <?= (isset($caracteristicas['categoria_teclado']) && $caracteristicas['categoria_teclado'] == $row['id_periferico']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($row['categoria_teclado']) ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

            <?php elseif ($producto['tipo_producto'] == 'monitor'): ?>
                <!-- Resolución Monitor -->
                <div class="col-md-6">
                    <label for="resolucion_monitor" class="form-label">Resolución del Monitor:</label>
                    <select name="resolucion_monitor" id="resolucion_monitor" class="form-select" required>
                        <option value="" selected disabled>Seleccione una resolución</option>
                        <?php while ($row = mysqli_fetch_assoc($resultResolucionMonitor)): ?>
                            <option value="<?= $row['id_periferico'] ?>" <?= (isset($caracteristicas['resolucion_monitor']) && $caracteristicas['resolucion_monitor'] == $row['id_periferico']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($row['resolucion_monitor']) ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <!-- Tamaño del Monitor -->
                <div class="col-md-6">
                    <label for="tamanio_monitor" class="form-label">Tamaño del Monitor:</label>
                    <select name="tamanio_monitor" id="tamanio_monitor" class="form-select" required>
                        <option value="" selected disabled>Seleccione un tamaño</option>
                        <?php while ($row = mysqli_fetch_assoc($resultTamanioMonitor)): ?>
                            <option value="<?= $row['id_periferico'] ?>" <?= (isset($caracteristicas['tamanio_monitor']) && $caracteristicas['tamanio_monitor'] == $row['id_periferico']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($row['tamanio_monitor']) ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <!-- Tasa de refresco -->
                <div class="col-md-6">
                    <label for="tasa_refresco" class="form-label">Tamaño del Monitor:</label>
                    <select name="tasa_refresco" id="tasa_refresco" class="form-select" required>
                        <option value="" selected disabled>Seleccione un tamaño</option>
                        <?php while ($row = mysqli_fetch_assoc($resultTasa)): ?>
                            <option value="<?= $row['id_periferico'] ?>" <?= (isset($caracteristicas['tasa_refresco']) && $caracteristicas['tasa_refresco'] == $row['id_periferico']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($row['tasa_refresco']) ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <!-- tiempo respuestar -->
                <div class="col-md-6">
                    <label for="tiempo_respuesta" class="form-label">Tiempo de respuesta:</label>
                    <select name="tiempo_respuesta" id="tiempo_respuesta" class="form-select" required>
                        <option value="" selected disabled>Seleccione un tamaño</option>
                        <?php while ($row = mysqli_fetch_assoc($resultTiempo)): ?>
                            <option value="<?= $row['id_periferico'] ?>" <?= (isset($caracteristicas['tiempo_respuesta']) && $caracteristicas['tiempo_respuesta'] == $row['id_periferico']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($row['tiempo_respuesta']) ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <!-- soporte monitor -->
                <div class="col-md-6">
                    <label for="soporte_monitor" class="form-label">Soporte del Monitor:</label>
                    <select name="soporte_monitor" id="soporte_monitor" class="form-select" required>
                        <option value="" selected disabled>Seleccione un tamaño</option>
                        <?php while ($row = mysqli_fetch_assoc($resultSoporte)): ?>
                            <option value="<?= $row['id_periferico'] ?>" <?= (isset($caracteristicas['soporte_monitor']) && $caracteristicas['soporte_monitor'] == $row['id_periferico']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($row['soporte_monitor']) ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <!-- Tipo panel -->
                <div class="col-md-6">
                    <label for="tipo_panel" class="form-label">Tipo de panel:</label>
                    <select name="tipo_panel" id="tipo_panel" class="form-select" required>
                        <option value="" selected disabled>Seleccione un tamaño</option>
                        <?php while ($row = mysqli_fetch_assoc($resultTipoPanel)): ?>
                            <option value="<?= $row['id_periferico'] ?>" <?= (isset($caracteristicas['tipo_panel']) && $caracteristicas['tipo_panel'] == $row['id_periferico']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($row['tipo_panel']) ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <!-- Tipo curvatura -->
                <div class="col-md-6">
                    <label for="tipo_curvatura" class="form-label">Tipo de curvatura:</label>
                    <select name="tipo_curvatura" id="tipo_curvatura" class="form-select" required>
                        <option value="" selected disabled>Seleccione un tamaño</option>
                        <?php while ($row = mysqli_fetch_assoc($resultTipoCurvatura)): ?>
                            <option value="<?= $row['id_periferico'] ?>" <?= (isset($caracteristicas['tipo_curvatura']) && $caracteristicas['tipo_curvatura'] == $row['id_periferico']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($row['tipo_curvatura']) ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                
            <?php elseif ($producto['tipo_producto'] == 'audifono'): ?>
                <!-- Tipo de audifono -->
                <div class="col-md-6">
                    <label for="tipo_audifono" class="form-label">Tipo de audifono:</label>
                    <select name="tipo_audifono" id="tipo_audifono" class="form-select" required>
                        <option value="" selected disabled>Seleccione un tipo</option>
                        <?php while ($row = mysqli_fetch_assoc($resultTipoAudifono)): ?>
                            <option value="<?= $row['id_periferico'] ?>" <?= (isset($caracteristicas['tipo_audifono']) && $caracteristicas['tipo_audifono'] == $row['id_periferico']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($row['tipo_audifono']) ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                
                <!-- Tipo de microfno -->
                <div class="col-md-6">
                    <label for="tipo_microfono" class="form-label">Tipo de microfono:</label>
                    <select name="tipo_microfono" id="tipo_microfono" class="form-select" required>
                        <option value="" selected disabled>Seleccione un tipo</option>
                        <?php while ($row = mysqli_fetch_assoc($resultTipoMicrofono)): ?>
                            <option value="<?= $row['id_periferico'] ?>" <?= (isset($caracteristicas['tipo_microfono']) && $caracteristicas['tipo_microfono'] == $row['id_periferico']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($row['tipo_microfono']) ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                
                <!-- Cancelacion de ruido -->
                <div class="col-md-6">
                    <label for="anc" class="form-label">Cancelacion de ruido:</label>
                    <select name="anc" id="anc" class="form-select" required>
                        <option value="" selected disabled>Seleccione un tipo</option>
                        <?php while ($row = mysqli_fetch_assoc($resultAnc)): ?>
                            <option value="<?= $row['id_periferico'] ?>" <?= (isset($caracteristicas['anc']) && $caracteristicas['anc'] == $row['id_periferico']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($row['anc']) ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <!-- Iluminación -->
                <div class="col-md-6">
                    <label for="iluminacion" class="form-label">Iluminación:</label>
                    <select name="iluminacion" id="iluminacion" class="form-select" required>
                        <option value="" selected disabled>Seleccione la iluminación</option>
                        <?php while ($row = mysqli_fetch_assoc($resultIluminacion)): ?>
                            <option value="<?= $row['id_periferico'] ?>" <?= (isset($caracteristicas['iluminacion']) && $caracteristicas['iluminacion'] == $row['id_periferico']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($row['iluminacion']) ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <!-- Conectividad -->
                <div class="col-md-6">
                    <label for="conectividad" class="form-label">Conectividad:</label>
                    <select name="conectividad" id="conectividad" class="form-select" required>
                        <option value="" selected disabled>Seleccione un tipo</option>
                        <?php while ($row = mysqli_fetch_assoc($resultConectividad)): ?>
                            <option value="<?= $row['id_periferico'] ?>" <?= (isset($caracteristicas['conectividad']) && $caracteristicas['conectividad'] == $row['id_periferico']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($row['conectividad']) ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

            <?php elseif ($producto['tipo_producto'] == 'mouse'): ?>
                <!-- DPI mouse -->
                <div class="col-md-6">
                    <label for="dpi_mouse" class="form-label">DPI:</label>
                    <select name="dpi_mouse" id="dpi_mouse" class="form-select" required>
                        <option value="" selected disabled>Seleccione un tipo</option>
                        <?php while ($row = mysqli_fetch_assoc($resultDpiMouse)): ?>
                            <option value="<?= $row['id_periferico'] ?>" <?= (isset($caracteristicas['dpi_mouse']) && $caracteristicas['dpi_mouse'] == $row['id_periferico']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($row['dpi_mouse']) ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <!-- peso mouse -->
                <div class="col-md-6">
                    <label for="peso_mouse" class="form-label">Peso mouse:</label>
                    <select name="peso_mouse" id="peso_mouse" class="form-select" required>
                        <option value="" selected disabled>Seleccione un tipo</option>
                        <?php while ($row = mysqli_fetch_assoc($resultPesoMouse)): ?>
                            <option value="<?= $row['id_periferico'] ?>" <?= (isset($caracteristicas['peso_mouse']) && $caracteristicas['peso_mouse'] == $row['id_periferico']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($row['peso_mouse']) ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <!-- Sensor mouse -->
                <div class="col-md-6">
                    <label for="sensor_mouse" class="form-label">Sensor mouse:</label>
                    <select name="sensor_mouse" id="sensor_mouse" class="form-select" required>
                        <option value="" selected disabled>Seleccione un tipo</option>
                        <?php while ($row = mysqli_fetch_assoc($resultSensorMouse)): ?>
                            <option value="<?= $row['id_periferico'] ?>" <?= (isset($caracteristicas['sensor_mouse']) && $caracteristicas['sensor_mouse'] == $row['id_periferico']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($row['sensor_mouse']) ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <!-- Conectividad -->
                <div class="col-md-6">
                    <label for="conectividad" class="form-label">Conectividad:</label>
                    <select name="conectividad" id="conectividad" class="form-select" required>
                        <option value="" selected disabled>Seleccione un tipo</option>
                        <?php while ($row = mysqli_fetch_assoc($resultConectividad)): ?>
                            <option value="<?= $row['id_periferico'] ?>" <?= (isset($caracteristicas['conectividad']) && $caracteristicas['conectividad'] == $row['id_periferico']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($row['conectividad']) ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                
                <!-- Iluminación -->
                <div class="col-md-6">
                    <label for="iluminacion" class="form-label">Iluminación:</label>
                    <select name="iluminacion" id="iluminacion" class="form-select" required>
                        <option value="" selected disabled>Seleccione la iluminación</option>
                        <?php while ($row = mysqli_fetch_assoc($resultIluminacion)): ?>
                            <option value="<?= $row['id_periferico'] ?>" <?= (isset($caracteristicas['iluminacion']) && $caracteristicas['iluminacion'] == $row['id_periferico']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($row['iluminacion']) ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
            <?php elseif ($producto['tipo_producto'] == 'cpu'): ?>
                <!-- frecuencia  -->
                <div class="col-md-6">
                    <label for="frecuencia_cpu" class="form-label">Frecuencia CPU:</label>
                    <select name="frecuencia_cpu" id="frecuencia_cpu" class="form-select" required>
                        <option value="" selected disabled>Seleccione un tipo</option>
                        <?php while ($row = mysqli_fetch_assoc($resultFrencuenciaCpu)): ?>
                            <option value="<?= $row['id_hardware'] ?>" <?= (isset($caracteristicas['frecuencia_cpu']) && $caracteristicas['frecuencia_cpu'] == $row['id_hardware']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($row['frecuencia_cpu']) ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <!-- nucleo/hilo  -->
                <div class="col-md-6">
                    <label for="nucleo_hilo_cpu" class="form-label">Nucleo / Hilo:</label>
                    <select name="nucleo_hilo_cpu" id="nucleo_hilo_cpu" class="form-select" required>
                        <option value="" selected disabled>Seleccione un tipo</option>
                        <?php while ($row = mysqli_fetch_assoc($resultNucleoHilo)): ?>
                            <option value="<?= $row['id_hardware'] ?>" <?= (isset($caracteristicas['nucleo_hilo_cpu']) && $caracteristicas['nucleo_hilo_cpu'] == $row['id_hardware']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($row['nucleo_hilo_cpu']) ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <!-- Socket  -->
                <div class="col-md-6">
                    <label for="socket_cpu" class="form-label">Socket:</label>
                    <select name="socket_cpu" id="socket_cpu" class="form-select" required>
                        <option value="" selected disabled>Seleccione un tipo</option>
                        <?php while ($row = mysqli_fetch_assoc($resultSocketCpu)): ?>
                            <option value="<?= $row['id_hardware'] ?>" <?= (isset($caracteristicas['socket_cpu']) && $caracteristicas['socket_cpu'] == $row['id_hardware']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($row['socket_cpu']) ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

            <?php elseif ($producto['tipo_producto'] == 'gpu'): ?>
                <!-- frecuencia  -->
                <div class="col-md-6">
                    <label for="frecuencia_gpu" class="form-label">Frecuencia GPU:</label>
                    <select name="frecuencia_gpu" id="frecuencia_gpu" class="form-select" required>
                        <option value="" selected disabled>Seleccione un tipo</option>
                        <?php while ($row = mysqli_fetch_assoc($resultFrencuenciaGpu)): ?>
                            <option value="<?= $row['id_hardware'] ?>" <?= (isset($caracteristicas['frecuencia_gpu']) && $caracteristicas['frecuencia_gpu'] == $row['id_hardware']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($row['frecuencia_gpu']) ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <!-- memoria  -->
                <div class="col-md-6">
                    <label for="memoria_gpu" class="form-label">Memoria GPU:</label>
                    <select name="memoria_gpu" id="memoria_gpu" class="form-select" required>
                        <option value="" selected disabled>Seleccione un tipo</option>
                        <?php while ($row = mysqli_fetch_assoc($resultMemoriaGpu)): ?>
                            <option value="<?= $row['id_hardware'] ?>" <?= (isset($caracteristicas['memoria_gpu']) && $caracteristicas['memoria_gpu'] == $row['id_hardware']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($row['memoria_gpu']) ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <!-- Bus  -->
                <div class="col-md-6">
                    <label for="bus_de_entrada_gpu" class="form-label">Bus entrada:</label>
                    <select name="bus_de_entrada_gpu" id="bus_de_entrada_gpu" class="form-select" required>
                        <option value="" selected disabled>Seleccione un tipo</option>
                        <?php while ($row = mysqli_fetch_assoc($resultBusEntrada)): ?>
                            <option value="<?= $row['id_hardware'] ?>" <?= (isset($caracteristicas['bus_de_entrada_gpu']) && $caracteristicas['bus_de_entrada_gpu'] == $row['id_hardware']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($row['bus_de_entrada_gpu']) ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

            <?php elseif ($producto['tipo_producto'] == 'ram'): ?>
                <!-- tipo ram  -->
                <div class="col-md-6">
                    <label for="tipo_ram" class="form-label">Velocidad:</label>
                    <select name="tipo_ram" id="tipo_ram" class="form-select" required>
                        <option value="" selected disabled>Seleccione un tipo</option>
                        <?php while ($row = mysqli_fetch_assoc($resultTipoRam)): ?>
                            <option value="<?= $row['id_hardware'] ?>" <?= (isset($caracteristicas['tipo_ram']) && $caracteristicas['tipo_ram'] == $row['id_hardware']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($row['tipo_ram']) ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <!-- velocidad  -->
                <div class="col-md-6">
                    <label for="velocidad_ram" class="form-label">Velocidad:</label>
                    <select name="velocidad_ram" id="velocidad_ram" class="form-select" required>
                        <option value="" selected disabled>Seleccione un tipo</option>
                        <?php while ($row = mysqli_fetch_assoc($resultVelocidadRam)): ?>
                            <option value="<?= $row['id_hardware'] ?>" <?= (isset($caracteristicas['velocidad_ram']) && $caracteristicas['velocidad_ram'] == $row['id_hardware']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($row['velocidad_ram']) ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <!-- capacidad  -->
                <div class="col-md-6">
                    <label for="capacidad_ram" class="form-label">Velocidad:</label>
                    <select name="capacidad_ram" id="capacidad_ram" class="form-select" required>
                        <option value="" selected disabled>Seleccione un tipo</option>
                        <?php while ($row = mysqli_fetch_assoc($resultCapacidadRam)): ?>
                            <option value="<?= $row['id_hardware'] ?>" <?= (isset($caracteristicas['capacidad_ram']) && $caracteristicas['capacidad_ram'] == $row['id_hardware']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($row['capacidad_ram']) ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <!-- formato  -->
                <div class="col-md-6">
                    <label for="formato_ram" class="form-label">Velocidad:</label>
                    <select name="formato_ram" id="formato_ram" class="form-select" required>
                        <option value="" selected disabled>Seleccione un tipo</option>
                        <?php while ($row = mysqli_fetch_assoc($resultFormatoRam)): ?>
                            <option value="<?= $row['id_hardware'] ?>" <?= (isset($caracteristicas['formato_ram']) && $caracteristicas['formato_ram'] == $row['id_hardware']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($row['formato_ram']) ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
            <?php elseif ($producto['tipo_producto'] == 'ssd'): ?>
                
                <div class="col-md-6">
                    <label for="capacidad_almacenamiento" class="form-label">Capacidad almacenamiento:</label>
                    <select name="capacidad_almacenamiento" id="capacidad_almacenamiento" class="form-select" required>
                        <option value="" selected disabled>Seleccione una opcion</option>
                        <?php while ($row = mysqli_fetch_assoc($resultCapacidadAlmacenamiento)): ?>
                            <option value="<?= $row['id_hardware'] ?>" <?= (isset($caracteristicas['capacidad_almacenamiento']) && $caracteristicas['capacidad_almacenamiento'] == $row['id_hardware']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($row['capacidad_almacenamiento']) ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="col-md-6">
                    <label for="bus_ssd" class="form-label">Bus:</label>
                    <select name="bus_ssd" id="bus_ssd" class="form-select" required>
                        <option value="" selected disabled>Seleccione una opcion</option>
                        <?php while ($row = mysqli_fetch_assoc($resultBusSsd)): ?>
                            <option value="<?= $row['id_hardware'] ?>" <?= (isset($caracteristicas['bus_ssd']) && $caracteristicas['bus_ssd'] == $row['id_hardware']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($row['bus_ssd']) ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="col-md-6">
                    <label for="formato_ssd" class="form-label">Formato:</label>
                    <select name="formato_ssd" id="formato_ssd" class="form-select" required>
                        <option value="" selected disabled>Seleccione una opcion</option>
                        <?php while ($row = mysqli_fetch_assoc($resultFormatoSsd)): ?>
                            <option value="<?= $row['id_hardware'] ?>" <?= (isset($caracteristicas['formato_ssd']) && $caracteristicas['formato_ssd'] == $row['id_hardware']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($row['formato_ssd']) ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>


            <?php elseif ($producto['tipo_producto'] == 'hdd'): ?>
                
                <div class="col-md-6">
                    <label for="capacidad_almacenamiento" class="form-label">Capacidad almacenamiento:</label>
                    <select name="capacidad_almacenamiento" id="capacidad_almacenamiento" class="form-select" required>
                        <option value="" selected disabled>Seleccione una opcion</option>
                        <?php while ($row = mysqli_fetch_assoc($resultCapacidadAlmacenamiento)): ?>
                            <option value="<?= $row['id_hardware'] ?>" <?= (isset($caracteristicas['capacidad_almacenamiento']) && $caracteristicas['capacidad_almacenamiento'] == $row['id_hardware']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($row['capacidad_almacenamiento']) ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="col-md-6">
                    <label for="bus_hdd" class="form-label">BUS:</label>
                    <select name="bus_hdd" id="bus_hdd" class="form-select" required>
                        <option value="" selected disabled>Seleccione una opcion</option>
                        <?php while ($row = mysqli_fetch_assoc($resultBusHdd)): ?>
                            <option value="<?= $row['id_hardware'] ?>" <?= (isset($caracteristicas['bus_hdd']) && $caracteristicas['bus_hdd'] == $row['id_hardware']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($row['bus_hdd']) ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="col-md-6">
                    <label for="rpm_hdd" class="form-label">RPM:</label>
                    <select name="rpm_hdd" id="rpm_hdd" class="form-select" required>
                        <option value="" selected disabled>Seleccione una opcion</option>
                        <?php while ($row = mysqli_fetch_assoc($resultRpmHdd)): ?>
                            <option value="<?= $row['id_hardware'] ?>" <?= (isset($caracteristicas['rpm_hdd']) && $caracteristicas['rpm_hdd'] == $row['id_hardware']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($row['rpm_hdd']) ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                        
                <div class="col-md-6">
                    <label for="tamanio_hdd" class="form-label">Tamaño:</label>
                    <select name="tamanio_hdd" id="tamanio_hdd" class="form-select" required>
                        <option value="" selected disabled>Seleccione una opcion</option>
                        <?php while ($row = mysqli_fetch_assoc($resultTamanioHdd)): ?>
                            <option value="<?= $row['id_hardware'] ?>" <?= (isset($caracteristicas['tamanio_hdd']) && $caracteristicas['tamanio_hdd'] == $row['id_hardware']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($row['tamanio_hdd']) ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

            <?php elseif ($producto['tipo_producto'] == 'placa'): ?>
                <!-- formato placa  -->
                <div class="col-md-6">
                    <label for="formato_placa" class="form-label">Formato:</label>
                    <select name="formato_placa" id="formato_placa" class="form-select" required>
                        <option value="" selected disabled>Seleccione un tipo</option>
                        <?php while ($row = mysqli_fetch_assoc($resultFormatoPlaca)): ?>
                            <option value="<?= $row['id_hardware'] ?>" <?= (isset($caracteristicas['formato_placa']) && $caracteristicas['formato_placa'] == $row['id_hardware']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($row['formato_placa']) ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <!-- slot memoria  -->
                <div class="col-md-6">
                    <label for="slot_memoria_placa" class="form-label">Slots memoria:</label>
                    <select name="slot_memoria_placa" id="slot_memoria_placa" class="form-select" required>
                        <option value="" selected disabled>Seleccione un tipo</option>
                        <?php while ($row = mysqli_fetch_assoc($resultSlot)): ?>
                            <option value="<?= $row['id_hardware'] ?>" <?= (isset($caracteristicas['slot_memoria_placa']) && $caracteristicas['slot_memoria_placa'] == $row['id_hardware']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($row['slot_memoria_placa']) ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <!-- socket placa  -->
                <div class="col-md-6">
                    <label for="socket_placa" class="form-label">Socket:</label>
                    <select name="socket_placa" id="socket_placa" class="form-select" required>
                        <option value="" selected disabled>Seleccione un tipo</option>
                        <?php while ($row = mysqli_fetch_assoc($resultSocket)): ?>
                            <option value="<?= $row['id_hardware'] ?>" <?= (isset($caracteristicas['socket_placa']) && $caracteristicas['socket_placa'] == $row['id_hardware']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($row['socket_placa']) ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <!-- chipset placa  -->
                <div class="col-md-6">
                    <label for="chipset_placa" class="form-label">Chipest:</label>
                    <select name="chipset_placa" id="chipset_placa" class="form-select" required>
                        <option value="" selected disabled>Seleccione un tipo</option>
                        <?php while ($row = mysqli_fetch_assoc($resultChipset)): ?>
                            <option value="<?= $row['id_hardware'] ?>" <?= (isset($caracteristicas['chipset_placa']) && $caracteristicas['chipset_placa'] == $row['id_hardware']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($row['chipset_placa']) ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
            <?php elseif ($producto['tipo_producto'] == 'fuente'): ?>
                <!-- certificacion  -->
                <div class="col-md-6">
                    <label for="certificacion_fuente" class="form-label">Certificacion:</label>
                    <select name="certificacion_fuente" id="certificacion_fuente" class="form-select" required>
                        <option value="" selected disabled>Seleccione un tipo</option>
                        <?php while ($row = mysqli_fetch_assoc($resultCertificacion)): ?>
                            <option value="<?= $row['id_hardware'] ?>" <?= (isset($caracteristicas['certificacion_fuente']) && $caracteristicas['certificacion_fuente'] == $row['id_hardware']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($row['certificacion_fuente']) ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <!-- potencia  -->
                <div class="col-md-6">
                    <label for="potencia_fuente" class="form-label">Potencia:</label>
                    <select name="potencia_fuente" id="potencia_fuente" class="form-select" required>
                        <option value="" selected disabled>Seleccione un tipo</option>
                        <?php while ($row = mysqli_fetch_assoc($resultPotencia)): ?>
                            <option value="<?= $row['id_hardware'] ?>" <?= (isset($caracteristicas['potencia_fuente']) && $caracteristicas['potencia_fuente'] == $row['id_hardware']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($row['potencia_fuente']) ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <!-- tamaño  -->
                <div class="col-md-6">
                    <label for="tamanio_fuente" class="form-label">Tamaño:</label>
                    <select name="tamanio_fuente" id="tamanio_fuente" class="form-select" required>
                        <option value="" selected disabled>Seleccione un tipo</option>
                        <?php while ($row = mysqli_fetch_assoc($resultTamanio)): ?>
                            <option value="<?= $row['id_hardware'] ?>" <?= (isset($caracteristicas['tamanio_fuente']) && $caracteristicas['tamanio_fuente'] == $row['id_hardware']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($row['tamanio_fuente']) ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
            <?php elseif ($producto['tipo_producto'] == 'gabinete'): ?>
                <!-- tamaño placa gabinete  -->
                <div class="col-md-6">
                    <label for="tamanio_max_gabinete" class="form-label">Tamaño placa gabinete:</label>
                    <select name="tamanio_max_gabinete" id="tamanio_max_gabinete" class="form-select" required>
                        <option value="" selected disabled>Seleccione un tipo</option>
                        <?php while ($row = mysqli_fetch_assoc($resultGabinete)): ?>
                            <option value="<?= $row['id_hardware'] ?>" <?= (isset($caracteristicas['tamanio_max_gabinete']) && $caracteristicas['tamanio_max_gabinete'] == $row['id_hardware']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($row['tamanio_max_gabinete']) ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                 <!-- Iluminación -->
                <div class="col-md-6">
                    <label for="iluminacion" class="form-label">Iluminación:</label>
                    <select name="iluminacion" id="iluminacion" class="form-select" required>
                        <option value="" selected disabled>Seleccione la iluminación</option>
                        <?php while ($row = mysqli_fetch_assoc($resultIluminacion)): ?>
                            <option value="<?= $row['id_periferico'] ?>" <?= (isset($caracteristicas['iluminacion']) && $caracteristicas['iluminacion'] == $row['id_periferico']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($row['iluminacion']) ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
            <?php elseif ($producto['tipo_producto'] == 'notebook'): ?>
                <div class="col-md-6">
                    <label for="bateria_notebook" class="form-label">Bateria:</label>
                    <select name="bateria_notebook" id="bateria_notebook" class="form-select" required>
                        <option value="" selected disabled>Seleccione un tipo</option>
                        <?php while ($row = mysqli_fetch_assoc($resultBateria)): ?>
                            <option value="<?= $row['id_notebook'] ?>" <?= (isset($caracteristicas['bateria_notebook']) && $caracteristicas['bateria_notebook'] == $row['id_notebook']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($row['bateria_notebook']) ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="cpu_notebook" class="form-label">CPU:</label>
                    <select name="cpu_notebook" id="cpu_notebook" class="form-select" required>
                        <option value="" selected disabled>Seleccione un tipo</option>
                        <?php while ($row = mysqli_fetch_assoc($resultCpuNotebook)): ?>
                            <option value="<?= $row['id_notebook'] ?>" <?= (isset($caracteristicas['cpu_notebook']) && $caracteristicas['cpu_notebook'] == $row['id_notebook']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($row['cpu_notebook']) ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="gpu_notebook" class="form-label">GPU:</label>
                    <select name="gpu_notebook" id="gpu_notebook" class="form-select" required>
                        <option value="" selected disabled>Seleccione un tipo</option>
                        <?php while ($row = mysqli_fetch_assoc($resultGpuNotebook)): ?>
                            <option value="<?= $row['id_notebook'] ?>" <?= (isset($caracteristicas['gpu_notebook']) && $caracteristicas['gpu_notebook'] == $row['id_notebook']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($row['gpu_notebook']) ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="capacidad_ram" class="form-label">RAM:</label>
                    <select name="capacidad_ram" id="capacidad_ram" class="form-select" required>
                        <option value="" selected disabled>Seleccione un tipo</option>
                        <?php while ($row = mysqli_fetch_assoc($resultCapacidadRam)): ?>
                            <option value="<?= $row['id_hardware'] ?>" <?= (isset($caracteristicas['capacidad_ram']) && $caracteristicas['capacidad_ram'] == $row['id_hardware']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($row['capacidad_ram']) ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="pantalla_notebook" class="form-label">Pantalla:</label>
                    <select name="pantalla_notebook" id="pantalla_notebook" class="form-select" required>
                        <option value="" selected disabled>Seleccione un tipo</option>
                        <?php while ($row = mysqli_fetch_assoc($resultPantalla)): ?>
                            <option value="<?= $row['id_notebook'] ?>" <?= (isset($caracteristicas['pantalla_notebook']) && $caracteristicas['pantalla_notebook'] == $row['id_notebook']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($row['pantalla_notebook']) ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
            <?php endif; ?>

            <div class="col-12">
                <button type="submit" class="btn btn-primary">Guardar cambios</button>
                <button type="button" class="btn btn-secondary" onclick="window.location.href='listar_productos.php';">Volver</button>
            </div>
        </form>
    </div>
</body>
</html>
