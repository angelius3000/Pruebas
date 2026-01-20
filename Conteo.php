<?php include("includes/HeaderScripts.php");

if (!usuarioTieneAccesoSeccion('conteo')) {
    header("Location: main.php");
    exit;
}

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
                    <!-- <input class="form-control" type="text" placeholder="Type here..." aria-label="Search"> -->
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
                                    <h2>Conteo</h2>
                                    <p class="text-muted">Registra los visitantes por hora y clasifica por tipo.</p>
                                    <p class="text-muted mb-0">Fecha y hora actual: <?php echo htmlspecialchars(date('d/m/Y H:i'), ENT_QUOTES, 'UTF-8'); ?></p>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col">
                                <div class="d-flex flex-wrap gap-3" id="conteo-botones">
                                    <div class="d-flex flex-column align-items-stretch">
                                        <button type="button" class="btn btn-primary conteo-accion" data-tipo="hombre" data-delta="1">Hombre</button>
                                        <button type="button" class="btn btn-outline-primary btn-sm mt-2 conteo-accion" data-tipo="hombre" data-delta="-1">Negativo</button>
                                    </div>
                                    <div class="d-flex flex-column align-items-stretch">
                                        <button type="button" class="btn btn-primary conteo-accion" data-tipo="mujer" data-delta="1">Mujer</button>
                                        <button type="button" class="btn btn-outline-primary btn-sm mt-2 conteo-accion" data-tipo="mujer" data-delta="-1">Negativo</button>
                                    </div>
                                    <div class="d-flex flex-column align-items-stretch">
                                        <button type="button" class="btn btn-success conteo-accion" data-tipo="pareja" data-delta="1">Pareja</button>
                                        <button type="button" class="btn btn-outline-success btn-sm mt-2 conteo-accion" data-tipo="pareja" data-delta="-1">Negativo</button>
                                    </div>
                                    <div class="d-flex flex-column align-items-stretch">
                                        <button type="button" class="btn btn-info conteo-accion" data-tipo="familia" data-delta="1">Familia</button>
                                        <button type="button" class="btn btn-outline-info btn-sm mt-2 conteo-accion" data-tipo="familia" data-delta="-1">Negativo</button>
                                    </div>
                                    <div class="d-flex flex-column align-items-stretch">
                                        <button type="button" class="btn btn-warning conteo-accion" data-tipo="cuadrilla" data-delta="1">Cuadrilla</button>
                                        <button type="button" class="btn btn-outline-warning btn-sm mt-2 conteo-accion" data-tipo="cuadrilla" data-delta="-1">Negativo</button>
                                    </div>
                                </div>
                                <small class="text-muted d-block mt-2">Los conteos se registran automáticamente en la franja horaria actual (8:00-19:00).</small>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <div class="table-responsive">
                                    <table class="table table-bordered align-middle" id="conteo-tabla">
                                        <thead>
                                            <tr>
                                                <th rowspan="2">Hora</th>
                                                <th colspan="2" class="text-center">Individual</th>
                                                <th rowspan="2" class="text-center">Pareja</th>
                                                <th rowspan="2" class="text-center">Familia</th>
                                                <th rowspan="2" class="text-center">Cuadrilla</th>
                                                <th rowspan="2" class="text-center">Total</th>
                                            </tr>
                                            <tr>
                                                <th class="text-center">Hombre</th>
                                                <th class="text-center">Mujer</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php for ($hora = 8; $hora < 19; $hora++) {
                                                $inicio = sprintf('%02d:00', $hora);
                                                $fin = sprintf('%02d:00', $hora + 1);
                                                $etiqueta = $inicio . '-' . $fin;
                                            ?>
                                                <tr data-hora-inicio="<?php echo htmlspecialchars($inicio, ENT_QUOTES, 'UTF-8'); ?>">
                                                    <td><?php echo htmlspecialchars($etiqueta, ENT_QUOTES, 'UTF-8'); ?></td>
                                                    <td class="text-center" data-campo="hombre">0</td>
                                                    <td class="text-center" data-campo="mujer">0</td>
                                                    <td class="text-center" data-campo="pareja">0</td>
                                                    <td class="text-center" data-campo="familia">0</td>
                                                    <td class="text-center" data-campo="cuadrilla">0</td>
                                                    <td class="text-center" data-campo="total">0</td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Javascripts -->
    <script src="assets/plugins/jquery/jquery-3.5.1.min.js"></script>
    <script src="assets/plugins/bootstrap/js/popper.min.js"></script>
    <script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/plugins/perfectscroll/perfect-scrollbar.min.js"></script>
    <script src="assets/plugins/pace/pace.min.js"></script>
    <script src="assets/plugins/highlight/highlight.pack.js"></script>
    <script src="assets/js/main.min.js"></script>
    <script src="assets/js/custom.js"></script>

    <script src="App/js/AppConteo.js"></script>
    <script src="App/js/AppCambiarContrasena.js"></script>

</body>

</html>
