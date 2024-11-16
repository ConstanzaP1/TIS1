<?php
session_start();
require('../conexion.php');
require('../vendor/setasign/fpdf/fpdf.php');

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
// Crear el PDF
// Verificar si se ha solicitado la descarga del PDF
if (isset($_GET['download']) && $_GET['download'] == 'true') {
    // Crear el PDF solo si se ha hecho clic en el botón de descarga
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 14);
    $pdf->Cell(0, 10, 'Historial de Compras', 0, 1, 'C');
    $pdf->Ln(10);

    $pdf->SetFont('Arial', 'B', 10);
    if ($role === 'admin' || $role === 'superadmin') {
        $pdf->Cell(30, 10, 'ID Usuario', 1);
    }
    $pdf->Cell(50, 10, 'Fecha de Compra', 1);
    $pdf->Cell(30, 10, 'Total', 1);
    $pdf->Cell(80, 10, 'Detalles', 1);
    $pdf->Ln();

    $pdf->SetFont('Arial', '', 10);
    while ($row = mysqli_fetch_assoc($result)) {
        if ($role === 'admin' || $role === 'superadmin') {
            $pdf->Cell(30, 10, $row['id_usuario'] ?? '', 1);
        }
        $pdf->Cell(50, 10, date('d/m/Y H:i', strtotime($row['fecha_compra'])), 1);
        $pdf->Cell(30, 10, '$' . number_format($row['total'], 0, ',', '.'), 1);
        $detalles = json_decode($row['detalles'], true);
        $texto_detalles = "";
        if ($detalles) {
            foreach ($detalles as $detalle) {
                $texto_detalles .= "Producto: " . $detalle['producto'] . "; ";
                $texto_detalles .= "Cantidad: " . $detalle['cantidad'] . "; ";
                $texto_detalles .= "Precio Unitario: $" . number_format($detalle['precio_unitario'], 0, ',', '.') . "; ";
                $texto_detalles .= "Total: $" . number_format($detalle['total'], 0, ',', '.') . "\n";
            }
        } else {
            $texto_detalles = "Sin detalles";
        }
        $pdf->MultiCell(80, 10, $texto_detalles, 1);
                $pdf->Ln();
    }

    // Salida del PDF
    $pdf->Output('D', 'historial_compras.pdf');
    exit();
}
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
                        <td>$<?php echo number_format($row['total'], 0, ',', '.'); ?></td>
                        <td>
    <?php 
    $detalles = json_decode($row['detalles'], true);
    if ($detalles) {
        foreach ($detalles as $detalle) {
            echo "Producto: " . htmlspecialchars($detalle['producto']) . "; ";
            echo "Cantidad: " . htmlspecialchars($detalle['cantidad']) . "; ";
            echo "Precio Unitario: $" . number_format($detalle['precio_unitario'], 0, ',', '.') . "; ";
            echo "Total: $" . number_format($detalle['total'], 0, ',', '.') . "<br>";
        }
    } else {
        echo "Sin detalles";
    }
    ?>
</td>
                        </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <a href="?download=true&user_id=<?php echo $user_id; ?>" class="btn btn-primary">Descargar Historial en PDF</a>
        <a href="javascript:history.back()" class="btn btn-secondary">Volver Atrás</a>
    </div>
</body>
</html>
