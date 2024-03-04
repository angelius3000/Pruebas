<div class="modal" id="ModalAgregarUsuarios">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Agregar Usuarios</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <form data-parsley-validate class="forms-sample" id="ValidacionAgregarUsuario">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12">

                                            <div class="row">
                                                <div class="col-lg-12 col-sm-12 mb-4">
                                                    <select class="form-select" aria-label="Default select example">
                                                        <option selected>Selecciona tipo de usuario</option>

                                                        <?php while ($row_TipoDeUsuario = mysqli_fetch_assoc($TipoDeUsuario)) { ?>

                                                            <option value="<?php echo $row_TipoDeUsuario['TIPODEUSUARIOID']; ?>"><?php echo $row_TipoDeUsuario['TipoDeUsuario']; ?></option>

                                                        <?php } ?>

                                                    </select>
                                                </div>


                                                <div class="col-lg-6 col-sm-12 mb-4">
                                                    <label for="PrimerNombre" class="form-label">Primer nombre</label>
                                                    <input type="text" class="form-control" id="PrimerNombre" autocomplete="off" placeholder="Luis" name="PrimerNombre">

                                                </div>
                                                <div class="col-lg-6 col-sm-12 mb-4">

                                                    <label for="SegundoNombre" class="form-label">Segundo nombre</label>
                                                    <input type="text" class="form-control" id="SegundoNombre" autocomplete="off" placeholder="Roberto" name="SegundoNombre">

                                                </div>
                                                <div class="col-lg-6 col-sm-12 mb-4">

                                                    <label for="ApellidoPaterno" class="form-label">Apellido paterno</label>
                                                    <input type="text" class="form-control" id="ApellidoPaterno" autocomplete="off" placeholder="Pérez" name="ApellidoPaterno">

                                                </div>
                                                <div class="col-lg-6 col-sm-12 mb-4">

                                                    <label for="ApellidoMaterno" class="form-label">Apellido materno</label>
                                                    <input type="text" class="form-control" id="ApellidoMaterno" autocomplete="off" placeholder="Chávez" name="ApellidoMaterno">

                                                </div>

                                                <div class="col-lg-6 col-sm-12 mb-4">

                                                    <label for="email" class="form-label">Email</label>
                                                    <input type="text" class="form-control" id="email" autocomplete="off" placeholder="uncorreo@email.com" name="email">

                                                </div>

                                                <div class="col-lg-6 col-sm-12 mb-4">

                                                    <label for="Telefono" class="form-label">Teléfono</label>
                                                    <input type="text" class="form-control" id="Telefono" autocomplete="off" placeholder="656 123 4567" name="Telefono">

                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">

                    <input name="FacturaID" type="hidden" id="FacturaID" value="<?php echo $_GET['F']; ?>">


                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">
                        Agregar</button>
                </div>
            </form>
        </div>
    </div>
</div>