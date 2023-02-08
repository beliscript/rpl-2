<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


//Load composer's autoloader
class ResetPassword extends Controller{
	public function index(){
		$data['title'] = 'Reset Password | Dosaku';
		$this->view('templates/header_auth', $data);
		$this->view('resetpassword/index');
		$this->view('templates/footer_auth');
	}

    private function kirimEmail($email, $token){
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
           $mail->Subject = 'Reset Password';
           $mail->Body = 'Klik link ini untuk mereset password: <a href="http://localhost/rpl1/resetpassword/reset/' . $token . '">Reset Password</a>';
           $mail->send();
           return true;
        } catch (Exception $e) {
           return false;
        }
    }

    public function isSendEmail(){
        $user = $this->model('User_model');
        $errors = array();
        if(empty($_POST['email'])){
            $errors['email'] = 'Email tidak boleh kosong';
        } else {
            if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
                $errors['email'] = 'Email tidak valid';
            } else {
                $user->setEmail($_POST['email']);
                if($user->tampilUser() < 1){
                    $errors['email'] = 'Email tidak terdaftar';
                }
            }
        }

        if(empty($errors)){
            $resetPassword = $this->model('ResetPassword_model');
            $resetPassword->setEmail($user->getEmail());
            $resetPassword->setToken(md5(uniqid(rand(), true)));
            $resetPassword->setTanggal(date('Y-m-d H:i:s', strtotime('+1 hour')));
            if($resetPassword->tambah() > 0){
                $result = $this->kirimEmail($resetPassword->getEmail(), $resetPassword->getToken());
                if($result){
                    echo json_encode(array('status' => 'success', 'message' => 'Silahkan cek email anda untuk mereset password'));
                } else {
                    echo json_encode(array('status' => 'failed', 'message' => $result['message']));
                }
            } else {
                echo json_encode(array('status' => 'failed', 'message' => 'Gagal mengirim email'));
            }
        } else {
            echo json_encode(array('status' => 'failed', 'message' => implode('<br>', $errors)));
        }
    }

    public function reset(){
        $data['title'] = 'Reset Password | Dosaku';
        $token = isset(explode('/', $_SERVER['REQUEST_URI'])[4]) ? explode('/', $_SERVER['REQUEST_URI'])[4] : '';
        if($token == ''){
            header('Location: '.BASEURL.'/resetpassword');
        }
        $resetPassword = $this->model('ResetPassword_model');
        $resetPassword->setToken($token);
       
        if($resetPassword->tampilResetPassword() < 1){
            header('Location: '.BASEURL.'/resetpassword');
        } else if ($resetPassword->tampilResetPassword()['tanggal'] < date('Y-m-d H:i:s')){
            $resetPassword->hapus();
            header('Location: '.BASEURL.'/resetpassword');
        }
        $data['token'] = $token;
		$this->view('templates/header_auth', $data);
		$this->view('resetpassword/reset', $data);
		$this->view('templates/footer_auth');
    }

    public function ubah()
    {
        $errors = array();
        $resetPassword = $this->model('ResetPassword_model');
        if(empty($_POST['token'])){
            $errors['token'] = 'Token tidak boleh kosong';
        } else {
            $resetPassword->setToken($_POST['token']);
            if($resetPassword->tampilResetPassword() < 1){
                $errors['token'] = 'Token tidak valid';
            }
        }
        if(empty($_POST['password'])){
            $errors['password'] = 'Password tidak boleh kosong';
        } else {
            if(empty($_POST['password_confirmation'])){
                $errors['password_confirmation'] = 'Password konfirmasi tidak boleh kosong!';
            } else if ($_POST['password'] != $_POST['password_confirmation']){
				$errors['password_confirmation'] = 'Password konfirmasi tidak sama!';
			}
        }
        if(empty($errors)){
			$dataUser = $resetPassword->tampilResetPassword();
            $user = $this->model('User_model');
            $user->setEmail($dataUser['email']);
			$user->setPassword(password_hash($_POST['password'], PASSWORD_DEFAULT));
			if($user->ubahPassword() >= 0){
                $resetPassword->hapus();
				echo json_encode(array('status' => 'success', 'message' => 'Password berhasil diubah'));
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