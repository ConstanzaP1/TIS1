<?php
session_start();
require('../conexion.php');
require('../vendor/setasign/fpdf/fpdf.php');

// Verificar si la transacción fue exitosa y si el carrito tiene datos
$detalle_compra = $_SESSION['detalle_compra'] ?? null;

if (isset($_GET['status']) && $_GET['status'] === 'success' && $detalle_compra) {
    foreach ($detalle_compra as $id_producto => $cantidad) {
        $id_producto = mysqli_real_escape_string($conexion, $id_producto);
        $cantidad = (int)$cantidad;

        // Reducir el stock en la base de datos
        $query = "UPDATE producto SET cantidad = cantidad - $cantidad WHERE id_producto = '$id_producto' AND cantidad >= $cantidad";
        mysqli_query($conexion, $query);
    }

    // Guardar los detalles de la compra para el PDF
    $_SESSION['pdf_detalle_compra'] = $detalle_compra;

    // Limpiar la sesión del carrito después de completar la compra
    unset($_SESSION['carrito']);
    unset($_SESSION['detalle_compra']);
}

function generarPDF($detalle_compra, $conexion, $total) {
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 16);

    // Encabezado del PDF
    $pdf->Cell(190, 10, 'Boleta de Compra - Componentes de Computadora', 0, 1, 'C');
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(190, 10, 'Fecha: ' . date('d/m/Y'), 0, 1, 'C');
    $pdf->Ln(10);

    // Tabla de productos
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(80, 10, 'Producto', 1);
    $pdf->Cell(30, 10, 'Cantidad', 1);
    $pdf->Cell(40, 10, 'Precio Unitario', 1);
    $pdf->Cell(40, 10, 'Total', 1);
    $pdf->Ln();

    $pdf->SetFont('Arial', '', 12);
    foreach ($detalle_compra as $id_producto => $cantidad) {
        $result = mysqli_query($conexion, "SELECT nombre_producto, precio FROM producto WHERE id_producto = '$id_producto'");
        $producto = mysqli_fetch_assoc($result);
        $nombre_producto = $producto['nombre_producto'];
        $precio_unitario = $producto['precio'];
        $precio_total = $precio_unitario * $cantidad;

        $pdf->Cell(80, 10, $nombre_producto, 1);
        $pdf->Cell(30, 10, $cantidad, 1, 0, 'C');
        $pdf->Cell(40, 10, "$" . number_format($precio_unitario, 0, ',', '.'), 1, 0, 'R');
        $pdf->Cell(40, 10, "$" . number_format($precio_total, 0, ',', '.'), 1, 0, 'R');
        $pdf->Ln();
    }

    // Total
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(150, 10, 'Total a pagar', 1, 0, 'R');
    $pdf->Cell(40, 10, "$" . number_format($total, 0, ',', '.'), 1, 0, 'R');

    $pdf->Output('I', 'Boleta_Compra.pdf');
}

// Verificar si se solicita descargar el PDF
if (isset($_GET['descargar']) && $_GET['descargar'] === 'pdf') {
    $detalle_compra = $_SESSION['pdf_detalle_compra'] ?? [];
    $total = 0;

    // Calcular el total
    foreach ($detalle_compra as $id_producto => $cantidad) {
        $result = mysqli_query($conexion, "SELECT precio FROM producto WHERE id_producto = '$id_producto'");
        $producto = mysqli_fetch_assoc($result);
        $total += $producto['precio'] * $cantidad;
    }

    generarPDF($detalle_compra, $conexion, $total);
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Boleta de Compra - Componentes de Computadora</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container py-5">
    <h2 class="mb-4">Boleta de Compra - Componentes de Computadora</h2>

    <?php if (isset($_GET['status']) && $_GET['status'] == 'success' && isset($_SESSION['pdf_detalle_compra'])): ?>
        <p class="alert alert-success">Transacción exitosa. Código de autorización: <?php echo htmlspecialchars($_GET['auth_code']); ?></p>
        
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio Unitario</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $total = 0;
                foreach ($detalle_compra as $id_producto => $cantidad) {
                    $result = mysqli_query($conexion, "SELECT nombre_producto, precio FROM producto WHERE id_producto = '$id_producto'");
                    $producto = mysqli_fetch_assoc($result);
                    $nombre_producto = $producto['nombre_producto'];
                    $precio_unitario = $producto['precio'];
                    $precio_total = $precio_unitario * $cantidad;
                    $total += $precio_total;

                    echo "<tr>
                            <td>{$nombre_producto}</td>
                            <td>{$cantidad}</td>
                            <td>$" . number_format($precio_unitario, 0, ',', '.') . "</td>
                            <td>$" . number_format($precio_total, 0, ',', '.') . "</td>
                          </tr>";
                }
                ?>
            </tbody>
        </table>
        <p><strong>Total a pagar:</strong> $<?php echo number_format($total, 0, ',', '.'); ?></p>

        <a href="?descargar=pdf" class="btn btn-primary mt-3" target="_blank">Descargar Boleta en PDF</a>

    <?php elseif (isset($_GET['status']) && $_GET['status'] == 'failed'): ?>
        <p class="alert alert-danger">La transacción no fue exitosa. Por favor, intenta de nuevo.</p>
    <?php else: ?>
        <p class="alert alert-warning">No se encontraron datos de compra.</p>
    <?php endif; ?>

    <a href="../index.php" class="btn btn-secondary mt-3">Volver al Catálogo</a>
</div>
</body>
</html>
