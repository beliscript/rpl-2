<?php

class User_model{
	private $table = 'user';
	private $db;
	private $email;
	private $nama;
	private $password;
	private $limitPengeluaran;
	private $lastNotif;

	public function __construct()
	{
        $this->db = new Database;
	}

	public function setEmail($email)
	{
		$this->email = $email;
	}

	public function setNama($nama)
	{
		$this->nama = $nama;
	}

	public function setPassword($password)
	{
		$this->password = $password;
	}

	public function setLimitPengeluaran($limitPengeluaran)
	{
		$this->limitPengeluaran = $limitPengeluaran;
	}

	public function setLastNotif($lastNotif)
	{
		$this->lastNotif = $lastNotif;
	}
	

	public function getEmail()
	{
		return $this->email;
	}

	public function getNama()
	{
		return $this->nama;
	}

	public function getPassword()
	{
		return $this->password;
	}

	public function getLimitPengeluaran()
	{
		return $this->limitPengeluaran;
	}

	public function getLastNotif()
	{
		return $this->lastNotif;
	}

	public function register()
	{
		$query = "INSERT INTO user (email, nama, password, limitPengeluaran, lastNotif) VALUES(:email, :nama, :password, :limitPengeluaran, :lastNotif)";
		$this->db->query($query);
		$this->db->bind('email', $this->email);
		$this->db->bind('nama', $this->nama);
		$this->db->bind('password', $this->password);
		$this->db->bind('limitPengeluaran', $this->limitPengeluaran);
		$this->db->bind('lastNotif', $this->lastNotif);
		$this->db->execute();
		return $this->db->rowCount();
	}
	

	public function editProfile()
	{
		if ($this->password) {
			$query = "UPDATE ".$this->table." SET nama=:nama, limitPengeluaran=:limitPengeluaran, password=:password WHERE email=:email";
		} else {
			$query = "UPDATE ".$this->table." SET nama=:nama, limitPengeluaran=:limitPengeluaran WHERE email=:email";
		}
		$this->db->query($query);
		if ($this->password) {
			$this->db->bind('password', $this->password);
		} 
		$this->db->bind('email', $this->email);
		$this->db->bind('nama', $this->nama);
		$this->db->bind('limitPengeluaran', $this->limitPengeluaran);
		$this->db->execute();
		return $this->db->rowCount();
	}

	public function ubahPassword()
	{
		$query = "UPDATE ".$this->table." SET password=:password WHERE email=:email";
		$this->db->query($query);
		$this->db->bind('password', $this->password);
		$this->db->bind('email', $this->email);
		$this->db->execute();
		return $this->db->rowCount();
	}

	public function tampilUserLimit()
	{
	
		$query = "SELECT user.email, user.limitPengeluaran, (SELECT SUM(transaksi.jumlah) FROM transaksi INNER JOIN kategori ON transaksi.idKategori=kategori.idKategori WHERE transaksi.email=" . $this->table . ".email AND kategori.tipe='pengeluaran' AND transaksi.tanggal LIKE :tanggal) as total_pengeluaran FROM " . $this->table . " where limitPengeluaran < (SELECT SUM(transaksi.jumlah) FROM transaksi INNER JOIN kategori ON transaksi.idKategori=kategori.idKategori WHERE transaksi.email=" . $this->table . ".email AND kategori.tipe='pengeluaran' AND transaksi.tanggal LIKE :tanggal) AND (lastNotif <:tanggal OR lastNotif IS NULL)";
		$this->db->query($query);
		$this->db->bind('tanggal', date('Y-m-d').'%');
		$this->db->execute();
		return $this->db->resultSet();
	}

	public function tampilUser()
	{
		$query = "SELECT * FROM ".$this->table." WHERE email=:email";
		$this->db->query($query);
		$this->db->bind('email', $this->email);
		$this->db->execute();
		return $this->db->single() ? $this->db->single() : false;
	}

	public function login()
	{
		$query = "SELECT * FROM ".$this->table." WHERE email=:email";
		$this->db->query($query);
		$this->db->bind('email', $this->email);
		$this->db->execute();
		$user = $this->db->single();
		if($user){
			if(password_verify($this->password, $user['password'])){
				return $user;
			}else{
				return false;
			}
		} else {
			return false;
		}
	}
	
	public function updateLastNotif()
	{
		$query = "UPDATE ".$this->table." SET lastNotif=:lastNotif WHERE email=:email";
		$this->db->query($query);
		$this->db->bind('email', $this->email);
		$this->db->bind('lastNotif', $this->lastNotif);
		$this->db->execute();
		return $this->db->rowCount();
	}

}