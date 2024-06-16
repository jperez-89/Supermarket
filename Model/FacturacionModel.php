<?php
require_once 'vendor/fpdf/fpdf.php';

class FacturacionModel extends Crud
{
     public $dato, $nameProduct, $nFactura, $tipoFactura, $tipoPago, $idCliente, $totalFactura, $codigo, $cantidad, $preUnitario, $subTotal, $iva, $total;

     public function __construct()
     {
          parent::__construct();
     }

     public static function selectCliente(string $dato, string $op)
     {
          $crud = new Crud();

          if ($op == 'i') {
               $sql = "SELECT cli.Id as id, cli.Identificacion
               FROM cliente as cli 
               INNER JOIN distrito as dis on dis.Id = cli.idDistrito 
               INNER JOIN canton as can on can.Id = dis.idCanton 
               INNER JOIN provincia as pro on pro.Id = can.IdProvincia 
               WHERE cli.Identificacion LIKE '$dato%' LIMIT 0, 2";
          } else if ($op == 'n') {
               $sql = "SELECT cli.Id as id, cli.Nombre
               FROM cliente as cli 
               INNER JOIN distrito as dis on dis.Id = cli.idDistrito 
               INNER JOIN canton as can on can.Id = dis.idCanton 
               INNER JOIN provincia as pro on pro.Id = can.IdProvincia 
               WHERE cli.Nombre LIKE '$dato%' LIMIT 0, 2";
          } else if ($op == 'data') {
               $sql = "SELECT cli.Id as id, cli.Identificacion, cli.Nombre, cli.Telefono, cli.Email, CONCAT(pro.NombreProvincia,', ', can.NombreCanton,', ', dis.nombreDistrito,', ', UPPER(cli.Direccion)) as Direccion, IF(ISNULL(cre.montoCredito - (SELECT SUM(v.m_total) FROM venta v INNER JOIN cliente c ON c.id = v.idCliente WHERE v.idCliente = cre.idCliente AND estado = 0)), cre.montoCredito, cre.montoCredito - (SELECT SUM(v.m_total) FROM venta v INNER JOIN cliente c ON c.id = v.idCliente WHERE v.idCliente = cre.idCliente AND estado = 0))  AS creditoActual, cre.estado
               FROM cliente as cli 
               INNER JOIN distrito as dis on dis.Id = cli.idDistrito 
               INNER JOIN canton as can on can.Id = dis.idCanton 
               INNER JOIN provincia as pro on pro.Id = can.IdProvincia 
               LEFT JOIN credito as cre on cre.idCliente = cli.Id
               WHERE cli.Id = $dato";
          }

          $request = $crud->get_AllRegister($sql);
          return $request;
     }

     public static function selectProducto(string $op, string $dato)
     {
          $crud = new Crud();

          if ($op == 'n') {
               $sql = "SELECT p.codigo, p.name FROM producto p INNER JOIN inventario i ON i.idProducto = p.id WHERE name LIKE '%$dato%' AND i.cantidad > 0 AND state = 1";
          } elseif ($op == 'data') {
               $sql = "SELECT p.codigo, p.name, p.price, i.cantidad, im.valor 
               FROM producto p 
               INNER JOIN inventario i ON i.idProducto = p.id 
               INNER JOIN impuesto im ON im.id = p.iva 
               WHERE p.codigo = $dato AND i.cantidad > 0 AND p.state = 1";
          }

          $request = $crud->get_AllRegister($sql);

          return $request;
     }

     public static function selectProductoByCode(string $code)
     {
          $crud = new Crud();
          $sql = "SELECT id, codigo, name FROM producto WHERE codigo = $code";

          $request = $crud->get_OneRegister($sql);

          return $request;
     }

     public function selectProducts()
     {
          $sql = "SELECT id, name FROM producto";
          $request = $this->get_AllRegister($sql);

          return $request;
     }

     public static function setEncaFactura(string $tipoFactura, int $tipoPago, int $idCliente, float $subTotal, float $iva, float $totalFactura)
     {
          $crud = new Crud();

          $idFactura = self::selectTipoDocumentoByCodigo($tipoFactura);

          $query_insert = "INSERT INTO venta (tipo_factura, tipo_pago, idCliente, m_subtotal, m_iva, m_total) VALUES(?,?,?,?,?,?)";
          $arrData = array($idFactura, $tipoPago, $idCliente, $subTotal, $iva, $totalFactura);

          $return = $crud->Insert_Register($query_insert, $arrData);

          return $return;
     }

     public static function setDetaFactura(string $idVenta, int $idProducto, float $cantidad, float $preUnitario, float $subTotal, float $iva, float $total)
     {
          $crud = new Crud();

          $sql = "SELECT id FROM venta WHERE id = '$idVenta'";
          $request = $crud->get_OneRegister($sql);

          if (!empty($request)) {
               $query_insert = "INSERT INTO venta_detalle (idFactura, idProducto, cantidad, preUnitario, subTotal, iva, total, estado) VALUES(?,?,?,?,?,?,?,?)";
               $arrData = array($idVenta, $idProducto, $cantidad, $preUnitario, $subTotal, $iva, $total, 1);

               $request = $crud->Insert_Register($query_insert, $arrData);
          } else {
               $request = 0;
          }

          return $request;
     }

     public static function setComprobante(int $idVenta, string $nComprobante,)
     {
          $crud = new Crud();

          $query_insert = "INSERT INTO comprobante_pago (idVenta, nComprobante, estado) VALUES(?,?,?)";
          $arrData = array($idVenta, $nComprobante, 1);

          $return = $crud->Insert_Register($query_insert, $arrData);

          return $return;
     }

     public static function setFacturaCredito(int $idVenta)
     {
          $crud = new Crud();

          $sql = "UPDATE venta SET estado = ? WHERE id = $idVenta";
          $arrData = array(0);

          $request = $crud->update_Register($sql, $arrData);

          return $request;
     }

     public static function updateNumeroFactura(int $idFactura, string $result)
     {
          $crud = new Crud();

          $sql = "UPDATE venta SET nfactura = ?, estado = ? WHERE id = $idFactura";
          $arrData = array($result, 1);

          $request = $crud->update_Register($sql, $arrData);

          return $request;
     }

     public static function selectFacturaById(int $idFactura)
     {
          $crud = new Crud();

          $sql = "SELECT v.id, td.codigo, c.Email FROM venta v INNER JOIN tipo_documento td ON td.id = v.tipo_factura INNER JOIN cliente c ON c.Id = v.idCliente WHERE v.id = $idFactura";
          $request = $crud->get_OneRegister($sql);

          return $request;
     }

     public static function insertNumeroVoucher(string $nVoucher, int $idVenta)
     {
          $crud = new Crud();

          $query_insert = "INSERT INTO voucher (n_voucher, idVenta) VALUES(?,?)";
          $arrData = array($nVoucher, $idVenta);

          $request = $crud->Insert_Register($query_insert, $arrData);

          return $request;
     }

     public static function selectLastIdVoucher()
     {
          $crud = new Crud();

          $sql = "SELECT MAX(id) AS idVoucher FROM voucher";
          $request = $crud->get_OneRegister($sql);

          return $request;
     }

     public static function insertNumeroFactura(string $nFactura, int $idVenta)
     {
          $crud = new Crud();

          $query_insert = "INSERT INTO factura_electronica (n_factura, idVenta) VALUES(?,?)";
          $arrData = array($nFactura, $idVenta);

          $request = $crud->Insert_Register($query_insert, $arrData);

          return $request;
     }

     public static function selectLastIdFactura()
     {
          $crud = new Crud();

          $sql = "SELECT MAX(id) AS idFactura FROM factura_electronica";
          $request = $crud->get_OneRegister($sql);

          return $request;
     }

     public static function insertNumeroTiquete(string $nTiquete, int $idVenta)
     {
          $crud = new Crud();

          $query_insert = "INSERT INTO tiquete_electronico (n_tiquete, idVenta) VALUES(?,?)";
          $arrData = array($nTiquete, $idVenta);

          $request = $crud->Insert_Register($query_insert, $arrData);

          return $request;
     }

     public static function selectLastIdTiquete()
     {
          $crud = new Crud();

          $sql = "SELECT MAX(id) AS idTiquete FROM tiquete_electronico";
          $request = $crud->get_OneRegister($sql);

          return $request;
     }

     public static function selectTipoDocumento()
     {
          $crud = new Crud();
          $sql = "SELECT codigo, nombre FROM tipo_documento";
          $request = $crud->get_AllRegister($sql);

          return $request;
     }

     public static function selectTipoDocumentoByCodigo(string $codigo)
     {
          $crud = new Crud();
          $sql = "SELECT id FROM tipo_documento WHERE codigo = $codigo";
          $request = $crud->get_OneRegister($sql);

          return $request['id'];
     }

     public static function selectTipoPago()
     {
          $crud = new Crud();
          $sql = "SELECT id, nombre, estado FROM tipo_pago";
          $request = $crud->get_AllRegister($sql);

          return $request;
     }

     public static function selectCantFacturas()
     {
          $crud = new Crud();

          $sql = "SELECT COUNT(id) AS Cantidad FROM venta";
          $request = $crud->get_CountRegister($sql);

          return $request;
     }

     // -------------------> Funciones Modulo Facturas <----------------------
     public static function selectFacturas()
     {
          $crud = new Crud();

          $sql = "SELECT v.id, v.fecha, v.nfactura, td.nombre AS tipo_factura, tp.nombre AS tipo_pago, v.m_total, v.estado, c.identificacion, c.nombre, c.Email FROM venta v
          INNER JOIN cliente c ON c.id = v.idCliente
          INNER JOIN tipo_documento td ON td.id = v.tipo_factura
          INNER JOIN tipo_pago tp ON tp.id = v.tipo_pago";
          $request = $crud->get_AllRegister($sql);

          return $request;
     }

     public static function selectDetalleFactura(int $idFactura)
     {
          $crud = new Crud();

          $sql = "SELECT p.name, vd.cantidad, vd.preUnitario, vd.subtotal, vd.iva, vd.total FROM venta_detalle vd INNER JOIN venta v ON v.id = vd.idFactura INNER JOIN producto p ON p.id = vd.idProducto WHERE v.id = $idFactura";
          $request = $crud->get_AllRegister($sql);

          return $request;
     }

     public static function generarPDF($idVenta, $pagaCon, $Vuelto)
     {
          $pdf = new FPDF('P', 'mm', array(80, 200));

          if ($pagaCon != 0) {
               $crud = new Crud();

               $sql = "SELECT c.Identificacion, c.Nombre AS NombreCliente, c.Email, c.Telefono, v.id, v.fecha, v.nfactura, UCASE(tp.nombre) AS tipo_pago, v.estado, td.nombre AS TipoDocumento, v.m_subtotal, v.m_iva, v.m_total FROM venta v INNER JOIN cliente c ON c.Id = v.idCliente INNER JOIN tipo_documento td ON td.id = v.tipo_factura INNER JOIN tipo_pago tp ON tp.id = v.tipo_pago WHERE v.id = $idVenta OR v.nfactura = '$idVenta'";

               $request = $crud->get_OneRegister($sql);

               $condicion = ($request['estado']) ? 'CANCELADO' : 'PENDIENTE';

               $sql = "SELECT p.name, vd.cantidad, vd.preUnitario, vd.subtotal, i.codigo, i.valor FROM venta_detalle vd INNER JOIN producto p ON p.id = vd.idProducto INNER JOIN venta v ON v.id = vd.idFactura INNER JOIN impuesto i ON i.id = p.iva WHERE v.id = " . $request['id'];

               $dFactura = $crud->get_AllRegister($sql);

               $pdf->AddPage();
               $pdf->SetMargins(1, 0, 0);
               $pdf->SetTitle("Factura " . $request['nfactura']);
               $pdf->SetFont('Arial', 'B', 9);
               $pdf->Cell(60, 5, 'SUPERMARKET - POS', 0, 1, 'C');

               $pdf->SetFont('Arial', '', 7);
               $pdf->Cell(30, 3, "IDENTIFICACION:", 0, 0, 'R');
               $pdf->Cell(15, 3, '603820149', 0, 0, 'L');
               $pdf->Cell(6, 3, 'TEL:', 0, 0, 'L');
               $pdf->Cell(15, 3, '+506 83182537', 0, 1, 'L');
               $pdf->Cell(30, 3, "EMAIL:", 0, 0, 'R');
               $pdf->Cell(20, 3, 'JRWC1989@GMAIL.COM', 0, 1, 'L');
               $pdf->Cell(75, 3, 'PITAHAYA, PUNTARENAS, DIAGONAL A LA IGLESIA CATOLICA', 0, 1, 'C');
               $pdf->Ln();

               $pdf->Cell(24, 4, mb_convert_encoding($request['TipoDocumento'] . ' v4.3', 'UTF-8'), 0, 1, 'L');
               $pdf->Cell(8, 4, "Clave", 0, 0, 'L');
               $pdf->Cell(24, 4, '506-DMA-603820149' . $request['nfactura'] . '-SCE-CS', 0, 1, 'L');
               $pdf->Cell(15, 4, "Consecutivo", 0, 0, 'L');
               $pdf->Cell(24, 4, $request['nfactura'], 0, 1, 'L');
               $pdf->Cell(8, 4, "Fecha", 0, 0, 'L');
               $pdf->Cell(2, 4, $request['fecha'], 0, 1, 'L');

               $pdf->SetFont('Arial', 'B', 7);
               $pdf->Cell(1, 3, "- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -", 0, 1, 'L');
               $pdf->Cell(40, 5, "Cliente", 0, 0, 'L');
               $pdf->Cell(16, 5, "Teléfono", 0, 0, 'L');
               $pdf->Cell(25, 5, "Correo", 0, 1, 'L');
               $pdf->SetFont('Arial', '', 7);
               $pdf->Cell(40, 3, mb_convert_encoding($request['NombreCliente'], "UTF-8"), 0, 0, 'L');
               $pdf->Cell(13, 3, mb_convert_encoding($request['Telefono'], "UTF-8"), 0, 0, 'L');
               $pdf->Cell(23, 3, mb_convert_encoding($request['Email'], "UTF-8"), 0, 1, 'L');

               $pdf->SetFont('Arial', 'B', 7);
               $pdf->Cell(1, 5, "- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -", 0, 1, 'L');
               $pdf->Cell(8, 3, 'Cant.', 0, 0, 'L');
               $pdf->Cell(42, 3, 'Detalle', 0, 0, 'C');
               $pdf->Cell(15, 3, 'Precio', 0, 0, 'L');
               $pdf->Cell(15, 3, 'Total', 0, 1, 'L');
               $pdf->SetFont('Arial', '', 7);
               for ($i = 0; $i < count($dFactura); $i++) {
                    $pdf->Cell(8, 5, number_format($dFactura[$i]['cantidad'], 2, '.', ','), 0, 0, 'L');
                    $pdf->Cell(42, 5, mb_convert_encoding($dFactura[$i]['name'], 'UTF-8', 'ISO-8859-1'), 0, 0, 'L');
                    $pdf->Cell(11, 5, number_format($dFactura[$i]['preUnitario'], 2, '.', ','), 0, 0, 'R');
                    $pdf->Cell(16, 5, number_format($dFactura[$i]['subtotal'], 2, '.', ',') . $dFactura[$i]['codigo'], 0, 1, 'R');
               }
               $pdf->Cell(1, 5, "- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -", 0, 0, 'L');

               $pdf->Ln();
               $pdf->SetFont('Arial', '', 8);
               $pdf->Cell(55, 4, 'Subtotal:', 0, 0, 'R');
               $pdf->Cell(22, 4, number_format($request['m_subtotal'], 2, '.', ','), 0, 1, 'R');

               $pdf->Cell(55, 4, 'IVA:', 0, 0, 'R');
               $pdf->Cell(22, 4, number_format($request['m_iva'], 2, '.', ','), 0, 1, 'R');

               $pdf->SetFont('Arial', 'B', 10);
               $pdf->Cell(55, 4, 'Total CRC:', 0, 0, 'R');
               $pdf->Cell(22, 4, number_format($request['m_total'], 2, '.', ','), 0, 1, 'R');
               $pdf->Ln();

               $pdf->SetFont('Arial', '', 7);
               $pdf->Cell(1, 3, "- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -", 0, 1, 'L');
               $pdf->Cell(22, 4, 'FORMA PAGO:', 0, 0, 'R');
               $pdf->Cell(20, 4, mb_convert_encoding($request['tipo_pago'], "UTF-8"), 0, 0, 'L');
               $pdf->Cell(16, 4, 'CONDICION:', 0, 0, 'L');
               $pdf->Cell(5, 4, mb_convert_encoding($condicion, "UTF-8"), 0, 1, 'L');
               $pdf->Cell(22, 4, 'PAGA CON:', 0, 0, 'R');
               $pdf->Cell(20, 4, mb_convert_encoding($pagaCon, "UTF-8"), 0, 0, 'L');
               $pdf->Cell(16, 4, 'VUELTO:', 0, 0, 'L');
               $pdf->Cell(5, 4, mb_convert_encoding($Vuelto, "UTF-8"), 0, 1, 'L');
               $pdf->Cell(1, 3, "- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -", 0, 1, 'L');

               $sql = "SELECT * FROM impuesto";
               $impuesto = $crud->get_AllRegister($sql);

               for ($i = 0; $i < count($impuesto); $i++) {
                    $pdf->Cell(15, 4, $impuesto[$i]['codigo'] . ': ' . $impuesto[$i]['valor'] . '%', 0, 0, 'C');
               }
               $pdf->Ln();
               $pdf->Cell(1, 3, "- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -", 0, 1, 'L');

               $pdf->SetFont('Arial', '', 8);
               $pdf->Cell(80, 5, mb_convert_encoding('*** GRACIAS POR SU VISITA ***', "UTF-8"), 0, 1, 'C');
               $pdf->Cell(80, 5, mb_convert_encoding('*** RESOLUCION DGT-R-033-2019 ***', "UTF-8"), 0, 1, 'C');

               if ($pdf->Output('assets/facturas/', 'factura-' . $request["nfactura"] . '.pdf', 'F')) {
                    $pdf->Output('assets/facturas/', 'factura-' . $request["nfactura"] . '.pdf', 'I');
               }
          } else {
               $crud = new Crud();

               $sql = "SELECT v.nfactura FROM venta v WHERE v.id = $idVenta OR v.nfactura = '$idVenta'";

               $request = $crud->get_OneRegister($sql);

               $pdf->Output('assets/facturas/', 'factura-' . $request["nfactura"] . '.pdf', 'S');
          }
     }

     public static function enviarFacturaPDF($idVenta)
     {
          $pdf = new FPDF('P', 'mm', array(80, 200));
          $crud = new Crud();

          $sql = "SELECT v.nfactura FROM venta v WHERE v.id = $idVenta OR v.nfactura = '$idVenta'";
          $request = $crud->get_OneRegister($sql);

          // $result = file_get_contents('assets/facturas/factura-' . $request["nfactura"] . '.pdf');
          $result = $pdf->Output('assets/facturas/', 'factura-' . $request["nfactura"] . '.pdf', 'S');

          return $result;
     }

     // -------------------> Funciones Modulo Dashboard <----------------------
     public static function selectFacturasEmitidas()
     {
          $crud = new Crud();

          $sql = "SELECT COUNT(v.id) AS totalFacturas, tp.nombre FROM `venta` v INNER JOIN tipo_documento tp ON tp.id = v.tipo_factura GROUP BY v.tipo_factura ORDER BY totalFacturas";
          $request = $crud->get_AllRegister($sql);

          return $request;
     }

     public static function selectFormaPago(string $fchInicio, string $fchFin)
     {
          $crud = new Crud();

          if ($fchInicio == '' && $fchFin == '') {
               $sql = "SELECT COUNT(v.id) AS totalFP, tp.nombre FROM `venta` v INNER JOIN tipo_pago tp ON tp.id = v.tipo_pago GROUP BY v.tipo_pago";
          } else {
               $sql = "SELECT COUNT(v.id) AS totalFP, tp.nombre FROM `venta` v INNER JOIN tipo_pago tp ON tp.id = v.tipo_pago WHERE v.fecha BETWEEN $fchInicio AND $fchFin GROUP BY v.tipo_pago";
          }

          $request = $crud->get_AllRegister($sql);

          return $request;
     }

     public static function selectVentaUltimos3Meses()
     {
          $crud = new Crud();

          $sql = "SELECT MONTH(fecha) AS idMes, MONTHNAME(v.fecha) AS Mes, SUM(v.m_total) AS Total FROM venta v WHERE YEAR(v.fecha) = YEAR(v.fecha) GROUP BY Mes ORDER BY idMes DESC;";
          $request = $crud->get_AllRegister($sql);

          return $request;
     }
}
