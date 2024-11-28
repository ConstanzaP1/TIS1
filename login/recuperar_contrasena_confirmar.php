<?php
session_start();
require('../conexion.php');

// Verificar si el token está presente
if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Buscar el token en la base de datos
    $query = "SELECT * FROM users WHERE recovery_token = '$token' LIMIT 1";
    $result = mysqli_query($conexion, $query);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);

        // Verificar si el token ha expirado
        $token_expiry = $user['token_expiry'];
        if (strtotime($token_expiry) > time()) {
            // El token es válido, permitir el cambio de contraseña
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $new_password = password_hash($_POST['new_password'], PASSWORD_BCRYPT);

                // Actualizar la contraseña en la base de datos
                $updateQuery = "UPDATE users SET password = '$new_password', recovery_token = NULL, token_expiry = NULL WHERE recovery_token = '$token'";
                if (mysqli_query($conexion, $updateQuery)) {
                    echo "Tu contraseña ha sido cambiada exitosamente.";
                } else {
                    echo "Hubo un error al actualizar la contraseña.";
                }
            }
        } else {
            echo "El enlace de recuperación ha expirado.";
        }
    } else {
        echo "El token no es válido.";
    }
} else {
    echo "No se ha proporcionado un token válido.";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cambiar Contraseña</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="row justify-content-center align-items-center min-vh-100">
            <div class="col-md-6 col-lg-4">
                <div class="card shadow">
                    <div class="card-body">
                        <h2 class="text-center mb-4">Cambiar Contraseña</h2>
                        <form method="POST" action="recuperar_contrasena_confirmar.php?token=<?php echo $token; ?>">
                            <div class="mb-3">
                                <label for="new_password" class="form-label">Nueva contraseña</label>
                                <input type="password" class="form-control" id="new_password" name="new_password" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Cambiar Contraseña</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
