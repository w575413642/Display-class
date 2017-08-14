<?php
/** 产品密钥ID，产品标识 */
define("SECRETID", "7fe69148b85f7c46ca4afde2fa2df07d");
/** 产品私有密钥，服务端生成签名信息使用，请严格保管，避免泄露 */
define("SECRETKEY", "a35011b4192a3d933f0536ba07d9ce6b");
/** 业务ID，易盾根据产品业务特点分配 */
define("BUSINESSID", "eb2d9dbbd1dea653e3fb013cfced4183");
/** 易盾反垃圾云服务文本在线检测接口地址 */
define("API_URL", "http://api.aq.163.com/v3/text/check");
/** api version */
define("VERSION", "v3");
/** API timeout*/
define("API_TIMEOUT", 2);
/** php内部使用的字符串编码 */
define("INTERNAL_STRING_CHARSET", "auto");

/**
 * 计算参数签名
 * $params 请求参数
 * $secretKey secretKey
 */
function gen_signature($secretKey, $params){
	ksort($params);
	$buff="";
	foreach($params as $key=>$value){
	     if($value !== null) {
	        $buff .=$key;
		$buff .=$value;
    	     }
	}
	$buff .= $secretKey;
	return md5($buff);
}

/**
 * 将输入数据的编码统一转换成utf8
 * @params 输入的参数
 */
function toUtf8($params){
	$utf8s = array();
    foreach ($params as $key => $value) {
    	$utf8s[$key] = is_string($value) ? mb_convert_encoding($value, "utf8", INTERNAL_STRING_CHARSET) : $value;
    }
    return $utf8s;
}

/**
 * 反垃圾请求接口简单封装
 * $params 请求参数
 */
function check($params){
	$params["secretId"] = SECRETID;
	$params["businessId"] = BUSINESSID;
	$params["version"] = VERSION;
	$params["timestamp"] = sprintf("%d", round(microtime(true)*1000));// time in milliseconds
	$params["nonce"] = sprintf("%d", rand()); // random int
	$params = toUtf8($params);
	$params["signature"] = gen_signature(SECRETKEY, $params);
	// var_dump($params);

	$options = array(
	    'http' => array(
	        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
	        'method'  => 'POST',
	        'timeout' => API_TIMEOUT, // read timeout in seconds
	        'content' => http_build_query($params),
	    ),
	);
	$context  = stream_context_create($options);
	
	$result = file_get_contents(API_URL,false,$context);
	
	/*CURL 版本 */
	/*
	$ch = curl_init ();
		//$callback = $_GET['callback'];
		//print_r($_GET);
		//die();
		//print_r($this->ws.$func."?".(is_object($params_query)?http_build_query($params_query):$params_query));
		//die();
		//$params_query =is_object($params_query)?http_build_query($params_query):$params_query;
		//echo $this->ws.$func."?".$params_query."<br/>";
		//$hostname = gethostbyname("dms.changan.com.cn");
		//echo $hostname."<br/>";
		//print_r(dns_get_record("dms.changan.com.cn"))."<br/>";
		
		//if(defined('CURLOPT_IPRESOLVE') && defined('CURL_IPRESOLVE_V4')){
		//curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
		//}
		$params_query =http_build_query($params_query);
		curl_setopt ( $ch, CURLOPT_HEADER, 0 );
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt($_h, CURLOPT_HTTPPOST, 1);
		curl_setopt ( $ch, CURLOPT_URL, API_URL);
		//curl_setopt($ch, CURLOPT_DNS_USE_GLOBAL_CACHE, false);
		//curl_setopt($ch, CURLOPT_DNS_CACHE_TIMEOUT, -1);
		//curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, 0);
		//curl_setopt ($ch, CURLOPT_TIMEOUT,0);
		curl_setopt ( $ch, CURLOPT_POSTFIELDS, $params_query );
		//die();
		if(curl_exec($ch) === false)
		{
		    echo 'Curl error: ' . curl_error($ch);
		    //exit;
		    //file_put_contents("updatelog.txt",date("Y-m-d H:i:s",time())." ".$func.' Curl error: '.curl_error($ch).'\r\n',FILE_APPEND);
		}
		else
		{
		    $result = curl_exec($ch);
		}
		//print_r($return);
		curl_close ( $ch );
		//return $return;
	//die("dfdfdf");
	*/
	if($result === FALSE){
		return array("code"=>500, "msg"=>"file_get_contents failed.");
	}else{
		return json_decode($result, true);	
	}
}

// 简单测试
function main($str){
	//$str = '你妈';
    //echo "mb_internal_encoding=".mb_internal_encoding()."\n";
	$returndata = array("code"=>500,"msg"=>"error");
	$params = array(
		"dataId"=>md5($str),
		"content"=>$str,
		"dataType"=>"1",
		//"ip"=>"123.115.77.137",
		//"account"=>"php@163.com",
		"deviceType"=>"1",
		//"deviceId"=>"92B1E5AA-4C3D-4565-A8C2-86E297055088",
		//"callback"=>"ebfcad1c-dba1-490c-b4de-e784c2691768",
		"publishTime"=>round(microtime(true)*1000)
	);
	$ret = check($params);
	//var_dump($ret);
	if ($ret["code"] == 200) {
		$returndata['code'] = 200;
		$action = $ret["result"]["action"];
		$taskId = $ret["result"]["taskId"];
		$labelArray = $ret["result"]["labels"];
	       	if ($action == 0) {
				$returndata['msg'] = 'ok';
				//echo "taskId={$taskId}，文本机器检测结果：通过\n";
	      	} else if ($action == 1) {
	      		$returndata['msg'] = '嫌疑，需人工复审';
				//echo "taskId={$taskId}，文本机器检测结果：嫌疑，需人工复审，分类信息如下：".json_encode($labelArray)."\n";
		} else if ($action == 2) {
				$returndata['msg'] = '不通过';
			//echo "taskId={$taskId}，文本机器检测结果：不通过，分类信息如下：".json_encode($labelArray)."\n";
		}
    }else{
		$returndata['code'] = 500;
    	$returndata['msg'] = '异常';// error handler
    }
	echo json_encode($returndata);
	exit;
}

$str = $_POST['msg'];
main($str);
?>
