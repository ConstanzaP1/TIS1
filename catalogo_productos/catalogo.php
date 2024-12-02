<?php
session_start();
require('../conexion.php');
require('../funcion_filtros/filtrar_productos.php');

// Valores predeterminados para los filtros de marca, precio y categoría
$marca = isset($_POST['marca']) ? $_POST['marca'] : "";
$precio_min = isset($_POST['precio_min']) ? $_POST['precio_min'] : "";
$precio_max = isset($_POST['precio_max']) ? $_POST['precio_max'] : "";
$categoria = isset($_POST['categoria']) ? $_POST['categoria'] : "";

// Mostrar todos los productos o aplicar filtros
if ($marca || $precio_min || $precio_max || $categoria) {
    $productos = filtrarProductosPorMarcaYRangoYCategoria($marca, $precio_min, $precio_max, $categoria);
} else {
    $productos = obtenerTodosLosProductos();
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
// Obtener todos los productos (función para obtener productos sin filtrar)
function obtenerTodosLosProductos()
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
              INNER JOIN marca m ON p.marca = m.id_marca";
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
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=tune" />
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
    .breadcrumb {
        background-color: #f9f9f9;
        font-size: 0.9rem;
    }
    .breadcrumb .breadcrumb-item a {
        transition: color 0.2s ease-in-out;
    }
    
    .breadcrumb .breadcrumb-item a:hover {
        color: #0056b3;
        text-decoration: underline;
    }
    
    .breadcrumb .breadcrumb-item.active {
        font-weight: bold;
        color: #333;
    }
    .material-symbols-outlined {
    font-size: 30px;
    vertical-align: middle;
}
@media (max-width: 768px) {
    .btn {
        font-size: 14px; /* Ajustar el tamaño del texto */
        padding: 8px;    /* Ajustar el padding de los botones */
    }
}

</style>

<body>
<nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
        <!-- Logo (centrado en pantallas pequeñas) -->
        <div class="navbar-brand d-lg-flex d-none col-2">
            <a href="../index.php">
                <img class="logo img-fluid w-75 rounded-pill" src="../logopng.png" alt="Logo">
            </a>
        </div>
    
        <div class="d-lg-none d-flex justify-content-between align-items-center w-100">
            <!-- Botón para abrir el menú lateral -->
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <a href="../index.php" class="mx-auto">
                <img class="logo img-fluid" src="../logopng.png" alt="Logo" style="width: 180px;">
            </a>
        </div>

        <!-- Contenido de la navbar -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <!-- Barra de búsqueda -->
            <form class="d-flex ms-auto col-4 shadow" role="search">
                <input class="form-control" type="search" placeholder="Buscar en Tisnology" aria-label="Buscar">
            </form>
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
            <ul class="navbar-nav ms-auto">
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
                            <a class="dropdown-item text-black" href="../perfil_usuario/perfil_usuario.php">Mi perfil</a>
                        </li>
                        <li>
                            <a class="dropdown-item text-danger" href="../login/logout.php">Cerrar Sesión</a>
                        </li>
                    </ul>
                </li>
                
                <?php if (isset($_SESSION['user_id'])): ?>
                <div class="d-flex">
                <li class="nav-item">
                    <button type="button" class="btn btn-cart p-3 rounded-pill" onclick="window.location.href='../carrito/carrito.php'">
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
                </div> 
                
                
                <?php else: ?>
                <li class="nav-item">
                    <a class="btn btn-primary" href="../login/login.php">Iniciar Sesión</a>
                </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
<!-- Migajas de pan -->
<nav aria-label="breadcrumb">
    <ol class="breadcrumb bg-light p-3 rounded shadow-sm">
        <li class="breadcrumb-item">
            <a href="../index.php" class="text-primary text-decoration-none">
                <i class="fas fa-home me-1"></i>Inicio
            </a>
        </li>
        <li class="breadcrumb-item active text-dark" aria-current="page">
            <a href="catalogo.php" class="text-black text-decoration-none">
                Catalogo
            </a>
        </li>
    </ol>
</nav>
<!-- Fin Migajas de pan -->
<div class="container my-4">
    <div class="row">
        <!-- Botón para mostrar/ocultar filtros en pantallas pequeñas -->
        <div class="col-12 d-md-none mb-3">
            <button class="btn btn-primary btn-sm w-100 d-flex align-items-center justify-content-center" type="button" data-bs-toggle="collapse" data-bs-target="#filterCollapse" aria-expanded="false" aria-controls="filterCollapse">
                <span class="material-symbols-outlined me-2" style="font-size: 16px;">tune</span>
                Filtros
            </button>
        </div>

        <!-- Filtros en un Collapse para pantallas pequeñas -->
        <div class="col-md-3">
            <div class="collapse d-md-block" id="filterCollapse">
                <form method="post" action="catalogo.php" id="filterForm" class="border p-3 rounded">
                    <h5>Filtros</h5>

                    <!-- Filtro de precios -->
                    <div class="mb-3">
                        <label for="precio_min" class="form-label">Precio Mínimo</label>
                        <input type="number" class="form-control" id="precio_min" name="precio_min" 
                            value="<?php echo htmlspecialchars($precio_min); ?>" 
                            placeholder="Ejemplo: 100">
                    </div>
                    <div class="mb-3">
                        <label for="precio_max" class="form-label">Precio Máximo</label>
                        <input type="number" class="form-control" id="precio_max" name="precio_max" 
                            value="<?php echo htmlspecialchars($precio_max); ?>" 
                            placeholder="Ejemplo: 1000">
                    </div>

                    <!-- Filtro de marca -->
                    <div class="mb-3">
                        <label for="marca" class="form-label">Marca</label>
                        <select name="marca" id="marca" class="form-select">
                            <option value="">Selecciona una marca</option>
                            <?php
                            $marcaQuery = "SELECT nombre_marca FROM marca";
                            $marcaResult = mysqli_query($conexion, $marcaQuery);
                            while ($marcaRow = mysqli_fetch_assoc($marcaResult)) {
                                $selected = ($marcaRow['nombre_marca'] == $marca) ? "selected" : "";
                                echo "<option value='{$marcaRow['nombre_marca']}' $selected>{$marcaRow['nombre_marca']}</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <!-- Filtro de categoría -->
                    <div class="mb-3">
                        <label for="categoria" class="form-label">Categoría</label>
                        <select name="categoria" id="categoria" class="form-select">
                            <option value="">Selecciona una categoría</option>
                            <option value="audifono" <?php echo ($categoria == 'audifono') ? 'selected' : ''; ?>>Audífono</option>
                            <option value="cpu" <?php echo ($categoria == 'cpu') ? 'selected' : ''; ?>>Procesador</option>
                            <option value="fuente" <?php echo ($categoria == 'fuente') ? 'selected' : ''; ?>>Fuente de Poder</option>
                            <option value="gabinete" <?php echo ($categoria == 'gabinete') ? 'selected' : ''; ?>>Gabinete</option>
                            <option value="gpu" <?php echo ($categoria == 'gpu') ? 'selected' : ''; ?>>Tarjeta de Video</option>
                            <option value="monitor" <?php echo ($categoria == 'monitor') ? 'selected' : ''; ?>>Monitor</option>
                            <option value="mouse" <?php echo ($categoria == 'mouse') ? 'selected' : ''; ?>>Mouse</option>
                            <option value="notebook" <?php echo ($categoria == 'notebook') ? 'selected' : ''; ?>>Notebook</option>
                            <option value="placa" <?php echo ($categoria == 'placa') ? 'selected' : ''; ?>>Placa Madre</option>
                            <option value="ram" <?php echo ($categoria == 'ram') ? 'selected' : ''; ?>>Memoria RAM</option>
                            <option value="teclado" <?php echo ($categoria == 'teclado') ? 'selected' : ''; ?>>Teclado</option>
                        </select>
                    </div>

                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
    <button type="submit" class="btn btn-primary flex-grow-1">Aplicar Filtros</button>
    <button type="button" class="btn btn-secondary flex-grow-1" onclick="resetFilters()">Limpiar Filtros</button>
</div>

                </form>
            </div>
        </div>

        <!-- Productos -->
        <div class="col-12 col-md-9">
            <div class="row gx-3 gy-3">
                <?php
                if (!empty($productos)) {
                    foreach ($productos as $producto) {
                        $id_producto = $producto['id_producto'];
                        $nombre_producto = $producto['nombre_producto'];
                        $marca_producto = $producto['marca'];
                        $precio = number_format($producto['precio'], 0, ',', '.');
                        $imagen_url = $producto['imagen_url'];

                        echo "
                            <div class='col-6 col-md-4'>
                                <a href='../catalogo_productos/detalle_producto.php?id_producto=$id_producto' class='text-decoration-none'>
                                    <div class='card p-0 shadow' style='width: 100%; height: 100%;'>
                                        <div class='image-container imagen' style='width: 100%; height: 100%; position: relative; overflow: hidden;'>
                                            <img src='$imagen_url' alt='$nombre_producto' class='card-img-top img-fluid product-image' style='object-fit: contain; width: 100%; height: 100%;'>
                                        </div>
                                        <div class='texto card-body text-begin' style='width: 100%; height: 45%;'>
                                            <h6 class='text-black fw-bold'>$marca_producto</h6>                               
                                            <h5 class='text-secondary-emphasis'>$nombre_producto</h5>
                                            <h5 class='text-secondary-emphasis'>$$precio</h5>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        ";
                    }
                } else {
                    echo "<p>No se encontraron productos para la categoría seleccionada.</p>";
                }
                ?>
            </div>
        </div>
    </div>
</div>




<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function resetFilters() {
        document.getElementById("filterForm").reset();
        window.location.href = 'catalogo.php';
    }
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.querySelector('.form-control[type="search"]');
    const productContainer = document.querySelector('.row.gx-3.gy-3');

    function cargarProductos(query = '') {
        const marca = document.getElementById('marca').value;
        const precioMin = document.getElementById('precio_min').value;
        const precioMax = document.getElementById('precio_max').value;
        const categoria = document.getElementById('categoria').value;

        $.ajax({
            url: '../funcion_busqueda/buscar_productos.php',
            method: 'GET',
            data: {
                query: query,
                marca: marca,
                precio_min: precioMin,
                precio_max: precioMax,
                categoria: categoria
            },
            success: function(response) {
                productContainer.innerHTML = response;
            }
        });
    }

    searchInput.addEventListener('input', function() {
        const query = searchInput.value;
        cargarProductos(query);
    });
});
</script>

<?php include "../footer.php"?>
</body>

</html>