<?php 
session_start();
require('conexion.php');
require('funcion_filtros/filtrar_productos.php');

// Valores predeterminados para los filtros de marca, precio y categoría
$marca = isset($_POST['marca']) ? $_POST['marca'] : "";
$precio_min = isset($_POST['precio_min']) ? $_POST['precio_min'] : "";
$precio_max = isset($_POST['precio_max']) ? $_POST['precio_max'] : "";
$categoria = isset($_POST['categoria']) ? $_POST['categoria'] : "";
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
<body>

<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <!-- Logo -->
        <div class="navbar-brand col-2  ">
            <img class="logo img-fluid w-75" src="logo.jpg" alt="Logo">
        </div>

        <!-- Botón para colapsar el menú en pantallas pequeñas -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Contenido de la navbar -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <!-- Barra de búsqueda -->
            <form class="d-flex ms-auto col-8 shadow" role="search">
                <input class="form-control" type="search" placeholder="Buscar" aria-label="Buscar">
            </form>

            <!-- Menú desplegable -->
            <ul class="navbar-nav ms-auto">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Bienvenido, <?php echo htmlspecialchars($_SESSION['username']); ?>!
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <?php if ($_SESSION['role'] === 'admin'): ?>
                                <li>
                                    <a class="dropdown-item" href="admin_panel/admin_panel.php">Panel Admin</a>
                                </li>
                            <?php endif; ?>
                            <li>
                                <a class="dropdown-item" href="carrito/carrito.php">Mi Carro</a>
                            </li>
                            <li>
                                <a class="dropdown-item text-danger" href="login/logout.php">Cerrar Sesión</a>
                            </li>
                        </ul>
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
            <form method="post" action="index.php" id="filterForm" class="border p-3 mt-3">
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
                        <?php
                        $categorias = ["Teclado", "Monitor", "Audifono", "Mouse", "Procesador", "Tarjeta de video", "Memoria Ram", "Placa Madre", "Fuente de Poder", "Gabinete", "Notebook"];
                        foreach ($categorias as $cat) {
                            $selected = ($cat == $categoria) ? "selected" : "";
                            echo "<option value='$cat' $selected>$cat</option>";
                        }
                        ?>
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
            <div class="row d-flex justify-content-center mt-3">
                <?php
                // Llamamos a la función de filtro de productos por marca, rango de precios y categoría
                $filtered_products = filtrarProductosPorMarcaYRangoYCategoria($marca, $precio_min, $precio_max, $categoria);

                // Mostrar productos filtrados
                if (!empty($filtered_products)) {
                    foreach ($filtered_products as $producto) {
                        $id_producto = $producto['id_producto'];
                        $nombre_producto = $producto['nombre_producto'];
                        $marca_producto = $producto['marca'];
                        $precio = number_format($producto['precio'], 0, ',', '.');
                        $imagen_url = $producto['imagen_url'];

                        echo "
                            <div class='card mx-1 mb-3 p-1 shadow' style='width: 18rem;'>
                                <img src='$imagen_url' alt='$nombre_producto'>
                                <div class='card-body text-begin'>
                                    <a class='text-decoration-none' href='catalogo_productos/detalle_producto.php?id_producto=$id_producto'>
                                        <p class='text-secondary'>$marca_producto</p>
                                        <h5 class='text-black'>$nombre_producto</h5>
                                        <p class='text-secondary'>$$precio</p>
                                    </a>
                                </div>
                            </div>
                        ";
                    }
                } else {
                    echo "<p>No se encontraron productos que coincidan con los filtros aplicados.</p>";
                }

                mysqli_close($conexion);
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
