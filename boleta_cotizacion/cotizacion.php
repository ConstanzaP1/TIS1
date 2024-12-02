<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';
require('../conexion.php'); 

session_start();

if (empty($_SESSION['carrito'])) {
    echo json_encode([
        'status' => 'error',
        'message' => 'No hay productos en el carrito para enviar en la cotización.'
    ]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['correo'])) {
    $correoE = $_POST['correo'];
    $mail = new PHPMailer(true);
    $mail->CharSet = 'UTF-8';

    // Generar el PDF
    $total = 0;
    $pdf = new FPDF();
    $pdf->AddPage();

    // Encabezado con el logo de Tisnology
    $pdf->Image('../logopng.png', 10, 10, 50); // Ruta y tamaño del logo
    $pdf->Ln(30); // Salto de línea para dar espacio al contenido principal

    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(0, 10, utf8_decode('Cotización de Productos'), 0, 1, 'C');
    $pdf->Ln(10);

    // Tabla de productos
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->SetFillColor(230, 230, 230); // Fondo gris claro para el encabezado de la tabla
    $pdf->Cell(80, 10, 'Producto', 1, 0, 'C', true);
    $pdf->Cell(30, 10, 'Cantidad', 1, 0, 'C', true);
    $pdf->Cell(40, 10, 'Precio Unitario', 1, 0, 'C', true);
    $pdf->Cell(40, 10, 'Subtotal', 1, 1, 'C', true);

    // Detalle de productos
    $pdf->SetFont('Arial', '', 12);
    foreach ($_SESSION['carrito'] as $id_producto => $cantidad) {
        $id_producto = mysqli_real_escape_string($conexion, $id_producto);
        $query = "SELECT nombre_producto, precio FROM producto WHERE id_producto = '$id_producto'";
        $result = mysqli_query($conexion, $query);
        $producto = mysqli_fetch_assoc($result);

        if ($producto) {
            $precio_total = $producto['precio'] * $cantidad;
            $total += $precio_total;

            $pdf->Cell(80, 10, utf8_decode($producto['nombre_producto']), 1);
            $pdf->Cell(30, 10, $cantidad, 1, 0, 'C');
            $pdf->Cell(40, 10, '$' . number_format($producto['precio'], 0, ',', '.'), 1, 0, 'R');
            $pdf->Cell(40, 10, '$' . number_format($precio_total, 0, ',', '.'), 1, 1, 'R');
        }
    }

    // Total general
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(150, 10, 'Total a Pagar', 1, 0, 'R');
    $pdf->Cell(40, 10, '$' . number_format($total, 0, ',', '.'), 1, 1, 'R');
    $pdf->Ln(10);

    // Mensaje final
    $pdf->SetFont('Arial', '', 12);
    $pdf->MultiCell(0, 10, utf8_decode("Esta cotización tiene validez por 7 días. Si tienes alguna consulta, no dudes en contactarnos. ¡Gracias por elegir Tisnology!"), 0, 'C');

    // Guardar el PDF
    $pdf_filename = '../boleta_cotizacion/cotizacion_productos.pdf';
    $pdf->Output('F', $pdf_filename);

    // Enviar el correo
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'tisnology1@gmail.com';
        $mail->Password = 'ytfksqrqrginpvge';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('tisnology1@gmail.com', 'Tisnology');
        $mail->addAddress($correoE);
        $mail->addAttachment($pdf_filename, 'Cotizacion_productos.pdf');
        $mail->isHTML(true);
        $mail->Subject = 'Cotización de productos';
        $mail->Body = '<p>Adjunto encontrará la cotización de los productos seleccionados.</p>';

        $mail->send();
        unlink($pdf_filename);

        echo json_encode([
            'status' => 'success',
            'message' => 'La cotización se envió exitosamente al correo: ' . $correoE
        ]);
    } catch (Exception $e) {
        echo json_encode([
            'status' => 'error',
            'message' => 'No se pudo enviar la cotización. Intente nuevamente.'
        ]);
    }
} else {
    echo json_encode([
        'status' => 'info',
        'message' => 'Por favor, envíe el formulario con un correo válido.'
    ]);
}
