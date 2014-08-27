<?php
defined('IN_ADMIN') or exit('File does not exist.');
include $admin->admin_tpl('header');?>




<div class="pad-10">
<div class="content-menu ib-a blue line-x">
　
<a href="javascript:;" class="on"><em>菜单列表</em></a>

<a href="menu.php?contenttype=add" class="on"><em>添加菜单</em></a>

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
			 <th width="100" align="center"><input type="checkbox" value="" id="check_box" onclick="selectall('ids[]');"></th>
            <th width="40">ID</th>
             <th width="100">菜单名称</th>
             
		<!--	<th  width="100">父级</th>-->
            <th  width="200">url</th>
            <th width="100">是否显示</th>
               <th width="100">排序</th>
          
       <th width="100">管理</th>
            </tr>
        </thead>
<tbody> 

<?php echo $categorys;?>


    <?php
	if(is_array($datas)) {

		foreach ($datas as $r) {
			 
	?>
  <!--      <tr>
		<td align="left"><input class="inputcheckbox " name="ids[]" value="<?php echo $r['id'];?>" type="checkbox"></td>
		<td align='center' ><?php echo $r['id'];?></td>
        <td align='center' ><?php echo $r['name'];?></td>
    
        <td align='center'><?php echo $r['parentid'];?></td>
        

         <td align='center'><?php echo $r['url'];?></td>
         <td align='center'><?php if($r['display']){echo '是';}else{echo '否';}?></td>
          <td align='center'><?php echo $r['listorder'];?></td>
         
    <td align='center'><a href="menu.php?contenttype=edit&id=<?php echo $r['id'];?>">编辑</a></td>
	</tr>
-->
    
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