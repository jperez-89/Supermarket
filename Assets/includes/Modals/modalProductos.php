<!-- Modal -->
<div class="modal fade" id="modalProducto" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-hidden="true">
     <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
          <div class="modal-content">
               <div class="modal-header headerRegister">
                    <h2 class="tile-title" id="titleModal">Nuevo Producto</h2>
               </div>
               <div class="modal-body">
                    <div class="tile">
                         <div class="tile-body">
                              <form id="frmProducto" name="frmProducto" enctype="multipart/form-data">
                                   <input type="hidden" name="idProducto" id="idProducto" value="">
                                   <!-- <div class="form-group">
                                        <div id="btnCamaraIn" style="display: none;">
                                             <button class="btn btn-light d-block w-100">Escanear Código de Barras con cámara</button>
                                        </div>
                                        <div id="btnCamaraOut" style="display: none;">
                                             <button class="btn btn-light d-block w-100">Ocultar Camara</button>
                                        </div>
                                        <div id="reader" style="width: 450px; display: none; position: relative; padding: 0px; border: 1px solid silver;"></div>
                                   </div> -->
                                   <div class="form-group">
                                        <label for="txtCodigo" class="control-label">Código de Barras</label>
                                        <div class="input-group">
                                             <div class="input-group-text"><i class="fa fa-barcode"></i></div>
                                             <input type="text" class="form-control" name="txtCodigo" id="txtCodigo" placeholder="Escanear o digitar" autocomplete="off">
                                             <!-- onchange=" buscarArticulo(); </div> -->
                                        </div>
                                   </div>
                                   <div class="form-group">
                                        <label for="txtNombre" class="control-label">Nombre</label>
                                        <input class="form-control" id="txtNombre" name="txtNombre" type="text" placeholder="Nombre">
                                        <ul class="list1" id="listaProductos" style="display: none;"></ul>
                                   </div>

                                   <div class="form-group">
                                        <label for="txtDescripcion" class="control-label">Descripción</label>
                                        <input class="form-control" id="txtDescripcion" name="txtDescripcion" type="text" placeholder="Descripción">
                                   </div>
                                   <div class="form-group">
                                        <label for="txtPrecio" class="control-label">Precio Compra</label>
                                        <div class="input-group">
                                             <div class="input-group-text">₡</div>
                                             <input class="form-control" id="txtPrecio" name="txtPrecio" type="text" placeholder="Precio">
                                        </div>
                                   </div>
                                   <div class="form-group">
                                        <label for="txtStock" class="control-label">Cantidad</label>
                                        <input class="form-control" id="txtStock" name="txtStock" type="text" placeholder="Cantidad">
                                   </div>
                                   <div class="form-group">
                                        <label for="txtMinimo" class="control-label">Cantidad mínima</label>
                                        <input class="form-control" id="txtMinimo" name="txtMinimo" type="text" placeholder="Cantidad mínima">
                                   </div>
                                   <div class="form-group">
                                        <label for="selecMedida" class="control-label">Medida</label>
                                        <select class="form-control" name="selecMedida" id="selecMedida">
                                        </select>
                                   </div>
                                   <div class="form-group">
                                        <label for="selecIVA" class="control-label">IVA</label>
                                        <select class="form-control" name="selecIVA" id="selecIVA">
                                        </select>
                                   </div>
                                   <div class="form-group">
                                        <div class="row">
                                             <div class="col-md-6">
                                                  <label for="image">Cargar imagen</label>
                                                  <input type="file" class="form-control-file" id="image" name="image" accept="image/*">
                                             </div>
                                             <div class="col-md-6 flex-center">
                                                  <div id="DivimgProducto" class="form-group">
                                                       <img class="pequenafrm" id="imgProducto">
                                                  </div>
                                             </div>
                                        </div>
                                   </div>
                                   <div class="tile-footer float-right">
                                        <button type="button" class="btn btn-secondary cerrarModal" aria-label="Close" data-dismiss="modal"><i class="fa fa-fw fa-lg fa-times-circle"></i><span>Cancelar</span></button>
                                        <button id="btnGuardar" class="btn btn-primaryFac" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i><span id="btnText">Guardar</span></button>
                                   </div>
                              </form>
                         </div>
                    </div>
               </div>
          </div>
     </div>
</div>