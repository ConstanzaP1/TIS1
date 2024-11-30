<?php
session_start();
require('../conexion.php');
require('../vendor/autoload.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Verificar si el usuario es administrador
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../login/login.php');
    exit;
}

// Procesar la respuesta del formulario (cuando se envía desde el modal)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_consulta']) && isset($_POST['respuesta'])) {
    $idConsulta = intval($_POST['id_consulta']);
    $respuesta = trim($_POST['respuesta']);

    // Obtener datos de la consulta
    $stmt = $conexion->prepare("SELECT cliente_email, cliente_nombre, pregunta FROM atencion_postventa WHERE id = ?");
    $stmt->bind_param("i", $idConsulta);
    $stmt->execute();
    $consulta = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if ($consulta) {
        $clienteEmail = $consulta['cliente_email'];
        $clienteNombre = $consulta['cliente_nombre'];
        $pregunta = $consulta['pregunta'];

        // Guardar la respuesta en la base de datos
        $stmt = $conexion->prepare("UPDATE atencion_postventa SET respuesta = ?, fecha_respuesta = NOW() WHERE id = ?");
        $stmt->bind_param("si", $respuesta, $idConsulta);

        if ($stmt->execute()) {
            // Enviar correo con PHPMailer
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
                $mail->Body = "Hola {$clienteNombre},\n\nGracias por contactarnos. Aquí está nuestra respuesta a tu consulta:\n\n{$respuesta}\n\n¡Gracias por confiar en nosotros!\nTisnology";

                $mail->send();
                $successMessage = "Respuesta enviada correctamente y notificación enviada al cliente.";
            } catch (Exception $e) {
                $errorMessage = "Respuesta guardada, pero ocurrió un error al enviar el correo: {$mail->ErrorInfo}";
            }
        } else {
            $errorMessage = "Error al guardar la respuesta en la base de datos.";
        }
        $stmt->close();
    }
}

// Obtener todas las consultas de postventa
$query = "SELECT * FROM atencion_postventa ORDER BY fecha_pregunta DESC";
$result = $conexion->query($query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administración de Postventa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .table th, .table td {
            vertical-align: middle;
            text-align: center;
        }
        .pregunta {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 300px;
        }
        .pregunta.expanded {
            white-space: normal;
            overflow: visible;
            text-overflow: unset;
        }
        .btn-toggle {
            cursor: pointer;
            color: #007bff;
            border: none;
            background: none;
            text-decoration: underline;
            padding: 0;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4">Administración de Postventa</h2>
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-primary">
                <tr>
                    <th class="col-2">Cliente</th>
                    <th class="col-2">Correo</th>
                    <th class="col-4">Pregunta</th>
                    <th class="col-2">Respuesta</th>
                    <th class="col-1">Fecha Pregunta</th>
                    <th class="col-1">Fecha Respuesta</th>
                    <th class="col-1">Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['cliente_nombre']); ?></td>
                        <td><?php echo htmlspecialchars($row['cliente_email']); ?></td>
                        <td>
                            <div class="pregunta" id="pregunta-<?php echo $row['id']; ?>">
                                <?php echo htmlspecialchars($row['pregunta']); ?>
                            </div>
                            <?php if (strlen($row['pregunta']) > 150): ?>
                                <button class="btn-toggle" data-id="<?php echo $row['id']; ?>">Ver más</button>
                            <?php endif; ?>
                        </td>
                        <td><?php echo $row['respuesta'] ? htmlspecialchars($row['respuesta']) : 'Sin respuesta'; ?></td>
                        <td><?php echo date('d/m/Y H:i', strtotime($row['fecha_pregunta'])); ?></td>
                        <td><?php echo $row['fecha_respuesta'] ? date('d/m/Y H:i', strtotime($row['fecha_respuesta'])) : 'Pendiente'; ?></td>
                        <td>
                            <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#responderModal" 
                                    data-id="<?php echo $row['id']; ?>" 
                                    data-cliente="<?php echo htmlspecialchars($row['cliente_nombre']); ?>"
                                    data-pregunta="<?php echo htmlspecialchars($row['pregunta']); ?>">
                                Responder
                            </button>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="responderModal" tabindex="-1" aria-labelledby="responderModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="responderModalLabel">Responder Consulta</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Cliente:</strong> <span id="modalCliente"></span></p>
                    <p><strong>Pregunta:</strong> <span id="modalPregunta"></span></p>
                    <div class="mb-3">
                        <label for="respuesta" class="form-label">Respuesta:</label>
                        <textarea class="form-control" id="respuesta" name="respuesta" rows="4" required></textarea>
                    </div>
                    <input type="hidden" id="modalIdConsulta" name="id_consulta">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Enviar Respuesta</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Alternar entre texto truncado y texto completo
    document.querySelectorAll('.btn-toggle').forEach(button => {
        button.addEventListener('click', () => {
            const id = button.getAttribute('data-id');
            const preguntaDiv = document.getElementById(`pregunta-${id}`);

            if (preguntaDiv.classList.contains('expanded')) {
                preguntaDiv.classList.remove('expanded');
                button.textContent = 'Ver más';
            } else {
                preguntaDiv.classList.add('expanded');
                button.textContent = 'Ocultar';
            }
        });
    });

    // Manejar el contenido del modal
    const responderModal = document.getElementById('responderModal');
    responderModal.addEventListener('show.bs.modal', event => {
        const button = event.relatedTarget;
        const idConsulta = button.getAttribute('data-id');
        const cliente = button.getAttribute('data-cliente');
        const pregunta = button.getAttribute('data-pregunta');

        // Rellenar el modal con la información
        document.getElementById('modalCliente').textContent = cliente;
        document.getElementById('modalPregunta').textContent = pregunta;
        document.getElementById('modalIdConsulta').value = idConsulta;
    });

    <?php if (!empty($successMessage)): ?>
        Swal.fire({
            icon: 'success',
            title: '<?php echo addslashes($successMessage); ?>',
            toast: true,
            position: 'top-end',
            timer: 3000,
            timerProgressBar: true,
            showConfirmButton: false
        });
    <?php elseif (!empty($errorMessage)): ?>
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
    <?php endif; ?>
</script>
</body>
</html>
