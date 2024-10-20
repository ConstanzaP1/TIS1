<?php
session_start(); // Iniciar sesión, si aún no lo has hecho
require_once 'conexion.php'; // Asegúrate de que la ruta es correcta

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

// Manejar la acción de registro
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validar si el usuario ya existe
    $sql_check = "SELECT * FROM users WHERE username = ? OR email = ?";
    $stmt_check = mysqli_prepare($conexion, $sql_check);
    mysqli_stmt_bind_param($stmt_check, 'ss', $username, $email);
    mysqli_stmt_execute($stmt_check);
    mysqli_stmt_store_result($stmt_check);

    if (mysqli_stmt_num_rows($stmt_check) > 0) {
        $_SESSION['error_message'] = 'El usuario o correo electrónico ya existe.';
    } else {
        // Insertar el nuevo usuario como "normal"
        $sql_insert = "INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, 'normal')";
        $stmt_insert = mysqli_prepare($conexion, $sql_insert);
        
        // Verificar si la preparación fue exitosa
        if ($stmt_insert) {
            // Hashear la contraseña antes de almacenarla
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            mysqli_stmt_bind_param($stmt_insert, 'sss', $username, $email, $hashed_password);
            
            // Ejecutar la consulta
            if (mysqli_stmt_execute($stmt_insert)) {
                $_SESSION['message'] = 'Usuario registrado exitosamente.'; // Almacena en la sesión
                header('Location: index.php'); // Redirigir a index.php
                exit; // Salir para evitar que se ejecute el resto del código
            } else {
                $_SESSION['error_message'] = 'Error al registrar el usuario. Inténtalo de nuevo.';
            }
            mysqli_stmt_close($stmt_insert); // Cerrar la declaración solo si fue creada
        } else {
            $_SESSION['error_message'] = 'Error al preparar la consulta de inserción.';
        }
    }
    
    mysqli_stmt_close($stmt_check);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos</title>
    <style>
        /* Estilos (como los que ya tenías) */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .header {
            background-color: #333;
            color: white;
            padding: 1rem;
            text-align: center;
        }
        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 1rem;
        }
        .formulario-registro {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
        }
        .formulario-registro input {
            margin-right: 10px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            flex: 1;
        }
        .formulario-registro button {
            padding: 10px 15px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-right: 5px;
        }
        .product {
            background-color: white;
            padding: 1rem;
            margin: 1rem 0;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .product h3 {
            margin: 0 0 10px;
        }
        .button-container {
            display: flex;
            align-items: center;
        }
        .message {
            margin-top: 10px;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>Lista de Productos</h1>
    </div>

    <div class="container">
        <!-- Formulario de registro -->
        <div class="formulario-registro">
            <form method="post" action="" style="flex: 1;">
                <input type="text" name="username" placeholder="Usuario" required>
                <input type="email" name="email" placeholder="Correo electrónico" required>
                <input type="password" name="password" placeholder="Contraseña" required>
                <button type="submit">Registrarse</button>
            </form>
            <div class="button-container">
                <a href="login/login.php">
                    <button type="button">Iniciar Sesión</button>
                </a>
            </div>
        </div>

        <!-- Mensajes de éxito o error -->
        <?php if ($message): ?>
            <div class="alert alert-success message" role="alert">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>
        <?php if ($error_message): ?>
            <div class="alert alert-danger message" role="alert">
                <?php echo $error_message; ?>
            </div>
        <?php endif; ?>

        <div class="product">
            <h3>Producto 1</h3>
            <p>Descripción del producto 1.</p>
            <p>Precio: $10</p>
        </div>
        <div class="product">
            <h3>Producto 2</h3>
            <p>Descripción del producto 2.</p>
            <p>Precio: $20</p>
        </div>
        <div class="product">
            <h3>Producto 3</h3>
            <p>Descripción del producto 3.</p>
            <p>Precio: $30</p>
        </div>
    </div>

</body>
</html>
