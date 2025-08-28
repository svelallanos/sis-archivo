<?php
class Management extends Controllers
{
    /**
     * Costructor que verifica que el usuario este logueado
     */
    public function __construct()
    {
        isSession();
        parent::__construct();
    }
    /**
     * Metodo que se encarga de cargar la vista de las empresas
     * @return void
     */
    public function management()
    {
        $data['page_id'] = 8;
        permissionInterface($data['page_id']);
        $data['page_title'] = "Gestión de Instrumentos";
        $data['page_description'] = "Gestión Documental";
        $data['page_container'] = "management";
        $data['page_js_css'] = "management";
        registerLog("Información de navegación", "El usuario entro a :" . $data['page_title'], 3, $_SESSION['login_info']['idUser']);
        $this->views->getView($this, "management", $data);
    }
    /**
     * Metodo que se encarga de cargar la vista de la categoria
     * @return void
     */
}
