<?php

namespace Controllers;

use Views\Renderer;
use Dao\Productos\Categorias\Categoria as CategoriasDAO;
use Dao\Productos\Proveedores\Proveedor as ProveedoresDAO;
use Dao\Productos\Producto as ProductosDAO;

class Index extends PublicController
{
    public function run() :void
    {
        $viewData = array();
        $viewData["categorias"] = CategoriasDAO::obtenerCategorias();
        $viewData["proveedores"] = ProveedoresDAO::obtenerProveedores();
        $viewData["productos"] = ProductosDAO::obtenerProductos();
        Renderer::render("landing", $viewData);
    }
}
?>