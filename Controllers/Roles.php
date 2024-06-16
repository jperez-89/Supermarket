<?php

class  Roles extends Controllers
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

     public function Roles()
     {
          $data['page_title'] = "Supermarket - Roles";
          $data['page_name'] = "Roles de usuario";
          $data['page_functions'] = 'js/function_Roles.js';

          // Hacemos el enlace a la vista
          $this->views->getViews($this, 'roles', $data);
     }

     public function getRoles()
     {
          $arrdatos = $this->model->selectRoles();

          for ($i = 0; $i < count($arrdatos); $i++) {
               if ($arrdatos[$i]['status'] == 1) {
                    // ESTADO
                    $arrdatos[$i]['status'] = '<span class="badge badge-success">Activo</span>';

                    // ACCIONES
                    $arrdatos[$i]['options'] = '<div class="p-0 m-0">
                                             <button onclick="fntEditRol(' . $arrdatos[$i]['Id'] . ')" class="btn btn-primary2">
                                                  <i class="fas fa-pencil-alt"></i>
                                             </button>
                                             <button onclick="fntDeleteRol(' . $arrdatos[$i]['Id'] . ')" class="btn btn-danger2">
                                                  <i class="fas fa-trash"></i>
                                             </button>
                                        </div>';
               } else {
                    // ESTADO
                    $arrdatos[$i]['status'] = '<span class="badge badge-danger">Inactivo</span>';

                    // ACCIONES
                    $arrdatos[$i]['options'] = '<div class="p-0 m-0">
                                             <button onclick="fntEnableRol(' . $arrdatos[$i]['Id'] . ')" class="btn btn-success2">
                                                  <i class="fas fa-sync-alt"></i>
                                             </button>
                                             <button idUser="' . $arrdatos[$i]['Id'] . '"disabled=true class="btnDeleteUser btn btn-danger2">
                                                  <i class="fas fa-trash"></i>
                                             </button>
                                        </div>';
               }
          }
          echo json_encode($arrdatos, JSON_UNESCAPED_UNICODE);
          die();
     }

     public function getRol(int $idRol)
     {
          $idRol = intval(strClean($idRol));
          if ($idRol > 0) {
               $arrdatos = $this->model->selectRol($idRol);
               if (empty($arrdatos)) {
                    $arrResponse = array('status' => false, 'msg' => 'Datos no encontrados');
               } else {
                    $arrResponse = array('status' => true, 'data' => $arrdatos);
               }
               echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
          }
          die();
     }

     public function setRol()
     {
          $idRol = intval($_POST['idRol']);
          $nombreRol = strClean($_POST['txtNombreRol']);
          $DescripcionRol = strClean($_POST['txtDescripcionRol']);

          if ($idRol == 0) {
               $request_Producto = $this->model->insertRol($nombreRol, $DescripcionRol);
               $option = 1;
          } else {
               $request_Producto = $this->model->updateRol($idRol, $nombreRol, $DescripcionRol);
               $option = 2;
          }

          if ($request_Producto > 0) {
               if ($option == 1) {
                    $arrResponse = array('status' => true, 'msg' => 'Datos guardados.');
               } else {
                    $arrResponse = array('status' => true, 'msg' => 'Datos actualizados.');
               }
          } elseif ($request_Producto == 'exist') {
               $arrResponse = array('status' => false, 'msg' => 'Atencion! El rol ya existe.');
          } else {
               $arrResponse = array('status' => false, 'msg' => 'No es posible almacenar los datos.');
          }
          echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
          die();
     }

     public function deleteRol()
     {
          $id = intval($_POST['id']);
          $resquestDelete = $this->model->deleteRol($id);

          if ($resquestDelete == 'ok') {
               $arrResponse = array('status' => true, 'msg' => 'Rol deshabilitado.');
          } elseif ($resquestDelete == 'exist') {
               $arrResponse = array('status' => false, 'msg' => 'No es posible deshabilitar el Rol.');
          } else {
               $arrResponse = array('status' => false, 'msg' => 'No es posible eliminar los datos.');
          }
          echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
          die();
     }

     public function enableRol()
     {
          $id = intval($_POST['id']);
          $request = $this->model->enableRol($id);

          if ($request == 'ok') {
               $arrResponse = array('status' => true, 'msg' => 'Rol habilitado.');
          } elseif ($request == 'exist') {
               $arrResponse = array('status' => false, 'msg' => 'No es posible habilitar el Rol.');
          } else {
               $arrResponse = array('status' => false, 'msg' => 'No es posible eliminar los datos.');
          }
          echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
          die();
     }

     public function getPermisos()
     {
          // Obtenemos todos los permisos del sistema
          $arrPermisos = $this->model->getPermisos();

          // Obtenemos los permisos actuales del usuario
          $idRol = intval($_POST['idRol']);
          $permiUsuario = $this->model->SelectPermisosUsuario($idRol);

          // Validamos si el usuario tiene permisos
          if (count($permiUsuario) > 0) {
               // Los agregamos en un array
               $valores = array();
               for ($i = 0; $i < count($permiUsuario); $i++) {
                    array_push($valores, $permiUsuario[$i]['idPermiso']);
               }

               // Validamos si el id de los permisos del sistema existen en el array creado anteriormente
               $html = "";
               for ($i = 0; $i < count($arrPermisos); $i++) {
                    $sw = in_array($arrPermisos[$i]["id"], $valores) ? 'checked' : '';

                    // Si existe creamos la lista con el checkbox marcado
                    $html .= '<li> <input type="checkbox" ' . $sw . ' name="permisos[]" value="' . $arrPermisos[$i]['id'] . '"> ' . $arrPermisos[$i]['nombre'] . ' </li>';
               }
          }
          // Si el usuario no tiene permisos mostramos todos los permisos
          else {
               $html = "<div class='row'>";
               for ($i = 0; $i < count($arrPermisos); $i++) {
                    $html .= ' <div class="col-md-3"> <li> <input type="checkbox" name="permisos[]" value="' . $arrPermisos[$i]['id'] . '"> ' . $arrPermisos[$i]['nombre'] . ' </li></div>';
               }
               $html .= '</div>';
          }

          $arrResponse = array('status' => true, 'html' => $html);

          echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
          die();
     }
}
