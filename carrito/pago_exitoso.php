<?php
require('../vendor/autoload.php');
use Transbank\Webpay\WebpayPlus\Transaction;

$token = $_GET['token_ws'];
$response = (new Transaction)->commit($token);

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
            <hr>
            <p class="mb-0">Gracias por tu compra. Puedes volver al <a href="../index.php" class="alert-link">catálogo</a>.</p>
            <?php unset($_SESSION['carrito']); // Vaciar el carrito ?>
        <?php else: ?>
            <h1 class="alert-heading">¡Pago Fallido!</h1>
            <p>El pago no fue aprobado.</p>
        <?php endif; ?>
    </div>
</body>
</html>
