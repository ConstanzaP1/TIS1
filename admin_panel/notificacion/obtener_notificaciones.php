<?php
header('Content-Type: application/json');

// Conexión a la base de datos y otras configuraciones necesarias
// ...

$sql = "SELECT * FROM notificaciones WHERE leida = 0 ORDER BY fecha_creacion DESC LIMIT 5";
$result = $conn->query($sql);

$notificaciones = [];
while ($row = $result->fetch_assoc()) {
    $notificaciones[] = $row;
}

echo json_encode($notificaciones);
?>