<?php
/* $Id: session mysql 数据库存储类 2011-12-22 13:09 聆星 $ */
/* @Copyright 2012 EaseMany  */

class session_oracel {
	var $lifetime = 1800;
	var $db;
	var $table;
/**
 * 构造函数
 * 
 */
    public function __construct() {
		$this->db = inc_base::load_model('session_model');
		$this->lifetime = inc_base::load_config('system','session_ttl');
    	session_set_save_handler(array(&$this,'open'), array(&$this,'close'), array(&$this,'read'), array(&$this,'write'), array(&$this,'destroy'), array(&$this,'gc'));
    	session_start();
    }
/**
 * session_set_save_handler  open方法
 * @param $save_path
 * @param $session_name
 * @return true
 */
    public function open($save_path, $session_name) {
		return true;
    }
/**
 * session_set_save_handler  close方法
 * @return bool
 */
    public function close() {
        return $this->gc();
		#return $this->gc($this->lifetime);
    } 
/**
 * 读取session_id
 * session_set_save_handler  read方法
 * @return string 读取session_id
 */
    public function read($id) {
		$r = $this->db->get_one(array('S_SESSIONID'=>$id), 'S_DATA');
		return $r ? $r['S_DATA'] : '';
    } 
/**
 * 写入session_id 的值
 * 
 * @param $id session
 * @param $data 值
 * @return mixed query 执行结果
 */
    public function write($id, $data) {
    	$uid = isset($_SESSION['userid']) ? $_SESSION['userid'] : 0;
    	$roleid = isset($_SESSION['roleid']) ? $_SESSION['roleid'] : 0;
		if(strlen($data) > 255) $data = '';
		$ip = ip();
		$sessiondata = array(
							'S_SESSIONID'=>$id,
							'S_USERID'=>$uid,
							'S_IP'=>$ip,
							'S_LASTVISIT'=>SYS_TIME,
							'S_ROLEID'=>$roleid,
							'S_DATA'=>$data,
						);
		$r = $this->db->get_one(array('S_SESSIONID'=>$id), 'S_SESSIONID');
		if($r['S_SESSIONID']){
			$this->destroy($id);
		}
		$this->db->insert($sessiondata);
		return $id;
    }
/** 
 * 删除指定的session_id
 * 
 * @param $id session
 * @return bool
 */
    public function destroy($id) {
		return $this->db->delete(array('S_SESSIONID'=>$id));
    }
/**
 * 删除过期的 session
 * 
 * @param $maxlifetime 存活期时间
 * @return bool
 */
   public function gc($maxlifetime) {
		$expiretime = SYS_TIME - $this->lifetime;
		return $this->db->delete("S_LASTVISIT<$expiretime");
    }
}
?>