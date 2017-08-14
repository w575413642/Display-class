<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once('Login.php');

/**
 *
 * @author RunlongJu <hipop@126.com>
 * @property Journey_model $Journey_model
 */
class Index extends Login {


	public function __construct(){
		parent::__construct();
		$this->load->library('session');
		$this->load->helper('url');
		$this->load->database();
		$this->load->model('Journey_model');
		$this->load->model('Drive_model');
        $this->load->model('Raffle_model');
        $prizelist = $this->Raffle_model->getListAll(10, 0);
        $prizeArr = array();
        foreach($prizelist as $row){
            $prizeArr[$row->id] = $row->name;
        }
        //$prizes = new stdClass();
        //$prizes->list = $prizeArr;
        //var_dump($prizes);
        $this->load->vars('prizeArr',$prizeArr);
		$session = $this->session->userdata('admin_user');
		//print_r($session);
		//die();
		if(empty($session)){
			redirect(site_url('/login/index'), 'refresh');
		}
	}

	public function index()
	{
		$page     = (int)$this->uri->segment(5,1);
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

	    $data = $this->Journey_model->getListFullWithPage($where, $page, $pagesize);
		//echo $data['total'];
		$this->load->view('manage/index', $data);
	}

	/**
	 * 奖项列表
	 */
	public function prize()
	{


		$page = (int)$this->uri->segment(5,1);
		$page = $page?$page:1;
		$pageSize = 100;

		$dateS = $this->input->get('dateS');
		$dateE = $this->input->get('dateE');

		$length = $pageSize;
		$offset = ($page-1) * $length;
		$offset = $offset<0?0:$offset;

		$list = $this->Raffle_model->getListAll($length, $offset);
		$count = $this->Raffle_model->getCount();

		$data = array(
			'list' => $list,
			'count'=> $count,
			'pageSize' => $pageSize,
			'page' => $page
		);
		$this->load->view('manage/prize', $data);
	}

    /**
     * 线索列表
     */
    public function piece()
    {

        $length = 10;
        $offset = 0;

        $list = $this->Raffle_model->getListPiece($length, $offset);
        $count = $this->Raffle_model->getCount('piece');

        $data = array(
            'list' => $list,
            'count'=> $count,
            'pageSize' => 10,
            'page' => 1
        );
        $this->load->view('manage/piece', $data);
    }
    //编辑线索
    public function editpiece()
    {
        $this->load->model('Raffle_model');
        if(empty($_POST)){
            $id = (int)$this->uri->segment(5,1);
            $data = array('data' => $this->Raffle_model->getPiece($id));
            $this->load->view('manage/editpiece', $data);
        }else{
            $id          = (int)$this->input->post('id');
            $key         = $this->input->post('key');
            $name        = $this->input->post('name');
            $probability = (int)$this->input->post('probability');
//            $category    = (int)$this->input->post('category');
//            $remainder   = (int)$this->input->post('remainder');
            $enabled     = (int)$this->input->post('enabled');

            $data = array(
                'key'         => $key,
                'name'        => $name,
                'probability' => $probability,
//                'category'    => $category,
//                'remainder'   => $remainder,
                'enabled'     => $enabled
            );

            $this->Raffle_model->update($id, $data,'piece');
            redirect(site_url('manage/index/piece') );
        }
    }

	public function delprize()
	{
		$id = (int)($this->input->get('id'));
		$this->load->model('Raffle_model');
		$this->Raffle_model->del($id);
		redirect(site_url('manage/index/prize') );
	}

	public function addprize()
	{
		if(empty($_POST)){
			$this->load->view('manage/addprize');
		}else{
			$key         = $this->input->post('key');
			$name        = $this->input->post('name');
			$probability = (int)$this->input->post('probability');
			$category    = (int)$this->input->post('category');
			$remainder   = (int)$this->input->post('remainder');
			$enabled     = (int)$this->input->post('enabled');

			$data = array(
				'key'         => $key,
				'name'        => $name,
				'probability' => $probability,
				'category'    => $category,
				'remainder'   => $remainder,
				'enabled'     => $enabled
			);

			$this->load->model('Raffle_model');
			$this->Raffle_model->add($data);
			redirect(site_url('manage/index/prize') );
		}
	}

	public function editprize()
	{
		$this->load->model('Raffle_model');
		if(empty($_POST)){
			$id = (int)$this->uri->segment(5,1);
			$data = array('data' => $this->Raffle_model->getPrize($id));
			$this->load->view('manage/editprize', $data);
		}else{
			$id          = (int)$this->input->post('id');
			$key         = $this->input->post('key');
			$name        = $this->input->post('name');
			$probability = (int)$this->input->post('probability');
			$category    = (int)$this->input->post('category');
			$remainder   = (int)$this->input->post('remainder');
			$enabled     = (int)$this->input->post('enabled');

			$data = array(
				'key'         => $key,
				'name'        => $name,
				'probability' => $probability,
				'category'    => $category,
				'remainder'   => $remainder,
				'enabled'     => $enabled
			);

			$this->Raffle_model->update($id, $data);
			redirect(site_url('manage/index/prize') );
		}
	}



	/**
	 * 中奖情况列表
	 */
	public function customer()
	{

		$page     = (int)$this->uri->segment(5,1);
		// echo $page;
		//$page = empty($page)?1:$page;
        $pagesize = (int)$this->input->get_post('pagesize');

	    //$list  = $this->Journey_model->getListFullWithPage("prize>0", $page, $pagesize);
	    $count = $this->Journey_model->getAllCustomer('',$page,$pagesize);
        //$prizecount = 0;
//	    $total = $count;
	    $data  = array(
			'list' => $count['data'],
			'count'=> $count['prizecount'],
			'pageSize' => 100,
			'page' => $page,
			'total' =>	$count['total']
		);
	    //print_r($data);
		//die();
        $this->load->view('manage/customer', $data);
	}

	/**
	 * 导出中奖情况列表
	 */
	public function customerexport()
	{
		header('Content-Type:application/vnd.ms-excel');
		$filename = 'customer_export_' . date('y_m_d',time()) . '.xls';
		header('Content-Disposition: attachment; filename="'.$filename.'"');

		//$page  = (int)$this->uri->segment(5,1);
		//$page  = max((int)$page, 1);
		//$pageSize = 100;
		//$offset   = ($page-1)*$pageSize;
		//$list  = $this->Drive_model->getPrizeListAll(PHP_INT_MAX, 0);
	    $count = $this->Journey_model->getAllCustomer();
	    //$total = $this->Drive_model->getPirzeCount();

		$data = array(
			'list' => $count['data'],
			'count'=> $count['prizecount'],
			'pageSize' => 100,
			'page' => 1,
			'total' =>	$count['total']
		);
		$this->load->view('/manage/customerexport', $data);
	}

	/**
	 * 把加失败的重新放入队列
	 */
	public function shear()
	{
		$type = (int)($this->uri->segment(5,1));
		$type = empty($type)?1:$type;
		$date = $this->input->get('date');

		$titleArr = array(
			1 => '分享',
			2 => '访问'
		);
		$tables = array(1=>'share',2=>'visit',3=>'');

		$this->load->model('Customer_model');
		$count = $this->Customer_model->getCountAll();
		//$owner = $this->Customer_model->getCountOwner();

		//$this->db->group_by('cookie,dateflag');
		$this->db->select(' num AS `c`, `dateflag`', FALSE);
		$this->db->where('type', $type );
		if($date !=''){
			$this->db->where('dateflag', $date );
		}
		$rs =  $this->db->get('total_'.$tables[$type].'_v');
		$rs = $rs->result_array();
		$this->load->view('manage/shearlist', array(
			'list'  => $rs,
			'count' => $count,
			'type' => $type,
			'date'=>$date,
			'title' => $titleArr[$type]
		));
	}

	/**
	 * 导出统计
	 */
	public function shearexport()
	{
		$type = (int)($this->input->get('type'));
		$type = empty($type)?1:$type;
		$date = $this->input->get('date');
		$all = (int)($this->input->get('all'));

		$titleArr = array(
			1 => '分享',
			2 => '访问'
		);
		$tables = array(1=>'share',2=>'visit',3=>'');

		$this->load->model('Customer_model');
		$count = $this->Customer_model->getCountAll();
		//$owner = $this->Customer_model->getCountOwner();

		//$this->db->group_by('cookie,dateflag');
		$this->db->select(' num AS `c`, `dateflag`,`name`,`tel`', FALSE);
		$this->db->where('type', $type );
		if($date !=''){
			$this->db->where('dateflag', $date );
			$rs =  $this->db->get('total_'.$tables[$type].'_v');
		}else{
			$rs =  $this->db->get('total_v');
		}
		//前10排名
		$this->db->limit(10);
		$rs = $rs->result_array();

	    $ua = $_SERVER["HTTP_USER_AGENT"];
	    $now = date('Y年m月d日', time());
	    if($all==1) $now = '总排名';
  	    $filename = $titleArr[$type]."记录-{$now}.xls";
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

	    $this->load->view('manage/shearexport', array('list' => $rs,'export'=>1,'title'=>$titleArr[$type],'all'=>$all));
	}



	public function editcustomer()
	{
		$this->load->model('Customer_model');
		$openid = $this->input->post('openid');
		$data = $this->input->post();
		unset($data['openid']);
		$this->Customer_model->updateOne($openid, $data);
	}

	public function getall()
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

	    $data = $this->Journey_model->report($where, $page, $pagesize);
	    //$rs = array();
	    /*$rs['total']    = count($data);
	    $rs['data']     = empty($data)?array(new stdClass()):$data;
	    $rs['page']     = 1;
	    $rs['pagesize'] = PHP_INT_MAX;*/
	    $this->json($data);
	}

    public function clearall()
	{
        die('ok');
        $sql = "truncate TABLE " . $this->db->dbprefix('customer') . ";";
        $this->db->query($sql);
        $sql = "truncate TABLE " . $this->db->dbprefix('journey') . ";";
        $this->db->query($sql);
        $sql = "truncate TABLE " . $this->db->dbprefix('share') . ";";
        $this->db->query($sql);
        die('ok');
	}

    public function alt()
    {
        $sql = "ALTER TABLE `" . $this->db->dbprefix('customer') . "` MODIFY COLUMN `nickname` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `openid`;";

        $this->db->query($sql);

        foreach(array('customer', 'journey', 'share') as $t){
            echo "<h1>$t</h1>";
            $fields = $this->db->field_data($t);

            foreach ($fields as $field)
            {
                echo $field->name , ",\t";
                echo $field->type , ",\t";
                echo $field->max_length , ",\t";
                echo $field->primary_key , ",\t";
                echo "<br>";
            }

            echo "<hr/>";
        }
        die();
    }

    public function test()
    {
        $q = $this->db->get('journey');
        $r = $q->result_array();
        var_dump($r);
        die();

    }

	public function export()
	{
		$page = $this->uri->segment(5,1);
		$pagesize = $this->uri->segment(7,100);
	    $data = $this->Journey_model->report(array(),$page,PHP_INT_MAX);
        //$data = $data['data'];
        //print_r($data);
	    $ua = $_SERVER["HTTP_USER_AGENT"];
	    $now = date('Y年m月d日', time());

  	    $filename = "双星之旅-{$now}.xls";
	    $encoded_filename = urlencode($filename);
	    $encoded_filename = str_replace("+", "%20", $encoded_filename);
	    header('Content-Type:application/vnd.ms-excel;charset=UTF-8');
		//$filename = 'journey_' . date('y_m_d',time()) . '.xls';
		//header('Content-Disposition: attachment; filename="'.$filename.'"');
	    if (preg_match("/MSIE/", $ua)) {
	        header('Content-Disposition: attachment; filename="' . $encoded_filename . '"');
	    } else if (preg_match("/Firefox/", $ua)) {
	        header('Content-Disposition: attachment; filename*="utf8\'\'' . $filename . '"');
	    } else {
	        header('Content-Disposition: attachment; filename="' . $filename . '"');
	    }
	    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

	    $this->load->view('manage/export', array('list' => $data,'export'=>1));
	}

}
