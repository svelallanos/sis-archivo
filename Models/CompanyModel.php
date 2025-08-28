<?php
class CompanyModel extends Mysql
{
    private int $id;
    private string $title;
    private string $subtitle;
    private string $description;
    private string $mail;
    private string $ruc;
    private string $address;
    private string $phone;
    private string $status;
    private string $dateRegistration;
    private string $dateUpdate;
    public function __construct()
    {
        parent::__construct();
    }
    /**
     * Metodo que se encarga de obtener todas las categorias
     * @return array
     */
    public function select_company()
    {
        $sql = "SELECT*FROM tb_company AS tbco
                ORDER BY tbco.dateRegistration DESC; ";
        $request = $this->select_all($sql);
        return $request;
    }
    /**
     * Metodo que se encarga de registrar una empresa
     * @param mixed $title
     * @param mixed $subtitle
     * @param mixed $description
     * @param mixed $mail
     * @param mixed $ruc
     * @param mixed $address
     * @param mixed $phone
     * @return bool|int|string
     */
    public function insert_company($title, $subtitle, $description, $mail, $ruc, $address, $phone)
    {
        $sql = "INSERT INTO tb_company (title, subtitle, description, mail, ruc, address, phone) VALUES (?,?,?,?,?,?,?)";
        $arrData = array($title, $subtitle, $description, $mail, $ruc, $address, $phone);
        $request = $this->insert($sql, $arrData);
        return $request;
    }
    /**
     * Metodo que busca la empresa por nombre, esto es usará para validar que no se ingrese una empresa con el mismo nombre
     * @param string $title
     * @return array
     */
    public function select_for_title_company(string $title)
    {
        $this->title = $title;
        $sql = "SELECT*FROM tb_company AS tbco WHERE tbco.`title`=?;";
        $arrValue = array($this->title);
        $request = $this->select($sql, $arrValue);
        return $request;
    }
    /**
     * Metodo que te permite consultar una de las empresas por el id
     * @param int $id
     * @return array
     */
    public function select_company_by_id(int $id)
    {
        $this->id = $id;
        $sql = "SELECT*FROM tb_company AS tbco WHERE tbco.id=?";
        $arrValue = array($this->id);
        $request = $this->select($sql, $arrValue);
        return $request;
    }
    /**
     * Metodo que se encarga de actualizar una empresa
     * @param int $id
     * @param mixed $title
     * @param mixed $subtitle
     * @param mixed $description
     * @param mixed $mail
     * @param mixed $ruc
     * @param mixed $address
     * @param mixed $phone
     * @param string $status
     * @return bool
     */
    public function update_company(int $id, string $title, string $subtitle, string $description, string $mail, string $ruc, string $address, string $phone, string $status)
    {
        $this->id = $id;
        $this->title = $title;
        $this->subtitle = $subtitle;
        $this->description = $description;
        $this->mail = $mail;
        $this->ruc = $ruc;
        $this->address = $address;
        $this->phone = $phone;
        $this->status = $status;
        $sql = "UPDATE tb_company SET title=?, subtitle=?, description=?, mail=?, ruc=?, address=?, phone=?, status=? WHERE id=?";
        $arrData = array($this->title, $this->subtitle, $this->description, $this->mail, $this->ruc, $this->address, $this->phone, $this->status, $this->id);
        $request = $this->update($sql, $arrData);
        return $request;
    }
    /**
     * Meotodo que se encarga de eliminar una categoria
     * @param int $id
     * @return bool
     */
    public function delete_company(int $id)
    {
        $this->id = $id;
        $sql = "DELETE FROM tb_company WHERE id=?";
        $arrData = array($this->id);
        $request = $this->delete($sql, $arrData);
        return $request;
    }
}