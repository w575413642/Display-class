<?php
/**
 * 报名模型
 *
 */
class Live_model extends CI_Model
{
    private $table_name = 'streetcustomer';

    public function __construct(){
        parent::__construct();
    }

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
        $query = $this->db->get($this->table_name, $pageSize, $offset);
        $data = $query->result_array();
        foreach ($data as &$row) {
            $row['createtime'] = date('Y-m-d H:i:s', $row['createtime']);
        }
        $rs['data'] = empty($data)?array(new stdClass()):$data;
        $rs['page'] = $page;
        $rs['pagesize'] = $pageSize;

        return $rs;
    }


    /**
     * 获取by phone
     * @param string $phone
     * @return Ambigous <>|multitype:
     */
    public function getoneByPhone($phone)
    {
        $this->db->where('phone', $phone);
        $query = $this->db->get($this->table_name);
        $rs = $query->result_array();
        if(!empty($rs[0])){
            $rs = $rs[0];
            return $rs;
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
        //$regionArr = explode(',', $data['region']);
        $insertData = $data;
        $insertData['createtime'] = time();
        //print_r($insertData);
        //$this->db->set($insertData);
        $this->db->insert($this->table_name,$insertData);
        $id = $this->db->insert_id();
        //$rs = $this->getoneById($id);
        return $id;
    }
}