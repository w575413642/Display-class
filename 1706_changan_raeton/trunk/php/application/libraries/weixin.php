<?php
/**
 * 微信相关类
 * @author RunlongJu <hipop@126.com>
 *
 */
class Weixin {
	
	/**
	 * 此微信的appid
	 * @var string
	 */
	private $appid;
	
	/**
	 * 此微信的secret
	 * @var string
	 */
	private $secret;
	
	public function __construct($config)
	{
		$this->appid  = $config['appid'];
		$this->secret = $config['secret'];
	}
	
	/**
	 * 获取openid
	 * @param string $appid 微信公众平台appid
	 * @param string $secret 微信公众号的appsecret
	 * @param string $code 授权之后的code
	 * @param string $redirectUrl 获取授权后的跳转页面
	 * @return string openid 返回openid
	 */
	public function getopenid($code = NULL, $redirectUrl = NULL )
	{
		$appid  = $this->appid;
		$secret = $this->secret;

		if(empty($code)){
			/*如果未曾授权，则发起snsapi_base方式授权以获取code*/
			$redirect_url = $redirectUrl;//urlencode("http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']);
			//echo $redirect_url;
			header("Location:https://open.weixin.qq.com/connect/oauth2/authorize?appid=".$appid."&redirect_uri=".$redirect_url."&response_type=code&scope=snsapi_base&state=123#wechat_redirect");
			exit();
		}else{
			/*如果以获取授权并得到code，则用code换取令牌*/
			$jsonStr = file_get_contents('https://api.weixin.qq.com/sns/oauth2/access_token?appid='.$appid.'&secret='.$secret.'&code='.$code.'&grant_type=authorization_code');
			$jsonObj = json_decode($jsonStr);
			//print_r($jsonObj);
			if(empty($jsonObj->errcode)){
				return $jsonObj->openid;
			}
			return NULL;
		}
	}
	
	
}