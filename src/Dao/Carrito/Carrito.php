<?php

namespace Dao\Carrito;

use Dao\Table;

class Carrito extends Table {
    public static function obtenerCarrito() {
        $sqlstr = "SELECT * FROM carritoCompras;";

        return self::obtenerRegistros($sqlstr, []);
    }

    public static function obtenerPrdCarritoPorid($id) {
        $sqlstr = "SELECT * FROM carritoCompras WHERE CrtID = :CrtID;";
        $params = ["CrtID" => $id];

        return self::obtenerUnRegistro($sqlstr, $params);
    }

    public static function ingresarPrdCarrito($id, $nombre, $cantidad, $precio, $imagen) {
        $sqlstr = "INSERT INTO carritoCompras (CrtID, CrtNombre, CrtCantidad, CrtPrecio, CrtImagen, CrtIngreso) values (:CrtID, :CrtNombre, :CrtCantidad, :CrtPrecio, :CrtImagen, NOW());";

        $params = [
            "CrtID" => $id,
            "CrtNombre" => $nombre,
            "CrtCantidad" => $cantidad,
            "CrtPrecio" => $precio,
            "CrtImagen" => $imagen,
        ];

        return self::executeNonQuery($sqlstr, $params);
    }

    public static function actualizarPrdCarrito($id, $nombre, $cantidad, $precio, $imagen) {
        $sqlstr = "UPDATE carritoCompras SET CrtNombre = :CrtNombre, CrtCantidad = :CrtCantidad, CrtPrecio = :CrtPrecio, CrtImagen = :CrtImagen WHERE CrtID = :CrtID;";
        
        $params = [
            "CrtNombre" => $nombre,
            "CrtCantidad" => $cantidad,
            "CrtPrecio" => $precio,
            "CrtImagen" => $imagen,
            "CrtID" => $id
        ];

        return self::executeNonQuery($sqlstr, $params);
    }

    public static function eliminarPrdCarrito($id) {
        $sqlstr = "DELETE FROM carritoCompras WHERE CrtID = :CrtID;";
        $params = ["CrtID" => $id];

        return self::executeNonQuery($sqlstr, $params);
    }
}