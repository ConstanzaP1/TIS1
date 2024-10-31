<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Usuarios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
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
                <?php
                // Conexión a la base de datos
                $conexion = new mysqli("localhost", "root", "", "proyecto_tis1");
                if ($conexion->connect_error) {
                    die("Error de conexión: " . $conexion->connect_error);
                }

                // Consulta SQL para buscar usuarios por ID, Nombre o Correo
                $search = isset($_GET['search']) ? $conexion->real_escape_string($_GET['search']) : '';
                $query = "SELECT * FROM users";
                if ($search) {
                    $query .= " WHERE id LIKE '%$search%' OR username LIKE '%$search%' OR email LIKE '%$search%'";
                }
                $result_users = $conexion->query($query);

                // Mostrar todos los usuarios encontrados
                while ($row = $result_users->fetch_assoc()):
                ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['username']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td><?php echo $row['role']; ?></td>
                    <td>
                            <!-- Botón para ver la lista de deseos del usuario -->
                        <a href="EN_PROCESO.php?user_id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm" disabled >Lista de deseo</a>
                            <!-- Botón para ver el historial de compras del usuario -->
                        <a href="EN_PROCESO.php?user_id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm" disabled>Historial de compras</a>

                        <a href="?delete=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de que deseas eliminar este usuario?');">Eliminar</a>
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
