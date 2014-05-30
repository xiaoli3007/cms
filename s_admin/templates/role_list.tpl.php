<?php
defined('IN_ADMIN') or exit('File does not exist.');
include $admin->admin_tpl('header');?>




<div class="pad-10">
<div class="content-menu ib-a blue line-x">
　
<a href="javascript:;" class="on"><em>角色列表</em></a>

<a href="role.php?contenttype=add" class="on"><em>添加角色</em></a>

<div style="float:right; padding-right:20px;">

</div>

</div>


<script type="text/javascript"> 


function confirm_delete1(){
	if(confirm('确认删除吗？')) {$('#myform1').submit();}
}



</script>
<form name="myform1" id="myform1" action="" method="post"  >
<div class="table-list">
    <table width="100%">
        <thead>
            <tr>
			 <th width="100" align="left"><input type="checkbox" value="" id="check_box" onclick="selectall('ids[]');"></th>
            <th width="40">ID</th>
             <th width="100">角色名</th>
             
			<th  width="100">角色描述</th>
   
          
       <th width="100">管理</th>
            </tr>
        </thead>
<tbody> 
    <?php
	if(is_array($datas)) {

		foreach ($datas as $r) {
			 
	?>
        <tr>
		<td align="left"><input class="inputcheckbox " name="ids[]" value="<?php echo $r['roleid'];?>" type="checkbox"></td>
		<td align='center' ><?php echo $r['roleid'];?></td>
        <td align='center' ><?php echo $r['rolename'];?></td>
    
        <td align='center'><?php echo $r['description'];?></td>
        

         
    <td align='center'><a href="role.php?contenttype=edit&id=<?php echo $r['roleid'];?>">编辑</a></td>
	</tr>
    
     <?php }
	}
	?>
</tbody>
     </table>
    <div class="btn">
    <label for="check_box">全选/取消</label>
    
    <input type="hidden" value="delete" name="contenttype">
    
		<input type="hidden" value="<?php echo $es_hash;?>" name="es_hash">&nbsp;&nbsp;
		<input type="button" class="button" value="删除" onclick="confirm_delete1()" />
    </div>
    <div id="pages"><?php echo $pages;?></div>
</div>
</form>
</div>


</body>
</html>