<?php
class SendcodeModel extends Mysql
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getTokenByCode(string $code)
    {
        $sql = "SELECT * FROM tb_password_reset_tokens WHERE code = ? LIMIT 1";
        $data = $this->select($sql, [$code]);
        return $data;
    }

    public function updateTokenStatus(string $code, string $status)
    {
        $sql = "UPDATE tb_password_reset_tokens SET status = ? WHERE code = ?";
        $this->update($sql, [$status, $code]);
    }
}
