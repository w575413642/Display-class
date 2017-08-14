<?php
defined('BASEPATH') or exit('No direct script access allowed');
require 'Login.php';

/**
 * 区域管理
 * @author RunlongJu <hipop@126.com>
 *
 */
class Region extends Login
{
    /**
     * Region_model
     * @var Region_model
     */
    public $Region_model;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Region_model');
    }

    /**
     * 列表，带分页功能
     */
	public function index()
	{
	    $page     = (int)$this->input->get_post('page');
	    $pagesize = PHP_INT_MAX;
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

	    $rs = $this->Region_model->getListFullWithPage($where, $page, $pagesize);

	    $this->json($rs);
	}

	/**
	 * 获得顶级区域
	 */
	public function toplevel()
	{
	    $where = array('pid' => 0);
	    $rs = $this->Region_model->getListFullWithPage($where, 1, PHP_INT_MAX);
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
	       $rs = $this->Region_model->create($data);
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
        $this->Region_model->delete($id);
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
	        $rs = $this->Region_model->update($id, $data);
	    }catch (Exception $e){
	        $rs = array(
                'code' => 500,
                'msg' => $e->getMessage()
	        );
	    }
	    $this->json($rs);
	}

}