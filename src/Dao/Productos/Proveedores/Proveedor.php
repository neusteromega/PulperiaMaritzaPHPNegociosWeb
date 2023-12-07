<?php

namespace Dao\Productos\Proveedores;

use Dao\Table;

class Proveedor extends Table {
    public static function obtenerProveedores() {
        $sqlstr = "SELECT * FROM proveedores";

        return self::obtenerRegistros($sqlstr, []);
    }

    public static function obtenerProveedorPorId($id) {
        $sqlstr = "SELECT * FROM proveedores WHERE PrvID = :PrvID;";
        $params = ["PrvID" => $id];

        return self::obtenerUnRegistro($sqlstr, $params);
    }

    public static function ingresarProveedor($nombre, $estado, $imagen) {
        $sqlstr = "INSERT INTO proveedores (PrvNombre, PrvEstado, PrvCreacion, PrvImagen) values (:PrvNombre, :PrvEstado, NOW(), :PrvImagen);";
        
        $params = [
            "PrvNombre" => $nombre,
            "PrvEstado" => $estado,
            "PrvImagen" => $imagen
        ];

        return self::executeNonQuery($sqlstr, $params);
    }

    public static function actualizarProveedor($id, $nombre, $estado, $imagen) {
        $sqlstr = "UPDATE proveedores SET PrvNombre = :PrvNombre, PrvEstado = :PrvEstado, PrvImagen = :PrvImagen WHERE PrvID = :PrvID;";
    
        $params = [
            "PrvNombre" => $nombre,
            "PrvEstado" => $estado,
            "PrvImagen" => $imagen,
            "PrvID" => $id
        ];

        return self::executeNonQuery($sqlstr, $params);
    }

    public static function eliminarProveedor($id) {
        $sqlstr = "DELETE FROM proveedores WHERE PrvID = :PrvID;";
        $params = ["PrvID" => $id];

        return self::executeNonQuery($sqlstr, $params);
    }
}