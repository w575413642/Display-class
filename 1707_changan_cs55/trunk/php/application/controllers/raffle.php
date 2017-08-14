<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 抽奖相关接口
 */
class Raffle extends CI_Controller {

	private $uploadUrl = '';

	/**
	 *
	 * @var Customer_model
	 */
	public $Customer_model;

	/**
	 *
	 * @var Raffle_model
	 */
	public $Raffle_model;

	/**
	 *
	 * @var array(openId,raffle_code)
	 */
	public $openIdArr;

	public function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->database();
		$this->load->model('Raffle_model');
		$this->load->model('Drive_model');
	}

	public function index()
	{
		die('ok');
	}

	public function raffledirect(){
		$raffle_key = $this->input->get('key');
		$config = $this->config;
		if($raffle_key =='' || $raffle_key != md5($config->config['rafflekey'])){
			die("非法请求!");
		}
		$raffle_code = $this->input->get('raffle_code');
		$prizeId = $this->input->get('prizeId');
		$time = $this->input->get('time');
		$time = $time>0?$time:time();
		//echo $raffle_code;
		//die();
		$rs = $this->Raffle_model->raffledirect(array("raffle_code"=>$raffle_code,"prizeId"=>$prizeId,"time"=>$time));
		// 统计抽奖次数
		$this->db->insert('total',array(
			'dateflag' => date('Y-m-d', $time),
			'type' => 3
		));
		echo json_encode($rs);
		die();
	}
	/**
	 * 尝试抽取奖品
	 */
	public function doraffle()
	{
		$raffle_code = $this->input->get_post('raffle_code');
		$callback = $this->input->get_post('callback');
		if(!empty($raffle_code)){
			$prize = array();
			$raffleArr = $this->Raffle_model->raffle($raffle_code);
			if($raffleArr){
				$prizeId = $raffleArr['prizeId'];
				$prizeInfo = $this->Raffle_model->getPrize($prizeId);
				if(!empty($prizeInfo)){
					$prize = array(
						'id'   => $prizeInfo['id'],
						'key'  => $prizeInfo['key'],
						'name' => $prizeInfo['name']
					);
					
					if(!empty($raffleArr['customer_prize_id'])){
						$prize['customer_prize_id'] = $raffleArr['customer_prize_id'];
					}
				}
			}else{
				$prize = array(
					'id'   => 0,
					'key'  => '',
					'name' => 'ops not winning'
				);
			}

			try{
				// 统计抽奖次数
				$this->db->insert('total',array(
					'dateflag' => date('Y-m-d', time()),
					'type' => 3
				));
			}catch(Exception $e){

			}

			// 重新获取剩余抽奖次数
			$custRemainder      = $this->Drive_model->getOneByRaffleCode($raffle_code);
			$custRemainder      = (int)$custRemainder['remainder'];
			$prize['remainder'] = $custRemainder;
		}else{
			// 关闭抽奖
			$prize = array(
				'id'   => 0,
				'key'  => '',
				'name' => 'not winning'
			);
		}
		$data = array(
			'code' => 200,
			'msg'  => 'ok',
			'data' => $prize
		);

		header('Content-type: application/json');
		if($callback!=''){
			echo $callback."(".json_encode($data).")";
		}else{
			echo json_encode($data);
		}
		die();
	}


	/**
	 * 个人中奖信息
	 */
	public function get()
	{
		$raffle_code = $raffle_code;
		$this->load->model('Customerprize_model');
		$list = $this->Customerprize_model->getListByCust($raffle_code);
		foreach ($list as &$row){
			$prizeId = (int)$row['prize'];
			$prizeInfo = $this->Raffle_model->getPrize($prizeId);
			if(!empty($prizeInfo)){
				$row['name'] = $prizeInfo['name'];
				$row['key']  = $prizeInfo['key'];
			}
			unset($row['openid_hash']);
		}

		$custRemainder = $this->Customer_model->getOne($raffle_code);
		$custRemainder = (int)$custRemainder['remainder'];

		$data = array(
			'code' => 200,
			'msg'  => 'ok',
			'data' => array(
				'remainder' => $custRemainder,
				'list'      => $list
			)
		);

		header('Content-type: application/json');
		echo json_encode($data);
		die();
	}

	/**
	 * 全部中奖信息
	 */
	public function listall()
	{
		$page = (int)($this->input->get('page'));
		$page = empty($page)?1:$page;
		$this->load->model('Customerprize_model');
		$list = $this->Customerprize_model->getListAll($page);

		$data = array(
			'code' => 200,
			'msg'  => 'ok',
			'data' => array(
				'page' => $page,
				'list' => $list
			)
		);

		header('Content-type: application/json');
		echo json_encode($data);
		die();
	}
}