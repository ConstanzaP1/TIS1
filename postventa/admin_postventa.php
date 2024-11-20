<?php
$conn = new mysqli("localhost", "usuario", "password", "basedatos");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $respuesta = $_POST["respuesta"];

    // Actualiza la respuesta en la base de datos
    $stmt = $conn->prepare("UPDATE atencion_postventa SET respuesta = ?, fecha_respuesta = NOW() WHERE id = ?");
    $stmt->bind_param("si", $respuesta, $id);
    $stmt->execute();
}

// Obtener preguntas pendientes (sin respuesta)
$pendientes = $conn->query("SELECT * FROM atencion_postventa WHERE respuesta IS NULL ORDER BY fecha_pregunta ASC");

// Obtener todas las preguntas y respuestas
$todas = $conn->query("SELECT * FROM atencion_postventa ORDER BY fecha_pregunta DESC");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Administrador - Atención Postventa</title>
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4 text-center">Panel de Atención Postventa</h2>

    <!-- Tabla de preguntas pendientes -->
    <h4>Preguntas Pendientes</h4>
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>ID</th>
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
                    <td><?= $row['id'] ?></td>
                    <td><?= $row['cliente_nombre'] ?></td>
                    <td><?= $row['cliente_email'] ?></td>
                    <td><?= $row['pregunta'] ?></td>
                    <td><?= $row['fecha_pregunta'] ?></td>
                    <td>
                        <form method="POST">
                            <input type="hidden" name="id" value="<?= $row['id'] ?>">
                            <textarea name="respuesta" class="form-control" placeholder="Escribe tu respuesta" required></textarea>
                            <button type="submit" class="btn btn-success mt-2">Enviar</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <!-- Tabla de todas las preguntas y respuestas -->
    <h4 class="mt-5">Historial de Preguntas y Respuestas</h4>
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Pregunta</th>
                <th>Respuesta</th>
                <th>Fecha Pregunta</th>
                <th>Fecha Respuesta</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $todas->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= $row['cliente_nombre'] ?></td>
                    <td><?= $row['cliente_email'] ?></td>
                    <td><?= $row['pregunta'] ?></td>
                    <td><?= $row['respuesta'] ?? 'Pendiente' ?></td>
                    <td><?= $row['fecha_pregunta'] ?></td>
                    <td><?= $row['fecha_respuesta'] ?? 'Pendiente' ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
</body>
</html>
