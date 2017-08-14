<?php
require_once APPPATH . 'libraries/weixin.php';
/**
 * 每日抽奖次数模型
 * @author RunlongJu <hipop@126.com>
 *
 */
class Dateremainder_model extends CI_Model {

	private $_tablename = '';

	function __construct()
	{
		parent::__construct();
		$this->_tablename = $this->db->dbprefix('customer_remainder');
	}
	
	
	/**
	 * 更新一个信息
	 * @param string $openIdHash
	 * @param array $data
	 * @return int
	 */
	public function updateOne($openIdHash, $data)
	{
		$this->db->update($this->_tablename, $data, array(
			'openid_hash' => $openIdHash
		));
		
		return $this->db->affected_rows();
	}
	
	public function getOne($openIdHash, $columns = NULL)
	{
		if($columns){
			$this->db->select($columns);
		}

		$query = $this->db->get_where($this->_tablename, array(
			'openid_hash' => $openIdHash
		));
		$rs = $query->result_array();
		if($rs){
			return $rs[0];
		}
		return $rs;
	}

	
	public function del($openIdHash)
	{
		$this->db->where(array(
			'openid_hash' => $openIdHash
		));
		return $this->db->delete($this->_tablename);
	}
	
	/**
	 * 每日初始化
	 */
	public function daily()
	{
		$date = date('Y-m-d', time());
		/* if(isset($_SESSION['daily']) && $_SESSION['daily'] == $date){
			return;
		} */

		$openIdHash = $_SESSION['openid']['openIdHash'];
		$data = $this->getOne($openIdHash);

		// 把标识东东初始化
		if($data['dateflag'] != $date){
			$dbData = array(
				'is_uploadwork' => 0,
				'dateflag'      => date('Y-m-d', time()),
				'remainder'     => 1,
				'is_vote'       => 0,
				'is_shear'      => 0
			);
			$this->updateOne($openIdHash, $dbData);
			//$_SESSION['daily'] = $date;
		}
		return;
	}
	
	public function addRemaind($fc, $openIdHash)
	{
		// 检查是否上传过
		$data = $this->getOne($openIdHash);
		$flag = array(
			'work' => 'is_uploadwork',
			'shear'=> 'is_shear',
			'vote' => 'is_vote'
		);
		// 增量
		$addo = array(
			'work' => 2,
			'shear'=> 1,
			'vote' => 1
		);
		$addition = 0;
		if(isset($flag[$fc]) && isset($addo[$fc])){
			$flag     = $flag[$fc];
			$addition = $addo[$fc];
		}else{
			return;
		}
		if($data[$flag] == 0 && $data['dateflag'] == date('Y-m-d', time())){
			$dbData = array(
				$flag       => 1,
				'dateflag'  => date('Y-m-d', time()),
				'remainder' => $data['remainder'] + $addition
			);
			$this->updateOne($openIdHash, $dbData);
		}
		return;
	}

	public function upload($openIdHash)
	{
		$this->addRemaind('work', $openIdHash);
	}
	

	public function vote($openIdHash)
	{
		$this->addRemaind(__FUNCTION__, $openIdHash);
	}
	
	public function shear($openIdHash)
	{
		$this->addRemaind(__FUNCTION__, $openIdHash);
	}
}