<?php
require('../conexion.php');

// Si se envía el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tipo_hardware = $_POST['tipo_hardware'];

    // Insertar solo el ID (auto-incremental) en la tabla hardware
    $queryHardware = "INSERT INTO hardware () VALUES ()"; // No especificamos id_hardware

    if (mysqli_query($conexion, $queryHardware)) {
        // Obtener el último id_hardware insertado
        $id_hardware = mysqli_insert_id($conexion);

        // Dependiendo del tipo de hardware, insertamos los valores en las tablas correspondientes
        if ($tipo_hardware == 'memoria') {
            $memoria = $_POST['memoria'];

            // Insertar en las tablas asociadas para tarjetas de video
            $queryMemoria = "INSERT INTO memoria (id_hardware, memoria) VALUES ('$id_hardware', '$memoria')";

            if (mysqli_query($conexion, $queryMemoria)) {
                echo "Ingreso exitoso.";
                header('location: admin_panel_hardware.php');
            } else {
                echo "Error al insertar." . mysqli_error($conexion);   
            }
            header('location: admin_panel_hardware.php');
        } 

        elseif ($tipo_hardware == 'memoria_gpu') {
            $memoria_gpu = $_POST['memoria_gpu'];
            // Insertar en las tablas asociadas para procesadores
            $queryMemoriaGPU = "INSERT INTO memoria_gpu (id_hardware, memoria_gpu) VALUES ('$id_hardware', '$memoria_gpu')";

            if (mysqli_query($conexion, $queryMemoriaGPU)) {
                echo "Ingreso exitoso.";
            } else {
                echo "Error al insertar." . mysqli_error($conexion);
            }
            header('location: memoria_gpu.php');

        }

        elseif ($tipo_hardware == 'frecuencia_gpu') {
            $frecuencia_gpu = $_POST['frecuencia_gpu'];
            // Insertar en las tablas asociadas para procesadores
            $queryFrecuenciaGPU = "INSERT INTO frecuencia_gpu (id_hardware, frecuencia_gpu) VALUES ('$id_hardware', '$frecuencia_gpu')";

            if (mysqli_query($conexion, $queryFrecuenciaGPU)) {
                echo "Ingreso exitoso.";
            } else {
                echo "Error al insertar." . mysqli_error($conexion);
            }
            header('location: frecuencia_gpu.php');
        } 
        
        elseif ($tipo_hardware == 'frecuencia_cpu') {
            $frecuencia_cpu = $_POST['frecuencia_cpu'];
            // Insertar en las tablas asociadas para procesadores
            $queryFrecuenciaCPU = "INSERT INTO frecuencia_cpu (id_hardware, frecuencia_cpu) VALUES ('$id_hardware', '$frecuencia_cpu')";

            if (mysqli_query($conexion, $queryFrecuenciaCPU)) {
                echo "Ingreso exitoso.";
            } else {
                echo "Error al insertar." . mysqli_error($conexion);
            }
            header('location: frecuencia_cpu.php');
        } 
        
        elseif ($tipo_hardware == 'socket_cpu') {
            $socket_cpu = $_POST['socket_cpu'];
            // Insertar en las tablas asociadas para procesadores
            $querySocket_cpu = "INSERT INTO socket_cpu (id_hardware, socket_cpu) VALUES ('$id_hardware', '$socket_cpu')";

            if (mysqli_query($conexion, $querySocket_cpu)) {
                echo "Ingreso exitoso.";
            } else {
                echo "Error al insertar." . mysqli_error($conexion);
            }
            header('location: socket_cpu.php');
        } 

        elseif ($tipo_hardware == 'nucleo_hilo_cpu') {
            $nucleo_hilo_cpu = $_POST['nucleo_hilo_cpu'];
            // Insertar en las tablas asociadas para procesadores
            $queryNucleo_hilo_cpu = "INSERT INTO nucleo_hilo_cpu (id_hardware, nucleo_hilo_cpu) VALUES ('$id_hardware', '$nucleo_hilo_cpu')";

            if (mysqli_query($conexion, $queryNucleo_hilo_cpu)) {
                echo "Ingreso exitoso.";
            } else {
                echo "Error al insertar." . mysqli_error($conexion);
            }
            header('location: nucleo_hilo_cpu.php');
        } 

        elseif ($tipo_hardware == 'socket_placa') {
            $socket_placa = $_POST['socket_placa'];
            // Insertar en las tablas asociadas para procesadores
            $querySocket_placa = "INSERT INTO socket_placa (id_hardware, socket_placa) VALUES ('$id_hardware', '$socket_placa')";

            if (mysqli_query($conexion, $querySocket_placa)) {
                echo "Ingreso exitoso.";
            } else {
                echo "Error al insertar." . mysqli_error($conexion);
            }
            header('location: socket_placa.php');
        } 

        elseif ($tipo_hardware == 'slot_memoria_placa') {
            $slot_memoria_placa = $_POST['slot_memoria_placa'];
            // Insertar en las tablas asociadas para procesadores
            $querySlot_memoria_placa = "INSERT INTO slot_memoria_placa (id_hardware, slot_memoria_placa) VALUES ('$id_hardware', '$slot_memoria_placa')";

            if (mysqli_query($conexion, $querySlot_memoria_placa)) {
                echo "Ingreso exitoso.";
            } else {
                echo "Error al insertar." . mysqli_error($conexion);
            }
            header('location: slot_memoria_placa.php');
        } 

        elseif ($tipo_hardware == 'formato_ram') {
            $formato_ram = $_POST['formato_ram'];
            // Insertar en las tablas asociadas para procesadores
            $queryFormato_ram = "INSERT INTO formato_ram (id_hardware, formato_ram) VALUES ('$id_hardware', '$formato_ram')";

            if (mysqli_query($conexion, $queryFormato_ram)) {
                echo "Ingreso exitoso.";
            } else {
                echo "Error al insertar." . mysqli_error($conexion);
            }
            header('location: formato_ram.php');
        } 
        
        elseif ($tipo_hardware == 'velocidad_ram') {
            $velocidad_ram = $_POST['velocidad_ram'];
            // Insertar en las tablas asociadas para procesadores
            $queryVelocidad_ram = "INSERT INTO velocidad_ram (id_hardware, velocidad_ram) VALUES ('$id_hardware', '$velocidad_ram')";

            if (mysqli_query($conexion, $queryVelocidad_ram)) {
                echo "Ingreso exitoso.";
            } else {
                echo "Error al insertar." . mysqli_error($conexion);
            }
            header('location: velocidad_ram.php');
        } 

        elseif ($tipo_hardware == 'capacidad_almacenamiento') {
            $capacidad_almacenamiento = $_POST['capacidad_almacenamiento'];
            // Insertar en las tablas asociadas para procesadores
            $queryCapacidad_almacenamiento = "INSERT INTO capacidad_almacenamiento (id_hardware, capacidad_almacenamiento) VALUES ('$id_hardware', '$capacidad_almacenamiento')";

            if (mysqli_query($conexion, $queryCapacidad_almacenamiento)) {
                echo "Ingreso exitoso.";
            } else {
                echo "Error al insertar." . mysqli_error($conexion);
            }
            header('location: capacidad_almacenamiento.php');
        } 

        elseif ($tipo_hardware == 'formato_placa') {
            $formato_placa = $_POST['formato_placa'];
            // Insertar en las tablas asociadas para procesadores
            $queryFormato_placa = "INSERT INTO formato_placa (id_hardware, formato_placa) VALUES ('$id_hardware', '$formato_placa')";

            if (mysqli_query($conexion, $queryFormato_placa)) {
                echo "Ingreso exitoso.";
            } else {
                echo "Error al insertar." . mysqli_error($conexion);
            }
            header('location: formato_placa.php');
        } 

        elseif ($tipo_hardware == 'capacidad_ram') {
            $capacidad_ram  = $_POST['capacidad_ram'];
            // Insertar en las tablas asociadas para procesadores
            $queryCapacidad_ram = "INSERT INTO capacidad_ram (id_hardware, capacidad_ram) VALUES ('$id_hardware', '$capacidad_ram')";

            if (mysqli_query($conexion, $queryCapacidad_ram)) {
                echo "Ingreso exitoso.";
            } else {
                echo "Error al insertar." . mysqli_error($conexion);
            }
            header('location: capacidad_ram.php');
        } 

        elseif ($tipo_hardware == 'tipo_ram') {
            $tipo_ram  = $_POST['tipo_ram'];
            // Insertar en las tablas asociadas para procesadores
            $queryTipo_ram = "INSERT INTO tipo_ram (id_hardware, tipo_ram) VALUES ('$id_hardware', '$tipo_ram')";

            if (mysqli_query($conexion, $queryTipo_ram)) {
                echo "Ingreso exitoso.";
            } else {
                echo "Error al insertar." . mysqli_error($conexion);
            }
            header('location: tipo_ram.php');
        } 

        elseif ($tipo_hardware == 'certificacion_fuente') {
            $certificacion_fuente  = $_POST['certificacion_fuente'];
            // Insertar en las tablas asociadas para procesadores
            $queryCertificacion_fuente = "INSERT INTO certificacion_fuente (id_hardware, certificacion_fuente) VALUES ('$id_hardware', '$certificacion_fuente')";

            if (mysqli_query($conexion, $queryCertificacion_fuente)) {
                echo "Ingreso exitoso.";
            } else {
                echo "Error al insertar." . mysqli_error($conexion);
            }
            header('location: certificacion_fuente.php');
        } 

        elseif ($tipo_hardware == 'tamanio_fuente') {
            $tamanio_fuente  = $_POST['tamanio_fuente'];
            // Insertar en las tablas asociadas para procesadores
            $queryTamanio_fuente = "INSERT INTO tamanio_fuente (id_hardware, tamanio_fuente) VALUES ('$id_hardware', '$tamanio_fuente')";

            if (mysqli_query($conexion, $queryTamanio_fuente)) {
                echo "Ingreso exitoso.";
            } else {
                echo "Error al insertar." . mysqli_error($conexion);
            }
            header('location: tamanio_fuente.php');
        } 

        elseif ($tipo_hardware == 'potencia_fuente') {
            $potencia_fuente  = $_POST['potencia_fuente'];
            // Insertar en las tablas asociadas para procesadores
            $queryPotencia_fuente = "INSERT INTO potencia_fuente (id_hardware, potencia_fuente) VALUES ('$id_hardware', '$potencia_fuente')";

            if (mysqli_query($conexion, $queryPotencia_fuente)) {
                echo "Ingreso exitoso.";
            } else {
                echo "Error al insertar." . mysqli_error($conexion);
            }
            header('location: potencia_fuente.php');
        } 

        elseif ($tipo_hardware == 'chipset_placa') {
            $chipset_placa  = $_POST['chipset_placa'];
            // Insertar en las tablas asociadas para procesadores
            $querychipset_placa = "INSERT INTO chipset_placa (id_hardware, chipset_placa) VALUES ('$id_hardware', '$chipset_placa')";

            if (mysqli_query($conexion, $querychipset_placa)) {
                echo "Ingreso exitoso.";
            } else {
                echo "Error al insertar." . mysqli_error($conexion);
            }
            header('location: chipset_placa.php');
        } 
        elseif ($tipo_hardware == 'tamanio_max_gabinete') {
            $tamanio_max_gabinete  = $_POST['tamanio_max_gabinete'];
            // Insertar en las tablas asociadas para procesadores
            $queryTamanio_max_gabinete = "INSERT INTO tamanio_max_gabinete (id_hardware, tamanio_max_gabinete) VALUES ('$id_hardware', '$tamanio_max_gabinete')";

            if (mysqli_query($conexion, $queryTamanio_max_gabinete)) {
                echo "Ingreso exitoso.";
            } else {
                echo "Error al insertar." . mysqli_error($conexion);
            }
            header('location: tamanio_max_gabinete.php');
        } 
        elseif ($tipo_hardware == 'bus_de_entrada_gpu') {
            $bus_de_entrada_gpu  = $_POST['bus_de_entrada_gpu'];
            // Insertar en las tablas asociadas para procesadores
            $querybus_de_entrada_gpu = "INSERT INTO bus_de_entrada_gpu (id_hardware, bus_de_entrada_gpu) VALUES ('$id_hardware', '$bus_de_entrada_gpu')";

            if (mysqli_query($conexion, $querybus_de_entrada_gpu)) {
                echo "Ingreso exitoso.";
            } else {
                echo "Error al insertar." . mysqli_error($conexion);
            }
            header('location: bus_de_entrada_gpu.php');
        } 
        elseif ($tipo_hardware == 'bus_hdd') {
            $bus_hdd  = $_POST['bus_hdd'];
            // Insertar en las tablas asociadas para procesadores
            $querybus_hdd = "INSERT INTO bus_hdd (id_hardware, bus_hdd) VALUES ('$id_hardware', '$bus_hdd')";

            if (mysqli_query($conexion, $querybus_hdd)) {
                echo "Ingreso exitoso.";
            } else {
                echo "Error al insertar." . mysqli_error($conexion);
            }
            header('location: bus_hdd.php');
        } 
        elseif ($tipo_hardware == 'bus_ssd') {
            $bus_ssd  = $_POST['bus_ssd'];
            // Insertar en las tablas asociadas para procesadores
            $querybus_ssd = "INSERT INTO bus_ssd (id_hardware, bus_ssd) VALUES ('$id_hardware', '$bus_ssd')";

            if (mysqli_query($conexion, $querybus_ssd)) {
                echo "Ingreso exitoso.";
            } else {
                echo "Error al insertar." . mysqli_error($conexion);
            }
            
            header('location: bus_ssd.php');
        } 
        elseif ($tipo_hardware == 'formato_ssd') {
            $formato_ssd  = $_POST['formato_ssd'];
            // Insertar en las tablas asociadas para procesadores
            $queryformato_ssd = "INSERT INTO formato_ssd (id_hardware, formato_ssd) VALUES ('$id_hardware', '$formato_ssd')";

            if (mysqli_query($conexion, $queryformato_ssd)) {
                echo "Ingreso exitoso.";
            } else {
                echo "Error al insertar." . mysqli_error($conexion);
            }
            header('location: formato_ssd.php');
        } 
        elseif ($tipo_hardware == 'rpm_hdd') {
            $rpm_hdd  = $_POST['rpm_hdd'];
            // Insertar en las tablas asociadas para procesadores
            $queryrpm_hdd = "INSERT INTO rpm_hdd (id_hardware, rpm_hdd) VALUES ('$id_hardware', '$rpm_hdd')";

            if (mysqli_query($conexion, $queryrpm_hdd)) {
                echo "Ingreso exitoso.";
            } else {
                echo "Error al insertar." . mysqli_error($conexion);
            }
            header('location: rpm_hdd.php');
        } 
        elseif ($tipo_hardware == 'tamanio_hdd') {
            $tamanio_hdd  = $_POST['tamanio_hdd'];
            // Insertar en las tablas asociadas para procesadores
            $querytamanio_hdd = "INSERT INTO tamanio_hdd (id_hardware, tamanio_hdd) VALUES ('$id_hardware', '$tamanio_hdd')";

            if (mysqli_query($conexion, $querytamanio_hdd)) {
                echo "Ingreso exitoso.";
            } else {
                echo "Error al insertar." . mysqli_error($conexion);
            }
            header('location: tamanio_hdd.php');
        } 



        

        // Agregar más bloques elseif para otros tipos de hardware (almacenamiento, fuente de poder, etc.)
    } else {
        echo "Error al insertar ID de hardware: " . mysqli_error($conexion);
    }
}
?>