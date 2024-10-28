<?php
require('../vendor/autoload.php');
use Transbank\Webpay\WebpayPlus\Transaction;

$token = $_GET['token_ws'];
$response = (new Transaction)->commit($token);

if ($response->isApproved()) {
    echo "Pago exitoso. Código de autorización: " . $response->getAuthorizationCode();
    // Aquí puedes vaciar el carrito y actualizar el estado del pedido en la base de datos
} else {
    echo "El pago no fue aprobado.";
}
?>
