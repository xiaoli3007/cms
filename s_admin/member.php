<?php
require dirname(__FILE__).DIRECTORY_SEPARATOR."admin_common.php";

$image = inc_base::load_sys_class('image');
inc_base::load_sys_func('dir');


if($_POST['contenttype']=='edit' || $_GET['contenttype']=='edit'){
	
	if(isset($_POST['dosubmit'])) {
		
		$member_db = inc_base::load_model('member_model');
		
		$id = isset($_POST['id']) ? intval($_POST['id']) : 0;	
		$newpass = $_POST['newpass'];
		
		if($newpass){
			$member['password'] = md5(md5(trim($newpass)));
			$member_db->update($member, array('userid'=>$id));
		}
		
		
			if($cat){
			
			$member_category_db->delete(array('userid'=>$id)); 
			$info['userid'] = $id;
			$member_category_db->insert($info);
			
			}

		showmessage(L('operation_success'),'member.php?contenttype=edit&id='.$id,1000);
		
	}else{
		

		$id = isset($_GET['id']) ? intval($_GET['id']) : 0;	
		
		$member_db = inc_base::load_model('member_model');
		$linkage_db = inc_base::load_model('linkage_model');

		$r = $member_db->get_one(array('userid'=>$id));
		
		
		include $admin->admin_tpl('member_edit');
		exit;
		
	}

}elseif($_GET['contenttype']=='delete'){
	
	$member_db = inc_base::load_model('member_model');
	
	$ids = isset($_POST['ids']) ? $_POST['ids'] : 0;	
	
	foreach($ids as $k=>$v){
		if($v){
			$member_db->delete(array('userid'=>$v)); 
		}
	}

	showmessage('成功','member.php?page='.$_GET['page'],0);

}elseif($_GET['contenttype']=='hot'){
	
	$news_db = inc_base::load_model('news_model');
	
	$id = isset($_GET['id']) ? $_GET['id'] : 0;	
	$hot = isset($_GET['hot']) ? $_GET['hot'] : 0;	

	if($hot==1){
		$news_db->update(array('hot'=>'1'), array('id'=>$id));
	}elseif($hot==2){
		$news_db->update(array('hot'=>'2'), array('id'=>$id));
	}else{
		$news_db->update(array('hot'=>'0'), array('id'=>$id));
	}

	showmessage('成功','member.php?page='.$_GET['page'],0);
		
}else{
	
	$member_db = inc_base::load_model('member_model');
	
	$show_header = $show_dialog  = $show_es_hash = '';
	
	$where = "1 = 1";
	
	$datas = $member_db->listinfo($where,'userid desc',$_GET['page']);

		$pages = $member_db->pages;
		$es_hash = $_SESSION['es_hash'];
	
	
		include $admin->admin_tpl('member_list');


}
		
		
?>