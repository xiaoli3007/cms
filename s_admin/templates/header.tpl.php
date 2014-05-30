<?php defined('IN_ADMIN') or exit('File does not exist.'); 
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET;?>" />
<meta http-equiv="X-UA-Compatible" content="IE=7" />
<title>后台管理系统</title>

<link href="<?php echo ADMIN_CSS?>reset.css" rel="stylesheet" type="text/css" />
<link href="<?php echo ADMIN_CSS?>zh-cn-system.css" rel="stylesheet" type="text/css" />
<link href="<?php echo ADMIN_CSS?>table_form.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript" src="<?php echo ADMIN_JS;?>jquery-1.8.2.min.js"></script>
<?php
//if(isset($show_dialog)) {
?>
<link href="<?php echo ADMIN_CSS?>dialog.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript" src="<?php echo ADMIN_JS?>dialog.js"></script>
<?php //} ?>

<script language="javascript" type="text/javascript" src="<?php echo ADMIN_JS?>admin_common.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo ADMIN_JS?>styleswitch.js"></script>
<?php if(isset($show_validator)) { ?>
<script language="javascript" type="text/javascript" src="<?php echo ADMIN_JS?>formvalidator.js" charset="UTF-8"></script>
<script language="javascript" type="text/javascript" src="<?php echo ADMIN_JS?>formvalidatorregex.js" charset="UTF-8"></script>
<?php } ?>

<script src="<?php echo ADMIN_K?>My97DatePicker/WdatePicker.js" type="text/javascript"></script>

<script type="text/javascript">
	window.focus();
	var es_hash = '<?php echo $_SESSION['es_hash'];?>';
	<?php if(!isset($show_es_hash)) { ?>
		window.onload = function(){
		var html_a = document.getElementsByTagName('a');
		var num = html_a.length;
		for(var i=0;i<num;i++) {
			var href = html_a[i].href;
			if(href && href.indexOf('javascript:') == -1) {
				if(href.indexOf('?') != -1) {
					html_a[i].href = href+'&es_hash='+es_hash;
				} else {
					html_a[i].href = href+'?es_hash='+es_hash;
				}
			}
		}

		var html_form = document.forms;
		var num = html_form.length;
		for(var i=0;i<num;i++) {
			var newNode = document.createElement("input");
			newNode.name = 'es_hash';
			newNode.type = 'hidden';
			newNode.value = es_hash;
			html_form[i].appendChild(newNode);
		}
	}
<?php } ?>


function showinfotoflash(){

window.location.reload();
}

</script>


</head>
<body>

<style type="text/css">
	html{_overflow-y:scroll}
</style>


