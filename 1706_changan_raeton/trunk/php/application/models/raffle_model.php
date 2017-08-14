<?php
require_once APPPATH . 'libraries/weixin.php';
/**
 * 抽奖模型
 * @author RunlongJu <hipop@126.com>
 *
 */
class Raffle_model extends CI_Model {

	private $_tablename = '';

	/**
	 * 客户端cookie名
	 */
	public $cookieName = 'wxopenid';

	function __construct()
	{
		parent::__construct();
		$this->_tablename = $this->db->dbprefix('prize');
		$this->load->model('Drive_model');
	}
	public function raffledirect($raffledata){
		try{
		$rs = array();
		$this->db->trans_start();
		$testdrvInfo = $this->Drive_model->getOneByRaffleCode($raffledata['raffle_code']);
		if(empty($testdrvInfo)){
			die("不存在的记录");
		}
		if(intval($testdrvInfo['prize'])>0){
			die("不要太贪心哦");
		}
		$testdrvID = $testdrvInfo['id'];
		$this->Drive_model->update(array('remainder' => 0), $testdrvID);
		$rowQr = $this->db->get_where($this->_tablename, array('id' => $raffledata['prizeId']));
		$row   = $rowQr->result_array();
		if(empty($row)){
			die("不存在的奖品");
		}
		$row = $row[0];
		// 剩余
		$remainder = (int)($row['remainder']);
		if($remainder==0){
			die("啊哦，奖被抽完了。");
		}
		$remainder = $remainder >0 ? $remainder - 1:0;
		$this->db->update($this->_tablename, array(
			'remainder' => $remainder
		), array(
			'id' => $raffledata['prizeId']
		));
		$rs['prizeId'] = $raffledata['prizeId'];
		if($rs){
			$data = array(
				'prize'       => $raffledata['prizeId'],
				'raffle_time' => $raffledata['time'],
				'raffle_date' => date('Y-m-d', $raffledata['time']),
				'raffle_ip' => $_SERVER['REMOTE_ADDR']
			);
			$this->Drive_model->update($data, $testdrvID);
			//try{
			$rs['customer_prize_id'] = $raffledata['prizeId'];
			//}catch(Exception $e){}
		}
		$this->db->trans_complete();
		}catch(Exception $e){
			$this->db->trans_rollback();
			throw $e;
		}
		return $rs;
	}
	/**
	 * 执行抽奖
	 * @param string $raffle_code
	 * @throws Exception
	 * @return Ambigous <NULL, number>
	 */
	public function raffle($raffle_code)
	{
		$rs = array();
		if(!empty($raffle_code)){
			try{
				$this->db->trans_start();
				//获取奖品列表
				$prizeId = 0;
				// 检查抽奖次数
				$testdrvInfo = $this->Drive_model->getOneByRaffleCode($raffle_code);
				$custRemainder = (int)$testdrvInfo['remainder'];
				$testdrvID = $testdrvInfo['id'];
				if($custRemainder < 1){
					// 没有抽奖机会了
					return $rs;
				}else{
					// 抽奖次数递减
					$custRemainder--;
					//$this->Drive_model->updateOne($raffle_code, array('remainder' => $custRemainder));
					$this->Drive_model->update(array('remainder' => $custRemainder), $testdrvID);
				}
				/* $hasRaffleQr = $this->db->get_where('customer', array('openid_hash' => $raffle_code )); 
				$hasRaffle = $hasRaffleQr->result_array();
				if($hasRaffle && count($hasRaffle) > 0){
					$hasRaffleTime = $hasRaffle[0]['raffle_time'];
					$hasRafflePriz = (int)($hasRaffle[0]['prize']);
					if(!empty($hasRafflePriz)){
						// 已经抽过奖,并且中奖了
						return $rs;
					}
				} */
				
				$prizeArr = array();
				$query = $this->db->get_where($this->_tablename, array('enabled' => 1));
				$prizeArr = $query->result_array();
				if(is_array($prizeArr)){
					shuffle($prizeArr);
					foreach ($prizeArr as $prize){
						$probability = (int)($prize['probability']);
						$prizeId = (int)($prize['id']);
						if($probability > 0){
							// 决定命运的函数
							$rand = mt_rand(1, $probability);
							if($rand == 1){
								//抽中此奖品
								$rowQr = $this->db->get_where($this->_tablename, array('id' => $prizeId));
								$row   = $rowQr->result_array();
								if(is_array($row) && count($row) == 1){
									$row = $row[0];
									// 剩余
									$remainder = (int)($row['remainder']);
									if($remainder > 0){
										$remainder = $remainder - 1;
										$this->db->update($this->_tablename, array(
											'remainder' => $remainder
										), array(
											'id' => $prizeId
										));
										if($this->db->affected_rows() != 1){
											throw new Exception('Data consistency logic error ');
										}
										$rs['prizeId'] = $prizeId;
									}
								}
								break;
							} 
						}
						//判定概率结束
					}
					//循环结束
				}
				//判定结束
	
				//把获奖情况记录起来
				if($rs){
					$data = array(
						'prize'       => $rs['prizeId'],
						'raffle_time' => time(),
						'raffle_date' => date('Y-m-d', time()),
						'raffle_ip' => $_SERVER['REMOTE_ADDR']
					);
					$this->Drive_model->update($data, $testdrvID);
					try{
						$customerPrizeID = $this->db->insert_id();
						$rs['customer_prize_id'] = $customerPrizeID;
					}catch(Exception $e){}
				}
				$this->db->trans_complete();
			}catch (Exception $e){
				$this->db->trans_rollback();
				throw $e;
			}
		}
		return $rs;
	}
	
	/**
	 * 获取奖品信息
	 * @param int $id
	 * @return Ambigous <multitype:, unknown>
	 */
	public function getPrize($id)
	{
		$prize = array();
		$query = $this->db->get_where($this->_tablename, array(
			'id' => (int)$id
		));
		if($query){
			$rs = $query->result_array();
			if(is_array($rs) && count($rs) > 0){
				$prize = $rs[0];
			}
		}
		return $prize;
	}

	/**
	 * 获取全部奖品
	 * @param unknown $length
	 * @param unknown $offset
	 * @return unknown
	 */
	public function getListAll($length, $offset)
	{
		$sql = 'SELECT * FROM `' .$this->_tablename. '` WHERE 1=1  ORDER BY `enabled` DESC LIMIT ?, ?';
		$query = $this->db->query($sql, array(
			$offset,
			$length
		));
		$result = $query->result();
		return $result;
	}
	
	public function getCount()
	{
		$sql = 'SELECT count(1) as c FROM `' .$this->_tablename. '` WHERE 1=1 ';
		$query = $this->db->query($sql);
		$result = $query->result();
		return $result[0]->c;
	}
	
	public function del($id)
	{
		$this->db->where(array(
			'id' => $id
		));
		return $this->db->delete($this->_tablename);
	}

	public function add($data)
	{
		return $this->db->insert($this->_tablename, $data);
	}
	
	public function update($id, $data)
	{
		return $this->db->update($this->_tablename, $data, array('id'=>(int)$id));
	}
}