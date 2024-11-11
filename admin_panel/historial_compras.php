<?php
session_start();
require('../conexion.php');

// Verificar que el usuario esté en sesión
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login/login.php");
    exit();
}

$id_usuario = $_SESSION['user_id'];
$role = $_SESSION['role'] ?? '';

// Obtener el ID del usuario cuyo historial se quiere ver desde el parámetro de la URL
$user_id = $_GET['user_id'] ?? $id_usuario;

// Solo permitir que el administrador o superadministrador vean el historial de otros usuarios
if ($id_usuario != $user_id && !in_array($role, ['admin', 'superadmin'])) {
    die("No tienes permisos para ver el historial de este usuario.");
}

// Consultar el historial de compras para el usuario especificado
$query_historial = "SELECT hc.fecha_compra, hc.total, hc.id_usuario, b.detalles 
                    FROM historial_compras hc
                    JOIN boletas b ON hc.id_boleta = b.id_boleta
                    WHERE hc.id_usuario = '$user_id'
                    ORDER BY hc.fecha_compra DESC";
$result = mysqli_query($conexion, $query_historial);

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial de Compras</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container my-5">
        <h2>Historial de Compras</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <?php if ($role === 'admin' || $role === 'superadmin'): ?>
                        <th>ID Usuario</th>
                    <?php endif; ?>
                    <th>Fecha de Compra</th>
                    <th>Total</th>
                    <th>Detalles</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <?php if ($role === 'admin' || $role === 'superadmin'): ?>
                            <td><?php echo htmlspecialchars($row['id_usuario'] ?? ''); ?></td>
                        <?php endif; ?>
                        <td><?php echo date('d/m/Y H:i', strtotime($row['fecha_compra'])); ?></td>
                        <td>$<?php echo number_format($row['total'], 2, ',', '.'); ?></td>
                        <td><?php echo htmlspecialchars($row['detalles']); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <a href="javascript:history.back()" class="btn btn-secondary">Volver Atrás</a>
    </div>
</body>
</html>
