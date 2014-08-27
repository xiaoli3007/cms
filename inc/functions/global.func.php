<?php
/* $Id: base.php 核心入口文件 2014-04-10 沙加 $ */
/* @Copyright 2012 EaseMany  */




/**
 * 返回经addslashes处理过的字符串或数组
 * @param $string 需要处理的字符串或数组
 * @return mixed
 */
function new_addslashes($string){
	if(!is_array($string)) return addslashes($string);
	foreach($string as $key => $val) $string[$key] = new_addslashes($val);
	return $string;
}

/**
 * 返回经stripslashes处理过的字符串或数组
 * @param $string 需要处理的字符串或数组
 * @return mixed
 */
function new_stripslashes($string) {
	if(!is_array($string)) return stripslashes($string);
	foreach($string as $key => $val) $string[$key] = new_stripslashes($val);
	return $string;
}

/**
 * 返回经addslashe处理过的字符串或数组
 * @param $obj 需要处理的字符串或数组
 * @return mixed
 */
function new_html_special_chars($string) {
	if(!is_array($string)) return htmlspecialchars($string);
	foreach($string as $key => $val) $string[$key] = new_html_special_chars($val);
	return $string;
}
/**
 * 安全过滤函数
 *
 * @param $string
 * @return string
 */
function safe_replace($string) {
	$string = str_replace('%20','',$string);
	$string = str_replace('%27','',$string);
	$string = str_replace('%2527','',$string);
	$string = str_replace('*','',$string);
	$string = str_replace('"','&quot;',$string);
	$string = str_replace("'",'',$string);
	$string = str_replace('"','',$string);
	$string = str_replace(';','',$string);
	$string = str_replace('<','&lt;',$string);
	$string = str_replace('>','&gt;',$string);
	$string = str_replace("{",'',$string);
	$string = str_replace('}','',$string);
	return $string;
}



/**
 * 过滤ASCII码从0-28的控制字符
 * @return String
 */
function trim_unsafe_control_chars($str) {
	$rule = '/[' . chr ( 1 ) . '-' . chr ( 8 ) . chr ( 11 ) . '-' . chr ( 12 ) . chr ( 14 ) . '-' . chr ( 31 ) . ']*/';
	return str_replace ( chr ( 0 ), '', preg_replace ( $rule, '', $str ) );
}

/**
 * 格式化文本域内容
 *
 * @param $string 文本域内容
 * @return string
 */
function trim_textarea($string) {
	$string = nl2br ( str_replace ( ' ', '&nbsp;', $string ) );
	return $string;
}

/**
 * 将文本格式成适合js输出的字符串
 * @param string $string 需要处理的字符串
 * @param intval $isjs 是否执行字符串格式化，默认为执行
 * @return string 处理后的字符串
 */
function format_js($string, $isjs = 1)
{
	$string = addslashes(str_replace(array("\r", "\n"), array('', ''), $string));
	return $isjs ? 'document.write("'.$string.'");' : $string;
}

/**
 * 转义 javascript 代码标记
 *
 * @param $str
 * @return mixed
 */
function trim_script($str) {
	$str = preg_replace ( '/\<([\/]?)script([^\>]*?)\>/si', '&lt;\\1script\\2&gt;', $str );
	$str = preg_replace ( '/\<([\/]?)iframe([^\>]*?)\>/si', '&lt;\\1iframe\\2&gt;', $str );
	$str = preg_replace ( '/\<([\/]?)frame([^\>]*?)\>/si', '&lt;\\1frame\\2&gt;', $str );
	$str = preg_replace ( '/]]\>/si', ']] >', $str );
	return $str;
}
/**
 * 获取当前页面完整URL地址
 */
function get_url() {
	$sys_protocal = isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443' ? 'https://' : 'http://';
	$php_self = $_SERVER['PHP_SELF'] ? safe_replace($_SERVER['PHP_SELF']) : safe_replace($_SERVER['SCRIPT_NAME']);
	$path_info = isset($_SERVER['PATH_INFO']) ? safe_replace($_SERVER['PATH_INFO']) : '';
	$relate_url = isset($_SERVER['REQUEST_URI']) ? safe_replace($_SERVER['REQUEST_URI']) : $php_self.(isset($_SERVER['QUERY_STRING']) ? '?'.safe_replace($_SERVER['QUERY_STRING']) : $path_info);
	return $sys_protocal.(isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '').$relate_url;
}
/**
 * 获取当前页面文件名
 */
function get_pagename() {
	$url = $_SERVER['PHP_SELF'] ? safe_replace($_SERVER['PHP_SELF']) : safe_replace($_SERVER['SCRIPT_NAME']);
	$pagename = current(explode('.',end(explode('/',$url)))); 
	return $pagename;
}

/**
 * 字符截取 支持UTF8/GBK
 * @param $string
 * @param $length
 * @param $dot
 */
function str_cut($string, $length, $dot = '...') {
	$strlen = strlen($string);
	if($strlen <= $length) return $string;
	$string = str_replace(array(' ','&nbsp;', '&amp;', '&quot;', '&#039;', '&ldquo;', '&rdquo;', '&mdash;', '&lt;', '&gt;', '&middot;', '&hellip;'), array('∵',' ', '&', '"', "'", '“', '”', '—', '<', '>', '·', '…'), $string);
	$strcut = '';
	if(strtolower(CHARSET) == 'utf-8') {
		$length = intval($length-strlen($dot)-$length/3);
		$n = $tn = $noc = 0;
		while($n < strlen($string)) {
			$t = ord($string[$n]);
			if($t == 9 || $t == 10 || (32 <= $t && $t <= 126)) {
				$tn = 1; $n++; $noc++;
			} elseif(194 <= $t && $t <= 223) {
				$tn = 2; $n += 2; $noc += 2;
			} elseif(224 <= $t && $t <= 239) {
				$tn = 3; $n += 3; $noc += 2;
			} elseif(240 <= $t && $t <= 247) {
				$tn = 4; $n += 4; $noc += 2;
			} elseif(248 <= $t && $t <= 251) {
				$tn = 5; $n += 5; $noc += 2;
			} elseif($t == 252 || $t == 253) {
				$tn = 6; $n += 6; $noc += 2;
			} else {
				$n++;
			}
			if($noc >= $length) {
				break;
			}
		}
		if($noc > $length) {
			$n -= $tn;
		}
		$strcut = substr($string, 0, $n);
		$strcut = str_replace(array('∵', '&', '"', "'", '“', '”', '—', '<', '>', '·', '…'), array(' ', '&amp;', '&quot;', '&#039;', '&ldquo;', '&rdquo;', '&mdash;', '&lt;', '&gt;', '&middot;', '&hellip;'), $strcut);
	} else {
		$dotlen = strlen($dot);
		$maxi = $length - $dotlen - 1;
		$current_str = '';
		$search_arr = array('&',' ', '"', "'", '“', '”', '—', '<', '>', '·', '…','∵');
		$replace_arr = array('&amp;','&nbsp;', '&quot;', '&#039;', '&ldquo;', '&rdquo;', '&mdash;', '&lt;', '&gt;', '&middot;', '&hellip;',' ');
		$search_flip = array_flip($search_arr);
		for ($i = 0; $i < $maxi; $i++) {
			$current_str = ord($string[$i]) > 127 ? $string[$i].$string[++$i] : $string[$i];
			if (in_array($current_str, $search_arr)) {
				$key = $search_flip[$current_str];
				$current_str = str_replace($search_arr[$key], $replace_arr[$key], $current_str);
			}
			$strcut .= $current_str;
		}
	}
	return $strcut.$dot;
}



/**
 * 获取请求ip
 *
 * @return ip地址
 */
function ip() {
	if(getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), 'unknown')) {
		$ip = getenv('HTTP_CLIENT_IP');
	} elseif(getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), 'unknown')) {
		$ip = getenv('HTTP_X_FORWARDED_FOR');
	} elseif(getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), 'unknown')) {
		$ip = getenv('REMOTE_ADDR');
	} elseif(isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown')) {
		$ip = $_SERVER['REMOTE_ADDR'];
	}
	return preg_match ( '/[\d\.]{7,15}/', $ip, $matches ) ? $matches [0] : '';
}

function get_cost_time() {
	$microtime = microtime ( TRUE );
	return $microtime - SYS_START_TIME;
}
/**
 * 程序执行时间
 *
 * @return	int	单位ms
 */
function execute_time() {
	$stime = explode ( ' ', SYS_START_TIME );
	$etime = explode ( ' ', microtime () );
	return number_format ( ($etime [1] + $etime [0] - $stime [1] - $stime [0]), 6 );
}

/**
* 产生随机字符串
*
* @param    int        $length  输出长度 
* @param    string     $chars   可选的 ，默认为 0123456789
* @return   string     字符串
*/
function random($length, $chars = '0123456789') {
	$hash = '';
	$max = strlen($chars) - 1;
	for($i = 0; $i < $length; $i++) {
		$hash .= $chars[mt_rand(0, $max)];
	}
	return $hash;
}

/**
* 将字符串转换为数组
*
* @param	string	$data	字符串
* @return	array	返回数组格式，如果，data为空，则返回空数组
*/
function string2array($data) {
	if($data == '') return array();
	eval("\$array = $data;");
	return $array;
}
/**
* 将数组转换为字符串
*
* @param	array	$data		数组
* @param	bool	$isformdata	如果为0，则不使用new_stripslashes处理，可选参数，默认为1
* @return	string	返回字符串，如果，data为空，则返回空
*/
function array2string($data, $isformdata = 1) {
	if($data == '') return '';
	if($isformdata) $data = new_stripslashes($data);
	return addslashes(var_export($data, TRUE));
}

/**
* 转换字节数为其他单位
*
*
* @param	string	$filesize	字节大小
* @return	string	返回大小
*/
function sizecount($filesize) {
	if ($filesize >= 1073741824) {
		$filesize = round($filesize / 1073741824 * 100) / 100 .' GB';
	} elseif ($filesize >= 1048576) {
		$filesize = round($filesize / 1048576 * 100) / 100 .' MB';
	} elseif($filesize >= 1024) {
		$filesize = round($filesize / 1024 * 100) / 100 . ' KB';
	} else {
		$filesize = $filesize.' Bytes';
	}
	return $filesize;
}
/**
* 字符串加密、解密函数
*
*
* @param	string	$txt		字符串
* @param	string	$operation	ENCODE为加密，DECODE为解密，可选参数，默认为ENCODE，
* @param	string	$key		密钥：数字、字母、下划线
* @return	string
*/
function sys_auth($txt, $operation = 'ENCODE', $key = '') {
	
	
	$key	= $key ? $key : inc_base::load_config('system', 'auth_key');
	$txt	= $operation == 'ENCODE' ? (string)$txt : base64_decode($txt);
	$len	= strlen($key);
	$code	= '';
	for($i=0; $i<strlen($txt); $i++){
		$k		= $i % $len;
		$code  .= $txt[$i] ^ $key[$k];
	}
	$code = $operation == 'DECODE' ? $code : base64_encode($code);
	
	
	return $code;
}

/**
* 语言文件处理
*
* @param	string		$language	标示符
* @param	array		$pars	转义的数组,二维数组 ,'key1'=>'value1','key2'=>'value2',
* @param	string		$modules 多个模块之间用半角逗号隔开，如：member,guestbook
* @return	string		语言字符
*/
function L($language = 'no_language',$pars = array(), $modules = '') {
	static $LANG = array();
	static $LANG_MODULES = array();
	static $lang = 'zh-cn';
	$lang = SYS_STYLE ? SYS_STYLE : inc_base::load_config('system','lang');
	
	require_once CORE_PATH.'languages'.DIRECTORY_SEPARATOR.$lang.DIRECTORY_SEPARATOR.'system.lang.php';
	/*if(file_exists(CORE_PATH.'languages'.DIRECTORY_SEPARATOR.$lang.DIRECTORY_SEPARATOR.$modules.'.lang.php')) require CORE_PATH.'languages'.DIRECTORY_SEPARATOR.$lang.DIRECTORY_SEPARATOR.$modules.'.lang.php';*/

	if(!array_key_exists($language,$LANG)) {
		return $LANG['no_language'].'['.$language.']';
	} else {
		$language = $LANG[$language];
		if($pars) {
			foreach($pars AS $_k=>$_v) {
				$language = str_replace('{'.$_k.'}',$_v,$language);
			}
		}
		return $language;
	}
}

/**
 * 模板调用
 * 
 * @param $module
 * @param $template
 * @param $istag
 * @return unknown_type
 */
function template($style,$file) {
	if(empty($file)) return false;
	return INC_PATH.'style'.DIRECTORY_SEPARATOR.$style.DIRECTORY_SEPARATOR.$file.'.tpl.php';
}

/**
 * 模板程序调用
 * 
 * @param $module
 * @param $template
 * @param $istag
 * @return unknown_type
 */
function template_php($file) {
	if(empty($file)) return false;
	return INC_PATH.$file.'.php';
}


/**
 * 输出自定义错误
 * 
 * @param $errno 错误号
 * @param $errstr 错误描述
 * @param $errfile 报错文件地址
 * @param $errline 错误行号
 * @return string 错误提示
 */

function my_error_handler($errno, $errstr, $errfile, $errline) {
	if($errno==8) return '';
	$errfile = str_replace(INC_PATH,'',$errfile);
	if(inc_base::load_config('system','errorlog')) {
		error_log('<?php exit;?>'.date('m-d H:i:s',SYS_TIME).' | '.$errno.' | '.str_pad($errstr,30).' | '.$errfile.' | '.$errline."\r\n", 3, CACHE_PATH.'error_log.php');
	} else {
		$str = '<div style="font-size:12px;text-align:left; border-bottom:1px solid #9cc9e0; border-right:1px solid #9cc9e0;padding:1px 4px;color:#000000;font-family:Arial, Helvetica,sans-serif;"><span>errorno:' . $errno . ',str:' . $errstr . ',file:<font color="blue">' . $errfile . '</font>,line' . $errline .'<br /><a href="http://faq.phpcms.cn/?type=file&errno='.$errno.'&errstr='.urlencode($errstr).'&errfile='.urlencode($errfile).'&errline='.$errline.'" target="_blank" style="color:red">Need Help?</a></span></div>';
		echo $str;
	}
}

/**
 * 提示信息页面跳转，跳转地址如果传入数组，页面会提示多个地址供用户选择，默认跳转地址为数组的第一个值，时间为5秒。
 * showmessage('登录成功', array('默认跳转地址'=>'http://www.es.com'));
 * @param string $msg 提示信息
 * @param mixed(string/array) $url_forward 跳转地址
 * @param int $ms 跳转等待时间
 */
function showmessage($msg, $url_forward = 'goback', $ms = 1250, $go = '', $dialog = '', $returnjs = '') {
	if(defined('IN_ADMIN')) {
		if($ms==0){
			header("location: ".$url_forward);
		}else{
			include(admin::admin_tpl('showmessage'));
		}
	} else {
		
		header("location: ".$url_forward);
		if($ms==0){
			header("location: ".$url_forward);
		}else{
		//include(admin::admin_tpl('showmessage'));
		//include template('showmessage');
		}
	}
	exit;
}

/**
 * 提示信息页面跳转，跳转地址如果传入数组，页面会提示多个地址供用户选择，默认跳转地址为数组的第一个值，时间为5秒。
 * showmessage('登录成功', array('默认跳转地址'=>'http://www.es.com'));
 * @param string $msg 提示信息
 * @param mixed(string/array) $url_forward 跳转地址
 * @param int $ms 跳转等待时间
 */
function showmessage_m($msg, $url_forward = 'goback', $ms = 1250, $go = '', $dialog = '', $returnjs = '') {
	if(defined('IN_ADMIN')) {
		if($ms==0){
			header("location: ".$url_forward);
		}else{
			include(admin_template('showmessage'));
		}
	} else {
		
		header("location: ".$url_forward);
		if($ms==0){
			header("location: ".$url_forward);
		}else{
		//include(admin::admin_tpl('showmessage'));
		//include template('showmessage');
		}
	}
	exit;
}


/**
 * 查询字符是否存在于某字符串
 * 
 * @param $haystack 字符串
 * @param $needle 要查找的字符
 * @return bool
 */
function str_exists($haystack, $needle)
{
	return !(strpos($haystack, $needle) === FALSE);
}

/**
 * 取得文件扩展
 * 
 * @param $filename 文件名
 * @return 扩展名
 */
function fileext($filename) {
	return strtolower(trim(substr(strrchr($filename, '.'), 1, 10)));
}

/**
 * 加载模板标签缓存
 * @param string $name 缓存名
 * @param integer $times 缓存时间
 */
function tpl_cache($name,$times = 0) {
	$filepath = 'tpl_data';
	$info = getcacheinfo($name, $filepath);
	if (SYS_TIME - $info['filemtime'] >= $times) {
		return false;
	} else {
		return getcache($name,$filepath);
	}
}

/**
 * 写入缓存，默认为文件缓存，不加载缓存配置。
 * @param $name 缓存名称
 * @param $data 缓存数据
 * @param $filepath 数据路径（模块名称） caches/cache_$filepath/
 * @param $type 缓存类型[file,memcache,apc]
 * @param $config 配置名称
 * @param $timeout 过期时间
 */
function setcache($name, $data, $filepath='', $type='file', $config='', $timeout=0) {
	inc_base::load_sys_class('cache_factory','',0);
	
	if($config) {
		$cacheconfig = inc_base::load_config('cache');
		$cache = cache_factory::get_instance($cacheconfig)->get_cache($config);
	} else {
		$cache = cache_factory::get_instance()->get_cache($type);
	}

	return $cache->set($name, $data, $timeout, '', $filepath);
}

/**
 * 读取缓存，默认为文件缓存，不加载缓存配置。
 * @param string $name 缓存名称
 * @param $filepath 数据路径（模块名称） caches/cache_$filepath/
 * @param string $config 配置名称
 */
function getcache($name, $filepath='', $type='file', $config='') {
	inc_base::load_sys_class('cache_factory','',0);
	if($config) {
		$cacheconfig = inc_base::load_config('cache');
		$cache = cache_factory::get_instance($cacheconfig)->get_cache($config);
	} else {
		$cache = cache_factory::get_instance()->get_cache($type);
	}
	return $cache->get($name, '', '', $filepath);
}

/**
 * 删除缓存，默认为文件缓存，不加载缓存配置。
 * @param $name 缓存名称
 * @param $filepath 数据路径（模块名称） caches/cache_$filepath/
 * @param $type 缓存类型[file,memcache,apc]
 * @param $config 配置名称
 */
function delcache($name, $filepath='', $type='file', $config='') {
	inc_base::load_sys_class('cache_factory','',0);
	if($config) {
		$cacheconfig = inc_base::load_config('cache');
		$cache = cache_factory::get_instance($cacheconfig)->get_cache($config);
	} else {
		$cache = cache_factory::get_instance()->get_cache($type);
	}
	return $cache->delete($name, '', '', $filepath);
}

/**
 * 读取缓存，默认为文件缓存，不加载缓存配置。
 * @param string $name 缓存名称
 * @param $filepath 数据路径（模块名称） caches/cache_$filepath/
 * @param string $config 配置名称
 */
function getcacheinfo($name, $filepath='', $type='file', $config='') {
	inc_base::load_sys_class('cache_factory');
	if($config) {
		$cacheconfig = inc_base::load_config('cache');
		$cache = cache_factory::get_instance($cacheconfig)->get_cache($config);
	} else {
		$cache = cache_factory::get_instance()->get_cache($type);
	}
	return $cache->cacheinfo($name, '', '', $filepath);
}

/**
 * 生成sql语句，如果传入$in_cloumn 生成格式为 IN('a', 'b', 'c')
 * @param $data 条件数组或者字符串
 * @param $front 连接符
 * @param $in_column 字段名称
 * @return string
 */
function to_sqls($data, $front = ' AND ', $in_column = false) {
	if($in_column && is_array($data)) {
		$ids = '\''.implode('\',\'', $data).'\'';
		$sql = "$in_column IN ($ids)";
		return $sql;
	} else {
		if ($front == '') {
			$front = ' AND ';
		}
		if(is_array($data) && count($data) > 0) {
			$sql = '';
			foreach ($data as $key => $val) {
				$sql .= $sql ? " $front `$key` = '$val' " : " `$key` = '$val' ";	
			}
			return $sql;
		} else {
			return $data;
		}
	}
}

/**
 * 分页函数
 * 
 * @param $num 信息总数
 * @param $curr_page 当前分页
 * @param $perpage 每页显示数
 * @param $urlrule URL规则
 * @param $array 需要传递的数组，用于增加额外的方法
 * @return 分页
 */
function pages($num, $curr_page, $perpage = 20, $urlrule = '', $array = array(),$setpages = 10) {
	
	
	if(defined('URLRULE') && $urlrule == '') {
		$urlrule = URLRULE;
		$array = $GLOBALS['URL_ARRAY'];
		
	} elseif($urlrule == '') {
		$urlrule = url_par('page={$page}');
	
	}

		
	$multipage = '';
	if($num > $perpage) {
		$page = $setpages+1;
		$offset = ceil($setpages/2-1);
		$pages = ceil($num / $perpage);
		if (defined('IN_ADMIN') && !defined('PAGES')) define('PAGES', $pages);
		$from = $curr_page - $offset;
		$to = $curr_page + $offset;
		$more = 0;
		if($page >= $pages) {
			$from = 2;
			$to = $pages-1;
		} else {
			if($from <= 1) {
				$to = $page-1;
				$from = 2;
			}  elseif($to >= $pages) { 
				$from = $pages-($page-2);  
				$to = $pages-1;  
			}
			$more = 1;
		} 
		$multipage .= '<a class="a1">'.$num.L('page_item').'</a>';
		if($curr_page>0) {
			$multipage .= ' <a href="'.pageurl($urlrule, $curr_page-1, $array).'" class="a1">'.L('previous').'</a>';
			if($curr_page==1) {
				$multipage .= ' <span>1</span>';
			} elseif($curr_page>6 && $more) {
				$multipage .= ' <a href="'.pageurl($urlrule, 1, $array).'">1</a>..';
			} else {
				$multipage .= ' <a href="'.pageurl($urlrule, 1, $array).'">1</a>';
			}
		}
		for($i = $from; $i <= $to; $i++) { 
			if($i != $curr_page) { 
				$multipage .= ' <a href="'.pageurl($urlrule, $i, $array).'">'.$i.'</a>'; 
			} else { 
				$multipage .= ' <span>'.$i.'</span>'; 
			} 
		} 
		if($curr_page<$pages) {
			if($curr_page<$pages-5 && $more) {
				$multipage .= ' ..<a href="'.pageurl($urlrule, $pages, $array).'">'.$pages.'</a> <a href="'.pageurl($urlrule, $curr_page+1, $array).'" class="a1">'.L('next').'</a>';
			} else {
				$multipage .= ' <a href="'.pageurl($urlrule, $pages, $array).'">'.$pages.'</a> <a href="'.pageurl($urlrule, $curr_page+1, $array).'" class="a1">'.L('next').'</a>';
			}
		} elseif($curr_page==$pages) {
			$multipage .= ' <span>'.$pages.'</span> <a href="'.pageurl($urlrule, $curr_page, $array).'" class="a1">'.L('next').'</a>';
		} else {
			$multipage .= ' <a href="'.pageurl($urlrule, $pages, $array).'">'.$pages.'</a> <a href="'.pageurl($urlrule, $curr_page+1, $array).'" class="a1">'.L('next').'</a>';
		}
	}
	
	
	
	
	return $multipage;
}


/**
 * 新列表ajax分页函数
 *
 * @param $num 信息总数
 * @param $curr_page 当前分页
 * @param $perpage 每页显示数
 * @param $urlrule URL规则
 * @param $array 需要传递的数组，用于增加额外的方法
 * @return 分页
 */
function ajax_pages($num, $curr_page, $perpage = 20, $urlrule = '', $array = array(),$setpages = 10) {
	
	//print_r($num);
	if(defined('URLRULE') && $urlrule == '') {
		$urlrule = URLRULE;
		$array = $GLOBALS['URL_ARRAY'];
	} elseif($urlrule == '') {
		$urlrule = url_par('page={$page}');
	}

	$multipage = '';
	if($num > $perpage) {
		$page = $setpages+1;
		$offset = ceil($setpages/2-1);
		$pages = ceil($num / $perpage);
		if (defined('IN_ADMIN') && !defined('PAGES')) define('PAGES', $pages);
		$from = $curr_page - $offset;
		$to = $curr_page + $offset;
		$more = 0;
		if($page >= $pages) {
			$from = 2;
			$to = $pages-1;
		} else {
			if($from <= 1) {
				$to = $page-1;
				$from = 2;
			}  elseif($to >= $pages) { 
				$from = $pages-($page-2);  
				$to = $pages-1;  
			}
			$more = 1;
		} 
		$multipage .= '<a class="a1">'.$num.L('page_item').'</a>';
		if($curr_page>0) {
			$multipage .= ' <a href="#pinglun" onClick="ajax_pages('.($curr_page-1).')" class="a1">'.L('previous').'</a>';
			if($curr_page==1) {
				$multipage .= ' <span>1</span>';
			} elseif($curr_page>6 && $more) {
				$multipage .= ' <a href="#pinglun" onClick="ajax_pages(1)">1</a>..';
			} else {
				$multipage .= ' <a href="#pinglun" onClick="ajax_pages(1)">1</a>';
			}
		}
		for($i = $from; $i <= $to; $i++) { 
			if($i != $curr_page) { 
				$multipage .= ' <a href="#pinglun" onClick="ajax_pages('.$i.')">'.$i.'</a>'; 
			} else { 
				$multipage .= ' <span>'.$i.'</span>'; 
			} 
		} 
		if($curr_page<$pages) {
			if($curr_page<$pages-5 && $more) {
				$multipage .= ' ..<a href="#pinglun" onClick="ajax_pages('.$pages.')">'.$pages.'</a> <a href="#pinglun" onClick="ajax_pages('.($curr_page+1).')" class="a1">'.L('next').'</a>';
			} else {
				$multipage .= ' <a href="#pinglun" onClick="ajax_pages('.$pages.')">'.$pages.'</a> <a href="#pinglun" onClick="ajax_pages('.($curr_page+1).')" class="a1">'.L('next').'</a>';
			}
		} elseif($curr_page==$pages) {
			$multipage .= ' <span>'.$pages.'</span> <a href="#pinglun" onClick="ajax_pages('.$curr_page.')" class="a1">'.L('next').'</a>';
		} else {
			$multipage .= ' <a href="#pinglun" onClick="ajax_pages('.$pages.')">'.$pages.'</a> <a href="#pinglun" onClick="ajax_pages('.($curr_page+1).')" class="a1">'.L('next').'</a>';
		}
	}
	return $multipage;
}

/**
 * 列表分页函数
 * 
 * @param $num 信息总数
 * @param $curr_page 当前分页
 * @param $perpage 每页显示数
 * @param $urlrule URL规则
 * @param $array 需要传递的数组，用于增加额外的方法
 * @return 分页
 */
function pages_list($num, $curr_page, $perpage = 20, $urlrule = '', $array = array(),$setpages = 10) {
	if(defined('URLRULE') && $urlrule == '') {
		$urlrule = URLRULE;
		$array = $GLOBALS['URL_ARRAY'];
	} elseif($urlrule == '') {
		$urlrule = url_par('page={$page}');
	
	}
	
	$multipage = '';
	if($num > $perpage) {
		$page = $setpages+1;
		$offset = ceil($setpages/2-1);
		$pages = ceil($num / $perpage);
		if (defined('IN_ADMIN') && !defined('PAGES')) define('PAGES', $pages);
		$from = $curr_page - $offset;
		$to = $curr_page + $offset;
		$more = 0;
		if($page >= $pages) {
			$from = 2;
			$to = $pages-1;
		} else {
			if($from <= 1) {
				$to = $page-1;
				$from = 2;
			}  elseif($to >= $pages) { 
				$from = $pages-($page-2);  
				$to = $pages-1;  
			}
			$more = 1;
		} 
			
	  
	  if($curr_page>0) {
		  if($curr_page==1){
			  $multipage .='<a href="javascript:void(0)" class="pageimg"><img src="'.IMG_PATH.'admin/syy.gif" /></a><a href="javascript:void(0)" class="fy_hover">1</a>';
		  }elseif($curr_page>6 && $more){
			  $multipage .= ' <a href="'.pageurl($urlrule, $curr_page-1, $array).'" class="pageimg"><img src="'.IMG_PATH.'admin/syy_2.gif" /></a><a href="'.pageurl($urlrule, 1, $array).'">1</a><a href="javascript:void(0)">...</a>';
		  }else{
			  $multipage .= '<a href="'.pageurl($urlrule, $curr_page-1, $array).'" class="pageimg"><img src="'.IMG_PATH.'admin/syy_2.gif" /></a> <a href="'.pageurl($urlrule, 1, $array).'">1</a>';	
		  }
	  }
	  for ($i = $from; $i <= $to; $i++){
		  if($i != $curr_page){
			  $multipage .= ' <a href="'.pageurl($urlrule, $i, $array).'">'.$i.'</a>';
		  } else {
			  $multipage .='<a href="javascript:void(0)" class="fy_hover">'.$i.'</a>';
		  }	
	  }
	  if($curr_page<$pages) {
		   if($curr_page<$pages-5 && $more) {
				$multipage .= ' <a href="javascript:void(0)">...</a><a href="'.pageurl($urlrule, $pages, $array).'">'.$pages.'</a> <a href="'.pageurl($urlrule, $curr_page+1, $array).'" class="pageimg"><img src="'.IMG_PATH.'admin/xyy.gif" /></a>';
			} else {
				$multipage .= ' <a href="'.pageurl($urlrule, $pages, $array).'">'.$pages.'</a> <a href="'.pageurl($urlrule, $curr_page+1, $array).'" class="pageimg"><img src="'.IMG_PATH.'admin/xyy.gif" /></a>';
			}
		} elseif($curr_page==$pages) {
			$multipage .= ' <a href="javascript:0" class="fy_hover">'.$pages.'</a> <a href="javascript:void(0)" class="pageimg"><img src="'.IMG_PATH.'admin/xyy_2.gif" /></a>';
		} else {
			$multipage .= ' <a href="'.pageurl($urlrule, $pages, $array).'">'.$pages.'</a> <a href="'.pageurl($urlrule, $curr_page+1, $array).'" class="pageimg"><img src="'.IMG_PATH.'admin/xyy.gif" /></a>';  
	  }
	}
	return $multipage;
}

/**
 * 返回分页路径
 * 
 * @param $urlrule 分页规则
 * @param $page 当前页
 * @param $array 需要传递的数组，用于增加额外的方法
 * @return 完整的URL路径
 */
function pageurl($urlrule, $page, $array = array()) {
	
	/*$urlrule=explode("&",$urlrule);
	$urlrule=$urlrules[0];*/
	
	if(strpos($urlrule, '~')) {
		$urlrules = explode('~', $urlrule);
		$urlrule = $page < 2 ? $urlrules[0] : $urlrules[1];
	}
	

	$findme = array('{$page}');
		
	$replaceme = array($page);
	if (is_array($array)) foreach ($array as $k=>$v) {
		$findme[] = '{$'.$k.'}';
		$replaceme[] = $v;
	}
	
	
	$url = str_replace($findme, $replaceme, $urlrule);
	$url = str_replace(array('http://','//','~'), array('~','/','http://'), $url);
	
	
	return $url;
}


/**
 * 新列表分页函数
 *
 * @param $num 信息总数
 * @param $curr_page 当前分页
 * @param $perpage 每页显示数
 * @param $urlrule URL规则
 * @param $array 需要传递的数组，用于增加额外的方法
 * @return 分页
 */
function newpages($num, $curr_page, $perpage = 20, $urlrule = '', $array = array(),$setpages = 10,$url_html) {
	
	if(defined('URLRULE') && $urlrule == '') {
		$urlrule = URLRULE;
		$array = $GLOBALS['URL_ARRAY'];
	} elseif($urlrule == '') {
		$urlrule = url_par('page={$page}');
	}

	$multipage = '';
	if($num > $perpage) {
		$page = $setpages+1;
		$offset = ceil($setpages/2-1);
		$pages = ceil($num / $perpage);
		if (defined('IN_ADMIN') && !defined('PAGES')) define('PAGES', $pages);
		$from = $curr_page - $offset;
		$to = $curr_page + $offset;
		$more = 0;
		if($page >= $pages) {
			$from = 2;
			$to = $pages-1;
		} else {
			if($from <= 1) {
				$to = $page-1;
				$from = 2;
			}  elseif($to >= $pages) { 
				$from = $pages-($page-2);  
				$to = $pages-1;  
			}
			$more = 1;
		} 
		$multipage .= '<a class="a1">'.$num.L('page_item').'</a>';
		if($curr_page>0) {
			$multipage .= ' <a href="'.newpageurl($urlrule, $curr_page-1, $array,$url_html).'" class="a1">'.L('previous').'</a>';
			if($curr_page==1) {
				$multipage .= ' <span>1</span>';
			} elseif($curr_page>6 && $more) {
				$multipage .= ' <a href="'.newpageurl($urlrule, 1, $array,$url_html).'">1</a>..';
			} else {
				$multipage .= ' <a href="'.newpageurl($urlrule, 1, $array,$url_html).'">1</a>';
			}
		}
		for($i = $from; $i <= $to; $i++) { 
			if($i != $curr_page) { 
				$multipage .= ' <a href="'.newpageurl($urlrule, $i, $array,$url_html).'">'.$i.'</a>'; 
			} else { 
				$multipage .= ' <span>'.$i.'</span>'; 
			} 
		} 
		if($curr_page<$pages) {
			if($curr_page<$pages-5 && $more) {
				$multipage .= ' ..<a href="'.newpageurl($urlrule, $pages, $array,$url_html).'">'.$pages.'</a> <a href="'.newpageurl($urlrule, $curr_page+1, $array,$url_html).'" class="a1">'.L('next').'</a>';
			} else {
				$multipage .= ' <a href="'.newpageurl($urlrule, $pages, $array,$url_html).'">'.$pages.'</a> <a href="'.newpageurl($urlrule, $curr_page+1, $array,$url_html).'" class="a1">'.L('next').'</a>';
			}
		} elseif($curr_page==$pages) {
			$multipage .= ' <span>'.$pages.'</span> <a href="'.newpageurl($urlrule, $curr_page, $array,$url_html).'" class="a1">'.L('next').'</a>';
		} else {
			$multipage .= ' <a href="'.newpageurl($urlrule, $pages, $array,$url_html).'">'.$pages.'</a> <a href="'.newpageurl($urlrule, $curr_page+1, $array,$url_html).'" class="a1">'.L('next').'</a>';
		}
	}
	return $multipage;
}

/**
 * 返回分页路径
 *
 * @param $urlrule 分页规则
 * @param $page 当前页
 * @param $array 需要传递的数组，用于增加额外的方法
 * @return 完整的URL路径
 */
function newpageurl($urlrule, $page, $array = array(),$url_html) {
	
	$array2=$array;
	if(strpos($urlrule, '~')) {
		$urlrules = explode('~', $urlrule);
		$urlrule = $page < 2 ? $urlrules[0] : $urlrules[1];
	}
	
	$findme = array('{$page}');
	$replaceme = array($page);
	if (is_array($array)) foreach ($array as $k=>$v) {
		$findme[] = '{$'.$k.'}';
		$replaceme[] = $v;
	}
	$url = str_replace($findme, $replaceme, $urlrule);
	$url = str_replace(array('http://','//','~'), array('~','/','http://'), $url);
	
	//说明  $url_html 为自定义静态参数   $array2 为前台分页传过来的数组  $replaceme[0] 应该为页数
	
	if($url_html=='rain'){
	
	if($array2[0]){
		
		$url = APP_PATH.'rain/'.$array2[0].'-'.$replaceme[0].'.html';	 	
		
	}else{
		
		$url = APP_PATH.'rain-'.$replaceme[0].'.html';	 
	}
	}
	
	
	if($url_html=='photo_list'){
	
	if($array2[0]){
		
		$url = APP_PATH.'photo_list/'.$array2[0].'-'.$replaceme[0].'.html';	 	
		
	}else{
		
		$url = APP_PATH.'photo_list-'.$replaceme[0].'.html';	 
	}
	}
	
	
	
	return $url;
}






/**
 * 返回分页路径
 *
 * @param $urlrule 分页规则
 * @param $page 当前页
 * @param $array 需要传递的数组，用于增加额外的方法
 * @return 完整的URL路径
 */
function ajax_pageurl($urlrule, $page, $array = array(),$url_html) {
	
/*	$array2=$array;
	if(strpos($urlrule, '~')) {
		$urlrules = explode('~', $urlrule);
		$urlrule = $page < 2 ? $urlrules[0] : $urlrules[1];
	}
	
	$findme = array('{$page}');
	$replaceme = array($page);
	if (is_array($array)) foreach ($array as $k=>$v) {
		$findme[] = '{$'.$k.'}';
		$replaceme[] = $v;
	}
	$url = str_replace($findme, $replaceme, $urlrule);
	$url = str_replace(array('http://','//','~'), array('~','/','http://'), $url);
	
	if($url_html=='ceshi'){
		$url = APP_PATH.'product/ceshi-'.$array2[0].'-'.$array2[1].'-'.$replaceme[0].'.html';	 
	}elseif($url_html=='expence_list'){
		$url = APP_PATH.'member/pay/expence_list_'.$replaceme[0].'.html';	
	}else{
		$url = APP_PATH.'news/index_'.$replaceme[1].'_'.$replaceme[0].'.html';
	}
	return $url;*/
}

/**
 * URL路径解析，pages 函数的辅助函数
 *
 * @param $par 传入需要解析的变量 默认为，page={$page}
 * @param $url URL地址
 * @return URL
 */
function url_par($par, $url = '') {
	
	
	if($url == '') $url = get_url();
	
	$pos = strpos($url, '?');
	
	if($pos === false) {
		$url .= '?'.$par;
	} else {
		$querystring = substr(strstr($url, '?'), 1);
		parse_str($querystring, $pars);
		$query_array = array();
	
		foreach($pars as $k=>$v) {
			$query_array[$k] = $v;
		}
		unset($query_array['page']);//分页BUG 不知道为什么
	$http_build_query=	http_build_query($query_array);
		/*	//print_r($http_build_query);
		//die;
		$aa=explode('&',$http_build_query);*/
		$querystring = $http_build_query.'&'.$par;
		$url = substr($url, 0, $pos).'?'.$querystring;
		
	}
	return $url;
}



/**
 * iconv 编辑转换
 */
if (!function_exists('iconv')) {
	function iconv($in_charset, $out_charset, $str) {
		$in_charset = strtoupper($in_charset);
		$out_charset = strtoupper($out_charset);
		if (function_exists('mb_convert_encoding')) {
			return mb_convert_encoding($str, $out_charset, $in_charset);
		} else {
			inc_base::load_sys_func('iconv');
			$in_charset = strtoupper($in_charset);
			$out_charset = strtoupper($out_charset);
			if ($in_charset == 'UTF-8' && ($out_charset == 'GBK' || $out_charset == 'GB2312')) {
				return utf8_to_gbk($str);
			}
			if (($in_charset == 'GBK' || $in_charset == 'GB2312') && $out_charset == 'UTF-8') {
				return gbk_to_utf8($str);
			}
			return $str;
		}
	}
}






/**
 * 联动菜单层级
 */

function menu_linkage_level($linkageid,$keyid,$infos,$result=array()) {
	if(array_key_exists($linkageid,$infos)) {
		$result[]=$infos[$linkageid]['name'];
		return menu_linkage_level($infos[$linkageid]['parentid'],$keyid,$infos,$result);
	}
	krsort($result);
	return implode(' > ',$result);
}
/**
 * 通过catid获取显示菜单完整结构
 * @param  $menuid 菜单ID
 * @param  $cache_file 菜单缓存文件名称
 * @param  $cache_path 缓存文件目录
 * @param  $key 取得缓存值的键值名称
 * @param  $parentkey 父级的ID
 * @param  $linkstring 链接字符
 */
function menu_level($menuid, $cache_file, $cache_path = 'commons', $key = 'catname', $parentkey = 'parentid', $linkstring = ' > ', $result=array()) {
	$menu_arr = getcache($cache_file, $cache_path);
	if (array_key_exists($menuid, $menu_arr)) {
		$result[] = $menu_arr[$menuid][$key];
		return menu_level($menu_arr[$menuid][$parentkey], $cache_file, $cache_path, $key, $parentkey, $linkstring, $result);
	}
	krsort($result);
	return implode($linkstring, $result);
}
/**
 * 通过id获取显示联动菜单
 * @param  $linkageid 联动菜单ID
 * @param  $keyid 菜单keyid
 * @param  $space 菜单间隔符
 * @param  $tyoe 1 返回间隔符链接，完整路径名称 3 返回完整路径数组，2返回当前联动菜单名称，4 直接返回ID
 * @param  $result 递归使用字段1
 * @param  $infos 递归使用字段2
 */
function get_linkage($linkageid, $keyid, $space = '>', $type = 1, $result = array(), $infos = array()) {
	if($space=='' || !isset($space))$space = '>';
	if(!$infos) {
		$datas = getcache($keyid,'linkage');
		$infos = $datas['data'];
	}
	if($type == 1 || $type == 3 || $type == 4) {
		if(array_key_exists($linkageid,$infos)) {
			$result[]= ($type == 1) ? $infos[$linkageid]['name'] : (($type == 4) ? $linkageid :$infos[$linkageid]);
			return get_linkage($infos[$linkageid]['parentid'], $keyid, $space, $type, $result, $infos);
		} else {
			if(count($result)>0) {
				krsort($result);
				if($type == 1 || $type == 4) $result = implode($space,$result);
				return $result;
			} else {
				return $result;
			}
		}
	} else {
		return $infos[$linkageid]['name'];
	}			
}
/**
 * IE浏览器判断
 */

function is_ie() {
	$useragent = strtolower($_SERVER['HTTP_USER_AGENT']);
	if((strpos($useragent, 'opera') !== false) || (strpos($useragent, 'konqueror') !== false)) return false;
	if(strpos($useragent, 'msie ') !== false) return true;
	return false;
}


/**
 * 文件下载
 * @param $filepath 文件路径
 * @param $filename 文件名称
 */

function file_down($filepath, $filename = '') {
	if(!$filename) $filename = basename($filepath);
	if(is_ie()) $filename = rawurlencode($filename);
	$filetype = fileext($filename);
	$filesize = sprintf("%u", filesize($filepath));
	if(ob_get_length() !== false) @ob_end_clean();
	header('Pragma: public');
	header('Last-Modified: '.gmdate('D, d M Y H:i:s') . ' GMT');
	header('Cache-Control: no-store, no-cache, must-revalidate');
	header('Cache-Control: pre-check=0, post-check=0, max-age=0');
	header('Content-Transfer-Encoding: binary');
	header('Content-Encoding: none');
	header('Content-type: '.$filetype);
	header('Content-Disposition: attachment; filename="'.$filename.'"');
	header('Content-length: '.$filesize);
	readfile($filepath);
	exit;
}

/**
 * 判断字符串是否为utf8编码，英文和半角字符返回ture
 * @param $string
 * @return bool
 */
function is_utf8($string) {
	return preg_match('%^(?:
					[\x09\x0A\x0D\x20-\x7E] # ASCII
					| [\xC2-\xDF][\x80-\xBF] # non-overlong 2-byte
					| \xE0[\xA0-\xBF][\x80-\xBF] # excluding overlongs
					| [\xE1-\xEC\xEE\xEF][\x80-\xBF]{2} # straight 3-byte
					| \xED[\x80-\x9F][\x80-\xBF] # excluding surrogates
					| \xF0[\x90-\xBF][\x80-\xBF]{2} # planes 1-3
					| [\xF1-\xF3][\x80-\xBF]{3} # planes 4-15
					| \xF4[\x80-\x8F][\x80-\xBF]{2} # plane 16
					)*$%xs', $string);
}

/**
 * 组装生成ID号
 * @param $modules 模块名
 * @param $contentid 内容ID
 * @param $siteid 站点ID
 */
function id_encode($modules,$contentid, $siteid) {
	return urlencode($modules.'-'.$contentid.'-'.$siteid);
}

/**
 * 解析ID
 * @param $id 评论ID
 */
function id_decode($id) {
	return explode('-', $id);
}

/**
 * 对用户的密码进行加密
 * @param $password
 * @param $encrypt //传入加密串，在修改密码时做认证
 * @return array/password
 */
function password($password, $encrypt='') {
	$pwd = array();
	$pwd['encrypt'] =  $encrypt ? $encrypt : create_randomstr();	
	$pwd['password'] = md5(md5(trim($password)).$pwd['encrypt']);
	return $encrypt ? $pwd['password'] : $pwd;
}
/**
 * 生成随机字符串
 * @param string $lenth 长度
 * @return string 字符串
 */
function create_randomstr($lenth = 6) {
	return random($lenth, '123456789abcdefghijklmnpqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ');
}

/**
 * 检查密码长度是否符合规定
 *
 * @param STRING $password
 * @return 	TRUE or FALSE
 */
function is_password($password) {
	$strlen = strlen($password);
	if($strlen >= 6 && $strlen <= 20) return true;
	return false;
}

 /**
 * 检测输入中是否含有错误字符
 *
 * @param char $string 要检查的字符串名称
 * @return TRUE or FALSE
 */
function is_badword($string) {
	$badwords = array("\\",'&',' ',"'",'"','/','*',',','<','>',"\r","\t","\n","#");
	foreach($badwords as $value){
		if(strpos($string, $value) !== FALSE) {
			return TRUE;
		}
	}
	return FALSE;
}



/**
 * 检查id是否存在于数组中
 * 
 * @param $id
 * @param $ids
 * @param $s
 */
function check_in($id, $ids = '', $s = ',') {
	if(!$ids) return false;
	$ids = explode($s, $ids);
	return is_array($id) ? array_intersect($id, $ids) : in_array($id, $ids);
}

/**
 * 对数据进行编码转换
 * @param array/string $data       数组
 * @param string $input     需要转换的编码
 * @param string $output    转换后的编码
 */
function array_iconv($data, $input = 'gbk', $output = 'utf-8') {
	if (!is_array($data)) {
		return iconv($input, $output, $data);
	} else {
		foreach ($data as $key=>$val) {
			if(is_array($val)) {
				$data[$key] = array_iconv($val, $input, $output);
			} else {
				$data[$key] = iconv($input, $output, $val);
			}
		}
		return $data;
	}
}

/**
 * 生成缩略图函数
 * @param  $imgurl 图片路径
 * @param  $width  缩略图宽度
 * @param  $height 缩略图高度
 * @param  $autocut 是否自动裁剪 默认裁剪，当高度或宽度有一个数值为0是，自动关闭
 * @param  $smallpic 无图片是默认图片路径
 */
function thumb($imgurl, $width = 100, $height = 100 ,$autocut = 1, $smallpic = 'nopic.gif',$c_cut) {
	global $image;
	$upload_url = inc_base::load_config('system','upload_url');
	$upload_path = inc_base::load_config('system','upload_path');		
	if(empty($imgurl)) return IMG_PATH.$smallpic;
	$imgurl_replace= str_replace($upload_url, '', $imgurl);		
	if(!extension_loaded('gd') || strpos($imgurl_replace, '://')) return $imgurl;
	if(!file_exists($upload_path.$imgurl_replace)) return IMG_PATH.$smallpic;
	
	list($width_t, $height_t, $type, $attr) = getimagesize($upload_path.$imgurl_replace);
	if($width>=$width_t || $height>=$height_t) return $imgurl;
	
	$newimgurl = dirname($imgurl_replace).'/thumb_'.$width.'_'.$height.'_'.basename($imgurl_replace);
	
	if(file_exists($upload_path.$newimgurl)) return $upload_url.$newimgurl;
	
	if(!is_object($image)) {
		inc_base::load_sys_class('image','','0');
		$image = new image(1,0);
	}
	return $image->thumb($upload_path.$imgurl_replace, $upload_path.$newimgurl, $width, $height, '', $autocut,'',$c_cut) ? $upload_url.$newimgurl : $imgurl;
}

/**
 * 水印添加
 * @param $source 原图片路径
 * @param $target 生成水印图片途径，默认为空，覆盖原图
 * @param $siteid 站点id，系统需根据站点id获取水印信息
 */
function watermark($source, $target = '',$siteid) {
	global $image_w;
	if(empty($source)) return $source;
	if(!extension_loaded('gd') || strpos($source, '://')) return $source;
	if(!$target) $target = $source;
	if(!is_object($image_w)){
		inc_base::load_sys_class('image','','0');
		$image_w = new image(0,$siteid);
	}
		$image_w->watermark($source, $target);
	return $target;
}




/**
 * 将附件地址转换为绝对地址
 * @param $path 附件地址
 */
function atturl($path) {
	if(strpos($path, ':/')) {
		return $path;
	} else {
		$sitelist = getcache('sitelist','commons');
		$siteid =  get_siteid();
		$siteurl = $sitelist[$siteid]['domain'];
		$domainlen = strlen($sitelist[$siteid]['domain'])-1;
		$path = $siteurl.$path;
		$path = substr_replace($path, '/', strpos($path, '//',$domainlen),2);
		return 	$path;
	}
}

/**
 * 判断模块是否安装
 * @param $m	模块名称
 */
function module_exists($m = '') {
	if ($m=='admin') return true;
	$modules = getcache('modules', 'commons');
	$modules = array_keys($modules);
	return in_array($m, $modules);
}

/**
 * 生成SEO
 * @param $siteid       站点ID
 * @param $catid        栏目ID
 * @param $title        标题
 * @param $description  描述
 * @param $keyword      关键词
 */
function seo($siteid, $catid = '', $title = '', $description = '', $keyword = '') {
	if (!empty($title))$title = strip_tags($title);
	if (!empty($description)) $description = strip_tags($description);
	if (!empty($keyword)) $keyword = str_replace(' ', ',', strip_tags($keyword));
	$sites = getcache('sitelist', 'commons');
	$site = $sites[$siteid];
	$cat = array();
	if (!empty($catid)) {
		$siteids = getcache('category_content','commons');
		$siteid = $siteids[$catid];
		$categorys = getcache('category_content_'.$siteid,'commons');
		$cat = $categorys[$catid];
		$cat['setting'] = string2array($cat['setting']);
	}
	$seo['site_title'] =isset($site['site_title']) && !empty($site['site_title']) ? $site['site_title'] : $site['name'];
	$seo['keyword'] = !empty($keyword) ? $keyword : $site['keywords'];
	$seo['description'] = isset($description) && !empty($description) ? $description : (isset($cat['setting']['meta_description']) && !empty($cat['setting']['meta_description']) ? $cat['setting']['meta_description'] : (isset($site['description']) && !empty($site['description']) ? $site['description'] : ''));
	$seo['title'] =  (isset($title) && !empty($title) ? $title.' - ' : '').(isset($cat['setting']['meta_title']) && !empty($cat['setting']['meta_title']) ? $cat['setting']['meta_title'].' - ' : (isset($cat['catname']) && !empty($cat['catname']) ? $cat['catname'].' - ' : ''));
	foreach ($seo as $k=>$v) {
		$seo[$k] = str_replace(array("\n","\r"),	'', $v);
	}
	return $seo;
}

/**
 * 获取站点的信息
 * @param $siteid   站点ID
 */
function siteinfo($siteid) {
	static $sitelist;
	if (empty($sitelist)) $sitelist  = getcache('sitelist','commons');
	return isset($sitelist[$siteid]) ? $sitelist[$siteid] : '';
}



/**
 * 生成标题样式
 * @param $style   样式
 * @param $html    是否显示完整的STYLE
 */
function title_style($style, $html = 1) {
	$str = '';
	if ($html) $str = ' style="';
	$style_arr = explode(';',$style);
	if (!empty($style_arr[0])) $str .= 'color:'.$style_arr[0].';';
	if (!empty($style_arr[1])) $str .= 'font-weight:'.$style_arr[1].';';
	if ($html) $str .= '" ';
	return $str;
}

/**
 * 获取站点域名
 * @param $siteid   站点id
 */
function siteurl($siteid) {
	static $sitelist;
	if(!$siteid) return WEB_PATH;
	if(empty($sitelist)) $sitelist = getcache('sitelist','commons');
	return substr($sitelist[$siteid]['domain'],0,-1);
}
/**
 * 生成上传附件验证
 * @param $args   参数
 * @param $operation   操作类型(加密解密)
 */

function upload_key($args, $operation = 'ENCODE') {
	$pc_auth_key = md5(inc_base::load_config('system','auth_key').$_SERVER['HTTP_USER_AGENT']);
	$authkey = sys_auth($args, $operation, $pc_auth_key);
	return $authkey;
}

/**
 * 文本转换为图片
 * @param string $txt 图形化文本内容
 * @param int $fonttype 无外部字体时生成文字大小，取值范围1-5
 * @param int $fontsize 引入外部字体时，字体大小
 * @param string $font 字体名称 字体请放于phpcms\libs\data\font下
 * @param string $fontcolor 字体颜色 十六进制形式 如FFFFFF,FF0000
 */
function string2img($txt, $fonttype = 5, $fontsize = 16, $font = '', $fontcolor = 'FF0000',$transparent = '1') {
	if(empty($txt)) return false;
	if(function_exists("imagepng")) {
		$txt = urlencode(sys_auth($txt));
		$txt = '<img src="'.APP_PATH.'api.php?op=creatimg&txt='.$txt.'&fonttype='.$fonttype.'&fontsize='.$fontsize.'&font='.$font.'&fontcolor='.$fontcolor.'&transparent='.$transparent.'" align="absmiddle">';
	}
	return $txt;
}

/**
 * 获取版本号
 */
function get_version($type='') {
	$version = inc_base::load_config('version');
	if($type==1) {
		return $version['pc_version'];
	} elseif($type==2) {
		return $version['pc_release'];
	} else {
		return $version['pc_version'].' '.$version['pc_release'];
	}
}
/**
 * 运行钩子（插件使用）
 */
function runhook($method) {
	$time_start = getmicrotime();
	$data  = '';
	$getpclass = FALSE;
	$hook_appid = getcache('hook','plugins');
	if(!empty($hook_appid)) {
		foreach($hook_appid as $appid => $p) {
			$pluginfilepath = CORE_PATH.'plugin'.DIRECTORY_SEPARATOR.$p.DIRECTORY_SEPARATOR.'hook.class.php';
			$getpclass = TRUE;		
			include_once $pluginfilepath;
		}
		$hook_appid = array_flip($hook_appid);
		if($getpclass) {
			$pclass = new ReflectionClass('hook'); 
			foreach($pclass->getMethods() as $r) {
				$legalmethods[] = $r->getName(); 
			}
		}
		if(in_array($method,$legalmethods)) {
			foreach (get_declared_classes() as $class){
			   $refclass = new ReflectionClass($class);
			   if($refclass->isSubclassOf('hook')){
				  if ($_method = $refclass->getMethod($method)) {
						  $classname = $refclass->getName();
						if ($_method->isPublic() && $_method->isFinal()) {			
							plugin_stat($hook_appid[$classname]);
							$data .= $_method->invoke(null);						
						}
					}
			   }
			}
		}
		return $data;
	}
}

function getmicrotime() {
	list($usec, $sec) = explode(" ",microtime()); 
	return ((float)$usec + (float)$sec); 
}
 
/**
 * 插件前台模板加载
 * Enter description here ...
 * @param unknown_type $module
 * @param unknown_type $template
 * @param unknown_type $style
 */
function p_template($plugin = 'content', $template = 'index',$style='default') {
	if(!$style) $style = 'default';
	$template_cache = inc_base::load_sys_class('template_cache');
	$compiledtplfile = INC_PATH.'caches'.DIRECTORY_SEPARATOR.'caches_template'.DIRECTORY_SEPARATOR.$style.DIRECTORY_SEPARATOR.'plugin'.DIRECTORY_SEPARATOR.$plugin.DIRECTORY_SEPARATOR.$template.'.php';

	if(!file_exists($compiledtplfile) || (file_exists(CORE_PATH.'plugin'.DIRECTORY_SEPARATOR.$plugin.DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.$template.'.html') && filemtime(CORE_PATH.'plugin'.DIRECTORY_SEPARATOR.$plugin.DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.$template.'.html') > filemtime($compiledtplfile))) {
		$template_cache->template_compile('plugin/'.$plugin, $template, 'default');
	} elseif (!file_exists(CORE_PATH.'plugin'.DIRECTORY_SEPARATOR.$plugin.DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.$template.'.html')) {
		showmessage('Template does not exist.'.DIRECTORY_SEPARATOR.'plugin'.DIRECTORY_SEPARATOR.$plugin.DIRECTORY_SEPARATOR.$template.'.html');
	}

	return $compiledtplfile;
}
/**
 * 读取缓存动态页面
 */
function cache_page_start() {
	$relate_url = isset($_SERVER['REQUEST_URI']) ? safe_replace($_SERVER['REQUEST_URI']) : $php_self.(isset($_SERVER['QUERY_STRING']) ? '?'.safe_replace($_SERVER['QUERY_STRING']) : $path_info);
	define('CACHE_PAGE_ID', md5($relate_url));
	$contents = getcache(CACHE_PAGE_ID, 'page_tmp/'.substr(CACHE_PAGE_ID, 0, 2));
	if($contents && intval(substr($contents, 15, 10)) > SYS_TIME) {
		echo substr($contents, 29);
		exit;
	}
	if (!defined('HTML')) define('HTML',true);
	return true;
}
/**
 * 写入缓存动态页面
 */
function cache_page($ttl = 360, $isjs = 0) {
	if($ttl == 0 || !defined('CACHE_PAGE_ID')) return false;
	$contents = ob_get_contents();
	
	if($isjs) $contents = format_js($contents);
	$contents = "<!--expiretime:".(SYS_TIME + $ttl)."-->\n".$contents;
	setcache(CACHE_PAGE_ID, $contents, 'page_tmp/'.substr(CACHE_PAGE_ID, 0, 2));
}
/**
 * 数据库多表前后缀处理
 */
function pre($table) {
	$table = 'pre_'.trim($table).'_suf';
	return $table;
}

/**
 * 图片全路径
 */
function imgurl($url) {
	$upload_root = inc_base::load_config('system','upload_url');
	$imgfile = $upload_root.$url;
	return $imgfile;
}




/*写文件*/
function write_file($filename,$data,$method="rb+",$iflock=1){
	@touch($filename);
	$handle=@fopen($filename,$method);
	if($iflock){
		@flock($handle,LOCK_EX);
	}
	@fputs($handle,$data);
	if($method=="rb+") @ftruncate($handle,strlen($data));
	@fclose($handle);
	@chmod($filename,0777);	
	if( is_writable($filename) ){
		return 1;
	}else{
		return 0;
	}
}
?>