<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo de Productos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>

<nav class="barra1 navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <div class="row col-2">
      <img class="img-fluid w-75" src="https://upload.wikimedia.org/wikipedia/commons/d/df/Ripley_Logo.png" alt="">
    </div>
    <div class="row col-8">
      <form class="d-flex" role="search">
        <input class="form-control me-2" type="search" placeholder="Buscar" aria-label="Search">
        <button class="btn btn-primary" type="submit">Buscar</button>
      </form>
    </div>
    <div class="row col-2">
      <div class="d-grid gap-2 d-md-block">
        <button type="button" class="btn btn-primary" onclick="window.location.href='login/login.php';">Iniciar sesion</button>
      </div>
    </div>
  </div>
</nav>

<div class="container my-4">
    <div class="row d-flex justify-content-center">
        <?php
        // Conexión a la base de datos
        require('conexion.php');

        // Consulta para obtener los productos y el nombre de la marca
        $query = "
            SELECT 
                p.id_producto, 
                m.nombre_marca AS marca, 
                p.nombre_producto, 
                p.precio, 
                p.imagen_url 
            FROM 
                producto p
            JOIN 
                marca m ON p.marca = m.id_marca
        ";
        
        $result = mysqli_query($conexion, $query);

        if ($result->num_rows > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $id_producto = $row['id_producto'];
                $marca = $row['marca']; 
                $nombre_producto = $row['nombre_producto'];
                $precio = number_format($row['precio'], 0, ',', '.');
                $imagen_url = $row['imagen_url']; 

                echo "
                  <div class='card mx-1 mb-3 p-1 shadow' style='width: 18rem;'>
                    <img src='$imagen_url' alt='$nombre_producto'>
                      <div class='card-body text-begin'>
                        <a class='text-decoration-none' href='catalogo_productos/detalle_producto.php?id_producto=$id_producto'>
                            <p class='text-secondary'>$marca</p>
                            <h5 class='text-black'>$nombre_producto</h5>
                            <p class='text-secondary'>$$precio</p>
                        </a>
                      </div>
                  </div>
                ";
            }
        } else {
            echo "<p>No hay productos disponibles.</p>";
        }
        mysqli_close($conexion);
        ?>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.querySelector('.form-control[type="search"]');
    const productContainer = document.querySelector('.row.d-flex.justify-content-center');

    // Función para cargar productos según la búsqueda
    function cargarProductos(query = '') {
        $.ajax({
            url: 'catalogo_productos/buscar_productos.php',
            method: 'GET',
            data: { query: query },
            success: function(response) {
                productContainer.innerHTML = response;
            }
        });
    }

    // Cargar todos los productos al cargar la página
    cargarProductos();

    // Evento para búsqueda en tiempo real
    searchInput.addEventListener('input', function() {
        const query = searchInput.value;
        cargarProductos(query);
    });
});
</script>

</body>
</html>
