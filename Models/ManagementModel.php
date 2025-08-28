<?php
class ManagementModel extends Mysql
{
    private int $id;
    private string $name;
    private string $file;
    private string $observation;
    private string $status;
    private string $create_at;
    private string $update_at;
    public function __construct()
    {
        parent::__construct();
    }
    /**
     * Metodo que se encarga de obtener todas las categorias
     * @return array
     */
}