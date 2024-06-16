<?= headerAdmin($data); ?>

<!-- CONTENIDO PRICIPAL -->
<main class="app-content animate__animated animate__headShake">
     <div class="app-title">
          <h1><?= $data['page_name'] ?></h1>
          <form class="d-flex">
               <div class="input-group">
                    <input type="date" id="txtFecha" step="1" pattern="[0-9]{2}-[0-9]{2}-[0-9]{4}" class="form-control form-control-light">
                    <!-- pattern="[0-9]{2}-[0-9]{2}-[0-9]{4}" -->
               </div>
          </form>
     </div>

     <div class="container-fluid mt-2">
          <div class="row">
               <div class="col-md-6 col-lg-3">
                    <div class="widget-small shadow ">
                         <a href="<?= base_url(); ?>facturacion/facturas"><i class="icon fas fa-file-invoice-dollar fa-3x"></i></a>
                         <div class="info">
                              <h4>Facturas</h4>
                              <p><b id="cantFacturas"></b></p>
                         </div>
                    </div>
               </div>
               <div class="col-md-6 col-lg-3">
                    <div class="widget-small shadow ">
                         <a href="<?= base_url(); ?>clientes"><i class="icon fas fa-users fa-3x"></i></a>
                         <div class="info">
                              <h4>Clientes</h4>
                              <p> <b id="cantClientes"></b> </p>
                         </div>
                    </div>
               </div>
               <div class="col-md-6 col-lg-3">
                    <div class="widget-small shadow ">
                         <a href="<?= base_url(); ?>productos"><i class="icon fas fa-gifts fa-3x"></i></a>
                         <div class="info">
                              <h4>Productos</h4>
                              <p> <b id="cantProductos"></b> </p>
                         </div>
                    </div>
               </div>
               <div class="col-md-6 col-lg-3">
                    <div class="widget-small shadow ">
                         <a href="<?= base_url(); ?>usuarios"><i class="icon fas fa-user-cog fa-3x"></i></a>
                         <div class="info">
                              <h4>Usuarios</h4>
                              <p> <b id="cantUsers"></b> </p>
                         </div>
                    </div>
               </div>
          </div>

          <div class="row pb-3">
               <div class="col-md-6">
                    <div class="tile w-100 h-100">
                         <a href="<?= base_url() ?>productos">
                              <h3 class="text-center text-info text-uppercase pb-1 mt-1">Productos por Abastecer</h3>
                         </a>
                         <div class="table-responsive">
                              <table class="table table-centered table-sm" id="tblProductosMinimos" style="width: 100%;">
                                   <thead>
                                        <tr>
                                             <th>Id</th>
                                             <th>Nombre</th>
                                             <th>Unidad de Medida</th>
                                             <th>Stock Actual</th>
                                             <th>Stock Minimo</th>
                                        </tr>
                                   </thead>
                                   <tbody>
                                   </tbody>
                              </table>
                         </div>
                    </div>
               </div>

               <div class="col-md-6">
                    <div class="tile w-100 h-100">
                         <a href="<?= base_url() ?>creditos">
                              <h3 class="text-center text-info text-uppercase pb-1 mt-1">Crédito Pendiente de Pago</h3>
                         </a>
                         <div class="table-responsive">
                              <table class="table table-centered table-sm w-100" id="tblCreditoPendiente">
                                   <thead>
                                        <tr>
                                             <th>Nombre</th>
                                             <th>Telefono</th>
                                             <th>Límite de Crédito</th>
                                             <th>Pendite de Pago</th>
                                             <th>Saldo Actual</th>
                                        </tr>
                                   </thead>
                                   <tbody>
                                   </tbody>
                              </table>
                         </div>
                    </div>
               </div>
          </div>

          <div class="row">
               <div class="col-md-6">
                    <div class="row">
                         <div class="col-md-6">
                              <div class="tile w-100 h-100">
                                   <a href="#">
                                        <h3 class="text-center text-black-50 text-uppercase pb-1 mt-1">Forma de Pago por Mes</h3>
                                   </a>

                                   <div class="row">
                                        <div class="col-md-6">
                                             <label for="fchInicioFPagoMes">Fecha Inicio</label>
                                             <input class="form-control date" type="date" name="fchInicioFPagoMes" id="fchInicioFPagoMes">
                                        </div>
                                        <div class="col-md-6">
                                             <label for="fchFinFPagoMes">Fecha Fin</label>
                                             <input class="form-control" type="date" name="fchFinFPagoMes" id="fchFinFPagoMes">
                                        </div>
                                   </div>
                                   <div class="row pt-3">
                                        <div class="col-md-12 col-sm-12">
                                             <canvas class="w-100 h-100" id="ChartFPagoMes"></canvas>
                                        </div>
                                   </div>
                              </div>
                         </div>
                         <div class="col-md-6">
                              <div class="tile w-100 h-100">
                                   <a href="<?= base_url() ?>facturacion/facturas">
                                        <h3 class="text-center text-black-50 text-uppercase pb-1 mt-1">Reporte de Facturas Emitidas</h3>
                                   </a>
                                   <h3 class="text-center pb-1 mt-1"></h3>

                                   <div class="row">
                                        <div class="col-md-6">
                                             <label for="fchInicio">Fecha Inicio</label>
                                             <input class="form-control date" type="date" name="fchInicio" id="fchInicio">
                                        </div>
                                        <div class="col-md-6">
                                             <label for="fchFin">Fecha Fin</label>
                                             <input class="form-control" type="date" name="fchFin" id="fchFin">
                                        </div>
                                   </div>
                                   <div class="row pt-3">
                                        <div class="col-md-12 col-sm-12">
                                             <canvas class="w-100 h-100" id="myChart"></canvas>
                                        </div>
                                   </div>
                              </div>
                         </div>
                    </div>
               </div>
               <div class="col-md-6">
                    <div class="tile w-100 h-100">
                         <a href="#">
                              <h3 class="text-center text-black-50 text-uppercase pb-1 mt-1">Ventas de los ultimos 3 meses</h3>
                         </a>
                         <div class="row pt-3">
                              <div class="col-md-12 col-sm-12">
                                   <canvas class="w-100 h-100" id="ChartVenta3Meses"></canvas>
                              </div>
                         </div>
                    </div>
               </div>
          </div>
     </div>
</main>

<?= footerAdmin($data); ?>