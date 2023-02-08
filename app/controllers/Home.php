<?php 
class Home extends Controller{
	public function __construct()
	{
		if(isset($_SESSION['login'])) {
			header('Location: ' . BASEURL . '/dashboard');
			exit;
		}
	}

    public function index(){
		$data['title'] = 'Dosaku';
		$this->view('templates/header_auth', $data);
		$this->view('home/index');
		$this->view('templates/footer_auth');
	}
}