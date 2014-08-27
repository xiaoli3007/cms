<?php
defined('IN_ADMIN') or exit('File does not exist.');
include $admin->admin_tpl('header');?>

<script type="text/javascript" src="<?php echo ADMIN_JS;?>jquery.jUploader-1.0.min.js"></script>
<script type="text/javascript" src="<?php echo ADMIN_JS;?>uploader_photo.js"></script>



<style type="text/css">
	.jUploader-button {background:url(<?php echo ADMIN_IMG;?>up.gif) no-repeat 0 0; height:23px; width:43px; border:0;padding:0px; margin:0px; cursor:pointer;}
	.jUploader-button-hover {background-color:#111111; color:#fff;}
</style>

<div class="subnav">
    <div class="content-menu ib-a blue line-x">
    <a href="photo.php" class="add fb"><em>信息列表</em></a>　
    </div>
</div>

<script type="text/javascript">
function submit_content(){

/*	var title = $("#title").val();
	var thumb = $("#photo").val();

	if (title=="") { 
		alert("名称不能为空"); 
		$('#title').focus(); 
		return false; 
	}
	if (thumb=="") { 
		alert("缩略图不能为空"); 
		$('#thumb').focus(); 
		return false; 
	}	*/
}

	
function delete_image(id){
	
	$.ajax({
		type: "get",
		url: 'photo.php?delete_image='+id+'&num='+Math.random(),
		dataType: "json",
		success: function(savedata){
			if(savedata==1){
				alert('删除成功！');
			$(".clone_two_edit"+id+"").remove();
			}
	}
	});             
}
	
	
</script>

<div class="common-form">

<form name="myform" id="myform" action="?" method="post" onSubmit="return submit_content();">
<table width="100%" class="table_form contentWrap">
      		
      
            
      		<tr>
                <td align="right">名称：</td>
                <td align="left"><input type="text"   name="info[title]" id="title"   value="<?=$r['title']?>" class="input-text" style="width:300px;"  /></td>
            </tr>
            
   

<script type="text/javascript">
	$(function () {
$(".infotwo_ss").click(function(){ 
		
	var jishu=$('#jishu').val();

	var content='<tr class="clone_two'+jishu+'"><td width="125" height="35" align="right" valign="middle"><font class="ys_333">图集：</font></td><td  height="35" width="250" style="padding-left:10px;*padding-left:25px;"><input type="text" name="infotwo_image[]" id="infotwo_image'+jishu+'" value="" class="q_input" style="width:150px;padding:0 5px;height:20px; line-height:20px; float:left;"/><div id="infotwo_image_button'+jishu+'" style="float:left; margin-left:10px; "><span></span></div>&nbsp;&nbsp;<span style="color: #F00" id="infotwo_image_button'+jishu+'_tip"></span><script type="text/javascript">$(function () {file_uploader("infotwo_image'+jishu+'","infotwo_image_button'+jishu+'","photos_taa'+jishu+'");});<\/script></td><td  width="100" ><input type="hidden"   name="infotwo_image_small[]" id="infotwo_image'+jishu+'_150" /><a href="javascript:;" class="infotwo_ss" style="float:left; margin-left:15px;" onClick="remove_image('+jishu+')">删除</a></td></tr><tr  class="clone_two'+jishu+'"><td></td><td colspan="2">  <img src="" id="photos_taa'+jishu+'"></td></tr>';
	
    $(content).appendTo('#clone_table');//复制节点
	 var jiahou= parseInt(jishu)+1;
	 $('#jishu').val(jiahou);
 }); 
    });
	
	
function remove_image(val){
	$(".clone_two"+val+"").remove();
	}
</script>

<tr><td colspan="2" align="left">
<table  border="0" id="clone_table" style="clear:both; position:relative;  " >


<tr class="clone_two">
    <td width="125" style="" height="35" align="right" valign="middle"><font class="ys_333">图集：</font></td>
    <td  height="35"  width="250" align="left" style="padding-left:10px;*padding-left:25px;">
      <input type="text" name="infotwo_image[]" id="infotwo_image" value="" class="q_input" style="width:150px;padding:0 5px;height:20px; line-height:20px; float:left;"/><div id="infotwo_image_button" style="float:left; margin-left:10px; "><span></span></div><span style="color: #F00" id="infotwo_image_button_tip">&nbsp;&nbsp;&nbsp;&nbsp;</span>
        
        <script type="text/javascript">
	$(function () {
		file_uploader('infotwo_image','infotwo_image_button','photos_taa');
});
</script> 
        </td>
        
        <td width="100">
        
         <input type="hidden"   name="infotwo_image_small[]" id="infotwo_image_150" />
          <a href="javascript:;"  style="float:left; margin-left:15px;" class="infotwo_ss"  >添加</a>
         <input type="hidden" id="jishu" value="1">
        </td>
    </tr>
    
   <tr class="clone_two"><td></td><td colspan="2">  <img src="" id="photos_taa"></td></tr>	<!--小图预览-->
    
<?php foreach($r_two_image as $i){?>
<tr class="clone_two_edit<?php echo $i['id'];?>">
    <td width="125" height="35" align="right" valign="middle"><font class="ys_333">图集：</font></td>
    <td   width="250" align="left" height="35" style="padding-left:10px;*padding-left:25px;">
      <input type="text" name="infotwo_image[]" id="infotwo_image_edit<?php echo $i['id'];?>" value="<?php echo $i['thumb'];?>" class="q_input" style="width:150px;padding:0 5px;height:20px; line-height:20px; float:left;"/><div id="infotwo_image_edit_button<?php echo $i['id'];?>" style="float:left; margin-left:10px; "><span></span></div> <span style="color: #F00"  id="infotwo_image_edit_button<?php echo $i['id'];?>_tip"></span>
     <script type="text/javascript">
	$(function () {
		file_uploader('infotwo_image_edit<?php echo $i['id'];?>','infotwo_image_edit_button<?php echo $i['id'];?>','photos_t_edit<?php echo $i['id'];?>');
});
</script> 
        </td>
        
            <td   width="100" >
             <input type="hidden"   name="infotwo_image_small[]" id="infotwo_image_edit<?php echo $i['id'];?>_150" value="<?php echo $i['thumb_small'];?>" />
             
       <a href="javascript:;" style="float:left; margin-left:15px;" class="infotwo_ss_edit" onClick="delete_image(<?php echo $i['id'];?>)"  >删除</a>
         </td>
        
    </tr>
    
     <tr class="clone_two_edit<?php echo $i['id'];?>"><td></td><td colspan="2">  <img src="<?php echo imgurl_photo($i['thumb_small']);?>" id="photos_t_edit<?php echo $i['id'];?>"></td></tr>	<!--小图预览-->

<?php }?>




</table></td></tr>	<!--克隆的节点--->       

    
            
            
            
       
        <tr>
                <td align="right">seo_描述：</td>
                <td align="left"><textarea   name="info[description]" id="description"    class="input-area" style="width:600px; height:70px; "><?=$r['description']?></textarea></td>  
            </tr> 
            
            
           
          
                
            <tr>
                <td align="right"></td>
                <td align="left">
                <?php if($_GET['contenttype']=='edit'){ ?>
                <input name="contenttype" type="hidden" value="edit">
                <input name="id" type="hidden" value="<?php echo $_GET['id']?>">
                <?php }else{ ?>
                <input name="contenttype" type="hidden" value="add">
                <?php } ?>
                <input name="dosubmit" type="hidden" value="1">
                <input type="submit"  class="btn_sub" value="保 存" /> 
          
                </td>
            </tr>
            
            
            
          
</table>

</form>

</div>

</body>
</html>