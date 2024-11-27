<?php
session_start();
include '../conexion.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login/login.php");
    exit();
}
// Verificar si el usuario está autenticado
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login/login.php");
    exit();
}

// Obtener datos del usuario
$user_id = $_SESSION['user_id'];
$queryUser = "SELECT username, img FROM users WHERE id = ?";
$stmtUser = $conexion->prepare($queryUser);
$stmtUser->bind_param("i", $user_id);
$stmtUser->execute();
$resultUser = $stmtUser->get_result();
$userData = $resultUser->fetch_assoc();
$stmtUser->close();

// Establecer imagen de perfil por defecto si no se encuentra en la base de datos
$img_url = $userData['img'] ?? 'https://static.vecteezy.com/system/resources/previews/007/167/661/non_2x/user-blue-icon-isolated-on-white-background-free-vector.jpg';

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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

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
        .btn-cart:hover {
    background-color: white; /* Cambia el fondo al pasar el mouse */
    color: #721c24; /* Cambia el color del texto/icono */
    transform: scale(1.1); /* Hace que el botón crezca ligeramente */
    transition: all 0.3s ease; /* Suaviza la animación */
}

/* Estilo para el botón de comparar */
.btn-comparar:hover {
    background-color: white; /* Cambia el fondo al pasar el mouse */
    color: #155724; /* Cambia el color del texto/icono */
    transform: scale(1.1); /* Hace que el botón crezca ligeramente */
    transition: all 0.3s ease; /* Suaviza la animación */
}
.btn-deseos:hover {
    background-color: white; /* Cambia el fondo al pasar el mouse */
    color: #721c24; /* Cambia el color del texto/icono */
    transform: scale(1.1); /* Hace que el botón crezca ligeramente */
    transition: all 0.3s ease; /* Suaviza la animación */

}
.wishlist-card {
        background-color: #ffffff;
        border-radius: 15px;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        padding: 20px;
        margin: 20px 0;
    }
body {
            background-color: #f8f9fa; /* Fondo claro */
        }
        .container {
            max-width: 1200px;
        }
        
.wishlist-card img {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 10px;
            
        }
        
        .wishlist-card .btn-danger {
            border-radius: 10px;
        }
        .wishlist-card .price {
            font-size: 1.2rem;
            font-weight: bold;
            color: #333;
        }
        
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
        <!-- Logo (centrado en pantallas pequeñas) -->
        <div class="navbar-brand d-lg-flex d-none col-2">
            <a href="../index.php">
                <img class="logo img-fluid w-75 rounded-pill" src="../logopng.png" alt="Logo">
            </a>
        </div>
    
        <div class="d-lg-none w-100 text-center">
            <a href="../index.php">
                <img class="logo img-fluid" src="../logopng.png" alt="Logo" style="width: 120px;">
            </a>    
        </div>

        <!-- Botón para abrir el menú lateral en pantallas pequeñas -->
        <button class="navbar-toggler d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Contenido de la navbar -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <!-- Menú desplegable -->
            <ul class="navbar-nav ms-auto align-items-center">
                
                <?php if (isset($_SESSION['user_id'])): ?>
                <li class="nav-item">
                    <button type="button" class="btn btn-cart p-3 ms-2 rounded-pill" onclick="window.location.href='../carrito/carrito.php'">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-cart" viewBox="0 0 16 16">
                            <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5M3.102 4l1.313 7h8.17l1.313-7zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4m7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4m-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2m7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2"/>
                        </svg>
                    </button>
                </li>
                <li class="nav-item">
                    <button type="button" class="btn btn-comparar p-3 ms-2 rounded-pill me-2" onclick="window.location.href='../comparador/comparador.php'">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left-right" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M1 11.5a.5.5 0 0 0 .5.5h11.793l-3.147 3.146a.5.5 0 0 0 .708.708l4-4a.5.5 0 0 0 0-.708l-4-4a.5.5 0 0 0-.708.708L13.293 11H1.5a.5.5 0 0 0-.5.5m14-7a.5.5 0 0 1-.5.5H2.707l3.147 3.146a.5.5 0 1 1-.708.708l-4-4a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 4H14.5a.5.5 0 0 1 .5.5"/>
                        </svg>
                    </button>
                </li>
                <li>
                    <button type="button" class="btn btn-deseos p-3 ms-2 rounded-pill me-2" onclick="window.location.href='../lista_deseos/lista_deseos.php'">
                    <i class='fas fa-heart'></i>
                    </button>
                   
                </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle bg-white rounded-pill p-3" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Bienvenid@, <?php echo htmlspecialchars($_SESSION['username']); ?>!
                        </a>
                        
                        <ul class="dropdown-menu dropdown-menu-end">
                            <?php if (in_array($_SESSION['role'], ['admin', 'superadmin'])): ?>
                                <li>
                                    <a class="dropdown-item" href="../admin_panel/admin_panel.php">Panel Admin</a>
                                </li>
                            <?php endif; ?>
                            
                            
                            <li>
                                <a class="dropdown-item text-danger" href="../login/logout.php">Cerrar Sesión</a>
                            </li>
                        </ul>
                    </li>
                    <a class="dropdown-item" href="../perfil_usuario/perfil_usuario.php">
                        <li class="nav-item ms-2">
                            <img src="<?php echo htmlspecialchars($img_url); ?>" alt="Foto de perfil" class="rounded-circle" style="width: 50px; height: 50px; object-fit: cover;">
                        </li>
                    </a>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="btn btn-primary" href="../login/login.php">Iniciar Sesión</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>

    <!-- Offcanvas para menú lateral -->
    <div class="offcanvas offcanvas-start d-lg-none" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Menú</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="../carrito/carrito.php">Carrito</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../comparador/comparador.php">Comparador</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../lista_deseos/lista_deseos.php">Lista de Deseos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-danger" href="../login/logout.php">Cerrar Sesión</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <!-- Lista de Deseos -->
    <h1 class="text-center">Lista de Deseos</h1>
    <?php if ($result->num_rows > 0): ?>
        <?php while ($producto = $result->fetch_assoc()): ?>
            <div class="wishlist-card d-flex align-items-center">
                <img src="<?php echo htmlspecialchars($producto['imagen_url']); ?>" alt="Producto">
                <div class="ms-3 w-100">
                    <h5 class="mb-0"><?php echo htmlspecialchars($producto['nombre_producto']); ?></h5>
                    <p class="mb-1">Marca: <?php echo htmlspecialchars($producto['nombre_marca']); ?></p>
                    <p class="price mb-2">$<?php echo number_format($producto['precio'], 0, ',', '.'); ?></p>
                    <form action="eliminar_producto.php" method="post">
                        <input type="hidden" name="producto_id" value="<?php echo $producto['id_producto']; ?>">
                        <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                    </form>
                </div>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <div class="wishlist-card text-center">
            <p>No hay productos en la lista de deseos.</p>
        </div>
    <?php endif; ?>
</div>
<?php include "../footer.php"?>
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
