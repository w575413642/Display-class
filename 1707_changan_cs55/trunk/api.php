<?php
$base_url = "http://www.changan.com.cn/";
$brand_id = 1;	
$carseries = "S201";
$aid=342;

$action=$_GET['action'];
if($action == "province"){
	$url = $base_url.'/api.php?op=dealer&act=get_province_list&brand='.$brand_id;
	$con = get_content($url);
	echo $con;
	exit;
} else if($action == "city"){
	$pid = intval($_GET['pid']);
	$url = $base_url.'/api.php?op=dealer&act=get_city_list&province='.$pid."&brand=".$brand_id."&carseries=".$carseries;
	$con = get_content($url);
	echo $con;
	exit;
}else if($action=='dealer'){
	$cid = intval($_GET['cid']);
	$series = $_GET['series'];
	$url=$base_url.'/api.php?op=dealer&act=get_dealer_list&city='.$cid.'&dist=-1&brand='.$brand_id."&carseries=".$series;
	$con = get_content($url);
	echo $con;
	exit;
} else if($action=='forum'){
	$url = 'http://club.changan.com.cn/OfficalWebSite/OfficalWebSite_reply.php';
	$data='{"tid": "36960"}';
	$con = post_content($url, $data);
	echo $con;
	exit;	
} else if($action=='carlist'){ 
	$url=$base_url.'/api.php?op=carseries&act=get_carseries_list&brand='.$brand_id."&carseries=".$carseries;
	$con = get_content($url);
	echo $con;
	exit;

} else if($action=='submit'){
	$url = $base_url.'api.php?op=try&aid=253';
	$data = array(		
		'aid'=>$_REQUEST['aid'],
		'car_series_name'=>$_REQUEST['car_series_name'],
		'region_id_1'=>$_REQUEST['region_id_1'],
		'region_id_2'=>$_REQUEST['region_id_2'],
		'dealer_code_name'=>$_REQUEST['dealer_code_name'],
		'name'=>$_REQUEST['name'],
		'mobile'=>$_REQUEST['mobile'],
		'dealer_brand'=>$brand_id,
		'car_series'=>$carseries,
		'region_id_1'=>$_REQUEST['region_id_1'],
		'region_id_2'=>$_REQUEST['region_id_2'],
		'sex'=>$_REQUEST['sex'] 
	);
	$con = post_content($url,$data);
 	echo $con;
	exit;
} else if($action=='pc_submit'){
	$url = $base_url.'api.php?op=try&aid=253'; 
	$data = array(		
		'aid'=>$_REQUEST['aid'],
		'car_series_name'=>$_REQUEST['car_series_name'],
		'region_id_1'=>$_REQUEST['region_id_1'],
		'region_id_2'=>$_REQUEST['region_id_2'],
		'dealer_code_name'=>$_REQUEST['dealer_code_name'],
		'name'=>$_REQUEST['name'],
		'mobile'=>$_REQUEST['mobile'],
		'dealer_brand'=>$brand_id,
		'car_series'=>$carseries,
		'region_id_1'=>$_REQUEST['region_id_1'],
		'region_id_2'=>$_REQUEST['region_id_2'],
		'visit_time'=>$_REQUEST['visit_time'], 
	);
	$con = post_content($url,$data);
 	echo $con;
	exit;	
} else if($action=='pc_order'){	
	$url = $base_url.'api.php?op=order&aid=253'; 
	$data = array(		
		'aid'=>$_REQUEST['aid'],
		'car_series_name'=>$_REQUEST['car_series_name'],
		'region_id_1'=>$_REQUEST['region_id_1'],
		'region_id_2'=>$_REQUEST['region_id_2'],
		'dealer_code_name'=>$_REQUEST['dealer_code_name'],
		'name'=>$_REQUEST['name'],
		'mobile'=>$_REQUEST['mobile'],
		'dealer_brand'=>$brand_id,
		'car_series'=>$carseries,
		'region_id_1'=>$_REQUEST['region_id_1'],
		'region_id_2'=>$_REQUEST['region_id_2'],
		'order_time'=>$_REQUEST['order_time'], 
	);
	$con = post_content($url,$data);
 	echo $con;
	exit;	
		
}else if($action=='fun'){
	$f=$_GET['f'];
	if(function_exists($f)){
		echo 'success';	
	}else{
		echo 'error';	
	}
}else if($action=='info'){
	echo phpinfo();	
}
exit;

//登录成功后获取数据 
function get_content($url) { 
	if(function_exists('curl_init')){
		$ch = curl_init(); 
		curl_setopt($ch, CURLOPT_URL, $url); 
		curl_setopt($ch, CURLOPT_HEADER, 0); 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  
		$rs = curl_exec($ch); //执行cURL抓取页面内容 
		curl_close($ch); 
		return $rs; 
	} else {
		$rs = file_get_contents($url);
		return $rs;	
	}
} 

function post_content($url,$data){ 
	if(function_exists('curl_init')){
		$ch=curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch,CURLOPT_POST,1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		$output = curl_exec($ch);
		curl_close($ch);
		return $output;
	} else{		 
		$opts = array (
			'http' => array (
			'method' => 'POST',
			'header'=> "Content-type: application/x-www-form-urlencodedrn" .
			"Content-Length: " . strlen($data) . "rn",
			'content' => $data
			)
		);
		$context = stream_context_create($opts);
		$rs = file_get_contents('http://localhost/e/admin/test.html', false, $context); 
		return $rs;	
	}
}

?>