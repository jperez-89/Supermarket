<?php

class Permisos extends Controllers
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

    public function Permisos()
    {
        $data['page_title'] = "Supermarket - Permisos";
        $data['page_name'] = "Permisos de acceso";
        $data['page_functions'] = 'js/function_Permisos.js';

        // Hacemos el enlace a la vista
        $this->views->getViews($this, 'permisos', $data);
    }

    public function getPermisos()
    {
        $arrdatos = PermisosModel::selectPermisos();

        for ($i = 0; $i < count($arrdatos); $i++) {

            if ($arrdatos[$i]['estado'] == 1) {
                $arrdatos[$i]['estado'] = '<span class="badge badge-success">Activo</span>';

                $arrdatos[$i]['options'] = '<div class="flex-center">
                                             <button class="btn btn-primary2 editPermiso">
                                                  <i class="fas fa-pencil-alt"></i>
                                             </button>
                                             <button class="btn btn-danger2 deletePermiso">
                                                  <i class="fas fa-trash"></i>
                                             </button> </div>';
            } else {
                $arrdatos[$i]['estado'] = ' <span class="badge badge-danger">Inactivo</span>';

                $arrdatos[$i]['options'] = '<div class="flex-center">
                                             <button class="btn btn-success2 enablePermiso">
                                                  <i class="fas fa-sync-alt"></i>
                                             </button>
                                             <button disabled class="btn btn-secondary2 deletePermiso">
                                                  <i class="fas fa-trash"></i>
                                             </button> </div>';
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

    public function setPermiso()
    {
        $idPermiso = intval($_POST['idPermiso']);
        $nombrePermiso = strClean($_POST['nombrePermiso']);

        if ($idPermiso == 0) {
            $request = PermisosModel::insertPermiso($nombrePermiso);
            $option = 1;
        } else {
            $request = PermisosModel::updatePermiso($idPermiso, $nombrePermiso);
            $option = 2;
        }

        if ($request > 0) {
            if ($option == 1) {
                $arrResponse = array('status' => true, 'msg' => 'Datos guardados.');
            } else {
                $arrResponse = array('status' => true, 'msg' => 'Datos actualizados.');
            }
        } elseif ($request == 'no_exist') {
            $arrResponse = array('status' => false, 'msg' => 'Atencion! El permiso no existe.');
        } else {
            $arrResponse = array('status' => false, 'msg' => 'No es posible almacenar los datos.');
        }

        echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function deletePermiso()
    {
        $idPermiso = intval($_POST['idPermiso']);
        $request = PermisosModel::deletePermiso($idPermiso);

        if ($request > 0) {
            $arrResponse = array('status' => true, 'msg' => 'Permiso deshabilitado.');
        } else if ($request == 'no_exist') {
            $arrResponse = array('status' => false, 'msg' => 'Permiso no existe.');
        } else {
            $arrResponse = array('status' => false, 'msg' => 'No es posible eliminar los datos.' . $request);
        }

        echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function enablePermiso()
    {
        $idPermiso = intval($_POST['idPermiso']);
        $request = PermisosModel::enablePermiso($idPermiso);

        if ($request > 0) {
            $arrResponse = array('status' => true, 'msg' => 'Permiso habilitado.');
        } else if ($request == 'no_exist') {
            $arrResponse = array('status' => false, 'msg' => 'Permiso no existe.');
        } else {
            $arrResponse = array('status' => false, 'msg' => 'No es posible eliminar los datos.' . $request);
        }

        echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        die();
    }
}
