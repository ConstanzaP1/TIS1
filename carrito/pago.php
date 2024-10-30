p
@@ -0,0 +1,71 @@
<?php
session_start();
require('../vendor/autoload.php');
use Transbank\Webpay\WebpayPlus\Transaction;

// Configurar Transbank para el entorno de integración
Transbank\Webpay\WebpayPlus::configureForTesting();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['pagar'])) {
    // Calcular el monto total del carrito
    $total = 0;
    foreach ($_SESSION['carrito'] as $id_producto => $cantidad) {
        require('../conexion.php');
        $query = "SELECT precio FROM producto WHERE id_producto = '$id_producto'";
        $result = mysqli_query($conexion, $query);
        $producto = mysqli_fetch_assoc($result);
        $precio_total = $producto['precio'] * $cantidad;
        $total += $precio_total;
    }

    // Iniciar la transacción
    $transaction = new Transaction();
    $response = $transaction->create(
        session_id(), // ID de sesión
        uniqid(), // Orden de compra única
        $total, // Monto total
        'http://localhost/xampp/TIS1/TIS1/carrito/carrito.php', // Cambia esta URL a tu dominio o entorno local
        'http://localhost/xampp/TIS1/TIS1/carrito/carrito.php' // Cambia esta URL a tu dominio o entorno local
    );

    if ($response) {
        header("Location: " . $response->getUrl() . "?token_ws=" . $response->getToken());
        exit;
    } else {
        echo "Hubo un problema al iniciar la transacción con Transbank.";
    }
} elseif (isset($_GET['token_ws'])) {
    // Manejo de respuesta de Transbank
    $token = $_GET['token_ws'];
    $transaction = new Transaction();
    $response = $transaction->commit($token);

    if ($response->isApproved()) {
        echo "Pago exitoso. Código de autorización: " . $response->getAuthorizationCode();
        // Aquí puedes vaciar el carrito y actualizar el estado del pedido en la base de datos
        unset($_SESSION['carrito']);
    } else {
        echo "El pago no fue aprobado.";
    }
} else {
    // Mostrar el formulario de pago
    ?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Proceder al Pago</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body class="container my-4">
        <h2>Proceder al Pago</h2>
        <form method="POST" action="pago.php">
            <button type="submit" name="pagar" class='btn btn-primary'>Pagar</button>
        </form>
        <a href="carrito.php" class='btn btn-secondary mt-3'>Volver al Carrito</a>
    </body>
    </html>
    <?php
}
?>