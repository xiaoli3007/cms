<?php
require dirname(__FILE__).DIRECTORY_SEPARATOR."admin_common.php";

session_destroy();

inc_base::set_cookie('username','');
inc_base::set_cookie('userid',0);
inc_base::set_cookie('roleid',0);
inc_base::set_cookie('es_hash',0);
//inc_base::set_cookie('sys_lang',0);

showmessage('退出成功','admin_login.php');

?>