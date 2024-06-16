<?php

class CreditosModel extends Crud
{
    public function __construct()
    {
        parent::__construct();
    }

    public static function insertCredito(string $idCliente, int $montoCredito)
    {
        $crud = new Crud();

        $sql = "SELECT idCliente FROM credito WHERE idCliente = $idCliente";
        $request = $crud->get_OneRegister($sql);

        if (empty($request)) {
            $query_insert = "INSERT INTO credito (idCliente, montoCredito, estado) VALUES(?,?,?)";
            $arrData = array($idCliente, $montoCredito, 1);

            $request = $crud->Insert_Register($query_insert, $arrData);
        } else {
            $request = 0;
        }

        return  $request;
    }

    public static function updateCredito(int $idCredito, int $montoCredito)
    {
        $crud = new Crud();

        $sql = "UPDATE credito SET montoCredito = ? WHERE id =  $idCredito";
        $arrData = array($montoCredito);

        $request = $crud->update_Register($sql, $arrData);

        return $request;
    }

    public static function selectCreditos()
    {
        $crud = new Crud();

        $sql = "SELECT cre.id, cli.Id AS idCliente, cli.Identificacion, cli.Nombre, cli.Telefono, cre.montoCredito, (SELECT SUM(v.m_total) FROM venta v INNER JOIN cliente c ON c.id = v.idCliente WHERE v.idCliente = cre.idCliente AND estado = 0) AS pendiente_pago,  IF(ISNULL(cre.montoCredito - (SELECT SUM(v.m_total) FROM venta v INNER JOIN cliente c ON c.id = v.idCliente WHERE v.idCliente = cre.idCliente AND estado = 0)), cre.montoCredito, cre.montoCredito - (SELECT SUM(v.m_total) FROM venta v INNER JOIN cliente c ON c.id = v.idCliente WHERE v.idCliente = cre.idCliente AND estado = 0)) AS creditoActual, cre.estado 
        FROM credito as cre 
        INNER JOIN cliente as cli on cli.Id = cre.idCliente";

        $request = $crud->get_AllRegister($sql);

        return $request;
    }

    public static function deleteCredito(int $idCredito)
    {
        $crud = new Crud();

        $sql = "UPDATE credito SET estado = ? WHERE id = $idCredito";
        $arrData = array(0);
        $request = $crud->update_Register($sql, $arrData);

        return $request;
    }

    public static function enableCredito(int $idCredito)
    {
        $crud = new Crud();

        $sql = "UPDATE credito SET estado = ? WHERE id = $idCredito";
        $arrData = array(1);
        $request = $crud->update_Register($sql, $arrData);

        return $request;
    }

    public static function selectFacturasCreditoCliente(int $idCliente)
    {
        $crud = new Crud();

        $sql = "SELECT v.id, v.fecha, v.nfactura, td.id idTipoFactura, td.nombre AS tipo_factura, tp.nombre AS tipo_pago, v.m_total, v.estado, c.identificacion, c.nombre FROM venta v 
        INNER JOIN cliente c ON c.id = v.idCliente 
        INNER JOIN tipo_documento td ON td.id = v.tipo_factura
        INNER JOIN tipo_pago tp ON tp.id = v.tipo_pago
        WHERE v.idCliente = $idCliente AND v.estado = 0 AND tp.nombre = 'Crédito'";

        $request = $crud->get_AllRegister($sql);

        return $request;
    }

    public static function updateVenta(int $idVenta, int $tipoPago)
    {
        $crud = new Crud();

        $sql = "UPDATE venta SET tipo_pago = ?,  estado = ? WHERE id =  $idVenta";
        $arrData = array($tipoPago, 1);

        $request = $crud->update_Register($sql, $arrData);

        return $request;
    }

    public static function selectCreditoPendientePago()
    {
        $crud = new Crud();

        $sql = "SELECT cli.Nombre, cli.Telefono, cre.montoCredito, (SELECT SUM(v.m_total) AS pendiente_pago FROM venta v INNER JOIN cliente c ON c.id = v.idCliente WHERE v.idCliente = cre.idCliente AND estado = 0) AS pendiente_pago, IF(ISNULL(cre.montoCredito - (SELECT SUM(v.m_total) FROM venta v INNER JOIN cliente c ON c.id = v.idCliente WHERE v.idCliente = cre.idCliente AND estado = 0)), cre.montoCredito, cre.montoCredito - (SELECT SUM(v.m_total) FROM venta v INNER JOIN cliente c ON c.id = v.idCliente WHERE v.idCliente = cre.idCliente AND estado = 0)) AS creditoActual, cre.estado FROM credito as cre INNER JOIN cliente as cli on cli.Id = cre.idCliente WHERE (SELECT SUM(v.m_total) AS pendiente_pago FROM venta v INNER JOIN cliente c ON c.id = v.idCliente WHERE v.idCliente = cre.idCliente AND estado = 0) > 0;";

        $request = $crud->get_AllRegister($sql);

        return $request;
    }
}
