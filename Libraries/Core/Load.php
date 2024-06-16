<?php
// Cambia la primera letra del controlador a mayuscula
$controller = ucwords($controller);
// echo 'CONTROLER - '.$controller;

// Obtener URL de los archivos controladores
$UrlcontrollerFile = "Controllers/" . $controller . ".php";
// echo ' - URL CONTROLER - '.$UrlcontrollerFile;
// Valida que exista la URL
if (file_exists($UrlcontrollerFile)) {
     // Carga el archivo
     require_once($UrlcontrollerFile);

     $controller = new $controller();

     // Valida que el metodo exista
     if (method_exists($controller, $method)) {
          // Hace el llamado al metodo
          $controller->{$method}($params);
     } else {
          // Si no existe el metodo, muestra la pagina de Not Foud
          require_once("Controllers/Error.php");
     }
} else {
     // Si no existe el controlador, muestra la pagina de Not Foud
     require_once("Controllers/Error.php");
}
