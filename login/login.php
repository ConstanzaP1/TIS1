<?php
session_start();
include('../conexion.php'); // Asegúrate de incluir tu archivo de conexión a la base de datos

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Consulta a la base de datos
    $query = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($conexion, $query);

    if ($result) {
        $user = mysqli_fetch_assoc($result);

        // Verificar si el usuario existe y la contraseña coincide
        if ($user && password_verify($password, $user['password'])) { // Cambiado a password_verify
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];

            // Redirigir según el rol del usuario
            if ($user['role'] == 'admin') {
                header('Location: ../admin_panel/admin_panel.php');
            } else {
                header('Location: ../login/user_panel.php');
            }
            exit();
        } else {
            $error_message = 'Usuario o contraseña incorrectos.'; // Mensaje de error
        }
    } else {
        $error_message = 'Error en la consulta a la base de datos.'; // Mensaje de error de consulta
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h2 class="text-center">Iniciar Sesión</h2>
        <?php if (isset($error_message)) : ?>
            <div class="alert alert-danger"><?= $error_message ?></div>
        <?php endif; ?>
        <form action="login.php" method="POST">
            <div class="mb-3">
                <label for="username" class="form-label">Usuario</label>
                <input type="text" class="form-control" name="username" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Contraseña</label>
                <input type="password" class="form-control" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Iniciar Sesión</button>
        </form>

        <!-- Botón para volver al inicio -->
        <div class="text-center mt-3">
            <a href="../index.php" class="btn btn-secondary">Volver al Inicio</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
