<?php
require 'vendor/autoload.php';

use Picqer\Barcode\BarcodeGeneratorHTML;

class Productos extends Controllers
{
     public function __construct()
     {
          session_start();
          if (!isset($_SESSION['login'])) {
               header('Location: ' . base_url() . 'login');
          }

          parent::__construct();
     }

     public function Productos()
     {
          $data['page_title'] = "Supermarket  - Productos";
          $data['page_name'] = "Productos";
          $data['page_functions'] = "js/function_Products.js";
          // Hacemos el enlace a la vista
          $this->views->getViews($this, 'productos', $data);
     }

     public function setProducto()
     {
          $id = intval($_POST['idProducto']);
          $codigo = strClean($_POST['txtCodigo']);
          $nombre = strClean($_POST['txtNombre']);
          $Precio = floatval($_POST['txtPrecio']);
          $Stock = floatval($_POST['txtStock']);
          $Descripcion = strClean($_POST['txtDescripcion']);
          $Medida = strClean($_POST['selecMedida']);
          $iva = strClean($_POST['selecIVA']);
          $img = '';

          // Metodo para insertar
          if (isset($_POST['op']) && $_POST['op'] === '') {
               $image = $_FILES['image'];
               // Inserta producto con imagen
               if (!empty($image['name'])) {
                    if ($image['error'] > 0) {
                         $arrResponse = array('status' => false, 'msg' => 'Error en la imagen');
                    } else {
                         $tipoImg = $_FILES['image']['type'];
                         $extensiones = array('image/jpg', 'image/jpeg', 'image/png', 'image/gif', 'application/pdf');

                         if (in_array($tipoImg, $extensiones)) {
                              $nombreImg = $_FILES['image']['name'];
                              $rutaTemporal = $_FILES['image']['tmp_name'];

                              $ruta = productosImg();
                              $archivo = $ruta . $nombreImg;

                              $request_Producto = ProductosModel::insertProducto($codigo, $nombre, $Precio, $Stock, $Descripcion, $Medida, $iva, $nombreImg);

                              if (!$request_Producto) { // Se hace esta validacion por que la tabla inventario no tiene id auto incremental
                                   if (!file_exists($ruta)) {
                                        mkdir($ruta);
                                   }

                                   $resultado = move_uploaded_file($rutaTemporal, $archivo);

                                   if ($resultado) {
                                        $arrResponse = array('status' => true, 'msg' => 'Datos guardados');
                                   } else {
                                        $arrResponse = array('status' => false, 'msg' => 'No es posible almacenar la imagen');
                                   }
                              } else if ($request_Producto == 'existe') {
                                   $arrResponse = array('status' => false, 'msg' => 'Atencion! El producto ya existe');
                              } else {
                                   $arrResponse = array('status' => false, 'msg' => 'No es posible almacenar los datos');
                              }
                         } else {
                              $arrResponse = array('status' => false, 'msg' => 'Tipo de imagen no permitida');
                         }
                    }
               }
               // Inserta producto sin imagen
               else {
                    $request_Producto = ProductosModel::insertProducto($codigo, $nombre, $Precio, $Stock, $Descripcion, $Medida, $iva, 'sinfoto.png');

                    if (!$request_Producto) {
                         $arrResponse = array('status' => true, 'msg' => 'Datos guardados');
                    } else if ($request_Producto == 'existe') {
                         $arrResponse = array('status' => false, 'msg' => 'Atencion! El producto ya existe');
                    } else {
                         $arrResponse = array('status' => false, 'msg' => 'No es posible almacenar los datos');
                    }
               }
          }
          // Metodo para actualizar
          else {
               $image = $_FILES['image'];
               // Se actualiza la informacion
               if (empty($image['name'])) {
                    $request_Producto = ProductosModel::updateProducto($codigo, $id, $nombre, $Precio, $Stock, $Descripcion, $Medida, $iva, $img);

                    if ($request_Producto > 0) {
                         $arrResponse = array('status' => true, 'msg' => 'Datos actualizados');
                    } else {
                         $arrResponse = array('status' => false, 'msg' => 'No es posible almacenar los datos');
                    }
               }
               // Se actualiza informacion e imagen
               else {
                    if ($image['error'] > 0) {
                         $arrResponse = array('status' => false, 'msg' => 'Error en la imagen');
                    } else {
                         // Eliminar la imagen anterior
                         $imgProducto = ProductosModel::SearchProductbByCode($codigo);

                         if (isset($imgProducto['img'])) {
                              if (file_exists(productosImg() . $imgProducto['img'] && $imgProducto['img'] != 'sinfoto.png')) {
                                   unlink(productosImg() . $imgProducto['img']);
                              }
                         }

                         $tipoImg = $_FILES['image']['type'];
                         $extensiones = array('image/jpeg', 'image/png', 'image/gif', 'application/pdf');

                         if (in_array($tipoImg, $extensiones)) {
                              $nombreImg = $_FILES['image']['name'];
                              $rutaTemporal = $_FILES['image']['tmp_name'];

                              $ruta = productosImg();
                              $archivo = $ruta . $nombreImg;

                              $request_Producto = ProductosModel::updateProducto($codigo, $id, $nombre, $Precio, $Stock, $Descripcion, $Medida, $iva, $nombreImg);

                              if ($request_Producto > 0) {
                                   if (!file_exists($ruta)) {
                                        mkdir($ruta);
                                   }

                                   $resultado = move_uploaded_file($rutaTemporal, $archivo);

                                   if ($resultado) {
                                        $arrResponse = array('status' => true, 'msg' => 'Datos actualizados');
                                   } else {
                                        $arrResponse = array('status' => false, 'msg' => 'No es posible almacenar la imagen');
                                   }
                              } else {
                                   $arrResponse = array('status' => false, 'msg' => 'No es posible almacenar los datos');
                              }
                         } else {
                              $arrResponse = array('status' => false, 'msg' => 'Tipo de imagen no permitida');
                         }
                    }
               }
          }

          echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
          die();
     }

     public function getProductos()
     {
          $arrdatos = ProductosModel::selectProductos();
          $bar = new BarcodeGeneratorHTML();

          for ($i = 0; $i < count($arrdatos); $i++) {

               if ($arrdatos[$i]['state'] == 1) {
                    $arrdatos[$i]['valor'] = $arrdatos[$i]['valor'] . "<span>%</span>";

                    $arrdatos[$i]['code'] = '<div class="">' . $bar->getBarcode($arrdatos[$i]['codigo'], $bar::TYPE_EAN_13) . '</div>';

                    $arrdatos[$i]['img'] = '<img onerror=this.onerror=null;this.src="' . productosImg() . 'sinfoto.png" class="pequena" src="' . productosImg() . $arrdatos[$i]['img'] . '" alt="' . $arrdatos[$i]['name'] . '" >';

                    $arrdatos[$i]['state'] = '<span class="badge badge-success">Activo</span>';

                    $arrdatos[$i]['options'] = '
                                             <button onClick="fntEditProduct(' . $arrdatos[$i]['codigo'] . ')" class="btn btn-primary2">
                                                  <i class="fas fa-pencil-alt"></i>
                                             </button>
                                             <button onClick="fntDeleteProduct(' . $arrdatos[$i]['codigo'] . ')" class="btn btn-danger2">
                                                  <i class="fas fa-trash"></i>
                                             </button>';
                    if ($arrdatos[$i]['cantidad'] <= $arrdatos[$i]['minimo']) {
                         $arrdatos[$i]['cantidad'] = '<span class="badge badge-danger">' . $arrdatos[$i]['cantidad'] . '</span>';
                    }
               } else {
                    $arrdatos[$i]['code'] = '<div class="">' . $bar->getBarcode($arrdatos[$i]['codigo'], $bar::TYPE_EAN_13) . '</div>';

                    $arrdatos[$i]['img'] = '<img onerror=this.onerror=null;this.src="' . productosImg() . 'sinfoto.png" class="pequena" src="' . productosImg() . $arrdatos[$i]['img'] . '" alt="' . $arrdatos[$i]['name'] . '" >';
                    $arrdatos[$i]['state'] = ' <span class="badge badge-danger">Inactivo</span>';

                    $arrdatos[$i]['options'] = '
                                             <button onClick="fntEnableProduct(' . $arrdatos[$i]['codigo'] . ')" class="btn btn-success2">
                                                  <i class="fas fa-sync-alt"></i>
                                             </button>
                                             <button disabled onClick="fntDeleteProduct(' . $arrdatos[$i]['codigo'] . ')" class="btn btn-danger2">
                                                  <i class="fas fa-trash"></i>
                                             </button>';
               }
          }
          echo json_encode($arrdatos, JSON_UNESCAPED_UNICODE);
          die();
     }

     public function getProducto(string $codigo)
     {
          $codigo = strClean($codigo);
          if ($codigo > 0) {
               $arrdatos = ProductosModel::SearchProductbByCode($codigo);

               if (empty($arrdatos)) {
                    $arrResponse = array('status' => false, 'msg' => 'Datos no encontrados');
               } else {
                    $arrResponse = array('status' => true, 'data' => $arrdatos);
               }
               echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
          }
          die();
     }

     public function deleteProduct()
     {
          if ($_POST) {
               $codigo = intval($_POST['codigo']);
               $resquestDelete = $this->model->deleteProducto($codigo);

               if ($resquestDelete == 'ok') {
                    $arrResponse = array('status' => true, 'msg' => 'Producto eliminado');
               } elseif ($resquestDelete == 'exist') {
                    $arrResponse = array('status' => false, 'msg' => 'No es posible eliminar el producto, aún tienes disponible.');
               } else {
                    $arrResponse = array('status' => false, 'msg' => 'No es posible eliminar los datos.');
               }
               echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
          }
          die();
     }

     public function enableProduct()
     {
          if ($_POST) {
               $codigo = intval($_POST['codigo']);
               $resquestDelete = $this->model->enableProduct($codigo);

               if ($resquestDelete == 'ok') {
                    $arrResponse = array('status' => true, 'msg' => 'Producto Habilitado.');
               } elseif ($resquestDelete == 'exist') {
                    $arrResponse = array('status' => false, 'msg' => 'No es posible habilitar el producto');
               } else {
                    $arrResponse = array('status' => false, 'msg' => 'No es posible eliminar los datos.');
               }
               echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
          }
          die();
     }

     public function getUnidadMedida()
     {
          $arrdatos = $this->model->selectUnidadMedida();

          echo json_encode($arrdatos, JSON_UNESCAPED_UNICODE);
          die();
     }

     public function getImpuestos()
     {
          $arrdatos = ProductosModel::selectImpuestos();

          echo json_encode($arrdatos, JSON_UNESCAPED_UNICODE);
          die();
     }

     public function getCantProductos()
     {
          $arrdatos = $this->model->selectCantProductos();

          echo json_encode($arrdatos, JSON_UNESCAPED_UNICODE);
          die();
     }

     // -------------------> Funciones Modulo Unidad de Medida <----------------------
     public function Unidad_Medida()
     {
          $data['page_title'] = "Supermarket - Unidad de Medida";
          $data['page_name'] = "Unidad de medida";
          $data['page_functions'] = 'js/function_UnidadMedida.js';

          // Hacemos el enlace a la vista
          $this->views->getViews($this, 'unidad_medida', $data);
     }

     public function getUnidadesMedida()
     {
          $arrdatos = ProductosModel::selectUnidadMedida();

          for ($i = 0; $i < count($arrdatos); $i++) {

               if ($arrdatos[$i]['estado'] == 1) {
                    $arrdatos[$i]['estado'] = '<span class="badge badge-success">Activo</span>';

                    $arrdatos[$i]['options'] = '<div class="flex-center">
                                             <button class="btn btn-primary2 editUnidadMedida">
                                                  <i class="fas fa-pencil-alt"></i>
                                             </button>
                                             <button class="btn btn-danger2 deleteUnidadMedida">
                                                  <i class="fas fa-trash"></i>
                                             </button> </div>';
               } else {
                    $arrdatos[$i]['estado'] = ' <span class="badge badge-danger">Inactivo</span>';

                    $arrdatos[$i]['options'] = '<div class="flex-center">
                                             <button class="btn btn-success2 enableUnidadMedida">
                                                  <i class="fas fa-sync-alt"></i>
                                             </button>
                                             <button disabled class="btn btn-danger2 deleteUnidadMedida">
                                                  <i class="fas fa-trash"></i>
                                             </button> </div>';
               }
          }

          echo json_encode($arrdatos, JSON_UNESCAPED_UNICODE);
          die();
     }

     public function setUnidadMedida()
     {
          try {
               $idUnidad = intval($_POST['idUnidadMedida']);
               $nombreUnidad = strClean($_POST['nombreUnidad']);
               $nomenclatura = strClean($_POST['nomenclatura']);
               $equivalencia = floatval($_POST['equivalencia']);

               if ($idUnidad == 0) {
                    $request = ProductosModel::insertUnidadMedida($nombreUnidad, $nomenclatura, $equivalencia);
                    $option = 1;
               } else {
                    $request = ProductosModel::updateUnidadMedida($idUnidad, $nombreUnidad, $nomenclatura, $equivalencia);
                    $option = 2;
               }

               if ($request > 0) {
                    if ($option == 1) {
                         $arrResponse = array('status' => true, 'msg' => 'Datos guardados.');
                    } else {
                         $arrResponse = array('status' => true, 'msg' => 'Datos actualizados.');
                    }
               } else if ($request == 0) {
                    $arrResponse = array('status' => false, 'msg' => 'Ya existe esa unidad de medida.');
               } else {
                    $arrResponse = array('status' => false, 'msg' => 'No es posible almacenar los datos.');
               }
          } catch (Throwable $th) {
               $arrResponse = array('status' => false, 'msg' => 'Error => ' . $th);
          }

          echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
          die();
     }

     public function deleteUnidadMedida()
     {
          if ($_POST) {
               try {
                    $idUnidad = intval($_POST['idUnidad']);
                    $requestDelete = ProductosModel::deleteUnidadMedida($idUnidad);

                    if ($requestDelete) {
                         $arrResponse = array('status' => true, 'msg' => 'Unidad de medida deshabilitada');
                    } else {
                         $arrResponse = array('status' => false, 'msg' => 'No es posible deshabilitar la unidad de medida');
                    }
               } catch (\Throwable $th) {
                    $arrResponse = array('status' => false, 'msg' => 'Error al deshabilitar la unidad de medida => ' . $th);
               }
               echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
          }
          die();
     }

     public function enableUnidadMedida()
     {
          if ($_POST) {
               try {
                    $idUnidad = intval($_POST['idUnidad']);
                    $requestDelete = ProductosModel::enableUnidadMedida($idUnidad);

                    if ($requestDelete) {
                         $arrResponse = array('status' => true, 'msg' => 'Unidad de medida habilitada');
                    } else {
                         $arrResponse = array('status' => false, 'msg' => 'No es posible habilitar la unidad de medida');
                    }
               } catch (\Throwable $th) {
                    $arrResponse = array('status' => false, 'msg' => 'Error al habilitar la unidad de medida => ', 'error' => $th);
               }
               echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
          }
          die();
     }

     // -------------------> Funciones Modulo Dashboard <----------------------
     public function getProductosMinimo()
     {
          $arrdatos = ProductosModel::SelectProductosMinimo();

          // for ($i = 0; $i < count($arrdatos); $i++) {
          //      if ($arrdatos[$i]['cantidad'] <= $arrdatos[$i]['minimo']) {
          //           $arrdatos[$i]['cantidad'] = '<span class="badge badge-danger">' . $arrdatos[$i]['cantidad'] . '</span>';
          //      }
          // }

          echo json_encode($arrdatos, JSON_UNESCAPED_UNICODE);
          die();
     }
}
