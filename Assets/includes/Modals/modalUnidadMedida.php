<!-- Modal -->
<div class="modal fade" id="modalUnidadMedida" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header headerRegister">
                <h2 class="tile-title" id="titleModal">Nueva Unidad de Medida</h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="tile">
                    <div class="tile-body">
                        <form id="frmUnidadMedida" name="frmUnidadMedida" novalidate>
                            <input type="hidden" name="idUnidadMedida" id="idUnidadMedida" value="0">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="nombreUnidad" class="control-label">Nombre</label>
                                        <input class="form-control" id="nombreUnidad" name="nombreUnidad" type="text" placeholder="Nombre unidad medida" required>
                                        <div class="invalid-feedback">Este campo es requerido</div>
                                    </div>
                                    <div class="form-group">
                                        <label for="nomenclatura" class="control-label">Abreviatura</label>
                                        <input class="form-control" id="nomenclatura" name="nomenclatura" type="text" placeholder="Abreviatura" required>
                                        <div class="invalid-feedback">Este campo es requerido</div>
                                    </div>
                                    <div class="form-group has-validation">
                                        <label for="equivalencia" class="control-label">Equivalenicia</label>
                                        <input class="form-control" id="equivalencia" name="equivalencia" type="text" placeholder="Equivalenicia" required>
                                        <div class="invalid-feedback">Este campo es requerido</div>
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