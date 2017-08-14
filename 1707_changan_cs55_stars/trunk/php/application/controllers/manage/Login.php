<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{
    /**
     * Base_model
     * @var Base_model
     */
    public $Base_model;

    public function __construct()
    {
        parent::__construct();

        $this->load->library('session');
		$this->load->helper('url');

		$c = $this->router->class;
		$m = $this->router->method;
		//echo $m;
		//die();
		$noChckSession = array(
			'login/index',
			'login/login',
			'login/logout'
		);

		if(!in_array($c.'/'.$m , $noChckSession)){
			if(empty($this->session->admin_user)){
			    header('HTTP/1.0 403 Forbidden');

			    if($this->input->is_ajax_request()){
    				$json = array('code'=>403);
    				$this->json($json);
			    }else{
			        redirect(site_url('manage/login'));
			    }
			}
		}
    }

    /**
     * 输出json
     * @param mixed $json
     */
    public function json($json, $code = 200, $msg = '')
    {
        $rs = array();
        header ( 'Content-type: application/json' );
        if (!empty($json['data']) || !empty($json['code'])){
            $rs = $json;
        }else{
            $rs = array(
                'data' => $json,
                'code' => $code,
                'msg'  => $msg
            );
        }
		echo json_encode($rs);
		die();
    }

	public function index()
	{
	    if($this->input->method() == 'get'){
	        if(!empty($this->session->userdata['admin_user'])){
	            redirect(site_url('manage'));
	        }
	        $this->load->view('manage/login',array(
	            'msg'=>'',
	            'username' => '',
	            'password' => ''
	        ));
            return;
	    }
        $this->load->library('form_validation');
		$data = array();
        $data['username'] = $this->input->post('username');
        $data['password'] = $this->input->post('password');

		$config = array(
            array(
                'field' => 'username',
                'label' => '用户名',
                'rules' => 'required'
            ),
            array(
                'field' => 'password',
                'label' => '密码',
                'rules' => 'required'
            )
		);

		$this->form_validation->set_data($data);
        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() !== FALSE){
			$data['password'] = md5($data['password'] . 'S@#XF');
            $this->db->where($data);
			$rs = $this->db->get('manage');
			$rs = $rs->result_array();
			if(!empty($rs[0])){
			    //$_SESSION['admin_user'] = $rs[0];
 				$this->session->set_userdata('admin_user', $rs[0]);
				$json = array('code'=>200);
				redirect(site_url('manage'));
			}else{
			    $json = array('code'=>403);
			}
        }else{
            $json = array('code'=>601,'msg' => $this->form_validation->error_string());
        }

        $error_msg = array(
        	'601' => '表单填写有误',
            '403' => '用户名或密码错误'
        );
        $json['msg'] = $error_msg[$json['code']];
        $json['username'] = $data['username'];
        $json['password'] = $data['password'];

        if($this->input->is_ajax_request()){
            $this->json($json);
        }else{
            $this->load->view('manage/login', $json);
        }
	}

	public function logout()
	{
		$this->session->admin_user = null;
		$json = array('code'=>200);
        $json['msg'] = '';
        $json['username'] = '';
        $json['password'] = '';
        $this->load->view('manage/login',$json);
	}

}