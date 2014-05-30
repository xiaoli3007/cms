<?php
require dirname(__FILE__).DIRECTORY_SEPARATOR."admin_common.php";

$image = inc_base::load_sys_class('image');
inc_base::load_sys_func('dir');


	$photo_category_db = inc_base::load_model('photo_category_model');
	


if($_GET['contenttype']=='add' || $_GET['contenttype']=='edit'){
	
		
		$id = isset($_GET['id']) ? intval($_GET['id']) : 0;	
		if($id){
		$r = $photo_category_db->get_one(array('catid'=>$id));
		}
		
	if(isset($_POST['dosubmit'])) {
		
		$info = $_POST['info'];
		
		
		if($_POST['contenttype']=='edit'){
		
		$idss=$_POST['id'];
		
		
		$photo_category_db->update($info, array('catid'=>$idss));

		showmessage(L('operation_success'),'photo_category.php?contenttype=edit&id='.$idss,1000);	
			
		}else{
		
		$photo_category_db->insert($info);

		showmessage(L('operation_success'),'photo_category.php',1000);		
			
		}
		
		
	}
	
	include $admin->admin_tpl('photo_category_add');

}elseif($_POST['contenttype']=='delete'){
	

	
	$ids = isset($_POST['ids']) ? $_POST['ids'] : 0;	
		
	foreach($ids as $k=>$v){
		if($v){
			$photo_category_db->delete(array('catid'=>$v)); 
			
		}
	}

	showmessage('成功','photo_category.php?page='.$page,0);

}else{
	
	
	

	$where = "1=1";
	
	$page_size=10;
		
	$datas = $photo_category_db->listinfo($where,'catid desc',$_GET['page'],$page_size);

	$pages = $photo_category_db->pages;
	$es_hash = $_SESSION['es_hash'];
	
	
	include $admin->admin_tpl('photo_category_list');

}
		
		
?>