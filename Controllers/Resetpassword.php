<?php
class Resetpassword extends Controllers
{
    public function __construct()
    {
        parent::__construct();
    }

    public function resetpassword()
    {
        $data["page_title"] = "Restablecer Contraseña";
        $data["page_js_css"] = "resetpassword";
        $this->views->getView($this, "resetpassword", $data);
    }

    public function changePassword()
    {
        if (!$_POST) {
            registerLog("Ocurrio un error inesperado", "No se recibió de forma correcta la solicitud", 1);
            toJson([
                "title" => "Error inesperado",
                "message" => "No se recibió la solicitud correctamente",
                "type" => "error",
                "status" => false
            ]);
        }

        $pass1 = strClean($_POST["password1"]);
        $pass2 = strClean($_POST["password2"]);
        $code = strClean($_POST["code"]);

        if (empty($pass1) || empty($pass2)) {
            registerLog("Campos obligatorios", "Ambas contraseñas deben ser completadas", 1);
            toJson([
                "title" => "Campos obligatorios",
                "message" => "Ambas contraseñas deben ser completadas",
                "type" => "warning",
                "status" => false
            ]);
        }

        if ($pass1 !== $pass2) {
            registerLog("Contraseñas diferentes", "Las contraseñas ingresadas no coinciden", 1);
            toJson([
                "title" => "Contraseñas diferentes",
                "message" => "Las contraseñas no coinciden",
                "type" => "error",
                "status" => false
            ]);
        }

        if (strlen($pass1) < 8) {
            registerLog("Contraseña muy corta", "La contraseña debe tener al menos 8 caracteres", 1);
            toJson([
                "title" => "Contraseña muy corta",
                "message" => "La contraseña debe tener al menos 8 caracteres",
                "type" => "warning",
                "status" => false
            ]);
        }

        if (empty($code)) {
            registerLog("Código faltante", "No se proporcionó un código para restablecer la contraseña", 1);
            toJson([
                "title" => "Código faltante",
                "message" => "Código inválido. Solicita uno nuevo.",
                "type" => "error",
                "status" => false
            ]);
        }

        // Buscar el token
        $token = $this->model->getTokenData($code);

        if (!$token) {
            registerLog("Código inválido", "El código ingresado no existe en la base de datos", 1);
            toJson([
                "title" => "Código inválido",
                "message" => "El código ya fue usado o no es válido",
                "type" => "error",
                "status" => false
            ]);
        }

        $emailEncrypted = $token["email"];
        $encryptedPass = encryption($pass1);

        $result = $this->model->updateUserPassword($emailEncrypted, $encryptedPass);

        if (!$result) {
            registerLog("Error al actualizar la contraseña", "No se pudo cambiar la contraseña del usuario", 1);
            toJson([
                "title" => "Error al actualizar",
                "message" => "No se pudo cambiar la contraseña",
                "type" => "error",
                "status" => false
            ]);
        } else {
            registerLog("Contraseña actualizada", "La contraseña del usuario se cambió correctamente", 1);
            toJson([
                "title" => "Contraseña actualizada",
                "message" => "Tu contraseña se cambió correctamente",
                "type" => "success",
                "status" => true,
                "redirection" => base_url() . "/login"
            ]);
        }
    }
}
