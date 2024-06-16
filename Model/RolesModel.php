<?php

class RolesModel extends Crud
{
     public $idRol, $id;
     public $nombre;
     public $descripcion;
     public $status, $nombreRol;

     public function __construct()
     {
          parent::__construct();
     }

     public function selectRoles()
     {
          $sql = "SELECT * FROM rol";
          $resquest = $this->get_AllRegister($sql);
          return $resquest;
     }

     public function selectRol(int $idRol)
     {
          $this->idRol = $idRol;
          $sql = "SELECT * FROM rol WHERE id = $this->idRol";
          $resquest = $this->get_OneRegister($sql);
          return $resquest;
     }

     public function insertRol(string $nombre, string $descripcion)
     {
          $return = "";
          $this->nombre = $nombre;
          $this->descripcion = $descripcion;

          // Validamos si existe el producto
          $sql = "SELECT * FROM rol WHERE nombreRol = '{$this->nombre}'";
          $resquest = $this->get_AllRegister($sql);

          if (empty($resquest)) {
               $query_insert = "INSERT INTO rol(nombreRol, descripcion, status) VALUES(?,?,?)";
               $arrData = array($this->nombre, $this->descripcion, 1);
               $resquest_insert = $this->Insert_Register($query_insert, $arrData);
               $return = $resquest_insert;
          } else {
               $return = "exist";
          }
          return $return;
     }

     public function updateRol(int $idRol, string $nombreRol, string $descripcion)
     {
          $this->idRol = $idRol;
          $this->nombreRol = $nombreRol;
          $this->descripcion = $descripcion;

          $sql = "SELECT * FROM rol WHERE nombreRol = '$this->nombreRol' AND Id != $this->idRol";
          $resquest = $this->get_AllRegister($sql);

          if (empty($resquest)) {
               $sql = "UPDATE rol SET nombreRol = ?, descripcion = ? WHERE Id = $this->idRol";
               $arrData = array($this->nombreRol, $this->descripcion);
               $resquest = $this->update_Register($sql, $arrData);
          } else {
               $resquest = "exist";
          }
          return $resquest;
     }

     public function deleteRol(int $id)
     {
          $this->id = $id;
          $sql = "SELECT * FROM rol WHERE Id = $this->id";
          $resquest = $this->get_OneRegister($sql);

          if (!empty($resquest)) {
               $sql = "UPDATE rol SET status = ? WHERE id = $this->id";
               $arrData = array(0);
               $resquest = $this->update_Register($sql, $arrData);
               if ($resquest) {
                    $resquest = "ok";
               } else {
                    $resquest = "error";
               }
          } else {
               $resquest = "exist";
          }
          return $resquest;
     }

     public function enableRol(int $id)
     {
          $this->id = $id;
          $sql = "SELECT * FROM rol WHERE Id = $this->id";
          $resquest = $this->get_OneRegister($sql);

          if (!empty($resquest)) {
               $sql = "UPDATE rol SET status = ? WHERE id = $this->id";
               $arrData = array(1);
               $resquest = $this->update_Register($sql, $arrData);
               if ($resquest) {
                    $resquest = "ok";
               } else {
                    $resquest = "error";
               }
          } else {
               $resquest = "exist";
          }
          return $resquest;
     }

     public function getPermisos()
     {
          $sql = "SELECT id, nombre, estado FROM permiso";
          $resquest = $this->get_AllRegister($sql);

          return $resquest;
     }

     public function SelectPermisosUsuario(int $idRol)
     {
          $this->idRol = $idRol;
          $sql = "SELECT pr.*, p.nombre FROM rol_permiso pr INNER JOIN permiso p ON p.id = pr.idPermiso WHERE pr.idRol = $this->idRol";

          $resquest = $this->get_AllRegister($sql);
          return $resquest;
     }
}
