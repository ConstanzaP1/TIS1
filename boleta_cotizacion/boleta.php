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

        // Guardar el detalle de cada producto en un array, incluyendo id_producto
        $detalle_boleta[] = [
            'id_producto' => $id_producto,
            'producto' => $nombre_producto,
            'cantidad' => $cantidad,
            'precio_unitario' => $precio_unitario,
            'total' => $precio_total
        ];
    }

    // Convertir el detalle de la compra en JSON para guardarlo en la base de datos
    $detalle_boleta_json = json_encode($detalle_boleta);

    // Establecer la zona horaria de Santiago
    date_default_timezone_set('America/Santiago');

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

    // Obtener el ID de la boleta recién insertada y guardarlo en la sesión
    $id_boleta = mysqli_insert_id($conexion);
    $_SESSION['id_boleta'] = $id_boleta;

    // Guardar los detalles de la compra para el PDF
    $_SESSION['pdf_detalle_compra'] = $detalle_compra;

    // Insertar los detalles de cada producto en la tabla `detalle_boletas`
    foreach ($detalle_boleta as $detalle) {
        $id_producto = mysqli_real_escape_string($conexion, $detalle['id_producto']);
        $cantidad = $detalle['cantidad'];
        $precio_unitario = $detalle['precio_unitario'];
        $precio_total = $detalle['total'];

        $query_detalle = "INSERT INTO detalle_boletas (id_boleta, id_producto, cantidad, precio_unitario, precio_total) 
                          VALUES ('$id_boleta', '$id_producto', '$cantidad', '$precio_unitario', '$precio_total')";

        // Ejecutar la consulta y verificar si hay errores
        if (!mysqli_query($conexion, $query_detalle)) {
            die("Error al guardar el detalle de la boleta en la base de datos: " . mysqli_error($conexion));
        }
    }

    // Limpiar la sesión del carrito después de completar la compra
    unset($_SESSION['carrito']);
    unset($_SESSION['detalle_compra']);
}

function generarPDF($detalle_compra, $conexion, $total) {
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->SetFillColor(33, 37, 41);
    $pdf->SetTextColor(255, 255, 255);

    // Encabezado del PDF
    $pdf->Cell(190, 10, 'Boleta de Compra - Componentes de Computadora', 0, 1, 'C', true);
    $pdf->SetFont('Arial', '', 12);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Cell(190, 10, 'Fecha: ' . date('d/m/Y'), 0, 1, 'C');
    $pdf->Ln(10);

    // Tabla de productos
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->SetFillColor(220, 220, 220);
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
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead class="table-dark">
                            <!-- Fila para mostrar "Información de la compra" como título -->
                            <tr>
                                <th colspan="6" class="text-center">Información de la compra</th>
                            </tr>
                            <!-- Encabezados de la tabla con nombres ajustados -->
                            <tr>
                                <th style="width: 10%;">Codigo Autorización</th>
                                <th style="width: 10%;">N° Boleta</th>
                                <th>Producto</th>
                                <th>Cantidad</th>
                                <th>Precio Unitario</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $total = 0;
                            $primera_fila = true;
                            foreach ($detalle_compra as $id_producto => $cantidad) {
                                // Mostrar Código de Autorización y N° de Boleta solo en la primera fila
                                if ($primera_fila) {
                                    echo "<tr>
                                            <td>" . htmlspecialchars($_GET['auth_code']) . "</td>
                                            <td>" . $_SESSION['id_boleta'] . "</td>";
                                    $primera_fila = false;
                                } else {
                                    echo "<tr><td></td><td></td>";
                                }

                                // Obtener información del producto
                                $result = mysqli_query($conexion, "SELECT nombre_producto, precio FROM producto WHERE id_producto = '$id_producto'");
                                $producto = mysqli_fetch_assoc($result);
                                $nombre_producto = $producto['nombre_producto'];
                                $precio_unitario = $producto['precio'];
                                $precio_total = $precio_unitario * $cantidad;
                                $total += $precio_total;

                                // Mostrar detalles del producto
                                echo "<td>{$nombre_producto}</td>
                                      <td>{$cantidad}</td>
                                      <td>$" . number_format($precio_unitario, 0, ',', '.') . "</td>
                                      <td>$" . number_format($precio_total, 0, ',', '.') . "</td>
                                      </tr>";
                            }
                            ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="5" class="text-end fw-bold">Total a pagar</td>
                                <td class="fw-bold">$<?php echo number_format($total, 0, ',', '.'); ?></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="d-flex justify-content-center">
                    <a href="?descargar=pdf" class="btn btn-primary mt-3" target="_blank">
                        Descargar Boleta en PDF
                    </a>
                </div>

                <?php unset($_SESSION['id_boleta']); // Limpiar el ID de la boleta de la sesión ?>
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
