<?php ob_start();

require dirname(__FILE__).DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."inc".DIRECTORY_SEPARATOR."common.php";

$image = inc_base::load_sys_class('image');
inc_base::load_sys_func('dir');

function getImg($url = "", $filename = "") {

		$hander = curl_init();
		$fp = fopen($filename,'wb');

		curl_setopt($hander,CURLOPT_URL,$url);
		curl_setopt($hander,CURLOPT_FILE,$fp);
		curl_setopt($hander,CURLOPT_HEADER,0);
		curl_setopt($hander,CURLOPT_FOLLOWLOCATION,1);
		//curl_setopt($hander,CURLOPT_RETURNTRANSFER,false);//以数据流的方式返回数据,当为false是直接显示出来
		curl_setopt($hander,CURLOPT_TIMEOUT,60);
		curl_exec($hander);
		curl_close($hander);
		fclose($fp);
		return true;
}
			
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
</head>
<script>

 
	var returnvalue,newwin;
	function go_oauth(){
		
		if(1==0){
			returnvalue=window.showModalDialog("?go_oauth","dialogWidth=300px;dialogHeight=200px");
			if(returnvalue==undefined){
				alert("没有返回值");
		 	//return;
		 	}else{
		 		alert(returnvalue);
		 	}
		}else{
		newwin=window.open("?go_oauth","","width=700,height=680,top=0,left=0,toolbar=no,menubar=no,scrollbars=no,location=yes,resizable=no,status=no");
		}
	}
	
	function closeOpener(name,access_token,access_token_secret){
		//alert(window.opener);
		window.opener.returnValue(name,access_token,access_token_secret);
		window.close();
	}
	
	function returnValue(name,access_token,access_token_secret){
		document.write([name,access_token,access_token_secret].join(","));
		if(newwin){newwin.close();}
		location.reload();
	}	
</script>
<?php
/**
 * just a demo
 *
 * 仅仅是个demo，未有严格考虑，请不要使用这个简单逻辑到生产环境。
 *
 */

error_reporting('0');
//设置include_path 到 OpenSDK目录
set_include_path(dirname(dirname(__FILE__)) . '/lib/');
require_once 'OpenSDK/Tencent/Weibo.php';

include 'appkey.php';




OpenSDK_Tencent_Weibo::init($appkey, $appsecret);


//打开session
session_start();
header('Content-Type: text/html; charset=utf-8');
$exit = false;
if(isset($_GET['exit']))
{
	unset($_SESSION[OpenSDK_Tencent_Weibo::OAUTH_TOKEN]);
	unset($_SESSION[OpenSDK_Tencent_Weibo::ACCESS_TOKEN]);
	unset($_SESSION[OpenSDK_Tencent_Weibo::OAUTH_TOKEN_SECRET]);
	unset($_SESSION[OpenSDK_Tencent_Weibo::OPENID]);
	unset($_SESSION[OpenSDK_Tencent_Weibo::OPENKEY]);
	//echo '<a href="?go_oauth">点击去授权</a>';
	echo '<a href="javascript:go_oauth();">点击去授权</a>';
}

else if( isset($_GET['oauth_token']) && isset($_GET['oauth_verifier'])) //第5，6步
{
	
	//从Callback返回时
	if(OpenSDK_Tencent_Weibo::getAccessToken($_GET['oauth_verifier']))
	{
		
	
	$ACCESS_TOKEN=	$_SESSION[OpenSDK_Tencent_Weibo::ACCESS_TOKEN];
	$OAUTH_TOKEN_SECRET=	$_SESSION[OpenSDK_Tencent_Weibo::OAUTH_TOKEN_SECRET];
	$OPENID=	$_SESSION[OpenSDK_Tencent_Weibo::OPENID];
	$OPENKEY=	$_SESSION[OpenSDK_Tencent_Weibo::OPENKEY];
		
		//此时已经可以正常调用CGI
		$user_message = OpenSDK_Tencent_Weibo::call('user/info');
		
		$user_message=$user_message[data];


$api_name = 'statuses/broadcast_timeline';

	$call_results = OpenSDK_Tencent_Weibo::call($api_name, array('format' =>'json','pageflag' => 0,'pagetime' => 0,'reqnum' => 30,'lastid' => 0,'type' => 3,'contenttype' =>0));



	$news_db = inc_base::load_model('news_model');

foreach($call_results['data']['info'] as $key=>$v){
	
		$bbb=$news_db->get_one(array('weibo_id'=>$v['id']));
		if(!$bbb['id']){				//重复了就不在抓取了
			
		if($v['source']['image']){
			$sina_webpic = $v['source']['image'][0].'/460';
			
			
			$fileext = 'jpg';
			$upload_root = inc_base::load_config('system','upload_path');
			$myDirDate = date('Y/md/');
			$savepath = $upload_root.$myDirDate;
			$temp_filename = date('Ymdhis').rand(100, 999).'.'.$fileext;;
			
			$savefile = $savepath.$temp_filename;
			$webfile = $myDirDate.$temp_filename;
			
			if(!dir_create($savepath)) {
				die('目录不存在');
			}
	
			if($filestr=file_get_contents($sina_webpic)){
				write_file($savefile,$filestr);
			}

		
			
		$thumb_setting = array('210','');
		$thumb_enable = is_array($thumb_setting) && ($thumb_setting[0] > 0 || $thumb_setting[1] > 0 ) ? 1 : 0;			
		$image = new image($thumb_enable);				
		$image->thumb($savefile,'',$thumb_setting[0],$thumb_setting[1],'_210x210');
		$picurl_210 = substr($webfile, 0, strrpos($webfile, '.')).'_210x210'.'.'.$fileext;
		
			
			
		}else{
			$webfile = '';
		}
		if($webfile){
			
		$v['source']['text']=preg_replace("/(\/?a.*?)>/si",'',$v['source']['text']);
			
		$infos[$key]['inputtime']=$v['timestamp'] ;
		$infos[$key]['title']=str_cut(safe_replace($v['source']['text']),40);
		$infos[$key]['thumb']=$webfile;
		$infos[$key]['thumb_middle']=$picurl_210;
		$infos[$key]['description']=safe_replace($v['source']['text']);
		$infos[$key]['content']=safe_replace($v['source']['text']);
		$infos[$key]['weibo_id']=$v['id'];
		$infos[$key]['type']='qq';
		}
	}
	
}



	foreach($infos as $v){
		
		$aa=$news_db->get_one(array('weibo_id'=>$v['weibo_id']));
		if(!$aa['id']){
		$news_db->insert($v);
		}
	}
	echo "<script> alert('更新成功！');window.opener.showinfotoflash(); window.close(); </script>";

			
	exit;
	
	
		
	}
	else
	{
		var_dump($_SESSION);
		echo '获得Access Tokn 失败';
	}
	$exit = true;
}
else if(isset($_GET['go_oauth'])) //第1，2，3，4步
{	

$mini=true;
	$callback = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
	
	$request_token = OpenSDK_Tencent_Weibo::getRequestToken($callback);

	$url = OpenSDK_Tencent_Weibo::getAuthorizeURL($request_token);

	echo "<script>window.location='".$url."';</script>";
	header('Location:' . $url);
}
else
{
	//echo '<a href="?go_oauth">点击去授权</a>';
	echo '</br><a href="javascript:go_oauth();">点击去授权</a></br>';
}

if($exit)
{
	echo '</br><a href="?exit">退出再来一次</a></br>';
}
?>
<body>
</body>
</html>