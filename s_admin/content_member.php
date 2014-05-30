<?php
require dirname(__FILE__).DIRECTORY_SEPARATOR."admin_common.php";

$image = inc_base::load_sys_class('image');
inc_base::load_sys_func('dir');
inc_base::load_sys_class('form','',1);

$news_db = inc_base::load_model('news_model');
$news_data_db = inc_base::load_model('news_data_model');
$category_db = inc_base::load_model('category_model');
$admin_db = inc_base::load_model('admin_model');

$member_db = inc_base::load_model('member_model');


$html=inc_base::load_sys_class('html','html_classes',1);



if($_GET['delete_image']){						//ajax 删除二级图片
	
		
	$delete=$news_data_db->delete(array('id'=>$_GET['delete_image']));
	
	
	echo $delete;
	exit;
}



if($_POST['contenttype']=='edit' || $_GET['contenttype']=='edit'){
	
	$admin->check_priv('content_edit');	//权限判断
	
	if(isset($_POST['dosubmit'])) {
		
		$info =$info_html = $_POST['info'];
		$id = isset($_POST['id']) ? intval($_POST['id']) : 0;	
		$info['inputtime']=strtotime($info['inputtime']);
		$info['updatetime']=time();
		$info['description']=addslashes($info['description']);
		$info_data['content']=addslashes($info['content']);
		unset($info['content']);
		$news_db->update($info, array('id'=>$id));
		$news_data_db->update($info_data, array('id'=>$id));
		
		/*更新静态--------------------*/
		$r_old = $news_db->get_one(array('id'=>$id));
		unset($info_html['content']);
		$info_html['id']=$id;
		if($r_old['html_url']){
		$info_html['html_url']=$r_old['html_url'];
		$html_url=$html->show(1,$info_html,'','','');	
		}else{
		$html_url=$html->show('',$info_html,'','','');		//判断如果没有静态路径重新生产
		}
		$info_html_new['html_url']=$html_url;
		$news_db->update($info_html_new, array('id'=>$id));		//重新更新url
		
		showmessage(L('operation_success'),'',1000);
		
	}else{
		
		

		$id = isset($_GET['id']) ? intval($_GET['id']) : 0;	
		
		$r1 = $news_db->get_one(array('id'=>$id));
		
		$r2 = $news_data_db->get_one(array('id'=>$id));
		
		$r = $r2 ? array_merge($r1,$r2) : $r1;
		
	}
	
	include $admin->admin_tpl('content_add');


}elseif($_POST['contenttype']=='add' || $_GET['contenttype']=='add'){
	
		$admin->check_priv('content_add');	//权限判断
		
	
		$category_listArr = $category_db->select("`parentid` = '0'");
		
		if(isset($_POST['dosubmit'])) {
		
	
	
		$info =$info_html = $_POST['info'];
		$info['inputtime']=strtotime($info['inputtime']);
		$info['admin_id'] =$_SESSION['userid'];	
		$info['description']=addslashes($info['description']);
		$info_data['content']=addslashes($info['content']);
		
		unset($info['content']);
		$new_id=$news_db->insert($info,true);
		$info_data['id']=$new_id;
		$news_data_db->insert($info_data);
		
		
		/*生产静态--------------------*/
		$info_html['id']=$new_id;
		$html_url=$html->show('',$info_html,'','','');
		$info_html_new['html_url']=$html_url;
		$news_db->update($info_html_new, array('id'=>$new_id));
		
		showmessage(L('operation_success'),'content_member.php',1000);
		
	}
	
	include $admin->admin_tpl('content_add');


}elseif($_POST['contenttype']=='delete'){
	
	$admin->check_priv('content_delete');	//权限判断
	
	$ids = isset($_POST['ids']) ? $_POST['ids'] : 0;	
	
	$upload_root = inc_base::load_config('system','upload_path');
		
	foreach($ids as $k=>$v){
		if($v){
			
		$news_db->delete(array('id'=>$v)); 
		}
	}

	showmessage('成功','content_member.php?page='.$_GET['page'],0);

}elseif($_POST['contenttype']=='remove'){
	

	$ids = isset($_POST['ids']) ? $_POST['ids'] : 0;	
	
	$inddd['admin_id']=$_POST['remove_catid'];
	foreach($ids as $k=>$v){
		if($v){
			$news_db->update($inddd,array('id'=>$v)); 
		}
	}

	showmessage('成功','content_member.php?page='.$_GET['page'],0);

}elseif($_GET['contenttype']=='hot'){
	

	
	$id = isset($_GET['id']) ? $_GET['id'] : 0;	
	$hot = isset($_GET['hot']) ? $_GET['hot'] : 0;	

	if($hot==1){
		$news_db->update(array('hot'=>'1'), array('id'=>$id));
	}elseif($hot==2){
		$news_db->update(array('hot'=>'2'), array('id'=>$id));
	}else{
		$news_db->update(array('hot'=>'0'), array('id'=>$id));
	}

	showmessage('成功','content_member.php?page='.$_GET['page'],0);
		
}elseif($_GET['contenttype']=='yz'){
	

	
	$id = isset($_GET['id']) ? $_GET['id'] : 0;	
	$yz = isset($_GET['yz']) ? $_GET['yz'] : 0;	

	if($yz==1){
		$news_db->update(array('yz'=>'1'), array('id'=>$id));
	}else{
		$news_db->update(array('yz'=>'0'), array('id'=>$id));
	}

	showmessage('成功','content_member.php?page='.$_GET['page'],0);
		
}elseif($_GET['contenttype']=='excel'){
	

	
	$datas = $news_db->select($where,'*','5000','id desc');
	$file_name=date('YmdHis',time());
	$file_name2=date('Y年m月d日H时i分s秒',time());
	header("Content-type: application/vnd.ms-excel; charset=utf-8");
    header("Content-Disposition: attachment; filename=$file_name.xls");
	
        echo ecs_iconv('gbk', 'GB2312', '编号') . "\t";
		echo ecs_iconv('gbk', 'GB2312', '首次咨询日期') . "\t";
        echo ecs_iconv('gbk', 'GB2312', '资源来源') . "\t";
	
		echo ecs_iconv('gbk', 'GB2312','回访跟踪5') . "\t\n";

        foreach ($datas as $value)
        {
            echo ecs_iconv('gbk', 'GB2312', $value['id']) . "\t";
			 echo ecs_iconv('gbk', 'GB2312',  date('Y-m-d',$value['first_time'])) . "\t";
            echo ecs_iconv('gbk', 'GB2312', $value['laiyuan']) . "\t";
			echo ecs_iconv('gbk', 'GB2312', str_replace("\n","",$value['data'][0]['contents'])) . "\t";
		
           foreach($value['data'] as $key=>$ee){
				
				if($ee['contents']){
			echo ecs_iconv('gbk', 'GB2312', str_replace("\n","",$ee['contents'])) . "\t";
				}
				
			}
           echo "\n";
		}
	
	exit;
	

}else{
	
	
	
	$category_listArr = $category_db->select("`parentid` = '0'");
	$category_admin = $admin_db->select("userid!=1");
	
	$admin_username = inc_base::get_cookie('admin_username');
	$where = "1=1";
	$pagesize=30;
	
	
	$page = $_GET['page'] ? intval($_GET['page']) : '1';
	$catid = $_GET['catid'] ? intval($_GET['catid']) : '1';
	
	$title = $_GET['keyword']  ? trim($_GET['keyword']) : '';
	
	if(isset($catid) && $_GET['catid']) {
			
		$is_sub=$category_db->select(array('parentid'=>$catid));

			if($is_sub){
				foreach($is_sub as $v){
				$bb[]= $v['catid'];
				}
				$catidsun=implode(',',$bb);
				$catidsun.=','.$catid;
				$where.=" AND `catid` in ($catidsun)";
			}else{
				$where .= " AND `catid` = $catid";
			}

	}
		
	if($title){
		$where .= " AND `title` like '%$title%'";
	}

		
	if($_SESSION['roleid']!=1){
	$where .= ' AND admin_id ='.$_SESSION['userid'];	
	}

	//搜索
		
	if(isset($_GET['start_time']) && $_GET['start_time']) {
			$start_time = strtotime($_GET['start_time']);
			$where .= " AND `inputtime` >= '$start_time'";
	}
	if(isset($_GET['end_time']) && $_GET['end_time']) {
			$end_time = strtotime($_GET['end_time']);
			$where .= " AND `inputtime` <= '$end_time'";
	}
		
		
		
	$datas = $news_db->listinfo($where,'id desc',$page,$pagesize);
		
	
	$pages = $news_db->pages;

	
	$es_hash = $_SESSION['es_hash'];
	include $admin->admin_tpl('content_list');

}
		
		
?>