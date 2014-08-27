<?php 

require_once("../comm/config.php");
require_once("../comm/utils.php");

require dirname(__FILE__).DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."inc".DIRECTORY_SEPARATOR."common.php";



function qq_callback()
{
    //debug
    //print_r($_REQUEST);


    if($_REQUEST['state'] == $_SESSION['state']) //csrf
    {
        $token_url = "https://graph.qq.com/oauth2.0/token?grant_type=authorization_code&"
            . "client_id=" . $_SESSION["appid"]. "&redirect_uri=" . urlencode($_SESSION["callback"])
            . "&client_secret=" . $_SESSION["appkey"]. "&code=" . $_REQUEST["code"];

        $response = get_url_contents($token_url);
		
	

        if (strpos($response, "callback") !== false)
        {
            $lpos = strpos($response, "(");
            $rpos = strrpos($response, ")");
            $response  = substr($response, $lpos + 1, $rpos - $lpos -1);
            $msg = json_decode($response);
            if (isset($msg->error))
            {
                echo "<h3>error:</h3>" . $msg->error;
                echo "<h3>msg  :</h3>" . $msg->error_description;
                exit;
            }
        }

        $params = array();
        parse_str($response, $params);

        //debug
        //print_r($params);

        //set access token to session
        $_SESSION["access_token"] = $params["access_token"];
		

    }
    else 
    {
        echo("The state does not match. You may be a victim of CSRF.");
    }
}

function get_openid()
{
    $graph_url = "https://graph.qq.com/oauth2.0/me?access_token=" 
        . $_SESSION['access_token'];

    $str  = get_url_contents($graph_url);
    if (strpos($str, "callback") !== false)
    {
        $lpos = strpos($str, "(");
        $rpos = strrpos($str, ")");
        $str  = substr($str, $lpos + 1, $rpos - $lpos -1);
    }

    $user = json_decode($str);
    if (isset($user->error))
    {
        echo "<h3>error:</h3>" . $user->error;
        echo "<h3>msg  :</h3>" . $user->error_description;
        exit;
    }

    //debug
    //echo("Hello " . $user->openid);

    //set openid to session
    $_SESSION["openid"] = $user->openid;
}

function get_user_info()
{
    $get_user_info = "https://graph.qq.com/user/get_user_info?"
        . "access_token=" . $_SESSION['access_token']
        . "&oauth_consumer_key=" . $_SESSION["appid"]
        . "&openid=" . $_SESSION["openid"]
        . "&format=json";

    $info = get_url_contents($get_user_info);
    $arr = json_decode($info, true);

    return $arr;
}

//QQ登录成功后的回调地址,主要保存access token


qq_callback();
get_openid();
$aa=get_user_info();



	
	if($_SESSION[openid]){
		
$member_db = inc_base::load_model('member_model');
		//查询帐号
$r = $member_db->get_one(array('qq_id'=>$_SESSION[openid],'api_type'=>'qq'));
	
	if($r){
		
							//执行登陆操作 
		inc_base::set_cookie('_username',$r['username']);
		inc_base::set_cookie('_userid', $r['userid']);
		inc_base::set_cookie('_nickname', $r['nickname']);
			
	
		/*echo "<script> window.location='".APP_PATH."';</script>";*/
	echo "<script> window.opener.login_api();window.close();   </script>";
	
	exit;
	
	}else{
	
	$_SESSION['qq_reg']['id']=$_SESSION[openid];
	$_SESSION['qq_reg']['name']=$aa[nickname];
	$_SESSION['qq_reg']['head']=$aa[figureurl_2];
	$_SESSION['qq_reg']['qq_token']=$_SESSION[access_token];


/*echo "<script> window.location='".APP_PATH."reg.php?step=api_reg&api_type=qq';</script>";*/

echo "<script> window.opener.reg_api('qq');window.close();   </script>";
	
	exit;
	}
	
	}else{		//未授权帐号
		
	/*	echo "<script>alert('未授权帐号！'); window.parent.login_reload();</script>";*/
		
			echo "<script> window.opener.login_api();window.close();   </script>";
	
	
		exit;	
	}
	


	
/*print_r($_SESSION);
exit;*/

//获取用户标示id




/*//print_r($_SESSION);
//die;
//echo "<script>window.close();</script>";*/
?>
