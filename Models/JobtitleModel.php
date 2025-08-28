<?php
class JobtitleModel extends Mysql
{
    private $id;
    private $name;
    private $description;
    private $status;

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Obtiene todos los títulos profesionales
     */
    public function select_jobtitles(): array
    {
        $sql = "SELECT * FROM tb_job_title ORDER BY id DESC";
        $request = $this->select_all($sql);
        return $request;
    }

    /**
     * Inserta un nuevo título profesional
     */
    public function insert_jobtitle(string $name, string $description): int
    {
        $sql = "INSERT INTO tb_job_title (name, description, status, dateRegistration) VALUES (?, ?, 'ACTIVO', NOW())";
        $arrData = [$name, $description];
        $request = $this->insert($sql, $arrData);
        return $request;
    }

    /**
     * Obtiene un título por su nombre (para validar duplicados)
     */
    public function get_jobtitle_by_name(string $name)
    {
        $sql = "SELECT * FROM tb_job_title WHERE name = ?";
        $arrData = [$name];
        return $this->select($sql, $arrData);
    }

    /**
     * Obtiene un título por su ID
     */
    public function select_jobtitle_by_id(int $id)
    {
        $sql = "SELECT * FROM tb_job_title WHERE id = ?";
        $arrData = [$id];
        return $this->select($sql, $arrData);
    }

     /**
     * Obtiene los detalles de una jobtitle por su ID.
     *
     * @param int $id ID de jobtitle
     * @return array Arreglo con los datos completos de la jobtitle
     */
    public function select_detail_jobtitle(int $id): array
    {
        $this->id = $id;

        $sql = "SELECT 
                id,
                name,
                description,
                status,
                dateRegistration,
                dateUpdate
            FROM tb_job_title
            WHERE id = ?";

        $arrValue = array($this->id);
        $request = $this->select($sql, $arrValue);
        return $request;
    }

    /**
     * Actualiza un título profesional existente
     */
    public function update_jobtitle(int $id, string $name, string $description, string $status): bool
    {
        $sql = "UPDATE tb_job_title 
            SET name = ?, description = ?, status = ?, dateUpdate = NOW() 
            WHERE id = ?";
        $arrData = [$name, $description, $status, $id];
        return $this->update($sql, $arrData);
    }

    /**
     * Elimina un título profesional por su ID
     */
    public function delete_jobtitle(int $id): bool
    {
        $sql = "DELETE FROM tb_job_title WHERE id = ?";
        $arrData = [$id];
        return $this->delete($sql, $arrData);
    }

    public function get_jobtitle_by_name_all($name)
    {
        $sql = "SELECT * FROM tb_job_title WHERE name = ?";
        $arrData = [$name];
        $request = $this->select($sql, $arrData);
        return $request;
    }
}
