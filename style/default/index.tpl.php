<?php
defined('IN_CORE') or exit('File does not exist.');
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
       

  </div>
  <div class="col-right">
  
  </div>
    
</div>


    



<?php include template('default','footer');?>

