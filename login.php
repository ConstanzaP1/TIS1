<?php
// Iniciar sesión
session_start();

// Incluir el archivo de conexión a la base de datos
require 'db.php';

// Verificar si se enviaron los datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Preparar y ejecutar la consulta para verificar el usuario
    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE username = :username");
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verificar si se encontró el usuario y si la contraseña es correcta
    if ($usuario && password_verify($password, $usuario['password'])) {
        // Guardar la información de usuario en la sesión
        $_SESSION['username'] = $usuario['username'];
        echo "Login exitoso. Bienvenido, " . $usuario['username'] . "!";
        // Redirigir a una página protegida
        // header("Location: dashboard.php");
    } else {
        echo "Nombre de usuario o contraseña incorrectos.";
    }
} else {
    echo "Método de solicitud no válido.";
}
?>
