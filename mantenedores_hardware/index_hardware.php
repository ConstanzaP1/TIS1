<?php
    require('conexion.php');
    // Obtener el ID del hardware a modificar
    $query = "
    SELECT p.id_hardware, m.memoria, mg.memoria_gpu, fg.frecuencia_gpu,
           fc.frecuencia_cpu, sc.socket_cpu,
           nhc.nucleo_hilo_cpu, sp.socket_placa,
           smp.slot_memoria_placa, vr.voltaje_ram,
           ve.velocidad_ram, ca.capacidad_almacenamiento,
           fp.formato_placa,cr.capacidad_ram,tr.tipo_ram,cf.certificacion_fuente,
           tc.tipo_cableado,tf.tamanio_fuente,pf.potencia_fuente,tp.tamanio_placa
    FROM hardware p
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

";

$result = mysqli_query($conexion, $query);
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
                <option value="memoria">Memoria</option>
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
        <div class="mb-3" id="camposMemoria" style="display: none;">       
            <label for="memoria" class="form-label mt-3">Memoria</label>
            <input type="text" name="memoria" class="form-control" id="memoria">
        </div>
        <div class="mb-3" id="camposMemoria_gpu" style="display: none;">       
            <label for="memoria_gpu" class="form-label mt-3">Memoria GPU</label>
            <input type="text" name="memoria_gpu" class="form-control" id="memoria_gpu">
        </div>

        <!-- Campos para frecuencia gpu (Ocultos inicialmente) -->
        <div class="mb-3" id="camposFrecuencia_gpu" style="display: none;">
            <label for="frecuencia_gpu" class="form-label">Frecuencia GPU</label>
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
            <label for="nucleo_hilo_cpu" class="form-label">Nucloe Hilos Cpu</label>
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
        <button class="btn btn-secondary mt-3" onclick="window.location.href='index.php';">Volver a Inicio</button>

    </form>
    <!-- Tabla para mostrar los datos guardados -->
    <h2 class="mb-4">Hardware Registrados</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID Hardware</th>
                <th>Memoria</th>
                <th>Memoria GPU</th>
                <th>Frecuencia GPU</th>
                <th>Frecuencia CPU</th>
                <th>Socket CPU</th>
                <th>Nucleo Hilo Cpu</th>
                <th>Socket Placa</th>
                <th>Slot Memoria Placa</th>
                <th>Voltaje Ram</th>
                <th>Velocidad Ram</th>
                <th>Capacidad Almacenamiento</th>
                <th>Formato Placa</th>
                <th>Capacidad Ram</th>
                <th>Tipo Ram</th>
                <th>Certificacion Fuente</th>
                <th>Tipo Cableado</th>
                <th>Tamaño Fuente</th>
                <th>Potencia Fuente</th>
                <th>Tamanño Placa</th>
                <th>Acciones</th> <!-- Nueva columna para botones -->
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                <tr>
                    <td><?php echo $row['id_hardware']; ?></td>
                    <td><?php echo $row['memoria']; ?></td>
                    <td><?php echo $row['memoria_gpu']; ?></td>
                    <td><?php echo $row['frecuencia_gpu']; ?></td>
                    <td><?php echo $row['frecuencia_cpu']; ?></td>
                    <td><?php echo $row['socket_cpu']; ?></td>
                    <td><?php echo $row['nucleo_hilo_cpu']; ?></td>
                    <td><?php echo $row['socket_placa']; ?></td>
                    <td><?php echo $row['slot_memoria_placa']; ?></td>
                    <td><?php echo $row['voltaje_ram']; ?></td>
                    <td><?php echo $row['velocidad_ram']; ?></td>
                    <td><?php echo $row['capacidad_almacenamiento']; ?></td>
                    <td><?php echo $row['formato_placa']; ?></td>
                    <td><?php echo $row['capacidad_ram']; ?></td>
                    <td><?php echo $row['tipo_ram']; ?></td>
                    <td><?php echo $row['certificacion_fuente']; ?></td>
                    <td><?php echo $row['tipo_cableado']; ?></td>
                    <td><?php echo $row['tamanio_fuente']; ?></td>
                    <td><?php echo $row['potencia_fuente']; ?></td>
                    <td><?php echo $row['tamanio_placa']; ?></td>



                    <td>
                        <a href="modificar_hardware.php?id_hardware=<?php echo $row['id_hardware']; ?>">Modificar</a> | 
                        <a href="eliminar_hardware.php?id_hardware=<?php echo $row['id_hardware']; ?>">Eliminar</a>

                    </td> <!-- Botones de acción -->
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<!-- JavaScript para mostrar los campos adicionales dinámicamente -->
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

        // Mostrar solo los campos correspondientes al tipo de hardware seleccionado
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
        // Agregar más condiciones si se agregan más tipos de hardware
    }
</script>

</body>
</html>
