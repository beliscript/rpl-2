<?php

class Profile extends Controller {
	public function __construct()
	{
		if( !isset($_SESSION['login']) ) {
			header('Location: ' . BASEURL . '/login');
			exit;
		}
	}
	public function index(){
		$data['title'] = 'Profile | Dosaku';
        $user = $this->model('User_model');
        $user->setEmail($_SESSION['user']['email']);
        $data['user'] = $user->tampilUser();
		$this->view('templates/header', $data);
		$this->view('profile/index', $data);
		$this->view('templates/footer');
	}

    public function ubah(){
        $errors = array();
		if(empty($_POST['nama'])){
			$errors['nama'] = 'Nama tidak boleh kosong';
		}
		if(empty($_POST['limitPengeluaran'])){
			$errors['limitPengeluaran'] = 'Nama tidak boleh kosong';
		} else {
			if(!is_numeric($_POST['limitPengeluaran'])){
				$errors['limitPengeluaran'] = 'Limit pengeluaran harus berupa angka';
			}
		}

		if(!empty($_POST['password'])){
            if(empty($_POST['password_confirmation'])){
                $errors['password_confirmation'] = 'Password konfirmasi tidak boleh kosong!';
            } else if ($_POST['password'] != $_POST['password_confirmation']){
				$errors['password_confirmation'] = 'Password konfirmasi tidak sama!';
			}
        }
		
		if(empty($errors)){
			$user = $this->model('User_model');
			$user->setNama($_POST['nama']);
            $user->setEmail($_SESSION['user']['email']);
			$user->setLimitPengeluaran($_POST['limitPengeluaran']);
			if($user->editProfile() >= 0){
                if(!empty($_POST['password'])){
                    $user->setPassword(password_hash($_POST['password'], PASSWORD_DEFAULT));
                    $user->ubahPassword();
                }
				echo json_encode(array('status' => 'success', 'message' => 'Data berhasil diubah'));
			}else{
				echo json_encode(array('status' => 'failed', 'message' => '<li>Terjadi kesalahan saat mengubah data</li>'));
			}
		} else {
			$listError = '';
			foreach($errors as $error){
				$listError .= "<li>$error</li>";
			}

			echo json_encode(array('status' => 'failed', 'message' => $listError));
		}

    }
}