<?php
session_start();
include('../conexion.php'); // Asegúrate de incluir tu archivo de conexión a la base de datos

// Inicializar mensajes
$message = '';
$error_message = '';

// Verifica si hay un mensaje almacenado en la sesión
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']); // Elimina el mensaje de la sesión
}

if (isset($_SESSION['error_message'])) {
    $error_message = $_SESSION['error_message'];
    unset($_SESSION['error_message']); // Elimina el mensaje de error de la sesión
}

// Manejar la acción de inicio de sesión
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    $email = $_POST['email']; // Cambiado a email
    $password = $_POST['password'];

    // Consulta a la base de datos
    $query = "SELECT * FROM users WHERE email = '$email'"; // Cambiado a email
    $result = mysqli_query($conexion, $query);

    if ($result) {
        $user = mysqli_fetch_assoc($result);

        // Verificar si el usuario existe y la contraseña coincide
        if ($user && password_verify($password, $user['password'])) {
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
            $_SESSION['error_message'] = 'Correo o contraseña incorrectos.'; // Mensaje de error
            header('Location: login.php'); // Redirigir para mostrar el mensaje
            exit();
        }
    } else {
        $_SESSION['error_message'] = 'Error en la consulta a la base de datos.'; // Mensaje de error de consulta
        header('Location: login.php');
        exit();
    }
}

// Manejar la acción de registro
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])) {
    $username = $_POST['reg_username'];
    $email = $_POST['reg_email'];
    $password = $_POST['reg_password'];

    // Validar si el correo ya existe
    $sql_check = "SELECT * FROM users WHERE email = ?";
    $stmt_check = mysqli_prepare($conexion, $sql_check);
    mysqli_stmt_bind_param($stmt_check, 's', $email);
    mysqli_stmt_execute($stmt_check);
    mysqli_stmt_store_result($stmt_check);

    if (mysqli_stmt_num_rows($stmt_check) > 0) {
        $_SESSION['error_message'] = 'El correo electrónico ya está registrado.';
        header('Location: login.php');
        exit();
    } else {
        // Insertar el nuevo usuario con el rol 'user'
        $sql_insert = "INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, 'user')";
        $stmt_insert = mysqli_prepare($conexion, $sql_insert);

        if ($stmt_insert) {
            // Hashear la contraseña antes de almacenarla
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            mysqli_stmt_bind_param($stmt_insert, 'sss', $username, $email, $hashed_password);

            if (mysqli_stmt_execute($stmt_insert)) {
                $_SESSION['message'] = 'Usuario registrado exitosamente.';
                header('Location: login.php'); // Redirigir al login después del registro
                exit();
            } else {
                $_SESSION['error_message'] = 'Error al registrar el usuario. Inténtalo de nuevo.';
                header('Location: login.php');
                exit();
            }
            mysqli_stmt_close($stmt_insert);
        } else {
            $_SESSION['error_message'] = 'Error al preparar la consulta de inserción.';
            header('Location: login.php');
            exit();
        }
    }

    mysqli_stmt_close($stmt_check);
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

        <!-- Mostrar mensajes de éxito o error -->
        <?php if (!empty($error_message)): ?>
            <div class="alert alert-danger"><?= $error_message ?></div>
        <?php elseif (!empty($message)): ?>
            <div class="alert alert-success"><?= $message ?></div>
        <?php endif; ?>

        <!-- Formulario de inicio de sesión -->
        <form action="login.php" method="POST">
            <div class="mb-3">
                <label for="email" class="form-label">Correo Electrónico</label> <!-- Cambiado a Correo Electrónico -->
                <input type="email" class="form-control" name="email" required> <!-- Cambiado a email -->
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Contraseña</label>
                <input type="password" class="form-control" name="password" required>
            </div>
            <div class="d-flex justify-content-between">
                <button type="submit" name="login" class="btn btn-primary">Iniciar Sesión</button>
                <a href="../index.php" class="btn btn-secondary">Volver al Inicio</a>
            </div>
        </form>

        <hr>

        <!-- Formulario de registro -->
        <h2 class="text-center">Registrarse</h2>
        <form action="login.php" method="POST">
            <div class="mb-3">
                <label for="reg_username" class="form-label">Usuario</label>
                <input type="text" class="form-control" name="reg_username" required>
            </div>
            <div class="mb-3">
                <label for="reg_email" class="form-label">Correo Electrónico</label>
                <input type="email" class="form-control" name="reg_email" required>
            </div>
            <div class="mb-3">
                <label for="reg_password" class="form-label">Contraseña</label>
                <input type="password" class="form-control" name="reg_password" required>
            </div>
            <div class="d-flex justify-content-between">
                <button type="submit" name="register" class="btn btn-success">Registrarse</button>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
