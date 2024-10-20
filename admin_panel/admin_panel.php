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
    <style>
        body {
            display: flex;
            height: 100vh;
            margin: 0;
        }
        #sidebar {
            width: 250px;
            background: #f8f9fa;
            border-right: 1px solid #ddd;
            padding: 10px;
        }
        #content {
            flex: 1;
            padding: 20px;
            overflow-y: auto; /* Para permitir desplazamiento si hay mucho contenido */
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
            margin-bottom: 20px; /* Añadir margen inferior para separación */
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
        <h2>Tisnology</h2>
        <div class="accordion">
            <div class="accordion-item">
                <div class="accordion-header">Tarjetas de video</div>
                <div class="accordion-content">
                    <ul>
                        <li><a href="../mantenedores_hardware/memoria_gpu.php">Memoria</a></li>
                        <li><a href="../mantenedores_hardware/frecuencia_gpu.php">Frecuencia</a></li>
                    </ul>
                </div>
            </div>
            <div class="accordion-item">
                <div class="accordion-header">Procesador</div>
                <div class="accordion-content">
                    <ul>
                        <li><a href="../mantenedores_hardware/frecuencia_cpu.php">Frecuencia</a></li>
                        <li><a href="../mantenedores_hardware/nucleo_hilo_cpu.php">Nucleo / Hilo</a></li>
                        <li><a href="../mantenedores_hardware/socket_cpu.php">Socket</a></li>
                    </ul>
                </div>
            </div>
            <div class="accordion-item">
                <div class="accordion-header">Placa madre</div>
                <div class="accordion-content">
                    <ul>
                        <li><a href="../mantenedores_hardware/socket_placa.php">Socket</a></li>
                        <li><a href="../mantenedores_hardware/slot_memoria_placa.php">Slot memoria</a></li>
                        <li><a href="../mantenedores_hardware/formato_placa.php">Formato</a></li>
                        <li><a href="../mantenedores_hardware/tamanio_placa.php">Tamaño</a></li>
                    </ul>
                </div>
            </div>
            <div class="accordion-item">
                <div class="accordion-header">Memoria RAM</div>
                <div class="accordion-content">
                    <ul>
                        <li><a href="../mantenedores_hardware/formato_ram.php">Formato</a></li>
                        <li><a href="../mantenedores_hardware/velocidad_ram.php">Velocidad</a></li>
                        <li><a href="../mantenedores_hardware/capacidad_ram.php">Capacidad</a></li>
                    </ul>
                </div>
            </div>
            <div class="accordion-item">
                <div class="accordion-header">Almacenamiento</div>
                <div class="accordion-content">
                    <ul>
                        <li><a href="../mantenedores_hardware/tamanio_hdd.php">Tamaño HDD</a></li>
                        <li><a href="../mantenedores_hardware/tamanio_ssd.php">Tamaño SSD</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="logout">
            <a href="?logout=true" class="btn btn-danger">Cerrar sesión</a> <!-- Botón de cerrar sesión -->
        </div>
    </aside>

    <div id="content">
        <h1>Panel de Administración - Usuarios</h1>

        <?php if ($message): ?>
            <div class="alert alert-success message"><?php echo $message; ?></div>
        <?php endif; ?>
        <?php if ($error_message): ?>
            <div class="alert alert-danger message"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <div class="registro">
            <h2>Registrar Usuario</h2>
            <form action="" method="post">
                <input type="text" name="username" placeholder="Nombre de usuario" required>
                <input type="email" name="email" placeholder="Correo electrónico" required>
                <input type="password" name="password" placeholder="Contraseña" required>
                <select name="role" required>
                    <option value="admin">Administrador</option>
                    <option value="user">Usuario</option>
                </select>
                <button type="submit" class="btn btn-success">Registrar</button> <!-- Estilo uniforme -->
            </form>
        </div>

        <h2>Lista de Usuarios</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre de Usuario</th>
                    <th>Correo Electrónico</th>
                    <th>Rol</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($user = mysqli_fetch_assoc($result_users)): ?>
                    <tr>
                        <td><?php echo $user['id']; ?></td>
                        <td><?php echo $user['username']; ?></td>
                        <td><?php echo $user['email']; ?></td>
                        <td><?php echo $user['role']; ?></td>
                        <td>
                            <!-- Cambiar a un botón que activa el modal -->
                            <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editUserModal<?php echo $user['id']; ?>">
                                Modificar
                            </button>
                            |
                            <a href="admin_panel.php?delete=<?php echo $user['id']; ?>" onclick="return confirm('¿Estás seguro de que quieres eliminar este usuario?');" class="btn btn-danger">Eliminar</a>
                        </td>
                    </tr>
                    
                    <!-- Modal para editar usuario -->
                    <div class="modal fade" id="editUserModal<?php echo $user['id']; ?>" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg"> <!-- Cambiar aquí a modal-lg para un modal más grande -->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editUserModalLabel">Modificar Usuario</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="" method="post">
                                        <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                                        <div class="row mb-3">
                                            <div class="col">
                                                <input type="text" name="username" class="form-control" placeholder="Nombre de usuario" value="<?php echo $user['username']; ?>" required>
                                            </div>
                                            <div class="col">
                                                <input type="email" name="email" class="form-control" placeholder="Correo electrónico" value="<?php echo $user['email']; ?>" required>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col">
                                                <select name="role" class="form-select" required>
                                                    <option value="admin" <?php echo ($user['role'] == 'admin') ? 'selected' : ''; ?>>Administrador</option>
                                                    <option value="user" <?php echo ($user['role'] == 'user') ? 'selected' : ''; ?>>Usuario</option>
                                                </select>
                                            </div>
                                            <div class="col-auto">
                                                <button type="submit" name="update" class="btn btn-primary">Modificar</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>


                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <script>
        $(document).ready(function() {
            $('.accordion-header').on('click', function() {
                $(this).toggleClass('active');
                $(this).next('.accordion-content').slideToggle();
            });
        });
    </script>

    <!-- Agregar el JS de Bootstrap para manejar los modales -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-..." crossorigin="anonymous"></script>
</body>
</html>
