<?php
function obtenerHistorialCompras($conexion, $userId) {
    $query = "SELECT h.id_historial, h.id_usuario, h.id_boleta, h.fecha_compra, h.total as total_historial, 
                     b.fecha, b.total as total_boleta, b.codigo_autorizacion, b.detalles
              FROM historial_compras h
              INNER JOIN boletas b ON h.id_boleta = b.id_boleta
              WHERE h.id_usuario = ?
              ORDER BY b.fecha DESC";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    $historial = [];
    while ($row = $result->fetch_assoc()) {
        $row['detalles'] = json_decode($row['detalles'], true);
        $historial[] = $row;
    }
    $stmt->close();
    return $historial;
}
