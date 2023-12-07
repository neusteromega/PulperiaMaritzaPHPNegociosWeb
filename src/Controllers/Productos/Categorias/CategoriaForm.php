<?php

namespace Controllers\Productos\Categorias;

use Controllers\PrivateController;
use Dao\Productos\Categorias\Categoria as CategoriaDAO;
use Utilities\Site;
use Utilities\Validators;
use Views\Renderer;

class CategoriaForm extends PrivateController {
    private $listUrl = "index.php?page=Productos-Categorias-CategoriasList";
    private $mode = 'INS';
    private $viewData = [];
    private $error = [];
    private $xss_token = '';
    private $modes = [
        "INS" => "Creando Nueva Categoría",
        "UPD" => "Editando %s (%s)",
        "DEL" => "Eliminando %s (%s)",
        "DSP" => "Detalle de %s (%s)"
    ];
    private $categoria = [
        "CatID" => -1,
        "CatNombre" => "",
        "CatEstado" => "ACT",
        "CatCreacion" => "",
        "CatImagen" => ""
    ];

    public function run(): void {
        $this->init();

        if ($this->isPostBack()) {
            if ($this->validateFormData()) {
                $this->categoria["CatNombre"] = $_POST["CatNombre"];
                $this->categoria["CatEstado"] = $_POST["CatEstado"];
                //$this->categoria["CatImagen"] = $_POST["CatImagen"];
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
                        $this->categoria = CategoriaDAO::obtenerCategoriaPorId(intval($_GET["id"]));
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

            if ($_SESSION["xss_token_categoria_form"] !== $this->xss_token) {
                error_log("CategoriaForm: Validación de XSS falló");
                $this->handleError("Error al procesar la petición");
                return false;
            }
        } else {
            error_log("CategoriaForm: Validación de XSS falló");
            $this->handleError("Error al procesar la petición");
            return false;
        }

        if (Validators::IsEmpty($_POST["CatNombre"])) {
            $this->error["catnombre_error"] = "El Campo es Requerido";
        }

        if (!in_array($_POST["CatEstado"], ["INA", "ACT"])) {
            $this->error["catestado_error"] = "El Estado de la Categoría es Inválido";
        }

        return count($this->error) == 0;
    }

    private function processAction() {
        switch($this->mode) {
            case 'INS':
                if (CategoriaDAO::ingresarCategoria($this->categoria["CatNombre"], $this->categoria["CatEstado"], "public/imgs/categorias/cat_abarroteria.png")) {
                    Site::redirectToWithMsg($this->listUrl, "Categoría registrada exitosamente");
                }
                break;
            case 'UPD':
                if (CategoriaDAO::actualizarCategoria($this->categoria["CatID"], $this->categoria["CatNombre"], $this->categoria["CatEstado"], "public/imgs/categorias/cat_abarroteria.png")) {
                    Site::redirectToWithMsg($this->listUrl, "Categoría actualizada exitosamente");
                }
                break;
            case 'DEL':
                if (CategoriaDAO::eliminarCategoria($this->categoria["CatID"])) {
                    Site::redirectToWithMsg($this->listUrl, "Categoría eliminada exitosamente");
                }
                break;
        }
    }

    private function prepareViewData() {
        $this->viewData["mode"] = $this->mode;
        $this->viewData["categoria"] = $this->categoria;

        if ($this->mode == "INS") {
            $this->viewData["modedsc"] = $this->modes[$this->mode];
        } else {
            $this->viewData["modedsc"] = sprintf(
                $this->modes[$this->mode],
                $this->categoria["CatNombre"],
                $this->categoria["CatID"]
            );
        }

        $this->viewData["categoria"][$this->categoria["CatEstado"]."_selected"] = 'selected';
    
        foreach($this->error as $key => $error) {
            $this->viewData["categoria"][$key] = $error;
        }

        $this->viewData["readonly"] = in_array($this->mode, ["DSP", "DEL"]) ? 'readonly' : '';
        $this->viewData["showConfirm"] = $this->mode !== "DSP";

        $this->xss_token = md5("categoriaForm".date('Ymdhisu'));
        $_SESSION["xss_token_categoria_form"] = $this->xss_token;
        $this->viewData["xss_token"] = $this->xss_token;
    }

    private function render() {
        Renderer::render("productos/categorias/form", $this->viewData);
    }

    private function handleError($errMsg) {
        Site::redirectToWithMsg($this->listUrl, $errMsg);
    }
}