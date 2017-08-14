<?php
error_reporting(0);
	index();
    function index()
    {
        header("Pragma: no-cache");
        header("Cache-Control: must-revalidate");
        header("Cache-Control: no-store");
        header("Cache-Control: no-cache");
        header("Expires: Sat, 26 Jul 1970 05:00:00 GMT" );
        header("Content-Type:text/javascript");
        require_once "jssdk.php";
        $config['name']   = '长安CS95预热';
		$config['appid']  = 'wx2787b05a5d258312';
		$config['secret'] = '8db1c9831c6c05c53d2bf7a5c2a249eb';
        $jssdk = new JSSDK($config['appid'], $config['secret'], 'cache');
        $signPackage = $jssdk->GetSignPackage();
        $debug = isset($_GET['debug'])?'true':'false';

        echo "<script>wx.config({
				debug: false,
				appId: '{$signPackage["appId"]}',
				timestamp: {$signPackage["timestamp"]},
				nonceStr: '{$signPackage["nonceStr"]}',
				signature: '{$signPackage["signature"]}',
				jsApiList: [
					'onMenuShareTimeline',
					'onMenuShareAppMessage',
					'onMenuShareQQ',
					'onMenuShareWeibo',
					'onMenuShareQZone'
				]
			});</script>";
		
    }


    function clear()
    {
        $this->load->helper('url');
        $this->load->helper('cookie');
        //set_cookie('wxopenid','', time() - 3600 * 365 *24);
        echo '<a href="', site_url('') ,'"><h1>',site_url(''),'</h1></a><br>';
        die('OK');
    }