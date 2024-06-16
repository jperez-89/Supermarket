<?= headerAdmin($data); ?>

<!-- CONTENIDO PRICIPAL -->
<main class="app-content animate__animated animate__headShake ">
     <div class="app-title">
          <div class='flex-center'>
               <h1></i> <?= $data['page_name'] ?></h1>
          </div>
          <ul class="app-breadcrumb breadcrumb">
               <li class="breadcrumb-item">
                    <a href="<?= base_url(); ?>dashboard"><i class="fa fa-home fa-lg"></i></a>
               </li>
               <li class="breadcrumb-item">
                    <a href="<?= base_url(); ?>clientes" class=""> Clientes</a>
               </li>
          </ul>
     </div>
     <div class="row">
          <div class="col-md-12">
               <div class="tile">
                    <button onclick="OpenModal();" type="button" class="btn text-muted" data-toggle="modal" data-target="#modalCliente"><i class="fas fa-plus-circle"></i> Nuevo Cliente</button>
                    <div class="table-responsive-sm">
                         <table class="table table-centered table-sm" id="tblClientes" style="width: 100%;">
                              <thead>
                                   <tr>
                                        <th>Id</th>
                                        <th>Identificación</th>
                                        <th>Nombre</th>
                                        <th>Teléfono</th>
                                        <th>Email</th>
                                        <th>Dirección</th>
                                        <th>Tipo Régimen</th>
                                        <th>Estado Hacienda</th>
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

<?=
ShowModal('modalClientes');
footerAdmin($data);
?>