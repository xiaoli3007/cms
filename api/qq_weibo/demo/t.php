<?php 
ob_start();
require("../../api/global.php");

$randomnum=rand(0,9999);
$dest=date("Ymd",time()).'_'.$randomnum;
$file_path="uploadfile/".$dest.'.jpg';	
$value = 'http://app.qlogo.cn/mbloghead/a09a57cd7510f7151340/120';

//$filestr=file_get_contents($value);

/*@copy($value,LK_PATH.$file_path);
elseif($filestr=file_get_contents($value)){
	$ck=1;
	write_file(LK_PATH.$file_path,$filestr);
}*/


getImg($value, LK_PATH.$file_path);

function getImg($url = "", $filename = "") {

		$hander = curl_init();
		$fp = fopen($filename,'wb');

		curl_setopt($hander,CURLOPT_URL,$url);
		curl_setopt($hander,CURLOPT_FILE,$fp);
		curl_setopt($hander,CURLOPT_HEADER,0);
		curl_setopt($hander,CURLOPT_FOLLOWLOCATION,1);
		//curl_setopt($hander,CURLOPT_RETURNTRANSFER,false);//以数据流的方式返回数据,当为false是直接显示出来
		curl_setopt($hander,CURLOPT_TIMEOUT,60);
		curl_exec($hander);
		curl_close($hander);
		fclose($fp);
		return true;
}

echo "123123123";

/*	
if(@$file = fopen($file_path,"x+")) {
	if(@fwrite($file,$output)) {
	}else{
		die("写入数据流失败");
	}
	fclose($file);
}*/

echo "123123";
		
?>