<?php
defined('IN_ADMIN') or exit('File does not exist.');
include $admin->admin_tpl('header');?>




<div class="pad-10">
<div class="content-menu ib-a blue line-x">
　
<a href="javascript:;" class="on"><em>分类列表</em></a>

<a href="photo_category.php?contenttype=add" class="on"><em>添加分类</em></a>

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
			 <th width="16"><input type="checkbox" value="" id="check_box" onclick="selectall('ids[]');"></th>
            <th width="40">ID</th>
             <th width="100">分类名称</th>
             
			<th  width="200">标题</th>
            <th  width="200">关键字</th>
            <th width="100">描述</th>
           <th width="100">排序</th>
       <th width="100">管理</th>
            </tr>
        </thead>
<tbody> 
    <?php
	if(is_array($datas)) {

		foreach ($datas as $r) {
			 
	?>
        <tr>
		<td align="center"><input class="inputcheckbox " name="ids[]" value="<?php echo $r['catid'];?>" type="checkbox"></td>
		<td align='center' ><?php echo $r['catid'];?></td>
        <td align='center' ><?php echo $r['catname'];?></td>
    
        <td align='left'><?php echo $r['title'];?></td>
        

         <td align='center'><?php echo $r['keywords'];?></td>
          <td align='center'><?php echo $r['description'];?></td>
          <td align='center'><?php echo $r['listorder'];?></td>
    <td align='center'><a href="photo_category.php?contenttype=edit&id=<?php echo $r['catid'];?>">编辑</a></td>
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