<!-- Modal -->
<div class="modal fade" id="modalCliente" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-hidden="true">
     <div class="modal-dialog modal-lg">
          <div class="modal-content">
               <div class="modal-header headerRegister">
                    <h2 class="tile-title" id="titleModal">Nuevo Cliente</h2>
               </div>
               <div class="modal-body">
                    <div class="tile">
                         <div class="tile-body">
                              <form id="frmClientes" name="frmClientes">
                                   <input type="hidden" name="idCliente" id="idCliente" value="0">
                                   <div class="row">
                                        <div class="col-md-6">
                                             <div class="form-group">
                                                  <label for="txtIdentificacion" class="control-label">Identificación</label>
                                                  <div class="input-group">
                                                       <input type="text" class="form-control" id="txtIdentificacion" name="txtIdentificacion" maxlength="10" placeholder="Número de indentificación">
                                                       <button id="btnIdentificacion" class="btn btn-outline-secondary" type="button"><i class="fa fa-fw fa-lg fa-search"></i></button>
                                                  </div>
                                             </div>
                                             <div class="form-group">
                                                  <label for="txtNombre" class="control-label">Nombre Completo</label>
                                                  <input class="form-control" id="txtNombre" name="txtNombre" type="text" placeholder="Nombre o razón social">
                                             </div>
                                             <div class="form-group">
                                                  <label for="txtTelefono" class="control-label">Teléfono</label>
                                                  <input maxlength="8" class="form-control" id="txtTelefono" name="txtTelefono" type="text" placeholder="Teléfono">
                                             </div>
                                             <div class="form-group">
                                                  <label for="txtEmail" class="control-label">Email</label>
                                                  <input class="form-control" id="txtEmail" name="txtEmail" type="email" placeholder="Email">
                                             </div>
                                        </div>

                                        <div class="col-md-6">
                                             <div class="form-group">
                                                  <label for="selecProvincia" class="control-label">Provincia</label>
                                                  <select onchange="CargaCanton_Fetch(this.value);" class="form-control" name="selecProvincia" id="selecProvincia">
                                                  </select>
                                             </div>
                                             <div class="form-group">
                                                  <label for="selecCanton" class="control-label">Cantón</label>
                                                  <select onchange="CargaDistrito_Fetch(this.value);" class="form-control" name="selecCanton" id="selecCanton">
                                                  </select>
                                             </div>
                                             <div class="form-group">
                                                  <label for="selecDistrito" class="control-label">Distrito</label>
                                                  <select class="form-control" name="selecDistrito" id="selecDistrito">
                                                  </select>
                                             </div>
                                             <div class="form-group">
                                                  <label for="txtDireccion" class="control-label">Dirección</label>
                                                  <input class="form-control" id="txtDireccion" name="txtDireccion" type="text" placeholder="Dirección exacta">
                                             </div>
                                        </div>
                                   </div>
                                   <div class="row">
                                        <div class="col-md-4">
                                             <div class="form-group">
                                                  <label for="selecRegimen" class="control-label">Régimen</label>
                                                  <select class="form-control" name="selecRegimen" id="selecRegimen">
                                                  </select>
                                             </div>
                                        </div>
                                        <div class="col-md-4">
                                             <div class="form-group">
                                                  <label for="estadoHacienda" class="control-label">Estado Hacienda</label>
                                                  <input disabled class="form-control" type="text" name="estadoHacienda" id="estadoHacienda" value="">
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