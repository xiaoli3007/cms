<?php
require dirname(__FILE__).DIRECTORY_SEPARATOR."admin_common.php";

$image = inc_base::load_sys_class('image');
inc_base::load_sys_func('dir');


$admin_role_db = inc_base::load_model('admin_role_model');
	$admin_db = inc_base::load_model('admin_model');
	


if($_GET['contenttype']=='add' || $_GET['contenttype']=='edit'){
	
		$id = isset($_GET['id']) ? intval($_GET['id']) : 0;	
		if($id){
		$r = $admin_db->get_one(array('userid'=>$id));
		}
		
	$datasrolename = $admin_role_db->select("1=1 and roleid!=1");
		print_r($datasrolename);
		exit;
	if(isset($_POST['dosubmit'])) {
		
		$info = $_POST['info'];
		
		
		if($_POST['contenttype']=='edit'){
		
		$idss=$_POST['id'];
		
		$newpass = $_POST['newpass'];
		
		if($newpass){
			$member['password'] = md5(md5(trim($newpass)));
			$admin_db->update($member, array('userid'=>$idss));
		}
		
		
		$admin_db->update($info, array('userid'=>$idss));

		showmessage(L('operation_success'),'admin_member.php?contenttype=edit&id='.$idss,1000);	
			
		}else{
		
		$newpass = $_POST['newpass'];
		
		if($newpass){
			$info['password'] = md5(md5(trim($newpass)));
			
		}
		
		$admin_db->insert($info);

		showmessage(L('operation_success'),'admin_member.php',1000);		
			
		}
		
		
	}
	
	include $admin->admin_tpl('admin_member_edit');

}elseif($_POST['contenttype']=='delete'){
	

	
	$ids = isset($_POST['ids']) ? $_POST['ids'] : 0;	
		
	foreach($ids as $k=>$v){
		if($v){
			$admin_db->delete(array('userid'=>$v)); 
			
		}
	}

	showmessage('成功','admin_member.php?page='.$page,0);

}else{
	
	
	

	$where = "1=1 and userid!=1";
	
	$page_size=30;
		
	$datas = $admin_db->listinfo($where,'userid desc',$_GET['page'],$page_size);

	$pages = $admin_db->pages;
	$es_hash = $_SESSION['es_hash'];
	
	
	include $admin->admin_tpl('admin_member_list');

}
		
		
?>