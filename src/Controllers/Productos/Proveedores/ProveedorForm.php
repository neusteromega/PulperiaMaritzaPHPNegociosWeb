<?php

namespace Controllers\Productos\Proveedores;

use Controllers\PrivateController;
use Dao\Productos\Proveedores\Proveedor as ProveedorDAO;
use Utilities\Site;
use Utilities\Validators;
use Views\Renderer;

class ProveedorForm extends PrivateController {
    private $listUrl = "index.php?page=Productos-Proveedores-ProveedoresList";
    private $mode = 'INS';
    private $viewData = [];
    private $error = [];
    private $xss_token = '';
    private $modes = [
        "INS" => "Creando Nuevo Proveedor",
        "UPD" => "Editando %s (%s)",
        "DEL" => "Eliminando %s (%s)",
        "DSP" => "Detalle de %s (%s)"
    ];
    private $proveedor = [
        "PrvID" => -1,
        "PrvNombre" => "",
        "PrvEstado" => "ACT",
        "PrvCreacion" => "",
        "PrvImagen" => ""
    ];

    public function run(): void {
        $this->init();

        if ($this->isPostBack()) {
            if ($this->validateFormData()) {
                $this->proveedor["PrvNombre"] = $_POST["PrvNombre"];
                $this->proveedor["PrvEstado"] = $_POST["PrvEstado"];
                //$this->proveedor["PrvImagen"] = $_POST["PrvImagen"];
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

                if ($this->mode !== "INS") {
                    if (isset($_GET["id"])) {
                        $this->proveedor = ProveedorDAO::obtenerProveedorPorId(intval($_GET["id"]));
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

            if ($_SESSION["xss_token_proveedor_form"] !== $this->xss_token) {
                error_log("ProveedorForm: Validación de XSS falló");
                $this->handleError("Error al procesar la petición");
                return false;
            }
        } else {
            error_log("ProveedorForm: Validación de XSS falló");
            $this->handleError("Error al procesar la petición");
            return false;
        }

        if (Validators::IsEmpty($_POST["PrvNombre"])) {
            $this->error["prvnombre_error"] = "El Campo es Requerido";
        }

        if (!in_array($_POST["PrvEstado"], ["INA", "ACT"])) {
            $this->error["prvestado_error"] = "El Estado del Proveedor es Inválido";
        }

        return count($this->error) == 0;
    }

    private function processAction() {
        switch($this->mode) {
            case 'INS':
                if (ProveedorDAO::ingresarProveedor($this->proveedor["PrvNombre"], $this->proveedor["PrvEstado"], "public/imgs/proveedores/logo_cerveceria.png")) {
                    Site::redirectToWithMsg($this->listUrl, "Proveedor registrado exitosamente");
                }
                break;
            case 'UPD':
                if (ProveedorDAO::actualizarProveedor($this->proveedor["PrvID"], $this->proveedor["PrvNombre"], $this->proveedor["PrvEstado"], "public/imgs/proveedores/logo_cerveceria.png")) {
                    Site::redirectToWithMsg($this->listUrl, "Proveedor actualizado exitosamente");
                }
                break;
            case 'DEL':
                if (ProveedorDAO::eliminarProveedor($this->proveedor["PrvID"])) {
                    Site::redirectToWithMsg($this->listUrl, "Proveedor eliminado exitosamente");
                }
                break;
        }
    }

    private function prepareViewData() {
        $this->viewData["mode"] = $this->mode;
        $this->viewData["proveedor"] = $this->proveedor;

        if ($this->mode == "INS") {
            $this->viewData["modedsc"] = $this->modes[$this->mode];
        } else {
            $this->viewData["modedsc"] = sprintf(
                $this->modes[$this->mode],
                $this->proveedor["PrvNombre"],
                $this->proveedor["PrvID"]
            );
        }

        $this->viewData["proveedor"][$this->proveedor["PrvEstado"]."_selected"] = 'selected';
        
        foreach($this->error as $key => $error) {
            $this->viewData["proveedor"][$key] = $error;
        }

        $this->viewData["readonly"] = in_array($this->mode, ["DSP", "DEL"]) ? 'readonly' : '';
        $this->viewData["showConfirm"] = $this->mode !== "DSP";

        $this->xss_token = md5("proveedorForm".date('Ymdhisu'));
        $_SESSION["xss_token_proveedor_form"] = $this->xss_token;
        $this->viewData["xss_token"] = $this->xss_token;
    }

    private function render() { 
        Renderer::render("productos/proveedores/form", $this->viewData);
    }

    private function handleError($errMsg) {
        Site::redirectToWithMsg($this->listUrl, $errMsg);
    }
}