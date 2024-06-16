<!-- Modal -->
<div class="modal fade" id="modalUsuario" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-hidden="true">
     <div class="modal-dialog modal-lg">
          <div class="modal-content">
               <div class="modal-header headerRegister">
                    <h2 class="tile-title" id="titleModal">Nuevo Usuario</h2>
               </div>
               <div class="modal-body">
                    <div class="tile">
                         <form id="frmUsuarios" name="frmUsuarios">
                              <input type="hidden" name="idUsuario" id="idUsuario" value="0">
                              <div class="row">
                                   <div class="col-md-3">
                                        <div class="form-group">
                                             <label for="txtIdentificacion" class="control-label">Identificación</label>
                                             <input class="form-control" id="txtIdentificacion" name="txtIdentificacion" type="text" placeholder="Identificación">
                                        </div>
                                   </div>
                                   <div class="col-md-3">
                                        <div class="form-group">
                                             <label for="txtNombre" class="control-label">Nombre</label>
                                             <input class="form-control" id="txtNombre" name="txtNombre" type="text" placeholder="Nombre">
                                        </div>
                                   </div>
                                   <div class="col-md-4">
                                        <div class="form-group">
                                             <label for="txtApellidos" class="control-label">Apellidos</label>
                                             <input class="form-control" id="txtApellidos" name="txtApellidos" type="text" placeholder="Apellidos">
                                        </div>
                                   </div>
                                   <div class="col-md-2">
                                        <div class="form-group">
                                             <label for="txtTelefono" class="control-label">Teléfono</label>
                                             <input class="form-control" id="txtTelefono" name="txtTelefono" type="text" placeholder="Teléfono">
                                        </div>
                                   </div>
                              </div>

                              <div class="row">
                                   <div class="col-md-4">
                                        <div class="form-group">
                                             <label for="txtEmail" class="control-label">Email</label>
                                             <input class="form-control" id="txtEmail" name="txtEmail" type="email" placeholder="Email">
                                        </div>
                                   </div>
                                   <div class="col-md-4">
                                        <div class="form-group">
                                             <label for="txtUsuario" class="control-label">Usuario</label>
                                             <input class="form-control" id="txtUsuario" name="txtUsuario" type="text" placeholder="Usuario">
                                        </div>
                                   </div>
                                   <div class="col-md-4">
                                        <div class="form-group">
                                             <label for="txtContra" class="control-label">Contraseña</label>
                                             <input class="form-control" id="txtContra" name="txtContra" type="password" placeholder="Contraseña">
                                             <i class="fa fa-eye" style="position: relative;top: -26px;right: 10px;float: right;font-size: 16px;" onclick="if($('#txtContra').attr('type')=='text'){$('#txtContra').attr('type','password');$(this).attr('class','fa fa-eye');}else{$('#txtContra').attr('type','text');$(this).attr('class','fa fa-eye-slash');}"></i>
                                        </div>
                                   </div>
                              </div>

                              <div class="row">
                                   <div class="col-md-4">
                                        <div class="form-group">
                                             <label for="selecRol" class="control-label">Rol</label>
                                             <select class="form-control" name="selecRol" id="selecRol">
                                             </select>
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