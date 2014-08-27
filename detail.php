<?php
if(!defined('IN_ADMIN')){
require dirname(__FILE__).DIRECTORY_SEPARATOR."inc".DIRECTORY_SEPARATOR."common.php";
exit('File does not exist.');
}

$news_db = inc_base::load_model('news_model');
$news_data_db = inc_base::load_model('news_data_model');

//$id = $id ? $id : intval($_GET['id']);	

$r1 = $news_db->get_one(array('id'=>$id));
$r2 = $news_data_db->get_one(array('id'=>$id));
$r = $r2 ? array_merge($r1,$r2) : $r1;


$category_db = inc_base::load_model('category_model');


$fenlei_seo=$category_db->get_one(array('catid'=>$r['catid']));


extract($r);

$seo_title = $title.$fenlei_seo['title'];
$seo_keywords = $fenlei_seo['keywords'];
$seo_description = $fenlei_seo['description'];


include template('default','detail');

?>