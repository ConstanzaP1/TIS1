<?php
require('../vendor/autoload.php');
use Transbank\Webpay\WebpayPlus\Transaction;
use FPDF;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Asume que tienes una conexión a la base de datos establecida
$conn = new mysqli("localhost", "root", "", "proyecto_tis1");

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$token = $_GET['token_ws'];
$response = (new Transaction)->commit($token);

if ($response->isApproved()) {
    // Asumimos que has guardado el ID de la orden de compra en algún lugar
    $id_orden = $_SESSION['id_orden']; // Ajusta esto según cómo manejes las órdenes

    // Obtener los detalles de la orden
    $sql = "SELECT oc.id_orden, oc.fecha, oc.forma_pago, oc.correo, oc.detalle_orden_precio, 
                   p.id_producto, p.nombre_producto, p.precio
            FROM orden_compra oc
            JOIN asocia a ON oc.id_orden = a.id_orden
            JOIN producto p ON a.id_producto = p.id_producto
            WHERE oc.id_orden = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_orden);
    $stmt->execute();
    $result = $stmt->get_result();

    // Crear la boleta
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(0, 10, 'Boleta de Compra', 0, 1, 'C');
    $pdf->Ln(10);

    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 10, 'Código de autorización: ' . $response->getAuthorizationCode(), 0, 1);
    
    // Detalles de la orden
    if ($row = $result->fetch_assoc()) {
        $pdf->Cell(0, 10, 'Fecha: ' . $row['fecha'], 0, 1);
        $pdf->Cell(0, 10, 'Forma de pago: ' . $row['forma_pago'], 0, 1);
        $pdf->Cell(0, 10, 'Correo: ' . $row['correo'], 0, 1);
    }
    $pdf->Ln(10);

    // Encabezados de la tabla
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(30, 10, 'ID', 1);
    $pdf->Cell(100, 10, 'Producto', 1);
    $pdf->Cell(60, 10, 'Precio', 1);
    $pdf->Ln();

    // Reiniciar el puntero del resultado
    $result->data_seek(0);
    
    // Detalles de los productos
    $pdf->SetFont('Arial', '', 12);
    $total = 0;
    while ($row = $result->fetch_assoc()) {
        $pdf->Cell(30, 10, $row['id_producto'], 1);
        $pdf->Cell(100, 10, $row['nombre_producto'], 1);
        $pdf->Cell(60, 10, '$' . number_format($row['precio'], 2), 1);
        $pdf->Ln();
        $total += $row['precio'];
    }

    // Total
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(130, 10, 'Total', 1);
    $pdf->Cell(60, 10, '$' . number_format($total, 2), 1);

    // Guardar el PDF
    $pdfPath = 'boletas/boleta_' . $response->getAuthorizationCode() . '.pdf';
    $pdf->Output('F', $pdfPath);

    // Código para enviar el correo
    $mail = new PHPMailer(true);
    try {
        //Configuración del servidor
        $mail->isSMTP();
        $mail->Host       = 'smtp.example.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'tu_correo@example.com';
        $mail->Password   = 'tu_contraseña';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        //Destinatarios
        $mail->setFrom('from@example.com', 'Tu Tienda');
        $mail->addAddress($row['correo']); // Usamos el correo del cliente de la orden

        //Contenido
        $mail->isHTML(true);
        $mail->Subject = 'Boleta de tu compra';
        $mail->Body    = 'Gracias por tu compra. Adjuntamos la boleta.';

        //Adjuntar la boleta
        $mail->addAttachment($pdfPath);

        $mail->send();
        $mensajeCorreo = 'Se ha enviado un correo con la boleta.';
    } catch (Exception $e) {
        $mensajeCorreo = "No se pudo enviar el correo. Error: {$mail->ErrorInfo}";
    }

    // Cerrar la conexión y liberar recursos
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pago Exitoso</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container my-4">
    <div class="alert alert-success text-center" role="alert">
        <?php if ($response->isApproved()): ?>
            <h1 class="alert-heading">¡Pago Exitoso!</h1>
            <p>Tu pago ha sido aprobado. Código de autorización: <strong><?php echo $response->getAuthorizationCode(); ?></strong></p>
            <p><?php echo $mensajeCorreo; ?></p>
            <hr>
            <p class="mb-0">Gracias por tu compra. Puedes volver al <a href="../index.php" class="alert-link">catálogo</a>.</p>
        <?php else: ?>
            <h1 class="alert-heading">¡Pago Fallido!</h1>
            <p>El pago no fue aprobado.</p>
        <?php endif; ?>
    </div>
</body>
</html>