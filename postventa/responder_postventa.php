<?php
session_start();
require('../conexion.php');
require('../vendor/autoload.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Verificar si el usuario es administrador
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../login/login.php');
    exit;
}

// Obtener ID de consulta desde la URL
$idConsulta = $_GET['id_consulta'] ?? null;

// Obtener datos de la consulta específica
$consulta = null;
if ($idConsulta) {
    $stmt = $conexion->prepare("SELECT id, cliente_nombre, cliente_email, id_boleta, pregunta FROM atencion_postventa WHERE id = ?");
    $stmt->bind_param("i", $idConsulta);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $consulta = $result->fetch_assoc();
    } else {
        die("Consulta no encontrada.");
    }
    $stmt->close();
}

// Procesar el formulario de respuesta
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $consulta) {
    $respuesta = trim($_POST['respuesta'] ?? '');
    $idBoleta = $consulta['id_boleta'];
    $clienteEmail = $consulta['cliente_email'];

    if (!empty($respuesta)) {
        // Guardar respuesta en la base de datos
        $stmt = $conexion->prepare("UPDATE atencion_postventa SET respuesta = ?, fecha_respuesta = NOW() WHERE id = ?");
        $stmt->bind_param("si", $respuesta, $idConsulta);

        if ($stmt->execute()) {
            // Enviar respuesta por correo
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'tisnology1@gmail.com'; // Correo del remitente
                $mail->Password = 'ytfksqrqrginpvge'; // Contraseña de aplicación
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                $mail->setFrom('tisnology1@gmail.com', 'Tisnology - Postventa');
                $mail->addAddress($clienteEmail);

                $mail->Subject = 'Respuesta a tu consulta - Postventa Tisnology';
                $mail->Body = "Hola {$consulta['cliente_nombre']},\n\nGracias por contactarnos. Aquí está nuestra respuesta a tu consulta:\n\n{$respuesta}\n\n¡Gracias por confiar en nosotros!\nTisnology";

                $mail->send();

                $successMessage = "Respuesta enviada correctamente y notificación enviada al cliente.";
            } catch (Exception $e) {
                $errorMessage = "Respuesta guardada, pero ocurrió un error al enviar el correo: {$mail->ErrorInfo}";
            }
        } else {
            $errorMessage = "Error al guardar la respuesta en la base de datos.";
        }
        $stmt->close();
    } else {
        $errorMessage = "La respuesta no puede estar vacía.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responder Postventa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<div class="container mt-5">
    <h2>Responder Consulta de Postventa</h2>

    <?php if ($consulta): ?>
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                Consulta de <?php echo htmlspecialchars($consulta['cliente_nombre']); ?>
            </div>
            <div class="card-body">
                <p><strong>Boleta ID:</strong> <?php echo htmlspecialchars($consulta['id_boleta']); ?></p>
                <p><strong>Consulta:</strong> <?php echo nl2br(htmlspecialchars($consulta['pregunta'])); ?></p>
            </div>
        </div>

        <form method="POST">
            <div class="mb-3">
                <label for="respuesta" class="form-label">Tu respuesta:</label>
                <textarea name="respuesta" id="respuesta" class="form-control" rows="5" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Enviar Respuesta</button>
            <a href="listar_consultas.php" class="btn btn-secondary">Volver</a>
        </form>
    <?php else: ?>
        <div class="alert alert-danger">Consulta no encontrada.</div>
    <?php endif; ?>
</div>

<?php if (!empty($successMessage)): ?>
    <script>
        Swal.fire({
            icon: 'success',
            title: '<?php echo addslashes($successMessage); ?>',
            toast: true,
            position: 'top-end',
            timer: 3000,
            timerProgressBar: true,
            showConfirmButton: false
        });
    </script>
<?php elseif (!empty($errorMessage)): ?>
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: '<?php echo addslashes($errorMessage); ?>',
            toast: true,
            position: 'top-end',
            timer: 3000,
            timerProgressBar: true,
            showConfirmButton: false
        });
    </script>
<?php endif; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
