<?php

namespace Dao\Productos;

use Dao\Table;

class Producto extends Table {
    public static function obtenerProductos() {
        $sqlstr = "SELECT * FROM productos";

        return self::obtenerRegistros($sqlstr, []);
    }

    public static function obtenerProductoPorId($id) {
        $sqlstr = "SELECT * FROM productos WHERE PrdID = :PrdID;";
        $params = ["PrdID" => $id];

        return self::obtenerUnRegistro($sqlstr, $params);
    }

    public static function ingresarProducto($nombre, $precio, $imagen, $stock, $idCat, $idPrv, $estado) {
        $sqlstr = "INSERT INTO productos (PrdNombre, PrdPrecio, PrdImagen, PrdStock, CatID, PrvID, PrdCreacion, PrdEstado) values (:PrdNombre, :PrdPrecio, :PrdImagen, :PrdStock, :CatID, :PrvID, NOW(), :PrdEstado);";

        $params = [
            "PrdNombre" => $nombre,
            "PrdPrecio" => $precio,
            "PrdImagen" => $imagen,
            "PrdStock" => $stock,
            "CatID" => $idCat,
            "PrvID" => $idPrv,
            "PrdEstado" => $estado
        ];

        return self::executeNonQuery($sqlstr, $params);
    }

    public static function actualizarProducto($id, $nombre, $precio, $imagen, $stock, $idCat, $idPrv, $estado) {
        $sqlstr = "UPDATE productos SET PrdNombre = :PrdNombre, PrdPrecio = :PrdPrecio, PrdImagen = :PrdImagen, PrdStock = :PrdStock, CatID = :CatID, PrvID = :PrvID, PrdEstado = :PrdEstado WHERE PrdID = :PrdID;";

        $params = [
            "PrdNombre" => $nombre,
            "PrdPrecio" => $precio,
            "PrdImagen" => $imagen,
            "PrdStock" => $stock,
            "CatID" => $idCat,
            "PrvID" => $idPrv,
            "PrdEstado" => $estado,
            "PrdID" => $id
        ];

        return self::executeNonQuery($sqlstr, $params);
    }

    public static function eliminarProducto($id) {
        $sqlstr = "DELETE FROM productos WHERE PrdID = :PrdID;";
        $params = ["PrdID" => $id];

        return self::executeNonQuery($sqlstr, $params);
    }

    public static function obtenerIdTabla($tabla, $nombreId, $nombreCampo, $nombre) {
        $sqlstr = "SELECT ". $nombreId ." FROM ". $tabla ." WHERE ". $nombreCampo ." = :". $nombreCampo . ";"; 
        $params = [$nombreCampo => $nombre];

        return self::obtenerUnRegistro($sqlstr, $params);
    }

    public static function productosPorCategoria($idCategoria){
        $sqlstr = "select * from productos where CatID=:CatID";
        $params = [
            "CatID" => $idCategoria
        ];
        return self::executeNonQuery($sqlstr, $params);
    }

    public static function productosPorProveedor($idProveedor){
        $sqlstr = "select * from productos where PrvID=:PrvID";
        $params = [
            "PrvID"=> $idProveedor  
        ];
        return self::executeNonQuery($sqlstr, $params);
    }
}