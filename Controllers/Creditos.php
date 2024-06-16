<?php

class Creditos extends Controllers
{
    public function __construct()
    {
        session_start();
        if (!isset($_SESSION['login'])) {
            header('Location: ' . base_url() . 'login');
        }

        parent::__construct();
    }

    public function Creditos()
    {
        $data['page_title'] = "Supermarket  - Créditos";
        $data['page_name'] = "Créditos";
        $data['page_functions'] = "js/function_Creditos.js";
        // Hacemos el enlace a la vista
        $this->views->getViews($this, 'creditos', $data);
    }

    public function getCreditos()
    {
        try {
            $arrdatos = CreditosModel::selectCreditos();

            for ($i = 0; $i < count($arrdatos); $i++) {
                if ($arrdatos[$i]['estado'] == 1) {
                    // ESTADO
                    $arrdatos[$i]['estado'] = '<div class="flex-center"> <span class="badge badge-success">Activo</span> </div>';

                    // ACCIONES
                    if (!empty($arrdatos[$i]['pendiente_pago'])) {
                        $arrdatos[$i]['options'] = '<div class="flex-center">
                                            <button data-target="#ModalFacturasCreditoCliente" data-toggle="modal" onclick = "fntVerFacturas(' . $arrdatos[$i]['idCliente'] . ')"  class="btn btn-success2" title:"Ver Factura">
                                                  <i class="fas fa-eye"></i>
                                            </button>
                                            <button id="EditMontoCredito" class="btn btn-primary2">
                                                  <i class="fas fa-pencil-alt"></i>
                                            </button>
                                            <button id="DeleteCredito" class="btn btn-danger2">
                                                  <i class="fas fa-trash"></i>
                                            </button>
                                        </div>';
                    } else {
                        $arrdatos[$i]['options'] = '<div class="flex-center">
                                            <button disabled data-target="#ModalFacturasCreditoCliente" data-toggle="modal" onclick = "fntVerFacturas(' . $arrdatos[$i]['idCliente'] . ')"  class="btn btn-scondary2" title:"Ver Factura">
                                                  <i class="fas fa-eye"></i>
                                            </button>
                                            <button id="EditMontoCredito" class="btn btn-primary2">
                                                  <i class="fas fa-pencil-alt"></i>
                                            </button>
                                            <button id="DeleteCredito" class="btn btn-danger2">
                                                  <i class="fas fa-trash"></i>
                                            </button>
                                        </div>';
                    }
                } else {
                    // ESTADO
                    $arrdatos[$i]['estado'] = '<div class="flex-center"> <span class="badge badge-danger">Cerrado</span> </div>';

                    // ACCIONES
                    $arrdatos[$i]['options'] = '<div class="flex-center">
                                            <button disabled data-target="#ModalFacturasCreditoCliente" data-toggle="modal" onclick = "fntVerFacturas(' . $arrdatos[$i]['idCliente'] . ')"  class="btn btn-secondary2" title:"Ver Factura">
                                                  <i class="fas fa-eye"></i>
                                            </button>
                                            <button disabled id="EditMontoCredito" class="btn btn-secondary2">
                                                  <i class="fas fa-pencil-alt"></i>
                                            </button>
                                            <button id="EnableCredito" class="btn btn-success2">
                                                  <i class="fas fa-sync-alt"></i>
                                             </button>
                                        </div>';
                }
            }
        } catch (\Throwable $th) {
            // throw $th;
            $arrdatos = array('status' => false, 'msg' => $th);
        }
        echo json_encode($arrdatos, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function setCredito()
    {
        try {
            $idCredito = intval($_POST['idCredito']);
            $idCliente = strClean($_POST['idCliente']);
            $montoCredito = intval($_POST['montoCredito']);

            if ($idCredito == 0) {
                $request = CreditosModel::insertCredito($idCliente, $montoCredito);
                $option = 1;
            } else {
                $request = CreditosModel::updateCredito($idCredito, $montoCredito);
                $option = 2;
            }

            if ($request > 0) {
                if ($option == 1) {
                    $arrResponse = array('status' => true, 'msg' => 'Datos guardados.');
                } else {
                    $arrResponse = array('status' => true, 'msg' => 'Datos actualizados.');
                }
            } else if ($request == 0) {
                $arrResponse = array('status' => false, 'msg' => 'El cliente ya cuenta con crédito establecido.');
            } else {
                $arrResponse = array('status' => false, 'msg' => 'No es posible almacenar los datos.');
            }

            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            die();
        } catch (Throwable $th) {
            throw $th;
        }
    }

    public function deleteCredito()
    {
        try {
            if (isset($_POST)) {
                $idCredito = intval($_POST['idCredito']);

                $request = CreditosModel::deleteCredito($idCredito);

                if ($request > 0) {
                    $arrResponse = array('status' => true, 'msg' => 'Crédito deshabilitado.');
                } else {
                    $arrResponse = array('status' => false, 'msg' => 'No es posible eliminar los datos.');
                }
            } else {
                $arrResponse = array('status' => false, 'msg' => 'Faltan datos.');
            }

            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            die();
        } catch (Throwable $th) {
            throw $th;
        }
    }

    public function enableCredito()
    {
        try {
            if (isset($_POST)) {
                $idCredito = intval($_POST['idCredito']);

                $request = CreditosModel::enableCredito($idCredito);

                if ($request > 0) {
                    $arrResponse = array('status' => true, 'msg' => 'Crédito habilitado.');
                } else {
                    $arrResponse = array('status' => false, 'msg' => 'No es posible habilitar el credito.');
                }
            } else {
                $arrResponse = array('status' => false, 'msg' => 'Faltan datos.');
            }

            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            die();
        } catch (Throwable $th) {
            throw $th;
        }
    }

    public function getFacturasCreditoCliente($idCliente)
    {
        try {
            $arrdatos = CreditosModel::selectFacturasCreditoCliente($idCliente);

            for ($i = 0; $i < count($arrdatos); $i++) {
                if (!$arrdatos[$i]['estado']) {
                    // ESTADO
                    $arrdatos[$i]['estado'] = '<div class="flex-center"><span class="badge badge-danger">Pendiente</span> </div>';

                    // ACCIONES
                    //  onclick="fntPagarFactura(' . $arrdatos[$i]['id'] . ')"
                    $arrdatos[$i]['options'] = '<div class="flex-center">
                                                                <button id="pagarFactura" class="btn btn-primary2" title:"PagarFactura">
                                                                    <i class="fas fa-sack-dollar" aria-hidden="true"></i> Pagar
                                                                </button>
                                                            </div>';
                }
            }

            echo json_encode($arrdatos, JSON_UNESCAPED_UNICODE);
            die();
        } catch (Throwable $th) {
            throw $th;
        }
    }

    public function updateFactura()
    {
        try {
            $idVenta = intval($_POST['idVenta']);
            $tipoPago = intval($_POST['tipoPago']);

            $request = CreditosModel::updateVenta($idVenta, $tipoPago); // $nComprobante = 0

            if ($request > 0) {
                $arrResponse = array('status' => true, 'msg' => 'Factura cancelada');
            } else {
                $arrResponse = array('status' => false, 'msg' => 'No se pudo cancelar la factura');
            }

            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            die();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    // -------------------> Funciones Modulo Dashboard <----------------------
    public function getCreditoPendientePago()
    {
        $arrdatos = CreditosModel::selectCreditoPendientePago();

        for ($i = 0; $i < count($arrdatos); $i++) {
            if ($arrdatos[$i]['estado']) {
                $arrdatos[$i]['estado'] = '<div class="flex-center"> <span class="badge badge-success">Activo</span> </div>';
            } else {
                $arrdatos[$i]['estado'] = '<div class="flex-center"> <span class="badge badge-danger">Cerrado</span> </div>';
            }
        }

        echo json_encode($arrdatos, JSON_UNESCAPED_UNICODE);
        die();
    }
}
