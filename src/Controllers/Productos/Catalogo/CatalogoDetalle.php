<?php

namespace Controllers\Productos\Catalogo;

use Controllers\PublicController;
use Utilities\Site;
use Utilities\Validators;
use Views\Renderer;

class CatalogoDetalle extends PublicController {
    private $listUrl = "index.php?page=Productos-Catalogo-CatalogoList";
    private $viewData = [];
    private $error = [];
    private $producto = [
        "PrdID" => -1,
        "PrdNombre" => "",
        "PrdPrecio" => 0,
        "PrdImagen" => "",
        "PrdStock" => 0,
        "CatID" => -1,
        "PrvID" => -1,
        "PrdCreacion" => "",
        "PrdEstado" => "ACT",
        "Categoria" => "",
        "PrdCantidad" => 1
    ];
    private $categoria = [];
    //private $proveedor = [];

    public function run(): void {
        Site::addLink("public/css/product_detail.css");
        $this->init();

        if ($this->isPostBack()) {
            if ($this->validateFormData()) {
                $this->producto["PrdCantidad"] = $_POST["PrdCantidad"];
                $this->processAction();
            }
        }

        $this->prepareViewData();
        $this->render();
    }

    private function init() {
        if (isset($_GET["id"])) {
            $this->producto = \Dao\Productos\Producto::obtenerProductoPorId($_GET["id"]);
            $this->categoria = \Dao\Productos\Categorias\Categoria::obtenerCategoriaPorId($this->producto["CatID"]); 
        
            $this->producto["Categoria"] = $this->categoria["CatNombre"];
        }
    }

    private function validateFormData() {
        if (Validators::IsEmpty($_POST["PrdCantidad"])) {
            $this->error["prdcantidad_error"] = "El Campo es Requerido";
        }

        if (\Dao\Carrito\Carrito::obtenerPrdCarritoPorid($this->producto["PrdID"])) {
            $this->error["prdcarrito_error"] = "El Producto ya se Encuentra en el Carrito";
        }

        return count($this->error) == 0;
    }

    private function processAction() {
        if (\Dao\Carrito\Carrito::ingresarPrdCarrito($this->producto["PrdID"], $this->producto["PrdNombre"], $this->producto["PrdCantidad"], $this->producto["PrdPrecio"], $this->producto["PrdImagen"])) {
            Site::redirectToWithMsg($this->listUrl, "Producto agregado al carrito");
        }
    }

    private function prepareViewData() {
        $this->viewData["producto"] = $this->producto;

        foreach($this->error as $key => $error) {
            $this->viewData["producto"][$key] = $error;
        }
    }

    private function render() {
        Renderer::render("productos/catalogo/detalle", $this->viewData);
    }
}