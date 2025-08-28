<?php
class LogOut extends Controllers
{
    public function __construct()
    {
        session_start(config_sesion());
        registerLog("Cierre de sesion", "El usuario " . $_SESSION['login_info']["fullName"] . " ah cerrado sesion en el sistema", 2, $_SESSION['login_info']['idUser']);
        $urlReturn = base_url() . "/login";
        session_unset();
        session_destroy();
        header("Location: " . $urlReturn);
    }
}