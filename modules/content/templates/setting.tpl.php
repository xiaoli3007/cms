<?php
//defined('IN_ADMIN') or exit('File does not exist.');

include admin_template('header');

?>




<div class="pad-10">
<div class="content-menu ib-a blue line-x">
　
<a href="javascript:;" class="on"><em>分类列表</em></a>


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
          <th  width="100">目录</th>
          <th width="100">排序</th>
       <th width="200">管理</th>
            </tr>
        </thead>
<tbody> 

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