<?php

class  home extends Controllers
{
     public function __construct()
     {
          // Ejecutar los metodos del Controllers
          parent::__construct();
     }

     public function home()
     {
          $data['page_title'] = "Pagina Princial";
          $data['page_functions'] = 'js/function_Home.js';

          // $data['page_name'] = "Home";
          // Hacemos el enlace a la vista
          $this->views->getViews($this, 'home', $data);
     }

     // public function insertar()
     // {
     //      $data = "Id de Usuario registrado: ". $this->model->Insert_User("Juan", 25);
     //      print_r($data);
     // }

     // public function Listar($id)
     // {
     //      $data = $this->model->Get_User($id);
     //      (!empty($data)) ? print_r($data) : print 'No hay datos para mostrar' ;
     //      // print_r($data);
     // }

     // public function actualizar()
     // {
     //      $data = $this->model->Update_User(1, "Roberto", 50);
     //      (!empty($data)) ? print_r($data) : print 'No hay datos para mostrar';
     // }
}
