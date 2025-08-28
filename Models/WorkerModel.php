<?php
class WorkerModel extends Mysql
{
    private int $id;
    private string $dni;
    private string $idWorker;
    private string $idPeople;
    private string $jobtitleid;
    private string $accountnumber;
    private string $accountnumber2;
    private string $accountnumber3;
    private string $accountnumber4;
    private string $dateRegistration;
    private string $dateUpdate;
    private string $status;
    public function __construct()
    {
        parent::__construct();
    }
    /**
     * Metodo que se encarga de obtener todas los trabajadores
     * @return array
     */
    public function select_worker()
    {
        $sql = "SELECT w.id as id, p.typePeople, p.name, p.lastname, p.id AS idPeople,p.fullname, p.numberDocument AS dni, p.`phone` AS phone, jb.`name` AS jobtitle, jb.`id` AS idJobtitle,
                w.`account_number` AS account, w.`account_number2` AS account2, w.`account_number3` AS account3,
                w.`account_number4` AS account4, p.mail AS mail, p.gender AS gender, p.birthdate AS birthdate, p.address AS address, 
                w.`dateRegistration` AS dateRegistration, w.`dateUpdate` AS dateUpdate, w.`status` AS status 
                FROM tb_worker w
                INNER JOIN tb_people p
                ON w.`people_id` = p.`id`
                INNER JOIN tb_job_title jb
                ON w.`job_title_id`=jb.`id`
                ORDER BY w.`dateRegistration` DESC;";
        $request = $this->select_all($sql);
        return $request;
    }

    //obtener los productos por el id
    public function getPeople(int $idPeople): array | bool
    {
        $sql = "SELECT * FROM tb_people WHERE id = ?";
        $arrValues = array($idPeople);
        $request = $this->select($sql, $arrValues);
        return $request;
    }

    public function getAllPeople(): array | bool
    {
        $sql = "SELECT * FROM tb_people
        WHERE status = 'Activo';";
        $request = $this->select_all($sql, []);
        return $request;
    }

    //obtener los productos por el id
    public function getJobtitle(int $idJobtitle): array | bool
    {
        $sql = "SELECT * FROM tb_job_title WHERE id = ?";
        $arrValues = array($idJobtitle);
        $request = $this->select($sql, $arrValues);
        return $request;
    }

    public function getAllJobtitle(): array | bool
    {
        $sql = "SELECT * FROM tb_job_title
        WHERE status = 'Activo';";
        $request = $this->select_all($sql, []);
        return $request;
    }


    /**
     * Metodo que se encarga de registrar un trabajador
     * Este metodo se utiliza para insertar un nuevo trabajador en la base de datos
     * @param int $idWorker
     * @param string $idJobtitle
     * @param int $strAccount
     * @param int $strAccount2
     * @param int $strAccount3
     * @param int $strAccount4
     * @return bool|int|string
     */
    public function insert_worker($idWorker, $idJobtitle, $strAccount, $strAccount2, $strAccount3, $strAccount4)
    {

        $sql = "INSERT INTO tb_worker (people_id, job_title_id, account_number, account_number2, 
        account_number3, account_number4) VALUES (?,?,?,?,?,?);";
        $arrValues = array(
            $this->idWorker = $idWorker,
            $this->jobtitleid = $idJobtitle,
            $this->accountnumber = $strAccount,
            $this->accountnumber2 = $strAccount2,
            $this->accountnumber3 = $strAccount3,
            $this->accountnumber4 = $strAccount4,
        );
        $request = $this->insert($sql, $arrValues);
        return $request;
    }

    /**
     * Metdodo que se encarga de buscar personas
     * Este metodo se utiliza para buscar personas en la base de datos
     * @param string $dni
     */
    public function search_people(string $dni)
    {
        $this->dni = $dni;
        $sql = "SELECT * FROM tb_people AS tbp WHERE tbp.numberDocument=? and tbp.status='ACTIVO';";
        $arrValue = array($this->dni);
        $request = $this->select($sql, $arrValue);
        return $request;
    }
    /**
     * Metodo que se encarga de buscar un trabajador por el id de la persona
     * Esto se utiliza para obtener los datos de un trabajador específico
     * @param int $id
     */
    public function select_people_by_id(int $id)
    {
        $this->id = $id;
        $sql = "SELECT * FROM tb_worker AS tbc WHERE tbc.people_id=?;";
        $arrValue = array($this->id);
        $request = $this->select($sql, $arrValue);
        return $request;
    }
    /**
     * Metodo que se encarga de buscar un trabajador por el id del trabajador
     * Esto se utiliza para obtener los datos de un trabajador específico
     * @param int $id
     */
    public function select_worker_by_id(int $id)
    {
        $this->id = $id;
        $sql = "SELECT * FROM tb_worker AS tbw WHERE tbw.id=?;";
        $arrValue = array($this->id);
        $request = $this->select($sql, $arrValue);
        return $request;
    }

    /**
     * Obtiene los detalles de los trabajadores por su ID.
     *
     * @param int $id ID del Worker
     * @return array Arreglo con los datos completos del Worker
     */
    public function select_detail_worker(int $id): array
    {
        $this->id = $id;
        $sql = "SELECT 
                w.id, 
                p.name, 
                jb.`name` AS nameJob,
                p.lastname, 
                p.typePeople,
                p.fullname,
                p.numberDocument,
                p.phone,
                w.account_number,
                w.account_number2,
                w.account_number3,
                w.account_number4,
                w.status,
                w.dateRegistration,
                w.dateUpdate,
                w.people_id,
                w.job_title_id
            FROM tb_worker w
            INNER JOIN tb_people p ON w.people_id = p.id
            INNER JOIN tb_job_title jb ON w.job_title_id=jb.id
            WHERE w.id = ?";

        $arrData = $this->select($sql, [$id]);
        return $arrData ?: null;
    }
    /**
     * Metodo que se encarga eliminnar un trabajador
     * Esto se utiliza para eliminar un trabajador de la base de datos
     * Este metodo elimina un trabajador de la base de datos
     * @param int $id
     * @return bool
     */
    public function delete_worker(int $id)
    {
        $this->id = $id;
        $sql = "DELETE FROM tb_worker WHERE id=?;";
        $arrValue = array($this->id);
        $request = $this->delete($sql, $arrValue);
        return $request;
    }


    public function update_worker(
        int $id,
        int $idPeople,
        int $jobtitleid,
        $accountnumber,
        $accountnumber2,
        $accountnumber3,
        $accountnumber4,
        $status
    ): bool {
        $this->id = $id;
        $this->idPeople = $idPeople;
        $this->jobtitleid = $jobtitleid;
        $this->accountnumber = $accountnumber;
        $this->accountnumber2 = $accountnumber2;
        $this->accountnumber3 = $accountnumber3;
        $this->accountnumber4 = $accountnumber4;
        $this->status = $status;

        // Consulta SQL preparada
        $sql = "UPDATE tb_worker 
            SET people_id = ?, job_title_id = ?, account_number = ?, account_number2 = ?,
            account_number3 = ?, account_number4 = ?, status = ?
            WHERE id = ?";


        // Datos a vincular
        $arrData = array(
            $this->idPeople,
            $this->jobtitleid,
            $this->accountnumber,
            $this->accountnumber2,
            $this->accountnumber3,
            $this->accountnumber4,
            $this->status,
            $this->id
        );

        // Ejecuta la actualización y retorna si fue exitosa
        $request = $this->update($sql, $arrData);
        return $request > 0;
    }
}
