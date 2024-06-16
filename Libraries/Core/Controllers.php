<?php
// Se actualiza a php v8.2, por ello se ocupa la linea 3, para permitir propiedades dinamicas $this->property
#[AllowDynamicProperties]

class Controllers
{
     public function __construct()
     {
          // Hacemos la instancia de las vistas
          $this->views = new Views();

          // Para iniciar el metodo automaticamente
          $this->loadModel();
     }
     // Obetemos los modelos de las clases
     public function loadModel()
     {
          $model = get_class($this) . "Model";
          $UrlModel = "Model/" . $model . ".php";

          // Validar si existe el archivo del modelo
          if (file_exists($UrlModel)) {
               require_once($UrlModel);

               $this->model = new $model();
          }
     }
}
