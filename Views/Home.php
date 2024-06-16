<!DOCTYPE html>
<html lang="en">

<head>
     <meta charset="utf-8">
     <!-- Descripcion que se muestran en los resultados de la busqueda de google -->
     <meta name="description" content="Supermercado en Linea">
     <meta http-equiv="X-UA-Compatible" content="IE=edge">
     <meta name="viewport" content="width=device-width, initial-scale=1">
     <meta name="author" content="Jairo RPR">
     <meta name="theme-color" content="#009688">
     <link rel="shortcut icon" href="<?= media(); ?>images/favicon2.ico" type="image/x-icon">

     <!-- Main CSS-->
     <link rel="stylesheet" type="text/css" href="<?php echo media(); ?>css/main.css">
     <title>Supermarket - Home</title>
</head>

<body>
     <nav class="navbar navbar-expand-lg navbar-light bg-light">
          <div class="container-fluid">
               <a class="navbar-brand" href="<?= base_url(); ?>home">LOGO</a>
               <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
               </button>
               <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                         <li class="nav-item">
                              <a class="nav-link active" aria-current="page" href="<?= base_url(); ?>login"><i class="fa fa-user-alt"> Mi cuenta</i></a>
                         </li>
                    </ul>
               </div>
          </div>
     </nav>

     <main>
          <h3 class="m-3">AQUI VA LA TIENDA DE PRODUCTOS</h3>
     </main>

     <!-- Essential javascripts for application to work-->
     <script type="text/javascript" src="<?php echo media(); ?>js/jquery-3.3.1.min.js"></script>
     <script type="text/javascript" src="<?php echo media(); ?>js/popper.min.js"></script>
     <script type="text/javascript" src="<?php echo media(); ?>js/bootstrap.min.js"></script>
     <script type="text/javascript" src="<?php echo media(); ?>js/main.js"></script>
     <script type="text/javascript" src="<?php echo media(); ?>js/fontawesome.js"></script>
     <!-- The javascript plugin to display page loading on top-->
     <script type="text/javascript" src="<?php echo media(); ?>js/plugins/pace.min.js"></script>
</body>

</html>