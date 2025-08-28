<?php

class PeopleModel extends Mysql
{
    private int $idPeople;
    private string $name;
    private string $lastname;
    private string $numberDocument;
    private DateTime $birthdate;
    private string $gender;
    private string $mail;
    private string $phone;
    private string $add;
    private string $status;

    public function __construct()
    {
        parent::__construct();
    }

    // Funciones para obtener un registro
    public function getPeople(int $idPeople): array | bool
    {
        $sql = "SELECT * FROM tb_people WHERE id = ?";
        $arrValues = array($idPeople);
        $request = $this->select($sql, $arrValues);
        return $request;
    }

    public function getPeopleByNumberDocument(string $numberDocument): array | bool
    {
        $sql = "SELECT * FROM tb_people WHERE numberDocument = ?";
        $arrValues = array($numberDocument);
        $request = $this->select($sql, $arrValues);
        return $request;
    }

    public function getPeopleWorker(int $idPeople): array | bool
    {
        $sql = "SELECT * FROM tb_worker WHERE people_id = ?";
        $arrValues = array($idPeople);
        $request = $this->select($sql, $arrValues);
        return $request;
    }

    public function getPeopleCustomer(int $idPeople): array | bool
    {
        $sql = "SELECT * FROM tb_customer WHERE people_id = ?";
        $arrValues = array($idPeople);
        $request = $this->select($sql, $arrValues);
        return $request;
    }

    public function getPeopleSupplier(int $idPeople): array | bool
    {
        $sql = "SELECT * FROM tb_supplier WHERE people_id = ?";
        $arrValues = array($idPeople);
        $request = $this->select($sql, $arrValues);
        return $request;
    }

    // Funciones para obtener registros
    public function getAllPeople(): array | bool
    {
        $sql = "SELECT * FROM tb_people";
        $request = $this->select_all($sql);
        return $request;
    }

    public function getAllFilePeople(string $table = ''): array | bool
    {
        $sql = "SELECT * FROM tb_file
        WHERE `table` = ?";
        $request = $this->select_all($sql, [$table]);
        return $request;
    }

    //Funcion que permite tomar los datos de la persona -pdf
    public function select_people_by_id(int $id): array | bool
    {
        $sql = "SELECT * FROM tb_people WHERE id = ?";
        $arrValues = array($id);
        $request = $this->select($sql, $arrValues);
        return $request;
    }

    //Funcion que permite tomar los detalles de la persona -pdf
    public function select_detail_people(int $id): array | bool
    {
        $sql = "SELECT * FROM tb_people WHERE id = ?";
        $arrValues = array($id);
        $request = $this->select($sql, $arrValues);
        return $request;
    }

    // Funciones para insertar registros
    public function setPeople($name, $fullname, $lastname,string $numberDocument, string $typePeople, $birthdate, $gender, string $mail, string $phone, string $address, string $comment): int
    {
        $sql = "INSERT INTO `tb_people` (`name`, `fullname`, `lastname`, `numberDocument`, `typePeople`, `birthdate`, `gender`, `mail`, `phone`, `address`, `comment`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $arrValues = array(
            $name,
            $fullname,
            $lastname,
            $numberDocument,
            $typePeople,
            $birthdate,
            $gender,
            $mail,
            $phone,
            $address,
            $comment
        );
        $request = $this->insert($sql, $arrValues);
        return $request;
    }

    public function setImagePeople(int $idPro, string $able, string $name, string $type, string $size): int
    {
        $sql = "INSERT INTO `tb_file` (`id_code`, `table`, `name`, `type`, `size`) VALUES (?, ?, ?, ?, ?)";
        $arrValues = array(
            $idPro,
            $able,
            $name,
            $type,
            $size,
        );
        $request = $this->insert($sql, $arrValues);
        return $request;
    }

    // Funciones para actualizar registros
    public function updatePeople(int $idPeople, $name, $lastname, $fullname, string $numberDocument, string $typePeople, $birthdate, $gender, string $mail, string $phone, string $address, string $comment, string $status): bool
    {
        $sql = "UPDATE tb_people SET name=?, lastname=?, fullname=?, numberDocument=?, typePeople=?, birthdate=?, gender=?, mail=?, phone=?, address=?, comment=?, status=? WHERE id=?";
        $arrValues = array($name, $lastname, $fullname, $numberDocument, $typePeople, $birthdate, $gender, $mail, $phone, $address, $comment, $status, $idPeople);
        $request = $this->update($sql, $arrValues);
        return $request;
    }

    // Funciones para eliminar registros
    public function deletePeople(int $idPeople): bool
    {
        $sql = "DELETE FROM tb_people WHERE id = ?";
        $arrValues = array($idPeople);
        $request = $this->delete($sql, $arrValues);
        return $request;
    }

    public function deleteFilePeople(int $idFile, string $table): bool
    {
        $sql = "DELETE FROM tb_file WHERE id_code = ? AND `table` = ?";
        $arrValues = array($idFile, $table);
        $request = $this->delete($sql, $arrValues);
        return $request;
    }
}
