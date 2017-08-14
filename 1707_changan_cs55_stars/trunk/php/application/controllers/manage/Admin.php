<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once('Login.php');

/**
 *
 * @author RunlongJu <hipop@126.com>
 * @property Journey_model $Journey_model
 * @property Customer_model $Customer_model
 */
class Admin extends Login {

	private $uploadUrl = '';

	public function __construct(){
		parent::__construct();
		$this->load->library('session');
		$this->load->helper('url');
		$this->load->database();
		$this->load->model('Drive_model');

		$session = $this->session->userdata('admin');
		if(empty($session)){
			//print_r($session);
			redirect(site_url('d=manage&c=login&m=index'), 'refresh');
		}
	}

	public function index()
	{
		$page = $this->uri->segment(4,0);
		//echo $page;
		$page = $page?$page:1;
		$pageSize = 100;

		$dateS = $this->input->get('dateS');
		$dateE = $this->input->get('dateE');

		$length = $pageSize;
		$offset = ($page-1) * $length;
		$offset = $offset<0?0:$offset;

		$list = $this->Drive_model->getList($length, $offset,"drive_date<>''");
		$count = $this->Drive_model->getCount("drive_date<>''");

		$data = array(
			'list' => $list,
			'count'=> $count,
			'pageSize' => $pageSize,
			'page' => $page
		);
		$this->load->view('index', $data);
	}

	public function order(){
		$page = (int)$this->input->get('page');
		$page = $page?$page:1;
		$pageSize = 100;

		$dateS = $this->input->get('dateS');
		$dateE = $this->input->get('dateE');

		$length = $pageSize;
		$offset = ($page-1) * $length;
		$offset = $offset<0?0:$offset;

		$list = $this->Drive_model->getList($length, $offset,"order_date<>''");
		$count = $this->Drive_model->getCount("order_date<>''");

		$data = array(
			'list' => $list,
			'count'=> $count,
			'pageSize' => $pageSize,
			'page' => $page
		);
		$this->load->view('order', $data);
	}

	public function export()
	{
		ini_set("max_execution_time", "3600");
		$t=$this->input->get('t')!=''?$this->input->get('t'):'try';
		$length = 5000;
		$page = $this->input->get('page');
		$page = $page>0?$page:1;
		if($t=='order'){
			$where = "order_date<>''";
		}else{
			$where = "drive_date<>''";
		}
		$list = $this->Drive_model->getList($length, ($page-1)*$length,$where);
		$data = array(
			'list' => $list
		);
		header("Content-type:application/vnd.ms-excel");
		header("Content-Disposition:filename=testdrive_".$t.".xls");
		$this->load->view('export', $data);
	}


	/**
	 * 中奖情况列表
	 */
	public function customer()
	{

		$this->load->model('Journey_model');
		$page  = (int)$this->input->get('page');
		$page  = max((int)$page, 1);
		$pageSize = 100;
		$offset   = ($page-1)*$pageSize;
		$list  = $this->Journey_model->getListFullWithPage(array(), $pageSize, $offset);
		$count = $this->Journey_model->getPrizeCustomerCount();
		$total = $this->Journey_model->getCount();

		$data = array(
			'list' => $list,
			'count'=> $count,
			'pageSize' => 100,
			'page' => $page,
			'total' =>	$total
		);
		$this->load->view('customer', $data);
	}

	/**
	 * 导出中奖情况列表
	 */
	public function customerexport()
	{
		header('Content-Type:application/vnd.ms-excel');
		$filename = 'customer_export_' . date('y_m_d',time()) . '.xls';
		header('Content-Disposition: attachment; filename="'.$filename.'"');

		$this->load->model('Drive_model');
		$page  = (int)$this->input->get('page');
		$page  = max((int)$page, 1);
		$pageSize = 100;
		$offset   = ($page-1)*$pageSize;
		$list  = $this->Drive_model->getPrizeListAll(PHP_INT_MAX, 0);
		$count = $this->Drive_model->getPirzeCount();
		$total = $this->Drive_model->getCount();

		$data = array(
			'list' => $list,
			'count'=> $count,
			'pageSize' => 100,
			'page' => 1,
			'total' =>	$total
		);
		$this->load->view('customerexport', $data);
	}
	public function editcustomer()
	{
		$this->load->model('Customer_model');
		$openid = $this->input->post('openid');
		$data = $this->input->post();
		unset($data['openid']);
		$this->Customer_model->updateOne($openid, $data);
	}

	/**
	 * 奖项列表
	 */
	public function prize()
	{

		$this->load->model('Raffle_model');
		$page = (int)$this->input->get('page');
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
		$this->load->view('prize', $data);
	}

	public function delprize()
	{
		$id = (int)($this->input->get('id'));
		$this->load->model('Raffle_model');
		$this->Raffle_model->del($id);
		redirect(site_url('c=admin&m=prize') );
	}

	public function addprize()
	{
		if(empty($_POST)){
			$this->load->view('addprize');
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
			redirect(site_url('c=admin&m=prize') );
		}
	}

	public function editprize()
	{
		$this->load->model('Raffle_model');
		if(empty($_POST)){
			$id = (int)$this->input->get('id');
			$data = array('data' => $this->Raffle_model->getPrize($id));
			$this->load->view('editprize', $data);
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
			redirect(site_url('c=admin&m=prize') );
		}
	}

	/**
	 * 作品列表
	 */
	public function worklist()
	{
		// 参数项目
		$region   = $this->input->get_post('region');			//"地区"; 可选
		$page     = (int)($this->input->get_post('page'));		//123;页码 可选
		$order    = $this->input->get_post('order');

		$type     = (int)($this->input->get_post('type'));
		$page     = max(1, $page);

		$custPram = $_REQUEST;

		$where = array();

		if(!empty($regin)){
			$where['region'] = $region;
		}
		if($type !== 2){
			$where['type'] = $type;
		}
		// 查询数据库
		$this->load->model('File_model');
		$param = array(
			'page'  => $page,
			'order' => $order,
			'where' => $where
		);
		$list = $this->File_model->backendworklist($param);

		$data = array();
		$data['list']     = $list;
		$data['page']     = $page;
		$data['total']    = $this->File_model->getCountAll();
		$data['count']    = $this->File_model->backendworklistCount($where);
		$data['custPram'] = $custPram;

		$this->load->view('worklist', $data);
	}

	public function delwork()
	{
		$id = (int)($this->input->get_post('id'));
		$this->load->model('File_model');
		$rs = $this->File_model->updateOne($id, array(
			'deleted' => 1
		));

		$data = array(
			'code' => 200,
			'msg'  => 'ok',
			'data' => $rs
		);
		header('Content-type: application/json');
		echo json_encode($data);
		die();
	}

	public function setvote()
	{
		if(empty($_POST)){
			$rs = NULL;
		}else{
			$id = $this->input->get_post('id');
			$vote = $this->input->get_post('vote');

			$data = array();
			$i = 0 ;
			$t = time();
			while ( $i < $vote) {
				$data[] = array(
					'openid_hash' => md5($t . '_' . $i),
					'file_id'     => $id
				);
				$i++;
			}

			$this->db->insert_batch('customer_vote', $data);
			$rs = $this->db->affected_rows();
		}
		$this->load->view('setvote', array('new' => $rs));
	}

	/**
	 * 把加失败的重新放入队列
	 */
	public function worklistretry()
	{
		$this->load->model('File_model');
		$count = 0;
		if($_SERVER['REQUEST_METHOD'] == 'GET'){
			$count = $this->File_model->getErrorCount();
			$this->load->view('worklistretry', array(
				'count' => $count
			));
		}else{
			$ok = $this->File_model->retry();
			$count = $this->File_model->getErrorCount();
			$ok = $this->File_model->retry();
			$this->load->view('worklistretry', array(
				'ok' => $ok,
				'count' => $count
			));
		};
	}

	/**
	 * 把加失败的重新放入队列
	 */
	public function shear()
	{
		$type = (int)($this->input->get('type'));
		$type = empty($type)?1:$type;

		$titleArr = array(
			1 => '分享',
			2 => '投票',
			3 => '抽奖',
		);

		$this->load->model('Customer_model');
		$count = $this->Customer_model->getCountAll();
		$owner = $this->Customer_model->getCountOwner();

		$this->db->group_by('dateflag');
		$this->db->select(' Count(`type`) AS `c`, `dateflag`', FALSE);
		$this->db->where('type', $type );
		$rs =  $this->db->get('total');
		$rs = $rs->result_array();
		$this->load->view('shearlist', array(
			'list'  => $rs,
			'count' => $count,
			'owner' => $owner,
			'title' => $titleArr[$type]
		));
	}


	/**
	 * 获取或刷新youku access token
	 */
	public function token()
	{
		$message = "";

		$code   = $this->input->get('code'); // 来自api的回调参数，优先级最高
		$method = $this->input->get('method');
		$method = empty($method)?'refresh':$method;
		$forced = (bool)$this->input->get('forced');
		if(!empty($code)){
			$method = 'creat';
		}

		$needAccessAPI = FALSE;
		$APIName       = NULL;

		// 查询老的token
		$oldTokenArr = $this->db->get_where('youku', array('key' => 'token'));
		$oldTokenArr = $oldTokenArr->result_array();
		if(count($oldTokenArr) == 0){
			$oldTokenArr = NULL;
			$oldTime     = NULL;
			$oldToken    = NULL;
			$refreshT    = $oldTokenArr->refresh_token;
		}else{
			$oldTokenArr = $oldTokenArr[0];
			$oldTime     = (int)($oldTokenArr['update_time']);
			$oldTokenArr = json_decode($oldTokenArr['value']);
			$oldToken    = $oldTokenArr->access_token;
			$refreshT    = $oldTokenArr->refresh_token;
		}
		//$oldExpires  = (int)($oldTokenArr->expires_in);

		if($method == 'refresh'){
			if($forced == FALSE){
				//判断token是否过期
				if($oldTokenArr && !empty($oldTokenArr->expires_in)){
					$oldExpires  = (int)($oldTokenArr->expires_in);
					if($oldTime + $oldExpires <= time()){
						$message .= '<h1>优酷access_token已经过期！请点击【强制刷新】刷新！</h1>';
					}else{
						$message .= '<h1>优酷access_token还有' . floor(($oldExpires - (time() - $oldTime)) /3600/24)  . '天过期，无需刷新！</h1>';
					}
				}else{
					// 数据库中还没有授权信息，跳转到授权
					redirect(site_url('c=admin&m=token&method=creat'));
				}
			}else{
				// 强制刷新
				$needAccessAPI = TRUE;
				$APIName = 'refreshToken';
			}
		}else if($method == 'creat'){
			// 重新授权
			$needAccessAPI = TRUE;
			$APIName = 'getAccessTokenByCode';
		}

		if($needAccessAPI && $APIName){
			// 重新生成token
			set_include_path(get_include_path() . PATH_SEPARATOR . './' .  APPPATH.'libraries/Youku');
			include('YoukuUploader.class.php');

			$conf          = $this->config->item('youku');
			$client_id     = $conf['client_id'];
			$client_secret = $conf['client_secret'];
			$redirect_uri  = $conf['author_uri'];
			$youkuUploader = new YoukuUploader($client_id, $client_secret);

			if($APIName == 'refreshToken'){
				$youkuUploader->setRefreshToken($refreshT);
				$token = $youkuUploader->refreshToken();
			}

			if($APIName == 'getAccessTokenByCode'){
				if(empty($code)){
					$youkuUploader->getAuthorize($redirect_uri);
					echo '正在掉转至授权 ： ', $redirect_uri;
					die();
				}else{
					try {
						$token = $youkuUploader->$APIName($code, $redirect_uri);

						// file_put_contents($this->tokenFile, json_encode($token));
					}catch (Exception $e){
						$message .= '抱歉，出错了 ： ' . $e->getMessage();
					}
				}
			}
			//持久化
			if($oldTokenArr == NULL){
				$this->db->insert('youku', array(
					'key' => 'token',
					'value'       => json_encode($token),
					'update_time' => time()
				));
			}else{
				$this->db->update('youku', array(
					'value'       => json_encode($token),
					'update_time' => time()
				), array('key' => 'token'));
			}
			//var_dump($APIName);
			//echo 'code is ' , $code;
			//var_dump($token);
			$message .= '刷新access_token完成。新的access_token是：' . $token->access_token . ' 过期时间为：' . (int)($token->expires_in)/3600/24 . '天。5秒后正在跳转...';
			$message .= '<script>setTimeout(function(){window.location.href="'. site_url('c=admin&m=token') . '";},5000);</script>';
		}

		$this->load->view('token', array('message' => $message));

	}
}