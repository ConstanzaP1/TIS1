<?php
session_start();
require('../conexion.php');

$userData = null;
$showModal = false; // Variable para controlar si se muestra el modal
// Consulta para obtener la URL de la imagen del usuario actual
$user_id = $_SESSION['user_id']; // Asegúrate de tener el ID del usuario en sesión
$query = "SELECT img FROM users WHERE id = ?";
$stmt = $conexion->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

// Verifica si se encontró la imagen
$img_url = $row['img'] ?? 'default-profile.png'; // Imagen por defecto si no hay una en la BD
if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
    $stmt = $conexion->prepare("SELECT id, username, email, role, img FROM users WHERE id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $userData = $result->fetch_assoc();
}
$stmt->close();



    $modalMessage = null;
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['profile_picture'])) {
        $newProfilePicture = trim($_POST['profile_picture']); // URL de la nueva imagen
    
        // Actualizar la URL de la imagen en la tabla `users`
        $updateStmt = $conexion->prepare("UPDATE users SET img = ? WHERE id = ?");
        $updateStmt->bind_param("si", $newProfilePicture, $userId); // Sustituir parámetros
        if ($updateStmt->execute()) {
            $userData['img'] = $newProfilePicture; // Actualizar en los datos obtenidos
           
        } else {
            $errorMessage = "Error al actualizar la imagen de perfil.";
        }
        $updateStmt->close();
    }
    
    
    // Cambiar el nombre de usuario
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['new_username'])) {
        $newUsername = trim($_POST['new_username']);
        if (!empty($newUsername)) {
            $checkStmt = $conexion->prepare("SELECT id FROM users WHERE username = ? AND id != ?");
            $checkStmt->bind_param("si", $newUsername, $userId);
            $checkStmt->execute();
            $checkResult = $checkStmt->get_result();
            if ($checkResult->num_rows > 0) {
                $modalMessage = "El nombre de usuario ya existe. Por favor, elija otro.";
            } else {
                $updateStmt = $conexion->prepare("UPDATE users SET username = ? WHERE id = ?");
                $updateStmt->bind_param("si", $newUsername, $userId);
                if ($updateStmt->execute()) {
                    $_SESSION['username'] = $newUsername;
                    $userData['username'] = $newUsername;
                    $modalMessage = "Nombre de usuario actualizado correctamente.";
                } else {
                    $modalMessage = "Error al actualizar el nombre de usuario.";
                }
                $updateStmt->close();
            }
            $checkStmt->close();
        } else {
            $modalMessage = "El nombre de usuario no puede estar vacío.";
        }
        $showModal = true;
    }

    // Cambiar el correo electrónico
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['new_email'])) {
        $newEmail = trim($_POST['new_email']);
        if (filter_var($newEmail, FILTER_VALIDATE_EMAIL)) {
            $checkStmt = $conexion->prepare("SELECT id FROM users WHERE email = ? AND id != ?");
            $checkStmt->bind_param("si", $newEmail, $userId);
            $checkStmt->execute();
            $checkResult = $checkStmt->get_result();
            if ($checkResult->num_rows > 0) {
                $modalMessage = "El correo electrónico ya está en uso. Por favor, elija otro.";
            } else {
                $updateStmt = $conexion->prepare("UPDATE users SET email = ? WHERE id = ?");
                $updateStmt->bind_param("si", $newEmail, $userId);
                if ($updateStmt->execute()) {
                    $userData['email'] = $newEmail;
                    $modalMessage = "Correo electrónico actualizado correctamente.";
                } else {
                    $modalMessage = "Error al actualizar el correo electrónico.";
                }
                $updateStmt->close();
            }
            $checkStmt->close();
        } else {
            $modalMessage = "El correo electrónico no es válido.";
        }
        $showModal = true;
    }
}
function obtenerTiposDeProducto()
{
    global $conexion;
    $query = "SELECT DISTINCT p.tipo_producto
              FROM producto p";
    $result = mysqli_query($conexion, $query);

    if (!$result) {
        die("Error en la consulta: " . mysqli_error($conexion));
    }

    // Almacenamos los tipos de productos únicos
    $tiposDeProducto = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $tiposDeProducto[] = $row['tipo_producto'];
    }

    return $tiposDeProducto;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de Usuario</title>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Symbols+Outlined" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">


</head>
<style>
    .user-info-card {
        background-color: #ffffff;
        border-radius: 15px;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        padding: 20px;
        max-width: 1200px;
        margin: 20px auto;
        
    }
    label img:hover {
    border-color: #007bff;
    transition: border-color 0.3s;
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
    
    .card-header{
        background-color: rgba(0, 128, 255, 0.5);   
    }
    .user-info-card h5 {
        color: #007bff;
        
    }
    .user-info-card p {
        margin: 5px 0;
    }

    .navbar{
        background-color: rgba(0, 128, 255, 0.5);   
    }
    .celeste-background{
        background-color: rgba(0, 128, 255, 0.5); 
        border-color: rgba(0, 128, 255, 0.5);   
    }
    .card-body{
        
        background-color: readdir;
    }
    .visibility-icon {
    font-size: 1.6rem;
    color: #007bff;
    
}
.alineado {
    display: flex;
    align-items: center;
    gap: 10px; /* Espacio entre el texto y el icono */
}

.alineado p {
    margin: 0;
}

.alineado span.material-symbols-outlined {
    font-size: 24px;
    cursor: pointer;
    color: #007bff;
}

</style>
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
            <!-- Logo centrado -->
            <a href="../index.php" class="mx-auto">
                <img class="logo img-fluid" src="../logopng.png" alt="Logo" style="width: 180px;">
            </a>
        </div>

        <!-- Contenido de la navbar -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <!-- Barra de búsqueda -->
            <form class="d-flex ms-auto col-4 shadow" role="search">
                <input class="form-control" type="search" placeholder="Buscar en Tisnology" aria-label="Buscar">
            </form>
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
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle bg-white rounded-pill p-3" type="button" id="productosDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        Categorias
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="productosDropdown">
                        <!-- Opción para todos los productos -->
                        <li>
                            <a class="dropdown-item" href="../catalogo_productos/catalogo.php">Todos los productos</a>
                        </li>
                        <?php 
                        // Opciones dinámicas basadas en tipos de producto
                        $tiposDeProducto = obtenerTiposDeProducto();
                        foreach ($tiposDeProducto as $tipo): ?>
                            <li>
                                <a class="dropdown-item text-capitalize" href="../catalogo_productos/catalogo.php?tipo_producto=<?php echo urlencode($tipo); ?>">
                                    <?php echo htmlspecialchars($tipo); ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
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
<!-- Migajas de pan -->
<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb bg-light p-3 rounded shadow-sm">
        <li class="breadcrumb-item">
            <a href="../index.php" class="text-primary text-decoration-none">
                <i class="fas fa-home me-1"></i>Inicio
            </a>
        </li>
        <li class="breadcrumb-item active text-dark" aria-current="page">
            Perfil
        </li>
    </ol>
</nav>
<!-- Fin Migajas de pan -->
<div class="user-info-card d-flex align-items-center">
    <div class="profile-picture-wrapper position-relative d-inline-block" style="width: 90px; height: 90px;">
        <!-- Foto de perfil -->
        <div class="profile-picture border rounded-circle" style="width: 100%; height: 100%; overflow: hidden;">
            <img id="currentProfilePicture" 
                src="<?php echo htmlspecialchars($userData['img'] ?? 'https://static.vecteezy.com/system/resources/previews/007/167/661/non_2x/user-blue-icon-isolated-on-white-background-free-vector.jpg'); ?>" 
                alt="Foto de perfil" 
                class="rounded-circle" 
                style="width: 100%; height: 100%; object-fit: cover;">
        </div>

        <!-- Ícono para cambiar imagen -->
        <span class="material-symbols-outlined cursor-pointer text-primary position-absolute" 
            id="editImageButton" 
            role="button" 
            style="bottom: 0; right: 0; font-size: 24px; background: white; border-radius: 50%; padding: 5px;">
            change_circle
        </span>
    </div>

    <!-- Modal para cambiar la foto de perfil -->
    <div class="modal fade" id="changeProfilePictureModal" tabindex="-1" aria-labelledby="changeProfilePictureLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="changeProfilePictureLabel">Selecciona tu nueva foto de perfil</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST">
                    <div class="d-flex flex-wrap gap-3">
                        <!-- Opciones de imágenes -->
                        <label>
                            <input type="radio" name="profile_picture" value="https://fotografias.lasexta.com/clipping/cmsimages02/2019/11/14/66C024AF-E20B-49A5-8BC3-A21DD22B96E6/default.jpg" hidden>
                            <img src="https://fotografias.lasexta.com/clipping/cmsimages02/2019/11/14/66C024AF-E20B-49A5-8BC3-A21DD22B96E6/default.jpg" 
                                 class="rounded-circle profile-option" 
                                 style="width: 80px; height: 80px; object-fit: cover; cursor: pointer; border: 2px solid transparent;">
                        </label>
                        <label>
                            <input type="radio" name="profile_picture" value="https://i.pinimg.com/736x/9e/f7/dc/9ef7dc7241f89d396a223cb9357456b0.jpg" hidden>
                            <img src="https://i.pinimg.com/736x/9e/f7/dc/9ef7dc7241f89d396a223cb9357456b0.jpg" 
                                 class="rounded-circle profile-option" 
                                 style="width: 80px; height: 80px; object-fit: cover; cursor: pointer; border: 2px solid transparent;">
                        </label>
                        
                        <label>
                            <input type="radio" name="profile_picture" value="https://static.vecteezy.com/system/resources/thumbnails/005/544/718/small_2x/profile-icon-design-free-vector.jpg" hidden>
                            <img src="https://static.vecteezy.com/system/resources/thumbnails/005/544/718/small_2x/profile-icon-design-free-vector.jpg" 
                                 class="rounded-circle profile-option" 
                                 style="width: 80px; height: 80px; object-fit: cover; cursor: pointer; border: 2px solid transparent;">
                        </label>
                        <label>
                            <input type="radio" name="profile_picture" value="https://w7.pngwing.com/pngs/26/692/png-transparent-person-woman-female-user-profile-avatar-website-internet-icon.png" hidden>
                            <img src="https://w7.pngwing.com/pngs/26/692/png-transparent-person-woman-female-user-profile-avatar-website-internet-icon.png" 
                                 class="rounded-circle profile-option" 
                                 style="width: 80px; height: 80px; object-fit: cover; cursor: pointer; border: 2px solid transparent;">
                        </label>
                        <label>
                            <input type="radio" name="profile_picture" value="https://www.meme-arsenal.com/memes/e9ee28679a89a409d6cdb85e6498837a.jpg" hidden>
                            <img src="https://www.meme-arsenal.com/memes/e9ee28679a89a409d6cdb85e6498837a.jpg" 
                                 class="rounded-circle profile-option" 
                                 style="width: 80px; height: 80px; object-fit: cover; cursor: pointer; border: 2px solid transparent;">
                        </label>
                        <label>
                            <input type="radio" name="profile_picture" value="https://i.pinimg.com/736x/4f/91/0e/4f910e02fef7145d49ee7b934021026a.jpg" hidden>
                            <img src="https://i.pinimg.com/736x/4f/91/0e/4f910e02fef7145d49ee7b934021026a.jpg" 
                                 class="rounded-circle profile-option" 
                                 style="width: 80px; height: 80px; object-fit: cover; cursor: pointer; border: 2px solid transparent;">
                        </label>
                        <label>
                            <input type="radio" name="profile_picture" value="https://i.pinimg.com/736x/95/b2/86/95b28609b5044e1a2706bee4e659a02a.jpg" hidden>
                            <img src="https://i.pinimg.com/736x/95/b2/86/95b28609b5044e1a2706bee4e659a02a.jpg" 
                                 class="rounded-circle profile-option" 
                                 style="width: 80px; height: 80px; object-fit: cover; cursor: pointer; border: 2px solid transparent;">
                        </label>
                        <label>
                            <input type="radio" name="profile_picture" value="https://i.pinimg.com/736x/8e/84/ae/8e84aef392fa0dffd19cf85ad67a9231.jpg" hidden>
                            <img src="https://i.pinimg.com/736x/8e/84/ae/8e84aef392fa0dffd19cf85ad67a9231.jpg" 
                                 class="rounded-circle profile-option" 
                                 style="width: 80px; height: 80px; object-fit: cover; cursor: pointer; border: 2px solid transparent;">
                        </label>
                    </div>
                    <div class="mt-3 text-end">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



    <!-- Información del usuario -->
    <div class="user-info ms-5">
        <?php if ($userData): ?>
            <h5>Información del Usuario</h5>
            <?php if (isset($successMessage)): ?>
                <div class="alert alert-success"><?php echo $successMessage; ?></div>
            <?php endif; ?>
            <?php if (isset($errorMessage)): ?>
                <div class="alert alert-danger"><?php echo $errorMessage; ?></div>
            <?php endif; ?>

<!-- Cambiar el nombre de usuario -->
<div class="mb-3">
    <div class="alineado">
        <p class="mb-0"><strong>Nombre de Usuario:</strong></p>
        <span id="usernameDisplay"><?php echo htmlspecialchars($userData['username']); ?></span>
        <span class="material-symbols-outlined" id="editUsernameButton" role="button">change_circle</span>
    </div>
    <form method="POST" id="usernameForm" class="mt-2" style="display: none;">
        <input type="text" name="new_username" id="usernameInput" class="form-control d-inline w-auto me-2" value="<?php echo htmlspecialchars($userData['username']); ?>" required>
        <button type="submit" class="btn btn-primary btn-sm" id="saveUsernameButton">Guardar</button>
    </form>
</div>

<!-- Cambiar el correo electrónico -->
<div class="mb-3">
    <div class="alineado">
        <p class="mb-0"><strong>Email:</strong></p>
        <span id="emailDisplay"><?php echo htmlspecialchars($userData['email']); ?></span>
        <span class="material-symbols-outlined" id="editEmailButton" role="button">change_circle</span>
    </div>
    <form method="POST" id="emailForm" class="mt-2" style="display: none;">
        <input type="email" name="new_email" id="emailInput" class="form-control d-inline w-auto me-2" value="<?php echo htmlspecialchars($userData['email']); ?>" required>
        <button type="submit" class="btn btn-primary btn-sm" id="saveEmailButton">Guardar</button>
    </form>
</div>



            <!-- Email del usuario -->
            
        <?php else: ?>
            <p class="text-danger">No se encontró información del usuario.</p>
        <?php endif; ?>
    </div>
</div>


<!-- Sección de Historial de Compras del Usuario -->
<div class="user-info-card">
    <div class="d-flex align-items-center">
        <h5 class="me-2">Historial de Compras</h5>
        <span class="material-symbols-outlined text-start visibility-icon" type="button" data-bs-toggle="collapse" data-bs-target="#historial" aria-expanded="false" aria-controls="historial">
            visibility
        </span>    
    </div>

    <div class="collapse" id="historial">
        <?php
        // Obtener las boletas del usuario
        $query = "SELECT h.id_boleta, h.fecha_compra, b.fecha, b.total, b.detalles
                  FROM historial_compras h
                  INNER JOIN boletas b ON h.id_boleta = b.id_boleta
                  WHERE h.id_usuario = ?
                  ORDER BY b.fecha DESC";
        $stmt = $conexion->prepare($query);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0):
            while ($row = $result->fetch_assoc()):
                $detalles = json_decode($row['detalles'], true);
        ?>
            <div class="card mb-2">
                <div class="card-header">
                    <a class="d-flex justify-content-between align-items-center text-decoration-none text-white" 
                       data-bs-toggle="collapse" href="#boleta-<?php echo $row['id_boleta']; ?>" role="button" aria-expanded="false" aria-controls="boleta-<?php echo $row['id_boleta']; ?>">
                        <span><strong>Nro. Boleta:</strong> <?php echo $row['id_boleta']; ?></span>
                        <span><strong>Fecha:</strong> <?php echo date('d/m/Y', strtotime($row['fecha'])); ?></span>
                    </a>
                </div>
                <div id="boleta-<?php echo $row['id_boleta']; ?>" class="collapse">
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Producto</th>
                                    <th>Cantidad</th>
                                    <th>Precio Unitario</th>
                                    <th>Total</th>
                                    <th>Acciónes</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($detalles as $item): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($item['producto']); ?></td>
                                        <td><?php echo $item['cantidad']; ?></td>
                                        <td>$<?php echo number_format($item['precio_unitario'], 0, ',', '.'); ?></td>
                                        <td>$<?php echo number_format($item['total'], 0, ',', '.'); ?></td>
                                        <td><a href="../postventa/postventa.php?id_boleta=<?php echo $row['id_boleta']; ?>" class="btn btn-primary">
                                        Solicitar Postventa</a></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        <?php
            endwhile;
        else:
            echo "<p>No hay compras registradas.</p>";
        endif;
        $stmt->close();
        ?>
    </div>
</div>



<script>
// Abre el modal al hacer clic en el ícono de cambiar imagen
document.getElementById('editImageButton').addEventListener('click', function () {
    const modal = new bootstrap.Modal(document.getElementById('changeProfilePictureModal'));
    modal.show();
});

// Resalta la imagen seleccionada en el modal
document.querySelectorAll('.profile-option').forEach(img => {
    img.addEventListener('click', function () {
        document.querySelectorAll('.profile-option').forEach(i => i.style.borderColor = 'transparent');
        this.style.borderColor = '#007bff';
    });
});



</script>

<script>
// Función para manejar la edición del correo electrónico
document.getElementById('editEmailButton').addEventListener('click', function () {
    const emailDisplay = document.getElementById('emailDisplay');
    const emailForm = document.getElementById('emailForm');
    const editEmailButton = document.getElementById('editEmailButton');

    // Ocultar el ícono y mostrar el formulario
    emailDisplay.style.display = 'none';
    emailForm.style.display = 'flex';
    editEmailButton.style.display = 'none';
    document.getElementById('emailInput').focus();
});

document.getElementById('saveEmailButton').addEventListener('click', function () {
    const emailDisplay = document.getElementById('emailDisplay');
    const emailForm = document.getElementById('emailForm');
    const editEmailButton = document.getElementById('editEmailButton');

    // Mostrar el ícono y ocultar el formulario después de guardar
    emailDisplay.style.display = 'inline';
    emailForm.style.display = 'none';
    editEmailButton.style.display = 'inline';
});

// Función para manejar la edición del nombre de usuario
document.getElementById('editUsernameButton').addEventListener('click', function () {
    const usernameDisplay = document.getElementById('usernameDisplay');
    const usernameForm = document.getElementById('usernameForm');
    const editUsernameButton = document.getElementById('editUsernameButton');

    // Ocultar el ícono y mostrar el formulario
    usernameDisplay.style.display = 'none';
    usernameForm.style.display = 'flex';
    editUsernameButton.style.display = 'none';
    document.getElementById('usernameInput').focus();
});

document.getElementById('saveUsernameButton').addEventListener('click', function () {
    const usernameDisplay = document.getElementById('usernameDisplay');
    const usernameForm = document.getElementById('usernameForm');
    const editUsernameButton = document.getElementById('editUsernameButton');

    // Mostrar el ícono y ocultar el formulario después de guardar
    usernameDisplay.style.display = 'inline';
    usernameForm.style.display = 'none';
    editUsernameButton.style.display = 'inline';
});

</script>
<?php include '../footer.php'?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
