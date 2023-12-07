<?php

namespace Controllers\Productos;

use Controllers\PrivateController;
use Dao\Productos\Producto as ProductoDAO;
use Utilities\Site;
use Utilities\Validators;
use Views\Renderer;

class ProductoForm extends PrivateController {
    private $listUrl = "index.php?page=Productos-ProductosList";
    private $mode = 'INS';
    private $viewData = [];
    private $error = [];
    private $xss_token = '';
    private $modes = [
        "INS" => "Creando Nuevo Producto",
        "UPD" => "Editando %s (%s)",
        "DEL" => "Eliminando %s (%s)",
        "DSP" => "Detalle de %s (%s)"
    ];
    private $producto = [
        "PrdID" => -1,
        "PrdNombre" => "",
        "PrdPrecio" => 0,
        "PrdImagen" => "",
        "PrdStock" => 0,
        "CatID" => -1,
        "PrvID" => -1,
        "PrdCreacion" => "",
        "PrdEstado" => "ACT"
    ];
    private $categorias = [];
    private $proveedores = [];
    private $idsCategorias = [];
    private $idsProveedores = [];

    public function run(): void {
        $this->init();

        if ($this->isPostBack()) {
            if ($this->validateFormData()) {
                $this->producto["PrdNombre"] = $_POST["PrdNombre"];
                $this->producto["PrdPrecio"] = $_POST["PrdPrecio"];
                $this->producto["PrdStock"] = $_POST["PrdStock"];
                $this->producto["PrdEstado"] = $_POST["PrdEstado"];
                $this->producto["PrdImagen"] = $_POST["PrdImagen"];
                $this->producto["CatID"] = $_POST["CatID"];
                $this->producto["PrvID"] = $_POST["PrvID"];
                //$this->producto["PrdImagen"] = $_POST["PrdImagen"];

                $this->processAction();
            }
        }

        $this->prepareViewData();
        $this->render();
    }

    private function init() {
        if (isset($_GET["mode"])) {
            if (isset($this->modes[$_GET["mode"]])) {
                $this->mode = $_GET["mode"];

                $this->categorias = \Dao\Productos\Categorias\Categoria::obtenerCategorias(); //Obtenemos las categorías
                $this->proveedores = \Dao\Productos\Proveedores\Proveedor::obtenerProveedores(); //Obtenemos los proveedores
                $this->obtenerIdsCatPrv();

                if ($this->mode !== "INS") {
                    if (isset($_GET["id"])) {
                        $this->producto = ProductoDAO::obtenerProductoPorId(intval($_GET["id"]));
                    }
                }
            } else {
                $this->handleError("Oops, el programa no encuentra el modo solicitado");
            }
        } else {
            $this->handleError("Oops, el programa falló, intente de nuevo");
        }
    }

    private function validateFormData() {
        if (isset($_POST["xss_token"])) {
            $this->xss_token = $_POST["xss_token"];

            if ($_SESSION["xss_token_producto_form"] !== $this->xss_token) {
                error_log("ProductoForm: Validación de XSS falló");
                $this->handleError("Error al procesar la petición");
                return false;
            }
        } else {
            error_log("ProductoForm: Validación de XSS falló");
            $this->handleError("Error al procesar la petición");
            return false;
        }

        if (Validators::IsEmpty($_POST["PrdNombre"])) {
            $this->error["prdnombre_error"] = "El Campo es Requerido";
        }

        if (Validators::IsEmpty($_POST["PrdPrecio"])) {
            $this->error["prdprecio_error"] = "El Campo es Requerido";
        }

        if (Validators::IsEmpty($_POST["PrdStock"])) {
            $this->error["prdstock_error"] = "El Campo es Requerido";
        }

        if (Validators::IsEmpty($_POST["PrdImagen"])) {
            $this->error["prdimagen_error"] = "El Campo es Requerido";
        }

        if (!in_array($_POST["PrdEstado"], ["INA", "ACT"])) {
            $this->error["prdestado_error"] = "El Estado del Producto es Inválido";
        }

        if (!in_array($_POST["CatID"], $this->idsCategorias)) {
            $this->error["catid_error"] = "La Categoría es Inválida";
        }

        if (!in_array($_POST["PrvID"], $this->idsProveedores)) {
            $this->error["prvid_error"] = "El Proveedor es Inválido";
        }

        return count($this->error) == 0;
    }

    private function processAction() {
        switch($this->mode) {
            case 'INS':
                if (ProductoDAO::ingresarProducto($this->producto["PrdNombre"], $this->producto["PrdPrecio"], $this->producto["PrdImagen"], $this->producto["PrdStock"], $this->producto["CatID"], $this->producto["PrvID"], $this->producto["PrdEstado"])) {
                    Site::redirectToWithMsg($this->listUrl, "Producto registrado exitosamente");
                }
                break;
            case 'UPD':
                if (ProductoDAO::actualizarProducto($this->producto["PrdID"], $this->producto["PrdNombre"], $this->producto["PrdPrecio"], $this->producto["PrdImagen"], $this->producto["PrdStock"], $this->producto["CatID"], $this->producto["PrvID"], $this->producto["PrdEstado"])) {
                    Site::redirectToWithMsg($this->listUrl, "Producto actualizado exitosamente");
                }
                break;
            case 'DEL':
                if (ProductoDAO::eliminarProducto($this->producto["PrdID"])) {
                    Site::redirectToWithMsg($this->listUrl, "Producto eliminado exitosamente");
                }
                break;
        }
    }

    private function prepareViewData() {
        $this->viewData["mode"] = $this->mode;
        $this->viewData["producto"] = $this->producto;

        $this->viewData["categorias"] = \Utilities\ArrUtils::objectArrToOptionsArray(
            $this->categorias,
            "CatID", 
            "CatNombre", 
            "CatID", 
            $this->producto["CatID"]
        );

        $this->viewData["proveedores"] = \Utilities\ArrUtils::objectArrToOptionsArray(
            $this->proveedores,
            "PrvID", 
            "PrvNombre", 
            "PrvID", 
            $this->producto["PrvID"]
        );

        if ($this->mode == "INS") {
            $this->viewData["modedsc"] = $this->modes[$this->mode];
        } else {
            $this->viewData["modedsc"] = sprintf(
                $this->modes[$this->mode],
                $this->producto["PrdNombre"],
                $this->producto["PrdID"]
            );
        }

        $this->viewData["producto"][$this->producto["PrdEstado"]."_selected"] = 'selected';

        foreach($this->error as $key => $error) {
            $this->viewData["producto"][$key] = $error;
        }

        $this->viewData["readonly"] = in_array($this->mode, ["DSP", "DEL"]) ? 'readonly' : '';
        $this->viewData["showConfirm"] = $this->mode !== "DSP";

        $this->xss_token = md5("productoForm".date('Ymdhisu'));
        $_SESSION["xss_token_producto_form"] = $this->xss_token;
        $this->viewData["xss_token"] = $this->xss_token;
    }

    private function render() {
        Renderer::render("productos/form", $this->viewData);
    }

    private function handleError($errMsg) {
        Site::redirectToWithMsg($this->listUrl, $errMsg);
    }

    private function obtenerIdsCatPrv() {
        foreach ($this->categorias as $categoria) {
            $this->idsCategorias[] = $categoria["CatID"];
        }

        foreach ($this->proveedores as $proveedor) {
            $this->idsProveedores[] = $proveedor["PrvID"];
        }
    }
}