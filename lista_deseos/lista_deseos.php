<?php
session_start();
include '../conexion.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$nombre_lista = 'mi_lista_deseos';

$query = "SELECT p.id_producto, p.nombre_producto, m.nombre_marca, p.precio, p.imagen_url 
          FROM producto p 
          JOIN lista_deseo_producto ldp ON p.id_producto = ldp.id_producto 
          JOIN marca m ON p.marca = m.id_marca 
          WHERE ldp.nombre_lista = ? AND ldp.user_id = ?";
$stmt = $conexion->prepare($query);
$stmt->bind_param("si", $nombre_lista, $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Deseos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .navbar {
            background-color: rgba(0, 128, 255, 0.5);   
        }
        .card-horizontal {
            display: flex;
            flex-direction: row;
            padding: 10px;
            border: 1px solid #ddd;
            margin-bottom: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
        }
        .card-horizontal img {
            width: 150px;
            height: auto;
            object-fit: cover;
            margin-right: 20px;
            border-radius: 5px;
        }
        .card-body {
            padding: 0 15px;
            flex: 1;
        }
        .card-price {
            font-size: 1.5rem;
            color: #333;
            font-weight: bold;
        }
        .navbar{
        background-color: rgba(0, 128, 255, 0.5);   
        }
        .celeste-background{
            background-color: rgba(0, 128, 255, 0.5); 
            border-color: rgba(0, 128, 255, 0.5);   
        }
        .card-body{
            background-color: #e0e0e0;
        }
        body{
            background-color: #e0e0e0;
        }   
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
        <!-- Logo -->
        <div class="navbar-brand col-2  ">
            <a href="../index.php">
                <img class="logo img-fluid w-75 rounded-pill" src="../logopng.png" alt="Logo">
            </a>
        </div>
        <!-- Botón para colapsar el menú en pantallas pequeñas -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Contenido de la navbar -->
        <div class="collapse navbar-collapse" id="navbarNav">

            <!-- Menú desplegable -->
            <ul class="navbar-nav ms-auto">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle bg-white rounded-pill p-3" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Bienvenid@, <?php echo htmlspecialchars($_SESSION['username']); ?>!
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <?php if ($_SESSION['role'] === 'admin'): ?>
                                <li>
                                    <a class="dropdown-item" href="../admin_panel/admin_panel.php">Panel Admin</a>
                                </li>
                            <?php endif; ?>
                            <li>
                                <a class="dropdown-item" href="../comparador/comparador.php">Comparador</a>
                            </li>
                            <li>
                                <a class="dropdown-item text-danger" href="../login/logout.php">Cerrar Sesión</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                    <button type="button" class="btn btn-cart p-3 ms-2 rounded-pill" onclick="window.location.href='../carrito/carrito.php'">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-cart" viewBox="0 0 16 16">
                            <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5M3.102 4l1.313 7h8.17l1.313-7zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4m7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4m-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2m7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2"/>
                        </svg>
                    </button>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="btn btn-primary" href="login/login.php">Iniciar Sesión</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <h1 class="text-center mb-4">Lista de Deseos</h1>
    <div class="row">
        <?php
        if ($result->num_rows > 0) {
            while ($producto = $result->fetch_assoc()) {
                $id_producto = $producto['id_producto'];
                $nombre_producto = $producto['nombre_producto'];
                $nombre_marca = $producto['nombre_marca'];
                $precio = number_format($producto['precio'], 0, ',', '.');
                $imagen_url = $producto['imagen_url'];

                echo "<div class='col-12'>";
                echo "<div class='card-horizontal d-flex align-items-center'>";
                echo "<img src='$imagen_url' alt='Imagen de $nombre_producto'>";
                echo "<div class='card-body'>";
                echo "<h5 class='card-title'>$nombre_producto</h5>";
                echo "<p class='card-text'>Marca: $nombre_marca</p>";
                echo "<p class='card-price'>$ $precio</p>";
                
                // Botón de eliminar
                echo "<form action='eliminar_producto.php' method='post' style='display:inline;'>";
                echo "<input type='hidden' name='producto_id' value='$id_producto'>";
                echo "<button type='submit' class='btn btn-danger mt-2'>Eliminar</button>";
                echo "</form>";

                echo "</div>";  // Cierra .card-body
                echo "</div>";  // Cierra .card-horizontal
                echo "</div>";  // Cierra .col-12
            }
        } else {
            echo "<p class='text-center'>No hay productos en la lista de deseos.</p>";
        }
        ?>
    </div>
    <!-- Botón Volver al Índice -->
    <br>
    <a href='../index.php' class='btn btn-secondary'>Volver al Catálogo</a>
    <br>
</div>
<script>
    function removeFromWishlist(producto_id) {
    fetch('../lista_deseos/eliminar_producto.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `producto_id=${producto_id}`
    })
    .then(() => {
        // Elimina el elemento del DOM sin mostrar ningún mensaje
        const item = document.getElementById(`wishlist-item-${producto_id}`);
        if (item) {
            item.remove();
        }
    })
    .catch(error => console.error('Error:', error)); // Esto solo se mostrará en caso de error
}

</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+3eS2bZqD1zwwu7oZXQAKdf4aJwEr" crossorigin="anonymous"></script>
</body>
</html>
<?php
$stmt->close();
$conexion->close();
?>
