<?php
require('conexion.php');

// Si se envía el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tipo_notebook = $_POST['tipo_notebook'];

    // Insertar solo el ID (auto-incremental) en la tabla notebook
    $queryNotebook = "INSERT INTO notebook () VALUES ()"; // No especificamos id_notebook

    if (mysqli_query($conexion, $queryNotebook)) {
        // Obtener el último id_notebook insertado
        $id_notebook = mysqli_insert_id($conexion);

        // Dependiendo del tipo de notebook, insertamos los valores en las tablas correspondientes
        if ($tipo_notebook == 'cpu_notebook') {
            $cpu_notebook = $_POST['cpu_notebook'];

            // Insertar en las tablas asociadas para tarjetas de video
            $queryCpu_notebook = "INSERT INTO cpu_notebook (id_notebook, cpu_notebook) VALUES ('$id_notebook', '$cpu_notebook')";

            if (mysqli_query($conexion, $queryCpu_notebook)) {
                echo "Ingreso exitoso.";
                header('location: admin_panel_notebook.php');
            } else {
                echo "Error al insertar." . mysqli_error($conexion);   
            }
            header('location: admin_panel_notebook.php');
        } elseif ($tipo_notebook == 'gpu_notebook') {
            $gpu_notebook = $_POST['gpu_notebook'];
            // Insertar en las tablas asociadas para procesadores
            $queryGpu_notebook = "INSERT INTO gpu_notebook (id_notebook, gpu_notebook) VALUES ('$id_notebook', '$gpu_notebook')";

            if (mysqli_query($conexion, $queryGpu_notebook)) {
                echo "Ingreso exitoso.";
            } else {
                echo "Error al insertar." . mysqli_error($conexion);
            }
            header('location: admin_panel_notebook.php');
        } 

        elseif ($tipo_notebook == 'pantalla_notebook') {
            $pantalla_notebook = $_POST['pantalla_notebook'];
            // Insertar en las tablas asociadas para procesadores
            $queryPantalla_notebook = "INSERT INTO pantalla_notebook (id_notebook, pantalla_notebook) VALUES ('$id_notebook', '$pantalla_notebook')";

            if (mysqli_query($conexion, $queryPantalla_notebook)) {
                echo "Ingreso exitoso.";
            } else {
                echo "Error al insertar." . mysqli_error($conexion);
            }
            header('location: admin_panel_notebook.php');
        } 

        elseif ($tipo_notebook == 'bateria_notebook') {
            $bateria_notebook = $_POST['bateria_notebook'];
            // Insertar en las tablas asociadas para procesadores
            $queryBateria_notebook = "INSERT INTO bateria_notebook (id_notebook, bateria_notebook) VALUES ('$id_notebook', '$bateria_notebook')";

            if (mysqli_query($conexion, $queryBateria_notebook)) {
                echo "Ingreso exitoso.";
            } else {
                echo "Error al insertar." . mysqli_error($conexion);
            }
            header('location: admin_panel_notebook.php');
        } 


        

        // Agregar más bloques elseif para otros tipos de notebook (almacenamiento, fuente de poder, etc.)
    } else {
        echo "Error al insertar ID de notebook: " . mysqli_error($conexion);
    }
}
?>