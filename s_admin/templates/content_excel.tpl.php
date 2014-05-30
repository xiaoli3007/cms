<?php
defined('IN_ADMIN') or exit('File does not exist.');
include $admin->admin_tpl('header');?>

<script type="text/javascript" src="<?php echo ADMIN_JS;?>jquery.jUploader-1.0.min.js"></script>
<script type="text/javascript" src="<?php echo ADMIN_JS;?>uploader_excel.js"></script>

          
<style type="text/css">
	.jUploader-button {background:url(<?php echo ADMIN_IMG;?>up.gif) no-repeat 0 0; height:23px; width:43px; border:0;padding:0px; margin:0px; cursor:pointer;}
	.jUploader-button-hover {background-color:#111111; color:#fff;}
</style>



<script type="text/javascript">
function submit_content(){

	var excel_file = $("#excel_file").val();


	if (excel_file=="") { 
		alert("文件不能为空"); 
		$('#excel_file').focus(); 
		return false; 
	}

}
	
	
</script>

<div class="common-form">

<form name="myform" id="myform" action="?" method="post" onSubmit="return submit_content();">
<table width="100%" class="table_form contentWrap">
      		
      <tr class="clone_two">
    <td width="125" style="" height="35" align="right" valign="middle"><font class="ys_333">选择excel文件：</font></td>
    <td  height="35"  width="250" align="left" style="padding-left:10px;*padding-left:25px;">
      <input type="hidden" name="excel_file" id="excel_file" value="" class="q_input" />
      <span id="photos_taa"></span>
      <div id="infotwo_image_button" style="float:left; margin-left:10px; "><span></span></div><span style="color: #F00" id="infotwo_image_button_tip">&nbsp;&nbsp;&nbsp;&nbsp;</span>
        
        <script type="text/javascript">
	$(function () {
		file_uploader('excel_file','infotwo_image_button','photos_taa');
});
</script> 
        </td>
        
    </tr>
          
            <tr>
                <td align="right"></td>
                <td align="left">
            
                <input name="dosubmit" type="hidden" value="1">
                <input type="submit"  class="btn_sub" value="导入" /> 
          
                </td>
            </tr>
            
            
            
          
</table>

</form>

</div>

</body>
</html>