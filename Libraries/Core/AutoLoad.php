<?php
// VALIDA QUE LAS CLASES EXISTEN Y LAS CARGA AUTOMATICAMENTE
spl_autoload_register(function ($class) {
     if (file_exists(libs . 'Core/' . $class . ".php")) {
          require_once(libs . 'Core/' . $class . ".php");
     }
});
