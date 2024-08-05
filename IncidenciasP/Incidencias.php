<?php include("Connections/ConDB.php");

$query_incidencias = "SELECT * FROM incidencias";
$incidencias = mysqli_query($conn, $query_incidencias) or die(mysqli_error($conn));
$totalRows_incidencias = mysqli_num_rows($incidencias);

$query_productos = "SELECT * FROM productos";
$productos = mysqli_query($conn, $query_productos) or die(mysqli_error($conn));
$totalRows_productos = mysqli_num_rows($productos);

$query_vendedores = "SELECT * FROM vendedores";
$vendedores = mysqli_query($conn, $query_vendedores) or die(mysqli_error($conn));
$totalRows_vendedores = mysqli_num_rows($vendedores);

$query_auditores = "SELECT * FROM auditores";
$auditores = mysqli_query($conn, $query_auditores) or die(mysqli_error($conn));
$totalRows_auditores = mysqli_num_rows($auditores);

// Fecha De hoy
$FechaHoy = date("Y-m-d");

?>

<!DOCTYPE html>
<html lang="en">

<?php include("includes/Header.php") ?>


<body>
    <div class="app full-width-header align-content-stretch d-flex flex-wrap">
        <div class="app-sidebar">
            <div class="logo logo-sm">
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
                                    <h2>Incidencias</h2>

                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col">
                                <button type="button" class="btn btn-sm btn-primary waves-effect width-md waves-light" data-bs-toggle="modal" data-bs-target="#ModalAgregarIncidencias"><i class="mdi mdi-pencil"></i>Agregar Ticket</button>

                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <table id="IncidenciasDT" class="display" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Incidencia</th>
                                        <th>Fecha</th>
                                        <th>Folio</th>
                                        <th>Cantidad</th>
                                        <th>SKU</th>
                                        <th>Producto</th>
                                        <th>Marca</th>
                                        <th>Precio</th>
                                        <th>Vendedor</th>
                                        <th>Surtidor</th>
                                        <th>Total</th>
                                        <th>Auditor</th>
                                        <th>Comentarios</th>
                                        <th></th>
                                    </tr>
                                </thead>
                            </table>
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

    <?php include("App/Modales/ModalesIncidencias.php") ?>

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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/3.5.3/select2.min.js"
     integrity="sha512-nwnflbQixsRIWaXWyQmLkq4WazLLsPLb1k9tA0SEx3Njm+bjEBVbLTijfMnztBKBoTwPsyz4ToosyNn/4ahTBQ=="
      crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/parsley.js/2.9.2/parsley.js"
     integrity="sha512-Fq/wHuMI7AraoOK+juE5oYILKvSPe6GC5ZWZnvpOO/ZPdtyA29n+a5kVLP4XaLyDy9D1IBPYzdFycO33Ijd0Pg=="
      crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="App/js/AppIncidencias.js"></script>

</body>

</html>