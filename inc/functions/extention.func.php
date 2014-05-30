<?php
/* $Id: extention.func.php 用户自定义函数库 2014-04-10 沙加 $ */
/* @Copyright 2012 EaseMany  */
 
 
  
 function ecs_iconv($source_lang, $target_lang, $source_string = '')
{
    static $chs = NULL;

    /* 如果字符串为空或者字符串不需要转换，直接返回 */
    if ($source_lang == $target_lang || $source_string == '' || preg_match("/[\x80-\xFF]+/", $source_string) == 0)
    {
        return $source_string;
    }

    if ($chs === NULL)
    {
       inc_base::load_sys_class('excel', '', 0);
        $chs = new Chinese();
    }

    return $chs->Convert($source_lang, $target_lang, $source_string);
}

 
 function get_catname($catid){
	 
	 $category_db = inc_base::load_model('category_model');
	 
	 $aaa= $category_db->get_one(array('catid'=>$catid));
	 
	 
	 return $aaa['catname'];
	 
}



/**
 * 模板调用
 * 
 * @param $module
 * @param $template
 * @param $istag
 * @return unknown_type
 */
function template_m($m,$file) {
	if(empty($m)) return false;
	return INC_PATH.'modules'.DIRECTORY_SEPARATOR.$m.DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.$file.'.tpl.php';
}


/**
 * 模板调用 后台系统模版
 * 
 * @param $module
 * @param $template
 * @param $istag
 * @return unknown_type
 */
function admin_template($file) {
	if(empty($file)) return false;
	return INC_PATH.'s_admin'.DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.$file.'.tpl.php';
}




?>