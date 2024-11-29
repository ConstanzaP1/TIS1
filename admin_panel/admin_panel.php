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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración</title>
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/toastr/build/toastr.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/toastr/build/toastr.min.js"></script>


    <style>
    body {
    display: flex; /* Flexbox para alinear los hijos horizontalmente */
    height: 100vh; /* Ocupa toda la altura de la pantalla */
    margin: 0; /* Eliminar márgenes del body */
}

#sidebar {
    width: 13%; /* Sidebar ocupa el 33% */
    background: #f8f9fa;
    border-right: 1px solid #ddd;
    padding: 10px;
    box-sizing: border-box; /* Incluir padding en el ancho total */
}

#dashboard {
    width: 67%; /* Dashboard ocupa el 67% */
    background: #ffffff;
    padding: 10px;
    box-sizing: border-box; /* Incluir padding en el ancho total */
    overflow-y: auto; /* Habilitar scroll si el contenido supera la altura */
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
    .logo-container {
        display: flex;
        justify-content: flex-start; 
        align-items: center; /* Centrar verticalmente */
        width: 100%; /* Para que ocupe todo el ancho del sidebar */
    }

</style>
</head>

<body>

    <aside id="sidebar">
    <div class="logo-container">
    <a href="../index.php" class="text-left">
        <div class="div text-center">
            <img class="logo img-fluid w-75" src="../logo.jpg" alt="Logo">
        </div>
    </a>
</div>

        <h4>Panel de Administración</h4>
        
        <div class="accordion-item">
    <div class="accordion-header">Hardware</div>
    <div class="accordion-content">
        <ul>
            <!-- Subcategoría: Almacenamiento -->
            <li>
            <a href="#" class="sub-category-header">SSD</a>
                        <ul class="sub-category-content" style="display: none;">
                            <li><a href="../mantenedores_hardware/capacidad_almacenamiento.php">Capacidad Almacenamiento</a></li>
                            <li><a href="../mantenedores_hardware/bus_ssd.php">Bus SSD</a></li>
                            <li><a href="../mantenedores_hardware/formato_ssd.php">Formato SSD</a></li>

                        </ul>
                    </li>
            </li>
            <li>
            <a href="#" class="sub-category-header">HDD</a>
                        <ul class="sub-category-content" style="display: none;">
                            <li><a href="../mantenedores_hardware/capacidad_almacenamiento.php">Capacidad Almacenamiento</a></li>
                            <li><a href="../mantenedores_hardware/bus_hdd.php">Bus HDD</a></li>
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
                    <li><a href="../mantenedores_periferico/tamanio_monitor.php">Tamaño Monitor</a></li>
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
<hr>

<div class="sidebar-container p-3">
<div class="d-flex flex-column gap-2">
    <!-- Botón para redirigir a lista_usuarios.php -->
    <a href="lista_usuarios.php" class="btn lista-usuarios-btn">Lista de Usuarios</a>
    
    <!-- Botón en el sidebar para abrir el modal de registro de usuario -->
    <button type="button" class="btn lista-usuarios-btn" data-bs-toggle="modal" data-bs-target="#registrarUsuarioModal">
        Registrar Usuario
    </button>

    <!-- Nuevo botón para recuperar boletas -->
    <a href="../boleta_cotizacion/recuperar_boletas.php" class="btn lista-usuarios-btn">
        Recuperar Boletas
    </a>

    <!-- Botón para el catálogo de productos -->
    <a href="../index.php" class="btn lista-usuarios-btn">
        Catálogo productos
    </a>
    <!-- Botón para el catálogo de productos -->
    <a href="../postventa/admin_postventa.php" class="btn lista-usuarios-btn">
        Postventa
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
                        <?php
                        // Asumiendo que el rol del usuario actual está almacenado en la sesión
                        session_start();
                        $current_role = $_SESSION['role'] ?? 'user'; // Por defecto 'user' si no está definido

                        // Lógica para mostrar opciones según el rol actual
                        if ($current_role === 'superadmin') {
                            // El superadmin puede asignar tanto 'user' como 'admin'
                            echo '<option value="user">Usuario</option>';
                            echo '<option value="admin">Administrador</option>';
                        } elseif ($current_role === 'admin') {
                            // El admin solo puede asignar el rol de 'user'
                            echo '<option value="user">Usuario</option>';
                        }
                        ?>
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
<div id="app">
    <aside>
        <h2 class="menu-title">Menú</h2>
        <nav>
            <ul class="menu-list">
                <li><a href="#" class="menu-link active" data-target="section-ganancias">Ganancias por Producto</a></li>
                <li><a href="#" class="menu-link" data-target="section-ventas">Ventas Diarias</a></li>
                <li><a href="#" class="menu-link" data-target="section-vendidos">Productos Más Vendidos</a></li>
                <li><a href="#" class="menu-link" data-target="section-stock">Problemas de Stock</a></li>
            </ul>
        </nav>
    </aside>
    <main>
        <header class="dashboard-header">
            <h1>poner otras coas aqui</h1>
        </header>

        <!-- Gráficos -->
        <section id="section-ganancias" class="dashboard-section active">
            <h2>Ganancias por Producto</h2>
            <div class="card">
                <canvas id="gananciasChart"></canvas>
            </div>
        </section>
        <section id="section-ventas" class="dashboard-section">
            <h2>Ventas Diarias</h2>
            <div class="card">
                <canvas id="ventasDiariasChart"></canvas>
            </div>
        </section>
        <section id="section-vendidos" class="dashboard-section">
            <h2>Productos Más Vendidos</h2>
            <div class="card">
                <canvas id="productosMasVendidosChart"></canvas>
            </div>
        </section>
        <section id="section-stock" class="dashboard-section">
            <h2>Problemas de Stock</h2>
            <div class="card">
                <canvas id="problemasStockChart"></canvas>
            </div>
        </section>
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const menuLinks = document.querySelectorAll('.menu-link');
        const sections = document.querySelectorAll('.dashboard-section');

        // Mostrar solo la primera sección
        sections.forEach(section => {
            section.style.display = "none";
        });
        document.getElementById('section-ganancias').style.display = "block" ;

        menuLinks.forEach(link => {
            link.addEventListener('click', (e) => {
                e.preventDefault();

                // Cambiar la clase activa en el menú
                menuLinks.forEach(link => link.classList.remove('active'));
                link.classList.add('active');

                // Ocultar todas las secciones
                sections.forEach(section => {
                    section.style.display = "none";
                });

                // Mostrar la sección correspondiente
                const targetId = link.getAttribute('data-target');
                const targetSection = document.getElementById(targetId);
                if (targetSection) {
                    targetSection.style.display = "block";
                }
            });
        });

        const metrics = ['ganancias_productos', 'ventas_diarias', 'productos_mas_vendidos', 'problemas_stock'];
        metrics.forEach(metric => {
            fetchData(metric).then(data => {
                if (!data || data.error || data.length === 0) {
                    console.warn(`No hay datos para ${metric}.`);
                    return;
                }

                switch (metric) {
                    case 'ganancias_productos':
                        createChart('gananciasChart', 'bar', data.map(item => item.nombre_producto), data.map(item => item.ganancia), 'Ganancias');
                        break;
                    case 'ventas_diarias':
                        createChart('ventasDiariasChart', 'line', data.map(item => item.dia), data.map(item => item.total_ventas), 'Ventas Diarias');
                        break;
                    case 'productos_mas_vendidos':
                        createChart('productosMasVendidosChart', 'bar', data.map(item => item.nombre_producto), data.map(item => item.cantidad_vendida), 'Más Vendidos');
                        break;
                    case 'problemas_stock':
                        createChart('problemasStockChart', 'bar', data.map(item => item.nombre_producto), data.map(item => item.cantidad), 'Problemas de Stock');
                        break;
                }
            });
        });
    });

    async function fetchData(metric) {
        try {
            const response = await fetch(`dashboard_data.php?metric=${metric}`);
            if (!response.ok) throw new Error('Error en la respuesta del servidor');
            return await response.json();
        } catch (error) {
            console.error(`Error al obtener datos para "${metric}":`, error);
            return [];
        }
    }

    function createChart(canvasId, type, labels, data, label) {
        const ctx = document.getElementById(canvasId).getContext('2d');
        new Chart(ctx, {
            type,
            data: {
                labels,
                datasets: [{
                    label,
                    data,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
    }
</script>

<style>
    /* Estilos principales */
    #app {
        display: flex;
        flex-direction: row; /* Alineación horizontal */
        min-height: 100vh;
        font-family: Arial, sans-serif;
    }

    aside {
        width: 20%; /* Por defecto, el sidebar ocupa el 20% */
        background-color: #f4f4f4;
        padding: 20px;
        box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
        overflow-y: auto;
        flex-shrink: 0; /* Evita que el sidebar se reduzca */
    }

    main {
        flex: 1; /* Ocupa el resto del espacio */
        padding: 20px;
    }

    .menu-title {
        font-size: 1.5em;
        margin-bottom: 20px;
        text-align: center;
    }

    .menu-list {
        list-style: none;
        padding: 0;
    }

    .menu-list li {
        margin-bottom: 10px;
    }

    .menu-link {
        text-decoration: none;
        color: #007bff;
        font-weight: bold;
        display: block;
        padding: 10px;
        border-radius: 5px;
        transition: background-color 0.3s ease;
    }

    .menu-link.active {
        background-color: #007bff;
        color: white;
    }

    .dashboard-header {
        background-color: #007BFF;
        color: white;
        text-align: center;
        padding: 20px;
        border-radius: 10px;
        margin-bottom: 20px;
    }

    .dashboard-section {
        display: none;
    }

    .dashboard-section.active {
        display: block;
    }

    .dashboard-section h2 {
        background-color: white;
        color: #333;
        padding: 10px;
        border-radius: 5px;
        margin-bottom: 20px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .card {
        background: white;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        height: 70vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    canvas {
        max-width: 100%;
        height: auto;
    }

    /* Responsividad */
    @media (max-width: 768px) {
        #app {
            flex-direction: column; /* Menú y contenido en columnas */
        }

        aside {
            width: 100%; /* Sidebar ocupa el ancho completo */
            order: 1; /* Sidebar se mueve debajo */
            padding: 10px;
        }

        main {
            width: 100%; /* El contenido principal ocupa el ancho completo */
            order: 2;
            padding: 10px;
        }

        .menu-link {
            font-size: 1em;
            padding: 8px;
        }

        .card {
            height: 50vh; /* Ajustar la altura en pantallas pequeñas */
        }
    }
    #section-ganancias {
    background-color: white; /* Fondo blanco */
}

    @media (max-width: 480px) {
        aside {
            width: 100%; /* Sidebar siempre visible */
        }

        main {
            width: 100%;
        }

        .menu-link {
            font-size: 0.9em;
            padding: 6px;
        }

        .card {
            height: 40vh; /* Más bajo para pantallas pequeñas */
        }
    }
</style>





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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
