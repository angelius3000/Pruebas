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
                                                <div class="col-lg-6 col-sm-12">
                                                    <label for="CantidadPago" class="form-label">Cantidad</label>
                                                    <input type="text" class="form-control" id="CantidadPago" autocomplete="off" placeholder="34540" name="CantidadPago">

                                                </div>
                                                <div class="col-lg-6 col-sm-12">

                                                    <label for="CantidadPago" class="form-label">Cantidad</label>
                                                    <input type="text" class="form-control" id="CantidadPago" autocomplete="off" placeholder="34540" name="CantidadPago">

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