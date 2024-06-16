<?php

class ClientesModel extends Crud
{
     public $idCliente, $identificacionCliente, $nombreCliente, $telefonoCliente, $emailCliente, $idDistrito, $direccionCliente, $actividadCliente, $regimenCliente, $estadoHacienda;

     public function __construct()
     {
          parent::__construct();
     }

     public function selecProvincias()
     {
          $sql = "SELECT * FROM provincia";
          $resquest = $this->get_AllRegister($sql);
          return $resquest;
     }

     public function selecRegimen()
     {
          $sql = "SELECT id, codigo, regimen FROM regimen";
          $resquest = $this->get_AllRegister($sql);
          return $resquest;
     }

     public function selecCanton(int $idProvincia)
     {
          $sql = "SELECT * FROM Canton WHERE idProvincia = $idProvincia";
          $resquest = $this->get_AllRegister($sql);
          return $resquest;
     }

     public function selecDistrito(int $idCanton)
     {
          $sql = "SELECT * FROM distrito WHERE idCanton = $idCanton";
          $resquest = $this->get_AllRegister($sql);
          return $resquest;
     }

     public function selectClientes()
     {
          $sql = "SELECT cli.Id, cli.Identificacion, cli.Nombre, cli.Telefono, cli.Email, LCASE(CONCAT(pro.NombreProvincia, ', ', can.NombreCanton, ', ', dis.nombreDistrito, ', ', cli.Direccion)) as Direccion, cli.Actividad, re.regimen, cli.estadoHacienda, cli.Status 
          FROM cliente as cli 
          INNER JOIN distrito as dis on dis.Id = cli.idDistrito 
          INNER JOIN canton as can on can.Id = dis.idCanton 
          INNER JOIN provincia as pro on pro.Id = can.IdProvincia
          INNER JOIN regimen AS re ON re.id = cli.Regimen";
          $resquest = $this->get_AllRegister($sql);
          return $resquest;
     }

     public function selectCliente(int $idCliente)
     {
          $this->idCliente = $idCliente;
          $sql = "SELECT cli.Id, cli.Identificacion, cli.Nombre, cli.Telefono, cli.Email, pro.Id as idProvincia, can.Id as idCanton, dis.Id as idDistrito, cli.Direccion, cli.Actividad, re.id AS idRegimen, cli.estadoHacienda 
          FROM cliente as cli 
          INNER JOIN distrito as dis on dis.Id = cli.idDistrito 
          INNER JOIN canton as can on can.Id = dis.idCanton 
          INNER JOIN provincia as pro on pro.Id = can.IdProvincia
          INNER JOIN regimen AS re ON re.id = cli.Regimen
          WHERE cli.Id = $this->idCliente OR cli.Identificacion = $this->idCliente";
          $resquest = $this->get_OneRegister($sql);
          return $resquest;
     }

     public function selectCantClients()
     {
          $sql = "SELECT count(id) as Cantidad FROM cliente";
          $resquest = $this->get_CountRegister($sql);
          return $resquest;
     }

     public function insertCliente(string $identificacionCliente, string $nombreCliente, string $telefonoCliente, string $emailCliente, int $idDistrito, string $direccionCliente, string $actividadCliente, int $regimenCliente, string $estadoHacienda)
     {
          $this->identificacionCliente = $identificacionCliente;
          $this->nombreCliente = $nombreCliente;
          $this->telefonoCliente = $telefonoCliente;
          $this->emailCliente = $emailCliente;
          $this->idDistrito = $idDistrito;
          $this->direccionCliente = $direccionCliente;
          $this->actividadCliente = $actividadCliente;
          $this->regimenCliente = $regimenCliente;
          $this->estadoHacienda = $estadoHacienda;

          // Validamos si existe el producto
          $sql = "SELECT Id FROM cliente WHERE Identificacion = '$this->identificacionCliente'";
          $request = $this->get_OneRegister($sql);

          if (empty($request)) {
               $query_insert = "INSERT INTO cliente (Identificacion, Nombre, Telefono, Email, idDistrito, Direccion, Actividad, Regimen, estadoHacienda, Status) VALUES(?,?,?,?,?,?,?,?,?,?)";

               $arrData = array($this->identificacionCliente, $this->nombreCliente, $this->telefonoCliente, $this->emailCliente, $this->idDistrito, $this->direccionCliente, $this->actividadCliente, $this->regimenCliente, $this->estadoHacienda, 1);

               $return = $this->Insert_Register($query_insert, $arrData);
          } else {
               $return = 0;
          }
          return $return;
     }

     public function updateCliente(int $idCliente, string $nombreCliente, string $telefonoCliente, string $emailCliente, int $idDistrito, string $direccionCliente, string $actividadCliente, int $regimenCliente, string $estadoHacienda)
     {
          $this->idCliente = $idCliente;
          $this->nombreCliente = $nombreCliente;
          $this->telefonoCliente = $telefonoCliente;
          $this->emailCliente = $emailCliente;
          $this->idDistrito = $idDistrito;
          $this->direccionCliente = $direccionCliente;
          $this->actividadCliente = $actividadCliente;
          $this->regimenCliente = $regimenCliente;
          $this->estadoHacienda = $estadoHacienda;

          // Validamos si existe el producto
          $sql = "SELECT * FROM cliente WHERE Id = $this->idCliente";
          $resquest = $this->get_AllRegister($sql);

          if (!empty($resquest)) {
               $query_update = "UPDATE cliente SET Nombre = ?, Telefono = ?, Email = ?, idDistrito = ?, Direccion = ?, Actividad = ?, Regimen = ?, estadoHacienda = ? WHERE Id = $this->idCliente";

               $arrData = array($this->nombreCliente, $this->telefonoCliente, $this->emailCliente, $this->idDistrito, $this->direccionCliente, $this->actividadCliente, $this->regimenCliente, $this->estadoHacienda);

               $resquest = $this->update_Register($query_update, $arrData);
          } else {
               $resquest = 0;
          }
          return $resquest;
     }

     public function deleteCliente(int $idCliente)
     {
          $this->idCliente = $idCliente;
          $sql = "SELECT Id FROM cliente WHERE Id = $this->idCliente";
          $resquest = $this->get_OneRegister($sql);

          if (!empty($resquest)) {
               $sql = "UPDATE cliente SET Status = ? WHERE Id = $this->idCliente";
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

     public function enableCliente(int $idCliente)
     {
          $this->idCliente = $idCliente;
          $sql = "SELECT Id FROM cliente WHERE Id = $this->idCliente";
          $resquest = $this->get_OneRegister($sql);

          if (!empty($resquest)) {
               $sql = "UPDATE cliente SET Status = ? WHERE Id = $this->idCliente";
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
}
