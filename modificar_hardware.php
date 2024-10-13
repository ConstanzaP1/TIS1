<?php
require('conexion.php');

// Obtener el ID del periférico a modificar
$id_hardware = $_GET['id_hardware'];

// Consultar la base de datos para obtener los datos actuales del periférico
$query = "SELECT * FROM hardware p
          LEFT JOIN memoria m ON p.id_hardware = m.id_hardware
          LEFT JOIN memoria_gpu mg ON p.id_hardware = mg.id_hardware
          LEFT JOIN frecuencia_gpu fg ON p.id_hardware = fg.id_hardware
          LEFT JOIN frecuencia_cpu fc ON p.id_hardware = fc.id_hardware
          LEFT JOIN socket_cpu sc ON p.id_hardware = sc.id_hardware
          LEFT JOIN nucleo_hilo_cpu nhc ON p.id_hardware = nhc.id_hardware
          LEFT JOIN socket_placa sp ON p.id_hardware = sp.id_hardware
          LEFT JOIN slot_memoria_placa smp ON p.id_hardware = smp.id_hardware
          LEFT JOIN voltaje_ram vr ON p.id_hardware = vr.id_hardware
          LEFT JOIN velocidad_ram ve ON p.id_hardware = ve.id_hardware
          LEFT JOIN capacidad_almacenamiento ca ON p.id_hardware = ca.id_hardware
          LEFT JOIN formato_placa fp ON p.id_hardware = fp.id_hardware
          LEFT JOIN capacidad_ram cr ON p.id_hardware = cr.id_hardware
          LEFT JOIN tipo_ram tr ON p.id_hardware = tr.id_hardware
          LEFT JOIN certificacion_fuente cf ON p.id_hardware = cf.id_hardware
          LEFT JOIN tipo_cableado tc ON p.id_hardware = tc.id_hardware
          LEFT JOIN tamanio_fuente tf ON p.id_hardware = tf.id_hardware
          LEFT JOIN potencia_fuente pf ON p.id_hardware = pf.id_hardware
          LEFT JOIN tamanio_placa tp ON p.id_hardware = tp.id_hardware
          WHERE p.id_hardware = '$id_hardware'";

$result = mysqli_query($conexion, $query);
$row = mysqli_fetch_assoc($result);

// Mostrar un formulario con los datos actuales para que el usuario pueda modificarlos
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Hardware</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h1 class="mb-4">Modificar Hardware</h1>

    <!-- Formulario para modificar periférico -->
    <form action="actualizar_hardware.php" method="POST" class="mb-4">
        <!-- Campos oculto para el ID del periférico -->
        <input type="hidden" name="id_hardware" value="<?php echo $id_hardware; ?>">

        <!-- Menú desplegable para seleccionar el tipo de periférico -->
        <div class="mb-3">
            <label for="tipo_hardware" class="form-label">Tipo de Hardware</label>
            <select name="tipo_hardware" id="tipo_hardware" class="form-select" required>
                <option value="" selected disabled>Seleccione un tipo de Hardware</option>
                <option value="memoria" <?php if ($row['memoria']) echo 'selected'; ?>>memoria </option>
                <option value="memoria_gpu" <?php if ($row['memoria_gpu']) echo 'selected'; ?>>memoria gpu</option>
                <option value="frecuencia_gpu" <?php if ($row['frecuencia_gpu']) echo 'selected'; ?>>Frecuencia Gpu</option>
                <option value="frecuencia_cpu" <?php if ($row['frecuencia_cpu']) echo 'selected'; ?>>Frecuencia Cpu</option>
                <option value="socket_cpu" <?php if ($row['socket_cpu']) echo 'selected'; ?>>Socket Cpu</option>
                <option value="nucleo_hilo_cpu" <?php if ($row['nucleo_hilo_cpu']) echo 'selected'; ?>>Nucleo Hilo Cpu</option>
                <option value="socket_placa" <?php if ($row['socket_placa']) echo 'selected'; ?>>Socket Placa</option>
                <option value="slot_memoria_placa" <?php if ($row['slot_memoria_placa']) echo 'selected'; ?>>Slot Memoria Placa</option>
                <option value="voltaje_ram" <?php if ($row['voltaje_ram']) echo 'selected'; ?>>Voltaje Ram</option>
                <option value="velocidad_ram" <?php if ($row['velocidad_ram']) echo 'selected'; ?>>Velocidad Ram</option>
                <option value="capacidad_almacenamiento" <?php if ($row['capacidad_almacenamiento']) echo 'selected'; ?>>Capacidad Almacenamiento</option>
                <option value="formato_placa" <?php if ($row['formato_placa']) echo 'selected'; ?>>Formato Placa</option>
                <option value="capacidad_ram" <?php if ($row['capacidad_ram']) echo 'selected'; ?>>Capacidad Ram</option>
                <option value="tipo_ram" <?php if ($row['tipo_ram']) echo 'selected'; ?>>Tipo Ram</option>
                <option value="certificacion_fuente" <?php if ($row['certificacion_fuente']) echo 'selected'; ?>>Certificacion Fuente</option>
                <option value="tipo_cableado" <?php if ($row['tipo_cableado']) echo 'selected'; ?>>Tipo Cableado</option>
                <option value="tamanio_fuente" <?php if ($row['tamanio_fuente']) echo 'selected'; ?>>Tamaño Fuente</option>
                <option value="potencia_fuente" <?php if ($row['potencia_fuente']) echo 'selected'; ?>>Potencia Fuente</option>
                <option value="tamanio_placa" <?php if ($row['tamanio_placa']) echo 'selected'; ?>>Tamaño Placa</option>
                

            </select>
        </div>
                 <!-- Camposs (Ocultos inicialmente) -->
        <div class="mb-3" id="camposMemoria" style="display: none;">       
            <label for="memoria" class="form-label mt-3">Memoria</label>
            <input type="text" name="memoria" class="form-control" id="memoria" value="<?php echo $row['memoria']; ?>">
        </div>                  
        <div class="mb-3" id="camposMemoria_gpu" style="display: none;">       
            <label for="memoria_gpu" class="form-label mt-3">Memoria Gpu</label>
            <input type="text" name="memoria_gpu" class="form-control" id="memoria_gpu" value="<?php echo $row['memoria_gpu']; ?>">
        </div>
        <div class="mb-3" id="camposFrecuencia_gpu" style="display: none;">       
            <label for="frecuencia_gpu" class="form-label mt-3">Frecuencia Gpu</label>
            <input type="text" name="frecuencia_gpu" class="form-control" id="frecuencia_gpu" value="<?php echo $row['frecuencia_gpu']; ?>">
        </div>
        <div class="mb-3" id="camposFrecuencia_cpu" style="display: none;">       
            <label for="frecuencia_cpu" class="form-label mt-3">Frecuencia Cpu</label>
            <input type="text" name="frecuencia_cpu" class="form-control" id="frecuencia_cpu" value="<?php echo $row['frecuencia_cpu']; ?>">
        </div>
        <div class="mb-3" id="camposSocket_cpu" style="display: none;">       
            <label for="socket_cpu" class="form-label mt-3">Socket Cpu</label>
            <input type="text" name="socket_cpu" class="form-control" id="socket_cpu" value="<?php echo $row['socket_cpu']; ?>">
        </div>

        <div class="mb-3" id="camposNucleo_hilo_cpu" style="display: none;">       
            <label for="nucleo_hilo_cpu" class="form-label mt-3">Nucleo Hilo Cpu</label>
            <input type="text" name="nucleo_hilo_cpu" class="form-control" id="nucleo_hilo_cpu" value="<?php echo $row['nucleo_hilo_cpu']; ?>">
        </div>
        <div class="mb-3" id="camposSocket_placa" style="display: none;">       
            <label for="socket_placa" class="form-label mt-3">Socket Placa</label>
            <input type="text" name="socket_placa" class="form-control" id="socket_placa" value="<?php echo $row['socket_placa']; ?>">
        </div>
        <div class="mb-3" id="camposSlot_memoria_placa" style="display: none;">       
            <label for="slot_memoria_placa" class="form-label mt-3">Slot Memoria Placa</label>
            <input type="text" name="slot_memoria_placa" class="form-control" id="slot_memoria_placa" value="<?php echo $row['slot_memoria_placa']; ?>">
        </div>
        <div class="mb-3" id="camposVoltaje_ram" style="display: none;">       
            <label for="voltaje_ram" class="form-label mt-3">Voltaje Ram</label>
            <input type="text" name="voltaje_ram" class="form-control" id="voltaje_ram" value="<?php echo $row['voltaje_ram']; ?>">
        </div>
        <div class="mb-3" id="camposVelocidad_ram" style="display: none;">       
            <label for="velocidad_ram" class="form-label mt-3">Velocidad Ram</label>
            <input type="text" name="velocidad_ram" class="form-control" id="velocidad_ram" value="<?php echo $row['velocidad_ram']; ?>">
        </div>
        <div class="mb-3" id="camposCapacidad_almacenamiento" style="display: none;">       
            <label for="capacidad_almacenamiento" class="form-label mt-3">Capacidad Almacenamiento</label>
            <input type="text" name="capacidad_almacenamiento" class="form-control" id="capacidad_almacenamiento" value="<?php echo $row['capacidad_almacenamiento']; ?>">
        </div>
        <div class="mb-3" id="camposFormato_placa" style="display: none;">       
            <label for="formato_placa" class="form-label mt-3">Formato Placa</label>
            <input type="text" name="formato_placa" class="form-control" id="formato_placa" value="<?php echo $row['formato_placa']; ?>">
        </div>
        <div class="mb-3" id="camposCapacidad_ram" style="display: none;">       
            <label for="capacidad_ram" class="form-label mt-3">Capacidad Ram</label>
            <input type="text" name="capacidad_ram" class="form-control" id="capacidad_ram" value="<?php echo $row['capacidad_ram']; ?>">
        </div>
        <div class="mb-3" id="camposTipo_ram" style="display: none;">       
            <label for="tipo_ram" class="form-label mt-3">Tipo Ram</label>
            <input type="text" name="tipo_ram" class="form-control" id="tipo_ram" value="<?php echo $row['tipo_ram']; ?>">
        </div>
        <div class="mb-3" id="camposCertificacion_fuente" style="display: none;">       
            <label for="certificacion_fuente" class="form-label mt-3">Certificacion Fuente</label>
            <input type="text" name="certificacion_fuente" class="form-control" id="certificacion_fuente" value="<?php echo $row['certificacion_fuente']; ?>">
        </div>
        <div class="mb-3" id="camposTipo_cableado" style="display: none;">       
            <label for="tipo_cableado" class="form-label mt-3">Tipo Cableado</label>
            <input type="text" name="tipo_cableado" class="form-control" id="tipo_cableado" value="<?php echo $row['tipo_cableado']; ?>">
        </div>
        <div class="mb-3" id="camposTamanio_fuente" style="display: none;">       
            <label for="tamanio_fuente" class="form-label mt-3">Tamanio Fuente</label>
            <input type="text" name="tamanio_fuente" class="form-control" id="tamanio_fuente" value="<?php echo $row['tamanio_fuente']; ?>">
        </div>
        <div class="mb-3" id="camposPotencia_fuente" style="display: none;">       
            <label for="potencia_fuente" class="form-label mt-3">Potencia Fuente</label>
            <input type="text" name="potencia_fuente" class="form-control" id="potencia_fuente" value="<?php echo $row['potencia_fuente']; ?>">
        </div>
        <div class="mb-3" id="camposTamanio_placa" style="display: none;">       
            <label for="tamanio_placa" class="form-label mt-3">Tamaño Placa</label>
            <input type="text" name="tamanio_placa" class="form-control" id="tamanio_placa" value="<?php echo $row['tamanio_placa']; ?>">
        </div>

        <button type="submit" class="btn btn-primary mt-3">Guardar cambios</button>
    </form>

    <script>
        function mostrarCamposHardware() {
        var tipoHardware = document.getElementById("tipo_hardware").value;

        // Ocultar todos los campos inicialmente
        document.getElementById("camposMemoria").style.display = "none";
        document.getElementById("camposMemoria_gpu").style.display = "none";
        document.getElementById("camposFrecuencia_gpu").style.display = "none";
        document.getElementById("camposFrecuencia_cpu").style.display = "none";
        document.getElementById("camposSocket_cpu").style.display = "none";
        document.getElementById("camposNucleo_hilo_cpu").style.display = "none";
        document.getElementById("camposSocket_placa").style.display = "none";
        document.getElementById("camposSlot_memoria_placa").style.display = "none";
        document.getElementById("camposVoltaje_ram").style.display = "none";
        document.getElementById("camposVelocidad_ram").style.display = "none";
        document.getElementById("camposCapacidad_almacenamiento").style.display = "none";
        document.getElementById("camposFormato_placa").style.display = "none";
        document.getElementById("camposCapacidad_ram").style.display = "none";
        document.getElementById("camposTipo_ram").style.display = "none";
        document.getElementById("camposCertificacion_fuente").style.display = "none";
        document.getElementById("camposTipo_cableado").style.display = "none";
        document.getElementById("camposTamanio_fuente").style.display = "none";
        document.getElementById("camposPotencia_fuente").style.display = "none";
        document.getElementById("camposTamanio_placa").style.display = "none";


        if (tipoHardware === "memoria") {
            document.getElementById("camposMemoria").style.display = "block";
        }
        else if (tipoHardware === "memoria_gpu") {
            document.getElementById("camposMemoria_gpu").style.display = "block";
        }  
        else if (tipoHardware === "frecuencia_gpu") {
            document.getElementById("camposFrecuencia_gpu").style.display = "block";
        } 
        else if (tipoHardware === "frecuencia_cpu") {
            document.getElementById("camposFrecuencia_cpu").style.display = "block";
        } 
        else if (tipoHardware === "socket_cpu") {
            document.getElementById("camposSocket_cpu").style.display = "block";
        } 
        else if (tipoHardware === "nucleo_hilo_cpu") {
            document.getElementById("camposNucleo_hilo_cpu").style.display = "block";
        } 
        else if (tipoHardware === "socket_placa") {
            document.getElementById("camposSocket_placa").style.display = "block";
        } 

        else if (tipoHardware === "slot_memoria_placa") {
            document.getElementById("camposSlot_memoria_placa").style.display = "block";
        } 
        else if (tipoHardware === "voltaje_ram") {
            document.getElementById("camposVoltaje_ram").style.display = "block";
        } 
        
        else if (tipoHardware === "velocidad_ram") {
            document.getElementById("camposVelocidad_ram").style.display = "block";
        }
        
        else if (tipoHardware === "capacidad_almacenamiento") {
            document.getElementById("camposCapacidad_almacenamiento").style.display = "block";
        }

        else if (tipoHardware === "formato_placa") {
            document.getElementById("camposFormato_placa").style.display = "block";
        }

        else if (tipoHardware === "capacidad_ram") {
            document.getElementById("camposCapacidad_ram").style.display = "block";
        }

        else if (tipoHardware === "tipo_ram") {
            document.getElementById("camposTipo_ram").style.display = "block";
        }

        else if (tipoHardware === "certificacion_fuente") {
            document.getElementById("camposCertificacion_fuente").style.display = "block";
        }

        else if (tipoHardware === "tipo_cableado") {
            document.getElementById("camposTipo_cableado").style.display = "block";
        }

        else if (tipoHardware === "tamanio_fuente") {
            document.getElementById("camposTamanio_fuente").style.display = "block";
        }

        else if (tipoHardware === "potencia_fuente") {
            document.getElementById("camposPotencia_fuente").style.display = "block";
        }

        else if (tipoHardware === "tamanio_placa") {
            document.getElementById("camposTamanio_placa").style.display = "block";
        }
        
    }

        // Llamar a la función al cargar la página
        window.onload = function() {
            mostrarCamposHardware();
        };

        // Llamar a la función al cambiar el valor del select
        document.getElementById("tipo_hardware").addEventListener("change", mostrarCamposHardware);
    </script>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>