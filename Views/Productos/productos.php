<?= headerAdmin($data); ?>

<!-- CONTENIDO PRICIPAL -->
<main class="app-content animate__animated animate__headShake ">
     <div class="app-title">
          <div class="flex-center">
               <h1><?= $data['page_name'] ?></h1>
          </div>
          <ul class="app-breadcrumb breadcrumb">
               <li class="breadcrumb-item"><a href="<?= base_url(); ?>dashboard"><i class="fa fa-home fa-lg"></i></a></li>
               <li class="breadcrumb-item"><a href="<?= base_url(); ?>productos"> Productos</a></li>
          </ul>
     </div>
     <div class="row">
          <div class="col-md-12">
               <div class="tile">
                    <button onclick="OpenModal();" type="button" class="btn text-muted" data-toggle="modal" data-target="#modalProducto"><i class="fas fa-plus-circle"></i> Nuevo Producto</button>
                    <div class="table-responsive">
                         <table class="table table-centered table-sm w-100" id="tblProductos">
                              <thead>
                                   <tr>
                                        <th>Id</th>
                                        <th>Codigo</th>
                                        <th>Imagen</th>
                                        <th>Nombre</th>
                                        <th>Descripción</th>
                                        <th>Medida</th>
                                        <th>Precio</th>
                                        <th>IVA</th>
                                        <th>Existencia</th>
                                        <th>Stock Mínimo</th>
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

     <script>
          //      function reset() {
          //           $("#image").empty();
          //           $("#tiff").empty();
          //      }
          //      var input = document.querySelector('input[type=file]');
          //      input.onchange = function() {
          //           reset();
          //           var file = input.files[0];
          //           var fileReader = new FileReader();
          //           // get file extension
          //           var extension = file.name.split('.').pop().toLowerCase();
          //           var isTiff = false;
          //           if (extension == "tif" || extension == "tiff") {
          //                isTiff = true;
          //           }
          //           fileReader.onload = function(e) {
          //                if (isTiff) {
          //                     console.debug("Parsing TIFF image...");
          //                     //initialize with 100MB for large files
          //                     Tiff.initialize({
          //                          TOTAL_MEMORY: 100000000
          //                     });
          //                     var tiff = new Tiff({
          //                          buffer: e.target.result
          //                     });
          //                     var tiffCanvas = tiff.toCanvas();
          //                     $(tiffCanvas).css({
          //                          "max-width": "800px",
          //                          "width": "100%",
          //                          "height": "auto",
          //                          "display": "block",
          //                          "padding-top": "10px"
          //                     }).addClass("TiffPreview");
          //                     $("#tiff").append(tiffCanvas);
          //                } else {
          //                     var dataURL = e.target.result,
          //                          img = new Image();
          //                     img.src = dataURL;
          //                     $("#image").append(img);
          //                }
          //           }
          //           if (isTiff) {
          //                fileReader.readAsArrayBuffer(file);
          //           } else
          //                fileReader.readAsDataURL(file);
          //      }
          // 
     </script>


     <!-- <form action="/upload.php" method="post" enctype="multipart/form-data">
          <input type="file" name="BarcodeQrImage" id="BarcodeQrImage" accept="image/*"><br>
          <input type="submit" value="Read Barcode" name="submit">
     </form>
     <img id="image" />

     <script>
          var input = document.querySelector('input[type=file]');
          input.onchange = function() {
               var file = input.files[0];
               var fileReader = new FileReader();
               fileReader.onload = function(e) {
                    {
                         let image = document.getElementById('image');
                         image.src = e.target.result;
                    }
               }
               fileReader.readAsDataURL(file);
          }
     </script> -->
</main>

<?=
ShowModal('modalProductos');
footerAdmin($data);
?>