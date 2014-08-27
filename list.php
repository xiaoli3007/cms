<?php
if(!defined('IN_ADMIN')){
require dirname(__FILE__).DIRECTORY_SEPARATOR."inc".DIRECTORY_SEPARATOR."common.php";
exit('File does not exist.');
}


$news_db = inc_base::load_model('news_model');
$category_db = inc_base::load_model('category_model');



$is_sub=$category_db->select(array('parentid'=>$catid));
$cc_info=$category_db->get_one(array('catid'=>$catid));



$seo_title = $cc_info['title'];
$seo_keywords = $cc_info['keywords'];
$seo_description = $cc_info['description'];



if(!$cc_info['parentid']){
	 $is_sub_right=$category_db->select(array('parentid'=>$catid));	
 
}else{
	
	$is_sub_right=$category_db->select(array('parentid'=>$cc_info['parentid']));
}


if($is_sub){
	foreach($is_sub as $v){
	$bb[]= $v['catid'];
	}
	$catidsun=implode(',',$bb);
	$catidsun.=','.$catid;
	$where="`catid` in ($catidsun) ";
}else{
	$where="`catid` = $catid";
}


//$where="`catid` = $catid";
$datas = $news_db->listinfo($where,'id desc',$page,$pagesize);

$total=$news_db->count($where);
$pages = $news_db->pages;


include template('default','list');

?>