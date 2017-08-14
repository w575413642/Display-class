<?php
require_once APPPATH . 'libraries/weixin.php';
/**
 * 访客模型
 * @author RunlongJu <hipop@126.com>
 *
 */
class Customer_model extends CI_Model {

	private $_tablename = '';

	/**
	 * 客户端cookie名
	 */
	public $cookieName = 'wxopenid';
	/**
	 * 客户端 老车主cookie名
	 */
	public $cookieOldownerName = 'wxolduid';

	function __construct()
	{
		parent::__construct();
		$this->_tablename = $this->db->dbprefix('customer');
	}
	
	/**
	 * 
	 * 获取openId
	 * 首先尝试从cookie中获取wxopenid并去数据库置换weixin的openid，如果没有就得去微信授权了
	 * @param array $cookie
	 * @param string $code
	 * @param string $redirectUrl
	 * @return array(openId,openIdHash) or NULL
	 */
	public function getOpenId($cookie, $code = NULL, $redirectUrl = NULL)
	{
		$openIdArr = NULL;
		$redirectUrl = urlencode($redirectUrl);
		
		$cookie = empty($cookie)?$_COOKIE:$cookie;
		if($code == NULL && !empty($cookie[$this->cookieName])){
			//尝试去数据库换取openid
			$openIdHash = $cookie[$this->cookieName];
			$query = $this->db->get_where($this->_tablename, array('openid_hash' => $openIdHash));
			$rs = $query->result_array();
			if(is_array($rs) && count($rs) >= 1){
				$openIdArr = array(
					'openId' => $rs[0]['openid'],
					'openIdHash' => $openIdHash
				);
			}
		}
		
		//尝试去微信获取openid
		if(empty($openIdArr)){
			$config = $this->config->config['weixin'];
			$weixin = new Weixin($config);
			$openId = $weixin->getopenid($code, $redirectUrl);
			if(!empty($openId)){
				$time = time();
				$openIdHash = md5($openId . 'yan_2015');
				
				//判断是否已经存在
				$query = $this->db->get_where($this->_tablename, array(
					'openid_hash' => $openIdHash
				));
				$rs = $query->result_array();
				if(empty($rs) || !isset($rs[0]['openid'])){
					try{
						//写入数据库
						$data = array(
							'openid' => $openId,
							'openid_hash' => $openIdHash,
							'creat_time'  => $time
						);
						$this->db->insert($this->_tablename, $data);
						
						/*try{
							$data = array(
								'openid_hash' => $openIdHash,
								'dateflag'    => date('Y-m-d', $time)
							);
							$this->db->insert('customer_remainder', $data);
						}catch (Exception $e){
							
						}*/

					}catch (Exception $e){
						
					}
				}
				$openIdArr = array(
					'openId' => $openId,
					'openIdHash' => $openIdHash
				);
			}
		}
		
		return $openIdArr;
	}
	
	/**
	 * 留资，更新一个信息
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
	
	/**
	 * 获取全部留资
	 * @param unknown $length
	 * @param unknown $offset
	 * @return unknown
	 */
	public function getListAll($length, $offset)
	{
		$sql = "
			SELECT
				C.openid,
				C.openid_hash,
				C.`name`,
				C.tel,
				C.raffle_time,
				C.creat_time,
				IFNULL(P.`name`, 'Not winning') AS prize
			FROM
				{$this->_tablename} AS C
			LEFT OUTER JOIN {$this->db->dbprefix('prize')} AS P ON C.prize = P.id
			WHERE
				C.`name` <> '' AND
				C.tel <> '' AND
				C.`name` IS NOT NULL AND
				C.tel IS NOT NULL
			ORDER BY
				C.prize DESC 
			LIMIT ?, ?
		";
		$query = $this->db->query($sql, array(
			$offset,
			$length
		));
		$result = $query->result();
		return $result;
	}
	
	/**
	 * 
	 * 获取全部留资count
	 * 
	 */
	public function getCount()
	{
		$sql = 'SELECT count(1) as c FROM `' .$this->_tablename. '` WHERE `name` <> \'\' AND `tel` <> \'\' AND `name` IS NOT NULL AND `tel` IS NOT NULL ';
		$query = $this->db->query($sql);
		$result = $query->result();
		return $result[0]->c;
	}
	

	/**
	 *
	 * 获取全部count
	 *
	 */
	public function getCountAll()
	{
		$sql = 'SELECT count(1) as c FROM `' .$this->_tablename. '` WHERE 1=1 ' ;
		$query = $this->db->query($sql);
		$result = $query->result();
		return $result[0]->c;
	}

	public function getCountOwner()
	{
		$sql = 'SELECT count(1) as c FROM `' .$this->_tablename. "` WHERE car_code <> '' " ;
		$query = $this->db->query($sql);
		$result = $query->result();
		return $result[0]->c;
	}
	
	public function del($openIdHash)
	{
		$this->db->where(array(
			'openid_hash' => $openIdHash
		));
		return $this->db->delete($this->_tablename);
	}

	/**
	 * 设置为车主
	 */
	public function markasowner($openIdHash, $carCode, $tel)
	{
		if(empty($carCode)){
			return FALSE;
		}
		$data = array(
			'tel'       => $tel,     //name
			'car_code'  => $carCode, //车架号
			'is_owner'  => 1
		);

		$where = array(
			'openid_hash' => $openIdHash,
			'car_code' => '',
		);

		$this->db->set($data);
		//$this->db->set('remainder', '`remainder`+1',false);
		$this->db->where($where);
		if($this->db->update($this->_tablename)){
			return true;
		};
	}

	/**
	 * 分享
	 * 计数、如果是车主，会增加一次抽奖机会
	 * @retrun object 剩余抽奖次数、是否预约试驾、是否分享
	 */
	public function share($openIdHash)
	{
		// 统计
		$data = array(
			'dateflag' => date('Y-m-d', time())
		);
		$this->db->insert('total', $data);

		// 判断是否预约试驾了，增加车主抽奖机会
		// 只有在预约试驾标志位为1，的情况下才有机会，
		$this->db->set('remainder', 'remainder+1', FALSE);
		$this->db->set('is_testdrive', 2);
		$where = array(
			'openid_hash'   => $openIdHash,
			'is_testdrive ' => 1
		);
		$this->db->where($where);
		$this->db->update($this->_tablename);

		// 判断是否认证成功了，增加车主抽奖机会
		// 只有在认证成功标志位为1，的情况下才有机会，
		$this->db->set('remainder', 'remainder+1', FALSE);
		$this->db->set('is_owner', 2);
		$where = array(
			'openid_hash'   => $openIdHash,
			'is_owner ' => 1
		);
		$this->db->where($where);
		$this->db->update($this->_tablename);

		// 设置is_sheared
		$this->db->set('is_sheared', 1);
		$where = array(
			'openid_hash'   => $openIdHash
		);
		$this->db->where($where);
		$this->db->update($this->_tablename);

		// 返回抽奖次数
		$this->db->select('remainder, is_testdrive, is_owner');
		$where = array(
			'openid_hash'   => $openIdHash,
		);
		$this->db->where($where);
		//$this->db->where('car_code IS NOT NULL',NULL, true);
		$query = $this->db->get($this->_tablename);
		//die($this->db->last_query());

		foreach ($query->result() as $row)
		{
		    return $row;
		}
		return NULL;

	}

	/**
	 * 设置老用户hash
	 * 成功返回是否是车主分享的true
	 */
	public function setOldowner($openIdHash, $uhash)
	{
		$this->db->set('oldowner_hash', $uhash);
		//
		//$this->db->set('remainder', 1);
		$where = array(
			///'remainder'     => '0',
			'openid_hash'   => $openIdHash,
			'oldowner_hash' => NULL,
		);
		$this->db->where($where);
		$rs = $this->db->update($this->_tablename);

		$effect = $this->db->affected_rows();
		return (bool)$effect;
	}

	public function reset($openIdHash)
	{
		$this->db->set('oldowner_hash', 'NULL', false);
		$this->db->set('remainder', 0);
		$this->db->set('is_sheared', 0);
		$this->db->set('tel', '');
		$this->db->set('name', '');
		$this->db->set('car_code', '');
		$this->db->set('is_testdrive', 0);
		$this->db->set('is_owner', 0);
		$where = array(
			'openid_hash'   => $openIdHash
		);
		$this->db->where($where);
		$this->db->update($this->_tablename);
		$effect = $this->db->affected_rows();

		return (bool)$effect;

	}

	/**
	 * 预约试驾，增加一次抽奖机会
	 */
	public function adddrive($openIdHash)
	{
		if(!empty($openIdHash)){
			// 当用户从来没有预约试驾过的前提下，设置为预约试驾标志位为1,使用了此次机会，置位2
			$this->db->set('is_testdrive','1');

			$where = array(
				'is_testdrive' => '0',
				'openid_hash'   => $openIdHash,
			);

			$this->db->where($where);
			$this->db->update($this->_tablename);
		}
	}
}