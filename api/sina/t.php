<?php

require dirname(__FILE__).DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."inc".DIRECTORY_SEPARATOR."common.php";

inc_base::_session_start();

#inc_base::set_cookie('dnja','sdfsdf');

#$var = inc_base::load_config('system','cookie_pre').'_userid';
//echo $var;
//print_r($_COOKIE);

#echo $_COOKIE[$var];

echo $_SESSION['_username'];
echo $_SESSION['_userid'];
echo $_SESSION['_nickname'];
die;		
	
?>