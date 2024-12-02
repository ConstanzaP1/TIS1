<?php
session_start();
require('../conexion.php'); // Conexión a la base de datos
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
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['accion'] === 'actualizar_cantidad') {
    $id_producto = mysqli_real_escape_string($conexion, $_POST['id_producto']);
    $cantidad = (int)$_POST['cantidad'];

    // Consultar el stock disponible y el precio del producto
    $query = "SELECT cantidad, precio FROM producto WHERE id_producto = '$id_producto'";
    $result = mysqli_query($conexion, $query);
    $producto = mysqli_fetch_assoc($result);

    if ($producto) {
        // Validar si la cantidad seleccionada no supera el stock disponible
        if ($cantidad > $producto['cantidad']) {
            // Si la cantidad excede el stock, devolver un error claro
            echo json_encode([
                'error' => 'La cantidad seleccionada supera el stock disponible. Por favor, reduce la cantidad.'
            ]);
            exit; // Detener la ejecución si hay un error
        }

        // Actualizar la cantidad en el carrito si la cantidad es válida
        $_SESSION['carrito'][$id_producto] = $cantidad;
        $precio_actualizado = $producto['precio'] * $cantidad;

        // Calcular el total actualizado
        $total_actualizado = 0;
        foreach ($_SESSION['carrito'] as $id => $cant) {
            $query_total = "SELECT precio FROM producto WHERE id_producto = '$id'";
            $result_total = mysqli_query($conexion, $query_total);
            $producto_total = mysqli_fetch_assoc($result_total);
            $total_actualizado += $producto_total['precio'] * $cant;
        }

        $_SESSION['total'] = $total_actualizado;

        // Responder con el precio actualizado y el total
        echo json_encode([
            'precioActualizado' => "$" . number_format($precio_actualizado, 0, ',', '.'),
            'totalActualizado' => "$" . number_format($total_actualizado, 0, ',', '.')
        ]);
    } else {
        // En caso de que el producto no exista
        echo json_encode([
            'error' => 'Producto no encontrado.'
        ]);
    }
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
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
        .btn-cat:hover {
        background-color: white; /* Cambia el fondo al pasar el mouse */
        color: black; /* Cambia el color del texto/icono */
        transform: scale(1.1); /* Hace que el botón crezca ligeramente */
        transition: all 0.3s ease; /* Suaviza la animación */
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
            <!-- Menú desplegable -->
            <ul class="navbar-nav ms-auto align-items-center">
                
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li class="nav-item">
    <button 
        class="btn btn-cat rounded-pill  px-3 py-3" 
        style=" color: #black; font-size: 0.85rem; font-weight: 500;"
        onclick="window.location.href='../catalogo_productos/catalogo.php'">
        Catálogo
    </button>
</li>
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
                <li class="nav-item">
                    <button 
                        class="nav-link  bg-white rounded-pill p-3" 
                        onclick="window.location.href='../catalogo_productos/catalogo.php'">
                        Ir al Catálogo
                    </button>
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
<body>
<!-- Migajas de pan -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb bg-light p-3 rounded shadow-sm">
            <li class="breadcrumb-item">
                <a href="../index.php" class="text-primary text-decoration-none">
                    <i class="fas fa-home me-1"></i>Inicio
                </a>
            </li>
            <li class="breadcrumb-item">
                <a href="../catalogo_productos/catalogo.php" class="text-primary text-decoration-none">
                    Catalogo
                </a>
            </li>
            <li class="breadcrumb-item active text-dark" aria-current="page">
                Carrito de Compras
            </li>
        </ol>
    </nav>
<!-- Fin Migajas de pan -->
<div class="container py-5">
    <h2 class="mb-4 text-center text-md-start">Tu carro (<?php echo count($_SESSION['carrito'] ?? []); ?> productos)</h2>

    <?php if (empty($_SESSION['carrito'])): ?>
        <div class="text-center py-5">
            <img src="../icono_carrito.png" alt="Carrito vacío" class="img-fluid mb-4">
            <h3 class="mt-4">Aún no tienes productos agregados</h3>
            <p class="text-muted">¡Puedes ver nuestras categorías destacadas y hacer tu primera compra con nosotros!</p>
            <a href="../index.php" class="btn btn-secondary">Regresar al catálogo</a>
        </div>
    <?php else: ?>
        <div class="row">
            <div class="col-lg-8 mb-4">
                <table class="table table-borderless align-middle table-responsive-sm">
                    <thead class="text-center">
                        <tr>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Precio</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($_SESSION['carrito'] as $id_producto => $cantidad):
                            $query = "SELECT nombre_producto, imagen_url, precio, cantidad FROM producto WHERE id_producto = '$id_producto'";
                            $result = mysqli_query($conexion, $query);
                            $producto = mysqli_fetch_assoc($result);

                            if ($producto):
                                $precio_total = $producto['precio'] * $cantidad;
                        ?>
                        <tr>
                            <td>
                                <div class="d-flex flex-column flex-sm-row align-items-center text-center text-sm-start">
                                    <img src="<?php echo htmlspecialchars($producto['imagen_url']); ?>" 
                                         alt="<?php echo htmlspecialchars($producto['nombre_producto']); ?>" 
                                         class="img-fluid mb-2 mb-sm-0 me-sm-3" 
                                         style="width: 80px; height: auto;">
                                    <div>
                                        <h6 class="mb-1"><?php echo htmlspecialchars($producto['nombre_producto']); ?></h6>
                                    </div>
                                </div>
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center align-items-center">
                                    <button class="btn btn-light btn-sm me-2" onclick="decrement('<?php echo $id_producto; ?>')">-</button>
                                    <input type="number" name="cantidad" id="cantidad_<?php echo $id_producto; ?>" 
                                           value="<?php echo $cantidad; ?>" 
                                           class="form-control text-center" 
                                           min="1" max="<?php echo $producto['cantidad']; ?>" 
                                           style="width: 60px;" 
                                           onchange="actualizarCantidad('<?php echo $id_producto; ?>', this.value)">
                                    <button class="btn btn-light btn-sm ms-2" onclick="increment('<?php echo $id_producto; ?>', <?php echo $producto['cantidad']; ?>)">+</button>
                                </div>
                                <small class="text-muted d-block mt-1">Disponibles: <?php echo $producto['cantidad']; ?></small>
                            </td>
                            <td class="text-center" id="precio_<?php echo $id_producto; ?>">
                                <strong>$<?php echo number_format($precio_total, 0, ',', '.'); ?></strong>
                            </td>
                            <td class="text-center">
                                <form method="POST" action="carrito.php">
                                    <input type="hidden" name="id_producto" value="<?php echo $id_producto; ?>">
                                    <button type="submit" name="eliminar_producto" class="btn btn-danger btn-sm">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                        <?php
                            endif;
                        endforeach;
                        ?>
                    </tbody>
                </table>
            </div>

            <div class="col-lg-4">
                <div class="border rounded p-3 bg-light">
                    <h5 class="text-center text-lg-start">Resumen de tu compra</h5>
                    <div class="d-flex justify-content-between py-2 border-bottom">
                        <span>Total:</span>
                        <strong>$<?php echo number_format($_SESSION['total'] ?? 0, 0, ',', '.'); ?></strong>
                    </div>
                    <a href="../index.php" class="btn btn-secondary w-100">Agregar más productos</a>
                    <form method="POST" action="../boleta_cotizacion/cotizacion.php" class="mt-2">
                        <input type="hidden" name="correo" id="correo" value="<?php echo htmlspecialchars($correoE); ?>" readonly>
                        <button type="button" class="btn btn-success w-100" onclick="enviarCotizacion()">Enviar Cotización</button>
                    </form>
                    <form method="POST" action="carrito.php" id="formPagoCarrito" class="mt-2">
                        <input type="hidden" name="total" value="<?php echo $_SESSION['total'] ?? 0; ?>">         
                        <button type="submit" name="pagar" class="btn btn-primary w-100">Proceder al pago</button>
                    </form>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php include "../footer.php"; ?>

<script>
function enviarCotizacion() {
    fetch('../boleta_cotizacion/cotizacion.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'correo=' + encodeURIComponent(document.getElementById('correo').value)
    })
    .then(response => response.json()) // Procesa la respuesta JSON
    .then(data => {
        // Mostrar notificación con SweetAlert2
        Swal.fire({
            icon: data.status,

            text: data.message,
            toast: true,
            position: 'top-end',
            timer: 3000,
            timerProgressBar: true,
            showConfirmButton: false
        });

        // Recargar la página si el envío fue exitoso
        if (data.status === 'success') {
            setTimeout(() => location.reload(), 3000);
        }
    })
    .catch(error => {
        console.error("Error:", error);

        // Mostrar alerta en caso de error
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Ocurrió un error al procesar la solicitud.',
            toast: true,
            position: 'top-end',
            timer: 3000,
            timerProgressBar: true,
            showConfirmButton: false
        });
    });
    }
</script>
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
// Función para actualizar la cantidad en el carrito
function actualizarCantidad(idProducto, nuevaCantidad) {
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "carrito.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    // Enviar datos al servidor
    xhr.onload = function () {
        if (xhr.status === 200) {
            const respuesta = JSON.parse(xhr.responseText);

            if (respuesta.error) {
                alert(respuesta.error); // Mostrar el error recibido del servidor
            } else {
                // Actualizar precio y total en el cliente
                document.getElementById(`precio_${idProducto}`).innerText = respuesta.precioActualizado;
                document.getElementById("total").innerText = respuesta.totalActualizado;
            }
        }
    };

    xhr.send(`accion=actualizar_cantidad&id_producto=${idProducto}&cantidad=${nuevaCantidad}`);
}

// Función para mostrar mensaje de error debajo del campo de cantidad
function mostrarMensajeError(mensaje, idProducto) {
    const errorElement = document.getElementById(`error_${idProducto}`);
    errorElement.innerHTML = mensaje;
    errorElement.style.display = 'block'; // Mostrar el mensaje de error
}

// Función para ocultar el mensaje de error cuando el carrito es actualizado correctamente
function ocultarMensajeError(idProducto) {
    const errorElement = document.getElementById(`error_${idProducto}`);
    errorElement.style.display = 'none'; // Ocultar el mensaje de error
}

document.querySelectorAll("form").forEach(form => {
    form.addEventListener("submit", function(e) {
        const cantidadInput = this.querySelector("input[name='cantidad']");
        const stockDisponible = parseInt(cantidadInput.max); // Stock máximo permitido
        const cantidadSeleccionada = parseInt(cantidadInput.value); // Cantidad seleccionada

        if (cantidadSeleccionada > stockDisponible) {
            e.preventDefault(); // Detener el envío del formulario
            // Mostrar mensaje emergente
            alert("No se puede agregar más stock del disponible. Por favor, ajusta la cantidad.");
        }
    });
});

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
function validarCantidadCarrito(input, maxStock) {
    const cantidadSeleccionada = parseInt(input.value);

    if (cantidadSeleccionada > maxStock) {
        input.setCustomValidity("La cantidad seleccionada supera el stock disponible. Por favor, reduce la cantidad.");
        input.reportValidity(); // Mostrar el mensaje emergente
    } else {
        input.setCustomValidity(""); // Eliminar mensaje si la cantidad es válida
        actualizarCantidad(input.id.split("_")[1], cantidadSeleccionada); // Llama a actualizarCantidad
    }
}
function validarCantidad(input, maxStock) {
    const cantidadSeleccionada = parseInt(input.value);

    if (cantidadSeleccionada > maxStock) {
        // Mostrar el mensaje, pero permitir cambios en la cantidad
        input.setCustomValidity("No se puede agregar más stock del disponible.");
        input.reportValidity(); // Mostrar el mensaje inmediatamente
    } else {
        // Eliminar cualquier mensaje previo y permitir el cambio
        input.setCustomValidity("");
    }
}
function seleccionarPunto(nombre) {
    document.getElementById('punto_retiro_input').value = nombre;
    document.getElementById('formPagoCarrito').style.display = 'block'; // Mostrar el botón
}
</script>
</body>
</html>
