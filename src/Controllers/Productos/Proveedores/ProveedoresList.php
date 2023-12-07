<?php

namespace Controllers\Productos\Proveedores;

use Controllers\PrivateController;
use Dao\Productos\Proveedores\Proveedor;
use Views\Renderer;

class ProveedoresList extends PrivateController {
    public function run(): void {
        $dataView = array();
        $dataView["proveedores"] = Proveedor::obtenerProveedores();
        $dataView["canView"] = $this->isFeatureAutorized("proveedoreslist-dsp");
        $dataView["canInsert"] = $this->isFeatureAutorized("proveedoreslist-ins");
        $dataView["canEdit"] = $this->isFeatureAutorized("proveedoreslist-upd");
        $dataView["canDelete"] = $this->isFeatureAutorized("proveedoreslist-del");

        Renderer::render('productos/proveedores/lista', $dataView);
    }
}