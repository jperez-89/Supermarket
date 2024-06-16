<!-- Sidebar menu-->
<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
<aside class="app-sidebar">
     <!--<div class="app-sidebar__user">
           <img class="app-sidebar__user-avatar" src="<?= media(); ?>images/avatar.png" alt="User Image">
          <div>
               <p id="RolUsuario" class="app-sidebar__user-designation"><?php echo $_SESSION['rol'] ?> </p>
          </div>
          </div> -->
     <ul class="app-menu">
          <!-- DASHBOARD --------------------------------------- -->
          <li>
               <a class="app-menu__item" href="<?= base_url() ?>">
                    <i class="app-menu__icon fa fa-dashboard"></i>
                    <span class="app-menu__label">Dashboard</span>
               </a>
          </li>

          <!-- VENTAS --------------------------------------- -->
          <li class="treeview">
               <a class="app-menu__item" href="#" data-toggle="treeview">
                    <i class="app-menu__icon fas fa-cash-register"></i>
                    <span class="app-menu__label">Ventas</span>
                    <i class="treeview-indicator fa fa-angle-right"></i>
               </a>
               <ul class="treeview-menu">
                    <li>
                         <a class="treeview-item" href="<?= base_url() ?>facturacion/nueva_venta" rel="noopener">
                              <i class="icon fa fa-circle-chevron-right"></i>Nueva venta
                         </a>
                    </li>
                    <li>
                         <a class="treeview-item" href="<?= base_url() ?>facturacion/facturas"><i class="icon fa fa-circle-chevron-right"></i>Ver ventas</a>
                    </li>
               </ul>
          </li>

          <!-- CREDITOS --------------------------------------- -->
          <li>
               <a class="app-menu__item" href="<?= base_url() ?>creditos">
                    <i class="app-menu__icon  fas fa-sack-dollar"></i>
                    <span class="app-menu__label">Créditos</span>
               </a>
          </li>

          <!-- CLIENTES --------------------------------------- -->
          <li>
               <a class="app-menu__item" href="<?= base_url() ?>clientes">
                    <i class="app-menu__icon fas fa-users"></i>
                    <span class="app-menu__label">Clientes</span>
               </a>
          </li>

          <!-- PRODUCTOS --------------------------------------- -->
          <li class="treeview">
               <a class="app-menu__item" href="#" data-toggle="treeview">
                    <i class="app-menu__icon fas fa-gifts"></i>
                    <span class="app-menu__label">Productos</span>
                    <i class="treeview-indicator fa fa-angle-right"></i>
               </a>
               <ul class="treeview-menu">
                    <li>
                         <a class="treeview-item" href="<?= base_url() ?>productos" rel="noopener">
                              <i class="icon fa fa-circle-chevron-right"></i>Agregar Producto
                         </a>
                    </li>
                    <li>
                         <a class="treeview-item" href="<?= base_url() ?>productos/unidad_medida"><i class="icon fa fa-circle-chevron-right"></i>Unidad de medida</a>
                    </li>
               </ul>
          </li>

          <!-- USUARIOS --------------------------------------- -->
          <li class="treeview">
               <a class="app-menu__item" href="#" data-toggle="treeview">
                    <i class="app-menu__icon fas fa-user-cog"></i>
                    <span class="app-menu__label">Usuarios</span>
                    <i class="treeview-indicator fa fa-angle-right"></i>
               </a>
               <ul class="treeview-menu">
                    <li>
                         <a class="treeview-item" href="<?= base_url() ?>usuarios"><i class="icon fa fa-circle-chevron-right"></i>Usuarios</a>
                    </li>
                    <li>
                         <a class="treeview-item" href="<?= base_url() ?>roles" target="" rel="noopener"><i class="icon fa fa-circle-chevron-right"></i>Roles</a>
                    </li>
                    <li>
                         <a class="treeview-item" href="<?= base_url() ?>permisos" target="" rel="noopener"><i class="icon fa fa-circle-chevron-right"></i>Permisos</a>
                    </li>
               </ul>
          </li>
     </ul>
</aside>