<?php
session_start();
require('../conexion.php');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

function get_ws($data, $method, $type, $endpoint) {
    $curl = curl_init();
    if ($type == 'live') {
        // Producción
        $TbkApiKeyId = '597055555532';
        $TbkApiKeySecret = '579B532A7440BB0C9079DED94D31EA1615BACEB56610332264630D42D0A36B1C';
        $url = "https://webpay3g.transbank.cl" . $endpoint; // Live
    } else {
        // Testing
        $TbkApiKeyId = '597055555532';
        $TbkApiKeySecret = '579B532A7440BB0C9079DED94D31EA1615BACEB56610332264630D42D0A36B1C';
        $url = "https://webpay3gint.transbank.cl" . $endpoint; // Testing
    }
    curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => $method,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $data,
        CURLOPT_HTTPHEADER => array(
            'Tbk-Api-Key-Id: ' . $TbkApiKeyId,
            'Tbk-Api-Key-Secret: ' . $TbkApiKeySecret,
            'Content-Type: application/json'
        ),
    ));

    $response = curl_exec($curl);
    if (curl_errno($curl)) {
        // Si hay un error en la conexión, redirigir al index.php con un mensaje
        header("Location: ../index.php?error=Error en la conexión con Webpay");
        exit;
    }
    curl_close($curl);
    return json_decode($response);
}

$baseurl = "https://" . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
$action = isset($_GET["action"]) ? $_GET["action"] : 'init';
$message = null;
$url_tbk = "";

// Verificar que el total esté configurado en la sesión antes de proceder
if (!isset($_SESSION['total']) || $_SESSION['total'] <= 0) {
    header("Location: ../index.php?error=No se encontraron datos de compra o el total es inválido");
    exit;
}

switch ($action) {
    case "init":
        $buy_order = rand();
        $session_id = rand();
        $amount = $_SESSION['total'];
        $return_url = $baseurl . "?action=getResult";
        $type = "sandbox";
        $data = json_encode([
            "buy_order" => $buy_order,
            "session_id" => $session_id,
            "amount" => $amount,
            "return_url" => $return_url
        ]);
        $method = 'POST';
        $endpoint = '/rswebpaytransaction/api/webpay/v1.0/transactions';
        
        $response = get_ws($data, $method, $type, $endpoint);
        
        if (isset($response->url, $response->token)) {
            $url_tbk = $response->url;
            $token = $response->token;
            echo "<form id='webpay_form' method='POST' action='$url_tbk'>";
            echo "<input type='hidden' name='token_ws' value='$token'>";
            echo "<button type='submit' class='btn btn-primary'>Continuar a Webpay</button>";
            echo "</form>";
            echo "<script>document.getElementById('webpay_form').submit();</script>";
        } else {
            header("Location: ../index.php?error=Error al iniciar la transacción con Webpay");
            exit;
        }
        break;

    case "getResult":
        $token = $_POST['token_ws'] ?? $_GET['token_ws'] ?? null;
        
        if (!$token) {
            header("Location: ../index.php?error=No se recibió el token de Webpay");
            exit;
        }

        $data = '';
        $method = 'PUT';
        $endpoint = '/rswebpaytransaction/api/webpay/v1.0/transactions/' . $token;

        $response = get_ws($data, $method, 'sandbox', $endpoint);

        // Redirigir a boleta con mensaje de transacción exitosa
        if (isset($response->status) && $response->status == 'AUTHORIZED') {
            $_SESSION['detalle_compra'] = $_SESSION['carrito']; // Almacena el carrito actual en la sesión para usar en boleta.php
            header("Location: ../boleta_cotizacion/boleta.php?status=success&auth_code={$response->authorization_code}");
            exit;
        } else {
            header("Location: ../index.php?error=La transacción no fue autorizada");
            exit;
        }
        break;

    default:
        header("Location: ../index.php?error=Acción no reconocida");
        exit;
}
?>
