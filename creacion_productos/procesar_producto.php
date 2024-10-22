<?php
require('../conexion.php');

// Recoger los datos generales del formulario
$nombre_producto = $_POST['nombre_producto'];
$precio = $_POST['precio'];
$cantidad = $_POST['cantidad'];
$categoria_producto = $_POST['categoria_producto']; // Debe ser 'teclado' en este caso

// Insertar los datos generales del producto en la tabla producto
$query_producto = "INSERT INTO producto (nombre_producto, precio, cantidad, tipo_producto) VALUES ('$nombre_producto', '$precio', '$cantidad', '$categoria_producto')";
if (mysqli_query($conexion, $query_producto)) {
    // Obtener el id del último producto insertado
    $id_producto = mysqli_insert_id($conexion);

    // Verificar si el producto es un teclado y tiene atributos seleccionados
    if (isset($_POST['tipo_teclado']) && isset($_POST['tipo_switch']) && isset($_POST['conectividad']) && isset($_POST['iluminacion'])) {
        
        // Capturamos los valores seleccionados en el formulario
        $tipo_teclado = $_POST['tipo_teclado'];    // Valor seleccionado del campo 'tipo_teclado' (por ejemplo: "Mecánico")
        $tipo_switch = $_POST['tipo_switch'];      // Valor seleccionado del campo 'tipo_switch' (por ejemplo: "Cherry MX")
        $conectividad = $_POST['conectividad'];    // Valor seleccionado del campo 'conectividad' (por ejemplo: "Inalámbrica")
        $iluminacion = $_POST['iluminacion'];      // Valor seleccionado del campo 'iluminacion' (por ejemplo: "RGB")

        // Crear un array de los atributos y sus valores correspondientes
        $atributos = [
            'tipo_teclado' => $tipo_teclado,  // "Mecánico"
            'tipo_switch' => $tipo_switch,    // "Cherry MX"
            'conectividad' => $conectividad,  // "Inalámbrica"
            'iluminacion' => $iluminacion     // "RGB"
        ];

        // Insertar cada atributo y su valor en la tabla producto_atributo
        foreach ($atributos as $atributo => $valor_atributo) {
            $query_atributo = "INSERT INTO producto_atributo (id_producto, atributo, valor_atributo) 
                               VALUES ('$id_producto', '$atributo', '$valor_atributo')";
            mysqli_query($conexion, $query_atributo);
        }
    }

    echo "Producto y atributos insertados correctamente.";
    ?>

    <button type="button" class="btn btn-primary" onclick="window.location.href='../admin_panel/admin_panel.php';">Aceptar</button>
    <?php
} else {
    echo "Error al insertar el producto: " . mysqli_error($conexion);
}
?>
