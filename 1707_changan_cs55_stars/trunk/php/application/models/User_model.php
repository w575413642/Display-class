<?php
/**
 * 配置模型
 *
 */
class User_model extends CI_Model
{
    private $table_name = 'user';

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
        $rs['data'] = empty($data)?array(new stdClass()):$data;
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
        $regionArr = explode(',', $data['region']);
        $insertData = array(
            'name'         => $data['name'],
            'region_big'   => $regionArr[0],
            'region_small' => empty($regionArr[1])?NULL:$regionArr[1],
            'uname'        => $data['uname'],
            'pword'        => $data['pword'],
            'dealer_code'  => $data['dealer_code'],
            'type'         => $data['type'],
        );

        $this->db->set($insertData);
        $this->db->insert($this->table_name);
        $id = $this->db->insert_id();
        $rs = $this->getoneById($id);
        return $rs;
    }

    /**
     * 修改
     * @param number $id
     * @param unknown $data
     * @return Ambigous <boolean, mixed, unknown, string>
     */
    public function update($id = 0, $data = array())
    {
        $regionArr = explode(',', $data['region']);
        $updateData = array(
            'name'         => $data['name'],
            'region_big'   => $regionArr[0],
            'region_small' => $regionArr[1],
            'uname'        => $data['uname'],
            'pword'        => $data['pword'],
            'dealer_code'  => $data['dealer_code'],
            'type'         => $data['type'],
        );
        $this->db->where('id', (int)$id);
        $this->db->set($updateData);
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

}