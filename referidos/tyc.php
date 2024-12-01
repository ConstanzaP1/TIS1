<?php
session_start();
require('../conexion.php');
// Consulta para obtener la URL de la imagen del usuario actual
$user_id = $_SESSION['user_id']; // ID del usuario en sesión
$query = "SELECT img FROM users WHERE id = ?";
$stmt = $conexion->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

// Imagen por defecto si no hay ninguna en la BD
$img_url = $row['img'] ?? 'default-profile.png'; 
    
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Términos y Condiciones</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .navbar { background-color: rgba(0, 128, 255, 0.5); }
        .rounded-circle { object-fit: cover; width: 50px; height: 50px; }
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

    <header class="bg-primary text-white text-center py-3">
        <h1>Términos y Condiciones</h1>
    </header>

    <div class="container my-5 bg-white p-4 shadow-sm rounded">
        <p class="lead">
            Bienvenido a Tisnology Concepción. Los siguientes términos y condiciones (en adelante, "Términos") regulan el uso de nuestro sitio web. 
            Al acceder y utilizar este sitio web, usted acepta los Términos y Condiciones descritos a continuación. Si no está de acuerdo con estos Términos, le pedimos que se abstenga de usar el sitio.
        </p>

        <ol class="list-group list-group-numbered">
            <li class="list-group-item">
                <strong>Información General:</strong> 
                Tisnology Concepción está ubicada en Joaquín Prieto 289, Concepción. Al utilizar este sitio web, usted acepta cumplir con estos Términos y con nuestra política de privacidad. 
                Cualquier referencia a "nosotros", "nuestro" o "la compañía" hace referencia a Tisnology Concepción. 
                Cualquier mención a "usted", "su" o "cliente" se refiere a la persona que accede o usa el sitio web.
            </li>
            <li class="list-group-item">
                <strong>Uso de Cookies:</strong> 
                Nuestro sitio web utiliza cookies para mejorar su experiencia de usuario. Al navegar en Tisnology Concepción, usted acepta el uso de cookies de acuerdo con nuestra Política de Privacidad.
            </li>
            <li class="list-group-item">
                <strong>Propiedad Intelectual:</strong> 
                Tisnology Concepción y sus licenciantes son los propietarios de todos los derechos de propiedad intelectual relacionados con el contenido de este sitio web, incluyendo, pero no limitado a, textos, imágenes, logotipos y otros elementos.
            </li>
            <li class="list-group-item">
                <strong>Exoneración de Responsabilidad:</strong> 
                En la medida máxima permitida por la ley, Tisnology Concepción no asume ninguna responsabilidad por cualquier daño o pérdida derivada del uso de este sitio web...
            </li>
            <li class="list-group-item">
                <strong>Limitación de Responsabilidad:</strong> 
                Las siguientes exclusiones de responsabilidad no se aplican en caso de que sean causadas por negligencia grave o conducta fraudulenta.
            </li>
            <li class="list-group-item">
                <strong>Modificaciones:</strong> 
                Tisnology Concepción se reserva el derecho de modificar estos Términos y Condiciones en cualquier momento. 
                Las modificaciones serán efectivas inmediatamente después de su publicación en el sitio web.
            </li>
            <li class="list-group-item">
                <strong>Ley Aplicable:</strong> 
                Estos Términos y Condiciones se rigen por la legislación vigente en Chile. Cualquier disputa relacionada con el uso de este sitio será resuelta en los tribunales competentes de Concepción, Chile.
            </li>
        </ol>
    </div>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <?php include "../footer.php"?>

    </body>
</html>
