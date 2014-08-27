<?php session_start(); require("../../api/global.php");

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

$exit = false;


	
if($_GET['type']=='qq'){
	
	$timetext=$_GET['token'];
	$timetoken=$_GET['token2'];
	
	$_SESSION[OpenSDK_Tencent_Weibo::ACCESS_TOKEN]=$timetext;
	$_SESSION[OpenSDK_Tencent_Weibo::OAUTH_TOKEN_SECRET]=$timetoken;


	OpenSDK_Tencent_Weibo::init($appkey, $appsecret);

	$api_name = 'friends/fanslist';
	
$fensi = OpenSDK_Tencent_Weibo::call($api_name,array(
							'startindex' =>$_GET['youb'],
							));
							
							

if($fensi['data']['info']){
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

$friend=$fensiss;
	?>
	
    
    
                         <?php 
					
					foreach($friend['users'] as $key=>$v){	
						
                       // $v['tou']=='/120'?'statics/images/user.jpg':$v['tou'];
		
                        
	$html.="<li><img src='".$v['tou']."' width='35' height='35'><p><input type='checkbox' name='friendArr'  onClick='return friend_add(this)'; value='".$v['name_full']."' class='friendArr'>".$v['name']."</p></li>";
                            }
						
						 echo '{
							"status": "'.$friend['next_cursor'].'",
							"info": "'.$html.'"
						  
							 }';
						?>
                        
	
 <?php
}else{
	echo '{
							"status": "",
							"info": ""
						  
							 }';
	
	
	}
	
}
			
?>