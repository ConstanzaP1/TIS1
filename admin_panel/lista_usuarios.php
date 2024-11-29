<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Usuarios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <!-- Navbar y otros contenidos del encabezado -->
    <nav class="navbar navbar-expand-lg bg-body-tertiary w-100">
        <div class="container-fluid">
            <img class="logo img-fluid" src="../logo.jpg" alt="Logo" style="width: 10%;">
            <!-- Otros elementos del navbar -->
        </div>
    </nav>

    <!-- Contenedor principal centrado -->
    <div class="container my-4">
        <div class="usuarios-container">
            <h2 class="text-center mb-4">Lista de Usuarios</h2>

            <!-- Formulario de búsqueda -->
            <form method="GET" action="" class="mb-2 d-flex justify-content-center align-items-center">
                <input type="text" name="search" class="form-control w-50" placeholder="Nombre de Usuario o Correo Electrónico" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
                
                <div class="d-flex ms-2" style="width: 150px;">
                    <button type="submit" class="btn btn-primary w-100">Buscar</button>
                </div>
                
                <div class="d-flex ms-2" style="width: 150px;">
                    <a href="lista_usuarios.php" class="btn btn-secondary w-100">Restablecer</a>
                </div>
                <div class="d-flex ms-2" style="width: 150px;">
                    <a href="historial_compras.php" class="btn btn-secondary w-100">Historial compras</a>
                </div>
                
                <div class="d-flex ms-2" style="width: 150px;">
                    <a href="admin_panel.php" class="btn btn-secondary w-100">Volver al panel</a>
                </div>
                
            </form>

            <!-- Código PHP para obtener usuarios de la base de datos -->
            <?php
            $conexion = new mysqli("localhost", "root", "", "proyecto_tis1");
            if ($conexion->connect_error) {
                die("Error de conexión: " . $conexion->connect_error);
            }

            session_start();
$role = $_SESSION['role'] ?? '';
if ($role !== 'superadmin' && $role !== 'admin') {
    die("Acceso denegado. Solo administradores pueden ver esta página.");
}

if (isset($_POST['user_id']) && isset($_POST['new_role'])) {
    $user_id = intval($_POST['user_id']);
    $new_role = $conexion->real_escape_string($_POST['new_role']);

    // Verificar que el superadmin no pueda crear o asignar el rol de superadmin
    if ($new_role === 'superadmin') {
        echo "<script>
            Swal.fire('Error', 'No tienes permiso para asignar el rol de superadmin.', 'error');
        </script>";
    } 
    // Evitar que el superadmin cambie su propio rol
    elseif ($user_id == $_SESSION['user_id']) {
        echo "<script>
            Swal.fire('Error', 'No puedes cambiar el rol del superadmin principal.', 'error');
        </script>";
    
    } else {
        // Si pasa las verificaciones, actualizar el rol
        $query_update_role = "UPDATE users SET role = ? WHERE id = ?";
        $stmt = $conexion->prepare($query_update_role);
        $stmt->bind_param("si", $new_role, $user_id);

        if ($stmt->execute()) {
            echo "<script>
                    Swal.fire('Rol actualizado', 'El rol del usuario ha sido cambiado exitosamente.', 'success')
                    .then(() => {
                        window.location.href = 'lista_usuarios.php';
                    });
                  </script>";
        } else {
            echo "<script>Swal.fire('Error', 'Error al cambiar el rol del usuario. Inténtalo de nuevo.', 'error');</script>";
        }

        $stmt->close();
    }
}



            $search = isset($_GET['search']) ? $conexion->real_escape_string($_GET['search']) : '';
            $query = "SELECT id, username, email, role, status FROM users";

            if ($search) {
                $query .= " WHERE id LIKE '%$search%' OR username LIKE '%$search%' OR email LIKE '%$search%'";
            }
            $result_users = $conexion->query($query);

            $roles = ['admin' => 'Administrador', 'user' => 'Usuario estándar', 'superadmin' => 'Superadministrador'];
            ?>

            <!-- Tabla de usuarios -->
            <table class="table table-bordered">
    <thead>
        <tr>
            <th>Nombre de Usuario</th>
            <th>Correo Electrónico</th>
            <th>Rol</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $result_users->fetch_assoc()): ?>
        <tr>

            <td><?php echo $row['username']; ?></td>
            <td><?php echo $row['email']; ?></td>
            <td><?php echo $roles[$row['role']]; ?></td>
            <td>
                <!-- Formulario para cambiar rol solo visible para superadmin -->
                <?php if ($role === 'superadmin'): ?>
                <form method="POST" action="" class="d-inline change-role-form">
                    <input type="hidden" name="user_id" value="<?php echo $row['id']; ?>">
                    <input type="hidden" name="current_role" value="<?php echo $row['role']; ?>">
                    <select name="new_role" class="form-select form-select-sm d-inline w-auto">
                        <?php foreach ($roles as $role_key => $role_name): ?>
                            <?php if ($role_key !== 'superadmin'): // Excluir superadmin del select ?>
                                <option value="<?php echo $role_key; ?>" <?php if ($role_key == $row['role']) echo 'selected'; ?>>
                                    <?php echo $role_name; ?>
                                </option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                    <button type="button" class="btn btn-warning btn-sm btn-change-role">Cambiar</button>
                </form>
                <?php endif; ?>

                <!-- Botones adicionales -->
                <a href="EN_PROCESO.php?user_id=<?php echo $row['id']; ?>" class="btn btn-info btn-sm">Lista de deseo</a>
                <a href="historial_compras.php?user_id=<?php echo $row['id']; ?>" class="btn btn-info btn-sm">Historial de compras</a>
                <?php if ($row['status'] === 'activo'): ?>
                    <!-- Botón para inhabilitar -->
                    <form method="POST" action="inhabilitar_usuario.php" class="d-inline">
                        <input type="hidden" name="user_id" value="<?php echo $row['id']; ?>">
                        <input type="hidden" name="action" value="inhabilitar">
                        <button type="button" class="btn btn-danger btn-sm btn-inhabilitar">Inhabilitar</button>
                    </form>
                <?php else: ?>
                    <!-- Botón para habilitar -->
                    <form method="POST" action="inhabilitar_usuario.php" class="d-inline">
                        <input type="hidden" name="user_id" value="<?php echo $row['id']; ?>">
                        <input type="hidden" name="action" value="habilitar">
                        <button type="submit" class="btn btn-success btn-sm">Habilitar</button>
                    </form>
                <?php endif; ?>
            </td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>

        </div>
    </div>

    <script>
        // SweetAlert2 para confirmar cambio de rol
        document.querySelectorAll('.btn-change-role').forEach(button => {
            button.addEventListener('click', function () {
                const form = this.closest('.change-role-form');
                const currentRole = form.querySelector('input[name="current_role"]').value;
                const newRole = form.querySelector('select[name="new_role"]').value;
                
                if (currentRole === newRole) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'El rol seleccionado es el mismo que el rol actual. Por favor, elige un rol diferente.',
                        confirmButtonText: 'Aceptar'
                    });
                } else {
                    Swal.fire({
                        title: '¿Estás seguro?',
                        text: '¿Quieres cambiar el rol de este usuario?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Sí, cambiar',
                        cancelButtonText: 'Cancelar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                }
            });
        });
        // SweetAlert2 para confirmar inhabilitación de usuario
        document.querySelectorAll('.btn-inhabilitar').forEach(button => {
    button.addEventListener('click', function () {
        const form = this.closest('form');

        Swal.fire({
            title: 'Inhabilitar cuenta',
            input: 'textarea',
            inputLabel: 'Razón para inhabilitar la cuenta:',
            inputPlaceholder: 'Escribe las razones aquí...',
            inputAttributes: {
                'aria-label': 'Escribe las razones aquí'
            },
            showCancelButton: true,
            confirmButtonText: 'Inhabilitar',
            cancelButtonText: 'Cancelar',
            inputValidator: (value) => {
                if (!value) {
                    return 'Debes escribir una razón para continuar';
                }
            }
        }).then((result) => {
            if (result.isConfirmed) {
                const reasonInput = document.createElement('input');
                reasonInput.type = 'hidden';
                reasonInput.name = 'reason';
                reasonInput.value = result.value;

                form.appendChild(reasonInput);
                form.submit();
            }
        });
    });
});
    </script>
    

    <style>
        .usuarios-container {
            max-height: 70vh;
            overflow-y: auto;
            border: 1px solid #ccc;
            padding: 10px;
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
