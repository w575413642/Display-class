<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once('Weixin.php');
/**
 *
 * @author RunlongJu <hipop@126.com>
 * @property  Drive_model $Drive_model
 * @property  Shear_model $Shear_model
 * @property  Journey_model_model $Journey_model_model
 * @property  Raffle_model $Raffle_model
 * @property  Customer_model $Customer_model
 *
 */
class Test extends Weixin
{

    private $authurl = 'http://club.changan.com.cn/';

    private $username = 'OfficalWebSite';

    private $userpwd = 'clubWWW2016';

    private $returndata = array(
        "code" => 500,
        "data" => null,
        "msg" => ""
    );

    public function __construct ()
    {
        parent::__construct();
        $this->load->model('Journey_model');
        $this->load->model('Shear_model');
    }

    public function index ()
    {
        print_r($_GET);
    }

}