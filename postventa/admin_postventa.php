<?php
session_start();
require('../conexion.php');

// Verificar si el usuario es administrador
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../login/login.php');
    exit;
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
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4">Administración de Postventa</h2>
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Cliente</th>
                    <th>Correo</th>
                    <th>Pregunta</th>
                    <th>Respuesta</th>
                    <th>Fecha Pregunta</th>
                    <th>Fecha Respuesta</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['cliente_nombre']); ?></td>
                        <td><?php echo htmlspecialchars($row['cliente_email']); ?></td>
                        <td><?php echo htmlspecialchars($row['pregunta']); ?></td>
                        <td><?php echo $row['respuesta'] ? htmlspecialchars($row['respuesta']) : 'Sin respuesta'; ?></td>
                        <td><?php echo date('d/m/Y H:i', strtotime($row['fecha_pregunta'])); ?></td>
                        <td><?php echo $row['fecha_respuesta'] ? date('d/m/Y H:i', strtotime($row['fecha_respuesta'])) : 'Pendiente'; ?></td>
                        <td>
                            <form method="POST" action="responder_postventa.php">
                                <input type="hidden" name="id_consulta" value="<?php echo $row['id']; ?>">
                                <textarea name="respuesta" class="form-control mb-2" rows="2" placeholder="Escribe una respuesta"></textarea>
                                <button type="submit" class="btn btn-success btn-sm">Responder</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
