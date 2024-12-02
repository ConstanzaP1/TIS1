<?php
function cambiarImagen($conexion, $userId, $newProfilePicture) {
    $newProfilePicture = trim($newProfilePicture);
    $updateStmt = $conexion->prepare("UPDATE users SET img = ? WHERE id = ?");
    $updateStmt->bind_param("si", $newProfilePicture, $userId);
    if ($updateStmt->execute()) {
        return "Imagen de perfil actualizada correctamente.";
    } else {
        return "Error al actualizar la imagen de perfil.";
    }
    $updateStmt->close();
}
