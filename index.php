
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú Principal</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; }
        nav { margin-top: 50px; }
        button { padding: 10px 20px; margin: 10px; font-size: 16px; }
    </style>
</head>
<body>
    <h1>Bienvenido al Índice Principal</h1>
    <nav>
        <form action="" method="get">
            <button type="submit" name="section" value="notebook">Notebooks</button>
            <button type="submit" name="section" value="perifericos">Periféricos</button>
            <button type="submit" name="section" value="hardware">Hardware</button>

        </form>
    </nav>

    <?php
    if (isset($_GET['section'])) {
        $section = $_GET['section'];
        
        // Redirigir según la sección seleccionada
        switch ($section) {
            case 'notebook':
                header("Location: index_notebook.php");
                break;
            case 'perifericos':
                header("Location: index_periferico.php");
                break;
            case 'hardware':
                header("Location: index_hardware.php");
                break;    
            default:
                echo "<p>Sección no encontrada.</p>";
                break;
        }
    }
    ?>
</body>
</html>
