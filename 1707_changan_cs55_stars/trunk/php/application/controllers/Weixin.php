<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * wx接口
 * @property Customer_model $Customer_model
 */
class Weixin extends CI_Controller {

	/**
	 * 微信用户信息
	 * @var array
	 */
	protected $userInfo;

	public function __construct(){

	    //@todo 这是debug
	    //$_COOKIE['wxopenid'] = 'f08bd544a5699250b29e4bbcf7546748';

		parent::__construct();
		$this->load->helper('url');
		$this->load->helper('cookie');

		$this->load->model('Customer_model');

		$code = $this->input->get('code');
        $uid = $this->uri->segment(4,0);
		$dircUrl = site_url($_SERVER['QUERY_STRING']);
		$this->userInfo = $this->Customer_model->getWxUserinfo(null, $code, $dircUrl,$uid);
        //print_r($this->userInfo);
        //die();
		$this->load->vars('userInfo', $this->userInfo);
	}

	/**
	 * 输出json
	 * @param mixed $json
	 */
	protected function json($json, $code = 200, $msg = '')
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
		$this->output->_display();
	}
}