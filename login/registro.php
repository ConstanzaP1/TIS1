<?php
session_start();
include('../conexion.php'); // Conexión a la base de datos

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role']; // Admin o normal

    // Verificar que el email no esté registrado
    $check_user_query = "SELECT * FROM users WHERE email='$email' LIMIT 1";
    $result = mysqli_query($conn, $check_user_query);
    
    if (mysqli_num_rows($result) == 0) {
        // Encriptar la contraseña
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Insertar el usuario
        $query = "INSERT INTO users (username, email, password, role) 
                  VALUES ('$username', '$email', '$hashedPassword', '$role')";
        if (mysqli_query($conn, $query)) {
            $_SESSION['success'] = "Registro exitoso. Ahora puedes iniciar sesión.";
            header('Location: login/login.php');
        } else {
            echo "Error al registrar.";
        }
    } else {
        echo "El email ya está registrado.";
    }
}
?>

<!-- Formulario de registro -->
<form method="post" action="">
    <input type="text" name="username" placeholder="Usuario" required>
    <input type="email" name="email" placeholder="Correo electrónico" required>
    <input type="password" name="password" placeholder="Contraseña" required>
    <select name="role" required>
        <option value="normal">Usuario normal</option>
        <option value="admin">Administrador</option>
    </select>
    <button type="submit">Registrarse</button>
</form>
