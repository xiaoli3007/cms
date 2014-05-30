<?php
require dirname(__FILE__).DIRECTORY_SEPARATOR."admin_common.php";

if($_GET['admintype']=='menu_left'){
	
	$menuid = intval($_GET['menuid']);
	$datas = admin::admin_menu($menuid);
	if (isset($_GET['parentid']) && $parentid = intval($_GET['parentid']) ? intval($_GET['parentid']) : 1) {
		foreach($datas as $_value) {
			if($parentid==$_value['id']) {
				echo '<li id="_M'.$_value['id'].'" class="on top_menu"><a href="javascript:_M('.$_value['id'].',\''.$_value['url'].'\')" hidefocus="true" style="outline:none;">'.$_value['name'].'</a></li>';
				
			} else {
				echo '<li id="_M'.$_value['id'].'" class="top_menu"><a href="javascript:_M('.$_value['id'].',\''.$_value['url'].'\')"  hidefocus="true" style="outline:none;">'.$_value['name'].'</a></li>';
			}      	
		}
	} else {
		include $admin->admin_tpl('left');
	}
	
}elseif($_GET['admintype']=='current_pos'){
	echo admin::current_pos($_GET['menuid']);
	exit;
}elseif($_GET['admintype']=='ajax_add_panel'){
	$menuid = isset($_POST['menuid']) ? $_POST['menuid'] : exit('0');
	$menu_db = inc_base::load_model('menu_model');
	$menuarr = $menu_db->get_one(array('id'=>$menuid));
	$url = '?m='.$menuarr['m'].'&c='.$menuarr['c'].'&a='.$menuarr['a'].'&'.$menuarr['data'];
	$data = array('menuid'=>$menuid, 'userid'=>$_SESSION['userid'], 'name'=>$menuarr['name'], 'url'=>$url, 'datetime'=>SYS_TIME);
	$panel_db = inc_base::load_model('admin_panel_model');
	$panel_db->insert($data, '', 1);
	$panelarr = $panel_db->listinfo(array('userid'=>$_SESSION['userid']), "datetime");
	foreach($panelarr as $v) {
		echo "<span><a onclick='paneladdclass(this);' target='right' href='".$v['url'].'&menuid='.$v['menuid']."&es_hash=".$_SESSION['es_hash']."'>".$v['name']."</a>  <a class='panel-delete' href='javascript:delete_panel(".$v['menuid'].");'></a></span>";
	}
	exit;
}elseif($_GET['admintype']=='ajax_delete_panel'){
	$menuid = isset($_POST['menuid']) ? $_POST['menuid'] : exit('0');
	$panel_db = inc_base::load_model('admin_panel_model');
	$panel_db->delete(array('menuid'=>$menuid, 'userid'=>$_SESSION['userid']));

	$panelarr = $panel_db->listinfo(array('userid'=>$_SESSION['userid']), "datetime");
	foreach($panelarr as $v) {
		echo "<span><a onclick='paneladdclass(this);' target='right' href='".$v['url']."&es_hash=".$_SESSION['es_hash']."'>".$v['name']."</a> <a class='panel-delete' href='javascript:delete_panel(".$v['menuid'].");'></a></span>";
	}
	exit;
}elseif($_GET['admintype']=='session_life'){
	$userid = $_SESSION['userid'];
	return true;
}else{
	
	#inc_base::load_app_func('global');
	#inc_base::load_app_func('admin');
	#define('PC_VERSION', inc_base::load_config('version','pc_version'));
	#define('PC_RELEASE', inc_base::load_config('version','pc_release'));	
	$admin_db = inc_base::load_model('admin_model');
	$admin_role_db = inc_base::load_model('admin_role_model');
	
	$admin_username = inc_base::get_cookie('admin_username');
	$userid = $_SESSION['userid'];
	
	$r = $admin_db->get_one(array('userid'=>$userid));
	$role = $admin_role_db->get_one(array('roleid'=>$r['roleid']));
	
	$logintime = $r['lastlogintime'];
	$loginip = $r['lastloginip'];
		
	include $admin->admin_tpl('main');
}
?>