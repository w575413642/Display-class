<?php
class User_model extends CI_Model {

	private $_tablename = '';

	function __construct()
	{
		// Call the Model constructor
		parent::__construct();
		$this->_tablename = $this->db->dbprefix('user');
	}
	
	/**
	 * 检查登录
	 * @param string $usr
	 * @param string $psw
	 */
	function check($usr, $psw)
	{
		$psw = md5($psw);
		$sql = 'SELECT `id` AS `id` FROM `' .$this->_tablename. '` WHERE `username` = ? AND `password` = ? ';
		$query = $this->db->query($sql, array(
			$usr,
			$psw
		));
		$result = $query->result();
		if(!empty($result[0])){
			$result = $result[0]->id;
		}else{
			$result = FALSE;
		}
		return $result;
	}

	function changepsw($id, $psw)
	{
		$psw = md5($psw);
		$data = array(
			'password' => $psw
		);
		$result = $this->db->update($this->_tablename, $data, array('id'=>$id));
		return $result;
	}
}