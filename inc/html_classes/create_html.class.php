<?php
class create_html  {
	private $db;
	public $siteid,$categorys;
	public function __construct() {
		
		$this->db = inc_base::load_model('news_model');
		foreach($_GET as $k=>$v) {
			$_POST[$k] = $v;
		}
	}
	
	private function urls($id, $catid= 0, $inputtime = 0, $prefix = ''){
		$urls = $this->url->show($id, 0, $catid, $inputtime, $prefix,'','edit');
		//更新到数据库
		$url = $urls[0];
		$this->db->update(array('url'=>$url),array('id'=>$id));
		//echo $id; echo "|";
		return $urls;
	}
	
	
		/**
	* 批量生成内容页
	*/
	public function show($catid) {
			$html=inc_base::load_sys_class('html','html_classes',1);
			$category_db = inc_base::load_model('category_model');
			$es_hash=$_GET['es_hash'];
			//$page = $page ? $page : 1;
			$page=$_GET['page']? $_GET['page'] : 1;
			$pagesize=10;
			
			$where="`catid` = $catid";
			$c_info=$category_db ->get_one(array('catid'=>$catid));
			$datas = $this->db->listinfo($where,'id desc',$page,$pagesize);
			
			foreach($datas as $i){
				
			if($i['html_url']){
				$html->show(1,$i,'','','');	
				$html_url=$i['html_url'];
			}else{
				
				$html_url=$html->show('',$i,'','','');		//判断如果没有静态路径重新生产
			}
			$info_html_new['html_url']=$html_url;
			$this->db->update($info_html_new, array('id'=>$i['id']));		//重新更新url
				
			}

			$total_number = ceil($this->db->count($where)/$pagesize);
			$page++;
			if($page<=$total_number){
			$message = '更新 ('.$c_info['catname'].') 第'.($page-1).'页结束，开始更新第'.$page.'页';
			$forward = "category.php?contenttype=content_html&id=$catid&es_hash=$es_hash&page=$page";
			showmessage($message,$forward,200);
			}else{
				
			$message = '更新此栏目成功，开始返回';
			$forward = "category.php";
			showmessage($message,$forward,200);	
			}

	}
	
	/**
	* 生成栏目页
	*/
	public function category($catid) {
		
			$html=inc_base::load_sys_class('html','html_classes',1);
			$category_db = inc_base::load_model('category_model');
			$es_hash=$_GET['es_hash'];
			//$page = $page ? $page : 1;
			$page=$_GET['page']? $_GET['page'] : 1;
			$pagesize=10;
			
			$c_info=$category_db ->get_one(array('catid'=>$catid));
			$html_url=$html->category($catid,$page,$pagesize);
			
			$total_number = isset($total_number) ? $total_number : PAGES;
			
			$page++;
			if($page<=$total_number){
			$message = '更新 ('.$c_info['catname'].') 第'.($page-1).'页结束，开始更新第'.$page.'页';
			$forward = "category.php?contenttype=cat_html&id=$catid&es_hash=$es_hash&page=$page";
			showmessage($message,$forward,200);
			}else{
				
			$message = '更新此栏目成功，开始返回';
			$forward = "category.php";
			showmessage($message,$forward,200);	
			}

	}
	
	/**
	* 生成内容页
	*/
	public function show_all($arr_cat,$p_num) {
			$html=inc_base::load_sys_class('html','html_classes',1);
			$category_db = inc_base::load_model('category_model');
			$es_hash=$_GET['es_hash'];
			//$page = $page ? $page : 1;
			$page=$_GET['page']? $_GET['page'] : 1;
			$pagesize=10;
			$catid=$arr_cat[$p_num];
			
			$where="`catid` = $catid";
			$c_info=$category_db ->get_one(array('catid'=>$catid));
			$datas = $this->db->listinfo($where,'id desc',$page,$pagesize);
			
			foreach($datas as $i){
				
			if($i['html_url']){
				$html->show(1,$i,'','','');	
				$html_url=$i['html_url'];
			}else{
				
				$html_url=$html->show('',$i,'','','');		//判断如果没有静态路径重新生产
			}
			$info_html_new['html_url']=$html_url;
			$this->db->update($info_html_new, array('id'=>$i['id']));		//重新更新url
				
			}

			$total_number = ceil($this->db->count($where)/$pagesize);
			$page++;
			
			if($page<=$total_number){
			$message = '更新 ('.$c_info['catname'].') 第'.($page-1).'页结束，开始更新第'.$page.'页';
			$forward = "category.php?contenttype=html_all_show&p_num=$p_num&es_hash=$es_hash&page=$page";
			showmessage($message,$forward,200);
			}else{
			
			$p_num++;
			if($p_num<count($arr_cat)){
			$message = '更新 ('.$c_info['catname'].')成功，开始更新下一栏目';
			$forward = "category.php?contenttype=html_all_show&p_num=$p_num&es_hash=$es_hash&page=";
			showmessage($message,$forward,200);	
			}else{
			
				
			$message = '更新所有栏目内容成功，开始返回';
			$forward = "category.php";
			showmessage($message,$forward,200);	
				
			}
			}

	}
		/**
	* 批量生成栏目页
	*/
	public function category_all($arr_cat,$p_num) {
		
			$html=inc_base::load_sys_class('html','html_classes',1);
			$category_db = inc_base::load_model('category_model');
			$es_hash=$_GET['es_hash'];
			//$page = $page ? $page : 1;
			$page=$_GET['page']? $_GET['page'] : 1;
			$pagesize=10;
			$catid=$arr_cat[$p_num];
			
			$c_info=$category_db ->get_one(array('catid'=>$catid));
			$html_url=$html->category($catid,$page,$pagesize);
			
			$total_number = isset($total_number) ? $total_number : PAGES;
			
			$page++;
			
				
			if($page<=$total_number){
			$message = '更新 ('.$c_info['catname'].') 第'.($page-1).'页结束，开始更新第'.$page.'页';
			$forward = "category.php?contenttype=html_all_cat&p_num=$p_num&es_hash=$es_hash&page=$page";
			showmessage($message,$forward,200);
			}else{
			
			$p_num++;
			if($p_num<count($arr_cat)){
			$message = '更新 ('.$c_info['catname'].')成功，开始更新下一栏目';
			$forward = "category.php?contenttype=html_all_cat&p_num=$p_num&es_hash=$es_hash&page=";
			showmessage($message,$forward,200);	
			}else{
			
				
			$message = '更新所有栏目成功，开始返回';
			$forward = "category.php";
			showmessage($message,$forward,200);	
				
			}
			}
			
	}
	
	//生成首页
	public function public_index() {
		$html=inc_base::load_sys_class('html','html_classes',1);
		$size = $html->index();
		showmessage('OK!');
	}
	/**
	* 批量生成内容页
	*/
	public function batch_show() {
		if(isset($_POST['dosubmit'])) {
			$catid = intval($_GET['catid']);
			if(!$catid) showmessage(L('missing_part_parameters'));
			$modelid = $this->categorys[$catid]['modelid'];
			$setting = string2array($this->categorys[$catid]['setting']);
			$content_ishtml = $setting['content_ishtml'];
			if($content_ishtml) {
				$this->url = inc_base::load_app_class('url');
				$this->db->set_model($modelid);
				if(empty($_POST['ids'])) showmessage(L('you_do_not_check'));
				$this->html = inc_base::load_app_class('html');
				$ids = implode(',', $_POST['ids']);
				$rs = $this->db->select("catid='$catid' AND id IN ($ids)");
				$tablename = $this->db->table_name.'_data';
				foreach($rs as $r) {
					if($r['islink']) continue;
					$this->db->table_name = $tablename;
					$r2 = $this->db->get_one(array('id'=>$r['id']));
					if($r2) $r = array_merge($r,$r2);
					//判断是否为升级或转换过来的数据
					if(!$r['upgrade']) {
						$urls = $this->url->show($r['id'], '', $r['catid'],$r['inputtime']);
					} else {
						$urls[1] = $r['url'];
					}
					$this->html->show($urls[1],$r,0,'edit',$r['upgrade']);
				}
				showmessage(L('operation_success'),HTTP_REFERER);
			}
		}
	}
}
?>