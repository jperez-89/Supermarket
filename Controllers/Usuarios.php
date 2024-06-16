<?php

class  Usuarios extends Controllers
{
     public function __construct()
     {
          session_start();
          if (!isset($_SESSION['login'])) {
               header('Location: ' . base_url() . 'login');
          }

          // Ejecutar los metodos del Controllers
          parent::__construct();
     }

     public function Usuarios()
     {
          $data['page_title'] = "Tienda Virtual - Usuarios";
          $data['page_name'] = "Usuarios";
          $data['page_functions'] = 'js/function_Usuarios.js';

          // Hacemos el enlace a la vista
          $this->views->getViews($this, 'usuarios', $data);
     }

     public function getCantUsers()
     {
          $arrdatos = $this->model->selectCantUsers();

          echo json_encode($arrdatos, JSON_UNESCAPED_UNICODE);
          die();
     }

     public function getUsers()
     {
          $arrdatos = $this->model->selectUsers();

          for ($i = 0; $i < count($arrdatos); $i++) {
               if ($arrdatos[$i]['status'] == 1 && $arrdatos[$i]['idRol'] == 1) {
                    // ESTADO
                    $arrdatos[$i]['status'] = '<div class=""> <span class="badge badge-success">Activo</span> </div> ';

                    // ACCIONES
                    $arrdatos[$i]['options'] = '<div class="">
                                             <button onclick="fntEditUser(' . $arrdatos[$i]['id'] . ')" class="btn btn-primary2">
                                                  <i class="fas fa-pencil-alt"></i>
                                             </button>
                                             <button disabled onclick="fntDeleteUser(' . $arrdatos[$i]['id'] . ')" class="btn btn-danger2">
                                                  <i class="fas fa-trash"></i>
                                             </button>
                                        </div>';
               } else if ($arrdatos[$i]['status'] == 1) {
                    // ESTADO
                    $arrdatos[$i]['status'] = '<div class=""> <span class="badge badge-success">Activo</span> </div> ';

                    // ACCIONES
                    $arrdatos[$i]['options'] = '<div class="">
                                             <button onclick="fntEditUser(' . $arrdatos[$i]['id'] . ')" class="btn btn-primary2">
                                                  <i class="fas fa-pencil-alt"></i>
                                             </button>
                                             <button disabled onclick="fntDeleteUser(' . $arrdatos[$i]['id'] . ')" class="btn btn-danger2">
                                                  <i class="fas fa-trash"></i>
                                             </button>
                                        </div>';
               } else {
                    // ESTADO
                    $arrdatos[$i]['status'] = '<div class=""> <span class="badge badge-danger">Inactivo</span> </div>';

                    // ACCIONES
                    $arrdatos[$i]['options'] = '<div class="">
                                             <button onclick="fntEnableUser(' . $arrdatos[$i]['id'] . ')" class="btn btn-success2">
                                                  <i class="fas fa-sync-alt"></i>
                                             </button>
                                             <button idUser="' . $arrdatos[$i]['id'] . '"disabled=true class="btnDeleteUser btn btn-danger2">
                                                  <i class="fas fa-trash"></i>
                                             </button>
                                        </div>';
               }
          }
          echo json_encode($arrdatos, JSON_UNESCAPED_UNICODE);
          die();
     }

     public function getUser(int $id)
     {
          $id = intval(strClean($id));
          if ($id > 0) {
               $arrdatos = $this->model->selectUser($id);
               if (empty($arrdatos)) {
                    $arrResponse = array('status' => false, 'msg' => 'Datos no encontrados');
               } else {
                    $arrResponse = array('status' => true, 'data' => $arrdatos);
               }
               echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
          }
          die();
     }

     public function getRoles()
     {
          $arrdatos = $this->model->selecRoles();
          if (empty($arrdatos)) {
               $arrdatos = array('status' => false, 'msg' => 'Datos no encontrados');
          } else {
               $arrdatos = array('status' => true, 'data' => $arrdatos);
          }
          echo json_encode($arrdatos, JSON_UNESCAPED_UNICODE);
          die();
     }

     public function setUser()
     {
          try {
               $idUsuario = intval($_POST['idUsuario']);
               $txtIdentificacion = strClean($_POST['txtIdentificacion']);
               $txtNombre = strClean($_POST['txtNombre']);
               $txtApellidos = strClean($_POST['txtApellidos']);
               $txtTelefono = strClean($_POST['txtTelefono']);
               $txtEmail = strClean($_POST['txtEmail']);
               $txtUsuario = strClean($_POST['txtUsuario']);
               $txtContra = strClean($_POST['txtContra']);
               $selecRol = intval($_POST['selecRol']);

               if ($idUsuario == 0) {
                    $request_Cliente = $this->model->insertUser($txtIdentificacion, $txtNombre, $txtApellidos, $txtTelefono, $txtEmail, $txtUsuario, $txtContra, $selecRol);
                    $option = 1;
               } else {
                    $request_Cliente = $this->model->updateCliente($idUsuario, $txtNombre, $txtApellidos, $txtTelefono, $txtEmail, $txtUsuario, $txtContra, $selecRol);
                    $option = 2;
               }

               if ($request_Cliente > 0) {
                    if ($option == 1) {
                         $arrResponse = array('status' => true, 'msg' => 'Datos guardados.');
                    } else {
                         $arrResponse = array('status' => true, 'msg' => 'Datos actualizados.');
                    }
               } elseif ($request_Cliente == 'exist') {
                    $arrResponse = array('status' => false, 'msg' => 'Atencion! El producto ya existe.');
               } else {
                    $arrResponse = array('status' => false, 'msg' => 'No es posible almacenar los datos.');
               }

               echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
               die();
          } catch (Throwable $th) {
               throw $th;
          }
     }

     public function deleteUser()
     {
          $id = intval($_POST['id']);
          if ($id == 11) {
               $arrResponse = array('status' => false, 'msg' => 'Usuario Administrador del sistema, no se puede eliminar');
          } else {
               $request = $this->model->deleteUser($id);

               if ($request == 'ok') {
                    $arrResponse = array('status' => true, 'msg' => 'Usuario eliminado');
               } elseif ($request == 'exist') {
                    $arrResponse = array('status' => false, 'msg' => 'No es posible eliminar el Usuario.');
               } else {
                    $arrResponse = array('status' => false, 'msg' => 'No es posible eliminar los datos.');
               }
          }
          echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
          die();
     }

     public function enableUser()
     {
          $id = intval($_POST['id']);
          $request = $this->model->enableUser($id);

          if ($request == 'ok') {
               $arrResponse = array('status' => true, 'msg' => 'Usuario habilitado.');
          } elseif ($request == 'exist') {
               $arrResponse = array('status' => false, 'msg' => 'No es posible habilitar el Usuario.');
          } else {
               $arrResponse = array('status' => false, 'msg' => 'No es posible eliminar los datos.');
          }
          echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
          die();
     }
}
