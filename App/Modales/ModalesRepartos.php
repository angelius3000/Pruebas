<div class="modal" id="ModalAgregarReparto">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Agregar reparto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <form data-parsley-validate class="forms-sample" id="ValidacionAgregarRepartos">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <div class="row">
                                                <div class="col-lg-12 col-sm-12 mb-4">
                                                    <label for="CLIENTEID" class="form-label">Cliente ID</label>
                                                    <select class="form-select" name="CLIENTEID" id="CLIENTEID" aria-label="Default select example" required>
                                                        <option selected>Selecciona cliente</option>

                                                        <?php while ($row_clientes = mysqli_fetch_assoc($clientes)) { ?>

                                                            <option value="<?php echo $row_clientes['CLIENTEID']; ?>">

                                                                <?php echo $row_clientes['clientesIAN'] . " - " . $row_clientes['NombreCliente']; ?>

                                                            </option>

                                                        <?php }

                                                        // Reset the pointer to the beginning
                                                        mysqli_data_seek($clientes, 0);

                                                        ?>

                                                    </select>
                                                </div>
                                                <div class="col-lg-6 col-sm-12 mb-4">
                                                    <label for="Fecha" class="form-label">Fecha de registro</label>
                                                    <input type="input" class="form-control" id="Fecha" disabled value="<?php echo $FechaHoy; ?> ">
                                                </div>
                                                <div class="col-lg-6 col-sm-12 mb-4">
                                                    <label for="NumeroDeFactura" class="form-label">Número de Factura</label>
                                                    <input type="text" class="form-control" id="NumeroDeFactura" autocomplete="off" name="NumeroDeFactura" required>
                                                </div>

                                                <div class="col-lg-6 col-sm-12 mb-4">
                                                    <label for="Calle" class="form-label">Calle</label>
                                                    <input type="text" class="form-control" id="Calle" autocomplete="off" name="Calle" required>
                                                </div>
                                                <div class="col-lg-6 col-sm-12 mb-4">
                                                    <label for="NumeroEXT" class="form-label">Número Exterior</label>
                                                    <input type="text" class="form-control" id="NumeroEXT" autocomplete="off" name="NumeroEXT" required>
                                                </div>
                                                <div class="col-lg-6 col-sm-12 mb-4">
                                                    <label for="Colonia" class="form-label">Colonia</label>
                                                    <input type="text" class="form-control" id="Colonia" autocomplete="off" name="Colonia" required>
                                                </div>
                                                <div class="col-lg-6 col-sm-12 mb-4">
                                                    <label for="CP" class="form-label">Código Postal</label>
                                                    <input type="text" class="form-control" id="CP" autocomplete="off" name="CP" required>
                                                </div>
                                                <div class="col-lg-6 col-sm-12 mb-4">
                                                    <label for="Ciudad" class="form-label">Ciudad</label>
                                                    <input type="text" class="form-control" id="Ciudad" autocomplete="off" name="Ciudad" required>
                                                </div>
                                                <div class="col-lg-6 col-sm-12 mb-4">
                                                    <label for="Estado" class="form-label">Estado</label>
                                                    <input type="text" class="form-control" id="Estado" autocomplete="off" name="Estado" required>
                                                </div>
                                                <div class="col-lg-12 col-sm-12 mb-4">
                                                    <label for="Receptor" class="form-label">Receptor</label>
                                                    <input type="text" class="form-control" id="Receptor" autocomplete="off" name="Receptor" required>
                                                </div>
                                                <div class="col-lg-6 col-sm-12 mb-4">
                                                    <label for="TelefonoDeReceptor" class="form-label">Teléfono del Receptor</label>
                                                    <input type="text" class="form-control" id="TelefonoDeReceptor" autocomplete="off" name="TelefonoDeReceptor" required>
                                                </div>
                                                <div class="col-lg-6 col-sm-12 mb-4">
                                                    <label for="TelefonoAlternativo" class="form-label">Teléfono Alternativo</label>
                                                    <input type="text" class="form-control" id="TelefonoAlternativo" autocomplete="off" name="TelefonoAlternativo">
                                                </div>
                                                <div class="col-lg-12 col-sm-12 mb-4">
                                                    <label for="Comentarios" class="form-label">Comentarios</label>
                                                    <textarea class="form-control" id="Comentarios" name="Comentarios" rows="4"></textarea>
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


                    <input type="hidden" class="form-control" id="USUARIOID" name="USUARIOID" value="1">

                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Agregar</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- MODAL DE EDICION -->
<div class="modal" id="ModalEditarReparto">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar reparto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <form data-parsley-validate class="forms-sample" id="ValidacionEditarRepartos">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <div class="row">
                                                <div class="col-lg-12 col-sm-12 mb-4">
                                                    <label for="CLIENTEIDEditar" class="form-label">Cliente ID</label>
                                                    <select class="form-select" name="CLIENTEIDEditar" id="CLIENTEIDEditar" aria-label="Default select example" required>
                                                        <option selected>Selecciona cliente</option>

                                                        <?php while ($row_clientes = mysqli_fetch_assoc($clientes)) { ?>

                                                            <option value="<?php echo $row_clientes['CLIENTEID']; ?>">

                                                                <?php echo $row_clientes['clientesIAN'] . " - " . $row_clientes['NombreCliente']; ?>

                                                            </option>

                                                        <?php }

                                                        // Reset the pointer to the beginning
                                                        mysqli_data_seek($clientes, 0);

                                                        ?>

                                                    </select>
                                                </div>

                                                <div class="col-lg-6 col-sm-12 mb-4">
                                                    <label for="NumeroDeFacturaEditar" class="form-label">Número de Factura</label>
                                                    <input type="text" class="form-control" id="NumeroDeFacturaEditar" autocomplete="off" name="NumeroDeFacturaEditar" required>
                                                </div>

                                                <div class="col-lg-6 col-sm-12 mb-4">
                                                    <label for="CalleEditar" class="form-label">Calle</label>
                                                    <input type="text" class="form-control" id="CalleEditar" autocomplete="off" name="CalleEditar" required>
                                                </div>
                                                <div class="col-lg-6 col-sm-12 mb-4">
                                                    <label for="NumeroEXTEditar" class="form-label">Número Exterior</label>
                                                    <input type="text" class="form-control" id="NumeroEXTEditar" autocomplete="off" name="NumeroEXTEditar" required>
                                                </div>
                                                <div class="col-lg-6 col-sm-12 mb-4">
                                                    <label for="ColoniaEditar" class="form-label">Colonia</label>
                                                    <input type="text" class="form-control" id="ColoniaEditar" autocomplete="off" name="ColoniaEditar" required>
                                                </div>
                                                <div class="col-lg-6 col-sm-12 mb-4">
                                                    <label for="CPEditar" class="form-label">Código Postal</label>
                                                    <input type="text" class="form-control" id="CPEditar" autocomplete="off" name="CPEditar" required>
                                                </div>
                                                <div class="col-lg-6 col-sm-12 mb-4">
                                                    <label for="CiudadEditar" class="form-label">Ciudad</label>
                                                    <input type="text" class="form-control" id="CiudadEditar" autocomplete="off" name="CiudadEditar" required>
                                                </div>
                                                <div class="col-lg-6 col-sm-12 mb-4">
                                                    <label for="EstadoEditar" class="form-label">Estado</label>
                                                    <input type="text" class="form-control" id="EstadoEditar" autocomplete="off" name="EstadoEditar" required>
                                                </div>
                                                <div class="col-lg-12 col-sm-12 mb-4">
                                                    <label for="ReceptorEditar" class="form-label">Receptor</label>
                                                    <input type="text" class="form-control" id="ReceptorEditar" autocomplete="off" name="ReceptorEditar" required>
                                                </div>
                                                <div class="col-lg-6 col-sm-12 mb-4">
                                                    <label for="TelefonoDeReceptorEditar" class="form-label">Teléfono del Receptor</label>
                                                    <input type="text" class="form-control" id="TelefonoDeReceptorEditar" autocomplete="off" name="TelefonoDeReceptorEditar" required>
                                                </div>
                                                <div class="col-lg-6 col-sm-12 mb-4">
                                                    <label for="TelefonoAlternativoEditar" class="form-label">Teléfono Alternativo</label>
                                                    <input type="text" class="form-control" id="TelefonoAlternativoEditar" autocomplete="off" name="TelefonoAlternativoEditar">
                                                </div>
                                                <div class="col-lg-12 col-sm-12 mb-4">
                                                    <label for="ComentariosEditar" class="form-label">Comentarios</label>
                                                    <textarea class="form-control" id="ComentariosEditar" name="ComentariosEditar" rows="4"></textarea>
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


                    <input type="hidden" class="form-control" id="USUARIOID" name="USUARIOID" value="1">

                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Agregar</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- MODAL DE BORRADO -->

<div class="modal" id="ModalDeshabilitarUsuarios">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Deshabilitar usuarios</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-body">

                                Deseas dehabilitar este usuario?

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
                <button type="button" id="DeshabilitarUsuario" class="btn btn-danger">
                    Deshabilitar</button>
            </div>

        </div>
    </div>
</div>