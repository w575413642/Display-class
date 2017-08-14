<?php
defined('BASEPATH') or exit('No direct script access allowed');
require 'Login.php';

/**
 * 区域管理
 * @author RunlongJu <hipop@126.com>
 * @property Journey_model $Journey_model
 *
 */
class Live extends Login
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Live_model');
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

	    $rs = $this->Live_model->getListFullWithPage($where, $page, $pagesize);

	    $this->json($rs);
	}

	/**
	 * 获得顶级区域
	 */
	public function toplevel()
	{
	    $where = array('pid' => 0);
	    $rs = $this->Live_model->getListFullWithPage($where, 1, PHP_INT_MAX);
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
	       $rs = $this->Live_model->create($data);
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
        $this->Live_model->delete($id);
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
	        $rs = $this->Live_model->update($id, $data);
	    }catch (Exception $e){
	        $rs = array(
                'code' => 500,
                'msg' => $e->getMessage()
	        );
	    }
	    $this->json($rs);
	}

	public function getone()
	{
	    $id = $this->input->get_post('id');
	    $rs = $this->Live_model->getoneById((int)$id);
	    $this->json($rs);
	}

	/**
	 * 观看报告
	 */
	public function report()
	{
	    $id   = $this->input->get_post('id');
	    $live = $this->Live_model->getoneById((int)$id);
	    $startTime = $live['start_time'];
	    $endTime = $live['end_time'];

	    // 计算有多少个分钟
	    $mins = ($endTime - $startTime) % 60;

	    // 计算有多少个经销商参与活动
	    $this->load->model('Channel_Model');
	    $channelId = $live['channel_id'];
	    $channel = $this->Channel_Model->getoneById($channelId);
	    $dealers = $channel['region'];
	    $dealers = explode(',', $dealers);

	    // 经销商kv
	    $this->load->model('User_model');
	    $dealerKv = $this->User_model->getKVcodename();
        $dealerData = array();
	    foreach ($dealers as $d){
	        $dealerData[$d] = $dealerKv[$d];
	    }

	    // 心跳统计
	    $this->db->where('live_id' , $id);
	    $this->db->select('dealer_id, create_time');
        $r = $this->db->get('hearbeat');
        $q = $r->result_array();

        $rs = array(
            'min'    => $mins,
            'dealer' => $dealerData,
            'report' => $q,
        );

        $this->load->view('manage/report');
	}

	/**
	 * 获取观看日志
	 */
	public function getlog()
	{
	    // 导出标记
	    $export = $this->input->get('export');
	    // 直播日志
	    $id = (int) $this->input->get_post('id');
        // 直播数据
	    $live = $this->Live_model->getoneById((int)$id);
        // 频道
	    $channelId = (int)$live['channel_id'];
	    $this->load->model('Channel_model');
	    $channel = $this->Channel_model->getoneById($channelId);
	    $live['title'] = $channel['title'] . "-第{$live['number']}场";

	    $this->load->model('Hearbeat_model');
	    $data = $this->Hearbeat_model->getListByLiveId($id);
	    $rs = array(
            'live'     => $live,
            'data'     => $data,
            'page'     => 1,
            'pagesize' => count($data),
            'total'    => count($data),
	    );

	    if(!empty($export)){
	        $ua = $_SERVER["HTTP_USER_AGENT"];
	        $now = date('Y年m月d日H时i分s秒', time());

	        $filename = "直播视频观看记录-{$live['title']}-{$now}.xls";
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
	        $this->load->view('manage/livelog', $rs);
	    }else{
	        $this->json($rs);
	    }
	}
}