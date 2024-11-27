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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            margin: 0;
            display: flex;
            min-height: 100vh;
            overflow: hidden;
        }

        .sidebar {
            width: 30%;
            background-color: #343a40;
            color: white;
            flex-shrink: 0;
            display: flex;
            flex-direction: column;
            height: 100vh;
            overflow-y: auto;
        }

        .sidebar h4 {
            text-align: center;
            margin: 20px 0;
            font-size: 1.5rem;
            font-weight: bold;
        }

        .sidebar a {
            text-decoration: none;
            color: white;
            padding: 10px 20px;
            display: block;
            transition: all 0.3s ease;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background-color: #495057;
            border-radius: 5px;
        }

        .accordion-button {
            background-color: #495057 !important;
            color: white !important;
            border: none;
            font-weight: bold;
        }

        .accordion-button:not(.collapsed) {
            background-color: #6c757d !important;
            color: white !important;
        }

        .accordion-item {
            border: none;
        }

        .accordion-body {
            background-color: #495057;
            color: white;
            padding-left: 20px;
        }

        .sub-category-content a {
            color: #adb5bd;
            font-size: 0.9rem;
        }

        .sub-category-content a:hover {
            color: #f8f9fa;
        }

        .logout-btn {
            margin-top: auto;
            margin-bottom: 20px;
            padding: 10px 20px;
            background-color: #dc3545;
            border: none;
            color: white;
            border-radius: 5px;
            text-align: center;
            transition: background-color 0.3s ease;
            width: 90%;
            margin-left: auto;
            margin-right: auto;
        }

        .logout-btn:hover {
            background-color: #b02a37;
        }
    </style>
</head>

<body>
<div class="container-fluid">
<div class="row">
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="text-center">
                <a href="../admin_panel/admin_panel.php">
                    <img class="logo img-fluid w-75 rounded-pill" src="../logopng.png" alt="Logo">
                </a>
        </div>
        <h4>Panel de Administración</h4>

        <!-- Acordeón -->
        <div class="accordion" id="sidebarAccordion">
            <!-- Hardware -->
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#hardware" aria-expanded="false">
                        Hardware
                    </button>
                </h2>
                <div id="hardware" class="accordion-collapse collapse" data-bs-parent="#sidebarAccordion">
                    <div class="accordion-body">
                        <ul class="list-unstyled">
                            <li>
                                <a href="#">SSD</a>
                                <ul class="sub-category-content">
                                    <li><a href="../mantenedores_hardware/capacidad_almacenamiento.php">Capacidad Almacenamiento</a></li>
                                    <li><a href="../mantenedores_hardware/bus_ssd.php">Bus SSD</a></li>
                                    <li><a href="../mantenedores_hardware/formato_ssd.php">Formato SSD</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="#">HDD</a>
                                <ul class="sub-category-content">
                                    <li><a href="../mantenedores_hardware/capacidad_almacenamiento.php">Capacidad Almacenamiento</a></li>
                                    <li><a href="../mantenedores_hardware/bus_hdd.php">Bus HDD</a></li>
                                    <li><a href="../mantenedores_hardware/rpm_hdd.php">RPM HDD</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Periféricos -->
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#perifericos" aria-expanded="false">
                        Periféricos
                    </button>
                </h2>
                <div id="perifericos" class="accordion-collapse collapse" data-bs-parent="#sidebarAccordion">
                    <div class="accordion-body">
                        <ul class="list-unstyled">
                            <li>
                                <a href="#">Monitores</a>
                                <ul class="sub-category-content">
                                    <li><a href="../mantenedores_periferico/resolucion_monitor.php">Resolución Monitor</a></li>
                                    <li><a href="../mantenedores_periferico/tamanio_monitor.php">Tamaño Monitor</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="#">Teclados</a>
                                <ul class="sub-category-content">
                                    <li><a href="../mantenedores_periferico/tipo_teclado.php">Tipo Teclado</a></li>
                                    <li><a href="../mantenedores_periferico/tipo_switch.php">Tipo Switch</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Notebook -->
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#notebook" aria-expanded="false">
                        Notebook
                    </button>
                </h2>
                <div id="notebook" class="accordion-collapse collapse" data-bs-parent="#sidebarAccordion">
                    <div class="accordion-body">
                        <ul class="list-unstyled">
                            <li><a href="../mantenedores_notebook/bateria_notebook.php">Batería</a></li>
                            <li><a href="../mantenedores_notebook/cpu_notebook.php">Procesador</a></li>
                            <li><a href="../mantenedores_notebook/gpu_notebook.php">Tarjeta de Video</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Marcas -->
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#marcas" aria-expanded="false">
                        Marcas
                    </button>
                </h2>
                <div id="marcas" class="accordion-collapse collapse" data-bs-parent="#sidebarAccordion">
                    <div class="accordion-body">
                        <ul class="list-unstyled">
                            <li><a href="../mantenedores_marcas/nombres_marcas.php">Agregar Marcas</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- Gestionar Categorías -->
            <div class="custom-link">
                <a href="../creacion_productos/categorias.php" class="text-decoration-none d-block text-white fw-bold px-3 py-2">
                    Gestionar Categorías
                </a>
            </div>

            <!-- Submenús sueltos -->
            <div class="custom-link">
                <a href="lista_usuarios.php" class="text-decoration-none d-block text-white fw-bold px-3 py-2">
                    Lista de Usuarios
                </a>
            </div>
            <div class="custom-link">
                <button type="button" class="btn text-decoration-none d-block text-white fw-bold px-3 py-2 w-100"
                    style="background: none; border: none; text-align: left;" data-bs-toggle="modal" data-bs-target="#registrarUsuarioModal">
                    Registrar Usuario
                </button>
            </div>
            <div class="custom-link">
                <a href="../boleta_cotizacion/recuperar_boletas.php" class="text-decoration-none d-block text-white fw-bold px-3 py-2">
                    Recuperar Boletas
                </a>
            </div>
            <div class="custom-link">
                <a href="../index.php" class="text-decoration-none d-block text-white fw-bold px-3 py-2">
                    Catálogo productos
                </a>
            </div>

            <!-- Estilos -->
            <style>
                .custom-link {
                    background-color: #495057;
                    /* Fondo uniforme */
                    border-bottom: 1px solid #343a40;
                    /* Línea divisoria */
                }

                .custom-link:last-child {
                    border-bottom: none;
                    /* Sin línea divisoria en el último elemento */
                }

                .custom-link:hover {
                    background-color: #6c757d;
                    /* Fondo al pasar el mouse */
                    text-decoration: none;
                    /* Sin subrayado */
                }

                .btn {
                    padding: 0;
                    /* Ajustar el padding del botón */
                }
            </style>



        </div>

        <!-- Cerrar Sesión -->
        <button class="logout-btn">Cerrar Sesión</button>
    </div>
</div>
</div>
</body>

</html>




<style>
    .sub-category-header {
        cursor: pointer;
        font-weight: bold;
    }

    .sub-category-content {
        padding-left: 20px;
        /* Indentación para la subcategoría */
    }
</style>
<script>
    document.querySelectorAll('.sub-category-header').forEach(header => {
        header.addEventListener('click', function() {
            const subCategory = this.nextElementSibling;
            subCategory.style.display = subCategory.style.display === 'none' ? 'block' : 'none';
        });
    });
</script>
<hr>


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



        </div>
    </aside>
    
<div id="app" class="container mt-4">
    <header class="dashboard-header text-center mb-4">
        <h1>Dashboard</h1>
    </header>

    <div class="row g-4">
        <!-- Ganancias por Producto -->
        <div class="col-md-6">
            <div class="card p-3">
                <h2 class="text-center">Ganancias por Producto</h2>
                <canvas class="w-100" style="height:auto;" id="gananciasChart"></canvas>
            </div>
        </div>

        <!-- Ventas Diarias -->
        <div class="col-md-6">
            <div class="card p-3">
                <h2 class="text-center">Ventas Diarias</h2>
                <canvas class="w-100" style="height:auto;" id="ventasDiariasChart"></canvas>
            </div>
        </div>

        <!-- Productos Más Vendidos -->
        <div class="col-md-6">
            <div class="card p-3">
                <h2 class="text-center">Productos Más Vendidos</h2>
                <canvas class="w-100" style="height:auto;" id="productosMasVendidosChart"></canvas>
            </div>
        </div>

        <!-- Problemas de Stock -->
        <div class="col-md-6">
            <div class="card p-3">
                <h2 class="text-center">Problemas de Stock</h2>
                <canvas class="w-100" style="height:auto;" id="problemasStockChart"></canvas>
            </div>
        </div>
    </div>
</div>




<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const ctxGanancias = document.getElementById('gananciasChart').getContext('2d');
        const ctxVentas = document.getElementById('ventasDiariasChart').getContext('2d');
        const ctxVendidos = document.getElementById('productosMasVendidosChart').getContext('2d');
        const ctxStock = document.getElementById('problemasStockChart').getContext('2d');

        // Gráfico de Ganancias
        new Chart(ctxGanancias, {
            type: 'bar',
            data: {
                labels: ['Producto 1', 'Producto 2', 'Producto 3'],
                datasets: [{
                    label: 'Ganancias',
                    data: [1200, 1900, 3000],
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });

        // Gráfico de Ventas Diarias
        new Chart(ctxVentas, {
            type: 'line',
            data: {
                labels: ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes'],
                datasets: [{
                    label: 'Ventas Diarias',
                    data: [120, 150, 180, 200, 170],
                    borderColor: 'rgba(54, 162, 235, 1)',
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });

        // Gráfico de Productos Más Vendidos
        new Chart(ctxVendidos, {
            type: 'pie',
            data: {
                labels: ['Producto A', 'Producto B', 'Producto C'],
                datasets: [{
                    label: 'Productos Más Vendidos',
                    data: [30, 50, 20],
                    backgroundColor: ['rgba(255, 99, 132, 0.2)', 'rgba(54, 162, 235, 0.2)', 'rgba(255, 206, 86, 0.2)'],
                    borderColor: ['rgba(255, 99, 132, 1)', 'rgba(54, 162, 235, 1)', 'rgba(255, 206, 86, 1)'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });

        // Gráfico de Problemas de Stock
        new Chart(ctxStock, {
            type: 'doughnut',
            data: {
                labels: ['Producto X', 'Producto Y', 'Producto Z'],
                datasets: [{
                    label: 'Problemas de Stock',
                    data: [5, 10, 3],
                    backgroundColor: ['rgba(153, 102, 255, 0.2)', 'rgba(255, 159, 64, 0.2)', 'rgba(75, 192, 192, 0.2)'],
                    borderColor: ['rgba(153, 102, 255, 1)', 'rgba(255, 159, 64, 1)', 'rgba(75, 192, 192, 1)'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    });
</script>

<style>
    /* Estilos principales */
    #app {
        display: flex;
        flex-direction: row;
        /* Alineación horizontal */
        min-height: 100vh;
        font-family: Arial, sans-serif;
    }

    aside {
        width: 20%;
        /* Por defecto, el sidebar ocupa el 20% */
        background-color: #f4f4f4;
        padding: 20px;
        box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
        overflow-y: auto;
        flex-shrink: 0;
        /* Evita que el sidebar se reduzca */
    }

    main {
    padding: 20px;
}

.dashboard-header {
    text-align: center;
    margin-bottom: 20px;
}

.dashboard-section {
    margin-bottom: 30px;
    text-align: center;
}

canvas {
    width: 100% !important;
    height: auto !important;
    max-height: 400px;
}
.card {
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    border-radius: 10px;
}
</style>





<style>
    .registro {
        max-height: 55vh;
        /* Ajustar la altura máxima */
        overflow-y: auto;
        /* Habilitar scroll vertical */
        padding: 5px;
        /* Espaciado interno */
        border: 1px solid #ccc;
        /* Borde para el contenedor */
        background-color: #f9f9f9;
        /* Color de fondo */
        box-sizing: border-box;
        /* Incluir padding y borde en el tamaño total */
    }

    .mb-3 {
        margin-bottom: 1px;
        /* Espacio entre los elementos */
    }

    .form-control,
    .form-select {
        width: 100%;
        /* Hacer los campos de formulario ocupar el ancho completo */
    }

    .message {
        margin-top: 1px;
        /* Espacio superior para el mensaje */
    }

    /* Limitar la altura del contenedor de mensajes */
    .message .alert {
        max-height: 50px;
        /* Altura máxima para los mensajes */
        overflow: hidden;
        /* Ocultar contenido que se salga */
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