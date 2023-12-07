<?php

namespace Dao\Cart;

class Cart extends \Dao\Table
{
    public static function getProductosDisponibles()
    {
        $sqlAllProductosActivos = "SELECT * from productos where PrdEstado in ('ACT');";
        $productosDisponibles = self::obtenerRegistros($sqlAllProductosActivos, array());

        //Sacar el stock de productos con carretilla autorizada
        $deltaAutorizada = \Utilities\Cart\CartFns::getAuthTimeDelta();
        $sqlCarretillaAutorizada = "select CrtID, sum(CrtCantidad) as reserved
            from carritoCompras where TIME_TO_SEC(TIMEDIFF(now(), CrtIngreso)) <= :delta
            group by CrtID;";
        $prodsCarretillaAutorizada = self::obtenerRegistros(
            $sqlCarretillaAutorizada,
            array("delta" => $deltaAutorizada)
        );
        //Sacar el stock de productos con carretilla no autorizada
        $deltaNAutorizada = \Utilities\Cart\CartFns::getUnAuthTimeDelta();
        $sqlCarretillaNAutorizada = "select CrtID, sum(CrtCantidad) as reserved
            from carretillaanom where TIME_TO_SEC(TIMEDIFF(now(), CrtIngreso)) <= :delta
            group by CrtID;";
        $prodsCarretillaNAutorizada = self::obtenerRegistros(
            $sqlCarretillaNAutorizada,
            array("delta" => $deltaNAutorizada)
        );
        $productosCurados = array();
        foreach ($productosDisponibles as $producto) {
            if (!isset($productosCurados[$producto["PrdID"]])) {
                $productosCurados[$producto["PrdID"]] = $producto;
            }
        }
        foreach ($prodsCarretillaAutorizada as $producto) {
            if (isset($productosCurados[$producto["PrdID"]])) {
                $productosCurados[$producto["PrdID"]]["PrdStock"] -= $producto["reserved"];
            }
        }
        foreach ($prodsCarretillaNAutorizada as $producto) {
            if (isset($productosCurados[$producto["PrdID"]])) {
                $productosCurados[$producto["PrdID"]]["PrdStock"] -= $producto["reserved"];
            }
        }
        $productosDisponibles = null;
        $prodsCarretillaAutorizada = null;
        $prodsCarretillaNAutorizada = null;
        return $productosCurados;
    }

    public static function getProductoDisponible($productId)
    {
        $sqlAllProductosActivos = "SELECT * from productos where PrdEstado in ('ACT') and PrdID=:PrdID;";
        $productosDisponibles = self::obtenerRegistros($sqlAllProductosActivos, array("PrdID" => $productId));

        //Sacar el stock de productos con carretilla autorizada
        $deltaAutorizada = \Utilities\Cart\CartFns::getAuthTimeDelta();
        $sqlCarretillaAutorizada = "select CrtID, sum(CrtCantidad) as reserved
            from carritoCompras where CrtID=:CrtID and TIME_TO_SEC(TIMEDIFF(now(), CrtIngreso)) <= :delta
            group by CrtID;";
        $prodsCarretillaAutorizada = self::obtenerRegistros(
            $sqlCarretillaAutorizada,
            array("CrtID" => $productId, "delta" => $deltaAutorizada)
        );
        //Sacar el stock de productos con carretilla no autorizada
        $deltaNAutorizada = \Utilities\Cart\CartFns::getUnAuthTimeDelta();
        $sqlCarretillaNAutorizada = "select CrtID, sum(CrtCantidad) as reserved
            from carretillaanom where CrtID = :CrtID and TIME_TO_SEC(TIMEDIFF(now(), CrtIngreso)) <= :delta
            group by CrtID;";
        $prodsCarretillaNAutorizada = self::obtenerRegistros(
            $sqlCarretillaNAutorizada,
            array("PrdID" => $productId, "delta" => $deltaNAutorizada)
        );
        $productosCurados = array();
        foreach ($productosDisponibles as $producto) {
            if (!isset($productosCurados[$producto["PrdID"]])) {
                $productosCurados[$producto["PrdID"]] = $producto;
            }
        }
        foreach ($prodsCarretillaAutorizada as $producto) {
            if (isset($productosCurados[$producto["PrdID"]])) {
                $productosCurados[$producto["PrdID"]]["PrdStock"] -= $producto["reserved"];
            }
        }
        foreach ($prodsCarretillaNAutorizada as $producto) {
            if (isset($productosCurados[$producto["PrdID"]])) {
                $productosCurados[$producto["PrdID"]]["PrdStock"] -= $producto["reserved"];
            }
        }
        $productosDisponibles = null;
        $prodsCarretillaAutorizada = null;
        $prodsCarretillaNAutorizada = null;
        return $productosCurados;
    }

    public static function getProducto($productId)
    {
        $sqlAllProductosActivos = "SELECT * from productos where PrdID=:PrdID;";
        $productosDisponibles = self::obtenerRegistros($sqlAllProductosActivos, array("PrdID" => $productId));
        return $productosDisponibles;
    }
}
