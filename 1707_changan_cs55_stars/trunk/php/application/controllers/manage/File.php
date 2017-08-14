<?php
defined('BASEPATH') or exit('No direct script access allowed');
require 'Login.php';

/**
 * 文件上传管理
 * @author RunlongJu <hipop@126.com>
 *
 */
class File extends Login
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 列表，带分页功能
     */
	public function upload()
	{
	    $this->upload->do_upload('file');

	    $this->json($rs);
	}

	/**
	 * 获得顶级区域
	 */
	public function toplevel()
	{
	    $where = array('pid' => 0);
	    $rs = $this->Video_model->getListFullWithPage($where, 1, PHP_INT_MAX);
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
	       $rs = $this->Video_model->create($data);
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
        $this->Video_model->delete($id);
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
	        $rs = $this->Video_model->update($id, $data);
	    }catch (Exception $e){
	        $rs = array(
                'code' => 500,
                'msg' => $e->getMessage()
	        );
	    }
	    $this->json($rs);
	}

    /**
     * 获取一个
     */
	public function getone()
	{
	    $id = $this->input->get_post('id');
	    $rs = $this->Video_model->getoneById((int)$id);
	    $this->json($rs);
	}

	/**
	 * 获取已经存在的channel
	 */
	public function existchannel()
	{
	    $rs = $this->Video_model->existchannel();
	    $this->json($rs);
	}
}