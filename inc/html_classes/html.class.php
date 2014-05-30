<?php

inc_base::load_sys_func('util');
inc_base::load_sys_func('dir');

class html {
	private $siteid,$url,$html_root,$queue,$categorys;
	public function __construct() {
		
		$this->queue = inc_base::load_model('queue_model');
		
		$this->category_db = inc_base::load_model('category_model');
		$categorys =$this->category_db->select();
		
		foreach($categorys as $key=>$v){
			
			$this->categorys[$v['catid']]=$v;
			
		}
		
		
		$this->url = inc_base::load_sys_class('url','html_classes',1);
		$this->html_root = inc_base::load_config('system','html_root');
		
	}

	/**
	 * 生成内容页
	 * @param  $file 文件地址
	 * @param  $data 数据
	 * @param  $array_merge 是否合并
	 * @param  $action 方法
	 * @param  $upgrade 是否是升级数据
	 */
	public function show($file, $data  ,$action = 'add',$upgrade = 0,$fenyes) {
		
		
		if(!$file){
			
			$cat_info=$this->category_db->get_one(array('catid'=>$data['catid']));
			$ymd=date('Ymd',time());
			$file=$cat_info['cat_dir'].'/'.$ymd.'/'.$data['id'].'.html';
			$file = $file_data = $this->html_root.'/'.$file;
		}else{
			
			$file=$data['html_url'];
		}
		
	
		
		$id = $data['id'];	
		
		//通过rs获取原始值
		$rs = $data;
		if(isset($fenyes['paginationtype'])) {
			$paginationtype = $data['paginationtype'];
			$maxcharperpage = $data['maxcharperpage'];
		} else {
			$paginationtype = 0;
		}
		$catid = $data['catid'];
		
		$this->queue->add_queue($action,$file,'');
		
		//SEO
		//分页处理
		$pages = $titles = '';
		/*if($paginationtype==1) {
			//自动分页
			if($maxcharperpage < 10) $maxcharperpage = 500;
			$contentpage = inc_base::load_app_class('contentpage');
			$content = $contentpage->get_data($content,$maxcharperpage);
		}
	
		if($paginationtype!=0) {
			//手动分页
			$CONTENT_POS = strpos($content, '[page]');
			if($CONTENT_POS !== false) {
				$this->url = inc_base::load_sys_class('url','html_classes',1);	
				$contents = array_filter(explode('[page]', $content));
				$pagenumber = count($contents);
				if (strpos($content, '[/page]')!==false && ($CONTENT_POS<7)) {
					$pagenumber--;
				}
				for($i=1; $i<=$pagenumber; $i++) {
					$upgrade = $upgrade ? '/'.ltrim($file,WEB_PATH) : '';
					$pageurls[$i] = $this->url->show($id, $i, $catid, $data['inputtime'],'','','edit',$upgrade);
				}
				$END_POS = strpos($content, '[/page]');
				if($END_POS !== false) {
					if($CONTENT_POS>7) {
						$content = '[page]'.$title.'[/page]'.$content;
					}
					if(preg_match_all("|\[page\](.*)\[/page\]|U", $content, $m, PREG_PATTERN_ORDER)) {
						foreach($m[1] as $k=>$v) {
							$p = $k+1;
							$titles[$p]['title'] = strip_tags($v);
							$titles[$p]['url'] = $pageurls[$p][0];
						}
					}
				}
				//生成分页
				foreach ($pageurls as $page=>$urls) {
					$pages = content_pages($pagenumber,$page, $pageurls);
					//判断[page]出现的位置是否在第一位 
					if($CONTENT_POS<7) {
						$content = $contents[$page];
					} else {
						if ($page==1 && !empty($titles)) {
							$content = $title.'[/page]'.$contents[$page-1];
						} else {
							$content = $contents[$page-1];
						}
					}
					if($titles) {
						list($title, $content) = explode('[/page]', $content);
						$content = trim($content);
						if(strpos($content,'</p>')===0) {
							$content = '<p>'.$content;
						}
						if(stripos($content,'<p>')===0) {
							$content = $content.'</p>';
						}
					}
					$pagefile = $urls[1];
					if($this->siteid!=1) {
						$pagefile = $this->html_root.'/'.$site_dir.$pagefile;
					}
					$this->queue->add_queue($action,$pagefile,'');
					$pagefile = INC_PATH.$pagefile;
					ob_start();
					include template('detail');
					$this->createhtml($pagefile);
				}
				return true;
			}
		}*/
		//分页处理结束
		$file = INC_PATH.$file;
		
		ob_start();
		//include template('default','detail');
		include template_php('detail');
		$s=$this->createhtml($file);
		return $file_data;
	}

	/**
	 * 生成栏目列表
	 * @param $catid 栏目id
	 * @param $page 当前页数
	 */
	public function category($catid, $page = 0,$pagesize) {
		
		
		$CAT = $this->categorys[$catid];
		@extract($CAT);
		$copyjs = '';
		$page = intval($page);
		
		if($CAT['parentid']!=0){
		$parentdir = $this->categorys[$CAT['parentid']]['cat_dir'].'/';	
		}else{
		$parentdir ='/';	
			
		}
		
		$catdir = $CAT['cat_dir'];
		$category_ruleid=1; //url规则 1
		$base_file = $this->url->get_list_url($category_ruleid,$parentdir, $catdir, $catid, $page);
		$base_file = '/'.$base_file;
		//$base_file = $this->html_root.'/'.$base_file;
		
		
		$root_domain =  0;
		$count_number = substr_count($CAT['url'], '/');
		$urlrules = getcache('urlrules','commons');
		$urlrules = explode('|',$urlrules[$category_ruleid]);
		
		$file = INC_PATH.substr($this->html_root,1).$base_file;
		
		
		//添加到发布点队列
		$this->queue->add_queue('add',$this->html_root.$base_file,'');
		//评论跨站调用所需的JS文件
		if(substr($base_file, -10)=='index.html' && $count_number==3) {
				$copyjs = 1;
				$this->queue->add_queue('add',$this->html_root.$base_file,'');
		}		
		//URLRULES
		$htm_prefix = $root_domain ? '' : $this->html_root;
		$htm_prefix = rtrim(WEB_PATH,'/').$htm_prefix;
		foreach ($urlrules as $_k=>$_v) {
					$urlrules[$_k] = $htm_prefix.'/'.$_v;
		}
		$template = 'default';
		
		
		//URL规则
		$urlrules = implode('~', $urlrules);
			
		
		define('URLRULE', $urlrules);
		
		
		
		
		
		//$GLOBALS['URL_ARRAY'] = array('year'=>2014, 'catdir'=>$catdir, 'month'=>'04', 'day'=>18, 'id'=>$catid, 'catid'=>$catid);	
		$GLOBALS['URL_ARRAY'] = array('categorydir'=>$parentdir, 'catdir'=>$catdir, 'catid'=>$catid);
	
		ob_start();
		//include template($template,'list');
		include template_php('list');
		return $this->createhtml($file, $copyjs);
	}
	/**
	 * 更新首页
	 */
	public function index() {
		
			
	  $file = '/index.html';
			
	  $file = INC_PATH.$file;
		
	  ob_start();
	  include template_php('index');
	 return $this->createhtml($file);
	}
	/**
	 * 单网页
	 * @param $catid
	 */
	public function page($catid) {
		$this->page_db = inc_base::load_model('page_model');
		$data = $this->page_db->get_one(array('catid'=>$catid));
		return $data;
	}
	/**
	* 写入文件
	* @param $file 文件路径
	* @param $copyjs 是否复制js，跨站调用评论时，需要该js
	*/
	private function createhtml($file, $copyjs = '') {
		$data = ob_get_contents();
		ob_clean();
		$dir = dirname($file);
		if(!is_dir($dir)) {
			mkdir($dir, 0777,1);
		}
		if ($copyjs && !file_exists($dir.'/js.html')) {
			@copy(PC_PATH.'modules/content/templates/js.html', $dir.'/js.html');
		}
		$strlen = file_put_contents($file, $data);
		@chmod($file,0777);
		if(!is_writable($file)) {
			$file = str_replace(INC_PATH,'',$file);
			showmessage(L('file').'：'.$file.'<br>'.L('not_writable'));
		}
		return $strlen;
	}


	/**
	* 生成相关栏目列表、只生成前5页
	* @param $catid
	*/
	public function create_relation_html($catid) {
		for($page = 1; $page < 6; $page++) {
			$this->category($catid,$page);
		}
		//检查当前栏目的父栏目，如果存在则生成
		$arrparentid = $this->categorys[$catid]['arrparentid'];
		if($arrparentid) {
			$arrparentid = explode(',', $arrparentid);
			foreach ($arrparentid as $catid) {
				if($catid) $this->category($catid,1);
			}
		}
	}
}