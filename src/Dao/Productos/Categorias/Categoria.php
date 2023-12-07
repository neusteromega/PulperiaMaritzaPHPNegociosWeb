<?php

namespace Dao\Productos\Categorias;

use Dao\Table;

class Categoria extends Table {
    public static function obtenerCategorias() {
        $sqlstr = "SELECT * FROM categorias";

        return self::obtenerRegistros($sqlstr, []);
    }

    public static function obtenerCategoriaPorId($id) {
        $sqlstr = "SELECT * FROM categorias WHERE CatID = :CatID;";
        $params = ["CatID" => $id];

        return self::obtenerUnRegistro($sqlstr, $params);
    }

    public static function ingresarCategoria($nombre, $estado, $imagen) {
        $sqlstr = "INSERT INTO categorias (CatNombre, CatEstado, CatCreacion, CatImagen) values (:CatNombre, :CatEstado, NOW(), :CatImagen);";
        
        $params = [
            "CatNombre" => $nombre,
            "CatEstado" => $estado,
            "CatImagen" => $imagen
        ];

        return self::executeNonQuery($sqlstr, $params);
    }

    public static function actualizarCategoria($id, $nombre, $estado, $imagen) {
        $sqlstr = "UPDATE categorias SET CatNombre = :CatNombre, CatEstado = :CatEstado, CatImagen = :CatImagen WHERE CatID = :CatID;";
    
        $params = [
            "CatNombre" => $nombre,
            "CatEstado" => $estado,
            "CatImagen" => $imagen,
            "CatID" => $id
        ];

        return self::executeNonQuery($sqlstr, $params);
    }

    public static function eliminarCategoria($id) {
        $sqlstr = "DELETE FROM categorias WHERE CatID = :CatID;";
        $params = ["CatID" => $id];

        return self::executeNonQuery($sqlstr, $params);
    }
}