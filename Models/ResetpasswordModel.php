<?php
class ResetpasswordModel extends Mysql
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getTokenData(string $code)
    {
        $sql = "SELECT * FROM tb_password_reset_tokens WHERE code = ? AND status = 'Usado' LIMIT 1";
        $request = $this->select($sql, [$code]);
        return $request;
    }

    public function updateUserPassword(string $emailEncrypted, string $newEncryptedPassword)
    {
        $sql = "UPDATE tb_user SET u_password = ? WHERE u_email = ?";
        $arrData = [$newEncryptedPassword, $emailEncrypted];
        return $this->update($sql, $arrData);
    }
}
