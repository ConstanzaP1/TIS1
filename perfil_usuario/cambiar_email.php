<?php
function cambiarEmail($conexion, $userId, $newEmail) {
    $newEmail = trim($newEmail);
    if (filter_var($newEmail, FILTER_VALIDATE_EMAIL)) {
        $checkStmt = $conexion->prepare("SELECT id FROM users WHERE email = ? AND id != ?");
        $checkStmt->bind_param("si", $newEmail, $userId);
        $checkStmt->execute();
        $checkResult = $checkStmt->get_result();
        if ($checkResult->num_rows > 0) {
            return "El correo electrónico ya está en uso. Por favor, elija otro.";
        } else {
            $updateStmt = $conexion->prepare("UPDATE users SET email = ? WHERE id = ?");
            $updateStmt->bind_param("si", $newEmail, $userId);
            if ($updateStmt->execute()) {
                return "Correo electrónico actualizado correctamente.";
            } else {
                return "Error al actualizar el correo electrónico.";
            }
            $updateStmt->close();
        }
        $checkStmt->close();
    } else {
        return "El correo electrónico no es válido.";
    }
}
