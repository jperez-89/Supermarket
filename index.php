<?php
// Obtener los archivos de configuracion inicial
require_once("Config/Config.php");
// Va despues de Config.php por que necesita de unas variables
require_once("Helpers/Helpers.php");

// Define la URL principal (raiz) del proyecto o si se hace llamado a un controlador y envio de parametros
$url = !empty($_GET['url']) ? $_GET['url'] : 'login/login'; // 'home/home';

// Crea un arreglo extrayendo los parametros de la URL
$arrUrl = explode("/", $url);

// http://localhost/tiendavirtual/ controlador [0] / metodo [1] / parametros [2]...
$controller = $arrUrl[0];
$method = $arrUrl[0];
$params = "";

// Obtenemos el nombre del metodo solicitado por el usuario
if (!empty($arrUrl[1])) {
     if ($arrUrl[1] != "") {
          $method = $arrUrl[1];
     }
}

// En el for obtenemos los parametros enviados por la URL para realizar las diferentes operaciones
if (!empty($arrUrl[2])) {
     if ($arrUrl[2] != "") {
          for ($i = 2; $i < count($arrUrl); $i++) {
               // Concatenamos los parametros y separamos por una ,
               $params .= $arrUrl[$i] . ',';
          }
          // Elimina el ultimo caracter o sea la ,
          $params = trim($params, ',');
     }
}

// Hacemos llamado al AutoLoad para cargar los archivos
require_once("Libraries/Core/AutoLoad.php");

// Hacemos llamado al Load para validar que existan los controladores y metodos solicitado y cargarlos
require_once("Libraries/Core/Load.php");
