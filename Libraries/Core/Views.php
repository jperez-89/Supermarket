<?php

class Views
{
     // Funcion para obtener obtener las vistas
     public function getViews($controller, $view, $data="")
     {
          // // Obtener la clase
          $controller = get_class($controller);

          // Validar que exista la vista
          if ($controller == 'home') {
               // Muestra la pagina principal del controlador
               $view = Views . $view . ".php";
          } else {
               // Sino muetsra la vista que necesita el usuario
               $view = Views . $controller . "/" . $view . ".php";
               // echo " - ".$view." - ";
          }
          // Requerir la vista
          require_once($view);
     }
}
