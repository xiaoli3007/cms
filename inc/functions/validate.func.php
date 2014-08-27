<?php

/**
 * 手机验证
 * 
 * @param $module
 * @param $template
 * @param $istag
 * @return unknown_type
 */
function is_mobile($mobile) {
	if($mobile!=""){
			if(!preg_match('/^1([0-9]{9})/',$mobile)) {
				return 0;
			}else{
				return 1;
			}
		}else{
			return 0;
		} 	
}


/**
 * 判断email格式是否正确
 * @param $email
 */
function is_email($email) {
	return strlen($email) > 6 && preg_match("/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/", $email);
}


/**
 * 检查用户名是否符合规定
 *
 * @param STRING $username 要检查的用户名
 * @return 	TRUE or FALSE
 */
function is_username($username) {
	$strlen = strlen($username);
	if(is_badword($username) || !preg_match("/^[a-zA-Z0-9_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]+$/", $username)){
		return false;
	} elseif ( 20 <= $strlen || $strlen < 2 ) {
		return false;
	}
	return true;
}




?>