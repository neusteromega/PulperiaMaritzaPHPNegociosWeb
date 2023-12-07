<?php
namespace Controllers\Carrito;

use Controllers\PublicController;
use Dao\Carrito\Carrito as CarritoDAO;
use Utilities\Site;
use Views\Renderer;

class Carrito extends PublicController {
    private $listUrl = "index.php?page=Carrito-Carrito";
    private $dataView = [];
    private $carrito = [
        "CrtID" => -1,
        "CrtNombre" => "",
        "CrtCantidad" => 1,
        "CrtPrecio" => 0,
        "CrtImagen" => "",
        "CrtIngreso" => "",
        "CrtTotal" => 0
    ];
    private $totales = [
        "Subtotal" => 0,
        "ISV" => 0,
        "Total" => 0
    ];

    public function run(): void {
        Site::addLink("public/css/cart.css");

        $this->carrito = CarritoDAO::obtenerCarrito();
        $this->totals();

        if (isset($_GET["id"])) {
            if ($this->isPostBack()) {
                if (\Dao\Carrito\Carrito::eliminarPrdCarrito($_GET["id"])) {
                    Site::redirectToWithMsg($this->listUrl, "Producto eliminado del carrito");
                }
            }
        }

        $this->dataView["carrito"] = $this->carrito;
        $this->dataView["totales"] = $this->totales;

        Renderer::render('carrito/carrito', $this->dataView);
    }

    private function totals() {
        $subtotal = 0;

        foreach($this->carrito as $key => $value) {
            $precio = floatval($value["CrtPrecio"]);
            $total = $precio * $value["CrtCantidad"];

            $this->carrito[$key]["CrtTotal"] = number_format($total, 2, '.', '');
            $subtotal += $this->carrito[$key]["CrtTotal"];
        }

        $this->totales["Subtotal"] = number_format($subtotal, 2, '.', '');
        $this->totales["ISV"] = number_format($this->totales["Subtotal"] * 0.15, 2, '.', '');
        $this->totales["Total"] =  number_format($this->totales["Subtotal"] + $this->totales["ISV"], 2, '.', '');
    }
}