<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Usuarios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<nav class="navbar navbar-expand-lg bg-body-tertiary w-100 m-0">
    <div class="container-fluid">
        <img class="logo img-fluid" src="../logo.jpg" alt="Logo" style="width: 50px;">
        <!-- Otros elementos del navbar -->
    </div>
</nav>

<body class="container my-4">
    
    <!-- Botón de Volver al panel de administración -->
    <div class="mb-4">
        <a href="admin_panel.php" class="btn btn-secondary">Volver al Panel de Administración</a>
    </div>
    <div class="usuarios-container">
        <h2 class="text-center mb-4">Lista de Usuarios</h2>

        <!-- Formulario de búsqueda -->
        <form method="GET" action="" class="mb-4 d-flex justify-content-center">
            <input type="text" name="search" class="form-control w-50" placeholder="Buscar por ID, Nombre de Usuario o Correo Electrónico" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
            <button type="submit" class="btn btn-primary ms-2">Buscar</button>
            <a href="lista_usuarios.php" class="btn btn-secondary ms-2">Restablecer</a>
        </form>

        <?php
        // Conexión a la base de datos
        $conexion = new mysqli("localhost", "root", "", "proyecto_tis1");
        if ($conexion->connect_error) {
            die("Error de conexión: " . $conexion->connect_error);
        }

        // Verificar si se ha solicitado cambiar el rol de un usuario
        if (isset($_POST['user_id']) && isset($_POST['new_role'])) {
            $user_id = intval($_POST['user_id']);
            $new_role = $conexion->real_escape_string($_POST['new_role']);

            // Cambiar el rol del usuario en la tabla users
            $query_update_role = "UPDATE users SET role = ? WHERE id = ?";
            $stmt = $conexion->prepare($query_update_role);
            $stmt->bind_param("si", $new_role, $user_id);

            if ($stmt->execute()) {
                echo "<script>alert('El rol del usuario ha sido cambiado exitosamente.'); window.location.href='lista_usuarios.php';</script>";
            } else {
                echo "<script>alert('Error al cambiar el rol del usuario. Inténtalo de nuevo.');</script>";
            }

            $stmt->close();
        }

        // Consulta SQL para buscar usuarios por ID, Nombre o Correo
        $search = isset($_GET['search']) ? $conexion->real_escape_string($_GET['search']) : '';
        $query = "SELECT id, username, email, role FROM users";
        if ($search) {
            $query .= " WHERE id LIKE '%$search%' OR username LIKE '%$search%' OR email LIKE '%$search%'";
        }
        $result_users = $conexion->query($query);

        // Roles disponibles (por ejemplo, 'admin' y 'user')
        $roles = ['admin' => 'Administrador', 'user' => 'Usuario estándar'];
        ?>

        <!-- Tabla de usuarios -->
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
                <?php while ($row = $result_users->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['username']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td><?php echo $roles[$row['role']]; ?></td>
                    <td>
                        <!-- Formulario para cambiar rol -->
                        <form method="POST" action="" class="d-inline">
                            <input type="hidden" name="user_id" value="<?php echo $row['id']; ?>">
                            <select name="new_role" class="form-select form-select-sm d-inline w-auto">
                                <?php foreach ($roles as $role_key => $role_name): ?>
                                    <option value="<?php echo $role_key; ?>" <?php if ($role_key == $row['role']) echo 'selected'; ?>>
                                        <?php echo $role_name; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <button type="submit" class="btn btn-warning btn-sm">Cambiar</button>
                        </form>
                        <!-- Botones adicionales -->
                        <a href="EN_PROCESO.php?user_id=<?php echo $row['id']; ?>" class="btn btn-info btn-sm">Lista de deseo</a>
                        <a href="EN_PROCESO.php?user_id=<?php echo $row['id']; ?>" class="btn btn-info btn-sm">Historial de compras</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <style>
        .usuarios-container {
            max-height: 70vh; /* Ajuste opcional para la altura máxima */
            overflow-y: auto; /* Habilitar scroll vertical */
            border: 1px solid #ccc; /* Opcional: borde para el contenedor */
            padding: 10px; /* Espaciado interno */
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
