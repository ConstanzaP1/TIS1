<?php
$servername = "localhost"; // O el nombre de tu servidor
$username = "root";    // Cambia esto por tu usuario de base de datos
$password = "";  // Cambia esto por tu contraseña de base de datos
$dbname = "proyecto_tis1"; // Cambia esto por el nombre de tu base de datos

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>