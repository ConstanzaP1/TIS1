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
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(0, 10, 'Cotización', 0, 1, 'C');
    $pdf->Ln(10);

    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(70, 10, 'Producto', 1);
    $pdf->Cell(30, 10, 'Cantidad', 1);
    $pdf->Cell(40, 10, 'Precio Unitario', 1);
    $pdf->Cell(40, 10, 'Subtotal', 1);
    $pdf->Ln();

    foreach ($_SESSION['carrito'] as $id_producto => $cantidad) {
        $id_producto = mysqli_real_escape_string($conexion, $id_producto);
        $query = "SELECT nombre_producto, precio FROM producto WHERE id_producto = '$id_producto'";
        $result = mysqli_query($conexion, $query);
        $producto = mysqli_fetch_assoc($result);

        if ($producto) {
            $precio_total = $producto['precio'] * $cantidad;
            $total += $precio_total;

            $pdf->Cell(70, 10, $producto['nombre_producto'], 1);
            $pdf->Cell(30, 10, $cantidad, 1);
            $pdf->Cell(40, 10, '$' . number_format($producto['precio'], 0, ',', '.'), 1);
            $pdf->Cell(40, 10, '$' . number_format($precio_total, 0, ',', '.'), 1);
            $pdf->Ln();
        }
    }

    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(140, 10, 'Total a Pagar', 1);
    $pdf->Cell(40, 10, '$' . number_format($total, 0, ',', '.'), 1);
    $pdf_filename = '../boleta_cotizacion/cotizacion_productos.pdf';
    $pdf->Output('F', $pdf_filename);

    try {
        // Configuración SMTP y envío
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
        $mail->Body = 'Adjunto la cotización de sus productos.';

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
