<?php

class Login extends Controller{
	public function index(){
		$data['title'] = 'Login | Dosaku';
		$this->view('templates/header_auth', $data);
		$this->view('login/index');
		$this->view('templates/footer_auth');
	}

    public function isLogin(){
        $errors = array();
        if(empty($_POST['email'])){
            $errors['email'] = 'Email tidak boleh kosong';
        }

        if(empty($_POST['password'])){
            $errors['password'] = 'Password tidak boleh kosong';
        }

        if(empty($errors)){
            $user = $this->model('User_model');
            $user->setEmail($_POST['email']);
            $user->setPassword($_POST['password']);
            if($user->login() > 0){
                $_SESSION['login'] = true;
                $_SESSION['user'] = $user->tampilUser();
                echo json_encode(array('status' => 'success', 'message' => 'Login berhasil'));
            }else{
                echo json_encode(array('status' => 'failed', 'message' => '<ul><li>Email atau password salah</li</ul>'));
            }
        } else {
            $pesan = '<ul>';
            $errors = array_values($errors);
            foreach($errors as $error){
                $pesan .= '<li>'.$error.'</li>';
            }
            $pesan .= '</ul>';
            echo json_encode(array('status' => 'failed', 'message' => $pesan));
        }
    }

    public function logout(){
        session_destroy();
        header('location: '. BASEURL . '/login');
        exit;
    }
}