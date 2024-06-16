<?php

class Facturacion extends Controllers
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

     public function Nueva_venta()
     {
          $data['page_title'] = "Supermarket - Nueva Venta";
          $data['page_name'] = "Nueva Venta";
          $data['page_functions'] = "js/function_NuevaVenta.js";
          // Hacemos el enlace a la vista
          $this->views->getViews($this, 'nueva_venta', $data);
     }

     public function getCantFacturas()
     {
          $arrdatos = FacturacionModel::selectCantFacturas();

          echo json_encode($arrdatos, JSON_UNESCAPED_UNICODE);
          die();
     }

     public function getCliente()
     {
          $dato = strClean($_POST["dato"]);
          $op = strClean($_POST["op"]);

          $arrdatos = FacturacionModel::selectCliente($dato, $op);

          if (!empty($arrdatos)) {
               $html = "";

               switch ($op) {
                    case 'i':
                         for ($i = 0; $i < count($arrdatos); $i++) {
                              $html .= "<li class='list2' onclick=MostrarCliente('" . $arrdatos[$i]['id'] . "','data')>" . $arrdatos[$i]['Identificacion'] . "</li>";
                         }

                         $arrResponse = array('status' => true, 'data' => $html);
                         break;

                    case 'n':
                         for ($i = 0; $i < count($arrdatos); $i++) {
                              $html .= "<li class='list2' onclick=MostrarCliente('" . $arrdatos[$i]['id'] . "','data')>" . $arrdatos[$i]['Nombre'] . "</li>";
                         }

                         $arrResponse = array('status' => true, 'data' => $html);
                         break;

                    case 'data':
                         $arrResponse = array('status' => true, 'data' => $arrdatos[0]);
                         break;
               }
          } else {
               $arrResponse = array('status' => false);
          }

          echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
          die();
     }

     public function getProducto()
     {
          if (isset($_POST)) {
               $op = $_POST['op'];
               $dato = $_POST['dato'];

               $arrdatos = FacturacionModel::selectProducto($op, $dato);

               if (!empty($arrdatos)) {
                    $html = "";

                    switch ($op) {
                         case 'n':
                              for ($i = 0; $i < count($arrdatos); $i++) {
                                   $html .= "<li class='list2' onclick=MostrarProducto('" . $arrdatos[$i]['codigo'] . "','data')>" . $arrdatos[$i]['name'] . "</li>";
                              }

                              $arrResponse = array('status' => true, 'data' => $html);
                              break;

                         case 'data':
                              $arrResponse = array('status' => true, 'data' => $arrdatos[0]);
                              break;
                    }
               } else {
                    $arrResponse = array('status' => false, 'msg' => 'No hay producto en existencia');
               }
          } else {
               $arrResponse = array('status' => false, 'msg' => 'Faltan datos');
          }

          echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
          die();
     }

     public function getProducts()
     {
          $arrdatos = $this->model->selectProducts();
          if (empty($arrdatos)) {
               $arrResponse = array('status' => false, 'msg' => 'Datos no encontrados');
          } else {
               $arrResponse = array('status' => true, 'data' => $arrdatos);
          }
          echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
          die();
     }

     public function insertEncaFactura()
     {
          if (isset($_POST)) {
               $idCliente = $_POST['idCliente'];
               $tipoFactura = $_POST['tipoDocumento'];
               $tipoPago = $_POST['tipoPago'];
               $Subtotal = $_POST['Subtotal'];
               $iva = $_POST['iva'];
               $totalFactura = $_POST['totalFactura'];

               $arrdatos = FacturacionModel::setEncaFactura($tipoFactura, $tipoPago, $idCliente, $Subtotal, $iva, $totalFactura);

               if ($arrdatos > 0) {
                    $arrResponse = array('status' => true, 'msg' => 'Datos Guardados', 'id' => $arrdatos);
               } else {
                    $arrResponse = array('status' => false, 'msg' => 'No se logro guardar los datos');
               }
          } else {
               $arrResponse = array('status' => false, 'msg' => 'Faltan datos');
          }

          echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
          die();
     }

     public function insertDetaFactura()
     {
          if (isset($_POST)) {
               $data = $_POST['datos'];

               if (!empty($data)) {
                    foreach ($data as $key => $value) {
                         $idVenta = $value['idVenta'];
                         $codigo = $value['codProducto'];
                         $cantidad = $value['cantidadProducto'];
                         $preUnitario = $value['precioUnit'];
                         $subTotal = $value['subTotal'];
                         $iva = $value['iva'];
                         $total = $value['total'];

                         $idProducto = FacturacionModel::selectProductoByCode($codigo);

                         $request = FacturacionModel::setDetaFactura($idVenta, $idProducto['id'], $cantidad, $preUnitario, $subTotal, $iva, $total);
                    }
               }

               if ($request != 0) {
                    $arrResponse = array('status' => true, 'msg' => 'Datos guardados');
               } else {
                    $arrResponse = array('status' => false, 'msg' => 'Datos no guardados');
               }
          } else {
               $arrResponse = array('status' => false, 'msg' => 'Faltan datos');
          }

          echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
          die();
     }

     public function insertFacturaCredito()
     {
          if (isset($_POST)) {
               $idVenta = $_POST['idVenta'];

               $arrdatos = FacturacionModel::setFacturaCredito($idVenta);

               if ($arrdatos > 0) {
                    $arrResponse = array('status' => true);
               } else {
                    $arrResponse = array('status' => false, 'msg' => 'No se logro guardar los datos');
               }
          } else {
               $arrResponse = array('status' => false, 'msg' => 'Faltan datos');
          }

          echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
          die();
     }

     public function insertarComprobante()
     {
          if (isset($_POST)) {
               $idVenta = intval($_POST['idVenta']);
               $nComprobante = strClean($_POST['nComprobante']);

               $arrdatos = FacturacionModel::setComprobante($idVenta, $nComprobante);

               if ($arrdatos > 0) {
                    $arrResponse = array('status' => true, 'msg' => 'Factura cancelada');
               } else {
                    $arrResponse = array('status' => false, 'msg' => 'No se logro guardar los datos');
               }
          } else {
               $arrResponse = array('status' => false, 'msg' => 'Faltan datos');
          }

          echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
          die();
     }

     public function getTipoDocumento()
     {
          $arrdatos = FacturacionModel::selectTipoDocumento();

          if (empty($arrdatos)) {
               $arrResponse = array('status' => false, 'msg' => 'Datos no encontrados');
          } else {
               $arrResponse = array('status' => true, 'data' => $arrdatos);
          }

          echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
          die();
     }

     public function getTipoPago()
     {
          $arrdatos = FacturacionModel::selectTipoPago();

          if (empty($arrdatos)) {
               $arrResponse = array('status' => false, 'msg' => 'Datos no encontrados');
          } else {
               $arrResponse = array('status' => true, 'data' => $arrdatos);
          }

          echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
          die();
     }

     public function GeneraFactura()
     {
          if (isset($_POST)) {
               $idVenta = intval($_POST['idVenta']);
               $tipoFactura = strClean($_POST['tipoFactura']);

               $Factura = FacturacionModel::selectFacturaById($idVenta);

               if (!empty($Factura)) {
                    switch ($tipoFactura) {
                              // F.E
                         case '01':
                              $idFactura = FacturacionModel::selectLastIdFactura();

                              if (!empty($idFactura['idFactura'])) {
                                   $idFactura['idFactura'] += 1;
                              } else {
                                   $idFactura['idFactura'] = 1;
                              }

                              $codigo = $Factura['codigo'];
                              $leng = 10;
                              $result = str_pad($idFactura['idFactura'], $leng, "0", STR_PAD_LEFT); // $start, $count, $digits

                              $nDocumento = sucursal . terminal . $codigo . $result;

                              $request = FacturacionModel::insertNumeroFactura($nDocumento, $Factura['id']);
                              break;

                              // T.E
                         case '02':
                              $idTiquete = FacturacionModel::selectLastIdTiquete();

                              if (empty($idTiquete['idTiquete'])) {
                                   $idTiquete['idTiquete'] = 1;
                              } else {
                                   $idTiquete['idTiquete'] += 1;
                              }

                              $codigo = $Factura['codigo'];
                              $leng = 10;
                              $result = str_pad($idTiquete['idTiquete'], $leng, "0", STR_PAD_LEFT); // $start, $count, $digits

                              $nDocumento = sucursal . terminal . $codigo . $result;

                              $request = FacturacionModel::insertNumeroTiquete($nDocumento, $Factura['id']);
                              break;

                              // Voucher
                         case '03':
                              $idVoucher = FacturacionModel::selectLastIdVoucher();

                              if (empty($idVoucher['idVoucher'])) {
                                   $idVoucher['idVoucher'] = 1;
                              } else {
                                   $idVoucher['idVoucher'] += 1;
                              }

                              $codigo = $Factura['codigo'];
                              $leng = 10;
                              $result = str_pad($idVoucher['idVoucher'], $leng, "0", STR_PAD_LEFT); // $start, $count, $digits

                              $nDocumento = sucursal . terminal . $codigo . $result;

                              $request = FacturacionModel::insertNumeroVoucher($nDocumento, $Factura['id']);
                              break;
                    }

                    if ($request > 0) {
                         $response = FacturacionModel::updateNumeroFactura($Factura['id'], $nDocumento);
                         $emailCliente = $Factura['Email'];

                         if ($response > 0) {
                              $arrResponse = array('status' => true, 'msg' => 'Datos Guardados', 'nfactura' => $nDocumento, 'emailCliente' => $emailCliente);
                         } else {
                              $arrResponse = array('status' => false, 'msg' => 'No se genero # de factura');
                         }
                    } else {
                         $arrResponse = array('status' => false, 'msg' => 'No se generó el # de documento');
                    }
               } else {
                    $arrResponse = array('status' => false, 'msg' => 'No existe la factura');
               }
          } else {
               $arrResponse = array('status' => false, 'msg' => 'Faltan datos');
          }

          echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
          die();
     }

     // -------------------> Funciones Modulo Facturas <----------------------
     public function Facturas()
     {
          $data['page_title'] = "Supermarket - Facturas";
          $data['page_name'] = "Facturas";
          $data['page_functions'] = "js/function_Facturas.js";
          // Hacemos el enlace a la vista
          $this->views->getViews($this, 'facturas', $data);
     }

     public function getFacturas()
     {
          try {
               $arrdatos = FacturacionModel::selectFacturas();

               for ($i = 0; $i < count($arrdatos); $i++) {
                    if ($arrdatos[$i]['estado'] == 1) {
                         // ESTADO
                         $arrdatos[$i]['estado'] = '<div class=""> <span class="badge badge-success">Pagada</span> </div>';
                    } else if ($arrdatos[$i]['estado'] == 0) {
                         // ESTADO
                         $arrdatos[$i]['estado'] = '<div class=""> <span class="badge badge-warning">Pendiente</span> </div>';
                    }

                    // ACCIONES
                    $arrdatos[$i]['options'] = '<div class="">
                                             <button data-target="#ModalDetalleFactura" data-toggle="modal" onclick = "fntVerDetalleFactura(' . $arrdatos[$i]['id'] . ')"  class="btn btn-primary2" title:"Ver Factura">
                                                  <i class="fas fa-eye"></i>
                                             </button>
                                             <button onclick=verFacturaPDF("' . strClean($arrdatos[$i]['nfactura']) . '") class="btn btn-danger2" title:"Ver PDF">
                                                  <i class="far fa-file-pdf"></i>
                                             </button>
                                             <button onclick=fntReenviarFactura("' . strClean($arrdatos[$i]['nfactura']) . '","' . strClean($arrdatos[$i]['Email']) . '") class="btn btn-success2" title:"Reenviar Factura">
                                                  <i class="fas fa-mail-bulk"></i>
                                             </button>
                                        </div>';

                    // <button onclick=fntReenviarFactura("' . strClean($arrdatos[$i]['nfactura']) . '") class="btn btn-success2" title:"Reenviar Factura">
                    //      <i class="fas fa-mail-bulk"></i>
                    // </button>

                    switch ($arrdatos[$i]['tipo_pago']) {
                         case 'E':
                              $arrdatos[$i]['tipo_pago'] = 'Efectivo';
                              break;

                         case 'T':
                              $arrdatos[$i]['tipo_pago'] = 'Tarjeta';
                              break;

                         case 'S':
                              $arrdatos[$i]['tipo_pago'] = 'Sinpe';
                              break;

                         case 'C':
                              $arrdatos[$i]['tipo_pago'] = 'Crédito';
                              break;
                    }
               }

               echo json_encode($arrdatos, JSON_UNESCAPED_UNICODE);
               die();
          } catch (\Throwable $th) {
               throw $th;
          }
     }

     public function getDetalleFactura($idFactura)
     {
          try {
               $arrdatos = FacturacionModel::selectDetalleFactura($idFactura);

               echo json_encode($arrdatos, JSON_UNESCAPED_UNICODE);
               die();
          } catch (\Throwable $th) {
               throw $th;
          }
     }

     public function generarPDF()
     {
          $idVenta = $_GET['iv'];
          $pagaCon = $_GET['pc'];
          $Vuelto = $_GET['v'];

          $request = FacturacionModel::generarPDF($idVenta, $pagaCon, $Vuelto);
          die();
     }

     public function enviarFactura()
     {
          if (isset($_POST)) {
               require_once("Libraries/Core/correo.php");
               $emailCliente = $_POST['emailCliente'];
               $nFactura = $_POST['nFactura'];

               $dirFactura = 'assets/facturas/factura-' . $nFactura . '.pdf';

               $envio = correo2($emailCliente, 'Envio de Factura ' . $nFactura, '<h1>Estimado/a usuario</h1> <br>En el siguiente correo te adjuntamos la factura correspondiente a tu compra. ¡Te deseamos mchas bendiciones!<br><br> Vuelve pronto!', $dirFactura);

               if ($envio) {
                    $arrdatos = array('status' => true, 'msg' => 'Factura enviada');
               } else {
                    $arrdatos = array('status' => false, 'msg' => 'Error al enviar la factura');
               }
          } else {
               $arrdatos = array('status' => false, 'msg' => 'Faltan datos');
          }

          echo json_encode($arrdatos, JSON_UNESCAPED_UNICODE);
          die();
     }

     // -------------------> Funciones Modulo Dashboard <----------------------
     public function getFacturasEmitidas()
     {
          $arrdatos = FacturacionModel::selectFacturasEmitidas();

          echo json_encode($arrdatos, JSON_UNESCAPED_UNICODE);
          die();
     }

     public function getFormaPago()
     {
          if (isset($_POST)) {
               try {
                    $fchInicioFPagoMes = strClean($_POST['fchInicioFPagoMes']);
                    $fchFinFPagoMes = strClean($_POST['fchFinFPagoMes']);

                    $arrdatos = FacturacionModel::selectFormaPago($fchInicioFPagoMes, $fchFinFPagoMes);
               } catch (\Throwable $th) {
                    $arrdatos = array('status' => false, 'msg' => $th);
               }
          } else {
               $arrdatos = array('status' => false, 'msg' => 'Faltan datos');
          }

          echo json_encode($arrdatos, JSON_UNESCAPED_UNICODE);
          die();
     }

     public function getVentaUltimos3Meses()
     {
          $arrdatos = FacturacionModel::selectVentaUltimos3Meses();

          echo json_encode($arrdatos, JSON_UNESCAPED_UNICODE);
          die();
     }
}
