<?php
session_start();
require('../conexion.php');
require('../vendor/setasign/fpdf/fpdf.php');

// Verificar si se ha proporcionado el ID de la boleta
if (!isset($_GET['id_boleta'])) {
    die("ID de boleta no proporcionado.");
}

$id_boleta = (int) $_GET['id_boleta'];

// Consultar la base de datos para obtener los detalles de la boleta
$query_boleta = "SELECT * FROM boletas WHERE id_boleta = '$id_boleta'";
$result_boleta = mysqli_query($conexion, $query_boleta);

if (!$result_boleta || mysqli_num_rows($result_boleta) === 0) {
    die("Boleta no encontrada.");
}

$boleta = mysqli_fetch_assoc($result_boleta);
$detalle_boleta = json_decode($boleta['detalles'], true);
$total = $boleta['total'];
$codigo_autorizacion = $boleta['codigo_autorizacion'];
$fecha = $boleta['fecha'];

// Configurar la fuente para admitir caracteres UTF-8
class PDF extends FPDF
{
    function Header()
    {
        // Título de la boleta
        $this->SetFont('Arial', 'B', 16);
        $this->SetFillColor(33, 37, 41);
        $this->SetTextColor(255, 255, 255);
        $this->Cell(0, 10, mb_convert_encoding('Boleta de Compra Tisnology', 'ISO-8859-1', 'UTF-8'), 0, 1, 'C', true);
        $this->Ln(10);
    }

    function Footer()
    {
        // Pie de página con número de página
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, mb_convert_encoding('Página ', 'ISO-8859-1', 'UTF-8') . $this->PageNo(), 0, 0, 'C');
    }
}

// Crear instancia de PDF
$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 12);

// Información de la compra
$pdf->Cell(50, 10, 'Fecha:', 0, 0);
$pdf->Cell(0, 10, date('d/m/Y', strtotime($fecha)), 0, 1);
$pdf->Ln(10);

// Encabezados de la tabla
$pdf->SetFont('Arial', 'B', 12);
$pdf->SetFillColor(220, 220, 220);
$pdf->Cell(30, 10, mb_convert_encoding('Cod. Aut', 'ISO-8859-1', 'UTF-8'), 1, 0, 'C', true);
$pdf->Cell(30, 10, mb_convert_encoding('N° Boleta', 'ISO-8859-1', 'UTF-8'), 1, 0, 'C', true);
$pdf->Cell(50, 10, mb_convert_encoding('Producto', 'ISO-8859-1', 'UTF-8'), 1, 0, 'C', true);
$pdf->Cell(25, 10, 'Cantidad', 1, 0, 'C', true);
$pdf->Cell(30, 10, 'Precio Unitario', 1, 0, 'C', true);
$pdf->Cell(30, 10, 'Total', 1, 1, 'C', true);

// Detalles de los productos
$pdf->SetFont('Arial', '', 12);
foreach ($detalle_boleta as $index => $detalle) {
    $pdf->Cell(30, 10, $index == 0 ? mb_convert_encoding($codigo_autorizacion, 'ISO-8859-1', 'UTF-8') : '', 1, 0, 'C');
    $pdf->Cell(30, 10, $index == 0 ? $id_boleta : '', 1, 0, 'C');
    $pdf->Cell(50, 10, mb_convert_encoding($detalle['producto'], 'ISO-8859-1', 'UTF-8'), 1);
    $pdf->Cell(25, 10, $detalle['cantidad'], 1, 0, 'C');
    $pdf->Cell(30, 10, "$" . number_format($detalle['precio_unitario'], 0, ',', '.'), 1, 0, 'R');
    $pdf->Cell(30, 10, "$" . number_format($detalle['total'], 0, ',', '.'), 1, 1, 'R');
}

// Total
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(165, 10, 'Total a pagar', 1, 0, 'R');
$pdf->Cell(30, 10, "$" . number_format($total, 0, ',', '.'), 1, 1, 'R');

// Salida del PDF para descarga
$pdf->Output('D', 'Boleta_' . $id_boleta . '.pdf');
