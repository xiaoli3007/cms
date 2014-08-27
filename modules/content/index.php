<?php

inc_base::load_app_func('test','content');
class index {
	
	function __construct() {
	 $this->c = inc_base::load_app_class('content','content');
	 $this->admin_module = inc_base::load_sys_class('admin_module');		//后台的程序
	}
	
	/**
	 * 关键词搜索
	 */
	public function init() {
	

	 include template_m('content','setting');
	   
	}


	/**
	 * 关键词搜索
	 */
	public function add() {
	
	$news_db = inc_base::load_model('news_model');
	
	$aa=get_catname222(2);
		
		
	$ddd=$news_db->get_one();
	
	
	$bb= $this->c->search('111111111111111111');
	
	//include template('default','index');
	   
	}
	
	
	

}
?>