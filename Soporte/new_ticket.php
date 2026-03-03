<?php
require_once __DIR__ . '/../includes/HeaderScripts.php';
if (!isset($_SESSION['USUARIOID'])) {
    header('Location: ../index.php');
    exit;
}
// only employees (solicitante) and above can create
// rol mapping may be in session; assume TIPOUSUARIO:1 solicitante,2 tecnico,3 admin ?
// allow all roles to create except maybe disabled
?>
<!DOCTYPE html>
<html lang="en">
<?php include(__DIR__ . '/../includes/Header.php'); ?>
<body>
<?php include(__DIR__ . '/../includes/Menu.php'); ?>
<div class="app-container">
    <div class="app-content">
        <div class="container-fluid">
            <h2>Nuevo ticket</h2>
            <form id="formNuevoTicket" method="post" action="" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="asunto" class="form-label">Asunto</label>
                    <input type="text" id="asunto" name="asunto" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="descripcion" class="form-label">Descripción</label>
                    <textarea id="descripcion" name="descripcion" class="form-control" rows="4" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="categoria" class="form-label">Categoría</label>
                    <select id="categoria" name="categoria" class="form-select" required>
                        <option value="">Selecciona categoría</option>
                        <?php
                        // load categories from DB
                        $res = mysqli_query($conn, "SELECT id,nombre FROM categories WHERE activo=1 ORDER BY nombre");
                        while ($row = mysqli_fetch_assoc($res)) {
                            echo '<option value="' . $row['id'] . '">' . htmlspecialchars($row['nombre']) . '</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="asset_id" class="form-label">Activo (opcional)</label>
                    <select id="asset_id" name="asset_id" class="form-select">
                        <option value="">No aplica</option>
                        <?php
                        $qry = mysqli_query($conn, "SELECT id, etiqueta_activo FROM assets WHERE activo=1 ORDER BY etiqueta_activo");
                        while ($a = mysqli_fetch_assoc($qry)) {
                            echo '<option value="' . $a['id'] . '">' . htmlspecialchars($a['etiqueta_activo']) . '</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="impacto" class="form-label">Impacto</label>
                        <select id="impacto" name="impacto" class="form-select" required>
                            <option value="Medio">Medio</option>
                            <option value="Alto">Alto</option>
                            <option value="Bajo">Bajo</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="urgencia" class="form-label">Urgencia</label>
                        <select id="urgencia" name="urgencia" class="form-select" required>
                            <option value="Media">Media</option>
                            <option value="Alta">Alta</option>
                            <option value="Baja">Baja</option>
                        </select>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="adjuntos" class="form-label">Adjuntos</label>
                    <input type="file" id="adjuntos" name="adjuntos[]" class="form-control" multiple>
                </div>
                <button type="submit" class="btn btn-primary">Crear ticket</button>
            </form>
        </div>
    </div>
</div>
<?php include(__DIR__ . '/../includes/Footer.php'); ?>
<script>
$('#formNuevoTicket').on('submit', function(e) {
    e.preventDefault();
    var form = new FormData(this);
    $.ajax({
        url: 'App/Server/SoporteCreateTicket.php',
        type: 'POST',
        data: form,
        processData: false,
        contentType: false,
        dataType: 'json'
    }).done(function(resp) {
        if (resp.success) {
            alert('Ticket creado: ' + resp.folio);
            window.location.href = 'index.php';
        } else {
            alert('Error: ' + (resp.message || JSON.stringify(resp.errors)));
        }
    }).fail(function() {
        alert('Error en la petición');
    });
});
</script>
</body>
</html>