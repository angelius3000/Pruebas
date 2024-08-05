<div class="modal" id="ModalAgregarIncidencias">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Agregar Ticket</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <form data-parsley-validate class="forms-sample" id="ValidacionAgregarIncidencias">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <div class="row">
                                            <div class="col-lg-6 col-sm-12 mb-4">
                                                    <label for="Fecha" class="form-label">Fecha de registro</label>
                                                    <input type="input" class="form-control" id="Fecha" disabled value="<?php echo $FechaHoy; ?> ">
                                                </div>
                                                <div class="col-lg-6 col-sm-12 mb-4">
                                                    <label for="Auditor" class="form-label">Auditor</label>
                                                    <select class="form-select select2" name="Auditor" id="Auditor" aria-label="Default select example" required>
                                                        <option selected>Selecciona Auditor</option>

                                                            <?php while ($row_auditores = mysqli_fetch_assoc($auditores)) {?>

                                                                <option value="<?php echo $row_auditores['NombreAuditor']; ?>">

                                                                    <?php echo $row_auditores['NombreAuditor']; ?>

                                                                </option>
                                                            
                                                            <?php }

                                                            // Reset the pointer to the beginning
                                                            mysqli_data_seek($auditores, 0);

                                                        ?>

                                                    </select>
                                                </div>
                                                <!-- <div class="col-lg-6 col-sm-12 mb-4">
                                                    <label for="Auditor" class="form-label">Auditor</label>
                                                    <input type="text" class="form-control" id="Auditor" autocomplete="off" placeholder="Auditor" name="Auditor" required>
                                                </div> -->
                                                <div class="col-lg-6 col-sm-12 mb-4">
                                                    <label for="Folio" class="form-label">Folio</label>
                                                    <input type="text" class="form-control" id="Folio" autocomplete="off" placeholder="Ticket/Factura" name="Folio" required>
                                                </div>
                                                <div class="col-lg-6 col-sm-12 mb-4">
                                                    <label for="Cantidad" class="form-label">Cantidad</label>
                                                    <input type="text" class="form-control" id="Cantidad" autocomplete="off" placeholder="0" name="Cantidad" required>
                                                </div>
                                                <div class="col-lg-12 col-sm-12 mb-4">
                                                    <label for="SKU" class="form-label">Producto</label>
                                                    <select class="form-select select2" name="SKU" id="SKU" aria-label="Default select example" required>
                                                        <option selected>Selecciona Producto</option>

                                                            <?php while ($row_productos = mysqli_fetch_assoc($productos)) {?>

                                                                <option value="<?php echo $row_productos['Sku']; ?>">

                                                                    <?php echo $row_productos['Sku'] . " - " . $row_productos['Descripcion']; ?>

                                                                </option>
                                                                
                                                            <?php }
                                                            
                                                            // Reset the pointer to the beginning
                                                            mysqli_data_seek($productos, 0);

                                                        ?>

                                                    </select>
                                                    
                                                </div>
                                                <!-- <div class="col-lg-6 col-sm-12 mb-4">
                                                    <label for="SKU" class="form-label">SKU</label>
                                                    <input type="text" class="form-control" id="SKU" autocomplete="off" placeholder="000000" name="SKU" required>
                                                </div>-->
                                                <div class="col-lg-6 col-sm-12 mb-4">
                                                    <label for="Vendedor" class="form-label">Vendedor</label>
                                                    <select class="form-select select2" name="Vendedor" id="Vendedor" aria-label="Default select example" required>
                                                        <option selected>Selecciona Vendedor</option>

                                                            <?php while ($row_vendedores = mysqli_fetch_assoc($vendedores)) {?>

                                                                <option value="<?php echo $row_vendedores['NombreVendedor']; ?>">

                                                                    <?php echo $row_vendedores['NombreVendedor']; ?>

                                                                </option>
                                                            
                                                            <?php }

                                                            // Reset the pointer to the beginning
                                                            mysqli_data_seek($vendedores, 0);

                                                        ?>

                                                    </select>
                                                </div>
                                                <div class="col-lg-6 col-sm-12 mb-4">
                                                    <label for="Surtidor" class="form-label">Surtidor</label>
                                                    <input type="text" class="form-control" id="Surtidor" autocomplete="off" placeholder="Nombre y apellido" name="Surtidor">
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

<div class="modal" id="ModalEditarIncidencias">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar Registro</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <form data-parsley-validate class="forms-sample" id="ValidacionEditarIncidencias">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-body">
                                <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <div class="row">
                                            <div class="col-lg-6 col-sm-12 mb-4">
                                                    <label for="FechaEditar" class="form-label">Fecha de registro</label>
                                                    <input type="input" class="form-control" id="FechaEditar" disabled>
                                                </div>
                                                <div class="col-lg-6 col-sm-12 mb-4">
                                                    <label for="AuditorEditar" class="form-label">Auditor</label>
                                                    <select class="form-select select2" name="AuditorEditar" id="AuditorEditar" aria-label="Default select example" required>
                                                        <option selected>Selecciona Auditor</option>

                                                            <?php while ($row_auditores = mysqli_fetch_assoc($auditores)) {?>

                                                                <option value="<?php echo $row_auditores['NombreAuditor']; ?>">

                                                                    <?php echo $row_auditores['NombreAuditor']; ?>

                                                                </option>
                                                            
                                                            <?php }

                                                            // Reset the pointer to the beginning
                                                            mysqli_data_seek($auditores, 0);

                                                        ?>

                                                    </select>
                                                </div>
                                                <!-- <div class="col-lg-6 col-sm-12 mb-4">
                                                    <label for="Auditor" class="form-label">Auditor</label>
                                                    <input type="text" class="form-control" id="Auditor" autocomplete="off" placeholder="Auditor" name="Auditor" required>
                                                </div> -->
                                                <div class="col-lg-6 col-sm-12 mb-4">
                                                    <label for="FolioEditar" class="form-label">Folio</label>
                                                    <input type="text" class="form-control" id="FolioEditar" autocomplete="off" placeholder="Ticket/Factura" name="Folio" required>
                                                </div>
                                                <div class="col-lg-6 col-sm-12 mb-4">
                                                    <label for="CantidadEditar" class="form-label">Cantidad</label>
                                                    <input type="text" class="form-control" id="CantidadEditar" autocomplete="off" placeholder="0" name="CantidadEditar" required>
                                                </div>
                                                <div class="col-lg-12 col-sm-12 mb-4">
                                                    <label for="SKUEditar" class="form-label">Producto</label>
                                                    <select class="form-select select2" name="SKUEditar" id="SKUEditar" aria-label="Default select example" required>
                                                        <option selected>Selecciona Producto</option>

                                                            <?php while ($row_productos = mysqli_fetch_assoc($productos)) {?>

                                                                <option value="<?php echo $row_productos['Sku']; ?>">

                                                                    <?php echo $row_productos['Sku'] . " - " . $row_productos['Descripcion']; ?>

                                                                </option>
                                                            
                                                            <?php }

                                                            // Reset the pointer to the beginning
                                                            mysqli_data_seek($productos, 0);

                                                        ?>

                                                    </select>
                                                </div>
                                                <!-- <div class="col-lg-6 col-sm-12 mb-4">
                                                    <label for="SKU" class="form-label">SKU</label>
                                                    <input type="text" class="form-control" id="SKU" autocomplete="off" placeholder="000000" name="SKU" required>
                                                </div>-->
                                                <div class="col-lg-6 col-sm-12 mb-4">
                                                    <label for="VendedorEditar" class="form-label">Vendedor</label>
                                                    <select class="form-select select2" name="VendedorEditar" id="VendedorEditar" aria-label="Default select example" required>
                                                        <option selected>Selecciona Vendedor</option>

                                                            <?php while ($row_vendedores = mysqli_fetch_assoc($vendedores)) {?>

                                                                <option value="<?php echo $row_vendedores['NombreVendedor']; ?>">

                                                                    <?php echo $row_vendedores['NombreVendedor']; ?>

                                                                </option>
                                                            
                                                            <?php }

                                                            // Reset the pointer to the beginning
                                                            mysqli_data_seek($vendedores, 0);

                                                        ?>

                                                    </select>
                                                    <!-- <input type="text" class="form-control" id="Vendedor" autocomplete="off" placeholder="Nombre y apellido" name="Vendedor" required> -->
                                                </div>
                                                <div class="col-lg-6 col-sm-12 mb-4">
                                                    <label for="SurtidorEditar" class="form-label">Surtidor</label>
                                                    <input type="text" class="form-control" id="SurtidorEditar" autocomplete="off" placeholder="Nombre y apellido" name="SurtidorEditar">
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
                <div class="modal-footer">
                    <input type="hidden" id="INCIDENCIASIDEditar" name="INCIDENCIASIDEditar">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Editar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL DE BORRADO -->

<div class="modal" id="ModalBorrarIncidencias">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Eliminar Registro</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-body">
                                <h3>¿Estas seguro que deseas eliminar este registro?</h3>
                                <br>
                                <span id="EliminarIncidencias"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="INCIDENCIASIDBorrar" name="INCIDENCIASIDBorrar">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" id="BorrarIncidencias" class="btn btn-danger">Eliminar</button>
            </div>
        </div>
    </div>
</div>

