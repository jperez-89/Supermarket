<?= headerAdmin($data); ?>

<!-- CONTENIDO PRICIPAL -->
<main class="app-content animate__animated animate__headShake ">
    <div class="app-title">
        <div class='flex-center'>
            <h1><?= $data['page_name'] ?> </h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item">
                <a href="<?= base_url(); ?>dashboard"><i class="fa fa-home fa-lg"></i></a>
            </li>
            <li class="breadcrumb-item">
                <a href="<?= base_url(); ?>creditos" class=""> Creditos</a>
            </li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <button onclick="OpenModal();" type="button" class="btn text-muted" data-toggle="modal" data-target="#modalCredito"><i class="fas fa-plus-circle"></i> Nuevo Crédito</button>
                <div class="table-responsive">
                    <table class="table table-centered table-sm" id="tblCreditos" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Identificación</th>
                                <th>Nombre</th>
                                <th>Teléfono</th>
                                <th>Limite Crédito</th>
                                <th>Pendiente Pago</th>
                                <th>Saldo Actual</th>
                                <th>Estado</th>
                                <th>Acciones</th>
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

<!-- MODAL FACTURAS CREDITO CLIENTE -->
<div id="ModalFacturasCreditoCliente" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" class="modal fade">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title" id="myModalLabel">Facturas por Cobrar</h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="tile">
                            <div class="table-responsive">
                                <table class="table table-centered table-sm w-100" id="tblFacturaCreditoCliente">
                                    <thead>
                                        <tr>
                                            <th># Venta</th>
                                            <th>Fecha</th>
                                            <th># Factura</th>
                                            <th>Tipo Documento</th>
                                            <th>Tipo Pago</th>
                                            <th>Monto Total</th>
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
                <br>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" aria-label="Close">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<!-- FIN MODAL FACTURAS CREDITO CLIENTE -->

<?=
ShowModal('modalCreditos');
footerAdmin($data);
?>