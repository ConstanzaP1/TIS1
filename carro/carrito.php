<?php
session_start();

include '../conexion.php'; // Asegúrate de que la ruta sea correcta

if (!$conexion) {
    die("Error: la conexión no se ha establecido correctamente.");
}

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../login/login.php');
    exit;
}

$id_usuario = $_SESSION['user_id'];

// Consulta para obtener los productos en el carrito del usuario junto con sus características y precio
$query = "
    SELECT carrito.id AS carrito_id, producto.nombre_producto, producto.precio, carrito.cantidad, producto_caracteristica.caracteristica 
    FROM carrito
    JOIN producto ON carrito.id_producto = producto.id_producto
    JOIN producto_caracteristica ON producto.id_producto = producto_caracteristica.id_producto
    WHERE carrito.id_usuario = ?
";

$stmt = $conexion->prepare($query);

if (!$stmt) {
    die("Error en la preparación de la consulta: " . $conexion->error);
}

// Bind de parámetros
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "Tu carrito está vacío.";
} else {
    echo "<h2>Tu Carrito</h2>";
    echo "<table>";
    echo "<tr><th>Producto</th><th>Precio</th><th>Cantidad</th><th>Total</th><th>Características</th><th>Acciones</th></tr>";
    
    $total_carrito = 0;
    while ($row = $result->fetch_assoc()) {
        $subtotal = $row['precio'] * $row['cantidad'];
        $total_carrito += $subtotal;

        echo "<tr>";
        echo "<td>{$row['nombre_producto']}</td>";
        echo "<td>$" . number_format($row['precio'], 2) . "</td>";
        echo "<td>
                <form action='actualizar_carrito.php' method='POST'>
                    <input type='hidden' name='carrito_id' value='{$row['carrito_id']}'>
                    <input type='number' name='cantidad' value='{$row['cantidad']}' min='1'>
                    <button type='submit'>Actualizar</button>
                </form>
              </td>";
        echo "<td>$" . number_format($subtotal, 2) . "</td>";
        echo "<td>{$row['caracteristica']}</td>";
        echo "<td>
                <form action='eliminar_del_carrito.php' method='POST'>
                    <input type='hidden' name='carrito_id' value='{$row['carrito_id']}'>
                    <button type='submit'>Eliminar</button>
                </form>
              </td>";
        echo "</tr>";
    }
    echo "<tr><td colspan='4'><strong>Total:</strong></td><td>$" . number_format($total_carrito, 2) . "</td><td></td></tr>";
    echo "</table>";
    
    // Botón para proceder al pago
    echo "<form action='procesar_pago.php' method='POST'>";
    echo "<button type='submit'>Proceder al Pago</button>";
    echo "</form>";
}

$stmt->close();
$conexion->close();
?>
