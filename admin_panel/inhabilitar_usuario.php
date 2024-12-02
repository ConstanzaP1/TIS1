<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php'; 

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Conexión a la base de datos
$conexion = new mysqli("localhost", "root", "", "proyecto_tis1");
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Validar si se envió el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = intval($_POST['user_id']);
    $action = $_POST['action'] ?? '';
    $reason = $_POST['reason'] ?? ''; // Razón para inhabilitar, si aplica

    if ($action === 'inhabilitar') {
        // Lógica para inhabilitar al usuario
        $query = "UPDATE users SET status = 'inhabilitado' WHERE id = ?";
        $stmt = $conexion->prepare($query);
        $stmt->bind_param("i", $user_id);

        if ($stmt->execute()) {
            // Obtener el correo del usuario
            $query_email = "SELECT email FROM users WHERE id = ?";
            $stmt_email = $conexion->prepare($query_email);
            $stmt_email->bind_param("i", $user_id);
            $stmt_email->execute();
            $result = $stmt_email->get_result();
            $user_email = $result->fetch_assoc()['email'];

            // Enviar correo al usuario
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'tisnology1@gmail.com'; 
                $mail->Password = 'ytfksqrqrginpvge';    
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                $mail->setFrom('tisnology1@gmail.com');
                $mail->addAddress($user_email);
                $mail->CharSet = 'UTF-8';
                $mail->Subject = 'Notificación de cuenta inhabilitada';
                $mail->Body = "Hola,\nTu cuenta ha sido inhabilitada por la siguiente razón:\n$reason\n\nSi tienes dudas, contacta con el soporte en tisnology1@gmail.com.\nEl equipo de Tisnology";

                $mail->send();

                // Redirigir tras el envío exitoso
                header("Location: lista_usuarios.php");
                exit();
            } catch (Exception $e) {
                echo "Error al enviar el correo: " . $mail->ErrorInfo;
            }
        } else {
            echo "Error al inhabilitar el usuario: " . $conexion->error;
        }
    } elseif ($action === 'habilitar') {
        // Lógica para habilitar al usuario
        $query = "UPDATE users SET status = 'activo' WHERE id = ?";
        $stmt = $conexion->prepare($query);
        $stmt->bind_param("i", $user_id);

        if ($stmt->execute()) {
            // Obtener el correo del usuario
            $query_email = "SELECT email FROM users WHERE id = ?";
            $stmt_email = $conexion->prepare($query_email);
            $stmt_email->bind_param("i", $user_id);
            $stmt_email->execute();
            $result = $stmt_email->get_result();
            $user_email = $result->fetch_assoc()['email'];

            // Enviar correo notificando la habilitación
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'tisnology1@gmail.com'; 
                $mail->Password = 'ytfksqrqrginpvge';    
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                $mail->setFrom('tisnology1@gmail.com');
                $mail->addAddress($user_email);
                $mail->CharSet = 'UTF-8';
                $mail->Subject = 'Notificación de cuenta habilitada';
                $mail->Body = "Hola,\nNos complace informarte que tu cuenta ha sido habilitada exitosamente.\nSi tienes dudas, contacta con el soporte en tisnology1@gmail.com.\nEl equipo de Tisnology";

                $mail->send();

                // Redirigir tras el envío exitoso
                header("Location: lista_usuarios.php");
                exit();
            } catch (Exception $e) {
                echo "Error al enviar el correo: " . $mail->ErrorInfo;
            }
        } else {
            echo "Error al habilitar el usuario: " . $conexion->error;
        }
    }
}
