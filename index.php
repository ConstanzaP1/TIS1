<?php
session_start(); // Iniciar sesión, si aún no lo has hecho
require_once 'conexion.php'; // Asegúrate de que la ruta es correcta

// Inicializar mensajes
$message = '';
$error_message = '';

// Verifica si hay un mensaje almacenado en la sesión
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']); // Elimina el mensaje de la sesión
}

if (isset($_SESSION['error_message'])) {
    $error_message = $_SESSION['error_message'];
    unset($_SESSION['error_message']); // Elimina el mensaje de error de la sesión
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos</title>
    <style>
        /* Estilos (como los que ya tenías) */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .header {
            background-color: #333;
            color: white;
            padding: 1rem;
            text-align: center;
        }
        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 1rem;
        }
        .formulario-registro {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            margin-bottom: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .formulario-registro button {
            padding: 10px 15px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin: 0 5px; /* Espaciado entre botones */
        }
        .product {
            background-color: white;
            padding: 1rem;
            margin: 1rem 0;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .product h3 {
            margin: 0 0 10px;
        }
        .message {
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <aside id="sidebar">
            <div class="d-flex">
                <button class="toggle-btn" type="button">
                    <i class="lni lni-grid-alt"></i>
                </button>
                <div class="sidebar-logo">
                    <a href="#">Tisnology</a>
                </div>
            </div>
            <li class="sidebar-item">
                <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse"
                        data-bs-target="#auth" aria-expanded="false" aria-controls="auth">
                    <i class="lni lni-protection"></i>
                    <span>Tarjetas de video</span>
                </a>
                <ul id="auth" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                    <li class="sidebar-item">
                            <a href="mantenedores_hardware/memoria_gpu.php" class="sidebar-link">Memoria</a>      
                    </li>
                    <li class="sidebar-item">
                            <a href="mantenedores_hardware/frecuencia_gpu.php" class="sidebar-link">Frecuencia</a>      
                    </li>
                </ul>
            </li>
            <li class="sidebar-item">
                <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse"
                        data-bs-target="#auth" aria-expanded="false" aria-controls="auth">
                    <i class="lni lni-protection"></i>
                    <span>Procesador</span>
                </a>
                <ul id="auth" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                    <li class="sidebar-item">
                            <a href="mantenedores_hardware/frecuencia_cpu.php" class="sidebar-link">Frecuencia</a>      
                    </li>
                    <li class="sidebar-item">
                            <a href="mantenedores_hardware/nucleo_hilo_cpu.php" class="sidebar-link">Nucleo / Hilo</a>      
                    </li>
                    <li class="sidebar-item">
                            <a href="mantenedores_hardware/socket_cpu.php" class="sidebar-link">Socket</a>      
                    </li>
                </ul>
            </li>
            <li class="sidebar-item">
                <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse"
                        data-bs-target="#auth" aria-expanded="false" aria-controls="auth">
                    <i class="lni lni-protection"></i>
                    <span>Placa madre</span>
                </a>
                <ul id="auth" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                    <li class="sidebar-item">
                            <a href="mantenedores_hardware/socket_placa.php" class="sidebar-link">Socket</a>      
                    </li>
                    <li class="sidebar-item">
                            <a href="mantenedores_hardware/slot_memoria_placa.php" class="sidebar-link">Slot memoria</a>      
                    </li>
                    <li class="sidebar-item">
                            <a href="mantenedores_hardware/formato_placa.php" class="sidebar-link">Formato</a>      
                    </li>
                    <li class="sidebar-item">
                            <a href="mantenedores_hardware/tamanio_placa.php" class="sidebar-link">Tamaño</a>      
                    </li>
                </ul>
            </li>
            <li class="sidebar-item">
                <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse"
                        data-bs-target="#auth" aria-expanded="false" aria-controls="auth">
                    <i class="lni lni-protection"></i>
                    <span>Memoria RAM</span>
                </a>
                <ul id="auth" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                    <li class="sidebar-item">
                            <a href="mantenedores_hardware/voltaje_ram.php" class="sidebar-link">Voltaje</a>      
                    </li>
                    <li class="sidebar-item">
                            <a href="mantenedores_hardware/velocidad_ram.php" class="sidebar-link">Velocidad</a>      
                    </li>
                    <li class="sidebar-item">
                            <a href="mantenedores_hardware/capacidad_ram.php" class="sidebar-link">Capacidad</a>      
                    </li>
                    <li class="sidebar-item">
                            <a href="mantenedores_hardware/tipo_ram.php" class="sidebar-link">Tipo</a>      
                    </li>
                </ul>
            </li>
            <li class="sidebar-item">
                <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse"
                        data-bs-target="#auth" aria-expanded="false" aria-controls="auth">
                    <i class="lni lni-protection"></i>
                    <span>Teclado</span>
                </a>
                <ul id="auth" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                    <li class="sidebar-item">
                            <a href="mantenedores_periferico/categoria_teclado.php" class="sidebar-link">Categoria</a>      
                    </li>
                    <li class="sidebar-item">
                            <a href="mantenedores_periferico/tipo_teclado.php" class="sidebar-link">Tipo</a>      
                    </li>
                </ul>
            </li>
            <li class="sidebar-item">
                <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse"
                        data-bs-target="#auth" aria-expanded="false" aria-controls="auth">
                    <i class="lni lni-protection"></i>
                    <span>Notebooks</span>
                </a>
                <ul id="auth" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                    <li class="sidebar-item">
                            <a href="mantenedores_notebook/cpu_notebook.php" class="sidebar-link">Cpu</a>      
                    </li>
                    <li class="sidebar-item">
                            <a href="mantenedores_notebook/gpu_notebook.php" class="sidebar-link">Gpu</a>      
                    </li>
                    <li class="sidebar-item">
                            <a href="mantenedores_notebook/pantalla_notebook.php" class="sidebar-link">Pantalla</a>      
                    </li>
                    <li class="sidebar-item">
                            <a href="mantenedores_notebook/bateria_notebook.php" class="sidebar-link">Batería</a>      
                    </li>
                </ul>
            </li>
            <li class="sidebar-item">
                <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse"
                        data-bs-target="#auth" aria-expanded="false" aria-controls="auth">
                    <i class="lni lni-protection"></i>
                    <span>Fuente de Poder</span>
                </a>
                <ul id="auth" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                    <li class="sidebar-item">
                            <a href="mantenedores_hardware/certificacion_fuente.php" class="sidebar-link">Certificacion</a>      
                    </li>
                    <li class="sidebar-item">
                            <a href="mantenedores_hardware/tipo_cableado.php" class="sidebar-link">Tipo Cableado</a>      
                    </li>
                    <li class="sidebar-item">
                            <a href="mantenedores_hardware/tamanio_fuente.php" class="sidebar-link">Tamaño</a>      
                    </li>
                    <li class="sidebar-item">
                            <a href="mantenedores_hardware/potencia_fuente.php" class="sidebar-link">Potencia</a>      
                    </li>
                    
                </ul>
            </li>
            <li class="sidebar-item">
                    <a href="crear_producto.php" class="sidebar-link">
                        <i class="lni lni-user"></i>
                        <span>Crear producto</span>
                    </a>
            </li>
            <div class="sidebar-footer">
                <a href="#" class="sidebar-link">
                    <i class="lni lni-exit"></i>
                    <span>Logout</span>
                </a>
            </div>
        </div>

        <!-- Mensajes de éxito o error -->
        <?php if ($message): ?>
            <div class="alert alert-success message" role="alert">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>
        <?php if ($error_message): ?>
            <div class="alert alert-danger message" role="alert">
                <?php echo $error_message; ?>
            </div>
        <?php endif; ?>

        <div class="product">
            <h3>Producto 1</h3>
            <p>Descripción del producto 1.</p>
            <p>Precio: $10</p>
        </div>
        <div class="product">
            <h3>Producto 2</h3>
            <p>Descripción del producto 2.</p>
            <p>Precio: $20</p>
        </div>
        <div class="product">
            <h3>Producto 3</h3>
            <p>Descripción del producto 3.</p>
            <p>Precio: $30</p>
        </div>
    </div>

</body>
</html>
