<?php
require_once __DIR__ . '/../includes/HeaderScripts.php';
if (!isset($_SESSION['USUARIOID'])) {
    header('Location: ../index.php');
    exit;
}
$rol = strtolower(trim($_SESSION['TipoDeUsuario'] ?? ''));
?>
<!DOCTYPE html>
<html lang="en">
<?php include(__DIR__ . '/../includes/Header.php'); ?>
<body>
<?php include(__DIR__ . '/../includes/Menu.php'); ?>
<div class="app-container">
    <div class="app-content">
        <div class="container-fluid">
            <h2>Panel de Soporte</h2>
            <div class="row">
                <?php if ($rol === 'solicitante' || $rol === 'tecnico' || $rol === 'admin'): ?>
                <div class="col-md-4">
                    <a href="new_ticket.php" class="card card-body text-decoration-none">
                        <h5>Nuevo ticket</h5>
                    </a>
                </div>
                <?php endif; ?>
                <div class="col-md-4">
                    <a href="list.php" class="card card-body text-decoration-none">
                        <h5>Ver tickets</h5>
                    </a>
                </div>
                <?php if ($rol === 'admin'): ?>
                <div class="col-md-4">
                    <a href="admin_users.php" class="card card-body text-decoration-none">
                        <h5>Administración</h5>
                    </a>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php include(__DIR__ . '/../includes/Footer.php'); ?>
</body>
</html>