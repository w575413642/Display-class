<?php
class Dealer_model extends CI_Model {

    private $_tablename = '';

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->_tablename = $this->db->dbprefix('dealer');
    }
    
    /**
     * 获取经销商及省市数据列表
     * @param string $type
     * @param string $key 关键字
     */
    public function getList($type, $key = NULL)
    {
		$key = empty($key)?'':$key;
    	$sql = 'SELECT * FROM `' .$this->_tablename. '` WHERE 1=1';
		$colum = '';
		
		switch($type){
			case 'province':
				$sql = 'SELECT pro FROM `' .$this->_tablename. '` WHERE 1=1 GROUP BY pro ';
				$colum = 'pro';
			break;
			
			case 'city':
				$sql .= " AND  `pro` = ?  GROUP BY city ";
				$colum = 'city';
			break;
			
			case 'dealer':
				$sql .= " AND `city` = ? ";
				$colum = 'dealer';
			break;
		}
		
        $query = $this->db->query($sql, array(
        	$key
        ));
        $result = $query->result_array();
		//die($this->db->last_query());
		$rs = array();
		if($result){
			foreach($result as $k=>$v){
				$rs[] = $v[$colum];
			}
		}
        return $rs;
    }
	
	public function adddrive($data){
		return $this->db->insert($this->db->dbprefix('testdrive'), $data);
	}
}