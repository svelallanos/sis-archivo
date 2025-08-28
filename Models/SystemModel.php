<?php

class SystemModel extends Mysql
{
    private int $idConfiguration;
    private int $idDocumentInfo;
    private string $name;
    private string $description;
    private string $logo;
    private string $title;
    private string $subtitle;
    private string $email;
    private string $ruc;
    private string $address;
    private string $phone;

    public function __construct()
    {
        parent::__construct();
    }
    /**
     * Funcion que inserta el registro en la tabla de la base de datos
     * @return void
     */
    public function insert_info_system(string $nombreSistema, string $descripcion, string $logo): int
    {
        $this->name = $nombreSistema;
        $this->description = $descripcion;
        $this->logo = $logo;
        $sql = "INSERT INTO `tb_configuration` (`c_name`, `c_logo`, `c_description`) VALUES (?,?,?);";
        $arrValues = array(
            $this->name,
            $this->logo,
            $this->description
        );
        $request = $this->insert($sql, $arrValues);
        return $request;
    }
    /**
     * Funcion que devuelve los registros de la tabla de configuracion
     * @return void
     */
    public function selects_info_system()
    {
        $sql = "SELECT * FROM tb_configuration";
        $request = $this->select_all($sql);
        return $request;
    }
    /**
     * Funcion que devuelve un registro de la tabla de configuracion
     * @return void
     */
    public function select_info_system()
    {
        $sql = "SELECT * FROM tb_configuration";
        $request = $this->select($sql);
        return $request;
    }
    /**
     * Funcion que trunca la tabla de configuracion
     * @return bool
     */
    public function truncate_info_system()
    {
        $sql = "TRUNCATE TABLE tb_configuration";
        $request = $this->delete($sql, []);
        return $request;
    }
    /**
     * Funcion que actualiza los registros de la tabla de configuracion
     * @param int $idConfiguration
     * @param string $nombreSistema
     * @param string $descripcion
     * @param string $logo
     * @return bool
     */
    function update_info_system(int $idConfiguration, string $nombreSistema, string $descripcion, string $logo)
    {
        $this->name = $nombreSistema;
        $this->description = $descripcion;
        $this->logo = $logo;
        $this->idConfiguration = $idConfiguration;
        $sql = "UPDATE tb_configuration SET c_name = ?, c_logo = ?, c_description = ? WHERE idConfiguration = ?";
        $arrValues = array(
            $this->name,
            $this->logo,
            $this->description,
            $this->idConfiguration
        );
        $request = $this->update($sql, $arrValues);
        return $request;
    }
    
    
    /**
     * Funcion que inserta el registro en la tabla de la base de datos
     * @return void
     */
    public function insert_info_configuration(string $titulo, string $subtitulo, string $email, string $ruc, string $direccion, string $telefono): int
    {
        $this->title = $titulo;
        $this->subtitle = $subtitulo;
        $this->email = $email;
        $this->ruc = $ruc;
        $this->address = $direccion;
        $this->phone = $telefono;

        $sql = "INSERT INTO `tb_company` (`title`, `subtitle`, `mail`, `ruc`, `address`, `phone`) VALUES (?,?,?,?,?,?);";
        $arrValues = array(
            $this->title,
            $this->subtitle,
            $this->email,
            $this->ruc,
            $this->address,
            $this->phone
        );
        $request = $this->insert($sql, $arrValues);
        return $request;
    }
    /**
     * Funcion que devuelve los registros de la tabla de configuracion
     * @return void
     */
    public function selects_info_configuration()
    {
        $sql = "SELECT * FROM tb_company";
        $request = $this->select_all($sql);
        return $request;
    }
    /**
     * Funcion que devuelve un registro de la tabla de configuracion
     * @return void
     */
    public function select_info_configuration()
    {
        $sql = "SELECT * FROM tb_company";
        $request = $this->select($sql);
        return $request;
    }
    /**
     * Funcion que trunca la tabla de configuracion
     * @return bool
     */
    public function truncate_info_configuration()
    {
        $sql = "TRUNCATE TABLE tb_company";
        $request = $this->delete($sql, []);
        return $request;
    }
    /**
     * Funcion que actualiza los registros de la tabla de configuracion
     * @param int $idDocumentInfo
     * @param string $di_title
     * @param string $di_subtitle
     * @param string $di_email
     * @param string $di_ruc
     * @param string $di_address
     * @param string $di_phone
     * @return bool
     */
    function update_info_configuration(int $idDocumentInfo, string $titulo, string $subtitulo, string $email, string $ruc, string $direccion, string $telefono)
    {
        $this->title = $titulo;
        $this->subtitle = $subtitulo;
        $this->email = $email;
        $this->ruc = $ruc;
        $this->address = $direccion;
        $this->phone = $telefono;
        $this->idDocumentInfo = $idDocumentInfo;
        $sql = "UPDATE tb_company SET title = ?, subtitle = ?,  mail = ?, ruc = ?, address = ?, phone = ? WHERE id = ?";
        $arrValues = array(
            $this->title,
            $this->subtitle,
            $this->email,
            $this->ruc,
            $this->address,
            $this->phone,
            $this->idDocumentInfo
        );
        $request = $this->update($sql, $arrValues);
        return $request;
    }
}