<?php
session_start();
require('conexion.php');


// Inicializar variables de filtro
$categoria = isset($_GET['categoria']) ? $_GET['categoria'] : "";
$tituloPagina = !empty($categoria) ? "Categoría  " . htmlspecialchars($categoria) : "Productos destacados";



/**
 * Función para obtener productos destacados.
 */
function obtenerProductosDestacados()
{
    global $conexion;
    $query = "SELECT 
                p.id_producto, 
                p.nombre_producto, 
                p.precio, 
                p.cantidad, 
                p.tipo_producto, 
                p.imagen_url, 
                p.destacado, 
                p.costo, 

                m.nombre_marca AS marca
              FROM producto p
              INNER JOIN marca m ON p.marca = m.id_marca
              WHERE p.destacado = 1";
    $result = mysqli_query($conexion, $query);

    if (!$result) {
        die("Error en la consulta: " . mysqli_error($conexion));
    }

    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

/**
 * Función para filtrar productos por categoría.
 */
function filtrarProductosPorCategoria($categoria)
{
    global $conexion;
    $query = "SELECT 
                p.id_producto, 
                p.nombre_producto, 
                p.precio, 
                p.cantidad, 
                p.tipo_producto, 
                p.imagen_url, 
                p.destacado, 
                p.costo, 
                p.nombre_categoria, 
                m.nombre_marca AS marca
              FROM producto p
              INNER JOIN marca m ON p.marca = m.id_marca
              WHERE p.nombre_categoria = '" . mysqli_real_escape_string($conexion, $categoria) . "'";
    $result = mysqli_query($conexion, $query);

    if (!$result) {
        die("Error en la consulta: " . mysqli_error($conexion));
    }

    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

// Consulta para obtener la URL de la imagen del usuario actual
// Comprobamos si el usuario ha iniciado sesión
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // Consulta para obtener la URL de la imagen del usuario actual
    $query = "SELECT img FROM users WHERE id = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    // Verifica si se encontró la imagen
    $img_url = $row['img'] ?? 'default-profile.png'; // Imagen por defecto si no hay una en la BD
} else {
    // Usuario no está logeado, asignamos una imagen por defecto
    $img_url = 'default-profile.png';
}
function obtenerTiposDeProducto()
{
    global $conexion;
    $query = "SELECT DISTINCT p.tipo_producto
              FROM producto p";
    $result = mysqli_query($conexion, $query);

    if (!$result) {
        die("Error en la consulta: " . mysqli_error($conexion));
    }

    // Almacenamos los tipos de productos únicos
    $tiposDeProducto = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $tiposDeProducto[] = $row['tipo_producto'];
    }

    return $tiposDeProducto;
}
// Obtener tipo de producto desde el parámetro GET
$tipoSeleccionado = isset($_GET['tipo_producto']) ? $_GET['tipo_producto'] : "";

// Si se seleccionó un tipo de producto, filtrar productos por ese tipo
if (!empty($tipoSeleccionado)) {
    $productos = filtrarProductosPorTipo($tipoSeleccionado);
} else {
    // Si no se seleccionó un tipo, mostrar productos destacados
    $productos = obtenerProductosDestacados();
}

/**
 * Función para filtrar productos por tipo.
 */
function filtrarProductosPorTipo($tipo)
{
    global $conexion;
    $query = "SELECT 
                p.id_producto, 
                p.nombre_producto, 
                p.precio, 
                p.cantidad, 
                p.tipo_producto, 
                p.imagen_url, 
                p.destacado, 
                p.costo, 
                p.nombre_categoria, 
                m.nombre_marca AS marca
              FROM producto p
              INNER JOIN marca m ON p.marca = m.id_marca
              WHERE p.tipo_producto = '" . mysqli_real_escape_string($conexion, $tipo) . "'";
    $result = mysqli_query($conexion, $query);

    if (!$result) {
        die("Error en la consulta: " . mysqli_error($conexion));
    }

    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}
?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo de Productos</title>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    
</head>
<style>
    .navbar {
        background-color: rgba(0, 128, 255, 0.5);
    }

    .celeste-background {
        background-color: rgba(0, 128, 255, 0.5);
        border-color: rgba(0, 128, 255, 0.5);
    }

    .card-body {
        background-color: #e0e0e0;
    }
    .celeste{
        color: #0080FF80;
    }
    .card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card:hover {
        transform: scale(1.05); /* Aumenta el tamaño de la tarjeta */
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2); /* Agrega una sombra */
    }

        /* Estilo para el botón del carrito */
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
    .carousel-inner {
        position: relative;
        width: 100%;
        overflow: hidden; /* Esto asegura que las imágenes no se desborden del contenedor */
    }

    .carousel-inner img {
        width: 100%; /* Las imágenes ocupan todo el ancho disponible */
        height: 100%; /* Las imágenes ocuparán toda la altura disponible */
        object-fit: cover; /* Asegura que las imágenes cubran el contenedor sin deformarse */
    }

    /* Para pantallas pequeñas, ajustamos la altura para que el banner no se vea muy alto */
    @media (max-width: 768px) {
        .carousel-inner img {
            object-fit: cover; /* Mantiene el mismo ajuste en pantallas medianas */
        }
    }

    @media (max-width: 576px) {
        .carousel-inner img {
            object-fit: cover; /* Asegura que la imagen cubra sin deformarse en pantallas pequeñas */
        }
    }
    .custom-carousel-control {
        top: 50%; /* Centrar verticalmente */
        transform: translateY(-50%);
    }

    .carousel-control-prev-icon,
    .carousel-control-next-icon {
        background-color: #000; /* Fondo oscuro para los íconos */
        border-radius: 50%; /* Hacerlos circulares */
    }

    .carousel-control-prev,
    .carousel-control-next {
        width: auto; /* Reducir ancho para que no cubran los productos */
        margin: 0 10px; /* Separar de los productos */
    }

</style>

<body>
<nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
        <!-- Logo (centrado en pantallas pequeñas) -->
        <div class="navbar-brand d-lg-flex d-none col-2">
            <img class="logo img-fluid w-75 rounded-pill" src="logopng.png" alt="Logo">
        </div>
        <div class="d-lg-none w-100 text-center">
            <img class="logo img-fluid" src="logopng.png" alt="Logo" style="width: 120px;">
        </div>

        <!-- Botón para abrir el menú lateral en pantallas pequeñas -->
        <button class="navbar-toggler d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Contenido de la navbar -->
        <div class="collapse navbar-collapse" id="navbarNav">
            
            <!-- Barra de búsqueda -->
            <form class="d-flex ms-auto col-4 shadow" role="search">
                <input class="form-control" type="search" placeholder="Buscar en Tisnology" aria-label="Buscar">
            </form>
            <!-- Menú  -->
            <ul class="navbar-nav ms-auto align-items-center">
            <li class="nav-item">
        <li class="nav-item">
            <button 
                class="btn btn-light rounded-pill px-4 py-2 ms-1 me-1 border shadow-sm" 
                style="background-color: white; color: #000; border-color: #ddd;"
                onclick="window.location.href='catalogo_productos/catalogo.php'">
                Ir al Catálogo
            </button>
        </li>

        </li>
                <?php if (isset($_SESSION['user_id'])): ?>
                <li class="nav-item">
                    <button type="button" class="btn btn-cart p-3 ms-2 rounded-pill" onclick="window.location.href='carrito/carrito.php'">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-cart" viewBox="0 0 16 16">
                            <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5M3.102 4l1.313 7h8.17l1.313-7zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4m7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4m-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2m7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2"/>
                        </svg>
                    </button>
                </li>
                <li class="nav-item">
                    <button type="button" class="btn btn-comparar p-3 ms-2 rounded-pill me-2" onclick="window.location.href='../TIS1/comparador/comparador.php'">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left-right" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M1 11.5a.5.5 0 0 0 .5.5h11.793l-3.147 3.146a.5.5 0 0 0 .708.708l4-4a.5.5 0 0 0 0-.708l-4-4a.5.5 0 0 0-.708.708L13.293 11H1.5a.5.5 0 0 0-.5.5m14-7a.5.5 0 0 1-.5.5H2.707l3.147 3.146a.5.5 0 1 1-.708.708l-4-4a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 4H14.5a.5.5 0 0 1 .5.5"/>
                        </svg>
                    </button>
                </li>
                <li>
                    <button type="button" class="btn btn-deseos p-3 ms-2 rounded-pill me-2" onclick="window.location.href='lista_deseos/lista_deseos.php'">
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
                                <a class="dropdown-item" href="admin_panel/admin_panel.php">Panel Admin</a>
                            </li>
                        <?php endif; ?>
                        <li>
                            <a class="dropdown-item text-danger" href="login/logout.php">Cerrar Sesión</a>
                        </li>
                    </ul>
                </li>
                <a class="dropdown-item" href="perfil_usuario/perfil_usuario.php">
                    <li class="nav-item ms-2">
                        <img src="<?php echo htmlspecialchars($img_url); ?>" alt="Foto de perfil" class="rounded-circle" style="width: 50px; height: 50px; object-fit: cover;">
                    </li>
                </a>
                <?php else: ?>
                <li class="nav-item">
                    <a class="btn btn-primary" href="login/login.php">Iniciar Sesión</a>
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


<div id="responsiveCarousel" class="carousel slide" data-bs-ride="carousel">
    <!-- Indicadores del carrusel -->
    <div class="carousel-indicators">
        <button type="button" data-bs-target="#responsiveCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#responsiveCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
        <button type="button" data-bs-target="#responsiveCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
    </div>

    <!-- Contenido del carrusel -->
    <div class="carousel-inner">
        <!-- Slide 1 -->
        <div class="carousel-item active">
            <img src="https://i.postimg.cc/q7Cfvmc9/1.png" class="d-block w-100" alt="Banner 1">
            <div class="carousel-caption d-none d-md-block">
                <a href="#" class="btn btn-primary">Ver más</a>
            </div>
        </div>

        <!-- Slide 2 -->
        <div class="carousel-item">
            <img src="https://i.postimg.cc/52ydZ9X9/2.png" class="d-block w-100" alt="Banner 2">
            <div class="carousel-caption d-none d-md-block">
                <a href="#" class="btn btn-primary">Explorar</a>
            </div>
        </div>

        <!-- Slide 3 -->
        <div class="carousel-item">
            <img src="https://i.postimg.cc/SxPFq096/3.png" class="d-block w-100" alt="Banner 3">
            <div class="carousel-caption d-none d-md-block">
                <a href="#" class="btn btn-primary">Descubre más</a>
            </div>
        </div>
    </div>

    <!-- Controles de navegación -->
    <button class="carousel-control-prev" type="button" data-bs-target="#responsiveCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#responsiveCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>

<div class="container my-2">
    <div class="row">
        <div class="col text-center celeste-background text-white py-3">
            <h1>Te recomendamos</h1>
        </div>
        <div class="col-12 py-3">
            <?php
            // Filtrar productos destacados
            $productosDestacados = array_filter($productos, function ($producto) {
                return $producto['destacado'] == 1;
            });

            if (!empty($productosDestacados)) {
                $chunkedProductos = array_chunk($productosDestacados, 3); // Dividimos en grupos de 3 productos
                ?>
                <div id="carouselProductosDestacados" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <?php foreach ($chunkedProductos as $index => $productosChunk): ?>
                            <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
                                <div class="row gx-3 gy-3">
                                    <?php foreach ($productosChunk as $producto): ?>
                                        <div class="col-6 col-md-4">
                                            <a href="catalogo_productos/detalle_producto.php?id_producto=<?php echo $producto['id_producto']; ?>" class="text-decoration-none">
                                                <div class="card p-0 shadow" style="width: 100%; height: 100%;">
                                                    <div class="image-container" style="width: 100%; height: 100%; position: relative; overflow: hidden;">
                                                        <img src="<?php echo $producto['imagen_url']; ?>" alt="<?php echo $producto['nombre_producto']; ?>" class="card-img-top img-fluid product-image" style="object-fit: contain; width: 100%; height: 100%;">
                                                    </div>
                                                    <div class="card-body text-begin" style="width: 100%; height: 45%;">
                                                        <h6 class="text-black fw-bold"><?php echo $producto['marca']; ?></h6>
                                                        <h5 class="text-secondary-emphasis"><?php echo $producto['nombre_producto']; ?></h5>
                                                        <h5 class="text-secondary-emphasis">$<?php echo number_format($producto['precio'], 0, ',', '.'); ?></h5>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <!-- Controles del carrusel -->
                    <button class="carousel-control-prev custom-carousel-control" type="button" data-bs-target="#carouselProductosDestacados" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon bg-dark rounded-circle p-2" aria-hidden="true"></span>
                        <span class="visually-hidden">Anterior</span>
                    </button>
                    <button class="carousel-control-next custom-carousel-control" type="button" data-bs-target="#carouselProductosDestacados" data-bs-slide="next">
                        <span class="carousel-control-next-icon bg-dark rounded-circle p-2" aria-hidden="true"></span>
                        <span class="visually-hidden">Siguiente</span>
                    </button>
                </div>
            <?php
            } else {
                echo "<p>No se encontraron productos destacados.</p>";
            }
            ?>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.querySelector('.form-control[type="search"]');
    const productContainer = document.querySelector('.row.gx-3.gy-3');

    // Function to fetch and display products
    function cargarProductos(query = '') {
        $.ajax({
            url: 'funcion_busqueda/buscar_productos.php',
            method: 'GET',
            data: { query: query },
            success: function(response) {
                productContainer.innerHTML = response;
            }
        });
    }

    // Listen for input changes in the search bar
    searchInput.addEventListener('input', function() {
        const query = searchInput.value.trim();
        cargarProductos(query);
    });
});

</script>
<?php include "footer.php"?>
</body>

</html>