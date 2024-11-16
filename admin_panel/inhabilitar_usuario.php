<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php'; 

// Conexión a la base de datos
$conexion = new mysqli("localhost", "root", "", "proyecto_tis1");
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Validar si se envió el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = intval($_POST['user_id']);
    $action = isset($_POST['action']) ? $_POST['action'] : '';
    $reason = isset($_POST['reason']) ? $conexion->real_escape_string($_POST['reason']) : '';

    if ($action === 'inhabilitar') {
        // Lógica para inhabilitar al usuario
        $query = "UPDATE users SET status = 'inhabilitado' WHERE id = ?";
        $stmt = $conexion->prepare($query);
        $stmt->bind_param("i", $user_id);

        if ($stmt->execute()) {
            // Enviar correo al usuario
            $query_email = "SELECT email FROM users WHERE id = ?";
            $stmt_email = $conexion->prepare($query_email);
            $stmt_email->bind_param("i", $user_id);
            $stmt_email->execute();
            $result = $stmt_email->get_result();
            $user_email = $result->fetch_assoc()['email'];

            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'tisnology1@gmail.com'; 
                $mail->Password = 'kkayajvlxqjtelsn';    
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                $mail->setFrom('tisnology1@gmail.com');
                $mail->addAddress($user_email);
                $mail->CharSet = 'UTF-8';
                $mail->Subject = 'Notificación de cuenta inhabilitada';
                $mail->Body = "Hola,\n\nTu cuenta ha sido inhabilitada por la siguiente razón:\n\n$reason\n\nSi tienes dudas, contacta con el soporte al siguiente número +56964177223.\n\nEl equipo de Tisnology";

                $mail->send();
                header("Location: lista_usuarios.php");
                exit();
            } catch (Exception $e) {
                echo "<script>
                    Swal.fire('Error', 'No se pudo enviar el correo: {$mail->ErrorInfo}', 'error')
                    .then(() => {
                        window.location.href = 'lista_usuarios.php';
                    });
                </script>";
                exit();
            }
        } else {
            echo "<script>Swal.fire('Error', 'No se pudo inhabilitar la cuenta.', 'error')
                .then(() => {
                    window.location.href = 'lista_usuarios.php';
                });
            </script>";
            exit();
        }
    } elseif ($action === 'habilitar') {
        // Lógica para habilitar al usuario
        $query = "UPDATE users SET status = 'activo' WHERE id = ?";
        $stmt = $conexion->prepare($query);
        $stmt->bind_param("i", $user_id);

        if ($stmt->execute()) {
            // Enviar correo notificando que la cuenta ha sido habilitada
            $query_email = "SELECT email FROM users WHERE id = ?";
            $stmt_email = $conexion->prepare($query_email);
            $stmt_email->bind_param("i", $user_id);
            $stmt_email->execute();
            $result = $stmt_email->get_result();
            $user_email = $result->fetch_assoc()['email'];
    
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'tisnology1@gmail.com'; 
                $mail->Password = 'kkayajvlxqjtelsn';    
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;
    
                $mail->setFrom('tisnology1@gmail.com');
                $mail->addAddress($user_email);
                $mail->CharSet = 'UTF-8';
                $mail->Subject = 'Notificación de cuenta habilitada';
                $mail->Body = "Hola,\n\nNos complace informarte que tu cuenta ha sido habilitada exitosamente.\n\nSi tienes dudas, contacta con el soporte al siguiente número +56964177223.\n\nEl equipo de Tisnology";
    
                $mail->send();
    
                // Redirigir después de enviar el correo
                header("Location: lista_usuarios.php");
                exit();
            } catch (Exception $e) {
                echo "<script>
                    Swal.fire('Error', 'No se pudo enviar el correo: {$mail->ErrorInfo}', 'error')
                    .then(() => {
                        window.location.href = 'lista_usuarios.php';
                    });
                </script>";
                exit();
            }
        } else {
            echo "<script>Swal.fire('Error', 'No se pudo habilitar la cuenta.', 'error')
                .then(() => {
                    window.location.href = 'lista_usuarios.php';
                });
            </script>";
            exit();
        }
    }
}