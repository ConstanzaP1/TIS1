<?php
require('conexion.php');

// Obtener los datos del formulario
$id_notebook = $_POST['id_notebook'];
$tipo_notebook = $_POST['tipo_notebook'];

// Procesar los datos según el tipo de periférico
if ($tipo_notebook == 'cpu_notebook') {
    $cpu_notebook = $_POST['cpu_notebook'];
    $query = "UPDATE cpu_notebook SET cpu_notebook = '$cpu_notebook' WHERE id_notebook = '$id_notebook'";
} elseif ($tipo_notebook == 'gpu_notebook') {
    $gpu_notebook = $_POST['gpu_notebook'];
    $query = "UPDATE gpu_notebook SET gpu_notebook = '$gpu_notebook' WHERE id_notebook = '$id_notebook'";
} elseif ($tipo_notebook == 'pantalla_notebook') {
    $pantalla_notebook = $_POST['pantalla_notebook'];
    $query = "UPDATE pantalla_notebook SET pantalla_notebook = '$pantalla_notebook' WHERE id_notebook = '$id_notebook'";
} elseif ($tipo_notebook == 'bateria_notebook') {
    $bateria_notebook = $_POST['bateria_notebook'];
    $query = "UPDATE bateria_notebook SET bateria_notebook = '$bateria_notebook' WHERE id_notebook = '$id_notebook'";
} 

// Ejecutar la consulta
mysqli_query($conexion, $query);

// Verificar si la consulta se ejecutó correctamente
if (mysqli_affected_rows($conexion) > 0) {
    // Redireccionar a la página de inicio
    header('Location: index_notebook.php');
    exit;
} else {
    // Mostrar un mensaje de error
    echo "Error al actualizar el periférico.";
    exit;
}
?>