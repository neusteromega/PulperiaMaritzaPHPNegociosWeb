<?php
namespace Controllers\Productos\Catalogo;

use Controllers\PublicController;
use Dao\Productos\Producto;
use Utilities\Site;
use Views\Renderer;

class CatalogoList extends PublicController {
    private $listUrl = "index.php?page=Productos-Catalogo-CatalogoList";
    private $dataView = [];
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
    ];

    public function run(): void {
        Site::addLink("public/css/products.css");
        $this->init();

        if ($this->isPostBack()) {
            $this->validateFormData();
            
            if (\Dao\Carrito\Carrito::ingresarPrdCarrito($this->producto["PrdID"], $this->producto["PrdNombre"], 1, $this->producto["PrdPrecio"], $this->producto["PrdImagen"])) {
                Site::redirectToWithMsg($this->listUrl, "Producto agregado al carrito");
            }
        }

        $this->dataView["catalogo"] = $this->producto;

        Renderer::render('productos/catalogo/lista', $this->dataView);
    }

    private function init() {
        $this->producto = Producto::obtenerProductos();

        if (isset($_GET["id"])) {
            $this->producto = Producto::obtenerProductoPorId($_GET["id"]);
        }
    }

    private function validateFormData() {
        if (\Dao\Carrito\Carrito::obtenerPrdCarritoPorid($this->producto["PrdID"])) {
            Site::redirectToWithMsg($this->listUrl, "El Producto ya se Encuentra en el Carrito");
        }
    }
}