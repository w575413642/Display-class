<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 提供给前端的接口
 */
class Api extends CI_Controller {

	private $uploadUrl = '';

	public function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->database();
		$this->load->model('Drive_model');
		
		//$this->output->enable_profiler();
	}
	
	public function jssdk(){
		//die('../libraries/Wx/jssdk.php');
		//require_once('../../libraries/Wx/jssdk.php');
		$this->load->library('Wx/jssdk.php');
		//cha wx2787b05a5d258312 8db1c9831c6c05c53d2bf7a5c2a249eb
		//cti wx35212803f42d66ba a754489a2c7a2075c71dba1eccff7c0f
		$jssdk = new JSSDK("wx35212803f42d66ba", "a754489a2c7a2075c71dba1eccff7c0f");
		$signPackage = $jssdk->GetSignPackage();
		//print_r($signPackage);
		$this->load->view('jssdk.php',array('signPackage'=>$signPackage));
	}
	
	public function visitorin(){
		$uname = self::generate_uname(6);
		$this->db->insert('customer',array('username'=>$uname,'intime'=>time()));
		//$row = $this->db->select_max('id')->result_array()
		//print_r($row);
		$userid = $this->db->insert_id();
		echo json_encode(array('code'=>200,'lastid'=>$userid,'username'=>$uname));
	}

	public function generate_uname( $length = 6 ) { 
		// 密码字符集，可任意添加你需要的字符 
		$chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'; 
		$password =''; 
		for ( $i = 0; $i < $length; $i++ ) 
		{ 
			// 这里提供两种字符获取方式 
			// 第一种是使用 substr 截取$chars中的任意一位字符； 
			// 第二种是取字符数组 $chars 的任意元素 
			// $password .= substr($chars, mt_rand(0, strlen($chars) – 1), 1); 
			$password .= $chars[ mt_rand(0, strlen($chars) - 1) ]; 
		} 
		return $password; 
	} 
	
	public function livemsg(){
		//$userid = $this->input->get_post('userid');
		//$username = $this->input->get_post('username');
		//$richtext = $this->input->get_post('richtext');
		$data = $this->input->post();
		unset($data['c']);
		unset($data['m']);
		//print_r($data);
		$ctime = time();
		$data['ctime'] = time();
		$this->db->insert('customer_msg',$data);
	}
	
	/*直播赞*/
	public function addup(){
		$tname = $this->db->dbprefix('addup');
		return $this->db->simple_query("UPDATE {$tname} set addup = addup+1 where id=1;");
	}
	public function getaddup(){
		$tname = $this->db->dbprefix('addup');
		$returndata = array("code"=>500,"num"=>0);
		$row = $this->db->from($tname)->limit(1,0)->get()->first_row();
		if(!empty($row)){
			$returndata['code'] = 200;
			$returndata['num'] = $row->addup;
		}
		echo json_encode($returndata);
	}
	/**
	 * 接受用户表单信息
	 * 验证  客户 手机号码是否重复
	 * 写入数据库
	 */
    public function get_cusinfo ()
    {
        //接受信息
        $posts['uname']       = $this->input->get_post('uname');
        $posts['phone']       = (int)$this->input->get_post('phone');
        $posts['sex']         = $this->input->get_post('sex');
        $posts['mototype']    = $this->input->get_post('mototype');
        $posts['age']         = (int)$this->input->get_post('age');
        $posts['create_date'] = time();
        //验证手机号
        $re_phone = $this->Drive_model->select_phone($posts['phone']);
        //var_dump(!$re_phone);
        if (!$re_phone) {
            //验证年龄
            if ($posts['age'] > 5 && $posts['age'] < 101) {
                //写入数据库
            	$re_insert = $this->Drive_model->insert($posts);
            	//var_dump($re_insert);
                if ($re_insert) {
                    $data = array(
                        'code' => 200,
                        'msg'  => '操作成功'
                    );
                }else {
                    $data = array(
                        'code' => 400,
                        'msg'  => '数据库写入失败'
                    );
                }
            }else {
                $data = array(
                    'code' => 400,
                    'msg'  => '年龄不符'
                );
            }
        	
        }else {
            $data = array(
                'code' => 403,
                'msg'  => '手机号已经提交过了'
            );
        }
        
        echo json_encode($data);
    }
    /**
     * 接受厂商信息
     * 验证 厂商 手机号是否重复
     * 写入数据库
     */
    public function get_deainfo ()
    {
        //接受信息
        $posts['uname']       = $this->input->get_post('uname');
        $posts['phone']       = (int)$this->input->get_post('phone');
        $posts['dealer']      = $this->input->get_post('dealer');
        $posts['create_date'] = time();
        //验证手机号
        $re_phone = $this->Drive_model->select_phone_dealer($posts['phone']);
        if (!$re_phone) {
            //写入数据库
            $re_insert = $this->Drive_model->insert($posts);
            //var_dump($re_insert);
            if ($re_insert) {
                $data = array(
                    'code' => 200,
                    'msg'  => '操作成功'
                );
            }else {
                $data = array(
                    'code' => 400,
                    'msg'  => '数据库写入失败'
                );
            }
        }else {
            $data = array(
                'code' => 403,
                'msg'  => '手机号已经提交过了'
            );
        }
        
        echo json_encode($data);
        
    }
    
	// public function testdrive_province()
	// {
	// 	$list = $this->Dealer_model->getList('province');

	// 	$data = array(
	// 		'code' => 200,
	// 		'msg'  => 'ok',
	// 		'data' => $list
	// 	);

	// 	header('Content-type: application/json');
	// 	echo json_encode($data);
	// 	die();
	// }

	// public function testdrive_city()
	// {
	// 	$key  = $this->input->get_post('province');
	// 	$list = $this->Dealer_model->getList('city', $key);

	// 	$data = array(
	// 		'code' => 200,
	// 		'msg'  => 'ok',
	// 		'data' => $list
	// 	);

	// 	header('Content-type: application/json');
	// 	echo json_encode($data);
	// 	die();
	// }

	// public function testdrive_dealers()
	// {
	// 	$key  = $this->input->get_post('city');
	// 	$list = $this->Dealer_model->getList('dealer', $key);

	// 	$data = array(
	// 		'code' => 200,
	// 		'msg'  => 'ok',
	// 		'data' => $list
	// 	);

	// 	header('Content-type: application/json');
	// 	echo json_encode($data);
	// 	die();
	// }

	public function getIp(){
		$ip=false;
		if(!empty($_SERVER["HTTP_CLIENT_IP"])){
		 $ip = $_SERVER["HTTP_CLIENT_IP"];
		}
		if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
		 $ips = explode (", ", $_SERVER['HTTP_X_FORWARDED_FOR']);
		 if($ip){
		  array_unshift($ips, $ip); $ip = FALSE;
		 }
		 for($i = 0; $i < count($ips); $i++){
		  if (!preg_match("/^(10|172.16|192.168)/i", $ips[$i])){
		  $ip = $ips[$i];
		  break;
		  }
		 }
		}
		return($ip ? $ip : $_SERVER['REMOTE_ADDR']);
	}
	
	/**
	 * 预约试驾 手机号唯一
	 * 预约试驾成功，生成抽奖码
	 */
	public function testdrive_adddrive(){
		$data = array();
		$data['uname'] = $this->input->get_post('uname');
		$data['phone'] = $this->input->get_post('phone');
		//$data['procode'] = $this->input->get_post('procode');
		$data['province'] = $this->input->get_post('province');
		//$data['citycode'] = $this->input->get_post('citycode');
		$data['city'] = $this->input->get_post('city');
		//$data['dealerid'] = $this->input->get_post('dealerid');
		//$data['dealercode'] = $this->input->get_post('dealercode');
		$data['dealer'] = $this->input->get_post('dealer');
		$data['drive_date'] = $this->input->get_post('dtime');
		$data['order_date'] = $this->input->get_post('otime');
		$data['sex'] = $this->input->get_post('sex');
		$data['from_usergent'] = $this->input->get_post('from_usergent');
		$data['cartype'] = $this->input->get_post('cartype');
		$callback = $this->input->get_post('callback');
		$data['create_date'] = time();
		$ip = self::getIp();
		$data['create_ip'] = $ip;
		$phone = $data['phone'];
		if(!preg_match('/^1([0-9]{9})/',$phone)){
			$data = array(
				'code' => 601,
				'msg'  => '无效的手机号码'
			);
		}else{
			// 检查phone是否存在过
			$phoneExist = $this->Drive_model->getOneByPhone($phone);
			//$ipExist = $this->Drive_model->getCountByIp($ip);
			$phoneExist = (bool)$phoneExist;
			// if($ipExist){
			// 	$data = array(
			// 		'code' => 403.1,
			// 		'msg'  => '提交成功!'
			// 	);
			// }else 
			if($phoneExist){
				$data = array(
					'code' => 403.1,
					'msg'  => '手机号已经提交过了'
				);
			}else{
				// print_r($data);
				//$raffle_code = $data['raffle_code'] = md5(uniqid($phone));
				$result = $this->Drive_model->insert($data);
				$data = array(
					'code' => 500,
					'msg'  => '提交失败'
				);
				if($result){
					$data = array(
						'code' => 200,
						//'raffle_code' => $raffle_code,
						'msg'  => '提交成功'
					);
				}
			}
		}
		header('Content-type: application/json');
		if($callback!=''){
			echo $callback."(".json_encode($data).")";
		}else{
			echo json_encode($data);
		}
		die();
	}
}