<?php
class Sale_model extends CI_Model {

	private $_tablename = '';

	function __construct()
	{
		// Call the Model constructor
		parent::__construct();
		$this->_tablename = $this->db->dbprefix('auto_sale');
	}

	/**
	 * 车主认证
	 */
	public function check($carcode)
	{
		$sql = "SELECT * FROM `{$this->_tablename}` WHERE `SHORT_VIN` = ?";
		$query = $this->db->query($sql, array($carcode));
		$result = $query->result_array();
		//var_dump($this->db->last_query());
		if(!empty($result[0]['SHORT_VIN'])){
			return true;
		}
		return false;
	}
	
	/**
	 * 获取最大的日期
	 * @return string maxDateTime
	 */
	function getMaxDate()
	{
		$sql = "SELECT MAX(`SALE_DATE`) AS `SALE_DATE` FROM `{$this->_tablename}` ";
		$query = $this->db->query($sql);
		$result = $query->result_array();
		if(!empty($result[0]['SALE_DATE'])){
			$result = $result[0]['SALE_DATE'];
		}else{
			$result = '1970-01-01 00:00:00';
		}
		return $result;
	}

	/**
	 * 更新数据
	 */
	function insertData($data)
	{
		if(is_array($data)){
			if($this->db->insert_batch('auto_sale', $data) == false){
				$data2 = array(
					'SALE_DATE' => $data[SALE_DATE]
				);
				$where = array(
					'SHORT_VIN' => $data['SHORT_VIN']
				);
				$this->db->set($data2);
				$this->db->where($where);
				return $this->db->update('auto_sale');
			}
			return true;
		}
		return false;
	}
}