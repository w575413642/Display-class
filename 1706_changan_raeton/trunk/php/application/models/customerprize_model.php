<?php
require_once APPPATH . 'libraries/weixin.php';
/**
 * 中奖信息模型
 * @author RunlongJu <hipop@126.com>
 *
 */
class Customerprize_model extends CI_Model {

	private $_tablename = '';

	function __construct()
	{
		parent::__construct();
		$this->_tablename = $this->db->dbprefix('customer_prize');
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
	 * 获取某个用户的中奖列表
	 */
	public function getListByCust($openIdHash, $columns = NULL)
	{
		if($columns){
			$this->db->select($columns);
		}

		$this->db->order_by('id', 'DESC');
		$query = $this->db->get_where($this->_tablename, array(
			'openid_hash' => $openIdHash
		));
		$rs = $query->result_array();
		return $rs;
	}
	
	public function mashTel($tel)
	{
		$telMash = preg_replace('/^(\d{3})(\d{5})(\d+)$/i', '\1*****\3', $tel);
		if($telMash == NULL || $telMash == $tel){
			$telMash = "***********";
		}
		return $telMash;
	}
	
	public function getCount()
	{
		$this->db->group_by('openid_hash');
		return $this->db->count_all_results($this->_tablename);
	}

	public function getCountAll()
	{
		return $this->db->count_all_results($this->_tablename);
	}
	
	/**
	 * 全部列表，供前端用
	 */
	public function getListAll($page=1)
	{
		$page     = max((int)$page, 1);
		$pageSize = 50;
		$offset   = ($page-1)*50;
		
		$this->db->order_by('id', 'DESC');
		$list = $this->db->get($this->_tablename, $pageSize, $offset);
		$list = $list->result_array();
		

		if(!empty($list)){
			$custArr  = array();
			$prizeArr = array();
			foreach ($list as $row){
				$custArr[$row['openid_hash']] = 1;
				$prizeArr[$row['prize']]      = 1;
			}
			$custArr  = array_keys($custArr);
			$prizeArr = array_keys($prizeArr);
			
			$this->db->select('openid_hash, name, tel');
			$this->db->where_in('openid_hash', $custArr);
			$custArr = $this->db->get('customer');
			$custArr = $custArr->result_array();
			$custKV = array();
			foreach ($custArr as $row){
				$custKV[$row['openid_hash']] = $row;
			}
	
			$this->db->select('id, name');
			$this->db->where_in('id', $prizeArr);
			$prizeArr = $this->db->get('prize');
			$prizeArr = $prizeArr->result_array();
			$prizeKV = array();
			foreach ($prizeArr as $row){
				$prizeKV[$row['id']] = $row['name'];
			}
			
			foreach ($list as &$row){
				if(empty($prizeKV[$row['prize']])){
					continue;
				}
				$row['prize'] = $prizeKV[$row['prize']];
				$row['name']  = $custKV[$row['openid_hash']]['name'];
				$row['tel']   = $this->mashTel($custKV[$row['openid_hash']]['tel']);
				unset($row['openid_hash']);
			}
		}
		
		return $list;
	}
	

	/**
	 * 全部列表，供后台用
	 */
	public function getListAllDetail($page=1, $isOrderCut=FALSE, $pageSize = 100)
	{
		$page     = max((int)$page, 1);
		//$pageSize = 100;
		$offset   = ($page-1)*$pageSize;
	
		$list = array();
		if($isOrderCut){
			$this->db->order_by('openid_hash', 'DESC');
			$list = $this->db->get($this->_tablename, $pageSize, $offset);
			$list = $list->result_array();
		}else{
			$this->db->order_by('id', 'DESC');
			$list = $this->db->get($this->_tablename, $pageSize, $offset);
			$list = $list->result_array();
		}
		
		if(!empty($list)){
			$custPrizeArr = array();
			$custArr  = array();
			$prizeArr = array();
			foreach ($list as $row){
				$custPrizeArr[$row['openid_hash']] = $row;
				$custArr[$row['openid_hash']] = 1;
				$prizeArr[$row['prize']]      = 1;
			}
			$custArr  = array_keys($custArr);
			$prizeArr = array_keys($prizeArr);
		
			$this->db->select('openid_hash, name, tel, address,car_code,oldowner_hash');
			$this->db->where_in('openid_hash', $custArr);
			$custArr = $this->db->get('customer');
			$custArr = $custArr->result_array();
			$custKV = array(); // 客户 hash->信息的键值对
			foreach ($custArr as $row){
				$hashFlag = $row['openid_hash'];
				$custPrizeItem = $custPrizeArr[$hashFlag];
				if(!empty($custPrizeItem['name'])){
					$row['name'] = '*' . $custPrizeItem['name'];
				}
				if(!empty($custPrizeItem['tel'])){
					$row['tel'] = '*' . $custPrizeItem['tel'];
				}
				$custKV[$hashFlag] = $row;
			}
		
			$this->db->select('id, name');
			$this->db->where_in('id', $prizeArr);
			$prizeArr = $this->db->get('prize');
			$prizeArr = $prizeArr->result_array();
			$prizeKV = array();
			foreach ($prizeArr as $row){
				$prizeKV[$row['id']] = $row['name'];
			}
			//var_dump($custKV);die();
		
			foreach ($list as &$row){
				$row['prize']     = $prizeKV[$row['prize']];
				$row['name']      = $custKV[$row['openid_hash']]['name'];
				$row['tel']       = $custKV[$row['openid_hash']]['tel'];
				$row['address']   = $custKV[$row['openid_hash']]['address'];

				$oldownerHash     = $custKV[$row['openid_hash']]['oldowner_hash'];
				$row['oldowner']  = empty($custKV[$oldownerHash])?'':$custKV[$oldownerHash]['name'];
				$row['car_code']  = $custKV[$row['openid_hash']]['car_code'];
				//unset($row['openid_hash']);
			}
		}
	
		return $list;
	}
}