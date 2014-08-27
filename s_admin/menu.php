<?php
require dirname(__FILE__).DIRECTORY_SEPARATOR."admin_common.php";

$image = inc_base::load_sys_class('image');
inc_base::load_sys_func('dir');


$news_db = inc_base::load_model('news_model');
$menu_db = inc_base::load_model('menu_model');

inc_base::load_sys_class('form','',1);


if($_GET['contenttype']=='add' || $_GET['contenttype']=='edit'){
	
		
		$id = isset($_GET['id']) ? intval($_GET['id']) : 0;	
		if($id){
		$r = $menu_db->get_one(array('id'=>$id));
		}
		
		$datasparentid = $menu_db->select("1=1 and id!=$id and parentid=0");
		
		
	if(isset($_POST['dosubmit'])) {
		
		$info = $_POST['info'];
		
		
		if($_POST['contenttype']=='edit'){
		
		$idss=$_POST['id'];
		
		
		$menu_db->update($info, array('id'=>$idss));

		showmessage(L('operation_success'),'menu.php?contenttype=edit&id='.$idss,1000);	
			
		}else{
		
		$menu_db->insert($info);

		showmessage(L('operation_success'),'menu.php',1000);		
			
		}
		
		
	}
	
	include $admin->admin_tpl('menu_add');

}elseif($_POST['contenttype']=='delete'){
	

	
	$ids = isset($_POST['ids']) ? $_POST['ids'] : 0;	
		
	foreach($ids as $k=>$v){
		if($v){
			$menu_db->delete(array('id'=>$v)); 
			
		}
	}

	showmessage('成功','menu.php?page='.$page,0);

}else{
	
	
		$tree = inc_base::load_sys_class('tree');
		$category_items = array();
	
		$tree->icon = array('&nbsp;&nbsp;&nbsp;│ ','&nbsp;&nbsp;&nbsp;├─ ','&nbsp;&nbsp;&nbsp;└─ ');
		$tree->nbsp = '&nbsp;&nbsp;&nbsp;';
		$categorys = array();
		//读取缓存
		$result =  $menu_db->select('','*','','listorder desc');
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
			
				$categorys[$r['id']] = $r;
			}
		}
	
		$str  = "<tr>
		<td align='center'><input class='inputcheckbox' name='ids[]' value='\$id' type='checkbox'></td>
		<td align='center' >\$id</td>
        <td align='left' >\$spacer\$name\$display_icon</td>
  
             <td align='left'>\$url</td>
			   <td align='center'>\$display</td>
			   <td align='center'>\$listorder</td>
    <td align='center'><a href='menu.php?contenttype=edit&id=\$id'>编辑</a></td>
	</tr>";
    
		$tree->init($categorys);
		$categorys = $tree->get_tree(0, $str);
		
	

/*	$where = "1=1 and parentid 	=0";
	
	$page_size=30;
		
	$datas = $menu_db->listinfo($where,'id desc',$_GET['page'],$page_size);

	$pages = $menu_db->pages;
	$es_hash = $_SESSION['es_hash'];*/
	
	
	include $admin->admin_tpl('menu_list');

}
		
		
?>