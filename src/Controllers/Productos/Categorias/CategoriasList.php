<?php

namespace Controllers\Productos\Categorias;

use Controllers\PrivateController;
use Dao\Productos\Categorias\Categoria;
use Views\Renderer;

class CategoriasList extends PrivateController {
    public function run(): void {
        $dataView = array();
        $dataView["categorias"] = Categoria::obtenerCategorias();
        $dataView["canView"] = $this->isFeatureAutorized("categoriaslist-dsp");
        $dataView["canInsert"] = $this->isFeatureAutorized("categoriaslist-ins");
        $dataView["canEdit"] = $this->isFeatureAutorized("categoriaslist-upd");
        $dataView["canDelete"] = $this->isFeatureAutorized("categoriaslist-del");

        Renderer::render('productos/categorias/lista', $dataView);
    }
}