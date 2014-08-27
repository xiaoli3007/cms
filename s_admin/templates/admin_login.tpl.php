<?php
defined('IN_ADMIN') or exit('File does not exist.');
include $admin->admin_tpl('header');?>
<link href="<?php echo ADMIN_CSS?>login.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="<?php echo ADMIN_JS;?>jquery-1.8.2.min.js"></script>
<script type="text/javascript">
function submit_admin_login(){

	var username = $("#username").val();
	var password = $("#password").val();
	var code = $("#code").val();
	
	if (username=="") { 
		alert("用户名不能为空"); 
		$('#username').focus(); 
		return false; 
	}
	if (password=="") { 
		alert("密码不能为空"); 
		$('#password').focus(); 
		return false; 
	}
	if (code=="") { 
		alert("验证码不能为空"); 
		$('#code').focus(); 
		return false; 
	}
}
</script>
</head>
<body>
<table rules="none" border="0" width="100%"  height="100%" cellpadding="0" cellspacing="0">
    <tr>
        <td align="center">
        <div id="content">
            <div id="login">
                <div class="top">后台管理系统</div>
                <div class="con">
                <form name="myform" action="?" method="post" onSubmit="return submit_admin_login();">
                <table width="100%" class="ctab" rules="none" border="0">
                    <tr>
                        <td align="right" width="34%"><span>用户名：</span></td>
                        <td align="left" width="66%"><div class="bdwk"><div class="tu1"></div><div class="biao"><input type="text"  class="inputtext" name="username" id="username" value="" /></div></div></td>
                    </tr>
                    <tr>
                        <td align="right"><span>密&nbsp;&nbsp;&nbsp;&nbsp;码：</span></td>
                        <td align="left"><div class="bdwk"><div class="tu2"></div><div class="biao"><input type="password" class="inputtext" name="password" id="password" value="" /></div></div></td>
                    </tr>
                    <tr>
                        <td align="right"><span>验证码：</span></td>
                        <td align="left"><div class="bdwk"><div class="tu3"></div><div class="biao"><input type="text" class="inputtext" name="code" id="code" value="" /></div></div> <img id='code_img' onclick='this.src=this.src+"&"+Math.random()' src='<?php echo APP_PATH;?>api/checkcode.php?code_len=4&font_size=15&width=80&height=30&font_color=&background='></td>
                    </tr>
                    <tr>
                        <td align="right">&nbsp;</td>
                        <td align="left"><input class="dlbtn" type="submit" name="dosubmit" value=""> </td>
                    </tr>
                </table>
                </form>
                </div>
            </div>
        </div>
        </td>
    </tr>
</table>
</body>
</html>