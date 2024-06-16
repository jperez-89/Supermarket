     <?= headerAdmin($data); ?>

     <!-- CONTENIDO PRICIPAL -->
     <main class="app-content">
          <div class="app-title">
               <div>
                    <h1><i class="fa fa-dashboard"></i> <?= $data['page_name'] ?></h1>
               </div>
               <ul class="app-breadcrumb breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url(); ?>dashboard"><i class="fa fa-home fa-lg"></i></a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url(); ?>error">Error</a></li>
               </ul>
          </div>
          <div class="row">
               <div class="col-md-12">
                    <div class="flex-center position-ref full-height">

                         <div class="code">
                              Error 404 </div>
                         <!-- <h1> -->
                         <div class="message" style="padding: 10px;">
                              Pages Not Found </div>
                         <!-- </h1> -->
                    </div>
               </div>
          </div>
     </main>

     <?= footerAdmin(); ?>