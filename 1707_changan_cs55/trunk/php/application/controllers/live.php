<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 直播接口
 */
class Live extends CI_Controller {

	public function __construct(){
		parent::__construct();
	}


	public function index()
    {
        header("Pragma: no-cache");
        header("Cache-Control: must-revalidate");
        header("Cache-Control: no-store");
        header("Cache-Control: no-cache");
        header("Expires: Sat, 26 Jul 1970 05:00:00 GMT" );
        header("Content-type: application/json");

        $roomId = $this->input->get_post('roomid');
        $time = $this->input->get_post('time');
        $this->load->driver('cache', array('adapter' => 'file'));
        $cacheKey = "LIVE_{$roomId}";
        $foo = $this->cache->get($cacheKey);
        if ( !$foo )
        {
            $foo = $this->getNewStreamInfo($roomId);

            // Save into the cache for 10 s
            $this->cache->save($cacheKey, $foo, 10);
        }
        echo $foo;
        die();
    }

	private function getNewStreamInfo($roomId){
        //$roomId = 431972;
        $url = 'http://coapi.douyucdn.cn/lapi/live/thirdPart/getPlay/' . $roomId;   //curl请求url
        $uri = 'lapi/live/thirdPart/getPlay/' . $roomId;    //加密部分URI(其他接口URI可能不同，请参照接口文档，接口加密方式通用)
        $aid = 'changan';      //合作方申请aid
        $time = time() + 640;     //请求服务器当前时间戳
        $key = '93H598sZQNcayTrp';    //申请秘钥
        $query['aid'] = $aid;
        $query['time'] = $time;
        ksort($query);      //参数键a-z排序
        $keyStr = $uri . '?' . http_build_query($query) . $key;     //加密字符串
        $auth = md5($keyStr);
        //header头信息
        $header = array("aid:$aid", "time:$time", "auth:$auth");

        //发送curl请求
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        if (strpos($url, 'https') === 0) {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        }
        //发送header参数
        if ($header and is_array($header)) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
            curl_setopt($ch, CURLOPT_HEADER, 0);
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 3);
        curl_setopt($ch, CURLOPT_ENCODING, 'gzip,deflate');
        $response = curl_exec($ch);
        return $response;
    }
}