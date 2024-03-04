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
                                                    <select class="form-select" name="TIPODEUSUARIOID" id="TIPODEUSUARIOID" aria-label="Default select example" required>
                                                        <option selected>Selecciona tipo de usuario</option>

                                                        <?php while ($row_TipoDeUsuario = mysqli_fetch_assoc($TipoDeUsuario)) { ?>

                                                            <option value="<?php echo $row_TipoDeUsuario['TIPODEUSUARIOID']; ?>"><?php echo $row_TipoDeUsuario['TipoDeUsuario']; ?></option>

                                                        <?php } ?>

                                                    </select>
                                                </div>


                                                <div class="col-lg-6 col-sm-12 mb-4">
                                                    <label for="PrimerNombre" class="form-label">Primer nombre</label>
                                                    <input type="text" class="form-control" id="PrimerNombre" autocomplete="off" placeholder="Luis" name="PrimerNombre" required>

                                                </div>
                                                <div class="col-lg-6 col-sm-12 mb-4">

                                                    <label for="SegundoNombre" class="form-label">Segundo nombre</label>
                                                    <input type="text" class="form-control" id="SegundoNombre" autocomplete="off" placeholder="Roberto" name="SegundoNombre" required>

                                                </div>
                                                <div class="col-lg-6 col-sm-12 mb-4">

                                                    <label for="ApellidoPaterno" class="form-label">Apellido paterno</label>
                                                    <input type="text" class="form-control" id="ApellidoPaterno" autocomplete="off" placeholder="Pérez" name="ApellidoPaterno" required>

                                                </div>
                                                <div class="col-lg-6 col-sm-12 mb-4">

                                                    <label for="ApellidoMaterno" class="form-label">Apellido materno</label>
                                                    <input type="text" class="form-control" id="ApellidoMaterno" autocomplete="off" placeholder="Chávez" name="ApellidoMaterno" required>

                                                </div>

                                                <div class="col-lg-6 col-sm-12 mb-4">

                                                    <label for="email" class="form-label">Email</label>
                                                    <input type="text" class="form-control" id="email" autocomplete="off" placeholder="uncorreo@email.com" name="email" required>

                                                </div>

                                                <div class="col-lg-6 col-sm-12 mb-4">

                                                    <label for="Telefono" class="form-label">Teléfono</label>
                                                    <input type="text" class="form-control" id="Telefono" autocomplete="off" placeholder="656 123 4567" name="Telefono" required>

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

                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">
                        Agregar</button>
                </div>
            </form>
        </div>
    </div>
</div>