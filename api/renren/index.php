<?php
session_start();

require_once './class/config.inc.php';

$code_url = 'https://graph.renren.com/oauth/authorize?client_id='.$config->APPID.'&response_type=code&redirect_uri='.$config->redirecturi.'&x_renew=true';

header("location:$code_url");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>renren api</title>
</head>
<body>
</body>
</html>