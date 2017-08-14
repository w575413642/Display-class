<?php
defined('BASEPATH') or exit('No direct script access allowed');
require 'Login.php';

/**
 * 区域管理
 * @author RunlongJu <hipop@126.com>
 * @property Videolog_model $Videolog_model
 *
 */
class Video extends Login
{
    /**
     * Video_model
     * @var Video_model
     */
    public $Video_model;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Video_model');
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

	    $rs = $this->Video_model->getListFullWithPage($where, $page, $pagesize);

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

	/**
	 * 获取观看日志
	 */
	public function getlog()
	{
	    $export = $this->input->get('export');
	    $id = (int) $this->input->get_post('id');

	    $video = $this->Video_model->getoneById((int)$id);

        $this->load->model('Videolog_model');
	    $data = $this->Videolog_model->getListByVideoId($id);
	    $rs = array(
	        'video'    => $video,
	        'data'     => $data,
	    	'page'     => 1,
	        'pagesize' => count($data),
	        'total'    => count($data),
	    );

	    if(!empty($export)){
	        $ua = $_SERVER["HTTP_USER_AGENT"];
	        $now = date('Y年m月d日H时i分s秒', time());

	        $filename = "往期视频观看记录-{$video['title']}-{$now}.xls";
	        $encoded_filename = urlencode($filename);
	        $encoded_filename = str_replace("+", "%20", $encoded_filename);
	        if (preg_match("/MSIE/", $ua)) {
	            header('Content-Disposition: attachment; filename="' . $encoded_filename . '"');
	        } else if (preg_match("/Firefox/", $ua)) {
	            header('Content-Disposition: attachment; filename*="utf8\'\'' . $filename . '"');
	        } else {
	            header('Content-Disposition: attachment; filename="' . $filename . '"');
	        }
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	        $this->load->view('manage/videolog', $rs);
	    }else{
	        $this->json($rs);
	    }
	}
}