<?php 

class ResetPassword_model {
    private $table = 'reset_password';
    private $db;
    private $email;
    private $tanggal;
    private $token;

    public function __construct()
	{
        $this->db = new Database;
	}

    // setter 
    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function setTanggal($tanggal)
    {
        $this->tanggal = $tanggal;
    }

    public function setToken($token)
    {
        $this->token = $token;
    }

    // getter
    public function getEmail()
    {
        return $this->email;
    }

    public function getTanggal()
    {
        return $this->tanggal;
    }

    public function getToken()
    {
        return $this->token;
    }
    
    public function tampilResetPassword()
    {
        if($this->email){
            $this->db->query('SELECT * FROM ' . $this->table . ' WHERE email=:email');
            $this->db->bind('email', $this->email);
        } else {
            $this->db->query('SELECT * FROM ' . $this->table . ' WHERE token=:token');
            $this->db->bind('token', $this->token);
        }
        return $this->db->single();
    }

    public function tambah()
    {
        if($this->tampilResetPassword() > 0){
            $this->hapus();
        }
        $this->db->query('INSERT INTO ' . $this->table . ' (email, tanggal, token) VALUES (:email, :tanggal, :token)');
        $this->db->bind('email', $this->email);
        $this->db->bind('tanggal', $this->tanggal);
        $this->db->bind('token', $this->token);
        $this->db->execute();
        return $this->db->rowCount();
    }

    public function hapus()
    {
        $this->db->query('DELETE FROM ' . $this->table . ' WHERE email=:email');
        $this->db->bind('email', $this->email);
        $this->db->execute();
        return $this->db->rowCount();
    }
}