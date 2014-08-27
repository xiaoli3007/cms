<?php
require dirname(__FILE__).DIRECTORY_SEPARATOR."admin_common.php";


$good_comment_db = inc_base::load_model('good_comment_model');

$news_db = inc_base::load_model('news_model');

$member_db = inc_base::load_model('member_model');

$admin_db = inc_base::load_model('admin_model');



if($_POST['contenttype']=='delete'){
	
	$ids = isset($_POST['ids']) ? $_POST['ids'] : 0;	
		
	foreach($ids as $k=>$v){
		if($v){
			
		$good_comment_db->delete(array('id'=>$v)); 	//删除最终数据

		}
	}

	showmessage('成功','pinglun.php?page='.$_GET['page'],0);

}else{
	


	$where = "1=1";
	$pagesize=30;
		
	$page = $_GET['page'] ? intval($_GET['page']) : '1';
	


	$datas = $good_comment_db->listinfo($where,'id desc',$page,$pagesize);

	$pages = $good_comment_db->pages;

	
	$es_hash = $_SESSION['es_hash'];
	include $admin->admin_tpl('pinglun_list');

}
		
		
?>