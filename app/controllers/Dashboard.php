<?php

class Dashboard extends Controller {

	public function __construct()
	{
		if( !isset($_SESSION['login']) ) {
			header('Location: ' . BASEURL . '/login');
			exit;
		}
	}

	public function index()
	{
		$data['title'] =  'Dashboard | DOSAKU';
		$this->view('templates/header', $data);
		$this->view('dashboard/index', $data);
		$this->view('templates/footer');
	}

	public function laporan()
	{
		$tanggal_awal = $_POST['tanggalAwal'];
		$tanggal_akhir = $_POST['tanggalAkhir'];
		$transaksi = $this->model('Transaksi_model');
		$transaksi->setEmail($_SESSION['user']['email']);
		$dataReport = array();
		$totalPemasukan = 0;
		$totalPengeluaran = 0;
	    while(strtotime($tanggal_awal) <= strtotime($tanggal_akhir)){
			$pemasukan = [
				'tanggal' => $tanggal_awal,
				'tipe' => 'pemasukan'
			];
			$pengeluaran = [
				'tanggal' => $tanggal_awal,
				'tipe' => 'pengeluaran'
			];
	        $dataReport[] = array(
	            'tanggal' => $tanggal_awal,
	            'pemasukan' => $transaksi->tampilLaporan($pemasukan),
	            'pengeluaran' => $transaksi->tampilLaporan($pengeluaran)
	        );
			$totalPemasukan += $transaksi->tampilLaporan($pemasukan);
			$totalPengeluaran += $transaksi->tampilLaporan($pengeluaran);
	        $tanggal_awal = date ("Y-m-d", strtotime("+1 day", strtotime($tanggal_awal)));
	    }
	
		$result = 
		[
			'status' => 'success',
			'grafik' => $dataReport,
			'info' => array(
				'totalPemasukan' => $totalPemasukan,
				'totalPengeluaran' => $totalPengeluaran,
				'selisih' => $totalPemasukan - $totalPengeluaran,
			),
		];

		echo json_encode($result, JSON_PRETTY_PRINT);
	}
}