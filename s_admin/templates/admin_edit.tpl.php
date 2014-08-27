<?php
defined('IN_ADMIN') or exit('File does not exist.');
include $admin->admin_tpl('header');?>


<div class="subnav">
    <div class="content-menu ib-a blue line-x">
  <!--  <a href="admin_member.php" class="add fb"><em>管理员列表</em></a>　-->
    </div>
</div>

<script type="text/javascript">
function submit_content(){

	var oldpass = $("#oldpass").val();
	var newpass = $("#newpass").val();
	var twopass = $("#twopass").val();
	
	if (oldpass=="") { 
		alert("旧密码不能为空"); 
		$('#oldpass').focus(); 
		return false; 
	}
	
	if (newpass=="") { 
		alert("新密码不能为空"); 
		$('#newpass').focus(); 
		return false; 
	}
	
		if (twopass=="") { 
		alert("确认密码不能为空"); 
		$('#twopass').focus(); 
		return false; 
	}
	
		if (newpass!=twopass) { 
		alert("两次密码不一致！"); 
		$('#newpass').focus(); 
		return false; 
	}
	
}

</script>

<div class="common-form">

<form name="myform" id="myform" action="" method="post" onSubmit="return submit_content();">
<table width="100%" class="table_form contentWrap">
      		
            
      	<!--	<tr>
                <td align="right">用户名：</td> 
                <td align="left"><input type="text"   name="info[username]" id="username"   value="<?=$r['username']?>" class="input-text" style="width:300px;"  /></td>
            </tr>
            -->
            
            <tr>
                <td align="right">旧密码：</td>
                <td align="left"><input type="password" name="oldpass" id="oldpass" /></td>
            </tr>
            
          <tr>
                <td align="right">新密码：</td>
                <td align="left"><input type="password" name="newpass" id="newpass" /></td>
            </tr>
            
            <tr>
                <td align="right">确认新密码：</td>
                <td align="left"><input type="password" name="twopass" id="twopass"></td>
            </tr>
            
        <!--    <tr>
                <td align="right">真实姓名：</td>
                <td align="left"><input type="text"   name="info[realname]" id="realname"   value="<?=$r['realname']?>" class="input-text" style="width:300px;"  /></td>
            </tr>
            
              <tr>
                <td align="right">email：</td>
                <td align="left"><input type="text"   name="info[email]" id="email"   value="<?=$r['email']?>" class="input-text" style="width:300px;"  /></td>
            </tr>-->
            
           
          
            <tr>
                <td align="right"></td>
                <td align="left">
          
               
            
                <input name="dosubmit" type="hidden" value="1">
                <input type="submit"  class="btn_sub" value="确 认" /> 
    
                </td>
            </tr>
            
            
            
          
</table>

</form>

</div>

</body>
</html>