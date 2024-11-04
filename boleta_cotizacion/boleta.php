<?php
session_start();
require('../conexion.php');
require('../vendor/setasign/fpdf/fpdf.php');
require('../vendor/autoload.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$correoE = $_SESSION['email'];
$username = $_SESSION['username'];

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

        $detalle_boleta[] = [
            'producto' => $nombre_producto,
            'cantidad' => $cantidad,
            'precio_unitario' => $precio_unitario,
            'total' => $precio_total
        ];
    }

    // Establecer la zona horaria de Santiago
    date_default_timezone_set('America/Santiago');
    $fecha = date('Y-m-d H:i:s');
    $codigo_autorizacion = mysqli_real_escape_string($conexion, $_GET['auth_code']);
    $query_boleta = "INSERT INTO boletas (fecha, total, codigo_autorizacion, detalles) VALUES ('$fecha', '$total', '$codigo_autorizacion', '" . json_encode($detalle_boleta) . "')";

    if (!mysqli_query($conexion, $query_boleta)) {
        die("Error al guardar la boleta en la base de datos: " . mysqli_error($conexion));
    }

    $id_boleta = mysqli_insert_id($conexion);
    $_SESSION['id_boleta'] = $id_boleta;

    // Crear el PDF en memoria
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(0, 10, 'Boleta de Compra Tisnology', 0, 1, 'C');
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 10, 'ID Boleta: ' . $id_boleta, 0, 1);
    $pdf->Cell(0, 10, 'Fecha: ' . date('d/m/Y H:i', strtotime($fecha)), 0, 1);
    $pdf->Cell(0, 10, 'Codigo de Autorizacion: ' . $codigo_autorizacion, 0, 1);
    $pdf->Ln(10);

    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(80, 10, 'Producto', 1);
    $pdf->Cell(30, 10, 'Cantidad', 1, 0, 'C');
    $pdf->Cell(40, 10, 'Precio Unitario', 1, 0, 'R');
    $pdf->Cell(40, 10, 'Total', 1, 1, 'R');

    $pdf->SetFont('Arial', '', 12);
    foreach ($detalle_boleta as $item) {
        $pdf->Cell(80, 10, $item['producto'], 1);
        $pdf->Cell(30, 10, $item['cantidad'], 1, 0, 'C');
        $pdf->Cell(40, 10, "$" . number_format($item['precio_unitario'], 0, ',', '.'), 1, 0, 'R');
        $pdf->Cell(40, 10, "$" . number_format($item['total'], 0, ',', '.'), 1, 1, 'R');
    }

    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(150, 10, 'Total a Pagar', 1, 0, 'R');
    $pdf->Cell(40, 10, "$" . number_format($total, 0, ',', '.'), 1, 1, 'R');
    $pdf_content = $pdf->Output('S');

    // Enviar PDF por correo
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'tisnology1@gmail.com';
        $mail->Password = 'kkayajvlxqjtelsn';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('tisnology1@gmail.com', 'Tisnology');
        $mail->addAddress($correoE);

        $mail->Subject = 'Boleta de Compra - Tisnology';
        $mail->Body = 'Estimado usuario, adjuntamos su boleta de compra . ¡Gracias por su preferencia!';
        $mail->addStringAttachment($pdf_content, "Boleta_Compra_$id_boleta.pdf");

        $mail->send();

        echo "
        <script>
            window.addEventListener('load', function() {
                toastr.options = {
                    'closeButton': true,
                    'positionClass': 'toast-top-right',
                    'timeOut': '5000'
                };
                toastr.success('La boleta ha sido enviada a su correo electrónico.');
            });
        </script>";
    } catch (Exception $e) {
        echo "
        <script>
            window.addEventListener('load', function() {
                toastr.options = {
                    'closeButton': true,
                    'positionClass': 'toast-top-right',
                    'timeOut': '5000'
                };
                toastr.error('Error al enviar la boleta: {$mail->ErrorInfo}');
            });
        </script>";
    }

    // Mostrar la boleta en pantalla con opción de descarga
    echo "
    <!DOCTYPE html>
    <html lang='es'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Boleta de Compra</title>
        <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css' rel='stylesheet'>
        <link href='https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css' rel='stylesheet'/>
        <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js'></script>
        <script src='https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js'></script>
    </head>
    <body class='bg-light'>
        <div class='container my-5'>
            <div class='card'>
                <div class='card-header bg-primary text-white'>
                    <h4 class='mb-0'>Boleta de Compra</h4>
                </div>
                <div class='card-body'>
                    <p><strong>ID Boleta:</strong> $id_boleta</p>
                    <p><strong>Fecha:</strong> $fecha</p>
                    <p><strong>Código de Autorización:</strong> $codigo_autorizacion</p>
                    <hr>
                    <table class='table table-bordered'>
                        <thead class='table-light'>
                            <tr>
                                <th>Producto</th>
                                <th>Cantidad</th>
                                <th>Precio Unitario</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>";
                        foreach ($detalle_boleta as $item) {
                            echo "
                            <tr>
                                <td>{$item['producto']}</td>
                                <td>{$item['cantidad']}</td>
                                <td>$" . number_format($item['precio_unitario'], 0, ',', '.') . "</td>
                                <td>$" . number_format($item['total'], 0, ',', '.') . "</td>
                            </tr>";
                        }
                        echo "
                        </tbody>
                    </table>
                    <h5 class='text-end'>Total a Pagar: $" . number_format($total, 0, ',', '.') . "</h5>
                    <div class='text-center mt-4'>
                        <a href='data:application/pdf;base64," . base64_encode($pdf_content) . "' download='Boleta_Compra_$id_boleta.pdf' class='btn btn-primary'>Descargar Boleta en PDF</a>
                        <a href='../index.php' class='btn btn-secondary'>Volver al Catálogo</a>
                    </div>
                </div>
            </div>
        </div>
    </body>
    </html>";

    unset($_SESSION['carrito']);
    unset($_SESSION['detalle_compra']);
}
?>
