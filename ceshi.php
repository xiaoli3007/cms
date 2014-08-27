<?php



$aa=date('Y-m',time());

	error_log(date('Y-m-d H:i:s',time()).'| GET:  pay  is succ |'."\r\n", 3, 'log/pay_succ_log_'.$aa.'.php'); //日志
	

?>