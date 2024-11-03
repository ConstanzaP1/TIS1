<?php
session_start();
require('../conexion.php');
require('../vendor/setasign/fpdf/fpdf.php');

// Verificar si la transacción fue exitosa y si el carrito tiene datos
$detalle_compra = $_SESSION['detalle_compra'] ?? null;

if (isset($_GET['status']) && $_GET['status'] === 'success' && $detalle_compra) {
    $total = 0;
    $detalle_boleta = [];

    foreach ($detalle_compra as $id_producto => $cantidad) {
        $id_producto = mysqli_real_escape_string($conexion, $id_producto);
        $cantidad = (int)$cantidad;

        // Reducir el stock en la base de datos
        $query = "UPDATE producto SET cantidad = cantidad - $cantidad WHERE id_producto = '$id_producto' AND cantidad >= $cantidad";
        mysqli_query($conexion, $query);

        // Obtener información del producto para el detalle de la boleta
        $result = mysqli_query($conexion, "SELECT nombre_producto, precio FROM producto WHERE id_producto = '$id_producto'");
        $producto = mysqli_fetch_assoc($result);

        $nombre_producto = $producto['nombre_producto'];
        $precio_unitario = $producto['precio'];
        $precio_total = $precio_unitario * $cantidad;
        $total += $precio_total;

        // Guardar el detalle de cada producto en un array
        $detalle_boleta[] = [
            'producto' => $nombre_producto,
            'cantidad' => $cantidad,
            'precio_unitario' => $precio_unitario,
            'total' => $precio_total
        ];
    }

    // Convertir el detalle de la compra en JSON para guardarlo en la base de datos
    $detalle_boleta_json = json_encode($detalle_boleta);

    // Guardar la boleta en la base de datos
    $fecha = date('Y-m-d H:i:s');
    $codigo_autorizacion = mysqli_real_escape_string($conexion, $_GET['auth_code']);

    // Consulta para insertar en la tabla `boletas`
    $query_boleta = "INSERT INTO boletas (fecha, total, codigo_autorizacion, detalles) 
                     VALUES ('$fecha', '$total', '$codigo_autorizacion', '$detalle_boleta_json')";

    // Ejecutar la consulta e imprimir un mensaje de error si falla
    if (!mysqli_query($conexion, $query_boleta)) {
        die("Error al guardar la boleta en la base de datos: " . mysqli_error($conexion));
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
    $pdf->SetFillColor(33, 37, 41); // Color de fondo oscuro similar a Bootstrap
    $pdf->SetTextColor(255, 255, 255); // Texto blanco para el encabezado

    // Encabezado del PDF
    $pdf->Cell(190, 10, 'Boleta de Compra - Componentes de Computadora', 0, 1, 'C', true);
    $pdf->SetFont('Arial', '', 12);
    $pdf->SetTextColor(0, 0, 0); // Texto en color negro
    $pdf->Cell(190, 10, 'Fecha: ' . date('d/m/Y'), 0, 1, 'C');
    $pdf->Ln(10);

    // Tabla de productos
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->SetFillColor(220, 220, 220); // Fondo gris claro para encabezado de tabla
    $pdf->Cell(80, 10, 'Producto', 1, 0, 'C', true);
    $pdf->Cell(30, 10, 'Cantidad', 1, 0, 'C', true);
    $pdf->Cell(40, 10, 'Precio Unitario', 1, 0, 'C', true);
    $pdf->Cell(40, 10, 'Total', 1, 1, 'C', true);

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
        $pdf->Cell(40, 10, "$" . number_format($precio_total, 0, ',', '.'), 1, 1, 'R');
    }

    // Total
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(150, 10, 'Total a pagar', 1, 0, 'R');
    $pdf->Cell(40, 10, "$" . number_format($total, 0, ',', '.'), 1, 1, 'R');

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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boleta de Compra Tisnology</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container py-5">
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white text-center">
            <h2 class="mb-0">Boleta de Compra Tisnology</h2>
        </div>
        <div class="card-body">
            <?php if (isset($_GET['status']) && $_GET['status'] == 'success' && isset($_SESSION['pdf_detalle_compra'])): ?>
                <p class="alert alert-success text-center">
                    Transacción exitosa. Código de autorización: 
                    <strong><?php echo htmlspecialchars($_GET['auth_code']); ?></strong>
                </p>
                
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead class="table-dark">
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
                </div>
                <div class="text-end">
                    <p class="fw-bold fs-5">Total a pagar: $<?php echo number_format($total, 0, ',', '.'); ?></p>
                </div>

                <div class="d-flex justify-content-center">
                    <a href="?descargar=pdf" class="btn btn-primary mt-3" target="_blank">
                        Descargar Boleta en PDF
                    </a>
                </div>

            <?php elseif (isset($_GET['status']) && $_GET['status'] == 'failed'): ?>
                <p class="alert alert-danger text-center">La transacción no fue exitosa. Por favor, intenta de nuevo.</p>
            <?php else: ?>
                <p class="alert alert-warning text-center">No se encontraron datos de compra.</p>
            <?php endif; ?>

            <div class="text-center mt-4">
                <a href="../index.php" class="btn btn-secondary">Volver al Catálogo</a>
            </div>
        </div>
    </div>
</div>
</body>
</html>

