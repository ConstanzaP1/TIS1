<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require('../vendor/autoload.php'); // PHPMailer
require('../conexion.php'); // Conexión a la base de datos

$search = $_GET['search'] ?? ''; // Búsqueda

// Consultas para cargar preguntas
$pendientes = $conexion->query("SELECT * FROM atencion_postventa WHERE respuesta IS NULL AND (cliente_nombre LIKE '%$search%' OR cliente_email LIKE '%$search%') ORDER BY fecha_pregunta ASC");
$todas = $conexion->query("SELECT * FROM atencion_postventa WHERE cliente_nombre LIKE '%$search%' OR cliente_email LIKE '%$search%' ORDER BY fecha_pregunta DESC");

// Procesar el formulario para enviar respuesta
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $respuesta = $_POST['respuesta'];

    // Obtener datos del cliente y la pregunta
    $stmt = $conexion->prepare("SELECT cliente_email, cliente_nombre, pregunta FROM atencion_postventa WHERE id = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $email = $row['cliente_email'];
        $nombre = $row['cliente_nombre'];
        $pregunta = $row['pregunta'];

        // Actualizar la base de datos con la respuesta
        $update = $conexion->prepare("UPDATE atencion_postventa SET respuesta = ?, fecha_respuesta = NOW() WHERE id = ?");
        $update->bind_param('si', $respuesta, $id);
        if ($update->execute()) {
            // Enviar correo con PHPMailer
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'tisnology1@gmail.com'; // Tu correo
                $mail->Password = 'kkayajvlxqjtelsn'; // Tu contraseña
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                $mail->setFrom('tisnology1@gmail.com', 'Tisnology Soporte');
                $mail->addAddress($email, $nombre);

                $mail->isHTML(true);
                $mail->Subject = 'Respuesta a tu consulta - Tisnology';
                $mail->Body = "
                    <html>
                    <body style='font-family: Arial, sans-serif; line-height: 1.6;'>
                        <h2 style='text-align: center; color: #4CAF50;'>Respuesta a tu Consulta</h2>
                        <p>Hola <strong>$nombre</strong>,</p>
                        <p>Gracias por contactarte con nosotros. Aquí está la respuesta a tu pregunta:</p>
                        <blockquote style='background: #f9f9f9; border-left: 5px solid #ccc; margin: 10px 0; padding: 10px;'>
                            <strong>Tu pregunta:</strong> $pregunta<br>
                            <strong>Nuestra respuesta:</strong> $respuesta
                        </blockquote>
                        <p>Si tienes más dudas, no dudes en contactarnos nuevamente.</p>
                        <hr>
                        <p style='text-align: center; font-size: 12px; color: #888;'>Tisnology - Soporte</p>
                    </body>
                    </html>
                ";

                $mail->send();
                $successMessage = "Respuesta enviada correctamente al cliente.";
            } catch (Exception $e) {
                $errorMessage = "Error al enviar el correo: {$mail->ErrorInfo}";
            }
        } else {
            $errorMessage = "Error al actualizar la respuesta en la base de datos.";
        }
    } else {
        $errorMessage = "No se encontró la pregunta en la base de datos.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrador - Postventa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .container { margin-top: 20px; }
        .table { margin-top: 20px; }
        .table th, .table td { vertical-align: middle; }
        .alert { margin-top: 20px; }
    </style>
</head>
<body>
<div class="container">
    <h1 class="text-center mb-4">Panel de Atención Postventa</h1>

    <!-- Mensajes -->
    <?php if (isset($successMessage)): ?>
        <div class="alert alert-success"><?= $successMessage ?></div>
    <?php elseif (isset($errorMessage)): ?>
        <div class="alert alert-danger"><?= $errorMessage ?></div>
    <?php endif; ?>

    <!-- Formulario de búsqueda -->
    <form class="mb-4" method="GET">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Buscar por nombre o email" value="<?= htmlspecialchars($search) ?>">
            <button type="submit" class="btn btn-primary">Buscar</button>
        </div>
    </form>

    <!-- Tabla de preguntas pendientes -->
    <h3>Preguntas Pendientes</h3>
    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>Nombre</th>
                <th>Email</th>
                <th>Pregunta</th>
                <th>Fecha</th>
                <th>Responder</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $pendientes->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['cliente_nombre']) ?></td>
                    <td><?= htmlspecialchars($row['cliente_email']) ?></td>
                    <td><?= htmlspecialchars($row['pregunta']) ?></td>
                    <td><?= htmlspecialchars($row['fecha_pregunta']) ?></td>
                    <td>
                        <form method="POST">
                            <input type="hidden" name="id" value="<?= $row['id'] ?>">
                            <textarea name="respuesta" class="form-control" placeholder="Escribe tu respuesta aquí" required></textarea>
                            <button type="submit" class="btn btn-primary mt-2">Enviar</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <!-- Tabla de historial completo -->
    <h3 class="mt-5">Historial Completo</h3>
    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>Nombre</th>
                <th>Email</th>
                <th>Pregunta</th>
                <th>Respuesta</th>
                <th>Estado</th>
                <th>Fecha Pregunta</th>
                <th>Fecha Respuesta</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $todas->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['cliente_nombre']) ?></td>
                    <td><?= htmlspecialchars($row['cliente_email']) ?></td>
                    <td><?= htmlspecialchars($row['pregunta']) ?></td>
                    <td><?= htmlspecialchars($row['respuesta'] ?? 'Pendiente') ?></td>
                    <td><?= $row['respuesta'] ? 'Respondida' : 'Pendiente' ?></td>
                    <td><?= htmlspecialchars($row['fecha_pregunta']) ?></td>
                    <td><?= htmlspecialchars($row['fecha_respuesta'] ?? 'Pendiente') ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
