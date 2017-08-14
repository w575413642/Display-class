<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->library('session');
		$this->load->helper('url');
		$this->load->database();
		$this->load->model('User_model');
		$sesid = $this->session->userdata('admin');
		if(empty($sesid)){
			$router = $this->router;
			$m = $router->fetch_method();
			$c = $router->fetch_class();
			if (($c == 'login' && ($m == 'index' || $m == 'logout')) == false){
				$this->load->helper('url');
				redirect(site_url('c=login&m=index'), 'refresh');
			}
		}
	}

	public function index()
	{
		$sesid = $this->session->userdata('admin');
		if(!empty($sesid)){
			redirect(site_url('c=admin&m=index'), 'refresh');
		}

		$data = array(
			'message' => ''
		);
		$usr = trim($this->input->post('username'));
		$psw = trim($this->input->post('password'));
		if($usr && $psw){
			$usrId = $this->User_model->check($usr,$psw);
			if(empty($usrId)){
				$data['message'] = '密码或用户名错误';
			}else {
				$this->session->set_userdata('admin', $usrId);
				redirect(site_url('c=admin&m=index'), 'refresh');
			}
		}

		$this->load->view('login',$data);
	}

	public function logout()
	{
		$this->session->sess_destroy();
		redirect(site_url('c=login&m=index'), 'refresh');
	}

	public function changepsw()
	{
		$psw = $this->input->get('password');
		$psw2 = $this->input->get('password2');
		if($psw2 == $psw){
			$id = $this->session->userdata('admin');
			$this->User_model->changepsw($id, $psw);
		}
		$this->logout();
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */