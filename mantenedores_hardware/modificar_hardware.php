<?php
require('../conexion.php');

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
          LEFT JOIN velocidad_ram ve ON p.id_hardware = ve.id_hardware
          LEFT JOIN capacidad_almacenamiento ca ON p.id_hardware = ca.id_hardware
          LEFT JOIN formato_placa fp ON p.id_hardware = fp.id_hardware
          LEFT JOIN capacidad_ram cr ON p.id_hardware = cr.id_hardware
          LEFT JOIN formato_ram fr ON p.id_hardware = fr.id_hardware
          LEFT JOIN certificacion_fuente cf ON p.id_hardware = cf.id_hardware
          LEFT JOIN tamanio_fuente tf ON p.id_hardware = tf.id_hardware
          LEFT JOIN potencia_fuente pf ON p.id_hardware = pf.id_hardware
          LEFT JOIN chipset_placa cp ON p.id_hardware = cp.id_hardware
          LEFT JOIN tipo_ram tr ON p.id_hardware = tr.id_hardware
          LEFT JOIN tamanio_max_gabinete tmg ON p.id_hardware = tmg.id_hardware
          LEFT JOIN bus_de_entrada_gpu beg ON p.id_hardware = beg.id_hardware
          LEFT JOIN bus_hdd bh ON p.id_hardware = bh.id_hardware
          LEFT JOIN bus_ssd bs ON p.id_hardware = bs.id_hardware
          LEFT JOIN formato_ssd fs ON p.id_hardware = fs.id_hardware
          LEFT JOIN rpm_hdd rh ON p.id_hardware = rh.id_hardware
          LEFT JOIN tamanio_hdd th ON p.id_hardware = th.id_hardware


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
        <div class="mb-3" style="display: none;">
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
                <option value="velocidad_ram" <?php if ($row['velocidad_ram']) echo 'selected'; ?>>Velocidad Ram</option>
                <option value="capacidad_almacenamiento" <?php if ($row['capacidad_almacenamiento']) echo 'selected'; ?>>Capacidad Almacenamiento</option>
                <option value="formato_placa" <?php if ($row['formato_placa']) echo 'selected'; ?>>Formato Placa</option>
                <option value="capacidad_ram" <?php if ($row['capacidad_ram']) echo 'selected'; ?>>Capacidad Ram</option>
                <option value="formato_ram" <?php if ($row['formato_ram']) echo 'selected'; ?>>Formato Ram</option>
                <option value="certificacion_fuente" <?php if ($row['certificacion_fuente']) echo 'selected'; ?>>Certificacion Fuente</option>
                <option value="tamanio_fuente" <?php if ($row['tamanio_fuente']) echo 'selected'; ?>>Tamaño Fuente</option>
                <option value="potencia_fuente" <?php if ($row['potencia_fuente']) echo 'selected'; ?>>Potencia Fuente</option>
                <option value="chipset_placa" <?php if ($row['chipset_placa']) echo 'selected'; ?>>Chipset Placa</option>
                <option value="tipo_ram" <?php if ($row['tipo_ram']) echo 'selected'; ?>>Tipo RAM</option>
                <option value="tamanio_max_gabinete" <?php if ($row['tamanio_max_gabinete']) echo 'selected'; ?>>tamaño maximo placa</option>
                <option value="bus_de_entrada_gpu" <?php if ($row['bus_de_entrada_gpu']) echo 'selected'; ?>>bus de entrada Gpu</option>
                <option value="bus_hdd" <?php if ($row['bus_hdd']) echo 'selected'; ?>>Bus Hdd</option>
                <option value="bus_ssd" <?php if ($row['bus_ssd']) echo 'selected'; ?>>Bus Ssd</option>
                <option value="formato_ssd" <?php if ($row['formato_ssd']) echo 'selected'; ?>>formato Ssd</option>
                <option value="rpm_hdd" <?php if ($row['rpm_hdd']) echo 'selected'; ?>>Rpm Hdd</option>
                <option value="tamanio_hdd" <?php if ($row['tamanio_hdd']) echo 'selected'; ?>>Tamaño Hdd</option>


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
        <div class="mb-3" id="camposformato_ram" style="display: none;">       
            <label for="formato_ram" class="form-label mt-3">Formato Ram</label>
            <input type="text" name="formato_ram" class="form-control" id="formato_ram" value="<?php echo $row['formato_ram']; ?>">
        </div>
        <div class="mb-3" id="camposCertificacion_fuente" style="display: none;">       
            <label for="certificacion_fuente" class="form-label mt-3">Certificacion Fuente</label>
            <input type="text" name="certificacion_fuente" class="form-control" id="certificacion_fuente" value="<?php echo $row['certificacion_fuente']; ?>">
        </div>
        <div class="mb-3" id="camposTamanio_fuente" style="display: none;">       
            <label for="tamanio_fuente" class="form-label mt-3">Tamaño Fuente</label>
            <input type="text" name="tamanio_fuente" class="form-control" id="tamanio_fuente" value="<?php echo $row['tamanio_fuente']; ?>">
        </div>
        <div class="mb-3" id="camposPotencia_fuente" style="display: none;">       
            <label for="potencia_fuente" class="form-label mt-3">Potencia Fuente</label>
            <input type="text" name="potencia_fuente" class="form-control" id="potencia_fuente" value="<?php echo $row['potencia_fuente']; ?>">
        </div>
        <div class="mb-3" id="camposchipset_placa" style="display: none;">       
            <label for="chipset_placa" class="form-label mt-3">Chipset</label>
            <input type="text" name="chipset_placa" class="form-control" id="chipset_placa" value="<?php echo $row['chipset_placa']; ?>">
        </div>
        <div class="mb-3" id="camposTipo_ram" style="display: none;">       
            <label for="tipo_ram" class="form-label mt-3">Tipo RAM</label>
            <input type="text" name="tipo_ram" class="form-control" id="tipo_ram" value="<?php echo $row['tipo_ram']; ?>">
        </div>
        <div class="mb-3" id="camposTamanio_max_gabinete" style="display: none;">       
            <label for="tamanio_max_gabinete" class="form-label mt-3">Tamaño maximo placa</label>
            <input type="text" name="tamanio_max_gabinete" class="form-control" id="tamanio_max_gabinete" value="<?php echo $row['tamanio_max_gabinete']; ?>">
        </div>
        <div class="mb-3" id="camposbus_de_entrada_gpu" style="display: none;">       
            <label for="bus_de_entrada_gpu" class="form-label mt-3">Bus De Entrada Gpu</label>
            <input type="text" name="bus_de_entrada_gpu" class="form-control" id="bus_de_entrada_gpu" value="<?php echo $row['bus_de_entrada_gpu']; ?>">
        </div>
        <div class="mb-3" id="camposbus_hdd" style="display: none;">       
            <label for="bus_hdd" class="form-label mt-3">Bus Hdd</label>
            <input type="text" name="bus_hdd" class="form-control" id="bus_hdd" value="<?php echo $row['bus_hdd']; ?>">
        </div>
        <div class="mb-3" id="camposbus_ssd" style="display: none;">       
            <label for="bus_ssd" class="form-label mt-3">Bus Ssd</label>
            <input type="text" name="bus_ssd" class="form-control" id="bus_ssd" value="<?php echo $row['bus_ssd']; ?>">
        </div>
        <div class="mb-3" id="camposformato_ssd" style="display: none;">       
            <label for="formato_ssd" class="form-label mt-3">Bus Ssd</label>
            <input type="text" name="formato_ssd" class="form-control" id="formato_ssd" value="<?php echo $row['formato_ssd']; ?>">
        </div>
        <div class="mb-3" id="camposrpm_hdd" style="display: none;">       
            <label for="rpm_hdd" class="form-label mt-3">Rpm Hdd</label>
            <input type="text" name="rpm_hdd" class="form-control" id="rpm_hdd" value="<?php echo $row['rpm_hdd']; ?>">
        </div>
        <div class="mb-3" id="campostamanio_hdd" style="display: none;">       
            <label for="tamanio_hdd" class="form-label mt-3">Tamaño Hdd</label>
            <input type="text" name="tamanio_hdd" class="form-control" id="tamanio_hdd" value="<?php echo $row['tamanio_hdd']; ?>">
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
        document.getElementById("camposVelocidad_ram").style.display = "none";
        document.getElementById("camposCapacidad_almacenamiento").style.display = "none";
        document.getElementById("camposFormato_placa").style.display = "none";
        document.getElementById("camposCapacidad_ram").style.display = "none";
        document.getElementById("camposformato_ram").style.display = "none";
        document.getElementById("camposCertificacion_fuente").style.display = "none";
        document.getElementById("camposTamanio_fuente").style.display = "none";
        document.getElementById("camposPotencia_fuente").style.display = "none";
        document.getElementById("camposchipset_placa").style.display = "none";
       //no agregar aqui

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

        else if (tipoHardware === "formato_ram") {
            document.getElementById("camposformato_ram").style.display = "block";
        }

        else if (tipoHardware === "certificacion_fuente") {
            document.getElementById("camposCertificacion_fuente").style.display = "block";
        }

        else if (tipoHardware === "tamanio_fuente") {
            document.getElementById("camposTamanio_fuente").style.display = "block";
        }

        else if (tipoHardware === "potencia_fuente") {
            document.getElementById("camposPotencia_fuente").style.display = "block";
        }

        else if (tipoHardware === "chipset_placa") {
            document.getElementById("camposchipset_placa").style.display = "block";
        }

        else if (tipoHardware === "tipo_ram") {
            document.getElementById("camposTipo_ram").style.display = "block";
        }
        else if (tipoHardware === "tamanio_max_gabinete") {
            document.getElementById("camposTamanio_max_gabinete").style.display = "block";
        }
        else if (tipoHardware === "bus_de_entrada_gpu") {
            document.getElementById("camposbus_de_entrada_gpu").style.display = "block";
        }
        else if (tipoHardware === "bus_hdd") {
            document.getElementById("camposbus_hdd").style.display = "block";
        }
        else if (tipoHardware === "bus_ssd") {
            document.getElementById("camposbus_ssd").style.display = "block";
        }
        else if (tipoHardware === "formato_ssd") {
            document.getElementById("camposformato_ssd").style.display = "block";
        }
        else if (tipoHardware === "rpm_hdd") {
            document.getElementById("camposrpm_hdd").style.display = "block";
        }
        else if (tipoHardware === "tamanio_hdd") {
            document.getElementById("campostamanio_hdd").style.display = "block";
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
<script src="htcps://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>