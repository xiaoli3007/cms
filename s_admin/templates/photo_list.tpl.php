<?php
defined('IN_ADMIN') or exit('File does not exist.');
include $admin->admin_tpl('header');?>




<div class="pad-10">
<div class="content-menu ib-a blue line-x">
　
<a href="javascript:;" class="on"><em>信息列表</em></a>

<a href="photo.php?contenttype=add" class="on"><em>添加信息</em></a>

 
<div style="float:right; padding-right:20px;">
<form name="myform" id="myform" action="" method="get" >

 id <input type="text" value="" name="id">
    
分类：<select name="catid">
<option value="0">请选择...</option>
<?php foreach($category_listArr as $key => $cat){?>
<option value="<?php echo $cat['catid']?>" <?php if($catid==$cat['catid']){?>selected="selected"<?php }?>><?php echo $cat['catname'];?></option>
<?php } ?>
</select>

<input type="hidden" value="1" name="page">

<input type="submit" value="搜索">
</form>
</div>

</div>


<script type="text/javascript"> 


function confirm_delete1(){
	$('#contenttype').val('delete');
	if(confirm('确认删除吗？')) {
		
		
		$('#myform1').submit();}
}


function confirm_remove(){
	
	
	if($('#remove_catid').val()==0){
		
		alert('选择转移的分类');
	}else{
		$('#contenttype').val('remove');
		
		if(confirm('确认转移吗？')) {
		
		
		$('#myform1').submit();
		
		}	
	}
	

}



</script>
<form name="myform1" id="myform1" action="" method="post" >
<div class="table-list">
    <table width="100%">
        <thead>
            <tr>
			 <th width="16"><input type="checkbox" value="" id="check_box" onclick="selectall('ids[]');"></th>
            <th width="40">ID</th>
			<th  width="200">标题</th>
            <th  width="200">图</th>
            <th width="150">分类</th>
             <th width="100">发布人</th>
             
            <th width="200">时间</th>
            <th width="70">推荐</th>
          <th width="100">管理</th>
            </tr>
        </thead>
<tbody> 
    <?php
	if(is_array($datas)) {

		foreach ($datas as $r) {
			$category_r = $photo_category_db->get_one(array('catid'=>$r['catid']));
			if(!$r['admin_id']){
				$r['admin_id']='总管理';
			}else{
			$asdsad =$admin_db->get_one(array('userid'=>$r['admin_id']));
			
			$r['admin_id']=$asdsad['realname'];
			}
	?>
        <tr>
		<td align="center"><input class="inputcheckbox " name="ids[]" value="<?php echo $r['id'];?>" type="checkbox"></td>
		<td align='center' ><?php echo $r['id'];?></td>
        <td><a href="<?php echo APP_PATH.'photo/';?><?php echo $r['id']?>/" target="_blank"><?php echo $r['title'];?></a></td>
        
        <td align='left'><?php if($r['thumb_small']){?><span style="color:#F00;"><img src="<?php echo imgurl_photo($r['thumb_small']);?>"  width="67" height="67">(图)</span><?php }?></td>
        
		<td align='center'><?php echo $category_r['catname'];?></td>
         <td align='center'><?php echo $r['admin_id'];?></td>
         
         
		<td align='center'><?php echo date('Y-m-d H:i:s',$r['inputtime']);?></td>
        
        <?php if($r['hot']==1){ ?>
        <td align='center'><a href="photo.php?contenttype=hot&hot=2&id=<?php echo $r['id'];?>&page=<?php echo $page;?>&catid=<?php echo $catid;?>">已推荐</a></td>
        <?php }elseif($r['hot']==2){ ?>
        <td align='center'><a href="photo.php?contenttype=hot&hot=0&id=<?php echo $r['id'];?>&page=<?php echo $page;?>&catid=<?php echo $catid;?>">已置顶</a></td>
        <?php }else{ ?>
        <td align='center'><a href="photo.php?contenttype=hot&hot=1&id=<?php echo $r['id'];?>&page=<?php echo $page;?>&catid=<?php echo $catid;?>">未推荐</a></td>
        <?php } ?>
       <td align='center'><a href="photo.php?contenttype=edit&id=<?php echo $r['id'];?>&catid=<?php echo $catid;?>">编辑</a></td>
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
        
        <select name="remove_catid" id="remove_catid">
<option value="0">批量转移分类...</option>
<?php foreach($category_listArr as $key => $cat){?>
<option value="<?php echo $cat['catid']?>" <?php if($catid==$cat['catid']){?>selected="selected"<?php }?>><?php echo $cat['catname'];?></option>
<?php } ?>
</select>
	<input type="button" class="button" value="转移提交" onclick="confirm_remove()" />

    </div>
    <div id="pages"><?php echo $pages;?></div>
</div>
</form>
</div>


</body>
</html>