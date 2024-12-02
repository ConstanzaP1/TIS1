<?php
session_start();
require_once '../conexion.php';

// Verificar si el usuario ha iniciado sesión y es admin o superadmin
if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role'], ['admin', 'superadmin'])) {
    header('Location: ../login/login.php');
    exit;
}


// Recuperar todas las boletas desde la base de datos
$sql_boletas = "SELECT id_boleta, fecha, total, codigo_autorizacion, detalles FROM boletas";
$result_boletas = mysqli_query($conexion, $sql_boletas);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Boletas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container-fluid">
            <a class="navbar-brand" href="../admin_panel/admin_panel.php">
                <img src="../logoblanco.png" alt="Logo" style="width: auto; height: auto;" class="d-inline-block align-text-top">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="../admin_panel/admin_panel.php">Volver al Panel</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
<!-- Migajas de pan -->
<nav aria-label="breadcrumb">
    <ol class="breadcrumb bg-white p-3 rounded shadow-sm">
        <li class="breadcrumb-item">
            <a href="../index.php" class="text-primary text-decoration-none">
                <i class="fas fa-home me-1"></i> Inicio
            </a>
        </li>
        <li class="breadcrumb-item">
            <a href="../admin_panel/admin_panel.php" class="text-primary text-decoration-none">
                Panel de Administración
            </a>
        </li>
        <li class="breadcrumb-item active text-dark" aria-current="page">
            Recuperar Boletas
        </li>
    </ol>
</nav>

<!-- Fin Migajas de pan -->
<style>
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
    <!-- Contenedor Principal -->
    <div class="container">
        <div class="bg-light p-4 rounded shadow">
            <h2 class="text-center mb-4">Boletas Registradas</h2>

            <!-- Campo de búsqueda -->
            <form class="mb-3">
                <div class="row g-2">
                    <div class="col-md-12 col-12">
                        <input type="text" id="searchInput" class="form-control" placeholder="Buscar por ID Boleta">
                    </div>

                </div>
            </form>

            <!-- Tabla con Scroll -->
            <div class="table-responsive">
                <table class="table table-striped table-hover table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>ID Boleta</th>
                            <th>Fecha</th>
                            <th>Total</th>
                            <th>Código de Autorización</th>
                            <th>Detalles</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="boletasTable">
                        <?php while ($boleta = mysqli_fetch_assoc($result_boletas)): ?>
                            <tr>
                                <td><?php echo $boleta['id_boleta']; ?></td>
                                <td><?php echo $boleta['fecha']; ?></td>
                                <td>$<?php echo number_format($boleta['total'], 0, ',', '.'); ?></td>
                                <td><?php echo $boleta['codigo_autorizacion']; ?></td>
                                <td><?php echo htmlspecialchars($boleta['detalles']); ?></td>
                                <td>
                                    <div class="d-flex flex-wrap justify-content-center gap-2 mt-4">
                                        <button class="btn-sm btn btn-dark p-2" style="border-radius:20%" onclick="verBoleta(
                                            '<?php echo $boleta['id_boleta']; ?>',
                                            '<?php echo $boleta['fecha']; ?>',
                                            '<?php echo number_format($boleta['total'], 0, ',', '.'); ?>',
                                            '<?php echo $boleta['codigo_autorizacion']; ?>',
                                            `<?php echo htmlspecialchars($boleta['detalles']); ?>`
                                        )">Ver</button>
                                    </div>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal para Ver Boleta -->
    <div class="modal fade" id="boletaModal" tabindex="-1" aria-labelledby="boletaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="boletaModalLabel">Detalles de la Boleta</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><strong>ID Boleta:</strong> <span id="modalBoletaId"></span></p>
                    <p><strong>Fecha:</strong> <span id="modalFecha"></span></p>
                    <p><strong>Total:</strong> $<span id="modalTotal"></span></p>
                    <p><strong>Código de Autorización:</strong> <span id="modalCodigoAutorizacion"></span></p>
                    <p><strong>Detalles:</strong></p>
                    <pre id="modalDetalles" style="white-space: pre-wrap;"></pre>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <a href="#" id="downloadBoleta" class="btn btn-primary">Descargar Boleta</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Ver Boleta en Modal
        function verBoleta(id, fecha, total, codigo, detalles) {
            document.getElementById('modalBoletaId').textContent = id;
            document.getElementById('modalFecha').textContent = fecha;
            document.getElementById('modalTotal').textContent = total;
            document.getElementById('modalCodigoAutorizacion').textContent = codigo;
            document.getElementById('modalDetalles').textContent = detalles;

            document.getElementById('downloadBoleta').setAttribute('href', `descargar_boleta.php?id_boleta=${id}`);

            const modal = new bootstrap.Modal(document.getElementById('boletaModal'));
            modal.show();
        }

        // Filtrar boletas
        document.getElementById("searchInput").addEventListener("input", function () {
            const searchValue = this.value.toLowerCase();
            const rows = document.querySelectorAll("#boletasTable tr");

            rows.forEach(row => {
                const idBoleta = row.cells[0]?.textContent.toLowerCase();
                row.style.display = idBoleta && idBoleta.includes(searchValue) ? "" : "none";
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
