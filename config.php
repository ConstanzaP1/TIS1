<?php
// Detecta la URL base automáticamente
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://';
$host = $_SERVER['HTTP_HOST'];

// Ruta base relativa al servidor
$project_folder = '/xampp/TIS1/'; // Ajusta según la carpeta donde esté tu proyecto

// Define la constante BASE_URL
define('BASE_URL', $protocol . $host . $project_folder);
?>
