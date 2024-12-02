<?php
session_start();
require('../conexion.php');
require('../vendor/setasign/fpdf/fpdf.php');
require('../vendor/autoload.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$correoE = $_SESSION['email'];
$username = $_SESSION['username'];

// Verificar si el usuario está en sesión y obtener el ID del usuario
$id_usuario = $_SESSION['user_id'] ?? null; // Cambiado a 'user_id'

if ($id_usuario === null) {
    die("Error: El ID del usuario no está definido en la sesión.");
}

// Verificar si la transacción fue exitosa y si el carrito tiene datos
$detalle_compra = $_SESSION['detalle_compra'] ?? null;

if (isset($_GET['status']) && $_GET['status'] === 'success' && $detalle_compra) {
    $total = 0;
    $detalle_boleta = [];

    // Establecer la zona horaria de Santiago
    date_default_timezone_set('America/Santiago');
    $fecha = date('Y-m-d H:i:s');
    $codigo_autorizacion = mysqli_real_escape_string($conexion, $_GET['auth_code']);

    // Insertar la boleta en la base de datos
    $query_boleta = "INSERT INTO boletas (id_usuario, fecha, total, codigo_autorizacion, detalles) 
                     VALUES ('$id_usuario', '$fecha', '$total', '$codigo_autorizacion', '" . json_encode($detalle_boleta) . "')";
    
    if (!mysqli_query($conexion, $query_boleta)) {
        die("Error al guardar la boleta en la base de datos: " . mysqli_error($conexion));
    }

    $id_boleta = mysqli_insert_id($conexion);  // Obtener el id_boleta recién insertado
    $_SESSION['id_boleta'] = $id_boleta;

    // Procesar los productos en el carrito y reducir stock
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

        // Insertar la venta en la tabla ventas
        $query_venta = "INSERT INTO ventas (id_producto, nombre_producto, cantidad, precio_unitario, total, id_boleta) 
                        VALUES ('$id_producto', '$nombre_producto', '$cantidad', '$precio_unitario', '$precio_total', '$id_boleta')";
        mysqli_query($conexion, $query_venta);
    }

    // Actualizar el total de la boleta
    $query_update_boleta = "UPDATE boletas SET total = '$total' WHERE id_boleta = '$id_boleta'";
    mysqli_query($conexion, $query_update_boleta);

    // Agregar el registro al historial de compras
    $query_historial = "INSERT INTO historial_compras (id_usuario, id_boleta, total) VALUES ('$id_usuario', '$id_boleta', '$total')";
    if (!mysqli_query($conexion, $query_historial)) {
        die("Error al guardar en el historial de compras: " . mysqli_error($conexion));
    }
   // Crear el PDF
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 18);

    // Insertar logo de Tisnology (asegúrate de que la ruta al logo sea correcta)
    $pdf->Image('../logopng.png', 10, 10, 50); // Ajusta la posición y tamaño del logo
    $pdf->Ln(30); // Salto de línea para dar espacio al contenido principal

    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(0, 10, utf8_decode('¡Gracias por tu compra, ' . $username . '!'), 0, 1, 'C');
    $pdf->Ln(5);

    $pdf->SetFont('Arial', '', 12);
    $pdf->MultiCell(0, 10, utf8_decode("Hemos recibido tu pedido y te enviamos la boleta de compra. A continuación, los detalles de tu pedido:"), 0, 'C');
    $pdf->Ln(10);


    // Detalles de la boleta
    $pdf->SetFont('Arial', 'B', 14);
    $pdf->Cell(0, 10, 'Detalle de tu compra', 0, 1, 'L');
    $pdf->Ln(5);

    // Tabla de productos
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
    $pdf->Ln(10);

    // Agregar mensaje final
    $pdf->SetFont('Arial', '', 12);
    $pdf->MultiCell(0, 10, "Gracias por elegir Tisnology. Si tienes alguna consulta, no dudes en contactarnos.", 0, 'C');

    // Guardar el PDF en memoria
    $pdf_content = $pdf->Output('S');

    // Enviar PDF por correo
    $mail = new PHPMailer(true);
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

    $mail->Subject = 'Boleta de Compra - Tisnology';
    $mail->Body = "Estimado $username,\n\nGracias por su compra.\n\nAdjuntamos su boleta de compra en formato PDF.¡Gracias por su preferencia!";
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
