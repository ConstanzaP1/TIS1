<?php 
session_start();
require('conexion.php');
require('funcion_filtros/filtrar_productos.php');

// Valores predeterminados para los filtros de marca, precio y categoría
$marca = isset($_POST['marca']) ? $_POST['marca'] : "";
$precio_min = isset($_POST['precio_min']) ? $_POST['precio_min'] : "";
$precio_max = isset($_POST['precio_max']) ? $_POST['precio_max'] : "";
$categoria = isset($_POST['categoria']) ? $_POST['categoria'] : "";
// Verificar si hay filtros aplicados
// Verificar si hay filtros aplicados
if (empty($marca) && empty($precio_min) && empty($precio_max) && empty($categoria)) {
    // Obtener solo productos destacados
    $productos = filtrarProductosPorMarcaYRangoYCategoria("", "", "", "", true);
} else {
    // Filtrar productos destacados según los criterios
    $productos = filtrarProductosPorMarcaYRangoYCategoria($marca, $precio_min, $precio_max, $categoria, true);
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

</head>
<style>
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
</style>
<body>
<nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
        <!-- Logo -->
        <div class="navbar-brand col-2  ">
            <img class="logo img-fluid w-75 rounded-pill" src="logopng.png" alt="Logo">
        </div>

        <!-- Botón para colapsar el menú en pantallas pequeñas -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Contenido de la navbar -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <!-- Barra de búsqueda -->
            <form class="d-flex ms-auto col-8 shadow" role="search">
                <input class="form-control" type="search" placeholder="Buscar en Tisnology" aria-label="Buscar">
            </form>

            <!-- Menú desplegable -->
            <ul class="navbar-nav ms-auto">
                <?php if (isset($_SESSION['user_id'])): ?>
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
                    <li class="nav-item">
                    <button type="button" class="btn btn-cart p-3 ms-2 rounded-pill" onclick="window.location.href='carrito/carrito.php'">
    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-cart" viewBox="0 0 16 16">
        <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5M3.102 4l1.313 7h8.17l1.313-7zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4m7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4m-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2m7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2"/>
    </svg>
</button>

                    </li>
                    <li class="nav-item">
                            <button type="button" class="btn btn-comparar p-3 ms-2 rounded-pill" onclick="window.location.href='../TIS1/comparador/comparador.php'">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left-right" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M1 11.5a.5.5 0 0 0 .5.5h11.793l-3.147 3.146a.5.5 0 0 0 .708.708l4-4a.5.5 0 0 0 0-.708l-4-4a.5.5 0 0 0-.708.708L13.293 11H1.5a.5.5 0 0 0-.5.5m14-7a.5.5 0 0 1-.5.5H2.707l3.147 3.146a.5.5 0 1 1-.708.708l-4-4a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 4H14.5a.5.5 0 0 1 .5.5"/>
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

<div class="container my-4">
    <div class="row">
        <!-- Columna de filtros a la izquierda -->
        <div class="col-md-3">
            <form method="post" action="index.php" id="filterForm" class="border p-3 card-body rounded">
                <h5>Filtros</h5>
                
                <!-- Campos de filtro de precios -->
                <div class="mb-3">
                    <label for="precio_min" class="form-label">Precio Mínimo</label>
                    <input type="number" class="form-control" id="precio_min" name="precio_min" placeholder="ej:0" value="<?php echo htmlspecialchars($precio_min); ?>">
                </div>
                <div class="mb-3">
                    <label for="precio_max" class="form-label">Precio Máximo</label>
                    <input type="number" class="form-control" id="precio_max" name="precio_max" placeholder="ej:1000" value="<?php echo htmlspecialchars($precio_max); ?>">
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
                        <option value="audifono">Audífono</option>
                        <option value="cpu">Procesador</option>
                        <option value="fuente">Fuente de Poder</option>
                        <option value="gabinete">Gabinete</option>
                        <option value="gpu">Tarjeta de Video</option>
                        <option value="monitor">Monitor</option>
                        <option value="mouse">Mouse</option>
                        <option value="notebook">Notebook</option>
                        <option value="placa">Placa Madre</option>
                        <option value="ram">Memoria RAM</option>
                        <option value="teclado">Teclado</option>
                    </select>
                </div>

                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary">Aplicar Filtros</button>
                    <button type="button" class="btn btn-secondary" onclick="resetFilters()">Limpiar Filtros</button>
                </div>
            </form>
        </div>

        <!-- Columna de productos a la derecha -->
        <div class="col-md-9">
            <div class="row d-flex justify-content-center">
                <?php
                if (!empty($productos)) {
                    echo "<div class='d-flex flex-wrap justify-content-center'>";
                    foreach ($productos as $producto) {
                        $id_producto = $producto['id_producto'];
                        $nombre_producto = $producto['nombre_producto'];
                        $marca_producto = $producto['marca'];
                        $precio = number_format($producto['precio'], 0, ',', '.');
                        $imagen_url = $producto['imagen_url'];

                        echo "
                            <a href='catalogo_productos/detalle_producto.php?id_producto=$id_producto' class='text-decoration-none'>
                                <div class='card mx-1 mb-3 p-0 shadow' style='width: 18rem; height: 26rem;'>
                                    <img src='$imagen_url' alt='$nombre_producto' class='card-img-top img-fluid product-image'>
                                    <div class='card-body text-begin'>
                                        <h6 class='text-secondary m-0'>$marca_producto</h6>
                                        <h5 class='text-black my-1'>$nombre_producto</h5>
                                        <h6 class='text-secondary'>$$precio</h6>
                                    </div>
                                </div>
                            </a>
                        ";
                    }
                    echo "</div>";
                } else {
                    echo "<p>No se encontraron productos que coincidan con los filtros o destacados.</p>";
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
        window.location.href = 'index.php';
    }
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.querySelector('.form-control[type="search"]');
    const productContainer = document.querySelector('.row.d-flex.justify-content-center');

   // Función para cargar productos según la búsqueda
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
    searchInput.addEventListener('input', function() {
        const query = searchInput.value;
        cargarProductos(query);
    });
});
</script>
    
</body>
</html>