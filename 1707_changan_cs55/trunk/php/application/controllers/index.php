<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 首页
 * @author Jurunlong
 *
 */
class index extends CI_Controller {


	public function __construct(){
		parent::__construct();
        $this->load->helper('url');
	}
	/**
	 * 客户页面
	 */
	public function index ()
	{
	    $this->load->view('index.html');
	    //redirect(base_url('index.html'));
	}
	/**
	 * 厂商页面
	 */
	public function dealer ()
	{
	    $this->load->view('index-dealer.html');
	}
    public function test()
    {
        $this->load->view('index/index2.html');
        //redirect(base_url('h5'));
    }
}