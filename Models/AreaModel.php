<?php
class AreaModel extends Mysql
{
    private int $id;
    private int $management_tool_id;
    private string $name;
    private string $abbreviation;
    private string $comment;
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