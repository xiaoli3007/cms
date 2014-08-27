<?php
require dirname(__FILE__).DIRECTORY_SEPARATOR."admin_common.php";

if(isset($_POST['dosubmit'])) {

	$username = isset($_POST['username']) ? trim($_POST['username']) : showmessage('用户名不能为空',HTTP_REFERER);
	
	/*if($_POST['username_cookie']=='1'){
		inc_base::set_cookie('username_cookie',$username,$cookie_time);
	}else{
		inc_base::set_cookie('username_cookie','');
	}*/
	$code = isset($_POST['code']) && trim($_POST['code']) ? trim($_POST['code']) : showmessage(L('input_code'), HTTP_REFERER);

	if ($_SESSION['code'] != strtolower($code)) { //转换为小写
		showmessage(L('code_error'), 'admin_login.php',3000);
	}
	$member_db = inc_base::load_model('admin_model');
	//密码错误剩余重试次数
	$times_db = inc_base::load_model('times_model');
	$rtime = $times_db->get_one(array('username'=>$username,'isadmin'=>1));
	$maxloginfailedtimes = 10;

	if($rtime['times'] > $maxloginfailedtimes) {
		$minute = 60-floor((SYS_TIME-$rtime['logintime'])/60);
		showmessage("密码重试次数太多，请过{$minute}分钟后重新登录！");
	}
	//查询帐号
	$r = $member_db->get_one(array('username'=>$username));
	if(!$r) showmessage('管理员不存在','admin_login.php');
	$password = md5(md5(trim(($_POST['password']))).$r['encrypt']);


	if($r['password'] != $password) {
		$ip = ip();
		if($rtime && $rtime['times'] < $maxloginfailedtimes) {
			$times = $maxloginfailedtimes-intval($rtime['times']);
			$times_db->update(array('ip'=>$ip,'isadmin'=>1,'times'=>'+=1'),array('username'=>$username));
		} else {
			$times_db->delete(array('username'=>$username,'isadmin'=>1));
			$times_db->insert(array('username'=>$username,'ip'=>$ip,'isadmin'=>1,'logintime'=>SYS_TIME,'times'=>1));
			$times = $maxloginfailedtimes;
		}
		showmessage("密码错误，还有{$times}次机会！",'admin_login.php',3000);
	}

	$times_db->delete(array('username'=>$username));
	/*if($_POST['password_cookie']=='1'){
		inc_base::set_cookie('password_cookie',$_POST['password'],$cookie_time);
	}else{
		inc_base::set_cookie('password_cookie','');
	}*/
	


	$member_db->update(array('lastloginip'=>ip(),'lastlogintime'=>SYS_TIME),array('userid'=>$r['userid']));

	$es_hash = random(6,'abcdefghigklmnopqrstuvwxwyABCDEFGHIGKLMNOPQRSTUVWXWY0123456789');
	
	$_SESSION['userid'] = $r['userid'];
	$_SESSION['username'] = $r['username'];
	$_SESSION['roleid'] = $r['roleid'];
	#$_SESSION['qx'] = $r['qx'];
	$_SESSION['es_hash'] = $es_hash;
			
	//if(!$r['lang']) $r['lang'] = 'zh-cn';
	inc_base::set_cookie('admin_username',$r['username']);
	inc_base::set_cookie('userid', $r['userid']);
	//inc_base::set_cookie('admin_email', $r['email']);
	inc_base::set_cookie('roleid', $r['roleid']);
	inc_base::set_cookie('es_hash', $es_hash);
	
	
	//inc_base::set_cookie('sys_lang', SYS_STYLE);
	
	#$qx_admin=explode(",", $_SESSION[qx]);
	
	/*if($_SESSION['username']!='admin'){
	foreach($qx_admin as $vv){
		
		if($vv){
		showmessage('登录成功',$vv.'.php');	
		}else{
		showmessage('登录失败！您没有任何权限！','admin_login.php');		
		}
	}
	}else{
		
		showmessage('登录成功','index.php');	
	}*/
	showmessage('登录成功','index.php');	
	
	
}elseif(isset($_GET['lang'])) {
	inc_base::set_cookie('sys_lang', $_GET['lang']);
	showmessage('跳转中','admin_login.php',0);
}else {
	//echo $_SESSION['code'];
	//echo SYS_STYLE;
	//$username_cookie = inc_base::get_cookie('username_cookie');
	//$password_cookie = inc_base::get_cookie('password_cookie');
	include $admin->admin_tpl('admin_login');
}
header("Cache-control: private");

?>