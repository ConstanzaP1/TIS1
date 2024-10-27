<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo de Productos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        /* Estilo del menú de perfil */
        .perfil__menu {
            position: relative;
        }

        .perfil__boton {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 0.25rem;
            cursor: pointer;
            font-size: 1rem;
            height: 38px;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            white-space: nowrap;
        }

        .perfil__boton:hover {
            background-color: #0056b3;
        }

        .perfil__opciones {
            display: none;
            position: absolute;
            top: 100%;
            right: 0;
            background-color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 0.25rem;
            overflow: hidden;
            z-index: 1000;
            min-width: 120px;
            padding: 5px 0;
        }

        .perfil__opcion {
            display: block;
            padding: 0.5rem 1rem;
            color: #007bff;
            text-decoration: none;
            white-space: nowrap;
        }

        .perfil__opcion:hover {
            background-color: #f1f1f1;
        }

        /* Card de productos */
        .card {
            border: none;
            border-radius: 10px;
            overflow: hidden;
            transition: transform 0.3s;
        }

        .card img {
            width: 100%;
            height: auto;
        }

        .card:hover {
            transform: scale(1.05);
        }
    </style>
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
        <button id="botonBuscar" class="btn btn-primary" type="submit">Buscar</button>
        <div class="perfil__menu ms-2">
            <button id="perfilButton" class="perfil__boton">
                Perfil
                <i class="bi bi-caret-down-fill"></i>
            </button>
            <div id="perfil__opciones" class="perfil__opciones">
                <a href="login/login.php" class="perfil__opcion">Iniciar Sesión</a>
            </div>
        </div>
      </form>
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
                // Variables del producto
                $id_producto = $row['id_producto'];
                $marca = $row['marca']; 
                $nombre_producto = $row['nombre_producto'];
                $precio = number_format($row['precio'], 0, ',', '.');
                $imagen_url = $row['imagen_url']; 

                // HTML del producto con enlace al detalle
                echo "
                  <div class='card mx-1 mb-3 p-1 shadow' style='width: 18rem;'>
                    <img src='$imagen_url' alt='$nombre_producto'>
                      <div class='card-body text-begin'>
                        <a class='text-decoration-none' href='detalle_producto.php?id_producto=$id_producto'>
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

<!-- Script para el menú desplegable de perfil -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const perfilButton = document.getElementById("perfilButton");
        const perfilOpciones = document.getElementById("perfil__opciones");

        // Ocultar el menú al cargar la página
        perfilOpciones.style.display = "none";

        perfilButton.addEventListener("click", function(event) {
            event.preventDefault();
            event.stopPropagation(); // Evita que el clic se propague al documento
            perfilOpciones.style.display = perfilOpciones.style.display === "block" ? "none" : "block";
        });

        // Cerrar el menú si se hace clic fuera de él
        document.addEventListener("click", function(event) {
            if (perfilOpciones.style.display === "block" && !perfilOpciones.contains(event.target)) {
                perfilOpciones.style.display = "none";
            }
        });
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

</body>
</html>
