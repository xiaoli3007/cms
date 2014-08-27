<?php
require dirname(__FILE__).DIRECTORY_SEPARATOR."admin_common.php";
if($_GET['dosubmit']=='1'){
	
	$attachment = inc_base::load_sys_class('attachment');
	$picurl = $attachment->upload('jUploaderFile','jpg|gif|png|flv|swf|bmp|asf|jpeg','10204');
	/*$webpic = $savefile=UPLOAD_URL.$picurl;
	$picurl_210=thumb($webpic, 210, '' ,0);			//截取缩略图新方法
	$picurl_210= str_replace(UPLOAD_URL, '', $picurl_210);	
	$picurldaxiao = $attachment->upload_daxiao('jUploaderFile');
	*/
	$response = array();
	
	if($picurl){
		$response["success"] = 1;
		$response["fileUrl"] = $picurl;
		//$response["file_size"] = $picurldaxiao['size'];
		//$response["file_type"] = '.'.$picurldaxiao['types'];
	}else{
		$response["success"] = 0;
	}

	print json_encode($response);
	
}elseif($_GET['dosubmit']=='2'){
	
	
	$attachment = inc_base::load_sys_class('attachment');

	$picurl = $attachment->upload('imgFile','jpg|gif|png|flv|bmp|jpeg','2048');
	
	$response = array();
	
	if($picurl){
		$response["error"] = 0;
		$response["url"] = UPLOAD_URL.$picurl;
	}else{
		$response["error"] = 1;
	}

	print json_encode($response);
	
	
}elseif($_GET['dosubmit']=='3'){			//影集上传
	
	$attachment = inc_base::load_sys_class('attachment');
	
	$picurl = $attachment->upload_photo('jUploaderFile','jpg|gif|png|flv|swf|bmp|asf|jpeg','20204');
	
	$webpic = $savefile=UPLOAD_URL.'photo/'.$picurl;
	
	$picurl_150=thumb($webpic, 150, '108',1,'',1 );			//截取缩略图新方法
	
	$picurl_150= str_replace(UPLOAD_URL.'photo/', '', $picurl_150);		
		
	$picurldaxiao = $attachment->upload_daxiao('jUploaderFile');
	
	$response = array();
	
	if($picurl){
		$response["success"] = 1;
		$response["fileUrl"] = $picurl;
		$response["fileUrl_150"] = $picurl_150;
		$response["file_size"] = $picurldaxiao['size'];
		$response["file_type"] = '.'.$picurldaxiao['types'];
	}else{
		$response["success"] = 0;
	}

	print json_encode($response);
	
}elseif($_GET['dosubmit']=='4'){			//excel上传
	
	$attachment = inc_base::load_sys_class('attachment');
	
	$picurl = $attachment->upload_excel('jUploaderFile','xls','20204');
	
	
	if($picurl){
		$response["success"] = 1;
		$response["fileUrl"] = $picurl;
	}else{
		$response["success"] = 0;
	}

	print json_encode($response);
	
}

?>