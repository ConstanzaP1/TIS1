<?php
session_start();
require '../conexion.php';

$message = ""; // Variable para mostrar mensajes

// Obtener el ID del producto desde la URL
$id_producto = $_GET['id_producto'] ?? null;

// Consultar detalles del producto
$producto = null;
$caracteristicas = [];
if ($id_producto) {
    $query_producto = "
        SELECT 
            nombre_producto, precio, imagen_url, tipo_producto
        FROM producto 
        WHERE id_producto = ?";
    $stmt = $conexion->prepare($query_producto);
    $stmt->bind_param("i", $id_producto);
    $stmt->execute();
    $result = $stmt->get_result();
    $producto = $result->fetch_assoc();

    // Si el producto existe, consultar sus características
    if ($producto) {
        switch ($producto['tipo_producto']) {
            case 'teclado':
                $query_caracteristicas = "
                    SELECT 
                        CASE 
                            WHEN pa.caracteristica = 'tipo_teclado' THEN CONCAT('Tipo de Teclado: ', tt.tipo_teclado) 
                            WHEN pa.caracteristica = 'tipo_switch' THEN CONCAT('Tipo de Switch: ', ts.tipo_switch) 
                            WHEN pa.caracteristica = 'conectividad' THEN CONCAT('Conectividad: ', c.conectividad)
                            WHEN pa.caracteristica = 'iluminacion' THEN CONCAT('Iluminación: ', i.iluminacion)
                            WHEN pa.caracteristica = 'categoria_teclado' THEN CONCAT('Categoría teclado: ', ct.categoria_teclado)
                        END AS caracteristica
                    FROM 
                        producto_caracteristica pa
                    LEFT JOIN tipo_teclado tt ON pa.valor_caracteristica = tt.id_periferico AND pa.caracteristica = 'tipo_teclado'
                    LEFT JOIN tipo_switch ts ON pa.valor_caracteristica = ts.id_periferico AND pa.caracteristica = 'tipo_switch'
                    LEFT JOIN conectividad c ON pa.valor_caracteristica = c.id_periferico AND pa.caracteristica = 'conectividad'
                    LEFT JOIN iluminacion i ON pa.valor_caracteristica = i.id_periferico AND pa.caracteristica = 'iluminacion'
                    LEFT JOIN categoria_teclado ct ON pa.valor_caracteristica = ct.id_periferico AND pa.caracteristica = 'categoria_teclado'
                    WHERE pa.id_producto = ?";
                break;

            // Añadir más casos para otros tipos de productos...
            default:
                $query_caracteristicas = "
                    SELECT caracteristica 
                    FROM producto_caracteristica 
                    WHERE id_producto = ?";
                break;
        }

        // Obtener las características del producto
        $stmt_caracteristicas = $conexion->prepare($query_caracteristicas);
        $stmt_caracteristicas->bind_param("i", $id_producto);
        $stmt_caracteristicas->execute();
        $result_caracteristicas = $stmt_caracteristicas->get_result();

        while ($caracteristica = $result_caracteristicas->fetch_assoc()) {
            if (!empty($caracteristica['caracteristica'])) {
                $caracteristicas[] = $caracteristica['caracteristica'];
            }
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["nombre"];
    $email = $_SESSION["email"] ?? $_POST["email"];
    $pregunta = $_POST["pregunta"];
    $producto_id = $_POST["id_producto"];

    $stmt = $conexion->prepare("
        INSERT INTO atencion_postventa (cliente_nombre, cliente_email, pregunta, id_producto) 
        VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssi", $nombre, $email, $pregunta, $producto_id);

    if ($stmt->execute()) {
        $message = "¡Tu consulta ha sido enviada con éxito! Nos pondremos en contacto contigo pronto.";
    } else {
        $message = "Ocurrió un error al enviar tu consulta. Por favor, inténtalo nuevamente.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Postventa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .navbar {
            background-color: rgba(0, 128, 255, 0.5);   
        }
        .card-body {
            background-color: #e0e0e0;
        }
        .product-image {
            width: 100%;
            height: 100%;
            object-fit: cover; /* Ajusta la imagen al contenedor sin distorsionarla */
        }
        .image-container {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 300px; /* Altura fija para el contenedor */
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
        <div class="navbar-brand col-2">
            <img class="logo img-fluid w-75 rounded-pill" src="../logopng.png" alt="Logo">
        </div>
    </div>
</nav>
<div class="container py-5">
    <h2>Consulta de Postventa</h2>

    <?php if ($producto): ?>
        <div class="card mb-3" style="background-color: #e0e0e0; border: none;">
            <div class="row g-0" style="height: 300px;">
                <div class="col-md-4 image-container">
                    <img src="<?= htmlspecialchars($producto['imagen_url']) ?>" 
                         class="product-image" 
                         alt="<?= htmlspecialchars($producto['nombre_producto']) ?>">
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($producto['nombre_producto']) ?></h5>
                        <p class="card-text">Precio: $<?= number_format($producto['precio'], 0, ',', '.') ?></p>
                        <h6>Características:</h6>
                        <ul>
                            <?php foreach ($caracteristicas as $caracteristica): ?>
                                <li><?= htmlspecialchars($caracteristica) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    <?php else: ?>
        <p class="text-danger">No se encontró información del producto.</p>
    <?php endif; ?>

    <?php if ($message): ?>
        <div class="alert <?= strpos($message, 'éxito') !== false ? 'alert-success' : 'alert-danger' ?>">
            <?= $message ?>
        </div>
    <?php endif; ?>

    <form method="POST">
        <input type="hidden" name="id_producto" value="<?= htmlspecialchars($id_producto) ?>">
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre:</label>
            <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ingresa tu nombre" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Correo:</label>
            <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($_SESSION['email'] ?? '') ?>" <?= isset($_SESSION['email']) ? 'readonly' : '' ?> required>
        </div>
        <div class="mb-3">
            <label for="pregunta" class="form-label">Consulta:</label>
            <textarea class="form-control" id="pregunta" name="pregunta" rows="4" placeholder="Escribe tu consulta aquí" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Enviar</button>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
