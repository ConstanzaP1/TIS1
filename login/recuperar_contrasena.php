<?php
// Incluimos el archivo autoload de PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php'; // Si usas Composer, esto es suficiente
// Si no usas Composer, puedes incluir los archivos manualmente

session_start();

// Conexión a la base de datos
require('../conexion.php');

// Si el formulario es enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = mysqli_real_escape_string($conexion, $_POST['email']);

    // Verificar si el correo existe en la base de datos
    $query = "SELECT * FROM users WHERE email = '$email' LIMIT 1";
    $result = mysqli_query($conexion, $query);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);

        // Generar un token único para la recuperación de contraseña
        $token = bin2hex(random_bytes(50));  // Genera un token único
        $token_expiry = date("Y-m-d H:i:s", strtotime('+1 hour')); // El token será válido por 1 hora

        // Guardar el token en la base de datos
        $updateQuery = "UPDATE users SET recovery_token = '$token', token_expiry = '$token_expiry' WHERE email = '$email'";
        if (mysqli_query($conexion, $updateQuery)) {
            // Generar la URL de recuperación con el token
            $url = "http://" . $_SERVER['HTTP_HOST'] . "/xampp/TIS1/login/recuperar_contrasena_confirmar.php?token=$token";

            // Configuración de PHPMailer
            $mail = new PHPMailer(true);

            try {
                // Configuración del servidor SMTP
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com'; // Servidor SMTP de Gmail
                $mail->SMTPAuth = true;
                $mail->Username = 'tisnology1@gmail.com'; // Tu correo de Gmail
                $mail->Password = 'ytfksqrqrginpvge'; // Contraseña de aplicación (si usas 2FA en Gmail)
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;
                $mail->CharSet = 'UTF-8'; // Asegúrate de configurar esto

                // Receptores del correo
                $mail->setFrom('tucorreo@gmail.com', 'Tisnology'); // Tu correo
                $mail->addAddress($email); // Dirección del usuario que está solicitando la recuperación

                // Contenido del correo
                $mail->Subject = 'Recuperación de contraseña';
                $mail->Body    = "Hola, para recuperar tu contraseña, haz clic en el siguiente enlace:\n\n" . $url;
                $mail->AltBody = "Hola, para recuperar tu contraseña, haz clic en el siguiente enlace:\n\n" . $url;

                // Enviar el correo
                $mail->send();
                echo "Se ha enviado un enlace de recuperación de contraseña a tu correo.";

            } catch (Exception $e) {
                echo "Hubo un error al enviar el correo: {$mail->ErrorInfo}";
            }
        } else {
            echo "Error al generar el token.";
        }
    } else {
        echo "El correo electrónico no está registrado.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Contraseña</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="row justify-content-center align-items-center min-vh-100">
            <div class="col-md-6 col-lg-4">
                <div class="card shadow">
                    <div class="card-body">
                        <h2 class="text-center mb-4">Recuperar Contraseña</h2>
                        <form method="POST" action="recuperar_contrasena.php">
                            <div class="mb-3">
                                <label for="email" class="form-label">Correo electrónico</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Recuperar Contraseña</button>
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
