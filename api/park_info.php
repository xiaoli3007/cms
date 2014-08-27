<?php


//实例化SOAP服务
$server = new SoapServer(null, //non-WSDL模式，不指定WSDL文件
                         array('uri' => 'http://192.168.1.188/cescvip/ziyuan'));
//注册提供外部调用的方法
$server->addFunction('hello');
$server->addFunction('queryParkList');
$server->addFunction('queryParkInfoById');
//可以注册方法，也可以注册类：
//$server->setClass("class name");   
$server->handle();


//注册方法的实现
function hello($name, $password)
{
	if ($password == 'lory' && $name == 'lory')
	{
		return 'Welcome lory, how are you?';
	}
	else {
		return 'Go away!!!';
	}
}


//查询所有停车场
function queryParkList($user, $password)				
{
	if ($user == 'park' && $password == 'PARKINGinfo168360')
	{
		
		$result_info='<?xml version="1.0" encoding="utf-8"?>';
		
		$result_info.=	'<results>
					<total>2</total>
					<ParkInfo>
							<parkId>42000000000000000001</parkId>
							<parkName>武汉市青少年宫地下停车场</parkName>
						</ParkInfo>
						<ParkInfo>
							<parkId>42000000000000000002</parkId>
							<parkName>协和医院地上停车场</parkName>
						</ParkInfo>
					</results>';

		
		return $result_info;
	}else{
		
		return 'error!!!';	
	}
	
}


//查询指定停车场
function queryParkInfoById($user, $password, $parkId)
{
	if ($user == 'park' && $password == 'PARKINGinfo168360' && $parkId )
	{
		$result_info='<?xml version="1.0" encoding="utf-8"?>';
		$result_info.='<results>
					<ParkInfo>
						<parkId>42000000000000000001</parkId>
						<parkName>武汉市青少年宫地下停车场</parkName>
						<address>江岸区解放大道1435号</address>
						<parkcoord_long> 114.2855319</parkcoord_long>
						<parkcoord_lat> 30.5886141</parkcoord_lat>
						<totalPark> 450</totalPark>
						<freePark>10</freePark>
						<parkIndex>4</parkIndex>
					</ParkInfo>
				</results>';
		
		return $result_info;

	}
	else {
		return 'error!!!';
	}
}

exit();




?>