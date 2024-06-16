<?= headerAdmin($data); ?>

<!-- CONTENIDO PRICIPAL -->
<main class="app-content animate__animated animate__headShake">
     <div class="app-title">
          <h1><?= $data['page_name'] ?></h1>
          <ul class="app-breadcrumb breadcrumb">
               <li class="breadcrumb-item"><a href="<?= base_url(); ?>dashboard"><i class="fa fa-home fa-lg"></i></a></li>
               <li class="breadcrumb-item"><a href="#"><i class=""></i>Ventas</a></li>
               <li class="breadcrumb-item active"><a class="active" href="<?= base_url(); ?>facturacion/nueva_venta"> Nueva Venta</a></li>
          </ul>
     </div>

     <div class="row">
          <div class="col-md-9">
               <div class="tile">
                    <div class="row">
                         <div class="col-md-4">
                              <div class="form-floating">
                                   <input type="text" class="form-control" name="nombreProducto" id="nombreProducto" placeholder=" " aria-describedby="nombreProducto">
                                   <label for="nombreProducto">Nombre del producto <strong id="alerta"></strong></label>
                              </div>
                              <ul class="list1" id="listaProductos" style="display: none;"></ul>
                         </div>
                         <div class="col-md-2">
                              <div class="form-floating">
                                   <input type="text" class="form-control" name="Precio" id="Precio" placeholder=" " disabled>
                                   <label for="Precio">Precio</label>
                              </div>
                         </div>
                         <div class="col-md-2">
                              <div class="form-floating">
                                   <input type="text" class="form-control" name="Stock" id="Stock" placeholder=" " disabled>
                                   <label for="Stock">Stock</label>
                              </div>
                         </div>
                         <div class="col-md-2">
                              <div class="form-floating">
                                   <input type="text" class="form-control" name="Cantidad" id="Cantidad" placeholder=" ">
                                   <label for="Cantidad">Cantidad</label>
                              </div>
                         </div>
                         <div class="col-md-2">
                              <div id="add">
                                   <button id="btnAgregarProducto" class="btn btn-primaryFac btn-block" name="btnAgregarProducto" style="height: calc(3rem + 2px);">Agregar</button>
                              </div>
                              <div id="update" style="display: none;">
                                   <button id="btnActualizarProducto" class="btn btn-primaryFac btn-block" name="btnActualizarProducto" style="height: calc(3rem + 2px);">Actualizar</button>
                              </div>
                         </div>
                    </div>
                    <div class="row">
                         <div class="col-md-12">
                              <div class="form-group mt-3">
                                   <label for="txtCodigo" class="control-label">Escanear Código de Barras</label>
                                   <div class="input-group">
                                        <div class="input-group-text">
                                             <i class="fa fa-barcode"></i>
                                        </div>
                                        <input type="hidden" name="codigo" id="codigo" value="">
                                        <input type=" text" class="form-control" name="txtCodigo" id="txtCodigo" autocomplete="off">
                                   </div>
                              </div>
                         </div>
                    </div>
                    <div class="row">
                         <div class="col-md-12">
                              <div class="table-responsive">
                                   <table id="tblFactura" class="table table-centered table-sm" style="width: 100%;">
                                        <thead>
                                             <tr>
                                                  <th>id</th>
                                                  <th>Código</th>
                                                  <th>Cantidad</th>
                                                  <th>Nombre</th>
                                                  <th>Precio Unitario</th>
                                                  <th>Subtotal</th>
                                                  <th>IVA</th>
                                                  <th>Total</th>
                                                  <th>Acción</th>
                                             </tr>
                                        </thead>
                                        <tbody id="deta_venta">
                                        </tbody>
                                   </table>
                              </div>
                         </div>
                    </div>
               </div>
          </div>

          <div class="col-md-3">
               <div class="card tile">
                    <div class="text-center total">
                         <h1 class="text-center text-uppercase">Total Factura </h1>
                         <h1 id="totalFacturaLbl" class="text-center mt-0">0.00</h1>
                    </div>
                    <form id="frmFacturacion" method="post">
                         <input type="hidden" name="idCliente" id="idCliente" value="">
                         <div class="form-floating mb-1">
                              <input type="text" class="form-control" id="Identificacion" name="Identificacion" autocomplete="off" placeholder="No digite guiones ni espacios" maxlength="10" value="">
                              <label for="Identificacion">Identificación</label>
                              <ul class="list1" id="listaIdentificacion" style="display: none;"></ul>
                         </div>
                         <div class="form-floating mb-1">
                              <input id="Nombre" type="text" class="form-control" name="Nombre" placeholder=" ">
                              <label for="Nombre">Nombre</label>
                              <ul class="list1" id="listaNombre" style="display: none;"></ul>
                         </div>
                         <div class="form-floating">
                              <input disabled id="Email" type="text" class="form-control" name="Email" placeholder=" " autocomplete="off">
                              <label for="Email">Email</label>
                         </div>
                         <div class="mt-3">
                              <div class="row">
                                   <div class="col-md-12">
                                        <label for="tipoDocumento text-uppercase">Tipo Documento</label>
                                        <select class="custom-select" name="tipoDocumento" id="tipoDocumento">
                                        </select>
                                   </div>
                              </div>
                              <div class="row mt-2">
                                   <div class="col-md-12">
                                        <label for="tipoPago text-uppercase">Tipo Pago</label>
                                        <select id="tipoPago" name="tipoPago" class="custom-select form-control">
                                        </select>
                                   </div>
                              </div>
                         </div>

                         <div class="justify-content-between">
                              <div class="row mt-4">
                                   <div class="col-md-4">
                                        <div class="form-floating">
                                             <input type="text" class="form-control text-right" name="Subtotal1" id="Subtotal1" placeholder=" " disabled>
                                             <label for="Subtotal1" class="text-align-right text-uppercase">SubTotal</label>
                                             <input class="text-align-right" type="hidden" name="Subtotal" id="Subtotal" value="">
                                        </div>
                                   </div>
                                   <div class="col-md-4">
                                        <div class="form-floating">
                                             <input type="text" class="form-control text-right" name="iva1" id="iva1" placeholder=" " disabled>
                                             <label for="iva1" class="text-uppercase">iva</label>
                                             <input class="text-align-right" type="hidden" name="iva" id="iva" value="">
                                        </div>
                                   </div>
                                   <div class="col-md-4">
                                        <div class="form-floating">
                                             <input type="text" class="form-control text-right" name="totalFactura1" id="totalFactura1" placeholder=" " disabled>
                                             <label for="totalFactura1" class="text-uppercase">Total</label>
                                             <input type="hidden" name="totalFactura" id="totalFactura" value="">
                                        </div>
                                   </div>
                              </div>
                         </div>
                         <div class="pt-3">
                              <button style="height: calc(3rem + 2px);" class="btn btn-primaryFac btn-block text-uppercase" id="btnFacturar">Facturar</button>
                         </div>
                    </form>
               </div>
          </div>
     </div>
</main>

<?=
footerAdmin($data);
?>