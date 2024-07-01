<?php include("includes/HeaderScripts.php");

$query_clientes = "SELECT * FROM clientes";
$clientes = mysqli_query($conn, $query_clientes) or die(mysqli_error($conn));
$totalRows_clientes = mysqli_num_rows($clientes);

$query_status = "SELECT * FROM status";
$status = mysqli_query($conn, $query_status) or die(mysqli_error($conn));
$totalRows_status = mysqli_num_rows($status);

$query_Repartidores = "SELECT * FROM usuarios 
                        WHERE TIPODEUSUARIOID = 2 AND Deshabilitado = 0";
$Repartidores = mysqli_query($conn, $query_Repartidores) or die(mysqli_error($conn));
$totalRows_Repartidores = mysqli_num_rows($Repartidores);

// Fecha De hoy
$FechaHoy = date("Y-m-d");

$query_productos = "SELECT * FROM productos";
$productos = mysqli_query($conn, $query_productos) or die(mysqli_error($conn));
$totalRows_productos = mysqli_num_rows($productos);

if ($_SESSION['TIPOUSUARIO'] == 3) {

    $ClaseDeBody = "sidebar-hidden";
    $ClaseDeLogo = "hidden-sidebar-logo";
    $IconoFlecha = "last_page";
} else {

    $ClaseDeBody = "";
    $ClaseDeLogo = "";
    $IconoFlecha = "first_page";
}

?>

<!DOCTYPE html>
<html lang="en">

<?php include("includes/Header.php") ?>

<body>
    <div class="app full-width-header align-content-stretch d-flex flex-wrap <?php echo $ClaseDeBody; ?>">
        <div class="app-sidebar">
            <div class="logo logo-sm <?php echo $ClaseDeLogo; ?>">
                <a href="main.php"> <img src="App/Graficos/Logo/LogoEdison.png" style="max-width :130px;"> </a>
            </div>


            <?php include("includes/Menu.php") ?>



        </div>
        <div class="app-container">
            <div class="search">
                <form>
                    <input class="form-control" type="text" placeholder="Type here..." aria-label="Search">
                </form>
                <a href="#" class="toggle-search"><i class="material-icons">close</i></a>
            </div>

            <?php include("includes/MenuHeader.php") ?>

            <div class="app-content">
                <div class="content-wrapper">
                    <div class="container-fluid">

                        <div class="row">
                            <div class="col">
                                <div class="page-description">
                                    <h2>Repartos</h2>
                                    <?php // ESTE ES EL QUE IMPRIME LAS SESSIONES VARIABLES
                                    //echo '<pre>' . print_r($_SESSION, TRUE) . '</pre>';
                                    ?>
                                </div>
                            </div>
                        </div>

                        <?php if ($_SESSION['TIPOUSUARIO'] == 1 || $_SESSION['TIPOUSUARIO'] == 3) { ?>

                            <div class="row">
                                <div class="col">
                                    <button type="button" class="btn btn-sm btn-primary waves-effect width-md waves-light" data-bs-toggle="modal" data-bs-target="#ModalAgregarReparto"><i class="material-icons-two-tone">add</i> Agregar Reparto</button>

                                </div>
                            </div>

                        <?php  } ?>

                        <br>
                        <div class="row">

                            <?php if ($_SESSION['TIPOUSUARIO'] == 4) { ?>
                                <table id="RepartosCliente2DT" class="display" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Folio</th>
                                            <th>Estatus</th>
                                            <th>Solicitante</th>
                                            <th>Cliente</th>
                                            <th>Fecha de registro</th>
                                            <th>Dirección</th>
                                            <th>CP</th>
                                            <th>Receptor</th>
                                            <th>Teléfono receptor</th>
                                            <th>Telefono alternativo</th>
                                            <th>Numero de factura</th>
                                            <th>Comentarios</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                </table>

                            <?php } else { ?>

                                <table id="Repartos2DT" class="table table-striped" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Folio</th>
                                            <th>Estatus</th>
                                            <th>Surtidor</th>
                                            <th>Repartidor</th>
                                            <th>Solicitante</th>
                                            <th>Cliente</th>
                                            <th>Fecha de registro</th>
                                            <th>Dirección</th>
                                            <th>CP</th>
                                            <th>Receptor</th>
                                            <th>Teléfono receptor</th>
                                            <th>Telefono alternativo</th>
                                            <th>Numero de factura</th>
                                            <th>Comentarios</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                </table>

                            <?php } ?>


                        </div>
                        <div class="row">
                            <div class="col">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include("App/Modales/ModalesRepartos.php") ?>

    <!-- Javascripts -->
    <script src="assets/plugins/jquery/jquery-3.5.1.min.js"></script>
    <script src="assets/plugins/bootstrap/js/popper.min.js"></script>
    <script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/plugins/perfectscroll/perfect-scrollbar.min.js"></script>
    <script src="assets/plugins/pace/pace.min.js"></script>
    <script src="assets/plugins/highlight/highlight.pack.js"></script>
    <script src="assets/plugins/datatables/datatables.min.js"></script>
    <script src="assets/js/main.min.js"></script>
    <script src="assets/js/custom.js"></script>
    <script src="assets/js/pages/datatables.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables-buttons/3.0.2/js/dataTables.buttons.min.js" integrity="sha512-14shWK3qFVtqjfVywWUNuBNHxcEeS/3pJb9Lfj08z1/Y6mbMj9Ye4GOmiYnMbodUCNleopnrWldy92leOSkgpg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/3.5.3/select2.min.js" integrity="sha512-nwnflbQixsRIWaXWyQmLkq4WazLLsPLb1k9tA0SEx3Njm+bjEBVbLTijfMnztBKBoTwPsyz4ToosyNn/4ahTBQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/parsley.js/2.9.2/parsley.js" integrity="sha512-Fq/wHuMI7AraoOK+juE5oYILKvSPe6GC5ZWZnvpOO/ZPdtyA29n+a5kVLP4XaLyDy9D1IBPYzdFycO33Ijd0Pg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="App/js/AppRepartos.js"></script>

</body>

</html>