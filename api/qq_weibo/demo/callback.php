<?php require("../../api/global.php");?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
 <script src="../../statics/js/My97DatePicker/WdatePicker.js" type="text/javascript"></script>
</head>

<?php



if($_POST['qq'] && $_POST['access_token']){				//表单发送定时器
	
	$date=strtotime($_POST['endtime']);
	
	$db->query("INSERT INTO  `{$pre}timemachine` (
	`id` ,`text` ,`ACCESS_TOKEN`,`OAUTH_TOKEN_SECRET` ,`date` ,`qq` 
	)VALUES (
	NULL ,  '$_POST[textdx]', '$_POST[access_token]','$_POST[access_token2]', '$date',1
	)");
	
		$aa=$db->insert_id();
	if($aa){
	echo "提交成功";
	}
}

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

//打开session
session_start();
header('Content-Type: text/html; charset=utf-8');
$exit = false;

		
	/*$_SESSION[OpenSDK_Tencent_Weibo::ACCESS_TOKEN]='5f425d0b3d964f6293811101453aefb8';
	$_SESSION[OpenSDK_Tencent_Weibo::OAUTH_TOKEN_SECRET]='327bab3b900258814cfa9e6c527f77fc';
	$_SESSION[OpenSDK_Tencent_Weibo::OPENID]='7B260FA404448170E130232B558655C4';
	$_SESSION[OpenSDK_Tencent_Weibo::OPENKEY]='93B7C4F8D734993CB804DA340E8C35CC';*/
	

	
OpenSDK_Tencent_Weibo::init($appkey, $appsecret);

$uinfo = OpenSDK_Tencent_Weibo::call('user/info');
	$uinfo=$uinfo['data'];
$onlineip=real_server_ip();

 $picadd="http://ww4.sinaimg.cn/square/6d0912f5jw1do94qp9c7nj.jpg";
?>

	<?=$uinfo['name']?>,您好！ 
	<h2 align="left">发送新微博</h2>
	<form action="" method="post" enctype="multipart/form-data">
		文字<input type="text" name="text" style="width:300px"  value="" />
        
     
        图片<input type="text" name="pic" style="width:300px"  value="<?=$picadd?>" />
		<input type="submit" />
	</form><br />
<br />
	<h2 align="left">定时微博</h2>
	<form action="" method="post" enctype="multipart/form-data">
    
    日期：<input style="width:200px; height:16px;" name="endtime" id="d4311" type="text"  value=""  onFocus="WdatePicker({maxDate:'#F{$dp||\'2020-10-01\'}',minDate:'<?php echo date('Y-m-d',time());?>',dateFmt:'yyyy-MM-dd HH:mm:ss',alwaysUseStartDate:true})"/>
    
	内容	<input type="text" name="textdx" style="width:300px"  value="<?=$pictext?>" />
        
   
      <input type="text" name="access_token" style="width:300px"  value="<?=$_SESSION[OpenSDK_Tencent_Weibo::ACCESS_TOKEN]?>" />
      <input type="text" name="access_token2" style="width:300px"  value="<?=$_SESSION[OpenSDK_Tencent_Weibo::OAUTH_TOKEN_SECRET]?>" />
        
          <input type="text" name="qq" style="width:300px"  value="1" />
        
		<input type="submit" />
	</form>
    
    <br />
该用户的粉丝为 <?php 
	$api_name = 'friends/fanslist';
	
$fensi = OpenSDK_Tencent_Weibo::call($api_name);


foreach($fensi['data']['info'] as $key=>$v){
	
	$fensiss[$key]['nick']=$v['nick'];
	$fensiss[$key]['name']=$v['name'];
	
	
	}
	
	//print_r($fensiss);
?>
<select name="">
<?php foreach($fensiss as $vv){?>
  <option value="<?=$vv[name]?>"><?=$vv[nick]?></option>
  
  <?php }?>
</select>



<?php
	
	      
if($_POST['text']){
		
		$api_name = 't/add_pic';
	$call_result = OpenSDK_Tencent_Weibo::call($api_name, array(
							'content' => $_POST['text'],
							'clientip' => $onlineip
,
							), 'POST', array(
								'pic' => array(
									'type' => 'image/jpg',
									'name' => $_POST['pic'],
									'data' => file_get_contents($_POST['pic']),
								)),true);
	
	echo '</br>openid&openkey call_result:</br><pre>';
	print_r($call_result);
	echo '</pre>';
}
	 
/* $api_name = 't/add';
		
	$call_result = OpenSDK_Tencent_Weibo::call($api_name, array(
							'content' => $_POST['text'],
							'clientip' => $onlineip

							), 'POST', array(
								
									'format' => 'json',
									'content' => $_POST['pic'],
									'clientip' => $onlineip
								),true);
	print_r($call_result);*/
	

	
	
	
?>

<body>
</body>
</html>
