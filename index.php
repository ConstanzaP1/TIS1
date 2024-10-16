<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sidebar With Bootstrap</title>
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
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
                    <span>Audifonos</span>
                </a>
                <ul id="auth" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                    <li class="sidebar-item">
                            <a href="mantenedores_periferico/tipo_audifono.php" class="sidebar-link">Tipo Audifono</a>      
                    </li>
                    <li class="sidebar-item">
                            <a href="mantenedores_periferico/tipo_microfono.php" class="sidebar-link">Tipo Microfono</a>      
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
        </aside>
        <div class="main p-3">
            <div class="text-center">
                <h1>
                    Tisnology
                </h1>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
        crossorigin="anonymous"></script>
    <script src="script.js"></script>
</body>

</html>