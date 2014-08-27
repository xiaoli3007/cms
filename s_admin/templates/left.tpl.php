<?php
defined('IN_ADMIN') or exit('File does not exist.');
$es_hash = $_SESSION['es_hash'];
foreach($datas as $_value) {
	echo '<h3 class="f14"><span class="switchs cu on" title="展开与收缩"></span>'.$_value['name'].'</h3>';
	echo '<ul>';
	$sub_array = admin::admin_menu($_value['id']);
	foreach($sub_array as $_key=>$_m) {
		//附加参数
		$data = $_m['data'] ? $_m['data'] : '?';
		$is_m = $_m['is_m'] ? $_m['is_m'] : '';
		if($is_m){
			$_m['url']=WEB_PATH.$_m['url'];
		}
		if($menuid == 5) { //左侧菜单不显示选中状态
			$classname = 'class="sub_menu"';
		} else {
			$classname = 'class="sub_menu"';
		}
		//echo '<li id="_MP'.$_m['id'].'" '.$classname.'><a href="javascript:_MP('.$_m['id'].',\''.$_m['url'].'.php'.$data.'\');" hidefocus="true" style="outline:none;">'.$_m['name'].'</a></li>';
		
		echo '<li id="_MP'.$_m['id'].'" '.$classname.'><a href="javascript:_MP('.$_m['id'].',\''.$_m['url'].'\');" hidefocus="true" style="outline:none;">'.$_m['name'].'</a></li>';
	}
	echo '</ul>';
}
?>
<script type="text/javascript">
$(".switchs").each(function(i){
	var ul = $(this).parent().next();
	$(this).click(
	function(){
		if(ul.is(':visible')){
			ul.hide();
			$(this).removeClass('on');
				}else{
			ul.show();
			$(this).addClass('on');
		}
	})
});
</script>