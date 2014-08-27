<?php
/* $Id: base.php 核心入口文件 2011-12-22 13:09 聆星 $ */
/* @Copyright 2012 EaseMany  */

define('IN_CORE', true);

define('CORE_PATH', dirname(__FILE__).DIRECTORY_SEPARATOR); //类路径

define('INC_PATH', str_replace("inc".DIRECTORY_SEPARATOR,"",CORE_PATH)); //网站根目录

//框架路径
//define('SLCMS_PATH', CORE_PATH.'..'.DIRECTORY_SEPARATOR);


define('ADMIN_URL', '/s_admin/');


//缓存文件夹地址
define('CACHE_PATH', INC_PATH.'caches'.DIRECTORY_SEPARATOR);
//主机协议
define('SITE_PROTOCOL', isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443' ? 'https://' : 'http://');
//当前访问的主机名
define('SITE_URL', (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : ''));
//来源
define('HTTP_REFERER', isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '');

//系统开始时间
define('SYS_START_TIME', microtime());

//加载公用函数库
inc_base::load_sys_func('global');    //公共方法
inc_base::load_sys_func('extention'); //自定义方法
//inc_base::auto_load_func();  //自动加载functions/autoload/*.func.php

inc_base::load_config('system','errorlog') ? set_error_handler('my_error_handler') : error_reporting(E_ERROR | E_WARNING | E_PARSE);
//设置本地时差
function_exists('date_default_timezone_set') && date_default_timezone_set(inc_base::load_config('system','timezone'));

define('CHARSET' ,inc_base::load_config('system','charset'));
//输出页面字符集
header('Content-type: text/html; charset='.CHARSET);

define('SYS_TIME', time());
//定义网站根路径
define('WEB_PATH',inc_base::load_config('system','web_path'));

//js 路径
define('STATICS_PATH',inc_base::load_config('system','statics_path'));

//js 路径
define('JS_PATH',inc_base::load_config('system','js_path'));
//css 路径
define('CSS_PATH',inc_base::load_config('system','css_path'));
//img 路径
define('IMG_PATH',inc_base::load_config('system','img_path'));
//flash 路径
define('SWF_PATH',inc_base::load_config('system','swf_path'));

//admin 备用 路径
define('ADMIN_K',inc_base::load_config('system','admin_k'));
define('ADMIN_PATHSS',inc_base::load_config('system','admin_path'));

//js 路径
define('ADMIN_JS',inc_base::load_config('system','admin_js'));
//css 路径
define('ADMIN_CSS',inc_base::load_config('system','admin_css'));
//img 路径
define('ADMIN_IMG',inc_base::load_config('system','admin_img'));
//flash 路径
define('ADMIN_SWF',inc_base::load_config('system','admin_swf'));

//动态程序路径
define('APP_PATH',inc_base::load_config('system','app_path'));

define('UPLOAD_URL',inc_base::load_config('system','upload_url'));

define('OKEY',inc_base::load_config('system','oracle_key'));

if(inc_base::get_cookie('sys_lang')) {
	define('SYS_STYLE',inc_base::get_cookie('sys_lang'));
} else {
	define('SYS_STYLE','zh-cn');
}





	
//应用静态文件路径
define('PLUGIN_STATICS_PATH',WEB_PATH.'statics/plugin/');

if(inc_base::load_config('system','gzip') && function_exists('ob_gzhandler')) {
	ob_start('ob_gzhandler');
} else {
	ob_start();
}

class inc_base {
	
	public function __construct() {
		if(!get_magic_quotes_gpc()) {
			$_POST = new_addslashes($_POST);
			$_GET = new_addslashes($_GET);
			$_REQUEST = new_addslashes($_REQUEST);
			$_COOKIE = new_addslashes($_COOKIE);
		}
		return true;
	}
	
		/**
	 * 初始化应用程序 (模块儿)
	 */
	public static function creat_app() {
		return self::load_sys_class('application');
	}
	
	
	/**
	 * 加载系统类方法
	 * @param string $classname 类名
	 * @param string $path 扩展地址
	 * @param intger $initialize 是否初始化
	 */
	public static function load_sys_class($classname, $path = '', $initialize = 1) {
			
			return self::_load_class($classname, $path, $initialize);
	}
	
	/**
	 * 加载应用类方法
	 * @param string $classname 类名
	 * @param string $m 模块
	 * @param intger $initialize 是否初始化
	 */
	public static function load_app_class($classname, $m = '', $initialize = 1) {
	
		
		return self::_load_class2($classname, 'modules'.DIRECTORY_SEPARATOR.$m.DIRECTORY_SEPARATOR.'classes', $initialize);
		
			
	}
	
	/**
	 * 加载应用类方法
	 * @param string $classname 类名
	 * @param string $path 扩展地址
	 * @param intger $initialize 是否初始化
	 */
	private static function _load_class2($classname, $path = '', $initialize = 1) {
		static $classes = array();
		if (empty($path)) $path = 'classes';
		
		
				
		$key = md5($path.$classname);
		if (isset($classes[$key])) {
			if (!empty($classes[$key])) {
				return $classes[$key];
			} else {
				return true;
			}
		}
		
		if (file_exists(INC_PATH.$path.DIRECTORY_SEPARATOR.$classname.'.class.php')) {
			include INC_PATH.$path.DIRECTORY_SEPARATOR.$classname.'.class.php';
			$name = $classname;
			if ($initialize) {
				$classes[$key] = new $name;
			} else {
				$classes[$key] = true;
			}
			
		
			return $classes[$key];
			
		
		} else {
				
			return false;
		}
	}
	
	
	/**
	 * 加载数据模型
	 * @param string $classname 类名
	 */
	public static function load_model($classname) {
		return self::_load_class($classname,'model');
	}
		
	/**
	 * 加载类文件函数
	 * @param string $classname 类名
	 * @param string $path 扩展地址
	 * @param intger $initialize 是否初始化
	 */
	private static function _load_class($classname, $path = '', $initialize = 1) {
		static $classes = array();
		if (empty($path)) $path = 'classes';


		$key = md5($path.$classname);
		if (isset($classes[$key])) {
			if (!empty($classes[$key])) {
				return $classes[$key];
			} else {
				return true;
			}
		}
			
				
		if (file_exists(CORE_PATH.$path.DIRECTORY_SEPARATOR.$classname.'.class.php')) {
			include CORE_PATH.$path.DIRECTORY_SEPARATOR.$classname.'.class.php';
			$name = $classname;
			if ($initialize) {
				$classes[$key] = new $name;
			} else {
				$classes[$key] = true;
			}
			
		
			return $classes[$key];
			
		
		} else {
				
			return false;
		}
	}
	
	/**
	 * 加载系统的函数库
	 * @param string $func 函数库名
	 */
	public static function load_sys_func($func) {
		return self::_load_func($func);
	}
	
	/**
	 * 自动加载autoload目录下函数库
	 * @param string $func 函数库名
	 */
	public static function auto_load_func($path='') {
		return self::_auto_load_func($path);
	}
	
	/**
	 * 加载应用函数库
	 * @param string $func 函数库名
	 * @param string $m 模型名
	 */
	public static function load_app_func($func, $m = '') {
		if (empty($m)) return false;
		return self::_load_func2($func, 'modules'.DIRECTORY_SEPARATOR.$m.DIRECTORY_SEPARATOR.'functions');
	}
	
		/**
	 * 加载应用函数库2
	 * @param string $func 函数库名
	 * @param string $path 地址
	 */
	private static function _load_func2($func, $path = '') {
		static $funcs = array();
		
		if (empty($path)) $path = 'functions';
		$path .= DIRECTORY_SEPARATOR.$func.'.func.php';
		
		$key = md5($path);
		if (isset($funcs[$key])) return true;
		
		if (file_exists(INC_PATH.$path)) {
			include INC_PATH.$path;
		} else {
			$funcs[$key] = false;
			return false;
		}
		$funcs[$key] = true;
		return true;
	}
	
	
	/**
	 * 加载函数库
	 * @param string $func 函数库名
	 * @param string $path 地址
	 */
	private static function _load_func($func, $path = '') {
		static $funcs = array();
		if (empty($path)) $path = 'functions';
		$path .= DIRECTORY_SEPARATOR.$func.'.func.php';
		$key = md5($path);
		if (isset($funcs[$key])) return true;
		if (file_exists(CORE_PATH.$path)) {
			include CORE_PATH.$path;
		} else {
			$funcs[$key] = false;
			return false;
		}
		$funcs[$key] = true;
		return true;
	}
	
	/**
	 * 加载函数库
	 * @param string $func 函数库名
	 * @param string $path 地址
	 */
	private static function _auto_load_func($path = '') {
		if (empty($path)) $path = 'functions'.DIRECTORY_SEPARATOR.'autoload';
		$path .= DIRECTORY_SEPARATOR.'*.func.php';
		$auto_funcs = glob(CORE_PATH.DIRECTORY_SEPARATOR.$path);
		if(!empty($auto_funcs) && is_array($auto_funcs)) {
			foreach($auto_funcs as $func_path) {
				include $func_path;
			}
		}
	}
	
	/**
	 * 加载配置文件
	 * @param string $file 配置文件
	 * @param string $key  要获取的配置荐
	 * @param string $default  默认配置。当获取配置项目失败时该值发生作用。
	 * @param boolean $reload 强制重新加载。
	 */
	public static function load_config($file, $key = '', $default = '', $reload = false) {
		static $configs = array();
		if (!$reload && isset($configs[$file])) {
			if (empty($key)) {
				return $configs[$file];
			} elseif (isset($configs[$file][$key])) {
				return $configs[$file][$key];
			} else {
				return $default;
			}
		}
		$path = CACHE_PATH.'configs'.DIRECTORY_SEPARATOR.$file.'.php';
		if (file_exists($path)) {
			$configs[$file] = include $path;
		}
		if (empty($key)) {
			return $configs[$file];
		} elseif (isset($configs[$file][$key])) {
			return $configs[$file][$key];
		} else {
			return $default;
		}
	}
	
	/**
	 * 设置 cookie
	 * @param string $var     变量名
	 * @param string $value   变量值
	 * @param int $time    过期时间
	 */
	public static function set_cookie($var, $value = '', $time = 0) {
		$time = $time > 0 ? $time : ($value == '' ? SYS_TIME - 3600 : 0);
		$s = $_SERVER['SERVER_PORT'] == '443' ? 1 : 0;
		$var = inc_base::load_config('system','cookie_pre').$var;
		$_COOKIE[$var] = $value;
		if (is_array($value)) {
			foreach($value as $k=>$v) {
				setcookie($var.'['.$k.']', sys_auth($v, 'ENCODE'), $time, inc_base::load_config('system','cookie_path'), inc_base::load_config('system','cookie_domain'), $s);
			}
		} else {
			setcookie($var, sys_auth($value, 'ENCODE'), $time, inc_base::load_config('system','cookie_path'), inc_base::load_config('system','cookie_domain'), $s);
		}
	}

	/**
	 * 获取通过 set_cookie 设置的 cookie 变量 
	 * @param string $var 变量名
	 * @param string $default 默认值 
	 * @return mixed 成功则返回cookie 值，否则返回 false
	 */
	public static function get_cookie($var, $default = '') {
		
		$var = inc_base::load_config('system','cookie_pre').$var;
		
		return isset($_COOKIE[$var]) ? sys_auth($_COOKIE[$var], 'DECODE') : $default;
	}
	
	public static function _session_start() {
		$session_storage = 'session_'.inc_base::load_config('system','session_storage');
		inc_base::load_sys_class($session_storage);
	}
	
	public static function _set_lang($lang) {
		inc_base::set_cookie('sys_lang', $lang);
	}
}


?>