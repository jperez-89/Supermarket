<?php

class LoginModel extends Crud
{
     public function __construct()
     {
          parent::__construct();
     }

     public static function loginUser(string $Username)
     {
          $crud = new Crud();

          $sql = "SELECT u.username, u.name, u.surnames, u.password, r.nombreRol, u.status FROM user u INNER JOIN rol r ON r.Id = u.idRol WHERE u.username = '$Username' OR u.dni = '$Username'";
          $request = $crud->get_OneRegister($sql);

          return $request;
     }

}