<?php

namespace Controllers\Productos;

use Controllers\PrivateController;
use Dao\Productos\Producto;
use Views\Renderer;

class ProductosList extends PrivateController {
    public function run(): void {
        $dataView = array();
        $dataView["productos"] = Producto::obtenerProductos();
        $dataView["canView"] = $this->isFeatureAutorized("productoslist-dsp");
        $dataView["canInsert"] = $this->isFeatureAutorized("productoslist-ins");
        $dataView["canEdit"] = $this->isFeatureAutorized("productoslist-upd");
        $dataView["canDelete"] = $this->isFeatureAutorized("productoslist-del");

        Renderer::render('productos/lista', $dataView);
    }
}