<?php
session_start();

require_once '../conexion.php';

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role'], ['admin', 'superadmin'])) {
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

// Definir el límite de stock bajo (puede hacerse configurable)
$stock_limite = 10;

// Consulta para obtener productos con bajo stock
$sql_stock_bajo = "SELECT nombre_producto, cantidad FROM producto WHERE cantidad < ?";
$stmt_stock = mysqli_prepare($conexion, $sql_stock_bajo);
mysqli_stmt_bind_param($stmt_stock, 'i', $stock_limite);
mysqli_stmt_execute($stmt_stock);
$result_stock = mysqli_stmt_get_result($stmt_stock);

// Generar notificaciones para cada producto con bajo stock
$notificaciones_stock = [];
while ($row = mysqli_fetch_assoc($result_stock)) {
    $notificaciones_stock[] = $row;
}

mysqli_stmt_close($stmt_stock);


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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <style>
        .menu-button {
            position: relative;
            top: 10px;
            left: 10px;
            z-index: 1050; /* Asegura que el botón esté por encima de otros elementos */
            width: 20%; /* Un poco menos de la mitad de la pantalla */
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Botón para abrir el menú en pantallas pequeñas -->
            <button 
                class="btn btn-primary btn-sm d-lg-none menu-button" 
                type="button" 
                data-bs-toggle="offcanvas" 
                data-bs-target="#sidebar" 
                aria-controls="sidebar">
                <i class="fas fa-bars"></i> Menú
            </button>

            <!-- Sidebar (Offcanvas en móviles, barra fija en pantallas grandes) -->
            <nav class="col-lg-2 col-md-4 bg-dark text-white vh-100 d-flex flex-column p-3 d-none d-lg-flex">
                <!-- Logo -->
                <div class="text-center mb-4">
                    <a href="../index.php">
                        <img class="logo img-fluid w-75 rounded-pill" src="../logopng.png" alt="Logo">
                    </a>
                </div>
                <h4 class="text-center">Panel de Administración</h4>
                <!-- Menú principal -->
                <ul class="nav flex-column">
                    <!-- Mantenedores -->
                    <li class="nav-item">
                        <a class="nav-link text-white dropdown-toggle" data-bs-toggle="collapse" href="#menuMantenedores" role="button">
                            <i class="fas fa-tools"></i> Mantenedores
                        </a>
                        <ul class="collapse list-unstyled ps-3" id="menuMantenedores">
                            <!-- Hardware -->
                            <li>
                                <a class="nav-link text-white dropdown-toggle" data-bs-toggle="collapse" href="#menuHardware" role="button">
                                    <i class="fas fa-microchip"></i> Hardware
                                </a>
                                <ul class="collapse list-unstyled ps-3" id="menuHardware">
                                    <!-- SSD -->
                                    <li>
                                        <a class="nav-link text-white dropdown-toggle" data-bs-toggle="collapse" href="#submenuSSD" role="button">
                                            SSD
                                        </a>
                                        <ul class="collapse list-unstyled ps-3" id="submenuSSD">
                                            <li><a href="../mantenedores_hardware/capacidad_almacenamiento.php" class="nav-link text-white">Capacidad Almacenamiento</a></li>
                                            <li><a href="../mantenedores_hardware/bus_ssd.php" class="nav-link text-white">Bus SSD</a></li>
                                            <li><a href="../mantenedores_hardware/formato_ssd.php" class="nav-link text-white">Formato SSD</a></li>
                                        </ul>
                                    </li>
                                    <!-- HDD -->
                                    <li>
                                        <a class="nav-link text-white dropdown-toggle" data-bs-toggle="collapse" href="#submenuHDD" role="button">
                                            HDD
                                        </a>
                                        <ul class="collapse list-unstyled ps-3" id="submenuHDD">
                                            <li><a href="../mantenedores_hardware/capacidad_almacenamiento.php" class="nav-link text-white">Capacidad Almacenamiento</a></li>
                                            <li><a href="../mantenedores_hardware/bus_hdd.php" class="nav-link text-white">Bus HDD</a></li>
                                            <li><a href="../mantenedores_hardware/rpm_hdd.php" class="nav-link text-white">RPM HDD</a></li>
                                            <li><a href="../mantenedores_hardware/tamanio_hdd.php" class="nav-link text-white">Tamaño HDD</a></li>
                                        </ul>
                                    </li>
                                    <!-- RAM -->
                                    <li>
                                        <a class="nav-link text-white dropdown-toggle" data-bs-toggle="collapse" href="#submenuRAM" role="button">
                                            RAM
                                        </a>
                                        <ul class="collapse list-unstyled ps-3" id="submenuRAM">
                                            <li><a href="../mantenedores_hardware/tipo_ram.php" class="nav-link text-white">Tipo RAM</a></li>
                                            <li><a href="../mantenedores_hardware/velocidad_ram.php" class="nav-link text-white">Velocidad RAM</a></li>
                                            <li><a href="../mantenedores_hardware/capacidad_ram.php" class="nav-link text-white">Capacidad RAM</a></li>
                                            <li><a href="../mantenedores_hardware/formato_ram.php" class="nav-link text-white">Formato RAM</a></li>
                                        </ul>
                                    </li>
                                    <!-- CPU -->
                                    <li>
                                        <a class="nav-link text-white dropdown-toggle" data-bs-toggle="collapse" href="#submenuCPU" role="button">
                                            CPU
                                        </a>
                                        <ul class="collapse list-unstyled ps-3" id="submenuCPU">
                                            <li><a href="../mantenedores_hardware/frecuencia_cpu.php" class="nav-link text-white">Frecuencia CPU</a></li>
                                            <li><a href="../mantenedores_hardware/nucleo_hilo_cpu.php" class="nav-link text-white">Núcleo/Hilo CPU</a></li>
                                            <li><a href="../mantenedores_hardware/socket_cpu.php" class="nav-link text-white">Socket CPU</a></li>
                                        </ul>
                                    </li>
                                    <!-- GPU -->
                                    <li>
                                        <a class="nav-link text-white dropdown-toggle" data-bs-toggle="collapse" href="#submenuGPU" role="button">
                                        GPU
                                        </a>
                                        <ul class="collapse list-unstyled ps-3" id="submenuGPU">
                                            <li><a href="../mantenedores_hardware/frecuencia_gpu.php" class="nav-link text-white">Frecuencia GPU</a></li>
                                            <li><a href="../mantenedores_hardware/memoria_gpu.php" class="nav-link text-white">Memoria GPU</a></li>
                                            <li><a href="../mantenedores_hardware/chipset_gpu.php" class="nav-link text-white">Chipset GPU</a></li>
                                            <li><a href="../mantenedores_hardware/bus_de_entrada_gpu.php" class="nav-link text-white">Bus de Entrada GPU</a></li>
                                        </ul>
                                    </li>
                                    <!-- PLACAS -->
                                    <li>
                                        <a class="nav-link text-white dropdown-toggle" data-bs-toggle="collapse" href="#submenuPLACAS" role="button">
                                        PLACAS MADRE
                                        </a>
                                        <ul class="collapse list-unstyled ps-3" id="submenuPLACAS">
                                            <li><a href="../mantenedores_hardware/formato_placa.php" class="nav-link text-white">Formato Placa</a></li>
                                            <li><a href="../mantenedores_hardware/slot_memoria_placa.php" class="nav-link text-white">Slot Memoria Placa</a></li>
                                            <li><a href="../mantenedores_hardware/socket_placa.php" class="nav-link text-white">Socket Placa</a></li>
                                            <li><a href="../mantenedores_hardware/chipset_placa.php" class="nav-link text-white">Chipset Placa</a></li>
                                        </ul>
                                    </li>
                                    <!-- FUENTES -->
                                    <li>
                                        <a class="nav-link text-white dropdown-toggle" data-bs-toggle="collapse" href="#submenuFUENTE" role="button">
                                        FUENTE
                                        </a>
                                        <ul class="collapse list-unstyled ps-3" id="submenuFUENTE">
                                            <li><a href="../mantenedores_hardware/certificacion_fuente.php" class="nav-link text-white">Certificación Fuente</a></li>
                                            <li><a href="../mantenedores_hardware/potencia_fuente.php" class="nav-link text-white">Potencia Fuente</a></li>
                                            <li><a href="../mantenedores_hardware/tamanio_fuente.php" class="nav-link text-white">Tamaño Fuente</a></li>
                                        </ul>
                                    </li>
                                    <!-- GABINETE -->
                                    <li>
                                        <a class="nav-link text-white dropdown-toggle" data-bs-toggle="collapse" href="#submenuGABINETE" role="button">
                                        GABINETE
                                        </a>
                                        <ul class="collapse list-unstyled ps-3" id="submenuGABINETE">
                                            <li><a href="../mantenedores_hardware/tamanio_max_gabinete.php" class="nav-link text-white">Tamaño Max Gabinete</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>

                            <!-- Periféricos -->
                            <li>
                                <a class="nav-link text-white dropdown-toggle" data-bs-toggle="collapse" href="#menuPeriferico" role="button">
                                    <i class="fas fa-microchip"></i> Periféricos
                                </a>
                                <ul class="collapse list-unstyled ps-3" id="menuPeriferico">
                                    <!-- Monitores -->
                                    <li>
                                        <a class="nav-link text-white dropdown-toggle" data-bs-toggle="collapse" href="#submenuMONITORES" role="button">
                                        Monitores
                                        </a>
                                        <ul class="collapse list-unstyled ps-3" id="submenuMONITORES">
                                            <li><a href="../mantenedores_periferico/resolucion_monitor.php" class="nav-link text-white">Resolución Monitor</a></li>
                                            <li><a href="../mantenedores_periferico/tamanio_monitor.php" class="nav-link text-white">Tamaño Monitor</a></li>
                                            <li><a href="../mantenedores_periferico/tasa_refresco.php" class="nav-link text-white">Tasa de Refresco</a></li>
                                            <li><a href="../mantenedores_periferico/tiempo_respuesta.php" class="nav-link text-white">Tiempo de Respuesta</a></li>
                                            <li><a href="../mantenedores_periferico/soporte_monitor.php" class="nav-link text-white">Soporte Monitor</a></li>
                                            <li><a href="../mantenedores_periferico/tipo_panel.php" class="nav-link text-white">Tipo Panel</a></li>
                                            <li><a href="../mantenedores_periferico/tipo_curvatura.php" class="nav-link text-white">Tipo Curvatura</a></li>
                                        </ul>
                                    </li>
                                    <!-- Mouse -->
                                    <li>
                                        <a class="nav-link text-white dropdown-toggle" data-bs-toggle="collapse" href="#submenuMouse" role="button">
                                        Mouse
                                        </a>
                                        <ul class="collapse list-unstyled ps-3" id="submenuMouse">
                                            <li><a href="../mantenedores_periferico/dpi_mouse.php" class="nav-link text-white">DPI Mouse</a></li>
                                            <li><a href="../mantenedores_periferico/peso_mouse.php" class="nav-link text-white">Peso Mouse</a></li>
                                            <li><a href="../mantenedores_periferico/sensor_mouse.php" class="nav-link text-white">Sensor Mouse</a></li>
                                        </ul>
                                    </li>
                                    <!-- Audio -->
                                    <li>
                                        <a class="nav-link text-white dropdown-toggle" data-bs-toggle="collapse" href="#submenuAudio" role="button">
                                        Audio
                                        </a>
                                        <ul class="collapse list-unstyled ps-3" id="submenuAudio">
                                            <li><a href="../mantenedores_periferico/tipo_audifono.php" class="nav-link text-white">Tipo Audífono</a></li>
                                            <li><a href="../mantenedores_periferico/tipo_microfono.php" class="nav-link text-white">Tipo Micrófono</a></li>
                                            <li><a href="../mantenedores_periferico/anc.php" class="nav-link text-white">ANC</a></li>
                                            <li><a href="../mantenedores_periferico/iluminacion.php" class="nav-link text-white">Iluminación</a></li>
                                            <li><a href="../mantenedores_periferico/conectividad.php" class="nav-link text-white">Conectividad</a></li>
                                        </ul>
                                    </li>
                                    <!-- Teclados -->
                                    <li>
                                        <a class="nav-link text-white dropdown-toggle" data-bs-toggle="collapse" href="#submenuTeclados" role="button">
                                        Teclados
                                        </a>
                                        <ul class="collapse list-unstyled ps-3" id="submenuTeclados">
                                            <li><a href="../mantenedores_periferico/tipo_teclado.php" class="nav-link text-white">Tipo Teclado</a></li>
                                            <li><a href="../mantenedores_periferico/tipo_switch.php" class="nav-link text-white">Tipo Switch</a></li>
                                            <li><a href="../mantenedores_periferico/categoria_teclado.php" class="nav-link text-white">Categoria</a></li>
                                            <li><a href="../mantenedores_periferico/iluminacion.php" class="nav-link text-white">Iluminación</a></li>
                                            <li><a href="../mantenedores_periferico/conectividad.php" class="nav-link text-white">Conectividad</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>

                            <!-- Notebook -->
                            <li>
                                <a class="nav-link text-white dropdown-toggle" data-bs-toggle="collapse" href="#menuNotebook" role="button">
                                    <i class="fas fa-microchip"></i> Notebook
                                </a>
                                <ul class="collapse list-unstyled ps-3" id="menuNotebook">
                                    <!-- Subcategoría: Batería -->
                                    <li><a href="../mantenedores_notebook/bateria_notebook.php" class="nav-link text-white">Batería</a></li>

                                    <!-- Subcategoría: Procesador -->
                                    <li><a href="../mantenedores_notebook/cpu_notebook.php" class="nav-link text-white">Procesador</a></li>

                                    <!-- Subcategoría: Tarjeta de video -->
                                    <li><a href="../mantenedores_notebook/gpu_notebook.php" class="nav-link text-white">Tarjeta de video</a></li>

                                    <!-- Subcategoría: Pantalla -->
                                    <li><a href="../mantenedores_notebook/pantalla_notebook.php" class="nav-link text-white">Pantalla</a></li>
                                    
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <!-- Gestion productos -->
                    <li class="nav-item">
                        <a class="nav-link text-white dropdown-toggle" data-bs-toggle="collapse" href="#menuGestion_producto" role="button">
                            <i class="fas fa-tools"></i> Gestionar productos
                        </a>
                        <ul class="collapse list-unstyled ps-3" id="menuGestion_producto">
                            <li><a href="../creacion_productos/index_crear_producto.php" class="nav-link text-white">Crear producto</a></li>
                            <li><a href="../creacion_productos/listar_productos.php" class="nav-link text-white">Modificar productos</a></li>
                            <li><a href="../creacion_productos/crear_categoria.php" class="nav-link text-white">Crear Categorías</a></li>
                            <li><a href="../creacion_productos/gestionar_categoria.php" class="nav-link text-white">Gestionar Categorías</a></li>
                        </ul>
                    </li>
                    <!-- Acciones -->
                    <li class="nav-item">
                        <a class="nav-link text-white dropdown-toggle" data-bs-toggle="collapse" href="#menuAcciones" role="button">
                            <i class="fas fa-tools"></i> Acciones
                        </a>
                        <ul class="collapse list-unstyled ps-3" id="menuAcciones">
                            <!-- Botón para redirigir a lista_usuarios.php -->
                            <a href="lista_usuarios.php" class="nav-link text-white">Lista de Usuarios</a>
                            <!-- Nuevo botón para recuperar boletas -->
                            <a href="../boleta_cotizacion/recuperar_boletas.php" class="nav-link text-white">
                                Recuperar Boletas
                            </a>
                            <a href="#" class="nav-link text-white" data-bs-toggle="modal" data-bs-target="#registrarUsuarioModal">
                                Registrar Usuario
                            </a>
                            <a href="../postventa/admin_postventa.php" class="nav-link text-white">
                                Solicitudes Postventa
                            </a>
                            <!-- Modal para el formulario de registro de usuario -->
                            <div class="modal fade" id="registrarUsuarioModal" tabindex="-1" aria-labelledby="registrarUsuarioLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content bg-dark text-white border-secondary">
                                        <!-- Encabezado del Modal -->
                                        <div class="modal-header border-0">
                                            <h5 class="modal-title" id="registrarUsuarioLabel">Registrar Usuario</h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <!-- Cuerpo del Modal -->
                                        <div class="modal-body">
                                            <form method="POST" action="">
                                                <div class="mb-3">
                                                    <label for="username" class="form-label">Nombre de Usuario</label>
                                                    <input type="text" class="form-control bg-secondary text-white border-0" name="username" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="email" class="form-label">Correo Electrónico</label>
                                                    <input type="email" class="form-control bg-secondary text-white border-0" name="email" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="password" class="form-label">Contraseña</label>
                                                    <input type="password" class="form-control bg-secondary text-white border-0" name="password" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="role" class="form-label">Rol</label>
                                                    <select name="role" class="form-select bg-secondary text-white border-0">
                                                        <?php
                                                        session_start();
                                                        $current_role = $_SESSION['role'] ?? 'user'; 
                                                        if ($current_role === 'superadmin') {
                                                            echo '<option value="user">Usuario</option>';
                                                            echo '<option value="admin">Administrador</option>';
                                                        } elseif ($current_role === 'admin') {
                                                            echo '<option value="user">Usuario</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <button type="submit" class="btn btn-primary w-100">Registrar</button>
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
                        </ul>
                    </li>
                </ul>
                <button class="btn btn-secondary mt-auto" onclick="window.location.href='../index.php'">Volver al catalogo</button>
                <!-- Cerrar sesión -->
                <button class="btn btn-danger mt-2" onclick="window.location.href='?logout=true'">Cerrar Sesión</button>
            </nav>
            <!-- Sidebar para móviles -->
            <div class="offcanvas offcanvas-start bg-dark text-white d-lg-none" id="sidebar" tabindex="-1" aria-labelledby="sidebarLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="sidebarLabel">Panel de Administración</h5>
                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body p-3">
                    <!-- Logo -->
                    <div class="text-center mb-4">
                        <a href="../index.php">
                            <img class="logo img-fluid w-75 rounded-pill" src="../logopng.png" alt="Logo">
                        </a>
                    </div>
                    <h4 class="text-center">Panel de Administración</h4>

                    <!-- Menú principal -->
                    <ul class="nav flex-column">
                        <!-- Mantenedores -->
                        <li class="nav-item">
                            <a class="nav-link text-white dropdown-toggle" data-bs-toggle="collapse" href="#menuMantenedoresMobile" role="button">
                                <i class="fas fa-tools"></i> Mantenedores
                            </a>
                            <ul class="collapse list-unstyled ps-3" id="menuMantenedoresMobile">
                                <li><a href="#" class="nav-link text-white">SSD</a></li>
                                <li><a href="#" class="nav-link text-white">HDD</a></li>
                            </ul>
                        </li>
                    </ul>
                    <!-- Cerrar sesión -->
                    <button class="btn btn-danger mt-auto w-100" onclick="window.location.href='?logout=true'">Cerrar Sesión</button>
                </div>
            </div>
            <!-- Main Content -->
            <main class="col-lg-10 col-md-12 p-4">
                <header class="mb-4">
                    <h1 class="text-center">Dashboard</h1>
                </header>
                <body>
                    <!-- meter cosas aca -->
                </body>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: '<?php echo $error_message; ?>',
                confirmButtonText: 'Aceptar'
            });
        </script>
    <script>
            Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: '<?php echo $message; ?>',
                confirmButtonText: 'Aceptar'
            });
        </script>
    <script>
        document.querySelectorAll('.sub-category-header').forEach(header => {
            header.addEventListener('click', function() {
                const subCategory = this.nextElementSibling;
                subCategory.style.display = subCategory.style.display === 'none' ? 'block' : 'none';
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            toastr.options = {
                'closeButton': true,
                'positionClass': 'toast-top-right',
                'timeOut': '50000'
            };

            // Generar notificaciones dinámicamente desde PHP
            <?php if (!empty($notificaciones_stock)): ?>
                <?php foreach ($notificaciones_stock as $producto): ?>
                    toastr.warning(
                        'El producto "<?php echo $producto['nombre_producto']; ?>" tiene un stock bajo (<?php echo $producto['cantidad']; ?> unidades).'
                    );
                <?php endforeach; ?>
            <?php else: ?>
                console.log('No hay productos con stock bajo.');
            <?php endif; ?>
        });
    </script>

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
</body>
</html>