<?php
require_once __DIR__ . '/../includes/HeaderScripts.php';
if (!isset($_SESSION['USUARIOID'])) {
    header('Location: ../index.php');
    exit;
}

// rol determination
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
            <h2>Tickets</h2>
            <!-- filters -->
            <div class="row mb-3">
                <div class="col-md-2">
                    <button id="btnAsignadosAMi" class="btn btn-outline-secondary w-100 mb-1">Asignados a mí</button>
                    <button id="btnSinAsignar" class="btn btn-outline-secondary w-100">Sin asignar</button>
                </div>
                <div class="col-md-2">
                    <select id="fEstado" class="form-select">
                        <option value="">Todos estados</option>
                        <option>Nuevo</option>
                        <option>Asignado</option>
                        <option>En proceso</option>
                        <option>En espera de usuario</option>
                        <option>En espera de tercero</option>
                        <option>Resuelto</option>
                        <option>Cerrado</option>
                        <option>Cancelado</option>
                        <option>Duplicado</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select id="fPrioridad" class="form-select">
                        <option value="">Todas prioridades</option>
                        <option>P1</option>
                        <option>P2</option>
                        <option>P3</option>
                        <option>P4</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <input type="text" id="fTexto" class="form-control" placeholder="Buscar texto">
                </div>
                <div class="col-md-2">
                    <button id="btnFiltrar" class="btn btn-primary">Filtrar</button>
                </div>
            </div>
            <table id="ticketsTable" class="table table-striped" style="width:100%">
                <thead>
                    <tr>
                        <th>Folio</th>
                        <th>Asunto</th>
                        <th>Estado</th>
                        <th>Prioridad</th>
                        <th>Solicitante</th>
                        <th>Técnico</th>
                        <th>Fecha creación</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
    <!-- scripts -->
    <script src="assets/plugins/jquery/jquery-3.7.1.min.js"></script>
    <script src="assets/plugins/bootstrap/js/popper.min.js"></script>
    <script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/plugins/perfectscroll/perfect-scrollbar.min.js"></script>
    <script src="assets/plugins/pace/pace.min.js"></script>
    <script src="assets/plugins/highlight/highlight.pack.js"></script>
    <script src="assets/js/main.min.js"></script>
    <script src="assets/js/custom.js"></script>
    <script type="text/javascript" charset="utf8" src="assets/js/jquery.dataTables.js"></script>
    <script type="text/javascript" charset="utf8" src="assets/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" charset="utf8" src="assets/js/buttons.html5.min.js"></script>
    <script type="text/javascript" charset="utf8" src="assets/js/jszip.min.js"></script>
    <script type="text/javascript" charset="utf8" src="assets/js/pdfmake.min.js"></script>
    <script type="text/javascript" charset="utf8" src="assets/js/vfs_fonts.js"></script>
    <script type="text/javascript" charset="utf8" src="assets/js/dataTables.responsive.min.js"></script>

<?php include(__DIR__ . '/../includes/Footer.php'); ?>
<script>
$(document).ready(function(){
    var tabla = $('#ticketsTable').DataTable({
        dom: 'Bfrtip',
        buttons: ['csvHtml5','pageLength'],
        processing:true,
        serverSide:true,
        ajax: {
            url: 'App/Datatables/Soporte-tickets-grid-data.php',
            type: 'POST',
            data: function(d) {
                d.estado = $('#fEstado').val();
                d.prioridad = $('#fPrioridad').val();
                d.texto = $('#fTexto').val();
                d.asignadosami = ventanaAsignadosAMi ? 1 : 0;
                d.sinasignar = ventanaSinAsignar ? 1 : 0;
            }
        },
        order: [[0,'desc']],
    });
    var ventanaAsignadosAMi = false;
    var ventanaSinAsignar = false;
    $('#btnFiltrar').on('click', function(){ tabla.draw(); });
    $('#btnAsignadosAMi').on('click', function(){
        ventanaAsignadosAMi = !ventanaAsignadosAMi;
        ventanaSinAsignar = false;
        tabla.draw();
    });
    $('#btnSinAsignar').on('click', function(){
        ventanaSinAsignar = !ventanaSinAsignar;
        ventanaAsignadosAMi = false;
        tabla.draw();
    });
});
</script>
</body>
</html>