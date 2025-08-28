<?php
class LoginModel extends Mysql
{
	private $idUser;
	private $user;
	private $password;
	private $email;
	private $profile;
	private $fullName;
	private $gender;
	private $dni;
	private $status;
	private $role_id;

	public function __construct()
	{
		parent::__construct();
	}

	public function selectUserLogin(string $user, string $password)
	{
		$this->user = $user;
		$this->password = $password;
		$arrValues = array(
			$this->user,
			$this->user,
			$this->password
		);
		$sql = "SELECT  tbu.*,tbr.r_name FROM tb_user AS tbu INNER JOIN tb_role AS tbr ON tbr.idRole=tbu.role_id WHERE (tbu.u_user=? OR tbu.u_email=?) AND tbu.u_password=?;";
		$request = $this->select($sql, $arrValues);
		return $request;
	}

	public function emailExists(string $emailEnc)
	{
		$sql = "SELECT idUser FROM tb_user WHERE u_email = ?";
		$arrData = [$emailEnc];
		$request = $this->select($sql, $arrData);

		return $request; // Esto debería retornar false o un array con 'idUser'
	}

	public function insertResetToken($userId, $email, $code, $expiresAt)
	{
		$sql = "INSERT INTO tb_password_reset_tokens (user_id, email, code, expires_at, status) 
            VALUES (?, ?, ?, ?, 'Activo')";
		$arrData = [$userId, $email, $code, $expiresAt];
		return $this->insert($sql, $arrData);
	}
}
