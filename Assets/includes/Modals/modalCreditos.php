<!-- Modal -->
<div class="modal fade" id="modalCredito" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header headerRegister">
                <h2 class="tile-title" id="titleModal">Nuevo Crédito</h2>
            </div>
            <div class="modal-body">
                <div class="tile">
                    <div class="tile-body">
                        <form id="frmCredito" name="frmCredito">
                            <input type="hidden" name="idCredito" id="idCredito" value="0">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="hidden" name="idCliente" id="idCliente" value="0">
                                        <label for="txtIdentificacion" class="control-label">Identificación</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="txtIdentificacion" name="txtIdentificacion" maxlength="10" placeholder="Número de indentificación">
                                        </div>
                                        <ul class="list1 w-100" id="listaIdentificacion" style="display: none;"></ul>
                                    </div>
                                    <div class="form-group">
                                        <label for="txtNombre" class="control-label">Nombre Completo</label>
                                        <input class="form-control" id="txtNombre" name="txtNombre" type="text" placeholder="Nombre o razón social">
                                        <ul class="list1" id="listaNombre" style="display: none;"></ul>
                                    </div>
                                    <div class="form-group">
                                        <label for="txtTelefono" class="control-label">Teléfono</label>
                                        <input disabled class="form-control" id="txtTelefono" name="txtTelefono" type="text" placeholder="Teléfono">
                                    </div>
                                    <div class="form-group">
                                        <label for="montoCredito" class="control-label">Monto del Crédito</label>
                                        <input class="form-control" id="montoCredito" name="montoCredito" type="text" placeholder="0.00">
                                    </div>
                                </div>
                            </div>
                            <div class="tile-footer float-right">
                                <button class="btn btn-secondary cerrarModal" aria-label="Close" data-dismiss="modal"><i class="fa fa-fw fa-lg fa-times-circle"></i><span>Cancelar</span></button>
                                <button id="btnGuardar" class="btn btn-primaryFac" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i><span id="btnText">Guardar</span></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>