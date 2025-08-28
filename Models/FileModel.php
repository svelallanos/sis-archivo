<?php
class FileModel extends Mysql
{
    private int $id;
    private string $table;
    private string $name;
    private string $type;
    private float $size;

    public function __construct()
    {
        parent::__construct();
    }
    /**
     * Metodo que se encarga se consultar a la tabla de file mediante el id y la tabla
     * @param int $id
     * @param string $table
     */
    public function select_file_search_for_id_and_table(int $id, string $table)
    {
        $this->id = $id;
        $this->table = $table;
        $sql = "SELECT*FROM tb_file AS tbl WHERE tbl.id_code=? AND tbl.`table`=?;";
        $arrValues = array($this->id, $this->table);
        $request = $this->select($sql, $arrValues);
        return $request;
    }
    /**
     * Metodo que se encarga de registrar un nuevo archivo
     * @param int  $id
     * @param string $table
     * @param string $name
     * @param string $type
     * @param float $size
     * @return void
     */
    public function insert_file(int $id, string $table, string $name, string $type, float $size)
    {
        $this->id = $id;
        $this->table = $table;
        $this->name = $name;
        $this->type = $type;
        $this->size = $size;
        $sql = "INSERT INTO `tb_file` (`id_code`, `table`, `name`, `type`, `size`) VALUES (?, ?, ?, ?, ?);";
        $arrValues = array($this->id, $this->table, $this->name, $this->type, $this->size);
        $request = $this->insert($sql, $arrValues);
        return $request;

    }
}
