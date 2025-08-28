<?php
class Sendcode extends Controllers
{
    public function __construct()
    {
        parent::__construct(); // Aquí intenta cargar automáticamente sendCodeModel
    }

    public function sendcode()
    {
        $data["page_title"] = "Verificar Código";
        $data["page_js_css"] = "sendcode";
        $this->views->getView($this, "sendcode", $data);
    }

    public function verifyCode()
    {
        if (!$_POST) {
            registerLog("Ocurrio un error inesperado", "No se recibio de forma correcta la solicitud", 1);
            toJson([
                "title" => "Error inesperado",
                "message" => "No se recibió la solicitud correctamente",
                "type" => "error",
                "status" => false
            ]);
        }

        $codigo = strClean($_POST["codigo"]);

        $token = $this->model->getTokenByCode($codigo);

        if (!$token) {
            registerLog("Código inválido", "El código ingresado no existe en la base de datos", 1);
            toJson([
                "title" => "Código inválido",
                "message" => "El código ingresado no es válido",
                "type" => "error",
                "status" => false
            ]);
        }

        if ($token["status"] != "Activo") {
            registerLog("Código inactivo", "El código ingresado ya fue usado o está inactivo", 1);
            toJson([
                "title" => "Código inválido",
                "message" => "El código ya fue usado o está inactivo",
                "type" => "error",
                "status" => false
            ]);
        }

        if (strtotime($token["expires_at"]) < time()) {
            registerLog("Código expirado", "El código ingresado ha expirado", 1);
            $this->model->updateTokenStatus($codigo, "Expirado");
            toJson([
                "title" => "Código expirado",
                "message" => "El código ha expirado. Solicita uno nuevo.",
                "type" => "warning",
                "status" => false
            ]);
        }

        $this->model->updateTokenStatus($codigo, "Usado");

        toJson([
            "title" => "Verificación exitosa",
            "message" => "Código válido. Redirigiendo...",
            "type" => "success",
            "status" => true,
            "redirection" => base_url() . "/resetpassword?code=" . $codigo
        ]);
    }
}
