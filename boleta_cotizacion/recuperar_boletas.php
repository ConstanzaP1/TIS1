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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body, html {
            height: 100%;
            margin: 0;
            padding: 0;
        }
        .container-limited {
            max-width: 90%; /* Limitar el ancho al 90% de la pantalla */
            max-height: 90vh; /* Limitar la altura al 90% de la pantalla */
            padding: 20px;
            margin: 0 auto; /* Centrar horizontalmente */
            box-sizing: border-box;
        }
        .table-responsive {
            max-height: 60vh; /* Altura máxima de la tabla con scroll */
            overflow-y: auto;
        }
    </style>
</head>
<body>
<div class="container-limited">
    <h2 class="text-center">Boletas Registradas</h2>

    <!-- Campo de búsqueda -->
    <div class="mb-3">
        <input type="text" id="searchInput" class="form-control" placeholder="Buscar por ID Boleta">
    </div>

    <!-- Tabla con scroll vertical ocupando el espacio limitado -->
    <div class="table-responsive">
        <table class="table table-bordered">
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
                            <button class="btn btn-info btn-sm" onclick="verBoleta(
                                '<?php echo $boleta['id_boleta']; ?>',
                                '<?php echo $boleta['fecha']; ?>',
                                '<?php echo number_format($boleta['total'], 0, ',', '.'); ?>',
                                '<?php echo $boleta['codigo_autorizacion']; ?>',
                                `<?php echo htmlspecialchars($boleta['detalles']); ?>`
                            )">Ver Boleta</button>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    
    <div class="text-center mt-3">
        <a href="../admin_panel/admin_panel.php" class="btn btn-secondary">Volver al Panel de Administración</a>
    </div>
</div>

<!-- Modal para ver los detalles de la boleta -->
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
function verBoleta(id, fecha, total, codigo, detalles) {
    // Llenar el contenido del modal con los datos de la boleta
    $('#modalBoletaId').text(id);
    $('#modalFecha').text(fecha);
    $('#modalTotal').text(total);
    $('#modalCodigoAutorizacion').text(codigo);
    $('#modalDetalles').text(detalles);

    // Configurar el enlace de descarga
    $('#downloadBoleta').attr('href', `descargar_boleta.php?id_boleta=${id}`);

    // Mostrar el modal
    var modal = new bootstrap.Modal(document.getElementById('boletaModal'));
    modal.show();
}
// Filtrar las boletas
document.getElementById("searchInput").addEventListener("input", function () {
    const searchValue = this.value.toLowerCase(); // Convertir a minúsculas para búsqueda insensible a mayúsculas
    const rows = document.querySelectorAll("#boletasTable tr");

    rows.forEach(row => {
        const idBoleta = row.cells[0]?.textContent.toLowerCase(); // Obtener el texto del ID Boleta
        if (idBoleta && idBoleta.includes(searchValue)) {
            row.style.display = ""; // Mostrar la fila si coincide
        } else {
            row.style.display = "none"; // Ocultar la fila si no coincide
        }
    });
});

</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
