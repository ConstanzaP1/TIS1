<?php require_once 'config.php'; ?>
<?php
if (!defined('BASE_URL')) {
    define('BASE_URL', '/TIS1/');
}
?>


<footer class="bg-light py-4">
    <div class="container-fluid text-center">
        <div class="mb-4">
            <a href="<?php echo BASE_URL; ?>index.php">
                <img src="<?php echo BASE_URL; ?>logopng.png" alt="Logo Tisnology" class="img-fluid" style="max-width: 150px;">
            </a>
        </div>

        <!-- Links -->
        <div class="mb-4">
            <a class="text-decoration-none text-dark mx-2" href="<?php echo BASE_URL; ?>referidos/tyc.php">Términos y Condiciones</a> |
            <a class="text-decoration-none text-dark mx-2" href="<?php echo BASE_URL; ?>referidos/quienes_somos.php">Quiénes Somos</a> |
            <a class="text-decoration-none text-dark mx-2" href="<?php echo BASE_URL; ?>referidos/politica_privacidad.php">Política de Privacidad</a> |
            <a class="text-decoration-none text-dark mx-2" href="<?php echo BASE_URL; ?>referidos/politica_dev_rem.php">Política de Reembolso</a></a>
        </div>

        <!-- Línea de separación -->
        <hr class="my-4">

        <!-- Contact Information -->
        <div class="mb-4">
            <p class="mb-1 text-dark">Contáctanos</p>
            <a class="text-decoration-none text-dark mb-1" href="mailto:tisnology1@gmail.com">
                <p class="mb-0 text-dark">tisnology1@gmail.com</p>
            </a>
        </div>

        <!-- Copyright -->
        <div>
            <p class="text-muted mb-0">© 2024 Tisnology. Todos los derechos reservados.</p>
        </div>
    </div>
</footer>