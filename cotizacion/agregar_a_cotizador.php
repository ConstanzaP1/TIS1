<?php
session_start();
require('../conexion.php'); // Conexión a la base de datos

// Verificar si se envió el formulario
if (isset($_POST['agregar_cotizador'])) {
    $id_producto = $_POST['id_producto'];

    // Verificar si el cotizador ya existe en la sesión
    if (!isset($_SESSION['cotizador'])) {
        $_SESSION['cotizador'] = []; // Inicializar el cotizador
    }

    // Verificar si el producto ya está en el cotizador
    if (!in_array($id_producto, $_SESSION['cotizador'])) {
        // Si no está, lo agregamos al cotizador
        $_SESSION['cotizador'][] = $id_producto;
    }

    // Redirigir al cotizador o a otra página
    header('Location: ../cotizacion/cotizador.php');
    exit(); // Asegúrate de terminar el script después de redirigir
} else {
    // Manejar el caso donde el botón no fue presionado correctamente
    echo "No se pudo agregar el producto al cotizador.";
}
?>
