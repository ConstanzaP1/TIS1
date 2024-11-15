<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    $filterOrder = $data['filters'];
    
    // Aquí puedes guardar $filterOrder en la base de datos o en sesión, según lo necesites.
    echo json_encode(['status' => 'success', 'order' => $filterOrder]);
}
?>
