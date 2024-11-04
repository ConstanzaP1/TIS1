<?php
require('../conexion.php');

// Si se envía el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tipo_periferico = $_POST['tipo_periferico'];

    // Insertar solo el ID (auto-incremental) en la tabla hardware
    $queryPeriferico = "INSERT INTO periferico () VALUES ()"; // No especificamos id_hardware

    if (mysqli_query($conexion, $queryPeriferico)) {
        // Obtener el último id_hardware insertado
        $id_periferico = mysqli_insert_id($conexion);

        // Dependiendo del tipo de periferico, insertamos los valores en las tablas correspondientes
        if ($tipo_periferico == 'conectividad') {
            $conectividad = $_POST['conectividad'];

            // Insertar en las tablas asociadas
            $queryConectividad = "INSERT INTO conectividad (id_periferico, conectividad) VALUES ('$id_periferico', '$conectividad')";

            if (mysqli_query($conexion, $queryConectividad)) {
                echo "Conectividad agregada exitosamente.";
            } else {
                echo "Error al insertar datos de Conectividad: " . mysqli_error($conexion);   
            }
            header('location: conectividad.php');
        } elseif ($tipo_periferico == 'sensor_mouse') {
            $sensor_mouse = $_POST['sensor_mouse'];
            // Insertar en las tablas asociadas
            $querySensor_mouse = "INSERT INTO sensor_mouse (id_periferico, sensor_mouse) VALUES ('$id_periferico', '$sensor_mouse')";

            if (mysqli_query($conexion,  $querySensor_mouse)) {
                echo "Ingreso exitoso.";
            } else {
                echo "Error al insertar." . mysqli_error($conexion);
            }
            header('location: sensor_mouse.php');
        } elseif ($tipo_periferico == 'dpi_mouse') {
            $dpi_mouse = $_POST['dpi_mouse'];
            // Insertar en las tablas asociadas
            $queryDpi_mouse = "INSERT INTO dpi_mouse (id_periferico, dpi_mouse) VALUES ('$id_periferico', '$dpi_mouse')";

            if (mysqli_query($conexion, $queryDpi_mouse)) {
                echo "Ingreso exitoso.";
            } else {
                echo "Error al insertar." . mysqli_error($conexion);
            }
            header('location: dpi_mouse.php');
        } elseif ($tipo_periferico == 'categoria_teclado') {
            $categoria_teclado = $_POST['categoria_teclado'];
            // Insertar en las tablas asociadas
            $queryCategoria_teclado = "INSERT INTO categoria_teclado (id_periferico, categoria_teclado) VALUES ('$id_periferico', '$categoria_teclado')";
        
            if (mysqli_query($conexion, $queryCategoria_teclado)) {
                echo "Ingreso exitoso.";
            } else {
                echo "Error al insertar." . mysqli_error($conexion);
            }
            
            // Redirigir de vuelta a categoria_teclado.php
            header('Location:categoria_teclado.php');
            exit(); 

        } elseif ($tipo_periferico == 'tipo_teclado') {
            $tipo_teclado = $_POST['tipo_teclado'];
            // Insertar en las tablas asociadas
            $queryTipo_teclado = "INSERT INTO tipo_teclado (id_periferico, tipo_teclado) VALUES ('$id_periferico', '$tipo_teclado')";
            if (mysqli_query($conexion, $queryTipo_teclado)) {
                echo "Ingreso exitoso.";
            } else {
                echo "Error al insertar." . mysqli_error($conexion);
            }
            header('Location:tipo_teclado.php');
            exit(); 
        } elseif ($tipo_periferico == 'tipo_audifono') {
            $tipo_audifono = $_POST['tipo_audifono'];
            // Insertar en las tablas asociadas
            $queryTipo_audifono = "INSERT INTO tipo_audifono (id_periferico, tipo_audifono) VALUES ('$id_periferico', '$tipo_audifono')";
            if (mysqli_query($conexion, $queryTipo_audifono)) {
                echo "Ingreso exitoso.";
            } else {
                echo "Error al insertar." . mysqli_error($conexion);
            }
            header('location: tipo_audifono.php');
        } elseif ($tipo_periferico == 'tipo_microfono') {
            $tipo_microfono = $_POST['tipo_microfono'];
            // Insertar en las tablas asociadas
            $queryTipo_microfono = "INSERT INTO tipo_microfono (id_periferico, tipo_microfono) VALUES ('$id_periferico', '$tipo_microfono')";
            if (mysqli_query($conexion, $queryTipo_microfono)) {
                echo "Ingreso exitoso.";
            } else {
                echo "Error al insertar." . mysqli_error($conexion);
            }
            header('location: tipo_microfono.php');
        } elseif ($tipo_periferico == 'tamanio_monitor') {
            $tamanio_monitor = $_POST['tamanio_monitor'];
            // Insertar en las tablas asociadas
            $queryTamanio_monitor = "INSERT INTO tamanio_monitor (id_periferico, tamanio_monitor) VALUES ('$id_periferico', '$tamanio_monitor')";
            if (mysqli_query($conexion, $queryTamanio_monitor)) {
                echo "Ingreso exitoso.";
            } else {
                echo "Error al insertar." . mysqli_error($conexion);
            }
            header('location: tamanio_monitor.php');
        } elseif ($tipo_periferico == 'resolucion_monitor') {
            $resolucion_monitor = $_POST['resolucion_monitor'];
            // Insertar en las tablas asociadas
            $queryResolucion_monitor = "INSERT INTO resolucion_monitor (id_periferico, resolucion_monitor) VALUES ('$id_periferico', '$resolucion_monitor')";
            if (mysqli_query($conexion, $queryResolucion_monitor)) {
                echo "Ingreso exitoso.";
            } else {
                echo "Error al insertar." . mysqli_error($conexion);
            }
            header('location: resolucion_monitor.php');
        } elseif ($tipo_periferico == 'tipo_curvatura') {
            $tipo_curvatura = $_POST['tipo_curvatura'];
            // Insertar en las tablas asociadas
            $queryTipo_curvatura = "INSERT INTO tipo_curvatura (id_periferico, tipo_curvatura) VALUES ('$id_periferico', '$tipo_curvatura')";
            if (mysqli_query($conexion, $queryTipo_curvatura)) {
                echo "Ingreso exitoso.";
            } else {
                echo "Error al insertar." . mysqli_error($conexion);
            }
            header('location: tipo_curvatura.php');
        }
        elseif ($tipo_periferico == 'tiempo_respuesta') {
            $tiempo_respuesta = $_POST['tiempo_respuesta'];
            // Insertar en las tablas asociadas
            $queryTiempo_respuesta = "INSERT INTO tiempo_respuesta (id_periferico, tiempo_respuesta) VALUES ('$id_periferico', '$tiempo_respuesta')";
            if (mysqli_query($conexion, $queryTiempo_respuesta)) {
                echo "Ingreso exitoso.";
            } else {
                echo "Error al insertar." . mysqli_error($conexion);
            }
            header('location: tiempo_respuesta.php');
        } elseif ($tipo_periferico == 'tipo_panel') {
            $tipo_panel = $_POST['tipo_panel'];
            // Insertar en las tablas asociadas
            $queryTipo_panel = "INSERT INTO tipo_panel (id_periferico, tipo_panel) VALUES ('$id_periferico', '$tipo_panel')";
            if (mysqli_query($conexion, $queryTipo_panel)) {
                echo "Ingreso exitoso.";
            } else {
                echo "Error al insertar." . mysqli_error($conexion);
            }
            header('location: tipo_panel.php');
        } elseif ($tipo_periferico == 'iluminacion') {
            $iluminacion = $_POST['iluminacion'];
            // Insertar en las tablas asociadas
            $queryIluminacion = "INSERT INTO iluminacion (id_periferico, iluminacion) VALUES ('$id_periferico', '$iluminacion')";
            if (mysqli_query($conexion, $queryIluminacion)) {
                echo "Ingreso exitoso.";
            } else {
                echo "Error al insertar." . mysqli_error($conexion);
            }
            header('location: iluminacion.php');
        } elseif ($tipo_periferico == 'tipo_switch') {
            $tipo_switch = $_POST['tipo_switch'];
            // Insertar en las tablas asociadas
            $queryTipo_switch = "INSERT INTO tipo_switch (id_periferico, tipo_switch) VALUES ('$id_periferico', '$tipo_switch')";
            if (mysqli_query($conexion, $queryTipo_switch)) {
                echo "Ingreso exitoso.";
            } else {
                echo "Error al insertar." . mysqli_error($conexion);
            }
            header('location: tipo_switch.php');
        } elseif ($tipo_periferico == 'peso_mouse') {
            $peso_mouse = $_POST['peso_mouse'];
            // Insertar en las tablas asociadas
            $queryPeso_mouse = "INSERT INTO peso_mouse (id_periferico, peso_mouse) VALUES ('$id_periferico', '$peso_mouse')";
            if (mysqli_query($conexion, $queryPeso_mouse)) {
                echo "Ingreso exitoso.";
            } else {
                echo "Error al insertar." . mysqli_error($conexion);
            }
            header('location: peso_mouse.php');
        } elseif ($tipo_periferico == 'anc') {
            $anc = $_POST['anc'];
            // Insertar en las tablas asociadas
            $queryAnc = "INSERT INTO anc (id_periferico, anc) VALUES ('$id_periferico', '$anc')";
            if (mysqli_query($conexion, $queryAnc)) {
                echo "Ingreso exitoso.";
            } else {
                echo "Error al insertar." . mysqli_error($conexion);
            }
            header('location: anc.php');
        } elseif ($tipo_periferico == 'tasa_refresco') {
            $tasa_refresco = $_POST['tasa_refresco'];
            // Insertar en las tablas asociadas
            $queryTasa_refresco = "INSERT INTO tasa_refresco (id_periferico, tasa_refresco) VALUES ('$id_periferico', '$tasa_refresco')";
            if (mysqli_query($conexion, $queryTasa_refresco)) {
                echo "Ingreso exitoso.";
            } else {
                echo "Error al insertar." . mysqli_error($conexion);
            }
            header('location: tasa_refresco.php');
        } elseif ($tipo_periferico == 'soporte_monitor') {
            $soporte_monitor = $_POST['soporte_monitor'];
            // Insertar en las tablas asociadas
            $querySoporte_monitor = "INSERT INTO soporte_monitor (id_periferico, soporte_monitor) VALUES ('$id_periferico', '$soporte_monitor')";
            if (mysqli_query($conexion, $querySoporte_monitor)) {
                echo "Ingreso exitoso.";
            } else {
                echo "Error al insertar." . mysqli_error($conexion);
            }
            header('location: soporte_monitor.php');
        } 
        
    } else {
        echo "Error al insertar ID de hardware: " . mysqli_error($conexion);
    }
}
?>