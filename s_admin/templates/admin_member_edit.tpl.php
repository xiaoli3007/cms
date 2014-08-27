<?php
defined('IN_ADMIN') or exit('File does not exist.');
include $admin->admin_tpl('header');?>


<div class="subnav">
    <div class="content-menu ib-a blue line-x">
    <a href="admin_member.php" class="add fb"><em>管理员列表</em></a>　
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

<form name="myform" id="myform" action="admin_member.php?contenttype=<?php echo $_GET['contenttype'];?>" method="post" onSubmit="return submit_content();">
<table width="100%" class="table_form contentWrap">
      		
            
      		<tr>
                <td align="right">用户名：</td> 
                <td align="left"><input type="text"   name="info[username]" id="username"   value="<?=$r['username']?>" class="input-text" style="width:300px;"  /></td>
            </tr>
            
          <tr>
                <td align="right">新密码：</td>
                <td align="left"><input type="text" name="newpass" id="newpass" /></td>
            </tr>
            
            <tr>
                <td align="right">确认新密码：</td>
                <td align="left"><input type="text" name="twopass" id="twopass"></td>
            </tr>
            
            <tr>
                <td align="right">真实姓名：</td>
                <td align="left"><input type="text"   name="info[realname]" id="realname"   value="<?=$r['realname']?>" class="input-text" style="width:300px;"  /></td>
            </tr>
            
              <tr>
                <td align="right">email：</td>
                <td align="left"><input type="text"   name="info[email]" id="email"   value="<?=$r['email']?>" class="input-text" style="width:300px;"  /></td>
            </tr>
            
               <tr>
                <td align="right">角色：</td>
                <td align="left">
                    <select  name="info[roleid]" id="roleid" >
                   
                 <?php foreach($datasrolename as $v){?>
                <option value="<?php echo $v[roleid];?>" <?php if($r['roleid']==$v[roleid]){?> selected="selected"<?php }?>> <?php echo $v[rolename];?></option> 
                <?php }?>
                </select>
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