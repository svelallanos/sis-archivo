<?php

class UsersModel extends Mysql
{
    private $idUser;
    private $user;
    private $password;
    private $email;
    private $profile;
    private $fullname;
    private $gender;
    private $dni;
    private $role;
    private $status;
    public function __construct()
    {
        parent::__construct();
    }
    /**
     * Funcion que se encarga de la seleccion de todos los usuarios
     * @return array
     */
    public function select_users(): array
    {
        $query = "SELECT tbu.idUser, tbu.u_profile,tbu.u_gender,tbu.u_password,tbu.u_fullname,tbu.u_dni,tbu.u_user,tbu.u_email,tbr.r_name,tbu.u_status,tbu.u_registrationDate,tbu.u_updateDate,tbu.role_id FROM tb_user AS tbu INNER JOIN tb_role AS tbr ON tbr.idRole=tbu.role_id;";
        $request = $this->select_all($query, []);
        return $request;
    }
    /**
     * Funcion que inserta el registro en la tabla de la base de datos
     * @return void
     */
    public function insert_user($user, $pasword, $email, $profile = null, $fullname, $gender, $dni, $role): int
    {
        $sql = "INSERT INTO `tb_user` (`u_user`, `u_password`, `u_email`, `u_profile`, `u_fullname`, `u_gender`, `u_dni`, `role_id`) VALUES (?,?,?,?,?,?,?,?);";
        $arrValues = array(
            $this->user = $user,
            $this->password = $pasword,
            $this->email = $email,
            $this->profile = $profile,
            $this->fullname = $fullname,
            $this->gender = $gender,
            $this->dni = $dni,
            $this->role = $role
        );
        $request = $this->insert($sql, $arrValues);
        return $request;
    }
    /**
     * Funcion que eliminar un registro de la base de datos
     * @param mixed $id
     * @return bool
     */
    public function delete_user($id)
    {
        $this->idUser = $id;
        $sql = "DELETE FROM `tb_user` WHERE idUser = ?";
        $arrValues = array($this->idUser);
        $request = $this->delete($sql, $arrValues);
        return $request;
    }
    /**
     * Funcion que actualiza el registro en la base de datos
     * @param mixed $intId
     * @param mixed $strUser
     * @param mixed $strPassword
     * @param mixed $strEmail
     * @param mixed $strProfile
     * @param mixed $strFullName
     * @param mixed $strGender
     * @param mixed $strDNI
     * @param mixed $intRole
     * @param mixed $slctStatus
     * @return bool
     */
    public function update_user($intId, $strUser, $strPassword, $strEmail, $strProfile, $strFullName, $strGender, $strDNI, $intRole = false, $slctStatus = false)
    {
        $this->idUser = $intId;
        $this->user = $strUser;
        $this->password = $strPassword;
        $this->email = $strEmail;
        $this->profile = $strProfile;
        $this->fullname = $strFullName;
        $this->gender = $strGender;
        $this->dni = $strDNI;
        $this->role = $intRole;
        $this->status = $slctStatus;
        if (!$this->role && !$this->status) {
            $sql = "UPDATE `tb_user` SET `u_user`=?,`u_password`=?,`u_email`=?,`u_profile`=?,`u_fullname`=?,`u_gender`=?,`u_dni`=? WHERE idUser=?";
            $arrValues = array(
                $this->user,
                $this->password,
                $this->email,
                $this->profile,
                $this->fullname,
                $this->gender,
                $this->dni,
                $this->idUser
            );
        } else {
            $sql = "UPDATE `tb_user` SET `u_user`=?,`u_password`=?,`u_email`=?,`u_profile`=?,`u_fullname`=?,`u_gender`=?,`u_dni`=?,`role_id`=?,`u_status`=? WHERE idUser=?";
            $arrValues = array(
                $this->user,
                $this->password,
                $this->email,
                $this->profile,
                $this->fullname,
                $this->gender,
                $this->dni,
                $this->role,
                $this->status,
                $this->idUser
            );
        }

        $request = $this->update($sql, $arrValues);
        return $request;
    }
    public function select_user_by_Id(int $idUser)
    {
        $this->idUser = $idUser;
        $sql = "SELECT * FROM tb_user as tbu inner join tb_role as tbr on tbu.role_id=tbr.idRole WHERE tbu.idUser = ?";
        $arrValues = array($this->idUser);
        $request = $this->select($sql, $arrValues);
        return $request;
    }

}
