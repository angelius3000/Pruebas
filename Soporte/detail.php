<?php
require_once __DIR__ . '/../includes/HeaderScripts.php';
if (!isset($_SESSION['USUARIOID'])) {
    header('Location: ../index.php');
    exit;
}
$rol = strtolower(trim($_SESSION['TipoDeUsuario'] ?? ''));
$ticketId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($ticketId <= 0) {
    echo "<p>ID de ticket inválido</p>";
    exit;
}

// load ticket and messages
$stmt = mysqli_prepare($conn, 'SELECT t.*, u.nombre AS solicitante_nombre, ut.nombre AS tecnico_nombre
    FROM tickets t
    LEFT JOIN users u ON u.id=t.solicitante_id
    LEFT JOIN users ut ON ut.id=t.tecnico_id
    WHERE t.id=?');
mysqli_stmt_bind_param($stmt,'i',$ticketId);
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);
$ticket = mysqli_fetch_assoc($res);
mysqli_stmt_close($stmt);
if (!$ticket) {
    echo "<p>Ticket no encontrado</p>";
    exit;
}

// permission check: solicitante only own ticket
if ($rol === 'solicitante' && $ticket['solicitante_id'] != $_SESSION['USUARIOID']) {
    echo "<p>No autorizado</p>";
    exit;
}

// load messages
$messages = [];
$stmt = mysqli_prepare($conn, 'SELECT m.*, u.nombre as autor_nombre FROM ticket_messages m
    JOIN users u ON u.id=m.author_id
    WHERE m.ticket_id=? ORDER BY m.created_at');
mysqli_stmt_bind_param($stmt,'i',$ticketId);
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);
while ($r = mysqli_fetch_assoc($res)) {
    $messages[] = $r;
}
mysqli_stmt_close($stmt);
?>
<!DOCTYPE html>
<html lang="en">
<?php include(__DIR__ . '/../includes/Header.php'); ?>
<body>
<?php include(__DIR__ . '/../includes/Menu.php'); ?>
<div class="app-container">
    <div class="app-content">
        <div class="container-fluid">
            <h2>Ticket <?php echo htmlspecialchars($ticket['folio']); ?></h2>
            <p><strong>Asunto:</strong> <?php echo htmlspecialchars($ticket['asunto']); ?></p>
            <p><strong>Estado:</strong> <?php echo htmlspecialchars($ticket['estado']); ?></p>
            <p><strong>Prioridad:</strong> <?php echo htmlspecialchars($ticket['prioridad_calculada']); ?><?php if($ticket['prioridad_override']) echo ' (override '.$ticket['prioridad_override'].')'; ?></p>
            <p><strong>Solicitante:</strong> <?php echo htmlspecialchars($ticket['solicitante_nombre']); ?></p>
            <p><strong>Técnico:</strong> <?php echo htmlspecialchars($ticket['tecnico_nombre'] ?? '-'); ?></p>
            <hr>
            <h4>Conversación</h4>
            <?php foreach ($messages as $m): ?>
                <div class="mb-2<?php echo $m['is_internal'] ? ' bg-light' : ''; ?>">
                    <small><?php echo htmlspecialchars($m['autor_nombre']); ?> | <?php echo $m['created_at']; ?></small>
                    <p><?php echo nl2br(htmlspecialchars($m['body'])); ?></p>
                </div>
            <?php endforeach; ?>

            <?php if ($rol !== 'solicitante'): ?>
            <div class="mb-3">
                <button id="btnAsignarme" class="btn btn-secondary">Asignarme</button>
                <button id="btnCambiarEstado" class="btn btn-secondary">Cambiar estado</button>
                <button id="btnCerrar" class="btn btn-danger">Cerrar</button>
            </div>
            <?php endif; ?>
            <form id="formMensaje">
                <div class="mb-3">
                    <label for="body" class="form-label">Respuesta</label>
                    <textarea id="body" name="body" class="form-control" rows="3"></textarea>
                </div>
                <?php if ($rol !== 'solicitante'): ?>
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" id="is_internal" name="is_internal">
                    <label class="form-check-label" for="is_internal">Nota interna</label>
                </div>
                <?php endif; ?>
                <button type="submit" class="btn btn-primary">Enviar</button>
            </form>
        </div>
    </div>
</div>
<!-- scripts same as list-->
<script src="assets/plugins/jquery/jquery-3.7.1.min.js"></script>
<script src="assets/plugins/bootstrap/js/popper.min.js"></script>
<script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/plugins/perfectscroll/perfect-scrollbar.min.js"></script>
<script src="assets/plugins/pace/pace.min.js"></script>
<script src="assets/plugins/highlight/highlight.pack.js"></script>
<script src="assets/js/main.min.js"></script>
<script src="assets/js/custom.js"></script>
<script>
$('#formMensaje').on('submit', function(e){
    e.preventDefault();
    var form = $(this);
    $.post('App/Server/SoporteAddMessage.php', form.serialize() + '&ticket_id=' + <?php echo $ticketId; ?>, function(resp){
        if (resp.success) {
            location.reload();
        } else {
            alert('Error: '+resp.message);
        }
    }, 'json');
});

// action buttons
$('#btnAsignarme').on('click', function(){
    $.post('App/Server/SoporteUpdateTicket.php', {id:<?php echo $ticketId;?>, action:'assign_me'}, function(resp){
        if(resp.success) location.reload(); else alert(resp.message);
    },'json');
});
$('#btnCambiarEstado').on('click', function(){
    var nuevo = prompt('Nuevo estado:');
    if(nuevo) {
        $.post('App/Server/SoporteUpdateTicket.php', {id:<?php echo $ticketId;?>, action:'state', value:nuevo}, function(resp){
            if(resp.success) location.reload(); else alert(resp.message);
        },'json');
    }
});
$('#btnCerrar').on('click', function(){
    $.post('App/Server/SoporteUpdateTicket.php', {id:<?php echo $ticketId;?>, action:'close'}, function(resp){
        if(resp.success) location.reload(); else alert(resp.message);
    },'json');
});
</script>
</body>
</html>