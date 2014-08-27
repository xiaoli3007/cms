<?php

$code = $_GET["code"];
require_once './class/config.inc.php';
require_once './class/RenrenOAuthApiService.class.php';
require_once './class/RenrenRestApiService.class.php';

if($code){
	
	//获取accesstoken
	$oauthApi = new RenrenOAuthApiService;
	$post_params = array('client_id'=>$config->APIKey,
			'client_secret'=>$config->SecretKey,
			'redirect_uri'=>$config->redirecturi,
			'grant_type'=>'authorization_code',
			'code'=>$code
			);
	$token_url='http://graph.renren.com/oauth/token';
	$access_info=$oauthApi->rr_post_curl($token_url,$post_params);//使用code换取token
	//$access_info=$oauthApi->rr_post_fopen($token_url,$post_params);//如果你的环境无法支持curl函数，可以用基于fopen函数的该函数发送请求
	$access_token=$access_info["access_token"];
	$expires_in=$access_info["expires_in"];
	$refresh_token=$access_info["refresh_token"];
	//session_start();
	$_SESSION["access_token"]=$access_token;

	//获取用户信息RenrenRestApiService
	$restApi = new RenrenRestApiService;
	$params = array('fields'=>'uid,name,sex,birthday,mainurl,hometown_location,university_history,tinyurl,headurl','access_token'=>$access_token);
	$res = $restApi->rr_post_curl('users.getInfo', $params);//curl函数发送请求

	
	$user_message = $res[0];
	
print_r($user_message);
exit;	


}else{
	
	echo "<script>
				window.close();
		 </script>";
			
	exit;

}

?>