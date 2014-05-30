<?php
require dirname(__FILE__).DIRECTORY_SEPARATOR."admin_common.php";

$image = inc_base::load_sys_class('image');
inc_base::load_sys_func('dir');


$news_db = inc_base::load_model('news_model');
	$category_db = inc_base::load_model('category_model');
	
inc_base::load_sys_class('form','',1);

if($_GET['contenttype']=='add' || $_GET['contenttype']=='edit'){
	
		
		$id = isset($_GET['id']) ? intval($_GET['id']) : 0;	
		if($id){
		$r = $category_db->get_one(array('catid'=>$id));
		}
		
	if(isset($_POST['dosubmit'])) {
		
		$info = $_POST['info'];
		
		
		if($_POST['contenttype']=='edit'){
		
		$idss=$_POST['id'];
		
		
		if($info['parentid']==$idss){
			
			showmessage('不能选自己为上级','category.php?contenttype=edit&id='.$idss,1000);
		}
		
		$category_db->update($info, array('catid'=>$idss));

		showmessage(L('operation_success'),'category.php?contenttype=edit&id='.$idss,1000);	
			
		}else{
		
		$category_db->insert($info);

		showmessage(L('operation_success'),'category.php',1000);		
			
		}
		
		
	}
	
	include $admin->admin_tpl('category_add');

}elseif($_POST['contenttype']=='delete'){
		
	$ids = isset($_POST['ids']) ? $_POST['ids'] : 0;	
		
	foreach($ids as $k=>$v){
		if($v){
			$category_db->delete(array('catid'=>$v)); 
			
		}
	}

	showmessage('成功','category.php?page='.$page,0);

}elseif($_GET['contenttype']=='html_all_cat'){
	
	$create_html=inc_base::load_sys_class('create_html','html_classes',1);
	
	$arr=$category_db->select();
	foreach($arr as $v){
		$arr_cat[]=$v['catid'];
	}
	
	$p_num=$_GET['p_num']? $_GET['p_num'] : 0;
	$html_url=$create_html->category_all($arr_cat,$p_num);
	
	print_r('成功！');
	exit;
	
}elseif($_GET['contenttype']=='html_all_show'){
	
	$create_html=inc_base::load_sys_class('create_html','html_classes',1);
	
	$arr=$category_db->select();
	foreach($arr as $v){
		$arr_cat[]=$v['catid'];
	}
	
	$p_num=$_GET['p_num']? $_GET['p_num'] : 0;
	
	$html_url=$create_html->show_all($arr_cat,$p_num);
	
	print_r('成功！');
	exit;
	
}elseif($_GET['contenttype']=='cat_html'){
	
	$create_html=inc_base::load_sys_class('create_html','html_classes',1);
	
	$catid=$_GET['id'];
	//$page=$_GET['page']? $_GET['page'] : 1;
	$html_url=$create_html->category($catid);
	
	print_r('成功！');
	exit;
	
}elseif($_GET['contenttype']=='content_html'){
	

	$create_html=inc_base::load_sys_class('create_html','html_classes',1);
	
	$catid=$_GET['id'];
	//$page=$_GET['page']? $_GET['page'] : 1;
	$html_url=$create_html->show($catid);
	
	print_r('成功！');
	exit;
	

}elseif($_GET['contenttype']=='html_index'){
	

	$create_html=inc_base::load_sys_class('create_html','html_classes',1);
	
	$html_url=$create_html->public_index();
	
	print_r('成功！');
	exit;

}else{
	
	
	
		$tree = inc_base::load_sys_class('tree');
		$category_items = array();
	
		$tree->icon = array('&nbsp;&nbsp;&nbsp;│ ','&nbsp;&nbsp;&nbsp;├─ ','&nbsp;&nbsp;&nbsp;└─ ');
		$tree->nbsp = '&nbsp;&nbsp;&nbsp;';
		$categorys = array();
		//读取缓存
		$result =  $category_db->select('','*','','listorder desc');
		$show_detail = count($result) < 500 ? 1 : 0;
		$parentid = $_GET['parentid'] ? intval($_GET['parentid']) : 0;
		if(!empty($result)) {
			foreach($result as $r) {
				
				$r['str_manage'] = '';
				if(!$show_detail) {
					if($r['parentid']!=$parentid) continue;
					$r['parentid'] = 0;
				}
				$r['display'] =$r['display']? '显示':'不显示';
			
				$categorys[$r['catid']] = $r;
			}
		}
	
		$str  = "<tr>
		<td align='center'><input class='inputcheckbox' name='ids[]' value='\$catid' type='checkbox'></td>
		<td align='center' >\$id</td>
        <td align='left' >\$spacer\$catname\$display_icon</td>
  
             <td align='left'>\$title</td>
			   <td align='left'>\$keywords</td>
			    <td align='center'>\$cat_dir</td>
			   <td align='center'>\$listorder</td>
    <td align='center'><a href='category.php?contenttype=edit&id=\$catid'>编辑</a> | <a href='category.php?contenttype=cat_html&id=\$catid'>更新列表静态</a> | <a href='category.php?contenttype=content_html&id=\$catid'>更新内容静态</a></td>
	</tr>";
    
		$tree->init($categorys);
		$categorys = $tree->get_tree(0, $str);
		
	

	/*$where = "1=1";
	
	$page_size=10;
		
	$datas = $category_db->listinfo($where,'catid desc',$_GET['page'],$page_size);

	$pages = $category_db->pages;
	$es_hash = $_SESSION['es_hash'];*/
	
	
	include $admin->admin_tpl('category_list');

}
		
		
?>