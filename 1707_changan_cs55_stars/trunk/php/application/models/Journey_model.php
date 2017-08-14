<?php

class Jounery{
    public function __construct(){
        $this->tel = '';
        return $this;
    }
}

/**
 * 旅程模型
 *
 */
class Journey_model extends CI_Model
{

	private $table_name = 'journey';
	private $table_share = 'share';

    /**
     * 获取全部数据、带分页
     * @param array $where
     * @param number $page
     * @param number $pagesize
     * @return array('data'=>array, 'total'=>int)
     */
    public function getListFullWithPage($where = array(), $page = 1, $pageSize = 20)
    {
        $rs = array();
        $whereclone = $where;

        if (!empty($where['like'])){
            foreach ($where['like'] as $item){
                $this->db->like($item['field'], $item['value']);
            }
            unset($where['like']);
        }

        // count
        $this->db->where($where);
        $rs['total'] = $this->db->count_all_results($this->table_name);

        // list
        $where = $whereclone;
        if (!empty($where['like'])){
            foreach ($where['like'] as $item){
                $this->db->like($item['field'], $item['value']);
            }
            unset($where['like']);
        }
        $page = max(1, (int)$page);
        $pageSize = empty($pageSize) ? 20 : (int)$pageSize;
        $offset = ($page-1) * $pageSize;
        $this->db->where($where);
        $this->db->order_by("create_time","desc");
        $query = $this->db->get($this->table_name, $pageSize, $offset);
        $data = $query->result_array();
        foreach($data as &$row){
            $this->db->from($this->table_share);
            $this->db->where('journey_id',$row['id']);
            $this->db->where('key_num>0');
            $this->db->group_by('key_num');
            $row['num'] = $this->db->count_all_results();
        }
        $rs['data'] = empty($data)?array((array)(new stdClass())):$data;
        $rs['page'] = $page;
        $rs['pagesize'] = $pageSize;

        return $rs;
    }


    /**
     * 获取by id
     * @param number $id
     * @return Ambigous <>|multitype:
     */
    public function getoneById($id = 0)
    {
        $this->db->where('id', (int)$id);
        $query = $this->db->get($this->table_name);
        $rs = $query->result_array();
        if(!empty($rs[0])){
            return $rs[0];
        }
        return array();
    }

    /**
     * 创建
     * @param unknown $data
     * @throws Exception
     */
    public function create($data = array())
    {
        //num是旅程编号
        $insertData = $data;
        $this->db->set($insertData);
        $this->db->insert($this->table_name);
        $id = $this->db->insert_id();
        //$rs = $this->getoneById($id);
        return $id;
    }

    /**
     * 修改
     * @param number $id
     * @param unknown $data
     * @return Ambigous <boolean, mixed, unknown, string>
     */
    public function update($id = 0, $data = array())
    {
        $this->db->where('id', (int)$id);
        $this->db->set($data);
        $this->db->update($this->table_name);
        return $this->getoneById($id);
    }


    /**
     * 删除
     * @param number $id
     * @return Ambigous <mixed, void, boolean, string, unknown>
     */
    public function delete($id = 0)
    {
        $this->db->where('id', (int)$id);
        return $this->db->delete($this->table_name);
    }

    /**
     * 获取旅行信息
     * @param string $cookie
     * @return Ambigous <>|multitype:
     */
    public function getoneByCookie($cookie)
    {
        $this->db->where('cookie', $cookie);
        $query = $this->db->get($this->table_name);
        $rs = $query->result_array();
        if(!empty($rs[0])){
            return $rs[0];
        }
        return array();
    }

    /**
     * 获取所有我参与过的旅程by cookie
     * @param string $cookie
     * @return multitype:
     */
    public function getMyJoinsByCookie($cookie)
    {
        $this->db->where('cookie', $cookie);
        $query = $this->db->get($this->table_share);
        $rs = $query->result_array();
        return $rs;
    }


    /**
     * 获取旅程的所有参与者by $journeyId
     * @param INT $journeyId
     * @return multitype:
     */
    public function getSharesByJourneyId($journeyId)
    {
        $this->db->where('journey_id', (int)$journeyId);
        $this->db->order_by('id');
        $this->db->group_by('key_num');
        $query = $this->db->get($this->table_share);
        $rs = $query->result_array();
//        foreach ($rs as &$row){
//            $row['nickname'] = base64_decode($row['nickname']);
//        }
        return $rs;
    }

    /**
     * 参与行程
     * @param mixed $data array(journey_id, cookie)
     * @return Ambigous <boolean, mixed, unknown, string>
     */
    public function join($data)
    {
        $insertData = array(
            'journey_id' => $data['journey_id'],
            'cookie'     => $data['cookie'],
        );

        $this->db->set($insertData);
        $rs = $this->db->insert($this->table_share);
        return $rs;
    }

    /**
     * 输出报表数据
     */
    public function report($where = array(), $page = 1, $pageSize = 20)
    {
//        $this->db->select('id,num,create_time,tel,name,city,nickname,headimgurl,province');
        $rs = $this->getListFullWithPage($where, $page, $pageSize);
        return $rs['data'];
    }

    /*获取所有的留资列表*/
    public function getAllCustomer($where=array(),$page=1,$pageSize){
        //echo "dfdf";
        //die();
        //$this->db->where($where);
        //$query = $this->db->get($this->table_name);
        $rs = array();
        //count
        // $this->db->from('journey');
        $this->db->where("tel IS NOT NULL");
        $rs['total'] = $this->db->count_all_results('journey');
        $this->db->where("prize>0");
        $rs['prizecount'] = $this->db->count_all_results($this->table_name);
        //print_r($rs);
        //die();
        $page = max(1, (int)$page);
        $pageSize = empty($pageSize) ? 100 : (int)$pageSize;
        $offset = ($page-1) * $pageSize;

        $this->db->where("prize>0");
        $this->db->order_by("raffle_time",'desc');
        $query = $this->db->get($this->table_name, $pageSize, $offset);
        $data = $query->result_array();
        $rs['data'] = empty($data)?array():$data;
        $rs['page'] = $page;
        $rs['pagesize'] = $pageSize;
        return $rs;
    }
    // 获取中奖用户列表
    public function getPrizeCustomerCount(){
        $rs = array();
        //count
        $this->db->where(' prize IS NOT NULL ', NULL, TRUE);
        //$tableName = 'customer';
        $rs = $this->db->count_all_results($this->table_name);
        return $rs;
    }



}