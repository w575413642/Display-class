<?php
defined('BASEPATH') or exit('No direct script access allowed');
require 'Login.php';

/**
 * 用户管理
 * @author RunlongJu <hipop@126.com>
 *
 */
class User extends Login
{
    /**
     * User_model
     * @var User_model
     */
    public $User_model;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
    }

    /**
     * 列表，带分页功能
     */
	public function index()
	{
	    $page     = (int)$this->input->get_post('page');
	    $pagesize = (int)$this->input->get_post('pagesize');
	    $field    = $this->input->get_post('field');
	    $keyword  = $this->input->get_post('keyword');


	    $where = array();
	    if(!empty($field) && !empty($keyword)){
	        $where['like'] = array(
                array(
                    'field' => $field,
                    'value' => $keyword
                )
	        );
	    }

	    $rs = $this->User_model->getListFullWithPage($where, $page, $pagesize);

	    $this->json($rs);
	}


	/**
	 * 新建
	 */
	public function create()
	{
	    $data = $this->input->post();
	    $rs = array();
	    try{
	       $rs = $this->User_model->create($data);
	    }catch (Exception $e){
            $rs = array(
    	    	'code' => 500,
    	        'msg' => $e->getMessage()
            );
	    }
        $this->json($rs);
	}

	/**
	 * 删除
	 */
	public function delete()
	{
	    $id = (int)($this->input->post('id'));
        $this->User_model->delete($id);
        $this->json(array('id'=>$id));
	}

	/**
	 * 更新
	 */
	public function update()
	{
	    $data = $this->input->post();
	    $id = (int)$data['id'];
	    $rs = array();
	    try{
	        $rs = $this->User_model->update($id, $data);
	    }catch (Exception $e){
	        $rs = array(
                'code' => 500,
                'msg' => $e->getMessage()
	        );
	    }
	    $this->json($rs);
	}

	/**
	 * 树形结构
	 */
	public function tree()
	{
	    $sql = "SELECT
            U.dealer_code as `id`,
            U.`name` AS `name`,
            CONCAT('r' ,U.region_small) AS pid
            FROM
            dcctrainning_user AS U

            UNION

            SELECT
            CONCAT('r' ,R.id) ,
            R.`name`,
            CONCAT('r' ,R.pid)
            FROM
            dcctrainning_region AS R
        ";
	    $q = $this->db->query($sql);
	    $r = $q->result_array();
        $this->json($r);
	}

}