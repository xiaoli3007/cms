<?php session_start();

function real_server_ip(){
	static $serverip = NULL;
 
	if ($serverip !== NULL){
		return $serverip;
	}
 
	if (isset($_SERVER)){
		if (isset($_SERVER['SERVER_ADDR'])){
			$serverip = $_SERVER['SERVER_ADDR'];
		}
		else{
			$serverip = '0.0.0.0';
		}
	}
	else{
		$serverip = getenv('SERVER_ADDR');
	}
 
	return $serverip;
}


//error_reporting('0');
//设置include_path 到 OpenSDK目录
set_include_path(dirname(dirname(__FILE__)) . '/lib/');
require_once 'OpenSDK/Tencent/Weibo.php';

include 'appkey.php';

//打开session

//header('Content-Type: text/html; charset=utf-8');
$exit = false;

function qq_timemachine($timetext,$timetoken,$txt,$image){	
global $appkey,$appsecret,$webdb;
$_SESSION[OpenSDK_Tencent_Weibo::ACCESS_TOKEN]=$timetext;
$_SESSION[OpenSDK_Tencent_Weibo::OAUTH_TOKEN_SECRET]=$timetoken;

//请填上自己的app key
//$appkey = '801106879';
//请填上自己的app secret
//$appsecret = '4da8eb813783a786d75af71160304c19';


	OpenSDK_Tencent_Weibo::init($appkey, $appsecret);

	//$uinfo = OpenSDK_Tencent_Weibo::call('user/info');
	//$uinfo=$uinfo['data'];
	$onlineip=real_server_ip();
	 
	$api_name = 't/add_pic';

	$picadd=$webdb['photo_url']."/".$image;
	$call_result = OpenSDK_Tencent_Weibo::call($api_name, array(
							'content' =>$txt,
							'clientip' => $onlineip
,
							), 'POST', array(
								'pic' => array(
									'type' => 'image/jpg',
									'name' => $picadd,
									'data' => file_get_contents($picadd),
								)),true);
	//print_r($call_result);
	/*global $db,$pre;
	$db->query("INSERT INTO  `{$pre}memberdata` (
	`uid` ,`xueli` ,`hangye` 
	)VALUES (
	NULL ,  '$timetext', '$timetoken'
	)");*/
	
	}
	
	
	
function qq_post($timetext,$timetoken,$txt,$image){							//发送海报
	global $appkey,$appsecret;
	$_SESSION[OpenSDK_Tencent_Weibo::ACCESS_TOKEN]=$timetext;
	$_SESSION[OpenSDK_Tencent_Weibo::OAUTH_TOKEN_SECRET]=$timetoken;
	//请填上自己的app key
	//$appkey = '801106879';
	//请填上自己的app secret
	//$appsecret = '4da8eb813783a786d75af71160304c19';


	OpenSDK_Tencent_Weibo::init($appkey, $appsecret);

	$onlineip=real_server_ip();
	 
	$api_name = 't/add_pic';

	$call_result = OpenSDK_Tencent_Weibo::call($api_name, array(
							'content' =>$txt,
							'clientip' => $onlineip
,
							), 'POST', array(
								'pic' => array(
									'type' => 'image/jpg',
									'name' => $image,
									'data' => file_get_contents($image),
								)),true);

	return $call_result['msg'];
	}
	
function qq_friend($timetext,$timetoken,$next=0){							//发送海报
	global $appkey,$appsecret;
	$_SESSION[OpenSDK_Tencent_Weibo::ACCESS_TOKEN]=$timetext;
	$_SESSION[OpenSDK_Tencent_Weibo::OAUTH_TOKEN_SECRET]=$timetoken;
	//请填上自己的app key
	//$appkey = '801106879';
	//请填上自己的app secret
	//$appsecret = '4da8eb813783a786d75af71160304c19';

	OpenSDK_Tencent_Weibo::init($appkey, $appsecret);

	$api_name = 'friends/fanslist';
	
$fensi = OpenSDK_Tencent_Weibo::call($api_name);


foreach($fensi['data']['info'] as $key=>$v){
	
	//$fensiss[$key]['nick']=$v['nick'];

	if($v['head']){
		
		$v['head']=$v['head'].'/120';
		}else{
			$v['head']='statics/images/user.jpg';
			}
	
	$fensiss['users'][$key]['name_full']=$v['name'];
	$fensiss['users'][$key]['name']=get_word($v['name'],6);
	$fensiss['users'][$key]['tou']=$v['head'];
	
	
	}
$fensiss['next_cursor']=$fensi['data']['nextstartpos'];

	return $fensiss;
	}
	
	
	
?>