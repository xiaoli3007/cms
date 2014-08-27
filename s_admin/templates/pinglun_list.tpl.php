<?php
defined('IN_ADMIN') or exit('File does not exist.');
include $admin->admin_tpl('header');?>




<div class="pad-10">
<div class="content-menu ib-a blue line-x">
　

<div style="float:right; padding-right:20px;">

</div>

</div>


<script type="text/javascript"> 


function confirm_delete1(){
	$('#contenttype').val('delete');
	if(confirm('确认删除吗？')) {
		
		
		$('#myform1').submit();}
}





</script>
<form name="myform1" id="myform1" action="" method="post" >
<div class="table-list">
    <table width="100%">
        <thead>
            <tr>
			 <th width="16"><input type="checkbox" value="" id="check_box" onclick="selectall('ids[]');"></th>
            <th width="40">ID</th>
			<th  width="200">评论的文章</th>
            <th  width="300">评论内容</th>
               <th  width="100">评论人</th>
       		<th width="100">时间</th>
         
            </tr>
        </thead>
<tbody> 
    <?php
	if(is_array($datas)) {

		foreach ($datas as $r) {
		
		$aad=$news_db->get_one(array('id'=>$r['news_id']));
		
		$peopless=$member_db->get_one(array('userid'=>$r['userid']));
	?>
        <tr>
		<td align="center"><input class="inputcheckbox " name="ids[]" value="<?php echo $r['id'];?>" type="checkbox"></td>
		<td align='center' ><?php echo $r['id'];?></td>
        <td><a href="<?php echo APP_PATH.'detail.php?id=';?><?php echo $aad['id']?>/" target="_blank"><?php echo $aad['title'];?></a></td>
           
         <td align='center'><?php echo $r['comment'];?></td>
         
          <td align='center'><?php echo $peopless['nickname'];?></td>
           
		<td align='center'><?php echo date('Y-m-d H:i:s',$r['dates']);?></td>
              
	</tr>
     <?php }
	}
	?>
</tbody>
     </table>
    <div class="btn">
    <label for="check_box">全选/取消</label>
    
    <input type="hidden" value="" name="contenttype" id="contenttype">
    
		<input type="hidden" value="<?php echo $es_hash;?>" name="es_hash">&nbsp;&nbsp;
		<input type="button" class="button" value="删除" onclick="confirm_delete1()" />
        

    </div>
    <div id="pages"><?php echo $pages;?></div>
</div>
</form>
</div>


</body>
</html>