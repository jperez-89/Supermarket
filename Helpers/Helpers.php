<?php

// Retorna la direccion de la carpeta del proyecto
function base_url()
{
     return base;
}

function media()
{
     return base_url() . media;
}

function productosImg()
{
     return productosImg;
}

function facturas()
{
     return facturas;
}

function headerAdmin($data = "")
{
     require_once("Assets/includes/header_Admin.php");
}

function navBarAdmin($data = "")
{
     require_once("Assets/includes/navBar_Admin.php");
}

function footerAdmin($data = "")
{
     require_once("Assets/includes/footer_Admin.php");
}

function ShowModal(string $nameModal, $data = "")
{
     require_once("Assets/includes/Modals/{$nameModal}.php");
}

// Muestra informacion formateada
function priintData($data)
{
     $format = print_r('<pre>');
     $format .= print_r($data);
     $format .= print_r('</pre>');

     return $format;
}

function PrintArray($array)
{
     for ($i = 0; $i < count($array); $i++) {
          echo $i . ' - ' . $array[$i] . '<br />';
     }
}

// Evitar inyection
function strClean($cadena)
{
     $string = preg_replace(['/\s+/', '/^\s|\s$/'], [' ', ''], $cadena);
     $string = trim($string); //Elimina espacios en blanco
     $string = stripslashes($string); // Elimina las \ invertidas
     $string = str_ireplace("<script>", "", $string);
     $string = str_ireplace("</script>", "", $string);
     $string = str_ireplace("<script src>", "", $string);
     $string = str_ireplace("<script type=>", "", $string);
     $string = str_ireplace("SELECT * FROM", "", $string);
     $string = str_ireplace("DELETE FROM", "", $string);
     $string = str_ireplace("INSERT INTO", "", $string);
     $string = str_ireplace("SELECT COUNT(*) FROM", "", $string);
     $string = str_ireplace("DROP TABLE", "", $string);
     $string = str_ireplace("DROP DATABSE", "", $string);
     $string = str_ireplace("OR '1'='1'", "", $string);
     $string = str_ireplace('OR "1"="1"', "", $string);
     $string = str_ireplace("is NULL", "", $string);
     $string = str_ireplace("LIKE '", "", $string);
     $string = str_ireplace('LIKE "', "", $string);
     $string = str_ireplace("_ _", "", $string);
     $string = str_ireplace("^", "", $string);
     $string = str_ireplace("[", "", $string);
     $string = str_ireplace("]", "", $string);
     $string = str_ireplace("==", "", $string);
     $string = str_ireplace("OR 'a'='a'", "", $string);
     return $string;
}

// Generador de password aleatorio
function passGenerator($length = 10)
{
     $pass = "";
     $cadena = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890*@#$%";
     $longitudCadena = strlen($cadena);

     for ($i = 0; $i < $length; $i++) {
          $pos = rand(0, $longitudCadena - 1);
          $pass .= substr($cadena, $pos, 1);
     }
     return $pass;
}

// Generador de Token
function Token()
{
     $r1 = bin2hex(random_bytes(5));
     $r3 = bin2hex(random_bytes(5));
     $r2 = bin2hex(random_bytes(5));
     $r4 = bin2hex(random_bytes(5));

     $token = $r1 . '-' . $r2 . '-' . $r3 . '-' . $r4;
     return $token;
}

// formatear cantidades
function formatMoney($cantidad)
{
     $cantidad = number_format($cantidad, 2, deci, millar);
     return $cantidad;
}
