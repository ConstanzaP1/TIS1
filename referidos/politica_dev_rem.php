<?php
session_start();
require('../conexion.php');
// Consulta para obtener la URL de la imagen del usuario actual
$img_url = 'default-profile.png'; // Imagen por defecto
if (isset($_SESSION['user_id'])) {
    // Consulta para obtener la URL de la imagen del usuario actual
    $user_id = $_SESSION['user_id']; // ID del usuario en sesión
    $query = "SELECT img FROM users WHERE id = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    // Asignar la URL de la imagen o usar la imagen por defecto
    $img_url = $row['img'] ?? 'default-profile.png';
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Política de Devoluciones y Reembolsos</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
        <style>
        .navbar { background-color: rgba(0, 128, 255, 0.5); }
        .rounded-circle { object-fit: cover; width: 50px; height: 50px; }
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
    </style>
</head>
<body class="bg-light">
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
<nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb bg-light p-3 rounded shadow-sm">
            <li class="breadcrumb-item">
                <a href="../index.php" class="text-primary text-decoration-none">
                    <i class="fas fa-home me-1"></i>Inicio
                </a>
            </li>
            <li class="breadcrumb-item active text-dark" aria-current="page">
                Politica de Reembolso
            </li>
        </ol>
    </nav>
    <header class="bg-light text-black text-center py-3">
    <h1>Política de Devoluciones y Reembolsos</h1>
    </header>


    <div class="container my-5 bg-white p-4 shadow-sm rounded">
        <p class="lead">
            ¡Gracias por comprar en Tisnology Concepción! Queremos que estés completamente satisfecho con tu compra, por eso ofrecemos la opción de reembolso o cambio dentro de los primeros 30 días de tu compra. 
            Si han transcurrido más de 30 días desde tu compra, no podremos ofrecerte reembolso ni cambio.
        </p>

        <h2>Elegibilidad para Reembolsos y Cambios</h2>
        <ul class="list-group my-3">
            <li class="list-group-item">El artículo debe estar sin usar y en las mismas condiciones en que lo recibiste.</li>
            <li class="list-group-item">El artículo debe estar en su embalaje original.</li>
            <li class="list-group-item">Para completar tu devolución, es necesario presentar el recibo o comprobante de compra.</li>
            <li class="list-group-item">Solo se pueden reembolsar artículos de precio regular. Los artículos en oferta no se pueden reembolsar.</li>
            <li class="list-group-item">
                Si el artículo fue marcado como regalo al momento de la compra y se envió directamente a ti, recibirás un crédito de regalo por el valor de tu devolución.
            </li>
        </ul>

        <h2>Cambios (si aplica)</h2>
        <p>
            Solo reemplazamos artículos que estén defectuosos o dañados. Si necesitas cambiar un artículo por el mismo, por favor contáctanos a 
            <a href="mailto:tisnology1@gmail.com">tisnology1@gmail.com</a> y envía el artículo a la dirección que te proporcionaremos.
        </p>

        <h2>Bienes Exentos de Reembolso</h2>
        <ul class="list-group my-3">
            <li class="list-group-item">Tarjetas de regalo (gift cards).</li>
            <li class="list-group-item">Algunos artículos de salud y cuidado personal.</li>
        </ul>

        <h2>Reembolsos Parciales (si aplica)</h2>
        <ul class="list-group my-3">
            <li class="list-group-item">El artículo no se encuentra en su estado original.</li>
            <li class="list-group-item">El artículo está dañado o le falta alguna parte, por causas que no sean atribuibles a nuestro error.</li>
            <li class="list-group-item">El artículo es devuelto más de 30 días después de la entrega.</li>
        </ul>

        <h2>Procedimiento de Reembolso</h2>
        <p>
            Una vez recibamos e inspeccionemos tu devolución, te notificaremos por correo electrónico si tu artículo ha sido aprobado o rechazado para reembolso. 
            Si tu devolución es aprobada, procesaremos tu reembolso y el crédito se aplicará automáticamente a tu método de pago original, dentro de un plazo de X días 
            (dependiendo de tu banco o entidad financiera).
        </p>

        <h2>Reembolsos Atrasados o Faltantes</h2>
        <p>
            Si no has recibido tu reembolso:
        </p>
        <ul class="list-group my-3">
            <li class="list-group-item">Verifica nuevamente tu cuenta bancaria.</li>
            <li class="list-group-item">Contacta a tu compañía de tarjeta de crédito, ya que puede tomar tiempo antes de que se publique oficialmente el reembolso.</li>
            <li class="list-group-item">
                Si has seguido estos pasos y aún no recibes el reembolso, contáctanos a 
                <a href="mailto:tisnology1@gmail.com">tisnology1@gmail.com</a>.
            </li>
        </ul>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
<?php include "../footer.php"?>
</html>
