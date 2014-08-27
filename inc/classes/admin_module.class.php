<?php
/* $Id: base.php 是否为后台 2011-12-22 13:09 孙立 $ */
/* @Copyright 2012 EaseMany  */

define('IN_ADMIN',true);

inc_base::_session_start();
class admin_module {
	public $userid;
	public $username;
	public $roleid;
	
	
	
	public function __construct() {
		self::check_admin();

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
			
			$this->roleid = $roleid = $_SESSION['roleid'];
			
			
			
			if(!isset($userid) || !isset($roleid) || !$userid || !$roleid) showmessage_m('请先登录后台管理','admin_login.php');
				
	
		}
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
		if(!$r) showmessage_m('您没有权限操作该项');
		}
	}

}

?>