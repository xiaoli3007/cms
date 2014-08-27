<?php defined('IN_CORE') or exit('File does not exist.');

$category_db = inc_base::load_model('category_model');
$nav=$category_db->select(array('parentid'=>0));
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET;?>" />
<title><?php echo $seo_title;?></title>
<link rel="shortcut icon" href="favicon.ico" />
<LINK href="favicon.ico" type="image/x-icon" rel=icon>
<meta name="keywords" content="<?php echo $seo_keywords;?>" />
<meta name="description" content="<?php echo $seo_description;?>"/>

<link rel="stylesheet" type="text/css" href="<?php echo CSS_PATH;?>public.css">



</head>

<body>

<div class="header">
 <h3>单色</h3>
 <?php //print_r($catid);exit;?>
 <div class="nav">
	<ul>
    	
        <li <?php if(!$catid){?>class="dq" <?php }?>><a href="/">最新</a></li>
        <?php foreach($nav as $v){?>
        <li <?php if($v['catid']==$catid  ){?>class="dq" <?php }?>><a href="/html/<?php echo $v['cat_dir'];?>/"><?php echo $v['catname'];?></a></li>
       <?php }?>
    
    </ul>

</div>

</div>

