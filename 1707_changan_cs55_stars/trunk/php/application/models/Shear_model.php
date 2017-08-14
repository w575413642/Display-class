<?php
// require_once APPPATH . 'libraries/weixin.php';
/**
 * 访客模型
 * @author RunlongJu <hipop@126.com>
 *
 */
class Shear_model extends CI_Model {

    private $_tablename = 'share';

    /**
     * 客户端cookie名
     */
    public $cookieName = 'wxopenid';
    /**
     * 客户端 老车主cookie名
     */


    function __construct()
    {	
        parent::__construct();
        $this->_tablename = $this->db->dbprefix('share');
    }
    //根据旅行获取搜集的碎片
    public function getListByJourneyId($jid){
        $this->db->from($this->_tablename);
        $this->db->where("journey_id",$jid);
        $this->db->where("key_num>0");
        $this->db->group_by('key_num');
        $query = $this->db->get();
        $rs = $query->result_array();
        //echo $this->db->last_query();
        foreach($rs as &$row){
            $row['cookie'] = '';
        }
        return $rs;
    }
	
	public function getoneByOpenid($openid='',$cookie)
    {
		$this->db->from($this->_tablename);
        //$this->db->where('openid',$openid);
		$this->db->where('key_num', 5);
		$this->db->where('cookie',$cookie);
        $query = $this->db->get();
        $rs = $query->result_array();
        if(!empty($rs[0])){
            return $rs[0];
        }
        return array();
    }

    public function bindpiece($data){
        return $this->db->insert($this->_tablename,$data);
    }
	
	//插入分享统计
	public function updatenum($cookie,$type,$jid){
		if($type==2){
            $journeyInfo = $this->Journey_model->getoneByCookie($cookie);
            //查看我已有的线索列表 排除已经中的线索
            $pieces = $this->Shear_model->getListByJourneyId($journeyInfo['id']);
            $piecesIdArr = array();
            foreach($pieces as $row){
                    $piecesIdArr[] = $row['key_num'];
            }
            $noIds = array_diff(array(1,2,3,4,5),$piecesIdArr);
            $keynum = $noIds[array_rand($noIds,1)];
            //print_r($keynum);
            //die();
			//增加分享记录并给予必须碎片
            $data = array(
                'create_time'=>date('Y-m-d H:i:s',time()),
                'cookie'=>$cookie,
                'journey_id'=>$jid,
                'name'=>'fromshare',
                'key_num'=>$keynum
            );
            $this->db->insert($this->_tablename,$data);
            return $keynum;
		}else{//普通分享
			$data = array(
                'create_time'=>date('Y-m-d H:i:s',time()),
				'cookie'=>$cookie,
                'journey_id'=>$jid,
				'key_num'=>0
			);
			$this->db->insert($this->_tablename,$data);
		}
	}
	
}