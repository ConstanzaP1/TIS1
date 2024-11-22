<?php
session_start();
require('../conexion.php'); // Conexión a la base de datos

// Regenerar ID de sesión para asegurar consistencia
session_regenerate_id(true);

// Inicializar el carrito si no existe
if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

// Inicializar el total si no existe
if (!isset($_SESSION['total'])) {
    $_SESSION['total'] = 0;
}

// Obtener el ID del usuario de la sesión, si está disponible
$id_usuario = $_SESSION['id_usuario'] ?? null;
$correoE = $_SESSION['email'];


// Manejar la adición de productos al carrito
if (isset($_POST['agregar_carrito'])) {
    $id_producto = $_POST['id_producto'];
    $cantidad = $_POST['cantidad'];
    $_SESSION['carrito'][$id_producto] = ($_SESSION['carrito'][$id_producto] ?? 0) + $cantidad;
    recalcularTotal();
    header('Location: carrito.php'); // Recargar para evitar reposteo
    exit;
}

// Manejar la edición de cantidad de productos en el carrito
if (isset($_POST['editar_carrito'])) {
    $id_producto = $_POST['id_producto'];
    $nueva_cantidad = $_POST['cantidad'];

    // Verificar si la nueva cantidad es menor a 1 y eliminar si es necesario
    if ($nueva_cantidad < 1) {
        unset($_SESSION['carrito'][$id_producto]);
    } else {
        $_SESSION['carrito'][$id_producto] = $nueva_cantidad;
    }
    recalcularTotal();
    header('Location: carrito.php'); // Recargar para evitar reposteo
    exit;
}

// Eliminar un producto del carrito
if (isset($_POST['eliminar_producto'])) {
    $id_producto = $_POST['id_producto'];
    unset($_SESSION['carrito'][$id_producto]);
    recalcularTotal();
    header('Location: carrito.php'); // Recargar para evitar reposteo
    exit;
}

// Función para recalcular el total del carrito
function recalcularTotal() {
    global $conexion;
    if (!empty($_SESSION['carrito'])) {
        // Calcular el total del carrito y guardarlo en la sesión
        $total = 0;
        foreach ($_SESSION['carrito'] as $id_producto => $cantidad) {
            $id_producto = mysqli_real_escape_string($conexion, $id_producto);
            $query = "SELECT precio FROM producto WHERE id_producto = '$id_producto'";
            $result = mysqli_query($conexion, $query);
            $producto = mysqli_fetch_assoc($result);
            if ($producto) {
                $total += $producto['precio'] * $cantidad;
            } else {
                // Si no se encuentra el producto, eliminarlo del carrito
                unset($_SESSION['carrito'][$id_producto]);
            }
        }
        $_SESSION['total'] = $total; // Guardar el total en la sesión
    } else {
        $_SESSION['total'] = 0;
    }
}

// Verificar si el total es mayor a 0 antes de procesar el pago
if (isset($_POST['pagar'])) {
    recalcularTotal(); // Asegurarse de que el total esté actualizado antes de proceder al pago
    if (!isset($_SESSION['total']) || $_SESSION['total'] <= 0) {
        echo "Error: El total debe ser mayor que 0 para proceder al pago.";
    } else {
        // Persistir los datos del carrito antes de redirigir al pago
        $_SESSION['detalle_compra'] = $_SESSION['carrito'];
        $_SESSION['total_compra'] = $_SESSION['total'];
        // Regenerar ID de sesión antes de redirigir al pago para evitar problemas de sesión perdida
        session_regenerate_id(true);
        header('Location: webpay.php?action=init'); // Redirige a webpay.php para iniciar el pago
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <style>
        #map {
            height: 500px;
            margin-top: 20px;
            border: 2px solid #ddd;
            border-radius: 8px;
        }
        .product-img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 5px;
        }
        .table th, .table td {
            vertical-align: middle;
        }
        .empty-comparator {
            text-align: center;
            margin-top: 20px;
        }
        .back-to-store {
            margin-top: 20px;
            display: block;
            text-align: center;
        }
        .btnback-to-store{
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .table-comparison {
            margin-top: 20px;
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
        body {
            background-color: #f8f9fa;
        }
        .quantity-input {
            text-align: center;
            width: 50px;
            font-size: 1rem;
        }
        .input-group {
            display: inline-flex;
            align-items: center;
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
                                <a class="dropdown-item" href="../lista_deseos/lista_deseos.php">Lista deseos</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="../comparador/comparador.php">Comparador</a>
                            </li>
                            <li>
                                <a class="dropdown-item text-danger" href="../login/logout.php">Cerrar Sesión</a>
                            </li>
                        </ul>
                    </li>
                <?php endif ?>
            </ul>
        </div>
    </div>
</nav>
</head>
<body>
<div class="container py-5">
    <h2 class="mb-4">Carrito de Compras</h2>
    <?php if (empty($_SESSION['carrito'])): ?>
        <div class="text-center py-5">
            <img src="../icono_carrito.png" alt="Carrito vacío" style="width: 100px; height: auto;">
            <h3 class="mt-4">Aún no tienes productos agregados</h3>
            <p class="text-muted">¡Puedes ver nuestras categorías destacadas y hacer tu primera compra con nosotros!</p>
            <a href="../index.php" class="btn btn-secondary">Regresar al catalogo</a>
        </div>
    <?php else: ?>
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Imagen</th>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $exceeds_stock = false; // Flag para verificar si alguna cantidad excede el stock
                foreach ($_SESSION['carrito'] as $id_producto => $cantidad):
                    $id_producto = mysqli_real_escape_string($conexion, $id_producto);
                    $query = "SELECT nombre_producto, imagen_url, precio, cantidad FROM producto WHERE id_producto = '$id_producto'";
                    $result = mysqli_query($conexion, $query);
                    $producto = mysqli_fetch_assoc($result);
                    if ($producto) {
                        $precio_total = $producto['precio'] * $cantidad;
                        if ($cantidad > $producto['cantidad']) {
                            $exceeds_stock = true; // Marcar si la cantidad excede el stock
                        }
                ?>
                    <tr>
                        <td><img src="<?php echo htmlspecialchars($producto['imagen_url']); ?>" alt="<?php echo htmlspecialchars($producto['nombre_producto']); ?>" style="width: 50px; height: auto;"></td>
                        <td><?php echo htmlspecialchars($producto['nombre_producto']); ?></td>
                        <td>
                            <div class="input-group" style="max-width: 150px;">
                                <button type="button" class="btn btn-outline-secondary" onclick="decrement('<?php echo $id_producto; ?>', <?php echo $producto['cantidad']; ?>)">-</button>
                                <input type="text" name="cantidad" id="cantidad_<?php echo $id_producto; ?>" value="<?php echo $cantidad; ?>" class="form-control text-center quantity-input" readonly>
                                <button type="button" class="btn btn-outline-secondary" onclick="increment('<?php echo $id_producto; ?>', <?php echo $producto['cantidad']; ?>)">+</button>
                            </div>
                            <small class="text-muted">Disponibles: <?php echo $producto['cantidad']; ?></small>
                        </td>
                        <td id="precio_<?php echo $id_producto; ?>"><?php echo "$" . number_format($precio_total, 0, ',', '.'); ?></td>
                        <td>
                        <form method="POST" action="carrito.php">
                                <input type="hidden" name="id_producto" value="<?php echo $id_producto; ?>">
                                <button type="submit" name="eliminar_producto" class="btn btn-danger">Eliminar</button>
                        </form>
                        </td>
                    </tr>
                <?php } endforeach; ?>
            </tbody>
        </table>
        <h4>Total: $<span id="total"><?php echo number_format($_SESSION['total'] ?? 0, 0, ',', '.'); ?></span></h4>
        <div class="mt-1">
            <form id="formCotizacion" action="../boleta_cotizacion/cotizacion.php" method="POST">
                <input type="hidden" name="correo" value="<?php echo $correoE; ?>">
                <button type="button" class="btn btn-primary" onclick="confirmarEnvio()">Enviar cotización carro</button>
            </form>
        </div>
        <hr>
        <h2>Selecciona tu punto de retiro más cercano</h2>
        <!-- Formulario para ingresar dirección -->
        <form id="direccionForm" class="form-direccion">
            <div class="mb-3">
                <label for="direccion" class="form-label">Ingresa tu dirección:</label>
                <input type="text" id="direccion" class="form-control" placeholder="Ejemplo: Calle Falsa 123, Concepción, Chile" required>
            </div>
            <button type="button" id="buscarDireccion" class="btn btn-primary">Buscar</button>
        </form>
        <!-- Mapa-->
        <div id="map"></div>
        <p id="puntoCercano" class="mt-3"></p>
        <hr>
        <form method="POST" action="carrito.php" id="formPagoCarrito" style="display: none;">
            <input type="hidden" name="total" value="<?php echo $_SESSION['total'] ?? 0; ?>">
            <input type="hidden" name="punto_retiro" id="punto_retiro_input">
            <button type="submit" name="pagar" class="btn btn-primary" id="pagarButton">Proceder al Pago</button>
        </form>

        <form method="POST" action="../boleta_cotizacion/boleta.php" id="formPagoCarrito" style="display: none;">
            <input type="hidden" name="punto_retiro" id="punto_retiro_input">
            <button type="submit" name="pagar" class="btn btn-primary" id="pagarButton">Proceder al Pago</button>
        </form>
    <?php endif; ?>
</div>

<script>
    const map = L.map('map').setView([-36.82699, -73.04977], 13);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    const puntosRetiro = [
        { nombre: "Sucursal Centro - Chilexpress", lat: -36.82656, lng: -73.04867 },
        { nombre: "Sucursal Collao - Correos de Chile", lat: -36.82514, lng: -73.06874 },
        { nombre: "Sucursal Laguna Redonda - Starken", lat: -36.80997, lng: -73.04842 },
        { nombre: "Sucursal Universidad de Concepción - DHL", lat: -36.82012, lng: -73.03653 }
    ];

    let marcadorDireccion = null; // Marcador para la dirección ingresada
    let marcadorSeleccionado = null; // Marcador para el punto seleccionado
    let puntoSeleccionado = null; // Variable para guardar el nombre del punto seleccionado

    // Ícono personalizado para la dirección ingresada
    const direccionIcon = L.icon({
    iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-green.png', // URL confiable para un ícono verde
    shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/images/marker-shadow.png', // Sombra del marcador
    iconSize: [25, 41], // Tamaño del ícono
    iconAnchor: [12, 41], // Punto de anclaje
    popupAnchor: [1, -34], // Punto de anclaje para el popup
    shadowSize: [41, 41] // Tamaño de la sombra
    });

    // Mostrar los puntos de retiro en el mapa
    puntosRetiro.forEach(punto => {
        const marcador = L.marker([punto.lat, punto.lng])
            .addTo(map)
            .bindPopup(
                `<b>${punto.nombre}</b><br>
                <button onclick="seleccionarPunto('${punto.nombre}', ${punto.lat}, ${punto.lng}, false)">
                    Seleccionar este punto
                </button>`
            );
        punto.marcador = marcador;
    });

    // Evento para buscar la dirección ingresada
    document.getElementById('buscarDireccion').addEventListener('click', () => {
        const direccion = document.getElementById('direccion').value;

        if (direccion.trim() === "") {
            alert("Por favor, ingresa una dirección válida.");
            return;
        }

        // Buscar la dirección usando OpenStreetMap (Nominatim)
        fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(direccion)}`)
            .then(response => response.json())
            .then(data => {
                if (data.length === 0) {
                    alert("No se encontró la dirección. Intenta nuevamente.");
                    return;
                }

                const { lat, lon } = data[0]; // Coordenadas de la dirección ingresada

                // Mostrar la dirección en el mapa con el ícono personalizado
                if (marcadorDireccion) map.removeLayer(marcadorDireccion);
                marcadorDireccion = L.marker([lat, lon], { icon: direccionIcon })
                    .addTo(map)
                    .bindPopup("Tu dirección")
                    .openPopup();

                // Encontrar el punto de retiro más cercano
                let distanciaMinima = Infinity;
                let puntoCercano = null;

                puntosRetiro.forEach(punto => {
                    const distancia = calcularDistancia(lat, lon, punto.lat, punto.lng);
                    if (distancia < distanciaMinima) {
                        distanciaMinima = distancia;
                        puntoCercano = punto;
                    }
                });

                // Seleccionar automáticamente el punto más cercano
                if (puntoCercano) {
                    seleccionarPunto(puntoCercano.nombre, puntoCercano.lat, puntoCercano.lng, true);
                }

                // Mostrar mensaje del punto más cercano
                const mensaje = `El punto de retiro más cercano es: <b>${puntoCercano.nombre}</b>.`;
                document.getElementById('puntoCercano').innerHTML = mensaje;
            })
            .catch(error => console.error("Error al buscar la dirección:", error));
    });

    // Función para seleccionar un punto de retiro
    function seleccionarPunto(nombre, lat, lng, esRecomendado = false) {
        // Eliminar el marcador anterior si existe
        if (marcadorSeleccionado) map.removeLayer(marcadorSeleccionado);

        // Crear un nuevo marcador para el punto seleccionado
        marcadorSeleccionado = L.marker([lat, lng], {
            icon: L.icon({
                iconUrl: esRecomendado
                    ? 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/images/marker-icon.png'
                    : 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/images/marker-icon-red.png',
                iconSize: [25, 41],
                iconAnchor: [12, 41],
                popupAnchor: [1, -34],
                shadowSize: [41, 41]
            })
        }).addTo(map).bindPopup(`<b>${nombre}</b><br><i>${esRecomendado ? "Punto recomendado (seleccionado)" : "Punto seleccionado"}</i>`).openPopup();

        // Actualizar el punto seleccionado
        puntoSeleccionado = nombre;

        // Mostrar el mensaje del punto seleccionado
        document.getElementById('puntoCercano').innerHTML = `Has seleccionado: <b>${nombre}</b> como tu punto de retiro.${esRecomendado ? " Este es el punto recomendado." : ""}`;

        // Actualizar el valor del campo oculto
        document.getElementById('punto_retiro_input').value = nombre;

        // Mostrar el botón "Proceder al Pago"
        document.getElementById("formPagoCarrito").style.display = "block";
    }

    // Función para calcular la distancia entre dos coordenadas
    function calcularDistancia(lat1, lon1, lat2, lon2) {
        const R = 6371; // Radio de la Tierra en km
        const dLat = (lat2 - lat1) * Math.PI / 180;
        const dLon = (lon2 - lon1) * Math.PI / 180;
        const a =
            Math.sin(dLat / 2) * Math.sin(dLat / 2) +
            Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
            Math.sin(dLon / 2) * Math.sin(dLon / 2);
        const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
        return R * c;
    }
</script>


<script>
function confirmarEnvio() {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "Se enviará una cotización de los productos en tu carrito.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, enviar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('formCotizacion').submit();
        }
    });
}
</script>
<script>
// Funciones para incrementar y decrementar la cantidad de productos, actualizar el carrito y total.
function increment(id_producto, maxCantidad) {
    const input = document.getElementById(`cantidad_${id_producto}`);
    if (parseInt(input.value) < maxCantidad) {
        input.value = parseInt(input.value) + 1;
        updateCart(id_producto, input.value);
    } else {
        alert('Cantidad supera el stock disponible');
    }
}

function decrement(id_producto, maxCantidad) {
    const input = document.getElementById(`cantidad_${id_producto}`);
    if (parseInt(input.value) > 1) {
        input.value = parseInt(input.value) - 1;
        updateCart(id_producto, input.value);
    }
}

// Actualizar el carrito con AJAX y recalcular el total
function updateCart(id_producto, nuevaCantidad) {
    const formData = new FormData();
    formData.append('editar_carrito', true);
    formData.append('id_producto', id_producto);
    formData.append('cantidad', nuevaCantidad);

    fetch('carrito.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        // Recargar la página para actualizar el total y los precios
        location.reload();
    })
    .catch(error => console.error('Error:', error));
}
</script>

</body>
</html>
