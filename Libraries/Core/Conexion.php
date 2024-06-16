<?php

class Conexion
{
     private $conect;

     public function __construct()
     {
          $connetionString = "mysql:host=" . host . "dbname=" . dbName . charset;

          try {
               $this->conect = new PDO($connetionString, user, password);
               $this->conect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
               // return $this->conect;
               // echo "Conexión exitosa";
          } catch (PDOException $ex) {
               $this->conect = "Error de conexión";
               echo 'ERROR: ' . $ex->getMessage();
          }
     }

     public function getConection()
     {
          return $this->conect;
     }

     public function closeConection()
     {
          $this->conect = null;
     }
}
