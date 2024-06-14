<div class="modal" id="ModalAgregarClientes">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Agregar clientes</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <form data-parsley-validate class="forms-sample" id="ValidacionAgregarClientes">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12">

                                            <div class="row">
                                                <div class="col-lg-6 col-sm-12 mb-4">
                                                    <label for="CLIENTESIAN" class="form-label">Número de cliente</label>
                                                    <input type="text" class="form-control" id="CLIENTESIAN" autocomplete="off" placeholder="8923" name="CLIENTESIAN" required>

                                                </div>
                                                <div class="col-lg-6 col-sm-12 mb-4">

                                                    <label for="NombreCliente" class="form-label">Nombre</label>
                                                    <input type="text" class="form-control" id="NombreCliente" autocomplete="off" placeholder="Roberto" name="NombreCliente" required>

                                                </div>
                                                <div class="col-lg-6 col-sm-12 mb-4">

                                                    <label for="EmailCliente" class="form-label">Email</label>
                                                    <input type="text" class="form-control" id="EmailCliente" autocomplete="off" placeholder="correo@email.com" name="EmailCliente">

                                                </div>

                                                <div class="col-lg-6 col-sm-12 mb-4">

                                                    <label for="TelefonoCliente" class="form-label">Teléfono cliente</label>
                                                    <input type="text" class="form-control" id="TelefonoCliente" autocomplete="off" placeholder="6561234567" name="TelefonoCliente">

                                                </div>

                                                <div class="col-lg-6 col-sm-12 mb-4">

                                                    <label for="NombreContacto" class="form-label">Contacto</label>
                                                    <input type="text" class="form-control" id="NombreContacto" autocomplete="off" placeholder="Pedro" name="NombreContacto">

                                                </div>

                                                <div class="col-lg-6 col-sm-12 mb-4">

                                                    <label for="DireccionCliente" class="form-label">Calle y número</label>
                                                    <input type="text" class="form-control" id="DireccionCliente" placeholder="Arbolito 1208-A" name="DireccionCliente">

                                                </div>

                                                <div class="col-lg-6 col-sm-12 mb-4">

                                                    <label for="ColoniaCliente" class="form-label">Colonia</label>
                                                    <input type="text" class="form-control" id="ColoniaCliente" placeholder="Col Del Bosque" name="ColoniaCliente">

                                                </div>

                                                <div class="col-lg-6 col-sm-12 mb-4">

                                                    <label for="CiudadCliente" class="form-label">Ciudad</label>
                                                    <input type="text" class="form-control" id="CiudadCliente" placeholder="Monterrey" name="CiudadCliente">

                                                </div>

                                                <div class="col-lg-6 col-sm-12 mb-4">

                                                    <label for="EstadoCliente" class="form-label">Calle y número</label>
                                                    <input type="text" class="form-control" id="EstadoCliente" placeholder="Nuevo León" name="EstadoCliente">

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

<!-- MODAL DE EDICION -->

<div class="modal" id="ModalEditarClientes">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar cliente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <form data-parsley-validate class="forms-sample" id="ValidacionEditarClientes">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12">

                                            <div class="row">
                                                <div class="col-lg-12 col-sm-12 mb-4">
                                                    <select class="form-select" name="TIPODEUSUARIOIDEditar" id="TIPODEUSUARIOIDEditar" aria-label="Default select example" required>
                                                        <option selected>Selecciona tipo de usuario</option>

                                                        <?php while ($row_TipoDeUsuario = mysqli_fetch_assoc($TipoDeUsuario)) { ?>

                                                            <option value="<?php echo $row_TipoDeUsuario['TIPODEUSUARIOID']; ?>"><?php echo $row_TipoDeUsuario['TipoDeUsuario']; ?></option>

                                                        <?php } ?>


                                                    </select>
                                                </div>


                                                <div class="col-lg-6 col-sm-12 mb-4">
                                                    <label for="PrimerNombreEditar" class="form-label">Primer nombre</label>
                                                    <input type="text" class="form-control" id="PrimerNombreEditar" autocomplete="off" placeholder="Luis" name="PrimerNombreEditar" required>

                                                </div>
                                                <div class="col-lg-6 col-sm-12 mb-4">

                                                    <label for="SegundoNombreEditar" class="form-label">Segundo nombre</label>
                                                    <input type="text" class="form-control" id="SegundoNombreEditar" autocomplete="off" placeholder="Roberto" name="SegundoNombreEditar" required>

                                                </div>
                                                <div class="col-lg-6 col-sm-12 mb-4">

                                                    <label for="ApellidoPaternoEditar" class="form-label">Apellido paterno</label>
                                                    <input type="text" class="form-control" id="ApellidoPaternoEditar" autocomplete="off" placeholder="Pérez" name="ApellidoPaternoEditar" required>

                                                </div>
                                                <div class="col-lg-6 col-sm-12 mb-4">

                                                    <label for="ApellidoMaternoEditar" class="form-label">Apellido materno</label>
                                                    <input type="text" class="form-control" id="ApellidoMaternoEditar" autocomplete="off" placeholder="Chávez" name="ApellidoMaternoEditar" required>

                                                </div>

                                                <div class="col-lg-6 col-sm-12 mb-4">

                                                    <label for="emailEditar" class="form-label">Email</label>
                                                    <input type="text" class="form-control" id="emailEditar" autocomplete="off" placeholder="uncorreo@email.com" name="emailEditar" required>

                                                </div>

                                                <div class="col-lg-6 col-sm-12 mb-4">

                                                    <label for="TelefonoEditar" class="form-label">Teléfono</label>
                                                    <input type="text" class="form-control" id="TelefonoEditar" autocomplete="off" placeholder="656 123 4567" name="TelefonoEditar" required>

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


                    <input type="hidden" id="USUARIOIDEditar" name="USUARIOIDEditar">


                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">
                        Editar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL DE BORRADO -->

<div class="modal" id="ModalDeshabilitarClientes">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Deshabilitar cliente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-body">

                                Deseas dehabilitar este cliente?

                                <br>
                                <br>
                                <h3 id="NombreUsuarioDeshabilitar"></h3>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">

                <input type="hidden" id="USUARIOIDDeshabilitar" name="USUARIOIDDeshabilitar">


                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" id="DeshabilitarCliente" class="btn btn-danger">
                    Deshabilitar</button>
            </div>

        </div>
    </div>
</div>