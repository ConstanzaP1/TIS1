<?php
session_start();
include('../conexion.php');

// Inicializar mensajes
$message = '';
$error_message = '';

if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']);
}

if (isset($_SESSION['error_message'])) {
    $error_message = $_SESSION['error_message'];
    unset($_SESSION['error_message']);
}

// Manejar la acción de inicio de sesión
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    $email = mysqli_real_escape_string($conexion, $_POST['email']);
    $password = mysqli_real_escape_string($conexion, $_POST['password']);

    $query = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conexion, $query);

    if ($result) {
        $user = mysqli_fetch_assoc($result);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['email'] = $user['email'];

            header('Location: ../index.php');
            exit();
        } else {
            $_SESSION['error_message'] = 'Correo o contraseña incorrectos.';
            header('Location: login.php');
            exit();
        }
    } else {
        $_SESSION['error_message'] = 'Error en la consulta a la base de datos.';
        header('Location: login.php');
        exit();
    }
}

// Manejar la acción de registro
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])) {
    $username = mysqli_real_escape_string($conexion, $_POST['reg_username']);
    $email = mysqli_real_escape_string($conexion, $_POST['reg_email']);
    $password = mysqli_real_escape_string($conexion, $_POST['reg_password']);

    $sql_check = "SELECT * FROM users WHERE email = ?";
    $stmt_check = mysqli_prepare($conexion, $sql_check);
    mysqli_stmt_bind_param($stmt_check, 's', $email);
    mysqli_stmt_execute($stmt_check);
    mysqli_stmt_store_result($stmt_check);

    if (mysqli_stmt_num_rows($stmt_check) > 0) {
        $_SESSION['error_message'] = 'El correo electrónico ya está registrado.';
        mysqli_stmt_close($stmt_check);
        header('Location: login.php');
        exit();
    } else {
        $sql_insert = "INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, 'user')";
        $stmt_insert = mysqli_prepare($conexion, $sql_insert);

        if ($stmt_insert) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            mysqli_stmt_bind_param($stmt_insert, 'sss', $username, $email, $hashed_password);

            if (mysqli_stmt_execute($stmt_insert)) {
                $_SESSION['message'] = 'Usuario registrado exitosamente.';
                mysqli_stmt_close($stmt_insert);
                header('Location: login.php');
                exit();
            } else {
                $_SESSION['error_message'] = 'Error al registrar el usuario. Inténtalo de nuevo.';
                mysqli_stmt_close($stmt_insert);
                header('Location: login.php');
                exit();
            }
        } else {
            $_SESSION['error_message'] = 'Error al preparar la consulta de inserción.';
            mysqli_stmt_close($stmt_check);
            header('Location: login.php');
            exit();
        }
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
    <link rel="stylesheet" href="../admin_panel/style.css">
</head>
<body class="bodylogin">
<!-- Botón de Volver Atrás -->
<button onclick="window.location.href='../index.php'" class="boton__volver" style="z-index: 10;">Volver al catálogo</button>
<div class="logo-container">
    <img src="../Logopng.png" alt="Logo" class="logo-image">
</div>

<div class="login-container" id="login-container">
    <div class="login-info-container">
        <h1 class="title">Iniciar Sesión</h1>
        
        <?php if (!empty($error_message)): ?>
            <div class="alert alert-danger"><?= $error_message ?></div>
        <?php elseif (!empty($message)): ?>
            <div class="alert alert-success"><?= $message ?></div>
        <?php endif; ?>

        <form class="inputs-container" method="POST" action="">
            <input type="email" class="input" placeholder="Correo Electrónico" name="email" required>
            <input type="password" class="input" placeholder="Contraseña" name="password" required>
            <button type="submit" name="login" class="btn">Iniciar Sesión</button>
        </form>

        <p class="mt-3">¿No tienes una cuenta? <a href="#" onclick="toggleForms()" class="span">Regístrate aquí</a></p>
    </div>
</div>

<div class="login-container" id="register-container" style="display: none;">
    <div class="login-info-container">
        <h1 class="title">Registrarse</h1>

        <form class="inputs-container" method="POST" action="">
            <input type="text" class="input" placeholder="Usuario" name="reg_username" required>
            <input type="email" class="input" placeholder="Correo Electrónico" name="reg_email" required>
            <input type="password" class="input" placeholder="Contraseña" name="reg_password" required>
            <button type="submit" name="register" class="btn">Registrarse</button>
        </form>

        <p class="mt-3">¿Ya tienes una cuenta? <a href="#" onclick="toggleForms()" class="span">Inicia sesión aquí</a></p>
    </div>
</div>

<script>
function toggleForms() {
    const loginContainer = document.getElementById('login-container');
    const registerContainer = document.getElementById('register-container');
    loginContainer.style.display = loginContainer.style.display === 'none' ? 'flex' : 'none';
    registerContainer.style.display = registerContainer.style.display === 'none' ? 'flex' : 'none';
}
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
