<?php
defined('IN_ADMIN') or exit('File does not exist.');
include $admin->admin_tpl('header');?>




<div class="pad-10" >
<div class="content-menu ib-a blue line-x">
　
<!--<a href="javascript:;" class="on"><em>信息列表</em></a>-->

<a href="content_member.php?contenttype=add" class="on"><em>添加信息</em></a>

<?php //echo ip();?>
</div>
<div  class="content-menu ib-a blue line-x" style=" padding-right:20px;">
<form name="myform" id="myform" action="" method="get" >

  

栏目： 
  <?php echo form::select_category('category_model',$catid,'name="catid" id="catid"','请选择分类') ;?>
               &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                
        开始 ：<input type="text" class="Wdate" style="width:100px;"  name="start_time"  onfocus="WdatePicker({dateFmt:'yyyy-MM-dd'})"   value="<?php if($start_time)echo date('Y-m-d',$start_time);?>"/>
                
         结束：  <input type="text" class="Wdate"  style="width:100px;"  name="end_time"  onfocus="WdatePicker({dateFmt:'yyyy-MM-dd'})"   value="<?php  if($end_time)echo date('Y-m-d',$end_time);?>"/>
                

关键词： <input type="text"  style="width:100px;"  name="keyword"    value="<?php echo $title;?>"/>
<input type="hidden" value="1" name="page">

<input type="submit" value="搜索">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;


<input type="text" class="Wdate" id="d414" onfocus="WdatePicker({startDate:'00:00:00',dateFmt:'[0-9][0-9]$:mm:ss',qsEnabled:false})"/>

</form>
</div>


<script type="text/javascript"> 


function confirm_delete1(){
	$('#contenttype').val('delete');
	if(confirm('确认删除吗？')) {
		
		
		$('#myform1').submit();}
}


function confirm_remove(){
	
	
	if($('#remove_catid').val()==0){
		
		alert('选择咨询顾问');
	}else{
		$('#contenttype').val('remove');
		
		if(confirm('确认分配吗？')) {
		
		
		$('#myform1').submit();
		
		}	
	}
	

}



</script>
<form name="myform1" id="myform1" action="" method="post" >
<div class="table-list">
    <table width="100%" style="color:#000;">
        <thead>
            <tr>
			 <th width="50"><input type="checkbox" value="" id="check_box" onclick="selectall('ids[]');"></th>
            <th width="100">ID</th>
            <th  width="100">时间</th>
            <th  width="100">栏目</th>
         	<th  width="200">标题</th>
          
            <th width="100">发布人</th>
         	<th width="200">管理</th>
            </tr>
        </thead>
<tbody> 
    <?php
	if(is_array($datas)) {

		foreach ($datas as $r) {
			$asdsad =$admin_db->get_one(array('userid'=>$r['admin_id']));
			
			$zuozhe=$asdsad['realname'];
		 
	?>
        <tr  height="15" >
		<td align="center"  width="50" ><input class="inputcheckbox " name="ids[]" value="<?php echo $r['id'];?>" type="checkbox"></td>
		<td align='center'   width="100"><?php echo $r['id'];?></td>
         <td align='center'   width="100" ><?php echo date('Y-m-d',$r['inputtime']);?></td>
          <td align='center'  width="100" ><?php echo get_catname($r['catid']);?></td>
      	 <td align='left'  width="200" ><a href="<?php echo $r['html_url'];?>" target="_blank"><?php echo str_cut($r['title'],'30','...');?></a></td>
        
        <td align='center'   width="100"><?php echo $zuozhe;?></td>
     	<td align='center'   width="200">
        <a href="content_member.php?contenttype=edit&id=<?php echo $r['id'];?>">编辑</a>
       </td>
	</tr>
     <?php }
	}
	?>
</tbody>
     </table>
     <?php if($_SESSION['roleid']==1){?>
    <div class="btn">
    <label for="check_box">全选/取消</label>
    
    <input type="hidden" value="" name="contenttype" id="contenttype">
    
		<input type="hidden" value="<?php echo $es_hash;?>" name="es_hash">&nbsp;&nbsp;
		<input type="button" class="button" value="删除" onclick="confirm_delete1()" />
        
     <!--  <select name="remove_catid" id="remove_catid">
<option value="0">分配...</option>
<?php foreach($category_admin as $key => $cat){?>
<option value="<?php echo $cat['userid']?>" ><?php echo $cat['realname'];?></option>
<?php } ?>
</select>
	<input type="button" class="button" value="分配提交" onclick="confirm_remove()" />
-->
    </div>
    <?php }?>
    <div id="pages" style="float:left;"><?php echo $pages;?></div>
</div>
</form>
</div>

   
</body>
</html>