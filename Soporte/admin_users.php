<?php
require_once __DIR__ . '/../includes/HeaderScripts.php';
if (!isset($_SESSION['USUARIOID']) || strtolower($_SESSION['TipoDeUsuario'] ?? '') !== 'admin') {
    header('Location: ../index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<?php include(__DIR__ . '/../includes/Header.php'); ?>
<body>
<?php include(__DIR__ . '/../includes/Menu.php'); ?>
<div class="app-container">
    <div class="app-content">
        <div class="container-fluid">
            <h2>Administrar usuarios</h2>
            <p>Página en construcción (CRUD de usuarios se implementará aquí).</p>
        </div>
    </div>
</div>
</body>
</html>