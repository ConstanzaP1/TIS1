<?php
    require('conexion.php');
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ingreso de Hardware</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h1 class="mb-4">Ingreso de Hardware</h1>

    <!-- Formulario para insertar hardware -->
    <form action="ingresar_hardware.php" method="POST" class="mb-4">
        <!-- Menú desplegable para seleccionar el tipo de hardware -->
        <div class="mb-3">
            <label for="tipo_hardware" class="form-label">Tipo de Hardware</label>
            <select name="tipo_hardware" id="tipo_hardware" class="form-select" required onchange="mostrarCamposHardware()">
                <option value="" selected disabled>Seleccione un tipo de hardware</option>
                <option value="memoria_gpu">Memorias GPU</option>
                <option value="frecuencia_gpu">Frecuencias GPU</option>
                <option value="frecuencia_cpu">Frecuencias CPU</option>
                <option value="socket_cpu">Socket CPU</option>
                <option value="nucleo_hilo_cpu">Nucleos Hilos CPU</option>
                <option value="socket_placa">Socket Placa</option>  
                <option value="slot_memoria_placa">Slot Memoria Placa</option>
                <option value="voltaje_ram">Voltaje Ram</option>
                <option value="velocidad_ram">Velocidad Ram</option> 
                <option value="capacidad_almacenamiento">Capacidad Almacenamiento</option>
                <option value="formato_placa">Formato Placa</option>
                <option value="capacidad_ram">Capacidad Ram</option>
                <option value="tipo_ram">Tipo Ram</option>
                <option value="certificacion_fuente">Certificacion Fuente</option>
                <option value="tipo_cableado">Tipo Cableado</option>
                <option value="tamanio_fuente">Tamaño Fuente</option> 
                <option value="potencia_fuente">Potencia Fuente</option> 
                <option value="tamanio_placa">Tamaño Placa</option>
            </select>
        </div>

        <!-- Campos para Memoria gpu (Ocultos inicialmente) -->
        <div class="mb-3" id="campoMemoria_gpu" style="display: none;">       
            <label for="memoria_gpu" class="form-label mt-3">Memoria GPU</label>
            <input type="text" name="memoria_gpu" class="form-control" id="memoria_gpu">
        </div>

        <!-- Campos para frecuencia gpu (Ocultos inicialmente) -->
        <div class="mb-3" id="camposFrecuencia_gpu" style="display: none;">
            <label for="frecuencia_gpu" class="form-label">Frecuencia CPU</label>
            <input type="text" name="frecuencia_gpu" class="form-control" id="frecuencia_gpu">
        </div>
        <!-- Campos para frecuencia cpu (Ocultos inicialmente) -->
        <div class="mb-3" id="camposFrecuencia_cpu" style="display: none;">
            <label for="frecuencia_cpu" class="form-label">Frecuencia CPU</label>
            <input type="text" name="frecuencia_cpu" class="form-control" id="frecuencia_cpu">
        </div>

        <!-- Campos para socket cpu (Ocultos inicialmente) -->
        <div class="mb-3" id="camposSocket_cpu" style="display: none;">
            <label for="socket_cpu" class="form-label">Socket CPU</label>
            <input type="text" name="socket_cpu" class="form-control" id="socket_cpu">
        </div>

        <!-- Campos para nucleo hilo cpu (Ocultos inicialmente) -->
        <div class="mb-3" id="camposNucleo_hilo_cpu" style="display: none;">
            <label for="nucleo_hilo_cpu" class="form-label">Hilos cpu</label>
            <input type="text" name="nucleo_hilo_cpu" class="form-control" id="nucleo_hilo_cpu">
        </div>

        <!-- Campos para nucleo hilo cpu (Ocultos inicialmente) -->
        <div class="mb-3" id="camposNucleo_hilo_cpu" style="display: none;">
            <label for="nucleo_hilo_cpu" class="form-label">Hilos cpu</label>
            <input type="text" name="nucleo_hilo_cpu" class="form-control" id="nucleo_hilo_cpu">
        </div>

         <!-- Campos para socket_placa (Ocultos inicialmente) -->
         <div class="mb-3" id="camposSocket_placa" style="display: none;">
            <label for="socket_placa" class="form-label">Socket Placa</label>
            <input type="text" name="socket_placa" class="form-control" id="socket_placa">
        </div>

        <!-- Campos para slot_memoria_placa (Ocultos inicialmente) -->
        <div class="mb-3" id="camposSlot_memoria_placa" style="display: none;">
            <label for="slot_memoria_placa" class="form-label">Slot Memoria Placa</label>
            <input type="text" name="slot_memoria_placa" class="form-control" id="slot_memoria_placa">
        </div>

        <!-- Campos para voltaje ram (Ocultos inicialmente) -->
        <div class="mb-3" id="camposVoltaje_ram" style="display: none;">
            <label for="voltaje_ram" class="form-label">Voltaje Ram</label>
            <input type="text" name="voltaje_ram" class="form-control" id="voltaje_ram">
        </div>
        <!-- Campos para velocidad ram (Ocultos inicialmente) -->
        <div class="mb-3" id="camposVelocidad_ram" style="display: none;">
            <label for="velocidad_ram" class="form-label">Velocidad Ram</label>
            <input type="text" name="velocidad_ram" class="form-control" id="velocidad_ram">
        </div><!-- Agregar más campos similares para otros tipos de hardware según sea necesario -->
        
        <!-- Campos para capacidad almacenamiento (Ocultos inicialmente) -->
        <div class="mb-3" id="camposCapacidad_almacenamiento" style="display: none;">
            <label for="capacidad_almacenamiento" class="form-label">Capacidad Almacenamiento</label>
            <input type="text" name="capacidad_almacenamiento" class="form-control" id="capacidad_almacenamiento">
        </div><!-- Agregar más campos similares para otros tipos de hardware según sea necesario -->

        <!-- Campos para formato placa (Ocultos inicialmente) -->
        <div class="mb-3" id="camposFormato_placa" style="display: none;">
            <label for="formato_placa" class="form-label">Formato Placa</label>
            <input type="text" name="formato_placa" class="form-control" id="formato_placa">
        </div><!-- Agregar más campos similares para otros tipos de hardware según sea necesario -->

        <!-- Campos para formato placa (Ocultos inicialmente) -->
        <div class="mb-3" id="camposCapacidad_ram" style="display: none;">
            <label for="capacidad_ram" class="form-label">Capacidad Ram</label>
            <input type="text" name="capacidad_ram" class="form-control" id="capacidad_ram">
        </div><!-- Agregar más campos similares para otros tipos de hardware según sea necesario -->

        <!-- Campos para formato placa (Ocultos inicialmente) -->
        <div class="mb-3" id="camposTipo_ram" style="display: none;">
            <label for="tipo_ram" class="form-label">Tipo Ram</label>
            <input type="text" name="tipo_ram" class="form-control" id="tipo_ram">

        </div><!-- Agregar más campos similares para otros tipos de hardware según sea necesario -->

        <div class="mb-3" id="camposCertificacion_fuente" style="display: none;">
            <label for="certificacion_fuente" class="form-label">Certificacion Fuente</label>
            <input type="text" name="certificacion_fuente" class="form-control" id="certificacion_fuente">

        </div><!-- Agregar más campos similares para otros tipos de hardware según sea necesario -->

        <div class="mb-3" id="camposTipo_cableado" style="display: none;">
            <label for="tipo_cableado" class="form-label">Tipo Cableado</label>
            <input type="text" name="tipo_cableado" class="form-control" id="tipo_cableado">

        </div><!-- Agregar más campos similares para otros tipos de hardware según sea necesario -->

        <div class="mb-3" id="camposTamanio_fuente" style="display: none;">
            <label for="tamanio_fuente" class="form-label">Tamaño Fuente</label>
            <input type="text" name="tamanio_fuente" class="form-control" id="tamanio_fuente">

        </div><!-- Agregar más campos similares para otros tipos de hardware según sea necesario -->

        <div class="mb-3" id="camposPotencia_fuente" style="display: none;">
            <label for="potencia_fuente" class="form-label">Potencia Fuente</label>
            <input type="text" name="potencia_fuente" class="form-control" id="potencia_fuente">

        </div><!-- Agregar más campos similares para otros tipos de hardware según sea necesario -->

        <div class="mb-3" id="camposTamanio_placa" style="display: none;">
            <label for="tamanio_placa" class="form-label">Tamaño Placa</label>
            <input type="text" name="tamanio_placa" class="form-control" id="tamanio_placa">

        </div><!-- Agregar más campos similares para otros tipos de hardware según sea necesario -->

        <button type="submit" class="btn btn-primary mt-3">Guardar Hardware</button>
    </form>

</div>

<!-- JavaScript para mostrar los campos adicionales dinámicamente -->
<script>
    function mostrarCamposHardware() {
        var tipoHardware = document.getElementById("tipo_hardware").value;

        // Ocultar todos los campos inicialmente
        document.getElementById("campoMemoria_gpu").style.display = "none";
        document.getElementById("camposFrecuencia_gpu").style.display = "none";
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

        // Mostrar solo los campos correspondientes al tipo de hardware seleccionado
        if (tipoHardware === "memoria_gpu") {
            document.getElementById("campoMemoria_gpu").style.display = "block";
        } else if (tipoHardware === "frecuencia_gpu") {
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
        // Agregar más condiciones si se agregan más tipos de hardware
    }
</script>

</body>
</html>
