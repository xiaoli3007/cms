<?php
if(!defined('IN_ADMIN')){
require dirname(__FILE__).DIRECTORY_SEPARATOR."inc".DIRECTORY_SEPARATOR."common.php";
}

$news_db = inc_base::load_model('news_model');
$category_db = inc_base::load_model('category_model');



$where="1 ";


$seo_title = $cc_info['title'];
$seo_keywords = $cc_info['keywords'];
$seo_description = $cc_info['description'];



//$where="`catid` = $catid";
$datas = $news_db->select($where,'*',10,'id desc');




include template('default','index');

?>