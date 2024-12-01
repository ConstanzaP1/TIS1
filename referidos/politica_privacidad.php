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
    <title>Política de Privacidad</title>
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
        <h1>Política de Privacidad</h1>
    </header>

    <div class="container my-5 bg-white p-4 shadow-sm rounded">
        <p class="lead">
            Esta Política de Privacidad describe cómo recopilamos, usamos y compartimos tu información personal cuando visitas o realizas una compra en nuestro sitio web
        </p>

        <h2 class="mt-4">Qué Información Personal Recopilamos</h2>
        <h3 class="mt-3">Información del Dispositivo</h3>
        <p>Cuando visitas nuestro sitio web, recopilamos automáticamente cierta información sobre tu dispositivo, incluyendo:</p>
        <ul>
            <li>El navegador web que usas.</li>
            <li>La dirección IP.</li>
            <li>La zona horaria.</li>
            <li>Algunas de las cookies instaladas en tu dispositivo.</li>
        </ul>
        <p>Mientras navegas por el sitio, también recopilamos información sobre las páginas web o productos que ves, los sitios web o términos de búsqueda que te remitieron al sitio e información sobre cómo interactúas con el sitio. Nos referimos a esta información como <strong>Información del Dispositivo</strong>.</p>

        <h3>Información del Pedido</h3>
        <p>Cuando realizas una compra o intentas realizarla en nuestro sitio, recopilamos la siguiente información personal:</p>
        <ul>
            <li>Nombre completo.</li>
            <li>Dirección de facturación.</li>
            <li>Dirección de envío.</li>
            <li>Información de pago (incluyendo números de tarjetas de crédito y otros métodos de pago aceptados).</li>
            <li>Dirección de correo electrónico.</li>
            <li>Número de teléfono.</li>
        </ul>
        <p>Al hablar de <strong>Información Personal</strong> en esta Política de Privacidad, nos referimos tanto a la Información del Dispositivo como a la Información del Pedido.</p>

        <h2 class="mt-4">Cómo Usamos tu Información Personal</h2>
        <p>Usamos la Información del Pedido para cumplir con los pedidos realizados a través de nuestro sitio web, lo que incluye:</p>
        <ul>
            <li>Procesar tu información de pago.</li>
            <li>Organizar el envío.</li>
            <li>Enviar facturas y/o confirmaciones de pedidos.</li>
        </ul>
        <p>También utilizamos esta información para:</p>
        <ul>
            <li>Comunicarnos contigo.</li>
            <li>Revisar nuestros pedidos en busca de posibles riesgos o fraudes.</li>
            <li>Ofrecerte información o publicidad relacionada con nuestros productos y servicios, de acuerdo con tus preferencias.</li>
        </ul>

        <h2 class="mt-4">Compartiendo tu Información Personal</h2>
        <p>Compartimos tu Información Personal con terceros para ayudarnos a utilizarla como se describe en esta política. Estos terceros incluyen:</p>
        <ul>
            <li><strong>Google Analytics:</strong> Para ayudarnos a comprender cómo los clientes usan nuestro sitio web. Google puede usar tu Información Personal conforme a su Política de Privacidad.</li>
            <li><strong>Proveedores de servicios de pago y envío:</strong> Para completar el procesamiento de tus pedidos.</li>
            <li>Otros terceros proveedores que prestan servicios en nombre de Tisnology Concepción.</li>
        </ul>
        <p>También podemos compartir tu Información Personal para cumplir con las leyes y regulaciones aplicables, responder a solicitudes legales como citaciones u órdenes judiciales o proteger nuestros derechos legales.</p>

        <h2 class="mt-4">Publicidad de Comportamiento</h2>
        <p>Usamos tu Información Personal para ofrecerte anuncios específicos o comunicaciones de marketing que creemos que pueden ser de tu interés. Algunos de los servicios de publicidad de comportamiento que utilizamos incluyen:</p>
        <ul>
            <li>Facebook Ads.</li>
            <li>Google Ads.</li>
        </ul>
        <p>Puedes inhabilitar la publicidad dirigida a través de los siguientes enlaces:</p>
        <ul>
            <li><a href="https://www.facebook.com/settings/?tab=ads" target="_blank">Desactivar anuncios de Facebook</a>.</li>
            <li><a href="https://adssettings.google.com/authenticated" target="_blank">Desactivar anuncios de Google</a>.</li>
        </ul>

        <h2 class="mt-4">Tus Derechos</h2>
        <p>Si eres un residente europeo, tienes derecho a:</p>
        <ul>
            <li>Acceder a la información personal que tenemos sobre ti.</li>
            <li>Solicitar que corrijamos, actualicemos o eliminemos tu información personal.</li>
        </ul>
        <p>Para ejercer estos derechos, por favor contáctanos utilizando la información de contacto que aparece al final de esta política.</p>

        <h2 class="mt-4">Retención de Datos</h2>
        <p>Cuando realizas un pedido a través de nuestro sitio, mantenemos tu Información de Pedido para nuestros registros, a menos que solicites la eliminación de dicha información.</p>

        <h2 class="mt-4">Menores de Edad</h2>
        <p>El sitio no está destinado a personas menores de 18 años. No recopilamos deliberadamente información de personas menores de edad.</p>

        <h2 class="mt-4">Cambios en esta Política de Privacidad</h2>
        <p>Podemos actualizar esta Política de Privacidad de vez en cuando para reflejar cambios en nuestras prácticas o por razones operativas, legales o reglamentarias. Te notificaremos sobre cualquier cambio importante publicando la nueva política en nuestro sitio web y actualizando la fecha al final de esta página.</p>

        <h2 class="mt-4">Contacto</h2>
        <p>Si tienes preguntas o necesitas más información sobre nuestra política de privacidad, no dudes en ponerte en contacto con nosotros en:</p>
        <p><strong>Correo electrónico:</strong> <a href="mailto:tisnology1@gmail.com">tisnology1@gmail.com</a></p>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    </body>
    <?php include "../footer.php"?>

</html>
