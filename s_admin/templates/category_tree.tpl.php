<?php
defined('IN_ADMIN') or exit('File does not exist.');
include $admin->admin_tpl('header');?>
<div class="bk10"></div>
<link rel="stylesheet" href="<?php echo ADMIN_CSS;?>jquery.treeview.css" type="text/css" />
<script type="text/javascript" src="<?php echo ADMIN_JS;?>jquery.cookie.js"></script>
<script type="text/javascript" src="<?php echo ADMIN_JS;?>jquery.treeview.js"></script>
<?php if($ajax_show) {?>
<script type="text/javascript" src="<?php echo ADMIN_JS;?>jquery.treeview.async.js"></script>
<?php }?>
<SCRIPT LANGUAGE="JavaScript">
<!--
<?php if($ajax_show) {?>
$(document).ready(function(){
    $("#category_tree").treeview({
			control: "#treecontrol",
			url: "index.php?m=content&c=content&a=public_sub_categorys&menuid=<?php echo $_GET['menuid']?>",
			ajax: {
				data: {
					"additional": function() {
						return "time: " + new Date;
					},
					"modelid": function() {
						return "<?php echo $modelid?>";
					}
				},
				type: "post"
			}
	});
});
<?php } else {?>
$(document).ready(function(){
    $("#category_tree").treeview({
			control: "#treecontrol",
			persist: "cookie",
			cookieId: "treeview-black"
	});
});
<?php }?>
function open_list(obj) {

	window.top.$("#current_pos_attr").html($(obj).html());
}

//-->
</SCRIPT>
 <style type="text/css">
.filetree *{white-space:nowrap;}
.filetree span.folder, .filetree span.file{display:auto;padding:1px 0 1px 16px;}
 </style>
 <div id="treecontrol">
 <span style="display:none">
		<a href="#"></a>
		<a href="#"></a>
		</span>
		<a href="#"><img src="<?php echo ADMIN_IMG;?>minus.gif" /> <img src="<?php echo ADMIN_IMG;?>application_side_expand.png" /> 展开/收缩</a>
</div>
<?php echo $categorys; ?>