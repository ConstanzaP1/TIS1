<?php
session_start();
require('../conexion.php');
require('../vendor/setasign/fpdf/fpdf.php');
require('../vendor/autoload.php'); // Asegúrate de incluir Composer y PHPMailer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$correoE = $_SESSION['email'];
$username= $_SESSION['username'];


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

    if (!mysqli_query($conexion, $query_boleta)) {
        die("Error al guardar la boleta en la base de datos: " . mysqli_error($conexion));
    }

    $id_boleta = mysqli_insert_id($conexion);
    $_SESSION['id_boleta'] = $id_boleta;

    // Crear y generar el PDF en memoria
    ob_start();
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->SetFillColor(33, 37, 41);
    $pdf->SetTextColor(255, 255, 255);
    $pdf->Cell(190, 10, 'Boleta de Compra - Componentes de Computadora', 0, 1, 'C', true);
    $pdf->SetFont('Arial', '', 12);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Cell(190, 10, 'Fecha: ' . date('d/m/Y'), 0, 1, 'C');
    $pdf->Ln(10);

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

    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(150, 10, 'Total a pagar', 1, 0, 'R');
    $pdf->Cell(40, 10, "$" . number_format($total, 0, ',', '.'), 1, 1, 'R');
    $pdf_content = $pdf->Output('S'); // Guardar el contenido del PDF en memoria
    ob_end_clean();

    // Configurar PHPMailer para enviar el correo con el PDF adjunto
    $mail = new PHPMailer(true);
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

        $mail->Subject = 'Boleta de Compra - Tisnology';
        $mail->Body = 'Estimado usuario, adjuntamos su boleta de compra en formato PDF. ¡Gracias por su compra!';

        // Adjuntar el PDF al correo
        $mail->addStringAttachment($pdf_content, 'Boleta_Compra.pdf');

        // Enviar correo
        $mail->send();
        echo 'La boleta ha sido enviada a su correo electrónico.';
        echo "<a href='../index.php' class='btn btn-secondary mt-3 rounded-pill px-5'>Volver al Catálogo</a>
                </div>";

    } catch (Exception $e) {
        echo "Error al enviar la boleta: {$mail->ErrorInfo}";
    }

    // Limpiar la sesión del carrito después de completar la compra
    unset($_SESSION['carrito']);
    unset($_SESSION['detalle_compra']);
}
?>
