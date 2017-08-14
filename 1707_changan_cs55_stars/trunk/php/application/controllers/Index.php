<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once('Weixin.php');

/**
 *
 * @author hipop
 * @property Journey_model $Journey_model
 * @property Shear_model $Shear_model
 *
 */
class Index extends Weixin {

	public function __construct(){
        parent::__construct();
        $this->load->model('Journey_model');
		$this->load->model('Shear_model');
	}

	public function index()
	{
	    // 辅助VIEW的变量
	    $viewIsShowLogin = false;
	    $viewIsFull = false;
	    $viewIsMyselfJourney = true;
	    $viewIsNewJourney = false;
	    $joinCustomers = array();
	    $journey = array();
	    $driverInfo = $this->userInfo;
	    $gotopage = 0;

	    // 旅程标志参数
	    $j      = $this->uri->segment(3);
        $uid    = $this->uri->segment(4,0);
	    $cookie = $this->userInfo['cookie'];
        //echo $j;
        //die();
        if($j!=$cookie){
            redirect(site_url("/index/index/{$cookie}/{$uid}"));
            return;
        }

	    // 有无参数，如果没有参数，跳转到自己的cookie
	    if(empty($j)){
	        if(empty($cookie)){
	            die('微信授权失败！');
	        }
	        redirect(site_url("/index/index/{$cookie}/{$uid}"));
	        return;
	    }
	    // 如果有参数，获取行程
	    $journey = $this->Journey_model->getoneByCookie($j);
	    // 判断行程是否存在
	    if(!empty($journey)){
	       // 如果行程存在, 判断行程是否是自己的,and 获取占座情况
	       $joinCustomers = $this->Journey_model->getSharesByJourneyId($journey['id']);
           if($j != $cookie){
                // 如果不是自己的，尝试判断是否满员并参与行程，
               $viewIsMyselfJourney = false;
//               $driverInfo = $this->Customer_model->getOne($j);
//               if(count($joinCustomers) >= 4){
//                    // 已经满员了
//                    $viewIsFull = true;
//                }else{
//                    // 未满员，判断是否参与过
//                    $joined = false;
//                    foreach ($joinCustomers as $jon){
//                        if($jon['cookie'] == $cookie){
//                            $joined = true;
//                        }
//                    }
//                    if($joined == false){
//                        // 为满员，尝试参与
//                        $rs = $this->Journey_model->join(array(
//                            'cookie'     => $cookie,
//                            'journey_id' => $journey['id'],
//                        ));
//                        if($rs){
//                            $joinCustomers[] = $this->userInfo;
//                        }
//                    }
//                }
//                $gotopage = 3;
           }else{
           		$joinCustomers = $this->Journey_model->getSharesByJourneyId($journey['id']);
           		if(count($joinCustomers) >= 5){
               		// 集齐
               		$viewIsFull = true;
           		}
               // print_r($joinCustomers);
               $hasIds = array();
               foreach ($joinCustomers as $key => $value) {
               		$hasIds[] = $value['key_num'];
               }
           }
           // 无论是否是自己的，
	    }else{
          $viewIsMyselfJourney = false;
	       // 如果行程不存在,判断参数是否是自己的cookie
	       if ($j != $cookie){
	           // 如果与cookie不匹配，跳转到自己的cookie
	           redirect(site_url("/index/index/{$cookie}/{$uid}"));
	           return;
	       }else{
	           // 如果匹配，判断是否登录过
	           if(!empty($this->userInfo['phone'])){
	               // 如果登陆过，建立行程 获取占座情况
	               //$journey = $this->Journey_model->getoneById();
	               //$jid=
                   $joinCustomers = $this->Journey_model->getSharesByJourneyId($journey['id']);
                   // print_r($joinCustomers);
                   $hasIds = array();
                   foreach ($joinCustomers as $key => $value) {
                   		$hasIds[] = $value['key_num'];
                   }
                   if(count($joinCustomers) >= 5){
                   		// 集齐
                   		$viewIsFull = true;
               		}
	               // 通知视图，这是新创建的
	               $gotopage = 3;
	           }else{
	               // 如果没有登录过，记录下登录情况，用来显示登录
	               $viewIsShowLogin = true;
	               // $gotopage = (int)($this->input->get('gotopage'));
	           }
	       }
	    }

	    // 处理头像尺寸
	    //foreach ($joinCustomers as &$item){
	       //$item['headimgurl'] = substr($item['headimgurl'], 0, -1) . 96;
	    //}

	    // 渲染视图
	    $data = array(
	        'j'                   => $j,
            'viewIsShowLogin'     => $viewIsShowLogin,
            'viewIsFull'          => $viewIsFull,
            'viewIsMyselfJourney' => $viewIsMyselfJourney,
	        'viewIsNewJourney'    => $viewIsNewJourney,
            'hasIds'       		  => $hasIds,
            'journey'             => $journey,
            'from_uid'            => $uid
	        //'driverInfo'          => $driverInfo,
	        //'gotopage'            => $gotopage,
	    );
        // print_r($data);
//        print_r($this->userInfo);
	    $this->load->view('index', $data);
	}


    /**
     * 开启旅途
     */
    public function createjourney(){
    	$data = $this->input->post();
    	$cookie = $this->userInfo['cookie'];
    	$journey = $this->Journey_model->getoneByCookie($cookie);
    	if(empty($journey)){
    	    $data['cookie'] = $cookie;
    		$rs = $this->Journey_model->create($data);
    	}
        redirect(site_url("j={$cookie}"));
    }

    /**
     * 加入旅途
     */
    public function joinjourney(){
        $data = $this->input->post();
        $journeyId = $data['journey_id'];
        $argJourney = $this->Journey_model->getoneById($journeyId);
        $joineds = $this->Journey_model->getSharesByJourneyId($journeyId);
        $tip = 'ok';
        if(count($joineds) >= 6){
        	// 已经满员了
            $tip = 'fail';
        }else{
            $cookie = $this->userInfo['cookie'];
            $data['cookie'] = $cookie;
            $journey = $this->Journey_model->join($data);
        }
        set_cookie('weixintip',$tip, time() + 3600*24);
        redirect(site_url("j={$argJourney['cookie']}"));
    }

    public function clear()
    {
    	$cookie = $this->userInfo['cookie'];
        $this->db->where(array('cookie' => $cookie));
        $this->db->delete('journey');
        $this->json('ok');

    }

    public function test(){
        var_dump($this->userInfo);
        die('OK');
    }



}
