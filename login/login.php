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
    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conexion, $query);

    if ($result) {
        $user = mysqli_fetch_assoc($result);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['username'] = $user['username'];

            if ($user['role'] == 'admin') {
                header('Location: ../index.php');
            } else {
                header('Location: ../index.php');
            }
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
    $username = $_POST['reg_username'];
    $email = $_POST['reg_email'];
    $password = $_POST['reg_password'];

    $sql_check = "SELECT * FROM users WHERE email = ?";
    $stmt_check = mysqli_prepare($conexion, $sql_check);
    mysqli_stmt_bind_param($stmt_check, 's', $email);
    mysqli_stmt_execute($stmt_check);
    mysqli_stmt_store_result($stmt_check);

    if (mysqli_stmt_num_rows($stmt_check) > 0) {
        $_SESSION['error_message'] = 'El correo electrónico ya está registrado.';
        mysqli_stmt_close($stmt_check);
        header('Location: ../login/login.php');
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
            mysqli_stmt_close($stmt_check);  // Este es el único cierre necesario si el insert falla
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

<div class="container">
    
    <div class="row d-flex justify-content-center">
        <div class="col-6">
            <img class="img-fluid" src="../logo.jpg" alt="">
        </div>
    </div>
    <div class="row d-flex justify-content-center">
        <div class="col-7 mt-3">
            <div class="caja__trasera">
                <div class="caja__trasera-login">
                    <h3>¿Ya tienes una cuenta?</h3>
                    <p>Inicia sesión para acceder</p>
                    <button id="btn__iniciar-sesion">Iniciar Sesión</button>
                </div>
                <div class="caja__trasera-register">
                    <h3>¿Aún no tienes cuenta?</h3>
                    <p>Regístrate para que puedas iniciar sesión</p>
                    <button id="btn__registrarse">Registrarse</button>
                </div>
            </div>

            <div class="contenedor__login-register">
            
                <form action="login.php" method="POST" class="formulario__login">
                    <h2>Iniciar Sesión</h2>
                    <?php if (!empty($error_message)): ?>
                        <div class="alert alert-danger"><?= $error_message ?></div>
                    <?php elseif (!empty($message)): ?>
                        <div class="alert alert-success"><?= $message ?></div>
                    <?php endif; ?>
                    <input type="email" placeholder="Correo Electrónico" name="email" required>
                    <input type="password" placeholder="Contraseña" name="password" required>
                    <button type="submit" name="login">Iniciar Sesión</button>
                  </form>
            
                <form action="login.php" method="POST" class="formulario__register">
                    <h2>Registrarse</h2>
                    <input type="text" placeholder="Usuario" name="reg_username" required>
                    <input type="email" placeholder="Correo Electrónico" name="reg_email" required>
                    <input type="password" placeholder="Contraseña" name="reg_password" required>
                    <button type="submit" name="register">Registrarse</button>
                </form>
            </div>
        </div>
    </div>
    <div class="row mt-1">
        <div class="col-12">
            <a href='../index.php' class='btn btn-secondary mt-3'>Volver atras</a>
        </div>
    </div>
</div>



<script src="../admin_panel/script.js"></script> 
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
