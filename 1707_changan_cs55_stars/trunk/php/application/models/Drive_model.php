<?php
/**
 * 试驾数据模型
 * @author Jurunlong
 *
 */
class Drive_model extends CI_Model {

    private $_tablename = '';
    private $_cname = 'customer';

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->_tablename = $this->db->dbprefix('journey');
        $this->_cname = $this->db->dbprefix('customer');
    }


    /**
     * 列表
     * @param int $length 获取数量
     * @param int $offset 起始位置
     */
    public function getList($length, $offset,$where='1=1')
    {
    	$sql = 'SELECT * FROM `' .$this->_tablename. '` WHERE '.$where.' ORDER BY `id` DESC LIMIT ?, ?';
        $query = $this->db->query($sql, array(
        	$offset,
        	$length
        ));
        $result = $query->result();
        return $result;
    }


    public function getPrizeListAll($length, $offset)
    {
    	$sql = 'SELECT c.bbs_username,c.bbs_mobile,j.raffle_time,j.prize FROM `' .$this->_cname. '` c,'.$this->_tablename.' j WHERE c.cookie=j.cookie';
    	$query = $this->db->query($sql);
    	$result = $query->result();

		$prizeArr = $this->db->get('prize');
		$prizeArr = $prizeArr->result_array();
		$prizeKV = array();
		foreach ($prizeArr as $row){
			$prizeKV[$row['id']] = $row['name'];
		}

		foreach($result as $item){
			$item->prize = $prizeKV[$item->prize];
		}
    	return $result;
    }

	public function getCount($where='1=1')
	{
		$sql = 'SELECT count(1) as c FROM `' .$this->_tablename. '` WHERE '.$where;
    	$query = $this->db->query($sql);
    	$result = $query->result();
    	return $result[0]->c;
	}



    public function getCountByIp($ip){
        $sql = 'SELECT count(1) as c FROM `' .$this->_tablename. "` WHERE create_ip='{$ip}' ";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result[0]->c;
    }

	public function getPirzeCount()
	{
		$sql = 'SELECT count(1) as c FROM `' .$this->_tablename. '` WHERE prize >0 ';
    	$query = $this->db->query($sql);
    	$result = $query->result();
    	return $result[0]->c;
	}

    /**
     * 添加一条记录
     * @param array $data
     */
    public function insert($data)
    {
    	return $this->db->insert($this->_tablename, $data);
    }

    /**
     * 获取某条记录
     * @param int $id
     * @return array
     */
    public function getDish($id)
    {
    	$sql = 'SELECT * FROM `' .$this->_tablename. '` WHERE 1=1 AND `id` = ? LIMIT 1';
        $query = $this->db->query($sql, array(
        	$id
        ));
        $result = $query->result();
        $rs = $result[0];
    	return $rs;
    }

    /**
     * 更新某条记录
     * @param array $data
     * @param int $id
     */
    public function update($data, $id)
    {
    	return $this->db->update($this->_tablename, $data, array('id'=>$id));
    }

    /**
     * 删除某条记录
     * @param int $id
     */
    public function del($id)
    {
    	$id = (int)$id;
    	$where = array('id' => $id);
    	return $this->db->delete($this->_tablename, $where);
    }


    /**
     * 获取某条记录根据手机号
     * @param int $id
     * @return array
     */
    public function getOneByPhone($phone)
    {
    	$sql = 'SELECT * FROM `' .$this->_tablename. '` WHERE 1=1 AND `phone` = ? LIMIT 1';
        $query = $this->db->query($sql, array(
        	$phone
        ));
        $result = $query->result_array();
		$rs = $result?$result[0]:$result;
    	return $rs;
    }

    /**
     * 获取某条记录根据抽奖号
     * @param int $id
     * @return array
     */
    public function getOneByRaffleCode($cookie)
    {
    	$sql = 'SELECT * FROM `' .$this->_tablename. '` WHERE 1=1 AND `raffle_code` = ? LIMIT 1';
        $query = $this->db->query($sql, array(
        	$code
        ));
        $result = $query->result_array();
		$rs = $result?$result[0]:$result;
    	return $rs;
    }
}