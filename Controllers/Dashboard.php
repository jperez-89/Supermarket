<?php

class  Dashboard extends Controllers
{
     public function __construct()
     {
          session_start();
          if (!isset($_SESSION['login'])) {
               header('Location: ' . base_url() . 'login');
          }

          parent::__construct();
     }

     public function Dashboard()
     {
          $data['page_title'] = "Supermarket - Dashboard";
          $data['page_name'] = "Dashboard";
          $data['page_functions'] = 'js/function_Admin.js';
          // Hacemos el enlace a la vista
          $this->views->getViews($this, 'dashboard', $data);
     }
}