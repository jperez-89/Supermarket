<?= headerAdmin($data); ?>

<!-- CONTENIDO PRICIPAL -->
<main class="app-content animate__animated animate__headShake">
     <div class="app-title">
          <h1><?= $data['page_name'] ?></h1>
          <ul class="app-breadcrumb breadcrumb">
               <li class="breadcrumb-item"><a href="<?= base_url(); ?>dashboard"><i class="fa fa-home fa-lg"></i></a></li>
               <li class="breadcrumb-item"><a href="<?= base_url(); ?>facturacion/facturas"> Facturas</a></li>
          </ul>
     </div>
     <div class="row">
          <div class="col-md-12">
               <div class="tile">
                    <div class="table-responsive">
                         <table class="table table-centered w-100 table-sm" id="tblFacturas">
                              <thead>
                                   <tr>
                                        <th># Venta</th>
                                        <th>Cliente</th>
                                        <th>Identificación</th>
                                        <th>Fecha</th>
                                        <th># Documento</th>
                                        <th>Monto Total</th>
                                        <th>Tipo Documento</th>
                                        <th>Tipo Pago</th>
                                        <th>Estado</th>
                                        <th>Acción</th>
                                   </tr>
                              </thead>
                              <tbody>
                              </tbody>
                         </table>
                    </div>
               </div>
          </div>
     </div>
</main>

<!-- MODAL DETALLE FACTURA -->
<div id="ModalDetalleFactura" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" class="modal fade">
     <div class="modal-dialog modal-xl" role="document">
          <div class="modal-content">
               <div class="modal-header">
                    <h2 class="modal-title" id="myModalLabel">Detalle de Factura</h2>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
               </div>
               <div class="modal-body">
                    <div class="row">
                         <div class="col-md-12">
                              <div class="tile">
                                   <div class="table-responsive">
                                        <table class="table table-centered table-sm w-100" id="tblDetalleFactura">
                                             <thead>
                                                  <tr>
                                                       <th>Producto</th>
                                                       <th>Cantidad</th>
                                                       <th>Precio Unitario</th>
                                                       <th>Sub Total</th>
                                                       <th>IVA</th>
                                                       <th>Total</th>
                                                  </tr>
                                             </thead>
                                             <tbody>
                                             </tbody>
                                        </table>
                                   </div>
                              </div>
                         </div>
                    </div>
                    <br>
               </div>
               <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" aria-label="Close">Cerrar</button>
               </div>
          </div>
     </div>
</div>
<!-- FIN MODAL DETALLE FACTURA -->

<?=
footerAdmin($data);
?>