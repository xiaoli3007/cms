<?php
session_start();

include_once( 'config.php' );
include_once( 'saetv2.ex.class.php' );
//require("../api/global.php");

//Array ( [access_token] => 2.00oHAsaBbYUo8C437c308c5cQtDdDE [expires_in] => 86400 [remind_in] => 4270 [uid] => 1460951124 ) 

//$aa='2.00oHAsaBbYUo8C778c938fe78VDCOC';$_SESSION['token']['access_token']
$aa='2.00rHxqECbYUo8C0e5d59e3aajsl2RB';



$c = new SaeTClientV2( WB_AKEY , WB_SKEY ,$_SESSION['token']['access_token']);
$ms  = $c->home_timeline(); // done
$uid_get = $c->get_uid();
$uid = $uid_get['uid'];
$user_message = $c->show_user_by_id( $uid);//根据ID获取用户等基本信息





if($_POST['sina'] && $_POST['access_token']){				//表单发送定时器
	
	$date=strtotime($_POST['endtime']);
	
	$db->query("INSERT INTO  `{$pre}timemachine` (
	`id` ,`text` ,`sina_access_token` ,`date` ,`sina` 
	)VALUES (
	NULL ,  '$_POST[textdx]', '$_POST[access_token]', '$date',1
	)");
	
		$aa=$db->insert_id();
	if($aa){
	echo "提交成功";
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>新浪微博V2接口演示程序-Powered by Sina App Engine</title>
<script src="http://tjs.sjs.sinajs.cn/t35/apps/opent/js/frames/client.js" language="JavaScript"></script>
 <script src="../statics/js/My97DatePicker/WdatePicker.js" type="text/javascript"></script>
</head>

<body>
   <?php 
       $pictext="默认内容";
       $picadd="http://ww4.sinaimg.cn/square/6d0912f5jw1do94qp9c7nj.jpg";
	   
	   //$picadd=file_get_contents($picadd);
        ?>


	<?=$user_message['screen_name']?>,您好！ 
	<h2 align="left">发送新微博</h2>
	<form action="" method="post" enctype="multipart/form-data">
		<input type="text" name="text" style="width:300px"  value="<?=$pictext?>" />
        
     
        <!--<input type="text" name="pic" style="width:300px"  value="<?=$picadd?>" />-->
		<input type="submit" />
	</form>
    <br />

	<h2 align="left">定时微博</h2>
	<form action="" method="post" enctype="multipart/form-data">
    
    日期：<input style="width:200px; height:16px;" name="endtime" id="d4311" type="text"  value=""  onFocus="WdatePicker({maxDate:'#F{$dp||\'2020-10-01\'}',minDate:'<?php echo date('Y-m-d',time());?>',dateFmt:'yyyy-MM-dd HH:mm:ss',alwaysUseStartDate:true})"/>
    
	内容	<input type="text" name="textdx" style="width:300px"  value="<?=$pictext?>" />
        
     
        <!--<input type="text" name="pic" style="width:300px"  value="<?=$picadd?>" />-->
        
        <input type="text" name="access_token" style="width:300px"  value="<?=$_SESSION['token']['access_token']?>" />
        
          <input type="text" name="sina" style="width:300px"  value="1" />
        
		<input type="submit" />
	</form>
    
    <br />
该用户的粉丝为 <?php 
$followers=$c->followers_by_id($uid);


foreach($followers['users'] as $v){
	
	$fensi[]=$v['name'];
	}
	
	
?>
<select name="">
<?php foreach($fensi as $vv){?>
  <option value="<?=$vv?>"><?=$vv?></option>
  
  <?php }?>
</select>
<?php
if( isset($_REQUEST['text']) ) {
	$ret = $c->update( $_REQUEST['text']);	//发送微博
	if ( isset($ret['error_code']) && $ret['error_code'] > 0 ) {
		echo "<p>发送失败，错误：{$ret['error_code']}:{$ret['error']}</p>";
	} else {
		echo "<p>发送成功</p>";
	}
}
?>

<?php //if( is_array( $ms['statuses'] ) ): ?>
<?php //foreach( $ms['statuses'] as $item ): ?>
<div style="padding:10px;margin:5px;border:1px solid #ccc">
	<?php //echo $item['text'];?>
</div>
<?php //endforeach; ?>
<?php //endif; ?>

</body>
</html>
