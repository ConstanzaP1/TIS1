<?php
session_start();
require('../conexion.php');

// Verificar si hay un usuario autenticado
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login/login.php');
    exit;
}

$userId = $_SESSION['user_id'];

// Obtener datos del usuario
$stmt = $conexion->prepare("SELECT id, username, email, role, img FROM users WHERE id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $userData = $result->fetch_assoc();
    $username = $userData['username'];
    $email = $userData['email'];
    $role = $userData['role'];
    $img_url = !empty($userData['img']) ? $userData['img'] : '../imagenes/default-profile.png';
} else {
    header('Location: ../login/login.php');
    exit;
}
$stmt->close();

// Verificar si se envió la consulta para una boleta específica
$boletaId = $_GET['id_boleta'] ?? null;
$consultaExistente = false;

if ($boletaId) {
    $stmt = $conexion->prepare("SELECT id FROM atencion_postventa WHERE cliente_email = ? AND id_boleta = ?");
    $stmt->bind_param("si", $email, $boletaId);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $consultaExistente = true;
    }
    $stmt->close();
}

// Procesar el formulario de consulta
$successMessage = '';
$errorMessage = '';
if (isset($_GET['success']) && $_GET['success'] == 1) {
    $successMessage = "Tu consulta ha sido enviada. Nos pondremos en contacto pronto.";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !$consultaExistente) {
    $pregunta = trim($_POST['pregunta'] ?? '');

    if (!empty($pregunta)) {
        $stmt = $conexion->prepare("INSERT INTO atencion_postventa (cliente_nombre, cliente_email, id_boleta, pregunta, fecha_pregunta) VALUES (?, ?, ?, ?, NOW())");
        $stmt->bind_param("ssis", $username, $email, $boletaId, $pregunta);

        if ($stmt->execute()) {
            // Redirigir al usuario después de procesar el formulario
            header("Location: postventa.php?id_boleta=" . $boletaId . "&success=1");
            exit;
        } else {
            $errorMessage = "Ocurrió un error al enviar tu consulta. Inténtalo nuevamente.";
        }
        $stmt->close();
    }
}

// Obtener los detalles de la boleta
$boletaDetalles = [];
if ($boletaId) {
    $stmt = $conexion->prepare("SELECT detalles FROM boletas WHERE id_boleta = ?");
    $stmt->bind_param("i", $boletaId);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $boletaDetalles = json_decode($result->fetch_assoc()['detalles'], true);
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atención Postventa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .navbar { background-color: rgba(0, 128, 255, 0.5); }
        .rounded-circle { object-fit: cover; width: 50px; height: 50px; }
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
<div class="container mt-5">
    <h2>Atención Postventa</h2>

    <?php if ($boletaDetalles): ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio Unitario</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($boletaDetalles as $detalle): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($detalle['producto']); ?></td>
                        <td><?php echo htmlspecialchars($detalle['cantidad']); ?></td>
                        <td><?php echo "$" . number_format($detalle['precio_unitario'], 0, ',', '.'); ?></td>
                        <td><?php echo "$" . number_format($detalle['total'], 0, ',', '.'); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p class="text-danger">No se encontraron detalles para esta boleta.</p>
    <?php endif; ?>

    <?php if ($consultaExistente): ?>
        <div class="alert alert-info">Ya has enviado una consulta para esta boleta. Por favor, espera nuestra respuesta.</div>
    <?php else: ?>
        <form method="POST">
            <div class="mb-3">
                <label for="pregunta" class="form-label">Escribe tu consulta:</label>
                <textarea name="pregunta" id="pregunta" class="form-control" rows="5"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Enviar</button>
        </form>
    <?php endif; ?>

    <a href="../perfil_usuario/perfil_usuario.php" class="btn btn-secondary mt-3">Volver</a>
</div>

<?php if ($successMessage): ?>
    <script>
        Swal.fire({
            icon: 'success',
            title: '<?php echo addslashes($successMessage); ?>',
            toast: true,
            position: 'top-end',
            timer: 3000,
            timerProgressBar: true,
            showConfirmButton: false
        });
    </script>
<?php elseif ($errorMessage): ?>
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: '<?php echo addslashes($errorMessage); ?>',
            toast: true,
            position: 'top-end',
            timer: 3000,
            timerProgressBar: true,
            showConfirmButton: false
        });
    </script>
<?php endif; ?>
<?php include "../footer.php"?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
