<?php

class Transaksi_model{
	private $table = 'transaksi';
	private $db;
    private $idTransaksi;
	private $judulTransaksi;
    private $email;
    private $idKategori;
    private $jumlah;
    private $tanggal;

	public function __construct()
	{
        $this->db = new Database;
	}

    public function setIdTransaksi($idTransaksi)
    {
        $this->idTransaksi = $idTransaksi;
    }

    public function setJudulTransaksi($judulTransaksi)
    {
        $this->judulTransaksi = $judulTransaksi;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function setIdKategori($idKategori)
    {
        $this->idKategori = $idKategori;
    }

    public function setJumlah($jumlah)
    {
        $this->jumlah = $jumlah;
    }

    public function setTanggal($tanggal)
    {
        $this->tanggal = $tanggal;
    }

    public function getIdTransaksi()
    {
        // return change to int
        return (int) $this->idTransaksi;
    }

    public function getJudulTransaksi()
    {
        return $this->judulTransaksi;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getIdKategori()
    {
        return $this->idKategori;
    }

    public function getJumlah()
    {
        return $this->jumlah;
    }

    public function getTanggal()
    {
        return $this->tanggal;
    }

    public function tampilSemuaTransaksi($data)
    {
        $search = $data['search'];
        $idKategori = $data['idKategori'];
        $tipe = $data['tipe'];
        $tanggalAwal = $data['tanggalAwal'];
        $tanggalAkhir = $data['tanggalAkhir'];
        $perPage = 10;
        
        $query = "SELECT COUNT(*) AS total FROM " . $this->table . " INNER JOIN kategori ON transaksi.idKategori=kategori.idKategori WHERE email=:email";
      
        if ($search != '') {
            $query .= " AND judulTransaksi LIKE :search";
        }
        if ($idKategori != '') {
            $query .= " AND transaksi.idKategori=:idKategori";
        }
        if ($tipe != '') {
            $query .= " AND kategori.tipe=:tipe";
        }
        if ($tanggalAwal != '' && $tanggalAkhir != '') {
            $query .= " AND tanggal BETWEEN :tanggalAwal AND :tanggalAkhir";
        }

        $this->db->query($query);
        if ($search != '') {
            $this->db->bind('search', "%$search%");
        }
        if ($idKategori != '') {
            $this->db->bind('idKategori', $idKategori);
        }
        if ($tipe != '') {
            $this->db->bind('tipe', $tipe);
        }
        if ($tanggalAwal != '' && $tanggalAkhir != '') {
            $this->db->bind('tanggalAwal', $tanggalAwal. ' 00:00:00');
            $this->db->bind('tanggalAkhir', $tanggalAkhir. ' 23:59:59');
        }

        $this->db->bind('email', $this->email);
        
        $total_results = $this->db->resultSet();
        $total_pages = ceil($total_results[0]['total'] / $perPage);

        $page = isset($data['page']) ? (int)$data['page'] : 1;
        $start = ($page - 1) * $perPage;

        // Query
        $query2 = "SELECT * FROM " . $this->table . " INNER JOIN kategori ON transaksi.idKategori=kategori.idKategori WHERE email=:email";
   
        if ($search != '') {
            $query2 .= " AND judulTransaksi LIKE :search";
        }
        if ($idKategori != '') {
            $query2 .= " AND transaksi.idKategori=:idKategori";
        }
        if ($tipe != '') {
            $query2 .= " AND kategori.tipe=:tipe";
        }
        if ($tanggalAwal != '' && $tanggalAkhir != '') {
            $query2 .= " AND tanggal BETWEEN :tanggalAwal AND :tanggalAkhir";
        }
        $query2 .= " ORDER BY tanggal DESC LIMIT $start, $perPage"; 
        $this->db->query($query2);
        $this->db->bind('email', $this->email);

        if ($search != '') {
            $this->db->bind('search', "%$search%");
        }

        if ($idKategori != '') {
            $this->db->bind('idKategori', $idKategori);
        }

        if ($tipe != '') {
            $this->db->bind('tipe', $tipe);
        }

        if ($tanggalAwal != '' && $tanggalAkhir != '') {
            $this->db->bind('tanggalAwal', $tanggalAwal. ' 00:00:00');
            $this->db->bind('tanggalAkhir', $tanggalAkhir. ' 23:59:59');
        }
        
        return [
            'data' => $this->db->resultSet(),
            'total_pages' => $total_pages,
            'current_page' => $page,
            'start' => $start,
        ];       
    }

    public function tampilTransaksi()
    {
        $this->db->query('SELECT * FROM ' . $this->table . ' INNER JOIN kategori ON transaksi.idKategori=kategori.idKategori WHERE idTransaksi=:idTransaksi AND email=:email');
		$this->db->bind('idTransaksi', $this->idTransaksi);
        $this->db->bind('email', $this->email);
		return $this->db->single();
    }

    public function tampilLaporan($data)
    {
        $this->db->query('SELECT SUM(jumlah) AS total FROM ' . $this->table . ' INNER JOIN kategori ON transaksi.idKategori=kategori.idKategori WHERE kategori.tipe=:tipe AND email=:email AND date(tanggal)=:tanggal');
        $this->db->bind('tipe', $data['tipe']);
        $this->db->bind('email', $this->email);
        $this->db->bind('tanggal', $data['tanggal']);
        foreach ($this->db->resultSet() as $row) {
            $total = $row['total'] == null ? 0 : $row['total'];
        }
        return $total;
    }



    // tambah data
    public function tambahTransaksi()
    {
        $query = "INSERT INTO " . $this->table . " VALUES ('', :email, :idKategori, :judulTransaksi, :jumlah, :tanggal)";
        $this->db->query($query);
        $this->db->bind('judulTransaksi', $this->judulTransaksi);
        $this->db->bind('email', $this->email);
        $this->db->bind('idKategori', $this->idKategori);
        $this->db->bind('jumlah', $this->jumlah);
        $this->db->bind('tanggal', $this->tanggal);
        $this->db->execute();
        return $this->db->rowCount();
    }

    // ubah data
    public function ubahTransaksi()
    {
        $query = "UPDATE " . $this->table . " SET judulTransaksi=:judulTransaksi , jumlah=:jumlah, tanggal=:tanggal WHERE idTransaksi=:idTransaksi AND email=:email";
        $this->db->query($query);
        $this->db->bind('judulTransaksi', $this->judulTransaksi);
        $this->db->bind('jumlah', $this->jumlah);
        $this->db->bind('tanggal', $this->tanggal);
        $this->db->bind('idTransaksi', $this->idTransaksi);
        $this->db->bind('email', $this->email);
        $this->db->execute();
        return $this->db->rowCount();
    }

    // hapus data
    public function hapusTransaksi()
    {
        $query = "DELETE FROM " . $this->table . " WHERE idTransaksi=:idTransaksi AND email=:email";
        $this->db->query($query);
        $this->db->bind('idTransaksi', $this->idTransaksi);
        $this->db->bind('email', $this->email);
        $this->db->execute();
        return $this->db->rowCount();
    }	
}