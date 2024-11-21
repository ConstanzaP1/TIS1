<?php
function cambiarUsername($conexion, $userId, $newUsername) {
    $newUsername = trim($newUsername);
    if (!empty($newUsername)) {
        $checkStmt = $conexion->prepare("SELECT id FROM users WHERE username = ? AND id != ?");
        $checkStmt->bind_param("si", $newUsername, $userId);
        $checkStmt->execute();
        $checkResult = $checkStmt->get_result();
        if ($checkResult->num_rows > 0) {
            return "El nombre de usuario ya existe. Por favor, elija otro.";
        } else {
            $updateStmt = $conexion->prepare("UPDATE users SET username = ? WHERE id = ?");
            $updateStmt->bind_param("si", $newUsername, $userId);
            if ($updateStmt->execute()) {
                return "Nombre de usuario actualizado correctamente.";
            } else {
                return "Error al actualizar el nombre de usuario.";
            }
            $updateStmt->close();
        }
        $checkStmt->close();
    } else {
        return "El nombre de usuario no puede estar vacío.";
    }
}
