<?php
require dirname(__FILE__).DIRECTORY_SEPARATOR."admin_common.php";

$image = inc_base::load_sys_class('image');
inc_base::load_sys_func('dir');


$photos_db = inc_base::load_model('photos_model');
$photos_thumb_db = inc_base::load_model('photos_thumb_model');
$photo_category_db = inc_base::load_model('photo_category_model');
$admin_db = inc_base::load_model('admin_model');


if($_GET['delete_image']){						//ajax 删除二级图片
	
	
	$deletess=$photos_thumb_db->get_one(array('id'=>$_GET['delete_image']));
	
	$upload_root = inc_base::load_config('system','upload_path');
	
	$savepath1 = $upload_root.'photo/'.$deletess['thumb'];		//删除关联附件
	$savepath2 = $upload_root.'photo/'.$deletess['thumb_small'];
			
			if (file_exists($savepath1)) {
			@unlink($savepath1);
			}
			if (file_exists($savepath2)) {
			@unlink($savepath2);
			}
			
			
	$delete=$photos_thumb_db->delete(array('id'=>$_GET['delete_image']));
	
	
	echo $delete;
	exit;
}


if($_POST['contenttype']=='edit' || $_GET['contenttype']=='edit'){
	
	$admin->check_priv('photo_edit');	//权限判断
	
	if(isset($_POST['dosubmit'])) {
			
		$info = $_POST['info'];
	
		$id = isset($_POST['id']) ? intval($_POST['id']) : 0;	
		$catid = $_POST['catid'] = intval($_POST['catid']);
		
		$info['updatetime']=time();
	
		$photos_db->update($info, array('id'=>$id));
		
		
		$photos_thumb_db->delete(array('photo_id'=>$id));		//删除关联的所有影集图片
		
		foreach($_POST['infotwo_image'] as $key=>$val){			//多条图片的更新
		if($val){
		$news_two_images['thumb']=$val;		
		$news_two_images['thumb_small']=$_POST['infotwo_image_small'][$key];		//小图的
		$news_two_images['photo_id']=$id;
		$photos_thumb_db->insert($news_two_images);	
				}
		}

		showmessage(L('operation_success'),'photo.php?contenttype=edit&id='.$id.'&catid='.$catid,1000);
		
	}else{
		
		$catid = $_GET['catid'] = intval($_GET['catid']);

		$id = isset($_GET['id']) ? intval($_GET['id']) : 0;	
		
	
		$r = $photos_db->get_one(array('id'=>$id));
		
		$r_two_image=$photos_thumb_db->select("`photo_id` = '$id'");
	
		$category_listArr = $photo_category_db->select("`parentid` = '0'");
		
	}
	
	include $admin->admin_tpl('photo_add');


}elseif($_POST['contenttype']=='add' || $_GET['contenttype']=='add'){
	
		$admin->check_priv('photo_add');	//权限判断
		
	
		$category_listArr = $photo_category_db->select("`parentid` = '0'");
		
	if(isset($_POST['dosubmit'])) {
		
		$info = $_POST['info'];
		
		$info['inputtime']=time();
		if($_SESSION['roleid']!=1){
		$info['admin_id'] =$_SESSION['userid'];	
		}
		$photos_db->insert($info);
		
		$newsid=$photos_db->insert_id();		//新影集 的ID
		
		foreach($_POST['infotwo_image'] as $key=>$val){			//多条影集图片的
		if($val){
		$news_two_images['thumb']=$val;		
		$news_two_images['thumb_small']=$_POST['infotwo_image_small'][$key];		//小图的
		$news_two_images['photo_id']=$newsid;
		$photos_thumb_db->insert($news_two_images);	
				}
		}

		showmessage(L('operation_success'),'photo.php',1000);
		
	}
	
	include $admin->admin_tpl('photo_add');


}elseif($_POST['contenttype']=='delete'){
	
	$admin->check_priv('photo_delete');	//权限判断
	

	
	$ids = isset($_POST['ids']) ? $_POST['ids'] : 0;	
	
	$upload_root = inc_base::load_config('system','upload_path');
		
	foreach($ids as $k=>$v){
		if($v){
			
			//------------------------------------------------删除附表关联附件
			$tu_infofu=$photos_thumb_db->select(array('photo_id'=>$v)); 
			foreach($tu_infofu as  $cc){
			$savepath11 = $upload_root.'photo/'.$cc['thumb'];		
			$savepath22 = $upload_root.'photo/'.$cc['thumb_small'];
			
			if (file_exists($savepath11)) {
			@unlink($savepath11);
			}
			if (file_exists($savepath22)) {
			@unlink($savepath22);
			}
	
			$photos_thumb_db->delete(array('id'=>$cc['id'])); 	//删除最终数据
			}
			//------------------------------------------------删除附表关联附件
			
			//------------------------------------------------删除主体关联附件
			$tu_info=$photos_db->get_one(array('id'=>$v)); 
			
			$savepath1 = $upload_root.'photo/'.$tu_info['thumb'];		
			$savepath2 = $upload_root.'photo/'.$tu_info['thumb_small'];
			
			if (file_exists($savepath1)) {
			@unlink($savepath1);
			}
			if (file_exists($savepath2)) {
			@unlink($savepath2);
			}
	
			$photos_db->delete(array('id'=>$v)); 	//删除最终数据
			
			//------------------------------------------------删除主体关联附件
		}
	}

	showmessage('成功','photo.php?page='.$_GET['page'].'&catid='.$_GET['catid'],0);

}elseif($_POST['contenttype']=='remove'){
	

	$ids = isset($_POST['ids']) ? $_POST['ids'] : 0;	
	
	$inddd['catid']=$_POST['remove_catid'];
	foreach($ids as $k=>$v){
		if($v){
			$photos_db->update($inddd,array('id'=>$v)); 
		}
	}

	showmessage('成功','photo.php?page='.$_GET['page'].'&catid='.$_GET['catid'],0);

}elseif($_GET['contenttype']=='hot'){
	

	
	$id = isset($_GET['id']) ? $_GET['id'] : 0;	
	$hot = isset($_GET['hot']) ? $_GET['hot'] : 0;	

	if($hot==1){
		$photos_db->update(array('hot'=>'1'), array('id'=>$id));
	}elseif($hot==2){
		$photos_db->update(array('hot'=>'2'), array('id'=>$id));
	}else{
		$photos_db->update(array('hot'=>'0'), array('id'=>$id));
	}

	showmessage('成功','photo.php?page='.$_GET['page'].'&catid='.$_GET['catid'],0);
		
}else{
	

	
	$category_listArr = $photo_category_db->select("`parentid` = '0'");
	$admin_username = inc_base::get_cookie('admin_username');
	$where = "1=1";
	$pagesize=30;
	
	
	$page = $_GET['page'] ? intval($_GET['page']) : '1';
	
	
	$catid = $_GET['catid'] = intval($_GET['catid']);
	$id = $_GET['id'] = intval($_GET['id']);
		
	
	
	if($id){	
	$where .= ' AND id='.$id;
	}
		

	if($catid){	
	$where .= ' AND catid='.$catid;
	}
	if($_SESSION['roleid']!=1){
	$where .= ' AND admin_id ='.$_SESSION['userid'];	
	}

		//搜索
		
		if(isset($_GET['start_time']) && $_GET['start_time']) {
			$start_time = strtotime($_GET['start_time']);
			$where .= " AND `inputtime` > '$start_time'";
		}
		if(isset($_GET['end_time']) && $_GET['end_time']) {
			$end_time = strtotime($_GET['end_time']);
			$where .= " AND `inputtime` < '$end_time'";
		}
		

		
		$datas = $photos_db->listinfo($where,'id desc',$page,$pagesize);

		$pages = $photos_db->pages;

	
	$es_hash = $_SESSION['es_hash'];
	include $admin->admin_tpl('photo_list');

}
		
		
?>