<?php

class PermisosModel extends Crud
{
    private static $crud;

    public function __construct()
    {
        parent::__construct();

        self::$crud = new Crud();
    }

    public static function selectPermisos()
    {
        $sql = "SELECT id, nombre, estado FROM permiso";
        $request = self::$crud->get_AllRegister($sql);

        return $request;
    }

    public static function insertPermiso(string $nombre)
    {
        $request = self::searchPermiso_Nombre($nombre);

        if (empty($request)) {
            $query_insert = "INSERT INTO permiso (nombre, estado) VALUES(?,?)";
            $arrData = array($nombre, 1);

            $return = self::$crud->Insert_Register($query_insert, $arrData);
        } else {
            $return = false;
        }
        return $return;
    }

    public static function searchPermiso_Id(int $idPermiso)
    {
        $sql = "SELECT id, nombre, estado FROM permiso WHERE id = $idPermiso";
        $request = self::$crud->get_OneRegister($sql);

        return $request;
    }

    public static function searchPermiso_Nombre($nombre)
    {
        $sql = "SELECT id, nombre, estado FROM permiso WHERE nombre COLLATE utf8mb4_spanish_ci = '$nombre'";
        $request = self::$crud->get_OneRegister($sql);

        return $request;
    }

    public static function updatePermiso(int $idPermiso, string $nombrePermiso)
    {
        $request = self::searchPermiso_Id($idPermiso);

        if (!empty($request)) {
            $sql = "UPDATE permiso SET nombre = ? WHERE id = ?";
            $arrData = array($nombrePermiso, $idPermiso);
            $request = self::$crud->update_Register($sql, $arrData);
        } else {
            $request = "no_exist";
        }

        return $request;
    }

    public static function deletePermiso(int $idPermiso)
    {
        try {
            $request = self::searchPermiso_Id($idPermiso);

            if (!empty($request)) {
                $sql = "UPDATE permiso SET estado = ? WHERE id = ?";
                $arrData = array(0, $idPermiso);

                $request = self::$crud->update_Register($sql, $arrData);
            } else {
                $request = "no_exist";
            }
        } catch (\Throwable $th) {
            $request = $th;
        }

        return $request;
    }

    public static function enablePermiso(int $idPermiso)
    {
        try {
            $request = self::searchPermiso_Id($idPermiso);

            if (!empty($request)) {
                $sql = "UPDATE permiso SET estado = ? WHERE id = ?";
                $arrData = array(1, $idPermiso);

                $request = self::$crud->update_Register($sql, $arrData);
            } else {
                $request = "no_exist";
            }
        } catch (\Throwable $th) {
            $request = $th;
        }

        return $request;
    }
}
