<!DOCTYPE html>
<html lang="es">

<head>
     <meta charset="utf-8">
     <!-- Descripcion que se muestran en los resultados de la busqueda de google -->
     <meta name="description" content="Supermercado en Linea">
     <meta http-equiv="X-UA-Compatible" content="IE=edge">
     <meta name="viewport" content="width=device-width, initial-scale=1">
     <meta name="author" content="Jairo RPR">
     <meta name="theme-color" content="#35b8e0">
     <link rel="shortcut icon" href="<?= media(); ?>images/favicon2.ico" type="image/x-icon">
     <title><?php echo $data["page_title"] ?></title>

     <!-- DataTables CSS -->
     <link rel="stylesheet" type="text/css" href="<?php echo media() ?>css/dataTables.bootstrap5.min.css">

     <!-- Main CSS-->
     <link rel="stylesheet" type="text/css" href="<?php echo media() ?>css/main.css">

     <!-- SweetAlert CSS-->
     <script type="text/javascript" src="<?php echo media() ?>js/plugins/sweetalert-2011.min.js"></script>

     <!-- Animate CSS-->
     <link rel="stylesheet" type="text/css" href="<?php echo media() ?>css/animate-4.1.1.min.css">

     <!-- Font Awesome CSS-->
     <link rel="stylesheet" type="text/css" href="<?php echo media() ?>css/fontawesome-6.4.0-all.css">
</head>

<body class="app sidebar-mini">
     <!-- Navbar-->
     <header class="app-header">
          <div class="app-header__logo">
               <a href="<?php echo base_url() ?>">SuperMarket</a>
          </div>

          <!-- Sidebar toggle button-->
          <a class="app-sidebar__toggle" href="#" data-toggle="sidebar" aria-label="Hide Sidebar"></a>

          <!-- Navbar Right Menu-->
          <ul class="app-nav">
               <!-- Boton de modificar tema -->
               <!-- <a id="theme-switcher" class="btn"></a> -->
               <div class="dropdown">
                    <a id="userDrop" href="#" role="button" data-toggle="dropdown" class="nav-link" aria-haspopup="true" aria-expanded="false">
                         <span id="nombre" class="font-weight-bold text-white"> <?php echo $_SESSION['name'] ?> </span>
                         <img class="settings" src="<?= media(); ?>images/avatar1.png" alt="User Image">
                    </a>

                    <div aria-labelledby="userDrop" class="dropdown-menu dropdown-menu-right shadow">
                         <a class="dropdown-item logout" href="#"><i class="fa fa-sign-out fa-lg"></i> Salir</a>
                    </div>
               </div>
          </ul>
     </header>

     <?= navBarAdmin(); ?>