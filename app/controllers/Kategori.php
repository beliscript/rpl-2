<?php

class Kategori extends Controller{
	public function cari(){
		$kategori = $this->model('Kategori_model');
		if(isset($_POST['tipe'])) {
			echo json_encode(array('status' => 'success', 'data' => $kategori->tampilSemuaKategori($_POST['tipe'])));
		} else {
			echo json_encode(array('status' => 'failed', 'message' => 'Tipe tidak ditemukan'));
		}
	}
}