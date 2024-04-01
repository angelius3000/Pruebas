<div class="modal" id="ModalAgregarReparto">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Agregar reparto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <form data-parsley-validate class="forms-sample" id="ValidacionAgregarrepartos">
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
                                                    <label for="Fecha" class="form-label">Fecha</label>
                                                    <input type="date" class="form-control" id="Fecha" name="Fecha" required>
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
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Agregar</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- MODAL DE EDICION -->

<div class="modal" id="ModalEditarUsuarios">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar usuarios</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <form data-parsley-validate class="forms-sample" id="ValidacionEditarUsuario">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12">

                                            <div class="row">
                                                <div class="col-lg-12 col-sm-12 mb-4">
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