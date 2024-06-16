<?= headerAdmin($data); ?>

<!-- CONTENIDO PRICIPAL -->
<main class="app-content animate__animated animate__headShake ">
     <div class="app-title">
          <div class="flex-center">
               <h1><?= $data['page_name'] ?></h1>
          </div>
          <ul class="app-breadcrumb breadcrumb">
               <li class="breadcrumb-item"><a href="<?= base_url(); ?>dashboard"><i class="fa fa-home fa-lg"></i></a></li>
               <li class="breadcrumb-item"><a href="<?= base_url(); ?>usuarios"> Usuarios</a></li>
          </ul>
     </div>
     <div class="row">
          <div class="col-md-12">
               <div class="tile">
                    <button onclick="OpenModal();" type="button" class="btn text-muted" data-toggle="modal" data-target="#modalUsuario"><i class="fas fa-plus-circle"></i> Nuevo Usuario</button>
                    <div class="table-responsive">
                         <table class="table table-centered table-sm" id="tblUsuarios" style="width: 100%;">
                              <thead>
                                   <tr>
                                        <th>ID</th>
                                        <th>Identificación</th>
                                        <th>Nombre</th>
                                        <th>Apellidos</th>
                                        <th>Teléfono</th>
                                        <th>Email</th>
                                        <th>Usuario</th>
                                        <th>Contraseña</th>
                                        <th>Rol</th>
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

<?= ShowModal('modalUsuarios');
footerAdmin($data); ?>