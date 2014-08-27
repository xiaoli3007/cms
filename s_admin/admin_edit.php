<?php
require dirname(__FILE__).DIRECTORY_SEPARATOR."admin_common.php";

$image = inc_base::load_sys_class('image');
inc_base::load_sys_func('dir');


$admin_role_db = inc_base::load_model('admin_role_model');
	$admin_db = inc_base::load_model('admin_model');
	

/*$id = isset($_GET['id']) ? intval($_GET['id']) : 0;	
		if($id){
		$r = $admin_db->get_one(array('userid'=>$id));
		}
		
	$datasrolename = $admin_role_db->select("1=1 and roleid!=1");
	*/	 
	if(isset($_POST['dosubmit'])) {
		
		$info = $_POST['info'];
		
		
		
		
		$idss=$_SESSION['userid'];
		$oldpass = $_POST['oldpass'];
		$newpass = $_POST['newpass'];
		
		$bb=$admin_db->get_one(array('userid'=>$idss));
		if($bb['password']!= md5(md5(trim($oldpass)))){
			showmessage('原密码错误！','admin_edit.php',1000);	
		}
		
		
		if($newpass){
			$member['password'] = md5(md5(trim($newpass)));
			$admin_db->update($member, array('userid'=>$idss));
		}
		
		
		$admin_db->update($info, array('userid'=>$idss));

		showmessage(L('operation_success'),'admin_edit.php',1000);	
			
		}
		
		

	
	include $admin->admin_tpl('admin_edit');


		
		
?>