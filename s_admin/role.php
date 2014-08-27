<?php
require dirname(__FILE__).DIRECTORY_SEPARATOR."admin_common.php";

$image = inc_base::load_sys_class('image');
inc_base::load_sys_func('dir');


	$menu_db = inc_base::load_model('menu_model');
	$admin_role_db = inc_base::load_model('admin_role_model');
	
	$admin_role_priv_db = inc_base::load_model('admin_role_priv_model');
	

	function list_menu($role_id){
		$menu_db = inc_base::load_model('menu_model');
		$admin_role_priv_db = inc_base::load_model('admin_role_priv_model');
		$tree = inc_base::load_sys_class('tree');
		$category_items = array();
	
		$tree->icon = array('&nbsp;&nbsp;&nbsp;│ ','&nbsp;&nbsp;&nbsp;├─ ','&nbsp;&nbsp;&nbsp;└─ ');
		$tree->nbsp = '&nbsp;&nbsp;&nbsp;';
		$categorys = array();
		
		//-----角色的权限---------------------------------
		$quanxianiddss=$admin_role_priv_db->select(array('roleid'=>$role_id));
		foreach($quanxianiddss as $key=>$j){
			
			$affff[]=$j['menuid'];
		}
		//-----角色的权限---------------------------------
		//读取所有权限菜单
		$result =  $menu_db->select('','*','','listorder desc');
		
		//$parentid = $_GET['parentid'] ? intval($_GET['parentid']) : 0;
		if(!empty($result)) {
			foreach($result as $r) {
				
				$r['str_manage'] = '';
				if ( @in_array($r[id], $affff)) {$r['checked']="checked='checked'";}
				
				$no_sub=$menu_db->get_one(array('parentid'=>$r['id']));
				if($r['parentid'] && !$no_sub){
					
					$aa="class=tree".$r['parentid'];
					
					$r['classid']=$aa;
				}elseif($r['parentid'] && $no_sub){
					
					$aa="class='tree$r[parentid] tree$r[id]'" ;
					
					$r['classid']=$aa;
				
				}else{
					$aa="class=tree".$r['id'];
					
					$r['classid']=$aa;
				}
				$categorys[$r['id']] = $r;
			}
		}
	
			
		
		$str  = "<tr>
		<td align='center'><input \$classid name='menuid[]' value='\$id' type='checkbox' \$checked   onclick='selectsub(\$id)'></td>

        <td align='left' >\$spacer\$name\$display_icon</td>
  
	</tr>";
    
		$tree->init($categorys);
		
		$categorys = "<table>";
		$categorys .= $tree->get_tree(0, $str);	
		$categorys .= "</table>";
		return $categorys;
	}

if($_GET['contenttype']=='add' || $_GET['contenttype']=='edit'){
	
		
		
		
		
		$id = isset($_GET['id']) ? intval($_GET['id']) : 0;	
		if($id){
		$r = $admin_role_db->get_one(array('roleid'=>$id));
		}
	
	//-----菜单树---------------------------------
	//$datasparentid = $menu_db->select("1=1 and id!=$id and parentid=0");
		
	$munu_list=list_menu($id);
	//-----菜单树---------------------------------
			

		
	if(isset($_POST['dosubmit'])) {
		
		$info = $_POST['info'];
		
		$menuidss = $_POST['menuid'];
		
		
		if($_POST['contenttype']=='edit'){
		
		$idss=$_POST['id'];
		
		$admin_role_db->update($info, array('roleid'=>$idss));
		
		//-------------------------------------------------------------------操作权限
			if($menuidss){			//权限表
		
		$isfff=$admin_role_priv_db->get_one(array('roleid'=>$idss));
		if($isfff){
		$admin_role_priv_db->delete(array('roleid'=>$idss));			//删除所有权限
		}
		foreach($menuidss as $c){
		
		$infosss3['roleid']=$idss;
		$infosss3['menuid']=$c;
		$admin_role_priv_db->insert($infosss3);		
		}		
		}
		//-------------------------------------------------------------------操作权限
		

		showmessage(L('operation_success'),'role.php?contenttype=edit&id='.$idss,1000);	
			
		}else{
		
		$admin_role_db->insert($info);
		
		$x_idd=$admin_role_db->insert_id();
		//-------------------------------------------------------------------操作权限
		if($menuidss){			//权限表
		
		foreach($menuidss as $c){
		
		$infosss3['roleid']=$x_idd;
		$infosss3['menuid']=$c;
		$admin_role_priv_db->insert($infosss3);		
		}		
		}
		//-------------------------------------------------------------------操作权限
		
		showmessage(L('operation_success'),'role.php',1000);		
			
		}
		
		
	}
	
	include $admin->admin_tpl('role_add');

}elseif($_POST['contenttype']=='delete'){
	

	
	$ids = isset($_POST['ids']) ? $_POST['ids'] : 0;	
		
	foreach($ids as $k=>$v){
		if($v){
			$admin_role_db->delete(array('roleid'=>$v)); 
			
		}
	}

	showmessage('成功','role.php?page='.$page,0);

}else{
	
	
	

	$where = "1=1 and roleid!=1"; 
	
	$page_size=30;
		
	$datas = $admin_role_db->listinfo($where,'roleid desc',$_GET['page'],$page_size);

	$pages = $admin_role_db->pages;
	
	$es_hash = $_SESSION['es_hash'];
	
	
	include $admin->admin_tpl('role_list');

}
		
		
?>