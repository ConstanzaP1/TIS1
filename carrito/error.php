<?php
session_start();
include('../conexion.php');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: rgba(0, 128, 255, 0.1);
            display: flex;
            justify-content: center;
            align-items: flex-start;
            padding-top: 5vh;
            min-height: 100vh;
            margin: 0;
        }
        .card {
            background-color: rgba(0, 128, 255, 0.5);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            border-radius: 15px;
            padding: 2rem;
        }
        .btn-primary {
            background-color: rgba(0, 128, 255, 0.9);
            border: none;
        }
        .btn-primary:hover {
            background-color: rgba(0, 128, 255, 1);
        }
        h1 {
            color: #fff;
        }
        label, p {
            color: #ffffff;
        }
        .alert {
            border-radius: 8px;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="text-center mb-4">
            <a href="../index.php">
                <img class="logo img-fluid w-25 rounded-pill" src="../logopng.png" alt="Logo">
            </a>
        </div>
        <!-- Contenedor -->
        <div class="row justify-content-center" id="login-container">
            <div class="col-md-6">
                <div class="card text-center">
                    <h1>Upss.. Ha ocurrido un error. </h1>
                    <p>Lo sentimos, ha ocurrido un error inesperado, intentelo de nuevo mas tarde.</p>
                    <a href="../catalogo_productos/catalogo.php" class="btn btn-secondary">Regresar al catálogo</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>