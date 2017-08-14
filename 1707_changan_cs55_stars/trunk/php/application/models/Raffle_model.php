<?php
/**
 * 抽奖模型
 * @author RunlongJu <hipop@126.com>
 * @property Journey_model $Journey_model
 */
class Raffle_model extends CI_Model {

	private $_tablename = '';

    private $_piecetable = '';

	/**
	 * 客户端cookie名
	 */
	public $cookieName = 'wxopenid';

	function __construct()
	{
		parent::__construct();
		$this->_tablename = $this->db->dbprefix('prize');
        $this->_piecetable = $this->db->dbprefix('piece');
		$this->load->model('Drive_model');
        $this->load->model('Shear_model');
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
	 * @param string $cookie
	 * @throws Exception
	 * @return Ambigous <NULL, number>
	 */
	public function raffle($cookie)
	{
		$rs = array();
		if(!empty($cookie)){
			try{
				$this->db->trans_start();
				//获取奖品列表
				$prizeId = 0;
				// 检查抽奖次数
				$journeyInfo = $this->Journey_model->getoneByCookie($cookie);
				$raffleTime = $journeyInfo['raffle_time'];
				if(!empty($raffleTime)){
					// 没有抽奖机会
				    $rs = array('prizeId'=>-1);
					return $rs;
				}else{
				    // 再检查是否凑足了五个人
				    $this->db->where('journey_id', $journeyInfo['id']);
				    $this->db->group_by('key_num');
				    $this->db->from('share');
				    $count = $this->db->count_all_results();
				    //echo $count;
				    //echo $this->db->last_query();
				    if($count < 4){
				        // 没有抽奖机会,还不满足条件
				        return $rs;
				    }
				}

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
				$data = array(
			        'raffle_time' => time(),
			        'raffle_date' => date('Y-m-d', time()),
			        'raffle_ip' => $_SERVER['REMOTE_ADDR']
				);
				if($rs){
					$data['prize'] = $rs['prizeId'];
				}else{
					$data['prize'] = 0;
				}
				$this->Journey_model->update($journeyInfo['id'], $data);

				$this->db->trans_complete();
			}catch (Exception $e){
				$this->db->trans_rollback();
				throw $e;
			}
		}
		return $data;
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
    //尝试抽取线索
	public function rafflepiece($cookie){
        $rs = array();
        if(!empty($cookie)){
            try{
                $this->db->trans_start();
                //获取奖品列表
                $prizeId = 0;
                // 检查线索搜集情况
                $journeyInfo = $this->Journey_model->getoneByCookie($cookie);
                //查看我已有的线索列表 排除已经中的线索
                $pieces = $this->Shear_model->getListByJourneyId($journeyInfo['id']);
                $piecesIdArr = array();
                foreach($pieces as $row){
                    $piecesIdArr[] = $row['key_num'];
                }
                if(empty($piecesIdArr)) $piecesIdArr = array(0);
                $pieceArr = array();
                $this->db->from($this->_piecetable);
                $this->db->where('enabled',1);
                $this->db->where_not_in("key",$piecesIdArr);
                $query = $this->db->get();
                //echo $this->db->last_query();
                $pieceArr = $query->result_array();
                //echo $this->db->last_query();
                //print_r($pieceArr);
                //die();
                if(is_array($pieceArr)){
                    shuffle($pieceArr);
                    foreach ($pieceArr as $piece){
                        $probability = (int)($piece['probability']);
                        $pieceId = (int)($piece['id']);
                        if($probability > 0){
                            // 决定命运的函数
                            $rand = mt_rand(1, $probability);
                            if($rand == 1){
                                //抽中此线索
                                //$rowQr = $this->db->get_where($this->_piecetable, array('id' => $pieceId));
                                //$row   = $rowQr->result_array();
                                $rs['pieceId'] = $pieceId;
                                break;
                            }
                        }
                        //判定概率结束
                    }
                    //循环结束
                }
                //判定结束
                if($rs['pieceId']) {
                    //把线索情况记录起来
                    $data = array(
                        'cookie' => $cookie,
                        'create_time' => date('Y-m-d H:i:s', time()),
                        'journey_id' => $journeyInfo['id'],
                        'key_num' => $rs['pieceId']
                    );
                    $this->Shear_model->bindpiece($data);
                }
                $this->db->trans_complete();
            }catch (Exception $e){
                $this->db->trans_rollback();
                throw $e;
            }
        }
        return $rs;
    }

    //获取线索信息
    public function getPiece($id)
    {
        $piece = array();
        $query = $this->db->get_where($this->_piecetable, array(
            'id' => (int)$id
        ));
        if($query){
            $rs = $query->result_array();
            if(is_array($rs) && count($rs) > 0){
                $piece = $rs[0];
            }
        }
        return $piece;
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
    //获取线索列表
    public function getListPiece($length, $offset)
    {
        $sql = 'SELECT * FROM `' .$this->_piecetable. '` WHERE 1=1  ORDER BY `key` ASC LIMIT ?, ?';
        $query = $this->db->query($sql, array(
            $offset,
            $length
        ));
        $result = $query->result();
        return $result;
    }

	public function getCount($t)
	{
        if($t=='piece'){
            $sql = 'SELECT count(1) as c FROM `' . $this->_piecetable . '` WHERE 1=1 ';
        }else {
            $sql = 'SELECT count(1) as c FROM `' . $this->_tablename . '` WHERE 1=1 ';
        }
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

	public function update($id, $data,$t)
	{
        if($t=='piece'){
            return $this->db->update($this->_piecetable, $data, array('id' => (int)$id));
        }else {
            return $this->db->update($this->_tablename, $data, array('id' => (int)$id));
        }
	}
}