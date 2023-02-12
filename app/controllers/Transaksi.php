<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Transaksi extends Controller{

	public function __construct()
	{
		if( !isset($_SESSION['login']) ) {
			header('Location: ' . BASEURL . '/login');
			exit;
		}
	}

	private function kirimEmail($email,$limit,$total){
        $mail = new PHPMailer(true);
        try {
           $mail->SMTPDebug = 0;									
           $mail->isSMTP();											
           $mail->Host	 = 'mail.warungtehusi.com';					
           $mail->SMTPAuth = true;							
           $mail->Username = 'noreply@warungtehusi.com';				
           $mail->Password = 'eAGTGqQzpXrM';						
           $mail->SMTPSecure = 'tsl';							
           $mail->Port	 = 25;
  
           $mail->setFrom('noreply@warungtehusi.com', 'DosaKu');
           $mail->addAddress($email);
           
           $mail->isHTML(true);								
           $mail->Subject = 'Peringatan Limit Pengeluaran';
           $mail->Body = 'Limit pengeluaran kamu sudah melebihi batas yang telah ditentukan.<br>
                        <b>Limit Pengeluaran : </b> Rp. '.number_format($limit,0,',','.').',-<br>
                        <b>Total Pengeluaran : </b> Rp. '.number_format($total,0,',','.').',-';
           $mail->send();
           return true;
        } catch (Exception $e) {
           return false;
        }
    }

	public function index(){
		$data['title'] = 'Transaksi | Pencatat Keuangan';
		$kategori = $this->model('Kategori_model');		
        $data['categories_pemasukan'] = $kategori->tampilSemuaKategori('pemasukan');
		$data['categories_pengeluaran'] = $kategori->tampilSemuaKategori('pengeluaran');
		$this->view('templates/header', $data);
		$this->view('transaksi/index', $data);
		$this->view('templates/footer');
	}

	public function simpan() {
	
		$errors = array();
		if(empty($_POST['judulTransaksi'])){
			$errors['judulTransaksi'] = 'Judul tidak boleh kosong';
		}
	
	
		if(empty($_POST['tanggal'])){
			$errors['tanggal'] = 'Tanggal tidak boleh kosong';
		} else {
			if(!preg_match('/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$/', $_POST['tanggal'])){
				$errors['tanggal'] = 'Format tanggal salah';
			}
		}
		if(empty($_POST['idKategori'])){
			$errors['idKategori'] = 'Kategori tidak boleh kosong';
		} else {
			$kategori = $this->model('Kategori_model');
			$kategori->setIdKategori($_POST['idKategori']);
			if($kategori->tampilKategori() == null){
				$errors['idKategori'] = 'Kategori tidak ditemukan';
			}
		}

		if(empty($_POST['jumlah'])){
			$errors['jumlah'] = 'Jumlah tidak boleh kosong';
		} else {
			if(!is_numeric($_POST['jumlah'])){
				$errors['jumlah'] = 'jumlah harus berupa angka';
			}
		}

		if(empty($errors)){
			$transaksi = $this->model('Transaksi_model');
			$transaksi->setJudulTransaksi($_POST['judulTransaksi']);
			$transaksi->setEmail($_SESSION['user']['email']);
			$transaksi->setIdKategori($_POST['idKategori']);
			$transaksi->setJumlah($_POST['jumlah']);
			$transaksi->setTanggal($_POST['tanggal']);
			if($transaksi->tambahTransaksi() > 0){
				if($kategori->tampilKategori()['tipe'] == 'pengeluaran') {
					$user = $this->model('User_model');
					$user->setEmail($_SESSION['user']['email']);
					$dataUser = $user->tampilUser();
					$pengeluaran = $dataUser['total_pengeluaran'];
					$limitPengeluaran = $dataUser['limitPengeluaran'];
					$lastNotif = date('Y-m-d', strtotime($dataUser['lastNotif']));
					if($pengeluaran > $limitPengeluaran AND $lastNotif != date('Y-m-d')){
						$user->setLastNotif(date('Y-m-d H:i:s'));
						$this->kirimEmail($_SESSION['user']['email'],$limitPengeluaran,$pengeluaran);
						$user->updateLastNotif();
					}
				}
				echo json_encode(array('status' => 'success', 'message' => 'Berhasil menambahkan transaksi'));
			}else{
				echo json_encode(array('status' => 'failed', 'message' => 'Gagal menambahkan transaksi'));
			}
		} else {
			$listError = '';
			foreach($errors as $error){
				$listError .= "<li>$error</li>";
			}

			echo json_encode(array('status' => 'failed', 'message' => $listError));
		}


	}

	public function ubah() {
		$transaksi = $this->model('Transaksi_model');
		$errors = array();
		if(empty($_POST['idTransaksi'])){
			$errors['idTransaksi'] = 'idTransaksi tidak boleh kosong';
		} else {
			$transaksi->setIdTransaksi($_POST['idTransaksi']);
			$transaksi->setEmail($_SESSION['user']['email']);
			if($transaksi->tampilTransaksi() == null){
				$errors['idTransaksi'] = 'idTransaksi tidak ditemukan';
			}
		}
		
		if(empty($_POST['judulTransaksi'])){
			$errors['judulTransaksi'] = 'Judul tidak boleh kosong';
		}


		if(empty($_POST['tanggal'])){
			$errors['tanggal'] = 'Tanggal tidak boleh kosong';
		} else {
			if(!preg_match('/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$/', $_POST['tanggal'])){
				$errors['tanggal'] = 'Format tanggal salah';
			}
		}

		if(empty($_POST['jumlah'])){
			$errors['jumlah'] = 'Jumlah tidak boleh kosong';
		} else {
			if(!is_numeric($_POST['jumlah'])){
				$errors['jumlah'] = 'jumlah harus berupa angka';
			}
		}

		if(empty($errors)){
			$transaksi->setJudulTransaksi($_POST['judulTransaksi']);
			$transaksi->setJumlah($_POST['jumlah']);
			$transaksi->setTanggal($_POST['tanggal']);
			
			if($transaksi->ubahTransaksi() > 0 or $transaksi->ubahTransaksi() == 0){
				echo json_encode(array('status' => 'success', 'message' => 'Berhasil mengubah transaksi'));
			}else{
				echo json_encode(array('status' => 'failed', 'message' => 'Gagal menambahkan transaksi'));
			}
		} else {
			$listError = '';
			foreach($errors as $error){
				$listError .= "<li>$error</li>";
			}

			echo json_encode(array('status' => 'failed', 'message' => $listError));
		}



	}

	public function hapus() {
		$transaksi = $this->model('Transaksi_model');
		$errors = array();
		if(empty($_POST['idTransaksi'])){
			$errors['idTransaksi'] = 'idTransaksi tidak boleh kosong';
		} else {
			$transaksi->setIdTransaksi($_POST['idTransaksi']);
			$transaksi->setEmail($_SESSION['user']['email']);
			if($transaksi->tampilTransaksi() == null){
				$errors['idTransaksi'] = 'idTransaksi tidak ditemukan';
			}
		}
		
		if(empty($errors)){
			if($transaksi->hapusTransaksi() > 0){
				echo json_encode(array('status' => 'success'));
			}else{
				echo json_encode(array('status' => 'failed'));
			}
		} else {
			echo json_encode($errors);
		}
	}

	public function tampil() {
		$transaksi = $this->model('Transaksi_model');
		$data = [
			'search' => isset($_POST['search']) ? $_POST['search'] : '',
			'idKategori' => isset($_POST['idKategori']) ? $_POST['idKategori'] : '',
			'tanggalAwal' => isset($_POST['tanggalAwal']) ? $_POST['tanggalAwal'] : '',
			'tanggalAkhir' => isset($_POST['tanggalAkhir']) ? $_POST['tanggalAkhir'] : '',
			'tipe' => isset($_POST['tipe']) ? $_POST['tipe'] : '',
			'page' => isset($_POST['page']) ? $_POST['page'] : 1,
		];
		$transaksi->setEmail($_SESSION['user']['email']);
		echo json_encode($transaksi->tampilSemuaTransaksi($data));
	}

	public function detail() {
		$transaksi = $this->model('Transaksi_model');
		$errors = array();
		if(empty($_POST['idTransaksi'])){
			$errors['idTransaksi'] = 'idTransaksi tidak boleh kosong';
		} else {
			$transaksi->setIdTransaksi($_POST['idTransaksi']);
			$transaksi->setEmail($_SESSION['user']['email']);
		    if($transaksi->tampilTransaksi() == null){
				$errors['idTransaksi'] = 'idTransaksi tidak ditemukan';
			} else {
				echo json_encode(array('status' => 'success', 'data' => $transaksi->tampilTransaksi()));
			}
		}
		if(!empty($errors)){
			echo json_encode(array('status' => 'failed', 'message' => implode('<br>', $errors)));
		}
	}
}
