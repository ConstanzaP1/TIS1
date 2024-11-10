<?php
session_start();
require('../vendor/autoload.php'); // Asegúrate de que esta ruta sea correcta
use Transbank\Webpay\WebpayPlus\Transaction;
require('../conexion.php'); // Conexión a la base de datos

// Resto de tu código aquí...


if (isset($_GET['token_ws'])) {
    $token = $_GET['token_ws'];
    $transaction = new Transaction();
    try {
        $response = $transaction->commit($token);
        if ($response->isApproved()) {
            $productos_comprados = json_encode($_SESSION['carrito']);
            $id_usuario = $_SESSION['id_usuario'] ?? null;

            // Calcular el total
            $total = array_sum(array_map(function($id_producto) {
                global $conexion;
                $query = "SELECT precio FROM producto WHERE id_producto = '$id_producto'";
                $resultado = mysqli_query($conexion, $query);
                $producto = mysqli_fetch_assoc($resultado);
                return isset($producto['precio']) ? $producto['precio'] * $_SESSION['carrito'][$id_producto] : 0;
            }, array_keys($_SESSION['carrito'])));

            // Actualizar cantidades de productos
            foreach ($_SESSION['carrito'] as $id_producto => $cantidad) {
                $query = "UPDATE producto SET cantidad = cantidad - $cantidad WHERE id_producto = '$id_producto'";
                mysqli_query($conexion, $query);
            }

            // Vaciar el carrito solo si existe en la sesión
            if (isset($_SESSION['carrito'])) {
                unset($_SESSION['carrito']);
            }

            // Redirigir a boleta.php con mensaje de éxito
            header("Location: ../boleta_cotizacion/boleta.php?status=success&auth_code=" . $response->getAuthorizationCode());
            exit;
        } else {
            // Redirigir a boleta.php con mensaje de rechazo
            header("Location: ../boleta_cotizacion/boleta.php?status=failed");
            exit;
        }
    } catch (Exception $e) {
        echo "Error al confirmar la transacción: " . $e->getMessage();
    }
}
?>
