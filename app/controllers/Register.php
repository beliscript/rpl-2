<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Register extends Controller{
    public function __construct()
	{
		if(isset($_SESSION['login']) && $_SESSION['login'] == true ) {
			header('Location: ' . BASEURL . '/login');
			exit;
		}
	}
    
	public function index(){
		$data['title'] = 'Register | Dosaku';
		$this->view('templates/header_auth', $data);
		$this->view('register/index');
		$this->view('templates/footer_auth');
	}

    public function kirimEmail($email) {
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
           $mail->Subject = 'Berhasil Mendaftar';
           $mail->Body = 'Selamat, Kamu telah berhasil mendaftar di DosaKu.';
           $mail->send();
           return true;
        } catch (Exception $e) {
           return false;
        }
    }

    public function simpan(){
        $user = $this->model('User_model');
        $errors = array();
        if(empty($_POST['nama'])){
            $errors['nama'] = 'Nama tidak boleh kosong';
        }
        if(empty($_POST['email'])){
            $errors['email'] = 'Email tidak boleh kosong';
        }else{
            if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
                $errors['email'] = 'Email tidak valid';
            }else{
                $user->setEmail($_POST['email']);
                if($user->tampilUser() > 0){
                    $errors['email'] = 'Email sudah terdaftar';
                }
            }
        }

        if(empty($_POST['password'])){
            $errors['password'] = 'Password tidak boleh kosong';
        }else{
            if($_POST['password'] != $_POST['password_confirmation']){
                $errors['password'] = 'Password tidak sama';
            }
        }

        if(empty($_POST['password_confirmation'])){
            $errors['password_confirmation'] = 'Konfirmasi password tidak boleh kosong';
        }

       
        if(empty($errors)){
            $user = $this->model('User_model');
            $user->setNama($_POST['nama']);
            $user->setEmail($_POST['email']);
            $user->setPassword(password_hash($_POST['password'], PASSWORD_DEFAULT));
            $user->setLimitPengeluaran(1000000);
            if($user->register() > 0){
                $this->kirimEmail($user->getEmail());
                echo json_encode(array('status' => 'success', 'message' => 'Hore, Kamu telah menjadi bagian <b>Dosa KU</b>.'));
            }else{
               echo  json_encode(array('status' => 'failed', 'message' => '<ul><li>Gagal menambahkan user</li</ul>'));
            }
        } else {            
            $pesan = '<ul>';
            $errors = array_values($errors);
            foreach($errors as $error){
                $pesan .= '<li>'.$error.'</li>';
            }
            $pesan .= '</ul>';
            echo json_encode(array('status' => 'failed', 'message' => $pesan), JSON_PRETTY_PRINT);
        }
	}
}