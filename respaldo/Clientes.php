<?php include("includes/HeaderScripts.php");

if ($_SESSION['TIPOUSUARIO'] != 1) {
    header("Location: index.php");
}

?>

<!DOCTYPE html>
<html lang="en">

<?php include("includes/Header.php") ?>

<body class="bg-theme bg-theme8">
    <!-- wrapper -->
    <div class="wrapper">
        <div class="app-container">
            <?php include("includes/MenuHeader.php") ?>

            <div class="app-content">
                <div class="content-wrapper">
                    <!-- Container with margin -->
                    

                    <div class="custom-container">
                        <div class="row">
                            <div class="col">
                                <div class="page-description">
                                    <h2>Clientes</h2>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <button type="button" class="btn btn-sm btn-primary waves-effect width-md waves-light" data-bs-toggle="modal" data-bs-target="#ModalAgregarClientes"><i class="material-icons-two-tone"></i> Agregar Cliente</button>
                            </div>
                        </div>

                        <br>

                        <div class="row">
                            <table id="ClientesDT" class="table table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Número de cliente</th>
                                        <th>Nombre</th>
                                        <th>Email</th>
                                        <th>Teléfono</th>
                                        <th>Contacto</th>
                                        <th>Dirección</th>
                                        <th>Colonia</th>
                                        <th>Ciudad</th>
                                        <th>Estado</th>
                                        <th></th>
                                    </tr>
                                </thead>
                            </table>
                        </div>

                        <div class="row">
                            <div class="col">
                                <!-- Espacio adicional si es necesario -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include("App/Modales/ModalesClientes.php") ?>
    <?php include("includes/Footer.php")  ?>
    <!-- Javascripts -->
    <script src="assets/plugins/jquery/jquery-3.5.1.min.js"></script>
    <script src="assets/plugins/bootstrap/js/popper.min.js"></script>
    <script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/plugins/perfectscroll/perfect-scrollbar.min.js"></script>
    <script src="assets/plugins/pace/pace.min.js"></script>
    <script src="assets/plugins/highlight/highlight.pack.js"></script>

    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.js"></script>

    <script src="assets/js/main.min.js"></script>
    <script src="assets/js/custom.js"></script>
    <script src="assets/js/pages/datatables.js"></script>

    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/responsive/2.2.7/js/dataTables.responsive.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/parsley.js/2.9.2/parsley.js" integrity="sha512-Fq/wHuMI7AraoOK+juE5oYILKvSPe6GC5ZWZnvpOO/ZPdtyA29n+a5kVLP4XaLyDy9D1IBPYzdFycO33Ijd0Pg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="App/js/AppClientes.js"></script>
    <script src="App/js/AppCambiarContrasena.js"></script>

</body>

</html>
