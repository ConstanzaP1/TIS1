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
            justify-content: center;
            align-items: center;
        }
        .formulario-registro button {
            padding: 10px 15px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin: 0 5px; /* Espaciado entre botones */
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
        <!-- Botones de Iniciar Sesión y Registrarse -->
        <div class="formulario-registro">
            <div class="button-container">
                <a href="login/login.php">
                    <button type="button">Iniciar Sesión</button>
                </a>
                <a href="login/login.php">
                    <button type="button">Registrarse</button>
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
