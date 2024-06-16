<?php

class errors extends Controllers
{
     public function __construct()
     {
          // Ejecutar los metodos del Controllers
          parent::__construct();
     }

     public function notFound()
     {
          $data['page_title'] = "Tienda Virtual - Error";
          $data['page_name'] = "Error 404";
          // Hacemos el enlace a la vista
          $this->views->getViews($this, 'error', $data);
     }
}

$notFoud = new Errors();
$notFoud->notFound();