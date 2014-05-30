<?php
defined('IN_ADMIN') or exit('File does not exist.');
include $admin->admin_tpl('header');?>




<div class="pad-10">
<div class="content-menu ib-a blue line-x">
　
<a href="javascript:;" class="on"><em>管理员列表</em></a>

<a href="admin_member.php?contenttype=add" class="on"><em>添加管理员</em></a>

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
             <th width="100">昵称</th>
             
			<th  width="100">真实姓名</th>
            
            <th  width="100">角色</th>
            <th  width="200">email </th>
            <th width="100">最后登录</th>
             
       <th width="100">管理</th>
            </tr>
        </thead>
<tbody> 
    <?php
	if(is_array($datas)) {

		foreach ($datas as $r) {
			
			$raa=$admin_role_db->get_one(array('roleid'=>$r['roleid'])); 
	?>
        <tr>
		<td align="left"><input class="inputcheckbox " name="ids[]" value="<?php echo $r['userid'];?>" type="checkbox"></td>
		<td align='center' ><?php echo $r['userid'];?></td>
        <td align='center' ><?php echo $r['username'];?></td>
    
        <td align='center'><?php echo $r['realname'];?></td>
        
           <td align='center'><?php echo $raa['rolename'];?></td>
           
         <td align='center'><?php echo $r['email'];?></td>
    <td align='center'><?php echo date('Y-m-d H:i',$r['lastlogintime']);?></td>
         
    <td align='center'><a href="admin_member.php?contenttype=edit&id=<?php echo $r['userid'];?>">编辑</a></td>
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

<script type="text/javascript"> 



parent.document.getElementById('display_center_id').style.display='none';


</script>
</body>
</html>