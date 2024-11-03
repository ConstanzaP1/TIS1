<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Carga el autoload de Composer
require '../vendor/autoload.php';
require('../conexion.php'); 

// Inicializa el carrito si no existe
session_start();
if (empty($_SESSION['carrito'])) {
    echo "<p>No hay productos en el carrito para enviar en la cotización.</p>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['correo'])) {
    // Captura el correo del formulario
    $correoE = $_POST['correo'];

    // Crea una instancia de PHPMailer
    $mail = new PHPMailer(true);

    // Contenido del PDF de la cotización
    $total = 0;
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(0, 10, 'Cotizacion', 0, 1, 'C');
    $pdf->Ln(10);

    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(70, 10, 'Producto', 1);
    $pdf->Cell(30, 10, 'Cantidad', 1);
    $pdf->Cell(40, 10, 'Precio Unitario', 1);
    $pdf->Cell(40, 10, 'Subtotal', 1);
    $pdf->Ln();

    $pdf->SetFont('Arial', '', 12);
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
    $pdf->Ln();

    // Guardar el PDF en un archivo temporal
    $pdf_filename = '../boleta_cotizacion/cotizacion_carrito.pdf';
    $pdf->Output('F', $pdf_filename);

    try {
        // Configuración del servidor SMTP
        $mail->SMTPDebug = 0;
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'tisnology1@gmail.com';
        $mail->Password   = 'kkayajvlxqjtelsn';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // Configurar destinatario y remitente
        $mail->setFrom('tisnology1@gmail.com', 'Tisnology');
        $mail->addAddress($correoE);

        // Adjuntar el PDF
        $mail->addAttachment($pdf_filename, 'Cotizacion_Carrito.pdf');

        // Configuración del contenido del correo
        $mail->isHTML(true);
        $mail->Subject = 'Cotizacion de carrito';
        $mail->Body    = 'Adjunto encontrará la cotización de su carrito.';

        // Enviar el correo
        $mail->send();
        echo 'El correo con la cotización de su carrito ha sido enviado correctamente.';
        echo "<a href='../carrito/carrito.php' class='btn btn-secondary mt-3'>Volver al carrito</a>";

        // Eliminar el archivo temporal
        unlink($pdf_filename);
    } catch (Exception $e) {
        echo "No se pudo enviar el correo. Error: {$mail->ErrorInfo}";
    }
} else {
    echo "Por favor, envíe el formulario con un correo electrónico válido.";
}
?>
