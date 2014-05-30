<?php
defined('IN_ADMIN') or exit('File does not exist.');
include $admin->admin_tpl('header');?>


<div class="subnav">
    <div class="content-menu ib-a blue line-x">
    <a href="menu.php" class="add fb"><em>菜单列表</em></a>　
    </div>
</div>

<script type="text/javascript">
function submit_content(){

	var catname = $("#catname").val();
	
	if (catname=="") { 
		alert("名称不能为空"); 
		$('#catname').focus(); 
		return false; 
	}

	
}

</script>

<div class="common-form">

<form name="myform" id="myform" action="menu.php?contenttype=<?php echo $_GET['contenttype'];?>" method="post" onSubmit="return submit_content();">
<table width="100%" class="table_form contentWrap">
      		
            
      		<tr>
                <td align="right">菜单名称：</td>
                <td align="left"><input type="text"   name="info[name]" id="name"   value="<?=$r['name']?>" class="input-text" style="width:300px;"  /></td>
            </tr>
            
            <tr>
                <td align="right">父级：</td>
                <td align="left">
                <?php echo form::select_menus('menu_model',$r['parentid'],'name="info[parentid]" id="parentid"','请选择分类') ;?>
                
                </td>
            </tr>
      

            
            <tr>
                <td align="right">url：</td>
                <td align="left"><input type="text"   name="info[url]" id="url"   value="<?=$r['url']?>" class="input-text" style="width:300px;"  /></td>
            </tr>
            
            
         <tr>
                <td align="right">是否显示：</td>
                <td align="left">
                
                <select  name="info[display]" id="hidden" >
                <option value="1"<?php if($r['display']){?> selected="selected"<?php }?>> 显示</option>
                <option value="0" <?php if(!$r['display']){?> selected="selected"<?php }?>>隐藏 </option>
                </select></td>  
            </tr> 
            
                   
            <tr>
                <td align="right">排序：</td>
                <td align="left"><input type="text"   name="info[listorder]" id="listorder"   value="<?=$r['listorder']?>" class="input-text" style="width:300px;"  /></td>
            </tr>
            
              <tr>
                <td align="right">是否为modules：</td>
                <td align="left">
               是 <input name="info[is_m]" type="radio" value="1"  <?php if($r['is_m']){?> checked="checked" <?php }?>/> 
               否  <input name="info[is_m]" type="radio" value="0"  <?php if(!$r['is_m']){?> checked="checked" <?php }?>/></td>
            </tr>
            
          
            <tr>
                <td align="right"></td>
                <td align="left">
                <?php if($_GET['contenttype']=='edit'){ ?>
                <input name="contenttype" type="hidden" value="edit">
                <input name="id" type="hidden" value="<?php echo $_GET['id']?>">
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