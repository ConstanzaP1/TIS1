<?php
session_start();
$id_usuario = $_SESSION['id_usuario'];
$id_producto = $producto['id'];

echo "<form action='agregar_al_carrito.php' method='POST'>";
echo "<input type='hidden' name='id_usuario' value='$id_usuario'>";
echo "<input type='hidden' name='id_producto' value='$id_producto'>";
echo "<label>Cantidad:</label>";
echo "<input type='number' name='cantidad' value='1' min='1'>";
echo "<button type='submit'>Agregar al carrito</button>";
echo "</form>";
?>
