<?php
/* $Id: extention.func.php 用户自定义函数库 2014-04-10 沙加 $ */
/* @Copyright 2012 EaseMany  */
 
 
  

 
 function get_catname222($catid){
	 
	 $category_db = inc_base::load_model('category_model');
	 
	 $aaa= $category_db->get_one(array('catid'=>$catid));
	 
	 
	 return $aaa['catname'];
	 
}

?>