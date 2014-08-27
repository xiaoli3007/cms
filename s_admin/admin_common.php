<?php
/* $Id: base.php 核心入口文件 2011-12-22 13:09 聆星 $ */
/* @Copyright 2012 EaseMany  */

define('IN_ADMIN',true);

//后台路径
define('ADMIN_PATH', dirname(__FILE__).DIRECTORY_SEPARATOR);


require ADMIN_PATH."..".DIRECTORY_SEPARATOR."inc".DIRECTORY_SEPARATOR."common.php";

inc_base::_session_start();

define('ADMIN_URL',inc_base::load_config('system','admin_path'));

class admin {
	public $userid;
	public $username;
	public $roleid;
	
	
	
	public function __construct() {
		self::check_admin();
		/*self::check_priv();
		inc_base::load_app_func('global','admin');
		if (!module_exists(ROUTE_M)) showmessage(L('module_not_exists'));
		self::manage_log();
		self::check_ip();
		self::lock_screen();
		self::check_hash();
		if(inc_base::load_config('system','admin_url') && $_SERVER["SERVER_NAME"]!= inc_base::load_config('system','admin_url')) {
			Header("http/1.1 403 Forbidden");
			exit('File does not exist.');
		}*/
	}
	 
	/**
	 * 判断用户是否已经登陆
	 */
	final public function check_admin() {
		$pageurl = get_pagename();
		if(in_array($pageurl, array('admin_login', 'admin_reg'))) {
			return true;
		} else {
			$this->userid = $userid = $_SESSION['userid'];
			$this->username = $username = inc_base::get_cookie('admin_username');
			//$this->sys_lang = $sys_lang = inc_base::get_cookie('sys_lang');
			$this->roleid = $roleid = $_SESSION['roleid'];
			
			if(!isset($userid) || !isset($roleid) || !$userid || !$roleid) showmessage('请先登录后台管理','admin_login.php');
			
			//if($roleid!=1) header("location:".APP_PATH);  //不是管理员，出去

		}
	}
	
	/**
	 * 加载后台模板
	 * @param string $file 文件名
	 * @param string $m 模型名
	 */
	final public static function admin_tpl($file) {
		
		if(empty($file)) return false;
		return ADMIN_PATH.'templates'.DIRECTORY_SEPARATOR.$file.'.tpl.php';
	}
	
	/**
	 * 按父ID查找菜单子项
	 * @param integer $parentid   父菜单ID  
	 * @param integer $with_self  是否包括他自己
	 */
	final public static function admin_menu($parentid, $with_self = 0) {
		$parentid = intval($parentid);
		$menudb = inc_base::load_model('menu_model');
		$result =$menudb->select(array('parentid'=>$parentid,'display'=>1),'*',1000,'listorder ASC');
		if($with_self) {
			$result2[] = $menudb->get_one(array('id'=>$parentid));
			$result = array_merge($result2,$result);
		}
		//权限检查
		if($_SESSION['roleid'] == 1) return $result;
		
		$array = array();
		$privdb = inc_base::load_model('admin_role_priv_model');
		//$siteid = param::get_cookie('siteid');
		foreach($result as $v) {
		
		$r = $privdb->get_one(array('menuid'=>$v['id'],'roleid'=>$_SESSION['roleid']));
				if($r) $array[] = $v;
			
		}
		
		return $array;
	}
	/**
	 * 获取菜单 头部菜单导航
	 * 
	 * @param $parentid 菜单id
	 */
/*	final public static function submenu($parentid = '', $big_menu = false) {
		if(empty($parentid)) {
			$menudb = inc_base::load_model('menu_model');
			$r = $menudb->get_one(array('m'=>ROUTE_M,'c'=>ROUTE_C,'a'=>ROUTE_A));
			$parentid = $_GET['menuid'] = $r['id'];
		}
		$array = self::admin_menu($parentid,1);
		
		$numbers = count($array);
		if($numbers==1 && !$big_menu) return '';
		$string = '';
		$pc_hash = $_SESSION['pc_hash'];
		foreach($array as $_value) {
			if (!isset($_GET['s'])) {
				$classname = ROUTE_M == $_value['m'] && ROUTE_C == $_value['c'] && ROUTE_A == $_value['a'] ? 'class="on"' : '';
			} else {
				$_s = !empty($_value['data']) ? str_replace('=', '', strstr($_value['data'], '=')) : '';
				$classname = ROUTE_M == $_value['m'] && ROUTE_C == $_value['c'] && ROUTE_A == $_value['a'] && $_GET['s'] == $_s ? 'class="on"' : '';
			}
			if($_value['parentid'] == 0 || $_value['m']=='') continue;
			if($classname) {
				$string .= "<a href='javascript:;' $classname><em>".L($_value['name'])."</em></a><span>|</span>";
			} else {
				$string .= "<a href='?m=".$_value['m']."&c=".$_value['c']."&a=".$_value['a']."&menuid=$parentid&pc_hash=$pc_hash".'&'.$_value['data']."' $classname><em>".L($_value['name'])."</em></a><span>|</span>";
			}
		}
		$string = substr($string,0,-14);
		return $string;
	}*/
	/**
	 * 当前位置
	 * 
	 * @param $id 菜单id
	 */
	final public static function current_pos($id) {
		$menudb = inc_base::load_model('menu_model');
		$r =$menudb->get_one(array('id'=>$id),'id,name,parentid');
		$str = '';
		if($r['parentid']) {
			$str = self::current_pos($r['parentid']);
		}
		return $str.$r['name'].' > ';
	}

	/**
	 * 权限判断
	 */
	final public function check_priv($url) {
		if($_SESSION['roleid'] != 1){
		$menudb = inc_base::load_model('menu_model');
		$mm =$menudb->get_one(array('url'=>$url));
		
		$privdb = inc_base::load_model('admin_role_priv_model');
		$r =$privdb->get_one(array('menuid'=>$mm['id'],'roleid'=>$_SESSION['roleid']));
		if(!$r) showmessage('您没有权限操作该项');
		}
	}

	/**
	 * 
	 * 记录日志 
	 */
/*	final private function manage_log() {
		//判断是否记录
		$setconfig = inc_base::load_config('system');
		extract($setconfig);
 		if($admin_log==1){
 			$action = ROUTE_A;
 			if($action == '' || strchr($action,'public') || $action == 'init' || $action=='public_current_pos' || $action=='getmessage') {
				return false;
			}else {
				$ip = ip();
				$log = inc_base::load_model('log_model');
				$username = param::get_cookie('admin_username');
				$userid = isset($_SESSION['userid']) ? $_SESSION['userid'] : '';
				$time = date('Y-m-d H-i-s',SYS_TIME);
				$url = '?m='.ROUTE_M.'&c='.ROUTE_C.'&a='.ROUTE_A;
				$log->insert(array('module'=>ROUTE_M,'username'=>$username,'userid'=>$userid,'action'=>ROUTE_C, 'querystring'=>$url,'time'=>$time,'ip'=>$ip));
			}
	  	}
	}*/
	
	/**
	 * 
	 * 后台IP禁止判断 ...
	 */
	final private function check_ip(){
		$this->ipbanned = inc_base::load_model('ipbanned_model');
		$this->ipbanned->check_ip();
 	}

	/**
 	 * 检查hash值，验证用户数据安全性
 	 */
	final private function check_hash() {
		if(isset($_GET['es_hash']) && $_SESSION['es_hash'] != '' && ($_SESSION['es_hash'] == $_GET['es_hash'])) {
			return true;
		} elseif(isset($_POST['es_hash']) && $_SESSION['es_hash'] != '' && ($_SESSION['es_hash'] == $_POST['es_hash'])) {
			return true;
		} else {
			showmessage(L('hash_check_false'),HTTP_REFERER);
		}
	}
}


$admin = new admin; //激活


?>