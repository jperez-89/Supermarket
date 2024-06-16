<?php
class  Login extends Controllers
{
     public function __construct()
     {
          if (session_status() != PHP_SESSION_ACTIVE) {
               session_start();
          }

          if (isset($_SESSION['login'])) {
               header('Location: ' . base_url() . 'dashboard');
          }
          // Ejecutar los metodos del Controllers
          parent::__construct();
     }

     public function Login()
     {
          $data['page_title'] = "Supermarket - Login";
          $data['page_functions'] = "js/function_login.js";
          $data['page_name'] = "Supermarket";
          // Hacemos el enlace a la vista
          $this->views->getViews($this, 'Login', $data);
     }

     public function LoginUser()
     {
          if ($_POST) {
               if (empty($_POST['txtUsername']) || empty($_POST['txtPassword'])) {
                    $arrResponse = array('status' => false, 'msg' => 'Complete todos los campos');
               } else {
                    $user = strClean($_POST['txtUsername']);
                    $pass =  strClean($_POST['txtPassword']);

                    $request = LoginModel::loginUser($user);

                    if (!empty($request)) {
                         $verificarPassword = password_verify($pass, $request['password']);

                         if ($verificarPassword) {
                              if ($request['status']) {
                                   $_SESSION['name'] = $request['name'] . ' ' . $request['surnames'];
                                   $_SESSION['rol'] = $request['nombreRol'];
                                   $_SESSION['login'] = true;
                                   $arrResponse = array('status' => true, 'msg' => 'ok');
                              } else {
                                   $arrResponse = array('status' => false, 'msg' => 'Usuario inactivo, contacta al administrador al email jrwc1989@gmail.com');
                              }
                         } else {
                              $arrResponse = array('status' => false, 'msg' => 'Contraseña incorrecta');
                         }
                    } else {
                         $arrResponse = array('status' => false, 'msg' => 'Usuario incorrecto');
                    }
               }
               echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
          }
          die();
     }
}
