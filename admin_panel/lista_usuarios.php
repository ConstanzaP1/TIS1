<?php
require_once '../conexion.php'; // Incluye el archivo de conexión.

session_start();
$role = $_SESSION['role'] ?? '';
if ($role !== 'superadmin' && $role !== 'admin') {
    die("Acceso denegado. Solo administradores pueden ver esta página.");
}

$search = isset($_GET['search']) ? $conexion->real_escape_string($_GET['search']) : '';
$query = "SELECT id, username, email, role, status FROM users";

if ($search) {
    $query .= " WHERE username LIKE '%$search%' OR email LIKE '%$search%'";
}

$result_users = $conexion->query($query);

if (!$result_users) {
    die("Error en la consulta: " . $conexion->error);
}

$roles = ['admin' => 'Administrador', 'user' => 'Usuario estándar', 'superadmin' => 'Superadministrador'];
?>
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
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container-fluid">
            <a class="navbar-brand" href="admin_panel.php">
                <img src="../logoblanco.png" alt="Logo" style="width: auto; height: auto;" class="d-inline-block align-text-top">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="admin_panel.php">Volver al Panel</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Contenedor Principal -->
    <div class="container">
        <div class="usuarios-container bg-light p-4 rounded shadow">
            <h2 class="text-center mb-4">Lista de Usuarios</h2>

            <!-- Formulario de Búsqueda -->
            <form method="GET" action="" class="mb-3">
                <div class="row g-2 align-items-center">
                    <div class="col-lg-6 col-md-8 col-12">
                        <input type="text" name="search" class="form-control" placeholder="Buscar por nombre o correo" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
                    </div>
                    <div class="col-lg-2 col-md-4 col-6">
                        <button type="submit" class="btn btn-primary w-100">Buscar</button>
                    </div>
                    <div class="col-lg-2 col-md-4 col-6">
                        <a href="lista_usuarios.php" class="btn btn-secondary w-100">Restablecer</a>
                    </div>
                    <div class="col-lg-2 col-md-4 col-6">
                        <a href="historial_compras.php" class="btn btn-secondary w-100">Historial</a>
                    </div>
                </div>
            </form>
            <!--tabla -->
            <div class="table-responsive">
                <table class="table table-striped table-hover table-bordered">
                    <thead class="table-dark">
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
                                <!-- Para pantallas grandes (horizontal) -->
                                <div class="d-none d-lg-flex justify-content-start align-items-center gap-2">
                                    <!-- Cambiar Rol -->
                                    <?php if ($role === 'superadmin'): ?>
                                    <form method="POST" action="" class="d-inline-block">
                                        <input type="hidden" name="user_id" value="<?php echo $row['id']; ?>">
                                        <div class="input-group">
                                            <select name="new_role" class="form-select form-select-sm">
                                                <?php foreach ($roles as $role_key => $role_name): ?>
                                                    <?php if ($role_key !== 'superadmin'): ?>
                                                        <option value="<?php echo $role_key; ?>" <?php if ($role_key == $row['role']) echo 'selected'; ?>>
                                                            <?php echo $role_name; ?>
                                                        </option>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            </select>
                                            <button type="submit" class="btn btn-warning btn-sm ms-1">Cambiar</button>
                                        </div>
                                    </form>
                                    <?php endif; ?>

                                    <!-- Botones de acciones -->
                                    <a href="EN_PROCESO.php?user_id=<?php echo $row['id']; ?>" class="btn btn-info btn-sm">Lista de deseos</a>
                                    <a href="historial_compras.php?user_id=<?php echo $row['id']; ?>" class="btn btn-info btn-sm">Historial</a>
                                    <?php if ($row['status'] === 'activo'): ?>
                                        <form method="POST" action="inhabilitar_usuario.php" class="d-inline-block">
                                            <input type="hidden" name="user_id" value="<?php echo $row['id']; ?>">
                                            <input type="hidden" name="action" value="inhabilitar">
                                            <button type="submit" class="btn btn-danger btn-sm">Inhabilitar</button>
                                        </form>
                                    <?php else: ?>
                                        <form method="POST" action="inhabilitar_usuario.php" class="d-inline-block">
                                            <input type="hidden" name="user_id" value="<?php echo $row['id']; ?>">
                                            <input type="hidden" name="action" value="habilitar">
                                            <button type="submit" class="btn btn-success btn-sm">Habilitar</button>
                                        </form>
                                    <?php endif; ?>
                                </div>

                                <!-- Para pantallas medianas (dos filas) -->
                                <div class="d-none d-md-flex d-lg-none flex-wrap justify-content-start gap-2 mt-2">
                                    <!-- Cambiar Rol -->
                                    <?php if ($role === 'superadmin'): ?>
                                    <form method="POST" action="" class="w-100">
                                        <input type="hidden" name="user_id" value="<?php echo $row['id']; ?>">
                                        <div class="input-group">
                                            <select name="new_role" class="form-select form-select-sm w-100">
                                                <?php foreach ($roles as $role_key => $role_name): ?>
                                                    <?php if ($role_key !== 'superadmin'): ?>
                                                        <option value="<?php echo $role_key; ?>" <?php if ($role_key == $row['role']) echo 'selected'; ?>>
                                                            <?php echo $role_name; ?>
                                                        </option>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            </select>
                                            <button type="submit" class="btn btn-warning btn-sm mt-1 w-100 ">Cambiar</button>
                                        </div>
                                    </form>
                                    <?php endif; ?>

                                    <!-- Botones de acciones -->
                                    <a href="EN_PROCESO.php?user_id=<?php echo $row['id']; ?>" class="btn btn-info btn-sm h-100 w-100">Lista deseos</a>
                                    <a href="historial_compras.php?user_id=<?php echo $row['id']; ?>" class="btn btn-info btn-sm h-100 w-100">Historial</a>
                                    <?php if ($row['status'] === 'activo'): ?>
                                        <form method="POST" action="inhabilitar_usuario.php" class="w-100">
                                            <input type="hidden" name="user_id" value="<?php echo $row['id']; ?>">
                                            <input type="hidden" name="action" value="inhabilitar">
                                            <button type="submit" class="btn btn-danger btn-sm h-100 w-100">Inhabilitar</button>
                                        </form>
                                    <?php else: ?>
                                        <form method="POST" action="inhabilitar_usuario.php" class="w-50">
                                            <input type="hidden" name="user_id" value="<?php echo $row['id']; ?>">
                                            <input type="hidden" name="action" value="habilitar">
                                            <button type="submit" class="btn btn-success btn-sm h-100 w-100">Habilitar</button>
                                        </form>
                                    <?php endif; ?>
                                </div>

                                <!-- Para pantallas pequeñas (vertical/apilado) -->
                                <div class="d-flex d-md-none flex-column gap-2 mt-2">
                                    <!-- Cambiar Rol -->
                                    <?php if ($role === 'superadmin'): ?>
                                    <form method="POST" action="" class="w-100">
                                        <input type="hidden" name="user_id" value="<?php echo $row['id']; ?>">
                                        <div class="input-group">
                                            <select name="new_role" class="form-select form-select-sm">
                                                <?php foreach ($roles as $role_key => $role_name): ?>
                                                    <?php if ($role_key !== 'superadmin'): ?>
                                                        <option value="<?php echo $role_key; ?>" <?php if ($role_key == $row['role']) echo 'selected'; ?>>
                                                            <?php echo $role_name; ?>
                                                        </option>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            </select>
                                            <button type="submit" class="btn btn-warning btn-sm w-100 mt-1">Cambiar</button>
                                        </div>
                                    </form>
                                    <?php endif; ?>

                                    <!-- Botones de acciones -->
                                    <a href="EN_PROCESO.php?user_id=<?php echo $row['id']; ?>" class="btn btn-info btn-sm w-100">Lista de deseos</a>
                                    <a href="historial_compras.php?user_id=<?php echo $row['id']; ?>" class="btn btn-info btn-sm w-100">Historial</a>
                                    <?php if ($row['status'] === 'activo'): ?>
                                        <form method="POST" action="inhabilitar_usuario.php" class="w-100">
                                            <input type="hidden" name="user_id" value="<?php echo $row['id']; ?>">
                                            <input type="hidden" name="action" value="inhabilitar">
                                            <button type="submit" class="btn btn-danger btn-sm w-100">Inhabilitar</button>
                                        </form>
                                    <?php else: ?>
                                        <form method="POST" action="inhabilitar_usuario.php" class="w-100">
                                            <input type="hidden" name="user_id" value="<?php echo $row['id']; ?>">
                                            <input type="hidden" name="action" value="habilitar">
                                            <button type="submit" class="btn btn-success btn-sm w-100">Habilitar</button>
                                        </form>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
