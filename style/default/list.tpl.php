<?php defined('IN_CORE') or exit('File does not exist.');
include template('default','header');?>

<!--main-->
<div class="main">
	<div class="col-left">
    	
    	
        <ul class="list">
<?php foreach($datas as $r){?>
	<li><a href="<?php echo $r[html_url];?>" ><?php echo $r[title];?></a>
    <span class="rt"><?php echo date('Y-m-d H:i:s',$r[inputtime]);?></span>
    </li>
	
    <?php }?>
        </ul>
        <div id="pages" class="text-c"><?=$pages?></div>

  </div>
  <div class="col-right">
  	<ul>
    <?php if($is_sub_right){?>
    	  <?php foreach($is_sub_right as $v){?>
        <li <?php if($v['catid']==$catid ){?>class="dq" <?php }?>><a href="/html/<?php echo $v['cat_dir'];?>/"><?php echo $v['catname'];?></a></li>
     
      <?php }}?>
       
       
    </ul>
  </div>
    
</div>

<?php include template('default','footer');?>