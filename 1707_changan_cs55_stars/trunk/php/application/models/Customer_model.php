<?php
// require_once APPPATH . 'libraries/weixin.php';
/**
 * 访客模型
 * @author RunlongJu <hipop@126.com>
 *
 */
class Customer_model extends CI_Model {

    private $_tablename = 'customer';

    /**
     * 客户端cookie名
     */
    public $cookieName = 'wxopenid';
    /**
     * 客户端 老车主cookie名
     */


    function __construct()
    {
        parent::__construct();
        $this->_tablename = $this->db->dbprefix('customer');
    }

    /**
     *
     * 获取openId
     * 首先尝试从cookie中获取wxopenid并去数据库置换weixin的openid，如果没有就得去微信授权了
     * @param array $cookie
     * @param string $code
     * @param string $redirectUrl
     * @return array(openId,openIdHash) or NULL
     */


    /**
     * 留资，更新一个信息
     * @param string $openIdHash
     * @param array $data
     * @return int
     */


    public function getOne($openIdHash, $columns = NULL)
    {
        if($columns){
            $this->db->select($columns);
        }

        $query = $this->db->get_where($this->_tablename, array(
            'cookie' => $openIdHash
        ));
        $rs = $query->result_array();
        if($rs){
            return $rs[0];
        }
        return $rs;
    }


	/**
	 *
	 * 获取全部留资count
	 *
	 */
	public function getCount()
	{
		$sql = 'SELECT count(1) as c FROM `' .$this->_tablename. '` WHERE `name` <> \'\' AND `tel` <> \'\' AND `name` IS NOT NULL AND `tel` IS NOT NULL ';
		$query = $this->db->query($sql);
		$result = $query->result();
		return $result[0]->c;
	}

	/**
	 *
	 * 获取全部count
	 *
	 */
	public function getCountAll()
	{
		$sql = 'SELECT count(1) as c FROM `' .$this->_tablename. '` WHERE 1=1 ' ;
		$query = $this->db->query($sql);
		$result = $query->result();
		return $result[0]->c;
	}

	public function getCountOwner()
	{
		$sql = 'SELECT count(1) as c FROM `' .$this->_tablename. "` WHERE car_code <> '' " ;
		$query = $this->db->query($sql);
		$result = $query->result();
		return $result[0]->c;
	}

    /**
     *
     * 获取用户的微信账户信息
     * @param string $cookie 服务器在客户端的标记
     * @param string $code 微信接口返回的授权码
     * @param string $redirectUrl 微信接口回调地址
     * @return Ambigous <Ambigous, NULL, multitype:unknown >
     */
    public function getWxUserinfo($cookie = NULL, $code = NULL, $redirectUrl = NULL,$uid)
    {
        $userinfo = array();

        // 微信配置
        $config = $this->config->config['weixin'];
        $appid  = $config['appid'];
        $secret = $config['secret'];

        // 如果没有微信接口授权码
        if(empty($_GET['code'])){
            // 首选判断是否存在cookie信息
            //echo $cookie;
            //die();
            $userinfo = $this->getWxUserinfoByCookie($cookie);
            if(empty($userinfo)){
                // 如果用户信息不存在于cookie中，那么就要去服务器端获取了，则发起snsapi_useinfo方式授权以获取code
//                $redirectUrl = urlencode($redirectUrl);
                $redirect_url = site_url("/index/index/0/{$uid}");
                //header("Location:http://cms.changan.com.cn/ccsupport/html/oauth.html?url=".$redirect_url."&accountid=86");
                header("Location:https://open.weixin.qq.com/connect/oauth2/authorize?appid={$appid}&redirect_uri={$redirect_url}&response_type=code&scope=snsapi_base#wechat_redirect");
                exit();
            }
        }else{
            // 如果有微信接口授权码，说明是微信接口的回调二次访问，则用code换取令牌
            $code = $_GET['code'];
            $tokenJson = file_get_contents('https://api.weixin.qq.com/sns/oauth2/access_token?appid='.$appid.'&secret='.$secret.'&code='.$code.'&grant_type=authorization_code');
            $tokenJson = json_decode($tokenJson,TRUE);
            $userinfo = array();
            //var_dump($tokenJson);
            //die();
            if(!isset($tokenJson['errcode'])){
                $cookie = md5($tokenJson['openid']);
                $openid = $tokenJson['openid'];
                $userinfo['cookie'] = $cookie;

                //　写入cookie
                $this->load->helper('cookie');
                set_cookie($this->cookieName, $cookie, strtotime('2030-01-01 00:00:00'));

                // 判断是否是否存在了这个cookie
                $exists = $this->getWxUserinfoByCookie($cookie);

                // 如果数据库中没有响应的数据
                if(empty($exists)){
                    // 下面将信息写入数据库
                    $this->db->set(array(
                        'openid'     => $openid,
                        'nickname'   => '',
                        'headimgurl' => '',
                        'country'    => '',
                        'province'   => '',
                        'city'       => '',
                        'sex'        => '',
                        'cookie'     => $cookie,
                        'from_uid'   => $uid,
                        'create_time'=>date('Y-m-d H:i:s',time())
                    ));

                    $this->db->insert($this->_tablename);
                }
            }
        }

        return $userinfo;
    }

    /**
     * 根据cookie获取用户信息
     * @param string $cookie
     * @return Ambigous <NULL, multitype:unknown >
     */
    public function getWxUserinfoByCookie($cookie)
    {
        $userinfo = null;

        // 获取cookie
        $openIdHash = empty($cookie)?$_COOKIE[$this->cookieName]:$cookie;
        $query = $this->db->get_where($this->_tablename, array('cookie' => $openIdHash));
        $rs = $query->result_array();
        //print_r($rs);
        //die();
        if(is_array($rs) && count($rs) >= 1){
            $rs = $rs[0];
            // 如果存在昵称信息
            $userinfo = $rs;
        }

        return $userinfo;
    }

    /**
     * 更新用户的留资料数据
     * @param string $cookie
     * @param mixed $data
     */
    public function updateUserInfo($cookie, $data)
    {
        $upData = $data;

        $this->db->where('cookie', $cookie);
        $this->db->set($upData);
        return $this->db->update($this->_tablename);
    }

    /**
     * 检查手机号码存在的数量
     * @param string $mob
     * @return number
     */
    public function checkmobile($mob)
    {
        $this->db->where('phone', $mob);
        $this->db->from($this->_tablename);
        $exist = $this->db->count_all_results();
        return $exist;
    }
}