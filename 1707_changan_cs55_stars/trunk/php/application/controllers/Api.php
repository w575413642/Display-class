<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once('Weixin.php');
/**
 *
 * @author RunlongJu <hipop@126.com>
 * @property  Drive_model $Drive_model
 * @property  Shear_model $Shear_model
 * @property  Journey_model_model $Journey_model_model
 * @property  Raffle_model $Raffle_model
 * @property  Customer_model $Customer_model
 *
 */
class Api extends Weixin
{

    private $authurl = 'http://club.changan.com.cn/';

    private $username = 'OfficalWebSite';

    private $userpwd = 'clubWWW2016';

    private $returndata = array(
        "code" => 500,
        "data" => null,
        "msg" => ""
    );

    public function __construct ()
    {
        parent::__construct();
        $this->load->model('Journey_model');
        $this->load->model('Shear_model');
    }

    public function index ()
    {
        header("Pragma: no-cache");
        header("Cache-Control: must-revalidate");
        header("Cache-Control: no-store");
        header("Cache-Control: no-cache");
        header("Expires: Sat, 26 Jul 1970 05:00:00 GMT");
        header("Content-Type:text/javascript");
        require_once APPPATH . "libraries/jssdk.php";
        $config = $this->config->config['weixin'];
        $jssdk = new JSSDK($config['appid'], $config['secret'],
                APPPATH . 'cache');
        $signPackage = $jssdk->GetSignPackage();
        $debug = isset($_GET['debug']) ? 'true' : 'false';

        $this->load->view('jssdk',
            array(
                'signPackage' => $signPackage,
                'debug' => $debug
            ));
    }

    //记录某个人的寻找信息
    public function oncepiecelist(){
        $cookie = $this->userInfo['cookie'];

    }


    /**
     * 留资以便进行联系
     */
    public function login_fans()
    {
        $callback = $this->input->get('callback');
        // $username   = $this->uri->segment(3);
        // $mobile = $this->uri->segment(4);
        // $pro = $this->uri->segment(5);
        // $city = $this->uri->segment(6);
        // $town = $this->uri->segment(7);
        // $dealer = $this->uri->segment(8);
        // $uid = $this->uri->segment(9);

        // $data = array(
        //     'username' => urldecode($username),
        //     'phone'   => $mobile,
        //     'from_uid'=>$uid,
        //     'create_time'=>time()
        // );

        // $this->load->model('Customer_model');

        $return = array();

        // // 判断是否绑定过手机号
        $cookie = $this->userInfo['cookie'];
        $journeyInfo = $this->Journey_model->getoneByCookie($cookie);
        // //没有绑定过
        if(empty($journeyInfo)){
            $jid = $this->Journey_model->create(array(
                'cookie' => $cookie,
                // 'tel'=>$mobile,
                // 'name'=>urldecode($username),
                // 'province'=>urldecode($pro),
                // 'city'=>urldecode($city),
                // 'town'=>urldecode($town),
                // 'dealer'=>urldecode($dealer),
                'create_time'=>date('Y-m-d H:i:s',time())
            ));
        //     $this->Customer_model->updateUserInfo($this->userInfo['cookie'], $data);
        //     //$return['goto'] = site_url("j={$this->userInfo['cookie']}");
        //     $this->returndata['code'] = 200;
        //     $this->returndata['data'] = $return;
        //     $this->returndata['msg'] = 'ok';
        }
        // }else{//绑定过了
        //     $this->returndata['code'] = 403;
        //     $this->returndata['data'] = $return;
        //     $this->returndata['msg'] = '手机号已经使用，请更换';
        // }
         $this->returndata['code'] = 200;
        $this->returndata['data'] = $return;
        $this->returndata['msg'] = 'ok';
        if ($callback != '') {
            header('Content-type: text/javascript');
            echo $callback . "(" . json_encode($this->returndata) . ")";
        } else {
            header('Content-type: application/json');
            echo json_encode($this->returndata);
        }
        die();
    }


    private function getIp ()
    {
        $ip = false;
        if (!empty($_SERVER["HTTP_CLIENT_IP"])) {
            $ip = $_SERVER["HTTP_CLIENT_IP"];
        }
        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ips = explode(", ", $_SERVER['HTTP_X_FORWARDED_FOR']);
            if ($ip) {
                array_unshift($ips, $ip);
                $ip = FALSE;
            }
            for ($i = 0; $i < count($ips); $i++) {
                if (!preg_match("/^(10|172.16|192.168)/i", $ips[$i])) {
                    $ip = $ips[$i];
                    break;
                }
            }
        }
        return ($ip ? $ip : $_SERVER['REMOTE_ADDR']);
    }

    /**
     * 我搜集的线索列表
     */
    public function mypieceslist(){
        $cookie = $this->userInfo['cookie'];
        $journeyInfo = $this->Journey_model->getoneByCookie($cookie);
        $mylist = $this->Shear_model->getListByJourneyId($journeyInfo['id']);
        header('Content-type: application/json');
        $data = array(
            'code' => 200,
            'msg' => 'ok',
            'data' => $mylist
        );
        echo json_encode($data);
        die();
    }


    /**
     * 分享统计
     * 分享会增加碎片
     */
    public function share ()
    {
        // 增加抽奖次
        // $remainder = $this->Customer_model->share($phone);
        // $data = $this->Customer_model->share($phone);
        $cookie = $this->userInfo['cookie'];//$this->input->get_post('cookie');
        $journey = $this->Journey_model->getoneByCookie($cookie);
        //检查是否集齐
        $pieces = $this->Shear_model->getListByJourneyId($journey['id']);
        //检查是否有了分享获得的碎片
        foreach($pieces as $piece){
            if($piece['name']=='fromshare'){
                $nesssray = true;
                break;
            }
        }
        if(count($pieces)<5 && !$nesssray ){ // 分享会获得碎片
            $keynum = $this->Shear_model->updatenum($cookie, 2,$journey['id']);
            $hasNum5 = $keynum;
        }else{
            $this->Shear_model->updatenum($cookie, 1,$journey['id']);
            $hasNum5 = 0;
        }
        header('Content-type: application/json');
        $data = array(
            'code' => 200,
            'msg' => 'ok',
            'data' => $hasNum5
        );
        echo json_encode($data);
        die();
    }

    /**
     * 搜集线索 按照概率出现 1 2 3 4
     * 5 为需要分享才可获得的
     */
    public function getpiece(){
        $callback = $this->input->get_post('callback');
        if (true) {
            $prize = array();
            $this->load->model('Raffle_model');
            $raffleArr = $this->Raffle_model->rafflepiece($this->userInfo['cookie']);
            if ($raffleArr) {
                $pieceId = $raffleArr['pieceId'];
                $pieceInfo = $this->Raffle_model->getPiece($pieceId);
                if (!empty($pieceInfo)) {
                    $piece = array(
                        'id'   => $pieceInfo['id'],
                        'key'  => $pieceInfo['key'],
                        'name' => $pieceInfo['name'],
                    );

                    if (!empty($raffleArr['customer_prize_id'])) {
                        $piece['customer_prize_id'] = $raffleArr['customer_prize_id'];
                    }
                }

//                if($pieceId == -1){
//                    $piece = array(
//                        'id'   => $pieceId,
//                        'key'  => 'hasdone',
//                        'name' => '已经抽过了',
//                    );
//                }
            } else {
                $piece = array(
                    'id' => 0,
                    'key' => '',
                    'name' => 'piece not found'
                );
            }

            // 重新获取剩余抽奖次数
            /* $custRemainder = $this->Drive_model->getOneByRaffleCode(
                $raffle_code);
            $custRemainder = (int)$custRemainder['remainder'];
            $prize['remainder'] = $custRemainder; */
        } else {
            // 关闭抽奖
            $piece = array(
                'id' => 0,
                'key' => '',
                'name' => 'not found'
            );
        }
        $data = array(
            'code' => 200,
            'msg' => 'ok',
            'data' => $piece
        );

        if ($callback != '') {
            header('Content-type: text/javascript');
            echo $callback . "(" . json_encode($data) . ")";
        } else {
            header('Content-type: application/json');
            //echo $this->db->last_query();
            echo json_encode($data);
        }
        die();
    }

    //标记合成线索
    public function launched(){
        $cookie = $this->userInfo['cookie'];//$this->input->get_post('cookie');
        $journey = $this->Journey_model->getoneByCookie($cookie);
        $this->Journey_model->update($journey['id'],array('launched'=>1));
        $data = array(
            'code' => 200,
            'msg' => 'ok',
            'data' => array()
        );

        if ($callback != '') {
            header('Content-type: text/javascript');
            echo $callback . "(" . json_encode($data) . ")";
        } else {
            header('Content-type: application/json');
            //echo $this->db->last_query();
            echo json_encode($data);
        }
        die();
    }

    //完善信息
    public function updateinfo(){
        $callback = $this->input->get('callback');
        $username   = $this->uri->segment(3);
        $mobile = $this->uri->segment(4);
        $pro = $this->uri->segment(5);
        $city = $this->uri->segment(6);
        $town = $this->uri->segment(7);
        $dealer = $this->uri->segment(8);

        $cookie = $this->userInfo['cookie'];//$this->input->get_post('cookie');
        $journey = $this->Journey_model->getoneByCookie($cookie);
        $result = $this->Journey_model->update($journey['id'],array(
                'tel'=>$mobile,
                'name'=>urldecode($username),
                'province'=>urldecode($pro),
                'city'=>urldecode($city),
                'town'=>urldecode($town),
                'dealer'=>urldecode($dealer)
            ));
        
        $data = array(
            'code' => 200,
            'msg' => $result?'ok':'unsuccess',
            'data' => array()
        );

        if ($callback != '') {
            header('Content-type: text/javascript');
            echo $callback . "(" . json_encode($data) . ")";
        } else {
            header('Content-type: application/json');
            //echo $this->db->last_query();
            echo json_encode($data);
        }
        die();
    }

    /**
     * 尝试抽取奖品
     * @todo 不再使用抽奖码，
     * 直接判断是否集齐五个车位，如果集齐并且也是司机才可以抽奖，
     * 如果没有集齐，禁止抽奖
     */
    public function doraffle ()
    {
        $callback = $this->input->get_post('callback');
        $cookie = $this->userInfo['cookie'];
        $journey = $this->Journey_model->getoneByCookie($cookie);
        if($journey['tel']==''){
            $prize = array(
                'id' => -2,
                'key' => 'not valid winning',
                'name' => '没有完善信息无法抽奖!'
            );
        }else{
            $prize = array();
            $this->load->model('Raffle_model');
            $raffleArr = $this->Raffle_model->raffle($this->userInfo['cookie']);
            //print_r($raffleArr);
            if ($raffleArr) {
                $prizeId = $raffleArr['prize'];
                $prizeInfo = $this->Raffle_model->getPrize($prizeId);
                if (!empty($prizeInfo)) {
                    $prize = array(
                        'id'   => $prizeInfo['id'],
                        'key'  => $prizeInfo['key'],
                        'name' => $prizeInfo['name'],
                    );

                    if (!empty($raffleArr['customer_prize_id'])) {
                        $prize['customer_prize_id'] = $raffleArr['customer_prize_id'];
                    }
                }else{
                    $prize = array(
                        'id' => 0,
                        'key' => '',
                        'name' => 'not winning'
                    );
                }

                if($prizeId == -1){
                    $prize = array(
                        'id'   => $prizeId,
                        'key'  => 'hasdone',
                        'name' => '已经抽过了',
                    );
                }
            } else {
                $prize = array(
                    'id' => 0,
                    'key' => 'not valid winning',
                    'name' => '没有集齐线索，无法抽奖!'
                );
            }

            // 重新获取剩余抽奖次数
            /* $custRemainder = $this->Drive_model->getOneByRaffleCode(
                $raffle_code);
            $custRemainder = (int)$custRemainder['remainder'];
            $prize['remainder'] = $custRemainder; */
        }
        $data = array(
            'code' => 200,
            'msg' => 'ok',
            'data' => $prize
        );

        try {
            // 统计抽奖次数
            // @todo 这个插入不能成功，但占了一个自增ID
            $this->db->set(array(
                'dateflag' => date('Y-m-d', time()),
                'type' => 3,
                'cookie' => $this->userInfo['cookie'],
            ));
            $this->db->insert('total');
        } catch (Exception $e) {
        }

        if ($callback != '') {
            header('Content-type: text/javascript');
            echo $callback . "(" . json_encode($data) . ")";
        } else {
            header('Content-type: application/json');
            // echo $this->db->last_query();
            echo json_encode($data);
        }
        die();
    }

    public function clear ()
    {
        $this->load->helper('url');
        $this->load->helper('cookie');
        // set_cookie('wxopenid','', time() - 3600 * 365 *24);
        echo '<a href="', site_url(''), '"><h1>', site_url(''), '</h1></a><br>';
        die('OK');
    }
}