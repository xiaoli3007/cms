<?php
defined('IN_ADMIN') or exit('File does not exist.');
include $admin->admin_tpl('header');?>


<div class="subnav">
    <div class="content-menu ib-a blue line-x">
    <a href="role.php" class="add fb"><em>菜单列表</em></a>　
    </div>
</div>

<script type="text/javascript">
function submit_content(){

	var name = $("#name").val();
	
	if (name=="") { 
		alert("名称不能为空"); 
		$('#name').focus(); 
		return false; 
	}

	
}


function  selectsub(a){
		
	
		var obj = $(".tree"+a+"");
		
		//alert($(".one_ji"+a+"").attr("checked"));
		
		if(obj.attr("checked")!='checked'){
		obj.removeAttr("checked");//取消选中	
		}else{
		obj.attr("checked",'true');//选中	
		}
				
	}
		

</script>

<div class="common-form">

<form name="myform" id="myform" action="role.php?contenttype=<?php echo $_GET['contenttype'];?>" method="post" onSubmit="return submit_content();">
<table width="100%" class="table_form contentWrap">
      		
            
      		<tr>
                <td align="right">角色名：</td>
                <td align="left"><input type="text"   name="info[rolename]" id="name"   value="<?=$r['rolename']?>" class="input-text" style="width:300px;"  /></td>
            </tr>
            
                <tr>
                <td align="right">角色描述：</td>
                <td align="left"><input type="text"   name="info[description]" id="description"   value="<?=$r['description']?>" class="input-text" style="width:300px;"  /></td>
            </tr>
            
            
<tr>
                <td align="right">权限：</td>
                <td align="left">
               
                   
               <?php echo $munu_list ;?>
                

              
    </td>
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