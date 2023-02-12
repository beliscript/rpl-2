<?php

class Kategori_model{
	private $table = 'kategori';
	private $db;
	private $idKategori;
	private $tipe;
	

	public function __construct()
	{
        $this->db = new Database;
	}
	
	public function setIdKategori($idKategori)
	{
		$this->idKategori = $idKategori;
	}




    // tampilsemua

	public function tampilSemuaKategori($type = null)
	{
		$this->db->query('SELECT * FROM ' . $this->table . ' WHERE tipe=:tipe');
		$this->db->bind('tipe', $type);
		return $this->db->resultSet();
	}

	// tampil berdasarkan id
	public function tampilKategori()
	{
		$this->db->query('SELECT * FROM ' . $this->table . ' WHERE idKategori=:idKategori');
		$this->db->bind('idKategori', $this->idKategori);
		return $this->db->single();
	}


}