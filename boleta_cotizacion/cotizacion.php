<?php
// Importa las clases de PHPMailer en el espacio global
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Carga el autoload de Composer
require '../vendor/autoload.php';
require('../conexion.php'); // Conexión a la base de datos

// Inicializa el carrito si no existe (por ejemplo, después de una compra)
session_start();
if (empty($_SESSION['carrito'])) {
    echo "<p>No hay productos en el carrito para enviar en la boleta.</p>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['correo'])) {
    // Captura el correo del formulario
    $correoE = $_POST['correo'];

    // Crea una instancia de PHPMailer
    $mail = new PHPMailer(true);

    // Generar contenido HTML de la boleta
    $total = 0;
    $contenido_boleta = '<h2>Cotizacion</h2>';
    $contenido_boleta .= '<table border="1" cellpadding="10" cellspacing="0" style="width:100%; text-align:left;">';
    $contenido_boleta .= '<thead><tr><th>Producto</th><th>Cantidad</th><th>Precio Unitario</th><th>Subtotal</th></tr></thead>';
    $contenido_boleta .= '<tbody>';

    foreach ($_SESSION['carrito'] as $id_producto => $cantidad) {
        $id_producto = mysqli_real_escape_string($conexion, $id_producto); // Sanitizar ID del producto
        $query = "SELECT nombre_producto, precio FROM producto WHERE id_producto = '$id_producto'";
        $result = mysqli_query($conexion, $query);
        $producto = mysqli_fetch_assoc($result);

        if ($producto) {
            $precio_total = $producto['precio'] * $cantidad;
            $total += $precio_total;
            $contenido_boleta .= "<tr>
                                    <td>{$producto['nombre_producto']}</td>
                                    <td>{$cantidad}</td>
                                    <td>$" . number_format($producto['precio'], 0, ',', '.') . "</td>
                                    <td>$" . number_format($precio_total, 0, ',', '.') . "</td>
                                  </tr>";
        }
    }
    $contenido_boleta .= '</tbody>';
    $contenido_boleta .= '</table>';
    $contenido_boleta .= "<h4>Total a Pagar: $" . number_format($total, 0, ',', '.') . "</h4>";

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
        $mail->setFrom('tisnology1@gmail.com', 'Administrador');
        $mail->addAddress($correoE);

        // Configuración del contenido del correo
        $mail->isHTML(true);
        $mail->Subject = 'Cotizacion de carrito';
        $mail->Body    = $contenido_boleta;

        // Enviar el correo
        $mail->send();
        echo 'El correo con la boleta ha sido enviado correctamente.';
        echo "<a href='../carrito/carrito.php' class='btn btn-secondary mt-3'>Volver al carrito</a>";
    } catch (Exception $e) {
        echo "No se pudo enviar el correo. Error: {$mail->ErrorInfo}";
    }
} else {
    echo "Por favor, envíe el formulario con un correo electrónico válido.";
}
