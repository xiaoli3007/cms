<?php
require dirname(__FILE__).DIRECTORY_SEPARATOR."admin_common.php";
if($_GET['type']=='city'){
	
	//$response[""] = "请选择";
	$id = isset($_GET["province"]) ? intval($_GET["province"]) : '';
	if ($id) {
		$linkage_db = inc_base::load_model('linkage_model');
		$city_arr = $linkage_db->select(array('parentid'=>$id), 'linkageid,name');
		
		//$response[""] = "请选择";
		if($_GET['city']){
			$city_r = $linkage_db->get_one(array('linkageid'=>$_GET['city']), 'linkageid,name');
			$response[$city_r['linkageid']] = $city_r['name'];
		}else{
			$response[""] = "请选择";
		}
		foreach($city_arr as $_value) {
			$response[$_value['linkageid']] = $_value['name'];
		}
	
	}
	print json_encode($response);
	
}elseif($_GET['type']=='goods_search'){
	
	$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
	$goods_db = inc_base::load_model('goods_model');
	$goodslist = $goods_db->select("`title` LIKE '%".$keyword."%'", 'id,title');
	$response = '';
	$response .= '<select name="info[goods_id]" id="goods_id">';
	foreach($goodslist as $_value) {
		$response .= '<option value="'.$_value[id].'">'.$_value[title].'</option>';
	}
	$response .= '</select>';
	print $response;

}


?>