<?php
// Importa las clases de PHPMailer en el espacio global
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Carga el autoload de Composer
require '../vendor/autoload.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['correo'])) {
    // Captura el correo del formulario
    $correoE = $_POST['correo'];

    // Crea una instancia de PHPMailer
    $mail = new PHPMailer(true);

    try {
        // Configuración del servidor
        $mail->SMTPDebug = 0;                      // Habilita salida de depuración
        $mail->isSMTP();                                            // Usar SMTP
        $mail->Host       = 'smtp.gmail.com';                     // Servidor SMTP
        $mail->SMTPAuth   = true;                                   // Habilitar autenticación SMTP
        $mail->Username   = 'tisnology1@gmail.com';                     // Correo de usuario SMTP
        $mail->Password   = 'kkayajvlxqjtelsn';                               // Contraseña SMTP
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            // Habilitar encriptación TLS
        $mail->Port       = 587;                                    // Puerto SMTP

        // Destinatario
        $mail->setFrom('tisnology1@gmail.com', 'Administrador');
        $mail->addAddress($correoE);  // Agrega el correo electrónico del formulario

        // Contenido del correo
        $mail->isHTML(true);                                  // Configurar formato de correo HTML
        $mail->Subject = 'ESTO NO ES SPAM';
        $mail->Body    = '<h1>Hola, Esto es un correo de verificación</h1>';

        // Enviar correo
        $mail->send();
        echo 'El correo ha sido enviado correctamente.';
    } catch (Exception $e) {
        echo "No se pudo enviar el correo. Error: {$mail->ErrorInfo}";
    }
} else {
    echo "Por favor, envíe el formulario con un correo electrónico válido.";
}
