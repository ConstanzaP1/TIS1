<?php
include("auth.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index</title>
</head>
<body>
    <div class="form">
        <p>Buenvendid@ </b><?php echo $_SESSION['username'];?></b> </p>
        <p>Acabas de inciar sesión</p>
        <a href="logout.php">Cerrar sesión</a>
    </div>
</body>
</html>
