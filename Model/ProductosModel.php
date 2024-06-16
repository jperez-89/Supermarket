<?php

class ProductosModel extends Crud
{
     public $id;
     public $codigo;
     public $nombre;
     public $precio;
     public $stock;
     public $descripcion;
     public $medida;
     public $state;
     public $ruta;
     public $img;

     public function __construct()
     {
          parent::__construct();
     }

     public static function insertProducto(string $codigo, string $nombre, float $precio, float $cantidad, string $descripcion, string $medida, int $iva, string $imagen)
     {
          $crud = new Crud();
          $return = 0;

          $request = self::SearchProductbByCode($codigo);

          if (empty($request)) {
               $query_insert = "INSERT INTO producto (codigo, name, price, description, measure, iva, state, img) VALUES (?,?,?,?,?,?,?,?)";
               $arrData = array($codigo, $nombre, $precio, $descripcion, $medida, $iva, 1, $imagen);

               $request = $crud->Insert_Register($query_insert, $arrData);

               if ($request > 0) {
                    $query_insert = "INSERT INTO inventario (idProducto, cantidad) VALUES (?,?)";
                    $arrData = array($request, $cantidad);

                    $return = $crud->Insert_Register($query_insert, $arrData);
               }
          } else {
               $return = 'existe';
          }
          return $return;
     }

     public static function SelectProductos()
     {
          $crud = new Crud();

          $sql = "SELECT p.id, p.codigo, p.name, p.description, im.valor, um.unidad, p.price, i.cantidad, p.minimo, p.state, p.img 
          FROM producto p 
          INNER JOIN unidad_medida um ON um.nomenclatura = p.measure
          INNER JOIN inventario i ON i.idProducto = p.id
          INNER JOIN impuesto im ON im.id = p.iva";

          $request = $crud->get_AllRegister($sql);
          return $request;
     }

     public function selectCantProductos()
     {
          $sql = "SELECT count(id) as Cantidad FROM producto";
          $request = $this->get_CountRegister($sql);
          return $request;
     }

     public static function SearchProductbByCode(string $codigo)
     {
          $crud = new Crud();
          $sql = "SELECT p.*, i.cantidad, im.id AS idIVA 
          FROM producto p 
          INNER JOIN inventario i ON i.idProducto = p.id 
          INNER JOIN impuesto im ON im.id = p.iva 
          WHERE p.codigo = $codigo";
          $request = $crud->get_OneRegister($sql);
          return $request;
     }

     public static function updateProducto(string $codigo, int $id, string $nombre, float $precio, float $cantidad, string $descripcion, string $medida, int $iva, string $img)
     {
          $crud = new Crud();
          $return = 0;

          $request = self::SearchProductbByCode($codigo);

          if (!empty($request)) {
               if ($img == "") {
                    // Actualiza la informacion
                    $u_Producto = "UPDATE producto SET codigo = ?, name = ?, price = ?, description = ?, measure = ?, iva = ? WHERE codigo = $codigo";
                    $arrData = array($codigo, $nombre, $precio, $descripcion, $medida, $iva);


                    if ($cantidad != '') {
                         $u_Inventario = "UPDATE inventario SET cantidad = cantidad + ? WHERE idProducto = " . $request['id'];
                         $arrDataa = array($cantidad);
                    }
               } else {
                    // Actualiza la informacion e imagen
                    $u_Producto = "UPDATE producto SET codigo = ?, name = ?, price = ?, description = ?, measure = ?, iva = ?, img = ? WHERE codigo = $codigo";
                    $arrData = array($codigo, $nombre, $precio, $descripcion, $medida, $iva, $img);

                    if ($cantidad != '') {
                         $u_Inventario = "UPDATE inventario SET cantidad = cantidad + ? WHERE idProducto = " . $request['id'];
                         $arrDataa = array($cantidad);
                    }
               }

               if ($crud->update_Register($u_Producto, $arrData)) {
                    $return = $crud->update_Register($u_Inventario, $arrDataa);
               }
          }

          return $return;
     }

     public static function deleteProducto(string $codigo)
     {
          $crud = new Crud();
          $request = self::SearchProductbByCode($codigo);

          if (!empty($request)) {
               $sql = "UPDATE producto SET state = ? WHERE codigo = $codigo";
               $arrData = array(0);
               $request = $crud->update_Register($sql, $arrData);
               if ($request) {
                    $request = "ok";
               } else {
                    $request = "error";
               }
          } else {
               $request = "exist";
          }
          return $request;
     }

     public static function enableProduct(string $codigo)
     {
          $crud = new Crud();
          $request = self::SearchProductbByCode($codigo);

          if (!empty($request)) {
               $sql = "UPDATE producto SET state = ? WHERE codigo = $codigo";
               $arrData = array(1);
               $request = $crud->update_Register($sql, $arrData);
               if ($request) {
                    $request = "ok";
               } else {
                    $request = "error";
               }
          } else {
               $request = "exist";
          }
          return $request;
     }

     public static function selectUnidadMedida()
     {
          $crud = new Crud();

          $sql = "SELECT id, unidad, nomenclatura, equivalencia, estado FROM unidad_medida";
          $request = $crud->get_AllRegister($sql);

          return $request;
     }

     public static function selectImpuestos()
     {
          $crud = new Crud();

          $sql = "SELECT * FROM impuesto";
          $request = $crud->get_AllRegister($sql);

          return $request;
     }

     public static function SelectProductosMinimo()
     {
          $crud = new Crud();

          $sql = "SELECT p.id, p.name, p.description, um.unidad, i.cantidad, p.minimo, p.state 
          FROM producto p 
          INNER JOIN unidad_medida um ON um.nomenclatura = p.measure
          INNER JOIN inventario i ON i.idProducto = p.id
          WHERE i.cantidad <= p.minimo";

          $request = $crud->get_AllRegister($sql);
          return $request;
     }

     public static function insertUnidadMedida(string $unidad, string $nomenclatura, float $equivalencia)
     {
          $crud = new Crud();

          $request = self::SearchUnidadByName($unidad);

          if (empty($request)) {
               $query_insert = "INSERT INTO unidad_medida (unidad, nomenclatura, equivalencia, estado) VALUES (?,?,?,?)";
               $arrData = array($unidad, $nomenclatura, $equivalencia, 1);

               $request = $crud->Insert_Register($query_insert, $arrData);
          } else {
               $request = false;
          }
          return $request;
     }

     public static function updateUnidadMedida(int $idUnidad, string $unidad, string $nomenclatura, float $equivalencia)
     {
          $crud = new Crud();

          $request = self::SearchUnidadById($idUnidad);

          if (!empty($request)) {
               $query_insert = "UPDATE unidad_medida SET unidad = ?, nomenclatura = ?, equivalencia = ? WHERE id = $idUnidad";
               $arrData = array($unidad, $nomenclatura, $equivalencia);

               $request = $crud->update_Register($query_insert, $arrData);
          } else {
               $request = false;
          }
          return $request;
     }

     public static function SearchUnidadByName($unidad)
     {
          $crud = new Crud();

          $sql = "SELECT unidad, nomenclatura, equivalencia, estado FROM unidad_medida WHERE unidad COLLATE utf8mb4_spanish_ci = '$unidad'";
          $request = $crud->get_OneRegister($sql);

          return $request;
     }

     public static function SearchUnidadById($idUnidad)
     {
          $crud = new Crud();

          $sql = "SELECT unidad, nomenclatura, equivalencia, estado FROM unidad_medida WHERE id = $idUnidad";
          $request = $crud->get_OneRegister($sql);

          return $request;
     }

     public static function deleteUnidadMedida(int $idUnidad)
     {
          $crud = new Crud();

          $sql = "UPDATE unidad_medida SET estado = ? WHERE id = $idUnidad";
          $arrData = array(0);
          $request = $crud->update_Register($sql, $arrData);

          return $request;
     }

     public static function enableUnidadMedida(int $idUnidad)
     {
          $crud = new Crud();

          $sql = "UPDATE unidad_medida SET estado = ? WHERE id = $idUnidad";
          $arrData = array(1);
          $request = $crud->update_Register($sql, $arrData);

          return $request;
     }
}
