<?php
session_start();
require '../conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["nombre"];
    $email = $_POST["email"];
    $pregunta = $_POST["pregunta"];

    $stmt = $conexion->prepare("INSERT INTO atencion_postventa (cliente_nombre, cliente_email, pregunta) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $nombre, $email, $pregunta);
    $stmt->execute();

    echo "¡Tu pregunta ha sido enviada!";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>Enviar Pregunta</h2>
    <form method="POST">
        <div class="form-group">
            <label for="nombre">Nombre:</label>
            <input type="text" class="form-control" id="nombre" name="nombre" required>
        </div>
        <div class="form-group">
            <label for="email">Correo:</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="pregunta">Pregunta:</label>
            <textarea class="form-control" id="pregunta" name="pregunta" rows="4" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Enviar</button>
    </form>
</div>
</body>
</html>
