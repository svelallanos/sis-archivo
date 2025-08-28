<?php
class DashboardModel extends Mysql
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getResumenTarjetas()
    {
        $sqlClientes = "SELECT COUNT(*) AS total FROM tb_customer";
        $sqlTrabajadores = "SELECT COUNT(*) AS total FROM tb_worker";
        $sqlProveedores = "SELECT COUNT(*) AS total FROM tb_supplier";

        $clientes = $this->select($sqlClientes);
        $trabajadores = $this->select($sqlTrabajadores);
        $proveedores = $this->select($sqlProveedores);

        return [
            [
                "titulo" => "Clientes",
                "valor" => $clientes['total'],
                "color" => "primary"
            ],
            [
                "titulo" => "Trabajadores",
                "valor" => $trabajadores['total'],
                "color" => "danger"
            ],
            [
                "titulo" => "Proveedores",
                "valor" => $proveedores['total'],
                "color" => "info"
            ]
        ];
    }
}
