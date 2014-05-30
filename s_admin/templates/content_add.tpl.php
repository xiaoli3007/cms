<?php
defined('IN_ADMIN') or exit('File does not exist.');
include $admin->admin_tpl('header');?>

<script type="text/javascript" src="<?php echo ADMIN_JS;?>jquery.jUploader-1.0.min.js"></script>
<script type="text/javascript" src="<?php echo ADMIN_JS;?>uploader.js"></script>
		<script charset="utf-8" src="<?php echo ADMIN_K?>kindeditor4/kindeditor-min.js"></script>
		<script charset="utf-8" src="<?php echo ADMIN_K?>kindeditor4/lang/zh_CN.js"></script>
		<script>
			var editor;
			KindEditor.ready(function(K) {
				editor = K.create('textarea[id="content"]', {
					allowFileManager : true,
				
				
				});		
			});
		
		</script>
        
     
<style type="text/css">
	.jUploader-button {background:url(<?php echo ADMIN_IMG;?>up.gif) no-repeat 0 0; height:23px; width:43px; border:0;padding:0px; margin:0px; cursor:pointer;}
	.jUploader-button-hover {background-color:#111111; color:#fff;}
</style>

<div class="subnav">
    <div class="content-menu ib-a blue line-x">
    <a href="content_member.php?page=<?=$_GET['page']?>" class="add fb"><em>返回</em></a>　
    </div>
</div> 

<script type="text/javascript">
function submit_content(){

	var title = $("#title").val();
	var catid = $("#catid").val();
	var content = $("#content").val();



	if (title=="") { 
		alert("名称不能为空"); 
		$('#title').focus(); 
		return false; 
	}
	if (catid==0) { 
		alert("栏目不能为空"); 
		$('#catid').focus(); 
		return false; 
	}
}

	

			
		
	
</script>

<div class="common-form">

<form name="myform" id="myform" action="?" method="post" onSubmit="return submit_content();">
<table width="100%" class="table_form contentWrap">
      		
      
         
            <tr>
                <td align="right">标题：</td>
                <td align="left"><input type="text"   name="info[title]" id="title"   value="<?=$r['title']?>" class="input-text" style="width:300px;"  /></td>
            </tr>
            
            
               <tr>
                <td align="right">栏目：</td>
                <td align="left">
                <?php echo form::select_category('category_model',$r['catid'],'name="info[catid]" id="catid"','请选择分类') ;?>
                
                </td>
            </tr>
            
             <tr>
                <td align="right">缩略图：</td>
                <td align="left"> 
                <input type="text" name="info[thumb]" id="thumb" value="" class="q_input" style="width:150px;padding:0 5px;height:20px; line-height:20px; float:left;"/>			
                <div id="thumb_button" style="float:left; margin-left:10px; "><span></span></div>
                <span style="color: #F00" id="thumb_button_tip"></span>
       			 </td>
            </tr>
            
            
             <tr id="photos_yulan" style="display:none;">
                <td align="right">预览：</td>
                <td align="left"> 
                	<img src="" id="photos_taa" width="200" height="200">
        		</td>
            </tr>
           <script type="text/javascript">
				$(function () {
					file_uploader('thumb','thumb_button','photos_taa','photos_yulan');
			});
			</script> 


            <tr>
                <td align="right">发布日期：</td>
                <td align="left">
                	<input type="text" class="input-text"  name="info[inputtime]"  onfocus="WdatePicker({dateFmt:'yyyy-MM-dd'})"   value="<?php if($r['inputtime'])echo date('Y-m-d H:i:s',$r['inputtime']);else echo date('Y-m-d H:i:s',time());?>"/>
                
                </td>
            </tr>
			
    
    	  <tr>
                <td align="right">描述：</td>
                <td align="left"><textarea   name="info[description]" id="description"    class="input-area" style="width:600px; height:70px; "><?=$r['description']?></textarea></td>  
            </tr> 
            
            
     <tr>
                <td align="right">详细：</td>
                <td align="left"><textarea   name="info[content]" id="content"    class="input-area" style="width:700px; height:400px; "><?=$r['content']?></textarea></td>  
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