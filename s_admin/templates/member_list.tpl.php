<?php
defined('IN_ADMIN') or exit('File does not exist.');
include $admin->admin_tpl('header');?>

<div class="pad-10">
<div class="content-menu ib-a blue line-x">
<a href="javascript:;" class="on"><em>用户列表</em></a>
</div>


<form name="myform" id="myform" action="" method="post" >
<div class="table-list">
    <table width="100%">
        <thead>
            <tr>
			 <th width="5%"><input type="checkbox" value="" id="check_box" onclick="selectall('ids[]');"></th>
            <th width="5%">ID</th>
			<th width="15%">昵称</th>
            <th width="5%">性别</th>
         <!--   <th width="30%">注册时间</th>-->
            <th width="10%">联系方式</th>
            <th width="15%">邮箱</th>
            <th width="5%">管理</th>
            </tr>
        </thead>
<tbody>
    <?php
	if(is_array($datas)) {

		foreach ($datas as $r) {
			
	?>
        <tr>
		<td align="center"><input class="inputcheckbox " name="ids[]" value="<?php echo $r['userid'];?>" type="checkbox"></td>
		<td align='center' ><?php echo $r['userid'];?></td>
        <td><a href="member.php?contenttype=edit&id=<?php echo $r['userid'];?>"><?php echo $r['nickname'];?></a></td>
		<td align='center'><?php if( $r['sex']==1){echo "男";}elseif($r['sex']==2){echo '女';}else{echo "保密";};?></td>
	<!--	<td align='center'><?php echo date('Y-m-d H:i:s',$r['regdate']);?></td>-->
        <td align='center'><?php echo $r['mobile'];?></td>
        <td align='center'><?php echo $r['email'];?></td>
        <td align='center'><a href="member.php?contenttype=edit&id=<?php echo $r['userid'];?>">编辑</a></td>
	</tr>
     <?php }
	}
	?>
</tbody>
     </table>
    <div class="btn">
    <label for="check_box">全选/取消</label>
		<input type="hidden" value="<?php echo $es_hash;?>" name="es_hash">&nbsp;&nbsp;
		<input type="button" class="button" value="删除" onclick="myform.action='member.php?contenttype=delete&dosubmit=1';return confirm_delete()"/>
    </div>
    <div id="pages"><?php echo $pages;?></div>
</div>
</form>
</div>

<script type="text/javascript"> 
<!--

function confirm_delete(){
	if(confirm('确认删除吗？')) $('#myform').submit();
}

//-->
</script>
</body>
</html>