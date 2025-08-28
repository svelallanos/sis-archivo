<?php

class Dashboard extends Controllers
{
    public function __construct()
    {
        isSession();
        parent::__construct();
    }

    public function dashboard()
    {
        $data['page_id'] = 2;
        $data['page_title'] = "Panel de control";
        $data['page_description'] = "Panel de control";
        $data['page_container'] = "Dashboard";
        $data['page_js_css'] = "dashboard";
        registerLog("Información de navegación", "El usuario entro a :" . $data['page_title'], 3, $_SESSION['login_info']['idUser']);
        $this->views->getView($this, "dashboard", $data);
    }


    public function resumenTarjetas()
    {
        $model = new DashboardModel();
        $data = $model->getResumenTarjetas();

        header('Content-Type: application/json');
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
}
