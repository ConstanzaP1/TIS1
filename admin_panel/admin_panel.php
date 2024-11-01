<?php
session_start();

require_once '../conexion.php'; // Asegúrate de que el archivo conexion.php esté en la ruta correcta

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../login/login.php');
    exit;
}

// Inicializar mensajes
$message = '';
$error_message = '';

// Manejar la acción de logout
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: ../login/login.php');
    exit;
}

// Manejar la acción de registro
if ($_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_POST['update'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Validar si el correo electrónico ya existe
    $sql_check_email = "SELECT * FROM users WHERE email = ?";
    $stmt_check_email = mysqli_prepare($conexion, $sql_check_email);
    mysqli_stmt_bind_param($stmt_check_email, 's', $email); 
    mysqli_stmt_execute($stmt_check_email);
    mysqli_stmt_store_result($stmt_check_email);
    
    if (mysqli_stmt_num_rows($stmt_check_email) > 0) {
        $error_message = 'El correo electrónico ya está en uso.';
    } else {
        // Insertar el nuevo usuario
        $sql_insert = "INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)";
        $stmt_insert = mysqli_prepare($conexion, $sql_insert);
        
        // Verificar si la preparación fue exitosa
        if ($stmt_insert) {
            // Hashear la contraseña antes de almacenarla
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            mysqli_stmt_bind_param($stmt_insert, 'ssss', $username, $email, $hashed_password, $role);
            
            if (mysqli_stmt_execute($stmt_insert)) {
                $message = 'Usuario registrado exitosamente.';
            } else {
                $error_message = 'Error al registrar el usuario. Inténtalo de nuevo.';
            }
            mysqli_stmt_close($stmt_insert); // Cerrar la declaración solo si fue creada
        } else {
            $error_message = 'Error al preparar la consulta de inserción.';
        }
    }
    
    mysqli_stmt_close($stmt_check_email);
}

// Manejar la acción de eliminación de usuario
if (isset($_GET['delete'])) {
    $user_id = $_GET['delete']; // Obtén el ID del usuario a eliminar

    // Eliminar el usuario
    $sql_delete = "DELETE FROM users WHERE id = ?";
    $stmt_delete = mysqli_prepare($conexion, $sql_delete);

    if ($stmt_delete) {
        mysqli_stmt_bind_param($stmt_delete, 'i', $user_id);
        if (mysqli_stmt_execute($stmt_delete)) {
            $message = 'Usuario eliminado exitosamente.'; // Mensaje de éxito
        } else {
            $error_message = 'Error al eliminar el usuario. Inténtalo de nuevo.'; // Mensaje de error
        }
        mysqli_stmt_close($stmt_delete);
    } else {
        $error_message = 'Error al preparar la consulta de eliminación.'; // Mensaje de error
    }
}

// Manejar la acción de modificar usuario
if (isset($_POST['update'])) {
    $user_id = $_POST['user_id'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $role = $_POST['role'];

    // Actualizar el usuario
    $sql_update = "UPDATE users SET username = ?, email = ?, role = ? WHERE id = ?";
    $stmt_update = mysqli_prepare($conexion, $sql_update);
    mysqli_stmt_bind_param($stmt_update, 'sssi', $username, $email, $role, $user_id);
    
    if (mysqli_stmt_execute($stmt_update)) {
        $message = 'Usuario actualizado exitosamente.';
    } else {
        $error_message = 'Error al actualizar el usuario. Inténtalo de nuevo.';
    }
    
    mysqli_stmt_close($stmt_update);
}

// Obtener todos los usuarios
$sql_users = "SELECT id, username, email, role FROM users";
$result_users = mysqli_query($conexion, $sql_users);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración</title>
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body {
        display: flex;
        height: 100vh;
        margin: 0;
    }

    #sidebar {
        width: 33%;
        background: #f8f9fa;
        border-right: 1px solid #ddd;
        padding: 10px;
    }

    #content {
        flex: 1;
        padding: 20px;
        overflow-y: auto;
    }

    /* Estilo del botón "Lista de Usuarios" */
    .lista-usuarios-btn {
        display: block; /* Para que ocupe todo el ancho como en el acordeón */
        cursor: pointer;
        padding: 10px;
        background-color: #e9ecef;
        border: 1px solid #ddd;
        color: #000;
        text-decoration: none;
        border-radius: 4px;
        margin-bottom: 5px;
        text-align: left; 

    }

    .lista-usuarios-btn:hover {
        background-color: #d3d3d3;
    }

    .accordion-item {
        margin-bottom: 5px;
    }

    .accordion-header {
        cursor: pointer;
        padding: 10px;
        background-color: #e9ecef;
        border: 1px solid #ddd;
    }

    .accordion-content {
        display: none;
        padding: 10px;
        border: 1px solid #ddd;
        border-top: none;
        background: #f1f1f1;
    }

    .active {
        background-color: #d3d3d3;
    }

    .logout {
        margin-top: 20px;
    }

    .registro {
        margin-bottom: 20px;
        background-color: #f8f9fa;
        padding: 15px;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .message {
        margin-top: 10px;
    }
</style>
</head>

<body>
    <aside id="sidebar">
    <img class="logo img-fluid w-100" src="../logo.jpg" alt="Logo">

        <h4>Panel de Administración</h4>
        
        <div class="accordion-item">
    <div class="accordion-header">Hardware</div>
    <div class="accordion-content">
        <ul>
            <!-- Subcategoría: Almacenamiento -->
            <li>
            <a href="#" class="sub-category-header">Almacenamiento</a>
                        <ul class="sub-category-content" style="display: none;">
                            <li><a href="../mantenedores_hardware/capacidad_almacenamiento.php">Capacidad Almacenamiento</a></li>
                            <li><a href="../mantenedores_hardware/bus_hdd.php">Bus HDD</a></li>
                            <li><a href="../mantenedores_hardware/bus_ssd.php">Bus SSD</a></li>
                            <li><a href="../mantenedores_hardware/formato_ssd.php">Formato SSD</a></li>
                            <li><a href="../mantenedores_hardware/rpm_hdd.php">RPM HDD</a></li>
                            <li><a href="../mantenedores_hardware/tamanio_hdd.php">Tamaño HDD</a></li>
                        </ul>
                    </li>

            </li>

            <!-- Subcategoría: RAM -->
            <li>
                <a href="#" class="sub-category-header">RAM</a>
                <ul class="sub-category-content" style="display: none;">
                    <li><a href="../mantenedores_hardware/tipo_ram.php">Tipo RAM</a></li>
                    <li><a href="../mantenedores_hardware/velocidad_ram.php">Velocidad RAM</a></li>
                    <li><a href="../mantenedores_hardware/capacidad_ram.php">Capacidad RAM</a></li>
                    <li><a href="../mantenedores_hardware/formato_ram.php">Formato RAM</a></li>
                </ul>
            </li>

            <!-- Subcategoría: CPU -->
            <li>
                <a href="#" class="sub-category-header">CPU</a>
                <ul class="sub-category-content" style="display: none;">
                    <li><a href="../mantenedores_hardware/frecuencia_cpu.php">Frecuencia CPU</a></li>
                    <li><a href="../mantenedores_hardware/nucleo_hilo_cpu.php">Núcleo/Hilo CPU</a></li>
                    <li><a href="../mantenedores_hardware/socket_cpu.php">Socket CPU</a></li>
                </ul>
            </li>

            <!-- Subcategoría: GPU -->
            <li>
                <a href="#" class="sub-category-header">GPU</a>
                <ul class="sub-category-content" style="display: none;">
                    <li><a href="../mantenedores_hardware/frecuencia_gpu.php">Frecuencia GPU</a></li>
                    <li><a href="../mantenedores_hardware/memoria_gpu.php">Memoria GPU</a></li>
                    <li><a href="../mantenedores_hardware/chipset_gpu.php">Chipset GPU</a></li>
                    <li><a href="../mantenedores_hardware/bus_de_entrada_gpu.php">Bus de Entrada GPU</a></li>
                </ul>
            </li>

            <!-- Subcategoría: Placas -->
            <li>
                <a href="#" class="sub-category-header">Placas</a>
                <ul class="sub-category-content" style="display: none;">
                    <li><a href="../mantenedores_hardware/formato_placa.php">Formato Placa</a></li>
                    <li><a href="../mantenedores_hardware/slot_memoria_placa.php">Slot Memoria Placa</a></li>
                    <li><a href="../mantenedores_hardware/socket_placa.php">Socket Placa</a></li>
                    <li><a href="../mantenedores_hardware/chipset_placa.php">Chipset Placa</a></li>
                </ul>
            </li>

            <!-- Subcategoría: Fuentes -->
            <li>
                <a href="#" class="sub-category-header">Fuentes</a>
                <ul class="sub-category-content" style="display: none;">
                    <li><a href="../mantenedores_hardware/certificacion_fuente.php">Certificación Fuente</a></li>
                    <li><a href="../mantenedores_hardware/potencia_fuente.php">Potencia Fuente</a></li>
                    <li><a href="../mantenedores_hardware/tamanio_fuente.php">Tamaño Fuente</a></li>
                </ul>
            </li>

            <!-- Subcategoría: Gabinetes -->
            <li>
                <a href="#" class="sub-category-header">Gabinetes</a>
                <ul class="sub-category-content" style="display: none;">
                    <li><a href="../mantenedores_hardware/tamanio_max_gabinete.php">Tamaño Max Gabinete</a></li>
                </ul>
            </li>

        </ul>
    </div>
</div>

<style>
    .sub-category-header {
        cursor: pointer;
        font-weight: bold;
    }
    .sub-category-content {
        padding-left: 20px; /* Indentación para la subcategoría */
    }
</style>

</script>
</script>
<div class="accordion-item">
    <div class="accordion-header">Periféricos</div>
    <div class="accordion-content">
        <ul>
            <!-- Subcategoría: Monitores -->
            <li>
                <a href="#" class="sub-category-header">Monitores</a>
                <ul class="sub-category-content" style="display: none;">
                    <li><a href="../mantenedores_periferico/resolucion_monitor.php">Resolución Monitor</a></li>
                    <li><a href="../mantenedores_periferico/tamano_monitor.php">Tamaño Monitor</a></li>
                    <li><a href="../mantenedores_periferico/tasa_refresco.php">Tasa de Refresco</a></li>
                    <li><a href="../mantenedores_periferico/tiempo_respuesta.php">Tiempo de Respuesta</a></li>
                    <li><a href="../mantenedores_periferico/soporte_monitor.php">Soporte Monitor</a></li>
                    <li><a href="../mantenedores_periferico/tipo_panel.php">Tipo Panel</a></li>
                    <li><a href="../mantenedores_periferico/tipo_curvatura.php">Tipo Curvatura</a></li>
                </ul>
            </li>

            <!-- Subcategoría: Mouse -->
            <li>
                <a href="#" class="sub-category-header">Mouse</a>
                <ul class="sub-category-content" style="display: none;">
                    <li><a href="../mantenedores_periferico/dpi_mouse.php">DPI Mouse</a></li>
                    <li><a href="../mantenedores_periferico/peso_mouse.php">Peso Mouse</a></li>
                    <li><a href="../mantenedores_periferico/sensor_mouse.php">Sensor Mouse</a></li>
                </ul>
            </li>

            <!-- Subcategoría: Audio -->
            <li>
                <a href="#" class="sub-category-header">Audifonos</a>
                <ul class="sub-category-content" style="display: none;">
                    <li><a href="../mantenedores_periferico/tipo_audifono.php">Tipo Audífono</a></li>
                    <li><a href="../mantenedores_periferico/tipo_microfono.php">Tipo Micrófono</a></li>
                    <li><a href="../mantenedores_periferico/anc.php">ANC</a></li>
                    <li><a href="../mantenedores_periferico/iluminacion.php">Iluminación</a></li>
                    <li><a href="../mantenedores_periferico/conectividad.php">Conectividad</a></li>
                </ul>
            </li>


            <!-- Subcategoría: Teclados -->
            <li>
                <a href="#" class="sub-category-header">Teclados</a>
                <ul class="sub-category-content" style="display: none;">
                    <li><a href="../mantenedores_periferico/tipo_teclado.php">Tipo Teclado</a></li>
                    <li><a href="../mantenedores_periferico/tipo_switch.php">Tipo Switch</a></li>
                    <li><a href="../mantenedores_periferico/categoria_teclado.php">Categoria</a></li>
                    <li><a href="../mantenedores_periferico/iluminacion.php">Iluminación</a></li>
                    <li><a href="../mantenedores_periferico/conectividad.php">Conectividad</a></li>
                </ul>
            </li>

            <!-- Subcategoría: Otros Periféricos -->

        </ul>
    </div>
</div>

<div class="accordion-item">
    <div class="accordion-header">Notebook</div>
    <div class="accordion-content">
        <ul>
            <!-- Subcategoría: Batería -->
            <li><a href="../mantenedores_notebook/bateria_notebook.php">Batería</a></li>

            <!-- Subcategoría: Procesador -->
            <li><a href="../mantenedores_notebook/cpu_notebook.php">Procesador</a></li>

            <!-- Subcategoría: Tarjeta de video -->
            <li><a href="../mantenedores_notebook/gpu_notebook.php">Tarjeta de video</a></li>

            <!-- Subcategoría: Pantalla -->
            <li><a href="../mantenedores_notebook/pantalla_notebook.php">Pantalla</a></li>
        </ul>
    </div>
</div>
<div class="accordion-item">
    <div class="accordion-header">Marcas</div>
        <div class="accordion-content">
            <ul>
                <li><a href="../mantenedores_marcas/nombres_marcas.php">Agregar Marcas</a></li>
            
            </ul>
        </div>
    </div>
</div>

<div class="acordion-item">
    <div class="accordion-header">Gestionar productos</div>
        <div class="accordion-content">
            <ul>
                <li><a href="../creacion_productos/index_crear_producto.php">Crear producto</a></li>
                <li><a href="../creacion_productos/listar_productos.php">Modificar productos</a></li>
            </ul>
        </div>
    </div>
</div>
<style>
    .sub-category-header {
        cursor: pointer;
        font-weight: bold;
    }
    .sub-category-content {
        padding-left: 20px; /* Indentación para la subcategoría */
    }
</style>
<script>

    document.querySelectorAll('.sub-category-header').forEach(header => {
        header.addEventListener('click', function () {
            const subCategory = this.nextElementSibling;
            subCategory.style.display = subCategory.style.display === 'none' ? 'block' : 'none';
        });
    });
</script>
<div class="usuarios-container mt-2">
    <!-- Botón para redirigir a lista_usuarios.php -->
    <a href="lista_usuarios.php" class="btn lista-usuarios-btn">Lista de Usuarios</a>
</div>
<hr>

<div class="sidebar-container p-3">
    <div class="d-flex flex-row gap-2">
        <!-- Botón en el sidebar para abrir el modal de registro de usuario -->
        <button type="button" class="btn btn-primary flex-grow-1" data-bs-toggle="modal" data-bs-target="#registrarUsuarioModal">
            Registrar Usuario
        </button>

        <!-- Botón para el catálogo de productos -->
        <a href="../index.php" class="btn btn-primary flex-grow-1 d-flex align-items-center justify-content-center">
            Catálogo productos
        </a>

        <!-- Botón para cerrar sesión -->
        <a href="?logout" class="btn btn-danger flex-grow-1 d-flex align-items-center justify-content-center">
            Cerrar Sesión
        </a>
    </div>
</div>

<!-- Modal para el formulario de registro de usuario -->
<div class="modal fade" id="registrarUsuarioModal" tabindex="-1" aria-labelledby="registrarUsuarioLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="registrarUsuarioLabel">Registrar Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="">
                    <div class="mb-3">
                        <label for="username" class="form-label">Nombre de Usuario</label>
                        <input type="text" class="form-control" name="username" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Correo Electrónico</label>
                        <input type="email" class="form-control" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" name="password" required>
                    </div>
                    <div class="mb-3">
                        <label for="role" class="form-label">Rol</label>
                        <select name="role" class="form-select">
                            <option value="user">Usuario</option>
                            <option value="admin">Administrador</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Registrar</button>
                </form>
                <div class="message mt-3">
                    <?php if (!empty($message)): ?>
                        <div class="alert alert-success"><?php echo $message; ?></div>
                    <?php endif; ?>
                    <?php if (!empty($error_message)): ?>
                        <div class="alert alert-danger"><?php echo $error_message; ?></div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php if (!empty($message)): ?>
    <script>
        Swal.fire({
            icon: 'success',
            title: '¡Éxito!',
            text: '<?php echo $message; ?>',
            confirmButtonText: 'Aceptar'
        });
    </script>
<?php endif; ?>

<?php if (!empty($error_message)): ?>
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: '<?php echo $error_message; ?>',
            confirmButtonText: 'Aceptar'
        });
    </script>
<?php endif; ?>


</aside>

<style>
    .registro {
        max-height: 55vh; /* Ajustar la altura máxima */
        overflow-y: auto; /* Habilitar scroll vertical */
        padding: 5px; /* Espaciado interno */
        border: 1px solid #ccc; /* Borde para el contenedor */
        background-color: #f9f9f9; /* Color de fondo */
        box-sizing: border-box; /* Incluir padding y borde en el tamaño total */
    }

    .mb-3 {
        margin-bottom: 1px; /* Espacio entre los elementos */
    }

    .form-control, .form-select {
        width: 100%; /* Hacer los campos de formulario ocupar el ancho completo */
    }

    .message {
        margin-top: 1px; /* Espacio superior para el mensaje */
    }

    /* Limitar la altura del contenedor de mensajes */
    .message .alert {
        max-height: 50px; /* Altura máxima para los mensajes */
        overflow: hidden; /* Ocultar contenido que se salga */
    }
</style>

<script>
    // Script para manejar el acordeón
    const headers = document.querySelectorAll('.accordion-header');
    headers.forEach(header => {
        header.addEventListener('click', () => {
            const content = header.nextElementSibling;
            content.style.display = content.style.display === 'block' ? 'none' : 'block';
            header.classList.toggle('active');
        });
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
