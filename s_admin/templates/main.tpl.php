<?php
defined('IN_ADMIN') or exit('File does not exist.');
include $admin->admin_tpl('header');?>


<div id="main_frameid" class="pad-10" style="_margin-right:-12px;_width:98.9%;">


<div class="col-2 lf mr10" style="width:48%">
	<h6>我的个人信息</h6>
	<div class="content">
	您好，<?php echo $_SESSION['username'];?><br />
	所属角色：<?php echo $role['rolename'];?> <br />
	<div class="bk20 hr"><hr /></div>
	上次登录时间：<?php echo date('Y-m-d H:i:s',$logintime)?><br />
	上次登录IP：<?php echo $loginip?> <br />
	</div>
</div>



<!--<div class="col-2 col-auto">
	<h6>系统信息</h6>
	<div class="content">
    程序版本：Es V1.0 <br />
	操作系统：<?php echo PHP_OS;?> <br />
	服务器软件：<?php echo $_SERVER['SERVER_SOFTWARE'];?> <br />
	MySQL 版本：<?php echo mysql_get_server_info();?><br />
	上传文件：<?php echo @ini_get('file_uploads') ? ini_get('upload_max_filesize') :'unknown';?><br />	
	</div>
</div>-->
<div class="bk10"></div>

</div>

</body>
</html>